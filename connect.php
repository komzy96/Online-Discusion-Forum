<?php
//connect.php
//$server = 'localhost';
//$username   = 'root';
//$password   = '';
//$database   = 'techforum';
 
//if(!mysqli_connect($server, $username,  $password))
//{
 //   exit('Error: could not establish database connection');
//}
//if(!mysqli_select_db($database)
//{
  //  exit('Error: could not select the database');
//}
//?>


<?php 
define('server', 'localhost');
	 define('username', 'root');
	 define('password', '');
	define('database', 'techforum');
// $server	    = 'localhost';
// $username	= 'root';
// $password	= '';
// $database	= 'techforum';
$connection = mysqli_connect(server, username, password, database);

if($connection === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error($connection));
	}
?>