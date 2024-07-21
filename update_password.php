<?php
session_start();
include('db.php'); 

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch user ID from session
$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirmation
    if ($new_password !== $confirm_password) {
        echo "New password and confirmation do not match.";
        exit();
    }

    // Fetch the current password from the database
    $password_query = "SELECT password FROM users WHERE username = ?";
    $password_stmt = $conn->prepare($password_query);
    $password_stmt->bind_param('s', $username);
    $password_stmt->execute();
    $password_result = $password_stmt->get_result();
    $user = $password_result->fetch_assoc();

    // Verify the current password
    if (!password_verify($current_password, $user['password'])) {
        echo "Current password is incorrect.";
        exit();
    }

    // Hash the new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_query = "UPDATE users SET password = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ss', $hashed_new_password, $username);
    $update_stmt->execute();

    echo "Password updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles5.css">
    <title>Update Password</title>
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
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="cart.php">Cart</a></li>
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
    <div id="update-password-form">
        <h2>Update Password</h2>
        <form action="update_password.php" method="POST">
            <div>
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div>
                <button type="submit">Update Password</button>
            </div>
        </form>
    </div>
</main>
<footer>
    <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
</footer>
</body>
</html>
