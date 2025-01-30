<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please enter both username and password.'); window.location='index.php';</script>";
        exit();
    }

    // Fetch the user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Start the session and store user info
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the buyer's main page
        header("Location: buyer_main.php");
        exit();
    } else {
        // Invalid login
        echo "<script>alert('Invalid username or password.'); window.location='index.php';</script>";
        exit();
    }
}
?>
