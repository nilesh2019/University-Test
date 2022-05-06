<!-- Google Drive Setting -->
<div class="panel panel-default dropdown-menu " id="googleDriveSetting">
	<div class="panel-heading">
		<h3 class="panel-title">
			Order Details
		</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url();?>profile/updateGoogleDriveSetting" method="post" name="payuForm">
			<label>Google Drive Setting : </label>
			<input type="checkbox" name="driveSetting" value="1" ><label>ON</label>
			<input type="checkbox" name="driveSetting" value="0" checked><label>OFF</label>
			<input type="submit" value="Make Payment"  class="btn btn_orange" id="paymentBtn" style="display:none;"  />
			<a class="btn btn_blue" id="cancelPayment" href="javascript:void(0)">Cancel</a>
		</form>
	</div>
</div>
<!-- Google Drive Setting -->
<footer style="z-index: 999999 !important" id="myMainFooter">
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-lg-12">
            	<ul class="pull-left col-lg-6">
            	 <li>
            	 	 <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_new.png" style="width: 200px; " alt="logo" title="Home"></a>
            	 	
            	 </li>
                    <!-- <li id="feedback_li" class="dropup">
                        <a href="javascript:void(0)" class="feedback_lbl"> Write to us</a>
                        <div id="feedback_body" class="panel panel-default dropdown-menu" >
   							 <div class="panel-heading">We would love to hear from you!  <button type="button" class="feedback_cancle close"><i class="fa fa-times"></i></button> </div>
    						 <div class="panel-body">
                             	<form id="contactForm" method="POST" action="javascript:void(0)">
                             	<span class="error_text" id="comment_error"></span>
                                	<textarea class="form-control" id="comment_feedback" name="comment"  placeholder="Suggestions, Comments, Complaints, etc. "></textarea>
                                	
                                    <label>Your Name</label>
                                    <span  class="error_text" id="fullName_error"></span>
                                    <input  class="form-control" id="fullName" name="fullName" type="text">
                                    
                                    <label>Email ID</label>
                                    <span  class="error_text" id="email_error"></span>
                                    <input  class="form-control" id="email" name="email" type="text">
                                   	<div class="g-recaptcha" data-sitekey="6Ler3GQUAAAAANH-rMB_FjULzFTol5KVTM8JCQV9"></div>
                                   	<br />
                                    <span class="err_msg" style="display: none;color: red">Field is required</span>
                                    <button class="btn white_btn feedback_cancle">Cancel</button>
                                    <button id="submit_feedback" type="submit" class="btn btn_blue">Submit</button>
                                </form>
                             </div>
  						</div>
                    </li> -->
					<li><a target="_blank" href="<?php echo base_url();?>term/">Terms & Conditions </a></li>
					<li><a target="_blank" href="<?php echo base_url();?>policy/">Privacy Policy</a></li>
                </ul>
                <ul class="pull-right col-lg-2">
                	<li class="copyright" style="float:right">
                		 University <?php echo date('Y');?>
                		 connectwithus@creonow.com
                	</li>
                </ul>
                <ul class="pull-right">
                	<li>Need help? We are just a call away : 
                		<div class="pull-right">
	                			<!-- <i class="fa fa-phone"></i> +91 853069 0642<br/> -->
	                			<i class="fa fa-phone"></i> +91 123456 78902<br/>
	                			<i class="fa fa-clock-o"></i>  Monday to Friday , 9 AM to 6 PM <br/>

	                	</div>		
                	
                	</li>
                </ul>
            	
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="myModalForDetailProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border: none;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;color: #7D898F;font-size: 60px;text-shadow:none;opacity: 0.5;right: 15px;z-index: 9999;">
				<span aria-hidden="true">
					&times;
				</span>
			</button>
			<iframe id="myModalForDetailProjectIframe" style="margin-bottom: -5px;"></iframe>
			<div class="overlay-loader-wrapper" id="loaderHomePageDivP">
			    <div class="overlay-loader">
			        <div class="overlay-loader__content">
			          <!--<div class="overlay-loader__block">
			            <div class="overlay-loader__block--inner">
			              <span class="overlay-loader__line overlay-loader__line--first"></span>
			              <span class="overlay-loader__line overlay-loader__line--second"></span>
			              <span class="overlay-loader__line overlay-loader__line--last"></span>
			            </div>
			          </div>
			          <span class="overlay-loader__text">Loading...</span>-->
                      <img src="<?php echo base_url();?>assets/img/load.gif" style="width:100px"/>
			      </div>
			    </div>
			  </div>
		</div>
	</div>
</div>
    <!-- jQuery -->

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-asPieProgress.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <!-- custom scrollbar plugin -->
	<script src="<?php echo base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- custom scrollbar plugin -->
	<script src="<?php echo base_url();?>assets/script/jquery.blockUI.js"></script>
	<script src="<?php echo base_url();?>assets/script/jquery.toaster.js"></script>
	<script type="text/javascript">
		$('#myModalForDetailProject').on('shown.bs.modal', function (e) {
		  	/*$('html, body').css({
		      	overflow: 'hidden',
		      	height: '100%'
		  	});*/
		  	$('#myModalForDetailProjectIframe').on("load",function(){
		  		$('#loaderHomePageDivP').css('display', 'none');
		  	});
		});
		$('#myModalForDetailProject').on('hidden.bs.modal', function (e) {
			$('#loaderHomePageDivP').removeAttr('style');
			$('#myModal').removeAttr('style');
		  	/*$('html, body').css({
		      	overflow: 'visible',
		      	height: '100%'
		  	});*/
		});

		function showProjectDetailModal(projectPageName,is_assignment){
			$('iframe#myModalForDetailProjectIframe').on('load',function(){
             $(this).contents().find('body').css('padding-top', '0px');
				$(this).contents().find('#myMainNav').remove();
				$(this).contents().find('#myMainFooter').remove();
				//$(this).contents().find('#myModalForDetailProject').remove();
				$(this).contents().find('body').on('click', 'a', function(e){
				   	e.preventDefault(e);
				   	if (window.location != window.parent.location){
			       		if (window.parent.location != window.parent.parent.location){
       			       		if (window.parent.parent.location != window.parent.parent.parent.location){
	       			       		if (window.parent.parent.parent.location != window.parent.parent.parent.parent.location){
		       			       		if (window.parent.parent.parent.parent.location != window.parent.parent.parent.parent.parent.location){
   			       			       		if (window.parent.parent.parent.parent.parent.location != window.parent.parent.parent.parent.parent.parent.location){
       			       			       		if (window.parent.parent.parent.parent.parent.parent.location != window.parent.parent.parent.parent.parent.parent.parent.location){
	       			       			       		if (window.parent.parent.parent.parent.parent.parent.parent.location != window.parent.parent.parent.parent.parent.parent.parent.parent.location){
		       			       			       		if (window.parent.parent.parent.parent.parent.parent.parent.parent.location != window.parent.parent.parent.parent.parent.parent.parent.parent.parent.location){
		       			       			       	    	window.parent.parent.parent.parent.parent.parent.parent.parent.parent.location.href =  $(this).attr('href');
		       			       			       		}else{
		       			       				       		window.parent.parent.parent.parent.parent.parent.parent.parent.location.href =  $(this).attr('href');
		       			       			       		}
	       			       			       		}else{
	       			       				       		window.parent.parent.parent.parent.parent.parent.parent.location.href =  $(this).attr('href');
	       			       			       		}
       			       			       		}else{
       			       				       		window.parent.parent.parent.parent.parent.parent.location.href =  $(this).attr('href');
       			       			       		}
   			       			       		}else{
   			       				       		window.parent.parent.parent.parent.parent.location.href =  $(this).attr('href');
   			       			       		}
		       			       		}else{
		       				       		window.parent.parent.parent.parent.location.href =  $(this).attr('href');
		       			       		}
	       			       		}else{
	       				       		window.parent.parent.parent.location.href =  $(this).attr('href');
	       			       		}
       			       		}else{
       				       		window.parent.parent.location.href =  $(this).attr('href');
       			       		}
			       		}else{
				       		window.parent.location.href =  $(this).attr('href');
			       		}
				   	}else{
				   		window.location.href= $(this).attr('href');
				   	}
				});
			});
			/*if($('#myModalForDetailProject').hasClass('in')){
				console.log('open');
				console.log($('#myModalForDetailProject'));
			}*/
		    $('#myModalForDetailProjectIframe').removeAttr('src');
		    if(typeof is_assignment === "undefined") {
		    	var projectPageNameUrl=base_url+'projectDetail/'+projectPageName;
		    }else{				
		    	var projectPageNameUrl=base_url+'projectDetail/'+projectPageName+'/'+is_assignment;
		    }			
		    $('#myModalForDetailProjectIframe').attr('src', projectPageNameUrl);
		    $('#myModalForDetailProject').modal('show');
		}
	</script>
<!-- 	<script type="text/javascript">
		window.addEventListener("dragover",function(e){
		 debugger;
		 	alert();
		  e = e || event;		  
		  e.preventDefault();
		},false);
		window.addEventListener("drop",function(e){
		  e = e || event;
		  e.preventDefault();
		},false);
	</script> -->
	<?php
		if($this->session->flashdata('error') <> '')
		{
		?>
		<script>
			jQuery(document).ready(function($) {

				$.toaster.reset();
				var priority = 'danger';
				var title    = 'Error';
				var ticon	= 'fa-times-circle';
				var message  = '<?php echo $this->session->flashdata('error');?>';
				$.toaster({ priority : priority, title : title, message : message, ticon : ticon });
			});
		</script>
		<?php
		$this->session->set_flashdata('error','');
		}
		if($this->session->flashdata('success') <> '')
		{
		?>
		<script>
			jQuery(document).ready(function($) {
				$.toaster.reset();
				var priority = 'success';
				var title    = 'Success';
				var ticon	= 'fa-check-circle';
				var message  = '<?php echo $this->session->flashdata('success');?>';
				$.toaster({ priority : priority, title : title, message : message, ticon : ticon });
			});
		</script>
		<?php
			$this->session->set_flashdata('success','');
		}
	?>
<!-- tag it -->
       <script src="<?php echo base_url();?>assets/script/jquery.tag-editor.js"></script>
	   <script src="<?php echo base_url();?>assets/script/jquery.caret.min.js"></script>
	   <script src="<?php echo base_url();?>assets/script/jquery-ui.min.js"></script>
<!-- tag it -->
<script>
$(function(){
  $('input[name="copyright"]').click(function(){
    if($(this).is(':checked'))
    {
      if($(this).val()==1)
      {
	  	$('.copyright_text').removeClass('hide');
	  }
	  else{
	  	$('.copyright_text').addClass('hide');
	  }
    }
  });
});
/*	$(function () {
	  $('[data-tooltip="tooltip"]').tooltip();
	});*/
$(document).ready(function()
{
    $("#submit_feedback").click(function(event)
    {
    	//alert($('textarea#comment_feedback').val());
     	var url = $('#base_url').val();
        event.preventDefault();
		var ch = 0;
       
		if($('#comment_feedback').val() == '')
		{
			$('#comment_error').text('Field is required');
			ch++;
     	}
     	else
     	{
			$('#comment_error').text('');
		}
		if($('#email').val() == '')
		{
			$('#email_error').text('Field is required');
			ch++;
     	}
     	else
     	{
     		var sEmail = $('#email').val();
     		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	        if(filter.test(sEmail))
	        {
	        	$('#email_error').text('');
        	}
    		else
    		{
        	  ch++;
        	  $('#email_error').text('Not Valid Email');
	        }
		}
		if($('#fullName').val() == '')
		{
			$('#fullName_error').text('Field is required');
			ch++;
     	}
     	else
     	{
			$('#fullName_error').text('');
		}
		if(grecaptcha.getResponse()=="")
		{
			$(".err_msg").css("display",'block');
			ch++;
		}
		else
		{
			$(".err_msg").css("display",'none');
		}
		if(ch==0)
		{   //$.blockUI();
		   	setTimeout(function(){ $('#feedback_li').addClass('open'); }, 10);
			
				$.ajax({
	                url:url+'home/submit_feedback',
	                type:'POST',
	                data:$("#contactForm").serialize(),
	                success:function(result)
	                {
	                	if(result=='done')
	                	{
							var priority = 'success';
							var title    = 'Success';
							var message  = 'Thank You For Your Feedback';
							$.toaster({ priority : priority, title : title, message : message });
							$('#feedback_li').removeClass('open');
	                     	$("#contactForm")[0].reset();
	                      	$('#feedback_body').fadeToggle("slow");
						}
						else
						{
							var priority = 'danger';
							var title    = 'Error';
							var message  = 'Please Submit Again.';
							$.toaster({ priority : priority, title : title, message : message });
						}
	                   // $.unblockUI();
	                }
	            });
		}
		else
		{
			setTimeout(function(){
				// alert('sdga');
				 $('#feedback_li').addClass('open'); }, 10);
		}
   });
     });
</script>
<?php
	 if($this->session->userdata('front_user_id') != '' || $this->session->userdata('front_is_logged_in'!=''))
	  {
	  ?>
 <!-- uploader js -->



 <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

 <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url();?>assets/script/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url();?>assets/script/blueimp/javascript-template/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url();?>assets/script/blueimp/javascript-loadimg/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url();?>assets/script/blueimp/javascript-canvas-to-blob/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
<!-- blueimp Gallery script -->
<script src="<?php echo base_url();?>assets/script/blueimp/gallery/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url();?>assets/script/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url();?>assets/script/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url();?>assets/script/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url();?>assets/script/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url();?>assets/script/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url();?>assets/script/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo base_url();?>assets/script/main_add.js"></script>
<?php if($this->uri->segment(1)=='project' && $this->uri->segment(2)=='edit_project') {?>
<script src="<?php echo base_url();?>assets/script/main_edit.js"></script>
<?php } ?>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
   <td class="template-upload fade">
      <div class="preview"></div>
       <input id="img_id" type='hidden' value="">
	   <input class="water" name="water" type='hidden' >
	   <p class="name" style="overflow:hidden;">{%=file.name%}</p>
	   {% if (!i && !o.options.autoUpload) { %}
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="my_upload start"></span>
       {% } %}
   </td>
 {% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.deleteUrl) { %}
	  <td class="template-download fade ">
  {% } %}
	  {% if (file.deleteUrl) { %}
<div class="bunch">
                <span class="btn btn-info gradient size-3 delete template_image_delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="fa fa-close"></i>
               </span>
           <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="90" src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
             	<span><input id="img_id" type='hidden' value="{%=file.id%}"  name="image[]" ></span>
              {% if (file.file_ext!=".zip") { %}
				<span><br/><input type="radio" class="cover_pic" name="cover_pic" value="{%=file.id%}">Cover Pic</span>
			  {% } %}
				</div>
{% } %}
        </td>
{% } %}
</script>
<?php } ?>
<script>
jQuery (document).on('click','#quick_add',function(){
		jQuery ('.full_add').addClass('hide');
		$('#attri_div').addClass('hide');
	});
jQuery (document).on('click','#full_add',function(){
		jQuery ('.full_add').removeClass('hide');
		$('#attri_div').removeClass('hide');
	});
$('#add_project_button').on('click',function(){
	$('.AddProject').fadeToggle("slow");
	$('.AddProject #Save_Competition_Id').val('');
	$('.AddProject #Save_Assignment_Id').val('');
	$('#privateProject').show();
	$('#draftProject').show();
	$('#publishProject').show();
});
$('.feedback_lbl').on('click',function(){
	$('#feedback_body').fadeToggle("slow");
});
$('.feedback_cancle').on('click',function(){
	$('#feedback_body').fadeToggle("slow");
  $("#contactForm")[0].reset();
});
$("#cancel_add").click(function()
 {
 	$('#show_all_images').addClass('hide');
    $(".cover_pic").removeAttr('checked');
	$(".template_image_delete").trigger( "click" );
	$('#projectName').val('');
	$('#projectNameError').text('');
	$('#project_category').val('');
	$('#projectFileLink').val('');
	$('#attri_div').html('');
	$('#attribute_script').html('');
	$('#project_categoryError').text('');
	$('#videoLink').val('');
	$('#videoLinkError').text('');
	$('#projectTypeError').text('');
	$('#projectStatusError').text('');
	$('#socialFeaturesError').text('');
	$('#basicInfo').val('');
	$('#thought').val('');
	$('#ImageError').text('');
	$("#quick_add").trigger('click');
    var tags = $('#keyword').tagEditor('getTags')[0].tags;
    for (i = 0; i < tags.length; i++) { $('#keyword').tagEditor('removeTag', tags[i]); }
    var url1 = $('#base_url').val();
		if($('#check_watermark').is(":checked")){
		 $('#check_watermark').trigger('click');
		}
   $('.AddProject').fadeToggle("slow");
 });
</script>
<script>
   $(".add_pro").click(function(event)
   {
  		var subval = $(this).val();
   	    $('#submit_value').val(subval);
     	var url = $('#base_url').val();
        event.preventDefault();
		var ch = 0;
		if($('#videoLink').val() != '')
		{
			//alert($('#videoLink').val());
		}else{
			if(!$('#img_id').val())
			{
				$('#ImageError').text('Please Add Files');
		        ch++;
			}
			else
			{
				if(!$('.cover_pic').is(':checked'))
				{
					alert('Please select cover picture.');
					ch++;
			    }
			    else
			    {
					$('#ImageError').text('');
				}
			}
		}
        if($('#projectName').val() == '')
		{
			$('#projectNameError').text('Field is required');
			ch++;
     	}
     	else
     	{
			$('#projectNameError').text('');
		}
		if($('#project_category').val() == '')
		{
			$('#project_categoryError').text('Field is required');
			ch++;
     	}
     	else
     	{
     		 if(($('#project_category').val()==4 ||$('#project_category').val()==5 || $('#project_category').val()==6))
     		 {
			 	  if($('#videoLink').val() == '')
					{
						$('#videoLinkError').text('Field is required');
						ch++;
			     	}
			     	else if($('#videoLink').val() != '')
					{
						var linkd = $('#videoLink').val()
						var re = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
						if (re.test(linkd)==false)
						{
							$('#videoLinkError').text('Not valid URL');
							ch++;
						}
			    	}
			     	else
			     	{
			     		$('#videoLinkError').text('');
					}
			 }
			  else
			 {
			 	if($('#videoLink').val() != '')
					{
						var linkd = $('#videoLink').val();
						var re = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
						if (re.test(linkd)==false)
						{
							$('#videoLinkError').text('Not valid URL');
							ch++;
						}
			    	}
			     	else
			     	{
			     		$('#videoLinkError').text('');
					}
			 }
			$('#project_categoryError').text('');
		}
		if(!$('.projectType').is(':checked'))
		{
			$('#projectTypeError').val('Field is required');
			ch++;
     	}
     	else
     	{
			$('#projectTypeError').val('');
		}
		if(!$('.projectStatus').is(':checked'))
		{
			$('#projectStatusError').text('Field is required');
			ch++;
     	}
     	else
     	{
			$('#projectStatusError').text('');
		}
		if(!$('.socialFeatures').is(':checked'))
		{
			$('#socialFeaturesError').text('Field is required');
			ch++;
     	}
     	else
     	{
			$('#socialFeaturesError').text('');
		}
		if(ch==0)
		{ 
			$('#fileupload .btn').attr('disabled', true);
			$('#cancel_add').attr({
				style: 'display:none'				
			});			
		 	 $.blockUI();
			 $.ajax({
                url:url+'project/add_project',
                type:'POST',
                data:$("#fileupload").serialize(),
                success:function(result)
                {
                	if(result!='erroor'){
						window.location = result;
					}
					else{
						alert('Resubmit Project');
					}
                    $.unblockUI();
                }
            });
		}
   });
</script>
<!--Color Picker-->
<script src="<?php echo base_url();?>assets/js/jquery.minicolors.js"></script>
<!--<script src="<?php echo base_url();?>assets/js/modernizr.js"></script>-->
 <script>
        $(document).ready( function() {
            $('.demo').each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    change: function(value, opacity) {
                        if( !value ) return;
                        if( opacity ) value += ', ' + opacity;
                        if( typeof console === 'object' ) {
                            console.log(value);
                        }
                    },
                    theme: 'bootstrap'
                });
            });
        });
 </script>
 <!--Color Picker End-->
<div id="attribute_script"></div>
<script>
		$(document).ready(function()
		{
			var url = $('#base_url').val();
			$('#check_watermark').click(function()
			{
				if($('#check_watermark').prop("checked") == true)
				{
					$('.watermark').removeClass('hide');
				}
				else
				{
					$('.watermark').addClass('hide');
			   }
			});
              /*$("#project_category").change(function()
               {
			 	  	var project_category = $("#project_category").val();
			 	 	var currentRadio = $('input:radio[name=RadioOptionsForAdd]:checked').val();
					 $.blockUI();
					   $.ajax({
						   url: url+"project/set_category",
						   data: {project_category:project_category},
						   type: "POST",
		                   success:function(html)
						   {
						   	  $('#attri_div').html('');
						   	  $('#attribute_script').html('');
							if(html)
							{
								var obj = $.parseJSON(html);
								var i=1;
								$.each(obj, function(index, element)
								{
									$('#attri_div').append('<div class="form-group"><label class="col-sm-4 control-label">'+element.attributeName+'</label><div class="col-sm-8"><textarea name="attribute'+element.attributeId+'" id="demo'+i+'"></textarea></div></div>');
									if(element.atrribute_value != undefined || element.atrribute_value == null || element.atrribute_value.length == 0)
									{
										var attri = element.atrribute_value;
									}
									else
									{
										var attri='';
									}
									var s = document.createElement("script");
									s.type = "text/javascript";
									s.text =  '$("#demo'+i+'").tagEditor({autocomplete: {delay: 0,position: { collision: "flip" },source: ['+attri+']},forceLowercase: false,placeholder: "Attribute Value"});';
									$("#attribute_script").append(s);
									i++;
								});
							}
							$.unblockUI();
					       }
				      })
					if(currentRadio=='option2')
					{
						$('#attri_div').removeClass('hide');
					}
					else{
						$('#attri_div').addClass('hide');
					}
	          })*/
			$("#keyword").tagEditor({autocomplete: {delay: 0,position: { collision: "flip" },source: []},forceLowercase: false,placeholder: "Keywords"});
		})
	</script>
<script>
/*  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();*/
$(document).ready(function(){
	 $('#adv_pro_peo li').click(function(e)
      {
	   	 var name = $(this).find('a').text();
     	 $('#adv_pro_peo_selected').html(name+'<span class="caret"></span>');
      })
 	  	  $('#category_list li').click(function(e)
 	       {
 	          var url=$('#base_url').val();
 	      	  var id = $(this).find('a').data("id");
 	      	  var category_name = $(this).find('a').text();
 	      	  $('#adv_category_selected').html(category_name+'<span class="caret"></span>');
 	      	  $('#adv_category_selected').attr('data-id',id);
 	      	  $('#adv_attribute_selected').text('Attribute');
 	      	  $('#adv_attribute_selected').html('Attribute<span class="caret"></span>');
 	      	  $('#adv_attribute_list').html('');
 	      	  $('#adv_attribute_list').data();
 	      	 $('#adv_attri_value_selected').html('Attribute Value<span class="caret"></span>');
		     $('#adv_attri_value_list').html('');
		     $('#adv_attri_value_list').data();
 	      	  $.ajax({	   url: url+"home/get_category_attribute",
 	 					   type: "POST",
 	 					   data:{id:id},
 	 					   success:function(html)
 	 					   {
 	 							if(html!='')
 	 							{
 	 								 var obj = $.parseJSON(html);
 	 							     $.each(obj, function(index, element)
 	 								 {
 	 									$('#adv_attribute_list').append('<li><a data-id="'+element.id+'" data-name="'+element.attributeName+'">'+element.attributeName+'</a></li>');
 	 								 })
 	 							}
 	 					   }
 	 				 });
 	  	 })
 	  	     $(document.body).on("click",'#adv_attribute_list li', function()
 	  	     {
    	  	      var url=$('#base_url').val();
		     	  var id = $(this).find('a').data("id");
		     	  var attribute_name = $(this).find('a').text();
		     	  $('#adv_attribute_selected').html(attribute_name+'<span class="caret"></span>');
		     	  $('#adv_attribute_selected').attr('data-id',id);
		     	  $('#adv_attri_value_selected').text('Attribute Value');
		     	  $('#adv_attri_value_selected').html('Attribute Value<span class="caret"></span>');
		     	 
		     	  $('#adv_attri_value_list').html('');
		     	  $('#adv_attri_value_list').data();
		     	  $.ajax({	   url: url+"home/get_attribute_value",
							   type: "POST",
							   data:{id:id},
							   success:function(html)
							   {
									if(html!='')
									{
										 var obj = $.parseJSON(html);
									     $.each(obj, function(index, element)
										 {
											$('#adv_attri_value_list').append('<li><a data-id="'+element.id+'" data-name="'+element.attributeValue+'">'+element.attributeValue+'</a></li>');
										 })
									}
							   }
						 });
		 	 })
 	   $(document.body).on('click', '#adv_attri_value_list li' ,function()
		{
       	   var name = $(this).find('a').text();
       	   var id = $(this).find('a').data("id");
	   	   $('#adv_attri_value_selected').html(name+'<span class="caret"></span>');
	   	   $('#adv_attri_value_selected').attr('data-id',id);
        })
         $('#adv_rating_list li').click(function(e)
	      {
		   	  var name = $(this).find('a').text();
	     	  $('#adv_rating_selected').html(name+'<span class="caret"></span>');
	      })
     $('#adv_search').click(function(e)
      {
      	  	 var url=$('#base_url').val();
      	 	 var adv_search_for = $('#adv_pro_peo_selected').text();
      	  	 var category = $('#adv_category_selected').text();
		  var category_id=$('#adv_category_selected').data('id');
	   	  var attribute = $('#adv_attribute_selected').text();
	   	  var attribute_id = $('#adv_attribute_selected').data('id');
	   	  var attri_value = $.trim($('#adv_attri_value_selected').text());
	   	  var attri_value_id = $('#adv_attri_value_selected').data('id');
	   	  var rating = $('#adv_rating_selected').text();
	   	  if(adv_search_for=='Search For')
	   	  {
		  	adv_search_for='';
		  }
		  if(attribute=='Attribute')
	   	  {
		  	attribute='';
		  }
		  if(category=='Category')
	   	  {
		  	category='';
		  }
		  if(attri_value=='Attribute Value')
	   	  {
		  	attri_value='';
		  }
		  if(rating=='Rating')
	   	  {
		  	rating='';
		  }
		  if(adv_search_for!='')
		  {
		  		 $.ajax({
		  		      url: url+"home/advance_search",
					   type: "POST",
					   data:{adv_search_for:adv_search_for,category:category,category_id:category_id,attribute:attribute,attri_value:attri_value,rating:rating,attribute_id:attribute_id,attri_value_id:attri_value_id},
					   success:function(html)
					   {
							if(adv_search_for=='Project')
							{
								window.location='<?php echo base_url();?>all_project';
							}
							if(adv_search_for=='People')
							{
								window.location='<?php echo base_url();?>people';
							}
					   }
				 });
		  }
		  else
		  {
		  	alert('Please select search for');
		  }
	  })
		});
</script>
<script type="text/javascript">
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;
					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});
					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text(obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}
			$(function() {
				var dd = new DropDown( $('#dd') );
				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-3').removeClass('active');
				});
			});
		</script>
<script>
$(document).ready(function(){
        $('#hide').click(function() {
            $('#discover').removeClass('in');
        });
    });
</script>
 <?php
 if($this->session->userdata('front_user_id')!='')
 { ?>
 	<script>
 	$(function() {
$("div#feedback_body").click(function(e) {
		   // e.stopPropagation();
		    //alert();
		});});
	 $(document).ready(function()
	 {
	 	// $('.like_span').click(function()
		 $(document.body).on('click', '.like_div .fa-thumbs-o-up' ,function()
		  {	

		     var url = $('#base_url').val();
		    // var pro_id = $(this).data('id');		       
		     //var txt = $(this).text();
			 var urlName = '<?php echo current_url();?>';
			 var pageName = '<?php echo $this->uri->segment(1);?>';
			 if(pageName=='')
			 {
			 	pageName = 'Home';
			 }
			 if(pageName == 'projectDetail')
			 {
			 	var pro_id =  $(this).parent().data('id');
			 	var a = $(this).parent().data('like');
			 	var cal = $(this).parent().data('name');
			 	var th=$(this).parent();
			 }
			 else
			 {
			 	var pro_id = $(this).closest('div[data-id]').data('id');		 
			 	var a = $(this).closest('div[data-id]').data('like');
			 	var cal = $(this).closest('div[data-id]').data('name');
			 	var th=$(this).closest('div[data-id]');
			 }
			   if(cal==0)
			   {
			   	//alert(cal);
			 	 th.attr("data-name","1");
			   	   $.ajax({
					   url: url+"project/like_cnt",
					   type: "POST",
					   data:{pro_id:pro_id,pageName:pageName,urlName:urlName},
					   success:function(html)
					   {
					   	  if(html=='done')
						  {
						  /*	th.html('<i class="fa fa-thumbs-o-up"></i> Like ('+(a+1)+')');*/
						  	th.html('<i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+(a+1)+'</span>');
						  }
						  else if(html=='no')
						  {
						  	  th.attr("data-name","0");
						  }
					   }
				 });
			   }
		  });
		$("#notificationLink").click(function()
		{
			  var url = $('#base_url').val();
			   $.ajax({
					   url: url+"project/updateReadCount",
					   type: "POST",
					   success:function(html)
					   {
					   }
				 });
	    });
	    $("#notificationLink").click(function()
		{
		 $("#notificationContainer").fadeToggle(500);
		 $("#notification_count").fadeOut("slow");
		 return false;
		});
	    $(document.body).click(function (){$("#notificationContainer").fadeOut(500);});
     });
     </script>
 <?php
   }
  else
   {?>
	 <script>
	 $(document).ready(function()
	 {
	 	// $('.like_span').click(function()
		$(document.body).on('click', '.like_div' ,function()
		{
			var url = $('#base_url').val();
			var pro_id = $(this).data('id');
			var urlName = '<?php echo current_url();?>';
			var pageName = '<?php echo $this->uri->segment(1);?>';
		 if(pageName=='')
		 {
		 	pageName = 'Home';
		 }
			$.ajax({
				url: url+'home/remember_action',
				data: {urlName:urlName,pro_id:pro_id,pageName:pageName},
				type: "POST",
				success:function(html)
				{
					window.location='<?php echo base_url();?>hauth/googleLogin';
				}
			});
		});
     });
     </script>
<?php
   }
 ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('.pie_progress').asPieProgress({
            namespace: 'pie_progress'
        });
		$('.pie_progress').asPieProgress('start');
    });
	$(document).ready(function()
	{
		$('#myInstituteModal').on('hidden.bs.modal', function ()
		{
		    document.getElementById('myInstituteModal').reset();
		});
		$('.googleDriveSettingPanel').click(function(){
			$('#googleDriveSetting').fadeToggle("slow");
		});
		$(".driveSetting").on('click', function(e){
			var driveSetting = $(this).val();
			$.ajax({
				url: '<?php echo base_url();?>profile/updateGoogleDriveSetting',
				data:{driveSetting:driveSetting},
				type: "POST",
				success:function(res)
				{
					if(res==true){
						$('.errorMsg').text('Google drive setting updated successfully.').css('color','#70C44B');
					}else{
						$('.errorMsg').text('Error in updating Google drive setting.').css('color','#E02F2F');
					}
				}
			});
		});
		$(".moveToDrive").on('click', function(e){
			var moveToDrive = $(this).val();
			if(moveToDrive == 1)
			{
				$('#googleDriveSetting').modal('toggle');
				$.blockUI({ message: '<div id="example_processing" class="dataTables_processing" style="display: block;">Moving data to google drive <img src="<?php echo base_url();?>assets/img/loading.gif"></div>',css: {
			          border: 'none',
			          backgroundColor: 'transparent'
			      }  });
			}
			$.ajax({
				url: '<?php echo base_url();?>project/updateMoveDataToDriveSetting',
				data: {moveToDrive:moveToDrive},
				type: "POST",
				success:function(res)
				{
					if(res==true){
						$('.errorMsg').text('Setting updated successfully.').css('color','#70C44B');
						$.toaster({ priority : 'success', title : 'Success', message : 'Setting updated successfully.'});
					}else{
						$('.errorMsg').text('Error in updating setting.').css('color','#E02F2F');
						$.toaster({ priority : 'danger', title : 'Error', message : 'Error in updating setting.' });
					}
					if(moveToDrive == 1)
					{
						$.unblockUI();
					}
				}
			}).fail(function() {
				if(moveToDrive == 1)
				{
      				$.unblockUI();
      			}
    		})
		});
	});
	function checkStudentId()
	{
			var base_url = $('#base_url').val();
			var studentId = $('#studentId').val();
			var maac_url = '<?php echo maac_base_url();?>';			

			if(studentId != '')
			{
				$.ajax({
					url: base_url+'home/checkStudentId',
					type: 'POST',
					data: {studentId: studentId},
				})
				.done(function(data)
				{
					//alert(data);
					//return false;
					if(data==1 || data==4)
					{	
						document.getElementById('myForm').reset();
						window.location.replace(base_url+'hauth/googleLogin');
						return false;						
					}
					else if(data==11 || data==44)
					{						
						document.getElementById('myForm').reset();						
						$.ajax({url: maac_url+'hauth/setstudentid/'+studentId, success: function(result){							
						        window.location=base_url+'hauth/googleLogin';
						        //window.location=base_url+'hauth/googleLoginStudent';
						    }});						
						return false;						
					}
					else
					{
						if(data==2)
						{
							$('#myForm span.text-danger').html('Payment is not yet done for user of this student ID, Please contact your institute admin for further information.');
							return false;
						}
						else if(data == 3)
						{
							$('#myForm span.text-danger').html('No user found with this student ID, Please contact your institute admin for further information.');
							return false;
						}
						/*else
						{
						    $('#myForm span.text-danger').html('This Student ID is already in use, Please contact your institute admin for further information.');
						    return false;
						}*/
					}
				})
				return false;
			}
			else
			{
				$('#myForm span.text-danger').html('Student ID is required.');
				return false;
			}
		}
    $(document).ready(function(){
        $(this).scrollTop(0);
    });
    $(document).mouseup(function (e)
    {

        var container = $('.discover');
        var containerLink = $('#discoverLia');
        if($(e.target).attr('id') == 'discoverLia')
        {
        	return false;
        }

        if ((!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) ) 
        {
        		$('#discover').removeClass('in');
        		return false;
        }
    });
$(document).mouseup(function (e)
    {

        var container = $('#add_project_button');
        var containerLink = $('#addProjectMsg');
        if($(e.target).attr('id') == 'addProjectMsg')
        {
        	return false;
        }

        if ((!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) ) 
        {
        		$('#addProjectMsg').css({"display": "none"});
        		return false;
        }
    });
    </script>
  
    <script type="text/javascript">
     	$(function () {
     	       $("#show_all_images .table tr").sortable({
     	       connectWith: "td"
     	       });
     	       $("tr[id^='available']").draggable({
     	       helper: "clone",
     	       connectToSortable: "tr"
     	       });
     	       });
     	$(function () {
     	       $("#edit_show_all_images .table tr").sortable({
     	       connectWith: "td"
     	       });
     	       $("tr[id^='available']").draggable({
     	       helper: "clone",
     	       connectToSortable: "tr"
     	       });
     	       });
     </script>
     <script>
     		$(document).ready(function(){
     	    var cookieEnabled = (navigator.cookieEnabled) ? true : false;

     	    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled)
     	    { 
     	        document.cookie="testcookie";
     	        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
     	    }
     	    if(cookieEnabled==false)
     	    {
     	    	$('#cookiesModal').modal('show');
     	    }
     	    }); 
     </script>

     <script>
     	$('div.dropdown').hover(function() {
     	  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
     	}, function() {
     	  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
     	});
     </script>
     <?php if($this->session->userdata('blockUser') !=''){ ?>
     <script>
         $('#modalWarning').modal('show');
     </script>     	
     <?php $this->session->sess_destroy(); }?>
     <!-- <script type="text/javascript" src="http://www.unichronic.com/livechat/php/app.php?widget-init.js"></script> -->
</body>
</html>


