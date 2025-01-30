<?php
$host = "localhost";      // If using XAMPP/WAMP, leave as "localhost"
$dbname = "database_mags"; // Your database name
$username = "root";       // Default username for XAMPP/WAMP is "root"
$password = "";           // Default password is empty for XAMPP/WAMP

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
