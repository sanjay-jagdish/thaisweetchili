jQuery(function($){
	$('.qty').blur(function(){
		var id = $(this).attr('data-id');
		var menu_id = $(this).attr('data-rel');
		var val = $(this).val();
		updateQuantity(val,id,menu_id, 0, 0, 0);
		
	}).keypress(function(e){
		var id = $(this).attr('data-id');
		var menu_id = $(this).attr('data-rel');
		var val = $(this).val();
		if(e.which == 13){
			updateQuantity(val,id,menu_id, 0, 0, 0);
		}
	});
	
	// This button will increment the value
	$(document).on("click",'.qtyplus',function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
       
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
            var id = $(this).attr('data-id');
			var menu_id = $(this).attr('data-rel');
			var tillval_count = $(this).attr('data-tillvals');
			var menu_det = $('.btn_optional_dish-'+id).attr('data-rel');
			var price = $('.btn_optional_dish-'+id).attr('data-price');
			var val = currentVal+1;
			$('.order-option').html('');
			
			updateQuantity(val,id,menu_id, tillval_count, menu_det, price);
			$("#pluscheck").val(1);
    });
		
	$(document).on("click",'.qtyminus',function(e){
	    e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        			
        // If is not undefined
        if (!isNaN(currentVal)) {

            // Increment
            $('input[name='+fieldName+']').val(currentVal-1);
           
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
              var val = 0;
        }
       	var id = $(this).attr('data-id');
		var menu_id = $(this).attr('data-rel');
		
		var tillval_count = $(this).attr('data-tillvals');
		var menu_det = $('.btn_optional_dish-'+id).attr('data-rel');
		var price = $('.btn_optional_dish-'+id).attr('data-price');
		
		 var val = currentVal-1;
		
	
		updateQuantity(val,id,menu_id, tillval_count, menu_det, price);
		if(val >= 1){
		   $('.order-option').html('');
	       getMenuOption(id);
	   	}
	});
		
	$('.btn_check_out').click(function(){
		
		$.fn.center = function ()
		{
			this.css("position","fixed");
			// this.css("top", ((jQuery(window).height() / 2) - (this.outerHeight() / 2))+50);
			this.css("top", "80px");
			//this.css("left", ($(window).width() / 2) - (this.outerWidth() / 2));
			return this;
		}
		
		
		var total = $(this).attr('data-rel');
		
		$('.fader').fadeIn();
		$('.step-2-wrapper').addClass('steploader').html('<center><img src="'+siteurl+'/images/loader.gif'+'"></center>');
		$('.step-2-wrapper').center();
		
		$.ajax({
			url: siteurl+"/steps.php",
			type: 'POST',
			async: false,
			data: 'total='+encodeURIComponent(total)+'&tablename='+encodeURIComponent('takeaway_settings')+'&siteurl='+encodeURIComponent(siteurl),
			success: function(value){	
			
				$('.step-2-wrapper').removeClass('steploader').addClass('removecenter').html(value);
				$('.steps-container').center();
				$('.takeemail').val($.cookie('limone_email'));
				$('.takepass').val($.cookie('limone_pass'));
				
			}
		 });
   });
});

function getMenuOption(sid)
{
	var siteurl = $('#main-table').attr('data-rel');
	var chkid = $("#chkuniqeid").val();
	var id = $('.btn_optional_dish-'+sid).attr('data-id');
	var price = $('.btn_optional_dish-'+sid).attr('data-price');
	$.ajax({
		url: siteurl+"/ajax/special-request.php",
		type: 'POST',
		data: 'id='+encodeURIComponent(id)+'&chkuniqeid='+encodeURIComponent(chkid)+'&siteurl='+encodeURIComponent(siteurl)+'&price='+encodeURIComponent(price),
		success: function(value){
			$('.order-option').html(value);
			$('.order-option').show();
			$('.btn_optional_dish-'+sid).addClass('active');
		}
	});
}

function updateQuantity(val,id,menu_id, tillval_count, menu_det, price)
{
	var siteurl = $('#main-table').attr('data-rel');
	var chkid = $("#chkuniqeid").val();
	$.ajax({
		url: siteurl+"/ajax/update-cart.php",
		type: 'POST',
		data: 'id='+encodeURIComponent(id)+'&val='+encodeURIComponent(val)+'&menu_id='+encodeURIComponent(menu_id)+'&uniq='+encodeURIComponent(chkid)+'&check=check-plus',
		success: function(value){
			var obj = $.parseJSON(value);
			if(obj.subtotal == "0kr"){
			$("#item-"+id).slideUp();
			}
			$("#subtotal-"+id).html(obj.subtotal);
			$(".total-amt").html(obj.total);
			
			if(obj.count == 0){
			 window.location="../";
			}
		}
	});
}