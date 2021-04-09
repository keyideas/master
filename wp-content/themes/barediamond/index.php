<?php

/**

 * The index page template file

*/



get_header();



?>

<!--Home page body content start-->

<section class="banner-section">

	<div class="banner-inner position-relative">

	  <img src="<?php echo get_template_directory_uri();?>/images/home-banner.png" class="img-fluid img-fluid w-100 d-none d-sm-none d-md-block" alt="home-banner" title="home-banner" />
	  <img src="<?php echo get_template_directory_uri();?>/images/home-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" alt="home-banner" title="home-banner" />

	  <div class="banner-caption d-flex flex-column justify-content-center">

		<h1>CONSCIOUSLY CRAFTED</h1>

		<h2>ELEGANT. EXQUISITE. ETHICAL.</h2>

		<button class="btn banner-btn mt-4 mt-md-5">LEARN MORE</button>

	  </div>

	</div>

</section>



<section class="strip-section text-center d-none d-sm-none d-md-block">

	<h2>MODERN TECHNOLOGY MARRIES TIMELESS SIGNIFICANCE</h2>

</section>



<section class="created-specially-section">

	<div class="container-fluid">

	  <div class="row">

		<div class="col-sm-6">

		  <div class="row">

			<div class="create-banner-left p-0 w-100">

			  <img src="<?php echo get_template_directory_uri();?>/images/create-banner.png" class="img-fluid w-100 d-none d-sm-none d-md-block" alt="create-banner" title="create-banner">
			  <img src="<?php echo get_template_directory_uri();?>/images/create-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" alt="create-banner" title="create-banner">

			</div>

		  </div>

		</div>

		<div class="col-sm-6">

		  <div class="created-specially-right d-flex justify-content-center h-100 flex-column">

			<h3 class="">CREATED SPECIALLY FOR YOU</h3>

			<p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground.</p>

			<button class="btn view-diamond-btn mt-4 mt-md-4 mt-lg-5">VIEW OUR DIAMONDS</button>

		  </div>

		</div>

	  </div>

	</div>

</section>



<section class="our-jewelry-slider position-relative">

	<div class="slider owl-carousel">

	  <div class="slider-row">

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4.jpg" class="img-fluid d-none d-sm-none d-md-block" title="banner-slider" alt="banner-slider" />

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4-mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" title="banner-slider" alt="banner-slider" />

		<div class="banner-slider-caption">

		  <h3>FLAWLESS PEDIGREE</h3>

		  <p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground.</p>

		  <button class="btn btn-our-jewelry mt-3 mt-md-5">SEE OUR JEWELRY</button>

		</div>

	  </div>

	  <div class="slider-row">

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4.jpg" class="img-fluid d-none d-sm-none d-md-block" title="banner-slider" alt="banner-slider" />

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4-mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" title="banner-slider" alt="banner-slider" />

		<div class="banner-slider-caption">

		  <h3>FLAWLESS PEDIGREE</h3>

		  <p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground.</p>

		  <button class="btn btn-our-jewelry mt-3 mt-md-5">SEE OUR JEWELRY</button>

		</div>

	  </div>

	  <div class="slider-row">

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4.jpg" class="img-fluid d-none d-sm-none d-md-block" title="banner-slider" alt="banner-slider" />

		<img src="<?php echo get_template_directory_uri();?>/images/banner-4-mobile.jpg" class="img-fluid d-block d-sm-block d-md-none" title="banner-slider" alt="banner-slider" />

		<div class="banner-slider-caption">

		  <h3>FLAWLESS PEDIGREE</h3>

		  <p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground.</p>

		  <button class="btn btn-our-jewelry mt-3 mt-md-5">SEE OUR JEWELRY</button>

		</div>

	  </div>

	</div>

	<div class="slider-counter"></div>

</section>



<section class="grid-column-section">

	<div class="container-fluid">

	  <div class="row">

		<div class="col-sm-6">

		  <div class="row">

			<div class="ethical-sourced-left p-0 position-relative">

			  <img src="<?php echo get_template_directory_uri();?>/images/ethically-secure-banner.jpg" class="img-fluid w-100 d-none d-sm-none d-md-block" title="ethically-secure-banner" alt="ethically-secure-banner" />
			  <img src="<?php echo get_template_directory_uri();?>/images/ethically-secure-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" title="ethically-secure-banner" alt="ethically-secure-banner" />

			  <div class="ethical-sourced-caption d-flex flex-column justify-content-center text-center">

				<h3>ETHICALLY SOURCED</h3>

				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut</p>

				<button class="btn btn-grown mt-3 mt-md-3 mt-lg-5">GROWN DIAMONDS</button>

			  </div>

			</div>

		  </div>

		</div>

		<div class="col-sm-6">

		  <div class="row">

			<div class="ethical-sourced-right p-0 position-relative">

			  <img src="<?php echo get_template_directory_uri();?>/images/ecologically.jpg" class="img-fluid" title="ethically-secure-banner" alt="ethically-secure-banner" />

			  <div class="ecology-sourced-caption d-flex flex-column justify-content-center text-center">

				<h3>ECOLOGICALLY PROGRESSIVE</h3>

				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut</p>

				<button class="btn btn-grown mt-3 mt-md-3 mt-lg-5">WHERE TO BUY</button>

			  </div>

			</div>

		  </div>

		</div>

	  </div>

	</div>

</section>



<section class="instagram-gallery py-5">

	<div class="container">

	  <div class="row">

		<div class="col-sm-12 text-center mb-4">

		  <h3>Follow <strong>@barediamond</strong> on Instagram</h3>

		</div>

		<div class="col-sm-3 col-6 mb-3 mb-md-0">

		  <div class="instagram-gallery-inner position-relative">

			<div class="content">

			  <a href="" target="_blank">

				<div class="content-overlay"></div>

				<img class="content-image" src="<?php echo get_template_directory_uri();?>/images/instagram-gallery-img2.jpg" />

				<div class="content-details fadeIn-top">

				  <i class="fa fa-heart" aria-hidden="true"></i> <span>54</span>

				</div>

			  </a>

			</div>

		  </div>

		</div>

		<div class="col-sm-3 col-6 mb-3 mb-md-0">

		  <div class="instagram-gallery-inner position-relative">

			<div class="content">

			  <a href="" target="_blank">

				<div class="content-overlay"></div>

				<img class="content-image" src="<?php echo get_template_directory_uri();?>/images/instagram-gallery-img1.jpg" />

				<div class="content-details fadeIn-top">

				  <i class="fa fa-heart" aria-hidden="true"></i> <span>54</span>

				</div>

			  </a>

			</div>

		  </div>

		</div>

		<div class="col-sm-3 col-6">

		  <div class="instagram-gallery-inner position-relative">

			<div class="content">

			  <a href="" target="_blank">

				<div class="content-overlay"></div>

				<img class="content-image" src="<?php echo get_template_directory_uri();?>/images/instagram-gallery-img3.jpg" />

				<div class="content-details fadeIn-top">

				  <i class="fa fa-heart" aria-hidden="true"></i> <span>54</span>

				</div>

			  </a>

			</div>

		  </div>

		</div>

		<div class="col-sm-3 col-6">

		  <div class="instagram-gallery-inner position-relative">

			<div class="content">

			  <a href="" target="_blank">

				<div class="content-overlay"></div>

				<img class="content-image" src="<?php echo get_template_directory_uri();?>/images/instagram-gallery-img4.jpg" />

				<div class="content-details fadeIn-top">

				  <i class="fa fa-heart" aria-hidden="true"></i> <span>54</span>

				</div>

			  </a>

			</div>

		  </div>

		</div>

	  </div>

	</div>

</section>

<!--Home page body content end-->



<?php get_footer();?>