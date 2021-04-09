<?php 
$vendor_code = import_parishi['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
$PDcheckArr=custom_get_vendor_diamonds($vendor_id);
$upQGArr= [];
$newQGArr= [];
$url = "https://parishidiamond.com/aspxpages/StkDwnl.aspx?uname=".import_parishi['Username']."&pwd=".import_parishi['Password']."";
	$xmlobj = simplexml_load_file($url);
	$xmlArr = (array)$xmlobj;
    $diamonds_api =  $xmlArr['ExcelData'];
    $k=1;
    $ignoredOnSize = 0;
    foreach($diamonds_api as $diamonds_feed) {
        if($k < 8000){
            $diamonds_feed = (array)$diamonds_feed;
            $image                  = $diamonds_feed['ImagePath'];
            if(strpos($image,"NoImage.jpg")!==FALSE){
                $image_Link             = $image ;                
            }else{
                $image_Link             = $image;
            }
            $Sku                    = $diamonds_feed['RefNo'];
            $Style_certificate_num  = $diamonds_feed['CertNo'];;
            $ShapeCode=$shape_cat   = GetShapeValue($diamonds_feed['CutName']);
            $Color                  = $diamonds_feed['ColorCode'];
            $Clarity                = $diamonds_feed['ClarityName'];
            $Cut                    = GetQualityValue($diamonds_feed['PropCode']);
            $SizeCt                 = number_format($diamonds_feed['Weight'],2);
            $SizeMM                 = '';
            $CertType               = GetCertTypeValue($diamonds_feed['CertName']);
            $PriceEach              = $diamonds_feed['Rate'];
            $Polish                 = GetQualityValue($diamonds_feed['PolishName']);
            $Symmetry               = GetQualityValue($diamonds_feed['SymName']);
            $DepthPct               = number_format($diamonds_feed['TotDepth'], 1);
            $TablePct               = number_format($diamonds_feed['Table'], 1);
            $Fluorescence           = isset($diamonds_feed['FLName'])?GetFluorescenceValue($diamonds_feed['FLName']):'None';
            $LWRatio                = $diamonds_feed['Ratio'];
            $CertLink               = addhttps(getCertificateUrl($diamonds_feed['CertificatePath'],$CertType,$Style_certificate_num));
            $VideoLink              = $diamonds_feed['VideoPath'];
            $WholesalePrice         = ($diamonds_feed['Weight'])*($diamonds_feed['Rate']);
            //$WholesalePrice       = round($diamonds_feed['RetailPrice']); // temporary fix 
            $DiscountWholesalePrice = '';
            $Measurements           = isset($diamonds_feed['Diameter'])?$diamonds_feed['Diameter']:'';
            $ImageZoomEnabled       = isset($diamonds_feed['ImageZoomEnabled'])?$diamonds_feed['ImageZoomEnabled']:'';
            $ShapeDescription       = '';
            //$Cal_priceCt            = (($WholesalePrice)/($SizeCt));
            $PriceCt                = number_format($PriceEach,2);        // PricePerCt
            // Shape Code

            if(!empty($Measurements))
            {   
                $MeasurementsArr=explode('-', $Measurements);
                $Length=$MeasurementsArr[0];
                $MeasurementsArr1 = explode('*', $MeasurementsArr[1]);
                $Width = $MeasurementsArr1[0];
                $Depth = $MeasurementsArr1[1];
    			$Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
    			$LWRatio = GetLWRatio($Length,$Width,$Depth);
    		}else{
    			$Measurements = '';
				$LWRatio = '';
    		}
            if($Cut=='N/A'){
                $Cut = '';
            }else{
                $Cut = $Cut;
            }
            //Stock Number
            $stockNumber=generateStockNumber($Style_certificate_num,import_parishi['type']);
            // Culet 
            $Culet=GetCuletValue($diamonds_feed['Culet']);
            // Girdle
            $Girdle=(!empty($diamonds_feed['GirdlePer'])?ucwords($diamonds_feed['GirdlePer']):'None');            
            $diamond_price = $WholesalePrice;
            if($SizeCt<1){
                $admin_margin = ($diamond_price)*(import_parishi['onect_below_margin_price']/100);
            }
            if($SizeCt>=1){
                $admin_margin = ($diamond_price)*(import_parishi['onect_above_margin_price']/100);
            }           
            $Cut = changeCutGrade($Cut,$Polish,$Symmetry,$shape_cat,$CertType);
            $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
            $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
            $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
            $description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$ShapeCode,$Style_certificate_num,$CertType,import_parishi['type']);
            //Filter Validation
            $isFilterValidate = filterValidation($CertType,$ShapeCode,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$image_Link,$VideoLink,trim($PriceCt),trim($Style_certificate_num),$Fluorescence,$CertLink,Filters);
            if(!$isFilterValidate){
                $k++;
                continue;
            }
            $terms = getTermTaxonomy();
            if(in_array($Style_certificate_num, $PDcheckArr)){
                $upQGArr[]=$Style_certificate_num;
                $getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
                $qgresults=$wpdb->get_results($getpostid);
                $diamond_post_id=$qgresults[0]->posts_id;
                update_posts_table($product_title,$description,$product_name,$diamond_post_id);
                wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
                //stock Number update
                $stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."'";
                $wpdb->query($stockNumberupdate);
                //Custom Table Update
                $QGdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."',  Style='".$Style_certificate_num."',  Image='".$image_Link."',  ShapeCode='".$shape_cat."',  Color='".$Color."',  Clarity='".$Clarity."',  Cut='".$Cut."',  SizeCt='".$SizeCt."',  SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."',  CertType='".$CertType."',  PctOffRap='".$PctOffRap."',  PriceCt='".$PriceCt."',  PriceEach='".$PriceEach."',  Polish='".$Polish."',  Symmetry='".$Symmetry."',  DepthPct='".$DepthPct."',  TablePct='".$TablePct."',  Fluorescence='".$Fluorescence."',  LWRatio='".$LWRatio."',  CertLink='".$CertLink."',  Girdle='".$Girdle."',  VideoLink='".$VideoLink."',  Culet='".$Culet."',  WholesalePrice='".$WholesalePrice."',  DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."',  ColorRegularFancy='".$ColorRegularFancy."',  Measurements='".$Measurements."',  ImageZoomEnabled='".$ImageZoomEnabled."',  ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other='' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
                $wpdb->query($QGdiamondupdate);
                $sale_price = '';
                //SEO Update
                seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
                yoastSeoUpdate($diamond_post_id,$product_title,$description);
            }else{
                $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
                wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
                // SEO DETAILS 
                $values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
                $seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues); 
                $sqldiamonds2="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id, Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$image_Link."','".$ShapeCode."','".$Color."','".$Clarity."','".$Cut."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$Polish."','".$Symmetry."','".$DepthPct."','".$TablePct."','".$Fluorescence."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoLink."','".$Culet."','".$WholesalePrice."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
                $wpdb->query($sqldiamonds2);
                $newQGArr[]=$Style_certificate_num;
            }
        }
        $k++;
    }
    // Price meta
    insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
    $values='';$seovalues='';
    // GET Delete Products
    $totalQGArr=array_merge($upQGArr,$newQGArr);
    $delQGArr=array_diff($PDcheckArr,$totalQGArr);
    deleteDiamondsNotAvailable($delQGArr);
 ?>