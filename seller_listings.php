<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS - Main Screen</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Times, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f5d7;
        }

        .navbar {
            background-color: #ffd966;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #fff;
        }

        .container {
            text-align: center;
            padding: 50px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 800px;
            margin: auto;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .footer {
            background-color: #ffd966;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            margin: 0 5px;
        }
    </style>
</head>
<body>
<?php 
        // Simulating a logged-in user
        $userLoggedIn = true; 
        $username = "Palanichamy Naveen"; // Sample username
    ?>
<?php
session_start();
require 'db_connect.php'; // Include database connection

// Check if seller is logged in
if (!isset($_SESSION['seller_id'])) {
    die("Access Denied. Please <a href='seller_login.php'>Login</a> first.");
}

$seller_id = $_SESSION['seller_id'];
$seller_name = $_SESSION["Palanichamy Naveen"];

// Handle book actions (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_book'])) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $isbn = $_POST['isbn'];
        $description = $_POST['description'];

        $sql = "INSERT INTO book_listings (seller_id, title, price, isbn, description, status) 
                VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$seller_id, $title, $price, $isbn, $description]);

        echo "<script>alert('Book added successfully!'); window.location.href='seller_listings.php';</script>";
    }

    if (isset($_POST['edit_book'])) {
        $listing_id = $_POST['listing_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $isbn = $_POST['isbn'];
        $description = $_POST['description'];

        $sql = "UPDATE book_listings SET title=?, price=?, isbn=?, description=? 
                WHERE listing_id=? AND seller_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $price, $isbn, $description, $listing_id, $seller_id]);

        echo "<script>alert('Book listing updated successfully!'); window.location.href='seller_listings.php';</script>";
    }

    if (isset($_POST['delete_book'])) {
        $listing_id = $_POST['listing_id'];

        $sql = "DELETE FROM book_listings WHERE listing_id=? AND seller_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$listing_id, $seller_id]);

        echo "<script>alert('Book listing deleted successfully!'); window.location.href='seller_listings.php';</script>";
    }
}

// Fetch book listings for the logged-in seller
$sql = "SELECT * FROM book_listings WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS - Book Listings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div>
        <a href="seller_main.php">Home</a>
        <a href="seller_listings.php" class="active">Book Listings</a>
        <a href="seller_track.php">Process Orders</a>
        <a href="seller_refunds.php">Refund Response</a>
        <a href="seller_account.php">Account Management</a>
    </div>
    <div>
        Logged in as <?php echo htmlspecialchars($seller_name); ?> |
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Log out</a>
    </div>
</div>

<!-- Page Content -->
<div class="container">
    <h1>Manage Your Book Listings</h1>

    <!-- Add New Book Form -->
    <div class="card">
        <h3>Add New Book</h3>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required>
            <input type="number" name="price" step="0.01" placeholder="Price" required>
            <input type="text" name="isbn" placeholder="ISBN" required>
            <textarea name="description" placeholder="Book Description" required></textarea>
            <button type="submit" name="add_book">Add Book</button>
        </form>
    </div>

    <!-- Book Listings Table -->
    <h2>Your Listings</h2>
    <table border="1" cellpadding="10" width="100%">
        <tr>
            <th>Title</th>
            <th>Price</th>
            <th>ISBN</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <form method="POST">
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>"></td>
                    <td><input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($book['price']); ?>"></td>
                    <td><input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>"></td>
                    <td><textarea name="description"><?php echo htmlspecialchars($book['description']); ?></textarea></td>
                    <td>
                        <input type="hidden" name="listing_id" value="<?php echo $book['listing_id']; ?>">
                        <button type="submit" name="edit_book">Save Changes</button>
                        <button type="submit" name="delete_book" onclick="return confirm('Are you sure?');">Delete</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- Footer -->
<div class="footer">
    <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
</div>

</body>
</html>
