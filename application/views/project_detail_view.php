<?php $this->load->view('template/header');?>
<link href="<?php echo base_url()?>assets/css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/owl.theme.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/style_crowj.css"/>
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css"/>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.mCustomScrollbar.css"/> -->
<style>
	<?php if($this->uri->segment(1) !='projectDetail'){ ?>
		#myMainNav{
			display: none;
		}
		#myMainFooter{
			display: none;
		}
	<?php } ?>
	.disable_comment{
		pointer-events: none;
		opacity: 0.6;
	}
	.image_solid{
		float:left;
		margin: 5px;
	}
	#liked_image{
		cursor: default;
	}
	.navbar {
		background-color:rgb(0,0,0);
	}
	#owl-slider1 .owl-item{
		padding-left: 30px;
		padding-right: 25px;
		padding-top: 15px;
		width: 307px;
	}
	.owl-buttons {
		top: -46px;
	}
</style>
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
					<li>
						<a href="<?php echo base_url();?>user/userDetail/<?php echo $project['userId'];?>"><?php if($project['firstName'] !=''){ echo $project['firstName'];}?>&nbsp;<?php if($project['lastName'] !=''){ echo $project['lastName'];}?>'s Portfolio</a>
					</li>
					<li class="active">
						<?php echo ucwords($project['projectName']);?>
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="row project-details">
		<div class="col-lg-9 left_side project-left">
			<div class="clearfix"></div>
			<div class="showcase">
				<div class="project_lightbox">
					<?php if($project['withoutCover'] == 1){
						if($project['categoryId'] != 4 && $project['categoryId'] != 5 && $project['categoryId'] != 6){ ?>
							<div class="img_box">
								<a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">
									<?php if(file_exists(file_upload_s3_path().'project/thumb_big/'.$project['image_thumb']) && filesize(file_upload_s3_path().'project/thumb_big/'.$project['image_thumb']) > 0){ ?>
										<img class="img-full" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $project['image_thumb']?>" alt="big thumb"/>
										<?php
									}else{ ?>
										<img class="img-full" src="<?php echo base_url();?>assets/images/file_not_found.png" alt="big thumb"/>
										<?php 
									} ?>
								</a>
								<div class="over">
									<div class="image_solid image_strip<?php echo $project['image_id'];?>">
										<?php if($this->session->userdata('front_user_id') != ''){
											$CI       =& get_instance();
											$CI->load->model('project_model');
											$userLike = $CI->modelbasic->getValue('project_image_rating_like','id',array('user_id'=>$this->session->userdata('front_user_id'),'project_image_id'=>$project['image_id'],'image_like'=>1));
										}else{
											$userLike = '';
										}
										$like = $CI->modelbasic->count_all_only('project_image_rating_like',array('project_image_id'=>$project['image_id'],'image_like'=>1));
										if($userLike ==''){ ?>
											<a class="project_image_like" href="javascript:void(0);" data-id="<?php echo $project['image_id'];?>" data-name="0" data-like="<?php echo $like;?>" data-projectid="<?php echo $project['id'];?>">
												<span>
													<i class="fa fa-thumbs-o-up">
													</i><?php echo $like;?>
												</span>
											</a>
											<?php 
										}else{ ?>
											<a id="liked_image" class="project_image_like">
												<span>
													<i class="fa fa-thumbs-up">
													</i><?php echo $like;?>
												</span>
											</a>
											<?php 
										}?>
									</div>
									<a href="#">
										<span>
											<?php if($this->session->userdata('front_user_id') != ''){
												if($this->session->userdata('front_user_id') == $project['userId']){
													$rating = $this->modelbasic->getValue('project_image_rating_like','AVG(image_rating)',array('project_image_id'=>$project['image_id']));
													if($rating !='' && $rating > 0){
														$disable = 'disabled="disabled"';
														$rate    = $rating;
													}else{
														$disable = '';
														$rate    = 0;
													}
												}else{
													$image_rating = $this->modelbasic->getValue('project_image_rating_like','image_rating',array('project_image_id'=>$project['image_id'],'user_id'=>$this->session->userdata('front_user_id')));
													if($image_rating !=''){
														$disable = 'disabled="disabled"';
														$rate    = $image_rating;
													}else{
														$disable = '';
														$rate    = 0;
													}
												}
											}else{
												$rating = $this->modelbasic->getValue('project_image_rating_like','AVG(image_rating)',array('project_image_id'=>$project['image_id']));
												if(!empty($rating)){
													$disable = 'disabled="disabled"';
													$rate    = $rating;
												}else{
													$disable = '';
													$rate    = 0;
												}
											} ?>
											<input id="project_image<?php echo $project['image_id'];?>" value="<?php echo $rate?>" <?php echo $disable;?> type="number" class="rating" min=0 max=5 step=0.5 data-size="xs">
										</span>
									</a>
								</div>
							</div>
							<?php
						}
						if($project['categoryId'] != 4 && $project['categoryId'] != 5 && $project['categoryId'] != 6){
							foreach($project['projectImg'] as $x=>$img){
								$ext = pathinfo($img, PATHINFO_EXTENSION);
								if($img != $project['image_thumb'] && $ext != 'zip'){
									$image_id = $project['projectImgId'][$x];
									if($this->session->userdata('front_user_id') != ''){
										if($this->session->userdata('front_user_id') == $project['userId']){
											$rating = $this->modelbasic->getValue('project_image_rating_like','AVG(image_rating)',array('project_image_id'=>$image_id));
											$title  = 'title="Average rating"';
											if($rating !=''){
												$disable = 'disabled="disabled"';
												$rate    = $rating;
											}else{
												$disable = '';
												$rate    = 0;
											}
										}else{
											$image_rating = $this->modelbasic->getValue('project_image_rating_like','image_rating',array('project_image_id'=>$image_id,'user_id'=>$this->session->userdata('front_user_id')));
											$title  = 'title="Your rating"';
											if($image_rating !=''){
												$disable = 'disabled="disabled"';
												$rate    = $image_rating;
											}else{
												$disable = '';
												$rate    = 0;
											}
										}
									}else{
										$rating = $this->modelbasic->getValue('project_image_rating_like','AVG(image_rating)',array('project_image_id'=>$image_id));
										$title  = 'title="Average rating"';
										if(!empty($rating)){
											$disable = 'disabled="disabled"';
											$rate    = $rating;
										}else{
											$disable = '';
											$rate    = 0;
										}
									} ?>
									<div class="img_box">
										<a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">
											<?php if(file_exists(file_upload_s3_path().'project/thumb_big/'.$img) && filesize(file_upload_s3_path().'project/thumb_big/'.$img) > 0){ ?>
												<img class="img-full" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $img?>" alt="big thumb"/>
												<?php
											}else{ ?>
												<img class="img-full" src="<?php echo base_url();?>assets/images/file_not_found.png" alt="big thumb"/>
												<?php 
											} ?>
										</a>
										<div class="over">
											<div class="image_solid image_strip<?php echo $image_id;?>">
												<?php $like = $this->modelbasic->count_all_only('project_image_rating_like',array('project_image_id'=>$image_id,'image_like'=>1));
												if($this->session->userdata('front_user_id') != ''){
													$userLike = $this->modelbasic->getValue('project_image_rating_like','id',array('user_id'=>$this->session->userdata('front_user_id'),'project_image_id'=>$image_id,'image_like'=>1));
												}else{
													$userLike = '';
												}
												if($userLike !='' && $userLike > 0){ ?>
													<a class="project_image_like" href="javascript:void(0);" data-id="<?php echo $image_id;?>" data-name="0" data-like="0" data-projectid="<?php echo $project['id'];?>">
														<span>
															<i class="fa fa-thumbs-o-up"></i><?php echo $like;?>
														</span>
													</a>
													<?php 
												}else{ ?>
													<a id="liked_image" class="project_image_like">
														<span>
															<i class="fa fa-thumbs-up"></i><?php echo $like;?>
														</span>
													</a>
													<?php 
												}?>
											</div>
											<a href="#">
												<span>
													<input id="project_image<?php echo $image_id;?>" value="<?php echo $rate?>" <?php echo $disable;?> type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" <?php echo $title;?>>
												</span>
											</a>
										</div>
									</div>
									<?php
								}elseif($img != $project['image_thumb'] && $ext == 'zip'){
									$isZip[] = $img;
								}
							}
						} 
					} ?>
					<?php if($project['videoLink'] != ''){ ?>
						<iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?php echo $project['videoLink'];?>?rel=0" frameborder="0" allowfullscreen></iframe>
						<?php
					} ?>
					<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" >
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner" role="listbox">
										<?php if($project['categoryId'] != 4 && $project['categoryId'] != 5 && $project['categoryId'] != 6){
											$i = 1;
											foreach($project['projectImg'] as $img){
												$img_count = count($project['projectImg']);
												$ext       = pathinfo($img, PATHINFO_EXTENSION);
												if($ext != 'zip'){
													if($i == 1){
														$class = 'active';
													}else{
														$class = '';
													} ?>
													<div class="item <?php echo $class;?>">
														<?php if(file_exists(file_upload_s3_path().'project/thumb_big/'.$img) && filesize(file_upload_s3_path().'project/thumb_big/'.$img) > 0){ ?>
															<img class="img-responsive" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $img?>" alt="big thumb"/>
															<?php
														}else{ ?>
															<img class="img-responsive img-full" src="<?php echo base_url();?>assets/images/file_not_found.png" alt="big thumb"/>
															<?php 
														} ?>
														<div class="carousel-caption">
															<span class="img_counter">
																Project Image <?php echo $i;?> of <?php echo $img_count;?>
															</span>
														</div>
													</div>
													<?php 
													$i++;
												}
											}
										}?>
									</div>
									<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true">
										</span>
										<span class="sr-only">
											Previous
										</span>
									</a>
									<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true">
										</span>
										<span class="sr-only">
											Next
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="all_comments">
				<div id="view_comments">
					<?php if(!empty($project) && ($project['socialFeatures'] == 1)){ ?>
						<div class="comments">
							<div class="panel panel-default">
								<div id="com_cnt_h1" class="panel-heading">
									Comments(<?php	echo $project['comment_cnt'];?>)
								</div>
								<input type="hidden" id="com_cnt" value="<?php	echo $project['comment_cnt'];?>"/>
								<?php if($is_assignment==0) {
									if($this->session->userdata('front_user_id') != '' && $this->uri->segment('3') !=1){
										$login_user = $this->modelbasic->getValues('users','firstName,lastName,email',array('id'=>$this->session->userdata('front_user_id')),'row_array'); ?>
										<div class="panel-body">
											<input id="name" name="name" type="hidden" value="<?php if(!empty($login_user)) { echo ucwords($login_user['firstName'].' '.$login_user['lastName']); }?>">
											<input type="hidden" id="email" name="email" value="<?php if(!empty($login_user)) { echo $login_user['email']; }?>" >
											<label>
												My comment
											</label>
											<textarea name="comment" id="comment" required placeholder="Add Your Comment"></textarea>
											<button class="btn btn-default" id="post_comment">
												Post Comment
											</button>
										</div>
										<?php 
									}
								} ?>
								<ul class="list-group">
									<?php if(!empty($comment)){
										foreach($comment as $row){
											if($this->session->userdata('front_user_id') == $project['userId'] || $row['status'] == 1){ ?>
												<li class="list-group-item">
													<div class="media">
														<div class="media-left">
															<?php if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0) { ?>
																<img class="media-object img-circle" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileImage']?>" alt="profile Image" style="height: auto!important;"><?php
															}else{?>
																<img class="media-object img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="profile Image">
																<?php
															} ?>
														</div>
														<div class="media-body">
															<h4 class="media-heading">
															<a href="<?php echo base_url()?>user/userDetail/<?php echo $row['userId'];?>">
																&nbsp;<?php echo $row['name'];?>
															</a>
															<span class="DatenTime">
																<?php echo date("d M Y, H:i a",strtotime($row['created']));?>
															</span>
															</h4>
															<div class="row">
																<div class="col-md-10">
																	<p>
																		<?php echo $row['comment'];?>
																	</p>
																</div>
																<?php if(!isset($is_assignment)){?>
																	<div class="col-md-2" style="margin-top: -9px">
																		<?php if($this->session->userdata('front_user_id') == $project['userId']){
																			if($row['status'] == 1){?>
																				<button  class="state_change btn-success" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" data-proid="<?php echo $row['projectId'];?>" type="button">
																					<i class="glyphicon glyphicon-ok"></i>
																				</button>
																				<?php
																			}else{?>
																				<button class="state_change btn-danger" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" data-proid="<?php echo $row['projectId'];?>" type="button">
																					<i class="glyphicon glyphicon-remove"></i>
																				</button>
																				<?php
																			}
																		}?>
																	</div>
																	<?php 
																} ?>
															</div>
														</div>
													</div>
												</li>
												<?php
											}
										}
									} ?>
								</ul>
							</div>
						</div>
						<?php
					} ?>
				</div>
			</div>
			<?php $cat_project =$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName,users.id as userId',array('user_project_image.cover_pic'=>1,'project_master.id !='=>$project['id'],'project_master.categoryId'=>$project['categoryId'],'project_master.status'=>1),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.created','DESC'),6);
			if(!empty($cat_project)){ ?>
				<div class="similar_projects">
					<div class="panel panel-default">
						<div class="panel-heading">
							Similar Projects
						</div>
						<div class="panel-body">
							<div class="Slider"  id="demo">
								<div id="owl-demo" class="owl-carousel">
									<?php
									$data = array();
									$data['project'] = $cat_project;
									$data['thumbnailNum'] = 6;
									$data['mainClass'] = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
									$this->load->view('template/projectThumbnailView',$data);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}?>
		</div>
		<div class="col-lg-3 right_side r-border" style="padding:0">
			<div class="project-right">
				<div class="freelancer_info">
					<div class="media">
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?php echo base_url();?>user/userDetail/<?php echo $project['userId'];?>">
									<?php echo $project['firstName']?>  <?php echo $project['lastName']?>
								</a>
							</h4>
							<?php if(isset($project['instituteName'])) { ?>	
								Institute : <a target="_blank" href="<?php echo base_url().$project["pageName"] ?>"><?php echo $project['instituteName']?></a> <?php  
							} ?>
							<ul>
								<?php if(isset($project['profession']) && $project['profession'] != ''){
									$atr = $project['profession'];
									if(strlen($atr) > 16){
										$dot = '..';
									}else{
										$dot = '';
									}
									$position = 16;?>
									<li>
										<?php	echo substr($atr, 0, $position).$dot;?>
									</li>
									<?php
								}?>
								<li>
									<?php if(!empty($project['city'])){
										echo ucfirst($project['city']).',';
									}
									echo ucfirst($project['country']);?>
								</li>
							</ul>
						</div>
						<div class="media-left">
							<?php if($this->session->userdata('front_user_id') == $project['userId']){?>
								<a href="<?php echo base_url();?>profile">
								<?php 
							}else {?>
								<a href="<?php echo base_url();?>user/userDetail/<?php echo $project['userId'];?>">
								<?php 
							} ?>
							<?php if(file_exists(file_upload_s3_path().'users/thumbs/'.$project['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$project['profileImage']) > 0){ ?>
								<img class="media-object" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $project['profileImage']?>" alt="profile Image" style="height: auto!important;">
								<?php
							}else{ ?>
								<img class="media-object" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="profile Image">
								<?php
							} ?>
							</a>
						</div>
						<?php if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id') != $project['userId']){
							$following=$this->modelbasic->getValue('user_follow','created',array('userId'=>$this->session->userdata('front_user_id'),'followingUser'=>$project['userId']));
							if($following !=''){ ?>
								<form class="form-block" action="<?php echo base_url();?>project/unfollow_user/<?php if(!empty($project)){echo $project['id'];}?>/<?php if(!empty($project)){ echo $project['userId'];}?>" method="POST">
									<button class="fallow_unfallow btn btn-default btn-sm ">
										<i class="fa fa-check"></i>&nbsp;Following
									</button>
								</form>
								<?php
							}else{?>
								<form class="form-block" action="<?php echo base_url();?>project/follow_user/<?php if(!empty($project)){echo $project['id'];}?>/<?php if(!empty($project)){echo $project['userId'];}?>" method="POST">
									<button class="fallow_unfallow btn btn_blue btn-sm ">
										Follow
									</button>
								</form>
								<?php
							}
						} ?>
						</div>
						<?php if($project['file_link'] != ''){ ?>
							<p class="title" style="padding-bottom: 0px;font-weight: bold">
								Work/Project Files Link:
							</p>
							<p>
								<a href="<?php echo $project['file_link'];?>" target="_blank"><?php echo $project['file_link'];?></a>
							</p>
							<?php
						}?>
						<?php if($project['isTeam'] == 1){ ?>
							<p class="title" style="padding-bottom: 0px;font-weight: bold">
								Team Details:
							</p>
							<p>
								<?php echo $project['team_member'];?>
							</p>
							<?php
						}?>
						<?php if($project['basicInfo'] != ''){ ?>
							<p class="title" style="padding-bottom: 0px;font-weight: bold">
								Project Description:
							</p>
							<p>
								<?php echo $project['basicInfo'];?>
							</p>
							<?php
						}?>
						<?php if($project['thought'] != ''){ ?>
							<p class="title" style="padding-bottom: 0px;font-weight: bold">
								Thought Process:
							</p>
							<p>
								<?php echo $project['thought'];?>
							</p>
							<?php
						}?>
						<?php if($project['keyword'] != ''){ ?>
							<p class="title" style="padding-bottom: 0px;font-weight: bold">
								Keywords:
							</p>
							<p>
								<?php echo $project['keyword'];?>
							</p>
							<?php
						}?>
					</div>
					<div class="title_main">
						<div class="dropdown pull-right">
							<img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url();?>assets/images/shr.png"  style="cursor: pointer;">
							<ul class="dropdown-menu">
								<?php if($project['socialFeatures']==1  && $project['projectstatus']==1){ ?>
									<li>
										<a href="javascript:void(0);" onclick="return sharelink(1);" >
											Facebook
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" onclick="return sharelink(2);" >
											Twitter
										</a>
									</li>
									<?php 
								} ?>
							</ul>
						</div>
						<strong><?php echo $project['projectName']?></strong>
						<p><?php echo $project['categoryName']?></p>
						<a href="javascript:void(0)">
							<span>
								<i class="fa fa-eye"></i>&nbsp;
								<?php if(!empty($project['view_cnt'])){
									echo $project['view_cnt'];
								}else{
									echo 0;
								}?>
							</span>
						</a>
						<?php if($project['userLiked']==0){ ?>
							<a href="javascript:void(0)" class="like like_div"  data-name="0" data-id="<?php if(!empty($project)){echo $project['id'];}?>" data-like="<?php if(!empty($project['like_cnt'])){ echo $project['like_cnt']; }else{ echo 0;}?>">
								<i class="fa fa-thumbs-o-up" id="like_div_id"></i>&nbsp;
								<span class="like_span">
									<?php
									if(!empty($project['like_cnt'])){
										echo $project['like_cnt'];
									}else{
										echo 0;
									}?>
								</span>
							</a>
							<?php 
						}else{ ?>
							<a class="like">
								<i class="fa fa-thumbs-up"></i>&nbsp;
								<span class="like_span">
									<?php echo $project['like_cnt']; ?>
								</span>
							</a>
							<?php 
						}?>
						<a href="javascript:void(0)">
							<span>
								<i class="fa fa-comment" aria-hidden="true" id="view_comments"></i>
								<?php if(!empty($project['comment_cnt'])){
									echo $project['comment_cnt'];
								}else{
									echo 0;
								}?>
							</span>
						</a>
						<?php 
						$rate = 0;
						if($this->session->userdata('front_user_id') != '' && $project['userId'] == $this->session->userdata('front_user_id')){
							$rate_cmt = $this->modelbasic->getValue('project_rating','AVG(rating)',array('projectId'=>$project['id']));
							$user_rate_present = $this->modelbasic->getValue('project_rating','id',array('projectId'=>$project['id'],'userId'=>$this->session->userdata('front_user_id')));
							if($rate_cmt !=''){
								$rate = $rate_cmt;
							}
							$disable = 'disabled="disabled"';
						}elseif($this->session->userdata('front_user_id') != '' && $project['userId'] != $this->session->userdata('front_user_id')){
							$user_rate_present = $this->modelbasic->getValue('project_rating','id',array('projectId'=>$project['id'],'userId'=>$this->session->userdata('front_user_id')));
							$rate_cmt = $this->modelbasic->getValue('project_rating','AVG(rating)',array('projectId'=>$project['id']));
							if($rate_cmt !=''){
								$rate    = $rate_cmt;
								$disable = '';
							}else{
								$disable = '';
							}
							if($user_rate_present !='' && $user_rate_present > 0){
								$disable = 'disabled="disabled"';
							}else{
								$disable = '';
							}
						}else{
							$rate_cmt = $this->modelbasic->getValue('project_rating','AVG(rating)',array('projectId'=>$project['id']));
							if($rate_cmt !=''){
								$rate = $rate_cmt;
							}
							$disable = 'disabled="disabled"';
						} ?>
						<a href="javascript:void(0)">
							<span>
								<input id="project_rate" value="<?php echo $rate;?>" <?php echo $disable;?>   type="number" data-id="<?php if(!empty($project)){echo $project['id'];}?>" class="rating" min=0 max=5 step=0.5 data-size="xs">
							</span>
						</a>
						<span class="DatenTime">
							Added on : <?php echo date('d F Y',strtotime($project['created'])); ?>
						</span>
					</div>
					<div id="appreciateWork" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">
									&times;
									</button>
									<h4 class="modal-title">
										Write Your Appreciation
									</h4>
								</div>
								<form method="post" action="<?php echo base_url()?>appreciatework/save_appreciation/<?php if(!empty($project)) {echo $project['id'];}?>" id="appriciate-form">
									<div class="modal-body">
										<div class="form-group">
											<textarea class="form-control" id="appreciateText" name="appreciateText"></textarea>
										</div>
									</div>
									<input type="hidden" name="AppreciatedUserId" value="<?php echo $project['userId'];?>" />
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn btn-success">
											Post
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="project_detail">
						<?php if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id') != $project['userId']){
							$existInMyboard = $this->modelbasic->getValue('user_myboard','id',array('myboardUser'=>$this->session->userdata('front_user_id'),'projectId'=>$project['id']));
							$existInAppriciation = $this->modelbasic->getValue('project_appreciation','id',array('appreciateByUserId'=>$this->session->userdata('front_user_id'),'projectId'=>$project['id']));
							if($existInAppriciation ==''){ ?>
								<button class="btn_blue btn" data-toggle="modal" data-target="#appreciateWork">
									Appreciate Work
								</button>
								<?php
							}else{ ?>
								<button class="btn_blue btn">
									Appreciated
								</button>
								<?php
							}
							if($existInMyboard ==''){ ?>
								<button id="myboard_btn" data-id="<?php echo $project['id'];?>" class="btn_blue btn saveOnMyboard" style="position: relative !important;float: none;">
									Save on Myboard
								</button>
								<?php
							}else{ ?>
								<button id="myboard_btn" data-id="<?php echo $project['id'];?>" class="btn_blue btn removeFromMyboard" style="position: relative !important;float: none;">
									Remove From Myboard
								</button>
								<?php
							}
						}?>
					</div>
					<?php if($assignment_id != 0){
						$teacher_id = $this->modelbasic->getValue('assignment','teacher_id',array('id'=>$assignment_id));
						if($teacher_id == $this->session->userdata('front_user_id')){ ?>
							<div id="assignment_comment_accept" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">
											&times;
											</button>
											<h4 class="modal-title">
												Write Your Assignment Accepted Comment
											</h4>
										</div>
										<form method="post" action="<?php echo base_url();?>assignment/assignment_approval/<?php echo $assignment_id;?>/3/<?php echo $project['userId'];?>" id="addAcceptedCommentForm">
											<div class="modal-body">
												<div class="form-group">
													<textarea class="form-control" id="assignmentText" name="assignmentText"></textarea>
												</div>
											</div>
											<input type="hidden" name="assignmentCommentByUserId" value="<?php echo $this->session->userdata('front_user_id'); ?>" />
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-success"  onclick="return addAcceptedComment();" id="addAcceptedCommentBtn">
													Post
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div id="assignment_comment_pending" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">
											&times;
											</button>
											<h4 class="modal-title">
												Write Your Assignment Pending Comment
											</h4>
										</div>
										<form method="post" action="<?php echo base_url();?>assignment/assignment_approval/<?php echo $assignment_id;?>/2/<?php echo $project['userId'];?>"  id="addPendingCommentForm">
											<div class="modal-body">
												<div class="form-group">
													<textarea class="form-control" required id="assignmentText" name="assignmentText"></textarea>
												</div>
											</div>
											<input type="hidden" name="assignmentCommentByUserId" value="<?php echo $this->session->userdata('front_user_id'); ?>" />
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-success" onclick="return addPendingComment();" id="addPendingCommentBtn">
													Post
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="assign-btn">
								<?php if($is_assignment != 0) {  ?>
									<button class="btn btn-primary" data-toggle="modal" data-target="#assignment_comment_accept" >Accept Assignment</button>
									<button class="btn btn-primary" data-toggle="modal" data-target="#assignment_comment_pending" >Need More Work</button>
									<?php 
								}  ?>
							</div>
							<?php 
						}  
					}  ?>
					<?php
					$data=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName,users.id as userId',array('user_project_image.cover_pic'=>1,'project_master.id !='=>$project['id'],'project_master.status'=>1,'project_master.userId'=>$project['userId']),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.created','DESC'),3);
					if(!empty($data)){ ?>
						<div class="project_slider">
							<h4 class="title">
								<?php echo $project['firstName']?>'s Other  Projects:
							</h4>
							<div class="Slider">
								<div id="owl-slider1" class="owl-carousel">
									<?php
										$data1 = array();
										$data1['project'] = $data;
										$data1['thumbnailNum'] = 0;
										$data1['mainClass'] = '';
										$this->load->view('template/projectThumbnailView',$data1);
									?>
								</div>
							</div>
						</div>
						<?php
					} ?>
					<div class="copyright_info">
						<h4 class="title">
							Copyright Information:
						</h4>
						<?php if(isset($project['copyright']) && $project['copyright'] == 0) { ?>
							<h4>
								Creative Commons (CC) Licence
							</h4>
							<?php
						}else{?>
							<h4>
								Requires Permission
							</h4>
							<p>
								No modifications, no commercial use
							</p>
							<?php
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- </div> -->
<?php $this->load->view('template/footer');?>
<script>
	function addAcceptedComment(){
		$('#addAcceptedCommentForm').submit();
		$('#addAcceptedCommentBtn').attr('disabled', 'true');
		return false;
	}
	function addPendingComment(){
		$('#addPendingCommentForm').submit();
		$('#addPendingCommentBtn').attr('disabled', 'true');
		return false;
	}
</script>
<script src="<?php echo base_url()?>assets/js/owl.carousel.js"></script>
<script>
	$(document).ready(function(){
		var owl1 = $("#owl-slider1");
		owl1.owlCarousel({
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
	$(document).ready(function() {
		$("#owl-demo").owlCarousel({
			autoPlay: 3000,
			items : 4,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [979,3]
		});
	});
</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/js/star-rating.js" type="text/javascript"></script>
<?php if($this->session->userdata('front_user_id')!=''){ ?>
	<script>
		$(document.body).on('click', '.project_image_like' ,function(){
			var url = $('#base_url').val();
			var image_id = $(this).data('id');
			var project_id = $(this).data('projectid');
			var pageName = '<?php echo $this->uri->segment(1);?>';
			var urlName = '<?php echo current_url();?>';
			if(pageName==''){
				pageName = 'Home';
			}
			var a = $(this).data('like');
			var cal = $(this).data('name');
			var th = $(this);
			if(cal==0){
				th.attr("data-name","1");
				$.ajax({
					url: url+"project/image_rating",
					type: "POST",
					data:{
						image_id:image_id,proId:project_id,pageName:pageName,urlName:urlName,like:1
					},
					success:function(html){
						if(html=='yes'){
							$('.image_strip'+image_id).load(urlName+' .image_strip'+image_id);
						}else if(html=='no'){
							th.attr("data-name","0");
						}
					}
				});
			}
		});
	</script>
	<?php
}else{ ?>
	<script>
		$(document.body).on('click', '.project_image_like' ,function(){
			var url = $('#base_url').val();
			var image_id = $(this).data('id');
			var pro_id = $(this).data('projectid');
			var pageName = '<?php echo $this->uri->segment(1);?>';
			var urlName = '<?php echo current_url();?>';
			if(pageName==''){
				pageName = 'Home';
			}
			$.ajax({
				url: url+'home/remember_action',
				data: {pro_id:pro_id,image_id:image_id,urlName:urlName,pageName:pageName},
				type: "POST",
				success:function(html){
					if(html=='done'){
						window.location='<?php echo base_url();?>hauth/googleLogin';
					}
				}
			});
		});
	</script>
	<?php 
} ?>
<script type="text/javascript">
	$(function(){
		$('.state_change').click(function(){
			var cid = $(this).data('id');
			var proid = $(this).data('proid');
			var status = $(this).data('status');
			var cnt = parseInt($('#com_cnt').val());
			var url = $('#base_url').val();
			if(status==0){
				var status = 1; cnt++; $(this).removeClass('btn-danger').addClass("btn-success");
				$(this).data('status',1);
				$(this).html('<i class="glyphicon glyphicon-ok">');
			}else{
				var status = 0; cnt--;$(this).removeClass('btn-success').addClass("btn-danger");
				$(this).data('status',1); $(this).data('status',0);
				$(this).html('<i class="glyphicon glyphicon-remove">');
			}
			$('#com_cnt_h1').text('Comments ('+cnt+')');
			$('#com_cnt').val(cnt);
			$.ajax({
				url: url+"project/comment_status",
				data:{
					cid:cid,proid:proid,status:status
				},
				type: "POST",
				success:function(html){
				}
			})
		})
		<?php if($project['userId']==$this->session->userdata('front_user_id')){ ?>
			$("#project_rate").rating("refresh",{disabled:true});
			<?php
		} ?>
		$("#project_rate").on("rating.change", function(){
			var proId = $('#project_rate').data('id');
			var rating = $("input#project_rate").val();
			var url = $("#base_url").val();
			var pageName = '<?php echo $this->uri->segment(1);?>';
			var urlName = '<?php echo current_url();?>';
			if(pageName==''){
				pageName = 'Home';
			}
			$("input#project_rate").rating("refresh",{
				disabled:true
			});
			$.ajax({
				url: url+"project/project_rating",
				data:{
					proId:proId,rating:rating,pageName:pageName,urlName:urlName
				},
				type: "POST",
				success:function(html){
				}
			})
		});
		<?php if(!empty($project['projectImg'])){
			foreach($project['projectImg'] as $x=>$img){
				$ext = pathinfo($img, PATHINFO_EXTENSION);
				if($ext !='zip'){
					$image_id = $project['projectImgId'][$x];
					if($project['userId']==$this->session->userdata('front_user_id')){
						echo '$("input#project_image'.$image_id.'").rating("refresh",{ disabled:true });';
					}
					echo '$("input#project_image'.$image_id.'").on("rating.change", function() {
						var image_id = '.$image_id.';
						var proId = '.$project['id'].';
						var rating = $("input#project_image'.$image_id.'").val();
						var pageName = "'.$this->uri->segment(1).'";
						var urlName = "'.current_url().'";
						if(pageName==""){
							pageName = "Home";
						}
						var url = $("#base_url").val();
						$("input#project_image'.$image_id.'").rating("refresh",{
							disabled:true
						});
						$.ajax({
							url: url+"project/image_rating",
							data: {image_id:image_id,proId:proId,rating:rating,pageName:pageName,urlName:urlName},
							type: "POST",
							success:function(html){
							}
						})
					});';
				}
			}
		}?>
	})
</script>
<script>
	$('#post_comment').on('click',function(e){
		var postUrl = "<?php echo base_url();?>project/add_comment/<?php if(!empty($project)) {echo $project['id'];}?>/<?php if($this->session->userdata('front_user_id')!='') {echo $this->session->userdata('front_user_id');}?>";
		var email = $('#email').val();
		var name = $('#name').val();
		var comment = $('#comment').val();
		var pageName = '<?php echo $this->uri->segment(1);?>';
		var urlName = '<?php echo current_url();?>';
		if(pageName==''){
			pageName = 'Home';
		}
		$('#all_comments').addClass('disable_comment');
		$.ajax({
			url: postUrl,
			data:{
				email:email,name:name,comment:comment,pageName:pageName,urlName:urlName
			},
			type: "POST",
			success:function(html){
				if(html=='true'){
					$('#all_comments').load("<?php echo current_url();?> #all_comments");
					var priority = 'success';
					var title    = 'Success';
					var message  = 'Comment Posted successfully.';
					$.toaster({ priority : priority, title : title, message : message });
					$('#all_comments').removeClass('disable_comment');
				}else{
					$('#all_comments').load("<?php echo current_url();?> #all_comments");
					var priority = 'danger';
					var title    = 'Error';
					var message  = 'Comment Post failed.';
					$.toaster({ priority : priority, title : title, message : message });
					$('#all_comments').removeClass('disable_comment');
				}
			}
		})
	});
	$(document).ready(function(){
		$(document.body).on('click', '.saveOnMyboard' ,function(){
			var proId = $(this).data('id');
			var url = $("#base_url").val();
			$.ajax({
				url: url+"myboard/addToMyboard",
				data:{
					proId:proId
				},
				type: "POST",
				success:function(html){
					if(html!=''){
						$('#myboard_btn').text('Remove From Myboard');
						$('#myboard_btn').removeClass('saveOnMyboard').addClass('removeFromMyboard');
						var priority = 'success';
						var title    = 'Success';
						var message  = 'Project Saved On Myboard';
						$.toaster({ priority : priority, title : title, message : message });
					}
				}
			})
		});
		$(document.body).on('click', '.removeFromMyboard' ,function(){
			var proId = $(this).data('id');
			var url = $("#base_url").val();
			$.ajax({
				url: url+"myboard/removeFromMyboard",
				data:{
					proId:proId
				},
				type: "POST",
				success:function(html){
					if(html!=''){
						$('#myboard_btn').text('Save On Myboard');
						$('#myboard_btn').removeClass('removeFromMyboard').addClass('saveOnMyboard');
						var priority = 'success';
						var title    = 'Success';
						var message  = 'Project Removed From Myboard';
						$.toaster({ priority : priority, title : title, message : message });
					}
				}
			})
		});
	});
</script>
<style>
	.glyphicon-minus-sign{
		display: none !important;
	}
	.star-rating.rating-active{
		display: inline-block !important;
	}
	.star-rating.rating-disabled{
		display: inline-block !important;
	}
</style>
<script>
	$("#overAllRating").rating("refresh",{disabled:true});
</script>
<script>
	function sharelink(social){
		if(social==1){
			window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url();?>', '_blank');
		}else{
			window.open('https://twitter.com/share?url=<?php echo current_url();?>', '_blank');
		}
	}
</script>
<script src="<?php echo base_url();?>assets/script/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap_framework.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap-select.min.js"></script>
<script>
	$(document).ready(function() {
		$('#appriciate-form').formValidation({
			message: 'This value is not valid',
			framework: 'bootstrap',
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				appreciateText: {
					verbose: false,
					trigger: 'blur',
					message: 'The Description is not valid',
					validators:	{
						notEmpty:{
							message: 'The Appreciate Text is required and can\'t be empty'
						}
					}
				}
			}
		})
	});
</script>
<script>
	$(document).ready(function(){
		$(document).on("contextmenu",function(e){
			alert('Right click disabled.');
			return false;
		});
	});
</script>
