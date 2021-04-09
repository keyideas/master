<?php 
$vendorArr = import_meylorM;
$csvFolderpath = $vendorArr['csv_file_path'];;

$csvFiles = glob($csvFolderpath . "*.csv", GLOB_NOSORT);
usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
$latestCsvFile = $csvFiles[0];
$csvname = str_replace($csvFolderpath,'',$latestCsvFile);

$filters = Filters;
$vendor_code = $vendorArr['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
/*$jasID = 3;*/
$allowed 	=	array('csv','CSV');
$extension 	=	pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
	echo 'Please Upload CSV Format.';
}else{
	
	$vendorCheckArr=custom_get_vendor_diamonds($vendor_id);
	$upVendorArr= [];
	$newVendorArr= [];
	
	$csvFiles = glob($csvFolderpath . "*.csv", GLOB_NOSORT);
	usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
	$csvfile = $csvFiles[0];
	$csvname = str_replace($csvFolderpath,'',$latestCsvFile);
		
	
	if(file_exists($csvfile)) {
		
		$file_handle = fopen("$csvfile","r");
		$i=0;        
        $header = fgetcsv($file_handle);
        foreach ($header as $key => $value) {
        	if($value == 'Stock ID'){
        		$header[$key]='stock_id';
        	}
        }
        $header[0] = 'stock_id';
		while(! feof($file_handle)) {
			$row = fgetcsv($file_handle, 1024);
			$diamond = array_combine($header, $row);
			if(count($diamond)>0){
				
				$RefNo					=	$diamond['stock_id'];  				    // Lot#
				$shape_cat				=	GetShapeValue($diamond['Shape']);		// Shape
				$Color					=	$diamond['Color'];					// Color
				$Clarity				=	$diamond['Clarity'];					// Clarity
				$SizeCt					=	$diamond['Weight'];					// Weight
				$CertType				=	GetCertTypeValue($diamond['Lab']);	// Lab
				$PropCode				=	GetQualityValue($diamond['Cut']);	// Cut Grade
				$PolishName				=	GetQualityValue($diamond['Polish']);	// Polish
				$SymName				=	GetQualityValue($diamond['Symmetry']);	// Symmetry
				$FLName					=	GetFluorescenceValue((!empty($diamond['Fluorescence'])?ucfirst(strtolower($diamond['Fluorescence'])):'None')); // Flouressence
				$Style_certificate_num	=	$diamond['Cert Num'];					// CertificateNo
				$Length					=	$diamond['Measurements1'];					// Length
				$Width					=	$diamond['Measurements2'];					// Width
				$Depth					=	$diamond['Measurements3'];					// Depth
				$DepthPer				=	number_format($diamond['Depth%'],1);					// Depth%
				$TablePer				=	number_format($diamond['Table'],1);					// Table%
				
                
                $Girdle  = !empty($diamond['Girdle Thickness'])?$diamond['Girdle Thickness']:'None';
                
				$Culet					=	'None';	// Culet
				//$Location				=	$diamond[19];					// Origin
				$PriceCt				=	$diamond['Price Per Carat'];					// PricePerCt
				$diamond_price = $diamond['Total Price'];
				$CertLink				=	$diamond['Certificate Link'];	// Certificate URL
							// Video Link
				$ImagePath				=	$diamond['Diamond Image'];
				if($diamond['videourl v360']!=''){
					$VideoPath				=	$diamond['videourl v360'];
				}else{
				$VideoPath				=	$diamond['videourl'];
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
					$Sku=generateSku($vendorArr['type']);
				}
				//Stock Number
				$stockNumber=generateStockNumber($Style_certificate_num,$vendorArr['type']);
				
				// Culet
				$Culet = GetCuletValue($Culet);
				// Price 
				
				if($SizeCt < 1){
					$admin_margin = ($diamond_price)*($vendorArr['onect_below_margin_price']/100);
				}
				elseif($SizeCt >= 1){
					$admin_margin = ($diamond_price)*($vendorArr['onect_above_margin_price']/100);
				}
				
				$PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
				$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
				$product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
				$product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
				$description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,$vendorArr['type']);
				
				$isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$PropCode,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);
	            if(!$isFilterValidate){
	                 $i++;
	                continue;
	            }
				$terms = getTermTaxonomy();
				if(in_array($Style_certificate_num, $vendorCheckArr)){
					$upVendorArr[]=$Style_certificate_num;
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
					$newVendorArr[]=$Style_certificate_num;
				}
			
			}		
			$i++; 
		}
		
		// Price meta
	    insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
	    $values='';$seovalues='';
		// GET Delete Products	
		$totalVendorArr=array_merge($upVendorArr,$newVendorArr);
		$delVendorArr=array_diff($vendorCheckArr,$totalVendorArr);
		deleteDiamondsNotAvailable($delVendorArr);
		moveToArchives($csvFolderpath,$csvname);
	}else{		
		//moveToArchives($csvFolderpath,$csvname);
	}
	display_message($startTime,$vendorCheckArr,$upVendorArr,$newVendorArr,$delVendorArr);
}
?>