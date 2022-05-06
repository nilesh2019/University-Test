<?php $this->load->view('template/header');?>

<style>
	.navbar {
    background-color:rgb(0,0,0);
	}
body{
	background:#F0F0F0;
}
.link_home a{
	color: #00b4ff;
	   font-size: 20px;
	   left: 0;
	   margin: 35px auto auto;
	   position: absolute;
	   right: 0;
	   text-align: center;
}
.link_home a:hover{
color: #FF9A2D;
}
</style>

<div class="middle">
	<div class="container-fluid">
		<div class="row">		 
		 <div class="col-md-6  col-md-offset-3">
		 	<img src="<?php echo base_url(); ?>assets/images/404.jpg" alt="banner image" style="width: 100%;margin-top: 9%">
		 	<div class="link_home">
		 		<a href="<?php echo base_url();?>">Back To Home</a>
		 	</div>
		 </div>				
		</div>
	</div>
</div>

<?php $this->load->view('template/footer');?>
