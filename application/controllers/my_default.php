<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_default extends CI_Controller
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
     //echo "Inside";exit();

		/*if($this->uri->total_segments() === 0){
                redirect('my_default','refresh');
            }

*/
		if($this->session->userdata('front_user_id') !='' && $this->session->userdata('front_user_id') > 0 && $this->session->userdata('guest_user') =='' && $this->session->userdata('guest_user') !='guest_user')
		{
			redirect('home');
		}
		else
		{
			$this->load->view('my_default_view');
		}
	}

	public function term_and_cond($filter='',$userId='',$LoginId='')
	{
		if(isset($filter) && $filter !='')
		{
			$data['terms_and_condition'] = $filter;
			$data['userId'] = $userId;
			$data['loginId'] = $LoginId;
		}
	}
}
