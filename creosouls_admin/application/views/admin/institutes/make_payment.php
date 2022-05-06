<?php $this->load->view('admin/template/header');?>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css">
<style type="text/css">
.subscription{
display: none;
}
</style>
<!-- Header Ends -->
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
                <li class="active">Make Payment View</li>
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
              <?php if($this->session->flashdata('success'))
              {
              ?>
              <div class="alert alert-success alert-dismissable alert-condensed">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                <i class="fa fa-exclamation-circle append-icon"></i><a class="alert-link" href="#"><?php echo $this->session->flashdata('success');?> </a></div>
                <?php
                }
                elseif($this->session->flashdata('error'))
                {
                ?>
                <div class="alert alert-danger alert-dismissable alert-condensed">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                  <i class="fa fa-exclamation-circle append-icon"></i><a class="alert-link" href="#"><?php echo $this->session->flashdata('error');?></a></div>
                  <?php } ?>
                </div>
                <div class="vd_content-section clearfix">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="panel widget">
                        <div class="panel-heading vd_bg-grey" style="background:rgb(8,103,185) !important;">
                          <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Make Payment</h3>
                        </div>
                        <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                          <form action="<?php echo base_url();?>admin/make_payment/multiselect_action" method="post" name="myform" id="myform">
                            <table id="example" class="display" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th><input class="case" onchange="checkValues();" type="checkbox" id="check"></th>
                                  <th>Student ID</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Email</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                            </table>
                            <strong class="subscription" style="font-size:20px;">Subscription Details</strong>
                            <div class="row subscription" style="margin: 10px 2px; box-shadow: 0px 3px 14px rgb(0, 0, 0); border-spacing: 10px; border: 2px solid green;">
                              <div class="col-xs-3">
                                <strong>Institute Name:</strong><br>
                                <?php
                                $CI =&get_instance();
                                $CI->load->model('modelbasic');
                                $instituteName=$CI->modelbasic->getValue('institute_master','instituteName','id',$instituteID);
                                echo $instituteName;
                                ?>
                              </div>
                              <div class="col-xs-4">
                                <strong>No Of Students:</strong><br>
                                <span id="quantity" style="text-align:center;">00</span>
                              </div>
                              <div class="col-xs-2">
                                <strong>Price:</strong><br>
                                <span id="price"><?php echo number_format($CI->modelbasic->getValue('settings','description','type','subscription_rate'),2);?></span> <i class="fa fa-rupee"></i>
                              </div>
                              <div class="col-xs-3">
                                <div class="text-right">
                                  <strong>Total:</strong><br>
                                  <span id="total" class="mgtp-5 vd_green font-md">00</span> <i class="fa fa-rupee mgtp-5 vd_green font-md"></i>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3" style="padding: 0px">
                                  <!-- <div class="pm-button" style="float: right; margin-right: 4px ! important;display:none;"><a href="https://test.payumoney.com/paybypayumoney/#/C089FBF36FF99062959CAADA754247E7"><img src="https://test.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div> -->
                                  <!-- <div class="pm-button" style="float: right; margin-right: 4px ! important;"><a href="https://test.payumoney.com/paybypayumoney/#/1018"><img src="https://test.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div> -->
                                  <!--   <div class="pm-button" style="float: right; margin-right: 4px ! important;"><a href="javascript:void(0);" id="payumoneybtn"><img src="https://www.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div> -->
                                  <!-- <div class="pm-button" style="float: right; margin-right: 4px ! important;display:none;"><a href="https://test.payumoney.com/paybypayumoney/#/1018"><img src="https://test.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div> -->

                                  <div class="pm-button" style="float: right; margin-right: 4px ! important;display:none;"><a href="https://www.payumoney.com/paybypayumoney/#/A6580B056BBB24F8DF8F408A1E75CFBF"><img src="https://www.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div>

                                  <!-- <div class="pm-button" style="float: right; margin-right: 4px ! important;display:none;"><a href="https://test.payumoney.com/paybypayumoney/#/1030"><img src="https://test.payumoney.com//media/images/payby_payumoney/buttons/212.png" /></a></div> -->
                                </div>
                              </div>
                            </div>
                          </form>
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
      <!-- Specific Page Scripts Put Here -->
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
      <!-- <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script> -->
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
      <script type="text/javascript" language="javascript" >
      function format ( d )
      {
      return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
        '<div class="panel-heading"> </div>'+
        '<div class="panel-body">'+
          '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Users Detail</span><br><br>'+
          '<div class="row mgbt-xs-10">'+
            '<div class="col-xs-5 text-right"> <strong>Student ID</strong> </div>'+
            '<div class="col-xs-7">  '+d.studentId+' </div>'+
          '</div>'+
          '<div class="row mgbt-xs-10">'+
            '<div class="col-xs-5 text-right"> <strong>First Name</strong> </div>'+
            '<div class="col-xs-7">  '+d.firstName+' </div>'+
          '</div>'+
          '<div class="row mgbt-xs-10">'+
            '<div class="col-xs-5 text-right"> <strong>Last Name</strong> </div>'+
            '<div class="col-xs-7">  '+d.lastName+' </div>'+
          '</div>'+
          '<div class="row mgbt-xs-10">'+
            '<div class="col-xs-5 text-right"> <strong>Email:</strong> </div>'+
            '<div class="col-xs-7">'+d.email+'</div>'+
          '</div>'+
          '<div class="row mgbt-xs-10">'+
            '<div class="col-xs-5 text-right"> <strong>Status:</strong> </div>'+
            '<div class="col-xs-7">'+d.status+'</div>'+
          '</div>'+
        '</div>'+
      '</div></div></div>';
      }
      $(document).ready(function() {
      var instituteId='<?php echo $instituteID;?>';
      var dt = $('#example').DataTable( {
      oLanguage: {
      sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
      },
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url();?>admin/make_payment/get_ajaxdataObjects/"+instituteId,
      "columns": [
      {
      "class":          "details-control",
      "orderable":      false,
      "data":           null,
      "defaultContent": ""
      },
      { "data": "chk" },
      { "data": "studentId" },
      { "data": "firstName" },
      { "data": "lastName" },
      { "data": "email" },  //columns that you want to show in table
      { "data": "status" }
      ],
      "order": [],
      columnDefs: [
      { orderable: true, targets: [2,3,4,5] },
      { orderable: false, targets: [0,1] },
      { "width": "5%", "targets": [0,1] },
      { "width": "10%", "targets": [6] },
      { "width": "20%", "targets": [2,3,4,5] }
      ],
      "fnDrawCallback": function (oSettings) {
      nbr=0;
      $(".details-control").each(function()
      {
      if(nbr > 0)
      {
      $(this).html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
      }
      nbr++;
      });
      $('tbody').css('border', '1px solid #eee');
      $('[data-rel^="switch"]').bootstrapSwitch();
      }
      } );
      // Array to track the ids of the details displayed rows
      var detailRows = [];
      $('#example tbody').on( 'click', 'tr td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = dt.row( tr );
      var idx = $.inArray( tr.attr('id'), detailRows );
      if ( row.child.isShown() ) {
      $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
      tr.removeClass( 'details' );
      row.child.hide();
      // Remove from the 'open' array
      detailRows.splice( idx, 1 );
      }
      else {
      $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_close.png">');
      tr.addClass( 'details' );
      row.child( format( row.data() ) ).show();
      // Add to the 'open' array
      if ( idx === -1 ) {
      detailRows.push( tr.attr('id') );
      }
      }
      } );
      // On each draw, loop over the `detailRows` array and show any child rows
      dt.on( 'draw', function () {
      $.each( detailRows, function ( i, id ) {
      $('#'+id+' td.details-control').trigger( 'click' );
      } );
      } );
      } );
      function checkValues()
      {

        if ($("#myform input:checkbox:checked").length > 0)
        {
              $('.pm-button').show();
        }
        else
        {
              $('.pm-button').hide();
        }

      var studentId=[];
      var i=0;
      var checkValues = $('.case:checked').map(function()
      {
      if(!isNaN(parseInt( $(this).data("index"))))
      {
      console.log(parseInt($(this).data("index")));
      studentId[i]=parseInt($(this).data("index"));
      i++;
      }
      return $(this).val();
      }).get();
      if($('.case:first').prop('checked')) {
      checkValues=checkValues.length-1;
      }
      else
      {
      checkValues=checkValues.length;
      }

      $.ajax({
      url: '<?php echo base_url();?>'+'admin/make_payment/addQty',
      type: 'POST',
      data: {checkValues: checkValues,studentId:studentId},
      })
      .done(function(data) {
      var data=jQuery.parseJSON(data);
      $('#price').html(data.rate);
      $('#quantity').html(data.quantity);
      $('#total').html(data.total);
      $('#payumoneybtn').attr('href', 'https://www.payumoney.com/paybypayumoney/#/2930780DCD53FEDEF385A964DA87DD1B');
      })
      .fail(function()
      {
      alert("Something Went Wrong Please Try Again.");
      })
      }
      $(document).ready(function()
      {
      $("#check").click(function(){
      var checked_status = this.checked;
      $("#myform input[type=checkbox]").each(function(){
      this.checked = checked_status;
      });
      });
      $('.subscription').delay(1000).show(0);
      });
      </script>
    </body>
  </html>