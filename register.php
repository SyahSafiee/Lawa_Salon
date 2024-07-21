<?php
session_start();
require 'db.php';

// declare variables & set to empty value
$fname = $lname = $username = $email = $password = " ";
$fnameErr = $lnameErr = $usernameErr = $emailErr = $passwordErr = " ";
$signupErr = "";
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
    //first name
    if (empty($_POST["fname"])) {
        $fnameErr = "First name is required";
        $valid = false;
    }
    else {
        $fname = test_input($_POST["fname"]);
        if (!preg_match("/^[A-Za-z\s]+$/", $fname)) {
            $fnameErr = "Name must contain alphabets only";
            $valid = false;
        }
    }
    
    //last name
    if (empty($_POST["lname"])) {
        $lnameErr = "Last name is required";
        $valid = false;
    }
    else {
        $lname = test_input($_POST["lname"]);
        if (!preg_match("/^[A-Za-z\s]+$/", $lname)) {
            $lnameErr = "Name must contain alphabets only";
            $valid = false;
        }
    }

    //username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $valid = false;
    }
    else {
        $username = test_input($_POST["username"]);

        // Check if username already exists
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $usernameErr = "Username already taken";
            $valid = false;
        }
        $stmt->close();
        }

    //email
    $email = test_input($_POST["email"]);
    if (empty($_POST["email"])) {
        $passwordErr = "Email is required";
        $valid = false; 
    }
    else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }

    //password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $valid = false; 
    }
    else {
        $password = test_input($_POST["password"]);
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
            $passwordErr = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit";
            $valid = false;
        }
        
    }
    
    if ($valid) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an insert statement
        $sql = "INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $fname, $lname, $username, $email, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            header("Location: login.php");
            exit();
        } else {
            $signupErr = "Error: " . $stmt->error;
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
    
    <title>Registeration</title>
</head>

<body>
<header>
        <div class="header">
            <img src="image/logolawa.png" alt="Company Logo">
        </div>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
            <legend>Account Registeration</legend>
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" name="fname" class="user">
                <span class="error">*<?php echo $fnameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" name="lname" class="user">
                <span class="error">*<?php echo $lnameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="user">
                <span class="error">*<?php echo $usernameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="user">
                <span class="error">*<?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="user">
                <span class="error">*<?php echo $passwordErr; ?></span>
            </div>
        <div class="submit-button">    
            <button type="submit" value="Register">Register</button>
        </div>
        <br><br>
        <a href="login.php">Already have an account? Login now!</a>
        </fieldset>
        <?php if ($signupErr) echo "<p class='error'>$signupErr</p>"; ?>
    </form>
</body>
</html>