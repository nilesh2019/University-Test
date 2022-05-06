<?php 

$this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
.vd_red
{
	color: red;
}
 .box{
 	overflow: visible;
 	opacity: 1;
 }
 /*.like .dropdown-menu{
padding: 0;
margin-left: -50px;
 }
 .like .dropdown-menu li{
 	border-bottom: 1px solid #ccc;
 	    color: #252525;
 	    cursor: pointer;
 	    padding: 5px 5px 5px 10px;
 }
 .like .dropdown-menu li:hover{
 	background: #f4f4f4;
 }
 .like > .dropdown-menu{
 	max-height: 170px !important;
 	overflow-y: scroll;
 }*/
 .banner,.banner img{
 	height: auto;
 	    left: 0;
 	    margin: auto;
 	    max-height: 275px;
 	    max-width: 1380px;
 	    overflow: hidden;
 	    position: relative;
 	    right: 0;
 	    width: 100%;
 }
</style>
<div class="insti_bred">
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
						<a href="<?php echo base_url()?>institute/institute_list">
							Institutes
						</a>
					</li>
					<li class="active">
						<?php echo $this->uri->segment(1);?>
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- Page Content -->
<div class="banner">
	<?php
	if($institute['coverImage']!='' && file_exists(file_upload_s3_path().'institute/coverImage/'.$institute['coverImage']) && filesize(file_upload_s3_path().'institute/coverImage/'.$institute['coverImage']) > 0) {
	?>
		<!--<img class="img-responsive" src="<?php //echo base_url();?>assets/images/Institute_Banner.png" alt="image">-->
        <img class="img-responsive" src="<?php echo file_upload_base_url();?>institute/coverImage/<?php echo $institute['coverImage'];?>" alt="image">
	<?php }else{?>
		<img class="img-responsive" src="<?php echo base_url();?>assets/images/Institute_Banner.png" alt="image">
	<?php }?>
</div>
<div class="search_container search_style">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4">
				<div class="btn-group">
					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Creative Fields
						<i class="fa fa-angle-down">
						</i>
					</button>
					<div class="dropdown-menu" style="width: 500px;background: #fff;color:#414141">
						<div class="col-lg-4">
							<div class="title">
								All Projects
							</div>
							<div class="body">
								<input type="hidden" id="previous_sort" value="All Projects"/>
								<input type="radio" class="all_project" name="all_project" checked value="All Projects">&nbsp;All Projects<br />
								<input type="radio" class="all_project" name="all_project" value="Completed">&nbsp;Completed<br />
								<input type="radio" class="all_project" name="all_project" value="Work in progress">&nbsp;Work in progress
							</div>
							<div class="clearfix"></div>
							<!--<div class="title">
								Alumini Projects &nbsp;<input class="" type="checkbox" id="alumini_project" name="alumini_project" >
							</div>-->
						</div>
						<div class="col-lg-4">
							<div class="title">
								All Creative Fields
							</div>
							<div class="body">
								<?php
								if(!empty($category))
								{
									foreach($category as $cat)
									{
										?>
										<input class="Creative" data-id="<?php echo $cat['id'];?>" data-name="<?php echo $cat['categoryName'];?>" type="checkbox" id="creative_fields<?php echo $cat['id'];?>" name="creative_fields[]" value="<?php echo $cat['id'];?>">&nbsp;<?php echo $cat['categoryName'];?><br />
										<!--<li data-name="<?php echo $cat['categoryName'];?>"><a><?php echo $cat['categoryName'];?></a></li>-->
										<?php
									}
								} ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="title">
								Featured
							</div>
							<div class="body">
								<input type="hidden" id="previous_sort_featured" value="Featured"/>
								<input class="Featured" type="radio" name="Featured" value="Featured">Featured<br />
								<input class="Featured" type="radio" name="Featured" value="Most Appreciated">Most Appreciated<br />
								<input class="Featured" type="radio" name="Featured" value="Most Viewed">Most Viewed<br />
								<input class="Featured" type="radio" name="Featured" value="Most Discussed">Most Discussed<br />
								<input class="Featured" type="radio" name="Featured" value="Most Recent">Most Recent<br />
							</div>
						</div>
					</div>
					<?php $institutePageName=$this->uri->segment(1);?>
					<a href="<?php echo base_url();echo $institutePageName;?>/alumini_projects">
					<button class="btn btn <?php if($this->uri->segment(2)=='alumini_projects'){ echo 'btn-primary';}else{ echo 'btn-default';}?>" type="button" style="margin-left: 3px">
						Alumini Projects
					</button></a>
					<a href="<?php echo base_url();echo $institutePageName;?>/alumini_people">
					<button class="btn <?php if($this->uri->segment(2)=='alumini_people'){ echo 'btn-primary';}else{ echo 'btn-default';}?>" type="button">
						Alumini People
					</button>
					</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="center-institute">
					<?php
					  	if(!empty($institute) && $institute['instituteLogo']!='')
					{ ?>
					<!--<img src="<?php echo base_url();?>assets/images/Institute_Logo.png" alt="image">-->
            <img src="<?php echo file_upload_base_url();?>institute/instituteLogo/<?php echo $institute['instituteLogo'];?>" alt="image">
					<?php }else{?>
					<img src="<?php echo base_url();?>assets/images/Institute_Logo.png" alt="image">
					
					<?php }?>
					<div style="color: #000;padding-top: 10px; font-size: 20px;font-weight: bold;">
						
							<?php echo $institute['instituteName']; ?>						
						
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="input-group search">
					<input id="search" type="text" placeholder="Type project name or description to search" class="form-control">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search">
							</i>
						</button>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix">
</div>
<div class="middle">
	<div class="tranding_projects">
		<div class="container-fluid">
			<div class="row">
			<div class="col-md-12 text-center">
					   <div class="panel-group address-panel" id="accordion">						   
					     <div class="panel panel-default">
					       <div class="panel-heading">
					         <h4 class="panel-title">
					           <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">	
					           </a>
					         </h4>
					       </div>
					       <div id="collapseTwo" class="panel-collapse collapse">
					         <div class="panel-body">
					           <div class="col-md-12">
					           <strong> Contact Number : </strong> <?php echo $institute['contactNo'];?>
					           </div>
					           <div class="col-md-12">
					           <strong>Address : </strong> <?php echo $institute['address'];?>
					           </div>
					         </div>
					       </div>
					     </div>						     
					   </div>
					   </div>
				<div class="col-lg-12">
					<div class="filter">
						<form id="filter_div">
							<span id="after_this" class="filter_applied">
								<!-- <i class="fa fa-filter">
								</i>&nbsp;Filters Applied : -->
							</span>
							<div id="clear_all_div" class="btn-group" style="display: none">
							  <button type="button" class="btn btn-xs btn_remove">
							    <img src="<?php echo base_url(); ?>assets/images/remove.png" alt="image">
							  </button>
							  <button id="clear_all_btn" type="button" class="btn btn-xs btn_remove">Remove All</button>
							</div>
					 	</form>
					</div>
				</div>
				<div id="project_div">
					<?php
					if(!empty($project))
					{
						$data = array();
						$data['project'] = $project;
						$data['thumbnailNum'] = 4;
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';						
						$this->load->view('template/projectThumbnailView',$data);
					}else
					{
					?>
						<div class="col-lg-12">
							<div class="no_content_found">
								<h3>
									No Projects Found.
								</h3>
							</div>
						</div>
						<?php
					} ?>
				</div>
			</div>
			<div id="load_img_div"></div>
			<input type="hidden" id="call_count" value="2"/>
			<input type="hidden" id="institute" value="<?php echo $this->uri->segment(1);?>"/>
		</div>
	</div>
</div>
<div id="jobFeedback" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <!--  <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title">Job Feedback</h4>
      </div>
     <form class="form-horizontal" id="jobFeedbackForm" method="post" >
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="submit" id="jobFeedbackFormSubmit" class="btn btn-default">submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php $this->load->view('template/footer');?>

<script src="<?php echo base_url();?>assets/script/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap_framework.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap-select.min.js"></script>
<script>
jQuery(document).ready(function($) {
	$.ajax({
			url: '<?php echo base_url();?>home/jobStatusFeedback'				
		})
		.done(function(html) {
         //console.log(html);
			if(!html){
             
				<?php if($this->session->userdata('jobStatusFeedback') == 1)
				{ ?>
					$('#jobFeedback .modal-body').html(html);
					$('#jobFeedback').modal('show');
				<?php 
			
				} 
			 ?>					
			}
	     $('#jobFeedbackForm').on('init.field.fv', function(e, data) {
	                 // data.fv      --> The FormValidation instance
	                 // data.field   --> The field name
	                 // data.element --> The field element
	                 var $parent = data.element.parents('.form-group'),
	                     $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');
	                 // You can retrieve the icon element by
	                 // $icon = data.element.data('fv.icon');
	                 $icon.on('click.clearing', function() {
	                     // Check if the field is valid or not via the icon class
	                     if ($icon.hasClass('glyphicon-remove')) {
	                         // Clear the field
	                         data.fv.resetField(data.element);
	                     }
	                 });
	             }).
	     formValidation({
			  message: 'This value is not valid',
			  framework: 'bootstrap',
			  icon: {
			  valid: 'glyphicon glyphicon-ok',
			  invalid: 'glyphicon glyphicon-remove',
			  validating: 'glyphicon glyphicon-refresh'
			  },
	        fields: {
	            selectJobStatus: {
	            	verbose: false,
	            	  trigger: 'blur',
	            	  message: 'The status is not valid',	
	                           validators: {
	                               notEmpty: {
	                                   message: 'The job status is required'
	                               }
	                           }
	                       },

			      userFeedback: {
			        verbose: false,
			                trigger: 'blur',
			                message: 'The Feedback is not valid',
			                validators:
			                  {
			                        notEmpty: 
			                         {
			                          message: 'The Feedback is required and can\'t be empty'
			                         }
			                    }
			                 },
			           },
      
 				 }).on('success.form.fv', function(e) {
	                 // Prevent form submission
	                 e.preventDefault();
	                 var $form = $(e.target),
	                     fv    = $form.data('formValidation');
	                 // Use Ajax to submit form data
	                 var formData = new FormData($('#jobFeedbackForm')[0]);
	                 //alert(formData);
	                 $.ajax({
	                     url: '<?php echo base_url();?>home/submitJobFeedback',
	                     type: 'POST',
	                     data: formData,
	                     async: false,
	                     cache: false,
	                     contentType: false,
	                     processData: false,
	                     success: function(responce) {

	                     $('.fa-spinner').remove();
	                     var data = jQuery.parseJSON(responce);
	                    // alert(data);
	                     if(data.status=='error')
	                     {
	                         $.each(data.errorfields, function()
	                         {
	                             $.each(this, function(name, value)
	                             {	                           
	                                $('[name*="'+name+'"]').parent().after('<div style="margin-left: 15px" class="vd_red">'+value+'</div>');
	                             });
	                         });
	                         
	                        $('#jobFeedbackFormSubmit').prop("disabled", false);
	                     }
	                     else
	                     {
	                         if(data.status=='success')
	                         {	                         	
                                 document.getElementById("jobFeedbackForm").reset();
                                 window.location.reload(); 
	                         }
	                         else
	                         {
                                 $('.fa-spinner').remove();
                                 success_register_2.hide();
                                 error_register_2.show();
                                 $('#jobFeedbackForm').prop("disabled", false);
	                         }
	                     }

	                     }
	                 });
	           });				
		});				
});

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
			var institute=$('#institute').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
				if(creative.length==0)
				{
					creative = '';
				}
				var all_project = $('input[name=all_project]:checked').val();
				var featured = $('input[name=Featured]:checked').val();
				search_term = $('#search').val();
				if($('#alumini_project').prop("checked") == true)
				 {
				 	var alumini_project_status = 1;
				 }
				 else
				 {
				 	var alumini_project_status = 0;
				 }
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
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
								url: url+"institute/more_data",
								data:
								{
									all_project:all_project,creative:creative,featured:featured,call_count:call_count,search_term:search_term,institute:institute,alumini_project_status:alumini_project_status
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
												if(i == 2 || i== 3)
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
													if(a > 18)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 18;
													var trimmedprofession = profession.substring(0, length)+dot;
												}
												else
												{
													var trimmedprofession='';
												}
												var loca;
												if(element.city!='')
												{
													loca = element.city;
												}else
												{
													loca = 'Location';
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
												/*if(UrlExists(profileImage))
												{
													var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												var date = element.created;
												//var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
												/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
												var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
												if(element.userLiked==0)
												{
													/*userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'" title="Total Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
													userLiked = '<div class="like like_div dropdown" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';

												}
												else{
													/*userLiked = '<div class="like" title="Total Likes"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
													userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
												}
												/*$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'"><div class="box"><img class="img-responsive project-img" src="<?php echo base_url();?>uploads/project/thumbs/'+element.image_thumb+'" alt="" onclick='+urllink+'><div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="<?php echo base_url()?>projectDetail/'+element.projectPageName+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none"><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+element.firstName+'&nbsp;'+element.lastName+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o">&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');*/
												
												var myStr = element.firstName+' '+element.lastName;
												var getStrLength = myStr.length;
												var fixedLengthSter = myStr.substring(0, 22);
												if(getStrLength > 22)
												{
													var str2 = '...';
													var fixedLengthSter = fixedLengthSter.concat(str2)
												}
												var videoLink = element.videoLink;
												if(videoLink != ''){
													var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
												}else{
													var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image"></a>'
												}
												$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'"><div class="box">'+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+fixedLengthSter+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');

											});
$('div.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});
									}
									else
									{										
										if($('#project_div .no_content_found').text()  == '')
										{
											$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
										}
										else
										{
											$("#load_img_div").html(' ');
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
			$('.all_project').click(function(e)
				{
					var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
					creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $(this).val();
					var featured = $('input[name=Featured]:checked').val();
					//alert(creative);
					//$('#previous_sort').val(name);
					var previous_sort = $('#previous_sort').val();
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					if(all_project!=previous_sort)
					{
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort").val(all_project);
						if(all_project!='All Projects')
						{
							if($("#all_project_sort").length == 0)
							{
								$('<div id="all_project_sort" class="btn-group"><button id="all_project_sort_lable" type="button" class="btn btn-xs btn_most">'+all_project+'</button><button id="close_all_project_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");
							}
							else
							{
								$("#all_project_sort_lable").text(all_project);
							}
						}
						else
						{
							$("#all_project_sort").remove();
							var lght = $("#filter_div > div").length;
							if(lght == 1)
							{
								$("#clear_all_div").hide();
							}
						}
						 /*var lght = $("#filter_div > div").length;
						alert(lght);*/
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
					}
				});
			$('.Creative').click(function(e)
				{
					var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
						if(creative.length==0)
						{
							creative = '';
						}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					$.blockUI();
					$("#clear_all_div").show();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					var creative_name = $(this).data('name');
					var creative_id = $(this).val();
					if($.inArray(creative_id, creative) != -1)
					{
						if($("#creative_sort").length == 0)
						{
							$('<div id="creative_sort'+creative_id+'" class="btn-group creative_sorted"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most">'+creative_name+'</button><button id="close_creative_sort" data-id="'+creative_id+'" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
						}
						else
						{
							$('<div id="creative_sort'+creative_id+'" class="btn-group"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most">'+creative_name+'</button><button id="close_creative_sort" data-id="'+creative_id+'" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
						}
					}
					else
					{
						if(creative_name==$('#creative_sort'+creative_id.toString()+' #creative_sort_lable').text())
						{
							//alert($('#creative_sort_lable').text());
							$('#creative_sort'+creative_id.toString()).remove();
						}
						/*$("#creative_sort").remove();
						var lght = $("#filter_div").length;
						if(lght == 1)
						{
						}*/
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
			$('.Featured').click(function(e)
				{
					var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
						if(creative.length==0)
						{
							creative = '';
						}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					//alert(creative);
					//$('#previous_sort').val(name);
					var previous_sort = $('#previous_sort_featured').val();
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					if(featured!=previous_sort)
					{
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort_featured").val(featured);
						if(featured!='Featured')
						{
							if($("#featured_sort").length == 0)
							{
								$('<div id="featured_sort" class="btn-group"><button id="featured_sort_lable" type="button" class="btn btn-xs btn_most">'+featured+'</button><button id="close_featured_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
							}
							else
							{
								$("#featured_sort_lable").text(featured);
							}
						}
						else
						{
							$("#featured_sort").remove();
							var lght = $("#filter_div").length;
							// alert(lght);
							if(lght == 1)
							{
								//$("#filter_div").hide();
							}
						}
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
					}
				});
			$('#alumini_project').click(function(e)
			 {
					var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
						if(creative.length==0)
						{
							creative = '';
						}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var alumini_project = $('input[name=alumini_project]:checked').val();
					//var previous_sort = $('#previous_sort_featured').val();
						if($(this).prop("checked") == true)
						 {
						 	var alumini_project_status = 1;
						 }
						 else
						 {
						 	var alumini_project_status = 0;
						 }
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						if(alumini_project_status==1)
						{
							if($("#alumini_sort").length == 0)
							{
								$('<div id="alumini_sort" class="btn-group"><button id="alumini_lable" type="button" class="btn btn-xs btn_most">Alumini Projects</button><button id="close_alumini_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");
							}
							else
							{
								$("#alumini_lable").text('Alumini Projects');
							}
						}
						else
						{
							$("#alumini_sort").remove();
							var lght = $("#filter_div").length;
							// alert(lght);
							if(lght == 1)
							{
								//$("#filter_div").hide();
							}
						}
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
			$(document).on("click", "#close_all_project_sort", function()
				{
					var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
						if(creative.length==0)
						{
							creative = '';
						}
					var featured = $('input[name=Featured]:checked').val();
					var url=$('#base_url').val();
					var all_project = 'All Projects';
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					//$("#previous_sort").val(all_project);
					$("#all_project_sort").remove();
					//$('input[name=all_project]:checked','checked');
					$('.all_project').removeAttr('checked');
					$("input:radio[name=all_project]:first").prop('checked','checked');
					//$(".all_project").val('all_project').prop('checked','checked');
					$('#alumini_project').prop('checked', false);
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
			});
			$(document).on("click", "#close_creative_sort", function()
				{
					var institute=$('#institute').val();
					var creative= [];
					var featured = $('input[name=Featured]:checked').val();
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var creative_id = $(this).data('id');
					//var data_id = $('.Creative').data('id');
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#creative_sort"+creative_id.toString()).remove();
					$('#creative_fields'+creative_id.toString()).prop('checked','');
					$("input[name='creative_fields[]']:checked").each(function()
					{
						creative.push($(this).val());
					});
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
					  $("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					if(creative.length==0)
					{
						creative = '';
					}
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
			$(document).on("click", "#close_featured_sort", function()
			{
				var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = 'Featured';
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#previous_sort_featured").val(featured);
					$("#featured_sort").remove();
					$('.Featured').removeAttr('checked');
					$("input:radio[name=Featured]:first").prop('checked','checked');
					/*  $("#all_project_sort").remove();*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
			$(document).on("click", "#close_search_sort", function()
			{
				var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$('#search').val('');
					$("#search_sort").remove();
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					if($('#alumini_project').prop("checked") == true)
					 {
					 	var alumini_project_status = 1;
					 }
					 else
					 {
					 	var alumini_project_status = 0;
					 }
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
			$(document).on("click", "#close_alumini_sort", function()
			{
				var institute=$('#institute').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$("#alumini_sort").remove();
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
						$('#alumini_project').attr('checked', false);
					search_term = $('#search').val();
					var alumini_project_status = 0;
						call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
		   $(document).on("click", "#clear_all_div", function()
			{
				var institute=$('#institute').val();
					var creative= [];
					var featured = 'Featured';
					var url=$('#base_url').val();
					var all_project = 'All Projects';
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#all_project_sort").remove();
					$('.all_project').removeAttr('checked');
					$("input:radio[name=all_project]:first").prop('checked','checked');
					$("#previous_sort_featured").val(featured);
  					$("#featured_sort").remove();
					$('.Featured').removeAttr('checked');
					$("input:radio[name=Featured]:first").prop('checked','checked');
					$('.Creative').prop('checked','');
					$('.creative_sorted').remove();
					$("#clear_all_div").hide();
					$('#search').val('');
					$("#clear_all_div").hide();
					$("#search_sort").remove();
					search_term = $('#search').val();
					if(creative.length==0)
					{
						creative = '';
					}
					var alumini_project_status = 0;
				    $('#alumini_project').prop('checked', false);
				    $("#alumini_sort").remove();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
				});
		});
	$('#search').keyup(function()
     {
	    delay(function()
	    {
	    	var search_term = $('#search').val();
	    	 var institute=$('#institute').val();
	    		 	var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var previous_sort = $('#previous_sort').val();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort").val(all_project);
						$("#clear_all_div").show();
						if($('#alumini_project').prop("checked") == true)
						 {
						 	var alumini_project_status = 1;
						 }
						 else
						 {
						 	var alumini_project_status = 0;
						 }
						if(search_term!='')
						{
							if($("#search_sort").length == 0)
							{
								$('<div id="search_sort" class="btn-group"><button id="search_sort_lable" type="button" class="btn btn-xs btn_most">'+search_term+'</button><button id="close_search_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
							}
							else
							{
								$("#search_sort_lable").text(''+search_term);
							}
						}
						else
						{
							$("#all_project_sort").remove();
							var lght = $("#filter_div > div").length;
							if(lght == 1)
							{
								$("#clear_all_div").hide();
							}
						}
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,institute,alumini_project_status);
	    }, 1000 );
	});
	var delay = (function(){
 	 var timer = 0;
 	 return function(callback, ms)
 		 {
    	clearTimeout (timer);
    	timer = setTimeout(callback, ms);
  		};
	})();
	function load_projects(url='',all_project='',creative='',featured='',call_count='',search_term='',institute='',alumini_project_status='')
	{

		$("#filter_div #after_this").html('');		

		if(search_term != ''){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');
			$("#filter_div #search_sort").html('<button id="search_sort_lable" class="btn btn-xs btn_most" type="button">'+search_term+'</button><button id="close_search_sort" class="btn btn-xs btn_close" type="button"><i class="fa fa-close"></i></button>');	
			$('#clear_all_div').show();	
		}
		else if(creative != ''){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');	
			$("#filter_div #search_sort").html('<button id="search_sort_lable" class="btn btn-xs btn_most" type="button">'+search_term+'</button><button id="close_search_sort" class="btn btn-xs btn_close" type="button"><i class="fa fa-close"></i></button>');	
			$('#clear_all_div').show();			
		}
		else
		{
			
			$('#search_sort').html('');			
			$('#clear_all_div').hide();
		}

		$.ajax(
		{
			url: url+"institute/more_data",
			data:
			{
				all_project:all_project,creative:creative,featured:featured,call_count:call_count,search_term:search_term,institute:institute,alumini_project_status:alumini_project_status
			},
			type: "POST",
			success:function(html)
			{
				if(html != '')
				{
					var i = 1;
					var div_class;
					$("#load").remove();
					$("#no_rec").remove();
					var obj = $.parseJSON(html);
					$.each(obj, function(index, element)
						{
							if(i == 1)
							{
								div_class = 'right5';
								i++;
							}
							else
							if(i == 2 || i == 3)
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
								if(a > 18)
								{
									var dot ='..';
								}else
								{
									var dot ='';
								}
								var length = 18;
								var trimmedprofession = profession.substring(0, length)+dot;
							}
							else
							{
								var trimmedprofession='';
							}
							var loca;
							if(element.city!='')
							{
								loca = element.city;
							}else
							{
								loca = 'Location';
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
							/*if(UrlExists(profileImage))
							{
								var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
							}*/
							var date = element.created;
							/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
							var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
							if(element.userLiked==0)
							{
								userLiked = '<div class="like like_div"  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'" title="Total Likes"><i class="fa fa-thumbs-o-up" id="like_div_id"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';
							}
							else{
								userLiked = '<div class="like" title="Total Likes"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';
							}

							var myStr = element.firstName+' '+element.lastName;
							var getStrLength = myStr.length;
							var fixedLengthSter = myStr.substring(0, 22);
							if(getStrLength > 22)
							{
								var str2 = '...';
								var fixedLengthSter = fixedLengthSter.concat(str2)
							}
							var videoLink = element.videoLink;
							if(videoLink != ''){
								var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
							}else{
								var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image"></a>'
							}
							$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'"><div class="box">'+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5><span onclick="window.location=<?php echo base_url()?>user/userDetail/'+element.userId+'">'+fixedLengthSter+'</span></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o">&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
						});
				}
				$.unblockUI();
			}
		});
	}
</script>


