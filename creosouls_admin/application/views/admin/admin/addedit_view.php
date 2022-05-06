<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
      <div class="modal-dialog">
             <div class="modal-content">
                   <div class="modal-header vd_bg-blue vd_white">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
                          <h4 id="myModalLabel" class="modal-title">Add admin</h4>
                   </div>
                   <div class="modal-body">
                 <form class="form-horizontal" id="admin-form" action="#" role="form" method="post">
                 <div class="alert alert-danger vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span><strong>Oh snap!</strong> Please correct following errors and try submiting it again. </div>
                 <div class="alert alert-success vd_hidden">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                   <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong>. </div>
                   <div class="form-group  mgbt-xs-20">
                     <div class="col-md-12">
                       <div class="label-wrapper sr-only">
                         <label>Name</label>
                       </div>
                       <div class="vd_input-wrapper light-theme" id="name-input-wrapper"> <span class="menu-icon"> <i class="fa fa-user"></i> </span>
                         <input type="text" placeholder="Name" id="name" name="name" class="required">
                       </div>
                       <br/>
                       <div class="label-wrapper sr-only">
                         <label>Email</label>
                       </div>
                       <div class="vd_input-wrapper light-theme" id="email-input-wrapper"> <span class="menu-icon"> <i class="fa fa-envelope"></i> </span>
                         <input type="email" placeholder="Email" id="email" name="email" class="required">
                       </div>
                       <br/>
                       <?php if($this->session->userdata('admin_id')==1 && $this->session->userdata('admin_level')==1){?>
                       <div class="label-wrapper">
                         <label>Manage User</label>
                       </div>  
                       <div>                   
                       <input type="radio" name="manage_user" checked value="0"> No
                         <input type="radio" name="manage_user" value="1"> Yes  
                      </div>                            
                     <?php } ?>
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
