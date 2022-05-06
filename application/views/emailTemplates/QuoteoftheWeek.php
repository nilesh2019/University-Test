<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Quote of the Week</title>
<style type="text/css">
</style>
</head>
<body>
<div>
  <center>
    <table cellspacing="0" cellpadding="0" border="0" style="text-align:left; width:600px">
      <tbody>
        <tr style="background:#222835;">
          <td>
          	<table cellspacing="0" cellpadding="0" border="0" style="width:600px;">
            	<tbody>
                	<tr>
                    	<td style="padding-left:10px">
                        	<a href="http://www.creosouls.com/"><img src="<?php echo base_url();?>assets/email/img/logo.png" alt=""></a>
                        </td>
                        <td style="text-align:right; padding-right:15px;">
                        	<a href="https://www.facebook.com/www.creosouls.com/info/?tab=page_info&view" target="_blank">
                            	<img src="<?php echo base_url();?>assets/email/img/fb.png" alt=""></a>
                            <a href="https://twitter.com/creosoulsns" target="_blank">
                            	<img src="<?php echo base_url();?>assets/email/img/twt.png" alt=""></a>
                            <a href="https://plus.google.com/113448733927859878502/posts" target="_blank">
                            	<img src="<?php echo base_url();?>assets/email/img/google.png" alt=""></a>
                        </td>
                    </tr>
                </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td valign="top">
          	<a href="<?php echo base_url();?>job" target="_blank">
            	<img src="<?php echo base_url();?>assets/email/img/banner1.png" alt=""></a>
          </td>
        </tr>
        <tr class="separated">
        	<td style="text-align:center; font-size:20px; border-bottom: 1px solid #229acc;	border-top: 1px solid #229acc; margin: 15px 15px 0 15px !important;	display:block; padding:15px 0; line-height:14px; font-family:Verdana, Geneva, sans-serif">See what is HOT on creosouls!</td>
        </tr>
        <tr>
        	<td>
            	<table cellspacing="0" cellpadding="0" border="0" style="width:600px; font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px; text-align:center">
                	<tbody>
                    	<tr>
                        	<td style="padding:15px 15px 15px 15px">
                            	<a href="<?php echo base_url();?>" target="_blank" style="color:#000; text-decoration:none;">
                                	<img style="width:100%;" src="<?php echo base_url();?>assets/email/img/click1.png" alt="">
                                </a>
                            </td>
                            <td style="padding:15px 15px 15px 0">
                            	<a href="<?php echo base_url();?>" target="_blank">
                                	<img style="width:100%;" src="<?php echo base_url();?>assets/email/img/click2.png" alt="">
                                </a>
                            </td>
                            <td style="padding:15px 15px 15px 0">
                            	<a href="<?php echo base_url();?>" target="_blank">
                                	<img style="width:100%;" src="<?php echo base_url();?>assets/email/img/watercolor.png" alt="">
                                </a>
                            </td>
                            <td style="padding:15px 15px 15px 0">
                            	<a href="<?php echo base_url();?>" target="_blank">
                                	<img style="width:100%;" src="<?php echo base_url();?>assets/email/img/avatar.png" alt="">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="separated">
        	<td style="text-align:center; font-size:20px; line-height:14px; font-family:Verdana, Geneva, sans-serif; border-bottom: 1px solid #229acc; border-top: 1px solid #229acc;	margin: 0 15px !important;	display:block;	padding:15px 0;">What’s #Trending Now</td>
        </tr>
        <tr>
        	<td style=" font-size:14px; padding:15px; font-family:Verdana, Geneva, sans-serif">
                <a href="http://bit.ly/1krRhoc" target="_blank" style="color:#000;"> Birds painted on unfolded pharmaceutical boxes </a> <br><br>
                <a href="http://bit.ly/1RQOIKX" target="_blank" style="color:#000;"> Techie’s Art Show in Pune till 3rd January </a> <br><br>
                <a href="http://bbc.in/1QX7yQQ" target="_blank" style="color:#000;"> Tips on photography with your smart phone </a> <br><br>
            	<a href="http://bit.ly/1Ok1Jue" target="_blank" style="color:#000;"> Pizza restaurant in New Delhi an innovative mixture of architecture & design </a><br><br>
                <a href="http://on.wsj.com/1QYNVHP" target="_blank" style="color:#000;">Artists to look out for in 2016 </a><br>
            </td>
        </tr>
        <tr class="separated">
        	<td style="text-align:center; font-size:20px; margin-top:15px; line-height:14px; font-family:Verdana, Geneva, sans-serif; border-bottom: 1px solid #229acc; border-top: 1px solid #229acc; margin: 0 15px !important;	display:block; padding:15px 0;">Quote of the Week</td>
        </tr>
        <tr>
        <!-- 	<td style=" font-size:14px; padding:15px; font-family:Verdana, Geneva, sans-serif; text-align:center;">
            	"Art enables us to find ourselves and lose ourselves at the same time."<br>
<a href="https://www.facebook.com/" target="_blank">Click to share on Facebook</a>
            </td> -->
        </tr>
        <tr>
        	<td valign="top">
                	<a style="display:flex" href="<?php echo base_url();?>people" target="_blank">
                    	<img src="<?php echo base_url();?>assets/email/img/people.png" alt="">
                    </a>
            </td>
        </tr>
      </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" style="text-align:center; background-color:#222835; color:#fff; font-family:Verdana!important;font-size:10px!important; border:1px solid #000000; padding:8px; width:600px">
    	<tbody>
        	<tr>
            	<td>
                    
                    <?php 
                    $this->CI =& get_instance();
                    $this->CI->load->model('model_basic');
                    $emailFrom = $this->CI->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));   
                    ?>
                	Awakening creativity; we hope our emails do much more than that, if you still prefer to not receive future emails you can <a style="text-decoration:none; color:#00b4ff" href="mailto:<?php echo $emailFrom;?>?Subject=Unsubscribe%20me" target="_top"> unsubscribe </a> here.<br><br>
    &copy; Creosouls 2018
                </td>
            </tr>
        </tbody>
    </table>
  </center>
</div>
</body>
</html>
