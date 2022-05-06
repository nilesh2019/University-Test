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
                      <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Feedback Reports.</h3>
                    </div>
                    <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                      <center>
                      <?php
                      if($this->session->userdata('admin_level')==1)
                      {
                      if(!empty($institute)){ ?>
                      <div class="row">
                        <div class="col-md-3">
                          <select name="institute" id="institute" style="margin-top:5px;">
                            <option value="">Select Institute</option>
                            <?php foreach ($institute as $val) {
                            ?>
                            <option value="<?=$val['id']?>"><?=$val['instituteName']?></option>
                            <?php
                            }?>
                          </select>
                        </div>
                      </div>
                      <?php }
                      } ?>

                     <a href="<?php echo base_url();?>admin/reports/export_manage_feedback_reports" id="export_manage_feedback_reports" style="float:right;margin-bottom:10px;" class="btn btn-primary">Export</a>


                      </center>

                      <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                           <!--  <th style="width: 2%;">No</th> -->
                            <th>No</th>                          
                            <th>Feedback Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>                           
                            <th>Total Received</th>                           
                            <th>Total Pending</th>                           
                            <th>Action</th> 
                          </tr>

                          <?php if(!empty($feedback))
                          {  $i=1;
                              foreach ($feedback as $key => $value) {
                                if($value['id'] != '')
                                {                             
                                ?>
                                    <tr>
                                        <td>
                                           <?php echo $i; ?>
                                        </td>
                                   
                                        <td>
                                           <?php echo $value['FeedbackInstanceName']; ?>
                                        </td>
                                    
                                        <td>
                                            <?php echo $value['StartDate']; ?>
                                        </td>
                                        <td>
                                            <?php echo $value['EndDate']; ?>
                                        </td>
                                         <td>
                                           <?php echo $value['TotalFeedbackReceived']; ?>
                                        </td>
                                   
                                        <td>
                                          <?php echo $value['TotalFeedbackPending']; ?>
                                        </td>                                      
                                        <td>
                                        <a href="<?php echo base_url();?>admin/reports/export_single_feedback_reports/<?php echo $value['id']; ?>/<?php echo $value['FeedbackInstanceName']; ?>" style="float:right;margin-bottom:10px;">Export</a>
                                        </td>
                                      
                                    </tr>
                                <?php                                                          
                             $i++; }  }    
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