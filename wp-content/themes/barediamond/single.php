<?php
/**
 * The template for displaying all single posts
*/

get_header(); ?>

<div class="wrap">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				the_title();
				the_content();

			endwhile; // End of the loop.
			?>

	<?php //get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
