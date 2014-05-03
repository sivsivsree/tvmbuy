<?php
 require_once('../class/admin.php');

 
 $con = new ADMIN();

#redirection of non admin user
 
 try{

   $con -> IsLogged();
   header("Location:index.php");

 }catch(Exception $e){
   
 } 
 
#require feilds
?>
<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <title>Secure Portal</title> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <meta name="description" content=""> <meta name="author" content=""> <link rel="stylesheet" type="text/css" href="../assets/css/shop.css"> <link rel="stylesheet" type="text/css" href="../assets/css/shop2.css"> <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> <script type="text/javascript" src='../assets/js/cookie.js'></script> </head> <body> <div class='container'>

<?php

 $err = array();
#validating Authentication
 if(isset($_POST['submit']) && $_POST['submit'] == 'Authorise' ){
    
    if($_POST['id'] != '' && $_POST['password'] != ''){

       if( 
       	   md5(trim($_POST['id'])) == 'd4780e9fea89c01af6e665b621e962e9'
       	   && md5(trim($_POST['password'])) == '1e899157ef5e8a9cba484ef79b7599c7'
       	){

       	   echo $_SESSION['manage'] = 'manage';
           header("Location:index.php");

       }else{
       	 $err[] = 'Authentication failed';
       }

    }else{
    	$err[] = 'Feilds Required!';
    }

 }

 foreach($err as $e){

    echo "<div class='alert'>$e</div>";

 }

?>

<h2 class='text-center '>Admin Portal</h2>
<form action='' method='POST'>
 <div class='text-center'>

 	<div>
 	  <input type='text' name='id'>
 	</div>

 	<div>
 	  <input type='password' name='password'>
 	</div>
 	
 	<div >
 		<input type='submit' class='btn span3' name='submit' value='Authorise'>
 	</div>

 </div>
</form>
<br>
 <div class='text-center well alert'>
   <p>For security reasons we keep your IP adderess. 
   	 Your IP address is <b><?php echo $con->GetIp(); ?></b>
   </p>
 </div>


<?php require_once('include/content/foot.php'); ?>