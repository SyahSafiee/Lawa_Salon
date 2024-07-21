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
    
    <title>Homepage</title>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>WELCOME TO LAWA HAIR SALOON</h1>
            <p1>Step into a world of style and rejuvenation at Lawa Hair Saloon, your premier destination for all things hair and beauty. Nestled in the heart of Perlis, our salon is more than just a place to get your hair done – it's a sanctuary where style meets relaxation.</p1>
            <br>
            <br>
            <p1>Browse through our website to explore our services, meet our talented team, and conveniently schedule your next appointment online. Join us in embracing beauty, confidence, and self-care at Lawa Hair Saloon – because you deserve to look and feel your best every day.</p1>
        </div>
        <div class="image">
            <img src="image/saloon.jpg" alt="Saloon Image">
        </div>
    </section>

    <!-- Our Store and Stockist -->
    <section class="Our-Store-and-Stockist">
    <h2>Our Store and Stockist</h2>
        <div class="content">
            <div class="image">
                <img src="image/store.jpg" alt="Store Image">
            </div>
            <div class="next-box">
                <a href="products.php" class="next-arrow">&rarr; Explore Our Products</a>
            </div>
        </div>
    </section>

    <!-- New Collection Section -->
    <section class="New-Collection">
        <h2>New Collection</h2>
    </section>

    <!-- Slideshow container -->
    <div class="slideshow-container">
        <?php
        $images = ['image/1.jpg', 'image/2.jpg', 'image/3.jpg', 'image/4.jpg'];
        foreach ($images as $index => $image) {
            echo '<div class="mySlides fade">
                    <div class="numbertext">' . ($index + 1) . ' / ' . count($images) . '</div>
                    <img src="' . $image . '" alt="Image ' . ($index + 1) . '">
                </div>';
        }
        ?>
        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <!-- The dots -->
    <div style="text-align:center">
        <?php
            for ($i = 1; $i <= count($images); $i++) {
            echo '<span class="dot" id="dot' . $i . '" onclick="currentSlide(' . $i . ')"></span>';
            }
        ?>
    </div>

    <!-- Shop Now button -->
    <div class="dots-and-button">
        <a href="products.php" class="btn-shop-now">Shop Now</a>
    </div>

    <!-- Hair Care Products Section -->
    <section class="haircaare-products">
        <h2>HAIR CARE PRODUCTS</h2>
    </section>

    <!-- Product View Section -->
    <?php
        $products = [
            ['image' => 'image/lp1.jpg', 'name' => 'LIVING PROOF dry volume & texture spray ', 'price' => 'MYR70.00'],
            ['image' => 'image/lp2.jpg', 'name' => 'LIVING PROOF perfect hair day dry shampoo', 'price' => 'MYR89.90'],
            ['image' => 'image/lp3.jpg', 'name' => 'LIVING PROOF perfect hair day advanced clean dry shampoo', 'price' => 'MYR120.00'],
            ['image' => 'image/lp4.jpg', 'name' => 'LIVING PROOF instant de-frizzer', 'price' => 'MYR89.00'],
            ['image' => 'image/lp5.jpg', 'name' => 'LIVING PROOF leave-in conditioner', 'price' => 'MYR75.00'],
        ];
    ?>

    <div class="product-container">
        <img id="product-image" class="product-image" src="<?php echo $products[0]['image']; ?>" alt="Product Image">
        <div class="product-name">
            <div id="product-name-text"><?php echo substr($products[0]['name'], strlen('LIVING PROOF')); ?></div>
        </div>
        <div class="product-price" id="product-price"><?php echo $products[0]['price']; ?></div>
        <div class="pagination">
            <div class="arrow" onclick="changeProductSlide(-1)">&#10094;</div>
            <span id="product-slide-number">1/<?php echo count($products); ?></span>
            <div class="arrow" onclick="changeProductSlide(1)">&#10095;</div>
        </div>
            <a href="products.php" class="view-all-btn">View all</a>
        </div>
        <br>
        <br>

    <footer>
        <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
    </footer>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot"); // Get all dots
    
    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }
    
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active"); // Remove active class from all dots
    }
    
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].classList.add("active"); // Add active class to current dot
}

        const products = <?php echo json_encode($products); ?>;
        let currentProductSlideIndex = 0;

        function changeProductSlide(direction) {
            currentProductSlideIndex += direction;
            if (currentProductSlideIndex >= products.length) {
                currentProductSlideIndex = 0;
            }
            if (currentProductSlideIndex < 0) {
                currentProductSlideIndex = products.length - 1;
            }
            updateProductSlide();
        }

        function updateProductSlide() {
            const product = products[currentProductSlideIndex];
            document.getElementById('product-image').src = product.image;
            document.getElementById('product-name-text').innerText = product.name;
            document.getElementById('product-price').innerText = product.price;
            document.getElementById('product-slide-number').innerText = `${currentProductSlideIndex + 1}/${products.length}`;
        }

        updateProductSlide();
    </script>   
</body>
</html>