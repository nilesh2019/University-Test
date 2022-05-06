<?php $this->load->view('template/header');?>
<!-- MAIN CONTENT -->
<style>
.navbar {
    background-color:rgb(0,0,0);
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
						Help
					</li>
				</ol>
			</div>
			<div class="container">	
			<?php	
			//$title=array('Creosouls: Student - LogIn','Creosouls: Student - Add Project on creosouls','Creosouls: Teacher - Add assignments on Creosouls','Creosouls: Student -  Manage assignments on Creosouls','Creosouls:  Teacher - Review and Rate the assignments','Creosouls: Institute Admin - Change Cover Picture and Logo','Creosouls: Institute Admin - Project Approval','Creosouls: Institute Admin - Add Competation','Creosouls: Institute Admin - Job Application Approval or Rejection');

			//$iframe=array('https://www.youtube.com/embed/ns55XjhM8x0?rel=0','https://www.youtube.com/embed/Uis_b8F3FTk?rel=0','https://www.youtube.com/embed/m5vLG4l089c?rel=0','https://www.youtube.com/embed/L05toZtzqI8?rel=0','https://www.youtube.com/embed/xfkIQZCtu1U?rel=0','https://www.youtube.com/embed/G69wcn8lU8M?rel=0','https://www.youtube.com/embed/Gp6Lgcq-8Wo?rel=0','https://www.youtube.com/embed/aqkkiO28c_s?rel=0','https://www.youtube.com/embed/sFNdFsRRsOk?rel=0');	

			$title=array('Creosouls: Student - LogIn','Creosouls: Student - Add Project on creosouls','Creosouls: Teacher - Add assignments on Creosouls','Creosouls: Student -  Manage assignments on Creosouls','Creosouls:  Teacher - Review and Rate the assignments','Creosouls: Institute Admin - Change Cover Picture and Logo','Creosouls: Institute Admin - Project Approval','Creosouls: Institute Admin - Add Competation','Creosouls: Institute Admin - Job Application Approval or Rejection','Creosouls: Institute Admin - Declare The Winner','Creosouls: Upload you tube video link','Creosouls: Team Competition Flow');

			$iframe=array('https://www.youtube.com/embed/ns55XjhM8x0?rel=0','https://www.youtube.com/embed/Uis_b8F3FTk?rel=0','https://www.youtube.com/embed/m5vLG4l089c?rel=0','https://www.youtube.com/embed/L05toZtzqI8?rel=0','https://www.youtube.com/embed/xfkIQZCtu1U?rel=0','https://www.youtube.com/embed/G69wcn8lU8M?rel=0','https://www.youtube.com/embed/Gp6Lgcq-8Wo?rel=0','https://www.youtube.com/embed/aqkkiO28c_s?rel=0','https://www.youtube.com/embed/sFNdFsRRsOk?rel=0','https://www.youtube.com/embed/Y86Skl4HuJY','https://www.youtube.com/embed/6hkrirXS2FE','https://www.youtube.com/embed/Sfnpd_tdBD4');	

			for($i=0; $i<12; $i++)
				{
				?>
					   
			    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
				    <div style="color: red; font-weight: bold;">
				    <h2>
				  		<?php echo $title[$i];?>
				  		 </h2>
				    </div>
			         <article class="isotopeElement bg_post post">
			              <div class="post_thumb thumb video_2columns">
			                  <div class="sc_video_player">
			                      <div class="sc_video_frame">			                   
			                      <iframe width="560" height="315" src="<?php echo $iframe[$i];?>" frameborder="0" allowfullscreen></iframe>
			                      </div>
			                  </div>            
			              </div>            
			          </article>
			      </div>           
		 

		    <?php  } ?>
			 </div> 


		</div>
	</div>
	<div id="load_img_div" style="width:400px;">
	</div>
	<!--<div id="msg_div"></div>-->
	<input type="hidden" id="call_count" value="2"/>
	<input type="hidden" id="userId" value="<?php
	if($this->session->userdata('front_user_id'))
	{
		echo $this->session->userdata('front_user_id');
	}?>"/>
	<input type="hidden" id="fLoggedIn" value="<?php
	if($this->session->userdata('front_is_logged_in'))
	{
		echo $this->session->userdata('front_is_logged_in');
	}?>"/>
</div>
<?php $this->load->view('template/footer');?>

