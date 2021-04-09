<?php 
$jasFolderpath = import_jasM['csv_file_path'];
if(isset($_FILES['JAScsv']['name']) && $_FILES['JAScsv']['name'] != ''){
	$csvname 	=	$_FILES['JAScsv']['name'];
}
else{
	$csvFiles = glob($jasFolderpath . "*.csv", GLOB_NOSORT);
	usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
	$latestCsvFile = $csvFiles[0];
	$csvname = str_replace($jasFolderpath,'',$latestCsvFile);
}
$filters = Filters;
$vendor_code = import_jasM['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
/*print_r($vendor_id);
die;*/
/*$jasID = 3;*/
$allowed 	=	array('csv','CSV');
$extension 	=	pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
	echo 'Please Upload CSV Format.';
}else{
	
	$JAScheckArr=custom_get_vendor_diamonds($vendor_id);
	$upJASArr= [];
	$newJASArr= [];
	
	if(isset($_FILES['JAScsv']['name']) && $_FILES['JAScsv']['name'] != ''){
		$csv_tmpname= $_FILES['JAScsv']['tmp_name'];
		//$csvfile	= KDIPATH.'/assets/csvs/jas/'.$csvname;
		//$csvfile	= WP_CONTENT_DIR.'/diamond_uploads/jas/'.$csvname;
		$csvfile	= $jasFolderpath.$csvname;
		$move_uploaded_file = move_uploaded_file($csv_tmpname, $csvfile);
	}
	else{
		$csvFiles = glob($jasFolderpath . "*.csv", GLOB_NOSORT);
		usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
		$csvfile = $csvFiles[0];
		$csvname = str_replace($jasFolderpath,'',$latestCsvFile);
	}	
	
	if(file_exists($csvfile)) {
		
		$file_handle = fopen("$csvfile","r");
		$i=0;        
        $header = fgetcsv($file_handle);
		while(! feof($file_handle)) {
			$row = fgetcsv($file_handle, 1024);
			$diamond = array_combine($header, $row);
			/*print_r($diamond);
			die;*/
			if(count($diamond)>0){
				
				$RefNo					=	$diamond['VendorStockNumber'];  				    // Lot#
				$shape_cat				=	GetShapeValue($diamond['Shape']);		// Shape
				$Color					=	$diamond['Color'];					// Color
				$Clarity				=	$diamond['Clarity'];					// Clarity
				$SizeCt					=	$diamond['Weight'];					// Weight
				$CertType				=	GetCertTypeValue($diamond['Lab']);	// Lab
				$PropCode				=	GetQualityValue($diamond['CutGrade']);	// Cut Grade
				$PolishName				=	GetQualityValue($diamond['Polish']);	// Polish
				$SymName				=	GetQualityValue($diamond['Symmetry']);	// Symmetry
				$FLName					=	GetFluorescenceValue((!empty($diamond['FluorescenceIntensity'])?ucfirst(strtolower($diamond['FluorescenceIntensity'])):'None')); // Flouressence
				$Style_certificate_num	=	$diamond['Certificate#'];					// CertificateNo
				$Length					=	'';					// Length
				$Width					=	'';					// Width
				$Depth					=	'';					// Depth
				$DepthPer				=	number_format($diamond['Depth%'],1);					// Depth%
				$TablePer				=	number_format($diamond['Table%'],1);					// Table%
				
                if(!empty($diamond['GirdleThin']) && !empty($diamond['GirdleThick'])){
                    $Girdle                 =   $diamond['GirdleThin'].' TO '.$diamond['GirdleThick'];
                }else if(empty($diamond['GirdleThin']) && empty($diamond['GirdleThick'])){
                	$Girdle  = 'None';
                }else{
                	$Girdle  = $diamond['GirdleThin'].$diamond['GirdleThick'];
                }
				$Culet					=	(!empty($diamond['CuletSize'])?ucfirst(strtolower($diamond['CuletSize'])):'None');	// Culet
				//$Location				=	$diamond[19];					// Origin
				$PriceCt				=	$diamond['Price'];					// PricePerCt
				$CertLink				=	$diamond['CertificateImage'];	// Certificate URL
				$VideoPath				=	$diamond['Video URL'];					// Video Link
				$ImagePath				=	$diamond['Diamond Image'];
				// Measurements 
				$Measurements = $diamond['Measurements'];
				if(!empty($Measurements)){
					$MeasurementsArr=explode('x', $Measurements);
			        $Length=$MeasurementsArr[0];
			        $Width = $MeasurementsArr[1];
			        $Depth = $MeasurementsArr[2];
			        $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
			        $LWRatio = GetLWRatio($Length,$Width,$Depth);
				}else{
					$Measurements		=	'';
					$LWRatio = '';
				}
				
				// SKU
				if(!empty($RefNo)){
					$Sku=$RefNo;
				}else{
					$Sku=generateSku(import_jasM['type']);
				}
				//Stock Number
				$stockNumber=generateStockNumber($Style_certificate_num,import_jasM['type']);
				
				// Culet
				$Culet = GetCuletValue($Culet);
				// Price 
				$diamond_price = ($SizeCt)*($PriceCt);
				if($SizeCt < 1){
					$admin_margin = ($diamond_price)*(import_jasM['onect_below_margin_price']/100);
				}
				elseif($SizeCt >= 1){
					$admin_margin = ($diamond_price)*(import_jasM['onect_above_margin_price']/100);
				}
				
				$PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
				$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
				$product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
				$product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
				$description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,import_jasM['type']);
				//if($ImagePath==''){
				$ImagePath = make_diamond_image($VideoPath);
				//}
				$isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$PropCode,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);
	            if(!$isFilterValidate){
	                 $i++;
	                continue;
	            }
				$terms = getTermTaxonomy();
				if(in_array($Style_certificate_num, $JAScheckArr)){
					$upJASArr[]=$Style_certificate_num;
					$getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
					$qgresults=$wpdb->get_results($getpostid);
					$diamond_post_id=$qgresults[0]->posts_id;
					update_posts_table($product_title,$description,$product_name,$diamond_post_id);
					wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
					//stock Number update
					$stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
					$wpdb->query($stockNumberupdate);
					//Custom Table Update
					$JASdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$PropCode."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRatio='".$LWRatio."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', ColorRegularFancy='".$ColorRegularFancy."', Measurements='".$Measurements."', ImageZoomEnabled='".$ImageZoomEnabled."', ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other = '' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
					$wpdb->query($JASdiamondupdate);
					// Postmeta Table 
					seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
            		yoastSeoUpdate($diamond_post_id,$product_title,$description);
				}else{
					$new_diamond_id = insert_posts_table($product_title,$description,$product_name);
					wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
					//Custom Table
					$jasdiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$PropCode."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
					$wpdb->query($jasdiamonds); 
            		
            		$values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
        			$seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues);
					$newJASArr[]=$Style_certificate_num;
				}
			
			}		
			$i++; 
		}
		
		// Price meta
	    insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
	    $values='';$seovalues='';
		// GET Delete Products	
		$totalJASArr=array_merge($upJASArr,$newJASArr);
		$delJASArr=array_diff($JAScheckArr,$totalJASArr);
		deleteDiamondsNotAvailable($delJASArr);
		moveToArchives($jasFolderpath,$csvname);
	}else{		
		//moveToArchives($jasFolderpath,$csvname);
	}
	display_message($startTime,$JAScheckArr,$upJASArr,$newJASArr,$delJASArr);
}
?>