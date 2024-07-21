<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Successful</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('image/background.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background-color: black;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .top-bar {
            background-color: #333;
            color: white;
            padding: 10px 0;
        }

        .top-bar nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .top-bar nav ul li {
            display: inline-block;
            margin: 0 30px;
        }

        .top-bar nav ul li a {
            color: white;
            text-decoration: none;
        }

        main {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: whitesmoke;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
        }

        h1 {
            color: black;
        }
        P {
            color: black;
        }

        .confirmation-box {
            background-color: gray;
            padding: 2rem;
            border-radius: 8px;
        }

        .confirmation-box p {
            font-size: 1.2rem;
            margin: 1rem 0;
            color: greenyellow;
        }

        .button-container {
            margin-top: 2rem;
        }

        .button-container a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: greenyellow;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: skyblue;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
        }

        footer p {
            margin: 0;
            color: #666;
        }
    </style>
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
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="reservation.php">Reservation</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="login.php">Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h1>THANK YOU FOR YOUR Reservation!</h1>
        <p>PLEASE COME EARLY 5 MINUTE OF BOOKING TIME</p>
        <div class="confirmation-box">
            <p><?php echo isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'Reservation Successful!'; ?></p>
            <div class="button-container">
                <a href="home.php">Return to Home</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Lawa Hair Salon. All rights reserved.</p>
    </footer>
</body>
</html>
