<?php
class DatabaseStudent{
    private $conn;
    private $table_name = "mahasiswa";

    public function __construct($db){
        $this-> conn = $db;
    }

    public function getStudent(){
        $query = "SELECT id, nama, prodi FROM ". $this->table_name. " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $query = "SELECT id, nama, prodi FROM ". $this->table_name. " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $prodi){
        $query = "INSERT INTO ". $this->table_name. " (nama, prodi) VALUES (:nama, :prodi)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama", $name);
        $stmt->bindParam(":prodi", $prodi);
        if($stmt->execute()){
            return $this->conn->lastInsertID();
        }
        return false;
    }

    public function update($id, $name = null, $prodi = null){
        $query_parts = [];
        $params = [':id' => htmlspecialchars(strip_tags($id))];

        if($name !== null){
            $query_parts[] = "nama = :nama";
            $params[':nama'] = htmlspecialchars(strip_tags($name));
        }

        if($prodi !== null){
            $query_parts[] = "prodi = :prodi";
            $params[':prodi'] = htmlspecialchars(strip_tags($prodi));
        }

        if(empty($query_parts)){
            return 0;
        }

        $query = "UPDATE ". $this->table_name. " SET ". implode(", ", $query_parts). " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        foreach($params as $key => $val){
            $stmt->bindValue($key, $val);
        }

        if($stmt->execute()){
            return $stmt->rowCount();
        }
        return false;
    }

    public function delete($id){
        $query = "DELETE FROM ". $this->table_name. " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        return false;
    }
}