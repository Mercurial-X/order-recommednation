<?php
session_start(); 
error_reporting(0);
$error=''; 

if (isset($_POST['submit'])) {
if (empty($_POST['ID'])) {
$error = "ID Didnot Found";
}
else
{

$ID=$_POST['ID'];

require 'connection.php';
$conn = Connect();

$query = "SELECT * FROM home WHERE R_ID='$ID'";

$result = mysqli_query($conn, $query);
$row = mysqli_num_rows($result);
if ($row > 0)  
{
	// $_SESSION['login_user1']=$username; // Initializing Session
	 if($row['username'] = ''){
  session_start();
	 $_SESSION['ID'] = $ID;
	header("location: chefSignUp.php"); // Redirecting To Other Page
}
  else{
      $error = "ID has already been activated";
  }
} else {
$error = "ID didnot Found";
}
mysqli_close($conn); // Closing Connection
}
}
?>


<!DOCTYPE html>
<html>

  <head>
    <title> Home Chef | ASPRESSO</title>
  </head>

  <link rel="stylesheet" type = "text/css" href ="css/managerlogin.css">
  <link rel="stylesheet" type = "text/css" href ="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <body>

  
    <button onclick="topFunction()" id="myBtn" title="Go to top">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </button>
  
    <script type="text/javascript">
      window.onscroll = function()
      {
        scrollFunction()
      };

      function scrollFunction(){
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          document.getElementById("myBtn").style.display = "block";
        } else {
          document.getElementById("myBtn").style.display = "none";
        }
      }

      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>

    <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">ASPRESSO</a>
        </div>

        <div class="collapse navbar-collapse " id="myNavbar">
          <ul class="nav navbar-nav">
            <li ><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Sign Up <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="customersignup.php"> User Sign-up</a></li>
              <li> <a href="managersignup.php"> Manager Sign-up</a></li>

            </ul>
            </li>

            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li> <a href="customerlogin.php"> User Login</a></li>
              <li> <a href="managerlogin.php"> Manager Login</a></li>
 
            </ul>
            </li>
          </ul>
        </div>

      </div>
    </nav>

    <div class="container">
    <div class="jumbotron">
     <h1>Hi Chef,<br> Welcome to <span class="edit"> Le Cafe' </span></h1>
     <br>
   <p> Kindly SEARCH HomeID to continue.</p>
    </div>
    </div>
    <div class="container" style="margin-top: 4%; margin-bottom: 2%;">
      <div class="col-md-5 col-md-offset-4">
        <label style="margin-left: 5px;color: red;"><span> <?php echo $error;  ?> </span></label>
      <div class="panel panel-primary">
        <div class="panel-heading"> Search Your ID </div>
        <div class="panel-body">
          
        <form action="" method="POST">
          
        <div class="row">

          <div class="form-group col-xs-9">
             
            <label for="username"><span class="text-danger" style="margin-right: 5px;">*</span> Home ID </label>
            <div class="input-group">
              <input class="form-control" id="username" type="number" name="ID" placeholder="User ID" required="" autofocus=""><br>
              <span class="input-group-btn">
                <label class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></label>
            </span>
              </span>
            </div>           
          </div>
        </div>
        <div class="row">
          <div class="form-group col-xs-4">
              <button class="btn btn-primary"  name="submit" type="submit" value=" Login "> Search </button>

          </div>

        </div>
  
        </form>

        </div>
        
      </div>
      
    </div>
    </div>
    </body>
</html>