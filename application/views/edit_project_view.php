<?php ini_set('memory_limit', '-1'); $this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
	.checkbox-inline, .radio-inline{
		padding-left: 36px;
	}
</style>
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>">
							Home
						</a>
					</li>
					<li class="active">
						Edit Project
					</li>
				</ol>
			</div>
			<div class="clearfix">
			</div>
			<div class="col-lg-12" style="margin-top:20px">
				<div class="panel panel-default AddProject">
					<div class="panel-body">
						<div class="add_project">
							<?php
							if(!empty($project_details)){ ?>
								
							<form class="form-horizontal" id="fileupload_edit" onsubmit="return check_img();" action="<?php echo base_url();?>project/edit_project/<?php if(!empty($project_details)){ echo $project_details[0]['id'];} ?><?php if(isset($assignment_Id) && !empty($assignment_Id)){ echo '/'.$assignment_Id;} ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="withoutCover" id="withoutCover" value="<?php echo $project_details[0]['withoutCover']; ?>">
								<div class="col-lg-6">
									<div class="input-col col-xs-12 col-sm-12" style="margin-top: 10px;">
										<?php

										if($project_details[0]['withoutCover'] == 1)
										{ ?>
										<div class="form-group">
											<div class="drag_here">
												<div class="input-col col-xs-12 col-sm-12 fileupload-buttonbar">
													<span class="my_file  fileinput-button">
														<i class="glyphicon glyphicon-plus">
														</i>
														<span >
															Add files...
														</span>
														<input type="file" name="userfile" multiple>
													</span>
													<div style="clear:both;">
													</div>
													<span class="fileupload-process">
													</span>
												</div>
											</div>
										</div>
										
										<style>
											.template_image_delete
											{
												position: absolute;
												float: right;
												border-radius: 50% ;
												top: 0px;
												padding: 2px 7px !important;
											}
											#edit_show_all_images
											{
												background: #e3e3e6 none repeat scroll 0 0;
											    border: 2px dashed  #626262;
											    overflow-x: scroll;
											}
										</style>
										<div class="col-lg-12 fileupload-progress fade">
											<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
												<div class="progress-bar progress-bar-success" style="width:0%;">
												</div>
											</div>
											<div class="progress-extended">
												&nbsp;
											</div>
										</div>
										<?php
										$ci    = & get_instance();
										$ci->load->model('project_model');
										$image = $ci->project_model->getSingleProjectImage($project_details[0]['id']);
										if(!empty($image))
										{
											$classs = "";
										}
										else
										{
											$classs = 'hide';
										}
										?>
										<div id="edit_show_all_images" class="form-group  ">
											<table role="presentation" class="table table-striped">
												<tbody>
													<tr class="files" style="background: none !important;">
														<?php
														if(!empty($image)){
															foreach($image as $row){
																if($row['content_type'] == 0){
																	if((file_exists(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']))){
																		?>
																		<td class="template-download fade in">
																			<span class="btn btn-danger gradient size-3 delete template_image_delete" data-url="<?php echo base_url();?>project/deleteImage/<?php echo $row['image_thumb']; ?>" data-type="DELETE">
																				<i class="fa fa-close">
																				</i>
																			</span>
																			<span class="preview">
																				<a data-gallery="" download="<?php echo $row['image_thumb']; ?>" title="<?php echo $row['image_thumb']; ?>" href="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $row['image_thumb']; ?>">
																					<img width="90" alt="thumb image" src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $row['image_thumb']; ?>">
																				</a>
																			</span>
																			<span>
																				<input id="img_id" type="hidden" name="image[]" value="<?php echo $row['id']; ?>">
																			</span>
																			<?php
																			if($row['cover_pic'] == 1)
																			{
																				$ch = 'checked=""';
																			}
																			else
																			{
																				$ch = '';
																			}?>
																			<span>
																				<br><input class="cover_pic"  <?php echo $ch;?> type="radio" value="<?php echo $row['id']; ?>" name="cover_pic">Cover Pic
																			</span>
																		</td>
																		<?php
																	}
																}
																else
																{
																	if((file_exists(file_upload_s3_path().'project/'.$row['image_thumb']))){
																		?>
																		<td class="template-download fade in">
																			<span class="btn btn-danger gradient size-3 delete template_image_delete" data-url="<?php echo base_url();?>project/deleteImage/<?php echo $row['image_thumb']; ?>" data-type="DELETE">
																				<i class="fa fa-close">
																				</i>
																			</span>
																			<span class="preview">
																				<a data-gallery="" download="zip.png" title="zip.png" href="<?php echo base_url();?>assets/img/zip.png">
																					<img width="90" alt="thumb image" src="<?php echo base_url();?>assets/img/zip.png">
																				</a>
																			</span>
																			<span>
																				<input id="img_id" type="hidden" name="image[]" value="<?php echo $row['id']; ?>">
																			</span>
																		</td>
																		<?php
																	}
																}
															}
														}  ?>
													</tr>
												</tbody>
											</table>
										</div>
										<?php
										}
										?>
									</div>
								<!--	if($project_details[0]['categoryId'] == 4 || $project_details[0]['categoryId'] == 5 || $project_details[0]['categoryId'] == 6)
									{-->
										<div class="form-group">
											<label class="col-sm-4 control-label">
												YouTube Video Link
											</label>
											<div class="col-sm-8">
												<input class="form-control" name="videoLink" <?php
												if($project_details[0]['videoLink'] != '')
												{
													?> value="https://www.youtube.com/watch?v=<?php echo $project_details[0]['videoLink'];?>" <?php
												}
												else
												{
													?>value="<?php echo set_value('videoLink');?>"<?php
												} ?>type="text" placeholder="YouTube Video Link">
												<span class="error">
													<?php echo form_error('videoLink');?>
												</span>
											</div>
										</div>
										<?php
										if($project_details[0]['videoLink'] != ''){
											?>
											<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $project_details[0]['videoLink'];?>?rel=0" frameborder="0" allowfullscreen>
											</iframe>
											<?php
										}
									/*}*/
									$ci = & get_instance();
									$ci->load->model('project_model');
									if(!empty($attribute)){
										?>
										<div class="form-group">
											<label class="col-sm-4 control-label" id = "attri_name">
												Attribute Values
											</label>
											<div class="col-sm-8">
											</div>
										</div>
										<div id="attri">
											<?php
											$i = 1;
											foreach($attribute as $row){
												$data = $ci->project_model->get_attribute_value($row['attributeId'],$project_details[0]['id']);
												?>
												<div class="form-group">
													<label class="col-sm-4 control-label">
														<?php echo $row['attributeName'];?>
													</label>
													<div class="col-sm-8">
														<textarea name="attribute<?php echo $row['attributeId']; ?>" id="editDemo<?php echo $i; ?>">
															<?php
															if(!empty($data) && !empty($data['attributeValue']))
															{
																echo implode(',',$data['attributeValue']);
															}?>
														</textarea>
													</div>
												</div>
												<?php
												$i++;
											}
											?>
										</div>
										<?php
									}
									else
									{  ?>

										<div class="form-group">
											<label class="col-sm-4 control-label" id = "attri_name" >
												
											</label>
											<div class="col-sm-8">
											</div>
										</div>
										<div id="attri">									
										</div>

									<?php	} ?>
								</div>
								<div class="col-lg-6">
									<div class="">
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Project Name
											</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo $project_details[0]['projectName'];?>" name="projectName" class="form-control" placeholder="Project Name">
												<span class="error">
													<?php echo form_error('projectName');?>
												</span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Category
											</label>
											<div class="col-sm-8">
												<select class="form-control" name="categoryId" id="categoryId" onchange="getAttributeValue(this)" >
													<option value="">- - Select Category - -</option>
													<?php
													foreach($projectCategory as $cat){
														if($cat['id'] == $project_details[0]['categoryId']){
															$selected = 'selected=""';
															?>
															<option <?php echo $selected; ?>  value="<?php echo $cat['id'];?>" <?php echo set_select('category_name', $cat['id']); ?>>
																<?php echo $cat['categoryName']?>
															</option>
															<?php
														}else{
														?>
														<option value="<?php echo $cat['id'];?>" <?php echo set_select('category_name', $cat['id']); ?>>
															<?php echo $cat['categoryName']?>
														</option>
														<?php
														}
													}	  ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Type
											</label>
											<?php
											if($project_details[0]['projectType'] == 'Academic'){
												$y = 'checked="checked"';
												$n = '';
											}
											else
											{
												$y = '';
												$n = 'checked="checked"';
											}
											?>
											<label class="radio-inline">
												<input type="radio" <?php echo $y;?> name="projectType" value="Academic" <?php echo set_radio('projectType','Academic');?>> Academic
											</label>
											<label class="radio-inline">
												<input type="radio" <?php echo $n;?> name="projectType" value="Professional" <?php echo set_radio('projectType','Professional');?>> Professional
											</label>
											<span class="error">
												<?php echo form_error('projectType');?>
											</span>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Status
											</label>
											<?php
											if($project_details[0]['projectStatus'] == 1){
												$y = 'checked="checked"';
												$n = '';
											}
											else
											{
												$y = '';
												$n = 'checked="checked"';
											}
											?>
											<label class="radio-inline">
												<input type="radio" <?php echo $y;?> name="projectStatus" value="1" <?php echo set_radio('projectStatus','1');?>> Completed
											</label>
											<label class="radio-inline">
												<input type="radio" <?php echo $n;?> name="projectStatus" value="0" <?php echo set_radio('projectStatus','0');?>> Work in Progress
											</label>
											<span class="error">
												<?php echo form_error('projectStatus');?>
											</span>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Is this your showreel ?
											</label>
											<?php
											if($project_details[0]['showreel'] == 1){
												$y = 'checked="checked"';
												$n = '';
											}
											else
											{
												$y = '';
												$n = 'checked="checked"';
											}
											?>
											<label class="checkbox-inline">
												<input type="checkbox" <?php echo $y;?> name="showreel" value="1" > Yes
											</label>
										</div>	
									</div>
									<div class="">
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Social Features
											</label>
											<?php
											if($project_details[0]['socialFeatures'] == 1){
												$y = 'checked="checked"';
												$n = '';
											}
											else
											{
												$y = '';
												$n = 'checked="checked"';
											}
											?>
											<label class="radio-inline">
												<input type="radio"  <?php echo $y;?>  name="socialFeatures" value="1" <?php echo set_radio('socialFeatures','1');?>> Yes
											</label>
											<label class="radio-inline">
												<input type="radio" <?php echo $n;?> name="socialFeatures" value="0" <?php echo set_radio('socialFeatures','0');?>> No
											</label>
											<span class="error">
												<?php echo form_error('socialFeatures');?>
											</span>
										</div>
										<!-- <div class="form-group">
											<label class="col-sm-4 control-label">
												Watermark on Image :
											</label>
											<div class="checkbox-inline col-lg-8">
												<label>
													<input type="checkbox" value="" class="waterMark" id="waterMarkCheck">(check if you want watermark on image)
												</label>
											</div>
										</div> -->
										<div class="watermark hide">
											<div class="form-group">
												<label class="col-sm-4 control-label">
													Watermark text Color :
												</label>
												<div class="col-sm-8">
													<input type="text" class="form-control demo " id="hue-demo1" name="watermark_color"  data-control="hue" value="#fff">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">
													Watermark on Text :
												</label>
												<div class="col-sm-8">
													<?php
													if($this->session->userdata('watermark')){
														?>
														<input type="text" value="<?php echo $this->session->userdata('watermark'); ?>" name="watermark_text_edit" id="watermark_text_edit" class="form-control" placeholder="Watermark Text">
														<?php
													}
													else
													{
														?>
														<input type="text" name="watermark_text_edit" id="watermark_text_edit" class="form-control" placeholder="Watermark Text">
														<?php
													} ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Description
											</label>
											<div class="col-sm-8">
												
												<input type="text" value="<?php echo $project_details[0]['basicInfo'];?>" name="basicInfo" class="form-control" placeholder="Type Description/Project background here">
												<span class="error">
													<?php echo form_error('basicInfo');?>
												</span>
											</div>
										</div>
										<input type="hidden" name="title" value="<?php echo $project_details[0]['projectName'];?>" >
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Thought Process
											</label>
											<div class="col-sm-8">
												
												<input type="text" value="<?php echo $project_details[0]['thought'];?>" name="thought" class="form-control" placeholder="Talk about your thought process">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Add keywords
											</label>
											<div class="col-sm-8">
												<textarea name="keywords" id="edit_keyword">
												<?php echo $project_details[0]['keyword'];?>
												</textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">
												Copyright Settings?
											</label>
											<?php
											if($project_details[0]['copyright'] == 1){
												$y = 'checked="checked"';
												$n = '';
											}
											else
											{
												$y = '';
												$n = 'checked="checked"';
											}
											?>
											<label class="radio-inline">
												<input type="radio" <?php echo $n;?> name="copyright" value="0" <?php echo set_radio('copyright','0');?>> Creative Commons (CC) Licence
											</label>
											<label class="radio-inline">
												<input type="radio" <?php echo $y;?> name="copyright" value="1" <?php echo set_radio('copyright','1');?>> Requires Permission
											</label>
										</div>
										<div class="form-group" id="copyrightMsg" <?php	if($project_details[0]['copyright'] == 1){ echo 'style="display:block"';}else{ echo 'style="display:none"';}?>>
											<label class="col-sm-12 control-label note">
												By selecting this option, you are choosing not to allow any posting/use of your work without your permission.
											</label>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="buttons">
										<div class="pull-right">
										<a href="<?php echo base_url();?>project/manage_projects" class="btn btn_blue">Cancel</a>
											<?php
											if(!empty($project_details) && $project_details[0]['competitionId'] == 0){
												?>
													<?php if(!isset($assignment_Id) && empty($assignment_Id))
												{ ?>

												<button type="submit" name="Draft" value="Draft" class="btn btn_blue">
													Draft
												</button>
												<?php  }
												
											} ?>
												<?php if(!isset($assignment_Id) && empty($assignment_Id))
											{ ?>
											<button type="submit" name="Publish" value="Publish" class="btn btn_orange">
												Publish
											</button>
											<?php } ?>


											<?php
											if(!empty($project_details) && $project_details[0]['competitionId'] == 0){
												

												if($this->session->userdata('user_institute_id') != '' ){
													?>
													<button type="submit" name="Private" value="Private" class="btn btn_blue">
														Private
													</button>
													<?php
												}

												 }  ?>
										</div>
									</div>
								</div>
							</form>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php $this->load->view('template/footer');?>
<script>
	$('#hue-demo1').minicolors();
	function check_img()
	{
		
		var ch = 0;
		if($('#fileupload_edit #withoutCover').val() == 1){
			if($('#fileupload_edit #img_id').val() == '')
			{
				alert('Please Upload Image');
				ch++;
			}
			if(!$('#fileupload_edit .cover_pic').is(':checked'))
			{
				alert('Please select cover picture.');
				ch++;
			}
		}else{
			ch==0;
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
	$(document).ready(function() {
		$('#waterMarkCheck').on('click',function()
		{
			if($(this).prop('checked')==true)
			{
				$('.watermark').removeClass('hide');
			}
			else
			{
				$('.watermark').addClass('hide');
			}
		});
	});
</script>
<script>
	$("#edit_keyword").tagEditor({autocomplete: {delay: 0,position: { collision: "flip" },source: []},forceLowercase: false,placeholder: "Keywords"});
</script>
<script>
	<?php
	if(!empty($attribute))
	{
		$i=1;
		foreach($attribute as $row)
		{
			if(!empty($row['atrribute_value']))
			{
				$str = implode(',', array_map(function($value) { return   $value;}, $row['atrribute_value']));
			}
			else
			{
				$str ='';
			}		

			echo  '$("#editDemo'.$i.'").tagEditor({
			autocomplete: {
			delay: 0, // show suggestions immediately
			position: { collision: "flip" },
			source: ['.$str.']
			},
			forceLowercase: false,
			placeholder: "Attribute Value"
			});';
			$i++;
		}
	}
	?>
</script>

<script>
	function getAttributeValue() {
	    var project_category = document.getElementById("categoryId").value;
	    var projectId = '<?php echo $this->uri->segment(3);?>';	   
	    $.ajax({
	    	url: '<?php echo base_url();?>project/getProjectAttributeValue',
	    	type: 'POST',	    	
	    	data: {project_category: project_category,projectId : projectId},
	    })
	    .done(function(html) {
	    	data=$.parseJSON(html);	    	
	    /*	if(data = '')
	    	{
	    		$('#attri_name').html('');    		

	    	}
	    	else
	    	{*/
	    		$('#attri_name').html(''); 
	    		$('#attri').html('');
	    		if(data !='')
	    		{
	    			$('#attri_name').append('Attribute Values'); 
	    		}
	    		
	    		$.each(data, function(index, val) {
	    			
	    			indexVal=index+1;

	    			$('#attri').append('<div class="form-group"><label class="col-sm-4 control-label">'+val.attributeName+'</label><div class="col-sm-8"><textarea name="attribute'+val.id+'" id="editDemo'+indexVal+'">'+val.atrribute_value+'</textarea></div></div>');
	    			$('#editDemo'+indexVal).tagEditor({
	    						autocomplete: {
	    						delay: 0, // show suggestions immediately
	    						position: { collision: "flip" },
	    						source: '<?php echo base_url();?>project/getProjectAttributes/'+project_category
	    						},
	    						forceLowercase: false,
	    						placeholder: "Attribute Value"
	    						});	    		
	    		});

	    	/*}
	    */	

	    }); 
	}
	
</script>
<script>
	$('input[type=radio][name=copyright]').change( function() 
	{
	 	var copyright=$('input[name=copyright]:checked', '#fileupload_edit').val();
	 	if(copyright==1)
	 	{
	 		$("#copyrightMsg").css('display', 'block');
	 	}   
	 	else
	 	{
	 		$("#copyrightMsg").css('display', 'none');
	 	}
	});
</script>



