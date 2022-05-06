<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL); ini_set('display_errors', 1);

class Stream_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getFollowingUserData($uid='')
	{
	    return $this->db->select('id,firstName,lastName,profileImage,profession,city,')->from('users')->where_in('id',$uid)->get()->result_array();
	}
    public function getAllFollowingUserId()
	{
		$this->db->select('followingUser');
		$this->db->from('user_follow');
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		return $this->db->get()->result_array();
	}
	function unfollow_user($uid)
	{
		$this->db->where('userId',$this->session->userdata('front_user_id'));
		$this->db->where('followingUser',$uid);
		return $this->db->delete('user_follow');
	}
	/*public function getLimitedJob()
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
					$where .="((keySkills LIKE '%".$row['skillName']."%' || description LIKE '%".$row['skillName']."%')";
				}
				else{
					$where .=" || (keySkills LIKE '%".$row['skillName']."%' || description LIKE '%".$row['skillName']."%')";
				}
				$i++;
			}
			$where .=")";
		}
		if($where!='')
		{
			if($totalDays!='' && $totalDays>0)
		    {
				$where .=" OR (min_experience <= '".$totalDays."' and max_experience >= '".$totalDays."')";
			}
		}
		else{
			if($totalDays!='' && $totalDays>0)
		    {
				$where ="min_experience <= '".$totalDays."' and max_experience >= '".$totalDays."' ";
			}
		}
		//echo $where;die;
		/*if($stream!='' && $qualification!='' )
	    {
			$where .=" AND (industry LIKE '%".$stream."%' || function LIKE '%".$stream."%' || education LIKE '%".$qualification."%')";
		}
		elseif($stream!=''&& $qualification=='')
	    {
			$where .=" AND (industry LIKE '%".$stream."%' || function LIKE '%".$stream."%')";
		}
		elseif($stream==''&& $qualification!='' )
	    {
			$where .=" AND (education LIKE '%".$qualification."%')";
		}*/
	    /*if($city!='' && $country!='' )
	    {
			$where .=" OR (location LIKE '%".$city."%' || location LIKE '%".$country."%')";
		}
		elseif($city!=''&& $country=='')
	    {
			$where .=" OR (location LIKE '%".$city."%')";
		}
		elseif($city==''&& $country!='' )
	    {
			$where .=" OR (location LIKE '%".$country."%')";
		}
		if($where!='')
	    {
	    	$this->db->select('*');
			$this->db->from('jobs');
		    $this->db->where('status',1);
			$this->db->where($where);
		    $this->db->order_by('created','desc');
		    $this->db->limit(5);
		    return $this->db->get()->result_array();
	    }
	    else{
			return array();
		}
	    //$this->db->get();
	    //echo $this->db->last_query();
	}*/

	public function getFollowers($uid)
	{
		return $this->db->select('COUNT(followingUser) AS followers')->from('user_follow')->where('followingUser',$uid)->get()->result_array();
	}

	public function getUserWoksList($uid)
	{
		return $this->db->select('organisation, w_address')->from('users_work')->where('user_id',$uid)->where('status','1')->get()->result_array();
	}


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
	public function getAllProjectData($userids)
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where_in('project_master.userId',$userids);
		$this->db->order_by('project_master.created','desc');
		$this->db->limit(6);
		$this->db->where('project_master.status',1);
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



 /**
 * [get_time_ago description]
 * @param  [type] $time [description]
 * @return [type]       [description]
 */
public function get_time_ago( $time )
{
  $time_difference = time() - $time;

  if( $time_difference < 1 ) { return 'less than 1 second ago'; }
  $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach( $condition as $secs => $str )
  {
    $d = $time_difference / $secs;

    if( $d >= 1 )
    {
      $t = round( $d );
      return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
    }
  }
}
	public function more_data($limit,$page,$userIds)
	{
		$start = ($page - 1) * $limit;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where_in('project_master.userId',$userIds);
		$this->db->order_by('project_master.created','desc');
		$this->db->where('project_master.status',1);
		$this->db->limit($limit);
		$this->db->offset($start);
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
	function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
	public function getAllCategory()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
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
		$headers = get_headers($url);
		if(strpos($headers[17],"200") > 0){
			return true;
		}
		else
		{
			return false;
		}
	}
	public function get_all_attribute()
	{
		$this->db->select('*');
		$this->db->from('attribute_master');
		$this->db->where('status',1);
		$this->db->order_by('attributeName','asc');
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
	public function get_attribute_detail()
	{
	}
	public function get_all_category()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->order_by('categoryName','asc');
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


	public function getAllTrendingProjectData($noLimit='')
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created, project_master.featured');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where('project_master.like_cnt >=10');
		if(empty($noLimit)){
			$this->db->limit(10);
		} else{

			$limit = 3;
			$offSets = $noLimit*$limit;
			$this->db->limit(3);
			$this->db->offset($offSets);
		}

		$this->db->order_by('project_master.created','desc');
		//$this->db->order_by('project_master.like_cnt','RANDOM');
		$this->db->where('project_master.featured',1);
		$this->db->where('project_master.status',1);
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
				$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName,');
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


	public function getFollowingUsers()
	{
		$user_id=$this->session->userdata('front_user_id');

		return $this->db->select('followingUser')->from('user_follow')->where('userId',$user_id)->get()->result_array();
	}



public function getAllStrsmBlogData($search_term='')
	{
		$this->db->select('A.id,A.title,A.picture,A.description,A.keywords,A.created,A.posted_by');
		$this->db->from('blog as A');
		if($search_term != '')
		{
			$this->db->where("(description LIKE '%".$search_term."%'|| keywords LIKE '%".$search_term."%'|| title LIKE '%".$search_term."%')");
		}
		$this->db->where('A.status',1);
		//$this->db->limit(4);
		$this->db->order_by('A.created','desc');
		return $this->db->get()->result_array();
	}



public function getFollowingUsersLikedProjects($uids, $arStart)
	{

		$limit = 3;
		$offSets = $arStart*$limit;

		$pid = $this->db->select('projectId')->from('user_project_views')->where_in('userId',$uids)->get()->result_array();

		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created, project_master.featured, project_master.videoLink');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where('project_master.like_cnt >=10');


		$this->db->order_by('project_master.created','desc');
		//$this->db->order_by('project_master.like_cnt','RANDOM');
		$this->db->limit(3);
		$this->db->offset($offSets);

		$where = '(project_master.featured = 0)';
       	$this->db->where($where);


		$this->db->where('project_master.status',1);
		$this->db->where_in('project_master.id',array_unique(array_column($pid, 'projectId')));
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
				$this->db->select('attribute_master.attributeName,attribute_master.id,category_master.categoryName,');
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
					//$data[$i]['post_liked_by']=0;
				}
				if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
				{
					$this->db->select('*');
					$this->db->from('user_project_views');
					$this->db->where('projectId',$row['id']);
					$this->db->where('userId',$this->session->userdata('front_user_id'));
					$this->db->where('userLike',1);
					$data[$i]['userLiked'] = $this->db->get()->num_rows();

					$likedUsers = $this->db->select('userId')->from('user_project_views')->where('projectId',$row['id'])->get()->result_array();


					$data[$i]['post_liked_by']=array_column($likedUsers, 'userId');
				}
				else{
					$data[$i]['userLiked']=0;
				}
				$i++;
			}
		}



		return $data;
	}



	public function getProjectDetailsByProjectID($pid)
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,users.profileImage,users.profession,users.city,project_master.userId,project_master.categoryId,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt,project_attribute_relation.rating_avg,project_master.created');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.id',$pid);
		$this->db->where('project_master.status',1);
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

/**
 * [timeline_more_data description]
 * @param  [type] $limit         [description]
 * @param  [type] $page          [description]
 * @param  [type] $timelIneArray [description]
 * @return [type]                [description]
 */
	function timeline_more_data($arStart,$arEnd,$timelIneArray){

		$this->load->model('model_basic');





  $FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));



  $profileImage = $this->model_basic->getValue($this->db->dbprefix('users'),"profileImage"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $firstName = $this->model_basic->getValue($this->db->dbprefix('users'),"firstName"," `id` = '".$FRONT_USER_SESSION_ID."'");
  $lastName = $this->model_basic->getValue($this->db->dbprefix('users'),"lastName"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $profession = $this->model_basic->getValue($this->db->dbprefix('users'),"profession"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $userCompany = $this->model_basic->getValue($this->db->dbprefix('users'),"company"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $type = $this->model_basic->getValue($this->db->dbprefix('users'),"type"," `id` = '".$FRONT_USER_SESSION_ID."'");

  $users_work = $this->model_basic->getCompanyValue($this->db->dbprefix('users_work'),"*"," `user_id` = '".$FRONT_USER_SESSION_ID."'");


  $followingUserData = $this->model_basic->getCountWhere('user_follow',array('followingUser'=>$FRONT_USER_SESSION_ID));

		$this->load->model('user_model');
  $view_like_cnt = $this->user_model->getViewLikeCnt($FRONT_USER_SESSION_ID);
  $followers=$this->user_model->getFollowers($FRONT_USER_SESSION_ID);
  $following=$this->user_model->getFollowing($FRONT_USER_SESSION_ID);
  $overAllRating = $this->user_model->overAllProjectRating($FRONT_USER_SESSION_ID);


		$followingUsers = $this->getFollowingUsers();
  //$followers = $this->CI->stream_model->getFollowers($FRONT_USER_SESSION_ID);

  $currentUserLikeedUsers = array_column($followingUsers, 'followingUser');

		  if(!empty($currentUserLikeedUsers)){
		  $getFollowingUsersLikedProjects = $this->getFollowingUsersLikedProjects($currentUserLikeedUsers, $arStart);
		} else{
		  $getFollowingUsersLikedProjects = [];
		}


		$trandingProjects = $this->getAllTrendingProjectData($arStart);
		$p2 = array_merge($trandingProjects,$getFollowingUsersLikedProjects);
	  $projectsLists = array_map("unserialize", array_unique(array_map("serialize", $p2)));


		$unique = array();

		  foreach ($p2 as $value)
		  {
		    $unique[$value['id']] = $value;
		  }

		  $finalListOfProject = array_values($unique);


		  //print_r($finalListOfProject);

		  $lcomments = array();
              foreach ($finalListOfProject as $key => $row)
              {
                //$price[$key]['name'] = $row->name;
                $lcomments[$key] = $row['created'];
              }
              array_multisort($lcomments, SORT_DESC, $finalListOfProject);

$i = 0;
		  foreach ($finalListOfProject as $row) {

?>


      <div class="post-bar project-custom-bar" id="div_<?php echo $i;?>">

        <div class="post_topbar">


          <?php

          if(!empty($row['post_liked_by'])){
            $b=1;


          if(!in_array($FRONT_USER_SESSION_ID, $row['post_liked_by']) && $row['featured'] == 0){


            ?>

            <?php

               foreach ($row['post_liked_by'] as $key => $value) {

                if(in_array($value,$currentUserLikeedUsers)){

                	$this->load->model('people_model');

                $followingUser = $this->people_model->checkFollowingOrNot($row['userId']);

                if(empty($followingUser)){


                        if($b%24==1){
                            echo '<p class="post_liked_by_user ">Post liked by';
                        }




                        $this->load->model('model_basic');
                $firstName = $this->model_basic->getValue($this->db->dbprefix('users'),"firstName"," `id` = '".$value."'");

                $lastName             = $this->model_basic->getValue($this->db->dbprefix('users'),"lastName"," `id` = '".$value."'");?>
              <b><a href="<?php echo base_url();?>user/userDetail/<?php echo $value;?>"><?php echo
              $firstName.' '.$lastName;?></a></b>,


               <?php

                        if($b%24 == 0){
                            echo "</p>";

                }

                  $b++;
                }

            }
            }?>


          <?php
          }
        }?>
          <div class="usy-dt">

            <a href="<?php echo base_url();?>user/userDetail/<?php echo $row['userId']?>">

              <?php
              if(file_exists(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) && filesize(file_upload_s3_path().'users/thumbs/'.$row['profileImage']) > 0)   {
                ?>
                <img class="people_follow_list" src="<?php echo file_upload_base_url();?>users/thumbs/<?php echo $row['profileImage']?>">
                <?php }else{?>
                <img class="people_follow_list" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/p_logo.png" alt="">
                <?php } ?>


                <?php

                $flowcount = $this->getFollowers($row['userId']);
                $fcount = end($flowcount)['followers'];

                ?>
                <div class="usy-name">
                  <h3><?php echo $row['firstName'].' '.$row['lastName'];?>
                    <i>(<?php echo $fcount?$fcount:0?> followers)</i>
                  </h3>


                  <span><img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/clock.png" alt=""><?php echo $this->get_time_ago( strtotime($row['created']) ); ?></span>
                </div>

              </a>

            </div>
            <div class="follow_post_button">

              <?php
              if(($row['userId']) != $this->session->userdata('front_user_id'))
              {

                $this->load->model('people_model');
                $followingUser = $this->people_model->checkFollowingOrNot($row['userId']);
                if(!empty($followingUser))
                {
                  ?>
                  <form action="<?php echo base_url();?>user/unfollow_user/<?php if(!empty($row['userId'])){echo $row['userId'];}?>/0?isStream=1" method="POST">
                    <!--<input type="submit" name="submit" value="Following" class="fallow_unfallow btn  btn-danger"/>-->
                    <button type="submit" name="submit" class="fallow_unfallow btn btn_orange">
                      <i class="fa fa-check"></i>&nbsp;Following
                    </button>
                  </form>
                  <?php
                }
                else
                {
                  ?>

                  <form action="<?php echo base_url();?>user/follow_user/<?php if(!empty($row['userId'])){echo $row['userId'];}?>/0?isStream=1" method="POST">
                    <input type="submit" name="submit" value="&#x0002B; &nbsp; Follow" class="fallow_unfallow btn btn_blue"/>
                  </form>
                  <?php
                }
              }?>
            </div>

              </div>

      <div class="job_descp">

        <?php
        if(file_exists(file_upload_s3_path().'project/thumb_big/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumb_big/'.$row['image_thumb']) > 0){
          ?>
          <?php if(isset($is_assignment))
          { ?>
            <img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $row['image_thumb']?>" alt="" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>/<?php echo $is_assignment;?>'">
            <?php  } else { ?>
            <img class="img-responsive project-img" src="<?php echo file_upload_base_url();?>project/thumb_big/<?php echo $row['image_thumb']?>" alt="" onclick="window.location='<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>'">
            <?php }  ?>
            <?php }else{?>
            <img class="img-responsive project-img" src="<?php echo base_url();?>creosouls_admin/backend_assets/img/noimage.jpg" alt="" >
            <?php }?>



          <ul class="skill-tags">

            <?php if(isset($row['featured']) && $row['featured'] == 1){?>
            <li class="trndp"><a  title=""><i class="fa fa-bolt" aria-hidden="true"></i> Trending Project</a></li>
            <?php  } else { ?>
            <li><a  title="">Project</a></li>
            <?php  } ?>
            <li><a title=""><?php echo $row['categoryName'];?></a></li>
            <?php if(isset($row['videoLink']) && $row['videoLink'] != ''){?>
            <li class="project_has_video"><a title="" href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>"><i class="fa fa-youtube-play" aria-hidden="true"></i> </a></li>

            <?php  }?>
          </ul>
        </div>
    <div class="job-status-bar">
          <ul class="like-com"><li>

            <?php



                     $totalLikeName = $this->db->select('B.firstName,B.lastName, B.id')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array();

                     //print_r($totalLikeName);die;

            if($row['userLiked'] == 0){
              ?>
              <div class="like dropdown" >
                <div  >


                  <span  id="current_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>" class="sterm-project-like like_div" data-name="0" data-id="<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-like="<?php echo count($totalLikeName); ?>"><i class="fa  fa-thumbs-o-up no-user-like" ></i></span>

                  <span  id="show_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>"  class="sterm-project-like" style="display: none;"><i class="fa  fa-thumbs-up user-like" ></i></span>




                  <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="">

                  <span id="like_count_<?php if(!empty($row['id'])){ echo $row['id'];}else
                  { echo 0;}?>" data-cc="<?php echo count($totalLikeName); ?>"><?php echo count($totalLikeName); ?></span>
                </div>
                <ul class="dropdown-menu strem-line-project-drp">
                  <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){

                  ?>
                  <li><a href="<?php echo base_url();?>user/userDetail/<?php echo $TLname['id'];?>"><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></a></li>
                  <?php }   }  ?>
                </ul>
              </div>
              <?php
            }
            else
            {
              ?>
              <div class="like dropdown " title="">
                <!-- <span class="dropdown-toggle" data-toggle="dropdown"></span> -->

                <a ><i class="fa fa-thumbs-up user-like" >
                </i></a>
                <img src="<?php echo base_url();?>assets/custom-time-line_test_imgs/liked-img.png" alt="">
                <span><?php echo count($totalLikeName); ?></span>
                <ul class="dropdown-menu strem-line-project-drp">

                  <?php if(!empty($totalLikeName)){ foreach($totalLikeName as $TLname){

                  ?>
                  <li><a href="<?php echo base_url();?>user/userDetail/<?php echo $TLname['id'];?>"><?php echo $TLname['firstName'].' '.$TLname['lastName']; ?></a></li>
                  <?php }   }  ?>
                </ul>
              </div>
              <?php
            }?>

          </li>

          <?php
          if($this->session->userdata('front_user_id') == $row['userId'] && $this->uri->segment(1) !='all_project')
          {
            if(isset($editProject)){
              if($row['assignmentId'] == 0 && $row['competitionId'] == 0 )
              {
                ?>
                <span onclick="window.location='<?php echo base_url();?>project/edit_project/<?php echo $row['id'];?>'" style="cursor: pointer;" title="Edit Project"><i class="fa fa-pencil-square-o" ></i>&nbsp;</span>


                <?php }  }
              }else{
                $this->load->model('model_basic');
                $imageCount = $this->model_basic->getCount('user_project_image','project_id',$row['id']);
              //echo $imageCount;die;
                ?>
                <!--<li><a  title="" class="com"><i class="fa fa-picture-o"></i>&nbsp; Images <?php //echo $imageCount;?></a></li>-->


                <?php }?>


                <?php
        if(file_exists(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$row['image_thumb']) > 0){
          ?>
          <?php if(isset($is_assignment))
          { ?>


            <li><a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt=""> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

            <li><div class="dropdown pull-right sharelinks">
              <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>

     <?php  } else { ?>


            <li><a href="<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName']?>" title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt=""> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

            <li><div class="dropdown pull-right sharelinks">

            <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>
<?php }  ?>
            <?php }else{?>
              <li><a title="" class="com"><img src="<?php echo base_url();?>/assets/custom-time-line_test_imgs/com.png" alt=""> Comment <?php echo $row['comment_cnt'] ? $row['comment_cnt'] :0;?></a></li>

              <li><div class="dropdown pull-right sharelinks">
              <i class="fa fa-share dropdown-toggle" aria-hidden="true" data-toggle="dropdown"></i> <b>Share</b>

              <ul class="dropdown-menu">
                <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Facebook
                  </a>
                </li>
                <li>
                    <a href="https://twitter.com/share?url=<?php echo base_url()?>projectDetail/<?php echo $row['projectPageName'];?>" >
                    Twitter
                  </a>
                </li>
              </ul>
            </div></li>
            <?php }?>

            </ul>
              <?php if($row['view_cnt'] > 10){?>
              <a><i class="la la-eye"></i>Views <?php echo $row['view_cnt'];?> </a>
              <?php  }?>
            </div>
          </div><!--post-bar end-->
          <?php   $i++;
}


			}



}