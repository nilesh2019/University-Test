<?php $this->load->view('template/header');?>
<style>
.navbar {
background-color:rgb(0,0,0);
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
					<li>
					<?php 
					//print_r($this->session->all_userdata());die;
					if($this->session->userdata('teachers_status') == 0) {?>
					<a href="<?php echo base_url()?>assignment">
					<?php }  else { ?>  
						<a href="<?php echo base_url()?>assignment/manage_assignment/<?php echo $this->session->userdata('front_user_id');?>">
						<?php }  ?>
							Assignments
						</a>
					</li>
					<li class="active">
						Details
					</li>
				</ol>
			</div>			
			<div class="comp_list">
				<div class="col-lg-12">
					<div class="box_comp">
						<div class="hero ">							
							<img alt="image" src="<?php echo base_url();?>assets/img/as-1.jpg" class="hero__background1">
							<div class="hero__title">								
								<h3>
									<?php echo ucwords($assignment[0]['assignment_name']);?>
								</h3>	
								<?php  

								if(!isset($sub_assig))
								{ 
								if($assignment[0]['teacher_id'] != $this->session->userdata('front_user_id'))
								{
								$this->CI =& get_instance();
								$this->CI->load->model('model_basic');
								$uid = $this->uri->segment(4);
								$assignment_id = $this->uri->segment(3);								
								$project_Id=$this->CI->model_basic->getAllData('project_master','id,assignment_status',array('userId'=>$uid,'assignmentId'=>$assignment_id));
								$isAssigned=$this->CI->model_basic->getValueArray('user_assignment_relation','assignment_id',array('user_id'=>$uid,'assignment_id'=>$assignment_id));

								$checkAssignmentDate = $this->CI->model_basic->getAllData('assignment','start_date',array('id'=>$assignment_id));
								//print_r($checkAssignmentDate[0]['start_date']);die;
								if(!empty($project_Id) && $project_Id[0]['id'] !='' )
								{
									if($project_Id[0]['assignment_status'] !=3)
									{   ?>

										<a class="btn btn-default" style=" margin-bottom: 15px; margin-left: 10px;" href="<?php echo base_url();?>project/edit_project/<?php echo $project_Id[0]['id']; ?>/<?php echo$assignment_id; ?>" ><i class="fa fa-upload"></i>Edit Existing Assignment </a>						
										<?php	}  }
										elseif($isAssigned!='' && ($checkAssignmentDate[0]['start_date'] <= date('Y-m-d'))){ ?>
										<button  class="submit_project btn btn-success" data-id="<?php if(!empty($assignment)){ echo $assignment[0]['id'];}?>"><i class="fa fa-plus"></i> Submit New Assignment</button>
									<?php }  }  }
								?>
								<!-- 	<?php $this->CI =& get_instance();
									$this->CI->load->model('model_basic');
									$uid = $this->uri->segment(4);
									$assignment_id = $this->uri->segment(3);								
									$project_Id=$this->CI->model_basic->getAllData('project_master','id,assignment_status',array('userId'=>$uid,'assignmentId'=>$assignment_id));
									if(!empty($project_Id) && $project_Id[0]['id'] !='' ){

									if($project_Id[0]['assignment_status'] !=3)
									{   ?>
								<a class="btn btn-default" style=" margin-bottom: 15px; margin-left: 10px;" href="<?php echo base_url();?>project/edit_project/<?php echo $project_Id[0]['id']; ?>/<?php echo$assignment_id; ?>" ><i class="fa fa-upload"></i>Edit Existing Assignment </a>						
								<?php	} }
								else{ ?>
								<button  class="submit_project btn btn-success" data-id="<?php if(!empty($assignment)){ echo $assignment[0]['id'];}?>"><i class="fa fa-plus"></i> Submit New Assignment</button>
								<?php }   ?> -->
							</div>
						</div>
						<div class="hero2  bg-img"  style="overflow: auto;">
								<div class="assignment-info">
									<p>
										<h3><?php /*echo $assignment[0]['assignment_name'];*/ ?> Description </h3>
										<?php echo $assignment[0]['description']; ?>
									</p>
									<div class="assigned-by">
										<p>
											<strong>Teacher Name :</strong>&nbsp; <?php echo $teacher[0]['firstName']; ?> <?php echo $teacher[0]['lastName']; ?>
										</p>
									</div>
									<div class="assigned-by">
										<p>
											<strong>Tools :</strong>&nbsp; 
											<?php 
											$j=count($tools);
											$i=1;
												if(!empty($tools))
												{
													foreach ($tools as $singleTool) {

														echo $singleTool['attributeValue'];
														
														if($i < $j)
														{
															echo ', ';
														}
														$i++;

													}
												}									
										 ?>
										</p>

										<p>
											<strong>Features :</strong>&nbsp; 
											<?php 
											$j=count($features);
											$i=1;
												if(!empty($features))
												{
													foreach ($features as $feature) {

														echo $feature['attributeValue'];
														
														if($i < $j)
														{
															echo ', ';
														}
														$i++;

													}
												}									
										 ?>
										</p>
										</br>

									</div>
								</div>
								<div class="col-md-12">
									<div class="dates" style="margin-left: -15px;">
										<div class="startEnd">
											<p>
												<i class="fa fa-calendar-check-o">
												</i>Start Date : <span><?php echo date('M d, Y',strtotime($assignment[0]['start_date'])); ?></span>
											</p>
											<p>
												<i class="fa fa-calendar-check-o">											
												</i>End Date : <span><?php echo date('M d, Y',strtotime($assignment[0]['end_date'])); ?></span>
											</p>
										</div>							
									</div>
								</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<center><h3>Reference Video :</h3></center>				
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						 <?php
		              if($assignment[0]['videoLink'] != '')
		              {
		                ?>
		                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?php echo $assignment[0]['videoLink'];?>?rel=0" frameborder="0" allowfullscreen>
		                </iframe>
		                <?php
		              } ?>
		          	</div>
					<div class="col-lg-1"></div>

	          </div>
			</div>
<?php if(!empty($my_project))
					{  ?>
			<div class="participate_project">
				<div class="tranding_projects" >
					<div class="col-lg-12">
						<h2>
						My Assignment
						</h2>
					</div>
					<?php					
						$data = array();
						$data['project'] = $my_project;					
						$data['thumbnailNum'] = 4;						
						$data['rateButton'] = $this->uri->segment(4);
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';
						$data['is_assignment'] = 1;
						$this->load->view('template/projectThumbnailView',$data);					
					?>
				</div>
			</div>
<?php  }  ?>
			<div class="participate_project">
				<div class="tranding_projects" id="project_div">
					<div class="col-lg-12">
						<h2>
						Submitted Assignment
						</h2>
					</div>
					<?php
					if(!empty($project))
					{
						$data = array();
						$data['project'] = $project;					
						$data['thumbnailNum'] = 4;						
						$data['rateButton'] = $this->uri->segment(4);
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';
						$data['is_assignment'] = 1;
						$this->load->view('template/projectThumbnailView',$data);
					}
					?>
				</div>
			</div>
			<div class="col-lg-12">
				<div id="load_img_div" style="width:400px;">
				</div>
				<input type="hidden" id="call_count" value="2"/>
				<input type="hidden" id="assignment" value="<?php echo $assignment[0]['id'];?>"/>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="rate_form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
					<h4 class="modal-title" style="text-align: center" id="myModalLabel">
						Rate this project
					</h4>
				</div>
				<div class="modal-body form-group">
					<div class="row">
						<div class="col-xs-12 col-md-3">
						</div>
						<div class="col-xs-12 col-md-6">
							<div id="ratingInfo" style="display:none;margin-bottom: 10px">
							</div>
							<select class="form-control" name="rating">
								<option value="">
									Select Rating
								</option>
								<?php
								for($i = 0; $i < 11; $i++){
									?>
									<option value="<?php echo $i;?>">
										<?php echo $i;?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="col-xs-12 col-md-3">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
					<button type="submit" class="btn btn-primary">
						Save changes
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="assignment_comment_resubmit" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">
					Write Your Assignment Comment<span style="color: red;">(*)</span>
				</h4>
			</div>
			<form method="post" action="<?php echo base_url();?>assignment/assignment_approval_student_coment/<?php echo $this->uri->segment(3);?>/4/<?php echo $this->uri->segment(4);?>">
				<div class="modal-body">
					<div class="form-group" style="height: 140px!important;" >
						<textarea class="form-control" id="assignmentText" name="assignmentText" style="height: 154px!important;" ></textarea>
					</div>
				</div>							
				<input type="hidden" name="assignmentCommentByUserId" value="<?php echo $this->session->userdata('front_user_id'); ?>" />
				<div class="modal-footer">					
					<button type="submit" class="btn btn-success">
						Post
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<input type="hidden" value="<?php echo $assignment[0]['assignment_name']?>" id="hidename"/>
<div class="clearfix"></div>
<?php $this->load->view('template/footer');?>

<script>
$(document).ready(function()
	{
		$('.submit_project').click(function()
		{
			var assignment_id = $(this).attr('data-id');
			if(assignment_id!='')
			{
				$('.AddProject').toggle();
				$('.AddProject #Save_Assignment_Id').val(assignment_id);
				$('#publishProject').hide();
				$('#draftProject').hide();					
			}
			//jQuery('#add_project_button').click();
		});
	});
</script>

<script>
/*$(window).bind("pageshow", function()
	{
		$('#call_count').val(2);
	});*/


$(document).ready(function()
		{			
			var url=$('#base_url').val();
			var assignment='<?php echo $assignment[0]["id"]; ?>';
			var cat_id = 0;
			var hidename=$('#hidename').val();
			//alert(assignment);
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var mostOfTheWayDown = ($(document).height() - $(window).height());
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img style="width:100px;" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"assignment/more_data",
								data:
								{
									call_count:call_count,assignment:assignment
								},
								type: "POST",
								//dataType: "json",
								success:function(html)
								{
									//alert(html);
									//alert(JSON.stringify(html));																			
									if(html != '')
									{
										var i = 1;
										var div_class;
										$("#load").remove();
										var obj = $.parseJSON(html);
										//var obj = $.parseJSON(JSON.stringify(html));	
										//var obj =  jQuery.parseJSON(html);										
																		
										
										$.each(obj, function(index, element)
											{	
											//	alert(element.created);					
												if(i == 1)
												{
													div_class = 'right5';
												}
												else
												if(i == 2 || i == 3)
												{
													div_class = 'rightleft5';
												}
												else
												{
													div_class = 'left5';
													i=0;
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
												var loca;
												if(element.city!='') { loca = element.city; }else{ loca = 'Location';}
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
											/*	if(!UrlExists(profileImage))
												{
													var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												var date = element.created;
												if(hidename==1)
												{
													var echoName=element.firstName+' '+element.lastName;
												}
												else
												{
													var echoName='User Id : '+element.userId;
												}
											
											/*	var rateDiv='<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'+element.id+'" data-toggle="modal" class="rateit btn btn-primary" style="top:2%;left: 40%;">Rate It</button>';	*/

												var rateDiv='<div></div>';	
											
												/*var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';*/
												/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
												var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
												if(element.userLiked==0)
												{
													userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><i class="fa fa-thumbs-o-up" id="like_div_id"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';
												}
												else{
													userLiked = '<div class="like"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';
												}
												<?php
												 if($this->session->userdata('teachers_status') == 1 && $this->uri->segment(1) == 'assignment'  && $this->uri->segment(2) == 'assignment_detail')
													{  ?>

														if(element.assignment_status == 0)
														{
															box = '<div class="box side-corner-tag "><p class="ribbon"><span>ASSIGN</span></p>';
														}
														if(element.assignment_status == 1)
														{
															box = '<div class="box side-corner-tag "><p class="ribbon"><span>SUBMITED</span></p>';
														}
														if(element.assignment_status == 2)
														{
															box = '<div class="box side-corner-tag "><p class="ribbon"><span>PENDING</span></p>';
														}
														if(element.assignment_status == 3)
														{
															box = '<div class="box side-corner-tag "><p class="ribbon"><span>ACCEPTED</span></p>';
														}
													
													<?php } else {   ?>
													box = '<div class="box">';
												<?php	}  ?>


												if(element.userLiked==0)
												{
													/*userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/

												userLiked = '<div class="like like_div dropdown" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
												}
												else
												{
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
												$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'">'+box+rateDiv+'<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image"></a><div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'">'+element.projectName+'</a></div><div class="col-lg-9 col-xs-9 padding_none"><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+fixedLengthSter+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
												i++;
											});

											$('div.dropdown').hover(function() {
											  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
											}, function() {
											  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
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
<script>
	$('#assignment_comment_resubmit button').click(function(event) {
		$('#assignment_comment_resubmit button').css('display', 'none');		
	});
</script>

<script>
	jQuery(document).ready(function($) {	
	<?php if($this->uri->segment(5) == 1)
	{  ?>
		$('#assignment_comment_resubmit').modal('show');
<?php	} ?>		  	
	})
</script>

<?php
/*$cName = ucwords($competition[0]['name']);
$pageName = ucwords($competition[0]['pageName']);*/
//$cId = $competitionId;
$this->session->set_userdata('breadCrumb','');
$this->session->set_userdata('breadCrumbLink','');
//$this->session->set_userdata('breadCrumb','Copmitition,'.$cName);
//$this->session->set_userdata('breadCrumbLink','competition/competition_list,competition/'.$pageName);
?>
