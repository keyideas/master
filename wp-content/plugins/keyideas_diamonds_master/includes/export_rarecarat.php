<?php 
/********currently not in use****************/
//require("../../../../wp-config.php");

//ini_set('display_errors', 0);

global $wpdb;

$date = date("j-M-Y");

$data=array(

'Id,URL,ImagesURL,VideosURL,CertificateLab,CertificateURL,CertificateID,Price,Shape,Carat,Cut,Color,Clarity,Fluorescence,Polish,Symmetry,TableWidth,TableWidthPercentage,Girdle Thin,Girdle Thick,GirdleThickness,GirdleDiameter,Culet,CuletSize,CuletAngle,CrownHeight,CrownHeightPercentage,CrownAngle,PavilionDepth,PavilionDepthPercentage,PavilionAngle,DepthPercentage,LengthToWidthRatio,Measurements,GirdleToTableDistance,StarLength,StarLengthPercentage,GirdleToCuletDistance,LowerHalfLength,LowerHalfLengthPercentage,ShippingDays,WirePrice,Eye Clean,Lab Grown,Availability,Country,State,City');

	//$file_path = 'NuminedDiamondInventory-'.$date.'.csv';

	//$fp = fopen('php://output', 'w');

	$fp = fopen('php://memory', 'w');

	//$fp = fopen($file_path, 'w');

	foreach ($data as $line) {

		$val = explode(",", $line);

		fputcsv($fp, $val, ",");

	}



	//$product_ids = $wpdb->get_results("SELECT GROUP_CONCAT(posts_id SEPARATOR ', ') as proids FROM {$wpdb->prefix}custom_diamonds",ARRAY_A);

	//$proidsArr=$product_ids[0]['proids'];

 //echo "<pre>";

 //print_r($get_product_id[0]['proids']);



	/*$args = array(

        			'post_type'      => 'product',

        			'posts_per_page' => 10,

        			'post_status'	=> 'publish',

        			'include' => array($proidsArr),

    			);

    $diamondfeeds = new WP_Query( $args );*/

$getdiamonds="SELECT cd.*, p.post_date,p.post_content,p.post_title,p.post_excerpt,p.post_status,p.post_modified,

			  p.post_name FROM ".$wpdb->prefix."custom_kdmdiamonds as cd INNER JOIN ".$wpdb->prefix."posts as p ON 

			  cd.posts_id=p.ID WHERE cd.status <> 4";

$diamondresults=$wpdb->get_results($getdiamonds);

//show($diamondresults);

	$i=0;

	foreach ($diamondresults as $key => $diamond) {



        $Id							=  $diamond->Style;

		$URL						=  site_url().'/product/'.$diamond->post_name;

		$ImagesURL					=  $diamond->Image;

		$VideosURL					=  $diamond->VideoLink;

		$CertificateLab				=  $diamond->CertType;

		$CertificateURL				=  $diamond->CertLink;

		$CertificateID				=  '';

		$Price						=  $diamond->WholesalePrice;

		$Shape						=  $diamond->ShapeCode;

		$Carat						=  $diamond->SizeCt;

		$Cut						=  $diamond->Cut;

		$Color						=  $diamond->Color;

		$Clarity					=  $diamond->Clarity;

		$Fluorescence				=  $diamond->Fluorescence;

		$Polish						=  $diamond->Polish;

		$Symmetry					=  $diamond->Symmetry;

		$TableWidth					=  '';

		$TableWidthPercentage		=  $diamond->TablePct;

		$GirdleThin					=  '';

		$GirdleThick				=  '';

		$GirdleThickness			=  '';

		$GirdleDiameter				=  '';

		$Culet						=  '';

		$CuletSize					=  '';

		$CuletAngle					=  '';

		$CrownHeight				=  '';

		$CrownHeightPercentage		=  '';

		$CrownAngle					=  '';

		$PavilionDepth				=  '';

		$PavilionDepthPercentage	=  '';

		$PavilionAngle				=  '';

		$DepthPercentage			=  $diamond->DepthPct;

		$LengthToWidthRatio			=  '';

		$Measurements				=  $diamond->Measurements;

		$GirdleToTableDistance		=  '';

		$StarLength					=  '';

		$StarLengthPercentage		=  '';

		$GirdleToCuletDistance		=  '';

		$LowerHalfLength			=  '';

		$LowerHalfLengthPercentage	=  '';

		$ShippingDays				=  '3';

		$WirePrice					=  '';

		$EyeClean					=  '';

		$LabGrown					=  'Yes';

		$Availability				=  'Y';

		$Country					=  '';

		$State						=  '';

		$City						=  '';



    	$val=[

				'0' => (!empty($Id)?str_replace(","," ",trim($Id)):""),

				'1' => (!empty($URL)?str_replace(","," ",trim($URL)):""),

				'2' => (!empty($ImagesURL)?str_replace(","," ",trim($ImagesURL)):""),

				'3' => (!empty($VideosURL)?str_replace(","," ",trim($VideosURL)):""),

				'4' => (!empty($CertificateLab)?str_replace(","," ",trim($CertificateLab)):""),

				'5' => (!empty($CertificateURL)?str_replace(","," ",trim($CertificateURL)):""),

				'6' => (!empty($CertificateID)?str_replace(","," ",trim($CertificateID)):""),

				'7' => (!empty($Price)?str_replace(","," ",trim($Price)):""),

				'8' => (!empty($Shape)?str_replace(","," ",trim($Shape)):""),

				'9' => (!empty($Carat)?str_replace(","," ",trim($Carat)):""),

				'10' => (!empty($Cut)?str_replace(","," ",trim($Cut)):""),

				'11' => (!empty($Color)?str_replace(","," ",trim($Color)):""),

				'12' => (!empty($Clarity)?str_replace(","," ",trim($Clarity)):""),

				'13' => (!empty($Fluorescence)?str_replace(","," ",trim($Fluorescence)):""),

				'14' => (!empty($Polish)?str_replace(","," ",trim($Polish)):""),

				'15' => (!empty($Symmetry)?str_replace(","," ",trim($Symmetry)):""),

				'16' => (!empty($TableWidth)?str_replace(","," ",trim($TableWidth)):""),

				'17' => (!empty($TableWidthPercentage)?str_replace(","," ",trim($TableWidthPercentage)):""),

				'18' => (!empty($GirdleThin)?str_replace(","," ",trim($GirdleThin)):""),

				'19' => (!empty($GirdleThick)?str_replace(","," ",trim($GirdleThick)):""),

				'20' => (!empty($GirdleThickness)?str_replace(","," ",trim($GirdleThickness)):""),

				'21' => (!empty($GirdleDiameter)?str_replace(","," ",trim($GirdleDiameter)):""),

				'22' => (!empty($Culet)?str_replace(","," ",trim($Culet)):""),

				'23' => (!empty($CuletSize)?str_replace(","," ",trim($CuletSize)):""),

				'24' => (!empty($CuletAngle)?str_replace(","," ",trim($CuletAngle)):""),

				'25' => (!empty($CrownHeight)?str_replace(","," ",trim($CrownHeight)):""),

				'26' => (!empty($CrownHeightPercentage)?str_replace(","," ",trim($CrownHeightPercentage)):""),

				'27' => (!empty($CrownAngle)?str_replace(","," ",trim($CrownAngle)):""),

				'28' => (!empty($PavilionDepth)?str_replace(","," ",trim($PavilionDepth)):""),

				'29' => (!empty($PavilionDepthPercentage)?str_replace(","," ",trim($PavilionDepthPercentage)):""),

				'30' => (!empty($PavilionAngle)?str_replace(","," ",trim($PavilionAngle)):""),

				'31' => (!empty($DepthPercentage)?str_replace(","," ",trim($DepthPercentage)):""),

				'32' => (!empty($LengthToWidthRatio)?str_replace(","," ",trim($LengthToWidthRatio)):""),

				'33' => (!empty($Measurements)?str_replace(","," ",trim($Measurements)):""),

				'34' => (!empty($GirdleToTableDistance)?str_replace(","," ",trim($GirdleToTableDistance)):""),

				'35' => (!empty($StarLength)?str_replace(","," ",trim($StarLength)):""),

				'36' => (!empty($StarLengthPercentage)?str_replace(","," ",trim($StarLengthPercentage)):""),

				'37' => (!empty($GirdleToCuletDistance)?str_replace(","," ",trim($GirdleToCuletDistance)):""),

				'38' => (!empty($LowerHalfLength)?str_replace(","," ",trim($LowerHalfLength)):""),

				'39' => (!empty($LowerHalfLengthPercentage)?str_replace(","," ",trim($LowerHalfLengthPercentage)):""),

				'40' => (!empty($ShippingDays)?str_replace(","," ",trim($ShippingDays)):""),

				'41' => (!empty($WirePrice)?str_replace(","," ",trim($WirePrice)):""),

				'42' => (!empty($EyeClean)?str_replace(","," ",trim($EyeClean)):""),

				'43' => (!empty($LabGrown)?str_replace(","," ",trim($LabGrown)):""),

				'44' => (!empty($Availability)?str_replace(","," ",trim($Availability)):""),

				'45' => (!empty($Country)?str_replace(","," ",trim($Country)):""),

				'46' => (!empty($State)?str_replace(","," ",trim($State)):""),

				'47' => (!empty($City)?str_replace(","," ",trim($City)):""),

			];

		

		fputcsv($fp, $val, ",");

	}

	//endwhile;

	//wp_reset_query();

	//fclose($fp);

	//rewind($fp, 0);

	fseek($fp, 0);



	header('Content-Encoding: UTF-8');

	// tell the browser it's going to be a csv file

	header('Content-Type: application/csv; charset=UTF-8');

	// tell the browser we want to save it instead of displaying it

	$filename='NuminedDiamondInventory-'.$date.'.csv';



	header('Content-Disposition: attachment; filename="'.$filename.'";');

	// make php send the generated csv lines to the browser

	fpassthru($fp);



die();