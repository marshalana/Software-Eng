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

<div class="navbar">
    <div>
        <a href="buyer_main.php">Home</a>
        <a href="buyer_orders.php">Orders</a>
        <a href="buyer_track.php">Track</a>
        <a href="buyer_refunds.php">Refund Requests</a>
        <a href="buyer_account.php">Account Management</a>
    </div>
    <div>
        <?php if ($userLoggedIn): ?>
            Logged in as <?php echo htmlspecialchars($username); ?> |
            <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Log out</a>
        <?php else: ?>
            <a href="login.php">Log in</a>
        <?php endif; ?>
    </div>
</div>


    <div class="container">
        <h1>Welcome to MAGS!</h1>
        <p>Greetings, <?php echo htmlspecialchars($username); ?>!</p>

        <div class="grid">
            <div class="card">
                <h3>Orders</h3>
                <p>View and manage your orders.</p>
                <a href="buyer_orders.php">Go to Orders</a>
            </div>
            <div class="card">
                <h3>Track Order</h3>
                <p>Track the status of your orders.</p>
                <a href="buyer_track.php">Track your Orders</a>
            </div>
            <div class="card">
                <h3>Refund Requests</h3>
                <p>Submit and manage your refund requests.</p>
                <a href="buyer_refunds.php">Refund Requests</a>
            </div>
            <div class="card">
                <h3>Account Management</h3>
                <p>Update your profile and account settings.</p>
                <a href="buyer_account.php">Manage Account</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
        <p>Connect with us: <a href="#">Facebook</a> | <a href="#">Instagram</a></p>
    </div>
</body>
</html>
