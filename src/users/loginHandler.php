<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\Enseignant;
use Src\users\Etudiant;
use Src\users\Admin;

$database = new Database("youdemy");
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Both fields are required.";
        header("Location: ../../public/front_office/login.php");
        exit;
    }

    try {
        $sql = "SELECT * FROM users WHERE (username = :username_or_email OR email = :username_or_email) LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([':username_or_email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['role'] === 'etudiant') {
                $user_obj = new Etudiant($db, $user['username'], $password, $user['email'], $user['profile_picture_url']);
            } elseif ($user['role'] === 'enseignant') {
                $user_obj = new Enseignant($db, $user['username'], $password, $user['email'], $user['profile_picture_url']);
            } elseif ($user['role'] === 'admin') {
                $user_obj = new Admin($db);
            } else {
                $_SESSION['error'] = "Invalid role detected.";
                header("Location: ../../public/front_office/login.php");
                exit;
            }

            if ($user['role'] === 'admin') {
                if (password_verify($password, $user['password_hash']) && $user_obj->loginAdmin($email, $password)) {
                    $_SESSION['success'] = "Admin login successful!";
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'activation' => $user['activation'],
                        'profile_picture_url' => $user['profile_picture_url'],
                    ];
                    header("Location: ../../public/back_office/dashboard.php");
                    exit;
                }
            } else {
                if (password_verify($password, $user['password_hash']) && $user_obj->login()) {
                    $_SESSION['success'] = ucfirst($user['role']) . " login successful!";
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'activation' => $user['activation'],
                        'profile_picture_url' => $user['profile_picture_url'],
                    ];
                    header("Location: ../../public/index.php");
                    exit;
                }
            }

            $_SESSION['error'] = "Invalid username/email or password.";
            header("Location: ../../public/front_office/login.php");
            exit;
        } else {
            $_SESSION['error'] = "User not found.";
            header("Location: ../../public/front_office/login.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: ../../public/front_office/login.php");
        exit;
    }
} else {
    header("Location: ../../public/front_office/login.php");
    exit;
}
