<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">

<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="">

<meta name="author" content="">

-->


  <meta charset="UTF-8" />
  <meta property="og:site_name" content="university" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:url" content="<?php echo base_url();?>" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="university" />
  <meta property="og:description" content="Unleash your creativity with university, university an online Portfolio Management and Social Networking platform for Creative People including Job opportunities under single roof." />
  <meta property="og:image" content="<?php echo base_url();?>assets/CreonowBanner.jpg" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- <link rel="shortcut icon" href="<?php //echo base_url();?>assets/img/favicon.png"> -->
<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/ucsf_favicon.png">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

University

</title>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.minicolors.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />


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

.newGuestloginModal img{
  border: 2px solid #d1d1d1;
padding: 7px;
}
.vd_red{
  color: #f85d2c !important;
  float: left
}
.overlay-loader-wrapper {
  background: rgba(34, 55, 65, 0.59);
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1000;
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
  width: 65px;
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
.newloaderBckImg{	
	background-image: url('././assets/images/landing_page.jpg');
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
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

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1568131759954933",
    enable_page_level_ads: true
  });
</script>



</head>



<body>

  <div class="overlay-loader-wrapper newloaderBckImg" style="display: none;" id="loaderHomePageDiv">
      <div class="overlay-loader">
          <div class="overlay-loader__content">
            <div class="overlay-loader__block">
              <div class="overlay-loader__block--inner">
                <span class="overlay-loader__line overlay-loader__line--first"></span>
                <span class="overlay-loader__line overlay-loader__line--second"></span>
                <span class="overlay-loader__line overlay-loader__line--last"></span>
              </div>
            </div>
            <span class="overlay-loader__text">Loading...</span>
        </div>
      </div>
    </div>

    <script>
    <?php if($this->session->userdata('guest_user') && $this->session->userdata('guest_user')=='guest_user' && !$_GET['is_loggedout']) { ?>
      document.getElementById('loaderHomePageDiv').style.display = "block";
      window.location.href = '<?php echo base_url()?>hauth/center_name/1';
    <?php }  ?>
    </script>
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

<a class="navbar-brand" href="<?php echo base_url()?>">

<img src="<?php echo base_url();?>assets/images/logo_new.png" alt="logo" title="Home" style="width: 200px; margin-left: 10px;margin-top: 10px;">

</a>

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

<!-- <li id="help">

<a href="<?php echo base_url();?>home/help">Help</a>

</li> -->
<?php

if($this->session->userdata('front_user_id') == '' || $this->session->userdata('front_is_logged_in'=='')){

?>

<li class="pull-right ">

<ul>

<li class="img-playStore">

<!-- <a href="https://play.google.com/store/apps/details?id=com.creonow.user&hl=en&utm_source=global_co&utm_medium=prtnr&utm_content=Mar2515&utm_campaign=PartBadge&pcampaignid=MKT-AC-global-none-all-co-pr-py-PartBadges-Oct1515-1" target="_blank" title="Download App">

<img src="<?php //echo base_url()?>assets/images/play_app.png"/>

</a> -->

</li>

<li>

<a href="#" data-toggle="modal" data-target="#myInstituteModal">

<div class="btn-group">

<button type="button" class="btn btn-info sign-up-btn actionbuttons" style="border-right: 2px solid rgb(19, 156, 231); padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-info sign-up-btn actionbuttons">Student Login</button>



</div>

</a>

</li>

<li>

<a href="<?php echo base_url();?>hauth/googleLogin">

<div class="btn-group">

<button type="button" class="btn btn-primary sign-in-btn faculty-btn actionbuttons" style="border-right: 2px solid #337AB7 !important; padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="image" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-primary sign-in-btn faculty-btn actionbuttons">Faculty Login</button>



</div>



</a>

</li>
<li>

<!-- <a href="<?php echo base_url();?>hauth/googleLogin"> -->

   <!--<a href="#" data-toggle="modal" data-target="#loginExp">-->
     <a href="<?php echo base_url();?>hauth/googleLogin/111" title="Login to Arena">


<div class="btn-group">

<button type="button" class="btn btn-danger sign-in-btn actionbuttons" style="border-right: 2px solid #C9302C; padding: 4px 6px 2px;">

<img class="pull-right" src="<?php echo base_url();?>assets/images/g-plus.png" alt="image" style="margin-top: 0px; width: 21px; height: 23px;">

</button>

<button type="button" class="btn btn-danger sign-in-btn actionbuttons">Guest Login</button>



</div>



</a>

</li>

</ul></li>

<?php
}
?>




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

echo 'People';

}

else

{

echo 'Search For';

} ?><span class="caret"></span></button>

<ul class="dropdown-menu" id="adv_pro_peo">

<li><a>People</a></li>

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

{  ?>

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

<button  id="adv_rating_selected" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?php   if($this->session->userdata('adv_rating'))         { echo $this->session->userdata('adv_rating');

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
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="font-size: 15px;font-weight: bold">Login using Student ID</h4>
          </div>
          <div class="modal-body">
            <form id="myForm" method="post" action="" onsubmit="return checkStudentId();" style="text-align: center;">

                  <p style="text-align: center;margin-left: -90px">Enter Your Student ID.</p>

                  <div class="form-group">

                    <input style="border:1px solid #3cafdf;width:300px;" class="form-control" id="studentId" type="text" name="studentId" required>  <button type="submit" class="btn btn-primary">Submit</button>

                  </div>

                  <span class="text-danger"></span>

            </form>
            <br/>
            <br/>
            <button class="btn btn-success student-div1" style="display: none;">Open Form</button> <br/>
              <form class="student-div" style="display: none;" id="myForm1" method="post" action="" onsubmit="return sendemaildtosupport();" id="defaultForm">
                  <div class="row">
                     <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Select Institute Type
                          </label>&nbsp;<!-- (<span class="error">*</span>) --><br/>
                          <input type="radio" name="categorytype" value="Arena" onclick="getinsdata()"> Arena&nbsp;&nbsp;
                          <input type="radio"  name="categorytype" value="Maac" onclick="getinsdata()"> MAAC
                          <input type="radio"  name="categorytype" value="Lakme" onclick="getinsdata()"> LAKME
                          <small class="error">
                            <?php echo form_error('categorytype');?>
                          </small>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-col col-xs-6 col-sm-6" style="margin-left: -1px;">
                          <div class="form-group ">
                            <label>
                              Select Institute
                            </label>&nbsp;<!-- (<span class="error">*</span>) -->
                            <select name="ins_name" class="form-control" style="width: 270px;" >
                              <option class ='ARENA' value="">Select Institute</option>
                              <?php
                                $CI =&get_instance();
                                $CI->load->model('home_model');
                                $ins_data=$CI->home_model->selectDetailsWhrAll();
                              foreach ($ins_data as $val) {
                                ?>
                                    <option class ='ARENA' value="<?=$val['instituteName']?>"><?=$val['instituteName']?></option>
                                <?php
                              }?>
                               <option class="MAAC" value="">Select Institute</option>
                              <?php
                                $CI =&get_instance();
                                $CI->load->model('home_model');
                                $ins_data=$CI->home_model->selectDetailsWhrAllMAAC();
                              foreach ($ins_data as $val) {
                                ?>
                                    <option class="MAAC" value="<?=$val['instituteName']?>"><?=$val['instituteName']?></option>
                                <?php
                              }?>

                               <option class="LAKME" value="">Select Institute</option>
                              <?php
                                $CI =&get_instance();
                                $CI->load->model('home_model');
                                $ins_data=$CI->home_model->selectDetailsWhrAllLAKME();
                              foreach ($ins_data as $val) {
                                ?>
                                    <option class="LAKME" value="<?=$val['instituteName']?>"><?=$val['instituteName']?></option>
                                <?php
                              }?>

                            </select>
                            <small class="error">
                              <?php echo form_error('ins_name');?>
                            </small>
                          </div>
                        </div>
                      </div>
                      <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Name
                          </label>&nbsp;<!-- (<span class="error"> * </span>) -->
                          <input class="form-control" name="fullname" type="text" value="<?php echo set_value('fullname');?>" required>
                          <small class="error">
                            <?php echo form_error('fullname');?>
                          </small>
                        </div>
                      </div>
                      <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Student ID
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" name="studentId" type="text" value="<?php echo set_value('studentId');?>" required>
                          <small class="error">
                            <?php echo form_error('studentId');?>
                          </small>
                        </div>
                      </div>
                      <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Contact No
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" name="contactNo" type="text" value="<?php echo set_value('contactNo');?>" required>
                          <small class="error">
                            <?php echo form_error('contactNo');?>
                          </small>
                        </div>
                      </div>
                       <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Email Id
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" name="email" type="email" value="<?php echo set_value('email');?>" required>
                          <small class="error">
                            <?php echo form_error('email');?>
                          </small>
                        </div>
                      </div>
                       <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Course Start Date
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" required id="start_date" readonly="true" name="start_date" type="text" value="<?php echo set_value('start_date');?>">

                          <small class="error">
                            <?php echo form_error('start_date');?>
                          </small>
                        </div>
                      </div>
                       <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Course End Date
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" id="end_date" required readonly="true" name="end_date" type="text" value="<?php echo set_value('end_date');?>">
                          <small class="error">
                            <?php echo form_error('end_date');?>
                          </small>
                        </div>
                      </div>
                      <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Course Name
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" name="coursename" type="text" value="<?php echo set_value('coursename');?>" required>
                          <small class="error">
                            <?php echo form_error('coursename');?>
                          </small>
                        </div>
                      </div>
                       
                       <div class="input-col col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label>
                            Payment Receipt Copy
                          </label>&nbsp;<!-- (<span class="error">*</span>) -->
                          <input class="form-control" name="receiptimage" type="file" value="<?php echo set_value('receiptimage');?>" required>
                          <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg, html, pdf ", Allowed size 4MB )</span>
                          <small class="error">
                            <?php echo form_error('receiptimage');?>
                          </small>
                        </div>
                      </div>
                      <div class="row">
                  <span class="text-danger"></span>

                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary" id="supportformbutton">
                      Submit
                    </button>
                  </div>
                </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="message_model" role="dialog" onclick="closeDialog()">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closedialog" data-dismiss="modal">&times;</button>
          <div class="message_show" style="font-size: 15px;font-weight: bold"></div>
        </div>
    </div>
  </div>
</div>


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
          <?php if($this->session->userdata('blockUser') ==2){?> Your subscription period is over.</br></br>This happens if your course end date is reached as per your registration record.</br>Please confirm your course end date with your institute admin first by looking in Aptrack.</br></br>Here are a few things you can do:</br> 1. If your course has not ended as per your institute admin: Send email to support@cresouls.com with your Enrollment Receipt, Student ID, Email ID, Course Name, Start date, End Date as per Aptrack data. It is mandatory to attach a copy of fee receipt.</br></br>2. If your course has ended and you need to get access to cresouls: Please enroll in the standalone Cresouls course. Wait for one day and try accessing it.<?php } ?>
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


<!-- Login type select Modal -->
  <div class="modal fade" id="loginExp" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-weight: 600;font-size: 1.5em;">Area to Login</h4>
        </div>
        <div class="modal-body newGuestloginModal">

          <a href="<?php echo base_url();?>hauth/googleLogin/111" title="Login to Arena"><img src="<?php echo base_url();?>assets/img/arena_login.png" ></a>
          <a href="<?php echo base_url();?>hauth/googleLogin/222" title="Login to Maac"><img src="<?php echo base_url();?>assets/img/macc_login.png" style="margin-top: 6px"></a>
          <a href="<?php echo base_url();?>hauth/googleLogin/333" title="Login to Lakme"><img src="<?php echo base_url();?>assets/img/lakme_login.png" style="margin-top: 6px"></a>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>



