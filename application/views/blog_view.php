<?php $this->load->view('template/header');?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
</style>
<div class="middle blog_dtl">
  <div class="container">
  	<div class="row">
             <div class="border_btm">
                <h1>Newsletter List</h1>
                <div class="input-group blog_search">
                        <input type="text" id="search_blog" value="<?php if(isset($search)&&$search!=''){ echo $search;}?>" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
        </div>
      <div id="blog_div">
      <?php
         if(!empty($blog))
           {
			foreach ($blog as $val)
			{ ?>
         <!-- Blog Post Row -->
        <div class="row">
            <div class="col-md-2 text-center">
                <p><i class="fa fa-camera fa-4x"></i>
                </p>
                <p style=""><?php echo ucfirst(date("j F Y", strtotime($val['created']))) ;?></p>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $val['id'];?>">
                    <img class="img-responsive img-hover" src="<?php echo file_upload_base_url();?>blog/<?php echo $val['picture'];?>" alt="blog picture">
                </a>
            </div>
            <div class="col-md-6">
                <h3>
                    <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $val['id'];?>"><?php echo $val['title'];?></a>
                </h3>
                <p>by <a href="javascript:void(0)" style="cursor: auto"><?php echo $val['posted_by'];?></a>
                </p>
                <a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $val['id'];?>" class="btn btn_blue">Read More  <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
        <!-- /.row -->
          <hr>
	 <?php }
	     }
	    else
		{ ?>
			  <div class="col-lg-12">
					<div class="no_content_found">
						<h3>
							No newsletter Found.
						</h3>
					</div>
				</div>
		<?php }?>
		  </div>
		   <div class="col-lg-12">
					<div class="no_content_found">
						<div id="load_img_div" style="height: 53px;width: 130px; position: relative;top: 0%;left: 40%;">
						</div>
						<input type="hidden" id="call_count" value="2"/>
     				</div>
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
				var search_term = $('#search_blog').val();
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
								url: url+"newsletter/more_data",
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
												var n = element.description.length;
												a = parseInt(n);
												if(a > 190) { var dot ='..'; } else { var dot =''; }
												var length = 190;
												var trimmeddescrition = element.description.substring(0, length)+dot;
												var pic ="<?php echo file_upload_base_url();?>blog/"+element.picture;
												/*if(UrlExists(pic))
												{
													var pic="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
												}*/
												$('#blog_div').append('<div class="row"><div class="col-md-2 text-center"><p><i class="fa fa-camera fa-4x"></i></p><p  style=" " >'+element.created+'</p></div><div class="col-md-4"><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'"><img class="img-responsive img-hover" src="'+pic+'" alt="blog picture"></a></div><div class="col-md-6"><h3><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'">'+element.title+'</a></h3><p>by <a href="javascript:void(0);" style="cursor: auto">'+element.posted_by+'</a></p><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'" class="btn btn_blue">Read More  <i class="fa fa-angle-right"></i></a></div></div><hr>');
											});
									}
									else
									{
										$("#load_img_div").html('<div id="no_rec" style="height: 30px; top: 0%;text-align:center;"><h3 style="font-family: helveticaneue;">No More Newsletter Found.</h3></div>');
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
		$('#search_blog').keyup(function()
		{
			delay(function()
				{
					var search_term = $('#search_blog').val();
					var url=$('#base_url').val();
					$.blockUI();
					$("#load_img_div").html(' ');
					$("#blog_div").html('');
					$("#msg_div").html('');
					$("#call_count").val('1');
					call_count =1;
					a = parseInt(call_count);
					$("#call_count").val(a+1);
				    load_blog(call_count,search_term);
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
	function load_blog(call_count,search_term)
	{
		    var url=$('#base_url').val();
			a = parseInt(call_count);
			$("#call_count").val(a+1);
			$.ajax(
				{
					url: url+"newsletter/more_data",
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
									var n = element.description.length;
									a = parseInt(n);
									if(a > 190) { var dot ='..'; } else { var dot =''; }
									var length = 190;
									var trimmeddescrition = element.description.substring(0, length)+dot;
									var pic ="<?php echo file_upload_base_url();?>blog/thumb/"+element.picture;
									/*if(UrlExists(pic))
									{
										var pic="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg";
									}*/
									$('#blog_div').append('<div class="row"><div class="col-md-1 text-center"><p><i class="fa fa-camera fa-4x"></i></p><p  style=" " >'+element.created+'</p></div><div class="col-md-5"><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'"><img class="img-responsive img-hover" src="'+pic+'" alt="blog picture"></a></div><div class="col-md-6"><h3><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'">'+element.title+'</a></h3><p>by <a href="javascript:void(0)">'+element.posted_by+'</a></p><p>'+trimmeddescrition+'</p><a href="<?php echo base_url();?>newsletter/newsletterDetail/'+element.id+'" class="btn btn_blue">Read More  <i class="fa fa-angle-right"></i></a></div></div><hr>');
								});
						}
						$.unblockUI();
					}
				});
	}
</script>
