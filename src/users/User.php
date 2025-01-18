<?php
namespace Src\users;

abstract class User {
    protected $db;
    protected $username;
    protected $password;
    protected $email;
    protected $role;
    protected $table = 'users'; 

    public function __construct($db, $username, $password, $email, $role) {
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    public function register(){
    }

    public function login() {
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
