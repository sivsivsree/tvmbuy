<?php
ob_start();
require_once('class/main.php');
/*initialising the class objects*/ 
$get='';
if(isset($_GET['checkout']) && $_GET['checkout'] != ''){
	$get = trim( strtolower($_GET['checkout']) );
}



/*initialising the head*/
   include_once("includes/base/head.php");
 if($get == 'cart'){
	  
	  echo " <script type='text/javascript'>document.getElementById('cartBtn').style.display = 'none'; </script>";
	  include("includes/checkout/showcart.php");
	
	}else if( $get == 'checkout'){ 
	  #Check Out Place
	  if( empty($_SESSION['cart']) ){
  		 header("Location:index.php?success=You have an Empty cart!");
  		 die("died");

  	  }else{
		include("includes/checkout/placeorder.php");
	  }

	}else{
		header("Location:index.php");
		
	}


?>


<?php /* initialising the footer */ include_once("includes/base/footer.php"); ?>
<?php include_once("includes/base/footerclose.php"); ?>