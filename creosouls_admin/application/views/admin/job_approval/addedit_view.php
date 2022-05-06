<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header vd_bg-blue vd_white">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
        <h4 id="myModalLabel" class="modal-title">Add admin</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="job_application_form" action="#" role="form" method="post">
          <div class="alert alert-danger vd_hidden">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
            <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. </div>
            <div class="alert alert-success vd_hidden">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
              <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong>. </div>
              <div class="form-group  mgbt-xs-20">
                <div class="col-md-12">
                  <div class="label-wrapper sr-only">
                    <label>Comment</label>
                  </div>
                  <textarea placeholder="Comment" id="comment" name="comment" class="required" required></textarea>
                  <br/>
                  <br/>
                </div>
              </div>
              <div id="vd_login-error" class="alert alert-danger hidden"><i class="fa fa-exclamation-circle fa-fw"></i> Please fill the necessary field </div>
              <div class="form-group">
                <div class="col-md-12 text-center mgbt-xs-5">
                  <button class="btn vd_btn vd_btn-bevel vd_bg-blue font-semibold width-100" type="submit" id="admin-submit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>