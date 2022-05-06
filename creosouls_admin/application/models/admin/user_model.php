<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$institute='')
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select($selectColumns,FALSE)->from($table);
		$i=0;
    	if( !empty($requestData['search']['value']) )
    	{
    		foreach ($columns as $value)
    		{
    			if($i==0)
    			{
    				$this->db->like($value,$requestData['search']['value'],'both');
    			}
    			else
    			{
    				if($concatColumns <> '' && $value == $fieldName)
    				{
    					$concat=explode(',', $concatColumns);
    					$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $requestData['search']['value'], 'both',FALSE);
    				}
    				else
    				{
    					$this->db->or_like($value,$requestData['search']['value'],'both');
    				}
    			}
    			$i++;
    		}
    		if($institute!='')
    		{
    			$this->db->having('instituteId',$institute);
    		}
    		if($this->session->userdata('admin_level') == 4 && $institute=='')
    		{
    			if(!empty($ins))
    			{
    				$cnt=count($ins);
    				$i=1;
    				$qry='';
    				foreach($ins as $key => $value)
    				{
    					
    					if($cnt > 1 && $i < $cnt)
    					{
    						$qry.='instituteId='.$value.' OR ';
    					}
    					else
    					{
    						$qry.='instituteId='.$value;
    					}
    					$i++;
    				}
    			}
    			$this->db->having($qry,null, false);
    		}
    	}
    	elseif($this->session->userdata('admin_level') != 4)
    	{
    		if($institute!='')
    		{
    			$this->db->where('instituteId',$institute);
    		}
    	}
    	if($this->session->userdata('admin_level') == 4)
    	{
    		if($institute!='')
    		{
    			$this->db->where('instituteId',$institute);
    		}
    		else
    		{
    			$this->db->where_in('instituteId',$ins);
    		}
    	}
		if(!empty($requestData["order"]))
		{
			if($requestData["order"][0]["column"] > 2)
			{
				$orderby=$requestData["order"][0]["column"]-2;
			}
			else
			{
				$orderby=3;
			}
			if($columns[$orderby] != '')
			{
				$orderByField=$columns[$orderby];
				$orderByDirection=$requestData["order"][0]["dir"];
			}
			else
			{
				$orderByField='created';
				$orderByDirection='desc';
			}
		}
		else
		{
			$orderByField='created';
			$orderByDirection='desc';
		}
		return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
	}

	function count_all($table)
	{
		$this->db->select('A.*')->from($table.' as A');
		if($this->session->userdata('admin_level') == 2)
		{
			$this->db->join('institute_csv_users as B','A.email=B.email');
			$this->db->where('B.instituteId',$this->session->userdata('admin_level'));
		}
		$query=$this->db->get();
		$num_rows = $query->num_rows();
		return $num_rows;
	}


	function count_all_new($table)
	{
		$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) = DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		return $this->db->query($qry)->num_rows();
	}

	function count_all_only($table,$condition='',$separator="AND")
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		if($condition<>'')
		{
			$i=0;
			foreach ($condition as $key => $value)
			{
				if($separator=='AND')
				{
					$this->db->where($key,$value);
				}
				else
				{
					if($i==0)
					{
						$this->db->where($key,$value);
					}
					else
					{
						$this->db->or_where($key,$value);
					}

				}
				$i++;
			}
		}
		if($this->session->userdata('admin_level')==2)
		{
			$num_rows = $this->db->from($table)->where('instituteId',$this->session->userdata('instituteId'))->count_all_results();
		}
		elseif($this->session->userdata('admin_level')==4)
		{
			$num_rows = $this->db->from($table)->where_in('instituteId',$ins)->count_all_results();
		}
		else
		{
			$num_rows = $this->db->count_all_results($table);
		}

		return $num_rows;
	}


	function user_selective_projects($table,$user_id,$pro_status='')
	{
		$this->db->select('*')->from($table);
	    $this->db->where('userId',$user_id);
	    if($pro_status!='')
	    {
			  $this->db->where('status',$pro_status);
		}
	    return $this->db->get()->result_array();
	}

	public function deleteProject($project_id)
	{
    	$path2 = file_upload_s3_path().'project/';
    	$path3 = file_upload_s3_path().'project/thumbs/';
    	$path4 = file_upload_s3_path().'project/thumb_big/';

		$this->db->select('id');
		$this->db->from('project_master');
		$this->db->where('id',$project_id);
		$projectData = $this->db->get()->result_array();
		if(!empty($projectData))
		{
			foreach ($projectData as $key)
			{
				$this->db->select('image_thumb');
				$this->db->from('user_project_image');
				$this->db->where('project_id',$key['id']);
				$imageName = $this->db->get()->result_array();
				//print_r($imageName);die;
				foreach ($imageName as $name)
				{ 	
					if(file_exists($path2.$name['image_thumb']))
					{
						unlink( $path2 . $name['image_thumb']);
					}
					if (file_exists($path3.$name['image_thumb'])) {
						unlink( $path3 . $name['image_thumb']);
					}
					if (file_exists($path4.$name['image_thumb'])) {
						unlink( $path4 . $name['image_thumb']);
					}
				}
				$this->delete_with_condition('user_project_image','project_id',$key['id']);
				$this->delete_with_condition('project_image_rating_like','project_image_id',$key['id']);
			}
		}
		$this->delete_with_condition('user_project_comment','projectId',$project_id);
		$this->delete_with_condition('user_project_views','projectId',$project_id);
		$this->delete_with_condition('project_appreciation','projectId',$project_id);
		$this->delete_with_condition('project_attribute_relation','projectId',$project_id);
		$this->delete_with_condition('project_attribute_value_rating','projectId',$project_id);
		$this->delete_with_condition('project_image_rating_like','project_id',$project_id);
		$this->delete_with_condition('project_rating','projectId',$project_id);
		$this->delete_with_condition('project_team','projectId',$project_id);
		$this->delete_with_condition('user_myboard','projectId',$project_id);

    	$this->db->where('id',$project_id);
    	return $this->db->delete('project_master');
    }

	public function deleteProjectDeleted($project_id)
	{
    	$path2 = file_upload_s3_path().'project/';
    	$path3 = file_upload_s3_path().'project/thumbs/';
    	$path4 = file_upload_s3_path().'project/thumb_big/';

		$this->db->select('id');
		$this->db->from('project_master_deleted');
		$this->db->where('id',$project_id);
		$projectData = $this->db->get()->result_array();
		if(!empty($projectData))
		{
			foreach ($projectData as $key)
			{
				$this->db->select('image_thumb');
				$this->db->from('user_project_image');
				$this->db->where('project_id',$key['id']);
				$imageName = $this->db->get()->result_array();
				//print_r($imageName);die;
				foreach ($imageName as $name)
				{ 	
					if(file_exists($path2.$name['image_thumb']))
					{
						unlink( $path2 . $name['image_thumb']);
					}
					if (file_exists($path3.$name['image_thumb'])) {
						unlink( $path3 . $name['image_thumb']);
					}
					if (file_exists($path4.$name['image_thumb'])) {
						unlink( $path4 . $name['image_thumb']);
					}
				}
				$this->delete_with_condition('user_project_image','project_id',$key['id']);
				$this->delete_with_condition('project_image_rating_like','project_image_id',$key['id']);
			}
		}
		$this->delete_with_condition('user_project_comment','projectId',$project_id);
		$this->delete_with_condition('user_project_views','projectId',$project_id);
		$this->delete_with_condition('project_appreciation','projectId',$project_id);
		$this->delete_with_condition('project_attribute_relation','projectId',$project_id);
		$this->delete_with_condition('project_attribute_value_rating','projectId',$project_id);
		$this->delete_with_condition('project_image_rating_like','project_id',$project_id);
		$this->delete_with_condition('project_rating','projectId',$project_id);
		$this->delete_with_condition('project_team','projectId',$project_id);
		$this->delete_with_condition('user_myboard','projectId',$project_id);
		
    	$this->db->where('id',$project_id);
    	return $this->db->delete('project_master_deleted');
    }

    function delete_with_condition($table,$condi,$id)
    {
    	$this->db->where($condi, $id);
    	$this->db->delete($table);
    }

    function getAllUserProject($user_id)
	{
		$this->db->select('*')->from('project_master');
		$this->db->where('userId',$user_id);
		return $this->db->get()->result_array();
	}
	function getAllUserProjectDeleted($user_id)
	{
		$this->db->select('*')->from('project_master_deleted');
		$this->db->where('userId',$user_id);
		return $this->db->get()->result_array();
	}

	function getUserComments($user_id)
	{
		$this->db->select('projectId,id')->from('user_project_comment');
		$this->db->where('userId',$user_id);
		return $this->db->get()->result_array();
	}

	public function commentCountDecrement($project_id)
	{
		$this->db->where('id', $project_id);
        $this->db->set('comment_cnt', 'comment_cnt-1', FALSE);
        $this->db->update('project_master');
	}

	public function getAllInstitute()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select('*');
		$this->db->from('institute_master');
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('id',$ins);
		}
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}

	public function updateDiskSpace($userId,$newSpace){

		$this->db->select('disk_space');
		$this->db->from('users');
		$this->db->where('id',$userId);
		$result = $this->db->get()->row_array();

		$newSpace = $newSpace + $result['disk_space'];

		$this->db->where('id',$userId);
		$this->db->update('users',array('disk_space'=>$newSpace));
		$res = $this->db->affected_rows();

		if($res > 0){
			return $newSpace;
		}else{
			return FALSE;
		}
	}

	public function getAllInstituteUser($instituteId){

		$this->db->select('id,instituteId,disk_space');
		$this->db->from('users');
		if($instituteId!=0){
			$this->db->where('instituteId',$instituteId);
		}
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}

	public function _update($table,$id,$data){
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function _update2($table,$id,$data){
		$this->db->where('settings_id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function getUsersAllProject($user_id)
	{			
		return $this->db->select('id')->from('project_master')->where('userId',$user_id)->get()->result_array();
	}
	 public function getAllImages($projectId)
	{
		return $this->db->select('B.image_thumb')->from('project_master as A')->join('user_project_image as B','B.project_id=A.id')->where('A.id',$projectId)->get()->result_array();
	}

	public function find_studentid($studentid)
	{
		$this->db->select('id,email');
		$this->db->from('institute_csv_users');
		$this->db->where('studentid',$studentid);
		$query=$this->db->get();
	//	echo $this->db->last_query();
		if($query->num_rows()== 1)
		{			
			return $query->row();
		}
		else
		{
			return false;
		}
	}
}