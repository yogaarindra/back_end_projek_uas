<?php

class Request {

    private $queryParams = [];
    private $body;
    private $user;

    public function __construct($params = []) {

        $this->body = json_decode(file_get_contents('php://input'), true) ?? []; ;
        $this->queryParams = $params;
    }

    public function getBody() {
        return $this->body;
    }

    public function getQueryParams() {
        return $this->queryParams;
    }

    public function getAuthHeader(){
        $headers = getallheaders();
        return $headers['Authorization'] ?? null;
    }

    public function setUser($user){
        $this->user = $user;
    }
    public function getUser(){
        return $this->user;
    }

}