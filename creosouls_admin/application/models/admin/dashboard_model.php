<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function project_comment()
	{
		if($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5) 
		{
			$ins=$this->modelbasic->getHoadminInstitutes($this->session->userdata('admin_id'));
		}
		$this->db->select('user_project_comment.*,users.profileImage,users.firstname as fname,users.lastname as lname,region_list.region_name,institute_master.instituteName,zone_list.zone_name');
		$this->db->from('user_project_comment');
		$this->db->order_by('user_project_comment.created','desc');
		if($this->session->userdata('admin_level')==2) 
		{
			$this->db->where('users.instituteId',$this->session->userdata('instituteId'));
		}
		if($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5) 
		{
			$this->db->where_in('users.instituteId',$ins);
		}
		$this->db->limit(10);
		$this->db->join('users', 'users.id = user_project_comment.userId');
		$this->db->join('institute_master', 'users.instituteId = institute_master.id');
		$this->db->join('region_list', 'institute_master.region = region_list.id');
		$this->db->join('zone_list', 'institute_master.zone = zone_list.id');
	   	return $this->db->get()->result_array();
	}

	public function change_comment_status($cid,$status)
	{
		$this->db->where('id', $cid);
        return $this->db->update('user_project_comment',array('status'=>$status));
	}

	public function commentCountIncrement($project_id)
	{
		$this->db->where('id', $project_id);
        $this->db->set('comment_cnt', 'comment_cnt+1', FALSE);
        return $this->db->update('project_master');
	}

	public function commentCountDecrement($project_id)
	{
		$this->db->where('id', $project_id);
        $this->db->set('comment_cnt', 'comment_cnt-1', FALSE);
        return $this->db->update('project_master');
	}

	public function get_users_data()
	{
		if($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5) 
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		
		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->order_by('users.created','desc');
		if($this->session->userdata('admin_level')==2) 
		{
			$this->db->where('instituteId',$this->session->userdata('instituteId'));
		}
		if($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5) 
		{
			$this->db->where_in('instituteId',$ins);
		}	
		$this->db->limit(12);
	    return $this->db->get()->result_array();
	}

	public function getAllProject()
	{
		$this->db->select('*');
		$this->db->from('project_master');
		return $this->db->get()->result_array();
	}

	public function get_institute_admin_data($userId,$instituteName)
	{
		$this->db->select("A.*,B.pageName,B.id as instituteId,CONCAT(A.firstName, ' ',A.lastName) as userName",FALSE);
		$this->db->from('users as A');
		$this->db->join('institute_master as B','A.id = B.adminId');
		$this->db->where('A.id',$userId);
	
		$this->db->where('A.status',1);
		$this->db->where('B.pageName',$instituteName);
		$this->db->where('B.status',1);
	    	return $this->db->get()->row_array();
	}
	
	public function get_admin_data($email)
	{
		$this->db->select("*",FALSE);
		$this->db->from('admin');		
		$this->db->where('email',$email);	
		$this->db->where('status',1);		
	    	return $this->db->get()->row_array();
	}

	public function get_user_mail($userId)
	{
		$this->db->select("email,admin_level",FALSE);
		$this->db->from('users as A');		
		$this->db->where('A.id',$userId);	
		$this->db->where('A.status',1);		
	    	return $this->db->get()->row_array();
	}


	public function check_users_data($userId,$companyName)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$userId);
		$this->db->where('company',$companyName);
	    return $this->db->get()->row_array();
	}
	
	function getAll_jobs_users($apply_status)
	{		
		//echo $apply_status;
		$userId = $this->session->userdata('admin_id');
		$admin_level = $this->session->userdata('admin_level');
		
		$this->db->select('jobs.*');
		$this->db->from('jobs');
		if($admin_level==3)
		{
			$this->db->where('jobs.admin_level','3');
			$this->db->where('jobs.posted_by',$userId);
		}
		elseif($admin_level==2)
		{
			$this->db->where('jobs.admin_level','2');
			$this->db->where('jobs.posted_by',$this->session->userdata('instituteId'));
		}	
		
		if($apply_status!=0)
		{
			$this->db->join('job_user_relation','job_user_relation.jobId = jobs.id');
			if($apply_status!=1)
			{
				$this->db->where('job_user_relation.apply_status',$apply_status);
			}
		}
		return $this->db->get()->num_rows();
	}	
function getAll_jobs()
	{
		$userId = $this->session->userdata('admin_id');
		$admin_level = $this->session->userdata('admin_level');
		
			
		$whr='';
		if($this->session->userdata('admin_level')=='2')
		{
			$whr ='AND jobs.posted_by ='.$this->session->userdata('instituteId').' AND jobs.admin_level =2';
		}
		elseif ($this->session->userdata('admin_level')=='3') {
			$whr ='AND jobs.posted_by ='.$userId.' AND jobs.admin_level =3 ';
		}
		elseif ($this->session->userdata('admin_level')=='4') 
		{	
			$whr ='AND jobs.posted_by ='.$userId.' AND jobs.admin_level =4 ';
			
		}
		$query=$this->db->query("SELECT SUM(jobs.no_of_position) As no_of_position FROM jobs WHERE close_on>=CURDATE() $whr");
		if($query->num_rows()== 1)
		{			
			return $query->row()->no_of_position;
		}
		else
		{
			return false;
		}
	}

	public function getLoginCountStudent()
    {			
		$admin_id=$this->session->userdata('admin_id');
		$admin_email=$this->session->userdata('admin_email');		
		$whr='';
		if($this->session->userdata('admin_level')=='2')
		{
			$whr =' AND im.adminId ='.$admin_id;
		}
		else if ($this->session->userdata('admin_level')=='4') 
		{	
			$query= $this->db->query("SELECT distinct(region) FROM hoadmin_institute_relation hir JOIN admin a ON hir.hoadmin_id=a.id WHERE a.email='$admin_email'");
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
	        {
	        	foreach ($query->result() as $row)
	            {
	                $tbl_data[]=$row->region;
	            }
	        	//$res=$query->result_array();
	        }
			$region=implode(',', $tbl_data);
			$whr=" AND im.region IN(".$region.")";
		}
		else if ($this->session->userdata('admin_level')=='1') 
		{
			$whr='';
		}
		$query=$this->db->query("SELECT count(*) As logincount FROM institute_csv_users icu LEFT JOIN institute_master im on icu.instituteId = im.id WHERE icu.centerId=1 AND icu.studentId !=' ' AND  icu.email != '' AND im.status='1'  $whr");
		if($query->num_rows()== 1)
		{			
			return $query->row()->logincount;
		}
		else
		{
			return false;
		}	
    }


    public function getRegisterCountStudent()
    {		
		$admin_id=$this->session->userdata('admin_id');
		$admin_email=$this->session->userdata('admin_email');		
		$whr='';
		if($this->session->userdata('admin_level')=='2')
		{
			$whr =' AND im.adminId ='.$admin_id;
		}
		else if ($this->session->userdata('admin_level')=='4') 
		{	
			$query= $this->db->query("SELECT distinct(region) FROM hoadmin_institute_relation hir JOIN admin a ON hir.hoadmin_id=a.id WHERE a.email='$admin_email'");
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
	        {
	        	foreach ($query->result() as $row)
	            {
	                $tbl_data[]=$row->region;
	            }
	        	//$res=$query->result_array();
	        }
			$region=implode(',', $tbl_data);
			$whr=" AND im.region IN(".$region.")";
		}
		$query=$this->db->query("SELECT count(*) As registercount FROM institute_csv_users icu LEFT JOIN institute_master im on icu.instituteId = im.id WHERE icu.centerId=1 AND icu.studentId !=' ' AND im.status='1'  $whr");
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
    public function getAll_client()
    {
    	//echo $apply_status;
		$this->db->select('jobs.*');
		$this->db->from('jobs');
		$this->db->group_by('jobs.companyName');
		return $this->db->get()->num_rows();
    }
}