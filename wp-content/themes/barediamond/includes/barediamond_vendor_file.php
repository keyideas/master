<?php

if(isset($_POST['upload-zip'])) {
	$file_max_val =5000000; 
	$filename = $_FILES['pincsv']['name'];
	$file_size=$_FILES['pincsv']['size'];
	$phoen_file_name = $_FILES['pincsv']['name'];	
	$allowed =  array('csv','CSV');
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array($ext,$allowed) ) {
		$error_value = '<div class="error" id="message"><p><strong>Please Upload CSV Format</strong></p></div>';
	} elseif ($file_max_val < $file_size) {
		$error_value = '<div class="error" id="message"><p><strong>Please Upload Less Than Max Size</strong></p></div>';
	} else {
		$file_tmp = $_FILES['pincsv']['tmp_name'];
		$currendat = date('d-m-Y-h-i-s');
		$filename=$currendat."-".$filename;
		$filename = WP_CONTENT_DIR.'/diamond_uploads/barediamond/'.$filename;
		$move_uploaded_file = move_uploaded_file($file_tmp, $filename);		
		if($move_uploaded_file == 1) {
			$error_value = '<div class="updated" id="message"><p><strong>CSV Uploaded Successfully</strong></p></div>';
		} else {
			$error_value = '<div class="error" id="message"><p><strong>Something Went Wrong, Please Try Again</strong></p></div>';
		}
	}
}
?>
<div class="container">
	<div class="vender_section_wrapper">
		<form method="post" id="vendor_logout" class="text-right">
			<input type="submit" name="Logout" value="Logout" class="vender-logout-btn">
		</form>
		<div class="csv_upload_n_head text-center">
			<h1>Bare Diamonds</h1>
			<div class="upload_file_n">
				<form name="upload_zip_form" id="upload_zip_form" method="post" action="" enctype="multipart/form-data">
					<div class="labale">
						<p>Max File Size 5MB & Upload CSV Format Only</p>
					</div>
					<div class="select_files">
						<input type="file" name="pincsv" id="pincsv">
					</div>
					<?php echo $error_value ; ?>
					<div class="upload_btn_f mt-3">	
						<input type="submit" value="Upload" class="button btn" id="upload-zip" name="upload-zip" >
						<div id="cart-loader" style="display:none;"><div class="loader-gif"></div></div>
					</div>
				</form>
			</div>
		</div>
		<div class="numined_file_details text-center">
			<div class="file_details_n">
				<h3>File Uploaded Details</h3>
			</div>
			<div class="file_details">
				<ul>
					<?php
					$dir = WP_CONTENT_DIR.'/diamond_uploads/barediamond/';	
					$dir = scandir($dir,1);
					$i=1;
					foreach($dir as $key=>$file) {
						if($file!="." && $file!=".." && $file!='archives' && $file!='') {
							if($i<=10) {
								$date = implode('-', array_slice(explode('-', $file), 0, 3))."\n";
								$time = implode(':', array_slice(explode('-', $file), 3, 2))."\n";
								?>
								<li class="date_time_file_name">
									<div class="date_n"><?php echo $date ; ?></div>
									<div class="date_time"><?php echo $time ; ?></div>
									<div class="date_time_up">File Uploaded </div>
									<div class="date_time_file"> <?php echo $file; ?></div>
								</li>
								<?php
							}
							$i++;
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery("#upload-zip").on("click",function(){
		jQuery("#cart-loader").show();
	});
});
</script>