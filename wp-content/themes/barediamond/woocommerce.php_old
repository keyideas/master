<?php
/**
 * The shop page template file
*/
get_header();

if( is_shop() ) { ?>
	<div class="diamond-listing-wrapper customize-ur-ring-wrapper">
		<div class="top-heading text-center">
			<h1>Shop</h1>
		</div>
		
			<div class="best-seller-wrapper py-7">
				<div class="container">
					<?php if (have_posts()) : ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<?php while (have_posts()) : the_post(); ?>
									<?php woocommerce_get_template_part('content', 'product'); ?>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
					<div class="pagination">  <?php  woocommerce_pagination(); ?></div>
					<?php else : ?>
						<p class="no_result_found">No result found</p>
					<?php endif; ?>

				</div>
			</div>
		
	</div>
<?php
}
if( is_product_category() ) { ?>
	<div class="diamond-listing-wrapper customize-ur-ring-wrapper">
		<div class="top-heading text-center">
			<?php  $term = get_queried_object();  ?>
			<h1><?php echo $term->name;?></h1>
			<!-- <p>For Your Loved Ones</p> -->
			<?php echo $term->description;?>
		</div>
		
			<div class="best-seller-wrapper px-md-3">
				<?php if (have_posts()) : ?>
				<div class="container">
					
					<div class="row">
						<?php while (have_posts()) : the_post(); ?>
							<?php woocommerce_get_template_part('content', 'product'); ?>
						<?php endwhile; ?>
					</div>
				</div>
				<div class="pagination"><?php woocommerce_pagination(); ?></div>
				<?php else : ?>
					<p class="no_result_found">No result found</p>
				<?php endif; ?>
			</div>
		
	</div>
<?php
}
if (is_product()) {
	global $product;
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	if( !empty($terms) && ($terms[0]->slug == 'diamond') ) {
		woocommerce_get_template_part('content', 'diamonds');
	} else {
		if (have_posts()) while (have_posts()) : the_post();
		woocommerce_get_template_part('content', 'single-product');
		endwhile; // end of the loop.
	}
}
get_footer();
?>