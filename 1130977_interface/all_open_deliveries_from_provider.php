<?php
require("connect.php");

$tablename = '`sales`.`provider`';
$maxlength = 50;
$size = 15;

$response_server = "";

$provider_names = array();
$provider_id = array();
$quantity_array = array();
$id_product_tbProduct = array();
$product_description_tbProduct = array();
$product_array = array();
$deliverydate_array = array();

$provider_id_post = "";

if (isset($_POST['load'])) {
	$provider_id_post = $_POST["provider"];
	$query = mysql_query("SELECT * FROM `order` inner join sales.`provider` on sales.`order`.providerid = sales.`provider`.idprovider AND sales.`order`.delivered = '0' AND sales.`order`.providerid = '" . $provider_id_post . "'");
	while($row = mysql_fetch_array($query))
	{
		$quantity_array[] = $row['quantity'];
		$product_array[] = $row['productid'];
    $deliverydate_array[] = $row['deliverydate'];
    $Provider_name_select[] = $row['name'];

	}
	
	//Abfrage alle Werter von der Tabelle Product
	$query = mysql_query("SELECT * FROM sales.product");
	while($row = mysql_fetch_array($query))
	{
		$id_product_tbProduct[] = $row['idproduct'];
		$product_description_tbProduct[] = $row['description']; 
	}
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

//Abfrage alle Werter von der Tabelle Order
$query = mysql_query("SELECT * FROM $tablename");
while($row = mysql_fetch_array($query))
{
	$provider_names[] = $row['name'];
	$provider_id[] = $row['idprovider'];
}

require("disconnect.php");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
echo "<head><title>View all open orders from a provider</title></head>";
echo "<body>";
echo "<h1> View all open orders from a provider</h1>";

echo "</br>";
echo "<form action = \"all_open_deliveries_from_provider.php\" method =\"POST\">";

echo "<td><select name=\"provider\" style=\"width: 145px\"><option value=\"\">Select...</option>";
for ($i = 0; $i < count($provider_names); $i++) 
{
	echo '<option value="' .  $provider_id[$i] . '">' ;
	echo $provider_names[$i] ;
	echo '</option>';
}
echo '</select></td>';
echo "<td><input type=\"submit\" name=\"load\" value=\" Load \"> </td>";
echo "</form>";

echo "</br>";

if(count($quantity_array) != 0)
{
	echo "<table border=\"1px\">";
	echo "<tr><td>Quantity</td><td>Product</td><td>Delivery date</td></tr>";
	for($i = 0; $i<count($quantity_array); $i++)
  {
    echo "<tr><td>". $quantity_array[$i] . "</td> <td>";
    for ($f = 0; $f < count($id_product_tbProduct); $f++) 
    {	     
     
      if ($product_array[$i] == $id_product_tbProduct[$f])
      {
        echo $product_description_tbProduct[$f];
        break;
      }
    }
    echo "</td><td>". $deliverydate_array[$i] ."</td></tr>";
    
  }
	
	echo "</table></br>";
}
else
{
  if(strlen($provider_id_post) > 0){
    echo "<br> No open Orders from the Provider is found. <br>";
  }
}

if (count($response_server) != 0)
{
	echo $response_server;
}
echo "<p><a href = \"index.html\">Back</a>";
echo "</body>";
echo "</html>";

?>
