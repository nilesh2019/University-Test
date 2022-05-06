<?php $this->load->view('template/header');?>
<style>
	.pointer1
	{
		cursor: pointer;
	}	
	.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<!--Scroll Bar-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css"/>
<!--Scroll Bar End-->
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 page_navigation">
				<ul class="category">
					<li>
						<a class="active">
							My Stream
						</a>
					</li>
					<li>
						<a href="<?php echo base_url();?>myboard">
							My Board
						</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-9 left_side arrow_box1">
				<div class="row">
					<div class="col-lg-12">
						<ul class="people_you_nav">
							<li class="latest_proj">
								<h4>
									Stream Projects
								</h4>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<h4>
										People you follow
									</h4>
								</a>
								<div class="people_you_follow dropdown-menu">
									<h4>
										People you follow
										<span>
											<?php
											if(!empty($followingUserData)){
												echo count($followingUserData);
											}
											else
											{
												echo '0';
											}
											?>
										</span>
									</h4>
									<div class="showcase">
										<div id="content-2" class="content33 mCustomScrollbar light" data-mcs-theme="minimal-dark">
											<?php
											if(!empty($followingUserData)){
												foreach($followingUserData as $row){
													?>
													<div class="col-lg-6">
														<div class="media">
															<div class="media-left">
																<a href="<?php echo base_url();?>user/userDetail/<?php echo $row['id']?>">
																	<?php
																	if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0)
																	{
																		?>
																		<img class="media-object img-circle" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileImage']?>" alt="image" >
																		<?php
																	}
																	else
																	{
																		?>
																		<img class="media-object img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image">
																		<?php
																	} ?>
																</a>
															</div>
															<div class="media-body">
																<p>
																	
																	<?php
																		if($row['firstName'] != ''){
																			$fullname = $row['firstName'].' '.$row['lastName'];
																		}
																		else
																		{
																			$fullname= '';
																		}
																		if($fullname!= '')
																		{
																			$atr = $fullname;
																			if(strlen($atr) > 15)
																			{
																				$dot = '..';
																			}
																			else
																			{
																				$dot = '';
																			}
																			$position = 15;
																			echo $post2 = substr($atr, 0, $position).$dot;
																		}
																		else
																		{
																			echo '&nbsp;';
																		}
																		?>
																</p>
																<p>
																<?php
																	if(isset($row['profession']) && $row['profession'] != ''){
																		$atr = $row['profession'];
																		if(strlen($atr) > 30)
																		{
																			$dot = '..';
																		}
																		else
																		{
																			$dot = '';
																		}
																		$position = 30;
																		echo $post2 = substr($atr, 0, $position).$dot.'<br>';
																	}
																	else
																	{
																		echo '&nbsp;';
																	}
																	if($row['city'] != '')
																	{
																		echo $row['city'];
																	}?>
																</p>
																<a href="<?php echo base_url();?>stream/unfollow_user/<?php echo $row['id'];?>">
																	<label class="stop_following pointer1">
																		<i class="fa fa-times">
																		</i>&nbsp;FOLLOWING
																	</label>
																</a>
															</div>
														</div>
													</div>
													<?php
												}
											} ?>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="clearfix">
					</div>
					<div class="tranding_projects" id="project_div">
					<?php
						if(!empty($project))
						{
							$data = array();
							$data['project'] = $project;
							$data['thumbnailNum'] = 3;
							$data['mainClass'] = 'col-lg-3 col-md-3 col-sm-3 col-xs-12';						
							$this->load->view('template/projectThumbnailView',$data);
						}else{?>
							<div class="col-lg-12">
								<div class="no_content_found">
									<h3>
										No Projects Found.
									</h3>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div id="load_img_div"></div>
				<input type="hidden" id="call_count" value="2"/>
			</div>
			<?php
				$data = array();
				$data['job'] = $job;
				$this->load->view('template/recomndedJobs',$data);
			?>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<!-- custom scrollbar plugin -->
<script src="<?php echo base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js">
</script>
<!-- custom scrollbar plugin -->
<script>
	function UrlExists(url)
		{
			$.ajax({
				url: base_url+'project/file_exists',
				type: 'POST',
				data: {'file': url},
			})
			.done(function(data) {
				return data;
			})
		}
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
				var mostOfTheWayDown = ($(document).height() - $(window).height());
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"stream/more_data",
								data:
								{
									call_count:call_count
								},
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										var i = 1;
										var div_class;
										$("#load").remove();
										var obj = $.parseJSON(html);
										$.each(obj, function(index, element)
											{
												if(i == 1)
												{
													div_class = 'right5';
													i++;
												}
												else
												if(i == 2 )
												{
													div_class = 'rightleft5';
													i++;
												}
												else
												{
													div_class = 'left5';
													i     = 1;
												}
												if(typeof element.profession != 'undefined')
												{
													var profession = element.profession;
													var lnt = profession.length;
													a = parseInt(lnt);
													if(a > 16)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 16;
													var trimmedprofession = profession.substring(0, length)+dot;
												}
												else
												{
													var trimmedprofession='';
												}
												var n = element.projectName.length;
												a = parseInt(n);
												if(a > 40)
												{
													var dot ='..';
												}
												else
												{
													var dot ='';
												}
												var length = 40;
												var trimmedName = element.projectName.substring(0, length)+dot;
												var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
												/*if(!UrlExists(profileImage))
												{
													var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												var date = element.created;
												var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
												var loca;
												if(element.city!='')
												{
													loca = element.city;
												}else
												{
													loca = 'Location';
												}
												if(element.userLiked==0)
												{
													/*userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/


													userLiked = '<div class="like dropdown"><div class="like_div" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>'+element.droupdown+'</div>';

												}
												else{
													/*userLiked = '<div class="like"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
													userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
												}
												var myStr = element.firstName+' '+element.lastName;
												var getStrLength = myStr.length;
												var fixedLengthSter = myStr.substring(0, 22);
												if(getStrLength > 22)
												{
													var str2 = '...';
													var fixedLengthSter = fixedLengthSter.concat(str2)
												}												
												
												$('#project_div').append('<div class="col-lg-3 col-md-3 col-sm-3 '+div_class+'"><div class="box"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image" onclick='+urllink+'><div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="<?php echo base_url()?>projectDetail/'+element.projectPageName+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none"><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+fixedLengthSter+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
											});
												$('div.dropdown').hover(function() {
												  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
												}, function() {
												  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
												});
									}
									else
									{
										$('#load').remove();
										if($("#no_rec").length == 0)
										{
											
											$("#load_img_div").append('<div id="no_rec" style="height: 30px;top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');

										}
										else
										{
											
											$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
										}
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
