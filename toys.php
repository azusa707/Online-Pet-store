<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'root', 'petstore');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toys</title>
    <!-- <link rel="stylesheet" href="supp.css"> -->
    <link rel="stylesheet" href="style.css">
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
      <li><a href="home.php">Contact us</a></li>
      <?php if (isset($_SESSION["username"])) { ?>
    <li>
  <a href="cart/cart.php">
    Wishlist
    <span class="wishlist-quantity">
      <?php
      $totalWishlistQuantity = 0; // Initialize the total quantity variable
      if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
          $totalWishlistQuantity += $item['quantity'];
        }
        echo $totalWishlistQuantity; // Output the total wishlist quantity
      }
      ?>
    </span>
  </a>
</li>
        <li class="right-corner"><a href="logout.php">Logout</a></li>
      <?php } else { ?>
        <li class="right-corner"><a href="login.php">Sign up/ Login</a></li>
      <?php } ?>
    </ul>
  </header>
    <h2 style="text-align:center">Toys</h2>

    <?php
    $select = mysqli_query($conn, "SELECT * FROM products WHERE category = 'Toys'");

    // Counter variable to keep track of the number of cards
    $cardCount = 0;

    // Loop through each product and generate the corresponding product card
    while ($row = mysqli_fetch_assoc($select)) {
        $productImage = "admin/uploaded_img/" . $row['image'];
        $productName = $row['name'];
        $productPrice = $row['price'];

        // Check if a new row needs to be started
        if ($cardCount % 4 === 0) {
            echo '<div class="row">';
        }
    ?>

        <div class="column">
            <div class="card">
                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" style="width: 100%">
                <h1><?php echo $productName; ?></h1>
                <p class="price">Rs<?php echo $productPrice; ?></p>
                <?php if (isset($_SESSION["username"])) { ?>
                <form action="cart/cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $productName; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $productPrice; ?>">
                    <button type="submit">Add to wishlist</button>
                </form>
            <?php } else { ?>
                <p><a href="login.php">Log in</a> to add to wishlist</p>
            <?php } ?>
            </div>
        </div>

    <?php
        // Increment the card count
        $cardCount++;

        // Check if the row needs to be closed
        if ($cardCount % 4 === 0) {
            echo '</div>';
        }
    }

    // Check if there are any remaining cards in the last row
    if ($cardCount % 4 !== 0) {
        echo '</div>';
    }
    ?>
</body>

</html>