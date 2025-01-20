<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\courses\Cours;
use Src\categories\Category;
use Src\tags\Tag;
use Src\users\Admin;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: erreur404.php');
    exit();
}

$database = new Database("youdemy");
$db = $database->getConnection();

$coursObj = new Cours($db);

if (isset($_GET['id'])) {
    $coursId = $_GET['id'];

    $course = $coursObj->read($coursId);

    if ($course === null) {
        echo "Course not found.";
        exit;
    }
} else {
    echo "Invalid course ID.";
    exit;
}

$user = new Admin($db);
$isLoggedIn = $user->isLoggedIn();
$userRole = $_SESSION['user']['role'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="../index.php" class="text-white text-2xl font-bold tracking-wide">
                Youdemy-Platform
            </a>
            <div class="flex items-center space-x-6 text-white">
                <?php if ($isLoggedIn && $userRole == 'enseignant'): ?>
                    <a href="add_cours.php" class="hover:text-blue-400 transition duration-300">
                        Add Course
                    </a>
                    <a href="statistique.php" class="hover:text-blue-400 transition duration-300">
                        Statistique
                    </a>
                <?php endif; ?>

                <?php if ($isLoggedIn && $userRole == 'etudiant'): ?>
                    <a href="my_courses.php" class="hover:text-blue-400 transition duration-300">
                        My Courses
                    </a>
                <?php endif; ?>
                <?php if ($isLoggedIn): ?>
                    <div class="relative">
                        <button 
                            id="userMenuButton"
                            class="flex items-center space-x-2 bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg shadow transition duration-300"
                        >
                            <span><?php echo $_SESSION['user']['username'] ?></span>
                        </button>
                        <div 
                            id="userMenu"
                            class="absolute right-0 mt-2 w-48 bg-gray-800 text-white rounded-lg shadow-lg hidden"
                        >
                            <a 
                                href="pages/account.php" 
                                class="block px-4 py-2 hover:bg-gray-700 rounded-t-lg transition duration-300"
                            >
                                Account
                            </a>
                            <a 
                                href="../../src/users/logoutHandler.php" 
                                class="block px-4 py-2 hover:bg-gray-700 rounded-b-lg transition duration-300"
                            >
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="signup.php" class="hover:text-blue-400 transition duration-300">
                        Sign Up
                    </a>
                    <a href="login.php" class="hover:text-blue-400 transition duration-300">
                        Login
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </nav>

    <!-- Course Details -->
    <div class="container mx-auto mt-10 px-6 md:px-0">
        <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-lg shadow-xl p-8 text-white flex flex-col lg:flex-row gap-8">
            
            
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-6 mt-auto text-center">
        <p>&copy; 2025 Youdemy-Platform. All Rights Reserved.</p>
    </footer>

    <script>
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
