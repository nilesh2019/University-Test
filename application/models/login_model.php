<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
	public $variable;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
	}

	/**
	 * [newUserInsertCheck description]
	 * @param  [type] $userId [description]
	 * @return [type]         [description]
	 */
	public function newUserInsertCheck($dbObj,$userId){

		$userId=$this->db->insert_id();
					$showJob=$this->model_basic->getValue('users','job_status'," `id` = '".$userId."'");
					if($showJob==0)
					{
						$this->session->set_userdata('showJob','No');
					}
					elseif($showJob==1)
					{
						$this->session->set_userdata('showJob','Yes');
					}
					$emailID=$this->model_basic->getValue('users','email'," `id` = '".$userId."'");
					$juryId=$this->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
					$this->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$userId));
					$this->checkUserProfileCompleteOrNot($dbObj, $userId);
					return $userId;


	}


	/**
	 * [notExitInsertUser description]
	 * @param  [type] $dbObj [description]
	 * @param  [type] $data  [description]
	 * @return [type]        [description]
	 */
	public function notExitInsertUser($dbObj, $data){
		unset($data['login_type']);
		$dbObj->insert('users',$data);
		$userId=$this->db->insert_id();
		$this->newUserInsertCheck($dbObj,$userId);

	}

	/**
	 * [checkUserExitsOrnNot description]
	 * @param  [type] $dbObj [description]
	 * @param  [type] $data  [description]
	 * @return [type]        [description]
	 */
	public function checkUserExitsOrnNot($dbObj, $data){

		return $dbObj->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();
	}



	/**
	 * [checkUserProfile description]
	 * @param  [type] $userId [description]
	 * @return [type]         [description]
	 */
	public function checkUserProfileCompleteOrNot($dbObj, $userId)
	{
		$userDetail=$dbObj->select('A.firstName,A.lastName,A.type,A.college,A.company')->from('users as A')->where('A.id',$userId)->get()->row_array();
		//$userDetail[0]['notificationEntry']=$this->model_basic->getValue('user_email_notification_relation','userId'," `userId` = '".$userId."'");
		//print_r($userDetail);die;
		if(isset($userDetail) && !empty($userDetail))
		{
			if($userDetail['type']=='0')
			{
				if($userDetail['firstName']=='' || $userDetail['lastName']=='' ) //|| $userDetail[0]['college']==''
				{
					$this->session->set_userdata('userProfileComplete','FALSE');
				}
				else
				{
					$this->session->set_userdata('userProfileComplete','TRUE');
				}
			}
			elseif($userDetail['type']=='1')
			{
				if($userDetail['firstName']=='' || $userDetail['lastName']=='' ) //|| $userDetail[0]['company']==''
				{
					$this->session->set_userdata('userProfileComplete','FALSE');
				}
				else
				{
					$this->session->set_userdata('userProfileComplete','TRUE');
				}
			}
			elseif($userDetail['type']=='' && empty($userDetail['type']))
			{
				$this->session->set_userdata('userProfileComplete','FALSE');
			}
			else
			{
				$this->session->set_userdata('userProfileComplete','TRUE');
			}
		}
		//print_r($userDetail);die;
	}


	/**
	 * [insertUser description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function insertUser($data)
	{	//print_r($data);die;
		$maac = $this->load->database('maac_db', TRUE);
		$lakme = $this->load->database('lakme_db', TRUE);


		if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '111'){
			$this->session->set_userdata('guest_user','guest_user');

		} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '222'){
			$this->session->set_userdata('guest_user','guest_user');
			

		} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '333'){
			$this->session->set_userdata('guest_user','guest_user');
		} else{
			$this->session->unset_userdata('guest_user');
		}

		$userData=array();
		$centerId = 1;
		if(isset($data['email']) && $data['email'] !='')
		{

			$userData=$this->db->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();


			if(empty($userData))
			{
				/******* Maac Login ***/
			  	$userData = $maac->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();

			  	if(!empty($userData))
			  	{
			  		if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '111'){

				  		/// If Arena Guest Login
			  			$arenaUserData=$this->db->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();
			  			if(empty($arenaUserData)){
			  				unset($data['login_type']);
			  				$this->db->insert('users',$data);
			  				$userId=$this->db->insert_id();
			  				return $userId;
			  			} else{
			  				$centerId = 1;
			  			}


			  		} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '333'){

			  			// If Lakme Guest Login
			  			$lakmeUserData=$this->checkUserExitsOrnNot($lakme, $data);
			  			if(empty($lakmeUserData)){
			  				$this->notExitInsertUser($lakme, $data);
			  			} else{
			  				$centerId = 3;
			  			}

			  		} else{
			  			$centerId = 2;
			  		}


			  	} else{
			  		/******* Lakme Login ***/
			  		$userData = $lakme->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();
			  		if(empty($userData)){
			  			if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '111'){
			  					// If Arena Guest Login
			  					$arenaUserData=$this->db->select('id,status,instituteId,admin_level,teachers_status')->from('users')->where('email',$data['email'])->get()->row_array();
			  					if(empty($arenaUserData)){
			  						unset($data['login_type']);
			  						$this->db->insert('users',$data);
			  						$userId=$this->db->insert_id();
			  						return $userId;
			  					} else{
			  						$centerId = 1;
			  					}
			  			} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '222'){

			  				// If Maac Guest Login
							$maacUserData=$this->checkUserExitsOrnNot($maac, $data);

							if(empty($maacUserData)){
								//$this->notExitInsertUser($maac, $data);
								$centerId = 2;
							} else{
								$centerId = 2;
							}

			  			} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '333'){
			  				$lakmeUserData=$this->checkUserExitsOrnNot($lakme, $data);

			  				if(empty($lakmeUserData)){
			  					//$this->notExitInsertUser($maac, $data);
			  					$centerId = 3;
			  				} else{
			  					$centerId = 3;
			  				}
			  			} else if($this->session->userdata('centerId') == '1'){
			  				$centerId = 1;
			  			}else if($this->session->userdata('centerId') == '2'){
			  				$centerId = 2;
			  			}else if($this->session->userdata('centerId') == '3'){
			  				$centerId = 3;
			  			}
			  			else{

			  				$this->session->set_userdata('blockUser',5);
			  				redirect(base_url());
			  		}
			  	}else{
			  		$centerId = 3;
			  	}


			  	}
			} else{
					if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '222'){
						
			  			// If Maac Guest Login
						$maacUserData=$this->checkUserExitsOrnNot($maac, $data);
						if(empty($maacUserData)){
							$this->notExitInsertUser($maac, $data);
						} else{
							$centerId = 2;
						}

			  		} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '333'){
			  			
			  		// If Lakme Guest Login
			  			$lakmeUserData=$this->checkUserExitsOrnNot($lakme, $data);
			  			if(empty($lakmeUserData)){
			  				$this->notExitInsertUser($lakme, $data);
			  			} else{
			  				$centerId = 3;
			  			}

			  		} else{
			  			// If Arena Guest Login
			  			$centerId = 1;

			  		}
			}
		}

		if($centerId == 1 && !empty($userData) && $userData['instituteId'] != "")
		{
			$checkIsAdmin = $this->db->select('id')->from('institute_master')->where('id',$userData['instituteId'])->where('adminId',$userData['id'])->get()->row_array();
			if(!empty($checkIsAdmin))
			{
				$this->model_basic->_update('users','id',$userData['id'],array('admin_level'=>2));
				$userData['admin_level'] =2;
			}
		}
		if($centerId == 2 && !empty($userData) && $userData['instituteId'] != "")
		{
			$checkIsAdmin = $maac->select('id')->from('institute_master')->where('id',$userData['instituteId'])->where('adminId',$userData['id'])->get()->row_array();
			if(!empty($checkIsAdmin))
			{
				$wew = $maac->where('id',$userData['id'])->update('users',array('admin_level'=>2));
				$userData['admin_level'] =2;
			}
		}

		//print_r($this->session->all_userdata());
		//print_r($userData);die;


/*		if($userData['status'] = 1 && !empty($userData) && $this->session->all_userdata()['guestLoginType'] == "111" && $centerId == 1){
			redirect(base_url().'home');
		}*/

		if(!empty($userData) && $userData['instituteId'] != "" && $userData['instituteId'] > 0 && $userData['admin_level'] !=2 && $this->session->userdata('studentId') == '' && $userData['teachers_status'] == 0)
		{
			$this->session->set_userdata('blockUser',4);
			redirect(base_url());
		}

		if($centerId == 2 || $this->session->userdata('centerId') == 2)
		{

			$googleUserData = json_encode($data);
			redirect(maac_base_url().'hauth/googleLogin?arr='.$googleUserData);
		} elseif ($centerId == 3 || $this->session->userdata('centerId') == 3) {


			$googleUserData = json_encode($data);
			redirect('https://www.creosouls.com/lakme/hauth/googleLogin?arr='.$googleUserData);
		}	else
		{

			if(!empty($userData))
			{

				if($userData['status'] == 1)
				{
					$this->checkUserProfile($userData['id']);
					$userId=$userData['id'];
					$showJob=$this->model_basic->getValue('users','job_status'," `id` = '".$userId."'");
					if($showJob==0)
					{
						$this->session->set_userdata('showJob','No');
					}
					elseif($showJob==1)
					{
						$this->session->set_userdata('showJob','Yes');
					}
					$emailID=$this->model_basic->getValue('users','email'," `id` = '".$userId."'");
					$juryId=$this->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
					$this->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$userId));
					if(isset($data['refresh_token']) && $data['refresh_token'] !='')
					{
						$this->model_basic->_update('users','email',$data['email'],array('refresh_token'=>$data['refresh_token']));
					}
					return $userData['id'];
				}
				else
				{
					return 0;
				}
			}
			else
			{
				$userData=$this->db->select('id,provider,email')->from('users')->where('email',$data['email'])->get()->row_array();
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				if(!empty($userData))
				{
					$checkIsHardEntry=$this->db->select('id,instituteId,identifier')->from('users')->where('email',$data['email'])->get()->row_array();
					//print_r($data);
					//print_r($checkIsHardEntry);die;
					if($checkIsHardEntry['identifier'] == '')
					{
						$this->model_basic->_update('users','id',$checkIsHardEntry['id'],$data);
						$Emaildata['fromEmail']=$emailFrom;
						$Emaildata['to']=$data['email'];
						$Emaildata['subject']='Welcome To creosouls';
						$Emaildata['template']=$this->load->view('emailTemplates/welcomeEmail',$data,true);
						$this->model_basic->sendMail($Emaildata);
						$Emaildata['fromEmail']=$emailFrom;
						$Emaildata['to']=$data['email'];
						$Emaildata['subject']='Profile Created On creosouls.';
						$Emaildata['template']=$this->load->view('emailTemplates/registrationCompleted',$data,true);
						$this->model_basic->sendMail($Emaildata);
						$userId=$checkIsHardEntry['id'];
						$showJob=$this->model_basic->getValue('users','job_status'," `id` = '".$userId."'");
						if($showJob==0)
						{
							$this->session->set_userdata('showJob','No');
						}
						elseif($showJob==1)
						{
							$this->session->set_userdata('showJob','Yes');
						}
						$emailID=$this->model_basic->getValue('users','email'," `id` = '".$userId."'");
						$juryId=$this->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
						$this->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$userId));
						$this->checkUserProfile($userId);
						return $userId;
					}
					else
					{
						$this->session->set_flashdata('error', 'You have already used this email, please login using '.$userData['email']);
						redirect(base_url());
					}
				}
				else
				{

						unset($data['login_type']);

						if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '111'){

							$this->db->insert('users',$data);
							$this->session->set_userdata('guest_user','guest_user');
						//print "arena";
						//exit;

						} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '222'){
							$maac = $this->load->database('maac_db', TRUE);
							$maac->insert('users',$data);
							$this->session->set_userdata('guest_user','guest_user');
						//print "maac";
							exit;

						} else if($this->session->userdata('guestLoginType') && $this->session->userdata('guestLoginType') == '333'){

							$lakme = $this->load->database('lakme_db', TRUE);

							$lakme->insert('users',$data);
							$this->session->set_userdata('guest_user','guest_user');
						//print "lame";
						//exit;

						} else{

							$this->db->insert('users',$data);
							$this->session->unset_userdata('guest_user');

						}



					$Emaildata['fromEmail']=$emailFrom;
					$Emaildata['to']=$data['email'];
					$Emaildata['subject']='Welcome To creosouls';
					$Emaildata['template']=$this->load->view('emailTemplates/welcomeEmail',$data,true);
					$this->model_basic->sendMail($Emaildata);
					$Emaildata['fromEmail']=$emailFrom;
					$Emaildata['to']=$data['email'];
					$Emaildata['subject']='Profile Created On creosouls.';
					$Emaildata['template']=$this->load->view('emailTemplates/registrationCompleted',$data,true);
					$this->model_basic->sendMail($Emaildata);
					$userId=$this->db->insert_id();
					$showJob=$this->model_basic->getValue('users','job_status'," `id` = '".$userId."'");
					if($showJob==0)
					{
						$this->session->set_userdata('showJob','No');
					}
					elseif($showJob==1)
					{
						$this->session->set_userdata('showJob','Yes');
					}
					$emailID=$this->model_basic->getValue('users','email'," `id` = '".$userId."'");
					$juryId=$this->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
					$this->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$userId));
					$this->checkUserProfile($userId);
					return $userId;

				}
			}

		}


	}
	public function insert_login_details($user_id)
	{
		$userName = $this->session->userdata('logged_user_name'); //$this->model_basic->getValue('users','firstName'," `id` = '".$user_id."'");
		$data = array(
				'userId'				=>$user_id,
				'userName'				=>$userName,
				'logIn_time'			=>date('Y-m-d h:i:s'),
				'logIn_time_current'	=>date('Y-m-d h:i:s'),
				'ip_address'			=>$_SERVER['REMOTE_ADDR']
			);
		$this->db->insert('user_login_details',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function check_user_institute($user_id)
	{
		$this->db->select('institute_master.id as instituteId,institute_master.pageName');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$this->db->where('users.alumniFlag',0);
		$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		$this->db->join('institute_master', 'institute_csv_users.instituteId = institute_master.id');
	   	return $this->db->get()->result_array();
    }
    public function checkInstituteIdInUser($user_id)
	{
		$this->db->select('institute_master.id as instituteId,institute_master.pageName');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$this->db->where('users.instituteId !=',0);
		$this->db->join('institute_master', 'users.instituteId = institute_master.id');
	   	return $this->db->get()->result_array();
    }
    public function checkEmailExistInInstituteList($instituteId,$email)
	{
		$this->db->select('institute_csv_users.instituteId,institute_csv_users.email,institute_master.pageName');
		$this->db->from('institute_csv_users');
		$this->db->where('institute_csv_users.email',$email);
		$this->db->where('institute_csv_users.instituteId',$instituteId);
		$this->db->join('institute_master', 'institute_csv_users.instituteId = institute_master.id');
		return $this->db->get()->result_array();
    }
	public function checkAlumniUserOrNot($user_id)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$this->db->where('users.alumniFlag',1);
	   	return $this->db->get()->result_array();
    }
    function checkUserProfile($userId)
	{
		$userDetail=$this->db->select('A.firstName,A.lastName,A.type,A.college,A.company')->from('users as A')->where('A.id',$userId)->get()->row_array();

		//$userDetail[0]['notificationEntry']=$this->model_basic->getValue('user_email_notification_relation','userId'," `userId` = '".$userId."'");
		//print_r($userDetail);die;
		if(isset($userDetail) && !empty($userDetail))
		{
			if($userDetail['type']=='0')
			{
				if($userDetail['firstName']=='' || $userDetail['lastName']=='' ) //|| $userDetail[0]['college']==''
				{
					$this->session->set_userdata('userProfileComplete','FALSE');
				}
				else
				{
					$this->session->set_userdata('userProfileComplete','TRUE');
				}
			}
			elseif($userDetail['type']=='1')
			{
				if($userDetail['firstName']=='' || $userDetail['lastName']=='' ) //|| $userDetail[0]['company']==''
				{
					$this->session->set_userdata('userProfileComplete','FALSE');
				}
				else
				{
					$this->session->set_userdata('userProfileComplete','TRUE');
				}
			}
			elseif($userDetail['type']=='' && empty($userDetail['type']))
			{
				$this->session->set_userdata('userProfileComplete','FALSE');
			}
			else
			{
				$this->session->set_userdata('userProfileComplete','TRUE');
			}
		}
		//print_r($userDetail);die;
	}
	public function getUserDetail($userId)
	{
		$emailID=$this->model_basic->getValue('users','email'," `id` = '".$userId."'");
		$juryId=$this->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
		$this->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$userId));
		return $this->db->select('A.firstName,A.lastName,A.type,A.age,A.country,A.city,A.address,A.college,A.company,A.email,A.contactNo')->from('users as A')->where('A.id',$userId)->get()->result_array();
	}
}