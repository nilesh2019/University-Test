<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('model_basic');
		$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		$job_status = $this->model_basic->getValue($this->db->dbprefix('users'),"job_status"," `id` = '".$FRONT_USER_SESSION_ID."'");
		if($job_status == 0)
		{	
			if($FRONT_USER_SESSION_ID == 0)
			{
				redirect('hauth/googleLogin');
			}
			else
			{		
				$this->session->set_flashdata('error', 'You do not have access to this data.');
				redirect(base_url());
				exit();
			}
		}
	}
	public function index()
	{
		$data['jobs']=$this->job_model->getAllData();
		//print_r($data);
		$this->load->view('job_view',$data);
	}
	public function jobDetail($id)
	{
		$applicant=$this->job_model->checkAppliedOrNot($id);		
		$applicantApproveFromAdmin=$this->job_model->checkJobAppliedApproveFromAdmin($id);	
		$applicantApproveFromHoAdmin=$this->job_model->checkJobAppliedApproveFromRAHAdmin($id);	
		$data['interview_testdata']=$this->job_model->check_interview_assignmnetdata($id);
	   // echo $this->db->last_query();
		//print_r($interview_testdata);die;
		$data['apply_status']=0;	
		$data['tempJobId'] = 0;
		if(!empty($applicantApproveFromAdmin) && $applicantApproveFromAdmin['apply_status'] == 0)
		{
			$data['apply_status']=7;	
		}
		else if(!empty($applicantApproveFromAdmin) && $applicantApproveFromAdmin['apply_status'] == 2)
		{
			$data['apply_status']= 8;
			$data['tempJobId']=$applicantApproveFromAdmin['id'];		
		}
		if(isset($applicantApproveFromHoAdmin) && !empty($applicantApproveFromHoAdmin))
		{
			$data['tempJobId']=$applicantApproveFromHoAdmin['id'];
		}

		if(!empty($applicant))
		{
			$data['apply_status']=$applicant['apply_status'];			
		}

		$userId=$this->session->userdata('front_user_id');
		$data['getstudenteducation_details']=$this->model_basic->getValueArray("users_education","id",array('user_id'=>$userId));
		$data['getstudentskill_details']=$this->model_basic->getValueArray("users_skills","id",array('user_id'=>$userId));
		$data['getstudentAge']=$this->model_basic->getData("users",'age,contactNo,dob,about_me',array('id'=>$userId));
		$data['getprojectdetails']=$this->model_basic->getData("project_master",'id,projectName',array('userId'=>$userId,'showreel'=>'1'));
		//echo $this->db->last_query();
		$data['jobs']=$this->job_model->getSingleJobData($id);
		$this->session->unset_userdata('edit_profile_jobsId');
		$this->load->view('single_job_view',$data);
	}
	public function jobApply($id)
	{
		$data['jobs']=$this->job_model->getSingleJobData($id);
		$this->jobDetail($id);
		//$this->load->view('single_job_view',$data);
	}
	public function more_data()
	{
		$per_call_deal = 8;
		$call_count = $_POST['call_count'];
		$active_tab = $_POST['active_tab'];
		$this->job_model->more_data($per_call_deal,$_POST);
	}
	public function getRelationdata($id)
	{
	  return	$this->job_model->getRelationdata($id);
    }
	public function uploadResume($jobId='')
	{
		$userId=$this->session->userdata('front_user_id');		
		$getstudenteducation_details=$this->model_basic->getValueArray("users_education","id",array('user_id'=>$userId));
		$getstudentAge=$this->model_basic->getValue("users",'age'," `id` = '".$userId."'");
		
		if(empty($getstudentAge) && $getstudentAge==0 || empty($getstudenteducation_details))
		{
			$this->session->set_flashdata('error', 'Education OR age detilas are Empty.');
		}
		else
		{
			$institute_id=$this->session->userdata('user_institute_id');				
			$data=array('userId'=>$userId,'jobId'=>$jobId,'resume'=>'','apply_date'=>date('Y-m-d H:i:s'),'institute_id'=>$institute_id);    		
			$res=$this->job_model->add($data);
			$getInstituteAdminInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->join('institute_master as B','B.adminId = A.id')->where('B.id',$institute_id)->get()->row_array();
			//$RecruiterEmailId = $this->db->select('recruiter_email_id')->from('jobs')->where('id',$jobId)->get()->row_array();	
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$jobDetails=$this->model_basic->get_where('jobs',array('id'=>$jobId));				
				$jobName=$jobDetails['title'];
				$userDetails=$this->model_basic->loggedInUserInfoById($this->session->userdata('front_user_id'));
				$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job <b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$this->session->userdata('front_user_id').'">Click here</a> to see his portfolio.';				
				$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteAdminInfo['email'],'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
				//$this->model_basic->sendMail($data);
				$notificationEditEntryAdmin=array('title'=>'Someone has applied for the job','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$jobId,'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$jobId);
				$notificationIdAdmin=$this->model_basic->_insert('header_notification_master',$notificationEditEntryAdmin);
				$insertJobNotificationAdmin = array('notification_id'=>$notificationIdAdmin,'user_id'=>$getInstituteAdminInfo['id'],'status'=>0);
				$this->model_basic->_insert('header_notification_user_relation',$insertJobNotificationAdmin);
				
				$msg = array (
					'body' 	=> '',
					'title'	=> '',
					'aboutNotification'	=> ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job ',
					'notificationTitle'	=> 'Someone has applied for the job',
					'notificationType'	=> 1,
					'notificationId'	=> $jobId,
					'notificationImageUrl'	=> ''          	
		        );
				$this->model_basic->sendNotification($getInstituteAdminInfo['id'],$msg);

				$notificationEditEntryUser=array('title'=>'Successfully applied for job.(Pendig Admin Approve)','msg'=>'Applied for job '.$jobName.' posted on creosouls is pendig admin approve','link'=>'job/jobDetail/'.$jobId,'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$jobId);
				$notificationIdUser=$this->model_basic->_insert('header_notification_master',$notificationEditEntryUser);
				$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$userId,'status'=>0);
				$this->model_basic->_insert('header_notification_user_relation',$insertJobNotificationUser);
				$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have successfully applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';				
				$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Successfully applied for job.(Pendig Admin Approve)','template'=>$templateForApplicant);
				//$this->model_basic->sendMail($dataApplicant);
				
				$msg1 = array (
					'body' 	=> '',
					'title'	=> '',
					'aboutNotification'	=> 'You have successfully applied for the job.(Pendig Admin Approve)',
					'notificationTitle'	=> 'Successfully applied for job',
					'notificationType'	=> 1,
					'notificationId'	=> $jobId,
					'notificationImageUrl'	=> ''          	
		        );
				$this->model_basic->sendNotification($userId,$msg1);

				$this->session->set_flashdata('success', ' You have successfully applied for job.');
				redirect('job/jobDetail/'.$jobId);
			}
			else
			{
				$this->session->set_flashdata('error', 'Error occurred while applying for job.');
				redirect('job/jobDetail/'.$jobId);
			}			
		}			
	}

	public function search_more_data()
	{
		$per_call_deal = 8;
		$call_count = $_POST['call_count'];
		$active_tab = $_POST['active_tab'];
		$this->job_model->search_more_data($per_call_deal,$_POST);
	}

	public function get_comment()
	{
		$id = $_POST['reject_comment_Id'];
		$data = $this->model_basic->getData('job_user_relation_admin_approval','*',array('id'=>$id),$order='',$limit='',$offset='');
		$html = '';
		if(!empty($data) && $data['comment'] != '')
		{
			$html .= $data['comment'];
		}
		echo $html;
	}

	public function get_comment1()
	{
		$id = $_POST['reject_comment_Id'];
		$data = $this->model_basic->getData('job_user_relation_rahadmin_approval','*',array('id'=>$id),$order='',$limit='',$offset='');
		$html = '';
		if(!empty($data) && $data['comment'] != '')
		{
			$html .= $data['comment'];
		}
		echo $html;
	}	

	public function get_comment2()
	{
		$id = $_POST['reject_comment_Id'];
		$data = $this->model_basic->getData('job_user_relation_rph_approval','*',array('id'=>$id),$order='',$limit='',$offset='');
		$html = '';
		if(!empty($data) && $data['comment'] != '')
		{
			$html .= $data['comment'];
		}
		echo $html;
	}
}
