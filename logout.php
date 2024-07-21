<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header('Location: home.php'); // Redirect to the home page or login page
exit();
?>
