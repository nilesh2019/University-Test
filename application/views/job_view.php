<?php $this->load->view('template/header');?>
<style>
.margin_leftRight span
{
	margin: 0px 2% 0px 2%;
}
.panel-footer
{
	text-align: right;
}
.navbar {
    background-color:rgb(0,0,0);
	}
	.job-wrapper img
	{
		position: relative;
	}
</style>
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="col-lg-4 breadcrumb">
					<li>
						<a href="<?php echo base_url();?>">
							Home
						</a>
					</li>
					<li class="active">
						Job
					</li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
		<div class="col-lg-3 right5" style="padding:0;border-right:1px solid #d0d0d0;">
      		<div class="portfolio_lhs job-form">
        	<form id="searchForm">
        		<div class="form-group">
    				<label>Select</label>
    				<select class="form-control" id="alltabs" name="active_tab">
                    	<option class="active" onclick="javascript:void(0)" data-name="All Jobs" value="All Jobs">All Jobs</option>
                    	<option onclick="javascript:void(0)" data-name="Applied For" value="Applied For">Applied For</option>
                    	<option onclick="javascript:void(0)" data-name="Shortlisted For" value="Shortlisted For">Shortlisted For</option>
                    	<option onclick="javascript:void(0)" data-name="Selected For Interview" value="Selected For Interview">Selected For Interview</option>
                    	<option onclick="javascript:void(0)" data-name="Offered Jobs" value="Offered Jobs">Accepted job offer</option>
                    	<option onclick="javascript:void(0)" data-name="Rejected by Employe" value="Rejected by Employe">Rejected by Me</option>
                    	<option onclick="javascript:void(0)" data-name="Rejected by Admin" value="Rejected by Admin">Rejected by Employer</option>
                    </select>
  				</div>
            	<div class="form-group">
    				<input type="text" id="keywordText" name="keywordText" class="form-control" placeholder="Enter keyword i.e.skills,post name,education"/>
  				</div>
                <div class="form-group">
    				<input type="text" id="companyName" name="companyName" class="form-control" placeholder="Enter company name."/>
  				</div>
                <div class="form-group">
    				<input type="text" id="jobTitle" name="jobTitle" class="form-control" placeholder="Enter job title."/>
  				</div>

                <div class="form-group">
    				<input type="text" class="form-control" id="userLocation" name="userLocation" placeholder="Enter Location / Place"/>
  				</div>
				<input type="button" class="btn btn-success searchJobs" value="Search" id="btn_searchJobs" onclick="this.disabled=true;return true;" >
                <input type="button" class="btn btn-default" onClick="this.form.reset();$('#alltabs option.active').removeClass('active');" value="Reset">             

                <input type="hidden" id="call_count" name="call_count" value="2"/>
            </form>
            <hr>
        	</div>
      	</div>
		<div class="col-lg-9 left5 job-container">
			<div id="wrapper_div">
			<?php

			if(isset($jobs) && !empty($jobs)){
				$i = 1;
				foreach($jobs as $job){
					if($job['close_on'] > date('Y-m-d')) {
						if($job['view_status'] == 1 && $job['posted_by'] == $this->session->userdata('user_institute_id'))
						{
							if($i == 1)
							{
								$class = 'right7';
							}
							else
							if($i == 2)
							{
								$class = 'left7';
								$i     = 0;
							}
							?>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 <?php echo $class;?>">
								<div class="panel panel-default job_list side-corner-tag" style="cursor:pointer;" onclick="showJobDetail(<?php echo $job['id'];?>);">
								<?php if($job['close_on'] < date('Y-m-d')){ ?> <p class="ribbon"><span>CLOSED</span></p> <?php } ?>
									<div class="panel-body">
										<div class="media row">
											<div class="media-left job-title media-top col-md-4">
												<?php
												if($job['companyLogo'] != '')
												{
													?>
													<img class="media-object" src="<?php echo file_upload_base_url();?>companyLogos/<?php echo $job['companyLogo']?>"alt="image">
													<?php
												}
												else
												{
													?>
													<img class="media-object" src="<?php echo base_url();?>assets/images/we_are_hiring.jpg" alt="image">
													<?php
												}?>
											</div>
											<div class="job-detail col-md-8">
												<h4 class="media-heading">
													<a href="<?php echo base_url();?>job/jobDetail/<?php echo $job['id']?>">
														<?php
														if(isset($job['title']) && !empty($job['title'])){
															$atr = $job['title'];
															if(strlen($atr) > 50)
															{
																$dot = '..';
															}
															else
															{
																$dot = '';
															}
															$position = 50;
															echo $post2 = substr($atr, 0, $position).$dot;
														}
														else
														{
															echo '&nbsp;';
														}
														?>
													</a>
												</h4>
												<h5 class="media-heading">
													<?php
													   if($job['companyName']!=''){ echo $job['companyName']; } else { ?>Company Name Not Disclosed<?php } ?>
												</h5>
												<p class="margin_leftRight">
													<i class="fa fa-map-marker">
													</i>
													<span>
														<!-- &nbsp;<?php echo $job['location']?> -->
														&nbsp;
														<?php 
														if(strlen($job['location']) > 60)
														{
															 echo substr(strip_tags($job['location']), 0, 60).'... ';
														}
														else
														{
															echo substr(strip_tags($job['location']), 0, 60).'';
														}

														?> 
													</span>
													<i class="fa fa-briefcase">
													</i>
													<span>
														&nbsp;
														<?php if( $job['min_experience'] == $job['max_experience']) 
														{
															echo $job['min_experience'].' Years';														
														}else
														{
															echo $job['min_experience'].' - '.$job['max_experience'].' Years';
														}
														?>
													</span>
												</p>
											</div>
										</div>
										<div class="disc col-md-12">
										
												<label class="col-lg-4 right5">
													Job Description :
												</label>
												<div class="col-lg-8 job-desc">
													<?php echo substr(strip_tags($job['description']), 0, 40).' ';?>
												</div>
										</div>
										<div class="disc col-md-12">										
											<label class="col-lg-4 right5">
												Job Type  (Job / Internship):
											</label>
											<div class="col-lg-8 job-desc">
												<?php echo (!empty($jobs["job_type1"]) && $jobs["job_type1"]==1)?'Internship':'Job'; ?>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										Close On-&nbsp;&nbsp;<?php echo ucfirst(date("d M, Y", strtotime($job['close_on']))) ;?>
										Posted On-&nbsp;&nbsp;<?php echo ucfirst(date("d M, Y", strtotime($job['created']))) ;?>
									</div>
								</div>
							</div>
							<?php $i++;
						}
						else if($job['view_status'] == 0)
						{
							if($i == 1)
							{
								$class = 'right7';
							}
							else
							if($i == 2)
							{
								$class = 'left7';
								$i     = 0;
							}
							?>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 <?php echo $class;?>">
								<div class="panel panel-default job_list side-corner-tag" style="cursor:pointer;" onclick="showJobDetail(<?php echo $job['id'];?>);">
									<?php if($job['close_on'] < date('Y-m-d')){ ?><p class="ribbon"><span>CLOSED</span></p> <?php } ?>
									<div class="panel-body ">
										<div class="media row">
											<div class="media-left job-title media-top col-md-4">
												<?php
												if($job['companyLogo'] != '')
												{
													?>
													<img class="media-object" src="<?php echo file_upload_base_url();?>companyLogos/<?php echo $job['companyLogo']?>" alt="image">
													<?php
												}
												else
												{
													?>
													<img class="media-object" src="<?php echo base_url();?>assets/images/we_are_hiring.jpg" alt="image">
													<?php
												}?>
											</div>
											<div class="job-detail col-md-8">
												<h4 class="media-heading">
													<a href="<?php echo base_url();?>job/jobDetail/<?php echo $job['id']?>">
														<?php
														if(isset($job['title']) && !empty($job['title'])){
															$atr = $job['title'];
															if(strlen($atr) > 50)
															{
																$dot = '..';
															}
															else
															{
																$dot = '';
															}
															$position = 50;
															echo $post2 = substr($atr, 0, $position).$dot;
														}
														else
														{
															echo '&nbsp;';
														}
														?>
													</a>
												</h4>
												<h5 class="media-heading">
													<?php
													   if($job['companyName']!=''){ echo $job['companyName']; } else { ?>Company Name Not Disclosed<?php } ?>
												</h5>
												<p class="margin_leftRight">
													<i class="fa fa-map-marker">
													</i>
													<span>
														<!-- &nbsp;<?php echo $job['location']?> -->
														&nbsp;
														<?php 
														if(strlen($job['location']) > 60)
														{
															 echo substr(strip_tags($job['location']), 0, 60).'... ';
														}
														else
														{
															echo substr(strip_tags($job['location']), 0, 60).'';
														}

														?> 
													</span>
													<i class="fa fa-briefcase">
													</i>
													<span>
														&nbsp;
															<?php if( $job['min_experience'] == $job['max_experience']) 
															{
																echo $job['min_experience'].' Years';														
															}else
															{
																echo $job['min_experience'].' - '.$job['max_experience'].' Years';
															}
															?>
													</span>
												</p>
											</div>
										</div>
										<div class="disc col-md-12">
										
												<label class="col-lg-4 right5">
													Job Description :
												</label>
												<div class="col-lg-8 job-desc">
													<?php echo substr(strip_tags($job['description']), 0, 40).' ';?>
													<!--<a class="pull-right" href="<?php echo base_url();?>job/jobDetail/<?php echo $job['id']?>">
														Read More...
													</a>-->
												</div>
											</div>
											<div class="disc col-md-12">										
											<label class="col-lg-4 right5">
												Job Type <br/>(Job / Internship):
											</label>
											<div class="col-lg-8 job-desc">
												<?php echo (!empty($jobs["job_type1"]) && $jobs["job_type1"]==1)?'Internship':'Job'; ?>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										Close On-&nbsp;&nbsp;<?php echo ucfirst(date("d M, Y", strtotime($job['close_on']))) ;?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Posted On-&nbsp;&nbsp;<?php echo ucfirst(date("d M, Y", strtotime($job['created']))) ;?>
									</div>
								</div>
							</div>
							<?php $i++;
						}
					}
				}
			}
			else
			{
				?>
				<div class="col-lg-12">
					<div class="no_content_found">
						<h3>
							No More Job Found.
						</h3>
					</div>
				</div>
				<?php
			}?>
			</div>
	        <div id="load_img_div" ></div>
			<input type="hidden" id="all_jobs" value="2"/>
			<input type="hidden" id="applied_for" value="2"/>
			<input type="hidden" id="shortlisted_for" value="2"/>
			<input type="hidden" id="selected_for_interview" value="2"/>
			<input type="hidden" id="offered_job" value="2"/>
			<input type="hidden" id="usrid" value="<?php echo $this->session->userdata('front_user_id');?>"/>
			<input type="hidden" id="isbuttobclick" value="0"/>
		</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
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
		$('#all_job').val(2);
		$('#applied_job').val(2);
		$('#shortlisted_job').val(2);
	 });*/
    var url=$('#base_url').val();
	var cat_id = 0;
	var scrollFunction = function()
	{
		var mostOfTheWayDown = ($(document).height() - $(window).height());
		if ($(window).scrollTop() >= mostOfTheWayDown)
		{
			$("#load_img_div").append('<center id="load"><img src="'+url+'assets/img/load.gif"/></center>');
			$(window).unbind("scroll");
			if($("#no_rec").length==0)
			{
				var wrapper_div =  'wrapper_div';
				//$.blockUI();
				$("#load_img_div").html('');
				search_filter();
			}
			else
			{
				$('#load').remove();
				$(window).scroll(scrollFunction);
			}
			//$.unblockUI();
		}
	};
	$(window).scroll(scrollFunction);
   	$('.searchJobs').on('click',function(){
   		//$.blockUI();
   		$("#wrapper_div").html('');
		$("#msg_div").html('');
		$("#load_img_div").html('');
		$("#call_count").val('1');
		var call_count= 1;
   		search_filter();
   	});
  	$('#alltabs').on('change', function()
	{
		$('#alltabs option.active').removeClass('active');
		$(this).find(':selected').addClass('active');
		/*var call_count= 1;
		search_filter();*/
	})  	
  	
  	  $('#btn_searchJobs').click(function(event) {
  	  		$('#isbuttobclick').val('1');
  	  	});  	
  	 
  	  $("#searchForm :input").blur(function(event) {
  			 $('#isbuttobclick').val('0');
  	  });

	function search_filter()
	{
		var call_count = $("#call_count").val();
		a = parseInt(call_count);
		var active_tab = $("#alltabs option.active").data('name');	
	//	alert(active_tab);
		var form=$("#searchForm");
		$.ajax({
			url: url+"job/search_more_data",
			data:form.serialize(),
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
						if(i == 1)
						{
							class2 = 'right7';
						}
						else if($i == 2)
						{
							class2 = 'left7';
							i     = 0;
						}
						var n = element.title.length;
						a = parseInt(n);
						if(a > 50)
						{
							var dot ='..';
						}
						else
						{
							var dot ='';
						}
						var length = 50;
						var trimmedName = element.title.substring(0, length)+dot;
						if(element.companyLogo != '')
						{
							var companyLogos="<?php echo file_upload_base_url();?>companyLogos/"+element.companyLogo;
							/*if(UrlExists(companyLogos))
							{
								var companyLogos="<?php echo base_url();?>assets/images/we_are_hiring.jpg";
							}*/

						}
						else
						{
							var companyLogos="<?php echo base_url();?>assets/images/we_are_hiring.jpg";
						}
						if(element.companyName==''){
						  var cname = 'Company Name Not Disclosed';
						}
						else{
						  var cname = element.companyName;
						}
						var n = element.desc.length;
						a = parseInt(n);
						if(a > 40)
						{
							var dot ='..';
						}
						else
						{
							var dot ='';
						}

						var todayDate = '<?php echo date('Y-m-d');?>';
						if(element.close_on < todayDate )
						{
							var ribbon = '<p class="ribbon"><span>CLOSED</span></p>';  
						}
						else
						{
							var ribbon = '';  
						}

						var location = '';
												
						if(element.location.length > 60)
						{
							var location = element.location.substring(0,60)+'...';
						}
						else
						{
							var location = element.location.substring(0,60);
						}				

						var length = 40;
						var trimmed_desc = element.desc.substring(0, length)+dot;
						var job_type=(!empty(element.job_type1) && element.job_type1==1)?'Internship':'Job';
						var experience = element.min_experience+' - '+element.max_experience+' Years';
						$('#wrapper_div').append('<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 '+class2+'"><div class="panel panel-default job_list side-corner-tag" onclick="showJobDetail('+element.id+');" style="cursor:pointer;">'+ribbon+'<div class="panel-body"><div class="media row"><div class="media-left job-title col-md-4 media-top"><img class="media-object" src="'+companyLogos+'" alt="image"></div><div class="job-detail col-md-8"><h4 class="media-heading"><a href="<?php echo base_url();?>job/jobDetail/'+element.id+'">'+trimmedName+'</a></h4><h5 class="media-heading">'+cname+'</h5><p class="margin_leftRight"><i class="fa fa-map-marker"></i><span>&nbsp;'+location+'</span><i class="fa fa-briefcase"></i><span>&nbsp;'+experience+'</span></p></div></div><div class="disc col-md-12"><label class="col-lg-4 right5">Job Description : </label><div class="col-lg-8 job-desc">'+trimmed_desc+'</div></div></div><div class="disc col-md-12"><label class="col-lg-4 right5">Job Type  <br/>(Job / Internship) : </label><div class="col-lg-8 job-desc">'+job_type+'</div></div></div><div class="panel-footer">Posted On-&nbsp;&nbsp;'+element.created+'</div></div></div>');
					});
				}
				else
				{
					if(active_tab == 'Applied For'  && $('#isbuttobclick').val()=='1')
					{
						var jobMsg = "You haven't applied for a job yet.";
					}
					else if(active_tab == 'Shortlisted For'  && $('#isbuttobclick').val()=='1' )
					{
						var jobMsg = "You haven't been shorlisted for a job yet.";
					}
					else if(active_tab == 'Selected For Interview'  && $('#isbuttobclick').val()=='1')
					{
						var jobMsg = "You haven't been selected for a job interview yet.";
					}
					else if(active_tab == 'Offered Jobs'  && $('#isbuttobclick').val()=='1')
					{
						var jobMsg = "You haven't been offered jobs yet.";
					}
					else if(active_tab == 'Rejected by Me'  && $('#isbuttobclick').val()=='1')
					{
						var jobMsg = "You Rejected by this jobs yet.";
					}
					else if(active_tab == 'Rejected by Employer'  && $('#isbuttobclick').val()=='1')
					{
						var jobMsg = "You have this Job Rejected by Admin.";
					}
					else
					{
						var jobMsg = "No More Jobs Found.";
					}
					$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">'+jobMsg+'</h3></div>');
				}
				$(window).scroll(scrollFunction);
				$('#btn_searchJobs').removeAttr("disabled");
				
			}
		});
		$("#call_count").val(a+1);
	}
	function showJobDetail(jobId)
	{
		window.location='<?php echo base_url();?>job/jobDetail/'+jobId;
	}
</script>
<script type= "text/javascript" src = "<?php echo base_url();?>assets/js/countries.js"></script>
<script type="text/javascript">
	populateCountries("userCountry", "userState", "userCity"); //first parameter is id of country drop-down and second parameter is id of state drop-down
	/*populateCountries("country2");
	populateCountries("country2");*/
</script>
