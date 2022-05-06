<style>
.label-wrapper{
text-align: left;
}
.requiredClass{
color: red;
}
  </style>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
      <div class="modal-dialog">
             <div class="modal-content">
                   <div class="modal-header vd_bg-blue vd_white">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
                          <h4 id="myModalLabel" class="modal-title">Add New Event</h4>
                   </div>
                   <div class="modal-body">
                 <form class="form-horizontal" id="instituteRegistrationForm" enctype="multipart/form-data" action="#" role="form" method="post">
                 <div class="alert alert-danger vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. </div>
                 <div class="alert alert-success vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong>. </div>
                   <div id="instituteFormFields" class="form-group  mgbt-xs-20">
                     <div class="col-md-12">
                    
                      
                      <div class="label-wrapper">
                         <label class="control-label " for="coverImage">Banner Picture</label>
                       </div>
                       <div class="vd_input-wrapper light-theme" id="coverImage-input-wrapper" > <span class="menu-icon"></span>
                         <input onchange="readURL(this)" type="file" placeholder="Competition Cover Picture." id="banner" name="banner">
                         <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB ( 1200 W * 400 H ))</span>
                         <br/>
                         <img class="preview" width="230" height="100" id="coverPreview" src="#" alt="" />
                       </div>

                     </div>
                   </div>
                   <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
                   <div class="form-group">
                     <div class="col-md-12 text-center mgbt-xs-5">
                       <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="institute-submit">Submit</button>
                     </div>
                     <input type="hidden" name="eventId" id="eventId">
                   </div>
                 </form>
                   </div>

             </div>
      <!-- /.modal-content -->
      </div>
<!-- /.modal-dialog -->
</div>
