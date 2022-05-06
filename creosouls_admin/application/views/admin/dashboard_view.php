<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$this->load->view('admin/template/header');?>
<!-- Header Ends -->
<style>
	.left_30
	{
		margin-right: 30px;
	}
	.scrollBody{
		min-height: 50px;
		max-height: 300px;
		overflow-y: auto;
		display:block;
		overflow-x: hidden;
	}
	.fixTable thead, tbody tr{
		/*display:table;*/
	    width:100%;
	    table-layout:fixed;
	}
	/*.fixTable thead, tbody tr{
	   display:table-row;
	 }*/
	 .fixTable thead, tbody tr .vd_bg-blue .vd_white{
	 	display: table;
	 }
	 .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #DDD;
}
        #scrolly{
            width: 100%;
            height: 190px;
            overflow: auto;
            overflow-y: hidden;
            margin: 0 auto;
            white-space: nowrap
        }
</style>
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
								<li>
									<a href="<?php echo base_url();?>admin/dashboard">
										Home
									</a>
								</li>
								<li class="active">
									University Dashboard 
								</li>
							</ul>
							<div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
								<div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu">
									<i class="fa fa-arrows-h">
									</i>
								</div>
								<div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu">
									<i class="fa fa-arrows-v">
									</i>
								</div>
								<div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu">
									<i class="glyphicon glyphicon-fullscreen">
									</i>
								</div>
							</div>
						</div>
					</div>
					<!-- vd_head-section -->
					<div class="vd_title-section clearfix">
						<div class="vd_panel-header">
							<h1>
								University Dashboard
							</h1>
							<small class="subtitle">
								University Dashboard
							</small>
							<div class="vd_panel-menu  hidden-xs">
								<div class="menu no-bg vd_red" data-original-title="Start Layout Tour Guide" data-toggle="tooltip" data-placement="bottom" onClick="javascript:introJs().setOption('showBullets', false).start();">
									<span class="menu-icon font-md">
										<i class="fa fa-question-circle">
										</i>
									</span>
								</div>
								<!-- menu -->

							</div>
							<!-- vd_panel-menu -->
						</div>
						<!-- vd_panel-header -->
					</div>
					<!-- vd_title-section -->
				<?php

					$foot = '</div></div>';
				?>
					<div class="vd_content-section clearfix">
						<div class="row">
						<?php
						$CI =&get_instance();
						$CI->load->model('modelbasic');
						?>

							<?php if($this->session->userdata('admin_level') == 1) { ?>
								<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
									<div class="vd_status-widget vd_bg-red widget">
										<div class="vd_panel-menu">
											<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
												<i class="icon-cycle">
												</i>
											</div>
										</div>
										<a class="panel-body" href="<?php echo base_url();?>admin/users">
											<div class="clearfix">
												<span class="menu-icon">
													<i class="icon-users">
													</i>
												</span>
												<span class="menu-value">
													<?php /*
													if($this->session->userdata('admin_level') == 2){
														$condition = array('instituteId'=>$this->session->userdata('instituteId'));
													}
													else
													{
														$condition = array();
													}
													$totalUsers = $CI->modelbasic->count_all_only('users',$condition);*/

													$people_count1=$this->modelbasic->getCountWhere('users',array('instituteId'=>'0'));
													$people_count2=$this->modelbasic->getCountWhere('institute_csv_users',array('centerId'=>'1'));

													echo $people_count1+$people_count2;
													?>
												</span>
											</div>
											<div class="menu-text clearfix">
												Total Users
											</div>
										</a>
										<?php echo $foot; } ?>
								<?php if($this->session->userdata('admin_level') != 3 && $this->session->userdata('admin_level') != 5) { ?>
										<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
											<div class="vd_status-widget vd_bg-black  widget" style="background:rgb(132,30,205) !important;">
												<div class="vd_panel-menu">
													<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
														<i class="icon-cycle">
														</i>
													</div>
												</div>
												<!-- vd_panel-menu -->

												<a class="panel-body" href="<?php echo base_url();?>admin/users">
													<div class="clearfix">
														<span class="menu-icon">
															<i class="icon-user">
															</i>
														</span>
														<span class="menu-value">
															<?php
															$totalProjects = $CI->modelbasic->count_all_new('users');
															echo $totalProjects;
															?>
														</span>
													</div>
													<div class="menu-text clearfix">
														New Users
													</div>
												</a>
											</div>
										</div>										
										<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
											<div class="vd_status-widget vd_bg-red  widget" style="">
												<div class="vd_panel-menu">
													<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
														<i class="icon-cycle">
														</i>
													</div>
												</div>
												<!-- vd_panel-menu -->

												<a class="panel-body" href="<?php echo base_url();?>admin/users">
													<div class="clearfix">
														<span class="menu-icon">
															<i class="icon-user">
															</i>
														</span>
														<span class="menu-value">
															<?php
															$totalProjects = $CI->modelbasic->count_all_register('users');
															echo $totalProjects;
															?>
														</span>
													</div>
													<div class="menu-text clearfix">
														Registered Student's
													</div>
												</a>
											</div>
										</div>
										<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
											<div class="vd_status-widget vd_bg-red  widget" style="">
												<div class="vd_panel-menu">
													<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
														<i class="icon-cycle">
														</i>
													</div>
												</div>

												<a class="panel-body" href="<?php echo base_url();?>admin/users">
													<div class="clearfix">
														<span class="menu-icon">
															<i class="icon-user">
															</i>
														</span>
														<span class="menu-value">
															<?php
															$totalProjects = $CI->modelbasic->count_all_login('users');
															//echo $this->db->last_query();
															echo $totalProjects;
															?>
														</span>
													</div>
													<div class="menu-text clearfix">
														Logged In Student's
													</div>
												</a>
											</div>
										</div>
										<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
											<div class="vd_status-widget vd_bg-yellow widget"	style="background:purple !important;">
												<div class="vd_panel-menu">
													<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
														<i class="icon-cycle">
														</i>
													</div>
												</div>
												<!-- vd_panel-menu -->
												<a class="panel-body" href="#">
													<div class="clearfix">
														<span class="menu-icon">
															<i class="icon-users">
															</i>
														</span>
														<span class="menu-value">
															<?php
																$CI->load->model('modelbasic');
																$logincount = $CI->modelbasic->count_all_login();
																$registercount = $CI->modelbasic->count_all_register();
																echo $loginpercentage=round(($logincount/$registercount)*100);
															?>
														</span>
													</div>
													<div class="menu-text clearfix">
														Login Percentage
													</div>
												</a>
											
											<?php echo $foot;?>
											
									<?php if($this->session->userdata('admin_level') == 1){?>
									<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
										<div class="vd_status-widget vd_bg-facebook widget">
											<div class="vd_panel-menu">
												<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
													<i class="icon-cycle">
													</i>
												</div>
											</div>
											<!-- vd_panel-menu -->
											<a class="panel-body" href="#">
												<div class="clearfix">
													<span class="menu-icon">
														<i class="icon-users">
														</i>
													</span>
													<span class="menu-value">
														<?php
														$condition = array('visit_referrer'=>'https://www.facebook.com');
														$group_by   = 'visit_visitor_id';
														$totalUsers = $CI->modelbasic->countAllOnly('visit',$condition,$group_by);
														echo $totalUsers;
														?>
													</span>
												</div>
												<div class="menu-text clearfix">
													Unique Fb Users
												</div>
											</a>
											<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-facebook widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="#">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												$condition = array('visit_referrer'=>'https://www.facebook.com');
												$totalUsers = $CI->modelbasic->count_all_only('visit',$condition);
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Total Fb Users
										</div>
									</a>
									<?php echo $foot;  } ?>
								<!-- <div class="row">-->
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-xs-15">
								<div class="vd_status-widget vd_bg-yellow widget" style="background:rgb(8,103,185) !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->

									<a class="panel-body"  href="<?php echo base_url();?>admin/projects">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-pictures">
												</i>
											</span>
											<span class="menu-value">
												<?php
												if($this->session->userdata('admin_level') == 2){
													$totalProjects = $CI->modelbasic->count_institute_project();
												}
												elseif($this->session->userdata('admin_level') == 4){
													$totalProjects = $CI->modelbasic->count_institute_project();
												}
												else
												{
													$totalProjects = $CI->modelbasic->count_where('project_master','status','1');
												}
												echo $totalProjects;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Active Projects
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-xs-15">
								<div class="vd_status-widget vd_bg-yellow widget" style="background:rgb(237,122,7) !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body"  href="<?php echo base_url();?>admin/projects">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-pictures">
												</i>
											</span>
											<span class="menu-value">
												<?php
												if($this->session->userdata('admin_level') == 2){
													$totalProjects = $CI->modelbasic->count_institute_project_all();
												}
												elseif($this->session->userdata('admin_level') == 4){
													$totalProjects = $CI->modelbasic->count_institute_project_all();
												}
												else
												{
													$totalProjects = $CI->modelbasic->count_all('project_master');
												}
												echo $totalProjects;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Total Projects
										</div>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-xs-15">
								<div class="vd_status-widget vd_bg-yellow widget" style="background:rgb(237,122,7) !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body"  href="<?php echo base_url();?>admin/projects">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-pictures">
												</i>
											</span>
											<span class="menu-value">
												<?php
												
												$totalProjects = $CI->modelbasic->count_institute_project_pending('project_master');
												//echo $this->db->last_query();die;

												echo $totalProjects;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Pending Projects
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-xs-15">
								<div class="vd_status-widget vd_bg-yellow widget" style="background:rgb(8,103,185) !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body"  href="<?php echo base_url();?>admin/projects">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="fa fa-picture-o">
												</i>
											</span>
											<span class="menu-value">
												<?php
												if($this->session->userdata('admin_level') == 2){
													$totalProjects = $CI->modelbasic->count_institute_new_project();
												}
												elseif($this->session->userdata('admin_level') == 4){
													$totalProjects = $CI->modelbasic->count_institute_new_project();
												}
												else
												{
													$totalProjects = $CI->modelbasic->count_all_new('project_master');
												}
												echo $totalProjects;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											New Projects
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-black widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
								<!-- vd_panel-menu -->
								<a class="panel-body"  href="<?php echo base_url();?>admin/competition">
									<div class="clearfix">
										<span class="menu-icon">
											<i class="fa fa-picture-o">
											</i>
										</span>
										<span class="menu-value">
											<?php
											if($this->session->userdata('admin_level') == 2){
												$totalCompetitions = $CI->modelbasic->count_all('competitions');
											}
											elseif($this->session->userdata('admin_level') == 4){
												$totalCompetitions = $CI->modelbasic->count_all('competitions');
											}
											else
											{
												$totalCompetitions = $CI->modelbasic->count_all('competitions');
											}
											echo $totalCompetitions;
											?>
										</span>
									</div>
									<div class="menu-text clearfix">
										Total Competitions
									</div>
								</a>
								<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-black widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
								<!-- vd_panel-menu -->
								<a class="panel-body"  href="<?php echo base_url();?>admin/competition">
									<div class="clearfix">
										<span class="menu-icon">
											<i class="fa fa-picture-o">
											</i>
										</span>
										<span class="menu-value">
											<?php
											if($this->session->userdata('admin_level') == 2){
												$activeCompetitions = $CI->modelbasic->count_all_new('competitions');
											}
											elseif($this->session->userdata('admin_level') == 4){
												$activeCompetitions = $CI->modelbasic->count_all_new('competitions');
											}
											else
											{
												$activeCompetitions = $CI->modelbasic->count_all_competitions('competitions','status','1','','');
											}
											echo $activeCompetitions;
											?>
										</span>
									</div>
									<div class="menu-text clearfix">
										Active Competitions
									</div>
								</a>
								<?php echo $foot; } ?>
								<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-googleplus widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalUsers = $CI->dashboard_model->getAll_jobs();
												//echo $this->db->last_query();
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Total Jobs
										</div>
									</a>
								<?php echo $foot;?>
								<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								 <div class="vd_status-widget vd_bg-googleplus widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalclinets= $CI->dashboard_model->getAll_client(0);
												echo $totalclinets;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											No of Companies
										</div>
									</a>
								<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-grey widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalUsers = $CI->dashboard_model->getAll_jobs_users(1);
	   											//echo $this->db->last_query();
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Applied Candidates
										</div>
									</a>
								<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-twitter widget">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalUsers = $CI->dashboard_model->getAll_jobs_users(2);
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Shortlisted Candidates
										</div>
									</a>
								<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-red widget" style="background:rgb(80, 175, 0) none repeat scroll 0 0 !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalUsers = $CI->dashboard_model->getAll_jobs_users(3);
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Selected Candidates
										</div>
									</a>
								<?php echo $foot;?>
							<div class="col-lg-3 col-md-6 col-sm-6 mgbt-sm-15">
								<div class="vd_status-widget vd_bg-yellow widget"	style="background:purple !important;">
									<div class="vd_panel-menu">
										<div data-action="refresh" data-original-title="Refresh" data-rel="tooltip" class=" menu entypo-icon smaller-font">
											<i class="icon-cycle">
											</i>
										</div>
									</div>
									<!-- vd_panel-menu -->
									<a class="panel-body" href="<?php echo base_url();?>admin/jobs">
										<div class="clearfix">
											<span class="menu-icon">
												<i class="icon-users">
												</i>
											</span>
											<span class="menu-value">
												<?php
												/*$CI =&get_instance();*/
												$CI->load->model('dashboard_model');
												$totalUsers = $CI->dashboard_model->getAll_jobs_users(4);
												echo $totalUsers;
												?>
											</span>
										</div>
										<div class="menu-text clearfix">
											Job Offered Candidates
										</div>
									</a>
									<?php echo $foot;?>

									
							</div>

						<div class="row">
							<?php
								if($this->session->userdata('admin_level')!=3 && $this->session->userdata('admin_level') != 5)
								{
									$class1 = 'class="col-md-7"';
									$class2 = '';
									$class3 = 'class="col-md-5"';
								}
								else{
									$class1 = 'class="hide"';
									$class2 = 'hide';
									$class3 = 'class="col-md-6"';
								}
							?>
							<div <?php echo $class1;?>>
								<div class="row">
									<div class="col-md-12">
										<div class="tabs widget">
											<ul class="nav nav-tabs widget">
												<li class="active">
													<a data-toggle="tab" href="#home-tab">
														<span class="menu-icon">
															<i class="fa fa-comments">
															</i>
														</span>
														Recent Comments
														<span class="menu-active">
															<i class="fa fa-caret-up">
															</i>
														</span>
													</a>
												</li>


												<li>
													<a data-toggle="tab" href="#list-tab">
														<span class="menu-icon">
															<i class="fa fa-user">
															</i>
														</span>
														New Users
														<span class="menu-active">
															<i class="fa fa-caret-up">
															</i>
														</span>
													</a>
												</li>
											</ul>

											<div class="tab-content">
												<div id="home-tab" class="tab-pane active">
													<div class="content-list content-image menu-action-right">
														<div data-rel="scroll" data-scrollheight="550">
															<ul class="list-wrapper pd-lr-15">
																<?php
																if(!empty($recent_comment)){
																	foreach($recent_comment as $row){
																		?>
																		<li>
																			<div class="menu-icon">
																				<a href="#">
																					<?php
																					if(file_exists(file_upload_absolute_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_absolute_path().'users/thumbs/'.$row['profileImage']) > 0){
																						$profileImage = '<img width="40" height="40" src="'.file_upload_base_url().'users/thumbs/'.$row['profileImage'].'">';
																					}
																					else
																					{
																						$profileImage = '<img width="40" height="40" src="'.base_url().'backend_assets/img/noimage.jpg">';
																					}
																					echo $profileImage;
																					;?>
																				</a>
																			</div>
																			<div class="menu-text">
																				<?php echo $row['comment'];?>
																			</div>
																			<div class="menu-text">
																				<div class="menu-info">
																					By
																					<a href="javascript:void('0');" style="cursor: auto;" >
																						<?php echo $row['fname'].' '.$row['lname'];?>
																					</a> -
																					<span>
																						<?php 
																							echo (isset($row['instituteName']) && $row['instituteName']!='')?$row['instituteName']:'' ; 
																						?>	
																					</span>
																					<span>
																						(<?php 
																							echo (isset($row['zone_name']) && $row['zone_name']!='')?$row['zone_name']:'' ; ?>
																						)
																					</span>
																					<span class="menu-date">
																						<?php echo date("F j, Y, g:i a",strtotime($row['created']));?>
																					</span> -
																					<!-- <span class="menu-rating vd_yellow"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></span> -->
																				</div>
																			</div>
																			<div id="status<?php echo $row['id'];?>" class="menu-action left_30">
																				<?php
																				if($row['status'] == 1){
																					?>
																					<span class="label label-success">
																						Active
																					</span>
																					<?php
																				}
																				else
																				{
																					?>
																					<span class="label label-danger">
																						Deactive
																					</span>
																					<?php
																				} ?>
																			</div>
																			<div class="menu-action">
																				<div id="approve<?php echo $row['id'];?>" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" data-proid="<?php echo $row['projectId'];?>" data-userId="<?php echo $row['userId'];?>" class="approve menu-action-icon vd_green"  data-original-title="Approve" data-rel="tooltip-bottom">
																					<i class="fa fa-check">
																					</i>
																				</div>
																				<div id="reject<?php echo $row['id'];?>" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" data-proid="<?php echo $row['projectId'];?>" data-userId="<?php echo $row['userId'];?>" class="reject menu-action-icon vd_red"   data-original-title="Reject" data-rel="tooltip-bottom">
																					<i class="fa fa-times">
																					</i>
																				</div>
																			</div>
																		</li>
																		<?php
																	}
																} ?>
															</ul>
														</div>
													</div>
												</div>

												<div id="posts-tab" class="tab-pane sidebar-widget">
													<div class="content-list">
														<div data-rel="scroll">
															<ul  class="list-wrapper pd-lr-15">
																<li>
																	<a href="#">
																		<div class="menu-icon vd_yellow">
																			<i class="fa fa-suitcase">
																			</i>
																		</div>
																		<div class="menu-text">
																			Someone has give you a surprise
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 12 Minutes Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_blue">
																			<i class=" fa fa-user">
																			</i>
																		</div>
																		<div class="menu-text">
																			Change your user profile details
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 1 Hour 20 Minutes Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_red">
																			<i class=" fa fa-cogs">
																			</i>
																		</div>
																		<div class="menu-text">
																			Your setting is updated
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 12 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_green">
																			<i class=" fa fa-book">
																			</i>
																		</div>
																		<div class="menu-text">
																			Added new article
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 19 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_green">
																			<img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg">
																		</div>
																		<div class="menu-text">
																			Change Profile Pic
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 20 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_red">
																			<i class=" fa fa-cogs">
																			</i>
																		</div>
																		<div class="menu-text">
																			Your setting is updated
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 12 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_green">
																			<i class=" fa fa-book">
																			</i>
																		</div>
																		<div class="menu-text">
																			Added new article
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 19 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

																<li>
																	<a href="#">
																		<div class="menu-icon vd_green">
																			<img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg">
																		</div>
																		<div class="menu-text">
																			Change Profile Pic
																			<div class="menu-info">
																				<span class="menu-date">
																					~ 20 Days Ago
																				</span>
																			</div>
																		</div>
																	</a>
																</li>

															</ul>
														</div>
														<div class="closing text-center" style="">
															<a href="#">
																See All Activities
																<i class="fa fa-angle-double-right">
																</i>
															</a>
														</div>
													</div>
												</div>

												<div id="list-tab" class="tab-pane">
													<div class="content-grid column-xs-2 column-sm-6 height-xs-3">
														<div data-rel="scroll" >
															<ul class="list-wrapper">
																<?php
																if(!empty($user_data)){
																	foreach($user_data as $row){
																		?>
																		<li>
																			<a href="#">
																				<div class="menu-icon width-50">
																					<?php
																					if(file_exists(file_upload_absolute_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_absolute_path().'users/thumbs/'.$row['profileImage']) > 0){
																						$profileImage = '<img width="40" height="40" src="'.file_upload_base_url().'users/thumbs/'.$row['profileImage'].'">';
																					}
																					else
																					{
																						$profileImage = '<img width="40" height="40" src="'.base_url().'backend_assets/img/noimage.jpg">';
																					}
																					echo $profileImage;
																					;?>

																				</div>
																			</a>

																			<div class="menu-text">
																				<?php echo $row['firstName'].' '.$row['lastName'];?>
																				<div class="menu-info">
																					<div class="menu-date">
																						<?php echo $row['city'];?>
																					</div>
																					<div id="user_status<?php echo $row['id'];?>" class="menu-action">
																						<?php
																						if($row['status'] == 1){
																							?>
																							<span class="label label-success">
																								Active
																							</span>
																							<?php
																						}
																						else
																						{
																							?>
																							<span class="label label-danger">
																								Deactive
																							</span>
																							<?php
																						}?>
																					</div>

																					<div class="menu-action">
																					
																						<span <?php if($row['status'] == 1){?> style=display:none <?php }  ?>id="approve_user<?php echo $row['id'];?>" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" class="approve_user menu-action-icon vd_green vd_bd-green" data-original-title="Active" data-toggle="tooltip" data-placement="bottom">
																							<i class="fa fa-check">
																							</i>
																						</span>

																						<span <?php if($row['status'] == 0){?> style=display:none <?php }  ?> id="reject_user<?php echo $row['id'];?>" data-status="<?php echo $row['status'];?>" data-id="<?php echo $row['id'];?>" class="reject_user menu-action-icon vd_red vd_bd-red" data-original-title="Deactive" data-toggle="tooltip" data-placement="bottom">
																							<i class="fa fa-times">
																							</i>
																						</span>
																					</div>
																				</div>
																			</div>
																		</li>
																		<?php
																	}
																} ?>
															</ul>
														</div>

													</div>
												</div>
											</div>
										</div> <!-- tabs-widget -->
									</div>
									<!-- col-md-12 -->
								</div>
								<!-- row -->
							</div>

							<div <?php echo $class3;?>>
								<?php
									$ci     =&get_instance();
									$ci->load->model('modelbasic');
									$winner = $ci->modelbasic->getAllWinner();
									$job    = $ci->modelbasic->getAllJob_saperate($this->session->userdata('admin_level'));
									$jobUsers  = $ci->modelbasic->getAllJobUsers_saperate($this->session->userdata('admin_level'));
								?>
								<div class="panel widget <?php echo $class2;?>">
									<div class="panel-body-list  table-responsive">
										<table class="table no-head-border table-striped">
											<thead class="vd_bg-blue vd_white">
												<tr>
													<th style="width:15px">
														Competition Name
													</th>
													<th style="width:20px">
														Winner Name
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($winner))
												{
													foreach($winner as $val)
													{
														?>
														<tr>
															<td>
																<?php echo $val['name'];?>
															</td>
															<td>
																<?php echo $val['firstName'].' '.$val['lastName'];?>
															</td>
														</tr>
														<?php
													}
												} ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="panel widget">
									<div class="panel-body-list table-responsive">
										<table class="table no-head-border table-striped fixTable">
											<thead class="vd_bg-blue vd_white">
												<tr>
													<th>
														Job Title
													</th>
													<th>
														Job Location
													</th>
													<th>
														Post Date
													</th>
												</tr>
											</thead>
											<tbody class="scrollBody">
												<?php //print_r($job);
												if(!empty($job))
												{
													foreach($job as $row)
													{
														?>
														<tr style="display: table">
															<td>
																<?php echo $row['title'];?>
															</td>
															<td>
																<?php echo $row['location'];?>
															</td>
															<td>
																<?php echo date_format(date_create($row['created']),"d M Y H:i A");?>
															</td>
														</tr>
														<?php
													}
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div <?php echo $class3;?> >
								<div class="panel widget" id='scrolly'>
									<div class="panel-body-list table-responsive" >
										<table class="table no-head-border table-striped fixTable" >
											<thead class="vd_bg-blue vd_white">
												<tr>
													<th>
														Candidate Name
													</th>
													<th>
														Job Title
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody class="scrollBody">
												<?php //print_r($job);
												if(!empty($jobUsers))
												{
													foreach($jobUsers as $row)
													{ ?>
														<tr style="display: table">
															<td>
																<?php echo $row['firstName'].$row['lastName'];?>
															</td>
															<td>
																<?php echo $row['title'];?>
															</td>
															<td>
																<div id="status113" class="menu-action left_30">				
																	<?php
																	if($row['apply_status']==1)
																	{ ?>
																		<span class="label label-success">Applied</span>
																	<?php	}
																	elseif($row['apply_status']==2)
																	{  ?>
																		<span class="label label-success">Shortlisted</span>																		
																	<?php	}
																	elseif($row['apply_status']==3)
																	{  ?>
																		<span class="label label-success">Selected</span>																		
																	<?php	}
																	elseif($row['apply_status']==4)
																	{   ?>
																		<span class="label label-success">Job Offered</span>																		
																	<?php	} 
																	elseif($row['apply_status']==5)
																	{   ?>
																		<span class="label label-danger">Rejected by User</span>							
																	<?php	}
																	else if($row['apply_status']==11)
																	{ ?>
																		<span class="label label-success">Admin Approved The Job and &nbsp; <br>&nbsp; Waiting for RAH Approval</span>
																	<?php }
																	else if($row['apply_status']==13)
																	{ ?>
																		<span class="label label-success">RAH Approved The Job and  &nbsp;<br>&nbsp; Waiting for RPH Approval</span>
																	<?php }
																	else if($row['apply_status']==14)
																	{ ?>
																		<span class="label label-danger">Application Rejected By RAH</span>
																	<?php }
																	else if($row['apply_status']==15)
																	{ ?>
																		<span class="label label-success">RPH Approved The Job and &nbsp;<br>&nbsp; Waiting for Employer Approval</span>
																	<?php }
																	else if($row['apply_status']==16)
																	{ ?>
																		<span class="label label-danger">Application Rejected By RPH</span>
																	<?php }
																	else
																	{ ?>
																		<span class="label label-danger">Rejected by Employer</span>
																	<?php }	?>						
																</div>
															</td>
														</tr>
														<?php
													}
												} else{?>
												<tr>
													<td colspan="3" align="center">
														No candidates applied.
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- col-md-6 -->
								<!-- 	 <div id='scrolly'>
							 	ASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDASDFGHJASDASDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
							 </div> -->
						</div>
						<!-- .row -->
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
</div>

<!-- Footer Start -->
<?php $this->load->view('admin/template/footer');?>

<!-- Specific Page Scripts Put Here -->
<!-- Flot Chart  -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/flot/jquery.flot.categories.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/flot/jquery.flot.animator.min.js"></script>

<!-- Vector Map -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- Intro JS (Tour) -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/introjs/js/intro.min.js"></script>


<script type="text/javascript">
$(window).load(function()
{
	function labelFormatter(label, series)
	{
		return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	}
});

$(function()
{
	//comment
	$('.approve').click(function()
	{
		var cid = $(this).data('id');
		var proid = $(this).data('proid');
		var userId = $(this).data('userId');
		var status = $(this).data('status');
		var url = $('#base_url').val();
		if(status==0)
		{
			status=1;
			$.ajax(
				{
					url: url+"admin/admin/comment_status",
					data:
					{
						cid:cid,proid:proid,status:status
					},
					type: "POST",
					success:function(html)
					{
						if(html=='yes')
						{
							$('#status'+cid).html('<span class="label label-success">Active</span>');
							$('#approve'+cid).attr('data-status',1);
							$('#reject'+cid).attr('data-status',1);
						}
					}
				})
		}
		else
		{
			alert('Comment is already activated.');
		}
	})
	//comment
	$('.reject').click(function()
	{
		var cid = $(this).data('id');
		var proid = $(this).data('proid');
		var userId = $(this).data('userId');
		var status = $(this).data('status');
		var url = $('#base_url').val();
		if(status==1)
		{
			status=0;
			$.ajax(
				{
					url: url+"admin/admin/comment_status",
					data:
					{
						cid:cid,proid:proid,status:status
					},
					type: "POST",
					success:function(html)
					{
						if(html=='yes')
						{
							$('#status'+cid).html('<span class="label label-danger">Deactive</span>');
							$('#approve'+cid).attr('data-status',0);
							$('#reject'+cid).attr('data-status',0);
						}
					}
				})
		}
		else
		{
			alert('Comment is already deactivated.');
		}
	})

	//user
	$('.approve_user').click(function()
	{
		var userId = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		var url = $('#base_url').val();
		if(status==0)
		{
			status=1;
			$.ajax(
				{
					url: url+"admin/dashboard/change_user_status",
					data:
					{
						userId:userId,status:status
					},
					type: "POST",
					success:function(html)
					{
						if(html=='yes')
						{
							$('#user_status'+userId).html('<span class="label label-success">Active</span>');
							$('#approve_user'+userId).attr('data-status',1);
							$('#reject_user'+userId).attr('data-status',1);
							$('#approve_user'+userId).hide();
							$('#reject_user'+userId).show();
						}
					}
				})
		}
		else
		{
			alert('User is already activated.');
		}
	})

	$('.reject_user').click(function()
	{
		var userId = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		var url = $('#base_url').val();
		if(status==1)
		{
			status=0;
			$.ajax(
				{
					url: url+"admin/dashboard/change_user_status",
					data:
					{
						userId:userId,status:status
					},
					type: "POST",
					success:function(html)
					{
						if(html=='yes')
						{
							$('#user_status'+userId).html('<span class="label label-danger">Deactive</span>');
							$('#approve_user'+userId).attr('data-status',0);
							$('#reject_user'+userId).attr('data-status',0);
							$('#reject_user'+userId).hide();
							$('#approve_user'+userId).show();
						}
					}
				})
		}
		else
		{
			alert('User is already deactivated.');
		}
	})
})
</script>
</body>
</html>

