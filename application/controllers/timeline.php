<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Timeline extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('timeline_model');
		$this->load->model('model_basic');
	}
	public function index()
	{		
		$this->load->view('manage_timeline');
	}
	public function display_timeline($id='')
	{
		if($id != '')
		{
			$id = $id;
		}
		else
		{
			$id = $this->session->userdata('front_user_id');
		}
		$institute = $this->timeline_model->getUserInstituteId($id);
		$limit = 1;		
		$data['complete_project']=$this->timeline_model->getUserTimelineProject($id,$institute[0]['instituteId'],$limit);	
		$data['userInfo']=$this->timeline_model->getUserTimelineInfo($id);	
		$data['user_profile']=$this->user_model->getUserProfileData($this->uri->segment(3));
		$this->load->view('manage_timeline',$data);
	}
}
