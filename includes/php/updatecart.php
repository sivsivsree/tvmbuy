<?php
require_once("../../class/main.php");

$crt = new CART();

if(isset($_REQUEST['method']) && $_REQUEST['method'] != '' ){
	$sort = $_REQUEST['method'];
	if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' ){
		$pid = (int)($_REQUEST['pid']);
	}

	if( $sort == 'delete' ){
		#to delete items
		if($crt -> remove_product($pid)){
			echo "1";
		}else{
			echo '0';
		}

	}else if($sort == 'update'){
		#to update qty
	  if(isset($_REQUEST['qty']) && $_REQUEST['qty'] != ''){
	  	$qty = (int)($_REQUEST['qty']);
         
         if($crt -> updateCart($pid,$qty)){
			 echo $crt->get_order_total();
		 }else{
			echo '0';
		 }


	  }

	}
 

 #(parent [ if ]) 
}
