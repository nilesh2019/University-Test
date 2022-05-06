<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stream extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stream_model');
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','My Stream');
		$this->session->set_userdata('breadCrumbLink','stream');
	}

	public function index()
	{
		$arr = $this->followingUserId();
		$data['followingUserData']=$this->stream_model->getFollowingUserData($arr);
		$data['project']=$this->stream_model->getAllProjectData($arr);
		/*print_r($data);die;	*/
		$data['category']=$this->stream_model->getAllCategory();
		if($this->session->userdata('user_institute_id') !='')
		{
			$data['job'] = $this->stream_model->getLimitedJob();
		}
		else
		{
			$data['job'] = array();
		}
		$this->load->view('stream_view',$data);
	}

	public function followingUserId()
	{
	    $arr = '';
		$this->load->model('stream_model');
		$following_user=$this->stream_model->getAllFollowingUserId();
		if(!empty($following_user))
		{
			foreach($following_user as $row)
			{
				$arr[]=$row['followingUser'];
			}
		}

		return $arr;
	}


	public function unfollow_user($uid)
	{
		$res = $this->stream_model->unfollow_user($uid);
		if($res > 0)
		{
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
			$emailDetailunfollowBy = array('to' => $emailBy,'subject'=>$subjectBy,'template' =>$templateBy,'fromEmail'=>$from);
			$this->model_basic->sendMail($emailDetailunfollowBy);
			redirect('stream');
		}
		else
		{
			$this->session->set_flashdata('fail', 'failed to follow this user.');
			redirect('stream');
		}
	}
	public function more_data()
	{
		$arr = $this->followingUserId();
		$per_call_deal = 6;
	 	$call_count = $_POST['call_count'];
		$this->load->model('stream_model');
		$this->stream_model->more_data($per_call_deal,$call_count,$arr);
	}


	public function timeinline_more_data()
	{
		$per_call_deal = 10;
	  $timeLineArray = ''	;
	  $call_count = $_POST['sliceCount'];

		$this->stream_model->timeline_more_data($call_count,$per_call_deal,$timeLineArray);
	}






}