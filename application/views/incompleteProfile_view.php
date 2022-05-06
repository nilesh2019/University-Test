<?php $this->load->view('template/header');
//pr($detail);?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<div id="content-block">
	<div class="container be-detail-container">
		<div class="row" style="min-height:900px">
			<a class="btn" id="clickId" data-toggle="modal" data-target="#myModal">
			</a>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-controls-modal="myModal" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">
								Fill up your profile detail to continue.
							</h4>
						</div>
						<div class="modal-body form-group">
							<form method="post" action="<?php echo base_url();?>incompleteProfile" id="defaultForm">
								<div class="row">
									<input name="incompleteHidden" type="hidden" value="1">
									<?php
									if($detail[0]['firstName'] == '')
									{ ?>
										<div class="input-col col-xs-12 col-sm-12">
											<div class="form-group">
												<label>
													First Name
												</label>&nbsp;(
												<span class="error">
													*
												</span>)
												<input class="form-control" name="firstName" type="text" value="<?php echo set_value('firstName');?>">
												<small class="error">
													<?php echo form_error('firstName');?>
												</small>
											</div>
										</div>
									<?php
									}
									if($detail[0]['lastName'] == '')
									{
										?>
										<div class="input-col col-xs-12 col-sm-12">
											<div class="form-group">
												<label>
													Last Name
												</label>&nbsp;(<span class="error">*</span>)
												<input class="form-control" name="lastName" type="text" value="<?php echo set_value('lastName');?>">
												<small class="error">
													<?php echo form_error('lastName');?>
												</small>
											</div>
										</div>
										<?php
									}
									if($detail[0]['gender'] == '')
									{
										?>
										<div class="input-col col-xs-12 col-sm-12">
											<div class="form-group">
												<label>
													Gender
												</label>&nbsp;(<span class="error">*</span>)
												<br>
												<label class="radio-inline">
												    <input type="radio" name="gender" value="M" checked>Male
												</label>
												<label class="radio-inline">
												    <input type="radio" name="gender" value="F">Female
												</label>
												<small class="error">
													<?php echo form_error('gender');?>
												</small>
											</div>
										</div>
										<?php
									}
									if($detail[0]['contactNo'] == '')
									{ ?>
										<div class="input-col col-xs-12 col-sm-12">
											<div class="form-group">
												<label>
													Contact No
												</label>&nbsp;(<span class="error">*</span>)
												<input class="form-control" name="contactNo" type="text" value="<?php echo set_value('contactNo');?>">
												<small class="error">
													<?php echo form_error('contactNo');?>
												</small>
											</div>
										</div>
										<?php
									}
									if($detail[0]['city'] == '' && $this->session->userdata('studentId') == '')
									{ ?>
										<div class="input-col col-xs-12 col-sm-12">
											<div class="form-group">
												<label>
													City
												</label>&nbsp;(<span class="error">*</span>)
												<input class="form-control" name="city" type="text" value="<?php echo set_value('city');?>">
												<small class="error">
													<?php echo form_error('city');?>
												</small>
											</div>
										</div>
									<?php
									}
									if((!isset($detail[0]['type'])) || ($detail[0]['company'] == '' && $detail[0]['college'] == '' ))
									{ ?>
											<div class="input-col col-xs-12 col-sm-12">
												<div class="form-group">
													<label>
														I am a
													</label>&nbsp;(<span class="error">*</span>)
													<select name="type" class="form-control" onChange="addAtr(this.value)">
														<option value="">
															Select Type
														</option>
														<option <?php if(isset($detail[0]['type']) && $detail[0]['type'] == '0'){ echo 'selected';}?> value="0">
															Student
														</option>
														<option <?php if(isset($detail[0]['type']) && $detail[0]['type'] == '1'){ echo 'selected'; }?> value="1">
															Professional
														</option>
														<option <?php if(isset($detail[0]['type']) && $detail[0]['type'] == '2'){ echo 'selected'; }?> value="2">
															Employer
														</option>
														<option <?php if(isset($detail[0]['type']) && $detail[0]['type'] == '4'){ echo 'selected'; }?> value="4">
															Faculty
														</option>
													</select>
													<small class="error">
														<?php echo form_error('type');?>
													</small>
												</div>
											</div>
											<!--	
												<div class="input-col col-xs-12" id="college"  <?php if(isset($detail[0]['type']) && $detail[0]['type'] == 0){ ?>style="display:block;" <?php } { ?> style="display:none" <?php } ?>>
												<div class="form-group">
													<label>
														College
													</label>&nbsp;(<span class="error">*</span>)
													<input value="<?php echo ucfirst($detail[0]['college']);?>" class="form-control" name="college" type="text" placeholder="">
													<small class="error">
														<?php echo form_error('college');?>
													</small>
												</div>
												</div>
											-->
											<div class="input-col col-xs-12" id="company" <?php if(isset($detail[0]['type']) && $detail[0]['type'] == '2'){ ?>style="display:block;" <?php } { ?> style="display:none" <?php } ?>>
												<div class="form-group">
													<label>
														Company
													</label>&nbsp;(<span class="error">*</span>)
													<input value="<?php echo ucfirst($detail[0]['company']);?>" class="form-control" name="company" type="text" placeholder="">
													<small class="error">
														<?php echo form_error('company');?>
													</small>
												</div>
											</div>
									<?php 
										} 
									?>
								</div>
								<div class="modal-footer">
									<button type="submit"  class="btn btn-primary">
										Submit
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?php echo base_url();?>assets/script/formValidation.min.js">
</script>
<script src="<?php echo base_url();?>assets/script/bootstrap_framework.js">
</script>
<script>
	$(document).ready(function()
		{
			document.getElementById("clickId").click();
		});
	function addAtr(val)
	{
		var typeVal= val;
		if(typeVal==0)
		{
			$("#company").attr("style","display:none;");
		}
		else if(typeVal==1)
		{
			$("#company").attr("style","display:none;");
		}
		else if(typeVal==2)
		{
			$("#company").attr("style","display:block;");
		}
	}
	$('#defaultForm').formValidation(
		{
			message: 'This value is not valid',
			framework: 'bootstrap',
			excluded: [':disabled', ':hidden', ':not(:visible)'],
			icon:
			{
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields:
			{
				firstName:
				{
					verbose: false,
					message: 'The First Name is not valid',
					validators:
					{
						notEmpty:
						{
							message: 'The First Name is required and can\'t be empty'
						},
						stringLength:
						{
							min: 1,
							max: 40,
							message: 'First name must be more than 1 and less than 40 characters long'
						},
						regexp:
						{
							regexp: /^[a-zA-Z ]+$/,
							message: 'Please use only letters (a-z, A-Z)'
						},
					}
				},
				lastName:
				{
					verbose: false,
					message: 'The Last Name is not valid',
					validators:
					{
						notEmpty:
						{
							message: 'The Last Name is required and can\'t be empty'
						},
						stringLength:
						{
							min: 1,
							max: 40,
							message: 'Last name must be more than 1 and less than 40 characters long'
						},
						regexp:
						{
							regexp: /^[a-zA-Z ]+$/,
							message: 'Please use only letters (a-z, A-Z)'
						},
					}
				},
				contactNo:
				{
					verbose: false,
					message: 'The Contact No is not valid',
					validators:
					{
						notEmpty:
						{
							message: 'The Contact No is required and can\'t be empty'
						},
						stringLength:
						{
							min: 10,
							max: 10,
							message: 'Contact No Must Be at least 10 number'
						},
						regexp:
						{
							regexp: /^[0-9]+$/,
							message: 'Please use only Number (1-9)'
						},
					}
				},
				city:
				{
					verbose: false,
					message: 'The City is not valid',
					validators:
					{
						notEmpty:
						{
							message: 'The city is required and can\'t be empty'
						},
						stringLength:
						{
							min: 1,
							max: 40,
							message: 'City must be more than 1 and less than 40 characters long'
						},
						regexp:
						{
							regexp: /^[a-zA-Z ]+$/,
							message: 'Please use only letters (a-z, A-Z)'
						},
					}
				},
				company:
				{
					verbose: false,
					message: 'The Company field is not valid',
					validators:
					{
						stringLength:
						{
							min: 1,
							max: 100,
							message: 'The company name must be more than 1 and less than 100 characters long'
						},
						notEmpty:
						{
							message: 'The company name is required and can\'t be empty'
						},
					}
				},
				college:
				{
					verbose: false,
					message: 'The college field is not valid',
					validators:
					{
						stringLength:
						{
							min: 1,
							max: 100,
							message: 'The college name must be more than 1 and less than 100 characters long'
						},
						notEmpty:
						{
							message: 'The college name is required and can\'t be empty'
						},
					}
				},
				type:
				{
					verbose: false,
					message: 'The type field is not valid',
					validators:
					{
						notEmpty:
						{
							message: 'The type field is required and can\'t be empty'
						},
					}
				}
			}
		});
</script>