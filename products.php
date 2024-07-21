<?php
session_start();
require 'db.php';

$sql = "SELECT id, name, image, price, stock FROM products";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <title>Products</title>

    <script>
        function checkLoginAndAddToCart(productId) {
            let isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
            if (!isLoggedIn) {
                alert('You need to log in first.');
                window.location.href = 'login.php';
            } else {
                addToCart(productId);
            }
        }

        function addToCart(productId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let product = products.find(p => p.id == productId);
            if (product) {
                // Check if product is in stock
                if (product.stock > 0) {
                    cart.push(product);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    alert('Product added to cart!');
                } else {
                    alert('Sorry, this product is out of stock.');
                }
            } else {
                alert('Product not found.');
            }
        }
    </script>
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
        <h1>Our Products</h1>
        <div class="product-container">
            <?php
            foreach ($products as $product) {
                echo "
                <div class='product' data-id='{$product['id']}'>
                    <img src='{$product['image']}' alt='{$product['name']}'>
                    <h3>{$product['name']}</h3>
                    <p>RM {$product['price']}</p>
                    <div class='button-container'>
                        <button onclick='checkLoginAndAddToCart({$product['id']})' " . ($product['stock'] > 0 ? '' : 'disabled') . " class='" . ($product['stock'] > 0 ? '' : 'out-of-stock') . "'>" . ($product['stock'] > 0 ? 'Add to Cart' : 'Out of Stock') . "</button>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
    </footer>
    <script>
        const products = <?php echo json_encode($products); ?>;
    </script>
</body>
</html>
