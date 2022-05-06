<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/dataTables.bootstrap.min.css"/>
<style>
	.dataTable
	{
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
		padding: 3%;
		background: #F5F5F5;
		
	}
	.add_btn
	{
		padding: 0% 4% 2% 0%;
		float:left;
	}
	.dataTables_paginate
	{
		float: left;
	}
	.dataTable .odd {color:#212121;}
	.dataTable .input-sm { padding:0 10px;}
	.dataTable .table-hover > tbody > tr:hover { background-color: #ddd; color:#000;}
	.navbar {
    background-color:rgb(0,0,0);
	}
	.even{
		 background: #ededed none repeat scroll 0 0;
    color: #212121;
	}
	thead{
		 background: #00b4ff  none repeat scroll 0 0;
    color: #fff;
    font-weight: bold;
	}
.navbar {
    background-color:rgb(0,0,0);
	}
	.padding5b > div .col-md-12{
		padding-bottom: 5px; 
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
					
					<li class="active">
						Manage Projects
					</li>
				</ol>
			</div>
			<div class="clearfix">
			</div>
			<div class="col-lg-12">
				<div class=" add_btn" style="margin-top:10px">
					<!--<a class="btn btn-primary pull-right" href="<?php echo base_url();?>project/add_project">
						<i class="fa fa-plus">
						</i>&nbsp;Add New Project
					</a>-->
					<a class="btn btn_blue pull-left" href="<?php echo base_url();?>profile">
						<i class="fa fa-chevron-left">
						</i>&nbsp;Back To My Page
					</a>
				</div>
				<div class="col-lg-12 col-md-12 middle dataTable">
					<table id="example" class="table table-striped table-responsive table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="border: 1px solid #ccc">
									Project Name
								</th>
								<th style="border: 1px solid #ccc">
									Category
								</th>
								<th style="border: 1px solid #ccc">
									Posted Date
								</th>
								<th style="border: 1px solid #ccc">
									Status
								</th>
								<th style="border: 1px solid #ccc">
									Action
								</th>
							</tr>
						</thead>
						<tbody style="border: 1px solid #ccc">
							<?php
							if(!empty($project))
							{
								foreach($project as $row)
								{
									?>
									<tr>
										<td>
											<?php echo $row['projectName'];?>
										</td>
										<td>
											<?php echo $row['categoryName'];?>
										</td>
										<td>
											<?php echo date("Y-m-d",strtotime($row['created']));?>
										</td>
										<?php if($row['competitionId'] != 0) {?>
										<td class="padding5b">
										<?php
										if($row['status'] == 1)
										{
											?>
											<div class="row">
												<div class="col-md-12">
													<span class="label label-success" style="cursor: default;">
														Public
													</span>
												</div>
											</div>
											<?php }elseif($row['status'] == 0) {?>
											<div class="row">
												<div class="col-md-12">
													<span class="label label-danger" style="cursor: default;">
														Draft
													</span>
												</div>
											</div>
											<?php } elseif($row['status'] == 3) {
											?>
											<div class="row">
												<div class="col-md-12">
													<span class="label label-primary" style="cursor: default;">
														Private
													</span>
												</div>
											</div>
											<?php } ?>
										</td>

										<?php } elseif($row['assignmentId'] !=0) {  ?>
									
										<td class="padding5b">
										<?php

										if($row['assignment_status'] != 3)
										{											
											if($row['status'] == 1)
											{
												?>
												<div class="row">
													<div class="col-md-12">
														<span class="label label-success" style="cursor: default;">
															Public
														</span>
													</div>
												</div>												
												<?php } elseif($row['status'] == 3) {
												?>
												<div class="row">
													<div class="col-md-12">
														<span class="label label-primary" style="cursor: default;">
															Private
														</span>
													</div>
												</div>
												<?php }  } else {  ?>												
													<?php
													if($row['status'] == 1)
													{
														?>
														<div class="row">
															<div class="col-md-12">
																<span class="label label-success" style="cursor: default;">
																	Public
																</span>
															</div>
															<?php
															if($this->session->userdata('user_institute_id') != '')
															{
																?>
																<div class="col-md-12">
																	<span style="cursor: pointer" onclick="make_private('<?php echo $row['id'];?>');" class="label label-primary">
																		Make Private
																	</span>
																</div>
																<?php
															} ?>															
														</div>
														<?php
													}												
													elseif($row['status'] == 3)
													{
														if($this->session->userdata('user_institute_id') != '')
														{
															?>
															<div class="row">
																<div class="col-md-12">
																	<span class="label label-primary" style="cursor: default;">
																		Private
																	</span>
																</div>
																<div class="col-md-12">
																	<span style="cursor: pointer" onclick="make_public('<?php echo $row['id'];?>');" class="label label-success">
																		<?php if($row['admin_status'] !='' && $row['status']==3){?>
																		Pending Approval
																	<?php }else{?>
																		Make Public
																		<?php } ?>
																	</span>
																</div>																
															</div>
														  <?php
														}
													} ?>
												
											<?php	}
												?>
										</td>

										<?php } else {  ?>



										<td class="padding5b">
											<?php
											if($row['status'] == 1)
											{
												?>
												<div class="row">
													<div class="col-md-12">
														<span class="label label-success" style="cursor: default;">
															Public
														</span>
													</div>
													<?php
													if($this->session->userdata('user_institute_id') != '')
													{
														?>
														<div class="col-md-12">
															<span style="cursor: pointer" onclick="make_private('<?php echo $row['id'];?>');" class="label label-primary">
																Make Private
															</span>
														</div>
														<?php
													} ?>
													<div class="col-md-12">
														<span style="cursor: pointer" onclick="make_draft('<?php echo $row['id'];?>');" class="label label-danger">
															Make Draft
														</span>
													</div>
												</div>
												<?php
											}
											elseif($row['status'] == 0)
											{
												?>
												<div class="row">
													<div class="col-md-12">
														<span class="label label-danger" style="cursor: default;">
															Draft
														</span>
													</div>
													<?php
													if($this->session->userdata('user_institute_id') != '')
													{
														?>
														<div class="col-md-12">
															<span style="cursor: pointer" onclick="make_private('<?php echo $row['id'];?>');" class="label label-primary">
																Make Private
															</span>
														</div>
														<?php
													} ?>
													<div class="col-md-12">
														<span style="cursor: pointer" onclick="make_public('<?php echo $row['id'];?>');" class="label label-success">
														
															Make Public
														
														</span>
													</div>
												</div>
												<?php
											}
											elseif($row['status'] == 3)
											{
												if($this->session->userdata('user_institute_id') != '')
												{
													?>
													<div class="row">
														<div class="col-md-12">
															<span class="label label-primary" style="cursor: default;">
																Private
															</span>
														</div>
														<div class="col-md-12">
															<span style="cursor: pointer" onclick="make_public('<?php echo $row['id'];?>');" class="label label-success">
																<?php if($row['admin_status'] !='' && $row['status']==3){?>
																Pending Approval
															<?php }else{?>
																Make Public
																<?php } ?>
															</span>
														</div>
														<div class="col-md-12">
															<span style="cursor: pointer" onclick="make_draft('<?php echo $row['id'];?>');" class="label label-danger">
																Make Draft
															</span>
														</div>
													</div>
												  <?php
												}
											} ?>
										</td>
										<?php }  ?>
										<td>
											<a href="<?php echo base_url();?>project/projectDetail/<?php echo $row['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
												<i class="fa fa-eye" style="font-size:17px;margin-left: 15px;color: #39BF87;">
												</i>
											</a>
											
											<?php if($row['competitionId'] == 0 && $row['assignmentId'] == 0) {?>
											<a href="<?php echo base_url();?>project/edit_project/<?php echo $row['id'];?>">
												<i class="fa fa-edit" style="font-size:17px;margin-left: 15px;color: #3939c6;">
												</i>
											</a>											
											
											<a href="<?php echo base_url();?>project/delete/<?php echo $row['id'];?>" onclick="return delete_project(this);">
												<i class="fa fa-trash" style="font-size:17px;margin-left: 15px;color: #cc0000;">
												</i>
											</a>
											<?php } ?>
										</td>
									</tr>
									<?php
								}
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="clearfix">
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?php echo base_url();?>assets/script/jquery.dataTables.min.js">
</script>
<script src="<?php echo base_url();?>assets/script/dataTables.bootstrap.min.js">
</script>
<script>
	$(document).ready(function()
		{
			$('#example').DataTable();
		});
	function make_public(id)
	{
		url = $('#base_url').val();
		var r = confirm("Are you sure to change this status ?");
		if (r == true)
		{
			$.ajax(
				{
					url: url+"project/check_images_and_admin_flag",
					data:
					{
						id:id
					},
					type: "POST",
					success:function(html)
					{
						if(html!='')
						{
							var obj = $.parseJSON(html);
							if(obj.image==0 && obj.admin_flag==0)
							{
								alert("You cannot make this project public as there is no content.");
							}
							else if(obj.admin_flag==1)
							{
								window.location='<?php echo base_url();?>project/change_status/'+id+'/'+1;
							}
							else
							{
								window.location='<?php echo base_url();?>project/status/'+id+'/'+1;
							}
						}
					}
				});
		}
	}
	function make_private(id)
	{
		url = $('#base_url').val();
		var r = confirm("Are you sure to change this status ?");
		if (r == true)
		{
			$.ajax(
				{
					url: url+"project/check_project_images_exist",
					data:
					{
						id:id
					},
					type: "POST",
					success:function(html)
					{
						if(html=='yes')
						{
							window.location='<?php echo base_url();?>project/status/'+id+'/'+3;
						}
						else
						{
							alert("You cannot make this project private as there is no content.");
						}
					}
				});
		}
	}
	function make_draft(id)
	{
		url = $('#base_url').val();
		var r = confirm("Are you sure to change this status ?");
		if (r == true)
		{
			window.location='<?php echo base_url();?>project/status/'+id+'/'+0;
		}
	}
	
	function delete_project(obj)
	{
		if(confirm('Are you sure to want to delete this project ?')==true)
		{
			return true;
		}
		else{
			return false;
		}
	}
</script>