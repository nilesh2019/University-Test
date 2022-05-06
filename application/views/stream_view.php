<?php $this->load->view('template/header');

 error_reporting(E_ALL); ini_set('display_errors', 1);

 ?>
<style>
.pointer1
{
  cursor: pointer;
}
.navbar {
  background-color:rgb(0,0,0);
  /*display: none;*/
}

#showSpinner{
  margin-top: -55px;
}

</style>
<!--Scroll Bar-->
<!--Scroll Bar-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-tInstitutesime-line/line-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line/line-awesome-font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line_js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line_js/slick/slick-theme.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom-time-line/responsive.css">
<!--Scroll Bar End-->
<div class="middle">

  <?php

  $this->CI =& get_instance();

  $this->CI->load->model('model_basic');

  $FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));



  $profileImage = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"profileImage"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $firstName = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"firstName"," `id` = '".$FRONT_USER_SESSION_ID."'");
  $lastName = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"lastName"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $profession = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"profession"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $userCompany = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"company"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $type = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"type"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $users_work = $this->CI->model_basic->getCompanyValue($this->CI->db->dbprefix('users_work'),"*"," `user_id` = '".$FRONT_USER_SESSION_ID."'");


  $followingUserData = $this->CI->model_basic->getCountWhere('user_follow',array('followingUser'=>$FRONT_USER_SESSION_ID));

  $view_like_cnt = $this->CI->user_model->getViewLikeCnt($FRONT_USER_SESSION_ID);
  $followers=$this->CI->user_model->getFollowers($FRONT_USER_SESSION_ID);
  $following=$this->CI->user_model->getFollowing($FRONT_USER_SESSION_ID);
  $overAllRating = $this->CI->user_model->overAllProjectRating($FRONT_USER_SESSION_ID);


  $userworklists = $this->CI->stream_model->getUserWoksList($FRONT_USER_SESSION_ID);



  $peoples = $this->CI->model_basic->getAllPeopleData();
  $this->load->model('event_model');
  $this->load->model('competition_model');
  
  $event = $this->CI->event_model->getAllEventData();

  //echo "<pre>";print_r($event);die;


  //$competition = $this->competition_model->getAllCompetionData();
  $competition = $this->CI->competition_model->getAllCompetionData();

  $this->load->model('institute_model');
  $institute= $this->CI->institute_model->getUserSpecificInstituteData($FRONT_USER_SESSION_ID);


  $this->load->model('myboard_model');

  $job = $this->CI->myboard_model->getLimitedJob();



  $trandingProjects = $this->CI->stream_model->getAllTrendingProjectData(1);
  $trandingProjectsPeple = $this->CI->stream_model->getAllTrendingProjectData();

  $followingUsers = $this->CI->stream_model->getFollowingUsers();
  //$followers = $this->CI->stream_model->getFollowers($FRONT_USER_SESSION_ID);



  $currentUserLikeedUsers = array_column($followingUsers, 'followingUser');

//   if(!empty($currentUserLikeedUsers)){
//   $getFollowingUsersLikedProjects = $this->CI->stream_model->getFollowingUsersLikedProjects($currentUserLikeedUsers,1);
// } else{
//   $getFollowingUsersLikedProjects = [];
// }
//

$getSort = isset($_GET['sort'])?$_GET['sort']: 0;

if($getSort == 3){
$getFollowingUsersLikedProjects = [];
} else{
  $getFollowingUsersLikedProjects = $this->CI->stream_model->getFollowingUsersLikedProjects($currentUserLikeedUsers,0, $getSort);
}


// print_r($getFollowingUsersLikedProjects);
// exit;



  $blog = $this->CI->stream_model->getAllStrsmBlogData();


$pid = $this->db->select('uv.projectId, count(uv.userLike)')->from('project_master as pm')->join('user_project_views as uv','pm.id = uv.projectId')->where('pm.userId',$FRONT_USER_SESSION_ID)->group_by('uv.projectId')->get()->result_array();


if(!empty($pid))
$getMostLikedProjectData = $this->CI->stream_model->getProjectDetailsByProjectID($pid[0]['projectId']);



//print_r($getFollowingUsersLikedProjects);
//print $FRONT_USER_SESSION_ID;



/**
 * [get_time_ago description]
 * @param  [type] $time [description]
 * @return [type]       [description]
 */
function get_time_ago( $time )
{
  $time_difference = time() - $time;

  if( $time_difference < 1 ) { return 'less than 1 second ago'; }
  $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach( $condition as $secs => $str )
  {
    $d = $time_difference / $secs;

    if( $d >= 1 )
    {
      $t = round( $d );
      return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
    }
  }
}
?>
<div class="wrapper custom-time-line">
<?php if($getSort == 3){?>
<div id="hideForthree" data-value="3"></div>
<?php  } ?>


  <main>
    <div class="main-section">
      <div class="container">
        <div class="main-section-data">
          <div class="row">
            <div class="col-lg-3 col-md-3 pd-left-none no-pd">
              <div class="main-left-sidebar no-margin">
                <div class="ad-fixes-height">
                <div class="user-data full-width">
                  <div class="user-profile">
                    <div class="username-dt" style="background:url('<?php if(!empty($getMostLikedProjectData)) { echo file_upload_base_url().'project/thumbs/'.end($getMostLikedProjectData)['image_thumb']; } else {?> <?php  echo base_url();?>assets/images/active-activity-beach-40815.jpg <?php } ?>') no-repeat; background-size:cover">
                      <div class="usr-pic">

                        <?php

                        if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)

                        {

                          ?>

                          <img  alt="image" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>" title="Profile Completion"/>

                          <?php

                        }

                        else

                        {

                          ?>

                          <img alt="image" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />

                          <?php

                        }?>
                      </div>
                    </div><!--username-dt end-->
                    <div class="user-specs">
                      <h3><i><?php echo $firstName.' '.$lastName;?></i> <a title="Edit Profile" class="pull-right edit_links"  href="<?php echo base_url();?>profile/edit_profile">
                        <i class="fa fa-pencil">
                        </i>
                      </a></h3>

                      <?php if($type == 0){ ?>
                      <span>Student</span>
                      <?php  } else { ?>
                      <span>
                        <?php
                      if(!empty($profession)){
                        echo $profession;
                      } else {?>
                        <a href="<?php echo base_url();?>profile/edit_profile" class="addprefsion" style="color: #00a2ed !important;">Add Profession</a>
                        <?php }?>
                      </span>
                      <?php  } ?>

                    </div>
                  </div><!--user-profile end-->
                    <!-- <ul class="user-fw-status">
                      <li>
                        <h4>Following</h4>
                        <span><?php echo $followingUserData;?></span>
                      </li>
                      <li>
                        <h4>Followers</h4>
                        <span>155</span>
                      </li>
                      <li>
                        <a href="#" title="">View Profile</a>
                      </li>
                    </ul>
                  -->
                  <div class="project-viewer row">
                    <div class="col-md-3 project_view meta-p flow-margin">
                      <i class="fa fa-eye">
                      </i>&nbsp;
                      <span>
                        <?php
                        if(!empty($view_like_cnt) && $view_like_cnt[0]['views'] != ''){
                          echo $view_like_cnt[0]['views'];
                        }
                        else
                        {
                          echo 0;
                        }?>
                      </span>
                    </div>
                    <div class="appreciations col-md-3 meta-p flow-margin">
                      <i class="fa fa-thumbs-o-up">
                      </i> &nbsp;
                      <span>
                        <?php
                        if(!empty($view_like_cnt) && $view_like_cnt[0]['likes'] != ''){
                          echo $view_like_cnt[0]['likes'];
                        }
                        else
                        {
                          echo 0;
                        }?>
                      </span>
                    </div>

                    <div class="following col-md-4 meta-p flow-margin">
                  <!--<i class="fa fa-eye">
                  </i>--><i class="fa fa-user"></i>&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;
                  <span>
                    <?php
                    if(!empty($following)){
                      echo $following[0]['following'];
                    }
                    else
                    {
                      echo 0;
                    }?>
                  </span>
                </div>

                <div class="follower col-md-4 meta-p flow-margin">
                  <!--<i class="fa fa-eye">
                  </i>--><i class="fa fa-user"></i>&nbsp;<i class="fa fa-arrow-left"></i>&nbsp;
                  <span>
                    <?php
                    if(!empty($followers)){
                      echo $followers[0]['followers'];
                    }
                    else
                    {
                      echo 0;
                    }?>
                  </span>
                </div>
                <div class="rating col-md-12 meta-p">
                  <?php

                  /*  print_r($overAllRating);die;*/
                  if(!empty($overAllRating))
                  {
                    $rate = $overAllRating[0]['avg'];
                  }
                  else
                  {
                    $rate = 0;
                  }
                  ?>
                  <i class="fa fa-star"></i>&nbsp;Rating
                  <span>
                    <input id="overAllRating" value="<?php echo $rate?>" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs">
                  </span>
                </div>
              </div>
              <a href="<?php echo base_url();?>profile" title="" class="new_profilelink">View Profile</a>

            </div><!--user-data end-->


            <?php if($type == 0){?>
            <div class="widget widget-jobs institutes-list">
              <div class="sd-title">
                <h3>My Institute  &nbsp; <span class="fa fa-graduation-cap" aria-hidden="true"></span></h3>
                <i class="la la-ellipsis-v"></i>
              </div>
              <div class="jobs-list">

                <?php

                if(!empty($institute)){
                  foreach($institute as $row){
                    ?>
                    <div class="job-info">
                      <a href="<?php echo base_url().$row['pageName'];?>" >

                        <?php
                        if($row['instituteLogo'] != '' && file_exists(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) && filesize(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) > 0)
                        {
                          ?>
                          <img class="inst_cover_image" src="<?php echo file_upload_base_url();?>institute/instituteLogo/<?php echo $row['instituteLogo'];?>" alt="">
                          <?php
                        }
                        else
                        {
                          ?>
                          <img class="inst_cover_image" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >
                          <?php
                        } ?>

                      </a>
                      <div class="job-details">
                        <a href="<?php echo base_url().$row['pageName'];?>" >
                          <?php
                          if($row['instituteLogo'] != '' && file_exists(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) && filesize(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) > 0)
                          {
                            ?>
                            <img class="media-object inst_logo" src="<?php echo file_upload_base_url();?>institute/instituteLogo/<?php echo $row['instituteLogo'];?>" alt="image">
                            <?php
                          }
                          else
                          {
                            ?>
                            <img class="media-object img-circle inst_logo" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >
                            <?php
                          } ?>
                        </a>
                        <h3><a href="<?php echo base_url().$row['pageName'];?>">
                          <?php echo $row['instituteName'];?>
                        </a></h3>
                        <div class="media-body">
                          <h4 class="media-heading">
                            <?php
                            if(isset($row['address']) && !empty($row['address'])){
                              $atr = $row['address'];
                              if(strlen($atr) > 70)
                              {
                                $dot = '..';
                              }
                              else
                              {
                                $dot = '';
                              }
                              $position = 70;
                              echo $post2 = substr($atr, 0, $position).$dot;
                            }
                            else
                            {
                              echo '&nbsp;';
                            }
                            ?>
                          </h4>

                        </div>

                      </div>

                    </div><!--job-info end-->

                    <?php  }?>

                    <?php  } else {?>
                    <p class="event-notfound">No Institues found</p>

                    <?php } ?>


                  </div><!--jobs-list end-->
                </div><!--widget-jobs end-->
                <?php } elseif($type == 1){?>

                <div class="widget widget-jobs institutes-list">
                  <div class="sd-title">
                    <h3>My Company  &nbsp; <span class="fa fa-black-tie" aria-hidden="true"></span></h3>
                    <i class="la la-ellipsis-v"></i>
                  </div>
                  <div class="jobs-list">
                    <img class="inst_cover_image no-image" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >


                  </div><!--jobs-list end-->
                    <div class="job-details">

                    <?php if(empty($userworklists)){?>
                     <h4><a href="<?php echo base_url();?>profile/edit_profile">Update your current work experience </a></h4>


                        <?php  } else{ ?>

                         <img class="media-object img-circle inst_logo" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >

                        <h3>
                          <?php echo end($userworklists)['organisation'];?>

                        </h3>
                        <div class="media-body">
                          <h5 class="media-heading">
                             <!-- Address goes here -->
                              <?php echo end($userworklists)['w_address'];?>
                          </h5>

                        </div>

                        <?php  } ?>

                      </div>
                </div><!--widget-jobs end-->

                <?php  } else{?>

                <div class="widget widget-jobs institutes-list">
                  <div class="sd-title">
                    <h3>My Company  &nbsp; <span class="fa fa-black-tie" aria-hidden="true"></span></h3>
                    <i class="la la-ellipsis-v"></i>
                  </div>
                  <div class="jobs-list">
                    <img class="inst_cover_image no-image" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >


                  </div><!--jobs-list end-->
                    <div class="job-details">

                            <img class="media-object img-circle inst_logo" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" >

                        <h3>
                          <?php echo $userCompany;?>
                        </h3>
                        <div class="media-body">
                          <h4 class="media-heading">
                             <!-- Address goes here -->
                          </h4>

                        </div>

                      </div>
                </div><!--widget-jobs end-->

                <?php  } ?>
</div>
<!-- Advertisement -->
                 <div class="widget widget-jobs institutes-list ad-fixes">
              <div class="sd-title">
                <h3>Kung Fu Dhamaka (Book on BookMyShow)</h3>
              </div>
              <div class="jobs-list">
                    <div class="job-info">
                      <a href="https://in.bookmyshow.com/mumbai/movies/chhota-bheem-kung-fu-dhamaka/ET00075945?type=coming-soon" target="_blank">
                         <!--    <img class="ad-image img-circle " src="<?php //echo base_url();?>creosouls_admin/backend_assets/img/noimage1.png" alt="institute" > -->
                             <img class="ad-image img-circle " src="http://in.bmscdn.com/events/moviecard/ET00075945.jpg" alt="BookMyShow" >
                        </a>
                      </div>

                    </div>

                </div><!--widget-jobs end-->

              </div><!--main-left-sidebar end-->
            </div>

            <!-- Time line -->
            <div class="col-lg-6 col-md-8 no-pd">
              <div class="main-ws-sec">
                <div class="post-topbar">
                  <div class="user-picy">

                    <?php

                    if(file_exists(file_upload_s3_path().'users/thumbs/'.$profileImage) && filesize(file_upload_s3_path().'users/thumbs/'.$profileImage) > 0)

                    {

                      ?>

                      <img  src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $profileImage;?>" title="Profile Completion"/>

                      <?php

                    }

                    else

                    {

                      ?>

                      <img alt="image" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" />

                      <?php

                    }?>
                  </div>
                  <div class="post-st">
                    <ul>
                      <li><a class="add_project_button" href="#" title="">Post a Project</a></li>
                      <!-- <li><a class="post-jb active" href="#" title="">Post a Job</a></li> -->
                    </ul>
                  </div><!--post-st end-->
                </div><!--post-topbar end-->

                <!-- Filter and sort -->
                                            <div class="post-topbar sort-bars">
                                  <div class="user-picy">

                                  </div>
                                  <div class="post-st">

                                  <b>Sort/Filter By:</b>
                                  <div class="form-group1" style="display: inline-block;">
                                  <select class="form-control" id="sorts_change"  name="filter_sort" data-show-icon="true" >
                                  <option value="0" <?php if( isset($_GET['sort']) && $_GET['sort'] == 0) { echo "selected"; } ?>>Latest</option>
                                  <option value="1" <?php if( isset($_GET['sort']) && $_GET['sort'] == 1) { echo "selected"; } ?>>Trending Projects</option>
                                  <option value="2" <?php if( isset($_GET['sort']) && $_GET['sort'] == 2) { echo "selected"; } ?>> My Followings</option>
                                  <option value="3" <?php if( isset($_GET['sort']) && $_GET['sort'] == 3) { echo "selected"; } ?>> Blog/News</option>
                                  </select>
                                  </div>

                  </div><!--post-st end-->
                </div><!--post-topbar end-->


                <div class="posts-section">
                    <!-- <div class="post-bar">
                      <div class="post_topbar">
                        <div class="usy-dt">
                          <img src="http://via.placeholder.com/50x50" alt="">
                          <div class="usy-name">
                            <h3>John Doe</h3>
                            <span><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/clock.png" alt="">3 min ago</span>
                          </div>
                        </div>
                        <div class="ed-opts">
                          <a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
                          <ul class="ed-options">
                            <li><a href="#" title="">Edit Post</a></li>
                            <li><a href="#" title="">Unsaved</a></li>
                            <li><a href="#" title="">Unbid</a></li>
                            <li><a href="#" title="">Close</a></li>
                            <li><a href="#" title="">Hide</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="epi-sec">
                        <ul class="descp">
                          <li><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/icon8.png" alt=""><span>Epic Coder</span></li>
                          <li><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/icon9.png" alt=""><span>India</span></li>
                        </ul>
                        <ul class="bk-links">
                          <li><a href="#" title=""><i class="la la-bookmark"></i></a></li>
                          <li><a href="#" title=""><i class="la la-envelope"></i></a></li>
                        </ul>
                      </div>
                      <div class="job_descp">
                        <h3>Senior Wordpress Developer</h3>
                        <ul class="job-dt">
                          <li><a href="#" title="">Full Time</a></li>
                          <li><span>$30 / hr</span></li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam luctus hendrerit metus, ut ullamcorper quam finibus at. Etiam id magna sit amet... <a href="#" title="">view more</a></p>
                        <ul class="skill-tags">
                          <li><a href="#" title="">HTML</a></li>
                          <li><a href="#" title="">PHP</a></li>
                          <li><a href="#" title="">CSS</a></li>
                          <li><a href="#" title="">Javascript</a></li>
                          <li><a href="#" title="">Wordpress</a></li>
                        </ul>
                      </div>
                      <div class="job-status-bar">
                        <ul class="like-com">
                          <li>
                            <a href="#"><i class="la la-heart"></i> Like</a>
                            <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="">
                            <span>25</span>
                          </li>
                          <li><a href="#" title="" class="com"><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/com.png" alt=""> Comment 15</a></li>
                        </ul>
                        <a><i class="la la-eye"></i>Views 50</a>
                      </div>
                    </div> --><!--post-bar end-->

                    <?php if(!empty($trandingProjectsPeple)){?>
                    <div class="top-profiles top-profile-after-div">
                      <div class="pf-hd">
                        <h3>Top Profiles</h3>
                        <i class="la la-ellipsis-v"></i>
                      </div>
                      <div class="profiles-slider">

                        <?php


                        $i = 1;
                        foreach($trandingProjectsPeple as $user)
                        {


  if(($user['userId']) != $FRONT_USER_SESSION_ID)
  {
    ?>

    <div class="user-profy">
      <?php
      if(file_exists(file_upload_s3_path().'users/thumbs/'.$user['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$user['profileImage']) > 0)   {
        ?>
        <img class="top_people_follow_list" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $user['profileImage']?>">
        <?php }else{?>
        <img class="top_people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="image">
        <?php } ?>          <h3><?php
        if($user['firstName'] != ''){
          $fullname = $user['firstName'].' '.$user['lastName'];
        }
        else
        {
          $fullname= '';
        }
        if($fullname!= '')
        {
          $atr = $fullname;
          if(strlen($atr) > 20)
          {
            $dot = '..';
          }
          else
          {
            $dot = '';
          }
          $position = 20;
          echo $post2 = substr($atr, 0, $position).$dot;
        }
        else
        {
          echo '&nbsp;';
        }
        ?></h3>
        <span><?php
        if(isset($user['profession']) && $user['profession'] != ''){
          $atr = $user['profession'];
          if(strlen($atr) > 20)
          {
            $dot = '..';
          }
          else
          {
            $dot = '';
          }
          $position = 20;
          echo $post2 = substr($atr, 0, $position).$dot;
        }
        else
        {
          echo '&nbsp;';
        }?></span>
        <ul>
          <li><?php
          if(($user['userId']) != $this->session->userdata('front_user_id'))
          {
            $CI            =& get_instance();
            $CI->load->model('people_model');
            $followingUser = $CI->people_model->checkFollowingOrNot($user['userId']);
            if(!empty($followingUser))
            {
              ?>
              <form action="<?php echo base_url();?>user/unfollow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0?isStream=1" method="POST">
                <!--<input type="submit" name="submit" value="Following" class="fallow_unfallow btn  btn-danger"/>-->
                <button type="submit" name="submit" class="fallow_unfallow btn btn_orange">
                  <i class="fa fa-check"></i>&nbsp;Following
                </button>
              </form>
              <?php
            }
            else
            {
              ?>

              <form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0?isStream=1" method="POST">
                <input type="submit" name="submit" value="Follow" class="fallow_unfallow btn btn_blue"/>
              </form>
              <?php
            }
          }?></li>

        </ul>
        <a href="<?php echo base_url();?>user/userDetail/<?php echo $user['userId']?>" >View Profile</a>
      </div><!--user-profy end-->
      <?php
  }
      } ?>


    </div><!--profiles-slider end-->
  </div><!--top-profiles end-->

  <?php
  } ?>


  <!-- Blog Slider -->
  <?php if(!empty($blog)){?>
                    <div class="top-profiles blog-scroll">
                      <div class="pf-hd">
                        <h3>Latest Blogs</h3>
                        <i class="la la-ellipsis-v"></i>
                      </div>
                      <div class="profiles-slider">

                        <?php


                        $i = 1;
                        foreach(array_slice($blog,0,10) as $row)
                        {



    ?>

    <div class="user-profy">
                <img class="img-responsive img-hover blg-tm-img" src="<?php echo file_upload_base_url();?>blog/<?php echo $row['picture'];?>" alt="image">



        <h3><a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>"><?php echo substr($row['title'],0,35);?>...</a></h3>

        <ul class="bmeta">
          <li><span><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/clock.png" alt="image">&nbsp;<?php echo get_time_ago( strtotime($row['created']) ); ?></span></li>

        </ul>
        <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>" >Read More</a>
      </div><!--user-profy end-->
      <?php
  //}
      } ?>


    </div><!--profiles-slider end-->
  </div><!--top-profiles end-->

  <?php
  } ?>
  <?php if(isset($_GET['sort'])){?>
<input type="hidden" name="sort" id="getSort" value="<?php echo $_GET['sort'];?>">
<?php } ?>
  <!--  Project time line start -->

  <?php



  $p2 = array_merge($trandingProjects,$getFollowingUsersLikedProjects);



  //$projects = array_merge($project, $trandingProjects, $p2);



  $projectsLists = array_map("unserialize", array_unique(array_map("serialize", $getFollowingUsersLikedProjects)));





  $unique = array();

  foreach ($getFollowingUsersLikedProjects as $value)
  {
    $unique[$value['id']] = $value;
  }

  $finalListOfProject = array_values($unique);

  // Removing blogs
  $blog = [];
  $blog_projects= array_merge($finalListOfProject, $blog);



  $lcomments = array();
              foreach ($blog_projects as $key => $row)
              {
                //$price[$key]['name'] = $row->name;
                $lcomments[$key] = $row['created'];
              }
              array_multisort($lcomments, SORT_DESC, $blog_projects);



  //shuffle($blog_projects);
  //shuffle($finalListOfProject);
  //print_r($blog_projects);
  if(!empty($blog_projects)){
          $featureds = 1;

     // if(isset($_GET['sort']) && $_GET['sort'] == 1){
     //     $blog_projects = array_filter($blog_projects, function ($var) use ($featureds) {

     //             if(isset($var['featured'])){
     //                 return ($var['featured'] == 1);
     //             }
     //    });
     // }


     if(isset($_GET['sort']) && $_GET['sort'] == 2){

         $blog_projects = $this->CI->stream_model->getFollowingUsersLikedProjects($currentUserLikeedUsers,0,2);
          $lcomments = array();
              foreach ($blog_projects as $key => $row)
              {
                //$price[$key]['name'] = $row->name;
                $lcomments[$key] = $row['created'];
              }
              array_multisort($lcomments, SORT_DESC, $blog_projects);
     }



        if(isset($_GET['sort']) && $_GET['sort'] == 3){

         $blog_projects = $blog;
          $lcomments = array();
              foreach ($blog_projects as $key => $row)
              {
                //$price[$key]['name'] = $row->name;
                $lcomments[$key] = $row['created'];
              }
              array_multisort($lcomments, SORT_DESC, $blog_projects);
     }

    $i = 0;


    //$trjson=preg_replace('/([^{,:])"(?![},:])/', "$1".'\''."$2",json_encode($blog_projects));



    ?>


    <?php

    // print_r($blog_projects);
    // exit;
    foreach ($blog_projects as $row) {

      ?>


     <?php if(isset($row['posted_by'])) {?>

<div class="post-bar project-custom-bar" id="div_<?php echo $i;?>">
            <div class="post_topbar">
              <div class="usy-dt">
                <img class="people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="image">
                <div class="usy-name">
                  <h3><?php echo $row['posted_by'];?></h3>
                  <span><img alt="image" src="images/clock.png" alt=""><?php echo get_time_ago( strtotime($row['created']) ); ?></span>
                </div>
              </div>

            </div>

            <div class="job_descp">
              <h3> <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>"><?php echo $row['title'];?></a></h3>

              <p><?php echo substr(strip_tags($row['description']), 0, 150);?>... <a href="<?php echo base_url();?>blog/blogDetail/<?php echo $row['id'];?>" title="">view more</a></p>
              <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>">
                <img class="img-responsive img-hover blg-tm-img" src="<?php echo file_upload_base_url();?>blog/<?php echo $row['picture'];?>" alt="image">
              </a>



              <ul class="skill-tags">
                <li><a title="">Blog</a></li>

              </ul>
            </div>

            <div class="job-status-bar">
              <ul class="like-com">
                <li>
                  <div class="like dropdown" >
                    <div>
                      <span  class="sterm-project-like" ><i class="fa  fa-thumbs-o-up user-like" ></i></span>
                      <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="image">
                      <span>0</span>
                    </div>
                  </div>

                </li>
                <li>

                  <?php $comment = $this->CI->stream_model->getBlogCommentCount($row['id']) ;
                  ?>


                  <a  href="<?php echo base_url();?>blog/blogDetail/<?php echo $row['id'];?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt="image"> Comment <?php echo end($comment)['comment_cnt'];?></a></li>


                  <li>
                      <div class="dropdown pull-right sharelinks">

            <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url();?>blog/blogDetail/<?php echo $row['id'];?>" target="_blank" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url();?>blog/blogDetail/<?php echo $row['id'];?>" target="_blank">
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>


                </ul>
                <!--<a><i class="la la-eye"></i>Views 0</a>-->
              </div>
            </div>
      <?php  } else {?>



      <div class="post-bar project-custom-bar" id="div_<?php echo $i;?>">

        <div class="post_topbar">


          <?php
          //print_r($row);

          if(!empty($row['post_liked_by'])){
            $b=1;


          if(!in_array($FRONT_USER_SESSION_ID, $row['post_liked_by']) && $row['featured'] == 0){


            ?>

            <?php

               foreach ($row['post_liked_by'] as $key => $value) {

                if(in_array($value,$currentUserLikeedUsers)){
                    $CI            =& get_instance();
                $CI->load->model('people_model');
                $followingUser = $CI->people_model->checkFollowingOrNot($row['userId']);

                if(empty($followingUser)){


                        if($b%24==1){
                            echo '<p class="post_liked_by_user ">Post liked by';
                        }





                $firstName = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"firstName"," `id` = '".$value."'");

                $lastName             = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"lastName"," `id` = '".$value."'");?>
              <b><a href="<?php echo base_url();?>user/userDetail/<?php echo $value;?>"><?php echo
              $firstName.' '.$lastName;?></a></b>,


               <?php

                        if($b%24 == 0){
                            echo "</p>";

                }

                  $b++;
                }

            }
            }?>


          <?php
          }
        }?>
          <div class="usy-dt">

            <a href="<?php echo base_url();?>user/userDetail/<?php echo $row['userId']?>">

              <?php
              if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0)   {
                ?>
                <img class="people_follow_list" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileImage']?>">
                <?php }else{?>
                <img class="people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="image">
                <?php } ?>


                <?php  $flowcount = $this->CI->stream_model->getFollowers($row['userId']);
                $fcount = end($flowcount)['followers'];

                ?>
                <div class="usy-name">
                  <h3><?php echo $row['firstName'].' '.$row['lastName'];?>
                    <i>(<?php echo $fcount?$fcount:0?> followers)</i>
                  </h3>


                  <span><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/clock.png" alt=""><?php echo get_time_ago( strtotime($row['created']) ); ?></span>
                </div>

              </a>

            </div>
            <div class="follow_post_button">

              <?php
              if(($row['userId']) != $this->session->userdata('front_user_id'))
              {
                $CI            =& get_instance();
                $CI->load->model('people_model');
                $followingUser = $CI->people_model->checkFollowingOrNot($row['userId']);
                if(!empty($followingUser))
                {
                  ?>
                  <form action="<?php echo base_url();?>user/unfollow_user/<?php if(!empty($row['userId'])){echo $row['userId'];}?>/0?isStream=1" method="POST">
                    <!--<input type="submit" name="submit" value="Following" class="fallow_unfallow btn  btn-danger"/>-->
                    <button type="submit" name="submit" class="fallow_unfallow btn btn_orange">
                      <i class="fa fa-check"></i>&nbsp;Following
                    </button>
                  </form>
                  <?php
                }
                else
                {
                  ?>

                  <form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($row['userId'])){echo $row['userId'];}?>/0?isStream=1" method="POST">
                    <input type="submit" name="submit" value="&#x0002B; &nbsp; Follow" class="fallow_unfallow btn btn_blue"/>
                  </form>
                  <?php
                }
              }?>
            </div>
            <!--<div class="ed-opts">-->
              <!--  <a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>-->
              <!--  <ul class="ed-options">-->
                <!--    <li><a href="#" title="">Edit Post</a></li>-->
                <!--    <li><a href="#" title="">Unsaved</a></li>-->
                <!--    <li><a href="#" title="">Unbid</a></li>-->
                <!--    <li><a href="#" title="">Close</a></li>-->
                <!--    <li><a href="#" title="">Hide</a></li>-->
                <!--  </ul>-->
                <!--</div>-->
              </div>
              <div class="epi-sec">
                <ul class="descp">
                  <!--<li><img src="<?php //echo base_url();?>assets/custom-time-line_test_imgs/icon8.png" alt=""><span><?php //echo $row['projectPageName'];?></span></li>-->
                  <!--<li><img src="<?php //echo base_url();?>assets/custom-time-line_test_imgs/icon9.png" alt=""><span><?php //echo $row['city'];?></span></li>-->
                </ul>
        <!-- <ul class="bk-links">
          <li><a href="#" title=""><i class="la la-bookmark"></i></a></li>
          <li><a href="#" title=""><i class="la la-envelope"></i></a></li>
          <li><a href="#" title="" class="bid_now">Bid Now</a></li>
        </ul> -->
      </div>
      <div class="job_descp">

        <?php
        if(file_exists(file_upload_s3_path().'project/thumb_big/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumb_big/'.$row['image_thumb']) > 0){
          ?>
          <?php if(isset($is_assignment))
          { ?>
            <img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $row['image_thumb']?>" alt="image" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>/<?php echo $is_assignment;?>'">
            <?php  } else { ?>
            <img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $row['image_thumb']?>" alt="image" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>'">
            <?php }  ?>
            <?php }else{?>
            <img class="img-responsive project-img" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image">
            <?php }?>


        <!-- <ul class="job-dt">
          <li><a href="#" title="">Full Time</a></li>
          <li><span>$30 / hr</span></li>
        </ul> -->
        <!-- <h4>Profession</h4>
          <p><?php //echo $row['profession'];?></p> -->
          <ul class="skill-tags">

            <?php if(isset($row['featured']) && $row['featured'] == 1){?>
            <li class="trndp"><a  title=""><i class="fa fa-bolt" aria-hidden="true"></i> Trending Project</a></li>
            <?php  } else { ?>
            <li><a  title="">Project</a></li>
            <?php  } ?>
            <li><a title=""><?php echo $row['categoryName'];?></a></li>
            <?php if(isset($row['videoLink']) && $row['videoLink'] != ''){?>
            <li class="project_has_video"><a title="" href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>"><i class="fa fa-youtube-play" aria-hidden="true"></i> </a></li>

            <?php  }?>
          </ul>
        </div>
    <div class="job-status-bar">
          <ul class="like-com"><li>

            <?php

            //$totalLikeName = $this->db->select('B.firstName,B.lastName, B.id')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array();

                     $totalLikeName = $this->db->select('B.firstName,B.lastName, B.id')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array();

                     //print_r($totalLikeName);die;

            if($row['userLiked'] == 0){
              ?>
              <div class="like dropdown" >
                <div  >


                  <span  id="current_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>" class="sterm-project-like like_div" data-name="0" data-id="<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>"><i class="fa  fa-thumbs-o-up no-user-like" ></i></span>

                  <span  id="show_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>"  class="sterm-project-like" style="display: none;"><i class="fa  fa-thumbs-up user-like" ></i></span>




                  <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="image">

                  <span id="like_count_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-cc="<?php echo count($totalLikeName); ?>"><?php echo count($totalLikeName); ?></span>
                </div>
                <ul class="dropdown-menu strem-line-project-drp">
                  <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){

                  ?>
                  <li><a href="<?php echo base_url();?>user/userDetail/<?php echo $TLname['id'];?>"><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></a></li>
                  <?php }   }  ?>
                </ul>
              </div>
              <?php
            }
            else
            {
              ?>
              <div class="like dropdown " title="">
                <!-- <span class="dropdown-toggle" data-toggle="dropdown"></span> -->

                <a ><i class="fa fa-thumbs-up user-like" >
                </i></a>
                <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="image">
                <span><?php echo count($totalLikeName); ?></span>
                <ul class="dropdown-menu strem-line-project-drp">

                  <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){

                  ?>
                  <li><a href="<?php echo base_url();?>user/userDetail/<?php echo $TLname['id'];?>"><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></a></li>
                  <?php }   }  ?>
                </ul>
              </div>
              <?php
            }?>

          </li>

          <?php
          if($this->session->userdata('front_user_id') == $row['userId'] && $this->uri->segment(1) !='all_project')
          {
            if(isset($editProject)){
              if($row['assignmentId'] == 0 && $row['competitionId'] == 0 )
              {
                ?>
                <span onclick="window.location='<?php echo base_url();?>project/edit_project/<?php echo $row['id'];?>'" style="cursor: pointer;" title="Edit Project"><i class="fa fa-pencil-square-o" ></i>&nbsp;</span>


                <?php }  }
              }else{
                $CI  =& get_instance();
                $CI->load->model('model_basic');
                $imageCount = $CI->model_basic->getCount('user_project_image','project_id',$row['id']);
              //echo $imageCount;die;
                ?>
                <!--<li><a  title="" class="com"><i class="fa fa-picture-o"></i>&nbsp; Images <?php //echo $imageCount;?></a></li>-->


                <?php }?>


                <?php
        if(file_exists(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) > 0){
          ?>
          <?php if(isset($is_assignment))
          { ?>


            <li><a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt="image"> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

            <li><div class="dropdown pull-right sharelinks">
              <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>

     <?php  } else { ?>


            <li><a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt="image"> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

            <li><div class="dropdown pull-right sharelinks">

            <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>
<?php }  ?>
            <?php }else{?>
              <li><a title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt="image"> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

              <li><div class="dropdown pull-right sharelinks">
              <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>
            <?php }?>

            </ul>
              <?php if($row['view_cnt'] > 10){?>
              <a><i class="la la-eye"></i>Views <?php echo $row['view_cnt'];?> </a>
              <?php  }?>
            </div>
          </div><!--post-bar end-->
          <?php  } ?>
          <?php   $i++; }

        }?>

        <div id="ajaxTimelineData"></div>

       <!-- Blog Time line-->

       <?php /* if($blog){

          foreach ($blog as $val) {?>
          <div class="post-bar">
            <div class="post_topbar">
              <div class="usy-dt">
                <img class="people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="">
                <div class="usy-name">
                  <h3><?php echo $val['posted_by'];?></h3>
                  <span><img src="images/clock.png" alt=""><?php echo get_time_ago( strtotime($val['created']) ); ?></span>
                </div>
              </div>

            </div>

            <div class="job_descp">
              <h3> <a href="<?php echo base_url();?>blog/blogDetail/<?php echo $val['id'];?>"><?php echo $val['title'];?></a></h3>

              <p><?php echo substr(strip_tags($val['description']), 0, 150);?>... <a href="<?php echo base_url();?>blog/blogDetail/<?php echo $val['id'];?>" title="">view more</a></p>
              <a href="<?php echo base_url();?>blog/blogDetail/<?php echo $val['id'];?>">
                <img class="img-responsive img-hover blg-tm-img" src="<?php echo file_upload_base_url();?>blog/thumb/<?php echo $val['picture'];?>" alt="">
              </a>



              <ul class="skill-tags">
                <li><a title="">Blog</a></li>

              </ul>
            </div>
            <div class="job-status-bar">
              <ul class="like-com">
                <li>
                  <div class="like dropdown" >
                    <div  >



                      <span  class="sterm-project-like" ><i class="fa  fa-thumbs-o-up user-like" ></i></span>
                      <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="">

                      <span>0</span>
                    </div>
                  </div>

                </li>
                <li>

                  <?php $comment = $this->CI->stream_model->getBlogCommentCount($val['id']) ;
                  ?>


                  <a  href="<?php echo base_url();?>blog/blogDetail/<?php echo $val['id'];?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt=""> Comment <?php echo end($comment)['comment_cnt'];?></a></li>


                </ul>
                <a><i class="la la-eye"></i>Views 0</a>
              </div>
            </div><!--post-bar end-->
            <?php  }

          } */?>
        <div class="nomorePostsfound" style="display: none;" data-value="1025">No more projects found</div>
       <div class="process-comm" style="display: none" id="showSpinner" style="margin-top: -40px;">
                      <div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                      </div>
                    </div> <!--process-comm end -->
                  </div><!--posts-section end-->
                </div><!--main-ws-sec end-->
              </div>

              <div class="col-lg-3 pd-right-none no-pd">
                <div class="right-sidebar">
                      <div class="fixer_height">
                  <div class="widget widget-jobs">
                    <div class="sd-title">
                      <h3>Suggestions</h3>
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>
                    <div class="jobs-list">

                      <?php
                      $i = 1;
                      foreach(array_slice($peoples,0,4) as $user)
                      {
                        $CI           =& get_instance();
                        $CI->load->model('people_model');
                        $proData      = $CI->people_model->getUserProjectData($user['userId']);
                        $projectCount = sizeof($proData);
                        $likeCount    = 0;
                        $viewCount    = 0;
                        foreach($proData as $val){
                          $likeCount = $val['like_cnt'] + $likeCount;
                          $viewCount = $val['view_cnt'] + $viewCount;
                        }
  /*if(($user['userId']) != $this->session->userdata('front_user_id'))
  {*/
    ?>

    <div class="job-info">
      <div class="job-details">

        <h3><?php
        if(file_exists(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$user['profileimage']) > 0)   {
          ?>
          <img class="people_follow_list" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $user['profileimage']?>">
          <?php }else{?>
          <img class="people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="image">
          <?php } ?>
          <a href="<?php echo base_url();?>user/userDetail/<?php echo $user['userId']?>" class="be-use-name">
            <?php
            if($user['firstname'] != ''){
              $fullname = $user['firstname'].' '.$user['lastname'];
            }
            else
            {
              $fullname= '';
            }
            if($fullname!= '')
            {
              $atr = $fullname;
              if(strlen($atr) > 20)
              {
                $dot = '..';
              }
              else
              {
                $dot = '';
              }
              $position = 20;
              echo $post2 = substr($atr, 0, $position).$dot;
            }
            else
            {
              echo '&nbsp;';
            }
            ?>
          </a></h3><i class="custom_profession">
            <?php
            if(isset($user['profession']) && $user['profession'] != ''){
              $atr = $user['profession'];
              if(strlen($atr) > 20)
              {
                $dot = '..';
              }
              else
              {
                $dot = '';
              }
              $position = 20;
              echo $post2 = substr($atr, 0, $position).$dot;
            }
            else
            {
              echo '&nbsp;';
            }?>
          </i>


        </div>
        <div class="hr-rate">
          <span><?php
          if(($user['userId']) != $this->session->userdata('front_user_id'))
          {
            $CI            =& get_instance();
            $CI->load->model('people_model');
            $followingUser = $CI->people_model->checkFollowingOrNot($user['userId']);
            if(!empty($followingUser))
            {
              ?>
              <form action="<?php echo base_url();?>user/unfollow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0?isStream=1" method="POST">
                <!--<input type="submit" name="submit" value="Following" class="fallow_unfallow btn  btn-danger"/>-->
                <button type="submit" name="submit" class="fallow_unfallow btn btn_orange">
                  <i class="fa fa-check"></i>&nbsp;Following
                </button>
              </form>
              <?php
            }
            else
            {
              ?>

              <form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($user['userId'])){echo $user['userId'];}?>/0?isStream=1" method="POST">
                <i class="fa fa-plus" aria-hidden="true"></i> <input type="submit" name="submit" value="Follow" class="fallow_unfallow btn btn_blue"/>
              </form>
              <?php
            }
          }?></span>
        </div>


      </div><!--job-info end-->


      <?php /*}*/
    }?><div class="view-more">
      <a href="<?php echo base_url()?>people" title="">View More</a>
    </div>

</div><!--jobs-list end-->
</div><!--widget-jobs end-->


<div class="widget suggestions full-width jobs-lists">
  <div class="sd-title">
    <h3>Top Jobs &nbsp; <span class="fa fa-wpforms" aria-hidden="true"></span></h3>
    <i class="la la-ellipsis-v"></i>
  </div><!--sd-title end-->
  <div class="remjob-suggestions-list">
    <?php


    $jobsList = array_map("unserialize", array_unique(array_map("serialize", $job)));


 if(!empty($jobsList)){
    $jobsListLive = [];

    foreach ($jobsList as $key => $value) {

     $curdate = strtotime(date('Y-m-d'));
    $jobclosedate = strtotime($value['close_on']);
        // If job is not expired
      if($jobclosedate > $curdate){
          $jobsListLive[] = $value;
      }

    }



    if(!empty($jobsListLive)){

      foreach(array_slice($jobsListLive,0,1) as $row){
        ?>
        <div class="sc-job">
          <a href="<?php echo base_url();?>job/jobDetail/<?php echo $row['id'];?>">
            <h4>
              <?php echo $row['title'];?>

            </h4>

            <div class="sc-skills">
                    <?php if($row['description']){?>                  <span class="jobs_des"><?php echo substr($row['description'], 0,120);?>...</span>

                    <?php  } ?>
                  <span class="sc-locations sc-compant" style="display:block;"><b>Skills: </i> </b><?php echo $row['keySkills'];?></span>

              <span class="sc-locations sc-compant" style="display:block;"><b><i class="fa fa-building" aria-hidden="true"></i> </b><?php echo $row['companyName'];?></span>

              <span class="sc-locations" style="display:block;"><b><i class="fa fa-map-marker" aria-hidden="true"></i> </b><?php echo $row['location'];?></span>
            </div>

</a>
        </div>



      <div class="jobs-viewmore view-more" style="margin-bottom: 9px;">
      <a href="<?php echo base_url()?>job" title="">View More</a>
    </div>


<?php  } ?>

  <?php  } else { ?>

  <p class="event-notfound" style="margin: 12px 17px;
    display: block;
    float: left;">No more jobs found with your skills</p>
  <?php  } ?>


    <?php }else{?>
    <p class="event-notfound" style="margin: 12px 17px;
    display: block;
    float: left;"><a href="<?php echo base_url();?>profile/edit_profile">Update your work skills to view the top jobs</a></p>
    <?php }?>




  </div><!--suggestions-list end-->
</div>
</div>
<div class="fixed-divs">
<div class="widget suggestions full-width event-lists">
  <div class="sd-title">
    <h3>Events &nbsp; <span class="fa fa-calendar" aria-hidden="true"></span></h3>
    <i class="la la-ellipsis-v"></i>
  </div><!--sd-title end-->
  <div class="suggestions-list">

    <?php
    if(!empty($event)){


       $eventLive = [];

    foreach ($event as $key => $value) {

     $curdate = strtotime(date('Y-m-d'));
    $eventStartdate = strtotime($value['start_date']);
        // If job is not expired
      if($eventStartdate > $curdate){
          $eventLive[] = $value;
      }

    }


    if(!empty($eventLive)){
      foreach(array_slice($eventLive,0,1) as $row){


        ?>

        <div class="suggestion-usds">
          <a href="<?php echo base_url();?>event/show_event/<?php echo $row['id'];?>">
            <img class="media-object" src="<?php echo file_upload_base_url();?>event/banner/thumbs/<?php echo $row['banner'];?>" alt="image">
            <div class="sgt-text">

              <p class="event-metalistw">
                <i class="event-dates"><?php echo date("F",strtotime($row['start_date']));?></i>
                <span class="event-second-date">
                  <?php echo date("j",strtotime($row['start_date']));?>
                </span>
              </p>

              <div class="event-title">
                <?php echo $row['name'];?>
              </div>


            </div>
          </a>
        </div>





        <?php
      }
      ?>
      <div class="view-more">
        <a href="<?php echo base_url();?>event/event_list" title="">View More</a>
      </div>
      <?php } else{ ?>
<p class="event-notfound">No events found</p>
      <?php } ?>


   <?php  } else{?>
      <p class="event-notfound">No events found</p>
      <?php } ?>





    </div><!--suggestions-list end-->
  </div>



  <div class="widget suggestions full-width competition-lists">
    <div class="sd-title">
      <h3>Competitions &nbsp; <span class="fa fa-trophy" aria-hidden="true"></span></h3>
      <i class="la la-ellipsis-v"></i>
    </div><!--sd-title end-->
    <div class="suggestions-list">

      <?php

    if(!empty($competition)){
    $competitionLive = [];

    foreach ($competition as $key => $value) {

     $curdate = strtotime(date('Y-m-d'));
    $competitionclosedate = strtotime($value['end_date']);
        // If $competition is not expired
      if($competitionclosedate > $curdate){
          $competitionLive[] = $value;
      }

    }
  }


      if(!empty($competitionLive)){

        foreach(array_slice($competitionLive,0,1) as $row){


          ?>


          <div class="suggestion-usds">
            <div class="list-of-comp">
              <a href="<?php echo base_url();?>competition/<?php echo $row['pageName'];?>">
                <img src="http://via.placeholder.com/40x40" class="com-img">
                <?php
                $atr = $row['name'];
                if(strlen($atr) > 38){
                  $dot = '..';
                }
                else
                {
                  $dot = '<br/><br/>';
                }
                $position = 38;
                $post2    = substr($atr,0,$position).$dot;
                ?>
                <h4>

                  <?php echo $post2;?>
                </h4>
                <p class="c-metas">
                  <i class="fa fa-calendar-check-o">
                  </i> <span><?php echo date("M j, Y",strtotime($row['start_date']));?> - <?php echo date("M j, Y",strtotime($row['end_date']));?>
                  </span>

                </p>

                <div class="c-like-share-cout">
                  <div class="c-like">
                    <i class="fa fa-thumbs-o-up">
                    </i> <?php echo $row['likeCount'];?>
                  </div>
                  <div class="c-comment">
                    <i class="fa fa-comment-o">
                    </i> <?php echo $row['commentCount'];?>
                  </div>
                </div>
              </a>
            </div>

          </div>



          <?php
        }?>
        <div class="view-more">
          <a href="<?php echo base_url();?>event/event_list" title="">View More</a>
        </div>
        <?php } else{?>
        <p class="event-notfound">No Competitions found</p>
        <?php } ?>





      </div><!--suggestions-list end-->
    </div>
    </div>




  </div><!--right-sidebar end-->
</div>
</div>
</div><!-- main-section-data end-->
</div>
</div>
</main>




<div class="post-popup pst-pj">
  <div class="post-project">
    <h3>Post a project</h3>
    <div class="post-project-fields">
      <form>
        <div class="row">
          <div class="col-lg-12">
            <input type="text" name="title" placeholder="Title">
          </div>
          <div class="col-lg-12">
            <div class="inp-field">
              <select>
                <option>Category</option>
                <option>Category 1</option>
                <option>Category 2</option>
                <option>Category 3</option>
              </select>
            </div>
          </div>
          <div class="col-lg-12">
            <input type="text" name="skills" placeholder="Skills">
          </div>
          <div class="col-lg-12">
            <div class="price-sec">
              <div class="price-br">
                <input type="text" name="price1" placeholder="Price">
                <i class="la la-dollar"></i>
              </div>
              <span>To</span>
              <div class="price-br">
                <input type="text" name="price1" placeholder="Price">
                <i class="la la-dollar"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <textarea name="description" placeholder="Description"></textarea>
          </div>
          <div class="col-lg-12">
            <ul>
              <li><button class="active" type="submit" value="post">Post</button></li>
              <li><a href="#" title="">Cancel</a></li>
            </ul>
          </div>
        </div>
      </form>
    </div><!--post-project-fields end-->
    <a href="#" title=""><i class="la la-times-circle-o"></i></a>
  </div><!--post-project end-->
</div><!--post-project-popup end-->

<div class="post-popup job_post">
  <div class="post-project">
    <h3>Post a job</h3>
    <div class="post-project-fields">
      <form>
        <div class="row">
          <div class="col-lg-12">
            <input type="text" name="title" placeholder="Title">
          </div>
          <div class="col-lg-12">
            <div class="inp-field">
              <select>
                <option>Category</option>
                <option>Category 1</option>
                <option>Category 2</option>
                <option>Category 3</option>
              </select>
            </div>
          </div>
          <div class="col-lg-12">
            <input type="text" name="skills" placeholder="Skills">
          </div>
          <div class="col-lg-6">
            <div class="price-br">
              <input type="text" name="price1" placeholder="Price">
              <i class="la la-dollar"></i>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="inp-field">
              <select>
                <option>Full Time</option>
                <option>Half time</option>
              </select>
            </div>
          </div>
          <div class="col-lg-12">
            <textarea name="description" placeholder="Description"></textarea>
          </div>
          <div class="col-lg-12">
            <ul>
              <li><button class="active" type="submit" value="post">Post</button></li>
              <li><a href="#" title="">Cancel</a></li>
            </ul>
          </div>
        </div>
      </form>
    </div><!--post-project-fields end-->
    <a href="#" title=""><i class="la la-times-circle-o"></i></a>
  </div><!--post-project end-->
</div><!--post-project-popup end-->


</div>
<div class="footer_display" style="display:none;">
<?php $this->load->view('template/footer');?>
</div>


<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/custom-time-line_js/bootstrap.min.js"></script>
--><script type="text/javascript" src="<?php echo base_url();?>assets/custom-time-line_js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/custom-time-line_js/slick/slick.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/custom-time-line_js/scrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/custom-time-line_js/script.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/js/star-rating.js" type="text/javascript">
</script>
<script>
  $("#overAllRating").rating("refresh",{disabled:true});
</script>

<!-- custom scrollbar plugin -->


<script type="text/javascript">

  $(document).ready(function(){

  // $('.like_span').click(function()
  // $('.like_div').on('click' ,function()
  // {
    $(document).on('click', '.like_div', function(){
    var url = $('#base_url').val();
        // var pro_id = $(this).data('id');
        var pro_id = $(this).data('id');
         //var txt = $(this).text();
         var urlName = '<?php echo current_url();?>';
         var pageName = '<?php echo $this->uri->segment(1);?>';
         if(pageName=='')
         {
          pageName = 'Home';
         }
         var a = $(this).data('like');
         var cal = $(this).data('name');
         var th= $(this).data('id');

         var th_id = $('#'+th);
         var th_show = $('#show_'+th);
         var th_current = $('#current_'+th);
         var th_countChange = $('#like_count_'+th);

         if(cal==0)
         {
          //alert(url+"project/like_cnt");
          th_id.attr("data-name","1");
          $.ajax({
            url: url+"project/like_cnt",
            type: "POST",
            data:{pro_id:pro_id,pageName:pageName,urlName:urlName},
            success:function(html)
            {
              if(html=='done')
              {
                /*  th.html('<i class="fa fa-thumbs-o-up"></i> Like ('+(a+1)+')');*/
                th_show.show();
                th_current.hide();
                var countV = th_countChange.data('cc');
                //alert(countV);

                th_countChange.text(countV+1);
              }
              else if(html=='no')
              {
                th_id.attr("data-name","0");
              }
            }
          });
         }
      });


  $('.add_project_button').on('click',function(){
    $('.AddProject').fadeToggle("slow");
    $('.AddProject #Save_Competition_Id').val('');
    $('.AddProject #Save_Assignment_Id').val('');
    $('#privateProject').show();
    $('#draftProject').show();
    $('#publishProject').show();
  });


  $("#notificationLink").click(function()
  {
    var url = $('#base_url').val();
    $.ajax({
      url: url+"project/updateReadCount",
      type: "POST",
      success:function(html)
      {
      }
    });
  });
  $("#notificationLink").click(function()
  {
    $("#notificationContainer").fadeToggle(500);
    $("#notification_count").fadeOut("slow");
    return false;
  });
  $(document.body).click(function (){$("#notificationContainer").fadeOut(500);});


  $(".top-profile-after-div").insertAfter("#div_0");
  $(".blog-scroll").insertAfter(".project-custom-bar:nth-child(4n)");

//   $(".project-custom-bar").each(function(index) {
//    if ((index % 4) == 0 && index!= 0) {
//       $(this).after('<div class="red">after 4th div</div>');
//    }
// });


  $("#sorts_change").change(function(){
      var s_value = $(this).val();
      if(s_value == 0){
          window.location='<?php echo current_url();?>';
      } else{
          window.location='<?php echo current_url();?>?sort=' +s_value;
      }

  });

  var fixmeTop = $('.fixer_height').offset().top;
$(window).scroll(function() {
    var currentScroll = $(window).scrollTop();
    if (currentScroll >= fixmeTop+600) {
      $('.fixed-divs').addClass('fixed-wraps')
        $('.fixed-divs').css({
            position: 'fixed',
            width: '21%',
            top: '78px',
        });
    } else {
      $('.fixed-divs').removeClass('fixed-wraps')
        $('.fixed-divs').css({
            position: 'static',
            width: '100%',
        });
    }
});

var fixmeTop = $('.ad-fixes-height').offset().top;
$(window).scroll(function() {
    var currentScroll = $(window).scrollTop();
    if (currentScroll >= fixmeTop+800) {
      $('.ad-fixes').addClass('ad-fixes-fixed-wraps')
        $('.ad-fixes').css({
            position: 'fixed',
            width: '270px',
            top: '80px',
        });
    } else {
      $('.ad-fixes').removeClass('ad-fixes-fixed-wraps')
        $('.ad-fixes').css({
            position: 'static',
            width: '100%',
        });
    }
});




  $(window).bind("resize", function () {
    console.log($(this).width())
    if ($(this).width() < 1200) {
        $('.fixed-divs').removeClass('fixed-divs').addClass('noral-fix')
        $('.ad-fixes').removeClass('ad-fixes').addClass('ad-noral-fix')
    } else {
        $('.noral-fix').removeClass('noral-fix').addClass('fixed-divs')
        $('.ad-noral-fix').removeClass('ad-noral-fix').addClass('ad-fixes')
    }
}).trigger('resize');



var page = 0;
var hideForthree = $('#hideForthree').data('value');
if(hideForthree != 3){
  $(window).scroll(function() {

      if($(window).scrollTop() + $(window).height() >= $(document).height()) {

          page++;

          console.log(page+'ssss');
          loadTimelineMoreData(page);

      }

  });
}


  function loadTimelineMoreData(page){

    var url = $('#base_url').val();
    var tmAry = $('#timelineArData').val();
    var sortVal = $('#getSort').val();
    $('#showSpinner').show();
    $.ajax(

          {
              url: url+"stream/timeinline_more_data",
                data:
                {
                  sliceCount:page,timelinArray:tmAry, sortBy: sortVal
                },
                type: "POST",

                success:function(response)
                {
                  $('#showSpinner').hide();
                 // console.log(response);
                  $("#ajaxTimelineData").append(response);
                  //$(".blog-scroll").insertAfter(".project-custom-bar:nth-child(4n)");
                  if(response){
                    console.log("Exits data");
                    $('.nomorePostsfound').hide();
                    $('.ajax-custompost-bar:nth-child(4n+2)').addClass("zebra");
                    //$(".blog-scroll").insertAfter(".zebra");

                    $(".zebra").each(function(index) {
      $(".blog-scroll").insertAfter($(this));
});
                  } else{
                    console.log("No data found");
                    $('.nomorePostsfound').show();
                    $('#showSpinner').hide();

                  }


                  $('.dropdown').hover(function() {
                    // $(document).on('click', '.like_div', function(){
                    //alert("sdfsdf");
                      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
                    }, function() {
                      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
                    });
                }

          })



  }



});

</script>



