<?php
session_start();
include 'db.php';

// Register a new user
function registerUser($full_name, $username, $password, $role = 'user')
{
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $deleted = "";
    $query = "INSERT INTO users (fullName, username, password, role, deleted) VALUES (:full_name, :username, :password, :role, :deleted)";
    $stmt = $conn->prepare($query);

    if (checkUsername($username)) {
        return false;
    }

    try {
        $stmt->execute([
            ':full_name' => $full_name,
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role,
            ':deleted' => $deleted
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// reset password
function resetUser($full_name, $username, $password)
{
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "SELECT id FROM users WHERE username = :username AND fullName = :full_name";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':username' => $username,
            ':full_name' => $full_name
        ]);

        if ($stmt->rowCount() === 0) {
            return false; 
        }

        $updateQuery = "UPDATE users SET password = :password WHERE username = :username";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        return true; 
    } catch (Exception $e) {
        return false; 
    }
}


function checkUsername($username)
{
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

    if ($user) {
        return true;
    } else {
        return false;
    }
}

function checkFullName($fullName)
{
    global $conn;

    $query = "SELECT id FROM users WHERE fullName = :fullName";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':fullName' => $fullName
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return false;
    }

    if ($user) {
        return true;
    } else {
        return false;
    }
}

// Log in a user
function loginUser($username, $password)
{
    global $conn;

    $query = "SELECT id, fullName, username, password, role, isActive FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password']) && $user['isActive']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'fullName' => $user['fullName']
        ];
        return true;
    }
    return false;
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user']);
}

// Check user role
function hasRole($role)
{
    return isLoggedIn() && $_SESSION['user']['role'] === $role;
}

// Log out
function logoutUser()
{
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logoutUser();
}
