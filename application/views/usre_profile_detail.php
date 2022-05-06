<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/formValidation.min.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/percircle.css"/>
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
		<div class="fix_content mCustomScrollbar light" id="content-2" data-mcs-theme="minimal-dark"">
			<div class="profile_photo">
				
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
								if ($user_profile->courseName !='') {
									$ci->load->model('user_model');
									$courseData=$ci->user_model->getCourseData($user_profile->courseName);
									if(!empty($courseData)){
										$courseName = $courseData['course_name'];
										$courseType = $courseData['course_type'];
									}
								}

						$profileCompletion=0;
						$profileImage = $user_profile->profileImage;
						if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)
						{
						$profileCompletion=10;
						?>
						
						<img id="OpenImgUpload_new" class="" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>"/>
						<?php }else{?>
						<img id="OpenImgUpload_new" class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />
						<?php }?>
						
					</div>
				
				
				<?php
				 if($user_profile->instituteName !=''){  ?>
				 <div>
				 <h4 class="main"> Institute : <?php echo $user_profile->instituteName;?></h4>				
				</div>
				<?php }?>
				<?php 
				if ($user_profile->courseName !='') { ?>
				<div>
				 	<h4 class="main"> Course : <?php 
						if($courseName != ''){
							echo $courseName;
						}else{
							echo $user_profile->courseName;
						}
					?>
					</h4>				
				</div>
								
				<?php  }
				 if($user_profile->registration_date !='' && $user_profile->registration_date !='0000-00-00'){  ?>
				 <div>
				 	<h4 class="main"> Registration Date : <?php echo date('d-m-Y',strtotime($user_profile->registration_date));?></h4>				
				</div>
				<?php } 
				  if(isset($end_date) && $end_date !='0000-00-00'){  ?>
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
					$followingUserData = $ci->model_basic->getCountWhere('user_follow',array('followingUser'=>$user_ID));
					$appreciated=$ci->user_model->getUserLikedOnProject($user_ID);
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
			
			</div>
		</div>
	</div>
	<div class="col-lg-9 mid_content" style="border-left:1px solid #d0d0d0">
		<div id="basic_info">
			<div class="basic_info">
				<h3>
				<?php echo ucwords($user_profile->firstName.' '.$user_profile->lastName);?>
				</h3>

				<?php if(($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'usre_profile_detail'  &&  $this->uri->segment(3) == $this->session->userdata('front_user_id') ) || ($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'edit_profile') )
				{  ?>
				<button class="btn btn_blue" onclick="window.location='<?php echo base_url()?>profile';">					
				My Portfolio
				</button>
				<?php  }   ?>

				<ul>
					<?php if($user_profile->profession!=''){?>
						<li>
							<?php echo $user_profile->profession;?>
						</li>
					<?php }?>
					
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
					Mobile No :&nbsp;
					<span>
						<?php echo $user_profile->contactNo ;?>
					</span>
				</div>
				<br/>
				<div>
					Email ID :&nbsp;
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
				<div>
					DOB :&nbsp;
					<span>
						<?php echo (isset($user_profile->dob) && $user_profile->dob!='0000-00-00')?date('d-m-Y',strtotime($user_profile->dob)):'NA' ;?>
					</span>&nbsp;&nbsp;&nbsp;
					Age :&nbsp
					<span> 
						<?php echo (isset($user_profile->age) && !empty($user_profile->age) && $user_profile->age!='0')?$user_profile->age:'NA' ;?>
					</span>
				</div>
				<br>
				<?php if (isset($user_profile->marital_status) && !empty($user_profile->marital_status) && $user_profile->marital_status!='0') {?>
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
		<?php  if(isset($skillsData) && !empty($skillsData))
					{   ?>
		<div id="user_skills" class="user_skills">
					<div class="experience">
						<h4 class="main">
						Skills :
						</h4>						
					</div>
					<?php
					
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
						
					</div>
					<?php $i++;}?>
				</div>
				<?php  }  ?>
		<div class="clearfix"></div>
		<div id="work_exp" class="work_exp">
			<div class="experience">
				<h4 class="main">
				Work / Internship / Freelance  Experience :
				</h4>				
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
		<div id="education" class="education">
			<div class="experience">
				<h4 class="main">
				Education :
				</h4>				
			</div>
			<?php
		
			if(!empty($educationData))
			{		
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
				
				<?php if(!empty($e_details['university']))
				{ ?>
				<h5>
					<?php echo $e_details['university']; ?>
				</h5>
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
			</div>
			<?php } }else{?>
			<div class="experience">
				No Location added.
			</div>
			<?php }?>
		</div>
		<?php if((isset($socialData['facebook']) && $socialData['facebook']!='')  || (isset($socialData['twitter']) && $socialData['twitter']!='') || (isset($socialData['pinterest']) && $socialData['pinterest']!='') || (isset($socialData['instagram']) && $socialData['instagram']!='') || (isset($socialData['linkedin']) && $socialData['linkedin']!='')) {?>
		<div id="OnTheWeb" class="OnTheWeb" >
			<h4 class="main " style="border-bottom: 1px solid #4a4949; margin-bottom:15px; padding-bottom:15px;">
				My work on the web :
			</h4>
			
			<div class="web_content">
				<form id="creosouls" method="post" action="<?php echo base_url();?>profile/edit_profile">
					<img src="<?php echo base_url();?>assets/images/creosouls_logo.png" alt="My Instagram">
					<?php
						echo '<label id="creosouls_label"><a target="_blank" href="'.base_url().'profile/usre_profile_detail/'.$user_profile->id.'">'.base_url().'profile/usre_profile_detail/'.$user_profile->id.'</a></label>';
					?>
				</form>
			</div>
			<div class="web_content">					
			<?php
			if(isset($socialData['linkedin']) && $socialData['linkedin']!='')
			{  ?>
				<img src="<?php echo base_url();?>assets/images/in.png" alt="My Linkedin">  
			<?php 
			echo '<label id="linkedin_label"><a target="_blank" href="'.$socialData['linkedin'].'">'.$socialData['linkedin'].'</a></label>';
			?>					 
			<?php
			}
			?>				
			</div>
			<div class="web_content">
			<?php
			if(isset($socialData['pinterest']) && $socialData['pinterest']!='')
			{  ?>
				<img src="<?php echo base_url();?>assets/images/pintrst.png" alt="My Pinterest">
			<?php
			echo '<label id="pinterest_label"><a target="_blank" href="'.$socialData['pinterest'].'">'.$socialData['pinterest'].'</a></label>';
			?>
			<?php
			}
			?>
			</div>
			<div class="web_content">
			<?php
			if(isset($socialData['deviantart']) && $socialData['deviantart']!='')
			{  ?>
				<img src="<?php echo base_url();?>assets/images/deviantart-icon-logo.png" alt="My Deviantart">  
			<?php 
				echo '<label id="deviantart_label"><a target="_blank" href="'.$socialData['deviantart'].'">'.$socialData['deviantart'].'</a></label>';
			?>					
			<?php
			}
			?>
			</div>
			<div class="web_content">
			<?php
			if(isset($socialData['behance']) && $socialData['behance']!='')
			{  ?>
				<img src="<?php echo base_url();?>assets/images/behance-icon-logo.png" alt="My Behance">  
			<?php 
				echo '<label id="behance_label"><a target="_blank" href="'.$socialData['behance'].'">'.$socialData['behance'].'</a></label>';
			?>					
			<?php
			}
			?>
			
		</div>

		<?php  }   ?>

		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Awards / Achievements :
				</h4>				
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
				<p>
					<?php echo $row['prize'];?><br> <?php echo $row['dateRecieved'];?>
				</p>
			</div>
			<?php } }else{?>
			<div class="experience">
				No Awards/Achievements added.
			</div>
			<?php }?>
		</div>
		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Workshops / Webinars :
				</h4>				
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
					<p>
						<?php echo $row['workshop_by'];?><br> <?php echo $row['workshop_date'];?>
					</p>
				</div>
			<?php } }else{?>
			<div class="experience">
				No Workshops/Webinars added.
			</div>
			<?php }?>
		</div>
		<div id="award" class="awards">
			<div class="experience">
				<h4 class="main">
				Language  :
				</h4>
			</div>
			
			<?php
			if(!empty($languageData))
			{?>
			<div class="row" style="margin-left: -30px;">
				<div class="col-md-8" style="float:left;">
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
					<div class="col-md-1"><input type="checkbox" name="new_project_followed" id="new_project_followed" style="float:center;" <?php if($row['read']==1){ echo 'checked';}?>></div>
					<div class="col-md-1"><input type="checkbox" name="new_project_followed" id="new_project_followed" <?php if($row['write']==1){ echo 'checked';}?>></div>
					<div class="col-md-1"><input type="checkbox" name="new_project_followed" id="new_project_followed" <?php if($row['speak']==1) {  echo 'checked'; } ?>>
					</div>
					
				</div>
				<div class="col-md-4">
					
				</div>
			</div>
			<?php } }else{?>
			<div class="experience">
				No Language added.
			</div>
			<?php }?>
	</div>
</div>
<div class="clearfix"></div>




<?php $this->load->view('template/footer'); ?>
<script>

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


</script>