<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\enroll\Enroll;

if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in to enroll.");
}

$userId = $_SESSION['user']['id'];

// Check for the course ID from GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $courseId = (int)$_GET['id'];
} else {
    die("Invalid course ID.");
}

$database = new Database("youdemy");
$db = $database->getConnection();

$enroll = new Enroll($db);

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $response = $enroll->deleteEnrollment($userId, $courseId);
} else {
    $response = $enroll->addEnrollment($userId, $courseId);
}

// Output the response and redirect
echo $response;
header("Location: ../../public/front_office/my_courses.php?id=$courseId");
exit;
?>
