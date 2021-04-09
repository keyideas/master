=== Keyideas Diamonds Master ===
Contributors: keyideas
Tags: Diamonds Import product importer
Donate link: www.keyideasinfotech.com
Requires at least: 4.0
Tested up to: 7.3.*
Requires PHP: 7.0
Stable tag: 2.18
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


====Change Log 2.18 ==
Dated : 19 December 2020
- Added Diamond filter functionalities, Make filter enable and disable acccordingly

====Change Log 2.17 ==
Dated : 28 August 2020
-Change in getCertificateUrl function in functions.php, redirect cert Url to "www.igi.org/viewpdf.php?r=" if url comes from  igiworldwide.com 

====Change Log 2.16 ==
Dated : 27 August 2020
-Add new vendor purestones Diamonds lab grown

====Change Log 2.15 ==
Dated : 25 August 2020
-Add new vendor Etheareal Diamonds lab grown

====Change Log 2.14 ==
Dated : 21 August 2020
-Change in import_rapnet file to fix the file related warnings if file not found

====Change Log 2.13 ==
Dated : 18 August 2020
-Add new vendor Excellent Diamonds for mined on studio

====Change Log 2.12 ==
Dated : 24 July 2020
-Adding jas mined vendor,meylor mined vendor,diamond foundry vendor in kdm plugin
-Reading Numined Csv using header
-Changing the sku to get the 7 digit SKU 

====Change Log 2.11 ==
Dated : 17 July 2020
* Delete all csv files from reading directory after reading latest file is done , Need to integrate on NU live
* Numined vendor first image issue fix 

====Change Log 2.10 ==
Dated : 15 July 2020
* Optimize diamond listing API, remove subqueries from queries  

====Change Log 2.9 ==
Dated : 14 July 2020
* Similar Diamonds API created
* Change in video link for angel star url ,remove zoomslide parameter

====Change Log 2.8 ==
Dated : 11 July 2020
* Mail Text body changed . Added Table format stats
* Change in Export Api. All the non relevant parameters and conditions removed
* Vendor Name Change ,ULGD name change 

====Change Log 2.7 ==
Dated : 09 July 2020
* Cron Start time issue in mail resolved
* Mail Text Changed changed
* Change in Cut and Clarity functions 

==Change Log 2.6 ==
Dated : 09 July 2020
* Sanghvi star vendor added

==Change Log 2.5 ==
Dated : 07 July 2020
* Including diamonds with no image and video as long as 
  have certificate links

==Change Log 2.4 ==
Dated : 04 July 2020
* SKU added in postmeta 
* Cut and Clarity sorting filter added in API

==Change Log 2.3 ==
Dated : 03 July 2020
* certificate added for IGI if CertLink is blank
* Description Text Modify
* Fluoroscence added in api

==Change Log 2.2 ==
Dated : 30 June 2020
* Add diamonds with cut '-' and Blank 
* Add diamonds with shape PE,HE and LR

==Change Log 2.1 ==
Dated : 29 June 2020
* Add SRDSIL vendor 
* Change in GreenRock for image extracted from v360 video 
* Change in Product Title  
* Change and correction in Measurement,LWRatio

==Change Log 2.0 ==
Dated : 23 June 2020
* Delete Vendor on deactivate  
* Dot Url function added in plugin

==Change Log 1.9 ==
Dated : 22 June 2020
* Category issue fixed for diamond dynamically .
* Deleting posts and postmeta data along with diamonds and vendor table
==Change Log 1.8 ==
Dated : 20 June 2020
* Add two new columns type and source
* Update the vendor table using config file by deactivate the plugin and activate



== Description ==
With Keyideas Diamonds Master you can manage diamond import and schedule import :
* diamond table and vendor table created
* vendor on and off using config file
* schedule each vendor cron time interval
* add new vendors

== Installation ==
*place config file wordpress root directory
*install Advanced Cron Manger to schedule cron
*Upload \"keyideas-diamonds-master\" to the \"/wp-content/plugins/\" directory.
*Activate the plugin through the \"Plugins\" menu in WordPress.
== Cron Changes Instructios if Required  == 
*Make changes to cron register function e.g daily to hourly
*Run the query - Update nn_options set option_value='' where option_name='cron' 
*Run the cron Manager again to cron get registered again

==Config File Instructions==
-contains all vendor constant 
-can set the margin price for each vendor that needs to be imported
-can change and extend new filter properties (shapes,colors,clarity,cut,carat_min,carat_max,polish,symmetry,labs,fluorescence,price_min,price_max)
-can change filter api per page count