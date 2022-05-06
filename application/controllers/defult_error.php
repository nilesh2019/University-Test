<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Defult_error extends MY_Controller
{
	public function index()
	{
		$this->load->view('defult_error_view');		
	}
}

?>