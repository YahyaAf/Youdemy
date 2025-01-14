<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    use Src\tags\Tag;
    use Src\courses\Cours;

    $database = new Database("youdemy");
    $db = $database->getConnection();

    // categorie
    $category = new Category($db);
    $categories = $category->read();

    // tags
    $tag = new Tag($db);
    $tags = $tag->read();

    $coursObj = new Cours($db);
    $cours = $coursObj->readAll(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold tracking-wide">
                Youdemy-Platform
            </a>
            <div class="flex items-center space-x-6">
                <a href="pages/add_course.php" class="hover:text-blue-400 transition duration-300">Add Course</a>
                <a href="pages/my_courses.php" class="hover:text-blue-400 transition duration-300">My Courses</a>
                <a href="pages/signup.php" class="hover:text-blue-400 transition duration-300">Sign Up</a>
                <a href="pages/login.php" class="hover:text-blue-400 transition duration-300">Login</a>
                <div class="relative">
                    <button 
                        id="userMenuButton" 
                        class="bg-gray-800 hover:bg-gray-700 py-2 px-4 rounded-lg transition duration-300"
                    >
                        User
                    </button>
                    <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg hidden">
                        <a href="pages/account.php" class="block px-4 py-2 hover:bg-gray-700">Account</a>
                        <a href="../src/users/logoutHandler.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Container for the form and table -->
    <div class="flex justify-between gap-10 mt-10">
        <!-- Add Course Form (on the left) -->
        <div class="flex-1 max-w-lg"> 
            <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-6 rounded-lg shadow-lg ml-6 mb-10"> 
                <h1 class="text-center text-3xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
                    Add Course
                </h1>
                <form action="../../src/courses/coursHandler.php" method="POST">
                    <div class="mb-4">
                        <label for="title" class="block text-lg font-medium mb-2">Course Title</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Enter course title" 
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-lg font-medium mb-2">Course Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter course description" 
                            required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="contenu" class="block text-lg font-medium mb-2">Course Content Type</label>
                        <select 
                            id="contenu" 
                            name="contenu" 
                            class="w-full mt-1 p-2.5 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" <!-- Reduced padding -->
                            required
                        >
                            <option value="">--Please choose content type--</option>
                            <option value="video">Video</option>
                            <option value="document">Document</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="categorie" class="block text-lg font-medium mb-2">Category</label>
                        <select 
                            id="categorie" 
                            name="categorie" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Please choose a category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['id']); ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tags" class="block text-lg font-medium mb-2">Tags</label>
                        <select 
                            id="tags" 
                            name="tags[]" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            multiple>
                            <?php foreach ($tags as $tag): ?>
                                <option value="<?php echo htmlspecialchars($tag['id']); ?>">
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-sm text-gray-400 mt-2">Hold down the Ctrl (Windows) or Command (Mac) key to select multiple tags.</p>
                    </div>
                    <div class="mb-4">
                        <label for="featured_image" class="block text-lg font-medium mb-2">Featured Image URL</label>
                        <input 
                            type="url" 
                            id="featured_image" 
                            name="featured_image" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter image URL" 
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="scheduled_date" class="block text-lg font-medium mb-2">Scheduled Date</label>
                        <input 
                            type="date" 
                            id="scheduled_date" 
                            name="scheduled_date" 
                            class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            required>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 py-3 rounded-lg text-lg font-semibold transition duration-300">
                        Add Course
                    </button>
                </form>
            </div>
        </div>

        <!-- Courses Table (on the right) -->
        <div class="flex-1">
            <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-center text-gradient-to-r from-blue-400 to-purple-500">
                    Courses List
                </h2>
                <table class="w-full text-sm text-left text-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Course Title</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Tags</th>
                            <th class="px-4 py-2">Content</th>
                            <th class="px-4 py-2">Scheduled Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cours as $course): ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['category_name']); ?></td>
                                <td class="px-4 py-2">
                                    <?php 
                                        $tags = explode(',', $course['tags']);
                                        foreach ($tags as $tag) {
                                            echo "<span class='bg-blue-500 text-white rounded-full px-2 py-1 text-xs'>" . htmlspecialchars($tag) . "</span> ";
                                        }
                                    ?>
                                </td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['contenu']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['scheduled_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
