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

    public function create_by_document($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO cours 
                (title, description, contenu, featured_image, category_id, enseignant_id, scheduled_date, created_at, updated_at, contenu_document, contenu_video)
                VALUES (:title, :description, :contenu, :featured_image, :category_id, :enseignant_id, :scheduled_date, NOW(), NOW(), :contenu_document, NULL)
            ");
            $stmt->execute([
                'title' => $data['title'],
                'description' => $data['description'],
                'contenu' => 'document',
                'featured_image' => $data['featured_image'],
                'category_id' => $data['category_id'],
                'enseignant_id' => $data['enseignant_id'],
                'scheduled_date' => $data['scheduled_date'],
                'contenu_document' => $data['contenu_document'],
            ]);
    
            $courseId = $this->pdo->lastInsertId();
    
            if (!empty($data['tags'])) {
                $this->addTags($courseId, $data['tags']);
            }
    
            return $courseId;
        } catch (PDOException $e) {
            echo "Error creating course (document): " . $e->getMessage();
            return false;
        }
    }
    
    public function create_by_video($data, $type) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO cours 
                (title, description, contenu, featured_image, category_id, enseignant_id, scheduled_date, created_at, updated_at, contenu_document, contenu_video)
                VALUES (:title, :description, :contenu, :featured_image, :category_id, :enseignant_id, :scheduled_date, NOW(), NOW(), NULL, :contenu_video)
            ");
            $stmt->execute([
                'title' => $data['title'],
                'description' => $data['description'],
                'contenu' => $type,
                'featured_image' => $data['featured_image'],
                'category_id' => $data['category_id'],
                'enseignant_id' => $data['enseignant_id'],
                'scheduled_date' => $data['scheduled_date'],
                'contenu_video' => $data['contenu_video'],
            ]);
    
            $courseId = $this->pdo->lastInsertId();
    
            if (!empty($data['tags'])) {
                $this->addTags($courseId, $data['tags']);
            }
    
            return $courseId;
        } catch (PDOException $e) {
            echo "Error creating course (video): " . $e->getMessage();
            return false;
        }
    }
    
    public function __call($name, $args) {
        if ($name === "create") {
            if (count($args) === 1) {
                return $this->create_by_document($args[0]);
            } elseif (count($args) === 2) {
                return $this->create_by_video($args[0], $args[1]);
            } else {
                throw new Exception("Invalid number of arguments for create method.");
            }
        } elseif ($name === "readAll") {
            if (count($args) === 0) {
                return $this->readAll_by_document();
            } elseif (count($args) === 1) {
                return $this->readAll_by_video($args[0]);
            } else {
                throw new Exception("Invalid number of arguments for readAll method.");
            }
        }
    }
    
    public function readAll_by_document() {
        try {
            $stmt = $this->pdo->query("
                SELECT c.*, 
                    ca.name AS category_name, 
                    u.username AS enseignant_name, 
                    GROUP_CONCAT(t.name) AS tags,
                    DATE(c.scheduled_date) AS scheduled_date_only
                FROM cours c
                LEFT JOIN categories ca ON c.category_id = ca.id
                LEFT JOIN users u ON c.enseignant_id = u.id
                LEFT JOIN cours_tags ct ON c.id = ct.cours_id
                LEFT JOIN tags t ON ct.tag_id = t.id
                WHERE (c.contenu_document IS NOT NULL AND c.contenu_document != '') 
                  AND (c.contenu_video IS NULL OR c.contenu_video = '')
                GROUP BY c.id
                ORDER BY c.created_at DESC
            ");
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching document-based courses: " . $e->getMessage());
            return [];
        }
    }
    
    
    
    public function readAll_by_video($type) {
        try {
            $stmt = $this->pdo->query("
                SELECT c.*, 
                    ca.name AS category_name, 
                    u.username AS enseignant_name, 
                    GROUP_CONCAT(t.name) AS tags,
                    DATE(c.scheduled_date) AS scheduled_date_only
                FROM cours c
                LEFT JOIN categories ca ON c.category_id = ca.id
                LEFT JOIN users u ON c.enseignant_id = u.id
                LEFT JOIN cours_tags ct ON c.id = ct.cours_id
                LEFT JOIN tags t ON ct.tag_id = t.id
                WHERE (c.contenu_video IS NOT NULL AND c.contenu_video != '') 
                  AND (c.contenu_document IS NULL OR c.contenu_document = '')
                GROUP BY c.id
                ORDER BY c.created_at DESC
            ");
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching video-based courses: " . $e->getMessage());
            return [];
        }
    }

    public function read($id) {
        try {
            $stmt = $this->pdo->query("
                SELECT c.*, 
                    ca.name AS category_name, 
                    u.username AS enseignant_name, 
                    GROUP_CONCAT(t.name) AS tags,
                    DATE(c.scheduled_date) AS scheduled_date_only
                FROM cours c
                LEFT JOIN categories ca ON c.category_id = ca.id
                LEFT JOIN users u ON c.enseignant_id = u.id
                LEFT JOIN cours_tags ct ON c.id = ct.cours_id
                LEFT JOIN tags t ON ct.tag_id = t.id
                WHERE c.id = $id
                GROUP BY c.id
                ORDER BY c.created_at DESC
            ");
            
            $stmt->execute();
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
            return $course ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching document-based courses: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $data) {
        try {
            if (empty($data['title']) || empty($data['contenu']) || empty($data['category_id'])) {
                throw new Exception("Missing required fields.");
            }
    
            $stmt = $this->pdo->prepare("
                UPDATE cours
                SET title = :title, description = :description, contenu = :contenu, featured_image = :featured_image, 
                    category_id = :category_id, scheduled_date = :scheduled_date, contenu_video = :contenu_video, 
                    contenu_document = :contenu_document, updated_at = NOW()
                WHERE id = :id
            ");
    
            $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'description' => $data['description'],
                'contenu' => $data['contenu'],
                'featured_image' => $data['featured_image'],
                'category_id' => $data['category_id'],
                'scheduled_date' => $data['scheduled_date'],
                'contenu_video' => $data['contenu_video'],
                'contenu_document' => $data['contenu_document']
            ]);
    
            $this->updateTags($id, $data['tags']);
            return true;
        } catch (PDOException $e) {
            error_log("PDO Error: " . $e->getMessage());
            echo "Error updating course: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo $e->getMessage();
            return false;
        }
    }
    
    

    public function delete($id) {
        try {
            $this->removeTags($id);

            $stmt = $this->pdo->prepare("DELETE FROM cours WHERE id = :id");
            $stmt->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log("Error deleting course: " . $e->getMessage());
            return false;
        }
    }

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

    public function updateStatusCours($userId, $status)
    {
        $sql = "UPDATE cours SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
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
