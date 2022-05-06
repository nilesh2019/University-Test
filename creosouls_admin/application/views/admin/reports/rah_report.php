<div class="panel-heading vd_bg-grey">
	<h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> RAH Project Rating Report Table</h3>
	<a href="<?php echo base_url();?>admin/reports/exportrahratedata/<?php echo (isset($start_date) && !empty($start_date))?$start_date:''; ?>/<?php echo (isset($end_date) && !empty($end_date))?$end_date:''; ?>/<?php echo (isset($rah) && !empty($rah))?$rah:''; ?>"  class="btn btn-info btn-sm pull-right" style="margin-top: -25px;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export RAH Project Rating Data To CSV</span></i></a>
</div>
<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
	<table id="example" class="display masterTable" cellspacing="0" width="100%">
		<thead>
		    <tr>
		        <th>#</th>
		        <th>RAH Name</th>
		        <th>Email ID</th>
		        <th>Institute Name</th>
		        <th>Student Name</th>
				<th>Project Name</th>
                <th>Rating</th>
		        <th>Evaluation Date</th>
		    </tr>
		</thead>
		<tbody>	
			<?php $i=0;
			//echo "<pre>";print_r($rahData);exit;
			if(isset($rahrateData) && !empty($rahrateData))
			{
			foreach ($rahrateData as $key) { $i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo (isset($key['RAHNAME']) && !empty($key['RAHNAME']))?$key['RAHNAME']:''; ?></td>
					<td><?php echo (isset($key['email']) && !empty($key['email']))?$key['email']:''; ?></td>
					<td><?php echo (isset($key['instituteName']) && !empty($key['instituteName']))?$key['instituteName']:''; ?></td>
					<td><?php echo (isset($key['STUDENTNAME']) && !empty($key['STUDENTNAME']))?$key['STUDENTNAME']:''; ?></td>
					<td><?php echo (isset($key['projectName']) && !empty($key['projectName']))?$key['projectName']:''; ?></td>
					<td><?php echo (isset($key['rating']) && !empty($key['rating']))?$key['rating']:''; ?></td>
					<td><?php echo (isset($key['created']) && !empty($key['created']))?$key['created']:''; ?></td>
				</tr>
			<?php } 
				} ?>	
		</tbody>
	</table>
</div>
