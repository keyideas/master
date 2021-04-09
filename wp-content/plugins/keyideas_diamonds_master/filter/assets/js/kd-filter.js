jQuery(document).ready(function() {
	jQuery(".accordion_head_shape").click(function() {
		if (jQuery(".accordion_body_shape").is(':visible')) {
		  jQuery(".accordion_body_shape").slideUp(300);
		  jQuery(".plusminus_shape").text('+');
		} else {
		  jQuery(".accordion_body_shape").slideDown(300);
		  jQuery(".plusminus_shape").text('-');
		}
	});
	
	 jQuery(".accordion_head_color").click(function() {
		if (jQuery(".accordion_body_color").is(':visible')) {
		  jQuery(".accordion_body_color").slideUp(300);
		  jQuery(".plusminus_color").text('+');
		} else {
		  jQuery(".accordion_body_color").slideDown(300);
		  jQuery(".plusminus_color").text('-');
		}
	});
	
	 jQuery(".accordion_head_cut").click(function() {
		if (jQuery(".accordion_body_cut").is(':visible')) {
		  jQuery(".accordion_body_cut").slideUp(300);
		  jQuery(".plusminus_cut").text('+');
		} else {
		  jQuery(".accordion_body_cut").slideDown(300);
		  jQuery(".plusminus_cut").text('-');
		}
	});
	
	 jQuery(".accordion_head_clarity").click(function() {
		if (jQuery(".accordion_body_clarity").is(':visible')) {
		  jQuery(".accordion_body_clarity").slideUp(300);
		  jQuery(".plusminus_clarity").text('+');
		} else {
		  jQuery(".accordion_body_clarity").slideDown(300);
		  jQuery(".plusminus_clarity").text('-');
		}
	});
	 jQuery(".accordion_head_carat").click(function() {
		if (jQuery(".accordion_body_carat").is(':visible')) {
		  jQuery(".accordion_body_carat").slideUp(300);
		  jQuery(".plusminus_carat").text('+');
		} else {
		  jQuery(".accordion_body_carat").slideDown(300);
		  jQuery(".plusminus_carat").text('-');
		}
	});
	 jQuery(".accordion_head_price").click(function() {
		if (jQuery(".accordion_body_price").is(':visible')) {
		  jQuery(".accordion_body_price").slideUp(300);
		  jQuery(".plusminus_price").text('+');
		} else {
		  jQuery(".accordion_body_price").slideDown(300);
		  jQuery(".plusminus_price").text('-');
		}
	});
	
	 jQuery(".accordion_head_advance").click(function() {
		if (jQuery(".accordion_body_advance").is(':visible')) {
		  jQuery(".accordion_body_advance").slideUp(300);
		  jQuery(".plusminus_advance").text('+');
		} else {
		  jQuery(".accordion_body_advance").slideDown(300);
		  jQuery(".plusminus_advance").text('-');
		}
	});
});