<?php
include 'db_connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    // Password confirmation check
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL to insert the user into the database
    $sql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$username, $email, $hashed_password, $user_type]);

        // ✅ Success Message & Redirect
        echo "<script>
                alert('Account successfully created! Redirecting to login page...');
                window.location.href = 'index.php';
              </script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS Register</title>
    <style>
        body {
            font-family: 'Times New Roman', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7e6a2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 40%;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            color: #444;
        }

        .form-group {
            margin: 1rem 0;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 90%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            background-color: #555;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h1>Register</h1>
            <p>Create your MAGS account</p>
            
            <form action="register.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>

                <div class="form-group">
                    <label for="user_type">Register as:</label>
                    <select name="user_type" required>
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>

                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="index.php">Log in</a></p>
        </div>
    </div>
</body>
</html>
