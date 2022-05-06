<?php $this->load->view('template/header');?>
<style>
	.fa-comment-o {
    display: block;
}

.navbar {
    background-color:rgb(0,0,0);
	}
	.alreadyRated
	{
		background-color: #159e2c !important;
		border-color: #159e2c !important;
	}
	#comp_detail .box_comp{
		height: 470px;
	}
	 @media screen and (-webkit-min-device-pixel-ratio:0) {

	     .hero2{
	     	height: 470px !important;
	     }
	}
	#rate_comment{
		height: 60px !important;
		  margin-top: 10px;
	}

	.studentTeam input{
	    margin-bottom: 10px;
	}

	.studentTeam small{
	    font-size: 12px;

		color: #e59d19;
	}
</style>
<div id="comp_detail" class="middle">
	<div class="container-fluid">
		<div class="row">
			<!--<div class="col-lg-12 breadcrumb-bg">-->
			<div class="col-lg-6 breadcrumb-bg">
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>">
							Home
						</a>
					</li>
					<li>
						<a href="<?php echo base_url()?>competition/competition_list">
							Competition
						</a>
					</li>
					<li class="active">
						<?php echo ucwords($competition[0]['name']);?>
					</li>
				</ol>
			</div>

			<div class="col-lg-6 breadcrumb-bg">
				<ol class="breadcrumb" style="text-align:right;">
					<li>
						<?php
			if($this->uri->segment(4) != '' && $competition[0]['competition_type'] == 3){ ?>
						<a href="<?php echo base_url()?>competition/spotlightProjects/<?php echo $competition[0]['id'];?>/<?php echo $this->uri->segment(4);?>" style="text-decoration: underline;font-weight: bold;color: #31bcf6;">
							VIEW SHORTLISTED PROJECTS
						</a>
						<?php } ?>
					</li>
				</ol>
			</div>

			<?php
				$competitionId = $competition[0]['id'];
			?>
			<div class="comp_list">
				<div class="col-lg-12">
					<div class="box_comp">
						<div class="hero">
							<img class="hero__background" style="background-color: #FFFF">
							<div class="hero__title"  style="overflow-y: auto; overflow-x: hidden;">
								<?php
								if(!empty($competition) && $competition[0]['profile_image'] != ''){
									?>
									<img src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $competition[0]['profile_image'];?>" alt="profile image" class="img-circle">
									<?php
								}
								else
								{
									?>
									<img alt="profile image"  class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png">
									<?php
								} ?>
								<h3>
									<?php echo ucwords($competition[0]['name']);?>
								</h3>
								<?php
								$CI            =& get_instance();
								$CI->load->model('model_basic');
								$competitionId = $CI->model_basic->getValue('user_competition_relation','competitionId'," `competitionId` = '".$competition[0]['id']."' AND   `userId` = '".$this->session->userdata('front_user_id')."'");
								$isJury        = $CI->model_basic->getValue('competition_jury_relation','juryId'," `competitionId` = '".$competition[0]['id']."' AND   `userId` = '".$this->session->userdata('front_user_id')."'");
								if($isJury == '' && $this->session->userdata('user_institute_id') !=''){
									if($competitionId != $competition[0]['id']){
										if($competition[0]['status'] == 1){
										if(($competition[0]['open_for_all'] == 1) || ($competition[0]['instituteId'] == $this->session->userdata('user_institute_id'))){
											/**
											*  Checking the competition type
											*/
											$competitionType = $CI->model_basic->getValue('competitions','competition_type'," `id` = '".$competition[0]['id']."' ");
											if($competitionType == 2 ){
											?>
											    <button class="joinTeam btn btn-warning" data-id="<?php
											             if(!empty($competition))
											            { echo $competition[0]['id'];}?>" data-toggle="modal" data-target="#joinTeamModal">
											    <i class="fa fa-plus">
											    </i> Join as Team Competition
											    </button><br/>
											<?php  } 
											elseif($competitionType == 3){
											    $front_user_id = $this->session->userdata('front_user_id');
											    $checkStudentLinkedComp = $this->db->select('competition_id')->from('competition_selected_student')->where('user_id',$front_user_id)->where('competition_id',$competition[0]['id'])->get()->result_array();
											    if(!empty($checkStudentLinkedComp)){ ?>
											    	<button class="join btn btn-success" data-id="<?php if(!empty($competition)){ echo $competition[0]['id'];}?>">
											    	<i class="fa fa-plus">
											    	</i>Join Competition
											    	</button><br/>
											    <?php }
											}
											else{ ?>
												<button class="join btn btn-success" data-id="<?php if(!empty($competition)){ echo $competition[0]['id'];}?>">
												<i class="fa fa-plus">
												</i>Join Competition
												</button><br/>
											<?php } ?>
										<?php }
									}
									}
									if($competitionId == $competition[0]['id']){
										$CI->load->model('competition_model');
										if(($competition[0]['open_for_all'] == 1) || ($competition[0]['instituteId'] == $this->session->userdata('user_institute_id'))){
											$competition_project = $CI->competition_model->checkCompetitionProjectExist($competition[0]['id']);
											//if($competition[0]['status'] == 1 || $competition[0]['status'] == 2){
											if($competition[0]['status'] == 1){
											/**
											    *  Checking the competition type */
											    $competitionType = $CI->model_basic->getValue('competitions','competition_type'," `id` = '".$competition[0]['id']."' ");	

											    /**
											    * [$getTeamStatus description]
											    * @var [type]
											    */
											    $getTeamStatus = $CI->model_basic->getTeamStatus($this->session->userdata('front_user_id'));
											    if(!empty($getTeamStatus[0]) && $getTeamStatus[0]['team_status'] == 2){?>
													<div class="warning" style="width: 94%;background: orange;color: #FFF;font-size: 16px;padding: 5px;margin: 12px;">
														Your are in team competition and this team is in warning mode because some of students ids are not there 
													</div>
												<?php } 
												else{
												?>
													<?php if(!empty($getTeamStatus[0]) && $competitionType == 2) {?>
														<div class="warning" style="width: 94%;background: green;color: #FFF;font-size: 16px;padding: 5px;margin: 12px;">
															Your are in team competition.  
														</div>
													<?php  } ?>
												
												<button class="submit_project btn btn-success" id="competitionProj" data-id="<?php if(!empty($competition)) { echo $competition[0]['id'];}?>">
													<i class="fa fa-plus">
													</i> Submit New Project
												</button>

												<?php //if(!empty($exstingProject)){?>
												<!--
												<button class="btn btn-default" data-toggle="modal" data-target="#myModal1" data-controls-modal="myModal1" data-backdrop="static" data-keyboard="false" id="competitionProj">
													<i class="fa fa-upload">
													</i> Add Existing Project
												</button>-->
												<?php
																								//}else{ echo '<br/>';}
																							}
																						} else{
																							$getTeamStatus = $CI->model_basic->getTeamStatus($this->session->userdata('front_user_id'));
																							?>

																							<?php if(!empty($getTeamStatus[0]) && $competitionType == 2) {?>
																								<div class="warning" style="width: 94%;
												background: green;
												color: #FFF;
												font-size: 16px;
												padding: 5px;
												margin: 12px;
												">Your are in "<b style="color: #FFF"><?php echo $getTeamStatus[0]['team_name'];?></b>" team competition.  </div>
																									<?php  }?>
																									<div class="warning" style="width: 94%;
												color: orange;
												font-size: 16px;
												padding: 5px;
												margin: 12px;
												">You have added project to this competition </div>


																						<?php }
																					}
																				}
																			}
																				?>
																				
								<div class="descript">
									<div style=" text-align: center;">
										<a href="mailto:<?php echo $competition[0]['contactEmail'];?>">
											<?php echo $competition[0]['contactEmail'];?>
										</a>
									</div>
								</div>
								<div class="descript">
									<h3>
									Description : 
									</h3>
									<div style=" text-align: justify;">
										<?php echo $competition[0]['description'];?>
									</div>
								</div>
							</div>
						</div>
						<div class="hero2">
							<?php
							if(!empty($competition) && $competition[0]['banner'] != ''){
								?>
								<img class="hero2__background" alt="profile image" src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $competition[0]['banner'];?>">
								<?php
							}
							else
							{
								?>
								<img alt="background image" class="hero2__background">
								<?php
							} ?>
							<div class="dates">
								<div class="startEnd">
									<p>
										<i class="fa fa-calendar-check-o">
										</i>Start Date :
										<span>
											<?php echo date("M j, Y",strtotime($competition[0]['start_date']));?>
										</span>
									</p>
									<p>
										<i class="fa fa-calendar-check-o">
										</i>End Date :
										<span>
											<?php echo date("M j, Y",strtotime($competition[0]['end_date']));?>
										</span>
									</p>
								</div>
								<div class="view_more">
									<a href="#disc" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="Example" style="color: #00b4ff;">
										<i class="fa fa-angle-double-down">
										</i>
									</a>
								</div>
								<div class="Evaluation">
									<p>
										<i class="fa fa-calendar-check-o">
										</i>Evaluation Start Date :
										<span>
											<?php echo date("M j, Y",strtotime($competition[0]['evaluation_start_date']));?>
										</span>
									</p>
									<p>
										<i class="fa fa-calendar-check-o">
										</i>Evaluation End Date :
										<span>
											<?php echo date("M j, Y",strtotime($competition[0]['evaluation_end_date']));?>
										</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div id="disc" class="collapse in">
					<div class="view_more_disc" style="background: none;color: #000">
						<div class="col-lg-3">
							<!--<h3>
								Award
							</h3>
							<p>
								<i class="fa fa-trophy">
								</i><?php echo $competition[0]['award'];?>
							</p>-->
						</div>
						<div class="col-lg-3">
							<h3>
								Eligibility
							</h3>
							<p>
								<?php echo $competition[0]['eligibility'];?>
							</p>
						</div>
						<div class="col-lg-3">
							<h3>
								Number of Category Wise Winners
							</h3>
							<p>
								<i class="fa fa-trophy">
								</i>
								<?php 
									if($competition[0]['competition_type'] == 3){
										echo "Category Wise Winners";
									}else{
										echo $competition[0]['winnerCount'];
									}
								?>
							</p>
						</div>
						<div class="col-lg-3">
							<!--<h3>
								Share Competition
							</h3>
							<ul>
								<?php $detail_link = base_url().'competition/'.$competition[0]['pageName'];?>
								<li>
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $detail_link;?>" target="_blank">
										<img src="<?php echo base_url();?>assets/images/fcbk.png" alt="">
									</a>
								</li>
								<li>
									<a href="https://twitter.com/share?url=<?php echo $detail_link;?>" target="_blank">
										<img src="<?php echo base_url();?>assets/images/twt.png" alt="">
									</a>
								</li>
							</ul>-->
						</div>
						<div class="col-lg-12">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												Rules
											</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<?php echo $competition[0]['rule'];?>
											<?php if($competition[0]['video_link'] !=''){?>
											<?php $vLink= explode("youtu.be/",$competition[0]['video_link']);
											if($vLink[1] !=''){?>
											<br />
											<iframe  width="560" height="315" src="https://www.youtube.com/embed/<?php echo $vLink[1];?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><br />
											<?php  }  }?>
											<?php if($competition[0]['pdf_file'] !=''){?>
											<br />
											<iframe  width="560" height="715" src="<?php echo file_upload_base_url();?>competition/pdf_file/<?php echo $competition[0]['pdf_file'];?>"></iframe>
											<?php  }  ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="jury">
					<h2>
						Competition Jury
					</h2>
					<?php
					if(!empty($juries)){
						foreach($juries as $jury){
							?>
							<div class="jury_content">
								<img class="img-circle" src="<?php echo file_upload_base_url();?>competition/juryPhoto/thumbs/<?php echo $jury['photo'];?>" alt="thumbs image">
								<h4>
									<!-- <a href=""> -->
									<!-- <a href="mailto:<?php echo $jury['email'];?>"> -->
									
										<?php echo $jury['name'];?>
									<!-- </a> -->
								</h4>
								<!--<a data-controls-modal="juryWriteUpModal" data-backdrop="static" data-keyboard="false" data-target="#juryWriteUpModal" style="cursor:pointer;" id="writeUp" data-id="<?php echo $jury['id'];?>" data-toggle="modal">
									See Write Up
								</a>-->
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>


<style>
	#competition_category_filter{
		/*background: #5e5e5e none repeat scroll 0 0;*/
		border: 1px solid #fff;
		border-radius: 4px;
		color: #fff;
		display: inline-block;
		margin-bottom: 15px;
		padding: 15px;
		width: 100%;
	}
</style>

<?php
$this->CI =& get_instance();
$this->CI->load->model('project_model');
$this->CI->load->model('competition_model');
$competition_zone = $this->db->select('*')->from('zone_list')->get()->result_array();
$competition_category = $this->CI->competition_model->getAllCategory($competition[0]['id']);
$instituteZoneId = array();

if($competition[0]['open_for_all'] != 1)
{
	$instituteZoneId = $this->model_basic->getData("institute_master","zone,region",array('id'=>$competition[0]['instituteId']));

}

?>

			<div class="col-lg-12">
				<?php if(!empty($this->uri->segment(4))){?>
					<form action="<?php echo base_url();?>competition/get_competition/<?php echo $competition[0]['id'];?>/<?php echo $this->uri->segment(4);?>" name="category_filter" method="post">
					
				<?php }else{?>
					<form action="<?php echo base_url();?>competition/get_competition/<?php echo $competition[0]['id'];?>" name="category_filter" method="post">
					
				<?php } ?>
				
				<div id="competition_category_filter" class="collapse in" style="background-color:#A49F9E">
					<div class="view_more_disc">
						<div class="col-lg-2">							
							
							<?php 
							$catid = $this->session->userdata('catid');
							
							echo '<select id="competition_category" name="competition_category" class="form-control">';
							?>
							<option value="0">Select Category</option>
							<?php
							    if(!empty($competition_category))
							    {
							    	foreach($competition_category as $comp_cat)
							    	{
							    
							        	$selected = $comp_cat['id'] == $catid ? 'selected="selected"' : '';
							        	echo "<option {$selected} value=\"{$comp_cat['id']}\">{$comp_cat['categoryName']}</option>";
							    	}
								}
							    echo '</select>'; ?>				
						</div>
						<?php 
						if($this->uri->segment(4) != ''){ ?>
						<div class="col-lg-2">							
							<?php $projectratefrom = $this->session->userdata('compProjRatingFrom'); ?>
							<select id="project_rating_from" name="project_rating_from" class="form-control" onchange="selectRatingTo(this.value)">
							    <option value="">
							    	Select Rating From
							    </option>
							    <?php
							    	for($i = 1; $i < 11; $i++){
							    		$selected = $i == $projectratefrom ? 'selected="selected"' : '';
							    	echo "<option {$selected} value=\"{$i}\">{$i}</option>";
							    ?>
							    
							    <?php
							    }
							    ?>
							</select>				
						</div>
						<div class="col-lg-2">							
							<?php $projectrateto = $this->session->userdata('compProjRatingTo'); 
							if($projectrateto !=''){ ?>
								<select id="project_rating_to" name="project_rating_to" class="form-control">
							<?php
								for($i = $projectrateto; $i < 11; $i++){
									$selected = $i == $projectrateto ? 'selected="selected"' : '';	
									echo "<option {$selected} value=\"{$i}\">{$i}</option>";
								}
							?></select>
							<?php }else{ ?>
								<select id="project_rating_to" name="project_rating_to" class="form-control">
								    <option value="">
								    	Select Rating To
								    </option>
								    
								</select>
							<?php }
							?>
											
						</div>
					<?php } ?>
						<div class="col-lg-2">						
							
							<input type="submit" class="btn btn-default" id="filter_projet" name="filter_projet" value="Filter Project" />
							<input type="submit" class="btn btn-default" id="clear_projet" name="clear_projet" value="Reset Filter" />
						</div>
						<div class="col-lg-4" >	
						    <div style=" display: flex; text-align: start; float: right;">	
						    <p style="font-size: 20px;margin: 0 0 0;">Project Count :</p>&nbsp;&nbsp;&nbsp;&nbsp;
						    <p style="font-size: 20px;margin: 0 0 0;"><?php echo $totalProjectCount; ?></p>
						   </div>	
						  </div>
						
					</div>
				</div>
			</form>
			</div>
			<?php 
			$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
			$ho_status = $this->model_basic->getValue($this->db->dbprefix('users'),"admin_level"," `id` = '".$FRONT_USER_SESSION_ID."'");
			$jury_status = $this->model_basic->getValue($this->db->dbprefix('competition_jury_relation'),"userId"," `userId` = '".$FRONT_USER_SESSION_ID."'");
			if(isset($ho_status) && !empty($ho_status) && $ho_status=='4' || $ho_status=='2' || $ho_status=='1') 
			{ 
				$flag=1;
			} 
			if(isset($jury_status) && !empty($jury_status) && $jury_status==$FRONT_USER_SESSION_ID)
			{
				$flag=1;
			} 
			if(isset($flag) && !empty($flag) && $flag=='1') 
			{ ?>
				<div class="col-lg-12">
					<?php if(!empty($winningProjects)){
						$catproj = array();
						if($competition[0]['category_wise_winner'] == 1)
						{
							if ($this->session->userdata('user_admin_level') == 2 || $this->session->userdata('user_admin_level') == 4 || $this->session->userdata('user_admin_level') == 1){
								foreach ($winningProjects as $key => $value) 
								{
									$catproj[$value['categoryName']][]=$value;
								}

								foreach ($catproj as $key => $value) 
								{ ?>
									<div class="winner">
								 		<h2>
								 			Winner Projects of  " <?php echo $key;?> " 
								 		</h2>
								 	<div class="tranding_projects">
								 		<?php
								 		if(!empty($value))
								 		{
								 			$data = array();
								 			$data['project'] = $value;
								 			$data['competition'] = $competition;
								 			$data['thumbnailNum'] = 4;
								 			$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';
								 			$this->load->view('template/projectThumbnailView',$data);
								 		}
								 		?>
								 	</div>
								 	</div>
								<?php	} } }
							else 
							{ ?>
								<div class="winner">
									<h2>
										Winner Projects!
									</h2>
									<div class="tranding_projects">
									<?php
										if(!empty($winningProjects))
										{
											$data = array();
											$data['project'] = $winningProjects;
											$data['competition'] = $competition;
											$data['thumbnailNum'] = 4;
											$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';
											$this->load->view('template/projectThumbnailView',$data);
										}
									?>
								</div>
							</div>	
					<?php } }  ?>		
				</div>
			<?php } ?>
			<div class="participate_project">
				<div class="tranding_projects" id="project_div">
					<div class="col-lg-12">
						<h2>
							Participated Projects
						</h2>
					</div>
					<?php
					//echo "hii";
					
					if(!empty($project))
					{
						$data = array();
						$data['project'] = $project;
						$data['isJury'] = $isJury;
						$data['thumbnailNum'] = 4;
						$data['competition'] = $competition;
						$data['rateButton'] = $this->uri->segment(4);
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';
						$this->load->view('template/projectThumbnailView',$data);
					}
					?>
				</div>
			</div>
			<div class="col-lg-12">
			<div id="load_img_div" style="width:400px;">
			</div>
				<input type="hidden" id="call_count" value="2"/>
				<input type="hidden" id="competition" value="<?php echo $competition[0]['id'];?>"/>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="rate_form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
					<h4 class="modal-title" style="text-align: center" id="myModalLabel">
						Rate this project
					</h4>
				</div>
				<div class="modal-body">
				    <div class="row">
				        <div class="col-sm-8">
				            <div class="polaroid" id="polaroImage">
				            	<div class="carousel-container">
				            	  <div id="myCarousel" class="carousel slide">
				            	      <!-- Indicators -->
				            	      <ol class="carousel-indicators" id="indicators">
				            	      </ol>
				            	      <div class="carousel-inner" id="homepageItems">
				            	      </div>
				            	      <div class="carousel-controls" id="carouselNav"> 
				            	        <a class="carousel-control left" href="#myCarousel" data-slide="prev"> 
				            	          <span class="glyphicon glyphicon-chevron-left"></span> 
				            	        </a>
				            	        <a class="carousel-control right" href="#myCarousel" data-slide="next"> 
				            	          <span class="glyphicon glyphicon-chevron-right"></span> 
				            	        </a>
				            	      </div>
				            	  </div>
				            	</div>
				          	</div>
				          	<div class="polaroid" id="polaroVideo">
				          	</div>
				        </div>

				        <div class="col-sm-4">
				          <div class="row" style="margin-right: 3px;margin-bottom: 3px;">
				          Project Rating
				          </div>
				          <div class="row" style="margin-right: 3px;margin-bottom: 6px;">
				          <select class="form-control" name="rating" id="proj_rating" required>
				          	<option value="">
				          		Select Rating
				          	</option>
				          	<?php
				          	for($i = 0; $i < 11; $i++){
				          		?>
				          		<option value="<?php echo $i;?>">
				          			<?php echo $i;?>
				          		</option>
				          		<?php
				          	}
				          	?>
				          </select>  
				          </div>
				          <?php if($competition[0]['competition_type'] == 3){ ?>
				          <!--<div class="row" style="margin-right: 3px;margin-bottom: 3px;">
				          Technical Evaluation Rating
				          </div>-->
				         <!-- <div class="row" style="margin-right: 3px;margin-bottom: 3px;">
				          <select class="form-control" name="eval_rating" id="eval_rating">
				          	<option value="">
				          		Select Rating
				          	</option>
				          	<?php
				          	//for($i = 0; $i < 11; $i++){
				          		?>
				          		<option value="<?php //echo $i;?>">
				          			<?php //echo $i;?>
				          		</option>
				          		<?php
				          	//}
				          	?>
				          </select> 
				          </div> --> 
				          <?php } ?>  
				          <div class="row" style="margin-right: 3px;margin-bottom: 3px;">
				          	<textarea name="rate_comment" class="form-control" id="rate_comment" placeholder="Write your comment here."></textarea>
				          </div>
				          <div class="row" id="projectLink" style="margin-right: 3px;word-break:break-word;">
				          	
				          </div>
				      </div>
				          
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-default" data-dismiss="modal">
				    	Close
				    </button>
				    <button type="submit" class="btn btn-primary">
				    	Save changes
				    </button>
				</div>
			</form>

		</div>
	</div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Select Project to Submit for Competition
				</h4>
			</div>
			<form id="submitExstingUserProject" method="post" action="<?php echo base_url();?>competition/submitExstingUserProject">
				<div class="modal-body form-group">
					<select class="form-control" name="exstingProjectId" id="exstingProjectId">
						<option value="">
							Select Project to Submit for Competition
						</option>
						<?php
						foreach($exstingProject as $value){
							?>
							<option value="<?php echo $value['id']?>">
								<?php echo $value['projectName']?>
							</option>
							<?php
						}?>
					</select>
					<span id="exstingProjectId_error" style="color: red">
					</span>
					<input type="hidden" name="competitionId" value="<?php echo $competitionId;?>"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
					<button type="submit"  class="btn btn-primary">
						Submit Project
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="juryWriteUpModal" tabindex="-1" role="dialog" aria-labelledby="juryWriteUpModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="rate_form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
					<h4 class="modal-title" style="text-align: center" id="juryWriteUpModalLabel">
						Jury Write Up
					</h4>
				</div>
				<div class="modal-body form-group">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div id="juryInfo">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Team Modal -->
<div class="modal fade" id="joinTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Join as Team</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="<?php echo base_url();?>competition/insertTeamCompetition">
      <div class="modal-body">


          <div class="form-group">
            <label for="exampleInputEmail1">Team Name</label>
            <input type="text" class="form-control" id="teamName" name="teamName" placeholder="Enter Team Name" required="">
          </div>
          <div class="form-group studentTeam">
            <label for="exampleInputPassword1">Add students to team</label>
            <input type="hidden" value="<?php echo $competition[0]['id'];?>" name="compID">


            <!-- <input type="text" class="typeahead tm-input form-control tm-input-info" id="studentsList" > -->
              <input type="text" class="form-control teamCls"  name="studentTeam[]" placeholder="Student 1 (Student ID)" required="" width="13%" data-student="s1">

              <small id="s1" class="form-text text-muted" style="display: none;">Student ID not found, But still you can add</small>


              <input type="text" class="form-control teamCls"  name="studentTeam[]" placeholder="Student 2 (Student ID)" data-student="s2">
              <small id="s2" class="form-text text-muted" style="display: none;">Student ID not found, But still you can add</small>

              <input type="text" class="form-control teamCls"  name="studentTeam[]" placeholder="Student 3 (Student ID)" data-student="s3">
              <small id="s3" class="form-text text-muted" style="display: none;">Student ID not found, But still you can add</small>

              <input type="text" class="form-control teamCls"  name="studentTeam[]" placeholder="Student 4 (Student ID)" data-student="s4">
              <small id="s4" class="form-text text-muted" style="display: none;">Student ID not found, But still you can add</small>

              <input type="text" class="form-control teamCls"  name="studentTeam[]" placeholder="Student 5 (Student ID)" data-student="s5">
              <small id="s5" class="form-text text-muted" style="display: none;">Student ID not found, But still you can add</small>



                  <br><small id="emailHelp" class="form-text text-muted">Minimum 1 students are required to add as a team and maximum 5 students can be added as a team.</small>

          </div>

            <span id="dupids" style="color: red; display: none; font-size: 14px">You have added duplicate student ids, please check</span>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="teamCData">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="myModalSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="select_form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
					<h4 class="modal-title" style="text-align: center" id="myModalLabel">
						Select this project for next level
					</h4>
				</div>
				<div class="modal-body">
				    <div class="row">
				        <div class="col-sm-12">
				            <div class="polaroid" id="selectPolaroImage">
				            	<div class="carousel-container">
				            	  <div id="selectMyCarousel" class="carousel slide">
				            	      <!-- Indicators -->
				            	      <ol class="carousel-indicators" id="selectIndicators">
				            	      </ol>
				            	      <div class="carousel-inner" id="selectHomepageItems">
				            	      </div>
				            	      <div class="carousel-controls" id="selectCarouselNav"> 
				            	        <a class="carousel-control left" href="#selectMyCarousel" data-slide="prev"> 
				            	          <span class="glyphicon glyphicon-chevron-left"></span> 
				            	        </a>
				            	        <a class="carousel-control right" href="#selectMyCarousel" data-slide="next"> 
				            	          <span class="glyphicon glyphicon-chevron-right"></span> 
				            	        </a>
				            	      </div>
				            	  </div>
				            	</div>
				          	</div>
				          	<div class="polaroid" id="selectPolaroVideo">
				          	</div>
				        </div>

				      </div>
				          
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-default" data-dismiss="modal">
				    	Close
				    </button>
				    <button type="submit" class="btn btn-primary">
				    	Select
				    </button>
				</div>
			</form>

		</div>
	</div>
</div>
<input type="hidden" value="<?php echo $competition[0]['hidename']?>" id="hidename"/>
<div class="clearfix"></div>
</div>

<?php $this->load->view('template/footer');?>
<script>
	$('#submitExstingUserProject').on('submit', function()
		{
			var exstingProjectId=$('#exstingProjectId').val();
			if(exstingProjectId=='')
			{
				$('#exstingProjectId_error').html('Please select project.');
				return false;
			}
			else
			{
				return true;
			}
		});
</script>
<script>
	$('#myModal1').on('hidden.bs.modal', function (e)
		{
			$('#myModal1').hide();
			$('#myModal').hide();
		})
	$(document).ready(function()
		{
			$(document).on("click", "#rateIt", function ()
				{
					$('#ratingInfo').hide();
					var projectId = $(this).data('id');
					var competitionId='<?php echo $competitionId;?>';
					var projectImage = $(this).data('name');
					var projectFileLink = $(this).data('link');
					var projectRateVal = $(this).data('rate');
					var techRateVal = $(this).data('techrate');
					projectImageId = projectImage.split(/\s(.+)/)[0]; 
					projectVideoLink = projectImage.split(/\s(.+)/)[1]; 
					var projectImageThumb = $(this).data('img');
					var projectImageArray = projectImageThumb.split(',');
					if (typeof projectVideoLink != 'undefined') {
						$("#carouselNav").hide();
					    $("#polaroVideo").append('<iframe id="ratedVideo" width="100%" height="350px" src="https://www.youtube.com/embed/'+projectVideoLink+'?rel=0" frameborder="0" allowfullscreen></iframe>');

					}
					else{
										
						//$("#polaroImage").append('<center><img id="ratedImage" class="img-responsive" width="100%" height="350px" src="<?php echo file_upload_base_url();?>project/thumb_big/'+projectImageId+'"/></center>');
						$("#carouselNav").show();
						var response = '',
						indicator = '';
						for (var i = 0; i < projectImageArray.length; i++) {
						    response += '<div class="item"><img class="img-responsive" alt="blog image" src="<?php echo file_upload_base_url();?>project/thumb_big/' + projectImageArray[i] + '"></div>';
						    indicator += '<li data-target="#myCarousel" data-slide-to="'+i+'"></li>';
						}
						$('#homepageItems').append(response);
						$('#indicators').append(indicator);
						$('.item').first().addClass('active');
						$('.carousel-indicators > li').first().addClass('active');
						$("#myCarousel").carousel({interval: false, ride: false, pause: false});
					}
					if (projectFileLink != '') {
						$("#projectLink").append('<p class="title" style="padding-bottom: 0px;font-weight: bold">Work/Project Files Link:</p><p  style="text-align:justify;"><a href="'+ projectFileLink +'" target="_blank">'+ projectFileLink +'</a></p>');

					}
					if (projectRateVal != '') {
						$('#proj_rating').val(projectRateVal);

					}
					if (techRateVal != '' || techRateVal != 0) {
						$('#eval_rating').val(techRateVal);

					}
					$.ajax(
						{
							url: '<?php echo base_url();?>'+'competition/getRating',
							type: 'POST',
							data:
							{
								projectId: projectId,competitionId:competitionId
							},
						})
					.done(function(res)
						{
							var obj = $.parseJSON(res);
							if(obj.length != 0)
							{
								if(obj.yourRating >= 0)
								{
									var yourRating='<span style="line-height:35px;font-family: helveticaneue-light;font-size: 14px;font-weight:bold;">Your Rating : '+obj.yourRating+'</span>';
								}
								else
								{
									var yourRating='';
								}
								$('#ratingInfo').html('<span style="line-height:18px;font-family: helveticaneue-light;font-size: 14px;font-weight:bold;">Project Average Rating : '+obj.avgRating+'</span><br/>'+yourRating+'<br/>');
								$('#ratingInfo').show();
							}
						});
					$("#rate_form").attr('action', '<?php echo base_url();?>competition/rateProject/'+projectId);
				});
			$('#myModal').on('hidden.bs.modal', function (e)
				{
					$('#rate_form')[0].reset();
					$('#homepageItems').empty();
					$('#indicators').empty();
					$('#ratedVideo').remove();
					$('#projectLink').empty();
				})
			$(document).on("click", "#writeUp", function ()
				{
					var juryId = $(this).data('id');
					/*			     var competitionId='<?php echo $competitionId;?>';*/
					$.ajax(
						{
							url: '<?php echo base_url();?>'+'competition/getJuryWriteUp',
							type: 'POST',
							data:
							{
								juryId: juryId
							},
						})
					.done(function(res)
						{
							var obj = $.parseJSON(res);
							if(obj.length != 0)
							{
								$('#juryInfo').html('<span style="line-height:18px;font-family: helveticaneue-light;font-size: 14px;font-weight:bold;">'+obj+'</span><br/>');
							}
						});
				});
			$('#juryWriteUpModal').on('hidden.bs.modal', function (e)
				{
					$('#juryInfo').html('');
					$('#myModal').hide();
				})
		});
	
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
			$('#call_count').val(2);
		});*/
	$(document).ready(function()
		{
			var url=$('#base_url').val();
			var competition=$('#competition').val();
			var cat_id = 0;
			var hidename=$('#hidename').val();	
			var scrollFunction = function()
			{
				competition_zone = $('#competition_zone').val();			
				competition_region = $('#competition_region').val();
				competition_institute = $('#competition_institute').val();
				competition_category = $('#competition_category').val();
				
				var call_count= $("#call_count").val();
				var mostOfTheWayDown = ($(document).height() - $(window).height());
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img style="width:100px;" alt="load image" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"competition/more_data",
								data:
								{
									call_count:call_count,competition:competition,competition_zone:competition_zone,competition_region:competition_region,competition_institute:competition_institute,competition_category:competition_category
								},
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										var i = 1;
										var div_class;
										$("#load").remove();
										var obj = $.parseJSON(html);
										$.each(obj, function(index, element)
											{
												if(i == 1)
												{
													div_class = 'right5';
												}
												else
												if(i == 2 || i == 3)
												{
													div_class = 'rightleft5';
												}
												else
												{
													div_class = 'left5';
													i=0;
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
												var loca;
												if(element.city!='') { loca = element.city; }else{ loca = 'Location';}
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
												var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
												/*if(!UrlExists(profileImage))
												{
													var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												var date = element.created;
												if(hidename==1)
												{
													var echoName=element.firstName+' '+element.lastName;
												}
												else
												{
													var echoName='User Id : '+element.userId;
												}
												
												var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
												if(element.userLiked==0)
												{
													/*userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/

													userLiked = '<div class="like like_div dropdown" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';

												}
												else{
													/*userLiked = '<div class="like"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/

													userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';

												}
												var myStr = element.firstName+' '+element.lastName;
												var getStrLength = myStr.length;
												var fixedLengthSter = myStr.substring(0, 22);
												if(getStrLength > 22)
												{
													var str2 = '...';
													var fixedLengthSter = fixedLengthSter.concat(str2)
												}

												var sessiondata="<?php echo ($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0)?'':'guest'; ?>";
													if(sessiondata=='guest')
													{
														var userlink='<span style="margin-top:10px;padding-left:0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" ></span>';
													}
													else
													{
														var userlink='<span style="padding-left:0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" href=<?php echo base_url()?>user/userDetail/'+element.userId+'>'+fixedLengthSter+'</span>';
													}
												$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'"><div class="box">'+element.rateDiv+'<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="thumbs image" onclick='+urllink+'><div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="<?php echo base_url()?>projectDetail/'+element.projectPageName+'">'+element.projectName+'</a></div><div class="col-lg-9 col-xs-9 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5>'+userlink+'</div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
												i++;
											});
											$('div.dropdown').hover(function() {
											  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
											}, function() {
											  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
											});
									}
									else
									{									
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
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
				}
			};
			$(window).scroll(scrollFunction);
			$('.join').click(function()
				{
					var competition_id = $(this).attr('data-id');
					if(competition_id!='')
					{
						$.ajax(
							{
								url: url+"competition/join_competition",
								data:
								{
									competition_id:competition_id
								},
								type: "POST",
								success:function(html)
								{
									window.location="<?php echo base_url();?>hauth/googleLogin";
								}
							});
					}
					else
					{
						window.location="<?php echo base_url();?>hauth/googleLogin";
					}
				})
			$('.submit_project').click(function()
				{
					var competition_id = $(this).attr('data-id');	

					if(competition_id!='')
					{
						$.ajax(
							{
								url: url+"competition/get_competition_category/"+competition_id,								
								success:function(html)
								{
									$('#project_category').html('');
									$('#project_category').append(html);
								}
							});

						$('.AddProject').toggle();
						$('.AddProject #Save_Competition_Id').val(competition_id);
						$('#privateProject').hide();
						$('#draftProject').hide();					
					}
				})

			$('#add_project_button').click(function()
				{					
					$.ajax(
						{
							url: url+"competition/get_competition_category",	
							success:function(html)
							{
								$('#project_category').html('');
								$('#project_category').append(html);
							}
						});	
				})
		});

function get_competition_region(arg)
{
	var zoneId = $(arg).val();
	$.ajax(
		{
			url: base_url+"competition/get_regions/"+zoneId,								
			success:function(html)
			{
				$('#competition_region').html('');
				$('#competition_region').append(html);
				$('#competition_institute').html('');
				$('#competition_institute').append('<option value="">Select Project Institute</option>');
			}
		});

}

function get_competition_institute(arg)
{
	var regionId = $(arg).val();
	$.ajax(
		{
			url: base_url+"competition/get_Institute/"+regionId,								
			success:function(html)
			{
				$('#competition_institute').html('');
				$('#competition_institute').append(html);
			}
		});
}

function sort_project()
{
	$("#load_img_div").html(' ');
	 competition_zone = $('#competition_zone').val();			
	 competition_region = $('#competition_region').val();
	 competition_institute = $('#competition_institute').val();
	competition_category = $('#competition_category').val();	
	var competition=$('#competition').val();
	var url=$('#base_url').val();		
		$("#project_div").html('');	
		$("#call_count").val('1');
		var call_count= $("#call_count").val();
		a = parseInt(call_count);
		$("#call_count").val(a+1);	
		$.ajax(
			{
				url: url+"competition/more_data",
				data:
				{
					call_count:call_count,competition:competition,competition_zone:competition_zone,competition_region:competition_region,competition_institute:competition_institute,competition_category:competition_category
				},
				type: "POST",
				success:function(html)
				{							
					if(html != '')
					{
						var i = 1;
						var div_class;
						$("#load").remove();
						var obj = $.parseJSON(html);
						$('#project_div').append('<div class="col-lg-12"><h2> Participated Projects </h2>');
						$.each(obj, function(index, element)
							{
								if(i == 1)
								{
									div_class = 'right5';
								}
								else
								if(i == 2 || i == 3)
								{
									div_class = 'rightleft5';
								}
								else
								{
									div_class = 'left5';
									i=0;
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
								var loca;
								if(element.city!='') { loca = element.city; }else{ loca = 'Location';}
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
								var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
								/*if(!UrlExists(profileImage))
								{
									var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
								}*/
								var date = element.created;
								if(hidename==1)
								{
									var echoName=element.firstName+' '+element.lastName;
								}
								else
								{
									var echoName='User Id : '+element.userId;
								}								
								var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
								if(element.userLiked==0)
								{	
									userLiked = '<div class="like like_div dropdown" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
								}
								else{	
									userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
								}
								var myStr = element.firstName+' '+element.lastName;
								var getStrLength = myStr.length;
								var fixedLengthSter = myStr.substring(0, 22);
								if(getStrLength > 22)
								{
									var str2 = '...';
									var fixedLengthSter = fixedLengthSter.concat(str2)
								}
								var sessiondata="<?php echo ($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0)?'':'guest'; ?>";
													if(sessiondata=='guest')
													{
														var userlink='<span style="margin-top:10px;padding-left:0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" ></span>';
													}
													else
													{
														var userlink='<span style="padding-left:0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" href=<?php echo base_url()?>user/userDetail/'+element.userId+'>'+fixedLengthSter+'</span>';
													}
								$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 given glass'+div_class+'"><div class="box">'+element.rateDiv+'<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="thumbs image" onclick='+urllink+'><div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="<?php echo base_url()?>projectDetail/'+element.projectPageName+'">'+element.projectName+'</a></div><div class="col-lg-9 col-xs-9 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5>'+userlink+'</div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
								i++;
							});
						$('#project_div').append('</div>');
						/*$('html, body').animate({
					        scrollTop: $("#project_div").offset().top
					    }, 100);*/

							$('div.dropdown').hover(function() {
							  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
							}, function() {
							  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
							});
					}
					else
					{
						$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
					}
					//$(window).scroll(scrollFunction);
				}
			});
	}

</script>

<?php if(!empty($instituteZoneId)){
	?>
	<script>
	$(document).ready(function()
		{
			var zoneIds = $('#competition_zone').val();	
			var regionIds = '<?php echo $instituteZoneId["region"]; ?>';	
			var instituteIds = '<?php echo $competition[0]['instituteId']; ?>';			
			$.ajax(
				{
					url: base_url+"competition/get_defult_regions",	
					data:
					{
						zoneId:zoneIds,regionId:regionIds
					},
					type: "POST",							
					success:function(html)
					{	
						$('#competition_region').html('');
						$('#competition_region').append(html);
						$('#competition_institute').html('');
						$('#competition_institute').append('<option value="">Select Project Institute</option>');
						$.ajax(
								{
									url: base_url+"competition/get_defult_Institute",	
									data:
									{
										regionId:regionIds,instituteId:instituteIds
									},
									type: "POST",							
									success:function(html)
									{
										$('#competition_institute').html('');
										$('#competition_institute').append(html);
									}
								});
					}
				});

		})

	</script>

	<?php }  ?>
		<script type="text/javascript">

			function checkDuplicates() {
	  // get all input elements
	  var $elems = $('.teamCls');

	  // we store the inputs value inside this array
	  var values = [];
	  // return this
	  var isDuplicated = false;
	  // loop through elements
	  $elems.each(function () {
	    //If value is empty then move to the next iteration.
	    if(!this.value) return true;
	    //If the stored array has this value, break from the each method
	    if(values.indexOf(this.value) !== -1) {
	       isDuplicated = true;
	       return false;
	     }
	    // store the value
	    values.push(this.value);
	  });

	return isDuplicated;
	}


	$('#teamCData').on('click', function(e) {
	console.log(checkDuplicates());
	if(checkDuplicates()){
		$('#dupids').show();
		return false;
	} else{
	$('#dupids').hide();
		return true;
	}

	});



	$(document).ready(function()
			{
				var url=$('#base_url').val();

					$('.teamCls').keyup(function()
					{

						var studentID = $(this).val();
						console.log("length", $.trim(studentID).length);
						var $sid = $(this).data('student');
										console.log($sid);
						if(studentID!='' && $.trim(studentID).length > 6)
						{
							$.ajax(
								{
									url: url+"competition/getStudentIDsForJoinTeamCompetition",
									data:
									{
										query:studentID
									},
									type: "GET",
									success:function(html)
									{

										var returnedData = JSON.parse(html);
										console.log(returnedData.status);
										console.log($sid);


										if(returnedData.status == 0){

												$('#'+$sid).show();
												/*if($("#warnStatus").length == 0){
												$('.studentTeam').append('<div id="warnStatus"> <input type="hidden" value="2" name="warning" ></div>');
											}*/

										} else{
											$('#'+$sid).hide();
											/*$('#warnStatus').remove();*/
										}


									}
								});
						}

					})


			});


	</script>
	<script type="text/javascript">
	$(document).on("click", "#selectIt", function ()
	{
		$('#ratingInfo').hide();
		var projectId = $(this).data('id');
		var competitionId='<?php echo $competitionId;?>';

		var projectImage = $(this).data('name');
		projectImageId = projectImage.split(/\s(.+)/)[0]; 
		projectVideoLink = projectImage.split(/\s(.+)/)[1]; 
		var projectImageThumb = $(this).data('img');
		var projectImageArray = projectImageThumb.split(',');
		if (typeof projectVideoLink != 'undefined') {
			$("#selectCarouselNav").hide();
			$("#selectPolaroVideo").append('<iframe id="ratedVideo" width="100%" height="350px" src="https://www.youtube.com/embed/'+projectVideoLink+'?rel=0" frameborder="0" allowfullscreen></iframe>');
		}
		else{
			$("#selectCarouselNav").show();
			var response = '',
			indicator = '';
			for (var i = 0; i < projectImageArray.length; i++) {
				response += '<div class="item"><img class="img-responsive" alt="thumbs image" src="<?php echo file_upload_base_url();?>project/thumb_big/' + projectImageArray[i] + '"></div>';
				indicator += '<li data-target="#selectMyCarousel" data-slide-to="'+i+'"></li>';
			}
			$('#selectHomepageItems').append(response);
			$('#selectIndicators').append(indicator);
			$('.item').first().addClass('active');
			$('.carousel-indicators > li').first().addClass('active');
			$("#selectMyCarousel").carousel({interval: false, ride: false, pause: false});
		}
		$.ajax(
		{
			url: '<?php echo base_url();?>'+'competition/getRating',
			type: 'POST',
			data:
			{
				projectId: projectId,competitionId:competitionId
			},
		})
		.done(function(res)
		{
			var obj = $.parseJSON(res);
			if(obj.length != 0)
			{
				if(obj.yourRating >= 0)
				{
					var yourRating='<span style="line-height:35px;font-family: helveticaneue-light;font-size: 14px;font-weight:bold;">Your Rating : '+obj.yourRating+'</span>';
				}
				else
				{
					var yourRating='';
				}
				$('#ratingInfo').html('<span style="line-height:18px;font-family: helveticaneue-light;font-size: 14px;font-weight:bold;">Project Average Rating : '+obj.avgRating+'</span><br/>'+yourRating+'<br/>');
							$('#ratingInfo').show();
				}
			});
			$("#select_form").attr('action', '<?php echo base_url();?>competition/selectProject/'+projectId);
	});
	$('#myModalSelect').on('hidden.bs.modal', function (e)
	{
		$('#select_form')[0].reset();
		$('#selectHomepageItems').empty();
		$('#selectIndicators').empty();
		$('#ratedVideo').remove();
	})
	</script>
	<script type="text/javascript">
		function selectRatingTo(toVal){
			$('#project_rating_to').empty();
			for (var toVal; toVal < 11 ; toVal++) {
				$('#project_rating_to').append('<option value='+toVal+'>'+toVal+'</option>');
			}
	
		}
	</script>

	<script type="text/javascript">
	$(document).ready(function()
	{
	 	$(document.body).on('click', '.save_sort_project' ,function()
		{	
		    var url = $('#base_url').val();
		    var urlName = '<?php echo current_url();?>';
			var pageName = '<?php echo $this->uri->segment(1);?>';
			var proId = $(this).data('id');
			var competitionId='<?php echo $this->uri->segment(3);?>';
			var juryId='<?php echo $this->uri->segment(4);?>';
			var th=$(this).closest('div[data-id]');
			$.ajax(
			{
				url: url+"competition/saveSortProject",
				data:
				{
					proId:proId,compId:competitionId,juryId:juryId
				},
				type: "POST",
				success:function(html)
				{
					if(html!='')
					{
						var priority = 'success';
						var title    = 'Success';
						var message  = 'Project Shortlisted';
						th.html('<i class="fa fa-floppy-o" id="sort_project" style="color:blue"></i>&nbsp');
						$.toaster({ priority : priority, title : title, message : message });

					}
				}
			})	     
		});
		
	    
     });
	</script>
<?php
$cName = ucwords($competition[0]['name']);
$pageName = ucwords($competition[0]['pageName']);
$cId = $competitionId;
$this->session->set_userdata('breadCrumb','');
$this->session->set_userdata('breadCrumbLink','');
$this->session->set_userdata('breadCrumb','Copmitition,'.$cName);
$this->session->set_userdata('breadCrumbLink','competition/competition_list,competition/'.$pageName);
?>

