<?php
require("connect.php");

$tablename = '`sales`.`product`';
$maxlength = 50;
$size = 15;
$response_server = "";

if(isset($_POST['Delete']))
{
 $idprod = $_POST["idprod"];
 $query = mysql_query("DELETE FROM $tablename WHERE `idproduct`='$idprod';");
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
 $idprod = $_POST["idprod"];
 $des = $_POST["description"];
 $pri = $_POST["price"];
 $mino = $_POST["minoforder"];
 $query = mysql_query("UPDATE sales.product SET `description`='$des', `price`='$pri', `minimum of order`='$mino' WHERE `idproduct`='$idprod';");
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
 $description = $_POST["description"];
 $price = $_POST["price"];
 $minoforder = $_POST["minoforder"];
 if (empty($description) or empty($price) or empty($minoforder))
 {
	$response_server =  "<h2><font color = \"#FF0000\"><br>Not all fields are filled out!</h2><br>";
 }
 else
 { 
	/* Insert information into table */
	$query = MYSQL_QUERY("INSERT INTO $tablename (`description`, `price`, `minimum of order`) VALUES('$description', '$price', '$minoforder')");

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


$idproduct_array = array();
$product_array = array();
$price_array = array();
$minoforder_array = array();

$query = mysql_query("SELECT * FROM $tablename");
while($row = mysql_fetch_array($query))
{
	$idproduct_array[] = $row['idproduct'];
 	$product_array[] = $row['description'];   
	$price_array[] = $row['price']; 
	$minoforder_array[] = $row['minimum of order'];
}
require("disconnect.php");


PRINT "<html>";
PRINT "<head><title>View and edit all product</title></head>";
PRINT "<body>";
echo "<h1>View, edit and add products</h1>";
if(count($idproduct_array) == 0)
{
	echo "There are no products in the list.<p>";
}
else
{
	PRINT "<table border=\"0\">";
	echo "<tr><td>ID</td><td>Description</td><td>Price</td><td>Minimum of order</td></tr>";
	for($i = 0; $i<count($idproduct_array); $i++)
	{
		PRINT "<form action = \"view_all_product.php\" method =\"POST\">";
		echo "<tr>";
		echo "<td><input name=\"idprod\" type=\"text\" border=\"0\" size=\"4\" value=\"" . $idproduct_array[$i] . "\" readonly></td>";
		echo "<td><textarea name= \"description\" cols=\"40\" rows=\"3\">" . $product_array[$i]. "</textarea></td>";
		echo "<td><input type = \"text\" name = \"price\" size = \"$size\" maxlength = \"$maxlength\" value = \""  . $price_array[$i]. "\"></td>";
		echo "<td><input type = \"text\" name = \"minoforder\" size = \"$size\" maxlength = \"$maxlength\" value = \""  . $minoforder_array[$i]. "\"></td>";
		echo "<td><input type=\"submit\" name=\"Update\" value=\"Update\"> </td>";
		echo "<td><input type=\"submit\" name=\"Delete\" value=\"Delete\"> </td>";
		echo "</tr>";
		PRINT "</form>";
	}
	
	
}
PRINT "<form action = \"view_all_product.php\" method =\"POST\">";
echo "<tr><td> </td>";
echo "<td><textarea name= \"description\" cols=\"40\" rows=\"3\"></textarea>*</td>";
echo "<td><input type = \"text\" name = \"price\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"minoforder\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type=\"submit\" name=\"Add\" value=\" Add \"> </td>";
echo "<td></td>";
echo "</tr>";
echo "</table>";

echo "<p>Please fill out the mandatory fields (*)";
if (count($response_server) != 0)
{
	echo $response_server;
}
echo "<p><a href = \"index.html\">Back</a>";
echo "</body>";
echo "</html>";

?>