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
					  <a href="<?php echo base_url()?>assignment">
					    Assignment
					  </a>
					</li>					
					<li class="active">
						Manage Assignment
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
									Assignment Name
								</th>
								<th style="border: 1px solid #ccc">
									Description
								</th>
								<th style="border: 1px solid #ccc">
									Start Date
								</th>
								<th style="border: 1px solid #ccc">
									End Date
								</th>								
								<th style="border: 1px solid #ccc">
									Action
								</th>
							</tr>
						</thead>
						<tbody style="border: 1px solid #ccc">
							<?php
							//print_r($getAllUserAssignment);
							if(!empty($getAllUserAssignment))
							{
								foreach($getAllUserAssignment as $row)
								{
									?>
									<tr>
										<td>
											<?php echo $row['assignment_name'];?>
										</td>
										<td>

										<?php 

										if(strlen($row['description']) > 75)
										{
										   echo substr($row['description'], 0, 75);
										   echo "...";
										}
										else
										{
										   echo substr($row['description'], 0, 75);
										}
										 ?>  											
										</td>
										<td>
											<?php echo date("Y-m-d",strtotime($row['start_date']));?>
										</td>
										<td>
											<?php echo date("Y-m-d",strtotime($row['end_date']));?>
										</td>										
										<td>
											<a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $row['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
												<i class="fa fa-eye" style="font-size:17px;margin-left: 15px;color: #39BF87;">
												</i>
											</a>
											<a href="<?php echo base_url();?>assignment/add_assignment/<?php echo $row['id'];?>">
												<i class="fa fa-edit" style="font-size:17px;margin-left: 15px;color: #3939c6;">
												</i>
											</a>
											<a href="<?php echo base_url();?>assignment/delete/<?php echo $row['id'];?>" onclick="return delete_project(this);">
												<i class="fa fa-trash" style="font-size:17px;margin-left: 15px;color: #cc0000;">
												</i>
											</a>
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
		var r = confirm("Are you sure to change this status");
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
		var r = confirm("Are you sure to change this status");
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
		var r = confirm("Are you sure to change this status");
		if (r == true)
		{
			window.location='<?php echo base_url();?>project/status/'+id+'/'+0;
		}
	}
	
	function delete_project(obj)
	{
		if(confirm('Are you sure to want to delete this project?')==true)
		{
			return true;
		}
		else{
			return false;
		}
	}
</script>