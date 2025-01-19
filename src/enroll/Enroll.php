<?php

namespace Src\enroll;

use PDO;
use PDOException;
use Exception;

class Enroll {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function addEnrollment($userId, $courseId) {
        try {
            $sql = "INSERT INTO enroll (user_id, cours_id) 
                    VALUES (:user_id, :cours_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':cours_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();

            return "Enrollment added successfully.";
        } catch (PDOException $e) {
            return "Error adding enrollment: " . $e->getMessage();
        }
    }

    public function deleteEnrollment($userId, $courseId) {
        try {
            $sql = "DELETE FROM enroll WHERE user_id = :user_id AND cours_id = :cours_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':cours_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Enrollment deleted successfully.";
            } else {
                return "No matching enrollment found to delete.";
            }
        } catch (PDOException $e) {
            return "Error deleting enrollment: " . $e->getMessage();
        }
    }
}
?>
