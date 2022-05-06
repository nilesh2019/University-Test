<?php $this->load->view('admin/template/header');?>
<link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url();?>backend_assets/plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css">
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
                <li class="active">Manage Support Issue</li>
              </ul>
              <div class="vd_panel-menu hidden-sm hidden-xs" data-intro="<strong>Expand Control</strong><br/>To expand content page horizontally, vertically, or Both. If you just need one button just simply remove the other button code." data-step=5  data-position="left">
    <div data-action="remove-navbar" data-original-title="Remove Navigation Bar Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-navbar-button menu"> <i class="fa fa-arrows-h"></i> </div>
      <div data-action="remove-header" data-original-title="Remove Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="remove-header-button menu"> <i class="fa fa-arrows-v"></i> </div>
      <div data-action="fullscreen" data-original-title="Remove Navigation Bar and Top Menu Toggle" data-toggle="tooltip" data-placement="bottom" class="fullscreen-button menu"> <i class="glyphicon glyphicon-fullscreen"></i> </div>

</div>

            </div>
          </div>
          <div class="vd_title-section clearfix">
          <div class="vd_panel-header" id="flashMsg">
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
                    <h3 class="panel-title"> <span class="menu-icon"> <i class="fa fa-dot-circle-o"></i> </span> Manage Support Issue Table</h3>
                  </div>
                  <div class="panel-body table-responsive" style="border: 1px solid #eee;min-height:500px;">
                    <form action="<?php echo base_url();?>admin/support_issue/multiselect_action" method="post" name="myform" id="myform">
                            <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><input type="checkbox" id="check"></th>
                                    <th>#</th>
                                    <th width="10%" >Center</th>
                                    <th>Institute Name</th>                                  
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Student Id</th>
                                    <th width="20%">Date</th>
                                    <th>Refernec No</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            </table>
                            <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-3">
                                      <select name="listaction" id="listaction" class="allselect form-control input-sm" style="float: left;" >
                                        <option value=""> Select Action</option>
                                        <option value="1"> User error -CLOSED</option>
                                        <option value="2"> BUG - CLOSED</option>
                                        <option value="3"> Requested- OPERATION WAITING</option>          
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
<?php $this->load->view('admin/template/footer');?>
<!-- Specific Page Scripts Put Here -->

<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/tagsInput/jquery.tagsinput.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/prettyPhoto-plugin/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>backend_assets/plugins/bootstrap-wysiwyg/js/bootstrap-wysihtml5-0.0.2.js"></script>
           <script type="text/javascript" language="javascript" >
    function format ( d )
    {


           return '<div class="panel widget light-widget" style="box-shadow:-2px 5px 17px #ccc !important;">'+
            '<div class="panel-heading"> </div>'+
            '<div class="panel-body">'+
                    '<span style="font-size:20px;font-weight:bold;margin-left:40%;">Admin Detail</span><br><br>'+                   
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>User Name</strong> </div>'+
                      '<div class="col-xs-7">  '+d.name+' </div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Email:</strong> </div>'+
                      '<div class="col-xs-7">'+d.email+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Registration Date:</strong> </div>'+
                      '<div class="col-xs-7">'+d.created+'</div>'+
                    '</div>'+
                    '<div class="row mgbt-xs-10">'+
                      '<div class="col-xs-5 text-right"> <strong>Status:</strong> </div>'+
                      '<div class="col-xs-7">'+d.status+'</div>'+
                    '</div>'+
                  
                  '</div></div></div>';
    }

    $(document).ready(function() {

    var dt = $('#example').DataTable( {
       oLanguage: {
                sProcessing: "<img src='<?php echo base_url();?>backend_assets/img/loadings.gif'>"
         },
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url();?>admin/support_issue/get_ajaxdataObjects",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            { "data": "chk" },
            { "data": "id" },
            { "data": "categorytype" },
            { "data": "ins_name" }, 
            { "data": "name" }, 
            { "data": "contactNo" },           
            { "data": "studentId" },           
            { "data": "student_date" },           
            { "data": "reference_no" },
            { "data": "status" }
        ],
        "order": [],
         columnDefs: [
           { orderable: true, targets: [3] },
           { orderable: false, targets: [-1,0,1,2,4,5] },
           { "width": "5%", "targets": [0,1,2] },
           { "width": "10%", "targets": [-1,5,4] },
           { "width": "20%", "targets": [3,4] }
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
                $('[data-rel^="switch"]').bootstrapSwitch();
     }
    } );


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

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            $(this).closest('.details-control').html('<img src="<?php echo base_url();?>backend_assets/img/details_close.png">');
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();

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

} );

function change_status(Id)
{
      var done = confirm("Are you sure, you want to change the status?");
      if(done == true)
      {
          var pageurl_new = '<?php echo base_url();?>'+'admin/ho_admin/change_status/'+Id;
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





  function edit_admin(hoAdminId)
  {   
    BASEURL='<?php echo base_url();?>';
       var pageurl_new = BASEURL+'admin/ho_admin/edit_admin/'+hoAdminId;
       $.ajax({
          url: pageurl_new,
       }).done(function(responce)
       {
        console.log(responce);        
        if (!$.isEmptyObject(responce))
        {
           $('#myModal').modal('toggle');
           var data = jQuery.parseJSON(responce);        
             $.each(data, function(index, val)
              {           
                  if(index == 'zone')
                  {
                    $.each(val, function(regionindex, regionval) {

                      $('select#zone option[value='+regionval+']').attr('selected','selected');

                    });                             
                    getRegionData(val,hoAdminId);                       
                  }           
                  else if(index == 'id')
                  {
                    $('[name*="id"]').val(val);  
                  }
                  else if(index == 'name')
                  {
                    $('[name*="name"]').val(val);
                  }
                  else if(index == 'email')
                  {
                    $('[name*="email"]').val(val);
                  }
              })         
        }
       });
   }


   function getRegionData(val,hoAdminId)
   {    
    var base_url='<?php echo front_base_url();?>';
    var zoneId = val;
   
    $.ajax({
        type: "POST",
        data:{zoneId:zoneId,hoAdminId:hoAdminId},
        url: base_url+'creosouls_admin/admin/ho_admin/getSelectedRegionList',
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


   function getRegionList(element)
   {    
    var zoneId=$('#zone').val();
    //alert(zoneId);
    var base_url='<?php echo front_base_url();?>';
    $.ajax({
          type: "POST",
          data:{zoneId:zoneId},
          url: base_url+'creosouls_admin/admin/ho_admin/getZoneRegionList',
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

   $(document).ready(function(){
           $("#addInstitute").click(function(){
                  $('#id').val('');
                  $("#admin-form")[0].reset();
                  $("#zone option:selected").prop("selected", false);
                  $("#region").html("<option value=''>Select Region</option>  ");
                  $('#admin-submit').prop("disabled", false);
           });
    });

  </script>

</body>

</html>
