<?php

if(!session_start()) session_start();


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
<?php

if (isset($_SESSION['name'])){

?>
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
      	<form enctype="multipart/form-data" action="uploader.php" method="POST">
        	<h3>Write the tags of your image separated by commas</h3>
        	<input type="text" class="form-control" name="tagField" placeholder="Enter tags:">
        	<h2>Upload image</h2>
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
			Choose a file to upload from your computer: <input name="uploadedfile" type="file" /><br />
			<input type="submit" value="Upload File" class="btn btn-default" />
		</form>
      </div>
<?php

}else{
	
?>
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
            </ul>
            <form id="rightElements" class="navbar-form pull-right">
              <input id="mailField" class="span2" type="text" placeholder="Email">
              <input id="passField" class="span2" type="password" placeholder="Password">
              <button id="logButton" type="button" class="btn" onClick="login()">Log in</button>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <hr>

      <div class="jumbotron">
        <h2>Error, you are not logged in</h2>
      </div>
<?php
}
?>    
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