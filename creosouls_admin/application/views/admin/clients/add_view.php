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
                          <h4 id="myModalLabel" class="modal-title">Add Client</h4>
                   </div>
                   <div class="modal-body">
                 <form class="form-horizontal" id="login-form" enctype="multipart/form-data" action="#" role="form" method="post">
                 <div class="alert alert-danger vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. </div>
                 <div class="alert alert-success vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong>. </div>
                   <div id="jobFormFields" class="form-group  mgbt-xs-20">
                     <div class="col-md-12">
                       <div class="label-wrapper ">
                       <label class="control-label" for="title">Name</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme" id="title-input-wrapper"> <span class="menu-icon"> <i class="fa fa-envelope"></i> </span>
                         <input type="text" placeholder="Client Name" id="name" name="name" class="required">
                       </div>
                       <br/>

                       <div class="label-wrapper">
                         <label class="control-label " for="logo">Company Logo</label>
                       </div>
                       <div class="vd_input-wrapper light-theme" id="logo-input-wrapper" > <span class="menu-icon"></span>
                         <input type="file" placeholder="Logo image." id="logo" name="logo">
                         <span style="color: green; float: left;">(Note:- Allowed file types " gif, jpg, png, jpeg ", Allowed size 2MB)</span>
                         <img width="200" height="200" id="logoPreview" src="#" alt="" />
                         <input type="hidden" id="img_name"  value="">

                       </div>
                        <div id="img_error" style="color: red" ></div>
                       <br/>
                       <br/>
                       <div class="label-wrapper">
                         <label class="control-label " for="description">Description</label> (<span class="requiredClass"> * </span>)
                       </div>
                       <div class="vd_input-wrapper light-theme">
                        <textarea id="wysiwyghtml" name="description" class="width-100 form-control"  rows="15" placeholder="Write your message here"></textarea>
                       </div>
                     </div>
                   </div>
                   <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
                   <div class="form-group">
                     <div class="col-md-12 text-center mgbt-xs-5">
                       <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="login-submit">Submit</button>
                     </div>
                     <input type="hidden" name="clientId" id="clientId">
                   </div>
                 </form>
                   </div>
              <!--      <div class="modal-footer background-login">
                   <button data-dismiss="modal" class="btn vd_btn vd_bg-grey" type="button">Close</button>
                   <button class="btn vd_btn vd_bg-green" type="button">Save changes</button>
                   </div> -->
             </div>
      <!-- /.modal-content -->
      </div>
<!-- /.modal-dialog -->
</div>
