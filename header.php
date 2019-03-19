<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>Tech Forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">

    <link rel="stylesheet" type="text/css" href="bts/bootstrap.min.css">
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/main1.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


   <script src="jquery-slim.min.js"></script>
<script src="popper.min.js"></script>
<script src="bootstrap.min.js"></script> 
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php"><strong>TechForum.org</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><strong>Home</strong> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="create_topic.php"><strong>Create a Topic</strong></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="create_cat.php"><strong>
          Create a category</strong>
        </a>
        
      </li>
    </ul>
     <?php
        session_start();
        if(!empty($_SESSION['signed_in']))
        {
            echo '<a class="nav-text active">
      Hello <b>'. htmlentities($_SESSION['user_name']).' Not you?</span><a class="btn btn-danger" href="signout.php" role="button">signout</a>';
        }
        else
        {
            echo '<a class="btn btn-danger" href="signin.php" role="button"><strong>Sign in</strong></a><strong> or</strong> <a class="btn btn-danger" href="signup.php" role="button"><strong>Create an account</strong></a>';
        }

        ?>

     <style type="text/css">
  .clock {
  font-size: 1em;
  color: white;
  font-weight: bolder;

}
</style>

<body>
<div class="clock"></div>

<script type="text/javascript">
  function clock() {// We create a new Date object and assign it to a variable called "time".
var time = new Date(),
    
    // Access the "getHours" method on the Date object with the dot accessor.
    hours = time.getHours(),
    
    // Access the "getMinutes" method with the dot accessor.
    minutes = time.getMinutes(),
    
     // Access the "getSeconds" method with the dot accessor.
    seconds = time.getSeconds();

document.querySelectorAll('.clock')[0].innerHTML = SetTime(hours) + ":" + SetTime(minutes) + ":" + SetTime(seconds);
  
  function SetTime(standIn) {
    if (standIn < 10) {
      standIn = '0' + standIn
    }
    return standIn;
  }
}
setInterval(clock, 1000);
</script>
  
    </div>
  </div>
</nav>
    <!-- <span class="navbar-text">
      Hello User, Not you? 
    </span>
    <a class="nav-link" href="signout.php">Sign Out</a> -->
   <div>
        <!-- <a class="item" href="/techForum/signin.php">Sign in</a> -
        <a class="item" href="/techForum/signup.php">Create an account</a> -->
       
         
       
     <div id="content">
