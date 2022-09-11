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
	$user_data = check_login($con);

    // sql to delete a record
    $sql1 = "DELETE FROM users WHERE user_name='". $_POST['delete'] ."'";
    $sql2 = "DELETE FROM certificates WHERE user_name='". $_POST['delete'] ."'";






    if ( $con->query($sql2) === TRUE && $con->query($sql1) === TRUE) {

       header("Location: admin.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

?>