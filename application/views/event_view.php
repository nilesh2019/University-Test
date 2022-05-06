<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
						<a href="<?php echo base_url();?>">
							Home
						</a>
					</li>
					<li>
						<a href="<?php echo base_url()?>event/event_list">
							Events
						</a>
					</li>
					<li class="active">
						<?php echo $event[0]['name'];?>
					</li>
				</ol>
			</div>
			<div class="clearfix">
			</div>
			<div class="col-lg-12">
				<?php
				if(!empty($event)){
					?>
					<div class="event_detail">
						<div class="col-lg-6">
							<div class="event_pik">
								<img src="<?php echo file_upload_base_url();?>event/banner/<?php echo $event[0]['banner'];?>" alt="banner image">
							</div>
							<div class="dropdown pull-right" style="padding-top: 10px">
								<img class="dropdown-toggle" data-toggle="dropdown" alt="banner image" src="<?php echo base_url();?>assets/images/shr.png"  style="cursor: pointer;">
								
								<ul class="dropdown-menu">
									<li>
										<a href="javascript:void(0);" onclick="return sharelink(1);" >
											Facebook
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" onclick="return sharelink(2);" >
											Twitter
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="description">
								<h2><a href="#" style="color: #00B4FF;">
									<?php echo $event[0]['name'];?></a>
								</h2>
								<p>
									<i class="fa fa-calendar-check-o">
									</i>&nbsp;<a href="#"style="color: #414141;">Start Date :</a>
									<a href="#" ><span>
										<?php echo date("F j, Y",strtotime($event[0]['start_date']));?>
									</span></a>
								</p>
								<p>
									<i class="fa fa-calendar-check-o">
									</i>&nbsp;<a href="#" style="color: #414141;">End Date&nbsp; :</a>
									<a href="#" ><span>
										<?php echo date("F j, Y",strtotime($event[0]['end_date']));?>
									</span></a>
								</p>
								<h4 >
									<a style="color: #414141;" href="#" >Coupon Code :</a>
									<b>
										<?php echo $event[0]['coupon_code'];?>
									</b>
								</h4>

								<h4><a href="#" style="color: #414141;">
									Description :</a></h4>
								<p><a href="#" style="color: #414141;">
									<?php echo $event[0]['description'];?>
								</a></p>
								<?php 
								 if($this->session->userdata('user_admin_level') == 2 || $this->session->userdata('user_admin_level') == 4  || $this->session->userdata('teachers_status')==1) { 
								 	// if(isset($login_percentage) && !empty($login_percentage) && $login_percentage>=80)
								 	// { ?>
									<h4>
										Event Link :
										<a target="_blank" href="<?php echo (isset($event[0]['link']) && !empty($event[0]['link']))?$event[0]['link']:'' ;?>" >Click</a> Here
									</h4>
								<?php /*}
								else{
										echo "<span style='color:red'>Note: If you are unable to view event link then contact your Regional Acadmic Head</span>";
									}*/  } ?>
							</div>
						</div>
					</div>
						<div class="col-lg-12">		
							<div class="col-lg-1"></div>
							<div class="col-lg-10">
								 <?php
				              if($event[0]['videolink'] != '')
				              {
				                ?>
				                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?php echo $event[0]['videolink'];?>?rel=0" frameborder="0" allowfullscreen>
				                </iframe>
				                <?php
				              } ?>
				          	</div>
							<div class="col-lg-1"></div>

			          </div>
					<?php
				}?>
			</div>
			<div class="clearfix">
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script>
	function sharelink(social)
	{
		if(social==1)
		{
			window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url();?>', '_blank');
		}
		else
		{
			window.open('https://twitter.com/share?url=<?php echo current_url();?>', '_blank');
		}
	}
</script>



