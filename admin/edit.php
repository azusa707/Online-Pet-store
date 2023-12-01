<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'petstore');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $select = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    $row = mysqli_fetch_assoc($select);

    if (isset($_POST['update_users'])) {
        $username = $_POST['username'];
        $useremail = $_POST['email'];

        if (empty($username) || empty($useremail)) {
            $message = 'Please fill out all fields!';
        } else {
            $update_data = "UPDATE users SET username='$username', email='$useremail' WHERE id = '$id'";
            $upload = mysqli_query($conn, $update_data);

            if ($upload) {
                $update_success = true;
            } else {
                $message = 'Could not update the user';
            }
        }
    

        header('location: user.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/nav.css" type="text/css"/>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Edit User</h2>
            <form action="edit.php?edit=<?php echo $id; ?>" method="post">
                <input type="text" class="box" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter the username">
                <input type="email" class="box" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter the email">
                <input type="submit" value="Update User" name="update_users" class="btn">
            </form>
        </div>
    </div>
</body>
</html>