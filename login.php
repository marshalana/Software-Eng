<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Placeholder for authentication logic
    // Hardcoded users for demo: buyer, admin, seller, and finance officer (FO)
    if ($username === 'buyer' && $password === 'buyer123') {
        // Set session variable for buyer
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'buyer'; // Store role in session

        // Redirect to the buyer's main screen
        header("Location: buyer_main.php");
        exit();
    } elseif ($username === 'admin' && $password === 'admin123') {
        // Set session variable for admin
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin'; // Store role in session

        // Redirect to the admin's main screen
        header("Location: admin_main.php");
        exit();
    } elseif ($username === 'seller' && $password === 'seller123') {
        // Set session variable for seller
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'seller'; // Store role in session

        // Redirect to the seller's main screen
        header("Location: seller_main.php");
        exit();
    } elseif ($username === 'financeofficer' && $password === 'financeofficer123') {
        // Set session variable for finance officer
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'fo'; // Store role in session

        // Redirect to the finance officer's main screen
        header("Location: fo_main.php");
        exit();
    } else {
        // Show an alert and redirect back to the login page on failure
        echo "<script>
            alert('Invalid username or password.');
            location.href='buyer_login.php';
        </script>";
    }

    session_start();
$_SESSION['username'] = $username; // Set username
header("Location: buyer_main.php");
exit();

}
?>
