<?php
/**
 * The template for displaying the footer
 */
?>
<!--footer start-->
	<footer class="footer-section">
		<div class="container">
		  <div class="row py-4 py-md-4">
			<div class="col-sm-3">
			  <div class="footer-logo">
				<a href="<?php echo home_url();?>">
					<img src="<?php echo get_template_directory_uri();?>/images/logo.png" class="img-fluid" title="logo" alt="logo" />
				</a>
			  </div>
			</div>
			<div class="col-sm-9">
			  <div class="footer-menu-list">
				<!--<ul class="mt-4 mt-md-0 mb-0 p-0 list-unstyled d-md-flex">
				  <li><a href="">OUR STORY</a></li>
				  <li><a href="">DIAMONDS</a></li>
				  <li><a href="">JEWELRY</a></li>
				  <li><a href="">EDUCATION</a></li>
				  <li><a href="">CONTACT US</a></li>
				</ul>-->
				<?php      	
				  wp_nav_menu( array(
					  'menu' => 'footer-menu',
					  'depth' => 2,
					  'container' => false,
					  'menu_class' => 'mt-4 mt-md-2 mb-0 p-0 list-unstyled d-md-flex justify-content-between'
					));
				?>
			  </div>
			</div>
		  </div>
		</div>
		<div class="container-fluid footer-border-bottom-top py-2">
		  <div class="row">
			<div class="footer-bottom-txt text-center w-100">© Bare Diamonds <?php echo date("Y"); ?></div>
		  </div>
		</div>
	</footer>
</main>

<!-- <script src="js/jquery.min.js"></script> -->

<script src="<?php echo get_template_directory_uri();?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery-ui.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/owl.carousel.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/slick.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/custom.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/dataTables.min.js"></script>
<?php if(is_page( array('our-story','education'))){?>	
	<script src="https://dimsemenov.com/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
	<script>
		  $(document).ready(function() {
			$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
			  disableOn: 700,
			  type: 'iframe',
			  mainClass: 'mfp-fade',
			  removalDelay: 160,
			  preloader: false,
			  fixedContentPos: false
			});
		  });
		</script> 
<?php } ?>


<?php wp_footer(); ?>

