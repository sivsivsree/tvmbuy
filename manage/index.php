<?php
 require_once('../class/admin.php');

 
 $con = new ADMIN();

#redirection of non admin user
 try{

   $con -> IsLogged();
 }catch(Exception $e){
   header("Location:secure.php");
 } 

 require_once('include/content/head.php');

?>

<div class='row-fluid'>

<div><h4>Summary:</h4></div>

<div span='span8 text-center'></div>


  <p> 
  	 
     <li>Total <b><?php echo $con->OrderCOunt(); ?></b> user details in databse</li>
     <li>[<a href='order.php'><b><?php echo $con->PendingCount(); ?></b></a>] orders pending</li>


  </p>
 
  <p>
  	
  </p>


</div>

<?php require_once('include/content/foot.php'); ?>