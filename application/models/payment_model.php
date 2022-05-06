<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getUserProfileData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
	    return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row();
	}
	public function getUserNotificationData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
	    return $this->db->select('*')->from('user_email_notification_relation')->where('userId',$user_id)->get()->row();
	}
	public function getUserWorkData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
	    return $this->db->select('*')->from('users_work')->where('user_id',$user_id)->order_by('endingDate','asc')->get()->result_array();
	}
	public function getUserSkillData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
	  return  $this->db->select('*')->from('users_skills')->where('user_id',$user_id)->get()->result_array();
	}
	public function getUserEducationData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_education')->where('user_id',$user_id)->get()->result_array();
	}
	public function getUserWebsiteData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('user_web_reference')->where('user_id',$user_id)->get()->result_array();
	}
	public function getUserCardData()
	{
		$user_id=$this->session->userdata('front_user_id');
		return $this->db->select('*')->from('user_card_detail')->where('user_id',$user_id)->get()->result_array();
	}
	public function getUserSocialData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('social_link')->where('user_id',$user_id)->get()->row_array();
	}
	public function getAwardData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_award')->where('user_id',$user_id)->get()->result_array();
	}
	public function getAllowedDiskSpace()
	{
		return $this->db->select('*')->from('settings')->where('settings_id',14)->get()->result_array();
	}
	public function getUsersAllProject()
	{
			$user_id=$this->session->userdata('front_user_id');
			return $this->db->select('id')->from('project_master')->where('userId',$user_id)->get()->result_array();
	}
	 public function getAllImages($projectId)
	{
		return $this->db->select('B.image_thumb')->from('project_master as A')->join('user_project_image as B','B.project_id=A.id')->where('A.id',$projectId)->get()->result_array();
	}
	public function successPayUMoney($data){
		$this->db->insert('storage_space_payment_log',$data);
		return $this->db->insert_id();
	}
	public function addSpaceToUser($newSpace,$userId){
		$this->db->select('disk_space');
		$this->db->from('users');
		$this->db->where('id',$userId);
		$result = $this->db->get()->row_array();
		$newSpace = $newSpace + $result['disk_space'];
		$this->db->where('id',$userId);
		$this->db->update('users',array('disk_space'=>$newSpace));
		return $this->db->affected_rows();
	}
}