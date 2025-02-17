<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS - Refund Requests</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
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
            font-size: 18px;
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

        h1 {
            color: #333;
            font-size: 28px;
        }

        table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
        }

        th {
            background-color: #ffd966;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            font-family: "Times New Roman", Times, serif;
        }

        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }

        .approve-btn:hover {
            background-color: #45a049;
        }

        .dispute-btn {
            background-color: #ff5733;
            color: white;
        }

        .dispute-btn:hover {
            background-color: #e04b28;
        }

        .footer {
            background-color: #ffd966;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php
session_start();
require 'db_connect.php';

// Simulate logged-in seller name
$seller_name = "Palanichamy Naveen";

// Ensure seller is logged in
if (!isset($_SESSION['seller_id'])) {
    die("<p style='text-align:center; color:red;'>Access Denied. Please <a href='seller_login.php'>Login</a> first.</p>");
}

$seller_id = $_SESSION['seller_id'];

// Handle refund actions (Approve or Dispute)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve_refund'])) {
        $refund_id = $_POST['refund_id'];

        $sql = "UPDATE refunds SET status='Approved' WHERE refund_id=? AND seller_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$refund_id, $seller_id]);

        echo "<script>alert('Refund approved successfully!'); window.location.href='seller_refunds.php';</script>";
    }

    if (isset($_POST['dispute_refund'])) {
        $refund_id = $_POST['refund_id'];
        $reason = $_POST['reason'];

        $sql = "UPDATE refunds SET status='Disputed', reason=? WHERE refund_id=? AND seller_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$reason, $refund_id, $seller_id]);

        echo "<script>alert('Refund disputed successfully!'); window.location.href='seller_refunds.php';</script>";
    }
}

// Fetch refund requests
$sql = "SELECT * FROM refunds WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);
$refunds = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Navigation Bar -->
<div class="navbar">
    <div>
        <a href="seller_main.php">Home</a>
        <a href="seller_listings.php">Book Listings</a>
        <a href="seller_track.php">Process Orders</a>
        <a href="seller_refunds.php" class="active">Refund Response</a>
        <a href="seller_account.php">Account Management</a>
    </div>
    <div>
        Logged in as <?php echo htmlspecialchars($seller_name); ?> |
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Log out</a>
    </div>
</div>

<!-- Page Content -->
<div class="container">
    <h1>Manage Refund Requests</h1>

    <?php if (!empty($refunds)): ?>
        <table>
            <tr>
                <th>Refund ID</th>
                <th>Order ID</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($refunds as $refund): ?>
                <tr>
                    <form method="POST">
                        <td><?php echo htmlspecialchars($refund['refund_id']); ?></td>
                        <td><?php echo htmlspecialchars($refund['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($refund['status']); ?></td>
                        <td>
                            <input type="text" name="reason" value="<?php echo htmlspecialchars($refund['reason']); ?>" required>
                        </td>
                        <td>
                            <input type="hidden" name="refund_id" value="<?php echo $refund['refund_id']; ?>">
                            <button type="submit" name="approve_refund" class="btn approve-btn">Approve</button>
                            <button type="submit" name="dispute_refund" class="btn dispute-btn">Dispute</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="color: #555;">No refund requests found.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="footer">
    <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
</div>

</body>
</html>
