<div class="vd_navbar vd_nav-width vd_navbar-tabs-menu vd_navbar-left  ">
	<div class="navbar-menu clearfix">
		<div class="vd_panel-menu hidden-xs">
			<!-- <span data-original-title="Expand All" data-toggle="tooltip" data-placement="bottom" data-action="expand-all" class="menu" data-intro="<strong>Expand Button</strong><br/>To expand all menu on left navigation menu." data-step=4 >
				<i class="fa fa-sort-amount-asc">
				</i>
			</span> -->
		</div>
		<h3 class="menu-title hide-nav-medium hide-nav-small">
			Creosouls Admin
		</h3>
		<div class="vd_menu">
			<ul>
				<li <?php if($this->uri->segment('2') == 'dashboard'){ echo 'class="active"';}?>>
					<a href="<?php echo base_url();?>">
						<span class="menu-icon">
							<i class="fa fa-dashboard">
							</i>
						</span>
						<span class="menu-text">
							Dashboard
						</span>
					</a>
				</li>
				<?php /*echo "hii";
				echo $this->session->userdata('manage_user');*/
					if($this->session->userdata('manage_user')==1){?>
						<li <?php if($this->uri->segment('2') == 'admin'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/admin">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Admin
								</span>
							</a>
						</li><?php } 
					if($this->session->userdata('admin_level')==1 && $this->session->userdata('admin_id')==1){ ?>
						<li <?php if($this->uri->segment('2') == 'ho_admin'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/ho_admin">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Ho Admin
								</span>
							</a>
						</li>
						<li <?php if($this->uri->segment('2') == 'trending_project'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/projects/trending_project">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Make Project Trending
								</span>
							</a>
						</li> 
						 <?php } 
						 if($this->session->userdata('admin_level')==1){?>
						 	<li <?php if($this->uri->segment('2') == 'product'){ echo 'class="active"';}?>>
						 		<a href="<?php echo base_url();?>admin/product">
						 			<span class="menu-icon">
						 				<i class="fa fa-user">
						 				</i>
						 			</span>
						 			<span class="menu-text">
						 				Product
						 			</span>
						 		</a>
						 	</li><?php } 
						 	if($this->session->userdata('admin_level')==1){?>
						 		<li <?php if($this->uri->segment('2') == 'assignment'){ echo 'class="active"';}?>>
						 			<a href="<?php echo base_url();?>admin/assignment">
						 				<span class="menu-icon">
						 					<i class="fa fa-user">
						 					</i>
						 				</span>
						 				<span class="menu-text">
						 					Assignment
						 				</span>
						 			</a>
						 		</li><?php } 
						 		if($this->session->userdata('admin_level')==1){?>
						 			<li <?php if($this->uri->segment('2') == 'courses'){ echo 'class="active"';}?>>
						 				<a href="<?php echo base_url();?>admin/courses">
						 					<span class="menu-icon">
						 						<i class="fa fa-user">
						 						</i>
						 					</span>
						 					<span class="menu-text">
						 						Courses
						 					</span>
						 				</a>
						 			</li><?php } 
						 		
					if($this->session->userdata('admin_level') != 3 && $this->session->userdata('admin_level') != 5 && $this->session->userdata('admin_level') != 6){ ?>
						<li <?php if($this->uri->segment('2') == 'users'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/users">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Users
								</span>
								<?php
								$CI         =&get_instance();
								$CI->load->model('modelbasic');
								$totalUsers = $CI->modelbasic->count_all_new('users');
								if($totalUsers > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalUsers;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li>
						<li <?php if($this->uri->segment('2') == 'enroll_users'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/enroll_users">
									<span class="menu-icon">
										<i class="fa fa-user">
										</i>
									</span>
									<span class="menu-text">
										Enroll Users
									</span>
								</a>	
						</li>
						<li <?php if($this->uri->segment('2') == 'groups'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/groups">
								<span class="menu-icon">
									<i class="fa fa-users">
									</i>
								</span>
								<span class="menu-text">
									Groups
								</span>
							</a>
						</li>
						<li <?php if($this->uri->segment('2') == 'projects'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/projects">
								<span class="menu-icon">
									<i class="icon-palette">
									</i>
								</span>
								<span class="menu-text">
									Projects
								</span>
								<?php
								$CI =&get_instance();
								$CI->load->model('modelbasic');
								if($this->session->userdata('admin_level') == 2){
									$totalProjects = $CI->modelbasic->count_institute_new_project();
								}
								else
								{
									$totalProjects = $CI->modelbasic->count_all_new('project_master');
								}
								if($totalProjects > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalProjects;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li>
						<li <?php if($this->uri->segment('2') == 'institutes'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/institutes">
								<span class="menu-icon">
									<i class="fa fa-university">
									</i>
								</span>
								<span class="menu-text">

								<?php
								if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4){
									?>

									Institutes

									<?php  } else {  ?> Institute <?php }  ?>
								</span>
								<?php
								$CI              =&get_instance();
								$CI->load->model('modelbasic');
								$totalInstitutes = $CI->modelbasic->count_all_new('institute_master');
								if($totalInstitutes > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalInstitutes;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li> <?php } ?>
						<?php if($this->session->userdata('admin_level') != 6){ ?>
						<li <?php if($this->uri->segment('2') == 'jobs'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/jobs">
								<span class="menu-icon">
									<i class="icon-bookmark">
									</i>
								</span>
								<span class="menu-text">
									Jobs
								</span>
								<?php
								$CI        =&get_instance();
								$CI->load->model('admin/job_model');
								$totalJobs = $CI->job_model->count_all_new('jobs');
								if($totalJobs > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalJobs;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li>
						<?php }?>
						<?php if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 5){ ?>
						<li <?php if($this->uri->segment('2') == 'placement'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/placement">
								<span class="menu-icon">
									<i class="icon-bookmark">
									</i>
								</span>
								<span class="menu-text">
									Placement
								</span>
								<?php
								$CI        =&get_instance();
								$CI->load->model('admin/placement_model');
								$totalPlacements = $CI->placement_model->count_all_new('placement');
								if($totalPlacements > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalPlacements;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li>
						<?php }?>
				<?php
					if($this->session->userdata('admin_level') == 2) {?>
						<li <?php if($this->uri->segment('2') == 'feedback_instance'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/feedback_instance">
								<span class="menu-icon">
									<i class="icon-newspaper">
									</i>
								</span>
								<span class="menu-text">
									Feedback Instance
								</span>
							</a>
						</li><?php }
					if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') == 6) {?>
							<li <?php if($this->uri->segment('2') == 'newsletter'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/newsletter">
									<span class="menu-icon">
										<i class="icon-newspaper">
										</i>
									</span>
									<span class="menu-text">
										Newsletter
									</span>
									<?php
									$CI        =&get_instance();
									$CI->load->model('modelbasic');
									$totalblog = $CI->modelbasic->count_all_new('blog');
									if($totalblog > 0){
										?>
										<span class="menu-badge">
											<span class="badge vd_bg-red">
												<?php echo $totalblog;?>
											</span>
										</span>
										<?php
									}
									?>
								</a>
							</li>
							<!-- <li <?php if($this->uri->segment('2') == 'client'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/client">
									<span class="menu-icon">
										<i class="icon-newspaper">
										</i>
									</span>
									<span class="menu-text">
										Client
									</span>
								</a>
							</li> -->
							<?php if($this->session->userdata('admin_level') != 6){ ?>
							<li <?php if($this->uri->segment('2') == 'testimonial'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/testimonial">
									<span class="menu-icon">
										<i class="icon-newspaper">
										</i>
									</span>
									<span class="menu-text">
										Testimonial
									</span>
								</a>
							</li>
						<?php } }

					if($this->session->userdata('admin_level') != 3 && $this->session->userdata('admin_level') != 5 && $this->session->userdata('admin_level') != 6){?>
							<li <?php if($this->uri->segment('2') == 'competition'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/competition">
									<span class="menu-icon">
										<i class="fa fa-trophy">
										</i>
									</span>
									<span class="menu-text">
										Competition
									</span>
									<?php
									$CI               =&get_instance();
									$CI->load->model('modelbasic');
									$totalCompetition = $CI->modelbasic->count_all_new('competitions');
									if($totalCompetition > 0){
										?>
										<span class="menu-badge">
											<span class="badge vd_bg-red">
												<?php echo $totalCompetition;?>
											</span>
										</span>
										<?php
									}
									?>
								</a>
							</li> 
							<li <?php if($this->uri->segment('2') == 'competition' && $this->uri->segment('3') == 'linkStudent'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/competition/linkStudent">
									<span class="menu-icon">
										<i class="fa fa-trophy">
										</i>
									</span>
									<span class="menu-text">
										Competition Students
									</span>
								</a>
							</li>
						<?php }
					if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') == 6) { ?>
						<li <?php if($this->uri->segment('2') == 'event'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/event">
								<span class="menu-icon">
									<i class="fa fa-table">
									</i>
								</span>
								<span class="menu-text">
									Event
								</span>
								<?php
								$CI          =&get_instance();
								$CI->load->model('modelbasic');
								$totalEvents = $CI->modelbasic->count_all_new('events');
								if($totalEvents > 0){
									?>
									<span class="menu-badge">
										<span class="badge vd_bg-red">
											<?php echo $totalEvents;?>
										</span>
									</span>
									<?php
								}
								?>
							</a>
						</li> <?php } 
						if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') == 6) { ?>
							<li <?php if($this->uri->segment('2') == 'banner'){ echo 'class="active"';}?>>
								<a href="<?php echo base_url();?>admin/banner">
									<span class="menu-icon">
										<i class="fa fa-picture-o">
										</i>
									</span>
									<span class="menu-text">
										Banner
									</span>
									
								</a>
							</li> <?php } 
						if($this->session->userdata('admin_level') != 3 && $this->session->userdata('admin_level') != 5 && $this->session->userdata('admin_level') != 6) {?>
						<li <?php if($this->uri->segment('2') == 'notification'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/notification" id="addnotification">
								<span class="menu-icon">
									<i class="fa fa-bell">
									</i>
								</span>
								<span class="menu-text">
									Notification
								</span>
							</a>
						</li>
					<?php }
					if($this->session->userdata('admin_level') == 2 || $this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') == 5){ ?>
						<li <?php if($this->uri->segment('2') == 'job_approval'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/job_approval">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Manage Job Approval
								</span>							
							</a>
						</li> <?php } /* echo $this->session->userdata('admin_level');*/ 
							if($this->session->userdata('admin_level') == 1){ ?>
						<li <?php if($this->uri->segment('2') == 'support_issue'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/support_issue" id="addsupport_issue">
								<span class="menu-icon">
									<i class="fa fa-exclamation-triangle">
									</i>
								</span>
								<span class="menu-text">
									Support Issues
								</span>
							</a>
						</li><?php } ?>
						<?php if($this->session->userdata('admin_level') != '6'){ ?>
						<li <?php if($this->uri->segment('2') == 'reports'){ echo 'class="active"';}?>>
							<a href="javascript:void(0);" data-action="click-trigger">
						    	<span class="menu-icon"><i class="fa fa-file-excel-o"></i></span> 
						        <span class="menu-text">Reports</span>  
						        <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
						   	</a>
						 	<div class="child-menu"  data-action="click-target">
						        <ul>
						        <?php if($this->session->userdata('admin_level') != '0' && $this->session->userdata('admin_level') != '2' && $this->session->userdata('admin_level') != '5'  && $this->session->userdata('admin_level') != '3') {  ?>
						        	<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_student_reports" id="manage_student_reports">	
		    								<span class="menu-text">
		    									Student Report
		    								</span>							
		    							</a>
		    						</li>
									<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_rah_rating" id="manage_rah_rating">	
		    								<span class="menu-text">
		    									RAH Rating Report
		    								</span>							
		    							</a>
		    						</li>
		    						<li>
		    						    <a href="<?php echo base_url();?>admin/reports/manage_zonewise_project_added" id="manage_zonewise_project_added">	
		    						    <span class="menu-text">
		    						    		Zone Wise Project Added
		    						    </span>							
		    						    </a>
		    						</li>
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_institute_reports" id="manage_institute_reports">	
		    								<span class="menu-text">
		    									Institute Report
		    								</span>							
		    							</a>
		    						</li>
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_region_reports" id="manage_region_reports">	
		    								<span class="menu-text">
		    									Region Wise Report
		    								</span>							
		    							</a>
		    						</li>
		    					<!-- 	<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_insadmin_reports" id="manage_region_reports">	
		    								<span class="menu-text">
		    									Admin Report
		    								</span>							
		    							</a>
		    						</li> -->
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_top_student" id="manage_top_student">	
		    								<span class="menu-text">
		    									Top 5 Student
		    								</span>							
		    							</a>
		    						</li>
								<?php } ?>
		    						<!-- 
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_project_report" id="manage_project_report">	
		    								<span class="menu-text">
		    									Project Report
		    								</span>							
		    							</a>
		    						</li> -->
		    						<?php if($this->session->userdata('admin_level') != '5' && $this->session->userdata('admin_level') != '3'){?>
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_institute_users_reports" id="manage_institute_users_reports">				        							
		    								<span class="menu-text">
		    									List of Institute Users
		    								</span>							
		    							</a>
		    						</li>
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_assignment_reports" id="manage_assignment_reports">				        								
		    								<span class="menu-text">
		    								Assignment Reports 
		    								</span>								
		    							</a>
		    						</li>
		    						<li>
	    							  	<a href="<?php echo base_url();?>admin/reports/manage_institute_statitstics_reports" id="manage_institute_statitstics_reports">				        							
		    								<span class="menu-text">
		    								Institute Statitstics Reports
		    								</span>								
		    							</a>
		    						</li>
		    						<li>
		    							  <a href="<?php echo base_url();?>admin/reports/manage_feedback_reports" id="manage_feedback_reports">
			    								<span class="menu-text">
			    								Feedback Reports
			    								</span>								
			    							</a>
		    						</li>
		 							<li>
									  <a href="<?php echo base_url();?>admin/reports/manage_individual_feedback_reports" id="manage_individual_feedback_reports">				        							
										<span class="menu-text">
										Individual Feedback Report
										</span>								
										</a>
									</li>   
									<li>
										<a  data-placement="top" data-toggle="tooltip" data-original-title="Export Project Count" onclick="export_users_project_count()"> 
											<span class="menu-text">Project Count</span>
										</a>
									</li>  
									<li>
									  	<a href="<?php echo base_url();?>admin/admin/export_users_likers_project"  data-placement="top" data-toggle="tooltip" data-original-title="Export Project Likers"> 
									  		<span class="menu-text"> Project Likers</span>
									 	</a>
									</li>      
									<li>
										<a href="<?php echo base_url();?>admin/admin/export_users_assignments"  data-placement="top" data-toggle="tooltip" data-original-title="Export Assign Users"> 
											<span class="menu-text">Assign Users</span>
										</a> 
									</li> 
		    					<?php } ?>
								<?php if($this->session->userdata('admin_level') ==1 || $this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') ==5 ||  $this->session->userdata('admin_level') == '3'){?>
		    						<li>
		    							<a href="<?php echo base_url();?>admin/reports/manage_job_reports" id="manage_job_reports">
		    								<span class="menu-text">
		    								Jobs Reports
		    								</span>								
		    							</a>
		    						</li>
		    						<?php if ($this->session->userdata('admin_level') != '3') {?>
								 	<li>
									  <a href="<?php echo base_url();?>admin/reports/export_manage_job_reports_admin" id="export_manage_job_reports_admin">
											<span class="menu-text">
												Jobs Reports for Ho Admin
											</span>								
										</a>
									</li>
								<?php } } ?> 
						    </ul>   
						 </div>
						</li>
						<?php } ?>       
					<?php
					if($this->session->userdata('admin_level') != 3 && $this->session->userdata('admin_level') != 5 && $this->session->userdata('admin_level') != 6) {  ?>
						<li <?php if($this->uri->segment('2') == 'creative_mind_competition'){ echo 'class="active"';}?>>
							<a href="<?php echo base_url();?>admin/creative_mind_competition">
								<span class="menu-icon">
									<i class="fa fa-user">
									</i>
								</span>
								<span class="menu-text">
									Creative Mind Competition
								</span>			
							</a>
						</li> <?php } ?>
			</ul>
			<!-- Head menu search form ends -->
		</div>
	</div>
	<div class="navbar-spacing clearfix">
	</div>
	<div class="vd_menu vd_navbar-bottom-widget">
		<ul>
			<li>
				<a href="<?php echo base_url();?>admin/users/logout">
					<span class="menu-icon">
						<i class="fa fa-sign-out">
						</i>
					</span>
					<span class="menu-text">
						Logout
					</span>
				</a>
			</li>
		</ul>
	</div>
</div>
