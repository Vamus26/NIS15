<?php

$dbHost = "localhost";
$dbUser = "testuser";
$dbPass = "hase";
$dbName = "sales";
$console = false;

// make connection to the database server
//$con=mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

$connect = @mysql_connect($dbHost, $dbUser, $dbPass) or die("<p class='error'>ERROR: Unable to connect to database server!</p>");
$selectDB = @mysql_select_db($dbName, $connect) or die("<p class='error'>ERROR: Unable to select $dbName!</p>");

//require('connect.php');

if ($console) {
	$xml_trans = 'server';
	$firstname = "true";
} else {
	$xml_trans = $_GET['xml_trans'];
	$firstname = $_GET['firstname'];
}

$tablename = 'sales.customer';
$maxlength = 50;
$size = 15;

$response_server = "";

$idcostumer_array = array();
$company_array = array ();
$firstname_array = array();
$lastname_arry = array();
$zip_array = array();
$city_array = array();
$mail_array = array();

$query = mysql_query("SELECT * FROM $tablename");

while($row = mysql_fetch_array($query)) {
	$idcostumer_array[] = $row['idcustomer'];
	$company_array[] = $row['Company'];
	$firstname_array[] = $row['Firstname'];
	$lastname_array[] = $row['Lastname'];
 	$street_array[] = $row['Street'];   
	$zip_array[] = $row['Zip']; 
	$city_array[] = $row['City'];
	$mail_array[] = $row['email'];
}
/* close connection to the database server */
@mysql_close($connect);

/* create a dom document with encoding utf8 */
$domtree = new DOMDocument('1.0', 'UTF-8');
if ($xml_trans == "client") {
	if ($firstname == 'true') {
		$xslt = $domtree->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="customercatalogfirstname.xsl"');
	} else {
		$xslt = $domtree->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="customercatalog.xsl"');
	}
	header("Content-Type: text/xml");
	$domtree->appendChild($xslt);	
}

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("catalog");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

for ($i = 0; $i < count($idcostumer_array); $i++) {
	$currentTrack = $domtree->createElement("customer");
	$currentTrack = $xmlRoot->appendChild($currentTrack);
	$currentTrack->appendChild($domtree->createElement('id',$idcostumer_array[$i]));
	$currentTrack->appendChild($domtree->createElement('company',$company_array[$i]));
	$currentTrack->appendChild($domtree->createElement('firstname',$firstname_array[$i]));
	$currentTrack->appendChild($domtree->createElement('lastname',$lastname_array[$i]));
	$currentTrack->appendChild($domtree->createElement('street',$street_array[$i]));
	$currentTrack->appendChild($domtree->createElement('postcode',$zip_array[$i]));
	$currentTrack->appendChild($domtree->createElement('city',$city_array[$i]));
	$currentTrack->appendChild($domtree->createElement('mail',$mail_array[$i]));
}

/* get the xml printed */
if ($xml_trans == "client") {
	echo $domtree->saveXML();
}
if ($xml_trans == "server") {
	// $xsl - XSL file
	$xsl = new DOMDocument;
	if ($firstname == "true") {
		$xsl->load('customercatalogfirstname.xsl');
	} else {
		$xsl->load('customercatalog.xsl');
	}
	/* Create an XSLT processor */
	$proc = new XsltProcessor;
	$proc->importStyleSheet($xsl);
	/* Perform the transformation */
	$html = $proc->transformToXML($domtree);
	/* Output the resulting HTML */
	echo $html;
}

?>
