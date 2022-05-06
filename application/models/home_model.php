<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*public function getAllProjectData()
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->limit(10);
		$this->db->order_by('project_master.featured_date','desc');
		$this->db->where('project_master.featured',1);
		$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		$new_array = array();
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$data[$i]['atrribute'] = array();
				$data[$i]['attributeValue'] = array();
				$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				$data[$i]['userLiked']=0;
				$i++;
			}
		}
		return $data;
	}*/
  
    public function getAllProjectData_latestcresosouls()
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created,institute_master.PageName');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where('project_master.like_cnt >=10');
		$this->db->limit(10);
		//$this->db->order_by('project_master.created','desc');
		$this->db->order_by('project_master.featured_date','desc');
		$this->db->where('project_master.featured',1);
		$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('institute_master', 'institute_master.id = users.instituteId');
		$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		//echo $this->db->last_query();
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
  
	public function getAllProjectData()
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created,institute_master.PageName');
		$this->db->from('project_master');

		//$data['project']=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName,project_master.userId',array('user_project_image.cover_pic'=>1,'project_master.featured'=>1,'project_master.status'=>1),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.featured_date','DESC'),10);

		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where('project_master.like_cnt >=10');
		$this->db->limit(10);
		//$this->db->order_by('project_master.created','desc');
		$this->db->order_by('project_master.featured_date','desc');
		$this->db->where('project_master.featured',1);
		$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		$this->db->join('users', 'users.id = project_master.userId');
		$this->db->join('category_master', 'category_master.id = project_master.categoryId');
		//$this->db->join('institute_master', 'institute_master.id = users.instituteId');
		//$this->db->join('project_attribute_relation', 'project_attribute_relation.projectId = project_master.id', 'left');
		//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		//$this->db->group_by('project_master.id');
		$data      = $this->db->get()->result_array();
		//echo $this->db->last_query();
		return $data;
	}
	public function addFeedBack($data)
	{
		return $this->db->insert('feedback',$data);
	}
	public function getRecentBlog()
	{
		$this->db->select('*');
		$this->db->from('blog');
		$this->db->where('status',1);
		$this->db->order_by('created','desc');
		$this->db->limit(1);
		return $this->db->get()->result_array();
	}
	function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
	public function getClients()
	{
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
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
	public function get_project_attribute_value($project_id,$attribute_id)
	{
		$this->db->select('attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('project_attribute_relation');
		$this->db->where('project_attribute_relation.projectId',$project_id);
		$this->db->where('project_attribute_relation.attributeId',$attribute_id);
		$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
		return $this->db->get()->result_array();
	}

	public function getAllJobsData()
	{
		$data = $this->db->select('id')->from('region_list')->get()->result_array();
		$region_id =array();
		if(!empty($data))
		{
			foreach ($data as $key => $value)
			{
				$region_id[] .= $value['id'];
			}
		}

		$this->db->select('A.*,count(*) as jobcount');
		$this->db->from('jobs as A');
		$this->db->join('job_zone_relation as B','B.job_id = A.id');
		$this->db->where('A.status',1);
		$this->db->where('B.region_id !=',0);
		if(!empty($region_id))
		{
			foreach ($region_id as $key => $value) {
				$this->db->or_where('B.region_id',$value);

			}

		}
		$this->db->group_by('B.job_id');
		$this->db->order_by('A.created','desc');
		$this->db->having('jobcount',count($region_id));
		$this->db->limit(7);
		return $this->db->get()->result_array();
	}

	public function getAllJobsImagesData()
	{
		$this->db->select('DISTINCT(companyName),companyLogo');
		$this->db->from('jobs');
        $this->db->where('status',1);
        $this->db->where('companyLogo != ','');
        $this->db->group_by('companyName');
        $this->db->order_by('created','desc');
        $this->db->limit(10);
        return $this->db->get()->result_array();
	}
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
	public function getAllEventData()
	{
		$this->markExpiredEvents();
		$this->db->select('*');
		$this->db->from('events');
		$this->db->limit(6);
		$this->db->where('status !=',0);
		$this->db->where('featured',1);
		$this->db->order_by('created','desc');
	    return $this->db->get()->result_array();
    }
	public function markCompletedCompetions()
	{
		$this->db->select('*');
		$this->db->from('competitions');
	   	$det = $this->db->get()->result_array();
	   //print_r($det);die;
		foreach($det as $val)
		{
			$todayDate				=	date('Y-m-d');
			$evaluationEndDate		=	$val['evaluation_end_date'];
			$evaluationStartDate	=	$val['evaluation_start_date'];
			$endDate				=	$val['end_date'];
			$startDate				=	$val['start_date'];
			$checkWinnerEntry		=	$this->model_basic->getValue('competition_winning_projects','projectId'," `competitionId` = '".$val['id']."'");
			//echo $todayDate;
			//
			//echo $checkWinnerEntry;die;
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
					}
					elseif($todayDate >=$evaluationStartDate && $todayDate <=$evaluationEndDate)
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
	public function getAllCompetionData()
	{
		$this->markCompletedCompetions();
		$this->db->select('id,name,banner,profile_image,instituteId,pageName');
		$this->db->from('competitions');
		$this->db->limit(4);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    $data = $this->db->get()->result_array();
	     if(isset($data) && !empty($data))
	     {
	     		$i=0;
	     		foreach ($data as $value)
	     		{
	     			if($value['instituteId']==0)
	     			{
						$data[$i]['instituteName'] = 'Team creosouls';
					}
					else{
						$this->db->select('instituteName');
						$this->db->from('institute_master');
						$this->db->where('id',$value['instituteId']);
					    $data[$i]['instituteName'] = $this->db->get()->row()->instituteName;
					}
/*	     			$data[$i]['userCount']=$this->getUserCount($value['id']);
	     			$data[$i]['projectCount']=$this->getProjectCount($value['id']);
	     			$data[$i]['commentCount']=$this->getCommentCount($value['id']);
	     			$data[$i]['likeCount']=$this->getLikeCount($value['id']);*/
	     			$i++;
	     		}
	     }
	     //print_r($data);
	     return $data;
      }
	public function getTestimonial()
	{
		$this->db->select('*');
		$this->db->from('testimonials');
		//$this->db->where('project_attribute_relation.projectId',$project_id);
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
    public function get_all_category()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->order_by('categoryName','asc');
	    return $this->db->get()->result_array();
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
	public function get_category_attribute($cat_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_master');
		$this->db->join('category_attribute_relation', 'attribute_master.id = category_attribute_relation.attributeId');
		$this->db->where('categoryId',$cat_id);
		$this->db->order_by('attributeName','asc');
	    return $this->db->get()->result_array();
    }
	public function get_attribute_value_detail($attri_val_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('id',$attri_val_id);
	    return $this->db->get()->result_array();
 	}
 	public function checkStudentId()
 	{
 		$studentId=$_POST['studentId'];
		$this->db->select('status,email,paymentStatus,centerId');
		$this->db->from('institute_csv_users');
		$this->db->where('studentId',$studentId);
		return $this->db->get()->row_array();
 	}

 			/**
 	 * [lakmeCheckStudentId description]
 	 * @return [type] [description]
 	 */
 	 	public function lakmeCheckStudentId()
 	{
 		$studentId=$_POST['studentId'];
 		$lakme = $this->load->database('lakme_db', TRUE);
 		$studentData = $lakme->select('status,email,paymentStatus,centerId')->from('institute_csv_users')->where('studentId',$_POST['studentId'])->get()->row_array();

		return $studentData;
 	}




 	public function jobStatusFeedback()
 	{
 		$userId = $this->session->userdata('front_user_id');
 		if($userId !='')
 		{
 			$data = $this->db->select('A.id,A.userId,A.jobId,A.apply_status,B.companyName,B.title')->from('job_user_relation as A')->join('jobs as B','B.id = A.jobId')->where('A.userId',$userId)->where('A.apply_status',3)->order_by('A.modified_date','desc')->get()->result_array();
 			return $data;
 		}

 	}
	public function getTrandingInstitute()
	{
		/*$query1=$this->db->query("SELECT region_name,id FROM region_list");
		if($query1->num_rows()>=0)
		{
			$region=$query1->result();
			foreach ($region as $key)
			{
				$region=$key->id;
				$this->db->select('rl.region_name,count(pm.id) AS cnt,im.instituteName,im.coverImage,im.PageName,im.contactNo');
				$this->db->from('users u');
				$this->db->join('institute_master im','u.instituteId=im.id');
				$this->db->join('region_list rl','im.region=rl.id');
				$this->db->join('project_master pm','pm.userId=u.id');
				$this->db->WHERE('u.status','1');
				$this->db->WHERE('im.region',$region);
				$this->db->group_by('rl.id');
				$this->db->order_by('cnt','DESC');
				$this->db->limit(1);
				$query = $this->db->get();

			    if($query->num_rows() > 0)
                {
                    $tbl_data['std_data']=$query->result_array();
               	}
               	else
               	{
               		$tbl_data['std_data']=null;
                }
                $data[]=$tbl_data;
			}
			return  $data;
		}*/

		$this->db->select('rl.region_name,count(*) AS cnt,im.instituteName,im.coverImage,im.PageName,im.contactNo');
		$this->db->from('users u');
		$this->db->join('institute_master im','u.instituteId=im.id');
		$this->db->join('region_list rl','im.region=rl.id');
		$this->db->join('project_master pm','pm.userId=u.id');
		//$this->db->WHERE('u.status','1');
		//$this->db->WHERE('pm.status','1');
		//$this->db->WHERE('u.instituteId!=',1,FALSE);
		//$this->db->WHERE("u.instituteId!=",0,FALSE);
		$this->db->WHERE('im.status','1');
		$this->db->group_by('im.id');
		$this->db->order_by('cnt','DESC');
		$this->db->limit(10);
		//echo $this->db->last_query();
	    return $this->db->get()->result_array();

	}
	public function getTrandingStudent()
	{
		/*$query1=$this->db->query("SELECT region_name,id FROM region_list");
		if($query1->num_rows()>=0)
		{
			$region=$query1->result();
			foreach ($region as $key)
			{
				$region=$key->id;
				$this->db->select("rl.region_name,u.id as userId,u.instituteId,im.instituteName,u.firstname,u.lastname,u.city,u.country,u.profession,u.profileimage,COUNT(DISTINCT pm.id) AS project_count,pm.id AS projectId",FALSE);
				$this->db->from('users u');
				$this->db->join('institute_master im','u.instituteId=im.id');
				$this->db->join('region_list rl','im.region=rl.id');
				$this->db->join('project_master pm','pm.userId=u.id');
				$this->db->WHERE('u.status',1);
				$this->db->WHERE('im.region',$region);
				$this->db->group_by('u.id');
				$this->db->order_by('project_count','DESC');
				$this->db->limit(1);
				//echo $this->db->last_query();
				$query = $this->db->get();

			    if($query->num_rows() > 0)
                {
                    $tbl_data['std_data']=$query->result_array();
               	}
               	else
               	{
               		$tbl_data['std_data']=null;
                }
                $data[]=$tbl_data;
			}
			return  $data;
		}	*/


		$this->db->select("rl.region_name,u.id as userId,u.instituteId,im.instituteName,u.firstname,u.lastname,u.city,u.country,u.profession,u.profileimage,COUNT(DISTINCT pm.id) AS project_count",FALSE);
		$this->db->from('users u');
		$this->db->join('institute_master im','u.instituteId=im.id');
		$this->db->join('region_list rl','im.region=rl.id');
		$this->db->join('project_master pm','pm.userId=u.id');
		$this->db->WHERE('u.status','1');
		$this->db->WHERE('pm.status','1');
		$this->db->WHERE('u.admin_level','0');
		$this->db->WHERE('u.instituteId!=',1,FALSE);
		$this->db->WHERE("u.instituteId!=",0,FALSE);
		$this->db->group_by('u.id');
		$this->db->order_by('project_count','DESC');
		$this->db->limit(10);
		//echo $this->db->last_query();
	    return $this->db->get()->result_array();
	}
	public function getTrandingPlacement()
	{
		$this->db->select("p.student_name,p.company,p.position,p.profile_image",FALSE);
		$this->db->from('placement p');
		$this->db->WHERE('p.status','1');
		$this->db->WHERE('p.featured','1');
		$this->db->order_by('p.featured_date','DESC');
		$this->db->limit(10);
			//echo $this->db->last_query();
		return $this->db->get()->result_array();
	}
	/*function getprojectcounter()
	{
		$this->db->from("project_master pm");
		$this->db->join('users u','u.id=pm.userId');
		$this->db->join('institute_csv_users icu','icu.email=u.email');
		$this->db->where("icu.centerId","1");
		return $this->db->get()->num_rows();
	}*/

	function getregisterStudentCount()
	{

		$query=$this->db->query("SELECT count(*) As registercount FROM institute_csv_users icu WHERE icu.centerId=1 AND icu.studentId !=' ' ");
		//echo $this->db->last_query();
		if($query->num_rows()== 1)
		{
			return $query->row()->registercount;
		}
		else
		{
			return false;
		}

	}

	public function selectDetailsWhrAll()
    {
		$this->db->select("id,instituteName");
		$this->db->from('institute_master');
        $this->db->where("status",'1');
	    return $this->db->get()->result_array();


    }

    public function selectDetailsWhrAllMAAC()
    {
		$maac = $this->load->database('maac_db', TRUE);
    	$maac->select("id,instituteName");
		$maac->from('institute_master');
        $maac->where("status",'1');
	    return $maac->get()->result_array();
    }

    public function selectDetailsWhrAllLAKME()
    {
    	$maac = $this->load->database('lakme_db', TRUE);
        $maac->select("id,instituteName");
    	$maac->from('institute_master');
        $maac->where("status",'1');
    	return $maac->get()->result_array();
    }

    /*  public function selectDetailsWhrAllLakme()
    {
		$lakme = $this->load->database('lakme_db', TRUE);
    	$lakme->select("id,instituteName");
		$lakme->from('institute_master');
        $lakme->where("status",'1');
	    return $lakme->get()->result_array();
    }*/
}
