<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class People_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllData()
	{	
		$this->db->select('A.id as userId,A.instituteId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS project_count,project_master.id AS projectId');
		$this->db->from('users as A');		
		
		if($this->session->userdata('user_admin_level') == 1)
		{
			 if($this->session->userdata('adv_category_id'))
		    	{
		    	   $this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3) AND (project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
		        }
		        else
		        {
		        	$this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3)', 'left'); 
		        }   
		}				
		else
		{
		    	if('A.instituteId' == $this->session->userdata('user_institute_id'))
		    	{	
				 if($this->session->userdata('adv_category_id'))
			    	{
			    	   $this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3) AND (project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
			        }
			        else
			        {
			        	$this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3)', 'left'); 
			        }    				
		    	}
		    	else
		    	{	 
				if($this->session->userdata('adv_category_id'))
			    	{
			    	   $this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status = 1 AND project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
			        }
			        else 
			        {
			           	$this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status = 1)', 'left');			
			        }   				
		    	}

		}

		     if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
			{
				if(strpos($this->session->userdata('adv_rating'),'+') !== false)
				{
					  $arr = explode("+",$this->session->userdata('adv_rating'));
					  //$this->db->where('project_rating.rating >=',$arr[0]);
					  $this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating >="'.$arr[0].'"');
				}
				else
				{
					$this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating ="'.$this->session->userdata('adv_rating').'"');
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
            //  $this->db->where('A.status',1);

              	if($this->session->userdata('adv_category_id'))
              {
              		$this->db->where('project_master.categoryId is NOT NULL', NULL, FALSE);
            	}

              $this->db->where('A.id !=',$this->session->userdata('front_user_id'));
		$this->db->where('A.status',1);
		$this->db->limit(12);
		$this->db->order_by('project_count','desc');
		$this->db->group_by('A.id');
	  	$allData = $this->db->get()->result_array();	
	  	 return $allData;
	   // print_r($allData);die;
	   // $dat = $this->db->get()->result_array();
      /*  echo $this->db->last_query();
        print_r($dat);die;*/
	}
	public function more_data($limit,$page,$search_term)
	{	
		$start=($page-1)*$limit;
		$this->db->select('A.id as userId,A.instituteId,A.firstname,A.lastname,A.city,A.country,A.profession,A.profileimage,COUNT(DISTINCT project_master.id) AS project_count');
		$this->db->from('users as A');
	    	if($this->session->userdata('user_admin_level') == 1)
	    	{
	    		 if($this->session->userdata('adv_category_id'))
	    	    	{
	    	    	   $this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3) AND (project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
	    	        }
	    	        else
	    	        {
	    	        	$this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3)', 'left'); 
	    	        }   
	    	}	
	    	else
	    	{
    		    	if('A.instituteId' == $this->session->userdata('user_institute_id'))
    		    	{	
    				 if($this->session->userdata('adv_category_id'))
    			    	{
    			    	   $this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3) AND (project_master.categoryId = "'.$this->session->userdata('adv_category_id').'")', 'left'); 
    			        }
    			        else
    			        {
    			        	$this->db->join('project_master', 'project_master.userId = A.id AND (project_master.status=1 OR  project_master.status=3)', 'left'); 
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

	    	}

		     if($this->session->userdata('adv_rating') && $this->session->userdata('adv_rating')!='')
			{
				if(strpos($this->session->userdata('adv_rating'),'+') !== false)
				{
					  $arr = explode("+",$this->session->userdata('adv_rating'));
					  //$this->db->where('project_rating.rating >=',$arr[0]);
					  $this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating >="'.$arr[0].'"');
				}
				else
				{
					$this->db->join('project_rating', 'project_rating.projectId = project_master.id AND project_rating.rating ="'.$this->session->userdata('adv_rating').'"');
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
              $this->db->where('A.status',1);

              	if($this->session->userdata('adv_category_id'))
              {
              		$this->db->where('project_master.categoryId is NOT NULL', NULL, FALSE);
            	}

              $this->db->where('A.id !=',$this->session->userdata('front_user_id'));

               if($search_term != '')
              	{
              		$this->db->where("(A.firstName LIKE '%".$search_term."%'|| A.lastName LIKE '%".$search_term."%'|| CONCAT(A.firstname,' ', A.lastname) LIKE '%".$search_term."%' || A.country LIKE '%".$search_term."%'|| A.city LIKE '%".$search_term."%')");
              	}

              $this->db->limit($limit);
              $this->db->offset($start);
          	$this->db->order_by('project_count','desc');
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
}
