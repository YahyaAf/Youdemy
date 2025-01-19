<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\enroll\Enroll;
use Src\users\Admin;

session_start();
$userId = $_SESSION['user']['id'];

$database = new Database("youdemy");
$db = $database->getConnection();

$enroll = new Enroll($db);

$enrollments = $enroll->readAll($userId);
$user = new Admin($db);
$isLoggedIn = $user->isLoggedIn();
$userRole = $_SESSION['user']['role'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
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

    <!-- My Courses Section -->
    <div class="container mx-auto mt-10 px-6 md:px-0">
        <h2 class="text-3xl font-semibold text-center mb-8">My Enrolled Courses</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($enrollments as $enrollment): ?>
                <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-lg shadow-xl p-6">
                    <img src="<?= htmlspecialchars($enrollment['course_featured_image']) ?>" alt="Course Image" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="text-xl font-bold mt-4"><?= htmlspecialchars($enrollment['course_title']) ?></h3>
                    <p class="mt-2 text-sm text-gray-400"><?= htmlspecialchars($enrollment['course_description']) ?></p>
                    <div class="flex justify-between items-center mt-4">
                        <a href="./detailcours.php?id=<?= $enrollment['cours_id'] ?>" class="text-blue-400 hover:text-blue-500 transition duration-300">View Details</a>
                        <a href="../../src/enroll/enrollHandler.php?id=<?= $enrollment['cours_id'] ?>&action=delete" class="text-red-400 hover:text-red-500 transition duration-300">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
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
