<?php
require("connect.php");

$tablename = '`sales`.`order`';
$maxlength = 50;
$size = 15;

$response_server = "";

$idorder_array = array();
$quantity_array = array();
$product_array = array();
$idproduct_array = array();
$company_namen_customer_array = array();
$idcostumer_array = array();
$provider_array = array();
$idprovider_array = array();
$deliverydate_array = array();
$allready_delivered_array = array();

$company_namen_customer_tbCustomer = array();
$company_Street_customer_tbCustomer = array();
$company_City_customer_tbCustomer = array(); 
$company_Zip_customer_tbCustomer = array();
$id_costumer_array_tbCustomer_or = array();
$company_namen_customer_tbCustomer_or = array();

$company_namen_customer = array();
$provider = array();
$product = array();

//$id_costumer_array_tbCustomer[] = array();
//$company_namen_customer_tbCustomer[] = array(); 

//$id_product_tbProduct[] = array();
//$product_description_tbProduct[] = array();  

if(isset($_POST['load']))
{
 $customer_id = $_POST["customer"];
 $query = mysql_query("Select * FROM sales.`order` inner join sales.customer on sales.`order`.customerid = customer.idcustomer where sales.`order`.customerid = '".$customer_id."';");
 while($row = mysql_fetch_array($query))
{
	$idorder_array[] = $row['idorder'];
	$quantity_array[] = $row['quantity'];
	$product_array[] = $row['productid'];
 	$provider_array[] = $row['providerid'];   
	$deliverydate_array[] = $row['deliverydate']; 
  $allready_delivered_array[] = $row['delivered'];
  $company_namen_customer_tbCustomer[] = $row['Company'];
  $company_Street_customer_tbCustomer[] = $row['Street'];
  $company_City_customer_tbCustomer[] = $row['City']; 
  $company_Zip_customer_tbCustomer[] = $row['Zip']; 
}
 
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


//Abfrage alle Werter von der Tabelle Customer
$query = mysql_query("SELECT * FROM sales.customer");
while($row = mysql_fetch_array($query))
{
  $id_costumer_array_tbCustomer_or[] = $row['idcustomer'];
  $company_namen_customer_tbCustomer_or[] = $row['Company']; 
}

//Abfrage alle Werter von der Tabelle Product
$query = mysql_query("SELECT * FROM sales.product");
while($row = mysql_fetch_array($query))
{
	$id_product_tbProduct[] = $row['idproduct'];
	$product_description_tbProduct[] = $row['description'];   
}

//Abfrage alle Werter von der Tabelle Provider
$query = mysql_query("SELECT * FROM sales.provider");
while($row = mysql_fetch_array($query))
{
	$id_provider_array_tbprovider[] = $row['idprovider'];
	$provider_name_tbprovider[] = $row['name'];   
}

require("disconnect.php");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
echo "<head><title>View all orders from a Customer</title></head>";
echo "<body>";
echo "<h1> View all orders from a customer</h1>";

echo "</br>";
echo "<form action = \"all_orders_from_customer.php\" method =\"POST\">";

echo "<td><select name=\"customer\" style=\"width: 145px\"><option value=\"\">Select...</option>";
for ($i = 0; $i < count($company_namen_customer_tbCustomer_or); $i++) 
{
	echo '<option value="' .  $id_costumer_array_tbCustomer_or[$i] . '">' ;
	echo $company_namen_customer_tbCustomer_or[$i] ;
	echo '</option>';
}
echo '</select></td>';
echo "<td><input type=\"submit\" name=\"load\" value=\" Load \"> </td>";
echo "</form>";

echo "</br>";

if(count($idorder_array) > 0){

  if(count($company_namen_customer_tbCustomer) > 0){
  echo  $company_namen_customer_tbCustomer[0];
  }
  echo "</br>";
  if(count($company_Street_customer_tbCustomer) > 0){
  echo  $company_Street_customer_tbCustomer[0] . "\n";
  }
  echo "</br>";
  if(count($company_Zip_customer_tbCustomer) > 0){
  echo   $company_Zip_customer_tbCustomer[0] . "\n" ;
  }
  if(count($company_City_customer_tbCustomer) > 0){
  echo  " " .$company_City_customer_tbCustomer[0] ;
  }
  echo "</br>";
  echo "</br>";
  echo "<table border=\"1px\">";
  echo "<tr><td>Quantity</td><td>Product</td><td>Provider</td><td>Delivery date</td></tr>";

  for($i = 0; $i<count($idorder_array); $i++)
  {
    echo "<td>" . $quantity_array[$i] . "</td><td>";
    for ($f = 0; $f < count($id_product_tbProduct); $f++) 
    {	     
     
      if ($product_array[$i] == $id_product_tbProduct[$f])
      {
        echo $product_description_tbProduct[$f];
        break;
      }
    }
    echo "</td><td>";
    for ($f = 0; $f < count($id_provider_array_tbprovider); $f++) 
    {
      if ($provider_array[$i] == $id_provider_array_tbprovider[$f])
      {
        echo $provider_name_tbprovider[$f];
        break;
      }
    }
    echo "</td><td>" . $deliverydate_array[$i] . "</td>";
  }

  echo "</table>";
}
if (count($response_server) != 0)
{
	echo $response_server;
}
echo "<p><a href = \"index.html\">Back</a>";
echo "</body>";
echo "</html>";

?>