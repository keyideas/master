<?php
/*
 *
 * Template name: vendor page
 * 
 */

//get_header(); 
include ('includes/header.php');

?>


	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();
		//the_title();
		the_content();

	endwhile; // End of the loop.
	?>


<?php //get_footer();
include ('includes/footer.php');
