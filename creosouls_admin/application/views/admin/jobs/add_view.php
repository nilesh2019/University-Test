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

					Add New Job

				</h4>

			</div>

			<div class="modal-body">

				<form class="form-horizontal" id="login-form" enctype="multipart/form-data" action="#" role="form" method="post">

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

					

					<div id="jobFormFields" class="form-group  mgbt-xs-20">

						<div class="col-md-12">

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
						<!-- <div class="label-wrapper ">
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
						<br/> -->

					 <div class="label-wrapper ">
							<label class="control-label" for="groupName">Region</label>
						</div>
						<div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
							 <select id="region" name="region[]" multiple="multiple" class="form-control">
						     <option value="">Select Region</option>	
						    </select>
						</div>
						<br/>

					<?php } else  if($this->session->userdata('admin_level') == 4)
					{
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
								<select id="region" name="region[]" multiple="multiple" class="form-control">
								     <option value="" >Select Region</option>	
								      <?php if(!empty($getHoAdminInfoRegion))
								      {	
								      	foreach($getHoAdminInfoRegion as $region){  ?>
								      	<option value="<?php echo $region['region'];?>" ><?php echo $region['region_name'];?></option>
								     <?php 	} 
								      }?>
								</select>
							</div>
							<br/>
						<?php } ?>
							<div class="label-wrapper ">
								<label class="control-label" for="title">
									Job Title
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="title-input-wrapper">
								<span class="menu-icon">
									<i class="fa fa-envelope">
									</i>
								</span>
								<input type="text" placeholder="Job Title" id="title" name="title" class="required">
							</div>

							<br/>
							<div class="label-wrapper ">
								<label class="control-label" for="title">
									Job Type
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="title-input-wrapper">
								<select id="job_type" name="job_type" class="form-control">
								     <option value="" >Select Type</option>	
								     <option value="0">Job</option>
								     <option value="1">Internship</option>
								</select>
							</div>
							<br/>
							<div class="label-wrapper">
								<label class="control-label" for="location">
									Job Location
								</label> (
								<span class="requiredClass">
									*
								</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="location-input-wrapper" >

								<span class="menu-icon">

									<i class="icon-location">
									</i>
								</span>
								<input type="text" placeholder="Location" id="location" name="location" class="required">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="type">

									Employment Type 

								</label> (

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="type-input-wrapper" >

								<span class="menu-icon">

									<i class="fa fa-tasks">

									</i>

								</span>

								<input type="text" placeholder="eg . Part Time/Full Time" id="type" name="type" class="required">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="close_on">

									Job Closes On

								</label> (

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="close_on-input-wrapper" >

								<span class="menu-icon">

									<i class="fa fa-calendar">

									</i>

								</span>

								<input type="text" placeholder="Job Closes On Date." id="datepicker-normal" readonly="true" name="close_on" class="required">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="key_skills">

									Key Skills

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="key_skills-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Enter skills list.(i.e.HTML,Photoshope)" id="key_skills" name="key_skills" class="required">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="education">

									Education

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="education-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Enter required education." id="education" name="education" class="required">

							</div>

							<br/>

							<div class="label-wrapper">
								<label class="control-label " for="min_experience">
								 Min Experience
								</label>(<span class="requiredClass">*</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="min_experience-input-wrapper">
								
								<select name="min_experience" id="min_experience"  class="required">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
								</select>
								
							</div>
							<br/>
							
							<div class="label-wrapper">
								<label class="control-label " for="max_experience">
								  Max Experience
								</label>(<span class="requiredClass">*</span>)
							</div>
							<div class="vd_input-wrapper light-theme" id="max_experience-input-wrapper">
								
								<select name="max_experience" id="max_experience"  >
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
								</select></div>
							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="noOfPosition">

									No of Positions

								</label>

							</div>

							<div class="vd_input-wrapper light-theme" id="noOfPosition-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Enter job No of Positions." id="noOfPosition" name="no_of_position">

							</div>

							<br/>


							<div class="label-wrapper">

								<label class="control-label " for="function">

									Function

								</label>

							</div>

							<div class="vd_input-wrapper light-theme" id="function-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Enter job function.(i.e sales)" id="function" name="function">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="industry">

									Industry

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="industry-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Enter industries list(i.e.IT,Real Estate)." id="industry" name="industry" class="required">

							</div>

							<br/>
							<?php if($this->session->userdata('admin_level')==2){?>
							<div class="label-wrapper">

								<label class="control-label " for="jobStatus">

									Job Status

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="jobStatus-input-wrapper">
								<input type="radio" id="jobStatus1" name="jobStatus" value="0" checked>Open For All
								<input type="radio" id="jobStatus2" name="jobStatus" value="1" >Institute Only
							</div>

							<br/>
							<?php }?>

							<?php if($this->session->userdata('admin_level')==4){?>
							<div class="label-wrapper">
								<label class="control-label " for="jobStatus">
									Job Status
								</label>
							</div>
							<div class="vd_input-wrapper light-theme" id="jobStatus-input-wrapper">
								<input type="checkbox" id="jobStatus1" name="jobStatus" value="0" >Open For All								
							</div>
							<br/>
							<?php }?>

							<div class="label-wrapper">

								<label class="control-label " for="company_name">

									Company Name

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="cname-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Company Name" id="company_name" name="company_name" class="required">

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="company_name">

									Recruiter Email Id

								</label>(

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme" id="recruiter_email_id-input-wrapper">

								<span class="menu-icon">

									<i class="fa fa-envelope">

									</i>

								</span>

								<input type="text" placeholder="Recruiter Email Id" id="recruiter_email_id" name="recruiter_email_id" class="required">

							</div>

							</br>

							<div class="label-wrapper">

								<label class="control-label " for="logo">

									Company Logo

								</label>

							</div>

							<div class="vd_input-wrapper light-theme" id="logo-input-wrapper" >

								<span class="menu-icon">

								</span>

								<input type="file" placeholder="Logo image." id="logo" name="logo">

								<span style="color: green; float: left;">

									(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB)

								</span>

								<img width="200" height="200" id="logoPreview" src="#" alt="" />

							</div>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="about_company">

									About Company

								</label>

							</div>

							<div class="vd_input-wrapper light-theme" id="about_company-input-wrapper">								

								<textarea placeholder="Enter details" id="about_company" name="about_company"></textarea>

							</div>

							<br/>

							<br/>

							<div class="label-wrapper">

								<label class="control-label " for="description">

									Description

								</label> (

								<span class="requiredClass">

									*

								</span>)

							</div>

							<div class="vd_input-wrapper light-theme">

								<textarea id="wysiwyghtml" name="description" class="width-100 form-control"  rows="15" placeholder="Write your message here"></textarea>

							</div>

						</div>

					</div>

					<div id="vd_login-error" class="alert alert-danger hidden">

						<i class="fa fa-exclamation-circle fa-fw">

						</i>Please fill the necessary field

					</div>

					<div class="form-group">

						<div class="col-md-12 text-center mgbt-xs-5">

							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="login-submit">

								Submit

							</button>

						</div>

						<input type="hidden" name="jobId" id="jobId">

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

