<?php
/**
 * The template for displaying all pages
*/

get_header(); ?>


	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();
		//the_title();
		the_content();

	endwhile; // End of the loop.
	?>


<?php get_footer();
