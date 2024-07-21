<?php
session_start();
require 'db.php';

// Get the JSON data from the AJAX request
$cartItems = json_decode(file_get_contents('php://input'), true);

if (!empty($cartItems)) {
    $conn->begin_transaction();

    try {
        // Prepare statements for inserting into the carts table and updating the products table
        $insertStmt = $conn->prepare("INSERT INTO carts (username, product_id, total, created_at) VALUES (?, ?, ?, ?)");
        if (!$insertStmt) {
            throw new Exception("Insert statement preparation failed: " . $conn->error);
        }
        
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        if (!$updateStmt) {
            throw new Exception("Update statement preparation failed: " . $conn->error);
        }

        foreach ($cartItems as $item) {
            $username = $_SESSION['username']; 
            $productId = $item['id'];
            $quantity = 1; 
            $total = $item['price'];
            $createdAt = date('Y-m-d H:i:s');

            // Insert into the carts table
            $insertStmt->bind_param('sids', $username, $productId, $total, $createdAt);
            if (!$insertStmt->execute()) {
                throw new Exception("Insert execution failed: " . $insertStmt->error);
            }

            // Update the stock in the products table
            $updateStmt->bind_param('ii', $quantity, $productId);
            if (!$updateStmt->execute()) {
                throw new Exception("Update execution failed: " . $updateStmt->error);
            }
        }

        // Commit the transaction
        $conn->commit();
        $insertStmt->close();
        $updateStmt->close();
        $conn->close();
        
        http_response_code(200); // Success
    } catch (Exception $e) {
        // Roll back the transaction if something failed
        $conn->rollback();
        $conn->close();
        
        error_log($e->getMessage());
        http_response_code(500); // Internal Server Error
    }
} else {
    http_response_code(400); // Bad request
}
?>

