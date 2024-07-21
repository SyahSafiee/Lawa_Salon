<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch user's carts
$cartsQuery = "SELECT carts.id, products.name, products.price, products.image, carts.created_at 
                FROM carts 
                JOIN products ON carts.product_id = products.id 
                WHERE carts.username = ?";
$cartsStmt = $conn->prepare($cartsQuery);

if (!$cartsStmt) {
    die("Preparation failed for carts: " . $conn->error);
}

$cartsStmt->bind_param('s', $username);
$cartsStmt->execute();
$cartsResult = $cartsStmt->get_result();

// Fetch user's reservations
$reservationsQuery = "SELECT id, date AS reservation_date, service AS details 
                      FROM reservations 
                      WHERE username = ?";
$reservationsStmt = $conn->prepare($reservationsQuery);

if (!$reservationsStmt) {
    die("Preparation failed for reservations: " . $conn->error);
}

$reservationsStmt->bind_param('s', $username);
$reservationsStmt->execute();
$reservationsResult = $reservationsStmt->get_result();

$cartsStmt->close();
$reservationsStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles5.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>Customer Dashboard</title>
</head>
<body>
<header>
    <div class="header">
        <img src="image/logolawa.png" alt="Company Logo">
    </div>
    <div class="top-bar">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Log out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log in</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main>
    <!-- Add link to update password -->
    <h2>Account Settings</h2>
    <div id="account-settings" class="settings-section">
        <a href="update_password.php" class="btn">Update Password</a>
    </div>

    <h2>My Orders</h2>
    <div id="carts">
        <?php if ($cartsResult->num_rows > 0): ?>
            <?php while ($order = $cartsResult->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['name']); ?>">
                    <h3><?php echo htmlspecialchars($order['name']); ?></h3>
                    <p>RM <?php echo htmlspecialchars($order['price']); ?></p>
                    <p>Ordered on: <?php echo htmlspecialchars($order['created_at']); ?></p>
                    <button onclick="cancelItem(<?php echo $order['id']; ?>, 'order')">Cancel Order</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <h2>My Reservations</h2>
    <div id="reservations">
        <?php if ($reservationsResult->num_rows > 0): ?>
            <?php while ($reservation = $reservationsResult->fetch_assoc()): ?>
                <div class="reservation-item">
                    <p>Date: <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
                    <p>Details: <?php echo htmlspecialchars($reservation['details']); ?></p>
                    <button onclick="cancelItem(<?php echo $reservation['id']; ?>, 'reservation')">Cancel Reservation</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No reservations found.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
</footer>
<script>
    function cancelItem(id, type) {
        if (confirm('Are you sure you want to cancel this ' + type + '?')) {
            fetch('cancel.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id, type: type }),
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                location.reload(); // Reload the page to update the list
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to cancel the ' + type + '. Please try again.');
            });
        }
    }
</script>
</body>
</html>