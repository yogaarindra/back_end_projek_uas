<?php

class UserController{
    private $userRepository;
    private $response;

    public function __construct(DatabaseUser $userRepository, Response $response){
        $this->userRepository = $userRepository;
        $this->response = $response;
    }

    public function getAllUsers(Request $request, Response $response){
        $users = $this->userRepository->getAllUsers();
        $response->send(200, $users);
    }

    public function getUserById(Request $request, Response $response, $params){
        $id = $params['id'] ?? null;
        if(!$id){
            $response->send(400, ['pesan' => "ID pengguna diperlukan"]);
            return;
        }

        $user = $this->userRepository->getUserById($id);
        if($user){
            $response->send(200, $user);
        }else{
            $response->send(404, ['pesan' => 'Pengguna tidak ditemukan']);
        }
    }

    public function createUser(Request $request, Response $response){
        $data = $request->getBody();
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $role = $data['role'] ?? 'user';

        if(empty($username) || empty($password)){
            $response->send(400, ['pesan' => "Username dan password diperlukan"]);
            return;
        }

        if($this->userRepository->findByUsername($username)){
            $response->send(409, ['pesan' => 'Username sudah ada']);
            return;
        }

        if($this->userRepository->create($username, $password, $role)){
            $response->send(201, ['pesan' => 'Pengguna berhasil ditambahkan']);
        }else{
            $response->send(500, ['pesan' => 'Gagal menambahkan pengguna']);
        }
    }

    public function updateUser(Request $request, Response $response, $params){
        $id = $params['id'] ?? null;
        if(!$id){
            $response->send(400, ['pesan' => 'ID pengguna diperlukan']);
            return;
        }

        $data = $request->getBody();
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        $role = $data['role'] ?? null;

        $userAda = $this->userRepository->getUserById($id);
        if(!$userAda){
            $response->send(404, ['pesan' => 'Pengguna tidak ditemukan']);
            return;
        }

        $username = $username ?? $userAda['username'];
        $password = $password ? $password : $userAda['password'];
        $role = $role ?? $userAda['role'];

        if($username !== $userAda['username'] && $this->userRepository->findByUsername($username)){
            $response->send(409, ['pesan' => 'Username sudah digunakan oleh pengguna lain']);
            return;
        }

        if($this->userRepository->update($id, $username, $password, $role)){
            $response->send(200, ['pesan' => 'Pengguna berhasil diperbarui']);
        }else{
            $response->send(500, ['pesan' => 'Gagal memperbarui pengguna']);
        }
    }

    public function deleteUser(Request $request, Response $response, $params){
        $id = $params['id'] ?? null;
        if(!$id){
            $response->send(400, ['pesan' => 'ID pengguna diperlukan']);
            return;
        }

        if($this->userRepository->delete($id)){
            $response->send(200, ['pesan' => 'Pengguna berhasil dihapus']);
        }else{
            $response->send(500, ['pesan' => 'Gagal menghapus pengguna']);
        }
    }
}