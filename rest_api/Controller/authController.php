<?php
    class AuthController{
        private $userRepository;
        private $response;

        public function __construct(DatabaseUser $userRepository, Response $response){
            $this->userRepository = $userRepository;
            $this->response = $response;
        }

        public function login(Request $request){
            $data = $request->getBody();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            if(empty($username) || empty($password)){
                $this->response->send(400, ['pesan' => 'username dan password perlu diisi']);
                return;
            }

            $user = $this->userRepository->findByUsername($username);

            if(!$user || !password_verify($password, $user['password'])){
                $this->response->send(401, ['pesan' => 'Kredensial tidak valid']);
                return;
            }

            $token = bin2hex(random_bytes(32));
            $expiresAt = date('y-m-d H:i:s', strtotime('+2 hour'));

            if($this->userRepository->updateToken($user['id'], $token, $expiresAt)){
                $this->response->send(200,
                ['pesan' =>'Login berhasil!',
                'token' => $token,
                'expires_at' => $expiresAt,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]]);
            }else{
                $this->response->send(500, ['pesan' => 'Tidak dapat membuat token']);
            }
        }

        public function logout(Request $request){
            $user = $request->getUser();

            if($user && $this->userRepository->clearToken($user['id'])){
                $this->response->send(200, ['pesan' => 'Logout berhasil!']);
            }else{
                $this->response->send(401, ['pesan' => 'Tidak dapat logout!']);
            }
        }

        public function userSekarang(Request $request){
            $user = $request->getUser();
            if($user){
                $this->response->send(200,
                ['id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]);
            }else{
                $this->response->send(401, ['pesan' => 'Tidak ada pengguna yang terautentikasi']);
            }
        }
    }