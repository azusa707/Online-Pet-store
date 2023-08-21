<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'petstore');
// Check if the 'cart' session array exists
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

// Handle adding products to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
  $product_id = $_POST["product_id"];
  $product_name = $_POST["product_name"];
  $product_price = $_POST["product_price"];
  $quantity = isset($_POST["quantity"]) ? (int)$_POST["quantity"] : 1;

  // If the user is not logged in, use a default user_id (e.g., 123)
  if (!$user_id) {
    $user_id = 123;
  } else {
    // If the user is logged in, retrieve the user_id from the users table
    $username = $_SESSION['username'];
    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching user is found
    if ($result && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $user_id = $row['id'];
    } else {
      // Handle the case when the user is logged in, but their information is not found in the database
      // Set a default user_id in this case
      $user_id = 123;
    }
  }

  // Add the product to the cart table in the database using prepared statement
  $stmt = $connection->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, quantity)
                         VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("iisdi", $user_id, $product_id, $product_name, $product_price, $quantity);
  $stmt->execute();
  $stmt->close();
  $newCartItem = array(
    'user_id' => $user_id,
    'product_id' => $product_id,
    'product_name' => $product_name,
    'product_price' => $product_price,
    'quantity' => $quantity
  );
  $_SESSION['cart'][] = $newCartItem;

  // Redirect back to the product page after adding the product to the cart
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit();
}
function getCartItems($user_id, $connection)
{
  $query = "SELECT * FROM cart WHERE user_id = ?";
  $stmt = $connection->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check for errors in query execution
  if (!$result) {
    echo "Error fetching cart items: " . $connection->error;
    return array(); // Return an empty array in case of error
  }

  $cart_items = array();
  while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
  }
  return $cart_items;
}

// Retrieve cart items for the logged-in user
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $cart = getCartItems($user_id, $connection);
  if (!is_array($cart)) {
    $cart = array(); // Handle case where $cart is not an array
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<?php
function calculateTotalPrice($cart)
{
  $total = 0;
  foreach ($cart as $item) {
    $total += $item['product_price'] * $item['quantity'];
  }
  return $total;
}

// Initialize the $cart variable as an empty array if it doesn't exist
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

// Handle adding items to the wishlist
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
  $product_id = $_POST["product_id"];
  $product_name = $_POST["product_name"];
  $product_price = $_POST["product_price"];
  $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;

  $item = array(
    'product_id' => $product_id,
    'product_name' => $product_name,
    'product_price' => $product_price,
    'quantity' => $quantity
  );

  // Check if the item already exists in the wishlist
  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
  } else {
    $_SESSION['cart'][$product_id] = $item;
  }
}

// Handle item removal from the wishlist
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_product_id"])) {
  $remove_product_id = $_POST["remove_product_id"];
  // Check if the product is in the cart
  if (isset($_SESSION['cart'][$remove_product_id])) {
    // Remove the product from the cart
    unset($_SESSION['cart'][$remove_product_id]);
  }
}

?>

<body>
  <main>
    <div class="basket">
      <div class="basket-labels">
        <ul>
          <li class="item item-heading">Item</li>
          <li class="price">Price</li>
          <li class="quantity">Quantity</li>
          <li class="subtotal">Subtotal</li>
        </ul>
      </div>
      <?php
      foreach ($_SESSION['cart'] as $product_id => $item) {
        $total = $item['product_price'] * $item['quantity'];
        echo '<div class="basket-product">';
        echo '<div class="item">';
       
        echo '<div class="product-details">';
        echo '<h1><strong><span class="item-quantity">' . $item['quantity'] . '</span> x ' . $item['product_name'] . '</strong></h1>';
        echo '<p><strong>Product Code - ' . $item['product_id'] . '</strong></p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="price">' . $item['product_price'] . '</div>';
        echo '<div class="quantity">';
        echo '<input type="number" value="' . $item['quantity'] . '" min="1" class="quantity-field">';
        echo '</div>';
        echo '<div class="subtotal">' . $total . '</div>';
        echo '<div class="remove">';
        echo '<form method="post" action="cart.php">';
        echo '<input type="hidden" name="remove_product_id" value="' . $product_id . '">';
        echo '<button type="submit">Remove</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
    <aside>
      <div class="summary">
        <div class="summary-total-items"><span class="total-items"><?php echo count($_SESSION['cart']); ?></span>
          Items in your wishlist</div>
        <div class="summary-subtotal">
          <div class="subtotal-title">Subtotal</div>
          <div class="subtotal-value final-value" id="basket-subtotal"><?php echo calculateTotalPrice($_SESSION['cart']); ?>
          </div>
        </div>
        <div class="summary-total">
          <div class="total-title">Total</div>
          <div class="total-value final-value" id="basket-total"><?php echo calculateTotalPrice($_SESSION['cart']); ?>
          </div>
        </div>
        <form method="get" action="../home.php">
        <div class="summary-checkout">
          <button class="checkout-cta">Go Back</button>
        </div>
    </form>
      </div>
    </aside>
  </main>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  var promoCode;
  var promoPrice;
  var fadeTime = 300;

  /* Assign actions */
  $('.quantity input').change(function() {
    updateQuantity(this);
  });

  $('.remove button').click(function() {
    removeItem(this);
  });

  $(document).ready(function() {
    updateSumItems();
  });


  /* Recalculate cart */
  function recalculateCart(onlyTotal) {
    var subtotal = 0;

    /* Sum up row totals */
    $('.basket-product').each(function() {
      subtotal += parseFloat($(this).children('.subtotal').text());
    });

    /* Calculate totals */
    var total = subtotal;

    //If there is a valid promoCode, and subtotal < 10 subtract from total
    var promoPrice = parseFloat($('.promo-value').text());
    if (promoPrice) {
      if (subtotal >= 10) {
        total -= promoPrice;
      } else {
        alert('Order must be more than £10 for Promo code to apply.');
        $('.summary-promo').addClass('hide');
      }
    }

    /*If switch for update only total, update only total display*/
    if (onlyTotal) {
      /* Update total display */
      $('.total-value').fadeOut(fadeTime, function() {
        $('#basket-total').html(total.toFixed(2));
        $('.total-value').fadeIn(fadeTime);
      });
    } else {
      /* Update summary display. */
      $('.final-value').fadeOut(fadeTime, function() {
        $('#basket-subtotal').html(subtotal.toFixed(2));
        $('#basket-total').html(total.toFixed(2));
        if (total == 0) {
          $('.checkout-cta').fadeOut(fadeTime);
        } else {
          $('.checkout-cta').fadeIn(fadeTime);
        }
        $('.final-value').fadeIn(fadeTime);
      });
    }
  }

  /* Update quantity */
  function updateQuantity(quantityInput) {
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children('.price').text());
    var quantity = $(quantityInput).val();
    var linePrice = price * quantity;

    /* Update line price display and recalc cart totals */
    productRow.children('.subtotal').each(function() {
      $(this).fadeOut(fadeTime, function() {
        $(this).text(linePrice.toFixed(2));
        recalculateCart();
        $(this).fadeIn(fadeTime);
      });
    });

    productRow.find('.item-quantity').text(quantity);
    updateSumItems();
  }

  function updateSumItems() {
    var sumItems = 0;
    $('.quantity input').each(function() {
      sumItems += parseInt($(this).val());
    });
    $('.total-items').text(sumItems);
  }

  /* Remove item from cart */
  function removeItem(removeButton) {
    /* Remove row from DOM and recalc cart total */
    var productRow = $(removeButton).parent().parent();
    productRow.slideUp(fadeTime, function() {
      productRow.remove();
      recalculateCart();
      updateSumItems();
    });
  }
</script>

</html>