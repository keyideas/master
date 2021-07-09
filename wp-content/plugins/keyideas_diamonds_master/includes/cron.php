<?php 



include_once KDIPATH . '/includes/functions.php';

include_once KDIPATH . '/includes/yoast-seo.php';

include_once KDIPATH . '/includes/mail.php';

function custom_vendor_diamonds_import($vendor){

	ini_set('max_execution_time', 0);
	//ini_set('max_input_time', -1);
	//set_time_limit(0);
	ini_set('display_errors', 1);
	global $wpdb;
	//define('startTime', time());
	
	$startTime=time();
	$filters = Filters;
	$metaquery = "INSERT INTO ".$wpdb->prefix."postmeta(post_id,meta_key,meta_value) VALUES ";
  	$values = '';
  	$seometaquery = "INSERT INTO ".$wpdb->prefix."postmeta(post_id,meta_key,meta_value) VALUES ";
  	$seovalues = '';
	// Import Diamonds From JAS Diamond API
	
	if($vendor=='vdbLG'){
		$vdbArr = import_vdbLG;
		include_once KDIPATH. '/includes/import_vdb.php';
		//send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='barediamond'){
		include_once KDIPATH. '/includes/import_barediamond.php';
		//send_mail(mail_cron,$vendor,$startTime);
	}
}

function custom_kdm_diamonds_import_cron(){
	/*echo date("h:i a");
	die;*/
	if((strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time1']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time1'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time2']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time2'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time3']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time3'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time4']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time4'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time5']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time5'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time6']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time6'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time7']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time7'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time8']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time8']))){
		if(import_BareDiamond['status'] == 1){
		custom_vendor_diamonds_import('barediamond');
		}
	}
	if((strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time1']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time1'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time2']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time2'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time3']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time3'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time4']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time4'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time5']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time5'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time6']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time6'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time7']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time7'])) || (strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time8']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time8']))){
		if(import_vdbLG['status'] == 1){
		custom_vendor_diamonds_import('vdbLG');
		}
		
	}

	
	
}
?>