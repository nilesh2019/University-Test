<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_basic');
	}
	public function getAllProjectData()
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->order_by('project_master.created','desc');
		$this->db->limit(4);
		$this->db->where('user_myboard.myboardUser',$this->session->userdata('front_user_id'));
		//$this->db->where('project_master.status',1);
		$this->db->join('user_myboard', 'user_myboard.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		$new_array = array();
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
				$this->db->from('category_master');
				$this->db->where('category_master.id',$row['categoryId']);
				$this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
				$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				$atrribute = $this->db->get()->result_array();
				if(!empty($atrribute)){
					$arr = array();
					$arr2 = array();
					foreach($atrribute as $val){
						//$values = $this->get_attribute_value($val['id']);
						$values = $this->get_project_attribute_value($row['id'],$val['id']);
						if(count($values) > 0){
							$arr[] = $val['attributeName'];
						}
						if(!empty($values)){
							foreach($values as $dt){
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
					$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				}
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
	public function getAllCategory()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function more_data($limit,$page)
	{
		$start = ($page - 1) * $limit;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where_in('project_master.userId',$userIds);
		$this->db->order_by('project_master.created','desc');
		$this->db->where('project_master.status',1);
		$this->db->where('user_myboard.myboardUser',$this->session->userdata('front_user_id'));
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->join('user_myboard', 'user_myboard.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		//print_r( $data);
		//$data->created = date('d F Y',strtotime($data['created']));
		$new_array = array();
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$data[$i]['created'] = date('d F Y',strtotime($row['created']));
				$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
				$this->db->from('category_master');
				$this->db->where('category_master.id',$row['categoryId']);
				$this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
				$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				$atrribute = $this->db->get()->result_array();
				if(!empty($atrribute)){
					$arr = array();
					$arr2 = array();
					foreach($atrribute as $val){
						//$values = $this->get_attribute_value($val['id']);
						$values = $this->get_project_attribute_value($row['id'],$val['id']);
						if(count($values) > 0){
							$arr[] = $val['attributeName'];
						}
						if(!empty($values)){
							foreach($values as $dt){
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
					$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				}
				$imageCount = $this->getCount('user_project_image','project_id',$row['id']);
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

				$totalLikeName = $this->db->select('B.firstName,B.lastName')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array(); 
						$str ='';
						if(!empty($totalLikeName))
						{
							$str .='<ul class="dropdown-menu">';
							foreach ($totalLikeName as $TLname) {
								$str .='<li>'.$TLname["firstName"].' '.$TLname["lastName"].'</li>';								
							}  
							$str .='</ul>'; 
							$data[$i]['droupdown']=$str;
						}
						else
						{
							$str .='<ul class="dropdown-menu"></ul>';
							$data[$i]['droupdown']=$str;
						}	
						
				$i++;
			}
		}
		//print_r($data);
		if(!empty($data)){
			echo json_encode($data);
		}
		else
		{
			echo '';
		}
	}
	/*public function getLimitedJob()
	{
		$this->db->select('*');
		$this->db->from('jobs');
	    $this->db->where('status',1);
	    $this->db->order_by('created','desc');
	    $this->db->limit(3);
	    return $this->db->get()->result_array();
	}*/
	public function getLimitedJob()
	{
		if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id')!='')
	    {
	    	$userId = $this->session->userdata('front_user_id');	 
			$this->db->select('skillName');
			$this->db->from('users_skills');
			$this->db->where('user_id',$userId);
			$skills = $this->db->get()->result_array();			

			$this->db->select('startingDate,endingDate');
			$this->db->from('users_work');
			$this->db->where('user_id',$userId);
			$dates = $this->db->get()->result_array();
			$totalDays='';$diff = '';
			foreach($dates as $row)
			{
				$startDate = '';
				$endDate = '';
				$startDate = new DateTime($row['startingDate']);
				$endDate =new DateTime($row['endingDate']);
				$diff = $endDate->diff($startDate);
				$totalDays = ($totalDays+$diff->days);
			}
			$totalDays = round($totalDays/365,1);
		}
	    $where='';
	    if(!empty($skills))
	    {	    	
	    	$i=0;
	    	foreach($skills as $row)
	    	{
	    		if($i==0)
	    		{
					$where .="((jobs.keySkills LIKE '%".$row['skillName']."%' || jobs.description LIKE '%".$row['skillName']."%' || jobs.title LIKE '%".$row['skillName']."%')";
				}
				else{
					$where .=" || (jobs.keySkills LIKE '%".$row['skillName']."%' || jobs.description LIKE '%".$row['skillName']."%' || jobs.title LIKE '%".$row['skillName']."%')";
				}
				$i++;
			}
			
		}
		if($where!='')
		{			
			if($totalDays!='' && $totalDays>0)
		    {
				$where .=" OR (jobs.min_experience <= '".$totalDays."' and jobs.max_experience >= '".$totalDays."')";
			}
			$where .=")";
		}
		else{
		
			if($totalDays!='' && $totalDays>0)
		    {
				$where ="jobs.min_experience <= '".$totalDays."' and jobs.max_experience >= '".$totalDays."' ";
			}
		}

		$insti_id = $this->session->userdata('user_institute_id');
		if($insti_id && $insti_id != '')
		{
			$regionId=$this->db->select('region')->from('institute_master')->where('id',$insti_id)->get()->row_array();
		}
		else
		{
			$regionId='';
		}

		    	 
		$this->db->select('jobId');
		$this->db->from('job_user_relation');
		$this->db->where('userId',$userId);
		$appaliedJob = $this->db->get()->result_array();
		$whereAppaliedJob ='';
		if(!empty($appaliedJob))
		{
			$i= count($appaliedJob) ;
		//	$whereAppaliedJob .= "(";			
			foreach ($appaliedJob as $key => $value) {
				$whereAppaliedJob .="`jobs`.`id` != '".$value['jobId']."'";
				if(($i) > ($key+1))
				{
					$whereAppaliedJob .= " AND ";					
				}				
			}
			//$whereAppaliedJob .= ")";
		}
		
		if($where!='')
	    {
	    	$this->db->select('jobs.*');
			$this->db->from('jobs');
			$this->db->join('job_zone_relation','job_zone_relation.job_id=jobs.id','left');
		    $this->db->where('jobs.status',1);
		    if($whereAppaliedJob !='')
		    {
		    	$this->db->where($whereAppaliedJob);
		    }
		    
			$this->db->where($where);
			
			if(isset($regionId) && !empty($regionId))
			{
				$this->db->where('job_zone_relation.region_id',$regionId['region']);
				$this->db->group_by('jobs.id');
			}
		    $this->db->order_by('jobs.created','desc');
		    $this->db->limit(5);		  
		   return $this->db->get()->result_array();
		   /*$this->db->get()->result_array();
		    echo $this->db->last_query();die;*/
	    }
	    else{
			return array();
		}
	    
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
	function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
	public function check_image_exixt_on_server($url)
	{
		$headers = get_headers($url);
		if(strpos($headers[17],"200") > 0){
			return true;
		}
		else
		{
			return false;
		}
	}
	public function checkInMyboard($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_myboard');
		$this->db->where('myboardUser',$this->session->userdata('front_user_id'));
		$this->db->where('projectId',$project_id);
		return $this->db->get()->result_array();
	}
	public function addToMyboard($project_id)
	{
		$data = array('myboardUser'=>$this->session->userdata('front_user_id'),'projectId'=>$project_id,'created'=>date("Y-m-d H:i:s"));
	    return $this->db->insert('user_myboard',$data);
	}
	public function removeFromMyboard($project_id)
	{
		$this->db->where('myboardUser',$this->session->userdata('front_user_id'));
		$this->db->where('projectId',$project_id);
	    return $this->db->delete('user_myboard');
	}
}
