<?php
session_start(); // Start the session
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles4.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>Cart</title>
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
    <h2>Products in your Cart</h2>
    <div id="cartItems" class="cart-container">
        <!-- Cart items will be injected here by JavaScript -->
    </div>
    <div class="checkout-button-container">
        <button onclick="checkout()">Checkout</button>
    </div>
</main>
<footer>
    <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
</footer>
<script>
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    function displayCartItems() {
        const cartContainer = document.getElementById('cartItems');
        cartContainer.innerHTML = ''; // Clear existing content
        let total = 0;

        // Append cart items
        cartItems.forEach(item => {
            total += parseFloat(item.price);
            cartContainer.innerHTML += `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <h3>${item.name}</h3>
                    <p>RM ${item.price}</p>
                    <div class="button-container">
                        <button onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            `;
        });

        // Append total price after all items
        const totalElement = document.createElement('div');
        totalElement.className = 'total-amount';
        totalElement.textContent = `Total: RM ${total.toFixed(2)}`;
        
        cartContainer.appendChild(totalElement);
    }

    function removeFromCart(productId) {
        const index = cartItems.findIndex(item => item.id == productId);
        if (index !== -1) {
            cartItems.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cartItems));
            displayCartItems();
        }
    }

    function checkout() {
        if (cartItems.length > 0) {
            fetch('save_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(cartItems),
            })
            .then(response => {
                if (response.ok) {
                    alert('Checkout successful!');
                    localStorage.removeItem('cart');
                    displayCartItems();
                } else {
                    alert('Checkout failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Checkout failed. Please try again.');
            });
        } else {
            alert('Your cart is empty.');
        }
    }

    displayCartItems();
</script>
</body>
</html>
