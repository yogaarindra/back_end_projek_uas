<?php
class AuthMiddleware {
    private $userRepository;
    private $response;

    public function __construct(DatabaseUser $userRepository, Response $response){
        $this->userRepository = $userRepository;
        $this->response = $response;
    }

    public function authenticate(Request $request){
        $authHeader = $request->getAuthHeader();

        if(empty($authHeader)){
            $this->response->send(401, ['pesan' => 'Token tidak tersedia']);
            return false;
        }

        list($type, $token) = explode(' ', $authHeader, 2);

        if(strtolower($type) !== 'bearer' || empty($token)){
            $this->response->send(401, ['pesan' => 'Token tidak valid']);
            return false;
        }

        $user = $this->userRepository->findByToken($token);

        if(!$user){
            $this->response->send(401, ['pesan' => 'Token tidak valid']);
            return false;
        }

        if(isset($user['expired_token']) && strtotime($user['expired_token']) < time()){
            $this->userRepository->clearToken($user['id']);
            $this->response->send(401, ['pesan' => 'token tidak berlaku']);
            return false;
        }

        $request->setUser($user);
        return true;
    }

    public function authorize($request, $requiredRole = 'user'){
        $user = $request->getUser();
        if(!$user){
            $this->response->send(403, ['pesan' => 'tidak ada pengguna yang terautentikasi']);
            return false;
        }

        if($requiredRole !== 'user' && $user['role'] !== $requiredRole){
            $this->response->send(403, ['pesan' => 'diperlukan akses' .$requiredRole]);
            return false;
        }

        if($requiredRole === 'superadmin' && $user['role'] !== 'superadmin'){
            $this->response->send(403, ['pesan' => 'diperlukan akses superadmin']);
            return false;
        }

        if($requiredRole === 'user' && $user['role'] !== 'user' && $user['role'] !== 'superadmin'){
            $this->response->send(403, ['pesan' => 'diperlukan akses user']);
            return false;
        }

        return true;
    }
}