<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appreciatework extends CI_Controller
{	
		
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('appreciatework_model');
		$this->load->model('project_model');
	}
	
	public function save_appreciation($project_id)
	{
		$this->form_validation->set_rules('appreciateText','Appreciate Text','trim|required|xss_clean');
		
		if($this->form_validation->run())
		{
			$comment = $_POST['appreciateText'];
			$uid = $this->session->userdata('front_user_id');
			$data = array(
				'appreciatedUserId' => $_POST['AppreciatedUserId'],
				'appreciateByUserId' => $uid,
				'projectId' => $project_id,
				'comment' => $comment,
				'created'=>date('Y-m-d H:i:s')
			);
			
			$res = $this->appreciatework_model->save($data);
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));

			   	$proDetail          = $this->project_model->getProjectDetail($project_id);
				$appreciationTo          = $this->model_basic->loggedInUserInfoById($_POST['AppreciatedUserId']);
				$appreciationBy         = $this->model_basic->loggedInUserInfoById($uid);
				$emailTo            = $appreciationTo['email'];
				$from               = $emailFrom;
				$nameBy             = ucwords($appreciationBy['firstName'].' '.$appreciationBy['lastName']);
				$nameTo             = ucwords($appreciationTo['firstName'].' '.$appreciationTo['lastName']);
				$templateAppreciationTo  = 'Hello <b>'.$nameTo. '</b>, <br /><b>'.$nameBy.'</b> recently appreciated your project work of project "<b>' .$proDetail[0]['projectName'].'</b>" on creosouls.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$emailAppreciationTo = array('to' =>$emailTo,'subject'  =>'Someone has appreciated your work','template' =>$templateAppreciationTo,'fromEmail'=>$from);
				//$this->model_basic->sendMail($emailAppreciationTo);
				$notificationEntry=array('title'=>'New project appreciation','msg'=>$nameBy.' appreciated your work by viewing your project '.$proDetail[0]['projectName'],'link'=>'profile','imageLink'=>'users/thumbs/'.$appreciationBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>16,'redirectId'=>$project_id);
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
				$notificationToOwner=array('notification_id'=>$notificationId,'user_id'=>$_POST['AppreciatedUserId']);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToOwner);

				$this->session->set_flashdata('success', 'Thank you for Appreciation');
				redirect('project/projectDetail/'.$project_id.'/'.$uid);
			}
			else
			{
				$this->session->set_flashdata('fail', 'Sorry! Failed to post appreciation');
				redirect('project/projectDetail/'.$project_id.'/'.$uid);
			}
		}
		else{
			$this->session->set_flashdata('fail', 'Fill the comment box.');
			redirect('project/projectDetail/'.$project_id.'/'.$uid);
		}
	}	
	
	public function manage_appreciatework()
	{
	   $data['appriciation'] = $this->appreciatework_model->getAllAppriciate();
	   $this->load->view('appreciated_view',$data);
	}	
	
	public function more_data()
	{
		$per_call_deal = 6;
	   	$call_count = $_POST['call_count'];
		$this->appreciatework_model->more_data($per_call_deal,$call_count);
	}
	
	
	public function change_status()
	{
		$res = $this->appreciatework_model->change_status($_POST['id'],$_POST['status']);
		if($res>0)
		{
			echo 'done';
		}
		
	}
	
	
}