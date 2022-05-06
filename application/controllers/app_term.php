<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class App_term extends CI_Controller
{
	public function index()
	{
		$this->load->view('app_term_policy_view');
	}
	
}
