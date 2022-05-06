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
              <li class="active">Make Project Trending</li>
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
                  <i class="icon-cross">
                  </i>
                </button>
                <i class="fa fa-exclamation-circle append-icon">
                </i>
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
          <div class="vd_title-section clearfix">
            <div class="panel widget">
              <div class="panel-heading vd_bg-grey">
                <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span>Make Project Trending</h3>
              </div>
              <div class="panel-body" style="border: 1px solid #eee;">
                <form method='POST' id="make_project_trending" action='make_project_trending'>
                  <div class="row">
                    <!-- <div class="col-md-4">
                      <div class="label-wrapper">
                        <label class="control-label" for="instituteName">Enter Student Id (Eg Student000000)</label>
                      </div>
                      <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> 
                        <input type="text" class="required studentid" name="studentid" id="studentid" />
                      </div>
                    </div> -->
                    <div class="col-md-4">
                        <div class="label-wrapper ">
                          <label class="control-label" for="instituteName">&nbsp;</label>
                        </div>
                      <div class="col-md-12">
                        <button class="btn btn-primary make_project_trending" type="button" id="institute-submit">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="vd_title-section clearfix ">
               <div class="panel-heading">  
                 <h3 class="panel-title report_div" style="color: black"></h3>      
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
      $("#start_date").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
      });

      $("#end_date").datepicker({
          format: 'yyyy-mm-dd',
          setDate: new Date(),
          autoclose: true,
      });
  </script>
  <script type="text/javascript" language="javascript" >
    $(document).ready(function() {
      $('.studentid').keypress(function (e) {
          if (e.which == 13) {
           $('.make_project_trending').trigger('click');
            return false;    //<---- Add this line
          }
        });
        $(document).on('click','.make_project_trending',function(){
          var form = '#'+$(this).parents('form').attr('id');
          var url = $(form).attr('action');
          var serialize_data = $(form).serialize();
          $.ajax({
              type:'POST',
              url:'<?php echo base_url();?>'+'admin/projects/make_project_trending', 
              dataType:'html',
              data:serialize_data,
              success:function(data)
              { 
                  $(".report_div").parents('.widget').css("display","block");
                  $('.report_div').html(data);
              },
              complete:function()
              {                       
                TableAdvanced.init();
              }
          });
        });
    });   
  </script>
</body>
</html>