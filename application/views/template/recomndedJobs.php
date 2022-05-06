<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 job-sec right_side">
	<div class="job_info" style="display: none;">
		<h4 class="title">
			Recommended Jobs
			<span class="view_all">
				<a href="<?php echo base_url()?>job">
					View All
				</a>
			</span>
		</h4>
		<?php
		if(!empty($job)){
			foreach($job as $row){
				?>
				<div class="job">
					<a href="<?php echo base_url();?>job/jobDetail/<?php echo $row['id'];?>">
						<h4>
							<?php echo $row['title'];?>
							<span class="job_type">
								<?php echo $row['type'];?>
							</span>
						</h4>
						<p class="company">
							<?php echo $row['location'];?>
						</p>
						<p>
							<?php
							if(strlen($row['description']) > 55)
							{
								$dot = '..';
							}
							else
							{
								$dot = '';
							}
							$position = 55;
							echo $post2 = substr($row['description'], 0, $position).$dot;
							?>
						</p>
					</a>
				</div>
				<?php
			}
		}else{?>
			<div class="job">
				<div class="no_content_found">
					<h3>
						No Job recomendation found.
					</h3>
				</div>
			</div>
		<?php }?>
	</div>
</div>