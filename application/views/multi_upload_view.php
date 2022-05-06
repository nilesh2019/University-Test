<?php $this->load->view('template/header');
?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/bootstrap-fileupload.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.fileupload.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.fileupload-ui.css"/>
<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/style/fastselect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.tagit.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/tagit.ui-zendesk.css">-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.tag-editor.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.minicolors.css">
<div id="content-block">
	<div class="container be-detail-container">
		<div class="row">
			<div class="col-xs-12 col-md-3 left-feild" style="background:#fff;">
				<div class="be-vidget back-block">
					<a class="btn full btn-primary gradient size-1" href="<?php echo base_url();?>profile"><i class="fa fa-chevron-left"></i>back to profile</a>
				</div>
				<div class="be-vidget hidden-xs hidden-sm" id="scrollspy">
					<h3 class="letf-menu-article">
						Choose Category
					</h3>
					<div class="creative_filds_block">
						<ul class="ul nav">
							<li><a href="<?php echo base_url();?>project/manage_projects">View All Projects</a></li>
							<li><a href="<?php echo base_url();?>project/add_project">Add Project</a></li>
						</ul>
					</div>
					<!-- <a class="btn full color-1 size-1 hover-1 add_section"><i class="fa fa-plus"></i>add sections</a> -->
				</div>
			</div>
			<div class="col-xs-12 col-md-9 _editor-content_">
			<form  method="post" class="form-horizontal" onsubmit="return check_img();" enctype="multipart/form-data" action="<?php echo base_url()?>project/projectContent/<?php if(!empty($id)){ echo $id;} ?>/<?php if(!empty($cat_id)){ echo $cat_id;}?> " id="fileupload" >
				<div class="affix-block" id="basic-information">
				<div class="affix-block" id="edit-password">
					<div class="be-large-post">
						<div class="info-block style-2">
							<div class="be-large-post-align"><h3 class="info-block-label">Add Content</h3></div>
						</div>
						<div class="be-large-post-align">
							<div class="row">
					         		<div class="input-col col-xs-12 col-sm-12" style="display:none">
									<div class="form-group">
										<label>Content name</label>&nbsp;(<span class="error">*</span>)
										<input class="form-control" name="title" value="Content Name" type="text" placeholder="Content name">
										<span class="error"><?php echo form_error('title');?></span>
									</div>
							 	</div>
					         		<div class="input-col col-xs-12 col-sm-12">
									<div class="form-group">
										<label class="input-col col-xs-3 col-sm-3">More Details</label>
										<label class="input-col col-xs-9 col-sm-9" style="visibility: hidden;">Atribute Values</label>
									</div>
						             <?php
									if(!empty($attribute))
									{
										$i=1;
										foreach($attribute as $row)
										{
										?>
											<div class="form-group">
												<label class="input-col col-xs-3 col-sm-3"><?php echo $row['attributeName'];?></label>
												<div class="input-col col-xs-9 col-sm-9">
											            <textarea name="attribute<?php echo $row['attributeId']; ?>" id="demo<?php echo $i; ?>"><?php if(set_value('attribute'.$row['attributeId'])){ echo set_value('attribute'.$row['attributeId']);}?></textarea>
											        </div>
											</div>
						                 		<?php
										  $i++;
										 }
									}
								?>
								</div>
					         		<div class="input-col col-xs-12 col-sm-12">
									<div class="form-group">
										<label>YouTube Video Link</label>
										<input class="form-control" name="videoLink" value="<?php echo set_value('videoLink');?>" type="text" placeholder="YouTube Video Link">
										<span class="error"><?php echo form_error('videoLink');?></span>
									</div>
							 	</div>
								<div class="input-col col-xs-12 col-sm-12">
									<div class="form-group">
									 <div class="row">
									 	<div class="col-md-3"><label>Watermark on Image :</label></div>
									 	<div class="col-md-1"><input class="form-control" <?php if($this->session->userdata('watermark')){ ?> checked="" <?php } ?> id="check_watermark" name="check_watermark" type="checkbox" style="margin-top: -6px"></div>
									 	<div class="col-md-6"><b>Note :</b>(check if you want watermark on image)</div>
									 </div>
									  <br />
									  <div id="watermark_color_div" <?php if(!$this->session->userdata('watermark_color')){ ?> style="display: none" <?php } ?> class="row">
									 	<div class="col-md-3"><label>Watermark text Color :</label></div>
									 	<div class="col-md-3">
		                                <input type="text" id="hue-demo" class="form-control demo" data-control="hue" <?php if($this->session->userdata('watermark_color')){ ?> value="<?php echo $this->session->userdata('watermark_color'); ?>" <?php } else { ?> value="#ffffff" <?php } ?>>
		                                </div>
							 	    </div> <br />
							 		<div class="row" id="watermark_text_div" <?php if(!$this->session->userdata('watermark')){ ?> style="display: none" <?php } ?>>
							 		<div class="col-md-3"><label>Watermark on Text :</label></div>
							 		<div class="col-md-9">
									    <?php
									      if($this->session->userdata('watermark'))
									       { ?>
										<input class="form-control" id="watermark_text" value="<?php echo $this->session->userdata('watermark'); ?>" type="text" style="" placeholder="Watermark Text">
										 <?php } else { ?>
										 	<input class="form-control" id="watermark_text" type="text" style="display: none" placeholder="Watermark Text">
							 				<?php } ?>
										<!--<span class="error"><?php echo form_error('title');?></span>-->
									</div>
									</div>
									</div>
							 	</div>
								<div class="input-col col-xs-12 col-sm-12" style="margin-top: 10px;">
					         		<div class="form-group">
										<label>Upload Files</label>
										<span style="color:green;"><br />(Note : Only jpg, png, jpeg file types are allowed.)<br /><br /></span>
									 	<div class="input-col col-xs-12 col-sm-12 fileupload-buttonbar">
					            					<span class="my_file btn btn-success gradient size-3 fileinput-button">
					                					<i class="glyphicon glyphicon-plus"></i>
					                					<span >Add files...</span>
					                					<input type="file" name="userfile" multiple>
					            					</span>
					            					<span  class="my_upload btn btn-primary start gradient size-3">
					                 					<i class="glyphicon glyphicon-upload"></i>
					                					<span>Start upload</span>
					            					</span>
					            					<span type="reset" class="btn btn-warning cancel gradient size-3">
					                					<i class="glyphicon glyphicon-ban-circle"></i>
					                					<span>Cancel upload</span>
					            					</span>
					            					<span type="button" class="btn btn-danger delete gradient size-3">
					                					<i class="glyphicon glyphicon-trash"></i>
					                					<span>Delete</span>
					            					</span>
					            					<!-- <input type="checkbox" class="toggle" style="width:10px;"> -->
					            					<label class="check-box" style="height: 16px; width: 16px; border: 1px solid rgb(102, 119, 102);">
					            						    <input id="" class="checkbox-input toggle" type="checkbox" value="" name="" /> <span class="check-box-sign"></span>
					            						</label>
											<div style="clear:both;"></div>
					            					<span class="fileupload-process"></span>
					        				</div>
					        				<div class="input-col col-xs-5 col-sm-5 fileupload-progress fade">
					            					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					                					<div class="progress-bar progress-bar-success" style="width:0%;"></div>
					            					</div>
					            					<div class="progress-extended">&nbsp;</div>
					        				</div>
					    				</div>
					    				<table role="presentation" class="table table-striped">
					    					<tbody class="files"></tbody>
					    				</table>
					      				<span class="error"><?php echo form_error('image');?></span>
								</div>
								<div class="input-col col-xs-12 col-sm-12">
								<?php
								if(!$this->session->userdata('competition_id'))
								{ ?>
								<button type="submit" name="Publish" value="Publish" class="btn size-1 btn-primary gradient btn-right">Publish</button>
								<button type="submit" name="Draft" value="Draft" class="btn size-1 btn-primary gradient btn-right">Draft</button>
								<?php if($this->session->userdata('user_institute_id')!='' )
									{ ?>
									<button type="submit" name="Private" value="Private" class="btn size-1 btn-primary gradient btn-right">Private</button>
								<?php
								 } }
								if($this->session->userdata('competition_id') && $this->session->userdata('competition_id')!='') { ?>
								<button type="submit" name="Publish" value="Publish" class="btn size-1 btn-primary gradient btn-right">Publish</button>
								<?php  } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
	</form>
			</div>
		</div>
	</div>
</div>
	<?php $this->load->view('template/footer');?>
<script src="<?php echo base_url();?>assets/script/jquery.minicolors.js"></script>
<script>
      $('#hue-demo').minicolors();
</script>
	<script>
		$(document).ready(function()
		{
			var url = $('#base_url').val();
			$('#check_watermark').click(function()
			{
				if($('#check_watermark').prop("checked") == true)
				{
					$('#watermark_text').show();
					$('#watermark_color_div').show();
					$('#watermark_text_div').show();
					var val = $("#watermark_text").val();
					var color = $("#hue-demo").val();
					if(val !='')
					{    $.blockUI();
						   $.ajax({
							   url: url+"project/set_watermark",
							   data: {val:val,color:color},
							   type: "POST",
			                   success:function(html)
							   {
							   	  $.unblockUI();
					           }
					       })
					}
				}
				else
				{
					$('#watermark_text').hide();
					$('#watermark_color_div').hide();
					$('#watermark_text_div').hide();
					var val = $("#watermark_text").val();
					var color = $("#hue-demo").val();
					if(val !='')
					{
						 $.blockUI();
						   $.ajax({
							   url: url+"project/unset_watermark",
							   data: {val:val,color:color},
							   type: "POST",
			                   success:function(html)
							   {
							   	 $.unblockUI();
					           }
					       })
					}
			   }
		})
			 $("#watermark_text").blur(function(){
			 	  var val = $("#watermark_text").val();
			 	  var color = $("#hue-demo").val();
		          if(val !='')
					{
						 $.blockUI();
						   $.ajax({
							   url: url+"project/set_watermark",
							   data: {val:val,color:color},
							   type: "POST",
			                   success:function(html)
							   {
							   	 $.unblockUI();
					           }
					       })
					}
		     });
		})
	</script>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td style="width: 100px;">
            <span class="preview"></span>
        </td>
        <td style="width: 100px;font-family: helveticaneue-light;font-size: 13px">
            <p class="name" style="width:100px;overflow:hidden;">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
			<input id="img_id" type='hidden' value="">
			<input class="water" name="water" type='hidden' >
		  </td>
        <td style="width: 70px;font-family: helveticaneue-light;">
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td style="width:120px;overflow;height;text-align: center;display:none">														        </td>
        <td style="width: 100px;font-family: helveticaneue-light;">
            {% if (!i && !o.options.autoUpload) { %}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="my_upload btn btn-primary gradient size-3 start">
                    <i class="my_upload glyphicon glyphicon-upload"></i>
                </span>
            {% } %}
        </td>
        <td style="width: 153px; text-align: left; word-spacing: -1px; font-family: helveticaneue-bold; line-height: 14px; font-size: 13px;">
        {% if (!i) { %}
            <span class="btn btn-warning gradient size-3 cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
            </span>
        {% } %}
        </td>
        </tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	  <tr class="template-download fade">
        <td style="width: 100px;">
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="90" src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td style="width: 100px;font-family: helveticaneue-light;">
            <p class="name" style="width: 100px;overflow:hidden;font-size: 13px">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td style="width: 70px;font-family: helveticaneue-light;">
            <span class="size">{%=file.size%} KB</span>
			 <span><input id="img_id" type='hidden' value="{%=file.id%}"  name="image[]" ></span>
        </td>
        <td style="width: 120px;font-family: helveticaneue-light;display:none">
        {% if (file.file_ext!=".zip") { %}
		<span style="float: left; margin-top: 6px; margin-right: 5px; font-family: helveticaneue-bold;">Price </span>
		<input type="text" style="width: 70px;" class="form-control" name="prize[]">
		{% } %}
		</td>
				<td style="width: 100px; text-align: center; word-spacing: -1px; font-family: helveticaneue-bold; line-height: 14px; font-size: 13px;">
				{% if (file.file_ext!=".zip") { %}
				      <input type="radio" class="cover_pic" name="cover_pic" value="{%=file.id%}"><br><span>Set as cover picture</span>
				      {% } %}
		        </td>
        <td valign="middle" style="width: 153px;font-family: helveticaneue-light;">
            {% if (file.deleteUrl) { %}
                <span class="btn btn-danger gradient size-3 delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                </span>
                <label class="check-box" style="height: 16px; width: 16px; border: 1px solid rgb(102, 119, 102);margin-bottom: 3px">
                	    <input class="checkbox-input toggle" type="checkbox"name="delete" value="1" /> <span class="check-box-sign"></span>
                	</label>
            {% } else { %}
                <span class="btn btn-warning gradient size-3 cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </span>
            {% } %}
        </td>
{% } %}
</script>
<script>
    function check_img()
	{
	  var ch = 0;
		if($('#img_id').val() == '')
		{
        	alert('Please Upload Image');
		 	ch++;
		}
		if(!$('.cover_pic').is(':checked'))
		{
			alert('Please select cover picture.');
		    ch++;
     	}
		if(ch==0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
</script>
<!--
<script src="<?php echo base_url();?>assets/script/fastselect.standalone.js"></script>-->
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
  <script src="<?php echo base_url();?>assets/script/jquery.tag-editor.js"></script>
	   <script src="<?php echo base_url();?>assets/script/jquery.caret.min.js"></script>
	   <script src="<?php echo base_url();?>assets/script/jquery-ui.min.js"></script>
	 <script>
			<?php
		     if(!empty($attribute))
		       {$i=1;
			    foreach($attribute as $row)
				{
					if(!empty($row['atrribute_value']))
					  {
						$str = implode(',', array_map(function($value) { return '"' . $value . '"';}, $row['atrribute_value']));
					  }
					  else
					  {
					  	$str ='';
					  }
			      echo  '$("#demo'.$i.'").tagEditor({
			            autocomplete: {
			                delay: 0, // show suggestions immediately
			                position: { collision: "flip" },
			                source: ['.$str.']
			            },
			            forceLowercase: false,
			            placeholder: "Attribute Value"
			        });';
				$i++;}} ?>
		</script>