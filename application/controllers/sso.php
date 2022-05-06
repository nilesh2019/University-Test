<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Sso extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	function getloginurl($useremail, $firstname='', $lastname='', $username='', $ipaddress='', $courseid = null, $modname = null, $activityid = null) {

	    $token        = '535c0076f5a9816d8a12c88065f3436b';

	    //$domainname   = 'http://www.emmersivetech.in/LMS/Emmersive';

            $domainname   = 'https://emmersivedemo.obinco.com/';

	    $functionname = 'auth_userkey_request_login_url';
	    require_once(APPPATH.'libraries/Curl.php');
	    $param = [
		    'user' => [
		    'firstname' => $firstname,
		    'lastname' => $lastname,
		    'username' => $username,
		    'email' => $useremail
		    ]
	    ];
	    
           // echo json_encode($param);die;
	    
           /*$user2 = new stdClass();
	    $user2->username = 'testusername2';
	    $user2->firstname = 'testfirstname2';
	    $user2->lastname = 'testlastname2';
	    $user2->email = 'testemail2@moodle.com';
	    $param = array('user' => $user2);*/
	    
	    $serverurl = $domainname . '/webservice/rest/server.php' . '?wstoken=' . $token . '&wsfunction=' . $functionname . '&moodlewsrestformat=json';

	   //echo $serverurl;die;

	    $curl = new curl;
	    try {
	       $resp     = $curl->post($serverurl, $param);
	         print_r($serverurl); print_r($param);
                 $resp     = json_decode($resp);
                 print_r($resp);
	         $loginurl = $resp->loginurl;
	        //echo $loginurl;die;
	    } catch (Exception $ex) {
	        return false;
	    }

	    if (!isset($loginurl)) {
	        return false;
	    }

	    $path = '';
	    if (isset($courseid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/course/view.php?id=$courseid");
	    }
	    if (isset($modname) && isset($activityid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/mod/$modname/view.php?id=$activityid");
	    }

	    return $loginurl . $path;
	}

	function lmsLogin()
	{
		//print_r($this->session->all_userdata());die;
		if($this->session->userdata('front_user_id') > 0)
		{
			$userData = $this->model_basic->loggedInUserInfoById($this->session->userdata('front_user_id'));
                        //print_r($userData);die;
			$lms_login_link=$this->getloginurl($userData['email'],$userData['firstName'],$userData['lastName'],$userData['email']);
                        //print_r($lms_login_link);die;
			redirect($lms_login_link);
		}
	}

	function getAssesmentloginurl($useremail, $firstname='', $lastname='', $contact_no='', $city='', $profileImage='', $ipaddress='', $courseid = null, $modname = null, $activityid = null)
	{
	    require_once(APPPATH.'libraries/Curl.php');
	    $param = [
		    'user' => [
		    'firstname' => $firstname,
		    'lastname' => $lastname,
		    'contact_no' => $contact_no,
            'city' => $city,
            'photo' => $profileImage,
		    'email' => $useremail
		    ]
	    ];

	    $serverurl='https://assessments.creonow.com/auth/sso_login_url';

           // $serverurl='http://quiz.emmersivedemos.in/auth/sso_login_url';

	    $curl = new curl;
	    try {
	        $resp     = $curl->post($serverurl, $param);
	        //print_r($resp);die;
	        $resp     = json_decode($resp);
	        if(isset($resp->loginurl) && $resp->loginurl != '')
	        {
	        	$loginurl = $resp->loginurl;
	        }
	        else
	        {
	        	$this->session->set_flashdata('error', $resp->message);
	        	redirect(base_url());
	        	return false;
	        }
	        //echo $loginurl;die;
	    } catch (Exception $ex) {
	        return false;
	    }

	    if (!isset($loginurl)) {
	        return false;
	    }

	    $path = '';
	    if (isset($courseid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/course/view.php?id=$courseid");
	    }
	    if (isset($modname) && isset($activityid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/mod/$modname/view.php?id=$activityid");
	    }

	    return $loginurl . $path;
	}

	function AssesmentLogin()
	{
		//echo "AssesmentLogin";die();
               
		if($this->session->userdata('front_user_id') > 0)
		{
			$userData = $this->model_basic->loggedInUserInfoById($this->session->userdata('front_user_id'));

                       // print_r($userData);exit;

                        $lms_login_link = $this->getAssesmentloginurl($userData['email'],$userData['firstName'],$userData['lastName'],$userData['contactNo'],$userData['city'],$userData['profileImage']);
                        
                        //print_r($lms_login_link);exit;
                        
                        redirect($lms_login_link);
		}
	}
  
  	function TrainingLogin()
	{
		//echo "TrainingLogin";die(); 
        if($this->session->userdata('front_user_id') > 0)
        {
          $userData = $this->model_basic->loggedInUserInfoById($this->session->userdata('front_user_id'));

          //print_r($userData);exit;

          $lms_login_link = $this->getTrainingLoginurl($userData['email'],$userData['firstName'],$userData['lastName'],$userData['email']);

          //print_r($lms_login_link);exit;

          redirect($lms_login_link);
        }
	}
  
  	function getTrainingLoginurl($useremail, $firstname='', $lastname='', $username='', $ipaddress='', $courseid = null, $modname = null, $activityid = null)
	{
	    require_once(APPPATH.'libraries/Curl.php');
	    $param = [
		    'user' => [
		    'firstname' => $firstname,
		    'lastname' => $lastname,
		    'username' => $username,
		    'email' => $useremail
		    ]
	    ];

	    $serverurl='https://training.creonow.com/auth/sso_login_url';

	    $curl = new curl;
	    try {
	        $resp = $curl->post($serverurl, $param);
          	//echo "<pre/>"; print_r($resp); die;
	        $resp     = json_decode($resp);
	        if(isset($resp->loginurl) && $resp->loginurl != '')
	        {
	        	$loginurl = $resp->loginurl;
	        }
	        else
	        {
	        	$this->session->set_flashdata('error', $resp->message);
	        	redirect(base_url());
	        	return false;
	        }
	        //echo $loginurl;die;
	    } catch (Exception $ex) {
	        return false;
	    }

	    if (!isset($loginurl)) {
	        return false;
	    }

	    $path = '';
	    if (isset($courseid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/course/view.php?id=$courseid");
	    }
	    if (isset($modname) && isset($activityid)) {
	        $path = '&wantsurl=' . urlencode("$domainname/mod/$modname/view.php?id=$activityid");
	    }

	    return $loginurl . $path;
	}
}





