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
<style>
    #profile-dropdown ul li {
        padding: 8px 16px;
        cursor: pointer;
    }

    #profile-dropdown ul li:hover {
        background-color: #f3f4f6;
    }
</style>
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
                <?php if ($user['role'] === "admin"): ?>
                    <li>
                        <a href="./users/main_users.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            <p>Users</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="../includes/auth.php?action=logout" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Dashboard -->
        <div class="flex-1">
            <div class="flex mb-6 items-center justify-start bg-gray-600">
                <h1 class="text-3xl text-white p-4 font-bold w-11/12">Dashboard</h1>
                <div class="relative text-3xl text-white p-4 font-bold">
                    <div id="profile-icon" class="border px-2 py-1 rounded-full cursor-pointer hover:bg-gray-700">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded shadow-md hidden">
                        <ul id="dropdown-menu" class="py-2">
                        </ul>
                    </div>
                </div>
            </div>
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
<script>
    document.getElementById('profile-icon').addEventListener('click', function () {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.classList.toggle('hidden');

        // Check if dropdown is visible before fetching
        if (!dropdown.classList.contains('hidden')) {
            fetch('../elements/profile_menu.php')
                .then(response => response.json())
                .then(data => {
                    const dropdownMenu = document.getElementById('dropdown-menu');
                    dropdownMenu.innerHTML = ''; 

                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.label;
                        li.className = 'hover:bg-gray-100, text-sm';
                        li.onclick = () => window.location.href = item.link;
                        dropdownMenu.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error('Error fetching profile menu:', error);
                    alert('Failed to load profile menu.');
                });
        }
    });

    // Hide dropdown if clicked outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('profile-dropdown');
        if (!document.getElementById('profile-icon').contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
</html>