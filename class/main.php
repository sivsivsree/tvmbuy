<?php
/**
*  
* @author siv
* @copyright siv @ 7/7/2013 12:23 am 
*
*
*included class
*------------
*  DBC
*  USER
*  CART
*  EXTRA
**/

define('UPLOAD_LOC', 'http://'.$_SERVER['HTTP_HOST'].'/shopkart/manage/');

/*************************************************
*    The class used to create  PDO  connection
*************************************************/
class DBC{
   
	private $_host      = 'localhost';
    private $_dbname    = 'shopcart';
    private $_username  = 'root';       
	private $_password  = '';   




	private $_db;

  #methods 

	public function __construct() {
		#data conection auto
		try{
			#connecting to data base
		   $this ->_db = new PDO('mysql:host='. $this->_host .';dbname='. $this->_dbname .'', $this->_username  , $this->_password  );
		   $this->_db->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );
		}catch( PDOException $e ){
		   #throw an exeption
		   echo  $e -> getMessage();
		   
		}

     }

     public function dbc(){
     	return $this ->_db;
     }

}

/*************************************************
*    The class used to retrive the values from  
*     database using the PDO 
*************************************************/

class USER{
  
  #properties
	private $_dbh;

  #methods
	public function __construct(){
		$n = new DBC();
		$this -> _dbh = $n -> dbc(); //connection instance created


	}
    
    #function to  show items uisng categories
	public function USER_showCatergory($category,$price = FALSE){
		if($price == TRUE){
	       $sql = "SELECT * FROM products WHERE category = '$category' ORDER BY PRICE ASC ";
		}else{
		   $sql = "SELECT * FROM products WHERE category = '$category' ORDER BY PRICE DESC ";	
		}

		try{

			$fetch = array();

			$after = $this->_dbh ->query($sql);
			
			while($data = $after->fetch() ){
				$fetch['result'][] =  array(
                        'pid'      => $data['pid'],
                        'name'     => $data['name'],
                        'image'    => $data['image'],
                        'about'    => $data['about'],
                        'price'    => $data['price'],
                        'category' => $data['cid'],
				 	);
			}
			$fetch['success'] = true;
			return $fetch;


		}catch (PDOException $e){
		   echo $e->getMessage();
		}


	}
    
    #function to output array as json
    public function USER_jsonEncode($data){
    		
    	header('Content-Type:application/json;charset = UTF-8');
        echo json_encode((object)$data);
    
    }

   #return price
   public function get_nameprice($pid){
		 $pid = (int)$pid;
		try{
			 $sql = "SELECT `price`,`name` FROM `products` WHERE `pid` = '$pid' ";
			 $next = $this->_dbh ->query($sql);

			 while($ret = $next -> fetch() ){
			 	return $ret;
			 }
		 }catch(PDOException $e){
             return 'Error';
		 }
		
	}

    

} 

/*************************************************
*    The class used to mantain the shopping cart 
*     using PHP Sessions
*************************************************/
class CART{

   
   public function __construct(){
      if(!isset($_SESSION)){
      	session_start();

      	if(!isset($_SESSION['cart'])){
      		$_SESSION['cart'] = array();
      	}
      }

   }  

   #methods

	    #function to add to cart
    public function addToCart($pid,$q = 1){
		if($pid<1 or $q<1) return;
	 
		if(is_array($_SESSION['cart'])){
			$arr = $this -> product_exists($pid);
			
			if($arr['success']){
				
				$_SESSION['cart'][ $arr['pos'] ]['productid']=$pid;
				$_SESSION['cart'][ $arr['pos'] ]['qty'] += 1;

			}else{
				$max=count($_SESSION['cart']);
				$_SESSION['cart'][$max]['productid']=$pid;
				$_SESSION['cart'][$max]['qty'] = $q;

			}

		}else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
		}
	}

    public function updateCart($pid,$q = 1){
        $this -> remove_product($pid);
    	$this -> addToCart($pid,$q);
    	return true;
    }
    
    #functin to check if product exists
	public function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag= array('success'=> 0, 'pos' => 0 );
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				$flag['success']=1;
				$flag['pos'] = $i;
				break;
			}
		}
		return $flag;
	}

	#function to remove product
	public function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
		return true;
	}
   
   #to show the cart Price
   public function get_order_total(){
   	    $x = new USER();
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
		    $price = $x -> get_nameprice($pid);
			$sum+=$price['price']*$q;
		}
		return $sum;
	}

	public function count_cart(){
		return @$max=count($_SESSION['cart']);
	}

}


class EXTRA {
 public  function helpCenter(){
 	?>
 	<div class='text-center'>
 	   <h1>Welcome to Help Center!</h1>
 	   <div class='well text-left'>
 	   	 <h3>How to shop?? still worried?</h3>
 	   	 <p>
 	   	 	<b>here we go....</b>
 	   	 </p>
 	   </div>
    </div>
 	<?
 }
 public function thumbnail($image){
 	
	  	$image_size = getimagesize($image);
	  	$image_width  = $image_size[0];
	  	$image_height = $image_size[1];

	  	if($image_height >= 181 || $image_width >= 181){

		  	$ratio = ($image_width + $image_height) / ($image_width * ($image_height / 75 ));

		  	$newWidth  =  $image_width * $ratio ;
		  	$newHeight =  $image_height * $ratio ;
	    }else{

		  	$newWidth  =  $image_width;
		  	$newHeight =  $image_height;
	    }

	  	$newImage = imagecreatetruecolor($newWidth, $newHeight);
	  	$oldImage = imagecreatefromjpeg($image);

	  	imagecopyresized($newImage, $oldImage, 0, 0, 0, 0, $newWidth, $newHeight, $image_width, $image_height);
	 	imagejpeg($newImage, $image.".thump.jpg");

	  
 }

 public function sitemap(){
 	            $n = new DBC();
                  $c = $n->dbc();
                  
                  $MCat = array();

                  try{
                   // $c->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 

                    $s =$c->query("SELECT * FROM category ORDER BY MCat ASC");
                     while($dat = $s->fetch(PDO::FETCH_ASSOC)){ 
                            $MCat[ $dat['MCat'] ][] = $dat['sub'];
                     }

                  } catch(PDOExeption $e){
                    echo "Some thing went wrong! Please Try again!";
                  }
                  	echo "<h2>Site Map</h2><div class='well '>";
                  	echo "<ul style='font-size:1em;padding:2em'>";

                    foreach ($MCat as $key => $value) { 
                      $keyz = trim($key);
                     ?>

                    <li style='padding:1em;'>
                    <a href='item.php?main=<?php echo $keyz?>' ><?php echo $keyz?></a>
                      <ul>

                    <?php  foreach ($value as $key => $value) { ?>
                        <li>
                        	<a href='item.php?main=<?php echo $keyz?>&cat=<?php echo $value ?>'><?php echo $value ?></a>
                        </li>
                     <?php } ?>
                     
                     </ul>
                  
                   </li>
                  <?php } 
                  echo " </ul></div>"; 
 }



  public function IndexWelcome(){ ?>
  	 <!-- dynamic contents -->	
  <div class='text-center'>
   <h2 style='font-size:4em;line-height: .7;'>Welcome to </h2>
   <h1 style='font-size:6em;line-height: .7;'>TVMbuy<b style='font-size:.4em;'>.com</b></h1>
   <a class="btn btn-link" href="index.php">Start Ordering</a>
 </div>

  

   <?php
  }


}


