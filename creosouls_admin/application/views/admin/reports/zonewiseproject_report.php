<div class="panel-heading vd_bg-grey">
	<h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> RAH Project Rating Report Table</h3>
	<a href="<?php echo base_url();?>admin/reports/exportzonewiseprojectdata/<?php echo (isset($start_date) && !empty($start_date))?$start_date:''; ?>/<?php echo (isset($end_date) && !empty($end_date))?$end_date:''; ?>/<?php echo (isset($zone) && !empty($zone))?$zone:''; ?>/<?php echo (isset($region) && !empty($region))?$region:''; ?>/"  class="btn btn-info btn-sm pull-right" style="margin-top: -25px;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export Project Added Data To CSV</span></i></a>
</div>
<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
	<table id="example" class="display masterTable" cellspacing="0" width="100%">
		<thead>
		    <tr>
		        <th>#</th>
		        <th>Zone</th>
		        <th>Region</th>
		        <th>Institute</th>
		        <th>Student Name</th>
				<th>Project Name</th>
                <th>Created Date</th>
		    </tr>
		</thead>
		<tbody>	
			<?php $i=0;
			//echo "<pre>";print_r($rahData);exit;
			if(isset($zoneregionproject) && !empty($zoneregionproject))
			{
			foreach ($zoneregionproject as $key) { $i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo (isset($key['zone_name']) && !empty($key['zone_name']))?$key['zone_name']:''; ?></td>
					<td><?php echo (isset($key['region_name']) && !empty($key['region_name']))?$key['region_name']:''; ?></td>
					<td><?php echo (isset($key['instituteName']) && !empty($key['instituteName']))?$key['instituteName']:''; ?></td>
					<td><?php echo (isset($key['StudentName']) && !empty($key['StudentName']))?$key['StudentName']:''; ?></td>
					<td><?php echo (isset($key['projectName']) && !empty($key['projectName']))?$key['projectName']:''; ?></td>
					<td><?php echo (isset($key['created']) && !empty($key['created']))?$key['created']:''; ?></td>
				</tr>
			<?php } 
				} ?>	
		</tbody>
	</table>
</div>
