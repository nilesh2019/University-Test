<?php $this->load->view('template/header');
//print_r($blog);die;?>
<style>
.navbar {
    background-color:rgb(0,0,0);
	}
	.vd_red {
	    color: #f85d2c !important;
	    float: left;
	}
</style>
	<div class="middle blog_dtl">
  	<div class="container">
    	<!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
           		<div class="border_btm botm">
                    <h1><a style="color: #414141;" href="#" ><?php echo $blog[0]['title'];?></a>
                        <small>by <a href="javascript:void(0)" style="cursor: auto"> <?php echo $blog[0]['posted_by'];?></a></small>
                    </h1>
                	<a class="pull-right" href="<?php echo base_url();?>newsletter"><i class="fa fa-angle-double-left"></i>  Back </a>
                </div>
               </div>
        </div>
        <!-- /.row -->
        <!-- Content Row -->
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-9">
                <!-- Blog Post -->
                <!--<hr>-->
                <!-- Date/Time -->
                <p><a style="color: #414141;" href="#" ><i class="fa fa-clock-o"></i> Posted on <?php echo ucfirst(date("F d, Y - H:i a", strtotime($blog[0]['created']))) ;?></a></p>

	                <div class="dropdown pull-right" style=" margin-top: -27px;">
	                	<img class="dropdown-toggle" alt="image" data-toggle="dropdown" src="<?php echo base_url();?>assets/images/shr.png"  style="cursor: pointer;">
	                	
	                	<ul class="dropdown-menu">
	                		<li>
	                			<a href="javascript:void(0);" onclick="return sharelink(1);" >
	                				Facebook
	                			</a>
	                		</li>
	                		<li>
	                			<a href="javascript:void(0);" onclick="return sharelink(2);" >
	                				Twitter
	                			</a>
	                		</li>
	                	</ul>
	                </div>
                

                <hr>
                <!-- Preview Image -->
                <img class="img-responsive" src="<?php echo file_upload_base_url();?>blog/<?php echo $blog[0]['picture'];?>" alt="image">
             <!--    <div class="dropdown pull-right">
                	<img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url();?>assets/images/shr.png"  style="cursor: pointer;">
                	
                	<ul class="dropdown-menu">
                		<li>
                			<a href="javascript:void(0);" onclick="return sharelink(1);" >
                				Facebook
                			</a>
                		</li>
                		<li>
                			<a href="javascript:void(0);" onclick="return sharelink(2);" >
                				Twitter
                			</a>
                		</li>
                	</ul>
                </div> -->
                <hr>
                <!-- Post Content -->
               <!-- <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>-->
                <p><a style="color: #414141;" href="#" ><?php echo $blog[0]['description'];?></a></p>
                <hr>
                <!-- Blog Comments -->
                <!-- Comments Form -->

               <?php
                     $CI =& get_instance();
                   if($this->session->userdata('front_user_id') !='')
                     {
						$CI =& get_instance();
						$user=$CI->model_basic->loggedInUserInfo();
					  ?>

                <div class="well">
                    <h4><a style="color: #414141;" href="#" >Leave a Comment:</a></h4>
                    <form action="javascript:void(0)" method="POST">
                        <div class="form-group">
                            <textarea class="form-control" id="comment" name="comment"  rows="3"><?php echo set_value('comment');?></textarea>
                            <input type="hidden" id="blogId" name="blogId" value="<?php echo $blog[0]['id']?>">
                            <span id="comment_error" class="vd_red"  style="margin-left: 0px; position: absolute; "></span>
                        </div>
                        <button type="submit" id="submit_comment" class="btn btn_blue">Submit</button>
                    </form>
                </div>
                <hr>
				<?php } ?>
                <!-- Posted Comments -->
                <!-- Comment -->
              <div id="all_comment_div">
             <?php if(!empty($comment))
					 {
				      foreach ($comment as $value)
				      {
						?>
                        <div class="media">
		                    <a class="pull-left" href="<?php echo base_url();?>user/userDetail/<?php echo $value['userId'];?>">
		                    <?php
								if(file_exists(file_upload_s3_path().'users/thumbs/'.$value['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$value['profileImage']) > 0)
								{
									?>
							    <img src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $value['profileImage']?>" alt="image" class="media-object">
									<?php
								}
								else
								{
									?>
									<img src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="image" class="media-object">
									<?php
								} ?>

		                    </a>
		                    <div class="media-body">
		                        <h4 class="media-heading"><?php echo $value['firstName'].' '.$value['lastName'];?>
		                            <small><?php echo ucfirst(date("F d, Y H:i a", strtotime($value['created']))) ;?></small>
		                        </h4>
		                       <?php echo $value['comment'];?>
		                    </div>
		                </div>

		             <?php }
		                } ?>
		        </div>
                <!-- Comment -->



           </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4><a style="color: #414141;" href="#" >Newsletter Search</a></h4>
                   <form action="<?php echo base_url();?>newsletter" onsubmit="return validateForm();" method="POST">
                    <div class="input-group">
                        <input name="search" id="search"  type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                     <div class="input-group">
                     	<span id="search_error" class="vd_red"></span>
                     </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                       <!-- Blog Categories Well -->
                <div class="well">
                    <h4><a style="color: #414141;" href="#" >Recent Newsletters</a></h4>
                    <div class="row" style="margin:0">
                    <?php  
                        $CI->load->model('blog_model');
                        $resent = $CI->blog_model->getResentBlog($this->uri->segment(3));

                        if(!empty($resent))
                        {  ?>
                        	<div class="col-lg-12">
                        		<ul style="list-style: inherit">

                        <?php   foreach($resent as $row)
                           { ?>		

				<li><a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>"><?php echo $row['title'];?></a>
				</li>			

                 <?php  }  /*     $i=1;
                           foreach($resent as $row)
                           {
                           	 if($i==1)
                           	  {?>
                              <div class="col-lg-12">
	                            <ul class="list-unstyled">
	                            <?php } ?>

	                                <li><a href="<?php echo base_url();?>newsletter/newsletterDetail/<?php echo $row['id'];?>"><?php echo $row['title'];?></a>
	                                </li>

	                        <?php if($i==1)
                           	      { ?>
		                           </ul>
		                           </div>

		                           <br/>
		                    <?php }  $i++;

	                        if($i==5)
                       	      {
                       	      	 $i=1;
                       	      }
                          }*/
                        } ?>

                        	</ul>
                        </div>
                        <br/>


                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>



<?php $this->load->view('template/footer');?>
<script>
	function sharelink(social)
	{
		if(social==1)
		{
			window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url();?>', '_blank');
		}
		else
		{
			window.open('https://twitter.com/share?url=<?php echo current_url();?>', '_blank');
		}
	}
</script>
<script>
	   $('#submit_comment').on('click',function(e)
		{
			var postUrl = "<?php echo base_url();?>newsletter/submitComment";
			var blogId = $('#blogId').val();
			var comment = $('#comment').val();


			ch=0;
			if(comment=='')
			{
				$('#comment_error').text('Comment is required');
				ch++;
			}
			else
			{
				$('#comment_error').text('');
			}


			if(ch==0)
			{
			  $('#submit_comment').attr('disable','disable');
			  $.ajax({
						url: postUrl,
						data:
						{
							comment:comment,blogId:blogId
						},
						type: "POST",
						success:function(html)
						{
							//alert(html);
							if(html=='true')
							{
								$('#comment').val('');
								$('#all_comment_div').load("<?php echo current_url();?> #all_comment_div");
								var priority = 'success';
								var title    = 'Success';
								var message  = 'Comment Posted successfully.';
								$.toaster({ priority : priority, title : title, message : message });
								$('#submit_comment').removeAttr('disable');
							}
							else
							{
								$('#all_comment_div').load("<?php echo current_url();?> #all_comment_div");
								var priority = 'danger';
								var title    = 'Error';
								var message  = 'Comment Post failed.';
								$.toaster({ priority : priority, title : title, message : message });
								 $('#submit_comment').removeAttr('disable');
							}
						}
					})
			}




		});



		 function validateForm()
		 {
			if($( "input[name='search']" ).val() == "")
			  {
			    $("#search_error").text( "Search Field Requird" );
			    return false;
			  }
			  else
			  {
			  	 $("#search_error").text("");
			  	 return true;
			  }
		 }

</script>

