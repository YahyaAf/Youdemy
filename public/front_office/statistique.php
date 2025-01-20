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
}elseif (!isset($_SESSION['user']) || $_SESSION['user']['activation'] === 'pending') {
    header('Location: pending.php');
    exit();
}elseif (!isset($_SESSION['user']) || $_SESSION['user']['activation'] === 'baned') {
    header('Location: banned.php');
    exit();
}

$database = new Database("youdemy");
$db = $database->getConnection();
$userId = $_SESSION['user']['id'] ?? ''; 

$coursObj = new Cours($db);
$etudiantInscrire = $coursObj->etudiantInscrit($userId);
$countCours = $coursObj->coursByEnseignant($userId);


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
        <h1 class="text-3xl font-bold text-center mb-6">Statistiques des Enseignants</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex items-center space-x-4">
                <div class="bg-blue-500 p-4 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 10-8 0v2m6 8H7m10 0a2 2 0 11-4 0 2 2 0 014 0zm-4-6h.01"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Étudiants Inscrits</h2>
                    <?php if (!empty($etudiantInscrire)) : ?>
                        <p class="text-gray-300"><?php echo htmlspecialchars($etudiantInscrire['teacher_name']); ?> : <?php echo htmlspecialchars($etudiantInscrire['student_count']); ?></p>
                    <?php else : ?>
                        <p class="text-gray-500">No data found for this teacher.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex items-center space-x-4">
                <div class="bg-green-500 p-4 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16m-7 4h7m-7 4h7M4 14h7m0 4h7"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Cours Créés</h2>
                    <?php if (!empty($countCours)) : ?>
                        <p class="text-gray-300">Total : <?php echo htmlspecialchars($countCours); ?></p>
                    <?php else : ?>
                        <p class="text-gray-500">No data found for this teacher.</p>
                    <?php endif; ?>
                </div>
            </div>
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
