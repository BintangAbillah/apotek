<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../includes/auth.php';
include '../../includes/users.php';

if (!isLoggedIn()) {
    header("Location: ../../auth/login.php");
    exit();
}

$user = $_SESSION['user'];

if ($user['role'] !== "admin") {
    header("Location: ../../views/dashboard.php");
    exit();
}

// Validate user ID
if (!isset($_GET['id'])) {
    header("Location: main_users.php");
    exit();
}

$userId = $_GET['id'];
$userData = getUserById($userId);

if (!$user) {
    header("Location: main_users.php");
    exit();
}

// post request to edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $isActive = $_POST['isActive'];

    if (updateUser($username, $role, $isActive)) {
        header("Location: ../../views/users/main_users.php?success=User updated successfully");
        exit();
    } else {
        error_log("Failed to update user with Username: $username");
        header("Location: ../../views/users/edit_user.php?username=$username&error=Failed to update user");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit User</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
                        <p>Manage Medicine</p>
                    </a>
                </li>
                <li>
                    <a href="../sales/main_sales.php" class="bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-money-bill"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <?php if ($user['role'] === "admin"): ?>
                    <li>
                        <a href="main_users.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            <p>Users</p>
                        </a>
                    </li>
                <?php endif; ?>
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
            <div class="flex mb-6 items-center justify-start bg-gray-600 sticky top-0 z-50">
                <h1 class="text-3xl text-white p-4 font-bold w-11/12">Edit User</h1>
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
            <?php if (isset($_GET['error'])): ?>
                <p class="text-red-500"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>
            <div class="flex flex-col items-center">
                <form method="POST" class="bg-white p-6 rounded shadow-md w-11/12">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($userData['id']); ?>">

                    <div class="mb-4">
                        <label for="username_display" class="block text-gray-700 font-bold">Username</label>
                        <input type="text" id="username_display" name="username_display" value="<?= htmlspecialchars($userData['username']); ?>" placeholder="Enter Username" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" disabled>
                        <input type="hidden" id="username" name="username" value="<?= htmlspecialchars($userData['username']); ?>">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-bold">Role</label>
                        <select id="role" name="role" class="border p-2 w-full mb-4" required>
                            <option value="user" <?= $userData['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $userData['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="isActive" class="block text-gray-700 font-bold">isActive</label>
                        <select id="isActive" name="isActive" class="border p-2 w-full mb-4" required>
                            <option value="active" <?= $userData['isActive'] === '1' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $userData['isActive'] === '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="flex justify-between">
                        <a href="main_users.php" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('profile-icon').addEventListener('click', function() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.classList.toggle('hidden');

        // Check if dropdown is visible before fetching
        if (!dropdown.classList.contains('hidden')) {
            fetch('../../elements/profile_menu.php')
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
</script>

</html>