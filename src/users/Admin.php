<?php
namespace Src\users;
use Src\users\User;
use PDO;

class Admin extends User {
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function updateActivationStatus($userId, $status)
    {
        $sql = "UPDATE users SET activation = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateUserRole($userId, $role)
    {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUser($userId)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function loginAdmin($email, $password) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'profile_picture_url' => $user['profile_picture_url']
                ];

                return true;

            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function logout() {
        parent::logout();
        return true;
    }

}

?>