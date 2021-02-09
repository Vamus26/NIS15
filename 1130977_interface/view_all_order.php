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

$company_namen_customer = array();
$provider = array();
$product = array();

//$id_costumer_array_tbCustomer[] = array();
//$company_namen_customer_tbCustomer[] = array(); 

//$id_product_tbProduct[] = array();
//$product_description_tbProduct[] = array();  

if(isset($_POST['Delete']))
{
 $idord = $_POST["idorder"];
 $query = mysql_query("DELETE FROM $tablename WHERE `idorder`='$idord';");
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
  $idord  = $_POST["idorder"];
  $quantity = $_POST["quantity"];
  $productid = intval($_POST["product"]);
  $customerid = intval($_POST["customer"]);
  $providerid = intval($_POST["provider"]);
  $deliverydate= $_POST["deliverydate"];
  $allready_delivered = $_POST["allreadydelivered"];
  if($allready_delivered == "1"){
  $query = mysql_query("UPDATE $tablename SET `quantity`='$quantity', `productid`='$productid', `customerid`='$customerid', `providerid`='$providerid', `deliverydate`='$deliverydate', `delivered`='1'  WHERE `idorder`='$idord';");
  }
  else{
  $query = mysql_query("UPDATE $tablename SET `quantity`='$quantity', `productid`='$productid', `customerid`='$customerid', `providerid`='$providerid', `deliverydate`='$deliverydate'  WHERE `idorder`='$idord';");
  }
  $response_server = "<p>Database server response:<br>" . $idord ."<br>" . $quantity."<br>" . $productid ."<br>" . $customerid ."<br>" ;
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
  $quantity = $_POST["quantity"];
  $productid = intval($_POST["product"])+1;
  $providerid = intval($_POST["provider"]);
  $customerid = intval($_POST["customer"])+1;
  $deliverydate= $_POST["deliverydate"];
  
  //echo $quantity . "<br> product: " . $productid ."<br> provider: " . $providerid ."<br> deliver: ". $deliverydate ."\n";
  
  if (empty($quantity) or empty($productid) or empty($providerid) or empty($customerid)or empty($deliverydate))
  {
	$response_server =  "<h2><font color=\"#FF0000\"><br>Not all fields are filled out!</h2><br>";
  }
  else
  {
    $query = mysql_query("INSERT INTO $tablename (`quantity`, `productid`, `customerid`, `providerid`, `deliverydate`) VALUES('$quantity', '$productid', '$customerid', '$providerid', '$deliverydate')");
    $response_server =  "Database server response:<br>";
	if($query != 0){
		$affected_rows = mysql_affected_rows();
		$response_server = $response_server . "<strong>Query OK. Rows affected $affected_rows</strong>";
	} else{
		$response_server = $response_server . "<strong>Query FAILED. ".'Invalid query: ' . mysql_error() . "</strong>";
	}
  }
}

//Abfrage alle Werter von der Tabelle Order
$query = mysql_query("SELECT * FROM $tablename where delivered like '0'");
while($row = mysql_fetch_array($query))
{
	$idorder_array[] = $row['idorder'];
	$quantity_array[] = $row['quantity'];
	$product_array[] = $row['productid'];
	$company_namen_customer_array[] = $row['customerid'];
 	$provider_array[] = $row['providerid'];   
	$deliverydate_array[] = $row['deliverydate']; 
  $allready_delivered_array[] = $row['delivered'];
}

//Abfrage alle Werter von der Tabelle Customer
$query = mysql_query("SELECT * FROM sales.customer");
while($row = mysql_fetch_array($query))
{
  $id_costumer_array_tbCustomer[] = $row['idcustomer'];
  $company_namen_customer_tbCustomer[] = $row['Company']; 
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
echo "<head><title>View and edit all open orders</title></head>";
echo "<body>";
echo "<h1> View, edit  all open orders and add order</h1>";


echo "<table border=\"0\">";
echo "<tr><td>ID</td><td>Quantity</td><td>Product</td><td>Provider</td><td>Customer</td><td>Delivery date</td><td>Delivered</td><td></td><td></td></tr>";

if(count($idorder_array) != 0)
{
	for($i = 0; $i<count($idorder_array); $i++)
	{
       
    echo "<form action = \"view_all_order.php\" method =\"POST\">";
    echo "<tr>";
    echo "<td><input name=\"idorder\" type=\"text\" border=\"0\" size=\"4\" value=\"" . $idorder_array[$i] . "\" readonly></td>";
    echo "<td><input type = \"text\" name = \"quantity\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $quantity_array[$i] . "\"></td>";
    echo "<td><select name=\"product\" style=\"width: 145px\">";
    $found = FALSE;
    
    for ($f = 0; $f < count($id_product_tbProduct); $f++) 
    {	     
     
      if ($product_array[$i] == $id_product_tbProduct[$f])
      {
        echo '<option value=' . $id_product_tbProduct[$f] . ' selected>'. "id" . $product_description_tbProduct[$f]. '</option>';
        $found = TRUE;
        //break;
      }
      else
      {
        echo '<option value="' . $id_product_tbProduct[$f] . '">'.$product_description_tbProduct[$f]. '</option>';
      }
    }
    if ($found == FALSE)
    {
      echo '<option selected>Select new...</option>';
    }
    echo '</select></td>';
    
    echo "<td><select name=\"provider\" style=\"width: 145px\">";
    
    $found = False;
    
    for ($f = 0; $f < count($id_provider_array_tbprovider); $f++) 
    {
      if ($provider_array[$i] == $id_provider_array_tbprovider[$f])
      {
        echo '<option value="' . $id_provider_array_tbprovider[$f] . '"selected>' . $provider_name_tbprovider[$f] . '</option>';
        $found = TRUE;
      }
      else
      {
        echo '<option value="' . $id_provider_array_tbprovider[$f] . '">' . $provider_name_tbprovider[$f] . '</option>';
      }
    }
    if ($found == FALSE)
    {
      echo '<option selected>Select new...</option>';
    }
    echo '</select></td>';

    echo "<td><select name=\"customer\" style=\"width: 145px\">";
    $found = False;
    for ($f = 0; $f < count($id_costumer_array_tbCustomer); $f++) 
    {
      if ($company_namen_customer_array[$i] == $id_costumer_array_tbCustomer[$f])
      {
        echo '<option value="' . $id_costumer_array_tbCustomer[$f] . '"selected>'. $company_namen_customer_tbCustomer[$f] . '</option>';
        $found = True;
      }
      else{
        echo '<option value="' . $id_costumer_array_tbCustomer[$f] . '">'. $company_namen_customer_tbCustomer[$f] . '</option>';
      }
    }
    if ($found == FALSE)
    {
      echo '<option selected>Select new...</option>';
    }
    echo '</select></td>';
    
    
    
    echo "<td><input type = \"text\" name = \"deliverydate\" size = \"$size\" maxlength = \"$maxlength\" value = \"" . $deliverydate_array[$i] . "\"></td>";
    echo "<td><input type=\"checkbox\" name=\"allreadydelivered\" value =\"1\"> </td>";
    echo "<td><input type=\"submit\" name=\"Update\" value=\"Update\"> </td>";
    echo "<td><input type=\"submit\" name=\"Delete\" value=\"Delete\"> </td>";
    echo "</tr>";
    echo "</form>";
  }	
}

echo "<form action = \"view_all_order.php\" method =\"POST\">";
echo "<tr><td></td>";
//echo "<input type = \"text\" name = \"quantity\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type = \"text\" name = \"quantity\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><select name=\"product\" style=\"width: 145px\"><option value=\"\">Select...</option>";

for ($i = 0; $i < count($id_product_tbProduct); $i++) 
{
	echo '<option value="' . $id_product_tbProduct[$i] . '">' ;
	echo $product_description_tbProduct[$i] ;
	echo '</option>';
}
echo '</select>*</td>';

echo "<td><select name=\"provider\" style=\"width: 145px\"><option value=\"\">Select...</option>";

for ($i = 0; $i < count($provider_name_tbprovider); $i++) 
{
	echo '<option value="' . $id_provider_array_tbprovider[$i]  . '">' ;
	echo $provider_name_tbprovider[$i] ;
	echo '</option>';
}
echo '</select>*</td>';

echo "<td><select name=\"customer\" style=\"width: 145px\"><option value=\"\">Select...</option>";

for ($i = 0; $i < count($company_namen_customer_tbCustomer); $i++) 
{
	echo '<option value="' .  $id_costumer_array_tbCustomer[$i] . '">' ;
	echo $company_namen_customer_tbCustomer[$i] ;
	echo '</option>';
}
echo '</select>*</td>';

echo "<td><input type = \"text\" name = \"deliverydate\" size = \"$size\" maxlength = \"$maxlength\">*</td>";
echo "<td><input type=\"submit\" name=\"Add\" value=\" Add \"> </td>";
echo "<td></td>";
echo "</tr>";
echo "</form>";
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