<?php $this->load->view('template/header');?>
<link href="<?php echo base_url();?>assets/css/style_crowj.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/testimonial.css"/>
<style>
	.pie_progress
	{
		margin-top: 0px !important;
	}
	.navbar {
    background-color:rgb(0,0,0);
	}
	.media .media-left {
	    padding-right: 10px;
	}
	.side-link li {
		display: block !important;
	}
</style>
<style>
	 .box{
	 	overflow: visible;
	 	opacity: 1;
	 }
	 .like .dropdown-menu{
	padding: 0;
	margin-left: -50px;
	 }
	 .like .dropdown-menu li{
	 	border-bottom: 1px solid #ccc;
	 	    color: #252525;
	 	    cursor: pointer;
	 	    padding: 5px 5px 5px 10px;
	 }
	 .like .dropdown-menu li:hover{
	 	background: #f4f4f4;
	 }
	 .like > .dropdown-menu{
	 	max-height: 170px !important;
	 	overflow-y: scroll;
	 }

	 .left.carousel-control {
	     left: -19px !important;
	     position: absolute !important;
	     top: 27px !important;
	 }

	 .right.carousel-control {
	     position: absolute;
	     right: -53px !important;
	     top: 27px !important;
	 }


</style>
<!-- Page Content -->
<?php
$CI =& get_instance();
$CI->load->model('appreciatework_model');
if($user_profile->id != $this->session->userdata('front_user_id'))
{
	$userid = $user_profile->id;
}
else
{
	$userid = $this->session->userdata('front_user_id');
}
$appriciationExists = $CI->appreciatework_model->getAllAppriciationExists($userid);
$appriciation = $CI->appreciatework_model->getAllAppriciation($userid);
?>
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>">
							Home
						</a>
					</li>
					<li class="active">
						<?php
						if(isset($user_profile->firstName) && $user_profile->firstName != ''){
							echo ucwords($user_profile->firstName);
						}?> <?php
						if(isset($user_profile->lastName) && $user_profile->lastName != ''){
							echo ucwords($user_profile->lastName);
						}?>’s Portfolio
					</li>
				</ol>
			</div>
			<div class="col-lg-3 portfolio-left">
				<div class="portfolio_lhs" style="padding:0">
					<div class="media user-prof">
						<div class="media-left">
							<a href="javascript:void(0)">
								<?php
								if($this->uri->segment(2) == 'userDetail'){
									$profileMeter = $this->session->userdata('other_profile_meter');
								}
								else
								{
									$profileMeter = $this->session->userdata('profile_meter');
								}
								?>
								<div class="pie_progress profile" role="progressbar" data-goal="<?php echo $profileMeter;?>" data-speed="20" data-barcolor="#34A853" data-barsize="14" aria-valuemin="0" aria-valuemax="100" data-trackcolor="#FF9A2D">
									<div class="pie_progress__content">
										<?php
										if(isset($user_profile->profileImage) && file_exists(file_upload_s3_path().'users/thumbs/'.$user_profile->profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$user_profile->profileImage) > 0){
											?>
											<img class="media-object img-circle" style="height: 66px; margin-left: 6px;" src="<?php echo file_upload_base_url();?>users/thumbs/<?php
											if(isset($user_profile->profileImage) && $user_profile->profileImage != ''){
												echo $user_profile->profileImage;
											}?>" alt="image">
											<?php
										}
										else
										{ ?>
											<img class="media-object img-circle" style="margin-left: 13px;" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image" >
											<?php
										} ?>
									</div>
								</div>
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading">
								<?php
								if(isset($user_profile->firstName) && $user_profile->firstName != ''){
									echo ucwords($user_profile->firstName);
								}?> <?php
								if(isset($user_profile->lastName) && $user_profile->lastName != ''){
									echo ucwords($user_profile->lastName);
								}?>
								<?php
								if(isset($user_profile->id) && $user_profile->id == $this->session->userdata('front_user_id'))
								{
									?>
									<a title="Edit Profile" class="pull-right" style="margin-right: 15%;" href="<?php echo base_url()?>profile/edit_profile">
										<i class="fa fa-pencil">
										</i>
									</a>
									<?php
								} 
								else
									{
								?>
									<a title="View Profile" class="pull-right" style="margin-right: 15%;" href="<?php echo base_url()?>profile/usre_profile_detail/<?php echo $user_profile->id;?>">
										<i class="fa fa-eye">
										</i>
									</a>

								<?php }   ?>
							</h4>
							<ul>
								<?php
								if(isset($user_profile->profession) && $user_profile->profession != ''){
									?>
									<li>
										<?php echo ucwords($user_profile->profession);?>
									</li>
									<?php
								}?>
								<li>
									<?php
									if(isset($user_profile->city) && $user_profile->city != ''){
										echo ucwords($user_profile->city);
									}?><?php
									if(isset($user_profile->country) && $user_profile->country != ''){
										echo ', '.ucwords($user_profile->country);
									}?>
								</li>
							</ul><br />
							<?php if($user_profile->instituteName !=''){?>
							Institute : <a href="<?php echo base_url();?><?php echo $user_profile->pageName;?>"><?php echo ucwords($user_profile->instituteName);?></a>
							<?php }?>
							<ul class="side-link">
								
								<?php
								if($user_profile->id == $this->session->userdata('front_user_id')){
									$CI     =& get_instance();
									$CI->load->model('model_basic');
									$juryId = $this->model_basic->getValue('competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");
									$creativeJuryId = $this->model_basic->getValue('creative_competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");

									if($juryId != ''){
										?>
										<li>
										<a class="follow-btn" href="<?php echo base_url();?>profile/juryCompitations">
											Jury Competition's
										</a>
										</li>
										<?php
									}

									if($creativeJuryId != ''){
										?>
										<li>
										<a class="follow-btn" href="<?php echo base_url();?>profile/creativejuryCompitations">
											Jury Creative Competition's
										</a>
										</li>
										<?php
									}
								}?>						
							
								
									<?php
									//print_r($user_profile->id);die;
									if($this->session->userdata('teachers_status')==1 && ($user_profile->id == $this->session->userdata('front_user_id'))){	
										?>

										<?php
										if($user_profile->id == $this->session->userdata('front_user_id')){
											$CI     =& get_instance();
											$CI->load->model('model_basic');

											$teacher_id = $this->model_basic->getValue('assignment','teacher_id'," `teacher_id` = '".$this->session->userdata('front_user_id')."'");
											if($teacher_id != ''){
												?>
												<li>
												<a class="follow-btn" href="<?php echo base_url();?>assignment/submited_assignment">
													Submitted Assignments
												</a>
												</li>
												<?php
											}
										}
										?>	
										
										<?php /*<li>
																			<a class="follow-btn" href="<?php echo base_url();?>assignment/manage_assignment/<?php echo $user_profile->id ?>">
																				Manage Assignment
																			</a>
																			</li>
																			<li>
																			<a class="follow-btn" href="<?php echo base_url();?>assignment/add_assignment">
																				Add Assignment
																			</a>
																			</li>*/  ?>
										<?php									
									} ?>
								

									<?php
									if($user_profile->id != $this->session->userdata('front_user_id')){
										$CI->load->model('people_model');
										$followingUser = $CI->people_model->checkFollowingOrNot($user_profile->id);
										if(!empty($followingUser)){
											?>
											<li>
											<form action="<?php echo base_url()?>user/unfollow_user/<?php if(!empty($user_profile->id)){echo $user_profile->id;}?>/1" method="POST">
												<button type="submit" name="submit" class="follow-btn">
													<i class="fa fa-check">
													</i>&nbsp;Following
												</button>
											</form>
											</li>
											<?php
										}
										else
										{
											?>
											<li>
											<form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($user_profile->id))
				{echo $user_profile->id;}?>/1" method="POST">
												<button type="submit" name="submit" value="" class="follow-btn"/>Follow
											</form>
											</li>
											<?php
										}
									}
									else
									{
										if(!empty($appriciationExists)){
											?>
											<li>
											<a class="follow-btn" href="<?php echo base_url();?>appreciatework/manage_appreciatework">
												Manage Appreciated Work
											</a>
											</li>
											<?php
										}
									}?>
									
								
							</ul>
						</div><br />
						<div class="col-lg-12">						
						<div class="dropdown col-md-4">
							<button class="btn btn_bluebtn btn_blue" type="button" data-toggle="modal" data-target="#sendMail">
								<i class="fa fa-share">
								</i>&nbsp;SHARE
							</button>
						</div>
						<div class="dropdown col-md-4">
							<a href="<?php echo base_url();?>timeline/display_timeline<?php if($this->uri->segment(3) !=''){echo '/'.$this->uri->segment(3); }  ?>"><button class="btn btn_bluebtn btn_blue" type="button" >
								
								View Timeline
							</button>
							</a>
						</div>
					</div>
					</div>
					<div class="project-viewer row">
								<div class="col-md-4 project_view">
									<i class="fa fa-eye">
									</i>&nbsp;
									<span>
										<?php
										if(!empty($view_like_cnt) && $view_like_cnt[0]['views'] != ''){
											echo $view_like_cnt[0]['views'];
										}
										else
										{
											echo 0;
										}?>
									</span>
								</div>
								<div class="appreciations col-md-4">
									<i class="fa fa-thumbs-o-up">
									</i> &nbsp;
									<span>
										<?php
										if(!empty($view_like_cnt) && $view_like_cnt[0]['likes'] != ''){
											echo $view_like_cnt[0]['likes'];
										}
										else
										{
											echo 0;
										}?>
									</span>
								</div>
							<div class="following col-md-4 dropdown">
									<!--<i class="fa fa-eye">
									</i>--><i class="fa fa-user"></i>&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;
									<span>
										<?php
										if(!empty($following)){
											echo $following[0]['following'];
										}
										else
										{
											echo 0;
										}?>
									</span>
									<ul class="dropdown-menu">
										<?php if(!empty($followinglist)){ foreach($followinglist as $fLname){?>
										  <li><?php echo $fLname['firstName'].' '.$fLname['lastName']; ?></li>		
							       
										  <?php }   }  ?>
									</ul>
								</div>
								<div class="follower col-md-4 dropdown">
									<!--<i class="fa fa-eye">
									</i>--><i class="fa fa-user"></i>&nbsp;<i class="fa fa-arrow-left"></i>&nbsp;
									<span>
										<?php
										if(!empty($followers)){
											echo $followers[0]['followers'];
										}
										else
										{
											echo 0;
										}?>
									</span>
									<ul class="dropdown-menu">
										<?php if(!empty($followerslist)){ foreach($followerslist as $foLname){?>
										  <li><?php echo $foLname['firstName'].' '.$foLname['lastName']; ?></li>		
							       
										  <?php }   }  ?>
									</ul>
								</div>
								<div class="rating col-md-6">
									<?php
									$CI            =& get_instance();
									$CI->load->model('user_model');
									$overAllRating = $CI->user_model->overAllProjectRating($user_profile->id);
								/*	print_r($overAllRating);die;*/
									if(!empty($overAllRating))
									{
										$rate = $overAllRating[0]['avg'];
									}
									else
									{
										$rate = 0;
									}
									?>
									<i class="fa fa-star"></i>&nbsp;Rating
									<span>
										<input id="overAllRating" value="<?php echo $rate?>" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs">
									</span>
								</div>
							</div>
					
                <div class="about-user">
					<h4 class="title">

					<?php if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'userDetail' && $this->uri->segment('3') != $this->session->userdata('front_user_id')){ 
						?>

						About <?php
						if(isset($user_profile->firstName) && $user_profile->firstName != ''){
							echo ucwords($user_profile->firstName);
						}?> <?php
						if(isset($user_profile->lastName) && $user_profile->lastName != ''){
							echo ucwords($user_profile->lastName);
						}?>’s :
						<?php } else {
							?>
							About Me :
							<?php
						}  ?>
						
					</h4>
					<p>
						<?php
						if(isset($user_profile->about_me) && $user_profile->about_me != ''){
							echo ucwords($user_profile->about_me);
						}
						else
						{
							if($user_profile->id == $this->session->userdata('front_user_id')){
								echo 'Complete your profile.';
							}
							else
							{
								echo 'Personal Details Not Updated.';
							}
						}?>
					</p>
				</div>	
                <div class="about-company">
					<h4 class="title">
						Current Company :
					</h4>
					<p>
						<?php
						if(isset($workData) && !empty($workData)){
							echo ucwords($workData[0]['organisation']);
							if($workData[0]['w_address'] != ''){
								echo ' ,'.ucwords($workData[0]['w_address']);
							}
						}
						else
						{
							if($user_profile->id == $this->session->userdata('front_user_id')){
								echo 'Complete your profile.';
							}
							else
							{
								echo 'Company Details Not Updated.';
							}
						}
						?>
					</p>
				</div>
					
                <div class="about-edu">
					<h4 class="title">
						Highest Education :
					</h4>
					<p>
						<?php
						if(isset($educationData) && !empty($educationData)){
							echo ucwords($educationData[0]['qualification']);
							if($educationData[0]['university'] != ''){
								echo ' ,'.ucwords($educationData[0]['university']);
							}
						}
						else
						{
							if($user_profile->id == $this->session->userdata('front_user_id')){
								echo 'Complete your profile.';
							}
							else
							{
								echo 'Education Info Not Updated.';
							}
						}?>
					</p>
				</div>
               	<?php if(isset($testimonials) && !empty($testimonials))
   				{ 

   					 ?>
                <div class="about-testo">
   					<h4 class="title">
   						<?php if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'userDetail' && $this->uri->segment('3') != $this->session->userdata('front_user_id')){ 
   							?>

   							 <?php
   							if(isset($user_profile->firstName) && $user_profile->firstName != ''){
   								echo ucwords($user_profile->firstName);
   							}?> <?php
   							if(isset($user_profile->lastName) && $user_profile->lastName != ''){
   								echo ucwords($user_profile->lastName);
   							}?>’s Testimonial :
   							<?php } else {
   								?>
   								My Testimonial :
   								<?php
   							}  ?>
   					</h4>
   					<div class="cd-testimonials-wrapper row">
                               
   						<div class="col-md-12" data-wow-delay="0.2s">
   							<div class="carousel slide" data-ride="carousel" id="quote-carousel">
   							
   								<div class="carousel-inner">
   								<?php
   								foreach($testimonials as $key => $singleTestimonial)
   								{
   								 ?>
   									<div class="item <?php if($key == 0){ echo 'active';}?>">
   										<?php  echo $singleTestimonial['comment'];?><br/>- By <?php  echo $singleTestimonial['firstName'];?> <?php  echo $singleTestimonial['lastName'];?>
   									</div>

   									<?php  }  ?>									
   								</div>
   								<!-- Carousel Buttons Next/Prev -->
   								<a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
   								<a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
   							</div>
   						</div>
   					</div>
   				</div>

   				<?php } ?>
				
				<div class="about-award">	
					<h4 class="title">
						Awards :
					</h4>
					<p>
						<?php
						if(!empty($awards))
						{
							foreach($awards as $row){
								echo $row['award'].' , '.$row['prize'];
							}
						}
						else
						{
							if($user_profile->id == $this->session->userdata('front_user_id')){
								echo 'Complete your profile.';
							}
							else
							{
								echo 'No Awards.';
							}
						}?>
					</p>
                </div>
				</div>
				<?php
				$CI   =& get_instance();
				$CI->load->model('project_model');
				$data = $CI->project_model->getUserWinningProjects($user_profile->id);
				//pr($data);
				if(!empty($data)){
					?>
					<div class="project_slider">
						<h4 class="title">
							Award winning Projects
							<!--  <span class="view_all"><a href="#">View</a></span> -->
						</h4>
						<div class="Slider">
							<div id="owl-slider1" class="owl-carousel">
								<?php
								foreach($data as $value)
								{
									?>
									<div class="slide-item">
										<div class="thumbnail">
											<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal('<?php echo $value['projectPageName']?>');"><img src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $value['image_thumb']?>" alt="image"></a>
											<div class="content animated fadeInUp">
												<div class="top">
													<div class="col-lg-12">
														<p style="padding: 5px; text-align: center;">
															<b>
																<a href="<?php echo base_url()?>project/projectDetail/<?php echo $value['id']?>/<?php echo $value['userId']?>" class="be-post-title">
																	<?php
																	if(strlen($value['projectName']) > 40){
																		$dot = '..';
																	}
																	else
																	{
																		$dot = '';
																	}
																	$position = 40; // Define how many character you want to display.
																	echo $post2 = substr( $value['projectName'], 0, $position).$dot;?>
																</a>
															</b><!-- <i class="fa fa-camera"></i> -->
														</p>
														<!-- <p>Photography, Graphic Design</p> -->
													</div>
													<div class="col-lg-3 col-xs-3" style="margin-top:-15px;">
														<img class="img-circle" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $value['profileImage']?>" alt="image">
													</div>
													<div class="col-lg-9 col-xs-9 padding_none">
														<span>
															<?php echo $value['firstName']?>&nbsp;<?php echo $value['lastName']?>
														</span>
														<?php if($value['city'] !='' || $value['country'] !='')
														{ ?>
														<ul>
															<!-- <li>Freelance Designer</li> -->
															<li>
																<?php echo $value['city']?>,<?php echo $value['country']?>  &nbsp;
																<i class="fa fa-map-marker">
																</i>
															</li>
														</ul>
														<?php } ?>
													</div>
												</div>
												<!-- <div class="footer">
													<div class="col-lg-3 col-xs-3">
														<div class="view">
															<i class="fa fa-eye">
															</i>&nbsp;
															<span>
																<?php echo $value['view_cnt']; ?>
															</span>
														</div>
													</div>
													<div class="col-lg-3 col-xs-3">
														<div style="cursor:pointer" class="like like_span" data-name="0" data-id="<?php if(!empty($value['id'])){ echo $value['id'];}else{ echo 0;}?>" data-like="<?php echo $value['like_cnt']; ?>">
															<i class="fa fa-thumbs-o-up">
															</i>&nbsp;
															<span>
																<?php echo $value['like_cnt']; ?>
															</span>
														</div>
													</div>
													<div class="col-lg-3 col-xs-3">
														<div class="comment">
															<img src="<?php echo base_url();?>assets/images/comment.png" alt="">&nbsp;
															<span>
																<?php echo $value['comment_cnt'];?>
															</span>
														</div>
													</div>
													<div class="col-lg-3 col-xs-3">
														<?php
														$CI->load->model('model_basic');
														$imageCount = $CI->model_basic->getCount('user_project_image','project_id',$value['id']);?>
														<div class="photo">
															<img src="<?php echo base_url();?>assets/images/photo.png" alt="">&nbsp;
															<span>
																<?php echo $imageCount;?>
															</span>
														</div>
													</div>
													<div class="col-lg-12">
														<span class="publishedon">
															Published on <?php echo date("F j, Y",strtotime($value['created']));?>
														</span>
													</div>
												</div> -->
											</div>
										</div>
									</div>
									<?php
								} ?>
							</div>
						</div>
					</div>
					<?php
				} ?>
			</div>
			<div class="col-lg-9 right_side right-bg">
				<div class="tranding_projects">
					<div class="row">
						<div class="col-lg-12">							
						</div>
						<div class="col-lg-12">
							<ul id="alltabs" class="category" style="font-size: 11px;">								
								<?php 
								if(isset($showreel) && !empty($showreel) && $showreel!='0')
								{ ?>
									<li>
										<a class="active" href="javascript:void(0)" data-name="Showreel">
											Showreel
										</a>
									</li>
								<?php } ?>
								<li>
									<a class="<?php echo (isset($showreel) && $showreel==0)?'active':'' ?>" href="javascript:void(0)" data-name="Completed">
										Completed
									</a>
								</li>
								<?php
								if($user_profile->id == $this->session->userdata('front_user_id')){
									?>
									<li>
										<a href="javascript:void(0)" data-name="Saved as Draft">
											Saved as Draft
										</a>
									</li>
									<?php
								}?>
								<li>
									<a href="javascript:void(0)" data-name="Work in Progress">
										Work in Progress
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-name="Appreciated">
										Appreciated
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-name="Liked On">
										Liked On
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-name="Discussed On">
										Discussed On
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" data-name="Competition">
										Submitted For Competition
									</a>
								</li>
								<?php
								if($user_profile->id == $this->session->userdata('front_user_id')){ ?>
								<li>
									<a href="javascript:void(0)" data-name="Assignment">
										Submitted For Assignment
									</a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<div class="clearfix">
						</div>
						<div id="wrapper_div">
							<?php
							if(!empty($complete_project))
							{
								$data = array();
								$data['project'] = $complete_project;
								$data['thumbnailNum'] = 3;
								$data['editProject'] = '';
								$data['mainClass'] = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
								$this->load->view('template/projectThumbnailView',$data);
							}
							else
							{
								?>
								<div class="col-lg-12">
									<div class="no_content_found">
										<h3>
											No Projects Found.
										</h3>
									</div>
								</div>
								<?php
							} ?>
						</div>
					</div>
					<div class="col-lg-12">
					<center><div id="load_img_div" style="left:0%;" >
					</div></center>
					</div>
					<!--<div id="msg_div">
					</div>-->
					<input type="hidden" id="showreel_count" value="2"/>
					<input type="hidden" id="complete_count" value="2"/>
					<input type="hidden" id="draft_count" value="2"/>
					<input type="hidden" id="progress_count" value="2"/>
					<input type="hidden" id="appreciated_count" value="2"/>
					<input type="hidden" id="likedOn_count" value="2"/>
					<input type="hidden" id="discussedOn_count" value="2"/>
					<input type="hidden" id="competition_count" value="2"/>
					<input type="hidden" id="assignment_count" value="2"/>
					<input type="hidden" id="all_count" value="2"/>
					<input type="hidden" id="usrid" value="<?php echo $this->session->userdata('front_user_id');?>"/>
					<?php
					if($this->uri->segment(3) != '')
					{
						?>
						<input type="hidden" id="other_user" value="<?php echo $this->uri->segment(3); ?>"/>
						<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="sendMail" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<form method="post" action="<?php echo base_url()?>profile/shareUserProfile">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">
						Share A Portfolio
					</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="sharedUserId" value="<?php echo $userid;?>"/>
					<input type="email" required class="form-control" name="userEmail" placeholder="Enter email-id"/>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn_blue" name="sendEmail">
						Send Email
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<!--testimonial -->
<!--<script src=<?php echo base_url();?>assets/js/jquery-2.1.1.js"></script>-->
<script src="<?php echo base_url();?>assets/js/masonry.pkgd.min.js">
</script>
<script src="<?php echo base_url();?>assets/js/jquery.flexslider-min.js">
</script>
<script src="<?php echo base_url();?>assets/js/main.js">
</script>
<script src="<?php echo base_url();?>assets/js/owl.carousel.js">
</script>
<script>
	$(document).ready(function()
		{
			var owl1 = $("#owl-slider1");
			owl1.owlCarousel(
				{
					autoPlay: 5000,
					items : 1, //10 items above 1000px browser width
					itemsCustom : false,
					itemsDesktop : [1199,3],
					itemsDesktopSmall : [980,3],
					itemsTablet: [768,3],
					itemsTabletSmall: false,
					itemsMobile : [479,1],
					singleItem : false,
					itemsScaleUp : false,
					pagination : false,
					navigation : true
				});
		});
</script>
<script>
	function UrlExists(url)
	{
		$.ajax({
			url: base_url+'project/file_exists',
			type: 'POST',
			data: {'file': url},
		})
		.done(function(data) {
			return data;
		})
	}
	/*$(window).bind("pageshow", function()
		{
			$('#showreel_count').val(2);
			$('#complete_count').val(2);
			$('#draft_count').val(2);
			$('#progress_count').val(2);
			$('#appreciated_count').val(2);
			$('#likedOn_count').val(2);
			$('#discussedOn_count').val(2);
			$('#competition_count').val(2);
			$('#assignment_count').val(2);
			$('#all_count').val(2);
		});*/
	$(document).ready(function()
	{
	var url=$('#base_url').val();
	var cat_id = 0;
	var scrollFunction = function()
	{
	var active_tab = $("#alltabs li > a.active").data('name');
	//alert(active_tab);
	if(active_tab=='Showreel')
	{
		var call_count= $("#showreel_count").val();		
	}
	if(active_tab=='Completed')
	{
		var call_count= $("#complete_count").val();
	}
	if(active_tab=='Saved as Draft')
	{
		var call_count= $("#draft_count").val();
	}
	if(active_tab=='Work in Progress')
	{
		var call_count= $("#progress_count").val();
	}
	if(active_tab=='Appreciated')
	{
		var call_count= $("#appreciated_count").val();
	}
	if(active_tab=='Liked On')
	{
		var call_count= $("#likedOn_count").val();
	}
	if(active_tab=='Discussed On')
	{
		var call_count= $("#discussedOn_count").val();
	}
	if(active_tab=='Competition')
	{
		var call_count= $("#competition_count").val();
	}
	if(active_tab=='Assignment')
	{
		var call_count= $("#assignment_count").val();
	}
	var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
	if ($(window).scrollTop() >= mostOfTheWayDown)
	{
		$("#load_img_div").append('<center id="load"><img src="'+url+'assets/img/load.gif"/></center>');
		$(window).unbind("scroll");
		if($("#no_rec").length==0)
		{
			a = parseInt(call_count);
			var wrapper_div =  'wrapper_div';
			if(active_tab=='Showreel')
			{
				$('#showreel_count').val(a+1);

			}
			if(active_tab=='Completed')
			{
				$("#complete_count").val(a+1);
			}
			if(active_tab=='Saved as Draft')
			{
				$("#draft_count").val(a+1);
			}
			if(active_tab=='Work in Progress')
			{
				$("#progress_count").val(a+1);
			}
			if(active_tab=='Appreciated')
			{
				$("#appreciated_count").val(a+1);
			}
			if(active_tab=='Liked On')
			{
				$("#likedOn_count").val(a+1);
			}
			if(active_tab=='Discussed On')
			{
				$("#discussedOn_count").val(a+1);
			}
			if(active_tab=='Competition')
			{
				$("#competition_count").val(a+1);
			}
			if(active_tab=='Assignment')
			{
				$("#assignment_count").val(a+1);
			}
			$.blockUI();
			<?php
			if($this->uri->segment(3)=='')
			{
				?>
				$.ajax(
					{
						url: url+"profile/more_data",
						data:
						{
							call_count:call_count,active_tab:active_tab
						},
						type: "POST",
						success:function(html)
						<?php
					} else
					{
						?>
						var other_user = $("#other_user").val();
						$.ajax(
						{
							url: url+"profile/more_data",
							data:
							{
								call_count:call_count,active_tab:active_tab,other_user:other_user
							},
							type: "POST",
							success:function(html)
							<?php
						}?>
						{
							if(html != '')
							{
								var i=1;
								var div_class;
								$("#load").remove();
								var obj = $.parseJSON(html);
								$.each(obj, function(index, element)
									{
										if(i == 1)
										{
											div_class = 'right5';
											i++;
										}
										else
										if(i == 2)
										{
											div_class = 'rightleft5';
											i++;
										}
										else
										{
											div_class = 'left5';
											i     = 1;
										}
										if(typeof element.profession != 'undefined')
										{
											var profession = element.profession;
											var lnt = profession.length;
											a = parseInt(lnt);
											if(a > 16)
											{
												var dot ='..';
											}else
											{
												var dot ='';
											}
											var length = 16;
											var trimmedprofession = profession.substring(0, length)+dot;
										}
										else
										{
											var trimmedprofession='';
										}
										var n = element.projectName.length;
										a = parseInt(n);
										if(a > 40)
										{
											var dot ='..';
										}
										else
										{
											var dot ='';
										}
										var length = 40;
										var trimmedName = element.projectName.substring(0, length)+dot;
										var edit_link;
										
										if($('#usrid').val()==element.userId)
										{
											var clickLink = "window.location='<?php echo base_url();?>project/edit_project/"+element.id+"'";
											if(element.competitionId == '0' && element.assignmentId == '0')
											{
												
												var edit_link ='<div class="col-lg-4 col-xs-4"><div class="photo"><span style="cursor:pointer;" onclick='+clickLink+'><i class="fa fa-pencil-square-o"></i>&nbsp;</span></div></div>';
											}											
											else
											{
												var edit_link ='';
											}
											var img_cnt='';
										}else
										{
											var edit_link ='';
											var img_cnt= '<div class="col-lg-4 col-xs-4"><div class="photo"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div>';
										}
										var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
										/*if(!UrlExists("users/thumbs/"+element.profileImage))
										{
											var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
										}*/
										var loca;
										if(element.city!='')
										{
											loca = element.city;
										}else
										{
											loca = 'Location';
										}
										/*var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';*/
										/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
										var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
										if(element.userLiked==0)
										{
										userLiked = '<div class="like dropdown"><div class="like_div" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id" ></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>'+element.droupdown+'</div>';
										}
										else
										{	
											userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
										}
										var date = element.created;


										if(active_tab=='Assignment')
										{
											rebinClass = 'side-corner-tag';
											if(element.assignment_status == 0)
											{
												rebin = '<p class="ribbon"><span>ASSIGN</span></p>';
											}
											if(element.assignment_status == 1)
											{												
												rebin = '<p class="ribbon"><span>SUBMITTED</span></p>';
											}
											if(element.assignment_status == 2)
											{
												rebin = '<p class="ribbon"><span>PENDING</span></p>';
											}
											if(element.assignment_status == 3)
											{
												rebin = '<p class="ribbon"><span>ACCEPTED</span></p>';
											}
											if(element.assignment_status == 4)
											{
												rebin = '<p class="ribbon"><span>RE - SUBMITTED</span></p>';
											}
										}
										else
										{
											rebin = '';
											rebinClass = '';
										}
										var videoLink = element.videoLink;
										if(videoLink != ''){
											var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
										}else{
											var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image"></a>'
										}


										$('#wrapper_div').append('<div class="col-lg-3 col-md-3 col-sm-6 '+div_class+'"><div class="box '+rebinClass+'">'+rebin+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px" ><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+element.firstName+'&nbsp;'+element.lastName+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div>'+edit_link+img_cnt+'</div></div></div></div></div>');
									});

								$('div.dropdown').hover(function() {
								  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
								}, function() {
								  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
								});
							}
							else
							{
								<?php if($this->uri->segment(1) == 'profile'){ ?>
									if(active_tab !='Competition' && active_tab !='Assignment')
									{									
									var addProjButton = '<button class="btn btn_bluebtn btn_blue" onclick="noProjectAdd();" style="border-radius: 9px ! important; margin-top: 29px ! important;">Add Project</button>';
									}
									else if(active_tab =='Assignment')
									{									
									var addProjButton = '<a class="btn btn_bluebtn btn_blue" style="border-radius: 9px ! important; margin-top: 29px ! important;" href="'+base_url+'assignment" >View Assignment</a>';
									}
									else
									{
										var addProjButton = '';
									}
								<?php }
								else if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'userDetail' && $this->uri->segment('3') == $this->session->userdata('front_user_id')){  ?>							

									if(active_tab !='Competition' && active_tab !='Assignment')
									{									
									var addProjButton = '<button class="btn btn_bluebtn btn_blue" onclick="noProjectAdd();" style="border-radius: 9px ! important; margin-top: 29px ! important;">Add Project</button>';
									}
									else if(active_tab =='Assignment')
									{									
									var addProjButton = '<a class="btn btn_bluebtn btn_blue" style="border-radius: 9px ! important; margin-top: 29px ! important;" href="'+base_url+'assignment" >View Assignment</a>';
									}
									else
									{
										var addProjButton = '';
									}
									<?php 

								} else{  ?> var addProjButton =''; <?php } ?>
								$("#load_img_div").css('width', '400px').html('<center><div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">Oh, you have no more projects. Unleash your creativity NOW!</h3></div>'+addProjButton+'</center>');
							}
							$(window).scroll(scrollFunction);
						}
					});
			}
			else
			{
				$('#load').remove();
				$(window).scroll(scrollFunction);
			}
			$.unblockUI();
		}
	};
	$(window).scroll(scrollFunction);
	$('#alltabs').on('click', 'li', function()
		{
			$('#load_img_div').css('width','200px').html('');
			$('#alltabs li a.active').removeClass('active');
			$(this).find('a').addClass('active');
			$.blockUI();
			$("#wrapper_div").html('');
			$("#msg_div").html('');
			$("#call_count").val('1');
			var call_count= 1;
			a = parseInt(call_count);
			var active_tab = $("#alltabs li > a.active").data('name');
			if(active_tab=='Showreel')
			{
				$("#showreel_count").val(a+1);
			}
			if(active_tab=='Completed')
			{
				$("#complete_count").val(a+1);
			}
			if(active_tab=='Saved as Draft')
			{
				$("#draft_count").val(a+1);
			}
			if(active_tab=='Work in Progress')
			{
				$("#progress_count").val(a+1);
			}
			if(active_tab=='Appreciated')
			{
				$("#appreciated_count").val(a+1);
			}
			if(active_tab=='Liked On')
			{
				$("#likedOn_count").val(a+1);
			}
			if(active_tab=='Discussed On')
			{
				$("#discussedOn_count").val(a+1);
			}
			if(active_tab=='Competition')
			{
				$("#competition_count").val(a+1);
			}
			if(active_tab=='Assignment')
			{
				$("#assignment_count").val(a+1);
			}
			<?php
			if($this->uri->segment(3)=='')
			{
				?>
				$.ajax(
					{
						url: url+"profile/more_data",
						data:
						{
							call_count:call_count,active_tab:active_tab
						},
						type: "POST",
						success:function(html)
						<?php
					} else
					{
						?>
						var other_user = $("#other_user").val();
						$.ajax(
						{
							url: url+"profile/more_data",
							data:
							{
								call_count:call_count,active_tab:active_tab,other_user:other_user
							},
							type: "POST",
							success:function(html)
							<?php
						}?>
						{
							if(html != '')
							{								
								//alert('hiii');
								var i=1;
								var div_class;
								$("#load").remove();
								var obj = $.parseJSON(html);
								$.each(obj, function(index, element)
									{
										if(i == 1)
										{
											div_class = 'right5';
											i++;
										}
										else
										if(i == 2)
										{
											div_class = 'rightleft5';
											i++;
										}
										else
										{
											div_class = 'left5';
											i     = 1;
										}
										if(typeof element.profession != 'undefined')
										{
											var profession = element.profession;
											var lnt = profession.length;
											a = parseInt(lnt);
											if(a > 16)
											{
												var dot ='..';
											}else
											{
												var dot ='';
											}
											var length = 16;
											var trimmedprofession = profession.substring(0, length)+dot;
										}
										else
										{
											var trimmedprofession='';
										}
										var n = element.projectName.length;
										a = parseInt(n);
										if(a > 40)
										{
											var dot ='..';
										}
										else
										{
											var dot ='';
										}
										var length = 40;
										var trimmedName = element.projectName.substring(0, length)+dot;

										if($('#usrid').val()==element.userId)
										{
											var clickLink = "window.location='<?php echo base_url();?>project/edit_project/"+element.id+"'";

											if(element.competitionId == '0' && element.assignmentId == '0')
											{
												var edit_link ='<div class="col-lg-4 col-xs-4"><div class="photo"><span style="cursor:pointer;" onclick='+clickLink+'><i class="fa fa-pencil-square-o"></i>&nbsp;</span></div></div>';
											}											
											else
											{
												var edit_link ='';
											}

											//var edit_link ='<div class="col-lg-4 col-xs-4"><div class="photo"><span style="cursor:pointer;" onclick='+clickLink+'><i class="fa fa-pencil-square-o"></i>&nbsp;</span></div></div>';
											var img_cnt='';
										}else
										{
											var edit_link ='';
											var img_cnt= '<div class="col-lg-4 col-xs-4"><div class="photo"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div>';
										}
										var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
										/*if(!UrlExists("users/thumbs/"+element.profileImage))
										{
											var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
										}*/
										var loca;
										if(element.city!='')
										{
											loca = element.city;
										}else
										{
											loca = 'Location';
										}
										/*var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';*/
										/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
										var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
										if(element.userLiked==0)
										{										
											userLiked = '<div class="like dropdown"><div class="like_div" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>'+element.droupdown+'</div>';
										}
										else
										{
											
											userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';

										}
										var date = element.created;

										if(active_tab=='Assignment')
										{
											rebinClass = 'side-corner-tag';
											if(element.assignment_status == 0)
											{
												rebin = '<p class="ribbon"><span>ASSIGN</span></p>';
											}
											if(element.assignment_status == 1)
											{
												rebin = '<p class="ribbon"><span>SUBMITED</span></p>';
											}
											if(element.assignment_status == 2)
											{
												rebin = '<p class="ribbon"><span>PENDING</span></p>';
											}
											if(element.assignment_status == 3)
											{
												rebin = '<p class="ribbon"><span>ACCEPTED</span></p>';
											}
											if(element.assignment_status == 4)
											{
												rebin = '<p class="ribbon"><span>RE - SUBMITED</span></p>';
											}
										}
										else
										{
											rebin = '';
											rebinClass = '';
										}

										var videoLink = element.videoLink;
										if(videoLink != ''){
											var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
										}else{
											var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image"></a>'
										}
									$('#wrapper_div').append('<div class="col-lg-3 col-md-3 col-sm-6 '+div_class+'"><div class="box '+rebinClass+'">'+rebin+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px" ><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+element.firstName+'&nbsp;'+element.lastName+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div>'+edit_link+img_cnt+'</div></div></div></div></div>');
									})
									$('div.dropdown').hover(function() {
									  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
									}, function() {
									  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
									});
							}
							else
							{
								<?php if($this->uri->segment(1) == 'profile'){ ?> 	
								if(active_tab !='Competition' && active_tab !='Assignment')
								{								
									var addProjButton = '<button class="btn btn_bluebtn btn_blue" onclick="noProjectAdd();" style="border-radius: 9px ! important; margin-top: 29px ! important;">Add Project</button>';
								}
								else if(active_tab =='Assignment')
								{									
								var addProjButton = '<a class="btn btn_bluebtn btn_blue" style="border-radius: 9px ! important; margin-top: 29px ! important;" href="'+base_url+'assignment" >View Assignment</a>';
								}
								else
								{
									var addProjButton = '';
								}
								<?php } 

								else if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'userDetail' && $this->uri->segment('3') == $this->session->userdata('front_user_id')){  ?>	

									if(active_tab !='Competition' && active_tab !='Assignment')
									{									
									var addProjButton = '<button class="btn btn_bluebtn btn_blue" onclick="noProjectAdd();" style="border-radius: 9px ! important; margin-top: 29px ! important;">Add Project</button>';
									}
									else if(active_tab =='Assignment')
									{									
									var addProjButton = '<a class="btn btn_bluebtn btn_blue" style="border-radius: 9px ! important; margin-top: 29px ! important;" href="'+base_url+'assignment" >View Assignment</a>';
									}
									else
									{
										var addProjButton = '';
									}
									<?php 

								}



								else{  ?> var addProjButton =''; <?php } ?>

								$("#load_img_div").css('width', '400px').append('<div id="no_rec" style="height: 30px;top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">Oh, you have no more projects. Unleash your creativity NOW!. </h3></div>'+addProjButton);
							}
							$.unblockUI();
						}
					})
			})
			/*	$('.nav-tab-item').click(function()
			{
			$("#msg_div").html('');
			var name = $(this).data("name");
			$.ajax({
			url: url+"profile/sort_by",
			data: {name:name},
			type: "POST",
			success:function(html)
			{
			//$("#msg_div").html('');
			}
			});
			});*/
		});
</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/js/star-rating.js" type="text/javascript">
</script>
<script>
	$("#overAllRating").rating("refresh",{disabled:true});
</script>
<script>
	function sharelink(social)
	{
		if(social==1)
		{
			window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url();?>user/userDetail/<?php echo $user_profile->id;?>', '_blank');
		}
		else
		{
			window.open('https://twitter.com/share?url=<?php echo base_url();?>user/userDetail/<?php echo $user_profile->id;?>', '_blank');
		}
	}
</script>

<script>
function noProjectAdd()
{
	jQuery('#add_project_button').click();
}

</script>
