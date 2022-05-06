<footer class="footer-1"  id="footer">
    <div class="vd_bottom ">
        <div class="container">
            <div class="row">
              <div class=" col-xs-12">
                <div class="copyright">
                    Copyright &copy;2022 University. All Rights Reserved
                </div>
              </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>
  </footer>
<!-- Footer END -->

<!-- .vd_body END  -->
<a id="back-top" href="#" data-action="backtop" class="vd_back-top visible"> <i class="fa  fa-angle-up"> </i> </a>

<!--
<a class="back-top" href="#" id="back-top"> <i class="icon-chevron-up icon-white"> </i> </a> -->

<!-- Javascript =============================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/jquery.js"></script>
<!--[if lt IE 9]>
  <script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/caroufredsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/plugins.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/breakpoints/breakpoints.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/blockUI/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/pnotify/js/jquery.pnotify.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/theme.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/custom/custom.js"></script>

<!-- Specific Page Scripts END -->

<script>
function showDetails(val)
{
    $(val).parent('td').siblings('td.details-control').click();
}
</script>


   <script>
   $(document).ready(function() {

           "use strict";
           var form_register_2 = $('#admin-pass-form');
           var error_register_2 = $('.alert-danger', form_register_2);
           var success_register_2 = $('.alert-success', form_register_2);
           form_register_2.validate({
               errorElement: 'div', //default input error message container
               errorClass: 'vd_red', // default input error message class
               focusInvalid: false, // do not focus the last invalid input
               ignore: "",
               rules: {                  
                   chang_pass_admin: {
                       required: true
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
                 $(form).find('#admin-pass-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')
                   submitAdminPassForm();
               }
           });
   });



function submitAdminPassForm()
{
  BASEURL='<?php echo base_url();?>';
        $('#admin-pass-submit').prop("disabled", true);
        var form_register_2 = $('#admin-pass-form');
        var error_register_2 = $('.alert-danger', form_register_2);
        var success_register_2 = $('.alert-success', form_register_2);
        var formData = $( "#admin-pass-form" ).serialize();
        $.ajax({
            url: BASEURL+"admin/admin/save_change_pass",
            type: 'POST',
            data:  formData
        }).done(function(responce)
         {
            var data = jQuery.parseJSON(responce);
            console.log(data);
            if(data.status=='error')
            {
                $.each(data.errorfields, function()
                {
                    $.each(this, function(name, value)
                    {
                        $('[name*="'+name+'"]').html('<div class="vd_red">'+value+'</div>');
                    });
                });
                $('#admin-pass-submit').prop("disabled", false);
            }
            else
            {
                if(data.status=='success')
                {
                        document.getElementById("admin-pass-form").reset();
                        window.location.href = data['current_url'];
                }
                else
                {
                        $('.fa-spinner').remove();
                        success_register_2.hide();
                        error_register_2.show();
                        $('#admin-pass-submit').prop("disabled", false);
                }

            }

        }).fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
              $('#admin-pass-submit').prop("disabled", false);
        });

}


function export_users_project_count() {

  var base_url='<?php echo front_base_url();?>';
  var instituteId='<?php echo $this->session->userdata('instituteId');?>';
 // var instituteId='1';
  //alert(instituteId);
  $.ajax({
        type: "POST",  
        data:{instituteId:instituteId},     
        url: base_url+'creosouls_admin/admin/admin/export_users_project_count',
        success:function(responce)
        {
          var s =base_url+'export/'+responce;            
          window.location.href = s
        }
    }); 
}

</script>
