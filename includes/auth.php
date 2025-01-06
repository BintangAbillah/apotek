<?php
session_start();
include 'db.php';

// Register a new user
function registerUser($username, $password, $role = 'user') {
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $conn->prepare($query);
    
    if (checkUsername($username)) {
        return false;
    }

    try {
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function checkUsername($username) {
    global $conn;

    $query = "SELECT id FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':username' => $username
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return false;
    }

    // If the user exists, return true (username is taken)
    if ($user) {
        return true;
    } else {
        return false;
    }
}

// Log in a user
function loginUser($username, $password) {
    global $conn;

    $query = "SELECT id, username, password, role, isActive FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password']) && $user['isActive']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        return true;
    }
    return false;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Check user role
function hasRole($role) {
    return isLoggedIn() && $_SESSION['user']['role'] === $role;
}

// Log out
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logoutUser();
}
?>
