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
	if($vendor=='meylor'){
		include_once KDIPATH. '/includes/import_meylor.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='numined'){
		include_once KDIPATH. '/includes/import_numined.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='qgold'){
		include_once KDIPATH. '/includes/import_qgold.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='jas'){
		include_once KDIPATH. '/includes/import_jas.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='df'){
		include_once KDIPATH. '/includes/import_df.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='excellent'){
		include_once KDIPATH. '/includes/import_excellent.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='srdsil'){
		include_once KDIPATH. '/includes/import_srdsil.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='sanghvi'){
		include_once KDIPATH. '/includes/import_sanghvi.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='rapnet'){
		include_once KDIPATH. '/includes/import_rapnet.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='purestones'){
		include_once KDIPATH. '/includes/import_purestones.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='angel'){
		include_once KDIPATH. '/includes/import_angel.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='dharma'){
		include_once KDIPATH. '/includes/import_dharma.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='greenrock'){
		include_once KDIPATH. '/includes/import_greenrock.php';
		send_mail(mail_cron,$vendor,$startTime);
	}

	if($vendor=='ethereal'){
		include_once KDIPATH. '/includes/import_ethereal.php';
		send_mail(mail_cron,$vendor,$startTime);
	}

	if($vendor=='belgium'){
		include_once KDIPATH. '/includes/import_belgium.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='parishi'){
		include_once KDIPATH. '/includes/import_parishi.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='lgtrade'){
		include_once KDIPATH. '/includes/import_lgtrade.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='vdbLG'){
		$vdbArr = import_vdbLG;
		include_once KDIPATH. '/includes/import_vdb.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='vdbM'){
		$vdbArr = import_vdbM;
		include_once KDIPATH. '/includes/import_vdb.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='jasM'){
		$vdbArr = import_vdbM;
		include_once KDIPATH. '/includes/import_jasM.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
	if($vendor=='meylorM'){
		$vdbArr = import_vdbM;
		include_once KDIPATH. '/includes/import_meylorM.php';
		send_mail(mail_cron,$vendor,$startTime);
	}
}

function custom_kdm_diamonds_import_cron(){
	/*echo date("h:i a");
	die;*/
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule1']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule1']['end_time'])){
		if(import_belgium['status'] == 1){
		custom_vendor_diamonds_import('belgium');
		}
		if(import_parishi['status'] == 1){
			custom_vendor_diamonds_import('parishi');
		}
		
		if(import_meylor['status'] == 1){
			custom_vendor_diamonds_import('meylor');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule2']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule2']['end_time'])){
		if(import_qgold['status'] == 1){
			custom_vendor_diamonds_import('qgold');
		}
		if(import_numined['status'] == 1){
			custom_vendor_diamonds_import('numined');
		}
	}

	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule3']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule3']['end_time'])){
		if(import_lgtrade['status'] == 1){
			custom_vendor_diamonds_import('lgtrade');
		}
		if(import_ethereal['status'] == 1){
			custom_vendor_diamonds_import('ethereal');
		}
		if(import_greenrock['status'] == 1){
			custom_vendor_diamonds_import('greenrock');
		}
	}

	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule4']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule4']['end_time'])){
		if(import_vdbLG['status'] == 1){
		custom_vendor_diamonds_import('vdbLG');
		}
		if(import_vdbM['status'] == 1){
			custom_vendor_diamonds_import('vdbM');
		}
		if(import_jas['status'] == 1){
			custom_vendor_diamonds_import('jas');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule5']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule5']['end_time'])){
		if(import_df['status'] == 1){
		custom_vendor_diamonds_import('df');
		}
		if(import_excellent['status'] == 1){
		custom_vendor_diamonds_import('excellent');
		}
		if(import_srdsil['status'] == 1){
		custom_vendor_diamonds_import('srdsil');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule6']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule6']['end_time'])){
		if(import_sanghvi['status'] == 1){
		custom_vendor_diamonds_import('sanghvi');
		}
		if(import_rapnet['status'] == 1){
		custom_vendor_diamonds_import('rapnet');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule7']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule7']['end_time'])){
		if(import_angel['status'] == 1){
		custom_vendor_diamonds_import('angel');
		}
		if(import_dharma['status'] == 1){
		custom_vendor_diamonds_import('dharma');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule8']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule8']['end_time'])){
		if(import_jasM['status'] == 1){
		custom_vendor_diamonds_import('jasM');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule9']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule9']['end_time'])){
		if(import_meylorM['status'] == 1){
		custom_vendor_diamonds_import('meylorM');
		}
	}
	if(strtotime(date("h:i a")) >= strtotime(schedules['schedule10']['start_time']) && strtotime(date("h:i a")) < strtotime(schedules['schedule10']['end_time'])){
		if(import_purestones['status'] == 1){
		custom_vendor_diamonds_import('purestones');
		}
	}
}
?>