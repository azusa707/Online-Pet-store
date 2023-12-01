<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'petstore');

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;
    $product_category = $_POST['product_category'];

    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($product_category)) {
        $message[] = 'Please fill out all fields';
    } else {
        $insert = "INSERT INTO products (name, price, image, category) VALUES ('$product_name', '$product_price', '$product_image', '$product_category')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:product.php');
}

$product_category = isset($_POST['selected_category']) ? $_POST['selected_category'] : '';

$select = mysqli_query($conn, "SELECT * FROM products" . (!empty($product_category) ? " WHERE category = '$product_category'" : ""));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nav.css" type="text/css" />
</head>

<body>
    <div id="mySidenav" class="sidenav" style="background-color: #C9DBBA; position: fixed;">
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

            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <br />
        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '<span class="message">' . $msg . '</span>';
            }
        }
        ?>

        <div class="admin-product-form-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <h3>Add a new product</h3>
                <input type="text" placeholder="Enter product name" name="product_name" class="box">
                <input type="number" placeholder="Enter product price" name="product_price" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <select name="product_category" class="box">
                <option value="">Choose Category</option>
                    <option value="Food">Food</option>
                    <option value="Toys">Toys</option>
                    <option value="Accessories">Accessories</option>
                </select>
                <input type="hidden" name="selected_category" id="selected_category" value="<?php echo $product_category; ?>">
                <input type="submit" class="btn" name="add_product" value="Add Product">
            </form>
        </div>

        <div class="product-display">
            <div class="search-bar-container">
                <select id="filter-select" class="box">
                    <option value="none">None</option>
                    <option value="Food">Food</option>
                    <option value="Toys">Toys</option>
                    <option value="Accessories">Accessories</option>
                </select>
                <input type="text" id="search-bar" placeholder="Search..." class="box">
            </div>
            <table class="product-display-table" id="product-table">
                <thead>
                    <tr>
                        <th>Product image</th>
                        <th>Product name</th>
                        <th>Product price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                // Code to fetch data from the database
                // Replace this with your actual code to fetch data
                $select = mysqli_query($conn, "SELECT * FROM products");

                while ($row = mysqli_fetch_assoc($select)) {
                    $categoryClass = "category-" . $row['category'];
                ?>
                    <tr class="product-row <?php echo $categoryClass; ?>">
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>Rs<?php echo $row['price']; ?>/-</td>
                        <td>
                            <a href="update_product.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Edit </a>
                            <form action="product.php?delete=<?php echo $row['id']; ?>" method="post" onsubmit="return confirmDelete();">
                                <button type="submit" name="confirm_delete" class="btn">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            var filterSelect = document.getElementById("filter-select");
            var searchBar = document.getElementById("search-bar");

            function filterTable() {
                var selectedOption = filterSelect.value.toLowerCase();
                var searchText = searchBar.value.toLowerCase();

                var rows = document.getElementsByClassName("product-row");

                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    var category = row.classList.item(1).split("-")[1].toLowerCase();
                    var name = row.getElementsByTagName("td")[1].textContent.toLowerCase();

                    if ((selectedOption === "none" || category === selectedOption) && name.includes(searchText)) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                }
            }

            filterSelect.addEventListener("change", filterTable);
            searchBar.addEventListener("input", filterTable);

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
                return confirm("Are you sure you want to delete this product?");
            }
        </script>
</body>

</html>