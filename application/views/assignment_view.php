<?php $this->load->view('template/header');?>
<style>
.navbar {
background-color:rgb(0,0,0);
}
.side-corner-tag .ribbon-color {
  background: rgba(0, 0, 0, 0) linear-gradient(#00b4ff 0%, #318df7 100%) repeat scroll 0 0;
}
.late-tag{
  background: #ff8400 none repeat scroll 0 0;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
     color: #fff;
     margin: -17px -16px 0;
     padding: 2px 10px;
     position: absolute;
}
</style>
<div class="middle">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-bg">
        <ol class="col-lg-4 breadcrumb">
          <li>
            <a href="<?php echo base_url();?>">
              Home
            </a>
          </li>

       <!--   <?php
          if($this->session->userdata('teachers_status') == 1)
            {  ?>
          <li>
            <a href="<?php echo base_url();?>profile">
              Portfolio
            </a>
          </li>
              <?php }  ?> -->
          <li class="active">
            Assignments
          </li>
        </ol>
      </div>
      <?php
      //print_r($user_profile->id);die;
      if($this->session->userdata('teachers_status')==1 ){ 
        ?>
        <li>
        <a class="follow-btn" href="<?php echo base_url();?>assignment/manage_assignment/<?php echo $this->session->userdata('front_user_id'); ?>">
          Manage Assignment
        </a>
        </li>
        <li>
        <a class="follow-btn" href="<?php echo base_url();?>assignment/add_assignment">
          Add Assignment
        </a>
        </li>
        <?php                 
      } ?>
    </div>
    <div class="clearfix"></div>
    <div class="row"> 
    <div class="col-lg-12 left5 job-container">
      <div id="wrapper_div">

  <?php  if(empty($assigned) && empty($pending) && empty($resubmitted) && empty($submitted) && empty($accepted)) 
  {
    echo "No assignment assigned to you";
    
    } ?> 

    <?php  if(!empty($assigned)) {  ?>      
      
       <?php foreach ($assigned as $assignment) {          
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right7">
            <div class="panel panel-default job_list">
             <div class="panel-body side-corner-tag">

             <?php 
             $this->CI =& get_instance();
             $this->CI->load->model('model_basic');
             $uid = $this->session->userdata('front_user_id');
             $assignment_id = $assignment['id'];  
             $is_assignmente_submited=$this->CI->model_basic->getAllData('project_master','userId,assignment_status,created',array('userId'=>$uid,'assignmentId'=>$assignment_id));
     
      
             if($this->uri->segment(2) == '' && $this->uri->segment(2) != 'submited_assignment')
               {  
                if(empty($is_assignmente_submited) && $assignment['end_date'] == date('Y-m-d'))
                {  ?>
                 <p class="late-tag"> Today is the last day to submit this Assignment. </p>
            <?php  }
            
                if($assignment['end_date'] < date('Y-m-d'))
                  { 
                    ?>
                      <p class="late-tag">You have not submitted this assignment </p>
                  <?php
                  }
               } 
            if(isset($submited_assignment) && $submited_assignment== 1 && !empty($assignment))
               { 
                 if($assignment['end_date'] == date('Y-m-d'))
                 { 
                  ?>
               <p class="ribbon"><span>Last Date</span></p>
               <p class="late-tag">Latest Submitted </p>
               <?php  
                 
                 }
                 if($assignment['start_date'] > date('Y-m-d'))
                 { 
                  ?>
               
                 <p class="ribbon"><span>Future </span></p>
                 <p class="late-tag">Latest Submitted </p>
                 <?php  
                 
                 }
                 if($assignment['start_date'] <= date('Y-m-d') && $assignment['end_date'] > date('Y-m-d'))
                 {              
                  $date1 = new DateTime(date('Y-m-d'));
                  $date2 = new DateTime($assignment['end_date']);
                  $diff = $date2->diff($date1)->format("%a");                 

                 ?>               
               <p class="ribbon"><span><?php echo $diff;?> Days Remaining</span></p>
               <p class="late-tag">Latest Submitted </p>
               <?php  
                 
                 }
                   if($assignment['start_date'] < date('Y-m-d') && $assignment['end_date'] < date('Y-m-d'))
                   { 
                   ?>               
                 <p class="ribbon"><span>Out Of Date</span></p>
                 <p class="late-tag">Latest Submitted </p>
                 <?php                     
                   }              
               }
               else             
             if(!empty($is_assignmente_submited))
             {
               if($is_assignmente_submited[0]['assignment_status'] == 0)
               { ?>             
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php  
                 //echo 'status = 0("assign")';
               }           
             }
             else
             { ?>           
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php
                    }
               ?>

                <div class="media row">
                  <div class="media-left job-title media-top col-md-4">

                  <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                   <?php } else {?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                  <?php }  ?>
                  <img alt="assignment img" src="<?php echo base_url();?>assets/img/as.png" class="assignment-img">
                  </a>
                    
                  </div>
                  <div class="job-detail col-md-8">
                    <h4 class="media-heading">
                    <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                     <?php } else {?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                    <?php }  ?>
                    <?php echo mb_strimwidth($assignment['assignment_name'], 0, 20 , "..."); ?>    
                    </a>                
                    </h4>
                 
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> Start Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['start_date'])); ?>
                      </span>
                    </p>
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> End Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['end_date'])); ?>
                      </span>
                    </p>
                  </div>
                </div>
                <div class="disc col-md-12">
                  
                  <label class="col-lg-4 right5" style="padding-left:0">
                    <b>Description :</b>
                  </label>
                  <div class="col-lg-8 job-desc" style="height: 51px;" >
                    <?php 
                    if(strlen($assignment['description']) > 65)
                    {
                       echo substr($assignment['description'], 0, 65);
                       echo "...";
                    }
                    else
                    {
                       echo substr($assignment['description'], 0, 65);
                    }
                     ?>   
                  </div>
                </div>
              </div>


              <div class="panel-footer assign-date">
             <?php
                 if($this->session->userdata('teachers_status') == 1)
                 { 

                 $totalNoOfAssignUser = $this->db->select('id')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->count_all_results();
                 $totalNoOfUsersubmitedAssignment = $this->db->select('id')->from('project_master')->where('assignmentId',$assignment['id'])->count_all_results();                   
                 ?> 

                 <?php if($this->uri->segment('2') == 'submited_assignment'){?>
                     <p class="pull-left"><span><i class="fa fa-book"></i> Assign &nbsp;:&nbsp;<?php echo $totalNoOfAssignUser; ?></span>
                     &nbsp;&nbsp;&nbsp;<span><i class="fa fa-check"></i> Submitted &nbsp;:&nbsp;<?php echo $totalNoOfUsersubmitedAssignment; ?></span></p> 
                     <?php  }  }  ?> 
                     <p>Posted On-&nbsp;&nbsp;<?php echo date('d M , Y',strtotime($assignment['created']))?></p>              
              </div>

            </div>
          </div>
         <?php } ?> 
    <?php }  ?>

    <?php  if(!empty($pending)) {  ?>  
  
       <?php foreach ($pending as $assignment) {          
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right7">
            <div class="panel panel-default job_list">
             <div class="panel-body side-corner-tag">

             <?php 
             $this->CI =& get_instance();
             $this->CI->load->model('model_basic');
             $uid = $this->session->userdata('front_user_id');
             $assignment_id = $assignment['id'];  
             $is_assignmente_submited=$this->CI->model_basic->getAllData('project_master','userId,assignment_status,created',array('userId'=>$uid,'assignmentId'=>$assignment_id));
        
            if($this->uri->segment(2) == '' && $this->uri->segment(2) != 'submited_assignment')
               {  
                if($assignment['end_date'] == date('Y-m-d'))
                {  ?>
                 <p class="late-tag"> Today is the last day to submit this Assignment. </p>
            <?php    }
                 if(!empty($is_assignmente_submited)){ 
                      if(date("Y-m-d",strtotime($is_assignmente_submited[0]['created'])) > $assignment['end_date'])
                       {  ?> 
                     <p class="late-tag">Late submission for this Assignment. </p>
              <?php   }
                   }                                  
                } 

            if(isset($submited_assignment) && $submited_assignment== 1 && !empty($assignment))
               { //echo $assignment['start_date'];die;               

                 if($assignment['end_date'] == date('Y-m-d'))
                 { 
                  ?>
             
               <p class="ribbon"><span>Last Date</span></p>
               <p class="late-tag">Re - Submitted </p>
               <?php  
                 
                 }
                 if($assignment['start_date'] > date('Y-m-d'))
                 { 
                  ?>
               
                 <p class="ribbon"><span>Future </span></p>
                 <p class="late-tag">Re - Submitted </p>
                 <?php  
                 
                 }
                 if($assignment['start_date'] <= date('Y-m-d') && $assignment['end_date'] > date('Y-m-d'))
                 {              
                  $date1 = new DateTime(date('Y-m-d'));
                  $date2 = new DateTime($assignment['end_date']);
                  $diff = $date2->diff($date1)->format("%a");                 

                 ?>               
               <p class="ribbon"><span><?php echo $diff;?> Days Remaining</span></p>
               <p class="late-tag">Re - Submitted </p>
               <?php  
                 
                 }
                   if($assignment['start_date'] < date('Y-m-d') && $assignment['end_date'] < date('Y-m-d'))
                   { 
                   ?>               
                 <p class="ribbon"><span>Out Of Date</span></p>
                 <p class="late-tag">Re - Submitted </p>
                 <?php  
                   
                   }
              
               }
               else             
             if(!empty($is_assignmente_submited))
             {
               if($is_assignmente_submited[0]['assignment_status'] == 0)
               { ?>
             
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php  
                 //echo 'status = 0("assign")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 1)
               { ?>
             
                 <p class="ribbon"><span>SUBMITTED</span></p>
                 <?php  //echo 'status = 1("submited")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 2)
               { ?>
             <p class="ribbon"><span>PENDING</span></p>
             <?php
                // echo 'status = 2("Pending")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 3)
               { ?>

             <p class="ribbon"><span>ACCEPTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 4)
               { ?>
             <p class="ribbon"><span>RE - SUBMITTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
             }
             else
             { ?>           
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php
                 //echo 'status = 0("assign")';
               }
               ?>

                <div class="media row">
                  <div class="media-left job-title media-top col-md-4">

                  <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                   <?php } else {?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                  <?php }  ?>
                  <img alt="" src="<?php echo base_url();?>assets/img/as.png" class="assignment-img">
                  </a>
                    
                  </div>
                  <div class="job-detail col-md-8">
                    <h4 class="media-heading">
                    <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                     <?php } else {?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                    <?php }  ?>
                    <?php echo mb_strimwidth($assignment['assignment_name'], 0, 20 , "..."); ?>    
                    </a>                
                    </h4>
                 
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> Start Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['start_date'])); ?>
                      </span>
                    </p>
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> End Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['end_date'])); ?>
                      </span>
                    </p>
                  </div>
                </div>
                <div class="disc col-md-12">
                  
                  <label class="col-lg-4 right5" style="padding-left:0">
                    <b>Description :</b>
                  </label>
                  <div class="col-lg-8 job-desc" style="height: 51px;" >
                    <?php 
                    if(strlen($assignment['description']) > 65)
                    {
                       echo substr($assignment['description'], 0, 65);
                       echo "...";
                    }
                    else
                    {
                       echo substr($assignment['description'], 0, 65);
                    }
                     ?>   
                  </div>
                </div>
              </div>


              <div class="panel-footer assign-date">
             <?php
                 if($this->session->userdata('teachers_status') == 1)
                 { 

                 $totalNoOfAssignUser = $this->db->select('id')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->count_all_results();
                 $totalNoOfUsersubmitedAssignment = $this->db->select('id')->from('project_master')->where('assignmentId',$assignment['id'])->count_all_results();                   
                 ?> 
                 <?php if($this->uri->segment('2') == 'submited_assignment'){?>
                     <p class="pull-left"><span><i class="fa fa-book"></i> Assign &nbsp;:&nbsp;<?php echo $totalNoOfAssignUser; ?></span>
                     &nbsp;&nbsp;&nbsp;<span><i class="fa fa-check"></i> Submitted &nbsp;:&nbsp;<?php echo $totalNoOfUsersubmitedAssignment; ?></span></p>
                     <?php  }  } ?> 
                     <p>Posted On-&nbsp;&nbsp;<?php echo date('d M , Y',strtotime($assignment['created']))?></p>              
              </div>

            </div>
          </div>
         <?php } ?>      
   
    <?php }  ?>

    <?php  if(!empty($resubmitted)) {  ?>        
     
       <?php foreach ($resubmitted as $assignment) {          
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right7">
            <div class="panel panel-default job_list">
             <div class="panel-body side-corner-tag">

             <?php 
             $this->CI =& get_instance();
             $this->CI->load->model('model_basic');
             $uid = $this->session->userdata('front_user_id');
             $assignment_id = $assignment['id'];  
             $is_assignmente_submited=$this->CI->model_basic->getAllData('project_master','userId,assignment_status,created',array('userId'=>$uid,'assignmentId'=>$assignment_id));
        
           if($this->uri->segment(2) == '' && $this->uri->segment(2) != 'submited_assignment')
               {  
                if(empty($is_assignmente_submited) && $assignment['end_date'] == date('Y-m-d'))
                {  ?>
                 <p class="late-tag"> Today is the last day to submit this Assignment. </p>
            <?php    }
                 if(!empty($is_assignmente_submited)){ 
                      if(date("Y-m-d",strtotime($is_assignmente_submited[0]['created'])) > $assignment['end_date'])
                       {  ?> 
                     <p class="late-tag">Late submission for this Assignment. </p>
              <?php   }
                   }                             
                } 

            if(isset($submited_assignment) && $submited_assignment== 1 && !empty($assignment))
               {
                 if($assignment['end_date'] == date('Y-m-d'))
                 { 
                  ?>             
               <p class="ribbon"><span>Last Date</span></p>
               <p class="late-tag">Today's Assignment</p>
               <?php                  
                 }  
               }
               else             
             if(!empty($is_assignmente_submited))
             {
               if($is_assignmente_submited[0]['assignment_status'] == 0)
               { ?>
             
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php  
                 //echo 'status = 0("assign")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 1)
               { ?>
             
                 <p class="ribbon"><span>SUBMITTED</span></p>
                 <?php  //echo 'status = 1("submited")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 2)
               { ?>
             <p class="ribbon"><span>PENDING</span></p>
             <?php
                // echo 'status = 2("Pending")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 3)
               { ?>

             <p class="ribbon"><span>ACCEPTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 4)
               { ?>
             <p class="ribbon"><span>RE - SUBMITTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
             }
             else
             { ?>           
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php
                 //echo 'status = 0("assign")';
               }
               ?>

                <div class="media row">
                  <div class="media-left job-title media-top col-md-4">

                  <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                   <?php } else {?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                  <?php }  ?>
                  <img alt="" src="<?php echo base_url();?>assets/img/as.png" class="assignment-img">
                  </a>
                    
                  </div>
                  <div class="job-detail col-md-8">
                    <h4 class="media-heading">
                    <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                     <?php } else {?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                    <?php }  ?>
                    <?php echo mb_strimwidth($assignment['assignment_name'], 0, 20 , "..."); ?>    
                    </a>                
                    </h4>
                 
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> Start Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['start_date'])); ?>
                      </span>
                    </p>
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> End Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['end_date'])); ?>
                      </span>
                    </p>
                  </div>
                </div>
                <div class="disc col-md-12">
                  
                  <label class="col-lg-4 right5" style="padding-left:0">
                    <b>Description :</b>
                  </label>
                  <div class="col-lg-8 job-desc" style="height: 51px;" >
                    <?php 
                    if(strlen($assignment['description']) > 65)
                    {
                       echo substr($assignment['description'], 0, 65);
                       echo "...";
                    }
                    else
                    {
                       echo substr($assignment['description'], 0, 65);
                    }
                     ?>   
                  </div>
                </div>
              </div>


              <div class="panel-footer assign-date">
             <?php
                 if($this->session->userdata('teachers_status') == 1)
                 { 

                 $totalNoOfAssignUser = $this->db->select('id')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->count_all_results();
                 $totalNoOfUsersubmitedAssignment = $this->db->select('id')->from('project_master')->where('assignmentId',$assignment['id'])->count_all_results();                   
                 ?> 
                 <?php if($this->uri->segment('2') == 'submited_assignment'){?>
                     <p class="pull-left"><span><i class="fa fa-book"></i> Assign &nbsp;:&nbsp;<?php echo $totalNoOfAssignUser; ?></span>
                     &nbsp;&nbsp;&nbsp;<span><i class="fa fa-check"></i> Submitted &nbsp;:&nbsp;<?php echo $totalNoOfUsersubmitedAssignment; ?></span></p>
                     <?php  }  }  ?> 
                     <p>Posted On-&nbsp;&nbsp;<?php echo date('d M , Y',strtotime($assignment['created']))?></p>              
              </div>

            </div>
          </div>
         <?php } ?>     
   
    <?php }  ?>

    <?php  if(!empty($submitted)) {  ?> 
       <?php foreach ($submitted as $assignment) {          
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right7">
            <div class="panel panel-default job_list">
             <div class="panel-body side-corner-tag">

             <?php 
             $this->CI =& get_instance();
             $this->CI->load->model('model_basic');
             $uid = $this->session->userdata('front_user_id');
             $assignment_id = $assignment['id'];  
             $is_assignmente_submited=$this->CI->model_basic->getAllData('project_master','userId,assignment_status,created',array('userId'=>$uid,'assignmentId'=>$assignment_id));
       
         
           if($this->uri->segment(2) == '' && $this->uri->segment(2) != 'submited_assignment')
               {  
                if(empty($is_assignmente_submited) && $assignment['end_date'] == date('Y-m-d'))
                {  ?>
                 <p class="late-tag"> Today is the last day to submit this Assignment. </p>
            <?php    }
                 if(!empty($is_assignmente_submited)){ 
                      if(date("Y-m-d",strtotime($is_assignmente_submited[0]['created'])) > $assignment['end_date'])
                       {  ?> 
                     <p class="late-tag">Late submission for this Assignment. </p>
              <?php   }
                   }
                      
                } 

            if(isset($submited_assignment) && $submited_assignment== 1 && !empty($assignment))
               { //echo $assignment['start_date'];die;               

                 if($assignment['end_date'] == date('Y-m-d'))
                 { 
                  ?>
             
               <p class="ribbon"><span>Last Date</span></p>
               <?php  
                 
                 }
                 if($assignment['start_date'] > date('Y-m-d'))
                 { 
                  ?>
               
                 <p class="ribbon"><span>Future </span></p>
                 <?php  
                 
                 }
                 if($assignment['start_date'] <= date('Y-m-d') && $assignment['end_date'] > date('Y-m-d'))
                 {              
                  $date1 = new DateTime(date('Y-m-d'));
                  $date2 = new DateTime($assignment['end_date']);
                  $diff = $date2->diff($date1)->format("%a");                 

                 ?>               
               <p class="ribbon"><span><?php echo $diff;?> Days Remaining</span></p>
               <?php  
                 
                 }
                   if($assignment['start_date'] < date('Y-m-d') && $assignment['end_date'] < date('Y-m-d'))
                   { 
                   ?>               
                 <p class="ribbon"><span>Out Of Date</span></p>
                 <?php  
                   
                   }
              
               }
               else             
             if(!empty($is_assignmente_submited))
             {
               if($is_assignmente_submited[0]['assignment_status'] == 0)
               { ?>
             
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php  
                 //echo 'status = 0("assign")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 1)
               { ?>
             
                 <p class="ribbon"><span>SUBMITTED</span></p>
                 <?php  //echo 'status = 1("submited")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 2)
               { ?>
             <p class="ribbon"><span>PENDING</span></p>
             <?php                
               }
               if($is_assignmente_submited[0]['assignment_status'] == 3)
               { ?>

             <p class="ribbon"><span>ACCEPTED</span></p>
                <?php 
               }
               if($is_assignmente_submited[0]['assignment_status'] == 4)
               { ?>
             <p class="ribbon"><span>RE - SUBMITTED</span></p>
                <?php 
               }
             }
             else
             { ?>           
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php
                
               }
               ?>

                <div class="media row">
                  <div class="media-left job-title media-top col-md-4">

                  <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                   <?php } else {?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                  <?php }  ?>
                  <img alt="" src="<?php echo base_url();?>assets/img/as.png" class="assignment-img">
                  </a>
                    
                  </div>
                  <div class="job-detail col-md-8">
                    <h4 class="media-heading">
                    <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                     <?php } else {?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                    <?php }  ?>
                    <?php echo mb_strimwidth($assignment['assignment_name'], 0, 20 , "..."); ?>    
                    </a>                
                    </h4>
                 
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> Start Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['start_date'])); ?>
                      </span>
                    </p>
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> End Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['end_date'])); ?>
                      </span>
                    </p>
                  </div>
                </div>
                <div class="disc col-md-12">
                  
                  <label class="col-lg-4 right5" style="padding-left:0">
                    <b>Description :</b>
                  </label>
                  <div class="col-lg-8 job-desc" style="height: 51px;" >
                    <?php 
                    if(strlen($assignment['description']) > 65)
                    {
                       echo substr($assignment['description'], 0, 65);
                       echo "...";
                    }
                    else
                    {
                       echo substr($assignment['description'], 0, 65);
                    }
                     ?>   
                  </div>
                </div>
              </div>


              <div class="panel-footer assign-date">
             <?php
                 if($this->session->userdata('teachers_status') == 1)
                 { 

                 $totalNoOfAssignUser = $this->db->select('id')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->count_all_results();
                 $totalNoOfUsersubmitedAssignment = $this->db->select('id')->from('project_master')->where('assignmentId',$assignment['id'])->count_all_results();                   
                 ?> 
                 <?php if($this->uri->segment('2') == 'submited_assignment'){?>
                     <p class="pull-left"><span><i class="fa fa-book"></i> Assign &nbsp;:&nbsp;<?php echo $totalNoOfAssignUser; ?></span>
                     &nbsp;&nbsp;&nbsp;<span><i class="fa fa-check"></i> Submitted &nbsp;:&nbsp;<?php echo $totalNoOfUsersubmitedAssignment; ?></span></p>
                     <?php  }  } ?> 
                     <p>Posted On-&nbsp;&nbsp;<?php echo date('d M , Y',strtotime($assignment['created']))?></p>              
              </div>

            </div>
          </div>
         <?php } ?>
     
    <?php }  ?>

    <?php  if(!empty($accepted)) {  ?>
  
       <?php foreach ($accepted as $assignment) {          
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right7">
            <div class="panel panel-default job_list">
             <div class="panel-body side-corner-tag">

             <?php 
             $this->CI =& get_instance();
             $this->CI->load->model('model_basic');
             $uid = $this->session->userdata('front_user_id');
             $assignment_id = $assignment['id'];  
             $is_assignmente_submited=$this->CI->model_basic->getAllData('project_master','userId,assignment_status,created',array('userId'=>$uid,'assignmentId'=>$assignment_id));
            
           if($this->uri->segment(2) == '' && $this->uri->segment(2) != 'submited_assignment')
               {  
                if(empty($is_assignmente_submited) && $assignment['end_date'] == date('Y-m-d'))
                {  ?>
                 <p class="late-tag"> Today is the last day for submitting this assignment. </p>
            <?php    }
                 if(!empty($is_assignmente_submited)){ 
                      if(date("Y-m-d",strtotime($is_assignmente_submited[0]['created'])) > $assignment['end_date'])
                       {  ?> 
                     <p class="late-tag">Late submission for this Assignment. </p>
              <?php   }
                   }                      
                } 
            if(isset($submited_assignment) && $submited_assignment== 1 && !empty($assignment))
               { 
                 if($assignment['start_date'] < date('Y-m-d') && $assignment['end_date'] < date('Y-m-d'))
                   { 
                   ?>               
                 <p class="ribbon"><span>Completed</span></p>
                 <?php                    
                   }              
               }
               else             
             if(!empty($is_assignmente_submited))
             {
               if($is_assignmente_submited[0]['assignment_status'] == 0)
               { ?>
             
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php  
                 //echo 'status = 0("assign")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 1)
               { ?>
             
                 <p class="ribbon"><span>SUBMITTED</span></p>
                 <?php  //echo 'status = 1("submited")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 2)
               { ?>
             <p class="ribbon"><span>PENDING</span></p>
             <?php
                // echo 'status = 2("Pending")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 3)
               { ?>

             <p class="ribbon"><span>ACCEPTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
               if($is_assignmente_submited[0]['assignment_status'] == 4)
               { ?>
             <p class="ribbon"><span>RE - SUBMITTED</span></p>
                <?php // echo 'status = 3("accepted")';
               }
             }
             else
             { ?>           
             <p class="ribbon"><span>ASSIGNED</span></p>
             <?php
                 //echo 'status = 0("assign")';
               }
               ?>

                <div class="media row">
                  <div class="media-left job-title media-top col-md-4">

                  <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                   <?php } else {?>
                  <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                  <?php }  ?>
                  <img alt="" src="<?php echo base_url();?>assets/img/as.png" class="assignment-img">
                  </a>
                    
                  </div>
                  <div class="job-detail col-md-8">
                    <h4 class="media-heading">
                    <?php if($this->uri->segment(1) == 'profile' && $this->uri->segment(2) == 'submited_assignment') { ?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>/sub_assig">
                     <?php } else {?>
                    <a href="<?php echo base_url();?>assignment/assignment_detail/<?php echo $assignment['id'];?>/<?php echo $this->session->userdata('front_user_id');?>">
                    <?php }  ?>
                    <?php echo mb_strimwidth($assignment['assignment_name'], 0, 20 , "..."); ?>    
                    </a>                
                    </h4>
                 
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> Start Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['start_date'])); ?>
                      </span>
                    </p>
                    <p class="margin_leftRight">
                      <i class="fa fa-calendar">
                      </i>
                      <span>
                        &nbsp;<b> End Date :</b>&nbsp;&nbsp;<?php echo date('M d, Y',strtotime($assignment['end_date'])); ?>
                      </span>
                    </p>
                  </div>
                </div>
                <div class="disc col-md-12">
                  
                  <label class="col-lg-4 right5" style="padding-left:0">
                    <b>Description :</b>
                  </label>
                  <div class="col-lg-8 job-desc" style="height: 51px;" >
                    <?php 
                    if(strlen($assignment['description']) > 65)
                    {
                       echo substr($assignment['description'], 0, 65);
                       echo "...";
                    }
                    else
                    {
                       echo substr($assignment['description'], 0, 65);
                    }
                     ?>   
                  </div>
                </div>
              </div>
              <div class="panel-footer assign-date">
             <?php
                 if($this->session->userdata('teachers_status') == 1)
                 { 

                 $totalNoOfAssignUser = $this->db->select('id')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->count_all_results();
                 $totalNoOfUsersubmitedAssignment = $this->db->select('id')->from('project_master')->where('assignmentId',$assignment['id'])->count_all_results();                   
                 ?> 
                 <?php if($this->uri->segment('2') == 'submited_assignment'){?>
                     <p class="pull-left"><span><i class="fa fa-book"></i> Assign &nbsp;:&nbsp;<?php echo $totalNoOfAssignUser; ?></span>
                     &nbsp;&nbsp;&nbsp;<span><i class="fa fa-check"></i> Submitted &nbsp;:&nbsp;<?php echo $totalNoOfUsersubmitedAssignment; ?></span></p>
                     <?php  }  } ?> 
                     <p>Posted On-&nbsp;&nbsp;<?php echo date('d M , Y',strtotime($assignment['created']))?></p>              
              </div>

            </div>
          </div>
         <?php } ?>  
    <?php }  ?>
      </div>
      <div id="load_img_div"></div>
    </div>
    </div>
  </div>

 <div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Assignments Found.</h3></div>

</div>
<?php $this->load->view('template/footer');?>
