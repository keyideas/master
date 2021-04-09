<?php 
$mgdFolderpath = import_meylor['csv_file_path'];
if(isset($_FILES['MGDcsv']['name']) && $_FILES['MGDcsv']['name'] != ''){
	$csvname 	=	$_FILES['MGDcsv']['name'];
}
else{
	$csvFiles = glob($mgdFolderpath . "*.csv", GLOB_NOSORT);
	usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
	$latestCsvFile = $csvFiles[0];
	$csvname = str_replace($mgdFolderpath,'',$latestCsvFile);
}
$vendor_code = import_meylor['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
$allowed 	=	array('csv','CSV');
$extension 	=	pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
	echo 'Please Upload CSV Format.';
}else{

	$MGDcheckArr=custom_get_vendor_diamonds($vendor_id);
	$upMGDArr= [];
	$newMGDArr= [];

	if(isset($_FILES['MGDcsv']['name']) && $_FILES['MGDcsv']['name'] != ''){
		$csv_tmpname= $_FILES['MGDcsv']['tmp_name'];
		$csvfile	= $mgdFolderpath.$csvname;
		$move_uploaded_file = move_uploaded_file($csv_tmpname, $csvfile);
	}
	else{
		$csvFiles = glob($mgdFolderpath . "*.csv", GLOB_NOSORT);
		$csvfile = $csvFiles[0];
		$csvname = str_replace($mgdFolderpath,'',$latestCsvFile);
	}
	if(file_exists($csvfile)) {
		$file_handle = fopen("$csvfile","r");
		$i=0;
		while(! feof($file_handle)) {
			$Columnsdata = fgetcsv($file_handle, 1024);
			if(!empty($Columnsdata)){
				if($i>0 && !empty($Columnsdata[12])) {
					$RefNo					=	$Columnsdata[0];					// Lot#
					$shape_cat				=	GetShapeValue($Columnsdata[1]);		// Shape
					$Color					=	$Columnsdata[2];					// Color
					$Clarity				=	$Columnsdata[3];					// Clarity
					$SizeCt					=	$Columnsdata[5];					// Weight
					$CertType				=	GetCertTypeValue($Columnsdata[6]);	// Lab
					$PropCode				=	GetQualityValue($Columnsdata[7]);	// Cut Grade
					$PolishName				=	GetQualityValue($Columnsdata[8]);	// Polish
					$SymName				=	GetQualityValue($Columnsdata[9]);	// Symmetry
					$FLName					=	GetFluorescenceValue((!empty($Columnsdata[10])?ucfirst(strtolower($Columnsdata[10])):'None')); // Flouressence
					$Style_certificate_num	=	$Columnsdata[12];					// CertificateNo
					$Length					=	$Columnsdata[13];					// Length
					$Width					=	$Columnsdata[14];					// Width
					$Depth					=	$Columnsdata[15];					// Depth
					$DepthPer				=	number_format($Columnsdata[16],1);					// Depth%
					$TablePer				=	number_format($Columnsdata[17],1);					// Table%
					$Girdle					=	(!empty($Columnsdata[18])?ucwords(strtolower($Columnsdata[18])):'None');	// Girdle
					$Culet					=	(!empty($Columnsdata[19])?ucfirst(strtolower($Columnsdata[19])):'None');	// Culet
					$Desc					=	$Columnsdata[20];					// Desc
					$Location				=	$Columnsdata[21];					// Origin
					$PriceCt				=	$Columnsdata[11];					// PricePerCt
					$CertLink				=	addHttps($Columnsdata[23]);			// Certificate URL
					$VideoPath				= 	$Columnsdata[24];					// Video Link
					$ImagePath				=	addHttps($Columnsdata[26]);					// Image
					$Style_certificate_num = checkCertificateNum($Style_certificate_num, $CertType);
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
						$Sku=generateSku(import_meylor['type']);
					}					
					//Stock Number
					$stockNumber=generateStockNumber($Style_certificate_num,import_meylor['type']);
					// Culet
					$Culet = GetCuletValue($Culet);
					// Price 
					$diamond_price = ($SizeCt)*($PriceCt);
					if($SizeCt < 1){
						$admin_margin = ($diamond_price)*(import_meylor['onect_below_margin_price']/100);
					}
					elseif($SizeCt >= 1){
						$admin_margin = ($diamond_price)*(import_meylor['onect_above_margin_price']/100);
					}
					$PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
					$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
					$product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
					$product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
					$description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,import_meylor['type']);					
					//Filter Validation
					$isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$PropCode,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);
			        if(!$isFilterValidate){
			            continue;
			        }
			        $terms = getTermTaxonomy();
					if(in_array($Style_certificate_num, $MGDcheckArr)){
						$upMGDArr[]=$Style_certificate_num;
						$getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
						$qgresults=$wpdb->get_results($getpostid);
						$diamond_post_id=$qgresults[0]->posts_id;
						update_posts_table($product_title,$description,$product_name,$diamond_post_id);
						wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
						//stock Number update
						$stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
						$wpdb->query($stockNumberupdate);
						//Custom Table Update
						$MGDdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$PropCode."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRatio='".$LWRatio."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', ColorRegularFancy='".$ColorRegularFancy."', Measurements='".$Measurements."', ImageZoomEnabled='".$ImageZoomEnabled."', ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other = '' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
						$wpdb->query($MGDdiamondupdate);
        		        seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
		                yoastSeoUpdate($diamond_post_id,$product_title,$description);

					}else{
						$new_diamond_id = insert_posts_table($product_title,$description,$product_name);
						wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
						//Custom Table
						$mgddiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$PropCode."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
						$wpdb->query($mgddiamonds);
						$values =  getmetavalues($new_diamond_id,$ShapeCode,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
						$seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues);

						$newMGDArr[]=$Style_certificate_num;
					}	
				}
			}		
			$i++; 
		}
		// Price meta
		insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
    	$values='';$seovalues='';
		// GET Delete Products
		$totalMGDArr=array_merge($upMGDArr,$newMGDArr);
		$delMGDArr=array_diff($MGDcheckArr,$totalMGDArr);
		deleteDiamondsNotAvailable($delMGDArr);
		moveToArchives($mgdFolderpath,$csvname);
	}
}
display_message($startTime,$MGDcheckArr,$upMGDArr,$newMGDArr,$delMGDArr);
?>