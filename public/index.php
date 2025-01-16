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
            <!-- Logo -->
            <a href="#" class="text-white text-2xl font-bold tracking-wide">
                Youdemy-Platform
            </a>

            <!-- Links and Buttons -->
            <div class="flex items-center space-x-6 text-white">
                <!-- Navigation Links -->
                <a href="front_office/add_cours.php" class="hover:text-blue-400 transition duration-300">
                    Add Course
                </a>
                <a href="front_office/my_courses.php" class="hover:text-blue-400 transition duration-300">
                    My Courses
                </a>
                <a href="front_office/signup.php" class="hover:text-blue-400 transition duration-300">
                    Sign Up
                </a>
                <a href="front_office/login.php" class="hover:text-blue-400 transition duration-300">
                    Login
                </a>
                <!-- Dropdown Menu -->
                <div class="relative">
                    <button 
                        id="userMenuButton"
                        class="flex items-center space-x-2 bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg shadow transition duration-300"
                    >
                        <span>User</span>
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
              placeholder="Search for articles..." 
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6 mx-auto mb-5" style="max-width: 90%;">
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
