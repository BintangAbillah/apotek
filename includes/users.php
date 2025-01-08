<?php
include 'db.php';

// Get all users
function getUsers()
{
    global $conn;

    $query = "SELECT id, fullName, username, role, isActive, created FROM users WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// count active users
function countUsers()
{
    global $conn;

    $query = "SELECT count(isActive) as Total FROM users WHERE isActive = 1 AND deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Create a new user
function createUser($full_name, $username, $password, $role = "user")
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (checkUsername($username)) {
        return false;
    }
    $isActive = 1;
    $deleted = "";
    $query = "INSERT INTO users (fullName, username, password, role, isActive, deleted) VALUES (:full_name, :username, :password, :role, :isActive, :deleted)";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':full_name' => $full_name,
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role,
            ':isActive' => $isActive,
            ':deleted' => $deleted
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Get a single user by ID
function getUserById($id)
{
    global $conn;
    $query = "SELECT id, fullName, username, role, isActive FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update a user
function updateUser($full_name, $username, $role, $isActive = 1)
{
    global $conn;

    if (strtolower($isActive) === 'active') {
        $isActive = 1;
    } elseif (strtolower($isActive) === 'inactive') {
        $isActive = 0;
    }

    $query = "UPDATE users SET fullName = :full_name, role = :role, isActive = :isActive WHERE username = :username";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':username' => $username,
            ':full_name' => $full_name,
            ':role' => $role,
            ':isActive' => $isActive
        ]);
        return true;
    } catch (Exception $e) {
        error_log("Update failed: " . $e->getMessage());
        return false;
    }
}

function updateUserProfile($full_name, $username, $password, $role)
{
    global $conn;

    $query = "UPDATE users SET fullName = :full_name, role = :role";

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query .= ", password = :password"; 
    }

    $query .= " WHERE username = :username";

    $stmt = $conn->prepare($query);

    $params = [
        ':username' => $username,
        ':full_name' => $full_name,
        ':role' => $role,
    ];

    if (!empty($password)) {
        $params[':password'] = $hashedPassword;
    }

    try {
        $stmt->execute($params);

        return true; 
    } catch (Exception $e) {
        error_log("Update failed: " . $e->getMessage());
        return false;
    }
}


// Delete a user
function deleteUser($id)
{
    global $conn;
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}

// Soft delete action
if (isset($_GET['action']) && $_GET['action'] === 'soft_delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (softDeleteUser($id)) {
        echo 'success';
    } else {
        echo 'Failed to delete user';
    }
    exit();
}

// Soft delete a user
function softDeleteUser($id)
{
    global $conn;
    $query = "UPDATE users SET isActive = 0, deleted = '*' WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}
