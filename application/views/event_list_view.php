<?php $this->load->view('template/header');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.navbar {
    background-color:rgb(0,0,0);
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
						Event
					</li>
				</ol>
			</div>
			<div class="clearfix">
			</div>
			<?php
			if(!empty($event)){
				?>
				<div id="event_div">
					<?php
					$i = 1;
					foreach($event as $row){
						if($i == 1){
							$class = 'left7';
						}
						else
						{
							$class = 'right7';
							$i     = 0;
						}
						?>
						<div class="col-md-6 <?php echo $class;?>">
							<div class="event_list">
								<div class="media">
									<a href="<?php echo base_url();?>event/show_event/<?php echo $row['id'];?>">
										<div class="media-left media-top" style="padding-top: 10px">
											<img class="media-object" src="<?php echo file_upload_base_url();?>event/banner/thumbs/<?php echo $row['banner'];?>" alt="thumb image">
										</div>
										<div class="media-body">
											<h4 class="media-heading">
												<?php echo $row['name'];?>
											</h4>
											<p>
												<i class="fa fa-calendar-check-o">
												</i>&nbsp;Start Date :
												<span>
													<?php echo date("F j, Y",strtotime($row['start_date']));?>
												</span>
											</p>
											<p>
												<i class="fa fa-calendar-check-o">
												</i>&nbsp;End Date&nbsp; :
												<span>
													<?php echo date("F j, Y",strtotime($row['end_date']));?>
												</span>
											</p>
										</div>
									</a>
								</div>
							</div>
						</div>
						<?php $i++;
					} ?>
				</div>
				<div class="col-lg-12">
					<div class="no_content_found">
						<div id="load_img_div" style="width: 400px;">
						</div>
						<!--<div id="msg_div">
						</div>-->
						<input type="hidden" id="call_count" value="2"/>
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
				<?php
			}
			else
			{
				?>
				<div class="col-lg-12">
					<div class="no_content_found">
						<h3>
							No Event Found.
						</h3>
					</div>
				</div>
				<?php
			} ?>
		</div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script>
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
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
				if ($(window).scrollTop() >= mostOfTheWayDown)
				{
					$("#load_img_div").append('<center id="load"><img style="width:100px;" alt="thumb image" src="'+url+'assets/img/load.gif"/></center>');
					$(window).unbind("scroll");
					if($("#no_rec").length==0)
					{
						a = parseInt(call_count);
						$("#call_count").val(a+1);
						$.ajax(
							{
								url: url+"event/event_more_data",
								data:
								{
									call_count:call_count
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
												/*var n = element.descrition.length;
												a = parseInt(n);
												if(a > 40) { var dot ='..'; } else { var dot =''; }
												var length = 40;
												var trimmeddescrition = element.descrition.substring(0, length)+dot;*/
												$('#event_div').append('<div class="col-md-6 <?php echo $class;?>"><div class="event_list"><div class="media"><a href="<?php echo base_url();?>event/show_event/'+element.id+'"><div class="media-left media-top" style="padding-top: 10px"><img class="media-object" alt="thumb image" src="<?php echo file_upload_base_url();?>event/banner/thumbs/'+element.banner+'" alt=""></div><div class="media-body"><h4 class="media-heading">'+element.name+'</h4><p><i class="fa fa-calendar-check-o"></i> Start Date : <span>'+element.start_date+'</span></p><p><i class="fa fa-calendar-check-o"></i> End Date&nbsp; : <span>'+element.end_date+'</span></p></div></a></div></div></div>');
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Events Found.</h3></div>');
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
</script>
