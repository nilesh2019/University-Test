<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assignment_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_tools($assig_id)
	{
		//echo $id;die;
		$this->db->select('A.*,B.attributeValue');
		$this->db->from('assignment_tools_relation as A');
		$this->db->join('attribute_value_master as B','B.id=A.attribute_tools_id');
		$this->db->where('A.assignment_id',$assig_id);
		$this->db->where('B.attributeId',1);
		return $this->db->get()->result_array();
	}
	public function get_feature($assig_id)
	{
		//echo $id;die;
		$this->db->select('A.*,B.attributeValue');
		$this->db->from('assignment_features_relation as A');
		$this->db->join('attribute_value_master as B','B.id=A.attribute_features_id');
		$this->db->where('A.assignment_id',$assig_id);
		$this->db->where('B.attributeId',2);
		return $this->db->get()->result_array();
	}

	public function edit_assignment_data($assig_id)
	{		
		$this->db->select('*');
		$this->db->from('assignment');	
		$this->db->where('id',$assig_id);	
		return $this->db->get()->result_array();
	}
	public function edit_assignment_selected_user($assig_id)
	{			
		$this->db->select('*');
		$this->db->from('user_assignment_relation');	
		$this->db->where('assignment_id',$assig_id);	
		return $this->db->get()->result_array();
	}
	public function getAllUserAssignment($user_id)
	{		
		$this->db->select('B.*');
		$this->db->from('user_assignment_relation as A');
		$this->db->join('assignment as B','B.id=A.assignment_id');
		$this->db->where('A.user_id',$user_id);		
		$this->db->order_by("B.end_date",'asc');
		return $this->db->get()->result_array();

	}
	public function getAllAssignmentData($assignmentId,$user_id='',$not_my_project='')
	{
		if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
			$this->db->select('users.profession,project_master.created,project_master.assignment_status,project_master.id,project_master.projectName,project_master.projectPageName,project_master.videoLink,users.country,users.city,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->limit(2);
			$this->db->limit(12);
			if($this->session->userdata('query')!='')
			{
			 $this->db->where("(project_master.projectName LIKE '%".$this->session->userdata('query')."%'|| project_master.basicInfo LIKE '%".$this->session->userdata('query')."%')");
			}
			if($this->session->userdata('hsort_by')=='completed')
			{
				$this->db->where('project_master.projectStatus',1);
		    }
			if($this->session->userdata('hsort_by')=='in_progress')
			{
				$this->db->where('project_master.projectStatus',0);
			}
			if($this->session->userdata('category_sort')!='')
			{
			   if(!empty($category))
				 {
				 	   $this->db->where('project_master.categoryId',$category[0]['id']);
				 }
			}
			if($this->session->userdata('user_activity_sort')=='Featured')
			{
			   $this->db->order_by('project_master.created','desc');
			}
			elseif($this->session->userdata('user_activity_sort')=='Most Appreciated')
			{
			    $this->db->order_by('project_master.like_cnt','desc');
			    $this->db->where('project_master.like_cnt >',0);
			}
			elseif($this->session->userdata('user_activity_sort')=='Most Discussed')
			{
			    $this->db->order_by('project_master.comment_cnt','desc');
			}
			elseif($this->session->userdata('user_activity_sort')=='Most Viewed')
			{
				 $this->db->order_by('project_master.view_cnt','desc');
			}
			elseif($this->session->userdata('user_activity_sort')=='Most Recent')
			{
			   $this->db->order_by('project_master.created','desc');
			}
			else
			{
				$this->db->order_by('project_master.created','desc');
			}
			if($this->session->userdata('adv_attribute') && $this->session->userdata('adv_attribute')!='' )
			{
				$this->db->where('project_attribute_relation.attributeId',$this->session->userdata('adv_attribute_id'));
		    }
		    if($this->session->userdata('adv_attri_value') && $this->session->userdata('adv_attri_value')!='')
			{
				$this->db->where('project_attribute_relation.attributeValueId',$this->session->userdata('adv_attri_value_id'));
		    }
		     if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
			{
				if(strpos($this->session->userdata('adv_rating'),'+') !== false)
				{
					  $arr = explode("+",$this->session->userdata('adv_rating'));
					  $this->db->where('project_attribute_relation.rating_avg >=',$arr[0]);
				}
				else
				{
					$this->db->where('project_attribute_relation.rating_avg',$this->session->userdata('adv_rating'));
				}
		    }
			//$this->db->where('project_master.status',1);
			if($user_id!='')
			{
				$this->db->where('users.id',$user_id);
			}
			if($not_my_project!='')
			{
				$this->db->where('users.id !=',$not_my_project);
			}
			$this->db->where('project_master.assignmentId',$assignmentId);
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
			$this->db->group_by('project_master.id');
		    $data =$this->db->get()->result_array();

		   // print_r($data);die;


			$new_array = array();
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
						   //$values = $this->get_attribute_value($val['id']);
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

public function get_project_attribute_value($project_id,$attribute_id)
{
	$this->db->select('attribute_value_master.id,attribute_value_master.attributeValue');
	$this->db->from('project_attribute_relation');
	$this->db->where('project_attribute_relation.projectId',$project_id);
	$this->db->where('project_attribute_relation.attributeId',$attribute_id);
	$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
    return $this->db->get()->result_array();
}
	public function assignment_more_data($limit,$page)
	{
		//$this->markCompletedCompetions();
	  	$start=($page-1)*$limit;
		$this->db->select('*');
		$this->db->from('competitions');
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    	$data = $this->db->get()->result_array();
	    	if(!empty($data))
	    	{
    			$i=0;
    			foreach ($data as $value)
    			{
    				$data[$i]['userCount']=$this->getUserCount($value['id']);
    				$data[$i]['projectCount']=$this->getProjectCount($value['id']);
    				$data[$i]['commentCount']=$this->getCommentCount($value['id']);
    				$data[$i]['likeCount']=$this->getLikeCount($value['id']);
    				$data[$i]['start_date']=date("M j, Y",strtotime($value['start_date']));
    				$data[$i]['end_date']=date("M j, Y",strtotime($value['end_date']));
    				$i++;
    			}
	    	}
		if(!empty($data))
		{
		 	echo json_encode($data);
		}
		else
		{
			echo '';
		}
	}

	public function getAssignmentData($id)
	{
		$this->db->select('*');
		$this->db->from('assignment');
		$this->db->where('id',$id);
		$this->db->order_by('id','desc');		
		return $this->db->get()->result_array();
	}

	public function more_data($limit,$page,$assignmentId)
	{
	    if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
		$start=($page-1)*$limit;
		$this->db->select('project_master.created,project_master.assignment_status,project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.city,users.profession,users.country,users.profileImage,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($this->session->userdata('query')!='')
		{
		 $this->db->where("(project_master.projectName LIKE '%".$this->session->userdata('query')."%'|| project_master.basicInfo LIKE '%".$this->session->userdata('query')."%')");
		}
		if($this->session->userdata('hsort_by')=='completed')
		{
			$this->db->where('project_master.projectStatus',1);
	    }
		if($this->session->userdata('hsort_by')=='in_progress')
		{
			$this->db->where('project_master.projectStatus',0);
		}
	   if($this->session->userdata('category_sort')!='')
		{
		   if(!empty($category))
			 {
			 	   $this->db->where('project_master.categoryId',$category[0]['id']);
			 }
		}
		if($this->session->userdata('user_activity_sort')=='Featured')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		elseif($this->session->userdata('user_activity_sort')=='Most Appreciated')
		{
		   $this->db->order_by('project_master.like_cnt','desc');
		   $this->db->where('project_master.like_cnt >',0);
		}
		elseif($this->session->userdata('user_activity_sort')=='Most Viewed')
		{
		   $this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($this->session->userdata('user_activity_sort')=='Most Discussed')
		{
		   $this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($this->session->userdata('user_activity_sort')=='Most Recent')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		else
		{
			$this->db->order_by('project_master.created','desc');
		}
		if($this->session->userdata('adv_attribute') && $this->session->userdata('adv_attribute')!='' )
		{
			$this->db->where('project_attribute_relation.attributeId',$this->session->userdata('adv_attribute_id'));
	    }
	    if($this->session->userdata('adv_attri_value') && $this->session->userdata('adv_attri_value')!='')
		{
			$this->db->where('project_attribute_relation.attributeValueId',$this->session->userdata('adv_attri_value_id'));
	    }
	    if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
		{
			if(strpos($this->session->userdata('adv_rating'),'+') !== false)
			{
				  $arr = explode("+",$this->session->userdata('adv_rating'));
				  $this->db->where('project_attribute_relation.rating_avg >=',$arr[0]);
			}
			else
			{
				$this->db->where('project_attribute_relation.rating_avg',$this->session->userdata('adv_rating'));
			}
	    }
		//$this->db->where('project_master.status',1);
		$this->db->where('project_master.assignmentId',$assignmentId);
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
			$new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
			 	$data[$i]['created'] = date('d F Y',strtotime($row['created']));
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
						   //$values = $this->get_attribute_value($val['id']);
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
						$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					$imageCount=$this->getCount('user_project_image','project_id',$row['id']);
					$data[$i]['imageCount']=$imageCount;
					$data[$i]['created_on']=date("F j, Y",strtotime($row['created']));
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
	//	print_r($data);die;
	   if(!empty($data))
		{
		 	echo json_encode($data);
	    }
	    else
	    {
	     	echo '';
	    }
	}

   function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}

	public function getUserCount($competitionId)
	{
		return $this->db->select('A.id')->from('user_competition_relation as A')->where('A.competitionId',$competitionId)->count_all_results();
	}
	public function getProjectCount($competitionId)
	{
		return $this->db->select('A.id')->from('project_master as A')->where('A.competitionId',$competitionId)->where('A.status',1)->count_all_results();
	}
	public function getCommentCount($competitionId)
	{
		return $this->db->select('A.id')->from('project_master as A')->join('user_project_comment as B','A.id=B.projectId')->where('A.competitionId',$competitionId)->where('B.status',1)->count_all_results();
	}
	public function getLikeCount($competitionId)
	{
		return $this->db->select('A.id')->from('project_master as A')->join('user_project_views as B','A.id=B.projectId')->where('A.competitionId',$competitionId)->where('B.userLike',1)->count_all_results();
	}

	public function deleteAssignment($assignment_id)
	{
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('assignmentId',$assignment_id);
		$AssignmentData = $this->db->get()->result_array();
		if(!empty($AssignmentData))
		{
			foreach ($AssignmentData as $value) {
				$this->db->where('assignmentId',$value['assignmentId']);				
				$this->db->update('project_master',array('assignmentId'=>0));				
			}
			
		}
		$this->db->where('id',$assignment_id);
		return $this->db->delete('assignment');		
	}

public function not_assign_user($data,$assignmentId)
	{
		$this->db->select('user_id');
		$this->db->from('user_assignment_relation');
		$this->db->where('assignment_id',$assignmentId);
		if(!empty($data))
		{
			foreach ($data as $key => $value) 
			{

				$this->db->where('user_id !=',$value);
				
			}
		}
		$array = $this->db->get()->result_array();
		//print_r($array);die;
		return $array;
	}

	public function not_assign_user_api($data,$assignmentId)
		{
			//print_r($data);die;
			$this->db->select('user_id');
			$this->db->from('user_assignment_relation');
			$this->db->where('assignment_id',$assignmentId);
			if(!empty($data))
			{
				foreach ($data as $key) 
				{
					
					$this->db->where('user_id !=',$key['userId']);
					
				}
			}
			$array = $this->db->get()->result_array();
			//print_r($array);die;
			return $array;
		}

}
