<?php

include("connection.php");
//get the login details
$userEmail = $_REQUEST["userEmail"];
$userPassword = $_REQUEST["userPassword"];
$userPasswordEncrypted = base64_encode($userPassword);

$mySQLQuery = "SELECT * FROM usuario WHERE email = '$userEmail' AND pass= '$userPasswordEncrypted'";
$retval = mysqli_query($con, $mySQLQuery);
if (!$retval) {
    echo "Could not successfully run query from DB: " . mysql_error();
    //exit;
}else{
	$num_rows = $retval->num_rows;
	if ($num_rows = 1){
		$row = $retval->fetch_assoc();
	}
	
}
$userId = $row["id"];
$userName = $row["nombre"];
$userEmail = $row["email"];
//start the user session
if(!session_start()) session_start();
$_SESSION['id'] = $userId;
$_SESSION['name'] = $userName;
$_SESSION['email'] = $userEmail;

echo "session ready";

?>