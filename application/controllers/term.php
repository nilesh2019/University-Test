<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Term extends CI_Controller
{
	public function index()
	{
		$this->load->view('term_policy_view');
	}
	
}
