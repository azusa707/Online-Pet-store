<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title> Online Pet Store</title>
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
      <li><a href="#Supplies">Supplies </a></li>
      <li><a href="#contact">Contact us</a></li>
  <?php if (isset($_SESSION["username"])) { ?>
    <li>
  <a href="cart/cart.php">
    Cart
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
  <?php if (isset($_SESSION["welcome_message"])) { ?>
    <div class="welcome-message">
      <span><?php echo $_SESSION["welcome_message"]; ?></span>
    </div>
  <?php } ?>
  <div class="slideshow-container">

    <!-- Full-width images with number and caption text -->
    <div class="mySlides fade">
      <img src="./images/slide1.jpg" style="width:100%; border-radius: 20px; margin-top: 40px;">
    </div>

    <div class="mySlides fade">
      <img src="./images/slide2.jpg" style="width:100%; border-radius: 20px; margin-top: 40px;">
    </div>

    <div class="mySlides fade">
      <img src="./images/slide3.webp" style="width:100%; border-radius: 20px; margin-top: 40px;">
    </div>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>

  <!-- The dots/circles -->
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>

  <section id="Supplies">
    <!-- <h2 class="supplies">Supplies</h2> -->
    <div class="row">
      <div class="column">
        <div class="card">
          <img src="https://m.media-amazon.com/images/I/81ZekVKgeNL.jpg" alt="dog food" style="width:100%">
          <h1>Pet Food and Treats</h1>
          <p class="price"></p>
          <p></p>
          <a href="food.php">
            <p><button>View More</button></p>
          </a>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <img src="./images/puller_1.jpg" alt=" Toys" style="width:100%">
          <h1>Toys</h1>


          <a href="toys.php">
            <p><button>View More</button></p>
          </a>

        </div>
      </div>
      <div class="column">
        <div class="card">
          <img src="./images/bananda.jpg" alt="Accessories" style="width:100%">
          <h1>Accessories</h1>
          <a href="accessories.php">
            <p><button>View More</button></p>
          </a>
        </div>
      </div>
  </section>
  <section id="contact"></section>
  <footer>
    <section id="contact">
      <div class="f-item-con">
        <div class="app-info">
          <span class='app-name'>
            About Us
          </span>
          <p>We provides you with <strong>easy</strong> and <strong>efficient</strong> online petstore services.
            Pet store management systems are becoming increasingly popular, as pet stores seek to streamline their
            operations, improve customer experiences, and remain competitive in the market. By leveraging technology to
            manage their stores, pet store owners can save time, reduce costs, and improve their profitability.
            Additionally, these systems can provide customers with an improved shopping experience, including real-time
            inventory availability and efficient checkout processes.</p>
        </div>
        <div class="useful-links">
          <div class="footer-title">Useful Links</div>
          <ul>
            <li><a href="signin.php" style="text-decoration: none; color: white;">Sign In</a></li>
            <li><a href="supplies.php" style="text-decoration: none; color: white;">Supplies</a></li>

          </ul>
        </div>
        <div class="g-i-t">
          <div class="footer-title">Get in Touch</div>
          <div class="app-info">
            <p>Azusa Shakya <strong>98033499441</strong></p>
            
          </div>
          <!-- <form action="send_email.php" method="post" class="space-y-2">
            <input type="text" name="g-name" class="g-inp" id="g-name" placeholder='Name' />
            <input type="email" name="g-email" class="g-inp" id="g-email" placeholder='Email' />
            <textarea type="text" name="g-msg" class="g-inp h-40 resize-none" id="g-msg" placeholder='Message...'></textarea>
            <button type="submit" class='f-btn'>Submit</button>
          </form>  -->
        </div>
    </section>
  </footer>


  </section>
  <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      if (n > slides.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = slides.length
      }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
    }
  </script>
</body>

</html>