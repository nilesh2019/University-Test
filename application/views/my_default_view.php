<?php 
//echo "mydefaultview";exit();
$this->load->view('template/header_new');?>

<script type="text/javascript">

  $(document).ready(function(){
  $('.actionbuttons').each(function(){
    $(this).on('click', function(){
    localStorage.removeItem("justOnce");

      /*console.log("click");*/
      });

  });



});


</script>

<?php
/***** Redirect Coded added on Jul 9th *****/
if(!$_GET['is_loggedout']){
?>
<script type="text/javascript">




if(!$('#centerModel').hasClass('in')) {

/*  if (window.location.href.indexOf('welcome')==-1) {
     window.location.replace(window.location.href+'?welcome');
}*/


window.onload = function () {
    if (! localStorage.justOnce) {
        localStorage.setItem("justOnce", "true");
        /*window.location.reload();*/
    }
}



/*$(window).bind('load', function(ev){

  console.log($("#refreshed").val());
    if ($("#refreshed").val() === "no") {

          $("#refreshed").val("yes");

          if($("#refreshed").val() === "no"){
            location.reload();

          }


       //window.stop();

    } else{
      //$('#centerModel').modal('show');
    }
});*/
}
</script>
<?php }
 /********** ***/ ?>



<!-- <script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d3d7b55e-5d68-4dbc-9cfc-39905c9f57e7", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> -->
<!--crausal slider bottom-->
<link href="<?php echo base_url();?>assets/css/style_crowj.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>assets/css/style_testomo.css" rel="stylesheet"/>
<link href="<?php echo base_url();?>assets/css/owl.carousel.css" rel="stylesheet"/>
<style>
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

<?php
//redirect(base_url().'home');

?>
<!--crausal slider end-->
<!-- Header Carousel -->
<input name="refreshed" value="no" id="refreshed" type="hidden" />

<header id="myCarousel" class="carousel slide">
  <!-- Indicators -->
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <div class="fill">
        <img class="fill" src="<?php echo base_url();?>assets/images/landing_page.jpg" alt="image">
      </div>
    </div>
  </div>
</header>
<div class="social middle-bg" style="display: none;">
<div class="share-icon">
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 text-center">
      <h2 class="text-center">
      Share us on
      </h2>
<!--      <div class="col-md-2"></div>
      <div class="col-md-2 text-center">
        <a href=""><img class="" src="<?php echo base_url();?>assets/images/lin.png" alt=""></a>
      </div>
      <div class="col-md-2 text-center">
        <a href=""><img class="" src="<?php echo base_url();?>assets/images/gp.png" alt=""></a>
      </div>
      <div class="col-md-2 text-center">
        <a href=""><img class="" src="<?php echo base_url();?>assets/images/fbk.png" alt=""></a>
      </div>
      <div class="col-md-2 text-center">
        <a href=""><img class="" src="<?php echo base_url();?>assets/images/tw.png" alt=""></a>
      </div>
      <div class="col-md-2"></div> -->

      <span class='st_facebook_large' displayText='Facebook'></span>
      <span class='st_twitter_large' displayText='Tweet'></span>
      <span class='st_googleplus_large' displayText='Google +'></span>
      <span class='st_pinterest_large' displayText='Pinterest'></span>
      <span class='st_email_large' displayText='Email'></span>
      <span class='st_linkedin_large' displayText='LinkedIn'></span>
      <span class='st_whatsapp_large' displayText='WhatsApp'></span>
    </div>
  </div>
</div>
</div>
</div>

<?php if(isset($terms_and_condition) && $terms_and_condition!='') { ?>
<input type="hidden" name="terms_and_cond" id="terms_and_cond" value="<?php echo $terms_and_condition; ?>">
<?php }  ?>


  <!-- <div id="centerModel" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Please select the center</h4>
        </div>
        <div class="modal-body">
          <div class="row center-select">
            <div class="col-md-6" style="border-right:2px solid ">
              <a href="<?php //echo base_url()?>hauth/center_name/1">
                      <img style="width: 241px; margin-left: 10px;margin-top: 10px;" title="Home" alt="logo" src="<?php //echo base_url();?>assets/images/logo.png" >
                      <div class="img-cap">Arena</div>
                </a>
            </div>
            <div class="col-md-6">
              <a href="<?php //echo base_url()?>hauth/center_name/2">
                   <img style="width: 241px; margin-left: 10px;margin-top: 10px;" title="Home" alt="logo" src="<?php //echo base_url();?>assets/images/logo_m.png">
                      <div class="img-cap">MAAC</div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!-- <div id="creativeMind" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:400px">
      <div class="modal-content">
        <div class="modal-header" style="padding:5px">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 style="text-align:center;margin-top:0px;margin-bottom:0px">Creative Mind 2018</h3>
        </div>
        <div class="modal-body" style="text-align:center;padding:0px">
          <img src="<?php echo base_url();?>assets/images/creative_mind.jpg" style="width:100%">
        </div>
      </div>
    </div>
  </div> -->

<?php $this->load->view('template/footer_new');?>
<script type="text/javascript">
          $(document).ready(function(){
            $('#creativeMind').modal('show');
var scroll_start = 0;
var startchange = $('nav');
var offset = startchange.offset();
$(document).scroll(function() {
scroll_start = $(this).scrollTop();
if(scroll_start > offset.top) {
$('nav').css('background-color', 'rgba(0,0,0,0.8)');
$('nav').css('transition', '0.3s');
} else {
$('nav').css('background-color', 'transparent');
}
});
});
</script>
<!-- Script to Activate the Carousel -->
<script>
  $('.carousel').carousel(
    {
      interval: 5000 //changes the speed
    })
</script>

<!--Counter-->

<!--Testomonial Slider-->
<script src="<?php echo base_url();?>assets/js/masonry.pkgd.min.js">
</script>
<script src="<?php echo base_url();?>assets/js/jquery.flexslider-min.js">
</script>
<script src="<?php echo base_url();?>assets/js/main.js">
</script>
<!--Crowsel slider bottom-->

<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/owl.carousel.js"></script>
<script type="text/javascript">
   var date = new Date();
      $("#start_date").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
      });
      $("#end_date").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
      });
</script>
<script>
  $(document).ready(function() {
<?php
if(!empty($jobs))
{
?>
var owl1 = $("#owl-slider1");
owl1.owlCarousel({
autoPlay: 5000,
items : 6, //10 items above 1000px browser width
itemsCustom : false,
itemsDesktop : [1199,3],
itemsDesktopSmall : [980,3],
itemsTablet: [768,3],
itemsTabletSmall: false,
itemsMobile : [479,1],
singleItem : false,
itemsScaleUp : false,
pagination : false,
navigation : true
});
<?php }
if(!empty($compition))
{
?>
var owl2 = $("#owl-slider2");
owl2.owlCarousel({
autoPlay: false,
items : 3, //10 items above 1000px browser width
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
<?php }
if(!empty($event))
{
?>
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
<?php } ?>
});
</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56b0bc237eb112d2"></script>
<script>
  function openProject()
  {
    <?php $FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
    if($FRONT_USER_SESSION_ID == 0)
          {  ?>
            window.location.href = '<?php echo base_url();?>hauth/googleLogin';
    <?php } else{
      ?>
      jQuery('#add_project_button').click();
    <?php } ?>
  }
</script>
<script>
  jQuery(document).ready(function($) {
    <?php if(isset($terms_and_condition) && $terms_and_condition!='') { ?>
      $('#myModal').modal('show');
    <?php }  ?>
    /*<?php if($this->session->userdata('guest_user') && $this->session->userdata('guest_user')=='guest_user' && !$_GET['is_loggedout']) { ?>

     // $('#centerModel').modal('show');
     window.location.href = '<?php echo base_url()?>hauth/center_name/1';
    <?php }  ?>*/
  });
</script>

<script>
  function termsAndConditions()
  {
    var terms_and_conditions = $('input:checkbox:checked').val();
    $.ajax({
      url: "<?php echo base_url();?>hauth/terms_and_conditions",
      data: { checked_box : $('input:checkbox:checked').val()},
      type: "POST",
    })
    .done(function() {
      console.log("success");
    });

  }
</script>
<script src="<?php echo base_url();?>assets/js/numscroller-1.0.js">
</script>

