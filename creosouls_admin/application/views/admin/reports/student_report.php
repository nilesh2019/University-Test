<div class="panel-heading vd_bg-grey">
	<h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Student Report Table</h3>
	<a href="<?php echo base_url();?>admin/reports/exportstudentdata/<?php echo (isset($zone) && !empty($zone))?$zone:''; ?>/<?php echo (isset($region) && !empty($region))?$region:''; ?>/<?php echo (isset($institute_id) && !empty($institute_id))?$institute_id:''; ?>/<?php echo (isset($start_date) && !empty($start_date))?$start_date:''; ?>/<?php echo (isset($end_date) && !empty($end_date))?$end_date:''; ?>/<?php echo (isset($student_status) && !empty($student_status))?$student_status:''; ?>"  class="btn btn-info btn-sm pull-right" style="margin-top: -25px;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export Student To CSV</span></i></a>
</div>
<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
	<table id="example" class="display masterTable" cellspacing="0" width="100%">
		<thead>
		    <tr>
		        <th>#</th>
		        <th>Institute Name</th>
		        <th>Student Name</th>
		        <th>Student Id</th>
                <th>Student Email</th>
		        <th>Registation Date</th>
		        <th>Login Status</th>
		        <th>Project Count</th>
		    </tr>
		</thead>
		<tbody>	
			<?php $i=0;
		//	print_r($studentData);
			if(isset($studentData) && !empty($studentData)){
			foreach ($studentData as $key) { $i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $key['instituteName'] ?></td>
					<td>
						<?php 
						if(isset($key['email']) && !empty($key['email']))
						{?>
							<a target="_blank" href="<?php echo front_base_url();?>user/userDetail/<?php echo $key['userID']; ?>"><?php echo $key['firstName'].' '.$key['lastName'] ?></td>
						<?php }	
						else
						{
							 echo $key['firstName'].' '.$key['lastName'];
						}
						?>
					<td><?php echo $key['studentId'] ?></td>
					<td><?php echo $key['email'] ?></td>
					<td><?php echo $key['registration_date'] ?></td>
					<td><?php echo (isset($key['email']) && !empty($key['email'])?'<span class="label label-success" style="cursor: auto;">Login</span>':'<span class="label label-danger" style="cursor: auto;">Not Login</span'); ?></td>
					<td><?php echo (isset($key['project_cnt']) && !empty($key['project_cnt'])?$key['project_cnt']:'0'); ?></td>
				</tr>
			<?php } 
				} ?>	
		</tbody>
	</table>
</div>
