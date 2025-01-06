<?php
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        header("Location: ../views/dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials or account inactive.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title class="">Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form class="bg-white p-6 rounded shadow-md" method="POST">
        <h1 class="flex justify-center items-center text-2xl font-bold mb-4">Login</h1>
        <?php if (!empty($error)): ?>
            <p class="text-red-500"><?= $error; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" class="border p-2 w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-4" required>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded">Login</button>
        <p class="flex justify-center text-xs">Don't have an account? <a href="register.php" class="mx-1 text-blue-600 hover:underline hover:text-blue-500">Register</a></p>
    </form>
</body>
</html>
