          <!-- FILE UPLOAD -->
          <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/bootstrap-fileupload/bootstrap-fileupload.min.css" />	
          <!-- JQUERY UPLOAD -->
          <!-- blueimp Gallery styles -->
          <link rel="stylesheet" href="<?php echo base_url();?>backend_assets/js/blueimp/gallery/blueimp-gallery.min.css">
          <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
          <link rel="stylesheet" href="<?php echo base_url();?>backend_assets/js/jquery-upload/css/jquery.fileupload.css">
          <link rel="stylesheet" href="<?php echo base_url();?>backend_assets/js/jquery-upload/css/jquery.fileupload-ui.css">





           <div class="modal fade" id="csvJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog" style="width: 50% !important;">
               <div class="modal-content">
                 <div class="modal-header vd_bg-blue vd_white">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                   <h4 class="modal-title" id="myModalLabel">Add Job By CSV</h4>
                 </div>
                 <div class="modal-body">

                   <form action="<?php echo base_url();?>admin/jobs/add_csv" class="form-horizontal" method="POST" role="form" id="addUserCsv" enctype="multipart/form-data">
                     <div class="form-group">
                       <label class="col-sm-4 control-label">Add CSV :</label>
                       <div class="col-sm-8 controls">
                         <input type="file" name="csvfile">
                       </div>
                     </div>
                     <div class="form-group">
                           <div class="col-sm-offset-4 col-sm-8">
                           Download sample csv file						                                   
                           <?php if($this->session->userdata('admin_level')==1)
            				{ ?><a href="<?php echo front_base_url();?>assets/JobsDataSAdmin.csv" > <i class="fa fa-download"></i></a>
            				<?php } else if($this->session->userdata('admin_level')==2)
            				{ ?><a href="<?php echo front_base_url();?>assets/JobsDataIAdmin.csv" > <i class="fa fa-download"></i></a>
            				 <?php } else if($this->session->userdata('admin_level')==3)
            				{ ?><a href="<?php echo front_base_url();?>assets/JobsDataManager.csv" > <i class="fa fa-download"></i></a>
            			 	<?php } else if($this->session->userdata('admin_level')==4)
            				{ ?><a href="<?php echo front_base_url();?>assets/JobsDataHoAdmin.csv" > <i class="fa fa-download"></i></a>
            				 <?php } else if($this->session->userdata('admin_level')==5)
                    { ?><a href="<?php echo front_base_url();?>assets/JobsDataHoAdmin.csv" > <i class="fa fa-download"></i></a>
                     <?php } ?>
                           </div>
                     </div>

             		<div class="form-group" id="fileupload" >
             			<label class="control-label col-md-4">Detail Project Image </label>
             			<div class="col-md-8">
             				<div class="row fileupload-buttonbar">
             					<div class="col-lg-12">
             						<!-- The fileinput-button span is used to style the file input field as button -->
             						<span class="btn btn-success fileinput-button">
             							<i class="glyphicon glyphicon-plus"></i>
             							<span >Add files...</span>
             							<input type="file" name="userfile" multiple>
             						</span>
             						<span class="btn btn-primary start">
             							<i class="glyphicon glyphicon-upload"></i>
             							<span>Start upload</span>
             						</span>
             						<span type="reset" class="btn btn-warning cancel">
             							<i class="glyphicon glyphicon-ban-circle"></i>
             							<span>Cancel upload</span>
             						</span>
             						<span type="button" class="btn btn-danger delete">
             							<i class="glyphicon glyphicon-trash"></i>
             							<span>Delete</span>
             						</span>
             						<div style="clear:both;">
             							<input type="checkbox" class="toggle" style="width:10px;">
             						</div>
             						<!-- The global file processing state -->
             						<span class="fileupload-process"></span>
             					</div>
             					<!-- The global progress state -->
             					<div class="col-lg-5 fileupload-progress fade">
             						<!-- The global progress bar -->
             						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
             							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
             						</div>
             						<!-- The extended global progress state -->
             						<div class="progress-extended">&nbsp;</div>
             					</div>
             				</div>
                     				<!-- The table listing the files available for upload/download -->
                     			<table role="presentation" class="table table-striped" style="width:"><tbody class="files" ></tbody></table>
                     			<span class="error-span"><?php echo form_error('image');?></span>
                     			<!-- The blueimp Gallery widget -->
                     			<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                     				<div class="slides"></div>
                     				<h3 class="title"></h3>
                     				<a class="prev">‹</a>
                     				<a class="next">›</a>
                     				<a class="close">×</a>
                     				<a class="play-pause"></a>
                     			      <ol class="indicator"></ol>
                     		       </div>
                     	      </div>
                     </div>




                     <div class="modal-footer background-login">
                       <button type="button" class="btn vd_btn vd_bg-grey" data-dismiss="modal">Close</button>
                       <input type="submit" class="btn vd_btn vd_bg-green"  id="submitCsvUser" value="Submit">
                     </div>
                   </form>
                 </div>
               </div>
               <!-- /.modal-content -->
             </div>
             <!-- /.modal-dialog -->
           </div>


           <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">