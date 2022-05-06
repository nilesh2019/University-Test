<?php $this->load->view('admin/template/header');?>

<style>

  #ui-id-1{

  z-index: 10000 !important;

  }



  .widget .vd_panel-menu > .entypo-icon{

    background: transparent;

  }



  .vd_title-section .vd_panel-menu > .menu{

    padding:3px 15px !important;

  }

</style>

<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

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

                <li class="active">Manage Banner</li>

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



                            <?php

                            $errorLog=$this->session->userdata('errorLog');

                            $this->session->unset_userdata('errorLog');

                            if(!empty($errorLog))

                            {

                            ?>

                            <div class="row">

                                          <div class="col-sm-12">

                                            <div class="panel widget">

                                              <div class="panel-heading vd_bg-yellow">

                                                <h3 class="panel-title"> <span class="menu-icon"> <i class="icon-pie"></i> </span> Error Log </h3>

                                                <div class="vd_panel-menu">

                              <div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Minimize" data-action="minimize"> <i class="icon-minus3"></i> </div>

                              <div class=" menu entypo-icon smaller-font" data-placement="bottom" data-toggle="tooltip" data-original-title="Refresh" data-action="refresh"> <i class="icon-cycle"></i> </div>



                              <div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Close" data-action="close"> <i class="icon-cross"></i> </div>

                            </div>

                            <!-- vd_panel-menu -->

                            </div>

                            <div class="panel-body-list">

                              <div class="content-list content-image menu-action-right">

                                <div  data-rel="scroll" >

                                  <ul class="list-wrapper pd-lr-15">

                                                    <?php

                                                    foreach($errorLog['errorMessage'] as $key => $value)

                                                    {

                                                    ?>

                                                      <li>

                                                        <div class="menu-icon"></div>



                                                        <div class="menu-text">

                                                        <?php

                                                        foreach($value as $msg)

                                                        {

                                                        ?>

                                                              <div class="menu-info">Error message:- <a href="javascript:void('0');" style="cursor:default;color:red;"><?php echo $msg;?></a></div>

                                                        <?php

                                                          }

                                                        ?>

                                                        </div>



                                                        <div class="menu-text">

                                                          <div class="menu-info">Error on line no:- <a href="javascript:void('0');" style="cursor:default;color:red;"><?php echo $key;?></a></div>

                                                        </div>

                                                      </li>

                                                             <?php

                                                             }

                                                      ?>

                                               </ul>

                                             </div>

                                           </div>

                                         </div>

                                       </div>

                                            <!-- Panel Widget -->



                                          </div>

                                        </div>

                                <?php } ?>



          <div class="vd_content-section clearfix">

            <div class="row">

              <div class="col-md-12">

                <div class="panel widget">

                  <div class="panel-heading vd_bg-grey">

                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage Banner Table</h3>



                  </div>

                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">

                         <center>

                    <?php $this->load->view('admin/banner/addedit_view');?>

                    </center>

                    

                      <form action="<?php echo base_url();?>admin/banner/multiselect_action" method="post" name="myform" id="myform">



                            <table id="example" class="display" cellspacing="0" width="100%">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Name</th>

                                    <th>Banner</th>

                                    <th>Action</th>

                                </tr>

                            </thead>
                            <tbody style="border: 1px solid rgb(238, 238, 238);">
                              <tr role="row" class="odd" style="background-color: #E2E4FF;height: 100px;">
                                <td>1</td>
                                <td><a target="_blank" href="#">Slider1</a>
                                </td>
                                <td><img width="100" height="70" src="https://www.creosouls.com/uploads/arena_banner_1.jpg"></td>
                                <td><a onclick="openEditForm(1)" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></td>
                              </tr>
                              <tr role="row" class="odd" style="background-color: white;height: 100px;">
                                <td>2</td>
                                <td><a target="_blank" href="#">Slider2</a>
                                </td>
                                <td><img width="100" height="70" src="https://www.creosouls.com/uploads/arena_banner_2.jpg"></td>
                                <td><a onclick="openEditForm(2)" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></td>
                              </tr>
                              <tr role="row" class="odd" style="background-color: #E2E4FF;height: 100px;">
                                <td>3</td>
                                <td><a target="_blank" href="#">Slider3</a>
                                </td>
                                <td><img width="100" height="70" src="https://www.creosouls.com/uploads/arena_banner_3.jpg"></td>
                                <td><a onclick="openEditForm(3)" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></td>
                              </tr>
                              <tr role="row" class="odd" style="background-color: white;height: 100px;">
                                <td>4</td>
                                <td><a target="_blank" href="#">Slider4</a>
                                </td>
                                <td><img width="100" height="70" src="https://www.creosouls.com/uploads/arena_banner_4.jpg"></td>
                                <td><a onclick="openEditForm(4)" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></td>
                              </tr>
                              <tr role="row" class="odd" style="background-color: #E2E4FF;height: 100px;">
                                <td>5</td>
                                <td><a target="_blank" href="#">Slider5</a>
                                </td>
                                <td><img width="100" height="70" src="https://www.creosouls.com/uploads/arena_banner_5.jpg"></td>
                                <td><a onclick="openEditForm(5)" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></td>
                              </tr>
                              
                            </tbody>
                            </table>

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



<script type="text/javascript" language="javascript" >


$(document).ready(function()

{

   $("#check").click(function(){

    var checked_status = this.checked;

    $("#myform input[type=checkbox]").each(function(){

      this.checked = checked_status;

    });

   });


     $('#addInstitute').click(function()
      {
        $('#myModal #myModalLabel').text('Add New Event');
       	  $('#coverPreview').attr('src','#');
      	 	$('#banner').val('');
       	 	$('.vd_red').remove();
       	 	$('.alert-danger').css('display','none');
      });





});

    </script>

<!-- Specific Page Scripts END -->





  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/lightbox/themes/default/jquery.lightbox.css" />

  <!--[if IE 6]>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lightbox/themes/default/jquery.lightbox.ie6.css" />

  <![endif]-->









       <script>

       $(document).ready(function() {



               "use strict";
               console.log(" Form!");


               var registerInstituteForm = $('#instituteRegistrationForm');

               var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);

               var success_registerInstituteForm = $('.alert-success', registerInstituteForm);



               registerInstituteForm.validate({

                   errorElement: 'div', //default input error message container

                   errorClass: 'vd_red', // default input error message class

                   focusInvalid: false, // do not focus the last invalid input

                   onsubmit: true,

                   ignore: "",

                  

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

                       success_registerInstituteForm.hide();

                       error_registerInstituteForm.show();





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

                     $(form).find('#institute-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;

                       //success_registerInstituteForm.show();

                       //error_registerInstituteForm.hide();

                       submitForm();

                   }

               });



       });







    function submitForm(){
          console.log("Submit Form!");
        BASEURL='<?php echo base_url();?>';

        $('#institute-submit').prop("disabled", true);

        var registerInstituteForm = $('#instituteRegistrationForm');

        var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);

        var success_registerInstituteForm = $('.alert-success', registerInstituteForm);

        var formElement = document.getElementById("instituteRegistrationForm");

        var formData=new FormData(formElement);

        $.ajax({

                  url: BASEURL+"admin/banner/processForm",

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

        $('#institute-submit').prop("disabled", false);

        }

        else

        {

            if(data.status=='success')

            {

                document.getElementById("instituteRegistrationForm").reset();

                if(data.for == 'add')

                {

                window.location.href = BASEURL+'admin/banner/setFlashdata/add';

                }

                else

                {

                window.location.href = BASEURL+'admin/banner/setFlashdata/edit';

                }



            }

            else

            {

                $('.fa-spinner').remove();

                success_registerInstituteForm.hide();

                error_registerInstituteForm.show();

                $('#institute-submit').prop("disabled", false);

            }



          }



        }).fail(function( jqXHR, textStatus ) {

           alert( "Request failed: " + textStatus );

            $('#institute-submit').prop("disabled", false);

      });



    }





        function openEditForm(eventId)
        {
         
          $('#myModal #myModalLabel').text('Edit Banner');

          $.blockUI.defaults.css = {

                      padding: 0,

                      margin: 0,

                      width: 'auto',

                      top: '40%',

                      left: '45%',

                      textAlign: 'center',

                      cursor: 'wait'

          };

          $.ajax({

            url: '<?php echo base_url();?>admin/banner/getEditFormData',

            type: 'POST',

            data: {eventId:eventId},

          })

          .done(function(responce) {

            var data=jQuery.parseJSON(responce);
            $.each(data, function(index, val)
            {

                if(index == 'imageName')

                {

                  var base_url='<?php echo front_base_url();?>';
                  
                  var img='https://www.creosouls.com/testarena/uploads/'+val;

                  $('#coverPreview').attr('src', img);

                }

                else

                {

                  $("input[name='"+index+"']").val(val);

                }

                

            });

                $('#eventId').val(eventId);

                $('#myModal').modal('show');

                $.unblockUI();

          })
          
        }
        




        function readURL(input) {

          //console.log($(input).siblings('.preview'));

            if (input.files && input.files[0]) {

                var reader = new FileReader();



                reader.onload = function (e) {

                    $(input).siblings('.preview').attr('src', e.target.result);

                }



                reader.readAsDataURL(input.files[0]);

            }

        }



/*function getAutocomplete(instituteId)

{

          var base_url='<?php echo front_base_url();?>';

          $.ajax({

            url: base_url+'creosouls_admin/admin/competition/getAutocompleteUserData',

            type: 'POST',

            data: {instituteId: instituteId},

          })

          .done(function(response) {

            data_image=jQuery.parseJSON(response);

            $( "#adminEmail" ).autocomplete({

                minLength: 0,

                source: data_image,

                focus: function( event, ui ) {

                $( "#adminEmail" ).val( ui.item.label );

                  return false;

                },select: function( event, ui )

                {

                  console.log(ui.item);

                    $( "#adminId" ).val( ui.item.userId );

                }

              })

              .data( "ui-autocomplete" )._renderItem = function( ul, item ) {

                return $( "<li>" )

                .append( "<a href='javascript:void(0)'><span class='menu-icon'><img src='" + item.icon + "'></span><span class='menu-text'>" + item.label + "<span class='menu-info'>" + item.desc + "</span></span></a>" )

                .appendTo( ul );

              };

          });

}

*/

  </script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


</body>



</html>

