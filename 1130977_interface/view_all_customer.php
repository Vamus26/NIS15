<?php
require("connect.php");

$tablename = 'sales.customer';
$maxlength = 50;
$size = 15;

$response_server = "";

if(isset($_POST['Delete']))
{
 $idcos = $_POST["idcost"];
 $query = mysql_query("DELETE FROM $tablename WHERE `idcustomer`='$idcos';");
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
  $idcos = $_POST["idcost"];
  $company = $_POST["company"];
  $firstname = $_POST["fristname"];
  $lastname = $_POST["lastname"];
  $street = $_POST["street"];
  $zip= $_POST["zip"];
  $city= $_POST["city"];
  $mail = $_POST["mail"];
  $query = mysql_query("UPDATE $tablename SET `Company`='$company', `Firstname`='$firstname', `Lastname`='$lastname', `Street`='$street', `Zip`='$zip', `City`='$city', `email`='$mail'  WHERE `idcustomer`='$idcos';");
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
  $company = $_POST["company"];
  $fristname = $_POST["fristname"];
  $lastname = $_POST["lastname"];
  $street = $_POST["street"];
  $zip= $_POST["zip"];
  $city= $_POST["city"];
  $mail = $_POST["mail"];
  if (empty($company) or empty($fristname) or empty($lastname) or empty($street)or empty($zip) or empty($city))
  {
	$response_server =  "<h2><font color = \"#FF0000\"><br>Not all fields are filled out!</h2><br>";
  }
  else
  {
    $query = mysql_query("INSERT INTO $tablename (`Company`, `Firstname`, `Lastname`, `Street`, `Zip`, `City`, `email`) VALUES('$company', '$fristname', '$lastname', '$street', '$zip', '$city', '$mail')");
    $response_server =  "Database server response:<br>";
	if($query != 0){
		$affected_rows = mysql_affected_rows();
		$response_server = $response_server . "<strong>Query OK. Rows affected $affected_rows</strong>";
	} else{
		$response_server = $response_server . "<strong>Query FAILED. ".'Invalid query: ' . mysql_error() . "</strong>";
	}
  }
}

$idcostumer_array = array();
$company_array = array ();
$firstname_array = array();
$lastname_arry = array();
$zip_array = array();
$city_array = array();
$mail_array = array();

$query = mysql_query("SELECT * FROM $tablename");

while($row = mysql_fetch_array($query))
{
	$idcostumer_array[] = $row['idcustomer'];
	$company_array[] = $row['Company'];
	$firstname_array[] = $row['Firstname'];
	$lastname_arry[] = $row['Lastname'];
 	$street_array[] = $row['Street'];   
	$zip_array[] = $row['Zip']; 
	$city_array[] = $row['City'];
	$mail_array[] = $row['email'];
}
require("disconnect.php");


PRINT "<html>";
PRINT "<head><title>View and edit all costumer</title></head>";
PRINT "<body>";
echo "<h1> View, edit and add costumer</h1>";
PRINT "<table border=\"0\">";
echo "<tr><td>ID</td><td>Company</td><td>Firstname</td><td>Lastname</td><td>Street</td><td>Postcode</td><td>City</td><td>email</td></tr>";
	
	
if(count($idcostumer_array) != 0)
	{
	for($i = 0; $i<count($idcostumer_array); $i++)
	{
		PRINT "<form action = \"view_all_customer.php\" method =\"POST\">";
		echo "<tr>";
		echo "<td><input name=\"idcost\" type=\"text\" border=\"0\" size=\"4\" value=\"" . $idcostumer_array[$i] . "\" readonly></td>";
		echo "<td><input type = \"text\" name = \"company\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $company_array[$i] . "\"></td>";
		echo "<td><input type = \"text\" name = \"fristname\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $firstname_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"lastname\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $lastname_arry[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"street\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $street_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"zip\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $zip_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"city\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $city_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"mail\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $mail_array[$i]. "\"></td>";
		echo "<td><input type=\"submit\" name=\"Update\" value=\"Update\"> </td>";
		echo "<td><input type=\"submit\" name=\"Delete\" value=\"Delete\"> </td>";
		echo "</tr>";
		PRINT "</form>";
	}
	
}
PRINT "<form action = \"view_all_customer.php\" method =\"POST\">";
echo "<tr><td></td>";
echo "<td><input type = \"text\" name = \"company\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"fristname\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"lastname\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"street\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"zip\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"city\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"mail\" size = \"$size\" maxlength = \"$maxlength\"></td>";
echo "<td><input type=\"submit\" name=\"Add\" value=\" Add \"> </td>";
echo "<td></td>";
echo "</tr>";
PRINT "</form>";
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