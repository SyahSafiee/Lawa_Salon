<?php
session_start();
require 'db.php';

// declare variables & set to empty value
$username = $password = " ";
$usernameErr = $passwordErr = "";
$loginErr = "";
$valid = true;

// function to fix input & save from attacks
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// to trim the input & etc
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $valid = false;
    }
    else {
        $username = test_input($_POST["username"]);
    }

    //password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $valid = false; 
    }
    else {
        $password = test_input($_POST["password"]);
    }
    
    // If all inputs are valid
    if ($valid) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        
        // Execute the statement
        if ($stmt->execute()) {
            $stmt->store_result();
            
            // Check if username exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashedPassword);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashedPassword)) {
                        // Password is correct, so start a new session and
                        // save the username to the session
                        $_SESSION['username'] = $username;

                         // Redirect to the page that the user was trying to access
                         $redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'home.php';
                         header("Location: " . $redirectUrl);
                         exit();
                    } else {
                        // Display an error message if password is not valid
                        $loginErr = "Invalid username or password.";
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                $loginErr = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles4.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
     
    
    <title>Log In</title>
</head>

<body>
<header>
        <div class="header">
            <img src="image/logolawa.png" alt="Company Logo">
        </div>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Account Log In</legend>
            <input type="text" class="user" name="username" placeholder="Username"><required> <span class = "error">*<?php echo $usernameErr; ?></span>
            <br><br>
            <input type="password" class="user" name="password" placeholder="Password"><span class = "error">*<?php echo $passwordErr; ?></span>
            <br><br>
        <div class="submit-button">
            <button type="submit" value="Login">Log In</button>
        </div>
        <br><br>
        <a href="register.php">Don't have any account? Register now!</a>
        </fieldset>
    </form>
</body>
</html>