<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Barediamond
 * @since 1.0.0
 */

get_header();
?>

	<div class="page-not-found">
        <div class="top-heading">
          <h1>PAGE NOT FOUND ON SERVER</h1>
        </div>
        <div class="image-404 py-7 text-center">
          <div class="col-sm-12">
            <img src="<?php echo get_template_directory_uri();?>/images/404-image.png" class="img-fluid" alt="404-image" title="404-image" />
            <p class="pt-5">The link you followed is either outdated, inaccurate.</p>
			      <p><a href="<?php echo home_url();?>">Home</a></p>
          </div>
        </div>
     </div>

<?php
get_footer();
