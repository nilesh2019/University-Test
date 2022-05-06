<?php
$i = 1;
foreach($trandingPlacement as $row)
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
<div class="<?php echo $mainClass.' '.$class;?>">
	<div class="box" style="pointer-events: none;">
		<?php if($row['profile_image']!='' && file_exists(file_upload_s3_path().'placement/profile_image/'.$row['profile_image']) && filesize(file_upload_s3_path().'placement/profile_image/'.$row['profile_image']) > 0)
		{
			$back_image = file_upload_base_url().'placement/profile_image/'.$row['profile_image'];
		}
		else{
			$back_image = base_url().'creosouls_admin/backend_assets/img/noimage.jpg';
		} ?>
		<img class="img-responsive project-img" alt="image" src="<?php echo $back_image;?>">
			<div class="product-overlay">
				<div class="overlay-content">
					<div class="top">
						<div class="proj_name" style="text-align: center;font-size:14px;">						
							<b><?php
							if($row['student_name'] != ''){
								$fullname = $row['student_name'];
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
							</b>				
						</div>						
						<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px;text-align: center;">
							<h5>
								<b>Company : <?php echo $row['company'];  ?></b>
							</h5>
							<h5>
								Job Profile : <?php echo $row['position'];  ?>
							</h5>							
							
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php }  ?>

