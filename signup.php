<?php
session_start(); // Start the session

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "petstore"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Check if the username is already taken
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username is already taken.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
        if ($conn->query($sql) === TRUE) {
            // Store the username in the session
            $_SESSION["username"] = $username;
            echo "Registration successful.";

            // Redirect to a logged-in page
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>login/Sign up</title>
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
      <li><a href="#Supplies">Supplies </a></li>
      <li><a href="#">Pet services</a></li>
      <li><a href="#">Contact us</a></li>
      <li class="right-corner"><a href="login.php">Sign up/ Login</a></li>
    </ul>
    </header>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <h1>Signup</h1>
                <form method="POST" action="">
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email" required>
                    </div>
                    <div class="field input-field">
                        <input type="text" placeholder="Username" class="username" name="username" required>
                    </div>
                    <div class="field input-field">
                        <input type="password" placeholder="Create Password" class="password" name="password" required>
                    </div>
                    <div class="field button-field">
                        <button type="submit" name="register">Signup</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Already have an account? <a href="login.php" class="link signup-link">Login</a></span>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>