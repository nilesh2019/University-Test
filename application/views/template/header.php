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

<meta charset="UTF-8" /><meta property="og:site_name" content="university" /><meta property="og:locale" content="en_US" />

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

if(pathinfo($filename, PATHINFO_EXTENSION)!='pdf') 
{

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
	<meta property="og:site_name" content="university" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:url" content="<?php echo base_url();?>" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="university" />
	<meta property="og:description" content="Unleash your creativity with University, University an online Portfolio Management and Social Networking platform for Creative People including Job opportunities under single roof." />
	<meta property="og:image" content="<?php echo base_url();?>assets/CreonowBanner.jpg" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/ucsf_favicon.png">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

University

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
/* body.modal-open{
  overflow: hidden;
}
.myBdcrm>li+li:last-child:before{
  content:none;
}
.modal-backdrop{
   backdrop-filter: blur(5px);
   background-color: #01223770;
}
.modal-backdrop.in{
   opacity: 1 !important;
} */
body.modal-open{
  overflow: hidden;
}
#myModalForDetailProject .modal-dialog {
	width: 100%;
	height: 100%;
	margin: auto;
	padding: 0;
}
#myModalForDetailProject .modal-content {
	height: auto;
	min-height: 100%;
	border-radius: 0;
}
#myModalForDetailProjectIframe{
  width: 100vw;
  height: 100vh;
  margin: auto;
  /* height: calc(100vh + 72px); */
  border: none;
 /*  margin-top : -72px; */
}
.overlay-loader-wrapper {
  /* background: rgba(34, 55, 65, 0.59); */
  /*background: #7D898F;*/
  background: rgba(0,0,0, 0.59);
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 999999;
}

.overlay-loader {
  height: 100%;
  position: relative;
}
.overlay-loader__content {
  position: absolute;
  top: 50%;
  right: 50%;
  text-align: center;
  -ms-transform: translate(50%, -50%);
  -webkit-transform: translate(50%, -50%);
  transform: translate(50%, -50%);
  /*width: 65px;*/
}
.overlay-loader__block {
  background: #fff;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 0;
  height: 56px;
  margin: 0 auto;
  padding: 16px 12px;
  width: 56px;
}
.overlay-loader__block--inner {
  border-radius: 0;
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden;
  text-align: center;
  width: 100%;
}
.overlay-loader__line {
  background: #16C98D;
  border-radius: 2px;
  content: "";
  display: inline-block;
  height: 100%;
  position: relative;
  transform: translateY(100%);
  width: 5px;
}
.overlay-loader__line + .overlay-loader__line {
  margin-left: 7px;
}
.overlay-loader__line--first {
  animation: moveFirstLine 2s linear infinite;
}
.overlay-loader__line--second {
  animation: moveSecondLine 2s linear infinite;
}
.overlay-loader__line--last {
  animation: moveThirdLine 2s linear infinite;
}
.overlay-loader__text {
  animation: changeTextColor 2s linear infinite;
  display: inline-block;
  font-style: italic;
  font-size: 16px;
  margin-top: 12px;
}

@-moz-keyframes changeTextColor {
  0% {
    color: #f2f2f2;
  }
  50% {
    color: #c9c9c9;
  }
  100% {
    color: #f2f2f2;
  }
}
@-webkit-keyframes changeTextColor {
  0% {
    color: #f2f2f2;
  }
  50% {
    color: #c9c9c9;
  }
  100% {
    color: #f2f2f2;
  }
}
@keyframes changeTextColor {
  0% {
    color: #f2f2f2;
  }
  50% {
    color: #c9c9c9;
  }
  100% {
    color: #f2f2f2;
  }
}
@-moz-keyframes moveFirstLine {
  0% {
    transform: translateY(100%);
  }
  20% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@-webkit-keyframes moveFirstLine {
  0% {
    transform: translateY(100%);
  }
  20% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@keyframes moveFirstLine {
  0% {
    transform: translateY(100%);
  }
  20% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@-moz-keyframes moveSecondLine {
  0% {
    transform: translateY(100%);
  }
  30% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  60% {
    transform: translateY(0px);
  }
  80% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@-webkit-keyframes moveSecondLine {
  0% {
    transform: translateY(100%);
  }
  30% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  60% {
    transform: translateY(0px);
  }
  80% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@keyframes moveSecondLine {
  0% {
    transform: translateY(100%);
  }
  30% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  60% {
    transform: translateY(0px);
  }
  80% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@-moz-keyframes moveThirdLine {
  0% {
    transform: translateY(100%);
  }
  40% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(0px);
  }
  90% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@-webkit-keyframes moveThirdLine {
  0% {
    transform: translateY(100%);
  }
  40% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(0px);
  }
  90% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
@keyframes moveThirdLine {
  0% {
    transform: translateY(100%);
  }
  40% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(0px);
  }
  70% {
    transform: translateY(0px);
  }
  90% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
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
<!-- <script async
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
</script> -->


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

<nav class="navbar navbar-inverse navbar-fixed-top" id="myMainNav">

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
		<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 200px; margin-left: 10px;margin-top: 10px; margin-bottom: 10px;">
    </a>
	<?php }  else if( $this->session->userdata('guest_user') && $this->session->userdata('guest_user') == 'guest_user') { ?>
		<a class="navbar-brand" href="<?php echo base_url()?>">
		<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 200px; margin-left: 10px;margin-top: 10px; margin-bottom: 10px;">
		</a>
	<?php } else { ?>
		<a class="navbar-brand" href="<?php echo base_url()?>home">
<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 200px; margin-left: 10px;margin-top: 10px; margin-bottom: 10px;">
</a>
<?php } }else { ?>
	<a class="navbar-brand" href="<?php echo base_url()?>">
	<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 200px; margin-left: 10px;margin-top: 10px; margin-bottom: 10px;">
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

<li>

<a class="NoPaddingRight">Explore</a>

</li>

<li class="dropdown NoLeftMargin">

<a href="#" class="dropdown-toggle NoPaddingLeft" data-toggle="dropdown">

<i class="fa fa-angle-down"></i>

</a>

<ul class="dropdown-menu arrow_box animated flipInX delay-03s">

<li>

<a href="<?php echo base_url().'all_project'?>">

Creative Work

</a>

</li>
<?php
if($this->session->userdata('user_institute_id')!=0 || $this->session->userdata('user_admin_level')!=0){ ?>
	<li>
		<a href="<?php echo base_url().'institute/institute_list'?>"> Institutes </a>
	</li>
	<li>
		<a href="<?php echo base_url().'people'?>"> People </a>
	</li>
<?php }
?>
<li>

<a href="<?php echo base_url().'competition/competition_list'?>">

Competitions

</a>

</li>

<?php
//echo "asdasdasdasdd";
	if($this->session->userdata('front_user_id')!='' || $this->session->userdata('front_is_logged_in'!=''))
	{
		$falg=0;
		$this->CI =& get_instance();
		$this->CI->load->model('model_basic');
		$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		$ho_status = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"admin_level"," `id` = '".$FRONT_USER_SESSION_ID."'");
		$jury_status = $this->CI->model_basic->getValue($this->CI->db->dbprefix('creative_competition_jury_relation'),"userId"," `userId` = '".$FRONT_USER_SESSION_ID."'");
		if(isset($ho_status) && !empty($ho_status) && $ho_status=='4' || $ho_status=='2' || $ho_status=='1')
		{
			$flag=1;
		}
		if($ho_status=='0' && ($this->session->userdata('user_institute_id')==0))
		{
			$flag=1;
		}
		if($this->session->userdata('user_institute_id')!=0)
		{
			$flag=1;
		}
		if(isset($jury_status) && !empty($jury_status) && $jury_status==$FRONT_USER_SESSION_ID)
		{
			$flag=1;
		}
		if(isset($flag) && !empty($flag) && $flag=='1')
		{ ?>
				<li>
					<a href="<?php echo base_url().'creative_mind_competitions/competition_list'?>"> Creative Mind Competitions </a>
				</li>
		<?php }
	}
?>
<li>

<a href="<?php echo base_url().'event/event_list'?>">

Events

</a>

</li>

<li>

<a href="<?php echo base_url().'newsletter'?>">

Newsletters

</a>

</li>

</ul>

</li>

<li id="discoverLi">

<a id="discoverLia" data-toggle="collapse" href="#discover" aria-expanded="false" aria-controls="discover">Search</a>

</li>




<?php

$this->CI =& get_instance();

$this->CI->load->model('model_basic');

$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));

$job_status = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"job_status"," `id` = '".$FRONT_USER_SESSION_ID."'");

if($this->session->userdata('front_user_id') != '' || $this->session->userdata('front_is_logged_in'!='') )

{

if($job_status == 1)

{

?>

<li>

<a href="<?php echo base_url().'job'?>">

Jobs

</a>

</li>

<?php

}
else
{
	if($this->session->userdata('user_type') == 2)

	{

	?>

	<li>

	<a href="<?php echo base_url().'job'?>">

	Jobs

	</a>

	</li>

	<?php

	}
}


}

?>
<?php

if($this->session->userdata('front_user_id') != '' || $this->session->userdata('front_is_logged_in'!=''))

{

$this->CI =& get_instance();

$this->CI->load->model('project_model');

$projectCategory = $this->CI->project_model->getProjectCategory();

if($this->session->userdata('user_type') && $this->session->userdata('user_type')!='')

{

$type = $this->session->userdata('user_type');

$instituteOrCollage = '';

if($type=='1')

{

$manageLink = urlencode(base64_encode($this->session->userdata('user_institute_name'))).'/'.urlencode(base64_encode($this->session->userdata('front_user_id')));

}

elseif($type=='2'){

$manageLink = urlencode(base64_encode($this->session->userdata('user_company_name'))).'/'.urlencode(base64_encode($this->session->userdata('front_user_id'))).'/'.urlencode(base64_encode($this->session->userdata('user_type')));

}

if($type=='2'){

?>

<li class="dropdown NoLeftMargin">

<a href="#" class="dropdown-toggle NoPaddingLeft" data-toggle="dropdown">

<i class="fa fa-angle-down"></i>

</a>

<ul class="dropdown-menu arrow_box">

<li>

<a href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo $manageLink;?>">

Post Jobs

</a>

</li>

</ul>

</li>

<?php  } } ?>

<li class="dropdown add_project">
<button  id="add_project_button" <?php  if($this->uri->segment(1) == 'project' && $this->uri->segment(2) == 'edit_project'){ echo 'disabled="disable"';}?>>
Add Projects
</button>

<?php if(($this->session->userdata('user_admin_level')!= 2) && ($this->session->userdata('teachers_status')!= 1)&& ($this->session->userdata('user_institute_id')!='') && ($this->session->userdata('user_institute_id')!=0)){ ?>

<div class="panel panel-default AddProject dropdown-menu">

<div class="panel-heading">

<h3 class="panel-title">

Add Projects

</h3>

</div>

<div class="panel-body">

<form class="form-horizontal"  method="post" action="javascript:void(0);" id="fileupload">

<div class="showcase">

<div id="content-2" class="content44 mCustomScrollbar light" data-mcs-theme="minimal-dark">

<div class="col-lg-6">

<div class="">

<div class="input-col col-xs-12 col-sm-12" style="margin-top: 10px;">

<div class="form-group">

<span class="note1">(<b>Note</b> : Only jpg, png, jpeg file types are allowed & Maximum 3 MB file is allowed with maximum resolution 2048 X 2048. Allowed GIF file dimensions 800 X 600 and allowed size upto 2MB.)
</span><span style="color:red">*</span>

<div class="drag_here">

<div class="input-col col-xs-12 col-sm-12 fileupload-buttonbar">

<span class="my_file  fileinput-button">

<!--<i class="glyphicon glyphicon-plus">

</i>-->

<i class="fa fa-folder-o"></i>

<span>Drag and Drop files here or Click to browse to upload images here</span>

<input type="file" name="userfile" id="userfile" multiple accept=".gif,.jpg,.jpeg,.png,">

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

position: relative;

float: right;

border-radius: 50% ;

top: 0px;

padding: 2px 7px !important;

}

.mCS_img_loaded{ margin-top:-14px;}

#show_all_images

{

/*overflow-x: scroll;*/

border: 2px dashed #626262;

background: #242424;

max-width:100%;

}

.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {

width: 111px;

display: table-cell;

}

.bunch {

width:104px;

}

</style>

<span id="ImageError" class="error_text"></span>

<div class="col-lg-12 fileupload-progress fade">

<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">

<div class="progress-bar progress-bar-success" style="width:0%;">

</div>

</div>

<div class="progress-extended">

&nbsp;

</div>

</div>

<div class="form-group">

<div class="row">

<div class="col-lg-12">

<div id="show_all_images" class="hide">

<div class="table-responsive">

<table role="presentation" class="table">

<tbody>

<tr class="files" style="background: none !important;">

</tr>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>
<span id="CoverImageError" class="error_text"></span>
</div>
<div class="form-group" id="videoLinkDiv">

<label class="col-sm-4 control-label">YouTube Video Link</label><div class="col-sm-8"><input type="text" name="videoLink" id="videoLink" class="form-control" placeholder="YouTube Video Link"><span class="error_text" id="videoLinkError"></span></div>

</div>
<div id="attri_div">

</div>



</div>

</div>

<div class="col-lg-6">

<div class="option">

<label class="radio-inline">

<input type="radio" name="RadioOptionsForAdd" id="quick_add" value="option1" checked="checked"> Quick Add

</label>

<label class="radio-inline">

<input type="radio" name="RadioOptionsForAdd" id="full_add" value="option2"> Add Full Details

</label>

</div>

<div class="quick_add">

<div class="form-group">

<label class="col-sm-4 control-label">

Project Name<span style="color:red">*</span>

</label>

<div class="col-sm-8">

<input type="text" class="form-control" id="projectName" name="projectName" placeholder="Type Project Name">

<span class="error_text" id="projectNameError">

</span>

</div>

</div>
<div class="form-group">

<label class="col-sm-4 control-label">

Is Team ?

</label>

<div class="col-sm-8">

<div class="checkbox-inline">

<label>

<input type="checkbox" class="team" name="team" id="team" value="1" onclick="showInputMember()"> Yes

</label>

</div>

</div>

</div>
<script type="text/javascript">
	function showInputMember(){
		var checkBox = document.getElementById("team");
		  var teamMember = document.getElementById("projectTeam");
		  if (checkBox.checked == true){
		    teamMember.style.display = "block";
		  } else {
		     teamMember.style.display = "none";
		  }
	}
</script>
<div class="form-group" id="projectTeam" name="projectTeam" style="display:none">

<label class="col-sm-4 control-label">

Team Members

</label>

<div class="col-sm-8">

<textarea class="form-control" id="projectTeamMem" name="projectTeamMem" placeholder="Add member name">

</textarea>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Category<span style="color:red">*</span>

</label>

<div class="col-sm-8">

<select id="project_category" name="project_category" class="form-control" >

<option value="">

Select Project Category

</option>

<?php

if(!empty($projectCategory))

{

foreach($projectCategory as $cat)

{

?>

<option value="<?php echo $cat['id']?>">

<?php echo $cat['categoryName']?>

</option>

<?php

} // set_select('category_name', $cat['id']);

}?>

</select>

<span class="error_text" id="project_categoryError">

</span>

</div>

</div>
<div class="form-group">

<label class="col-sm-4 control-label">

Work/Project Files Link

</label>

<div class="col-sm-8">
<input type="text" class="form-control" id="projectFileLink" name="projectFileLink" placeholder="Add File Link">
<span>
	Note: Add G-Drive, WeTransfer, FileShare, Zippyshare Link.
</span>
<span class="error_text" id="project_categoryError">
</span>

</div>

</div>
<div class="form-group">

<label class="col-sm-4 control-label">

Type

</label>

<div class="col-sm-8">

<label class="radio-inline">

<input type="radio" class="projectType" checked="checked" name="projectType"  value="Academic"> Academic

</label>

<label class="radio-inline">

<input type="radio" class="projectType" name="projectType" value="Professional"> Professional

</label>

<span class="error_text" id="projectTypeError">

</span>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Project Status

</label>

<div class="col-sm-8">

<label class="radio-inline">

<input type="radio" class="projectStatus" checked="checked" name="projectStatus" value="1"> Completed

</label>

<label class="radio-inline">

<input type="radio" class="projectStatus" name="projectStatus" value="0"> Work in Progress

</label>

<span class="error_text" id="projectStatusError">

</span>

</div>

</div>
<div class="form-group">

<label class="col-sm-4 control-label">

Is this your showreel ?

</label>

<div class="col-sm-8">

<div class="checkbox-inline">

<label>

<input type="checkbox" class="showreel" name="showreel" value="1"> Yes

</label>

</div>

</div>

</div>


</div>



<div class="full_add hide">

<div class="form-group">

<label class="col-sm-4 control-label">

Social Features

</label>

<div class="col-sm-8">

<label class="radio-inline">

<input type="radio" class="socialFeatures" checked="checked" value="1"  name="socialFeatures"> Yes

</label>

<label class="radio-inline">

<input type="radio" class="socialFeatures" name="socialFeatures" value="0"> No

</label>

<span class="error_text" id="socialFeaturesError">

</span>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Watermark on Image

</label>

<div class="col-sm-8">

<div class="checkbox-inline">

<label>

<input id="check_watermark" name="check_watermark" type="checkbox" value="" >(check if you want watermark on image)

</label>
<div class="my-project-note">
	Note: Watermark can not be edited once submit the project.
</div>
</div>

</div>

</div>

<div class="watermark hide">

<div class="form-group">

<label class="col-sm-4 control-label">

Watermark text Color

</label>

<div class="col-sm-8">

<input type="text" class="form-control demo " id="hue-demo" name="watermark_color"  data-control="hue" value="#fff">

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Watermark on Text

</label>

<div class="col-sm-8">

<input type="text" id="watermark_text" name="watermark_text" class="form-control" placeholder="Watermark Text" maxlength="35">

</div>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Description

</label>

<div class="col-sm-8">

<textarea class="form-control" id="basicInfo" name="basicInfo" placeholder="Type Description/Project background here">

</textarea>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Thought Process

</label>

<div class="col-sm-8">

<textarea class="form-control" id="thought" name="thought" placeholder="Talk about your thought process">

</textarea>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Add keywords

</label>

<div class="col-sm-8">

<textarea name="keyword" id="keyword">

</textarea>

</div>

</div>

<div class="form-group">

<label class="col-sm-4 control-label">

Copyright Settings?

</label>

<div class="col-sm-8">

<label class="radio-inline">

<input type="radio" checked="checked"  name="copyright" value="0"> Creative Commons (CC) Licence

</label>

<br />

<label class="radio-inline">

<input type="radio" name="copyright" value="1"> Requires Permission

</label>

</div>

</div>

<div class="form-group copyright_text hide">

<label class="col-sm-12 control-label note">

By selecting this option, you are choosing not to allow any posting/use of your work without your permission.

</label>

</div>

</div>

</div>
<input type="hidden" id="submit_value" name="submit_value" value="" />
<input type="hidden" id="Save_Competition_Id" name="Save_Competition_Id" value="" />
<input type="hidden" name="Save_Assignment_Id" id="Save_Assignment_Id" value="" />
<input type="hidden" name="Save_interview_Assignment_Id" id="Save_interview_Assignment_Id" value="" />
</div>

</div>

<div class="col-lg-12">

<div class="buttons">

<div class="pull-right">

<a href="javascript:void(0)" id="cancel_add"  class="btn btn_blue">Cancel</a>
<button type="submit" name="Draft" value="Draft" id="draftProject" class="add_pro btn btn_blue">Draft</button>
<button type="submit" name="Publish" value="Publish" id="publishProject" class="add_pro btn btn_orange">Publish</button>
<button type="submit" name="Private" value="Private" id="privateProject" class="add_pro btn btn_blue">Private</button>
</div>

</div>

</div>

</form>

</div>

</div>

<?php }else{ ?>

<div class="panel panel-default AddProject dropdown-menu" id="addProjectMsg">

<div class="panel-heading">

<h3 class="panel-title">

Add Projects

</h3>

</div>

<div class="panel-body">

<h4 style="color:#5E5E5E;margin-left:10px;">Only students from registered institutes can add projects in university. If you are a student then please contact your Institute Admin.</h4>

</div>

</div>

<?php	} ?>

</li>

<?php

}

?>

<li>
    <a href="<?php echo base_url()?>resource/live">
      Creo Live!
    </a>
</li>&nbsp;&nbsp;&nbsp;

<li class="dropdown NoLeftMargin">

<a href="#" class="dropdown-toggle " data-toggle="dropdown">Learn

<i class="fa fa-angle-down"></i>

</a>

<ul class="dropdown-menu arrow_box animated flipInX delay-03s">

<?php if($this->session->userdata('front_user_id') != '' || $this->session->userdata('front_is_logged_in'!='') )
{
?>
<li>

<a href="<?php echo base_url().'sso/AssesmentLogin'?>" target="_blank">
<!--<a href="https://assessments.creonow.com/creonow/">-->

Assessments

</a>

</li>
<li>
<a href="<?php echo base_url().'sso/TrainingLogin'?>" target="_blank">

Trainings

</a>

</li>
<?php } else{ ?>
<li>

<a href="<?php echo base_url();?>my_default/index/assessments" target="_blank">

Assessments

</a>

</li>
<li>
<a href="<?php echo base_url();?>my_default/index/training" target="_blank">

Trainings

</a>

</li>
<?php } ?>


</ul>

</li>

<li id="help">

<a href="<?php echo base_url();?>home/help">Help</a>

</li>
<!--
<li id="help">

<a href="<?php echo base_url();?>quiz/get_quiz">Quiz</a>

</li> -->


<?php

if($this->session->userdata('front_user_id') == '' || $this->session->userdata('front_is_logged_in')==''){
  

?>

<li class="pull-right">

<ul>

<!--<li class="img-playStore">

<a href="https://play.google.com/store/apps/details?id=com.creonow.user&hl=en&utm_source=global_co&utm_medium=prtnr&utm_content=Mar2515&utm_campaign=PartBadge&pcampaignid=MKT-AC-global-none-all-co-pr-py-PartBadges-Oct1515-1" target="_blank" title="Download App">

<img src="<?php //echo base_url()?>assets/images/play_app.png"/>

</a>

</li>-->

<li>

<a href="#" data-toggle="modal" data-target="#myInstituteModal">

<div class="btn-group">

<button type="button" class="btn btn-info sign-up-btn" style="border-right: 2px solid rgb(19, 156, 231); padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="image" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-info sign-up-btn">Student Login</button>



</div>

</a>

</li>

<li>

<a href="<?php echo base_url();?>hauth/googleLogin">

<div class="btn-group">

<button type="button" class="btn btn-primary sign-in-btn faculty-btn" style="border-right: 2px solid #337AB7 !important; padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="image" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-primary sign-in-btn faculty-btn">Faculty Login</button>



</div>



</a>

</li>
<li>

<a href="<?php echo base_url();?>hauth/googleLogin">

<div class="btn-group">

<button type="button" class="btn btn-danger sign-in-btn" style="border-right: 2px solid #C9302C; padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="image" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-danger sign-in-btn">Guest Login</button>



</div>



</a>

</li>

</ul></li>

<?php
}
?>

<?php

if($this->session->userdata('front_user_id') != '' || $this->session->userdata('front_is_logged_in')!=''){

$CI=& get_instance();
$this->CI->load->model('login_model');
$IsGustUser=$CI->login_model->check_user_institute($this->session->userdata('front_user_id'));
			if(empty($IsGustUser))
			{   ?>

				<li class="">
					<ul>
						<li class="img-playStore">
							<a href="<?php echo base_url();?>hauth/center_name/2">
								<div class="btn-group sitch-center">
									<button type="button" class="btn btn-info sign-up-btn">GoTo MAAC</button>
								</div>
							</a>
						</li>
					</ul>
				</li>

<?php	}   }	?>

<?php

if($this->session->userdata('front_user_id') == '' || $this->session->userdata('front_is_logged_in')=='')
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
		<!--<li class="img-playStore">
			<a href="https://play.google.com/store/apps/details?id=com.creonow.user&hl=en&utm_source=global_co&utm_medium=prtnr&utm_content=Mar2515&utm_campaign=PartBadge&pcampaignid=MKT-AC-global-none-all-co-pr-py-PartBadges-Oct1515-1" target="_blank" title="Download App">
				<img  src="<?php //echo base_url()?>assets/images/play_app.png"/>
			</a>
		</li>-->
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
									<img class="media-object notify-img" src="<?php echo file_upload_base_url()?><?php echo $notification['imageLink'];?>" alt="image">
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

<img id="profileImage" class="img-circle headerImg" alt="image" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>" title="Profile Completion"/>

<?php

}

else

{

?>

<img id="profileImage" alt="image" class="img-circle headerImg" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />

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
   // echo "<pre>";print_r($this->session->all_userdata());exit();
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

<?php if(($this->session->userdata('user_admin_level')== 2) || ($this->session->userdata('teachers_status')== 1)&& ($this->session->userdata('user_institute_id')!='') && ($this->session->userdata('user_institute_id')!=0)){ ?>

<li>

<a href="<?php echo base_url();?>project/approve_pending_projects">

Manage Pending Projects

</a>

</li>
<?php }?>

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

<a href="<?php echo base_url();?>hauth/logout">

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
	        <?php if($this->session->userdata('blockUser') ==2){?> Your subscription period is over. Please contact university support for more details.<br/>+91 738773 0642<?php } ?>
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



