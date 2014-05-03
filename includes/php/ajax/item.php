<?php

 require_once("../../../class/main.php");
 


  $u = new USER();




  #initialising Json Array 
  $data = array(
  			'results' => array(),
  			'success' => FALSE,
  			'error'   => ''
  	      );

  #checking conditions
  if(isset($_REQUEST['process']) && !empty($_REQUEST['process'])) {
      $process = (int)($_REQUEST['process']);

      if($process == 1){

         process1($_REQUEST['main'] , $data );

        if(!empty($data['results'])){
          $data['success'] = true;
         }else{$data['error'] = '<b>'.$_REQUEST['main'].'</b> Out Of Stock!';}

      }else if($process == 2){

      	 process2($_REQUEST['main'] , $_REQUEST['sub'] ,$data );
      	 
      	 if(!empty($data['results'])){
      	 	$data['success'] = true;
      	 }else{$data['error'] = '<b>'.$_REQUEST['sub'].'</b> Out Of Stock!';}
      	 
      }else if($process == 3){
         process3($data);
          if(!empty($data['results'])){
           $data['success'] = true;
         }else{$data['error'] = '<b>'.$_REQUEST['sub'].'</b> Out Of Stock!';}

      }else if($process == 4){
      	#for adding item to cart
      	$kar = new CART();
        $pid = (int)$_REQUEST['pid'];  
        $qty = (int)$_REQUEST['qty'];

         if( $kar ->product_exists($pid) && $qty == 1 ){
         	$kar ->addToCart( $pid , $qty ) ;

         }else{
         	$kar ->updateCart( $pid , $qty ) ;
         }
         
          $data['results'][] =
                            array(
                                'item'  => $kar ->count_cart(),
          					    'total' => $kar ->get_order_total(),
		          			); 
		  $data['success'] = true;

      }


  }



 # to print out Json!
 $u -> USER_jsonEncode($data);




 #function definitions
 function process3(&$data){
    $c = new DBC(); $dbc = $c->dbc();
      
     #using the exeptions to catch error
     try{
       #debugging
       $dbc ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
      #quering 
       $sql = $dbc -> prepare("SELECT * FROM `products` ,`category` WHERE `products`.`cid` = `category`.`cid` ORDER BY  `products`.`pid` DESC  LIMIT 0 , 15 ");

       $sql -> execute();
        
       while( $fetch = $sql -> fetch(PDO::FETCH_ASSOC) ){
        
        $data['results'][] = array(
                   'pid'   => $fetch['pid'],
                               'cid'   => $fetch['cid'],
                               'image' => $fetch['image'],
                               'name'  => $fetch['name'],
                               'price' => $fetch['price'],
                               'about' => $fetch['about'],
                               'time'  => $fetch['time'],

                      );
        

       }



     }catch(PDOExeption $e){
      $data['error'] = "Some Error ".$dbc -> getMessage();
     }

 }

 function process2($main , $sub , &$data  ){
     #intialisng data base connection
     $c = new DBC(); $dbc = $c->dbc();
      
     #using the exeptions to catch error
     try{
     	 #debugging
     	 $dbc ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
     	#quering 
     	 $sql = $dbc -> prepare("SELECT * FROM `products` ,`category` WHERE `products`.`cid` = `category`.`cid` AND ( `category`.`MCat` = :main  AND `category`.`sub` = :sub  ) ORDER BY price");

     	 $sql -> execute(array(':main' => $main , ':sub' => $sub));
        
     	 while( $fetch = $sql -> fetch(PDO::FETCH_ASSOC) ){
     	 	
     	 	$data['results'][] = array(
     	 					   'pid'   => $fetch['pid'],
                               'cid'   => $fetch['cid'],
                               'image' => $fetch['image'],
                               'name'  => $fetch['name'],
                               'price' => $fetch['price'],
                               'about' => $fetch['about'],
                               'time'  => $fetch['time'],

     	 	             	);
     	 	

     	 }



     }catch(PDOExeption $e){
     	$data['error'] = "Some Error ".$dbc -> getMessage();
     }

     

 }

 function process1($main , &$data){
    $c = new DBC(); $dbc = $c->dbc();
      
     #using the exeptions to catch error
     try{
       #debugging
       $dbc ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
      #quering 
       $sql = $dbc -> prepare("SELECT * FROM `products` ,`category` WHERE `products`.`cid` = `category`.`cid` AND ( `category`.`MCat` = :main  ) ");

       $sql -> execute(array(':main' => $main));
        
       while( $fetch = $sql -> fetch(PDO::FETCH_ASSOC) ){
        
        $data['results'][] = array(
                   'pid'   => $fetch['pid'],
                               'cid'   => $fetch['cid'],
                               'image' => $fetch['image'],
                               'name'  => $fetch['name'],
                               'price' => $fetch['price'],
                               'about' => $fetch['about'],
                               'time'  => $fetch['time'],

                      );
        

       }



     }catch(PDOExeption $e){
      $data['error'] = "Some Error ".$dbc -> getMessage();
     }

 }