<?php
require("connect.php");

$tablename = 'sales.provider';
$maxlength = 50;
$size = 20;

$response_server = "";

if(isset($_POST['Delete']))
{
 $idpro = $_POST["idpro"];
 $query = mysql_query("DELETE FROM $tablename WHERE `idprovider`='$idpro';");
 
 $response_server = "<p>Database server response:<br>";
 if($query != 0)
 {
  $affected_rows = mysql_affected_rows();
  $response_server = $response_server . "<strong>Query OK. Rows affected $affected_rows</strong>";
 } 
 else
 {
  $response_server = $response_server . "<strong>Query FAILED. ".'Invalid query: ' . mysql_error() . "</strong>";
 }
}

if(isset($_POST['Update']))
{
  $idpro = $_POST["idpro"];
  $name = $_POST["name"];
  $street = $_POST["street"];
  $zip= $_POST["zip"];
  $city= $_POST["city"];
  $mail = $_POST["mail"];
  $query = mysql_query("UPDATE $tablename SET `name`='$name', `street`='$street', `zip`='$zip', `city`='$city', `email`='$mail' WHERE `idprovider`='$idpro';");
  $response_server = "<p>Database server response:<br>";
  if($query != 0)
 {
  $affected_rows = mysql_affected_rows();
  $response_server = $response_server . "<strong>Query OK. Rows affected $affected_rows</strong>";
 } 
 else
 {
  $response_server = $response_server . "<strong>Query FAILED. ".'Invalid query: ' . mysql_error() . "</strong>";
 }
}

if(isset($_POST['Add']))
{
  $name = $_POST["name"];
  $street = $_POST["street"];
  $zip= $_POST["zip"];
  $city= $_POST["city"];
  $mail = $_POST["mail"];
  if (empty($name) or empty($street)or empty($zip) or empty($city))
  {
	$response_server =  "<h2><font color = \"#FF0000\"><br>Not all fields are filled out!</h2><br>";
  }
  else
  {
    $query = mysql_query("INSERT INTO $tablename (`name`, `street`, `zip`, `city`, `email`) VALUES('$name', '$street', '$zip', '$city', '$mail')");
    $response_server = "<p>Database server response:<br>";
    if($query != 0)
   {
     $affected_rows = mysql_affected_rows();
     $response_server = $response_server . "<strong>Query OK. Rows affected $affected_rows</strong>";
   } 
   else
   {
     $response_server = $response_server . "<strong>Query FAILED. ".'Invalid query: ' . mysql_error() . "</strong>";
   }
  }
}
$idprovider_array = array();
$name_array = array();
$street_array = array();
$zip_array = array();
$city_array = array();
$mail_array = array();

$query = mysql_query("SELECT * FROM $tablename");
while($row = mysql_fetch_array($query))
{
	$idprovider_array[] = $row['idprovider'];
	$name_array[] = $row['name'];
 	$street_array[] = $row['street'];   
	$zip_array[] = $row['zip']; 
	$city_array[] = $row['city'];
	$mail_array[] = $row['email'];
}
require("disconnect.php");


PRINT "<html>";
PRINT "<head><title>View and edit all product</title></head>";
echo "<body>";
echo "<h1> View, edit and add provider</h1>";

PRINT "<table border=\"0\">";
echo "<tr><td>ID</td><td>Name</td><td>Street</td><td>Postcode</td><td>City</td><td>email</td></tr>";
	
if(count($idprovider_array) != 0)
{	
	for($i = 0; $i<count($idprovider_array); $i++)
	{
		PRINT "<form action = \"view_all_provider.php\" method =\"POST\">";
		echo "<tr>";
		echo "<td><input name=\"idpro\" type=\"text\" border=\"0\" size=\"4\" value=\"" . $idprovider_array[$i] . "\" readonly></td>";
		echo "<td><input type = \"text\" name = \"name\" size = \"$size\" maxlength = \"$maxlength\" value =\"" . $name_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"street\" size = \"$size\" maxlength = \"$maxlength\" value =\"" . $street_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"zip\" size = \"$size\" maxlength = \"$maxlength\" value =\"" . $zip_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"city\" size = \"$size\" maxlength = \"$maxlength\" value =\"" . $city_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"mail\" size = \"$size\" maxlength = \"$maxlength\" value =\"" . $mail_array[$i]. "\"></td>";
		echo "<td><input type=\"submit\" name=\"Update\" value=\"Update\"> </td>";
		echo "<td><input type=\"submit\" name=\"Delete\" value=\"Delete\"> </td>";
		echo "</tr>";
		PRINT "</form>";
	}
}
echo "<form action = \"view_all_provider.php\" method =\"POST\">";
echo "<tr><td></td>";
echo "<td><input type = \"text\" name = \"name\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"street\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"zip\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"city\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"mail\" size = \"$size\" maxlength = \"$maxlength\"></td>";
echo "<td><input type=\"submit\" name=\"Add\" value=\"Add\"> </td>";
PRINT "</table>";
echo "<p>Please fill out the mandatory fields (*)";
if (count($response_server) != 0)
{
	echo $response_server;
}
PRINT "<p><a href = \"index.html\">Back</a>";
PRINT "</body>";
PRINT "</html>";

?>