<?php

if(isset($_POST['savecat'])){
   if(isset($_POST['main']) && isset($_POST['sub'] ) ){
     if($_POST['main'] != '0' && $_POST['sub'] != '' ){
        $sub = ucfirst(strtolower($_POST['sub']));
      

        try{
          #transaaction
          $conn -> beginTransaction();

            $nxt = $conn -> prepare("INSERT INTO  category (MCat , sub) VALUES ( :mcat , :sub) ;" );
             $nxt -> execute(array(
                  ':mcat' => $_POST['main'],
                  ':sub'  => $sub
               ));
          $remove = $conn -> lastInsertId();
          $conn -> commit();
        }catch(PDOException $e){
          echo "Please Try again..";
          $conn -> rollBack();
        }
        
        print "<div class='alert alert-success'><b>".$sub."</b> Added Successfully! <span class='text-danger'><a href='add.php?add=cat&remove={$remove}'>Undo</a></span></div>";
     }else{
      print "<div class='alert alert-danger'>Please fill all the feilds!</div>";
     }
   }

 }else if(isset($_GET['remove']) && !empty($_GET['remove'])){
  $remove = (int)$_GET['remove'];

  $conn->beginTransaction();
    try{
      $sql = "DELETE FROM `category`  WHERE `cid` = {$remove}";
      $nxt = $conn -> query($sql);
      $conn -> commit();
    }catch(PDOException $e){
      echo "Failed Try again after Sometime.. $e";
      $conn -> rollBack();
    }
   echo "Undo Complete!";
 }
?>

 <form action='' method='POST'>

 <div class='text-center'>
 
 <b>Choose the main category:</b><br>
  <select name='main'>
      <option value='0'>choose:</option>
      <option value='Vegetables'>Vegetables</option>
      <option value='Beverages'>Beverages</option>
      <option value='Foods Snacks'>Foods Snacks</option>
      <option value='Fruits'>Fruits</option>
      <option value='Grocery'>Grocery</option>
      <option value='Health'>Health</option>
      <option value='Household'>Household</option>
      <option value='Personal Care'>Personal Care</option>
      <option value='Stationary'>Stationary</option>
  </select>
  <br>

  <b>Add the submenu:</b><br>

  <input type='text' name='sub' placeholder='Enter a subcategory' >
   <br>
  <input class='btn' type='submit' name='savecat' value='save'> 
 </div>

</form>