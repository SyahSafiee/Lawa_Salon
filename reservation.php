<?php
session_start();
require 'db.php';

// Initialize variables to store form data
$step = isset($_POST['step']) ? $_POST['step'] : 'customer_details'; // Default to first step
$reservation_status = "";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle form submissions based on current step
switch ($step) {
    case 'customer_details':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process customer details
            $customer_name = $_POST['name'];
            $customer_email = $_POST['email'];
            
            // Store data in session
            $_SESSION['customer_name'] = $customer_name;
            $_SESSION['customer_email'] = $customer_email;

            // Move to next step
            $step = 'booking_info';
        }
        break;
    
    case 'booking_info':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process booking information
            $booking_date = $_POST['date'];
            $booking_time = $_POST['time'];
            $service = implode(', ', $_POST['service']);
            
            // Store data in session
            $_SESSION['booking_date'] = $booking_date;
            $_SESSION['booking_time'] = $booking_time;
            $_SESSION['booking_service'] = $service;

            // Move to next step
            $step = 'confirmation';
        }
        break;

    case 'confirmation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['confirm'])) {
                // Process reservation
                $username = $_SESSION['username']; // Get username from session
                $name = $_SESSION['customer_name'];
                $email = $_SESSION['customer_email'];
                $date = $_SESSION['booking_date'];
                $time = $_SESSION['booking_time'];
                $service = $_SESSION['booking_service'];

                $sql = "INSERT INTO reservations (username, name, email, date, time, service) VALUES ('$username', '$name', '$email', '$date', '$time', '$service')";

                if ($conn->query($sql) === TRUE) {
                    $reservation_status = "Reservation successful!";
                } else {
                    $reservation_status = "Error: " . $sql . "<br>" . $conn->error;
                }

                // Clear session data after reservation is processed
                unset($_SESSION['customer_name'], $_SESSION['customer_email'], $_SESSION['booking_date'], $_SESSION['booking_time'], $_SESSION['booking_service']);

                // Redirect to success page
                header("Location: success.php?status=" . urlencode($reservation_status));
                exit();
            } else {
                // If not confirmed, go back to the first step
                unset($_SESSION['customer_name'], $_SESSION['customer_email'], $_SESSION['booking_date'], $_SESSION['booking_time'], $_SESSION['booking_service']);
                $step = 'customer_details';
            }
        }
        break;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <title>Multi-Step Reservation Form</title>
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
        <h1>Make your Reservation Here!!</h1>
        <?php if ($step === 'customer_details'): ?>
        <section id="customer_details">
            <h3>Customer Details: </h3>
            <form method="post">
                <input type="hidden" name="step" value="customer_details">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Next</button>
            </form>
        </section>
        <?php elseif ($step === 'booking_info'): ?>
        <section id="booking_info">
            <h3>Booking Information: </h3>
            <form method="post">
                <input type="hidden" name="step" value="booking_info">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
                <label for="service">Service:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="service[]" value="Haircut"> Haircut</label>
                    <label><input type="checkbox" name="service[]" value="Colour"> Colour Service</label>
                    <label><input type="checkbox" name="service[]" value="Rebonding"> Rebonding</label>
                    <label><input type="checkbox" name="service[]" value="Relaxing"> Relaxing</label>
                    <label><input type="checkbox" name="service[]" value="Perm"> Perm</label>
                    <label><input type="checkbox" name="service[]" value="Brazilian keratin"> Brazilian keratin</label>
                </div>
                <button type="submit">Next</button>
            </form>
        </section>
        <?php elseif ($step === 'confirmation'): ?>
        <section id="confirmation">
            <h3>Confirmation</h3>
            <div class="confirmation-details">
                <p><strong>Name:</strong> <?php echo $_SESSION['customer_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['customer_email']; ?></p>
                <p><strong>Date:</strong> <?php echo $_SESSION['booking_date']; ?></p>
                <p><strong>Time:</strong> <?php echo $_SESSION['booking_time']; ?></p>
                <p><strong>Service(s):</strong> <?php echo $_SESSION['booking_service']; ?></p>
            </div>
            <form method="post">
                <input type="hidden" name="step" value="confirmation">
                <button type="submit" name="confirm">Confirm</button>
                <button type="submit" name="edit">Edit</button>
            </form>
        </section>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
    </footer>
</body>
</html>
