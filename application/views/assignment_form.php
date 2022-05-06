<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-multiselect.css">

<style>
.navbar {
    background-color:rgb(0,0,0);
 * { 
   .border-radius(0) !important;
 }

 #field {
     margin-bottom:20px;
 }
  .input-group{
    margin-bottom:10px; 
  } 
  .multiselect-container {
      height: 150px !important;
      overflow: auto;
      position: relative !important;
  }
</style>
<div class="middle">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 breadcrumb-bg">
          <ol class="breadcrumb">
            <li>
              <a href="<?php echo base_url()?>">
                Home
              </a>
            </li>
            <li>
              <a href="<?php echo base_url()?>assignment">
                Assignment
              </a>
            </li>
            <li class="active">
              Add Assignment
            </li>
          </ol>
        </div>
        <div class="col-lg-10 col-md-offset-1">
          <div class="assignment-form">
            <form  id="assignment_form" action="<?php echo base_url();?>assignment/add_assignment<?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['id']!='') { echo '/'.$edit_assignment_data[0]['id']; } ?>" role="form" method="post">
                <div class="form-group">
                  <label>Assignment Name</label>
                  <input type="text" name="assignment_name" id="assignment_name" class="form-control" placeholder="Enter Assignment Name" <?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['assignment_name']!=''){ ?> value="<?php echo $edit_assignment_data[0]['assignment_name'];?>" <?php }?>>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea name="description" id="description" class="form-control"><?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['description'] !=''){ ?> <?php echo $edit_assignment_data[0]['description'];?> <?php }?></textarea>
                </div>
                <div class="form-group">
                  <div class="example example_typeahead">
                    <div class="bs-example">
                      <label> Tools </label> (Press Enter Key)
                      <?php
                       if(!empty($edit_assignment_data) && $edit_assignment_data[0]['id']!='')
                      {
                        $this->CI =& get_instance();
                        $this->CI->load->model('assignment_model');
                        $assignment_tools = $this->CI->assignment_model->get_tools($edit_assignment_data[0]['id']);
                        if(!empty($assignment_tools))
                        {
                          $count = count($assignment_tools);
                          $i=1;                        
                          $tool_Name='';
                          foreach ($assignment_tools as $toolname) {

                            $tool_Name .= $toolname['attributeValue'];
                           
                            if($i < $count)
                            {
                              $tool_Name .= ',';                                
                              $i++;
                            }
                          }
                        }
                        else
                        {
                          $tool_Name = '';
                        }
                        //print_r($tool_Name);die;
                        ?>
                       <input name="tools" type="text" value="<?php echo $tool_Name; ?>"  />
                    <?php    } else {  ?>
                      <input name="tools" type="text" />
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="example example_typeahead1">
                    <div class="bs-example">
                      <label> Features </label> (Press Enter Key)
                          <?php
                           if(!empty($edit_assignment_data) && $edit_assignment_data[0]['id']!='')
                          {                              
                            $assignment_feature = $this->CI->assignment_model->get_feature($edit_assignment_data[0]['id']);
                         //   print_r($assignment_feature);die;
                            if(!empty($assignment_feature))
                            { 
                              $count = count($assignment_feature);
                              $i=1;                        
                              $feature_Name='';
                              foreach ($assignment_feature as $featurename) {
                                $feature_Name .= $featurename['attributeValue'];                                 
                                if($i < $count)
                                {
                                  $feature_Name .= ',';                                
                                  $i++;
                                }
                              }
                            }
                            else
                            {
                              $feature_Name = '';
                            }
                              ?>
                           <input name="features" type="text" value="<?php echo $feature_Name; ?>"  />
                      <?php    } else { ?>
                        <input name="features" type="text"/>
                          <?php }  ?>
                    </div>
                  </div>
                </div>
                  <div class="form-group">
                          <label> Youtube Url </label> 
                          <input type="text" name="videoLink" id="videoLink" class="form-control" placeholder="Enter Video Link" <?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['videoLink']!=''){ ?> value="<?php echo $edit_assignment_data[0]['videoLink'];?>" <?php }?>>
                  </div>
                <div class="row">
                    <div class="form-group col-md-4">
                      <label>Start Date</label><br>                  
                      <input class="form-control" name="start_date" id="start_date" type="text" readonly="readonly" <?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['start_date']!=''){ ?> value="<?php echo date( "m/d/Y", strtotime($edit_assignment_data[0]['start_date']) );?>" <?php }?>>
                    </div>                               

                    <div class="form-group col-md-4">
                      <label>End Date</label><br>
                      <input class="form-control" name="end_date" id="end_date" type="text" readonly="readonly" <?php if(!empty($edit_assignment_data) && $edit_assignment_data[0]['end_date']!=''){ ?> value="<?php echo date( "m/d/Y", strtotime($edit_assignment_data[0]['end_date']) );?>" <?php }?>>
                    </div>  
                    <?php if(!empty($user_list))
                    { ?>
                        <div class="form-group col-md-4">
                          <label>Individual users.</label><br>
                          <select id="individual_user" name='individual_user[]' multiple="multiple" style="width:100%">
                          <?php   foreach ($user_list as $UsreList) { ?>
                            <option value="<?php echo $UsreList['id'];?>" <?php if(isset($selected_user) && !empty($selected_user)) { foreach ($selected_user as $selectUser) {

                              if($selectUser['user_id'] == $UsreList['id'])
                              {
                                echo 'selected';                            }
                            
                            } } ?>  ><?php echo $UsreList['firstName'];?>&nbsp;&nbsp;<?php echo $UsreList['lastName']; if($UsreList['teachers_status'] == 1){ echo '(Teacher)';}?></option>    
                            <?php }  ?>                 
                          </select>
                        </div>                 
                    <?php  }  ?>
                </div>               
                <div class="form-group">                    
                    <button class="btn btn-info" type="submit" value="submit">Submit</button> 
                </div>
            </form>
          </div> 
        </div>
      </div>
    </div>
</div>

<?php $this->load->view('template/footer');?>


<script src="<?php echo base_url();?>assets/js/dcalendar.picker.js"></script>
<!-- <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> -->
<script src="<?php echo base_url();?>assets/js/bootstrap-multiselect.js"></script>
<script>
   $(document).ready(function() {   
       /*  $('#group_of_users').multiselect({ 
           includeSelectAllOption: true,
             enableFiltering:true    
       });*/
            $('#individual_user').multiselect({          
             includeSelectAllOption: true,
             enableFiltering:true,  
             enableCaseInsensitiveFiltering: true,
               
         });
  
  });

 </script>


<script type="text/javascript">
  $(document).ready(function () {
      $(".btn-select").each(function (e) {
          var value = $(this).find("ul li.selected").html();
          if (value != undefined) {
              $(this).find(".btn-select-input").val(value);
              $(this).find(".btn-select-value").html(value);
          }
      });
  });

  $(document).on('click', '.btn-select', function (e) {
      e.preventDefault();
      var ul = $(this).find("ul");
      if ($(this).hasClass("active")) {
          if (ul.find("li").is(e.target)) {
              var target = $(e.target);
              target.addClass("selected").siblings().removeClass("selected");
              var value = target.html();
              $(this).find(".btn-select-input").val(value);
              $(this).find(".btn-select-value").html(value);
          }
          ul.hide();
          $(this).removeClass("active");
      }
      else {
          $('.btn-select').not(this).each(function () {
              $(this).removeClass("active").find("ul").hide();
          });
          ul.slideDown(300);
          $(this).addClass("active");
      }
  });

  $(document).on('click', function (e) {
      var target = $(e.target).closest(".btn-select");
      if (!target.length) {
          $(".btn-select").removeClass("active").find("ul").hide();
      }
  });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/app_bs3.js"></script>

<script src="<?php echo base_url();?>assets/script/formValidation.min.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap_framework.js"></script>
<script src="<?php echo base_url();?>assets/script/bootstrap-select.min.js"></script>

<script>
  $(document).ready(function() {
    $('#assignment_form').formValidation({
      message: 'This value is not valid',
      framework: 'bootstrap',
      icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
      },
            fields: {
         
              assignment_name: {
                verbose: false,
                  trigger: 'blur',
                  message: 'The Name is not valid',
                  validators: {
                      notEmpty: {
                          message: 'The Assignment Name is required and can\'t be empty'
                      },
          stringLength: {
                        min: 1,
                        max: 40,
                        message: 'Assignment name must be more than 1 and less than 40 characters long'
                    },
          regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
                        message: 'Please use only letters (a-z, A-Z)'
                    }
                 }
              },
        description: {
          verbose: false,
                  trigger: 'blur',
                  message: 'The Description is not valid',
                  validators:
                    {
                          notEmpty: 
                           {
                            message: 'The description is required and can\'t be empty'
                           }
                      }
                   },
        start_date: {
           verbose: false,
                   trigger: 'blur',
                   message: 'The Date is not valid',
                   validators:
                     {

                         notEmpty: {
                             message: 'The Start Date is required and can\'t be empty'
                         },                      
                         /* date: {
                              format: 'DD/MM/YYYY',
                              message: 'Start date is less than end date',
                              max: 'end_date'
                          }*/
                       }
                    },
      end_date: {
                verbose: false,
                trigger: 'blur',
                message: 'The Date is not valid',
                validators:
                  { 
                    notEmpty: {
                        message: 'The End Date is required and can\'t be empty'
                    },                   
                    /* date: {
                         format: 'DD/MM/YYYY',
                         message: 'End date is greter than start date',
                         min: 'start_date'
                     }*/
                  }
               }
             }
          })
    });
  
    $(document).ready(function(){
      var date = new Date();
      $("#start_date").datepicker({
          format: 'dd-mm-yyyy',
          startDate: date,
          autoclose: true,
      }).on('changeDate', function (selected) {
          var startDate = new Date(selected.date.valueOf());
          $('#end_date').datepicker('setStartDate', startDate);
          $('#assignment_form').formValidation('revalidateField', 'start_date');
      }).on('clearDate', function (selected) {
          $('#end_date').datepicker('setStartDate', null);
          $('#assignment_form').formValidation('revalidateField', 'start_date');
      });

      $("#end_date").datepicker({
          format: 'dd-mm-yyyy',
          setDate: new Date(),
          startDate: date,
          autoclose: true,
      }).on('changeDate', function (selected) {
          var endDate = new Date(selected.date.valueOf());
          $('#start_date').datepicker('setEndDate', endDate);
          $('#assignment_form').formValidation('revalidateField', 'end_date');
      }).on('clearDate', function (selected) {
          $('#start_date').datepicker('setEndDate', null);
          $('#assignment_form').formValidation('revalidateField', 'end_date');
      });
    });
</script>