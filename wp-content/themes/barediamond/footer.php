<?php
/**
 * The template for displaying the footer
 */
?>
<!--footer start-->
	<!--<footer class="footer-section">
		<div class="container">
		  <div class="row py-4 py-md-4">
			<div class="col-sm-3">
			  <div class="footer-logo">
				<a href="<?php //echo home_url();?>">
					<img src="<?php //echo get_template_directory_uri();?>/images/logo.png" class="img-fluid" title="logo" alt="logo" />
				</a>
			  </div>
			</div>
			<div class="col-sm-9">
			  <div class="footer-menu-list">
				<?php      	
				//   wp_nav_menu( array(
				// 	  'menu' => 'footer-menu',
				// 	  'depth' => 2,
				// 	  'container' => false,
				// 	  'menu_class' => 'mt-4 mt-md-2 mb-0 p-0 list-unstyled d-md-flex justify-content-between'
				// 	));
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
	</footer> -->
	<footer class="bgd_footer footer-section">
        <div class="container-fluid">
          <div class="row bgd_footer_lr-pad">
            <div class="col-sm-3">
              <div class="footer-logo">
			  	<a href="<?php echo home_url();?>">
                   <img src="<?php echo get_template_directory_uri();?>/images/bgd_footer_logo.png" class="img-fluid" title="bgd_footer_logo" alt="bgd_footer_logo" />
				</a>
              </div>
            </div>
            <div class="col-sm-9 offset-sm-0 col-md-9 offset-md-0 col-lg-8 offset-lg-1 col-xl-8 offset-xl-1">
              <div class="row">  
                <div class="col-sm-7">
                  <div class="explore-footer">
                    <label>Explore</label>
                    <!-- <ul>
                      <li><a href="<?php //bloginfo('url');?>/diamonds">Diamonds</a></li>
                      <li> <a href="<?php //bloginfo('url');?>/engagement-rings">Engagement Rings</a></li>
                      <li><a href="<?php //bloginfo('url');?>/wedding-rings">Wedding Rings</a></li>
                    </ul>
                    <ul>
                      <li><a href="<?php //bloginfo('url');?>/bracelets">Jewelry</a></li>
                      <li><a href="<?php //bloginfo('url');?>/our-story">Our Story</a></li>
                      <li><a href="<?php //bloginfo('url');?>/education">Education</a></li>
                    </ul> -->
                    <?php      	
                      wp_nav_menu( array(
                        'menu' => 'footer-menus',
                        'depth' => 2,
                        'container' => false,
                        'menu_class' => 'mb-0 p-0 list-unstyled'
                      ));
				            ?>
                  </div>
                </div>
                <div class="col-sm-5 d-none d-sm-block d-md-block">
                  <div class="stay-connected">
                    <label>Stay Connected</label>
                    <ul class="phone_email mb-0">
                      <li><img src="<?php echo get_template_directory_uri();?>/images/bgd_call.svg" alt="bgd_call" title="bgd_call" /><a href="tel:917-971-2216">917-971-2216</a></li>
                      <li><img src="<?php echo get_template_directory_uri();?>/images/bgd_envelope.svg" alt="bgd_envelope" title="bgd_envelope" /><a href="mailto:info@barediamond.com">info@barediamond.com</a></li>
                    </ul>
                    <ul class="footer_links mb-0">
                      <li><a target="_blank" href="https://www.facebook.com/BareDiamond/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_facebook.svg" alt="bgd_facebook" title="bgd_facebook" /></a></li>
                      <li><a target="_blank" href="https://twitter.com/thebarediamond"><img src="<?php echo get_template_directory_uri();?>/images/bgd_twitter.svg" alt="bgd_twitter" title="bgd_twitter" /></a></li>
                      <li><a target="_blank" href="https://www.instagram.com/thebarediamond/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_instagram.svg" alt="bgd_instagram" title="bgd_instagram" /></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid footer-border-bottom-top py-3">
          <div class="row">
            <div class="footer-bottom-txt text-center w-100">© Bare Diamond <?php echo date('Y');?></div>
          </div>
        </div>
      </footer> 
</main>

<!-- <script src="js/jquery.min.js"></script> -->

<script src="<?php echo get_template_directory_uri();?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/bootstrap.min.js"></script>
<!-- <script src="<?php echo get_template_directory_uri();?>/js/jquery-ui.js"></script> -->
<!-- <script src="<?php echo get_template_directory_uri();?>/js/owl.carousel.js"></script> -->
<script src="<?php echo get_template_directory_uri();?>/js/header-menu.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/global.js"></script>

<?php if(is_page( array('diamonds'))) { ?>
  <script src="<?php echo get_template_directory_uri();?>/js/jquery-ui.js"></script>
  <script src="<?php echo get_template_directory_uri();?>/js/custom_range_slider.js"></script>
  <script src="<?php echo get_template_directory_uri();?>/js/dataTables.min.js"></script>
<?php } ?>
<?php if(is_page( array('home'))) { ?>
  <script src="<?php echo get_template_directory_uri();?>/js/slick.min.js"></script>
  <script src="<?php echo get_template_directory_uri();?>/js/custom_home_page.js"></script>
<?php } ?>
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
<?php if(is_product()) { ?>
  <script src="<?php echo get_template_directory_uri();?>/js/slick.min.js"></script>
  <script src="<?php echo get_template_directory_uri();?>/js/custom.js"></script>
<?php } ?>


<?php wp_footer(); ?>