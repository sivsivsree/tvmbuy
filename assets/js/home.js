/**
* @author Siv.S
* @copyright Siv.S
* @time 12:22 am , 7/7/2013
**/


$(document).ready(function(){
	$("#searchInput").keyup(function(){
		var val = $(this).val().trim(), results = $("#results");
		if(val != ''){
          results.show();
		}else{
			 results.hide();
		}
	});

	$("#advGo").click(function(){
		window.location = 'search.php?q='+$("#searchInput").val().trim();
	});



  /*for navgation submene*/

	$("#horizontalmenu ul li").hover(function(){
	    if ($("> ul", this).length > 0) {
	    	$(this).addClass("addShine");
	        $("> ul", this).fadeIn(100);
	    }
	}, function(){
	    if ($("> ul", this).length > 0) {
	    	$(this).removeClass("addShine")
	        $("> ul", this).fadeOut(100);
	    }
	});

	$(".sub-menu li").click(function(){
		window.location = 'item.php?cat='+$(this).attr('val').trim()+'&main='+$(this).attr('main').trim();
	});

/* cart function*/

$('.remove').click(function(){
	var x= confirm("Are you sure want to delete this item?");
	 if(x == true){
	 	var pid = $(this).attr("pid"),row = '.'+pid+'_c',total;
	 	$this = this ;
	 	total = $(this).attr("tot");
	 		 		Gtot = parseInt( $('#grandtot').text() );
	 		 		var rem = Gtot - total;
	 				
	 	$.ajax({
	 		url:'includes/php/updatecart.php',
	 		type:'post',
	 		data:{pid:pid,method:'delete'},
	 		beforeSend:function(){

	 		},
	 		success: function(data){
	 			if(data == 1){
	 				$(row).hide();
	 				$('#grandtot').text(rem);
	 			}
	 		}
	 	});
	 }
});

/*updatecart*/

  var orginal;
  var error = $('.error');
$(".c").focusin(function(){
	orginal = $(this).val();
}).focusout(function(){
	var neew = $(this).val();
    var pid  = $(this).parent().parent('tr').attr('pid');
    var price  = $(this).parent().parent('tr').attr('price');
	if(neew != orginal){
		var intRegex = /^\d+$/;
		if(intRegex.test(neew) && neew != 0 ) {

		 var sum0; var cla = $('.'+pid+'_T');
         
             
		   $.ajax({
		   	 url:'includes/php/updatecart.php',
	 		 type:'post',
	 		 data:{pid:pid,qty:neew,method:'update'},
	 		 beforeSend:function(){
	 		 	sum0 = cla.text();
	 		 	
	 		 },
	 		 success:function(data){
	 		 	if(data != 0){
	 		 		var sum = price*neew;
	 		 		cla.text(sum);

					$('#grandtot').html(data).show();

	 		 		
	 		 	}else{
					error.addClass('alert-danger').text("something got wrong Try again").show().delay(3000).hide('slow');
				}
	 		 }
		   });
		}else{
			$(this).val(orginal);
			error.addClass('alert-danger').text("Please enter Valid Quantity").show().delay(3000).hide('slow');
		}
	}
});



$("#placeOrder").click(function(e){
  	var err = 0,print = new Array();
  	e.preventDefault();
     
    $(".Of").each(function() {
         var name = $(this).attr("name");

	   if($(this).val().trim() === ""){
	   	 err = 1;
	   	 print[0] = "Please Fill all Feilds";
	   }else{
		   if(name == 'Mobile'){
		   	  /*checking is mobile or not*/
		   	 var intRegex = /^\d+$/; var str = $(this).val();
		   	 if(!intRegex.test(str) || str.length != 10) {
				 err = 1;
			   	 print[1] = "Please Enter a valid Mobile No!";  
				   
			 }
		   }

		   if(name == 'email'){
		   	var email = $(this).val();
			   if(!validateEmail(email)){
			   	 err = 1;
			   	 print[2] = "Please Enter a valid Email Id";  
			   }	 
		   }

	   }

	   
	});


  
    if(err == 0){
    	$("#orderForm").submit();
    }else{
     $('.OrderAlert').text('').hide();
     for($i = 0 ; $i<print.length; $i++){
     	if(print[$i] != undefined)
     	$('.OrderAlert').append("<b>"+print[$i]+"</b><br>").show();
	 }
    	
    }
  

});



});





/*functions*/


function ShowTheProducts(data , err , output){
  
	if(data.success){ 
			
		 if(data.results.length > 0 ){
		 		
		 	$.each(data.results, function(){
		 		var html = "<li class='span text-center'>";
		 		html += "<div class='thumbnail'>";
		 		html += "<h5>"+ucFirst(this.name)+"</h5><div class='minH'>";
		 		html += "<img data-src='holder.js/300x200' src='"+this.image+"' style='width: 150px;'  alt='"+this.name+"'>";
		 		html += "</div><h5>Price:"+this.price+"</h5>";
		 		html += "<blockquote class='text-left'>"+this.about+"</blockquote>";
		 		html += "<p>";
		 		html += "<input id='"+this.pid+"_add' type='text' class='pull-left span1' value='1' placeholder='Quantity'>";
		 		html += "<button  class='aDCrt btn btn-warning span1' pid='"+this.pid+"' call='"+this.name+"'>Add</button>";
		 		html += "</p>";
		 		html += "</div></li>";

		 		output.append(html).fadeIn();
		 	});

		 }else{
		 	err.html("No Results Found!").show();
		 }

	}else{
		err.html(data.error).show();
	}
}

/*add to cart*/

function addToCart(pid,qty, res, name){

	$.ajax({
		url:'includes/php/ajax/item.php',
		type :'post',
		data :{pid:pid,qty:qty,process:4},
		beforeSend:function(){
			//$('#cartCount').text('');
			//$('#cartCost').text('shit');
		},
		success:function(data){
			if(data.success){
			$.each(data.results, function(){
					console.log(this.total);
				   $('#cartCount').html(this.item);
				   $('#cartCost').html(parseFloat(this.total));
				});
				
				res.hide().removeClass('alert-danger').addClass('alert-warning').html("<b>"+qty+" "+name+"</b> has been added to cart ").fadeIn().delay(1500).fadeOut("slow");
			}else{
				res.addClass('alert-danger').html('Something');
			}
		}
	});

}


function ucFirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}