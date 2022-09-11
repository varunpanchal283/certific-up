<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cdb";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
