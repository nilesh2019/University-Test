<div class="panel-heading vd_bg-grey">
	<h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Institute Report Table</h3>
	   <a href="<?php echo base_url();?>admin/reports/exportinstitutedata/<?php echo (isset($zoneid) && !empty($zoneid))?$zoneid:''; ?>/<?php echo (isset($regionid) && !empty($regionid))?$regionid:''; ?>/<?php echo (isset($start_date) && !empty($start_date))?$start_date:''; ?>/<?php echo (isset($end_date) && !empty($end_date))?$end_date:''; ?>/<?php echo (isset($institute_status) && !empty($institute_status))?$institute_status:''; ?>" class="btn btn-info btn-sm pull-right" style="margin-top: -25px;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export institute To CSV</span></i></a>
</div>
<div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
   <table id="example" class="display masterTable" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Institute Name</th>
                <th>Admin Name</th>
                <th>Admin Email</th>
                <th>Project Count</th>
                <th>Ins Created Date</th>
            </tr>
        </thead>
        <tbody> 
          <?php 
          $i=0;
          foreach ($instituteData as $key) { $i++; ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo (isset($key['instituteName']) && !empty($key['instituteName']))?$key['instituteName']:''; ?></td>
              <td><?php echo ucwords((isset($key['firstName']) && !empty($key['firstName']))?$key['firstName']:''.' '.(isset($key['lastName']) && !empty($key['lastName']))?$key['lastName']:''); ?></td>
              <td><?php echo (isset($key['email']) && !empty($key['email']))?$key['email']:''; ?></td>
              <td><?php echo (isset($key['project_cnt']) && $key['project_cnt']!='')?$key['project_cnt']:''; ?></td>
              <td><?php echo date('Y-m-d',strtotime($key['created'])); ?></td>
            </tr>
          <?php } ?>  
        </tbody>
    </table>
</div>