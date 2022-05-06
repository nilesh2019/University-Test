<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Enroll_users extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/user_model');
	    if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
	}

	public function index()
	{
		$data['institute'] = $this->user_model->getAllInstitute();
		$this->load->view('admin/users/enroll_users',$data);
	}

	public function check_enroll_student()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('studentid', 'Student Id', 'required');
		if($this->form_validation->run())
		{
			$studentid=$this->input->post("studentid");
			$find=$this->user_model->find_studentid($studentid);
			if((isset($find->id) && !empty($find->id)) && (isset($find->email) && !empty($find->email)))
			{
				echo "Login email associated with the Student id <b style='color:blue;'>".$studentid."</b> is <b style='color:blue;'>".$find->email.".</b>";
			}
			elseif ((isset($find->id) && !empty($find->id)) && empty($find->email)) 
			{
				echo "Student id <b style='color:blue;'>".$studentid."</b> is only enrolled and not logged in yet.";
			}
			else
			{
				echo "Student id not found. Kindly send an email to creosouls support team <b style='color:blue;'>(support@creosouls.com)</b> along with student details.";
			}
		}
	}
}
