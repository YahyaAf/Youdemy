<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Enable Tailwind's Dark Mode
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
</head>
<body>
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
                <a href="pages/add_course.php" class="hover:text-blue-400 transition duration-300">
                    Add Course
                </a>
                <a href="pages/my_courses.php" class="hover:text-blue-400 transition duration-300">
                    My Courses
                </a>
                <a href="pages/signup.php" class="hover:text-blue-400 transition duration-300">
                    Sign Up
                </a>
                <a href="pages/login.php" class="hover:text-blue-400 transition duration-300">
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
    <div class="bg-gray-900 text-gray-200 flex items-center justify-center h-screen">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Welcome Back</h2>
            <form action="../../src/users/loginHandler.php" method="POST" class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your email" 
                        required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your password" 
                        required>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Log In
                </button>

                <!-- Sign-Up Prompt -->
                <p class="text-sm text-center text-gray-400 mt-4">
                    Don’t have an account? 
                    <a href="signup.php" class="text-blue-400 hover:underline">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
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
</html>