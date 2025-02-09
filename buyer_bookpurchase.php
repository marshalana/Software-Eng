<?php
session_start();
require 'db_connection.php'; // Ensure this file is correctly set up

// Mock user session (Replace with actual authentication system)
$buyer_ID = $_SESSION['buyer_ID'] ?? 1;

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to search books
function searchBooks($conn, $book_title)
{
    $query = "SELECT * FROM books WHERE title LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$book_title%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to add item to cart
function addToCart($book_ID, $quantity)
{
    $_SESSION['cart'][$book_ID] = ($quantity > 0) ? $quantity : 1;
}

// Function to remove item from cart
function removeFromCart($book_ID)
{
    unset($_SESSION['cart'][$book_ID]);
}

// Function to process checkout
function checkout($conn, $buyer_ID, $payment_info)
{
    if (empty($_SESSION['cart'])) {
        return "Cart is empty!";
    }

    // Simulate payment verification (Assume success)
    $payment_verified = true;

    if ($payment_verified) {
        foreach ($_SESSION['cart'] as $book_ID => $quantity) {
            $stmt = $conn->prepare("INSERT INTO orders (buyer_ID, book_ID, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $buyer_ID, $book_ID, $quantity);
            $stmt->execute();
        }

        $_SESSION['cart'] = []; // Clear cart after order
        return "Order placed successfully!";
    } else {
        return "Payment failed!";
    }
}

// Handling form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        $books = searchBooks($conn, $_POST['book_title']);
    } elseif (isset($_POST['add_to_cart'])) {
        addToCart($_POST['book_ID'], $_POST['quantity']);
    } elseif (isset($_POST['remove_from_cart'])) {
        removeFromCart($_POST['book_ID']);
    } elseif (isset($_POST['checkout'])) {
        $message = checkout($conn, $buyer_ID, $_POST['payment_info']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Purchase</title>
    <link rel="stylesheet" href="styles.css"> <!-- Reuse the same CSS from buyer_main.php -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 15px;
        }
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .cart-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="buyer_main.php">Home</a>
    <a href="buyer_bookpurchase.php">Book Purchase</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Search for Books</h2>
    <form method="POST">
        <input type="text" name="book_title" placeholder="Enter book title">
        <button type="submit" name="search" class="button">Search</button>
    </form>

    <?php if (isset($books)): ?>
        <h3>Search Results</h3>
        <ul>
            <?php while ($row = $books->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['title']); ?> - $<?php echo $row['price']; ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="book_ID" value="<?php echo $row['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add_to_cart" class="button">Add to Cart</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <h2>Shopping Cart</h2>
    <ul>
        <?php foreach ($_SESSION['cart'] as $book_ID => $quantity): ?>
            <li class="cart-item">
                Book ID: <?php echo $book_ID; ?> | Quantity: <?php echo $quantity; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="book_ID" value="<?php echo $book_ID; ?>">
                    <button type="submit" name="remove_from_cart" class="button">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Checkout</h2>
    <form method="POST">
        <input type="text" name="payment_info" placeholder="Enter payment details">
        <button type="submit" name="checkout" class="button">Proceed to Checkout</button>
    </form>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</div>
<div class="footer">
        <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
        <p>Connect with us: <a href="#">Facebook</a> | <a href="#">Instagram</a></p>
    </div>
<script src="script.js"></script> <!-- Include any JavaScript if needed -->
</body>
</html>

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

<div class="footer">
        <p>Terms of Service | Privacy Policy | Return & Refund Policy</p>
        <p>Connect with us: <a href="#">Facebook</a> | <a href="#">Instagram</a></p>
    </div>