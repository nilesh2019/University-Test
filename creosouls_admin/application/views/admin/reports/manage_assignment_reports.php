<?php $this->load->view('admin/template/header');?>
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
            <div class="vd_content-section clearfix">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel widget">
                    <div class="panel-heading vd_bg-grey">
                      <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Assignment Reports.</h3>
                    </div>
                    <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                      <center>
                      

                      <a href="<?php echo base_url();?>admin/reports/export_manage_assignments_reports" id="addInstitute" style="float:right;margin-bottom:10px;" class="btn btn-primary">Export</a>

                      </center>

                      <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Assignment Name</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Submission Date(created)</th>
                            <th>Approval Date</th>
                            <th>Assignment Status</th>  
                          </tr>

                          <?php 
                          if(!empty($assignment))
                          {  $i=1;
                              foreach ($assignment as $key => $value) {
                                                         
                                ?>
                                    <tr>
                                        <td>
                                           <?php echo $i; ?>
                                        </td>
                                   
                                        <td>
                                            <?php echo $value['StudentName']; ?>
                                        </td>
                                    
                                        <td>
                                           <?php echo $value['AssignmentName']; ?>
                                        </td>
                                    
                                        <td>
                                            <?php echo $value['StartDate']; ?>
                                        </td>
                                   
                                        <td>
                                           <?php echo $value['EndDate']; ?>
                                        </td>
                                        <td>
                                            <?php echo $value['SubmissionDate']; ?>
                                        </td>
                                        <td>
                                            <?php echo $value['ApprovalDate']; ?>
                                        </td>
                                        <td>
                                            <?php echo $value['AssignmentStatus']; ?>
                                        </td>                                        
                                    </tr>
                                <?php                                                          
                             $i++; }    
                            }?>
                        </thead>
                      </table>
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
</body>
</html>