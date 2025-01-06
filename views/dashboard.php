<?php
include '../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../auth/login.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/54e497b2de.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white p-4">
            <h2 class="text-2xl font-bold mb-4"><?php echo strtoupper($user['role']) ?>, <?php echo strtoupper($user['username']) ?></h2>
            <ul>
                <li>
                    <a href="dashboard.php" class="bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-gauge"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="./medicine/main_medicine.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-pills"></i>
                        <p>Manage Medicines</p>
                    </a>
                </li>
                <li>
                    <a href="./sales/main_sales.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-money-bill"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <li>
                    <a href="./users/main_sales.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a href="../includes/auth.php?action=logout" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
            <!-- <i class="fa-solid fa-user"></i> -->
        </div>

        <!-- Main Dashboard -->
        <div class="flex-1">
            <h1 class="text-3xl text-white p-4 mb-6 font-bold bg-gray-600 w-full">Dashboard</h1>
            <div class="grid grid-cols-3 gap-4 px-4">
                <!-- Active Users -->
                <div class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2">Active Users</h2>
                    <p class="text-3xl font-bold"><?= $activeUsers ?></p>
                </div>

                <!-- Total Medicines Sold -->
                <div class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2">Total Medicines Sold</h2>
                    <p class="text-3xl font-bold"><?= $medicinesSold ?></p>
                </div>

                <!-- Medicine Stock -->
                <div class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-2">Medicine Stock</h2>
                    <p class="text-3xl font-bold"><?= $medicineStock ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>