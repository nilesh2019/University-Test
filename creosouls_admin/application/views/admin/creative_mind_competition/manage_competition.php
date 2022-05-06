<?php $this->load->view('admin/template/header');?>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">
 -->
<style>
  #ui-id-1{
  z-index: 10000 !important;
  }
  .widget .vd_panel-menu > .entypo-icon{
    background: transparent;
  }
  .vd_title-section .vd_panel-menu > .menu{
    padding:3px 15px !important;
  }

  #ratingsModal .modal-header, .modal-footer
  {
    background: #eee !important;
  }

</style>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/css/jquery.tokenize.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/dist/cropper.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>backend_assets/css/main.css" rel="stylesheet">
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css">
  <!-- Header Ends -->
<div class="content">
  <div class="container" id="crop-avatar">
  <?php $this->load->view('admin/template/navbar_view');?>
    <!-- Middle Content Start -->
    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin">Home</a> </li>
                <li class="active">Manage Creative Mind Competition</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>
</div>
            </div>
          </div>
          <div class="vd_title-section clearfix">
          <div class="vd_panel-header">
            <?php if($this->session->flashdata('success'))
            {
            ?>
                    <div class="alert alert-success alert-dismissable alert-condensed">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                                    <i class="fa fa-exclamation-circle append-icon"></i><strong>Well done!</strong> <a class="alert-link" href="#"><?php echo $this->session->flashdata('success');?> </a></div>
            <?php
            }
            elseif($this->session->flashdata('error'))
            {
            ?>
            <div class="alert alert-danger alert-dismissable alert-condensed">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                            <i class="fa fa-exclamation-circle append-icon"></i><strong>Oh snap!</strong> <a class="alert-link" href="#"><?php echo $this->session->flashdata('error');?></a></div>
                            <?php } ?>
                            </div>
                            <?php
                            $errorLog=$this->session->userdata('errorLog');
                            $this->session->unset_userdata('errorLog');
                            if(!empty($errorLog))
                            {
                            ?>
                            <div class="row">
                                          <div class="col-sm-12">
                                            <div class="panel widget">
                                              <div class="panel-heading vd_bg-yellow">
                                                <h3 class="panel-title"> <span class="menu-icon"> <i class="icon-pie"></i> </span> Error Log </h3>
                                                <div class="vd_panel-menu">
                              <div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Minimize" data-action="minimize"> <i class="icon-minus3"></i> </div>
                              <div class=" menu entypo-icon smaller-font" data-placement="bottom" data-toggle="tooltip" data-original-title="Refresh" data-action="refresh"> <i class="icon-cycle"></i> </div>
                              <div class=" menu entypo-icon" data-placement="bottom" data-toggle="tooltip" data-original-title="Close" data-action="close"> <i class="icon-cross"></i> </div>
                            </div>
                            <!-- vd_panel-menu -->
                            </div>
                            <div class="panel-body-list">
                              <div class="content-list content-image menu-action-right">
                                <div  data-rel="scroll" >
                                  <ul class="list-wrapper pd-lr-15">
                                                    <?php
                                                    foreach($errorLog['errorMessage'] as $key => $value)
                                                    {
                                                    ?>
                                                      <li>
                                                        <div class="menu-icon"></div>
                                                        <div class="menu-text">
                                                        <?php
                                                        foreach($value as $msg)
                                                        {
                                                        ?>
                                                              <div class="menu-info">Error message:- <a href="javascript:void('0');" style="cursor:default;color:red;"><?php echo $msg;?></a></div>
                                                        <?php
                                                          }
                                                        ?>
                                                        </div>
                                                        <div class="menu-text">
                                                          <div class="menu-info">Error on line no:- <a href="javascript:void('0');" style="cursor:default;color:red;"><?php echo $key;?></a></div>
                                                        </div>
                                                      </li>
                                                             <?php
                                                             }
                                                      ?>
                                               </ul>
                                             </div>
                                           </div>
                                         </div>
                                       </div>
                                            <!-- Panel Widget -->
                                          </div>
                                        </div>
                                <?php } ?>
          <div class="vd_content-section clearfix">
            <div class="row">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage Creative Mind Competition Table</h3>
                  </div>
                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                         <center>
                    <?php $this->load->view('admin/creative_mind_competition/addedit_view');?>
                    <?php $this->load->view('admin/creative_mind_competition/ratings_view');?>
                    </center>
                      <button id="addInstitute" style="float:right;margin-bottom:10px;" class="btn btn-primary" onclick="getAutocomplete();"  data-toggle="modal" data-target="#myModal">Add Creative Mind Competition</button>
                        <form action="<?php echo base_url();?>admin/creative_mind_competition/multiselect_action" method="post" name="myform" id="myform">
                            <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><input type="checkbox" id="check"></th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Banner</th>
                                  <!--  <th>Admin Name</th>-->
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            </table>
                                  <div class="row">
                                      <div class="col-md-12">
                                            <div class="col-md-3">
                                                  <select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;" >
                                                  <option value=""> Select Action</option>
                                                  <option value="1"> Activate</option>
                                                  <option value="2"> Deactivate</option>
                                                  <option value="3"> Delete</option>
                                                  </select>
                                            </div>
                                      <div class="col-md-2">
                                            <input type="submit" name="submit" value="Go" onclick="return validateForm();" class="btn btn-info-night" style="float: left;" >
                                      </div>
                                      <div class="col-md-6">
                                      </div>
                                    </div>
                                </div>
                        </form>
                  </div>
                </div>
                <!-- Panel Widget -->
              </div>
              <!-- col-md-12 -->
            </div>
            <!-- row -->
          </div>
          <!-- .vd_content-section -->
        </div>
        <!-- .vd_content -->
      </div>
      <!-- .vd_container -->
    </div>
    <!-- .vd_content-wrapper -->
    <!-- Middle Content End -->



    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="<?php echo base_url();?>admin/creative_mind_competition/upload_image" enctype="multipart/form-data" method="post">
            <div class="modal-header">
              <button class="close" data-dismiss="modal" type="button">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input class="avatar-src" name="avatar_src" type="hidden">
                  <input class="avatar-data" name="avatar_data" type="hidden">
                  <label for="avatarInput">Local upload</label>
                  <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <div class="col-md-9">
                    <div class="btn-group">
                  <button class="btn btn-primary" title="Move" type="button" data-option="move" data-method="setDragMode">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("setDragMode", "move")">
                  <span class="icon icon-move"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Crop" type="button" data-option="crop" data-method="setDragMode">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("setDragMode", "crop")">
                  <span class="icon icon-crop"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Zoom In" type="button" data-option="0.1" data-method="zoom">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("zoom", 0.1)">
                  <span class="icon icon-zoom-in"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Zoom Out" type="button" data-option="-0.1" data-method="zoom">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("zoom", -0.1)">
                  <span class="icon icon-zoom-out"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Rotate Left" type="button" data-option="-45" data-method="rotate">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("rotate", -45)">
                  <span class="icon icon-rotate-left"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Rotate Right" type="button" data-option="45" data-method="rotate">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("rotate", 45)">
                  <span class="icon icon-rotate-right"></span>
                  </span>
                  </button>
                  </div>
                  <div class="btn-group">
                  <button class="btn btn-primary" title="Crop" type="button" data-method="crop">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("crop")">
                  <span class="icon icon-ok"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Clear" type="button" data-method="clear">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("clear")">
                  <span class="icon icon-remove"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Disable" type="button" data-method="disable">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("disable")">
                  <span class="icon icon-lock"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Enable" type="button" data-method="enable">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("enable")">
                  <span class="icon icon-unlock"></span>
                  </span>
                  </button>
                  <button class="btn btn-primary" title="Reset" type="button" data-method="reset">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("reset")">
                  <span class="icon icon-refresh"></span>
                  </span>
                  </button>
                  <label class="btn btn-primary btn-upload" title="Upload image file" for="inputImage">
                  <input id="inputImage" class="sr-only" type="file" accept="image/*" name="file">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="Import image with Blob URLs">
                  <span class="icon icon-upload"></span>
                  </span>
                  </label>
                  <button class="btn btn-primary" title="Destroy" type="button" data-method="destroy">
                  <span class="docs-tooltip" title="" data-toggle="tooltip" data-original-title="$().cropper("destroy")">
                  <span class="icon icon-off"></span>
                  </span>
                  </button>
                  </div>
                  </div>
                  <div class="col-md-3">
                    <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>


  </div>
  <!-- .container -->
</div>
<!-- .content -->
<!-- Footer Start -->
<?php $this->load->view('admin/template/footer');?>
<!-- Specific Page Scripts Put Here -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/jquery.tokenize.js"></script>
<script src="<?php echo base_url();?>backend_assets/dist/cropper.min.js"></script>
<script src="<?php echo base_url();?>backend_assets/js/main.js"></script>
<script type="text/javascript">

$(function() {

  $('#ratingsModal').on('hidden.bs.modal', function (e) {
   $('#ratingsModal').hide();
   $('#ratingInfo').html('');
  })

      $(document).on("click", "#viewRating", function ()
      {
           var projectId = $(this).data('id');
           var competitionId = $(this).data('cid');
           $.ajax({
            url: '<?php echo base_url();?>'+'admin/creative_mind_competition/getRating',
            type: 'POST',
            data: {projectId: projectId,competitionId:competitionId},
           })
           .done(function(res)
           {
              var obj = $.parseJSON(res);
              if(obj.length != 0)
              {
                $('#ratingInfo').show();
                $('#ratingInfo').html('<span style="line-height:18px;font-size: 14px;font-weight:bold;">Project Average Rating : '+obj.avgRating+'</span><br/><br/>'+obj.juryRatings);
              }
           });
      });
});


    $(document).ready(function() {
      var base_url='<?php echo base_url();?>';
        $('#tokenize').tokenize({
          newElements:false,
          datas: base_url+'admin/creative_mind_competition/getCompetitionJury',
          placeholder:'Type jury name or email.'
      });
      $('.tokenize-sample').css('width', '100%');
      $('.modal').on('hidden.bs.modal', function (e) {
          if($('.modal').hasClass('in')) {
          $('body').addClass('modal-open');
          }
      });

    });
</script>
           <script type="text/javascript" language="javascript" >
    function format ( d )
    {
           return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
            '<div class="panel-heading"> </div>'+
            '<div class="panel-body">'+
                    '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Competition Details</span><br><br>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong></strong> </div>'+
                      '<div class="col-xs-7">  '+d.competitionName+' </div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Competition Details</strong> </div>'+
                      '<div class="col-xs-7">  '+d.competitionDetails+' </div>'+
                    '</div>'+
                   '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Start Date:</strong> </div>'+
                      '<div class="col-xs-7">'+d.start_date+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>End Date:</strong> </div>'+
                      '<div class="col-xs-7">'+d.end_date+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Competition Status:</strong> </div>'+
                      '<div class="col-xs-7">'+d.status+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Awards:</strong> </div>'+
                      '<div class="col-xs-7">'+d.award+'</div>'+
                    '</div>'+

                     '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Eligibility:</strong> </div>'+
                      '<div class="col-xs-7">'+d.eligibility+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Rules:</strong> </div>'+
                      '<div class="col-xs-7">'+d.rule+'</div>'+
                    '</div>'+

                  '</div><div class="panel-body"><div class="col-md-12"><table id="example2" class="example2 display" cellspacing="0" width="100%">'+

                          '<thead style="background: #0c99d5 none repeat scroll 0 0 !important;">'+

                                '<tr>'+

                                    '<th>#</th>'+

                                    '<th>Project Title</th>'+

                                    '<th>Cover Image</th>'+

                                    '<th>Action</th>'+

                                    '</tr>'+

                            '</thead>'+

                            '<tbody>'+d.competition_projects+'<tbody>'+

                            '</table></div>'+
                  '</div></div>';
    }
/*  '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>User Details:</strong> </div>'+
                      '<div class="col-xs-7">'+d.admin_name+'</div>'+
                    '</div>'+*/
    $(document).ready(function() {
    var dt = $('#example').DataTable( {
       oLanguage: {
                sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
         },
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url();?>admin/creative_mind_competition/get_ajaxdataObjects",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            { "data": "chk" },
            { "data": "id" },
            { "data": "competitionName" },
            { "data": "competitionDetails" },
            { "data": "start_date" },
            { "data": "end_date" },
            { "data": "status" },
            { "data": "action" }
        ],
        "order": [],
         columnDefs: [
           { orderable: true, targets: [3,6,7] },
           { orderable: false, targets: [-1,0,2,1,4,5] },
           { "width": "5%", "targets": [0,1,2] },
           { "width": "10%", "targets": [6,7] },
           { "width": "10%", "targets": [-1] },
           { "width": "15%", "targets": [5,4] },
           { "width": "20%", "targets": [3] }
        ],
      "fnDrawCallback": function (oSettings) {
           nbr=0;
                $(".details-control").each(function()
                {
                    if(nbr > 0)
                    {
                        $(this).html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
                    }
                    nbr++;
                });
                $('tbody').css('border', '1px solid #eee');
     }
    } );
    // Array to track the ids of the details displayed rows
    var detailRows = [];
    $('#example tbody').on( 'click', 'tr td.details-control', function () {

     $("tr.details").each(function( index, val ) {
                $(this).next('tr').empty();
                $(this).removeClass('details');
                  $(this).find('td.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
              });
      
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
        if ( row.child.isShown() ) {
            $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
            tr.removeClass( 'details' );
            row.child.hide();
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_close.png">');
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
       $('.example2').DataTable();
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
      $("#check").click(function()
      {
            var checked_status = this.checked;
            $("#myform input[type=checkbox]").each(function(){
                this.checked = checked_status;
            });
     });



     
        var date = new Date();
        $("#start_date").datepicker({
            format: 'yyyy-mm-dd',
            startDate: date,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', (startDate));
            $('#evaluation_start_date').datepicker('setStartDate', startDate);
            $('#evaluation_end_date').datepicker('setStartDate', startDate);

          //  $('#assignment_form').formValidation('revalidateField', 'start_date');

        }).on('clearDate', function (selected) {
            $('#end_date').datepicker('setStartDate', null);
            $('#evaluation_start_date').datepicker('setStartDate', null);
            $('#evaluation_end_date').datepicker('setStartDate', null);

           // $('#assignment_form').formValidation('revalidateField', 'start_date');

        });

        $("#end_date").datepicker({
            format: 'yyyy-mm-dd',
            setDate: new Date(),
            startDate: date,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', endDate);
            $('#evaluation_start_date').datepicker('setStartDate', endDate.addDays(1));
            $('#evaluation_end_date').datepicker('setStartDate', endDate.addDays(1));

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        }).on('clearDate', function (selected) {
            $('#start_date').datepicker('setEndDate', null);
            $('#evaluation_start_date').datepicker('setStartDate', null);
            $('#evaluation_end_date').datepicker('setStartDate', null);

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        });


        $("#evaluation_start_date").datepicker({
            format: 'yyyy-mm-dd',
            setDate: new Date(),
            startDate: date,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', endDate);
            $('#end_date').datepicker('setEndDate', endDate);        
            $('#evaluation_end_date').datepicker('setStartDate', endDate);

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        }).on('clearDate', function (selected) {
            $('#start_date').datepicker('setEndDate', null);
            $('#end_date').datepicker('setStartDate', null);
            $('#evaluation_end_date').datepicker('setStartDate', null);

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        });


        $("#evaluation_end_date").datepicker({
            format: 'yyyy-mm-dd',
            setDate: new Date(),
            startDate: date,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', endDate);
            $('#end_date').datepicker('setEndDate', endDate);        
            $('#evaluation_start_date').datepicker('setEndDate', endDate);

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        }).on('clearDate', function (selected) {
            $('#start_date').datepicker('setEndDate', null);
            $('#end_date').datepicker('setStartDate', null);
            $('#evaluation_start_date').datepicker('setStartDate', null);

           // $('#assignment_form').formValidation('revalidateField', 'end_date');

        });
        


        Date.prototype.addDays = function(days) {
            this.setDate(this.getDate() + parseInt(days));
            return this;
        };




      /*$( "#evaluation_start_date" ).datepicker({ dateFormat: 'dd-M-yy',gotoCurrent: true,minDate: 0});
      $( "#evaluation_end_date" ).datepicker({ dateFormat: 'dd-M-yy',gotoCurrent: true,minDate: 0});*/



} );
function change_status(userId)
{
      var done = confirm("Are you sure, you want to change the status?");
      if(done == true)
      {
          var pageurl_new = '<?php echo base_url();?>'+'admin/creative_mind_competition/change_status/'+userId;
          window.location.href = pageurl_new;
      }
      else
      {
          return false;
      }
}
function delete_confirm(userId)
{
      var done = confirm("Are you sure to delete this record");
      if(done == true)
      {
          var pageurl_new = '<?php echo base_url();?>'+'admin/creative_mind_competition/delete_confirm/'+userId;
          window.location.href = pageurl_new;
      }
      else
      {
          return false;
      }
}
function emailToJury(compId)
{
	var done = confirm("Are you sure, you want to send reminder email to jury till who not rated anyone?");
	if(done == true)
	{
	    var pageurl_new = '<?php echo base_url();?>'+'admin/creative_mind_competition/emailToJury/'+compId;
	    window.location.href = pageurl_new;
	}
	else
	{
	    return false;
	}
}
function declareResult(compId)
{
  //alert(compId);
	var done = confirm("Are you sure, you want to declare result of this competition?");
	if(done == true)
	{
	    var pageurl_new = '<?php echo base_url();?>'+'admin/creative_mind_competition/declareResult/'+compId;
	    window.location.href = pageurl_new;
	}
	else
	{
	    return false;
	}
}
function validateForm()
{
      var total="";
      for(var i=0; i < document.myform.check.length; i++)
      {
          if(document.myform.check[i].checked)
          total +=document.myform.check[i].value + "\n";
      }
      if(total=="")
      {
          alert("Please select checkbox.");
          return false;
      }
      var listBoxSelection=document.getElementById("listaction").value;
      if(listBoxSelection==0)
      {
          alert("Please select Action");
          return false;
      }
      else
            if(listBoxSelection == 3){
            var done = confirm("Are you sure, you want to delete record's from database?");
            if(done == true){
              return true;
            }
            else
            {
              return false;
            }
      }
}
$(document).ready(function()
{
   $("#check").click(function(){
    var checked_status = this.checked;
    $("#myform input[type=checkbox]").each(function(){
      this.checked = checked_status;
    });
   });

   $('#myModal').on('hidden.bs.modal', function (e) {
    $('#myModal #myModalLabel').text('Add Competition');
    $('#instituteRegistrationForm')[0].reset();
          $(this).find('#tokenize').tokenize().clear();
          $(this).find('#logoPreview').attr('src',' ');
          $(this).find('#coverPreview').attr('src',' ');
   })

});
    </script>
<!-- Specific Page Scripts END -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/lightbox/themes/default/jquery.lightbox.css" />
  <!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lightbox/themes/default/jquery.lightbox.ie6.css" />
  <![endif]-->
       <script>
       $(document).ready(function() {
               "use strict";
               var registerInstituteForm = $('#instituteRegistrationForm');
               var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
               var success_registerInstituteForm = $('.alert-success', registerInstituteForm);
               registerInstituteForm.validate({
                   errorElement: 'div', //default input error message container
                   errorClass: 'vd_red', // default input error message class
                   focusInvalid: false, // do not focus the last invalid input
                   onsubmit: true,
                   ignore: "",
                   rules: {
                       name: {
                           required: true
                       },
                       pageName:
						{
							required: true
							/* remote: {
							url: '<?php echo base_url();?>'+'admin/institutes/change_st/'+$(this).val()+';',
							type: "post"
							}*/
						},
                       contactEmail: {
                           required: true
                       },
                       description: {
                           required: true
                       },
                       winnerCount: {
                           required: true,
                           number:true,
                           max:20
                       },

                       start_date:
                       {
                        required: true
                       },
                       end_date: {
                           required: true
                       },
                       evaluation_start_date:
                       {
                        required: true
                       },
                       evaluation_end_date: {
                           required: true
                       },
                        award: {
                           required: true
                       },
                        eligibility: {
                           required: true
                       },
                        'jury[]': {
                           required: true
                       },
                        rule: {
                           required: false
                       },
                        country: {
                           required: false
                       },
                       city: {
                           required: false
                       },

                       institute_name: {
                           required: false
                       }
                   },
                   messages: {
                   	pageName:
						{
							required:'Competition page display name is required'/*,
							remote:"already exist"*/
						},
                           name: "Competition name is required",
                           description:{
                            required:'Competition description is required'
                              },
                              winnerCount:{
                                required:'Number of number is required',
                                number:'Only number is required',
                                max:'Maximum number of winner for competition is 20.',
                                 },
                           start_date: "Competition Start date is required",
                           evaluation_start_date: "Competition Evaluation Start date is required",
                           award: "Award is required",
                           eligibility: "Eligibility is required",

                           city: "City name is required",
                           country: "Country is required",

                           contactEmail: "Contact email for competition is required",
                           end_date: "Competition End date is required",
                           evaluation_end_date: "Competition Evaluation End date is required"
                           },
                   errorPlacement: function(error, element) {
                       if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio")){
                           element.parent().append(error);
                       } else if (element.parent().hasClass("vd_input-wrapper")){
                           error.insertAfter(element.parent());
                       }else {
                           error.insertAfter(element);
                       }
                   },
                   invalidHandler: function (event, validator) { //display error alert on form submit
                       success_registerInstituteForm.hide();
                       error_registerInstituteForm.show();
                   },
                   highlight: function (element) { // hightlight error inputs
                       $(element).addClass('vd_bd-red');
                       $(element).parent().siblings('.help-inline').removeClass('help-inline hidden');
                       if ($(element).parent().hasClass("vd_checkbox") || $(element).parent().hasClass("vd_radio")) {
                           $(element).siblings('.help-inline').removeClass('help-inline hidden');
                       }
                   },
                   unhighlight: function (element) { // revert the change dony by hightlight
                       $(element)
                           .closest('.control-group').removeClass('error'); // set error class to the control group
                   },
                   success: function (label, element) {
                                      label
                           .addClass('valid').addClass('help-inline hidden') // mark the current input as valid and display OK icon
                           .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                       $(element).removeClass('vd_bd-red');
                   },
                   submitHandler: function (form) {
                     $(form).find('#institute-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
                       //success_registerInstituteForm.show();
                       //error_registerInstituteForm.hide();
                        if($('#open_for_all').prop('checked')==true)
              {
                tinyMCE.triggerSave();
                  submitForm();
              }
              else
              {
                if($('#institute_name').val()=='')
                {
                  $('#error1').text('This field is required');
                }
                else
                {
                  submitForm();
                }
              }
                   }
               });
$('#jury-submit').click(function(){
    $('#addJuryFrom').submit();
});
               "use strict";
               var addJuryFrom = $('#addJuryFrom');
               var error_addJuryFrom = $('.alert-danger', addJuryFrom);
               var success_addJuryFrom = $('.alert-success', addJuryFrom);
               addJuryFrom.validate({
                   errorElement: 'div', //default input error message container
                   errorClass: 'vd_red', // default input error message class
                   focusInvalid: false, // do not focus the last invalid input
                   onsubmit: true,
                   ignore: "",
                   rules: {
                       juryName: {
                           required: true,
                       },
                       juryEmail: {
                           required: true,
                           email:true
                       },
                       juryPhoto:
                       {
                        required: true
                       },
                       juryWriteUp: {
                           required: true
                       }
                   },
                   messages:
                   {
                       juryName: "Jury Name is required",
                       juryEmail:{
                          required:"Jury Email is required",
                          email:"Jury Email is invalid email"
                       },
                       juryPhoto: "Jury Photo is required",
                       juryWriteUp: "Jury Write Up is required"
                   },
                   errorPlacement: function(error, element) {
                       if (element.parent().hasClass("vd_checkbox") || element.parent().hasClass("vd_radio")){
                           element.parent().append(error);
                       } else if (element.parent().hasClass("vd_input-wrapper")){
                           error.insertAfter(element.parent());
                       }else {
                           error.insertAfter(element);
                       }
                   },
                   invalidHandler: function (event, validator) { //display error alert on form submit
                       success_registerInstituteForm.hide();
                       error_registerInstituteForm.show();
                   },
                   highlight: function (element) { // hightlight error inputs
                       $(element).addClass('vd_bd-red');
                       $(element).parent().siblings('.help-inline').removeClass('help-inline hidden');
                       if ($(element).parent().hasClass("vd_checkbox") || $(element).parent().hasClass("vd_radio")) {
                           $(element).siblings('.help-inline').removeClass('help-inline hidden');
                       }
                   },
                   unhighlight: function (element) { // revert the change dony by hightlight
                       $(element)
                           .closest('.control-group').removeClass('error'); // set error class to the control group
                   },
                   success: function (label, element) {
                                      label
                           .addClass('valid').addClass('help-inline hidden') // mark the current input as valid and display OK icon
                           .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                       $(element).removeClass('vd_bd-red');
                   },
                   submitHandler: function (form) {
                     $(form).find('#jury-submit').prepend('<i class="fa fa-spinner fa-spin mgr-10"></i>')/*.addClass('disabled').attr('disabled')*/;
                       //success_registerInstituteForm.show();
                       //error_registerInstituteForm.hide();
                      submitJuryForm();
                   }
               });
               $('#wysiwyghtml').wysihtml5();
       });

    function submitForm(){
                    BASEURL='<?php echo base_url();?>';
                                $('#institute-submit').prop("disabled", true);
                                var registerInstituteForm = $('#instituteRegistrationForm');
                                var error_registerInstituteForm = $('.alert-danger', registerInstituteForm);
                                var success_registerInstituteForm = $('.alert-success', registerInstituteForm);
                               // var formData = $( "#instituteRegistrationForm" ).serialize();
                                var formElement = document.getElementById("instituteRegistrationForm");
                                var formData=new FormData(formElement);
                                $.ajax({
                                    url: BASEURL+"admin/creative_mind_competition/processForm",
                                    type: 'POST',
                                    data:  formData,
                                    cache: false,
                                    processData: false, // Don't process the files
                                    contentType: false,
                                }).done(function(responce)
                                 {
                                            $('.fa-spinner').remove();
                                            var data = jQuery.parseJSON(responce);
                                            if(data.status=='error')
                                            {
                                                $.each(data.errorfields, function()
                                                {
                                                    $.each(this, function(name, value)
                                                    {
                                                        $('[name*="'+name+'"]').parent().after('<div class="vd_red">'+value+'</div>');
                                                    });
                                                });
                                                $('#institute-submit').prop("disabled", false);
                                            }
                                            else
                                            {
                                                if(data.status=='success')
                                                {
                                                        document.getElementById("instituteRegistrationForm").reset();
                                                        if(data.for == 'add')
                                                        {
                                                            window.location.href = BASEURL+'admin/creative_mind_competition/setFlashdata/add';
                                                        }
                                                        else
                                                        {
                                                            window.location.href = BASEURL+'admin/creative_mind_competition/setFlashdata/edit';
                                                        }
                                                }
                                                else
                                                {
                                                        $('.fa-spinner').remove();
                                                        success_registerInstituteForm.hide();
                                                        error_registerInstituteForm.show();
                                                        $('#institute-submit').prop("disabled", false);
                                                }
                                            }
                                }).fail(function( jqXHR, textStatus ) {
                                    alert( "Request failed: " + textStatus );
                                      $('#institute-submit').prop("disabled", false);
                                });
    }


    function submitJuryForm(){
                    BASEURL='<?php echo base_url();?>';
                                $('#jury-submit').prop("disabled", true);
                                var addJuryFrom = $('#addJuryFrom');
                                var error_addJuryFrom = $('.alert-danger', addJuryFrom);
                                var success_addJuryFrom = $('.alert-success', addJuryFrom);
                               // var formData = $( "#instituteRegistrationForm" ).serialize();
                                var formElement = document.getElementById("addJuryFrom");
                                var formData=new FormData(formElement);
                                $.ajax({
                                    url: BASEURL+"admin/creative_mind_competition/processJuryForm",
                                    type: 'POST',
                                    data:  formData,
                                    cache: false,
                                    processData: false, // Don't process the files
                                    contentType: false,
                                }).done(function(responce)
                                 {
                                            $('.fa-spinner').remove();
                                            var data = jQuery.parseJSON(responce);
                                            if(data.status=='error')
                                            {
                                                $.each(data.errorfields, function()
                                                {
                                                    $.each(this, function(name, value)
                                                    {
                                                        $('[name*="'+name+'"]').parent().after('<div class="vd_red">'+value+'</div>');
                                                    });
                                                });
                                                $('#jury-submit').prop("disabled", false);
                                            }
                                            else
                                            {
                                                if(data.status=='success')
                                                {
                                                        $('#juryFail').hide();
                                                        $('#jurySuccess').show();
                                                        $('#jurySuccessData').html(data.message);
                                                        $('.juryPhoto').attr('src', ' ');
                                                        document.getElementById("addJuryFrom").reset();
                                                }
                                                else
                                                {
                                                        $('#jurySuccess').hide();
                                                        $('#juryFail').show();
                                                        $('#juryFailData').html(data.message);
                                                        $('.fa-spinner').remove();
                                                        success_addJuryFrom.hide();
                                                        error_addJuryFrom.show();
                                                        $('#jury-submit').prop("disabled", false);
                                                }
                                            }
                                }).fail(function( jqXHR, textStatus ) {
                                    alert( "Request failed: " + textStatus );
                                      $('#jury-submit').prop("disabled", false);
                                });
    }

      function openEditForm(competitionId)
      {
        $('#myModal #myModalLabel').text('Edit Competition');
            getAutocomplete();
            $.blockUI.defaults.css = {
            padding: 0,
            margin: 0,
            width: 'auto',
            top: '40%',
            left: '45%',
            textAlign: 'center',
            cursor: 'wait'
            };
            $.blockUI({ message: '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"><div class="modal-dialog" style="width:300px !important;box-shadow:0 6px 7px #000;"><div class="modal-content"><div class="modal-body" style="padding-bottom:15px !important;"><img src="<?php echo base_url();?>backend_assets/img/loadings.gif"></div></div></div></div>' });
            $.ajax({
            url: '<?php echo base_url();?>admin/creative_mind_competition/getEditFormData',
            type: 'POST',
            data: {competitionId:competitionId},
            })
            .done(function(responce) {
            var data=jQuery.parseJSON(responce);
            $.each(data, function(index, val)
            {
                if(index == 'profile_image')
                {
                      var base_url='<?php echo front_base_url();?>';
                      var img='<?php echo file_upload_base_url();?>competition/profile_image/thumbs/'+val;
                      $('#logoPreview').attr('src', img);
                }
                else
                {
                    if(index == 'banner')
                    {
                        var base_url='<?php echo front_base_url();?>';
                        var img='<?php echo file_upload_base_url();?>competition/banner/thumbs/'+val;
                        $('#coverPreview').attr('src', img);
                    }
                    else if(index == 'description')
                    {
                        $("#description").val(val);
                    }
                    else if(index == 'award')
                    {
                        $("#award").val(val);
                    }
                    else if(index == 'eligibility')
                    {
                        $("#eligibility").val(val);
                    }
                    else if(index == 'jury')
                    {
                        $('#tokenize').tokenize().clear();
                          $.each(val, function(key, data)
                          {
                        $("#tokenize").append('<option selected="selected" value="'+data.id+'">'+data.email+'</option>');
                          });
                          $('.tokenize-sample').css('width', '100%');
                          $('#tokenize').tokenize().remap();
                    }
                    else if(index == 'hidename')
                        {
							//alert(val);
                                      if(val==1)
                                      {

                                             $('.bootstrap-switch-yellow').addClass('bootstrap-switch-on');
                                             $('.bootstrap-switch-yellow').removeClass('bootstrap-switch-off');
                                      }
                                      else
                                      {
                                          $('.bootstrap-switch-yellow').addClass('bootstrap-switch-off');

                                      }

						}
						else if(index == 'countryId')
                                  {
							$("#country").val(val);
						}
						else if(index == 'cityId')
                                  {
							$('#city').html(val);
						}
						else if(index == 'certificate')
            {
							if(val==1)
							{
                  $('.bootstrap-switch-blue').addClass('bootstrap-switch-on');
                  $('.bootstrap-switch-blue').removeClass('bootstrap-switch-off');
							}
              else
              {
                    $('.bootstrap-switch-blue').addClass('bootstrap-switch-off');
              }
						}
            else if(index == 'rankTitleName')
            {
              $('#winnerTitles').html(val);
            }
            else if(index == 'html_zone')
            {
              $('#zone').html(val);
            }
            else if(index == 'html_region')
            {
              $('#region').html(val);
            }
             else if(index == 'html_normalCompetition')
            {
              $('#competition_id').html(val);
            }

						else if(index=='winnerEmail')
						{
							//$('#elm1').html(val);
                                        tinyMCE.activeEditor.setContent(val);
						}
						else if(index == 'rule')
                        {
							$('#wysiwyghtml').data("wysihtml5").editor.setValue(val);
						}

					else if(index == 'instituteId')
                    {
                        $('#instituteId').val(val);
                    }
                /*    else if(index == 'open_for_all')
                    {
                      if(val==1)
                      {
                          $('#open_for_all').attr('checked','checked');
                          $('.institute_div').hide();
                      }
                      else
                      {
                          $("#open_for_all").removeAttr("checked");
                          $('.institute_div').show();
                      }
                    }*/
                    else if(index == 'category_wise_winner')
                    {
                      if(val==1)
                      {
                          $('#Category_wise_winner').attr('checked','checked');                          
                      }
                      else
                      {
                          $("#Category_wise_winner").removeAttr("checked");                        
                      }
                    }
                    else
                    {
                        $("input[name='"+index+"']").val(val);
                    }
                }
            });
            $('#competitionId').val(competitionId);
            $('#myModal').modal('show');
            $.unblockUI();
            })
            .fail(function() {
            console.log("error");
            })
            }
        function readURL(input) {
          //console.log($(input).siblings('.preview'));
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).siblings('.preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    function getAutocomplete()
    {
            <?php if($this->session->userdata('admin_level') == 1){;?>
              var base_url='<?php echo front_base_url();?>';
              $.ajax({
                url: base_url+'creosouls_admin/admin/creative_mind_competition/getAutocompleteInstituteData',
                type: 'POST',
               })
              .done(function(response) {
                data_image=jQuery.parseJSON(response);
                $( "#institute_name" ).autocomplete({
                    minLength: 0,
                    source: data_image,
                    focus: function( event, ui ) {
                    $( "#institute_name" ).val( ui.item.label );
                      return false;
                    },select: function( event, ui )
                    {
                      console.log(ui.item);
                        $( "#instituteId" ).val( ui.item.userId );
                    }
                  })
                  .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                    .append( "<a href='javascript:void(0)'><span class='menu-icon'><img src='" + item.icon + "'></span><span class='menu-text'>" + item.label + "<span class='menu-info'>" + item.desc + "</span></span></a>" )
                    .appendTo( ul );
                  };
              });
              <?php } ?>
    }
    $('#open_for_all').click(function()
    {
      if($('#open_for_all').prop('checked')==true)
      {
        $('.institute_div').hide();
      }
      else
      {
        $('.institute_div').show();
      }
    })
    $('#institute-submit').click(function()
    {
       if($('#open_for_all').prop('checked')==true)
      {
          //submitForm();
      }
      else
      {
        if($('#institute_name').val()=='')
        {
          $('#error1').text('This field is required');
        }
        else
        {
          //submitForm();
        }
      }
    })
            </script>


            <script>
function getCities(id)
{
	var countryId=id;
	var base_url=$('#base_url').val();
	$.ajax({
	type:"POST",
	data:{countryId:countryId},
	url:base_url+'admin/creative_mind_competition/getAllCities/'+countryId,
	success:function(data)
			{
				$('#city').html(data);
			}
	});
}
</script>
<script>
function myFunction(winNum)
{
     var inputCount = document.getElementById('winnerTitles').getElementsByTagName('input').length;
     var winNum = winNum;
     var titleName = $('#winnerTitles');
     var i = $('#winnerTitles').size() + 1;
     if (inputCount < winNum)
     {
          if(winNum > 20)
          {
            alert('Maximum number of winner for competition is 20.');
            return false;
          }
          else
          {
              for (var i = inputCount +1; i <= winNum; i++)
              {
                $('<div class="label-wrapper" id="winnerTitles_'+ i +'"><label class="control-label" for="rankTitle">Rank ' + i +' : </label> (<span class="requiredClass"> * </span>) &nbsp;&nbsp;<div class="vd_input-wrapper light-theme" id="winnerCount-input-wrapper"><input type="text" id="p_scnt" size="50" name="rankTitle[]" value="" placeholder="Rank ' + i +' Winner Title" class="required"/></div></div>').appendTo(titleName);
              }
          }
     }
     else if(inputCount > winNum)
     {
          for (var j = parseInt(winNum)+1; j <= inputCount; j++)
          {

              $(' #winnerTitles_'+ j  ).remove();
              console.log(j);
          }
     }
}

$("#Category_wise_winner").on("click", function(){       
        if($(this).is(":checked")) {
           $('#winnerCount').val(3);
          /* $('#winnerCount').attr('disabled','disabled');*/         
           $('#open_for_all').removeAttr('checked','checked');
           $('#open_for_all').attr('disabled','disabled');
           myFunction(3);
        } else {
           $('#winnerCount').val('');
         /*  $('#winnerCount').removeAttr('disabled','disabled');*/
           $('#open_for_all').removeAttr('disabled','disabled');
           myFunction(0);
        }
});

$("#open_for_all").on("click", function(){       
        if($(this).is(":checked")) {
           $('#winnerCount').val('');   
           $('#Category_wise_winner').removeAttr('checked','checked');      
           myFunction(0);
        } 
});


function getcompetition_idList(arg)
{  
  var regionId = $(arg).val();
  var zoneId=$('#zone').val(); 
  $.ajax(
    {
      type: "POST",
      data:{zoneId:zoneId,regionId:regionId},
      url: base_url+'admin/creative_mind_competition/get_competition_list',                 
      success:function(html)
      {
        //alert(html);
        $('#competition_id').html('');
        $('#competition_id').append(html);
      }
    });
}


function getRegionList(element)
{   
  var zoneId=$('#zone').val(); 
  $.ajax({
        type: "POST",
        data:{zoneId:zoneId},
        url: base_url+'admin/creative_mind_competition/getZoneRegionList',
        success:function(data)
        {
          if(data!='')
          {
            $('#region').html(data);
          }
          else
          {
            $('#region').html(data);
          }
      }
      });     
}



</script>


<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
        editor_selector : "myTextEditor",
		theme : "advanced",
		height:200,
		plugins : "openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,pramukhime",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,blockquote,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bullist,numlist,undo,redo,link,unlink,forecolor,backcolor,media,image,openmanager,preview,code,,fullscreen,pramukhime,pramukhimeclick,pramukhimeconvert,pramukhimehelp",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		//Open Manager Options
		file_browser_callback: "openmanager",
		open_manager_upload_path: '<?php echo file_upload_s3_path();?>',
		// Example content CSS (should be your site CSS)
		content_css : "<?php echo base_url();?>jscripts/tiny_mce/themes/advanced/skins/highcontrast/content.css",
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		// Style formats
		style_formats: [
    {title: "Headers", items: [
        {title: "Header 1", format: "h1"},
        {title: "Header 2", format: "h2"},
        {title: "Header 3", format: "h3"},
        {title: "Header 4", format: "h4"},
        {title: "Header 5", format: "h5"},
        {title: "Header 6", format: "h6"}
    ]},
    {title: "Inline", items: [
        {title: "Bold", icon: "bold", format: "bold"},
        {title: "Italic", icon: "italic", format: "italic"},
        {title: "Underline", icon: "underline", format: "underline"},
        {title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
        {title: "Superscript", icon: "superscript", format: "superscript"},
        {title: "Subscript", icon: "subscript", format: "subscript"},
        {title: "Code", icon: "code", format: "code"}
    ]},
    {title: "Blocks", items: [
        {title: "Paragraph", format: "p"},
        {title: "Blockquote", format: "blockquote"},
        {title: "Div", format: "div"},
        {title: "Pre", format: "pre"}
    ]},
    {title: "Alignment", items: [
        {title: "Left", icon: "alignleft", format: "alignleft"},
        {title: "Center", icon: "aligncenter", format: "aligncenter"},
        {title: "Right", icon: "alignright", format: "alignright"},
        {title: "Justify", icon: "alignjustify", format: "alignjustify"}
    ]}
],
	 pramukhime_language : [
            {
                jsfile : 'pramukhindic.js', // Required - Keyboard plugin js file name located at TinyMCE_ROOT/plugins/pramukhime/js/
                kbclassname: 'PramukhIndic', // Required - Keyboard plugin class name. If this parameter does not exists,
				// it will be considered as a placeholder for "English"
                kbtitle: 'Indic Script', // Not required - Title given to the list of all languages
                languagelist: [	// Not required. - List of languages to be shown in the drop down
                    { language: "marathi"}, // "language" required
                    { language: "hindi", title: "My Hindi", defaultlanguage: true} // "language" required,
					// "title" not required, "defaultlanguage" not required
                    ],
					defaultlanguage: 'English' // "defaultlanguage" not required. this overrides "defaultlanguage"
					// settings in individual language in "languagelist"
            },
			{ // This blank element will be considered as a placeholder for "English" in language drop down list
				kbtitle:'Roman', // Not required. If kbtitle: '' it will not create title, otherwise default title will be English
				title:'My English' // Not required
			}
        ],
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
</body>
</html>


