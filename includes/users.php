<?php
include 'db.php';

// Get all users
function getUsers()
{
    global $conn;

    $query = "SELECT id, username, role, isActive, created FROM users WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create a new user
function createUser($username, $password, $role = "user")
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (checkUsername($username)) {
        return false;
    }
    $isActive = 1;
    $deleted = "";
    $query = "INSERT INTO users (username, password, role, isActive, deleted) VALUES (:username, :password, :role, :isActive, :deleted)";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
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
    $query = "SELECT id, username, role, isActive FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update a user
function updateUser($username, $role, $isActive)
{
    global $conn;

    if (strtolower($isActive) === 'active') {
        $isActive = 1;
    } else {
        $isActive = 0;
    }
    $deleted = "";

    $query = "UPDATE users SET role = :role, isActive = :isActive, deleted = :deleted WHERE username = :username";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':username' => $username,
            ':role' => $role,
            ':isActive' => $isActive,
            ':deleted' => $deleted
        ]);
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
