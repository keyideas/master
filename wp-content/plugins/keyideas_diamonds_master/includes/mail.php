<?php 

function send_mail($mail,$vendor,$startTime){
	global $wpdb;
	$from      = "From: KDM <".$mail['mail_from_address'].">" . "\r\n"; 
	$to = array($mail['mail_to_address']);
	//$to = array('message-90077348-9d8024795843425f8ae2db4b@basecamp.com');
	$subject = $mail['subject'];
	$endTime=   time();
	$runduration=(($startTime)-($endTime));
	
	$totaldiamonds=$wpdb->get_results("SELECT COUNT(id) as totd FROM ".$wpdb->prefix."custom_kdmdiamonds", ARRAY_A);
	
	$headers = array('Content-Type: text/html; charset=UTF-8',$from);
	//echo strtoupper($vendor).' Diamonds Updated Executed';
	$Statistics = getStatisticsDiamonds();
	$total = $total_image = $total_video = $total_certi = 0;
	$res='';
	foreach($Statistics as $result){
		$total +=$result->total;
		$total_image +=$result->image_count;
		$total_video +=$result->video_count;
		$total_certi +=$result->certi_count;
		$res .= '<tr><td style="border: 1px solid black;">'.$result->name.'</td><td style="border: 1px solid black;">'.$result->source.'</td><td style="border: 1px solid black;">'.$result->total.'</td><td style="border: 1px solid black;">'.$result->image_count.'</td><td style="border: 1px solid black;">'.$result->video_count.'</td><td style="border: 1px solid black;">'.$result->certi_count.'</td></tr>';
		
	}
	$res.='<tr><td style="border: 1px solid black;">Total</td><td style="border: 1px solid black;"></td><td style="border: 1px solid black;">'.$total.'</td><td style="border: 1px solid black;">'.$total_image.'</td><td style="border: 1px solid black;">'.$total_video.'</td><td style="border: 1px solid black;">'.$total_certi.'</td></tr>';
	$html = '<html>
    <head>
        <title></title>
        <style type="text/css">td,th {border: 1px solid #ddd;padding: 8px;</style>
    </head>
    <body>
        <div>'.strtoupper($vendor).' Diamonds Updated</div>
        <div>Cron Start Time '.date("d/m/Y H:i:s", $startTime).'</div>
        <div>Cron End Time '.date("d/m/Y H:i:s", $endTime).'</div>
        <table class="customers" >
            <tr>
                <td colspan="5"><span>Last Cron Run at : '.date("d/m/Y H:i:s", $startTime).'</span></td>
            </tr>
            <tr>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Vendor Name </th>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Source </th>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Total </th>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Image </th>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Video </th>
                <th style="text-align: left;border: 1px solid black;" colspan="1">Certificate </th>
            </tr>
            '.$res.'
        </table>
    </body>
</html>';

	$sent2 = wp_mail($to, $subject, $html, $headers);
	//basecamp_mail($mail,$vendor,$startTime);
	//echo $html;

}

function display_message($startTime,$VendorcheckArr,$upVendorArr,$newVendorArr,$delVendorArr){
	global $wpdb;
	$endTime=time();
	$message='';
	$totaldiamonds=$wpdb->get_results("SELECT COUNT(id) as totd FROM ".$wpdb->prefix."custom_kdmdiamonds", ARRAY_A);
	$message.='Cron Start Time '.date("d/m/Y H:i:s", $startTime).'<br/>';
	$message.='Cron End Time '.date("d/m/Y H:i:s", $endTime).'<br/>';
	$message.='Total Diamonds was '.count(array_merge($VendorcheckArr,$VendorcheckArr)).'<br/>' ;
	$message.='Total updated Diamonds '.count(array_merge($upVendorArr,$upVendorArr)).'<br/>' ;
	$message.='Total Inserted Diamonds '.count(array_merge($newVendorArr,$newVendorArr)).'<br/>' ;
	$message.='Total Deleted Diamonds '.count(array_merge($delVendorArr,$delVendorArr)).'<br/>' ;
	$message.='After Import Total Diamonds '.$totaldiamonds[0]['totd'].'&nbsp;&nbsp;&nbsp;<br/>';
	$jasmsg=$message.' Import Complete';
	echo $jasmsg.'<br/>';
}

function basecamp_mail($mail,$vendor,$startTime){
	global $wpdb;
	$from      = "From: KDM <".$mail['mail_from_address'].">" . "\r\n"; 
	$subject = $mail['subject'];
	$to = array($mail['mail_to_address']);
	$endTime=   time();
	$runduration=(($startTime)-($endTime));
	
	$totaldiamonds=$wpdb->get_results("SELECT COUNT(id) as totd FROM ".$wpdb->prefix."custom_kdmdiamonds", ARRAY_A);
	
	$headers = array('Content-Type: text/html; charset=UTF-8',$from);
	//echo strtoupper($vendor).' Diamonds Updated Executed';
	$Statistics = getStatisticsDiamonds();
	$total = $total_image = $total_video = $total_certi = 0;
	$message="Last Cron Run : ".date('d/m/Y H:i:s', $startTime)."<br/>";
	foreach($Statistics as $result){
		$total +=$result->total;
		$total_image +=$result->image_count;
		$total_video +=$result->video_count;
		$total_certi +=$result->certi_count;
		$message .= "
		$result->name: $result->total<br/>
		";		
	}

	$message .= "
		Total: $total<br/>
		";

	$sent2 = wp_mail($to, $subject, $message, $headers);
	//echo $html;

}

 ?>