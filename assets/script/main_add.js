$(function () {
    'use strict';
    var url1 = $('#base_url').val();
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({

        url: url1+'project/do_upload',
        autoUpload: true,
        success:function(responce){
            //  var obj = jQuery.parseJSON(responce);
            if(responce != '' && responce.error == 'Allowed disk space limit is over, please contact admin')
            {
                $('#ImageError').html('File you are trying to upload is having more size than allowed disk space, <a style="color:#3cafdf;" href="'+url1+'payment">Click here to buy space.</a> or contact admin.');
            }
			$('#show_all_images').removeClass('hide');
		}
    });

});