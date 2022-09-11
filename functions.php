<?php

function check_login($con)
{

	if(isset($_SESSION['user_name']))
	{
		$query = "CREATE TABLE IF NOT EXISTS users (user_name varchar(255) PRIMARY KEY, password varchar(255) )";
		mysqli_query($con,$query);

		$quer = "CREATE TABLE IF NOT EXISTS certificates(certification_id varchar(255) NOT NULL,user_name varchar(255) NOT NULL, emp_name varchar(255), certification_type varchar(255), cert_level varchar(255), cert_id varchar(255), dateof_cert DATE, expiry_cert DATE, PRIMARY KEY (certification_id, user_name))";
		mysqli_query($con,$quer);

		$id = $_SESSION['user_name'];
		$query = "select * from users where user_name = '$id' limit 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}

