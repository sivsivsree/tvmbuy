<?php
 require_once('../class/admin.php');

 
 $con = new ADMIN();
 $conn = $con->conn();
#redirection of non admin user
 try{

   $con -> IsLogged();
 }catch(Exception $e){
   header("Location:secure.php");
 } 

 #to handle the delete 
 if(isset($_GET['cat']) && !empty($_GET['cat'])){
  $con -> category_del();
 }
#to delete the order

if(isset($_GET['del'])){
 #delete order
	foreach ($_GET as $key => $val) {
		foreach ($val as $key => $value) {
		
		 $value =  (int)($value);
		 try {
		 
		 	$conn -> query("DELETE FROM orders WHERE uid = {$value}");
		 } catch (PDOException $e) {
		 	echo "Something went Wrong";
		 }
		 

		}
	}

	header("Location:order.php");
	
}else if(isset($_GET['alter']) ){
 
  #deleting category

  

  require_once('include/content/head.php');
   
  echo "<form action='' method = 'get'>";
    
   $con -> category();

  echo "</form>";
 
}else{
	header("Location:action.php?alter=false");
}


 require_once('include/content/foot.php');


 ?>