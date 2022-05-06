<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html><!--<![endif]-->

<!-- Specific Page Data -->

<!-- End of Data -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <title>University Admin Panel</title>
    <meta name="description" content="Creosouls Admin dashboard">
    <meta name="author" content="Santosh">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="img/ico/favicon.png">


    <!-- CSS -->

    <!-- Bootstrap & FontAwesome & Entypo CSS -->
    <link href="<?php echo base_url();?>backend_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if IE 7]><link type="text/css" rel="stylesheet" href="<?php echo base_url();?>backend_assets/css/font-awesome-ie7.min.css"><![endif]-->
    <link href="<?php echo base_url();?>backend_assets/css/font-entypo.css" rel="stylesheet" type="text/css">

    <!-- Fonts CSS -->
    <link href="<?php echo base_url();?>backend_assets/css/fonts.css"  rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="<?php echo base_url();?>backend_assets/plugins/jquery-ui/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/css/prettyPhoto.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/isotope/css/isotope.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/pnotify/css/jquery.pnotify.css" media="screen" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">


    <link href="<?php echo base_url();?>backend_assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.css" rel="stylesheet" type="text/css">
   <!--  <link href="<?php echo base_url();?>backend_assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"> -->

   
    <link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>backend_assets/plugins/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">

    <!-- Specific CSS -->
    <link href="<?php echo base_url();?>backend_assets/plugins/introjs/css/introjs.min.css" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="<?php echo base_url();?>backend_assets/css/theme.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]> <link href="<?php echo base_url();?>backend_assets/css/ie.css" rel="stylesheet" > <![endif]-->
    <link href="<?php echo base_url();?>backend_assets/css/chrome.css" rel="stylesheet" type="text/chrome"> <!-- chrome only css -->



    <!-- Responsive CSS -->
            <link href="<?php echo base_url();?>backend_assets/css/theme-responsive.min.css" rel="stylesheet" type="text/css">




    <!-- for specific page in style css -->

    <!-- for specific page responsive in style css -->


    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>backend_assets/custom/custom.css" rel="stylesheet" type="text/css">



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/mobile-detect.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/mobile-detect-modernizr.js"></script>
    <script type="text/javascript">
        var base_url='<?php echo base_url();?>';
    </script>

</head>

<body id="dashboard" class="full-layout  nav-right-hide nav-right-start-hide  nav-top-fixed      responsive    clearfix breakpoint-975 nav-left-medium" data-active="dashboard "  data-smooth-scrolling="1">
<div class="vd_body">
<!-- Header Start -->
  <header class="header-1" id="header">
      <div class="vd_top-menu-wrapper">
        <div class="container ">
          <div class="vd_top-nav vd_nav-width  ">
          <div class="vd_panel-header">
            <div class="logo">
                <a href="<?php echo base_url();?>"><img alt="logo" src="<?php echo front_base_url();?>assets/images/logo_new.png"></a>
            </div>
            <!-- logo -->
            <div class="vd_panel-menu  hidden-sm hidden-xs" data-intro="<strong>Minimize Left Navigation</strong><br/>Toggle navigation size to medium or small size. You can set both button or one button only. See full option at documentation." data-step=1>
                                        <span class="nav-medium-button menu" data-toggle="tooltip" data-placement="bottom" data-original-title="Medium Nav Toggle" data-action="nav-left-medium">
                        <i class="fa fa-bars"></i>
                    </span>

                    <span class="nav-small-button menu" data-toggle="tooltip" data-placement="bottom" data-original-title="Small Nav Toggle" data-action="nav-left-small">
                        <i class="fa fa-ellipsis-v"></i>
                    </span>

            </div>
            <div class="vd_panel-menu left-pos visible-sm visible-xs">

                        <span class="menu" data-action="toggle-navbar-left">
                            <i class="fa fa-ellipsis-v"></i>
                        </span>


            </div>
            <div class="vd_panel-menu visible-sm visible-xs">
                    <span class="menu visible-xs" data-action="submenu">
                        <i class="fa fa-bars"></i>
                    </span>

                        <span class="menu visible-sm visible-xs" data-action="toggle-navbar-right">
                            <i class="fa fa-comments"></i>
                        </span>

            </div>
            <!-- vd_panel-menu -->
          </div>
          <!-- vd_panel-header -->

          </div>
          <div class="vd_container">
            <div class="row">
                <div class="col-sm-5 col-xs-12">
<!--
<div class="vd_menu-search">
  <form id="search-box" method="post" action="#">
    <input type="text" name="search" class="vd_menu-search-text width-60" placeholder="Search">
    <div class="vd_menu-search-category"> <span data-action="click-trigger"> <span class="separator"></span> <span class="text">Category</span> <span class="icon"> <i class="fa fa-caret-down"></i></span> </span>
      <div class="vd_mega-menu-content width-xs-2 center-xs-2 right-sm" data-action="click-target">
        <div class="child-menu">
          <div class="content-list content-menu content">
            <ul class="list-wrapper">
              <li>
                <label>
                  <input type="checkbox" value="all-files">
                  <span>All Files</span></label>
              </li>
              <li>
                <label>
                  <input type="checkbox" value="photos">
                  <span>Photos</span></label>
              </li>
              <li>
                <label>
                  <input type="checkbox" value="illustrations">
                  <span>Illustrations</span></label>
              </li>
              <li>
                <label>
                  <input type="checkbox" value="video">
                  <span>Video</span></label>
              </li>
              <li>
                <label>
                  <input type="checkbox" value="audio">
                  <span>Audio</span></label>
              </li>
              <li>
                <label>
                  <input type="checkbox" value="flash">
                  <span>Flash</span></label>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <span class="vd_menu-search-submit"><i class="fa fa-search"></i> </span>
  </form>
</div>
               -->  </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="vd_mega-menu-wrapper">
                        <div class="vd_mega-menu pull-right">
                            <ul class="mega-ul">
   <!--  <li id="top-menu-1" class="one-icon mega-li">
      <a href="index.html" class="mega-link" data-action="click-trigger">
        <span class="mega-icon"><i class="fa fa-users"></i></span>
        <span class="badge vd_bg-red">1</span>
      </a>
      <div class="vd_mega-menu-content width-xs-3 width-sm-4 width-md-5 right-xs left-sm" data-action="click-target">
        <div class="child-menu">
           <div class="title">
               Friend Requests
               <div class="vd_panel-menu">
                     <span data-original-title="Find User" data-toggle="tooltip" data-placement="bottom" class="menu">
                        <i class="fa fa-search"></i>
                    </span>
                     <span data-original-title="Message Setting" data-toggle="tooltip" data-placement="bottom" class="menu">
                        <i class="fa fa-cog"></i>
                    </span>
                </div>
           </div>
           <div class="content-grid column-xs-2 column-sm-3 height-xs-4">
           <div data-rel="scroll">
               <ul class="list-wrapper">
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg"></div>
                         </a>
                        <div class="menu-text"> Gabriella Montagna
                            <div class="menu-info">
                                <div class="menu-date">San Diego</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                     </li>
                    <li class="warning">
                            <a href="#">
                                <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-2.jpg"></div>
                            </a>
                            <div class="menu-text">  Jonathan Fuzzy
                                <div class="menu-info">
                                    <div class="menu-date">Seattle</div>
                                    <div class="menu-action">
                                        <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                     </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-3.jpg"></div>
                         </a>
                        <div class="menu-text">  Sakura Hinata
                            <div class="menu-info">
                                <div class="menu-date">Hawaii</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-4.jpg"></div>
                         </a>
                        <div class="menu-text">  Rikudou Sennin
                            <div class="menu-info">
                                <div class="menu-date">Las Vegas</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-5.jpg"></div>
                         </a>
                        <div class="menu-text">  Kim Kardiosun
                            <div class="menu-info">
                                <div class="menu-date">New York</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                     </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-6.jpg"></div>
                         </a>
                        <div class="menu-text">   Brad Pita
                            <div class="menu-info">
                                <div class="menu-date">Seattle</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-7.jpg"></div>
                         </a>
                        <div class="menu-text">  Celline Dior
                            <div class="menu-info">
                                <div class="menu-date">Los Angeles</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li> <a href="#">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-8.jpg"></div>
                         </a>
                        <div class="menu-text">  Goerge Bruno Marz
                            <div class="menu-info">
                                <div class="menu-date">Las Vegas</div>
                                <div class="menu-action">
                                    <span class="menu-action-icon vd_green vd_bd-green" data-original-title="Approve" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span class="menu-action-icon vd_red vd_bd-red" data-original-title="Reject" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>

               </ul>
               </div>
               <div class="closing text-center" style="">
                    <a href="#">See All Requests <i class="fa fa-angle-double-right"></i></a>
               </div>
           </div>
        </div>
      </div>
    </li>
    <li id="top-menu-2" class="one-icon mega-li">
      <a href="index.html" class="mega-link" data-action="click-trigger">
        <span class="mega-icon"><i class="fa fa-envelope"></i></span>
        <span class="badge vd_bg-red">10</span>
      </a>
      <div class="vd_mega-menu-content width-xs-3 width-sm-4 width-md-5 width-lg-4 right-xs left-sm" data-action="click-target">
        <div class="child-menu">
           <div class="title">
               Messages
               <div class="vd_panel-menu">
                     <span data-original-title="Message Setting" data-toggle="tooltip" data-placement="bottom" class="menu">
                        <i class="fa fa-cog"></i>
                    </span>
                </div>
           </div>
           <div class="content-list content-image">
               <div  data-rel="scroll">
               <ul class="list-wrapper pd-lr-10">
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg"></div>
                            <div class="menu-text"> Do you play or follow any sports?
                                <div class="menu-info">
                                    <span class="menu-date">12 Minutes Ago </span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                    </li>
                    <li class="warning">
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-2.jpg"></div>
                            <div class="menu-text">  Good job mate !
                                <div class="menu-info">
                                    <span class="menu-date">1 Hour 20 Minutes Ago </span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Read" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                     </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-3.jpg"></div>
                            <div class="menu-text">  Just calm down babe, everything will work out.
                                <div class="menu-info">
                                    <span class="menu-date">12 Days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                    </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-4.jpg"></div>
                            <div class="menu-text">  Euuh so gross....
                                <div class="menu-info">
                                    <span class="menu-date">19 Days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                    </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-5.jpg"></div>
                            <div class="menu-text">  That's the way.. I like it :D
                                <div class="menu-info">
                                    <span class="menu-date">20 Days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                     </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-6.jpg"></div>
                            <div class="menu-text">  Oooh don't be shy ;P
                                <div class="menu-info">
                                    <span class="menu-date">21 Days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                     </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-7.jpg"></div>
                            <div class="menu-text">  Hello, please call my number..
                                <div class="menu-info">
                                    <span class="menu-date">24 Days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                    </li>
                    <li>
                            <div class="menu-icon"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar-8.jpg"></div>
                            <div class="menu-text">  Don't go anywhere, i will be coming soon
                                <div class="menu-info">
                                    <span class="menu-date">1 Month 2 days Ago</span>
                                    <span class="menu-action">
                                        <span class="menu-action-icon" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                     </li>

               </ul>
               </div>
               <div class="closing text-center" style="">
                    <a href="#">See All Notifications <i class="fa fa-angle-double-right"></i></a>
               </div>
           </div>
        </div>
      </div>
    </li>
    <li id="top-menu-3"  class="one-icon mega-li">
      <a href="index.html" class="mega-link" data-action="click-trigger">
        <span class="mega-icon"><i class="fa fa-globe"></i></span>
        <span class="badge vd_bg-red">51</span>
      </a>
      <div class="vd_mega-menu-content  width-xs-3 width-sm-4  center-xs-3 left-sm" data-action="click-target">
        <div class="child-menu">
           <div class="title">
                Notifications
               <div class="vd_panel-menu">
                     <span data-original-title="Notification Setting" data-toggle="tooltip" data-placement="bottom" class="menu">
                        <i class="fa fa-cog"></i>
                    </span>

                </div>
           </div>
           <div class="content-list">
               <div  data-rel="scroll">
               <ul  class="list-wrapper pd-lr-10">
                    <li> <a href="#">
                            <div class="menu-icon vd_yellow"><i class="fa fa-suitcase"></i></div>
                            <div class="menu-text"> Someone has give you a surprise
                                <div class="menu-info"><span class="menu-date">12 Minutes Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_blue"><i class=" fa fa-user"></i></div>
                            <div class="menu-text">  Change your user profile details
                                <div class="menu-info"><span class="menu-date">1 Hour 20 Minutes Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_red"><i class=" fa fa-cogs"></i></div>
                            <div class="menu-text">  Your setting is updated
                                <div class="menu-info"><span class="menu-date">12 Days Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_green"><i class=" fa fa-book"></i></div>
                            <div class="menu-text">  Added new article
                                <div class="menu-info"><span class="menu-date">19 Days Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_green"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg"></div>
                            <div class="menu-text">  Change Profile Pic
                                <div class="menu-info"><span class="menu-date">20 Days Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_red"><i class=" fa fa-cogs"></i></div>
                            <div class="menu-text">  Your setting is updated
                                <div class="menu-info"><span class="menu-date">12 Days Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_green"><i class=" fa fa-book"></i></div>
                            <div class="menu-text">  Added new article
                                <div class="menu-info"><span class="menu-date">19 Days Ago</span></div>
                            </div>
                    </a> </li>
                    <li> <a href="#">
                            <div class="menu-icon vd_green"><img alt="example image" src="<?php echo base_url();?>backend_assets/img/avatar/avatar.jpg"></div>
                            <div class="menu-text">  Change Profile Pic
                                <div class="menu-info"><span class="menu-date">20 Days Ago</span></div>
                            </div>
                    </a> </li>

               </ul>
               </div>
               <div class="closing text-center" style="">
                    <a href="#">See All Notifications <i class="fa fa-angle-double-right"></i></a>
               </div>
           </div>
        </div>
      </div>
    </li> -->


<!--     <a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="Export Users" onclick="export_users_project_count()"> <i class="fa fa-download"></i> Project Count</a>


 <a href="<?php echo base_url();?>admin/admin/export_users_likers_project" class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="Export Users"> <i class="fa fa-download"></i> Project Likers</a>


 <a href="<?php echo base_url();?>admin/admin/export_users_assignments" class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="Export Assignment"> <i class="fa fa-download"></i>Assig Users</a>  -->





    <li id="top-menu-profile" class="profile mega-li">
        <a href="#" class="mega-link"  data-action="click-trigger">
            <span  class="mega-image">
                <img src="<?php echo base_url();?>backend_assets/img/noimage.jpg" alt="" />
            </span>
            <span class="mega-name">
                <?php echo $this->session->userdata('admin_name');?> <i class="fa fa-caret-down fa-fw"></i>
            </span>
        </a>
      <div class="vd_mega-menu-content  width-xs-2  left-xs left-sm" data-action="click-target">
        <div class="child-menu">
            <div class="content-list content-menu">
                <ul class="list-wrapper pd-lr-10">
                  <!--   <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-user"></i></div> <div class="menu-text">Edit Profile</div> </a> </li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-trophy"></i></div> <div class="menu-text">My Achievements</div> </a> </li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-envelope"></i></div> <div class="menu-text">Messages</div><div class="menu-badge"><div class="badge vd_bg-red">10</div></div> </a>  </li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-tasks
"></i></div> <div class="menu-text"> Tasks</div><div class="menu-badge"><div class="badge vd_bg-red">5</div></div> </a> </li>
                    <li class="line"></li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-lock
"></i></div> <div class="menu-text">Privacy</div> </a> </li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-cogs"></i></div> <div class="menu-text">Settings</div> </a> </li>
                    <li> <a href="#"> <div class="menu-icon"><i class="  fa fa-key"></i></div> <div class="menu-text">Lock</div> </a> </li> -->
                    <li> <a href="<?php echo base_url();?>admin/admin/logout"> <div class="menu-icon"><i class=" fa fa-sign-out"></i></div>  <div class="menu-text">Visit Frontend</div> </a> </li>
                  <!--   <li> <a href="<?php echo front_base_url();?>"> <div class="menu-icon"><i class=" fa fa-sign-in"></i></div>  <div class="menu-text">Visit Frontend</div> </a> </li> -->
                  

                    <li style="display: none;"><a id="chang_password" data-toggle="modal" data-target="#chang_pass"> <div class="menu-icon"><i class=" fa fa-sign-out"></i></div>  <div class="menu-text">Change Password</div> </a> </li>

<!--                     <li> <a href="#"> <div class="menu-icon"><i class=" fa fa-question-circle"></i></div> <div class="menu-text">Help</div> </a> </li>
                    <li> <a href="#"> <div class="menu-icon"><i class=" glyphicon glyphicon-bullhorn"></i></div> <div class="menu-text">Report a Problem</div> </a> </li> -->
                </ul>
            </div>
        </div>
      </div>

    </li>

<!--     <li id="top-menu-settings" class="one-big-icon hidden-xs hidden-sm mega-li" data-intro="<strong>Toggle Right Navigation </strong><br/>On smaller device such as tablet or phone you can click on the middle content to close the right or left navigation." data-step=2 data-position="left">
        <a href="#" class="mega-link"  data-action="toggle-navbar-right">
           <span class="mega-icon">
                <i class="fa fa-comments"></i>
            </span>

            <span class="badge vd_bg-red">8</span>
        </a>

    </li> -->
    </ul>

                        </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
        <!-- container -->
      </div>
      <!-- vd_primary-menu-wrapper -->
<input type="hidden"  id="base_url" value="<?php echo base_url(); ?>"/>
  </header>

  <div aria-hidden="true" role="dialog" tabindex="-1" id="chang_pass" class="modal fade" style="display: none;">
        <div class="modal-dialog">
               <div class="modal-content">
                     <div class="modal-header vd_bg-blue vd_white">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
                            <h4 id="AdminModalLabel" class="modal-title">Change Password</h4>
                     </div>
                     <div class="modal-body">
                   <form class="form-horizontal" id="admin-pass-form" action="#" role="form" method="post">
                     <div class="form-group  mgbt-xs-20">
                       <div class="col-md-12">
                         <div class="label-wrapper sr-only">
                           <label>Password</label>
                         </div>
                         <div class="vd_input-wrapper light-theme"> <span class="menu-icon"> <i class="fa fa-user"></i> </span>
                           <input type="text" placeholder="Enter Password" id="chang_pass_admin" name="chang_pass_admin" class="required">
                         </div> 
                       </div>
                     </div>                    
                     <div class="form-group">
                       <div class="col-md-12 text-center mgbt-xs-5">
                         <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="admin-pass-submit">Submit</button>
                       </div>
                       <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $this->session->userdata('admin_id');?>">
                       <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url();?>">
                     </div>
                   </form>
                     </div>           
               </div>    
        </div>

  </div>

