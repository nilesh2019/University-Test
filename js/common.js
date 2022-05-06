$(document).ready(function(){


     $(document).on('click','.show_report',function(){
          var form = '#'+$(this).parents('form').attr('id');
          var url = $(form).attr('action');
          //alert(base_url+'admin/reports/'+url);
          var serialize_data = $(form).serialize();
          $.ajax({
              type:'POST',
              url:base_url+'admin/reports/'+url, 
              dataType:'html',
              data:serialize_data,
              success:function(data)
              { 
                  $('.report_div').html(data);
              },
              complete:function()
              {                       
                TableAdvanced.init();
              }
          });
        });

        $(document).on('change','.getregion_list',function(){
          var zoneId = $(this).val();
          $.ajax({
              async: true,
              type:'POST',
              url:base_url+'admin/reports/getZoneRegionList', 
              dataType:'html',
              data:{zoneId:zoneId},
              success:function(data)
              { 
                $('.setregion_list').html(data);
              }
          });
        });


    "use strict";
   var registerInstituteForm = $('#instituteRegistrationForm');
   var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
   var success_registerInstituteForm = $('.alert-success', registerInstituteForm);

   jQuery.validator.addMethod("validyoutubeurl", function(value, element) {
     return this.optional(element) || value.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/);
   }, "Please specify the correct youtube url.");
              
    registerInstituteForm.validate({
                   errorElement: 'div', //default input error message container
                   errorClass: 'vd_red', // default input error message class
                   focusInvalid: false, // do not focus the last invalid input
                   onsubmit: true,
                   ignore: "",
                   rules: 
                   {

                   },
                   messages: {},
                   errorPlacement: function(error, element) 
                   {
                       if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio"))
                        {
                           element.parent().append(error);
                        } 
                        else if (element.parent().hasClass("vd_input-wrapper"))
                        {
                           error.insertAfter(element.parent());
                        }
                       else 
                       {
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
                   submitHandler: function (form) 
                   {
                        $(form).find('#institute-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
                        if($('#open_for_all').prop('checked')==true)
                        {
                            tinyMCE.triggerSave();
                            submitForm();
                        }
                        else
                        {
                            if($('#institute_name').val()=='')
                            {
                                $('#error1').text('This field is required');
                            }
                            else
                            {
                                submitForm();
                            }
                        }
                   }
               });

   function submitForm(){
         BASEURL='<?php echo base_url();?>';
        $('#institute-submit').prop("disabled", true);
        var registerInstituteForm = $('#instituteRegistrationForm');
        var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
        var success_registerInstituteForm = $('.alert-success', registerInstituteForm);
       // var formData = $( "#instituteRegistrationForm" ).serialize();
        var formElement = document.getElementById("instituteRegistrationForm");
        var formData=new FormData(formElement);
        $.ajax({
            url: BASEURL+"admin/competition/processForm",
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
                                    window.location.href = BASEURL+'admin/competition/setFlashdata/add';
                                }
                                else
                                {
                                    window.location.href = BASEURL+'admin/competition/setFlashdata/edit';
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
});
