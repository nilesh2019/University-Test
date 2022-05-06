<?php $this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<!-- MAIN CONTENT -->
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
					<li class="active">
						Institutes
					</li>
				</ol>
			</div>
					  
			   <div class="input-group blog_search">
		           <input type="text" id="search_institute" value="<?php if(isset($search)&&$search!=''){ echo $search;}?>" class="form-control">
		           <span class="input-group-btn">
		               <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
		           </span>
			   </div>
			  
		</div>
		<div class="clearfix">
		</div>
		<div class="row institute" id="institute_div">
			<?php
			if(!empty($institute)){
				$i = 1;
				foreach($institute as $row){
					if($i == 1){
						$class = 'right7';
					}
					else
					if($i == 2 || $i == 3){
						$class = 'rightleft7';
					}
					elseif($i == 4){
						$class = 'left7';
						$i     = 0;
					}
					?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 <?php echo $class;?>">
						<div class="thumbnail">
							<div class="inst_img">
								<a href="<?php echo base_url();?><?php echo $row['pageName'];?>">
									<?php
									if($row['coverImage'] != '' && file_exists(file_upload_s3_path().'institute/coverImage/thumbs/'.$row['coverImage']) && filesize(file_upload_s3_path().'institute/coverImage/thumbs/'.$row['coverImage']) > 0)
									{
										?>
										<img src="<?php echo file_upload_base_url();?>institute/coverImage/thumbs/<?php echo $row['coverImage'];?>" alt="institute" style="height: 203px;">
										<?php
									}
									else
									{
										?>
										<img src="<?php echo base_url();?>assets/images/Institute_BigThumb_Banner.png" alt="institute" style="height: 203px;">
										<?php
									} ?>
								</a>
							</div>
							<div class="caption">
									<!-- <div class="be-user-counter">
										<div class="c_number" style="margin-left: 24px;">
											<?php echo $row['project_cnt'];?>
										</div>
										<div class="c_text" style="margin-left: 10px;">
											Projects
										</div>
									</div>	 -->						
								<h3>
									<a href="<?php echo base_url();?><?php echo $row['pageName'];?>">
										<?php echo $row['instituteName'];?>
									</a>
								</h3>
								<div class="media desc">
									<div class="media-left">
										<?php
										if($row['instituteLogo'] != '' && file_exists(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) && filesize(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogo']) > 0)
										{
											?>
											<img class="media-object" src="<?php echo file_upload_base_url();?>institute/instituteLogo/<?php echo $row['instituteLogo'];?>" alt="image">
											<?php
										}
										else
										{
											?>
											<img class="media-object" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/Institute_Logo.png" alt="institute">
											<?php
										} ?>
									</div>
									<div class="media-body">
										<h4 class="media-heading">
											<?php
											if(isset($row['address']) && !empty($row['address'])){
												$atr = $row['address'];
												if(strlen($atr) > 70)
												{
													$dot = '..';
												}
												else
												{
													$dot = '';
												}
												$position = 70;
												echo $post2 = substr($atr, 0, $position).$dot;
											}
											else
											{
												echo '&nbsp;';
											}
											?>
										</h4>										
									</div>
									<div class="media-footer" style="background-color: #5BC0DE;font-size: 15px;border-radius: 25px;color: white;margin-top:5px;">
										<center><?php echo $row['project_cnt'];?> Projects</center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $i++;
				}
			}
			else
			{
				?>
				<div class="col-lg-12">
					<div class="no_content_found">
						<h3>
							No Institute Found.
						</h3>
					</div>
				</div>
				<?php
			}?>

			   <div class="col-lg-12">
				   <!-- <div id="msg_div"></div> -->
				  <!--  <input type="hidden" id="call_count" value="2"/> -->
				   <input type="hidden" id="userId" value="<?php
				   if($this->session->userdata('front_user_id'))
				   {
				   	echo $this->session->userdata('front_user_id');
				   }?>"/>
				   <input type="hidden" id="fLoggedIn" value="<?php
				   if($this->session->userdata('front_is_logged_in'))
				   {
				   	echo $this->session->userdata('front_is_logged_in');
				   }?>"/>
				</div>
		</div>
	  <input type="hidden" id="call_count" value="2"/>
				<div id="load_img_div" style="width:400px;">
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script>
	/*$(window).bind("pageshow", function()
		{
			$('#call_count').val(2);
		});*/
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
	$(document).ready(function()
		{
			var url=$('#base_url').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();

				//alert(call_count);

				var search_term = $('#search_institute').val();
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img style="width:100px;" alt="image" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"institute/institute_more_data",
								data:
								{
									call_count:call_count,search_term:search_term
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
													div_class = 'right7';
													i++;
												}
												else
												if(i == 2 || i== 3)
												{
													div_class = 'rightleft7';
													i++;
												}
												else
												{
													div_class = 'left7';
													i     = 1;
												}
												if($('#fLoggedIn').val()=='' && $('#userId').val()=='')
												{
													var join_btn = '<a class="be-ava-left btn btn-primary size-2 gradient" href="#">JOIN</a>';
												} else
												{
													var join_btn = '';
												}
												var instituteLogo ="<?php echo base_url();?>creosouls_admin/backend_assets/img/Institute_Logo.png";
												/*if(UrlExists(instituteLogo))
												{
													var instituteLogo="<?php echo base_url();?>creosouls_admin/backend_assets/img/Institute_Logo.png";
												}*/
												var instituteCover ="<?php echo base_url();?>assets/images/Institute_BigThumb_Banner.png";
												/*if(UrlExists(instituteCover))
												{
													var instituteCover="<?php echo base_url();?>assets/images/Institute_BigThumb_Banner.png";
												}*/
												var n = element.address.length;
												a = parseInt(n);
												if(a > 70)
												{
													var dot ='..';
												}
												else
												{
													var dot ='';
												}
												var length = 70;
												var trimmedAddress = element.address.substring(0, length)+dot;
												$('#institute_div').append('<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 '+div_class+'"><div class="thumbnail"><div class="inst_img"><a href="<?php echo base_url();?>'+element.pageName+'"><img src="'+instituteCover+'" alt="institute" style="height: 203px;"></a></div><div class="caption">	<h3><a href="<?php echo base_url();?>'+element.pageName+'">'+element.instituteName+'</a></h3><div class="media desc"><div class="media-left"><img class="media-object" alt="image" src="'+instituteLogo+'"></div><div class="media-body"><h4 class="media-heading">'+trimmedAddress+'</h4></div><div class="media-footer" style="background-color: #5BC0DE;font-size: 15px;border-radius: 25px;color: white;margin-top:5px;"> <center>'+element.project_cnt+' Projects</center> </div></div></div></div></div>');
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Institutes Found.</h3></div>');
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
			$('.join').click(function()
				{
					var ins_id = $(this).attr('data-id');
					$.ajax(
						{
							url: url+"institute/join_institute",
							data:
							{
								ins_id:ins_id
							},
							type: "POST",
							success:function(html)
							{
								window.location="<?php echo base_url();?>hauth/googleLogin";
							}
						});
				})
		});

//////////////////////////////////////////////////////

	$(document).ready(function()
		{

				$('#search_institute').keyup(function()
				{
					delay(function()
						{
							var search_term = $('#search_institute').val();
							var url=$('#base_url').val();
							$.blockUI();
							$("#institute_div").html('');
							$("#load_img_div").html('');
							$("#msg_div").html('');
							$("#call_count").val('1');
							call_count =1;
							a = parseInt(call_count);
							$("#call_count").val(a+1);
						    load_institute(call_count,search_term);
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

			function load_institute(call_count,search_term)
			{
				    var url=$('#base_url').val();
					a = parseInt(call_count);
					$("#call_count").val(a+1);
					$.ajax(
						{
							url: url+"institute/search_more_data",
							data:
							{
								call_count:call_count,search_term:search_term
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
												div_class = 'right7';
												i++;
											}
											else
											if(i == 2 || i== 3)
											{
												div_class = 'rightleft7';
												i++;
											}
											else
											{
												div_class = 'left7';
												i     = 1;
											}
											if($('#fLoggedIn').val()=='' && $('#userId').val()=='')
											{
												var join_btn = '<a class="be-ava-left btn btn-primary size-2 gradient" href="#">JOIN</a>';
											} else
											{
												var join_btn = '';
											}
											var instituteLogo ="<?php echo base_url();?>creosouls_admin/backend_assets/img/Institute_Logo.png";
											/*if(UrlExists(instituteLogo))
											{
												var instituteLogo="<?php echo base_url();?>creosouls_admin/backend_assets/img/Institute_Logo.png";
											}*/
											var instituteCover ="<?php echo base_url();?>assets/images/Institute_BigThumb_Banner.png";
											/*if(UrlExists(instituteCover))
											{
												var instituteCover="<?php echo base_url();?>assets/images/Institute_BigThumb_Banner.png";
											}*/
											var n = element.address.length;
											a = parseInt(n);
											if(a > 70)
											{
												var dot ='..';
											}
											else
											{
												var dot ='';
											}
											var length = 70;
											var trimmedAddress = element.address.substring(0, length)+dot;
											$('#institute_div').append('<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 '+div_class+'"><div class="thumbnail"><div class="inst_img"><a href="<?php echo base_url();?>'+element.pageName+'"><img src="'+instituteCover+'" alt="institute" style="height: 203px;"></a></div><div class="caption"><h3><a href="<?php echo base_url();?>'+element.pageName+'">'+element.instituteName+'</a></h3><div class="media desc"><div class="media-left"><img class="media-object" alt="image" src="'+instituteLogo+'"></div><div class="media-body"><h4 class="media-heading">'+trimmedAddress+'</h4></div></div></div></div></div>');
										});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Institutes Found.</h3></div>');
									}
									//$(window).scroll(scrollFunction);
									$.unblockUI();
							}
						});
				}

		});

</script>

