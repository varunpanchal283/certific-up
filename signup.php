<?php
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();

	include("connection.php");
	include("functions.php");
	if(isset($_GET["Message"])){
		echo '<script type="text/javascript">
			window.onload = function () { alert("Uncorrect OTP, Please Signup Again"); } 
			</script>';
	}

	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['signup']))
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$query = "CREATE TABLE IF NOT EXISTS users (user_name varchar(255) PRIMARY KEY, password varchar(255) )";
		mysqli_query($con,$query);
		
		$select = mysqli_query($con, "SELECT * FROM users WHERE user_name = '".$_POST['user_name']."'");
		if(mysqli_num_rows($select)) {

			echo '<script type="text/javascript">
			window.onload = function () { alert("This username already exists"); } 
			</script>';
			
			
		}
		else{

				//save to database
				//$query = "insert into users (user_name,password) values ('$user_name','$password')";
				$generator = "1357902468";
				$result = "";
				for ($i = 1; $i <= 4; $i++) {
        			$result .= substr($generator, (rand()%(strlen($generator))), 1);
    			}
    			$mail = new PHPMailer();

    $mail->SMTPDebug = 0;
    $mail->isSMTP();

    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'colabrdp283@gmail.com';                     //SMTP username
        $mail->Password   = 'zoembrsnnwgghdzk';                               //SMTP password
        $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('colabrdp283@gmail.com', 'CertificUp');
        $mail->addAddress($user_name);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'CertificUP Verification';
        $mail->Body    = "OTP:".$result." 
                          ";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();


				//mysqli_query($con, $query);
				$_SESSION['user']=$user_name;
				$_SESSION['pass']=$password;
				$_SESSION['otp']=$result;

				header("Location: otp.php?Message=" . urlencode($user_name));
				die;
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
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
			<h2>SIGN UP</h2>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input required id="text" type="text" name="user_name" class="login__input" placeholder="User name / Email"pattern="^[\w.+\-]+@gmail\.com$"></input>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input required id="text" type="password" name="password" class="login__input" placeholder="Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
				</div>
				<input id="button" type="submit" value="Signup" name="signup">
								
			</form>

			<a id="underline" href="login.php">  
					<button id="abc">Cancel</button>  
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
			<div style="font-size: 20px;margin: 10px;color: white;">Signup</div>

			<input required id="text" type="text" name="user_name"><br><br>
			<input id="text" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>
			
		</form>
		<a href="login.php">  
			   <button>Cancel</button>  
		</a>
	</div>
	-->
</body>
</html>