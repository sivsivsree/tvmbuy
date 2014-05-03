<script type="text/javascript">
document.title ='Place Order';

</script>



<h3>Please fill the details to place your Order</h3>

<div id='Xky' class='OrderAlert alert alert-danger'>
      <?php
      if(isset($_GET['error']) && $_GET['error'] != '' ){

        echo htmlentities($_GET['error']);
      }else{  ?>
        <script type="text/javascript"> document.getElementById("Xky").style.display = 'none'; </script>
     <?php   }?>

</div>

<form  id='orderForm' action='includes/php/validateOrder.php' type='GET'>

<div class='row-fluid'>
	<div class='span5 row well' >
      
      <div>
      	<b>You Basic Info</b>
      </div>
      <table>
      		<tr>
      			<td>Firstname &nbsp;</td>
      			<td>
      			   <input type='text' class='Of' name='firstname' placeholder='Firstname'>
      			</td>
      		</tr>

      		<tr>
      			<td>Lastname &nbsp;</td>
      			<td>
      			    <input type='text' class='Of' name='lastname' placeholder='Lastname'>
      			</td>
      		</tr>
      		<tr>
      			<td>Email Id &nbsp;</td>
      			<td>
      			    <input type='text' class='Of' name='email' placeholder='Email'>
      			</td>
      		</tr>
       		<tr>
      			<td>Mobile No &nbsp;</td>
      			<td>
      			   <input type='text' class='Of' name='Mobile' placeholder='Mobile Number'>
      			</td>
      		</tr>     		
      </table>

	</div>
	
	<div class='span7 row well'>

	  <div>
      	<b>Delivery Address</b>
      </div>

       <div>
       	  <label>House Name or No</label>
       	  <input type='text' class='span12 Of' name='HouseNo' placeholder='Housename Or HouseNo'>
       </div>

        <div>
       	  <label>Address</label>
       	  <textarea class='span12 Of' name='Address'></textarea>
       </div>
	  
        <div>
       	  <div> <input type='checkbox' name='SaveDetails'  style='margin-bottom: 10px;' checked><small> Save the informations for future Purchase<small></div>
       	  <input type='hidden' name='placeO' value='placeO'>
       </div>

	</div>

	<button  id='placeOrder' class='btn btn-danger btn-large offset9' type='submit' value='Order'>Ok! Place My Order</button>
</div>

</form>


