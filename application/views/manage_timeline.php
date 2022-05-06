<?php $this->load->view('template/header');?>
<link href="<?php echo base_url(); ?>assets/timeline/css/flat.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/timeline/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/timeline/css/lightbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/timeline/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

<!--[if lt IE 9]>
<link href="css/ie8fix.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/js/jquery.timeline.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/js/image.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/timeline/js/lightbox.js"></script>
<script type="text/javascript">

$(window).load(function() {
  // light
  $('.tl1').timeline({
    openTriggerClass : '.read_more',
    startItem : '15/08/2012',
    closeText : 'x',
    ajaxFailMessage: 'This ajax fail is made on purpose. You can add your own message here, just remember to escape single quotes if you\'re using them.'
  });
  $('.tl1').on('ajaxLoaded.timeline', function(e){
    var height = e.element.height()-60-e.element.find('h2').height();
    e.element.find('.timeline_open_content span').css('max-height', height).mCustomScrollbar({
      autoHideScrollbar:true,
      theme:"light-thin"
    }); 
  });
  
});

</script>
<style>
.navbar {
    background-color:rgb(0,0,0);
  }

	 .box{
	 	overflow: visible;
	 	opacity: 1;
	 }
	 .like .dropdown-menu{
	padding: 0;
	margin-left: -50px;
	 }
	 .like .dropdown-menu li{
	 	border-bottom: 1px solid #ccc;
	 	    color: #252525;
	 	    cursor: pointer;
	 	    padding: 5px 5px 5px 10px;
	 }
	 .like .dropdown-menu li:hover{
	 	background: #f4f4f4;
	 }
	 .like > .dropdown-menu{
	 	max-height: 170px !important;
	 	overflow-y: scroll;
	 }
</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>">
							Home
						</a>
					</li>
					<li>
						<a href="<?php echo base_url()?>user/userDetail/<?php echo$user_profile->id?>">
							<?php
							if(isset($user_profile->firstName) && $user_profile->firstName != ''){
								echo ucwords($user_profile->firstName);
							}?> <?php
							if(isset($user_profile->lastName) && $user_profile->lastName != ''){
								echo ucwords($user_profile->lastName);
							}?>’s Portfolio
						</a>
					</li>

					<li class="active">
						<?php
						if(isset($user_profile->firstName) && $user_profile->firstName != ''){
							echo ucwords($user_profile->firstName);
						}?> <?php
						if(isset($user_profile->lastName) && $user_profile->lastName != ''){
							echo ucwords($user_profile->lastName);
						}?>’s Timeline
						
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="middle">
	<?php if(!empty($userInfo))
	{?>	
	  <div class="user-img" style="text-align:center">
	     <img class="img-circle" alt="image" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $userInfo[0]['profileImage'] ?>">
	     <h3><?php echo $userInfo[0]['firstName'] ?>&nbsp;&nbsp;<?php echo $userInfo[0]['lastName'] ?></h3>
	  </div>	
	<?php }  ?>

<?php if(!empty($complete_project))
{?>


<div class="timelineLoader">
  <img src="images/timeline/loadingAnimation.gif" />
</div>
<div class="timelineFlat tl1">
<?php foreach ($complete_project as $value) {
	$CI=& get_instance();
	$CI->load->model('timeline_model');
	$users_instutude_id = $CI->timeline_model->get_users_instutude_id($value['userId']);
	//print_r($users_instutude_id);die;
	if($users_instutude_id!='')
	{
		$usersInstutudeId = $users_instutude_id->instituteId;
	}
	else
	{
		$usersInstutudeId='';
	}

	$project_dateCount = $CI->timeline_model->getCount(date('Y-m-d', strtotime($value['created'])),$value['userId'],$usersInstutudeId);

  ?>
    <div class="item" data-id="<?php echo date('d/m/Y', strtotime($value['created'])); ?>" data-description="<?php echo $project_dateCount;?>">   
     <a class="image_rollover_bottom con_borderImage" data-description="ZOOM IN" href="<?php echo base_url()?>projectDetail/<?php echo $value['projectPageName']?>" rel="lightbox[timeline]">
           <img src="<?php echo file_upload_base_url();?>project/thumbs/<?php echo $value['image_thumb'];?>" alt="image"/>
           </a>
           <div class="time_proj_name">
              <a href="<?php echo base_url()?>projectDetail/<?php echo $value['projectPageName']?>"><h2><?php echo $value['projectName'];?></h2></a>
           </div>
           <div class="project-catagory">
            <h3><i class="fa fa-caret-square-o-right"></i>&nbsp;&nbsp;<?php echo $value['categoryName'];?></h3>
            <h3 class="project-owner"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $value['firstName'];?>&nbsp;&nbsp;<?php echo $value['lastName'];?></h3>            
           </div>
           <div class="timeline-footer row">
           <div class="col-md-4">
             <div title="Total Views" class="view">
              <i class="fa fa-eye"></i>&nbsp;<span><?php echo $value['view_cnt'];?></span>
             </div>
           </div>
           <!--<div class="col-md-4">
              <div title="Total Likes" data-like="1" data-id="1052" data-name="0" class="like like_div">
                <i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span"><?php echo $value['like_cnt'];?></span>
             </div>
           </div>-->
			<!-- <div class="col-lg-4 col-xs-4">
				<?php
				if($value['userLiked'] == 0){
					?>
					<div class="like like_div"  data-name="0" data-id="<?php if(!empty($value['id'])){ echo $value['id'];}else
						{ echo 0;}?>" data-like="<?php echo $value['like_cnt']; ?>" >
						<i class="fa fa-thumbs-o-up">
						</i>&nbsp;
						<span class="like_span">
							<?php echo $value['like_cnt']; ?>
						</span>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="like like_div"  data-name="0" data-id="<?php if(!empty($value['id'])){ echo $value['id'];}else
						{ echo 0;}?>" data-like="<?php echo $value['like_cnt']; ?>">
						<i class="fa fa-thumbs-up">
						</i>&nbsp;
						<span class="like_span">
							<?php echo $value['like_cnt']; ?>
						</span>
					</div>
					<?php
				}?>
			</div> -->

			<div class="col-md-4">
				<?php

				$totalLikeName = $this->db->select('B.firstName,B.lastName')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$value['id'])->where('A.userLike',1)->get()->result_array(); 

				//print_r($totalLikeName);die;

				if($value['userLiked'] == 0){
					?>
					<div class="like like_div dropdown"  data-name="0" data-id="<?php if(!empty($value['id'])){ echo $value['id'];}else
{ echo 0;}?>" data-like="<?php echo $value['like_cnt']; ?>" >
						<i class="fa fa-thumbs-o-up" id="like_div_id" >
						</i>&nbsp;
						<span class="like_span">
							<?php echo $value['like_cnt']; ?>
						</span>
						<ul class="dropdown-menu">
						<?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){?>
						  <li><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></li>							       
						  <?php }   }  ?>
						</ul>
					</div>
					<?php
				}
				else
				{						   
					?>	
					<div class="like dropdown " title="">
						<span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up "></i></span>
					<span class="like_span" >
						<?php echo $value['like_cnt']; ?>
					</span>	
					      <ul class="dropdown-menu">
					      
					      <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){?>
					        <li><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></li>							       
					        <?php }   }  ?>
					      </ul>
					      </div>	
					<?php
				}?>

			</div>	

           <div class="col-md-4">
           <div title="Total Project Images" class="photo">
             <i class="fa fa-picture-o"></i>&nbsp;<span><?php echo $value['imageCount'];?></span>
           </div>
           </div>
           </div>

    </div>
    <div class="item_open" data-id="27/06/2012" data-access="ajax-content-no-image.html">
      <div class="item_open_content">
        <img class="ajaxloader" src="<?php echo base_url(); ?>assets/timeline/images/timeline/loadingAnimation.gif" alt="image"/>
      </div>
    </div>
    <?php  }  ?>        
</div> <!-- /END TIMELINE -->

<?php  } 
else {  ?>

<div><h3 class="text-center">
<?php if($this->uri->segment(3) != ''){ echo "No More Projects Found. Hasn't Added Anything To Their Timeline. "; }else{ echo "No More Projects Found. Hasn't Added Anything To your Timeline. "; } ?>
</h3></div>
  <?php	
 } ?>
 </div>
</body>
<?php $this->load->view('template/footer');?>
<script>
$(".item").hover(function(){
   var val = $(this).data("id");
  console.log(val);       
  });        
</script>

<script>
	$('div.dropdown').hover(function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
	}, function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
	});
</script>
