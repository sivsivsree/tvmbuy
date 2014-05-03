<?php

  $user = new USER();
#To  view the orders
       $uid = (int)$_GET['uid'];
       $sql = "SELECT * FROM orders WHERE status = 0 AND orders.uid = '$uid' ORDER BY time";
       try{
         
         $Mysql = $conn->query($sql);

       }catch(PDOException $e){
         echo "ohhh";
       }
?>
  <h3><small>Showing Orders of user [<?= $uid?>] ,</small><?php echo htmlentities($_GET['name'])?></h3>
  <table class='table table-bordered table-hover'>
    <tr>
      <th>Pid</th>
      <th>Item</th>
      <th>Quantity</th>
      <th>Price</th>
    </tr>

    <?php
        $total = 0;
        while($fetch = $Mysql->fetch(PDO::FETCH_ASSOC)){ 
          $np     = $user->get_nameprice($fetch['pid']);
          $total += $np['price']*$fetch['qty'];    
      ?>
          
          <tr>
          	<td><?php echo $fetch['pid'] ; ?></td>
          	<td><?php echo $np['name'] ; ?></td>
          	<td><?php echo $fetch['qty'] ; ?></td>
          	<td><?php echo $np['price'] ; ?></td>
          </tr>


    <?php }?>

 <tr>
   <td colspan='3'><h4 class='pull-right'>Total</h4></td>
   <td><h4><?php echo $total; ?></h4></td>
 </tr>
</table>