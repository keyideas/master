<?php
/**
 Template Name: Customize Ring
*/

get_header();
?>

<div class="customize-ur-ring-wrapper">
	<div class="top-heading">
		<h1>CUSTOMIZE YOUR RING</h1>
	</div>
	<div class="customize-ring-form">
		<div class="container">
		       <?php echo do_shortcode('[contact-form-7 id="90" title="Customize Your Ring"]');?>
		</div>
	</div>
	<div class="customize-ring-full-img">
                <img src="<?php echo get_template_directory_uri();?>/images/CUSTOMIZE-YOUR-RING.jpg" class="img-fluid d-none d-sm-none d-md-block w-100" alt="CUSTOMIZE-YOUR-RING" title="CUSTOMIZE-YOUR-RING" />
				<img src="<?php echo get_template_directory_uri();?>/images/CUSTOMIZE-YOUR-RING-mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" alt="CUSTOMIZE-YOUR-RING-mobile" title="CUSTOMIZE-YOUR-RING-mobile" />
</div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery(".wpcf7-submit").click(function(){
			var img = jQuery('.wpcf7-file').val();
			if(img!=''){
				jQuery("input[name='image-file']").val("File Attached");
			}else{
				jQuery("input[name='image-file']").val("File Not Attached");
			}
		});
});
</script>
<?php get_footer();?>