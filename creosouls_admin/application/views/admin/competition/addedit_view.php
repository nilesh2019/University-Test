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
          <h4 id="myModalLabel" class="modal-title">Add Competition</h4>
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
                <?php if($this->session->userdata('admin_level')==4)
                {?>
                  <div class="label-wrapper ">
                    <label class="control-label" for="instituteName">Select Institute:</label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="open_for_all-input-wrapper">
                    <select name="institutename[]" id="institutename" multiple="">
                      <option value=""></option>
                      <?php
                      foreach ($institutedata as $ins) { ?>
                        <option value="<?php echo $ins['id']?>"><?php echo $ins['instituteName']?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <br/>
                <?php }
                ?>
                  <div class="label-wrapper ">
                    <label class="control-label" for="instituteName">Competition Name</label> (<span class="requiredClass"> * </span>)
                  </div>
                  <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                    <input type="text" placeholder="Name" id="name" name="name" class="required">
                  </div>
                  <br/>
                  <div class="label-wrapper ">
								    <label class="control-label" for="pageName">
									    Page display name
								    </label> (
								    <span class="requiredClass">
									    *
								    </span>)
							    </div>
							    <div class=" col-md-12" style="padding: 0px !important">
                    <div class="col-md-7" style="line-height: 42px; padding: 0px ! important; float: left; text-align: right; font-weight: bold; font-size: 14px; color: rgb(12, 153, 213); background: rgb(204, 204, 204) none repeat scroll 0% 0%;">
									   <?php echo front_base_url();?>competition/
								    </div>
								    <div class="col-md-5" style="padding: 0px !important;text-align:left;">
									    <div class="vd_input-wrapper light-theme" id="pageName-input-wrapper">
										<!--   <span class="menu-icon"> <i class="fa fa-university"></i> </span> -->
										    <input style="padding-left: 5px !important" type="text" placeholder="Competition page display name" id="pageName" name="pageName" class="required">
									    </div>
								    </div>
							    </div>
							    <br/>
                  <div class="label-wrapper ">
                    <label class="control-label" for="country">Competition Type</label>(<span class="requiredClass"> * </span>)
                  </div>
                  <div class="vd_input-wrapper light-theme">
                    <select name="ctype" id="ctype" >
                      <option value="">Select Competition Type</option>
                      <option value="1">Single Competition</option>
                      <option value="2">Team Competition</option>
                      <option value="3">Level Competition</option>
                    </select>
                  </div>
                  <br/>      
                  <div class="label-wrapper">
					          <label class="control-label" for="contactEmail">Contact Email ID</label> (<span class="requiredClass"> * </span>)
				          </div>
				          <div class="vd_input-wrapper light-theme" id="contactEmail-input-wrapper">
					          <input type="text" placeholder="Contact Email ID for Competition" id="contactEmail" name="contactEmail" class="required">
				          </div>
				          <br/>
                  <input type="hidden" id="instituteId" name="instituteId">
                  <div class="label-wrapper">
                    <label class="control-label " for="address">Description</label> (<span class="requiredClass"> * </span>)
                  </div>
                  <div class="vd_input-wrapper light-theme" id="address-input-wrapper" > <!-- <span class="menu-icon"> <i class="icon-location"></i> </span> -->
                    <textarea placeholder="Description" id="description" name="description" class="required"></textarea>
                  </div>
                  <br/>
                  <div class="label-wrapper ">
				            <label id="hidenameLabel" class="control-label" for="hidename">Participant Name Display</label>
				&nbsp;&nbsp;<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="hidename" name="hidename" checked="">
			            </div>
                  <div class="label-wrapper ">
                    <label class="control-label" for="Categorywisewinner">Category wise winner:</label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="Category-wise-winner-input-wrapper">
                    <input style="float: left; margin-right: 10px; margin-left: 33px;" id="Category_wise_winner" type="checkbox" name="category_wise_winner">
                    <span style="float:left;">Category wise winner:</span><br>
                    <span style="color: green;">(Note:- If checked, then competition is category wise winners for all Users of institute only. otherwise for institute only or open for all)</span>               
                  </div>
                  <br/>
		              <div class="label-wrapper" id="Number_of_Winners">
			               <label class="control-label" for="winnerCount">Number of Winners</label> (<span class="requiredClass"> * </span>)
		              </div>
		              <div class="vd_input-wrapper light-theme" id="winnerCount-input-wrapper">
			              <input type="text" placeholder="Number of Winners" id="winnerCount" onblur="myFunction(this.value)" name="winnerCount" class="required" value="">
		              </div>
                  <br/>
                  <div id="winnerTitles"></div>
                    <div class="label-wrapper">
                      <label class="control-label " for="address">Award</label> (<span class="requiredClass"> * </span>)
                    </div>
                  <div class="vd_input-wrapper light-theme" id="address-input-wrapper" > <!-- <span class="menu-icon"> <i class="icon-location"></i> </span> -->
                    <textarea placeholder="Award" id="award" name="award" class="required"></textarea>
                  </div>
                  <br/>
                  <span style="color: green; float: left;">(Note:- Click Add jury button to add new jury members.If you are RAH, then jury is not mandatory)</span>
                  <a href="#juryModal" class="btn btn-default btn-xs" data-toggle="modal">Add jury</a>
                  <div class="label-wrapper">
                    <label class="control-label " for="address">Jury Members</label> (<span class="requiredClass"> * </span>)
                  </div>
                  <div class="vd_input-wrapper light-theme" id="jury-input-wrapper" > <!-- <span class="menu-icon"> <i class="icon-location"></i> </span> -->
                       <!-- <textarea placeholder="Jury Members" id="jury" name="jury" class="required"></textarea> -->
                    <select id="tokenize" multiple="multiple" class="tokenize-sample jury" name="jury[]">
                       </select>
                  </div>
                  <br/>
                  <div class="label-wrapper">
                    <label class="control-label " for="eligibility">Eligibility</label> (<span class="requiredClass"> * </span>)
                  </div>
                  <div class="vd_input-wrapper light-theme" id="eligibility-input-wrapper" > <!-- <span class="menu-icon"> <i class="icon-location"></i> </span> -->
                    <textarea placeholder="Eligibility" id="eligibility" name="eligibility" class="required"></textarea>
                  </div>
                  <br/>
                  <div class="label-wrapper">
				            <label class="control-label" for="rule">Rules (<span class="requiredClass"> * </span>) </label>
			            </div>
			            <div class="vd_input-wrapper light-theme" id="rule-input-wrapper" >
				            <textarea placeholder="Rules" name="rule" class="required" id="wysiwyghtml" class="width-100 form-control"  rows="5"></textarea>
			            </div>
			            <br/>
                  <div class="label-wrapper ">
                    <label class="control-label" for="instituteName">Video Link</label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="instituteName-input-wrapper"> <span class="menu-icon"> <i class="fa fa-university"></i> </span>
                    <input type="text" placeholder="Video Link" id="video_link" name="video_link">
                  </div>
                  <br/>
                  <div class="label-wrapper">
                    <label class="control-label " for="coverImage">Upload PDF file </label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="coverImage-input-wrapper" > <span class="menu-icon"></span>
                    <input type="file" placeholder="Competition PDF File." id="pdf_file" name="pdf_file">
                    <span style="color: green; float: left;">(Note:- Allowed file types " pdf"))</span>
                    <br/>           
                  </div>
                  </br>
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
					          <label class="control-label" for="evaluation_start_date">Evaluation Start Date</label> (<span class="requiredClass"> * </span>)
				          </div>
				          <div class="vd_input-wrapper light-theme" id="evaluation_start_date-input-wrapper">
					          <input type="text" placeholder="Evaluation Start Date" readonly="true" id="evaluation_start_date" name="evaluation_start_date" class="required">
				          </div>
				          <br/>
				          <div class="label-wrapper ">
					          <label class="control-label" for="evaluation_end_date">Evaluation End Date</label> (<span class="requiredClass"> * </span>)
				          </div>
				          <div class="vd_input-wrapper light-theme" id="evaluation_end_date-input-wrapper">
					          <input type="text" placeholder="Evaluation End Date" readonly="true" id="evaluation_end_date" name="evaluation_end_date" class="required">
				          </div>
				          <br/>
                  <?php 
                  if($this->session->userdata('admin_level') ==2 || $this->session->userdata('admin_level') ==3)
                  { ?>
                  <div class="label-wrapper ">
                    <label class="control-label" for="instituteName">Open for all:</label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="open_for_all-input-wrapper">
                    <input style="float: left; margin-right: 10px; margin-left: 33px;" id="open_for_all" type="checkbox" name="open_for_all">
                    <span style="float:left;">Open for all</span><br>
                    <span style="color: green;">(Note:- If checked, then competition open for all Users. otherwise for institute users)
                    </span>
                  </div>
                  <br/>
                  <?php 
                  } ?>

					        <div class="label-wrapper " style="display: none;">
					   	      <label class="control-label" for="country">Competition for Country</label>(<span class="requiredClass"> * </span>)
					        </div>
					        <div class="vd_input-wrapper light-theme" style="display: none;">
					   	      <select name="country" id="country" onchange="getCities(this.value)">
					   		    <!-- <option value="">Select Country</option> -->
					   		    <?php
					   		    /*$ci=&get_instance();
					   		    $ci->load->model('competition_model');
					   		    $country=$ci->competition_model->getAllCountry();*/
					   		    foreach ($countries as $val) { ?>
					   		      <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
					   		    <?php } ?>
					   	      </select>
					        </div>
					        <!-- <br/> -->
					        <div class="label-wrapper " style="display: none;">
					   	      <label class="control-label" for="city">Competition for City</label>(<span class="requiredClass"> * </span>)
					        </div>
                  <div class="label-wrapper ">
					          <label class="control-label" for="certificate">Send Certificates</label>
					          &nbsp;&nbsp;
                    <input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="blue" id="certificate" name="certificate" data-on-text="Yes" data-off-text="No" checked="">
				          </div>
				          <div class="label-wrapper">
					          <label class="control-label" for="winnerEmail">Winner Email Body</label>
				          </div>
				          <div class="vd_input-wrapper light-theme" id="winnerEmail-input-wrapper" >
					          <textarea placeholder="Rules" name="winnerEmail" id="elm1" rows="15" cols="10" style="width:100%" class="myTextEditor width-100 form-control"></textarea>
				          </div>
                  <div class="label-wrapper">
                    <label class="control-label " for="competitionLogo">Competition Logo (<span class="requiredClass"> * </span>) </label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="competitionLogo-input-wrapper" > 
                    <span class="menu-icon"></span>
                    <input onchange="readURL(this)" type="file" placeholder="Competition Logo image." id="profile_image" name="profile_image">
                    <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB (Recommended size for best view 200 W * 200 H))</span>
                    <br/>
                    <img width="100" height="100" class="preview" id="logoPreview" src="#" alt="" />
                  </div>
                  <br/>
                  <div class="label-wrapper">
                    <label class="control-label " for="coverImage">Competition Cover Picture (<span class="requiredClass"> * </span>) </label>
                  </div>
                  <div class="vd_input-wrapper light-theme" id="coverImage-input-wrapper" > <span class="menu-icon"></span>
                    <input onchange="readURL(this)" type="file" placeholder="Competition Cover Picture." id="banner" name="banner">
                    <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB  (Recommended size for best view 945 W * 470 H))</span>
                    <br/>
                    <img class="preview" width="241" height="118" id="coverPreview" src="#" alt="" />
                   <!--       <div class="avatar-view" title="Change the avatar">
                           <img src="<?php echo base_url();?>backend_assets/img/picture.jpg" alt="Avatar">
                         </div> -->
                  </div>
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


<div class="modal fade" id="juryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">



      <div class="modal-body">

      <div style="display:none;" id="jurySuccess" class="alert alert-success alert-dismissable alert-condensed">

                      <i class="fa fa-exclamation-circle append-icon"></i><strong>Well done!</strong> <a id="jurySuccessData" class="alert-link" href="#"></a></div>

              <div style="display:none;" id="juryFail" class="alert alert-danger alert-dismissable alert-condensed">

                              <i class="fa fa-exclamation-circle append-icon"></i><strong>Oh snap!</strong> <a id="juryFailData" class="alert-link" href="#"></a></div>
      <form class="form-horizontal" id="addJuryFrom" style="margin-top:50px;">
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryName">Name<span class="requiredClass"> * </span></label>
              <div class="col-sm-10">
                  <input name="juryName" type="text" class="form-control" id="juryName">
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryEmail">Email<span class="requiredClass"> * </span></label>
              <div class="col-sm-10">
                  <input name="juryEmail" type="text" class="form-control" id="juryEmail">
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryName">Photo<span class="requiredClass"> * </span></label>
              <div class="col-sm-10">
                 <input onchange="readURL(this)" type="file" placeholder="Jury Photo." id="juryPhoto" name="juryPhoto">
                 <span style="color: green; float: left;">(Note:- Allowed file types " jpg, png, jpeg ", Allowed size 2MB)</span>
                 <br/>
                 <img width="100" height="100" class="preview juryPhoto" id="juryPhoto" src="#" alt="" />
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryWriteUp">Write Up<span class="requiredClass"> * </span></label>
              <div class="col-sm-10">
                  <textarea placeholder="juryWriteUp" id="juryWriteUp" name="juryWriteUp"></textarea>
              </div>
          </div>
          <div class="form-group" style="float: right;padding-right:15px">
               <a href="javascript:void('0')" class="btn btn-default" data-dismiss="modal">Cancel</a>
               <a href="javascript:void('0')" id="jury-submit" class="btn btn-danger" data-dismiss="submodal">Submit</a>
           </div>
      </form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


