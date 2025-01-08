<?php
include '../includes/auth.php';
include '../includes/users.php';

if (!isLoggedIn()) {
    header("Location: ../auth/login.php");
    exit();
}

$user = $_SESSION['user'];

$userData = getUserById($user['id']);

// update users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (updateUserProfile($full_name, $username, $password, $role)) {
        header("Location: profile.php?success=User updated successfully");
        exit();
    } else {
        $error = "Failed to update user. Please try again.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedFileExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedFileExtensions)) {
            $uploadFileDir = '../uploads/profile_pictures/';
            $destPath = $uploadFileDir . 'profile_' . $userId . '.' . $fileExtension;

            if (!file_exists($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $_SESSION['message'] = "Profile picture updated successfully.";
            } else {
                $_SESSION['error'] = "Error moving the uploaded file.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Allowed types: jpg, jpeg, png.";
        }
    } else {
        $_SESSION['error'] = "Error uploading file.";
    }

    header("Location: profile.php");
    exit();
}

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

        <!-- Main Page -->
        <div class="flex-1">
            <div class="flex mb-6 items-center justify-start bg-gray-600">
                <h1 class="text-3xl text-white p-4 font-bold w-11/12">Profile Page</h1>
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
            <div class="flex items-center justify-center">
                <div class="flex flex-row item-start gap-4 w-11/12 p-8 rounded-lg bg-white border">
                    <div class="flex flex-col items-center border p-2 rounded-lg shadow-sm">
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Profile Picture" class="rounded-full w-32 h-32">
                        <div class="flex flex-row justify-center items-center gap-4 mt-4">
                            <h2 class="text-2xl font-bold"><?php echo $userData['fullName'] ?></h2>
                            <i id="edit-icon" class="mt-1 fa-solid fa-pencil cursor-pointer"></i>
                        </div>
                        <form action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo $userData['id']; ?>">
                            <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*" class="hidden">
                        </form>
                    </div>
                    <form method="POST" class="flex flex-col gap-4">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" id="username" name="username" value="<?= htmlspecialchars($userData['username']); ?>">
                        <div class="flex flex-row items-center gap-4 border-b pb-4">
                            <label for="full_name" class="text-gray-500 w-20">Full Name</label>
                            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($userData['fullName']); ?>" class="border rounded-lg p-2">
                        </div>
                        <div class="flex flex-row items-center gap-4 border-b pb-4">
                            <label for="username_display" class="text-gray-500 w-20">Username</label>
                            <input type="text" id="username_display" name="username_display" value="<?= htmlspecialchars($userData['username']); ?>" class="border rounded-lg p-2" disabled>
                        </div>
                        <div class="flex flex-row items-center gap-4 border-b pb-4">
                            <label for="password" class="text-gray-500 w-20">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your new password" class="border rounded-lg p-2">
                        </div>
                        <div class="flex flex-row items-center gap-4">
                            <label for="role" class="text-gray-500 w-20">Role</label>
                            <?php if ($userData['role'] === "admin"): ?>
                                <select id="role" name="role" class="border w-auto pr-4 rounded-lg p-2">
                                    <option value="user" <?= $userData['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $userData['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            <?php else: ?>
                                <input type="text" id="role_display" name="role_display" value="<?= htmlspecialchars($userData['role']); ?>" class="border rounded-lg p-2" disabled>
                                <input type="hidden" id="role" name="role" value="<?= htmlspecialchars($userData['role']); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Update</button>
                        </div>
                    </form>

                </div>
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
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profile-dropdown');
        if (!document.getElementById('profile-icon').contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Get elements
    const editIcon = document.getElementById('edit-icon');
    const fileInput = document.getElementById('profile-picture-input');
    const profilePicturePreview = document.getElementById('profile-picture-preview');

    editIcon.addEventListener('click', () => {
        fileInput.click();
    });

    // Update image preview on file selection
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                profilePicturePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</html>