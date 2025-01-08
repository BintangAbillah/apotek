<?php
include 'db.php';

// Get all medicines
function getMedicines()
{
    global $conn;

    $query = "SELECT * FROM medicines WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMedicinesStock()
{
    global $conn;

    $query = "SELECT SUM(stock) as totalStock FROM medicines WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get a single medicine by ID
function getMedicineById($id)
{
    global $conn;
    $query = "SELECT id, name, price, category, stock FROM medicines WHERE id = :id AND deleted != '*'";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Get a single medicine by ID
function getMedicineByName($name)
{
    global $conn;
    $query = "SELECT price FROM medicines WHERE name = :name AND deleted != '*'";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':name', $name);
    $stmt->execute();
    $medicine = $stmt->fetch(PDO::FETCH_ASSOC);
    return $medicine ? $medicine : ['price' => 0];
}


// Fetch medicine suggestions
function fetchMedicineSuggestions($name)
{
    global $conn;
    $query = "SELECT name FROM medicines WHERE LOWER(name) LIKE LOWER(:name) AND deleted!='*' LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':name', '%' . $name . '%');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Validate medicine name
function validateMedicine($name)
{
    global $conn;
    $query = "SELECT COUNT(*) FROM medicines WHERE name = :name";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':name', $name);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Create a new medicine
function createMedicine($name, $category, $stock, $price)
{
    global $conn;
    $deleted = "";
    $query = "INSERT INTO medicines (name, category, stock, price, deleted) VALUES (:name, :category, :stock, :price, :deleted)";
    $stmt = $conn->prepare($query);
    return $stmt->execute([
        ':name' => $name,
        ':category' => $category,
        ':stock' => $stock,
        ':price' => $price,
        ':deleted' => $deleted
    ]);
}


// Update a medicine
function updateMedicine($id, $name, $category, $stock, $price)
{
    global $conn;
    $query = "UPDATE medicines SET name = :name, category = :category, stock = :stock, price = :price WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':category' => $category,
        ':stock' => $stock,
        ':price' => $price
    ]);
}

// Delete a medicine
function deleteMedicine($id)
{
    global $conn;
    $query = "DELETE FROM medicines WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}

// Soft delete action
if (isset($_GET['action']) && $_GET['action'] === 'soft_delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (softDeleteMedicine($id)) {
        echo 'success';
    } else {
        echo 'Failed to delete medicine';
    }
    exit();
}

// Soft delete a medicine
function softDeleteMedicine($id)
{
    global $conn;
    $query = "UPDATE medicines SET deleted = '*' WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}
