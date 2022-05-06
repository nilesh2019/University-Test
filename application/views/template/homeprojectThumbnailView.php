<?php
$i = 1;
foreach($project as $row)
{
	$class='';
	if($thumbnailNum==3){
		if($i == 1){
			$class = 'right5';
			$i++;
		}
		elseif($i == 2){
			$class = 'rightleft5';
			$i++;
		}
		else{
			$class = 'left5';
			$i     = 1;
		}
	}
	elseif($thumbnailNum==4){
		if($i == 1){
			$class = 'right5';
			$i++;
		}
		elseif($i == 2 || $i == 3){
			$class = 'rightleft5';
			$i++;
		}
		else{
			$class = 'left5';
			$i     = 1;
		}
	}elseif($thumbnailNum==6){
		if($i == 1){
			$class = 'right5';
			$i++;
		}
		elseif($i == 2 || $i == 3 || $i== 4 || $i == 5){
			$class = 'rightleft5';
			$i++;
		}
		else{
			$class = 'left5';
			$i     = 1;
		}
	}
	elseif($thumbnailNum==5){
			if($i == 1){
				$class = 'right5 col-md-offset-1';
				$i++;
			}
			elseif($i == 2 || $i == 3 || $i== 4 || $i == 5){
				$class = 'rightleft5';
				if($i==5)
				{
					$i=1;
				}
				else
				{
					$i++;
				}
			}
		}
	if(isset($row['rank']))
	{
		$CI	= & get_instance();
		$CI->load->model('model_basic');
		$rankName = $CI->model_basic->getValue('competition_rank_title','rankTitle'," `competitionId` = '".$competition[0]['id']."' AND   `rankNumber` = '".$row['rank']."'");
		if($rankName && $rankName!='')
		{
			$ribben = '<div id="ribbon1"><div class="inset"></div><div class="main_container"><div class="base"><i class="fa fa-trophy"></i><br>'.$rankName.'</div><div class="left_corner"></div><div class="right_corner"></div></div></div>';
		}
	}
	if($this->uri->segment('1') == 'creative_mind_competitions')
	{

		if(isset($isJury) && $competition[0]['status'] == 2 && isset($rateButton) && $rateButton != '')
		{
			$rate = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-toggle="modal" class="rateit btn btn-primary" style="top:2%;left: 40%;z-index:1;">Rate It</button>';
			$juryIdByDb=$this->uri->segment(4);
			$CI	= & get_instance();
			$CI->load->model('model_basic');
			$isAlreadyRated=$CI->model_basic->getValueArray('creative_competition_project_jury_rating','id',array('creative_competition_id'=>$competition[0]['id'],'juryId'=>$juryIdByDb,'projectId'=>$row['id']));
			if($isAlreadyRated > 0)
			{
				$rate = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-toggle="modal" class="rateit btn btn-primary alreadyRated" style="top:2%;left: 40%;z-index:1;">Rated</button>';
			}
		}
	}
	else
	{

		if(isset($isJury) && $competition[0]['status'] == 2 && isset($rateButton) && $rateButton != '')
		{
			$rate = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-toggle="modal" class="rateit btn btn-primary" style="top:2%;left: 40%;z-index:1;">Rate It</button>';
			$juryIdByDb=$this->uri->segment(4);
			$CI	= & get_instance();
			$CI->load->model('model_basic');
			$isAlreadyRated=$CI->model_basic->getValueArray('project_jury_rating','id',array('competitionId'=>$competition[0]['id'],'juryId'=>$juryIdByDb,'projectId'=>$row['id']));
			if($isAlreadyRated > 0)
			{
				$rate = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-toggle="modal" class="rateit btn btn-primary alreadyRated" style="top:2%;left: 40%;z-index:1;">Rated</button>';
			}
		}
	}
	$removeMyBoard='';
	if(isset($removeBoard) && $removeBoard=='removeBoard')
	{
		$removeMyBoard = '<button class="btn removeFromMyboard" data-id="'.$row['id'].'" title="Remove From Board"><i class="fa fa-trash-o"></i></button>';
	}
?>
<div class="<?php echo $mainClass.' '.$class;?>">
	<?php if(isset($ribben)){ echo $ribben;}?>
	<?php if(isset($rate)){ echo $rate;}?>
	<?php if($this->uri->segment(1) == 'assignment'  && $this->uri->segment(2) == 'assignment_detail')
	{  
		if($row['assignment_status'] == 0)
		{ ?>
		<div class="box side-corner-tag "><p class="ribbon"><span>ASSIGN</span></p> 
	<?php
		}
		if($row['assignment_status'] == 1)
		{ ?>
	<div class="box side-corner-tag "><p class="ribbon"><span>SUBMITTED</span></p> 
	<?php
		}
		if($row['assignment_status'] == 2)
		{ ?>

	<div class="box side-corner-tag "><p class="ribbon"><span>PENDING</span></p> 
		 <?php }
		if($row['assignment_status'] == 3)
		{  ?>
	<div class="box side-corner-tag "><p class="ribbon"><span>ACCEPTED</span></p> 
		 <?php }
		if($row['assignment_status'] == 4)
		{  ?>
	<div class="box side-corner-tag "><p class="ribbon"><span>RE - SUBMITTED</span></p> 
	<?php 	}?>


	

	<?php
	} else {  ?>  
	<div class="box">
	<?php }  ?>
	<?php echo $removeMyBoard;
	if($row['videoLink'] != ''){
	?>
		<iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $row['videoLink'];?>/maxresdefault.jpg" frameborder="0" allowfullscreen>
		</iframe>
	<?php
	} else{
	?>
	<?php
		if(file_exists(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) > 0){
	?>
	<?php if(isset($is_assignment) && $is_assignment !=0)
	{ ?>
	<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $row['image_thumb']?>" alt="image" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>/<?php echo $is_assignment;?>'">
	<?php  } else { ?>
		<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $row['image_thumb']?>" alt="image" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>'">
		<?php }  ?>
	<?php }else{?>
		<img class="img-responsive project-img" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image" >
	<?php }}?>
		<div class="product-overlay">
			<div class="overlay-content">
				<div class="top">
					<div class="proj_name">

					<?php if(isset($is_assignment) && $is_assignment !=0)
					{ ?>
						<a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>/<?php echo $is_assignment;?>" title="<?php echo $row['projectName'];?>">

					<?php	}
					else{
						?>

						<a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>" title="<?php echo $row['projectName'];?>">
						<?php } ?>
							<?php
							if(strlen($row['projectName']) > 40)
							{
								$dot = '..';
							}
							else
							{
								$dot = '';
							}
							$position = 40;
							echo $post2 = substr( $row['projectName'], 0, $position).$dot;
							?>
						</a>
					</div>

					<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px">
						<h5>
							<?php echo $row['categoryName'];  ?>
						</h5>
						<?php 
						if($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0)
						{ ?> 
							<a style="padding-left: 0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" href='<?php echo base_url().'user/userDetail/'.$row['userId']?>'">
							<?php 
							if($this->uri->segment(2) == 'get_competition' && $this->uri->segment(3) !='')
							{  
								if($this->uri->segment(1)=='creative_mind_competitions')
								{
									$get_show_participant_name = $this->db->select('hidename')->from('creative_mind_competition')->where('id',$this->uri->segment('3'))->get()->row_array();
								}
								else
								{
									$get_show_participant_name = $this->db->select('hidename')->from('competitions')->where('id',$this->uri->segment('3'))->get()->row_array();
								}

								if($get_show_participant_name['hidename'] == 1)
								{
									$myStr = ucfirst($row['firstName']).' '.ucfirst($row['lastName']);
									$result = substr($myStr, 0, 22);
									echo  $result;
									if(strlen($myStr) > 22)
									{
										echo '...';
									}
								}

						    }   
							else 
							{ 	
								$myStr = ucfirst($row['firstName']).' '.ucfirst($row['lastName']); 								
								$result = substr($myStr, 0, 22);
								echo  $result;
								if(strlen($myStr) > 22)
								{
									echo '...';
								}
								
							}  ?>
							</a>
							<?php 
						
							if(isset($row['instituteName']) && !empty($row['instituteName']))
							{ ?>							
								<a style="padding-left: 0px; font-size: 11px; font-weight: bold;border-bottom: 0px ; margin-top: -5px; margin-bottom: -6px; display: inline-block; cursor: pointer; color: #414141;" href='<?php echo base_url()?><?php echo $row['PageName']?>'">
									<?php echo /*character_limiter($row['instituteName'], 10);*/ substr($row['instituteName'], 0,10).'...'; ?>
								</a>
							<?php 
							}
						}
						else
						{ ?>
							<a style="margin-top:10px;padding-left: 0px;font-size: 13px; border-bottom: 0px ;font-weight: bold; display: inline-block; cursor: pointer; color: #414141;" ></a>
						<?php }
						?>
						
					</div>
				</div>
				<div class="footer">
					<div class="col-lg-4 col-xs-4" >
						<div class="view" title="Total Views">
							<i class="fa fa-eye">
							</i>&nbsp;
							<span>
								<?php echo $row['view_cnt'];?>
							</span>
						</div>
					</div>
					<!-- showing drop down of likers. -->
					<div class="col-lg-4 col-xs-4">
						<?php
						$totalLikeName = $this->db->select('B.firstName,B.lastName')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array(); 

						/*if($row['userLiked'] == 0){
						*/	?>
							<div class="like dropdown" >
							<div class="like_div" data-name="0" data-id="<?php if(!empty($row['id'])){ echo $row['id'];}else
							{ echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>" >
								<i class="fa fa-thumbs-o-up" id="like_div_id">
								</i>&nbsp;
								<span class="like_span">
									<?php echo count($totalLikeName); ?>
								</span>
								</div>
								<!-- <ul class="dropdown-menu">
								<?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){?>
								  <li><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></li>							       
								  <?php }   }  ?>
								</ul> -->
							</div>
							<?php/*
						}
						else
						{*/						   
							?>	
							<!-- <div class="like dropdown " title="">
								<span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up "></i></span>
							<span class="like_span" >
								<?php echo count($totalLikeName); ?>
							</span>	
							      <ul class="dropdown-menu">							      
							      <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){?>
							        <li><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></li>							       
							        <?php }   }  ?>
							      </ul>
							      </div>	 -->
							<?php
						/* }*/
						 ?>

					</div>				
					<div class="col-lg-4 col-xs-4">
						<div class="photo" title="Total Project Images">
							<?php
							if($this->session->userdata('front_user_id') == $row['userId'] && $this->uri->segment(1) !='all_project')
							{
								if(isset($editProject)){
									if($row['assignmentId'] == 0 && $row['competitionId'] == 0 )
								{
								?>
									<span onclick="window.location='<?php echo base_url();?>project/edit_project/<?php echo $row['id'];?>'" style="cursor: pointer;" title="Edit Project"><i class="fa fa-pencil-square-o" ></i>&nbsp;</span>


								<?php }  }
							}else{
							$CI         =& get_instance();
							$CI->load->model('model_basic');
							$imageCount = $CI->model_basic->getCount('user_project_image','project_id',$row['id']);
							//echo $imageCount;die;
							?>
							<i class="fa fa-picture-o"></i>&nbsp;
							<span>
								<?php echo $imageCount;?>
							</span>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>


