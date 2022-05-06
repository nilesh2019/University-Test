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
/*	.help-block{
		margin: -56px 0px 0px 100px !important;
	}*/
	.subscription {
	    color: #57ba2c;
	    font-size: 16px;
	    font-weight: bold;
	    margin-bottom:5px;
	}
	label{
		margin-right:25px;
	}
	#q1a,#q2a,#q3a,#q4a,#q5a{
		margin-left:25px;
	}
	.quesColor{
		color:#00b4ff;
	}
	.error-span p{
		color:red;
		font-size: 12px;
		margin-left:25px;
	}
	.navbar {
    background-color:rgb(0,0,0);
	}
  .hideDiv{
    display:none;
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
						<img id="OpenImgUpload_new" class="" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />
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
				<a href="<?php echo base_url();?>profile/edit_profile#basic_info" class="scroll">
					Basic Information
				</a>
			</h4>
			<h4>
				<a href="<?php echo base_url();?>profile/edit_profile#work_exp" class="scroll">
					Work Experience
				</a>
			</h4>
			<h4>
				<a href="<?php echo base_url();?>profile/edit_profile#education" class="scroll">
					Education
				</a>
			</h4>
			<h4>
				<a href="<?php echo base_url();?>profile/edit_profile#OnTheWeb" class="scroll">
					On the Web
				</a>
			</h4>
			<h4>
				<a href="<?php echo base_url();?>profile/edit_profile#award" class="scroll">
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
				<a href="#" class="scroll" data-toggle="modal" data-target="#googleDriveSetting">
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
				<a href="<?php echo base_url();?>profile/edit_profile#flag_status" class="scroll">
					Monitor Flag
				</a>
			</h4>
			<h4>
				<a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($this->session->userdata('user_institute_name')));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">Manage Institute Data</a>
			</h4>
			<?php } if($user_profile->type==2 && $user_profile->company!=''){?>
			<h4>
				<a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($this->session->userdata('user_company_name')));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>/<?php echo urlencode(base64_encode($this->session->userdata('user_type')));?>">Manage Jobs Data</a>
			</h4>
			<?php }?>
		</div>
	
    	<div class="Lhs_content content44 ">
			<div class="profile_complation">
				<h4>
					Profile Completion Meter (<?php echo $user_profile->profile_complete;?>%)
				</h4>
				<div class="progress">
					<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $user_profile->profile_complete;?>%">
						<span class="sr-only">
							<?php echo $user_profile->profile_complete;?>% Complete
						</span>
					</div>
				</div>
				<p>
					Complete your profile to get more  noticed. People will know you better.
				</p>
			</div>
			<div class="profile_complation">
				<h4>
					Maximum allowed disk space :-<?php echo $allowedDiskSpace[0]['description'];?> MB
				</h4>
				<h4>
					Used disk space :-<?php echo $usedDiskSpace;?>
				</h4>
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
		
			<!-- <div class="project-info">
					<a class="btn white_btn" href="<?php echo base_url();?>payment">Buy Space</a>
			</div> -->
            <div id="piechart_3d" style="width: 100%; height: 200px;"></div>
		</div>
	</div>
</div>
	<div class="col-lg-9 mid_content" style="padding:25px;font-size:14px;min-height:900px;">
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
		<h1>Feedback Form</h1>
		<?php
			if(!empty($feedbackInstance)){
		?>
		<form id="feedbackFrm" role="form" action="<?php echo base_url();?>profile/submitFeedback" method="post" >
			<div class="form-group">
			    <label for="" class="quesColor">Select Feedback Instance</label>
			    <ul class="answers">
			       <select name="feedbackInstance" id="feedbackInstance">
			       <option value="" selected>Select Feedback Instance</option>
			       <?php
		       	foreach ($feedbackInstance as $val) {
		       	?>
			       		<option value="<?=$val['id']?>" <?php if($lastFeedback['instance_id']==$val['id'] || $val['id']== set_value('feedbackInstance')){ echo "selected"; } ?> ><?=$val['name']?></option>
		       	<?php
		       	}
			       ?>
			       </select>
			       <input type="button" name="Go" value="Go" id="selectedInstance">
                        <span style="color:green;" class="hideDiv"><hr/>(Note:- <span style="color:red;">All fields are mandatory.</span>)<hr/></span>
			    </ul>
			    <span class="error-span"><?php echo form_error('feedbackInstance');?></span>
			</div>
		  <div class="form-group hideDiv">
		    <label for="email" class="quesColor">1. Did your class ever cancel due to absence of faculty?</label>
		    <ul class="answers">
		       <input type="radio" id="q1a" value="Never" checked name="q1" <?php if($lastFeedback['q1']==''){ echo 'checked="checked"';} if($lastFeedback['q1']=='Never'){echo "checked";}?>><label for="q1a">Never</label>
		       <input type="radio" id="q1b" value="Sometimes" name="q1" <?php if($lastFeedback['q1']=='Sometimes'){echo "checked";}?>><label for="q1b">Sometimes</label>
		       <input type="radio" id="q1c" value="Frequently" name="q1" <?php if($lastFeedback['q1']=='Frequently'){echo "checked";}?>><label for="q1c">Frequently</label>
		       <input type="radio" id="q1d" value="Mostly" name="q1" <?php if($lastFeedback['q1']=='Mostly'){echo "checked";}?>><label for="q1d">Mostly</label><br>
		       </ul>
		       <span class="error-span"><?php echo form_error('q1');?></span>
		  </div>
		  <div class="form-group hideDiv">
		    <label for="email" class="quesColor">2. Were you issued courseware for the module(s) being taught?</label>
		    <ul class="answers">
		       <input type="radio" id="q2a" value="Mostly" checked name="q2" <?php if($lastFeedback['q2']=='Mostly'){echo "checked";}?>><label for="q2a">Mostly</label>
		       <input type="radio" id="q2b" value="Frequently" name="q2" <?php if($lastFeedback['q2']=='Frequently'){echo "checked";}?>><label for="q2b">Frequently</label>
		       <input type="radio" id="q2c" value="Sometimes" name="q2" <?php if($lastFeedback['q2']=='Sometimes'){echo "checked";}?>><label for="q2c">Sometimes</label>
		       <input type="radio" id="q2d" value="Never" name="q2" <?php if($lastFeedback['q2']=='Never'){echo "checked";}?>><label for="q2d">Never</label><br>
		       </ul>
		       <span class="error-span"><?php echo form_error('q2');?></span>
		  </div>
		  <div class="form-group hideDiv">
		    <label for="email" class="quesColor">3. Do theory classes start and end at right time?</label>
		    <ul class="answers">
		       		<input type="radio" id="q3a" value="Mostly" checked name="q3" <?php if($lastFeedback['q3']=='Mostly'){echo "checked";}?>><label for="q3a">Mostly</label>
     		       <input type="radio" id="q3b" value="Frequently" name="q3" <?php if($lastFeedback['q3']=='Frequently'){echo "checked";}?>><label for="q3b">Frequently</label>
     		       <input type="radio" id="q3c" value="Sometimes" name="q3" <?php if($lastFeedback['q3']=='Sometimes'){echo "checked";}?>><label for="q3c">Sometimes</label>
     		       <input type="radio" id="q3d" value="Never" name="q3" <?php if($lastFeedback['q3']=='Never'){echo "checked";}?>><label for="q3d">Never</label><br>
		       </ul>
		       <span class="error-span"><?php echo form_error('q3');?></span>
		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">4. Are the modules taken as per the timetable?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q4a" value="Mostly" checked name="q4" <?php if($lastFeedback['q4']=='Mostly'){echo "checked";}?>><label for="q4a">Mostly</label>
       		       <input type="radio" id="q4b" value="Frequently" name="q4" <?php if($lastFeedback['q4']=='Frequently'){echo "checked";}?>><label for="q4b">Frequently</label>
       		       <input type="radio" id="q4c" value="Sometimes" name="q4" <?php if($lastFeedback['q4']=='Sometimes'){echo "checked";}?>><label for="q4c">Sometimes</label>
       		       <input type="radio" id="q4d" value="Never" name="q4" <?php if($lastFeedback['q4']=='Never'){echo "checked";}?>><label for="q4d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q4');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">5. Does the faculty teach concepts and clear doubts to your satisfaction?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q5a" value="Mostly" checked name="q5" <?php if($lastFeedback['q5']=='Mostly'){echo "checked";}?>><label for="q5a">Mostly</label>
       		       <input type="radio" id="q5b" value="Frequently" name="q5" <?php if($lastFeedback['q5']=='Frequently'){echo "checked";}?>><label for="q5b">Frequently</label>
       		       <input type="radio" id="q5c" value="Sometimes" name="q5" <?php if($lastFeedback['q5']=='Sometimes'){echo "checked";}?>><label for="q5c">Sometimes</label>
       		       <input type="radio" id="q5d" value="Never" name="q5" <?php if($lastFeedback['q5']=='Never'){echo "checked";}?>><label for="q5d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q5');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">6. Does the theory class get conducted OHP or terminal?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q6" <?php if($lastFeedback['q6']=='Mostly'){echo "checked";}?>><label for="q6a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q6" <?php if($lastFeedback['q6']=='Frequently'){echo "checked";}?>><label for="q6b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q6" <?php if($lastFeedback['q6']=='Sometimes'){echo "checked";}?>><label for="q6c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q6" <?php if($lastFeedback['q6']=='Never'){echo "checked";}?>><label for="q6d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q6');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">7. Your understanding of the topics covered?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q7" <?php if($lastFeedback['q7']=='Mostly'){echo "checked";}?>><label for="q7a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q7" <?php if($lastFeedback['q7']=='Frequently'){echo "checked";}?>><label for="q7b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q7" <?php if($lastFeedback['q7']=='Sometimes'){echo "checked";}?>><label for="q7c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q7" <?php if($lastFeedback['q7']=='Never'){echo "checked";}?>><label for="q7d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q7');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">8. Is technical assistance always available in the lab?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q8" <?php if($lastFeedback['q8']=='Mostly'){echo "checked";}?>><label for="q8a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q8" <?php if($lastFeedback['q8']=='Frequently'){echo "checked";}?>><label for="q8b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q8" <?php if($lastFeedback['q8']=='Sometimes'){echo "checked";}?>><label for="q8c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q8" <?php if($lastFeedback['q8']=='Never'){echo "checked";}?>><label for="q8d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q8');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">9. Are you assisted for the lab exercises given in the courseware?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q9"  <?php if($lastFeedback['q9']=='Mostly'){echo "checked";}?>><label for="q9a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q9"  <?php if($lastFeedback['q9']=='Frequently'){echo "checked";}?>><label for="q9b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q9"  <?php if($lastFeedback['q9']=='Sometimes'){echo "checked";}?>><label for="q9c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q9"  <?php if($lastFeedback['q9']=='Never'){echo "checked";}?>><label for="q9d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q9');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">10. Were you able to workout lab exercises with faculty’s help in the lab?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q10"  <?php if($lastFeedback['q10']=='Mostly'){echo "checked";}?>><label for="q10a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q10"  <?php if($lastFeedback['q10']=='Frequently'){echo "checked";}?>><label for="q10b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q10"  <?php if($lastFeedback['q10']=='Sometimes'){echo "checked";}?>><label for="q10c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q10"  <?php if($lastFeedback['q10']=='Never'){echo "checked";}?>><label for="q10d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q10');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">11. Do you always get a machine to work during the regular lab hours?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q11"  <?php if($lastFeedback['q11']=='Mostly'){echo "checked";}?>><label for="q11a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q11"  <?php if($lastFeedback['q11']=='Frequently'){echo "checked";}?>><label for="q11b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q11"  <?php if($lastFeedback['q11']=='Sometimes'){echo "checked";}?>><label for="q11c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q11"  <?php if($lastFeedback['q11']=='Never'){echo "checked";}?>><label for="q11d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q11');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">12. Have you encountered a problem with respect to the software in the lab?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Never" checked name="q12" <?php if($lastFeedback['q12']=='Never'){echo "checked";}?>><label for="q12a">Never</label>
  		       <input type="radio" id="q1b" value="Sometimes" name="q12" <?php if($lastFeedback['q12']=='Sometimes'){echo "checked";}?>><label for="q12b">Sometimes</label>
  		       <input type="radio" id="q1c" value="Frequently" name="q12" <?php if($lastFeedback['q12']=='Frequently'){echo "checked";}?>><label for="q12c">Frequently</label>
  		       <input type="radio" id="q1d" value="Mostly" name="q12" <?php if($lastFeedback['q12']=='Mostly'){echo "checked";}?>><label for="q12d">Mostly</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q12');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">13. Have you encountered a problem with respect to the machine in the lab?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Never" checked name="q13" <?php if($lastFeedback['q13']=='Never'){echo "checked";}?>><label for="q13a">Never</label>
  		       <input type="radio" id="q1b" value="Sometimes" name="q13" <?php if($lastFeedback['q13']=='Sometimes'){echo "checked";}?>><label for="q13b">Sometimes</label>
  		       <input type="radio" id="q1c" value="Frequently" name="q13" <?php if($lastFeedback['q13']=='Frequently'){echo "checked";}?>><label for="q13c">Frequently</label>
  		       <input type="radio" id="q1d" value="Mostly" name="q13" <?php if($lastFeedback['q13']=='Mostly'){echo "checked";}?>><label for="q13d">Mostly</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q13');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">14. Does machine problems get sorted within a stipulated time?</label>
  		    	<ul class="answers">
  		       	<input type="radio" id="q1a" value="Mostly" checked name="q14" <?php if($lastFeedback['q14']=='Mostly'){echo "checked";}?>><label for="q14a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q14" <?php if($lastFeedback['q14']=='Frequently'){echo "checked";}?>><label for="q14b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q14" <?php if($lastFeedback['q14']=='Sometimes'){echo "checked";}?>><label for="q14c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q14" <?php if($lastFeedback['q14']=='Never'){echo "checked";}?>><label for="q14d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q14');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">15. Are the assignments and examinations conducted as per the schedule?</label>
  		    <ul class="answers">
  		       	<input type="radio" id="q1a" value="Mostly" checked name="q15" <?php if($lastFeedback['q15']=='Mostly'){echo "checked";}?>><label for="q15a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q15" <?php if($lastFeedback['q15']=='Frequently'){echo "checked";}?>><label for="q15b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q15" <?php if($lastFeedback['q15']=='Sometimes'){echo "checked";}?>><label for="q15c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q15" <?php if($lastFeedback['q15']=='Never'){echo "checked";}?>><label for="q15d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q15');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">16. Are you evaluated after each module (test /assignment/ quiz)?</label>
  		    <ul class="answers">
  		       	<input type="radio" id="q1a" value="Mostly" checked name="q16" <?php if($lastFeedback['q16']=='Mostly'){echo "checked";}?>><label for="q16a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q16" <?php if($lastFeedback['q16']=='Frequently'){echo "checked";}?>><label for="q16b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q16" <?php if($lastFeedback['q16']=='Sometimes'){echo "checked";}?>><label for="q16c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q16" <?php if($lastFeedback['q16']=='Never'){echo "checked";}?>><label for="q16d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q16');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">17. Your satisfaction level with respect to faculty guidance on the project.</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Excellent" checked name="q17" <?php if($lastFeedback['q17']=='Excellent'){echo "checked";}?>><label for="q17a">Excellent</label>
       		       <input type="radio" id="q1b" value="Good" name="q17" <?php if($lastFeedback['q17']=='Good'){echo "checked";}?>><label for="q17b">Good</label>
       		       <input type="radio" id="q1c" value="Average" name="q17" <?php if($lastFeedback['q17']=='Average'){echo "checked";}?>><label for="q17c">Average</label>
       		       <input type="radio" id="q1d" value="Fair" name="q17" <?php if($lastFeedback['q17']=='Fair'){echo "checked";}?>><label for="q17d">Fair</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q17');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">18. Is the feedback taken from you at least once a month?</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Mostly" checked name="q18" <?php if($lastFeedback['q18']=='Mostly'){echo "checked";}?>><label for="q18a">Mostly</label>
       		       <input type="radio" id="q1b" value="Frequently" name="q18" <?php if($lastFeedback['q18']=='Frequently'){echo "checked";}?>><label for="q18b">Frequently</label>
       		       <input type="radio" id="q1c" value="Sometimes" name="q18" <?php if($lastFeedback['q18']=='Sometimes'){echo "checked";}?>><label for="q18c">Sometimes</label>
       		       <input type="radio" id="q1d" value="Never" name="q18" <?php if($lastFeedback['q18']=='Never'){echo "checked";}?>><label for="q18d">Never</label><br>
  		       </ul>
  		       <span class="error-span"><?php echo form_error('q18');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">19. Relevance and adequacy of examples used by the faculty while teaching.</label>
  		    <ul class="answers">
  		       <input type="radio" id="q1a" value="Excellent" checked name="q19" <?php if($lastFeedback['q19']=='Excellent'){echo "checked";}?>><label for="q19a">Excellent</label>
          		       <input type="radio" id="q1b" value="Good" name="q19" <?php if($lastFeedback['q19']=='Good'){echo "checked";}?>><label for="q19b">Good</label>
          		       <input type="radio" id="q1c" value="Average" name="q19" <?php if($lastFeedback['q19']=='Average'){echo "checked";}?>><label for="q19c">Average</label>
          		       <input type="radio" id="q1d" value="Fair" name="q19" <?php if($lastFeedback['q19']=='Fair'){echo "checked";}?>><label for="q19d">Fair</label><br>
     		       </ul>
     		       <span class="error-span"><?php echo form_error('q19');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">20. Would you like to tell anyone to join our institute?</label>
  		    <ul class="answers">
  		       <input type="text" id="q1a" required value="<?php if($lastFeedback['q20']!=''){echo $lastFeedback['q20'];}else{echo set_value('q20');}?>" name="q20" style="color:#000;width:85%"><br>
     		      </ul>
     		      <span class="error-span"><?php echo form_error('q20');?></span>
  		  </div>
  		  <div class="form-group hideDiv">
  		    <label for="email" class="quesColor">Please use the following space to provide any other feedback about the course/ center etc.</label>
  		    <ul class="answers">
  		       <textarea id="q1a" name="q21" required style="color:#000;width:85%"><?php if($lastFeedback['q21']!=''){echo $lastFeedback['q21'];}else{echo set_value('q21');}?></textarea><br>
     		      </ul>
     		      <span class="error-span"><?php echo form_error('q21');?></span>
  		  </div>
		  <div class="form-group hideDiv" style="text-align:center">
		  	<input type="hidden" id="feedbackId" name="feedbackId" value="<?php if($lastFeedback['id']!=''){ echo $lastFeedback['id']; } ?>">
	  		<button type="submit" class="btn btn-success" id="submitBtn" <?php if($lastFeedback['status']=='invalid'){?> style="display:none;" <?php }?>> <?php if($lastFeedback['id']!=''){ echo 'Update'; }else{ echo 'Submit';} ?></button>
		  	<button type="reset" id="reset" class="btn btn-default">Cancel</button>
		</div>
		</form>
		<?php
		}else{
		?>
		<span>No active instance found.</span>
		<?php
		}
		?>
	</div>
	
</div>
<div class="clearfix"></div>
<?php $this->load->view('template/footer')?>
<script>
$(document).ready(function(){
	$("#selectedInstance").click(function(){
		var instanceId = $("#feedbackInstance").val();
		var url = $("#base_url").val();
		//$('#feedbackFrm input[type="radio"]').prop('checked',false);
		$('#feedbackFrm input[type="text"]').val('');
		$('#feedbackFrm input[type="hidden"]').val('');
		$('#feedbackFrm textarea').val('');
		$('.error-span').hide();
            if(instanceId > 0)
            {
              $.ajax({
                url: url+"profile/checkFeedbackExist",
                data: {instanceId:instanceId},
                type: "POST",
                success:function(data)
                {
                  //if((data != false) && (data !='dateInvalid')){
                  if((data != false)){
                    var obj = jQuery.parseJSON(data);
                    jQuery.each(obj, function (index, value) {
                           if (value['showbtn']==1) {
                            //console.log("Hi1");
                            $('#feedbackFrm input[type="radio"]').prop('checked',false);
                            $('#feedbackFrm input[type="text"]').val('');
                            $('#feedbackFrm input[type="hidden"]').val('');
                            $('#feedbackFrm textarea').val('');
                            $('#feedbackInstance').val(instanceId);
                        $('input[name^="q1"][value="'+value['q1']+'"]').prop("checked",true);
                        $('input[name^="q2"][value="'+value['q2']+'"]').prop("checked",true);
                        $('input[name^="q3"][value="'+value['q3']+'"]').prop("checked",true);
                        $('input[name^="q4"][value="'+value['q4']+'"]').prop("checked",true);
                        $('input[name^="q5"][value="'+value['q5']+'"]').prop("checked",true);
                        $('input[name^="q6"][value="'+value['q6']+'"]').prop("checked",true);
                        $('input[name^="q7"][value="'+value['q7']+'"]').prop("checked",true);
                        $('input[name^="q8"][value="'+value['q8']+'"]').prop("checked",true);
                        $('input[name^="q9"][value="'+value['q9']+'"]').prop("checked",true);
                        $('input[name^="q10"][value="'+value['q10']+'"]').prop("checked",true);
                        $('input[name^="q11"][value="'+value['q11']+'"]').prop("checked",true);
                        $('input[name^="q12"][value="'+value['q12']+'"]').prop("checked",true);
                        $('input[name^="q13"][value="'+value['q13']+'"]').prop("checked",true);
                        $('input[name^="q14"][value="'+value['q14']+'"]').prop("checked",true);
                        $('input[name^="q15"][value="'+value['q15']+'"]').prop("checked",true);
                        $('input[name^="q16"][value="'+value['q16']+'"]').prop("checked",true);
                        $('input[name^="q17"][value="'+value['q17']+'"]').prop("checked",true);
                        $('input[name^="q18"][value="'+value['q18']+'"]').prop("checked",true);
                        $('input[name^="q19"][value="'+value['q19']+'"]').prop("checked",true);
                        $('input[name^="q20"]').val(value['q20']);
                        $('textarea[name^="q21"]').val(value['q21']);
                        $("#feedbackId").val(value['id']);
                        $("#submitBtn").show();
                        $("#submitBtn").text('Update');
                        $("#feedbackFrm").show();
                      }else if( value['showbtn']==0){
                        //console.log("Hi2");
                        $('#feedbackFrm input[type="radio"]').prop('checked',false);
                        $('#feedbackFrm input[type="text"]').val('');
                        $('#feedbackFrm input[type="hidden"]').val('');
                        $('#feedbackFrm textarea').val('');
                        $('#feedbackInstance').val(instanceId);
                        $('input[name^="q1"][value="'+value['q1']+'"]').prop("checked",true);
                        $('input[name^="q2"][value="'+value['q2']+'"]').prop("checked",true);
                        $('input[name^="q3"][value="'+value['q3']+'"]').prop("checked",true);
                        $('input[name^="q4"][value="'+value['q4']+'"]').prop("checked",true);
                        $('input[name^="q5"][value="'+value['q5']+'"]').prop("checked",true);
                        $('input[name^="q6"][value="'+value['q6']+'"]').prop("checked",true);
                        $('input[name^="q7"][value="'+value['q7']+'"]').prop("checked",true);
                        $('input[name^="q8"][value="'+value['q8']+'"]').prop("checked",true);
                        $('input[name^="q9"][value="'+value['q9']+'"]').prop("checked",true);
                        $('input[name^="q10"][value="'+value['q10']+'"]').prop("checked",true);
                        $('input[name^="q11"][value="'+value['q11']+'"]').prop("checked",true);
                        $('input[name^="q12"][value="'+value['q12']+'"]').prop("checked",true);
                        $('input[name^="q13"][value="'+value['q13']+'"]').prop("checked",true);
                        $('input[name^="q14"][value="'+value['q14']+'"]').prop("checked",true);
                        $('input[name^="q15"][value="'+value['q15']+'"]').prop("checked",true);
                        $('input[name^="q16"][value="'+value['q16']+'"]').prop("checked",true);
                        $('input[name^="q17"][value="'+value['q17']+'"]').prop("checked",true);
                        $('input[name^="q18"][value="'+value['q18']+'"]').prop("checked",true);
                        $('input[name^="q19"][value="'+value['q19']+'"]').prop("checked",true);
                        $('input[name^="q20"]').val(value['q20']);
                        $('textarea[name^="q21"]').val(value['q21']);
                        $("#feedbackFrm").show();
                        $("#submitBtn").hide();
                      }else if(value['showbtn']==0 && value['showbtn']=='invalid'){
                        //console.log("Hi4");
                        $("#feedbackFrm").show();
                        $('#feedbackFrm input[type="radio"]').prop('checked',false);
                        $('#feedbackFrm input[type="text"]').val('');
                        $('#feedbackFrm input[type="hidden"]').val('');
                        $('#feedbackFrm textarea').val('');
                        $('#feedbackInstance').val(instanceId);
                        $("#submitBtn").hide();
                      }
                    });
                  }else{
                    //console.log($("#feedbackFrm")[0]);
                    $("#submitBtn").show();
                    $("#feedbackFrm").show();
                    //$('#feedbackFrm input[type="radio"]').prop('checked',false);
                    $('#feedbackFrm input[type="text"]').val('');
                    $('#feedbackFrm input[type="hidden"]').val('');
                    $('#feedbackFrm textarea').val('');
                    $('#feedbackInstance').val(instanceId);
                    $("#submitBtn").text('Submit');
                  }
                }
              });
              $('.hideDiv').css('display', 'block');
            }
            else
            {
              $('.hideDiv').css('display', 'none');
            }
	})
	$('#reset').click(function(event) {
		window.location='<?php echo base_url();?>profile/edit_profile';
	});
})
</script>