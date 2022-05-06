 <?php $this->load->view('template/header');?>
  <style>
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
 
<div class="middle">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url()?>">
					Home
				</a>
			</li>
			<?php
			if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id')!='')
			{?>
			<li>
				<a href="<?php echo base_url()?>profile">
					Dashboard
				</a>
			</li>
			<?php }?>
          	<li class="active">Appriciate Work</li>
        </ol>
      </div>
      <div class="clearfix"></div>
      <div id="project_div">
      <?php 
      if(!empty($appriciation))
      	{ $i=1;
      		foreach($appriciation as $row)
      		 {
      		 	if($i==1)
      		 	{
      		 		$class = 'right7';
      		 	}
      		 	elseif($i==2)
      		 	{
      		 		$class = 'rightleft7';
      		 	}
      		 	else
      		 	{
					$class = 'left7'; $i=0;
				}
      		?>
	      <div class="col-lg-4 <?php echo $class;?>">
	      	<div class="appreciate">
	        	<div class="box">
	            	<div class="col-lg-3">
	            	   <?php if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0) { ?>
							<img class="img-circle" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileImage']?>" alt="profile Image" >
						<?php } else {?>
						   <img class="img-circle" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="profile Image" >
						<?php } ?>
	                </div>
	                <div class="col-lg-9">
	                	<h4><?php echo $row['firstName']?>&nbsp;<?php echo $row['lastName']?></h4>
	                	<?php if($row['status']==1){ ?>
	                    <button id="stat<?php echo $row['id']?>" data-id="<?php echo $row['id']?>" data-state="0"  class="btn btn-success pull-right appri_btn" >Active</button>
	                    <?php }else { ?>
	                     <button id="stat<?php echo $row['id']?>" data-id="<?php echo $row['id']?>" data-state="1"  class="btn btn-danger pull-right appri_btn" >Deactive</button>
	                    <?php } ?>
	                    <ul style="color: black;">
	                    	<li><?php echo $row['profession'];?></li>
	                        <li><?php if($row['city']!='') { echo $row['city']; ?><?php }else{ echo 'Location';} ?> &nbsp;<i class="fa fa-map-marker"> </i></li>
	                    </ul>
	                </div>
	                </div>
	                <div class="col-lg-12">
	                    <span><?php echo $row['comment'];?></span>
	               </div>
	        </div>
	      </div>
   <?php  $i++; }
      } ?>
      </div>
    </div>
        <div id="load_img_div" style="height: 53px;width: 130px; position: relative;top: 0%;left: 40%;">
		</div>
		<div id="msg_div">
		</div>
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
			$('#call_count').val(2);
		});*/
	        var url=$('#base_url').val();
			var cat_id = 0;
			var scrollFunction = function()
			{
				var call_count= $("#call_count").val();
				var mostOfTheWayDown = ($(document).height() - $(window).height()) * 2 / 3;
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
								url: url+"appreciatework/more_data",
								data:{ call_count:call_count },
								type: "POST",
								success:function(html)
								{
									if(html != '')
									{
										$("#load").remove();
										var obj = $.parseJSON(html);
										var i=1;
										  $.each(obj, function(index, element)
											{
												  if(i==1)
									      		 	{
									      		 		var classs = 'right7';
									      		 	}
									      		 	else if(i==2)
									      		 	{
									      		 		var classs = 'rightleft7';
									      		 	}
									      		 	else
									      		 	{
														var classs = 'left7'; i=0;
													}
												var profileImage="<?php echo file_upload_base_url();?>users/thumbs/"+element.profileImage;
												/*if(!UrlExists(profileImage))
												{
													var profileImage="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												var date = element.created;
												var urllink ='window.location="<?php echo base_url()?>project/projectDetail/'+element.id+'/'+element.userId+'"';
												var loca;
												if(element.status==1)
												{
												var btn = '<button id="stat'+element.id+'" data-id="'+element.id+'" data-state="'+element.status+' class="btn btn-success pull-right appri_btn">Active</button>';
												}
												else
												{
												var btn = '<button id="stat'+element.id+'" data-id="'+element.id+'" data-state="'+element.status+' class="btn btn-danger pull-right appri_btn">Deactive</button>';
												}
												if(element.city!='') { loca = element.city; }else{ loca = 'Location';}

												var myStr = element.firstName+' '+element.lastName;
												var getStrLength = myStr.length;
												var fixedLengthSter = myStr.substring(0, 22);
												if(getStrLength > 22)
												{
													var str2 = '...';
													var fixedLengthSter = fixedLengthSter.concat(str2)
												}

												$('#project_div').append('<div class="col-lg-4 '+classs+'"><div class="appreciate"><div class="box"><div class="col-lg-3"><img class="img-circle" src="'+profileImage+'" alt="profile Image" ></div><div class="col-lg-9"><h4>'+fixedLengthSter+'</h4>   <ul style="color: black;"><li>'+element.profession+'</li><li>'+loca+'&nbsp;<i class="fa fa-map-marker"> </i></li></ul></div></div><div class="col-lg-12"><span>'+element.comment+'</span></div></div></div>');
												i++;
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Appreciations Found.</h3></div>');
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
	           $(document).on("click", ".appri_btn", function()
				{
				    var id = $(this).attr('data-id');
				    var status = $(this).attr('data-state');
					    $.ajax({
								url: url+"appreciatework/change_status",
								data:{id:id,status:status},
								type: "POST",
								success:function(html)
								{
									if(html!='')
									{
										if(status=='0')
										{
											$('#stat'+id).removeClass('btn-success').addClass('btn-danger');
											$('#stat'+id).text('Deactive');
											$('#stat'+id).attr('data-state',1);
										}
										if(status=='1')
										{
											$('#stat'+id).removeClass('btn-danger').addClass('btn-success');
											$('#stat'+id).text('Active');
											$('#stat'+id).attr('data-state',0);
										}
									}
								}
							})
				});
</script>
