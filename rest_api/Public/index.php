<?php

header('Content-Type: application/json');

spl_autoload_register(function ($class) {

    $directories = [
        __DIR__ . '/../core/',
        __DIR__ . '/../controller/',
        __DIR__ . '/../repository/',
        __DIR__ . '/../database',
    ];

    foreach ($directories as $directory) {
        $file = $directory .'/'. $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$database = new Database();
$db = $database->getConnection();
$userRepository = new DatabaseUser($db);
$studentRepository = new DatabaseStudent($db);

$response = new Response();
$authMiddleware = new AuthMiddleware($userRepository, $response);

$router = new Router($authMiddleware);
$router->addRoute('POST', '/api/auth/login', [AuthController::class, 'login']);
$router->addRoute('POST', '/api/auth/logout', [AuthController::class, 'logout'], true, ['user']);
$router->addRoute('GET', '/api/auth/me', [AuthController::class, 'userSekarang'], true);

require_once __DIR__ . '/studentStorage.php';

//database mahasiswa
$router->addRoute('GET',
'/api/student',
[StudentController::class, 'getAllStudents'], true, ['superadmin']);

$router->addRoute('GET',
'/api/student/{id}',
[StudentController::class, 'getStudentById'], true, ['superadmin']);

$router->addRoute('POST',
'/api/student',
[StudentController::class, 'createStudent'], true, ['superadmin']);

$router->addRoute('PUT',
'/api/student/{id}',
[StudentController::class, 'updateStudent'], true, ['superadmin']);

$router->addRoute('DELETE',
'/api/student/{id}',
[StudentController::class, 'deleteStudent'], true, ['superadmin']);

$userController = new UserController($userRepository, $response);

//database user
$router->addRoute('GET',
'/api/users',
[UserController::class, 'getAllUsers'], true, ['superadmin']);

$router->addRoute('GET',
'/api/users/{id}',
[UserController::class, 'getUserById'], true, ['superadmin']);

$router->addRoute('POST',
'/api/users',
[UserController::class, 'createUser'], true, ['superadmin']);

$router->addRoute('PUT',
'/api/users/{id}',
[UserController::class, 'updateUser'], true, ['superadmin']);

$router->addRoute('DELETE',
'/api/users/{id}',
[UserController::class, 'deleteUser'], true, ['superadmin']);

$router->handleRequest();

error_reporting(E_ALL);
ini_set('display_errors', 1);