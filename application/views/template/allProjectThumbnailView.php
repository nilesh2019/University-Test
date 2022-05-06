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
	
?>
<div class="<?php echo $mainClass.' '.$class;?>" style="height: 291px;">
	
	
	<div class="box" style="height: 256px !important;">
	
	
	<?php
		if($row['videoLink'] != ''){
		?>
			<a href="javascript:void(0);" title="<?php echo $row['projectName'];?>" oncontextmenu="return false;" onclick="showProjectDetailModal('<?php echo $row['projectPageName']?>');"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $row['videoLink'];?>/maxresdefault.jpg" frameborder="0" allowfullscreen>
			</iframe></a>
		<?php
		} else{

			
			if(file_exists(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) > 0){
		?>
		
			<a href="javascript:void(0);" title="<?php echo $row['projectName'];?>" oncontextmenu="return false;" onclick="showProjectDetailModal('<?php echo $row['projectPageName']?>');"><img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $row['image_thumb']?>" alt="image"></a>
			
		<?php }else{?>
			<img class="img-responsive project-img" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/pdf.jpg" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>'" alt="image" >
		<?php }}?>
		<div class="product-overlay">
			<div class="overlay-content">
				<div class="top">
					<div class="proj_name">

					

						<a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>" title="<?php echo $row['projectName'];?>">
						
							<?php
							if(strlen($row['projectName']) > 30)
							{
								$dot = '..';
							}
							else
							{
								$dot = '';
							}
							$position = 30;
							echo $post2 = substr( $row['projectName'], 0, $position).$dot;
							?>
						</a>
					</div>

					<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px">
						<h5>
							<?php echo $row['categoryName'];  ?>
						</h5>
						
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
						<div class="col-lg-4 col-xs-4">
							<?php

							$totalLikeName = $this->db->select('A.userId')->from('user_project_views as A')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array(); 
							if($this->session->userdata('front_user_id') != ''){
								$condition=array('userId'=>$this->session->userdata('front_user_id'),'projectId'=>$row['id']);
							}else{
								$condition=array('ip_address'=>$this->input->ip_address(),'projectId'=>$row['id']);
							}
							$userLiked=$this->modelbasic->getValue('user_project_views','userLike',$condition);

							if($userLiked == ''){
								?>
								<div class="like dropdown" >
								<div class="like_div" data-name="0" data-id="<?php if(!empty($row['id'])){ echo $row['id'];}else
							{ echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>" >
									<i class="fa fa-thumbs-o-up" id="like_div_id">
									</i>&nbsp;
									<span class="like_span">
										<?php echo count($totalLikeName); ?>
									</span>
									</div>
									
								</div>
								<?php
							}
							else
							{						   
								?>	
								<div class="like dropdown " title="">
									<span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up "></i></span>
								<span class="like_span" >
									<?php echo count($totalLikeName); ?>
								</span>	
								      
								      </div>	
								<?php
							}?>

						</div>				
						<div class="col-lg-4 col-xs-4">
							<div class="photo" title="Total Project Images">
								<?php
								
								$CI         =& get_instance();
								$CI->load->model('model_basic');
								$imageCount = $CI->model_basic->getCount('user_project_image','project_id',$row['id']);
								//echo $imageCount;die;
								?>
								<i class="fa fa-picture-o"></i>&nbsp;
								<span>
									<?php echo $imageCount;?>
								</span>
								
							</div>
						</div>
						
					</div>
				
			</div>
		</div>
	</div>
	
</div>
<?php }?>



