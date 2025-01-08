<?php
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (resetUser($full_name, $username, $password)) {
        header("Location: login.php?success=Password reset successfully.");
        exit();
    } else {
        $error = "Reset password failed. Please check your username and full name.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Account</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/54e497b2de.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form class="bg-white p-6 rounded shadow-md" method="POST">
        <h1 class="flex justify-center items-center text-2xl font-bold mb-4">Reset Account</h1>
        <?php if (!empty($error)): ?>
            <p class="text-red-500"><?= $error; ?></p>
        <?php endif; ?>
        <input type="text" name="full_name" placeholder="Full Name" class="border p-2 w-full mb-4" required>
        <input type="text" name="username" placeholder="Username" class="border p-2 w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-4" required>
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Send</button>
        <p class="flex justify-center text-xs">Already have an account? <a href="login.php" class="mx-1 text-blue-600 hover:underline hover:text-blue-500">Login</a></p>
    </form>
</body>
</html>
