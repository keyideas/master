<?php include_once KDIPATH . '/includes/functions.php'; ?>
<div class="wrap">
	<h1>Keyideas Diamonds Master</h1>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<table class="customers wp-list-table widefat fixed striped" style="margin: 30px 0px 17px 0px;" id="Allover">
					<tr>
						<th colspan="5">Total Diamonds</th>	
					</tr>
					<tr>
						<td colspan="5">
							<span>Last Updated Statistics at : <?php echo $date = date('M d Y h:i A', time()); ?></span><button type="button" name="statisticsMail" id="statisticsMail" class="button button-primary button-large pull-right">Send Mail</button>&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<th colspan="1">Vendor Name: </th>	
						<th colspan="1">Total Diamonds In DB: </th>	
						<th colspan="1">Diamonds With Image: </th>	
						<th colspan="1">Diamonds With Video: </th>	
						<th colspan="1">Diamonds With Certificate: </th>		
					</tr>
					<?php 
					$Statistics = getStatisticsDiamonds();
					$total = $total_image = $total_video = $total_certi = 0;
					foreach($Statistics as $result){
					$total +=$result->total;
					$total_image +=$result->image_count;
					$total_video +=$result->video_count;
					$total_certi +=$result->certi_count;
						?>
					<tr>
						<td><a class="pull-right" target="_blank" href="<?=site_url( 'loose-diamonds/?vendor='.$result->vendor )?>"><?=$result->name?></a></td>
						<td><a class="pull-right" href=""><?=$result->total?></a></td>
						<td><a class="pull-right" href=""><?=$result->image_count?></a></td>
						<td><a class="pull-right" href=""><?=$result->video_count?></a></td>
						<td><a class="pull-right" href=""><?=$result->certi_count?></a></td>
					</tr>
					<?php } ?>
					<tr>
						<td><a class="pull-right" target="_blank" href="<?=site_url( 'loose-diamonds/')?>">Total</a></td>
						<td><a class="pull-right" href=""><?=$total?></a></td>
						<td><a class="pull-right" href=""><?=$total_image?></a></td>
						<td><a class="pull-right" href=""><?=$total_video?></a></td>
						<td><a class="pull-right" href=""><?=$total_certi?></a></td>
					</tr>
				</table>
			<div id="postbox-container-1" class="postbox-container">
				
				<form name="jas_frm" id="jas_frm" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="jas_submit" id="jas_submit" value="1" />
					<span class="JAS_response"><?php echo (!empty($jasmsg)?$jasmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-30" id="jasdiamonds">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From CSV <br/> 
									<span><i>(JAS)</i></span>
								</div>
								<div  class="topheadrght">
									<!--<span name="JASimport" class="button button-primary button-large pull-right" id="JAScsvimport">Import Now</span>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />-->
									<a title="Download NU Diamonds CSV" href="<?php echo site_url('/wp-json/kdm/v1/numineddiamonds'); ?>"><img class="pull-right" src="<?php echo plugins_url('../../assets/images/export-csv.png', __FILE__);?>" width="32" height="32" alt="Download NU Diamonds CSV" /></a>
									<button type="submit" name="JASimport" id="JAScsvimport" class="button button-primary button-large pull-right">Import Now</button>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />
								</div>
							</th>
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="jasabname" class="pull-right" id="jasabname" value="<?php echo $JASArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="jasshipdays" class="pull-right custwidth" id="jasshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($JASArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_below" class="pull-right" id="jas_below" value="<?php echo (!empty($JASArr['onect_below_margin_price'])?$JASArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat > 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_above" class="pull-right" id="jas_above" value="<?php echo (!empty($JASArr['onect_above_margin_price'])?$JASArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="jas_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
						
					</table>
				</form>
				<form name="qg_frm" id="qg_frm" method="post" action="" enctype="multipart/form-data">
					<span class="QG_response"><?php echo (!empty($qgmsg)?$qgmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-30" id="qgdiamond">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From API<br/> 
									<span><i>(Quality Gold)</i></span>
								</div>
								<div  class="topheadrght">
									<button name="QGimport" class="QGimport button button-primary button-large pull-right" id="QGimport">Import Now</button>
								</div>
							</th>	
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="qgabname" class="pull-right" id="qgabname" value="<?php echo $QGArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="qgshipdays" class="pull-right custwidth" id="qgshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($i==$QGArr['shipdays']?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="15%"><input type="text" name="qg_below" class="pull-right" value="<?php echo (!empty($QGArr['onect_below_margin_price'])?$QGArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat > 1.0 (CT)</td>
							<td width="15%"><input type="text" name="qg_above" class="pull-right" value="<?php echo (!empty($QGArr['onect_above_margin_price'])?$QGArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td width="100%" colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="qg_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without  Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
					</table>
				</form>
				
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<form name="nu_mainfrm" id="nu_mainfrm" method="post" action="" enctype="multipart/form-data">
					<span class="NU_response"><?php echo (!empty($numsg)?$numsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From CSV <br/> 
									<span><i>(Numined Diamonds)</i></span>
								</div>
								<div  class="topheadrght">
									<a title="Download NU Diamonds CSV" href="<?php echo site_url('/wp-json/kdm/v1/numineddiamonds'); ?>"><img class="pull-right" src="<?php echo plugins_url('../../assets/images/export-csv.png', __FILE__);?>" width="32" height="32" alt="Download NU Diamonds CSV" /></a>
									<!-- <span name="NUimport" class="button button-primary button-large pull-right" id="NUcsvimport">Import Now</span> -->
									<button type="submit" name="NUimport" id="NUcsvimport" class="button button-primary button-large pull-right">Import Now</button> &nbsp;&nbsp;
									<input type="file" name="NUcsv" class="NUimport csvupload button button-primary button-large pull-right" id="NUcsv" />
								</div>
							</th>
						</tr>
					</table>
				</form>
				<form name="nu_frm" id="nu_frm" method="post" action="" enctype="multipart/form-data">
					<table class="customers wp-list-table widefat fixed striped" id="nudiamonds">
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="nuabname" class="pull-right" id="nuabname" value="<?php echo $NUArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="nushipdays" class="pull-right custwidth" id="nushipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($NUArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="35%"><input type="text" name="nu_below" class="pull-right" id="nu_below" value="<?php echo (!empty($NUArr['onect_below_margin_price'])?$NUArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat > 1.0 (CT)</td>
							<td width="35%"><input type="text" name="nu_above" class="pull-right" id="nu_above" value="<?php echo (!empty($NUArr['onect_above_margin_price'])?$NUArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="nu_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without  Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
					</table>
				</form>
				<form name="ugld_frm" id="ugld_frm" method="post" action="" enctype="multipart/form-data">
					<span class="UGLD_response"><?php echo (!empty($ugldmsg)?$ugldmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-50" id="uglddiamond">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From CSV <br/> 
									<span><i>(Unique Lab Grown Diamond)</i></span>
								</div>
								<div  class="topheadrght">
									<span name="UGLDimport" class="button button-primary button-large pull-right" id="UGLDcsvimport">Import Now</span>&nbsp;&nbsp;
									<input type="file" name="UGLDcsv" class="UGLDimport csvupload button button-primary button-large pull-right" id="UGLDcsv" />
								</div>
							</th>
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="ugldabname" class="pull-right" id="ugldabname" value="<?php echo $ULGDArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="ugldshipdays" class="pull-right custwidth" id="ugldshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($ULGDArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="25%"><input type="text" class="pull-right" name="ugld_below" value="<?php echo (!empty($ULGDArr['onect_below_margin_price'])?$ULGDArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat > 1.0 (CT)</td>
							<td width="25%"><input type="text" class="pull-right" name="ugld_above" value="<?php echo (!empty($ULGDArr['onect_above_margin_price'])?$ULGDArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="ugld_settings" 
								id="ugld_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without  Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
						
					</table>
				</form>
				<?php /* ?>
				<form name="pd_frm" id="pd_frm" method="post" action="" enctype="multipart/form-data">
					<span class="PD_response"><?php echo (!empty($pdmsg)?$pdmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-50" id="pddiamond">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From API <br/> 
									<span><i>(Parishi Diamond)</i></span>
								</div>
								<div  class="topheadrght">
									<span name="PDimport" class="button button-primary button-large pull-right" id="PDcsvimport">Import Now</span>&nbsp;&nbsp;
									<input type="file" name="PDcsv" class="PDimport csvupload button button-primary button-large pull-right" id="PDcsv" />
								</div>
							</th>
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="pdabname" class="pull-right" id="pdabname" value="<?php echo $PDArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="pdshipdays" class="pull-right custwidth" id="pdshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($PDArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="25%"><input type="text" class="pull-right" name="pd_below" value="<?php echo (!empty($PDArr['onect_below_margin_price'])?$PDArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="65%">Margin % For Carat > 1.0 (CT)</td>
							<td width="25%"><input type="text" class="pull-right" name="pd_above" value="<?php echo (!empty($PDArr['onect_above_margin_price'])?$PDArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="pd_settings" 
								id="pd_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without  Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
					</table>
				</form>
				<?php */ ?>
				<form name="rare_frm" id="rare_frm" method="post" action="" enctype="multipart/form-data">
					<span class="RARE_response"></span>
					<table class="customers wp-list-table widefat fixed striped " id="rarediamond">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Download Diamonds CSV <br/> 
									<span><i>(Rare Carat)</i></span>
								</div>
								<div  class="topheadrght">
									<a title="Download Rare Carat Diamonds CSV" href="<?php echo site_url('wp-json/kdm/v1/rcfeed'); ?>" target="_new"><img class="pull-right" src="<?php echo plugins_url('../../assets/images/export-csv.png', __FILE__);?>" width="32" height="32" alt="Download Rare Carat Diamonds CSV" /></a>
								</div>
							</th>
						</tr>
						<tr>
							<td colspan="2">
								Send Diamonds CSV on Rare Carat
								<a class="button-primary pull-right" title="Export Rare Carat" href="#">Send Now</a>
							</td>
						</tr>
					</table>
				</form>
				<form name="jas_frm" id="jas_frm" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="jas_submit" id="jas_submit" value="1" />
					<span class="JAS_response"><?php echo (!empty($jasmsg)?$jasmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-30" id="jasdiamonds">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From CSV <br/> 
									<span><i>(Meylor)</i></span>
								</div>
								<div  class="topheadrght">
									<!--<span name="JASimport" class="button button-primary button-large pull-right" id="JAScsvimport">Import Now</span>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />-->
									<a title="Download NU Diamonds CSV" href="<?php echo site_url('/wp-json/kdm/v1/numineddiamonds'); ?>"><img class="pull-right" src="<?php echo plugins_url('../../assets/images/export-csv.png', __FILE__);?>" width="32" height="32" alt="Download NU Diamonds CSV" /></a>
									<button type="submit" name="JASimport" id="JAScsvimport" class="button button-primary button-large pull-right">Import Now</button>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />
								</div>
							</th>
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="jasabname" class="pull-right" id="jasabname" value="<?php echo $JASArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="jasshipdays" class="pull-right custwidth" id="jasshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($JASArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_below" class="pull-right" id="jas_below" value="<?php echo (!empty($JASArr['onect_below_margin_price'])?$JASArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat > 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_above" class="pull-right" id="jas_above" value="<?php echo (!empty($JASArr['onect_above_margin_price'])?$JASArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="jas_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
						
					</table>
				</form>
				<form name="jas_frm" id="jas_frm" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="jas_submit" id="jas_submit" value="1" />
					<span class="JAS_response"><?php echo (!empty($jasmsg)?$jasmsg:'');?></span>
					<table class="customers wp-list-table widefat fixed striped margin-bottom-30" id="jasdiamonds">
						<tr>
							<th colspan="2">
								<div class="topheadlft">Import Diamonds From CSV <br/> 
									<span><i>(GREENROCK)</i></span>
								</div>
								<div  class="topheadrght">
									<!--<span name="JASimport" class="button button-primary button-large pull-right" id="JAScsvimport">Import Now</span>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />-->
									<a title="Download NU Diamonds CSV" href="<?php echo site_url('/wp-json/kdm/v1/numineddiamonds'); ?>"><img class="pull-right" src="<?php echo plugins_url('../../assets/images/export-csv.png', __FILE__);?>" width="32" height="32" alt="Download NU Diamonds CSV" /></a>
									<button type="submit" name="JASimport" id="JAScsvimport" class="button button-primary button-large pull-right">Import Now</button>&nbsp;&nbsp;
									<input type="file" name="JAScsv" class="JASimport csvupload button button-primary button-large pull-right" id="JAScsv" />
								</div>
							</th>
						</tr>
						<tr>
							<td width="85%">Vendor Code</td>
							<td width="15%"><input type="text" name="jasabname" class="pull-right" id="jasabname" value="<?php echo $JASArr['abbreviation'];?>"></td>
						</tr>
						<tr>
							<td width="85%">Shipping Days</td>
							<td width="15%">
								<select name="jasshipdays" class="pull-right custwidth" id="jasshipdays">
									<option value="">Days</option>
									<?php 
										for($i = 0; $i <= 30; $i++){
											echo '<option value="'.$i.'" '.($JASArr['shipdays']==$i?'selected="selected"':'').'>'.$i.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat <= 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_below" class="pull-right" id="jas_below" value="<?php echo (!empty($JASArr['onect_below_margin_price'])?$JASArr['onect_below_margin_price']:'35');?>"></td>
						</tr>
						<tr>
							<td width="85%">Margin % For Carat > 1.0 (CT)</td>
							<td width="15%"><input type="text" name="jas_above" class="pull-right" id="jas_above" value="<?php echo (!empty($JASArr['onect_above_margin_price'])?$JASArr['onect_above_margin_price']:'22');?>"></td>
						</tr>
						<tr>
							<td colspan="2" class="kdiactions">
								<input type="submit" class="button button-primary button-large pull-right custwidth" name="jas_settings" value="Save">
							</td>
						</tr>
						<tr class="pricerow">
							<td colspan="2">
								<span>Run Price Scheduler<input type="submit" class="button button-primary button-large " name="update_qg_price" value="Now"> Or Later (Next cron run in)  4 hours 30 mins</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span>Last Import Diamonds Statistics at : <?php echo $date = date('M d Y h:i:s A', time()); ?></span>
							</td>
						</tr>
						<tr>
							<td><span>Diamonds With Image : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Image : </span><a class="pull-right" href="">100</a></td>
						</tr>
						<tr>
							<td><span>Diamonds With Video Link : </span><a class="pull-right" href="">4096</a></td>
							<td><span>Diamonds Without Video Link : </span><a class="pull-right" href="">100</a></td>
						</tr>
						
					</table>
				</form>
				<table class="customers wp-list-table widefat fixed striped " id="dsdiamond" style="margin-top:30px;">
					<tr>
						<th colspan="2">
							<div class="topheadlft">JSON FEEDS <br/> 
								<span><i>(DS)</i></span>
							</div>
							<div  class="topheadrght">
								<a title="DS Json Feeds" href="<?php echo site_url(); ?>/wp-json/kdm/v1/dsfeed?disable=<?php echo time();?>" target="_new">Click Here</a>
							</div>
						</th>
					</tr>
				</table>
				
			</div>
		</div>
	</div>
</div>