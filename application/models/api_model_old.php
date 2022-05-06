<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    /////////////////////////////////////////////////////////-- Project -- ////////////////////////////////////////////////////////////
public function isPaymentDone($userId)
    {
    	$userEmail=$this->db->select('email')->from('users')->where('id',$userId)->get()->row_array();
    	$email=$userEmail['email'];
    	$data=$this->db->select('id')->from('institute_csv_users')->where('email',$email)->get()->row_array();
    	if(!empty($data))
    	{
    		$date=date('Y-m-d H:i:s');
    		$res=$this->db->select('id')->from('student_membership')->where('csvuserId',$data['id'])->where('start_date <=',$date)->where('end_date >=',$date)->where('status',1)->get()->row_array();
    		return $res['id'];
    	}
    	else
    	{
    		return 0;
    	}
    }
	public function generateProjectPageName($projectName='',$userId)
	{
		//$userId = $this->session->userdata('front_user_id');
		$this->db->select('firstName,lastName');
		$this->db->from('users');
		$this->db->where('id',$userId);
		$userData = $this->db->get()->row();
		$username1 = $userData->firstName.$userData->lastName;
		$username = preg_replace('/[^A-Za-z0-9]/','', strip_tags($username1));
		$this->db->select('id,projectName,userId');
		$this->db->from('project_master');
		$this->db->where('userId',$userId);
		$this->db->where('projectName',$projectName);
		$similarProjectsCount = $this->db->get()->num_rows();
		$newProjectName = preg_replace('/[^A-Za-z0-9]/','', strip_tags($projectName));
		$newName = str_replace(" ",'',$newProjectName);
		if($similarProjectsCount!='' && $similarProjectsCount>0)
		{
			$projectPageName = $newName.'_'.$similarProjectsCount.'_By_'.$username;
		}
		else{
			$projectPageName = $newName.'_By_'.$username;
		}
		return $projectPageName;
	}
	public function GetProjectCategory()
	{
		$new_array = array();
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$data = $this->db->get()->result_array();
		if(!empty($data))
		{
		 	$new_array['category']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='No Category Found';
		 	$new_array['statusMessage']='';
	    }
      return $new_array;
	}
	public function GetProjectList($pageNo,$pageSize,$userId,$deviceId,$keyword,$category,$featuredType,$projectStatus)
	{
		if($category!='')
		{
			$categoryId = $this->findCategoryId($category);
		}
	   	$start=($pageNo-1)*$pageSize;
	   	if($pageNo!=-1)
		{
		  	$start=($pageNo-1)*$pageSize;
		}
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($keyword!='')
		{
		 $this->db->where("(project_master.projectName LIKE '%".$keyword."%'|| project_master.basicInfo LIKE '%".$keyword."%'|| project_master.keyword LIKE '%".$keyword."%')");
		}
	    if(!empty($category) && isset($categoryId) && !empty($categoryId))
	    {
			 $this->db->where('project_master.categoryId',$categoryId[0]['id']);
	    }
        if($projectStatus!='')
		{
			if($projectStatus=='Completed'){
				$pstatus = 1;
			}
			else{
			   $pstatus = 0;
			}
			$this->db->where('project_master.projectStatus',$pstatus);
	   }
		$this->db->where('project_master.status',1);
		if($pageNo!=-1)
		{
			$this->db->limit($pageSize);
			$this->db->offset($start);
		}
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->group_by('project_master.id');
		if($featuredType=='Featured')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		elseif($featuredType=='Most Appreciated')
		{
		    $this->db->order_by('project_master.like_cnt','desc');
		    $this->db->where('project_master.like_cnt >',0);
		}
		elseif($featuredType=='Most Discussed')
		{
		    $this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($featuredType=='Most Viewed')
		{
			 $this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($featuredType=='Most Recent')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		else
		{
			$this->db->order_by('project_master.created','desc');
		}
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
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
			{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(empty($data[$i]['rating']))
					{
						$data[$i]['rating']=0.0;
					}
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				    $data[$i]['userId'] = $userId;
				    $data[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
				    $data[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
				    $data[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
			    $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['project']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
		public function GetTrendingProjectList($userId,$deviceId,$keyword,$category,$featuredType,$projectStatus)
		{
			$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation');

			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			//$this->db->where('project_master.like_cnt >=10');
			$this->db->limit(10);
			//$this->db->order_by('project_master.created','desc');
			$this->db->order_by('project_master.like_cnt','RANDOM');
			$this->db->where('project_master.featured',1);
			$this->db->where('project_master.status',1);
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
			$this->db->group_by('project_master.id');
		    $data = $this->db->get()->result_array();
			/*print_r($data);die;*/
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
				{
						    $arr=array();
						    $arr2=array();
						 	foreach($atrribute as $val)
							{
							   //$values = $this->get_attribute_value($val['id']);
							   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
							$data[$i]['atrribute'] = implode(',',$arr);
							$data[$i]['attributeValue'] = implode(',',$arr2);
							$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
					   	}
						else
						{
							$data[$i]['atrribute'] = '';
							$data[$i]['attributeValue'] = '';
							$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
						}
						if(empty($data[$i]['rating']))
						{
							$data[$i]['rating']=0.0;
						}
						if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
						{
						  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
						}
						else
						{
							$data[$i]['profileImage'] = "";
						}
						$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
						$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
					    $data[$i]['imageCount'] = $imageCount;
					    $data[$i]['userId'] = $userId;
					    $data[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
					    $data[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
					    $data[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));

				    $i++;
				 }
			}
		   if(!empty($data))
			{
			 	$new_array['project']=$data;
			 	$new_array['statusCode']=200;
			 	$new_array['errorMessage']='';
			 	$new_array['statusMessage']='Done';
		    }
		    else
		    {
		     	$new_array['project']=array();
			 	$new_array['statusCode']=200;
			 	$new_array['errorMessage']='';
			 	$new_array['statusMessage']='Done';
		    }
		    return $new_array;
		}
	public function checkProjectView($project_id,$userId)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$userId);
		return $this->db->get()->result_array();
	}
	public function projectViewUpdate($project_id,$userId)
	{
		$data = array('userView'=>1);
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$userId);
	    return $this->db->update('user_project_views',$data);
	}
	public function viewCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('view_cnt', 'view_cnt+1', FALSE);
		$this->db->update('project_master');
	}
	public function projectViewEntry($project_id,$userId)
	{
		$data = array('projectId' =>$project_id,'ip_address'=>'','userView'  =>1,'userId'=>$userId);
		return $this->db->insert('user_project_views',$data);
	}
   public function getProjectDetail($project_id,$shareUrl,$userId,$deviceId)
	{
		if($shareUrl!='')
		{
			$project_id=$this->model_basic->getValueArray('project_master','id',array('projectPageName'=>$shareUrl));
		}
	  	$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,project_master.projectType,project_master.socialFeatures,project_master.thought as thoughtProcess, project_master.keyword,project_master.copyright as copyrightSetting, project_master.videoLink,project_master.basicInfo as description, users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_master.categoryId,project_master.projectStatus,users.profession as designation,project_master.created as publishedOnDate,users.address,users.city,users.country,project_master.status as projectPublishStatus,project_master.projectPageName as shareUrl,project_master.assignmentId');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->order_by('project_master.created','desc');
		$this->db->where('project_master.id',$project_id);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
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
			 	$this->db->select('user_project_image.image_thumb,user_project_image.id,user_project_image.cover_pic as isCoverPic');
				$this->db->from('user_project_image');
				$this->db->where('user_project_image.project_id',$row['projectId']);
$this->db->order_by('user_project_image.order_no','asc');
				$projectImages = $this->db->get()->result_array();
			     if(!empty($atrribute))
					{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(!empty($projectImages))
					{
					    $k=0;
					 	foreach($projectImages as $val)
						{
						   $values = $this->get_project_image_like_rating($row['projectId'],$val['id'],$userId);
						  if(!empty($values))
						   {
						   	  if($values[0]['image_rating']!='')
						   	  {
							  	 $projectImages[$k]['imageRating'] = $values[0]['image_rating'];
							  }
							  else
							  {
							  	 $projectImages[$k]['imageRating'] = 0.0;
							  }
							  if($values[0]['image_like']!='')
						   	  {
							  	 $projectImages[$k]['imageLike'] = $values[0]['image_like'];
							  }
							  else
							  {
							  	 $projectImages[$k]['imageLike'] = 0;
							  }
						   }
						   else
						   {
						   	  $projectImages[$k]['imageRating'] = 0.0;
						   	  $projectImages[$k]['imageLike'] = 0;
						   }
						  $projectImages[$k]['url'] = file_upload_base_url().'project/thumbs/'.$val['image_thumb'];
						  $projectImages[$k]['urlLarge'] = file_upload_base_url().'project/thumb_big/'.$val['image_thumb'];
						  $k++;
					   }
					 	$data[$i]['images'] = $projectImages;
				   	}
					else
					{
						 $data[$i]['images'] = array();
					}
					/*if(!empty($zipFile))
					{
					    $k=0;
					 	foreach($zipFile as $val)
						{
						  $zipFile[$k]['zipFileLink'] = file_upload_base_url().'project/'.$row['thumbImage'];
						  $k++;
					   }
					   $data[$i]['zipFileLink'] = $zipFile;
				   	}
					else
					{
						 $data[$i]['zipFileLink'] = array();
					}*/
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['projectUserId']);
					if(!empty($followingOrNot))
					{
						$data[$i]['userFollow'] = 1;
					}
					else
					{
						$data[$i]['userFollow'] = 0;
					}
					$overAllAttibuteAvg = $this->overAllAttibuteAvg($row['projectId'],$userId);
					//print_r($overAllAttibuteAvg);die;
					if(!empty($overAllAttibuteAvg)&&isset($overAllAttibuteAvg[0]['avg'])&&$overAllAttibuteAvg[0]['avg']!='')
					{
						$data[$i]['overAllAttibuteAvg'] = $overAllAttibuteAvg[0]['avg'];
					}
					else
					{
						$data[$i]['overAllAttibuteAvg'] = 0.0;
					}
					/*if($data[$i]['projectUserId'] == $userId)
					{*/
						$projectRating = $this->project_avg_rating($row['projectId']);
						if(!empty($projectRating))
						{
							$data[$i]['projectRating'] = $projectRating->rate;
						}
						else
						{
							$data[$i]['projectRating'] = 0.0;
						}
					/*}*/
					/*else
					{
						$projectRating = $this->projectRating($row['projectId'],$userId);
						if(!empty($projectRating))
						{
							$data[$i]['projectRating'] = $projectRating[0]['rating'];
						}
						else
						{
							$data[$i]['projectRating'] = 0.0;
						}
					}*/
					$similar_project = $this->getCategoryRelatedProjects($row['projectId'],$row['categoryId'],$userId);
				    if(!empty($similar_project))
					{
						$data[$i]['similarProject'] = $similar_project;
					}
					else
					{
						$data[$i]['similarProject'] = array();
					}
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0)
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						//$data[$i]['profileImage'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				   // $data[$i]['comment'] = $this->project_comment($row['projectId']);
if($userId == $row['projectUserId'])
				    {
				    	$commentFlag=1;
				    }
				    else
				    {
				    	$commentFlag=0;
				    }
				    $comments = $this->project_comment($row['projectId'],$commentFlag);
				    //$comments = $this->project_comment($row['projectId']);
				    if(!empty($comments))
				    {  $k=0;
				    	foreach($comments as $vl)
				    	{
						if(file_exists(file_upload_s3_path().'users/thumbs/'.$vl['personImageUrl']) && filesize(file_upload_s3_path().'users/thumbs/'.$vl['personImageUrl']) > 0 && $vl['personImageUrl']!='')
							{
							  	$comments[$k]['personImageUrl'] = file_upload_base_url().'users/thumbs/'.$vl['personImageUrl'];
							}
							else
							{
								$comments[$k]['personImageUrl'] = "";
							}
							if($vl['assignmentId'] > 0)
							{
								$comments[$k]['assignmentComment'] = "true";
							}
							else
							{
								$comments[$k]['assignmentComment'] = "false";
							}
							$k++;
						}
						$data[$i]['comment'] = $comments;
					}
					else
					{
						$data[$i]['comment'] = array();
					}
				    $data[$i]['userId'] = $userId;
				    $projectLike = $this->checkProjectLike($row['projectId'],$userId);
				    if(!empty($projectLike))
					{
						if($projectLike[0]['userLike'] == 0)
						{
							$data[$i]['projectLike'] = 0;
						}
						else
						{
							$data[$i]['projectLike'] = 1;
						}
					}
					else
					{
						$data[$i]['projectLike'] = 0;
					}
			    $i++;
			 }
			    $viewed = $this->checkProjectView($data[0]['projectId'],$userId);
                            $appreciated = $this->getValueOnly('project_appreciation','id',array('projectId'=>$data[0]['projectId'], 'appreciateByUserId'=>$userId));
			    if($appreciated !='' && $appreciated > 0)
			    {
			    	$data[0]['isAppreciatedWork']='true';
			    }
			    else
			    {
			    	$data[0]['isAppreciatedWork']='false';
			    }
			    $savedOnBoard = $this->getValueOnly('user_myboard','id',array('projectId'=>$data[0]['projectId'], 'myboardUser'=>$userId));
			    if($savedOnBoard !='' && $savedOnBoard > 0)
			    {
			    	$data[0]['isSavedOnBoard']='true';
			    }
			    else
			    {
			    	$data[0]['isSavedOnBoard']='false';
			    }
				if(!empty($viewed))
				{
					if($viewed[0]['userView'] == 0)
					{
						$this->projectViewUpdate($data[0]['projectId'],$userId);
						$this->viewCountIncrement($data[0]['projectId']);
					}
				}
				else
				{
					$this->projectViewEntry($data[0]['projectId'],$userId);
					$this->viewCountIncrement($data[0]['projectId']);
				}
				if($data[0]['projectUserId']==$userId)
				{
					$this->updateLikeRead($data[0]['projectId']);
					$this->updateCommentRead($data[0]['projectId']);
					$this->updateFollowingRead($userId);
				}
				if($data[0]['assignmentId'] != 0)
				{
					$teacherId=$this->getValueOnly('assignment','teacher_id',array('id'=>$data[0]['assignmentId']));
					if($teacherId == $userId)
					{
						$data[0]['isMyAssignmentProject'] ='true';
					}
					else
					{
						$data[0]['isMyAssignmentProject'] ='false';
					}
					$data[0]['isAssignmentProject'] ='true';
				}
				elseif($data[0]['assignmentId'] == 0)
				{
					$data[0]['isMyAssignmentProject'] ='false';
					$data[0]['isAssignmentProject'] ='false';
				}
if($data[0]['socialFeatures'] == 1)
				{
					$data[0]['socialFeatures'] ='true';
				}
				elseif($data[0]['socialFeatures'] == 0)
				{
					$data[0]['socialFeatures'] ='false';
				}
				if($data[0]['copyrightSetting'] == 1)
				{
					$data[0]['copyrightSetting'] ='Requires Permission';
				}
				else
				{
					$data[0]['copyrightSetting'] ='';
				}
if($data[0]['videoLink'] != '')
			{
				$data[0]['videoLink'] =$data[0]['videoLink'];
			}
			else
			{
				$data[0]['videoLink'] ='';
			}
$followers = $this->getFollowers($data[0]['projectUserId']);
			if($followers[0]['followers'] > 0)
			{
				$data[0]['fallowersCount'] =$followers[0]['followers'];
			}
			else
			{
				$data[0]['fallowersCount'] =0;
			}
			$data[0]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$data[0]['projectId'],'assignmentId'=>0,'status'=>1));
			$data[0]['likeCount'] = $this->model_basic->getCountWhere('user_project_views',array('projectId'=>$data[0]['projectId'],'userLike'=>1));
			$data[0]['viewCount'] = $this->model_basic->getCountWhere('user_project_views',array('projectId'=>$data[0]['projectId'],'userView'=>1));
		}
	   if(!empty($data))
		{
		 	$new_array=$data[0];
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='No Project Found';
		 	$new_array['statusMessage']='';
	    }
	    return $new_array;
	}
	public function project_avg_rating($projectId)
	{
		$this->db->select('AVG(rating) as rate');
		$this->db->from('project_rating');
		$this->db->where('projectId',$projectId);
		return $this->db->get()->row();
	}
	public function updateCommentRead($project_id)
	{
		$this->db->where('projectId', $project_id);
		$this->db->where('read',0);
		$this->db->update('user_project_comment',array('read'=>1));
	}
	public function updateLikeRead($project_id)
	{
		$this->db->where('projectId', $project_id);
		$this->db->where('userId !=',0);
		$this->db->where('userLike',1);
		$this->db->where('read',0);
		$this->db->update('user_project_views',array('read'=>1));
	}
	public function updateFollowingRead($userId)
	{
		$this->db->where('followingUser', $userId);
		$this->db->where('read',0);
		$this->db->update('user_follow',array('read'=>1));
	}
	public function getCategoryRelatedProjects($project_id,$cat_id,$userId)
	{
		$this->db->select('project_master.userId,project_master.id as projectId,project_master.projectName,users.firstName,users.lastName,users.profileImage,users.profession as designation,project_master.categoryId,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.id !=',$project_id);
		$this->db->where('project_master.categoryId',$cat_id);
		$this->db->where('project_master.status',1);
		$this->db->limit(20);
		$this->db->order_by('project_master.created','desc');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$data = $this->db->get()->result_array();
		/*print_r($data);die;*/
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
				$this->db->from('category_master');
				$this->db->where('category_master.id',$row['categoryId']);
				$this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
				$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				$atrribute = $this->db->get()->result_array();
				if(!empty($atrribute))
				{
				    $arr=array();
				    $arr2=array();
				 	foreach($atrribute as $val)
					{
					   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
					$data[$i]['atrribute'] = implode(',',$arr);
					$data[$i]['attributeValue'] = implode(',',$arr2);
					$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
			   	}
				else
				{
					$data[$i]['atrribute'] = '';
					$data[$i]['attributeValue'] = '';
					$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				}
				$projectRating = $this->projectRating($row['projectId'],$userId);
			    if(!empty($projectRating))
				{
					$data[$i]['projectRating'] = $projectRating[0]['rating'];
				}
				else
				{
					$data[$i]['projectRating'] = 0.0;
				}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0)
				{
				  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
				}
				else
				{
					//$data[$i]['profileImage'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
					$data[$i]['profileImage'] = "";
				}
				$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
				$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
			    $data[$i]['imageCount'] = $imageCount;
				$i++;
			}
		}
		return $data;
	}
    public function overAllAttibuteAvg($projectId,$uid)
	{
		$this->db->select('AVG(project_attribute_value_rating.rating) as avg');
		$this->db->from('project_attribute_value_rating');
		$this->db->where('project_attribute_value_rating.projectId',$projectId);
		$this->db->where('project_attribute_value_rating.userId',$uid);
	    return $this->db->get()->result_array();
	}
	public function projectRating($projectId,$uid)
	{
		$this->db->select('rating');
		$this->db->from('project_rating');
		$this->db->where('projectId',$projectId);
		$this->db->where('userId',$uid);
	    return $this->db->get()->result_array();
	}
	public function checkFollowingOrNot($user_id,$followingUser)
	{
		$this->db->select('*');
		$this->db->from('user_follow');
		$this->db->where('userId',$user_id);
		$this->db->where('followingUser',$followingUser);
		return $this->db->get()->result_array();
	}
	public function get_project_image_like_rating($projectId,$imgId,$userId)
	{
		$this->db->select('image_like,image_rating');
		$this->db->from('project_image_rating_like');
		$this->db->where('project_image_id',$imgId);
		$this->db->where('project_id',$projectId);
		$this->db->where('user_id',$userId);
		return $this->db->get()->result_array();
	}
	public function project_comment($project_id,$commentFlag='')
	{
		$this->db->select('user_project_comment.id as commentId,user_project_comment.comment as commentText,user_project_comment.created as commentDate,users.profileImage as personImageUrl,user_project_comment.name as commentPersonName,users.id as commentPersonId,user_project_comment.status as commentStatus,assignmentId');
		$this->db->from('user_project_comment');
		$this->db->where('user_project_comment.projectId',$project_id);
		if($commentFlag==0)
		{
			$this->db->where('user_project_comment.status',1);
		}
		//$this->db->where('user_project_comment.assignmentId',0);
		$this->db->join('users', 'users.id = user_project_comment.userId');
		//$this->db->limit(20);
		return $this->db->get()->result_array();
	}
	public function findCategoryId($cat)
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->where('categoryName',$cat);
	    return $this->db->get()->result_array();
	}
    function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
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
	  public function ProjectLike($projectId,$userId,$deviceId)
	{
		    $new_array = array();
			$viewed = $this->checkProjectLike($projectId,$userId);
			if(!empty($viewed))
			{
				if($viewed[0]['userLike'] == 0)
				{
					$res = $this->projectUpdateLike($projectId,$userId);
					if($res > 0)
					{
						$this->likeCountIncrement($projectId);
						$this->insertActivity('Like From App','',$projectId,'Liked',$deviceId,$userId);
					}
				}
			}
			else
			{
				$res = $this->projectLikeEntry($projectId,$userId);
				if($res > 0)
				{
					$this->likeCountIncrement($projectId);
					$this->insertActivity('Like From App','',$projectId,'Liked',$deviceId,$userId);
				}
			}
		if(isset($res)&&!empty($res))
		{
			$msg = array();
		    $userDetail = $this->loggedInUserInfoById($userId);
		    $proDetail          = $this->getProjectData($projectId);
			$commentProjectName = $proDetail[0]['projectName'];
		    if(file_exists(file_upload_s3_path().'users/thumbs/'.$nameBy['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$nameBy['profileImage']) > 0)
			{
				$msg['notificationImageUrl'] = file_upload_base_url().'users/thumbs/'.$nameBy['profileImage'];
			}
			else
			{
				$msg['notificationImageUrl'] = '';
			}
			$msg['notificationTitle'] = 'New Project Liked';
			$msg['notificationMessage']  = ucwords($userDetail['firstName'].' '.$userDetail['lastName']).' liked your project. '.$proDetail[0]['projectName'];
			$msg['notificationType']   = 3;
		    $msg['notificationId']     = $proDetail[0]['id'];
		    $msg['type']     = 0;
			$this->sendGcmToken($proDetail[0]['userId'],$msg);
		 	$new_array['isUpdatedOnServer']=1;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	    	$new_array['isUpdatedOnServer']=0;
	     	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
	    }
		return $new_array;
    }
    public function insertActivity($pageName,$urlName='',$project_id='',$activityName,$deviceId,$userId)
	{
		$userName = $this->get_where('users',array('id'=>$userId));
		if(!empty($userName)){
			$name = $userName['firstName'].' '.$userName['lastName'];
		}else{
			$name ='';
		}
		if($project_id!='')
		{
			$projectName = $this->getValue('project_master','projectName'," `id` = '".$project_id."'");
		}
		else
		{
			$projectName = '';
		}
		$userActivity = array(
					'userId'		=> $userId,
					'userName'		=> $name,
					'pageName'		=> $pageName,
					'urlName'		=> $urlName,
					'projectId'		=> $project_id,
					'activityName'	=> $activityName,
					'description'	=> $name.' '.$activityName.' '.$projectName,
					'deviceId'	=> $deviceId,
					'activityTime'	=> date('Y-m-d h:i:s')
		);
		return $this->db->insert('user_activity_master',$userActivity);
     }
	public function checkProjectLike($project_id,$userId)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$userId);
		return $this->db->get()->result_array();
	}
	public function projectUpdateLike($project_id,$userId)
	{
		$data = array('userLike'  =>1,'ip_address'=>'','like_date' =>date("Y-m-d H:i:s"));
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$userId);
		return $this->db->update('user_project_views',$data);
	}
	public function projectLikeEntry($project_id,$userId)
	{
		$data = array('projectId' =>$project_id,'userLike'=>1,'userId'=>$userId,'like_date' =>date("Y-m-d H:i:s"));
		return $this->db->insert('user_project_views',$data);
	}
	public function likeCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('like_cnt', 'like_cnt+1', FALSE);
		$this->db->update('project_master');
	}
       public function add_project($data)
	{
		$this->db->insert('project_master',$data);
		return $this->db->insert_id();
	}
	public function getValue($table_name="",$field_name="",$condition="")
	{
		//echo $field_name;die;
		$query 	= "SELECT
						'".$field_name."'
					FROM
						".$table_name;
		if($condition <> "")
		{
			$query 	.= " WHERE ".$condition;
		}
		$result = $this->db->query($query);
		//echo $this->db->last_query();die;
		if($result)
		{
			$recordSet 	= $result->row_array();
			if(count($recordSet) > 0)
			{
				return $recordSet[$field_name];
			}
		}
		return false;
	}
	public function add_img($data)
	{
		$this->db->insert('user_project_image',$data);
		return $this->db->insert_id();
	}
/*	public function add($data)
	{
		$this->db->insert('content_master',$data);
		return $this->db->insert_id();
	}*/
		public function ImageCropMaster($max_width, $max_height, $source_file, $dst_dir, $quality = 80)
	{
		include_once APPPATH . "libraries/Zebra_Image.php";
		// create a new instance of the class
		$image = new Zebra_Image();
		// indicate a source image (a GIF, PNG or JPEG file)
		$image->source_path = $source_file;
		// indicate a target image
		// note that there's no extra property to set in order to specify the target
		// image's type -simply by writing '.jpg' as extension will instruct the script
		// to create a 'jpg' file
		$image->target_path = $dst_dir;
		// since in this example we're going to have a jpeg file, let's set the output
		// image's quality
		$image->jpeg_quality = 100;
		// some additional properties that can be set
		// read about them in the documentation
		$image->preserve_aspect_ratio = true;
		$image->enlarge_smaller_images = true;
		$image->preserve_time = true;
		// resize the image to exactly 100x100 pixels by using the "crop from center" method
		// (read more in the overview section or in the documentation)
		//  and if there is an error, check what the error is about
		$size = getImageSize($source_file);
		$w = $size[0];
		$h = $size[1];
		if($w > $max_width || $h > $max_height)
		{
			if (!$image->resize($max_width, $max_height, ZEBRA_IMAGE_CROP_CENTER)) {
			    // if there was an error, let's see what the error is about
			    switch ($image->error) {
			        case 1:
			            echo 'Source file could not be found!';
			            break;
			        case 2:
			            echo 'Source file is not readable!';
			            break;
			        case 3:
			            echo 'Could not write target file!';
			            break;
			        case 4:
			            echo 'Unsupported source file format!';
			            break;
			        case 5:
			            echo 'Unsupported target file format!';
			            break;
			        case 6:
			            echo 'GD library version does not support target file format!';
			            break;
			        case 7:
			            echo 'GD library is not installed!';
			            break;
			    }
			// if no errors
			} else {
			   return true;
			}
		}
		else
		{
			if (!$image->resize($max_width, $max_height, ZEBRA_IMAGE_BOXED, '#ffffff')) {
			    // if there was an error, let's see what the error is about
			    switch ($image->error) {
			        case 1:
			            echo 'Source file could not be found!';
			            break;
			        case 2:
			            echo 'Source file is not readable!';
			            break;
			        case 3:
			            echo 'Could not write target file!';
			            break;
			        case 4:
			            echo 'Unsupported source file format!';
			            break;
			        case 5:
			            echo 'Unsupported target file format!';
			            break;
			        case 6:
			            echo 'GD library version does not support target file format!';
			            break;
			        case 7:
			            echo 'GD library is not installed!';
			            break;
			    }
			// if no errors
			} else {
			   return true;
			}
		}
	}
	public function update_project_status($project_id,$det)
	{
		$this->db->where('id',$project_id);
		return $this->db->update('project_master',$det);
	}
    public function getCategoryAttribute($cat_id)
	{
		$this->db->select('*');
		$this->db->from('category_attribute_relation');
		$this->db->where('category_attribute_relation.categoryId',$cat_id);
		$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
		$data = $this->db->get()->result_array();
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$this->db->select('attributeValue');
				$this->db->from('attribute_value_master');
				$this->db->where('attributeId',$row['attributeId']);
				$atrribute = $this->db->get()->result_array();
				if(!empty($atrribute)){
					$arr = array();
					foreach($atrribute as $val){
						$arr[] = $val['attributeValue'];
					}
					$data[$i]['atrribute_value'] = $arr;
				}
				else
				{
					$data[$i]['atrribute_value'] = array();
				}
				$i++;
			}
		}
		return $data;
	}
 	public function getProjectData($id)
	{
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('id',$id);
	    return $this->db->get()->result_array();
	}
	public function loggedInUserInfoById($user_id)
	{
		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row_array();
	}
	public function sendMail($data)
	{
		//print_r($data);die;
		$localhost = array(
		    '127.0.0.1',
		    '::1'
		);
		$this->load->library('email');
 		$config = Array(
 		                'charset'=>'utf-8',
 		                'wordwrap'=> TRUE,
 		                'mailtype' => 'html'
                  			);
	 		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
	 		{
	 		    	/*$config['protocol']='smtp';
	 		    	$config['smtp_host']='ssl://smtp.googlemail.com';
	 		    	$config['smtp_port']='465';
	 		    	$config['smtp_user']='test.unichronic@gmail.com';
	 		    	$config['smtp_pass']='Uspl@12345';
	 		    	$config['mailtype']='html';*/
	 		}
			$this->email->initialize($config);
			/*if(isset($data['fromEmail']) && $data['fromEmail']!='')
			{
				$fromEmail 	=	$this->getValue($this->db->dbprefix('admin_users'),"email"," `id` = '1' ");
			}*/
			$fromName 	=	'creonow Team';
			$this->email->clear(TRUE);
			$this->email->to($data['to']);
			$this->email->from($data['fromEmail'],$fromName);
			$this->email->subject($data['subject']);
			$this->email->message($data['template']);
/*			$this->email->send();
			echo $this->email->print_debugger();
			pr($data);*/
			 if($this->email->send())
				return true;
			else
				return false;
	}
   public function AddProject($userId,$deviceId,$projectName,$projectType,$projectStatus,$projectPublish,$category,$imageList,$videoLink,$coverPicPosition,$socialFeatures,$waterMarkText,$waterMarkTextColor,$thoughtProcess,$keyword,$copyrightSetting,$description,$offlineId,$isForCompetition,$isShowreel)
	{
	    $new_array = array();
	    $categoryData = $this->findCategoryId($category);
	    if(!empty($categoryData))
		{
			$categoryId      = $categoryData[0]['id'];
			$requiresFunding = 0;
			$projectPageName = $this->generateProjectPageName($projectName,$userId);
			$data = array('projectName'=>$projectName,'projectPageName'=>$projectPageName,'basicInfo'=>$description,'categoryId'=>$categoryId,'projectType'=>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures'=>$socialFeatures,'projectStatus'=>$projectStatus,'created'=>date('Y-m-d H:i:s'), 'userId'=>$userId, 'status'=>2,'videoLink'=>$videoLink, 'thought'=>$thoughtProcess, 'keyword'=>$keyword, 'copyright'=> $copyrightSetting,'showreel'=>$isShowreel);
			$projectId = $this->add_project($data);
			if($projectId > 0)
			{
			    $title = $this->getValue('project_master',"projectName"," `id` = '".$projectId."' ");
				$res=$projectId;
				if($res > 0)
				{
					if(!empty($imageList))
					{
						$i = 1;$z=1;
						foreach($imageList as $row)
						{
						 	$today = date("Y_m_d_H_i_s");
						 	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$shuffled = str_shuffle($str);
						 	$binary=base64_decode($row);
						    header('Content-Type: bitmap; charset=utf-8');
						    $file = fopen(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg', 'w');
						    fwrite($file, $binary);
						    fclose($file);
						    $det = array("project_id"=>$res,'image_thumb'=>$today.$shuffled.'.jpg','created'=>date('Y-m-d H:i:s'),'size'=>'','order_no'=>$z);
						    if($i == ($coverPicPosition + 1))
							{
								$det['cover_pic'] = 1;
							}
							$insert_id = $this->add_img($det);
						    $this->ImageCropMaster('307','310',file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumbs/'.$today.$shuffled.'.jpg');
						    $heightWidth = getimagesize(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg');
						    $bigThumbWidth=(960 * $heightWidth[1])/$heightWidth[0];
						    $this->ImageCropMaster('960',$bigThumbWidth,file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumb_big/'.$today.$shuffled.'.jpg');
							if($waterMarkText !='')
							{
								$text = $waterMarkText;
								$color = 'ffffff';
								if($waterMarkTextColor != '')
								{
									$color = $waterMarkTextColor;
								}
								if(!file_exists(file_upload_s3_path().'project/thumb_big'.$today.$shuffled.'.jpg'))
								{
									$this->load->library('image_lib');
									$this->watermark($today.$shuffled.'.jpg',$text,'middle','center',$color);
								}
							}
							$i++;$z++;
					  	}
					}
					if($projectPublish == 0)
					{
						$status       = 0;
						$admin_status = '';
					}
					elseif($projectPublish == 3)
					{
						$status       = 3;
						$admin_status = '';
					}
					elseif($projectPublish == 1)
					{
						$instituteIdOfUser=$this->model_basic->getValueArray('users','instituteId',array('id'=>$userId),$order_by='',$limit='');
						$admin_flag=$this->model_basic->getValueArray('institute_master','admin_status',array('id'=>$instituteIdOfUser),$order_by='',$limit='');
						if($admin_flag == 1 && $isForCompetition==0)
						{
							$status       = 3;
							$admin_status = 0;
							$retMsg='Project added and admin approval required to make this project public till then your project status change to private successfully.';
						}
						else
						{
							$status       = 1;
							$admin_status = '';
						}
					}
$st=array('status'=>$status,'admin_status'=>$admin_status);
					$this->update_project_status($projectId,$st);
					if($status == 1 && $admin_status=='')
					{
						$proDetail          = $this->getProjectData($projectId);
						$newAddedPrjectName = $proDetail[0]['projectName'];
						$addedBy            = $this->loggedInUserInfoById($proDetail[0]['userId']);
						$addedByName        = ucwords($addedBy['firstName'].' '.$addedBy['lastName']);
						$addedByEmail       = $addedBy['email'];
						$from               = 'contact@creonow.com';
						$subjectBy          = 'Successfully added project "'. $newAddedPrjectName.'" to creonow';
						$templateAddedBy    = 'Hello <b>'.$addedByName. '</b>,<br />Your project "<b>' .$newAddedPrjectName.'</b>" is added successfully to creonow.<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
						$sendEmailToAddUser = array('to'       =>$addedByEmail,'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
						$this->sendMail($sendEmailToAddUser);
						$templateToTushar = 'Hello <b>Tushar</b>,<br /><b>'.$addedByName. '</b>, added new project "<b>' .$newAddedPrjectName.'</b>" successfully to creonow.<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
						$sendEmailToTushar= array('to'       =>'tushar.desai@emmersivetech.com','subject'  =>$subjectBy,'template' =>$templateToTushar,'fromEmail'=>$from);
						$this->sendMail($sendEmailToTushar);
						$templateToDeb = 'Hello <b>Deb</b>,<br /><b>'.$addedByName. '</b>, added new project "<b>' .$newAddedPrjectName.'</b>" successfully to creonow.<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
						$sendEmailToDeb= array('to'       =>'ddutta@emmersivetech.com','subject'  =>$subjectBy,'template' =>$templateToDeb,'fromEmail'=>$from);
						$this->sendMail($sendEmailToDeb);
						$templateToVivek = 'Hello <b>Vivek</b>,<br /><b>'.$addedByName. '</b>, added new project "<b>' .$newAddedPrjectName.'</b>" successfully to creonow.<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
						$sendEmailToVivek= array('to'       =>'vivek.bhide@emmersivetech.com','subject'  =>$subjectBy,'template' =>$templateToVivek,'fromEmail'=>$from);
						$this->sendMail($sendEmailToVivek);
						$followedUsers = $this->getFollowedUsers($proDetail[0]['userId']);
						if(!empty($followedUsers))
						{
							foreach($followedUsers as $key)
							{
								$followedUsersDetail   = $this->loggedInUserInfoById($key['userId']);
								$followedUsersName     = ucwords($followedUsersDetail['firstName'].' '.$followedUsersDetail['lastName']);
								$followedUsersEmail    = $followedUsersDetail['email'];
								$subjectTo             = ''.$addedByName.' added a new project on creonow.';
								$templateFollowedBy    = 'Hello <b>'.$followedUsersName. '</b>,<br />The user '.$addedByName.' whom you are following on creonow has added new project "<b>' .$newAddedPrjectName.'</b>".<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the project.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
								$sendEmailToFolledUser = array('to'       =>$followedUsersEmail,'subject'  =>$subjectTo,'template' =>$templateFollowedBy,'fromEmail'=>$from);
								$this->sendMail($sendEmailToFolledUser);
							}
						}
					}
				}
				$new_array['projectId'] = $projectId;
				$new_array['offlineId'] = $offlineId;
			 	$new_array['statusCode']=200;
			 	$new_array['errorMessage']='';
			 	if(isset($retMsg))
			 	{
			 		$new_array['statusMessage']=$retMsg;
			 	}
			 	else
			 	{
			 		$new_array['statusMessage']='';
			 	} 	
			}
			else
			{
				$new_array['projectId'] = 0;
				$new_array['offlineId'] = 0;
			 	$new_array['statusCode']=404;
			 	$new_array['errorMessage']='error';
			 	$new_array['statusMessage']='';
			}
		}
		else
		{
			$new_array['projectId'] = 0;
			$new_array['offlineId'] = 0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
		}
		return $new_array;
	}
public function watermark($image = '',$text,$vrtPostion = '',$horPostion = '',$textColor = '')
	{
		$config['source_image'] = file_upload_s3_path().'project/thumb_big/'.$image;
		$config['wm_text'] = $text;
		$config['wm_font_path'] = './assets/fonts/HelveticaNeue-Bold.ttf';
		$config['wm_type'] = 'text';
		//$config['new_image'] = file_upload_s3_path().'project/'.$image;
		$config['wm_font_size'] = '20';
		$config['wm_font_color'] = $textColor;
		$config['wm_vrt_alignment'] = $vrtPostion;
		$config['wm_hor_alignment'] = $horPostion;
		$config['wm_opacity'] = 10;
		/*$config['wm_padding'] = '20';
		$config['wm_x_transp'] = '4';*/
		$this->image_lib->initialize($config);
		return $this->image_lib->watermark();
	}
	public function getFollowedUsers($addedBy)
	{
		$this->db->select('userId');
		$this->db->from('user_follow');
		$this->db->where('followingUser',$addedBy);
		return $this->db->get()->result_array();
	}
    public function AddProjectReview($projectId,$userId,$deviceId,$commentText)
	{
		$new_array = array();
	    $userDetail = $this->loggedInUserInfoById($userId);
		if(!empty($userDetail))
		 {
			$name = ucwords($userDetail['firstName'].' '.$userDetail['lastName']);;
			$email = $userDetail['email'];
			$comment = $commentText;
			$data   = array('name'=>ucwords($name),'email'=>$email,'comment'=>ucfirst($comment),'projectId'=>$projectId,'userId'=>$userId,'created'=>date('Y-m-d H:i:s'),'status'=>0);
			$commentId = $this->add_comment($data);
			if($commentId > 0)
			{
				$this->insertActivity('Comment From App','',$projectId,'Comment',$deviceId,$userId);
				$this->commentCountIncrement($projectId);
				$proDetail          = $this->getProjectData($projectId);
				$commentProjectName = $proDetail[0]['projectName'];
				$commentTo          = $this->loggedInUserInfoById($proDetail[0]['userId']);
				$commentBy          = $this->loggedInUserInfoById($userId);
				$emailTo            = $commentTo['email'];
				$from               = 'contact@creonow.com';
				$nameBy             = ucwords($commentBy['firstName'].' '.$commentBy['lastName']);
				$nameTo             = ucwords($commentTo['firstName'].' '.$commentTo['lastName']);
				$templateCommentTo  = 'Hello <b>'.$nameTo. '</b>, <br /><b>'.$nameBy.'</b> recently commented on your project "<b>' .$commentProjectName.'</b>" on creonow.<br /><a href="'.base_url().'project/projectDetail/'.$projectId.'/'.$proDetail[0]['userId'].'">Click here</a>  to view the comment.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
				$emailDetailComment = array('to'=>$emailTo,'subject'=>'Someone has commented on  your project','template' =>$templateCommentTo,'fromEmail'=>$from);
				$this->sendMail($emailDetailComment);
				$msg = array();
				$msg['notificationImageUrl'] = '';
				/*pr($nameBy);*/
			    /*if(file_exists(file_upload_s3_path().'users/thumbs/'.$nameBy['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$nameBy['profileImage']) > 0)
				{
					$msg['notificationImageUrl'] = file_upload_base_url().'users/thumbs/'.$nameBy['profileImage'];
				}*/
				$msg['notificationTitle'] = 'New Comment';
				$msg['notificationMessage']  = $nameBy.' commented on your project '. $commentProjectName;
				$msg['notificationType']   = 3;
			    $msg['notificationId']     = $proDetail[0]['id'];
			    $msg['type']     = 0;
				$this->sendGcmToken($proDetail[0]['userId'],$msg);
				$new_array['commentId'] = $commentId;
			 	$new_array['statusCode']=200;
			 	$new_array['errorMessage']='';
			 	$new_array['statusMessage']='Done';
			}
			else
			{
				$new_array['commentId'] = 0;
			 	$new_array['statusCode']=404;
			 	$new_array['errorMessage']='error';
			 	$new_array['statusMessage']='';
			}
		}
		else
		{
			    $new_array['commentId'] = 0;
			 	$new_array['statusCode']=404;
			 	$new_array['errorMessage']='error';
			 	$new_array['statusMessage']='';
		}
		return $new_array;
	}
	public function add_comment($data)
	{
		$this->db->insert('user_project_comment',$data);
		return $this->db->insert_id();
	}
	public function commentCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('comment_cnt', 'comment_cnt+1', FALSE);
		$this->db->update('project_master');
	}
	public function DeleteProject($project_id,$userId,$deviceId)
	{
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('id',$project_id);
		$projectData = $this->db->get()->row();
		if($this->db->insert('project_master_deleted',$projectData))
		{
			$this->db->where('id',$project_id);
			$result = $this->db->delete('project_master');
			$this->insertActivity('Delete From App','',$project_id,'Delete',$deviceId,$userId);
		}
		else
		{
			$result = 0;
		}
   		 $new_array = array();
		 if($result > 0 )
		 {
			$new_array['isUpdatedOnServer'] = 1;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
		else
		{
		    $new_array['isUpdatedOnServer'] = 0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
		}
		return $new_array;
	}
    public function getUserInstituteId($userId)
	{
		$this->db->select('instituteId');
		$this->db->from('users');
		$this->db->where('status',1);
		$this->db->where('id',$userId);
	    return $this->db->get()->result_array();
    }
    public function GetUserProjectList($user_id,$deviceId,$active_tab,$instituteId,$peopleId)
	{
		//$new_array = array();
		$institute = $this->getUserInstituteId($peopleId);
		$institutepeopleId = $this->getUserInstituteId($user_id);
	  /*0 for all active except submitted for competition
	    1 for published/completed
        2 for savedInDraft
        3 for workInProgress
        4 for appreciated
        5 for LikedOn
        6 for DiscussedOn
        7 for SubmitedForCompetition*/
		/*$start=($page-1)*$limit;*/
		if($active_tab==8)
		{
			$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,users.city,project_master.status as project_normal_status,project_master.created,assignment_status as assignmentStatus');
		}
		else
		{
			$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,users.city,project_master.status as project_normal_status,project_master.created');
		}
	   if($active_tab!=6 && $active_tab!=5)
	   {
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->where('users.id',$peopleId);
           if($active_tab==0)
			{
				$this->db->where('project_master.competitionId',0);
				$this->db->where('project_master.status',1);
		    }
		    if($active_tab==1)
			{
				$this->db->where('project_master.projectStatus',1);
		    }
			if($active_tab==3)
			{
				$this->db->where('project_master.projectStatus',0);
			}
			if($active_tab==8)
			{
				$this->db->where('project_master.assignmentId !=',0);
			}
			if($active_tab==4)
			{
				$this->db->where('project_master.like_cnt !=',0);
				$this->db->order_by('project_master.like_cnt','desc');
			}
			if($active_tab==7)
			{
				$this->db->where('project_master.status',1);
				$this->db->where('project_master.competitionId !=',0);
			}
			elseif($active_tab==2)
			{
				$this->db->where('project_master.status',0);
			}
			else
			{
			  if($institutepeopleId[0]['instituteId']==$institute[0]['instituteId'])
				{
			  		$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					$where = "(( project_master.status=1))";
				    $this->db->where($where);
				}
			}
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
			$this->db->group_by('project_master.id');
		    $data_array = $this->db->get()->result_array();
		}
		if($active_tab==6)
	    {
			$this->db->from('user_project_comment');
			//$this->db->group_by('user_project_comment.projectId');
			$this->db->where('user_project_comment.status',1);
$this->db->where('user_project_comment.assignmentId',0);
$this->db->where('project_master.socialFeatures',1);
			$this->db->where('user_project_comment.userId',$peopleId);
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->order_by('user_project_comment.id','desc');
			$this->db->where('users.id !=',$peopleId);
			/*$this->db->limit($limit);
			$this->db->offset($start);*/
			$this->db->join('project_master', 'user_project_comment.projectId = project_master.id');
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
			$this->db->group_by('project_master.id');
		    $data = $this->db->get()->result_array();
		    $data_array=array();
				if(!empty($data))
			    { $i=0;
				 foreach($data as $row)
				 {
					$institute = $this->getUserInstituteId($row['projectUserId']);
					 if(isset($institute)&& !empty($institute)&&$instituteId!=0)
					   {
							if($institute[0]['instituteId']==$instituteId)
							{
								if($row['project_normal_status']=1 || $row['project_normal_status']=3)
								{
									$data_array[]=$row;
								}
							}
							else
							{
								if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
							}
						}
						elseif(isset($institute)&&!empty($institute)&&$instituteId==0)
						{
							if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
						}
						else
						{
							  if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
						}
				    $i++;
				 }
			  }
		}
		if($active_tab==5)
	    {
	   		$this->db->from('user_project_views');
			$this->db->where('user_project_views.userId',$peopleId);
			$this->db->where('user_project_views.userlike',1);
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->where('users.id !=',$peopleId);
			/*$this->db->limit($limit);
			$this->db->offset($start);*/
			$this->db->join('project_master', 'user_project_views.projectId = project_master.id');
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
			$this->db->group_by('project_master.id');
		    $data = $this->db->get()->result_array();
		    $data_array=array();
				if(!empty($data))
			    { $i=0;
				 foreach($data as $row)
				 {
					$institute = $this->getUserInstituteId($row['projectUserId']);
					 if(isset($institute)&& !empty($institute)&&$instituteId!=0)
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								if($row['project_normal_status']=1 || $row['project_normal_status']=3)
								{
									$data_array[]=$row;
								}
							}
							else
							{
								if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
							}
						}
						elseif(isset($institute)&&!empty($institute)&&$instituteId==0)
						{
							if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
						}
						else
						{
							  if($row['project_normal_status']=1)
								{
									$data_array[]=$row;
								}
						}
				    $i++;
				 }
			  }
		}
	   /*print_r($data_array);die;*/
		if(!empty($data_array))
		{ $i=0;
			 foreach($data_array as $row)
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
						$values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
					$data_array[$i]['atrribute'] = implode(',',$arr);
					$data_array[$i]['attributeValue'] = implode(',',$arr2);
					$data_array[$i]['categoryName'] = $atrribute[0]['categoryName'];
			   	}
				else
				{
					$data_array[$i]['atrribute'] = '';
					$data_array[$i]['attributeValue'] = '';
					$data_array[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$row['categoryId']."'");
				}
			   	if(empty($data_array[$i]['rating']))
				{
					$data_array[$i]['rating']=0.0;
				}
			 	if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
				{
				  	$data_array[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
				}
				else
				{
					$data_array[$i]['profileImage'] = "";
				}
			    $data_array[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
				$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
			    $data_array[$i]['imageCount'] = $imageCount;
			    $data_array[$i]['userId'] = $peopleId;
			    $data_array[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
			    $data_array[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
			    $data_array[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
    		    $i++;
			 }
		}
	   if(!empty($data_array))
		{
		 	$new_array['project']=$data_array;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
   /////////////////////////////////////////////////////////-- Project End -- ////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////-- Institute -- ////////////////////////////////////////////////////////////
    public function GetInstituteList($pageNo,$pageSize,$userId,$deviceId,$keyword)
	{
		$start=($pageNo-1)*$pageSize;
		$this->db->select('instituteName,id as instituteId,adminId,instituteLogo as instituteLogoUrl,coverImage as instituteCoverImageUrl,pageName,address,contactNo');
		$this->db->from('institute_master');
		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->where('status',1);
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
			 	if($row['adminId']!=0)
			 	{
				 	$this->db->select('firstName,lastName');
					$this->db->from('users');
					$this->db->where('id',$row['adminId']);
				 	$user = $this->db->get()->result_array();
				     if(!empty($user))
					   {
						  $data[$i]['adminName'] = $user[0]['firstName'].' '.$user[0]['lastName'];
					   }
					   else
					   {
						  $data[$i]['adminName'] = '';
					   }
				  }
				  else
				  {
				  	$data[$i]['adminName'] = 'creonow Admin';
				  }
					if(file_exists(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl']) && filesize(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl']) > 0)
				{
				  	$data[$i]['instituteLogoUrl'] = file_upload_base_url().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl'];
					}
					else
					{
						//$data[$i]['instituteLogoUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['instituteLogoUrl'] = '';
					}
				$data[$i]['instituteCoverImageUrl'] = file_upload_base_url().'institute/coverImage/thumbs/'.$row['instituteCoverImageUrl'];
				/*$data[$i]['viewCount'] = 0;
				$data[$i]['likeCount'] = 0;
				$data[$i]['commentCount'] = 0;
				$data[$i]['rating'] = 0;
*/
				if($userId!='-1' || $userId!='')
				{
					$relationData = $this->check_user_institute_with_instid($userId,$row['instituteId']);
					$instituteId = $this->getValue('users','instituteId','id='.$userId);
					$data[$i]['isAlreadyJoin'] = 0;
					if($instituteId == $row['instituteId'])
					{
						$data[$i]['isAlreadyJoin'] = 1;
					}
					if(!empty($relationData))
					{
						$data[$i]['isAbleToJoin'] = 1;
					}
					else
					{
						$data[$i]['isAbleToJoin'] = 0;
					}
				}
				else
				{
					$data[$i]['isAbleToJoin'] = 0;
					$data[$i]['isAlreadyJoin'] = 0;
				}
				$data[$i]['userId'] = $userId;
		      $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['institute']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['institute']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
	public function check_user_institute_with_instid($user_id,$insId)
	{
		$this->db->select('institute_master.id as instituteId,institute_master.pageName');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$this->db->where('users.alumniFlag',0);
		$this->db->where('institute_master.id',$insId);
		$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		$this->db->join('institute_master', 'institute_csv_users.instituteId = institute_master.id');
	   	return $this->db->get()->result_array();
    }
	public function check_user_institute($user_id)
	{
		$this->db->select('institute_master.id as instituteId,institute_master.pageName');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$this->db->where('users.alumniFlag',0);
		$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		$this->db->join('institute_master', 'institute_csv_users.instituteId = institute_master.id');
	   	return $this->db->get()->result_array();
    }
	public function GetInstituteDetail($instituteId,$userId,$deviceId)
	{
		$this->db->select('instituteName,id as instituteId,adminId,instituteLogo as instituteLogoUrl,coverImage as instituteCoverImageUrl,pageName,address,contactNo');
		$this->db->from('institute_master');
		$this->db->where('id',$instituteId);
		$this->db->where('status',1);
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
			 	if($row['adminId']!=0)
			 	{
				 	$this->db->select('firstName,lastName');
					$this->db->from('users');
					$this->db->where('id',$row['adminId']);
				 	$user = $this->db->get()->result_array();
				     if(!empty($user))
					   {
						  $data[$i]['adminName'] = $user[0]['firstName'].' '.$user[0]['lastName'];
					   }
					   else
					   {
						  $data[$i]['adminName'] = '';
					   }
				  }
				  else
				  {
				  	$data[$i]['adminName'] = 'creonow Admin';
				  }
					if(file_exists(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl']) && filesize(file_upload_s3_path().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl']) > 0)
					{
					  	$data[$i]['instituteLogoUrl'] = file_upload_base_url().'institute/instituteLogo/thumbs/'.$row['instituteLogoUrl'];
					}
					else
					{
						//$data[$i]['instituteLogoUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['instituteLogoUrl'] = '';
					}
				$data[$i]['instituteCoverImageUrl'] = file_upload_base_url().'institute/coverImage/thumbs/'.$row['instituteCoverImageUrl'];
				//$data[$i]['instanceList'] = $this->model_basic->getData('feedback_instance','id,name as titile,DATE_FORMAT(start_session,"%Y/%m/%d") as startDate,DATE_FORMAT(end_session,"%Y/%m/%d") as endDate',array('institute_id'=>$row['instituteId'],'status'=>1));
				$data[$i]['instanceList'] = $this->model_basic->getAllData('feedback_instance','id,name as title,start_session as startDate,end_session as endDate',array('institute_id'=>$row['instituteId'],'status'=>1),array('id'=>'desc'));
                                 if(!empty($data[$i]['instanceList']))
				{
					$instanceList=array();
					foreach($data[$i]['instanceList'] as $instance )
					{ $isSubmitted=$this->model_basic->getValueArray('institutefeedback','id',array('user_id'=>$userId,'instance_id'=>$instance['id']),$order_by='',$limit='');
						if($isSubmitted > 0)
						{
							$instance['isSubmitted']='true';
						}
						else
						{
							$instance['isSubmitted']='false';
						}
						$instanceList[]=$instance;
					}
					$data[$i]['instanceList'] = $instanceList;
				}
				else
				{
					$data[$i]['instanceList'] = array();
				}
				if($userId != '-1' && $userId!='')
				{
					$relationData=array();
					$relationData = $this->getUserInstituteId($userId);
					if(!empty($relationData) && $relationData[0]['instituteId'] == $instituteId)
					{
						$data[$i]['isAbleToJoin'] = 1;
					}
					else
					{
						$data[$i]['isAbleToJoin'] = 0;
					}
				}
				else
				{
					$data[$i]['isAbleToJoin'] = 0;
				}
			    $data[$i]['userId'] = $userId;
		      $i++;
			 }
	}
	   if(!empty($data))
		{
		 	$new_array=$data[0];
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	//$new_array['institute']=array();
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
	    }
	    return $new_array;
    }
    public function GetInstituteProjectList($pageNo,$pageSize,$userId,$deviceId,$keyword,$category,$featuredType,$projectStatus,$instituteId)
	{
		if($category!='')
		{
			$categoryId = $this->findCategoryId($category);
		}
		if($userId!='-1' || $userId!='')
		{
			$relationData = $this->check_user_institute($userId);
		}
		else
		{
			$relationData = array();
		}
	   	$start=($pageNo-1)*$pageSize;
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		if($keyword!='')
		{
		 //$this->db->where("(project_master.projectName LIKE '%".$keyword."%')");
		 $this->db->where("(project_master.projectName LIKE '%".$keyword."%'|| project_master.basicInfo LIKE '%".$keyword."%'|| project_master.keyword LIKE '%".$keyword."%')");
		}
	    if(!empty($category) && isset($categoryId) && !empty($categoryId))
	    {
			 $this->db->where('project_master.categoryId',$categoryId[0]['id']);
	    }
        if($projectStatus!='')
		{
			if($projectStatus=='Completed'){
				$pstatus = 1;
			}
			else{
			   $pstatus = 0;
			}
			$this->db->where('project_master.projectStatus',$pstatus);
	   }
		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->where('users.instituteId',$instituteId);
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->group_by('project_master.id');
		if($featuredType=='Featured')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		elseif($featuredType=='Most Appreciated')
		{
		    $this->db->order_by('project_master.like_cnt','desc');
		    $this->db->where('project_master.like_cnt >',0);
		}
		elseif($featuredType=='Most Discussed')
		{
		    $this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($featuredType=='Most Viewed')
		{
			 $this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($featuredType=='Most Recent')
		{
		   $this->db->order_by('project_master.created','desc');
		}
		else
		{
			$this->db->order_by('project_master.created','desc');
		}
	  if(!empty($relationData)&&$instituteId!='')
		{
			if($relationData[0]['instituteId']==$instituteId)
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
			//$this->db->where('users.instituteId',$relationData[0]['instituteId']);
		}
		else
		{
			$this->db->where('project_master.status',1);
		}
	    $data = $this->db->get()->result_array();
		/*echo($this->db->last_query());die;*/
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
			{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(empty($data[$i]['rating']))
					{
						$data[$i]['rating']=0.0;
					}
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				    $data[$i]['userId'] = $userId;
			    $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['project']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
	 public function JoinInstitute($userId,$deviceId,$instituteId)
	{
		$new_array = array();
		$userData = $this->loggedInUserInfoById($userId);
		$instituteData =  $this->checkEmailExistInInstituteList($instituteId,$userData['email']);
	   if(!empty($instituteData))
		{
			$this->db->where('id',$userId);
			$this->db->update('users',array('instituteId'=>$instituteId));
		  	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	      	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='You are not part of this Institute';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
    public function AddInstituteFeedback($userId,$deviceId,$instituteId,$questionList,$likeJoinOurInstitute,$feedback,$instancdId)
    	{
  		$new_array = array();
  			$i=1;
    		$data=array('user_id'=>$userId,'institute_id'=>$instituteId);
    		foreach ($questionList as $question)
    		{
    			$data['q'.$i]=$question['selectedAnswer'];
    			$i++;
    		}
    		$data['q20']=$likeJoinOurInstitute;
    		$data['q21']=$feedback;
    		$data['instance_id']=$instancdId;
    	   	if(!empty($data))
    		{
    			$oldFeedbackExists=$this->db->select('id')->from('institutefeedback')->where('user_id',$userId)->where('instance_id',$instancdId)->where('institute_id',$instituteId)->get()->result_array();
    			if(empty($oldFeedbackExists))
    			{
    				$this->db->insert('institutefeedback',$data);
    				$res=$this->db->insert_id();
    			}
    			else
    			{
    				$this->db->where('user_id',$userId)->where('instance_id',$instancdId)->where('institute_id',$instituteId);
    				$res=$this->db->update('institutefeedback',$data);
    			}
    			if($res >= 1)
    			{
    				$instAdminData=$this->db->select('B.email,A.instituteName,B.firstName,B.lastName')->from('institute_master as A')->join('users as B','B.id=A.adminId')->where('A.id',$instituteId)->get()->result_array();
    				if(!empty($instAdminData))
    				{
    					$frontUserData=$this->db->select('*')->from('users')->where('id',$userId)->get()->result_array();
    					if(!empty($frontUserData))
    					{
    						$msg='Hello '.$instAdminData[0]['firstName'].' '.$instAdminData[0]['lastName'].',<br/><b>'.$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'].'</b> has submitted feedback about your institute <b>'.$instAdminData[0]['instituteName'].'</b>, following are the feedback.<br/><table cellspacing="5" cellpadding="5" border="1" style="border:1px solid #ddd;border-collapse:collapse;border-spacing:0;"><thead><tr><th>#</th><th>Question</th><th>Answer</th></tr></thead><tbody><tr><td>1</td><td>Did your class ever cancel due to absence of faculty?</td><td>'.$data['q1'].'</td></tr><tr><td>2</td><td>Were you issued courseware for the module(s) being taught?</td><td>'.$data['q2'].'</td></tr><tr><td>3</td><td>Do theory classes start and end at right time?</td><td>'.$data['q3'].'</td></tr><tr><td>4</td><td>Are the modules taken as per the timetable?</td><td>'.$data['q4'].'</td></tr><tr><td>5</td><td>Does the faculty teach concepts and clear doubts to your satisfaction?</td><td>'.$data['q5'].'</td></tr><tr><td>6</td><td>Does the theory class get conducted OHP or terminal?</td><td>'.$data['q6'].'</td></tr><tr><td>7</td><td>Your understanding of the topics covered?</td><td>'.$data['q7'].'</td></tr><tr><td>8</td><td>Is technical assistance always available in the lab?</td><td>'.$data['q8'].'</td></tr><tr><td>9</td><td>Are you assisted for the lab exercises given in the courseware?</td><td>'.$data['q9'].'</td></tr><tr><td>10</td><td>Were you able to workout lab exercises with facultys help in the lab?</td><td>'.$data['q10'].'</td></tr><tr><td>11</td><td>Do you always get a machine to work during the regular lab hours?</td><td>'.$data['q11'].'</td></tr><tr><td>12</td><td>Have you encountered a problem with respect to the software in the lab?</td><td>'.$data['q12'].'</td></tr><tr><td>13</td><td>Have you encountered a problem with respect to the machine in the lab?</td><td>'.$data['q13'].'</td></tr><tr><td>14</td><td>Does machine problems get sorted within a stipulated time?</td><td>'.$data['q14'].'</td></tr><tr><td>15</td><td>Are the assignments and examinations conducted as per the schedule?</td><td>'.$data['q15'].'</td></tr><tr><td>16</td><td>Are you evaluated after each module (test /assignment/ quiz)?</td><td>'.$data['q16'].'</td></tr><tr><td>17</td><td>Your satisfaction level with respect to faculty guidance on the project.</td><td>'.$data['q17'].'</td></tr><tr><td>18</td><td>Is the feedback taken from you at least once a month?</td><td>'.$data['q18'].'</td></tr><tr><td>19</td><td>Relevance and adequacy of examples used by the faculty while teaching.</td><td>'.$data['q19'].'</td></tr><tr><td>20</td><td>Would you like to tell anyone to join our institute?</td><td>'.$data['q20'].'</td></tr><tr><td>21</td><td>Please use the following space to provide any other feedback about the course/ center etc.</td><td>'.$data['q21'].'</td></tr></tbody></table>';
    							$fromName=$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'];
    							$sendFeedbackEmail=array('to'=>$instAdminData[0]['email'],'subject'=>'Feedback about institute','template' =>$msg,'fromEmail'=>$frontUserData[0]['email'],'fromName'=>$fromName);
    							$this->load->model('model_basic');
    							$this->model_basic->sendMail($sendFeedbackEmail);
						 	$new_array['statusCode']=200;
							$new_array['errorMessage']='';
							$new_array['statusMessage']='Done';
							return $new_array;
    					}
    					else
    					{
				      	$new_array['statusCode']=404;
					 	$new_array['errorMessage']='No user found with this user id';
					 	$new_array['statusMessage']='';
					 	return $new_array;
    					}
    				}
    				else
    				{
			      	$new_array['statusCode']=404;
				 	$new_array['errorMessage']='You are not a part of this institute';
				 	$new_array['statusMessage']='';
				 	return $new_array;
    				}
    			}
    		}
      }
    	public function checkEmailExistInInstituteList($id,$email)
	{
		$this->db->select('institute_csv_users.instituteId,institute_csv_users.email,institute_master.pageName');
		$this->db->from('institute_csv_users');
		$this->db->where('institute_csv_users.email',$email);
		$this->db->where('institute_master.id',$id);
		$this->db->join('institute_master', 'institute_csv_users.instituteId = institute_master.id');
		return $this->db->get()->result_array();
    }
     /////////////////////////////////////////////////////////-- Institute end -- ////////////////////////////////////////////////////////////
      /////////////////////////////////////////////////////////-- Competition -- ////////////////////////////////////////////////////////////
    public function GetCompetitionList($pageNo,$pageSize,$userId,$deviceId,$keyword)
	{
		$start=($pageNo-1)*$pageSize;
	    $this->db->select('name as competitionName,id as competitionId,instituteId,banner as bannerImageUrl,profile_image as profileImageUrl,description,award,jury,eligibility,rule,start_date as startDate,end_date as endDate,open_for_all as openForAll');
		$this->db->from('competitions');
		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    $data=$this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 	$this->db->select('instituteName');
					$this->db->from('institute_master');
					$this->db->where('id',$row['instituteId']);
				 	$institute = $this->db->get()->result_array();
				     if(!empty($institute))
					   {
						  $data[$i]['instituteName'] = $institute[0]['instituteName'];
					   }
					   else
					   {
						  $data[$i]['instituteName'] = '';
					   }
					if(file_exists(file_upload_s3_path().'competition/banner/'.$row['bannerImageUrl']) && filesize(file_upload_s3_path().'competition/banner/'.$row['bannerImageUrl']) > 0)
					{
					  	$data[$i]['bannerImageUrl'] = file_upload_base_url().'competition/banner/'.$row['bannerImageUrl'];
					}
					else
					{
						//$data[$i]['bannerImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['bannerImageUrl'] = '';
					}
					if(file_exists(file_upload_s3_path().'competition/profile_image/thumbs/'.$row['profileImageUrl']) && filesize(file_upload_s3_path().'competition/profile_image/thumbs/'.$row['profileImageUrl']) > 0)
					{
					  	$data[$i]['profileImageUrl'] = file_upload_base_url().'competition/profile_image/thumbs/'.$row['profileImageUrl'];
					}
					else
					{
						//$data[$i]['profileImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['profileImageUrl'] = "";
					}
	                $userCount = $this->getUserCount($row['competitionId']);
	     			$projectCount = $this->getProjectCount($row['competitionId']);
	     			$commentCount = $this->getCommentCount($row['competitionId']);
	     			$likeCount = $this->getLikeCount($row['competitionId']);
	     			if(!empty($userCount)){ $data[$i]['userCount'] = $userCount;} else {$data[$i]['userCount'] = 0;}
	     			if(!empty($projectCount)){ $data[$i]['projectCount'] = $projectCount;} else {$data[$i]['projectCount'] = 0;}
	     			if(!empty($likeCount)){ $data[$i]['likeCount'] = $likeCount;} else {$data[$i]['likeCount'] = 0;}
	     			if(!empty($commentCount)){ $data[$i]['commentCount'] = $commentCount;} else {$data[$i]['commentCount'] = 0;}
					$data[$i]['userId'] = $userId;
					$data[$i]['rating'] = 0;
		      $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['competition']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['competition']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
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
      	return $this->db->select('A.id')->from('project_master as A')->join('user_project_comment as B','A.id=B.projectId')->where('A.competitionId',$competitionId)->count_all_results();
      }
      public function getLikeCount($competitionId)
      {
      	return $this->db->select('A.id')->from('project_master as A')->join('user_project_views as B','A.id=B.projectId')->where('A.competitionId',$competitionId)->where('B.userLike',1)->count_all_results();
      }
    public function markCompletedCompetions()
	{
		$this->db->select('*');
		$this->db->from('competitions');
		$this->db->where('status',1);
	    $det = $this->db->get()->result_array();
	    foreach($det as $val)
		{
		  if(date("Y-m-d H:i:s") > date("Y-m-d 23:59:59",strtotime($val['end_date'])))
			{
				$this->db->where('id',$val['id']);
				$this->db->update('competitions',array('status'=>2));
			}
		}
    }
	public function GetCompetitionDetail($userId,$deviceId,$competitionId,$shareUrl)
	{
		if($shareUrl!='')
		{
			$competitionId=$this->model_basic->getValueArray('competitions','id',array('name'=>$shareUrl));
		}
		$this->db->select('id as competitionId,evaluation_start_date as evaluationStartDate,evaluation_end_date as evaluationEndDate,instituteId,winnerCount,name as competitionName,description,award,eligibility,rule,start_date as startDate,end_date as endDate,open_for_all as openForAll,profile_image as profileImageUrl,banner as bannerImageUrl,contactEmail,status,pageName as shareUrl');
		$this->db->from('competitions');
		$this->db->where('id',$competitionId);
		$data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ 
			$i=0;
			foreach($data as $row)
			{
			 	$this->db->select('instituteName');
				$this->db->from('institute_master');
				$this->db->where('id',$row['instituteId']);
			 	$institute = $this->db->get()->result_array();
				if(!empty($institute))
				{
				  	$data[$i]['instituteName'] = $institute[0]['instituteName'];
				}
				else
				{
				  	$data[$i]['instituteName'] = '';
				}
				if(file_exists(file_upload_s3_path().'competition/banner/'.$row['bannerImageUrl']) && filesize(file_upload_s3_path().'competition/banner/'.$row['bannerImageUrl']) > 0)
				{
				  	$data[$i]['bannerImageUrl'] = file_upload_base_url().'competition/banner/'.$row['bannerImageUrl'];
				}
				else
				{
					$data[$i]['bannerImageUrl'] = '';
				}
				if(file_exists(file_upload_s3_path().'competition/profile_image/thumbs/'.$row['profileImageUrl']) && filesize(file_upload_s3_path().'competition/profile_image/thumbs/'.$row['profileImageUrl']) > 0)
				{
				  	$data[$i]['profileImageUrl'] = file_upload_base_url().'competition/profile_image/thumbs/'.$row['profileImageUrl'];
				}
				else
				{
					$data[$i]['profileImageUrl'] = "";
				}
                $userCount = $this->getUserCount($row['competitionId']);
     			$projectCount = $this->getProjectCount($row['competitionId']);
     			$commentCount = $this->getCommentCount($row['competitionId']);
     			$likeCount = $this->getLikeCount($row['competitionId']);
     			if(!empty($userCount)){ $data[$i]['userCount'] = $userCount;} else {$data[$i]['userCount'] = 0;}
     			if(!empty($projectCount)){ $data[$i]['userCount'] = $projectCount;} else {$data[$i]['userCount'] = 0;}
     			if(!empty($likeCount)){ $data[$i]['likeCount'] = $likeCount;} else {$data[$i]['likeCount'] = 0;}
     			if(!empty($commentCount)){ $data[$i]['commentCount'] = $commentCount;} else {$data[$i]['commentCount'] = 0;}
     			$data[$i]['projectCount'] = 0;
				$data[$i]['userId'] = $userId;
				$data[$i]['rating'] = 0;
		      	$i++;
			}
			$new_array = $data[0];
			$new_array['project'] =$this->GetCompetitionProject($competitionId,$userId);
			$new_array['winningProjects'] =$this->getAllWinningProjects($competitionId,$userId);
			$juries =$this->getAllJuries($competitionId);
			if(!empty($juries))
			{
			 	$k=0;
		 	    foreach($juries as $vl)
		    	{
					if(file_exists(file_upload_s3_path().'competition/juryPhoto/thumbs/'.$vl['photo']) && filesize(file_upload_s3_path().'competition/juryPhoto/thumbs/'.$vl['photo']) > 0 && $vl['photo']!='')
					{
					  	$juries[$k]['personImageUrl'] = file_upload_base_url().'competition/juryPhoto/thumbs/'.$vl['photo'];
					}
					else
					{
						$juries[$k]['personImageUrl'] = "";
					}
					$k++;
				}
				$new_array['juries'] = $juries;
			}
			else
			{
				$new_array['juries'] = array();
			}
			$isJury = $this->getValue('competition_jury_relation','juryId'," `competitionId` = '".$competitionId."' AND   `userId` = '".$userId."'");
			//$isAlreadyJoin = $this->db->select('competitionId')->from('user_competition_relation')->where(array('competitionId'=>$competitionId,'userId'=>$userId))->get()->row_array();
			$isAlreadyJoin=$this->model_basic->getValueArray('user_competition_relation','competitionId',array('competitionId'=>$competitionId,'userId'=>$userId));
			if($isAlreadyJoin > 0)
			{
					$new_array['isAlreadyJoin'] = 1;
			}
			else
			{
					$new_array['isAlreadyJoin'] = 0;
			}
			$isProjectAdded=$this->model_basic->getValueArray('project_master','id',array('competitionId'=>$competitionId,'userId'=>$userId));
			if($isProjectAdded !='' || $isProjectAdded > 0)
			{
				$new_array['isProjectAdded']=1;
			}
			else
			{
				$new_array['isProjectAdded']=0;
			}
			//print_r($data[0]);die;
			if($isJury==FALSE)
			{
				$new_array['isJury'] = 0;
				$instituteId = $this->model_basic->getValueArray('users','instituteId',array('id'=>$userId));
				if(($data[0]['status']==1) && (($data[0]['openForAll']==1) || ($data[0]['instituteId']==$instituteId)))
				{
					$new_array['isAbleToJoin'] = 1;
				}
				else
				{
			  		$new_array['isAbleToJoin'] = 0;
			  	}
			}
			else
			{
				$new_array['isJury'] = 1;
				$new_array['isAbleToJoin'] = 0;
			}
			$this->makeCompetitionReadEntry($data[0]['instituteId'],$userId);
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
	    else
	    {
	     	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
	    }
	   	return $new_array;
    }
    public function makeCompetitionReadEntry($instituteId,$userId)
	{
		$event = $this->getAllCompetition($instituteId);
		if(!empty($event)){
			foreach($event as $row){
				$reln = $this->check_competition_notification_relation($row['competitionId'],$userId);
				if(empty($reln)){
					$data = array('competitionId'=>$row['competitionId'],'userId'=>$userId,'read' =>1,'created' =>date("Y-m-d H:i:s"));
					$this->db->insert('competition_user_notification',$data);
				}
			}
		}
		return;
	}
	public function GetCompetitionProject($competitionId,$userId)
	{
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,users.city,project_master.status as project_normal_status,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.status',1);
		$this->db->where('project_master.competitionId',$competitionId);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->group_by('project_master.id');
		$this->db->order_by('project_master.created','desc');
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
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
			{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(empty($data[$i]['rating']))
					{
						$data[$i]['rating']=0.0;
					}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						//$data[$i]['profileImage'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				    $data[$i]['userId'] = $userId;
			    $i++;
			 }
		}
	    return $data;
	}
	public function getAllWinningProjects($competitionId,$userId)
	{
		//$noOfWinners=$this->model_basic->getValue('competitions','userId'," `competitionId` = '".$competitionId."' AND  `juryId` = '".$juryId."'");
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,users.city,project_master.status as project_normal_status,project_master.created,users.country,A.rank');
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
			{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(empty($data[$i]['rating']))
					{
						$data[$i]['rating']=0.0;
					}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						//$data[$i]['profileImage'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				    $data[$i]['userId'] = $userId;
			    $i++;
			 }
		}
		return $data;
	}
    public function getAllJuries($competitionId)
	{
		$this->db->select('B.id,B.name,B.photo,B.email,B.writeup as JuryWriteUp');
		$this->db->from('competition_jury_relation as A')->join('competition_jury as B','A.juryId=B.id');
		$this->db->where('A.competitionId',$competitionId);
		return $this->db->get()->result_array();
	}
	public function JoinCompetition($userId,$deviceId,$competitionId,$projectId)
	{
		//$isAlreadySubmitted = $this->getValue('project_master','id'," `competitionId` = '".$competitionId."' AND   `userId` = '".$userId."'");
		//$isAlreadySubmitted = $this->db->select('id')->from('project_master')->where(array('competitionId'=>$competitionId,'userId'=>$userId))->get()->row_array();
		$isAlreadyJoined = $this->getValue('user_competition_relation','userId'," `competitionId` = '".$competitionId."' AND   `userId` = '".$userId."'");
		if($isAlreadyJoined =='')
		{
			$this->db->insert('user_competition_relation',array('competitionId'=>$competitionId,'userId'=>$userId));
		}
		/*if($isAlreadySubmitted['id'] > 0)
		{
			$this->db->where('id',$isAlreadySubmitted['id']);
			$this->db->where('userId',$userId);
			$res = $this->db->update('project_master',array('competitionId'=>0));
		}*/
		$this->db->where('id',$projectId);
		$this->db->where('userId',$userId);
		$res = $this->db->update('project_master',array('competitionId'=>$competitionId));
	    $new_array = array();
		if(!empty($res))
		{
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
	    else
	    {
	     	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
	    }
	   return $new_array;
    }
    /////////////////////////////////////////////////////////-- Competition -- ////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////--event--////////////////////////////////////////////////////////////////////////
    public function markExpiredEvents()
	{
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('status',1);
	    $det = $this->db->get()->result_array();
	    foreach($det as $val)
		{
		  if(date("Y-m-d H:i:s") > date("Y-m-d 23:59:59",strtotime($val['end_date'])))
			{
				$this->db->where('id',$val['id']);
				$this->db->update('events',array('status'=>2));
			}
		}
    }
	public function GetEventList($pageNo,$pageSize,$userId,$deviceId,$keyword)
	{
		$this->markExpiredEvents();
		$start=($pageNo-1)*$pageSize;
	    $this->db->select('name as eventName,id as eventId,instituteId,banner as bannerImageUrl,description,coupon_code as couponCode,start_date as startDate,end_date as endDate');
		$this->db->from('events');
		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    $data=$this->db->get()->result_array();
	   $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 	$this->db->select('instituteName');
					$this->db->from('institute_master');
					$this->db->where('id',$row['instituteId']);
				 	$institute = $this->db->get()->result_array();
				     if(!empty($institute))
					   {
						  $data[$i]['instituteName'] = $institute[0]['instituteName'];
					   }
					   else
					   {
						  $data[$i]['instituteName'] = '';
					   }
					if(file_exists(file_upload_s3_path().'event/banner/'.$row['bannerImageUrl']) && filesize(file_upload_s3_path().'event/banner/'.$row['bannerImageUrl']) > 0)
					{
					  	$data[$i]['bannerImageUrl'] = file_upload_base_url().'event/banner/'.$row['bannerImageUrl'];
					}
					else
					{
						//$data[$i]['bannerImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['bannerImageUrl'] = "";
					}
				    $data[$i]['userId'] = $userId;
		      $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['event']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['event']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
	  public function GetEventDetail($userId,$deviceId,$eventId)
	{
		//$this->markExpiredEvents();
	    $this->db->select('name as eventName,id as eventId,instituteId,banner as bannerImageUrl,description,coupon_code as couponCode,start_date as startDate,end_date as endDate');
		$this->db->from('events');
		$this->db->where('id',$eventId);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    $data=$this->db->get()->result_array();
	   $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 	$this->db->select('instituteName');
					$this->db->from('institute_master');
					$this->db->where('id',$row['instituteId']);
				 	$institute = $this->db->get()->result_array();
				     if(!empty($institute))
					   {
						  $data[$i]['instituteName'] = $institute[0]['instituteName'];
					   }
					   else
					   {
						  $data[$i]['instituteName'] = '';
					   }
					if(file_exists(file_upload_s3_path().'event/banner/'.$row['bannerImageUrl']) && filesize(file_upload_s3_path().'event/banner/'.$row['bannerImageUrl']) > 0)
					{
					  	$data[$i]['bannerImageUrl'] = file_upload_base_url().'event/banner/'.$row['bannerImageUrl'];
					}
					else
					{
						//$data[$i]['bannerImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
						$data[$i]['bannerImageUrl'] = "";
					}
				    $data[$i]['userId'] = $userId;
		      $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array = $data[0];
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array = array();
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
	    }
	    return $new_array;
    }
  /////////////////////////////////////////////////////////--event End--////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////----Job----- ////////////////////////////////////////////////////
	public function GetJobList($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType)
	{
		if($instituteId && $instituteId != '')
		{
			$regionId=$this->db->select('region')->from('institute_master')->where('id',$instituteId)->get()->row_array();
		}
		else
		{
			$regionId='';
		}
		if($jobType==1)
		{
			$data=$this->getLimitedJob($userId,$instituteId);
		}
		else
		{
			$data=$this->getUserJobs($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType,$regionId);
		}
		
		/*$idarray = array();
		if(!empty($data))
		{			
			foreach ($data as $key => $value) 
			{
				$idarray[] = $value['jobId'];        		
			}  
		}
		else 
		{
		  	$idarray[] = 0; 
		}
		if($jobType==1)
		{
			$dataOther=$this->getLimitedJob($userId,$instituteId);
		}
		else
		{
			$dataOther = $this->getUserJobs($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType,$regionId,$idarray);
		}*/
		$firstArray = array();
		if(!empty($data))
		{
			$firstArray = $data;
		}
		$secondArray = array();
		/*if(!empty($dataOther))
		{
			$secondArray = $dataOther;
		}*/
		$merged_arr = array_merge_recursive($firstArray,$secondArray );
		$merged_arr = array_map("unserialize", array_unique(array_map("serialize", $merged_arr)));
	    $new_array = array();
		if(!empty($merged_arr))
		{ 
			$i=0;
			foreach($merged_arr as $row)
			{
				$merged_arr[$i]['postedDate'] = date('Y-m-d',strtotime($row['created']));
				$merged_arr[$i]['description'] = strip_tags($row['description']);
				if(file_exists(file_upload_s3_path().'companyLogos/'.$row['companyLogoUrl']) && filesize(file_upload_s3_path().'companyLogos/'.$row['companyLogoUrl']) > 0)
				{
				  	$merged_arr[$i]['companyLogoUrl'] = file_upload_base_url().'companyLogos/'.$row['companyLogoUrl'];
				}
				else
				{
					$merged_arr[$i]['companyLogoUrl'] = "";
				}
			    $merged_arr[$i]['userId'] = $userId;
				$applicant = $this->checkAppliedOrNot($row['jobId'],$userId);
			    if(!empty($applicant))
				{
					$merged_arr[$i]['isApplied']=1;
				}
				else
				{
					$merged_arr[$i]['isApplied']=0;
				}
				$merged_arr[$i]['jobType']= $jobType;
		      	$i++;
			}
		}
		if($jobType==1)
	    {
			$new_array['job']=$merged_arr;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
	   elseif(!empty($merged_arr))
		{
		 	$new_array['job']=$merged_arr;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
        else
	    {
	     	$new_array['job']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
    public function getLimitedJob($userId,$instituteId)
    {	
        if($instituteId !='') 
        {
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
        	$where='';
	        if(!empty($skills))
	        {	    	
	        	$i=0;
	        	foreach($skills as $row)
	        	{
	        		if($i==0)
	        		{
	    				$where .="((jobs.keySkills LIKE '%".$row['skillName']."%' || jobs.description LIKE '%".$row['skillName']."%'|| jobs.title LIKE '%".$row['skillName']."%')";
	    			}
	    			else{
	    				$where .=" || (jobs.keySkills LIKE '%".$row['skillName']."%' || jobs.description LIKE '%".$row['skillName']."%'|| jobs.title LIKE '%".$row['skillName']."%')";
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
	    	else
	    	{
	    		if($totalDays!='' && $totalDays>0)
	    	    {
	    			$where ="jobs.min_experience <= '".$totalDays."' and jobs.max_experience >= '".$totalDays."' ";
	    		}
	    	}
	    	$insti_id = $instituteId;
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
	    		foreach ($appaliedJob as $key => $value) {
	    			$whereAppaliedJob .="`jobs`.`id` != '".$value['jobId']."'";
	    			if(($i) > ($key+1))
	    			{
	    				$whereAppaliedJob .= " AND ";					
	    			}				
	    		}
	    	}
	    	if($where!='')
	        {
	        	$this->db->select('jobs.title,jobs.companyName,jobs.id as jobId,jobs.description,jobs.location,jobs.companyLogo as companyLogoUrl,jobs.type,jobs.close_on as closeOnDate,jobs.created,jobs.min_experience,jobs.max_experience');
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
	        }
	        else
	        {
	    		return array();
	    	}
    	}
        else
        {
    		return array();
    	}
    }
    public function getUserJobs($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType,$regionId='',$idarray='')
	{
		$start=($pageNo-1)*$pageSize; 
		$this->db->select('A.title,A.companyName,A.id as jobId,A.description,A.location,A.companyLogo as companyLogoUrl,A.type,A.close_on as closeOnDate,A.created,A.min_experience,A.max_experience');
		$this->db->from('jobs as A');
		$this->db->join('job_zone_relation as B','B.job_id=A.id','LEFT');
		$this->db->where('A.status',1);
		if(isset($regionId) && !empty($regionId))
		{
			$this->db->where('B.region_id',$regionId['region']);
		}
		$this->db->where('A.status',1);
		if($instituteId && $instituteId != '')
		{
			$query = "((A.admin_level=2 and A.posted_by=".$instituteId.") or (A.view_status=0))";
			$this->db->where($query);
		}
		else
		{
			$this->db->where('A.view_status',0);
		}
		if($idarray != '')
		{
			if(isset($idarray) && !empty($idarray))
			{
				$this->db->where_not_in('A.id', $idarray);
			}
		}
		$this->db->where('date_format(A.close_on,"%Y-%m-%d")>', 'CURDATE()', FALSE);

		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->group_by('B.job_id');
		$this->db->order_by('A.created','desc');    
		return $this->db->get()->result_array();
	}	
	 public function  AdvancedJobSearch($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType,$companyName,$jobTitle,$lcocationPlace,$activeJobType)
	{
		$where='';
		$start=($pageNo-1)*$pageSize;
		if($instituteId && $instituteId != '')
		{
			$regionId=$this->db->select('region')->from('institute_master')->where('id',$instituteId)->get()->row_array();
		}
		else
		{
			$regionId='';
		}
		$this->db->select('jobs.title,jobs.companyName,jobs.id as jobId,jobs.description,jobs.location,jobs.companyLogo as companyLogoUrl,jobs.type,jobs.close_on as closeOnDate,jobs.created,jobs.min_experience,jobs.max_experience');
		$this->db->from('jobs');
		$this->db->join('job_zone_relation','job_zone_relation.job_id=jobs.id','left');
		if(isset($regionId) && !empty($regionId))
		{
			$this->db->where('job_zone_relation.region_id',$regionId['region']);
		}
        $where .= 'jobs.status = 1';
        if($instituteId && $instituteId!='')
        {
        	$where .= " AND ((jobs.admin_level =2 and jobs.posted_by=".$instituteId.") or (jobs.view_status=0))";
 		}
 		else
 		{
 			$where .= ' AND jobs.view_status = 0';
 		}
 		if($jobType=='1')
 		{
 			$where .= " AND jobs.job_type = ".$jobType;
 		}
 		else
 		{
 			$where .= " AND jobs.job_type = ".$jobType;
 		}
 		if($lcocationPlace!='')
 		{
 			$where .= " AND (jobs.location like '%".$lcocationPlace."%')";
 		}
 		if($jobTitle!='')
 		{
 			$where .= " AND (jobs.title like '%".$jobTitle."%')";
 		}
 		if($companyName!='')
 		{
 			$where .= " AND (jobs.companyName like '%".$companyName."%')";
 		}
 		if($keyword!='')
 		{
 			$where .= " AND ((jobs.title like '%".$keyword."%') OR (jobs.description like '%".$keyword."%') OR (jobs.keySkills like '%".$keyword."%') OR (jobs.education like '%".$keyword."%') OR (jobs.industry like '%".$keyword."%') OR (jobs.function like '%".$keyword."%'))";
 		}
 		$this->db->where($where);
        if($activeJobType!='All Jobs')
 		{
			if($activeJobType=='Applied For')
			{
				$this->db->where('job_user_relation.apply_status',1);
			}
			if($activeJobType=='Shortlisted For')
			{
				$this->db->where('job_user_relation.apply_status',2);
			}
			if($activeJobType=='Selected For Interview')
			{
				$this->db->where('job_user_relation.apply_status',3);
			}
			if($activeJobType=='Accepted Job Offer')
			{
				$this->db->where('job_user_relation.apply_status',4);
			}
			if($activeJobType=='Rejected by Me')
			{
				$this->db->where('job_user_relation.apply_status',5);
			}
			if($activeJobType=='Rejected by Employer')
			{
				$this->db->where('job_user_relation.apply_status',6);
			}
			$this->db->where('job_user_relation.userId',$userId);
        	$this->db->join('job_user_relation', 'job_user_relation.jobId = jobs.id', 'left');
	    }
		$this->db->where('date_format(A.close_on,"%Y-%m-%d")>', 'CURDATE()', FALSE);	    
	    $this->db->group_by('jobs.id');
 		$this->db->limit($pageSize);
 		$this->db->offset($start);
 		$this->db->order_by('jobs.created','desc');
 		$data = $this->db->get()->result_array();
 		$new_array = array();
 		if(!empty($data))
 		{ 
 			$i=0;
 			foreach($data as $row)
 			{
 				$data[$i]['postedDate'] = date('Y-m-d',strtotime($row['created']));
 				$data[$i]['description'] = strip_tags($row['description']);
				if(file_exists(file_upload_s3_path().'companyLogos/'.$row['companyLogoUrl']) && filesize(file_upload_s3_path().'companyLogos/'.$row['companyLogoUrl']) > 0)
				{
				  	$data[$i]['companyLogoUrl'] = file_upload_base_url().'companyLogos/'.$row['companyLogoUrl'];
				}
				else
				{
					$data[$i]['companyLogoUrl'] = "";
				}
			    $data[$i]['userId'] = $userId;
				$applicant = $this->checkAppliedOrNot($row['jobId'],$userId);
			    if(!empty($applicant))
				{
					$data[$i]['isApplied']=1;
				}
				else
				{
					$data[$i]['isApplied']=0;
				}
 		      	$i++;
 			}
 		}
 	   	if(!empty($data))
 		{
 		 	$new_array['job']=$data;
 		 	$new_array['statusCode']=200;
 		 	$new_array['errorMessage']='';
 		 	$new_array['statusMessage']='Done';
 	    }
 	    else
 	    {
 	     	$new_array['job']=array();
 		 	$new_array['statusCode']=200;
 		 	$new_array['errorMessage']='';
 		 	$new_array['statusMessage']='Done';
 	    }
 	    return $new_array;
    }
    public function CheckSelectedForJob($userId)
    {
    	$data=$this->db->select('B.id as jobId,B.title as jobTitle,B.companyName')->from('job_user_relation as A')->join('jobs as B','B.id=A.jobId')->where('A.userId',$userId)->where('A.apply_status',3)->get()->row_array();
    	if(!empty($data))
    	{
		  	$data['statusCode']=200;
			$data['errorMessage']='';
			$data['statusMessage']='Done';
			return $data;
    	}
    	else
    	{
		  	$data1['statusCode']=404;
			$data1['errorMessage']='Data not found.';
			$data1['statusMessage']='';
			return $data1;
		}
	  	
    }
    public function SaveJobFeedback($userId,$jobId,$joinJob,$feedback)
    {
    	$res=$this->model_basic->_insert('job_feedback',array('jobId'=>$jobId,'userId'=>$userId,'feedback'=>$feedback));
    	if($joinJob==0)
    	{
    		$apply_status=5;
    	}
    	if($joinJob==1)
    	{
    		$apply_status=4;
    	}
    	$this->model_basic->_updateWhere('job_user_relation',array('userId'=>$userId,'jobId'=>$jobId),array('apply_status'=>$apply_status));
	  	$data['statusCode']=200;
		$data['errorMessage']='';
		$data['statusMessage']='Done';
		return $data;
    }
    public function GetJobDetail($userId,$deviceId,$jobId)
	{
		$this->db->select('*');
		$this->db->from('jobs');
        $this->db->where('id',$jobId);
        $job_detail = $this->db->get()->result_array();
	    $data = array();
		if(!empty($job_detail))
		{ $i=0;
			 foreach($job_detail as $row)
			 {
			  		$data['jobId'] = $row['id'];
			 		$data['companyName'] = $row['companyName'];
			 		$data['aboutCompany'] = $row['aboutCompany'];
			 		$data['description'] = $row['description'];
			 		$data['education'] = $row['education'];
			 		$data['keySkills'] = $row['keySkills'];
			 		if($row['min_experience']==0&&$row['max_experience']==0)
			 		{
						$data['experience'] = '0 Years';
					}
					else
					{
						$data['experience'] = $row['min_experience'].'-'.$row['max_experience'].' Years';
					}
			 		$data['function'] = $row['function'];
			 		$data['industry'] = $row['industry'];
			 		$data['location'] = $row['location'];
			 		$data['roleType'] = $row['type'];
			 		$data['title'] = $row['title'];
			 		$data['closeOnDate'] = $row['close_on'];
			 		$data['postedOnDate'] = date('Y-m-d',strtotime($row['created']));
					if(file_exists(file_upload_s3_path().'companyLogos/'.$row['companyLogo']) && filesize(file_upload_s3_path().'companyLogos/'.$row['companyLogo']) > 0)
					{
					  	$data['companyLogo'] = file_upload_base_url().'companyLogos/'.$row['companyLogo'];
					}
					else
					{
						$data['companyLogo'] = "";
					}
				    $applicant = $this->checkAppliedOrNot($jobId,$userId);
				    if(!empty($applicant))
					{
						$data['isApplied']=1;
					}
					else
					{
						$data['isApplied']=0;
					}
		   			 $reln = $this->check_job_notification_relation($jobId,$userId);
					if(empty($reln))
					{
						$arr1 = array('jobId'  =>$jobId,'userId' =>$userId,'read'   =>1,'created'=>date("Y-m-d H:i:s"));
						$this->db->insert('job_user_notification',$arr1);
					}
			 }
			   $data['statusCode']=200;
		 	   $data['errorMessage']='';
		 	   $data['statusMessage']='Done';
		}
        else
	    {
	     	$data['job']=array();
		 	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
	    }
	    return $data;
    }
    public function checkAppliedOrNot($jobId,$userId)
	{
		 $this->db->select('userId');
		 $this->db->from('job_user_relation_admin_approval');
	     $this->db->where('jobId',$jobId);
	     $this->db->where('userId',$userId);
	     return $this->db->get()->row();
	}
        public function ApplyJob($userId,$deviceId,$jobId,$instituteId)
    	{
    			/*$data['user_profile']=$this->getUserProfileData($userId);*/
    		    /*$Emaildata = array();
    		    $new_array = array();
    			if(!empty($data['user_profile']))
    			{
    				*//*$data['liked_project']=$this->getUserMostLikedThreeProject($userId);
    				$data['view_like_cnt']=$this->getViewLikeCnt($userId);
    				$data['followers']=$this->getFollowers($userId);
    				$data['following']=$this->getFollowing($userId);
    				$data['educationData']=$this->getUserHighestEducationData($userId);
    				$data['workData']=$this->getUserWorkData($userId);
    			    $data['overAllRating'] = $this->overAllProjectRating($userId);*/
    				/*$Emaildata['fromEmail']='contact@creonow.com';
    				$Emaildata['to'] = $data['user_profile']->email;
    				$Emaildata['subject']='Welcome To creonow';
    				$Emaildata['template']=$this->load->view('emailTemplates/job_apply_app_email_view',$data,true);*/
    				/*$Emaildataview = $this->load->view('emailTemplates/job_apply_app_email_view',$data,true);*/

    				$arr=array('userId'=>$userId,'jobId'=>$jobId,'resume'=>'','apply_date'=>date('Y-m-d H:i:s'),'institute_id'=>$instituteId);    		
					//$arr=array('userId'=>$userId,'jobId'=>$jobId,'resume'=>'');
    	    	    //$res=$this->model_basic->_insert('job_user_relation',$arr);
    	    	    $res=$this->model_basic->_insert('job_user_relation_admin_approval',$arr);
    				$jobDetails=$this->get_where('jobs',array('id'=>$jobId));
    				$jobName=$jobDetails['title'];
    				$userDetails=$this->loggedInUserInfoById($userId);

    				$RecruiterEmailId = $this->db->select('recruiter_email_id')->from('jobs')->where('id',$jobId)->get()->row_array();
    				$templateRecruter='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job <b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$userId.'">Click here</a> to see his portfolio.';

    				$dataRecruter=array('fromEmail'=>$userDetails['email'],'to'=>$RecruiterEmailId['recruiter_email_id'],'cc'=>'contact@creonow.com','subject'=>'Someone has applied for the job.','template'=>$templateRecruter);
    				$this->model_basic->sendMail($dataRecruter);
    				$getRegionIds=$this->db->select('region')->from('institute_master')->where('id',$instituteId)->get()->row_array();
    				if(!empty($getRegionIds))
    				{					
    					$jobApplicationEmail=$this->db->select('job_application_email_id')->from('region_list')->where('id',$getRegionIds['region'])->get()->row_array();
    					//print_r($jobApplicationEmail);
    					$jobApplicationEmaildata=array('fromEmail'=>$userDetails['email'],'to'=>$jobApplicationEmail['job_application_email_id'],'subject'=>'Someone has applied for the job.','template'=>$templateRecruter);
    					
    					$this->model_basic->sendMail($jobApplicationEmaildata);	
    				}

    				$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have successfully applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';

    				$dataApplicant=array('fromEmail'=>'contact@creonow.com','to'=>$userDetails['email'],'subject'=>'Successfully applied for job.','template'=>$templateForApplicant);

    				$this->model_basic->sendMail($dataApplicant);
    				
    				
    			     if($res)
    			     {
    				 	$new_array['statusCode']=200;
    				    $new_array['errorMessage']='';
    				    $new_array['statusMessage']='Done';
    				 }
    				 else
    				 {
    				 	$new_array['statusCode']=404;
    		 			$new_array['errorMessage']='error';
    		 			$new_array['statusMessage']='';
    				 }
    			/*}
    			else
    			{
    				$new_array['statusCode']=404;
    		 		$new_array['errorMessage']='error';
    		 		$new_array['statusMessage']='';
    			}*/
    		  return $new_array;
        }
   /* public function addJobRelation($data)
	{
	   return $this->db->insert('job_user_relation',$data);
	}*/
    public function getUserProfileData($uid)
	{
	   return $this->db->select('*')->from('users')->where('id',$uid)->get()->row();
	}
	public function getUserHighestEducationData($uid)
	{
	   return $this->db->select('*')->from('users_education')->where('user_id',$uid)->order_by('endFrom','desc')->get()->result_array();
	}
    public function getUserWorkData($uid)
	{
	   return  $this->db->select('*')->from('users_work')->where('user_id',$uid)->where('status','1')->get()->result_array();
    }
    public function get_where($table,$condition)
	{
		return $this->db->select('*')->from($table)->where($condition)->get()->row_array();
	}
    public function overAllProjectRating($uid)
	{
		$this->db->select('AVG(project_rating.rating) as avg,project_master.id');
		$this->db->from('users');
		$this->db->where('users.id',$uid);
	    $this->db->join('project_master', 'project_master.userId = users.id');
		$this->db->join('project_rating', 'project_rating.projectId = project_master.id');
	 	return $this->db->get()->result_array();
	}
	public function getUserMostLikedThreeProject($user_id)
	{
		$this->db->select('project_master.id,project_master.projectName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,users.profession,users.city,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$where = "(( project_master.status=1))";
	    $this->db->where($where);
		$this->db->limit(3);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
	    return $this->db->get()->result_array();
    }
///////////////////////////////////////////////////////////----Job----- ////////////////////////////////////////////////////
///////////////////////////////////////////////////////////----user----- ////////////////////////////////////////////////////
	public function GetBaseServerUrl($googleId,$emailId,$firstName,$lastName,$profileImageUrl,$gender,$deviceId,$studentId,$userType)
    {
    	if($studentId != '')
    	{
    		$userDataInCsv=$this->db->select('id,centerId,email,instituteId')->from('institute_csv_users')->where('studentId',$studentId)->get()->result_array();
    		if(!empty($userDataInCsv))
    		{
    			if($userDataInCsv[0]['centerId']==1)
    			{
    				if($userDataInCsv[0]['email'] !='' && $userDataInCsv[0]['email'] == $emailId)
    				{
					 	$data = array();
						$data['statusCode']=200;
					 	$data['errorMessage']='';
					 	$data['statusMessage']='Done';
					 	//$data['baseServerUrl']=base_url()."api/";
					 	$data['baseServerUrl']="https://www.creosouls.com/api/";
					 	return $data;
    				}
    				if($userDataInCsv[0]['email'] !='' && $userDataInCsv[0]['email'] != $emailId)
    				{
			    		$userData=$this->db->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
			    		if(!empty($userData))
			    		{
			    			if($userData[0]['instituteId']==0)
			    			{
							 	$data = array();
								$data['statusCode']=200;
							 	$data['errorMessage']='';
							 	$data['statusMessage']='Done';
							 	$data['baseServerUrl']='';
							 	return $data;
			    			}
			    			elseif($userData[0]['instituteId'] > 0)
			    			{
							 	$data = array();
								$data['statusCode']=200;
							 	$data['errorMessage']='';
							 	$data['statusMessage']='Done';
							 	//$data['baseServerUrl']=base_url()."api/";
							 	$data['baseServerUrl']="https://www.creosouls.com/api/";
							 	return $data;
			    			}
			    		}
			    		else
			    		{
			    			$maac = $this->load->database('maac_db', TRUE);
			    			$userData=$maac->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
			    			if(!empty($userData))
			    			{
				    			if($userData[0]['instituteId'] > 0)
				    			{
								 	$data = array();
									$data['statusCode']=200;
								 	$data['errorMessage']='';
								 	$data['statusMessage']='Done';
								 	//$data['baseServerUrl']=base_url()."maac/api/";
								 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
								 	return $data;
				    			}
				    		}
				    		else
				    		{
				    			$udata=array('firstName'=>$firstName,'lastName'=>$lastName,'email'=>$emailId,'identifier'=>$googleId,'profileImage'=>$profileImageUrl,'status'=>1,'disk_space'=>1024,'type'=>$userType,'created'=>date('Y-m-d H:i:s'));
				    			$this->db->insert('users',$udata);
				    			$maac->insert('users',$udata);
			    			 	$data = array();
			    				$data['statusCode']=200;
			    			 	$data['errorMessage']='';
			    			 	$data['statusMessage']='Done';
			    			 	$data['baseServerUrl']='';
			    			 	return $data;
				    		}
			    		}
    				}
    				if($userDataInCsv[0]['email'] =='')
    				{
    					$userDataU=$this->db->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
    					if(!empty($userDataU) && $userDataU[0]['instituteId'] != 0)
    					{
						 	$data = array();
							$data['statusCode']=200;
						 	$data['errorMessage']='';
						 	$data['statusMessage']='Done';
						 	//$data['baseServerUrl']=base_url()."api/";
						 	$data['baseServerUrl']="https://www.creosouls.com/api/";
						 	return $data;
    					}
    					if(!empty($userDataU) && $userDataU[0]['instituteId'] == 0)
    					{
    						$userTableData=array('instituteId'=>$userDataInCsv[0]['instituteId']);
    						$this->db->where('email',$emailId);
    						$this->db->update('users',$userTableData);
    						$csvTableData=array('email'=>$emailId);
    						$this->db->where('id',$userDataInCsv[0]['id']);
    						$this->db->update('institute_csv_users',$csvTableData);
    						$maac = $this->load->database('maac_db', TRUE);
    						$maac->where('email',$emailId);
    						$maac->delete('users');
						 	$data = array();
							$data['statusCode']=200;
						 	$data['errorMessage']='';
						 	$data['statusMessage']='Done';
						 	//$data['baseServerUrl']=base_url()."api/";
						 	$data['baseServerUrl']="https://www.creosouls.com/api/";
						 	return $data;
    					}
    				}
    			}
    			if($userDataInCsv[0]['centerId']==2)
    			{
    				$maac = $this->load->database('maac_db', TRUE);
    				$userDataInCsvM=$maac->select('id,centerId,email')->from('institute_csv_users')->where('studentId',$studentId)->get()->result_array();
    				if($userDataInCsvM[0]['email'] !='' && $userDataInCsvM[0]['email'] == $emailId)
    				{
					 	$data = array();
						$data['statusCode']=200;
					 	$data['errorMessage']='';
					 	$data['statusMessage']='Done';
					 	//$data['baseServerUrl']=base_url()."api/";
					 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
					 	return $data;
    				}
    				if($userDataInCsvM[0]['email'] !='' && $userDataInCsvM[0]['email'] != $emailId)
    				{
			    		$userData=$this->db->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
			    		if(!empty($userData))
			    		{
			    			if($userData[0]['instituteId']==0)
			    			{
							 	$data = array();
								$data['statusCode']=200;
							 	$data['errorMessage']='';
							 	$data['statusMessage']='Done';
							 	$data['baseServerUrl']='';
							 	return $data;
			    			}
			    			elseif($userData[0]['instituteId'] > 0)
			    			{
							 	$data = array();
								$data['statusCode']=200;
							 	$data['errorMessage']='';
							 	$data['statusMessage']='Done';
							 	//$data['baseServerUrl']=base_url()."api/";
							 	$data['baseServerUrl']="https://www.creosouls.com/api/";
							 	return $data;
			    			}
			    		}
			    		else
			    		{
			    			$maac = $this->load->database('maac_db', TRUE);
			    			$userData=$maac->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
			    			if(!empty($userData))
			    			{
				    			if($userData[0]['instituteId'] > 0)
				    			{
								 	$data = array();
									$data['statusCode']=200;
								 	$data['errorMessage']='';
								 	$data['statusMessage']='Done';
								 	//$data['baseServerUrl']=base_url()."maac/api/";
								 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
								 	return $data;
				    			}
				    		}
				    		else
				    		{
				    			$udata=array('firstName'=>$firstName,'lastName'=>$lastName,'email'=>$emailId,'identifier'=>$googleId,'profileImage'=>$profileImageUrl,'status'=>1,'disk_space'=>1024,'type'=>$userType,'created'=>date('Y-m-d H:i:s'));
				    			$this->db->insert('users',$udata);
				    			$maac->insert('users',$udata);
			    			 	$data = array();
			    				$data['statusCode']=200;
			    			 	$data['errorMessage']='';
			    			 	$data['statusMessage']='Done';
			    			 	$data['baseServerUrl']='';
			    			 	return $data;
				    		}
			    		}
    				}
    				if($userDataInCsvM[0]['email'] =='')
    				{
    					$userDataUM=$maac->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
    					if(!empty($userDataUM) && $userDataUM[0]['instituteId'] != 0)
    					{
						 	$data = array();
							$data['statusCode']=200;
						 	$data['errorMessage']='';
						 	$data['statusMessage']='Done';
						 	//$data['baseServerUrl']=base_url()."api/";
						 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
						 	return $data;
    					}
    					if(!empty($userDataUM) && $userDataUM[0]['instituteId'] == 0)
    					{
    						$userTableDataM=array('instituteId'=>$userDataInCsv[0]['instituteId']);
    						$maac->where('email',$emailId);
    						$maac->update('users',$userTableDataM);
    						$csvTableDataM=array('email'=>$emailId);
    						$maac->where('studentId',$studentId);
    						$maac->update('institute_csv_users',$csvTableDataM);
    						$this->db->where('email',$emailId);
    						$this->db->delete('users');
						 	$data = array();
							$data['statusCode']=200;
						 	$data['errorMessage']='';
						 	$data['statusMessage']='Done';
						 	//$data['baseServerUrl']=base_url()."api/";
						 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
						 	return $data;
    					}
    				}
    			}
    		}
    	}
    	if($studentId =='' || empty($userDataInCsv))
    	{
    		$userData=$this->db->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
    		if(!empty($userData))
    		{
    			if($userData[0]['instituteId']==0)
    			{
				 	$data = array();
					$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
				 	$data['baseServerUrl']='';
				 	return $data;
    			}
    			elseif($userData[0]['instituteId'] > 0)
    			{
				 	$data = array();
					$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
				 	//$data['baseServerUrl']=base_url()."api/";
				 	$data['baseServerUrl']="https://www.creosouls.com/api/";
				 	return $data;
    			}
    		}
    		else
    		{
    			$maac = $this->load->database('maac_db', TRUE);
    			$userData=$maac->select('id,instituteId,status')->from('users')->where('email',$emailId)->get()->result_array();
    			if(!empty($userData))
    			{
	    			if($userData[0]['instituteId'] > 0)
	    			{
					 	$data = array();
						$data['statusCode']=200;
					 	$data['errorMessage']='';
					 	$data['statusMessage']='Done';
					 	//$data['baseServerUrl']=base_url()."maac/api/";
					 	$data['baseServerUrl']="https://www.creosouls.com/maac/api/";
					 	return $data;
	    			}
	    		}
	    		else
	    		{
	    			$udata=array('firstName'=>$firstName,'lastName'=>$lastName,'email'=>$emailId,'identifier'=>$googleId,'profileImage'=>$profileImageUrl,'status'=>1,'disk_space'=>1024,'type'=>$userType,'created'=>date('Y-m-d H:i:s'));
	    			$this->db->insert('users',$udata);
	    			$maac->insert('users',$udata);
    			 	$data = array();
    				$data['statusCode']=200;
    			 	$data['errorMessage']='';
    			 	$data['statusMessage']='Done';
    			 	$data['baseServerUrl']='';
    			 	return $data;
	    		}
    		}
    	}
    }
	public function GetUserDetail($googleId,$emailId,$firstName,$lastName,$profileImageUrl,$gender,$deviceId,$studentId,$userType)
	{
		if($studentId != '')
		{
			//echo $studentId;die;
			$studentIdExists = $this->db->select('id')->from('institute_csv_users')->where(array('studentId'=>$studentId))->get()->row_array();
			//print_r($studentIdExists);die;
			if(empty($studentIdExists))
			{
				 	$data = array();
					$data['statusCode']=404;
				 	$data['errorMessage']='Student id does not exists.';
				 	$data['statusMessage']='Invalid student ID. If you are a student, please contact your Institute Admin.';
				 	return $data;
			}   
		    $this->db->select('status,email');
			$this->db->from('institute_csv_users');
	        $this->db->where('studentId',$studentId);
	      	$dataArray = $this->db->get()->row_array();
	      	//print_r($dataArray);die;
	      	if($dataArray['email'] =='')
	      	{
	      		//echo "new string";die;
	      		$this->db->where('studentId',$studentId);
	      		$this->db->update('institute_csv_users',array('email'=>$emailId,'status'=>1));
	      		$csvId = $this->db->select('id')->from('institute_csv_users')->where(array('email'=>$emailId,'studentId'=>$studentId))->get()->row_array();
	      		//print_r($csvId);die;
	      		$instituteId = $this->db->select('instituteId')->from('institute_csv_users')->where(array('email'=>$emailId,'studentId'=>$studentId))->get()->row_array();
	      		//print_r(array('csvuserId'=>$csvId['id'],'start_date'=>date('Y-m-d H:i:s'),'end_date'=>date('Y-m-d H:i:s', strtotime("+12 months $date")),'status'=>1));die;
	      		$this->db->insert('student_membership',array('csvuserId'=>$csvId['id'],'start_date'=>date('Y-m-d H:i:s'),'end_date'=>date('Y-m-d H:i:s', strtotime("+12 months $date")),'status'=>1));
	      		
	      	}
	      	else
	      	{
	      		if($dataArray['email'] != $emailId)
	      		{
	      			$correctEmail=$dataArray['email'];
	      			$correctEmailParts=explode('@',$correctEmail);
	      			$emailLength=strlen($correctEmailParts[0]);
	      			if($emailLength >= 8)
	      			{
	      				$newstring = substr($correctEmailParts[0], -4);
	      			}
	      			elseif($emailLength < 8 && $emailLength >=5)
	      			{
	      				$newstring = substr($correctEmailParts[0], -3);
	      			}
	      			else
	      			{
	      				$newstring = substr($correctEmailParts[0], -2);
	      			}
	      			$stMsg='Correct email associated with inserted student id is ****'.$newstring.'@'.$correctEmailParts[1].'.';
      			 	$data = array();
      				$data['statusCode']=404;
      			 	$data['errorMessage']='Student id does not exists.';
      			 	$data['statusMessage']=$stMsg;
      			 	return $data;
	      		}
	      	}
		}
		//echo "Old one";die;
	      	if(!empty($dataArray) || $studentId == '')
	      	{
		    $this->db->select('id as userId,firstName,email,deviceId,identifier as googleId,contactNo,instituteId,country,city,profession,company,about_me as aboutMe,experience,education,profileImage as profileImageUrl,webSiteURL,dob as birthday,status,job_status as isJobEnable,type as userType,age');
			$this->db->from('users');
	        $this->db->where('email',$emailId);
	      	$new_array = $this->db->get()->result_array();
		   if(!empty($new_array))
		   {
		   	  	if($new_array[0]['status']==1)
		   	  	{
					$userSocialLink = $this->getUserSocialData($new_array[0]['userId']);
					$user_web_links = $this->getUserWebsiteData($new_array[0]['userId']);
					$view_like_cnt = $this->getViewLikeCnt($new_array[0]['userId']);
					$followers = $this->getFollowers($new_array[0]['userId']);
					$following = $this->getFollowing($new_array[0]['userId']);
					$rating = $this->overAllProjectRating($new_array[0]['userId']);

							$isTermsAndConditionsAccepted=$this->getValueOnly('terms_and_conditions','id',array('user_id'=>$new_array[0]['userId']),$order_by='',$limit='');
							if($isTermsAndConditionsAccepted > 0)
							{
								$new_array[0]['isTermsAndConditionsAccepted'] = 'true';
							}
							else
							{
								$new_array[0]['isTermsAndConditionsAccepted'] = 'false';
							}
							if($new_array[0]['isJobEnable'] ==1)
							{
								$new_array[0]['isJobEnable'] = 'true';
							}
							else
							{
								$new_array[0]['isJobEnable'] = 'false';
							}
					if(!empty($rating)&& $rating[0]['avg']!='')
					{
						$new_array[0]['rating'] = $rating[0]['avg'];
					}
					else
					{
						$new_array[0]['rating'] = 0;
					}
					if(!empty($userSocialLink))
					{
						$new_array[0]['userSocialLinks'] = implode(',',$userSocialLink);
					}
					else
					{
						$new_array[0]['userSocialLinks'] = '';
					}
					if(!empty($user_web_links))
					{
						$new_array[0]['userWebLinks'] = implode(',',$user_web_links);
					}
					else
					{
						$new_array[0]['userWebLinks'] = '';
					}
					if(!empty($view_like_cnt) && !empty($view_like_cnt[0]['views']) && !empty($view_like_cnt[0]['likes']))
					{
						$new_array[0]['pofileViewCount'] = $view_like_cnt[0]['views'];
						$new_array[0]['pofileLikeCount'] = $view_like_cnt[0]['likes'];
					}
					else
					{
						$new_array[0]['pofileViewCount'] = 0;
						$new_array[0]['pofileLikeCount'] = 0;
					}
					if(!empty($followers) && !empty($followers[0]['followers']))
					{
						$new_array[0]['followersCount'] = $followers[0]['followers'];
					}
					else
					{
						$new_array[0]['followersCount'] = 0;
					}
					if(!empty($following) && !empty($following[0]['following']))
					{
						$new_array[0]['followingCount'] = $following[0]['following'];
					}
					else
					{
						$new_array[0]['followingCount'] = 0;
					}
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) && filesize(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) > 0 && $new_array[0]['profileImageUrl']!='')
					{
					  	$new_array[0]['profileImageUrl'] = file_upload_base_url().'users/thumbs/'.$new_array[0]['profileImageUrl'];
					}
					else
					{
						 if(isset($profileImageUrl) && $profileImageUrl!='')
					       {
			   	   		$imageName=$this->grab_google_image($profileImageUrl,file_upload_s3_path().'users/thumbs/'.$googleId.'.jpg');
					   	   		$new_array[0]['profileImageUrl'] = file_upload_base_url().'users/thumbs/'.$imageName;
					   	   	    $UserInfo=array('profileImage'=>$imageName,'profileURL'=>$profileImageUrl);
								$this->db->where('email',$emailId);
								$this->db->update('users',$UserInfo);
					   	   }
					   	   else
					   	   {
						   		$new_array[0]['profileImageUrl']='';
						   }
						//$new_array[0]['profileImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
					}
					if($new_array[0]['deviceId']!=$deviceId)
					{
						$this->db->where('id',$new_array[0]['userId']);
						$this->db->update('users',array('deviceId'=>$deviceId));
					}
					if(isset($instituteId['instituteId']) && $instituteId['instituteId']!='')
					{
						$this->db->where('email',$emailId);
						$this->db->update('users',array('instituteId'=>$instituteId['instituteId']));
					}
					$this->insert_login_details($new_array[0]['userId'],$deviceId);
					$data = $new_array[0];
				  	$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
				}
				else
				{
				 	$data = array();
					$data['statusCode']=404;
				 	$data['errorMessage']='Your Account is Deactivated';
				 	$data['statusMessage']='Your Account is Deactivated';
				}
	 	   }
		   else
		   {
		   	  if(isset($profileImageUrl)&& $profileImageUrl)
			    {
		   	   		$imageName=$this->grab_google_image($profileImageUrl,file_upload_s3_path().'users/thumbs/'.$googleId.'.jpg');
		   	    }
		   	    else
		   	    {
					$imageName = '';
				}
		   	   $UserInfo=array('firstName'=>$firstName,'lastName'=>$lastName,'email'=>$emailId,'profileImage'=>$imageName,'identifier'=>$googleId,'deviceId'=>$deviceId,'status'=>1,'created'=>date('Y-m-d H:i:s'),'type'=>$userType);
					if(isset($profileImageUrl)&& $profileImageUrl)
					{
						$UserInfo['profileURL']=$profileImageUrl;
					}
				 $this->db->insert('users',$UserInfo);
				 $res = $this->db->insert_id();
				 if(isset($instituteId['instituteId']) && $instituteId['instituteId']!='')
				 {
				 	$this->db->where('email',$emailId);
				 	$this->db->update('users',array('instituteId'=>$instituteId['instituteId']));
				 }
				 
				 if(!empty($res))
				 {
				 	   $this->db->select('id as userId,firstName,email,identifier as googleId,contactNo,instituteId,country,city,profession,company,about_me as aboutMe,experience,education,profileImage as profileImageUrl,webSiteURL,dob as birthday,status,job_status as isJobEnable,type as userType,age');
						$this->db->from('users');
				        $this->db->where('email',$emailId);
				      	$new_array=$this->db->get()->result_array();
				      	if(!empty($new_array))
				   	  	{
				   	  		$new_array[0]['userSocialLinks'] = '';
							$new_array[0]['userWebLinks'] = '';
							$new_array[0]['pofileViewCount'] = 0;
							$new_array[0]['pofileLikeCount'] = 0;
							$new_array[0]['followersCount'] = 0;
							$new_array[0]['followingCount'] = 0;
							$new_array[0]['rating'] = 0;
							if(file_exists(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) && filesize(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) > 0 && $new_array[0]['profileImageUrl']!='')
							{
							  	$new_array[0]['profileImageUrl'] = file_upload_base_url().'users/thumbs/'.$new_array[0]['profileImageUrl'];
							}
							else
							{
								//$new_array[0]['profileImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
								$new_array[0]['profileImageUrl'] = "";
							}
							$isTermsAndConditionsAccepted=$this->getValueOnly('terms_and_conditions','id',array('user_id'=>$new_array[0]['userId']),$order_by='',$limit='');
							if($isTermsAndConditionsAccepted > 0)
							{
								$new_array[0]['isTermsAndConditionsAccepted'] = 'true';
							}
							else
							{
								$new_array[0]['isTermsAndConditionsAccepted'] = 'false';
							}
							if($new_array[0]['isJobEnable'] ==1)
							{
								$new_array[0]['isJobEnable'] = 'true';
							}
							else
							{
								$new_array[0]['isJobEnable'] = 'false';
							}
							$this->insert_login_details($res,$deviceId);
							$data = $new_array[0];
						  	$data['statusCode']=200;
						 	$data['errorMessage']='';
						 	$data['statusMessage']='Done';
						}
						else
						{
						 	$data = array();
							$data['statusCode']=404;
						 	$data['errorMessage']='Server error';
						 	$data['statusMessage']='Try again please';
						}
				 }
				 else
				 {
				 	$data = array();
					$data['statusCode']=404;
				 	$data['errorMessage']='Faild to add user';
				 	$data['statusMessage']='Try again please';
				 }
		   }
		   return $data;
	  }
	  else
	  {
	  	return array();
	  }
	}
	public function insert_login_details($user_id,$deviceId)
	{
		$userdetail= $this->loggedInUserInfoById($user_id); //$this->model_basic->getValue('users','firstName'," `id` = '".$user_id."'");
		$data = array(
				'userId'				=>$user_id,
				'userName'				=>ucwords($userdetail['firstName'].' '.$userdetail['lastName']),
				'logIn_time'			=>date('Y-m-d h:i:s'),
				'logIn_time_current'	=>date('Y-m-d h:i:s'),
				'deviceId'			=>$deviceId
			);
		return $this->db->insert('user_login_details',$data);
	}
	public function getprojectshowreeldata($uid)
	{
		return $this->db->select('showreel')->from('project_master')->where('userId',$uid)->where('showreel','1')->get()->row_array();
	}
	public function getUserSocialData($uid)
	{
		return $this->db->select('facebook,twitter,google,pinterest,instagram,linkedin')->from('social_link')->where('user_id',$uid)->get()->row_array();
	}
	public function getUserWebsiteData($uid)
	{
	   return $this->db->select('link')->from('user_web_reference')->where('user_id',$uid)->get()->result_array();
	}
	public function getViewLikeCnt($uid)
	{
		return $this->db->select('SUM(view_cnt) AS views,SUM(like_cnt) AS likes')->from('project_master')->where('userId',$uid)->get()->result_array();
	}
	public function getFollowers($uid)
	{
		return $this->db->select('COUNT(followingUser) AS followers')->from('user_follow')->where('followingUser',$uid)->get()->result_array();
	}
	public function getFollowing($uid)
	{
		return $this->db->select('COUNT(followingUser) AS following')->from('user_follow')->where('userId',$uid)->get()->result_array();
	}
	function grab_google_image($url,$saveto)
	{
	    $ch = curl_init ($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    $raw=curl_exec($ch);
	    curl_close ($ch);
	    if(file_exists($saveto)){
	        unlink($saveto);
	    }
       $fp = fopen($saveto,'x');
	    fwrite($fp, $raw);
	    fclose($fp);
	    return basename($saveto);
	}
	public function UserFollow($followUserId,$userFollowStatus,$userId,$deviceId)
	{   $data = array();
		if($userFollowStatus==1)
		{
			$result=$this->checkFollowingOrNot($userId,$followUserId);
			if(empty($result))
			{
			    $data1=array('followingUser'=>$followUserId,'userId'=>$userId,'created'=>date('Y-m-d H:i:s'));
				$res = $this->db->insert('user_follow',$data1);
				if($res > 0)
				{
					$followBy            = $this->loggedInUserInfoById($userId);
					$followTo            = $this->loggedInUserInfoById($followUserId);
					$nameBy              = ucwords($followBy['firstName'].' '.$followBy['lastName']);
					$nameTo              = ucwords($followTo['firstName'].' '.$followTo['lastName']);
					$emailBy             = $followBy['email'];
					$emailTo             = $followTo['email'];
					$subjectBy           = 'You are now following '.$nameTo.' on creonow';
					$subjectTo           = 'Congratulations! You have a new follower on creonow';
					$from                = 'contact@creonow.com';
					$templateBy          = 'Hello<b> '.$nameBy. '</b>,<br /> You are now following <b>'.$nameTo.'</b> on creonow. You will be notified about latest creations by '.$nameTo.'.<br /><a href="'.base_url().'user/userDetail/'.$followUserId.'">Click here</a> to view '.$nameTo.'‘s profile.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
					$templateTo          = 'Hello <b>'.$nameTo.'</b>,<br /> <b>'.$nameBy.'</b> started following you on creonow.<br /><a href="'.base_url().'user/userDetail/'.$userId.'">Click here</a> to view '.$nameBy.'‘s profile.<br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
					$emailDetailFollowTo = array('to'=>$emailTo,'subject'  =>$subjectTo,'template' =>$templateTo,'fromEmail'=>$from);
					$emailDetailFollowBy = array('to'=>$emailBy,'subject'  =>$subjectBy,'template' =>$templateBy,'fromEmail'=>$from);
					$emailFlag=$this->getValue('user_email_notification_relation','follow_unfollow'," `userId` = '".$followUserId."'");
					if($emailFlag==1 || $emailFlag=='')
					{
						$this->sendMail($emailDetailFollowTo);
					}
					$emailFlag1=$this->getValue('user_email_notification_relation','follow_unfollow'," `userId` = '".$userId."'");
					if($emailFlag1==1 || $emailFlag1=='')
					{
						$this->sendMail($emailDetailFollowBy);
					}
					$msg = array();
				    if(file_exists(file_upload_s3_path().'users/thumbs/'.$followBy['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$followBy['profileImage']) > 0)
					{
						$msg['notificationImageUrl'] = file_upload_base_url().'users/thumbs/'.$followBy['profileImage'];
					}
					else
					{
						$msg['notificationImageUrl'] = '';
					}
					$msg['notificationTitle'] = 'New User Following';
					$msg['notificationMessage']  = $nameBy.'  started following you.';
					$msg['notificationType']   = 5;
				    $msg['notificationId']     = $userId;
				    $msg['type']     = 0;
					$this->sendGcmToken($followUserId,$msg);
					$data['isUpdatedOnServer']=1;
					$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
				}
				else
				{
					$data['isUpdatedOnServer']=0;
					$data['statusCode']=404;
				 	$data['errorMessage']='Faild to Follow user';
				 	$data['statusMessage']='Try again please';
				}
			}
			else{
				    $data['isUpdatedOnServer']=1;
					$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
			}
		}
		else
		{
			$res=$this->unfollow_user($userId,$followUserId);
			if($res > 0)
			{
				$unfollowBy            = $this->loggedInUserInfoById($userId);
				$unfollowTo            = $this->loggedInUserInfoById($followUserId);
				$nameBy                = ucwords($unfollowBy['firstName'].' '.$unfollowBy['lastName']);
				$nameTo                = ucwords($unfollowTo['firstName'].' '.$unfollowTo['lastName']);
				$emailBy               = $unfollowBy['email'];
				$subjectBy             = 'You are no more following '.$nameTo.' on creonow';
				$from                  = 'contact@creonow.com';
				$templateBy            = 'Hello<b> '.$nameBy. '</b>,<br /> You are no more following <b>'.$nameTo.'</b> on creonow. <br /><br /><br />Thanks,<br />Team creonow<br /><a href="http://aptech.creonow.com">aptech.creonow.com</a>';
				$emailDetailunfollowBy = array('to'       =>$emailBy,'subject'  =>$subjectBy,'template' =>$templateBy,'fromEmail'=>$from);
				$this->sendMail($emailDetailunfollowBy);
				$data['isUpdatedOnServer']=1;
				$data['statusCode']=200;
			 	$data['errorMessage']='';
			 	$data['statusMessage']='Done';
			}
			else
			{
				$data['isUpdatedOnServer']=0;
				$data['statusCode']=404;
			 	$data['errorMessage']='Faild to unfollow add user';
			 	$data['statusMessage']='Try again please';
			}
		}
		 return $data;
	 }
	/*public function checkFollowingOrNot($userId,$followUserId)
	{
		$this->db->select('*');
		$this->db->from('user_follow');
		$this->db->where('userId',$userId);
		$this->db->where('followingUser',$followUserId);
	    return $this->db->get()->result_array();
	}*/
	function unfollow_user($userId,$followUserId)
	{
	    $this->db->where('userId',$userId);
	    $this->db->where('followingUser',$followUserId);
		return $this->db->delete('user_follow');
    }
	public function UploadProfilePic($userId,$deviceId,$bitmapString)
	{
            $data = array();
	  	 	$today = date("Y_m_d_H_i_s");
	  	 	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$shuffled = str_shuffle($str);
		 	$binary=base64_decode($bitmapString);
		    header('Content-Type: bitmap; charset=utf-8');
		    $file = fopen(file_upload_s3_path().'users/'.$today.$shuffled.'.jpg', 'w');
		    fwrite($file, $binary);
		    fclose($file);
		    $this->ImageCropMaster('200', '200', file_upload_s3_path().'users/'.$today.$shuffled.'.jpg', file_upload_s3_path().'users/thumbs/'.$today.$shuffled.'.jpg', $quality = 80);
			$previousImage = $this->getValue('users',"profileImage","id=".$userId);
			if($previousImage!='')
			{
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$previousImage))
				{
					@unlink(file_upload_s3_path().'users/thumbs/'.$previousImage);
				}
				if(file_exists(file_upload_s3_path().'users/'.$previousImage))
				{
					@unlink(file_upload_s3_path().'users/'.$previousImage);
				}
			}
			$res =  $this->_update('users','id',$userId,array('profileImage'=>$today.$shuffled.'.jpg'));
			if($res > 0)
			{
				$data['url']= file_upload_base_url().'users/thumbs/'.$today.$shuffled.'.jpg';
				$data['isUpdatedOnServer']=1;
				$data['statusCode']=200;
			 	$data['errorMessage']='';
			 	$data['statusMessage']='Done';
			}
			else
			{
				$data['url']= '';
				$data['isUpdatedOnServer']=0;
				$data['statusCode']=404;
			 	$data['errorMessage']='Faild to update user profile';
			 	$data['statusMessage']='Try again please';
			}
		 return $data;
	 }
	function _update($table,$field,$fieldValue,$data)
	{
		$this->db->where($field,$fieldValue);
		return $this->db->update($table,$data);
	}
	public function UserSignOut($userId,$deviceId)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('user_login_details');
        $this->db->where('userId',$userId);
        $this->db->where('deviceId',$deviceId);
        $this->db->order_by('loginId','desc');
      	$new_array = $this->db->get()->result_array();
	    if(!empty($new_array))
	    {
	    	 $this->db->where('loginId',$new_array[0]['loginId']);
	         $res = $this->db->update('user_lo$new_arraygin_details',array('logOut_time'=>date('Y-m-d h:i:s'),'status'=>0));
			if($res > 0)
			{
				$data['isUpdatedOnServer']=1;
				$data['statusCode']=200;
			 	$data['errorMessage']='';
			 	$data['statusMessage']='Done';
			}
			else
			{
				$data['isUpdatedOnServer']=0;
				$data['statusCode']=404;
			 	$data['errorMessage']='Faild to update';
			 	$data['statusMessage']='Try again please';
			}
		}
		 return $data;
	 }
	public function SaveProjectRating($userId,$deviceId,$projectId,$rating)
	{
			$res= $this->check_project_rating($projectId,$userId);
			if(empty($res))
			{
				$data = array('projectId' =>$projectId,'userId'=>$userId,'created'=>date('Y-m-d H:i:s'),'rating'=>$rating);
				$rs =$this->db->insert('project_rating',$data);
				if($rs > 0)
				{
					$data['isUpdatedOnServer']=1;
					$data['statusCode']=200;
				 	$data['errorMessage']='';
				 	$data['statusMessage']='Done';
				}
				else
				{
					$data['isUpdatedOnServer']=0;
					$data['statusCode']=404;
				 	$data['errorMessage']='Faild to update';
				 	$data['statusMessage']='Try again please';
			    }
			}
	   		else
			{
				$data['isUpdatedOnServer']=0;
				$data['statusCode']=404;
			 	$data['errorMessage']='Faild to update';
			 	$data['statusMessage']='Try again please';
		    }
		 return $data;
	 }
	public function check_project_rating($proId,$userId)
	{
		$this->db->select('*');
		$this->db->from('project_rating');
		$this->db->where('projectId',$proId);
		$this->db->where('userId',$userId);
		return $this->db->get()->result_array();
	}
	public function GetUserInfoById($userId,$deviceId)
	{
	   	$this->db->select('A.id as userId,A.firstName,A.lastName,A.email,A.identifier as googleId,A.profile_complete as profileCompilationMeter,A.contactNo,A.instituteId,B.instituteName,A.country,A.city,A.profession,A.company,A.about_me as aboutMe,A.experience,A.education,A.profileImage as profileImageUrl,A.webSiteURL,A.dob as birthday,A.status,A.address,A.teachers_status as isTeacher,A.job_status as isJobEnable,A.type as userType,A.age');
		$this->db->from('users as A');
        	$this->db->where('A.id',$userId);
        	$this->db->join('institute_master as B','B.id = A.instituteId','left');
      		$new_array = $this->db->get()->result_array();
	   	if(!empty($new_array))
	   	{
	   	  	if($new_array[0]['status']==1)
	   	  	{				
				$isTermsAndConditionsAccepted=$this->getValueOnly('terms_and_conditions','id',array('user_id'=>$new_array[0]['userId']),$order_by='',$limit='');
				if($isTermsAndConditionsAccepted > 0)
				{
					$new_array[0]['isTermsAndConditionsAccepted'] = 'true';
				}
				else
				{
					$new_array[0]['isTermsAndConditionsAccepted'] = 'false';
				}
				$getshowreel=$this->getprojectshowreeldata($new_array[0]['userId']);
				if(isset($getshowreel) && !empty($getshowreel))
				{
					$new_array[0]['isShowreel'] = 'true';

				}
				else
				{
					$new_array[0]['isShowreel'] = 'false';

				}
				$userSocialLink = $this->getUserSocialData($new_array[0]['userId']);
				$user_web_links = $this->getUserWebsiteData($new_array[0]['userId']);
				$view_like_cnt = $this->getViewLikeCnt($new_array[0]['userId']);
				$followers = $this->getFollowers($new_array[0]['userId']);
				$following = $this->getFollowing($new_array[0]['userId']);
				$rating = $this->overAllProjectRating($new_array[0]['userId']);
				$education = $this->getUserEducationDetails($new_array[0]['userId']);
				$skill = $this->getUserSkill($new_array[0]['userId']);
				$award = $this->getUserAward($new_array[0]['userId']);
				$finstanceList = $this->model_basic->getAllData('feedback_instance','id,name as title,start_session as startDate,end_session as endDate',array('institute_id'=>$new_array[0]['instituteId'],'status'=>1));
				if(!empty($finstanceList))
				{
					$instanceList=array();
					foreach($finstanceList as $instance )
					{
						$isSubmitted=$this->model_basic->getValueArray('institutefeedback','id',array('user_id'=>$userId,'instance_id'=>$instance['id']),$order_by='',$limit='');
						if($isSubmitted > 0)
						{
							$instance['isSubmitted']='true';
						}
						else
						{
							$instance['isSubmitted']='false';
						}
						$instanceList[]=$instance;
					}
					$new_array[0]['instanceList'] = $instanceList;
				}
				else
				{
					$new_array[0]['instanceList'] = array();
				}
				$csvUserId = $this->model_basic->getValueArray('institute_csv_users','id',array('email'=>$new_array[0]['email']),$order_by='',$limit='');
				if(isset($csvUserId) && $csvUserId > 0)
				{
					$startDate = $this->model_basic->getValueArray('student_membership','start_date',array('csvuserId'=>$csvUserId),$order_by='',$limit='');
					$startDate = date('Y/m/d H:i:s', strtotime($startDate));
					$endDate = $this->model_basic->getValueArray('student_membership','end_date',array('csvuserId'=>$csvUserId),$order_by='',$limit='');
					$endDate = date('Y/m/d H:i:s', strtotime($endDate));
				}
				$new_array[0]['registrationStartDate']=(isset($startDate) && $startDate!='')?$startDate:'';
				$new_array[0]['registrationEndDate']=(isset($endDate) && $endDate!='')?$endDate:'';

                if($new_array[0]['isTeacher']==1)
				{
					$new_array[0]['isTeacher']='true';
				}
				else
				{
					$new_array[0]['isTeacher']='false';
				}
if($new_array[0]['isJobEnable']==1)
				{
					$new_array[0]['isJobEnable']='true';
				}
				else
				{
					$new_array[0]['isJobEnable']='false';
				}
				if(!empty($skill))
				{
					$new_array[0]['skillList'] = $skill;
				}
				else
				{
					$new_array[0]['skillList'] = array();
				}
				if(!empty($award))
				{
					$new_array[0]['awardAndPublicationList'] = $award;
				}
				else
				{
					$new_array[0]['awardAndPublicationList'] = array();
				}
				if(!empty($education))
				{
					$new_array[0]['educationList'] = $education;
				}
				else
				{
					$new_array[0]['educationList'] = array();
				}
				$workdetails = $this->getUserWorkDetails($new_array[0]['userId']);
				if(!empty($workdetails))
				{
					$new_array[0]['experienceList'] = $workdetails;
				}
				else
				{
					$new_array[0]['experienceList'] = array();
				}
				if(!empty($rating)&& $rating[0]['avg']!='')
				{
					$new_array[0]['rating'] = $rating[0]['avg'];
				}
				else
				{
					$new_array[0]['rating'] = 0;
				}
				if(!empty($userSocialLink))
				{
					$new_array[0]['facebook'] = $userSocialLink['facebook'];
					$new_array[0]['twitter'] = $userSocialLink['twitter'];
					$new_array[0]['google'] = $userSocialLink['google'];
					$new_array[0]['pinterest']= $userSocialLink['pinterest'];
					$new_array[0]['instagram'] = $userSocialLink['instagram'];
					$new_array[0]['linkedin'] = $userSocialLink['linkedin'];
				}
				else
				{
					$new_array[0]['facebook'] = '';
					$new_array[0]['twitter'] = '';
					$new_array[0]['google'] = '';
					$new_array[0]['pinterest']= '';
					$new_array[0]['instagram'] = '';
					$new_array[0]['linkedin'] = '';
				}
				if(!empty($user_web_links))
				{
					$new_array[0]['userWebLinks'] = implode(',',$user_web_links);
				}
				else
				{
					$new_array[0]['userWebLinks'] = '';
				}
				if(!empty($view_like_cnt))
				{
					if(!empty($view_like_cnt[0]['views']))
					{
						$new_array[0]['profileViewCount'] = $view_like_cnt[0]['views'];
					}
					else{
						$new_array[0]['profileViewCount'] = 0;
					}
					if(!empty($view_like_cnt[0]['likes']))
					{
						$new_array[0]['profileLikeCount'] = $view_like_cnt[0]['likes'];
					}
					else{
						$new_array[0]['profileLikeCount'] = 0;
					}
					/*$new_array[0]['pofileViewCount'] = $view_like_cnt[0]['views'];
					$new_array[0]['pofileLikeCount'] = $view_like_cnt[0]['likes'];*/
				}
				else
				{
					$new_array[0]['profileViewCount'] = 0;
					$new_array[0]['profileLikeCount'] = 0;
				}
				if(!empty($followers) && !empty($followers[0]['followers']))
				{
					$new_array[0]['followersCount'] = $followers[0]['followers'];
				}
				else
				{
					$new_array[0]['followersCount'] = 0;
				}
				if(!empty($following) && !empty($following[0]['following']))
				{
					$new_array[0]['followingCount'] = $following[0]['following'];
				}
				else
				{
					$new_array[0]['followingCount'] = 0;
				}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) && filesize(file_upload_s3_path().'users/thumbs/'.$new_array[0]['profileImageUrl']) > 0 && $new_array[0]['profileImageUrl']!='')
				{
				  	$new_array[0]['profileImageUrl'] = file_upload_base_url().'users/thumbs/'.$new_array[0]['profileImageUrl'];
				}
				else
				{
					if(isset($profileImageUrl) && $profileImageUrl!='')
				       {
		   	   			$imageName=$this->grab_google_image($profileImageUrl,file_upload_s3_path().'users/thumbs/'.$googleId.'.jpg');
				   	   	$new_array[0]['profileImageUrl'] = file_upload_base_url().'users/thumbs/'.$imageName;
				   	   	$UserInfo=array('profileImage'=>$imageName,'profileURL'=>$profileImageUrl);
						$this->db->where('email',$emailId);
						$this->db->update('users',$UserInfo);
				   	}
				   	else
				   	{
						$new_array[0]['profileImageUrl']='';
					}
					//$new_array[0]['profileImageUrl'] = base_url().'creonow_admin/backend_assets/img/noimage.jpg';
				}
				$data = $new_array[0];
			  	$data['statusCode']=200;
			 	$data['errorMessage']='';
			 	$data['statusMessage']='Done';
			}
			else
			{
			 	$data = array();
				$data['statusCode']=404;
			 	$data['errorMessage']='Your Account is Deactivated';
			 	$data['statusMessage']='Your Account is Deactivated';
			}
 	   	}
	   	else
	   	{
	   	 	$data = array();
			$data['statusCode']=404;
		 	$data['errorMessage']='Not Exist';
		 	$data['statusMessage']='Try again please';
	   	}
	   	return $data;
	}
	public function getUserEducationDetails($uid)
	{
	   return $this->db->select('qualification,stream,startFrom as fromYear,endFrom as toYear,id as educationId,university as universityInstitute')->from('users_education')->where('user_id',$uid)->order_by('endFrom','desc')->get()->result_array();
	}
	public function getUserWorkDetails($uid)
	{
	   return  $this->db->select('id as experienceId,organisation as companyName,position,	startingDate as fromDate,endingDate as toDate,w_address as address,status as currentEmployer,workDetails as workDescription')->from('users_work')->where('user_id',$uid)->order_by('status','desc')->get()->result_array();
	}
	public function getUserSkill($uid)
	{
	     return  $this->db->select('id as skillId,skillName,skillLevel as knowledgeRate')->from('users_skills')->where('user_id',$uid)->get()->result_array();
	}
	public function getUserAward($uid)
	{
	     return  $this->db->select('id as AwardsPublicationId,award as AwardTitle,prize as AwardPrizeNomination,dateRecieved as date')->from('users_award')->where('user_id',$uid)->get()->result_array();
	}
	public function UpdateBasicInfo($userId,$arr)
	{
		$data =array();
		$this->db->where('id',$userId);
		$res = $this->db->update('users',$arr);
		if($res)
		{
			$data['isUpdatedOnServer']=1;
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['isUpdatedOnServer']=0;
			$data['statusCode']=404;
		 	$data['errorMessage']='Field To Update Profile';
		 	$data['statusMessage']='';
		}
		 return $data;
	}
 	public function getAllNotificationData($userId,$deviceId,$pageNo,$pageSize)
 	{
 		return $this->db->select('A.id,A.typeId as notificationType,A.redirectId as notificationId,A.title as notificationHeaderTitle,A.msg as notificationTitle,A.imageLink as logoUrl,A.created as notificationDate,B.status as isRead')->from('header_notification_master as A')->join('header_notification_user_relation as B','A.id=B.notification_id')->where('B.user_id',$userId)->where('A.typeId !=',0)->order_by('B.status','asc')->order_by('A.created','desc')->get()->result_array();
 	}
 	public function GetUserNotification($userId,$deviceId,$pageNo,$pageSize)
 	{
 		$notifications=$this->getAllNotificationData($userId,$deviceId,$pageNo,$pageSize);
 		if(!empty($notifications))
 		{
 			$new_array=array();
 			foreach($notifications as $notification)
 			{
 				$notification['logoUrl'] = file_upload_base_url().$notification['logoUrl'];
 				$new_array[]=$notification;
 			}
 			$arr_data['notifications']=$new_array;
 		  	$arr_data['statusCode']=200;
 		 	$arr_data['errorMessage']='';
 		 	$arr_data['statusMessage']='Done';
 		}
 		else
 		{
 			$arr_data['notifications']=array();
 		  	$arr_data['statusCode']=200;
 		 	$arr_data['errorMessage']='';
 		 	$arr_data['statusMessage']='Done';
 		}
  		return $arr_data;
 	}
 	public function UpdateIsReadNotificationFlag($userId,$deviceId)
 	{
 		$res = $this->model_basic->_updateWhere('header_notification_user_relation',array('user_id'=>$userId,'status'=>0),array('status'=>1));
 		if($res > 0)
 		{
 		  	$data['statusCode']=200;
 		 	$data['errorMessage']='';
 		 	$data['statusMessage']='Done';
 		}
 		else
 		{

 		  	$data['statusCode']=404;
		 	$data['errorMessage']='Failed to update read status.';
		 	$data['statusMessage']='';
 		}
  		return $data;
 	}
    public function check_job_notification_relation($id,$userId)
	{
		$this->db->select('*');
		$this->db->from('job_user_notification');
		$this->db->where('userId',$userId);
		$this->db->where('jobId',$id);
	    return $this->db->get()->result_array();
	}
    public function check_event_notification_relation($id,$userId)
	{
		$this->db->select('*');
		$this->db->from('event_user_notification');
		$this->db->where('userId',$userId);
		$this->db->where('eventId',$id);
	    return $this->db->get()->result_array();
	}
    public function check_competition_notification_relation($id,$userId)
	{
		$this->db->select('*');
		$this->db->from('competition_user_notification');
		$this->db->where('userId',$userId);
		$this->db->where('competitionId',$id);
	    return $this->db->get()->result_array();
	}
    public function getAllLike($userId)
	{
		$this->db->select('project_master.projectName,project_master.id,user_project_views.userLike,users.firstName,users.profileImage,users.lastName,user_project_views.read,user_project_views.like_date as created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$userId);
		$this->db->where('user_project_views.userId !=',$userId);
	   	//$this->db->limit(10);
		$this->db->where('user_project_views.userLike',1);
		//$this->db->where('user_project_views.read',0);
		$this->db->order_by('user_project_views.like_date','desc');
		$this->db->join('user_project_views', 'user_project_views.projectId = project_master.id');
		$this->db->join('users', 'users.id = user_project_views.userId');
		return $this->db->get()->result_array();
	}
	public function getAllComment($userId)
	{
		$this->db->select('project_master.projectName,project_master.id,user_project_comment.comment,user_project_comment.read,users.profileImage,users.firstName,users.lastName,user_project_comment.created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$userId);
		$this->db->where('user_project_comment.userId !=',$userId);
	   //	$this->db->limit(10);
		$this->db->where('user_project_comment.status',1);
		//$this->db->where('user_project_comment.read',0);
		$this->db->order_by('user_project_comment.created','desc');
		$this->db->join('user_project_comment', 'user_project_comment.projectId = project_master.id');
	    $this->db->join('users', 'users.id = user_project_comment.userId');
		return $this->db->get()->result_array();
	}
	public function getAllfollowing($userId)
	{
		$this->db->select('users.id as userId,users.firstName as followed_by_fname,users.lastName as followed_by_lname,users.profileImage,user_follow.read,user_follow.created');
		$this->db->from('user_follow');
		$this->db->where('user_follow.followingUser',$userId);
		$this->db->join('users', 'users.id = user_follow.userId');
		return $this->db->get()->result_array();
	}
	 public function getAllJob()
	{
		$this->db->select('jobs.id as jobId,jobs.companyLogo,jobs.title as job_title,jobs.created');
		$this->db->from('jobs');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function getAllEvent()
	{
		$this->db->select('events.id as eventId,events.banner,events.name as event_name,events.created');
		$this->db->from('events');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function getAllCompetition($user_institute_id)
	{
		if($user_institute_id!='')
		{
			$this->db->select('competitions.id as competitionId,competitions.profile_image,competitions.name as competition_name,competitions.created');
			$this->db->from('competitions');
			$this->db->where('status',1);
			$this->db->where('instituteId',$user_institute_id);
			$user_institute_competition = $this->db->get()->result_array();
		}
		else
		{
			$user_institute_competition = array();
		}
		$this->db->select('competitions.id as competitionId,competitions.profile_image,competitions.name as competition_name,competitions.created');
		$this->db->from('competitions');
		$this->db->where('status',1);
		$this->db->where('instituteId',0);
		$this->db->where('open_for_all',1);
		$open_competition = $this->db->get()->result_array();
		if(!empty($open_competition)&&!empty($user_institute_competition))
		  {
		  	 $det = array_merge($open_competition,$user_institute_competition);
		  }
		elseif(empty($open_competition)&&!empty($user_institute_competition))
		  {
		  	 $det = $user_institute_competition;
		  }
		 elseif(!empty($open_competition)&&empty($user_institute_competition))
		  {
		  	 $det = $open_competition;
		  }
		  else
		  {
		  	$det = array();
		  }
		return $det;
	}
	   public function AddExperience($userId,$deviceId,$companyName,$position,$fromDate,$toDate,$address,$currentEmployer,$experienceId,$workDescription)
	{
	   if($currentEmployer==1)
	   {
	   		$currentCompany = $this->getUserCurrentCompany($userId);
			if(!empty($currentCompany))
			{
				foreach($currentCompany as $row)
				{
					$this->db->where('id',$row['id']);
					$this->db->update('users_work',array('status'=>'0'));
				}
			}
	   }
		if($experienceId=='-1')
	    {
			if($toDate=='')
			{
				$toDate=date('Y-m-d');
			}
			$arr = array('user_id'=>$userId,'organisation'=>$companyName,'w_address'=>$address,'position'=>$position,'startingDate'=>$fromDate,'endingDate'=>$toDate,'status'=>$currentEmployer,'created'=>date("Y-m-d H:i:s"),'workDetails'=>$workDescription);
			$res = $this->db->insert('users_work',$arr);
		}
		else
		{
			$arr = array('organisation'=>$companyName,'w_address'=>$address,'position'=>$position,'startingDate'=>$fromDate,'endingDate'=>$toDate,'status'=>$currentEmployer,'workDetails'=>$workDescription);
			$this->db->where('user_id',$userId);
			$this->db->where('id',$experienceId);
		    $res = $this->db->update('users_work',$arr);
		}
		$data =array();
		if($res)
		{
			$data['isUpdatedOnServer']=1;
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['isUpdatedOnServer']=0;
			$data['statusCode']=404;
		 	$data['errorMessage']='Failed to add experience';
		 	$data['statusMessage']='';
		}
		 return $data;
	}
	public function getUserCurrentCompany($uid)
	{
	   return  $this->db->select('*')->from('users_work')->where('user_id',$uid)->where('status','1')->get()->result_array();
	}
	public function AddEducation($userId,$deviceId,$university,$qualification,$stream,$fromYear,$toYear,$educationId)
	{
	    if($educationId=='-1')
	    {
			$arr = array('user_id'=>$userId,'university'=>$university,'qualification'=>$qualification,'stream'=>$stream,'startFrom'=>$fromYear,'endFrom'=>$toYear,'created'=>date("Y-m-d H:i:s"));
		    $res = $this->db->insert('users_education',$arr);
		}
		else
		{
			$arr = array('university'=>$university,'qualification'=>$qualification,'stream'=>$stream,'startFrom'=>$fromYear,'endFrom'=>$toYear);
			$this->db->where('user_id',$userId);
			$this->db->where('id',$educationId);
		    $res = $this->db->update('users_education',$arr);
		}
		$data =array();
		if($res)
		{
			$data['isUpdatedOnServer']=1;
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['isUpdatedOnServer']=0;
			$data['statusCode']=404;
		 	$data['errorMessage']='Failed to add education';
		 	$data['statusMessage']='';
		}
		 return $data;
	}
	function DeleteExperience($userId,$deviceId,$experienceId)
	{
	    $this->db->where('user_id',$userId);
	    $this->db->where('id',$experienceId);
		$res = $this->db->delete('users_work');
		if($res > 0)
		{
		  	$data['statusCode']=200;
		 	$data['errorMessage']='Experience Deleted Successfully';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='Field To Delete Experience';
		 	$data['statusMessage']='';
		}
		 return $data;
    }
    function DeleteEducation($userId,$deviceId,$educationId)
	{
	    $this->db->where('user_id',$userId);
	    $this->db->where('id',$educationId);
		$res = $this->db->delete('users_education');
		if($res > 0)
		{
		  	$data['statusCode']=200;
		 	$data['errorMessage']='Education Deleted Successfully';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='Field To Delete Education';
		 	$data['statusMessage']='';
		}
		 return $data;
    }
     function SaveAppFeedback($userId,$deviceId,$email,$name,$feedback)
	{
	   	$arr = array('comment'=>$feedback,'fullName'=>$name,'email'=>$email,'created'=>date("Y-m-d H:i:s"));
		$res = $this->db->insert('feedback',$arr);
		if($res > 0)
		{
			$addedByName        = $name;
			$addedByEmail       = 'contact@creonow.com';
			$from               = $email;
			$subjectBy          = 'Feedback';
			$templateAddedBy  = 'Hello <b>Admin</b>,<br />User  "<b>'.$addedByName.'</b>" sent following feedback about creonow.<br />'.$feedback;
			$sendEmailToAddUser = array('to'=>$addedByEmail,'subject'=>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
			$rest = $this->sendMail($sendEmailToAddUser);
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='Field To Add Comment';
		 	$data['statusMessage']='';
		}
		 return $data;
    }
      public function AddSkill($knowledgeRate,$skillName,$userId,$skillId)
	{
		 if($skillId=='-1')
		 {
		 	$arr = array('skillName' =>$skillName,'skillLevel'=>$knowledgeRate,'user_id'=>$userId,'created'=>date("Y-m-d H:i:s"));
				   $this->db->insert('users_skills',$arr);
			$res = $this->db->insert_id();
		 }
		 else
		 {
		 	$arr = array('skillName' =>$skillName,'skillLevel'=>$knowledgeRate);
		 	$this->db->where('id',$skillId);
		 	$this->db->where('user_id',$userId);
	   	    $res = $this->db->update('users_skills',$arr);
		 }
		if($res > 0)
		{
			$new_array['skillId'] = $skillId;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
		else
		{
			$new_array['skillId'] = 0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
		}
		return $new_array;
	}
	function DeleteSkill($skillId,$userId)
	{
	    $this->db->where('id',$skillId);
		$this->db->where('user_id',$userId);
		$res = $this->db->delete('users_skills');
		if($res > 0)
		{
		  	$data['statusCode']=200;
		 	$data['errorMessage']='Deleted Successfully';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='Field To Delete';
		 	$data['statusMessage']='';
		}
		 return $data;
    }
    function AddLink($userId,$deviceId,$linkType,$link)
	{
		$res = 0;
		$dat = $this->getUserSocialData($userId);
		$arr = array($linkType=>$link);
		if(empty($dat))
		{
			$arr['user_id']=$userId;
		    $res = $this->db->insert('social_link',$arr);
		}
		else
		{
			$this->db->where('user_id',$userId);
		    $res = $this->db->update('social_link',$arr);
		}
		if($res > 0)
		{
		  	$data['statusCode']=200;
		 	$data['errorMessage']='Success';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='Field';
		 	$data['statusMessage']='error';
		}
		 return $data;
    }
///////////////////////////////////////////////////////////----User End----- ////////////////////////////////////////////////////
////////////////////////////////////////////////////////------people -----------///////////////////////////////////////////////
    public function GetPeopleList($userId,$pageNo,$pageSize,$keyword,$deviceId,$category)
	{
        if($category!='')
    	{
    		$categoryId = $this->findCategoryId($category);
    	}
    	$start=($pageNo-1)*$pageSize;
    	$this->db->select('A.id as userId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS projectCount');
		$this->db->from('users as A');
	    $this->db->where('A.status',1);
	    if($userId!='-1')
		  {
		  	 $this->db->where('A.id !=',$userId);
		  }
		if(!empty($category) && isset($categoryId) && !empty($categoryId))
      	{
  		 	$this->db->where('project_master.categoryId',$categoryId[0]['id']);
      	}
	    $this->db->where('A.status',1);
	    $this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->order_by('projectCount','desc');
		if($keyword != '')
		{
			$this->db->where("(A.firstName LIKE '%".$keyword."%'|| A.lastName LIKE '%".$keyword."%'|| A.country LIKE '%".$keyword."%'|| A.city LIKE '%".$keyword."%')");
		}
	    $this->db->join('project_master', 'project_master.userId = A.id', 'left');
	    $this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
	    $this->db->join('project_rating', 'project_rating.projectId = project_master.id', 'left');
		$this->db->group_by('A.id');
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 if(file_exists(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) > 0 && $data[$i]['profileimage']!='')
				{
				  	$data[$i]['profileimage'] = file_upload_base_url().'users/thumbs/'.$data[$i]['profileimage'];
				}
				else
				{
					$data[$i]['profileimage'] = "";
				}
				if($userId!='-1')
				{
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['userId']);
				    if(!empty($followingOrNot))
					{
						$data[$i]['isfollow'] = 1;
					}
					else
					{
						$data[$i]['isfollow'] = 0;
					}
				}
				else
				{
					$data[$i]['isfollow'] = 0;
				}
				$data[$i]['followersCount']=$this->model_basic->getCount('user_follow','followingUser',$row['userId']);
			    $proData = $this->getUserProjectData($row['userId']);
				$likeCount    = 0;
				$viewCount    = 0;
				foreach($proData as $val)
				{
					$likeCount = $val['like_cnt'] + $likeCount;
					$viewCount = $val['view_cnt'] + $viewCount;
				}
				$data[$i]['likeCount'] = $likeCount;
				$data[$i]['viewCount'] = $viewCount;
		        $i++;
			 }
		}
	   	if(!empty($data))
		{
		 	$new_array['peopleList']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
	public function getUserProjectData($userId)
	{
		$this->db->select('A.id as projectId,A.like_cnt,A.view_cnt');
		$this->db->from('project_master as A');
		$this->db->where('A.userId',$userId);
    	return $this->db->get()->result_array();
	}
	/////////////////////////////////////////////////////////--------blog-------------////////////////////////////////////////////////
	public function GetBlogList($pageNo,$pageSize,$userId,$deviceId,$keyword)
	{
	 	$start=($pageNo-1)*$pageSize;
		$this->db->select('id as blogId,title,picture,description,keywords,created,posted_by as postedBy');
		$this->db->from('blog');
		$this->db->where('status',1);
		if($keyword != '')
		{
			$this->db->where("(description LIKE '%".$keyword."%'|| keywords LIKE '%".$keyword."%'|| title LIKE '%".$keyword."%')");
		}
		$this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->order_by('created','desc');
	    $data = $this->db->get()->result_array();
		$new_array = array();
	    if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				$data[$i]['createdDate'] = $row['created'];
				if(file_exists(file_upload_s3_path().'blog/thumb/'.$data[$i]['picture']) && filesize(file_upload_s3_path().'blog/thumb/'.$data[$i]['picture']) > 0 && $data[$i]['picture']!='')
				{
				  	$data[$i]['pictureUrl'] = file_upload_base_url().'blog/thumb/'.$data[$i]['picture'];
				}
				else
				{
					$data[$i]['pictureUrl'] = "";
				}
				$i++;
			}
		 	$new_array['blogs']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
	public function GetBlogDetail($blogId)
	{
	 	$this->db->select('id as blogId,title,picture,description,keywords,created,posted_by as postedBy');
		$this->db->from('blog');
		$this->db->where('status',1);
		$this->db->where('id',$blogId);
	    $data = $this->db->get()->result_array();
		$new_array = array();
	    if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				$data[$i]['createdDate'] = $row['created'];
				if(file_exists(file_upload_s3_path().'blog/'.$data[$i]['picture']) && filesize(file_upload_s3_path().'blog/'.$data[$i]['picture']) > 0 && $data[$i]['picture']!='')
				{
				  	$data[$i]['pictureUrl'] = file_upload_base_url().'blog/'.$data[$i]['picture'];
				}
				else
				{
					$data[$i]['pictureUrl'] = "";
				}
				$i++;
			}
			$new_array=$data[0];
			$comment = $this->getAllBlogComment($blogId);
			if(!empty($comment))
			{
				$i =0;
				foreach($comment as $val)
				{
					 if(file_exists(file_upload_s3_path().'users/thumbs/'.$val['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$val['profileImage']) > 0 && $val['profileImage']!='')
					{
					  	$new_array['comment'][$i]['personImageUrl'] = file_upload_base_url().'users/thumbs/'.$val['profileImage'];
					}
					else
					{
						$new_array['comment'][$i]['personImageUrl'] = "";
					}
					$new_array['comment'][$i]['commentId'] = $val['commentId'];
					$new_array['comment'][$i]['commentText'] = $val['commentText'];
					$new_array['comment'][$i]['commentDate'] = $val['commentDate'];
					$new_array['comment'][$i]['commentId'] = $val['commentId'];
					$new_array['comment'][$i]['commentPersonName'] = $val['firstName'].' '.$val['lastName'];
					$new_array['comment'][$i]['commentPersonId'] = $val['commentPersonId'];
				 $i++;
				}
			}
			else
			{
				$new_array['comment']=array();
			}
		  	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	//$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
	public function getAllBlogComment($id)
	{
		$this->db->select('A.id as commentId,A.comment as commentText,A.created as commentDate,B.firstName,B.lastName,B.profileImage,B.id as commentPersonId');
		$this->db->from('blog_comment as A');
		$this->db->join('users as B','B.id=A.userId');
		$this->db->where('A.blogId',$id);
		return $this->db->get()->result_array();
	}
	public function AddBlogComment($blogId,$commentText,$userId)
	{
			$arr = array('blogId' =>$blogId,'comment'=>$commentText,'userId'=>$userId,'created'=>date("Y-m-d H:i:s"));
				   $this->db->insert('blog_comment',$arr);
			$res = $this->db->insert_id();
			if($res > 0)
			{
				$new_array['commentId'] = $res;
			 	$new_array['statusCode']=200;
			 	$new_array['errorMessage']='';
			 	$new_array['statusMessage']='Done';
			}
			else
			{
				$new_array['commentId'] = 0;
			 	$new_array['statusCode']=404;
			 	$new_array['errorMessage']='error';
			 	$new_array['statusMessage']='';
			}
		return $new_array;
	}
		//////////////////////////////////////////////////////////--------blog-------------////////////////////////////////////////////////
	///////////////////////////////////////////////////////////----checkForUpgrade----- ////////////////////////////////////////////////////
	public function checkForUpgrade($versionCode,$version)
	{
		$this->db->select('*');
		$this->db->from('app_upgrade');
	/*	$this->db->where('versionName',$version);*/
	    $version_data =  $this->db->get()->result_array();
		$data =array();
		if(!empty($version_data))
		{
			if($version_data[0]['versionCode']-$versionCode >= 1)
			{
				$data['isForceUpgrade']=1;
			}
			else
			{
				$data['isForceUpgrade']=0;
			}
			/*if($version_data[0]['versionCode']-$versionCode < 3 && $version_data[0]['versionCode']-$versionCode > 0)
			{
				$data['isUpgrade']=1;
			}
			else
			{
				$data['isUpgrade']=0;
			}*/
			$data['versionCode']=$version_data[0]['versionCode'];
			$data['version']=$version_data[0]['versionName'];
			$data['message']='';
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
			$data['statusCode']=404;
		 	$data['errorMessage']='Error';
		 	$data['statusMessage']='';
		}
	   return $data;
	}
	////////////////////////////////////////////////////--GCM--/////////////////////////////////////////////////
	public function saveGcmToken($gcmToken,$deviceId)
	{
		$data =array();
		$gcmdata = $this->getValue('gcm','deviceId'," `deviceId` = '".$deviceId."'");
		if(!empty($gcmdata))
		{
			$this->db->where('deviceId',$deviceId);
	   	    $res = $this->db->update('gcm',array('gcmToken'=>$gcmToken));
		}
		else
		{
			$arr = array('deviceId' =>$deviceId,'gcmToken'=>$gcmToken,'createDate'=>date("Y-m-d H:i:s"));
			$res = $this->db->insert('gcm',$arr);
		}
		if($res)
		{
			$data['isUpdatedOnServer']=1;
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['isUpdatedOnServer']=0;
			$data['statusCode']=404;
		 	$data['errorMessage']='Field To Update GCM Token';
		 	$data['statusMessage']='';
		}
		 return $data;
	}
	public function sendGcmToken($userId,$msg)
	{
		 define( 'API_ACCESS_KEY', 'AIzaSyCAVHevvPy-yAZUbJdRRF2RLf8DTQcDcGw' );
		 //$registrationIds = array( $_GET['id'] );
		    $deviceId = $this->getValue('users','deviceId'," `id` = '".$userId."'");
			if(isset($deviceId)&&$deviceId!='')
			{
			    $gcmToken = $this->getValue('gcm','gcmToken'," `deviceId` = '".$deviceId."'");
				if(isset($gcmToken)&& $gcmToken!='')
				{
					// prep the bundle
						/*$msg = array
						(
							'message' 	=> 'here is a message. message',
							'title'		=> 'This is a title. title',
							'subtitle'	=> 'This is a subtitle. subtitle',
							'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
							'vibrate'	=> 1,
							'sound'		=> 1,
							'largeIcon'	=> 'large_icon',
							'smallIcon'	=> 'small_icon'
						);*/
						/*    int type,
						    int notificationId,
						    int notificationType,
						    String notificationTitle,
						    String notificationMessage,
						    String notificationImageUrl,*/
						//	print_r($msg);
						  $gcmId = array($gcmToken);
						$fields = array
						(
							'registration_ids' 	=> $gcmId,
							'data'			=>  array('default'=>$msg)
						);
						//print_r($fields);die;
						$headers = array
						(
							'Authorization: key=' . API_ACCESS_KEY,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
						$result = curl_exec($ch );
						curl_close( $ch );
						/*echo $result;die;*/
				}
			}
	       return;
	}
	public function SaveAppError($error)
	{
	    $data = array();
		$arr = array('error'=>$error);
		$res = $this->db->insert('app_error_log',$arr);
		if($res)
		{
			$data['isUpdatedOnServer']=1;
		  	$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['isUpdatedOnServer']=0;
			$data['statusCode']=404;
		 	$data['errorMessage']='Field To Update';
		 	$data['statusMessage']='';
		}
		 return $data;
	}
	public function getSearchResultForJob($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,title,companyLogo as imageUrl');
		$this->db->from('jobs');
        $where .= 'jobs.status = 1';
		if($keyword!=''){
			$where .= " AND ((jobs.title like '%".$keyword."%') OR (jobs.description like '%".$keyword."%') OR (jobs.keySkills like '%".$keyword."%') OR (jobs.education like '%".$keyword."%') OR (jobs.industry like '%".$keyword."%') OR (jobs.function like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->order_by('jobs.created','desc');
	    return $this->db->get()->result_array();
	}
	public function getSearchResultForEvent($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,name as title,banner as imageUrl');
		$this->db->from('events');
		if($keyword!=''){
			$where .= "((name like '%".$keyword."%') OR (description like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	  	return $this->db->get()->result_array();
	}
	public function getSearchResultForProject($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('project_master.id,project_master.projectName as title,user_project_image.image_thumb as imageUrl');
		$this->db->from('project_master');
		if($keyword!=''){
			$where .= "((project_master.projectName like '%".$keyword."%') OR (project_master.projectPageName like '%".$keyword."%') OR (project_master.projectType like '%".$keyword."%') OR (project_master.basicInfo like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('project_master.status !=',0);
		$this->db->join('user_project_image','project_master.id = user_project_image.project_id');
		$this->db->order_by('project_master.created','desc');
	  	return $this->db->get()->result_array();
	}
	public function getSearchResultForCompetition($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,name as title,banner as imageUrl');
		$this->db->from('competitions');
		if($keyword!=''){
			$where .= "((name like '%".$keyword."%') OR (pageName like '%".$keyword."%') OR (description like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	  	return $this->db->get()->result_array();
	}
	public function getSearchResultForPepole($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,CONCAT(firstName," ",lastName) as title,profileImage as imageUrl',FALSE);
		$this->db->from('users');
		if($keyword!=''){
			$where .= "((firstName like '%".$keyword."%') OR (lastName like '%".$keyword."%') OR (company like '%".$keyword."%') OR (about_me like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	  	return $this->db->get()->result_array();
	}
	public function getSearchResultForInstitute($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,instituteName as title,instituteLogo as imageUrl');
		$this->db->from('institute_master');
		if($keyword!=''){
			$where .= "((instituteName like '%".$keyword."%') OR (pageName like '%".$keyword."%') OR (address like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	  	return $this->db->get()->result_array();
	}
	public function getSearchResultForBlog($parameters){
		$keyword = $parameters['keyword'];
		$where='';
		$this->db->select('id,title,picture as imageUrl');
		$this->db->from('blog');
		if($keyword!=''){
			$where .= "((title like '%".$keyword."%') OR (description like '%".$keyword."%') OR (keywords like '%".$keyword."%'))";
		}
		$this->db->where($where);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	  	return $this->db->get()->result_array();
	}
      public function AddAward($award,$awardPrizeNomination,$userId,$awardId,$date)
	{
		 if($awardId > 0)
		 {
 		 	$arr = array('award' =>$award,'prize'=>$awardPrizeNomination,'dateRecieved'=>$date);
 		 	$this->db->where('id',$awardId);
 		 	$this->db->where('user_id',$userId);
 	   	    	$this->db->update('users_award',$arr);
 	   	    	$res = $this->db->affected_rows();
		 }
		 else
		 {
	   	     	$arr = array('award' =>$award,'prize'=>$awardPrizeNomination,'dateRecieved'=>$date,'user_id'=>$userId,'created'=>date("Y-m-d H:i:s"));
	   	    	$this->db->insert('users_award',$arr);
	   	    	$this->db->insert_id();
	   	    	$res = $this->db->affected_rows();
		 }
		if($res==1)
		{
			$new_array['awardId'] = $awardId;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
		}
		else
		{
			$new_array['awardId'] = 0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='No such record found.';
		 	$new_array['statusMessage']='error';
		}
		return $new_array;
	}
      public function DeleteAward($userId,$awardId)
	{
	    $this->db->where('user_id',$userId);
	    $this->db->where('id',$awardId);
		$this->db->delete('users_award');
		$res = $this->db->affected_rows();
		//return $res;
		if($res ==1)
		{
		  	$data['statusCode']=200;
		 	$data['errorMessage']='User Award Deleted Successfully';
		 	$data['statusMessage']='Done';
		}
		else
		{
		 	$data['statusCode']=404;
		 	$data['errorMessage']='No such record found.';
		 	$data['statusMessage']='error';
		}
		 return $data;
	}
	public function userProfileMeter($userId)
	{
		$profileCompletion=0;
		$user_profile = $this->get_where('users',array("id"=>$userId));
		//pr($user_profile);
		$educationData = $this->get_where('users_education',array("user_id"=>$userId));
		$workData = $this->get_where('users_work',array("user_id"=>$userId));
		$skillData = $this->get_where('users_skills',array("user_id"=>$userId));
		$socialData = $this->get_where('social_link',array("user_id"=>$userId));
		/*print_r($socialData);*/
		if($user_profile['firstName']!='' && $user_profile['lastName']!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile['city']!='' && $user_profile['country']!='')
		{
			$profileCompletion = $profileCompletion+15;
		}
		if($user_profile['profession']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile['profileImage']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if($user_profile['about_me']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		if(!empty($skillData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		/*echo $profileCompletion;*/
		if(!empty($workData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		if(!empty($educationData))
		{
			$profileCompletion = $profileCompletion+10;
		}
		/*echo $profileCompletion;*/
		if(isset($socialData['facebook']) && $socialData['facebook']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['twitter']) && $socialData['twitter']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['google']) && $socialData['google']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['pinterest']) && $socialData['pinterest']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['instagram']) && $socialData['instagram']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		elseif(isset($socialData['linkedin']) && $socialData['linkedin']!='')
		{
			$profileCompletion = $profileCompletion+10;
		}
		$insertArray=array('profile_complete'=>$profileCompletion);
		$this->db->where('id', $userId);
		return $this->db->update('users',$insertArray);
	}
public function GetInstanceDetails($userId,$deviceId,$instituteId,$instanceId){
			$this->db->select('q20 as wouldYouLiketoTellAnyonetoJoinOurInstitute,q21 as feedback, institutefeedback.institute_id as instituteId, institutefeedback.instance_id as instanceId, feedback_instance.name as instanceTitle, feedback_instance.start_session as instanceStartDate, feedback_instance.end_session as instanceEndDate');
			$this->db->from('institutefeedback');
			$this->db->join('feedback_instance','feedback_instance.id = institutefeedback.instance_id','left');
			$this->db->where('institutefeedback.user_id', $userId);
			$this->db->where('institutefeedback.institute_id', $instituteId);
			$this->db->where('institutefeedback.instance_id', $instanceId);
			$result =  $this->db->get()->row_array();
			if(!empty($result)){
				if( ($result['instanceStartDate'] <= date("Y-m-d")) && ($result['instanceEndDate'] >= date("Y-m-d")) ){
					$result['instanceStatus']=1;
				}else{
					$result['instanceStatus']=0;
				}
			}
			else
			{
				$this->db->select('name as instanceTitle, start_session as instanceStartDate,end_session as instanceEndDate');
				$this->db->from('feedback_instance');
				$this->db->where('institute_id', $instituteId);
				$this->db->where('id', $instanceId);
				$result =  $this->db->get()->row_array();
			}
			$this->db->select('*');
			$this->db->from('institutefeedback');
			$this->db->where('user_id', $userId);
			$this->db->where('institute_id', $instituteId);
			$this->db->where('instance_id', $instanceId);
			$answer =  $this->db->get()->row_array();
			//print_r($answer);die;
			$questionList = array();
			if(!empty($answer)){
				$questionList[] =  array(
					                           'answer1' => 'Never',
					                           'answer2' => 'Sometimes',
					                           'answer3' => 'Frequently',
					                           'answer4' => 'Mostly',
					                           'question' => 'Did your class ever cancel due to absence of faculty?',
					                           'selectedAnswer' =>$answer['q1']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Were you issued courseware for the module(s) being taught?',
					                           'selectedAnswer' =>$answer['q2']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Do theory classes start and end at right time?',
					                           'selectedAnswer' =>$answer['q3']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Are the modules taken as per the timetable?',
					                           'selectedAnswer' =>$answer['q4']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Does the faculty teach concepts and clear doubts to your satisfaction?',
					                           'selectedAnswer' =>$answer['q5']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Does the theory class get conducted OHP or terminal?',
					                           'selectedAnswer' =>$answer['q6']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Your understanding of the topics covered?',
					                           'selectedAnswer' =>$answer['q7']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Is technical assistance always available in the lab?',
					                           'selectedAnswer' =>$answer['q8']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Are you assisted for the lab exercises given in the courseware?',
					                           'selectedAnswer' =>$answer['q9']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Were you able to workout lab exercises with facultys help in the lab?',
					                           'selectedAnswer' =>$answer['q10']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Do you always get a machine to work during the regular lab hours?',
					                           'selectedAnswer' =>$answer['q11']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Never',
     					                           'answer2' => 'Sometimes',
     					                           'answer3' => 'Frequently',
     					                           'answer4' => 'Mostly',
					                           'question' => 'Have you encountered a problem with respect to the software in the lab?',
					                           'selectedAnswer' =>$answer['q12']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Never',
      					                           'answer2' => 'Sometimes',
      					                           'answer3' => 'Frequently',
      					                           'answer4' => 'Mostly',
					                           'question' => 'Have you encountered a problem with respect to the machine in the lab?',
					                           'selectedAnswer' =>$answer['q13']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Does machine problems get sorted within a stipulated time?',
					                           'selectedAnswer' =>$answer['q14']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Are the assignments and examinations conducted as per the schedule?',
					                           'selectedAnswer' =>$answer['q15']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Are you evaluated after each module (test /assignment/ quiz)?',
					                           'selectedAnswer' =>$answer['q16']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Your satisfaction level with respect to faculty guidance on the project.',
					                           'selectedAnswer' =>$answer['q17']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Mostly',
					                           'answer2' => 'Frequently',
					                           'answer3' => 'Sometimes',
					                           'answer4' => 'Never',
					                           'question' => 'Is the feedback taken from you at least once a month?',
					                           'selectedAnswer' =>$answer['q18']
					                           );
				$questionList[] =  array(
					                           'answer1' => 'Excellent',
					                           'answer2' => 'Good',
					                           'answer3' => 'Average',
					                           'answer4' => 'Fair',
					                           'question' => 'Relevance and adequacy of examples used by the faculty while teaching.',
					                           'selectedAnswer' =>$answer['q19']
					                           );
			}
			$result['questionList'] = $questionList;
			return $result;
		}
public function getValueOnly($table,$getColumn,$conditionArray='',$order_by='',$limit='')
	{
		$this->db->select($getColumn,false);
		$this->db->from($table);
		if($conditionArray!='')
		{
			$this->db->where($conditionArray);
		}
		if($order_by != '')
		{
			$this->db->order_by($order_by[0],$order_by[1]);
		}
		if($limit != '')
		{
			$this->db->limit($limit);
		}
		$result=$this->db->get()->row();
		if(!empty($result))
		{
			return $result->$getColumn;
		}
		else
		{
			return '';
		}
	}
public function GetMyBoardProjectList($userId)
	{
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('user_myboard.myboardUser',$userId);
		//$this->db->where('project_master.status',1);
		$this->db->join('user_myboard', 'user_myboard.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->group_by('project_master.id');
		$this->db->order_by('project_master.created','desc');
		$data      = $this->db->get()->result_array();
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
				{
				    $arr=array();
				    $arr2=array();
				 	foreach($atrribute as $val)
					{
					   //$values = $this->get_attribute_value($val['id']);
					   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
					$data[$i]['atrribute'] = implode(',',$arr);
					$data[$i]['attributeValue'] = implode(',',$arr2);
					$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
			   	}
				else
				{
					$data[$i]['atrribute'] = '';
					$data[$i]['attributeValue'] = '';
					$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				}
				if(empty($data[$i]['rating']))
				{
					$data[$i]['rating']=0.0;
				}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
				{
				  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
				}
				else
				{
					$data[$i]['profileImage'] = "";
				}
				$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
				$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
			    $data[$i]['imageCount'] = $imageCount;
			    $data[$i]['userId'] = $userId;
			    $data[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
			    $data[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
			    $data[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
		    	$i++;
			}
		}
	   if(!empty($data))
		{
		 	$new_array['project']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
public function GetMyStreamProjectList($userids)
	{
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where_in('project_master.userId',$userids);
		$this->db->order_by('project_master.created','desc');
		$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		//print_r($data);die;
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
				{
				    $arr=array();
				    $arr2=array();
				 	foreach($atrribute as $val)
					{
					   //$values = $this->get_attribute_value($val['id']);
					   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
					$data[$i]['atrribute'] = implode(',',$arr);
					$data[$i]['attributeValue'] = implode(',',$arr2);
					$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
			   	}
				else
				{
					$data[$i]['atrribute'] = '';
					$data[$i]['attributeValue'] = '';
					$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				}
				if(empty($data[$i]['rating']))
				{
					$data[$i]['rating']=0.0;
				}
				if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
				{
				  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
				}
				else
				{
					$data[$i]['profileImage'] = "";
				}
				$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
				$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
			    $data[$i]['imageCount'] = $imageCount;
			    $data[$i]['userId'] = $row['projectUserId'];
			    $data[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
			    $data[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
			    $data[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
		    	$i++;
			}
		}
	   if(!empty($data))
		{
		 	$new_array['project']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}
	    	
    public function GetFollowersList($userId,$pageNo,$pageSize,$keyword,$deviceId)
	{
    	$start=($pageNo-1)*$pageSize;
    	$this->db->select('B.id as userId,B.firstname,B.lastname,B.city,B.country,B.profession,B.profileimage');
		$this->db->from('user_follow as A');
		$this->db->join('users as B','B.id=A.userId','left');
	    $this->db->join('project_master as C', 'C.userId = A.userId', 'left');
	    $this->db->join('project_attribute_relation as D', 'D.projectId = C.id', 'left');
	    $this->db->join('project_rating as E', 'E.projectId = C.id', 'left');
	    $this->db->where('B.status',1);
	    $this->db->where('A.followingUser',$userId);
	    $this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->group_by('A.userId');
		if($keyword != '')
		{
			$this->db->where("(B.firstName LIKE '%".$keyword."%'|| B.lastName LIKE '%".$keyword."%'|| B.country LIKE '%".$keyword."%'|| B.city LIKE '%".$keyword."%')");
		}
		
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 if(file_exists(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) > 0 && $data[$i]['profileimage']!='')
				{
				  	$data[$i]['profileimage'] = file_upload_base_url().'users/thumbs/'.$data[$i]['profileimage'];
				}
				else
				{
					$data[$i]['profileimage'] = "";
				}
				if($userId!='-1')
				{
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['userId']);
				    if(!empty($followingOrNot))
					{
						$data[$i]['isfollow'] = 1;
					}
					else
					{
						$data[$i]['isfollow'] = 0;
					}
				}
				else
				{
					$data[$i]['isfollow'] = 0;
				}
			    $proData = $this->getUserProjectData($row['userId']);
			    $data[$i]['projectCount']=$this->model_basic->getCountWhere('project_master',array('userId'=>$row['userId']));
				$likeCount    = 0;
				$viewCount    = 0;
				foreach($proData as $val)
				{
					$likeCount = $val['like_cnt'] + $likeCount;
					$viewCount = $val['view_cnt'] + $viewCount;
				}
				$data[$i]['likeCount'] = $likeCount;
				$data[$i]['viewCount'] = $viewCount;
		        $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['peopleList']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function GetFollowingsList($userId,$pageNo,$pageSize,$keyword,$deviceId)
	{
    	$start=($pageNo-1)*$pageSize;
    	$this->db->select('B.id as userId,B.firstname,B.lastname,B.city,B.country,B.profession,B.profileimage');
		$this->db->from('user_follow as A');
		$this->db->join('users as B','B.id=A.followingUser','left');
	    $this->db->join('project_master as C', 'C.userId = A.userId', 'left');
	    $this->db->join('project_attribute_relation as D', 'D.projectId = C.id', 'left');
	    $this->db->join('project_rating as E', 'E.projectId = C.id', 'left');
	    $this->db->where('B.status',1);
	    $this->db->where('A.userId',$userId);
	    $this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->group_by('B.id');
		if($keyword != '')
		{
			$this->db->where("(B.firstName LIKE '%".$keyword."%'|| B.lastName LIKE '%".$keyword."%'|| B.country LIKE '%".$keyword."%'|| B.city LIKE '%".$keyword."%')");
		}
		
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 if(file_exists(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) > 0 && $data[$i]['profileimage']!='')
				{
				  	$data[$i]['profileimage'] = file_upload_base_url().'users/thumbs/'.$data[$i]['profileimage'];
				}
				else
				{
					$data[$i]['profileimage'] = "";
				}
				if($userId!='-1')
				{
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['userId']);
				    if(!empty($followingOrNot))
					{
						$data[$i]['isfollow'] = 1;
					}
					else
					{
						$data[$i]['isfollow'] = 0;
					}
				}
				else
				{
					$data[$i]['isfollow'] = 0;
				}
			    $proData = $this->getUserProjectData($row['userId']);
			    $data[$i]['projectCount']=$this->model_basic->getCountWhere('project_master',array('userId'=>$row['userId']));
				$likeCount    = 0;
				$viewCount    = 0;
				foreach($proData as $val)
				{
					$likeCount = $val['like_cnt'] + $likeCount;
					$viewCount = $val['view_cnt'] + $viewCount;
				}
				$data[$i]['likeCount'] = $likeCount;
				$data[$i]['viewCount'] = $viewCount;
		        $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['peopleList']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function GetProjectLikeList($projectId,$pageNo,$pageSize,$keyword,$deviceId,$userId )
	{
    	$start=($pageNo-1)*$pageSize;
    	$this->db->select('B.id as userId,B.firstname,B.lastname,B.city,B.country,B.profession,B.profileimage');
		$this->db->from('user_project_views as A');
		$this->db->join('users as B','B.id=A.userId','left');
	    $this->db->join('project_master as C', 'C.userId = A.userId', 'left');
	    $this->db->join('project_attribute_relation as D', 'D.projectId = C.id', 'left');
	    $this->db->join('project_rating as E', 'E.projectId = C.id', 'left');
	    $this->db->where('B.status',1);
	    $this->db->where('A.projectId',$projectId);
$this->db->where('A.userLike',1);
	    $this->db->limit($pageSize);
		$this->db->offset($start);
		$this->db->group_by('A.userId');
		if($keyword != '')
		{
			$this->db->where("(B.firstName LIKE '%".$keyword."%'|| B.lastName LIKE '%".$keyword."%'|| B.country LIKE '%".$keyword."%'|| B.city LIKE '%".$keyword."%')");
		}
		
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 if(file_exists(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) > 0 && $data[$i]['profileimage']!='')
				{
				  	$data[$i]['profileimage'] = file_upload_base_url().'users/thumbs/'.$data[$i]['profileimage'];
				}
				else
				{
					$data[$i]['profileimage'] = "";
				}
				if($userId !='-1')
				{
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['userId']);
				    if(!empty($followingOrNot))
					{
						$data[$i]['isfollow'] = 1;
					}
					else
					{
						$data[$i]['isfollow'] = 0;
					}
				}
				else
				{
					$data[$i]['isfollow'] = 0;
				}
			    $proData = $this->getUserProjectData($row['userId']);
			    $data[$i]['projectCount']=$this->model_basic->getCountWhere('project_master',array('userId'=>$row['userId']));
				/*$likeCount    = 0;
				$viewCount    = 0;
				foreach($proData as $val)
				{
					$likeCount = $val['like_cnt'] + $likeCount;
					$viewCount = $val['view_cnt'] + $viewCount;
				}*/
				/*$data[$i]['likeCount'] = $likeCount;
				$data[$i]['viewCount'] = $viewCount;*/
				$data[$i]['likeCount'] = $this->model_basic->getCountWhere('user_project_views',array('projectId'=>$projectId,'userLike'=>1));
				$data[$i]['viewCount'] = $this->model_basic->getCountWhere('user_project_views',array('projectId'=>$projectId,'userView'=>1));
		        $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['peopleList']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

     public function UpdateProjectStatus($projectId,$userId,$status,$admin_status='')
	{
    	$this->load->model('model_basic');
    	if($status==1)
    	{
    		$instituteIdOfUser=$this->model_basic->getValueArray('users','instituteId',array('id'=>$userId),$order_by='',$limit='');
    		$admin_flag=$this->model_basic->getValueArray('institute_master','admin_status',array('id'=>$instituteIdOfUser),$order_by='',$limit='');
    		if($admin_flag == 1)
    		{
    			$status       = 3;
    			$admin_status = 0;
    			$retMsg='Project added and admin approval required to make this project public till then your project status change to private successfully.';
    		}
    		else
    		{
    			$status       = 1;
    			$admin_status = '';
    		}
    	}
    	$data = $this->model_basic->_updateWhere('project_master',array('id'=>$projectId,'userId'=>$userId),array('status'=>$status,'admin_status'=>$admin_status));
	   if($data !='')
		{
		 	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	if(isset($retMsg))
		 	{
		 		$new_array['statusMessage']=$retMsg;
		 	}
else
{
$new_array['statusMessage']='';
}
		 	
	    }
	    else
	    {
	     	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

	public function GetAllUserProject($userId)
	{
		$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,project_master.status as projectPublishStatus,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,project_master.admin_status as adminStatus');
		$this->db->from('project_master');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
		$this->db->where('project_master.userId',$userId);
		$this->db->where('project_master.status !=',2);
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		//print_r($data);die;
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
			{
					    $arr=array();
					    $arr2=array();
					 	foreach($atrribute as $val)
						{
						   //$values = $this->get_attribute_value($val['id']);
						   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
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
						$data[$i]['atrribute'] = implode(',',$arr);
						$data[$i]['attributeValue'] = implode(',',$arr2);
						$data[$i]['categoryName'] = $atrribute[0]['categoryName'];
				   	}
					else
					{
						$data[$i]['atrribute'] = '';
						$data[$i]['attributeValue'] = '';
						$data[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
					}
					if(empty($data[$i]['rating']))
					{
						$data[$i]['rating']=0.0;
					}
					if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
					{
					  	$data[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
					}
					else
					{
						$data[$i]['profileImage'] = "";
					}
					$data[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
					$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
				    $data[$i]['imageCount'] = $imageCount;
				    $data[$i]['userId'] = $userId;$ableToDelete=$this->model_basic->getData('project_master','assignmentId,competitionId',array('id'=>$row['projectId'],'userId'=>$userId));
				    $data[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
				    $data[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
				    $data[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
				    if($ableToDelete['assignmentId'] > 0 || $ableToDelete['competitionId'] > 0)
				    {
				    	$data[$i]['isAbleToDelete'] ='false';
				    }
				    else
				    {
				    	$data[$i]['isAbleToDelete'] ='true';
				    }
			    $i++;
			 }
		}
	   if(!empty($data))
		{
		 	$new_array['project']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['project']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
	}

    public function ChangeProjectImage($userId,$projectId,$imageId,$bitmapString)
	{
    	$data = array();
  	 	$today = date("Y_m_d_H_i_s");
  	 	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$shuffled = str_shuffle($str);
	 	$binary=base64_decode($bitmapString);
	    header('Content-Type: bitmap; charset=utf-8');
	    $file = fopen(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg', 'w');
	    fwrite($file, $binary);
	    fclose($file);
	    $this->ImageCropMaster('307','310',file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumbs/'.$today.$shuffled.'.jpg');
	    $heightWidth = getimagesize(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg');
	    $bigThumbWidth=(960 * $heightWidth[1])/$heightWidth[0];
	    $this->ImageCropMaster('960',$bigThumbWidth,file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumb_big/'.$today.$shuffled.'.jpg');
		$previousImage = $this->getValue('user_project_image',"image_thumb","id=".$imageId);
		if($previousImage!='')
		{
			if(file_exists(file_upload_s3_path().'project/thumb_big/'.$previousImage))
			{
				@unlink(file_upload_s3_path().'project/thumb_big/'.$previousImage);
			}
			if(file_exists(file_upload_s3_path().'project/thumbs/'.$previousImage))
			{
				@unlink(file_upload_s3_path().'project/thumbs/'.$previousImage);
			}
			if(file_exists(file_upload_s3_path().'project/'.$previousImage))
			{
				@unlink(file_upload_s3_path().'project/'.$previousImage);
			}
		}
		$res =  $this->_update('user_project_image','id',$imageId,array('image_thumb'=>$today.$shuffled.'.jpg'));
		if($res > 0)
		{
			$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
			$data['statusCode']=404;
		 	$data['errorMessage']='Faild to update image.';
		 	$data['statusMessage']='Try again please';
		}
	 	return $data;
    } 

    public function RemoveProjectImage($userId,$projectId,$imageId)
	{
		$previousImage = $this->getValue('user_project_image',"image_thumb","id=".$imageId);
		$res = $this->db->delete('user_project_image', array('id' => $imageId));
		if($res > 0)
		{
			if($previousImage!='')
			{
				if(file_exists(file_upload_s3_path().'project/thumb_big/'.$previousImage))
				{
					@unlink(file_upload_s3_path().'project/thumb_big/'.$previousImage);
				}
				if(file_exists(file_upload_s3_path().'project/thumbs/'.$previousImage))
				{
					@unlink(file_upload_s3_path().'project/thumbs/'.$previousImage);
				}
				if(file_exists(file_upload_s3_path().'project/'.$previousImage))
				{
					@unlink(file_upload_s3_path().'project/'.$previousImage);
				}
			}
			$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
			$data['statusCode']=404;
		 	$data['errorMessage']='Faild to delete image.';
		 	$data['statusMessage']='Try again please';
		}
	 	return $data;
    }
public function AddProjectImage($userId,$projectId,$bitmapString)
	{
    	$data = array();
  	 	$today = date("Y_m_d_H_i_s");
  	 	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$shuffled = str_shuffle($str);
	 	$binary=base64_decode($bitmapString);
	    header('Content-Type: bitmap; charset=utf-8');
	    $file = fopen(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg', 'w');
	    fwrite($file, $binary);
	    fclose($file);
	    $this->ImageCropMaster('307','310',file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumbs/'.$today.$shuffled.'.jpg');
	    $heightWidth = getimagesize(file_upload_s3_path().'project/'.$today.$shuffled.'.jpg');
	    $bigThumbWidth=(960 * $heightWidth[1])/$heightWidth[0];
	    $this->ImageCropMaster('960',$bigThumbWidth,file_upload_s3_path().'project/'.$today.$shuffled.'.jpg',file_upload_s3_path().'project/thumb_big/'.$today.$shuffled.'.jpg');
		$this->db->insert('user_project_image',array('image_thumb'=>$today.$shuffled.'.jpg','project_id'=>$projectId,'status'=>1));
		$res = $this->db->insert_id();
		if($res > 0)
		{
			$data['statusCode']=200;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='Done';
		}
		else
		{
			$data['statusCode']=404;
		 	$data['errorMessage']='Faild to add image.';
		 	$data['statusMessage']='Try again please';
		}
	 	return $data;
    } 

    public function EditProject($projectId,$userId,$deviceId,$projectName,$projectType,$projectStatus,$projectPublish,$category,$videoLink,$coverPicImageId,$thoughtProcess,$socialFeatures,$description,$keyword,$copyrightSetting)
	{
$categoryData = $this->findCategoryId($category);
	    if(!empty($categoryData))
		{
				$categoryId      = $categoryData[0]['id'];
				$requiresFunding = 0;
				$projectPageName = $this->generateProjectPageName($projectName,$userId);
				$data = array('projectName'=>$projectName,'projectPageName'=>$projectPageName,'basicInfo'=>$description,'categoryId'=>$categoryId,'projectType'=>$projectType,'requiresFunding'=>$requiresFunding,'socialFeatures'=>$socialFeatures,'projectStatus'=>$projectStatus,'created'=>date('Y-m-d H:i:s'), 'userId'=>$userId,'videoLink'=>$videoLink, 'thought'=>$thoughtProcess, 'keyword'=>$keyword, 'copyright'=> $copyrightSetting);

				$this->_update('project_master','id',$projectId,$data);
				if($projectId > 0)
				{
					    $title = $this->getValue('project_master',"projectName"," `id` = '".$projectId."' ");
						/*if($projectPublish == 0)
						{
							$status       = 0;
							$admin_status = '';
						}
						elseif($projectPublish == 3)
						{
							$status       = 3;
							$admin_status = '';
						}
						else
						{
							$status       = 1;
							$admin_status = '';
						}*/
						$res=$projectId;
						/*if($res > 0)
						{
							  
							if(isset($admin_flag)&&!empty($admin_flag))
							{
								$st = array('status'=>$status,'admin_status'=>$admin_status);
							}
							else
							{
								$st = array('status' =>$status,'admin_status'=>$admin_status);
							}
							$this->update_project_status($projectId,$st);
						}*/
if($coverPicImageId !='' && $coverPicImageId > 0)
{
$oldCoverPicImageId=$this->getValueOnly('user_project_image','id',array('project_id'=>$projectId, 'cover_pic'=>1));
if($oldCoverPicImageId != $coverPicImageId)
{
$this->_update('user_project_image','id',$oldCoverPicImageId,array('cover_pic'=>0));
$this->_update('user_project_image','id',$coverPicImageId,array('cover_pic'=>1));
}
}
				 	$new_array['statusCode']=200;
				 	$new_array['errorMessage']='';
				 	$new_array['statusMessage']='Done';
			    }
				else
				{
				 	$new_array['statusCode']=404;
				 	$new_array['errorMessage']='error';
				 	$new_array['statusMessage']='';
				}
		}
		else
		{
			$new_array['projectId'] = 0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='error';
		 	$new_array['statusMessage']='';
		}
		return $new_array;
    }
public function AcceptTermsAndConditions($userId,$deviceId)
	{
    	$this->load->model('model_basic');
    	$res = $this->model_basic->_insert('terms_and_conditions',array('user_id'=>$userId,'ip_address'=>$deviceId,'accepted_date'=>date('Y-m-d H:i:s')));
	   if($res > 0)
		{
		 	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

public function UpdateCommentStatus($userId,$commentId,$commentStatus)
	{
    	$this->load->model('model_basic');
    	$res = $this->model_basic->_updateWhere('user_project_comment',array('id'=>$commentId),array('status'=>$commentStatus));
	   if($res > 0)
		{
		 	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }
public function SaveUserType($userId,$deviceId,$userType)
	{
    	$this->load->model('model_basic');
    	$res = $this->model_basic->_updateWhere('users',array('id'=>$userId),array('type'=>$userType));
	   if($res > 0)
		{
		 	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function GetAssignmentList($userId,$deviceId,$instituteId)
    {
    	$this->db->select('assignment.id as assignmentId,assignment.teacher_id as teacherId,assignment.assignment_name as assignmentName,assignment.start_date as startDate,assignment.end_date as endDate,assignment.created as postedOnDate,assignment.description as description');
    	$this->db->from('assignment');
    	$this->db->join('user_assignment_relation','user_assignment_relation.assignment_id=assignment.id');
    	$this->db->where('user_assignment_relation.user_id',$userId);
    	$this->db->order_by('assignment.id','DESC');
    	$data=$this->db->get()->result_array();
    	if(!empty($data))
    	{
	    	foreach($data as $dt)
	    	{
	    		$dt['assignmentId']=(int) $dt['assignmentId'];
	    		$dt['teacherId']=(int) $dt['teacherId'];

	    		$dt['assignmentImageUrl']=base_url().'assets/img/as.png';
	    		$dt['submitedProjectId']=$this->getValueOnly('project_master','id',array('assignmentId'=>$dt['assignmentId'], 'userId'=>$userId));
	    		if($dt['submitedProjectId']!='')
	    		{
	    			$assignment_status=$this->getValueOnly('project_master','assignment_status',array('assignmentId'=>$dt['assignmentId'], 'userId'=>$userId));
	    			$createdProjectDate=$this->getValueOnly('project_master','created',array('assignmentId'=>$dt['assignmentId'], 'userId'=>$userId));
	    			$createdProjectDate=date('Y-m-d',strtotime($createdProjectDate));
	    			if($assignment_status==1)
	    			{
	    				$dt['submitedStatus']='Submitted';
	    			}
	    			if($assignment_status==2)
	    			{
	    				$dt['submitedStatus']='Pending';
	    			}
	    			if($assignment_status==3)
	    			{
	    				$dt['submitedStatus']='Accepted';
	    			}
	    			if($assignment_status==4)
	    			{
	    				$dt['submitedStatus']='Resubmitted';
	    			}
	    			$dt['submitedProjectId']=(int) $dt['submitedProjectId'];
	    			if($createdProjectDate > $dt['endDate'])
	    			{
	    				$dt['submitedStatusMessage']='Late submission for this assignment.';
	    			}
	    			else
	    			{
	    				$dt['submitedStatusMessage']='';
	    			}
	    		}
	    		else
	    		{
	    			$dt['submitedProjectId']=0;
	    			$dt['submitedStatus']='Assigned';
	    			if($dt['endDate']==date('Y-m-d'))
	    			{
	    				$dt['submitedStatusMessage']='Today is the last day to submit this Assignment.';
	    			}
	    			elseif($dt['endDate'] < date('Y-m-d'))
	    			{
	    				$dt['submitedStatusMessage']='You have not submitted this assignment.';
	    			}
	    			else
	    			{
	    				$dt['submitedStatusMessage']='';
	    			}
	    		}
	    		$dt['assignedStatus']=1;
	    		$allass[]=$dt;
	    	}
	    	$ass['assignmentList']=$allass;
	    	$ass['statusCode']=200;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	else
    	{
	    	$ass['assignmentList']=array();
	    	$ass['statusCode']=404;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	return $ass;
    }

    public function GetAssignmentDetail($userId,$assignmentId,$deviceId,$instituteId)
    {
    	$this->db->select('assignment.id as assignmentId,assignment.teacher_id as teacherId,assignment.assignment_name as assignmentName,assignment.start_date as startDate,assignment.end_date as endDate,assignment.created as postedOnDate,assignment.description as description');
    	$this->db->from('assignment');
    	//$this->db->join('user_assignment_relation','user_assignment_relation.assignment_id=assignment.id');
    	//$this->db->where('user_assignment_relation.user_id',$userId);
    	$this->db->where('assignment.id',$assignmentId);
    	$data=$this->db->get()->result_array();
    	if(!empty($data))
    	{
	    	foreach($data as $dt)
	    	{
	    		$dt['assignmentId']=(int) $dt['assignmentId'];
	    		$dt['teacherId']=(int) $dt['teacherId'];
	    		$dt['assignmentImageUrl']=base_url().'assets/img/as.png';
	    		$firstName=$this->getValueOnly('users','firstName',array('id'=>$dt['teacherId']));
	    		$lastName=$this->getValueOnly('users','lastName',array('id'=>$dt['teacherId']));
	    		$dt['teacherName']=$firstName.' '.$lastName;
	    		$tools=$this->db->select('B.attributeValue')->from('assignment_tools_relation as A')->join('attribute_value_master as B','B.id = A.attribute_tools_id')->where('A.assignment_id',$assignmentId)->get()->result_array();
	    		$j=count($tools);
	    		$i=1;
	    		$dt['tools']='';
    			if(!empty($tools))
    			{
    				foreach ($tools as $singleTool) 
    				{
    					$dt['tools'].= $singleTool['attributeValue'];
    					if($i < $j)
    					{
    						$dt['tools'].= ', ';
    					}
    					$i++;
    				}
    			}
	    		$features=$this->db->select('B.attributeValue')->from('assignment_features_relation as A')->join('attribute_value_master as B','B.id = A.attribute_features_id')->where('A.assignment_id',$assignmentId)->get()->result_array();
	    		$k=count($features);
	    		$l=1;
	    		$dt['features']='';
    			if(!empty($features))
    			{
    				foreach ($features as $singleFeature) 
    				{
    					$dt['features'].= $singleFeature['attributeValue'];
    					if($l < $k)
    					{
    						$dt['features'].= ', ';
    					}
    					$l++;
    				}
    			}
	    		$dt['submitedProjectId']=$this->getValueOnly('project_master','id',array('assignmentId'=>$dt['assignmentId'], 'userId'=>$userId));
	    		if($dt['submitedProjectId']!='')
	    		{
	    			$assignment_status=$this->getValueOnly('project_master','assignment_status',array('assignmentId'=>$dt['assignmentId'], 'userId'=>$userId));
	    			if($assignment_status==1)
	    			{
	    				$dt['submitedStatus']='Submitted';
	    			}
	    			if($assignment_status==2)
	    			{
	    				$dt['submitedStatus']='Pending';
	    			}
	    			if($assignment_status==3)
	    			{
	    				$dt['submitedStatus']='Accepted';
	    			}
	    			if($assignment_status==4)
	    			{
	    				$dt['submitedStatus']='Resubmitted';
	    			}
	    			$dt['submitedProjectId']=(int) $dt['submitedProjectId'];
	    		}
	    		else
	    		{
	    			$dt['submitedProjectId']=0;
	    			$dt['submitedStatus']='Assigned';
	    		}
	    		$dt['assignedStatus']=$assignment_status;
	    	}
			$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,project_master.assignment_status as assignmentProjectSubmitStatus');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
			$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
			$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
			$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
			$this->db->group_by('project_master.id');
			$this->db->where('project_master.assignmentId',$assignmentId);
			$this->db->where('project_master.userId',$userId);
		    $myAssProject = $this->db->get()->result_array();
			if(!empty($myAssProject))
			{ 
				$i=0;
				 foreach($myAssProject as $row)
				 {
				 	$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
					$this->db->from('category_master');
					$this->db->where('category_master.id',$row['categoryId']);
				    $this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
					$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				 	$atrribute = $this->db->get()->result_array();
		      if(!empty($atrribute))
				{
						    $arr=array();
						    $arr2=array();
						 	foreach($atrribute as $val)
							{
							   $values = $this->get_project_attribute_value($row['projectId'],$val['id']);
							   if(count($values) > 0)
							   {
							   	 $arr[] = $val['attributeName'];
							   }
							   if(!empty($values))
							   {
							   	 foreach($values as $dts)
							   	 {
								 	$arr2[] = $dts['attributeValue'];
								 }
							   }
							}
							$myAssProject[$i]['atrribute'] = implode(',',$arr);
							$myAssProject[$i]['attributeValue'] = implode(',',$arr2);
							$myAssProject[$i]['categoryName'] = $atrribute[0]['categoryName'];
					   	}
						else
						{
							$myAssProject[$i]['atrribute'] = '';
							$myAssProject[$i]['attributeValue'] = '';
							$myAssProject[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$myAssProject[$i]['categoryId']."'");
						}
						if(empty($myAssProject[$i]['rating']))
						{
							$myAssProject[$i]['rating']=0.0;
						}
						if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0 && $row['profileImage']!='')
						{
						  	$myAssProject[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$row['profileImage'];
						}
						else
						{
							$myAssProject[$i]['profileImage'] = "";
						}
						$myAssProject[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$row['thumbImage'];
						$imageCount = $this->getCount('user_project_image','project_id',$row['projectId']);
					    $myAssProject[$i]['imageCount'] = (int) $imageCount;
					    $myAssProject[$i]['userId'] = (int) $userId;
					    $myAssProject[$i]['projectUserId'] = (int) $myAssProject[$i]['projectUserId'];
					    $myAssProject[$i]['projectId'] = (int) $myAssProject[$i]['projectId'];
					    $myAssProject[$i]['categoryId'] = (int) $myAssProject[$i]['categoryId'];
					    $myAssProject[$i]['projectStatus'] = (int) $myAssProject[$i]['projectStatus'];
					    $myAssProject[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$row['projectId'],'assignmentId'=>0,'status'=>1));
					    $myAssProject[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userLike'=>1));
					    $myAssProject[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$row['projectId'],'userView'=>1));
				    	if($myAssProject[$i]['assignmentProjectSubmitStatus']==0)
				    	{
				    		$myAssProject[$i]['assignmentProjectSubmitStatus']='Assigned';
				    	}
				    	if($myAssProject[$i]['assignmentProjectSubmitStatus']==1)
				    	{
				    		$myAssProject[$i]['assignmentProjectSubmitStatus']='Submitted';
				    	}
				    	if($myAssProject[$i]['assignmentProjectSubmitStatus']==2)
				    	{
				    		$myAssProject[$i]['assignmentProjectSubmitStatus']=='Pending';
				    	}
				    	if($myAssProject[$i]['assignmentProjectSubmitStatus']==3)
				    	{
				    		$myAssProject[$i]['assignmentProjectSubmitStatus']='Accepted';
				    	}
				    	if($myAssProject[$i]['assignmentProjectSubmitStatus']==4)
				    	{
				    		$myAssProject[$i]['assignmentProjectSubmitStatus']='Resubmitted';
				    	}
				    $i++;
				 }
			}
		    $dt['myAssignmentProjectList'] = $myAssProject;
	    	$this->db->select('project_master.userId as projectUserId,project_master.projectName,project_master.id as projectId,users.firstName,users.lastName,users.profileImage,user_project_image.image_thumb as thumbImage,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,project_master.comment_cnt as commentCount,project_attribute_relation.rating_avg as rating,project_master.categoryId,project_master.projectStatus,users.profession as designation,project_master.assignment_status as assignmentProjectSubmitStatus');
	    	$this->db->from('project_master');
	    	$this->db->where('user_project_image.cover_pic',1);
	    	$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
	    	$this->db->join('users', 'users.id = project_master.userId');
	    	$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id','left');
	    	$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
	    	$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId','left');
	    	$this->db->group_by('project_master.id');
	    	$this->db->where('project_master.assignmentId',$assignmentId);
	    	$this->db->where('project_master.userId !=',$userId);
	        $allAssProject = $this->db->get()->result_array();
	    	if(!empty($allAssProject))
	    	{ 
	    		$i=0;
	    		 foreach($allAssProject as $rowAll)
	    		 {
	    		 	$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName');
	    			$this->db->from('category_master');
	    			$this->db->where('category_master.id',$rowAll['categoryId']);
	    		    $this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
	    			$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
	    		 	$atrributeAll = $this->db->get()->result_array();
	          	if(!empty($atrributeAll))
	    		{
	    				    $arrAll=array();
	    				    $arr2All=array();
	    				 	foreach($atrributeAll as $valAll)
	    					{
	    					   $valuesAll = $this->get_project_attribute_value($rowAll['projectId'],$valAll['id']);
	    					   if(count($valuesAll) > 0)
	    					   {
	    					   	 $arrAll[] = $valAll['attributeName'];
	    					   }
	    					   if(!empty($valuesAll))
	    					   {
	    					   	 foreach($valuesAll as $dtAll)
	    					   	 {
	    						 	$arr2All[] = $dtAll['attributeValue'];
	    						 }
	    					   }
	    					}
	    					$allAssProject[$i]['atrribute'] = implode(',',$arrAll);
	    					$allAssProject[$i]['attributeValue'] = implode(',',$arr2All);
	    					$allAssProject[$i]['categoryName'] = $atrributeAll[0]['categoryName'];
	    			   	}
	    				else
	    				{
	    					$allAssProject[$i]['atrribute'] = '';
	    					$allAssProject[$i]['attributeValue'] = '';
	    					$allAssProject[$i]['categoryName'] = $this->model_basic->getValue('category_master','categoryName'," `id` = '".$allAssProject[$i]['categoryId']."'");
	    				}
	    				if(empty($allAssProject[$i]['rating']))
	    				{
	    					$allAssProject[$i]['rating']=0.0;
	    				}
	    				if(file_exists(file_upload_s3_path().'users/thumbs/'.$rowAll['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$rowAll['profileImage']) > 0 && $rowAll['profileImage']!='')
	    				{
	    				  	$allAssProject[$i]['profileImage'] = file_upload_base_url().'users/thumbs/'.$rowAll['profileImage'];
	    				}
	    				else
	    				{
	    					$allAssProject[$i]['profileImage'] = "";
	    				}
	    				$allAssProject[$i]['thumbImage'] = file_upload_base_url().'project/thumbs/'.$rowAll['thumbImage'];
	    				$imageCountAll = $this->getCount('user_project_image','project_id',$rowAll['projectId']);
	    			    $allAssProject[$i]['imageCount'] = (int) $imageCountAll;
	    			    $allAssProject[$i]['userId'] = (int) $userId;
	    			    $allAssProject[$i]['projectUserId'] = (int) $allAssProject[$i]['projectUserId'];
	    			    $allAssProject[$i]['projectId'] = (int) $allAssProject[$i]['projectId'];
	    			    $allAssProject[$i]['categoryId'] = (int) $allAssProject[$i]['categoryId'];
	    			    $allAssProject[$i]['projectStatus'] = (int) $allAssProject[$i]['projectStatus'];
	    			    $allAssProject[$i]['commentCount']=$this->model_basic->getCountWhere('user_project_comment',array('projectId'=>$rowAll['projectId'],'assignmentId'=>0,'status'=>1));
	    			    $allAssProject[$i]['likeCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$rowAll['projectId'],'userLike'=>1));
	    			    $allAssProject[$i]['viewCount']=$this->model_basic->getCountWhere('user_project_views',array('projectId'=>$rowAll['projectId'],'userView'=>1));
	    			    if($allAssProject[$i]['assignmentProjectSubmitStatus']==0)
	    			    {
	    			    	$allAssProject[$i]['assignmentProjectSubmitStatus']='Assigned';
	    			    }
	    			    if($allAssProject[$i]['assignmentProjectSubmitStatus']==1)
	    			    {
	    			    	$allAssProject[$i]['assignmentProjectSubmitStatus']='Submitted';
	    			    }
	    			    if($allAssProject[$i]['assignmentProjectSubmitStatus']==2)
	    			    {
	    			    	$allAssProject[$i]['assignmentProjectSubmitStatus']='Pending';
	    			    }
	    			    if($allAssProject[$i]['assignmentProjectSubmitStatus']==3)
	    			    {
	    			    	$allAssProject[$i]['assignmentProjectSubmitStatus']='Accepted';
	    			    }
	    			    if($allAssProject[$i]['assignmentProjectSubmitStatus']==4)
	    			    {
	    			    	$allAssProject[$i]['assignmentProjectSubmitStatus']='Resubmitted';
	    			    }
	    		    $i++;
	    		 }
	    	}
	        $dt['submitedAssignmentProjectList'] = $allAssProject;
	    	$dt['statusCode']=200;
		 	$dt['errorMessage']='';
		 	$dt['statusMessage']='Done';
    	}
    	else
    	{
	    	$dt['statusCode']=404;
		 	$dt['errorMessage']='';
		 	$dt['statusMessage']='Done';
    	}
    	return $dt;
    }

    public function SubmitAssignment($userId,$deviceId,$instituteId,$projectId,$assignmentId,$comment)
    {
    	$isAlreadySubmitted=$this->getValueOnly('project_master','id',array('id'=>$projectId,'assignmentId'=>$assignmentId,'userId'=>$userId));
    	//echo $userId;echo "string";echo $projectId;echo "string";echo $assignmentId;echo "string";echo $isAlreadySubmitted;die;
    	if($isAlreadySubmitted !='')
    	{
    		$res = $this->model_basic->_updateWhere('project_master',array('assignmentId'=>$assignmentId,'id'=>$projectId,'userId'=>$userId),array('assignment_status'=>4));
    		$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
    		$com = $this->model_basic->_insert('user_project_comment',array('projectId'=>$projectId,'userId'=>$userId,'name'=>$get_user_data['firstName'].' '.$get_user_data['lastName'],'email'=>$get_user_data['email'],'comment'=>$comment,'read'=>0,'status'=>1,'created'=>date('Y-m-d H:i:s'),'assignmentId'=>$assignmentId));
    		$newAddedPrjectName=$this->getValueOnly('project_master','projectName',array('id'=>$projectId));
    		$projectPageName=$this->getValueOnly('project_master','projectPageName',array('id'=>$projectId));
    		$userImage=$this->getValueOnly('users','profileImage',array('id'=>$userId));
    		
    		$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignmentId));
    		$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));
    		$message='Hello Sir,<br /> Assignment has been Re-submitted .<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br />  Thank You.';	
    		$emailData = array('to'=>$get_teacher_data['email'],'fromEmail'=>$get_user_data['email'],'subject'=>'Assignment has been re -submitted to you','template'=>$message);	  
    		$sendMail = $this->model_basic->sendMail($emailData);
    		$assEditNotificationEntry=array('title'=>'Assignment re-submitted','msg'=>$get_user_data['firstName'].' '.$get_user_data['lastName'].' re-submitted assignment project '.$newAddedPrjectName.' for assignment that you assigned to him.','link'=>'projectDetail/'.$projectPageName.'/1','imageLink'=>'users/thumbs/'.$userImage,'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$assignmentId);
    		$assNotificationId=$this->model_basic->_insert('header_notification_master',$assEditNotificationEntry);
    		$notificationToTeacher=array('notification_id'=>$assNotificationId,'user_id'=>$get_assignment_data['teacher_id']);
    		$this->model_basic->_insert('header_notification_user_relation',$notificationToTeacher);
    	}
	   	else
		{
			//echo "string";die;
			$res = $this->model_basic->_updateWhere('project_master',array('id'=>$projectId,'userId'=>$userId),array('assignmentId'=>$assignmentId,'assignment_status'=>1));
		 	$newAddedPrjectName=$this->getValueOnly('project_master','projectName',array('id'=>$projectId));
		 	$projectPageName=$this->getValueOnly('project_master','projectPageName',array('id'=>$projectId));
		 	$userImage=$this->getValueOnly('users','profileImage',array('id'=>$userId));
		 	$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
		 	$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignmentId));
		 	$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));
		 	$message='Hello Sir,<br /> New assignment has been submitted <br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';	
		 	$emailData = array('to'=>$get_teacher_data['email'],'fromEmail'=>$get_user_data['email'],'subject'=>'Assignment has been submitted to you','template'=>$message);	  
		 	$sendMail = $this->model_basic->sendMail($emailData);
		 	$assNotificationEntry=array('title'=>'New assignment project submitted','msg'=>$get_user_data['firstName'].' '.$get_user_data['lastName'].' submitted new  project '.$newAddedPrjectName.' for assignment that you assigned to him. ','link'=>'projectDetail/'.$projectPageName.'/1','imageLink'=>'users/thumbs/'.$userImage,'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$assignmentId);
		 	$assNotificationId=$this->model_basic->_insert('header_notification_master',$assNotificationEntry);
		 	$notificationToTeacher=array('notification_id'=>$assNotificationId,'user_id'=>$get_assignment_data['teacher_id']);
		 	$this->model_basic->_insert('header_notification_user_relation',$notificationToTeacher);
	    }
	    if($res > 0)
	    {
	    	$new_array['statusCode']=200;
	    	$new_array['errorMessage']='';
	    	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function MyInstitutePeopleList($userId,$deviceId,$instituteId)
    {
    	$this->db->select('A.id as userId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS projectCount');
		$this->db->from('users as A');
	    $this->db->where('A.status',1);
	    $this->db->where('A.instituteId',$instituteId);
        if($userId!='-1')
    	{
    	  	$this->db->where('A.id !=',$userId);
    	}
		$this->db->order_by('projectCount','desc');
	    $this->db->join('project_master', 'project_master.userId = A.id', 'left');
	    $this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
	    $this->db->join('project_rating', 'project_rating.projectId = project_master.id', 'left');
		$this->db->group_by('A.id');
	    $data = $this->db->get()->result_array();
	    $new_array = array();
		if(!empty($data))
		{ $i=0;
			 foreach($data as $row)
			 {
				 if(file_exists(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) && filesize(file_upload_s3_path().'users/thumbs/'.$data[$i]['profileimage']) > 0 && $data[$i]['profileimage']!='')
				{
				  	$data[$i]['profileimage'] = file_upload_base_url().'users/thumbs/'.$data[$i]['profileimage'];
				}
				else
				{
					$data[$i]['profileimage'] = "";
				}
				if($userId!='-1')
				{
					$followingOrNot = $this->checkFollowingOrNot($userId,$row['userId']);
				    if(!empty($followingOrNot))
					{
						$data[$i]['isfollow'] = 1;
					}
					else
					{
						$data[$i]['isfollow'] = 0;
					}
				}
				else
				{
					$data[$i]['isfollow'] = 0;
				}
				$data[$i]['followersCount']=$this->model_basic->getCount('user_follow','followingUser',$row['userId']);
			    $proData = $this->getUserProjectData($row['userId']);
				$likeCount    = 0;
				$viewCount    = 0;
				foreach($proData as $val)
				{
					$likeCount = $val['like_cnt'] + $likeCount;
					$viewCount = $val['view_cnt'] + $viewCount;
				}
				$data[$i]['likeCount'] = $likeCount;
				$data[$i]['viewCount'] = $viewCount;
				$data[$i]['userId'] = (int) $data[$i]['userId'];
				$data[$i]['projectCount'] = (int) $data[$i]['projectCount'];
		        $i++;
			 }
		}
	   	if(!empty($data))
		{
		 	$new_array['peopleList']=$data;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['peopleList']=array();
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function AddNewAssignment($userId,$deviceId,$instituteId,$assignmentName,$description,$startDate,$endDate,$tools,$features,$peopleList,$assignmentId)
    {
    	if($assignmentId > 0)
    	{
    		$AddData=array('assignment_name'=> $assignmentName,'description'=>$description,'start_date'=>date('Y-m-d',strtotime($startDate)),'end_date'=>date('Y-m-d',strtotime($endDate)),'teacher_id'=>$userId);
    		$res=$this->model_basic->_update('assignment','id',$assignmentId,$AddData);
    		if(!empty($peopleList))
    		{
    			foreach ($peopleList as $individual_user) 
    			{	
    				
					$check_user_present=$this->model_basic->getData('user_assignment_relation','*',array('user_id'=>$individual_user['userId'],'assignment_id'=>$assignmentId));
					if(empty($check_user_present))
					{
						$user_assig_relation_data  = array('user_id' => $individual_user['userId'],'assignment_id'=>$assignmentId);
						$insert_user_assig_relation_data=$this->model_basic->_insert('user_assignment_relation',$user_assig_relation_data);
						$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user['userId']));
						$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignmentId));
						$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
						$message='Hellow, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> New assignment has been assign to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';
						$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'New assignment has been assign to you','template'=>$message);
						$sendMail = $this->model_basic->sendMail($emailData);
						$notificationEntry=array('title'=>'New assignment added','msg'=>'New assignment '.$get_assignment_data['assignment_name'].' added in creonow by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'],'link'=>'assignment/assignment_detail/'.$assignmentId.'/'.$individual_user['userId'],'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$assignmentId);
						$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
						$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user['userId']);
						$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);
					}
					else
					{	

						$user_assig_relation_data  = array('user_id' => $individual_user['userId'],'assignment_id'=>$assignmentId);
						$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user['userId']));
						$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignmentId));
						$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
						$message='Hellow, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> Some changes are made in assignment has been assigned to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';								
						$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'Some changes are made in assignment has been assign to you','template'=>$message);	  
						$sendMail = $this->model_basic->sendMail($emailData);
						$notificationEntry=array('title'=>'Some changes in Assignment','msg'=>'Some changes are made in assignment '.$get_assignment_data['assignment_name'].' in creonow.','link'=>'assignment/assignment_detail/'.$assignmentId.'/'.$individual_user['userId'],'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$assignmentId);
						$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
						$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user['userId']);
						$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);

					}
    			}
    		}
    		$this->load->model('assignment_model');
    		$assign_not_users = $this->assignment_model->not_assign_user_api($peopleList,$assignmentId);	
    		//$errorMsg='';
    		if(!empty($assign_not_users))	
    		{
    			foreach ($assign_not_users as $key => $value) 
    			{
    				//echo $value['user_id'];die;
    				$toCheckAssigIsSubmitedOrNot=$this->model_basic->getAllData('project_master','id',array('userId'=>$value['user_id'],'assignmentId'=>$assignmentId));
    				if(!empty($toCheckAssigIsSubmitedOrNot))
    				{
    					$get_user_Name=$this->model_basic->getData('users','firstName,lastName',array('id'=>$value['user_id']));
    					//$errorMsg .= $get_user_Name['firstName'].' '.$get_user_Name['lastName'].' user can not delet. submit project';
    				}
    				else
    				{							
    					$deletUser = $this->model_basic->_deleteWhere('user_assignment_relation',array('assignment_id'=>$assignmentId,'user_id'=>$value['user_id']));										
    				}
    				
    			}
    		}
    		$delettools = $this->model_basic->_deleteWhere('assignment_tools_relation',array('assignment_id'=>$assignmentId));
    		$deletfeatures = $this->model_basic->_deleteWhere('assignment_features_relation',array('assignment_id'=>$assignmentId));
    		if($tools!='')
    		{
    			$tools = explode(',', $tools);
    			if(!empty($tools))
    			{
    				foreach($tools as $single_tool_value)
    				{
    					$get_tool_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>1,'attributeValue'=>$single_tool_value));
    					if(!empty($get_tool_data))
    					{							
    						$AddToolData=array('assignment_id'=>$res,'attribute_tools_id'=>$get_tool_data['id']);	
    					}
    					else
    					{
    						$add_tool_data=array('attributeId'=>1,'attributeValue'=>$single_tool_value);
    						$add_tool=$this->model_basic->_insert('attribute_value_master',$add_tool_data);
    						if($add_tool>1)
    						{
    							$AddToolData=array('assignment_id'=>$assignmentId,'attribute_tools_id'=>$add_tool);
    						}
    					}
    					$insert_get_tool_data=$this->model_basic->_insert('assignment_tools_relation',$AddToolData);						
    				}
    			}				
    		}
    		if($features!='')
    		{
    			$features = explode(',', $features);
    			if(!empty($features))
    			{
    				foreach($features as $single_features_value)
    				{
    					$get_features_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>2,'attributeValue'=>$single_features_value));
    					if(!empty($get_features_data))
    					{							
    						$AddfeaturesData=array('assignment_id'=>$assignmentId,'attribute_features_id'=>$get_features_data['id']);
    					}
    					else
    					{
    						$add_feature_data=array('attributeId'=>1,'attributeValue'=>$single_features_value);
    						$add_feature=$this->model_basic->_insert('attribute_value_master',$add_feature_data);
    						if($add_feature>1)
    						{
    							$AddfeaturesData=array('assignment_id'=>$res,'attribute_features_id'=>$add_feature);
    						}

    					}
    					$insert_get_features_data=$this->model_basic->_insert('assignment_features_relation',$AddfeaturesData);					
    				}
    			}			
    		}
    	}
    	else
    	{
    		$AddData=array('assignment_name'=> $assignmentName,'description'=>$description,'start_date'=>date('Y-m-d',strtotime($startDate)),'end_date'=>date('Y-m-d',strtotime($endDate)),'teacher_id'=>$userId,'created'=>date('Y-m-d H:i:s'));
			$res=$this->model_basic->_insert('assignment',$AddData);
			if(!empty($peopleList))
			{
				foreach ($peopleList as $individual_user) 
				{
					$user_assig_relation_data  = array('user_id' => $individual_user['userId'],'assignment_id'=>$res);
					$insert_user_assig_relation_data=$this->model_basic->_insert('user_assignment_relation',$user_assig_relation_data);
					$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user['userId']));
					$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$res));
					$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
					$message='Hellow, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> New assignment has been assign to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';
					$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'New assignment has been assign to you','template'=>$message);
					$sendMail = $this->model_basic->sendMail($emailData);
					$notificationEntry=array('title'=>'New assignment added','msg'=>'New assignment '.$get_assignment_data['assignment_name'].' added in creonow by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'],'link'=>'assignment/assignment_detail/'.$res.'/'.$individual_user['userId'],'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$res);
					$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);
					$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user['userId']);
					$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);
				}
			}
			if($tools!='')
			{
				$tools = explode(',', $tools);
				if(!empty($tools))
				{
					foreach($tools as $single_tool_value)
					{
						$get_tool_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>1,'attributeValue'=>$single_tool_value));
						if(!empty($get_tool_data))
						{							
							$AddToolData=array('assignment_id'=>$res,'attribute_tools_id'=>$get_tool_data['id']);	
						}
						else
						{
							$add_tool_data=array('attributeId'=>1,'attributeValue'=>$single_tool_value);
							$add_tool=$this->model_basic->_insert('attribute_value_master',$add_tool_data);
							if($add_tool>1)
							{
								$AddToolData=array('assignment_id'=>$res,'attribute_tools_id'=>$add_tool);
							}
						}
						$insert_get_tool_data=$this->model_basic->_insert('assignment_tools_relation',$AddToolData);						
					}
				}				
			}
			if($features!='')
			{
				$features = explode(',', $features);
				if(!empty($features))
				{
					foreach($features as $single_features_value)
					{
						$get_features_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>2,'attributeValue'=>$single_features_value));
						if(!empty($get_features_data))
						{							
							$AddfeaturesData=array('assignment_id'=>$res,'attribute_features_id'=>$get_features_data['id']);
						}
						else
						{
							$add_feature_data=array('attributeId'=>1,'attributeValue'=>$single_features_value);
							$add_feature=$this->model_basic->_insert('attribute_value_master',$add_feature_data);
							if($add_feature>1)
							{
								$AddfeaturesData=array('assignment_id'=>$res,'attribute_features_id'=>$add_feature);
							}

						}
						$insert_get_features_data=$this->model_basic->_insert('assignment_features_relation',$AddfeaturesData);					
					}
				}			
			}
		}
		if($res > 0)
		{
			$new_array['assignmentId']=$res;
		 	$new_array['statusCode']=200;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    else
	    {
	     	$new_array['assignmentId']=0;
		 	$new_array['statusCode']=404;
		 	$new_array['errorMessage']='';
		 	$new_array['statusMessage']='Done';
	    }
	    return $new_array;
    }

    public function GetSubmitedAssignmentList($userId,$deviceId,$instituteId)
    {
    	$this->db->select('assignment.id as assignmentId,assignment.teacher_id as teacherId,assignment.assignment_name as assignmentName,assignment.start_date as startDate,assignment.end_date as endDate,assignment.created as postedOnDate,assignment.description as description');
    	$this->db->from('assignment');
    	$this->db->where('assignment.teacher_id',$userId);
    	$this->db->order_by("created",'desc');
    	$data=$this->db->get()->result_array();
    	if(!empty($data))
    	{
    		foreach($data as $assignment)
    		{
    			$assignment['assignmentId']=(int) $assignment['assignmentId'];
    			$assignment['teacherId']=(int) $assignment['teacherId'];
    			$assignment['submitedStatus']='';
    			$assignment['submitedStatusMessage']='';
    			$TotalNoOfAssignedUser = $this->db->select('*')->from('user_assignment_relation')->where('assignment_id',$assignment['assignmentId'])->get()->num_rows();
    			$TotalNoOfAssignmentSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->get()->num_rows();
    			$NoOfAssignmentSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->where('assignment_status',1)->get()->num_rows();
    			$NoOfAssignmentReSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->where('assignment_status',4)->get()->num_rows();
    			$NoOfAssignmentAcceptedUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->where('assignment_status',3)->get()->num_rows();
    			$NoOfAssignmentPendingUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->where('assignment_status',2)->get()->num_rows();
    			if($TotalNoOfAssignedUser > $TotalNoOfAssignmentSubmiterUser && $NoOfAssignmentReSubmiterUser>0)
    			{
    				$assignment['submitedStatusMessage']='Re - Submitted';				
    			}
    			elseif($TotalNoOfAssignmentSubmiterUser > 0 && $NoOfAssignmentSubmiterUser > 0)
    			{
    				$assignment['submitedStatusMessage']='Latest Submitted';					
    			}				
    			elseif($assignment['endDate'] == date('Y-m-d'))
    			{
    				$assignment['submitedStatusMessage']="Today's Assignment";
    			}
    			$assignment['assignedStatus']='';
    			$assignment['assignedStatus']=(int) $assignment['assignedStatus'];
    			$assignment['asssignCount'] = $this->db->select('*')->from('user_assignment_relation')->where('assignment_id',$assignment['assignmentId'])->get()->num_rows();
    			$assignment['submitCount'] = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['assignmentId'])->get()->num_rows();
	    		$tools=$this->db->select('B.attributeValue')->from('assignment_tools_relation as A')->join('attribute_value_master as B','B.id = A.attribute_tools_id')->where('A.assignment_id',$assignment['assignmentId'])->get()->result_array();
	    		$j=count($tools);
	    		$i=1;
	    		$assignment['tools']='';
    			if(!empty($tools))
    			{
    				foreach ($tools as $singleTool) 
    				{
    					$assignment['tools'].= $singleTool['attributeValue'];
    					if($i < $j)
    					{
    						$assignment['tools'].= ', ';
    					}
    					$i++;
    				}
    			}
	    		$features=$this->db->select('B.attributeValue')->from('assignment_features_relation as A')->join('attribute_value_master as B','B.id = A.attribute_features_id')->where('A.assignment_id',$assignment['assignmentId'])->get()->result_array();
	    		$k=count($features);
	    		$l=1;
	    		$assignment['features']='';
    			if(!empty($features))
    			{
    				foreach ($features as $singleFeature) 
    				{
    					$assignment['features'].= $singleFeature['attributeValue'];
    					if($l < $k)
    					{
    						$assignment['features'].= ', ';
    					}
    					$l++;
    				}
    			}
    			$assignment['peopleList']=$this->db->select('user_id as userId')->from('user_assignment_relation')->where('assignment_id',$assignment['assignmentId'])->get()->result_array();
    			/*$NoOfAssignmentSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',1)->get()->num_rows();
    			$NoOfAssignmentReSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',4)->get()->num_rows();
    			$NoOfAssignmentAcceptedUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',3)->get()->num_rows();
    			$NoOfAssignmentPendingUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',2)->get()->num_rows();*/
    			$allass[]=$assignment;
    		}
	    	$ass['assignmentList']=$allass;
	    	$ass['statusCode']=200;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	else
    	{
	    	$ass['assignmentList']=array();
	    	$ass['statusCode']=404;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	return $ass;
    }

    public function DeleteAssignment($userId,$deviceId,$instituteId,$assignmentId)
    {
    	$res = $this->model_basic->_deleteWhere('assignment',array('id'=>$assignmentId,'teacher_id'=>$userId));
    	if($res)
    	{			
    		$ass['statusCode']=200;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	else
    	{
	    	$ass['statusCode']=404;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	return $ass;
    }

    public function AcceptAssignment($userId,$deviceId,$instituteId,$comment,$projectId)
    {
    	$assignmentId=$this->getValueOnly('project_master','assignmentId',array('id'=>$projectId));
    	$teacherData=$this->db->select('firstName,lastName,email')->from('users')->where('id',$userId)->get()->result_array();
    	$name=$teacherData[0]['firstName'].' '.$teacherData[0]['lastName'];
    	$commentData=array('projectId'=>$projectId,'userId'=>$userId,'name'=>$name,'email'=>$teacherData[0]['email'],'comment'=>$comment,'read'=>0,'status'=>1,'created'=>date('Y-m-d H:i:s'),'assignmentId'=>$assignmentId);
    	$res=$this->model_basic->_insert('user_project_comment',$commentData);
    	if($res > 0)
    	{
    		$this->model_basic->_update('project_master','id',$projectId,array('assignment_status'=>3));
    	}
    	if($res)
    	{			
    		$ass['statusCode']=200;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	else
    	{
	    	$ass['statusCode']=404;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	return $ass;
    }

    public function NeedMoreWorkAssignment($userId,$deviceId,$instituteId,$comment,$projectId)
    {
    	$assignmentId=$this->getValueOnly('project_master','assignmentId',array('id'=>$projectId));
    	$teacherData=$this->db->select('firstName,lastName,email')->from('users')->where('id',$userId)->get()->result_array();
    	$name=$teacherData[0]['firstName'].' '.$teacherData[0]['lastName'];
    	$commentData=array('projectId'=>$projectId,'userId'=>$userId,'name'=>$name,'email'=>$teacherData[0]['email'],'comment'=>$comment,'read'=>0,'status'=>1,'created'=>date('Y-m-d H:i:s'),'assignmentId'=>$assignmentId);
    	$res=$this->model_basic->_insert('user_project_comment',$commentData);
    	if($res > 0)
    	{
    		$this->model_basic->_update('project_master','id',$projectId,array('assignment_status'=>2));
    	}
    	if($res)
    	{			
    		$ass['statusCode']=200;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	else
    	{
	    	$ass['statusCode']=404;
		 	$ass['errorMessage']='';
		 	$ass['statusMessage']='Done';
    	}
    	return $ass;
    }
}