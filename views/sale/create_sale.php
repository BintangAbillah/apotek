<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../includes/auth.php';
include '../../includes/medicine.php';

if (!isLoggedIn()) {
    header("Location: ../../auth/login.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    if (createMedicine($name, $category, $stock, $price)) {
        header("Location: ../../views/medicine/main_medicine.php?success=Medicine created successfully");
        exit();
    } else {
        header("Location: ../../views/medicine/create_medicine.php?error=Failed to create medicine");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Medicine</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/54e497b2de.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white p-4 sticky top-0">
            <h2 class="text-2xl font-bold mb-4"><?php echo strtoupper($user['role']) ?>, <?php echo strtoupper($user['username']) ?></h2>
            <ul>
                <li>
                    <a href="../dashboard.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-gauge"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="../medicine/main_medicine.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-pills"></i>
                        <p>Manage Medicines</p>
                    </a>
                </li>
                <li>
                    <a href="main_sale.php" class="bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-money-bill"></i>
                        <p>Sale</p>
                    </a>
                </li>
                <li>
                    <a href="./users/main_users.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a href="../../includes/auth.php?action=logout" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <h1 class="text-3xl text-white p-4 mb-6 font-bold bg-gray-600 w-full sticky top-0 z-50">Create Medicine</h1>
            <?php if (isset($_GET['error'])): ?>
                <p class="text-red-500"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>
            <div class="flex flex-col items-center">
                <form method="POST" class="bg-white p-6 rounded shadow-md w-11/12">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold">Medicine Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter medicine name" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-bold">Category</label>
                        <input type="text" id="category" name="category" placeholder="Enter category" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-gray-700 font-bold">Stock</label>
                        <input type="number" id="stock" name="stock" placeholder="Enter stock amount" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-bold">Price (Rp.)</label>
                        <input type="number" id="price" name="price" placeholder="Enter price" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="flex justify-between">
                        <a href="main_medicine.php" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>