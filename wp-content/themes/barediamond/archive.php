<?php
/**
 * The template for displaying archive pages
*/

get_header(); ?>

<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				the_content();

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'mytheme' ),
				'next_text'          => __( 'Next page', 'mytheme' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mytheme' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			the_content();

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
