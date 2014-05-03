<?php
include_once("includes/base/head.php");


if(isset($_GET['page']) && $_GET['page'] != '' ){
	#page set
	$page = $_GET['page'];
	$con = new EXTRA;

	if($page == 'help'){
		$con -> helpCenter();
	}else if($page == 'terms'){
		
		 include_once "includes/pages/terms.html";
	
	}else if($page == 'faq'){
		echo "<pre>";
		  include_once "includes/pages/faq.siv";
		echo "</pre>";

	}else if($page == 'about'){
		include_once "includes/pages/about.html";
	}else if($page == 'sitemap'){
		
		$con->sitemap();
	}


}else{
  #something else..
  header("Location:helpcenter.php?page=help");
}



?>
<?php include_once("includes/base/footer.php"); ?>
  


<?php include_once("includes/base/footerclose.php"); ?>