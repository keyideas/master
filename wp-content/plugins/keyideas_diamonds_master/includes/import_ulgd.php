<?php 



/*******currently not in use**********/

$ULGDcheckArr=custom_get_vendor_diamonds(2);
	if($ULGDcheckArr==0){
		$i=1;
		$diamondsFeedsObj=ulgd_api_diamond_feeds();
		foreach($diamondsFeedsObj as $xmldata){
			if($i<5){
    		$xmldataArr 			= 	(array)$xmldata;
			$RefNo					=	$xmldataArr['Lot #'];
			$shape_cat				=	ucwords(strtolower($xmldataArr['Shape']));
			$SizeCt					=	number_format($xmldataArr['Weight'],1);
			$Color					=	$xmldataArr['Color'];
			$Clarity				=	$xmldataArr['Clarity'];
			$PropCode				=	ucwords(strtolower($xmldataArr['Cut Grade']));
			$PolishName				=	ucwords(strtolower($xmldataArr['Polish']));
			$SymName				=	ucwords(strtolower($xmldataArr['Symmetry']));
			$FLName					=	ucwords(strtolower($xmldataArr['Fluor']));
			//$Measurements			=	$xmldataArr['Measurement'];
			$CertType				=	ucwords(strtolower($xmldataArr['Lab']));
			$Style_certificate_num	=	$xmldataArr['Certificate #'];
			$PriceCt				=	$xmldataArr['Price/Ct'];
			$DepthPer				=	round($xmldataArr['Depth %']);
			$TablePer				=	round($xmldataArr['Table %']);
			$Girdle					=	$xmldataArr['Girdle'];
			$Culet					=	$xmldataArr['Culet'];
			$Comments				=	$xmldataArr['Description/Comments'];
			$Location				=	$xmldataArr['Origin'];
			$ImagePath				=	$xmldataArr['ImageLink'];
			$VideoPath				=	$xmldataArr['Video Link'];
			$CertLink				=	$xmldataArr['Certificate Image'];
			$Length					=	$xmldataArr['Length'];
			$Width					=	$xmldataArr['Width'];
			$Depth					=	$xmldataArr['Depth'];
			// Measurements 



			if(!empty($Length) && !empty($Width) && !empty($Depth)){



				$Measurements 		=  	$Length.'*'.$Width.'*'.$Depth;



			}else{



				$Measurements		=	'';



			}
						// Culet P=Pointed, N- None, M- Medium, VS- Very small, S- small, L- Large



			if($Culet=='P'){$Culet='Pointed';}



			elseif($Culet=='N'){$Culet='None';}



			elseif($Culet=='M'){$Culet='Medium';}



			elseif($Culet=='VS'){$Culet='Very small';}



			elseif($Culet=='S'){$Culet='small';}



			elseif($Culet=='L'){$Culet='Large';}



			else{ucwords(strtolower($Culet));}
						// Price 



			$diamond_price = ($SizeCt)*($PriceCt);



			if($SizeCt<'1.0'){



				$admin_margin = ($diamond_price)*($ULGD_onect_below_price/100);



			}



			if($SizeCt>='1.0'){



				$admin_margin = ($diamond_price)*($ULGD_onect_above_price/100);



			}
						$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);



			$product_title=str_replace($Style_certificate_num, '', $product_title_raw);



			$product_name=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);



			$description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);



			 $proinsert="INSERT INTO ".$wpdb->prefix."posts(post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$description."','".$product_title."','".$description."','publish','open','closed','','".sanitize_title($product_name)."','','','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','','0','','0','product','','0')";



			



			$wpdb->query($proinsert);



			$new_diamond_id = $wpdb->insert_id;



			$newULGDArr[]=$new_diamond_id;
						//Custom Table



			$sqldiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRation, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$RefNo."','".$Style_certificate_num."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$PropCode."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRation."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','','".$Measurements."','','".$Comments."','".$ULGDArr['id']."', 1, '')";



			//echo '<br/>';



			$wpdb->query($sqldiamonds);
						
						if($shape_cat=='ROUND' || $shape_cat == "RD"){



				$sale_price = round($diamond_price + $admin_margin);



				$discountArr 			= 	range(5, 25);



				shuffle($discountArr);



				$getdiscount			=	$discountArr[0];



				$sale_discount 			= 	($sale_price)*($getdiscount/100);



				$regular_price 			= 	round($sale_price + $sale_discount);
								// Postmeta Table 



				$post_id   		= $new_diamond_id; 



				$meta_key1  	= '_regular_price'; 



				$meta_value1	= $regular_price; 



				$values .= "('$post_id', '$meta_key1', '$meta_value1'),";
								$meta_key2  	= '_sale_price'; 



				$meta_value2	= $sale_price; 



				$values .= "('$post_id', '$meta_key2', '$meta_value2'),";
								$meta_key3  	= '_price'; 



				$meta_value3	= $sale_price; 



				$values .= "('$post_id', '$meta_key3', '$meta_value3'),";
							}else{



				$regular_price = round($diamond_price + $admin_margin);



				$post_id   		= $new_diamond_id; 



				$meta_key1  	= '_regular_price'; 



				$meta_value1	= $regular_price; 



				$values .= "('$post_id', '$meta_key1', '$meta_value1'),";
								$meta_key3  	= '_price'; 



				$meta_value3	= $regular_price; 



				$values .= "('$post_id', '$meta_key3', '$meta_value3'),";



			}
						// SEO DETAILS



			$seo_post_id   		= $new_diamond_id; 



			$meta_key_title  	= '_yoast_wpseo_title'; 



			$meta_value_title	= $product_title; 



			$seovalues 			.= "('$seo_post_id', '$meta_key_title', '$meta_value_title'),";







			$meta_key_desc  	= '_yoast_wpseo_metadesc'; 



			$meta_value_desc	= $product_title; 



			$seovalues 			.= "('$seo_post_id', '$meta_key_desc', '$meta_value_desc'),";







			$meta_key_fkw  		= '_yoast_wpseo_focuskw'; 



			$meta_value_fkw		= $product_title; 



			$seovalues 			.= "('$seo_post_id', '$meta_key_fkw', '$meta_value_fkw'),";







			}



			$i++;



		}







		// Price meta



		$values = substr($values, 0, strlen($values) - 1);



		$insert_query = $metaquery . $values;



  		$wpdb->query($insert_query);



  		$values='';







  		$seovalues = substr($seovalues, 0, strlen($seovalues) - 1);



		$insert_meta_query = $seometaquery . $seovalues;



  		$wpdb->query($insert_meta_query);



  		$seovalues='';







	}else{



		$diamondsFeedsObj=ulgd_api_diamond_feeds();



		foreach($diamondsFeedsObj as $xmldata){



    		$xmldataArr = (array)$xmldata;



			$RefNo					=	$xmldataArr['Lot #'];



			$shape_cat				=	ucwords(strtolower($xmldataArr['Shape']));



			$SizeCt					=	number_format($xmldataArr['Weight'],1);



			$Color					=	$xmldataArr['Color'];



			$Clarity				=	$xmldataArr['Clarity'];



			$PropCode				=	ucwords(strtolower($xmldataArr['Cut Grade']));



			$PolishName				=	ucwords(strtolower($xmldataArr['Polish']));



			$SymName				=	ucwords(strtolower($xmldataArr['Symmetry']));



			$FLName					=	ucwords(strtolower($xmldataArr['Fluor']));



			$Measurements			=	$xmldataArr['Measurement'];



			$CertType				=	ucwords(strtolower($xmldataArr['Lab']));



			$Style_certificate_num	=	$xmldataArr['Certificate #'];



			$PriceCt				=	$xmldataArr['Price/Ct'];



			$DepthPer				=	$xmldataArr['Depth %'];



			$TablePer				=	$xmldataArr['Table %'];



			$Girdle					=	$xmldataArr['Girdle'];



			$Culet					=	ucwords(strtolower($xmldataArr['Culet']));



			$Comments				=	$xmldataArr['Description/Comments'];



			$Location				=	$xmldataArr['Origin'];



			$ImagePath				=	$xmldataArr['ImageLink'];



			$VideoPath				=	$xmldataArr['Video Link'];



			$CertLink				=	$xmldataArr['Certificate Image'];



			$Length					=	$xmldataArr['Length'];



			$Width					=	$xmldataArr['Width'];



			$Depth					=	$xmldataArr['Depth'];







			// Measurements 



			if(!empty($Length) && !empty($Width) && !empty($Depth)){



				$Measurements 		=  	$Length.'*'.$Width.'*'.$Depth;



			}else{



				$Measurements		=	'';



			}







			// Culet P=Pointed, N- None, M- Medium, VS- Very small, S- small, L- Large



			/*if($Culet=='P'){$Culet='Pointed';}



			elseif($Culet=='N'){$Culet='None';}



			elseif($Culet=='M'){$Culet='Medium';}



			elseif($Culet=='VS'){$Culet='Very small';}



			elseif($Culet=='S'){$Culet='small';}



			elseif($Culet=='L'){$Culet='Large';}



			else{ucwords(strtolower($Culet);})*/







			// Price 



			$diamond_price = ($SizeCt)*($PriceCt);



			if($SizeCt<1){



				$admin_margin = ($diamond_price)*($ULGD_onect_below_price/100);



			}



			if($SizeCt>=1){



				$admin_margin = ($diamond_price)*($ULGD_onect_above_price/100);



			}







			$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);



			$product_title=str_replace($Style_certificate_num, '', $product_title_raw);



			$product_name=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);



			$description=make_diamond_description($SizeCt, $Color, $Clarity, $PropCode, $shape_cat, $Style_certificate_num);







			if(in_array($Style_certificate_num, $ULGDcheckArr)){



				$upULGDArr[]=$Style_certificate_num;



				$ULGDpostsupdate="UPDATE ".$wpdb->prefix."posts SET post_author='1', post_content='".$description."', post_title='".$product_title."', post_excerpt='".$description."', post_name='".sanitize_title($product_name)."', post_modified='".date("Y-m-d H:i:s")."', post_modified_gmt='".date("Y-m-d H:i:s")."', guid='', post_type='product' WHERE post_title='".$product_title."'";



				$wpdb->query($ULGDpostsupdate);







				//Custom Table Update



				$ULGDdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$RefNo."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$PropCode."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRation='".$LWRation."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', Measurements='".$Measurements."', ShapeDescription='".$Comments."', vendor='".$ULGDArr['id']."', status='1', other = '' WHERE Style='".$Style_certificate_num."'";



				//echo '<br/>';



				$wpdb->query($ULGDdiamondupdate);







			}else{



				$proinsert="INSERT INTO ".$wpdb->prefix."posts(post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$description."','".$product_title."','".$description."','publish','open','closed','','".sanitize_title($product_name)."','','','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','','0','','0','product','','0')";



				//echo '<br/>';



				$wpdb->query($proinsert);



				$new_diamond_id = $wpdb->insert_id;







				//Custom Table



				$sqldiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRation, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$RefNo."','".$Style_certificate_num."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$shape_cat."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRation."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$WholesalePrice."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$ULGDArr['id']."', '1', '')";



				$wpdb->query($sqldiamonds);







				if($shape_cat=="ROUND" || $shape_cat=="Round"){



					$sale_price = round($diamond_price + $admin_margin);



					$discountArr 			= 	range(5, 25);



					shuffle($discountArr);



					$getdiscount			=	$discountArr[0];



					$sale_discount 			= 	($sale_price)*($getdiscount/100);



					$regular_price 			= 	round($sale_price + $sale_discount);







					// Postmeta Table 



					$post_id   		= $new_diamond_id; 



					$meta_key1  	= '_regular_price'; 



					$meta_value1	= $regular_price; 



					$values .= "('$post_id', '$meta_key1', '$meta_value1'),";







					$meta_key2  	= '_sale_price'; 



					$meta_value2	= $sale_price; 



					$values .= "('$post_id', '$meta_key2', '$meta_value2'),";







					$meta_key3  	= '_price'; 



					$meta_value3	= $sale_price; 



					$values .= "('$post_id', '$meta_key3', '$meta_value3'),";



				



				}else{



					$regular_price = round($diamond_price + $admin_margin);



					$post_id   		= $new_diamond_id; 



					$meta_key1  	= '_regular_price'; 



					$meta_value1	= $regular_price; 



					$values .= "('$post_id', '$meta_key1', '$meta_value1'),";







					$meta_key3  	= '_price'; 



					$meta_value3	= $regular_price; 



					$values .= "('$post_id', '$meta_key3', '$meta_value3'),";



				}







				// SEO DETAILS



				$seo_post_id   		= $new_diamond_id; 



				$meta_key_title  	= '_yoast_wpseo_title'; 



				$meta_value_title	= $product_title; 



				$seovalues 			.= "('$seo_post_id', '$meta_key_title', '$meta_value_title'),";







				$meta_key_desc  	= '_yoast_wpseo_metadesc'; 



				$meta_value_desc	= $product_title; 



				$seovalues 			.= "('$seo_post_id', '$meta_key_desc', '$meta_value_desc'),";







				$meta_key_fkw  		= '_yoast_wpseo_focuskw'; 



				$meta_value_fkw		= $product_title; 



				$seovalues 			.= "('$seo_post_id', '$meta_key_fkw', '$meta_value_fkw'),";







				$newULGDArr[]=$Style_certificate_num;



			}



		}







		// Price meta



		$values = substr($values, 0, strlen($values) - 1);



		$insert_query = $metaquery . $values;



  		$wpdb->query($insert_query);



  		$values='';







  		$seovalues = substr($seovalues, 0, strlen($seovalues) - 1);



		$insert_meta_query = $seometaquery . $seovalues;



  		$wpdb->query($insert_meta_query);



  		$seovalues='';







		// GET Delete Products



		$totalULGDArr=array_merge($upULGDArr,$newULGDArr);



		$delULGDArr=array_diff($ULGDcheckArr,$totalULGDArr);



		//$delULGDArr=array_merge(array_diff($totalULGDArr, $ULGDcheckArr), array_diff($ULGDcheckArr, $totalULGDArr));



		foreach ($delULGDArr as $key => $delULGD) {



			$wpdb->query("UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET status='2' WHERE Style='".$delULGD."'");



		}



	}



?>