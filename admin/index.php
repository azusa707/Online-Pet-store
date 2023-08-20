<?php
$conn = mysqli_connect('localhost', 'root', '', 'petstore');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$selectUsers = mysqli_query($conn, "SELECT * FROM users");
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Check if the delete confirmation form is submitted
    if (isset($_POST['confirm_delete'])) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $id");
        header('location: index.php');
    }
}
?>
<!Doctype HTML>
	<html>
	<head>
		<title></title>
		<meta http-equiv="Cache-control" content="no-cache">
		<link rel="stylesheet" href="css/nav.css" type="text/css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>


	<body>
		
		<div id="mySidenav" class="sidenav" style="background-color: #C9DBBA;">
		<p class="logo"><span>M</span>iri Store</p>
	  <a href="#" class="icon-a"><i class="fa fa-dashboard icons"></i>   Dashboard</a>
	  <a href="user.php"class="icon-a"><i class="fa fa-users icons"></i>   Users</a>
	  <a href="product.php" class="icon-a subnav-toggle"><i class="fa fa-list icons"></i> Products</a>
	
	  
	</div>
	<div id="main">

		<div class="head">
			<div class="col-div-6">
	<span style="font-size:30px;cursor:pointer; color: black;" class="nav"  >☰ Dashboard</span>
	<span style="font-size:30px;cursor:pointer; color: black;" class="nav2"  >☰ Dashboard</span>
	</div>
		
		<div class="clearfix"></div>
	</div>

		<div class="clearfix"></div>
		<br/>
		
		<div class="col-div-3">
			<div class="box">
				<p>40<br/><span>Customers</span></p>
				<i class="fa fa-users box-icon"></i>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box">
				<p>88<br/><span>Projects</span></p>
				<i class="fa fa-list box-icon"></i>
			</div>
		</div>
		<!-- <div class="col-div-3">
			<div class="box">
				<p>99<br/><span>Orders</span></p>
				<i class="fa fa-shopping-bag box-icon"></i>
			</div>
		</div> -->
		<!-- <div class="col-div-3">
			<div class="box">
				<p>78<br/><span>Tasks</span></p>
				<i class="fa fa-tasks box-icon"></i>
			</div> -->
		</div>
		<!-- <div class="clearfix"></div>
		<br/><br/>
		<div class="col-div-8">
			<div class="box-8">
			<div class="content-box">
				
			</div>
		</div>
		</div> -->

		<!-- <div class="col-div-4">
			<div class="box-4">
			<div class="content-box">
				<p>Total Sale <span>Sell All</span></p>

				<div class="circle-wrap">
	    <div class="circle">
	      <div class="mask full">
	        <div class="fill"></div>
	      </div>
	      <div class="mask half">
	        <div class="fill"></div>
	      </div>
	      <div class="inside-circle"> 70% </div>
	    </div>
	  </div>
			</div>
		</div>
		</div> -->
			
		<!-- <div class="clearfix"></div>
	</div> -->


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>

	  $(".nav").click(function(){
	    $("#mySidenav").css('width','70px');
	    $("#main").css('margin-left','70px');
	    $(".logo").css('visibility', 'hidden');
	    $(".logo span").css('visibility', 'visible');
	     $(".logo span").css('margin-left', '-10px');
	     $(".icon-a").css('visibility', 'hidden');
	     $(".icons").css('visibility', 'visible');
	     $(".icons").css('margin-left', '-8px');
	      $(".nav").css('display','none');
	      $(".nav2").css('display','block');
	  });

	$(".nav2").click(function(){
	    $("#mySidenav").css('width','300px');
	    $("#main").css('margin-left','300px');
	    $(".logo").css('visibility', 'visible');
	     $(".icon-a").css('visibility', 'visible');
	     $(".icons").css('visibility', 'visible');
	     $(".nav").css('display','block');
	      $(".nav2").css('display','none');
	 });
    $(document).ready(function() {
        $('.subnav-toggle').click(function() {
            $('.subnav').slideToggle();
        });
    });
	</script>

	</body>


	</html>