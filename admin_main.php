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
        <a href="admin_main.php">Home</a>
        <a href="admin_listings.php">Manage Book Listings</a>
        <a href="admin_account.php">Account Management</a>
        <a href="admin_monitorrefund.php">Refund Monitoring</a>
        <a href="admin_userqueries.php">Manage Queries</a>
        
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
        <h1><p>Greetings, Admin <?php echo htmlspecialchars($username); ?>!</p></h1>
        
        <div class="grid">
            <div class="card">
                <h3>Oversee Book Listings</h3>
                <p>Verify, Monitor, and Oversee book listings.</p>
                <a href="admin_listings.php">Review Book Listings</a>
            </div>
            <div class="card">
                <h3>User Account Management</h3>
                <p>Manage the accounts of Buyers and Sellers.</p>
                <a href="admin_account.php">Manage Account</a>
            </div>
            <div class="card">
                <h3>Monitor Return and Refund Requests</h3>
                <p>Verify the validaty of the return and refund requests.</p>
                <a href="admin_monitorrefund.php">Oversee Return and Refund Requests</a>
            </div>
            <div class="card">
                <h3>Manage Basic User Queries</h3>
                <p>Address user's Frequently Asked Questions (FAQs).</p>
                <a href="admin_userqueries.php">Resolve Basic User Concerns</a>
            </div>   
        </div>
    </div>

    <div class="footer">
        <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
        <p>Connect with us: <a href="#">Facebook</a> | <a href="#">Instagram</a></p>
    </div>
</body>
</html>
