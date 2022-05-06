<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
	}
   	public function getViewLikeCnt($uid='')
	{
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('SUM(view_cnt) AS views,SUM(like_cnt) AS likes')->from('project_master')->where('userId',$user_id)->get()->result_array();
	}
public function getFollowers($uid='')
	{
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('COUNT(followingUser) AS followers')->from('user_follow')->where('followingUser',$user_id)->get()->result_array();
	}
	public function getFollowersList($uid='')
	{
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('users.firstName,users.lastName')->from('user_follow')->join('users','user_follow.userId=users.id')->where('followingUser',$user_id)->get()->result_array();
	}
	public function getFollowing($uid='')
	{
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('COUNT(followingUser) AS following')->from('user_follow')->where('userId',$user_id)->get()->result_array();
	}


	public function getFollowingList($uid='')
	{
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('users.firstName,users.lastName')->from('user_follow')->join('users','user_follow.followingUser=users.id')->where('userId',$user_id)->get()->result_array();
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
	    //return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row();

	     return $this->db->select('A.id, A.firstName, A.lastName, A.email, A.contactNo, A.address, A.country, A.city, A.marital_status, A.state, A.location, A.profession, A.age, A.college, A.about_me, A.type, A.company, A.webSiteURL, A.skills, A.dob, A.age, A.profileImage, A.profileURL, A.dob, B.instituteName , B.pageName,B.instituteName,B.pageName,icu.courseName,icu.courseId,icu.registration_date')->from('users as A')->join('institute_master as B','B.id=A.instituteId','left')->join('institute_csv_users as icu','icu.email=A.email','left')->where('A.id',$user_id)->get()->row();


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
	    return $this->db->select('new_job,weeklyNewsletter,new_competition,follow_unfollow,new_project_followed,project_comment')->from('user_email_notification_relation')->where('userId',$user_id)->get()->row();
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
	public function getUserWorkData_new($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
	  return  $this->db->select('*')->from('users_work')->where('user_id',$user_id)->where('status','1')->get()->result_array();
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
		return $this->db->select('*')->from('users_education')->where('user_id',$user_id)->order_by('passoutyear','desc')->get()->result_array();
	}
	public function getUserProfessionalEducationData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_education')->where('user_id',$user_id)->where('education_type','5')->order_by('passoutyear','desc')->get()->result_array();
	}
	public function getUserHighestEducationData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_education')->where('user_id',$user_id)->order_by('endFrom','desc')->get()->result_array();
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
	public function getWorkshopData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_workshop')->where('user_id',$user_id)->order_by('workshop_date','desc')->get()->result_array();
	}
	public function getLanguageData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		return $this->db->select('*')->from('users_language')->where('user_id',$user_id)->get()->result_array();
	}
	public function getLocationData($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('cities.city,users_location.id,users_location.state_id,users_location.city_id');
		$this->db->from('users_location');
		$this->db->where('users_location.user_id',$user_id);
		$this->db->join('cities', 'users_location.city_id = cities.id');
		return $this->db->get()->result_array();
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
	public function getUserCardData($uid='')
	{
		 if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
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
	public function getCourseData($course_code){
		$this->db->select('courses.course_name,course_type.course_type');
		$this->db->from('courses');
		$this->db->join('course_type', 'courses.course_type = course_type.id');
		$this->db->where('courses.course_code',$course_code);
		return $this->db->get()->row_array();
	}
	public function check_password($id,$pass)
	{
	   return $this->db->select('*')->from('users')->where('id',$id)->where('password',md5($pass))->get()->row();
	}
	public function check_admin_or_not()
	{
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->where('status',1);
		$this->db->where('adminId',$this->session->userdata('front_user_id'));
	    return $this->db->get()->result_array();
    }
    public function change_admin_project_flag($status)
	{
		$data = $this->check_admin_or_not();
		if(!empty($data))
		{
			/*if($data[0]['admin_status']==1)
			{
				$status = 0;
			}
			else
			{
				$status = 1;
			}*/
			$this->db->where('adminId',$this->session->userdata('front_user_id'));
			$res = $this->db->update('institute_master',array('admin_status'=>$status));
	        if($res>0)
	        {
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
    }
	public function getInstituteData()
	{
		$this->db->select('*');
		$this->db->from('institute_master');
		$this->db->where('status',1);
		$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
	    return $this->db->get()->result_array();
    }
    public function getUserInstituteId($userId)
	{
		$this->db->select('instituteId');
		$this->db->from('users');
		$this->db->where('status',1);
		$this->db->where('id',$userId);
		//$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
	    return $this->db->get()->result_array();
    }
	public function getUserProjectData($uid='')
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,users.profession,users.city,project_master.created');
		//$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {

			if($this->session->userdata('user_admin_level') == 1)
			{
				$where = "(( project_master.status=1) OR ( project_master.status=3))";
				$this->db->where($where);
				$this->db->where('users.instituteId',$institute[0]['instituteId']);
			}				
			else if($this->session->userdata('user_admin_level') == 4)
			{	
				  if(!empty($institute))
				  {
				  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
				  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
				  }		
			}
			else
			{
				
				 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
				   {
						if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
						{
							//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
							if($user_id==$this->session->userdata('front_user_id'))
							{
								$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
					    			$this->db->where($where);
							}
							else
							{
								$where = "(( project_master.status=1) OR ( project_master.status=3))";
						    		$this->db->where($where);
							}
						}
						else
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
					}
					elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
						$this->db->where('project_master.status',1);
					}
					else
					{
						  if($user_id==$this->session->userdata('front_user_id'))
							{
								$where = "(( project_master.status=1) OR ( project_master.status=0))";
					    			$this->db->where($where);
							}
							else
							{
								$this->db->where('project_master.status',1);
							}
					}
			}

		  }
		  else
		  {
		  		if(isset($institute)&& !empty($institute))
				{
			  	 	//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					//$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('project_master.status',1);
					//$where = "(( project_master.status=1) OR ( project_master.status=0))";
					$where = "(( project_master.status=1))";
				    	$this->db->where($where);
				}
		  }
		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		if(isset($institute)&& !empty($institute))
		{
		  //$this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		}
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
	  /*  echo $this->db->last_query();die;*/
		/*print_r($data);die;*/
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
			    $i++;
			 }
		}
		return $data;
	}
    function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
    public function getUserCompleteProject($uid='')
	{
		//echo "sadasdasdasdasdasdasdassasdesdddddddddddddddddddddddddddddddddddddddddddddddwwwwwwwwwwwwwwwwwwweeeeeeeeeeerrrrrrrrr";
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		//echo $user_id;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,users.profession,users.city,project_master.created,project_master.assignmentId,project_master.competitionId,project_master.assignment_status');
	    $this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$this->db->where('project_master.projectStatus',1);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
  				if($this->session->userdata('user_admin_level') == 1)
  				{
  					$where = "(( project_master.status=1) OR ( project_master.status=3))";
  					$this->db->where($where);
  					$this->db->where('users.instituteId',$institute[0]['instituteId']);
  				}				
  				else if($this->session->userdata('user_admin_level') == 4)
  				{	
  					  if(!empty($institute))
  					  {
  					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
  					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
  					  }		
  				}
  				else
  				{
  					
  					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
  					   {
  							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
  							{
  								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
  								if($user_id==$this->session->userdata('front_user_id'))
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
  						    			$this->db->where($where);
  								}
  								else
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=3))";
  							    		$this->db->where($where);
  								}
  							}
  							else
  							{
  								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
  								$this->db->where('project_master.status',1);
  							}
  						}
  						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
  						{
  							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
  							$this->db->where('project_master.status',1);
  						}
  						else
  						{
  							  if($user_id==$this->session->userdata('front_user_id'))
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=0))";
  						    			$this->db->where($where);
  								}
  								else
  								{
  									$this->db->where('project_master.status',1);
  								}
  						}
  				}
		  }		 
		  else
		  {
		  	 	if(isset($institute)&& !empty($institute))
				{
			  	 	//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					//$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('project_master.status',1);
					//$where = "(( project_master.status=1) OR ( project_master.status=0))";
					$where = "(( project_master.status=1))";
				    $this->db->where($where);
				}
		  }

		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->order_by('project_master.created','desc');
		/*if(isset($institute)&& !empty($institute))
		{
		  $this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		}*/
		//$this->db->group_by('project_master.id');
		$data = $this->db->get()->result_array();

		//print_r($data);die;
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
			    $i++;
			 }
		}
		/*
		print_r($data);die;
			echo $this->db->last_query();*/

		return $data;
	}
	public function overAllAvg($uid)
	{
		$this->db->select('AVG(project_attribute_value_rating.rating) as avg');
		$this->db->from('project_attribute_value_rating');
		$this->db->where('project_master.userId',$uid);
		$this->db->join('project_master', 'project_attribute_value_rating.projectId = project_master.id');
		return $this->db->get()->result_array();
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
	public function getUserWorkProgressProject($uid='')
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt');
		//$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$this->db->where('project_master.projectStatus',0);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			/* if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			   {
					if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
					{
						//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
					    $this->db->where($where);
					}
					else
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
						$this->db->where('project_master.status',1);
					}
				}
				elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
					$this->db->where('project_master.status',1);
				}
				else
				{
					  if($user_id==$this->session->userdata('front_user_id'))
						{
							$where = "(( project_master.status=1) OR ( project_master.status=0))";
				    		$this->db->where($where);
						}
						else
						{
							$this->db->where('project_master.status',1);
						}
				}*/
				if($this->session->userdata('user_admin_level') == 1)
				{
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
					$this->db->where($where);
					$this->db->where('users.instituteId',$institute[0]['instituteId']);
				}				
				else if($this->session->userdata('user_admin_level') == 4)
				{	
					  if(!empty($institute))
					  {
					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
					  }		
				}
				else
				{
					
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    		$this->db->where($where);
								}
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							  if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$this->db->where('project_master.status',1);
								}
						}
				}
		  }
		  else
		  {
	  	 		if(isset($institute)&& !empty($institute))
				{
			  	 	//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('project_master.status',1);
					$where = "(( project_master.status=1) OR ( project_master.status=0))";
				    $this->db->where($where);
				}
		  }
		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		/*if(isset($institute)&& !empty($institute))
		{
		  $this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		}*/
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
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
	public function getUserAppreciatedProject($uid='')
	{

		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt');
		//$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$this->db->order_by('project_master.like_cnt','desc');
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			/* if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			   {
					if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
					{
						//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
					    $this->db->where($where);
					}
					else
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
						$this->db->where('project_master.status',1);
					}
				}
				elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
					$this->db->where('project_master.status',1);
				}
				else
				{
					  if($user_id==$this->session->userdata('front_user_id'))
						{
							$where = "(( project_master.status=1) OR ( project_master.status=0))";
				    		$this->db->where($where);
						}
						else
						{
							$this->db->where('project_master.status',1);
						}
				}*/

				if($this->session->userdata('user_admin_level') == 1)
				{
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
					$this->db->where($where);
					$this->db->where('users.instituteId',$institute[0]['instituteId']);
				}				
				else if($this->session->userdata('user_admin_level') == 4)
				{	
					  if(!empty($institute))
					  {
					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
					  }		
				}
				else
				{
					
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    		$this->db->where($where);
								}
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							  if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$this->db->where('project_master.status',1);
								}
						}
				}
		  }
		  else
		  {
		  	 	if(isset($institute)&& !empty($institute))
				{
			  	 	//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('project_master.status',1);
					$where = "(( project_master.status=1) OR ( project_master.status=0))";
				    $this->db->where($where);
				}
		  }
		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		/*if(isset($institute)&& !empty($institute))
		{
		  $this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		}*/
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
	  /*  echo $this->db->last_query();
		print_r($data);die;*/
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
	public function getUserLikedOnProject($uid='')
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		  if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.status as project_normal_status');
		//$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('user_project_views.userId',$user_id);
		$this->db->where('user_project_views.userlike',1);
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id !=',$user_id);
		//$this->db->order_by('project_master.comment_cnt','desc');
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{*/
			//$this->db->where('project_master.status',1);
		/*}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			/* if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			   {
					if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
					{
						//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
					    $this->db->where($where);
					}
					else
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
						$this->db->where('project_master.status',1);
					}
				}
				elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
					$this->db->where('project_master.status',1);
				}
				else
				{
					$this->db->where('project_master.status',1);
				}*/

				if($this->session->userdata('user_admin_level') == 1)
				{
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
					$this->db->where($where);
					$this->db->where('users.instituteId',$institute[0]['instituteId']);
				}				
				else if($this->session->userdata('user_admin_level') == 4)
				{	
					  if(!empty($institute))
					  {
					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
					  }		
				}
				else
				{
					
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    		$this->db->where($where);
								}
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							  if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$this->db->where('project_master.status',1);
								}
						}
				}
		  }
		$this->db->limit(12);
		$this->db->join('project_master', 'user_project_views.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
	   // echo $this->db->last_query();
		//print_r($data);die;
		$data_array=array();
		if($this->uri->segment(1)=='profile')
		  {
				if(!empty($data))
			    { $i=0;
				 foreach($data as $row)
				 {
					$institute = $this->getUserInstituteId($row['userId']);
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
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
						elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
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
		  else
		  {
		  	$data_array = $data;
		  }
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
					$data_array[$i]['categoryName'] = $atrribute[0]['categoryName'];
					$data_array[$i]['atrribute'] = $arr;
					$data_array[$i]['attributeValue'] = $arr2;
			   	}
				else
				{
					$data_array[$i]['atrribute'] = array();
					$data_array[$i]['attributeValue'] = array();
					$data_array[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data_array[$i]['categoryId']."'");
				}
				if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
				{
					$this->db->select('*');
					$this->db->from('user_project_views');
					$this->db->where('projectId',$row['id']);
					$this->db->where('userId',$this->session->userdata('front_user_id'));
					$this->db->where('userLike',1);
					$data_array[$i]['userLiked'] = $this->db->get()->num_rows();
				}
				else{
					$data[$i]['userLiked']=0;
				}
			    $i++;
			 }
		}
		return $data_array;
	}
	public function getUserCommentedOnProject($uid='')
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		  if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.status as project_normal_status');
		//$this->db->select('*');
		$this->db->from('user_project_comment');
		$this->db->group_by('user_project_comment.projectId');
		$this->db->where('user_project_comment.status',1);
		$this->db->where('user_project_comment.userId',$user_id);
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->order_by('user_project_comment.id','desc');
		$this->db->where('users.id !=',$user_id);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{*/
			//$this->db->where('project_master.status',1);
		/*}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			 /*if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
			   {
					if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
					{
						//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
					    $this->db->where($where);
					}
					else
					{
						//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
						$this->db->where('project_master.status',1);
					}
				}
				elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
				{
					//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
					$this->db->where('project_master.status',1);
				}
				else
				{
					$this->db->where('project_master.status',1);
				}*/
				if($this->session->userdata('user_admin_level') == 1)
				{
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
					$this->db->where($where);
					$this->db->where('users.instituteId',$institute[0]['instituteId']);
				}				
				else if($this->session->userdata('user_admin_level') == 4)
				{	
					  if(!empty($institute))
					  {
					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
					  }		
				}
				else
				{
					
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    		$this->db->where($where);
								}
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							  if($user_id==$this->session->userdata('front_user_id'))
								{
									$where = "(( project_master.status=1) OR ( project_master.status=0))";
						    			$this->db->where($where);
								}
								else
								{
									$this->db->where('project_master.status',1);
								}
						}
				}
		  }
		$this->db->limit(12);
		$this->db->join('project_master', 'user_project_comment.projectId = project_master.id');
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		/*print_r($data);*/
		$data_array=array();
		if($this->uri->segment(1)=='profile')
		  {
				if(!empty($data))
			    { $i=0;
				 foreach($data as $row)
				 {
					$institute = $this->getUserInstituteId($row['userId']);
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
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
						elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
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
		  else
		  {
		  	$data_array = $data;
		  }
		//print_r($data_array);die;
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
					$data_array[$i]['categoryName'] = $atrribute[0]['categoryName'];
					$data_array[$i]['atrribute'] = $arr;
					$data_array[$i]['attributeValue'] = $arr2;
			   	}
				else
				{
					$data_array[$i]['atrribute'] = array();
					$data_array[$i]['attributeValue'] = array();
					$data_array[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data_array[$i]['categoryId']."'");
				}
				if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
				{
					$this->db->select('*');
					$this->db->from('user_project_views');
					$this->db->where('projectId',$row['id']);
					$this->db->where('userId',$this->session->userdata('front_user_id'));
					$this->db->where('userLike',1);
					$data_array[$i]['userLiked'] = $this->db->get()->num_rows();
				}
				else{
					$data[$i]['userLiked']=0;
				}
			    $i++;
			 }
		}
		return $data_array;
	}
	public function getUserCompetitionProject($uid='')
	{
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt');
		//$this->db->select('*');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$this->db->where('project_master.projectStatus',1);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		$this->db->where('project_master.status',1);
		$this->db->where('project_master.competitionId !=',0);
		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
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
	public function more_data($limit,$page,$uid,$active_tab)
		{

			$hoinstituteList = array();
			if($this->session->userdata('user_admin_level') == 4)
			{
				$front_user_id = $this->session->userdata('front_user_id');
				$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
				$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
			}

			if($uid != '')
			  {
				  $institute = $this->getUserInstituteId($uid);
			  }
			  else
			  {
			  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
			  }
			if($uid!='')
			{
				$user_id=$uid;
			}
			else
			{
				$user_id=$this->session->userdata('front_user_id');
			}
			$start=($page-1)*$limit;
			$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profession,users.city,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.status as project_normal_status,project_master.created,project_master.assignment_status,project_master.competitionId,project_master.assignmentId');
		   if($active_tab!='Discussed On' && $active_tab!='Liked On')
		   {
				$this->db->from('project_master');
				$this->db->where('user_project_image.cover_pic',1);
				$this->db->where('users.id',$user_id);
			   	if($active_tab=='Completed')
				{
					$this->db->where('project_master.projectStatus',1);
			   	}
			   	if($active_tab=='Showreel')
				{
					//$this->db->where('project_master.status',1);
					$this->db->where('project_master.showreel',1);					
				}
				if($active_tab=='Work in Progress')
				{
					$this->db->where('project_master.projectStatus',0);
				}
				if($active_tab=='Appreciated')
				{
					$this->db->order_by('project_master.like_cnt','desc');
					$this->db->where('project_master.like_cnt >',0);
				}
				if($active_tab=='Assignment')
				{
					//$this->db->where('project_master.status',1);
					$this->db->where('project_master.assignmentId !=',0);
				}
				/*if($this->session->userdata('sort_by')=='viewed')
				{
					 $this->db->order_by('project_master.view_cnt','desc');
				}*/
				/*if($this->session->userdata('sort_by')=='discussed')
				{
					$this->db->order_by('project_master.comment_cnt','desc');
				}*/
				if($active_tab=='Competition')
				{
					$this->db->where('project_master.status',1);
					$this->db->where('project_master.competitionId !=',0);
				}
				if($active_tab=='Saved as Draft')
				{
					$this->db->where('project_master.status',0);
				}
			

				//print_r($this->uri->segment(2));die;

				if($active_tab!='Saved as Draft')
				{

					if($this->session->userdata('user_admin_level') == 1)
					{
						$where = "(( project_master.status=1) OR ( project_master.status=3))";
						$this->db->where($where);
						$this->db->where('users.instituteId',$institute[0]['instituteId']);
					}				
					else if($this->session->userdata('user_admin_level') == 4)
					{	
						  if(!empty($institute))
						  {
						  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
						  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
						  }		
					}
					else
					{							
					
						if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
						  {					  	
							 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
							   {
									if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
									{
										//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
										$where = "(( project_master.status=1) OR ( project_master.status=3))";
									    $this->db->where($where);
									}
									else
									{
										//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
										$this->db->where('project_master.status',1);
									}
								}
								elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
								{
									//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
									$this->db->where('project_master.status',1);
								}
								else
								{
									  if($user_id==$this->session->userdata('front_user_id'))
										{
											//$where = "(( project_master.status=1) OR ( project_master.status=0))";
											$where = "(( project_master.status=1))";
								    		$this->db->where($where);
										}
										else
										{
											$this->db->where('project_master.status',1);
										}
								}
						  }
						  else
						  {					  	
					  	 	if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
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
					}
				}
			//	die;
			   	$this->db->limit($limit);
				$this->db->offset($start);
				$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
				$this->db->join('users', 'users.id = project_master.userId');
				//$this->db->group_by('project_master.id');
				$this->db->order_by('project_master.created','desc');
			    $data_array = $this->db->get()->result_array();
			    //echo $this->db->last_query();
			    
			}
			if($active_tab=='Discussed On')
		    {
				$this->db->from('user_project_comment');
				//$this->db->group_by('user_project_comment.projectId');
				/*		$this->db->where('user_project_comment.status',1);*/
				$this->db->where('user_project_comment.assignmentId',0);
				$this->db->where('project_master.socialFeatures',1);
				$this->db->where('user_project_comment.userId',$user_id);
				$this->db->where('user_project_image.cover_pic',1);
				$this->db->order_by('user_project_comment.id','desc');
				$this->db->where('users.id !=',$user_id);
				/*if($this->session->userdata('front_user_id')!=$user_id)
				{*/
				 //$this->db->where('project_master.status',1);
				/*}*/
				if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
				{
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    $this->db->where($where);
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							$this->db->where('project_master.status',1);
						}
				}
				$this->db->limit($limit);
				$this->db->offset($start);
				$this->db->join('project_master', 'user_project_comment.projectId = project_master.id');
				$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
				$this->db->join('users', 'users.id = project_master.userId');
				$this->db->group_by('project_master.id');
				$data = $this->db->get()->result_array();
			   // echo $this->db->last_query();
				$data_array=array();
				if($this->uri->segment(1)=='profile')
				{
						if(!empty($data))
					    { $i=0;
						 foreach($data as $row)
						 {
							$institute = $this->getUserInstituteId($row['userId']);
							 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
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
								elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
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
			  	else
			  	{
			  		$data_array = $data;
			  	}
			}
			if($active_tab=='Liked On')
		    	{
		   		$this->db->from('user_project_views');
				$this->db->where('user_project_views.userId',$user_id);
				$this->db->where('user_project_views.userlike',1);
				$this->db->where('user_project_image.cover_pic',1);
				$this->db->where('users.id !=',$user_id);
				//$this->db->order_by('project_master.comment_cnt','desc');
				/*if($this->session->userdata('front_user_id')!=$user_id)
				{*/
				// $this->db->where('project_master.status',1);
				/*}*/
				if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
				  {
					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
					   {
							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
							{
								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
								$where = "(( project_master.status=1) OR ( project_master.status=3))";
							    $this->db->where($where);
							}
							else
							{
								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
								$this->db->where('project_master.status',1);
							}
						}
						elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
						{
							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
							$this->db->where('project_master.status',1);
						}
						else
						{
							$this->db->where('project_master.status',1);
						}
				  }
				$this->db->limit($limit);
				$this->db->offset($start);
				$this->db->join('project_master', 'user_project_views.projectId = project_master.id');
				$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
				$this->db->join('users', 'users.id = project_master.userId');
				$this->db->group_by('project_master.id');
				$data = $this->db->get()->result_array();
			    $data_array=array();
				if($this->uri->segment(1)=='profile')
				  {
						if(!empty($data))
					    { $i=0;
						 foreach($data as $row)
						 {
							$institute = $this->getUserInstituteId($row['userId']);
							 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
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
								elseif(isset($institute)&&!empty($institute)&&$this->session->userdata('user_institute_id')=='')
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
				  else
				  {
				  	$data_array = $data;
				  }
			}
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
				 	//print_r($atrribute);
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
						$data_array[$i]['categoryName'] = $atrribute[0]['categoryName'];
						$data_array[$i]['atrribute'] = $arr;
						$data_array[$i]['attributeValue'] = $arr2;
				   	}
					else
					{
						$data_array[$i]['atrribute'] = array();
						$data_array[$i]['attributeValue'] = array();
						$data_array[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data_array[$i]['categoryId']."'");
					}
					$data_array[$i]['created']=date("d F Y",strtotime($data_array[$i]['created']));
					$imageCount = $this->getCount('user_project_image','project_id',$row['id']);
					$data_array[$i]['imageCount'] = $imageCount;
					if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
					{
						$this->db->select('*');
						$this->db->from('user_project_views');
						$this->db->where('projectId',$row['id']);
						$this->db->where('userId',$this->session->userdata('front_user_id'));
						$this->db->where('userLike',1);
						$data_array[$i]['userLiked'] = $this->db->get()->num_rows();
					}
					else{
						$data_array[$i]['userLiked']=0;
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
								$data_array[$i]['droupdown']=$str;
							}
							else
							{
								$str .='<ul class="dropdown-menu"></ul>';
								$data_array[$i]['droupdown']=$str;
							}	
	    		    $i++;
				 }
			}
			if(!empty($data_array))
			{
				echo json_encode($data_array);
			}
			else
			{
				echo '';
			}
		}
	public function project_like_count($project_id)
	{
		$this->db->select('*');
		$this->db->from('user_project_views');
		$this->db->where('projectId',$project_id);
		$this->db->where('userLike',1);
	    return $this->db->get()->num_rows();
	}

    	public function checkRecentLike()
	{
		$this->db->select('project_master.projectName,project_master.id,user_project_views.userLike,users.firstName,users.profileImage,users.lastName,user_project_views.like_date as created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		$this->db->where('user_project_views.userId !=',$this->session->userdata('front_user_id'));
	   	//$this->db->limit(10);
		$this->db->where('user_project_views.userLike',1);
		$this->db->where('user_project_views.read',0);
		$this->db->order_by('user_project_views.like_date','desc');
		$this->db->join('user_project_views', 'user_project_views.projectId = project_master.id');
		$this->db->join('users', 'users.id = user_project_views.userId');
		return $this->db->get()->result_array();
	}
	public function checkRecentComment()
	{
		$this->db->select('project_master.projectName,project_master.id,user_project_comment.comment,users.profileImage,users.firstName,users.lastName,user_project_comment.created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		$this->db->where('user_project_comment.userId !=',$this->session->userdata('front_user_id'));
	   //	$this->db->limit(10);
		$this->db->where('user_project_comment.status',1);
		$this->db->where('user_project_comment.read',0);
		$this->db->order_by('user_project_comment.created','desc');
		$this->db->join('user_project_comment', 'user_project_comment.projectId = project_master.id');
	    $this->db->join('users', 'users.id = user_project_comment.userId');
		return $this->db->get()->result_array();
	}
	public function checkRecentfollowing()
	{
		$this->db->select('users.id as userId,users.firstName as followed_by_fname,users.lastName as followed_by_lname,users.profileImage,user_follow.read,user_follow.created');
		$this->db->from('user_follow');
		$this->db->where('user_follow.followingUser',$this->session->userdata('front_user_id'));
		$this->db->where('user_follow.read',0);
		$this->db->join('users', 'users.id = user_follow.userId');
	    return $this->db->get()->result_array();
	}
	public function getAllfollowing()
	{
		$this->db->select('users.id as userId,users.firstName as followed_by_fname,users.lastName as followed_by_lname,users.profileImage,user_follow.read,user_follow.created');
		$this->db->from('user_follow');
		$this->db->where('user_follow.followingUser',$this->session->userdata('front_user_id'));
		$this->db->join('users', 'users.id = user_follow.userId');
		return $this->db->get()->result_array();
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
	public function checkRecentJob()
	{
		$createdDate=$this->model_basic->getValue('users','created'," `id` = '".$this->session->userdata('front_user_id')."'");
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('status',1);
		if($createdDate != '')
		{
			$this->db->where('created > ',$createdDate);
		}
		$data = $this->db->get()->result_array();
		$arr=array();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$job = $this->check_job_notification_relation($row['id']);
				if(empty($job))
				{
					$arr[] = $row;
				}
		    }
		}
		return $arr;
    }
    public function checkRecentEvent()
	{
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('status',1);
		$data = $this->db->get()->result_array();
		$arr=array();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$event = $this->check_event_notification_relation($row['id']);
				if(empty($event))
				{
					$arr[] = $row;
				}
		    }
		}
		return $arr;
    }
    public function checkRecentCompetition($user_institute_id)
	{
		if($user_institute_id!='')
		{
			$this->db->select('*');
			$this->db->from('competitions');
			$this->db->where('status',1);
			$this->db->where('instituteId',$user_institute_id);
			$user_institute_competition = $this->db->get()->result_array();
		}
		else
		{
			$user_institute_competition = array();
		}
		$this->db->select('*');
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
		$arr=array();
		if(!empty($det))
		{
			foreach($det as $row)
			{
				$competition = $this->check_competition_notification_relation($row['id']);
				if(empty($competition))
				{
					$arr[] = $row;
				}
		    }
		}
		return $arr;
    }
    /*New Change*/
    public function getAllRecentFedback($instituteId){
    	$this->db->select('*');
    	$this->db->from('feedback_instance');
    	$this->db->where('status',1);
    	$this->db->where('institute_id',$instituteId);
    	$data = $this->db->get()->result_array();
    	$arr=array();
    	if(!empty($data))
    	{
    		foreach($data as $row)
    		{
    			$event = $this->check_feedback_notification_relation($row['id']);
    			if(empty($event))
    			{
    				$arr[] = $row;
    			}
    	    }
    	}
    	return $arr;
    }
    public function check_feedback_notification_relation($id)
    {
    	$this->db->select('*');
    	$this->db->from('feedback_user_notification');
    	$this->db->where('userId',$this->session->userdata('front_user_id'));
    	$this->db->where('instance_id',$id);
        return $this->db->get()->result_array();
    }
    	public function getAllRecentFedbackData($instituteId)
    	{
    		$createdDate=$this->model_basic->getValue('users','created'," `id` = '".$this->session->userdata('front_user_id')."'");
    		$this->db->select('feedback_instance.id as feedback_instanceId,institute_master.instituteLogo,feedback_instance.name,feedback_instance.created');
    		$this->db->from('feedback_instance');
    		$this->db->join('institute_master','institute_master.id=feedback_instance.institute_id');
    		$this->db->where('feedback_instance.status',1);
    		if($createdDate != '')
    		{
    			$this->db->where('feedback_instance.created > ',$createdDate);
    		}
    		$this->db->where('feedback_instance.institute_id',$instituteId);
    		return $this->db->get()->result_array();
    }
    /*New Change*/
   	 public function getAllJob()
	{
		$createdDate=$this->model_basic->getValue('users','created'," `id` = '".$this->session->userdata('front_user_id')."'");
		$this->db->select('jobs.id as jobId,jobs.companyLogo,jobs.title as job_title,jobs.created');
		$this->db->from('jobs');
		$this->db->where('status',1);
		if($createdDate != '')
		{
			$this->db->where('created > ',$createdDate);
		}
		return $this->db->get()->result_array();
	}
	public function getAllCompetition($user_institute_id)
	{
		$createdDate=$this->model_basic->getValue('users','created'," `id` = '".$this->session->userdata('front_user_id')."'");
		if($user_institute_id!='')
		{
			$this->db->select('competitions.id as competitionId,competitions.profile_image,competitions.name as competition_name,competitions.created');
			$this->db->from('competitions');
			$this->db->where('status',1);
			if($createdDate != '')
			{
				$this->db->where('created > ',$createdDate);
			}
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
		if($createdDate != '')
		{
			$this->db->where('created > ',$createdDate);
		}
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
	public function getAllEvent()
	{
		$createdDate=$this->model_basic->getValue('users','created'," `id` = '".$this->session->userdata('front_user_id')."'");
		$this->db->select('events.id as eventId,events.banner,events.name as event_name,events.created');
		$this->db->from('events');
		$this->db->where('status',1);
		if($createdDate != '')
		{
			$this->db->where('created > ',$createdDate);
		}
		return $this->db->get()->result_array();
	}
   public function getAllLike()
	{
		$this->db->select('project_master.projectName,project_master.projectPageName,project_master.id,user_project_views.userLike,users.firstName,users.profileImage,users.lastName,user_project_views.read,user_project_views.like_date as created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		$this->db->where('user_project_views.userId !=',$this->session->userdata('front_user_id'));
	   	//$this->db->limit(10);
		$this->db->where('user_project_views.userLike',1);
		//$this->db->where('user_project_views.read',0);
		$this->db->order_by('user_project_views.like_date','desc');
		$this->db->join('user_project_views', 'user_project_views.projectId = project_master.id');
		$this->db->join('users', 'users.id = user_project_views.userId');
		return $this->db->get()->result_array();
	}
	public function getAllComment()
	{
		$this->db->select('project_master.projectPageName,project_master.projectName,project_master.id,user_project_comment.comment,user_project_comment.read,users.profileImage,users.firstName,users.lastName,user_project_comment.created');
	    $this->db->from('project_master');
		$this->db->where('project_master.userId',$this->session->userdata('front_user_id'));
		$this->db->where('user_project_comment.userId !=',$this->session->userdata('front_user_id'));
	   //	$this->db->limit(10);
		//$this->db->where('user_project_comment.status',1);
		//$this->db->where('user_project_comment.read',0);
		$this->db->order_by('user_project_comment.created','desc');
		$this->db->join('user_project_comment', 'user_project_comment.projectId = project_master.id');
	    $this->db->join('users', 'users.id = user_project_comment.userId');
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
	public function get_project_attribute_value($project_id,$attribute_id)
	{
		$this->db->select('attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('project_attribute_relation');
		$this->db->where('project_attribute_relation.projectId',$project_id);
		$this->db->where('project_attribute_relation.attributeId',$attribute_id);
		$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
	    return $this->db->get()->result_array();
    }
    public function getUsersAllProject($userId)
    {
    		if($userId != ''){
    			$user_id = $userId;
    		}else{
    			$user_id = $this->session->userdata('front_user_id');
    		}
    		//$user_id=$this->session->userdata('front_user_id');
    		return $this->db->select('id')->from('project_master')->where('userId',$user_id)->get()->result_array();
    }
     public function getAllImages($projectId)
    {
    		return $this->db->select('B.image_thumb')->from('project_master as A')->join('user_project_image as B','B.project_id=A.id')->where('A.id',$projectId)->get()->result_array();
    }
    public function getInstAdminData($institute_id)
    {
    		return $this->db->select('B.email,A.instituteName,B.firstName,B.lastName')->from('institute_master as A')->join('users as B','B.id=A.adminId')->where('A.id',$institute_id)->get()->result_array();
    }
    public function getFrontUserData($user_id)
    {
    		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->result_array();
    }
    public function getAllowedDiskSpace($userId)
    {
    	if($userId != ''){
    		$uId = $userId;
    	}else{
    		$uId = $this->session->userdata('front_user_id');
    	}
    	$this->db->select('disk_space as description');
    	$this->db->from('users');
    	$this->db->where('id',$uId);
    	$data = $this->db->get()->result_array();
    	if(empty($data) || $data[0]['description'] == 0 ){
    		$data = $this->db->select('*')->from('settings')->where('settings_id',14)->get()->result_array();
    	}
    	return $data;
    }
    public function getAllFeedbackInstance(){
    	$this->db->select('*');
    	$this->db->from('feedback_instance');
    	$this->db->where('status',1);
    	$this->db->where('institute_id',$this->session->userdata('user_institute_id'));
    	return $this->db->get()->result_array();
    }
    public function checkFeedbackExist($instanceId,$status=''){
    	//fetch start and end date from instanceid
    	//check if this end date is less than or equal to current date
    	$flag=0;
    	$this->db->select('*');
    	$this->db->from('feedback_instance');
    	$this->db->where('id',$instanceId);
    	$instanceData = $this->db->get()->row_array();
    	//print_r($instanceData);die;
    	if(!empty($instanceData)){
    		$startDate = $instanceData['start_session'];
    		$endDate = $instanceData['end_session'];
    		$flag = 1;
    	}else{
    		$flag = 2;
    	}
    	if($flag==1){
    		if(($startDate <= date("Y-m-d")) && ($endDate >= date("Y-m-d"))){
	    		$this->db->select('*');
	    		$this->db->from('institutefeedback');
	    		$this->db->where('instance_id',$instanceId);
	    		$this->db->where('user_id',$this->session->userdata('front_user_id'));
	    		$this->db->where('institute_id',$this->session->userdata('user_institute_id'));
	    		$data = $this->db->get()->result_array();
	    		//echo $this->db->last_query();
	    		//print_r($data);die;
	    		if(!empty($data) || $status ==1){
	    			 $data[0]['showbtn']=1;
	    			 $data[0]['msg']='valid';
	    		}
	    		return $data;
    		}else if($endDate < date("Y-m-d")){
    			$this->db->select('*');
    			$this->db->from('institutefeedback');
    			$this->db->where('instance_id',$instanceId);
    			$this->db->where('user_id',$this->session->userdata('front_user_id'));
    			$this->db->where('institute_id',$this->session->userdata('user_institute_id'));
    			$data = $this->db->get()->result_array();
    			//if(!empty($data)){
	    			$data[0]['showbtn']=0;
	    			$data[0]['msg']='invalid';
    			//}
	    		return $data;
    		}else if($startDate > date("Y-m-d")){
    			$data  = array();
	    		$data[0]['showbtn']=0;
	    		$data[0]['msg']='invalid';
	    		return $data;
    		}
    	}else{
    		return FALSE;
    	}
    }
	public function updateGoogleDriveSetting($googleDriveSetting){
	    	$this->db->where('id',$this->session->userdata('front_user_id'));
	    	return $this->db->update('users', array('google_drive_setting' => $googleDriveSetting ));
	}
	public function getUserGoogleSetting(){
		$this->db->select('google_drive_setting,move_to_google_drive');
		$this->db->from('users');
		$this->db->where('id',$this->session->userdata('front_user_id'));
		return $this->db->get()->row_array();
	}
	public function getLastFeedback($id=''){
		$this->db->select('institutefeedback.*');
		$this->db->from('institutefeedback');
		$this->db->join('feedback_instance','feedback_instance.id = institutefeedback.instance_id');
		$this->db->where('institutefeedback.user_id',$this->session->userdata('front_user_id'));
		if($id!='')
		{
			$this->db->where('institutefeedback.instance_id',$id);
		}
		else
		{
			$this->db->order_by('institutefeedback.created','desc');
		}
		$result = $this->db->get()->row_array();
		if(!empty($result))
		{
			$status = $this->checkFeedbackExist($result['instance_id']);
		}
		if(!empty($status) && $status!=FALSE){
			if($status[0]['msg']=='invalid'){
				$result['status']='invalid';
			}else{
				$result['status']='valid';
			}
			return $result;
		}
	}
	public function getTestimonials($uid='')
	{
	    if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}
		$data = $this->db->select('A.comment,A.appreciateByUserId,B.firstName,B.lastName')->from('project_appreciation as A')->join('users as B','B.id = A.appreciateByUserId','left')->where('A.appreciatedUserId',$user_id)->where('A.status',1)->get()->result_array();

		return $data;
	}
    public function getalluserdata()
    {
    	return $this->db->select('users.id as sr,institute_csv_users.studentid as StudentId,users.firstName as FirstName,users.lastName as LastName,users.email as EmailId,users.deviceId as isAppInstalled')->from('users')->join('institute_csv_users','users.email = institute_csv_users.email','left')->get()->result_array();
    }


    public function getUsershowreelProject($uid='')
	{
		$hoinstituteList = array();
		if($this->session->userdata('user_admin_level') == 4)
		{
			$front_user_id = $this->session->userdata('front_user_id');
			$hoadmin_id = $this->db->select('A.id')->from('admin as A')->join('users as U','U.email=A.email')->where('U.id',$front_user_id)->get()->row_array();
			$hoinstituteList = $this->model_basic->getHoadminInstitutes($hoadmin_id['id']);						
		}

		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
			  $institute = $this->getUserInstituteId($this->uri->segment(3));
		  }
		  else
		  {
		  	  $institute = $this->getUserInstituteId($this->session->userdata('front_user_id'));
		  }
		if($uid!='')
		{
			$user_id=$uid;
		}
		else
		{
			$user_id=$this->session->userdata('front_user_id');
		}

		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,users.profession,users.city,project_master.created,project_master.assignmentId,project_master.competitionId,project_master.assignment_status');
	    $this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('users.id',$user_id);
		$this->db->where('project_master.projectStatus',1);
		$this->db->where('project_master.showreel',1);
		/*if($this->session->userdata('front_user_id')!=$user_id)
		{
			$this->db->where('project_master.status',1);
		}*/
		if($this->uri->segment(1)=='user' && $this->uri->segment(2)=='userDetail' && $this->uri->segment(3)!='')
		  {
  				if($this->session->userdata('user_admin_level') == 1)
  				{
  					$where = "(( project_master.status=1) OR ( project_master.status=3))";
  					$this->db->where($where);
  					$this->db->where('users.instituteId',$institute[0]['instituteId']);
  				}				
  				else if($this->session->userdata('user_admin_level') == 4)
  				{	
  					  if(!empty($institute))
  					  {
  					  	if (in_array($institute[0]['instituteId'], $hoinstituteList))
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
  					  	$this->db->where('users.instituteId',$institute[0]['instituteId']);
  					  }		
  				}
  				else
  				{
  					
  					 if(isset($institute)&& !empty($institute)&&$this->session->userdata('user_institute_id')&&$this->session->userdata('user_institute_id')!='')
  					   {
  							if($institute[0]['instituteId']==$this->session->userdata('user_institute_id'))
  							{
  								//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
  								if($user_id==$this->session->userdata('front_user_id'))
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
  						    			$this->db->where($where);
  								}
  								else
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=3))";
  							    		$this->db->where($where);
  								}
  							}
  							else
  							{
  								//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
  								$this->db->where('project_master.status',1);
  							}
  						}
  						elseif(isset($institute)&&!empty($institute)&& $institute[0]['instituteId']!=0 && $this->session->userdata('user_institute_id')=='')
  						{
  							//$this->db->where('institute_csv_users.instituteId',$institute[0]['instituteId']);
  							$this->db->where('project_master.status',1);
  						}
  						else
  						{
  							  if($user_id==$this->session->userdata('front_user_id'))
  								{
  									$where = "(( project_master.status=1) OR ( project_master.status=0))";
  						    			$this->db->where($where);
  								}
  								else
  								{
  									$this->db->where('project_master.status',1);
  								}
  						}
  				}
		  }		 
		  else
		  {
		  	 	if(isset($institute)&& !empty($institute))
				{
			  	 	//$this->db->where('institute_csv_users.instituteId',$this->session->userdata('user_institute_id'));
					//$where = "(( project_master.status=1) OR ( project_master.status=3) OR ( project_master.status=0))";
					$where = "(( project_master.status=1) OR ( project_master.status=3))";
				    $this->db->where($where);
				}
				else
				{
					//$this->db->where('project_master.status',1);
					//$where = "(( project_master.status=1) OR ( project_master.status=0))";
					$where = "(( project_master.status=1))";
				    $this->db->where($where);
				}
		  }

		$this->db->limit(12);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		/*if(isset($institute)&& !empty($institute))
		{
		  $this->db->join('institute_csv_users', 'users.email = institute_csv_users.email');
		}*/
		$this->db->group_by('project_master.id');
	    $data = $this->db->get()->result_array();
		/*print_r($data);die;*/
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
			    $i++;
			 }
		}
		//	print_r($data);die;
		return $data;
	}
	public function checkshowreel($uid='')
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
	    $this->db->from('project_master');
		$this->db->where('userId',$user_id);
		$this->db->where('showreel',1);
	    $query = $this->db->get();
		$rowcount = $query->num_rows();
		// /echo $this->db->last_query();
		return $rowcount;
	}
	public function getlogin_countofuser()
	{
		$query =$this->db->query("SELECT COUNT( DISTINCT (
institute_csv_users.id
) ) AS total
FROM institute_csv_users
WHERE institute_csv_users.centerId =1
AND institute_csv_users.email != ''
AND institute_csv_users.studentid != ''");
	  	 $arr   = $query->row_array(); 
    		$total = $arr['total'];  
		return $total;
	}
}