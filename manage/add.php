<?php
 require_once('../class/admin.php');

 
 $con = new ADMIN();
 $conn = $con->conn();
 $f = new EXTRA();
#redirection of non admin user
 try{

   $con -> IsLogged();
 }catch(Exception $e){
   header("Location:secure.php");
 } 

 require_once('include/content/head.php');
 
 if(isset($_GET['add']) && $_GET['add'] == 'cat'){
 	#to add category
     require_once('include/php/addcat.php');

 }else{
   #product add

 	if(isset($_POST['addP']) && isset($_FILES['file']) ){
      $ok = true; $file_ok = false; $thisError = true;
      
      foreach ($_POST as $key => $value) {
          if(trim($value == '')){
              $ok = false; break;
          }else{
            $_POST[$key] = htmlentities($value);
          }
      }

      
      if($_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/png' ){
        
         $file_ok = true;
         $file_loc = 'images/'.sha1(microtime()).'.jpg';
         move_uploaded_file($_FILES['file']['tmp_name'], $file_loc);
         $f -> thumbnail($file_loc);
      }
     

      if($ok && $file_ok){
        

        try{
           $conn ->beginTransaction();

             $getCid = $conn -> query("SELECT  cid FROM `category` WHERE MCat = '". $_POST['Main_Category']."' AND sub = '".  $_POST['Sub_Category'] ."'  ");
            
             $cid = $getCid -> fetchColumn();

            $q = $conn -> prepare ("INSERT INTO `products` (name , cid , image, imageBig ,  price, about , time) VALUES (:name , :cid ,:image,:imageB , :price , :about , :time)" );
            $q -> execute(
                array(
                    ':name'  => $_POST['name'],
                    ':cid'   => $cid,
                    ':image' => UPLOAD_LOC.$file_loc.".thump.jpg",
                    ':imageB'=>UPLOAD_LOC.$file_loc,
                    ':price' => (int)$_POST['price'],
                    ':about' => $_POST['about'],
                    ':time'  => time(),
                  ) );
           $remove = $conn -> lastInsertId();
           $conn -> commit();
        }catch(PDOExeception $e){
          echo "There was some problem, code error 333!";
          $conn -> rollBack();
          $thisError = 0;
        }
        if($thisError){
           print "<div class='alert alert-success'><b>".$_POST['name']."</b> Added Successfully! <span class='text-danger'><a href='add.php?remove={$remove}'>Undo</a></span></div>";
        }
      }
    
 	}

#getting values of select!
 	$agn = $conn -> query("SELECT * FROM category");
    $optin = $agn->fetchAll(PDO::FETCH_ASSOC);
    
    $option = array(
    		'Beverages',
    		'Foods Snacks',
        'Fruits',
    		'Grocery',
    		'Health',
    		'Household',
    		'Personal Care',
    		'Stationary',
    		'Vegetables'

    	);
    //print_r($option);	
     				

 					
if(!empty($error)){
	foreach ($error as $e) {
		echo "<div class='alert alert-danger'>$e</div>";
	}
}			

?>
<script type="text/javascript">
document.title ="Add Item";
</script>
<form id='form' method="post" action='' enctype='multipart/form-data'>

 <table class='table table-bordered'>
 	<tr>
 		<td class='span2'>
 			Product name
 		</td>
 		<td>
 			<input type='text' name='name' placeholder='Product Name'>
 		</td>
 		<td class='span1'>
 			Image
 		</td>
 		<td>
 			<input type='file' id='file' name='file' >
 		</td>

 	</tr>

 	<tr>
 		<td class='span2'>
 			Category
 		</td>
 		<td class='row'>
 			<select id='mainAjax' name='Main Category' class='span2'>
 				<option value=''>Select</option>
 				<?php
 				   foreach ($option  as  $optn) {
 						echo "<option value='".$optn."'>".$optn."</option>";
 					}
 				?>
 			</select>
      <span id='sel_con'>
   			<select id='subAjax' class='span2' name='Sub Category'>
   				<option value=''>Select</option>
   			</select>
    </span>
 		</td>

 		<td class='span2'>
 			Price
 		</td>
 		<td>
 			<input type='text' placeholder='Price' name='price'>
 		</td>

 	</tr>
 	<tr>
 		<td>About:</td>
 		<td colspan=2 >
           <textarea style='resize:none;width:90%' placeholder='About Product' name='about'></textarea>
 		</td>
 		<td style='text-align:center'>
 			<p>Yes finished! Add Product to Public Page..</p>
          <button id='addP' type='submit' class='btn btn-warning btn-block' name='addP' value='addP'>Add Product</button>
 		</td>

 	</tr>
 </table>
</form>

      <script type="text/javascript" src='../assets/js/jquery.js'></script>

      <script type="text/javascript">

      $('#mainAjax').change(function (){
        var main = $(this).val();
          $.ajax({
            url :'include/php/ajaxfunctions.php',
            type:'post',
            data:{main:main,functio:'select'},
            beforeSend:function(){
              $('#subAjax').html($('<option>' ,{value:'', text: 'Loading..', }));
            },
            success:function(data){
               $("#sel_con").html(data);
            }

          });



      });

      $('#form').submit(function(){
        var ar = Array(),i=0;
        $('#form input , textarea, select').each(function(){
          ar[i] = $(this).val() ;
          i++;
        });
        
        for (i=0 ; i<6 ; i++){
          if(ar[i] == ''){
            
            alert("please fill all the feilds");
            return false;
            break;
          }
        }
        
      });

      
      </script>
    </div>
  </body>
</html>

<?php } ?>