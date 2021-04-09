$("#subscribeBtn").click(function () {
	$("#mailchimp_msg").html(" ");
	$("#mailchimp_msg").hide();
  var email = $('#newsletterEmail').val();
  if(email!=''){
	  $("#mailchimp_loader").show();
  }else{
	  $("#mailchimp_msg").html("Please provide valid email!");
	  $("#mailchimp_msg").show();
	  return false;
  }
  var list_group = $('#list_group').val();
  $.ajax({
	type: "POST",
	dataType: "html",
	url: ajaxurl,
	data: {
		email: email,
		list_group: list_group,
		action:'mailchimp_api'
	},
	success: function (data) {
		$("#mailchimp_loader").hide();
		if(data=='-1'){
			$("#mailchimp_msg").html("Please provide valid email!");
		}else if(data=="-2"){
			$("#mailchimp_msg").html("There is something error, not subscribed!");
		}else{
			$("#mailchimp_msg").html(data);
		}
		$("#mailchimp_msg").show();
	},
	error: function (jqXHR, textStatus, errorThrown) {
		console.log(errorThrown);
	}

	});
  return false;
});

$("#subscribePopupBtn").click(function () {
	var loader = $("#mailchimp_loader").html();
	$("#mailchimp_popup_loader").html(loader);
	$("#mailchimp_popup_msg").html(" ");
	$("#mailchimp_popup_msg").hide();
  var email = $('#newsletterPopupEmail').val();
  if(email!=''){
	  $("#mailchimp_popup_loader").show();
  }else{
	  $("#mailchimp_popup_msg").html("Please provide valid email!");
	  $("#mailchimp_popup_msg").show();
	  return false;
  }
  var list_group = $('#list_group_popup').val();
  $.ajax({
	type: "POST",
	dataType: "html",
	url: ajaxurl,
	data: {
		email: email,
		list_group: list_group,
		action:'mailchimp_api'
	},
	success: function (data) {
		$("#mailchimp_popup_loader").hide();
		if(data=='-1'){
			$("#mailchimp_popup_msg").html("Please provide valid email!");
		}else if(data=="-2"){
			$("#mailchimp_popup_msg").html("There is something error, not subscribed!");
		}else{
			$("#mailchimp_popup_msg").html(data);
		}
		$("#mailchimp_popup_msg").show();
	},
	error: function (jqXHR, textStatus, errorThrown) {
		console.log(errorThrown);
	}

	});
  return false;
});

function filterEngagementProducts(t, e) {
    var a = [],
        c = [];

    var cat_slug = $("#current_cat_slug").val();
    var prt_slug = $("#current_parent_slug").val();
         
    $("input.filter_ewr_cat[type=checkbox]").each(function() {
        this.checked && a.push($(this).val())
    }), $("input.filter_ewr_metal[type=radio]").each(function() {
        this.checked && c.push($(this).val())
    }), $("#overlay").show(), $.ajax({
        type: "POST",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
            value: a,
            min_price: t,
            max_price: e,
            metal_slug: c,
            cat_slug: cat_slug,
            prt_slug: prt_slug,
            action: "filter_product",
            dataType: "json"
        },
        success: function(t) {
            $(".engagement-data").html(t.html), $(".total_pro").html(t.total_products), $("#overlay").hide()
        }
    })
}

 $("#drop_down_order  .dropdown-item").click(function() {  

    var dropItemVal = $(this).attr('value');
   
    $('#dropdownSelectt').html(dropItemVal); 
   
    var t = $(this).attr('for');
    var e = [],
        a = [];

    var cat_slug = $("#current_cat_slug").val();
    var prt_slug = $("#current_parent_slug").val();

  

    var range_min = jQuery( ".noUi-handle-lower" ).attr('aria-valuetext').replace("$", "");
    var range_max = jQuery( ".noUi-handle-upper" ).attr('aria-valuetext').replace("$", "");   

    $("input.filter_ewr_cat[type=checkbox]").each(function() {
        this.checked && e.push($(this).val())
    }), $("input.filter_ewr_metal[type=radio]").each(function() {
        this.checked && a.push($(this).val())
    }), $.ajax({
        type: "POST",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
            value: e,
            metal_slug: a,
            sortby: t,
            cat_slug: cat_slug,
            prt_slug: prt_slug,
            min_price: range_min,
            max_price: range_max,
            action: "filter_product",
            dataType: "json"
        },
        beforeSend: function() {
            $("#overlay").show()
        },
        success: function(t) {
            $(".engagement-data").html(t.html), $(".total_pro").html(t.total_products), $("#overlay").hide()
        }
    })
}), $(document).ready(function() {
    var t = $(".ep_font_icon_document");

    var cat_slug = $("#current_cat_slug").val();
    var prt_slug = $("#current_parent_slug").val();

    t.hasClass("ep_font_icon_document") && t.removeClass("ep_font_icon_document").addClass("epkbfa epkbfa-chevron-circle-right")
}), $(".reset-filter").click(function() {


   location.reload(); 

}), $(".filter_ewr_cat, .filter_ewr_metal").click(function() {
	
    var t = [],
        e = [];

    var metal = $("input.filter_ewr_metal[type=radio]:checked").val();
    e.push(metal);
    var cat_slug = $("#current_cat_slug").val();
    var prt_slug = $("#current_parent_slug").val();



    var range_min = jQuery( ".noUi-handle-lower" ).attr('aria-valuetext').replace("$", "");
    var range_max = jQuery( ".noUi-handle-upper" ).attr('aria-valuetext').replace("$", ""); 

    var sortby = $("#dropdownSelectt").attr('value');


    
   $("input.filter_ewr_metal[type=radio]").each(function() {
         $(this).removeClass("active");
    });

    $("input.filter_ewr_metal[value="+metal+"]").addClass("active");    
    
    $("input.filter_ewr_cat[type=checkbox]").each(function() {
        this.checked && t.push($(this).val()) && $(this).addClass("active");
    }), $.ajax({
        type: "POST",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
            value: t,
            metal_slug: e,
            cat_slug: cat_slug,
            prt_slug: prt_slug,
            min_price: range_min,
            max_price: range_max,
            sortby: sortby,
            action: "filter_product",
            dataType: "json"
        },
        beforeSend: function() {
            $("#overlay").show()
        },
        success: function(t) {
            $(".wedding-data").html(t.html), $(".total_pro").html(t.total_products), $("#overlay").hide()
        }
    })
}),  $("#img_by_shape").change(function() {     

    var product_id = $("#product_id").val();
    var shape = $("#img_by_shape").val();
    var metal = $("#pa_eo_metal_attr").val(); 
    var parent_cat = $(".wedding_option_check").val(); 
    var all_compatibale_shape = $("#all_compatibale_shape").val(); 

    $.ajax({
        type: "POST",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
            product_id: product_id,
            shape: shape,
            all_compatibale_shape: all_compatibale_shape,
            metal: metal,
            parent_cat: parent_cat,
            action: "get_product_img",
            dataType: "json"
        },
        beforeSend: function() {
            $("#overlay").show()
        },
        success: function(t) {
            $(".custom_slider").html(t.html), $(".nu-product-price").html(t.metal_price), $(".product_variation_id").val(t.variation_id), $("#overlay").hide()

        }
    })
    
}), $(".custom-select-option-dropdown li a").click(function() {  

    var product_url = $('#product_url').val();   
    var metal_color = $(this).attr('metal_color');   
   
    if(metal_color=='14k-rose-gold')       
    {
       var metal_url = product_url.replace("14k-rose-gold", $(this).attr('metal_color'));
       window.location.href = product_url+'/'+metal_color;
       return false;

    }
    if(metal_color=='14k-white-gold')
    {

        var metal_url = product_url.replace("14k-white-gold", $(this).attr('metal_color'));
        window.location.href = product_url+'/'+metal_color;
        return false;

    }
    if(metal_color=='14k-yellow-gold') 
    {

        var metal_url = product_url.replace("14k-yellow-gold", $(this).attr('metal_color'));
       window.location.href = product_url+'/'+metal_color;
        return false;

    }
    if(metal_color=='platinum')
    { 

        var metal_url = product_url.replace("platinum", $(this).attr('metal_color'));  
        window.location.href = product_url+'/'+metal_color;
        return false;
    }

   
    window.location.href = product_url+'/'+ $(this).val();
    
}), $('body').on('click', '.apr_product_diamond, .dsr_product_ring', function () {

    var product_id = $(this).val();    
    var cart_item_key = $(this).attr('cart_item_key');
    
    if($(this).prop("checked") == true)
    {
        
     $.ajax({
            type: "POST",
            dataType: "json",
            url: my_ajax_object.ajax_url,
            data: {
                product_id: product_id,                
                cart_item_key: cart_item_key,        
                action: "add_apr_dsr_prod",
                dataType: "json"
            },
            beforeSend: function() {               
                $("#overlay").show()              
            },
            success: function(t) {
               
                if(t.result=='true')
                {

                 $("[name='update_cart']").removeAttr('disabled');
                 $("[name='update_cart']").trigger("click"); 
                  $( 'body' ).trigger( 'update_checkout' );
                 $("#overlay").hide();

                }

            }
        });
   }
   else
   {

    var product_id = $(this).val();    
    var cart_item_key = $(this).attr('cart_item_key');

    $.ajax({
            type: "POST",
            dataType: "json",
            url: my_ajax_object.ajax_url,
            data: {
                 product_id: product_id,    
                cart_item_key: cart_item_key,            
                action: "remove_item_from_cart",
                dataType: "json"
            },
            beforeSend: function() {               
                $("#overlay").show()
            },
            success: function(t) {
                
                if(t.result=='true')
                {

                 $("[name='update_cart']").removeAttr('disabled');
                 $("[name='update_cart']").trigger("click"); 
                  $( 'body' ).trigger( 'update_checkout' );
                 $("#overlay").hide();
                 
                }

            }
        });

   }
    
});

$('body').on('click', '#availaible-coupon-list .coupon-outer', function () {

    var coupon_code = $(this).attr('id');
   
    $('#'+coupon_code).addClass('allreadyused');

     $.ajax({
            type: "POST",
            dataType: "json",
            url: my_ajax_object.ajax_url,
            data: {
                              
                coupon_code: coupon_code,        
                action: "apply_coupon_code",
                dataType: "json"
            },
            beforeSend: function() {  
                         
                $("#overlay").show() ;
                         
            },
            success: function(t) {                
               
                 $("[name='update_cart']").removeAttr('disabled');
                 $("[name='update_cart']").trigger("click"); 
                 $( 'body' ).trigger( 'update_checkout' );
                 $("#overlay").hide();

            }
        });
});