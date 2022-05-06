<?php $this->load->view('admin/template/header');?>
<style>
	#ui-id-1
	{
		z-index: 10000 !important;
	}
	.widget .vd_panel-menu > .entypo-icon
	{
		background: transparent;
	}
	.vd_title-section .vd_panel-menu > .menu
	{
		padding: 3px 15px !important;
	}
</style>

<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

<!-- Header Ends -->

<div class="content">
<div class="container">
	<?php $this->load->view('admin/template/navbar_view');?>
	<!-- Middle Content Start -->
	<div class="vd_content-wrapper">
		<div class="vd_container">
			<div class="vd_content clearfix">
				<div class="vd_head-section clearfix">
					<div class="vd_panel-header">
						<ul class="breadcrumb">
							<li>
								<a href="<?php echo base_url();?>admin">
									Home
								</a>
							</li>
							<li class="active">
								Manage notifications
							</li>
						</ul>
						<div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
							<div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu">
								<i class="fa fa-arrows-h">
								</i>
							</div>
							<div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu">
								<i class="fa fa-arrows-v">
								</i>
							</div>
							<div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu">
								<i class="glyphicon glyphicon-fullscreen">
								</i>
							</div>
						</div>
					</div>
				</div>
				<div class="vd_title-section clearfix">
					<div class="vd_panel-header">
						<?php
						if($this->session->flashdata('success')){
							?>
							<div class="alert alert-success alert-dismissable alert-condensed">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									<i class="icon-cross">
									</i>
								</button>
								<i class="fa fa-exclamation-circle append-icon">
								</i>
								<strong>
									Well done!
								</strong>
								<a class="alert-link" href="#">
									<?php echo $this->session->flashdata('success');?>
								</a>
							</div>
							<?php
						}
						elseif($this->session->flashdata('error')){
							?>
							<div class="alert alert-danger alert-dismissable alert-condensed">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									<i class="icon-cross">
									</i>
								</button>
								<i class="fa fa-exclamation-circle append-icon">
								</i>
								<strong>
									Oh snap!
								</strong>
								<a class="alert-link" href="#">
									<?php echo $this->session->flashdata('error');?>
								</a>
							</div>
							<?php
						} ?>
					</div>

					<?php
					$errorLog = $this->session->userdata('errorLog');
					$this->session->unset_userdata('errorLog');
					if(!empty($errorLog)){
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel widget">
									<div class="panel-heading vd_bg-yellow">
										<h3 class="panel-title">
											<span class="menu-icon">
												<i class="icon-pie">
												</i>
											</span>Error Log
										</h3>
										<div class="vd_panel-menu">
											<div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Minimize" data-action="minimize">
												<i class="icon-minus3">
												</i>
											</div>
											<div class=" menu entypo-icon smaller-font" data-placement="bottom" data-toggle="tooltip" data-original-title="Refresh" data-action="refresh">
												<i class="icon-cycle">
												</i>
											</div>
											<div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Close" data-action="close">
												<i class="icon-cross">
												</i>
											</div>
										</div>
										<!-- vd_panel-menu -->
									</div>
									<div class="panel-body-list">
										<div class="content-list content-image menu-action-right">
											<div  data-rel="scroll">
												<ul class="list-wrapper pd-lr-15">
													<?php
													foreach($errorLog['errorMessage'] as $key => $value){
														?>
														<li>
															<div class="menu-icon">
															</div>
															<div class="menu-text">
																<?php
																foreach($value as $msg){
																	?>
																	<div class="menu-info">
																		Error message:-
																		<a href="javascript:void('0');" style="cursor:default;color:red;">
																			<?php echo $msg;?>
																		</a>
																	</div>
																	<?php
																}
																?>
															</div>
															<div class="menu-text">
																<div class="menu-info">
																	Error on line no:-
																	<a href="javascript:void('0');" style="cursor:default;color:red;">
																		<?php echo $key + 2;?>
																	</a>
																</div>
															</div>
														</li>
														<?php
													}
													?>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<!-- Panel Widget -->
							</div>
						</div>
						<?php
					} ?>
				<center>
					<?php $this->load->view('admin/notification/addedit_view');?>
				</center>	
					<!-- .vd_content-section -->
				</div>
				<!-- .vd_content -->
			</div>
			<!-- .vd_container -->
		</div>
		<!-- .vd_content-wrapper -->
		<!-- Middle Content End -->
	</div>
	<!-- .container -->
</div>
<!-- .content -->

<!-- Footer Start -->
<?php $this->load->view('admin/template/footer');?>
<!-- Specific Page Scripts Put Here -->

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js">
</script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js">
</script>
<script type="text/javascript" language="javascript" >

	function validateForm()
	{
		var total="";
		for(var i=0; i < document.myform.check.length; i++)
		{
			if(document.myform.check[i].checked)
			total +=document.myform.check[i].value + "\n";
		}
		if(total=="")
		{
			alert("Please select checkbox.");
			return false;
		}

		var listBoxSelection=document.getElementById("listaction").value;
		if(listBoxSelection==0)
		{
			alert("Please select Action");
			return false;
		}
		else
		if(listBoxSelection == 3)
		{
			var done = confirm("Are you sure, you want to delete record's from database?");
			if(done == true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	$(document).ready(function()
		{
			$("#check").click(function()
				{
					var checked_status = this.checked;
					$("#myform input[type=checkbox]").each(function()
						{
							this.checked = checked_status;
						});
				});

			$('#myModal #myModalLabel').text('Register Notification');				
			$('#head_office_name').val('');
			$('#notification').val('');					
			$('.vd_red').remove();
			$('.alert-danger').css('display','none');
			$('#myModal').modal('show');
			
		});
</script>
<!-- Specific Page Scripts END -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/lightbox/themes/default/jquery.lightbox.css" />

<!--[if IE 6]>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lightbox/themes/default/jquery.lightbox.ie6.css" />

<![endif]-->

<script>
	$(document).ready(function()
		{
			"use strict";
			var registerInstituteForm = $('#notificationRegistrationForm');
			var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
			var success_registerInstituteForm = $('.alert-success', registerInstituteForm);

			registerInstituteForm.validate(
				{
					errorElement: 'div', //default input error message container
					errorClass: 'vd_red', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					onsubmit: true,
					ignore: "",
					rules:
					{											
						notification:
						{
							required: true
						},						
					},
					messages:
					{										
						notification: "Notification is required",
					},

					errorPlacement: function(error, element)
					{
						if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio"))
						{
							element.parent().append(error);
						} else if (element.parent().hasClass("vd_input-wrapper"))
						{
							error.insertAfter(element.parent());
						}else
						{
							error.insertAfter(element);
						}
					},
					invalidHandler: function (event, validator)
					{
						//display error alert on form submit
						success_registerInstituteForm.hide();
						error_registerInstituteForm.show();
					},

					highlight: function (element)
					{
						// hightlight error inputs
						$(element).addClass('vd_bd-red');
						$(element).parent().siblings('.help-inline').removeClass('help-inline hidden');
						if ($(element).parent().hasClass("vd_checkbox") || $(element).parent().hasClass("vd_radio"))
						{
							$(element).siblings('.help-inline').removeClass('help-inline hidden');
						}
					},
					unhighlight: function (element)
					{
						// revert the change dony by hightlight
						$(element)
						.closest('.control-group').removeClass('error'); // set error class to the control group
					},
					success: function (label, element)
					{
						label
						.addClass('valid').addClass('help-inline hidden') // mark the current input as valid and display OK icon
						.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
						$(element).removeClass('vd_bd-red');
					},
					submitHandler: function (form)
					{
						$(form).find('#notification-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
						//success_registerInstituteForm.show();
						//error_registerInstituteForm.hide();
						submitForm();
					}
				});
		});

	function submitForm()
	{
		BASEURL='<?php echo base_url();?>';
		$('#notification-submit').prop("disabled", true);
		var registerInstituteForm = $('#notificationRegistrationForm');
		var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
		var success_registerInstituteForm = $('.alert-success', registerInstituteForm);
		// var formData = $( "#notificationRegistrationForm" ).serialize();
		var formElement = document.getElementById("notificationRegistrationForm");
		var formData=new FormData(formElement);
		$.ajax(
			{
				url: BASEURL+"admin/notification/processForm",
				type: 'POST',
				data:  formData,
				cache: false,
				processData: false, // Don't process the files
				contentType: false,
			}).done(function(responce)
			{
				$('.fa-spinner').remove();
				var data = jQuery.parseJSON(responce);
				if(data.status=='error')
				{
					$.each(data.errorfields, function()
						{
							$.each(this, function(name, value)
								{
									$('[name*="'+name+'"]').parent().after('<div class="vd_red">'+value+'</div>');
								});
						});
					$('#notification-submit').prop("disabled", false);
				}
				else
				{
					if(data.status=='success')
					{
						document.getElementById("notificationRegistrationForm").reset();

						if(data.for == 'add')
						{
							window.location.href = BASEURL+'admin/notification/setFlashdata/add';
						}
						else
						{
							window.location.href = BASEURL+'admin/notification/setFlashdata/edit';
						}
					}
					else
					{
						$('.fa-spinner').remove();
						success_registerInstituteForm.hide();
						error_registerInstituteForm.show();
						$('#notification-submit').prop("disabled", false);
					}
				}

			}).fail(function( jqXHR, textStatus )
			{
				alert( "Request failed: " + textStatus );
				$('#notification-submit').prop("disabled", false);
			});
	}

	

	function getZoneData(val,notificationId)
	{		
		var base_url='<?php echo front_base_url();?>';
		var regionId = val;
		$.ajax({
				type: "POST",
				data:{regionId:regionId,notificationId:notificationId},
				url: base_url+'creosouls_admin/admin/notification/getZoneRegionList',
				success:function(data)
				{
					if(data!='')
					{
						$('#zone').html(data);
					}
					else
					{
						$('#zone').html(data);
					}
					
				}
			});		
	}

	function getInstituteData(val,notificationId)
	{		
		var base_url='<?php echo front_base_url();?>';
		var regionId = val;
		$.ajax({
				type: "POST",
				data:{regionId:regionId,notificationId:notificationId},
				url: base_url+'creosouls_admin/admin/notification/getInstituteDataList',
				success:function(data)
				{
					if(data!='')
					{
						$('#instituteId').html(data);
					}
					else
					{
						$('#instituteId').html(data);
					}
					
				}
			});		
	}

	function getGroupData(val,notificationId)
	{	   
		var institudeId = val;
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
				type: "POST",
				data:{institudeId:institudeId,notificationId:notificationId},
				url: base_url+'creosouls_admin/admin/notification/getGroupDataList',
				success:function(data)
				{
					if(data!='')
					{
						$('#groupId').html(data);
					}
					else
					{
						$('#groupId').html(data);
					}
					
				}
			});		
	}

	function readURL(input)
	{
		//console.log($(input).siblings('.preview'));
		if (input.files && input.files[0])
		{
			var reader = new FileReader();

			reader.onload = function (e)
			{
				$(input).siblings('.preview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}	

	function showInstDetails(val)
	{
	    $(val).closest('td').siblings('td.details-control').click();
	}

	function getRegionList(element)
	{		
		var zoneId=$('#zone').val();
		//alert(zoneId);
		getZoneInstituteList(zoneId);
		var notificationId='0';
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{zoneId:zoneId,notificationId:notificationId},
					url: base_url+'creosouls_admin/admin/notification/getZoneRegionList',
					success:function(data)
					{
						if(data!='')
						{
							$('#region').html(data);
						}
						else
						{
							$('#region').html(data);
						}
						
					}

			});	
	}

function getZoneInstituteList(zoneId)
{
	$.ajax({
				type: "POST",
				data:{zoneId:zoneId},
				url: base_url+'admin/notification/getZoneInstituteList',
				success:function(datas)
				{						
					if(datas!='')
					{
						$('#instituteId').html(datas);
					}
					else
					{
						$('#instituteId').html(datas);
					}
			}
	});
}

function getInstituteList(element)
	{	
		
		var regionId=$(element).val();
		var zoneId=$('#zone').val();	
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{zoneId:zoneId,regionId:regionId},
					url: base_url+'creosouls_admin/admin/notification/getRegionInstituteList',
					success:function(data)
					{						
						if(data!='')
						{
							$('#instituteId').html(data);
						}
						else
						{
							$('#instituteId').html(data);
						}
				}
		});	
	
	}

	function getGroupList(element)
		{
			var instituteId=$(element).val();
			var base_url='<?php echo front_base_url();?>';
			$.ajax({
						type: "POST",
						data:{instituteId:instituteId},
						url: base_url+'creosouls_admin/admin/notification/getInstituteGroupList',
						success:function(data)
						{						
							if(data!='')
							{
								$('#groupId').html(data);
							}
							else
							{
								$('#groupId').html(data);
							}
					}
					});	

		
		}

</script>
</body>
</html>