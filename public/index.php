<?php
require_once __DIR__ . '/../vendor/autoload.php';
use config\Database;
use Src\categories\Category;
use Src\tags\Tag;
use Src\courses\Cours;
use Src\users\Admin;

session_start();

$database = new Database("youdemy");
$db = $database->getConnection();

// categorie
$category = new Category($db);
$categories = $category->read();

// tags
$tag = new Tag($db);
$tags = $tag->read();

$coursObj = new Cours($db);

$user = new Admin($db);
$isLoggedIn = $user->isLoggedIn();
$userRole = $_SESSION['user']['role'] ?? ''; 

// $courses = $coursObj->affichage();
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$courses = $coursObj->getPaginatedCourses($limit, $page);
$totalPages = $coursObj->getTotalPages($limit);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search'])) {
    $searchQuery = htmlspecialchars(trim($_POST['search'])); 
    $courses = $coursObj->search($searchQuery);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dev.to-Blogging-Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold tracking-wide">
                Youdemy-Platform
            </a>
            <div class="flex items-center space-x-6 text-white">
                <?php if ($isLoggedIn && $userRole == 'enseignant'): ?>
                    <a href="front_office/add_cours.php" class="hover:text-blue-400 transition duration-300">
                        Add Course
                    </a>
                    <a href="front_office/statistique.php" class="hover:text-blue-400 transition duration-300">
                        Statistique
                    </a>
                <?php endif; ?>

                <?php if ($isLoggedIn && $userRole == 'etudiant'): ?>
                    <a href="front_office/my_courses.php" class="hover:text-blue-400 transition duration-300">
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
                                href="../src/users/logoutHandler.php" 
                                class="block px-4 py-2 hover:bg-gray-700 rounded-b-lg transition duration-300"
                            >
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="front_office/signup.php" class="hover:text-blue-400 transition duration-300">
                        Sign Up
                    </a>
                    <a href="front_office/login.php" class="hover:text-blue-400 transition duration-300">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Card Section -->
    <div class="flex justify-center mt-8">
      <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-lg shadow-2xl p-8 max-w-4xl text-center text-white">
        <!-- Header -->
        <h1 class="text-4xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
          Welcome to Youdemy-Platform
        </h1>

        <!-- Content Section -->
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between space-y-6 md:space-y-0">
          <!-- Text Section -->
          <div>
            <p class="text-gray-300 text-lg leading-relaxed">
              Dev.to-Blogging-Platform is your go-to destination for creating and sharing high-quality blogs. 
              Explore insightful content, connect with a community of passionate writers, and grow your audience!
            </p>
          </div>
        </div>
        
        <!-- Search Section -->
        <div class="mt-6 flex justify-center items-center space-x-4">
          <form method="POST" class="flex space-x-4 w-full md:w-2/3">
            <input 
              type="text" 
              name="search" 
              placeholder="Search for courses..." 
              class="py-3 px-4 rounded-lg shadow-md text-gray-900 text-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
            />
            <button 
              type="submit" 
              class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg shadow-md text-lg font-semibold transition duration-300">
              Search
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="px-4 sm:px-8 lg:px-16 py-8  from-gray-900 to-black">
        <h2 class="text-4xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 mb-10">
            Featured Courses
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <?php if($course['status'] === 'published') : ?>
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <img src="<?php echo htmlspecialchars($course['featured_image']); ?>" 
                        alt="Course Image" 
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-blue-400 mb-2">
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h4>
                        <p class="text-sm text-gray-400 mb-4">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        <?php if($course['contenu'] === 'document') : ?>
                            <p class="text-gray-200 mb-6">
                                <?php echo htmlspecialchars($course['contenu_document']); ?>
                            </p>
                        <?php else : ?>
                            <iframe 
                                src="<?php echo htmlspecialchars($course['contenu_video']); ?>" 
                                class="w-full h-48 mb-4 rounded-md"
                                frameborder="0" 
                                allowfullscreen>
                            </iframe>
                        <?php endif; ?>
                        <a href="./front_office/detailcours.php?id=<?php echo $course['id']; ?>" 
                          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition-colors duration-300">
                            View Course
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- pagination -->
    <div class="pagination flex justify-center mt-8 gap-1 mb-2">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                Previous
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" 
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg <?php echo $i == $page ? 'bg-blue-700' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                Next
            </a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-6 mt-auto">
      <div class="container mx-auto text-center text-white">
        <div class="flex justify-center space-x-6 mb-4">
          <a href="#" class="hover:text-blue-500 transition duration-300">About Us</a>
          <a href="#" class="hover:text-blue-500 transition duration-300">Privacy Policy</a>
          <a href="#" class="hover:text-blue-500 transition duration-300">Terms of Service</a>
        </div>
        <p class="text-sm text-gray-400">&copy; 2025 Youdemy-Platform. All rights reserved.</p>
      </div>
    </footer>

</body>
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
</html>
