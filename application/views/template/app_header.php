<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">

<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="">

<meta name="author" content="">

-->

<?php

if($this->uri->segment(1) == "projectDetail"){

?>

<meta charset="UTF-8" /><meta property="og:site_name" content="creosouls" /><meta property="og:locale" content="en_US" />

<meta property="og:url" content="<?php echo current_url();?>" />

<meta property="og:type" content="article" />

<meta property="og:title" content="<?php

if(isset($project) && !empty($project) && isset($project[0]['projectName'])){

echo $project[0]['projectName'];

}

else

{

echo base_url();

}?>" />

<meta property="og:description" content="<?php

if(isset($project) && !empty($project) && isset($project[0]['basicInfo'])){

echo substr(strip_tags($project[0]['basicInfo']), 0, 250);

}

else

{

echo base_url();

}?>" />



<?php



if(isset($project) && !empty($project) && isset($project[0]['image_thumb'])){

$filename=file_upload_s3_path().'project/thumbs/'.$project[0]['image_thumb'];

	$file = getimagesize($filename);

		if($file[1] < 310)
		{
			$this->CI =& get_instance();

			$files['name'] = $project[0]['image_thumb'];

			$config['upload_path'] = file_upload_s3_path().'project/thumbs/';

			$config['allowed_types'] ='jpg|png|img|jpeg|gif';

			$this->CI->upload->initialize($config);

			$img =  $this->CI->upload->data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = file_upload_s3_path().'project/thumbs/'.$files['name'];

			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['master_dim'] = 'height';
			$config['width'] = '307';
			$config['height'] = '310';
			$this->CI->image_lib->initialize($config);
			$return = $this->CI->image_lib->resize();
			//echo $files['name'];die;

		}
}



?>



<meta property="og:image"  content="<?php

if(isset($project) && !empty($project) && isset($project[0]['image_thumb'])){

echo file_upload_base_url();?>project/thumbs/<?php echo $project[0]['image_thumb'];

}

else

{

echo '';

}?>" />

<!-- 	<meta property="og:image:type" content="image/jpg"> -->

<?php

} ?>

<?php if($this->uri->segment(1) == "competition" && $this->uri->segment(2) != "competition_list"){ ?>
<meta charset="UTF-8" />
<meta property="og:url" content="<?php echo base_url();?>competition/<?php echo $competition[0]['pageName'];?>"/>
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?php if(isset($competition) && !empty($competition) && isset($competition[0]['name'])){ echo $competition[0]['name'];} else{ echo base_url();}?>"/>
<meta property="og:description" content="<?php if(isset($competition) && !empty($competition) && isset($competition[0]['description'])){ echo substr(strip_tags($competition[0]['description']), 0, 150); } else{ echo base_url();}?>"/>
<?php

if(isset($competition) && !empty($competition) && isset($competition[0]['banner']))
{

	$filename=file_upload_s3_path().'competition/banner/'.$competition[0]['banner'];
	$file = getimagesize($filename);
	if($file[0] < 500)
	{
		$this->CI =& get_instance();
		$files['name'] = $competition[0]['banner'];
		$config['upload_path'] = file_upload_s3_path().'competition/banner/';
		$config['allowed_types'] ='jpg|png|img|jpeg|gif';
		$this->CI->upload->initialize($config);
		$img =  $this->CI->upload->data();
		$config['image_library'] = 'gd2';
		$config['source_image'] = file_upload_s3_path().'competition/banner/'.$files['name'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = true;
		$config['master_dim'] = 'width';
		$config['width'] = '500';
		$config['height'] = '300';
		$this->CI->image_lib->initialize($config);
		$return = $this->CI->image_lib->resize();
	}
}
?>
<meta property="og:image" content="<?php if(isset($competition) && !empty($competition) && isset($competition[0]['banner'])){ echo file_upload_base_url();?>competition/banner/<?php echo $competition[0]['banner'];} else{ echo ''; }?>"/>
<?php } ?>

<?php

if($this->uri->segment(2) == "show_event"){

?>

<meta charset="UTF-8" />

<meta property="og:url"                content="<?php echo current_url();?>" />

<meta property="og:type"               content="article" />

<meta property="og:title"              content="<?php

if(isset($event) && !empty($event) && isset($event[0]['name'])){

echo $event[0]['name'];

}

else

{

echo base_url();

}?>" />

<meta property="og:description"        content="<?php

if(isset($event) && !empty($event) && isset($event[0]['description'])){

echo substr(strip_tags($event[0]['description']), 0, 150);

}

else

{

echo base_url();

}?>" />

<meta property="og:image"             content="<?php

if(isset($event) && !empty($event) && isset($event[0]['banner'])){

echo file_upload_base_url();?>event/banner/<?php echo $event[0]['banner'];

}

else

{

echo '';

}?>" />

<?php

} ?>

<?php

if(isset($institute) && !empty($institute)){

?>

<meta charset="UTF-8" />

<meta property="og:url"                content="<?php echo current_url();?>" />

<meta property="og:type"               content="article" />

<meta property="og:title"              content="<?php

if(isset($institute) && !empty($institute) && isset($institute[0]['instituteName'])){

echo $institute[0]['instituteName'];

}

else

{

echo base_url();

}?>" />

<meta property="og:description"        content="<?php

if(isset($institute) && !empty($institute) && isset($institute[0]['address'])){

echo substr(strip_tags($institute[0]['address']), 0, 150);

}

else

{

echo base_url();

}?>" />

<meta property="og:image"              content="<?php

if(isset($institute) && !empty($institute) && isset($institute[0]['coverImage'])){

echo file_upload_base_url();?>institute/coverImage/<?php echo $institute[0]['coverImage'];

}

else

{

echo '';

}?>" />

<?php

}?>

<?php

if(isset($blog) && !empty($blog))

{

?>

<meta charset="UTF-8" />

<meta property="og:url"                content="<?php echo current_url();?>" />

<meta property="og:type"               content="article" />

<meta property="og:title"              content="<?php

if($blog[0]['title']!=''){

echo $blog[0]['title'];

}

else

{

echo base_url();

}?>" />

<meta property="og:keywords"        content="<?php

if($blog[0]['keywords']!=''){

echo $blog[0]['keywords'];

}

else

{

echo base_url();

}?>" />

<meta property="og:description"        content="<?php

if($blog[0]['description']!=''){

/*echo substr(strip_tags($blog[0]['description']), 0, 150);*/

}

else

{

echo base_url();

}?>" />

<meta property="og:image"              content="<?php

if($blog[0]['picture']!=''){

echo file_upload_base_url();?>blog/<?php echo $blog[0]['picture'];

}
else

{

echo '';

}?>" />

<?php

}
if($this->uri->segment(1) =='')
{?>
	<meta charset="UTF-8" />
	<meta property="og:site_name" content="creosouls" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:url" content="<?php echo base_url();?>" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="creosouls" />
	<meta property="og:description" content="Unleash your creativity with creosouls, creosouls an online Portfolio Management and Social Networking platform for Creative People including Job opportunities under single roof." />
	<meta property="og:image" content="<?php echo base_url();?>assets/CreonowBanner.jpg" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.png">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

Creosouls

</title>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.minicolors.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css">

<!-- Bootstrap Core CSS -->

<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

<link href="<?php echo base_url();?>assets/css/animate/animate.css" rel="stylesheet" type="text/css">

<!--Scroll Bar-->

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css">

<!--Scroll Bar End-->

<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.tag-editor.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/style/formValidation.min.css">

<!-- Custom Fonts -->

<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>

<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url();?>assets/css/Normalize.css" rel="stylesheet" type="text/css">

<!-- uploader css  -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/bootstrap-fileupload.min.css" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.fileupload.css"/>

<link rel="stylesheet" href="<?php echo base_url();?>assets/style/jquery.fileupload-ui.css"/>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/progress.css">

<!-- Custom CSS -->

<link href="<?php echo base_url();?>assets/css/modern-business.css?v=2" rel="stylesheet">
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--Social Side Bar-->

<!-- <script type="text/javascript">var switchTo5x=true;</script>

<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>

<script type="text/javascript" src="https://ss.sharethis.com/loader.js"></script>-->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

<!--[if lt IE 9]>

<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

<![endif]-->

<style>

.like_div

{

cursor: pointer;

}

.error_text

{

color: red;

}

.pie_progress{

width: 50px;

display: inline-block;

margin-top: -5px;

}

.pie_progress.profile{

width: 80px;

/*display: inline-block;*/

}

.pie_progress.profile img{

margin: 8px;

}

.headerImg{

width:40px;

height: 40px;

}

.pie_progress__content img {

max-width: 100%;

}

.template-upload, .template-download

{

float:left;

}
.faculty-btn{
	background-color: #62aeef;
}
.faculty-btn:focus,.faculty-btn:hover{
	background-color: #337AB7;
	border:1px solid #337AB7 !important;
}

.my-project-note{
	background-color: #d7d7d7;
	    border: 1px solid #ccc;
	    border-radius: 6px;
	    margin-left: -20px;
	    padding: 8px;
}
.sitch-center{
	left: 6%;
}

</style>

<script src="<?php echo base_url();?>assets/js/jquery.js"></script>

     <!-- Global site tag (gtag.js) - Google Analytics -->
<script async
src="https://www.googletagmanager.com/gtag/js?id=UA-128587876-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128587876-1');
</script>
</head>


<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1568131759954933",
    enable_page_level_ads: true
  });
</script>


<?php if($this->uri->segment(1)=='payment') { ?>

<body onload="submitPayuForm()">

<?php }else{ ?>

<body>

<?php } ?>

<script>

	var base_url="<?php echo base_url();?>";
	var file_upload_base_url="<?php echo file_upload_base_url();?>";

</script>

<!-- <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92884469-1', 'auto');
  ga('send', 'pageview');

</script> -->

<?php

if($this->uri->segment(1)=='' || $this->uri->segment(1)=='home')

{

?>

<style>

.middle{

min-height: auto;

}

</style>

<?php }?>

<!-- Navigation -->

<nav class="navbar navbar-inverse navbar-fixed-top">

<div class="container-fluid">

<!-- Brand and toggle get grouped for better mobile display -->

<div class="navbar-header">

<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

<span class="sr-only">

Toggle navigation

</span>

<span class="icon-bar">

</span>

<span class="icon-bar">

</span>

<span class="icon-bar">

</span>

</button>

<!-- <a class="navbar-brand" href="<?php echo base_url()?>">

<img src="<?php echo base_url();?>assets/images/logo.png" alt="logo" title="Home" style="width: 241px; margin-left: 10px;margin-top: 10px;">

</a> -->


<?php if($this->session->userdata('front_user_id') !='' && $this->session->userdata('front_user_id') > 0 ){ ?>

	<?php if( $this->session->userdata('userProfileComplete') == FALSE) { ?>
		<a class="navbar-brand" href="<?php echo base_url()?>">
		<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 241px; margin-left: 10px;margin-top: 10px;">
		</a>
	<?php }  else if( $this->session->userdata('guest_user') && $this->session->userdata('guest_user') == 'guest_user') { ?>
		<a class="navbar-brand" href="<?php echo base_url()?>">
		<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 241px; margin-left: 10px;margin-top: 10px;">
		</a>
	<?php } else { ?>
		<a class="navbar-brand" href="<?php echo base_url()?>home">
<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 241px; margin-left: 10px;margin-top: 10px;">
</a>
<?php } }else { ?>
	<a class="navbar-brand" href="<?php echo base_url()?>">
	<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 241px; margin-left: 10px;margin-top: 10px;">
	</a>

	<?php } ?>

</div>

<style>

#notificationContainer .showcase #content-2.content44

{

height: 275px;

}

</style>

<!-- Collect the nav links, forms, and other content for toggling -->

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav">



<?php

if($this->session->userdata('front_user_id') == '' || $this->session->userdata('front_is_logged_in'==''))
{


}

else

{

$this->CI =& get_instance();

$this->CI->load->model('model_basic');

$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));

$profileImage          = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"profileImage"," `id` = '".$FRONT_USER_SESSION_ID."'");

$firstName             = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"firstName"," `id` = '".$FRONT_USER_SESSION_ID."'");

?>
<li class="pull-right">
	<ul>
		
		<li class="notification dropdown">
		<?php
		$CI=& get_instance();
		$count=$CI->model_basic->getCountWhere('header_notification_user_relation',array('user_id'=>$this->session->userdata('front_user_id'),'status'=>0));
		//echo $this->db->last_query();

		$notifications=$CI->model_basic->getAllNotificationData();
		//echo $this->db->last_query();
		?>
			<a href="javascript:void(0)" id="notificationLink" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
				<i class="fa fa-bell"></i>
				<span <?php if($count > 0){ echo 'class="badge"';}?> id="notification_count"><?php if($count > 0){ echo $count;}?></span>
			</a>
			<div class="notification_container arrow_box_notify dropdown-menu" id="notificationContainer">
				<div class="showcase">
					<div id="content-2" class="content44 mCustomScrollbar light" data-mcs-theme="minimal-dark">
					<?php if(!empty($notifications)){ foreach($notifications as $notification){ ?>
						<a href="<?php echo base_url();?><?php echo $notification['link'];?>"  <?php if($notification['status']== 0){ echo 'class="active"';} ?>>
							<div class="media">
								<div class="media-left media-top">
									<img class="media-object notify-img" src="<?php echo file_upload_base_url()?><?php echo $notification['imageLink'];?>" alt="">
								</div>
								<div class="media-body">
									<h4 class="media-heading"><?php echo $notification['title'];?></h4>
									<span><?php echo date('M d, H:i',strtotime($notification['created'])); ?></span>
									<p><?php echo $notification['msg'];?></p>
								</div>
							</div>
						</a>
						<?php } } ?>
					</div>
				</div>
			</div>
		</li>

<li class="loger_info dropdown">
<a href="<?php echo base_url();?>profile">




<div class="pie_progress" role="progressbar" data-goal="<?php echo $this->session->userdata('profile_meter');?>" data-speed="20" data-barcolor="#00B4FF" data-barsize="14" aria-valuemin="0" aria-valuemax="100" data-trackcolor="#FF9A2D">

<div class="pie_progress__content">

<?php

if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)

{

?>

<img id="profileImage" class="img-circle headerImg" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>" title="Profile Completion"/>

<?php

}

else

{

?>

<img id="profileImage" class="img-circle headerImg" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />

<?php

}?>

</div></div>
</a>
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
&nbsp;&nbsp;&nbsp; Welcome <?php echo $firstName;?>  &nbsp;

<i class="fa fa-angle-down">

</i>

</a>

<ul class="dropdown-menu arrow_box animated flipInX delay-03s">

<?php

	if($this->session->userdata('user_admin_level') == 4 || $this->session->userdata('user_admin_level') == 1 || $this->session->userdata('user_admin_level') == 5 || $this->session->userdata('user_admin_level') == 6)
	{  ?>

		<li>
			<a href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">All Institute Data</a>
		</li>

	<?php } else {

	$ci= &get_instance();
	$ci->load->model('user_model');
	$admin_data = $ci->user_model->check_admin_or_not();
	if(!empty($admin_data))
	{
	?>
	<!-- <h4>
	<a href="#flag_status" class="scroll">
		Monitor Flag
	</a>
	</h4> -->
	<li>
		<a href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($admin_data[0]['pageName']));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">Manage Institute Data</a>
	</li>

<?php }   } ?>



<li>

<a href="<?php echo base_url();?>stream">

My Stream

</a>

</li>

<li>

<a href="<?php echo base_url();?>myboard">

My Board

</a>

</li>

<li>

<a href="<?php echo base_url();?>profile">

My Portfolio

</a>

</li>

<li>

<a href="<?php echo base_url();?>project/manage_projects">

Manage Projects

</a>

</li>

<li>

<a href="<?php echo base_url();?>profile/edit_profile">

My Profile

</a>

</li>

<?php if(($this->session->userdata('user_institute_id')!='') || ($this->session->userdata('user_institute_id')!=0)){ ?>

<li>

<a href="<?php echo base_url().'assignment'?>">

Assignment

</a>

</li>

<?php }  ?>

<li>

<a href="<?php echo base_url();?>hauth/arenalogout">

Logout

</a>

</li>

</ul>

</li>

</ul>



</li>

<?php

}?>

</ul>

</div>

<!-- /.navbar-collapse -->

</div>

<!-- /.container -->

<input type="hidden" id="base_url" value="<?php echo base_url();?>" />

</nav>

<div class="discover">

<div class="container-fluid">

<div class="row">

<div class="col-lg-12">

<div class="panel panel-default collapse"  id="discover">

<div class="col-md-12">

<a id="hide" class="close" href="#" data-dismiss="panel" aria-label="close">×</a>

</div>

<!--<div class="panel-heading">

<button type="button" class="close" data-target="#discover" data-dismiss="panel" aria-label="Close"><span aria-hidden="true">&times;</span></button>

<a href="#" class="close" data-dismiss="panel" aria-label="close" id="hide">&times;</a>

<h3>Search :</h3>

</div>-->

<div class="panel-body">

<form action="javascript:void('0');">

<div class="col-lg-2">

<!--   <section>

<div class="wrapper-demo">

<div id="dd" class="wrapper-dropdown-3" tabindex="1">

<span id="adv_pro_peo_selected"><?php

if($this->session->flashdata('adv_search_for')=='Project')

{

echo 'Project';

}

elseif($this->session->flashdata('adv_search_for')=='People')

{

echo 'People';

}

else

{

echo 'Search For';

} ?></span>

<ul class="dropdown my_ul" id="adv_pro_peo">

<li><a>People</a></li>

<li><a>Project</a></li>

</ul>

</div>

​</div>

</section> -->

<div class="btn-group">

<button  id="adv_pro_peo_selected" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?php

if($this->session->flashdata('adv_search_for')=='Project')

{

echo 'Project';

}

elseif($this->session->flashdata('adv_search_for')=='People')

{
if($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0){
echo 'People';
}
}

else

{

echo 'Search For';

} ?><span class="caret"></span></button>

<ul class="dropdown-menu" id="adv_pro_peo">
<?php
if($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0){ ?>
<li><a>People</a></li>
<?php } ?>
<li><a>Project</a></li>

</ul>

</div>

</div>

<div class="col-lg-2">

<?php

$ci= &get_instance();

$ci->load->model('home_model');

$cat = $ci->home_model->get_all_category();

?>

<!--    <section>

<div class="wrapper-demo">

<div id="dd2" class="wrapper-dropdown-3" tabindex="1">

<span id="adv_category_selected" data-id="<?php  if($this->session->userdata('adv_category_id')){echo $this->session->userdata('adv_category_id');} ?>" class="be-dropdown-content"><?php if($this->session->flashdata('adv_category'))

{

echo $this->session->flashdata('adv_category');

}

else

{

echo  'Category';

}?></span>

<ul id="category_list" class="dropdown my_ul">

<?php

if(!empty($cat))

{

foreach($cat as $row)

{

?>

<li><a data-id="<?php echo $row['id'];?>"><?php echo $row['categoryName'];?></a></li>

<?php  }

} ?>

</ul>

</div>

​</div>

</section>-->

<div class="btn-group">

<button  id="adv_category_selected" data-toggle="dropdown" data-id="<?php  if($this->session->userdata('adv_category_id')){echo $this->session->userdata('adv_category_id');} ?>" class="btn btn-default dropdown-toggle"><?php if($this->session->flashdata('adv_category'))

{

echo $this->session->flashdata('adv_category');

}

else

{

echo  'Category';

}?><span class="caret"></span></button>

<ul class="dropdown-menu" id="category_list">

<?php     if(!empty($cat))

{

foreach($cat as $row)

{	 ?>

<li><a data-id="<?php echo $row['id'];?>"><?php echo $row['categoryName'];?></a></li>

<?php  }

} ?>

</ul>

</div>

</div>

<div class="col-lg-2">

<?php

$ci= &get_instance();

$ci->load->model('home_model');

$attri = $ci->home_model->get_all_attribute();

?>

<div class="btn-group">

<button  id="adv_attribute_selected" data-toggle="dropdown" data-id="<?php  if($this->session->userdata('adv_attribute_id')){echo $this->session->userdata('adv_attribute_id');} ?>" class="btn btn-default dropdown-toggle"><?php

if($this->session->flashdata('adv_attribute'))

{

echo $this->session->flashdata('adv_attribute');

}

else {?>Attribute<?php } ?><span class="caret"></span></button>

<ul class="dropdown-menu" id="adv_attribute_list" >

<?php

if(!empty($attri))

{

foreach($attri as $row)

{

$ci= &get_instance();

$ci->load->model('model_basic');

$attriributeValueCount = $ci->model_basic->getCount('attribute_value_master','attributeId',$row['id']);

if($attriributeValueCount != 0)

{ ?>

<li><a data-id="<?php echo $row['id'];?>"><?php echo $row['attributeName'];?></a></li>

<?php } }

} ?>

</ul>

</div>

</div>

<div class="col-lg-2">


<div class="btn-group">

<button  id="adv_attri_value_selected" data-toggle="dropdown" data-id="<?php if($this->session->userdata('adv_attri_value_id')){echo $this->session->userdata('adv_attri_value_id');} ?>" class="btn btn-default dropdown-toggle"><?php

if($this->session->userdata('adv_attri_value_id'))

{

$attri_val_info = $ci->home_model->get_attribute_value_detail($this->session->userdata('adv_attri_value_id'));

if(!empty($attri_val_info))

{

echo $attri_val_info[0]['attributeValue'];

}

}

else {?>Attribute Value<?php } ?><span class="caret"></span></button>

<ul class="dropdown-menu" id="adv_attri_value_list" >

<?php  if($this->session->userdata('adv_attribute_id'))

{

$attri_val = $ci->home_model->get_attribute_value($this->session->userdata('adv_attribute_id'));

if(!empty($attri_val))

{

foreach($attri_val as $row)

{?>

<li><a data-id="<?php echo $row['id'];?>" data-name="<?php echo $row['attributeValue'];?>"><?php echo $row['attributeValue'];?></a></li>

<?php }

}

}

?>

</ul>

</div>

</div>

<div class="col-lg-2">

<!--      <section>

<div class="wrapper-demo">

<div id="dd5" class="wrapper-dropdown-3" tabindex="1">

<span id="adv_rating_selected" class="be-dropdown-content"><?php

if($this->session->userdata('adv_rating'))

{

echo $this->session->userdata('adv_rating');

}

else

{

echo  'Rating';

}?></span>

<ul class="dropdown my_ul" id="adv_rating_list">

<li><a>0</a></li>

<li><a>1</a></li>

<li><a>1+</a></li>

<li><a>2</a></li>

<li><a>2+</a></li>

<li><a>3</a></li>

<li><a>3+</a></li>

<li><a>4</a></li>

<li><a>4+</a></li>

<li><a>5</a></li>

</ul>

</div>

​</div>

</section> -->

<div class="btn-group">

<button  id="adv_rating_selected" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?php   if($this->session->userdata('adv_rating'))					{	echo $this->session->userdata('adv_rating');

}

else

{  echo 'Rating';

}?><span class="caret"></span></button>

<ul class="dropdown-menu" id="adv_rating_list" >

<li><a>0</a></li>

<li><a>1</a></li>

<li><a>1+</a></li>

<li><a>2</a></li>

<li><a>2+</a></li>

<li><a>3</a></li>

<li><a>3+</a></li>

<li><a>4</a></li>

<li><a>4+</a></li>

<li><a>5</a></li>

</ul>

</div>

</div>

<div class="col-lg-2">

<button id="adv_search" class="btn btn-default" style="width:100%">Search</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="modal fade" id="myInstituteModal" role="dialog">

<div class="modal-dialog">

<!-- Modal content-->

<form id="myForm" method="post" action="" onsubmit="return checkStudentId();" style="text-align: center;">

<div class="modal-content">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title" style="font-size: 15px;font-weight: bold">Login using Student ID</h4>

</div>

<div class="modal-body">

<p style="text-align: left;margin-left: 90px">Enter Your Student ID.</p>

<div class="form-group">

<input style="border:1px solid #3cafdf;width:300px;" class="form-control" id="studentId" type="text" name="studentId">  <button type="submit" class="btn btn-primary">Submit</button>

</div>

<span class="text-danger"></span>

</div>

<!--       <div class="modal-footer">

</div> -->

</div>

</form>

</div>

</div>

<?php

if($this->session->userdata('front_user_id') != '')

{
$ci =& get_instance();
$ci->load->model('user_model');
$googleSetting = $ci->user_model->getUserGoogleSetting();

if(!empty($googleSetting)){

?>

<div class="modal fade" id="googleDriveSetting" role="dialog">

<div class="modal-dialog">

<!-- Modal content-->

<form  method="post" action="">

<div class="modal-content">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Google Drive Setting</h4>

<h5 class="errorMsg"></h5>

</div>

<div class="modal-body">

<div class="form-group">

<label class="radio-inline">

<input type="radio" name="driveSetting" class="driveSetting" value="1" <?php if($googleSetting['google_drive_setting']==1){ echo "checked";} ?>><label>ON</label>

</label>

<label class="radio-inline">

<input type="radio" name="driveSetting" class="driveSetting" value="0" <?php if($googleSetting['google_drive_setting']!=1){ echo "checked";} ?>><label>OFF</label>

</label>

</div>

<span class="text-danger"></span>

</div>

<div class="modal-body" id="moveDataSetting" >

<div class="form-group">

<h4 class="modal-title">Move your old data to your google drive?</h4>

<label class="radio-inline">

<input type="radio" name="moveToDrive" class="moveToDrive" value="1"><label>YES</label>

</label>

<label class="radio-inline">

<input type="radio" name="moveToDrive" class="moveToDrive" value="0"  checked><label>NO</label>

</label>

</div>

<span class="text-danger"></span>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

<!-- <button type="submit" class="btn btn-primary" id="settingBtn">Submit</button> -->

</div>

</div>

</form>

</div>

</div>

<?php }

}

?>
<div id="cookiesModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Cookies Required</h4>
      </div>
      <div class="modal-body">

        <p>Cookies are not enabled on your browser. Please enable cookies in your browser preferences to continue.</p>
      </div>

    </div>

  </div>
</div>
<div class="modal fade modal-success" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-body modalWarning">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        	<span aria-hidden="true">&times;</span>
	        </button>
	        <?php if($this->session->userdata('blockUser') ==1){?> Your evaluation period is over. Please contact your institute admin for more details.<?php } ?>
	        <?php if($this->session->userdata('blockUser') ==2){?> Your subscription period is over. Please contact creosouls support for more details.<br/>+91 738773 0642<?php } ?>
	        <?php if($this->session->userdata('blockUser') ==3){
	        	$correctEmail=$this->session->userdata('correctEmail');
	        	$this->session->unset_userdata('correctEmail');
	        	$correctEmailParts=explode('@',$correctEmail);
	        	//print_r($correctEmailParts);
	        	$emailLength=strlen($correctEmailParts[0]);
	        	if($emailLength >= 8)
	        	{
	        		$newstring = substr($correctEmailParts[0], -4);
	        	}
	        	elseif($emailLength < 8 && $emailLength >=5)
	        	{
	        		$newstring = substr($correctEmailParts[0], -3);
	        	}
	        	else
	        	{
	        		$newstring = substr($correctEmailParts[0], -2);
	        	}
	        	?> Correct email associated with inserted student id is ****<?php echo $newstring;?>@<?php echo $correctEmailParts[1];}?>
	        	<?php if($this->session->userdata('blockUser') ==4){?> Please Log in using your StudentId.<?php } ?>
	        	<?php if($this->session->userdata('blockUser') ==5){?> Please try again.<?php } ?>
        </div>
    </div>
</div>
