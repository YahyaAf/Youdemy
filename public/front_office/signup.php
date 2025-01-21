<?php
session_start();
$form_errors = $_SESSION['form_errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-gray-900 text-gray-200 flex items-center justify-center h-screen">
        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Create an Account</h2>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white text-sm p-3 rounded mb-4">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="../../src/users/signupHandler.php" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="<?= htmlspecialchars($form_data['username'] ?? '') ?>"
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border <?= isset($form_errors['username']) ? 'border-red-500' : 'border-gray-600' ?> rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your username">
                    <?php if (isset($form_errors['username'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($form_errors['username']) ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border <?= isset($form_errors['email']) ? 'border-red-500' : 'border-gray-600' ?> rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your email">
                    <?php if (isset($form_errors['email'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($form_errors['email']) ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border <?= isset($form_errors['password']) ? 'border-red-500' : 'border-gray-600' ?> rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your password">
                    <?php if (isset($form_errors['password'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($form_errors['password']) ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="profile_picture_url" class="block text-sm font-medium text-gray-300">Profile Picture</label>
                    <input 
                        type="url" 
                        id="profile_picture_url" 
                        name="profile_picture_url" 
                        value="<?= htmlspecialchars($form_data['profile_picture_url'] ?? '') ?>"
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border <?= isset($form_errors['profile_picture_url']) ? 'border-red-500' : 'border-gray-600' ?> rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter your profile picture URL">
                    <?php if (isset($form_errors['profile_picture_url'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($form_errors['profile_picture_url']) ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
                    <select 
                        id="role" 
                        name="role" 
                        class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border <?= isset($form_errors['role']) ? 'border-red-500' : 'border-gray-600' ?> rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">-- Please choose a role --</option>
                        <option value="etudiant" <?= ($form_data['role'] ?? '') === 'etudiant' ? 'selected' : '' ?>>Etudiant</option>
                        <option value="enseignant" <?= ($form_data['role'] ?? '') === 'enseignant' ? 'selected' : '' ?>>Enseignant</option>
                    </select>
                    <?php if (isset($form_errors['role'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($form_errors['role']) ?></p>
                    <?php endif; ?>
                </div>
                <button 
                    type="submit" 
                    class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Sign Up
                </button>
                <p class="text-sm text-center text-gray-400 mt-4">
                    Deja have a account? 
                    <a href="login.php" class="text-blue-400 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
