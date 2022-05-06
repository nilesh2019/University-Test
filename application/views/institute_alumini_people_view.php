<?php $this->load->view('template/header');?>
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
 .like .dropdown-menu{
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
 }
 .tranding_projects .btn_orange{
 	margin-bottom: 3%;
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
						<a href="<?php echo base_url()?><?php echo $this->uri->segment(1);?>">
						<?php echo $this->uri->segment(1);?>
						</a>
					</li>
					<li class="active">
						Alumini People
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- Page Content -->
<div class="banner">
	<?php
	if($institute[0]['coverImage']!='' && file_exists(file_upload_s3_path().'institute/coverImage/'.$institute[0]['coverImage']) && filesize(file_upload_s3_path().'institute/coverImage/'.$institute[0]['coverImage']) > 0) {
	?>
		<img class="img-responsive" src="<?php echo file_upload_base_url();?>institute/coverImage/<?php echo $institute[0]['coverImage'];?>" alt="cover image">
	<?php }else{?>
		<img class="img-responsive" src="<?php echo base_url();?>assets/images/nobaner.png" alt="cover image">
	<?php }?>
</div>
<div class="search_container search_style">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4">
				<div class="btn-group">
					
					<?php $institutePageName=$this->uri->segment(1);?>
					<a href="<?php echo base_url();echo $institutePageName;?>/alumini_projects">
					<button class="btn <?php if($this->uri->segment(2)=='alumini_projects'){ echo 'btn-primary';}else{ echo 'btn-default';}?>" type="button" style="margin-left: 3px">
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
					  	if(!empty($institute)&&$institute[0]['instituteLogo']!='')
					{ ?>
					<img src="<?php echo file_upload_base_url();?>institute/instituteLogo/<?php echo $institute[0]['instituteLogo'];?>" alt="image">
					<?php }else{?>
					<img src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image">
					<?php }?>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="input-group search">
					<input id="search_people" type="text" placeholder="Type People Name" class="form-control">
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
					           <strong> Contact Number : </strong> <?php echo $institute[0]['contactNo'];?>
					           </div>
					           <div class="col-md-12">
					           <strong>Address : </strong> <?php echo $institute[0]['address'];?>
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
				<div id="user_div">
					<?php
					//print_r($project);die;
					if(!empty($peoples))
					{
						$data = array();
						$data['peoples'] = $peoples;
						//$data['thumbnailNum'] = 4;
						//$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-6';						
						$this->load->view('template/peopleThumbnailView',$data);
					}else
					{
					?>
						<div class="col-lg-12">
							<div class="no_content_found">
								<h3>
									No People Found.
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
			if(html !=''){
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
				search_term = $('#search_people').val();
				//alert(search_term);
				if($('#alumini_people').prop("checked") == true)
				 {
				 	var alumini_people_status = 1;
				 }
				 else
				 {
				 	var alumini_people_status = 0;
				 }
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img alt="image" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"institute/alumini_more_data_people",
								data:
								{
									call_count:call_count,search_term:search_term,institute:institute
								},
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										$("#load").remove();
										var obj = $.parseJSON(html);
										$.each(obj, function(index, element)
											{
												var location,name;
												name = element.firstname+'&nbsp;'+element.lastname;
												var name1 = name.length;
												if(name1!='')
												{
													a = parseInt(name1);
													if(a > 20)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 20;
													name = name.substring(0, length)+dot;
												}
												else
												{
													name = '&nbsp';
												}
												location = element.city;
												if(element.country!='')
												{
													location = location+',&nbsp;'+element.country;
												}
												else
												{
													location = location+'&nbsp;';
												}
												if(element.positionName !='')
												{
													workExp = element.positionName+',&nbsp;'+element.orgName;
												}
												else
												{
													workExp = element.orgName;
												}
												if(typeof element.profession != 'undefined')
												{
													var profession = element.profession;
													var lnt = profession.length;
													a = parseInt(lnt);
													if(a > 20)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 20;
													var trimmedprofession = profession.substring(0, length)+dot;
												}
												else
												{
													var trimmedprofession='';
												}
												if(element.follow_status==1)
												{
													var follow = '<form action="<?php echo base_url();?>user/unfollow_user/'+element.userId+'/0" method="POST"><button type="submit" name="submit" class="fallow_unfallow btn btn_orange" style=" background: #ff8400 none repeat scroll 0 0; border: 0px solid #d0d0d0;"><i class="fa fa-check"></i>&nbsp;FOLLOWING</button></form>';
												}
												else
												{
													var follow ='<form action="<?php echo base_url();?>user/follow_user/'+element.userId+'/0" method="POST"><input type="submit" name="submit" value="FOLLOW" class="fallow_unfallow btn btn_blue"/></form>';
												}
												var profileimage = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
												var tmpImg = new Image();
												tmpImg.src = profileimage;
												var filesize = tmpImg.width;
												var profileimage1='';
//alert(typeof filesize);
												if(element.profileimage=='')
												{
													profileimage1="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}
												else
												{
													
													profileimage1 = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
													
												}

												/*<img class="people__background" src="'+profileimage1+'">*/
												$('#user_div').append('<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="people"><div class="people__title"><div class="be-user-counter"><div class="c_number">'+element.project_count+'</div><div class="c_text">projects</div></div><a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/'+element.userId+'"><img class="img-circle" src="'+profileimage1+'" alt="image" style=></a><h4><a href="<?php echo base_url();?>user/userDetail/'+element.userId+'" class="be-use-name">'+name+'</a></h4><p style="min-height:35px">'+workExp+'</p><p class="profession">'+trimmedprofession+'&nbsp;</p><div class="count"><div class="col-lg-4" style="padding:1px;><span title="View"><i class="fa fa-eye"></i>&nbsp;</span><span>'+element.viewCount+'</span></div><div class="col-lg-4" style="padding:1px; ><span title="Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;</span><span>'+element.likeCount+'</span></div><div class="follower col-lg-4" style="padding:1px;"><span title="Follower"><i class="fa fa-users"></i>&nbsp;</span><span>'+element.followers+'</span></div></div>'+follow+'</div></div></div>');
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More People Found.</h3></div>');
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


	$(document).on("click", "#close_search_sort", function()
	{
		var institute=$('#institute').val();
		var url=$('#base_url').val();
		$.blockUI();
		$("#user_div").html('');
		$("#msg_div").html('');
		$("#load_img_div").html('');
		$("#call_count").val('1');
		$('#search_people').val('');
		$("#search_sort").remove();
		var lght = $("#filter_div > div").length;
		if(lght == 1)
		{
			$("#clear_all_div").hide();
		}
		search_term = $('#search_people').val();
		call_count =1;
		a = parseInt(call_count);
		$("#call_count").val(a+1);
		load_people(call_count,search_term,institute);
	});


	$('#search_people').keyup(function()
     {
	    delay(function()
	    {
	    	var search_term = $('#search_people').val();
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
					
						$.blockUI();
						$("#user_div").html('');
						$("#msg_div").html('');
						$("#load_img_div").html('');
						$("#call_count").val('1');						
						$("#clear_all_div").show();
						if($('#alumini_people').prop("checked") == true)
						 {
						 	var alumini_people_status = 1;
						 }
						 else
						 {
						 	var alumini_people_status = 0;
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
							$("#search_sort").remove();
							var lght = $("#filter_div > div").length;
							if(lght == 1)
							{
								$("#clear_all_div").hide();
							}
						}
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_people(call_count,search_term,institute);
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



function load_people(call_count,search_term,institute)
	{
		
		$("#filter_div #after_this").html('');
		if(search_term != ''){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');
		}
		var url=$('#base_url').val();
		$.ajax(
		{
			url: url+"institute/people_more_data",
			data:
			{
				call_count:call_count,search_term:search_term,institute:institute
			},
			type: "POST",
			success:function(html)
			{
				if(html != '')
				{
					$("#load").remove();
					var obj = $.parseJSON(html);
					$.each(obj, function(index, element)
						{
							var location,name;
							name = element.firstname+'&nbsp;'+element.lastname;
							var name1 = name.length;
							if(name1!='')
							{
								a = parseInt(name1);
								if(a > 20)
								{
									var dot ='..';
								}else
								{
									var dot ='';
								}
								var length = 20;
								name = name.substring(0, length)+dot;
							}
							else
							{
								name = '&nbsp';
							}
							location = element.city;
							if(element.country!='')
							{
								location = location+',&nbsp;'+element.country;
							}
							else
							{
								location = location+'&nbsp;';
							}
							if(typeof element.profession != 'undefined')
							{
								var profession = element.profession;
								var lnt = profession.length;
								a = parseInt(lnt);
								if(a > 20)
								{
									var dot ='..';
								}else
								{
									var dot ='';
								}
								var length = 20;
								var trimmedprofession = profession.substring(0, length)+dot;
							}
							else
							{
								var trimmedprofession='';
							}
							if(element.follow_status==1)
							{
								var follow = '<form action="<?php echo base_url();?>user/unfollow_user/'+element.userId+'/0" method="POST"><button type="submit" name="submit" class="fallow_unfallow btn btn_orange"><i class="fa fa-check"></i>&nbsp;FOLLOWING</button></form>';
							}
							else
							{
								var follow ='<form action="<?php echo base_url();?>user/follow_user/'+element.userId+'/0" method="POST"><input type="submit" name="submit" value="FOLLOW" class="fallow_unfallow btn btn_blue"/></form>';
							}
							var profileimage = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
							var tmpImg = new Image();
							tmpImg.src = profileimage;
							var filesize = tmpImg.width;
							var profileimage1='';
							if(element.profileimage=='')
							{
								profileimage1="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
							}
							else
							{								
								profileimage1 = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
							}	
							/*<img class="people__background" src="'+profileimage1+'">*/					
							$('#user_div').append('<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="people"><div class="people__title"><div class="be-user-counter"><div class="c_number">'+element.project_count+'</div><div class="c_text">projects</div></div><a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/'+element.userId+'"><img class="img-circle" src="'+profileimage1+'" alt="image" style=></a><h4><a href="<?php echo base_url();?>user/userDetail/'+element.userId+'" class="be-use-name">'+name+'</a></h4><p>'+location+'</p><p class="profession">'+trimmedprofession+'&nbsp;</p><div class="count"><div class="col-lg-4" style="padding:1px;><span title="View"><i class="fa fa-eye"></i>&nbsp;</span><span>'+element.viewCount+'</span></div><div class="col-lg-4" style="padding:1px; ><span title="Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;</span><span>'+element.likeCount+'</span></div><div class="follower col-lg-4" style="padding:1px;"><span title="Follower"><i class="fa fa-users"></i>&nbsp;</span><span>'+element.followers+'</span></div></div>'+follow+'</div></div></div>');
						});
				}
				$.unblockUI();
			}
		});
	}
</script>
