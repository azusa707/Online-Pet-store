<?php
$conn = mysqli_connect('localhost', 'root', '', 'petstore');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $select = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
  $user = mysqli_fetch_assoc($select);

  // Return the user data as JSON response
  header('Content-Type: application/json');
  echo json_encode($user);
}
?>