<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myboard extends CI_Controller
{	
		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('myboard_model');
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','My Board');
		$this->session->set_userdata('breadCrumbLink','myboard');
	}
	
	public function index()
	{
		$data['project']=$this->myboard_model->getAllProjectData();	
		$data['category']=$this->myboard_model->getAllCategory();
		if($this->session->userdata('user_institute_id') !='')
		{ 
			$data['job'] = $this->myboard_model->getLimitedJob();
		}
		else
		{
			$data['job'] = array();
		}
	    $this->load->view('myboard_view',$data);
	}
	
	public function more_data()
	{
		$per_call_deal = 4;
	 	$call_count = $_POST['call_count'];
		$this->load->model('myboard_model');
		$this->myboard_model->more_data($per_call_deal,$call_count);
	}
	
	
	public function addToMyboard()
	{
		if(isset($_POST['proId'])&&$_POST['proId']!='')
		{
			$existIn = $this->myboard_model->checkInMyboard($_POST['proId']);
		
		    if(empty($existIn))
		    {
				$result = $this->myboard_model->addToMyboard($_POST['proId']);
				if($result > 0)
				{
					echo 'done';
				}
			}
		 }
	}
	
	
	public function removeFromMyboard()
	{
		if(isset($_POST['proId'])&&$_POST['proId']!='')
		{
		    $existIn = $this->myboard_model->checkInMyboard($_POST['proId']);
		    if(!empty($existIn))
		    {
				$result = $this->myboard_model->removeFromMyboard($_POST['proId']);
				if($result > 0)
				{
					echo 'done';
				}
				
			}
		}
	}
	
	
	
	
	
	
}