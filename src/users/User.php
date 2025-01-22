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

    abstract public function logout();

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

    public function update($id, $username, $email, $profile_picture_url) {
        try {
            $sql = "UPDATE users
                SET username = :username, email = :email, profile_picture_url = :profile_picture_url
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':profile_picture_url', $profile_picture_url);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        return isset($_SESSION['user']);
    }
}
