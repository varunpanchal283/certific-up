<?php 

session_start();

	include("connection.php");
	include("functions.php");

	if(isset($_GET['Message'])){
		echo '<script type="text/javascript">
			window.onload = function () { alert("Succesfully Register"); } 
			</script>';	
	}
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted

		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{
			$query = "CREATE TABLE IF NOT EXISTS users (user_name varchar(255) PRIMARY KEY, password varchar(255) )";
			mysqli_query($con,$query);
			$query = "select * from users where user_name = '$user_name'";
			$result = mysqli_query($con, $query);
			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);

					
					if($user_data['password'] === $password)
					{
						if($user_data['user_name'] == "admin@gmail.com"){
						$_SESSION['user_name'] = $user_data['user_name'];
						header("Location: admin.php");
						die;	
						}
						else{	
						$_SESSION['user_name'] = $user_data['user_name'];
						header("Location: index.php");
						die;}
					}
				}
			}
			echo '<script type="text/javascript">
			window.onload = function () { alert("wrong username or password!"); } 
			</script>';
			
		}

		else
		{
			echo "wrong username or password!";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

	<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');
	
	* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
	}

	
	body {
	background: linear-gradient(90deg, #b3c6ff, #3366ff);		
	}
	
	.container {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {		
	background: linear-gradient(90deg, #0052cc, #1a75ff);		
	position: relative;	
	height: 600px;
	width: 500px;	
	box-shadow: 0px 0px 24px #0066ff;
}

.screen__content {
	z-index: 1;
	position: relative;	
	height: 100%;
}

.screen__background {		
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 0;
	-webkit-clip-path: inset(0 0 0 0);
	clip-path: inset(0 0 0 0);	
}

.screen__background__shape {
	transform: rotate(20deg);
	position: absolute;
}

.screen__background__shape1 {
	height: 500px;
	width: 500px;
	background: #FFF;	
	top: -50px;
	right: 120px;	
	border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
	height: 220px;
	width: 220px;
	background: #0052cc;	
	top: -172px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape3 {
	height: 540px;
	width: 190px;
	background: linear-gradient(270deg, #0052cc, #4d94ff);
	top: -24px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape4 {
	height: 400px;
	width: 200px;
	background: #0047b3;	
	top: 420px;
	right: 50px;	
	border-radius: 60px;
}

.login {
	width: 320px;
	padding: 30px;
	padding-top: 50px;
}

.login__field {
	padding: 20px 0px;	
	position: relative;	
}

.login__icon {
	position: absolute;
	top: 30px;
	color: #1a75ff;
}

.login__input {
	border: none;
	border-bottom: 2px solid #0052cc;
	background: none;
	padding: 10px;
	padding-left: 24px;
	font-weight: 700;
	width: 75%;
	transition: .2s;
}

.login__input:active,
.login__input:focus,
.login__input:hover {
	outline: none;
	border-bottom-color: #0052cc;
}

.login__submit {
	background: #fff;
	font-size: 14px;
	margin-top: 30px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #0052cc;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #4C489D;
	box-shadow: 0px 2px 2px #5C5696;
	cursor: pointer;
	transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
	border-color: #0052cc;
	outline: none;
}

.button__icon {
	font-size: 24px;
	margin-left: auto;
	color: #0052cc;
}

.social-login {	
	position: absolute;
	height: 140px;
	width: 160px;
	text-align: center;
	bottom: 0px;
	right: 0px;
	color: #fff;
}

.social-icons {
	display: flex;
	align-items: center;
	justify-content: center;
}

.social-login__icon {
	padding: 20px 10px;
	color: #fff;
	text-decoration: none;	
	text-shadow: 0px 0px 8px #7875B5;
}

.social-login__icon:hover {
	transform: scale(1.5);	
}

	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}
	#pp{
		margin-left: 35px;
	}
	#abc{
		background: #fff;
	font-size: 14px;
	margin-top: 0px;
	margin-left: 35px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 53%;
	color: #0052cc;
	box-shadow: 0px 2px 2px #5C5696;
	cursor: pointer;
	transition: .2s;
	}
	#underline {
            text-decoration: none;
        }

	#button{

		background: #fff;
	font-size: 14px;
	margin-top: 5px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #0052cc;
	box-shadow: 0px 2px 2px #0052cc;
	cursor: pointer;
	transition: .2s;
	}
	

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>
	
	<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" method ="post">
			<h2>LOG IN</h2>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input required type="text" id="text" name="user_name" class="login__input" placeholder="User name / Email">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input required id="text" type="password" name="password" class="login__input" placeholder="Password">
				</div>
				
				<input id="button" type="submit" value="Login"><br><br>
				
								
			</form>
			
			
			<p id="pp">Not Registered? Register Now.</p>
			<a id="underline" href="signup.php">  
					<button id="abc">Sign Up</button>  
			</a>
			
		
			
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>

<!--
	<div id="box">
		
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Login</div>

			<input id="text" type="text" name="user_name"><br><br>
			<input id="text" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Login"><br><br>

		</form>
		<a href="signup.php">  
			   <button>Sign Up</button>  
		</a>
	</div>
	-->
</body>
</html>