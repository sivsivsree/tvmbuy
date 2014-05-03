<?php /*initialising the head*/ include_once("includes/base/head.php"); ?>


   <?php
    $show = false;  $all = false;
   if( isset($_GET['main']) && $_GET['main'] != '' ){
   	   
        

       if( isset($_GET['cat']) && $_GET['cat'] != '' ){
           
           
           $main[0] = htmlentities($_GET['main']);
           $main[1] = htmlentities($_GET['cat']);
           echo "<script type='text/javascript'> var type = 2; var item = new Array('".$main[0]."','".$main[1]."'); </script>";
        ?>
             <!-- random php generator['start'] -->
             <ul class="breadcrumb">
              <li><a href="item.php?main=<?php echo $main[0];?>"><?php echo $main[0];?></a><span class="divider">/</span></li>
              <li class="active"><?php echo $main[1];?></li>
            </ul> 
            <!-- random php generator['ends'] -->
      <?php   
       }else{
       	  $main = htmlentities($_GET['main']);
           echo "<script type='text/javascript'> var type = 1; var item = '{$main}'; </script>";
       }

   }else {
    echo "<script type='text/javascript'> var type = 3; </script>";
    $all = true;
   }

?>

  <h4 id='ItemTotal'><? echo ($all ? 'New Products' : '');?></h4>
  <div id='IDanger' class='alert alert-danger hide Absolute'></div>
  <ul class="thumbnails loadItems span12">


  </ul> 





<?php include_once("includes/base/footer.php"); ?>

 <script type="text/javascript" src='assets/js/items.js'></script>

<?php include_once("includes/base/footerclose.php"); ?>