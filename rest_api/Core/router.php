<?php

    class Router{
        private $routes = [];
        private $authMiddleware;

        public function __construct($authMiddleware){
            $this->authMiddleware = $authMiddleware;
        }

        public function addRoute($method, $path, $callback, $authRequired = false, $roles = ['user']) {
            $this->routes[] = [
                'method' => strtoupper($method),
                'path' => $path,
                'callback' => $callback,
                'authRequired' => $authRequired,
                'roles' => $roles
            ];
        }

        public function handleRequest(){
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];
            $path = parse_url($uri, PHP_URL_PATH);
            $basepath = dirname($_SERVER['SCRIPT_NAME']);
            $response = new Response();

            error_log("DEBUG: REQUEST_URI = ". $uri);
            error_log("DEBUG: SCRIPT_NAME = ". $_SERVER['SERVER_NAME']);
            error_log("DEBUG: Basepath = ". $basepath);

            if(strpos($path, $basepath) === 0){
                $path = substr($path, strlen($basepath));
            }

            if(strpos($path, '/index.php') === 0){
                $path = substr($path, strlen('/index.php'));
            }

            if(empty($path) || $path[0] !== '/'){
                $path = '/'. $path;
            }

            error_log("DEBUG: Final Path for matching = ". $path);
            error_log("DEBUG: Method = ". $method);

            foreach ($this->routes as $route) {
               if($this->matchRoute($route, $path, $method)) {
                    $params = $this->getParams($route, $path);
                    $request = new Request($params);

                    if($route['authRequired']){
                        if(!$this->authMiddleware->authenticate($request)){
                            return;
                        }

                        if(!empty($route['roles']) && !$this->authMiddleware->authorize($request, $route['roles'][0])){
                            return;
                        }
                    }

                    try{
                        $callback = $route['callback'];

                        if(is_array($callback) && count($callback) >= 2){
                            $controllerName = $callback[0];
                            $handlerName = $callback[1];

                            $database = new Database();
                            $db = $database->getConnection();

                            $reflectionClass = new ReflectionClass($controllerName);
                            $constructor = $reflectionClass->getConstructor();
                            $controller = null;

                            if($constructor){
                                $parameters = $constructor->getParameters();
                                $args = [];
                                foreach($parameters as $param){
                                    $paramType = $param->getType();
                                    if($paramType && !$paramType->isBuiltin()){
                                        $paramClassName = $paramType->getName();
                                        if($paramClassName === 'DatabaseStudent'){
                                            $args[] = new DatabaseStudent($db);
                                        }elseif($paramClassName === 'DatabaseUser'){
                                            $args[] = new DatabaseUser($db);
                                        }elseif($paramClassName === 'Response'){
                                            $args[] = $response;
                                        }
                                    }
                                }
                                $controller = $reflectionClass->newInstanceArgs($args);
                            }else{
                                $controller = new $controllerName();
                            }

                            if($controller && method_exists($controller, $handlerName)){
                                return $controller->$handlerName($request, $response, $params);
                            }else{
                                $response->send(404, ['message' => 'Handler tidak ditemukan']);
                                return $response;
                            }
                        }elseif(is_callable($callback)){
                            return call_user_func_array($callback, [$request, $response, $params]);
                        }else{
                            $response->send(500, ['pesan' => 'Callback tidak valid!']);
                            return $response;
                        }
                    }catch(Exception $e){
                        $response->send(500, ['pesan' => 'Internal Server Error: '. $e->getMessage()]);
                        return $response;
                    }
                }
            }
            $response->send(404, ['message' => 'Rute tidak dapat ditemukan']);
            return $response;
        }

        public function matchRoute($route, $path, $method): bool{
            if( $route['method'] !== $method) {
                return false;
            }

            $routePath = $route['path'];

            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);

            $pattern = '#^' . $pattern . '$#';

            return preg_match($pattern, $path, $matches);
        }

        public function getParams($route, $path): array {
            $params = [];
            preg_match_all('/\{([^}]+)\}/', $route['path'], $paramNames);
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            preg_match($pattern, $path, $matches);
            array_shift($matches);
            for( $i = 0; $i < count($paramNames[1]); $i++) {
                $params[$paramNames[1][$i]] = $matches[$i] ?? null;
            }

            return $params;
        }
    }

?>