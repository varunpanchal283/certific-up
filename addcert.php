<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
	
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$ename = $_POST['ename'];
		$csp = $_POST['csp'];
		$certlevel = $_POST['certlevel'];
		$certname = $_POST['certname'];
		$certid = $_POST['certid'];	
		$dateofcert = $_POST['dateofcert'];
		$expiry = $_POST['expiry'];

		$query = "SELECT * FROM certificates WHERE certification_id='". $certid ."' AND user_name='". $user_data['user_name'] ."'";
		$res=mysqli_query($con,$query);
		if(mysqli_num_rows($res) == 1){
			echo '<script type="text/javascript">
       window.onload = function () { alert("Data Already Exists"); } 
</script>';

		
		}
else{
		$stmt = $con->prepare("INSERT INTO certificates VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssss",$certid,$user_data['user_name'],$ename,$csp,$certlevel,$certname,$dateofcert,$expiry);
		$stmt->execute();
		$res=$stmt->get_result();

	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';

	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\SMTP;
	//use PHPMailer\PHPMailer\Exception;

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
	    $mail->addAddress($user_data['user_name']);     //Add a recipient
	    //$mail->addAddress('ellen@example.com');               //Name is optional
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

	    //Content
	    $mail->isHTML(true);                                  //Set email format to HTML
	    $mail->Subject = 'CertificUP Update';
	    $mail->Body    = "The Below Certificate Details were added<br>
	    				  Employee Name:'". $ename ."'<br>
	    				  Certification Name:'". $certname ."'<br>
	    				  Certification ID:'". $certid ."'<br>
	    				  CSP:'". $csp ."'<br>
	    				  Certification Level:'". $certlevel ."'<br>
	    				  Issue Date:'". $dateofcert ."'<br>
	    				  Expiry Date:'". $expiry ."'<br>
	    				  ";
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	    echo '<script type="text/javascript">
       window.onload = function () { alert("Sucessfully Uploaded"); } 
</script>'; 
		}


		//if( !empty($ename) && !empty($csp) && !empty($certlevel) && !empty($certname) && !empty())
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
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
	.title label{
		color: #fff;
		font-size: 22px;
	}
	
	table{
		border-collapse: collapse;
		width: 100%;
		color: #fff;
		font-family: monospace;
		font-size: 25px;
		text-align: center;
	}
	
	th {
		background-color: #000000;
		color: white;
	}


	
	#button{

		background: #fff;
	font-size: 14px;
	margin-top: 5px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #fff;
	text-transform: uppercase;
	font-weight: 700;
	
	align-items: center;
	width: 50dx;
	color: #000000;
	
	cursor: pointer;
	transition: .2s;
	
	}
	
	
	</style>
</head>
<body>
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
				<h1><center>Enter Certificate Details</center></h1><br><br>
				<div id="box">
		<center><table>
		<form method="post">
			<tr><td><label>Employee Name</label></td><td><input required name="ename"  maxlength="25" type="text"></td></tr>
			<tr><td><label>CSP</label></td><td><select name="csp">
  			<option value="AWS">AWS</option>
  			<option value="Azure">Azure</option>
  			<option value="GCP">GCP</option>
			</select></td></tr>
			<tr><td><label>Certificate Level</label></td><td><input required name="certlevel" type="text"></td></tr>
			<tr><td><label>Certification Name</label></td><td><input required name="certname" type="text"></td></tr>
			<tr><td><label>Certification ID</label></td><td><input required name="certid" type="text"></td></tr>
			<tr><td><label>Issue Date</label></td><td><input required name="dateofcert" type="date" id="datefield" max="2000-01-01"></td></tr>
			<tr><td><label>Expiry Date</label></td><td><input required name="expiry" type="date" id="datee" min="2000-01-01"></td></tr>
			<tr><td colspan="2"><input id="button" type="submit" value="Add Certificate"></td></tr>

		</form>
	</table></center>
	</div>
	<br><br>
				<h2><center>Click On Show Certificates to Add & Delete Certificates</h2>
			
			</div>
			
		

	</header>

	

<script>
	var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1;
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("datefield").setAttribute("max", today);
document.getElementById("datee").setAttribute("min", today);

</script>
</body>
</html>