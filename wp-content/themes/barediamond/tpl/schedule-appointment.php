<?php
/**
 Template Name: Schedule appointment
*/

get_header();
?>  

<div class="bgd_contact_page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="bgd_contact_top_heading text-center mt-5">
					<h1 class="mb-0">Schedule An Appointment</h1>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="bgd_contact_details">
					<img src="<?php echo get_template_directory_uri();?>/images/bgd_schedule_appointment_img.jpg" class="img-fluid w-100 d-none d-sm-none d-md-block" />
					<img src="<?php echo get_template_directory_uri();?>/images/bgd_schedule_appointment_mobile_img.jpg" class="img-fluid w-100 d-block d-sm-block d-md-none" />
					<div class="bgd_contact_bottom w-100 d-md-flex justify-content-between align-items-end mt-4">
						<div class="bgd_stay_connected">
							<p><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:646-415-8007">(646)-415-8007</a></p>
							<p class="mb-0"><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:info@barediamond.com">info@barediamond.com</a></p>
						</div>
						<ul class="footer_links mb-0 p-0 list-unstyled">
							<li><a href="https://www.facebook.com/BareDiamond/" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/bgd_facebook_black.svg" /></a></li>
							<li><a href="https://twitter.com/thebarediamond"  target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/bgd_twitter_black.svg" /></a></li>
							<li><a href="https://www.instagram.com/thebarediamond/" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/bgd_instagram_black.svg" /></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="bgd_contact_form">
					<?php echo do_shortcode('[contact-form-7 id="84" title="Schedule Appointment"]');?>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
jQuery(document).ready(function(){
	var select_option = jQuery("#contact_method").html();
	jQuery(".app_type").click(function(){
		var contact_type = $(this).val();
		jQuery("input[name='appointment']").val($(this).val());
	  //alert("contact_type="+contact_type);
	  if(contact_type=='BOOK IN-STORE APPOINTMENT'){
		jQuery("#contact_method").html('<option value="In-Store">In-Store (Charlotte Gallery)</option>')
	  }else{
		  jQuery("#contact_method").html(select_option);
	  }
	});
});
</script>
<?php get_footer();?>