<?php
session_start();
require 'db_connect.php'; // Database connection

// Ensure seller is logged in
if (!isset($_SESSION['seller_id'])) {
    die("<p style='color: red; text-align: center;'>Access Denied. Please <a href='seller_login.php'>Login</a> first.</p>");
}

$seller_id = $_SESSION['seller_id'];
$seller_name = "Palanichamy Naveen"; // Hardcoded to ensure correct name display

// Handle Order Actions (Add, Update, Track)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['place_order'])) {
        $buyer_id = $_POST['buyer_id'];
        $book_id = $_POST['book_id'];
        $status = 'Processing';
        $tracking_number = NULL;

        $sql = "INSERT INTO orders (buyer_id, seller_id, book_id, status, tracking_number) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$buyer_id, $seller_id, $book_id, $status, $tracking_number]);

        echo "<script>alert('Order placed successfully!'); window.location.href='seller_track.php';</script>";
    }

    if (isset($_POST['update_order'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        $sql = "UPDATE orders SET status=? WHERE order_id=? AND seller_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$status, $order_id, $seller_id]);

        echo "<script>alert('Order status updated successfully!'); window.location.href='seller_track.php';</script>";
    }
}

// Fetch orders for this seller with book titles
$sql = "SELECT o.order_id, o.buyer_id, b.title AS book_title, o.status, o.tracking_number 
        FROM orders o 
        JOIN book_listings b ON o.book_id = b.listing_id 
        WHERE o.seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch books for dropdown selection
$sql_books = "SELECT listing_id, title FROM book_listings WHERE seller_id = ?";
$stmt_books = $conn->prepare($sql_books);
$stmt_books->execute([$seller_id]);
$books = $stmt_books->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MAGS - Process Orders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Times New Roman', sans-serif;
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
            padding: 30px;
        }

        .table-container {
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ffd966;
            color: #333;
        }

        .btn {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-add {
            background-color: #4CAF50;
            color: white;
        }

        .btn-add:hover {
            background-color: #45a049;
        }

        .btn-update {
            background-color: #008CBA;
            color: white;
        }

        .btn-update:hover {
            background-color: #007bb5;
        }

        .footer {
            background-color: #ffd966;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div>
        <a href="seller_main.php">Home</a>
        <a href="seller_listings.php">Book Listings</a>
        <a href="seller_track.php" class="active">Process Orders</a>
        <a href="seller_refunds.php">Refund Response</a>
        <a href="seller_account.php">Account Management</a>
    </div>
    <div>
        Logged in as <?php echo htmlspecialchars($seller_name); ?> |
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Log out</a>
    </div>
</div>

<div class="container">
    <h1>Manage Your Orders</h1>

    <!-- Order Placement -->
    <div class="table-container">
        <h2>Place a New Order</h2>
        <form method="POST">
            <input type="number" name="buyer_id" placeholder="Buyer ID" required>
            <select name="book_id" required>
                <option value="">Select a Book</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?php echo $book['listing_id']; ?>"><?php echo htmlspecialchars($book['title']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="place_order" class="btn btn-add">Place Order</button>
        </form>
    </div>

    <!-- Order Management -->
    <div class="table-container">
        <h2>Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Buyer ID</th>
                <th>Book Title</th>
                <th>Status</th>
                <th>Tracking</th>
                <th>Actions</th>
            </tr>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <form method="POST">
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['buyer_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['book_title']); ?></td>
                            <td>
                                <select name="status">
                                    <option value="Processing" <?php echo ($order['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Shipped" <?php echo ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="Delivered" <?php echo ($order['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                </select>
                            </td>
                            <td><input type="text" name="tracking_number" value="<?php echo htmlspecialchars($order['tracking_number']); ?>" placeholder="Enter Tracking No."></td>
                            <td>
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <button type="submit" name="update_order" class="btn btn-update">Update Status</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="color: red;">No orders found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
</div>

</body>
</html>
