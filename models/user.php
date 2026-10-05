<?php
class User {
    private $id;
    private string $username;
    private string $email = ""; 
    private string $password = "";
    private int $state = 0;

    public function __construct($id, string $username, string $password = "")
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->state = 1;
    }

    public function getUserName() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getId() { return $this->id; }
    public function getState() { return $this->state; }

    public function setUsername(string $username) {
        $this->username = $username;
        return $this->username;
    }
    public function setEmail(string $email) {
        $this->email = $email;
        return $this->email;
    }
    public function setPassword(string $password) {
        $this->password = $password;
        return $this->password;
    }
} 
?>