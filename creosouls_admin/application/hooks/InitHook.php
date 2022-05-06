<?php
ob_start();
class InitHook
{
	var $CI,$isLoggedIn;
	function __construct(){
	  $this->CI = NULL;
      
	}
	function loadCustomCommonFunctions()
	{
		require_once(APPPATH.'third_party/functions'.EXT);
	}
	function initPostController($code="")
	{
		$this->CI =& get_instance();
		$class = $this->CI->router->class;

		$this->CI->load->model('update_competition');
		$localhost = array('127.0.0.1','::1');
		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
		{
		}
		else
		{
			$this->CI->load->library('aws_sdk');
			$this->CI->aws_sdk->registerStreamWrapper();
		}
		$this->CI->update_competition->markCompletedCompetions();
		$this->CI->update_competition->markCompletedCreativeCompetions();

		if($class <> "maintenence" && $this->isUnderMaintenence())
		{
			if($this->isLoggedIn())
			{
				$admin_SESSION_ID = intval($this->CI->session->userdata('admin_id'));
				$this->forceLogout($admin_SESSION_ID);
			}
			redirect(base_url()."maintenence/");
			return false;
		}
		else
		{
			$this->authenticateUser();
		}
	}
	function isLoggedIn()
	{
		$admin_SESSION_ID = intval($this->CI->session->userdata('admin_id'));
		//print_r($this->CI->session->all_userdata());die;
		if($admin_SESSION_ID > 0)
		{
			return true;
		}
		else
		{
			$this->CI->session->set_userdata('timezone','GMT');
			return false;
		}
	}
	//===================================================================================
    function authenticateUser()
	{
		$class = $this->CI->router->class;
	  	$method = $this->CI->router->method;
		//after login
		$afterLoginControllerMethodArr	=	array(
						                                       'dashboard',
						                                       'newsletter',
						                                       'install',
						                                       'institutes',
						                                       'jobs',
						                                       'projects',
						                                       'users',
													'logout'
											 	);
		// before login
		$beforeLoginControllerMethodArray = array (
			"login"
		);
		// allways allow
		$alwaysAllowControllerMethodArray = array (
		);
		// check always allow controller
		$returnMatch	=	$this->matchControllerMethod($alwaysAllowControllerMethodArray,$class);

		if(!$returnMatch)
		{
			$returnMatch	=	$this->matchControllerMethod($beforeLoginControllerMethodArray,$class);
			if($returnMatch)
			{
				
				if($this->isLoggedIn())
				{
					redirect(base_url().'admin/dashboard');
					return false;
				}
			}
			else
			{
				if(!$this->isLoggedIn())
				{
					$data=explode('/',$this->CI->uri->uri_string);
					if(in_array('dashboard',$data))
					{
						if(isset($data['2']) && $data['2'] <> '' && !isset($data['3']) && !isset($data['4']) )
						{	
											
							$userId=base64_decode(urldecode($data['2']));
							//echo $userId;
							if($userId > 0)
							{
								$this->CI->load->model('dashboard_model');

								$admin_info = $this->CI->dashboard_model->get_user_mail($userId);	
								$admin_data = $this->CI->dashboard_model->get_admin_data($admin_info['email']);
								//print_r($admin_info);			
								//print_r($admin_data);die;	

								$this->CI->session->unset_userdata('admin_id');
								$this->CI->session->unset_userdata('admin_email');
								$this->CI->session->unset_userdata('admin_name');
								$this->CI->session->unset_userdata('admin_level');
								$this->CI->session->unset_userdata('manage_user');
								$this->CI->session->unset_userdata('instituteId');

								if(!empty($admin_data) && ($admin_info['admin_level'] == 4 || $admin_info['admin_level'] == 5 || $admin_info['admin_level'] == 6))
								{										
									$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['name'],'admin_level'=>$admin_data['level'],'manage_user'=>$admin_data['manage_user']);				
									$this->CI->session->set_userdata($sess_data);
									//pr($this->CI->session->all_userdata());								

								}
								else if(!empty($admin_data) && $admin_info['admin_level'] == 1)
								{
									$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['name'],'admin_level'=>$admin_data['level'],'manage_user'=>$admin_data['manage_user']);				
									$this->CI->session->set_userdata($sess_data);
								}

							}

						}
						else if(isset($data['2']) && $data['2'] <> '' && !isset($data['4']) )
						{
							$instituteName=base64_decode(urldecode($data['2']));
							$userId=base64_decode(urldecode($data['3']));
							if($instituteName <> '' && $userId > 0)
							{
								$this->CI->load->model('dashboard_model');
								$admin_data = $this->CI->dashboard_model->get_institute_admin_data($userId,$instituteName);
								if(!empty($admin_data))
								{
									if($admin_data['id'] == $userId)
									{
										$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['userName'],'admin_level'=>2,'institute_name'=>$admin_data['pageName'],'instituteId'=>$admin_data['instituteId']);
										$this->CI->session->set_userdata($sess_data);
										//pr($this->CI->session->all_userdata());
									}

								}

							}

						}
						else if(isset($data['2']) && $data['2'] <> '' && isset($data['3']) && $data['3'] <> '' && isset($data['4']) && $data['4'] <> '')
						{
							$companyName=base64_decode(urldecode($data['2']));
							$userId=base64_decode(urldecode($data['3']));
							$userType=base64_decode(urldecode($data['4']));
							if($companyName <> '' && $userId > 0)
							{
								$this->CI->load->model('dashboard_model');
								$user_data = $this->CI->dashboard_model->check_users_data($userId,$companyName);
								if(!empty($user_data))
								{
									if($user_data['id'] == $userId)
									{
										$sess_data=array('admin_id'=>$user_data['id'],'admin_email'=>$user_data['email'],'admin_name'=>$user_data['firstName'].$user_data['lastName'],'admin_level'=>3,'institute_name'=>'','company_name'=>$user_data['company'],'instituteId'=>'');
										$this->CI->session->set_userdata($sess_data);
										redirect(base_url().'admin/dashboard');
										return false;
									}

								}

							}
						}
					}

					redirect(base_url()."admin/login");
					return false;
				}
				else
				{
					$data=explode('/',$this->CI->uri->uri_string);
					if(in_array('dashboard',$data))
					{
						if(isset($data['2']) && $data['2'] <> '' && isset($data['3']) && $data['3'] && !isset($data['4']))
						{
							$instituteName=base64_decode(urldecode($data['2']));
							$userId=base64_decode(urldecode($data['3']));
							if($instituteName <> '' && $userId > 0)
							{
								$this->CI->load->model('dashboard_model');
								$admin_data = $this->CI->dashboard_model->get_institute_admin_data($userId,$instituteName);
								if(!empty($admin_data))
								{
									if($admin_data['id'] == $userId)
									{
										$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['userName'],'admin_level'=>2,'institute_name'=>$admin_data['pageName'],'instituteId'=>$admin_data['instituteId']);
										$this->CI->session->set_userdata($sess_data);
										redirect(base_url().'admin/dashboard');
										return false;
									}

								}

							}

						}
						else if(isset($data['2']) && $data['2'] <> '' && isset($data['3']) && $data['3'] <> '' && isset($data['4']) && $data['4'] <> '')
						{
							$companyName=base64_decode(urldecode($data['2']));
							$userId=base64_decode(urldecode($data['3']));
							$userType=base64_decode(urldecode($data['4']));
							if($companyName <> '' && $userId > 0)
							{
								$this->CI->load->model('dashboard_model');
								$user_data = $this->CI->dashboard_model->check_users_data($userId,$companyName);
								if(!empty($user_data))
								{
									if($user_data['id'] == $userId)
									{
										$sess_data=array('admin_id'=>$user_data['id'],'admin_email'=>$user_data['email'],'admin_name'=>$user_data['firstName'].$user_data['lastName'],'admin_level'=>3,'institute_name'=>'','company_name'=>$user_data['company'],'instituteId'=>'');
										$this->CI->session->set_userdata($sess_data);
										redirect(base_url().'admin/dashboard');
										return false;
									}

								}

							}
						}
						elseif(isset($data['2']) && $data['2'] <> '' && !isset($data['3']) && !isset($data['4']))
						{
							
							$userId=base64_decode(urldecode($data['2']));
														//echo $userId;
							if($userId > 0)
							{
								$this->CI->load->model('dashboard_model');

								$admin_info = $this->CI->dashboard_model->get_user_mail($userId);	
								$admin_data = $this->CI->dashboard_model->get_admin_data($admin_info['email']);
								//print_r($admin_info);			
								//print_r($admin_data);		die;	
								if(!empty($admin_data) && ($admin_info['admin_level'] == 4 || $admin_info['admin_level'] == 5))
								{										
									$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['name'],'admin_level'=>$admin_data['level'],'manage_user'=>$admin_data['manage_user']);				
									$this->CI->session->set_userdata($sess_data);
									//pr($this->CI->session->all_userdata());								

								}
								else if(!empty($admin_data) && $admin_info['admin_level'] == 1)
								{
									$sess_data=array('admin_id'=>$admin_data['id'],'admin_email'=>$admin_data['email'],'admin_name'=>$admin_data['name'],'admin_level'=>$admin_data['level'],'manage_user'=>$admin_data['manage_user']);				
									$this->CI->session->set_userdata($sess_data);
								}

							}
							redirect(base_url()."admin/login");
							return false;
						}

					}

				}
			}
		}
		if($this->isLoggedIn())
		{
			$this->CI->load->model('modelbasic');
			$admin_SESSION_ID = intval($this->CI->session->userdata('admin_id'));
			$admin_STATUS = $this->CI->modelbasic->getValueWhere('admin','level',array('id'=>$admin_SESSION_ID));
			if($admin_STATUS == "2" || $admin_STATUS == "3")
			{
				$this->forceLogout($admin_SESSION_ID);
				if($admin_STATUS == "2")
					$msg	=	"Your account is suspended. Contact BridgeB2B admin for re-activation.";
				elseif($admin_STATUS == "3")
					$msg	=	"Your account is closed. Contact BridgeB2B admin for re-activation.";
				$this->CI->session->set_userdata('error', $msg);
				redirect(base_url()."admin/login");
				exit;
			}
		}
	}
	function matchControllerMethod($allowControllerMethodArr,$class)
	{
		$returnMatch	=	false;
		foreach($allowControllerMethodArr as $key)
		{
			if($key == $class)
			{
				$returnMatch	=	true;
			}
		}
		return $returnMatch;
	}
	function forceLogout($loggedInUserId=0)
	{
		$this->CI->load->model('modelusers');
		$this->CI->modelusers->update_user_logout($loggedInUserId);
		$this->CI->modelusers->update_login_logout_log($loggedInUserId,0);
		$this->CI->session->unset_userdata('admin_name');
		$this->CI->session->unset_userdata('admin_id');
		$this->CI->session->unset_userdata('admin_email');
		$this->CI->session->unset_userdata('admin_type');
		$this->CI->session->unset_userdata('front_is_logged_in');
	}
	function isUnderMaintenence()
	{
		$this->CI->load->model('modelbasic');
		$SITE_OFFLINE = $this->CI->modelbasic->getValue('settings','description','type', 'SITE_OFFLINE');
		if($SITE_OFFLINE == "YES")
			return true;
		else
			return false;
	}
}
?>

