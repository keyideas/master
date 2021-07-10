<?php

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

//for show nav menu option in admin
register_nav_menus(
	array( 
		'header' => 'Header menu', 
		'footer' => 'Footer menu' 
	)
);

define('NUMINED_THEME_URI', get_template_directory_uri());
define('BASE_URL', get_site_url());

function numined_enqueue_scripts()
{
   
    wp_enqueue_script('filter-ajax', NUMINED_THEME_URI . '/js/custom-ajax.js', array('jquery' ) , '1.0.0', true);
    wp_localize_script('filter-ajax', 'my_ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php') ));

}
add_action("wp_enqueue_scripts", "numined_enqueue_scripts");

function single_product_custom_rewrite_rule()
{

    add_rewrite_rule('([^/]*)/([^/]*)/([^/]*)/?', 'index.php?cat=$matches[1]&product=$matches[2]&attribute_pa_metal=$matches[3]', 'bottom');
}
add_action('init', 'single_product_custom_rewrite_rule', 10, 0);

function wpd_add_query_vars($qvars)
{
    $qvars[] = 'cat';
    $qvars[] = 'product';
    $qvars[] = 'attribute_pa_metal';
    return $qvars;
}
add_filter('query_vars', 'wpd_add_query_vars');


//for show widgets option in admin
add_theme_support('widgets');

//for show post thumbnail option in admin
add_theme_support('post-thumbnails');

add_action( 'widgets_init', 'my_footer_widgets' );
function my_footer_widgets() {
	register_sidebar(
		array(
			'name' 			=> __( 'Footer Logo', 'footer-logo' ),
			'id' 			=> 'footer-logo',
			'description' 	=> __( 'Widgets for footer logo.', 'footer-logo' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name' 			=> __( 'Copyright', 'footer-copyright ' ),
			'id' 			=> 'footer-copyright',
			'description' 	=> __( 'Widgets for footer copyright.', 'footer-copyright' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		)
	);
}

//add custom class to li in wp nav menu
add_filter( 'nav_menu_link_attributes', 'wp_nav_menu_add_class', 10, 3 );
function wp_nav_menu_add_class( $atts, $item, $args ) {

	if( $args->menu == 'main-menu' ) {
		$class = 'nav-link'; // or something based on $item
		$atts['class'] = $class;
	}
	return $atts;
}

//Custom Post Type for home slider
function create_post_type() {
	
	register_post_type('slider',
		array(
			'labels' 			=> array(
				'name' 			=> __( 'Slider' ),
				'all_items' 	=> __( 'All Slides' ),
				'add_new_item' 	=> __( 'Add Slide' ),
				'singular_name' => __( 'Slide' ),
				'featured_image' 		=> __( 'Slide Image' ),
				'set_featured_image' 	=> __( 'Set Slide Image' ),
				'remove_featured_image' => __( 'Remove Slide Image' ),
				'use_featured_image' 	=> __( 'Use as Slide Image' ),
				'excerpt' 				=> __( 'Slide Tagline' )
			),
			'public' 			=> true,
			'has_archive' 		=> true,
			'show_in_menu'		=> true,
			'rewrite' 			=> array(
				'slug' 			=> 'slider'
			),

			'supports' => array('title','editor','thumbnail','excerpt'),
			'menu_icon' 		=> 'dashicons-slides',
		)
	);
	
}
add_action( 'init', 'create_post_type' );

//Detect User device
function isMobileDevice() { 
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
, $_SERVER["HTTP_USER_AGENT"]); 
}

add_filter( 'wpcf7_autop_or_not', '__return_false' );

add_action( 'wpcf7_before_send_mail', 'wpcf7_mail_sent_event_triggered', 10, 3);
//contact form 7 hook to send second email to basecamp after sending the default one.
//function wpcf7_mail_sent_event_triggered( $contact_form ) {
function wpcf7_mail_sent_event_triggered( $contact_form, $abort, $submission ) {
	//$submission = WPCF7_Submission::get_instance();
	$form_id = $contact_form->id();
	$sent_to_basecamp = '';
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip_address"));
	$region = isset($geo["geoplugin_region"]) ? $geo["geoplugin_region"] : "";
	$city = isset($geo["geoplugin_city"]) ? $geo["geoplugin_city"] : "";
	$country = $geo["geoplugin_countryName"];
	$ip_address = $ip_address."/".$region."/".$city."/".$country;
	$server = $_SERVER['HTTP_USER_AGENT'];
	$refferal_url = $_SERVER['HTTP_REFERER'];
	$home_url = home_url();
	if(isMobileDevice()){ 
		$request_from = 'Mobile';
	}else{
		$request_from = 'Desktop';
	}

	 if(!empty($refferal_url)){
		 if (strpos($refferal_url,$home_url) !== false) {
			 $reffered_by = 'Direct';
		 }else{
			 $reffered_by = 'Affiliate';
		 }
	 }else{
		 $reffered_by = 'Direct';
		 $refferal_url = $home_url;
	 }
	 
	
	//form id for contact-us(81), schedule-appointment(84) and customize-your-ring(90), place order(210)
	if (81 == $form_id) {
		if($submission) {
            // get submission data
            $data = $submission->get_posted_data();
			if (empty($data)){
                            return;
			}
			
			$name = $data['full-name'];
			$email = $data['your-email'];
			$phone = $data['phone'];
			$company = $data['company'];
			$details = $data['details'];
			
			$page_url = home_url().'/contact-us';
			$subject = 'New Contact Inquiry BareGrown Diamond';
			
			$sent_to_basecamp = 'A user of the website has submitted a request from the Contact Us form.'."\n";
			$sent_to_basecamp .= 'Name: '.$name."\n";
			$sent_to_basecamp .= 'Email: '.$email."\n";
			$sent_to_basecamp .= 'Phone: '.trim($phone)."\n";
			$sent_to_basecamp .= 'Date: '.date('F d, Y, h:i a')."\n";
			$sent_to_basecamp .= 'Company: '.$company."\n";
			$sent_to_basecamp .= 'Comments: '.$details."\n";
			$sent_to_basecamp .= 'Page URL: '.$page_url."\n";
			$sent_to_basecamp .= 'Referral URL: '.$refferal_url."\n";
			$sent_to_basecamp .= 'Request From: '.$request_from."\n";
			$sent_to_basecamp .= 'Referred BY: '.$reffered_by."\n";
			$sent_to_basecamp .= 'IP Address: '.$ip_address."\n";
			$sent_to_basecamp .= 'Agent: '.$server."\n";

		}
        
	}else if (84 == $form_id) {
		if($submission) {
            // get submission data
            $data = $submission->get_posted_data();
			if (empty($data)){
                            return;
			}
			
			$name = $data['full-name'];
			$appointment = $data['appointment'];
			$contact_method = $data['contact-method'][0];
			$email = $data['email'];
			$phone = $data['phone'];
			$date = date('m-d-Y',strtotime($data['date']));
			$time_slot = $data['time-slot'][0];
			$budget = $data['budget'][0];
			$message = $data['message'];
			
			$page_url = home_url().'/schedule-appointment';
			$subject = 'Schedule Appointment BareGrown Diamond';
			
			$sent_to_basecamp = 'Schedule Appointment request submitted on BareGrown Diamond'."\n";
			$sent_to_basecamp .= 'Submit Date: '.date('F d, Y, h:i a')."\n";
			$sent_to_basecamp .= 'Name: '.$name."\n";
			$sent_to_basecamp .= 'Appointment: '.$appointment."\n";
			$sent_to_basecamp .= 'Contact Method: '.$contact_method."\n";
			$sent_to_basecamp .= 'Email: '.$email."\n";
			$sent_to_basecamp .= 'Phone: '.trim($phone)."\n";
			$sent_to_basecamp .= 'Date: '.$date."\n";
			$sent_to_basecamp .= 'Time Slot: '.$time_slot."\n";
			$sent_to_basecamp .= 'Budget: '.$budget."\n";
			$sent_to_basecamp .= 'Message: '.$message."\n";
			$sent_to_basecamp .= 'Page URL: '.$page_url."\n";
			$sent_to_basecamp .= 'Referral URL: '.$refferal_url."\n";
			$sent_to_basecamp .= 'Request From: '.$request_from."\n";
			$sent_to_basecamp .= 'Referred BY: '.$reffered_by."\n";
			$sent_to_basecamp .= 'IP Address: '.$ip_address."\n";
			$sent_to_basecamp .= 'Agent: '.$server."\n";
		}
		
	}else if (90 == $form_id) {
		if($submission) {
            // get submission data
            $data = $submission->get_posted_data();
			if (empty($data)){
                            return;
			}
			
			$name = $data['full-name'];
			$email = $data['your-email'];
			$mobile = $data['mobile'];
			$date = date('m-d-Y',strtotime($data['date']));
			$ring_size = $data['ring-size'][0];
			$budget = $data['budget'][0];
			$message = $data['message'];
			
			$page_url = home_url().'/customize-your-ring';
			$subject = 'Customize Your Ring BareGrown Diamond';
			
			$sent_to_basecamp = 'Customize Ring request submitted on BareGrown Diamond'."\n";
			$sent_to_basecamp .= 'Submit Date: '.date('F d, Y, h:i a')."\n";
			$sent_to_basecamp .= 'Name: '.$name."\n";
			$sent_to_basecamp .= 'Email: '.$email."\n";
			$sent_to_basecamp .= 'Mobile: '.trim($mobile)."\n";
			$sent_to_basecamp .= 'Date: '.$date."\n";
			$sent_to_basecamp .= 'Ring Size: '.$ring_size."\n";
			$sent_to_basecamp .= 'Budget: '.$budget."\n";
			$sent_to_basecamp .= 'Message: '.$message."\n";
			$sent_to_basecamp .= 'Page URL: '.$page_url."\n";
			$sent_to_basecamp .= 'Referral URL: '.$refferal_url."\n";
			$sent_to_basecamp .= 'Request From: '.$request_from."\n";
			$sent_to_basecamp .= 'Referred BY: '.$reffered_by."\n";
			$sent_to_basecamp .= 'IP Address: '.$ip_address."\n";
			$sent_to_basecamp .= 'Agent: '.$server."\n";
			
			//echo "sent_to_basecamp=".$sent_to_basecamp;
			//die;
		}
		
	}else if (210 == $form_id) {
		if($submission) {
            // get submission data
            $data = $submission->get_posted_data();
			if (empty($data)){
                            return;
			}
			
			$name = $data['your-name'];
			$email = $data['your-email'];
			$product_name = $data['product-name'];
			$mobile = $data['contact'];
			$product_url = $data['product-url'];
			$message = $data['comment'];
			
			//$page_url = home_url().'/shop';
			$subject = 'Order placed on BareGrown Diamond';
			
			$sent_to_basecamp = 'Order placed request submitted on BareGrown Diamond'."\n";
			$sent_to_basecamp .= 'Submit Date: '.date('F d, Y, h:i a')."\n";
			$sent_to_basecamp .= 'Name: '.$name."\n";
			$sent_to_basecamp .= 'Email: '.$email."\n";
			$sent_to_basecamp .= 'Product: '.$product_name."\n";
			$sent_to_basecamp .= 'Mobile: '.trim($mobile)."\n";
			$sent_to_basecamp .= 'Message: '.$message."\n";
			$sent_to_basecamp .= 'Page URL: '.$product_url."\n";
			$sent_to_basecamp .= 'Referral URL: '.$refferal_url."\n";
			$sent_to_basecamp .= 'Request From: '.$request_from."\n";
			$sent_to_basecamp .= 'Referred BY: '.$reffered_by."\n";
			$sent_to_basecamp .= 'IP Address: '.$ip_address."\n";
			$sent_to_basecamp .= 'Agent: '.$server."\n";
			
		}
		
	}
	
	//$basecamp_email_id = 'message-94366756-9d8024795843425f8ae2db4b@basecamp.com';
	
	if(!empty($sent_to_basecamp)){
		mail( 'message-94181202-9d8024795843425f8ae2db4b@basecamp.com', $subject, $sent_to_basecamp); //email to basecamp as text format
                //mail( 'shashank@keyideasglobal.com', $subject, $sent_to_basecamp);
                
        }
}

//add custom shortcode to cf7
function bd_add_year_tag(){
        // This adds a form tag to the FORM itself called [year_tag]
        wpcf7_add_form_tag('year_tag', 'cf7_year_field_handler');
		wpcf7_add_form_tag('base_url', 'cf7_baseurl_field_handler');
}
add_action('wpcf7_init', 'bd_add_year_tag');

function cf7_year_field_handler($tag){
    $year = date('Y');
    // create hidden form field with name "current-year" and Current Year as value.
    $output = '<input type="hidden" name="current-year" value='.$year.'>';
    return $output;
}
function cf7_baseurl_field_handler($tag){
    $base_url = home_url();
    $output = '<input type="hidden" name="baseurl" value='.$base_url.'>';
    return $output;
}


// disable Gutenberg  for posts
add_filter('use_block_editor_for_post', '__return_false', 10);
// disable Gutenberg  for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

//Remove <p> and <br> tags from editor added defualt by wp
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

//Remove cf7 css, script and recaptcha from unused pages
function bgd_disable_recaptcha_badge_page(){
   if ( !is_page( array( 'contact-us', 'schedule-appointment', 'customize-your-ring', 'diamonds') ) && !is_singular( 'product' ) ) {
       wp_dequeue_script('google-recaptcha');    
       wp_dequeue_script('wpcf7-recaptcha');
       wp_dequeue_style('wpcf7-recaptcha');
	   wp_dequeue_script('contact-form-7');
       wp_dequeue_style('contact-form-7');
   }
}
add_action( 'wp_enqueue_scripts', 'bgd_disable_recaptcha_badge_page' );



// delete product category slug from the url
add_filter('request', function( $vars ) {
   global $wpdb;
   if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
      $slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
      $exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
      if( $exists ){
         $old_vars = $vars;
         $vars = array('product_cat' => $slug );
         if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
            $vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
         if ( !empty( $old_vars['orderby'] ) )
            $vars['orderby'] = $old_vars['orderby'];
         if ( !empty( $old_vars['order'] ) )
            $vars['order'] = $old_vars['order']; 
      }
   }
   return $vars;
});

if(is_product())
{

	add_filter( 'woocommerce_register_post_type_product', function($var) {
	    $var['rewrite'] = str_replace('/shop/', '/', $var['rewrite']);
	    return $var;
	});
	
}

//shortcode for instagram feed
function get_instagram_feed() {
    ob_start();
	get_template_part( 'tpl/template-part', 'instagram' );
    return ob_get_clean();   
} 
add_shortcode( 'instagram-feed', 'get_instagram_feed' );


/* get the diamond detail by id */
function get_detail_api_data($postId){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => get_site_url()."/wp-json/diamond/v1/details/$postId",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 500,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"postman-token: 0845db60-442f-a1c9-5a43-f9ba30590a7c"
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$response = json_decode($response, true);
	return $response;
}

/* get the similar diamond by id */
function get_similar_api_data($postId){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => get_site_url()."/wp-json/diamond/v1/similar_diamonds?id=$postId",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 500,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		  "cache-control: no-cache",
		  "postman-token: 0845db60-442f-a1c9-5a43-f9ba30590a7c"
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$response = json_decode($response, true);
	return $response;
}

/* get certificate url by lab */
function get_cert_img($lab){
	if($lab=='GIA') {
		$cert_img = get_template_directory_uri().'/images/gia_member_logo_480x-1.png';
	} elseif($lab=='IGI') {
		$cert_img = get_template_directory_uri().'/images/logo_IGI.png';
	}elseif($lab=='GCAL'){
		$cert_img = get_template_directory_uri().'/images/GCAL_logo.jpg';
	}elseif($lab=='AGS'){
		$cert_img = get_template_directory_uri().'/images/AGS_logo-1.jpg';
	} else {
		$cert_img = get_template_directory_uri().'/images/GIA_Logo.png';
	}
	return $cert_img;
}

/* get certificate url by lab */
function get_cert_sample_img($lab){
	if($lab=='GIA') {
		$cert_img = get_template_directory_uri().'/images/GIA-cert.jpg';
	} elseif($lab=='IGI') {
		$cert_img = get_template_directory_uri().'/images/IGI-cert.jpg';
	}elseif($lab=='GCAL'){
		$cert_img = get_template_directory_uri().'/images/cert-sample-GCAL_image.jpg';
	}elseif($lab=='AGS'){
		$cert_img = get_template_directory_uri().'/images/GIA-cert.jpg';
	} else {
		$cert_img = get_template_directory_uri().'/images/GIA-cert.jpg';
	}
	return $cert_img;
}

function get_parent_category_by_product_id ($product_id)

{

   

    $categories = get_the_terms( $product_id, 'product_cat' );



    if ( $categories && ! is_wp_error( $categories ) ) :

        foreach($categories as $category) :

            $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));

            if ( count($children) == 0 ) {

                $categname =  $category->name;

                $categslug =  $category->slug;

                $link1 =  '/'.$category->slug;

                $categid =  $category->term_id;

            }

            if($category->parent == 0){

                $parentCateg =  $category->name;        

                $parentCatSlug = $category->slug;

                

            }

        endforeach;

    endif;



    return $parentCatSlug;



}

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options –> Reading
  // Return the number of products you wanna show per page.
  $cols = 8;
  return $cols;
}

add_shortcode( 'barediamond_vendor', 'jas_vendor_shortcode' );
function jas_vendor_shortcode( ) {
    require_once (dirname( __FILE__ ) . '/includes/barediamond_vendor_file.php');
}