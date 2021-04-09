<?php
/**
Template Name: Education
*/

get_header(); 

?>
      <!-- <section class="banner-section education-banner">
        <div class="banner-inner position-relative">
          <img src="<?php // echo get_template_directory_uri();?>/images/education-banner.png" class="img-fluid w-100" alt="education-banner" title="education-banner" />
          <div class="banner-caption d-flex flex-column justify-content-center">
            <h1>THE DIFFERENCE</h1>
            <h2>CREATED WITHOUT QUESTIONABLE PRACTICES</h2>
          </div>
        </div>
      </section> -->

      <section class="banner-section education-page">
        <h1>EDUCATION</h1>
        <h2>CREATED WITHOUT QUESTIONABLE PRACTICES</h2>
      </section>

      <section class="created-specially-section">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="create-banner-left p-0 w-100">
                  <img src="<?php echo get_template_directory_uri();?>/images/our-story-modern-technology.png" class="img-fluid w-100" alt="our-story-modern-technology" title="our-story-modern-technology">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="created-specially-right d-flex justify-content-center h-100 flex-column max-width-400">
                <h3 class="">The Diamond Mine <br> of the Future</h3>
                <p>IN 1796, Chemist Smithson Tennant discovered that diamonds are made from pure carbon, the key ingredient for most life on earth. It took almost half a century to perfect a chamber that could create diamonds free from the ecological and human cost of diamonds mined from the earth. We have painstakingly recreated the precise environment that natures uses to create our consciously crafted diamonds, making them indistinguishable from mined diamonds.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="created-specially-section py-7 xs-py-0">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-7">
              <div class="created-specially-right d-flex justify-content-center h-100 flex-column max-width-500">
                <h3 class="">CREATED WITHOUT QUESTIONABLE PRACTICES</h3>
                <p>Each Bare Diamond starts with a tiny diamond seed as thin as a human hair that is then planted in a vacuum chamber and heated to more than 2000 degrees with pressure fifty times greater than the earth’s atmosphere imitating the force of a mountain.</p>
                <p>Gasses are injected into the cocoon to form a plasma that rains down on the tiny seed causing it to grow up to ten times their original size. The diamonds are then polished with diamond grit, the only substance hard enough to polish a diamond. They are then hand cut by our Master Cutters to sparkling perfection and certified. Each Bare Diamond takes more than three hundred hours to handcraft to exacting specifications.</p>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row">
                <div class="create-banner-left p-0 w-100">
					<a class="popup-youtube" href="https://www.youtube.com/watch?v=l9pg6h1A688">
					  <img src="<?php echo get_template_directory_uri();?>/images/education-video.png" class="img-fluid w-100" alt="education-video" title="education-video">
					</a>
				</div>
              </div>
            </div>
            
          </div>
        </div>
      </section>

      <section class="created-specially-section">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-7 col-md-7 col-lg-6 col-xl-6">
              <div class="row">
                <div class="create-banner-left p-0 w-100">
                  <img src="<?php echo get_template_directory_uri();?>/images/education-diamond.png" class="img-fluid w-100" alt="education-diamond" title="education-diamond">
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="created-specially-right d-flex justify-content-center h-100 flex-column max-width-500">
                <h3 class="">STONES WITH A FLAWLESS PEDIGREE</h3>
                <p>More than one million pounds of the earth are displaced to create a single carat stone in the earth. The environmental and human devastation that comes with this antiquated practice is too high of a price to pay. Bare Diamonds are beautiful in every way with all of their integrity intact. Ethically sourced, indistinguishable from mined diamonds, ecologically progressive Bare Diamonds are the next generation of the diamond.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="dont-compreomize-section">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-8 offset-sm-2">
              <div class="dont-compreomize-inner text-center text-white">
                <h3 class="mb-4">DON’T COMPROMISE. YOUR BELIEFS…OR YOUR WALLET.</h3>
                <p class="w-75 m-auto">The word diamond comes from the Greek, Adamas, meaning invincible. With a transparent pedigree, Bare Diamonds are indistinguishable from mined diamonds but cost 30-40% less, making you…virtually invincible.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

<!--get instagram fedd-->
<?php echo do_shortcode('[instagram-feed]');?>

<?php get_footer();?>