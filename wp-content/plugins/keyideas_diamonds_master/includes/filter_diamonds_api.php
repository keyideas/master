<?php 
if ( ! function_exists( 'getDiamondDetailsByPostID' ) ) {
	function getDiamondDetailsByPostID($data)
	{
		//echo ($data['id']);
		$postId=$data['id'];
		global $wpdb;
		$query=$wpdb->get_row("SELECT T1.id, T1.posts_id, T1.Sku, T1.Style, T1.stockNumber, T1.Image, T1.ShapeCode, T1.Color, T1.Clarity, T1.Cut, T1.SizeCt, T1.SizeMM, T1.SizeMMChar, T1.CertType, T1.PctOffRap, T1.PriceCt, T1.PriceEach, T1.Polish, T1.Symmetry, T1.DepthPct, T1.TablePct, T1.Fluorescence, T1.LWRatio, T1.CertLink, T1.Girdle, T1.VideoLink, T1.Culet, T1.WholesalePrice, T1.DiscountWholesalePrice, T1.RetailPrice, T1.ColorRegularFancy, IF(T1.Measurements IS NULL or T1.Measurements = '', '-', T1.Measurements) as Measurements, T1.ImageZoomEnabled, T1.ShapeDescription, T1.vendor, T1.status, T1.other,  (SELECT T2.meta_value FROM ".$wpdb->prefix."postmeta T2 WHERE T2.post_id=T1.posts_id AND T2.meta_key='_sale_price') as salePrice,(SELECT  T3.meta_value FROM ".$wpdb->prefix."postmeta T3 WHERE T3.post_id=T1.posts_id AND T3.meta_key='_regular_price') as regularPrice,(SELECT  T6.meta_value FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as price, T4.name, T4.vendor_code, T4.abbreviation, T4.shipdays, T5.post_date, T5.post_content, T5.post_title, T5.post_excerpt, T5.post_status, T5.comment_status, T5.ping_status, T5.post_name, T5.guid, T5.post_type, T5.post_mime_type FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.posts_id='$postId' AND T1.status!='0' AND T1.status!='2'");
		return rest_ensure_response( $query, ARRAY_A );
	}
}
if ( ! function_exists( 'popularsearch' ) ) {
	function popularsearch($search)
	{
		$where = '';
		$pricedata = '';
		$search = str_replace("','",",",$search);
		$rawData = explode(',',$search);
		foreach($rawData as $value){
			$data = explode('_',$value);
			switch (strtoupper($data[1])) {
				case 'PRICE':
					$pricedata .= " HAVING price <= ".$data[0];
					break;
                case 'CTSIZE':
					$where .= " AND T1.SizeCt <= ".$data[0];
					break;
				case 'COLORCLARITY':
					$colorclarity = explode('-',$data[0]);
					$colorName = $colorclarity[0];
					$clarityName = $colorclarity[1];
					$where .= " AND T1.Color IN ('$colorName')";
					$where .= " AND T1.Clarity IN ('$clarityName')";
					break;
			}
		}
		return $where.$pricedata;
	}
}
if ( ! function_exists( 'getDiamondsListingBycondition' ) ) {
	function getDiamondsListingBycondition()
	{	
		$result = [];
		$where = '';
		$order = 0;
		$orderBy = '';
		$pricedata = '';
		$per_page_count = filterApi['per_page_count'];
		$limit = 'LIMIT 0, '.$per_page_count.'';
		$type = array('LG','M');
		$price_order = 0;
		//$orderBy = 'ORDER BY T1.id DESC';

		foreach($_REQUEST as $key=>$value){
			$searchValue = $value;
			$value = str_replace(",","','",$value);
			if(trim($value) == '')
				continue;
			switch (strtoupper($key)) {
				case 'VENDOR':
					$where .= " AND T1.vendor IN ('$value')";
					break;
                case 'COLOR':
                case 'COLOR_MAX_COL':
					$where .= " AND T1.Color IN ('$value')";
					break;
				case 'POLISH':
					$where .= " AND T1.Polish IN ('$value')";
					break;
				case 'CUT':
				case 'CUT_MAX_CT':
					$where .= " AND T1.Cut IN ('$value')";
					break;
				case 'SHAPE':
				case 'SHAPE_NAME':
					$where .= " AND T1.ShapeCode IN ('$value')";
					break;
				case 'COMPARE':
					$where .= " AND T1.posts_id IN ('$value')";
					break;
				case 'LAB':
					$where .= " AND T1.CertType IN ('$value')";
					break;
				case 'SYMMETRY':
					$where .= " AND T1.Symmetry IN ('$value')";
					break;
				case 'CLARITY':
				case 'CLARITY_MAX_CAL':
					$where .= " AND T1.Clarity IN ('$value')";
					break;
				case 'FLUORESCENCE':
					$where .= " AND T1.Fluorescence IN ('$value')";
					break;					
				case '360VIEW':
					if($value == 1)
						$where .= " AND T1.VideoLink !='' ";
					break;
				case 'POPULARSEARCH':
					$where .= popularsearch($value);
					break;
				case 'PAGE':
					$page = is_numeric($value)? ($value-1)*$per_page_count : 0 ;
					$limit = " LIMIT $page, $per_page_count";
					break;
				case 'ORDERBYPRICE':
					$value = strtoupper($value);
					$orderBy .= (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY CAST(price AS DECIMAL(10,2)) $value" : "";
					$price_order = 1;
					$order = 1;
					break;
				case 'ORDERBYCARAT':
					$value = strtoupper($value);
					$orderBy .= (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T1.SizeCt $value" : "";
					$order = 1;
					break;
				case 'ORDERBYCOLOR':
					
					$value = strtoupper($value);
					$arr = Filters['colors'];
					if($value=='DESC'){
						$arr = array_reverse($arr);						
					}
					$arr = join("','",$arr);
					$arr = "'".$arr."'";
					$orderBy .= " ORDER BY field(T1.Color, $arr)";
					$order = 1;
					break;
				case 'ORDERBYCUT':
					$value = strtoupper($value);
					$arr = Filters['cut'];
					if($value=='DESC'){
						$arr = array_reverse($arr);						
					}
					$arr = join("','",$arr);
					$arr = "'".$arr."'";
					$orderBy .= " ORDER BY field(Cut, $arr)";
					$order = 1;
					break;
				case 'ORDERBYCLARITY':
					$value = strtoupper($value);
					$arr = Filters['clarity'];
					if($value=='DESC'){
						$arr = array_reverse($arr);						
					}
					$arr = join("','",$arr);
					$arr = "'".$arr."'";
					$orderBy .= " ORDER BY field(Clarity, $arr)";
					$order = 1;
					break;
				case 'QUICKSHIP':
					$value = strtoupper($value);
					$orderBy .= (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T4.shipdays $value" : " ORDER BY T4.shipdays ASC";
					$order = 1;
					break;
				case 'MINLWRATIO':
					$where .= " AND T1.LWRatio >= ".$value;
					break;
				case 'MAXLWRATIO':
					$where .= " AND T1.LWRatio <= ".$value;
					break;
				case 'MINDEPTH':
					$where .= " AND T1.DepthPct >= ".$value;
					break;
				case 'MAXDEPTH':
					$where .= " AND T1.DepthPct <= ".$value;
					break;
				case 'MINTABLE':
					$where .= " AND T1.TablePct >= ".$value;
					break;
				case 'MAXTABLE':
					$where .= " AND T1.TablePct <= ".$value;
					break;
				case 'MINCARAT':
				case 'CARAT_MIN':
					$where .= " AND T1.SizeCt >= ".$value;
					break;
				case 'MAXCARAT':
				case 'CARAT_MAX':
					$where .= " AND T1.SizeCt <= ".$value;
					break;
				case 'TYPE':					
					if(str_replace(' ', '', strtoupper($value)) == 'LG'){
						unset($type[array_search('M',$type)]);
					}else if(strtoupper($value) == 'M'){
						unset($type[array_search('LG',$type)]);
					}					
					break;
				case 'MINPRICE':
				case 'PRICE_MIN':
					if(strpos($pricedata, "HAVING") !== FALSE)
						$pricedata .= " AND price >= ".$value;
					else
						$pricedata .= " HAVING price >= ".$value;
					break;
				case 'MAXPRICE':
				case 'PRICE_MAX':
					if(strpos($pricedata, "HAVING") !== FALSE)
						$pricedata .= " AND price <= ".$value;
					else
						$pricedata .= " HAVING price <= ".$value;
					break;
			}
		}
		if($order != 1){
			$orderBy .= " ORDER BY CAST(price AS DECIMAL(10,2)) ASC";
		}
		global $wpdb;
		
		
		$type = join("','",$type);
		/* $query1=$wpdb->get_row("SELECT count(T1.id) as total_items, (SELECT T2.meta_value FROM ".$wpdb->prefix."postmeta T2 WHERE T2.post_id=T1.posts_id AND T2.meta_key='_sale_price') as salePrice,(SELECT  T3.meta_value FROM ".$wpdb->prefix."postmeta T3 WHERE T3.post_id=T1.posts_id AND T3.meta_key='_regular_price') as regularPrice,(SELECT cast(T6.meta_value AS UNSIGNED) FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as price FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T1.status!='2' AND T4.type in ('".$type."') AND T1.status!='3' $where $pricedata"); */

		$qr_data = "SELECT T1.id, T1.posts_id, T1.Sku, T1.Style, T1.stockNumber, T1.Image, T1.ShapeCode, T1.Color, T1.Clarity, T1.Cut, T1.SizeCt, T1.CertType, T1.PriceCt, T1.Polish, T1.Symmetry, T1.DepthPct, T1.TablePct, T1.Fluorescence, T1.LWRatio, T1.CertLink, T1.Girdle, T1.VideoLink, T1.Culet, T1.WholesalePrice, IF(T1.Measurements IS NULL or T1.Measurements = '', '-', T1.Measurements) as Measurements, T1.ShapeDescription, T1.vendor, T1.status,T4.name, T4.vendor_code, T4.abbreviation, T4.shipdays, T5.post_date, T5.post_content, T5.post_title, T5.post_name, T5.post_type, T5.post_mime_type,T6.meta_value AS price, T7.meta_value AS regularPrice,T9.meta_value AS salePrice FROM ".$wpdb->prefix."custom_kdmdiamonds T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."postmeta T6 on T6.post_id=T1.posts_id and T6.meta_key='_price' LEFT JOIN ".$wpdb->prefix."postmeta T7 on T7.post_id=T1.posts_id and T7.meta_key='_regular_price' LEFT JOIN ".$wpdb->prefix."postmeta T9 on T9.post_id=T1.posts_id and T9.meta_key='_sale_price' INNER JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T4.type in ('".$type."') AND T1.status!='2' AND T1.status!='3' $where $pricedata";
		
		$total_items = $wpdb->get_results($qr_data);
		$main_query = $qr_data." ".$orderBy." ".$limit;
		
		$query = $wpdb->get_results($main_query,ARRAY_A);

		
		
		$result['Status'] = 200;
		$result['Total'] = count($total_items);
		$result['data'] = $query;
		return rest_ensure_response( $result );
	}
}
if ( ! function_exists( 'getMinedDiamondsList' ) ) {
	function getMinedDiamondsList()
	{
		$where = '';
		$limit = '';
		$pricedata = '';
		$orderBy = 'ORDER BY T1.id DESC';
		$per_page_count = filterApi['per_page_count'];
		$limit = 'LIMIT 0, '.$per_page_count.'';
		$price_order = 0;
		foreach($_REQUEST as $key=>$value){
			$value = str_replace(",","','",$value);
			switch (strtoupper($key)) {
				case 'VENDOR':
					$where .= " AND T1.vendor IN ('$value')";
					break;
                case 'COLOR':
					$where .= " AND T1.Color IN ('$value')";
					break;
				case 'POLISH':
					$where .= " AND T1.Polish IN ('$value')";
					break;
				case 'CUT':
					$where .= " AND T1.Cut IN ('$value')";
					break;
				case 'SHAPE':
					$where .= " AND T1.ShapeCode IN ('$value')";
				break;
				case 'LAB':
					$where .= " AND T1.CertType IN ('$value')";
					break;
				case 'SYMMETRY':
					$where .= " AND T1.Symmetry IN ('$value')";
					break;
				case 'CLARITY':
					$where .= " AND T1.Clarity IN ('$value')";
					break;
				case '360VIEW':
					if($value == 1)
						$where .= " AND T1.VideoLink !='' ";
					break;
				case 'ORDERBYPRICE':
					$value = strtoupper($value);
					$orderBy = (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY price $value" : "";
					$price_order = 1;
					break;
				case 'ORDERBYCARAT':
					$value = strtoupper($value);
					$orderBy = (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T1.SizeCt $value" : "";
					break;
				case 'ORDERBYCOLOR':
					$value = strtoupper($value);
					$orderBy = (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T1.Color $value" : "";
					break;
				case 'ORDERBYCLARITY':
					$value = strtoupper($value);
					$orderBy = (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T1.Clarity $value" : "";
					break;
				case 'QUICKSHIP':
					$value = strtoupper($value);
					$orderBy .= (($value == 'DESC') || ($value == 'ASC')) ? " ORDER BY T4.shipdays $value" : " ORDER BY T4.shipdays ASC";
					break;
				case 'PAGE':
					$page = is_int($value)? ($value-1)*$per_page_count : 0 ;
					$limit = " LIMIT $page, $per_page_count";
					break;
				case 'MINLWRATIO':
					$where .= " AND T1.LWRatio >= ".$value;
					break;
				case 'MAXLWRATIO':
					$where .= " AND T1.LWRatio <= ".$value;
					break;
				case 'MINDEPTH':
					$where .= " AND T1.DepthPct >= ".$value;
					break;
				case 'MAXDEPTH':
					$where .= " AND T1.DepthPct <= ".$value;
					break;
				case 'MINTABLE':
					$where .= " AND T1.TablePct >= ".$value;
					break;
				case 'MAXTABLE':
					$where .= " AND T1.TablePct <= ".$value;
					break;
				case 'MINCARAT':
					$where .= " AND T1.SizeCt >= ".$value;
					break;
				case 'MAXCARAT':
					$where .= " AND T1.SizeCt <= ".$value;
					break;
				case 'LIMIT':
					$limit = " LIMIT 0, ".$value;
					break;
				case 'MINPRICE':
					if(strpos($pricedata, "HAVING") !== FALSE)
						$pricedata .= " AND wholesale_price >= ".$value;
					else
						$pricedata .= " HAVING wholesale_price >= ".$value;
					break;
				case 'MAXPRICE':
					if(strpos($pricedata, "HAVING") !== FALSE)
						$pricedata .= " AND wholesale_price <= ".$value;
					else
						$pricedata .= " HAVING wholesale_price <= ".$value;
					break;
				case 'TYPE':
					$where .= " AND T4.type IN ('$value')";
					break;
				
			}
		}
		if(!$price_order){
			$orderBy .= " ORDER BY price ASC";
		}
		global $wpdb;
		$query1=$wpdb->get_row("SELECT count(T1.id) as total_items, (SELECT T2.meta_value FROM ".$wpdb->prefix."postmeta T2 WHERE T2.post_id=T1.posts_id AND T2.meta_key='_sale_price') as salePrice,(SELECT  T3.meta_value FROM ".$wpdb->prefix."postmeta T3 WHERE T3.post_id=T1.posts_id AND T3.meta_key='_regular_price') as regularPrice,(SELECT cast(T6.meta_value AS UNSIGNED) FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as price FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T1.status!='2' AND T1.status!='3' $where $pricedata");
		$query=$wpdb->get_results("SELECT T1.posts_id as ID, T1.Style as product_name,T5.post_title as product_display_name, T1.stockNumber as product_stock_number, T5.post_date, T5.post_content as product_description, (SELECT  T6.meta_value FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as product_price, T1.PriceCt as product_price_ct, T1.Measurements as product_measurements, T1.CertLink as product_certificate_image, T1.CertLink as product_certificate_url,T1.Fluorescence, T1.SizeCt as product_carat, T1.VideoLink as product_video, T1.Image as product_rapnet_image, T1.status as product_status, T1.Sku as product_inventoryID, T1.Polish as product_polish, T1.Symmetry as product_symmetry, T1.DepthPct as product_depth, T1.Girdle as product_girdle, T1.Culet as product_culet, T1.TablePct as product_dTable, T1.ShapeDescription as about_cut, T4.shipdays as shipping, T1.Color as color_title, T1.Clarity as clarity_title, T1.Cut as cut_title, T4.ds_vendor_name as display_name, T1.ShapeCode as shape_title, T1.LWRatio, T1.CertType as certificate_name, T1.WholesalePrice as wholesale_price FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T1.status!='2' AND T1.status!='3' $where $pricedata $orderBy $limit");
		//print_r($query);
		$result['Status'] = 200;
		$result['Total'] = $query1->total_items;
		$result['data'] = $query;
		return rest_ensure_response( $query, ARRAY_A );
	}
}
if ( ! function_exists( 'getFilterData' ) ) {
	function getFilterData(){
			global $wpdb;
			$data = [];
			$query_price=$wpdb->get_results("SELECT MIN(cast(meta_value as unsigned)) as minprice, MAX(cast(meta_value as unsigned)) as maxprice FROM `".$wpdb->prefix."postmeta` T1 INNER JOIN ".$wpdb->prefix."custom_kdmdiamonds T2 ON T1.post_id=T2.posts_id WHERE meta_key='_price'");
			$query_carat=$wpdb->get_results("SELECT MIN(SizeCt) as mincarat, MAX(SizeCt) as maxcarat FROM `".$wpdb->prefix."custom_kdmdiamonds`");
			$query_depth=$wpdb->get_results("SELECT MIN(DepthPct) as mindepth, MAX(DepthPct) as maxdepth FROM `".$wpdb->prefix."custom_kdmdiamonds`");
			$query_table=$wpdb->get_results("SELECT MIN(TablePct) as mintable, MAX(TablePct) as maxtable FROM `".$wpdb->prefix."custom_kdmdiamonds`");
			$query_lwratio=$wpdb->get_results("SELECT MIN(LWRatio) as minlwratio, MAX(LWRatio) as maxlwratio FROM `".$wpdb->prefix."custom_kdmdiamonds`");
			$query_vendor=$wpdb->get_results("SELECT id,name,vendor_code,abbreviation,shipdays FROM `".$wpdb->prefix."custom_kdmvendors` WHERE status = '1'");
			$data['price'] = $query_price;
			$data['carat'] = $query_carat;
			$data['depth'] = $query_depth;
			$data['table'] = $query_table;
			$data['lwratio'] = $query_lwratio;
			$data['color'] = Filters['colors'];
			$data['clarity'] = Filters['clarity'];
			$data['cuts'] = Filters['cut'];
			$data['symmetry'] = Filters['symmetry'];
			$data['shapes'] = Filters['shapes'];
			$data['labs'] = Filters['labs'];
			$data['polish'] = Filters['polish'];
			$data['fluorescence'] = Filters['fluorescence'];
			$data['vendor'] = $query_vendor;
			$view360Data = [];
			$view360Data[] = ['unavailable'=>'0', 'available'=>'1'];
			$data['360view '] = $view360Data;
			return rest_ensure_response( $data, ARRAY_A );
	}
}
if ( ! function_exists( 'getSimilarDiamonds' ) ) {
	function getSimilarDiamonds(){
		global $wpdb;
		$post_id = $_REQUEST['id'];
		//$limit = 'LIMIT 0, '.filterApi['similar_count'].'';
		$limit = filterApi['similar_count'];
		$record=$wpdb->get_row("SELECT T1.id, T1.posts_id, T1.Sku, T1.Style, T1.stockNumber, T1.Image, T1.ShapeCode, T1.Color, T1.Clarity, T1.Cut, T1.SizeCt, T1.CertType, T1.PriceCt, T1.Polish, T1.Symmetry, T1.DepthPct, T1.TablePct, T1.Fluorescence, T1.LWRatio, T1.CertLink, T1.Girdle, T1.VideoLink, T1.Culet, T1.WholesalePrice, IF(T1.Measurements IS NULL or T1.Measurements = '', '-', T1.Measurements) as Measurements, T1.ShapeDescription, T1.vendor, T1.status,  (SELECT T2.meta_value FROM ".$wpdb->prefix."postmeta T2 WHERE T2.post_id=T1.posts_id AND T2.meta_key='_sale_price') as salePrice,(SELECT  T3.meta_value FROM ".$wpdb->prefix."postmeta T3 WHERE T3.post_id=T1.posts_id AND T3.meta_key='_regular_price') as regularPrice,(SELECT cast(T6.meta_value AS UNSIGNED) FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as price, T4.name, T4.vendor_code,T4.type, T4.abbreviation, T4.shipdays, T5.post_date, T5.post_content, T5.post_title, T5.post_name, T5.post_type, T5.post_mime_type FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T1.status!='2' AND T1.status!='3' AND T1.posts_id='".$_REQUEST['id']."'");

		/*print_r($record);
		die;*/
		$colors = Filters['colors'];
		$clarity = Filters['clarity'];
		$cut =  Filters['cut'];
		$pos = array_search($record->Color, $colors);
		$colorGroup='';
		$clarityGroup='';
		$cutGroup='';
		if($pos){
			if($pos<(count($colors)-1)){
				$nextPos = $pos+1;
			}else{
				$nextPos = count($colors)-2;
			}
			$colorGroup = [$record->Color,$colors[$nextPos]];
			$colorGroup = join("','",$colorGroup);
		}

		$pos = array_search($record->Clarity, $clarity);
		if($pos){
			if($pos<(count($clarity)-1)){
				$nextPos = $pos+1;
			}else{
				$nextPos = count($clarity)-2;
			}
			$clarityGroup = [$record->Clarity,$clarity[$nextPos]];
			$clarityGroup = join("','",$clarityGroup);
		}
		$cutGroup = '';
        if($record->ShapeCode == 'Round'){
        	$pos = array_search($record->Cut, $cut);
			if($pos){
				if($pos<(count($cut)-1)){
					$nextPos = $pos+1;
				}else{
					$nextPos = count($cut)-2;
				}
				$cutGroup = [$record->Cut,$cut[$nextPos]];
				$cutGroup = join("','",$cutGroup);
				$cutGroup = "And T1.Cut in ('".$cutGroup."')";
			}
        }

        if($record->type == 'M'){
			$nxt_price = $record->price + 2500;
			$pre_price = $record->price - 500;
		}
		else{
			$nxt_price = $record->price + 500;
			$pre_price = $record->price - 3500;
		}

        $cmxwidth=$record->SizeCt+0.4;
		$cmnwidth=$record->SizeCt-0.1;
		if($record->SizeCt > 3.7)
		{
			$cmnwidth=$record->weight-0.3;
		}

		$similarItems = $wpdb->get_results("SELECT T1.id, T1.posts_id, T1.Sku, T1.Style, T1.stockNumber, T1.Image, T1.ShapeCode, T1.Color, T1.Clarity, T1.Cut, T1.SizeCt, T1.CertType, T1.PriceCt, T1.Polish, T1.Symmetry, T1.DepthPct, T1.TablePct, T1.Fluorescence, T1.LWRatio, T1.CertLink, T1.Girdle, T1.VideoLink, T1.Culet, T1.WholesalePrice, IF(T1.Measurements IS NULL or T1.Measurements = '', '-', T1.Measurements) as Measurements, T1.ShapeDescription, T1.vendor, T1.status,  (SELECT T2.meta_value FROM ".$wpdb->prefix."postmeta T2 WHERE T2.post_id=T1.posts_id AND T2.meta_key='_sale_price') as salePrice,(SELECT  T3.meta_value FROM ".$wpdb->prefix."postmeta T3 WHERE T3.post_id=T1.posts_id AND T3.meta_key='_regular_price') as regularPrice,(SELECT cast(T6.meta_value AS UNSIGNED) FROM ".$wpdb->prefix."postmeta T6 WHERE T6.post_id=T1.posts_id AND T6.meta_key='_price') as price, T4.name, T4.vendor_code, T4.abbreviation, T4.type,T4.shipdays, T5.post_date, T5.post_content, T5.post_title, T5.post_name, T5.post_type, T5.post_mime_type FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."posts T5 ON T5.ID = T1.posts_id LEFT JOIN ".$wpdb->prefix."custom_kdmvendors T4 ON T1.vendor = T4.id where T1.status!='0' AND T1.status!='2' AND T1.status!='3' AND T1.Color in ('".$colorGroup."') AND T1.Clarity in ('".$clarityGroup."') $cutGroup AND T1.ShapeCode = '".$record->ShapeCode."' AND SizeCt between $cmnwidth and $cmxwidth AND T1.posts_id<>'".$_REQUEST['id']."' HAVING price >= price AND price <= ".$nxt_price." ORDER BY price ASC",ARRAY_A);


		

		$LGArray = array_filter($similarItems, function ($item) {
		    if ($item['type']== 'LG') {
		        return true;
		    }
		    return false;
		});
		if(count($LGArray)>$limit){
			$LGArray = array_slice($LGArray, 0, ($limit-1)); 
		}
		$MinedArray = array_filter($similarItems, function ($item) {
		    if ($item['type']== 'M') {
		        return true;
		    }
		    return false;
		});
		if(count($MinedArray)>$limit){
			$MinedArray = array_slice($MinedArray, 0, ($limit-1)); 
		}
		$result['LGArray'] = $LGArray;
		$result['MinedArray'] = $MinedArray;
		
		return rest_ensure_response( $result, ARRAY_A );
	}
}

?>