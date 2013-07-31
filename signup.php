<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Sign up</title>
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

    <div class="jumbotron" id="content">
    <form>
    <fieldset>
    <legend>Please fill the following information</legend>
    <div class="form-group">
      <label for="exampleInputName">Name</label>
      <input type="text" class="form-control" id="exampleInputName" placeholder="Enter name">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail">Email address</label>
      <input type="text" class="form-control" id="exampleInputEmail" placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password">
    </div>
    <button onclick="register()" type="button" class="btn btn-default">Sign up</button>
    <fieldset>
    </form>
    </div>
      
<!-- Adding Jquery and neccesary .js -->
<script src="http://code.jquery.com/jquery.js"></script>
<script src="Styles/bootstrap/js/bootstrap.min.js"></script>
<!-- Javascript methods -->
<script>
function register(){
	var name = $("#exampleInputName").val();
	var email = $("#exampleInputEmail").val();
	var password = $("#exampleInputPassword").val();
	if (name != "" && email != "" && password != ""){
		sendData(name,email,password);		   
	}else{
		var div = document.getElementById('content');
		div.innerHTML = div.innerHTML + '<div class="alert alert-error">Please fill all the information</div>';
	}

}
function sendData(userName,userEmail,userPassword)
{
    $.ajax({
       type: "POST",
       url: "userRegistration.php",
       data: { name: userName, email: userEmail, password: userPassword },
       success: function(msg){
         if (msg == "Success"){
			 var div = document.getElementById('content');
		     div.innerHTML = div.innerHTML + '<div class="alert alert-success">Congratulations, now you can log in and start uploading images!</div>';
		 }
       }
     });
}
function login(){
	var email = $("#mailField").val()
	var password = $("#passField").val()
	sendLogin(email,password);
}

function sendLogin(email, password){
    $.ajax({
       type: "POST",
       url: "Back-end/login.php",
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
}	
</script>			
</body>
</html>