<?php
/**
 Template Name: Customize Ring
*/

get_header();
?>

<div class="bgd_contact_page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="bgd_contact_top_heading text-center mt-5">
					<h1 class="mb-0">Customize Your Ring</h1>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="bgd_contact_details">
					<img src="<?php echo get_template_directory_uri();?>/images/bgd_customize_ring_img.jpg" alt="bgd_customize_ring" title="bgd_customize_ring" class="img-fluid w-100 d-none d-sm-none d-md-block" />
					<img src="<?php echo get_template_directory_uri();?>/images/bgd_customize_ring_mobile_img.jpg" alt="bgd_customize_ring_mobile" title="bgd_customize_ring_mobile" class="img-fluid w-100 d-block d-sm-block d-md-none" />
					<div class="bgd_contact_bottom w-100 d-md-flex justify-content-between align-items-end mt-4">
						<div class="bgd_stay_connected">
							<p><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:646-415-8007">(646)-415-8007</a></p>
							<p class="mb-0"><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:info@barediamond.com">info@barediamond.com</a></p>
						</div>
						<ul class="footer_links mb-0 p-0 list-unstyled">
							<li><a href="https://www.facebook.com/BareDiamond/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_facebook_black.svg" alt="bgd_facebook_black" title="bgd_facebook_black" /></a></li>
							<li><a href="https://twitter.com/thebarediamond"><img src="<?php echo get_template_directory_uri();?>/images/bgd_twitter_black.svg" alt="bgd_twitter_black" title="bgd_twitter_black" /></a></li>
							<li><a href="https://www.instagram.com/thebarediamond/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_instagram_black.svg" alt="bgd_instagram_black" title="bgd_instagram_black" /></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="bgd_contact_form">
					<?php echo do_shortcode('[contact-form-7 id="90" title="Customize Your Ring"]');?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="customize-ur-ring-wrapper">
	<div class="top-heading">
		<h1>Customize Your Ring</h1>
	</div>
	<div class="customize-ring-form">
		<div class="container">
		       <?php //echo do_shortcode('[contact-form-7 id="90" title="Customize Your Ring"]');?>
		</div>
	</div>
	<div class="customize-ring-full-img">
		<img src="<?php //echo get_template_directory_uri();?>/images/CUSTOMIZE-YOUR-RING.jpg" class="img-fluid d-none d-sm-none d-md-block w-100" alt="CUSTOMIZE-YOUR-RING" title="CUSTOMIZE-YOUR-RING" />
		<img src="<?php //echo get_template_directory_uri();?>/images/CUSTOMIZE-YOUR-RING-mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" alt="CUSTOMIZE-YOUR-RING-mobile" title="CUSTOMIZE-YOUR-RING-mobile" />
	</div>
</div> -->
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