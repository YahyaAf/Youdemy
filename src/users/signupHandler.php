<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\Enseignant;
use Src\users\Etudiant;

$database = new Database("youdemy");
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $profile_picture_url = trim($_POST['profile_picture_url']);
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($password) || empty($profile_picture_url) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: signup.php");
        exit;
    }

    try {
        if ($role === 'etudiant') {
            $user = new Etudiant($db, $username, $password, $email, $profile_picture_url);
        } elseif ($role === 'enseignant') {
            $user = new Enseignant($db, $username, $password, $email, $profile_picture_url);
        } else {
            $_SESSION['error'] = "Invalid role selected.";
            header("Location: ../../public/front_office/signup.php");
            exit;
        }

        if ($user->register()) {
            $_SESSION['success'] = "Account created successfully. Please log in.";
            header("Location: ../../public/front_office/login.php");
            exit;
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: ../../public/front_office/signup.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: ../../public/front_office/signup.php");
        exit;
    }
} else {
    header("Location: signup.php");
    exit;
}
