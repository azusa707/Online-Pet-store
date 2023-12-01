<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'petstore');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle delete operation
if (isset($_GET['delete'])) {
  $userid = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM users WHERE id = $userid");
  header('location: user.php');
  exit();
}

// Fetch users data
$selectUsers = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>User admin</title>
  <link rel="stylesheet" href="css/nav.css" type="text/css" />
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <div id="mySidenav" class="sidenav" style="background-color: #C9DBBA;">
    <p class="logo"><span>M</span>iri Store</p>

    <a href="product.php" class="icon-a subnav-toggle"><i class="fa fa-list icons"></i> Products</a>
    <a href="user.php" class="icon-a"><i class="fa fa-users icons"></i> Users</a>
    <a href="history.php" class="icon-a"><i class="fa fa-heart icons"></i> Wishlist</a>
    <a href="logout.php" class="icon-a"><i class="fa fa-sign-out-alt icons"></i> Logout</a>
  </div>
  <div id="main">
    <div class="head">
      <div class="col-div-6">
        <span style="font-size:30px;cursor:pointer; color: black;" class="nav">☰ Dashboard</span>
        <span style="font-size:30px;cursor:pointer; color: black;" class="nav2">☰ Dashboard</span>
      </div>
      <div id="blur" class="container" style="font-size: 1.5rem;">
        <div class="content">
          <table style="color:black">
            <thead>
              <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($user = mysqli_fetch_assoc($selectUsers)) {
                $userid = $user['id'];
                $username = $user['username'];
                $useremail = $user['email'];
              ?>
                <tr>
                  <td><?php echo $userid; ?></td>
                  <td><?php echo $username; ?></td>
                  <td><?php echo $useremail; ?></td>
                  <td>
                    <form action="user.php?delete=<?php echo $userid; ?>" method="post" onsubmit="return confirmDelete();">
                      <button type="submit" name="confirm_delete" class="btn">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>
                    </button>
                    </form>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
        $(".nav").click(function() {
          $("#mySidenav").css('width', '70px');
          $("#main").css('margin-left', '70px');
          $(".logo").css('visibility', 'hidden');
          $(".logo span").css('visibility', 'visible');
          $(".logo span").css('margin-left', '-10px');
          $(".icon-a").css('visibility', 'hidden');
          $(".icons").css('visibility', 'visible');
          $(".icons").css('margin-left', '-8px');
          $(".nav").css('display', 'none');
          $(".nav2").css('display', 'block');
        });

        $(".nav2").click(function() {
          $("#mySidenav").css('width', '300px');
          $("#main").css('margin-left', '300px');
          $(".logo").css('visibility', 'visible');
          $(".icon-a").css('visibility', 'visible');
          $(".icons").css('visibility', 'visible');
          $(".nav").css('display', 'block');
          $(".nav2").css('display', 'none');
        });
        $(document).ready(function() {
          $('.subnav-toggle').click(function() {
            $('.subnav').slideToggle();
          });
        });

        function confirmDelete() {
          return confirm("Are you sure you want to delete this user?");
        }
      </script>
</body>

</html>