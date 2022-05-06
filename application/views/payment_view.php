<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/formValidation.min.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/percircle.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/toggle.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/countdown/jquery.countdown.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/percircle.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/jquery.countdown.js"></script>
<style>
	textarea { resize: vertical; }
	.bootstrap-tagsinput {
	width: 100%;
	line-height:2.2 !important;
	}
	.bootstrap-tagsinput .tag
	{
		font-size: 14px;
		padding: 5px;
		font-weight: bold;
	}
	.form-control-feedback{
		width: 0px !important;
	}
	.deleteSkill{
		position:relative;font-size:10px;cursor:pointer;left: 15px;float: right;
	}
	.small{
		margin-right: 3%;
	}
	/*	.help-block{
		margin: -56px 0px 0px 100px !important;
	}*/
	.subscription {
	color: #57ba2c;
	font-size: 16px;
	font-weight: bold;
	margin-bottom:5px;
	}
	.orderDetails{
		background: #000 none repeat scroll 0 0;
	    	left: 25%;
	    	position: relative;
	   	top: 5%;
	   	color: #fff;
	   	width: 50%;
	   	font-size: 14px;
	}
	.orderDetails .panel-heading{
		background: #000;
		color: #fff;
	}
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<div class="clearfix"></div>
<div class="middle_my_profile">
		<div id="img_div" class="col-lg-3  portfolio-left" style="padding:0">
			<div class="fix_content mCustomScrollbar light" id="content-2" data-mcs-theme="minimal-dark"">
				<div class="profile_photo">
					<form id="imageForm" method="post">
						<div class="box">
							<?php $profileCompletion=0;
							$profileImage = $user_profile->profileImage;
							if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)
							{
							$profileCompletion=10;
							?>
							
							<img id="OpenImgUpload_new" class="" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>"/>
							<?php }else{?>
							<img id="OpenImgUpload_new" class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />
							<?php }?>
							<input type="file" accept="image/jpeg" style="display:none;"  id="image" name="image"/>
							<div class="product-overlay">
								<div class=" overlay-content">
									<a href="javascript:void(0);" id="OpenImgUpload"><i class="fa fa-pencil"></i> Change</a>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php
				$ci= &get_instance();
				$ci->load->model('user_model');
				$admin_data = $ci->user_model->check_admin_or_not();
				?>
				<div class="timeline">
					<h4>
					<a href="#basic_info" class="scroll">
						Basic Information
					</a>
					</h4>
					<h4>
					<a href="#work_exp" class="scroll">
						Work Experience
					</a>
					</h4>
					<h4>
					<a href="#education" class="scroll">
						Education
					</a>
					</h4>
					<h4>
					<a href="#OnTheWeb" class="scroll">
						On the Web
					</a>
					</h4>
					<h4>
					<a href="#award" class="scroll">
						Award
					</a>
					</h4>
					<?php if($this->session->userdata('user_institute_id') !=''){ ?>
					<h4>
					<a href="<?php echo base_url();?>profile/submitFeedback" class="scroll">
						Feedback
					</a>
					</h4>
					<h4>
					<a href="#" data-toggle="modal" data-target="#googleDriveSetting">
						Google Drive Setting
					</a>
					</h4>
					<?php } ?>
					<?php //print_r($user_profile);
					//print_r($admin_data);
					if(!empty($admin_data))
					{
					?>
					<h4>
					<a href="#flag_status" class="scroll">
						Monitor Flag
					</a>
					</h4>
					<h4>
					<a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($admin_data[0]['pageName']));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">Manage Institute Data</a>
					</h4>
					<?php } if($user_profile->type==2 && $user_profile->company!=''){?>
					<h4>
					<a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($this->session->userdata('user_company_name')));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>/<?php echo urlencode(base64_encode($this->session->userdata('user_type')));?>">Manage Jobs Data</a>
					</h4>
					<?php }?>

	<?php
	if($user_profile->firstName!='' && $user_profile->lastName!='')
	{
	$profileCompletion = $profileCompletion+15;
	}
	if($user_profile->city!='' && $user_profile->country!='')
	{
	$profileCompletion = $profileCompletion+15;
	}
	if($user_profile->profession!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	if($user_profile->webSiteURL!='')
	{
	$profileCompletion = $profileCompletion+0;
	}
	if($user_profile->about_me!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	if($user_profile->skills!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	?>

	<?php
	if(isset($socialData['facebook']) && $socialData['facebook']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	elseif(isset($socialData['twitter']) && $socialData['twitter']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	elseif(isset($socialData['google']) && $socialData['google']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	elseif(isset($socialData['pinterest']) && $socialData['pinterest']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	elseif(isset($socialData['instagram']) && $socialData['instagram']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}
	elseif(isset($socialData['linkedin']) && $socialData['linkedin']!='')
	{
	$profileCompletion = $profileCompletion+10;
	}

	if(!empty($educationData))
	{
	$profileCompletion = $profileCompletion+10;
	}

	if(!empty($skillsData))
	{
	  $profileCompletion = $profileCompletion+10;
	}

	if(!empty($workData))
	{
	  $profileCompletion = $profileCompletion+10;
	}
	?>



				</div>
				<div class="Lhs_content content44" id="Lhs_content">
					<div class="profile_complation">
						<h4>
						Profile Completion Meter (<?php echo $profileCompletion;?>%)
						</h4>
						<div class="progress">
							<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $profileCompletion;?>%">
								<span class="sr-only">
									<?php echo $profileCompletion;?>% Complete
								</span>
							</div>
						</div>
						<p>
							Complete your profile to get more  noticed. People will know you better.
						</p>
					</div>
					<div class="counter_mtr">
						<?php
						$ci->load->model('stream_model');
						$ci->load->model('user_model');
						$followingUserData = $ci->stream_model->getFollowingUserData($this->session->userdata('front_user_id'));
						$appreciated=$ci->user_model->getUserLikedOnProject();
						?>
						<span>
							<?php
							if(!empty($followingUserData))
							{
							echo count($followingUserData);
							}
							else
							{
							echo '0';
							}
							?>
						</span>
						<p>
							follower(s).
						</p>
						<span>
							<?php
							if(!empty($appreciated))
							{
							echo count($appreciated);
							}
							else
							{
							echo '0';
							}
							?>
						</span>
						<p>
							<?php
							if(!empty($appreciated))
							{
							echo "Project(s) appreciated.";
							}
							else
							{
							echo "You have not appreciated other's work.";
							}
							?>
						</p>
					</div>
					<div class="project-info">
						<p>
							More you have information on your projects more you get noticed
						</p><br>
						<p>
							Following other people and appreciating their work will increase your online presence.
						</p>
						<div class="view_all mid_content">
							<a href="<?php echo base_url()?>all_project">
								<span>go to explore</span>
							</a>
						</div>
					</div>
				
						<?php
					$ci= &get_instance();
					$ci->load->model('model_basic');
					$csvuserId = $ci->model_basic->getValue('institute_csv_users','id'," `email` = '".$user_profile->email."' and `status`=1");
					//echo $csvuserId;die;
					if(isset($csvuserId) && $csvuserId > 0)
					{
					$end_date = $ci->model_basic->getValue('student_membership','end_date'," `csvuserId` = '".$csvuserId."'");
					$start_date = $ci->model_basic->getValue('student_membership','start_date'," `csvuserId` = '".$csvuserId."'");
					if(isset($end_date))
					{
					$date=strtotime($end_date);
					$difference=$date-time();
					}
					}
					if(isset($difference) && $difference > 1)
					{
					?>
						<div class="countdown">
					<div>
						<div class="subscription">Registration Date: <span ><?php echo date('d M, Y',strtotime($start_date));?></span></div>
						<div class="subscription">Days remaining before renewal:</div><span  id="countdown"></span><span  id="note"></span>
					</div>
					
					</div>
					<?php } ?>
					<div class="project-info">
						<a class="btn btn-warning" href="<?php echo base_url();?>payment">Buy Space</a>
					</div>
			<!-- 		<div id="piechart_3d" style="width: 100%; height: 200px;">
					</div>  -->
					<?php 
					$usedDiskSpace = $usedDiskSpace;
					$totalSpace = $allowedDiskSpace[0]['description'];
					$percentage = ($usedDiskSpace * 100) / $totalSpace;
					;?>
					<div class="disk-used col-md-12">
					<h5>Maximum allowed disk space : <?php echo $allowedDiskSpace[0]['description'];?> MB</h5>
					<h6>Used space : <?php echo $usedDiskSpace;?></h6>
					<h6>Free space : <?php echo round($allowedDiskSpace[0]['description'] - (float)$usedDiskSpace,2);?> MB</h6>
					<div id="diskspace" data-percent="<?php echo $percentage;?>" class="small" style="margin-top:20px">
					</div>
				</div>
				</div>
			</div>
		</div>
	<div class="col-lg-9 mid_content" style="height:900px;">
	<?php
		if($user_profile->firstName!='' && $user_profile->lastName!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile->city!='' && $user_profile->country!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile->profession!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile->webSiteURL!='')
		{
			$profileCompletion = $profileCompletion+0;
		}
		if($user_profile->about_me!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile->skills!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		$ci->load->library('EncryptCardDetails');
		$encryptCardDetails=new EncryptCardDetails();
		//echo $encryptCardDetails->encrypt( 10 );die;
?>
		<div class="pricing">
		  <div class="[ price-option price-option--low ]">
		    <div class="price-option__detail">
		      <span class="price-option__cost">50 MB</span>
		      <span class="price-option__cost"><i class="fa fa-rupee"></i>1</span>
		      <span class="price-option__type">BASIC</span>
		    </div>
		    <a href="javascript:void(0);" class="price-option__purchase" onclick="setAmount('<?php echo $encryptCardDetails->encrypt( 1 );?>',1,50,'BASIC',1);">Buy</a>
		  </div>
		  <div class="[ price-option price-option--mid ]">
		    <div class="price-option__detail">
		    <span class="price-option__cost">100 MB</span>
		      <span class="price-option__cost"><i class="fa fa-rupee"></i>2</span>
		      <span class="price-option__type">EXCLUSIVE</span>
		    </div>
		    <a href="javascript:void(0);" class="price-option__purchase" onclick="setAmount('<?php echo $encryptCardDetails->encrypt( 2 );?>',2,100,'EXCLUSIVE',2);">Buy</a>
		  </div>
		  <div class="[ price-option price-option--high ]">
		    <div class="price-option__detail">
		    <span class="price-option__cost">200 MB</span>
		      <span class="price-option__cost"><i class="fa fa-rupee"></i>4</span>
		      <span class="price-option__type">PRO</span>
		    </div>
		    <a href="javascript:void(0);" class="price-option__purchase" onclick="setAmount('<?php echo $encryptCardDetails->encrypt( 4 );?>',3,200,'PRO',4);">Buy</a>
		  </div>
		</div>
<!-- Payment Process -->
<div class="panel panel-default orderDetails dropdown-menu">
	<div class="panel-heading">
		<h3 class="panel-title">
			Order Details
		</h3>
	</div>
	<div class="panel-body">
		Plan : <label id="plan"></label><br/><br/>
		Space : <label id="space"></label>MB<br/><br/>
		Price : <i class="fa fa-rupee"></i><label id="price"></label><br/><br/><br/>
		<form action="<?php echo $action; ?>" method="post" name="payuForm">
			<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
			<input type="hidden" name="hash" value="<?php echo $hash ?>"/>
			<input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
			<input type="hidden" name="productinfo" value="<?php echo (empty($data['productinfo'])) ? '' : $data['productinfo']; ?>">
			<input type="hidden" name="amount" value="<?php echo (empty($data['amount'])) ? '' : $data['amount']; ?>">
			<input type="hidden" name="surl" value="<?php echo base_url();?>payment/successPayUMoney" size="64" />
			<input type="hidden" name="furl" value="<?php echo base_url();?>payment/cancel" size="64" />
			<input type="hidden" name="service_provider" value="payu_paisa" size="64" />
			<input type="hidden"  name="firstname" id="firstname" value="<?php echo $user_profile->firstName; ?>" />
			<input type="hidden" name="email" id="email" value="<?php echo $user_profile->email;  ?>" />
			<input type="hidden" name="phone" value="9999999999" />
			<input type="hidden" name="lastname" id="lastname" value="<?php echo $user_profile->lastName; ?>" />
			<input type="hidden" name="country" value="<?php echo $user_profile->country;?>" />
			<input type="submit" value="Make Payment"  class="btn btn_orange" id="paymentBtn"style="display:none;"  />
			<a class="btn btn_blue" id="cancelPayment" href="javascript:void(0)">Cancel</a>
		</form>
	</div>
</div>
<!-- Payment Process -->
	</div>

</div>
<div class="clearfix"></div>
<!-- Basic Deatils Modal -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Basic Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="defaultForm">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="firstName" class="control-label">
										First Name:
									</label>
									<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo ucfirst($user_profile->firstName);?>">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="lastName" class="control-label">
										Last Name:
									</label>
									<input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo ucfirst($user_profile->lastName);?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										City:
									</label>
									<input type="text" class="form-control" id="city" name="city" value="<?php echo ucfirst($user_profile->city);?>">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="country" class="control-label">
										Country:
									</label>
									<input type="text" class="form-control" id="country" name="country" value="<?php echo ucfirst($user_profile->country);?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="about_me" class="control-label">
										About:
									</label>
									<textarea class="form-control" id="about_me" name="about_me" placeholder="Something about you"><?php echo $user_profile->about_me;?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="website" class="control-label">
										Website:
									</label>
									<input type="text" class="form-control" id="website" name="website" value="<?php echo ucfirst($user_profile->webSiteURL);?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="profession" class="control-label">
										Profession:
									</label>
									<input class="form-control" value="<?php echo ucfirst($user_profile->profession);?>" id="profession" name="profession" type="text" data-role="tagsinput"><br>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Basic Deatils Modal Ends -->
<!-- Add Skills Modal -->
<div class="modal fade" id="add_skills" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Skills
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="my_skills" method="post" action="<?php echo base_url().'profile/saveSkillsData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="skillName" class="control-label">
										Skill Name:
									</label>
									<input type="text" class="form-control" id="skillName" name="skillName[]" value="">
								</div>
								<div class="col-lg-5 form-group">
									<label for="skillLevel" class="control-label">
										Rate Your Knowledge:
									</label>
									<select class="form-control" id="skillLevel" name="skillLevel[]">
										<option value="1" selected>1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
								<div class="col-lg-1 form-group">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- The option field template containing an option field and a Remove button -->
						<div class="form-group hide" id="optionTemplate">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group">
										<label for="skillName" class="control-label">
											Skill Name:
										</label>
										<input type="text" class="form-control" id="skillName" name="skillName[]" value="">
									</div>
									<div class="col-lg-5 form-group">
										<label for="skillLevel" class="control-label">
											Rate Your Knowledge:
										</label>
										<select class="form-control" id="skillLevel" name="skillLevel[]">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-lg-1 form-group">
										<label>&nbsp;</label>
										<button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="save_skills" id="save_skills" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Skills Modal Ends -->
<!-- Edit Skills Modal -->
<div class="modal fade" id="edit_skills" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Skills
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_my_skills" method="post" action="<?php echo base_url().'profile/updateSkillsData';?>">
						<div class="row">
							<div class="col-lg-12">
								<?php
								if(isset($skillsData) && !empty($skillsData))
								{
									foreach($skillsData as $row)
									{
										$selected='selected';
								?>
								<div class="col-lg-5 form-group">
									<label for="skillName" class="control-label">
										Skill Name:
									</label>
									<input type="text" class="form-control" id="skillName" name="skillName[]" value="<?php echo $row['skillName'];?>">
								</div>
								<div class="col-lg-5 form-group">
									<label for="skillLevel" class="control-label">
										Rate Your Knowledge:
									</label>
									<select class="form-control" id="skillLevel" name="skillLevel[]">
										<option value="1" <?php if($row['skillLevel']==1){ echo $selected;}?>>1</option>
										<option value="2" <?php if($row['skillLevel']==2){ echo $selected;}?>>2</option>
										<option value="3" <?php if($row['skillLevel']==3){ echo $selected;}?>>3</option>
										<option value="4" <?php if($row['skillLevel']==4){ echo $selected;}?>>4</option>
										<option value="5" <?php if($row['skillLevel']==5){ echo $selected;}?>>5</option>
									</select>
								</div>
								<input type="hidden" name="skills_id[]" value="<?php echo $row['id'];?>"/>
								<?php }}?>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-primary" name="update_skills" id="update_skills" value="Update">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Skills Modal Ends -->
<!-- Add experience Deatils Modal -->
<div class="modal fade" id="add_experience_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Experience Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_exp_details" method="post" action="<?php echo base_url().'profile/saveExperienceData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="company_name" class="control-label">
										Company Name :
									</label>
									<input type="text" class="form-control" id="company_name" name="company_name[]" value="">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="position" class="control-label">
										Position :
									</label>
									<input type="text" class="form-control" id="position" name="position[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="from_date" class="control-label">
										From Date :
									</label>
									<div class="input-group date from_yr" id="from_date">
										<input class="form-control from_yr" type="text" id="from_date" name="from_date[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="to_date" class="control-label">
										To Date :
									</label>
									<div class="input-group date to_year" id="to_date">
										<input class="form-control to_year" type="text" id="to_date" name="to_date[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="address" class="control-label">
										Address :
									</label>
									<textarea style="resize:vertical;" class="form-control" id="address" name="address[]"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="work_description" class="control-label">
										Work Description :
									</label>
									<textarea style="resize:vertical;" class="form-control" id="work_description" name="work_description[]"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="current_employer" class="control-label">
										Current Employer :
									</label>
									<input type="hidden" id="current_emp_arr" name="current_emp_arr[]" value="0"/>
									<input type="checkbox" class="" id="current_employer" name="current_employer[]" value="0" onclick="return check(this);">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="save_exp_details" id="save_exp_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Experience Deatils Modal Ends -->
<!-- Edit experience Deatils Modal -->
<div class="modal fade" id="edit_experience_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Experience Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_exp_details" method="post" action="<?php echo base_url().'profile/updateExperienceData';?>">
						<?php
							if(isset($workData) && !empty($workData)){
								foreach($workData as $w_details){
						?>
						<div class="form-group" id="edit_exp_clone">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group">
										<label for="company_name" class="control-label">
											Company Name :
										</label>
										<input type="hidden" name="exp_id[]" value="<?php echo $w_details['id'];?>"/>
										<input type="text" class="form-control" id="company_name" name="company_name[]" value="<?php echo $w_details['organisation']?>">
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="position" class="control-label">
											Position :
										</label>
										<input type="text" class="form-control" id="position" name="position[]" value="<?php echo $w_details['position']?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group">
										<label for="from_date" class="control-label">
											From Date :
										</label>
										<div class="input-group date from_yr" id="from_date">
											<input class="form-control from_yr" type="text" id="from_date" name="from_date[]" value="<?php echo $w_details['startingDate']?>">
											<span class="input-group-addon add-on">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="to_date" class="control-label">
											To Date :
										</label>
										<div class="input-group date to_year" id="to_date">
											<input class="form-control to_year" type="text" id="to_date" name="to_date[]" value="<?php echo $w_details['endingDate']?>">
											<span class="input-group-addon add-on">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-11 form-group">
										<label for="address" class="control-label">
											Address :
										</label>
										<textarea style="resize:vertical;" class="form-control" id="address" name="address[]"><?php echo $w_details['w_address']?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-11 form-group">
										<label for="work_description" class="control-label">
											Work Description :
										</label>
										<textarea style="resize:vertical;" class="form-control" id="work_description" name="work_description[]"><?php echo $w_details['workDetails']?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-11 form-group">
										<label for="current_employer" class="control-label">
											Current Employer :
										</label>
										<?php if($w_details['status']==1){ $check ='checked="checked"';$val = 1;}else{ $check ='';$val =0;}?>
										<input type="hidden" id="current_emp_arr" name="current_emp_arr[]" value="<?php echo $val;?>"/>
										<input type="checkbox" class="" id="current_employer" name="current_employer[]" <?php echo $check;?> value="<?php echo $val;?>" onclick="return check(this);">
									</div>
								</div>
							</div>
						</div>
						<?php }}?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="edit_exp_details" id="edit_exp_details" value="Update">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Edit Experience Deatils Modal Ends -->
<!-- Add Educational Deatils Modal -->
<div class="modal fade" id="add_educational_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Educational Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_edu_details" method="post" action="<?php echo base_url().'profile/saveEducationalData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="qualification" class="control-label">
										Qualification :
									</label>
									<input type="text" class="form-control" id="qualification" name="qualification[]" value="">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="stream" class="control-label">
										Stream :
									</label>
									<input type="text" class="form-control" id="stream" name="stream[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="from_yr" class="control-label">
										From Year :
									</label>
									<div class="input-group date from_yr" id='from_yr'>
										<input class="form-control from_yr" type="text" id="from_yr" name="from_yr[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="to_year" class="control-label">
										To Year :
									</label>
									<div class="input-group date to_year" id='to_year'>
										<input class="form-control to_year" type="text" id="to_year" name="to_year[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="university" class="control-label">
										University / Institute :
									</label>
									<input type="text" class="form-control" id="university" name="university[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="save_edu_details" name="save_edu_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Educational Deatils Modal Ends -->
<!-- Edit Educational Deatils Modal -->
<div class="modal fade" id="edit_educational_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Educational Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_edu_details" method="post" action="<?php echo base_url().'profile/updateEducationalData';?>">
						<?php
							if(isset($educationData) && !empty($educationData))
							{
								foreach($educationData as $e_details)
								{
						?>
						<div class="form-group" id="edit_edu_clone">
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group">
										<label for="qualification" class="control-label">
											Qualification :
										</label>
										<input type="text" class="form-control" id="qualification" name="qualification[]" value="<?php echo $e_details['qualification']?>">
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="stream" class="control-label">
											Stream :
										</label>
										<input type="text" class="form-control" id="stream" name="stream[]" value="<?php echo $e_details['stream']?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group">
										<label for="from_yr" class="control-label">
											From Year :
										</label>
										<div class="input-group date from_yr" id='from_yr'>
											<input class="form-control from_yr" type="text" id="from_yr" name="from_yr[]" value="<?php echo $e_details['startFrom']?>">
											<span class="input-group-addon add-on">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="to_year" class="control-label">
											To Year :
										</label>
										<div class="input-group date to_year" id='to_year'>
											<input class="form-control to_year" type="text" id="to_year" name="to_year[]" value="<?php echo $e_details['endFrom']?>">
											<span class="input-group-addon add-on">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-11 form-group">
										<label for="university" class="control-label">
											University / Institute :
										</label>
										<input type="text" class="form-control" id="university" name="university[]" value="<?php echo $e_details['university']?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-xs-4">
										<button type="button" class="btn btn-warning removeButton">Remove Experience</button>
									</div>
								</div>
							</div>
							<hr />
						</div>
						<?php }}?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="edit_edu_details" name="edit_edu_details" value="Update">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Edit Educational Deatils Modal Ends -->
<!-- Add Awards Deatils Modal -->
<div class="modal fade" id="add_award_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Awards Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_award_form" method="post" action="<?php echo base_url().'profile/saveAwardData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="award_name" class="control-label">
										Award :
									</label>
									<input type="text" class="form-control" id="award_name" name="award_name[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="award_nomination" class="control-label">
										Award Prize/Nomination :
									</label>
									<input type="text" class="form-control" id="award_nomination" name="award_nomination[]" value="">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="award_date" class="control-label">
										Date :
									</label>
									<div class="input-group date award_date" id='award_date'>
										<input class="form-control award_date" type="text" id="award_date" name="award_date[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="save_award_details" id="save_award_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Awards Deatils Modal Ends -->
<!-- edit Awards Deatils Modal -->
<div class="modal fade" id="edit_award_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Awards Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_award_form" method="post" action="<?php echo base_url().'profile/updateAwardData';?>">
						<?php
							if(isset($awardData) && !empty($awardData))
							{
								foreach($awardData as $row)
								{
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="award_name" class="control-label">
										Award :
									</label>
									<input type="text" class="form-control" id="award_name" name="award_name[]" value="<?php echo $row['award'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="award_nomination" class="control-label">
										Award Prize/Nomination :
									</label>
									<input type="text" class="form-control" id="award_nomination" name="award_nomination[]" value="<?php echo $row['prize'];?>">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="award_date" class="control-label">
										Date :
									</label>
									<div class="input-group date award_date" id='award_date'>
										<input class="form-control award_date" type="text" id="award_date" name="award_date[]" value="<?php echo $row['dateRecieved'];?>">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
									<input type="hidden" name="award_id[]" value="<?php echo $row['id'];?>"/>
								</div>
							</div>
						</div>
						<?php }} ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="edit_award_details" name="edit_award_details" value="Update">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- edit Awards Deatils Modal Ends -->
<?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function() {
	$('#moniterFlagForm')
		.formValidation({
	message: 'This value is not valid',
	framework: 'bootstrap',
	icon: {
	valid: 'glyphicon glyphicon-ok',
	invalid: 'glyphicon glyphicon-remove',
	validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
			admin_status_flag: {
				verbose: false,
trigger: 'blur',
message: 'Monitor flag is not valid',
validators:
	{
	notEmpty: {
	message: 'Monitor flag is required and can\'t be empty'
	},
	remote: {
	type: 'POST',
url: '<?php echo base_url();?>profile/change_admin_project_flag',
message: 'Unable to save monitor flag data please try again',
//delay: 1000
}
}
}
}
})
});
</script>
<script>
$(function(){
$('#new_job').click(function() {
if($(this).is(':checked'))
$('#new_job').attr('value', '1');
else
$('#new_job').attr('value', '0');
});
$('#weeklyNewsletter').click(function() {
if($(this).is(':checked'))
$('#weeklyNewsletter').attr('value', '1');
else
$('#weeklyNewsletter').attr('value', '0');
});
$('#new_competition').click(function() {
if($(this).is(':checked'))
$('#new_competition').attr('value', '1');
else
$('#new_competition').attr('value', '0');
});
$('#new_institute').click(function() {
if($(this).is(':checked'))
$('#new_institute').attr('value', '1');
else
$('#new_institute').attr('value', '0');
});
$('#follow_unfollow').click(function() {
if($(this).is(':checked'))
$('#follow_unfollow').attr('value', '1');
else
$('#follow_unfollow').attr('value', '0');
});
$('#new_project_followed').click(function() {
if($(this).is(':checked'))
$('#new_project_followed').attr('value', '1');
else
$('#new_project_followed').attr('value', '0');
});
$('#project_like').click(function() {
if($(this).is(':checked'))
$('#project_like').attr('value', '1');
else
$('#project_like').attr('value', '0');
});
$('#project_comment').click(function() {
if($(this).is(':checked'))
$('#project_comment').attr('value', '1');
else
$('#project_comment').attr('value', '0');
});
})
</script>
<script>
$(document).ready(function() {
	$('#emailNotificationForm')
		.formValidation({
	message: 'This value is not valid',
	framework: 'bootstrap',
	icon: {
	valid: 'glyphicon glyphicon-ok',
	invalid: 'glyphicon glyphicon-remove',
	validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
			new_job:
						{
							verbose: false,
							trigger: 'click',
							validators:
							{
								remote:
								{
									type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save new job email notification flag.',
}
}
},
weeklyNewsletter:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save weekly newsletter email notification flag.',
}
}
},
new_competition:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save new competition email notification flag.',
}
}
},
new_institute:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save new institute email notification flag.',
}
}
},
follow_unfollow:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save follow or unfollow email notification flag.',
}
}
},
new_project_followed:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save new project by followed user notification flag.',
}
}
},
project_like:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save project like email notification flag.',
}
}
},
project_comment:
{
verbose: false,
trigger: 'click',
validators:
{
remote:
{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save project comment email notification flag.',
}
}
}
}
})
});
</script>
<script>
$(function () {
$('#datetimepicker2').datetimepicker({
format: 'MM/YYYY'
});
});
$(document.body).on('click',function(){
	$('.from_yr').datetimepicker({
	format: 'YYYY-MM-DD'
	});
});
$(document.body).on('click',function(){
	$('.to_year').datetimepicker({
	format: 'YYYY-MM-DD'
	});
});
$(document.body).on('click',function(){
	$('.award_date').datetimepicker({
	format: 'YYYY-MM-DD'
	});
});
$(document.body).on('click',function(){
	$('.from_yr').on('dp.change',function(e) {
$('#add_edu_details').formValidation('revalidateField', 'from_yr[]');
});
	$('.from_yr').on('dp.change',function(e) {
$('#add_exp_details').formValidation('revalidateField', 'from_date[]');
});
$('.award_date').on('dp.change',function(e) {
$('#add_award_form').formValidation('revalidateField', 'award_date[]');
});
});
$(document.body).on('click',function(){
	$('.to_year').on('dp.change',function(e) {
$('#add_edu_details').formValidation('revalidateField', 'to_year[]');
});
	$('.to_year').on('dp.change',function(e) {
$('#add_exp_details').formValidation('revalidateField', 'to_date[]');
});
});
</script>
<script src="<?php echo base_url();?>assets/js/moment.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_framework.js"></script>
<script>
function save_social_data(linkName)
{
	$("#"+linkName).submit();
}
function edit_social_data(linkName)
{
	$("#"+linkName+"_label").addClass('hide');
	$("input#"+linkName).removeClass('hide');
	$("#"+linkName+"_edit").addClass("hide");
	$("#"+linkName+"_save").removeClass("hide");
}
</script>
<script>
$(document).ready(function() {
	$('#defaultForm').find('[name="profession"]').change(function (e) {
$('#defaultForm').formValidation('revalidateField', 'profession');
})
.end()
$('#defaultForm').find('[name="user_skills"]').change(function (e) {
$('#defaultForm').formValidation('revalidateField', 'user_skills');
})
.end()
		.formValidation({
	message: 'This value is not valid',
	framework: 'bootstrap',
	excluded:':disabled',
	icon: {
	valid: 'glyphicon glyphicon-ok',
	invalid: 'glyphicon glyphicon-remove',
	validating: 'glyphicon glyphicon-refresh'
	},
	err: {
	container: 'popover'
	},
	fields: {
		firstName: {
		verbose: false,
	trigger: 'blur',
	message: 'First Name is not valid',
	validators: {
	notEmpty: {
	message: 'First Name is required'
	},
					stringLength: {
min: 1,
max: 40,
message: 'First name must be more than 1 and less than 40 characters long'
},
					regexp: {
regexp: /^[a-zA-Z ]+$/,
message: 'Please use only letters (a-z, A-Z)'
},
	remote: {
	type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save first name please try again',
//delay: 1000
}
}
},
lastName: {
verbose: false,
trigger: 'blur',
message: 'Last Name is not valid',
validators: {
notEmpty: {
message: 'Last Name is required'
},
stringLength: {
min: 1,
max: 40,
message: 'Last name must be more than 1 and less than 40 characters long'
},
regexp: {
regexp: /^[a-zA-Z ]+$/,
message: 'Please use only letters (a-z, A-Z)'
},
remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save last name please try again',
//delay: 1000
}
}
},
country: {
verbose: false,
trigger: 'blur',
message: 'Country field is not valid',
validators: {
notEmpty: {
message: 'Country field is required'
},
remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save country name please try again',
//delay: 1000
}
}
},
city: {
verbose: false,
trigger: 'blur',
message: 'City field is not valid',
validators: {
notEmpty: {
message: 'City field is required'
},
stringLength: {
min: 1,
max: 30,
message: 'City must be more than 1 and less than 30 characters long'
},
remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save city name please try again',
//delay: 1000
}
}
},
website: {
verbose: false,
trigger: 'blur',
message: 'Website field is not valid',
validators: {
uri: {
message: 'Website address is not valid'
},
remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save website link please try again',
//delay: 1000
}
}
},
about_me: {
verbose: false,
trigger: 'blur',
message: 'About Me is not valid',
validators:
{
remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save about me data please try again',
//delay: 1000
}
}
},
profession:{
verbose: false,
validators: {
trigger:'blur',
callback: {
message: 'Please enter max 5 professions.',
callback: function (value, validator, $field) {
// Get the entered elements
var options = validator.getFieldElements('profession').tagsinput('items');
return (options !== null && options.length >= 0 && options.length <= 5);
}    },
remote:{
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save profession data please try again.',
}
}
}
}
})
//  reload when body click basic info
$('#myModal').on('hidden.bs.modal', function (){
$('#basic_info').load('<?php echo current_url();?> #basic_info');
})
});
$(document).ready(function() {
// The maximum number of options
<?php
if(isset($skillsData) && !empty($skillsData))
{
	$numSkills = 5 - count($skillsData);
}
else{
	$numSkills =5;
}
?>
var MAX_OPTIONS = "<?php echo $numSkills?>";
$('#my_skills')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
fields: {
'skillName[]': {
validators: {
notEmpty: {
message: 'The question required and cannot be empty'
}
}
},
'skillLevel[]': {
validators: {
notEmpty: {
message: 'The option required and cannot be empty'
}
}
}
}
})
// Add button click handler
.on('click', '.addButton', function() {
if ($('#my_skills').find(':visible[name="skillLevel[]"]').length >= MAX_OPTIONS) {
$('#my_skills').find('.addButton').attr('disabled', 'disabled');
}
else{
var $template = $('#optionTemplate'),
$clone    = $template
.clone()
.removeClass('hide')
.removeAttr('id')
.insertBefore($template),
$option   = $clone.find('[name="skillName[]"]');
$option1   = $clone.find('[name="skillLevel[]"]');
//alert($('#my_skills').find(':visible[name="skillLevel[]"]').length);
// Add new field
$('#my_skills').formValidation('addField', $option);
$('#my_skills').formValidation('addField', $option1);
}
})
// Remove button click handler
.on('click', '.removeButton', function() {
var $row    = $(this).parents('.form-group'),
$option = $row.find('[name="skillName[]"]');
$option1 = $row.find('[name="skillLevel[]"]');
// Remove element containing the option
$row.remove();
// Remove field
$('#my_skills').formValidation('removeField', $option);
$('#my_skills').formValidation('removeField', $option1);
})
// Called after adding new field
.on('added.field.fv', function(e, data) {
// data.field   --> The field name
// data.element --> The new field element
// data.options --> The new field options
if (data.field === 'skillLevel[]') {
if ($('#my_skills').find(':visible[name="skillLevel[]"]').length >= MAX_OPTIONS) {
$('#my_skills').find('.addButton').attr('disabled', 'disabled');
}
}
})
// Called after removing the field
.on('removed.field.fv', function(e, data) {
if (data.field === 'skillLevel[]') {
if ($('#my_skills').find(':visible[name="skillLevel[]"]').length < MAX_OPTIONS) {
$('#my_skills').find('.addButton').removeAttr('disabled');
}
}
});
});
$("#user_skills").on('itemRemoved', function(event)
{
user_skills = $("#user_skills").val();
$.ajax({
url: '<?php echo base_url();?>profile/saveFieldValues',
type: 'POST',
data: {user_skills: user_skills},
success:function (response){
}
})
});
$("#profession").on('itemRemoved', function(event)
{
profession = $("#profession").val();
$.ajax({
url: '<?php echo base_url();?>profile/saveFieldValues',
type: 'POST',
data: {profession: profession},
success:function (response){
}
})
});
</script>
<script>
$(function(){
	$('.deleteSkill').on('click',function(){
		var id = $(this).data('id');
		var fieldName='id';
		if(confirm('Are you sure you want to remove this Skill?')==true)
		{
			$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_skills',
type: 'POST',
data: {id: id},
success:function (response){
$.getScript("<?php echo base_url();?>assets/js/percircle.js").done(function( script, textStatus ){
if(textStatus=='success')
{
var url = $('#base_url').val();
var uId = '<?php echo $this->session->userdata("front_user_id");?>';
$('#user_skills').load('<?php echo current_url();?> #user_skills');
$.ajax({
url:url+'user/userSkills/'+uId,
type:'POST',
success:function(result)
{
var obj = $.parseJSON(result);
var i=1;
$.each(obj, function(index, element)
{
var Name = element.length;
var skillName='';
if(Name!='')
{
a = parseInt(Name);
if(a > 16)
{
var dot ='...';
}else
{
var dot ='';
}
var length = 16;
skillName = element.substring(0, length)+dot;
}
setTimeout(function() {
$("#custom"+i).percircle({
text:skillName
});i++;
},2000);
});
$('.left_side').load('<?php echo current_url();?> .Lhs_content');
}
});
}
});
//$('#educational_details'+id).remove();
/*$('#education').load('<?php echo base_url()?>profile/edit_profile #education');
jQuery(document).ready(function($)
{
var message  = 'Successfully removed the skills.';
var ticon	= 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
});*/
}
})
}
});
$('.remove_edu_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_education',
type: 'POST',
data: {id: id},
success:function (response){
//$('#educational_details'+id).remove();
$('#education').load('<?php echo base_url()?>profile/edit_profile #education');
jQuery(document).ready(function($)
{
var message  = 'Successfully removed the educational detail.';
var ticon	= 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
});
}
})
}
});
$('.remove_exp_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_work',
type: 'POST',
data: {id: id},
success:function (response){
$('#experience_details'+id).remove();
$('#work_exp').load('<?php echo base_url()?>profile/edit_profile #work_exp');
jQuery(document).ready(function($)
{
var message  = 'Successfully removed the experience detail.';
var ticon	= 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
});
}
})
}
});
$('.remove_award_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_award',
type: 'POST',
data: {id: id},
success:function (response){
//$('#award_details'+id).remove();
$('#award').load('<?php echo base_url()?>profile/edit_profile #award');
jQuery(document).ready(function($)
{
var message  = 'Successfully removed the award & publication detail.';
var ticon	= 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
});
}
})
}
});
});
function check(obj)
{
$('input#current_employer').not(obj).prop('checked', false);
$('input#current_employer').not(obj).val('0');
$(obj).val('1');
var $row    = $(obj).parents('.form-group');
var hidden  = $row.find('#current_emp_arr');
hidden.val('1');
$('input#current_emp_arr').not(hidden).val('0');
//alert();
}
</script>
<script>
$(document).ready(function()
{
$('#add_exp_details')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
excluded:':disabled',
err: {
	container: 'popover'
	},
fields: {
'company_name[]': {
validators: {
notEmpty: {
message: 'Company name is required'
}
}
},
'position[]': {
validators: {
notEmpty: {
message: 'Position name is required'
},
stringLength: {
max: 100,
message: 'Position name must be less than 100 characters long'
}
}
},
'from_date[]': {
validators: {
notEmpty: {
message: 'Company joining date required'
},
date: {
	format: 'YYYY-MM-DD',
	max: 'to_date[]',
	message: 'The date is not a valid'
	}
}
},
'to_date[]': {
validators: {
notEmpty: {
message: 'Company leaving date required'
},
date: {
	format: 'YYYY-MM-DD',
	min: 'from_date[]',
	message: 'The date is not a valid'
	}
}
},
'address[]': {
validators: {
notEmpty: {
message: 'Company address is required'
},
stringLength: {
max: 100,
message: 'Company address must be less than 100 characters'
}
}
}
}
})
$('#edit_exp_details')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
excluded:':disabled',
err: {
	container: 'popover'
	},
fields: {
'company_name[]': {
validators: {
notEmpty: {
message: 'Company name is required'
},
stringLength: {
max: 100,
message: 'The option must be less than 100 characters long'
}
}
},
'position[]': {
validators: {
notEmpty: {
message: 'Position name is required'
},
stringLength: {
max: 100,
message: 'The option must be less than 100 characters long'
}
}
},
'from_date[]': {
validators: {
notEmpty: {
message: 'Company joining date is required'
},
date: {
	format: 'YYYY-MM-DD',
	max:'to_date[]',
	message: 'The date is not a valid'
	}
}
},
'to_date[]': {
validators: {
notEmpty: {
message: 'Company leaving date is required'
},
date: {
	format: 'YYYY-MM-DD',
	min:'from_date[]',
	message: 'The date is not a valid'
	}
}
},
'address[]': {
validators: {
notEmpty: {
message: 'Company address is required'
},
stringLength: {
max: 100,
message: 'Company address must be less than 100 characters long'
}
}
}
}
})
});
$(document).ready(function()
{
		/* Image Upload validation	*/
	$('#OpenImgUpload').click(function(){ $('#image').trigger('click'); });
	$('#imageForm').formValidation({
message: 'This value is not valid',
framework: 'bootstrap',
excluded: ':disabled',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
fields: {
	image: {
	trigger: 'change',
	icon: false,
	message: 'The username is not valid',
	validators: {
		notEmpty: {
		message: 'Profile Image is required and can\'t be empty'
		},
		required: {
		message: 'Profile Image is required and cannot be empty'
		},
	file: {
	extension: 'jpeg,png,jpg,bmp',
	type: 'image/jpeg,image/png,image/bmp',
	maxSize: 1000000,   // 2048 * 1024
	message: 'The selected file is not valid'
	},
	callback: {
message: 'Something went wrong while saving file',
callback: function(value, validator, $field) {
if(value != '' && validator.isValid('image') != false)
{
	$.blockUI();
files = $field[0].files;
var data = new FormData();
$.each(files, function(key, value)
{
	data.append(key, value);
});
$.ajax({
url: '<?php echo base_url();?>profile/saveImage',
data: data,
type:'POST',
cache: false,
processData: false, // Don't process the files
contentType: false,
})
.done(function(response) {
if(response != '')
{
var imageData='<?php echo file_upload_base_url();?>users/thumbs/'+response;
$('#profileImage').attr('src', imageData);
$('#OpenImgUpload_new').attr('src', imageData);
$.unblockUI();
}
})
var priority = 'success';
var title    = 'Success';
var message  = 'Profile Pic Updated Successfully';
var ticon	 = 'fa-check-circle';
$.toaster({ priority : priority, title : title, message : message, ticon : ticon });
return {
valid: true,    // or false
message: ''
}
return false;
}
else
{
var priority = 'danger';
var title    = 'Error';
var message  = 'Unable to update image please try again';
var ticon	 = 'fa-times-circle';
$.toaster({ priority : priority, title : title, message : message, ticon : ticon });
return {
valid: false,    // or false
message: ''
//message: 'Unable to update image please try again'
}
}
$('#img_div').find('.help-block').css('display','none');
$.unblockUI();
}
}
}
}
}
})
/* Image Upload validation	*/
$('#add_edu_details')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
excluded:':disabled',
err: {
container: 'popover'
},
fields: {
'qualification[]': {
validators: {
notEmpty: {
message: 'Qualification is required'
},
stringLength: {
max: 100,
message: 'The option must be less than 100 characters long'
}
}
},
'stream[]': {
validators: {
notEmpty: {
message: 'Educational stream name is required'
},
stringLength: {
max: 100,
message: 'The option must be less than 100 characters long'
}
}
},
'from_yr[]': {
validators: {
notEmpty: {
message: 'Education from year required and less than to year'
},
date: {
format: 'YYYY-MM-DD',
max:'to_year[]',
message: 'The date is not a valid'
}
}
},
'to_year[]': {
validators: {
notEmpty: {
message: 'Education to year required and greater than from year'
},
date: {
format: 'YYYY-MM-DD',
min:'from_yr[]',
message: 'The date is not a valid'
}
}
},
'university[]': {
validators: {
notEmpty: {
message: 'University name is required'
},
stringLength: {
max: 100,
message: 'The option must be less than 100 characters long'
}
}
}
}
})
});
</script>
<script>
$(document).ready(function()
{
$('#add_award_form')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
excluded:':disabled',
err: {
	container: 'popover'
	},
fields: {
'award_name[]': {
validators: {
notEmpty: {
message: 'Award name is required'
}
}
},
'award_nomination[]': {
validators: {
notEmpty: {
message: 'Nomination name is required'
}
}
},
'award_date[]': {
validators: {
notEmpty: {
message: 'Award date is required'
},
date: {
	format: 'YYYY-MM-DD',
	message: 'The date is not a valid'
	}
}
}
}
})
$('#edit_award_form')
.formValidation({
framework: 'bootstrap',
icon: {
valid: 'glyphicon glyphicon-ok',
invalid: 'glyphicon glyphicon-remove',
validating: 'glyphicon glyphicon-refresh'
},
excluded:':disabled',
err: {
	container: 'popover'
	},
	fields: {
'award_name[]': {
validators: {
notEmpty: {
message: 'Award name is required'
},
stringLength: {
max: 100,
message: 'Award name must be less than 100 characters long'
}
}
},
'award_nomination[]': {
validators: {
notEmpty: {
message: 'Nomination name is required'
},
stringLength: {
max: 100,
message: 'Nomination name must be less than 100 characters long'
}
}
},
'award_date[]': {
validators: {
notEmpty: {
message: 'Award date is required'
},
date: {
	format: 'YYYY-MM-DD',
	message: 'The date is not a valid'
	}
}
}
}
})
/*$('#myModal').on('hidden.bs.modal', function () {
$('#defaultForm').bootstrapValidator('resetForm', true);
});*/
$('#add_experience_details').on('hidden.bs.modal', function () {
$('#add_exp_details').bootstrapValidator('resetForm', true);
});
$('#add_educational_details').on('hidden.bs.modal', function () {
$('#add_edu_details').bootstrapValidator('resetForm', true);
});
$('#add_award_details').on('hidden.bs.modal', function () {
$('#add_award_form').bootstrapValidator('resetForm', true);
});
});
<?php
	if(isset($skillsData) && !empty($skillsData))
	{
		$i=1;
		foreach($skillsData as $row)
		{
			$skillName = $row["skillName"];
			if($skillName!= '')
			{
				$atr = $skillName;
				if(strlen($atr) > 16)
				{
					$dot = '...';
				}
				else
				{
					$dot = '';
				}
				$position = 16;
				$post = substr($atr, 0, $position).$dot;
			}
?>
$("#custom<?php echo $i;?>").percircle({
text:"<?php echo $post;?>"
});
<?php $i++;}}?>
$(document).ready(function() {
$(".scroll").click(function(event) {
var fixedH = $(".navbar").outerHeight(true);
$('html,body').animate({ scrollTop: $(this.hash).css("padding-top","50px").offset().top}, 1000);
});
});
$(function(){
var note = $('#note');
// The new year is here! Count towards something else.
// Notice the *1000 at the end - time must be in milliseconds
<?php if(isset($diff) && $diff > 0)
{
?>
//console.log(parseInt('<?php echo $diff;?>')*1000);
ts = (new Date()).getTime() + parseInt('<?php echo $diff;?>')*1000;
<?php
}
else
{
?>
ts = (new Date()).getTime() + 10*24*60*60*1000;
<?php
}
?>
newYear = false;
/*$('#countdown').countdown({
timestamp	: ts,
layout: '{d<}{dn}{dl}{d>} {h<}{hn}h{h>} {m<}{mn}m{m>} {s<}{sn}s{s>}',
callback	: function(days, hours, minutes, seconds){
var message = "";
message += days + " day" + ( days==1 ? '':'s' ) + ", ";
message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";
if(newYear){
message += "left until the new year!";
}
else {
message += "left to 10 days from now!";
}*/
$('#countdown').countdown({
	timestamp : ts,
	layout: '{d<}{dn}{dl}{d>}',
	callback  : function(days){
	var message = "";
	message += days + " day" + ( days==1 ? '':'s' ) + "<br />";
	if(newYear){
	message += "left until the new year!";
	}
	else {
	message += "left to 10 days from now!";
	}
//note.html(message);
}
});
});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
['Task', 'Disc Space'],
['Free space',     99],
['Used Space',      1]
]);
var options = {
title: 'Maximum allowed disk space : 100 MB',
		backgroundColor:'#303030',
is3D: true,
		titleTextStyle:{ color: '#fff'},
		fontSize:12,
		chartArea:{left:0,top:50,width:'100%',height:'60%'}
};
var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
chart.draw(data, options);
}
function setAmount(amt,packageType,space,plan,price){
	if((amt != '' && amt != 0) && (packageType != '' && packageType != 0)){
		$("#paymentBtn").show();
		$("input[type='hidden'][name='amount']").val(amt);
		$("input[type='hidden'][name='productinfo']").val(packageType);
		$('#plan').text(plan);
		$('#space').text(space);
		$('#price').text(price);
		$('.orderDetails').fadeToggle("slow");
	}
}
$('#cancelPayment').click(function(){
	$('.orderDetails').fadeToggle("slow");
});
</script>
<script>
  var hash = '<?php echo $hash ?>';
  function submitPayuForm() {
  	console.log(hash);
    if(hash == '') {
    		console.log("In"+hash);
	      return;
    }
    var payuForm = document.forms.payuForm;
    payuForm.submit();
  }
</script>