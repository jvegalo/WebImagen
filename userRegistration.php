<?php

include("connection.php");
//get variables from post
$userName = $_REQUEST["name"];
$userEmail = $_REQUEST["email"];
$userPassword = $_REQUEST["password"];
//encrypt password
$userPasswordEncrypted = base64_encode($userPassword);

$mySQLQuery = "INSERT INTO usuario (nombre, email, pass) VALUES ('$userName','$userEmail','$userPasswordEncrypted')";
$retval = mysqli_query( $con, $mySQLQuery );
if(! $retval )
{
  die('Could not enter data: ' . mysql_error());
}

echo "Success";
?>