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
								Manage Institutes
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
					<div class="vd_content-section clearfix">
						<div class="row">
							<div class="col-md-12">
								<div class="panel widget">
									<div class="panel-heading vd_bg-grey">
										<h3 class="panel-title">
											<span class="menu-icon">
												<i class="fa fa-dot-circle-o">
												</i>
											</span>Manage Institutes Table
										</h3>
									</div>
									<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
										<center>
											<?php $this->load->view('admin/institutes/addedit_view');?>
										</center>
										<?php
										if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4){
											?>
											<button id="addInstitute" style="float:right;margin-bottom:10px;" class="btn btn-primary" onclick="getAutocomplete(0);" data-toggle="modal" data-target="#myModal">
												Register Institute
											</button>
											<?php
										} ?>
										<form action="<?php echo base_url();?>admin/institutes/multiselect_action" method="post" name="myform" id="myform">
											<table id="example" class="display table" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>
														</th>
														<th>
															<input type="checkbox" id="check">
														</th>
														<th>
															#
														</th>
														<th>
															Institute Name
														</th>
														<th>
															Institute Details
														</th>
														<th>
															Admin Name
														</th>
														<th>
															Created Date
														</th>
														<th>
															Status
														</th>
													<th <?php	if($this->session->userdata('admin_level') != 2){ echo "display:'none'";}?> >
															Action
														</th>
														
													</tr>
												</thead>
											</table>

											<?php
											if($this->session->userdata('admin_level') != 2){
												?>
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-3">
															<select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;" >
																<option value="">
																	Select Action
																</option>
																<option value="1">
																	Activate
																</option>
																<!-- <option value="2">
																	Deactivate
																</option>
																<option value="3">
																	Delete
																</option> -->
															</select>
														</div>
														<div class="col-md-2">
															<input type="submit" name="submit" value="Go" onclick="return validateForm();" class="btn btn-info-night" style="float: left;">
														</div>
														<div class="col-md-6">
														</div>
													</div>
												</div>
												<?php
											} ?>
										</form>
									</div>
								</div>
								<!-- Panel Widget -->
							</div>
							<!-- col-md-12 -->
						</div>
						<!-- row -->
					</div>
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
	function format ( d )
	{
		return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
		'<div class="panel-heading"> </div>'+
		'<div class="panel-body">'+
		'<span style="font-size:20px;font-weight:bold;margin-left:40%;">Institute Details</span><br><br>'+
		
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong></strong> </div>'+
		'<div class="col-xs-7">  '+d.instituteName+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>SAP Center Code :</strong> </div>'+
		'<div class="col-xs-7">  '+d.sap_center_code+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Zone :</strong> </div>'+
		'<div class="col-xs-7">  '+d.zone+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Region :</strong> </div>'+
		'<div class="col-xs-7">  '+d.region+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Institute Details :</strong> </div>'+
		'<div class="col-xs-7"> ------------------------   </div>'+
		'</div>'+

		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Institute Id :</strong> </div>'+
		'<div class="col-xs-7">  '+d.instituteID+' </div>'+
		'</div>'+

		
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Institute Contact :</strong> </div>'+
		'<div class="col-xs-7">  '+d.Contact+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>institute Status :</strong> </div>'+
		'<div class="col-xs-7">'+d.status+'</div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>User Details :</strong> </div>'+
		'<div class="col-xs-7"> ------------------------  </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>User Profile Image :</strong> </div>'+
		'<div class="col-xs-7">  '+d.adminprofileImage+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>User Id :</strong> </div>'+
		'<div class="col-xs-7">  '+d.adminuserId+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>User Status :</strong> </div>'+
		'<div class="col-xs-7">  '+d.adminuserStatus+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Created Date :</strong> </div>'+
		'<div class="col-xs-7">'+d.created+'</div>'+
		'</div>'+
		
		'</div><div class="panel-body"><div class="col-md-12"><table id="example2" class="example2 display" cellspacing="0" width="100%">'+
		'<thead style="background: #0c99d5 none repeat scroll 0 0 !important;">'+
		'<tr>'+
		'<th>#</th>'+
		'<th>Student ID</th>'+
		'<th>First Name</th>'+
		'<th>Last Name</th>'+
		/*'<th>Email</th>'+*/
		'<th>Status</th>'+
		'</tr>'+
		'</thead>'+
		'<tbody>'+d.institute_users+'<tbody>'+
		'</table></div>'+
		'</div></div>';
	}

	$(document).ready(function()
		{
			var dt = $('#example').DataTable(
				{
					oLanguage:
					{
						sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
					},
					"processing": true,
					"serverSide": true,
					"ajax": "<?php echo base_url();?>admin/institutes/get_ajaxdataObjects",
					"columns": [
						{
							"class":"details-control",
							"orderable": false,
							"data": null,
							"defaultContent": ""
						},

						{
							"data": "chk"
						},
						{
							"data": "id"
						},
						{
							"data": "instituteName"
						},
						{
							"data": "instituteDetails"
						},
						{
							"data": "admin_name"
						},  //columns that you want to show in table
						{
							"data": "created"
						},
						{
							"data": "status"
						},
						{
							"data": "action"
						}
					],
					"order": [],
					columnDefs: [
						{
							orderable: true, targets: [3,6,7]
						},
						{
							orderable: false, targets: [-1,0,2,1,4,5]
						},
						{
							"width": "5%", "targets": [0,1,2,6]
						},
						{
							"width": "10%", "targets": [7]
						},
						{
							"width": "15%", "targets": [-1]
						},
						{
							"width": "15%", "targets": [5,4]
						},
						{
							"width": "20%", "targets": [3]
						}
					],
					"fnDrawCallback": function (oSettings)
					{
						nbr=0;
						$(".details-control").each(function()
							{
								if(nbr > 0)
								{
									$(this).html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
								}
								nbr++;
							});

						$('tbody').css('border', '1px solid #eee');
					}
				});

			// Array to track the ids of the details displayed rows

			var detailRows = [];

			$('#example tbody').on( 'click', 'tr td.details-control', function ()
			{

					$("tr.details").each(function( index, val ) {
						$(this).next('tr').empty();
						$(this).removeClass('details');
					  	$(this).find('td.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
					});

					/*$.each($('.details'), function(index, val) {
					   $(this).next('tr').remove();
					   $(this).find('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
					   $(this).removeClass('details');
					});*/
					


					var tr = $(this).closest('tr');
					var row = dt.row( tr );
					var idx = $.inArray( tr.attr('id'), detailRows );

					if ( row.child.isShown() )
					{
						$(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
						tr.removeClass( 'details' );
						row.child.hide();

						// Remove from the 'open' array
						detailRows.splice( idx, 1 );
					}
					else
					{
						$(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_close.png">');
						tr.addClass( 'details' );
						row.child( format( row.data() ) ).show();
						$('.example2').DataTable();
						// Add to the 'open' array

						if ( idx === -1 )
						{
							detailRows.push( tr.attr('id') );
						}
					}
				});

			// On each draw, loop over the `detailRows` array and show any child rows
			dt.on( 'draw', function ()
				{
					$.each( detailRows, function ( i, id )
						{
							$('#'+id+' td.details-control').trigger( 'click' );
						});
				});

			$("#check").click(function()
				{
					var checked_status = this.checked;
					$("#myform input[type=checkbox]").each(function()
						{
							this.checked = checked_status;
						});
				});
		});

	function change_status(userId)
	{
		var done = confirm("Are you sure, you want to change the status?");
		if(done == true)
		{
			var pageurl_new = '<?php echo base_url();?>'+'admin/institutes/change_status/'+userId;
			window.location.href = pageurl_new;
		}
		else
		{
			return false;
		}
	}

	function delete_confirm(userId)
	{
		var done = confirm("Are you sure to delete this record");
		if(done == true)
		{
			var pageurl_new = '<?php echo base_url();?>'+'admin/institutes/delete_confirm/'+userId;
			window.location.href = pageurl_new;
		}
		else
		{
			return false;
		}
	}

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

			$('#addInstitute').click(function()
				{
					$('#myModal #myModalLabel').text('Register Institute');
					$('#instituteName').val('');
					$('#head_office_name').val('');
					$('#pageName').val('');
					$('#adminEmail').val('');
					$('#address').val('');
					$('#contactNo').val('');
					$('#instituteLogo').val('');
					$('#logoPreview').attr('src','#');
					$('#coverImage').val('');
					$('#coverPreview').attr('src','#');
					$('#csvUsers').val('');
					$('#adminId').val('');
					$('.vd_red').remove();
					$('.alert-danger').css('display','none');

				});

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
			var registerInstituteForm = $('#instituteRegistrationForm');
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
						instituteName:
						{
							required: true
						},
						sap_center_code:
						{
							required: true,
							number:true
						},
						pageName:
						{
							required: true
							/* remote: {
							url: '<?php echo base_url();?>'+'admin/institutes/change_st/'+$(this).val()+';',
							type: "post"
							}*/
						},
						adminEmail:
						{
							required: true,
							email: true
						},
						address:
						{
							required: true
						},
						contactNo:
						{
							required: true,
							number:true
						}
					},
					messages:
					{
						instituteName: "Institute name is required",
						sap_center_code:
						{
							required:"SAP Center Code is required",
							number:"Only numbers allowed"
						},
						pageName:
						{
							required:'Institute page display name is required'/*,
							remote:"already exist"*/
						},
						address: "Institute address is required",
						adminEmail:
						{
							required:"Institute admin email is required",
							email:"invalid email"
						},
						contactNo:
						{
							required:"Institute contact no is required",
							number:"Only numbers allowed"
						}
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
						$(form).find('#institute-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
						//success_registerInstituteForm.show();
						//error_registerInstituteForm.hide();
						submitForm();
					}
				});
		});

	function submitForm()
	{

		BASEURL='<?php echo base_url();?>';
		$('#institute-submit').prop("disabled", true);
		var registerInstituteForm = $('#instituteRegistrationForm');
		var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
		var success_registerInstituteForm = $('.alert-success', registerInstituteForm);
		// var formData = $( "#instituteRegistrationForm" ).serialize();
		var formElement = document.getElementById("instituteRegistrationForm");
		var formData=new FormData(formElement);
		$.ajax(
			{
				url: BASEURL+"admin/institutes/processForm",
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
					$('#institute-submit').prop("disabled", false);
				}
				else
				{
					if(data.status=='success')
					{
						document.getElementById("instituteRegistrationForm").reset();

						if(data.for == 'add')
						{
							window.location.href = BASEURL+'admin/institutes/setFlashdata/add';
						}
						else
						{
							window.location.href = BASEURL+'admin/institutes/setFlashdata/edit';
						}
					}
					else
					{
						$('.fa-spinner').remove();
						success_registerInstituteForm.hide();
						error_registerInstituteForm.show();
						$('#institute-submit').prop("disabled", false);
					}
				}

			}).fail(function( jqXHR, textStatus )
			{
				alert( "Request failed: " + textStatus );
				$('#institute-submit').prop("disabled", false);
			});
	}

	function openEditForm(instituteId)
	{
		getAutocomplete(instituteId);
		$.blockUI.defaults.css =
		{
			padding: 0,
			margin: 0,
			width: 'auto',
			top: '40%',
			left: '45%',
			textAlign: 'center',
			cursor: 'wait'

		};
		$('#myModal #myModalLabel').text('Edit Institute');
		$.blockUI({ message: '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"><div class="modal-dialog" style="width:300px !important;box-shadow:0 6px 7px #000;"><div class="modal-content"><div class="modal-body" style="padding-bottom:15px !important;"><img src="<?php echo base_url();?>backend_assets/img/loadings.gif"></div></div></div></div>' });

		$.ajax(
			{
				url: '<?php echo base_url();?>admin/institutes/getEditFormData',
				type: 'POST',
				data:
				{
					instituteId:instituteId
				},
			})

		.done(function(responce)
			{
				var data=jQuery.parseJSON(responce);

				$.each(data, function(index, val)
					{												
						if(index == 'zone')
						{								
							$("#zone option[value="+val+"]").attr("selected", "selected");								
							getRegionData(val,instituteId);														
						}							
						else
						{
								$("input[name='"+index+"']").val(val);
						}
					
					});

				$('#instituteId').val(instituteId);
				$('#myModal').modal('show');
				$.unblockUI();
			})
		.fail(function()
			{
				console.log("error");
			})
	}

	function getRegionData(val,instituteId)
		{		
			var base_url='<?php echo front_base_url();?>';
			var zoneId = val;
			$.ajax({
					type: "POST",
					data:{zoneId:zoneId,instituteId:instituteId},
					url: base_url+'creosouls_admin/admin/institutes/getZoneRegionList',
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

	function getAutocomplete(instituteId)
	{
		var base_url='<?php echo front_base_url();?>';
		$.ajax(
			{
				url: base_url+'creosouls_admin/admin/institutes/getAutocompleteUserData',
				type: 'POST',
				data:
				{
					instituteId: instituteId
				},
			})
		.done(function(response)
			{
				data_image=jQuery.parseJSON(response);
				$( "#adminEmail" ).autocomplete(
					{
						minLength: 0,
						source: data_image,
						focus: function( event, ui )
						{
							$( "#adminEmail" ).val( ui.item.label );
							return false;
						},select: function( event, ui )
						{
							console.log(ui.item);
							$( "#adminId" ).val( ui.item.userId );
						}
					})

				.data( "ui-autocomplete" )._renderItem = function( ul, item )
				{
					return $( "<li>" )
					.append( "<a href='javascript:void(0)'><span class='menu-icon'><img src='" + item.icon + "'></span><span class='menu-text'>" + item.label + "<span class='menu-info'>" + item.desc + "</span></span></a>" )
					.appendTo( ul );
				};
			});
	}

	function showInstDetails(val)
	{
	    $(val).closest('td').siblings('td.details-control').click();
	}

function getRegionList(element)
	{
		var zoneId=$(element).val();
		var instituteId='0';
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{zoneId:zoneId,instituteId:instituteId},
					url: base_url+'creosouls_admin/admin/institutes/getZoneRegionList',
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

</script>
</body>
</html>