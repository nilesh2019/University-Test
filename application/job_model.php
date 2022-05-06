<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllData()
	{
		$insti_id = $this->session->userdata('user_institute_id');
		if($insti_id && $insti_id != '')
		{
			$regionId=$this->db->select('region')->from('institute_master')->where('id',$insti_id)->get()->row_array();
		}
		else
		{
			$regionId='';
		}		
		$data=$this->getJobs($regionId);
		//echo $this->db->last_query();

		return $data;	
	}
	
	public function getJobs($regionId='')
	{
		$this->db->select('A.*');
		$this->db->from('jobs as A');
		$this->db->join('job_zone_relation as B','B.job_id=A.id','LEFT');
		$this->db->where('A.status',1);
		if(isset($regionId) && !empty($regionId))
		{
			$this->db->where('B.region_id',$regionId['region']);
		}
		
		$insti_id = $this->session->userdata('user_institute_id');

		$this->db->where('status',1);
		if($insti_id && $insti_id != '')
		{
			$query = "((A.admin_level=2 and A.posted_by=".$insti_id.") or (A.view_status=0))";
			$this->db->where($query);
		}
		else
		{
			$this->db->where('A.view_status',0);
		}
		/*$keyword = $this->session->userdata('city');        		
		if($keyword && $keyword !='')
		{  
			$this->db->where("A.location LIKE '%".$keyword."%'");     	      	           
		}*/
		
		$this->db->where('date_format(A.close_on,"%Y-%m-%d")>', 'CURDATE()', FALSE);
		$this->db->limit(8);
		$this->db->group_by('B.job_id');
		$this->db->order_by('A.created','desc');    
		return $this->db->get()->result_array();
	}

	public function getSingleJobData($id)
	{
		$this->db->select('*');
		$this->db->from('jobs');
        $this->db->where('id',$id);
        return $this->db->get()->result_array();
	}
	public function checkAppliedOrNot($id)
	{
		$this->db->select('*');
		$this->db->from('job_user_relation');
             $this->db->where('jobId',$id);
             $this->db->where('userId',$this->session->userdata('front_user_id'));
             return $this->db->get()->row_array();
	}

	public function checkJobAppliedApproveFromAdmin($id)
	{
		$this->db->select('*');
		$this->db->from('job_user_relation_admin_approval');
             $this->db->where('jobId',$id);
             $this->db->where('userId',$this->session->userdata('front_user_id'));
             return $this->db->get()->row_array();
	}
	public function checkJobAppliedApproveFromRAHAdmin($id)
	{
		$this->db->select('*');
		$this->db->from('job_user_relation_rahadmin_approval');
             $this->db->where('jobId',$id);
             $this->db->where('userId',$this->session->userdata('front_user_id'));
             return $this->db->get()->row_array();
	}
	public function getRelationdata($id)
	{
		 $this->db->select('*');
		 $this->db->from('job_user_relation');
         $this->db->where('id',$id);
         return $this->db->get()->result_array();
	}
	/*public function add($data)
	{
		$this->db->select('id');
		$this->db->from('job_user_relation');
		$this->db->where('userId',$data['userId']);
		$this->db->where('jobId',$data['jobId']);
		$result=$this->db->get()->result_array();
		if(!empty($result))
		{
			$this->session->set_flashdata('error', ' Sorry..., you have already applied for this job.');
			redirect('job/jobDetail/'.$data['jobId']);
		}
		else
		{
			$this->db->insert('job_user_relation',$data);
			return $this->db->insert_id();
		}
	}*/

	public function add($data)
	{
		$this->db->select('id');
		$this->db->from('job_user_relation_admin_approval');
		$this->db->where('userId',$data['userId']);
		$this->db->where('jobId',$data['jobId']);
		$result=$this->db->get()->result_array();
		if(!empty($result))
		{
			$this->session->set_flashdata('error', ' Sorry..., you have already applied for this job.');
			redirect('job/jobDetail/'.$data['jobId']);
		}
		else
		{
			$this->db->insert('job_user_relation_admin_approval',$data);
			return $this->db->insert_id();
		}
	}
	public function more_data($limit,$valueArray)
	{
		$page		=	$valueArray['call_count'];
		$active_tab	=	$valueArray['active_tab'];
		$keyword	=	$valueArray['keywordText'];
		$companyName=	$valueArray['companyName'];
		$jobTitle	=	$valueArray['jobTitle'];
		$userLocation	=	$valueArray['userLocation'];
/*		$userCountry=	$valueArray['userCountry'];
		$userState	=	$valueArray['userState'];
		$userCity	=	$valueArray['userCity'];*/
		$where='';
		$start=($page-1)*$limit;
		$this->db->select('jobs.*');
		$this->db->from('jobs');
        	$where .= 'jobs.status = 1';
        	if($this->session->userdata('user_institute_id') && $this->session->userdata('user_institute_id')!='')
       	{
       		$insti_id = $this->session->userdata('user_institute_id');
       		$where .= " AND ((jobs.admin_level =2 and jobs.posted_by=".$insti_id.") or (jobs.view_status=0))";
			//$this->db->where($query);
		}
		else
		{
			$where .= ' AND jobs.view_status = 0';
		  	//$this->db->where('jobs.view_status',0);
		}
/*		if($userCountry!='-1')
		{
			$where .= " AND (jobs.location like '%".$userCountry."%')";
		}
		if($userState!='')
		{
			$where .= " AND (jobs.location like '%".$userState."%')";
		}
		if($userCity!='')
		{
			$where .= " AND (jobs.location like '%".$userCity."%')";
		}*/
		if($userLocation!='')
		{
			$where .= " AND (jobs.location like '%".$userLocation."%')";
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
		//echo $where;
		$this->db->where($where);
	      if($active_tab!='All Jobs')
		{
			if($active_tab=='Applied For')
			{
				$this->db->where('job_user_relation.apply_status',1);
			}
			if($active_tab=='Shortlisted For')
			{
				$this->db->where('job_user_relation.apply_status',2);
			}
			if($active_tab=='Selected For Interview')
			{
				$this->db->where('job_user_relation.apply_status',3);
			}
			if($active_tab=='Offered Jobs')
			{
				$this->db->where('job_user_relation.apply_status',4);
			}
			$this->db->where('job_user_relation.userId',$this->session->userdata('front_user_id'));
	        	$this->db->join('job_user_relation', 'job_user_relation.jobId = jobs.id', 'left');
		}
			$this->db->where('date_format(A.close_on,"%Y-%m-%d")>', 'CURDATE()', FALSE);
        	
        	$this->db->limit($limit);
	    	$this->db->offset($start);
	    /*$this->db->limit(8);*/
		$this->db->order_by('jobs.created','desc');
	    	$data = $this->db->get()->result_array();
	    	if(!empty($data))
	    	{$i=0;
			foreach($data as $row)
			{
				$data[$i]['desc'] = strip_tags($row['description']);
				$data[$i]['created'] = date("d M, Y", strtotime($row['created']));
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

public function search_more_data($limit,$valueArray)
	{
		$page		=	$valueArray['call_count'];
		$active_tab	=	$valueArray['active_tab'];
		$keyword	=	$valueArray['keywordText'];
		$companyName=	$valueArray['companyName'];
		$jobTitle	=	$valueArray['jobTitle'];
		$userLocation	=	$valueArray['userLocation'];
/*		$userCountry=	$valueArray['userCountry'];
		$userState	=	$valueArray['userState'];
		$userCity	=	$valueArray['userCity'];*/
		$where='';
		$start=($page-1)*$limit;

		$insti_id = $this->session->userdata('user_institute_id');
		if($insti_id && $insti_id != '')
		{
			$regionId=$this->db->select('region')->from('institute_master')->where('id',$insti_id)->get()->row_array();
		}
		else
		{
			$regionId='';
		}

		$this->db->select('jobs.*');
		$this->db->from('jobs');
		$this->db->join('job_zone_relation','job_zone_relation.job_id=jobs.id','left');

		if(isset($regionId) && !empty($regionId))
		{
			$this->db->where('job_zone_relation.region_id',$regionId['region']);
		}

        	$where .= 'jobs.status = 1';
        	if($this->session->userdata('user_institute_id') && $this->session->userdata('user_institute_id')!='')
       	{
       		$insti_id = $this->session->userdata('user_institute_id');
       		$where .= " AND ((jobs.admin_level =2 and jobs.posted_by=".$insti_id.") or (jobs.view_status=0))";
			//$this->db->where($query);
		}
		else
		{
			$where .= ' AND jobs.view_status = 0';
		  	//$this->db->where('jobs.view_status',0);
		}

		if($userLocation!='')
		{
			$where .= " AND (jobs.location like '%".$userLocation."%')";
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
		//echo $where;
		$this->db->where($where);
	      if($active_tab!='All Jobs')
		{
			if($active_tab=='Applied For')
			{
				$this->db->where('job_user_relation.apply_status',1);
			}
			if($active_tab=='Shortlisted For')
			{
				$this->db->where('job_user_relation.apply_status',2);
			}
			if($active_tab=='Selected For Interview')
			{
				$this->db->where('job_user_relation.apply_status',3);
			}
			if($active_tab=='Offered Jobs')
			{
				$this->db->where('job_user_relation.apply_status',4);
			}
			if($active_tab=='Rejected by Employe')
			{
				$this->db->where('job_user_relation.apply_status',5);
			}
			if($active_tab=='Rejected by Admin')
			{
				$this->db->where('job_user_relation.apply_status',6);
			}
			
			$this->db->where('job_user_relation.userId',$this->session->userdata('front_user_id'));
	        $this->db->join('job_user_relation', 'job_user_relation.jobId = jobs.id', 'left');
		}
			$this->db->where('date_format(A.close_on,"%Y-%m-%d")>', 'CURDATE()', FALSE);
			$this->db->group_by('jobs.id');
        	$this->db->limit($limit);
	    	$this->db->offset($start);
	   
			$this->db->order_by('jobs.close_on','desc');
	    	$data = $this->db->get()->result_array();
	    	if(!empty($data))
	    	{$i=0;
			foreach($data as $row)
			{
				$data[$i]['desc'] = strip_tags($row['description']);
				$data[$i]['created'] = date("d M, Y", strtotime($row['created']));
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

	public function check_interview_assignmnetdata($job_id)
	{
		$this->db->select('*');
		$this->db->from('interview_assignment AS ia');
		$this->db->join('interview_assignment_user_relation as iaur','iaur.interview_assignment_id=ia.id','LEFT');
	    $this->db->where('ia.jobId',$job_id);
	    $this->db->where('iaur.user_id',$this->session->userdata('front_user_id'));
	    return $this->db->get()->row();
	}

	public function _update_status($table,$userId,$jobId,$data){
		$this->db->where('userId', $userId);
		$this->db->where('jobId', $jobId);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
}