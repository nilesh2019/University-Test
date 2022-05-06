<?php
$i = 1;
foreach($trandingJob as $row)
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
	<div class="box">
		<?php if($row['companyLogo']!='' && file_exists(file_upload_s3_path().'companyLogos/'.$row['companyLogo']) && filesize(file_upload_s3_path().'companyLogos/'.$row['companyLogo']) > 0)
		{
			$back_image = file_upload_base_url().'companyLogos/'.$row['companyLogo'];
		}
		else{
			$back_image = base_url().'assets/images/trending_job.jpg';
		} ?>
		<img class="img-responsive project-img" src="<?php echo $back_image;?>" alt="image" onclick="window.location='<?php echo base_url()?>job/jobDetail/<?php echo $row['id']?>'">
			<div class="product-overlay">
				<div class="overlay-content">
					<div class="top">
						<div class="proj_name" style="text-align: center;font-size:14px;">						
							<a href="<?php echo base_url()?>job/jobDetail/<?php echo $row['id']?>" title="<?php echo $row['title'];?>">
								<?php
								if(strlen($row['title']) > 40)
								{
									$dot = '..';
								}
								else
								{
									$dot = '';
								}
								$position = 40;
								echo $post2 = substr( $row['title'], 0, $position).$dot;
								?>
							</a>
						</div>						
						<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px;text-align: center;">
							<h5>
								<b>Company : <?php echo $row['companyName'];  ?></b>
							</h5>							
							<h5>
								No Of Position : <?php echo $row['no_of_position'];  ?>
							</h5>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php }  ?>

