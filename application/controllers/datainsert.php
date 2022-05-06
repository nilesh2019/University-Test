<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Datainsert extends CI_Controller
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


		
	}

	
}