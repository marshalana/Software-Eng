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
    $userLoggedIn = true; 
    $username = "Palanichamy Naveen"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS - Process Orders</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="navbar">
    <div>
        <a href="seller_main.php">Home</a>
        <a href="seller_listings.php">Book Listings</a>
        <a href="seller_track.php" class="active">Process Orders</a>
        <a href="seller_refunds.php">Refund Response</a>
        <a href="seller_account.php">Account Management</a>
    </div>
</div>

<div class="container">
    <h1>Process Orders</h1>
    <div class="grid">
        <div class="card">
            <h3>View Orders</h3>
            <p>See new and ongoing orders.</p>
            <button class="btn">View Orders</button>
        </div>
        <div class="card">
            <h3>Update Order Status</h3>
            <p>Mark orders as shipped or delivered.</p>
            <button class="btn">Update Status</button>
        </div>
        <div class="card">
            <h3>Track Shipments</h3>
            <p>Provide tracking details for buyers.</p>
            <button class="btn">Add Tracking</button>
        </div>
    </div>
</div>

<div class="footer">
    <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
</div>

</body>
</html>
