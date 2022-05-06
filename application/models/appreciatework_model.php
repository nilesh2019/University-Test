<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appreciatework_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function getAppriciate($pro_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('project_appreciation');
		$this->db->where('appreciateByUserId',$user_id);
		$this->db->where('projectId',$pro_id);
		return $this->db->get()->row();		
	}
	
	public function save($data)
	{
		if(!empty($data))
		{
			if($this->db->insert('project_appreciation',$data))
			{
				return 1;
			}
			else{
				return 0;
			}
		}
	}
	
	
	public function getAllAppriciate()
	{
		$this->db->select('users.firstName,users.firstName,users.lastName,users.profession,users.profileImage,users.city,users.country,project_appreciation.comment,project_appreciation.status,project_appreciation.id');
		$this->db->from('project_appreciation');
		$this->db->limit(6);
		$this->db->where('project_appreciation.appreciatedUserId',$this->session->userdata('front_user_id'));
	  	$this->db->join('users', 'project_appreciation.appreciateByUserId = users.id');
		return $this->db->get()->result_array();	
		
	}
	
	public function more_data($limit,$page)
	{
		$start = ($page - 1) * $limit;
		$this->db->select('users.firstName,users.firstName,users.lastName,users.profession,users.profileImage,users.city,project_appreciation.comment,project_appreciation.status,,project_appreciation.id');
		$this->db->from('project_appreciation');
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->where('project_appreciation.appreciatedUserId',$this->session->userdata('front_user_id'));
	  	$this->db->join('users', 'project_appreciation.appreciateByUserId = users.id');
		return $this->db->get()->result_array();	
		
	}
	
	public function change_status($id,$status)
	{
		$this->db->where('id',$id);
		$this->db->where('appreciatedUserId',$this->session->userdata('front_user_id'));
	  	return $this->db->update('project_appreciation',array('status'=>$status));
    }
    
    
    
    public function getAllAppriciation($uid)
	{
		$this->db->select('users.firstName,users.firstName,users.lastName,users.profession,users.profileImage,users.city,users.country,project_appreciation.comment,project_appreciation.status,project_appreciation.id');
		$this->db->from('project_appreciation');
		$this->db->where('project_appreciation.status',1);
		$this->db->where('project_appreciation.appreciatedUserId',$uid);
	  	$this->db->join('users', 'project_appreciation.appreciateByUserId = users.id');
		return $this->db->get()->result_array();	
		
	}
	
	public function getAllAppriciationExists($uid)
	{
		$this->db->select('users.firstName,users.firstName,users.lastName,users.profession,users.profileImage,users.city,users.country,project_appreciation.comment,project_appreciation.status,project_appreciation.id');
		$this->db->from('project_appreciation');
		$this->db->where('project_appreciation.appreciatedUserId',$uid);
	  	$this->db->join('users', 'project_appreciation.appreciateByUserId = users.id');
		return $this->db->get()->result_array();	
		
	}
}