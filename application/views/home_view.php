<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$this->load->view('template/header');?>
<!-- <link href="<?php echo base_url();?>assets/css/style_crowj.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>assets/css/style_testomo.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>assets/css/owl.carousel.css" rel="stylesheet"/> -->
<style>
	.navbar {
	    background-color:#000;
	}
	.policy-modal .modal-footer{
        padding: 0;
        border-top: 1px solid;
	}
	.policy-modal .modal-body{
		height: 450px !important;
	   	overflow-x: hidden;
	   	overflow-y: scroll;
	}
	.agree{
		color: #252525;
	}
	#centerModel  .modal-header{
     	background:#5E5E5E;
	}
	#centerModel  .modal-header .modal-title {
	    color: #fff;
	    font-size: 19px;
	}
	.center-select {
		margin: 0;
	}
	.center-select img{
	}
	.img-cap{
		color: #000;
	    font-size: 19px;
	    margin-bottom: 7px;
	    margin-top: 7px;
	    text-align: center;
	}
</style>
<div id="home">
	<header id="myCarousel" class="carousel slide" style="margin-top: 0px;">
		<div class="carousel-inner">
			<div class="item active">
				<div class="fill">
					<!-- <a href="https://zoom.us/webinar/register/WN_JYgeZD8gSJ6P6laN83zQDA" target="_blank"> -->
						<img class="fill" src="<?php echo base_url();?>uploads/Arena_Women's_Day_Clay_Modeling_Workshop.png" alt="image">
					<!-- </a> -->
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<img class="fill" src="<?php echo base_url();?>uploads/Arena_Purani_Jeans_Contest_Winners.jpg" alt="image">
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<img class="fill" src="<?php echo base_url();?>uploads/arena_republic_day_winner_banner.jpg" alt="image">
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<img class="fill" src="<?php echo base_url();?>uploads/Remarkable_Reel_Creosouls_Winner.jpg" alt="image">
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<img class="fill" src="<?php echo base_url();?>uploads/arena_banner_new_1.jpg" alt="image">
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<img class="fill" src="<?php echo base_url();?>uploads/arena_banner_new_2.jpg" alt="image">
				</div>
			</div>
			<div class="item">
				<div class="fill">
					<a href="https://www.arena-multimedia.com/in/en/campaign/arena-langara-cea-program/" target="_blank">
						<img class="fill" src="<?php echo base_url();?>uploads/arena_banner_new_3.jpg" alt="image">
					</a>
				</div>
			</div>	
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			<span class="icon-prev">
			</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
			<span class="icon-next">
			</span>
		</a>
	</header>
	<div class="clearfix">
	</div>
	<div class="middle-bg">
		<div class="tranding_projects">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h2 class="text-center">
							<a style="color: #252525;"href="#">Trending Projects</a>
						</h2>
						<a class="pull-right"  href="<?php echo base_url();?>all_project">
							<p  style="color: rgb(31, 61, 193); font-weight: bold; margin-top: -35px; margin-right: 18px; font-size: 13px;">Explore more</p>
						</a>
					</div>
				</div>
				<?php 
              
             // echo "<pre>";print_r($data);exit();
              if(!empty($project)){
					$img = base_url().'assets/images/ribn.png';
					$data = array();
					$data['project'] = $project;
					$data['thumbnailNum'] = 5;
					$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4';
					$this->load->view('template/homeprojectThumbnailView',$data);
				}else{ ?>
					<div class="col-lg-12">
						<div class="no_content_found">
							<h3><a style="color: #252525;"href="#">
                              There are no Projects to display.</a>
							</h3>
						</div>
					</div>
					<?php 
				} ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php if($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0) { ?>
		<div class="middle-bg">
			<div class="tranding_projects">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<h2 class="text-center">
                              <a style="color: #252525;"href="#">	Trending Institute</a>
							</h2>
							<!-- <a class="pull-right"  href="<?php echo base_url();?>all_project"></a> -->
						</div>
					</div>
					<?php if(!empty($trandingInstitute)) {
						$img = base_url().'assets/images/ribn.png';
						$data = array();
						$data['trandingInstitute'] = $trandingInstitute;
						$data['thumbnailNum'] = 5;
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4';
						$this->load->view('template/instituteThumbnailView',$data);
					}else{ ?>
						<div class="col-lg-12">
							<div class="no_content_found">
								<h3>
									There are no Institute to display.
								</h3>
							</div>
						</div>
						<?php 
					} ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="middle-bg">
			<div class="tranding_projects">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<h2 class="text-center">
								Trending Student
							</h2>
							<!-- <a class="pull-right"  href="<?php echo base_url();?>all_project"></a> -->
						</div>
					</div>
					<?php if(!empty($trandingStudent)) {
						$img = base_url().'assets/images/ribn.png';
						$data = array();
						$data['peoples'] = $trandingStudent;
						$data['thumbnailNum'] = 5;
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4';
						$this->load->view('template/peopleThumbnailView1',$data);
					}else { ?>
						<div class="col-lg-12">
							<div class="no_content_found">
								<h3>
									There are no Institute to display.
								</h3>
							</div>
						</div>
						<?php 
					} ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="clearfix"></div>
	<div class="middle-bg">
		<div class="tranding_projects">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h2 class="text-center">
                          <a style="color: #252525;"href="#"> Trending Jobs</a>
						</h2>					
					</div>
				</div>
				<?php if(!empty($jobs)) {
					$img = base_url().'assets/images/ribn.png';
					$data = array();
					$data['trandingJob'] = $jobs;
					$data['thumbnailNum'] = 5;
					$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4';
					$this->load->view('template/jobThumbnailView',$data);
				}else { ?>
					<div class="col-lg-12">
						<div class="no_content_found">
							<h3>
                              <a style="color: #252525;"href="#">There are no Jobs to display.</a>
							</h3>
						</div>
					</div>
					<?php 
				} ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="middle-bg">
		<div class="tranding_projects">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h2 class="text-center">
                          <a style="color: #252525;"href="#">	Trending Placement</a>
						</h2>					
					</div>
				</div>
				<?php if(!empty($trandingPlacement)) {
					$img = base_url().'assets/images/ribn.png';
					$data = array();
					$data['trandingPlacement'] = $trandingPlacement;
					$data['thumbnailNum'] = 5;
					$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4';
					$this->load->view('template/placementThumbnailView',$data);
				}else { ?>
					<div class="col-lg-12">
						<div class="no_content_found">
							<h3><a style="color: #252525;"href="#">
                              There are no Placement details to display.</a>
							</h3>
						</div>
					</div>
					<?php 
				} ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- <?php if(!empty($event)) { ?>
		<div class="newsandeevent " style="padding-bottom:0px">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 left5">
						<h2 class="text-center">
							Events
						</h2>
						<a class="pull-right"  href="<?php echo base_url();?>event/event_list">
							<p style="color: rgb(31, 61, 193); font-weight: bold; margin-top: -35px; margin-right: 18px; font-size: 13px;">Explore more</p>
						</a>
						<div class="Slider">
							<div id="owl-slider3">
								<?php foreach($event as $val){
									if(file_exists(file_upload_s3_path().'event/banner/'.$val['banner']) && filesize(file_upload_s3_path().'event/banner/'.$val['banner']) > 0){
										$back_image = file_upload_base_url().'event/banner/'.$val['banner'];
									}else{
										$back_image = base_url().'assets/img/noimage.jpg';
									} ?>
									<div class="slide-item">
										<div class="peoplesay" style="background:url(<?php echo $back_image?>) no-repeat;background-size:cover; background-position: center; transition: background-size 1s; display: inline-block; background-size: 100% 100%;height:204px">
											<a href="<?php echo base_url()?>event/show_event/<?php echo $val['id']?>">
												<div class="content3">
													<div class="row adj2">
														<div class="col-lg-12"><?php echo $val['name'];?></div>
													</div>
												</div>
											</a>
										</div>
									</div>
									<?php 
								}?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	} ?>
	<div class="clearfix"></div> -->
	<div class="counter bottom-shadow middle-bg">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<?php if(!empty($people_count)){
						$userStart = (99 / 100) * $people_count;
					}else{
						$userStart = 0;
					} ?>
					<div class='numscroller creative_people' data-slno='1' data-min='<?php echo $userStart;?>' data-max='<?php if(!empty($people_count)){ echo $people_count;}else{ echo 0;} ?>' data-delay='2' data-increment="5">
						0
					</div>
                  <p><a style="color: #252525;"href="#">Users</a></p>
				</div>
				<div class="col-md-3">
					<?php if(!empty($register_student)){
						$studentStart = (99 / 100) * $register_student;
					}else{
						$studentStart = 0;
					} ?>
					<div class='numscroller creative_people' data-slno='1' data-min='<?php echo $studentStart;?>' data-max='<?php if(!empty($register_student)){ echo $register_student;}else{ echo 0;} ?>' data-delay='2' data-increment="2">
						0
					</div>
                  <p><a style="color: #252525;"href="#">Register Student</a></p>
				</div>
				<div class="col-md-3">
					<?php if(!empty($project_count)){
						$projectStart = (99 / 100) * $project_count;
					}else{
						$projectStart = 0;
					} ?>
					<div class='numscroller uploaded_projects' data-slno='1' data-min='<?php echo $projectStart;?>' data-max='<?php if(!empty($project_count)){ echo $project_count;} else{ echo 0;} ?>' data-delay='2' data-increment="9">
						0
					</div>
                  <p><a style="color: #252525;"href="#">Uploaded Projects</a></p>
				</div>
				<div class="col-md-3">
					<?php if(!empty($job_count)){
						$jobStart = (99 / 100) * $job_count;
					}else{
						$jobStart = 0;
					} ?>
					<div class='numscroller jobs_available' data-slno='1' data-min='<?php echo $jobStart;?>' data-max='<?php if(!empty($job_count)){ echo $job_count;} else{ echo 0;} ?>' data-delay='2' data-increment="5">
						0
					</div>
                  <p><a style="color: #252525;"href="#">Jobs Available</a></p>
				</div>
			</div>
		</div>
	</div>
	<?php if(isset($terms_and_condition) && $terms_and_condition!='') { ?>
		<input type="hidden" name="terms_and_cond" id="terms_and_cond" value="<?php echo $terms_and_condition; ?>">
		<?php 
	}  ?>
	<div id="myModal" class="modal policy-modal fade" role="dialog">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	            	<ul class="nav nav-tabs" role="tablist">
	      	            <li id="trm" role="presentation" class="active">
	      		            <a href="#terms" aria-controls="terms" role="tab" data-toggle="tab">
	      		            	<h3>Terms and Conditions</h3>
	      		            </a>
	      	            </li>
	      	            <li id="prvc" role="presentation">
	      		            <a href="#PRIVACY_POLICY" aria-controls="profile" role="tab" data-toggle="tab">
	      		            	<h3>Privacy Policy </h3>
	      		            </a>
	      	            </li>
	            	</ul>
	      		</div>
				<div class="modal-body">
					<div id="content-2" class="content44 mCustomScrollbar light" data-mcs-theme="minimal-dark">
						<div class="col-lg-12">
							<div class="tab-content">
		                  		<div role="tabpanel" class="tab-pane fade in active" id="terms">
		                    		<p><strong>Aptech Pvt Ltd</strong><strong>,</strong>&nbsp;a company incorporated in India (&ldquo;<strong>Aptech</strong>&rdquo;), operates its website&nbsp;<strong>www.creosouls.com</strong>&nbsp;(the&quot;<strong>Site</strong>&quot;) to provide online access to the Site visitor/user (&ldquo;You&rdquo;) to provide content, services, products and other opportunities to You. Where You are using this Site on behalf of a corporate entity, (i) You represent that You have due authority from such corporate entity and (ii) these Terms of Use shall bind such corporate entity as well. By accessing and/or using this Site, You agree to each of the terms and conditions set forth herein (&quot;<strong>Terms of Use</strong>&quot;). Additional terms and conditions including the Privacy Policy and other policies applicable to general and specific areas of this Site may also be posted in relevant areas of the Site. Such additional terms and conditions, together with these Terms of Use, govern Your use of those areas, content, product or services. These Terms of Use, together with applicable additional terms and conditions, disclaimers and policies, are referred to as &ldquo;<strong>Agreement</strong>.&rdquo;</p>
				                    <p>&nbsp;</p>
				                    <p><strong>USE OF THE SITE</strong></p>
				                    <hr />
				                    <p>You may use the site; and the information, writings, images, audio, video, multimedia, and/or other works that you see, access, upload or otherwise experience on the site (singly or collectively, the <strong>"Site Content"</strong>); and the services, products and other opportunities provided in the site (singly or collectively, the "<strong>Services</strong>") for various purposes so long as such purposes are compliant with all applicable laws. You may not use this Site, site content or services for any purposes not intended under this �Terms of Use� including any e-commerce activities.</p>
				                    <p>No right, title or interest in and to any site Content, whether in whole or in part, is transferred to you, whether as a result of accessing such site content or otherwise. creosouls and/ or its licensors reserve all rights, title and interest in and to the intellectual property rights in all site content posted on the site, except for material or any content submitted by you.<span style="color:#CC4739">Except as expressly authorized by the Terms of Use</span>, You may not use, alter, copy, modify, distribute, transmit, or derive another work from any site content obtained from the site.</p>
				                    <p>You will not use the site in any way that is unlawful or harms creosouls, its directors, employees, affiliates, distributors, partners, service providers and/or any other user/ visitor of the site and/or other data or content on the site. You may not use the site in any manner that could damage, disable, overburden, block, or impair the site, whether in part or in full and whether permanently or temporarily, or disallow or interfere with any other party's use and enjoyment of the site and the services.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>USER CONDUCT</strong></p>
				                    <hr />
				                    <p>You agree to use the site content and services only for lawful purposes as detailed above. You agree not to take any action that might compromise the security of the site, site content and services, or render the site, site content and services inaccessible to others or otherwise cause damage to the site, site content or services. You agree not to add <span style="color:#CC4739">to</span>, subtract <span style="color:#CC4739">from</span>, or otherwise modify the site content, or to attempt to access any site content that is not intended for you or as permitted under this �Terms of Use�. You agree not to use the Site Content in any manner that might interfere with the rights of third parties.</p>
				                    <p>In particular You shall not:</p>
				                    <ul>
										<li>use, publish, modify or share any information or site content of any third party for any commercial purpose to which you do not have a right to;</li>
										<li>use the site to defame, abuse, solicit, harass, stalk, threaten or otherwise violate the legal rights of any person;</li>
										<li>use the site to upload or distribute any information that promotes or contains bigotry, racism, hatred, profanity or obscenity, promotes physical harm or harms minors in any way;</li>
										<li>engage in any fraudulent, abusive or illegal activity, including but not limited to any communication or solicitation designed or intended to fraudulently obtain the password or any private information of any person;</li>
										<li>use the site to violate the security of any computer network, crack passwords or security encryption codes, transfer or store illegal material;</li>
										<li>reverse engineer, decompile, disassemble, copy, reproduce, distribute, sell, modify, transmit, perform, publish or create any derivative work from or in any way exploit the site content for any commercial purpose without express written consent of creosouls or as permitted by this �Terms of Use�;</li>
										<li>distribute any downloaded file that you know, or reasonably should know, cannot be legally distributed;</li>
										<li>reproduce, duplicate, copy, sell or exploit for any commercial purpose, or redistribute or publish the site content or services provided by creosouls or obtained from creosouls without obtaining creosouls’s express, prior written consent or as permitted by this “Terms of Use”. This restriction includes any attempt to incorporate any information provided by creosouls into any other directory, product, or service;</li>
										<li>do any act that violates creosouls’s intellectual property or intellectual property rights in the site content or any intellectual property rights of any third party;</li>
										<li>provide misleading information about the origin or source of information or content provided by you on the Site;</li>
										<li>without our express written permission, use any technology like robot, spider, scraper or other automated means to access the site for any purpose.</li>
										<li>take any action that imposes, or may impose in our sole discretion an unreasonable or disproportionately large load on our infrastructure</li>
										<li>interfere or attempt to interfere with the proper working of the site or any activities conducted on the Site;</li>
										<li>bypass any measures we may use to prevent or restrict access to the site;</li>
										<li>artificially in?ate or alter number of views, likes or favourites, vote counts, blog counts, comments, or any other service or for the purpose of giving or receiving money or other compensation in exchange for votes, or for participating in any other organized effort that in any way artificially alters the results of services;</li>
										<li>use the site to store and/or display and/or publish any adult or offensive content, which without limitation includes all pornography, erotic images, or otherwise lewd or obscene content. The designation of "adult content" is left entirely to creosouls’s discretion;</li>
										<li><span style="color:#CC4739">Threatens</span><span style="color:#34A853"> (threaten)</span> the unity, security or sovereignty of any country;
										<li>violate any law for the time being in force.</li>
				                    </ul>
				                    <p>&nbsp;</p>
				                    <p><strong>USER CONDUCT</strong></p>
				                    <hr />
				                    <p>You can access only certain parts of the site without registration/ subscription as determined by creosouls from time to time. If you wish to gain complete access to the site/ access to certain specific portions of the site, site content or services creosouls may require its members/users to first register with the site, by creating a login name and password and accept all the terms and conditions in, and linked to, the terms of Use and the Agreement.</p>
				                    <p>The registration information that you provide must be accurate, complete, and current at all times. Failure to do so constitutes a breach of the terms, which may result in immediate termination of your creosouls account. You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trade mark that is subject to any rights of another person or entity other than You without appropriate authorization, or a name that is otherwise offensive, vulgar or obscene.</p>
				                    <p>Services are available only to individuals who are 18 years old. In case of minor if the parent/legal guardian have authorized a minor to use the site, the parent/legal guardian are responsible for the online conduct of such a minor, and the consequences of any misuse of the site by the minor. Parents and legal guardians are hereby informed that the site may display certain images that may contain nudity and/or violence that may be offensive to some.</p>
				                    <p>You may also be required to pay a non-refundable subscription fee periodically (as determined by creosouls from time to time) as a consideration for creating, accessing and using premium features of the site. If you are a part of a corporate entity that is party to a separate subscription agreement, then the terms and conditions of such subscription agreement shall prevail over this “Terms of Use” in case of a conflict between the two.</p>
				                    <p>In order to process the payments towards registration/subscription, you shall provide us with your bank account and credit card details and collection/use/ transfer of such information shall be governed by the Privacy Policy.</p>
				                    <p>At all times, you will be solely responsible for keeping secure the user identity/login name and password required to access the site, site content and services. All acts and actions performed by any person using the identity/login name and password allotted to you shall be deemed to have been committed by you or under your authority and you will be liable for the same. You will ensure that the password is kept confidential and not shared with any other person.</p>
				                    <p>You shall not share your login name and password with any other individual or corporate entity and you will not permit any other person or entity to use the site via your login name and password either concurrently with you or otherwise. creosouls reserves the right to refuse, disable or terminate your site access or account, whether in part or in full, if in its sole discretion at any time it is found that you have been sharing your password or using someone else’s password in any unauthorized way or have been using such password for any illegal or unauthorized purpose or you have infringed or likely to infringe the copyrights or other intellectual property rights of creosouls and/or other third party.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>MY Page &amp; Account Setting</strong></p>
				                    <hr />
				                    <p>You can personalize your use of the site through “MY Page”& “Account Setting”, features available exclusively to you who have registered/ subscribed to the site.</p>
				                    <p>You agree that creosouls shall have the right to monitor, review all portions of user content and may remove any and all such user content<span style="color:#CC4739"> if in the reasonable opinion of creosouls such User Content violates the Terms of Use or is objectionable in any manner.</span><span style="color:#34A853">(if in the reasonable opinion of creosouls it is objectionable in any manner such user content that violates the “Terms of Use”)</span></p>
				                    <p>You hereby grant creosouls a perpetual, worldwide, non-exclusive, sub-licensable license to all your user content. This license will exist for the period during which the user content is posted on the site and will automatically terminate upon the removal of the user content from the site. The license granted to creosouls includes the right to use your user content fully or partially for promotional reasons and to distribute and redistribute your user content to other parties, web-sites, applications, and other entities, provided such user content is attributed to you in accordance with the credits (i.e. username, profile picture, photo title, descriptions, tags, and other accompanying information) if any and as appropriate, all as submitted to creosouls by you. creosouls makes no representation and warranty that user content posted on the site will not be unlawfully copied without your consent. creosouls does not restrict the ability of users and visitors to the site to make low resolution or 'thumbnail' copies of user content posted on the site and you hereby expressly authorize creosouls to permit users and visitors to the site to make such low resolution copies of your user content.</p>
				                    <p>You represent and warrant that all user content posted by you on “MY Page” does not infringe any intellectual property rights or any other third party rights. You further represent that you have validly procured all necessary right, licenses and consents in relation to such user content. creosouls shall not be responsible for any liability (including infringement of intellectual property rights or other third party rights) in relation to the User Content.</p>
				                    <p>creosouls reserves the right to report any wrong doing of which we become aware to the applicable government agencies or otherwise.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>PRIVACY POLICY</strong></p>
				                    <hr />
				                    <p>creosouls is committed to protecting your privacy. In the course of using the site or availing the services, creosouls may become privacy to your personal information, including information that is of a confidential nature. Apart from this “Terms of Use”, you agree to be bound by the “Privacy Policy”.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>LOG FILES</strong></p>
				                    <hr />
				                    <p>We may store and use IP addresses or log on information to analyze trends, administer the site, track user’s movement, and gather broad demographic information and such other information as may be necessary for marketing purposes and for other uses. Additionally, in case of registered/ subscribed users, for systems administration, detecting usage patterns and troubleshooting purposes, our web servers automatically log standard access information including browser type, access times, URL requested, and referral URL. This information is not shared with third parties and is used only on a need-to-know basis. Any individually identifiable information related to this data will never be used in any way different to that stated above without your explicit permission. For more details please refer our “Privacy Policy” as to “How your personal information will be used?”</p>
				                    <p>&nbsp;</p>
				                    <p><strong>CONTENT FROM AND POSTING ON/ LINKING TO THIRD-PARTY WEBSITES</strong></p>
				                    <hr />
				                    <p>You further acknowledge that the site content may contain content proprietary to creosouls or other third parties. The site content may also include links to third party websites (“Third Party Sites”). When you access such Third Party Sites, you do so of your own volition and creosouls has no responsibility or liability for any content or services provided in such Third Party Sites. Any content available on or through any such Third Party Sites will be governed by the terms of use of those websites, and not of creosouls. With regard to any content available on the site which is sourced from any Third Party Sites, the content usage rules as may be provided for in the terms of use of such Third Party Sites may be applicable in addition to the Terms of Use of this Site.</p>
				                    <p>We do not monitor or review or provide any representations with respect to the content of Third Party Sites which are linked to from this Site. Links on the site to Third Party Sites or information are provided solely as a convenience to you. If you use these links, you will leave the site. Such links do not constitute or imply an endorsement, sponsorship, or recommendation by creosouls of the third party, the third-party website, or the information contained therein.</p>
				                    <p>creosouls will not accept any responsibility for any loss or damage in whatever manner, howsoever caused, resulting from your disclosure of any information, personal or otherwise, on such Third Party Sites. We, therefore, encourage our users to be aware when they leave our Site and to read the privacy statements of such third party websites.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>INTELLECTUAL PROPERTY RIGHTS (IPRs)</strong></p>
				                    <hr />
				                    <p>creosouls respects the intellectual property rights of others, and we request our visitors and users to do the same. The site and the site content is protected by applicable intellectual property laws and international treaties.</p>
				                    <p>Except as permitted under these “Terms of Use” or unless expressly authorized by creosouls, You agree not to reproduce, modify, sell, distribute, mirror, frame, republish, download, transmit, or create derivative works of the site content, in whole or in part, by any means. You must not remove or modify any copyright or trademark notice, or other notice of ownership. You shall abide by the “Terms of Use” and the “Agreement” while using the site content on the site. Any other use is prohibited and will constitute an infringement of the proprietary rights of creosouls and/ or the relevant owner.</p>
				                    <p>creosouls and/or its licensors assert all proprietary rights in and to all names and trademarks contained on the site. The name creosouls is the trademark and copyright (or any other intellectual property right) of creosouls, the owner of the site. Any use of the creosouls’s trademarks or copyright in connection with any product or service that does not belong to the creosouls, unless otherwise authorized in a written license agreement, will constitute an infringement upon the trademark and copyright (or any other such intellectual property right) and may be actionable under the applicable laws.</p>
				                    <p>Unless explicitly stated herein, nothing in these “Terms of Use” shall be construed as conferring any license to intellectual property rights, whether by estoppel, implication, or otherwise.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>DISCLAIMER</strong></p>
				                    <hr />
				                    <p>creosouls DISCLAIMS ANY REPRESENTATION AND WARRANTIES FOR THE SECURITY, RELIABILITY, TIMELINESS, AND PERFORMANCE OF (I) THE SITE, SERVICES, AND CONTENT; (II) THIRD PARTY PRODUCTS OR SERVICES ADVERTISED ON OR RECEIVED THROUGH ANY LINKS PROVIDED ON THE SITE; (III) ANY INFORMATION, CONTENT OR ADVICE RECEIVED THROUGH SUCH SITE, LINKS OR PRODUCTS OR SERVICES.</p>
				                    <p>YOUR USE OF THE SITE IS AT YOUR SOLE RISK UNLESS OTHERWISE EXPLICITLY STATED. THE SITE, INCLUDING THE CONTENT IS PROVIDED ON AN "AS IS", "AS AVAILABLE" AND "WITH ALL FAULTS" BASIS WITH NO REPRESENTATIONS OR WARRANTIES WHATSOEVER. ALL EXPRESS, IMPLIED, AND STATUTORY REPRESENTATIONS AND WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT OF THIRD PARTY RIGHTS, ARE EXPRESSLY DISCLAIMED TO THE FULLEST EXTENT PERMITTED BY LAW.</p>
				                    <p>NOTHING ON THIS WEBSITE SHOULD BE TAKEN TO CONSTITUTE PROFESSIONAL ADVICE OR A FORMAL RECOMMENDATION AND WE EXCLUDE ALL REPRESENTATIONS AND WARRANTIES RELATING TO THE CONTENT AND USE OF THIS SITE.</p>
				                    <p>creosouls MAKES NO WARRANTY OR REPRESENTATION THAT: (A) THE SITE, CONTENT, SERVICES OR SERVER THAT MAY BE USED BY creosouls WILL BE UNINTERRUPTED, TIMELY, SECURE, PROBLEM-FREE OR ERROR-FREE; (B) THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE SITE, CONTENT OR SERVICES WILL BE ACCURATE OR RELIABLE; (C) THE QUALITY OF ANY SERVICES, CONTENT OR OTHER MATERIAL AVAILABLE ON THE SITE WILL MEET YOUR EXPECTATIONS OR REQUIREMENTS; OR (D) ANY ERRORS IN THE SITE WILL BE CORRECTED.</p>
				                    <p>creosouls ASSUMES NO RESPONSIBILITY AND/OR LIABILITY WITH RESPECT TO ANY USER CONTENT WHICH YOU MAY POST ON THE SITE. YOU ARE SOLELY RESPONSIBLE AND LIABLE IN RESPECT OF SUCH USER CONTENT.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>LIMITATION OF LIABILITY</strong></p>
				                    <hr />
				                    <p>TO THE FULLEST EXTENT PERMITTED BY LAW, creosouls IS NOT LIABLE FOR ANY , INDIRECT, REMOTE, PUNITIVE, SPECIAL, INCIDENTAL, CONSEQUENTIAL, OR EXEMPLARY DAMAGES (INCLUDING, WITHOUT LIMITATION, LOSS OF BUSINESS, REVENUE, PROFITS, GOODWILL, USE, DATA, ELECTRONICALLY TRANSMITTED ORDERS, OR OTHER ECONOMIC ADVANTAGE) ARISING OUT OF OR IN CONNECTION WITH THE SITE, EVEN IF creosouls HAS PREVIOUSLY BEEN ADVISED OF, OR REASONABLY COULD HAVE FORESEEN, THE POSSIBILITY OF SUCH DAMAGES, HOWEVER THEY ARISE, WHETHER IN BREACH OF CONTRACT OR IN TORT (INCLUDING NEGLIGENCE), INCLUDING WITHOUT LIMITATION DAMAGES DUE TO: (a) THE USE OF OR THE INABILITY TO USE THE SITE OR CONTENT OR SERVICES; (b) STATEMENTS OR CONDUCT OF ANY THIRD PARTY ON THE SITE, INCLUDING WITHOUT LIMITATION UNAUTHORIZED ACCESS TO OR ALTERATION OF TRANSMISSIONS OR DATA, MALICIOUS OR CRIMINAL BEHAVIOUR, OR FALSE OR FRAUDULENT TRANSACTIONS; OR (c) CONTENT OR INFORMATION YOU MAY DOWNLOAD, USE, MODIFY OR DISTRIBUTE.</p>
				                    <p>IN ANY EVENT creosouls’S LIABILITY ARISING OUT OF THIS TERMS OF USE AND/ OR AGREEMENT SHALL NOT EXCEED THE AMOUNT ACTUALLY PAID BY YOU AS SUBSCRIPTION FEE AT THE TIME OF REGISTRATION/ SUBSCRIPTION TO THE SITE.</p>
				                    <p><strong>NOTIFICATION OF CHANGES</strong></p>
				                    <hr />
				                    <p>creosouls reserves the right to modify this “Terms of Use” or the “Agreement” at any time without giving you prior notice. Your use of the site following any such modification constitutes your agreement to follow and be bound by this “Terms of Use” or the “Agreement” as may be modified from time to time. The last date this “Terms of Us0”e was revised may be set forth at the end of this “Terms of Use”. Your continued use of the Site after notice of any change to the “Terms of Use” will be deemed to be your consent to the amended terms.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>TERMINATION OF USE</strong></p>
				                    <hr />
				                    <p>You agree that we may, in our sole discretion, terminate or suspend Your access to all or part of the site with or without notice and for any reason, including, without limitation, breach of these “Terms of Use”. Any suspected fraudulent, abusive or illegal activity may be grounds for terminating your relationship and may be referred to appropriate law enforcement authorities.</p>
				                    <p>Upon termination or suspension, regardless of the reasons therefore, your right to use the content, site or services immediately ceases, and you acknowledge and agree that we may immediately deactivate or delete your account (including your subscription) and all related information and files in your account and/or bar any further access to such files or this site. You shall not be entitled to any refund of the subscription fee paid by you at the time of subscribing to creosouls’s site, content or services. We shall not be liable to you or any third party for any claims or damages arising out of any termination or suspension or any other actions taken by us in connection with such termination or suspension.</p>
				                    <p>&nbsp;</p>
				                    <p><strong>GOVERNING LAW AND JURISDICTION</strong></p>
				                    <hr />
				                    <p>The Agreement is governed by the laws of India. By accessing the site, you consent to the exclusive jurisdiction of Pune courts, in India in all disputes arising out of or relating to the use of the site content or services. Use of the site is unauthorized in any jurisdiction that does not give effect to all provisions of the agreement, including without limitation, this paragraph.</p>
				                    <p>&nbsp;</p>
			                  	</div>
			                  	<div role="tabpanel" class="tab-pane fade" id="PRIVACY_POLICY">
				                    <p>"<strong>creosouls</strong>" is committed to respecting the privacy of every person who shares information with creosouls including but not limited to age, gender, name, birth date, occupation, bank name, bank account details, biometric information and any other data as disclosed by you to us ("<strong>Personal Information</strong>"). Your privacy is important to us and we strive to take reasonable care and protection of the information we receive from you.</p> 
				                    <p>The purpose of this Privacy Policy ("<strong>Policy</strong>"), as amended from time to time, is to give you an understanding on how we intend to collect and use the information you provide to us. This Policy read along with the terms and conditions ("<strong>Terms</strong>") governing our website www.creosouls.com provide our practices on the collection, storage, processing and transfer of Personal Information of our Users.</p>
				                    <p>Creosouls is a one stop online portfolio management and social networking platform for animation students. It offers activities like portfolio management, quality of training and assignments, direct information about job opportunities and opportunity to participate in competitions. Creosouls allows you to access other professionals or students work in one place. On Creosouls, you can get feedback from experts, friends and followers. You can also like, comment or appreciate other people's work just like other social networking websites.Creosouls also allows you to upload the YouTube video link associated with your work.On creosouls you can stay updated about events.</p>
				                    <p>All capitalized terms which are not defined in this Privacy Policy have the same meaning as set out in the Terms.</p>
				                    <p>Collection of Personal Information and its Usage</p>
				                    <hr>
				                    <p><strong>Creosouls Features:</strong></p>
				                    <p>
					                    <ul>
					                        <li>One can upload creative portfolio and share with the world - Creosouls allows you to upload projects in 36 different categories.</li>
					                        <li>One stop for uploading all creative content.</li>
					                        <li>Get access to other professionals and students work in one place - You can view the creative work uploaded by other students form different centers/institutes.</li>
					                        <li>Participate in competitions - You can participate in the competitions on institute level and as well as on regional level.</li>
					                        <li>Stay updated about events - Get notified about the day-today events held at institute level as well as on regional level.</li>
					                        <li>Get feedback from experts, friends & followers - Creosouls allows you to like, comment or appreciate work just like other social networking websites.</li>
					                        <li>Ability to configure Google Drive for Back up (15 GB additional Space)</li>
					                        <li>Creosouls also allows you to upload Youtube video link associated with your project.</li>
					                        <li>Get Access to Jobs and Get Hired - Get notified when there is a job opening for your location.</li>
					                        <li>Get your work Rated and Recommended by Experts.</li>
					                        <li>Get inspiration & knowledge with the help of blogs & interviews</li>
					                        <li>Newsletter is uploaded on monthly basis on Creosouls which highlights the events or competitions occurred for that month.</li>
					                        <li>Creosouls provide My Profile option - Where Students can create their profile and apply jobs using the same profile.</li>
					                    </ul>
				                    </p>
			                        <p>All capitalized terms which are not defined in this Privacy Policy have the same meaning as set out in the Terms.</p>
			                        <hr>
			                        <p><strong>What information/data do we collect?</strong></p>
			                        <p>We may collect Personal Information from you ; when you contact us by any method, register on our Site/Application, use any Services, or sell or purchase any Designs on our Site/Application or is provided to us by third parties who are authorized on your behalf to share your Personal Information.</p>
			                        <p>By providing us your information (directly or via third parties), you hereby consent to the collection, disclosure, processing and transfer of such information for the purposes as disclosed in this Policy. You are providing the information (directly or via third parties)` out of your free will. You have the option not to provide us the data or Personal Information if you do not agree with this Policy. If you do not wish to provide us with Personal Information as requested on the Site, we may not be able to provide you our Services and you may not be able to access all areas of the Site.</p>
			                        <p>Creosouls uses your Gmail ID for login. Creosouls only uses the First name and Last name from your Gmail account.</p>
			                        <p>We may collect, disclose, process, store, use and transfer your Personal Information to:</p>
				                    <ul>
				                        <li>Enable the functioning of creosouls's business;</li>
				                        <li>Provide our services and to engage in/ carry out the activities that would enable and assist in providing you our services;</li>
				                        <li>Transfer information about you to such third parties as may be required if we are acquired by or merged with another company;</li>
				                        <li>Administer or otherwise carry out our obligations in relation to any agreement you have with us;</li>
				                        <li>Respond to subpoenas, court orders, or legal process, or to establish or exercise our legal rights or defend against legal claims; and</li>
				                        <li>To investigate, prevent, or take action regarding illegal activities, suspected fraud, violations of the website or as otherwise required by law.</li>
				                        <li>To notify you of changes to our goods or services;</li>
				                        <li>To send email notifications for special promotions or offers conducted by us, our suppliers or distributors;</li>
				                        <li>To conduct marketing activities and to conduct market research;</li>
				                        <li>To respond to your questions or suggestions.</li>
				                    </ul>
				                    <p>We may also remove all the personally identifiable information from your Personal Information, and use the remaining data for historical or statistical purposes.</p>
				                    <hr>
				                    <p><strong>How do we use such information?</strong></p>
				                    <p>We use your information for the following purposes: </p>
				                    <ul>
				                        <li>To provide and operate the Services;</li>
				                        <li>To enhance our data security and fraud prevention capabilities; </li>
				                        <li>To create aggregated statistical data and other aggregated and/or inferred information, which we may use to provide and improve our respective Services.</li>
				                    </ul>
				                    <p>Our use of your Information is necessary to support legitimate interests that we have as a business (for example, to maintain and improve our Services by identifying user trends and the effectiveness of our promotional campaigns and identifying technical issues), provided it is conducted at all times in a way that is proportionate, and that respects your privacy rights</p>
				                    <hr>
				                    <p><strong>How we share your information?</strong></p>
				                    <p>We may share your information with service providers and others (or otherwise allow them access to it) in the following manners and instances:</p>
				                    <ul>
				                        <li>Third party Designers or Customers who may request information regarding any Designs created or purchased by you.</li>
				                        <li>Affiliates and companies within our corporate group</li>
				                        <li>Agents</li>
				                        <li>Third party that provide services to creosouls</li>
				                        <li>Business partners</li>
				                        <li>Other agencies</li>
				                    </ul>
				                    <p>Your Personal Information will be disclosed, shared, or transferred to such third parties for purposes specified under this Policy or to fulfil our obligations under a contract with you or as may be required by law.
				                    </p>
				                    <hr>
				                    <p><strong>Where do we store your information?</strong></p>
				                    <p>Information of Account holders and non-Account holders may be maintained, processed and stored by us and our authorized affiliates and service providers in Maharashtra, India and in other jurisdictions as necessary for the proper delivery of our Services and/or as may be required by law.</p>
				                    <p><u>Information placed on your computer</u></p>	                                
				                    <p>We may store some information such as "cookies" on your computer. A cookie does not identify you personally but it does identify your computer. We may use such 'cookies' to enable us to monitor the traffic on our Site, and provide Users with better Services. We may also allow some of our marketing or technology partners to utilize such 'cookies' to collect non-personally identifying data regarding Users to assist in delivering services to you. You can erase or choose to block these cookies from your computer. You can configure your computer's browser to alert you when we attempt to send you a cookie with an option to accept or refuse the cookie.</p>	                                
				                    <p><u>Use of Cookies and Similar Technologies</u></p>	                                
				                    <p>A cookie is a small file of letters and numbers downloaded on to your computer when you access certain websites. In general, cookies allow a website to recognize a user�s computer. The most important thing to know about cookies placed by Creosouls is that they make our website a bit more user-friendly, for example, by remembering site preferences and language settings.</p>
				                    <p>Cookies should be divided in two types:</p>
				                    <p>"First-party cookies" - Cookies that are placed by Creosouls</p>
				                    <p>"Third-party cookies" - Cookies that are placed and used by Third Party Service Providers</p>
				                    <p>We also use other technologies with similar functionality to cookies, such as web beacons, pixels, and tracking URLs, to obtain Log Data (as described in the Privacy Policy). For example, our email messages may contain web beacons and tracking URLs to determine whether you have opened a certain message or accessed a certain link.</p>
				                    <p>Duration: Depending on their function, Cookies may have different durations. There are session cookies and persistent cookies:</p>
				                    <p>Session cookies only last for your online session. It means that the browser deletes these cookies once you close your browser.</p>
				                    <p>Persistent cookies stay on your device after the browser has been closed and last for the period of time specified in the cookie.</p>
				                    <p>Categories: The cookies used on our website fall into one of four categories: Essential, Analytics, Functional and Marketing.</p>
				                    <p>Essential Cookies let you move around the website and use essential features like secure and private areas.</p>
				                    <p>Analytics cookies let us understand how you use our website (e.g. which pages you visit and if you experience any errors). These cookies are essential to us being able to enhance and maintain our platform.</p>
				                    <p>Functional cookies are cookies used to remember choices users make to improve their experience.</p>
				                    <p>Marketing cookies are used to collect information about the impact of our marketing campaigns performed in other website on users and non-users. These cookies are only used on Creosouls owned sites under creosouls.com</p>
				                    <hr>
				                    <p><strong>How we give them User data Security?</strong></p>
				                    <p><u>Security</u></p>
				                    <p>The security of your Personal Information is important to us. We have adopted reasonable security practices and procedure to ensure that the Personal Information collected is secure.</p>
				                    <p>You agree that such measures are secured and adequate. While we will endeavour to take all reasonable and appropriate steps to keep secure any information which we hold about you and prevent unauthorized access, you acknowledge that the internet is not 100% secure and that we cannot provide any absolute assurance regarding the security of your Personal Information. We will not be liable in any way in relation to any breach of security or unintended loss or disclosure of information caused by us in relation to your Personal Information.</p>
				                    <p>We have implemented security measures designed to protect the Information you share with us, including physical, electronic and procedural measures. Among other things, we offer HTTPS secure access to most areas on our Services; the transmission of sensitive information is protected by an industry standard SSL/TLS encrypted connection. We also regularly monitor our systems for possible vulnerabilities and attacks, and regularly seek new ways and Third Party Services for further enhancing the security of our Services and protection of our visitors' and Users' privacy.</p>
				                    <p>Regardless of the measures and efforts taken by us, we cannot and do not guarantee the absolute protection and security of your Information, or any other content you upload, publish or otherwise share with us or anyone else. We therefore encourage you to set strong passwords for your User Account, and avoid providing us or anyone with any sensitive information which you believe its disclosure could cause you substantial or irreparable harm.</p>
				                    <p><u>Third Party Links</u></p>
				                    <p>During your interactions with us, it may happen that we provide/include links and hyperlinks of third party websites. The listing of such third party external site does not imply endorsement of such site by us. We do not make any representations regarding the availability and performance of any of the external sites which could be provided.</p>
				                    <p>We are not responsible for the content, terms of use, privacy policies and practices of such third party websites / services.</p>
				                    <p><u>Access</u></p>
				                    <p>If you need to update or correct your Personal Information or have any grievance with respect to the processing or use of your Personal Information, for any reason, you may send updates and corrections to us at support@creosouls.com and we may take all reasonable efforts to incorporate the changes and/or address your grievances within a reasonable period of time.</p>
				                    <p>Further, you will have an option to withdraw your consent given earlier, provided such withdrawal of the consent is intimated to us in writing. If you do not provide us Personal Information or withdraw the consent to provide us Personal Information at any point in time, we shall have the option not to fulfil the purposes for which the said Personal Information was sought.</p>
				                    <p><u>Applicable Law</u></p>
				                    <p>This Privacy Policy is subject to and governed by the laws of the Republic of India. If the terms of this Privacy Policy are inapplicable or insufficient in your country (whether by operation of law or otherwise), please refrain from accessing and using our website.</p>
				                    <p><u>Data Retention</u></p>
				                    <p>We may retain your Information for as long as your Account is active, as indicated in this Privacy Policy or as otherwise needed to provide you with our Services.</p>
				                    <p>We may continue to retain such Information even after you deactivate your Account and/or cease to use any particular Services, as reasonably necessary to comply with our legal obligations, to resolve disputes regarding our Users, prevent fraud and abuse, enforce our agreements and/or protect our legitimate interests. Where your Information is no longer required, we will ensure it is securely deleted.</p>
				                    <p><u>Creosouls Profile Page</u></p>
				                    <p>Please note that when you create an Account, your profile page will display your Account user name and certain statistics regarding your own use of the Services, including but not limited to, the date you became an Account holder, the categories of materials you posted and how long ago you last visited the Sites. It will also display information about the Account holders who visit your profile page including the names of those Account holders who follow you (if the Account holder has permitted such display), and the number of visitors to, and views of your profile page or pages containing content you have submitted.</p>
				                    <p>Any information or content that you post to your profile page, or to any Groups which you are a part of or forums will be publicly accessible by Users so please exercise your good judgment before you post. The name you choose when creating your Account is visible to all Users of the Services. If you visit another Account holder's profile page, your user name will appear on that page. Creosouls does not control, and is not responsible for, the use of any information or content that you have exposed to the public through your use of the Services. You may use the tools we make available via the Services to make decisions about what information about you, including Information, will be visible on your profile page and on the profile pages of other Account holders that you visit. Please note accounts can be created either by individuals or companies. Note that in some cases, we may not be able to remove your Information from such areas.</p>
				                    <p><u>Changes to This Privacy Policy</u></p>
				                    <p>Creosouls reserves the right to modify this Policy at any time without giving you prior notice. Your use of the Site following any such modification constitutes your agreement to follow and be bound by this Policy as may be modified from time to time. The last date this Policy was revised may be set forth at the end of this Policy. Your continued use of the Site after notice of any change to the Policy will be deemed to be your consent to the amended terms.</p>
				                    <hr>
				                    <p><strong>Android App Permissions:</strong></p>
				                    <p><b>Account :</b> We use your Gmail ID and Nmae to identify you on Creosouls. Your Email I'd will be secure with us with our standard encrypted format.</p>
				                    <p><b>Device ID :</b> We your phone device ID to identify on which phone you made login in the past because we allowing you to login from multiple devices. We never share your device ID with any one.</p>
				                    <p><b>Camera :</b> App requests camera permission to click photo by camera for student project and his profile picture to upload to server.</p>
				                    <p><b>Storage :</b> App requests camera permission to select photos from storage/gallery for student project and his profile picture to upload to server.</p>
				                    <p><b>Location :</b> App requests location permission to fetch user location.</p>
				                    <p><b>Internet :</b> App requests internet permission to connect with server.</p>
				                    <hr>
				                    <p><strong>Contact Us</strong></p>
				                    <p>We can address any questions, comments and concerns about our online privacy practices and policy. Please write to us at &nbsp;<a href="mailto:<?php echo $emailFrom;?>"><?php echo $emailFrom;?></a>.</p>
			                  	</div>
			                </div>
						</div>
					</div>
				</div>
		      	<div class="modal-footer">
		       		<div class="col-md-12 agree">
				       <form class="form-horizontal" method="post" action="<?php echo base_url()?>hauth/terms_and_conditions">
							<input type="hidden" name="user_id" value="<?php echo $userId;?>">
							<input type="hidden" name="login_id" value="<?php echo $loginId;?>">
							<input type="checkbox" name="terms_and_conditions" id="terms_and_conditions" value="1" required onclick ="termsAndConditions();" >&nbsp;&nbsp; I Agree Terms And Conditions<br>
							<button type="submit" class="btn btn_bluebtn btn_blue pull-right" style=""> Agree </button>
						</form>
			      	</div>
		      	</div>
			</div>
	    </div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script type="text/javascript">
	$(document).ready(function(){
		var scroll_start = 0;
		var startchange = $('nav');
		var offset = startchange.offset();
		$(document).scroll(function() {
			scroll_start = $(this).scrollTop();
			if(scroll_start > offset.top) {
				$('nav').css('background-color', 'rgba(0,0,0,0.8)');
				$('nav').css('transition', '0.3s');
			} else {
				$('nav').css('background-color', '#000');
			}
		});
	});
	$('.carousel').carousel({
		interval: 5000 //changes the speed
	})
</script>
<!-- <script src="<?php echo base_url();?>assets/js/masonry.pkgd.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<script src="<?php echo base_url();?>assets/js/owl.carousel.js"></script> -->
<!-- <script>
	$(document).ready(function() {
		<?php if(!empty($event)) { ?>
			var owl3 = $("#owl-slider3");
			owl3.owlCarousel({
				autoPlay: false,
				items : 4, //10 items above 1000px browser width
				itemsCustom : false,
				itemsDesktop : [1199,3],
				itemsDesktopSmall : [980,3],
				itemsTablet: [768,3],
				itemsTabletSmall: false,
				itemsMobile : [479,1],
				singleItem : false,
				itemsScaleUp : false,
				pagination : false,
				navigation : false,
				mouseDrag:false,
				touchDrag:false
			});
			<?php 
		} ?>
	});
</script> -->
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56b0bc237eb112d2"></script> -->
<script>
	function openProject(){
		<?php $FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		if($FRONT_USER_SESSION_ID == 0){ ?>
			window.location.href = '<?php echo base_url();?>hauth/googleLogin';
			<?php 
		} else{ ?>
			jQuery('#add_project_button').click();
			<?php 
		} ?>
	}
	jQuery(document).ready(function($) {
		<?php if(isset($terms_and_condition) && $terms_and_condition!='') { ?>
			$('#myModal').modal('show');
			<?php    
		}
		if($this->session->userdata('guest_user') && $this->session->userdata('guest_user')=='guest_user') { ?>
			$('#centerModel').modal('show');
			//window.location.href = '<?php echo base_url()?>hauth/center_name/1';
			<?php 
		}  ?>
	});
	function termsAndConditions(){
		var terms_and_conditions = $('input:checkbox:checked').val();
		$.ajax({
			url: "<?php echo base_url();?>hauth/terms_and_conditions",
			data: { checked_box : $('input:checkbox:checked').val()},
			type: "POST",
		}).done(function() {
			console.log("success");
		});
	}
</script>
<script src="<?php echo base_url();?>assets/js/numscroller-1.0.js"></script>




