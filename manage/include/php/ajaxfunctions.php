<?php
 

  if(isset($_POST['functio'])){
      
    require_once('../../../class/admin.php');

  	 if( $_POST['functio'] == 'select' && $_POST['main'] ){
  	 	 $data = array(
                  'error' => 1,
                  'optns' => array()
  	 	 	);

  	 	 $con = new ADMIN();
         $conn = $con->conn();

        $sql = "SELECT `sub` FROM `category` WHERE MCat = '".$_POST['main']."' ";
        $q = $conn -> query($sql); 
        ?>
        <select id='subAjax' class='span2' name='Sub Category'>
        <?php while($t = $q->fetch(PDO::FETCH_ASSOC) ){ ?>
        <option value='<?=$t['sub']?>'><?=$t['sub']?></option> 
        <?php } ?></select><?php
        
  	 }

  }else
    die("Nothing here!");
?>