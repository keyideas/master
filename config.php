<?php
/*
Global Constants
Config File For Numined Website
KEYIDEAS INFOTECH PVT LTD
*/
//JAS Constants
define('import_BareDiamond', array(
	'name'=>'BareDiamond',
	'onect_below_margin_price' => 240,
	'onect_above_margin_price' => 240,
	'vendor_code'=>'BRD',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/barediamond/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>1
));

//VDB LG Constants
define('import_vdbLG', array(
	'Type' => 'Lab_grown_Diamond',
	'Auth' => 'Token token=NY-Ms-itlEZQvWB1575tse6zVh40ZlZR6X07OsNlZXw, api_key=bad_IIoVwROu-XB10mRBnjdkdg',
	'vendors'=>array (
		0 => array ( 'name' => 'Eco Star',  'vendor_code'=>'SE','shipdays'=>10,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>1 ) ,
		1=> array ( 'name' => 'Go Green Diamonds Inc.','vendor_code'=>'DGG','shipdays'=>7,'onect_below_margin_price' => 35 ,'onect_above_margin_price' => 30,'status'=>1 ),
		2=> array ( 'name' => 'Advanced Technology','vendor_code'=>'TADV','shipdays'=>7,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>0 ) ,
		3=> array ( 'name' => 'Parallel Diamonds','vendor_code'=>'DLP','shipdays'=>7,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>1 ) ,
		4=> array ( 'name' => 'Unique Lab Grown Diamond Inc','vendor_code'=>'DGLU','shipdays'=>7,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>1 ) ),
	'type'=>'LG',
	'source'=>'VDB-API',
	'status'=>1
));


define('Filters', array(
	//basic
	'shapes'=>array("Round","Oval","Cushion","Princess","Pear","Emerald","Marquise","Asscher","Radiant","Heart"),
	'colors'=>array("L", "K", "J", "I", "H", "G", "F", "E","D"),
	'clarity'=>array("I2","I1", "SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1","FL", "IF"),
	'cut'=>array("Good", "Very Good", "Excellent", "Ideal"),
	'carat_min'=>0.3,'carat_max'=>12.0,
	//advanced
	'polish'=>array('Good','Very Good','Excellent','Ideal'),
	'symmetry'=>array('Good','Very Good','Excellent','Ideal'),
	'labs'=>array ('AGS','IGI','GCAL','HRD'),
	'fluorescence'=>array('None','Faint','Medium','Strong','Very Strong'),
	'price_min'=>100,'price_max'=>54000
));

//schedules for cron differnt vendors
define('schedules', array(
	////barediamond
	'schedule1' => array('start_time1' => '04:00 am','end_time1' => '05:00 am','start_time2' => '07:00 am','end_time2' => '08:00 am','start_time3' => '10:00 am','end_time3' => '11:00 am','start_time4' => '02:00 pm','end_time4' => '02:00 pm','start_time5' => '04:00 pm','end_time5' => '05:00 pm','start_time6' => '07:00 pm','end_time6' => '08:00 pm','start_time7' => '10:00 pm','end_time7' => '11:00 pm','start_time8' => '01:00 am','end_time8' => '02:00 am'),
	//vdbLG,
	'schedule2' => array('start_time1' => '05:00 am','end_time1' => '06:00 am','start_time2' => '08:00 am','end_time2' => '09:00 am','start_time3' => '11:00 am','end_time3' => '12:00 pm','start_time4' => '01:00 pm','end_time4' => '03:00 pm','start_time5' => '05:00 pm','end_time5' => '06:00 pm','start_time6' => '08:00 pm','end_time6' => '09:00 pm','start_time7' => '11:00 pm','end_time7' => '12:00 am','start_time8' => '02:00 am','end_time8' => '03:00 am'),
	

));


// Diamond Filters Constants for KDM PLugin
define('AllowFilter', array(
	'360view' => false,
	'quickShip' => false,
	'shape' => true,
	'price' => true,
	'caret' => true,
	'cut' => true,
	'color' => true,
	'clarity' => true,
	'polish' => false,
	'symmetry' => false,
	'labs' => false,
	'ratio' => false,
	'depth' => false,
	'table' => false,
	'vendor' => false
));

// Ring Option for Ring detail page
define('RingOption', array(
	'14k-rose-gold' => '14K Rose Gold',
	'18k-white-gold' => '18K White Gold',
	'18k-yellow-gold' => '18K Yellow Gold',
	'platinum' => 'Platinum'
));

// Ring Size for Ring detail page
define('RingSize', array(
	'3' => '3',
	'3.25' => '3.25',
	'3.50' => '3.50',
	'3.75' => '3.75',
	'4' => '4',
	'4.25' => '4.25',
	'4.50' => '4.50',
	'4.75' => '4.75',
	'5' => '5',
	'5.25' => '5.25',
	'5.50' => '5.50',
	'5.75' => '5.75',
	'6' => '6',
	'6.25' => '6.25',
	'6.50' => '6.50',
	'6.75' => '6.75',
	'7' => '7',
	'7.25' => '7.25',
	'7.50' => '7.50',
	'7.75' => '7.75',
	'8' => '8',
	'8.25' => '8.25',
	'8.50' => '8.50',
	'8.75' => '8.75',
	'9' => '9',
	'9.25' => '9.25',
	'9.50' => '9.50',
	'9.75' => '9.75',
	'10' => '10',
	'10.25' => '10.25',
	'10.50' => '10.50',
	'10.75' => '10.75',
	'11' => '11',
	'11.25' => '11.25',
	'11.50' => '11.50',
	'11.75' => '11.75',
	'12' => '12',
	'12.5' => '12.5',
	'22766' => '12.25',
	'12.25' => '12.75',
	'13' => '13',
	'13.5' => '13.5',
	'0' => 'I don\'t know'
));

/*
Filter Diamonds Api Constants
*/
define('filterApi',array(
	'per_page_count' =>100    //number of data to be showed on one page
));
/*
image extension allowed
*/
define('imageExtension',array(
	'jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF')
);

//EMAIL CONSTANTS
define('mail_cron',array(
	'mail_from_address' => 'keyideas.barediamond@gmail.com',
	'mail_to_address' => 'keyideas.barediamond@gmail.com',
	'subject'=>'The Keyideas Barediamonds import cron Updates.'
));

?>