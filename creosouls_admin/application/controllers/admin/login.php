<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2014
*	http://unichronic.com
*	Unichronic - Master Admin
*/

class Login extends MY_Controller
{

	function __construct()
	{
	    	parent::__construct();
	    	$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run())
		{
			$condition=array('email'=>$this->input->post('email'),'password'=>md5($this->input->post('password')));
			$id=$this->modelbasic->getValueWhere('admin','id',$condition);
			if($id > 0)
			{
				if($this->input->post('remember')=="on")
				{
					$this->load->helper('cookie');
					$cookie = array(
									    'name'   => 'admin_id',
									    'value'  =>$id,
									    'expire' => '86500',
									);

					$this->input->set_cookie($cookie);
				}
				$userInfo=$this->modelbasic->get_where('admin',$id)->row();
               // echo "<pre>";rint_r($userInfo);exit();
				$data=array('admin_id'=>$userInfo->id,'admin_email'=>$userInfo->email,'admin_name'=>$userInfo->name,'admin_level'=>$userInfo->level,'manage_user'=>$userInfo->manage_user);
				$this->session->set_userdata($data);
				$data=array('status'=>'success','message'=>'Welcome .');
				echo json_encode($data);
			}
			else
			{
				$data=array('status'=>'fail','message'=>'Invalid email address or password');
				echo json_encode($data);
			}
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo $this->form_validation->get_json();
			}
			else
			{
				//$this->load->view('admin/users/login_view');
				redirect(front_base_url());
			}
		}
	}

	function ajax_login()
	{
		$response = array();

		//Recieving post input of email, password from ajax request
		$email 		= $_POST["email"];
		$password 	= $_POST["password"];
		$response['submitted_data'] = $_POST;

		//Validating login
		$login_status = $this->validate_login( $email ,  $password );
		$response['login_status'] = $login_status;
		if ($login_status == 'success')
		{
			$response['redirect_url'] = '';
		}
		//Replying ajax request with validation response
		echo json_encode($response);
	}

    //Validating login from ajax request
    function validate_login($email	=	'' , $password	 =  '')
    {
		 $credential	=	array(	'email' => $email , 'password' => $password );
		 // Checking login credential for admin
        	$query = $this->db->get_where('admin' , $credential);
        	if ($query->num_rows() > 0) {
            $row = $query->row();
			  $this->session->set_userdata('admin_login', '1');
			  $this->session->set_userdata('admin_id', $row->admin_id);
			  $this->session->set_userdata('name', $row->name);
			  $this->session->set_userdata('login_type', 'admin');
			  return 'success';
		}

		return 'invalid';
    }

    /***DEFAULT NOR FOUND PAGE*****/
    function four_zero_four()
    {
        $this->load->view('four_zero_four');
    }


	/***RESET AND SEND PASSWORD TO REQUESTED EMAIL****/
	function reset_password()
	{
		$account_type = $this->input->post('account_type');
		if ($account_type == "") {
			redirect(base_url(), 'refresh');
		}
		$email  = $this->input->post('email');
		$result = $this->email_model->password_reset_email($account_type, $email); //SEND EMAIL ACCOUNT OPENING EMAIL
		if ($result == true) {
			$this->session->set_flashdata('flash_message', get_phrase('password_sent'));
		} else if ($result == false) {
			$this->session->set_flashdata('flash_message', get_phrase('account_not_found'));
		}

		redirect(base_url(), 'refresh');
	}
    /*******LOGOUT FUNCTION *******/


}

