<?php

namespace Src\users;

use Src\users\User;
use PDO;
use PDOException;

class Enseignant extends User {
    private $profile_picture_url;

    public function __construct($db, $username, $password, $email, $profile_picture_url) {
        parent::__construct($db, $username, $password, $email, 'enseignant');
        $this->profile_picture_url = $profile_picture_url;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register() {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password_hash, activation, role, profile_picture_url) 
                VALUES (:username, :email, :password_hash, 'pending', 'enseignant', :profile_picture_url)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':email' => $this->email,
                ':password_hash' => $hashed_password,
                ':profile_picture_url' => $this->profile_picture_url,
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error during registration: " . $e->getMessage());
            return false;
        }
    }

    public function login() {
        $sql = "SELECT * FROM users WHERE (username = :username OR email = :email) AND role = 'enseignant'";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $this->username, ':email' => $this->email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'activation' => $user['activation'],
                    'profile_picture_url' => $user['profile_picture_url']
                ];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error during login: " . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        parent::logout();
        return true;
    }
}

?>
