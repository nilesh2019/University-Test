/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
	
    'use strict';
             var url1 = $('#base_url').val();
    // Initialize the jQuery File Upload widget:
    $('#fileupload_edit').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: url1+'project/do_upload',
        autoUpload: true,
        success:function(responce){
			$('#edit_show_all_images').removeClass('hide');
		}
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload_edit').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') 
    {
        // Demo settings:
      
        $('#fileupload_edit').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 5000000,
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
        	
            $.ajax({
                url: url1+'project/do_upload',
                type: 'HEAD',
                autoUpload: true
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload_edit');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload_edit').addClass('fileupload-processing');
        	
        	//console.log($('#fileupload_edit')[0]);
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload_edit').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload_edit')[0],
            autoUpload: true
        }).always(function () {
            $(this).removeClass('fileupload-processing');
            
        }).done(function (result) {
        	$('#edit_show_all_images').removeClass('hide');
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});