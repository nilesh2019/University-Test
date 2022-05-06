<?php $this->load->view('template/header');
//print_r($jobs);die;?>
<style>
	.be-comment-content{
		margin-left:0px;
	}
	.noto-text{
		margin-left:10px;
	}
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<!-- MAIN CONTENT -->
<div id="content-block">
	<div class="container be-detail-container">
		<div class="row">
<div class="col-xs-12 col-md-12_editor-content_">
<form id="defaultForm" method="post" class="form-horizontal" action="<?php echo base_url();?>job/uploadResume" enctype="multipart/form-data" style="margin-top:150px;margin-bottom:150px;min-height:500px;">
	<div class="affix-block" id="basic-information">
		<div class="be-large-post">
			<div class="info-block style-2">
			<?php $CI =& get_instance();
			$CI->load->model_basic;
			$loggedInUser=$CI->model_basic->loggedInUserInfo();
			//print_r($loggedInUser);die;?>
				<div class="be-large-post-align"><h3 class="info-block-label"><?php echo $loggedInUser['firstName'];?> Upload Your Resume</h3></div>
			</div>
			<div class="form-group">
			   <label class="col-md-3 control-label">Upload Your Resume</label>
			   <div class="col-md-8">
				<span>(Note: Only .doc, .docx, .pdf file types are allowed.)</span>
			   <input class="file-input" type="file" name="resume">
			   <input type="hidden" name="userId" value="<?php echo $this->session->userdata('front_user_id');?>">
			   <input type="hidden" name="jobId" value="<?php echo $jobs[0]['id']?>">	</div>
			</div>
				<input class="btn btn-primary size-1 gradient col-md-2" style="float:right" type="submit" name="submit" value="Submit">
				<a href="<?php echo base_url();?>job" class="btn btn-primary size-1 gradient col-md-2" style="float:right">Cancel</a>
	</div>
	</div>
	</form>
	</div>
	</div>
	</div>
	</div>
<?php $this->load->view('template/footer');?>