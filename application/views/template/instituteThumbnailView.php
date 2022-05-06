<?php
$i = 1;
foreach($trandingInstitute as $row)
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
		<img class="img-responsive project-img" src="<?php echo base_url();?>assets/images/unt_institute_logo.png" alt="image" onclick="window.location='<?php echo base_url()?><?php echo $row['PageName']?>'">
			<div class="product-overlay">
				<div class="overlay-content">
					<div class="top">
						<div class="proj_name" style="text-align: center;font-size:14px;">						
							<a href="<?php echo base_url()?><?php echo $row['PageName']?>" title="<?php echo $row['instituteName'];?>">
								<?php
								if(strlen($row['instituteName']) > 40)
								{
									$dot = '..';
								}
								else
								{
									$dot = '';
								}
								$position = 40;
								echo $post2 = substr( $row['instituteName'], 0, $position).$dot;
								?>
							</a>
						</div>						
						<div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px;text-align: center;">
							<h5>
								<?php echo $row['region_name'];  ?> Region
							</h5>							
							<h5>
								<b><?php echo $row['cnt'];  ?>  Projects</b>
							</h5>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php }  ?>


