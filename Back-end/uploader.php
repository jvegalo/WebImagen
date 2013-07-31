<?php

if(!session_start()) session_start();

include("connection.php");
include("Classes/image.php");
//get the tags of the image
$tags=$_REQUEST["tagField"];
// Where the file is going to be placed 
$target_path = "Images/";

/* Add the original filename to our target path.  
Result is "images/filename.extension" */
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
$imageName = basename( $_FILES['uploadedfile']['name']);
$userIdImage = $_SESSION['id'];

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    //the upload succeed, now let´s register it in the database
	$tagsArray = explode(",", $tags);
	$mySQLQuery = "INSERT INTO imagen (nombre, ruta, idUsuario) VALUES ('$imageName','$target_path', '$userIdImage')";
	$retval = mysqli_query( $con, $mySQLQuery );
	$imageID = mysqli_insert_id($con);
	foreach ($tagsArray as $value) {
		$value = trim($value);
		$mySQLQueryTags = "SELECT * FROM tag WHERE nombre = '$value'";
		$retval2 = mysqli_query( $con, $mySQLQueryTags );
		$num_rows = $retval2->num_rows;
		if ($num_rows == 0){
			$mySQLQueryInsertTag = "INSERT INTO tag (nombre) VALUES ('$value')";
			$retval3 = mysqli_query( $con, $mySQLQueryInsertTag );
			$tagID = mysqli_insert_id($con);
			$mySQLQueryInsertTagImage = "INSERT INTO imagentag (idImagen, idTag) VALUES ('$imageID','$tagID')";
			$retval4 = mysqli_query( $con, $mySQLQueryInsertTagImage );
		}else{
			//tag already exist, just make the imagen-tag insertion
			$tagThatExist = $retval2->fetch_assoc();
			$tagThatExistID = $tagThatExist["id"];
			$mySQLQueryAssociateTagToImage = "INSERT INTO imagentag (idImagen, idTag) VALUES ('$imageID', '$tagThatExistID')";
			$retval4 = mysqli_query( $con, $mySQLQueryAssociateTagToImage );
		}
	}
} else{
    
	echo $_FILES['uploadedfile']['tmp_name'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Upload images</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Adding Bootstrap Style -->
<link href="Styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">WebImage</a>
          <div class="nav-collapse collapse">
            <ul class="nav" id="sections">
              <li><a href="signup.php">Sign up</a></li>
              <li><a href="upload.php">Upload!</a></li>
            </ul>
            <form id="rightElements" class="navbar-form pull-right">
              <button id="logOutButton" type="button" class="btn" onClick="logout()">Log out</button>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <hr>

      <div class="jumbotron">
      	<h1>Your Upload was successful!</h1>
      </div>
<!-- Adding Jquery and neccesary .js -->
<script src="http://code.jquery.com/jquery.js"></script>
<script src="Styles/bootstrap/js/bootstrap.min.js"></script>
<!-- Javascript methods -->
<script>
function login(){
	var email = $("#mailField").val()
	var password = $("#passField").val()
	sendLogin(email,password);
}

function sendLogin(email, password){
    $.ajax({
       type: "POST",
       url: "login.php",
       data: { userEmail: email, userPassword: password },
       success: function(msg){
         if (msg == "session ready"){
			 $("#sections").append('<li><a href="upload.php">Upload!</a></li>');
			 $("#mailField").remove();
			 $("#passField").remove();
			 $("#logButton").remove();
			 $("#rightElements").append('<button id="logOutButton" type="button" class="btn" onClick="logout()">Log out</button>');
		 }else{
			 alert( "Data Saved: " + msg );
		 }
       }
     });
}

function logout(){
	$.ajax({
       type: "POST",
       url: "Back-end/logout.php",
       data: { message: "logout"},
       success: function(msg){
			window.location.replace("index.php");
			
		 
       }
     });
}
</script>

</body>
</html>