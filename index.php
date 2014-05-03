<?php
ob_start();
require_once('class/main.php');
/*initialising the class objects*/ 
$u = new CART; 
/*initialising the head*/
   if(isset($_GET['success']) && $_GET['success'] != '' ){ ?>
 <!--  For all success functions -->
      <div id='indexAlert' class='alert-success'>
       <p><?php echo htmlentities($_GET['success']) ?> </p>
          <?php if( isset($_GET['id']) && $_GET['id'] != ''){ ?>
          <p>Please Note down your Order Id  <b>#<?php echo htmlentities($_GET['id'])?></b></p>
         <?php } ?>
      </div>

<?php  } 

  
   include_once("includes/base/head.php");
   
   if(!isset($_COOKIE['welcome'] ) ){
     header("Location:?welcome=land");
     setcookie('welcome' , '1' , time()+(60*60*60));
   }

   if(isset($_GET['welcome']) && $_GET['welcome'] == 'land'){
     $v = new EXTRA();
     $v->IndexWelcome();

   }else{
    include_once('welcome.html');
   }

?>

  

 


<?php include_once("includes/base/footer.php"); ?>
  


<?php include_once("includes/base/footerclose.php"); ?>
