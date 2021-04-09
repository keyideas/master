<?php 
$nuFolderpath = import_numined['csv_file_path'];
if(isset($_FILES['NUcsv']['name']) && $_FILES['NUcsv']['name'] != ''){
	$csvname 	=	$_FILES['NUcsv']['name'];
}
else{
	$csvFiles = glob($nuFolderpath . "*.csv", GLOB_NOSORT);
	usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
	$latestCsvFile = $csvFiles[0];
	$csvname = str_replace($nuFolderpath,'',$latestCsvFile);
}
$vendor_code = import_numined['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
$allowed 	=	array('csv','CSV');
$extension 	=	pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
	echo 'Please Upload CSV Format.';
}else{
	$NUcheckArr=custom_get_vendor_diamonds($vendor_id);
	$upNUArr= [];
	$newNUArr= [];

	if(isset($_FILES['NUcsv']['name']) && $_FILES['NUcsv']['name'] != ''){
		$csv_tmpname= $_FILES['NUcsv']['tmp_name'];
		$csvfile	= $nuFolderpath.$csvname;
		$move_uploaded_file = move_uploaded_file($csv_tmpname, $csvfile);
	}
	else{
		$csvFiles = glob($nuFolderpath . "*.csv", GLOB_NOSORT);
		$csvfile = $csvFiles[0];
		$csvname = str_replace($nuFolderpath,'',$latestCsvFile);
	}
	if(file_exists($csvfile)) {
		$file_handle = fopen("$csvfile","r");
		$i=0;
		$header = fgetcsv($file_handle);
		while(! feof($file_handle)) {
			$row = fgetcsv($file_handle, 1024);
			$diamond = array_combine($header, $row);
			if(count($diamond)>0){
				$RefNo					=	$diamond['Lot#'];					// Lot#
				$shape_cat				=	GetShapeValue($diamond['Shape']);					// Shape
				$Color					=	$diamond['Color'];					// Color
				$Clarity				=	$diamond['Clarity'];					// Clarity
				$SizeCt					=	$diamond['Weight'];	// Weight
				$CertType				=	GetCertTypeValue($diamond['Lab']);					// Lab
				$Cut				=	GetQualityValue($diamond['Cut Grade']);					// Cut Grade
				$PolishName				=	GetQualityValue($diamond['Polish']);					// Polish
				$SymName				=	GetQualityValue($diamond['Symmetry']);					// Symmetry
				$FLName					=	GetFluorescenceValue((!empty($diamond['Flouressence'])?ucfirst(strtolower($diamond['Flouressence'])):'None')); // Flouressence
				$Style_certificate_num	=	$diamond['CertificateNo'];					// CertificateNo
				$Length					=	$diamond['Length'];					// Length
				$Width					=	$diamond['Width'];					// Width
				$Depth					=	$diamond['Depth'];					// Depth
				$DepthPer				=	number_format($diamond['Depth%'],1);			// Depth%
				$TablePer				=	number_format($diamond['Table%'],1);			// Table%
				$Girdle					=	(!empty($diamond['Girdle'])?ucwords(strtolower($diamond['Girdle'])):'None');	// Girdle
				$Culet					=	(!empty($diamond['Culet'])?ucfirst(strtolower($diamond['Culet'])):'None');	// Culet
				$Desc					=	$diamond['Desc'];					// Desc
				$Location				=	$diamond['Origin'];					// Origin
				$PriceCt				=	$diamond['PricePerCt'];				// PricePerCt
				$PriceCode				=	$diamond['PriceCode'];					// PriceCode
				$CertLink				=	addHttps(getCertificateUrl($diamond['Certificate URL'],$CertType,$Style_certificate_num));	// Certificate URL
				$VideoPath				=	addHttps(checkUrlValidation($diamond['Video Link']));					// Video Link
				$ImagePath				=	checkUrlValidation($diamond['ImageLink']);					// ImageLink
				$Style_certificate_num = checkCertificateNum($Style_certificate_num, $CertType);
				if($ImagePath==''){
					if(strpos($VideoPath,"v360.in/SCAASI/vision360.html")!==FALSE){
						$url_components = parse_url($VideoPath);   
                        parse_str($url_components['query'], $params); 
                            $param = $params['d'];
						$ImagePath="https://s4.v360.in/images/company/349/imaged/$param/still.jpg";
					}else if(strpos($VideoPath,"v360.in/viewer4.0/vision360.htm")!==FALSE){
						$url_components = parse_url($VideoPath);   
                        parse_str($url_components['query'], $params); 
                            $param = $params['d'];
						$ImagePath="https://s6.v360.in/images/company/1373/imaged/$param/still.jpg";
					}
				}
				
									// Measurements 
				if(!empty($Length) && !empty($Width) && !empty($Depth)){
					$Measurements 		=  	$Length.'*'.$Width.'*'.$Depth;
					$LWRatio = GetLWRatio($Length,$Width,$Depth);
				}else{
					$Measurements		=	'';
					$LWRatio = '';
				}
									// SKU
				if(!empty($RefNo)){
					$Sku=$RefNo;
				}else{
					$Sku=generateSku(import_numined['type']);
				}

				//Stock Number
				$stockNumber=generateStockNumber($Style_certificate_num,import_numined['type']);

				// Culet
				$Culet = GetCuletValue($Culet);
									// Price 
				$diamond_price = ($SizeCt)*($PriceCt);
				if($SizeCt<1){
					$admin_margin = ($diamond_price)*(import_numined['onect_below_margin_price']/100);
				}
				if($SizeCt>=1){
					$admin_margin = ($diamond_price)*(import_numined['onect_above_margin_price']/100);
				}
				$Cut = changeCutGrade($Cut,$PolishName,$SymName,$shape_cat,$CertType);
				//echo 'Cut:'.$Cut.' '.$Style_certificate_num;
				$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
				$product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
				$product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
				$description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num,$CertType,import_numined['type']);
				/*$isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$Cut,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,$PriceCt,$Style_certificate_num,$FLName,$filters);
	            if(!$isFilterValidate){
	            	echo $Style_certificate_num.' ';
	                continue;
	            }*/
	            $terms = getTermTaxonomy();
				if(in_array($Style_certificate_num, $NUcheckArr)){
					$upNUArr[]=$Style_certificate_num;
					$getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
					$qgresults=$wpdb->get_results($getpostid);
					$diamond_post_id=$qgresults[0]->posts_id;
					update_posts_table($product_title,$description,$product_name,$diamond_post_id);
					wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
					//stock Number update
					$stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
					$wpdb->query($stockNumberupdate);
					//Custom Table Update
					$NUdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$Cut."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRatio='".$LWRatio."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', ColorRegularFancy='".$ColorRegularFancy."', Measurements='".$Measurements."', ImageZoomEnabled='".$ImageZoomEnabled."', ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other = '' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
					$wpdb->query($NUdiamondupdate);
    		        seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
	                yoastSeoUpdate($diamond_post_id,$product_title,$description);
				}else{
					$new_diamond_id = insert_posts_table($product_title,$description,$product_name);
					wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
					//Custom Table
					$nudiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$Cut."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
					$wpdb->query($nudiamonds);
					$values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
					$seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues);
					$newNUArr[]=$Style_certificate_num;
				}	
				
			}		
			$i++; 
		} 
		// Price meta
    	insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
    	$values='';$seovalues='';
		// GET Delete Products
		$totalNUArr=array_merge($upNUArr,$newNUArr);
		$delNUArr=array_diff($NUcheckArr,$totalNUArr);
		//updateDiamondStatus($delNUArr,'0');
		deleteDiamondsNotAvailable($delNUArr);
		moveToArchives($nuFolderpath,$csvname);
	}
	display_message($startTime,$NUcheckArr,$upNUArr,$newNUArr,$delNUArr);
}
?>