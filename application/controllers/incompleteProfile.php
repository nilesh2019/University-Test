<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class IncompleteProfile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('model_basic');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$userId=$this->session->userdata('front_user_id');
		$userDetails=$this->login_model->getUserDetail($userId);
		//print_r($userDetails);die;
		//$userDetails[0]['notificationEntry']=$this->model_basic->getValue('user_email_notification_relation','userId'," `userId` = '".$userId."'");
		
		if(isset($_POST))
		{
			if(isset($_POST['type']) && $_POST['type']=='')
			{
				$this->form_validation->set_rules('type', 'Type', 'trim|required');
			}
			/*if(isset($_POST['type']) && $_POST['type']=='0' && $_POST['college']=='')
			{
				$this->form_validation->set_rules('college', 'College Name', 'trim|required');
			}*/
			if(isset($_POST['type']) && $_POST['type']=='2' && $_POST['company']=='')
			{
				$this->form_validation->set_rules('company', 'Company Name', 'trim|required');
			}
			$this->form_validation->set_rules('incompleteHidden', 'Hidden Field', 'trim|required');
		}
		else{
			if(isset($userDetails) && $userDetails[0]['type']=='')
			{
				$this->form_validation->set_rules('type', 'Type', 'trim|required');
			}
			/*if(isset($userDetails) && $userDetails[0]['type']=='0' && $userDetails[0]['college']=='')
			{
				$this->form_validation->set_rules('college', 'College Name', 'trim|required');
			}*/
			if(isset($userDetails) && $userDetails[0]['type']=='2' && $userDetails[0]['company']=='')
			{
				$this->form_validation->set_rules('company', 'Company Name', 'trim|required');
			}
		}
		if(isset($userDetails) && $userDetails[0]['firstName']=='')
		{
			$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
		}
		if(isset($userDetails) && $userDetails[0]['lastName']=='')
		{
			$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
		}
		if(isset($userDetails) && $userDetails[0]['gender']=='')
		{
			$this->form_validation->set_rules('gender', 'Gender', 'required');
		}	
		if(isset($userDetails) && $userDetails[0]['contactNo']=='')
		{
			$this->form_validation->set_rules('contactNo', 'Contact No', 'trim|required');
		}	
		
		if($this->form_validation->run())
		{
			$data=array(); 
			if(isset($_POST['firstName']))
			{
				$firstName=$_POST['firstName'];
				$data['firstName']=$firstName;
			}
			if(isset($_POST['lastName']))
			{
				$lastName=$_POST['lastName'];
				$data['lastName']=$lastName;
			}
			if(isset($_POST['gender']))
			{
				$gender=$_POST['gender'];
				$data['gender']=$gender;
			}
			if(isset($_POST['type']))
			{
				$type=$_POST['type'];
				$data['type']=$type;
			}
			if(isset($_POST['contactNo']))
			{
				$contactNo=$_POST['contactNo'];
				$data['contactNo']=$contactNo;
			}
			if(isset($_POST['city']))
			{
				$city=$_POST['city'];
				$data['city']=$city;
			}
		/*	if(isset($_POST['college']))
			{
				$college=$_POST['college'];
				$data['college']=$college;
			}*/
			if(isset($_POST['company']))
			{
				$company=$_POST['company'];
				$data['company']=$company;
			}
			
			$newNotificationEntry=array();
			$newNotificationEntry['new_job']=1;		
			$newNotificationEntry['weeklyNewsletter']=1;		
			$newNotificationEntry['new_competition']=1;		
			$newNotificationEntry['new_institute']=1;		
			$newNotificationEntry['follow_unfollow']=1;		
			$newNotificationEntry['new_project_followed']=1;		
			$newNotificationEntry['project_like']=1;		
			$newNotificationEntry['project_comment']=1;			
			if(!empty($newNotificationEntry))
			{
				$newNotificationEntry['userId']=$userId;
				$this->model_basic->_insert('user_email_notification_relation',$newNotificationEntry);
			}			
			if(!empty($data))
			{
				$this->model_basic->_update('users','id',$userId,$data);
			}
			$this->session->set_userdata('userProfileComplete','TRUE');
			$this->session->set_flashdata('success', 'Your profile updated successfully on creosouls.');
			redirect(base_url());
			exit();
		}
		else{
			$data['detail']=$userDetails;
			$this->load->view('incompleteProfile_view',$data);
		}
		
	}
}