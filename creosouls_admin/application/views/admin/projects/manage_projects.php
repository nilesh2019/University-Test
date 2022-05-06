<?php $this->load->view('admin/template/header');?>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
  <!-- Header Ends -->
<div class="content">
  <div class="container">
  <?php $this->load->view('admin/template/navbar_view');?>
    <!-- Middle Content Start -->

    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin">Home</a> </li>
                <li class="active">Manage Projects</li>
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
          <div class="vd_content-section clearfix">
            <div class="row">
              <div class="col-md-12">
                <div class="panel widget">
                  <div class="panel-heading vd_bg-grey">
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage Projects Table</h3>

                  </div>
                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                     <!--              <center>
                  <button class="btn btn-primary" style="margin-top: -2px;cursor:pointer;"><i class="fa fa-plus"> Add User</i></button>
                  <a href="<?php echo base_url();?>admin/projects/addedit_user?lightbox[width]=600&lightbox[height]=420&lightbox[modal]=true" class="lightbox">Login Box</a>
                  </center> -->
                  <div class="row">

                        <div class="col-md-3">
                          <select name="institute" id="find_institute_records" class="featured_project" style="margin-top:5px;">
                            <option value="">Select Institute</option>
                          <?php foreach ($institute as $val) {
                            ?>
                                <option value="<?=$val['id']?>"><?=$val['instituteName']?></option>
                            <?php
                          }?>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <select name="category" id="find_category_records" class="featured_project" style="margin-top:5px;">
                            <option value="">Select Category</option>
                          <?php foreach ($category as $val) {
                            ?>
                                <option value="<?=$val['id']?>"><?=$val['categoryName']?></option>
                            <?php
                          }?>
                          </select>
                        </div>
                        <div class="col-md-3">                          
                            <select name="projectstatus" id="projectstatus" class="featured_project" style="margin-top:5px;">
                              <option value="">Select Status</option>
                              <option value="0">Draft</option>
                              <option value="1">Public</option>
                              <option value="2">Incomplete</option>
                              <option value="3">Private</option>
                              <option value="4">Pending Admin Approval </option>
                            </select>
                        </div>
                       <div class="col-md-3">
                           <?php
                      if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4){
                        ?>
                      <center><input type="checkbox" class="featured_project" name="featured_project" id="featured_projectfind" value="1" ><label> &nbsp; Show Feature Project </label></center>
                      <?php }  ?>
                       </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="label-wrapper ">
                            <label class="control-label" for="featured_project">From Date</label>
                          </div>
                          <div class="vd_input-wrapper light-theme" id="featured_project-input-wrapper">
                            <input type="text" placeholder="Start Date" readonly="true" id="start_date" name="start_date" class="featured_project start_date">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="label-wrapper ">
                            <label class="control-label" for="featured_project">To Date</label>
                          </div>
                          <div class="vd_input-wrapper light-theme" id="featured_project-input-wrapper"> 
                            <input type="text" placeholder="End Date" readonly="true" id="end_date" name="end_date" class="featured_project end_date">
                          </div>
                        </div> 
                      </div>
                  
                 
                        <form action="<?php echo base_url();?>admin/projects/multiselect_action" method="post" name="myform" id="myform">

                            <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><input type="checkbox" id="check"></th>
                                    <th>#</th>
                                    <th>Project Cover</th>
                                    <th>Project Name</th>
                                    <th>Owner's Institute Name</th>
                                    <th>User Name</th>
                                    <th>Category Name</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            </table>
                                <div class="row">
                                      <div class="col-md-12">

                                            <div class="col-md-3">
                                                  <select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;" >
                                                  <option value=""> Select Status</option>
                                                  <option value="1"> Public</option>
                                                  <option value="2"> Private</option>
                                                  <option value="3"> Delete</option>
                                                  <?php if($this->session->userdata('admin_level') == 1 || $this->session->userdata('admin_level') == 4){?>
                                                  <option value="4"> Make Featured</option>
                                                  <option value="5"> Make Unfeatured</option>
                                                  <?php } ?>
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

  </div>
  <!-- .container -->
</div>
<!-- .content -->

<!-- Footer Start -->
<!-- <a style="display: none" class='ajax' href="#inline_content"></a>-->

<?php $this->load->view('admin/template/footer');?>
<!-- Specific Page Scripts Put Here -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript">
    var date = new Date();
    $(".start_date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    $(".end_date").datepicker({
        format: 'yyyy-mm-dd',
        setDate: new Date(),
        autoclose: true,
    });
</script>
           <script type="text/javascript" language="javascript" >
    function format ( d )
    {


           return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
            '<div class="panel-heading"> </div>'+
            '<div class="panel-body">'+
                    '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Projects Details</span><br><br>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong></strong> </div>'+
                      '<div class="col-xs-7">  '+d.projectCoverImage+' </div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Project Details</strong> </div>'+
                      '<div class="col-xs-7">  '+d.projectName+' </div>'+
                    '</div>'+
                      '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Project Details</strong> </div>'+
                      '<div class="col-xs-7">  '+d.instituteName+' </div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>User Details:</strong> </div>'+
                      '<div class="col-xs-7">'+d.user_name+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Project Category:</strong> </div>'+
                      '<div class="col-xs-7">'+d.categoryName+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Created Date:</strong> </div>'+
                      '<div class="col-xs-7">'+d.created+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Project Status:</strong> </div>'+
                      '<div class="col-xs-7">'+d.status+'</div>'+
                    '</div>'+
                  '</div></div></div>';
    }

$(document).ready(function() {    
  //  var featured_project =0;
  $('.featured_project').change(function() {
   
        
        if($('#find_institute_records').val())
        {
           var ins_val=$('#find_institute_records').val();
        }
        else
        {
          var ins_val=0;
        }
        if($('#find_category_records').val())
        {
           var cat_val=$('#find_category_records').val();
        }
        else
        {
          var cat_val=0;
        }
        if($('.start_date').val())
        {
           var startDate_val=$('.start_date').val();
        }
        else
        {
          var startDate_val=0;
        }
        if($('.end_date').val())
        {
           var endDate_val=$('.end_date').val();
        }
        else
        {
          var endDate_val=0;
        }
        //var ins_val =$('#find_institute_records').val();
        var ins_flag='insfind';
        var cat_flag = 'catfind';
        var startDate_flag = 'startdatefind';
        var endDate_flag = 'enddatefind';
         // renderDatatable(ins_val,ins_flag);
        var statusval =$('#projectstatus').val();
        var statusfalg='projectstatus';
        // $('#example').DataTable().destroy();
         // renderDatatable(statusval,statusfalg);
    
        if ($("#featured_projectfind").is(':checked')){
            var featured_project =1;
            var featured='featured';
          
            //$('#example').DataTable().destroy();
            // renderDatatable(featured_project,featured);
          }
          else {
              var featured_project =0;
              var featured='featured';
              //$('#example').DataTable().destroy();
              // renderDatatable(featured_project,featured);
          }

            $('#example').DataTable().destroy();      
            renderDatatable(featured_project,featured,ins_flag,ins_val,cat_flag,cat_val,startDate_flag,startDate_val,endDate_flag,endDate_val,statusfalg,statusval);
     // alert(featured_project);

  });

  var featured_project =0;
  var featured='';
  var ins_flag='';
  var ins_val=0;
  var cat_flag ='';
  var cat_val = 0;
  var startDate_flag = '';
  var startDate_val = 0;
  var endDate_flag = '';
  var endDate_val = 0;
  var statusfalg='';
  var statusval=0;
  renderDatatable(featured_project,featured,ins_flag,ins_val,cat_flag,cat_val,startDate_flag,startDate_val,endDate_flag,endDate_val,statusfalg,statusval);

    function renderDatatable(featured_project,featured,ins_flag,ins_val,cat_flag,cat_val,startDate_flag,startDate_val,endDate_flag,endDate_val,statusfalg,statusval){
      //alert(featured);
        dt = $('#example').DataTable({
          oLanguage: {
            sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
          },
          "processing": true,
          "serverSide": true,
          "ajax": "<?php echo base_url();?>admin/projects/get_ajaxdataObjects/"+featured+"/"+featured_project+"/"+ins_flag+"/"+ins_val+"/"+cat_flag+"/"+cat_val+"/"+startDate_flag+"/"+startDate_val+"/"+endDate_flag+"/"+endDate_val+"/"+statusfalg+"/"+statusval,
          "columns": [
          {
          "class":          "details-control",
          "orderable":      false,
          "data":           null,
          "defaultContent": ""
          },
          { "data": "chk" },
          { "data": "id" },
          { "data": "projectCoverImage" },
          { "data": "projectName" },
          { "data": "InstituteName" },
          { "data": "user_name" },  //columns that you want to show in table
          { "data": "categoryName" },
          { "data": "created" },
          { "data": "status" },
          { "data": "action" }
          ],
          "order": [],
          columnDefs: [
          { orderable: true, targets: [4,5,6,7,8,9] },
          { orderable: false, targets: [-1,0,3,2,1] },
          { "width": "5%", "targets": [0,1,2,9] },
          { "width": "10%", "targets": [3,7,8] },
          { "width": "13%", "targets": [-1] },
          { "width": "15%", "targets": [6,4] },
          { "width": "22%", "targets": [5] }
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
          });
        }
        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#example tbody').on( 'click', 'tr td.details-control', function () {
            $.each($('.details'), function(index, val) {
              $(this).next('tr').remove();
              $(this).find('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');
              $(this).removeClass('details');
            });

            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
              $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_open.png">');

              tr.removeClass( 'details' );
              row.child.hide();
              detailRows.splice( idx, 1 );
            }
            else {
                $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_close.png">');
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();
                if ( idx === -1 ) {
                  detailRows.push( tr.attr('id') );
                }
            }
        });

        dt.on( 'draw', function () {
          $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
          });
        });

        $("#check").click(function() {
          var checked_status = this.checked;
          $("#myform input[type=checkbox]").each(function(){
           this.checked = checked_status;
          });
        });
    });

function change_status(userId)
{
      var done = confirm("Are you sure, you want to change the status?");
      if(done == true)
      {
          var pageurl_new = '<?php echo base_url();?>'+'admin/projects/change_status/'+userId;
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
        var pageurl_new = '<?php echo base_url();?>'+'admin/projects/delete_confirm/'+userId;
        window.location.href = pageurl_new;
    }
    else
    {
        return false;
    }
}


  function make_public(projectId)
  {
        var done = confirm("Are you sure, you want to make this project public ?");
        if(done == true)
        {
            var pageurl_new = '<?php echo base_url();?>'+'admin/projects/make_public/'+projectId;
            window.location.href = pageurl_new;
        }
        /*  else
        {
          $.colorbox({html:'<div class="container"><h2>Reason for disapproval</h2><form role="form"><div class="form-group"><label for="comment">Comment:</label><input type="hidden" id="proId" value="'+projectId+'"/><textarea class="form-control" rows="5" id="comment_text"></textarea><br/><button id="send_btn" type="button" class="btn btn-success">send</button><br/><span id="error1" style="color:red"><span></div></form></div>'});
        }*/
  }

$(document).ready(function()
{
         $(document.body).on('click','#send_btn',function()
      {

        var comment_text = $('#comment_text').val();
        var projectId = $('#proId').val();
       if(comment_text=='')
        {
           $('#error1').text('Please Enter reason');
          return false;
        }
        else
        {
              $.ajax({
              type:"POST",
                    data:{projectId:projectId,comment_text:comment_text},
                    url: '<?php echo base_url();?>'+'admin/projects/make_private/'+projectId,
                    success:function(html)
                    {
                      if(html)
                      {
                $('#cboxClose').trigger('click');
                 var pageurl_new = '<?php echo base_url();?>'+'admin/projects';
                     window.location.href = pageurl_new;
              }
             }
         });
        }
       })
 })

function validateForm()
{
      var total="";
    /*  for(var i=0; i < $("#myform").check.length; i++)
      {
          if($("#myform").check[i].checked);
          total +=$("#myform").check[i].value + '\n';
      }*/


        $("#myform input[type=checkbox]").each(function(){
               if($(this).is(":checked"))
                {
              total += $(this).val();
          }
        });


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
});
    </script>
<!-- Specific Page Scripts END -->

  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>backend_assets/js/lightbox/themes/default/jquery.lightbox.css" />
  <!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lightbox/themes/default/jquery.lightbox.ie6.css" />
  <![endif]-->

  <script type="text/javascript" src="<?php echo base_url();?>backend_assets/js/lightbox/jquery.lightbox.min.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($){
      $('.lightbox').lightbox();
    });
  </script>


  <link rel="stylesheet" href="<?php echo base_url();?>backend_assets/colorbox/colorbox.css" />
<script src="<?php echo base_url();?>backend_assets/colorbox/jquery.colorbox.js"></script>


</body>

</html>
