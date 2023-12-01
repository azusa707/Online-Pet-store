<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "petstore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isAdmin($conn, $username, $password) {
    $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

// Authenticate the user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user is an admin
    if (isAdmin($conn, $username, $password)) {
        // Redirect to the admin panel
        header("Location: admin/product.php");
        exit();
    } else {
        // Proceed with regular user login
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Retrieve the user from the database
        $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row["password"];

            // Verify the password
            if (password_verify($password, $storedPassword)) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["welcome_message"] = "Welcome, " . $_SESSION["username"] . "!";
                header("Location: home.php"); // Redirect to the dashboard or any other page
                exit();
            } else {
                echo "Invalid password.";
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title> login/Sign up</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style2.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header id="header">
            <ul id="nav-bar">
                <li class="topnav">
                <a class="navbar-brand" href="/">
                <div class="logo-image">
                <img src="./images/logoPetStore.png" class="img-fluid" width="100" height="100">
                </div>
                </a>
                </li>
                <li><a href="home.php">Home</a></li>
                <li><a href="home.php">Supplies </a></li>
                <li><a href="#">Contact us</a></li>
                <li class="right-corner"><a href="login.php">Sign up/ Login</a></li>
            </ul>
        </header>
        <section class="container forms">
            <div class="form login">
             <div class="form-content">
                <h1>Login</h1>
                <form method="POST" action="">
              

                <div class="field input-field">
                    <input type="text" placeholder="Username" class="username" name="username" required>
                </div>

                <div class="field input-field">
                    <input type="password" placeholder="Password" class="password" name="password" required>
                   
                </div>

                <!-- <div class="form-link">
                    <a href="#" class="forgot-pass">Forgot password?</a>
                </div> -->

                <div class="field button-field">
                    <button type="submit" name="login">Login</button>
                </div>
                </form>

            <div class="form-link">
                <span>Don't have an account? <a href="signup.php" class="link signup-link">Signup</a></span>
            </div>
        </div>
    </div>
</section>
    </body>
</html>