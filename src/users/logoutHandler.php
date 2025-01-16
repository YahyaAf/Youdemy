<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\Enseignant;
use Src\users\Etudiant;

$database = new Database("youdemy");
$db = $database->getConnection();

if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    $username = $_SESSION['user']['username'];
    $password = $_SESSION['user']['password'];

    if ($role === 'etudiant') {
        $user = new Etudiant($db, $username, $password, $_SESSION['user']['email'], $_SESSION['user']['profile_picture_url']);
    } elseif ($role === 'enseignant') {
        $user = new Enseignant($db, $username, $password, $_SESSION['user']['email'], $_SESSION['user']['profile_picture_url']);
    } else {
        echo "Invalid role.";
        exit;
    }

    if ($user->logout()) {
        session_unset();
        session_destroy();
        header("Location: ../../public/index.php");
        exit();
    } else {
        echo "Logout failed.";
    }
} else {
    echo "No user is logged in.";
}
?>
