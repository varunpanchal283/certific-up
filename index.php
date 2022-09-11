<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>
	<style type="text/css">
	*{
		margin: 0;
		padding: 0;
		font-family: Century Gothic;
	}
	
	header {
		background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(imgsrc/back2.jpg);
		height: 100vh;
		background-size: cover;
		background-position: center;
	}
	
	ul{
		float: right;
		list-style-type: none;
		margin-top: 25px;
	}
	
	ul li{
		display: inline-block;
	}
	
	ul li a{
		text-decoration: none;
		color: #fff;
		padding: 5px 20px;
		border: 1px solid transparent;
		transition: 0.6s ease;
	}
	
	ul li a:hover{
		background-color: #4da6ff;
		color: #000;
	}
	
	ul li.active a{
		background-color: #4da6ff;
		color: #000;
	}
	
	.logo img{
		float: left;
		width: 170px;
		height: auto;
		margin-top: 10px;
		margin-left: 0px;
	}
	
	.main{
		max-width: 1200px;
		margin: auto;
	}
	
	.title{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	
	.title h1{
		margin-left:15px;
		color: #fff;
		font-size: 70px;
	}
	.title h2{
		color: #fff;
		font-size: 17px;
	}
	
	
	</style>

	<header>
		
		
			<div class="main">
			<div class="logo">
				<img src="imgsrc/logo1.jpg">
			</div>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="addcert.php">Add Certificates</a></li>
				<li><a href="showcert.php">Show Certificates</a></li>
				<li class="active"><a href="logout.php">Log out</a></li>
			</ul>	
			</div>
			
			<div class="title">
				<h1>CERTIC' UP</h1>
				<h2><center>Hello, <?php echo $user_data['user_name']; ?><center> <br>Store all your Certificates in One Place.</h2>
			
			</div>
			
		

	</header>
	<hr>


	
	
</body>
</html>




<?php
function display_table(){
		
    $stmt = $con->prepare("SELECT * FROM certificates WHERE user_name = ?");
    $stmt->bind_param("s",$user_data['user_name']);
    $stmt->execute();

    while($row = mysqli_fetch_array($stmt))
      {
      echo $row['certification_id'] . " " . $row['emp_name']; //these are the fields that you have stored in your database table employee
      echo "<br />";
      }

}


?>