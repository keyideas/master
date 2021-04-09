<?php
/**
 Template Name: Schedule appointment
*/

get_header();
?>

<div class="customize-ur-ring-wrapper">
<div class="top-heading">
	<h1>SCHEDULE AN APPOINTMENT</h1>
</div>
<div class="customize-ring-form schedule-appointment-form py-7">
	<div class="container">
		<?php echo do_shortcode('[contact-form-7 id="84" title="Schedule Appointment"]');?>
	</div>
</div>
<div class="customize-ring-full-img">
	<img src="<?php echo get_template_directory_uri();?>/images/SCHEDULE-AN-APPOINTMENT-Mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" alt="SCHEDULE-AN-APPOINTMENT-Mobile" title="SCHEDULE-AN-APPOINTMENT-Mobile" />
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
		jQuery("#contact_method").html('<option value="In-Store">In-Store</option>')
	  }else{
		  jQuery("#contact_method").html(select_option);
	  }
	});
});
</script>
<?php get_footer();?>