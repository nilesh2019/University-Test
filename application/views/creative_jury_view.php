<?php $this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
  }
</style>
 <div class="middle">
   <div class="container-fluid">
     <div class="row">
       <div class="col-lg-12">
         <ol class="breadcrumb">
           <li>Dashboard</li>
           <li class="active">Jury Creative Competition</li>
         </ol>
       </div>
       </div>
       <?php if(!empty($juryCompitationsEvaluating))
                   { ?>
     <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-primary jury_competition">
              <div class="panel-heading">
                  <h2>Evaluating</h2>
                 </div>
                 <div class="panel-body">
                  <div class="jury_project">
                  <?php
                    $i=1;
                   foreach ($juryCompitationsEvaluating as $competition)
                   {
                  ?>
                      <div class="col-lg-6 <?php if($i % 2 == 0){ echo 'left';}else{echo 'right';}?>7">
                          <div class="box_jury_proj">
                              <img src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $competition['banner'];?>" alt="banner image">
                                 <div class="trans">
                                  <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  Start Date :<span><?php echo date("j M, y",strtotime($competition['start_date']));?></span></p>
                                     <!--  <p><i class="fa fa-calendar-check-o"></i>  Evaluation Start Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_start_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <img class="img-circle" src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $competition['profile_image'];?>" alt="<?php echo $competition['name'];?>">
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  End Date :<span><?php echo date("j M, y",strtotime($competition['end_date']));?></span></p>
                                       <!-- <p><i class="fa fa-calendar-check-o"></i>  Evaluation End Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_end_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-12 col-xs-12">
                                      <h3><?php echo $competition['name'];?></h3>
                                      <a style="margin-bottom:10px;" class="btn btn-primary" target="_blank" href="<?php echo base_url();?>creative_mind_competitions/get_competition/<?php echo $competition['id'];?>/<?php echo $competition['juryId'];?>">Rate It</a>
                                     </div>
                                     <div class="count">
                                           <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-user"></i>&nbsp;
                                               <span><?php echo $competition['userCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-thumbs-o-up"></i>&nbsp;
                                              <span><?php echo $competition['likeCount'];?></span>
                                           </div>
                                          <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-comment-o"></i>&nbsp;
                                               <span><?php echo $competition['commentCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-image"></i>&nbsp;
                                              <span><?php echo $competition['projectCount'];?></span>
                                           </div>
                          </div>
                                 </div>
                             </div>
                         </div>
                         <?php
                         $i++;
                      }
                        ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
        <?php
     }
     if(!empty($juryCompitationsInprogress))
                   { ?>
     <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-success jury_competition">
                <div class="panel-heading">
                    <h2>Inprogress - wait for evaluation to start</h2>
                   </div>
                 <div class="panel-body">
                  <div class="jury_project">
                  <?php
                 $i=1;
                   foreach ($juryCompitationsInprogress as $competition)
                   {
                  ?>
                      <div class="col-lg-6 <?php if($i % 2 == 0){ echo 'left';}else{echo 'right';}?>7">
                          <div class="box_jury_proj">
                              <img src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $competition['banner'];?>" alt="banner image">
                                 <div class="trans no_rate_button">
                                  <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  Start Date :<span><?php echo date("j M, y",strtotime($competition['start_date']));?></span></p>
                                     <!--  <p><i class="fa fa-calendar-check-o"></i>  Evaluation Start Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_start_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <img class="img-circle" src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $competition['profile_image'];?>" alt="<?php echo $competition['name'];?>">
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  End Date :<span><?php echo date("j M, y",strtotime($competition['end_date']));?></span></p>
                                       <!-- <p><i class="fa fa-calendar-check-o"></i>  Evaluation End Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_end_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-12 col-xs-12">
                                      <h3><?php echo $competition['name'];?></h3>
                                      <!-- <a style="margin-bottom:10px;" class="btn btn-primary" target="_blank" href="<?php echo base_url();?>creative_mind_competitions/get_competition/<?php echo $competition['id'];?>/<?php echo $competition['juryId'];?>">Rate It</a> -->
                                     </div>
                                     <div class="count">
                                           <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-user"></i>&nbsp;
                                               <span><?php echo $competition['userCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-thumbs-o-up"></i>&nbsp;
                                              <span><?php echo $competition['likeCount'];?></span>
                                           </div>
                                          <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-comment-o"></i>&nbsp;
                                               <span><?php echo $competition['commentCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-image"></i>&nbsp;
                                              <span><?php echo $competition['projectCount'];?></span>
                                           </div>
                          </div>
                                 </div>
                             </div>
                         </div>
                         <?php
                         $i++;
                    }
                        ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <?php }
     if(!empty($juryCompitationsEvaluated))
     {?>
     <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-primary jury_competition">
                <div class="panel-heading">
                    <h2>Evaluated & waiting for results</h2>
                   </div>
                 <div class="panel-body">
                  <div class="jury_project">
                  <?php
                    $i=1;
                   foreach ($juryCompitationsEvaluated as $competition)
                   {
                  ?>
                      <div class="col-lg-6 <?php if($i % 2 == 0){ echo 'left';}else{echo 'right';}?>7">
                          <div class="box_jury_proj">
                              <img src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $competition['banner'];?>" alt="banner image">
                                 <div class="trans no_rate_button" >
                                  <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  Start Date :<span><?php echo date("j M, y",strtotime($competition['start_date']));?></span></p>
                                     <!--  <p><i class="fa fa-calendar-check-o"></i>  Evaluation Start Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_start_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <img class="img-circle" src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $competition['profile_image'];?>" alt="<?php echo $competition['name'];?>">
                                     </div>
                                     <div class="col-lg-4 col-xs-12">
                                      <p><i class="fa fa-calendar-check-o"></i>  End Date :<span><?php echo date("j M, y",strtotime($competition['end_date']));?></span></p>
                                       <!-- <p><i class="fa fa-calendar-check-o"></i>  Evaluation End Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_end_date']));?></span></p> -->
                                     </div>
                                     <div class="col-lg-12 col-xs-12">
                                      <h3><?php echo $competition['name'];?></h3>
                                      <!-- <a style="margin-bottom:10px;" class="btn btn-primary" target="_blank" href="<?php echo base_url();?>creative_mind_competitions/get_competition/<?php echo $competition['id'];?>/<?php echo $competition['juryId'];?>">Rate It</a> -->
                                     </div>
                                     <div class="count">
                                           <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-user"></i>&nbsp;
                                               <span><?php echo $competition['userCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-thumbs-o-up"></i>&nbsp;
                                              <span><?php echo $competition['likeCount'];?></span>
                                           </div>
                                          <div class="col-lg-3 col-xs-3">
                                               <i class="fa fa-comment-o"></i>&nbsp;
                                               <span><?php echo $competition['commentCount'];?></span>
                                          </div>
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-image"></i>&nbsp;
                                              <span><?php echo $competition['projectCount'];?></span>
                                           </div>
                          </div>
                                 </div>
                             </div>
                         </div>
                         <?php
                         $i++;
                           }
                             ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <?php }
     if(!empty($juryCompitationsCompleted))
     { ?>
    <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-danger jury_competition">
               <div class="panel-heading">
                   <h2>Result Declared</h2>
                  </div>
                <div class="panel-body">
                 <div class="jury_project">
                 <?php
                    $i=1;
                  foreach ($juryCompitationsCompleted as $competition)
                  {
                 ?>
                     <div class="col-lg-6 <?php if($i % 2 == 0){ echo 'left';}else{echo 'right';}?>7">
                         <div class="box_jury_proj">
                             <img src="<?php echo file_upload_base_url();?>competition/banner/<?php echo $competition['banner'];?>" alt="banner image">
                                <div class="trans no_rate_button">
                                 <div class="col-lg-4 col-xs-12">
                                     <p><i class="fa fa-calendar-check-o"></i>  Start Date :<span><?php echo date("j M, y",strtotime($competition['start_date']));?></span></p>
                                    <!--  <p><i class="fa fa-calendar-check-o"></i>  Evaluation Start Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_start_date']));?></span></p> -->
                                    </div>
                                    <div class="col-lg-4 col-xs-12">
                                     <img class="img-circle" src="<?php echo file_upload_base_url();?>competition/profile_image/thumbs/<?php echo $competition['profile_image'];?>" alt="<?php echo $competition['name'];?>">
                                    </div>
                                    <div class="col-lg-4 col-xs-12">
                                     <p><i class="fa fa-calendar-check-o"></i>  End Date :<span><?php echo date("j M, y",strtotime($competition['end_date']));?></span></p>
                                      <!-- <p><i class="fa fa-calendar-check-o"></i>  Evaluation End Date :<span><?php echo date("F j, y",strtotime($competition['evaluation_end_date']));?></span></p> -->
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                     <h3><?php echo $competition['name'];?></h3>
                                    <!--  <a style="margin-bottom:10px;" class="btn btn-primary" target="_blank" href="<?php echo base_url();?>creative_mind_competitions/get_competition/<?php echo $competition['id'];?>/<?php echo $competition['juryId'];?>">Rate It</a> -->
                                    </div>
                                    <div class="count">
                                          <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-user"></i>&nbsp;
                                              <span><?php echo $competition['userCount'];?></span>
                                         </div>
                                         <div class="col-lg-3 col-xs-3">
                                             <i class="fa fa-thumbs-o-up"></i>&nbsp;
                                             <span><?php echo $competition['likeCount'];?></span>
                                          </div>
                                         <div class="col-lg-3 col-xs-3">
                                              <i class="fa fa-comment-o"></i>&nbsp;
                                              <span><?php echo $competition['commentCount'];?></span>
                                         </div>
                                         <div class="col-lg-3 col-xs-3">
                                             <i class="fa fa-image"></i>&nbsp;
                                             <span><?php echo $competition['projectCount'];?></span>
                                          </div>
                         </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                      }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
 </div>
 <?php } ?>
 </div>
<?php $this->load->view('template/footer');?>
<script>
	function UrlExists(url)
    {
      $.ajax({
        url: base_url+'project/file_exists',
        type: 'POST',
        data: {'file': url},
      })
      .done(function(data) {
        return data;
      })
    }
  </script>

