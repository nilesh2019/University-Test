<?php $this->load->view('template/header');
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/formValidation.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/bootstrap-select.min.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
<style type="text/css">
.bootstrap-tagsinput {
    width: 100%;
    line-height:2.2 !important;
}
.label {
    line-height: 2 !important;
}
.bootstrap-tagsinput .tag
{
	font-size: 14px;
	padding: 5px;
	font-weight: bold;
}
h3,
.h3 {
  margin-top: 0px !important;
  margin-bottom: 10px;
}
h1{
position: absolute;
margin-left: 15px;
top: 21px;
}
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<div id="content-block">
	<div class="container be-detail-container">
		<div class="row">
			<div class="col-xs-12 col-md-3 left-feild" style="background:#fff;">
				<div class="be-vidget back-block">
					<a class="btn full btn-primary size-1 gradient" href="<?php echo base_url();?>competition/competition_list"><i class="fa fa-chevron-left"></i>Back To List</a>
				</div>
				<div class="be-vidget hidden-xs hidden-sm" id="scrollspy">
				<!--	<h3 class="letf-menu-article">
						Choose Category
					</h3>
					<?php
					   $ci= &get_instance();
					   $ci->load->model('user_model');
					  $admin_data = $ci->user_model->check_admin_or_not();
					 ?>
					<div class="creative_filds_block">
						<ul class="ul nav">
							<li><a href="#basic-information">Basic Information</a></li>
							<!-- <li><a href="#edit-password">Edit Password</a></li> -->
						<!--	<li><a href="#on-the-web">On The Web</a></li>
							<li><a href="#about-me">About Me</a></li>
							<li><a href="#web-references">Web References</a></li>
							<li><a href="#payment_cards">Payment card details</a></li>
							<?php
							  if(!empty($admin_data))
							  { ?>
							   <li><a href="#flag_status">Monitor Flag</a></li>
							   <li><a target="_blank" href="<?php echo base_url();?>creosouls_admin/admin/dashboard/<?php echo urlencode(base64_encode($this->session->userdata('user_institute_name')));?>/<?php echo urlencode(base64_encode($this->session->userdata('front_user_id')));?>">Manage Institute Data</a></li>
							 <?php } ?>
						</ul>
					</div>-->
			<!--		<a class="btn full color-1 size-1 hover-1 add_section gradient"><i class="fa fa-plus"></i>add sections</a>-->
				</div>
			</div>
			<div class="col-xs-12 col-md-9 _editor-content_">
			<form id="defaultForm" method="post" class="form-horizontal" action="<?php echo base_url();?>competition/add_competition">
				<div class="affix-block" id="basic-information">
					<div class="be-large-post">
						<div class="info-block style-2">
							<div class="be-large-post-align"><h3 class="info-block-label">Create New Competition</h3></div>
						</div>
						<div class="be-large-post-align">
							<div class="be-change-ava">
								<a style="float:left;" class="be-ava-user style-2" href="blog-detail-2.html">
									<img class="fileupload-preview" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $user_profile->profileImage;?>" alt="profileImage">
								</a>
								<div style="float:left;margin-top:45px;" class="fileupload fileupload-new" data-provides="fileupload">
								    <span class="btn btn-success btn-file gradient"><span class="fileupload-new">replace image</span>
								    <span class="fileupload-exists">Change</span>
								    <input id="imgInp" name="image" type="file" /></span>
								    <span class="fileupload-preview"></span>
								    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
								</div>
							</div>
					</div>
					<div class="be-large-post-align" style="clear:left;">
						<div class="row">
							<div class="input-col col-xs-12">
								<div class="form-group">
									<label>Name </label>&nbsp;(<span class="error">*</span>)
									<input class="form-control" name="name" type="text">
								</div>
							</div>
						
								<div class="input-col col-xs-12">
									<div class="form-group">
										<label>Description</label>&nbsp;(<span class="error">*</span>)
										<textarea class="form-control" name="description" placeholder=""></textarea>
									</div>
								</div>
								<div class="input-col col-xs-12">
									<div class="form-group">
										<label>Start Date</label>&nbsp;(<span class="error">*</span>)
										<input value="" id="start_date" class="form-control" name="start_date" type="text" data-role="tagsinput">
									</div>
								</div>
								
								<div class="input-col col-xs-12">
									<div class="form-group">
										<label>End Date</label>&nbsp;(<span class="error">*</span>)
										<input value="" id="end_date" class="form-control" name="end_date" type="text" data-role="tagsinput">
									</div>
								</div>
			
						</div>
					</div>
				</div>
						
			<br/>
				</form>
			</div>
		</div>
	</div>
</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?php echo base_url();?>assets/script/formValidation.min.js"></script>
	<script src="<?php echo base_url();?>assets/script/bootstrap_framework.js"></script>
	<script src="<?php echo base_url();?>assets/script/bootstrap-select.min.js"></script>
	<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
	<script type="text/javascript">
	$("#imgInp").change(function(){
	    previewImage(this);
	});
	$(document).ready(function() {
	    $('#defaultForm').find('[name="profession"]')
            // Revalidate the cities field when it is changed
            .change(function (e) {
                $('#defaultForm').formValidation('revalidateField', 'profession');
            })
            .end()
			.formValidation({
	        message: 'This value is not valid',
	        framework: 'bootstrap',
	        excluded: ':disabled',
	//        live: 'disabled',
	        icon: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	        	image: {
	        		verbose: false,
	        	   trigger: 'change',
	        	   icon: false,
	        	    message: 'The username is not valid',
	        	    validators: {
	        	    	notEmpty: {
	        	    	    message: 'Profile Image is required and can\'t be empty'
	        	    	},
	        	    	required: {
	        	    	        message: 'Profile Image is required and cannot be empty'
	        	    	    },
	        	        file: {
	        	            extension: 'jpeg,png,jpg,bmp,pdf',
	        	            type: 'image/jpeg,image/png,image/bmp,application/pdf',
	        	            maxSize: 1000000,   // 2048 * 1024
	        	            message: 'The selected file is not valid'
	        	        }
	        	      }
	        	},
	            name: {
	            	verbose: false,
	                trigger: 'blur',
	                message: 'The Name is not valid',
	                validators: {
	                    notEmpty: {
	                        message: 'The First Name is required and can\'t be empty'
	                    },
					stringLength: {
                        min: 1,
                        max: 40,
                        message: 'First name must be more than 1 and less than 40 characters long'
                    },
					regexp: {
                        regexp: /^[a-zA-Z ]+$/,
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
      			admin_status_flag: {
      				verbose: false,
                      trigger: 'blur',
                      message: 'Monitor flag is not valid',
                      validators:
                      	{
                            	notEmpty: {
                              	message: 'Monitor flag is required and can\'t be empty'
                          	},
      	                   remote: {
      	                        type: 'POST',
      	                        url: '<?php echo base_url();?>profile/change_admin_project_flag',
      	                        message: 'Unable to save monitor flag data please try again',
      	                        //delay: 1000
      	                    }
                          }
                      },
						experience: {
					verbose: false,
	                trigger: 'blur',
	                message: 'The Experience is not valid',
	                validators:
	                	{
	                      /*	notEmpty: {
	                        	message: 'The About me is required and can\'t be empty'
	                    	},*/
		                   remote: {
		                        type: 'POST',
		                        url: '<?php echo base_url();?>profile/saveFieldValues',
		                        message: 'Unable to save experience data please try again',
		                        //delay: 1000
		                    }
	                    }
	                },
					education: {
					verbose: false,
	                trigger: 'blur',
	                message: 'The Education is not valid',
	                validators:
	                	{
	                      /*	notEmpty: {
	                        	message: 'The About me is required and can\'t be empty'
	                    	},*/
		                   remote: {
		                        type: 'POST',
		                        url: '<?php echo base_url();?>profile/saveFieldValues',
		                        message: 'Unable to save education data please try again',
		                        //delay: 1000
		                    }
	                    }
	                },
			   old_password: {
			   	verbose: false,
			   	trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    },
					stringLength: {
                        min: 6,
                        message: 'Password must be more than 6 characters long'
					},
                    remote: {
                        type: 'POST',
                        url: '<?php echo base_url();?>profile/checkOldPassword',
                        message: 'Unable to find old password please try again',
                        //delay: 1000
                    }
                }
            },
			 password: {
			 	trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    },
					stringLength: {
                        min: 6,
                        message: 'Password must be more than 6 characters long'
					}
                }
            },
            re_password: {
            	verbose: false,
            	trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: "These passwords don't match. Try again?"
                    },
					 remote: {
                        type: 'POST',
                        url: '<?php echo base_url();?>profile/insertNewPassword',
                        message: 'Unable to save password please try again',
                        //delay: 1000
                    }
                }
            },
		'links[]': {
			verbose: false,
				trigger: 'blur',
                validators: {
                      uri: {
                        message: 'The website address is not valid'
                      },
                     remote: {
                        type: 'POST',
                        data: function(validator, $field, value) {
                        	var link_data=[];
                        	var x=$("[name='links[]']").serializeArray();
                        	$.each(x, function(i, field){
                        	            link_data.push(field.value);
                        	        });
                                                  return {
                                                          links: link_data,
                                                      };
                                     },
                        url: '<?php echo base_url();?>profile/saveFieldValues',
                        message: 'Unable to save link please try again',
                        //delay: 1000
                    }
                }
            },
			'desc[]': {
				verbose: false,
				trigger: 'blur',
                validators: {
                   remote: {
                        type: 'POST',
                        data: function(validator, $field, value) {
                        	var desc_data=[];
                        	var x=$("[name='desc[]']").serializeArray();
                        	$.each(x, function(i, field){
                        	            desc_data.push(field.value);
                        	        });
                                                  return {
                                                          desc: desc_data,
                                                      };
                                     },
                        url: '<?php echo base_url();?>profile/saveFieldValues',
                        message: 'Unable to save description please try again',
                        //delay: 1000
                    }
                }
            },
			'ccNumber[]': {
			  verbose: false,
	                trigger: 'blur',
	                message: 'The card number is not valid',
	                validators: {
	                creditCard:true,
	                 creditCard: {
                            message: 'The credit card number is not valid'
                        },
	                  remote: {
	                        type: 'POST',
	                        data: function(validator, $field, value) {
	                        	var cc_data=[];
	                        	var x=$("[name='ccNumber[]']").serializeArray();
	                        	$.each(x, function(i, field){
	                        	            cc_data.push(field.value);
	                        	        });
	                                                  return {
	                                                          ccNumber: cc_data,
	                                                      };
	                                     },
	                        url: '<?php echo base_url();?>profile/saveFieldValues',
	                        message: 'Unable to save credit card number please try again',
	                        //delay: 1000
	                    }
	                }
	            },
				'cvvNumber[]': {
					verbose: false,
	                trigger: 'blur',
	                message: 'The cvv number is not valid',
	                validators: {
	                 cvv: {
                        creditCardField: 'ccNumber[]',
                        message: 'The CVV number is not valid'
                    },
	                    remote: {
	                        type: 'POST',
	                        data: function(validator, $field, value) {
	                        	var cvv_data=[];
	                        	var x=$("[name='cvvNumber[]']").serializeArray();
	                        	//console.log(x);
	                        	$.each(x, function(i, field){
	                        	            cvv_data.push(field.value);
	                        	        });
	                                                  return {
	                                                          cvvNumber: cvv_data,
	                                                      };
	                                     },
	                        url: '<?php echo base_url();?>profile/saveFieldValues',
	                        message: 'Unable to save cvv number please try again',
	                        //delay: 1000
	                    }
	                }
	            },
				'expDate[]': {
					verbose: false,
                 trigger: 'blur',
				 message: 'The expiration date is not valid',
                validators: {
                    notEmpty: {
                        message: 'The expiration date is required'
                    },
                    regexp: {
                        message: 'The expiration date must be YYYY/MM',
                        regexp: /^\d{4}\/\d{1,2}$/
                    },
					 remote: {
	                        type: 'POST',
	                        data: function(validator, $field, value) {
	                        	var date_data=[];
	                        	var x=$("[name='expDate[]']").serializeArray();
	                        	$.each(x, function(i, field){
	                        	            date_data.push(field.value);
	                        	        });
	                                                  return {
	                                                          expDate: date_data,
	                                                      };
	                                     },
	                        url: '<?php echo base_url();?>profile/saveFieldValues',
	                        message: 'Unable to save expiration date please try again',
	                        //delay: 1000
	                    },
                    callback: {
                        message: 'The expiration date is expired',
                        callback: function(value, validator, $field) {
                            var sections = value.split('/');
                            if (sections.length !== 2) {
                                return {
                                    valid: false,
                                    message: 'The expiration date is not valid'
                                };
                            }
                            var year         = parseInt(sections[0], 10),
                                month        = parseInt(sections[1], 10),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (month <= 0 || month > 12 || year > currentYear + 10) {
                                return {
                                    valid: false,
                                    message: 'The expiration date is not valid'
                                };
                            }
                            if (year < currentYear || (year == currentYear && month < currentMonth)) {
                                // The date is expired
                                return {
                                    valid: false,
                                    message: 'The expiration date is expired'
                                };
                            }
                            return true;
                        }
                    }
                }
            }
	        }
	    }) .on('success.validator.fv', function(e, data) {
            if (data.field === 'ccNumber' && data.validator === 'creditCard') {
                var icon = $('#symbol');
                // data.result.type can be one of
                // AMERICAN_EXPRESS, DINERS_CLUB, DINERS_CLUB_US, DISCOVER, JCB, LASER,
                // MAESTRO, MASTERCARD, SOLO, UNIONPAY, VISA
                switch (data.result.type) {
                    case 'AMERICAN_EXPRESS':
                        icon.removeClass().addClass('form-control  fa fa-cc-amex');
                        break;
                    case 'DISCOVER':
                        icon.removeClass().addClass('form-control fa fa-cc-discover');
                        break;
                    case 'MASTERCARD':
                    case 'DINERS_CLUB_US':
                        icon.removeClass().addClass('form-control  fa fa-cc-mastercard');
                        break;
                    case 'VISA':
                        icon.removeClass().addClass('form-control  fa fa-cc-visa');
                        break;
                    default:
                        icon.removeClass().addClass('form-control  fa fa-credit-card');
                        break;
                }
            }
        }).on('click', '.more_form', function() {
            $('#defaultForm').formValidation('addField', 'links[]').formValidation('addField', 'desc[]')
        }).on('click', '.remove_field', function() {
      		$('#defaultForm').formValidation('removeField', 'links[]').formValidation('removeField', 'desc[]');
        }).on('click', '.more_card', function() {
            $('#defaultForm').formValidation('addField', 'ccNumber[]').formValidation('addField', 'cvvNumber[]').formValidation('addField', 'expDate[]');
        }).on('click', '.remove_card', function() {
 	$('#defaultForm').formValidation('removeField', 'ccNumber[]').formValidation('removeField', 'cvvNumber[]').formValidation('removeField', 'expDate[]');
        })
	});
	$(document).ready(function()
  {
    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $("#wrapper_div"); //Fields wrapper
    var add_button      = $("#more_form"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e)
	 { //on add input button click
        e.preventDefault();
       if(x < max_fields)
		 { //max input box allowed
            x++; //text box increment
			$("#form_multi").val(x);
            $(wrapper).append('<div><div class="row"><div class="input-col col-xs-12 col-sm-5"><div class="form-group"><input class="form-control" id="links" name="links[]" type="url" placeholder="Enter link URL"></div></div><div class="input-col col-xs-12 col-sm-5"><div class="form-group"><input class="form-control" id="desc" type="text" name="desc[]"  placeholder="Enter descriprion"></div></div><div class="col-xs-12 col-sm-2"></div></div><a href="#" class="remove_field radio-inline btn-sm btn-danger gradient" style="float: right; margin-top: -53px; margin-right: 65px;"><i class="fa fa-minus"></i></a></div>'); //add input box
        }
    });
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
       var x =$(this).parent('div').find('input').serializeArray();
        $.each(x, function(i, field){
        	if(i==0)
        	{
        		var fieldName='link';
        	value=field.value;
	        	$.ajax({
	        		url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/user_web_reference',
	        		type: 'POST',
	        		data: {name: value},
	        	})
	        }
            });
        $(this).parent('div').remove(); x--;
	 })
});
	$(document).ready(function()
  {
    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $("#wrapper_card"); //Fields wrapper
    var add_button      = $("#more_card"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e)
	 { //on add input button click
        e.preventDefault();
       if(x < max_fields)
		 { //max input box allowed
            x++; //text box increment
			$("#form_multi").val(x);
            $(wrapper).append('<div><div class="row"><div class="input-col col-xs-12 col-sm-5"><div class="form-group"><label>Credit card number</label><input class="form-control" name="ccNumber[]" type="text" placeholder="card number"></div></div><div class="input-col col-xs-12 col-sm-1"><div class="form-group"><label>symbol</label><i id="symbol" class="form-control fa fa-cc-amex" style="display: block;" data-fv-icon-for="cc"></i></div></div><div class="input-col col-xs-12 col-sm-2"><div class="form-group"><label>CVV</label><input class="form-control" name="cvvNumber[]" type="text" placeholder="cvv"></div></div><div class="input-col col-xs-12 col-sm-2"><div class="form-group"><label>Expiration date</label><input class="form-control" name="expDate[]" type="text" placeholder="YYYY/MM"></div></div></div><a href="#" class="remove_card radio-inline btn-sm btn-danger gradient" style="float: right; margin-top: -53px; margin-right: 65px;"><i class="fa fa-minus"></i></a></div>');//add input box
        }
    });
    $(wrapper).on("click",".remove_card", function(e){ //user click on remove text
    	       var x =$(this).parent('div').find('input').serializeArray();
    	        $.each(x, function(i, field){
    	        	if(i==0)
    	        	{
    	        		var fieldName='card_no';
    	        		value=field.value;
    		        	$.ajax({
    		        		url: '<?php echo base_url();?>profile/deleteData/'+fieldName+'/user_card_detail',
    		        		type: 'POST',
    		        		data: {name: value},
    		        	})
    		        }
    	            });
        e.preventDefault(); $(this).parent('div').remove(); x--;
	 })
    //$('#profession').tagsinput('add', );
});
	</script>
