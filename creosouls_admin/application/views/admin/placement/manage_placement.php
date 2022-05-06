<?php $this->load->view('admin/template/header');?>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css">
<style>
	#myModal1 .modal-header{
     background: #fff none repeat scroll 0 0;
     padding: 2px 7px;
	}
	#myModal1 .modal-footer{
     background: #fff none repeat scroll 0 0;
     padding: 0 19px 12px 0;
	}
	#myModal1 .modal-body .modal1-body{
      border: 1px solid #c3c3c3;
      border-radius: 5px;
      margin: 0;
      padding: 20px;
	}
	#myModal1 .modal-body{
		padding: 15px 20px;
	}
</style>


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
									Manage Placement 
								</li>
							</ul>
							<div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
								<div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu">
									<i class="fa fa-arrows-h"></i>
								</div>
								<div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu">
									<i class="fa fa-arrows-v"></i>
								</div>
								<div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu">
									<i class="glyphicon glyphicon-fullscreen"></i>
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
										<i class="icon-cross"></i>
									</button>
									<i class="fa fa-exclamation-circle append-icon"></i>
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
						<div class="vd_content-section clearfix">
							<div class="row">
								<div class="col-md-12">
									<div class="panel widget">
										<div class="panel-heading vd_bg-grey">
											<h3 class="panel-title">
												<span class="menu-icon">
													<i class="fa fa-dot-circle-o"></i>
												</span>Manage Placement Table
											</h3>
										</div>
										<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
											<center>
												<?php $this->load->view('admin/placement/add_edit_view');?>
											</center>
											<button id="addJob" onclick="clearFields()" style="float:right;margin-bottom:10px;" class="btn btn-primary " data-target="#myModal" data-toggle="modal">
												Add New Placement
											</button>

											<!--<button class="btn btn-primary" data-target="#csvJob" data-toggle="modal"> <i class="fa  fa-file-text-o"></i> Add Placement By CSV </button>-->

											<?php //$this->load->view('admin/placement/add_csv_view');?>

											
											<center><input type="checkbox" name="featured_job" id="featured_job" value="1" ><label> &nbsp; Show Feature Placements </label></center>
											
											<form action="<?php echo base_url();?>admin/placement/multiselect_action" method="post" name="myform" id="myform">
												<table id="example" class="display" cellspacing="0" width="100%">
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
																Student
															</th>
															<th>
																Company
															</th>
															<th>
																Job Profile
															</th>
															<th>
																Created Date
															</th>
															
															<th>
																Status
															</th>
															<th>
																Action
															</th>
														</tr>
													</thead>
												</table>
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-3">
															<select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;">
																<option value="">Select Action</option>
																<option value="1">Activate</option>
																<option value="2">Deactivate</option>
																<option value="3">Delete</option>
																<option value="4"> Make Featured</option>
																<option value="5"> Make Unfeatured</option>
															</select>
														</div>
													<div class="col-md-2">
														<input type="submit" name="submit" value="Go" onclick="return validateForm();" class="btn btn-info-night" style="float: left;" >
													</div>
													<div class="col-md-6"></div>
													</div>
												</div>
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
</div>
<!-- Footer Start -->
<?php $this->load->view('admin/template/footer');?>
<!-- Specific Page Scripts Put Here -->

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/blockUI/jquery.blockUI.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/app_bs3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jscript/jquery.form.js"></script>
<script type="text/javascript" language="javascript">

function clearFields()
{
	$('#myModal #myModalLabel').text('Add New Job');
	$('#logoPreview').attr('src','#');
	$('#company').val('');
	$('#position').val('');
	$('#wysiwyghtml').data("wysihtml5").editor.clear();
	$('div.vd_red').remove();
	$('.alert-danger').css('display','none');
	
	}
</script>
<script>
	$(document).ready(function()
		{
			"use strict";
			var form_register_2 = $('#login-form');
			var error_register_2 = $('.alert-danger', form_register_2);
			var success_register_2 = $('.alert-success', form_register_2);
			form_register_2.validate(
				{
					errorElement: 'div', //default input error message container
					errorClass: 'vd_red', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: ":disabled",					
					//ignore: "",
					rules:
					{
						student_name:
						{
							required: true
						},
						company:
						{
							required: true
						},
						position:
						{
							required: true
						},
						
					},
					messages:
					{
						student_name:
						{
							required: "Student Name is required",
						},
						company:
						{
							required: "Company Name is required",
						},

						position: "Position is required",
						description:
						{
							required: "Placement Description is required",
							minlength:"Placement Description must be at least 50 characters in length",
							maxlength:"Placement Description can not be at more than 5000 characters in length"
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
						success_register_2.hide();
						error_register_2.show();
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
						$(form).find('#login-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
						//success_register_2.show();
						//error_register_2.hide();
						submitForm();
					}
				});

			$('#wysiwyghtml').wysihtml5();
		});

	function submitForm()
	{
		BASEURL='<?php echo base_url();?>';
		$('#login-submit').prop("disabled", true);
		var form_register_2 = $('#login-form');
		var error_register_2 = $('.alert-danger', form_register_2);
		var success_register_2 = $('.alert-success', form_register_2);
		// var formData = $( "#login-form" ).serialize();
		var formElement = document.getElementById("login-form");
		var formData=new FormData(formElement);
		
		$.ajax(
			{
				url: BASEURL+"admin/placement/processForm",
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
					$('#login-submit').prop("disabled", false);
				}
				else
				{
					if(data.status=='success')
					{
						document.getElementById("login-form").reset();
						if(data.for == 'add')
						{
							window.location.href = BASEURL+'admin/placement/setFlashdata/add';
						}
						else
						{
							window.location.href = BASEURL+'admin/placement/setFlashdata/edit';
						}
					}
					else
					{
						$('.fa-spinner').remove();
						success_register_2.hide();
						error_register_2.show();
						$('#login-submit').prop("disabled", false);
					}
				}

			}).fail(function( jqXHR, textStatus )
			{
				alert( "Request failed: " + textStatus );
				$('#login-submit').prop("disabled", false);
			});

	}
	
	function getRegionData(val,placementId)
	{		
		var base_url='<?php echo front_base_url();?>';
		var zoneId = val;
		$.ajax({
				type: "POST",
				data:{zoneId:zoneId,placementId:placementId},
				url: base_url+'creosouls_admin/admin/placement/getSelectedRegionList',
				success:function(data)
				{
					console.log(data);
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
	function getInstituteData(val,placementId)
	{		
		var base_url='<?php echo front_base_url();?>';
		var regionId = val;
		$.ajax({
				type: "POST",
				data:{regionId:regionId,placementId:placementId},
				url: base_url+'creosouls_admin/admin/placement/getSelectedInstList',
				success:function(data)
				{
					console.log(data);
					if(data!='')
					{
						$('#institute').html(data);
					}
					else
					{
						$('#institute').html(data);
					}
					
				}
			});		
	}
	function getStudentData(val,placementId){
		var base_url='<?php echo front_base_url();?>';
		var instId = val;
		$.ajax({
				type: "POST",
				data:{instId:instId,placementId:placementId},
				url: base_url+'creosouls_admin/admin/placement/getSelectedStudentList',
				success:function(data)
				{
					console.log(data);
					if(data!='')
					{
						$('#student').html(data);
					}
					else
					{
						$('#student').html(data);
					}
					
				}
			});	
	}
	function readURL(input)
	{

		if (input.files && input.files[0])
		{
			var reader = new FileReader();
			reader.onload = function (e)
			{
				$('#logoPreview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#logo").change(function()
		{
			readURL(this);
		});

	function getRegionList(element)
	{		
		var zoneId=$('#zone').val();
		//alert(zoneId);
		var groupId='0';
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{zoneId:zoneId,groupId:groupId},
					url: base_url+'creosouls_admin/admin/placement/getZoneRegionList',
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
	function getInstituteList(element){
		var regionId=$('#region').val();
		//alert(zoneId);
		var groupId='0';
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{regionId:regionId,groupId:groupId},
					url: base_url+'creosouls_admin/admin/placement/getRegionInstituteList',
					success:function(data)
					{
						if(data!='')
						{
							$('#institute').html(data);
						}
						else
						{
							$('#institute').html(data);
						}
				}
				});	
	}

	function getStudentList(element){
		var instId=$('#institute').val();
		//alert(zoneId);
		var groupId='0';
		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{instId:instId,groupId:groupId},
					url: base_url+'creosouls_admin/admin/placement/getInstituteStudentList',
					success:function(data)
					{
						if(data!='')
						{
							$('#student').html(data);
						}
						else
						{
							$('#student').html(data);
						}
				}
				});	
	}
	function export_job_users(jobId) {

		var base_url='<?php echo front_base_url();?>';
		$.ajax({
					type: "POST",
					data:{jobId:jobId},
					url: base_url+'creosouls_admin/admin/jobs/export_job_users',
					success:function(responce)
					{						
						var s =base_url+'export/'+responce;	
						window.location.href = s
					}
			});	
	}

</script>
<script type="text/javascript" language="javascript">
	
	function format (d)
	{
		return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
		'<div class="panel-heading"> </div>'+
		'<div class="panel-body">'+
		'<span style="font-size:20px;font-weight:bold;margin-left:40%;">Placement Detail</span><br><br>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong></strong> </div>'+
		'<div class="col-xs-7">  '+d.studentProfile+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"><strong>Student Name</strong> </div>'+
		'<div class="col-xs-7">  '+d.student+' </div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Company:</strong> </div>'+
		'<div class="col-xs-7">'+d.company+'</div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Job Profile:</strong> </div>'+
		'<div class="col-xs-7">'+d.position+'</div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Description:</strong> </div>'+
		'<div class="col-xs-7">'+d.description+'</div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Registration Date:</strong> </div>'+
		'<div class="col-xs-7">'+d.created+'</div>'+
		'</div>'+
		'<div class="row mgbt-xs-10">'+
		'<div class="col-xs-5 text-right"> <strong>Status:</strong> </div>'+
		'<div class="col-xs-7">'+d.status+'</div>'+
		'</div>'+

		'</div></div>';
	}
	$(document).ready(function()
		{
	        $('#featured_job').change(function() {
	               if ( ! this.checked) {
	                   var featured_job =0;
	                   $('#example').DataTable().destroy();
	                   renderDatatable(featured_job);
	               }
	               else{
	                var featured_job =1;
	                $('#example').DataTable().destroy();
	                renderDatatable(featured_job);
	               }
	            });
			var featured_job =0;
			renderDatatable(featured_job);
			function renderDatatable(featured_job){

			dt = $('#example').DataTable(
				{
					oLanguage:
					{
						sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
					},

					"processing": true,
					"serverSide": true,
					"ajax": "<?php echo base_url();?>admin/placement/get_ajaxdataObjects/"+featured_job,

					"columns": [
						{
							"class":          "details-control",
							"orderable":      false,
							"data":           null,
							"defaultContent": ""
						},
						{
							"data": "chk"
						},
						{
							"data": "id"
						},
						{
							"data": "student"
						},
						{
							"data": "company"
						},
						{
							"data": "position"
						},
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
							orderable: false, targets: [-1,0,1,2,4,5]
						},
						{
							"width": "5%", "targets": [0,1,2,7,8,6]
						},
						{
							"width": "10%", "targets": [5]
						},
						{
							"width": "15%", "targets": [-1]
						},
						{
							"width": "20%", "targets": [3,4]
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
		}

			var detailRows = [];

			$('#example tbody').on( 'click', 'tr td.details-control', function ()
				{
					/*$.each($('.details'), function(index, val) {
					   $(this).next('tr').remove();
					   $(this).find('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
					   $(this).removeClass('details');
					});*/

					$("tr.details").each(function( index, val ) {
						$(this).next('tr').empty();
						$(this).removeClass('details');
					  	$(this).find('td.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
					});
					

					var tr = $(this).closest('tr');
					var row = dt.row( tr );
					var idx = $.inArray( tr.attr('id'), detailRows );

					if (row.child.isShown())
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
						tr.addClass('details');
						row.child(format(row.data())).show();
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

	function openEditForm(placementId)
	{
		$('#myModal #myModalLabel').text('Edit Placement');
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
		$.blockUI({ message: '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"><div class="modal-dialog" style="width:300px !important;box-shadow:0 6px 7px #000;"><div class="modal-content"><div class="modal-body" style="padding-bottom:15px !important;"><img src="<?php echo base_url();?>backend_assets/img/loadings.gif"></div></div></div></div>' });

		$.ajax(
			{
				url: '<?php echo base_url();?>admin/placement/getEditFormData',
				type: 'POST',
				data:
				{
					placementId:placementId
				},
			})

		.done(function(responce)
			{
				var data=jQuery.parseJSON(responce);

				$.each(data, function(index, val)
					{	
						if(index == 'profile_image')
						{
						      var base_url='<?php echo front_base_url();?>';
						      var img='<?php echo file_upload_base_url();?>placement/profile_image/'+val;
						      $('#logoPreview').attr('src', img);
						}
						else if(index == 'student')
						{
							$('#student_name').val(val);
						}					
						else if(index == 'description')
						{
							$('#wysiwyghtml').data("wysihtml5").editor.setValue(val);
						}
						else if(index == 'company')
						{
							$('#company').val(val);
						}
						else(index == 'position')
						{
							$('#position').val(val);
						}
						
					});


				$('#placementId').val(placementId);
				$('#myModal').modal('show');
				$('#zone').attr('disabled','disabled');
				$('#region').attr('disabled','disabled');
				$('#institute').attr('disabled','disabled');
				$('#student').attr('disabled','disabled');
				$.unblockUI();
			})
		.fail(function()
			{
				console.log("error");
			})
	}
	function change_status(userId)
	{
		var done = confirm("Are you sure, you want to change the status?");
		if(done == true)
		{
			var pageurl_new = '<?php echo base_url();?>'+'admin/jobs/change_status/'+userId;
			window.location.href = pageurl_new;
		}
		else
		{
			return false;
		}
	}

	function user_statusChange(jobUserRelationId,status)
	{		
		var done;
		if(status==2)
		{
			done = confirm("An email will be sent to the candidate with these details. Do you want to continue?");
			if(done == true)
			{
				var pageurl_new = '<?php echo base_url();?>'+'admin/jobs/change_candidate_status/'+jobUserRelationId+'/'+status;
				var additionalMsg = $('#myModel1Text').val();	
				$.ajax({
					url: pageurl_new,
					type: 'POST',
					data: {jobUserRelationId: jobUserRelationId, status: status , additionalMsg: additionalMsg},
					async: false
				})
				.done(function(returndata) 
				{
					window.location='<?php echo base_url();?>'+'admin/jobs';
				});											
				
			}
			else
			{
				return false;
			}
		}
		else if(status==3)
		{
			done = confirm("An email will be sent to the candidate with these details. Do you want to continue?");
			if(done == true)
			{
				var pageurl_new = '<?php echo base_url();?>'+'admin/jobs/change_candidate_status/'+jobUserRelationId+'/'+status;
				var additionalMsg = $('#myModel1Text').val();	
				$.ajax({
					url: pageurl_new,
					type: 'POST',
					data: {jobUserRelationId: jobUserRelationId, status: status , additionalMsg: additionalMsg},
					async: false
				})
				.done(function(returndata) 
				{
					window.location='<?php echo base_url();?>'+'admin/jobs';
				});											
				
			}
			else
			{
				return false;
			}
		}
		else if(status==6)
		{
			done = confirm("An email will be sent to the candidate with these details. Do you want to continue?");
			if(done == true)
			{
				var pageurl_new = '<?php echo base_url();?>'+'admin/jobs/change_candidate_status/'+jobUserRelationId+'/'+status;
				var additionalMsg = $('#myModel1Text').val();	
				$.ajax({
					url: pageurl_new,
					type: 'POST',
					data: {jobUserRelationId: jobUserRelationId, status: status , additionalMsg: additionalMsg},
					async: false
				})
				.done(function(returndata) 
				{
					window.location='<?php echo base_url();?>'+'admin/jobs';
				});											
			}
			else
			{
				return false;
			}
		}
		else if(status==7)
		{
			done = confirm("Candidate will be rejected without sending an email. Do you want to continue?");
			if(done == true)
			{
				var noEmail=7;
				var pageurl_new = '<?php echo base_url();?>'+'admin/jobs/change_candidate_status/'+jobUserRelationId+'/'+status;
				var additionalMsg = $('#myModel1Text').val();	
				$.ajax({
					url: pageurl_new,
					type: 'POST',
					data: {jobUserRelationId: jobUserRelationId, status: noEmail , additionalMsg: additionalMsg},
					async: false
				})
				.done(function(returndata) 
				{
					window.location='<?php echo base_url();?>'+'admin/jobs';
				});											
			}
			else
			{
				return false;
			}
		}
	}


	function check_interview_test(userId,jobid)
	{
		var file_upload_base_url='<?php echo file_upload_base_url();?>';
		var jobid=jobid;
		var userId=userId;
		$.ajax({
			url: '<?php echo base_url();?>'+'admin/jobs/get_interview_test_image',
			type: 'POST',				
			data: {userId: userId,jobid :jobid},
		})
		.done(function(responce) {
			jobdata = jQuery.parseJSON(responce);	
			//alert(jobdata.interview_assignment_image);
			$( "#myModal_assignmentview .modal-body" ).html('<div class="modal1-body"> <img src='+file_upload_base_url+'project/thumb_big/'+jobdata.interview_assignment_image+' ></div>');			
			$('#myModal_assignmentview').modal('show');	
		});	
	}

	function user_job_change_status(jobUserRelationId,status)
	{		
		var reqStatus=status;
		var jobUserRelationId=jobUserRelationId;
		$.ajax({
			url: '<?php echo base_url();?>'+'admin/jobs/getModelInfo',
			type: 'POST',				
			data: {jobUserRelationId: jobUserRelationId,status :status},
		})
		.done(function(responce) {
			jobdata = jQuery.parseJSON(responce);	
		//alert(jobdata.status);
			if(jobdata.status == 15 && reqStatus==2)
			{
				$('#model1Close').hide();
				$( "#myModal1 .modal-body" ).html( '<div class="modal1-body"><span style="color:#f85d2c">Please put the interview details here. Like interview type (Face to face, telephonic, Skype etc.), schedule, contact person etc.</span></br><textarea id="myModel1Text" name="myModel1Text" placeholder="Please put the interview details here. Like interview type (Face to face, telephonic, Skype etc.), schedule, contact person etc."> Hello <b>'+jobdata.nameTo+ '</b>,<br /><br />Congratulations! <br/>You have been shortlisted for the job <b>'+jobdata.jobTitle+'</b> at <b>'+jobdata.companyName+'</b>.<br /> <br /><a href="<?php echo front_base_url();?>job/jobDetail/'+jobdata.jobId+'">Click here</a>  to view the job details.<br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a></div>');
				$('#myModal1').modal('show');
				$('#myModel1Text').wysihtml5();
			}
			else if(jobdata.status == 2 && reqStatus==4)
			{
				$('#myModal_assignment').modal('show');
				$("#myModal_assignment").find('.job_user_relaiton_id').val(jobUserRelationId);
				/*$( "#myModal1 .modal-body" ).html('<div class="modal1-body"> <textarea id="myModel1Text" name="myModel1Text" placeholder="Please write additional information here, eg.place: ABC , Address : XYZ.">Hello <b>'+jobdata.nameTo+' </b>,<br /><br />Congratulations! <br/> You have been selected for the job <b>'+jobdata.jobTitle+'</b> at <b>'+jobdata.companyName+'</b>.<br /><br /><a href="<?php echo front_base_url();?>job/jobDetail/'+jobdata.jobId+'">Click here</a>  to view the job details.<br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a></textarea></div>');
		*/	}
			else if((jobdata.status == 19 || jobdata.status == 2) && reqStatus==3)
			{
				$('#model1Close').hide();
				$( "#myModal1 .modal-body" ).html('<div class="modal1-body"> <textarea id="myModel1Text" name="myModel1Text" placeholder="Please write additional information here, eg.place: ABC , Address : XYZ.">Hello <b>'+jobdata.nameTo+' </b>,<br /><br />Congratulations! <br/> You have been selected for the job <b>'+jobdata.jobTitle+'</b> at <b>'+jobdata.companyName+'</b>.<br /><br /><a href="<?php echo front_base_url();?>job/jobDetail/'+jobdata.jobId+'">Click here</a>  to view the job details.<br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a></textarea></div>');
				$('#myModal1').modal('show');
				$('#myModel1Text').wysihtml5();
			}
			else if(reqStatus==6)
			{
				$( "#myModal1 .modal-body" ).html( '<div class="modal1-body"><textarea id="myModel1Text" name="myModel1Text" placeholder=""> Dear <b>'+jobdata.nameTo+ '</b>,<br /><br />Unfortunately, the requirement <b>'+jobdata.jobTitle+'</b> at <b>'+jobdata.companyName+'</b> does not exactly match your skill set. We will get back to you when we have a requirement that suits your profile.<br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a></textarea></div>');
				$('#model1Close').show();
				$('#myModal1').modal('show');
				$('#myModel1Text').wysihtml5();
			}	
		});	
		$('#model1Send').click(function(event) 
		{				
			user_statusChange(jobUserRelationId,reqStatus);	
		});			

		$('#model1Close').click(function(event) 
		{				
			user_statusChange(jobUserRelationId,7);	
		});		

	}

	function delete_Placement(placementId)
	{
		var done = confirm("Are you sure, you want to delete the placement details?");
		if(done == true)
		{
			var pageurl_new = '<?php echo base_url();?>'+'admin/placement/delete_placement/'+placementId;
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

			$( "#datepicker-normal" ).datepicker({ dateFormat: 'dd-M-yy',gotoCurrent: true,minDate: 0});
		});

	function clearFields()
	{
		$('#myModal #myModalLabel').text('Add New Job');
		$('#logoPreview').attr('src','#');
		$('#title').val('');
		$('#location').val('');
		$('#type').val('');
		$('#key_skills').val('');
		$('#education').val('');
		$('#function').val('');
		$('#industry').val('');
		$('#company_name').val('');
		$('#min_experience').val(0);
		$('#max_experience').val(0);
		$('#datepicker-normal').val('');
		$('#logo').val('');
		$('#wysiwyghtml').data("wysihtml5").editor.clear();
		$('div.vd_red').remove();
		$('.alert-danger').css('display','none');
		$('#zone').removeAttr('disabled');
		$('#region').removeAttr('disabled');
		$('#jobStatus1').removeAttr('disabled');
		$('#jobStatus2').removeAttr('disabled');
		$('#noOfPosition').removeAttr('');
	}
</script>
<!--   Multiple Image Upload Code  -->

<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.fileupload.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.fileupload-process.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.fileupload-image.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/jquery.fileupload-ui.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/multiupload/main1.js"></script>






</body>
</html>