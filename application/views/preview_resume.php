<?php $this->load->view('template/header');?>
<style>
.navbar {
background-color:rgb(0,0,0);
}
.side-corner-tag .ribbon-color {
  background: rgba(0, 0, 0, 0) linear-gradient(#00b4ff 0%, #318df7 100%) repeat scroll 0 0;
}
.late-tag{
  background: #ff8400 none repeat scroll 0 0;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
     color: #fff;
     margin: -17px -16px 0;
     padding: 2px 10px;
     position: absolute;
}
</style>
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="col-lg-4 breadcrumb">
					<li>
						<a href="<?php echo base_url();?>">
						Home
						</a>
					</li>
					<li class="active">
						Preview Resume
					</li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12 left5 job-container">
			<div id="wrapper_div">
				<div class="col-lg-1"></div>
				<div class="col-lg-8">
					<div class="row">
						<div class="col-lg-2">
							<?php $profileImage = $user_profile->profileImage;
							if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)
							{
								$profileCompletion=20;
							?>
							
								<img id="OpenImgUpload_new" class="" alt="image" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>" height="100" width="100" />
							<?php }else{?>
								<img id="OpenImgUpload_new" alt="image" class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />
							<?php }?>
						</div>
						<div class="col-lg-6" style="padding-right: 10px;padding-left: 10px;">
							<div class="basic_info">
								<h3 style="margin-top: 0px;">
									<?php echo ucwords($user_profile->firstName.' '.$user_profile->lastName);?>
								</h3>						
								<ul>
									<?php if($user_profile->profession!=''){?>
										<li>
											<?php echo $user_profile->profession;?>
										</li>
									<?php }?>
								</ul>
														
								<div>
									<table>
										<?php 
										if($this->session->userdata('studentId') != '')
										{
											$ci= &get_instance();
											$ci->load->model('user_model');
											$courseData=$ci->user_model->getCourseData($user_profile->courseName);
											if(!empty($courseData)){
												$courseName = $courseData['course_name'];
												$courseType = $courseData['course_type'];
											}
										?>
										<tr style="height: 20px;">
											<td>Course</td>
											<td>&nbsp;:&nbsp;</td>
											<td><?php if($courseName != ''){
														echo $courseName." (".$courseType." Course)";
													  }else{
														echo $user_profile->courseName;
													  }?>
											</td>
										</tr>
										
										<?php 
										} ?>
										<tr style="height: 20px;">
											<td>Mobile No</td>
											<td>&nbsp;:&nbsp;</td>
											<td><?php echo $user_profile->contactNo ;?></td>
										</tr>
										<tr style="height: 20px;">
											<td>Email ID</td>
											<td>&nbsp;:&nbsp;</td>
											<td><?php echo $user_profile->email;?></td>
										</tr>
									</table>
									 
								</div>
								<br/>
								
							</div>
						</div>
						<div class="col-lg-4">
							<ul style="display:flex;list-style:none;float:right;">
								
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo base_url()?>profile/usre_profile_detail/<?php echo $user_profile->id;?>" target="_blank"><img alt="image" src="<?php echo base_url();?>assets/images/creosouls_newlogo.png" alt="Creosouls Profile"></a>
								</li>
								<?php if(isset($socialData['linkedin']) && !empty($socialData['linkedin'])){?>
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo $socialData['linkedin'];?>" target="_blank"><img alt="image" src="<?php echo base_url();?>assets/images/linkedin_32.png" alt="Linkedin Profile"></a>
								</li>
								<?php }?>
								<?php if(isset($socialData['pinterest']) && !empty($socialData['pinterest'])){?>
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo $socialData['pinterest'];?>" target="_blank"><img alt="image" src="<?php echo base_url();?>assets/images/pinterest_32.png" alt="Pinterest Profile"></a>
								</li>
								<?php }?>
								<?php if(isset($socialData['deviantart']) && !empty($socialData['deviantart'])){?>
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo $socialData['deviantart'];?>" target="_blank"><img alt="image" src="<?php echo base_url();?>assets/images/deviantart_32.png" alt="Deviantart Profile"></a>
								</li>
								<?php }?>
								<?php if(isset($socialData['behance']) && !empty($socialData['behance'])){?>
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo $socialData['behance'];?>" target="_blank"><img alt="image" src="<?php echo base_url();?>assets/images/behance_32.png" alt="Behance Profile"></a>
								</li>
								<?php }?>
								<li style="margin:0 10px 0 0;">
									<a href="<?php echo base_url()?>profile/donwload_resume"><button class="btn btn_blue" style="height: 32px;">
										Download PDF
									</button></a>
									
								</li>
								
							</ul>
						</div>
					
					</div>
					<br/>	
					
					<div id="user_skills" class="user_skills">
						<h4 class="experience" style="font-weight: bold;">
							About Me :
						</h4>
						<p style="text-align: justify;text-justify: inter-word;">
							<?php echo $user_profile->about_me;?>
						</p>
						<p style="text-align: justify;text-justify: inter-word;">
							<?php echo $user_profile->more_about_me;?>
						</p>
					</div>								
					<br>
					<?php
					if(isset($skillsData) && !empty($skillsData))
					{?>
					<div id="user_skills" class="user_skills">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
								Skills :
							</h4>
						</div>
						<ul>
						<?php
						if(isset($skillsData) && !empty($skillsData))
						{
							$skillArray = array();
							//$profileCompletion = $profileCompletion+10;
							foreach($skillsData as $row)
							{ 
								array_push($skillArray,$row['skillName']);

							}
							
							$comma_seprated_skills = implode(', ', $skillArray);

							echo $comma_seprated_skills;
						} ?>
						</ul>
					</div>
					<br>
					<?php } ?>
					<?php
					if(!empty($workData))
					{ ?>
					<div id="user_skills" class="user_skills">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Work Experience :
							</h4>
						</div>
						<?php
						    if(!empty($workData))
						    {
						        foreach($workData as $w_details)
						        { ?>
						            <div id="experience_details<?php echo $w_details['id'];?>">
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
						                <?php echo " : ".$w_details['position'];?>
						                <?php echo ' - '.$w_details['organisation'].', ';?>
						                <?php echo $w_details['w_address'];?>
						            	</p>
						                <p style="text-align: justify;text-justify: inter-word;"><?php echo $w_details['workDetails'];?></p>                    
						            </div>
						            <br>
						            <?php
						        } 
						    } 
						?>
					</div>
					<br>
					<?php } ?>
					<?php
					//print_r($workData);
					if(!empty($educationProfData))
					{?>					
					<div id="education" class="education">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Professional Qualification :
							</h4>
						</div>
						<?php
						    //print_r($workData);
						    if(!empty($educationProfData))
						    {
						        //$profileCompletion = $profileCompletion+10;
						        foreach($educationProfData as $e_details){
						    ?>
						    	<div id="educational_details<?php echo $e_details['id'];?>">
						            <p>
						                <?php
						                if(isset($e_details['passoutyear']))
						                {
						                	echo $e_details['passoutyear']." : ";
						                }?>
						                <?php
						                if(($e_details['education_type']==1))
						                {
						                	echo "10th,";
						                }elseif ($e_details['education_type']==2) {
						                	echo "12th,";
						                }elseif ($e_details['education_type']==3 || $e_details['education_type']==4|| $e_details['education_type']==5) 
						                {
						                	if($e_details['qualification']!=''){
						                		echo $e_details['qualification'].',';
						                	}
						                	
						                	if($e_details['stream']!=''){
						                		echo $e_details['stream'].',';
						                	}						            
						                }?>
						                <?php
						                if($e_details['school']!=''){
						                	echo $e_details['school'];
						                }
						                if($e_details['university']!=''){
						                	echo $e_details['university'];
						                }
						                
						                ?>
						            </p>
						        </div>
						    <?php }
							} ?>
					</div>
					<br>
					<?php }?>
					<?php 
					if(!empty($educationData))
					{ ?>
					<div id="education" class="education">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Academic Qualification :
							</h4>
						</div>
						<?php
						    //print_r($workData);
						    if(!empty($educationData))
						    {
						        //$profileCompletion = $profileCompletion+10;
						        foreach($educationData as $e_details){
						    ?>
						    <div id="educational_details<?php echo $e_details['id'];?>">
						        <p>
						            <?php
						            if(isset($e_details['passoutyear']))
						            {
						                echo $e_details['passoutyear']." : ";
						            }?>
						            <?php
						            if(($e_details['education_type']==1))
						            {
						                echo "10th, ";
						                if($e_details['school']!=''){
						                	echo $e_details['school'];
						                }
						                if($e_details['university']!=''){
						                	echo ', '.$e_details['university'];
						                }
						            }elseif ($e_details['education_type']==2) {
						                echo "12th, ";
						                if($e_details['school']!=''){
						                	echo $e_details['school'];
						                }
						                if($e_details['university']!=''){
						                	echo ', '.$e_details['university'];
						                }
						            }elseif ($e_details['education_type']==3 || $e_details['education_type']==4 || $e_details['education_type']==5) 
						            {
						                if($e_details['qualification']!=''){
						                	echo $e_details['qualification'];
						                }
						                if($e_details['stream']!=''){
						                	echo ', '.$e_details['stream'].', ';
						                }	
						                if($e_details['school']!=''){
						                	echo $e_details['school'];
						                }
						                if($e_details['university']!=''){
						                	echo ', '.$e_details['university'];
						                }				            
						            }?>
						            
						            <?php
						            
						            ?>
						        </p>
						    </div>
						    <?php }
							} ?>
					</div>
					<br>
					<?php }?>
					<?php 
					if(!empty($awardData))
					{?>
					<div id="award" class="award">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Awards / Achievements :
							</h4>
						</div>
						<?php
						    //print_r($awardData);
						    if(!empty($awardData))
						    {
						        //$profileCompletion = $profileCompletion+10;
						        foreach($awardData as $a_details){
						    ?>
						        <div id="award_details<?php echo $a_details['id'];?>">
						            <p>
						                <?php echo $a_details['dateRecieved']." : ";?>
						                <?php echo $a_details['prize'];?>
						                <?php echo '- '.$a_details['award'];?>
						            </p>
						        </div>
						                       
						    <?php }
							} ?>
					</div>
					<br>
					<?php } ?>
					<?php 
					if(!empty($workshopData))
					{ ?>
					<div id="workshop" class="workshop">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Workshops / Webinars :
							</h4>
						</div>
						<?php
						    //print_r($awardData);
						    if(!empty($workshopData))
						    {
						        //$profileCompletion = $profileCompletion+10;
						        foreach($workshopData as $w_details){
						    ?>
						        <div id="workshop_details<?php echo $w_details['id'];?>">
						            <p>
						                <?php echo $w_details['workshop_date']." : ";?>
						                <?php echo $w_details['workshop'];?>
						                <?php echo '- '.$w_details['workshop_by'];?>
						            </p>
						        </div>
						                        
						    <?php }} ?>
					</div>
					<br>
					<?php } ?>
					<?php 
					if(!empty($languageData))
					{ ?>
					<div id="language" class="language">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
							Languages Known :
							</h4>
						</div>
						<?php
						if(!empty($languageData))
						{?>
						    <table style="border: 1px solid black;width: 50%;text-align: center;">
						        <tr style="border: 1px solid black;">
						            <th style="border: 1px solid black;text-align: center;">Language</th>
						            <th style="border: 1px solid black;text-align: center;">Language Level</th>
						            <th style="border: 1px solid black;text-align: center;">Read</th>
						            <th style="border: 1px solid black;text-align: center;">Write</th>
						            <th style="border: 1px solid black;text-align: center;">Speak</th>
						        </tr>   
						                                
						<?php    //$profileCompletion = $profileCompletion+10;
						    foreach($languageData as $l_details){
						?>
						        <tr style="border: 1px solid black;">
						            <td style="border: 1px solid black;">
						            	<?php echo $l_details['language_name'];?>
						            </td>
						            <td style="border: 1px solid black;">
						            	<?php 
						            	if($l_details['language_proficiency']==1){
						                    echo "Basic Knowledge";
						                }elseif ($l_details['language_proficiency']==2) {
						                    echo "Conversant";
						                }elseif ($l_details['language_proficiency']==3) {
						                    echo "Proficient";
						                }elseif ($l_details['language_proficiency']==4) {
						                    echo "Fluent";
						                }?>
						            </td>
						            <td style="border: 1px solid black;">
						        		<?php 
						            	if($l_details['read']==1){ 
						                	echo "Y";
						            	}else{
						                	echo "N";
						            	}
										?>
						            </td>
						            <td style="border: 1px solid black;">
						                <?php 
									    if($l_details['write']==1){ 
						                    echo "Y";
						                }else{
						                    echo "N";
						                }
										?>
						            </td>
						            <td style="border: 1px solid black;">
						                <?php 
						                if($l_details['speak']==1){ 
						                    echo "Y";
						                }else{
						                    echo "N";
						                }
										?>
						            </td>
						        </tr>
						       <?php }?>
						    </table>   
						    <?php } ?>                      
					</div>
					
					<br>
					<?php } ?>
					<?php
					if(isset($locationData) && !empty($locationData))
					{ 
					?>
					<div id="location" class="location">
						<div class="experience">
							<h4 class="main" style="font-weight: bold;">
								Preferred Location :
							</h4>
					</div>
					<br>
					<?php
						//print_r($awardData);
						if(isset($locationData) && !empty($locationData))
						{
							$locationArray = array();
							$i = 1;

							foreach($locationData as $row)
							{ 
							    $cityName = "• ".$row['city'];
							    array_push($locationArray,$cityName);
							}
							$comma_seprated_location = implode("  ", $locationArray);
							echo $comma_seprated_location;

						} ?>					
					</div>
					<br>
					<?php } ?>
					<div id="personal" class="personal">
							<div class="experience">
								<h4 class="main" style="font-weight: bold;">
								Personal Information :
								</h4>
							</div>
							<table>
							    <tr style="height: 20px;">
							        <td width="21%">
							            Date Of Birth
							        </td>
							        <td width="2%">
							            :
							        </td>
							        <td width="76%">
							           <?php echo (isset($user_profile->dob) && $user_profile->dob!='0000-00-00')?date('d-m-Y',strtotime($user_profile->dob)):'NA' ;?> 
							        </td>
							    </tr>
							    <tr style="height: 20px;">
							        <td width="21%">
							            Marital Status
							        </td>
							        <td width="2%">
							            :
							        </td>
							        <td width="76%">
							           <?php 
							                if($user_profile->marital_status=='S'){
							                    echo "Single";
							                }
							                if($user_profile->marital_status=='M'){
							                    echo "Single";
							                }
							            ?> 
							        </td>
							    </tr>
							    <tr style="height: 20px;">
							        <td width="21%">
							            Current Address
							        </td>
							        <td width="2%">
							            :
							        </td>
							        <td width="76%">
							            <?php if($user_profile->address!=''){ echo ucfirst($user_profile->address); }?>
							            
							        </td>
							    </tr>
							</table>			
						</div>
						<br>
					</div>
				</div>
				<div class="col-lg-1"></div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
