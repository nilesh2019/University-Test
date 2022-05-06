<style>
  .label-wrapper
  {
    text-align: left;
  }
  .requiredClass
  {
    color: red;
  }
</style>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header vd_bg-blue vd_white">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="myModalLabel" class="modal-title">Add Product</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="admin-form" enctype="multipart/form-data" action="#" role="form" method="post">
          <div class="alert alert-danger vd_hidden">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
              <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. 
          </div>
          <div class="alert alert-success vd_hidden">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
            <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span>
            <strong>Well done!</strong>. 
          </div>
          <div class="form-group  mgbt-xs-20">
            <div class="col-md-12">
              <div class="label-wrapper light-theme">
                <label>Product Name</label>
              </div>
              <div class="vd_input-wrapper light-theme" id="name-input-wrapper"> 
                <span class="menu-icon"> <i class="fa fa-file-o"></i> </span>
                <input type="text" placeholder="Name" id="name" name="name" class="required">
              </div>
              <br/>
              <div class="label-wrapper">
                <label class="control-label " for="description">Description</label> (
                <span class="requiredClass">*</span>)
              </div>
              <div class="vd_input-wrapper light-theme">
                <textarea id="wysiwyghtml" name="description" class="width-100 form-control"  rows="7" placeholder="Write your message here"></textarea>
              </div>
              <br/>
            </div>
          </div>
          <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
          <div class="form-group">
            <div class="col-md-12 text-center mgbt-xs-5">
              <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="admin-submit">Submit</button>
            </div>
            <input type="hidden" name="id" id="id">
          </div>
        </form>
      </div>           
    </div>    
  </div>
</div>
