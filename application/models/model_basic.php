<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_basic extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
	}
	public function loggedInUserInfo()
	{
		$user_id=$this->session->userdata('front_user_id');
		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row_array();
	}
	public function loggedInUserInfoById($user_id)
	{
		//$user_id=$this->session->userdata('front_user_id');
		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row_array();
	}
	public function getValue($table_name="",$field_name="",$condition="")
	{
		//echo $field_name;die;
		$query 	= "SELECT
						".$field_name."
					FROM
						".$table_name;
		if($condition <> "")
		{
			$query 	.= " WHERE ".$condition;
		}
		$result = $this->db->query($query);
		//echo $this->db->last_query();die;
		if($result)
		{
			$recordSet 	= $result->row_array();
			if(count($recordSet) > 0)
			{
				return $recordSet[$field_name];
			}
		}
		return false;
	}

	public function getCompanyValue($table_name="",$field_name="",$condition="")
	{
		//echo $field_name;die;
		$query 	= "SELECT
						".$field_name."
					FROM
						".$table_name;
		if($condition <> "")
		{
			$query 	.= " WHERE ".$condition;
		}

		$this->db->select('*',false);
			$this->db->from('users_work');
			$result=$this->db->get()->row();

		if($result)
		{
			return $result;
		}
		return false;
	}

	function getValueArray($table,$getColumn,$conditionArray='',$order_by='',$limit='')
		{
			$this->db->select($getColumn,false);
			$this->db->from($table);
			if($conditionArray!='')
			{
				$this->db->where($conditionArray);
			}
			if($order_by != '')
			{
				$this->db->order_by($order_by[0],$order_by[1]);
			}

			if($limit != '')
			{
				$this->db->limit($limit);
			}

			$result=$this->db->get()->row();
			if(!empty($result))
			{
				return $result->$getColumn;
			}
			else
			{
				return '';
			}
		}
	public function getTimespan($start,$end=null)
	{
		 if ($end == null) { $end = time(); }
		 $seconds = $end - $start;
		 $days = floor($seconds/60/60/24);
		 $hours = $seconds/60/60%24;
		 $mins = $seconds/60%60;
		 $secs = $seconds%60;
		 $duration='';
		 if($days>0)
		 {
		 	$duration .= "$days days ";
		 }
		 else
		 {
			 if($hours>0)
			 {
			 	$duration .= "$hours hours ";
			 }
			 else
			 {
			 	if($mins>0)
			 	{
			 		$duration .= "$mins minutes ";
				}
				else
				{
					if($secs>0) $duration .= "$secs seconds ";
				}
			 }
		 }
		 $duration = trim($duration);
		 if($duration==null) $duration = '0 seconds';
		 $duration	.=	" ago";
		 return $duration;
	}
	function _update($table,$field,$fieldValue,$data)
	{
		$this->db->where($field,$fieldValue);
		return $this->db->update($table,$data);
	}
	function _updateWhere($table,$conditionArr,$data)
	{
		foreach ($conditionArr as $key => $value)
		{
			$this->db->where($key,$value);
		}
		return $this->db->update($table,$data);
	}
	function _insert($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	function _delete($table,$field,$fieldValue)
	{
		$this->db->where($field,$fieldValue);
		return $this->db->delete($table);
	}
	function _deleteWhere($table,$conditionArr)
	{
		foreach ($conditionArr as $key => $value)
		{
			$this->db->where($key,$value);
		}
		return $this->db->delete($table);
	}
	function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
	function getCountWhere($table,$conditionArr)
	{
		$this->db->from($table);
		if(!empty($conditionArr)){
			foreach ($conditionArr as $key => $value)
			{
				$this->db->where($key,$value);
			}
		}
		return $this->db->get()->num_rows();
	}
	function getData($table,$selectStr,$cond,$order='',$limit='',$offset='')
	{
		$this->db->select($selectStr,FALSE)->from($table);
		foreach ($cond as $key => $value)
		{
			$this->db->where($key,$value);
		}
		if($order!='')
		{
			foreach ($order as $key => $value)
			{
				$this->db->order_by($key,$value);
			}
		}
		if($limit!='')
		{
			$this->db->limit($limit,$offset);
		}
		return $this->db->get()->row_array();
	}
	function getAllData($table,$selectStr,$cond,$order='',$limit='',$offset='')
	{
		$this->db->select($selectStr)->from($table);
		if($cond!='')
		{
			foreach ($cond as $key => $value)
			{
				$this->db->where($key,$value);
			}
		}
		if($order!='')
		{
			foreach ($order as $key => $value)
			{
				$this->db->order_by($key,$value);
			}
		}
		if($limit!='')
		{
			$this->db->limit($limit,$offset);
		}
		return $this->db->get()->result_array();
	}
	public function sendMail($data)
	{
		$localhost = array(
		    '127.0.0.1',
		    '::1'
		);
		$this->load->library('email');
 		$config = Array(
 		                /*'charset'=>'utf-8',
 		                'wordwrap'=> TRUE,
 		                'mailtype' => 'html'*/

 		                'mailtype' => 'html',
 		                'priority' => '3',
 		                'charset'  => 'utf-8',
 		                'validate'  => TRUE ,
 		                'newline'   => "\r\n",
 		                'wordwrap' => TRUE

                  			);
	 		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
	 		{
	 		    	$config['protocol']='smtp';
	 		    	$config['smtp_host']='ssl://smtp.googlemail.com';
	 		    	$config['smtp_port']='465';
	 		    	$config['smtp_user']='test.unichronic@gmail.com';
	 		    	$config['smtp_pass']='Uspl@123';
	 		    	$config['mailtype']='html';
	 		}
			$this->email->initialize($config);
			/*if(isset($data['fromEmail']) && $data['fromEmail']!='')
			{
				$fromEmail 	=	$this->getValue($this->db->dbprefix('admin_users'),"email"," `id` = '1' ");
			}*/
			if(!isset($data['fromName']) || $data['fromName'] == '')
			{
				$fromName 	=	'Creosouls Team';
			}
			else
			{
				$fromName=$data['fromName'];
			}
			$this->email->clear(TRUE);
			$this->email->to($data['to']);
			if(isset($data['cc']) && $data['cc'] !='')
			{
				$this->email->cc($data['cc']);
			}
			$this->email->from($data['fromEmail'],$fromName);
			$this->email->subject($data['subject']);
			$this->email->message($data['template']);
/*			$this->email->send();
			echo $this->email->print_debugger();
			pr($data);*/
			 if($this->email->send())
				return true;
			else
				return false;
		}
		public function sendMailToSupport($data)
		{
			/*$localhost = array(
			    '127.0.0.1',
			    '::1'
			);*/
			$this->load->library('email');
	 		$config = Array(
	 		                /*'charset'=>'utf-8',
	 		                'wordwrap'=> TRUE,
	 		                'mailtype' => 'html'*/
	 		                'mailtype' => 'html',
	 		                'priority' => '3',
	 		                'charset'  => 'utf-8',
	 		                'validate'  => TRUE ,
	 		                'newline'   => "\r\n",
	 		                'wordwrap' => TRUE,
	 		                'auth' => TRUE);
		 		
		 	$config['protocol']='smtp';
		 	$config['smtp_host']='ssl://smtp.googlemail.com';
		 	$config['smtp_port']='465';
		 	$config['smtp_user']='creosouls.help@gmail.com';
		 	$config['smtp_pass']='creosupport@123';
		 	$config['mailtype']='html';
		 	
			$this->email->initialize($config);
			
			$fromName 	=	'Creosouls';
			$fromEmail ="creosouls.help@gmail.com";
			$this->email->clear(TRUE);
			$this->email->to($data['to']);
			if(isset($data['cc']) && $data['cc'] !='')
			{
				$this->email->cc($data['cc']);
			}	
			$this->email->from($fromEmail,$fromName);
			$this->email->subject($data['subject']);
			$this->email->message($data['template']);
			$this->email->attach($data['attachment']);
		
			if($this->email->send())
				return true;
			else
				return false;
		}
	public function sendMailWithAttachment($data)
	{
		/*$localhost = array(
		    '127.0.0.1',
		    '::1'
		);
*/
		$this->load->library('email');
		$config = Array(
		              'mailtype' => 'html',
		              'priority' => '3',
		              'charset'  => 'iso-8859-1',
		              'validate'  => TRUE ,
		              'newline'   => "\r\n",
		              'wordwrap' => TRUE
		              );
		if(!in_array($_SERVER['REMOTE_ADDR'], $localhost))
		{
		    	$config['protocol']='smtp';
		    	$config['smtp_host']='ssl://smtp.googlemail.com';
		    	$config['smtp_port']='465';
		    	$config['smtp_user']='test.unichronic@gmail.com';
		    	$config['smtp_pass']='Uspl@12345';
		    	$config['mailtype']='html';
		}

		$this->email->initialize($config);
		$attachment=file_upload_s3_path().'resume/'.$data['attachment'];
		if(isset($data['fromEmail']) && $data['fromEmail']!='')
		{
			$fromEmail 	=	$this->getValue($this->db->dbprefix('admin'),"email"," `id` = '1' ");
		}
		$fromName 	=	'creosouls Team';
		$this->email->clear(TRUE);
		$this->email->to($data['to']);
		if(isset($data['cc']) && $data['cc'] !='')
		{
			$this->email->cc($data['cc']);
		}	
		$this->email->from($fromEmail,$fromName);
		$this->email->subject($data['subject']);
		$this->email->message($data['template']);
		$this->email->attach($attachment);
		 if($this->email->send())
		 {
		 	return true;
		 }
		else
		{
			return false;
		}
	}
	public function fileUpload(&$uploadFileData,$field,$file_name,$path)
	{
		$config['allowed_types'] 	= 'jpg|jpeg|png|bmp';
		$config['upload_path'] 		= $path;
		$config['optional'] 		= true;
		$config['max_size']			= '1024';
		$config['max_width']  		= '00';
		$config['file_name']    	= $file_name;
		//$this->upload->set_config($config);
		$this->upload->initialize($config);
		$r = $this->upload->do_upload($field,true);
		$uploadFileData[$field] = $this->upload->file_name;
		$uploadFileData[$field.'_err'] = $this->upload->display_errors();
		return $r;
	}
	public function thumbnail($file_name='',$folder_name='',$path='',$twidth='',$theight='')
	{
		$tag        = '';
		$Twidth     = $twidth;
		$Theight    = $theight;
		$thumb_file_name  = $file_name;
		$dest       = $path.'/'.$thumb_file_name;
		$src        = $folder_name.$file_name;
		$this->upload->create_thumbnail($dest,$src,$Twidth,$Theight,$tag);
	}
	public function createtThumbnail($file_name='',$folder_name='',$path='',$twidth='',$theight='')
	{
		$newname = $path.$file_name;
		$oldname=$folder_name.$file_name;
		// Dimensions of displayed thumbnail
		$thumbh = 186;
		$thumbw = 280;
		// Dimension of intermediate thumbnail
		$nh = $thumbh;
		$nw = $thumbw;
		$size = getImageSize($oldname);
		$w = $size[0];
		$h = $size[1];
		// Applying calculations to dimensions of the image
		$ratio = $h / $w;
		$nratio = $thumbh / $thumbw;
		if($ratio > $nratio)
		{
		  $x = intval($w * $nh / $h);
		  if ($x < $nw)
		  {
		    $nh = intval($h * $nw / $w);
		  }
		  else
		  {
		    $nw = $x;
		  }
		}
		else
		{
		  $x = intval($h * $nw / $w);
		  if ($x < $nh)
		  {
		    $nw = intval($w * $nh / $h);
		  }
		  else
		  {
		    $nh = $x;
		  }
		}
		// Building the intermediate resized thumbnail
		$resimage = imagecreatefromjpeg($oldname);
		$newimage = imagecreatetruecolor($nw, $nh);  // use alternate function if not installed
		imageCopyResampled($newimage, $resimage,0,0,0,0,$nw, $nh, $w, $h);
		// Making the final cropped thumbnail
		$viewimage = imagecreatetruecolor($thumbw, $thumbh);
		imagecopy($viewimage, $newimage, 0, 0, 0, 0, $nw, $nh);
		// saving
		imagejpeg($viewimage,$newname, 90);
		return true;
	}
	//resize and crop image by center
	function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 100){
	    $imgsize = getimagesize($source_file);
	    $width = $imgsize[0];
	    $height = $imgsize[1];
	    $mime = $imgsize['mime'];
	    switch($mime){
	        case 'image/gif':
	            $image_create = "imagecreatefromgif";
	            $image = "imagegif";
	            break;
	        case 'image/png':
	            $image_create = "imagecreatefrompng";
	            $image = "imagepng";
	            $quality = 9;
	            break;
	        case 'image/jpeg':
	            $image_create = "imagecreatefromjpeg";
	            $image = "imagejpeg";
	            $quality = 100;
	            break;
	        default:
	            return false;
	            break;
	    }
	    $dst_img = imagecreatetruecolor($max_width, $max_height);
	    $src_img = $image_create($source_file);
	    $width_new = $height * $max_width / $max_height;
	    $height_new = $width * $max_height / $max_width;
	    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
	    if($width_new > $width){
	        //cut point by height
	        $h_point = (($height - $height_new) / 2);
	        //copy image
	        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
	    }else{
	        //cut point by width
	        $w_point = (($width - $width_new) / 2);
	        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
	    }
	    $image($dst_img, $dst_dir, $quality);
	    if($dst_img)imagedestroy($dst_img);
	    if($src_img)imagedestroy($src_img);
	    return true;
	}
  	public function ImageCropMaster($max_width, $max_height, $source_file, $dst_dir, $quality = 80,$image_width='',$image_height='')
	{
		include_once APPPATH . "libraries/Zebra_Image.php";
		// create a new instance of the class
		$image = new Zebra_Image();
		// indicate a source image (a GIF, PNG or JPEG file)
		$image->source_path = $source_file;
		// indicate a target image
		// note that there's no extra property to set in order to specify the target
		// image's type -simply by writing '.jpg' as extension will instruct the script
		// to create a 'jpg' file
		$image->target_path = $dst_dir;
		// since in this example we're going to have a jpeg file, let's set the output
		// image's quality
		$image->jpeg_quality = 100;
		// some additional properties that can be set
		// read about them in the documentation
		$image->preserve_aspect_ratio = true;
		$image->enlarge_smaller_images = true;
		$image->preserve_time = true;
		// resize the image to exactly 100x100 pixels by using the "crop from center" method
		// (read more in the overview section or in the documentation)
		//  and if there is an error, check what the error is about
		if($image_width == '' && $image_height=='')
		{
			$size = @getImageSize($source_file);
			$w = $size[0];
			$h = $size[1];
		}
		else
		{
			$w = $image_width;
			$h = $image_height;
		}

		if($w > $max_width || $h > $max_height)
		{
			
			if (!$image->resize($max_width, $max_height, ZEBRA_IMAGE_CROP_CENTER)) {
			    // if there was an error, let's see what the error is about
			    switch ($image->error) {
			        case 1:
			            //echo 'Problem with the image you are trying to upload. Please contact creosouls support @  +91 738773 0642.';die;
			            echo 'Oh, snap! Please upload .PNG version of the same image you are uploading.';die;
			            break;
			        case 2:
			            echo 'Source file is not readable!';
			            break;
			        case 3:
			            echo 'Could not write target file!';
			            break;
			        case 4:
			            echo 'Unsupported source file format!';
			            break;
			        case 5:
			            echo 'Unsupported target file format!';
			            break;
			        case 6:
			            echo 'GD library version does not support target file format!';
			            break;
			        case 7:
			            echo 'GD library is not installed!';
			            break;
			    }
			// if no errors
			} else {
			   return true;
			}
		}
		else
		{
			if (!$image->resize($max_width, $max_height, ZEBRA_IMAGE_BOXED, '#ffffff')) {
			    // if there was an error, let's see what the error is about
			    switch ($image->error) {
			        case 1:
			            //echo 'Problem with the image you are trying to upload. Please contact creosouls support @  +91 738773 0642.';die;
			            echo 'Oh, snap! Please upload .PNG version of the same image you are uploading.';die;
			            break;
			        case 2:
			            echo 'Source file is not readable!';
			            break;
			        case 3:
			            echo 'Could not write target file!';
			            break;
			        case 4:
			            //echo 'Unsupported source file format!';
			        	//echo 'Problem with the image you are trying to upload. Please contact creosouls support @  +91 738773 0642.';die;
			            echo 'Oh, snap! Please upload .PNG version of the same image you are uploading.';die;
			            break;
			        case 5:
			            echo 'Unsupported target file format!';
			            break;
			        case 6:
			            echo 'GD library version does not support target file format!';
			            break;
			        case 7:
			            echo 'GD library is not installed!';
			            break;
			    }
			// if no errors
			} else {
			   return true;
			}
		}
	}
	// Check whether a value has duplicates in the database
	public function has_duplicate($value, $tabletocheck, $fieldtocheck)
	{
	    $this->db->select($fieldtocheck);
	    $this->db->where($fieldtocheck,$value);
	    $result = $this->db->get($tabletocheck);
	    if($result->num_rows() > 0) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	// Check whether the field has any reference from other table
	// Normally to check before delete a value that is a foreign key in another table
	public function has_child($value, $tabletocheck, $fieldtocheck)
	{
	    $this->db->select($fieldtocheck);
	    $this->db->where($fieldtocheck,$value);
	    $result = $this->db->get($tabletocheck);
	    if($result->num_rows() > 0) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	// Return an array to use as reference or dropdown selection
	public function get_ref($table,$key,$value,$dropdown=false)
	{
	    $this->db->from($table);
	    $this->db->order_by($value);
	    $result = $this->db->get();
	    $array = array();
	    if ($dropdown)
	        $array = array("" => "Please Select");
	    if($result->num_rows() > 0) {
	        foreach($result->result_array() as $row) {
	        $array[$row[$key]] = $row[$value];
	        }
	    }
	    return $array;
	}
	// Return all records in the table
	public function get_all($table)
	{
	    $q = $this->db->get($table);
	    if($q->num_rows() > 0)
	    {
	        return $q->result();
	    }
	    return array();
	}
	public function get_where($table,$condition)
	{
		return $this->db->select('*')->from($table)->where($condition)->get()->row_array();
	}
	public function updateLogin($loginId)
	{
		$this->db->where('loginId',$loginId);
		return $this->db->update('user_login_details',array('logIn_time_current'=>date('Y-m-d h:i:s')));
	}
	public function updateLogOut($loginId)
	{
		$this->db->where('loginId',$loginId);
		return $this->db->update('user_login_details',array('logOut_time'=>date('Y-m-d h:i:s'),'status'=>0));
	}
	public function insertActivity($pageName,$urlName='',$project_id='',$activityName)
	{
		$userId = $this->session->userdata('front_user_id');
		$userName = $this->session->userdata('logged_user_name');
		if($project_id!='')
		{
			$projectName = $this->getValue('project_master','projectName'," `id` = '".$project_id."'");
		}
		else{
			$projectName = '';
		}
		$userActivity = array(
					'userId'		=> $userId,
					'userName'		=> $userName,
					'pageName'		=> $pageName,
					'urlName'		=> $urlName,
					'projectId'		=> $project_id,
					'activityName'	=> $activityName,
					'description'	=> $userName.' '.$activityName.' '.$projectName,
					'ip_address'	=> $this->input->ip_address(),
					'activityTime'	=> date('Y-m-d h:i:s')
		);
		if($this->db->insert('user_activity_master',$userActivity))
		{
			return true;
		}
		else{
			return false;
		}
	}
	public function userProfileMeter($userId)
	{
		$profileCompletion=0;
		$user_profile = $this->get_where('users',array("id"=>$userId));
		$educationData = $this->get_where('users_education',array("user_id"=>$userId));
		$workData = $this->get_where('users_work',array("user_id"=>$userId));
		$skillData = $this->get_where('users_skills',array("user_id"=>$userId));
		$socialData = $this->get_where('social_link',array("user_id"=>$userId));
		/*print_r($socialData);*/
		if($user_profile['firstName']!='' && $user_profile['lastName']!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile['city']!='' && $user_profile['country']!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile['profession']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile['profileImage']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile['about_me']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if(!empty($skillData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		/*echo $profileCompletion;*/
		if(!empty($workData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		if(!empty($educationData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		/*echo $profileCompletion;*/
		if(isset($socialData['facebook']) && $socialData['facebook']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['twitter']) && $socialData['twitter']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['google']) && $socialData['google']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['pinterest']) && $socialData['pinterest']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['instagram']) && $socialData['instagram']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['linkedin']) && $socialData['linkedin']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		return $profileCompletion;
	}
	public function getAllInstitute(){
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function getAllFeedbackInstanceForAllInstitute($endDate){
		$this->db->select('feedback_instance.*,institute_master.instituteName,users.email');
		$this->db->from('feedback_instance');
		$this->db->join('institute_master','institute_master.id = feedback_instance.institute_id');
		$this->db->join('users','institute_master.adminId = users.id');
		$this->db->where('feedback_instance.status',1);
		$this->db->where('end_session <= ', $endDate);
		$this->db->where('end_session >= ', date("Y-m-d"));
		return $this->db->get()->result_array();
	}
	public function getFeedbackUserId($instanceId){
		$this->db->select('user_id,institute_id');
		$this->db->from('institutefeedback');
		$this->db->where('instance_id',$instanceId);
		return $this->db->get()->result_array();
	}
	public function getUserIdNotFeedback($userIds,$instituteId){
		$this->db->select('id,firstName,lastName,email,instituteId');
		$this->db->from('users');
		if(!empty($userIds)){
			$this->db->where_not_in('id',$userIds);
		}
		$this->db->where('instituteId',$instituteId);
		return $this->db->get()->result_array();
	}

	public function getAllNotificationData()
	{
		return $this->db->select('A.*,B.status')->from('header_notification_master as A')->join('header_notification_user_relation as B','A.id=B.notification_id')->where('B.user_id',$this->session->userdata('front_user_id'))->order_by('B.status','asc')->order_by('A.created','desc')->get()->result_array();
	}

	public function getHoadminInstitutes($hoadmin_id)
	{
		//$hoadmin_id=$this->session->userdata('admin_id');
		$mul_array=$this->db->select('institute_id')->from('hoadmin_institute_relation')->where('hoadmin_id',$hoadmin_id)->get()->result_array();
		$institutes=array();
		if(!empty($mul_array))
		{
			foreach ($mul_array as $ins) 
			{
				$institutes[]=$ins['institute_id'];
			}
		}
		return $institutes;
	}

    /**
	 * [getAllData description]
	 * @return [type] [description]
	 */
	public function getAllPeopleData()
	{
		$this->db->select('A.id as userId,A.instituteId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS project_count,project_master.id AS projectId');
		$this->db->from('users as A');
	    $this->db->where('A.status',1);
	    $this->db->limit(12);
		$this->db->order_by('project_count','desc');
       	if($this->session->userdata('adv_category_id') && $this->session->userdata('adv_category_id')!='' )
    	{
    		$this->db->where('project_master.categoryId',$this->session->userdata('adv_category_id'));
        }
	    if($this->session->userdata('adv_attribute_id') && $this->session->userdata('adv_attribute_id')!='' )
		{ 
			$this->db->where('project_attribute_relation.attributeId',$this->session->userdata('adv_attribute_id'));
	    }
	        
	    if($this->session->userdata('adv_attri_value_id') && $this->session->userdata('adv_attri_value_id')!='')
		{
			$this->db->where('project_attribute_relation.attributeValueId',$this->session->userdata('adv_attri_value_id'));
	    }
	
	    if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
		{
			if(strpos($this->session->userdata('adv_rating'),'+') !== false)
			{
				  $arr = explode("+",$this->session->userdata('adv_rating'));
				  $this->db->where('project_rating.avg_project_rating >=',$arr[0]);
			}
			else
			{
				$this->db->where('project_rating.avg_project_rating',$this->session->userdata('adv_rating'));
			}
	    }

    	if('A.instituteId' == $this->session->userdata('user_institute_id'))
    	{	    				
    		$where = "(( project_master.status=1) OR ( project_master.status=3))";
        	$this->db->where($where);	    			
    	}
    	else
    	{	    				
    		$this->db->where('project_master.status',1);
    	}
	    $this->db->join('project_master', 'project_master.userId = A.id', 'left');
	    $this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
	    $this->db->join('project_rating', 'project_rating.projectId = project_master.id', 'left');
		//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		//$this->db->group_by('project_master.id');
		$this->db->group_by('A.id');
	    $allData = $this->db->get()->result_array();	
	    return $allData;
	   // print_r($allData);die;
	    /*$dat = $this->db->get()->result_array();
        echo $this->db->last_query();
        print_r($dat);die;*/
	} 

	public function add($table,$data)
	{		
		$this->db->insert($table,$data);
		return $this->db->insert_id();		
	}

	
	public function sendNotification($userId,$msg)
	{ 
		//	define( 'API_ACCESS_KEY', 'AAAAlqhHLn0:APA91bF4yrGgfyVHMiMRMfQ7eENB18X1HZIHrS6QiQGNrgkN4oOxumJX4CQi8KlCbiRe2aiCfKtr5iSQgjwJB4xxCISutkFXhi3p2ORe1gtKsqs4eU2X-Jzt-AmGan705Dq0mXKl2sZ6' );
			$API_ACCESS_KEY= 'AAAAlqhHLn0:APA91bF4yrGgfyVHMiMRMfQ7eENB18X1HZIHrS6QiQGNrgkN4oOxumJX4CQi8KlCbiRe2aiCfKtr5iSQgjwJB4xxCISutkFXhi3p2ORe1gtKsqs4eU2X-Jzt-AmGan705Dq0mXKl2sZ6';
		$deviceId = $this->model_basic->getValue('users','deviceId',"`id` = '".$userId."'");
		if(isset($deviceId)&&$deviceId!='')
		{
		  $gcmToken = $this->model_basic->getValue('gcm','gcmToken',"`deviceId` = '".$deviceId."'");
			if(isset($gcmToken)&& $gcmToken!='')
			{		
				$registrationIds = array($gcmToken);
				$fields = array
				(
					//'to'		=> $registrationIds,// at a time for single user
					'registration_ids'		=> $registrationIds,// at a time for multiple users
					'data'	=> $msg
				);		
		
				$headers = array
						(
							'Authorization: key=' . $API_ACCESS_KEY,
							'Content-Type: application/json'
						);
				#Send Reponse To FireBase Server	
				$ch = curl_init();
				curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
				curl_setopt( $ch,CURLOPT_POST, true );
				curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
				$result = curl_exec($ch );
				curl_close( $ch );
				#Echo Result Of FireBase Server
			/*	print_r($msg);
				echo $result;*/
			}
		}
	}

	public function getStudentslist($searchTerm='')
	{
		$this->db->select('*');
		$this->db->from('institute_csv_users');
		$this->db->join('users', 'users.email = institute_csv_users.email');
		$this->db->where('studentId',$searchTerm);


		return $this->db->get()->result_array();
	}
	public function getStudenUserid($studentID){
			$this->db->select('institute_csv_users.id as instituteId,users.id as user_id');
		$this->db->from('users');
		$this->db->where('institute_csv_users.studentId',$studentID);
		$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
	   	return $this->db->get()->result_array();
	}

	public function getTeamStatus($loggedinUid){

			$this->db->select('cmpt_teams.*');
		$this->db->from('team_competitions');
				$this->db->join('institute_csv_users', 'institute_csv_users.studentId = team_competitions.team_member_student_id');

						$this->db->join('cmpt_teams', 'cmpt_teams.id = team_competitions.team_id');

						$this->db->join('users', 'users.email = institute_csv_users.email');

		$this->db->where('users.id',$loggedinUid);
	   	return $this->db->get()->result_array();

	}
	public function getAuthUserAptech($aptechId){
    

		$data = array(
            'LoginID'      => $aptechId
    	);

    	$data_string = json_encode($data);

    	$curl = curl_init('https://api.aptrack.asia/Creosoul/Api/UserVarification');

    	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

    	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    		'ApiKey: GRDFEYKWEFHIGDAB',
    		'Content-Type: application/json',
    		'Content-Length: ' . strlen($data_string))
    	);

    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data

    	// Send the request
    	$result = curl_exec($curl);
    	curl_close($curl);
    	return $result;
		/*$resultResponse = json_decode($result,true);
    		foreach ($resultResponse as $character) {
			echo json_encode($character['Data']). '<br>';exit();
		}*/

	}
}