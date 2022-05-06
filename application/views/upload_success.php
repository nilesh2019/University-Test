<?php
echo '{"name":"'.$upload_data['file_name'].'","type":"'.$upload_data['file_type'].'","size":"'.$upload_data['file_size'].'"}';
?>
<br/><br/><br/>
<a href= "<?php echo file_upload_base_url().$upload_data['file_name'] ?>" ><img style="float:left; padding: 20px;" alt="image" width="80" src="<?php echo file_upload_base_url().$upload_data['file_name']/*or set to thumbnail image*/ ?>"/></a><?php echo '<br/>name: ' .$upload_data['file_name'] .'<br/>size: ' .$upload_data['file_size'] .' k' ?> <!-- <br/><a href="upload/delete <?php echo $upload_data['file_name']?>"  >DELETE</a>-->
