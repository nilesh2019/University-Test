<?php $this->load->view('template/header');?>
<!-- MAIN CONTENT -->
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
	.box_comp{
		height: 215px !important;
	}
	.hero__title{
		padding-top: 10px;
	}
	 @media screen and (-webkit-min-device-pixel-ratio:0) {

	     .hero2{
	     	height: 215px !important;
	     }
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
					<li class="active">
						Creative Mind Competition
					</li>
				</ol>
			</div>
			<?php
			if(!empty($competition)){
				?>
				<div class="comp_list">
					<?php
					$i = 1;
					foreach($competition as $row){
						?>
						<div class="col-lg-6 <?php if($i % 2 == 0){ echo 'left';}else{echo 'right';}?>7">
							<div class="box_comp">
								<div class="hero">
									<img class="hero__background" alt="background image" src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $row['banner'];?>">
									<div class="hero__title">
										<a href="<?php echo base_url();?>creative_mind_competitions/<?php echo $row['pageName'];?>">
											<img src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $row['profile_image'];?>" alt="profile image" class="img-circle">
										</a>
										<?php
										$atr = $row['name'];
										if(strlen($atr) > 38){
											$dot = '..';
										}
										else
										{
											$dot = '<br/><br/>';
										}
										$position = 38;
										$post2    = substr($atr,0,$position).$dot;
										?>
										<h4 style="margin-top: 5px;margin-bottom: 5px">
											<a href="<?php echo base_url();?>creative_mind_competitions/<?php echo $row['pageName'];?>">
												<?php echo $post2;?>
											</a>
										</h4>
										<p style="margin-bottom: 5px">
											<i class="fa fa-calendar-check-o">
											</i>Start Date :&nbsp;
											<span>
												<?php echo date("M j, Y",strtotime($row['start_date']));?>
											</span>
										</p>
										<p style="margin-bottom: 5px">
											<i class="fa fa-calendar-check-o">
											</i>End Date &nbsp;:&nbsp;
											<span>
												<?php echo date("M j, Y",strtotime($row['end_date']));?>
											</span>
										</p>
										<div class="count" style="padding-bottom: 5px;padding-top: 5px;display: none;">
											<div class="col-lg-3">
												<i class="fa fa-user">
												</i><br />
												<span>
													<?php echo $row['userCount'];?>
												</span>
											</div>
											<div class="col-lg-3">
												<i class="fa fa-thumbs-o-up">
												</i><br />
												<span>
													<?php echo $row['likeCount'];?>
												</span>
											</div>
											<div class="col-lg-3">
												<i class="fa fa-comment-o">
												</i><br />
												<span>
													<?php echo $row['commentCount'];?>
												</span>
											</div>
											<div class="col-lg-3">
												<i class="fa fa-image">
												</i><br />
												<span>
													<?php echo $row['projectCount'];?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<?php
										/*list($width, $height) = getimagesize(file_upload_base_url().'competition/banner/'.$row['banner']);
										$ratio = ($width / $height);
									    $newWidth = $ratio * $newWidth;
									    $newHeight = $ratio * $newHeight;*/
									?>
								<script>
									/*var screenWidth = window.screen.width;
									var screenHeight = window.screen.height;
									var newWidth= ((screenWidth/2)*60)/100;*/
								</script>
								<div class="hero2">
									<a href="<?php echo base_url();?>creative_mind_competitions/<?php echo $row['pageName'];?>">
										<img class="hero2__background" alt="profile image" src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $row['banner'];?>">
									</a>
								</div>
							</div>
						</div>
						<?php $i++;
					} ?>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="col-lg-12">
					<div class="no_content_found">
						<h3>
							No Competition Found.
						</h3>
					</div>
				</div>
				<?php
			} ?>
		</div>
	</div>
	<div id="load_img_div" style="width:400px;">
	</div>
	<!--<div id="msg_div"></div>-->
	<input type="hidden" id="call_count" value="2"/>
	<input type="hidden" id="userId" value="<?php
	if($this->session->userdata('front_user_id'))
	{
		echo $this->session->userdata('front_user_id');
	}?>"/>
	<input type="hidden" id="fLoggedIn" value="<?php
	if($this->session->userdata('front_is_logged_in'))
	{
		echo $this->session->userdata('front_is_logged_in');
	}?>"/>
</div>
<?php $this->load->view('template/footer');?>
<script>
	/*$(window).bind("pageshow", function()
		{
			$('#call_count').val(2);
		});*/
	$(document).ready(function()
		{
			var url=$('#base_url').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img style="width:100px;" alt="profile image" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"creative_mind_competitions/competition_more_data",
								data:
								{
									call_count:call_count
								},
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										$("#load").remove();
										var obj = $.parseJSON(html);
										var i=1;
										$.each(obj, function(index, element)
											{
												if(i % 2 ==0)
												{
													divClass='left';
												}
												else
												{
													divClass='right';
												}
												$('.comp_list').append('<div class="col-lg-6 '+divClass+'7"><div class="box_comp"><div class="hero"><div class="hero__title"><a href="<?php echo base_url();?>creative_mind_competitions/get_competition/'+element.id+'"><img src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/'+element.profile_image+'" alt="profile image" class="img-circle"></a><a href="<?php echo base_url();?>creative_mind_competitions/get_competition/'+element.id+'"><h4 style="margin-top: 5px;margin-bottom: 5px">'+element.name+'</h4></a><p style="margin-bottom: 5px"><i class="fa fa-calendar-check-o"></i> Start Date : <span>'+element.start_date+'</span></p><p style="margin-bottom: 5px"><i class="fa fa-calendar-check-o"></i> End Date : <span>'+element.end_date+'</span></p><div class="count" style="padding-bottom: 5px;padding-top: 5px;display: none;"><div class="col-lg-3"><i class="fa fa-user"></i>&nbsp;<span>'+element.userCount+'</span>&nbsp;</div><div class="col-lg-3"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span>'+element.likeCount+'</span>&nbsp;</div><div class="col-lg-3"><i class="fa fa-comment-o"></i>&nbsp;<span>'+element.commentCount+'</span>&nbsp;</div><div class="col-lg-3"><i class="fa fa-image"></i>&nbsp;<span>'+element.projectCount+'</span>&nbsp;</div></div></div></div><div class="hero2"><a href="<?php echo base_url();?>creative_mind_competitions/get_competition/'+element.id+'"><img class="hero2__background" alt="profile image" src="<?php echo file_upload_base_url();?>competition/banner/'+element.banner+'"></a></div></div></div>');
												i++;
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Competitions Found.</h3></div>');
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
		});
</script>

