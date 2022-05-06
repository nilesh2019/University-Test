<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function insert_data($tablename,$data)
	{
		$this->db->insert($tablename,$data);
		return $this->db->insert_id();
	}
	public function update_rating_data($tablename,$data,$projectId)
	{
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('projectId',$projectId);
		return $this->db->update($tablename,$data);		
	}
	public function update_data($tablename,$data,$attrName,$attrValue)
	{
		$this->db->where($attrName,$attrValue);
		$this->db->where('user_id',$this->session->userdata('front_user_id'));
		return $this->db->update($tablename,$data);
	}
	public function getCategoryName($catId)
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('id',$catId);
		return $this->db->get()->result_array();
	}
	public function getUserWinningProjects($userId)
	{
			$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.city,users.country,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.created');
			$this->db->from('project_master');
			$this->db->where('user_project_image.cover_pic',1);
			$this->db->where('users.id',$userId);
			$this->db->join('competition_winning_projects', 'competition_winning_projects.projectId = project_master.id');
			$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
			$this->db->join('users', 'users.id = project_master.userId');
		    	$data = $this->db->get()->result_array();
			if(!empty($data))
			{ $i=0;
				 foreach($data as $row)
				 {
				 	$this->db->select('attribute_master.attributeName,attribute_master.id');
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
						$data[$i]['atrribute'] = $arr;
						$data[$i]['attributeValue'] = $arr2;
				   	}
					else
					{
						$data[$i]['atrribute'] = array();
						$data[$i]['attributeValue'] = array();
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
	public function get_data($tablename,$attrName,$attrValue,$fieldname)
	{
		$this->db->select($fieldname);
		$this->db->from($tablename);
		$this->db->where($attrName,$attrValue);
		$this->db->where('user_id',$this->session->userdata('front_user_id'));
		return $this->db->get()->row();
	}
	public function get_image_likes($imageId,$userId='')
	{
		$this->db->select('*');
		$this->db->from('project_image_rating_like');
		$this->db->where('project_image_id',$imageId);
		if($userId!='')
		{
			$this->db->where('user_id',$userId);
		}
		$this->db->where('image_like',1);
		return $this->db->get()->result_array();
	}
	public function get_avg_rating($tablename,$attrName,$attrValue,$fieldname)
	{
		$total='';$avg=0;
		$this->db->select($fieldname);
		$this->db->from($tablename);
		$this->db->where($attrName,$attrValue);
		$data = $this->db->get();
		$num_rows = $data->num_rows();
		if($num_rows>0)
		{
			foreach($data->result() as $rating)
			{
				$total = $total + $rating->image_rating;
			}
			$avg = ($total/$num_rows);
		}
		return $avg;
	}
	public function overAllAvg($projectId,$uid)
	{
		$this->db->select('AVG(project_attribute_value_rating.rating) as avg');
		$this->db->from('project_attribute_value_rating');
		$this->db->where('project_attribute_value_rating.projectId',$projectId);
		$this->db->where('project_master.userId',$uid);
		$this->db->join('project_master', 'project_attribute_value_rating.projectId = project_master.id');
		return $this->db->get()->result_array();
	}
	public function getUserProfileData()
	{
		$user_id = $this->session->userdata('front_user_id');
		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row();
	}
	public function check_admin_approve_required($institute_id)
	{
		$this->db->select('admin_status');
		$this->db->from('institute_master');
		$this->db->where('id',$institute_id);
		return $this->db->get()->result_array();
	}
	public function getProjectCategory()
	{
		$this->db->select('id,categoryName');
		$this->db->from('category_master');
		$this->db->where('status',1);
		/*$this->db->where('id <',26);
		$this->db->or_where('id >',36);*/
		return $this->db->get()->result_array();
	}
	public function project_status_update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->update('project_master',$data);
	}
	public function getAttributeNameValueRating($attributeId,$projectId)
	{
		$this->db->select('attribute_master.id,attribute_master.attributeName,attribute_value_master.attributeValue,attribute_value_master.id as atrValueId');
		$this->db->from('project_attribute_relation');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId');
		$this->db->join('attribute_master', 'project_attribute_relation.attributeId = attribute_master.id');
		$this->db->where('attribute_master.id',$attributeId);
		$this->db->where('attribute_master.status',1);
		$this->db->where('project_attribute_relation.projectId',$projectId);
		$this->db->group_by('attribute_value_master.attributeValue');
		return $this->db->get()->result_array();
	}
	public function getAttributeRatingAvg($proId,$atrValueId)
	{
		$this->db->select('rating_avg');
		$this->db->from('project_attribute_relation');
		$this->db->where('attributeValueId',$atrValueId);
		$this->db->where('projectId',$proId);
		return $this->db->get()->row();
	}
	public function check_rating_entry($proId,$attrId,$attrValId)
	{
		$this->db->select('*');
		$this->db->from('project_attribute_value_rating');
		$this->db->where('attributeValueId',$attrValId);
		$this->db->where('attributeId',$attrId);
		$this->db->where('projectId',$proId);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	public function check_rate_like_exists($image_id/*,$rating='',$like=''*/)
	{
		$this->db->select('*');
		$this->db->from('project_image_rating_like');
		$this->db->where('project_image_id',$image_id);
		$this->db->where('user_id',$this->session->userdata('front_user_id'));
		/*if($rating!='')
		{
			$this->db->where('image_rating !=','');
		}
		elseif($like!='')
		{
			$this->db->where('image_like',1);
		}*/
		return $this->db->get()->result_array();
	}
	public function insertAttributeValueRating($data)
	{
		$this->db->insert('project_attribute_value_rating',$data);
		return $this->db->insert_id();
	}
	public function countAvgOfAttributeValueRating($attrId,$attrValId,$projectId)
	{
		$this->db->select('AVG(rating) as avg');
		$this->db->from('project_attribute_value_rating');
		$this->db->where('attributeValueId',$attrValId);
		$this->db->where('attributeId',$attrId);
		$this->db->where('projectId',$projectId);
		return $this->db->get()->result_array();
	}
	public function updateAvgToAttributeValue($attrId,$attrValId,$avg,$proid)
	{
		$this->db->where('attributeValueId',$attrValId);
		$this->db->where('attributeId',$attrId);
		$this->db->where('projectId',$proid);
		return $this->db->update('project_attribute_relation',array('rating_avg'=>$avg));
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
						//$arr[] = $val['attributeValue'];
						$arr[] = "'".$val['attributeValue']."'";
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
	public function check_project_rating($proId)
	{
		$this->db->select('*');
		$this->db->from('project_rating');
		$this->db->where('projectId',$proId);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	public function project_avg_rating($projectId)
	{
		$this->db->select('AVG(rating) as avg');
		$this->db->from('project_rating');
		$this->db->where('projectId',$projectId);
		return $this->db->get()->result_array();
	}
	public function project_rating_by_user($projectId)
	{
		$this->db->select('rating');
		$this->db->from('project_rating');
		$this->db->where('projectId',$projectId);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	public function getCreatedByUser($createdByUser)
	{
		return $this->db->select('firstName,lastName,email,contactNo,address,country,city,profession,company,about_me')->from('users')->where('id',$createdByUser)->get()->row();
	}
	public function getFollowedUsers($addedBy)
	{
		$this->db->select('userId');
		$this->db->from('user_follow');
		$this->db->where('followingUser',$addedBy);
		return $this->db->get()->result_array();
	}
	public function getProjectDetail($project_id)
	{
		$this->db->select('project_master.id,project_master.status as projectstatus,project_master.assignment_status as teacher_status,project_master.assignmentId as assignmentId,project_master.basicInfo,project_master.projectName,project_master.projectPageName,project_master.videoLink,project_master.team_member,project_master.isTeam,project_master.withoutCover,users.firstName,users.lastName,users.profileImage,users.folderId,project_master.userId,project_master.categoryId,user_project_image.image_thumb,user_project_image.id as image_id,project_master.socialFeatures,project_master.created,project_master.copyright,project_master.keyword,project_master.thought,project_master.file_link');
		//$this->db->select(' * ');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.id',$project_id);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$data = $this->db->get()->result_array();
		/*print_r($data);die;*/
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$this->db->select('attribute_master.attributeName,attribute_master.id as attributeMainId');
				$this->db->from('category_master');
				$this->db->where('category_master.id',$row['categoryId']);
				$this->db->join('category_attribute_relation', 'category_attribute_relation.categoryId = category_master.id');
				$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
				$atrribute     = $this->db->get()->result_array();
				$this->db->select('user_project_image.image_thumb,user_project_image.id');
				$this->db->from('user_project_image');
				$this->db->where('user_project_image.project_id',$row['id']);
				$this->db->order_by('user_project_image.order_no','asc');
				$projectImages = $this->db->get()->result_array();
				if(!empty($atrribute)){
					$arr = array();
					$arr2 = array();
					foreach($atrribute as $val){
						//$values = $this->get_attribute_value($val['id']);
						$values = $this->get_project_attribute_value($row['id'],$val['attributeMainId']);
						if(count($values) > 0){
							//$arr[] = $val['attributeName'];
							$arr[] = $val['attributeMainId'];
						}
						if(!empty($values)){
							foreach($values as $dt){
								$arr2[] = $dt['attributeValue'];
							}
						}
					}
					$data[$i]['atrribute'] = $arr;
					$data[$i]['attributeValue'] = $arr2;
				}
				else
				{
					$data[$i]['atrribute'] = array();
					$data[$i]['attributeValue'] = array();
				}
				if(!empty($projectImages)){
					$proimg = array();
					$proimgId = array();
					foreach($projectImages as $img){
						$proimg[] = $img['image_thumb'];
						$proimgId[] = $img['id'];
					}
					$data[$i]['projectImg'] = $proimg;
					$data[$i]['projectImgId'] = $proimgId;
				}
				else
				{
					$data[$i]['projectImg'] = array();
					$data[$i]['projectImgId'] = array();
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
	public function getUserProjects($projectId,$mainprojectId)
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('project_master.userId',$projectId);
		$this->db->where_not_in('project_master.id',$mainprojectId);
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->order_by('project_master.created','desc');
		$this->db->where('project_master.status',1);
		$this->db->limit(3);
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
					$data[$i]['categoryName'] = $atrribute['0']['categoryName'];
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
	
	public function getCategoryRelatedProjects($project_id,$cat_id)
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.id !=',$project_id);
		$this->db->where('project_master.categoryId',$cat_id);
		$this->db->where('project_master.status',1);
		$this->db->limit(6);
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
					$arr = array();
					$arr2 = array();
					foreach($atrribute as $val)
					{
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
					$data[$i]['categoryName'] = $atrribute['0']['categoryName'];
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
				/*	$view_cnt = $this->project_view_count($row['id']);
				if(!empty($view_cnt))
				{
				$data[$i]['view_cnt'] = $view_cnt;
				}
				else
				{
				$data[$i]['view_cnt'] = 0;
				}
				$like_cnt = $this->project_like_count($row['id']);
				if(!empty($like_cnt))
				{
				$data[$i]['like_cnt'] = $like_cnt;
				}
				else
				{
				$data[$i]['like_cnt'] = 0;
				}
				$comment_cnt = $this->project_comment($row['id']);
				if(!empty($comment_cnt))
				{
				$data[$i]['comment_cnt'] = count($comment_cnt);
				}
				else
				{
				$data[$i]['comment_cnt'] = 0;
				}	*/
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
	public function add_attribute_value($data)
	{
		$this->db->insert('attribute_value_master',$data);
		return $this->db->insert_id();
	}
	public function getSingleProjectDetail($project_id)
	{
		$this->db->select('project_master.*');
		$this->db->from('project_master');
		$this->db->where('project_master.id',$project_id);
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	public function getSingleProjectTeam($project_id)
	{
		$this->db->select('*');
		$this->db->from('project_team');
		$this->db->where('projectId',$project_id);
		$data = $this->db->get()->result_array();
		if(!empty($data)){
			foreach($data as $row){
				$data['all_team'][] = $row['userId'];
			}
		}
		else
		{
			$data['all_team'][] = array();
		}
		return $data;
	}
	public function getSingleProjectImage($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_image');
		$this->db->where('project_id',$project_id);
		$this->db->order_by('order_no','asc');
		return $this->db->get()->result_array();
	}
	public function deleteProjectTeam($project_id)
	{
		$this->db->where('projectId',$project_id);
		return $this->db->delete('project_team');
	}
	public function deleteProjectImages($project_id)
	{
		$this->db->where('project_id',$project_id);
		return $this->db->delete('user_project_image');
	}
	public function deleteProjectAttributeReln($project_id)
	{
		$this->db->where('projectId',$project_id);
		return $this->db->delete('project_attribute_relation');
	}
	public function deleteProject($project_id)
	{
		$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('id',$project_id);
		$projectData = $this->db->get()->row();
		if($this->db->insert('project_master_deleted',$projectData))
		{
			$this->db->where('id',$project_id);
			return $this->db->delete('project_master');
		}
		else{
			return false;
		}
	}
	public function get_attribute_value($attri_id,$pro_id)
	{
		$this->db->select('attribute_value_master.attributeValue');
		$this->db->from('project_attribute_relation');
		$this->db->where('project_attribute_relation.attributeId',$attri_id);
		$this->db->where('project_attribute_relation.projectId',$pro_id);
		$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
		$data = $this->db->get()->result_array();
		if(!empty($data)){
			foreach($data as $row){
				$data['attributeValue'][] = $row['attributeValue'];
			}
		}
		else
		{
			$data['attributeValue'][] = '';
		}
		return $data;
	}
	public function update_project($project_id,$det)
	{
		$this->db->where('id',$project_id);
		return $this->db->update('project_master',$det);
	}
	public function update_project_status($project_id,$det)
	{
		$this->db->where('id',$project_id);
		return $this->db->update('project_master',$det);
	}
/*	public function edit_content($project_id,$det)
	{
		$this->db->where('projectId',$project_id);
		$this->db->update('content_master',$det);
	}*/
	function delete_member($project_id,$val)
	{
		$this->db->where('userId',$val);
		$this->db->where('projectId',$project_id);
		return $this->db->delete('project_team');
	}
	public function get_relation_exist($project_id,$attributeId,$attributeValueId)
	{
		$this->db->select('*');
		$this->db->from('project_attribute_relation');
		$this->db->where('attributeId',$attributeId);
		$this->db->where('attributeValueId',$attributeValueId);
		$this->db->where('projectId',$project_id);
		return $this->db->get()->result_array();
	}
	public function delete_relation_attributeValue($project_id,$attributeId,$attributeValueId)
	{
		$this->db->where('attributeId',$attributeId);
		$this->db->where('attributeValueId',$attributeValueId);
		$this->db->where('projectId',$project_id);
		return $this->db->delete('project_attribute_relation');
	}
	public function get_attribute_value_id($attri_id,$vname)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('attributeId',$attri_id);
		$this->db->where('attributeValue',$vname);
		return $this->db->get()->result_array();
	}
	public function get_all_user_project()
	{
		$this->db->select('id');
		$this->db->from('project_master');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('status',1);
		return $this->db->get()->result_array();
		// $data = $this->db->get()->result_array();
		//print_r($data);die;
	}
	public function makeJobReadEntry()
	{
		$job = $this->getAllJob();
		if(!empty($job)){
			foreach($job as $row){
				$reln = $this->check_job_notification_relation($row['jobId']);
				if(empty($reln)){
					$data = array('jobId'  =>$row['jobId'],'userId' =>$this->session->userdata('front_user_id'),'read'   =>1,'created'=>date("Y-m-d H:i:s"));
					$this->db->insert('job_user_notification',$data);
				}
			}
		}
		return;
	}
	public function makeEventReadEntry()
	{
		$event = $this->getAllEvent();
		if(!empty($event)){
			foreach($event as $row){
				$reln = $this->check_event_notification_relation($row['eventId']);
				if(empty($reln)){
					$data = array('eventId'=>$row['eventId'],'userId' =>$this->session->userdata('front_user_id'),'read'   =>1,'created'=>date("Y-m-d H:i:s"));
					$this->db->insert('event_user_notification',$data);
				}
			}
		}
		return;
	}
	public function makeCompetitionReadEntry()
	{
		$event = $this->getAllCompetition($this->session->userdata('user_institute_id'));
		if(!empty($event)){
			foreach($event as $row){
				$reln = $this->check_competition_notification_relation($row['competitionId']);
				if(empty($reln)){
					$data = array('competitionId'=>$row['competitionId'],'userId'       =>$this->session->userdata('front_user_id'),'read'         =>1,'created'      =>date("Y-m-d H:i:s"));
					$this->db->insert('competition_user_notification',$data);
				}
			}
		}
		return;
	}
	/*New Change*/
	public function makeFeedbackInstanceReadEntry()
	{
		$feedback= $this->getAllFeedback();
		if(!empty($feedback)){
			foreach($feedback as $row){
				$reln = $this->check_feedback_notification_relation($row['id']);
				if(empty($reln)){
					$data = array('instance_id'=>$row['id'],'userId' =>$this->session->userdata('front_user_id'),'read'  =>1,'created' =>date("Y-m-d H:i:s"));
					$this->db->insert('feedback_user_notification',$data);
				}
			}
		}
		return;
	}
	public function getAllFeedback(){
		$this->db->select('*');
		$this->db->from('feedback_instance');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function check_feedback_notification_relation($id)
	{
		$this->db->select('*');
		$this->db->from('feedback_user_notification');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('instance_id',$id);
		return $this->db->get()->result_array();
	}
	/*New Change*/
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
		if($user_institute_id != ''){
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
		if(!empty($open_competition)&&!empty($user_institute_competition)){
			$det = array_merge($open_competition,$user_institute_competition);
		}
		elseif(empty($open_competition)&&!empty($user_institute_competition)){
			$det = $user_institute_competition;
		}
		elseif(!empty($open_competition) && empty($user_institute_competition)){
			$det = $open_competition;
		}
		else
		{
			$det = array();
		}
		return $det;
	}
	public function check_job_notification_relation($id)
	{
		$this->db->select('*');
		$this->db->from('job_user_notification');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('jobId',$id);
		return $this->db->get()->result_array();
	}
	public function check_event_notification_relation($id)
	{
		$this->db->select('*');
		$this->db->from('event_user_notification');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('eventId',$id);
		return $this->db->get()->result_array();
	}
	public function check_competition_notification_relation($id)
	{
		$this->db->select('*');
		$this->db->from('competition_user_notification');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('competitionId',$id);
		return $this->db->get()->result_array();
	}
	public function updateCommentRead($project_id)
	{
		$this->db->where('projectId', $project_id);
		$this->db->where('read',0);
		$this->db->update('user_project_comment',array('read'=>1));
	}
	public function updateFollowingRead()
	{
		$this->db->where('followingUser', $this->session->userdata('front_user_id'));
		$this->db->where('read',0);
		$this->db->update('user_follow',array('read'=>1));
	}
	public function updateLikeRead($project_id)
	{
		$this->db->where('projectId', $project_id);
		$this->db->where('userId !=',0);
		$this->db->where('userLike',1);
		$this->db->where('read',0);
		$this->db->update('user_project_views',array('read'=>1));
	}
	public function getAllUserProject()
	{
		$this->db->select('project_master.*,category_master.categoryName');
		$this->db->from('project_master');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		$this->db->where('project_master.status !=',2);
		$this->db->join('category_master', 'project_master.categoryId = category_master.id');
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
	public function follow_user($data)
	{
		return $this->db->insert('user_follow',$data);
	}
	function unfollow_user($uid)
	{
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('followingUser',$uid);
		return $this->db->delete('user_follow');
	}
	public function loginUserDetail()
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$this->session->userdata('front_user_id'));
		$this->db->where('status',1);
		return $this->db->get()->row();
	}
	public function project_view_count($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userView',1);
		return $this->db->get()->num_rows();
	}
	public function project_like_count($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userLike',1);
		return $this->db->get()->num_rows();
	}
	public function project_comment($project_id,$asi='')
	{
		$this->db->select('user_project_comment.*,users.profileImage');
		$this->db->from('user_project_comment');
		$this->db->where('user_project_comment.projectId',$project_id);
		$this->db->order_by('id','desc');
		if($asi=='')
		{
			$this->db->where('user_project_comment.assignmentId',0);
		}
		else {
					$this->db->where('user_project_comment.assignmentId !=',0);
				}		
		$this->db->join('users', 'users.id = user_project_comment.userId');
		return $this->db->get()->result_array();
	}
	public function project_active_comment($project_id)
	{
		$this->db->select('user_project_comment.*,users.profileImage');
		$this->db->from('user_project_comment');
		$this->db->where('user_project_comment.projectId',$project_id);
		$this->db->where('user_project_comment.status',1);
		if($this->uri->segment(3)=='')
		{
			$this->db->where('user_project_comment.assignmentId',0);
		}
		else {
					$this->db->where('user_project_comment.assignmentId !=',0);
				}	
		$this->db->join('users', 'users.id = user_project_comment.userId');
		return $this->db->get()->num_rows();
	}
	public function viewCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('view_cnt', 'view_cnt+1', FALSE);
		$this->db->update('project_master');
	}
	public function likeCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('like_cnt', 'like_cnt+1', FALSE);
		$this->db->update('project_master');
	}
	public function commentCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('comment_cnt', 'comment_cnt+1', FALSE);
		$this->db->update('project_master');
	}
	public function commentCountDecrement($project_id)
	{
		$this->db->where('id', $project_id);
		$this->db->set('comment_cnt', 'comment_cnt-1', FALSE);
		$this->db->update('project_master');
	}
	public function change_comment_status($cid,$status)
	{
		$this->db->where('id', $cid);
		$this->db->update('user_project_comment',array('status'=>$status));
	}
	public function getMember()
	{
		return $this->db->select('*')->from('users')->get()->result_array();
	}
	public function add_project($data)
	{
		$this->db->insert('project_master',$data);
		return $this->db->insert_id();
	}
	public function add_project_attribute($data)
	{
		$this->db->insert('project_attribute_relation',$data);
		return $this->db->insert_id();
	}
	public function add_comment($data)
	{
		$this->db->insert('user_project_comment',$data);
		return $this->db->insert_id();
	}
	public function add_member($data)
	{
		$this->db->insert('project_team',$data);
		return $this->db->insert_id();
	}
/*	public function add($data)
	{
		$this->db->insert('content_master',$data);
		return $this->db->insert_id();
	}*/
	public function add_img($data)
	{
		$this->db->insert('user_project_image',$data);
		return $this->db->insert_id();
	}
	public function upadate_info($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('user_project_image',$data);
	}
	public function getImgDetail($id)
	{
		$this->db->select('*');
		$this->db->from('user_project_image');
		$this->db->where('id',$id);
		return $this->db->get()->result_array();
	}
	function delete_img($file)
	{
		$this->db->where('image_thumb',$file);
		return $this->db->delete('user_project_image');
	}
	public function checkProjectView($project_id,$ip)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		if($this->session->userdata('front_user_id') != ''){
			$this->db->where('userId',$this->session->userdata('front_user_id'));
		}
		else
		{
			$this->db->where('ip_address',$ip);
		}
		return $this->db->get()->result_array();
	}
	public function projectViewEntry($project_id,$ip)
	{
		$data = array('projectId' =>$project_id,'ip_address'=>$ip,'userView'  =>1);
		if($this->session->userdata('front_user_id') != ''){
			$data['userId'] = $this->session->userdata('front_user_id');
		}
		return $this->db->insert('user_project_views',$data);
	}
	public function projectViewUpdate($project_id,$ip)
	{
		$data = array('userView'=>1);
		$this->db->where('projectId',$project_id);
		if($this->session->userdata('front_user_id') != ''){
			$this->db->where('userId',$this->session->userdata('front_user_id'));
			$data['ip_address'] = $ip;
		}
		else
		{
			$this->db->where('ip_address',$ip);
		}
		return $this->db->update('user_project_views',$data);
	}
	public function checkProjectLike($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	public function projectUpdateLike($project_id,$ip)
	{
		$data = array('userLike'  =>1,'ip_address'=>$ip,'like_date' =>date("Y-m-d H:i:s"));
		$this->db->where('projectId',$project_id);
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->update('user_project_views',$data);
	}
	public function projectLikeEntry($project_id,$ip)
	{
		$data = array('projectId' =>$project_id,'ip_address'=>$ip,'userLike'  =>1,'userId'    =>$this->session->userdata('front_user_id'),'like_date' =>date("Y-m-d H:i:s"));
		return $this->db->insert('user_project_views',$data);
	}
	public function updateMoveDataToDriveSetting($moveToGoogleDriveSetting){
	    	$this->db->where('id',$this->session->userdata('front_user_id'));
	    	$res = $this->db->update('users', array('move_to_google_drive' => $moveToGoogleDriveSetting ));
	    	 //$this->db->affected_rows();
	    	if($res > 0)
	    		echo TRUE;
	    	else
	    		echo FALSE;
	}
	public function getAllImageData(){
		$this->db->select('user_project_image.id,user_project_image.image_thumb');
		$this->db->from('user_project_image');
		$this->db->join('project_master','project_master.id = user_project_image.project_id');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}

	public function getProjectAttributeValue($cat_id,$projectId)
	{			
		$this->db->select('attribute_master.id,attribute_master.attributeName');
		$this->db->from('category_attribute_relation');
		$this->db->where('category_attribute_relation.categoryId',$cat_id);
		$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
		$data = $this->db->get()->result_array();
		//print_r($data);die;
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				$this->db->select('attribute_value_master.attributeValue');
				$this->db->from('attribute_value_master');
				$this->db->join('project_attribute_relation','project_attribute_relation.attributeValueId=attribute_value_master.id');
				$this->db->where('project_attribute_relation.projectId',$projectId);
				$this->db->where('project_attribute_relation.attributeId',$row['id']);
				$atrribute = $this->db->get()->result_array();
				//print_r($attribute);die;
				if(!empty($atrribute))
				{
					$arr = array();
					foreach($atrribute as $val)
					{						
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

	public function getCategoryAttributeOnAjax($cat_id)
	{
		$this->db->select('attributeId');
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
	
	public function GetInstitutePendingProjectList($instituteId){
       
	   	$this->db->select('project_master.id,project_master.projectName,project_master.userId,user_project_image.image_thumb,project_master.videoLink,project_master.created,project_master.status,users.firstName,users.lastName,category_master.categoryName');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.assignmentId',0);
		$this->db->where('project_master.projectStatus',1);
		$this->db->where('project_master.admin_status','0');
		$this->db->where('project_master.competitionId',0);
		$this->db->where('project_master.status',3);
      	$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
      	$this->db->join('category_master', 'project_master.categoryId = category_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->where('users.instituteId',$instituteId);
		$this->db->order_by('project_master.created','desc');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		
	    return $data;
    }
    public function pending_project_status_update($id,$data)
	{
		$this->db->where('id',$id);
		return $this->db->update('project_master',$data);
	}


}