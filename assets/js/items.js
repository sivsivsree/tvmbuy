$(document).ready(function(){
  
   if( type == 1 ){
   	  // alert('only '+ item);
        $.ajax({
            url   : "includes/php/ajax/item.php",
            type  : 'get',
            data  :{main:item ,  process:1},
            beforeSend: function(){
               $(".loadItems").addClass("loading");
            },
            success:function(data){

               $(".loadItems").removeClass("loading");
                var err = $('#IDanger'); var output = $('.loadItems');
                ShowTheProducts(data , err , output);

                $('.aDCrt').click(function(){
                  /*add to cart event*/
                  var pid = $(this).attr('pid'), name = $(this).attr('call');
                  addToCart(pid , parseInt($('#'+pid+'_add').val()) , err , name );
                });

            },
         });

   }else if(type == 2){
   		//alert(item[0] +' -> '+ item[1]);

   		$.ajax({
   			url   : "includes/php/ajax/item.php",
   			type  : 'get',
   			data  :{main:item[0] , sub:item[1], process:2},
   			beforeSend: function(){
   				$(".loadItems").addClass("loading");
   			},
   			success:function(data){

   				$(".loadItems").removeClass("loading");
   				 var err = $('#IDanger'); var output = $('.loadItems');
   				 ShowTheProducts(data , err , output);

   				 $('.aDCrt').click(function(){
   				 	/*add to cart event*/
   				 	var pid = $(this).attr('pid'), name = $(this).attr('call');
   				 	addToCart(pid , parseInt($('#'+pid+'_add').val()) , err , name );
   				 });

   			},
   		});

   }else if(type == 3){

   	 $.ajax({
            url   : "includes/php/ajax/item.php",
            type  : 'get',
            data  :{process:3},
            beforeSend: function(){
               $(".loadItems").addClass("loading");
               
            },
            success:function(data){
              
               $(".loadItems").removeClass("loading");
                var err = $('#IDanger'); var output = $('.loadItems');
                ShowTheProducts(data , err , output);

                $('.aDCrt').click(function(){
                  /*add to cart event*/
                  var pid = $(this).attr('pid'), name = $(this).attr('call');
                  addToCart(pid , parseInt($('#'+pid+'_add').val()) , err , name );
                });

            },
         });
   }

 });