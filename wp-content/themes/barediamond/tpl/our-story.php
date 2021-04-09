<?php
/**
Template Name: Our story
*/

get_header();
?>

<!-- <section class="banner-section our-story">
	<div class="banner-inner position-relative">
	  <img src="<?php //echo get_template_directory_uri();?>/images/our-story-banner.png" class="img-fluid w-100" alt="our-story-banner" title="our-story-banner" />
	  <div class="banner-caption d-flex flex-column justify-content-center">
		<h1>CONSCIOUSLY CRAFTED</h1>
		<h2>ELEGANT. EXQUISITE. ETHICAL.</h2>
	  </div>
	</div>
</section> -->

<section class="banner-section our-story">
	<h1>OUR STORY</h1>
	<h2>ELEGANT. EXQUISITE. ETHICAL</h2>
</section>

<section class="created-specially-section">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-sm-6">
		  <div class="row">
			<div class="create-banner-left p-0 w-100">
			  <img src="<?php echo get_template_directory_uri();?>/images/our-story-diamond-industry.png" class="img-fluid w-100" alt="our-story-diamond-industryr" title="our-story-diamond-industryr">
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="created-specially-right d-flex justify-content-center h-100 flex-column">
			<h3 class="">DIAMOND INDUSTRY DISRUPTORSU</h3>
			<p>Bare Diamond was created by a trust of second-generation jewelers who felt it was important to offer an alternative to the environmental and human devastation that carving diamonds from the Earth wreaks. Wanting to create a diamond with a transparent pedigree they set about to find a solution.</p>
			<!-- <button class="btn view-diamond-btn mt-3 mt-md-3 mt-lg-5">VIEW OUR DIAMONDS</button> -->
			<a href="<?php echo home_url();?>/diamonds" class="btn view-diamond-btn mt-3 mt-md-3 mt-lg-5">VIEW OUR DIAMONDS</a>
		  </div>
		</div>
	  </div>
	</div>
</section>

<section class="created-specially-section">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-sm-6">
		  <div class="created-specially-right d-flex justify-content-center h-100 flex-column max-width-500">
			<h3 class="">MODERN TECHNOLOGY MARRIES TIMELESS SIGNIFICANCE</h3>
			<p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground. Each Bare Diamond takes more than three hundred hours to handcraft to exacting specifications. Our engineers are highly educated scientists with decades of years in the field.and we work with the most advanced lab technology and precise cutting lasers in our state of the art facilities to create diamonds with a sustainable origin.</p>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="row">
			<div class="create-banner-left p-0 w-100">
			  <img src="<?php echo get_template_directory_uri();?>/images/our-story-modern-technology.png" class="img-fluid w-100" alt="our-story-modern-technology" title="our-story-modern-technology">
			</div>
		  </div>
		</div>
		
	  </div>
	</div>
</section>

<section>
	<div class="container-fluid">
	  <div class="row">
		<div class="popup-gallery w-100">
		  <a class="popup-youtube" href="https://www.youtube.com/watch?v=l9pg6h1A688">
			<img src="<?php echo get_template_directory_uri();?>/images/video-img-new-min.png" class="img-fluid w-100" alt="video-img-new-min" title="video-img-new-min" />
		  </a>
		</div>
	  </div>
	</div>
</section>

<section class="created-specially-section">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-sm-6">
		  <div class="row">
			<div class="create-banner-left p-0 w-100">
			  <img src="<?php echo get_template_directory_uri();?>/images/our-story-stones-hold.png" class="img-fluid w-100" alt="our-story-stones-holdr" title="our-story-stones-holdr">
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="created-specially-right d-flex justify-content-center h-100 flex-column max-width-500">
			<h3 class="">STONES HOLD THE ENERGY OF THEIR HISTORY.</h3>
			<p>Mother Nature has created diamonds deep beneath the Earth’s mantle for billions of years. These sparkling, indestructible stones have come to represent all of our most precious feelings for one another. The only problem is that mining diamonds from the Earth can come with an unsustainable human and environmental cost.</p>
		  </div>
		</div>
	  </div>
	</div>
</section>

<!--get instagram fedd-->
<?php echo do_shortcode('[instagram-feed]');?>

<?php get_footer();?>