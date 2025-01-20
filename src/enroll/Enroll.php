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

    public function readAll($id) {
        try {
            $sql = "
                SELECT 
                    e.id AS enrollment_id, 
                    e.user_id, 
                    e.cours_id, 
                    e.created_at AS enrollment_created_at,
                    c.title AS course_title,
                    c.description AS course_description,
                    c.scheduled_date AS course_scheduled_date,
                    c.featured_image AS course_featured_image,
                    cat.name AS category_name
                FROM enroll e
                JOIN cours c ON e.cours_id = c.id
                JOIN categories cat ON c.category_id = cat.id
                WHERE e.user_id = :user_id
                ORDER BY e.created_at DESC
            ";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $enrollments;
    
        } catch (PDOException $e) {
            return "Error fetching enrollments: " . $e->getMessage();
        }
    }

    public function isAlreadyEnrolled($userId, $courseId) {
        try {
            $sql = "SELECT COUNT(*) FROM enroll WHERE user_id = :user_id AND cours_id = :cours_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':cours_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();
    
            $enrollmentCount = $stmt->fetchColumn();
            return $enrollmentCount > 0; 
        } catch (PDOException $e) {
            throw new Exception("Error checking enrollment: " . $e->getMessage());
        }
    }
    
}
?>
