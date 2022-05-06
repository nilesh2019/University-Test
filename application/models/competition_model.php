<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Competition_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
	}
	public function markCompletedCompetions()
	{
		$this->db->select('*');
		$this->db->from('competitions');
	   	$det = $this->db->get()->result_array();
	   //	print_r($det);die;
		foreach($det as $val)
		{
			$todayDate=date('Y-m-d');
			$evaluationEndDate=$val['evaluation_end_date'];
			$evaluationStartDate=$val['evaluation_start_date'];
			$endDate=$val['end_date'];
			$startDate=$val['start_date'];
			$checkWinnerEntry=$this->model_basic->getValue('competition_winning_projects','projectId'," `competitionId` = '".$val['id']."'");
			$checkLevelCompWinnerEntry=$this->model_basic->getValue('competition_level_winning_projects','projectId'," `competitionId` = '".$val['id']."'");
			//echo $todayDate;
			//echo $checkWinnerEntry;die;
			if($val['competition_type'] == 3){
				if($startDate > $todayDate)
				{
					$this->db->where('id',$val['id']);
					$this->db->update('competitions',array('status'=>0));
				}
				else
				{
					if($todayDate > $evaluationEndDate && $checkLevelCompWinnerEntry > 0)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>4));
					}
					else
					{
						if($todayDate > $evaluationEndDate && $checkLevelCompWinnerEntry == '')
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>3));
						}elseif($todayDate >=$evaluationStartDate && $todayDate <=$evaluationEndDate)
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>2));
						}
						elseif($todayDate >=$startDate && $todayDate <=$endDate)
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>1));
						}
						else
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>5));
						}
					}
				}
			}else{
				if($startDate > $todayDate)
				{
					$this->db->where('id',$val['id']);
					$this->db->update('competitions',array('status'=>0));
				}
				else
				{
					if($todayDate > $evaluationEndDate && $checkWinnerEntry > 0)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>4));
					}
					else
					{
						if($todayDate > $evaluationEndDate && $checkWinnerEntry == '')
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>3));
						}elseif($todayDate >=$evaluationStartDate && $todayDate <=$evaluationEndDate)
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>2));
						}
						elseif($todayDate >=$startDate && $todayDate <=$endDate)
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>1));
						}
						else
						{
							$this->db->where('id',$val['id']);
							$this->db->update('competitions',array('status'=>5));
						}
					}
				}
			}
		}
    }
	public function getAllJuries($competitionId)
	{
		$this->db->select('B.id,B.name,B.photo,B.email');
		$this->db->from('competition_jury_relation as A')->join('competition_jury as B','A.juryId=B.id');
		$this->db->where('A.competitionId',$competitionId);
		return $this->db->get()->result_array();
	}
	public function checkCompetitionProjectExist($competitionId)
	{
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('competitionId',$competitionId);
	    return $this->db->get()->result_array();
    }
    public function checkCompetitionCategoryProjectExist($competitionId,$categoryId)
    {
    	$this->db->select('*');
    	$this->db->from('project_master');
    	$this->db->where('userId',$this->session->userdata('front_user_id'));
    	$this->db->where('competitionId',$competitionId);
    	$this->db->where('categoryId',$categoryId);
    	return $this->db->get()->result_array();
    }
    public function getAllJuryRating($competitionId,$projectId)
    {
    		return $this->db->select('rating,tech_eval_rating')->from('project_jury_rating')->where('competitionId',$competitionId)->where('projectId',$projectId)->get()->result_array();
    }
	public function getAllCompetionData()
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}
		/*$this->markCompletedCompetions();*/
		$this->db->select('*');
		$this->db->from('competitions');
		$this->db->limit(12);
		$this->db->where('competitions.status !=',0);
		if($this->session->userdata('user_admin_level') != '' && $this->session->userdata('user_admin_level') == '2')
		{
			$region =$this->model_basic->getValue('institute_master','region'," `id` = '".$this->session->userdata('user_institute_id')."'");
			//$this->db->join('institute_master','competitions.instituteId=institute_master.id' ,'LEFT');
			//$this->db->where('competitions.open_for_all',1);
			//$this->db->or_where('institute_master.region',$region);	
			$this->db->where_in('competitions.instituteId', [0,$this->session->userdata('user_institute_id')]);
		}
		else if($this->session->userdata('user_admin_level') != '' && $this->session->userdata('user_admin_level') == '4')
		{
			$this->db->where_in('competitions.addedBy,(1,4)');
			//$this->db->where('c.open_for_all',1);
			array_push($hoinstituteList,0);
			$this->db->where_in('competitions.instituteId', $hoinstituteList);
		}
		else 
		{
			$this->db->where('competitions.open_for_all',1);
			if($this->session->userdata('user_institute_id') != '')
			{
				//$this->db->or_where('`instituteId` = '.$this->session->userdata('user_institute_id').' AND `addedBy` = 2');
				$this->db->or_where('competitions.instituteId',$this->session->userdata('user_institute_id'));
			}
		}
		$this->db->order_by('competitions.created','desc');
	    $data=$this->db->get()->result_array();
	  	//echo $this->db->last_query();
	    if(!empty($data))
	    {
     		$i=0;
     		foreach ($data as $value)
     		{
     			$data[$i]['userCount']=$this->getUserCount($value['id']);
     			$data[$i]['projectCount']=$this->getProjectCount($value['id']);
     			$data[$i]['commentCount']=$this->getCommentCount($value['id']);
     			$data[$i]['likeCount']=$this->getLikeCount($value['id']);
     			$i++;
     		}
	    }
	    return $data;
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
      public function getAllExstingUserProject($competitionId='')
      {
      		$category_wie_winner=$this->model_basic->getValueArray("competitions","category_wise_winner",array('id'=>$competitionId));
      		$this->db->select('id,projectName')->from('project_master')->where('userId',$this->session->userdata('front_user_id'))->where('competitionId',0)->where('status',1);
      		if($category_wie_winner==1)
      		{
      			$this->db->where('categoryId >',26);
      			$this->db->where('categoryId <',45);
      		}
      		return $this->db->get()->result_array();
      }
      public function submitExstingUserProject($projectId,$competitionId)
      {
		$this->db->where('id',$projectId);
		return $this->db->update('project_master',array('competitionId'=>$competitionId));
      }
	public function competition_more_data($limit,$page)
	{
		//$this->markCompletedCompetions();
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}
	  	$start=($page-1)*$limit;
		$this->db->select('*');
		$this->db->from('competitions');
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->where('competitions.status !=',0);
				if($this->session->userdata('user_admin_level') != '' && $this->session->userdata('user_admin_level') == '2')
				{
					$region =$this->model_basic->getValue('institute_master','region'," `id` = '".$this->session->userdata('user_institute_id')."'");
					$this->db->join('institute_master','competitions.instituteId=institute_master.id' ,'LEFT');
					//$this->db->where('competitions.open_for_all',1);
					//$this->db->or_where('institute_master.region',$region);	
					$this->db->where_in('competitions.instituteId', [0,$this->session->userdata('user_institute_id')]);
				}
				else if($this->session->userdata('user_admin_level') != '' && $this->session->userdata('user_admin_level') == '4')
				{
					$this->db->where_in('competitions.addedBy,(1,4)');
					//$this->db->where('c.open_for_all',1);
					array_push($hoinstituteList,0);
					$this->db->where_in('competitions.instituteId', $hoinstituteList);
				}
				else 
				{
					$this->db->where('competitions.open_for_all',1);
					if($this->session->userdata('user_institute_id') != '')
					{
						//$this->db->or_where('`instituteId` = '.$this->session->userdata('user_institute_id').' AND `addedBy` = 2');
						$this->db->or_where('competitions.instituteId',$this->session->userdata('user_institute_id'));
					}
				}
				$this->db->order_by('competitions.created','desc');
	    	$data = $this->db->get()->result_array();
	    	//echo $this->db->last_query();
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
	public function getAllProjectData($competitionId,$catid,$projrating)
	{
		//echo $competitionId;
		if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
			$this->db->select('users.profession,project_master.created,project_master.id,project_master.projectName,project_master.projectPageName,users.country,users.city,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->limit(12);
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
			$this->db->where('project_master.status',1);
			$this->db->where('project_master.competitionId',$competitionId);
			if($catid !='')
			{
			 	$this->db->where('project_master.categoryId',$catid);
			}
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
			$this->db->group_by('project_master.id');
		    $data =$this->db->get()->result_array();
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
	public function getAllRatedProjectData($competitionId,$juryId,$catid,$projratingfrom,$projratingto)
	{
		//echo $competitionId;
		if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
			$this->db->select('users.profession,project_master.created,project_master.id,project_master.projectName,project_master.projectPageName,users.country,users.city,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->limit(12);
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
			$this->db->where('project_master.status',1);
			$this->db->where('project_jury_rating.competitionId',$competitionId);
			$this->db->where('project_jury_rating.juryId',$juryId);
			if($catid !='')
			{
			 	$this->db->where('project_master.categoryId',$catid);
			}
			if($projratingfrom !='')
			{
			 	//$this->db->where('project_jury_rating.rating',$projratingfrom);
			 	$this->db->where('project_jury_rating.rating BETWEEN '.$projratingfrom. ' AND '. $projratingto.'');
			}
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			$this->db->join('project_jury_rating', 'project_jury_rating.projectId = project_master.id');
			//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
			$this->db->group_by('project_master.id');
		    $data =$this->db->get()->result_array();
		    //echo $this->db->last_query();exit();
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
	public function getAllWinningProjects($competitionId)
	{
		//$noOfWinners=$this->model_basic->getValue('competitions','userId'," `competitionId` = '".$competitionId."' AND  `juryId` = '".$juryId."'");
		$this->db->select('users.profession,project_master.id,project_master.created,project_master.projectName,project_master.projectPageName,users.city,users.country,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,A.rank');
		$this->db->from('project_master');
		$this->db->join('competition_winning_projects as A', 'A.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->limit(5);
		$this->db->where('project_master.status',1);
		$this->db->where('A.competitionId',$competitionId);
		$this->db->order_by('A.rank','asc');
		$this->db->group_by('project_master.id');
	    $data =$this->db->get()->result_array();
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
	public function more_data($limit,$page,$competitionId,$category_id,$institute_id,$region_id,$zone_id)
	{
	    if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
		//print_r($category);
		$start=($page-1)*$limit;
		$this->db->select('project_master.created,project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.city,users.profession,users.country,users.profileImage,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($this->session->userdata('query')!='')
		{
		 	$this->db->where("(project_master.projectName LIKE '%".$this->session->userdata('query')."%'|| project_master.basicInfo LIKE '%".$this->session->userdata('query')."%')");
		}
		
		/*if($this->session->userdata('hsort_by')=='completed')
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
	    }*/

		 $this->db->order_by('project_master.created','desc');

		if($category_id !='')
		 {
		 	$this->db->where('project_master.categoryId',$category_id);
		 }
		  
		/*  if($institute_id !='')
		 {
		 	$this->db->where('institute_master.id',$institute_id);
		 } 
		 if($region_id !='')
		 {
		 	$this->db->where('institute_master.region',$region_id);
		 }
		 if($zone_id !='')
		 {
		 	$this->db->where('institute_master.zone',$zone_id);
		 }*/

		$this->db->where('project_master.status',1);
		$this->db->where('project_master.competitionId',$competitionId);
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
		//echo $this->db->last_query();

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
					$isJury=$this->model_basic->getValueArray('competition_jury_relation','juryId',array('competitionId'=>$competitionId,'userId'=>$this->session->userdata('front_user_id')));
					$computationStatus=$this->model_basic->getValueArray('competitions','status',array('id'=>$competitionId));
					if($computationStatus==2 && $isJury > 0)
					{
						$isAlreadyRated=$this->model_basic->getValueArray('project_jury_rating','id',array('competitionId'=>$competitionId,'juryId'=>$isJury,'projectId'=>$row['id']));
						if($isAlreadyRated > 0)
						{
							$data[$i]['rateDiv'] = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-toggle="modal" class="rateit btn btn-primary alreadyRated" style="top:2%;left: 40%;z-index:1;">Rated</button>';
						}
						else
						{
							$imageIdVideoLink = array($row['image_thumb'],$row['videoLink']);
							$imagevideo = implode(" ",$imageIdVideoLink);
							$data[$i]['rateDiv'] = '<button data-controls-modal="myModal" data-backdrop="static" data-keyboard="false" data-target="#myModal" id="rateIt" data-id="'.$row['id'].'" data-name="'.$imagevideo.'" data-toggle="modal" class="rateit btn btn-primary" style="top:2%;left: 40%;z-index:1;">Rate It</button>';
						}
					}
					else
					{
						$data[$i]['rateDiv']='';
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
    public function getAllCategory($competitionId='')
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		if($competitionId !='')
		{
			//$this->db->where('id >',26);
			//$this->db->where('id <',38);
			$this->db->where_in('id', ['27','38','40','41','42','43','44','50','51']);
		}
		else
		{
			$this->db->where('id <',26);
			$this->db->or_where('id >',45);
		}
	    return $this->db->get()->result_array();
	}
	public function findCategory($cat)
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->where('categoryName',$cat);
	    return $this->db->get()->result_array();
	}
	public function check_image_exixt_on_server($url)
	{
      $status =	$this->is_url_exist($url);
      return $status;
    }
	function is_url_exist($url)
	{
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    if($code == 200){
	       $status = true;
	    }else{
	      $status = false;
	    }
	    curl_close($ch);
	   return $status;
	}
	public function get_all_attribute()
	{
		$this->db->select('*');
		$this->db->from('attribute_master');
		$this->db->where('status',1);
		$this->db->order_by('attributeName','asc');
	    return $this->db->get()->result_array();
    }
	public function get_attribute_value($attri_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('attributeId',$attri_id);
		$this->db->order_by('attributeValue','asc');
	    return $this->db->get()->result_array();
	}
	public function get_attribute_value_detail($attri_val_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('id',$attri_val_id);
	    return $this->db->get()->result_array();
 	}
	public function get_attribute_and_value($attribute_id,$attri_val_id)
	{
		$this->db->select('attribute_master.id,attribute_master.attributeName,attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('attribute_master');
		$this->db->where('attribute_master.status',1);
		$this->db->where('attribute_master.id',$attribute_id);
		$this->db->where('attribute_value_master.id',$attri_val_id);
		$this->db->join('attribute_value_master', 'attribute_master.id = attribute_value_master.attributeId');
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
    public function getAllInstituteData()
	{
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->limit(12);
		$this->db->where('status',1);
	    return $this->db->get()->result_array();
    }
    public function institute_more_data($limit,$page)
	{
	  	$start=($page-1)*$limit;
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->limit($limit);
		$this->db->offset($start);
	    $data = $this->db->get()->result_array();
	   if(!empty($data))
		{
		 	echo json_encode($data);
	    }
	    else
	    {
	     	echo '';
	    }
	}
	public function getCompetitionData($id)
	{
		$this->db->select('*');
		$this->db->from('competitions');
		$this->db->where('id',$id);
		return $this->db->get()->result_array();
	}
	public function get_project_jury_ratings($projectId,$competitionId)
	{
		$this->db->select('*');
		$this->db->from('project_jury_rating');
		$this->db->where('competitionId',$competitionId);
		$this->db->where('projectId',$projectId);
		return $this->db->get()->result_array();
	}
	public function getJuryCompetitionsCompleted($id)
	{
		$this->db->select('A.*,B.juryId');
		$this->db->from('competitions as A')->join('competition_jury_relation as B','B.competitionId=A.id');
		$this->db->where('B.juryId',$id);
		$this->db->where('A.status',4);
		$this->db->group_by('A.id');
		$data=$this->db->get()->result_array();
		if(!empty($data))
		{
			$i=0;
			foreach ($data as $value)
			{
				$data[$i]['userCount']=$this->getUserCount($value['id']);
				$data[$i]['projectCount']=$this->getProjectCount($value['id']);
				$data[$i]['commentCount']=$this->getCommentCount($value['id']);
				$data[$i]['likeCount']=$this->getLikeCount($value['id']);
				$i++;
			}
		}
		return $data;
	}
	public function getJuryCompetitionsInprogress($id)
	{
		$this->db->select('A.*,B.juryId');
		$this->db->from('competitions as A')->join('competition_jury_relation as B','B.competitionId=A.id');
		$this->db->where('B.juryId',$id);
		$this->db->where('A.status',1);
		$this->db->group_by('A.id');
		$data=$this->db->get()->result_array();
		if(!empty($data))
		{
			$i=0;
			foreach ($data as $value)
			{
				$data[$i]['userCount']=$this->getUserCount($value['id']);
				$data[$i]['projectCount']=$this->getProjectCount($value['id']);
				$data[$i]['commentCount']=$this->getCommentCount($value['id']);
				$data[$i]['likeCount']=$this->getLikeCount($value['id']);
				$i++;
			}
		}
		return $data;
	}
	public function getJuryCompetitionsEvaluating($id)
	{
		$this->db->select('A.*,B.juryId');
		$this->db->from('competitions as A')->join('competition_jury_relation as B','B.competitionId=A.id');
		$this->db->where('B.juryId',$id);
		$this->db->where_in('A.status',['1','2']);
		$this->db->group_by('A.id');
		$data=$this->db->get()->result_array();
		if(!empty($data))
		{
			$i=0;
			foreach ($data as $value)
			{
				$data[$i]['userCount']=$this->getUserCount($value['id']);
				$data[$i]['projectCount']=$this->getProjectCount($value['id']);
				$data[$i]['commentCount']=$this->getCommentCount($value['id']);
				$data[$i]['likeCount']=$this->getLikeCount($value['id']);
				$i++;
			}
		}
		return $data;
	}
	public function getJuryCompetitionsEvaluated($id)
	{
		$this->db->select('A.*,B.juryId');
		$this->db->from('competitions as A')->join('competition_jury_relation as B','B.competitionId=A.id');
		$this->db->where('B.juryId',$id);
		$this->db->where('A.status',3);
		$this->db->group_by('A.id');
		$data=$this->db->get()->result_array();
		if(!empty($data))
		{
			$i=0;
			foreach ($data as $value)
			{
				$data[$i]['userCount']=$this->getUserCount($value['id']);
				$data[$i]['projectCount']=$this->getProjectCount($value['id']);
				$data[$i]['commentCount']=$this->getCommentCount($value['id']);
				$data[$i]['likeCount']=$this->getLikeCount($value['id']);
				$i++;
			}
		}
		return $data;
	}
	public function checkUserCompetitionRelation($comp_id,$userId)
	{
		$cnt=$this->db->select('*')->from('user_competition_relation')->where('userId',$userId)->where('competitionId',$comp_id)->count_all_results();
		if($cnt != 1)
		{
			$this->db->insert('user_competition_relation',array('userId'=>$userId,'competitionId'=>$comp_id));
			$this->session->set_flashdata('success','You have successfully joined this competition.');
			return $this->db->insert_id();
		}
	}
	public function getAllSelectedProjectData($competitionId,$juryId,$catid)
	{
		//echo $competitionId;
		if($this->session->userdata('category_sort')!='')

		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
			$this->db->select('users.profession,project_master.created,project_master.id,project_master.projectName,project_master.projectPageName,users.country,users.city,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->limit(12);
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
			$this->db->where('project_master.status',1);
			$this->db->where('competition_level_project_jury.competitionId',$competitionId);
			$this->db->where('competition_level_project_jury.juryId',$juryId);
			$this->db->where('competition_level_project_jury.selectStatus',1);
			if($catid !='')
			{
			 	$this->db->where('project_master.categoryId',$catid);
			}
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			$this->db->join('competition_level_project_jury', 'competition_level_project_jury.projectId = project_master.id');
			//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
			$this->db->group_by('project_master.id');
		    $data =$this->db->get()->result_array();
		    //echo $this->db->last_query();exit();
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
  
    public function checkInSaveProject($projId,$compId,$userId)
	{
		$this->db->select('id');
		$this->db->from('spotlight_sort_project');
		$this->db->where('projectId',$projId);
		$this->db->where('compId',$compId);
		$this->db->where('userId',$userId);
		return $this->db->get()->result_array();
	}
  
    public function saveSortProject($projId,$compId,$userId)
	{
		$data = array('projectId'=>$projId,'compId'=>$compId,'userId'=>$userId,'status'=>1,'created'=>date("Y-m-d H:i:s"));
	    return $this->db->insert('spotlight_sort_project',$data);
	}
  
    public function getAllSortedProjects($competitionId,$juryId,$catid){
		$this->db->select('users.profession,project_master.created,project_master.id,project_master.projectName,project_master.projectPageName,users.country,users.city,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->limit(12);
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
			$this->db->where('spotlight_sort_project.status',1);
			$this->db->where('spotlight_sort_project.compId',$competitionId);
			$this->db->where('spotlight_sort_project.userId',$juryId);
			if($catid !='')
			{
			 	$this->db->where('project_master.categoryId',$catid);
			}
			if($projratingfrom !='')
			{
				//$this->db->where('project_jury_rating.rating',$projratingfrom);
				$this->db->where('project_jury_rating.rating BETWEEN '.$projratingfrom. ' AND '. $projratingto.'');
			}
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			$this->db->join('spotlight_sort_project', 'spotlight_sort_project.projectId = project_master.id');
			//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
			$this->db->group_by('project_master.id');
		    $data =$this->db->get()->result_array();
		    //echo $this->db->last_query();exit();
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
  
    public function removeFromSpotlight($projId,$compId,$userId)
	{
		$this->db->where('projectId',$projId);
		$this->db->where('compId',$compId);
		$this->db->where('userId',$userId);
	    return $this->db->delete('spotlight_sort_project');
	}
  
    
}
