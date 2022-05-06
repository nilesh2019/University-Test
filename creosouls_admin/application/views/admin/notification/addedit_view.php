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
					Register notification
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="notificationRegistrationForm" enctype="multipart/form-data" action="#" role="form" method="post">
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
								<label class="control-label" for="groupName">select</label>
							</div>
							<div class="vd_input-wrapper light-theme" id="check-input-wrapper">
								<input type="checkbox" name="notification_ckeck" value="1" checked> Notifications
								<input type="checkbox" name="email_ckeck" value="2"> Email
							</div>
							<br/>

							 <div class="label-wrapper ">
									<label class="control-label" for="groupName">Link</label>
								</div>
								<div class="vd_input-wrapper light-theme" id="check-input-wrapper">
									<input type="text" name="link" value="" /> 
									
								</div>
								<br/>
								<?php if($this->session->userdata('admin_level') == 1)
								{
									?>

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
										$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');  ?>
										<div class="vd_input-wrapper light-theme">
											<select multiple="multiple" class="form-control" name="zone[]" id="zone" onclick="getRegionList(this)">
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
												<label class="control-label" for="groupName">Region</label>
											</div>
											<div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
												 <select id="region" name="region[]" multiple="multiple" class="form-control" onclick="getInstituteList(this)">
											     <option value="">Select Zone</option>	
											    </select>
											</div>
											<br/>
									<div class="label-wrapper ">
										<label class="control-label" for="instituteName">Institute Name</label> 
									
									</div>
									<div class="vd_input-wrapper light-theme">
										<select  multiple="multiple" class="form-control" name="instituteId[]" id="instituteId" onclick="getGroupList(this)">
										  <option value="">Select Institute</option>								
										</select>
									</div>
									<br/>

									<div class="label-wrapper ">
										<label class="control-label" for="groupName">Group Name</label> 
									
									</div>
									<div class="vd_input-wrapper light-theme">
										<select multiple="multiple" class="form-control" name="groupId[]" id="groupId">
										  <option value="">Select Group</option>								
										</select>
									</div>
									<br/>

							<?php 
							} 
								else if($this->session->userdata('admin_level') == 4)
								{
									?>


									<?php


										$hoadmin_id=$this->session->userdata('admin_id');
										$CI =& get_instance();
										$CI->load->model('modelbasic');
										$getHoAdminInfoRegion = $this->db->select('A.region,B.region_name')->from('hoadmin_institute_relation as A')->join('region_list as B','B.id=A.region')->where('A.hoadmin_id',$hoadmin_id)->group_by('A.region')->get()->result_array();
										$getHoAdminInfoZone = $this->db->select('zone')->from('hoadmin_institute_relation')->where('hoadmin_id',$hoadmin_id)->group_by('zone')->get()->row_array();

										//print_r($getHoAdminInfoRegion);
										//print_r($getHoAdminInfoZone);die;
										?>

									<div class="label-wrapper ">
												<label class="control-label">
													Zone 
												</label> (
												<span class="requiredClass">
													*
												</span>)
											</div>
											<?php  
											$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');  ?>
											<div class="vd_input-wrapper light-theme">
												<select multiple="multiple" class="form-control" name="zone[]" id="zone" >
												  <option value="" disabled="">Select Zone</option>
												  <?php if(!empty($zoneList))
												  {	
												  	foreach($zoneList as $Zlist){  ?>
												  	<option value="<?php echo $Zlist['id'];?>" <?php if($getHoAdminInfoZone['zone'] !=  $Zlist['id'] ){ echo "disabled=''";}else{ echo"selected";}?>><?php echo $Zlist['zone_name'];?></option>
												 <?php 	} 
												  }?>
												</select>
											</div>
											<br/>	
										 <div class="label-wrapper ">
												<label class="control-label" for="groupName">Region</label>
											</div>
											<div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
											<select id="region" name="region[]" multiple="multiple" class="form-control" onclick="getInstituteList(this)">
											     <option value="" selected="">Select Region</option>	
											      <?php if(!empty($getHoAdminInfoRegion))
											      {	
											      	foreach($getHoAdminInfoRegion as $region){  ?>
											      	<option value="<?php echo $region['region'];?>" ><?php echo $region['region_name'];?></option>
											     <?php 	} 
											      }?>

											    </select>
											</div>
											<br/>									
									<div class="label-wrapper ">
										<label class="control-label" for="instituteName">Institute Name</label> 
									
									</div>
									<div class="vd_input-wrapper light-theme">
										<select  multiple="multiple" class="form-control" name="instituteId[]" id="instituteId" onclick="getGroupList(this)">
										  <option value="">Select Institute</option>								
										</select>
									</div>
									<br/>

									<div class="label-wrapper ">
										<label class="control-label" for="groupName">Group Name</label> 
									
									</div>
									<div class="vd_input-wrapper light-theme">
										<select multiple="multiple" class="form-control" name="groupId[]" id="groupId">
										  <option value="">Select Group</option>								
										</select>
									</div>
									<br/>

							<?php 
							} 
							else
							{
									$CI =& get_instance();
									$CI->load->model('modelbasic');
									$instituteId = $this->session->userdata('instituteId');
									$instituteGroupData=$CI->modelbasic->getSelectedData('group_master','id,group_name',array('institute_id'=>$instituteId));
									 ?>

									<div class="label-wrapper ">
										<label class="control-label" for="groupName">Group Name</label> 
									
									</div>
									<div class="vd_input-wrapper light-theme">
										<select multiple="multiple" class="form-control" name="groupId[]" id="groupId" required>
										<option value="">Select Group</option>	
										<?php 	if(!empty($instituteGroupData))
										{
											foreach($instituteGroupData as $instituteGroupDatavalue)
											{
												?>
												<option value="<?php echo $instituteGroupDatavalue['id'];?>"><?php echo $instituteGroupDatavalue['group_name'];?> </option>
												<?php
											}
										} 
										?>								 							
										</select>
									</div>
									<br/>

							<?php
							  }    ?>
							
							<div class="label-wrapper ">
								<label class="control-label" for="groupName">
									Notification
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="notificationName-input-wrapper">							
								<textarea id="notification" name="notification" class="required"></textarea>								
							</div>
							<br/>
						</div>
					</div>
					<div id="vd_login-error" class="alert alert-danger hidden">
						<i class="fa fa-exclamation-circle fa-fw">
						</i>Please fill the necessary field
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center mgbt-xs-5">
							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="notification-submit">
								Submit
							</button>
						</div>
						<input type="hidden" name="notificationId" id="notificationId">
					</div>
				</form>
			</div>		
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
