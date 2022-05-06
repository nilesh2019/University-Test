<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron_job extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('model_basic');
	}
  /*  public function profile_complete_mail()
	{
		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$limit = 2;
		$id = 1;
		$start = $this->model_basic->getValue('custom_mail','start'," `id` = '".$id."'");
		if(!empty($start))
		{
			$newstart=($start-1)*$limit;
			$a = $newstart+1;
			for($i=$a;$i<=$limit;$i++)
			{   $data=array();
				$userData = $this->model_basic->loggedInUserInfoById($i);
				if($userData['profile_complete'] < 100)
				{
					$Emaildata['fromEmail']=$emailFrom;
					$Emaildata['to']=$userData['email'];
					$Emaildata['subject']='Complete Your Profile';
					$Emaildata['template'] = 'Hi '.ucwords($userData['firstName'].' '.$userData['lastName']).',<br><br> Have You filled all the details in creosouls Profile? Do it now to get more visibility and attention on creosouls.<a href="'.base_url().'user/userDetail/'.$i.'">click here</a> <br><br> Regards,<br> Team creosouls.';
					$this->model_basic->sendMail($Emaildata);
				}
			}
			$data1 = array('start'=>$start+1);
			$this->db->where('id',$id);
			$this->db->update('custom_mail',$data1);
		}
	}*/
/*	  public function profile_complete_mail()
	{
		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$limit = 2;
		$id = 1;
		$start = $this->model_basic->getValue('custom_mail','start'," `id` = '".$id."'");
		if(!empty($start))
		{
			$newstart=($start-1)*$limit;
			$a =$newstart+1;
			for($i=$a;$i<=$limit;$i++)
			{
				echo $i;
				$email = $this->model_basic->getValue('users',"email","id=".$i);
				$data=array();
				$Emaildata['fromEmail']=$emailFrom;
				$Emaildata['to']='pratik.gaikwad@emmersivetech.com';
				$Emaildata['subject']='Complete Your Profile';
				$Emaildata['template']=$this->load->view('emailTemplates/new_UI_email_view',$data,true);
				$this->model_basic->sendMail($Emaildata);
			}
			$data1 = array('start'=>$start+1);
			$this->db->where('id',$id);
			$this->db->update('custom_mail',$data1);
		}
	}*/
  /*   public function profile_complete_mail()
	{
		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$limit = 1;
	      for($i=1;$i<=$limit;$i++)
			{   $data=array();
				$userData = $this->model_basic->loggedInUserInfoById($i);
				if($userData['profile_complete'] < 100)
				{
					$Emaildata['fromEmail']=$emailFrom;
					$Emaildata['to']='pratikgaikwad69@gmail.com';
					$Emaildata['subject']='Complete Your Profile';
					$Emaildata['template'] = 'Hi '.ucwords($userData['firstName'].' '.$userData['lastName']).',<br><br> Have You filled all the details in creosouls Profile? Do it now to get more visibility and attention on creosouls.<a href="'.base_url().'user/userDetail/'.$i.'">click here</a> <br><br> Regards,<br> Team creosouls.';
					$this->model_basic->sendMail($Emaildata);
				}
			}
     }*/
     	public function feedbackReminderToStudent(){
		$endDate = date('Y-m-d',strtotime("2 days"));
		$feedbackInstance = $this->model_basic->getAllFeedbackInstanceForAllInstitute($endDate);
		foreach ($feedbackInstance as $val) {
			$userFeedback = $this->model_basic->getFeedbackUserId($val['id']);
			$userIds = array();
			if(!empty($userFeedback)){
				$instituteId = $userFeedback[0]['institute_id'];
				$i=0;
				foreach ($userFeedback as $userId) {
					$userIds[$i] = $userId['user_id'];
					$i++;
				}
			}else{
				$instituteId = $val['institute_id'];
			}
			$userNotFeedback = $this->model_basic->getUserIdNotFeedback($userIds,$instituteId);
			foreach ($userNotFeedback as $user) {
				$todayDate=date_create(date('Y-m-d'));
				$endDate=date_create($val['end_session']);
				if($endDate == $todayDate){
					$subject='Hurry Up...!! Today is last day for submitting feedback';
					$info=' Evaluation time has been started and today is last day for submitting your feedback';
				}
				if($endDate >= date('Y-m-d')){
					$dateDiff = date_diff($endDate, $todayDate);
					$dateDiff=$dateDiff->format("%a");
					$subject='Hurry Up...!! Only ' .$dateDiff.' days are remaing to submit feedback';
					$info='Evaluation time has been started and only  "<b>' .$dateDiff.'</b>" days are remaining to submit feedback';
				}
				$sendFeedbackEmail=array('to'=>$user['email'],'subject'=>$subject,'template' =>$info,'fromEmail'=>$val['email'],'fromName'=>$val['instituteName']);
				$this->model_basic->sendMail($sendFeedbackEmail);
			}
		}
     	}
}