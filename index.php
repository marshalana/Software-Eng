<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGS Login</title>
    <style>
        body {
            font-family: Times New Roman, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7e6a2;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            height: 100vh;
        }

        .book-section {
            width: 50%;
            padding: 2rem;
        }

        .login-section {
            width: 40%;
            text-align: center;
            padding: 2rem;
        }

        h1 {
            font-size: 5rem;
            color: #fff;
        }

        h2 {
            font-size: 2rem;
            color: #fff;
        }

        p {
            font-size: 1.2rem;
            color: #555;
        }

        .form-group {
            margin: 1rem 0;
        }

        input[type="text"],
        input[type="password"] {
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

        .footer-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .footer-buttons button {
            width: 7rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="book-section">
            <img src="/path/to/book-image.png" alt="Book Image" style="width: 100%; height: auto;">
            <p style="text-align: center; margin-top: 1rem; font-size: 1.2rem;">This season’s featured books similar to:</p>
            <h2 style="text-align: center; color: #444;">The Essence of Software Engineering</h2>
        </div>

        <div class="login-section">
            <h1>MAGS</h1>
            <h2>Greetings, Buyer!</h2>
            <p>Marsha, Afina, Galoh, and Sofia's Secondhand Book Buying and Selling Platform</p>

            <form id="loginForm" action="login.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>

                <button type="submit">Log In</button>
            </form>

            <div class="footer-buttons">
                <button onclick="location.href='seller_login.php';">Seller</button>
                <button onclick="location.href='admin_login.php';">Admin</button>
                <button onclick="location.href='fo_login.php';">FO</button>
            </div>
        </div>
    </div>

    <script>
        // Simulate typing effect
        const usernameField = document.getElementById("username");
        const passwordField = document.getElementById("password");
        
        const typeText = (field, text, delay) => {
            let index = 0;
            const interval = setInterval(() => {
                if (index < text.length) {
                    field.value += text[index++];
                } else {
                    clearInterval(interval);
                }
            }, delay);
        };

        // Start typing the username and password
        window.onload = function () {
            typeText(usernameField, "buyer", 100); // Type 'buyer' into the username field
            setTimeout(() => typeText(passwordField, "buyer123", 100), 600); // Type 'buyer123' after the username
        };
    </script>
</body>
</html>
