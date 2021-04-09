<?php 

/********currently not in use****************/



	require("../../../../wp-config.php");



	//ini_set('display_errors', 1);



	global $wpdb;



   	$date = date("j-M-Y");



	$data=array('Lot#,Shape,Color,Clarity,Weight,Lab,Cut Grade,Polish,Symmetry,Flouressence,CertificateNo,Length,Width,Depth,Depth%,Table%,Girdle,Culet,Desc,Origin,PricePerCt,PricePerPc,PriceCode,Certificate URL,VideoLink,ImageLink,Image,Notes');



	//$file_path = 'NuminedDiamondInventory-'.$date.'.csv';



	//$fp = fopen('php://output', 'w');



	$fp = fopen('php://memory', 'w');



	//$fp = fopen($file_path, 'w');



	foreach ($data as $line) {



		$val = explode(",", $line);



		fputcsv($fp, $val, ",");



	}







	$args = array(



        			'post_type'      => 'product',



        			'meta_key'   => 'vendor_name',



        			'posts_per_page' => -1,



        			'product_cat'    => 'loose-diamonds',



        			'meta_query' => array(



									        array(



									            'key'     => 'vendor_name',



									            'value'   => 'nu',



									        ),



									    ),



    			);



    $diamondfeeds = new WP_Query( $args );



    //show($diamondfeeds);



    $i=0;



    while ( $diamondfeeds->have_posts() ) : $diamondfeeds->the_post();



        global $product;



        $proID					=  get_the_ID();







        $cut_term_obj_list 		= 	get_the_terms( $proID, 'pa_cut' );



		if(!empty($cut_term_obj_list)){



			$cut_terms_string 	= 	join(': ', wp_list_pluck($cut_term_obj_list, 'name'));



		}



		



		$shapes_term_obj_list 	= 	get_the_terms( $proID, 'pa_shapes' );



		if(!empty($shapes_term_obj_list)){



			$shapes_terms_string = 	join(': ', wp_list_pluck($shapes_term_obj_list, 'name'));



		}



			



		$color_term_obj_list 	= 	get_the_terms( $proID, 'pa_color' );



		if(!empty($color_term_obj_list)){



			$color_terms_string 	= 	join(': ', wp_list_pluck($color_term_obj_list, 'name'));



		}



		



		$clarity_term_obj_list 	= 	get_the_terms( $proID, 'pa_clarity' );



		if(!empty($clarity_term_obj_list)){



			$clarity_terms_string 	= 	join(': ', wp_list_pluck($clarity_term_obj_list, 'name'));



		}



		



		$carat_term_obj_list 	= 	get_the_terms( $proID, 'pa_carat' );



		if(!empty($carat_term_obj_list)){



			$carat_terms_string 	= 	join(': ', wp_list_pluck($carat_term_obj_list, 'name'));



		}







		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $proID ), 'single-post-thumbnail' );



		



        $Id						=  $proID;



        $Shape					=  $shapes_terms_string;



        $Color					=  $color_terms_string;



        $Clarity				=  $clarity_terms_string;



        $Carat					=  $carat_terms_string;



        $CertificateLab			=  get_post_meta($proID, 'lab', true);



        $Cut					=  $cut_terms_string;



        $Polish					=  get_post_meta($proID, 'polish', true);



        $Symmetry				=  get_post_meta($proID, 'symmetry', true);



        $Fluorescence			=  get_post_meta($proID, 'fluor', true);



        $CertificateNo			=  get_post_meta($proID, 'certificate_no', true);



        $Length					=  '';		



		$Width					=  '';		



		$Depth					=  '';		



		$DepthPer				=  '';		



		$TablePer				=  get_post_meta($proID, 'table', true);		



		$Girdle					=  '';		



		$Culet					=  get_post_meta($proID, 'culet', true);		



		$Desc					=  '';		



		$Origin					=  '';		



		$PricePerCt				=  '';		



		$PricePerPc				=  '';		



		$PriceCode				=  '';		



		$CertificateURL			=  get_post_meta($proID, 'certificate_image', true);		



		$VideoLink				=  get_post_meta($proID, '360_video_link', true);		



		$ImageLink				=  $image[0];		



		$Image					=  '';		



		$Notes					=  '';		







    	$val=[



				'0' => (!empty($Id)?trim($Id):""),



				'1' => (!empty($Shape)?trim($Shape):""),



				'2' => (!empty($Color)?trim($Color):""),



				'3' => (!empty($Clarity)?trim($Clarity):""),



				'4' => (!empty($Carat)?trim($Carat):""),



				'5' => (!empty($CertificateLab)?trim($CertificateLab):""),



				'6' => (!empty($Cut)?trim($Cut):""),



				'7' => (!empty($Polish)?trim($Polish):""),



				'8' => (!empty($Symmetry)?trim($Symmetry):""),



				'9' => (!empty($Fluorescence)?trim($Fluorescence):""),



				'10' => (!empty($CertificateNo)?trim($CertificateNo):""),



				'11' => (!empty($Length)?trim($Length):""),



				'12' => (!empty($Width)?trim($Width):""),



				'13' => (!empty($Depth)?trim($Depth):""),



				'14' => (!empty($DepthPer)?trim($DepthPer):""),



				'15' => (!empty($TablePer)?trim($TablePer):""),



				'16' => (!empty($Girdle)?trim($Girdle):""),



				'17' => (!empty($Culet)?trim($Culet):""),



				'18' => (!empty($Desc)?trim($Desc):""),



				'19' => (!empty($Origin)?trim($Origin):""),



				'20' => (!empty($PricePerCt)?trim($PricePerCt):""),



				'21' => (!empty($PricePerPc)?trim($PricePerPc):""),



				'22' => (!empty($PriceCode)?trim($PriceCode):""),



				'23' => (!empty($CertificateURL)?trim($CertificateURL):""),



				'24' => (!empty($VideoLink)?trim($VideoLink):""),



				'25' => (!empty($ImageLink)?trim($ImageLink):""),



				'26' => (!empty($Image)?trim($Image):""),



				'27' => (!empty($Notes)?trim($Notes):""),



			];



		



		fputcsv($fp, $val, ",");



	endwhile;



	//wp_reset_query();



	//fclose($fp);



	//rewind($fp, 0);



	fseek($fp, 0);







	header('Content-Encoding: UTF-8');



	// tell the browser it's going to be a csv file



	header('Content-Type: application/csv; charset=UTF-8');



	// tell the browser we want to save it instead of displaying it



	$filename='NuminedDiamonds-'.$date.'.csv';



	header('Content-Disposition: attachment; filename="'.$filename.'";');



	// make php send the generated csv lines to the browser



	fpassthru($fp);







die();