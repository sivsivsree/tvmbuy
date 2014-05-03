<?php
 ob_start();
   require_once('class/main.php');
   $cart  =  new CART(); 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TVMbuy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="You Order We Deliver">
    <meta name="author" content="Siv.S">

    
    <link rel="stylesheet" type="text/css" href="assets/css/shop.css">
    <link rel="stylesheet" type="text/css" href="assets/css/shop2.css">

    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <script type="text/javascript" src='assets/js/cookie.js'></script>

    


    
    
  </head>
  <body>
<!-- navigation [starts] -->

<!-- here is the content -->
    <div class='top-nav-main '>
     <div class='container'>
      <div class='row-fluid'>
        
        <div class='span8'>
          <div class='span12 row-fluid'>
                      <div class='span4'><h2><a class='branD' href='index.php' style='text-decoration:none'>TvmBuy</a></h2></div>
                       <!-- accout info link -->
                      <div class='span4'>
                         <div class='fadE'><b><u>Need Help?</u></b></div>
                         <div class='fadE'><a href='helpcenter.php?page=help'>How to Purchase?</a></div>
                         <div class='fadE'><a href='order.php?checkout=cart'>Order Details</a></div>
                      </div>
                      <!-- contact and call no -->
                      <div class='span4'>
                        <div class='fadE'><b><u>24x7 Support</u></b></div>
                        <div class='fadE'>9876543210</div>
                        <div class='fadE'>0123456789</div>
                      </div>

          </div>
          <!-- for search -->
          <div class='span12'>
            <div class="input-append" style="display:none;">
              <input id='searchInput' class="span10"  placeholder='Search for your item' type="text">
              <button id='advGo' class="btn btn-primary" type="button">Go!</button>
            </div>
          </div>
        </div>
        
        <div id='cartMenu' class='span4'>
           
          <div class=''> <b><span id='cartCount'><?php echo $cart->count_cart() ?></span></b> Items in Cart </div>
          <div class=''><h4>Rs: <span id='cartCost'><?php echo $cart->get_order_total(); ?></span></h4></div>
        
          <div class=''><a id='cartBtn' class='btn btn-success' href='order.php?checkout=cart'>View Cart</a></div>
        </div>
      </div>

      </div>
       <!-- navigation category -->
       <div class='nav-mini'> 
         <div id='' class='container Relative'>
            <!-- quick navigation -->
            <div id="horizontalmenu" class='ul-nav-mini'>
              <ul class='innerMe'> 

                <?php
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

                    foreach ($MCat as $key => $value) { 
                      $keyz = trim($key);
                     ?>
                    <li><a href='item.php?main=<?php echo $keyz?>' ><?php echo $keyz?></a>
                      <ul class='sub-menu hide' >

                    <?php  foreach ($value as $key => $value) { ?>
                        <li main='<?php echo $keyz; ?>' val='<?php echo $value; ?>'><?php echo $value ?></li>
                     <?php } ?>
                     
                     </ul>
                   </li>
                   
                  <?php } ?>
                

                
                                                     
              </ul>
             
            </div>
             <!-- search results  -->

             <div id='results' class='Absolute container hide'><li>This is search results</li></div>

         </div>
       </div>
    </div>

    <!-- navigation [ends] -->


<!-- the content starts here -->
<div id='MainC' class='container'>
  <div class='row'>
