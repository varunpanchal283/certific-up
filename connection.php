<?php
require 'aws-autoloader.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
use Aws\SecretsManager\SecretsManagerClient; 
use Aws\Exception\AwsException;
putenv("HOME=/var/www/html/certific-up");
$ev=shell_exec("wget -q -O - http://169.254.169.254/latest/meta-data/placement/region");
$client = new SecretsManagerClient([
    'profile' => 'default',
    'version' => 'latest',
    'region' => $ev,
]);
$secretName = 'mysql';
    $result = $client->getSecretValue([
        'SecretId' => $secretName,
    ]);
$temp = $result['SecretString'];
$res = json_decode($temp);
$dbhost = $res->localhost;
$dbuser = $res->username;
$dbpass = $res->password;
$dbname = $res->databasename;

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

        die("failed to connect!");
}
