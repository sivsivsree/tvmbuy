<?php
 

  if(isset($_GET['img'])){
  	header("Content-type:image/jpeg");
  	$image = $_GET['img'];

  	$image_size = getimagesize($image);
  	$image_width  = $image_size[0];
  	$image_height = $image_size[1];

  	$ratio = ($image_width + $image_height) / ($image_width * ($image_height / 75 ));

  	$newWidth = $image_width * $ratio ;
  	$newHeight = $image_height * $ratio ;

  	$newImage = imagecreatetruecolor($newWidth, $newHeight);
  	$oldImage = imagecreatefromjpeg($image);

  	imagecopyresized($newImage, $oldImage, 0, 0, 0, 0, $newWidth, $newHeight, $image_width, $image_height);
 	imagejpeg($newImage, $image."_thump.jpg");

  }else{
     
  }

