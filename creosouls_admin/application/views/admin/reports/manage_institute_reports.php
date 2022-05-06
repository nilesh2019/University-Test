<?php $this->load->view('admin/template/header');?>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/css/jquery.tokenize.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/dist/cropper.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>backend_assets/css/main.css" rel="stylesheet">
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css">

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
              <li><a href="<?php echo base_url();?>admin">Home</a> </li>
              <li class="active">Reports</li>
            </ul>
            <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
              <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
              <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
              <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>
            </div>
          </div>
         </div>
          <div class="vd_title-section clearfix">
            <div class="panel widget">
              <div class="panel-heading vd_bg-grey">
                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Institute Report</h3>
              </div>
              <div class="panel-body" style="border: 1px solid #eee;">
                <form method='POST' id="institute_report" action='institute_report'>
                  <div class="row">                  
                    <div class="col-md-4">
                      <div class="label-wrapper ">
                        <label class="control-label" for="instituteName">Select Zone</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> 
                        <select  class="form-control getregion_list" name="zone" id="zone">
                          <option value="" >All</option>
                          <?php if(!empty($zoneData))
                          { 
                            foreach($zoneData as $zone1){  ?>
                            <option value="<?php echo $zone1->id;?>"><?php echo $zone1->zone_name;?></option>
                         <?php  } 
                          }?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="label-wrapper ">
                        <label class="control-label" for="instituteName">Select Region</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> 
                        <select  class="form-control setregion_list" name="region" id="region">
                          <option value="" >All</option>                        
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="label-wrapper ">
                        <label class="control-label" for="instituteName">From Date</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper">
                        <input type="text" placeholder="Start Date" readonly="true" id="start_date" name="start_date" class="required start_date">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="label-wrapper ">
                        <label class="control-label" for="instituteName">To Date</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> 
                        <input type="text" placeholder="End Date" readonly="true" id="end_date" name="end_date" class="required end_date">
                      </div>
                    </div>                   
                    <div class="col-md-4">
                      <div class="label-wrapper ">
                        <label class="control-label" for="instituteName">Select Status</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> 
                        <select  class="form-control" name="institute_status" id="institute_status">
                          <option value=''>Select </option>
                          <option value='1'>Activate </option>
                          <option value='0'>Deactivate </option>
                        </select>
                      </div>
                    </div>
                  </div><br>
                  <div class="form-group clearfix">
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button class="btn btn-primary show_report" type="button" id="institute-submit">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="vd_title-section clearfix">
            <div class="panel widget report_div">
              <div class="panel-heading vd_bg-grey">
                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Institute Report Table</h3>
                 <a href="<?php echo base_url();?>admin/reports/exportinstitutedata/<?php echo (isset($zoneid) && !empty($zoneid))?$zoneid:''; ?>/<?php echo (isset($regionid) && !empty($regionid))?$regionid:''; ?>/<?php echo (isset($start_date) && !empty($start_date))?$start_date:''; ?>/<?php echo (isset($end_date) && !empty($end_date))?$end_date:''; ?>/<?php echo (isset($institute_status) && !empty($institute_status))?$institute_status:''; ?>" class="btn btn-info btn-sm pull-right" style="margin-top: -25px;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export institute To CSV</span></i></a>
              </div>
              <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                <?php
                if(isset($instituteData) && !empty($instituteData)){?>
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
                <?php } ?>
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
  </div>
  <!-- .container -->
</div>
  <!-- .content -->
  <!-- Footer Start -->
<?php $this->load->view('admin/template/footer');?>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
  <script src="<?php echo front_base_url();?>js/table-advanced.js"></script>
  <script src="<?php echo front_base_url();?>js/common.js"></script>
  <script type="text/javascript">
      var date = new Date();
      $(".start_date").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
      });

      $(".end_date").datepicker({
          format: 'yyyy-mm-dd',
          setDate: new Date(),
          autoclose: true,
      });
  </script>
  <script type="text/javascript" language="javascript" >
    $(document).ready(function() {
        TableAdvanced.init();           
    });   
  </script>
</body>
</html>