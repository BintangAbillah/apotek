<?php
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (registerUser($username, $password, $role)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed. Username may already exist.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/54e497b2de.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form class="bg-white p-6 rounded shadow-md" method="POST">
        <h1 class="flex justify-center items-center text-2xl font-bold mb-4">Register</h1>
        <?php if (!empty($error)): ?>
            <p class="text-red-500"><?= $error; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" class="border p-2 w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-4" required>
        <select name="role" class="border p-2 w-full mb-4">
            <option value="user">User</option>
            <option value="manager">Manager</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Register</button>
        <p class="flex justify-center text-xs">Already have an account? <a href="login.php" class="mx-1 text-blue-600 hover:underline hover:text-blue-500">Login</a></p>
    </form>
</body>
</html>
