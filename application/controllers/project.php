<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
        $this->load->model('modelbasic');
		$this->load->model('model_basic');
		$this->load->model('project_model');
        $this->load->model('competition_model');
		$this->load->library('form_validation');
		$this->load->library('image_lib');
	}
	public function add_project()
	{
		if(isset($_POST) && isset($_POST['projectName']) && $_POST['projectName']!='' && isset($_POST['project_category']) && $_POST['project_category']!='' && isset($_POST['projectType']) && $_POST['projectType']!='' && isset($_POST['projectStatus']) && $_POST['projectStatus']!='')
		{
			$projectName     = $_POST['projectName'];
			$basicInfo       = $_POST['basicInfo'];
			$categoryId      = $_POST['project_category'];
			$projectType     = $_POST['projectType'];
			$requiresFunding = 0;
			$socialFeatures  = $_POST['socialFeatures'];
			$projectStatus   = $_POST['projectStatus'];
			$cover_pic   	 = $_POST['cover_pic'];
			$keyword   		 = $_POST['keyword'];
			$thought   		 = $_POST['thought'];
			$copyright   	 = $_POST['copyright'];
		//	$showreel        =$_POST['showreel'];
			$projectPageName = $this->generateProjectPageName($projectName);
			if(empty($_POST['cover_pic'])){
				$cover_pic = 1;
			}else{
				$cover_pic  = $_POST['cover_pic'];
			}
			if(empty($_POST['image'])){
				$withoutCover = 0;
			}else{
				$withoutCover = 1;
			}
	   	  	if(!empty($_POST['videoLink']))
			{
				//$videoLinkArr = explode("watch?v=",$_POST['videoLink']);
				//$videoLink1    = explode("&feature=youtu.b", $videoLinkArr[1]);
				//$videoLink    = $videoLink1[0];
				$url = $_POST['videoLink'];
				$key = 'watch?v='; 
           		if (strpos($url, $key) == TRUE) { 
           	    	$videoLinkArr = explode("watch?v=",$url);
           	    	$videoLink    = $videoLinkArr[1];
           	  
           		}else { 
           	    	$videoLinkArr = explode("youtu.be/",$url);
           	    	$videoLink    = $videoLinkArr[1];
           		}
			}
			else
			{
				$videoLink = '';
			}
			if(isset($_POST['team']) && !empty($_POST['team']))
			{
				$isTeam=1;
			}
			else
			{
				$isTeam=0;
			}
			if(!empty($_POST['projectTeamMem']))
			{
				$projectTeamMem = $_POST['projectTeamMem'];
						
			}
			else
			{
				$projectTeamMem = '';
			}
			if(isset($_POST['showreel']) && !empty($_POST['showreel']))
			{
				$showreel=1;
			}
			else
			{
				$showreel=0;
			}
			if(isset($_POST['projectFileLink']))
			{
				$fileLink=$_POST['projectFileLink'];
			}
			else
			{
				$fileLink = '';
			}

			$data     = array('projectName'=>$projectName,'projectPageName'=>$projectPageName,'basicInfo'=>$basicInfo,'categoryId'=>$categoryId,'projectType'=>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures' =>$socialFeatures,'projectStatus'=>$projectStatus,'keyword'=>$keyword,'thought'=>$thought,'created'=>date('Y-m-d H:i:s'),'userId'=>$this->session->userdata('front_user_id'),'status'=>2,'copyright'=>$copyright,'videoLink'=>$videoLink,'withoutCover'=>$withoutCover,'showreel'=>$showreel,"uploadFrom"=>'Web','isTeam'=>$isTeam,'team_member'=>$projectTeamMem,'file_link'=>$fileLink);
			//$data     = array('projectName'=>$projectName,'projectPageName'=>$projectPageName,'basicInfo'=>$basicInfo,'categoryId'=>$categoryId,'projectType'=>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures' =>$socialFeatures,'projectStatus'=>$projectStatus,'keyword'=>$keyword,'thought'=>$thought,'created'=>date('Y-m-d H:i:s'),'userId'=>$this->session->userdata('front_user_id'),'status'=>2,'copyright'=>$copyright,'videoLink'=>$videoLink);
			

			if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
			{
				$data['competitionId'] = $_POST['Save_Competition_Id'];
				$data['view_status']='N';				
			}
			else
			{
				$data['view_status']='Y';
			}
 
			if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')
			{ 
				$check_assig_user_relation = $this->db->select('*')->from('user_assignment_relation')->where('assignment_id',$_POST['Save_Assignment_Id'])->where('user_id',$this->session->userdata('front_user_id'))->get()->row_array();						
			}

			if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
			{
				$data['assignmentId'] = $_POST['Save_Assignment_Id'];
				$data['assignment_status'] = 1 ;
			}		

			if(isset($_POST['Save_interview_Assignment_Id']) && $_POST['Save_interview_Assignment_Id']!='')
			{
				$this->load->model('job_model');
				$jobId =$this->model_basic->getValue('interview_assignment',"jobId"," `id` = '".$_POST['Save_interview_Assignment_Id']."' ");
				$this->job_model->_update_status("job_user_relation",$this->session->userdata('front_user_id'),$jobId,array('apply_status'=>19));			
				$data['interview_assignment_id'] = $_POST['Save_interview_Assignment_Id'];
				//$data['interview_assignment_status'] = 1 ;
			}
			$competition_categoryproject = $this->competition_model->checkCompetitionCategoryProjectExist( $_POST['Save_Competition_Id'],$categoryId);
			
			
			if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
			{
			if(empty($competition_categoryproject)){
				$projectId = $this->project_model->add_project($data);
			if($projectId > 0)
			{
			  	$title     = $this->model_basic->getValue($this->db->dbprefix('project_master'),"projectName"," `id` = '".$projectId."' ");

			  	if(empty($_POST['image'])){
			  		
			  		$det  = array('project_id'=>$projectId,'image_thumb'=>'1596101202Dh.jpg','cover_pic'=>1,'status'=>1,'created'=>date('Y-m-d H:i:s'),'size'=>'20.11kb','order_no'=>1);
			  		$insert_id = $this->project_model->add_img($det);
			  		$img_ids = array($insert_id);
			  		
			  	}else{
			  		$img_ids = $_POST['image'];
			  	}
				//$img_ids = $_POST['image'];
				//pr($img_ids);
				$today   = date("Y-m-d H:i:s");
				if($_POST['submit_value'] == 'Draft'){
					$status       = 0;
					$admin_status = '';
				}
				elseif($_POST['submit_value'] == 'Private'){
					$status       = 3;
					$admin_status = '';
				}
				else
				{
					if($this->session->userdata('user_institute_id') != ''){
						if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
						{
							$status       = 1;
							$admin_status = '';
						}
						else
						{
							$admin_flag = $this->project_model->check_admin_approve_required($this->session->userdata('user_institute_id'));
							if(!empty($admin_flag))
							{
								if($admin_flag[0]['admin_status'] == 1)
								{
									$status       = 3;$admin_status = 0;
									$flashMsg='Project added and admin approval required to make this project public till then your project status change to private successfully.';
								}
								else
								{
									$status       = 1;$admin_status = '';
								}
							}
						}
					}
					else
					{
						$status       = 1;
						$admin_status = '';
					}
				}
				$i   = 0; $k   = 0; $z=1;
				//print_r($img_ids);die;
				foreach($img_ids as $row)
				{
					$img_detail = $this->project_model->getImgDetail($row);
					$this->load->model('project_model');
					$data1 = array("project_id"=>$projectId,'order_no'=>$z);
					if($cover_pic == $row)
					{
						$data1['cover_pic'] = 1;
					}
					if($img_detail[0]['content_type'] == 0)
					{
						if(isset($_POST['prize'][$k]))
						{
							$data1['prize'] = $_POST['prize'][$k];
						}
						$k++;
						if(isset($_POST['watermark_text']) && $this->input->post('watermark_text') != '')
						{
							//pr($_POST);
							$text = $this->input->post('watermark_text');
							$color = 'ffffff';
							if($this->input->post('watermark_color') != '')
							{
								$color = $this->input->post('watermark_color');
							}
							if(file_exists(file_upload_s3_path().'project/thumb_big/'.$img_detail[0]['image_thumb']))
							{
								//echo "string";die;
								$this->watermark($img_detail[0]['image_thumb'],$text,'middle','center',$color);
							}
						}
					}
					$this->project_model->upadate_info($data1,$row);
					$i++;
					$imageName = $this->model_basic->getValue($this->db->dbprefix('user_project_image'),"image_thumb"," `id` = '".$row."' ");
					$result =$this->model_basic->getValue('users',"google_drive_setting"," `id` = '".$this->session->userdata('front_user_id')."' ");
					if($result == 1){
						$this->session->set_userdata('profileImageData',file_upload_s3_path().'project/'.$imageName);
						$this->session->set_userdata('file_id',$row);
						$this->uploadFile();
						unlink(file_upload_s3_path().'project/'. $imageName);
					}
					$z++;
				}
				if($projectId > 0)
				{
					if(isset($admin_flag)&&!empty($admin_flag))
					{
						$st = array('status'=>$status,'admin_status'=>$admin_status);
					}
					else
					{
						$st = array('status'=>$status,'admin_status'=>$admin_status);
					}
					$this->project_model->update_project_status($projectId,$st);
					$attribute = $this->project_model->getCategoryAttribute($categoryId);
					if(!empty($attribute))
					{
						foreach($attribute as $row){
							$temp = array();
							$atti_id = $row['attributeId'];
							if(isset($_POST['attribute'.$atti_id]) && $_POST['attribute'.$atti_id] != '')
							{
								$arr = explode(',',$_POST['attribute'.$atti_id]);
								if(!empty($row['atrribute_value'])){
									$k = 0;
									foreach($row['atrribute_value'] as $val){
										foreach($arr as $ar){
											if(($val == $ar)){
												$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$val);
												$det = array('projectId'       =>$projectId,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$vid[0]['id']);
												$this->project_model->add_project_attribute($det);
											}
											else
											{
												$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
												if(empty($vid)){
													$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
													$temp[] = $this->project_model->add_attribute_value($det);
												}
											}
										}
										$k++;
									}
								}
								else
								{
									foreach($arr as $ar){
										$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
										if(empty($vid)){
											//echo $ar;
											$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
											$temp[] = $this->project_model->add_attribute_value($det);
										}
									}
								}
							}
							if(!empty($temp)){
								foreach($temp as $dt){
									$det = array('projectId'  =>$projectId,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$dt);
									$this->project_model->add_project_attribute($det);
								}
							}
						}
					}

					/*if(isset($_POST['submit_value']) && $_POST['submit_value'] == 'Publish')
					{*/
						$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
						$proDetail          = $this->project_model->getProjectDetail($projectId);
						$newAddedPrjectName = $proDetail[0]['projectName'];
						$addedBy            = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
						$addedByName        = ucwords($addedBy['firstName'].' '.$addedBy['lastName']);
						$addedByEmail       = $addedBy['email'];
						$from               = $emailFrom;
						$subjectBy          = 'Successfully added project "'. $newAddedPrjectName.'" to creosouls';
						$templateAddedBy    = 'Hello <b>'.$addedByName. '</b>,<br />Your project "<b>' .$newAddedPrjectName.'</b>" is added successfully to creosouls.<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$sendEmailToAddUser = array('to' =>$addedByEmail,'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
						//$this->model_basic->sendMail($sendEmailToAddUser);

						$notificationEntry=array('title'=>'New project added','msg'=>$addedByName.' added new project '.$newAddedPrjectName,'link'=>'projectDetail/'.$projectPageName,'imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>3,'redirectId'=>$projectId);
						$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

						$instituteAdminUserId=$this->model_basic->getValueArray('institute_master','adminId',array('id'=>$addedBy['instituteId']));
						$instituteAdminUsersDetail   = $this->model_basic->loggedInUserInfoById($instituteAdminUserId);
						$instituteAdminName     = ucwords($instituteAdminUsersDetail['firstName'].' '.$instituteAdminUsersDetail['lastName']);
						$instituteAdminEmail    = $instituteAdminUsersDetail['email'];
						$subjectToinstituteAdmin    = ''.$addedByName.' added a new project on creosouls.';
						$templateInstituteAdmin    = 'Hello <b>'.$instituteAdminName. '</b>,<br />The user '.$addedByName.' of your institute has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$sendEmailToInstituteAdmin  = array('to'=>$instituteAdminEmail,'subject'  =>$subjectToinstituteAdmin,'template' =>$templateInstituteAdmin,'fromEmail'=>$from);
						//$this->model_basic->sendMail($sendEmailToInstituteAdmin);
						
						$notificationToInstituteAdmin=array('notification_id'=>$notificationId,'user_id'=>$instituteAdminUserId);
						$this->model_basic->_insert('header_notification_user_relation',$notificationToInstituteAdmin);

						$msg = array (
							'body' 	=> '',
							'title'	=> '',
							'aboutNotification'	=> ucwords($addedByName).'added a new project on creosouls.',
							'notificationTitle'	=> 'New Project added',
							'notificationType'	=> 3,
							'notificationId'	=> $projectId,
							'notificationImageUrl'	=> ''          	
			          	);
						$this->model_basic->sendNotification($instituteAdminUserId,$msg);

						$followedUsers = $this->project_model->getFollowedUsers($proDetail[0]['userId']);
						if($status==1)
						{
							if(!empty($followedUsers))
							{
								foreach($followedUsers as $key)
								{
									$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
									if(!empty($followedUsersDetail))
									{
										$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
										if($emailSetting==1)
										{
											$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
											$followedUsersEmail    = $followedUsersDetail['email'];
											$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
											$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br /><br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
											$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
											//$this->model_basic->sendMail($sendEmailToFolledUser);
										}
										$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
										$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);
										$msg = array (
											'body' 	=> '',
											'title'	=> '',
											'aboutNotification'	=> ucwords($addedByName).'whom you are following on creosouls has added new project',
											'notificationTitle'	=> 'New Project added',
											'notificationType'	=> 3,
											'notificationId'	=> $projectId,
											'notificationImageUrl'	=> ''          	
							          	);
										$this->model_basic->sendNotification($key['userId'],$msg);
									}
									
								}
							}
						}
						if($status==3)
						{
							if(!empty($followedUsers))
							{
								foreach($followedUsers as $key)
								{
									$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
									if($followedUsersDetail['instituteId'] == $addedBy['instituteId'])
									{
										$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
										if($emailSetting==1)
										{
											$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
											$followedUsersEmail    = $followedUsersDetail['email'];
											$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
											$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br /><br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
											$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
											//$this->model_basic->sendMail($sendEmailToFolledUser);
										}
										$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
										$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);

										$msg = array (
											'body' 	=> '',
											'title'	=> '',
											'aboutNotification'	=> ucwords($addedByName).'whom you are following on creosouls has added new project',
											'notificationTitle'	=> 'New Project added',
											'notificationType'	=> 3,
											'notificationId'	=> $projectId,
											'notificationImageUrl'	=> ''          	
						          		);
										$this->model_basic->sendNotification($key['userId'],$msg);
									}
								}
							}
						}
						
						/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')
						{*/

						if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
						{
							$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$this->session->userdata('front_user_id')));
							$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$_POST['Save_Assignment_Id']));
							$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));
							$message='Hello Sir,<br /> New assignment has been submitted <br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';	
							$emailData = array('to'=>$get_teacher_data['email'],'fromEmail'=>$get_user_data['email'],'subject'=>'Assignment has been submitted to you','template'=>$message);	  
							//$sendMail = $this->model_basic->sendMail($emailData);

						/*	$assNotificationEntry=array('title'=>'New assignment project submitted','msg'=>$addedByName.' submitted new  project '.$newAddedPrjectName.'for assignment that you assigned to him.','link'=>'assignment/assignment_detail/'.$_POST['Save_Assignment_Id'].'/'.$this->session->userdata('front_user_id'),'imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$_POST['Save_Assignment_Id']);*/
							$assNotificationEntry=array('title'=>'New assignment project submitted','msg'=>$addedByName.' submitted new  project '.$newAddedPrjectName.' for assignment that you assigned to him. ','link'=>'projectDetail/'.$proDetail[0]['projectPageName'].'/1','imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$_POST['Save_Assignment_Id']);
							$assNotificationId=$this->model_basic->_insert('header_notification_master',$assNotificationEntry);
							$notificationToTeacher=array('notification_id'=>$assNotificationId,'user_id'=>$get_assignment_data['teacher_id']);
							$this->model_basic->_insert('header_notification_user_relation',$notificationToTeacher);	

							$msg = array (
										'body' 	=> '',
										'title'	=> '',
										'aboutNotification'	=> ucwords($addedByName).'submitted new project for assignment that you assigned to him.',
										'notificationTitle'	=> 'New assignment project submitted',
										'notificationType'	=> 17,
										'notificationId'	=> $_POST['Save_Assignment_Id'],
										'notificationImageUrl'	=> ''          	
						          	);
							$this->model_basic->sendNotification($get_assignment_data['teacher_id'],$msg);		
						}
					
					if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
					{
						$this->session->set_flashdata('success', 'Competition content added successfully.');
						$comp_id = $_POST['Save_Competition_Id'];							
						echo base_url().'competition/get_competition/'.$comp_id;
					}
					else if(isset($_POST['Save_interview_Assignment_Id']) && $_POST['Save_interview_Assignment_Id'] !='')
					{
						$this->session->set_flashdata('success', 'Interview Assignment content added successfully.');
						$interview_Assignment_Id = $_POST['Save_interview_Assignment_Id'];							
						echo base_url().'interview_test/interview_test_detail/'.$interview_Assignment_Id.'/'.$this->session->userData("front_user_id");
					}
					else
					{
						if(isset($flashMsg))
						{
							$this->session->set_flashdata('success',$flashMsg);
						}
						else
						{
							/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')*/
							if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
							{
								$this->session->set_flashdata('success', 'Project submitted successfully');
							}
							else
							{
								$this->session->set_flashdata('success', 'Project added successfully.');
							}
						}

						/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')*/
						if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
						{
								echo base_url().'assignment/assignment_detail/'.$_POST['Save_Assignment_Id'].'/'.$this->session->userdata('front_user_id');	
						}
						else
						{
							echo base_url().'profile';
						}							
						
					}
				}
		    }
			else
			{
				echo 'error';
			}
			}
			else{
				$this->session->set_flashdata('error', 'Failed,Please select a different category.You have already added a project in this category.');
				$comp_id = $_POST['Save_Competition_Id'];							
				echo base_url().'competition/get_competition/'.$comp_id;
			}
		}else{
			$projectId = $this->project_model->add_project($data);
				if($projectId > 0)
				{
				  	$title     = $this->model_basic->getValue($this->db->dbprefix('project_master'),"projectName"," `id` = '".$projectId."' ");

				  	if(empty($_POST['image'])){
				  		$det  = array('project_id'=>$projectId,'image_thumb'=>'1596101202Dh.jpg','cover_pic'=>1,'status'=>1,'created'=>date('Y-m-d H:i:s'),'size'=>'20.11kb','order_no'=>1);
				  		$insert_id = $this->project_model->add_img($det);
				  		$img_ids = array($insert_id);
				  		
				  	}else{
				  		$img_ids = $_POST['image'];
				  	}
					//$img_ids = $_POST['image'];
					//pr($img_ids);
					$today   = date("Y-m-d H:i:s");
					if($_POST['submit_value'] == 'Draft'){
						$status       = 0;
						$admin_status = '';
					}
					elseif($_POST['submit_value'] == 'Private'){
						$status       = 3;
						$admin_status = '';
					}
					else
					{
						if($this->session->userdata('user_institute_id') != ''){
							if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
							{
								$status       = 1;
								$admin_status = '';
							}
							else
							{
								$admin_flag = $this->project_model->check_admin_approve_required($this->session->userdata('user_institute_id'));
								if(!empty($admin_flag))
								{
									if($admin_flag[0]['admin_status'] == 1)
									{
										$status       = 3;$admin_status = 0;
										$flashMsg='Project added and admin approval required to make this project public till then your project status change to private successfully.';
									}
									else
									{
										$status       = 1;$admin_status = '';
									}
								}
							}
						}
						else
						{
							$status       = 1;
							$admin_status = '';
						}
					}
					$i   = 0; $k   = 0; $z=1;
					//print_r($img_ids);die;
					foreach($img_ids as $row)
					{
						$img_detail = $this->project_model->getImgDetail($row);
						$this->load->model('project_model');
						$data1 = array("project_id"=>$projectId,'order_no'=>$z);
						if($cover_pic == $row)
						{
							$data1['cover_pic'] = 1;
						}
						if($img_detail[0]['content_type'] == 0)
						{
							if(isset($_POST['prize'][$k]))
							{
								$data1['prize'] = $_POST['prize'][$k];
							}
							$k++;
							if(isset($_POST['watermark_text']) && $this->input->post('watermark_text') != '')
							{
								//pr($_POST);
								$text = $this->input->post('watermark_text');
								$color = 'ffffff';
								if($this->input->post('watermark_color') != '')
								{
									$color = $this->input->post('watermark_color');
								}
								if(file_exists(file_upload_s3_path().'project/thumb_big/'.$img_detail[0]['image_thumb']))
								{
									//echo "string";die;
									$this->watermark($img_detail[0]['image_thumb'],$text,'middle','center',$color);
								}
							}
						}
						$this->project_model->upadate_info($data1,$row);
						$i++;
						$imageName = $this->model_basic->getValue($this->db->dbprefix('user_project_image'),"image_thumb"," `id` = '".$row."' ");
						$result =$this->model_basic->getValue('users',"google_drive_setting"," `id` = '".$this->session->userdata('front_user_id')."' ");
						if($result == 1){
							$this->session->set_userdata('profileImageData',file_upload_s3_path().'project/'.$imageName);
							$this->session->set_userdata('file_id',$row);
							$this->uploadFile();
							unlink(file_upload_s3_path().'project/'. $imageName);
						}
						$z++;
					}
					if($projectId > 0)
					{
						if(isset($admin_flag)&&!empty($admin_flag))
						{
							$st = array('status'=>$status,'admin_status'=>$admin_status);
						}
						else
						{
							$st = array('status'=>$status,'admin_status'=>$admin_status);
						}
						$this->project_model->update_project_status($projectId,$st);
						$attribute = $this->project_model->getCategoryAttribute($categoryId);
						if(!empty($attribute))
						{
							foreach($attribute as $row){
								$temp = array();
								$atti_id = $row['attributeId'];
								if(isset($_POST['attribute'.$atti_id]) && $_POST['attribute'.$atti_id] != '')
								{
									$arr = explode(',',$_POST['attribute'.$atti_id]);
									if(!empty($row['atrribute_value'])){
										$k = 0;
										foreach($row['atrribute_value'] as $val){
											foreach($arr as $ar){
												if(($val == $ar)){
													$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$val);
													$det = array('projectId'       =>$projectId,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$vid[0]['id']);
													$this->project_model->add_project_attribute($det);
												}
												else
												{
													$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
													if(empty($vid)){
														$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
														$temp[] = $this->project_model->add_attribute_value($det);
													}
												}
											}
											$k++;
										}
									}
									else
									{
										foreach($arr as $ar){
											$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
											if(empty($vid)){
												//echo $ar;
												$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
												$temp[] = $this->project_model->add_attribute_value($det);
											}
										}
									}
								}
								if(!empty($temp)){
									foreach($temp as $dt){
										$det = array('projectId'  =>$projectId,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$dt);
										$this->project_model->add_project_attribute($det);
									}
								}
							}
						}

						/*if(isset($_POST['submit_value']) && $_POST['submit_value'] == 'Publish')
						{*/
							$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							$proDetail          = $this->project_model->getProjectDetail($projectId);
							$newAddedPrjectName = $proDetail[0]['projectName'];
							$addedBy            = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
							$addedByName        = ucwords($addedBy['firstName'].' '.$addedBy['lastName']);
							$addedByEmail       = $addedBy['email'];
							$from               = $emailFrom;
							$subjectBy          = 'Successfully added project "'. $newAddedPrjectName.'" to creosouls';
							$templateAddedBy    = 'Hello <b>'.$addedByName. '</b>,<br />Your project "<b>' .$newAddedPrjectName.'</b>" is added successfully to creosouls.<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$sendEmailToAddUser = array('to' =>$addedByEmail,'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
							//$this->model_basic->sendMail($sendEmailToAddUser);

							$notificationEntry=array('title'=>'New project added','msg'=>$addedByName.' added new project '.$newAddedPrjectName,'link'=>'projectDetail/'.$projectPageName,'imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>3,'redirectId'=>$projectId);
							$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

							$instituteAdminUserId=$this->model_basic->getValueArray('institute_master','adminId',array('id'=>$addedBy['instituteId']));
							$instituteAdminUsersDetail   = $this->model_basic->loggedInUserInfoById($instituteAdminUserId);
							$instituteAdminName     = ucwords($instituteAdminUsersDetail['firstName'].' '.$instituteAdminUsersDetail['lastName']);
							$instituteAdminEmail    = $instituteAdminUsersDetail['email'];
							$subjectToinstituteAdmin    = ''.$addedByName.' added a new project on creosouls.';
							$templateInstituteAdmin    = 'Hello <b>'.$instituteAdminName. '</b>,<br />The user '.$addedByName.' of your institute has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$sendEmailToInstituteAdmin  = array('to'=>$instituteAdminEmail,'subject'  =>$subjectToinstituteAdmin,'template' =>$templateInstituteAdmin,'fromEmail'=>$from);
							//$this->model_basic->sendMail($sendEmailToInstituteAdmin);
							
							$notificationToInstituteAdmin=array('notification_id'=>$notificationId,'user_id'=>$instituteAdminUserId);
							$this->model_basic->_insert('header_notification_user_relation',$notificationToInstituteAdmin);

							$msg = array (
								'body' 	=> '',
								'title'	=> '',
								'aboutNotification'	=> ucwords($addedByName).'added a new project on creosouls.',
								'notificationTitle'	=> 'New Project added',
								'notificationType'	=> 3,
								'notificationId'	=> $projectId,
								'notificationImageUrl'	=> ''          	
				          	);
							$this->model_basic->sendNotification($instituteAdminUserId,$msg);

							$followedUsers = $this->project_model->getFollowedUsers($proDetail[0]['userId']);
							if($status==1)
							{
								if(!empty($followedUsers))
								{
									foreach($followedUsers as $key)
									{
										$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
										if(!empty($followedUsersDetail))
										{
											$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
											if($emailSetting==1)
											{
												$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
												$followedUsersEmail    = $followedUsersDetail['email'];
												$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
												$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br /><br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
												$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
												//$this->model_basic->sendMail($sendEmailToFolledUser);
											}
											$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
											$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);
											$msg = array (
												'body' 	=> '',
												'title'	=> '',
												'aboutNotification'	=> ucwords($addedByName).'whom you are following on creosouls has added new project',
												'notificationTitle'	=> 'New Project added',
												'notificationType'	=> 3,
												'notificationId'	=> $projectId,
												'notificationImageUrl'	=> ''          	
								          	);
											$this->model_basic->sendNotification($key['userId'],$msg);
										}
										
									}
								}
							}
							if($status==3)
							{
								if(!empty($followedUsers))
								{
									foreach($followedUsers as $key)
									{
										$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
										if($followedUsersDetail['instituteId'] == $addedBy['instituteId'])
										{
											$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
											if($emailSetting==1)
											{
												$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
												$followedUsersEmail    = $followedUsersDetail['email'];
												$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
												$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br /><br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
												$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
												//$this->model_basic->sendMail($sendEmailToFolledUser);
											}
											$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
											$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);

											$msg = array (
												'body' 	=> '',
												'title'	=> '',
												'aboutNotification'	=> ucwords($addedByName).'whom you are following on creosouls has added new project',
												'notificationTitle'	=> 'New Project added',
												'notificationType'	=> 3,
												'notificationId'	=> $projectId,
												'notificationImageUrl'	=> ''          	
							          		);
											$this->model_basic->sendNotification($key['userId'],$msg);
										}
									}
								}
							}
							
							/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')
							{*/

							if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
							{
								$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$this->session->userdata('front_user_id')));
								$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$_POST['Save_Assignment_Id']));
								$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));
								$message='Hello Sir,<br /> New assignment has been submitted <br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';	
								$emailData = array('to'=>$get_teacher_data['email'],'fromEmail'=>$get_user_data['email'],'subject'=>'Assignment has been submitted to you','template'=>$message);	  
								//$sendMail = $this->model_basic->sendMail($emailData);

							/*	$assNotificationEntry=array('title'=>'New assignment project submitted','msg'=>$addedByName.' submitted new  project '.$newAddedPrjectName.'for assignment that you assigned to him.','link'=>'assignment/assignment_detail/'.$_POST['Save_Assignment_Id'].'/'.$this->session->userdata('front_user_id'),'imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$_POST['Save_Assignment_Id']);*/
								$assNotificationEntry=array('title'=>'New assignment project submitted','msg'=>$addedByName.' submitted new  project '.$newAddedPrjectName.' for assignment that you assigned to him. ','link'=>'projectDetail/'.$proDetail[0]['projectPageName'].'/1','imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$_POST['Save_Assignment_Id']);
								$assNotificationId=$this->model_basic->_insert('header_notification_master',$assNotificationEntry);
								$notificationToTeacher=array('notification_id'=>$assNotificationId,'user_id'=>$get_assignment_data['teacher_id']);
								$this->model_basic->_insert('header_notification_user_relation',$notificationToTeacher);	

								$msg = array (
											'body' 	=> '',
											'title'	=> '',
											'aboutNotification'	=> ucwords($addedByName).'submitted new project for assignment that you assigned to him.',
											'notificationTitle'	=> 'New assignment project submitted',
											'notificationType'	=> 17,
											'notificationId'	=> $_POST['Save_Assignment_Id'],
											'notificationImageUrl'	=> ''          	
							          	);
								$this->model_basic->sendNotification($get_assignment_data['teacher_id'],$msg);		
							}
						
						if(isset($_POST['Save_Competition_Id']) && $_POST['Save_Competition_Id'] !='')
						{
							$this->session->set_flashdata('success', 'Competition content added successfully.');
							$comp_id = $_POST['Save_Competition_Id'];							
							echo base_url().'competition/get_competition/'.$comp_id;
						}
						else if(isset($_POST['Save_interview_Assignment_Id']) && $_POST['Save_interview_Assignment_Id'] !='')
						{
							$this->session->set_flashdata('success', 'Interview Assignment content added successfully.');
							$interview_Assignment_Id = $_POST['Save_interview_Assignment_Id'];							
							echo base_url().'interview_test/interview_test_detail/'.$interview_Assignment_Id.'/'.$this->session->userData("front_user_id");
						}
						else
						{
							if(isset($flashMsg))
							{
								$this->session->set_flashdata('success',$flashMsg);
							}
							else
							{
								/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')*/
								if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
								{
									$this->session->set_flashdata('success', 'Project submitted successfully');
								}
								else
								{
									$this->session->set_flashdata('success', 'Project added successfully.');
								}
							}

							/*if(isset($_POST['Save_Assignment_Id']) && $_POST['Save_Assignment_Id']!='')*/
							if(isset($check_assig_user_relation) && !empty($check_assig_user_relation))
							{
									echo base_url().'assignment/assignment_detail/'.$_POST['Save_Assignment_Id'].'/'.$this->session->userdata('front_user_id');	
							}
							else
							{
								//echo base_url().'profile';
								echo base_url().'projectDetail/'.$projectPageName;
							}							
							
						}
					}
			    }
				else
				{
					echo 'error';
				}
		}
			
		}
		else
		{
			echo 'error';
		}
	}

	/*public function entryOldJobs()
	{
		$jobs=$this->db->select('id')->from('jobs')->get()->result_array();
		$regions=$this->db->select('id,zone_id')->from('region_list')->get()->result_array();
		foreach($jobs as $job)
		{
			foreach($regions as $region)
			{
				$data=array('job_id'=>$job['id'],'zone_id'=>$region['zone_id'],'region_id'=>$region['id']);
				$this->model_basic->_insert('job_zone_relation',$data);
			}
		}
	}*/

	public function generateProjectPageName($projectName='')
	{
		$userId = $this->session->userdata('front_user_id');
		$this->db->select('firstName,lastName');
		$this->db->from('users');
		$this->db->where('id',$userId);
		$userData = $this->db->get()->row();
		$username = $userData->firstName.$userData->lastName;
		$this->db->select('id,projectName,userId');
		$this->db->from('project_master');
		$this->db->where('userId',$userId);
		$this->db->where('projectName',$projectName);
		$similarProjectsCount = $this->db->get()->num_rows();
		$newProjectName = preg_replace('/[^A-Za-z0-9]/','', strip_tags($projectName));
		$newName = str_replace(" ",'',$newProjectName);
		if($similarProjectsCount!='' && $similarProjectsCount>0)
		{
			$projectPageName = $newName.'_'.$similarProjectsCount.'_By_'.$username;
		}
		else{
			$projectPageName = $newName.'_By_'.$username;
		}
		return $projectPageName;
	}
    public function set_category()
	{
	   if(isset($_POST['project_category']) && ($_POST['project_category'] != ''))
		 {
			$res = $this->project_model->getCategoryAttribute($_POST['project_category']);
			echo json_encode($res);
		 }
	}
	public function watermark($image = '',$text,$vrtPostion = '',$horPostion = '',$textColor = '')
	{
		$config['source_image'] = file_upload_s3_path().'project/thumb_big/'.$image;
		$config['wm_text'] = $text;
		$config['wm_font_path'] = './assets/fonts/HelveticaNeue-Bold.ttf';
		$config['wm_type'] = 'text';
		//$config['new_image'] =file_upload_s3_path().'project/'.$image;
		$config['wm_font_size'] = '20';
		$config['wm_font_color'] = $textColor;
		$config['wm_vrt_alignment'] = $vrtPostion;
		$config['wm_hor_alignment'] = $horPostion;
		$config['wm_opacity'] = 10;
		/*$config['wm_padding'] = '20';
		$config['wm_x_transp'] = '4';*/
		$this->image_lib->initialize($config);
		return $this->image_lib->watermark();
	}

	public function do_upload()
	{
		$filename=$_FILES['userfile']['name'];
		$ext = end(explode('.', $filename));
		$extarray=array("jpeg","JPEG","jpg","JPG","png","PNG","gif");
		if(isset($ext) && !empty($ext) && in_array($ext, $extarray))
		{
			$date = date("Y-m-d");
			if(!is_dir(file_upload_s3_path().'project')){
				@mkdir(file_upload_s3_path().'project', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project/thumbs')){
				@mkdir(file_upload_s3_path().'project/thumbs', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project')){
				@mkdir(file_upload_s3_path().'project', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project/thumb_big')){
				@mkdir(file_upload_s3_path().'project/thumb_big', 0777, TRUE);
			}
			$this->load->helper('string');
			$upload_path_url = file_upload_base_url().'project/';
			$config['upload_path'] = file_upload_s3_path().'project';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
			$config['file_name'] = time().random_string('alnum', 2);
			$config['max_size'] = '3000';
			$config['max_width'] = '2048';
			$config['max_height'] = '2048';
			$this->load->library('upload');
			$this->upload->initialize($config);
            $uId = $this->session->userdata('front_user_id');
			$allowedDiskSpace=$this->user_model->getAllowedDiskSpace($uId);
			$uploadImageSize=0;
			if(isset($_FILES['userfile']['name']))
			{
				$uploadImageSize=$_FILES['userfile']['size'];
			}
			$usedDiskSpace=$this->getDiskSpace();
			$totalSizeAfterUpload=$uploadImageSize + $usedDiskSpace;
			$totalSizeAfterUpload = number_format($totalSizeAfterUpload / 1048576, 2);

			if($allowedDiskSpace[0]['description'] > $totalSizeAfterUpload)
			{
				if(!$this->upload->do_upload())
				{
					echo strip_tags($this->upload->display_errors());
				}
				else
				{
					$data = $this->upload->data();
					$image_width=$data['image_width'];
					$image_height=$data['image_height'];

					$config['source_image'] = file_upload_s3_path().'project/'.$data['file_name'];
					$config['new_image'] = file_upload_s3_path().'project/thumb_big/'.$data['file_name'];
					$config['maintain_ratio'] = TRUE;
					if($image_width < 960)
					{
						$config['width']=$image_width;
						$config['height']=$image_height;
					}
					else
					{
						$config['width'] = 960;
						$config['height'] = 768;
					}
					$config['master_dim'] = 'width';

					$this->image_lib->initialize($config);
					$this->image_lib->resize();


					// to re - size for thumbnail images un - comment and set path here and in json array
					$det  = array('image_thumb'=>$data['file_name'],'created'    =>date('Y-m-d H:i:s'),'size'=>$data['file_size'].' kb');
					if($data['file_ext'] == '.zip'){
						$det['content_type'] = 1;
					}
					$this->load->model('project_model');
					$insert_id = $this->project_model->add_img($det);

					$this->model_basic->ImageCropMaster('200','160',file_upload_s3_path().'project/thumb_big/'.$data['file_name'],file_upload_s3_path().'project/thumbs/'.$data['file_name'],$image_width,$image_height);
					//set the data for the json array
					$info = new StdClass;
					$info->name = $data['file_name'];
					$info->size = round($data['file_size']);
					$info->type = $data['file_type'];
					$info->file_ext = $data['file_ext'];
					$info->id = $insert_id;
					if($data['file_ext'] == '.zip'){
						$info->url = base_url().'assets/img/zip.png';
						$info->thumbnailUrl = base_url().'assets/img/zip.png';
					}
					else
					{
						$info->url = $upload_path_url . $data['file_name'];
						$info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
					}
					$info->deleteUrl = base_url() . 'project/deleteImage/' . urldecode($data['file_name']);
					$info->deleteType = 'DELETE';
					$info->error = null;
					$files[] = $info;
					//this is why we put this in the constants to pass only json data
					if(IS_AJAX)
					{
						echo json_encode(array("files"=> $files));
						//this has to be the only data returned or you will get an error.
						//if you don't give this a json array it will give you a Empty file upload result error
						//it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
						// so that this will still work if javascript is not enabled
					}
					else
					{
						$file_data['upload_data'] = $this->upload->data();
						$this->load->view('upload_success', $file_data);
					}
				}
			}
		    else
		    {
		    	echo json_encode(array("error"=> 'Allowed disk space limit is over, please contact admin'));
		    }
		}
		else
		{
		     //echo "Inside";exit();
		if(isset($_FILES['userfile']['type']) && $_FILES['userfile']['type']== 'application/pdf' )
		{		
		  if($_FILES['userfile']['size'] != 0)
			{	
                $this->load->library('upload');  
			    $upload_path_url = file_upload_base_url().'project/';
			    $config['upload_path'] = file_upload_s3_path().'project';
                $config['allowed_types'] = 'pdf';
			    $config['max_size'] = '1000000';
			    $config['max_width'] = '2048';
			    $config['max_height'] = '2048';
				
                $this->upload->initialize($config);
          
				if($this->upload->do_upload('userfile'))
				{
                    $img = $this->upload->data();
                  
                    //echo "<pre>";print_r($img);exit();
                    $img_name=$img['file_name'];
                    $det  = array('image_thumb'=>$img['file_name'],'created'=>date('Y-m-d H:i:s'),'size'=>$img['file_size'].' kb');
					
                    $this->load->model('project_model');
					$insert_id = $this->project_model->add_img($det);
                    
                    //set the data for the json array
					$info = new StdClass;
					$info->name = $img['file_name'];
					$info->size = round($img['file_size']);
					$info->type = $img['file_type'];
					$info->file_ext = $img['file_ext'];
					$info->id = $insert_id;
                    //echo "<pre>";print_r($info);exit();
					if($img['file_ext'] == '.pdf'){
                     // echo "In";exit();
						$info->url = base_url().'assets/img/pdf.png';
						$info->thumbnailUrl = base_url().'assets/img/pdf.png';
					}
					else
					{
                      //echo "out";exit();
						$info->url = $upload_path_url . $img['file_name'];
						$info->thumbnailUrl = $upload_path_url . 'thumbs/' . $img['file_name'];
					}
                    $info->deleteUrl = base_url() . 'project/deleteImage/' . urldecode($img['file_name']);
					$info->deleteType = 'DELETE';
					$info->error = null;
					$files[] = $info;
					//this is why we put this in the constants to pass only json data
					if(IS_AJAX)
					{
						echo json_encode(array("files"=> $files));
						//this has to be the only data returned or you will get an error.
						//if you don't give this a json array it will give you a Empty file upload result error
						//it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
						// so that this will still work if javascript is not enabled
					}
					else
					{
						$file_data['upload_data'] = $this->upload->data();
						$this->load->view('upload_success', $file_data);
					}
				}
				else
				{
                   $error=$this->upload->display_errors();
					$this->session->set_flashdata('img',$error);						
				}
			}
		}
		}
	}

	public function do_upload_5april()
	{
		$filename=$_FILES['userfile']['name'];
		$ext = end(explode('.', $filename));
		$extarray=array("jpeg","JPEG","jpg","JPG","png","PNG","gif");
		if(isset($ext) && !empty($ext) && in_array($ext, $extarray))
		{
			$date = date("Y-m-d");
			if(!is_dir(file_upload_s3_path().'project')){
				@mkdir(file_upload_s3_path().'project', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project/thumbs')){
				@mkdir(file_upload_s3_path().'project/thumbs', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project')){
				@mkdir(file_upload_s3_path().'project', 0777, TRUE);
			}
			if(!is_dir(file_upload_s3_path().'project/thumb_big')){
				@mkdir(file_upload_s3_path().'project/thumb_big', 0777, TRUE);
			}
			$this->load->helper('string');
			$upload_path_url = file_upload_base_url().'project/';
			$config['upload_path'] = file_upload_s3_path().'project';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = time().random_string('alnum', 2);
			$config['max_size'] = '3000';
			$config['max_width'] = '4048';
			$config['max_height'] = '4048';
			$this->load->library('upload');
			$this->upload->initialize($config);
            $uId = $this->session->userdata('front_user_id');
			$allowedDiskSpace=$this->user_model->getAllowedDiskSpace($uId);
			$uploadImageSize=0;
			if(isset($_FILES['userfile']['name']))
			{
				$uploadImageSize=$_FILES['userfile']['size'];
			}
			$usedDiskSpace=$this->getDiskSpace();
			$totalSizeAfterUpload=$uploadImageSize + $usedDiskSpace;
			$totalSizeAfterUpload = number_format($totalSizeAfterUpload / 1048576, 2);

			if($allowedDiskSpace[0]['description'] > $totalSizeAfterUpload)
			{
				if(!$this->upload->do_upload())
				{
					echo strip_tags($this->upload->display_errors());
				}
				else
				{
					$data = $this->upload->data();
					$image_width=$data['image_width'];
					$image_height=$data['image_height'];

					$config['source_image'] = file_upload_s3_path().'project/'.$data['file_name'];
					$config['new_image'] = file_upload_s3_path().'project/thumb_big/'.$data['file_name'];
					$config['maintain_ratio'] = TRUE;
					if($image_width < 960)
					{
						$config['width']=$image_width;
						$config['height']=$image_height;
					}
					else
					{
						$config['width'] = 960;
						$config['height'] = 768;
					}
					$config['master_dim'] = 'width';

					$this->image_lib->initialize($config);
					$this->image_lib->resize();


					// to re - size for thumbnail images un - comment and set path here and in json array
					$det  = array('image_thumb'=>$data['file_name'],'created'    =>date('Y-m-d H:i:s'),'size'=>$data['file_size'].' kb');
					if($data['file_ext'] == '.zip'){
						$det['content_type'] = 1;
					}
					$this->load->model('project_model');
					$insert_id = $this->project_model->add_img($det);

					$this->model_basic->ImageCropMaster('200','160',file_upload_s3_path().'project/thumb_big/'.$data['file_name'],file_upload_s3_path().'project/thumbs/'.$data['file_name'],$image_width,$image_height);
					//set the data for the json array
					$info = new StdClass;
					$info->name = $data['file_name'];
					$info->size = round($data['file_size']);
					$info->type = $data['file_type'];
					$info->file_ext = $data['file_ext'];
					$info->id = $insert_id;
					if($data['file_ext'] == '.zip'){
						$info->url = base_url().'assets/img/zip.png';
						$info->thumbnailUrl = base_url().'assets/img/zip.png';
					}
					else
					{
						$info->url = $upload_path_url . $data['file_name'];
						$info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
					}
					$info->deleteUrl = base_url() . 'project/deleteImage/' . urldecode($data['file_name']);
					$info->deleteType = 'DELETE';
					$info->error = null;
					$files[] = $info;
					//this is why we put this in the constants to pass only json data
					if(IS_AJAX)
					{
						echo json_encode(array("files"=> $files));
						//this has to be the only data returned or you will get an error.
						//if you don't give this a json array it will give you a Empty file upload result error
						//it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
						// so that this will still work if javascript is not enabled
					}
					else
					{
						$file_data['upload_data'] = $this->upload->data();
						$this->load->view('upload_success', $file_data);
					}
				}
			}
		    else
		    {
		    	echo json_encode(array("error"=> 'Allowed disk space limit is over, please contact admin'));
		    }
		}
		else
		{
		    echo "Check File Extension";
		}
	}

	public function getDiskSpace()
	{
		$size=0;
        $uId = $this->session->userdata('front_user_id');
		$allProject=$this->user_model->getUsersAllProject($uId);
		if(!empty($allProject))
		{
			foreach($allProject as $project)
			{
				$allImages=$this->user_model->getAllImages($project['id']);
				if(!empty($allImages))
				{
					
					foreach($allImages as $image)
					{
						if(file_exists(file_upload_s3_path().'project/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumbs/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']);
						}
					}
				}
			}
		}
		return $size;
	}
	public function deleteImage($file1)
	{
		//gets the job done but you might want to add error checking and security
		$this->load->model('project_model');
		$file   = html_entity_decode($file1);
		$result = $this->project_model->delete_img($file);
		if($result > 0){
			$date       = date("Y-m-d");
			$success=1;
			if(file_exists(file_upload_s3_path().'project/'.$file))
			{
				$success    = unlink(file_upload_s3_path().'project/'. $file);
			}
			$path_parts = pathinfo($file);
			if($path_parts['extension'] != 'zip'){
				if(file_exists(file_upload_s3_path().'project/thumbs/'.$file))
				{
					$success = unlink(file_upload_s3_path().'project/thumbs/'. $file);
				}
				if(file_exists(file_upload_s3_path().'project/thumb_big/'.$file))
				{
					$success = unlink(file_upload_s3_path().'project/thumb_big/'. $file);
				}
			}
			//info to see if it is doing what it is supposed to
			$info = new StdClass;
			$info->sucess = $success;
			$info->path = file_upload_base_url() . 'project/'. $file;
			$info->file = is_file(file_upload_s3_path().'project/' . $file);
			if(IS_AJAX){
				//I don't think it matters if this is set but good for error checking in the console / firebug
				echo json_encode(array($info));
			}
			else
			{
				//here you will need to decide what you want to show for a successful delete
				$file_data['delete_data'] = $file;
				$this->load->view('delete_success', $file_data);
			}
		}
	}
	public function uploadFile($code = '',$key = '')
	{
		//print_r($_GET);die;
		//require_once 'google - api - php - client / src / Google / autoload.php';
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/autoload.php";
		if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['code']) || ($this->session->userdata('access_token') <> '' && $this->session->userdata('access_token')) || $this->session->userdata('profileImageData') != ''){
			$client = new Google_Client();
			$localhost = array('127.0.0.1','::1');
			if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
			{
				/* local */
				$client->setClientId('787212047392-2o7nscmjvlmnf4u3e6jnes7a2dcbeh1j.apps.googleusercontent.com');
				$client->setClientSecret('uDWrFdVQ2495Fxjm6TwcW6nG');
				$client->setRedirectUri('http://localhost/creosouls/hauth/googleLogin');
			}
			else
			{
				/* test */
				/*$client->setClientId('787212047392-n3akhlp5rkts8st40tu1s1vpah8iqo88.apps.googleusercontent.com');
				$client->setClientSecret('EeuVKH9osDshP_VOstvMHPej');
				$client->setRedirectUri('http://www.creosouls.com/testarena/hauth/googleLogin');*/

				/* live */
				$client->setClientId('787212047392-elqlbfofmi22tpftimheafb4vnvjbudg.apps.googleusercontent.com');
				$client->setClientSecret('ZNE1lTP5G3LXp1bcs7K0_AVq');
				$client->setRedirectUri('http://www.creosouls.com/hauth/googleLogin');
			}
			if($this->session->userdata('access_token') <> '' || (isset($_GET['code']) && $_GET['code'] <> '')){
				if($this->session->userdata('access_token') <> ''){
					$client->setAccessToken($this->session->userdata('access_token'));
				}
			}
			else
			{
				$this->session->set_flashdata('error','Session Expired Login Again To Continue.');
				redirect('hauth/logout');
			}
			// if already has access token
			if(isset($_GET['code']) || ($this->session->userdata('access_token') <> '' && $this->session->userdata('access_token')))
			{
				if(isset($_GET['code']))
				{
					$credentials=$client->authenticate($_GET['code']);
					$this->session->set_userdata('access_token',$client->getAccessToken());
					//pr($client->getAccessToken());
				}
				else
				{
					$client->setAccessToken($this->session->userdata('access_token'));
					if($client->isAccessTokenExpired())
					{
						$refresh_token='';
						if($this->session->userdata('refresh_token') && $this->session->userdata('refresh_token') != '')
						{
							$refresh_token=$this->session->userdata('refresh_token');
						}
						else
						{
							$uid=$this->session->userdata('front_user_id');
							$refresh_token=$this->model_basic->getValue($this->db->dbprefix('users'),"refresh_token"," `id` = '".$uid."' ");;
						}
						$client->refreshToken($refresh_token);
					}
				}
				$service = new Google_Service_Drive($client);
				$uid     = $this->session->userdata('front_user_id');
				//echo $uid;die;
				$parentId= $this->model_basic->getValue($this->db->dbprefix('users'),"folderId"," `id` = '".$uid."' ");
				if($parentId == ''){
					$parentId = $this->createPublicFolder($service,'creosouls');
				}
				//Insert a file
				$file = new Google_Service_Drive_DriveFile();
				$file->setTitle(basename($this->session->userdata('profileImageData')));
				$file->setDescription('Project file');
				//$file->setMimeType('image / jpeg');
				$this->model_basic->_update('users','id',$uid,array('folderId'=>$parentId));
				// Set the parent folder.
				if($parentId != null){
					$parent = new Google_Service_Drive_ParentReference();
					$parent->setId($parentId);
					$file->setParents(array($parent));
				}
				$data        = file_get_contents($this->session->userdata('profileImageData'));
				$createdFile = $service->files->insert($file, array(
						'data'      => $data,
						//'mimeType' => 'image / jpeg',
						'uploadType'=> 'multipart'
					));
				//echo " < h1 > File Uploaded Successfully..</h1><br > Below is the details of file: < br><br><br > ";
				//print_r($createdFile);die;
				if(!empty($createdFile)){
					$this->model_basic->_update('user_project_image','id',$this->session->userdata('file_id'),array('storage_link'=>$createdFile->thumbnailLink));
				}
				//---------------------------------------------------------------
				// 3. removing the file from own server
				//---------------------------------------------------------------
				//unlink('a.jpg'); //remove the file
				//https://googledrive.com / host/<folderID>/basename($this->session->userdata('profileImageData'))
				//$this->session->set_userdata('fileInfo','');
			}
			// if no token
			else
			{
				$authUrl = $client->createAuthUrl();
				//header('Location: ' . $authUrl);
				redirect($authUrl);
				exit();
			}
		}
	}
	public function check_project_images_exist()
	{
		if(isset($_POST['id']) && ($_POST['id'] != '')){
			$res = $this->project_model->getSingleProjectDetail($_POST['id']);
			if(!empty($res)){
				$img = $this->project_model->getSingleProjectImage($res[0]['id']);
				if(!empty($img)){
					echo 'yes';
				}
				else
				{
					echo 'no';
				}
			}
			else
			{
				echo 'no';
			}
		}
	}
	public function check_images_and_admin_flag()
	{
		if(isset($_POST['id']) && ($_POST['id'] != '')){
			$res = $this->project_model->getSingleProjectDetail($_POST['id']);
			if(!empty($res)){
				$img = $this->project_model->getSingleProjectImage($res[0]['id']);
				if(!empty($img)){
					$data['image'] = 1;
				}
				else
				{
					$data['image'] = 0;
				}
			}
			else
			{
				$data['image'] = 0;
			}
			if($this->session->userdata('user_institute_id') != ''){
				$admin_flag = $this->project_model->check_admin_approve_required($this->session->userdata('user_institute_id'));
				if(!empty($admin_flag)){
					if($admin_flag[0]['admin_status'] == 1){
						$data['admin_flag'] = 1;
					}
					else
					{
						$data['admin_flag'] = 0;
					}
				}
			}
			else
			{
				$data['admin_flag'] = 0;
			}
			echo json_encode($data);
		}
	}
	public function change_status($id)
	{
		$data = array('status'=>3,'admin_status'=>0);
		$result = $this->project_model->project_status_update($id,$data);
		if($result > 0)
		{
			$this->session->set_flashdata('success','Admin approval required to make this project public till then your project status change to private successfully.');
			redirect('project/manage_projects');
		}
		else
		{
			$this->session->set_flashdata('error','failed to deactivate status');
			redirect('project/manage_projects');
		}
	}
	public function status($id,$status)
	{
		if($status == 1){
			$data = array('status'=> 1);
		}
		elseif($status == 0){
			$data = array('status'=> 0);
		}
		else
		{
			$data = array('status'      =>3,'admin_status'=>'');
		}
		$result = $this->project_model->project_status_update($id,$data);
		if($result > 0){
			$this->session->set_flashdata('success','status change successfully');
			redirect('project/manage_projects');
		}
		else
		{
			$this->session->set_flashdata('error','failed to change status');
			redirect('project/manage_projects');
		}
	}
	function createPublicFolder($service, $folderName)
	{
		//echo "string";
		$file        = new Google_Service_Drive_DriveFile();
		$file->setTitle($folderName);
		$file->setMimeType('application/vnd.google-apps.folder');
		$createdFile = $service->files->insert($file, array(
				'mimeType'=> 'application/vnd.google-apps.folder',
			));
		$permission = new Google_Service_Drive_Permission();
		$permission->setValue('');
		$permission->setType('anyone');
		$permission->setRole('reader');
		$service->permissions->insert(
			$createdFile->getId(), $permission);
		return $createdFile->getId();
	}
	/*public function projectDetail($project_id,$createdByUser)
	{
		$data['project'] = $this->project_model->getProjectDetail($project_id);
		if($data['project'][0]['assignmentId'] != 0 && $this->session->userdata('teachers_status') == 1)
		{
			$data['assignment_id'] = $data['project'][0]['assignmentId'];
		}
		$get_institute_id = $this->db->select('instituteId')->from('users')->where('id',$data['project'][0]['userId'])->get()->row_array();
		$data['get_institute_name'] = $this->db->select('instituteName,pageName,id')->from('institute_master')->where('id',$get_institute_id['instituteId'])->get()->row_array();
		if(($data['project'][0]['userId'] == $this->session->userdata('front_user_id') || $data['project'][0]['projectstatus'] == 1 || $get_institute_id['instituteId'] == $this->session->userdata('user_institute_id')) || ($this->session->userdata('user_admin_level') == 1 || $this->session->userdata('user_admin_level') == 4) ){
			$ip     = $this->input->ip_address();
			$viewed = $this->project_model->checkProjectView($project_id,$ip);
			if(!empty($viewed)){
				if($viewed[0]['userView'] == 0){
					$this->project_model->projectViewUpdate($project_id,$ip);
					$this->project_model->viewCountIncrement($project_id);
				}
			}
			else
			{
				$this->project_model->projectViewEntry($project_id,$ip);
				$this->project_model->viewCountIncrement($project_id);
			}
			$data['like_cnt'] = $this->project_model->project_like_count($project_id);			
			$data['view_cnt'] = $this->project_model->project_view_count($project_id);
			$data['user'] = $this->project_model->getCreatedByUser($createdByUser);

			if($this->session->userdata('front_user_id') != '')
			{
				$check_user = $this->db->select('id')->from('project_master')->where('userId',$this->session->userdata['front_user_id'])->where('id',$project_id)->get()->row_array();


				$check_teacher = $this->db->select('*')->from('assignment')->join('project_master','project_master.assignmentId=assignment.id')->where('assignment.teacher_id',$this->session->userdata['front_user_id'])->where('project_master.id',$project_id)->get()->row_array();
				if($this->uri->segment(3) !='' && (!empty($check_user) || !empty($check_teacher)))
				{					
					$data['is_assignment'] = 1;
					$asi =1;
					$data['comment'] = $this->project_model->project_comment($project_id,$asi);
				}
				else
				{
					$data['comment'] = $this->project_model->project_comment($project_id);
				}
			}
			else
			{
				$data['comment'] = $this->project_model->project_comment($project_id);
			}
			
			$this->load->view('project_detail_view',$data);
		}
		else
		{
			$this->session->set_flashdata('error','Project not found.');
			redirect('home');
		}
	}*/	
	
	public function projectDetail_19april($project_id,$createdByUser)
	{
		$data['project'] = $this->project_model->getProjectDetail($project_id);

        if($data['project'][0]['assignmentId'] != 0 && $this->session->userdata('teachers_status') == 1)
		{
			$data['assignment_id'] = $data['project'][0]['assignmentId'];
		}

		$get_institute_id = $this->db->select('instituteId')->from('users')->where('id',$data['project'][0]['userId'])->get()->row_array();
		
		$data['get_institute_name'] = $this->db->select('instituteName,pageName,id')->from('institute_master')->where('id',$get_institute_id['instituteId'])->get()->row_array();

		if(($data['project'][0]['userId'] == $this->session->userdata('front_user_id') || $data['project'][0]['projectstatus'] == 1 || $get_institute_id['instituteId'] == $this->session->userdata('user_institute_id')) || ($this->session->userdata('user_admin_level') == 1 || $this->session->userdata('user_admin_level') == 4) )
        {
        	//echo "inside";exit;
			$ip     = $this->input->ip_address();
			$viewed = $this->project_model->checkProjectView($project_id,$ip);
			//pr($viewed);
			if(!empty($viewed)){
				if($viewed[0]['userView'] == 0){
					$this->project_model->projectViewUpdate($project_id,$ip);
					$this->project_model->viewCountIncrement($project_id);
				}
			}
			else
			{
				$this->project_model->projectViewEntry($project_id,$ip);
				$this->project_model->viewCountIncrement($project_id);
			}
			$data['like_cnt'] = $this->project_model->project_like_count($project_id);
			$data['view_cnt'] = $this->project_model->project_view_count($project_id);
			$data['user'] = $this->project_model->getCreatedByUser($createdByUser);

			if($this->session->userdata('front_user_id') != '')
			{
				//echo "in";exit();
				$check_user = $this->db->select('id')->from('project_master')->where('userId',$this->session->userdata['front_user_id'])->where('id',$project_id)->get()->row_array();
				//echo "shsHHJ";echo "<pre>";print_r($check_user);exit;171781

				$check_teacher = $this->db->select('*')->from('assignment')->join('project_master','project_master.assignmentId=assignment.id')->where('assignment.teacher_id',$this->session->userdata['front_user_id'])->where('project_master.id',$project_id)->get()->row_array();
				//echo "<pre>";print_r($check_teacher);exit;


				if($this->uri->segment(3) !='' && (!empty($check_user) || !empty($check_teacher)))
				{
					$data['is_assignment'] = 1;
					$asi =1;
					$data['comment'] = $this->project_model->project_comment($project_id,$asi);
				}
				else
				{
					//echo "cxcxcxcxc";exit();
					$data['comment'] = $this->project_model->project_comment($project_id);
				}
			}
			else
			{
				$data['comment'] = $this->project_model->project_comment($project_id);
			}

			$this->load->view('project_detail_view',$data);
		}
		else
		{
			$this->session->set_flashdata('error','Project not found.');
			redirect('home');
		}
		//$this->load->view('project_detail_view');
	}

	public function projectDetail_new($project_id,$createdByUser)
	{
		$this->load->model('modelbasic');
		$data['project'] = $this->modelbasic->getValues('project_master','project_master.id,project_master.status as projectstatus,project_master.assignment_status as teacher_status,project_master.assignmentId as assignmentId,project_master.basicInfo,project_master.projectName,project_master.projectPageName,project_master.videoLink,project_master.team_member,project_master.isTeam,project_master.withoutCover,users.firstName,users.lastName,users.profileImage,users.folderId,project_master.userId,project_master.categoryId,user_project_image.image_thumb,user_project_image.id as image_id,project_master.socialFeatures,project_master.created,project_master.copyright,project_master.keyword,project_master.thought,project_master.file_link,category_master.categoryName,institute_master.instituteName,institute_master.pageName,users.instituteId,project_master.view_cnt,project_master.comment_cnt,project_master.like_cnt,users.email,users.contactNo,users.address,users.country,users.city,users.profession,users.company,users.about_me',array('user_project_image.cover_pic'=>1,'project_master.id'=>$project_id),'row_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId"),array("institute_master","institute_master.id=users.instituteId")));
		//$data['project'] = $this->project_model->getProjectDetail($project_id);
		//echo "<pre>";print_r($data['project']);exit();
		$projectImages=$this->modelbasic->getValues('user_project_image','image_thumb,id',array('project_id'=>$project_id),'result_array','',array('order_no','ASC'));		
		if(!empty($projectImages)){
			$proimg = array();
			$proimgId = array();
			foreach($projectImages as $img){
				$proimg[] = $img['image_thumb'];
				$proimgId[] = $img['id'];
			}
			$data['project']['projectImg'] = $proimg;
			$data['project']['projectImgId'] = $proimgId;
		}else{
			$data['project']['projectImg'] = array();
			$data['project']['projectImgId'] = array();
		}
		//if($data['project']['assignmentId'] != 0 && $this->session->userdata('teachers_status') == 1)
		//{
		//	$data['assignment_id'] = $data['project']['assignmentId'];
		//}else{
		//	$data['assignment_id']=0;
		//}
        //echo $this->session->userdata('front_user_id');exit();
		if(($data['project']['userId'] == $this->session->userdata('front_user_id') || $data['project']['projectstatus'] == 1 || $data['project']['instituteId'] == $this->session->userdata('user_institute_id')) || ($this->session->userdata('user_admin_level') == 1 || $this->session->userdata('user_admin_level') == 4) )
		{
			//echo "inside";exit();
			if($this->session->userdata('front_user_id') != ''){
				$condition=array('userId'=>$this->session->userdata('front_user_id'),'projectId'=>$project_id);
			}else{
				$condition=array('ip_address'=>$this->input->ip_address(),'projectId'=>$project_id);
			}
			$viewed=$this->modelbasic->getValues('user_project_views','userLike,userView',$condition,'row_array');
			if(!empty($viewed)){
				$data['project']['userLiked']=$viewed['userLike'];
			}else{
				$data['project']['userLiked']=0;
			}
			if(!empty($viewed) && $viewed['userView']==0){
				$this->modelbasic->_update('user_project_views',$condition,array('userView'=>1,'ip_address'=>$this->input->ip_address()));
			}else{
				$insViewdata = array('projectId' =>$project_id,'ip_address'=>$this->input->ip_address(),'userView'=>1);
				if($this->session->userdata('front_user_id') != ''){
					$insViewdata['userId'] = $this->session->userdata('front_user_id');
				}
				$this->modelbasic->_insert('user_project_views',$insViewdata);
			}
			$data['project']['view_cnt']=(int)$data['project']['view_cnt'] + 1;
			$this->modelbasic->_update('project_master',array('id'=>$project_id),array('view_cnt'=>$data['project']['view_cnt']));
			$data['is_assignment'] = 0;
			if($this->session->userdata('front_user_id') != ''){
				$IsTeacher=$this->modelbasic->getValues('assignment','assignment.teacher_id',array('assignment.teacher_id'=>$this->session->userdata['front_user_id'],'project_master.id'=>$project_id),'row_array',array(array('project_master','project_master.assignmentId=assignment.id')));
				if((($data['project']['userId'] == $this->session->userdata['front_user_id']) || !empty($IsTeacher)) && $this->uri->segment(3) !=''){
					$data['is_assignment'] = 1;
				}
			}
			if($data['is_assignment'] == 1){
				$commentCond=array('user_project_comment.projectId'=>$project_id,'user_project_comment.assignmentId !='=>0);
			}else{
				$commentCond=array('user_project_comment.projectId'=>$project_id,'user_project_comment.assignmentId'=>0);
			}
			$data['comment']=$this->modelbasic->getValues('user_project_comment','user_project_comment.*,users.profileImage',$commentCond,'result_array',array(array('users','users.id=user_project_comment.userId')),'',array('user_project_comment.id','ASC'));
			//print_r($data);die;
			$this->load->view('project_detail_view',$data);
		}
		else{
			$this->session->set_flashdata('error','Project not found.');
			redirect('home');
		}
	}
	
	public function projectDetail($project_id,$createdByUser){
		$this->load->model('modelbasic');
		$data['project'] = $this->modelbasic->getValues('project_master','project_master.id,project_master.status as projectstatus,project_master.assignment_status as teacher_status,project_master.assignmentId as assignmentId,project_master.basicInfo,project_master.projectName,project_master.projectPageName,project_master.videoLink,project_master.team_member,project_master.isTeam,project_master.withoutCover,users.firstName,users.lastName,users.profileImage,users.folderId,project_master.userId,project_master.categoryId,user_project_image.image_thumb,user_project_image.id as image_id,project_master.socialFeatures,project_master.created,project_master.copyright,project_master.keyword,project_master.thought,project_master.file_link,category_master.categoryName,institute_master.instituteName,institute_master.pageName,users.instituteId,project_master.view_cnt,project_master.comment_cnt,project_master.like_cnt,users.email,users.contactNo,users.address,users.country,users.city,users.profession,users.company,users.about_me',array('user_project_image.cover_pic'=>1,'project_master.id'=>$project_id),'row_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId"),array("institute_master","institute_master.id=users.instituteId")));

		$projectImages=$this->modelbasic->getValues('user_project_image','image_thumb,id',array('project_id'=>$project_id),'result_array','',array('order_no','ASC'));	

		if(!empty($projectImages)){
			$proimg = array();
			$proimgId = array();
			foreach($projectImages as $img){
				$proimg[] = $img['image_thumb'];
				$proimgId[] = $img['id'];
			}
			$data['project']['projectImg'] = $proimg;
			$data['project']['projectImgId'] = $proimgId;
		}else{
			$data['project']['projectImg'] = array();
			$data['project']['projectImgId'] = array();
		}

		if($data['project']['assignmentId'] != 0 && $this->session->userdata('teachers_status') == 1)
		{
			$data['assignment_id'] = $data['project']['assignmentId'];
		}else{
			$data['assignment_id']=0;
		}

		if(($data['project']['userId'] == $this->session->userdata('front_user_id') || $data['project']['projectstatus'] == 1 || $data['project']['instituteId'] == $this->session->userdata('user_institute_id')) || ($this->session->userdata('user_admin_level') == 1 || $this->session->userdata('user_admin_level') == 4) ){
			if($this->session->userdata('front_user_id') != ''){
				$condition=array('userId'=>$this->session->userdata('front_user_id'),'projectId'=>$project_id);
			}else{
				$condition=array('ip_address'=>$this->input->ip_address(),'projectId'=>$project_id);
			}
			$viewed=$this->modelbasic->getValues('user_project_views','userLike,userView',$condition,'row_array');
			if(!empty($viewed)){
				$data['project']['userLiked']=$viewed['userLike'];
			}else{
				$data['project']['userLiked']=0;
			}
			if(!empty($viewed) && $viewed['userView']==0){
				$this->modelbasic->_update('user_project_views',$condition,array('userView'=>1,'ip_address'=>$this->input->ip_address()));
			}else{
				$insViewdata = array('projectId' =>$project_id,'ip_address'=>$this->input->ip_address(),'userView'=>1);
				if($this->session->userdata('front_user_id') != ''){
					$insViewdata['userId'] = $this->session->userdata('front_user_id');
				}
				$this->modelbasic->_insert('user_project_views',$insViewdata);
			}
			$data['project']['view_cnt']=(int)$data['project']['view_cnt'] + 1;
			$this->modelbasic->_update('project_master',array('id'=>$project_id),array('view_cnt'=>$data['project']['view_cnt']));
			$data['is_assignment'] = 0;
			if($this->session->userdata('front_user_id') != ''){
				$IsTeacher=$this->modelbasic->getValues('assignment','assignment.teacher_id',array('assignment.teacher_id'=>$this->session->userdata['front_user_id'],'project_master.id'=>$project_id),'row_array',array(array('project_master','project_master.assignmentId=assignment.id')));
				if((($data['project']['userId'] == $this->session->userdata['front_user_id']) || !empty($IsTeacher)) && $this->uri->segment(3) !=''){
					$data['is_assignment'] = 1;
				}
			}
			if($data['is_assignment'] == 1){
				$commentCond=array('user_project_comment.projectId'=>$project_id,'user_project_comment.assignmentId !='=>0);
			}else{
				$commentCond=array('user_project_comment.projectId'=>$project_id,'user_project_comment.assignmentId'=>0);
			}
			$data['comment']=$this->modelbasic->getValues('user_project_comment','user_project_comment.*,users.profileImage',$commentCond,'result_array',array(array('users','users.id=user_project_comment.userId')),'',array('user_project_comment.id','ASC'));
			//print_r($data);die;
			$this->load->view('project_detail_view',$data);
		}else{
			$this->session->set_flashdata('error','Project not found.');
			redirect('home');
		}
	}

	public function rating()
	{
		if(!$this->isLoggedIn()){
			redirect('/');
			exit();
		}
		if(isset($_POST['attrId']) && ($_POST['attrId'] != '') && isset($_POST['proId']) && ($_POST['proId'] != '') && isset($_POST['attrValId']) && ($_POST['attrValId'] != '') && isset($_POST['rating']) && ($_POST['rating'] != '')){
			$res = $this->project_model->check_rating_entry($_POST['proId'],$_POST['attrId'],$_POST['attrValId']);
			if(empty($res)){
				$data = array('attributeValueId'=>$_POST['attrValId'],'attributeId'     =>$_POST['attrId'],'projectId'       =>$_POST['proId'],'userId'          =>$this->session->userdata('front_user_id'),'rating'          =>$_POST['rating']);
				$rs = $this->project_model->insertAttributeValueRating($data);
				$avg= $this->project_model->countAvgOfAttributeValueRating($_POST['attrId'],$_POST['attrValId'],$_POST['proId']);
				$this->project_model->updateAvgToAttributeValue($_POST['attrId'],$_POST['attrValId'],$avg[0]['avg'],$_POST['proId']);
				/*$proDetail=$this->project_model->getProjectDetail($_POST['proId']);
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$rateProjectName=$proDetail[0]['projectName'];
				$rateTo=$this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
				$rateBy=$this->model_basic->loggedInUserInfo();
				$emailTo=$rateTo['email'];
				$from=$emailFrom;
				$nameBy=ucwords($rateBy['firstName'].' '.$rateBy['lastName']);
				$nameTo=ucwords($rateTo['firstName'].' '.$rateTo['lastName']);
				$templateRateTo='Hello <b>'.$nameTo. '</b>,<br /> Following people recently rated your projects on creosouls.<br /><a href="'.base_url().'project/projectDetail/'.$_POST['proId'].'/'.$proDetail[0]['userId'].'">Click here</a>  to view the ratings.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$emailRating=array('to'=>$emailTo,'subject'=>'Summary of ratings on your projects','template'=>$templateRateTo,'fromEmail'=>$from);
				$this->model_basic->sendMail($emailRating);*/
			}
			if($res > 0){
				echo 'yes';
			}
			else
			{
				echo 'no';
			}
		}
	}
	public function image_rating()
	{
		//print_r($_POST);die;
		if(!$this->isLoggedIn()){
			redirect('/');
			exit();
		}
		if(isset($_POST['image_id']) && ($_POST['image_id'] != '') && isset($_POST['proId']) && ($_POST['proId'] != ''))
		{
			$rs = 0;
			$res= $this->project_model->check_rate_like_exists($_POST['image_id']);
			if(empty($res))
			{
				$data = array('project_image_id'=>$_POST['image_id'],'project_id' =>$_POST['proId'],'user_id'=>$this->session->userdata('front_user_id'),'created'=>date('Y-m-d H:i:s'));
				if(isset($_POST['rating']) && ($_POST['rating'] != ''))
				{
					$data['image_rating'] = $_POST['rating'];
					$activity = 'Rated image of';
				}
				else
				{
					$data['image_like'] = $_POST['like'];
					$activity = 'Liked Image of';
				}
				$rs = $this->project_model->insert_data('project_image_rating_like',$data);
			}
			else
			{
				if(isset($_POST['rating']) && $res[0]['image_rating'] == 0 || $res[0]['image_rating'] == '')
				{
					$data = array('image_rating'=>$_POST['rating']);
					$activity = 'Rated image of';
					$rs = $this->project_model->update_data('project_image_rating_like',$data,'project_image_id',$_POST['image_id']);
				}
				else if(isset($_POST['like']) && $res[0]['image_like']==0 || $res[0]['image_like'] == '')
				{
					$data = array('image_like'=>1);
					$activity = 'Liked Image of';
					$rs = $this->project_model->update_data('project_image_rating_like',$data,'project_image_id',$_POST['image_id']);
				}
			}
			if($rs > 0)
			{
				$this->model_basic->insertActivity($_POST['pageName'],$_POST['urlName'],$_POST['proId'],$activity);
				echo 'yes';
			}
			else
			{
				echo 'no';
			}
		}
	}
	public function comment_status()
	{
		if(isset($_POST['cid']) && ($_POST['cid'] != '') && isset($_POST['proid']) && ($_POST['proid'] != '') && isset($_POST['status']) && ($_POST['status'] != '')){
			$res = $this->project_model->change_comment_status($_POST['cid'],$_POST['status']);
			if($_POST['status'] == 1){
				$this->project_model->commentCountIncrement($_POST['proid']);
			}
			else
			{
				$this->project_model->commentCountDecrement($_POST['proid']);
			}
			if($res > 0){
				echo 'yes';
			}
			else
			{
				echo 'no';
			}
		}
	}
	public function like_cnt()
	{
		if(isset($_POST['pro_id']) && ($_POST['pro_id'] != '') && $this->session->userdata('front_user_id') != '')
		{
			$project_id = $_POST['pro_id'];
			$ip     = $this->input->ip_address();
			$viewed = $this->project_model->checkProjectLike($_POST['pro_id']);
			$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
			if(!empty($viewed))
			{
				if($viewed[0]['userLike'] == 0)
				{
					$res = $this->project_model->projectUpdateLike($_POST['pro_id'],$ip);
					if($this->session->userdata('front_user_id') != "")
					{
						$proDetail=$this->project_model->getProjectDetail($_POST['pro_id']);
				        //$emailFlag=$this->model_basic->getValue('user_email_notification_relation','project_like'," `userId` = '".$proDetail[0]['userId']."'");
				        $likeBy                = $this->model_basic->loggedInUserInfo();
				     /* if($emailFlag==1 || $emailFlag=='')
				      {*/
						$proDetail             = $this->project_model->getProjectDetail($_POST['pro_id']);
						$likeProjectName       = $proDetail[0]['projectName'];
						$likeTo                = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
						$emailTo               = $likeTo['email'];
						$from                  = $emailFrom;
						$nameBy                = ucwords($likeBy['firstName'].' '.$likeBy['lastName']);
						$nameTo                = ucwords($likeTo['firstName'].' '.$likeTo['lastName']);
						/*$templateLikeTo        = 'Hello <b>'.$nameTo. '</b>,<br /><b> '.$nameBy.'</b> recently liked your project "<b>' .$likeProjectName.'</b>" on creosouls.<br /><a href="'.base_url().'projectDetail/'.$proDetail[0]['projectPageName'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$emailDetailUnFollowTo = array('to'       =>$emailTo,'subject'  =>'Someone has liked your project','template' =>$templateLikeTo,'fromEmail'=>$from);
						$this->model_basic->sendMail($emailDetailUnFollowTo);*/
						$notificationEntry=array('title'=>'New project like','msg'=>$nameBy.' liked your project '.$likeProjectName,'link'=>'projectDetail/'.$proDetail[0]['projectPageName'],'imageLink'=>'users/thumbs/'.$likeBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>15,'redirectId'=>$_POST['pro_id']);
						$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
						$notificationToOwner=array('notification_id'=>$notificationId,'user_id'=>$proDetail[0]['userId']);
						$this->model_basic->_insert('header_notification_user_relation',$notificationToOwner);
						/*}*/
						/*	$msg['notificationImageUrl'] = '';
					    $msg['notificationTitle'] = 'New Project Liked';
						$msg['notificationMessage']  = ucwords($likeBy['firstName'].' '.$likeBy['lastName']).' liked your project. '.$proDetail[0]['projectName'];
						$msg['notificationType']   = 3;
						$msg['notificationId']     = $proDetail[0]['id'];
						$msg['type']     = 0;
						$this->sendGcmToken($proDetail[0]['userId'],$msg);*/
						
						$msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=> ucwords($likeBy['firstName'].' '.$likeBy['lastName']).' liked your project. '.$proDetail[0]['projectName'],
						'notificationTitle'	=> 'New Project Liked',
						'notificationType'	=> 3,
						'notificationId'	=> $proDetail[0]['id'],
						'notificationImageUrl'	=> ''          	
			          );
					$this->model_basic->sendNotification($proDetail[0]['userId'],$msg);
					}
					if($res > 0)
					{
						$this->model_basic->insertActivity($_POST['pageName'],$_POST['urlName'],$project_id,'Liked');
						$this->project_model->likeCountIncrement($_POST['pro_id']);
						echo 'done';
					}
					else
					{
						echo 'no';
					}
				}
			}
			else
			{
				$res = $this->project_model->projectLikeEntry($_POST['pro_id'],$ip);
				if($this->session->userdata('front_user_id') != "")
				{
					$proDetail=$this->project_model->getProjectDetail($_POST['pro_id']);
				    //$emailFlag=$this->model_basic->getValue('user_email_notification_relation','project_like'," `userId` = '".$proDetail[0]['userId']."'");
				    $likeBy  = $this->model_basic->loggedInUserInfo();
			    /*  if($emailFlag==1 || $emailFlag=='')
			      {*/
					$proDetail             = $this->project_model->getProjectDetail($_POST['pro_id']);
					$likeProjectName       = $proDetail[0]['projectName'];
					$likeTo                = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
					$emailTo               = $likeTo['email'];
					$from                  = $emailFrom;
					$nameBy                = ucwords($likeBy['firstName'].' '.$likeBy['lastName']);
					$nameTo                = ucwords($likeTo['firstName'].' '.$likeTo['lastName']);
					/*$templateLikeTo        = 'Hello <b>'.$nameTo. '</b>,<br /><b> '.$nameBy.'</b> recently liked your project "<b>' .$likeProjectName.'</b>" on creosouls.<br /><a href="'.base_url().'project/projectDetail/'.$_POST['pro_id'].'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$emailDetailUnFollowTo = array('to'       =>$emailTo,'subject'  =>'Someone has liked your project','template' =>$templateLikeTo,'fromEmail'=>$from);
					$this->model_basic->sendMail($emailDetailUnFollowTo);*/
					$notificationEntry=array('title'=>'New project like','msg'=>$nameBy.' liked your project '.$likeProjectName,'link'=>'projectDetail/'.$proDetail[0]['projectPageName'],'imageLink'=>'users/thumbs/'.$likeBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>15,'redirectId'=>$_POST['pro_id']);
					$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
					$notificationToOwner=array('notification_id'=>$notificationId,'user_id'=>$proDetail[0]['userId']);
					$this->model_basic->_insert('header_notification_user_relation',$notificationToOwner);
				/*  }*/
				       /* $msg['notificationImageUrl'] = '';
				        $msg['notificationTitle'] = 'New Project Liked';
						$msg['notificationMessage']  = ucwords($likeBy['firstName'].' '.$likeBy['lastName']).' liked your project. '.$proDetail[0]['projectName'];
						$msg['notificationType']   = 3;
					    $msg['notificationId']     = $proDetail[0]['id'];
					    $msg['type']     = 0;
					    $this->sendGcmToken($proDetail[0]['userId'],$msg);*/

					    $msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=> ucwords($likeBy['firstName'].' '.$likeBy['lastName']).' liked your project. '.$proDetail[0]['projectName'],
						'notificationTitle'	=> 'New Project Liked',
						'notificationType'	=> 3,
						'notificationId'	=> $proDetail[0]['id'],
						'notificationImageUrl'	=> ''          	
			          );
					$this->model_basic->sendNotification($proDetail[0]['userId'],$msg);
				}
				if($res > 0)
				{
					$this->model_basic->insertActivity($_POST['pageName'],$_POST['urlName'],$project_id,'Liked');
					$this->project_model->likeCountIncrement($_POST['pro_id']);
					echo 'done';
				}
				else
				{
					echo 'no';
				}
			}
		}
	}
	public function updateReadCount()
	{
		if($this->session->userdata('front_user_id') != '')
		{
			$this->model_basic->_updateWhere('header_notification_user_relation',array('user_id'=>$this->session->userdata('front_user_id'),'status'=>0),array('status'=>1));
			echo 'done';
		}
	}
	public function follow_user($project_id,$uid)
	{
		$result = $this->project_model->checkFollowingOrNot($uid);
		if(empty($result)){
			$data = array('followingUser'=>$uid,'userId'       =>$this->session->userdata('front_user_id'),'created'      =>date('Y-m-d H:i:s'));
			$res = $this->project_model->follow_user($data);
			if($res > 0){
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$this->session->set_flashdata('success', 'You are now following this user.');
				$followBy            = $this->model_basic->loggedInUserInfo();
				$followTo            = $this->model_basic->loggedInUserInfoById($uid);
				$nameBy              = ucwords($followBy['firstName'].' '.$followBy['lastName']);
				$nameTo              = ucwords($followTo['firstName'].' '.$followTo['lastName']);
				$emailBy             = $followBy['email'];
				$emailTo             = $followTo['email'];
				//$subjectBy           = 'You are now following '.$nameTo.' on creosouls';
				$subjectTo           = 'Congratulations! You have a new follower on creosouls';
				$from                = $emailFrom;
				//$templateBy          = 'Hello<b> '.$nameBy. '</b>,<br /> You are now following <b>'.$nameTo.'</b> on creosouls. You will be notified about latest creations by '.$nameTo.'.<br /><a href="'.base_url().'user/userDetail/'.$uid.'">Click here</a> to view '.$nameTo.'‘s profile.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$templateTo          = 'Hello <b>'.$nameTo.'</b>,<br /> <b>'.$nameBy.'</b> started following you on creosouls.<br /><a href="'.base_url().'user/userDetail/'.$this->session->userdata('front_user_id').'">Click here</a> to view '.$nameBy.'‘s profile.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$emailDetailFollowTo = array('to'       =>$emailTo,'subject'  =>$subjectTo,'template' =>$templateTo,'fromEmail'=>$from);
				$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','follow_unfollow',array('userId'=>$uid));
				if($emailSetting == 1)
				{
					//$this->model_basic->sendMail($emailDetailFollowTo);
				}

				$notificationEntry=array('title'=>'New follower','msg'=>'Now '.$nameBy.' is following you on creosouls.','link'=>'user/userDetail/'.$this->session->userdata('front_user_id'),'imageLink'=>'users/thumbs/'.$followBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>5,'redirectId'=>$this->session->userdata('front_user_id'));
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

				$notificationToFollowee=array('notification_id'=>$notificationId,'user_id'=>$uid);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToFollowee);
				
				/*$msg['notificationImageUrl'] = '';
				$msg['notificationTitle'] = 'New User Following';
				$msg['notificationMessage']  = $nameBy.'  started following you.';
				$msg['notificationType']   = 5;
			    $msg['notificationId']     = $followBy['id'];
			    $msg['type']     = 0;
				$this->sendGcmToken($followTo['id'],$msg);*/

				$msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=> $nameBy.'  started following you.',
						'notificationTitle'	=> 'New User Following',
						'notificationType'	=> 5,
						'notificationId'	=>  $followBy['id'],
						'notificationImageUrl'	=> ''          	
			          );
					$this->model_basic->sendNotification($followTo['id'],$msg);

				redirect('project/projectDetail/'.$project_id.'/'.$uid);
			}
			else
			{
				$this->session->set_flashdata('fail', 'failed to follow this user.');
				redirect('project/projectDetail/'.$project_id.'/'.$uid);
			}
		}
		else
		{
			redirect('project/projectDetail/'.$project_id.'/'.$uid);
		}
	}
	public function unfollow_user($project_id,$uid)
	{
		$res = $this->project_model->unfollow_user($uid);
		if($res > 0){
			$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
			$this->session->set_flashdata('success', 'You are now unfollowing this user.');
			$unfollowBy            = $this->model_basic->loggedInUserInfo();
			$unfollowTo            = $this->model_basic->loggedInUserInfoById($uid);
			$nameBy                = ucwords($unfollowBy['firstName'].' '.$unfollowBy['lastName']);
			$nameTo                = ucwords($unfollowTo['firstName'].' '.$unfollowTo['lastName']);
			$emailBy               = $unfollowBy['email'];
			$subjectBy             = 'You are no more following '.$nameTo.' on creosouls';
			$from                  = $emailFrom;
			$templateBy            = 'Hello<b> '.$nameBy. '</b>,<br /> You are no more following <b>'.$nameTo.'</b> on creosouls. <br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$emailDetailunfollowBy = array('to'       =>$emailBy,'subject'  =>$subjectBy,'template' =>$templateBy,'fromEmail'=>$from);
			//$this->model_basic->sendMail($emailDetailunfollowBy);
			redirect('project/projectDetail/'.$project_id.'/'.$uid);
		}
		else
		{
			$this->session->set_flashdata('fail', 'failed to follow this user.');
			redirect('project/projectDetail/'.$project_id.'/'.$uid);
		}
	}
	public function add_comment($project_id,$uid)
	{
/*		$this->form_validation->set_rules('name','Name','trim|required|xss_clean');
		$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('comment','Comment','trim|required|xss_clean');
*/
		if($_POST['comment']!='')
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$comment = $_POST['comment'];
			$data   = array(
					'name' 		=>ucwords($name),
					'email'    	=>$email,
					'comment'  	=>ucfirst($comment),
					'projectId'	=>$project_id,
					'userId'   	=>$this->session->userdata('front_user_id'),
					'created'  	=>date('Y-m-d H:i:s'),
					'status'   	=>1
				);
			$res = $this->project_model->add_comment($data);
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$this->model_basic->insertActivity($_POST['pageName'],$_POST['urlName'],$project_id,'Commented');
				$this->project_model->commentCountIncrement($project_id);
				$proDetail=$this->project_model->getProjectDetail($project_id);
				$emailFlag=$this->model_basic->getValue('user_email_notification_relation','project_comment'," `userId` = '".$proDetail[0]['userId']."'");
				$commentBy          = $this->model_basic->loggedInUserInfoById($uid);

				$proDetail          = $this->project_model->getProjectDetail($project_id);
				$commentProjectName = $proDetail[0]['projectName'];
				$commentTo          = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
				$emailTo            = $commentTo['email'];
				$from               = $emailFrom;
				$nameBy             = ucwords($commentBy['firstName'].' '.$commentBy['lastName']);
				$nameTo             = ucwords($commentTo['firstName'].' '.$commentTo['lastName']);
				
			   if($emailFlag==1 || $emailFlag=='')
				{					
					
					$templateCommentTo  = 'Hello <b>'.$nameTo. '</b>, <br /><b>'.$nameBy.'</b> recently commented on your project "<b>' .$commentProjectName.'</b>" on creosouls.<br /><a href="'.base_url().'projectDetail/'.$proDetail[0]['projectPageName'].'">Click here</a>  to view the comment.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$emailDetailComment = array('to' =>$emailTo,'subject'  =>'Someone has commented on  your project','template' =>$templateCommentTo,'fromEmail'=>$from);
					//$this->model_basic->sendMail($emailDetailComment);
				}
				
				$notificationEntry=array('title'=>'New project comment','msg'=>$nameBy.' commented on your project '.$commentProjectName,'link'=>'projectDetail/'.$proDetail[0]['projectPageName'],'imageLink'=>'users/thumbs/'.$commentBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>14,'redirectId'=>$project_id);
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
				$notificationToOwner=array('notification_id'=>$notificationId,'user_id'=>$proDetail[0]['userId']);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToOwner);
				//app push notification
				/*$msg['notificationImageUrl'] = '';
				$msg['notificationTitle'] = 'New Comment';
				$msg['notificationMessage']  = ucwords($commentBy['firstName'].' '.$commentBy['lastName']).' commented on your project '. $proDetail[0]['projectName'];
				$msg['notificationType']   = 3;
			    $msg['notificationId']     = $proDetail[0]['id'];
			    $msg['type']     = 0;
				$this->sendGcmToken($proDetail[0]['userId'],$msg);*/
				
				$msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=> ucwords($commentBy['firstName'].' '.$commentBy['lastName']).' commented on your project '. $proDetail[0]['projectName'],
						'notificationTitle'	=> 'New Comment',
						'notificationType'	=> 3,
						'notificationId'	=> $proDetail[0]['id'],
						'notificationImageUrl'	=> ''          	
			          );
					$this->model_basic->sendNotification($proDetail[0]['userId'],$msg);
				//$this->session->set_flashdata('success', 'Comment Added successfully');
				echo 'true';
				//redirect('project/projectDetail/'.$project_id.'/'.$this->session->userdata('front_user_id'));
			}
			else
			{
				//$this->session->set_flashdata('fail', 'Faild to add comment');
				echo 'false';
				//redirect('project/projectDetail/'.$project_id.'/'.$this->session->userdata('front_user_id'));
			}
		}
		else
		{
			echo 'false';
		}
	}
	public function manage_projects()
	{
		if($this->session->userdata('front_user_id') !='')
		{
			$data['project'] = $this->project_model->getAllUserProject();
			$this->load->view('manage_project_view',$data);
		}
		else
		{
			$this->session->set_flashdata('error', 'Please Login.');
			redirect('home');
		}
		
	}
	public function cat_data()
	{
		if(isset($_POST['catid']) && $_POST['catid'] != ''){
			$res = $this->project_model->getCategoryAttribute($_POST['catid']);
			if(!empty($res)){
				echo json_encode($res);
			}
			else
			{
				echo '';
			}
		}
	}
	public function video_check($video)
    {
       if(!preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$video))
            {
              $this->form_validation->set_message('video_check', 'URL Not valid');
		      return FALSE;
		    }
            else
            {
              return TRUE;
            }
    }
	public function edit_project($project_id,$assignment_id='')
	{
		//print_r($_POST);die;
		$this->form_validation->set_rules('projectName','Project Name','trim|required|xss_clean');
		$this->form_validation->set_rules('basicInfo','Project Information','trim|xss_clean');
		$this->form_validation->set_rules('categoryId','Project Category','trim|required|xss_clean');
		$this->form_validation->set_rules('projectType','Project Type','trim|required|xss_clean');
		//$this->form_validation->set_rules('requiresFunding','Require Funding','trim|required|xss_clean');
		$this->form_validation->set_rules('socialFeatures','Social Features','trim|required|xss_clean');
		$this->form_validation->set_rules('projectStatus','Project Status','trim|required|xss_clean');
		$this->form_validation->set_rules('keywords','Keywords','trim|xss_clean');
		$this->form_validation->set_rules('thought','Thought Process','trim|xss_clean');
		//$this->form_validation->set_rules('title','Title','trim|xss_clean|required');
		if(isset($_POST['image']) &&($_POST['image'] !='')){
			$this->form_validation->set_rules('image','Image','xss_clean|required');
	    }
		if(isset($_POST['categoryId']) &&($_POST['categoryId'] == 4 || $_POST['categoryId'] == 5 || $_POST['categoryId'] == 6))
		{
			

		  $this->form_validation->set_rules('videoLink','YouTube Video Link','required|trim|xss_clean|callback_video_check|prep_url');
		}
		else
		{
			if(isset($_POST['videoLink']) &&($_POST['videoLink'] !=''))
			{
				
			   $this->form_validation->set_rules('videoLink','YouTube Video Link','trim|xss_clean|callback_video_check|prep_url');
		    }
		}
			if(isset($_POST['cover_pic']) &&($_POST['cover_pic'] !='')){
				$this->form_validation->set_rules('cover_pic','cover picture','xss_clean|required');
		    }
		
		if($this->form_validation->run())
		  {
			$projectName     = $_POST['projectName'];
			$basicInfo       = $_POST['basicInfo'];
			$categoryId      = $_POST['categoryId'];
			$projectType     = $_POST['projectType'];
			$requiresFunding = 0;
			//$showreel  = $_POST['showreel'];
			$socialFeatures  = $_POST['socialFeatures'];
			$projectStatus   = $_POST['projectStatus'];
			$copyright   = $_POST['copyright'];
			$thought   = $_POST['thought'];
			$keyword   = $_POST['keywords'];
			/*if(isset($showreel) && !empty($showreel))
			{
				$showreel=1;
			}
			else
			{
				$showreel='0';
			}*/

			//$data  = array('projectName'    =>$projectName,'basicInfo'      =>$basicInfo,'categoryId'     =>$categoryId,'projectType'    =>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures' =>$socialFeatures,'projectStatus'  =>$projectStatus,'copyright'  =>$copyright,'thought'=>$thought,'keyword'=>$keyword,"showreel"=>$showreel);
			$data  = array('projectName'    =>$projectName,'basicInfo'      =>$basicInfo,'categoryId'     =>$categoryId,'projectType'    =>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures' =>$socialFeatures,'projectStatus'  =>$projectStatus,'copyright'  =>$copyright,'thought'=>$thought,'keyword'=>$keyword);

			if(isset($_POST['videoLink']) &&($_POST['videoLink'] !=''))
			{
				$title = $this->input->post('title',TRUE);
				$videoLinkArr = explode("watch?v=",$_POST['videoLink']);
				$data['videoLink']    = $videoLinkArr[1];
			}
			if(isset($_POST['projectFileLink']))
			{
				$data['file_link'] = $this->input->post('projectFileLink',TRUE);
			}
		
			if(isset($_POST['Draft'])){
				$status       = 0;
				$admin_status = '';
			}
			elseif(isset($_POST['Private'])){
				$status       = 3;
				$admin_status = '';
			}
			else
			{
				if($this->session->userdata('user_institute_id') != ''){
					$pro_data = $this->project_model->getSingleProjectDetail($project_id);
					if(!empty($pro_data) && $pro_data[0]['competitionId'] != 0){
						$status       = 1;
						$admin_status = '';
					}
					else
					{
						$admin_flag = $this->project_model->check_admin_approve_required($this->session->userdata('user_institute_id'));
						if(!empty($admin_flag)){
							if($admin_flag[0]['admin_status'] == 1){
								$status       = 3;$admin_status = 0;
								$flashMsg='Project updated and admin approval required to make this project public till then your project status change to private successfully.';
							}
							else
							{
								$status       = 1;$admin_status = '';
							}
						}
					}
				}
				else
				{
					$status       = 1;
					$admin_status = '';
				}
			}
			if(isset($assignment_id) && $assignment_id!='')
			{
				$data['assignmentId'] = $assignment_id;

				$teachers_status=$this->db->select('assignment_status,assignmentId')->from('project_master')->where('assignmentId',$assignment_id)->where('id',$project_id)->get()->result_array();

				if($teachers_status[0]['assignment_status'] == 2)
				{
					$data['assignment_status'] = 4 ;	
				}
				//print_r($teachers_status);die;				
			}
			$data['status'] = $status;
			$data['admin_status'] = $admin_status;
			$res = $this->project_model->update_project($project_id,$data);
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$proDetail          = $this->project_model->getProjectDetail($project_id);
				$newAddedPrjectName = $proDetail[0]['projectName'];
				$addedBy            = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
				$addedByName        = ucwords($addedBy['firstName'].' '.$addedBy['lastName']);
				/*$addedByEmail       = $addedBy['email'];
				$from               = $emailFrom;
				$subjectBy          = 'Successfully added project "'. $newAddedPrjectName.'" to creosouls';
				$templateAddedBy    = 'Hello <b>'.$addedByName. '</b>,<br />Your project "<b>' .$newAddedPrjectName.'</b>" is added successfully to creosouls.<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$sendEmailToAddUser = array('to' =>$addedByEmail,'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
				$this->model_basic->sendMail($sendEmailToAddUser);*/

				$notificationEntry=array('title'=>'Existing project edited','msg'=>$addedByName.' made some changes in his project '.$newAddedPrjectName,'link'=>'projectDetail/'.$proDetail[0]['projectPageName'],'imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>6,'redirectId'=>$project_id);
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

				$instituteAdminUserId=$this->model_basic->getValueArray('institute_master','adminId',array('id'=>$addedBy['instituteId']));
				$instituteAdminUsersDetail   = $this->model_basic->loggedInUserInfoById($instituteAdminUserId);
				/*$instituteAdminName     = ucwords($instituteAdminUsersDetail['firstName'].' '.$instituteAdminUsersDetail['lastName']);
				$instituteAdminEmail    = $instituteAdminUsersDetail['email'];
				$subjectToinstituteAdmin    = ''.$addedByName.' added a new project on creosouls.';
				$templateInstituteAdmin    = 'Hello <b>'.$instituteAdminName. '</b>,<br />The user '.$addedByName.' of your institute has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'projectDetail/'.$projectPageName.'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$sendEmailToInstituteAdmin  = array('to'=>$instituteAdminEmail,'subject'  =>$subjectToinstituteAdmin,'template' =>$templateInstituteAdmin,'fromEmail'=>$from);
				$this->model_basic->sendMail($sendEmailToInstituteAdmin);*/
				$notificationToInstituteAdmin=array('notification_id'=>$notificationId,'user_id'=>$instituteAdminUserId);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToInstituteAdmin);

				$msg = array (
					'body' 	=> '',
					'title'	=> '',
					'aboutNotification'	=> ucwords($addedByName).' made some changes in his project',
					'notificationTitle'	=> 'Existing project edited',
					'notificationType'	=> 3,
					'notificationId'	=> $projectId,
					'notificationImageUrl'	=> ''          	
	          	);
				$this->model_basic->sendNotification($instituteAdminUserId,$msg);

				$followedUsers = $this->project_model->getFollowedUsers($proDetail[0]['userId']);
				if($status==1)
				{
					if(!empty($followedUsers))
					{
						foreach($followedUsers as $key)
						{
							/*$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
							$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
							if($emailSetting==1)
							{
								$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
								$followedUsersEmail    = $followedUsersDetail['email'];
								$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
								$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
								$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
								$this->model_basic->sendMail($sendEmailToFolledUser);
							}*/
							$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
							$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);
							
						}
					}
				}
				if($status==3)
				{
					if(!empty($followedUsers))
					{
						foreach($followedUsers as $key)
						{
							$followedUsersDetail   = $this->model_basic->loggedInUserInfoById($key['userId']);
							if($followedUsersDetail['instituteId'] == $addedBy['instituteId'])
							{
								/*$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','new_project',array('userId'=>$key['userId']));
								if($emailSetting==1)
								{
									$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
									$followedUsersEmail    = $followedUsersDetail['email'];
									$subjectTo             = ''.$addedByName.' added a new project on creosouls.';
									$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br />The user '.$addedByName.' whom you are following on creosouls has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
									$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
									$this->model_basic->sendMail($sendEmailToFolledUser);
								}*/
								$notificationToFolledUser=array('notification_id'=>$notificationId,'user_id'=>$key['userId']);
								$this->model_basic->_insert('header_notification_user_relation',$notificationToFolledUser);
							}
						}
					}
				}

				if(isset($assignment_id) && $assignment_id!='')
				{
					$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$this->session->userdata('front_user_id')));
					$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignment_id));
					$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));
					$message='Hello Sir,<br /> Assignment has been Re-submitted .<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br />  Thank You.';	
					$emailData = array('to'=>$get_teacher_data['email'],'fromEmail'=>$get_user_data['email'],'subject'=>'Assignment has been re -submitted to you','template'=>$message);	  
					//$sendMail = $this->model_basic->sendMail($emailData);

					$assEditNotificationEntry=array('title'=>'Assignment re-submitted','msg'=>$addedByName.' re-submitted assignment project '.$newAddedPrjectName.' for assignment that you assigned to him.','link'=>'projectDetail/'.$proDetail[0]['projectPageName'].'/1','imageLink'=>'users/thumbs/'.$addedBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$assignment_id);
					$assEditNotificationId=$this->model_basic->_insert('header_notification_master',$assEditNotificationEntry);

					$editNotificationToTeacher=array('notification_id'=>$assEditNotificationId,'user_id'=>$get_assignment_data['teacher_id']);
					$this->model_basic->_insert('header_notification_user_relation',$editNotificationToTeacher);
					
				}
				if(isset($_POST['member'])){
					$mem = $_POST['member'];
				}
				else
				{
					$mem = array();
				}
				$project_team = $this->project_model->getSingleProjectTeam($project_id);
				if(isset($project_team['all_team']) && !empty($project_team['all_team'])){
					foreach($project_team['all_team'] as $val){
						if(!empty($val)){
							if(!in_array($val, $mem)){
								$this->project_model->delete_member($project_id,$val);
							}
						}
					}
				}
				if(!empty($mem)){
					foreach($mem as $row){
						if(!in_array($row, $project_team['all_team'])){
							$det = array('projectId'=>$project_id,'userId'   =>$row);
							$this->project_model->add_member($det);
						}
					}
				}
				 $cover_pic = $this->input->post('cover_pic',TRUE);
				 $img_ids      = $_POST['image'];
				$project_details = $this->project_model->getSingleProjectDetail($project_id);
				$project_img     = $this->project_model->getSingleProjectImage($project_details[0]['id']);
				if(!empty($project_img)){
					foreach($project_img as $row){
						$imageId[] = $row['id'];
					}
				}
				else
				{
					$imageId[] = array();
				}
				$i = 0;$k = 0;$z=1;
				foreach($img_ids as $row)
				{
					$this->load->model('project_model');
					$data2 = array("project_id"=>$project_details[0]['id'],'order_no'=>$z);
					if($cover_pic == $row){
						$data2['cover_pic'] = 1;
					}
					else
					{
						$data2['cover_pic'] = 0;
					}
					$img_detail = $this->project_model->getImgDetail($row);
					/*if($img_detail[0]['content_type'] == 0){
						$data2['prize'] = $_POST['prize'][$k];
						$k++;
					}*/
					if(isset($_POST['watermark_text_edit']) && $this->input->post('watermark_text_edit') != '')
					{
						//pr($_POST);
						$text = $this->input->post('watermark_text_edit');
						$color = 'ffffff';
						if($this->input->post('watermark_color') != '')
						{
							$color = $this->input->post('watermark_color');
						}
						if(file_exists(file_upload_s3_path().'project/thumb_big/'.$img_detail[0]['image_thumb']))
						{
							//echo "string";die;
							$this->watermark($img_detail[0]['image_thumb'],$text,'middle','center',$color);
						}
					}
					

					$this->project_model->upadate_info($data2,$row);
					$i++;
					if(!in_array($row, $imageId)){
						$imageName = $this->model_basic->getValue($this->db->dbprefix('user_project_image'),"image_thumb"," `id` = '".$row."' ");
						$result =$this->model_basic->getValue('users',"google_drive_setting"," `id` = '".$this->session->userdata('front_user_id')."' ");
						if($result == 1){
							$this->session->set_userdata('profileImageData',file_upload_s3_path().'project/'.$imageName);
							$this->session->set_userdata('file_id',$row);
							$this->uploadFile();
							unlink(file_upload_s3_path().'project/'. $imageName);
						}
					}
					$z++;
				}
				$attribute = $this->project_model->getCategoryAttribute($categoryId);
				$deleteOldRelation = $this->db->where('projectId',$project_id)->delete('project_attribute_relation');
				if(!empty($attribute)){
					foreach($attribute as $row){
						$temp = array();
						$atti_id = $row['attributeId'];
						if($_POST['attribute'.$atti_id] != ''){

							

							$arr = explode(',',$_POST['attribute'.$atti_id]);
							if(!empty($row['atrribute_value'])){
								$k = 0;
								foreach($row['atrribute_value'] as $val){
									if(!in_array($val,$arr)){
										$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$val);
										if(!empty($vid)){
											$sd = $this->project_model->delete_relation_attributeValue($project_id,$vid[0]['attributeId'],$vid[0]['id']);
										}
									}
									foreach($arr as $ar){
										if(($val != $ar)){
											$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
											if(empty($vid)){
												$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
												$temp[] = $this->project_model->add_attribute_value($det);
											}
											else
											{
												$relation = $this->project_model->get_relation_exist($project_id,$row['attributeId'],$vid[0]['id']);
												if(empty($relation)){
													if(!in_array($vid[0]['id'],$temp)){
														$det = array('projectId'       =>$project_id,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$vid[0]['id']);
														$this->project_model->add_project_attribute($det);
													}
												}
											}
										}
									}
									$k++;
								}
							}
							else
							{
								foreach($arr as $ar){
									$vid = $this->project_model->get_attribute_value_id($row['attributeId'],$ar);
									if(empty($vid)){
										$det = array('attributeId'   =>$row['attributeId'],'attributeValue'=>$ar);
										$temp[] = $this->project_model->add_attribute_value($det);
									}
								}
							}
						}
						if(!empty($temp)){
							foreach($temp as $dt){
								$det = array('projectId'       =>$project_id,'attributeId'     =>$row['attributeId'],'attributeValueId'=>$dt);
								$this->project_model->add_project_attribute($det);
							}
						}
					}
				}

				if(isset($flashMsg))
				{
					$this->session->set_flashdata('success',$flashMsg);
					redirect('project/projectDetail/'.$project_id.'/'.$project_details[0]['userId']);
				}
				else
				{
					if(isset($assignment_id) && $assignment_id!='')
					{					
						//$this->session->set_flashdata('success', 'Assignment edited successfully');
						//redirect('assignment/assignment_detail/'.$assignment_id.'/'.$this->session->userdata('front_user_id').'/1');
						if($teachers_status[0]['assignment_status'] == 3 || $teachers_status[0]['assignment_status'] == 1)						
						{
							redirect('assignment/assignment_detail/'.$assignment_id.'/'.$this->session->userdata('front_user_id'));
						}
						else 
						{
						redirect('assignment/assignment_detail/'.$assignment_id.'/'.$this->session->userdata('front_user_id').'/1');
						}	
					}
					else
					{					
						$this->session->set_flashdata('success', 'Project edited successfully');
						redirect('project/projectDetail/'.$project_id.'/'.$project_details[0]['userId']);
						
					}

				}
				
			}
			else
			{
				if(isset($assignment_id) && $assignment_id!='')
				{					
					$this->session->set_flashdata('fail', 'Faild to edit Assignment');
					redirect('assignment/assignment_detail/'.$assignment_id.'/'.$this->session->userdata('front_user_id'));
				}
				else
				{					
					$this->session->set_flashdata('fail', 'Faild to edit project');
					redirect('project/manage_projects');
				}
			}
		}
		else
		{
			$data['project_details'] = $this->project_model->getSingleProjectDetail($project_id);
			$data['project_team'] = $this->project_model->getSingleProjectTeam($project_id);
			/*	$data['project_image']=$this->project_model->getSingleProjectImage($project_id);*/
			$data['projectCategory'] = $this->project_model->getProjectCategory();
			//$data['member'] = $this->project_model->getMember();
			$data['attribute'] = $this->project_model->getCategoryAttribute($data['project_details'][0]['categoryId']);
			if(isset($assignment_id) && $assignment_id!='')
			{
				$data['assignment_Id'] = $assignment_id;
			}
			//echo "project ";print_r($data);die;
			$this->load->view('edit_project_view',$data);
		}
	}
	public function project_rating()
	{
		if(!$this->isLoggedIn()){
			redirect('/');
			exit();
		}
		if(isset($_POST['proId']) && ($_POST['proId'] != ''))
		{
			$rs = 0;
			$res= $this->project_model->check_project_rating($_POST['proId']);
			if(empty($res))
			{
				$data = array('projectId' =>$_POST['proId'],'userId'=>$this->session->userdata('front_user_id'),'created'=>date('Y-m-d H:i:s'),'rating'=>$_POST['rating']);
				$rs = $this->project_model->insert_data('project_rating',$data);
			}
			else
			{
				$data = array('projectId' =>$_POST['proId'],'userId'=>$this->session->userdata('front_user_id'),'created'=>date('Y-m-d H:i:s'),'rating'=>$_POST['rating']);
				$rs = $this->project_model->update_rating_data('project_rating',$data,$_POST['proId']);
			}

			$avg_rating=$this->db->select(' AVG(`rating`) As avg_r')->from('project_rating')->where('projectId',$_POST['proId'])->get()->row_array();
			$ratingData = array('avg_project_rating'=>$avg_rating['avg_r']);

			$rating_update = $this->project_model->update_rating_data('project_rating',$ratingData,$_POST['proId']);	


			if($rs > 0)
			{
				$this->model_basic->insertActivity($_POST['pageName'],$_POST['urlName'],$_POST['proId'],'Rated');
				echo 'yes';
			}
			else
			{
				echo 'no';
			}
		}
	}
	public function project_avg_rating($proId)
	{
		return $this->project_model->project_avg_rating($proId);
    }
    public function project_rating_by_user($proId)
	{
		return $this->project_model->project_rating_by_user($proId);
    }
	public function view($project_id)
	{
		$data['project_details'] = $this->project_model->getSingleProjectDetail($project_id);
		$data['project_team'] = $this->project_model->getSingleProjectTeam($project_id);
		/*	$data['project_image']=$this->project_model->getSingleProjectImage($project_id);*/
		$data['projectCategory'] = $this->project_model->getProjectCategory();
		$data['member'] = $this->project_model->getMember();
		$data['attribute'] = $this->project_model->getCategoryAttribute($data['project_details'][0]['categoryId']);
		$this->load->view('project_table_detail_view',$data);
	}
	public function delete($project_id)
	{
		$projectAssignBy = $this->model_basic->getData('project_master','assignmentId,competitionId',array('id'=>$project_id));
		if($projectAssignBy['competitionId'] == 0 && $projectAssignBy['assignmentId'] ==0 )
		{
			$res = $this->project_model->deleteProject($project_id);
			if($res)
			{
				if($this->model_basic->insertActivity('Manage Projects',base_url().'project/manage_projects',$project_id,'Delete'))
				{
					$this->session->set_flashdata('success', 'Project deleted successfully');
				}
			}
			else
			{
				$this->session->set_flashdata('fail', 'Fail to delete project');
			}
		}
		else
		{
			if($projectAssignBy['competitionId'] != 0)
			{
				$get_competition_name = $this->model_basic->getData('competitions','name',array('id'=>$projectAssignBy['competitionId']));
				$this->session->set_flashdata('success', 'Fail to delete '.$get_competition_name["name"].' Competition Project');
			}
			if($projectAssignBy['assignmentId'] !=0 )
			{
				$get_assignment_name = $this->model_basic->getData('assignment','assignment_name',array('id'=>$projectAssignBy['assignmentId']));
				$this->session->set_flashdata('success', 'Fail to delete '.$get_assignment_name["assignment_name"].' Assignment Project');
			}
		}
		
		redirect('project/manage_projects');
	}
	public function sendGcmToken($userId,$msg)
	{
		 define( 'API_ACCESS_KEY', 'AIzaSyCAVHevvPy-yAZUbJdRRF2RLf8DTQcDcGw' );
		 //$registrationIds = array( $_GET['id'] );
		    $deviceId = $this->model_basic->getValue('users','deviceId'," `id` = '".$userId."'");
			if(isset($deviceId)&&$deviceId!='')
			{
			    $gcmToken = $this->model_basic->getValue('gcm','gcmToken'," `deviceId` = '".$deviceId."'");
				if(isset($gcmToken)&& $gcmToken!='')
				{
					// prep the bundle
					/*$msg = array
					(
						'message' 	=> 'here is a message. message',
						'title'		=> 'This is a title. title',
						'subtitle'	=> 'This is a subtitle. subtitle',
						'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
						'vibrate'	=> 1,
						'sound'		=> 1,
						'largeIcon'	=> 'large_icon',
						'smallIcon'	=> 'small_icon'
					);*/
					/*    int type,
					    int notificationId,
					    int notificationType,
					    String notificationTitle,
					    String notificationMessage,
					    String notificationImageUrl,*/
					//	print_r($msg);
					  $gcmId = array($gcmToken);
					$fields = array
					(
						'registration_ids' 	=> $gcmId,
						'data'			=>  array('default'=>$msg)
					);
					//print_r($fields);die;
					$headers = array
					(
						'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
					);
					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$result = curl_exec($ch );
					curl_close( $ch );
					/*echo $result;die;*/
				}
			}
	       return;
	}
	public function updateMoveDataToDriveSetting(){
		if(isset($_POST['moveToDrive'])){
			$moveToGoogleDriveSetting = $_POST['moveToDrive'];
			if($moveToGoogleDriveSetting == 1){
				$imageData = $this->project_model->getAllImageData();
				//print_r($imageData);die;
				if(!empty($imageData)){
					foreach ($imageData as $val) {
						if(file_exists(file_upload_s3_path().'project/'.$val['image_thumb'])){
							$this->session->set_userdata('profileImageData',file_upload_s3_path().'project/'.$val['image_thumb']);
							$this->session->set_userdata('file_id',$val['id']);
							$this->uploadFile();
							$success = unlink(file_upload_s3_path().'project/'. $val['image_thumb']);
						}
					}
				}
			}
			echo $this->project_model->updateMoveDataToDriveSetting($moveToGoogleDriveSetting);
		}else{
			echo FALSE;
		}
	}

	public function file_exists()
	{
		$file=$this->input->post('file', TRUE);
		if(file_exists(file_upload_s3_path().$file))
		{
			echo true;
		}
		else
		{
			echo false;
		}
	}


	/*public function cus()
	{
		$proIds = $this->db->select('projectId')->from('project_rating')->group_by('projectId')->get()->result_array();

		foreach ($proIds as $proid) {

			$avg_rating=$this->db->select(' AVG(`rating`) As avg_r')->from('project_rating')->where('projectId',$proid['projectId'])->get()->row_array();
			print_r($avg_rating);
			$ratingData = array('avg_project_rating'=>$avg_rating['avg_r']);
			print_r($ratingData);
			//$rating_update = $this->project_model->update_rating_data('project_rating',$ratingData,$proid['projectId']);
			$rating_update = $this->model_basic->_updateWhere('project_rating',array('projectId'=>$proid['projectId']),$ratingData);
			
		}
	}*/

	public function getCategoryWiseCount()
	{
		$cats=$this->db->select('id')->from('category_master')->get()->result_array();
		foreach ($cats as $cat) 
		{
			$count=$this->model_basic->getCount('project_master','categoryId',$cat['id']);
			$this->model_basic->_updateWhere('category_master',array('id'=>$cat['id']),array('ProjectCount'=>$count));	
		}
	}

	public function deleteJobNotifications()
	{
		$cats=$this->db->select('id')->from('header_notification_master')->where('typeId',1)->get()->result_array();
		foreach ($cats as $cat) 
		{
			//$count=$this->model_basic->getCount('project_master','categoryId',$cat['id']);
			$this->model_basic->_deleteWhere('header_notification_user_relation',array('notification_id'=>$cat['id']));
			$this->model_basic->_deleteWhere('header_notification_master',array('id'=>$cat['id']));
		}
	}
    public function getProjectAttributeValue()
	{
		$catId = $_POST['project_category'];	  
		$projectId = $_POST['projectId'];	  
		$res = $this->project_model->getProjectAttributeValue($catId,$projectId);	
		echo json_encode($res);	
	}
	public function getProjectAttributes($categoryId)
	{
		$attributes=$this->project_model->getCategoryAttributeOnAjax($categoryId);
		echo json_encode($attributes[0]['atrribute_value']);
	}

    public function approve_pending_projects()
	{
		if($this->session->userdata('front_user_id') !='')
		{
			$instituteId = $this->session->userdata('user_institute_id');
			$data['project'] = $this->project_model->GetInstitutePendingProjectList($instituteId);
			$this->load->view('manage_project_pending_approve_view',$data);
		}
		else
		{
			$this->session->set_flashdata('error', 'Please Login.');
			redirect('home');
		}
		
	}

    public function pending_approve_status($id,$status){
		if($status == 4){
			$data = array('status'=> 4);
		}elseif($status == 1){
			$data = array('status'=> 1);
		}
		else
		{
			$data = array('status' =>3,'admin_status'=>'');
		}
		$result = $this->project_model->pending_project_status_update($id,$data);
		if($result > 0){
			$this->session->set_flashdata('success','status change successfully');
			redirect('project/approve_pending_projects');
		}
		else
		{
			$this->session->set_flashdata('error','failed to change status');
			redirect('project/approve_pending_projects');
		}
	}
}

