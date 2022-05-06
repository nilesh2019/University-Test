<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Timeline_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
	}
	public function getCount($date,$user_id,$users_instutude_id='')
	{		
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('userId',$user_id);		
		if($users_instutude_id !='' && $users_instutude_id == $this->session->userdata('user_institute_id'))
		{			
			$this->db->where('(`status` = 1 OR `status` = 3)');
		}
		else
		{
			$this->db->where('status',1);
		}
		$this->db->like('created',$date);
	 	return $this->db->get()->num_rows();
	 	//echo $this->db->last_query();
	}

	function get_users_instutude_id($user_id)
	{
		//echo "ckvj";die;
		$this->db->select('instituteId');
		$this->db->from('users');
		$this->db->where('id',$user_id);	
		return $this->db->get()->row();		
	}

	    public function getUserTimelineProject($uid='',$other_user_institute_Id='',$limit='')
		{
			$institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));			
			if($uid!='')
			{
				$user_id=$uid;
			}
			else
			{
				$user_id=$this->session->userdata('front_user_id');
			}
			if($other_user_institute_Id!='')
			{
				$other_user_instituteId=$other_user_institute_Id;
			}
			else
			{
				$other_user_instituteId=$institute;
			}

			$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,users.profession,users.city,project_master.created');
		    $this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->where('users.id',$user_id);
			
				 if(isset($other_user_instituteId) && !empty($other_user_instituteId))
				   {
						if($other_user_instituteId==$this->session->userdata('user_institute_id'))
						{										
							$where = "(( project_master.status=1) OR ( project_master.status=3))";
						    $this->db->where($where);
						}
						else
						{						
							$this->db->where('project_master.status',1);
						}
					}

					elseif(isset($other_user_instituteId) && !empty($other_user_instituteId) && $other_user_instituteId!=0 && $this->session->userdata('user_institute_id')=='')
					{				
						$this->db->where('project_master.status',1);
					}
					else
					{
						  if($user_id == $this->session->userdata('front_user_id'))
							{						
								$where = "(( project_master.status=1))";
					    		$this->db->where($where);
							}
							else
							{
								$this->db->where('project_master.status',1);
							}
					}
					
				if($limit=='')
				{
					$this->db->limit(12);
				}	

			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
		
			$this->db->group_by('project_master.id');
		    $data = $this->db->get()->result_array();
		
			if(!empty($data))
			{ $i=0;
				 foreach($data as $row)
				 {
				 	$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
					$this->db->from('category_master');
					$this->db->where('category_master.id',$row['categoryId']);
				    $this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
					$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				 	$atrribute = $this->db->get()->result_array();
				     if(!empty($atrribute))
					{   $arr=array();
						$arr2=array();
					 	foreach($atrribute as $val)
						{
							$values = $this->get_project_attribute_value($row['id'],$val['id']);
						     if(count($values) > 0)
							   {
							   	 $arr[] = $val['attributeName'];
							   }
							  if(!empty($values))
							   {
							   	 foreach($values as $dt)
							   	 {
								 	$arr2[] = $dt['attributeValue'];
								 }
							   }
						}
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
						$data[$i]['atrribute'] = $arr;
						$data[$i]['attributeValue'] = $arr2;
				   	}
					else
					{
						$data[$i]['atrribute'] = array();
						$data[$i]['attributeValue'] = array();
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					$imageCount = $this->getCountimg('user_project_image','project_id',$row['id']);
					$data[$i]['imageCount'] = $imageCount;
					if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
					{
						$this->db->select('*');
						$this->db->from('user_project_views');
						$this->db->where('projectId',$row['id']);
						$this->db->where('userId',$this->session->userdata('front_user_id'));
						$this->db->where('userLike',1);
						$data[$i]['userLiked'] = $this->db->get()->num_rows();
					}
					else{
						$data[$i]['userLiked']=0;
					}
				    $i++;
				 }
			}
			return $data;
	 }

    function getCountimg($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
    public function getUserInstituteId($userId)
	{
		$this->db->select('instituteId');
		$this->db->from('users');
		$this->db->where('status',1);
		$this->db->where('id',$userId);
	    return $this->db->get()->result_array();
    }

	public function get_project_attribute_value($project_id,$attribute_id)
	{
		$this->db->select('attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('project_attribute_relation');
		$this->db->where('project_attribute_relation.projectId',$project_id);
		$this->db->where('project_attribute_relation.attributeId',$attribute_id);
		$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
	    return $this->db->get()->result_array();
    }


        public function getUserTimelineInfo($uid='')
    	{    			
    		if($uid!='')
    		{
    			$user_id=$uid;
    		}
    		else
    		{
    			$user_id=$this->session->userdata('front_user_id');
    		} 
    		$this->db->select('*');
    	    $this->db->from('users');    	
    		$this->db->where('users.id',$user_id);
    		return $this->db->get()->result_array();
     }

	


}