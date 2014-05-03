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

 require_once('include/content/head.php');
  
 $sql = "SELECT * FROM user WHERE status = 0 ORDER BY time";

 try{
   
   $Mysql = $conn->query($sql);

 }catch(PDOException $e){
   echo "ohhh";
 }
  
 $fetch = $Mysql->fetchAll(PDO::FETCH_ASSOC);

 ?>
<form action='action.php' method='get'>
  <table class='table table-bordered table-hover'>
 <tr>
 			<th class='span1'>OId</th>
 			<th class='span4'>Name </th>
 			<th>Phone</th>
 			<th  class='span4'>Address</th>
 			<th>Amount</th>
 			<th class='span3'>Time</th>
 			<th>Items</th>
 			<th class='text-center'>delete</th>
 </tr>
 
 <?php 
  foreach ($fetch as $key => $v) {
    $p = $con->amount($v['uid']);
  	if( $p > 0  ){ ?>

  
	    <tr>
	     <td><?php echo $v['uid'] ?></td>
	     <td><?php echo $v['firstname'].' '.$v['lastname'] ?></td>
	     <td><?php echo $v['phone'] ?></td>
	     <td><?php echo $v['address1'].','.$v['address2'].','.$v['city']?></td>
	     <td><b><?php echo $p ?></b></td>
	     <td><?php echo gmdate("d/ m/ Y ,g:i A ", $v['time']) ?></td>
	     <td>[<a href='search.php?uid=<?php echo $v['uid']?>&name=<?php echo $v['firstname'].' '.$v['lastname'] ?>&view=1'>view</a>]</td>
	     <td class='text-center'><input type ="checkbox" name="del[]" value = "<?php echo (int)$v['uid'] ?>"></td>
	    </tr>
<?php }
  }
?>
  
   <tr>
   	<td colspan=7></td>
   	<td><input class='btn' type='submit' value='Submit'></input></td>
   </tr>
</table>
</form>







</div>

<?php require_once('include/content/foot.php'); ?>