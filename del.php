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
    $stmt = $con->prepare("SELECT * FROM certificates WHERE certification_id = ? AND user_name = ?");
    $stmt->bind_param("ss",$_POST['delete'],$user_data['user_name']);
    $stmt->execute();
    $res =  $stmt->get_result();
    while($row = mysqli_fetch_array($res))
      {
       $ename=$row['emp_name'];
       $certname=$row['cert_id'];
       $certlevel=$row['cert_level']; 
       $certid=$row['certification_id'];
       $dateofcert=$row["dateof_cert"];
       $expiry=$row['expiry_cert'];
       $csp=$row['certification_type'];
      }

    // sql to delete a record
    $sql = "DELETE FROM certificates WHERE certification_id='". $_POST['delete'] ."' AND user_name='". $user_data['user_name'] ."'";





    if ($con->query($sql) === TRUE) {
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
        $mail->Body    = "The Below Certificate Details were Deleted<br>
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

       header("Location: showcert.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

?>