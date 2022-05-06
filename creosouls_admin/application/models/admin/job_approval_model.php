<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_approval_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();     
    }

    function run_query($requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$institute='')
	{		
		$col='';
		$admin_level=$this->session->userdata("admin_level");
		if(isset($admin_level) && !empty($admin_level) && $admin_level==4)
		{
			$table='job_user_relation_rahadmin_approval as A';
		}
		else if(isset($admin_level) && !empty($admin_level) && $admin_level==5)
		{
			$table='job_user_relation_rph_approval as A';
			$col=", A.comment1";
		}
		else
		{
			$table='job_user_relation_admin_approval as A';			
		}
		$this->db->select($selectColumns.$col,FALSE)->from($table)->join('users as B','B.id = A.userId')->join('jobs as C','C.id = A.jobId');
		$i=0;
    	if( !empty($requestData['search']['value']) )
    	{
    		foreach ($columns as $value)
    		{
    			if($i==0)
    			{
    				$this->db->like($value,$requestData['search']['value'],'both');
    			}
    			else
    			{
    				if($concatColumns <> '' && $value == $fieldName)
    				{
    					$concat=explode(',', $concatColumns);
    					$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $requestData['search']['value'], 'both',FALSE);
    				}
    				else
    				{
    					$this->db->or_like($value,$requestData['search']['value'],'both');
    				}
    			}
    			$i++;
    		}	    			    		
    	}   
    
		if(!empty($requestData["order"]))
		{
			if($requestData["order"][0]["column"] > 2)
			{
				$orderby=$requestData["order"][0]["column"]-2;
			}
			else
			{
				$orderby=3;
			}
			if($columns[$orderby] != '')
			{
				$orderByField=$columns[$orderby];
				$orderByDirection=$requestData["order"][0]["dir"];
			}
			else
			{
				$orderByField='A.apply_date';
				$orderByDirection='DESC';
			}
		}
		else
		{
			$orderByField='A.apply_date';
			$orderByDirection='DESC';
		}
		if($institute!='')
		{
			$this->db->having('A.institute_id',$institute);
		}
		return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();

	}

	function count_all($table)
	{
		$this->db->select('A.*')->from($table.' as A');
		if($this->session->userdata('admin_level') == 2)
		{
			$this->db->join('institute_csv_users as B','A.email=B.email');
			$this->db->where('B.instituteId',$this->session->userdata('admin_level'));
		}
		$query=$this->db->get();
		$num_rows = $query->num_rows();
		return $num_rows;
	}


	function count_all_new($table)
	{
		$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) = DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		return $this->db->query($qry)->num_rows();
	}

	function count_all_only($table,$condition='',$separator="AND")
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		if($condition<>'')
		{
			$i=0;
			foreach ($condition as $key => $value)
			{
				if($separator=='AND')
				{
					$this->db->where($key,$value);
				}
				else
				{
					if($i==0)
					{
						$this->db->where($key,$value);
					}
					else
					{
						$this->db->or_where($key,$value);
					}

				}
				$i++;
			}
		}
		if($this->session->userdata('admin_level')==2)
		{
			$num_rows = $this->db->from($table)->where('instituteId',$this->session->userdata('instituteId'))->count_all_results();
		}
		elseif($this->session->userdata('admin_level')==4)
		{
			$num_rows = $this->db->from($table)->where_in('instituteId',$ins)->count_all_results();
		}
		else
		{
			$num_rows = $this->db->count_all_results($table);
		}

		return $num_rows;
	}



	public function getAllInstitute()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select('*');
		$this->db->from('institute_master');
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('id',$ins);
		}
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}



	public function getAllInstituteUser($instituteId){

		$this->db->select('id,instituteId,disk_space');
		$this->db->from('users');
		if($instituteId!=0){
			$this->db->where('instituteId',$instituteId);
		}
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}

	public function _update($table,$id,$data){
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function _update2($table,$id,$data){
		$this->db->where('settings_id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	public function getUsersAllProject($user_id)
	{			
		return $this->db->select('id')->from('project_master')->where('userId',$user_id)->get()->result_array();
	}
	 public function getAllImages($projectId)
	{
		return $this->db->select('B.image_thumb')->from('project_master as A')->join('user_project_image as B','B.project_id=A.id')->where('A.id',$projectId)->get()->result_array();
	}
	public function add($table,$data)
	{		
		$this->db->insert($table,$data);
		return $this->db->insert_id();		
	}
	public function find_admin_level($institute_id,$level)
	{
		return $this->db->select('A.hoadmin_id,B.email')->from('hoadmin_institute_relation as A')->join('admin as B','B.id=A.hoadmin_id')->where('A.institute_id',$institute_id)->where('B.level',$level)->get()->row();//return $this->db->select('id')->from('project_master')->where('userId',$user_id)->get()->result_array();
		//return $this->db->select('hoadmin_id')->from('hoadmin_institute_relation')->where('institute_id',$institute_id)->get()->row();
	}
	public function _update_status($table,$userId,$jobId,$data){
		$this->db->where('userId', $userId);
		$this->db->where('jobId', $jobId);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	public function find_employer($id)
	{
		return $this->db->select('A.id,A.email')->from('users as A')->join('jobs as B','B.posted_by=A.id')->where('B.id',$id)->get()->row();				
	}
	public function find_insd_admin($id)
	{
		return $this->db->select('A.id,A.email')->from('users as A')->join('jobs as B','B.postedBy=A.id')->where('B.id',$id)->get()->result_array();				
	}

	public function approvejobbysystem()
	{
		$mul_array=$this->db->select("hir.institute_id,hir.hoadmin_id")->from("hoadmin_institute_relation hir")->join("admin as a","hir.hoadmin_id=a.id")->where("a.email",$this->session->userdata('admin_email'))->get()->result_array();
		$institute_id=array();
		$hoadmin_id='';
		if(!empty($mul_array))
		{
			foreach ($mul_array as $ins) 
			{
				$institute_id[]=$ins['institute_id'];
				$hoadmin_id=$ins['hoadmin_id'];
			}
		}
		
		 $job_with_system_approval_rph=$this->modelbasic->getValue('settings','description','type','job_with_system_approval_rph');
		 $str='-'.$job_with_system_approval_rph.' days';
		//	echo $date_select = date("Y-m-d", strtotime($str));  
		$date_select = date("Y-m-d", strtotime('-2 days'));  
		$whr="DATE_FORMAT(apply_date,'%Y-%m-%d') <= '".$date_select."'";
		$jobdata=$this->db->select("*")->from("job_user_relation_admin_approval")->where($whr)->where("apply_status",'0')->where_in("institute_id",$institute_id)->get()->result_array();
		/*echo $this->db->last_query();
		print_r($jobdata);*/
		if(!empty($jobdata))
		{
			foreach ($jobdata as $job) 
			{
				$job_user_relation_data = array('resume' => $job['resume'],'userId' => $job['userId'],'jobId' => $job['jobId'],'apply_status' => 13,'apply_date' => $job['apply_date'],'modified_date' => $job['modified_date']);
				$res=$this->job_approval_model->add("job_user_relation",$job_user_relation_data);
				//print_r($job_user_relation_data);

				$data=array('userId'=>$job['userId'],"rphadmin_id"=>$hoadmin_id,'jobId'=>$job['jobId'],'resume'=>'','apply_date'=>$job['apply_date'],'institute_id'=>$job['institute_id'],"apply_status"=>0,'comment1'=>"Approved By System");   
				//print_r($data);
				$res=$this->job_approval_model->add("job_user_relation_rph_approval",$data);			
				$this->job_approval_model->_update('job_user_relation_admin_approval',$job['id'],array('apply_status'=>1,'comment'=>"Approved By System"));
			}
		}
	}
}