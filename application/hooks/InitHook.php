<?php
class InitHook
{
	var $CI,$isLoggedIn;
	function __construct(){
	  $this->CI = NULL;
	}
	function loadCustomCommonFunctions(){
		require_once(APPPATH.'third_party/functions'.EXT);
	}
	function initPostController($code="")
	{
		//echo '<h1>yessssssssssssssssss</h1>';
		$this->CI =& get_instance();
		$localhost = array('127.0.0.1','::1');
		
		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
		{
		}
		else
		{
			$this->CI->load->library('aws_sdk');
			$this->CI->aws_sdk->registerStreamWrapper();
            return true;
		}
        $class = $this->CI->router->class;
		$this->CI->load->model('competition_model');
		$this->CI->load->model('creative_mind_competition_model');
		$this->CI->load->model('job_model');
        $this->CI->competition_model->markCompletedCompetions();
		$this->CI->creative_mind_competition_model->markCompletedCompetions();
		$this->CI->job_model->markJobStatus();
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$refererData=explode('/',$_SERVER['HTTP_REFERER']);
			$this->CI->load->model('tracker_model');
				//$this->tracker_model->add_visit();
		}
		//$this->CI->load->model('tracker_model');
		$FRONT_USER_SESSION_ID = intval($this->CI->session->userdata('front_user_id'));
		$this->CI->load->model('model_basic');
		$loginId = $this->CI->session->userdata('user_login_id');
		$this->CI->model_basic->updateLogin($loginId);
		//$this->CI->model_basic->updateLogin('user_login_details','loginId',$loginId,array('logIn_time_current'=>date('Y-m-d h:s:i')));
		if($FRONT_USER_SESSION_ID > 0 && $this->CI->session->userdata('front_is_logged_in') === true && $class != 'incompleteProfile')
		{
			if($this->CI->uri->segment(2)=='userDetail')
			{
				$otherProfileCompletion = $this->CI->model_basic->userProfileMeter($this->CI->uri->segment(3));
				$profileCompletion = $this->CI->model_basic->userProfileMeter($this->CI->session->userdata('front_user_id'));
				$this->CI->session->set_userdata('other_profile_meter',$otherProfileCompletion);
			}
			else{
				$profileCompletion = $this->CI->model_basic->userProfileMeter($this->CI->session->userdata('front_user_id'));
				$this->CI->session->unset_userdata('other_profile_meter');
			}
			if(!$this->CI->session->userdata('profile_meter')||$this->CI->uri->segment(2)=='edit_profile')
			{
			  $this->CI->model_basic->_update('users','id',$this->CI->session->userdata('front_user_id'),array('profile_complete'=>$profileCompletion));
			}
			$this->CI->session->set_userdata('profile_meter',$profileCompletion);
		}
		$emailID=$this->CI->model_basic->getValue('users','email'," `id` = '".$this->CI->session->userdata('front_user_id')."'");
		$juryId=$this->CI->model_basic->getValue('competition_jury','id'," `email` = '".$emailID."'");
		$this->CI->model_basic->_update('competition_jury_relation','juryId',$juryId,array('userId'=>$this->CI->session->userdata('front_user_id')));
		$this->CI->model_basic->_update('creative_competition_jury_relation','juryId',$juryId,array('userId'=>$this->CI->session->userdata('front_user_id')));
		if($FRONT_USER_SESSION_ID > 0 && $this->CI->session->userdata('front_is_logged_in') === true && $class != 'incompleteProfile')
		{
			if(empty($this->CI->session->userdata('userProfileComplete'))){
				$this->CI->session->set_userdata('userProfileComplete','FALSE');
			}
			if($this->CI->session->userdata('userProfileComplete') == "FALSE")
			{
				redirect('incompleteProfile');
			}
		}
		$this->authenticateUser();
	}
	function isLoggedIn()
	{
		$FRONT_USER_SESSION_ID = intval($this->CI->session->userdata('front_user_id'));
		if($FRONT_USER_SESSION_ID > 0 && $this->CI->session->userdata('front_is_logged_in') === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//===================================================================================
    function authenticateUser()
	{
		$class = $this->CI->router->class;
	  	$method = $this->CI->router->method;
		//after login
		$afterLoginControllerMethodArr	=	array('profile','job','people','appreciatework','incompleteProfile');
		// before login
		$beforeLoginControllerMethodArray = array();
		// allways allow
		$alwaysAllowControllerMethodArray = array (
			"home","my_default",
			"hauth","example",
			'inhibitor_handler','newsletter','institute','term','policy','app_term','app_policy','competition','event','project','all_project','incompleteProfile','competition_api','event_api','institute_api','job_api','project_api','user_api','version_api','people_api','blog_api','cron_job','user_import_api', 'institute_import_api','home_api'
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
					$this->CI->load->model('model_basic');
					$FRONT_USER_SESSION_ID = intval($this->CI->session->userdata('front_user_id'));
					$FRONT_USER_STATUS = $this->CI->model_basic->getValue($this->CI->db->dbprefix('users'),"status"," `id` = '".$FRONT_USER_SESSION_ID."'");
					if($FRONT_USER_STATUS==false || $FRONT_USER_STATUS == "2" || $FRONT_USER_STATUS == "3")
					{
						$this->forceLogout($FRONT_USER_SESSION_ID);
						if($FRONT_USER_STATUS == "2")
							$msg	=	"Your account is suspended. Contact CreativeWork admin for re-activation.";
						elseif($FRONT_USER_STATUS == "3")
							$msg	=	"Your account is closed. Contact CreativeWork admin for re-activation.";
						$this->CI->session->set_userdata('error', $msg);
						redirect(base_url());
						exit;
					}
					redirect(base_url());
					return false;
				}
			}
			else
			{
				if(!$this->isLoggedIn())
				{
					//echo $this->CI->uri->uri_string;die;
					$this->CI->session->set_userdata('redirect_back', $this->CI->uri->uri_string);
					//print_r($this->CI->session->all_userdata());die;
					redirect(base_url().'hauth/googleLogin');
					return false;
				}
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
		$this->CI->load->model('model_basic');
		$this->CI->model_basic->_update('user_login_details','userId',$loggedInUserId,array('logOut_time'=>date('Y-m-d H:i:s')));
		$this->CI->session->unset_userdata('front_user_id');
		$this->CI->session->unset_userdata('front_is_logged_in');
	}
}
?>