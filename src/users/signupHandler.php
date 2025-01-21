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

    $errors = [];

    // Validation des champs
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    if (empty($profile_picture_url)) {
        $errors['profile_picture_url'] = "Profile picture URL is required.";
    } elseif (!filter_var($profile_picture_url, FILTER_VALIDATE_URL)) {
        $errors['profile_picture_url'] = "Invalid URL format.";
    }

    if (empty($role)) {
        $errors['role'] = "Role selection is required.";
    } elseif (!in_array($role, ['etudiant', 'enseignant'])) {
        $errors['role'] = "Invalid role selected.";
    }

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST; 
        header("Location: ../../public/front_office/signup.php");
        exit;
    }

    try {
        if ($role === 'etudiant') {
            $user = new Etudiant($db, $username, $password, $email, $profile_picture_url);
        } elseif ($role === 'enseignant') {
            $user = new Enseignant($db, $username, $password, $email, $profile_picture_url);
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
