<?php
include 'db.php';

// Get all sales
function getSales()
{
    global $conn;

    $query =    "SELECT 
                s.id, m.name as medicine, s.quantity, s.total_price, s.sold_by, s.sale_date
                FROM sales s
                JOIN medicines m ON s.medicine_id = m.id 
                WHERE s.deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// count total sales
function countSales()
{
    global $conn;

    $query = "SELECT SUM(total_price) as income FROM sales WHERE deleted!='*'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Create a new sale
function createSale($medicine_name, $quantity, $total_price, $sold_by)
{
    global $conn;
    $deleted = "";

    // get medicine id
    $medQuery = "SELECT id FROM medicines WHERE name = :medicine_name";
    $stmt = $conn->prepare($medQuery);
    $stmt->bindParam(':medicine_name', $medicine_name);
    $stmt->execute();
    $medId = $stmt->fetchColumn();

    // insert sale
    $query = "INSERT INTO sales (medicine_id, quantity, total_price, sold_by, deleted) VALUES (:medicine_id, :quantity, :total_price, :sold_by, :deleted)";
    $stmt = $conn->prepare($query);
    return $stmt->execute([
        ':medicine_id' => $medId,
        ':quantity' => $quantity,
        ':total_price' => $total_price,
        ':sold_by' => $sold_by,
        ':deleted' => $deleted
    ]);
}

// Get a single sale by ID
function getSaleById($id)
{
    global $conn;
    $query = "
        SELECT 
            s.id, 
            s.medicine_id, 
            m.name AS medicine, 
            s.quantity, 
            s.total_price, 
            s.sold_by, 
            s.sale_date
        FROM 
            sales s
        JOIN 
            medicines m ON s.medicine_id = m.id 
        WHERE 
            s.id = :id 
            AND s.deleted != '*'
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update a sale
function updateSale($id, $medicine_name, $quantity, $total_price, $sold_by)
{
    global $conn;
    // get medicine id
    $medQuery = "SELECT id FROM medicines WHERE name = :medicine_name";
    $stmt = $conn->prepare($medQuery);
    $stmt->bindParam(':medicine_name', $medicine_name);
    $stmt->execute();
    $medId = $stmt->fetchColumn();

    
    $query = "UPDATE sales SET medicine_id = :medicine_id, quantity = :quantity, total_price = :total_price, sold_by = :sold_by WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([
        ':medicine_id' => $medId,
        ':quantity' => $quantity,
        ':total_price' => $total_price,
        ':sold_by' => $sold_by,
        ':id' => $id
    ]);
}

// Delete a sale
function deleteSale($id)
{
    global $conn;
    $query = "DELETE FROM sales WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}

// Soft delete action
if (isset($_GET['action']) && $_GET['action'] === 'soft_delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (softDeleteSale($id)) {
        echo 'success';
    } else {
        echo 'Failed to delete sale';
    }
    exit();
}

// Soft delete a sale
function softDeleteSale($id)
{
    global $conn;
    $query = "UPDATE sales SET deleted = '*' WHERE id = :id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}
