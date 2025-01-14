<?php

namespace Src\courses;

use PDO;
use PDOException;
use Exception;

class Cours {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO cours 
                (title, description, contenu, featured_image, category_id, enseignant_id, scheduled_date, created_at, updated_at)
                VALUES (:title, :description, :contenu, :featured_image, :category_id, :enseignant_id, :scheduled_date, NOW(), NOW())
            ");
            $stmt->execute([
                'title' => $data['title'],
                'description' => $data['description'],
                'contenu' => $data['contenu'], 
                'featured_image' => $data['featured_image'],
                'category_id' => $data['category_id'],
                'enseignant_id' => $data['enseignant_id'],
                'scheduled_date' => $data['scheduled_date']
            ]);
    
            $courseId = $this->pdo->lastInsertId();
    
            if (!empty($data['tags'])) {
                $this->addTags($courseId, $data['tags']);
            }
    
            return $courseId;
        } catch (PDOException $e) {
            echo "Error creating course: " . $e->getMessage();
            return false;
        }
    }
    
    
    public function readAll() {
        try {
            $stmt = $this->pdo->query("
                SELECT c.*, 
                    ca.name AS category_name, 
                    u.username AS enseignant_name, 
                    GROUP_CONCAT(t.name) AS tags
                FROM cours c
                LEFT JOIN categories ca ON c.category_id = ca.id
                LEFT JOIN users u ON c.enseignant_id = u.id
                LEFT JOIN cours_tags ct ON c.id = ct.cours_id
                LEFT JOIN tags t ON ct.tag_id = t.id
                GROUP BY c.id
                ORDER BY c.created_at DESC
            ");
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching courses: " . $e->getMessage());
            return [];
        }
    }
    

    // public function read($id) {
    //     try {
    //         $stmt = $this->pdo->prepare("
    //             SELECT 
    //                 c.*, 
    //                 ca.name AS category_name, 
    //                 u.username AS enseignant_name, 
    //                 GROUP_CONCAT(t.name) AS tags
    //             FROM cours c
    //             LEFT JOIN categories ca ON c.category_id = ca.id
    //             LEFT JOIN users u ON c.enseignant_id = u.id
    //             LEFT JOIN cours_tags ct ON c.id = ct.cours_id
    //             LEFT JOIN tags t ON ct.tag_id = t.id
    //             WHERE c.id = :id
    //             GROUP BY c.id
    //         ");
    //         $stmt->execute(['id' => $id]);
    //         $course = $stmt->fetch(PDO::FETCH_ASSOC);

    //         return $course ?: null; 
    //     } catch (PDOException $e) {
    //         error_log("Error fetching course: " . $e->getMessage());
    //         return null;
    //     }
    // }

    // public function update($id, $data) {
    //     try {
    //         if (empty($data['title']) || empty($data['content']) || empty($data['category_id'])) {
    //             throw new Exception("Missing required fields.");
    //         }

    //         $stmt = $this->pdo->prepare("
    //             UPDATE cours
    //             SET title = :title, description = :description, content = :content, content_type = :content_type, featured_image = :featured_image, 
    //                 status = :status, category_id = :category_id, updated_at = NOW()
    //             WHERE id = :id
    //         ");
    //         $stmt->execute([
    //             'id' => $id,
    //             'title' => $data['title'],
    //             'description' => $data['description'], 
    //             'content' => $data['content'],
    //             'content_type' => $data['content_type'],
    //             'featured_image' => $data['featured_image'],
    //             'status' => $data['status'],
    //             'category_id' => $data['category_id']
    //         ]);

    //         $this->updateTags($id, $data['tags']);

    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Error updating course: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log($e->getMessage());
    //         return false;
    //     }
    // }

    // public function delete($id) {
    //     try {
    //         $this->removeTags($id);

    //         $stmt = $this->pdo->prepare("DELETE FROM cours WHERE id = :id");
    //         $stmt->execute(['id' => $id]);

    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Error deleting course: " . $e->getMessage());
    //         return false;
    //     }
    // }

    private function addTags($courseId, $tags) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO cours_tags (cours_id, tag_id)
                VALUES (:cours_id, :tag_id)
            ");
            foreach ($tags as $tagId) {
                $stmt->execute(['cours_id' => $courseId, 'tag_id' => $tagId]);
            }
        } catch (PDOException $e) {
            error_log("Error adding tags: " . $e->getMessage());
        }
    }

    private function updateTags($courseId, $tags) {
        $this->removeTags($courseId);
        $this->addTags($courseId, $tags);
    }

    private function removeTags($courseId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cours_tags WHERE cours_id = :cours_id");
            $stmt->execute(['cours_id' => $courseId]);
        } catch (PDOException $e) {
            error_log("Error removing tags: " . $e->getMessage());
        }
    }

    // public function countCourses() {
    //     try {
    //         $stmt = $this->pdo->query("SELECT COUNT(*) AS cours_count FROM cours");
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $result['cours_count'];
    //     } catch (PDOException $e) {
    //         error_log("Error counting courses: " . $e->getMessage());
    //         return 0;
    //     }
    // }

    // public function search($query) {
    //     try {
    //         $stmt = $this->pdo->prepare("
    //             SELECT 
    //                 c.*, 
    //                 ca.name AS category_name, 
    //                 u.username AS enseignant_name, 
    //                 GROUP_CONCAT(t.name) AS tags
    //             FROM cours c
    //             LEFT JOIN categories ca ON c.category_id = ca.id
    //             LEFT JOIN users u ON c.enseignant_id = u.id
    //             LEFT JOIN cours_tags ct ON c.id = ct.cours_id
    //             LEFT JOIN tags t ON ct.tag_id = t.id
    //             WHERE c.title LIKE :query
    //                OR c.content LIKE :query
    //                OR t.name LIKE :query
    //             GROUP BY c.id
    //         ");
    //         $stmt->execute(['query' => '%' . $query . '%']);
    //         $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         return $courses ?: [];
    //     } catch (PDOException $e) {
    //         error_log("Error searching courses: " . $e->getMessage());
    //         return [];
    //     }
    // }
}
