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

                <li class="active">Manage Testimonials</li>

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

                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage testimonial Table</h3>



                  </div>

                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">

                       <center>

                  <?php $this->load->view('admin/testimonial/add_view');?>

                  </center>

                  <button id="addClient" onclick="clearFields()" style="float:right;margin-bottom:10px;" class="btn btn-primary " data-target="#myModal" data-toggle="modal">Add Testimonial</button>



                        <form action="<?php echo base_url();?>admin/testimonial/multiselect_action" method="post" name="myform" id="myform">



                            <table id="example" class="display" cellspacing="0" width="100%">

                            <thead>

                                <tr>

                                    <th></th>

                                    <th><input type="checkbox" id="check"></th>

                                    <th>#</th>

                                    <th>Name</th>

                                    <th>Image</th>

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

  </div>

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

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/blockUI/jquery.blockUI.js"></script>

           <script type="text/javascript" language="javascript" >

    function format ( d )

    {

           return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+

            '<div class="panel-heading"> </div>'+

            '<div class="panel-body">'+

                    '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Client Detail</span><br><br>'+



                    '<div class="row mgbt-xs-10">'+

                      '<div class="col-xs-5 text-right"> <strong>Name</strong> </div>'+

                      '<div class="col-xs-7">  '+d.name+' </div>'+

                    '</div>'+

                    '<div class="row mgbt-xs-10">'+

                      '<div class="col-xs-5 text-right"> <strong>Message:</strong> </div>'+

                      '<div class="col-xs-7">'+d.comment+'</div>'+

                    '</div>'+

                    '<div class="row mgbt-xs-10">'+

                      '<div class="col-xs-5 text-right"> <strong>Date:</strong> </div>'+

                      '<div class="col-xs-7">'+d.created+'</div>'+

                    '</div>'+

                    '<div class="row mgbt-xs-10">'+

                      '<div class="col-xs-5 text-right"> <strong>Status:</strong> </div>'+

                      '<div class="col-xs-7">'+d.status+'</div>'+

                    '</div>'+

                  '</div></div></div>';



                  return '';

    }



    $(document).ready(function() {

    var dt = $('#example').DataTable( {

       oLanguage: {

                sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"

         },

        "processing": true,

        "serverSide": true,

        "ajax": "<?php echo base_url();?>admin/testimonial/get_ajaxdataObjects",

        "columns": [

            {

                "class":          "details-control",

                "orderable":      false,

                "data":           null,

                "defaultContent": ""

            },

            { "data": "chk" },

            { "data": "id" },

            { "data": "name" },

            { "data": "image" },  //columns that you want to show in table

            { "data": "status" },

            { "data": "action" }

        ],

        "order": [],

         columnDefs: [

           { orderable: true, targets: [3] },

           { orderable: false, targets: [-1,0,1,2,4,5] },

           { "width": "5%", "targets": [0,1,2,] },

           { "width": "10%", "targets": [5] },

           { "width": "15%", "targets": [-1] },

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

      $.each($('.details'), function(index, val) {
                   $(this).next('tr').remove();
                   $(this).find('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
                   $(this).removeClass('details');
                });
      
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

          var pageurl_new = '<?php echo base_url();?>'+'admin/testimonial/change_status/'+userId;

          window.location.href = pageurl_new;

      }

      else

      {

          return false;

      }

}



function delete_client(userId)

{

      var done = confirm("Are you sure, you want to delete the testimonial?");

      if(done == true)

      {

          var pageurl_new = '<?php echo base_url();?>'+'admin/testimonial/delete_client/'+userId;

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



     function clearFields()
     {
              $('#myModal #myModalLabel').text('Add New Testimonial');
   	  	    $('#logoPreview').attr('src','#');

	   	 	$('#name').val('');

	   	  	$('#logo').val('');

	   	 	$('#wysiwyghtml').data("wysihtml5").editor.clear();

	   	 	$('div.vd_red').remove();

       	 	$('.alert-danger').css('display','none');



	  }



$(document).ready(function()

{

   $("#check").click(function(){

    var checked_status = this.checked;

    $("#myform input[type=checkbox]").each(function(){

      this.checked = checked_status;

    });

   });



   $( "#datepicker-normal" ).datepicker({ dateFormat: 'dd-M-yy',gotoCurrent: true,minDate: 0});





















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

                     name: {

                         required: true

                     },

                    designation: {

                         required: true

                     },

                     description: {

                         required: true

                     }

                 },

                 messages: {

                         name:{

                         required: "Name is required",

                         minlength:"Job Title must be at least 10 characters in length"

                        },

                         logo:{

                         required: "Logo is required"

                        },

                        description: {

                             required: "Job Description is required"

                         /*    minlength:"Job Description must be at least 50 characters in length",

                             maxlength:"Job Description can not be at more than 5000 characters in length"*/

                         }

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

                             // var formData = $( "#login-form" ).serialize();

                              var formElement = document.getElementById("login-form");

                              var formData=new FormData(formElement);

                              $.ajax({

                                  url: BASEURL+"admin/testimonial/processForm",

                                  type: 'POST',

                                  data:  formData,

                                  cache: false,

                                  processData: false, // Don't process the files

                                  contentType: false,

                              }).done(function(responce)

                               {

                                          $('.fa-spinner').remove();

                                          var data = jQuery.parseJSON(responce);

                                          if(data.status=='error')

                                          {

                                              $.each(data.errorfields, function()

                                              {

                                                  $.each(this, function(name, value)

                                                  {

                                                      $('[name*="'+name+'"]').parent().after('<div class="vd_red">'+value+'</div>');

                                                  });

                                              });

                                              $('#login-submit').prop("disabled", false);

                                          }

                                          else

                                          {

                                              if(data.status=='success')

                                              {

                                                      document.getElementById("login-form").reset();

                                                      if(data.for == 'add')

                                                      {

                                                          window.location.href = BASEURL+'admin/testimonial/setFlashdata/add';

                                                      }

                                                      else

                                                      {

                                                          window.location.href = BASEURL+'admin/testimonial/setFlashdata/edit';

                                                      }



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





      function openEditForm(testimonialId)
      {
        $('#myModal #myModalLabel').text('Edit Testimonial');
        $.blockUI.defaults.css = {

                    padding: 0,

                    margin: 0,

                    width: 'auto',

                    top: '40%',

                    left: '45%',

                    textAlign: 'center',

                    cursor: 'wait'

                };

        $.blockUI({ message: '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"><div class="modal-dialog" style="width:300px !important;box-shadow:0 6px 7px #000;"><div class="modal-content"><div class="modal-body" style="padding-bottom:15px !important;"><img src="<?php echo base_url();?>backend_assets/img/loadings.gif"></div></div></div></div>' });

            $.ajax({

              url: '<?php echo base_url();?>admin/testimonial/getEditFormData',

              type: 'POST',

              data: {testimonialId:testimonialId},

            })

            .done(function(responce) {

              var data=jQuery.parseJSON(responce);



            $.each(data, function(index, val)

            {

                  if(index == 'message')

                  {

                        $('#wysiwyghtml').data("wysihtml5").editor.setValue(val);

                  }

                  else

                  {

                       if(index == 'image')

                        {

                              var base_url='<?php echo front_base_url();?>';

                              var img='<?php echo file_upload_base_url();?>testimonial/thumbs/'+val;

                              $('#logoPreview').attr('src', img);

                        }

                        else

                        {

                              $("input[name='"+index+"']").val(val);

                        }



                  }

            });



             $('#testimonialId').val(testimonialId);

              $('#myModal').modal('show');

              $.unblockUI();

            })

            .fail(function() {

              console.log("error");

            })

      }





      function readURL(input) {



          if (input.files && input.files[0]) {

              var reader = new FileReader();



              reader.onload = function (e) {

                  $('#logoPreview').attr('src', e.target.result);

              }



              reader.readAsDataURL(input.files[0]);

          }

      }



      $("#logo").change(function(){

          readURL(this);

      });



          </script>

</body>



</html>

