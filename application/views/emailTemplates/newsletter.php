<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>index</title>
<style type="text/css">
	@media only screen and (max-width: 480px) {
		.abc img {
			height: 140px !important;
			
		}
		
	}
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
                        	<a href="http://www.creosouls.com/" target="_blank"><img style="width:50%;" src="<?php echo base_url() ?>assets/img/email_pic/logo.png" alt=""></a>
                        </td>
                        <td style="text-align:right; padding-right:15px;">
                        	<a href="https://www.facebook.com/creosouls.com/info/?tab=page_info&view" target="_blank">
                            	<img src="<?php echo base_url() ?>assets/img/email_pic/fb44.png" alt=""></a>
                            <a href="https://twitter.com/creosoulsns" target="_blank">
                            	<img src="<?php echo base_url() ?>assets/img/email_pic/twt.png" alt=""></a>
                            <a href="https://plus.google.com/113448733927859878502/posts" target="_blank">
                            	<img src="<?php echo base_url() ?>assets/img/email_pic/google.png" alt=""></a>
                        </td>
                    </tr>
                </tbody>
            </table>
          </td>
        </tr>
        
       <tr>
			<td style="padding-top:15px;">
				<img src="<?php echo base_url() ?>assets/img/email_pic/top_naming.png">
			</td>
       </tr>
        <tr>
        	<td>
            	<table cellspacing="0" cellpadding="0" border="0" style="width:600px; font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px; text-align:center">
                	<tbody>
                    	<tr>
                        	<td class="abc" style="padding:15px 15px 15px 0px; width:180px; height:180px;">
                            	<a href="http://www.creosouls.com/project/projectDetail/527/453" target="_blank" style="color:#000; text-decoration:none;">
                                	<img style="width:100%; height:180px" src="<?php echo base_url() ?>assets/img/email_pic/girl.jpg" alt="">
                                </a>
                                <p>Illustration by Pooja B </p>                     
                            </td>
                            <td class="abc" style="padding:15px 15px 15px 0px; width:180px; height:180px;">
                            	<a href="http://www.creosouls.com/project/projectDetail/543/431" target="_blank">
                                	<img style="width:100%; height:180px" src="<?php echo base_url() ?>assets/img/email_pic/img.jpg" alt="">
                                </a>
                                <p>Architecture by Santosh P</p> 
                            </td>
                            
                            <td class="abc" style="padding:15px 0px 15px 0px; width:180px; height:180px;">
                            	<a href="http://www.creosouls.com/project/projectDetail/523/450" target="_blank">
                                	<img style="width:100%; height:180px" src="<?php echo base_url() ?>assets/img/email_pic/GraphicDesign.jpg" alt="">
                                </a>
                                <p>Gaming work by Ajay </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
		<tr>
			<td>
				<img src="<?php echo base_url() ?>assets/img/email_pic/tranding.png">
			</td>
       </tr>
        <tr>
        	<td style=" font-size:14px; padding:15px 15px 0px 15px; font-family:Verdana, Geneva, sans-serif">
                <a href="http://www.animationxpress.com/index.php/video-gallery/perspectives-on-indian-animation-with-tehzeeb-khurana" target="_blank" style="color:#0048fe;"> Perspectives on Indian Animation with TehzeebKhurana  (Founder of Toon Club)  </a> <br><br>
  
                <a href="http://www.fastcodesign.com/3057698/this-architect-is-pioneering-unthinkably-complex-structures-with-lego/1" target="_blank" style="color:#0048fe;"> This Architect Builds Complex Structures with Legos </a> <br><br>
  
                <a href="http://www.whatshot.in/pune/lesser-known-cultural-hotspots-c-1930" target="_blank" style="color:#0048fe;">Lesser known cultural hotspots in Pune</a> <br><br>
                <a href="http://www.dezeen.com/2016/02/01/david-chipperfield-mughal-museum-agra-india-taj-mahal-work-begins/" target="_blank" style="color:#0048fe;"> Mughal Museum Under Constructions Besides the Taj Mahal. </a> <br><br>
            </td>
        </tr>
        <tr>
			<td style="padding-bottom:15px;">
				<img src="<?php echo base_url() ?>assets/img/email_pic/gang.png">
			</td>
       </tr>
        
        <tr>
        	<td valign="top">
                	<a style="display:flex" href="http://www.creosouls.com/people" target="_blank">
                    	<img src="<?php echo base_url() ?>assets/img/email_pic/photos2.png" alt="">
                    </a>
            </td>
        </tr>
        <tr>
			<td style="padding:15px 0 0px;">
				<img src="<?php echo base_url() ?>assets/img/email_pic/job.png">
			</td>
       </tr>
        <tr>
          <td valign="top">
          	<a href="http://www.creosouls.com/job" target="_blank">
            	<img src="<?php echo base_url() ?>assets/img/email_pic/jobongalilia1.jpg" alt=""></a>
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
    &copy; creosouls 2018  
                </td>
            </tr>
        </tbody>
    </table>
  </center>
  
</div>
</body>
</html>
