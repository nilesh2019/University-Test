<?php
$i = 1;
foreach($peoples as $user)
{
	$CI           =& get_instance();
	$CI->load->model('people_model');
	$proData      = $CI->people_model->getUserProjectData($user['userId']);
	$projectCount = sizeof($proData);
	$likeCount    = 0;
	$viewCount    = 0;
	foreach($proData as $val){
		$likeCount = $val['like_cnt'] + $likeCount;
		$viewCount = $val['view_cnt'] + $viewCount;
	}
	/*if(($user['userId']) != $this->session->userdata('front_user_id'))
	{*/
		?>
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
	<div class="people">
<!-- 	<?php
	if(file_exists(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) > 0)		{
	?>
		<img class="people__background" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $user['profileimage']?>">
	<?php }else{?>
		<img class="people__background" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="">
	<?php } ?> -->
		<div class="people__title" <?php if(($user['userId']) == $this->session->userdata('front_user_id'))
			{ echo 'style="height:203px;"';}?> >
			<div class="be-user-counter">
				<div class="c_number">
					<?php echo $user['project_count'];?>
				</div>
				<div class="c_text">
					projects
				</div>
			</div>
			<a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/<?php echo $user['userId']?>">
				<?php
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) > 0)
				{
				?>
					<img class="img-circle" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $user['profileimage']?>" alt="image">
				<?php
				}
				else
				{
				?>
					<img class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image">
				<?php } ?>
			</a>
			<h4>
			<a href="<?php echo base_url();?>user/userDetail/<?php echo $user['userId']?>" class="be-use-name">
				<?php
					if($user['firstname'] != ''){
						$fullname = $user['firstname'].' '.$user['lastname'];
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
			</h4>
			<!-- <p style="min-height:35px"> -->
				<p>
				<?php 	
				$orgName=$CI->people_model->getOrgName($user['userId']);
				$positionName=$CI->people_model->getPositionName($user['userId']);
				if($this->uri->segment(2)=='alumini_people')
				{ 
					echo $positionName; 
					if($positionName !='')
					{ 
						echo ', ';
					} 
					echo $orgName;
				}
				else
				{?>
					<?php echo $user['city'];
					if($user['city'] != ''){
						echo ',&nbsp;'.$user['country'];
					}
					else
					{
						echo '&nbsp;';
					} 
				}?>
			</p>
			<p class="profession">
				<?php
				if(isset($user['profession']) && $user['profession'] != ''){
					$atr = $user['profession'];
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
				}?>
			</p>
			<div class="count" <?php if(($user['userId']) == $this->session->userdata('front_user_id'))
			{ echo 'style="height:75px;"';}?>>
				<div class="col-lg-4" style="padding:1px">
					<span title="View"><i class="fa fa-eye"></i>&nbsp;</span>
					<span>
						<?php echo $viewCount;?>
					</span>
				</div>
				<div class="col-lg-4" style="padding:1px">
					<span title="Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;</span>
					<span>
						<?php echo $likeCount;?>
					</span>
				</div>
			
				<div class="follower col-md-4" style="padding:1px">
				  <span title="Follower"><i class="fa fa-users"></i>&nbsp;</span>
					<span>
						<?php
						$CI->load->model('user_model');
						$followers = $CI->user_model->getFollowers($user['userId']);
						if(!empty($followers)){
							echo $followers[0]['followers'];
						}
						else
						{
							echo 0;
						}?>
					</span>
				</div>
			
			</div>
			<?php
			if(($user['userId']) != $this->session->userdata('front_user_id'))
			{
				$CI            =& get_instance();
				$CI->load->model('people_model');
				$followingUser = $CI->people_model->checkFollowingOrNot($user['userId']);
				if(!empty($followingUser))
				{
					?>
					<form action="<?php echo base_url();?>user/unfollow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0" method="POST">
						<!--<input type="submit" name="submit" value="Following" class="fallow_unfallow btn  btn-danger"/>-->
						<button type="submit" name="submit" class="fallow_unfallow btn btn_orange">
							<i class="fa fa-check"></i>&nbsp;FOLLOWING
						</button>
					</form>
			<?php
				}
				else
				{
					?>					

					<form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0" method="POST">	
						<input type="submit" name="submit" value="FOLLOW" class="fallow_unfallow btn btn_blue"/>
					</form>
			<?php
				}
			}?>
		</div>
	</div>
</div>
<?php /*}*/
}?>
