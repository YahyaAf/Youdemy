<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\courses\Cours;

$database = new Database("youdemy");
$db = $database->getConnection();

$course = new Cours($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['title'], $_POST['contenu'], $_POST['categorie'], $_POST['description'], $_POST['scheduled_date']) &&
        !empty($_POST['title']) &&
        !empty($_POST['contenu']) &&
        !empty($_POST['categorie']) &&
        !empty($_POST['description']) &&
        !empty($_POST['scheduled_date'])
    ) {
        $title = htmlspecialchars(strip_tags($_POST['title']));
        $contenu = htmlspecialchars(strip_tags($_POST['contenu'])); 
        $description = htmlspecialchars(strip_tags($_POST['description']));
        
        $featured_image = isset($_POST['featured_image']) ? htmlspecialchars(strip_tags($_POST['featured_image'])) : null;
        $scheduled_date = htmlspecialchars(strip_tags($_POST['scheduled_date'])); 
        
        $category_id = intval(htmlspecialchars(strip_tags($_POST['categorie'])));
        $enseignant_id = isset($_POST['enseignant_id']) ? intval($_POST['enseignant_id']) : null;

        $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

        $data = [
            'title' => $title,
            'contenu' => $contenu,
            'description' => $description,
            'featured_image' => $featured_image,
            'category_id' => $category_id,
            'enseignant_id' => $enseignant_id,
            'scheduled_date' => $scheduled_date, 
            'tags' => $tags 
        ];

        if ($course->create($data)) {
            header("Location: ../../public/front_office/add_cours.php");
            exit;
        } else {
            echo "Failed to create course. Please check your input and try again.";
            echo "<pre>";
            var_dump($data); 
            echo "</pre>";
        }
    } else {
        echo "All required fields must be filled. Please check your input.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}




// Delete a course 
// if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
//     $courseId = $_GET['id'];

//     if ($course->delete($courseId)) {
//         header("Location: ../../public/pages/course.php"); 
//     } else {
//         echo "Failed to delete the course.";
//     }
// } 

// else {
//     echo "Invalid request method.";
// }
