<?php $this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
	 .box{
	 	overflow: visible;
	 	opacity: 1;
	 }
	 .like .dropdown-menu{
	padding: 0;
	margin-left: -50px;
	 }
	 .like .dropdown-menu li{
	 	border-bottom: 1px solid #ccc;
	 	    color: #252525;
	 	    cursor: pointer;
	 	    padding: 5px 5px 5px 10px;
	 }
	 .like .dropdown-menu li:hover{
	 	background: #f4f4f4;
	 }
	 /* .like > .dropdown-menu{
	 	max-height: 170px !important;
	 	overflow-y: scroll;
	 } */
	 .like > .dropdown-menu{
	    	height: auto !important;
	    		 	   max-height: 150px !important;
	    		 	   overflow-x: hidden !important;
	    }
	    .filter_box{
	    	width: 600px;
	    }
</style>
<div class="ribben">
	<div class="container-fluid">
		<?php
		if( !$this->session->userdata('front_user_id')){
			?>
			<h4>
				Flaunt Your Creativity. Quickly build your portfolio and share with the community .
				<a href="<?php echo base_url();?>hauth/googleLogin">
					<b>
						Signup with Google
					</b>
				</a>to get noticed and hired.
			</h4>
			<?php
		}?>
	</div>
</div>
<div class="search_container">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3">
				<div class="input-group search">
					<input id="search" type="text" placeholder="Type keyword,Project Name or Description" class="form-control">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="btn-group">
					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="showSelection()">
						<!-- Creative Fields --> Filter & Sort
						<i class="fa fa-angle-down"></i>
					</button>
					<div class="dropdown-menu filter_box" id="filter_selection">
						<div class="col-lg-3">
							<h4>
								All Projects
							</h4>
							<div class="body">
								<input type="hidden" id="previous_sort" value="All Projects"/>
								<input type="radio" class="all_project" name="all_project" checked value="All Projects">&nbsp;All Projects<br />
								<input type="radio" class="all_project" name="all_project" value="Completed">&nbsp;Completed<br />
								<input type="radio" class="all_project" name="all_project" value="Work in progress">&nbsp;Work in progress
							</div>
						</div>
						<div class="col-lg-3">
							<h4>
								All Creative Fields
							</h4>
							<div class="body">
								<?php
								if(!empty($category)){
									foreach($category as $cat){
									 if($this->session->userdata('adv_category_id')&&$this->session->userdata('adv_category_id')==$cat['id']){
									 	$ck = 'checked=""'; 
									 }
									 else{
									 	$ck = '';
									 }	
										?>
										<input class="Creative" data-id="<?php echo $cat['id'];?>" data-name="<?php echo $cat['categoryName'];?>" type="checkbox" id="creative_fields<?php echo $cat['id'];?>" <?php echo $ck; ?> name="creative_fields[]" value="<?php echo $cat['id'];?>">&nbsp;<?php echo $cat['categoryName'];?><br />
										<!--<li data-name="<?php echo $cat['categoryName'];?>"><a><?php echo $cat['categoryName'];?></a></li>-->
										<?php
									}
								} ?>
							</div>
						</div>
						<div class="col-lg-3">
							<h4>
								Time
							</h4>
							<div class="body">
								<input type="hidden" id="previous_sort_filter" value="ALL"/>
								<input type="radio" class="filter" name="Time" checked value="ALL">&nbsp;ALL<br />
								<input type="radio" class="filter" name="Time" value="This Month">&nbsp;This Month<br />
								<input type="radio" class="filter" name="Time" value="This Week">&nbsp;This Week<br />
								<input type="radio" class="filter" name="Time" value="Today">&nbsp;Today<br />
								<input type="radio" class="filter" name="Time" value="Featured">&nbsp;Featured<br />								
							</div>
						</div>
						<div class="col-lg-3">
							<h4>
								Sort
							</h4>
							<div class="body">
								<input type="hidden" id="previous_sort_featured" value="Most Recent"/>
								<!-- <input class="Featured" type="radio" name="Featured" checked value="Featured">Featured<br />
								 -->
								<input class="Featured" type="radio" name="Featured" checked value="Most Recent">Most Recent<br />
								<input class="Featured" type="radio" name="Featured" value="Most Appreciated">Most Appreciated<br />
								<input class="Featured" type="radio" name="Featured" value="Most Viewed">Most Viewed<br />
								<input class="Featured" type="radio" name="Featured" value="Most Discussed">Most Discussed<br />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="middle">
	<div class="tranding_projects">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="filter">
						<form id="filter_div">
							<span id="after_this" class="filter_applied">	
							<?php 
							 if($this->session->userdata('flash:old:adv_search_for') != '' || $this->session->userdata('adv_category_id') !='' || $this->session->userdata('adv_attribute_id') || $this->session->userdata('adv_attri_value_id') || $this->session->userdata('adv_rating'))
									{ ?>
										<i class="fa fa-filter"></i>&nbsp;Filters Applied :
								<?php 	}

									?>
								<!-- <i class="fa fa-filter"></i>&nbsp;Filters Applied : -->
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
							<div id="creative_sort<?php echo $this->session->userdata('adv_category_id');?>" class="btn-group creative_sorted adv_section"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most"><?php echo $adv_category_id_name['categoryName']; ?></button><button id="close_creative_sort" data-id="<?php echo $this->session->userdata('adv_category_id');?>" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>
						<?php }	?>
							<div id="clear_all_div" class="btn-group" <?php if($this->session->userdata('adv_rating')||$this->session->userdata('adv_attri_value_id')||$this->session->userdata('adv_attribute_id')||$this->session->userdata('adv_category_id')){?> style=""  <?php } else {?> style="display: none" <?php } ?>>
								<button type="button" class="btn btn-xs btn_remove">
									<img src="<?php echo base_url(); ?>assets/images/remove.png" alt="remove button">
								</button>
								<button id="clear_all_btn" type="button" class="btn btn-xs btn_remove">
									Remove All
								</button>
							</div>
						</form>
					</div>
				</div>
				<div id="project_div">
					<?php
					if(!empty($project))
					{
						$data = array();
						$data['project'] = $project;
						$data['thumbnailNum'] = 6;
						$data['mainClass'] = 'col-lg-2 col-md-2 col-sm-4 col-xs-12';						
						$this->load->view('template/allProjectThumbnailView',$data);
					} else{?>
					<div class="col-lg-12">
						<div class="no_content_found">
							<h3>
								No Project Found.
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
			$('#call_count').val(2);
		});*/
	$(document).ready(function()
		{
			var url=$('#base_url').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var creative= [];
				$("input[name='creative_fields[]']:checked").each(function()
					{
						creative.push($(this).val());
					});
				if(creative.length==0)
				{
					creative = '';
				}
				var all_project = $('input[name=all_project]:checked').val();
				var featured = $('input[name=Featured]:checked').val();
				var vartime = $('input[name=Time]:checked').val();
				search_term = $('#search').val();
				var mostOfTheWayDown = ($(document).height() - $(window).height());
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"all_project/more_data",
								data:
								{
									all_project:all_project,creative:creative,featured:featured,call_count:call_count,search_term:search_term,vartime:vartime
								},
								type: "POST",
								success:function(html)
								{
									
									if(html != '')
									{
										var i=1;
										var div_class;
										$("#load").remove();
										var obj = $.parseJSON(html);
										$.each(obj, function(index, element)
											{
												if(i == 1)
												{
													div_class = 'right5';
													i++;
												}
												else
												if(i == 2 || i== 3)
												{
													div_class = 'rightleft5';
													i++;
												}
												else
												{
													div_class = 'left5';
													i     = 1;
												}
												
												
												var n = element.projectName.length;
												a = parseInt(n);
												if(a > 40)
												{
													var dot ='..';
												}
												else
												{
													var dot ='';
												}
												var length = 40;
												var trimmedName = element.projectName.substring(0, length)+dot;
												
												//var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
												if(element.userLiked==0)
								{
									/*userLiked = '<div class="like like_div" data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'" title="Total Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
									userLiked = '<div class="like dropdown" ><div class="like_div" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>'+element.droupdown+'</div>';
								}
								else{
									/*userLiked = '<div class="like"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
									userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
								}
									var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
									//var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';
								var videoLink = element.videoLink;
								
												if(videoLink != ''){
													var videoImageLink = '<a oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);" href="javascript:void(0);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
												}else{
													var videoImageLink = '<a oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);" href="javascript:void(0);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image thumb"></a>'
												}
												
												$('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'style="height:290px;"><div class="box" style="height: 256px !important;">'+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');
										});
										
										$('div.dropdown').hover(function() {
										  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
										}, function() {
										  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
										});
									}
									else
									{

										if($('#project_div .no_content_found').text()  == '')
										{
											$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
										}
										else
										{
											$("#load_img_div").html(' ');
										}

										//$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Projects Found.</h3></div>');
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
			$('.all_project').click(function(e)
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $(this).val();
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();
					//alert(creative);
					//$('#previous_sort').val(name);
					var previous_sort = $('#previous_sort').val();
					if(all_project!=previous_sort)
					{
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort").val(all_project);
						if(all_project!='All Projects')
						{
							if($("#all_project_sort").length == 0)
							{
								$('<div id="all_project_sort" class="btn-group"><button id="all_project_sort_lable" type="button" class="btn btn-xs btn_most">'+all_project+'</button><button id="close_all_project_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");
							}
							else
							{
								$("#all_project_sort_lable").text(all_project);
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
						/*var lght = $("#filter_div > div").length;
						alert(lght);*/
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
					}
				});
			$('.Creative').click(function(e)
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					$.blockUI();
					$("#clear_all_div").show();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					var creative_name = $(this).data('name');
					var creative_id = $(this).val();
					if($.inArray(creative_id, creative) != -1)
					{
						if($("#creative_sort").length == 0)
						{
							$('<div id="creative_sort'+creative_id+'" class="btn-group creative_sorted"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most">'+creative_name+'</button><button id="close_creative_sort" data-id="'+creative_id+'" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
						}
						else
						{
							$('<div id="creative_sort'+creative_id+'" class="btn-group"><button id="creative_sort_lable" type="button" class="btn btn-xs btn_most">'+creative_name+'</button><button id="close_creative_sort" data-id="'+creative_id+'" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
						}
					}
					else
					{
						if(creative_name==$('#creative_sort'+creative_id.toString()+' #creative_sort_lable').text())
						{
							//alert($('#creative_sort_lable').text());
							$('#creative_sort'+creative_id.toString()).remove();
						}
						/*$("#creative_sort").remove();
						var lght = $("#filter_div").length;
						if(lght == 1)
						{
						}*/
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
				});
				$('.Featured').click(function(e)
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var  vartime = $('input[name=Time]:checked').val();
					//alert(vartime);
					//$('#previous_sort').val(name);
					var previous_sort = $('#previous_sort_featured').val();
					//alert(previous_sort);
					if(featured!=previous_sort)
					{
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort_featured").val(featured);
						if(featured!='Most Recent')
						{
							if($("#featured_sort").length == 0)
							{
								$('<div id="featured_sort" class="btn-group"><button id="featured_sort_lable" type="button" class="btn btn-xs btn_most">'+featured+'</button><button id="close_featured_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
							}
							else
							{
								$("#featured_sort_lable").text(featured);
							}
						}
						else
						{
							$("#featured_sort").remove();
							var lght = $("#filter_div").length;
							// alert(lght);
							if(lght == 1)
							{
								//$("#filter_div").hide();
							}
						}
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
					}
				});
				$('.filter').click(function(e)
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();
					//alert(vartime);
					//$('#previous_sort').val(name);
					var previous_sort = $('#previous_sort_filter').val();
					//alert(previous_sort);
					if(vartime!=previous_sort)
					{
						$("#clear_all_div").show();
						$.blockUI();
						$("#project_div").html('');
						$("#msg_div").html('');
						$("#call_count").val('1');
						$("#previous_sort_filter").val(vartime);
						if(vartime!='ALL')
						{
							if($("#time_sort").length == 0)
							{
								$('<div id="time_sort" class="btn-group"><button id="time_sort_lable" type="button" class="btn btn-xs btn_most">'+vartime+'</button><button id="close_time_sort" type="button" class="btn btn-xs btn_close"><i class="fa fa-close"></i></button></div>').insertBefore("#clear_all_div");;
							}
							else
							{
								$("#time_sort_lable").text(vartime);
							}
						}
						else
						{
							$("#time_sort").remove();
							var lght = $("#filter_div").length;
							// alert(lght);
							if(lght == 1)
							{
								//$("#filter_div").hide();
							}
						}
						search_term = $('#search').val();
						call_count =1;
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
					}
				});
			$(document).on("click", "#close_all_project_sort", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = 'All Projects';
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					//$("#previous_sort").val(all_project);
					$("#all_project_sort").remove();
					//$('input[name=all_project]:checked','checked');
					$('.all_project').removeAttr('checked');
					$("input:radio[name=all_project]:first").prop('checked','checked');
					//$(".all_project").val('all_project').prop('checked','checked');
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
				});
			$(document).on("click", "#close_creative_sort", function()
				{
					var creative= [];
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var creative_id = $(this).data('id');
					//var data_id = $('.Creative').data('id');
					 $("#adv_category_selected").html('Category<span class="caret"></span>');
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#creative_sort"+creative_id.toString()).remove();
					$('#creative_fields'+creative_id.toString()).prop('checked','');
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					if(creative.length==0)
					{
						creative = '';
					}
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"all_project/clear_adv_category",
						type: "POST",
						success:function(html)
						{
							load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
						}
					});
				});
			$(document).on("click", "#close_featured_sort", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = 'Featured';
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#previous_sort_featured").val(featured);
					$("#featured_sort").remove();
					$('.Featured').removeAttr('checked');
					$("input:radio[name=Featured]:first").prop('checked','checked');
					var vartime = $('input[name=Time]:checked').val();

					/*  $("#all_project_sort").remove();*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
				});
			$(document).on("click", "#close_time_sort", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var vartime = 'ALL';
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#previous_sort_filter").val(vartime);
					$("#time_sort").remove();
					$('.filter').removeAttr('checked');
					$("input:radio[name=Time]:first").prop('checked','checked');
					var featured = $('input[name=Featured]:checked').val();

					/*  $("#all_project_sort").remove();*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
				});
			$(document).on("click", "#close_search_sort", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$('#search').val('');
					$("#search_sort").remove();
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
				});
			$(document).on("click", "#clear_all_div", function()
				{
					var creative= [];
					var featured = 'Featured';
					var url=$('#base_url').val();
					var all_project = 'All Projects';
					/* var previous_sort = $('#previous_sort').val();*/
					$("#adv_category_selected").html('Category<span class="caret"></span>');
				    $("#adv_attribute_selected").html('Attribute<span class="caret"></span>');
				    $("#adv_attri_value_selected").html('Attribute Value<span class="caret"></span>');
				    $("#adv_rating_selected").html('Rating<span class="caret"></span>');
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#all_project_sort").remove();
					$('.all_project').removeAttr('checked');
					$("input:radio[name=all_project]:first").prop('checked','checked');
					$("#previous_sort_featured").val(featured);
					$("#featured_sort").remove();
					$('.Featured').removeAttr('checked');
					$("input:radio[name=Featured]:first").prop('checked','checked');
					$('.Creative').prop('checked','');
					$('.creative_sorted').remove();
					$("#clear_all_div").hide();
					$('#search').val('');
					$("#clear_all_div").hide();
					$("#search_sort").remove();
					search_term = $('#search').val();
					if(creative.length==0)
					{
						creative = '';
					}
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$("#adv_attribute_sort").remove();
					$("#adv_attri_value_sort").remove();
					$("#adv_rating_sort").remove();
					$.ajax(
					{
						url: url+"all_project/clear_all_adv_sort",
						type: "POST",
						success:function(html)
						{
							load_projects(url,all_project,creative,featured,call_count,search_term);
						}
					});
				});
				$(document).on("click", "#close_adv_attribute", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
						$("#adv_attribute_selected").html('Attribute<span class="caret"></span>');
					$.blockUI();
					$("#adv_attribute_sort").remove();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					/*$('#search').val('');
					$("#search_sort").remove();
					*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"all_project/clear_adv_attribute",
						type: "POST",
						success:function(html)
						{
							load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
						}
					});
				});
				$(document).on("click", "#close_adv_attri_value", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
					 $("#adv_attri_value_selected").html('Attribute Value<span class="caret"></span>');
					$.blockUI();
					$("#adv_attri_value_sort").remove();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					/*$('#search').val('');
					$("#search_sort").remove();
						*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"all_project/clear_adv_attri_value",
						type: "POST",
						success:function(html)
						{
							load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
						}
					});
				});
				$(document).on("click", "#close_adv_rating", function()
				{
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var featured = $('input[name=Featured]:checked').val();
					var vartime = $('input[name=Time]:checked').val();

					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					/* var previous_sort = $('#previous_sort').val();*/
				$("#adv_rating_selected").html('Rating<span class="caret"></span>');
					$.blockUI();
					$("#adv_rating_sort").remove();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					/*$('#search').val('');
					$("#search_sort").remove();*/
					var lght = $("#filter_div > div").length;
					if(lght == 1)
					{
						$("#clear_all_div").hide();
					}
					search_term = $('#search').val();
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
					{
						url: url+"all_project/clear_adv_rating",
						type: "POST",
						success:function(html)
						{
							load_projects(url,all_project,creative,featured,call_count,search_term,vartime);
						}
					});
				});
			});
	function load_projects(url,all_project,creative,featured,call_count,search_term,vartime)
	{
		$("#filter_div #after_this").html('');
		/*	$("#filter_div #adv_rating_sort").html('');
		$("#filter_div #after_this").html('')*/
		$("#filter_selection").hide();
		var filter_exists = $('#filter_div div').hasClass('adv_section');

		if(search_term != '' || filter_exists ==true){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');
			$("#filter_div #search_sort").html('<button id="search_sort_lable" class="btn btn-xs btn_most" type="button">'+search_term+'</button><button id="close_search_sort" class="btn btn-xs btn_close" type="button"><i class="fa fa-close"></i></button>');		
			$('#clear_all_div').show();
		}
		else if(creative != ''){
			$("#filter_div #after_this").html('<span id="after_this" class="filter_applied"><i class="fa fa-filter"></i>&nbsp;Filters Applied :</span>');	
			$("#filter_div #search_sort").html('<button id="search_sort_lable" class="btn btn-xs btn_most" type="button">'+search_term+'</button><button id="close_search_sort" class="btn btn-xs btn_close" type="button"><i class="fa fa-close"></i></button>');		
			$('#clear_all_div').show();		
		}
		else
		{
			$('#search_sort').html('');
			$('#clear_all_div').hide();
		}
		
		$.ajax(
			{
				url: url+"all_project/sort_by",
				data:
				{
					all_project:all_project,creative:creative,featured:featured,call_count:call_count,search_term:search_term,vartime:vartime
				},
				type: "POST",
				success:function(html)
				{
					if(html != '')
					{
						var i = 1;
						var div_class;
						$("#load").remove();
						$("#no_rec").remove();
						var obj = $.parseJSON(html);
						$.each(obj, function(index, element)
							{
								if(i == 1)
								{
									div_class = 'right5';
									i++;
								}
								else
								if(i == 2 || i== 3)
								{
									div_class = 'rightleft5';
									i++;
								}
								else
								{
									div_class = 'left5';
									i     = 1;
								}
								
								
								var n = element.projectName.length;
								a = parseInt(n);
								if(a > 40)
								{
									var dot ='..';
								}
								else
								{
									var dot ='';
								}
								var length = 40;
								var trimmedName = element.projectName.substring(0, length)+dot;
								
								
								//var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';
								if(element.userLiked==0)
								{
									/*userLiked = '<div class="like like_div" data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'" title="Total Likes"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
									userLiked = '<div class="like dropdown" ><div class="like_div" onhover  data-name="0" data-id="'+element.id+'" data-like="'+element.like_cnt+'"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-o-up" id="like_div_id"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>'+element.droupdown+'</div>';
								}
								else{
									/*userLiked = '<div class="like"><i class="fa fa-thumbs-up"></i>&nbsp;<span class="like_span">'+element.like_cnt+'</span></div>';*/
									userLiked = '<div class="like dropdown"><span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumbs-up"></i></span>&nbsp;<span class="like_span">'+element.like_cnt+'</span>'+element.droupdown+'</div>';
								}
								/*var urllink ='window.location="<?php echo base_url()?>projectDetail/'+element.projectPageName+'"';*/
								var urllink ='<?php echo base_url()?>projectDetail/'+element.projectPageName;
								/*var urllink ='showProjectDetailModal(`'+element.projectPageName+'`)';*/
								var videoLink = element.videoLink;
								
												if(videoLink != ''){
													var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><iframe class="img-responsive project-img" width="100%" height="100%" src="https://www.youtube.com/embed/'+element.videoLink+'?rel=0" frameborder="0" allowfullscreen></iframe></a>';
												}else{
													var videoImageLink = '<a href="javascript:void(0);" oncontextmenu="return false;" onclick="showProjectDetailModal(`'+element.projectPageName+'`);"><img class="img-responsive  project-img" src="<?php echo file_upload_base_url();?>project/thumbs/'+element.image_thumb+'" alt="image thumb"></a>'
												}

 							    $('#project_div').append('<div class="col-lg-2 col-md-2 col-sm-6 '+div_class+'"><div class="box" style="height: 256px !important;">'+videoImageLink+'<div class="product-overlay"><div class="overlay-content"><div class="top"><div class="proj_name"><a href="'+urllink+'" title="'+element.projectName+'">'+trimmedName+'</a></div><div class="col-lg-12 col-xs-12 padding_none" style="padding-left:6px"><h5>'+element.categoryName+'</h5></div></div><div class="footer"><div class="col-lg-4 col-xs-4"><div class="view" title="Total Views"><i class="fa fa-eye"></i>&nbsp;<span>'+element.view_cnt+'</span></div></div><div class="col-lg-4 col-xs-4">'+userLiked+'</div><div class="col-lg-4 col-xs-4"><div class="photo" title="Total Project Images"><i class="fa fa-picture-o"></i>&nbsp;<span>'+element.imageCount+'</span></div></div></div></div></div></div></div>');	
							});
			$('div.dropdown').hover(function() {
			  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
			}, function() {
			  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
			});
			}
					$.unblockUI();
				}
			});
	}
	function showSelection(){
		$("#filter_selection").show();
	}
	$(document).on("click", function() {
  		$("#filter_selection").hide();
	});
	$('#search').keyup(function()
		{
			delay(function()
				{
					var search_term = $('#search').val();
					var creative= [];
					$("input[name='creative_fields[]']:checked").each(function()
						{
							creative.push($(this).val());
						});
					if(creative.length==0)
					{
						creative = '';
					}
					var url=$('#base_url').val();
					var all_project = $('input[name=all_project]:checked').val();
					var featured = $('input[name=Featured]:checked').val();
					var previous_sort = $('#previous_sort').val();
					$.blockUI();
					$("#project_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					$("#previous_sort").val(all_project);
					$("#clear_all_div").show();
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
					load_projects(url,all_project,creative,featured,call_count,search_term);
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
</script>
