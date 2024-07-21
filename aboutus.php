<?php
session_start(); // Start the session
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <title>About Us</title>
</head>
<body>
    <!-- Header Section with Logo -->
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

    <!-- About Us Content -->
    <div class="content">
        <h1>Our Story</h1>
        <div class="story-section">
            <div class="story-text">
                <p3>LAWA was established in 2020. We are headquartered in Perlis, and have offices and stores in many parts of Malaysia.</p3>
                <br>
                <br>
                <p2>We pride ourselves on our meticulously crafted hair care products. From nourishing shampoos to styling essentials, each product blends natural goodness with cutting-edge technology for hair that shines with health and vitality. Join us at Lawa Hair Salon, where beauty, style, and great hair days are always on the menu.</p2>
            </div>
            <img src="image/story1.jpg" alt="Story Image 1">
        </div>
        <div class="story-section">
            <img src="image/story3.jpg" alt="Story Image 2">
            <div class="image/story-text">
                <p1>Offers a range of services including stylish cuts, vibrant colors, relaxing treatments, and personalized consultations. Step into our friendly space and let our skilled stylists create a look that's as unique as you are.</p1>
            </div>
        </div>
        <div class="story-section">
            <div class="story-text">
                <p>From the outset, Lawa Hair Salon set itself apart with a commitment to excellence and innovation. Our founders, inspired by a shared love for artistry and sustainability, envisioned a salon that not only transforms hair but also champions intelligent design and eco-conscious practices.</p>
                <p>At Lawa Hair Salon, sustainability isn't just a trend—it's a core value that guides every decision. We meticulously select hair care products crafted from natural, responsibly sourced ingredients, ensuring both quality results and environmental responsibility. Beyond products, our dedication to service is at the heart of what we do.</p>
                <p>Our talented team of stylists, trained in the latest techniques and trends, are passionate about creating personalized experiences. Whether it's a precision haircut, a stunning color transformation, or a soothing treatment, we believe in empowering our clients with confidence and beauty. Step into Lawa Hair Salon and experience the difference. Our inviting space, infused with creativity and warmth, welcomes you to indulge in a journey of self-expression and care. Join us in Perlis and beyond, where every visit is a testament to our commitment to intelligent design, sustainable beauty, and exceptional hair care.</p>
            </div>
            <img src="image/story4.jpg" alt="Story Image 3">
        </div>
        <p>
            Sincerely,<br>
            [Lawa Hair's Saloon]
        </p>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
    </footer>
</body>
</html>
