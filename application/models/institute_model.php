<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Institute_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllProjectData($institute)
	{
			$hoinstituteList = array();
			if($this->session->userdata('user_admin_level') == 4)
			{
				$front_user_id = $this->session->userdata('front_user_id');
				$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
				$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
			}

			$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.videoLink,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created,category_master.categoryName');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->limit(12);

			if($this->session->userdata('user_admin_level') == 1)
			{
				$where = "(( project_master.status=1) OR ( project_master.status=3))";
				$this->db->where($where);
				$this->db->where('users.instituteId',$institute[0]['id']);
			}				
			else if($this->session->userdata('user_admin_level') == 4)
			{	
				  if(!empty($institute))
				  {
				  	if (in_array($institute[0]['id'], $hoinstituteList))
  					  {
  					  	//echo "Match found";
  					  	$where = "(( project_master.status=1) OR ( project_master.status=3))";
  					  	$this->db->where($where);
  					  }
  					else
  					  {
  					  	//echo "Match not found";
  					  	$this->db->where('project_master.status',1);
  					  }
				  	$this->db->where('users.instituteId',$institute[0]['id']);
				  }		
			}
			else
			{
				if(!empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
				{
					if($institute[0]['id']==$this->session->userdata('user_institute_id'))
					{
						//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
					    $this->db->where($where);
					}
					else
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
						$this->db->where('project_master.status',1);
						//$this->db->where('project_master.admin_status',1);
					}
					$this->db->where('users.instituteId',$institute[0]['id']);
				}
				elseif(!empty($institute)&&$this->session->userdata('user_institute_id')=='')
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
					$this->db->where('project_master.status',1);
					//$this->db->where('project_master.admin_status',1);
					$this->db->where('users.instituteId',$institute[0]['id']);
				}
			}
			$this->db->order_by('project_master.created','desc');
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('category_master', 'category_master.id = project_master.categoryId');
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

	public function getUserSpecificInstituteData($uid)
	{
		$this->db->select('im.*,count(pm.id) As project_cnt');
		$this->db->from('institute_master im');
		$this->db->join('users u', 'im.id=u.instituteId',"LEFT");
		$this->db->join('project_master pm', 'pm.userId=u.id',"LEFT");
		$this->db->limit(1);
		$this->db->where('im.status',1);
		$this->db->where('u.id',$uid);
		$this->db->order_by('project_cnt','DESC');
		$this->db->group_by('im.id');
	    return $this->db->get()->result_array();
    } 
	public function getAllAluminiPeopleData($instituteid)
	{
				$this->db->select('A.id as userId,A.instituteId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS project_count,project_master.id AS projectId');
				$this->db->from('users as A');
			    $this->db->where('A.status',1);
			    $this->db->where('A.alumniFlag',1);
			    $this->db->where('A.instituteId',$instituteid);
			    $this->db->limit(8);
				$this->db->order_by('project_count','desc');
		       	if($this->session->userdata('adv_category_id') && $this->session->userdata('adv_category_id')!='' )
		    	{
		    		$this->db->where('project_master.categoryId',$this->session->userdata('adv_category_id'));
		        }
			    if($this->session->userdata('adv_attribute_id') && $this->session->userdata('adv_attribute_id')!='' )
				{ 
					$this->db->where('project_attribute_relation.attributeId',$this->session->userdata('adv_attribute_id'));
			    }
			        
			    if($this->session->userdata('adv_attri_value_id') && $this->session->userdata('adv_attri_value_id')!='')
				{
					$this->db->where('project_attribute_relation.attributeValueId',$this->session->userdata('adv_attri_value_id'));
			    }
			
			    if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
				{
					if(strpos($this->session->userdata('adv_rating'),'+') !== false)
					{
						  $arr = explode("+",$this->session->userdata('adv_rating'));
						  $this->db->where('project_rating.avg_project_rating >=',$arr[0]);
					}
					else
					{
						$this->db->where('project_rating.avg_project_rating',$this->session->userdata('adv_rating'));
					}
			    }

		    	if('A.instituteId' == $this->session->userdata('user_institute_id'))
		    	{	    				
		    		$where = "(( project_master.status=1) OR ( project_master.status=3))";
		        	$this->db->where($where);	    			
		    	}
		    	else
		    	{	    				
		    		$this->db->where('project_master.status',1);
		    	}
			    $this->db->join('project_master', 'project_master.userId = A.id', 'left');
			    $this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			    $this->db->join('project_rating', 'project_rating.projectId = project_master.id', 'left');
				//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
				//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
				//$this->db->group_by('project_master.id');
				$this->db->group_by('A.id');
			    $allData = $this->db->get()->result_array();	
			    return $allData;
			   // print_r($allData);die;
			    /*$dat = $this->db->get()->result_array();
		        echo $this->db->last_query();
		        print_r($dat);die;*/
	}
	public function getAllAluminiProjectData($instituteId)
	{
			$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created,category_master.categoryName');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->limit(8);
			if(!empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			{
				if($institute[0]['id']==$this->session->userdata('user_institute_id'))
				{
					//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
					$this->db->where('project_master.status',1);
					//$this->db->where('project_master.admin_status',1);
				}
				$this->db->where('users.instituteId',$institute[0]['id']);
			}
			elseif(!empty($institute)&&$this->session->userdata('user_institute_id')=='')
			{
				//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
				$this->db->where('project_master.status',1);
				//$this->db->where('project_master.admin_status',1);
				
			}
			//print_r($institute);die;
			$this->db->where('users.instituteId',$instituteId);
			$this->db->where('users.alumniFlag',1);
			$this->db->order_by('project_master.created','desc');
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('category_master', 'category_master.id = project_master.categoryId');
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
	public function more_data($limit,$page,$all_project = '',$creative_fields = '',$featured = '',$search_term = '',$institute,$alumini_project_status)
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

	    if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
		$start=($page-1)*$limit;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($search_term != ''){
			$this->db->where("(project_master.projectName LIKE '%".$search_term."%'|| project_master.basicInfo LIKE '%".$search_term."%')");
		}
		if($all_project == 'Completed'){
			$this->db->where('project_master.projectStatus',1);
		}
		if($all_project == 'Work in progress'){
			$this->db->where('project_master.projectStatus',0);
		}
		if($creative_fields != ''){
			if(!empty($creative_fields)){
				$this->db->where_in('project_master.categoryId',$creative_fields);
			}
		}
		if($featured == 'Featured'){
			$this->db->order_by('project_master.created','desc');
		}
		elseif($featured == 'Most Appreciated'){
			$this->db->order_by('project_master.like_cnt','desc');
			$this->db->where('project_master.like_cnt >',0);
		}
		elseif($featured == 'Most Viewed'){
			$this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($featured == 'Most Discussed'){
			$this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($featured == 'Most Recent'){
			$this->db->order_by('project_master.created','desc');
		}
		else
		{
			$this->db->order_by('project_master.created','desc');
		}

		if($this->session->userdata('user_admin_level') == 1)
		{
			$where = "(( project_master.status=1) OR ( project_master.status=3))";
			$this->db->where($where);
			$this->db->where('users.instituteId',$institute[0]['id']);
		}				
		else if($this->session->userdata('user_admin_level') == 4)
		{	
			  if(!empty($institute))
			  {
			  	if (in_array($institute[0]['id'], $hoinstituteList))
					  {					  	
					  	$where = "(( project_master.status=1) OR ( project_master.status=3))";
					  	$this->db->where($where);
					  }
					else
					  {					  	
					  	$this->db->where('project_master.status',1);
					  }
			  	$this->db->where('users.instituteId',$institute[0]['id']);
			  }		
		}
		else
		{
			if(!empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			{
				if($institute[0]['id']==$this->session->userdata('user_institute_id'))
				{
					//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
					$this->db->where('project_master.status',1);
					//$this->db->where('project_master.admin_status',1);
				}
				$this->db->where('users.instituteId',$institute[0]['id']);
			}
			elseif(!empty($institute)&&$this->session->userdata('user_institute_id')=='')
			{
				//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
				$this->db->where('project_master.status',1);
				//$this->db->where('project_master.admin_status',1);
				$this->db->where('users.instituteId',$institute[0]['id']);
			}
		}

		if($alumini_project_status!=0)
		{
			$this->db->where('users.alumniFlag',1);
		 }
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

	public function alumini_more_data($limit,$page,$all_project = '',$creative_fields = '',$featured = '',$search_term = '',$institute,$alumini_project_status)
	{
	    if($this->session->userdata('category_sort')!='')
		{
			$category = $this->findCategory($this->session->userdata('category_sort'));
		}
		$start=($page-1)*$limit;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($search_term != ''){
			$this->db->where("(project_master.projectName LIKE '%".$search_term."%'|| project_master.basicInfo LIKE '%".$search_term."%')");
		}
		if($all_project == 'Completed'){
			$this->db->where('project_master.projectStatus',1);
		}
		if($all_project == 'Work in progress'){
			$this->db->where('project_master.projectStatus',0);
		}
		if($creative_fields != ''){
			if(!empty($creative_fields)){
				$this->db->where_in('project_master.categoryId',$creative_fields);
			}
		}
		if($featured == 'Featured'){
			$this->db->order_by('project_master.created','desc');
		}
		elseif($featured == 'Most Appreciated'){
			$this->db->order_by('project_master.like_cnt','desc');
			$this->db->where('project_master.like_cnt >',0);
		}
		elseif($featured == 'Most Viewed'){
			$this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($featured == 'Most Discussed'){
			$this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($featured == 'Most Recent'){
			$this->db->order_by('project_master.created','desc');
		}
		else
		{
			$this->db->order_by('project_master.created','desc');
		}
		    if(!empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			{
				if($institute[0]['id']==$this->session->userdata('user_institute_id'))
				{
					//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
					$this->db->where('project_master.status',1);
					//$this->db->where('project_master.admin_status',1);
				}
				$this->db->where('users.instituteId',$institute[0]['id']);
			}
			elseif(!empty($institute)&&$this->session->userdata('user_institute_id')=='')
			{
				//$this->db->where('institute_csv_users.instituteId',$institute[0]['id']);
				$this->db->where('project_master.status',1);
				//$this->db->where('project_master.admin_status',1);
				$this->db->where('users.instituteId',$institute[0]['id']);
			}
			
				$this->db->where('users.alumniFlag',1);
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
	/*public function project_like_count($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userLike',1);
	    return $this->db->get()->num_rows();
	}*/
	/*public function project_comment($project_id)
	{
		$this->db->select('user_project_comment.*,users.profileImage');
		$this->db->from('user_project_comment');
		$this->db->where('user_project_comment.projectId',$project_id);
		$this->db->where('user_project_comment.status',1);
		$this->db->join('users', 'users.id = user_project_comment.userId');
	    return $this->db->get()->result_array();
	}*/
    public function getAllCategory()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->order_by('id','DESC');
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
	/*public function project_view_count($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userView',1);
	    return $this->db->get()->num_rows();
	}*/
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
		$this->db->select('im.*,count(pm.id) As project_cnt');
		$this->db->from('institute_master im');
		$this->db->join('users u', 'im.id=u.instituteId',"LEFT");
		$this->db->join('project_master pm', 'pm.userId=u.id',"LEFT");
		$this->db->limit(8);
		$this->db->where('im.status',1);
		//$this->db->WHERE('pm.status','1');
		$this->db->order_by('project_cnt','DESC');
		$this->db->group_by('im.id');
	    return $this->db->get()->result_array();
	    //echo $this->db->last_query();exit();
    }
    public function institute_more_data($limit,$page,$search_term='')
	{
	  	$start=($page-1)*$limit;
		$this->db->select('im.*,count(pm.id) As project_cnt');
		$this->db->from('institute_master im');
		$this->db->join('users u', 'im.id=u.instituteId',"LEFT");
		$this->db->join('project_master pm', 'pm.userId=u.id',"LEFT");
		$this->db->limit($limit);
		$this->db->where('im.status',1);
		$this->db->WHERE('pm.status','1');
		if($search_term != '')
		{
			$this->db->where("(instituteName LIKE '%".$search_term."%')");
		}
		$this->db->offset($start);
		$this->db->order_by('project_cnt','DESC');
		$this->db->group_by('im.id');		
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
    public function getInstituteData($name)
	{
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->where('status',1);
		$this->db->where('pageName',$name);
	    return $this->db->get()->result_array();
    }

    public function search_more_data($limit,$page,$search_term)
    {

     	$start=($page-1)*$limit;
    	$this->db->select('*');
    	$this->db->from('institute_master');    	
    	$this->db->where('status',1);
    	if($search_term != '')
    	{
    		$this->db->where("(instituteName LIKE '%".$search_term."%')");
    	}
    	$this->db->limit($limit);
    	$this->db->offset($start);
    	$this->db->order_by('created','desc');
        $data = $this->db->get()->result_array();
       if(!empty($data))
    	{
    		$i = 0; 
    		foreach($data as $row)
    		{
    			$data[$i]['created'] = date("j F Y", strtotime($row['created']));
    			$i++;
    		}
    			
    	 	echo json_encode($data);
        }
        else
        {
         	echo '';
        }
    }


    	public function alumini_more_data_people($limit,$page,$search_term,$institute)
    	{			
    		$start=($page-1)*$limit;
    		$this->db->select('A.id as userId,A.instituteId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS project_count');
    		$this->db->from('users as A');
    	    $this->db->where('A.status',1);
    	    $this->db->where('A.instituteId',$institute);
    	    $this->db->where('A.alumniFlag',1);
    	    $this->db->where('A.id !=',$this->session->userdata('front_user_id'));
    	    $this->db->limit($limit);
    	    $this->db->offset($start);
    		$this->db->order_by('project_count','desc');

    	  	if($search_term != '')
    		{
    			$this->db->where("(A.firstName LIKE '%".$search_term."%'|| A.lastName LIKE '%".$search_term."%'|| CONCAT(A.firstname,' ', A.lastname) LIKE '%".$search_term."%' || A.country LIKE '%".$search_term."%'|| A.city LIKE '%".$search_term."%')");
    		}	 

        	if('A.instituteId' == $this->session->userdata('user_institute_id'))
        	{	
    		    if($this->session->userdata('adv_category_id'))
    	    	{
    	    	   $this->db->join('project_master', '(project_master.userId = A.id) AND (project_master.status=1 OR  project_master.status=3) AND (project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
    	        }
    	        else
    	        {
    	        	$this->db->join('project_master', '(project_master.userId = A.id) AND (project_master.status=1 OR  project_master.status=3)', 'left'); 
    	        }    				
        	}
        	else
        	{	 
    		    if($this->session->userdata('adv_category_id'))
    	    	{
    	    	   $this->db->join('project_master', 'project_master.userId = A.id AND project_master.status = 1 AND project_master.categoryId = "'.$this->session->userdata('adv_category_id').'"', 'left'); 
    	        }
    	        else 
    	        {
    	           	$this->db->join('project_master', 'project_master.userId = A.id AND project_master.status = 1', 'left');			
    	        }   				
        	}
    	     if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
    		{
    			if(strpos($this->session->userdata('adv_rating'),'+') !== false)
    			{
    				  $arr = explode("+",$this->session->userdata('adv_rating'));
    				  //$this->db->where('project_rating.rating >=',$arr[0]);

    				  $this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating ="'.$arr[0].'"', 'left');
    			}
    			else
    			{
    				$this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating ="'.$this->session->userdata('adv_rating').'"', 'left');
    			}
    	    }
    	    else
    	    {
    	    	$this->db->join('project_rating', 'project_rating.projectId = project_master.id', 'left');
    	    }

            if($this->session->userdata('adv_attribute_id') !='' || $this->session->userdata('adv_attri_value_id') != '')
        	{ 
        		if($this->session->userdata('adv_attribute_id') != '' && $this->session->userdata('adv_attri_value_id') != '')
        		{
        			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id AND project_attribute_relation.attributeId = "'.$this->session->userdata('adv_attribute_id').'" AND project_attribute_relation.attributeValueId = "'.$this->session->userdata('adv_attri_value_id').'"', 'left');
        		}
        		elseif($this->session->userdata('adv_attribute_id') != ''){
        			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id AND project_attribute_relation.attributeId = "'.$this->session->userdata('adv_attribute_id').'"', 'left');
        		}elseif ($this->session->userdata('adv_attri_value_id') != '') {
        			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id AND project_attribute_relation.attributeValueId = "'.$this->session->userdata('adv_attri_value_id').'"', 'left');
        		}
            }
              
    		//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
    		//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
    		//$this->db->group_by('project_master.id');
    		$this->db->group_by('A.id');
            $user = $this->db->get()->result_array();
            if(!empty($user))
            {$i=0;
    			foreach($user as $row)
    			{
    				$data = $this->checkFollowingOrNot($row['userId']);
    				if(!empty($data))
    				{
    					$user[$i]['follow_status']=1;
    				}
    				else
    				{
    					$user[$i]['follow_status']=0;
    				}
    				$proData = $this->getUserProjectData($row['userId']);
    				$orgName=$this->getOrgName($row['userId']);
    				$positionName=$this->getPositionName($row['userId']);
    				$user[$i]['positionName']=$positionName;
    				$user[$i]['orgName']=$orgName;
    				$projectCount=0;
    				$likeCount=0;$viewCount=0;
    				if(!empty($proData))
    				{
    					$projectCount=sizeof($proData);
    					foreach($proData as $dt)
    					{
    						$likeCount=$dt['like_cnt'] + $likeCount;
    						$viewCount=$dt['view_cnt'] + $viewCount;
    					}
    					$user[$i]['projectCount']=$projectCount;
    					$user[$i]['likeCount']=$likeCount;
    					$user[$i]['viewCount']=$viewCount;
    				}
    				else
    				{
    					$user[$i]['projectCount']=$projectCount;
    					$user[$i]['likeCount']=$likeCount;
    					$user[$i]['viewCount']=$viewCount;
    				}

    				$followers = $this->db->select('COUNT(followingUser) AS followers')->from('user_follow')->where('followingUser',$row['userId'])->get()->row_array();
    				if(!empty($followers))
    				{
    					$user[$i]['followers']=$followers['followers'];
    				}
    				else
    				{
    					$user[$i]['followers']=0;
    				}

    				$following = $this->db->select('COUNT(followingUser) AS following')->from('user_follow')->where('userId',$row['userId'])->get()->row_array();

    				if(!empty($following))
    				{
    					$user[$i]['following']=$following['following'];
    				}
    				else
    				{
    					$user[$i]['following']=0;
    				}
    			 $i++;
    			}
    		}
    			if(!empty($user))
    			{
    			 	echo json_encode($user);
    		    }
    		    else
    		    {
    		     	echo '';
    		    }
        }

        public function getUserProjectData($userId)
        {
        	$this->db->select('A.id as projectId,A.like_cnt,A.view_cnt');
        	$this->db->from('project_master as A');
        	//$this->db->join('project_master as B', 'B.userId = A.id');
        	$this->db->where('A.userId',$userId);
        	//$this->db->where('A.status',1);
        	return $this->db->get()->result_array();
        }
        public function checkFollowingOrNot($user_id)
        {
        	$this->db->select('*');
        	$this->db->from('user_follow');
        	$this->db->where('userId',$this->session->userdata('front_user_id'));
        	$this->db->where('followingUser',$user_id);
            return $this->db->get()->result_array();
        }
        public function getOrgName($userId)
        {
        	$this->db->select('organisation',false);
        	$this->db->from('users_work');
        	$this->db->where('user_id',$userId);
        	$this->db->order_by('endingDate','desc');
        	$this->db->limit(1);
        	$result=$this->db->get()->row();
        	
        	if(!empty($result))
        	{
        		return $result->organisation;
        	}
        	else
        	{
        		return '';
        	}
        }
        public function getPositionName($userId)
        {
        	$this->db->select('position',false);
        	$this->db->from('users_work');
        	$this->db->where('user_id',$userId);
        	$this->db->order_by('endingDate','desc');
        	$this->db->limit(1);
        	$result=$this->db->get()->row();
        	
        	if(!empty($result))
        	{
        		return $result->position;
        	}
        	else
        	{
        		return '';
        	}
        }
        public function getInsProjectcount($instituteId)
        {
        	$this->db->select('count(pm.id) as projectCount');
        	$this->db->from('project_master pm');
        	$this->db->join('users u',"u.id = pm.userId");
        	$this->db->where('u.instituteId',$instituteId);
    		echo $this->db->last_query();
        	$result=$this->db->get()->row();        	
        	if(!empty($result))
        	{
        		return $result->projectCount;
        	}
        	else
        	{
        		return '';
        	}
        }

}
