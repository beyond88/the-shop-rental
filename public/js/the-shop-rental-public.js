(function( $ ) {
	'use strict';

	$(document).on("click", ".btn-add-quote", function(){
		var btn = $(this);
				
		var data = {
			itemId: $(this).attr('data-id'),
			itemName: $(this).attr('data-name'),
			category: $(this).attr('data-category'),
			action: 'addItemToQuote'			
		};
			
		$.ajax({
			url: ajax.ajax_url,
			type:"POST",
			dataType:"JSON",
			data: data,
			 success: function(data){
				console.log("send item ===>", data);
				console.log("item id===>", data.data.rowId);
				console.log("item count===>", data.data.count);
				
				$('.view-quotes').removeClass('hide');
				$(btn).closest('.add-quote').find(".remove-quote").attr("data-id", data.data.rowId);
				$('.quote-count span').text(data.data.count);
				$(btn).closest('.add-quote').find('.remove-quote-cnt').removeClass('hide');
				// $(btn).closest('.ri-wrapper').find('.remove-quote-cnt').addClass('hide'); 
			 },
			 error: function(err, status, xhr){
				console.log(err);
				console.log(status);
				console.log(xhr);
			 }
		});
		
	});
	
	$(document).on("click", ".remove-quote", function(){
		var btn = $(this);
		var data = {
			itemId: $(this).attr('data-id'),
			action: 'removeItemFromQuote'
		};
		
		$.ajax({
			url: ajax.ajax_url,
			type:"POST",
			dataType:"JSON",
			data: data,
			 success: function(data) {
				console.log(data);
				 
				if(data.data == 0) {
					$('.view-quotes').addClass('hide');
				} else {
					$('.view-quotes').removeClass('hide');
				}

				if(data.success == true){
					$('.quote-count span').text(data.data);
				}
				
				$(btn).closest('.add-quote').find('.remove-quote-cnt').addClass('hide'); 
			 },
			 error: function(err, status, xhr){
				console.log(err);
				console.log(status);
				console.log(xhr);
			 }
		});
		return false;
	});


	$(document).on("submit", "#quote_form", function(e)
	{ 
	   var valid = $("#quote_form").parsley().validate();
	   if(!valid) {
		   return false;
	   }
	   
		var products = '';
		var crew = '';
		var city_val = $("#city").val();
		if(city_val == 'Others'){
			city_val = $("#country option:selected").text();
		}
		
		$("#quote_items li:not(li.header)").each(function() {
			var product = $(this);
			var prd = $(product).find('.item').val()+"_|_"+$(product).find('.item').attr('data-itemid')+",";
			products += prd;
		});
		
		$("#quote_crew li:not(li.header)").each(function() {
			var cr = $(this);
			var prd = $(cr).find('.item').val()+"_|_"+$(cr).find('.item').attr('data-itemid')+",";
			crew += prd;
		});		
   
		var data = {
			name : $("#fullname").val(),
			email : $("#email").val(),
			phone : $("#phone").val(),
			companyname : $("#cmpname").val(),
			city : city_val,
			rentaldate: $("#rentaldate").val(),
			noofdays:$("#ndays").val(),
			notes: $("#notes").val(),
			quoteproducts: products,
			// quotecrew: crew,
			action: 'submitQuote'
		};

		$("#quote_form input, #quote_form textarea, #quote_form .btn").attr('disabled', 'disabled');
			$.ajax({
			url: ajax.ajax_url,
			type:"POST",
			data: data,			
			success: function(result){
				console.log(result);				
				window.location.href = result.data.url;
			},
			error:function(err, status, xhr){
				$("#quote_form input, #quote_form textarea, #quote_form .btn").removeAttr('disabled');
				$("#quote_form #error_mail").text(__ErrorMessage);
				error_msgs_toggle();
				console.log(err);
				console.log(status);
				console.log(xhr);
			}
			});
			return false;
	});	

})( jQuery );


function removeCartItem(id){
	///var btn = jQuery(this);
	var data = {
		itemId: id,
		action: 'removeItemFromQuote'			
	};
	
	jQuery.ajax({
		url: ajax.ajax_url,
		type:"POST",
		dataType:"JSON",
		data: data,
		 success: function(data){
			 console.log(data);				
			 jQuery('.list-group-item'+id+'').remove();
		 },
		 error: function(err, status, xhr){
			console.log(err);
			console.log(status);
			console.log(xhr);

		 }
	});
	return false;
}




  


$(document).ready(function() {	
  	$('.tabs a').click(function(){
		$('.panel').hide();
		$('.tabs a.active').removeClass('active');
		$(this).addClass('active');

		// var options = $('#catselector option');		
		// var values = $.map(options ,function(option) {
		// 	if( option.value != '' ){
		// 		$('#' + option.value).show();
		// 	} 				
		// });		

		var panel = $(this).attr('href');
		$(panel).fadeIn(1000);

		return false;  // prevents link action
  	});  // end click 

    $('.tabs li:first a').click(); 


    // Dropdown List
    $('#catselector').change(function(){
			
	    $('.cat-list').hide();
		if( $(this).val() == '' ){	
			var options = $('#catselector option');		
			var values = $.map(options ,function(option) {
				if( option.value != '' ){
					$('#' + option.value).show();
				} 				
			});
		} else {
			$('#' + $(this).val()).show();
		}

	});

}); // end ready
















