<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['type'])) {
    $id = $data['id'];
    $type = $data['type'];

    if ($type === 'order') {
        // Cancel an order
        $stmt = $conn->prepare("DELETE FROM carts WHERE id = ? AND username = ?");
        $stmt->bind_param('is', $id, $_SESSION['username']);
    } elseif ($type === 'reservation') {
        // Cancel a reservation
        $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ? AND username = ?");
        $stmt->bind_param('is', $id, $_SESSION['username']);
    } else {
        echo "Invalid type.";
        exit();
    }

    if ($stmt->execute()) {
        echo ucfirst($type) . " cancelled successfully.";
    } else {
        echo "Failed to cancel the " . $type . ".";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
