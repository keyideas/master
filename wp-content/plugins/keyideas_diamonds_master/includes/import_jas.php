<?php 
$jasFolderpath = import_jas['csv_file_path'];;
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
$vendor_code = import_jas['vendor_code'];
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
		$csvfile = $csvFiles[0];
		$csvname = str_replace($jasFolderpath,'',$latestCsvFile);
	}	
		$csvKeyArray = [];
		$csvKeyArray[0] = ["Stock#","Lot#"];
		$csvKeyArray[1] = ["Shape"];
		$csvKeyArray[2] = ["Color"];
		$csvKeyArray[3] = ["Clarity"];
		$csvKeyArray[4] = ["Weight"];
		$csvKeyArray[5] = ["Lab"];
		$csvKeyArray[6] = ["Cut","Cut Grade"];
		$csvKeyArray[7] = ["Polish"];
		$csvKeyArray[8] = ["Symmetry"];
		$csvKeyArray[9] = ["Fluor","Flouressence","fluorescent","Fluorescence"];
		$csvKeyArray[10] = ["Cert#","CertificateNo"];
		$csvKeyArray[11] = ["L-mm","Length"];
		$csvKeyArray[12] = ["W-mm","Width"];
		$csvKeyArray[13] = ["D-mm","Depth"];
		$csvKeyArray[14] = ["Depth%"];
		$csvKeyArray[15] = ["Table%"];
		$csvKeyArray[16] = ["Girdle"];
		$csvKeyArray[17] = ["Culet"];
		$csvKeyArray[18] = ["Remarks","Desc"];
		$csvKeyArray[19] = ["County of Orig","Origin"];
		$csvKeyArray[20] = ["Price","PricePerCt"];
		$csvKeyArray[21] = ["Certificate URL","Cert file"];
		$csvKeyArray[22] = ["Video URL","Video Link"];
		$data_array = readCSV($csvfile);
		$validKey = FALSE;
		if(count($data_array) > 0) {		
			foreach ($data_array[0] as $key => $value) {
				if($key > 22){
					continue;
				}else{
					if(in_array(trim($value), $csvKeyArray[$key], TRUE)){					
						$validKey = TRUE;
					}else{
						$failure_key= $key;
						$failure_value= $value;
						$validKey = FALSE;
						break;
					}			}		} 	}
	
	if((file_exists($csvfile)) && ($validKey != FALSE)) {
		$file_handle = fopen("$csvfile","r");
		$i=0;
		while(! feof($file_handle)) {
			$Columnsdata = fgetcsv($file_handle, 1024);
			if(!empty($Columnsdata)){
				if($i>0 && !empty($Columnsdata[10])) {
					$RefNo					=	$Columnsdata[0];  				    // Lot#
					$shape_cat				=	GetShapeValue($Columnsdata[1]);		// Shape
					$Color					=	$Columnsdata[2];					// Color
					$Clarity				=	$Columnsdata[3];					// Clarity
					$SizeCt					=	$Columnsdata[4];					// Weight
					$CertType				=	GetCertTypeValue($Columnsdata[5]);	// Lab
					$PropCode				=	GetQualityValue($Columnsdata[6]);	// Cut Grade
					$PolishName				=	GetQualityValue($Columnsdata[7]);	// Polish
					$SymName				=	GetQualityValue($Columnsdata[8]);	// Symmetry
					$FLName					=	GetFluorescenceValue((!empty($Columnsdata[9])?ucfirst(strtolower($Columnsdata[9])):'None')); // Flouressence
					$Style_certificate_num	=	$Columnsdata[10];					// CertificateNo
					$Length					=	$Columnsdata[11];					// Length
					$Width					=	$Columnsdata[12];					// Width
					$Depth					=	$Columnsdata[13];					// Depth
					$DepthPer				=	number_format($Columnsdata[14],1);					// Depth%
					$TablePer				=	number_format($Columnsdata[15],1);					// Table%
					$Girdle					=	(!empty($Columnsdata[16])?ucwords(strtolower($Columnsdata[16])):'None');	// Girdle
					$Culet					=	(!empty($Columnsdata[17])?ucfirst(strtolower($Columnsdata[17])):'None');	// Culet
					$Desc					=	$Columnsdata[18];					// Desc
					$Location				=	$Columnsdata[19];					// Origin
					$PriceCt				=	$Columnsdata[20];					// PricePerCt
					$CertLink				=	addHttps(getCertificateUrl($Columnsdata[21],$CertType,$Style_certificate_num));	// Certificate URL
					$getvideoLink			= 	defaultVideoFormat($Columnsdata[22]);
					$VideoPath				=	$getvideoLink['videoUrl'];					// Video Link
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
						$Sku=generateSku(import_jas['type']);
					}
					//Stock Number
					$stockNumber=generateStockNumber($Style_certificate_num,import_jas['type']);
					
					// Culet
					$Culet = GetCuletValue($Culet);
					// Price 
					$diamond_price = ($SizeCt)*($PriceCt);
					if($SizeCt < 1){
						$admin_margin = ($diamond_price)*(import_jas['onect_below_margin_price']/100);
					}
					elseif($SizeCt >= 1){
						$admin_margin = ($diamond_price)*(import_jas['onect_above_margin_price']/100);
					}
					
					$PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
					$product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
					$product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
					$product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
					$description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,import_greenrock['type']);
					$ImagePath = make_diamond_image($VideoPath);
					
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
		moveToArchives($jasFolderpath,$csvname);
	}
	display_message($startTime,$JAScheckArr,$upJASArr,$newJASArr,$delJASArr);
}
?>