<?php $this->load->view('template/header'); ?>

<style>

  .contact-btn:hover

  {

    color: #fff;

  }

  .regBtn {

    height: 35px;

    padding-top: 12px;

  }
  .datePost, .speakerdetls h4,.speakerdetls h5 {
    font-size: 17px;
    line-height: 25px;
    margin-bottom: 0;
        color: #000;


}
  .squareButton:hover {
    color: #ffffff!important;
    background-color: orangered!important;
    border-color: orangered!important;
}
  
.history_content .sc_title {
    margin-bottom: 0;
}


  .sc_title {
    padding: 0 0 20px 0;
}
  .about-content p {
    color: #000!important;
}


.about-content li, .entry-summary li, p {
    color: #000;
    text-align: left;
}
p {
    color: #252525;
    font-size: 17px;
    line-height: 25px;
    margin-bottom: 0;
}
  .event-name {
    text-align: left;
}
  .event-name h5, .event-region h5 {
    padding: 5px 0;
}

  .slide_description {
    display: inline-block;
    vertical-align: middle;
}
  .slider_textblock_center .slide_description {
    text-align: center;
    margin-right: 0;
}
.animated {
    visibility: visible!important;
}
  .flexslider h3 {
    font-size: 48px;
    line-height: 59px;
}
  .history_content {
     padding-top: 5px;
    padding: 15px 10px;
}
  
   #mainslider h3 {
    color: #fff;
}
  
.h5, h5 {
    font-size: 14px;
    line-height: 19px;
    padding: 0 0 25px 0;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin: 0;
    color: #232a34;
    -ms-word-wrap: break-word;
    word-wrap: break-word;
}
  .event-name {
    text-align: left;
}
  .event-region {
    text-align: right;
}
  #mainslider .slide_description_wrapper {
    position: absolute;
    top: 70px;
    bottom: 0;
    left: 0;
    right: 0;
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
  .about-content p {
    color: #000!important;
}


.about-content li, .entry-summary li, p {
    color: #000;
    text-align: left;
}
p {
    color: #252525;
    font-size: 17px;
    line-height: 25px;
    margin-bottom: 0;
}
  .squareButton.big {
    height: 50px;
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

.squareButton, input[type=button], input[type=submit] {
    height: 30px;
    list-style: none;
    display: inline-block;
    vertical-align: bottom;
    position: relative;
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
  .row+.row {
    margin-top: 20px;
}
.row {
    margin-right: 0px;
    margin-left: 0px;
}

</style>

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

                    <div data-animation="fadeInUp" class="animated fadeInUp">

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



<?php if(!empty($webinar)){ ?>

<section id="skills" class="light_section">

  <div class="container">   

    <?php foreach($webinar as $wd) { ?>

    <div class="row ">

      <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="history_content about-content">

          <h2 class="sc_title h2Title"><strong><?php echo $wd['webinar_title']; ?></strong></h2>

          <?php echo $wd['description']; ?>

          

          <div class="row" style="margin-top: 25px;">

            <div class="col-md-3 col-sm-12">

              <div class="images">

                <a href="<?php echo base_url();?>uploads/webinar/<?php echo $wd['image'];?>" class="inited p-view prettyPhoto" data-gal="prettyPhoto[gal]">

                  <img src="<?php echo base_url();?>uploads/webinar/<?php echo $wd['image'];?>" class="attachment-shop_single wp-post-image" alt="<?php echo $wd['image'];?>" title="<?php echo $wd['image'];?>" style="margin-bottom: 15px;">

                </a>

              </div>

            </div>

            <div class="col-md-9 col-sm-12">

              <div class="summary entry-summary product">

                <!--<h4 class="product_title entry-title">Spreaker Details</h4>-->          

                <div class="speakerdetls">

                  <p><?php echo $wd['speaker_details']; ?></p>            

                </div>
                <br />
                <div class="speakerdetls">

                  <div class="event-name">

                    <h5><?php echo $wd['region']; ?></h5>

                    <span class="datePost"><b>Date :-</b> <?php echo date('m/d/Y', strtotime($wd['date'])); ?></span><br/>
                    <span class="datePost"><b>Time :-</b> <?php echo date('h:i a', strtotime($wd['time'])); ?></span>

                  </div>

                </div>
               
                
                

                <?php if($wd['registration_link']!=''){ ?>
                
                <?php //if($wd['video']!=''){ ?><!--<br>-->

                <div class=" text-center">
                  	<?php if(strtotime($wd['date']) >= strtotime(date("y-m-d"))){  ?>
                  	<?php if(!empty($this->session->userdata('front_user_id'))) { ?>
                    	<a class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;" href="<?php echo $wd['registration_link'];?>">Join Link</a>
                    <?php } else{ ?>
                  		<a class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" style="padding: 15px; margin-bottom: 15px;" href="<?php echo base_url();?>my_default">Register</a>
                    <?php } } ?>
                  	                  	


                    
                    
                   <!-- <a class="squareButton sc_button_style_accent_2 accent_2 big contact-btn regBtn" href="<?php //echo $wd['video'];?>">Webinar Link</a>-->
                    
                </div>

                <?php } ?>

              </div>

            </div>

          </div>

          <?php if($wd['video']!=''){?>

          <div class="row">

            <div class="col-sm-8 col-xs-offset-2">

              <!--<article class="isotopeElement bg_post post">-->

              <!--  <div class="post_thumb thumb video_2columns">-->

              <!--    <div class="sc_video_player">-->

              <!--      <div class="sc_video_frame">-->

                      <?php //$link =str_replace('/watch?v=','/embed/',strip_tags($wd['video']));?>

              <!--        <iframe width="760" height="428" src="<?php //echo $link;?>?rel=0" frameborder="0" allowfullscreen></iframe>-->

              <!--      </div>-->

              <!--    </div>-->

              <!--  </div>-->

              <!--</article>-->

            </div>

          </div>

          <?php  }  ?>

        </div>

      </div>

    </div>  

  </div>

</section>

<?php } }  ?>



<?php $this->load->view('template/footer');?>











