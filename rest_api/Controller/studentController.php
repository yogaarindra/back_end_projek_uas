<?php
    class StudentController {
        private $studentRepository;
        private $response;

        public function __construct(DatabaseStudent $studentRepository, Response $response) {
            $this->studentRepository = $studentRepository;
            $this->response = $response;
        }

        public function getAllStudents(Request $request, Response $response) {
            $students = $this->studentRepository->getStudent();
            $response->send(200, $students);
        }

        public function getStudentById(Request $request,
        Response $response, $params) {
            $id = $params['id'] ?? null;
            if(!$id){
                $response->send(400, ['pesan' => 'ID Mahasiswa perlu diisi!']);
                return;
            }
            $student = $this->studentRepository->getById($id);
            if($student){
                $response->send(200,$student);
            }else{
                $response->send(404, ['message' => "Mahasiswa tidak ditemukan!"]);
            }
        }

        public function createStudent(Request $request,
        Response $response) {
            $data = $request->getBody();
            $name = $data['name'] ?? null;
            $prodi = $data['prodi'] ?? null;

            if(empty($name)){
                $response->send(400, ['message' => 'Nama mahasiswa perlu diisi!']);
                return;
            }

            if(empty($prodi)){
                $response->send(400, ['message' => 'Nama prodi perlu diisi!']);
                return;
            }

            $newStudentId = $this->studentRepository->create($name, $prodi);
            if($newStudentId){
                $response->send(200,
            ['pesan' => 'Data Mahasiswa telah berhasil dibuat', 'id' => $newStudentId]);
            }else{
                $response->send(500, ['pesan' => 'Gagal memuat data mahasiswa!']);
            }
        }

        public function updateStudent(Request $request, Response $response, $params) {
            $data = $request->getBody();
            $id = $params['id'] ?? null;
            $name = $data['name'] ?? null;
            $prodi = $data['prodi'] ?? null;

            if (!$id || empty($data)) {
                $response->send(400, ['pesan' => 'Invalid request: kedua data perlu diisi!']);
                return $response;
            }

            if(empty($name) && empty($prodi)){
                $response->send(400, ['pesan' => 'Nama atau Prodi mahasiswa perlu diisi!']);
                return;
            }

            $updatedRows = $this->studentRepository->update($id, $name, $prodi);
            if($updatedRows > 0){
                $response->send(200, ['pesan' => 'Data mahasiswa berhasil diperbarui!']);
            }else{
                $response->send(404,['pesan' => 'Data tidak ditemukan atau tidak ada perubahan!']);
            }
        }

        public function deleteStudent(Request $request, Response $response, $params) {
            $id = $params['id'] ?? null;
            if(!$id){
                $response->send(400, ['pesan' => 'ID Mahasiswa diperlukan!']);
                return;
            }
            $deletedRows = $this->studentRepository->delete($id);
            if($deletedRows > 0){
                $response->send(200,['message' => 'Data mahasiswa telah dihapus']);
            }else{
                $response->send(404,['message' => 'Data mahasiswa tidak ditemukan!']);
            }
        }
    }
?>