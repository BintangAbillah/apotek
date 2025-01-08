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

if (!isset($_GET['id'])) {
    header("Location: main_medicine.php");
    exit();
}

$medicineId = $_GET['id'];
$medicine = getMedicineById($medicineId);

if (!$medicine) {
    header("Location: main_medicine.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    if (updateMedicine($id, $name, $category, $stock, $price)) {
        header("Location: ../../views/medicine/main_medicine.php?success=Medicine updated successfully");
        exit();
    } else {
        header("Location: ../../views/medicine/edit_medicine.php?id=$id&error=Failed to update medicine");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Medicine</title>
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
                    <a href="main_medicine.php" class="bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-pills"></i>
                        <p>Manage Medicines</p>
                    </a>
                </li>
                <li>
                    <a href="../sales/main_sales.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-money-bill"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <?php if ($user['role'] === "admin"): ?>
                    <li>
                        <a href="../users/main_users.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
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
                <h1 class="text-3xl text-white p-4 font-bold w-11/12">Edit Medicine</h1>
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
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($medicine['id']); ?>">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold">Medicine Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($medicine['name']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-bold">Category</label>
                        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($medicine['category']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-gray-700 font-bold">Stock</label>
                        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($medicine['stock']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-bold">Price (Rp.)</label>
                        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($medicine['price']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="flex justify-between">
                        <a href="main_medicine.php" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
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

    // Hide dropdown if clicked outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profile-dropdown');
        if (!document.getElementById('profile-icon').contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

</html>