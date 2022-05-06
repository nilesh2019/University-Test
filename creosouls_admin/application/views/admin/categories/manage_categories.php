<?php $this->load->view('admin/template/header');?>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css">
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
                <li class="active">Manage Categories</li>
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
                                    <i class="fa fa-exclamation-circle append-icon"></i><strong>Well done!</strong> <a class="alert-link" href="#"><?php echo $this->session->flashdata('success');?> </a></div>
            <?php
            }
            elseif($this->session->flashdata('error'))
            {
            ?>
            <div class="alert alert-danger alert-dismissable alert-condensed">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                            <i class="fa fa-exclamation-circle append-icon"></i><strong>Oh snap!</strong> <a class="alert-link" href="#"><?php echo $this->session->flashdata('error');?></a></div>
                            <?php } ?>
                            </div>
          <div class="vd_content-section clearfix">
            <div class="row">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage Categories Table</h3>

                  </div>
                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                       <center>
      <!--                  <a href="<?php echo base_url();?>admin/Categories/exportCategories" class="btn btn-info" style="margin-top: -2px;cursor:pointer;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export All Categories To CSV</span></i></a>
                       <a href="<?php echo base_url();?>admin/Categories/exportCategories/1" class="btn btn-success" style="margin-top: -2px;cursor:pointer;"><i class="icon-export"> <span style="font-family:'Open Sans','arial'">Export Today's Categories To CSV</span></i></a> -->
                  <!-- <a href="<?php echo base_url();?>admin/Categories/addedit_user?lightbox[width]=600&lightbox[height]=420&lightbox[modal]=true" class="lightbox">Login Box</a> -->
                 <button class="btn btn-primary " data-target="#myModal" data-toggle="modal"> Launch demo modal </button>
                  <?php $this->load->view('admin/categories/addedit_view');?>
                  </center>
                        <form action="<?php echo base_url();?>admin/categories/multiselect_action" method="post" name="myform" id="myform">

                            <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><input type="checkbox" id="check"></th>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Profile Image</th>
                                    <th>Registration Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            </table>
                                <div class="row">
                                      <div class="col-md-12">

                                            <div class="col-md-3">
                                                  <select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;" >
                                                  <option value=""> Select Action</option>
                                                  <option value="1"> Activate</option>
                                                  <option value="2"> Deactivate</option>
                                                  <option value="3"> Delete</option>
                                                  </select>
                                            </div>
                                      <div class="col-md-2">
                                            <input type="submit" name="submit" value="Go" onclick="return validateForm();" class="btn btn-info-night" style="float: left;" >
                                      </div>
                                      <div class="col-md-6">
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
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
           <script type="text/javascript" language="javascript" >
    function format ( d )
    {


           return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
            '<div class="panel-heading"> </div>'+
            '<div class="panel-body">'+
                    '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Categories Detail</span><br><br>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong></strong> </div>'+
                      '<div class="col-xs-7">'+d.profileImage+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>User Name</strong> </div>'+
                      '<div class="col-xs-7">  '+d.user_name+' </div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Email:</strong> </div>'+
                      '<div class="col-xs-7">'+d.email+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Registration Date:</strong> </div>'+
                      '<div class="col-xs-7">'+d.created+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Status:</strong> </div>'+
                      '<div class="col-xs-7">'+d.status+'</div>'+
                    '</div>'+
                  '</div></div></div>';
    }

    $(document).ready(function() {
    var dt = $('#example').DataTable( {
       oLanguage: {
                sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
         },
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url();?>admin/categories/get_ajaxdataObjects",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            { "data": "chk" },
            { "data": "id" },
            { "data": "user_name" },
            { "data": "email" },  //columns that you want to show in table
            { "data": "profileImage" },
            { "data": "created" },
            { "data": "status" },
            { "data": "action" }
        ],
        "order": [],
         columnDefs: [
           { orderable: true, targets: [3,6,7] },
           { orderable: false, targets: [-1,0,1,2,4,5] },
           { "width": "5%", "targets": [0,1,2,7] },
           { "width": "10%", "targets": [-1,5,6] },
           { "width": "20%", "targets": [3,4] }
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




      $("#check").click(function()
      {
            var checked_status = this.checked;
            $("#myform input[type=checkbox]").each(function(){
                this.checked = checked_status;
            });
     });

} );

function change_status(userId)
{
      var done = confirm("Are you sure, you want to change the status?");
      if(done == true)
      {
          var pageurl_new = '<?php echo base_url();?>'+'admin/categories/change_status/'+userId;
          window.location.href = pageurl_new;
      }
      else
      {
          return false;
      }
}


function validateForm()
{
      var total="";
      for(var i=0; i < document.myform.check.length; i++)
      {
          if(document.myform.check[i].checked)
          total +=document.myform.check[i].value + "\n";
      }
      if(total=="")
      {
          alert("Please select checkbox.");
          return false;
      }
      var listBoxSelection=document.getElementById("listaction").value;
      if(listBoxSelection==0)
      {
          alert("Please select Action");
          return false;
      }
      else
            if(listBoxSelection == 3){
            var done = confirm("Are you sure, you want to delete record's from database?");
            if(done == true){
              return true;
            }
            else
            {
              return false;
            }
      }

}

$(document).ready(function()
{
   $("#check").click(function(){
    var checked_status = this.checked;
    $("#myform input[type=checkbox]").each(function(){
      this.checked = checked_status;
    });
   });
});
    </script>
<!-- Specific Page Scripts END -->

<!--
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/lightbox/themes/default/jquery.lightbox.css" /> -->
  <!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lightbox/themes/default/jquery.lightbox.ie6.css" />
  <![endif]-->

     <script>
     $(document).ready(function() {

             "use strict";

             var form_register_2 = $('#login-form');
             var error_register_2 = $('.alert-danger', form_register_2);
             var success_register_2 = $('.alert-success', form_register_2);

             form_register_2.validate({
                 errorElement: 'div', //default input error message container
                 errorClass: 'vd_red', // default input error message class
                 focusInvalid: false, // do not focus the last invalid input
                 ignore: "",
                 rules: {
                     email: {
                         required: true,
                         email: true
                     },
                     password: {
                         required: true,
                         minlength: 6
                     },

                 },

                 errorPlacement: function(error, element) {
                     if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio")){
                         element.parent().append(error);
                     } else if (element.parent().hasClass("vd_input-wrapper")){
                         error.insertAfter(element.parent());
                     }else {
                         error.insertAfter(element);
                     }
                 },

                 invalidHandler: function (event, validator) { //display error alert on form submit
                     success_register_2.hide();
                     error_register_2.show();


                 },

                 highlight: function (element) { // hightlight error inputs

                     $(element).addClass('vd_bd-red');
                     $(element).parent().siblings('.help-inline').removeClass('help-inline hidden');
                     if ($(element).parent().hasClass("vd_checkbox") || $(element).parent().hasClass("vd_radio")) {
                         $(element).siblings('.help-inline').removeClass('help-inline hidden');
                     }

                 },

                 unhighlight: function (element) { // revert the change dony by hightlight
                     $(element)
                         .closest('.control-group').removeClass('error'); // set error class to the control group
                 },

                 success: function (label, element) {
                                    label
                         .addClass('valid').addClass('help-inline hidden') // mark the current input as valid and display OK icon
                         .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                     $(element).removeClass('vd_bd-red');

                 },

                 submitHandler: function (form) {
                   $(form).find('#login-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
                     //success_register_2.show();
                     //error_register_2.hide();
                     submitForm();
                 }
             });
$('#wysiwyghtml').wysihtml5();

     });



  function submitForm(){

                  BASEURL='<?php echo base_url();?>';
                              $('#login-submit').prop("disabled", true);
                              var form_register_2 = $('#login-form');
                              var error_register_2 = $('.alert-danger', form_register_2);
                              var success_register_2 = $('.alert-success', form_register_2);
                              var formData = $( "#login-form" ).serialize();
                              $.ajax({
                                  url: BASEURL+"admin/login",
                                  type: 'POST',
                                  data:  formData
                              }).done(function(responce)
                               {
                                          var data = jQuery.parseJSON(responce);
                                          if(data.status=='error')
                                          {
                                              $.each(data.errorfields, function()
                                              {
                                                  $.each(this, function(name, value)
                                                  {
                                                      $('[name*="'+name+'"]').html('<div class="vd_red">'+value+'</div>');
                                                  });
                                              });
                                              $('#login-submit').prop("disabled", false);
                                          }
                                          else
                                          {
                                              if(data.status=='success')
                                              {
                                                      document.getElementById("login-form").reset();
                                                      window.location.href = BASEURL+'admin/dashboard';
                                              }
                                              else
                                              {
                                                      $('.fa-spinner').remove();
                                                      success_register_2.hide();
                                                      error_register_2.show();
                                                      $('#login-submit').prop("disabled", false);
                                              }

                                          }

                              }).fail(function( jqXHR, textStatus ) {
                                  alert( "Request failed: " + textStatus );
                                    $('#login-submit').prop("disabled", false);
                              });

  }
          </script>
</body>

</html>
