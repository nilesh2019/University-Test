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

					Add New Placement Details

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

						<?php if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 5)
						{
						?>

						<!--<div class="label-wrapper ">
							<label class="control-label">Zone </label> 
							(<span class="requiredClass">
								*
							</span>)
						</div>
						<?php  $CI =& get_instance();
						$CI->load->model('modelbasic');
						$zoneList = $CI->modelbasic->getSelectedData('zone_list','*');  ?>
						<div class="vd_input-wrapper light-theme">
							<select class="form-control" name="zone" id="zone" onclick="getRegionList(this)">
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
							<select id="region" name="region" class="form-control" onclick="getInstituteList(this)">
							    <option value="">Select Region</option>	
							</select>
						</div>
						<br/>
						<div class="label-wrapper ">
							<label class="control-label" for="groupName">Institute</label>
						</div>
						<div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
						    <select  class="form-control" name="institute" id="institute" onclick="getStudentList(this)">
						    	<option value="" >Select Institute</option>
						    </select>
						</div>
					
						</br>
						<div class="label-wrapper ">
						  <label class="control-label" for="groupName">Student</label>
						</div>
						<div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
						    <select  class="form-control" name="student" id="student">
						    	<option value="" >Select Students</option>
						    </select>
						</div>
						
						</br>-->
						<?php }?>
						<div class="label-wrapper ">
							<label class="control-label" for="title">
							Student Name
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
							<input type="text" placeholder="Student Full Name" id="student_name" name="student_name" class="required">
						</div>
						<br/>
						<div class="label-wrapper ">
							<label class="control-label" for="title">
							Company Name
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
							<input type="text" placeholder="Company Name" id="company" name="company" class="required">
						</div>
						<br/>
					
						<div class="label-wrapper">
							<label class="control-label" for="position">
								Job Profile
							</label> (
							<span class="requiredClass">
								*
							</span>)
						</div>
						<div class="vd_input-wrapper light-theme" id="position-input-wrapper" >
							<span class="menu-icon">

									<i class="fa fa-envelope">
									</i>
								</span>
								<input type="text" placeholder="Position" id="position" name="position" class="required">

						</div>
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
							<textarea id="wysiwyghtml" name="description" class="width-100 form-control"  rows="7" placeholder="Write your message here"></textarea>
						</div>
						<div class="label-wrapper">
						  <label class="control-label " for="studentProfile">Student Profile (<span class="requiredClass"> * </span>) </label>
						</div>
						<div class="vd_input-wrapper light-theme" id="studentProfile-input-wrapper" > <span class="menu-icon"></span>
						  <input onchange="readURL(this)" type="file" placeholder="Student profile image." id="profile_image" name="profile_image">
						  <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB (Recommended size for best view 200 W * 200 H))</span>
						  <br/>
						  <img width="100" height="100" class="preview" id="logoPreview" src="#" alt="" />
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

							<button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="login-submit">

								Submit

							</button>

						</div>
					</div>

					<input type="hidden" name="placementId" id="placementId">

				</form>

			</div>


		</div>

		<!-- /.modal-content -->

	</div>

	<!-- /.modal-dialog -->

</div>

