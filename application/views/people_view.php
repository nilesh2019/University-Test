<?php $this->load->view('template/header');?>
<style>
.fallow_unfallow{
	width: 90%;
}
.navbar {
    background-color:rgb(0,0,0);
	}
	.follower{
		margin-bottom: 0px;
	}
</style>
<div class="middle">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 breadcrumb-bg">
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url();?>">
							Home
						</a>
					</li>
					<li class="active">
						People
					</li>
				</ol>
			</div>
			<div class="clearfix">
			</div>
			<div class="search_container">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3">
							<div class="input-group search">
								<input id="search_people" type="text" placeholder="Type People Name" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<i class="fa fa-search">
										</i>
									</button>
								</span>
							</div>
						</div>
						<div class="col-lg-9">
					</div>
					</div>
				</div>
			</div>
			<div class="clearfix">
			</div>
				<div class="col-lg-12">
					<div class="filter">
						<form id="filter_div">
							<span id="after_this" class="filter_applied">	
							<?php 
//print_r($this->session->all_userdata() );die;
							if($this->session->userdata('flash:old:adv_search_for') != '' ||  ( $this->session->userdata('adv_category_id') !='' || $this->session->userdata('adv_attribute_id') || $this->session->userdata('adv_attri_value_id') || $this->session->userdata('adv_rating')))
									{ ?>
										<i class="fa fa-filter"></i>&nbsp;Filters Applied :
								<?php 	}

									?>						
							</span>
						 <?php
						   	if($this->session->userdata('adv_attribute_id'))
						    { 
						    	$adv_attribute_id_name = $this->db->select('attributeName')->from('attribute_master')->where('id',$this->session->userdata('adv_attribute_id'))->get()->row_array();
						    	?>
							<div id="adv_attribute_sort" class="btn-group adv_section">
							  <button  type="button" class="btn btn-xs btn_most"><?php echo $adv_attribute_id_name['attributeName']; ?></button><button id="close_adv_attribute" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button>
						    </div>
						<?php }	?>
						 <?php
						   	if($this->session->userdata('adv_attri_value_id'))
						    { 
						    	$adv_attri_value_id_name = $this->db->select('attributeValue')->from('attribute_value_master')->where('id',$this->session->userdata('adv_attri_value_id'))->get()->row_array();
						    	?>

							<div id="adv_attri_value_sort" class="btn-group adv_section">
							  <button  type="button" class="btn btn-xs btn_most"><?php echo $adv_attri_value_id_name['attributeValue'] ; ?></button><button id="close_adv_attri_value" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button>
						    </div>
						<?php }	?>
						<?php
						   	if($this->session->userdata('adv_rating'))
						    { ?>
							<div id="adv_rating_sort" class="btn-group adv_section">
							  <button  type="button" class="btn btn-xs btn_most"><?php echo $this->session->userdata('adv_rating'); ?></button><button id="close_adv_rating" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button>
						    </div>
						<?php }	?>
						<?php
						   	if($this->session->userdata('adv_category_id'))
						    {
						    $adv_category_id_name = $this->db->select('categoryName')->from('category_master')->where('id',$this->session->userdata('adv_category_id'))->get()->row_array();
						     ?>
							<div id="creative_sort<?php echo $this->session->userdata('adv_category_id');?>" class="btn-group creative_sorted adv_section"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most"><?php echo  $adv_category_id_name['categoryName'];?></button><button id="close_creative_sort" data-id="<?php echo $this->session->userdata('adv_category_id');?>" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>
						<?php }	?>
							<div id="clear_all_div" class="btn-group" <?php if($this->session->userdata('adv_rating')||$this->session->userdata('adv_attri_value_id')||$this->session->userdata('adv_attribute_id')||$this->session->userdata('adv_category_id')){?> style=""  <?php } else {?> style="display: none" <?php } ?>>
								<button type="button" class="btn btn-xs btn_remove">
									<img src="<?php echo base_url(); ?>assets/images/remove.png" alt="image">
								</button>
								<button id="clear_all_btn" type="button" class="btn btn-xs btn_remove">
									Remove All
								</button>
							</div>
						</form>
					</div>
				</div>
	       <div class="clearfix">
			</div>
			<div class="col-lg-12" id="user_div">
				<?php
				if(!empty($peoples))
				{
					$data = array();
					$data['peoples'] = $peoples;
					$this->load->view('template/peopleThumbnailView',$data);
				}
				else
				{?>
					<div class="col-lg-12">
											<div class="no_content_found">
												<h3>
													No People Found.
												</h3>
											</div>
										</div>
				<?php } ?>
			</div>
		</div>
		<div id="load_img_div"></div>
		<input type="hidden" id="call_count" value="2"/>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script>
	function UrlExists(url)
		{
			$.ajax({
				url: base_url+'project/file_exists',
				type: 'POST',
				data: {'file': url},
			})
			.done(function(data) {
				return data;
			})
		}
	/*$(window).bind("pageshow", function()
		{
			var url=$('#call_count').val(2);
		});*/
	$(document).ready(function()
		{
			var url=$('#base_url').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var mostOfTheWayDown = ($(document).height() - $(window).height());
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						//var search_term = $('#search_people').val();
						search_term = $('#search_people').val();
						$.ajax(
							{
								url: url+"people/more_data",
								data:
								{
									call_count:call_count,search_term:search_term
								},
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										$("#load").remove();
										var obj = $.parseJSON(html);
										$.each(obj, function(index, element)
											{
												var location,name;
												name = element.firstname+'&nbsp;'+element.lastname;
												var name1 = name.length;
												if(name1!='')
												{
													a = parseInt(name1);
													if(a > 20)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 20;
													name = name.substring(0, length)+dot;
												}
												else
												{
													name = '&nbsp';
												}
												location = element.city;
												if(element.country!='')
												{
													location = location+',&nbsp;'+element.country;
												}
												else
												{
													location = location+'&nbsp;';
												}
												if(typeof element.profession != 'undefined')
												{
													var profession = element.profession;
													var lnt = profession.length;
													a = parseInt(lnt);
													if(a > 20)
													{
														var dot ='..';
													}else
													{
														var dot ='';
													}
													var length = 20;
													var trimmedprofession = profession.substring(0, length)+dot;
												}
												else
												{
													var trimmedprofession='';
												}
												if(element.follow_status==1)
												{
													var follow = '<form action="<?php echo base_url();?>user/unfollow_user/'+element.userId+'/0" method="POST"><button type="submit" name="submit" class="fallow_unfallow btn btn_orange" style=" background: #ff8400 none repeat scroll 0 0;"><i class="fa fa-check"></i>&nbsp;FOLLOWING</button></form>';
												}
												else
												{
													var follow ='<form action="<?php echo base_url();?>user/follow_user/'+element.userId+'/0" method="POST"><input type="submit" name="submit" value="FOLLOW" class="fallow_unfallow btn btn_blue"/></form>';
												}
												var profileimage = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
												var tmpImg = new Image();
												tmpImg.src = profileimage;
												var filesize = tmpImg.width;
												var profileimage1='';
//alert(typeof filesize);
												if(element.profileimage=='')
												{
													profileimage1="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}
												else
												{
													
													profileimage1 = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
													
												}
												/*<img class="people__background" src="'+profileimage1+'">*/
												$('#user_div').append('<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="people"><div class="people__title"><div class="be-user-counter"><div class="c_number">'+element.project_count+'</div><div class="c_text">projects</div></div><a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/'+element.userId+'"><img class="img-circle" src="'+profileimage1+'" alt="image" style=></a><h4><a href="<?php echo base_url();?>user/userDetail/'+element.userId+'" class="be-use-name">'+name+'</a></h4><p>'+location+'</p><p class="profession">'+trimmedprofession+'&nbsp;</p><div class="count"><div class="col-lg-4" style="padding:1px;><span title="View"><i class="fa fa-eye"></i>&nbsp;</span><span>'+element.viewCount+'</span></div><div class="col-lg-4" style="padding:1px; ><span title="Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;</span><span>'+element.likeCount+'</span></div><div class="col-lg-4" style="padding:1px;"><span title="Follower"><i class="fa fa-users"></i>&nbsp;</span><span>'+element.followers+'</span></div></div>'+follow+'</div></div></div>');
											});
									}
									else
									{

										if($('#user_div.no_content_found').text()  == '')
										{
											//alert('s');
											$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Peoples Found.</h3></div>');
										}
										else
										{
											//alert('ss');
											$("#load_img_div").html(' ');
										}


										/*$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Peoples Found.</h3></div>');*/
									}
									$(window).scroll(scrollFunction);
								}
							});
					}
					else
					{
						$('#load').remove();
						$(window).scroll(scrollFunction);
					}
				}
			};
			$(window).scroll(scrollFunction);
		});
/////////////////
		$('#search_people').keyup(function()
		{
			delay(function()
				{
					var search_term = $('#search_people').val();
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					if(search_term!='')
					{
						if($("#search_sort").length == 0)
						{
							$('<div id="search_sort" class="btn-group"><button id="search_sort_lable" type="button" class="btn btn-xs btn_most">'+search_term+'</button><button id="close_search_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
						}
						else
						{
							$("#search_sort_lable").text(''+search_term);
						}
					}
					else
					{
						$("#all_project_sort").remove();
						var lght = $("#filter_div > div").length;
						if(lght == 1)
						{
							$("#clear_all_div").hide();
						}
					}
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
				    load_people(call_count,search_term);
				}, 1000);
		});
	var delay = (function()
		{
			var timer = 0;
			return function(callback, ms)
			{
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
			$(document).on("click", "#clear_all_div", function()
				 {
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$('.creative_sorted').remove();
					$('#search_people').val('');
					$("#adv_category_selected").html('Category<span class="caret"></span>');
				    $("#adv_attribute_selected").html('Attribute<span class="caret"></span>');
				    $("#adv_attri_value_selected").html('Attribute Value<span class="caret"></span>');
				    $("#adv_rating_selected").html('Rating<span class="caret"></span>');
					$("#search_sort").remove();
					$("#clear_all_div").hide();
					var search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$("#adv_attribute_sort").remove();
					$("#adv_attri_value_sort").remove();
					$("#adv_rating_sort").remove();
					$.ajax(
					{
						url: url+"people/clear_all_adv_sort",
						type: "POST",
						success:function(html)
						{
							load_people(call_count,search_term);
						}
					});
			     });
				$(document).on("click", "#close_adv_attribute", function()
				{
					var url=$('#base_url').val();
					$.blockUI();
					$("#adv_attribute_sort").remove();
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#adv_attribute_selected").html('Attribute<span class="caret"></span>');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"people/clear_adv_attribute",
						type: "POST",
						success:function(html)
						{
							load_people(call_count,search_term);
						}
					});
				});
				$(document).on("click", "#close_adv_attri_value", function()
				{
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#adv_attri_value_sort").remove();
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#adv_attri_value_selected").html('Attribute Value<span class="caret"></span>');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"people/clear_adv_attri_value",
						type: "POST",
						success:function(html)
						{
							load_people(call_count,search_term);
						}
					});
				});
				$(document).on("click", "#close_adv_rating", function()
				{
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#adv_rating_sort").remove();
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#adv_rating_selected").html('Rating<span class="caret"></span>');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"people/clear_adv_rating",
						type: "POST",
						success:function(html)
						{
							load_people(call_count,search_term);
						}
					});
				});
				$(document).on("click", "#close_creative_sort", function()
				{
					var url=$('#base_url').val();
					var creative_id = $(this).data('id');
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#user_div").html('');
					$("#call_count").val('1');
					$("#creative_sort"+creative_id.toString()).remove();
					$("#adv_category_selected").html('Category<span class="caret"></span>');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"people/clear_adv_category",
						type: "POST",
						success:function(html)
						{
							load_people(call_count,search_term);
						}
					});
				});
				$(document).on("click", "#close_search_sort", function()
				{
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#user_div").html('');
					$("#msg_div").html('');
					$("#load_img_div").html('');
					$("#call_count").val('1');
					$('#search_people').val('');
					$("#search_sort").remove();
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search_people').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_people(call_count,search_term);
				});
	function load_people(call_count,search_term)
	{
		$("#filter_div #after_this").html('');
		var filter_exists = $('#filter_div div').hasClass('adv_section');
		if(search_term != '' || filter_exists ==true){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');			
			$("#filter_div #search_sort").html('<button id="search_sort_lable" class="btn btn-xs btn_most" type="button">'+search_term+'</button><button id="close_search_sort" class="btn btn-xs btn_close" type="button"><i class="fa fa-close"></i></button>');	
			$('#clear_all_div').show();		
		}	
		else
		{
			$('#search_sort').html('');
			$('#clear_all_div').hide();
		} 

		var url=$('#base_url').val();
		$.ajax(
		{
			url: url+"people/more_data",
			data:
			{
				call_count:call_count,search_term:search_term
			},
			type: "POST",
			success:function(html)
			{
				if(html != '')
				{
					$("#load").remove();
					var obj = $.parseJSON(html);
					$.each(obj, function(index, element)
						{
							var location,name;
							name = element.firstname+'&nbsp;'+element.lastname;
							var name1 = name.length;
							if(name1!='')
							{
								a = parseInt(name1);
								if(a > 20)
								{
									var dot ='..';
								}else
								{
									var dot ='';
								}
								var length = 20;
								name = name.substring(0, length)+dot;
							}
							else
							{
								name = '&nbsp';
							}
							location = element.city;
							if(element.country!='')
							{
								location = location+',&nbsp;'+element.country;
							}
							else
							{
								location = location+'&nbsp;';
							}
							if(typeof element.profession != 'undefined')
							{
								var profession = element.profession;
								var lnt = profession.length;
								a = parseInt(lnt);
								if(a > 20)
								{
									var dot ='..';
								}else
								{
									var dot ='';
								}
								var length = 20;
								var trimmedprofession = profession.substring(0, length)+dot;
							}
							else
							{
								var trimmedprofession='';
							}
							if(element.follow_status==1)
							{
								var follow = '<form action="<?php echo base_url();?>user/unfollow_user/'+element.userId+'/0" method="POST"><button type="submit" name="submit" class="fallow_unfallow btn btn_orange"><i class="fa fa-check"></i>&nbsp;FOLLOWING</button></form>';
							}
							else
							{
								var follow ='<form action="<?php echo base_url();?>user/follow_user/'+element.userId+'/0" method="POST"><input type="submit" name="submit" value="FOLLOW" class="fallow_unfallow btn btn_blue"/></form>';
							}
							var profileimage = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
							var tmpImg = new Image();
							tmpImg.src = profileimage;
							var filesize = tmpImg.width;
							var profileimage1='';
							if(element.profileimage=='')
							{
								profileimage1="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
							}
							else
							{
								
								profileimage1 = "<?php echo file_upload_base_url();?>users/thumbs/"+element.profileimage;
								
							}
							/*$('#user_div').append('<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="people"><img class="people__background" src="'+profileimage1+'"><div class="people__title"><div class="be-user-counter"><div class="c_number">'+element.project_count+'</div><div class="c_text">projects</div></div><a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/'+element.userId+'"><img class="img-circle" src="'+profileimage1+'" alt="" style=></a><h4><a href="<?php echo base_url();?>user/userDetail/'+element.userId+'" class="be-use-name">'+name+'</a></h4><p>'+location+'</p><p class="profession">'+trimmedprofession+'&nbsp;</p><div class="count"><div class="col-lg-6"><i class="fa fa-eye"></i>&nbsp;<span>'+element.viewCount+'</span></div><div class="col-lg-6"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span>'+element.likeCount+'</span></div></div>'+follow+'</div></div></div>');*/
							$('#user_div').append('<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"><div class="people"><div class="people__title"><div class="be-user-counter"><div class="c_number">'+element.project_count+'</div><div class="c_text">projects</div></div><a class="be-ava-user style-2" href="<?php echo base_url();?>user/userDetail/'+element.userId+'"><img class="img-circle" src="'+profileimage1+'" alt="image" style=></a><h4><a href="<?php echo base_url();?>user/userDetail/'+element.userId+'" class="be-use-name">'+name+'</a></h4><p>'+location+'</p><p class="profession">'+trimmedprofession+'&nbsp;</p><div class="count"><div class="col-lg-4" style="padding:1px;><span title="View"><i class="fa fa-eye"></i>&nbsp;</span><span>'+element.viewCount+'</span></div><div class="col-lg-4" style="padding:1px; ><span title="Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;</span><span>'+element.likeCount+'</span></div><div class="col-lg-4" style="padding:1px;"><span title="Follower"><i class="fa fa-users"></i>&nbsp;</span><span>'+element.followers+'</span></div></div>'+follow+'</div></div></div>');
							/*<img class="people__background" src="'+profileimage1+'">*/
						});
				}
				$.unblockUI();
			}
		});
	}
</script>
