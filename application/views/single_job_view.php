<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<style>
		.btn-default.active, .btn-default:active, .open > .dropdown-toggle.btn-default {
		    background: rgb(245,245,245) none repeat scroll 0 0 !important;
		}

		.btn-default.focus, .btn-default:focus {
		   background: rgb(245,245,245) none repeat scroll 0 0 !important;
		}
		h1{
			font-size:1.2em !important;
			font-weight: bold;
		}
		.panel-heading .btn{
			padding: 3px 15px !important;		
		}
		.panel-heading .btn{
			margin-top: -4px !important;
		}
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
						<a href="<?php echo base_url()?>">Home</a>
					</li>
					<li>
						<a href="<?php echo base_url().'job'?>">Jobs</a>
					</li>
					<li class="active"><?php echo $jobs[0]['title']?></li>
				</ol>
			</div>
			<div class="clearfix"></div>
			<div class="job_detail">
				<div class="col-lg-3 right7">
					<div class="panel panel-default job_summary">
						<div class="panel-heading">
							Job Summary
						</div>
						<div class="panel-body">
							<label>Locations:</label>
							<span>
								<?php if($jobs[0]['location']!=''){ echo $jobs[0]['location'];}else{ echo ' - ';}?>
							</span><br/><br/>
							<label>
								Experience:
							</label>
							<span>		
								<?php if( $jobs[0]['min_experience'] == $jobs[0]['max_experience']) 
								{
									echo $jobs[0]['min_experience'].' Years';														
								}else
								{
									echo $jobs[0]['min_experience'].' - '.$jobs[0]['max_experience'].' Years';
								}
								?>
							</span><br/><br/>
							<label>No of Positions:</label>
							<span>
								<?php if($jobs[0]['no_of_position']!=''){ echo $jobs[0]['no_of_position'];}else{ echo ' - ';}?>
							</span><br/><br/>
							<!-- <?php
							if($jobs[0]['keySkills'] != '')
							{
								?>
								<label>
									Keywords / Skills :
								</label>
								<span><?php echo $jobs[0]['keySkills'];?></span><br/><br/>
								<?php }?> -->							
							<label>
								Education :
							</label>
							<span>
								<?php if($jobs[0]['education']!=''){ echo $jobs[0]['education'];}else{ echo ' - ';}?>
							</span><br/><br/>
							<label>
								Function:
							</label>
							<span>
								<?php if($jobs[0]['function']!=''){ echo $jobs[0]['function'];}else{ echo ' - ';}?>
							</span><br/><br/>
							<label>
								Job Type (Job / Internship):
							</label>
							<span>
								<?php echo (!empty($jobs[0]["job_type1"]) && $jobs[0]["job_type1"]==1)?'Internship':'Job'; ?>
							</span><br/><br/>
							<label>
								Employment Type:
							</label>
							<span>
								<?php if($jobs[0]['type']!=''){ echo $jobs[0]['type'];}else{ echo ' - ';}?>
							</span><br/><br/>
							<label>
								Industry:
							</label>
							<span>
								<?php if($jobs[0]['industry']!=''){ echo $jobs[0]['industry'];}else{ echo ' - ';}?>
							</span><br/><br/>							
							<label>
								Closed On:
							</label>
							<span>
								<?php echo ucfirst(date("d M Y", strtotime($jobs[0]['close_on']))) ;?>
							</span>
						</div>
					</div>
				</div>
				<div class="col-lg-9 left7">
					<div class="panel panel-default job_disc">
						<div class="panel-heading">
							<h1 style="width: 16%;">							
								<?php echo $jobs[0]['title']?>
							</h1>
							<?php 
							if($this->session->userdata('user_institute_id')!='')
							{
								$this->CI =& get_instance();	
								$this->CI->load->model('model_basic');							
								$InstituteAdminId = $this->CI->model_basic->getData('institute_master','adminId',array('id'=>$this->session->userdata('user_institute_id')));
								if($InstituteAdminId['adminId'] != $this->session->userdata('front_user_id'))
								{
							?>

							<div class="col-lg-10 pull-right">							
							<a href="<?php echo base_url();?>job" class="btn btn_blue"><i class="fa fa-chevron-left"></i>&nbsp;Back To Jobs</a>
							
							
							<?php if($apply_status==1) { ?>
								<button class="pull-right btn btn-danger"> Applied</button>
							<?php }else  if($apply_status==2) { ?>

							 <button class="pull-right btn btn-success">Shortlisted</button>

							 <?php } else  if($apply_status==3) { ?>
							 <button class="pull-right btn btn-success"> Selected </button>

							 <?php } else if($apply_status==4) { ?>
							 <button class="pull-right btn btn-success"> Accepted </button>			

							 <?php } else if($apply_status==5) { ?>
							 <button class="pull-right btn btn-danger"> Rejected by User </button>	

							<?php } else if($apply_status==6) { ?>
							<button class="pull-right btn btn-danger"> Rejected by Employer </button>

							<?php } else if($apply_status==7) { ?>
							<button class="pull-right btn btn-warning"  style="margin-right: -10px"> Waiting for Admin Approval </button>		

							<?php } else if($apply_status==8) { ?>
							<button class="pull-right btn btn-danger"  style="margin-right: -10px" onclick="showComment('<?php echo $tempJobId; ?>');"> Rejected By Institute Admin </button>	
							 <?php }
							 else if($apply_status==11)
							 { ?>
								<button class="pull-right btn btn-warning"  style="margin-right: -10px"> Application Approved by Inst Admin & pending for RAH Approval </button>	
							<?php }
 							else if($apply_status==12)
							 { ?>
								<button class="pull-right btn btn-danger" onclick="showComment('<?php echo $tempJobId; ?>');" style="margin-right: -10px"> Application Rejected By Admin </button>	
							<?php }
							else if($apply_status==13)
							 { ?>
								<button class="pull-right btn btn-warning" style="margin-right: -10px"> Admin Approved The Application and Waiting for RPH Approval </button>	
							<?php }
							else if($apply_status==15)
							 { ?>
								<button class="pull-right btn btn-warning" style="margin-right: -10px"> RPH Approved The Application and Waiting for Employer Approval </button>	
							<?php }
							else if($apply_status==16)
							 { ?>
								<button class="pull-right btn btn-danger" onclick="showComment2('<?php echo $tempJobId; ?>');" style="margin-right: -10px">Application Rejected By RPH  </button>	
							<?php }
								else if($apply_status==18)
							 { ?>
								<a class="pull-right btn btn-success" href="<?php echo base_url(); ?>interview_test/interview_test_detail/<?php echo $interview_testdata->id; ?>/<?php echo $interview_testdata->user_id; ?>"  style="margin-right: -10px">Test Assign </a>	
							<?php }
							else{
								if($jobs[0]['close_on'] >= date('Y-m-d'))
								{?>
								<!-- <button class="pull-right btn btn-default" data-toggle="modal" data-target="#exampleModal">
									APPLY
								</button> -->
							<?php 
							//print_r($getprojectdetails);
							$checkUserHaveAccess = $this->db->select('region')->from('institute_master')->where('id',$this->session->userdata('user_institute_id'))->get()->row_array();
							$is_student_have_job_access = $this->db->select('*')->from('job_zone_relation')->where('job_id',$jobs[0]['id'])->where('region_id',$checkUserHaveAccess['region'])->get()->row_array();
							//	print_r($this->session->userdata('user_institute_id'));
							if(!empty($is_student_have_job_access))
							{
								$check_job_is_institute_only = $this->db->select('view_status,posted_by')->from('jobs')->where('id',$jobs[0]['id'])->get()->row_array();
								//	print_r($check_job_is_institute_only['view_status']);
								if(empty($getstudentAge['age']) && $getstudentAge['age']==0 || empty($getstudentAge['contactNo']) && $getstudentAge['contactNo']==0  || empty($getstudentAge['dob']) || $getstudentAge['dob']=='0000-00-00' || empty($getstudentAge['about_me']) && $getstudentAge['about_me']=='' || empty($getstudenteducation_details) || empty($getstudentskill_details) || (count($getprojectdetails))=='0' && empty($getprojectdetails)){
									$this->session->set_userdata('edit_profile_jobsId',$jobs[0]['id']);
									?>
										<button href="#" class="pull-right btn btn-default" disabled="true">APPLY</button> 
										<!-- <p class="pull-right"><a href="<?php echo base_url()?>profile/edit_profile" style='color:#00B4FF'  >Click </a>  here to Complete your profile & then only you can apply for job
										</p> -->
								<?php }
								else
								{
									if($check_job_is_institute_only['view_status'] == 0 )
									{  ?>
										<a href="<?php echo base_url();?>job/uploadResume/<?php echo $jobs[0]['id']?>" class="pull-right btn btn-default" >APPLY</a>
									<?php
									}
									else
									{
										if($check_job_is_institute_only['posted_by'] == $this->session->userdata('user_institute_id')) 
										{ ?>
											<a href="<?php echo base_url();?>job/uploadResume/<?php echo $jobs[0]['id']?>" class="pull-right btn btn-default" >APPLY</a> 
										<?php  }
									}
								}
								
							} ?>
								<!-- 	<a href="<?php echo base_url();?>job/uploadResume/<?php echo $jobs[0]['id']?>" class="pull-right btn btn-default" >APPLY</a> -->
							<?php }  } ?></div>	
							<?php } } ?>						
						</div>
							<!-- 	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">
													&times;
												</span>
											</button>
											<h4 class="modal-title" id="exampleModalLabel">
											<?php
												$CI =& get_instance();
												$CI->load->model_basic;
												$loggedInUser=$CI->model_basic->loggedInUserInfo();
											?>
												<?php echo $loggedInUser['firstName'];?> Upload Your Resume
											</h4>
										</div>
										<form method="post" action="<?php echo base_url();?>job/uploadResume" enctype="multipart/form-data">
											<div class="modal-body">											
												<div class="form-group">
													<label for="recipient-name" class="control-label">
														Select the File:
													</label>
													
													<span>(Note: Only .doc, .docx, .pdf file types are allowed.)</span>
												    <input class="file-input center-block" type="file" name="resume" required>
												    <input type="hidden" name="userId" value="<?php echo $this->session->userdata('front_user_id');?>">
												    <input type="hidden" name="jobId" value="<?php echo $jobs[0]['id']?>">
												</div>											
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Apply
												</button>
											</div>
										</form>
									</div>
								</div>
							</div> -->
						<div class="panel-body">
							<div class="media">
								<div class="media-left media-top">
									<?php
									if($jobs[0]['companyLogo'] != '')
									{
										?>
										<img src="<?php echo file_upload_base_url();?>companyLogos/<?php echo $jobs[0]['companyLogo']?>" alt="image" class="media-object img-circle">
										<?php
									}
									else
									{
										?>
										<img class="media-object img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image">
										<?php
									}?>
								</div>
								<div class="media-body">
									<h4 class="media-heading">
										<a href="#">
										<?php 
										if($jobs[0]['companyName']!='')
										{
											echo $jobs[0]['companyName'];
										}
										else{
											echo 'Company Name';
										}?>
											
										</a>
									</h4>
									<p>
										<!--<i class="fa fa-briefcase">
										</i>&nbsp;
										<a href="#">
											All Jobs by this Recruiter
										</a>
										<span class="pull-right">-->
										<span>
											Posted On: <?php echo ucfirst(date("d M Y", strtotime($jobs[0]['created']))) ;?>
										</span>
										
									</p>
								</div>
							</div>
							<?php 
								if(empty($getstudentAge['age']) && $getstudentAge['age']==0 || empty($getstudentAge['contactNo']) && $getstudentAge['contactNo']==0  || empty($getstudentAge['dob']) || $getstudentAge['dob']=='0000-00-00' || empty($getstudentAge['about_me']) && $getstudentAge['about_me']=='' || empty($getstudenteducation_details) || empty($getstudentskill_details) || (count($getprojectdetails))=='0' && empty($getprojectdetails)){ ?>
									<fieldset>
										<legend>&nbsp;Requirments To Apply For Job&nbsp;</legend>
										<?php 
										if(empty($getstudentAge['age']) && $getstudentAge['age']==0 || empty($getstudentAge['contactNo']) && $getstudentAge['contactNo']==0  || empty($getstudentAge['dob']) || $getstudentAge['dob']=='0000-00-00' || empty($getstudentAge['about_me']) && $getstudentAge['about_me']=='' || empty($getstudenteducation_details) || empty($getstudentskill_details)){
											$this->session->set_userdata('edit_profile_jobsId',$jobs[0]['id']);
											?>
												<p style="font-size: 14px;"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;<a href="<?php echo base_url()?>profile/edit_profile" style='color:#00B4FF'>Click </a>  here to Complete your profile (Need to fill Contact No, DOB, About Me, My Skills, My Education).
												</p>
										<?php }
										if((count($getprojectdetails))=='0' && empty($getprojectdetails)) 
										{?>
												<p style="font-size: 14px;"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp; Upload your Showreel by clicking on Add Projects & by selecting Showreel option. </p>
										<?php } ?>
										<h4 class="media-heading"><a href=""  style="font-size: 14px;">After fulfilling the requirment you are able to apply for job.</a></h4>
									</fieldset>
							<?php } ?>
							<fieldset>
								<legend>&nbsp;Job Description&nbsp;</legend>
								<?php echo $jobs[0]['description']?>
							</fieldset>
							<?php
							if($jobs[0]['keySkills'] != '')
							{
								$skills = explode(',',$jobs[0]['keySkills']);
								?>
								<fieldset>
									<legend>&nbsp;Key Skills&nbsp;</legend>
									<?php
									foreach($skills as $row)
									{
										?>
										<label class="filter_label">
											<?php echo $row.'&nbsp;&nbsp;&nbsp;&nbsp;';?>
										</label>
										<?php
									}?>
								</fieldset>
								<?php
							}
							if($jobs[0]['aboutCompany'] != '')
							{?>
							<fieldset>
			  					<legend>&nbsp;About Company&nbsp;</legend>
			                 	<p><?php echo $jobs[0]['aboutCompany'];?></p>
			             	</fieldset>
			             	<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="modal fade" id="RejectCommentModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="font-size: 15px;font-weight: bold">Comment</h4>
			</div>
			<div class="modal-body">
				<div  id = "rejected_comment" style="color: #4a4a4a"></div>				
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_educational_details" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				&times;
				</button>
				<h4 class="modal-title">
				Add Educational Details
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="add_edu_details" method="post" action="<?php echo base_url().'profile/saveEducationalData';?>">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										Mobile No :
									</label>
								    <input type="text" class="form-control" placeholder="Mobile No" id="contactNo" value="<?php echo (isset($getstudentAge['contactNo'])&& !empty($getstudentAge['contactNo']))? $getstudentAge['contactNo'] :'' ;?>" name="contactNo" >
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										DOB :
									</label>
								    <input type="text" class="form-control" placeholder="DOB" onchange="_calculateAge(this.value)"; readonly="true" id="dob" value="<?php echo (isset($getstudentAge['dob']) && $getstudentAge['dob']!='0000-00-00')? date('Y-m-d',strtotime($getstudentAge['dob'])):'' ;?>" name="dob" >
								    <input type="hidden" value="<?php echo $jobs[0]['id'] ?>" name="jobsId" >
				           		</div>					           		
								<div class="col-lg-1 form-group"></div>			           		
								<div class="col-lg-5 form-group">
									<label for="city" class="control-label">
										Age :
									</label>
								    <input type="text" class="form-control" placeholder="Age" readonly="true" id="age" value="<?php echo (isset($getstudentAge['age']) && !empty($getstudentAge['age']))? ucfirst($getstudentAge['age']):'' ;?>" name="age" >
				           		</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="qualification" class="control-label">
										Qualification :
									</label>
									<input type="text" class="form-control" id="qualification" name="qualification[]" value="">
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="stream" class="control-label">
										Stream :
									</label>
									<input type="text" class="form-control" id="stream" name="stream[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-5 form-group">
									<label for="from_yr" class="control-label">
										From Year :
									</label>
									<div class="input-group date from_yr" id='from_yr'>
										<input class="form-control from_yr" type="text" id="from_yr" name="from_yr[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-lg-1 form-group"></div>
								<div class="col-lg-5 form-group">
									<label for="to_year" class="control-label">
										To Year :
									</label>
									<div class="input-group date to_year" id='to_year'>
										<input class="form-control to_year" type="text" id="to_year" name="to_year[]">
										<span class="input-group-addon add-on">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-11 form-group">
									<label for="university" class="control-label">
										University / Institute :
									</label>
									<input type="text" class="form-control" id="university" name="university[]" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-2 form-group">
									<input type="submit" class="form-control btn btn-success" id="save_edu_details" name="save_edu_details" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?php echo base_url();?>assets/js/moment.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_framework.js"></script>
<script type="text/javascript">
  var date = new Date();
  $("#dob").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
  });
    $("#from_yr").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
  });
      $("#to_year").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
  });
 	function _calculateAge(birthday) 
  	{ 	// birthday is a date
  		var birthday1=new Date(birthday);
	    var ageDifMs = Date.now() - birthday1.getTime();
	    var ageDate = new Date(ageDifMs); // miliseconds from epoch
	   	// return Math.abs(ageDate.getUTCFullYear() - 1970);
	    //alert(Math.abs(ageDate.getUTCFullYear() - 1970));
	    document.getElementById('age').value = Math.abs(ageDate.getUTCFullYear() - 1970);
	}
</script>
<script type="text/javascript">
function showComment(reject_comment_Id)
{		

	$.ajax({
		url: '<?php echo base_url();?>job/get_comment',
		type: 'POST',			
		data: {reject_comment_Id: reject_comment_Id},
		success:function(html)
		{				
			$('#RejectCommentModal #rejected_comment').html(html);
			$('#RejectCommentModal').modal('show');	
		}
	});
}
function showComment1(reject_comment_Id)
{		
	$.ajax({
	url: '<?php echo base_url();?>job/get_comment1',
		type: 'POST',			
		data: {reject_comment_Id: reject_comment_Id},
		success:function(html)
		{				
			$('#RejectCommentModal #rejected_comment').html(html);
			$('#RejectCommentModal').modal('show');	
		}
	});
}
function showComment2(reject_comment_Id)
{		
	$.ajax({
	url: '<?php echo base_url();?>job/get_comment2',
		type: 'POST',			
		data: {reject_comment_Id: reject_comment_Id},
		success:function(html)
		{				
			$('#RejectCommentModal #rejected_comment').html(html);
			$('#RejectCommentModal').modal('show');	
		}
	});
}

$(document).ready(function(){
	/* Image Upload validation  */
	$('#add_edu_details').formValidation({
		framework: 'bootstrap',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		excluded:':disabled',
		err: {
			container: 'popover'
		},
		fields: {
			'contactNo': {
				validators: {
					notEmpty: {
						message: 'Contact No is required'
					},
					stringLength: {
						min: 10,
						message: 'Contact No must be of 10 digites'
					}
				}
			},
			'dob': {
				validators: {
					notEmpty: {
						message: 'Dob is required'
					}
				}
			},
			'qualification[]': {
				validators: {
					notEmpty: {
						message: 'Qualification is required'
					},
					stringLength: {
						max: 100,
						message: 'The option must be less than 100 characters long'
					}
				}
			},
			'stream[]': {
				validators: {
					notEmpty: {
					message: 'Educational stream name is required'
					},
					stringLength: {
						max: 100,
						message: 'The option must be less than 100 characters long'
					}
				}
			},
			'from_yr[]': {
				validators: {
					notEmpty: {
						message: 'Education from year required and less than to year'
					},
				date: {
					format: 'YYYY-MM-DD',
					max:'to_year[]',
					message: 'The date is not a valid'
					}
				}
			},
			'to_year[]': {
				validators: {
					notEmpty: {
						message: 'Education to year required and greater than from year'
					},
					date: {
						format: 'YYYY-MM-DD',
						min:'from_yr[]',
						message: 'The date is not a valid'
					}
				}
			},
			'university[]': {
				validators: {
					notEmpty: {
						message: 'University name is required'
					},
					stringLength: {
						max: 100,
						message: 'The option must be less than 100 characters long'
					}
				}
			}
		}
	})
});
</script>
