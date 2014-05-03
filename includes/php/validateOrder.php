<?php
require_once("../../class/main.php");

	$d = new DBC();
		$dbh = $d -> dbc();
	$kart = new CART();


$redirect = "Location:../../order.php?checkout=checkout&error=";

  if(isset($_GET['placeO']) && $_GET['placeO'] =='placeO' ){
   
  	if(empty($_SESSION['cart']) ){
  		 header($redirect."Your Cart is Empty");
  		 die('redirecting');
  	}

  	

    $bind =""; $name = '';
    foreach ($_GET as $key => $value) {
     
      if($value == ''){
       	header($redirect."{Please Fill all the feilds");
      }else{

  	      if($key == 'firstname' || $key =='lastname'){
  	     	  $value = ucfirst($value);

  	      }else if($key == 'email'){
    	     	
              if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      			   header($redirect."{$value} is not valid!");
      			   die('redirecting');
      			  }
  	      }  
      }

       
       if($key != 'placeO' && $key != 'SaveDetails'){
       	  $value = mysql_real_escape_string(htmlentities($value));
       	  $bind .=  "'".$value."'," ;
       }
    
    }
    
   $ip   = $_SERVER['REMOTE_ADDR'];
   $time = time();
   /*/bind*/
   $sql = "INSERT INTO user (`firstname` , `lastname` , `email` , `phone` ,`address1`, `address2`,`ip`,`time` ) VALUES ( {$bind} '".$ip."','".$time."' )";
 

    

    try {  
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->beginTransaction();

      $dbh->exec($sql);
      $id = $dbh->lastInsertId();
        
        # what if i added unset($_SESSION['something']) ; 
        #will it roll back this also??

	    foreach ($_SESSION['cart'] as $key => $value) {
	     	$SQL = "INSERT INTO `orders` (`uid`, `pid` , `qty` , `time`) VALUES('{$id}', '".(int)$value['productid']."' , '".(int)$value['qty']."' , '{$time}')";
	     	$dbh ->exec($SQL);
	    }


      $dbh->commit();
    }catch (Exception $e) {

	     $dbh->rollBack();
	     header($redirect. "Failed to place your Order " .$e->getMessage());
	     die('redirecting');
	  }



	  $exp = time()+60*60*24*360;
    setcookie("uid", $id,$exp);
    setcookie("time"."_".$id,$time,$exp);
	  unset($_SESSION['cart']);

    header('Location:../../?success=Your Order has been Processing, Check your email [ '.$_GET['email'].' ] for more details! Order will be deliverd within 6 hours!&id='.$id);
    die('redirecting');

  }else{
  	header($redirect."Please%20try%20again!");
  	die('redirecting');
  }
