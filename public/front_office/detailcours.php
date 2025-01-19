<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\courses\Cours;
use Src\categories\Category;
use Src\tags\Tag;
use Src\users\Admin;

session_start();

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
                <a href="add_cours.php" class="hover:text-blue-400 transition duration-300">
                    Add Course
                </a>
                <a href="my_courses.php" class="hover:text-blue-400 transition duration-300">
                    My Courses
                </a>
                
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
            
            <!-- Image Section -->
            <div class="lg:w-1/3 flex justify-center">
                <img 
                    src="<?php echo htmlspecialchars($course['featured_image'] ?? 'default-image.jpg'); ?>" 
                    alt="Course Image" 
                    class="rounded-lg shadow-lg w-full max-w-sm object-cover"
                >
            </div>

            <div class="lg:w-2/3 flex flex-col gap-6">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                    <?php echo htmlspecialchars($course['title']); ?>
                </h1>

                <p class="text-sm text-gray-400">
                    <span class="font-semibold text-gray-300">Published on:</span> 
                    <?php echo htmlspecialchars($course['scheduled_date_only']); ?>
                </p>

                <p class="text-lg text-gray-300 leading-relaxed">
                    <?php echo htmlspecialchars($course['description']); ?>
                </p>

                <p class="text-lg text-gray-300 leading-relaxed ">
                    <?php echo nl2br(htmlspecialchars($course['contenu_document'])); ?>
                </p>

                <div>
                    <span class="font-semibold text-gray-300">Category:</span> 
                    <span class="text-gray-400"><?php echo htmlspecialchars($course['category_name']); ?></span>
                </div>

                <div>
                    <span class="font-semibold text-gray-300">Tags:</span>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <?php 
                            if (!empty($course['tags'])) {
                                $tags = explode(',', $course['tags']);
                                foreach ($tags as $tag) {
                                    echo "<span class='bg-blue-500 text-white rounded-full px-3 py-1 text-sm'>" . htmlspecialchars($tag) . "</span>";
                                }
                            } else {
                                echo "<span class='text-gray-400'>No tags available.</span>";
                            }
                        ?>
                    </div>
                </div>

                <?php if($course['contenu'] === "video"): ?>
                    <iframe 
                        src="<?php echo htmlspecialchars($course['contenu_video']); ?>" 
                        class="w-full h-64 rounded-md border-2 border-gray-700 shadow-lg"
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                <?php endif; ?>

                <div class="mt-6 flex gap-4">
                    <a
                        href="../index.php"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition-all duration-300"
                    >
                        Go Back
                    </a>
                    <a
                        href="../../src/enroll/enrollHandler.php?id=<?php echo htmlspecialchars($course['id']); ?>"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition-all duration-300"
                    >
                        Add Course
                    </a>
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
