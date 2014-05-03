<?php
 require_once('../class/admin.php');

 
 $con = new ADMIN();
 $conn = $con->conn();
#redirection of non admin user
 try{$con -> IsLogged(); }catch(Exception $e){header("Location:secure.php"); } require_once('include/content/head.php');

 if(isset($_GET['uid']) && $_GET['uid'] != '' ){
    if(isset($_GET['view']) && $_GET['view'] == 1 ){

       include_once('include/php/search-view.php');
    }else if(isset($_GET['q']) && $_GET['q'] != 1){
      
      #include search page
    }
 }
?>


</div>
</body>
</html>