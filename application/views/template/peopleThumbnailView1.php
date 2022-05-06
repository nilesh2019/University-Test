<?php
$i = 1;
foreach($peoples as $row)
{
	
			$CI           =& get_instance();
		$CI->load->model('people_model');
		$proData      = $CI->people_model->getUserProjectData($row['userId']);
		$projectCount = sizeof($proData);
		$likeCount    = 0;
		$viewCount    = 0;
		foreach($proData as $val){
			$likeCount = $val['like_cnt'] + $likeCount;
			$viewCount = $val['view_cnt'] + $viewCount;
		}
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
<div class="<?php echo $mainClass.' '.$class;?>">
	<div class="box">
					<?php
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileimage']) > 0)
					{
					?>
		<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileimage']?>" alt="" onclick="window.location='<?php echo base_url();?>user/userDetail/<?php echo $row['userId']?>'">
						
					<?php
					}
					else
					{
					?>
		<img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileimage']?>" alt="" onclick="window.location='<?php echo base_url();?>user/userDetail/<?php echo $row['userId']?>'">
						
					<?php } ?>
			<div class="product-overlay">
				<div class="overlay-content">
					<div class="top">
						<div class="proj_name" style="text-align: center;;font-size:14px;">						
							<a href="<?php echo base_url();?>user/userDetail/<?php echo $row['userId']?>" title="<?php echo $row['userId'];?>">
								<?php
						if($row['firstname'] != ''){
							$fullname = $row['firstname'].' '.$row['lastname'];
						}
						else
						{
							$fullname= '';
						}
						if($fullname!= '')
						{
							$atr = $fullname;
							if(strlen($atr) > 20)
							{
								$dot = '..';
							}
							else
							{
								$dot = '';
							}
							$position = 20;
							echo $post2 = substr($atr, 0, $position).$dot;
						}
						else
						{
							echo '&nbsp;';
						}
						?>
							</a>
						</div>						
						<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px;text-align: center;">
							<h5>
								<?php echo $row['instituteName'];  ?>
							</h5>							
							<h5>
								<b><?php echo $row['project_count'];  ?>  Projects</b>
							</h5>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php } ?>
