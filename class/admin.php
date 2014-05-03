<?php
 ob_start();
 session_start();
 require_once("main.php");

class ADMIN{
	#to store connection
	private $_con;

    public function __construct(){
    	$n = new DBC();
		$this ->_con = $n -> dbc(); //connection instance created
    }

  #function to check user is admin or not
    public function IsLogged(){
    	
    	if(!isset($_SESSION['manage']) ){
	    	throw new Exception("Please Login to Continue");
	     }else if($_SESSION['manage'] != 'manage'){
	     	throw new Exception("Please Login to Continue");
	     }
    }

   #functin to return the conn variable
   public function conn(){
   		return $this->_con;
   }

   #to get ip addr!
   public function GetIp(){

		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		   $ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
			$ip = $_SERVER['REMOTE_ADDR']; 
		}
	return $ip;

  }

  public function OrderCOunt(){
  	
  	$val = $this->_con ->query("SELECT count(*) FROM user ");
  	return $val -> fetchColumn();
  }

  public function PendingCount(){
    #Pending COunt
  	$val = $this->_con ->query("SELECT count(*) FROM orders  ");
  	return $val -> fetchColumn();
  }
 public function amount($uid){
  $val = $this->_con ->query("SELECT SUM( products.price *orders.qty)  FROM products RIGHT JOIN orders ON orders.pid = products.pid  AND orders.uid= '$uid' ");
  return $val -> fetchColumn();

 }  
 public function category(){ 
   $val =  $this ->_con->query("SELECT * FROM category");
     ?>

       <table class='table table-bordered'> <tr> <th>CID</th> <th>Main Category</th> <th>Sub Category</th> <th>Delete</th> </tr>
   
    <? while($fetch = $val->fetch(PDO::FETCH_ASSOC)){ ?>
      
        <tr> <td><?php echo $fetch['cid'] ?> </td> <td><?php echo $fetch['MCat'] ?></td> <td><?php echo $fetch['sub'] ?></td> <td style='text-align:center;'><input type='checkbox' name='cat[]' value='"<?php echo $fetch['cid'];?>"'></td> </tr>
    
    <?php } ?>
       <tr> <td colspan=3></td> <td><input type='submit' class='btn btn-block' value='delete'></td> </tr> </table> <?

  }

  public function category_del(){
     

          foreach ($_GET as $key => $val) {
            foreach ($val as $key => $value) {
              
               try {
                 
                 $this ->_con-> query("DELETE FROM products WHERE cid = {$value}");
                 $this ->_con-> query("DELETE FROM category WHERE cid = {$value}");
                 
               } catch (PDOException $e) {
                echo "Something went Wrong";
               }
             

            }
         }


       

  }


}
