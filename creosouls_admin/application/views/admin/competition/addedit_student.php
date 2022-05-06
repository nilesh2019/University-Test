<style>
.label-wrapper{
text-align: left;
}
.requiredClass{
color: red;
}
#juryModal .modal-body{
  margin-left: -18px;
}
#juryModal {
   z-index: 9997;
}
.modal-open .modal {
  overflow-x: hidden;
  overflow-y: auto;
}
</style>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header vd_bg-blue vd_white">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="myModalLabel" class="modal-title">Add Student To Competition</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="instituteRegistrationForm"  enctype="multipart/form-data" action="#" role="form" method="post">
          <div class="alert alert-danger vd_hidden">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
            <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. </div>
            <div class="alert alert-success vd_hidden">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong>. 
            </div>
            <div id="instituteFormFields" class="form-group  mgbt-xs-20">
              <div class="col-md-12">
                <div class="label-wrapper ">
                  <label class="control-label">
                    Zone 
                  </label> (
                  <span class="requiredClass">
                    *
                  </span>)
                </div>

                <?php  $CI =& get_instance();
                $CI->load->model('modelbasic');
                  if($this->session->userdata('admin_level') == 1){
                    $zoneList = $CI->modelbasic->getSelectedData('zone_list','*');
                    
                  }
                  if($this->session->userdata('admin_level') == 4){
                    
                    $zoneListId = $CI->modelbasic->getInstituteZone();
                    
                    $zoneid = $zoneListId[0];
                    
                    $zoneList = $CI->modelbasic->getSelectedData('zone_list','*',array('id'=>$zoneid));
                    
                  }
                    if($this->session->userdata('admin_level') == 2){
                      $zoneList = $CI->modelbasic->getSelectedData('zone_list','*');
                      
                    }

                ?>
                <div class="vd_input-wrapper light-theme">
                  <select class="ui dropdown" name="zone" id="zone" onchange="getRegionList(this)">
                    <option value="">Select Zone</option>
                    <?php if(!empty($zoneList))
                    { 
                      foreach($zoneList as $Zlist){  ?>
                      <option value="<?php echo $Zlist['id'];?>"><?php echo $Zlist['zone_name'];?></option>
                   <?php  } 
                    }?>
                  </select>
                </div>
                <br/>
                <div class="label-wrapper ">
                  <label class="control-label">
                    Region 
                  </label> (
                  <span class="requiredClass">
                    *
                  </span>)
                </div>
                <div class="vd_input-wrapper light-theme">
                  <select class="form-control" name="region" id="region" onclick="getInstituteList(this)">
                    <option value="">Select Region</option>               
                  </select>
                </div>
                <br/>
                <div class="label-wrapper ">
                  <label class="control-label" for="groupName">Institute</label>
                </div>
                <div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
                    <select  class="form-control" name="institute" id="institute" onclick="getStudentList(this)">
                      <option value="" >Select Institute</option>
                    </select>
                </div>
                
                </br>
                <div class="label-wrapper ">
                  <label class="control-label" for="groupName">Student</label>
                </div>
                <div class="vd_input-wrapper light-theme" id="zone-input-wrapper">
                    <select  class="form-control" name="student[]" id="student" multiple="multiple">
                      <option value="" >Select Students</option>
                    </select>
                </div>
                
                </br>
                <div class="label-wrapper ">
                  <label class="control-label" for="instituteName">Select Competition</label> (<span class="requiredClass"> * </span>)
                </div>
                <?php  
                  $CI =& get_instance();
                  $CI->load->model('modelbasic');
                  $competitionList = $CI->modelbasic->getSelectedData('competitions','id,name',array('competition_type'=>3));
                ?>
                <div class="vd_input-wrapper light-theme">
                  <select class="ui dropdown" name="competition" id="competition">
                    <option value="">Select Competition</option>
                    <?php if(!empty($competitionList))
                    { 
                      foreach($competitionList as $Clist){  ?>
                      <option value="<?php echo $Clist['id'];?>"><?php echo $Clist['name'];?></option>
                   <?php  } 
                    }?>
                  </select>
                </div>
                
                <br/>
            
               
              </div>
            </div>
            <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
            <div class="form-group">
              <div class="col-md-12 text-center mgbt-xs-5">
                <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="institute-submit">Submit</button>
              </div>
              <input type="hidden" name="competitionId" id="competitionId">
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>


