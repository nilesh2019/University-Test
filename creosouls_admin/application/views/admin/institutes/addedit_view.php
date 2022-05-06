<style>
	.label-wrapper
	{
		text-align: left;
	}
	.requiredClass
	{
		color: red;
	}
</style>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header vd_bg-blue vd_white">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">
					<i class="fa fa-times">
					</i>
				</button>
				<h4 id="myModalLabel" class="modal-title">
					Register Institute
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="instituteRegistrationForm" enctype="multipart/form-data" action="#" role="form" method="post">
					<div class="alert alert-danger vd_hidden">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							<i class="icon-cross">
							</i>
						</button>
						<span class="vd_alert-icon">
							<i class="fa fa-exclamation-circle vd_red">
							</i>
						</span>
						<strong>
							Oh snap!
						</strong> Please correct following errors and try submiting it again.
					</div>
					<div class="alert alert-success vd_hidden">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							<i class="icon-cross">
							</i>
						</button>
						<span class="vd_alert-icon">
							<i class="fa fa-check-circle vd_green">
							</i>
						</span>
						<strong>
							Well done!
						</strong>.
					</div>
					<div id="instituteFormFields" class="form-group  mgbt-xs-20">
						<div class="col-md-12">		

						<div class="label-wrapper ">
							<label class="control-label">
								Zone 
							</label> (
							<span class="requiredClass">
								*
							</span>)
						</div>

						<?php  $CI =& get_instance();
						$CI->load->model('modelbasic');
						if($this->session->userdata('admin_level') == 1){
							$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');
											
						}
						if($this->session->userdata('admin_level') == 4){
														
							$zoneListId = $CI->modelbasic->getInstituteZone();
							$zoneid = $zoneListId[0];
							$zoneList = $CI->modelbasic->getSelectedData('zone_list','*',array('id'=>$zoneid));
														
						}  
						if($this->session->userdata('admin_level') == 2){
							$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');
												  		
						}
						?>
						<div class="vd_input-wrapper light-theme">
							<select class="ui dropdown" name="zone" id="zone" onchange="getRegionList(this)">
							  <option value="">Select Zone</option>
							  <?php if(!empty($zoneList))
							  {	
							  	foreach($zoneList as $Zlist){  ?>
							  	<option value="<?php echo $Zlist['id'];?>"><?php echo $Zlist['zone_name'];?></option>
							 <?php 	} 
							  }?>
							</select>
						</div>
						<br/>

						<div class="label-wrapper ">
							<label class="control-label">
								Region 
							</label> (
							<span class="requiredClass">
								*
							</span>)
						</div>
						<div class="vd_input-wrapper light-theme">
							<select class="ui dropdown" name="region" id="region">
							  <option value="">Select Region</option>								
							</select>
						</div>
						<br/>
							
							<div class="label-wrapper ">
								<label class="control-label" for="instituteName">
									Institute Name
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper">
								<span class="menu-icon">
									<i class="fa fa-university">
									</i>
								</span>
								<input type="text" placeholder="Institute Name" id="instituteName" name="instituteName" class="required">
							</div>
							<br/>
							<div class="label-wrapper ">
								<label class="control-label" for="sap_center_code">
									SAP Center Code
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="sap_center_code-input-wrapper">
								<span class="menu-icon">
									<i class="fa fa-barcode">
									</i>
								</span>
								<input type="text" placeholder="SAP Center Code" id="sap_center_code" name="sap_center_code" class="required">
							</div>
							<br/>

							<div class="label-wrapper ">
								<label class="control-label" for="pageName">
									Page display name
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class=" col-md-12" style="padding: 0px !important">

								<div class="col-md-6" style="line-height: 42px; padding: 0px ! important; float: left; text-align: right; font-weight: bold; font-size: 14px; color: rgb(12, 153, 213); background: rgb(204, 204, 204) none repeat scroll 0% 0%;">
									<?php echo front_base_url();?>
								</div>
								<div class="col-md-6" style="padding: 0px !important;text-align:left;">
									<div class="vd_input-wrapper light-theme" id="pageName-input-wrapper">
										<!--   <span class="menu-icon"> <i class="fa fa-university"></i> </span> -->
										<input style="padding-left: 5px !important" type="text" placeholder="Institute page display name" id="pageName" name="pageName" class="required">
									</div>
								</div>

							</div>

							<br/>
							<div class="label-wrapper">
								<label class="control-label " for="adminEmail">
									Admin Email
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="adminEmail-input-wrapper" >
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<input type="text" placeholder="Try typing 'Admin Email'" autocomplete="off" id="adminEmail" name="adminEmail" class="required">
							</div>
							<br/>
							<input type="hidden" id="adminId" name="adminId">
							<div class="label-wrapper">
								<label class="control-label " for="address">
									Institute Address
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="address-input-wrapper" >
								<span class="menu-icon">
									<i class="icon-location">
									</i>
								</span>
								<input type="text" placeholder="Institute Address" id="address" name="address" class="required">
							</div>
							<br/>
							<div class="label-wrapper">
								<label class="control-label " for="contactNo">
									Contact No
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="contactNo-input-wrapper" >
								<span class="menu-icon">
									<i class="fa fa-phone">
									</i>
								</span>
								<input type="text" placeholder="Contact No" id="contactNo" name="contactNo" class="required">
							</div>
							<br/>
							<!--<div class="label-wrapper">
								<label class="control-label " for="instituteLogo">
									Institute Logo
								</label>
							</div>
							<div class="vd_input-wrapper light-theme" id="instituteLogo-input-wrapper" >
								<span class="menu-icon">
								</span>
								<input onchange="readURL(this)" type="file" placeholder="Institute Logo image." id="instituteLogo" name="instituteLogo">
								<span style="color: green; float: left;">
									(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB)
								</span>
								<br/>
								<img width="100" height="100" class="preview" id="logoPreview" src="#" alt="" />
							</div>
							<br/>

							<div class="label-wrapper">
								<label class="control-label " for="coverImage">
									Cover Picture
								</label>
							</div>
							<div class="vd_input-wrapper light-theme" id="coverImage-input-wrapper" >
								<span class="menu-icon">
								</span>
								<input onchange="readURL(this)" type="file" placeholder="Cover Picture image." id="coverImage" name="coverImage">
								<span style="color: green; float: left;">
									(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB (1300 W * 260 H))
								</span>
								<br/>
								<img class="preview" width="1000" height="115" id="coverPreview" src="#" alt="" />
							</div>-->
							<br/>
							<?php if($this->session->userdata('admin_level')==1 || $this->session->userdata('admin_level')==4){?>
							<div class="label-wrapper">
								<label class="control-label " for="csvUsers">
									Import Users
								</label>
							</div>
							<div class="vd_input-wrapper light-theme" id="csvUsers-input-wrapper" >
								<span class="menu-icon">
								</span>
								<input type="file" placeholder="Cover Picture image." id="csvUsers" name="csvUsers">
								<span style="color: green; float: left;">
									(Note:- Allowed file types " csv ", Allowed size 2MB)
								</span>
								<a style="" class="btn btn-primary" href="<?php echo front_base_url();?>assets/sample.csv">
									sample csv
								</a>
							</div>
							<?php } ?>
						</div>
					</div>
					<div id="vd_login-error" class="alert alert-danger hidden">
						<i class="fa fa-exclamation-circle fa-fw">
						</i>Please fill the necessary field
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center mgbt-xs-5">
							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="institute-submit">
								Submit
							</button>
						</div>
						<input type="hidden" name="instituteId" id="instituteId">
					</div>
				</form>
			</div>
			<!--      <div class="modal-footer background-login">
			<button data-dismiss="modal" class="btn vd_btn vd_bg-grey" type="button">Close</button>
			<button class="btn vd_btn vd_bg-green" type="button">Save changes</button>
			</div> -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
