<?php
/*
Global Constants
Config File For Numined Website
KEYIDEAS INFOTECH PVT LTD
*/
//Quality Gold Constants
define('import_qgold', array(
	'name'=>'Quality Gold',
	'Username'=>'lgd_api',
	'Password'=>'ND832!',
	'AccountId'=>'25266',
	'Referer'=>'https://www.numineddiamonds.com',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'DLOG',
	'shipdays'=>3,
	'type'=>'LG',
	'source'=>'D-API',
	'status'=>0
));
//JAS Constants
define('import_jas', array(
	'name'=>'JAS',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'SAJ',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/jas/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>0
));
//Meylor Constants
define('import_meylor', array(
	'name'=>'Meylor',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'GLM',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/meylor/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>0
));
//SRDSIL
define('import_srdsil', array(
	'name'=>'SRDSIL',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'SDRS',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/srdsil/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>0
));
//GreenRock Constants
define('import_greenrock', array(
	'name'=>'GreenRocks',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'DRG',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/greenrocks/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>0
));
//Numined Diamonds Constants
define('import_numined', array(
	'name'=>'Numined',
	'onect_below_margin_price' => 0,
	'onect_above_margin_price' => 0,
	'vendor_code'=>'MUN',
	'shipdays'=>2,
	'csv_file_path'=>WP_CONTENT_DIR.'/diamond_uploads/numined/',
	'type'=>'LG',
	'source'=>'CSV',
	'status'=>0
));
//Belgium Constants
define('import_belgium', array(
	'name'=>'Belgium diamonds',
	'onect_below_margin_price' => 30,
	'onect_above_margin_price' => 25,
	'APIKEY'=>'44460dd88728d5c528d9c305bfdcaeb351f4e8fbc587',
	'vendor_code'=>'DLB',
	'shipdays'=>2,
	'type'=>'M',
	'source'=>'D-API',
	'status'=>0
));
//Parishi Diamond
define('import_parishi', array(
	'name'=>'Parishi Diamonds',
	'onect_below_margin_price' => 30,
	'onect_above_margin_price' => 25,
	'Username'=>'thediamondart',
	'Password'=>'thediamondart@19',
	'vendor_code'=>'DRP',
	'shipdays'=>2,
	'type'=>'M',
	'source'=>'D-API',
	'status'=>0
));
//LGTrade Constants
define('import_lgtrade', array(
	'Username'=>'info@thediamondart.com',
	'Password'=>'Zina@2012',
	'vendors'=>array ( 
		0 => array ( 'name' => 'Mehta Diam','vendor_code'=>'DHM','shipdays'=>2,'onect_below_margin_price' => 27 ,'onect_above_margin_price' => 22,'status'=>1 ),
		1 => array ( 'name' => 'UNIQUE LAB GROWN DIAMOND','vendor_code'=>'DGLU','shipdays'=>2,'onect_below_margin_price' => 27 ,'onect_above_margin_price' => 22,'status'=>1 ),
		2 => array ( 'name' => 'Lab stone','vendor_code'=>'DSL','shipdays'=>2,'onect_below_margin_price' => 27 ,'onect_above_margin_price' => 22,'status'=>1 ) ),
	'type'=>'LG',
	'source'=>'LGT-API',
	'status'=>0
));
//VDB LG Constants
define('import_vdbLG', array(
	'Type' => 'Lab_grown_Diamond',
	'Auth' => 'Token token=NY-Ms-itlEZQvWB1575tse6zVh40ZlZR6X07OsNlZXw, api_key=bad_IIoVwROu-XB10mRBnjdkdg',
	'vendors'=>array (
		0 => array ( 'name' => 'Eco Star',  'vendor_code'=>'SE','shipdays'=>10,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>1 ) ,
		1=> array ( 'name' => 'Go Green Diamonds Inc.','vendor_code'=>'DGG','shipdays'=>2,'onect_below_margin_price' => 35 ,'onect_above_margin_price' => 30,'status'=>1 ),
		2=> array ( 'name' => 'Advanced Technology','vendor_code'=>'TADV','shipdays'=>2,'onect_below_margin_price' => 35, 'onect_above_margin_price' => 30,'status'=>1 ) ),
	'type'=>'LG',
	'source'=>'VDB-API',
	'status'=>1
));
//VDB Mined Constants
define('import_vdbM', array(
	'Type' => 'Diamond',
	'Auth' => 'Token token=iNyJI1-2LLq2pnSy3sMWAOCxxkm-vmoBVy4E2smxT9Y, api_key=_HAxdckxn8bobdLWwoS4tsg',
	'vendors'=>array ( 
		0 => array ( 'name' => 'Vaibhav Gems','vendor_code'=>'GV','shipdays'=>2,'onect_below_margin_price' => 30 ,'onect_above_margin_price' => 17,'status'=>0 ),
		1 => array ( 'name' => 'Sagar Star Corp.','vendor_code'=>'CSS','shipdays'=>2,'onect_below_margin_price' => 30 ,'onect_above_margin_price' => 17,'status'=>0 ),
		2 => array ( 'name' => 'Ofer Mizrahi Diamonds, Inc','vendor_code'=>'DMO','shipdays'=>2,'onect_below_margin_price' => 30 ,'onect_above_margin_price' => 17,'status'=>0 ),
		3 => array ( 'name' => 'Belgium NY LLC','vendor_code'=>'LNB','shipdays'=>2,'onect_below_margin_price' => 30 ,'onect_above_margin_price' => 17,'status'=>0 ),
		4 => array ( 'name' => 'MJ Gross Inc.','vendor_code'=>'GJM','shipdays'=>2,'onect_below_margin_price' => 30 ,'onect_above_margin_price' => 17,'status'=>0 ) ),
	'type'=>'M',
	'source'=>'VDB-API',
	'status'=>0
));

//Diamond Foundry
define('import_df', array(
	'name'=>'Diamond Foundry',
	'email'=>'stephanie@numined.com',
	'password'=>'Dimend1734',
	'onect_below_margin_price' => 27,
	'onect_above_margin_price' => 22,
	'vendor_code'=>'OFD',
	'shipdays'=>3,
	'type'=>'LG',
	'source'=>'D-API',
	'status'=>0
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
	'labs'=>array ('AGS','IGI','GCAL'),
	'fluorescence'=>array('None','Faint','Medium','Strong','Very Strong'),
	'price_min'=>100,'price_max'=>54000
));

//Quality Gold Diamond Filters Constants
define('QGFilters', array(
	//basic
	'shapes'=>array("Round","Cushion","Oval","Radiant","Emerald","Pear","Princess","Asscher","Marquise","Heart"),
	'colors'=>array("L", "K", "J", "I", "H", "G", "F", "E","D"),
	'clarity'=>array("I1", "SI2", "SI1", "VS2", "VS1", "VVS2", "VVS1","FL", "IF"),
	'cut'=>array("Good", "Very Good", "Excellent", "Ideal"),
	'carat_min'=>0.7,'carat_max'=>6.0,
	//advanced
	'polish'=>array('Good','Very Good','Excellent','Ideal'),
	'symmetry'=>array('Good','Very Good','Excellent','Ideal'),
	'labs'=>array ('GIA','IGI','GCAL'),
	'fluorescence'=>array('None','Faint','Medium','Strong','Very Strong'),
	'price_min'=>100,'price_max'=>54000
));

//schedules for cron differnt vendors
define('schedules', array(
	//!belgium,!parishi,meylor
	// 'schedule1' => array('start_time' => '06:00 am','end_time' => '07:00 am'),
	//qgold,numined
	// 'schedule2' => array('start_time' => '08:00 pm','end_time' => '09:00 pm'),
	//!lgtrade,greenrock
	// 'schedule3' => array('start_time' => '06:00 am','end_time' => '07:00 am'),
	//vdbLG,!vdbM,jas
	'schedule4' => array('start_time' => '04:00 am','end_time' => '05:30 am'),
	//SRDSIL,DiamondFoundry
	// 'schedule5' => array('start_time' => '06:00 am','end_time' => '07:00 am')
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