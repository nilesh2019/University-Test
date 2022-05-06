<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/formValidation.min.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/percircle.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/countdown/jquery.countdown.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/percircle.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
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
/*  .help-block{
margin: -56px 0px 0px 100px !important;
}*/
.subscription {
color: #57ba2c;
font-size: 16px;
font-weight: bold;
margin-bottom:5px;
}
.dataTables_processing {
background-color: white;
border: 1px solid #ddd;
box-shadow: 0 6px 7px #000;
color: #000;
font-size: 14px;
height: 60px;
left: 50%;
margin-left: -125px;
margin-top: -15px;
padding: 14px 0 2px;
position: absolute;
text-align: center;
top: 50%;
width: 300px;
z-index: 10000000000;
}
.navbar {
background-color:rgb(0,0,0);
}
.OnTheWeb input
{
color:#4a4949;
}
.countDiv:after,.countHours,.countMinutes,.countSeconds
{
	display: none;
}
.countDiv:before{
	display: none;
}
.box
{
	overflow: hidden;
}

.error
{
	color: red;
	padding-left: 5%;
}
</style>
<div class="clearfix"></div>
<div class="middle_my_profile">
	<div id="img_div" class="col-lg-3  portfolio-left" style="padding:0">
		<div class="fix_content mCustomScrollbar light" id="content-2" data-mcs-theme="minimal-dark">
			<div class="profile_photo">
				<form id="imageForm" method="post">
					<div class="box">
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
								
								if ($user_profile->courseName !='') 
                                {
									$ci->load->model('user_model');
									$courseData=$ci->user_model->getCourseData($user_profile->courseName);
                                  //echo "<pre>";print_r($courseData);exit();
									if(!empty($courseData)){
										$courseName = $courseData['course_name'];
										$courseType = $courseData['course_type'];
									}
								}

						$profileCompletion=0;
						$profileImage = $user_profile->profileImage;
						if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)
						{
						$profileCompletion=20;
						?>
						
						<img id="OpenImgUpload_new" class="" alt="image" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>"/>
						<?php }else{?>
						<img id="OpenImgUpload_new"alt="image" class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />
						<?php }?>
						<input type="file" accept="image/jpeg" class="UploadProf"  id="image" name="image"/>
						<div class="product-overlay">
							<div class=" overlay-content">
								<a href="javascript:void(0);" id="OpenImgUpload"><i class="fa fa-pencil"></i> Change</a>
							</div>
						</div>
					</div>
				</form>				
				<?php
				 if($user_profile->instituteName !=''){  ?>
				 <div>
				 <h4 class="main"> Institute : <a href="<?php echo base_url();?><?php echo $user_profile->pageName;?>"><?php echo $user_profile->instituteName;?></a></h4>				
				</div>
				<?php }?>
						
				<?php 
				if ($user_profile->courseName !='') { ?>
				<div>
				 	<h4 class="main"> Course : 
				 			<?php 
								if($courseName != ''){
									echo $courseName;
								}else{
									echo $user_profile->courseName;
								}
							?>
					</h4>				
				</div>
				<?php } 
				 if($user_profile->registration_date !='' && $user_profile->registration_date !='0000-00-00'){  ?>
				 <div>
				 	<h4 class="main"> Registration Date : <?php echo date('d-m-Y',strtotime($user_profile->registration_date));?></h4>				
				</div>
				<?php } 
				 if(isset($end_date)  && $end_date !='0000-00-00'){  ?>
				 <div>
				 	<h4 class="main"> End Date : <?php echo date('d-m-Y',strtotime($end_date));?></h4>				
				</div>
				<?php } 
				if ($user_profile->courseName !='') { ?>	
				
				<div>
				 	<h4 class="main"> Course Type : <?php echo $courseType; ?></h4>				
				</div>
			<?php } ?>
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
				<?php if($this->session->userdata('user_institute_id') != '' && $this->session->userdata('user_institute_id') > 0 && $this->session->userdata('user_admin_level') == 0) { ?>
				<h4>
				<a href="#" data-toggle="modal" data-target="#googleDriveSetting">
					Google Drive Setting
				</a>
				</h4>
				<?php } ?>
				<?php } ?>
				<?php //print_r($user_profile);
				//print_r($admin_data);
				if(!empty($admin_data))
				{
				?>
				<h4>y
				<a href="#flag_status" class="scroll">
					Monitor Flag
				</a>
				</h4>
				<!-- <h4>
				<a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($admin_data[0]['pageName']));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">Manage Institute Data</a>
				</h4> -->
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
$profileCompletion = $profileCompletion+0;
}
if($user_profile->webSiteURL!='')
{
$profileCompletion = $profileCompletion+0;
}
if($user_profile->about_me!='')
{
$profileCompletion = $profileCompletion+20;
}
/*if($user_profile->skills!='')
{
$profileCompletion = $profileCompletion+10;
}*/
?>

<?php
if(isset($socialData['pinterest']) && $socialData['pinterest']!='')
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
  $profileCompletion = $profileCompletion+0;
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
					$followingUserData = $ci->model_basic->getCountWhere('user_follow',array('followingUser'=>$this->session->userdata('front_user_id')));
					$appreciated=$ci->user_model->getUserLikedOnProject();
					?>
					<span>
						<?php
						if(!empty($followingUserData))
						{
						echo $followingUserData;
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
				
				if(isset($difference) && $difference > 1)
				{
				?>
					<div class="countdown">
				<div>
					<!-- <div class="subscription">Registration Date: <span ><?php echo date('d M, Y',strtotime($start_date));?></span></div> -->
					<div class="subscription">Days remaining before renewal:</div><span  id="countdown"></span><span  id="note"></span>
				</div>
				
				</div>
				<?php } ?>
				<!-- <div class="project-info">
					<a class="btn btn-warning" href="<?php echo base_url();?>payment">Buy Space</a>
				</div> -->
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
	<div class="col-lg-9 mid_content" style="border-left:1px solid #d0d0d0">
		<div id="basic_info">
			<div class="basic_info">
				<h3>
				<?php echo ucwords($user_profile->firstName.' '.$user_profile->lastName);?>
				</h3>
				<a href="#" data-toggle="modal" data-target="#myModal">
					<i class="fa fa-pencil">
					</i>&nbsp;
					<span>
						Edit Basic Details
					</span>
				</a>
				<button class="btn btn_blue" onclick="window.location='<?php echo base_url()?>profile';">
					My Portfolio
				</button>
				<button class="btn btn_blue" onclick="window.location='<?php echo base_url()?>profile/preview_resume';" style="margin-right:10px;">
					Resume
				</button>
				<?php 
				 $edit_profile_jobsId=$this->session->userData("edit_profile_jobsId");
				if(isset($edit_profile_jobsId)  && !empty($edit_profile_jobsId))
				{
					if(isset($user_profile->age)  && $user_profile->age!='0' && isset($user_profile->contactNo) &&  $user_profile->contactNo!='0' && isset($user_profile->about_me) && isset($user_profile->dob) && $user_profile->dob!='0000-00-00' && $user_profile->about_me!=''  && count($educationData)!=0 &&  count($skillsData)!=0 )  { ?>
					<button class="btn btn_blue" onclick="window.location='<?php echo base_url();?>job/jobDetail/<?php echo $edit_profile_jobsId; ?>';" style="margin-right:10px;">
						Back To Job
					</button>
				<?php } } ?>
				<ul>
					<?php if($user_profile->profession!=''){?>
					<li>
						<?php echo ucfirst($user_profile->profession);?>
					</li>
					<?php }?>
					<li>
						<?php if($user_profile->city!=''){ echo ucfirst($user_profile->city); }?>
						<?php if($user_profile->city!='' && $user_profile->country!=''){ echo ', '.ucfirst($user_profile->country);}?>
					</li>
				</ul>
				<?php 
					if($this->session->userdata('studentId') != '')
					{
				?>
				
				<div >
					Course :
					<span>
						<?php 
							if($courseName != ''){
								echo $courseName." (".$courseType." Course)";
							}else{
								echo $user_profile->courseName;
							}
							
						?>
					</span>
				</div>
				<br/>
				<?php 
				
				} ?>
				
				<div>
					Contact No :&nbsp;
					<span>
						<?php echo $user_profile->contactNo ;?>
					</span>
				</div>
				<br/>
				<div>
					Email Id :&nbsp;
					<a href="mailto:<?php echo $user_profile->email;?>">
						<span>
							<?php echo $user_profile->email;?>
						</span>
					</a>
				</div>
				<br/>
				<div>
					Address :&nbsp;
					<span>
						<?php echo $user_profile->address;?>
					</span>
					
				</div>
				<br/>
				<div >
					My Website :
					<a href="<?php echo $user_profile->webSiteURL;?>">
						<span>
							<?php echo $user_profile->webSiteURL;?>
						</span>
					</a>
				</div>
				
				<br/>
				<div>
					Dob :&nbsp;
					<span>
						<?php echo (isset($user_profile->dob) && $user_profile->dob!='0000-00-00')?$user_profile->dob:'NA' ;?>
					</span>&nbsp;&nbsp;&nbsp;
					Age :&nbsp
					<span> 
						<?php echo (isset($user_profile->age) && !empty($user_profile->age) && $user_profile->age!='0')?$user_profile->age:'NA' ;?>
					</span>
				</div>
				<br>
				<?php if (isset($user_profile->marital_status) && !empty($user_profile->marital_status)) {?>
				<div>
					Marital Status :&nbsp;
					<span> 
						<?php 
							if($user_profile->marital_status=='S'){
								echo "Single";
							}else{
								echo "Married";
							}
						?>
					</span>
				</div>
				<?php } ?>
				<h4 class="main">
				About Me:
				</h4>
				<p>
					<?php echo $user_profile->about_me;?>
				</p>
				<div class="clearfix"></div>
			</div>

		</div>
		<div id="user_skills" class="user_skills">
			<div class="experience">
				<h4 class="main">
				My Skills :  (<span style="color : red;">*</span>)
				</h4>
				<ul>
					<?php
					$numSkills =0;
					if(isset($skillsData) && !empty($skillsData))
					{
					$numSkills = count($skillsData);
					}
					if($numSkills<5)
					{
					?>
					<li>
						<a href="#" data-toggle="modal" data-target="#add_skills">
							<i class="fa fa-plus">
							</i>&nbsp;&nbsp
							<span>
								Add Skills
							</span>
						</a>
					</li>
					<?php }
					if(isset($skillsData) && !empty($skillsData))
					{
					?>
					<li>
						<a href="#" data-toggle="modal" data-target="#edit_skills">
							<i class="fa fa-pencil">
							</i>&nbsp;
							<span>
								Edit
							</span>
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php
			if(isset($skillsData) && !empty($skillsData))
			{
			$i=1;
			$skills = explode(',',$user_profile->skills);
			//$profileCompletion = $profileCompletion+10;
			foreach($skillsData as $row)
			{
			$percent='';
			if($row['skillLevel']==1)
			{
			$percent = '20';
			}elseif($row['skillLevel']==2)
			{
			$percent = '40';
			}elseif($row['skillLevel']==3)
			{
			$percent = '60';
			}elseif($row['skillLevel']==4)
			{
			$percent = '80';
			}else
			{
			$percent = '100';
			}
			?>
			<div id="custom<?php echo $i;?>" data-percent="<?php echo $percent;?>" class="small">
				<i class="fa fa-close deleteSkill" data-id="<?php echo $row['id'];?>" title="Delete Skill"></i>
			</div>
			<?php $i++;}}?>
		</div>
		<div class="clearfix"></div>
		<div id="work_exp" class="work_exp">
			<div class="experience">
				<h4 class="main">
				Work / Internship / Freelance  Experience :
				</h4>
				<ul>
					<li>
						<a href="#" data-toggle="modal" data-target="#add_experience_details">
							<i class="fa fa-plus">
							</i>&nbsp;&nbsp
							<span>
								Add Work Experience
							</span>
						</a>
					</li>
					<?php
					if(!empty($workData))
					{
					?>
					<li>
						<a href="#" data-toggle="modal" data-target="#edit_experience_details">
							<i class="fa fa-pencil">
							</i>&nbsp;
							<span>
								Edit
							</span>
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php
			//print_r($workData);
			if(!empty($workData))
			{
			//$profileCompletion = $profileCompletion+10;
			foreach($workData as $w_details){
			?>
				<div class="experience" id="experience_details<?php echo $w_details['id'];?>">
					<h4>
					<?php echo $w_details['position'];?>
					</h4>
					<ul>
						<li>
							<a class="remove_exp_details" href="javascript:void(0);" data-id="<?php echo $w_details['id'];?>">
								<i class="fa fa-times">
								</i>&nbsp;
								<span>
									Remove
								</span>
							</a>
						</li>
					</ul>
					<h5>
					<?php echo $w_details['organisation'];?><?php if($w_details['w_address']!=''){ echo ', '.$w_details['w_address'];}?>
					</h5>
					<p><?php echo $w_details['workDetails'];?></p>
					<p>
						<?php
						if(isset($w_details['startingDate']) && isset($w_details['endingDate']))
						{
						echo date('M Y',strtotime($w_details['startingDate']));
						?> to
						<?php if($w_details['status']==1)
						{
						echo 'Present';
						}
						else
						{
						echo date('M Y',strtotime($w_details['endingDate']));
						}
						}
						?>
						
					</p>
				</div>
			<?php }}else{?>
			<div class="experience">
				No Work Experience added.
			</div>
			<?php }?>
		</div>
		<div id="award" class="award">
					<div class="experience">
						<h4 class="main">
							Education : (<span style="color : red;">*</span>)
						</h4>
						<ul>
							<li>
								<a href="#" data-toggle="modal" data-target="#add_educational_details">
									<i class="fa fa-plus">
									</i>&nbsp;&nbsp
									<span>
										Add Education
									</span>
								</a>
							</li>
							<?php
							if(!empty($educationData))
							{?>
							<li>
								<a href="#" data-toggle="modal" data-target="#edit_educational_details">
									<i class="fa fa-pencil">
									</i>&nbsp;
									<span>
										Edit
									</span>
								</a>
							</li>
							<?php }?>
						</ul>
					</div>
					<?php
					//print_r($workData);
					if(!empty($educationData))
					{
						//$profileCompletion = $profileCompletion+10;
					foreach($educationData as $e_details){
					?>
					<div class="experience" id="educational_details<?php echo $e_details['id'];?>">
						<h4>
							<?php if($e_details['education_type'] == 1){ ?>
								10th :
							<?php }?>
							<?php if($e_details['education_type'] == 2){ ?>
								12th :
							<?php }?>
							<?php if($e_details['education_type'] == 3){ ?>
								Graduation :
							<?php }?>
							<?php if($e_details['education_type'] == 4){ ?>
								Post Graduation :
							<?php }?>
							<?php if($e_details['education_type'] == 5){ ?>
								Professional Qualifications :
							<?php }?>
						</h4>
						
						<ul>
							<li>
								<a class="remove_edu_details" href="javascript:void(0);" data-id="<?php echo $e_details['id'];?>">
									<i class="fa fa-times">
									</i>&nbsp;
									<span>
										Remove
									</span>
								</a>
							</li>
						</ul>
						<?php if(!empty($e_details['university']))
						{ ?>
						<h4>
							<?php echo $e_details['university']; ?>
						</h4>
						<?php }
						?>
						<?php if(!empty($e_details['qualification']) || !empty($e_details['stream']))
						{  
							?>
						<h5>
						<?php echo $e_details['qualification'];if($e_details['stream']!=''){echo ', '.$e_details['stream'];}else{ echo '';}?>
						</h5>

						<?php }?>
						<h5>
							<?php echo $e_details['school']?>
						</h5>
						<p>
							<?php
							if(isset($e_details['passoutyear']))
							{
							echo ($e_details['passoutyear']);
							}
							?>
						</p>
					</div>
					<?php }}else{?>
					<div class="experience">
						No Education added.
					</div>
					<?php }?>
				</div>
				<div id="award" class="awards">
					<div class="experience">
						<h4 class="main">
						Preferred Location  :
						</h4>
						<ul>
							<li>
								<a href="#" data-toggle="modal" data-target="#add_location_details">
									<i class="fa fa-plus">
									</i>&nbsp;&nbsp
									<span>
										Add Location
									</span>
								</a>
							</li>
							
						</ul>
					</div>
					<?php
					if(!empty($locationData))
					{
					foreach($locationData as $row){
					?>
					<div id="location_details<?php echo $row['id'];?>">
						<h5>
						<?php echo $row['city'];?>
						</h5>
						<a class="remove_location_details" href="javascript:void(0);" data-id="<?php echo $row['id'];?>">
							<i class="fa fa-times">
							</i>&nbsp;
							<span>
								Remove
							</span>
						</a>
						
					</div>
					<?php } }else{?>
					<div class="experience">
						No Location added.
					</div>
					<?php }?>
				</div>
		<div id="OnTheWeb" class="OnTheWeb" >
			<h4 class="main " style="border-bottom: 1px solid #4a4949; margin-bottom:15px; padding-bottom:15px;">
			On The Web :
			</h4>
			<div class="web_content">
				<form id="creosouls" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/creosouls_logo.png" alt="My Creosouls">
					<?php
						echo '<label id="creosouls_label"><a target="_blank" href="'.base_url().'profile/usre_profile_detail/'.$user_profile->id.'">'.base_url().'profile/usre_profile_detail/'.$user_profile->id.'</a></label>';
					?>
				</form>
			</div>
			<div class="web_content">
				<form id="linkedin" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/in.png" alt="My Linkedin">
					<?php
					if(isset($socialData['linkedin']) && $socialData['linkedin']!='')
					{
					echo '<label id="linkedin_label"><a target="_blank" href="'.$socialData['linkedin'].'">'.$socialData['linkedin'].'</a></label>';
					?>
					<input class="form-control hide" name="linkedin" id="linkedin" type="text" placeholder="Share your link" value="<?php if(isset($socialData['linkedin'])){ echo $socialData['linkedin'];}?>">
					<a href="javascript:void(0);" id="linkedin_edit" onclick="edit_social_data('linkedin');" style="padding-left: 2%;">
						<i class="fa fa-pencil"></i>&nbsp;&nbsp;
						<span>Edit</span>
					</a>
					<a href="javascript:void(0);" class="hide" id="linkedin_save" onclick="save_social_data('linkedin');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('linkedin')?></span> 
					<?php
					}
					else{
					?>
					<input class="form-control" type="text" placeholder="Share your link" name="linkedin" value="">
					<a href="javascript:void(0);" id="linkedin_save" onclick="save_social_data('linkedin');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('linkedin')?></span> 
					<?php }?>
				</form>
			</div>
			<div class="web_content">
				<form id="pinterest" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/pintrst.png" alt="My Pinterest">
					<?php
					if(isset($socialData['pinterest']) && $socialData['pinterest']!='')
					{
					echo '<label id="pinterest_label"><a target="_blank" href="'.$socialData['pinterest'].'">'.$socialData['pinterest'].'</a></label>';
					?>
					<input class="form-control hide" name="pinterest" id="pinterest" type="text" placeholder="Share your link" value="<?php if(isset($socialData['pinterest'])){ echo $socialData['pinterest'];}?>">
					<a href="javascript:void(0);" id="pinterest_edit" onclick="edit_social_data('pinterest');" style="padding-left: 2%;">
						<i class="fa fa-pencil"></i>&nbsp;&nbsp;
						<span>Edit</span>
					</a>
					<a href="javascript:void(0);" class="hide" id="pinterest_save" onclick="save_social_data('pinterest');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('pinterest')?></span> 
					<?php
					}
					else{
					?>
					<input class="form-control" type="text" placeholder="Share your link" name="pinterest" value="">
					<a href="javascript:void(0);" id="pinterest_save" onclick="save_social_data('pinterest');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('pinterest')?></span> 
					<?php }?>
				</form>
			</div>
			<div class="web_content">
				<form id="deviantart" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/deviantart-icon-logo.png" alt="My Twitter">
					<?php
					if(isset($socialData['deviantart']) && $socialData['deviantart']!='')
					{
					echo '<label id="deviantart_label"><a target="_blank" href="'.$socialData['deviantart'].'">'.$socialData['deviantart'].'</a></label>';
					?>
					<input class="form-control hide" name="deviantart" id="deviantart" type="text" placeholder="Share your link" value="<?php if(isset($socialData['deviantart'])){ echo $socialData['deviantart'];}?>">
					<a href="javascript:void(0);" id="deviantart_edit" onclick="edit_social_data('deviantart');" style="padding-left: 2%;">
						<i class="fa fa-pencil"></i>&nbsp;&nbsp;
						<span>Edit</span>
					</a>
					<a href="javascript:void(0);" class="hide" id="deviantart_save" onclick="save_social_data('deviantart');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('deviantart')?></span> 
					<?php
					}
					else{
					?>
					<input class="form-control" type="text" placeholder="Share your link" name="deviantart" value="">
					<a id="deviantart_save" href="javascript:void(0);" onclick="save_social_data('deviantart');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('deviantart')?></span> 
					<?php }?>
				</form>
			</div>
			<div class="web_content">
				<form id="behance" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/behance-icon-logo.png" alt="My Twitter">
					<?php
					if(isset($socialData['behance']) && $socialData['behance']!='')
					{
					echo '<label id="behance_label"><a target="_blank" href="'.$socialData['behance'].'">'.$socialData['behance'].'</a></label>';
					?>
					<input class="form-control hide" name="behance" id="behance" type="text" placeholder="Share your link" value="<?php if(isset($socialData['behance'])){ echo $socialData['behance'];}?>">
					<a href="javascript:void(0);" id="behance_edit" onclick="edit_social_data('behance');" style="padding-left: 2%;">
						<i class="fa fa-pencil"></i>&nbsp;&nbsp;
						<span>Edit</span>
					</a>
					<a href="javascript:void(0);" class="hide" id="behance_save" onclick="save_social_data('behance');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('behance')?></span> 
					<?php
					}
					else{
					?>
					<input class="form-control" type="text" placeholder="Share your link" name="behance" value="">
					<a id="deviantart_save" href="javascript:void(0);" onclick="save_social_data('behance');">
						<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;
						<span>Save</span>
					</a>
					<span style="color:red"><?php echo form_error('deviantart')?></span> 
					<?php }?>
				</form>
			</div>
		</div>
		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Awards / Achievements :
				</h4>
				<ul>
					<li>
						<a href="#" data-toggle="modal" data-target="#add_award_details">
							<i class="fa fa-plus">
							</i>&nbsp;&nbsp
							<span>
								Add Award
							</span>
						</a>
					</li>
					<?php
					if(!empty($awardData))
					{
					?>
					<li>
						<a href="#" data-toggle="modal" data-target="#edit_award_details">
							<i class="fa fa-pencil">
							</i>&nbsp;&nbsp;
							<span>
								Edit
							</span>
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php
			if(!empty($awardData))
			{
			foreach($awardData as $row){
			?>
			<div id="award_details<?php echo $row['id'];?>">
				<h5>
				<?php echo $row['award'];?>
				</h5>
				<a class="remove_award_details" href="javascript:void(0);" data-id="<?php echo $row['id'];?>">
					<i class="fa fa-times">
					</i>&nbsp;
					<span>
						Remove
					</span>
				</a>
				<p>
					<?php echo $row['prize'];?><br> <?php echo $row['dateRecieved'];?>
				</p>
			</div>
			<?php } }else{?>
			<div class="experience">
				No Awards added.
			</div>
			<?php }?>
		</div>
		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Workshops / Webinars :
				</h4>
				<ul>
					<li>
						<a href="#" data-toggle="modal" data-target="#add_workshop_details">
							<i class="fa fa-plus">
							</i>&nbsp;&nbsp
							<span>
								Add Workshop
							</span>
						</a>
					</li>
					<?php
					if(!empty($workshopData))
					{
					?>
					<li>
						<a href="#" data-toggle="modal" data-target="#edit_workshop_details">
							<i class="fa fa-pencil">
							</i>&nbsp;&nbsp;
							<span>
								Edit
							</span>
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php
			if(!empty($workshopData))
			{
			foreach($workshopData as $row){
			?>
			<div id="workshopData<?php echo $row['id'];?>">
				<h5>
				<?php echo $row['workshop'];?>
				</h5>
				<a class="remove_workshop_details" href="javascript:void(0);" data-id="<?php echo $row['id'];?>">
					<i class="fa fa-times">
					</i>&nbsp;
					<span>
						Remove
					</span>
				</a>
				<p>
					<?php echo $row['workshop_by'];?><br> <?php echo $row['workshop_date'];?>
				</p>
			</div>
			<?php } }else{?>
			<div class="experience">
				No Workshops added.
			</div>
			<?php }?>
		</div>
		
		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Languages Known  :
				</h4>
				<ul>
					<li>
						<a href="#" data-toggle="modal" data-target="#add_language_details">
							<i class="fa fa-plus">
							</i>&nbsp;&nbsp
							<span>
								Add Language
							</span>
						</a>
					</li>
					
				</ul>
			</div>
			
			<?php
			if(!empty($languageData))
			{?>
			<div class="row" style="margin-left: -30px;">
				<div class="col-md-8" style="float:left;word-break: normal;">
					<div class="col-md-2"><h4 style="font-weight: bold;">Languages</h4></div>
					<div class="col-md-3"><h4 style="font-weight: bold;">Language Level</h4></div>
					<div class="col-md-1"><h4 style="font-weight: bold;">Read</h4></div>
					<div class="col-md-1"><h4 style="font-weight: bold;">Write</h4></div>
					<div class="col-md-1"><h4 style="font-weight: bold;">Speak</h4></div>
				</div>
				<div class="col-md-4"></div>
			</div>
			<?php foreach($languageData as $row){
			?>
			<div class="row" style="margin-left: -30px;">
				<div class="col-md-8" style="float:left;">
					<div class="col-md-2"><h4><?php echo $row['language_name'];?></h4></div>
					<div class="col-md-3"><h4><?php if($row['language_proficiency']==1){
														echo "Basic Knowledge";
													}elseif ($row['language_proficiency']==2) {
														echo "Conversant";
													}elseif ($row['language_proficiency']==3) {
														echo "Proficient";
													}elseif ($row['language_proficiency']==4) {
														echo "Fluent";
													}
					?></h4></div>
					<div class="col-md-1" ><input style="padding-top: 20px;" type="checkbox" disabled name="new_project_followed" id="new_project_followed" style="float:center;" <?php if($row['read']==1){ echo 'checked';}?>></div>
					<div class="col-md-1" ><input style="padding-top: 20px;" type="checkbox" disabled name="new_project_followed" id="new_project_followed" <?php if($row['write']==1){ echo 'checked';}?>></div>
					<div class="col-md-1" ><input style="padding-top: 20px;" type="checkbox" disabled name="new_project_followed" id="new_project_followed" <?php if($row['speak']==1) {  echo 'checked'; } ?>>
					</div>
					<a class="remove_language_details" href="javascript:void(0);" data-id="<?php echo $row['id'];?>" style="padding-left: 33px;padding-top: 20px;">
						<i class="fa fa-times">
						</i>&nbsp;
						<span>
							Remove
						</span>
					</a>
				</div>
				<div class="col-md-4">
					
				</div>
			</div>
			<?php } }else{?>
			<div class="experience">
				No Language added.
			</div>
			<?php }?>
	
		<div class="affix-block" id="notification">
			<div class="be-large-post">
				<div class="info-block style-2">
					<div class="be-large-post-align"><h3 class="info-block-label">Email Settings</h3></div>
				</div>
				<div class="be-large-post-align">
					<div class="row">
						<div class="input-col col-xs-12">
							<div class="form-group">
								<label>Email Notification Settings</label>&nbsp;<span class="error" style="padding-left: 0% !important; ">(*)</span>
								<br/>
								<span style="font-size:10px;color:green;">(Note : If you want to get respective email from creosouls, please check respective checkbox.)</span>
								<form id="emailNotificationForm">
									<table width="100%" class="table table-bordered">
										<?php if($this->session->userdata('showJob')=='Yes') { ?>
										<tr width="100%">
											<td width="90%">New job opening on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox" <?php if(!empty($notification) && $notification->new_job==1) {  echo 'checked'; } ?> name="new_job" id="new_job"> </td>
										</tr>
										<?php }?>
										<tr>
											<td width="90%">Weekly newsletter from creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->weeklyNewsletter==1) {  echo 'checked'; } ?> name="weeklyNewsletter" id="weeklyNewsletter" > </td>
										</tr>
										<tr>
											<td width="90%">New competition on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->new_competition==1) {  echo 'checked'; } ?> name="new_competition" id="new_competition" > </td>
										</tr>
										<!--<tr>
											<td width="90%">New institute on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->new_institute==1) {  echo 'checked'; } ?> name="new_institute" id="new_institute" > </td>
										</tr>-->
										<tr>
											<td width="90%">Follow / Unfollow user on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->follow_unfollow==1) {  echo 'checked'; } ?> name="follow_unfollow" id="follow_unfollow" > </td>
										</tr>
										<tr>
											<td width="90%">New project by user which you follow</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->new_project_followed==1) {  echo 'checked'; } ?> name="new_project_followed" id="new_project_followed" > </td>
										</tr>
										<!-- <tr>
											<td width="90%">New project like on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if($notification->project_like==1) {  echo 'checked'; } ?> name="project_like" id="project_like" > </td>
										</tr> -->
										<tr style="border-bottom:1px solid #eee">
											<td width="90%">New project comment on creosouls</td>
											<td width="10%" style="text-align:center"><input type="checkbox"  <?php if(!empty($notification) && $notification->project_comment==1) {  echo 'checked'; } ?> name="project_comment" id="project_comment" > </td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		if(!empty($admin_data))
		{ ?>
		<div class="affix-block" id="flag_status">
			<div class="be-large-post">
				<div class="info-block style-2">
					<div class="be-large-post-align"><h3 class="info-block-label">Monitor Flag</h3></div>
				</div>
				<div id="wrapper_div" class="be-large-post-align">
					<form id="moniterFlagForm">
						<div class="row">
							<div class="input-col col-xs-12 col-sm-12">
								<div class="form-group">
									<label>Monitor Flag</label><br/>
									<div class="col-sm-8">
										<label class="radio-inline">
											<input type="radio" class="admin_status_flag" name="admin_status_flag" <?php  if($admin_data[0]['admin_status']==1) { ?> checked="" <?php } ?>  value="1" >On <span style="font-size: 10px; color: green;">(Note:- User's can't publish work without admin's approval.)</span>
										</label><br/>
										<label class="radio-inline">
											<input type="radio" class="admin_status_flag" name="admin_status_flag" <?php  if($admin_data[0]['admin_status']==0) { ?> checked="" <?php } ?> value="0"  >Off <span style="font-size: 10px; color: green;">(Note:- User's can publish work without admin's approval.)</span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php } ?>
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
										First Name:(<span style="color : red;">*</span>)
									</label>
									<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo ucfirst($user_profile->firstName);?>">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="lastName" class="control-label">
										Last Name:(<span style="color : red;">*</span>)
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
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										DOB :(<span style="color : red;">*</span>)
									</label>
								    <input type="text" class="form-control" placeholder="DOB" onchange="_calculateAge(this.value)"; readonly="true" id="dob" value="<?php echo (isset($user_profile->dob) && $user_profile->dob!='0000-00-00')? date('Y-m-d',strtotime($user_profile->dob)):'' ;?>" name="dob" >
				           		</div>					           		
								<div class="col-lg-1 form-group"></div>			           		
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										Age :
									</label>
								    <input type="text" class="form-control" placeholder="Age" readonly="true" id="age" value="<?php echo (isset($user_profile->age) && !empty($user_profile->age))? ucfirst($user_profile->age):'' ;?>" name="age" >
				           		</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										Mobile No : (<span style="color : red;">*</span>) 
									</label>
								    <input minlength="10" maxlength="10" type="text" class="form-control" placeholder="Mobile No" id="contactNo" value="<?php echo (isset($user_profile->contactNo)&& !empty($user_profile->contactNo))? $user_profile->contactNo :'' ;?>" name="contactNo" >
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="maritalStatus" class="control-label">
										Marital Status : 
									</label>
									<select class="form-control" id="maritalStatus" name="maritalStatus" onchange="saveMaritalStatus(this.value)">
										<option value="0" selected="">Select Marital Status</option>
										<option value="S" <?php if(($user_profile->marital_status) =='S'){ echo "selected";}?>>Single</option>
										<option value="M" <?php if(($user_profile->marital_status) =='M'){ echo "selected";}?>>Married</option>
									</select>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="about_me" class="control-label">
										Address : (<span style="color : red;">*</span>) 
									</label>&nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum"></div>
									<input type="text" class="form-control" id="address" name="address" value="<?php echo ucfirst($user_profile->address);?>">
								</div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="about_me" class="control-label">
										About: (<span style="color : red;">*</span>) 
									</label>&nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum"></div>
									<textarea   rows="5" style="min-width: 100%" onkeyup="countChar(this)" maxlength="200" minlength="100" id="about_me" name="about_me" placeholder="Something about you"><?php echo $user_profile->about_me;?></textarea>
								</div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum"></div>
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
										City :
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
											City :
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
										Education :
									</label>
									<select class="form-control" id="education_type" name="education_type">
										<option value="0" selected>Select Education</option>
										<option value="1">10th</option>
										<option value="2">12th</option>
										<option value="3">Graduation</option>
										<option value="4">Post Graduation</option>
										<option value="5">Professional</option>
									</select>
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="university" class="control-label">
										Board / University / Institute :
									</label>
									<input type="text" class="form-control" id="university" name="university[]" value="">
								</div>
							</div>
						</div>
						<div class="row" id="qualificationStream">
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
									<label for="pass_yr" class="control-label">
										Passing Out Year :
									</label>
									<div class="input-group date pass_yr" id='pass_yr'>
										<input class="form-control pass_yr" type="text" id="pass_yr" name="pass_yr[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="school" class="control-label">
										School / College Name :
									</label>
									<input type="text" class="form-control" id="school" name="school[]" value="">
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									
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
											Education :
										</label>
										<select class="form-control" id="education_type" name="education_type[]">
											<option value="0" selected>Select Education</option>
											<option value="1" <?php if($e_details['education_type']==1){ echo $selected;}?>>10th</option>
											<option value="2" <?php if($e_details['education_type']==2){ echo $selected;}?>>12th</option>
											<option value="3" <?php if($e_details['education_type']==3){ echo $selected;}?>>Graduation</option>
											<option value="4" <?php if($e_details['education_type']==4){ echo $selected;}?>>Post Graduation</option>
											<option value="5" <?php if($e_details['education_type']==5){ echo $selected;}?>>Proffessional</option>
										</select>
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="university" class="control-label">
											University / Institute :
										</label>
										<input type="text" class="form-control" id="university" name="university[]" value="<?php echo $e_details['university']?>">
									</div>
								</div>
							</div>
							<?php if($e_details['education_type']==3 || $e_details['education_type']==4 || $e_details['education_type']==5){?>


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
						<?php }?>
							<div class="row">
								<div class="col-lg-12">
									<!--<div class="col-lg-5 form-group">
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
									</div>-->
									<div class="col-lg-5 form-group">
										<label for="pass_yr" class="control-label">
											Passing Out Year :
										</label>
										<div class="input-group date pass_yr" id='pass_yr'>
											<input class="form-control pass_yr" type="text" id="pass_yr" name="pass_yr[]" value="<?php echo $e_details['passoutyear']?>">
											<span class="input-group-addon add-on">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-lg-1 form-group"></div>
									<div class="col-lg-5 form-group">
										<label for="school" class="control-label">
											School / College Name :
										</label>
										<input type="text" class="form-control" id="school" name="school[]" value="<?php echo $e_details['school']?>">
										
									</div>
								</div>
							</div>
							
							<!--           <div class="row">
								<div class="col-lg-12">
									<div class="col-xs-4">
										<button type="button" class="btn btn-warning removeButton">Remove Experience</button>
									</div>
								</div>
							</div> -->
							<hr />
							<input type="hidden" name="edu_id[]" value="<?php echo $e_details['id'];?>"/>
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
										Year :
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
										Year :
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
<!-- Add Workshop Deatils Modal -->
<div class="modal fade" id="add_workshop_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Workshop Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_workshop_form" method="post" action="<?php echo base_url().'profile/saveWorkshopData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="workshop_name" class="control-label">
										Workshop Name :
									</label>
									<input type="text" class="form-control" id="workshop_name" name="workshop_name[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="workshop_by" class="control-label">
										Workshop By :
									</label>
									<input type="text" class="form-control" id="workshop_by" name="workshop_by[]" value="">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="workshop_date" class="control-label">
										Year :
									</label>
									<div class="input-group date workshop_date" id='workshop_date'>
										<input class="form-control workshop_date" type="text" id="workshop_date" name="workshop_date[]">
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
									<input type="submit" class="form-control btn btn-success" name="save_workshop_details" id="save_workshop_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Workshop Deatils Modal Ends -->
<!-- edit Workshop Deatils Modal -->
<div class="modal fade" id="edit_workshop_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Workshop Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_workshop_form" method="post" action="<?php echo base_url().'profile/updateWorkshopData';?>">
						<?php
						if(isset($workshopData) && !empty($workshopData))
						{
						foreach($workshopData as $row)
						{
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="workshop_name" class="control-label">
										Workshop Name :
									</label>
									<input type="text" class="form-control" id="workshop_name" name="workshop_name[]" value="<?php echo $row['workshop'];?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="workshop_by" class="control-label">
										Award Prize/Nomination :
									</label>
									<input type="text" class="form-control" id="workshop_by" name="workshop_by[]" value="<?php echo $row['workshop_by'];?>">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="workshop_date" class="control-label">
										Year :
									</label>
									<div class="input-group date workshop_date" id='workshop_date'>
										<input class="form-control workshop_date" type="text" id="workshop_date" name="workshop_date[]" value="<?php echo $row['workshop_date'];?>">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
									<input type="hidden" name="workshop_id[]" value="<?php echo $row['id'];?>"/>
								</div>
							</div>
						</div>
						<?php }} ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="edit_workshop_details" name="edit_workshop_details" value="Update">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- edit Workshop Deatils Modal Ends -->
<!-- Add Language Deatils Modal -->
<div class="modal fade" id="add_language_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Language Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_language_form" method="post" action="<?php echo base_url().'profile/saveLanguageData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-6 form-group">
									<label for="language_name" class="control-label">
										Language :
									</label>
									<input type="text" class="form-control" id="language_name" name="language_name" value="">
								</div>
								<div class="col-lg-6 form-group">
									<label for="language_proficiency" class="control-label">
										Language Level :
									</label>
									<select class="form-control" id="language_proficiency" name="language_proficiency">
										<option value="1">Basic Knowledge</option>
										<option value="2">Conversant</option>
										<option value="3">Proficient</option>
										<option value="4">Fluent</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12" style="margin-left: -15px;">
								<div class="col-lg-9 form-group">
									<div class="col-md-3"><h4>Read</h4></div>
									<div class="col-md-3"><h4>Write</h4></div>
									<div class="col-md-3"><h4>Speak</h4></div>
								</div>
								<div class="col-lg-3 form-group">
									
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: -15px;">
							<div class="col-lg-12" style="margin-left: -15px;">
								<div class="col-lg-9 form-group" style="margin-bottom: 15px;">
									<div class="col-md-3"><input type="checkbox" name="language_read" id="language_read" value="1"></div>
									<div class="col-md-3"><input type="checkbox" name="language_write" id="language_write" value="1"></div>
									<div class="col-md-3"><input type="checkbox" name="language_speak" id="language_speak" value="1"></div>
								</div>
								<div class="col-lg-3 form-group">
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="save_language_details" id="save_language_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Language Deatils Modal Ends -->
<!-- Edit Language Deatils Modal -->
<div class="modal fade" id="edit_language_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Language Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_language_form" method="post" action="<?php echo base_url().'profile/updateLanguageData';?>">
						<?php
						if(isset($languageData) && !empty($languageData))
						{
						foreach($languageData as $row)
						{
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-6 form-group">
									<label for="language_name" class="control-label">
										Language :
									</label>
									<input type="text" class="form-control" id="language_name" name="language_name[]" value="<?php echo $row['language_name']; ?>">
								</div>
								<div class="col-lg-6 form-group">
									<label for="language_proficiency" class="control-label">
										Proficiency :
									</label>
									<select class="form-control" id="language_proficiency" name="language_proficiency[]">
										<option value="1" <?php if($row['language_proficiency']==1){ echo $selected;}?>>Beginner</option>
										<option value="2" <?php if($row['language_proficiency']==2){ echo $selected;}?>>Proficient</option>
										<option value="3" <?php if($row['language_proficiency']==3){ echo $selected;}?>>Expert</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12" style="margin-left: -15px;">
								<div class="col-lg-9 form-group">
									<div class="col-md-3"><h4>Read</h4></div>
									<div class="col-md-3"><h4>Write</h4></div>
									<div class="col-md-3"><h4>Speak</h4></div>
								</div>
								<div class="col-lg-3 form-group">
									
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: -15px;">
							<div class="col-lg-12" style="margin-left: -15px;">
								<div class="col-lg-9 form-group" style="margin-bottom: 15px;">
									<div class="col-md-3"><input type="checkbox" name="language_read[]" id="language_read" value="1" <?php if($row['read']==1){ echo 'checked';}?>></div>
									<div class="col-md-3"><input type="checkbox" name="language_write[]" id="language_write" value="1" <?php if($row['write']==1){ echo 'checked';}?>></div>
									<div class="col-md-3"><input type="checkbox" name="language_speak[]" id="language_speak" value="1" <?php if($row['speak']==1){ echo 'checked';}?>></div>
								</div>
								<div class="col-lg-3 form-group">
									<input type="hidden" name="language_id[]" value="<?php echo $row['id'];?>"/>
								</div>
							</div>
						</div>
					<?php }}?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" name="edit_language_details" id="edit_language_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Edit Language Deatils Modal Ends -->
<!-- Add Location Deatils Modal -->
<div class="modal fade" id="add_location_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Location Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_edu_details" method="post" action="<?php echo base_url().'profile/saveLocationData';?>">
						<div class="row">
							<div class="col-lg-12">
								<?php  $CI =& get_instance();
								$CI->load->model('model_basic');
								$stateList = $CI->model_basic->getAllData('states','id,name','');  
								if(!empty($stateList))
								{
								?>
								<div class="col-lg-5 form-group">

									<label for="location_state" class="control-label">
										State :
									</label>
									<select class="form-control" id="location_state" name="location_state" onclick="getCityList(this)">
										<option value="" selected>Select State</option>
										<?php   foreach ($stateList as $SList) { ?>
										<option value="<?php echo $SList['id'];?>" ><?php echo $SList['name'];?></option>    
										<?php }  ?>
									</select>
								</div>
								<?php }?>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="location_city" class="control-label">
										City :
									</label>
									<select class="form-control" id="location_city" name="location_city">
										<option value="0" selected>Select City</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="save_location_details" name="save_location_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Location Deatils Modal Ends -->
<!-- Edit Location Deatils Modal -->
<div class="modal fade" id="edit_location_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Edit Location Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="edit_edu_details" method="post" action="<?php echo base_url().'profile/updateEducationalData';?>">
						<?php
							if(isset($locationData) && !empty($locationData))
							{
								foreach($locationData as $l_details)
								{
						?>
								<div class="form-group" id="edit_edu_clone">
									<div class="row">
										<div class="col-lg-12">
											<?php  $CI =& get_instance();
											$CI->load->model('model_basic');
											$stateList = $CI->model_basic->getAllData('states','id,name');  
											if(!empty($stateList))
											{
											?>
											<div class="col-lg-5 form-group">

												<label for="location_state" class="control-label">
													State :
												</label>
												<select class="form-control" id="location_state" name="location_state" onchange="getCityList(this)">
													<option value="" selected>Select State</option>
													<?php   foreach ($stateList as $SList) { ?>
													<option value="<?php echo $SList['id'];?>" <?php if($SList['id']==$l_details['state_id']){ echo $selected;}?>><?php echo $SList['name'];?></option>    
													<?php }  ?>
												</select>
											</div>
											<?php }?>
											<div class="col-lg-1 form-group"></div>
											<div class="col-lg-5 form-group">
												<label for="location_city" class="control-label">
													City :
												</label>
												<select class="form-control" id="location_city" name="location_city">
													<option value="<?php echo $l_details['city_id']; ?>" selected><?php echo $l_details['city']; ?></option>
												</select>			
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
<!-- Edit Location Deatils Modal Ends -->
<?php $this->load->view('template/footer'); ?>
 <script>

    </script>

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
trigger: 'click',
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
      function countChar(val) {
      	var len = val.value.length;
        if (len >= 200) {
          val.value = val.value.substring(0, 200);
        } else {
          $('#charNum').text(200 - len);
        }
      };
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
$('.pass_yr').datetimepicker({
format: 'YYYY'
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
format: 'YYYY'
});
});
$(document.body).on('click',function(){
$('.workshop_date').datetimepicker({
format: 'YYYY'
});
});
$(document.body).on('click',function(){
	$('.from_yr').on('dp.change',function(e) {
		$('#add_edu_details').formValidation('revalidateField', 'from_yr[]');
	});
	$('.pass_yr').on('dp.change',function(e) {
		$('#add_edu_details').formValidation('revalidateField', 'pass_yr[]');
	});
	$('.from_yr').on('dp.change',function(e) {
		$('#add_exp_details').formValidation('revalidateField', 'from_date[]');
	});
	$('.award_date').on('dp.change',function(e) {
		$('#add_award_form').formValidation('revalidateField', 'award_date[]');
	});
	$('.workshop_date').on('dp.change',function(e) {
		$('#add_workshop_form').formValidation('revalidateField', 'workshop_date[]');
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
 <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_framework.js"></script>
  <script type="text/javascript">
      var date = new Date();
      $("#dob").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
      });
     	function _calculateAge(birthday) 
      	{ 	// birthday is a date
      		var birthday1=new Date(birthday);
		    var ageDifMs = Date.now() - birthday1.getTime();
		    var ageDate = new Date(ageDifMs); // miliseconds from epoch
		   	// return Math.abs(ageDate.getUTCFullYear() - 1970);
		    //alert(Math.abs(ageDate.getUTCFullYear() - 1970));
		    document.getElementById('age').value = Math.abs(ageDate.getUTCFullYear() - 1970);
		
		if(birthday == '')
		{
		    $.ajax({
		        url: '<?php echo base_url();?>profile/saveFieldValues',
		        type: 'POST',
		        data: {'dob': birthday}
		    })
		    .done(function() {
		        return {
			        valid: true,    
			        message: 'information updated'
		        }
		    })
		    .fail(function() {
		        return {
			        valid: false,       
			        message: 'something went wrong'
		        }
		    })
		    return true;
		}
		else
		{
			    $.ajax({
			        url: '<?php echo base_url();?>profile/saveFieldValues',
			        type: 'POST',
			        data: {'dob': birthday}
			    })
			    .done(function() {
			        return {
				        valid: true,    
				        message: 'information updated'
			        }
			    })
			    .fail(function() {
			        return {
				        valid: false,       
				        message: 'something went wrong'
			        }
			    })
		    return true;
		}
	}
  </script>
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
/*err: {
container: 'popover'
},*/
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
			callback: {
				message: 'City address is not valid',
	                     callback: function (value, validator, $field) {                    
	                     	if(value == '')
	                     	{
	                     		$.ajax({
	                     			url: '<?php echo base_url();?>profile/saveFieldValues',
	                     			type: 'POST',
	                     			data: {'country': value}
	                     		})
	                     		.done(function() {
	                     			return {
		                     			valid: true,    
		                     			 message: 'information updated'
	                     			}
	                     		})
	                     		.fail(function() {
	                     			return {
		                     			valid: false,       
		                     			message: 'something went wrong'
	                     			}
	                     		})
	                     		return true;
	                     	}
	                     	else
	                     	{
	                     		return true;
	                     	}
	                     }
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

			callback: {
				message: 'City address is not valid',
	                     callback: function (value, validator, $field) {                    
	                     	if(value == '')
	                     	{
	                     		$.ajax({
	                     			url: '<?php echo base_url();?>profile/saveFieldValues',
	                     			type: 'POST',
	                     			data: {'city': value}
	                     		})
	                     		.done(function() {
	                     			return {
		                     			valid: true,    
		                     			 message: 'information updated'
	                     			}
	                     		})
	                     		.fail(function() {
	                     			return {
		                     			valid: false,       
		                     			message: 'something went wrong'
	                     			}
	                     		})
	                     		return true;
	                     	}
	                     	else
	                     	{
	                     		return true;
	                     	}
	                     }
				 },
	remote: {
		type: 'POST',
		url: '<?php echo base_url();?>profile/saveFieldValues',
		message: 'Unable to save city name please try again',
		//delay: 1000
		}
	}
},
address: {
verbose: false,
trigger: 'blur',
message: 'Address field is not valid',
validators: {
			notEmpty: {
			message: 'Address is required'
			},
			stringLength: {
			min: 1,
			max: 100,
			message: 'Address must be more than 1 and less than 100 characters long'
			},
			callback: {

				message: 'Address is not valid',
	                     callback: function (value, validator, $field) {                    
	                     	if(value == '')
	                     	{
	                     		$.ajax({
	                     			url: '<?php echo base_url();?>profile/saveFieldValues',
	                     			type: 'POST',
	                     			data: {'address': value}
	                     		})
	                     		.done(function() {
	                     			return {
		                     			valid: true,    
		                     			 message: 'information updated'
	                     			}
	                     		})
	                     		.fail(function() {
	                     			return {
		                     			valid: false,       
		                     			message: 'something went wrong'
	                     			}
	                     		})
	                     		return true;
	                     	}
	                     	else
	                     	{
	                     		return true;
	                     	}
	                     }
				 },
	remote: {
		type: 'POST',
		url: '<?php echo base_url();?>profile/saveFieldValues',
		message: 'Unable to save address please try again',
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
		callback: {
			message: 'Website address is not valid',
                     callback: function (value, validator, $field) {                    
                     	if(value == '')
                     	{
                     		$.ajax({
                     			url: '<?php echo base_url();?>profile/saveFieldValues',
                     			type: 'POST',
                     			data: {'website': value}
                     		})
                     		.done(function() {
                     			return {
	                     			valid: true,    
	                     			 message: 'information updated'
                     			}
                     		})
                     		.fail(function() {
                     			return {
	                     			valid: false,       
	                     			message: 'something went wrong'
                     			}
                     		})
                     		return true;
                     	}
                     	else
                     	{
                     		return true;
                     	}
                     }
		},
		remote: {
		type: 'POST',
		url: '<?php echo base_url();?>profile/saveFieldValues',
		message: 'Unable to save website link please try again',
		//delay: 1000
		}
	}
},
contactNo: {
verbose: false,
trigger: 'blur',
message: 'Contact field is not valid',
validators: {
		notEmpty: {
				message: 'Contact field is required'
		},
		digits:{
			min: 10,
			max: 10,
			message: 'Contact field is not valid'			
		},		
		callback: {
			message: 'Contact field is not valid',
                     callback: function (value, validator, $field) {                    
                     	if(value == '')
                     	{
                     		$.ajax({
                     			url: '<?php echo base_url();?>profile/saveFieldValues',
                     			type: 'POST',
                     			data: {'contactNo': value}
                     		})
                     		.done(function() {
                     			return {
	                     			valid: true,    
	                     			 message: 'information updated'
                     			}
                     		})
                     		.fail(function() {
                     			return {
	                     			valid: false,       
	                     			message: 'something went wrong'
                     			}
                     		})
                     		return true;
                     	}
                     	else
                     	{
                     		return true;
                     	}
                     }
		},
		remote: {
		type: 'POST',
		url: '<?php echo base_url();?>profile/saveFieldValues',
		message: 'Unable to save phone no please try again',
		//delay: 1000
		}
	}
},
maritalStatus: {
verbose: false,
trigger: 'blur',
message: 'Marital Status field is not valid',
validators: {
			callback: {
				message: 'Marital Status address is not valid',
	                     callback: function (value, validator, $field) {                    
	                     	if(value == '')
	                     	{
	                     		alert("test");
	                     		$.ajax({
	                     			url: '<?php echo base_url();?>profile/saveFieldValues',
	                     			type: 'POST',
	                     			data: {'maritalStatus': value}
	                     		})
	                     		.done(function() {
	                     			return {
		                     			valid: true,    
		                     			 message: 'information updated'
	                     			}
	                     		})
	                     		.fail(function() {
	                     			return {
		                     			valid: false,       
		                     			message: 'something went wrong'
	                     			}
	                     		})
	                     		return true;
	                     	}
	                     	else
	                     	{
	                     		return true;
	                     	}
	                     }
				 },

remote: {
type: 'POST',
url: '<?php echo base_url();?>profile/saveFieldValues',
message: 'Unable to save Marital Status please try again',
//delay: 1000
}
}
},
about_me: {
verbose: false,
trigger: 'blur',
	validators:
	{
		notEmpty: {
				message: 'About Me is required'
		},
		stringLength: {
			min: 100,
			max: 200,
			message: 'About Me must be more than 100 and less than 200 characters long'
		},
		callback: {
					message: 'About Me is not valid',
                     callback: function (value, validator, $field) {                    
                     	if(value == '')
                     	{
                     		$.ajax({
                     			url: '<?php echo base_url();?>profile/saveFieldValues',
                     			type: 'POST',
                     			data: {'about_me': value}
                     		})
                     		.done(function() {
                     			return {
	                     			valid: true,    
	                     			 message: 'information updated'
                     			}
                     		})
                     		.fail(function() {
                     			return {
	                     			valid: false,       
	                     			message: 'something went wrong'
                     			}
                     		})
                     		return true;
                     	}
                     	else
                     	{
                     		return true;
                     	}
                    }
			 },
			 
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
},
dob: {
verbose: false,
trigger: 'blur',
message: 'Dob field is not valid',
validators: {
		
		callback: {
			message: 'dob address is not valid',
                     	callback: function (value, validator, $field) { 
                     	//alert(value);                   
                     	if(value == '')
                     	{
                     		$.ajax({
                     			url: '<?php echo base_url();?>profile/saveFieldValues',
                     			type: 'POST',
                     			data: {'dob': value}
                     		})
                     		.done(function() {
                     			return {
	                     			valid: true,    
	                     			 message: 'information updated'
                     			}
                     		})
                     		.fail(function() {
                     			return {
	                     			valid: false,       
	                     			message: 'something went wrong'
                     			}
                     		})
                     		return true;
                     	}
                     	else
                     	{
                     		return true;
                     	}
                     }
		 },
		remote: {
		type: 'POST',
		url: '<?php echo base_url();?>profile/saveFieldValues',
		message: 'Unable to save dob please try again',
		//delay: 1000
		}
	}
},
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
message: 'The skill name is required and cannot be empty'
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
}).on('click', '.addButton', function() {
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
$('body').on('click','.deleteSkill',function(event){
var id = $(this).data('id');
var fieldName='id';
var skill_name=$(this).siblings('span').text();
$("#edit_skills input[value='"+skill_name+"']").parent('.col-lg-5').next('.col-lg-5').remove();
$("#edit_skills input[value='"+skill_name+"']").parent('.col-lg-5').remove();
if(confirm('Are you sure you want to remove this Skill?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_skills',
type: 'POST',
data: {id: id},
success:function (response){
if(response == 1)
{
/*$('#user_skills').load('<?php echo current_url();?> #user_skills');
var url = $('#base_url').val();
var uId = '<?php echo $this->session->userdata("front_user_id");?>';
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
});i++;}, 2000);
});
window.location='<?php echo current_url()?>';
$('.left_side').load('<?php echo current_url();?> #Lhs_content');
}
});*/
var message  = 'Skill removed Successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
}
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
//$('#education').load('<?php echo base_url()?>profile/edit_profile #education');
var message  = 'Educational details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
}
});
}
});
$('body').on('click','.remove_exp_details',function(){
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
//$('#work_exp').load('<?php echo base_url()?>profile/edit_profile #work_exp');
var message  = 'Experience details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
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
//$('#award').load('<?php echo base_url()?>profile/edit_profile #award');
var message  = 'Award & publication details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
}
})
}
});
$('.remove_language_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_language',
type: 'POST',
data: {id: id},
success:function (response){
//$('#award_details'+id).remove();
//$('#award').load('<?php echo base_url()?>profile/edit_profile #award');
var message  = 'Language details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
}
})
}
});
$('.remove_location_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_location',
type: 'POST',
data: {id: id},
success:function (response){
//$('#award_details'+id).remove();
//$('#award').load('<?php echo base_url()?>profile/edit_profile #award');
var message  = 'Location details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
}
})
}
});
$('.remove_workshop_details').on('click',function(){
var id = $(this).data('id');
var fieldName='id';
if(confirm('Are you sure you want to remove this record?')==true)
{
$.ajax({
url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/users_workshop',
type: 'POST',
data: {id: id},
success:function (response){
//$('#award_details'+id).remove();
//$('#award').load('<?php echo base_url()?>profile/edit_profile #award');
var message  = 'Workshop details removed successfully.';
var ticon = 'fa-check-circle';
$.toaster({ priority : 'success', title : 'success', message : message, ticon : ticon });
window.location='<?php echo current_url()?>';
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
/* Image Upload validation  */
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
var ticon  = 'fa-check-circle';
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
var ticon  = 'fa-times-circle';
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
/* Image Upload validation  */
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
education_type: {
validators: {
notEmpty: {
message: 'Education is required'
}
}
},
'pass_yr[]': {
validators: {
notEmpty: {
message: 'Education passing year required'
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
			}
		}
	}
    }
})
$('#add_workshop_form')
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
'workshop_name[]': {
validators: {
notEmpty: {
message: 'Workshop name is required'
}
}
},
'workshop_by[]': {
validators: {
notEmpty: {
message: 'Workshop by is required'
}
}
},
'workshop_date[]': {
validators: {
notEmpty: {
message: 'workshop date is required'
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

$("#diskspace").percircle();

<?php $i++;}}?>
$(document).ready(function() {
$(".scroll").click(function(event) {
var fixedH = $(".navbar").outerHeight(true);
$('html,body').animate({ scrollTop: $(this.hash).css("padding-top","50px").offset().top}, 1000);
});
});
$(function(){
var note = $('#note');
<?php if(isset($difference) && $difference > 0)
{
?>
ts = (new Date()).getTime() + parseInt('<?php echo $difference;?>')*1000;
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
<script type="text/javascript">
function saveMaritalStatus(mstatus){
	var maritalStatus=mstatus;
		
	if(maritalStatus == '')
	{
		$.ajax({
		url: '<?php echo base_url();?>profile/saveFieldValues',
		type: 'POST',
		data: {'maritalStatus': maritalStatus}
	})
	.done(function() {
	return {
		valid: true,    
		message: 'information updated'
	}
	})
	.fail(function() {
	return {
		valid: false,       
		message: 'something went wrong'
	}
	})
	return true;
	}
	else
	{
		$.ajax({
			url: '<?php echo base_url();?>profile/saveFieldValues',
			type: 'POST',
			data: {'maritalStatus': maritalStatus}
		})
		.done(function() {
		return {
			valid: true,    
			message: 'information updated'
		}
		})
		.fail(function() {
		return {
			valid: false,       
			message: 'something went wrong'
		}
		})
	return true;
	}
}
</script>
<script type="text/javascript">
	
	$(document).ready(function(){
	    $("#education_type").change(function(){
	        $(this).find("option:selected").each(function(){
	            var optionValue = $(this).attr("value");
	            if(optionValue == 3 || optionValue == 4 || optionValue == 5){
	                $("#qualificationStream").show();
	            } else{
	                $("#qualificationStream").hide();
	            }
	        });
	    }).change();
	});
	
</script>
<script type="text/javascript">
	function getCityList(element)
	{   

	
	 var stateId=$('#location_state').val();
	 var url=$('#base_url').val();
	 $.ajax({
	       type: "POST",
	       data:{stateId:stateId},
	       url: url+"profile/getCityList",
	       success:function(data)
	       {
	         if(data!='')
	         {
	           $('#location_city').html(data);
	         }
	         else
	         {
	           $('#location_city').html(data);
	         }
	     }
	     });     
	}
</script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
['Task', 'Disc Space'],
['Free space',     <?php echo round($allowedDiskSpace[0]['description'] - (float)$usedDiskSpace,2);?>],
['Used Space',      <?php echo round($usedDiskSpace,2);?>]
]);
var options = {
title: 'Maximum allowed disk space : <?php echo $allowedDiskSpace[0]['description'];?> MB \n Used space : <?php echo $usedDiskSpace;?> \n Free space : <?php echo round($allowedDiskSpace[0]['description'] - (float)$usedDiskSpace,2);?> MB',
backgroundColor:'#303030',
is3D: true,
titleTextStyle:{ color: '#fff'},
fontSize:12,
chartArea:{left:0,top:50,width:'100%',height:'60%'}
};
var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
chart.draw(data, options);
}
</script> -->


