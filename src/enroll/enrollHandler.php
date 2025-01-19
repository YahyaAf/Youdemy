<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\enroll\Enroll;

if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in to enroll.");
}

$userId = $_SESSION['user']['id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $courseId = (int)$_GET['id'];
} else {
    die("Invalid course ID.");
}

$database = new Database("youdemy");
$db = $database->getConnection();

$enroll = new Enroll($db);

$response = $enroll->addEnrollment($userId, $courseId);

echo $response;

header("Location: ../../public/front_office/detailcours.php?id=$courseId");
exit;
?>
