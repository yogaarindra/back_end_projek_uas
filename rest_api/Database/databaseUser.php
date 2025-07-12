<?php
class DatabaseUser{
    private $conn;
    private $table_name = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    public function findByUsername($username){
        $query = "SELECT id, username, password, role, auth_token, expired_token FROM ". $this->table_name. " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByToken($token){
        $query = "SELECT id, username, role, auth_token, expired_token FROM ". $this->table_name. " WHERE auth_token = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateToken($userID, $token, $expiresAt){
        $query = "UPDATE ". $this->table_name. " SET auth_token = :auth_token, expired_token = :expired_token WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":auth_token", $token);
        $stmt->bindParam(":expired_token", $expiresAt);
        $stmt->bindParam(":id", $userID);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function clearToken($userID){
        $query = "UPDATE ". $this->table_name. " SET auth_token = NULL, expired_token = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $userID);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getAllUsers(){
        $query = "SELECT id, username, role FROM ".  $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id){
        $query = "SELECT id, username, role FROM ".  $this->table_name. " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function create($username, $password, $role){
        $query = "INSERT INTO ". $this->table_name. " (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $hashed_password);
        $stmt->bindParam(3, $role);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function update($id, $username, $password, $role){
        $query = "UPDATE ". $this->table_name. " SET username = ?, password = ?, role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $hashed_password);
        $stmt->bindParam(3, $role);
        $stmt->bindParam(4, $id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function delete($id){
        $query = "DELETE FROM ". $this->table_name. " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}