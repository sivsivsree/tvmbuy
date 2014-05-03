<?php
ob_start();
error_reporting(0);
require_once('class/main.php');

$Dimg = array();

$length = strlen(UPLOAD_LOC.'images/');

$dir = 'manage/images';
$Img = scandir($dir);

foreach ($Img as $key => $value) {
  if($value != '.' && $value != '..' ){
	$fImg[] = $value;
  }
}

$conn = new DBC;
$con = $conn-> dbc();


$q = $con -> query("SELECT image , imageBig FROM products");
while( $dbImg = $q -> fetch(PDO::FETCH_ASSOC) ){
  $Dimg[] = substr($dbImg['image'] , $length);
  $Dimg[] = substr($dbImg['imageBig'] , $length);
}


$result = array_diff($fImg, $Dimg);

if($_GET['clean'] == 'clean'){
	foreach ($result as $key => $value) {
		
			unlink($dir.'/'.$value);
	}
  
}
echo "<pre>";
echo "from file ";
print_r($fImg);
echo "from db ";
print_r($Dimg);
echo "diffrent";
print_r($result);

