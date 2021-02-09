<?php
    $dbHost = "localhost";
  	$dbUser = "testuser";
  	$dbPass = "hase";
  	$dbName = "sales";
  
  	/* make connection to the database server */
	//$con=mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

  	$connect = @mysql_connect($dbHost, $dbUser, $dbPass) or die("<p class='error'>ERROR: Unable to connect to database server!</p>");
  	$selectDB = @mysql_select_db($dbName, $connect) or die("<p class='error'>ERROR: Unable to select $dbName!</p>");
?>

