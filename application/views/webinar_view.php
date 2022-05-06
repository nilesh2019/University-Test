<?php $this->load->view('template/header'); ?>

<title><?php echo $meta_title; ?></title>
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />

<?php
$redirect_page_name = 'live_sessions';
?>
<style>

  .contact-btn:hover
  {
    color: #fff;
  }
  .regBtn
  {
    height: 35px;
    padding-top: 6px;
  }

  .slider_textblock_center .slide_description {
    text-align: center;
    margin-right: 0;
}
.animated {
    visibility: visible!important;
}
  
.MY-isotopeFiltr ul li a, .MY-isotopeFiltr ul a:hover, .MY-isotopeFiltr ul a{
      background-color: transperant;
      border-color: #eee;
      color: #252525!important;
  }

  .MY-isotopeFiltr ul li.active a, .MY-isotopeFiltr ul a:hover, .MY-isotopeFiltr ul a:active {
      background-color: #2a41e8;
      border-color: transperant;
      color: #fff!important;
  }
  .MY-isotopeFiltr ul a {
      background-color: transparent;
      border: 1px solid transparent;
      box-sizing: border-box;
      font-size: 14px;
      font-weight: 300;
      height: 50px;
      letter-spacing: 1px;
      line-height: 50px;
      overflow: visible;
      padding: 0 30px;
      position: relative;
      text-transform: uppercase;
  }
  .MY-isotopeFiltr ul {
      margin: 0;
      text-align: center;
  }
  .portfolioWrap {
    overflow: hidden;
}
.squareButton, input[type=button], input[type=submit] {
    height: 70px;
    list-style: none;
    display: inline-block;
    vertical-align: bottom;
    position: relative;
}
  .squareButton:not(.ico)>a {
    display: inline-table;
    border-spacing: 0;
}
  .menuSearch .search-form, .openResponsiveMenu, .relatedPostWrap.sc_blogger article .readmore_blogger, .revlink, .squareButton>a, .squareButton>span, .swpRightPos .searchBlock .search-form, .topWrap .cart .cart_button, .topWrap .search, .topWrap .search:before, .user-popUp .formItems .formList .loginSoc .iconLogin, .user-popUp .formItems .formList li .sendEnter, .widget_area .search-form, .widget_area .search-form input.search-field, .widget_area .tabs_area ul.tabs>li>a, .widget_area .tagcloud a, input[type=password], input[type=text], textarea {
    -webkit-border-radius: 31px;
    -moz-border-radius: 31px;
    border-radius: 31px;
}


.isotope, .isotope .isotope-item {
    -webkit-transition-duration: .8s;
    -moz-transition-duration: .8s;
    transition-duration: .8s;
}

.masonry .isotopePadding {
    position: relative;
    background: #F5F7FF;
}

  
  
  
.portfolioWrap .isotopePadding {
    min-height: 200px;
    overflow: hidden;
    position: relative;
}
.audio_container, .bg_image, .portfolioWrap .isotopePadding, .postAside, .postLink, .postStatus, .relatedPostWrap article .wrap.no_thumb, .sc_quote_style_1, .topTabsWrap, .userFooterSection.global, .userHeaderSection.global {
    background-image: url(background.jpg);
    background-size: 100% 100%;
    background-position: left top;
}
  a {
    text-decoration: none;
    -webkit-transition: all .3s ease-in-out 0s;
    -moz-transition: all .3s ease-in-out 0s;
    -o-transition: all .3s ease-in-out 0s;
    -ms-transition: all .3s ease-in-out 0s;
    transition: all .3s ease-in-out 0s;
    color: #232a34;
}
  .masonry article .thumb {
    width: 100%;
}

.hoverIncrease {
    position: relative;
    overflow: hidden;
}
  .masonry article .thumb img {
    width: 100%;
    height: auto;
    display: block;
}

.hoverIncrease img {
    position: relative;
    z-index: 5;
    display: block;
}
a img {
    -webkit-transition: all .15s ease-in-out 0s;
    -moz-transition: all .15s ease-in-out 0s;
    -o-transition: all .15s ease-in-out 0s;
    -ms-transition: all .15s ease-in-out 0s;
    transition: all .15s ease-in-out 0s;
}
img {
    max-width: 100%;
}
img {
    vertical-align: middle;
}
img {
    border: 0;
}
  #pagination .squareButton a:active, #pagination .squareButton a:hover, #pagination .squareButton.active span, #timeline_section [class*=swiper-button-]:hover, #viewmore_link:active, #viewmore_link:hover, .hoverIncrease .hoverShadow, .portfolioWrap .isotopePadding:before, .relatedPostWrap .wrap:before, .relatedPostWrap.sc_blogger .wrap:hover:before, .sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title:before, .sc_blogger.sc_blogger_vertical.style_date.sc_scroll_controls ul.flex-direction-nav li a:hover, .sc_dropcaps.sc_dropcaps_style_3 .sc_dropcap, .sc_skills_bar .sc_skills_item .sc_skills_count, .sc_skills_counter .sc_skills_item.sc_skills_style_3 .sc_skills_count, .sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_count, .sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_info, .sc_timeline.style_date .sc_timeline_item .sc_timeline_date, .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:before, .sc_tooltip_parent .sc_tooltip, .sc_tooltip_parent .sc_tooltip:before, .sidemenu_wrap .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, .sidemenu_wrap .mCSB_scrollTools_onDrag .mCSB_dragger_bar, .squareButton.accent_2>a, .theme_accent_2_bgc, .theme_accent_2_bgc:before, .user-popUp .formItems .formList li .sendEnter, .user-popUp ul.loginHeadTab li.ui-tabs-active:before, .woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce .widget_area aside.widgetWrap.woocommerce .button, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce-page .widget_area aside.widgetWrap.woocommerce .button, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span.current {
    background-color: #392071;
}

.gallery-item .gallery-item-description, .gallery-item h2, .gallery-item p, .gallery-item:hover img, .hoverIncrease .hoverIcon, .hoverIncrease .hoverShadow, .hoverIncrease .wrap_hover a>span, .isotopeFiltr ul a .data_count, .portfolioWrap .isotopePadding .portfolioInfo, .portfolioWrap .isotopePadding:before, .sc_team_item_avatar:after, a.sc_image_hover .img_hover {
    opacity: 0;
}
#custom_options .co_options #co_bg_pattern_list a img, .author .socPage ul li a, .commentsForm input[type=password], .commentsForm input[type=text], .commentsForm textarea, .comments_list a.comment-edit-link, .contactFooter .contactShare ul li a, .copyWrap .socPage ul li a, .flex-direction-nav a, .footerContentWrap .sc_googlemap, .footerWidget .flickr_badge_image a:before, .footerWidget .flickr_images>a:before, .footerWidget .instagram-pics li a:before, .fullScreenSlider .sliderHomeBullets .order a, .hoverIncrease .hoverIcon, .hoverIncrease .hoverIcon:before, .hoverIncrease .hoverLink, .hoverIncrease .hoverShadow, .iColorPicker:before, .isotopeFiltr ul a .data_count, .mejs-controls .mejs-mute.mejs-button, .mejs-controls .mejs-pause, .mejs-controls .mejs-play, .mejs-controls .mejs-unmute.mejs-button, .menuSearch .searchSubmit:before, .menuTopWrap ul#mainmenu>li>a>.menu_item_description, .menu_center .topWrap .search.SearchHide, .nav_comments>a, .nav_pages_parts>a>span, .openResponsiveMenu, .openResponsiveMenu:before, .pagination .flex-direction-nav a, .pagination .flex-direction-nav a:active, .pagination .flex-direction-nav a:hover, .portfolioWrap .isotopePadding:before, .postSharing a, .postSharing a:hover, .relatedPostWrap .wrap:before, .relatedPostWrap article a, .relatedPostWrap.sc_blogger article .readmore_blogger, .relatedPostWrap.sc_blogger article .wrap_bottom_info, .revlink, .roundButton a, .roundButton a:hover, .sc_contact_form .next, .sc_contact_form input, .sc_contact_form input[type=password], .sc_contact_form input[type=text], .sc_contact_form textarea, .sc_price_currency, .sc_price_money, .sc_pricing_data>span, .sc_pricing_table .sc_pricing_columns ul, .sc_pricing_table .sc_pricing_columns ul li, .sc_scroll_controls .flex-direction-nav a, .sc_scroll_controls .swiper-direction-nav a, .sc_section.sc_scroll_controls_horizontal.sc_scroll_controls ul.flex-direction-nav li, .sc_slider_chop ul.flex-direction-nav a, .sc_slider_chop ul.flex-direction-nav li, .sc_slider_flex ul.flex-direction-nav a, .sc_slider_flex ul.flex-direction-nav li, .sc_slider_swiper ul.flex-direction-nav a, .sc_slider_swiper ul.flex-direction-nav li, .sc_tabs ul.sc_tabs_titles li a, .sc_tabs ul.sc_tabs_titles li a:after, .sc_team_item, .sc_team_item .sc_team_item_avatar, .sc_team_item .sc_team_item_socials, .sc_team_item:hover .sc_team_item_avatar .sc_team_item_description, .sc_team_item:hover .sc_team_item_avatar:after, .sc_testimonials .flex-direction-nav a, .sc_testimonials_style .flex-direction-nav li, .sc_video_player .sc_video_play_button:after, .sc_video_player:active .sc_video_play_button:after, .sc_video_player:hover .sc_video_play_button:after, .socPage ul li a, .squareButton>a, .squareButton>a:hover, .topWrap .search .searchSubmit .icoSearch:before, .topWrap .search:not(.searchOpen):before, .topWrap.styleFon .cart .cart_button:before, .topWrap.styleFon .search .searchForm .searchField, .tp-leftarrow.default, .tp-rightarrow.default, .twitBlock .flex-direction-nav li, .twitBlock .flex-direction-nav li a, .twitBlock .flex-direction-nav li a:before, .upToScroll, .upToScroll a, .upToScroll.buttonShow, .widgetWrap .tagcloud a, .widget_area .flickr_images .flickr_badge_image a:after, .widget_area .flickr_images .flickr_badge_image a:before, .widget_area .instagram-pics li a:after, .widget_area .instagram-pics li a:before, .widget_area .tabs_area ul.tabs a, .widget_socials .socPage ul li a, .wp-calendar tbody td a, [class*=swiper-button-], a.sc_icon.bg_icon.sc_icon_round, a.sc_icon.bg_icon.sc_icon_round:before, a.sc_icon.no_bg_icon.sc_icon_round, a.sc_icon.no_bg_icon.sc_icon_round:before, body.boxed, body.boxed .boxedWrap, input[type=button], input[type=submit], ul>li.like>a:hover>span.likePost:before, ul>li.like>a>span.likePost, ul>li.like>a>span.likePost:before, ul>li.likeActive>a:hover>span.likePost:before, ul>li.likeActive>a>span.likePost, ul>li.likeActive>a>span.likePost:before, ul>li.share>ul.shareDrop:before {
    -webkit-transition: all .3s ease-out;
    -moz-transition: all .3s ease-out;
    -ms-transition: all .3s ease-out;
    -o-transition: all .3s ease-out;
    transition: all .3s ease-out;
}
.hoverIncrease .hoverShadow {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 6;
    display: block;
    background-color: #392071;
    opacity: 0;
}
  .masonry .isotopePadding.bg_post .post_wrap {
    padding: 30px 35px 35px;
}
  a {
    text-decoration: none;
    -webkit-transition: all .3s ease-in-out 0s;
    -moz-transition: all .3s ease-in-out 0s;
    -o-transition: all .3s ease-in-out 0s;
    -ms-transition: all .3s ease-in-out 0s;
    transition: all .3s ease-in-out 0s;
    color: #232a34;
}
.masonry article h4 {
    padding: 0 0 15px 0;
    height: 60px;
}
  
  .flexslider h3 {
    font-size: 48px;
    line-height: 59px;
}
  
  .slide_description {
    display: inline-block;
    vertical-align: middle;
}
.attendbtn:hover {
    color: #ffffff!important;
    background-color: orangered!important;
    border-color: orangered!important;
}
  
.h4, h4 {
    font-size: 22px;
    line-height: 30px;
    padding: 0 0 30px 0;
    font-weight: 100;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin: 0;
    color: #232a34;
    -ms-word-wrap: break-word;
    word-wrap: break-word;
}
  a {
    text-decoration: none;
    -webkit-transition: all .3s ease-in-out 0s;
    -moz-transition: all .3s ease-in-out 0s;
    -o-transition: all .3s ease-in-out 0s;
    -ms-transition: all .3s ease-in-out 0s;
    transition: all .3s ease-in-out 0s;
    color: #232a34;
}
  .portfolioWrap .post_format_wrap {
    font-size: 14px;
    line-height: 25px;
    color: #5a6266;
}


.masonry {
    /* padding: 0 45px 185px 0; */
    /* margin: 0 -40px 0 0; */
    text-align: center;
}
.isotope, .isotope .isotope-item {
    -webkit-transition-duration: .8s;
    -moz-transition-duration: .8s;
    transition-duration: .8s;
}
  .sc_parallax_content>.container, section>.container {
    padding-top: 15px;
    padding-bottom: 15px;
}
#mainslider .flexslider {
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.flexslider {
    height: auto!important;
}
.flexslider {
    margin: 0 0;
    position: relative;
    zoom: 1;
}
.flexslider {
    margin: 0;
    padding: 0;
}
  .flexslider .slides {
    zoom: 1;
    height: inherit;
}

.flex-control-nav, .flex-direction-nav, .slides {
    margin: 0;
    padding: 0;
    list-style: none;
}
  .flexslider .slides>li {
    /*display: none;*/
    -webkit-backface-visibility: hidden;
    height: inherit;
}
  .flexslider .slides img {
    width: 100%;
    display: block;
}

a img {
    -webkit-transition: all .15s ease-in-out 0s;
    -moz-transition: all .15s ease-in-out 0s;
    -o-transition: all .15s ease-in-out 0s;
    -ms-transition: all .15s ease-in-out 0s;
    transition: all .15s ease-in-out 0s;
}
  img {
    max-width: 100%;
}
  @media (max-width: 1367px) and (min-width: 1268px)
#mainslider .flexslider h3 {
    font-size: 48px;
    line-height: 59px;
}
#mainslider h3 {
    margin: 0;
}
#mainslider h2, #mainslider h3, #mainslider p {
    color: #fff;
}
.h3, h3 {
    font-size: 30px;
   /* line-height: 37px;*/
  /*  padding: 0 0 30px 0; */
    font-weight: 100;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin: 0;
    color: #232a34;
    -ms-word-wrap: break-word;
    word-wrap: break-word;
}
  #mainslider .slide_description_wrapper {
    position: absolute;
    top: 70px;
    bottom: 0;
    left: 0;
    right: 0;
}
  .squareButton.big {
    height: 50px;
}
.squareButton, input[type=button], input[type=submit] {
    height: 70px;
    list-style: none;
    display: inline-block;
    vertical-align: bottom;
    position: relative;
} 
  .contact-btn {
    background: #2a41e8 none repeat scroll 0 0;
    border: medium none;
    border-radius: 30px;
    color: #fff;
    letter-spacing: 1px;
    padding: 1px 30px;
    text-transform: uppercase;
    margin-top: 20px;
}
    .regBtn {
    height: 35px;
    padding-top: 12px;
  }
  
  .row{
    margin-right:0px !important;
    margin-left:0px !important;
  }
  
  footer img {
        margin-left: 0px ! important;
}
</style>
<div class="middle">
<?php //if(!empty($banner)){ ?>
<section id="mainslider" class="fullwidth no_padding_container no_margin_col">
  <div class="">
    <div class="row">
      <div class="col-sm-12" style="padding: 0px;">
        <div class="flexslider">
          <ul class="slides text-center">
            <?php //foreach ($banner as $ban_val) { ?>
            <li> 
              <a href="<?php echo base_url();?>resource/live">
                <!--<img src="<?php //echo base_url(); ?>uploads/banner/<?php //echo $ban_val['img']?>" alt="<?php //echo $ban_val['img']?>">-->
                <img src="<?php echo base_url(); ?>uploads/banner/bg_banner.jpg" alt="bg_banner.jpg">
                <div class="slide_description_wrapper slider_textblock_center">
                  <div class="slide_description to_animate animated fadeInUp">
                    <div data-animation="fadeInUp"class="animated fadeInUp">
                      <h3><?php echo "Creo Live"; //$ban_val['title'];?></h3>
                      <p>
                        <?php //echo $ban_val['desc'];?>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </li>
            <?php  //} ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php //} ?>
<!--<section id="skills" class="light_section">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="history_content about-content">
          <h1 class="sc_title sc_title_underline h1Title">Webinars</h1>                    
        </div>
      </div>
    </div>    
  </div>
</section>-->

<section id="portfolio_columns" class="light_section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="portfolioWrap">
          <div class="MY-isotopeFiltr">
            <ul style="padding-top: 0px">
              <li id="upWebinarLi" class="squareButton active">
                <a id="upWebinar" href="javascript:void(0);" data-filter="" onclick="myFunction('1');">Upcoming Sessions</a>
              </li>
              <li id="paWebinarLi" class="squareButton">
                <a id="paWebinar" href="javascript:void(0);" data-filter="" onclick="myFunction('2');">Past Sessions</a>
              </li>             
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


  
<section id="portfolio_columns" class="light_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="padding: 0px;">
                <div class="portfolioWrap">                   
                    <div class="masonry isotope" data-columns="3" style="">

                    
                    <?php 
                      if(!empty($up_webinar)){ ?>
                          <?php 
                              $i=1; foreach($up_webinar as $wd) 
                               {   
                                if(($i % 2) == 0){ $po='even';}else{$po='odd'; }
							?>
                      
                      		<article class="col-lg-4 col-sm-6 mb-2 mb-lg-0 px-1 isotopeElement" style="padding-bottom: 30px;">
                          <!--<div class="col-lg-4 col-sm-6 mb-2 mb-lg-0 <?php //echo $po;?> px-1" >-->
                              <div class="isotopePadding bg_post">
<!--<a title="Detail" href="<?php //echo base_url();?>resource/detailwebinars/<?php //echo $wd['webinar_title'];?>">-->
                                  <div class="thumb hoverIncrease hoverTwo inited" data-link="#" data-image="<?php echo base_url();?>uploads/webinar/<?php echo $wd['image'];?>" data-title="Sapien etiam faucibus euismod">
                                      <img alt="<?php echo $wd['webinar_title']; ?>" src="<?php echo base_url();?>uploads/webinar/<?php echo $wd['image'];?>">         
                                      <span class="hoverShadow"></span>
                                      <!--<div class="wrap_hover">
                                          <a href="<?php echo base_url();?>uploads/webinar/<?php //echo $wd['image'];?>" title="<?php // echo $wd['webinar_title']; ?>" class="inited p-view prettyPhoto" data-gal="prettyPhoto[gal]">
                                              <span class="hoverIcon"></span>
                                          </a>
                                          
                                              <span class="hoverLink"></span>
                                          
                                      </div>-->
                                  </div>
<!--</a>-->
                                  <div class="post_wrap">
                                      <h4>
                                         <?php 
                                       if(strlen($wd['webinar_title']) > 35)
                                       {
                                          echo substr($wd['webinar_title'], 0, 35);
                                          echo "...";
                                       }
                                       else
                                       {
                                          echo substr($wd['webinar_title'], 0, 35);
                                       }
                                        ?> 
                                      </h4>           
                                    
                                      <?php if(!empty($this->session->userdata('front_user_id'))) { ?>
                                    		<a href="<?php echo base_url();?>resource/detailwebinars/<?php echo $wd['webinar_title'];?>" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn attendbtn regBtn" style="padding: 15px; margin-bottom: 15px;">Attend</a>
                                      <?php } else{ ?>
                                    		<a href="<?php echo base_url();?>my_default/index/<?php echo $redirect_page_name; ?>" class="squareButton sc_button_style_accent_2 accent_2 big contact-btn attendbtn regBtn" style="padding: 15px; margin-bottom: 15px;">Register</a>
                                      <?php } ?>
                                  </div>
                              </div>
                            </article>
                          <!--</div>--> 
                          <?php   
                                   $i++; 
                               }  
                           ?> 
                          <?php } else { echo 'No upcoming sessions, take a look at past sessions by clicking on "Past Sessions”.'; } ?>
                        </div>                     
                     </div>
                 </div>             
             </div>
         </div>
     </section>
 </div>
<!--<section id="skills" class="light_section">
    <div class="container">
      <div class="row">
         <div class=" text-center">
            <span class="squareButton comm sc_button_size_big accent_2 big">       
              <a data-target="#createNew" data-toggle="modal" onclick="get_project_id('0');"> REGISTER </a> 
            </span>
         </div>
      </div>            
    </div>
  </section>-->

<script>
  function myFunction(type) 
  {   
    $.ajax({
      url: '<?php echo base_url();?>resource/get_webinar/'+type,
      type: 'POST'
    })
    .done(function(responce) {   
      $('.container .portfolioWrap .masonry').html(''); 
      $('.container .portfolioWrap .masonry').html(responce); 
    })
  }
</script>

<?php $this->load->view('template/footer');?>
 <script>
    function get_project_id(id) {
     $('#PID').val(id);
    }
  </script>

  <script src="<?php echo base_url();?>front_assets/js/formValidation.min.js"></script>
  <script src="<?php echo base_url();?>front_assets/js/framework/bootstrap.js"></script>

<script>

 $(document).ready(function() {
 $('#add_detail').on('init.field.fv', function(e, data) {
             // data.fv      --> The FormValidation instance
             // data.field   --> The field name
             // data.element --> The field element
             var $parent = data.element.parents('.form-group'),
                 $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');
             // You can retrieve the icon element by
             // $icon = data.element.data('fv.icon');
             $icon.on('click.clearing', function() {
                 // Check if the field is valid or not via the icon class
                 if ($icon.hasClass('glyphicon-remove')) {
                     // Clear the field
                     data.fv.resetField(data.element);
                 }
             });
         }).formValidation({
   message: 'This value is not valid',
     icon: {
           valid: 'glyphicon glyphicon-ok',
           invalid: 'glyphicon glyphicon-remove',
           validating: 'glyphicon glyphicon-refresh'
     },
   trigger: 'keyup',
   verbos:'false',
   fields: {
             name: {
                         message: 'User name is not valid',
                         validators: {
                               notEmpty: {
                               message: 'User name is required and cannot be empty'
                               },
                          stringLength: {
                               min: 4,
                               message: 'User name must be more than 4 characters'
                               },
                         
                             }
                        },

                 lname: {
                             message: 'User Last name is not valid',
                             validators: {
                                   notEmpty: {
                                   message: 'User Last name is required and cannot be empty'
                                   },
                              stringLength: {
                                   min: 4,
                                   message: 'User Last name must be more than 4 characters'
                                   },
                             regexp: {
                                 regexp: /^[a-zA-Z0-9_\.]+$/,
                                 message: 'User name can only consist of alphabetical, number, dot and underscore'
                                     }
                                 }
                            },
                 email: {
                 validators: {
                         notEmpty: {
                                 message: 'The email id is required and cannot be empty'
                         },
                         emailAddress: {
                                regexp:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                                 message: 'The input is not a valid email address'
                              }
                         }
                 },

                 contact: {
                             message: 'User contact is not valid',
                             validators: {
                                   notEmpty: {
                                   message: 'User contact is required and cannot be empty'
                                   },
                              stringLength: {
                                   min: 10,
                                   message: 'User contact must be more than 10 numbers'
                                   },
                             regexp: {
                                 regexp: /^[0-9_\.]+$/,
                                 message: 'User contact can only consist of number'
                                     }
                                 }
                            }




         }        
     });
 });

 </script>
<script>
  
$(document).ready(function () {
    $('.isotopeElement').css('position', 'unset');
});
  
  $('#upWebinar').on('click', function () {
$('#paWebinarLi').removeClass( "active" );
     $('#upWebinarLi').addClass( "active" );
 });
  
$('#paWebinar').on('click', function () {
$('#upWebinarLi').removeClass( "active" );
     $('#paWebinarLi').addClass( "active" );
 });

</script>


























