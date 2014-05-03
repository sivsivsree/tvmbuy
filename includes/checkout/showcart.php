<?php
 
  $user  =  new USER();
  /*the total iten in cart*/
  $TotalCart = $cart->get_order_total();

   /*checking if cart empty  or not*/
?>
<style type="text/css">
	.remove{text-align: center; border-radius:2px;-moz- border-radius:2px; -webkit- border-radius:20px;-o- border-radius:2px;}

	#ten{width: 10px;}
	#c{border: 1px solid rgb(219, 215, 215);resize: none;width: 40px; height:20px; padding: 2px 3px;margin:0;}
	.table th,.table td{text-align: center;}
	.table .t{font-size: 20px; font-weight: bold;}
</style>

  <div class='alert error hide'></div>
    <?php

    if($TotalCart <= 0 ){
	?>
	<div class="cart-empty">
	
	</div>
	<a  href='index.php' class='btn btn-info btn-large btn-block'>Shop Something!</a>
    <?php
    }else{ 
	?>

	<h2>Your cart Contains:</h2>

	<table class='table table-bordered table-hover'> 
	 <tr class='info t'>
	   <td class='span1'>Pid</td>
	   <td class='span4'>Name</td>
	   <td class='span3'>Price</td>
	   <td class='span2'>Quantity</td>
	   <td class='span2'>Total</td>
	   <td id='ten'></td>
	 	
	 </tr>
		<?php
	     


		  foreach ($_SESSION['cart'] as $key => $value) {  
		  		$p = $user->get_nameprice($value['productid']);
		  		$tot =$value['qty']*$p['price'];
		  		$pid = $value['productid'];
		  	?>
		  
		  	
		  	<tr class='<?php echo $pid;?>_c' pid='<?php echo $pid;?>' price='<?php echo $p['price']?>'>
		  	  <td class='muted'>#<?php echo $pid;?></td>
		  	  <td>
		  	  	<b><?php echo $p['name']?></b>
		  	  </td>
		  	  <td class='price'><?php echo $p['price']?></td>
		  	  <td>
		  	  	 <input id='c' class='c' type='text' max='3' value='<?php echo $value['qty'];?>'>
		  	  </td>
		  	  <td>र&nbsp;<span class='<?php echo $pid;?>_T'><?php echo $tot;?></span></td>
		  	  <td>
		  	  	<button class='btn btn-danger btn-mini remove' tot='<?php echo $tot;?>' pid='<?php echo $pid;?>'>&times;</button>
		  	  </td>
		  	<tr>
		  	
		 <?php }

		?>

		<tr>
		   <td colspan='4'><h4 class='pull-right'>Grand Total:</h4></td>
		  
		   <td colspan='2' class='success'><h4>र&nbsp;<span id='grandtot'><?php echo $TotalCart; ?></span></h4></td>
		   
		 </tr>
	</table>

	<div>
	 <a href='index.php' class='pull-left btn btn-success'>Continue Adding</a></a>
	 <a href='order.php?checkout=checkout' class='pull-right btn btn-warning btn-large'>Place Order</a>
	</div>

<?php } /*for the else condition*/ ?>