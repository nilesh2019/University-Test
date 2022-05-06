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
					Register Group
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="groupRegistrationForm" enctype="multipart/form-data" action="#" role="form" method="post">
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
							$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');  ?>
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
								<select class="ui dropdown" name="region" id="region" onchange="getInstituteList(this)">
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
							<div class="vd_input-wrapper light-theme">
								<select class="ui dropdown" name="instituteId" id="instituteId" onchange="getUserList(this)">
								  <option value="">Select Institute</option>								
								</select>
							</div>
							<br/>
							
							<div class="label-wrapper ">
								<label class="control-label" for="groupName">
									Group Name
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="groupName-input-wrapper">
								<span class="menu-icon">
									<i class="fa fa-university">
									</i>
								</span>
								<input type="text" placeholder="Group Name" id="group_name" name="group_name" class="required">
							</div>
							<br/>	

							<div class="label-wrapper ">
								<label class="control-label" for="groupName">Select users</label> (<span class="requiredClass">*</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="selectUsers-input-wrapper">
								 <select id="selectUsers" name="selectUsers[]" multiple="multiple" class="form-control">
							     <option value="">Select Users</option>	
							    </select>
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
							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="group-submit">
								Submit
							</button>
						</div>
						<input type="hidden" name="groupId" id="groupId">
					</div>
				</form>
			</div>		
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
