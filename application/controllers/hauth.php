<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HAuth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('model_basic');
		$this->load->model('competition_model');
		$this->load->model('project_model');
	}
	public function googleLogin($gusetLoginType = '')
	{


		if(!empty($gusetLoginType) && $gusetLoginType != '' && $gusetLoginType){
			$this->session->set_userdata('guestLoginType',$gusetLoginType);
		}



		//print_r($this->session->all_userdata());die;
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/autoload.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";
		$localhost = array('127.0.0.1','::1');
		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
		{
			/* local */
			$client_id = '787212047392-2o7nscmjvlmnf4u3e6jnes7a2dcbeh1j.apps.googleusercontent.com';
			$client_secret = 'uDWrFdVQ2495Fxjm6TwcW6nG';
			$redirect_uri = 'http://localhost/creosouls/hauth/googleLogin';
		}
		else
		{
			/* test */
			/*$client_id = '787212047392-n3akhlp5rkts8st40tu1s1vpah8iqo88.apps.googleusercontent.com';
			$client_secret = 'EeuVKH9osDshP_VOstvMHPej';
			$redirect_uri = 'http://www.creosouls.com/testarena/hauth/googleLogin';*/

			/* live */
			$client_id = '834129337559-8d4muv0aipa6c2upbmlvh93i3710mjm4.apps.googleusercontent.com';
			$client_secret = 'R1NLkb2YnEr4DWlGbssRGLpQ';
			$redirect_uri = 'https://university.creonow.com/hauth/googleLogin';
		}
		$client = new Google_Client();
		$client->setApplicationName("PHP Google OAuth Login Example");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		//$client->revokeToken();
		//$client->setDeveloperKey($simple_api_key);
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");
		$client->addScope("https://www.googleapis.com/auth/drive.file");
		$objOAuthService = new Google_Service_Oauth2($client);
		// Add Access Token to Session
		if(isset($_GET['code']))
		{
			$credentials =$client->authenticate($_GET['code']);
			$refresh_token=json_decode($credentials)->refresh_token;
			$this->session->set_userdata('access_token',$client->getAccessToken());
			$this->session->set_userdata('refresh_token', json_decode($credentials)->refresh_token);

			if(!empty($this->session->userdata('guestLoginType')) && $this->session->userdata('guestLoginType') != '' && $this->session->userdata('guestLoginType')){
				header('Location: ' . filter_var($redirect_uri.'?loginType='.$this->session->userdata('guestLoginType'), FILTER_SANITIZE_URL));

			} else{
				header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			}


		}
		if($this->session->userdata('access_token') <> '' && $this->session->userdata('access_token'))
		{
			$client->setAccessToken($this->session->userdata('access_token'));
		}
		//echo $client->getAccessToken();die;
		if($client->getAccessToken())
		{
			$user_profile = $objOAuthService->userinfo->get();
			//$data['userData'] = $userData;
			$this->session->set_userdata('access_token',$client->getAccessToken());
			$defaultDiskSpace=$this->model_basic->getValue('settings','description'," `settings_id` = 14");
			$imageName=$this->grab_google_image($user_profile->picture,file_upload_s3_path().'users/thumbs/'.$user_profile->id.'.jpg');
			$UserInfo=array(
					/*'firstName'		=>$user_profile->givenName,
					'lastName'		=>$user_profile->familyName,*/
					'email'			=>$user_profile->email,
					'profileImage'	=>$imageName,
					'identifier'	=>$user_profile->id,
					'disk_space'	=>$defaultDiskSpace,
					'status'		=>1,
					'created'		=>date('Y-m-d H:i:s')
				);

			$this->session->set_userdata('guestLoginUserData',$UserInfo);



			if(!empty($_GET['loginType']) && $_GET['loginType']){
				$UserInfo['login_type'] = $_GET['loginType'];
			}

			$refresh_token=$this->session->userdata('refresh_token');
			if(isset($refresh_token) && $refresh_token !='')
			{
				$UserInfo['refresh_token']=$refresh_token;
			}
			$redirect_url = base_url();
			if(isset($user_profile->link)&& $user_profile->link!='')
			{
				$UserInfo['profileURL']=$user_profile->link;
			}
			if( $this->session->userdata('redirect_back'))
			{

			    $redirect_url = base_url().$this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
			    //$this->session->unset_userdata('redirect_back');
			}
			else
			{

				$redirect_url = $this->session->userdata('redirect_back_url');  // grab value and put into a temp variable so we unset the session value
				//$this->session->unset_userdata('redirect_back_url');

			}


			$userId=$this->login_model->insertUser($UserInfo);
			if($userId == 0)
			{
				$this->session->set_flashdata('error', 'Your account is deactive contact creosouls admin to activate your account.');
				redirect(base_url());
				exit();
			}
			else
			{
				//print_r($this->session->all_userdata());die;
				if($this->session->userdata('studentId') != '')
				{

					$checkInstituteId = $this->model_basic->getValue('institute_csv_users','instituteId'," `studentId` = '".$this->session->userdata('studentId')."'");
					$checkInstituteIsActive = $this->model_basic->getValue('institute_master','status'," `id` = '".$checkInstituteId."'");

					if($checkInstituteIsActive != '0')
					{
						$isStudentExist=$this->model_basic->getValue('institute_csv_users','email'," `studentId` = '".$this->session->userdata('studentId')."'");
						$isEmailExistsInCSV=$this->model_basic->getValue('institute_csv_users','email'," `email` = '".$UserInfo['email']."'");
						if($isStudentExist == '' && $isEmailExistsInCSV == '')
						{
						/*	$this->model_basic->_update('institute_csv_users','studentId',$this->session->userdata('studentId'),array('email'=>$user_profile->email));*/

							$paymentStatusOfStudent=$this->model_basic->getValueArray('institute_csv_users','paymentStatus',array('studentId'=>$this->session->userdata('studentId')));
							$csvIdOfStudent=$this->model_basic->getValueArray('institute_csv_users','id',array('studentId'=>$this->session->userdata('studentId')));
							if($paymentStatusOfStudent==2)
							{
								$this->model_basic->_update('student_membership','csvuserId',$csvIdOfStudent,array('end_date'=>date('Y-m-d H:i:s', strtotime('+30 days'))));
							}

							$this->model_basic->_update('institute_csv_users','studentId',$this->session->userdata('studentId'),array('email'=>$user_profile->email,'first_login_date'=>date('Y-m-d')));

							$maac = $this->load->database('maac_db', TRUE);
						  	$deleteUserDataEntry = $maac->select('id')->from('users')->where('email',$user_profile->email)->get()->row_array();
						  	//print_r($deleteUserDataEntry);die;
							  	if(!empty($deleteUserDataEntry))
							  	{
							  	  	$maac->where('email',$user_profile->email)->delete('users');
							  	}

							$this->session->unset_userdata('studentId');
						}
						if($isStudentExist !='' && $isStudentExist != $isEmailExistsInCSV)
						{
							$this->session->unset_userdata('studentId');
							$this->session->set_userdata('correctEmail',$isStudentExist);
							$this->session->set_userdata('blockUser',3);
							redirect(base_url());
						}
						/*elseif($isStudentExist != '')
						{
							$this->session->set_flashdata('error', 'This Student ID is already in use.');
							$this->session->unset_userdata('studentId');
							redirect(base_url());
							exit();
						}
						elseif($isEmailExistsInCSV != '')
						{
							$this->session->set_flashdata('error', 'This Email ID is already used with other Student ID.');
							$this->session->unset_userdata('studentId');
							redirect(base_url());
							exit();
						}*/
					}
				}
				$institute=$this->login_model->check_user_institute($userId);
				$usersFinalEmail=$this->model_basic->getValueArray('users','email',array('id'=>$userId));
				$usersFinalCsvId=$this->model_basic->getValueArray('institute_csv_users','id',array('email'=>$usersFinalEmail));
				$usersFinalPaymentStatus=$this->model_basic->getValueArray('institute_csv_users','paymentStatus',array('email'=>$usersFinalEmail));
				if($usersFinalPaymentStatus==2)
				{
					$usersEvaluationPeriodEndDate=$this->model_basic->getValueArray('student_membership','end_date',array('csvuserId'=>$usersFinalCsvId));
					$today=date('Y-m-d H:i:s');
					if($today > $usersEvaluationPeriodEndDate)
					{
						$this->session->set_userdata('blockUser',1);
						redirect(base_url());
					}
				}
				if($usersFinalPaymentStatus==3)
				{
					$usersSubscriptionPeriodEndDate=$this->model_basic->getValueArray('student_membership','end_date',array('csvuserId'=>$usersFinalCsvId));
					$today=date('Y-m-d H:i:s');
					if($today > $usersSubscriptionPeriodEndDate)
					{
						$this->session->set_userdata('blockUser',2);
						redirect(base_url());
					}
				}

				//$institute=$this->login_model->checkInstituteIdInUser($userId);
				if(!empty($institute))
				{
					$this->model_basic->_update('users','id',$userId,array('instituteId'=>$institute[0]['instituteId']));
					$this->session->set_userdata('user_institute_id',$institute[0]['instituteId']);
					$this->session->set_userdata('user_institute_name',$institute[0]['pageName']);
				}
				else
				{
					$this->session->set_userdata('user_institute_id','');
					$this->session->set_userdata('user_institute_name','');
				}
				//pr($this->session->all_userdata());
				$userData = $this->model_basic->loggedInUserInfoById($userId);
				$userFullName = $userData['firstName'].$userData['lastName'];
				$this->session->set_userdata('logged_user_name',$userFullName);
				$loginId = $this->login_model->insert_login_details($userId);
				if($this->session->userdata('project_Id') && $this->session->userdata('project_Id')!='' && $this->session->userdata('image_Id')=='')
				{
					$project_id = $this->session->userdata('project_Id');
					$currentUrl = $this->session->userdata('redirect_back');
					$page_name = $this->session->userdata('page_name');
					$this->set_sessions($userId,$loginId,$userData);
					$this->beforeLogin_Actions($project_id,'','Project_Liked',$currentUrl,$page_name);
					$this->session->unset_userdata('project_Id');
					$this->session->unset_userdata('page_name');
					if($this->session->userdata('redirect_back') !='')
					{
						$redirect_url = base_url().$this->session->userdata('redirect_back');
						$this->session->unset_userdata('redirect_back');
					}
					redirect($redirect_url);
				}
				else if($this->session->userdata('project_Id') && $this->session->userdata('project_Id')!='' && $this->session->userdata('image_Id') && $this->session->userdata('image_Id')!='')
				{
					$project_id = $this->session->userdata('project_Id');
					$image_Id = $this->session->userdata('image_Id');
					$currentUrl = $this->session->userdata('redirect_back');
					$page_name = $this->session->userdata('page_name');
					$this->set_sessions($userId,$loginId,$userData);
					$this->beforeLogin_Actions($project_id,$image_Id,'Project_Image_Liked',$currentUrl,$page_name);
					$this->session->unset_userdata('project_Id');
					$this->session->unset_userdata('image_Id');
					$this->session->unset_userdata('page_name');
					if($this->session->userdata('redirect_back') !='')
					{
						$redirect_url = base_url().$this->session->userdata('redirect_back');
						$this->session->unset_userdata('redirect_back');
					}
					redirect($redirect_url);
				}
				else if(!empty($institute))
				{
					//pr($institute);
					$this->set_sessions($userId,$loginId,$userData);
					if($this->session->userdata('clicked_competition_id') && $this->session->userdata('clicked_competition_id') !='')
					{
						$comp_id = $this->session->userdata('clicked_competition_id');
						$competition_data = $this->competition_model->getCompetitionData($comp_id);
						if(!empty($competition_data))
						{
							if($competition_data[0]['open_for_all']==1)
							{
								$this->competition_model->checkUserCompetitionRelation($comp_id,$userId);
							}
							elseif($competition_data[0]['instituteId']==$institute[0]['instituteId'])
							{
								$this->competition_model->checkUserCompetitionRelation($comp_id,$userId);
							}
							else
							{
								$this->session->set_flashdata('error', 'This Competition is not open for all.');
							}
						}
					    $this->session->unset_userdata('clicked_competition_id');
						redirect(base_url().'competition/get_competition/'.$comp_id);
					}
					else
					{
						$redirect_url=base_url().$institute[0]['pageName'];
						if($this->session->userdata('redirect_back') !='')
						{
							$redirect_url = base_url().$this->session->userdata('redirect_back');
							$this->session->unset_userdata('redirect_back');
						}
						redirect($redirect_url);
					}
				}
				elseif($this->session->userdata('redirect_back')||$this->session->userdata('clicked_competition_id'))
				{
					$this->set_sessions($userId,$loginId,$userData);
					if($this->session->userdata('clicked_competition_id') && $this->session->userdata('clicked_competition_id') !='')
					{
						$comp_id = $this->session->userdata('clicked_competition_id');
					    $competition_data = $this->competition_model->getCompetitionData($comp_id);
						if(!empty($competition_data))
						{
							if($competition_data[0]['open_for_all']==1)
							{
								$this->competition_model->checkUserCompetitionRelation($comp_id,$userId);
							}
							elseif($competition_data[0]['instituteId']==$institute[0]['instituteId'])
							{
								$this->competition_model->checkUserCompetitionRelation($comp_id,$userId);
							}
							else
							{
								$this->session->set_flashdata('error', 'This Competition is not open for all.');
							}
						}
						$this->session->unset_userdata('clicked_competition_id');
						$redirect_url=base_url().'competition/get_competition/'.$comp_id;
						if($this->session->userdata('redirect_back') !='')
						{
							$redirect_url = base_url().$this->session->userdata('redirect_back');
							$this->session->unset_userdata('redirect_back');
						}
					}
					else
					{
					    $redirect_url = base_url().$this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
					    $this->session->unset_userdata('redirect_back');
					    redirect( $redirect_url );
					}
				}
				else
				{
					$this->set_sessions($userId,$loginId,$userData);
					if($this->session->userdata('redirect_back') !='')
					{
						$redirect_url = base_url().$this->session->userdata('redirect_back');
						$this->session->unset_userdata('redirect_back');
					}
					redirect($redirect_url);
				}
			}

		}
		else
		{
			$authUrl = $client->createAuthUrl();
		}
		redirect($authUrl);
	}
	public function logout()
	{
		/*$loginId=$this->session->userdata('user_login_id');
		$this->model_basic->updateLogOut($loginId);
		unset($_SESSION['access_token']);
		session_destroy();
		setcookie('PHPSESSID','dsad',time()-1);
		$this->session->sess_destroy();
		redirect();*/

		unset($_SESSION['access_token']);
		session_destroy();
		setcookie('PHPSESSID','dsad',time()-1);
		$this->session->sess_destroy();
		$this->session->userdata = array();
		unset($this->session->userdata['guest_user']);
		unset($this->session->userdata['front_is_logged_in']);
		$this->session->sess_destroy();
        //$this->cache->clean();
         $sdata=array();
        $this->session->set_userdata($sdata);
        ob_clean();
		redirect('/?is_loggedout=1');
	}

	public function arenalogout()
	{
		redirect(maac_base_url().'hauth/logout');
	}

	function grab_google_image($url,$saveto)
	{
	    $image = file_get_contents($url); // sets $image to the contents of the url
	    file_put_contents($saveto, $image);
	    return basename($saveto);
	}
	function grab_facebook_image($url,$saveto)
	{
		$image = file_get_contents($url); // sets $image to the contents of the url
		file_put_contents($saveto, $image);
		return basename($saveto);
	}
	function creosoulsWeeklyNewsletter()
	{
		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$userData=$this->model_basic->getAllData('users','email',array('status'=>1));
		if(!empty($userData))
		{
			foreach ($userData as $user)
			{
				$data=array();
				$Emaildata['fromEmail']=$emailFrom;
				$Emaildata['to']=$user['email'];
				$Emaildata['subject']='creosouls Is Growing';
				$Emaildata['template']=$this->load->view('emailTemplates/QuoteoftheWeek',$data,true);
				//$this->model_basic->sendMail($Emaildata);
			}
		}
	}
	public function beforeLogin_Actions($project_id,$image_id,$activity_name='',$currentUrl,$page_name)
	{
		if(isset($project_id) && $project_id != '' && $image_id=='' && $this->session->userdata('front_user_id') != '')
		{
			$project_id = $project_id;
			$ip     = $this->input->ip_address();
			$viewed = $this->project_model->checkProjectLike($project_id);
			if(!empty($viewed))
			{
				if($viewed[0]['userLike'] == 0)
				{
					$res = $this->project_model->projectUpdateLike($project_id,$ip);
					if($this->session->userdata('front_user_id') != "")
					{
						$proDetail=$this->project_model->getProjectDetail($project_id);
				        $emailFlag=$this->model_basic->getValue('user_email_notification_relation','project_like'," `userId` = '".$proDetail[0]['userId']."'");
				      	if($emailFlag==1 || $emailFlag=='')
				      	{
				      		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
							$proDetail             = $this->project_model->getProjectDetail($project_id);
							$likeProjectName       = $proDetail[0]['projectName'];
							$likeTo                = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
							$likeBy                = $this->model_basic->loggedInUserInfo();
							$emailTo               = $likeTo['email'];
							$from                  = $emailFrom;
							$nameBy                = ucwords($likeBy['firstName'].' '.$likeBy['lastName']);
							$nameTo                = ucwords($likeTo['firstName'].' '.$likeTo['lastName']);
							$templateLikeTo        = 'Hello <b>'.$nameTo. '</b>,<br /><b> '.$nameBy.'</b> recently liked your project "<b>' .$likeProjectName.'</b>" on creosouls.<br /><a href="'.base_url().'project/projectDetail/'.$project_id.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$emailDetailUnFollowTo = array('to'       =>$emailTo,'subject'  =>'Someone has liked your project','template' =>$templateLikeTo,'fromEmail'=>$from);
					  	}
					}
					if($res > 0)
					{
						$this->model_basic->insertActivity($page_name,$currentUrl,$project_id,'Liked');
						$this->project_model->likeCountIncrement($project_id);
						return true;
					}
					else
					{
						return false;
					}
				}
			}
			else
			{
				$res = $this->project_model->projectLikeEntry($project_id,$ip);
				if($this->session->userdata('front_user_id') != "")
				{
					$proDetail=$this->project_model->getProjectDetail($project_id);
				    $emailFlag=$this->model_basic->getValue('user_email_notification_relation','project_like'," `userId` = '".$proDetail[0]['userId']."'");
					if($emailFlag==1 || $emailFlag=='')
					{
						$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
						$proDetail             = $this->project_model->getProjectDetail($project_id);
						$likeProjectName       = $proDetail[0]['projectName'];
						$likeTo                = $this->model_basic->loggedInUserInfoById($proDetail[0]['userId']);
						$likeBy                = $this->model_basic->loggedInUserInfo();
						$emailTo               = $likeTo['email'];
						$from                  = $emailFrom;
						$nameBy                = ucwords($likeBy['firstName'].' '.$likeBy['lastName']);
						$nameTo                = ucwords($likeTo['firstName'].' '.$likeTo['lastName']);
						$templateLikeTo        = 'Hello <b>'.$nameTo. '</b>,<br /><b> '.$nameBy.'</b> recently liked your project "<b>' .$likeProjectName.'</b>" on creosouls.<br /><a href="'.base_url().'project/projectDetail/'.$project_id.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$emailDetailUnFollowTo = array('to'       =>$emailTo,'subject'  =>'Someone has liked your project','template' =>$templateLikeTo,'fromEmail'=>$from);
					}
				}
				if($res > 0)
				{
					$this->model_basic->insertActivity($page_name,$currentUrl,$project_id,'Liked');
					$this->project_model->likeCountIncrement($project_id);
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else if(isset($project_id) && isset($image_id) && $project_id != '' && $image_id!='' && $this->session->userdata('front_user_id') != '')
		{
			$rs = 0;
			$res= $this->project_model->check_rate_like_exists($image_id);
			if(empty($res))
			{
				$data = array(
						'project_image_id'=>$image_id,
						'project_id' =>$project_id,
						'user_id'=>$this->session->userdata('front_user_id'),
						'created'=>date('Y-m-d H:i:s')
					);
				$data['image_like'] = 1;
				$activity = 'Liked Image of';
				$rs = $this->project_model->insert_data('project_image_rating_like',$data);
			}
			else
			{
				if($res[0]['image_like']==0 || $res[0]['image_like'] == '')
				{
					$data = array('image_like'=>1);
					$activity = 'Liked Image of';
					$rs = $this->project_model->update_data('project_image_rating_like',$data,'project_image_id',$image_id);
				}
			}
			if($rs > 0)
			{
				$this->model_basic->insertActivity($page_name,$currentUrl,$project_id,$activity);
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	public function set_sessions($userId,$loginId,$userData)
	{
           //echo "inside".$userId; exit();
	        $termsCondition=$this->model_basic->getData('terms_and_conditions','*',array('user_id'=>$userId));
	        if(empty($termsCondition))
	        {
              //echo "inside".$userId; exit();
		       redirect('home/index/1/'.$userId.'/'.$loginId);
	        }
	        else
	        {
	        	$TeacherStatus=$this->model_basic->getAllData('users','id,teachers_status,city,admin_level,aptech_id',array('id'=>$userId));
			//print_r($TeacherStatus);die;
			$this->session->set_userdata('teachers_status',$TeacherStatus[0]['teachers_status']);
			$this->session->set_userdata('city',$TeacherStatus[0]['city']);
			//$this->session->set_userdata('user_admin_level',$TeacherStatus[0]['admin_level']);
			$this->session->set_userdata('front_user_id',$userId);
			$this->session->set_userdata('jobStatusFeedback',1);
			if($TeacherStatus[0]['admin_level'] == 1 && $TeacherStatus[0]['aptech_id'] != ''){
				$checkValidUser = $this->model_basic->getAuthUserAptech($TeacherStatus[0]['aptech_id']);
				$resultResponse = json_decode($checkValidUser,true);
    			foreach ($resultResponse as $userData) {
    				if($userData['Result'] == 'Success'){
						$this->session->set_userdata('user_admin_level',$TeacherStatus[0]['admin_level']);
			
					}else{
						$this->session->set_userdata('user_admin_level',0);
					}
				}
			
			}else{
				$this->session->set_userdata('user_admin_level',$TeacherStatus[0]['admin_level']);
			}
			if($userData['type']=='2' && $userData['company']!='')
			{
				$this->session->set_userdata('user_company_name',$userData['company']);
				$this->session->set_userdata('user_type',$userData['type']);
			}
			elseif($userData['type']=='1' && $userData['instituteId']>0)
			{
				$this->load->model('user_model');
				$isAdmin = $this->user_model->check_admin_or_not();
				if(!empty($isAdmin))
				{
					$this->session->set_userdata('user_type',$userData['type']);
				}
			}
			$this->session->set_userdata('user_login_id',$loginId);
			$this->session->set_userdata('front_is_logged_in',true);
			$this->session->set_flashdata('success', 'Welcome to creosouls...!');

			$IsGustUser=$this->login_model->check_user_institute($userId);
			if(empty($IsGustUser))
			{
				$this->session->set_userdata('guest_user','guest_user');
			}

		}
	}
	public function deleteImages()
	{
		//$directory = file_upload_s3_path()."project/";
		//$directory = file_upload_s3_path()."project/thumbs/";
		$directory = file_upload_s3_path()."project/thumb_big/";
		$images = glob($directory . "*.{jpg,png,gif,jpeg,JPG,PNG,zip}", GLOB_BRACE);
		foreach($images as $image)
		{
			//echo $image;echo '<br/>';
			$projectId=$this->model_basic->getValue('user_project_image','project_id',"image_thumb='".basename($image)."'");
			if($projectId > 0)
			{
				echo $projectId;echo "<br/>";
			}
			else
			{
				//unlink(file_upload_s3_path().'project/'.basename($image));
				//unlink(file_upload_s3_path().'project/thumbs/'.basename($image));
				unlink(file_upload_s3_path().'project/thumb_big/'.basename($image));
			}
		}
	}

	public function terms_and_conditions()
	{
		$maac = $this->load->database('maac_db', TRUE);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('terms_and_conditions', 'Terms And Conditions', 'trim|required');
		if ($this->form_validation->run())
		{
			$termsCondition=$this->model_basic->getData('terms_and_conditions','*',array('user_id'=>$_POST['user_id']));
			if(empty($termsCondition))
			{
				$ip = $_SERVER['REMOTE_ADDR'];
				$data = array('user_id' =>$_POST['user_id'],'ip_address'=>$ip,'accepted_date'=>date('Y-m-d H:i:s') );
				$acceptTermsAndConditions=$this->model_basic->_insert('terms_and_conditions',$data);

				$userData = $this->model_basic->loggedInUserInfoById($_POST['user_id']);

				$maacUserData = $maac->select('id,status')->from('users')->where('email',$userData['email'])->get()->row_array();
				if(!empty($maacUserData))
				{
					$maacData = array('user_id' =>$maacUserData['id'],'ip_address'=>$ip,'accepted_date'=>date('Y-m-d H:i:s') );
					$maac->insert('terms_and_conditions',$maacData);
				}

				$this->set_sessions($_POST['user_id'],$_POST['loginId'],$userData);
				redirect(base_url().'incompleteProfile');
			}
			else
			{
				redirect(base_url().'home');
			}
		}
		else
		{
			redirect('home/index/1/'.$_POST['user_id'].'/'.$_POST['loginId']);
		}
	}
	public function set_center_session($userId)
	{
		$userData = $this->db->select('*')->from('users')->where('id',$userId)->get()->row_array();
		$loginId = $this->login_model->insert_login_details($userId);

	        $termsCondition=$this->model_basic->getData('terms_and_conditions','*',array('user_id'=>$userId));
	        if(empty($termsCondition))
	        {
	        	redirect('home/index/1/'.$userId.'/'.$loginId);
	        }
	        else
	        {
		        $TeacherStatus=$this->model_basic->getAllData('users','id,teachers_status,city,admin_level',array('id'=>$userId));
				//print_r($TeacherStatus);die;
				$this->session->set_userdata('teachers_status',$TeacherStatus[0]['teachers_status']);
				$this->session->set_userdata('city',$TeacherStatus[0]['city']);
				$this->session->set_userdata('user_admin_level',$TeacherStatus[0]['admin_level']);
				$this->session->set_userdata('front_user_id',$userId);
				$this->session->set_userdata('jobStatusFeedback',1);

				if($userData['type']=='2' && $userData['company']!='')
				{
					$this->session->set_userdata('user_company_name',$userData['company']);
					$this->session->set_userdata('user_type',$userData['type']);
				}
				elseif($userData['type']=='1' && $userData['instituteId']>0)
				{
					$this->load->model('user_model');
					$isAdmin = $this->user_model->check_admin_or_not();
					if(!empty($isAdmin))
					{
						$this->session->set_userdata('user_type',$userData['type']);
					}
				}

				$institute = array();
				if($userData['instituteId'] != '' && $userData['instituteId'] > 0)
				{
					$institute = $this->db->select('id,instituteName,pageName')->from('institute_master')->where('id',$userData['instituteId'])->get()->row_array();
				}

				if(!empty($institute))
				{

					$this->session->set_userdata('user_institute_id',$institute['instituteId']);
					$this->session->set_userdata('user_institute_name',$institute['pageName']);
				}
				else
				{
					$this->session->set_userdata('user_institute_id','');
					$this->session->set_userdata('user_institute_name','');
				}

				$userData = $this->model_basic->loggedInUserInfoById($userId);
				$userFullName = $userData['firstName'].$userData['lastName'];
				$this->session->set_userdata('logged_user_name',$userFullName);

				if($userData['type']=='2' && $userData['company']!='')
				{
					$this->session->set_userdata('user_company_name',$userData['company']);
					$this->session->set_userdata('user_type',$userData['type']);
				}
				elseif($userData['type']=='1' && $userData['instituteId']>0)
				{
					$this->load->model('user_model');
					$isAdmin = $this->user_model->check_admin_or_not();
					if(!empty($isAdmin))
					{
						$this->session->set_userdata('user_type',$userData['type']);
					}
				}
				$this->login_model->checkUserProfile($userId);
				$this->session->set_userdata('user_login_id',$loginId);
				$this->session->set_userdata('front_is_logged_in',true);
				$this->session->set_flashdata('success', 'Welcome to creosouls...!');
			}
		redirect(base_url());

	}

	public function center_name($center_name)
	{

		$this->session->unset_userdata('guest_user');

		if($center_name == 1)
		{
			redirect(base_url().'home');
		}
		else if($center_name == 2)
		{
			$userInfo = $this->model_basic->loggedInUserInfo();
			$maac = $this->load->database('maac_db', TRUE);
			$userData = $maac->select('id')->from('users')->where('email',$userInfo['email'])->get()->row_array();
			if(!empty($userData))
			{
				redirect(maac_base_url().'hauth/set_center_session/'.$userData['id'],'refresh');
			}
		} else if($center_name == 3){

			//$userInfo = $this->model_basic->loggedInUserInfo();
			$lakme_db = $this->load->database('lakme_db', TRUE);
			$user_id=$this->session->userdata('front_user_id');


			$uinfo = $this->session->userdata('guestLoginUserData');

			$userData = $lakme_db->select('id')->from('users')->where('email',$uinfo['email'])->get()->row_array();


			if(!empty($userData))
			{


				redirect('https://www.creosouls.com/lakme/hauth/set_center_session/'.$userData['id'],'refresh');
			}
		}

	}
}




