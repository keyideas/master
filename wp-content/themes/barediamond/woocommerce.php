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
if( is_product_category() ) {

   $term = get_queried_object();
   $slug = $term->slug;


    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if($slug=='engagement-rings')
    {
			$args = array(
	            'posts_per_page' => 8,     
	            'paged' => $paged,        
	            'post_type' => 'product',
	            'post_status' => 'publish',
	             'tax_query' => array(              
	                array(
	                    'taxonomy' => 'product_cat',
	                    'field' => 'slug',
	                    'terms' => $slug,
	                )
	            ),
	            'orderby'        => 'meta_value_num',
	            'meta_key'       => 'prodmeta_showas_topring',
	            'order'          => 'desc'
	        );
		}
		else
		{

				$args = array(
	            'posts_per_page' => 8,     
	            'paged' => $paged,        
	            'post_type' => 'product',
	            'post_status' => 'publish',
	             'tax_query' => array(              
	                array(
	                    'taxonomy' => 'product_cat',
	                    'field' => 'slug',
	                    'terms' => $slug,
	                )
	            ),            
	        );


		}
  
         $products = new WP_Query( $args );  

 ?>
	<div class="diamond-listing-wrapper customize-ur-ring-wrapper">
		<div class="top-heading text-center">
			<?php  $term = get_queried_object();  ?>
			<h1><?php echo $term->name;?></h1>
			<!-- <p>For Your Loved Ones</p> -->
			<?php echo $term->description;?>
			<p><?php  echo $total_items = $products->found_posts; ?> Items</p>
		</div>
		
		<div class="best-seller-wrapper px-md-3">
			<?php if ($products->have_posts()) : ?>
			<div class="container">				
				<div class="row">
					<?php   while ( $products->have_posts() ):
                        $products->the_post(); ?>
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