<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



	public function getEditFormData($bannerId)
	{
		return $this->db->select('A.*')->from('banner as A')->where('A.id',$bannerId)->get()->row_array();
	}


	

}