<?php
include 'db.php';

// Get all medicines
function getMedicines() {
    global $conn;

    $query = "SELECT * FROM medicines WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create a new medicine
function createMedicine($name, $category, $stock, $price) {
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

// Get a single medicine by ID
function getMedicineById($id) {
    global $conn;
    $query = "SELECT id, name, category, stock, price FROM medicines WHERE id = :id AND deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update a medicine
function updateMedicine($id, $name, $category, $stock, $price) {
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
function deleteMedicine($id) {
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
function softDeleteMedicine($id) {
    global $conn;
    $query = "UPDATE medicines SET deleted = '*' WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}
?>
