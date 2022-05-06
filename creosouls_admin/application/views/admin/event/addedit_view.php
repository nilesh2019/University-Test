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
                       <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">Event Name</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                         <input type="text" placeholder="Name" id="name" name="name" class="required">
                       </div>
                       <br/>

                      <!-- <input type="hidden" id="adminId" name="adminId">-->
                     <div class="label-wrapper">
                       <label class="control-label " for="address">Description</label> (<span class="requiredClass"> * </span>)
                     </div>
                     <div class="vd_input-wrapper light-theme" id="address-input-wrapper" > <!-- <span class="menu-icon"> <i class="icon-location"></i> </span> -->
                       <textarea placeholder="Description" id="description" name="description" class="required"></textarea>
                     </div>
                     <br/>
                       <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">Coupon Code</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                         <input type="text" placeholder="Coupon Code" id="coupon_code" name="coupon_code" class="required">
                       </div>
                       <br/>

                         <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">Start Date</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                         <input type="text" placeholder="Start Date" readonly="true" id="start_date" name="start_date" class="required">
                       </div>
                       <br/>
                         <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">End Date</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                         <input type="text" placeholder="End Date" readonly="true" id="end_date" name="end_date" class="required">
                       </div>
                       <br/>
                       <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">Video Link</label> 
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-link "></i> </span>
                         <input type="text" placeholder="Video Link" id="videolink" name="videolink" >
                       </div>
                       <br/>
                        <div class="label-wrapper ">
                       <label class="control-label" for="instituteName">Event Link</label> 
                       </div>
                       <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-link "></i> </span>
                         <input type="text" placeholder="Event Link" id="link" name="link" >
                       </div>
                       <br/>
                       <div class="label-wrapper">
                         <label class="control-label " for="coverImage">Event Cover Picture</label>
                       </div>
                       <div class="vd_input-wrapper light-theme" id="coverImage-input-wrapper" > <span class="menu-icon"></span>
                         <input onchange="readURL(this)" type="file" placeholder="Competition Cover Picture." id="banner" name="banner">
                         <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB ( 690 W * 300 H ))</span>
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
