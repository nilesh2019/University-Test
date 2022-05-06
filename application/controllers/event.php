<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event extends CI_Controller
{
		
    public function event_list()
	{
		$this->load->model('event_model');	
		$data['event']=$this->event_model->getAllEventData();
		$this->load->view('event_list_view',$data);
	}
	
	public function event_more_data()
	{
    	$per_call_deal = 16;
		$call_count = $_POST['call_count'];
		$this->load->model('event_model');
		$this->event_model->event_more_data($per_call_deal,$call_count);
	}
		
    public function show_event($eventId='')
	{ 
	    $this->load->model('event_model');
	    $user_id=$this->session->userdata('front_user_id');
		$logincount=$this->event_model->getlogincountstudent($user_id);
		//echo $this->db->last_query();
		 $registercount=$this->event_model->getregistercountstudent($user_id);
		//echo $this->db->last_query();
		if(isset($registercount) && !empty($registercount) && $logincount>=0)
		{
			$data['login_percentage']=($logincount/$registercount)*100;
		}
		$data['event']=$this->event_model->getSingleEvent($eventId);
		$this->load->view('event_view',$data);
	}
	
}
