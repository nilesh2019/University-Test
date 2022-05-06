<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function getJobData($id)
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('id',$id);
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}


	function get($table,$order_by)
	{
		$this->db->order_by($order_by);
		$query=$this->db->get($table);
		return $query;
	}

	public function getAllUser()
	{
		$this->db->select('id,firstName,lastName,email');
		$this->db->from('users');
		$this->db->where('status',1);
		if($this->session->userdata('admin_level')==2)
		{
			$this->db->where('instituteId',$this->session->userdata('instituteId'));
		}
		return $this->db->get()->result_array();
	}

	public function getAllPreticularRegionInstitute($jobid,$view_status='',$posted_by='')
	{
		$institute_Id =array();
		if($view_status !='' && $view_status==1)
		{
			$institute_Id[] = $posted_by;
		}
		else
		{
			$regionIds = $this->db->select('region_id')->from('job_zone_relation')->where('job_id',$jobid)->where('region_id !=',0)->get()->result_array();
			
			if(!empty($regionIds))
			{
				foreach ($regionIds as $regionId) {
					$instituteIds = $this->db->select('id')->from('institute_master')->where('region',$regionId['region_id'])->get()->result_array();
					if(!empty($instituteIds))
					{
						foreach ($instituteIds as $singleInstitute) {
							$institute_Id[] = $singleInstitute['id'];
						}
					}
					
				}
			}
		}
		
		return $institute_Id;
	}

	public function get_visitor()
	{
		$date=date("Y-m-d");
		$this->db->select('*');
		$this->db->from('visitor as A');
		$this->db->join('visit as B','A.visitor_id=B.visit_visitor_id');
		$this->db->where("(`visit_visit_date` LIKE '%$date%')");
		$this->db->group_by('B.visit_visitor_id');
		return $this->db->get()->num_rows();
	}

	public function getAllUserForJobDetail()
	{
		$this->db->select('A.id,A.firstName,A.lastName,A.email');
		$this->db->from('users as A');
		$this->db->join('user_email_notification_relation as B','A.id=B.userId','left');
		$this->db->where('A.status',1);
		$this->db->where('B.new_job',1);
		return $this->db->get()->result_array();
	}

	function getValue($table,$getColumn,$fieldName, $fieldValue)
	{
		$this->db->select($getColumn);
		$this->db->from($table);
		$this->db->where($fieldName,$fieldValue);
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

	public function getValuewithCondition($table_name="",$field_name="",$condition="")
	{
		//echo $field_name;die;
		$query 	= "SELECT
						".$field_name."
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

	function getValueWhere($table,$getColumn,$condition)
	{
		$this->db->select($getColumn);
		$this->db->from($table);

		foreach ($condition as $key => $value)
		{
			$this->db->where($key,$value);
		}

		$result=$this->db->get()->row();
		if(!empty($result))
		{
			return $result->$getColumn;
		}
		else
		{
			return 0;
		}

	}

	function getValueOrWhere($table,$getColumn,$condition)
	{
		$this->db->select($getColumn);
		$this->db->from($table);

		foreach ($condition as $key => $value)
		{
			$this->db->where($key,$value);
		}

		$result=$this->db->get()->row();
		if(!empty($result))
		{
			return $result->$getColumn;
		}
		else
		{
			return 0;
		}

	}

	function get_with_limit($table,$limit, $offset, $order_by)
	{

		$this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		$query=$this->db->get($table);
		return $query;
	}

	function get_where($table,$id)
	{

		$this->db->where('id', $id);
		$query=$this->db->get($table);
		return $query;
	}

	function get_singleJobData($id)
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('id',$id);
		$data = $this->db->get()->row_array();
		$jobZoneRegion = $this->db->select('*')->from('job_zone_relation')->where('job_id',$id)->get()->result_array();
		$data['zones'] = array();
		$data['regions'] = array();
		if(!empty($jobZoneRegion))
		{			
			foreach ($jobZoneRegion as $key => $value) {
				if($value['zone_id'] == 0 && $value['region_id'] !=0)
				{
					$data['region'][] = $value['region_id'];
				}
				if($value['zone_id'] != 0 && $value['region_id'] ==0)
				{
					$data['zone'][] = $value['zone_id'];
				}				
			}
		}
		return $data;
	}


	function get_users_with_status($value)
	{
		$this->db->select('job_user_relation.*,users.id as uId,users.firstName,users.lastName,users.email');
		$this->db->from('job_user_relation');
		$this->db->where('job_user_relation.jobId',$value);
		/*$this->db->where('job_user_relation.apply_status',$value);*/
        $this->db->join('users', 'job_user_relation.userId = users.id', 'left');
		$query = $this->db->get();

		return $query;
	}

	function _insert($table,$data)
	{

		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function _update($table,$id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($table, $data);
	}

	function _update_custom($table,$field,$value, $data)
	{

		$this->db->where($field, $value);
		return $this->db->update($table, $data);
	}

	function _delete($table,$id)
	{

		$this->db->where('id', $id);
		$this->db->delete($table);
	}

	function _delete_with_condition($table,$condi,$id)
	{

		$this->db->where($condi, $id);
		$this->db->delete($table);
	}

	function count_where($table,$column,$value1)
	{

		$this->db->where($column, $value1);
		$query=$this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function count_all($table)
	{
		$query=$this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function count_all_new($table)
	{
		if($this->session->userdata('admin_level') == 2)
		{
			if($table == "institute_master")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d')) AND id=".$this->session->userdata('instituteId');
			}
			elseif($table == "users")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d')) AND instituteId=".$this->session->userdata('instituteId');
			}
			elseif($table == "competitions")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d')) AND instituteId=".$this->session->userdata('instituteId');
			}
			elseif($table == "events")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d')) AND instituteId=".$this->session->userdata('instituteId');
			}
			elseif($table == "jobs")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE admin_level=2 AND posted_by=".$this->session->userdata('instituteId');
			}

		}
		elseif($this->session->userdata('admin_level') == 3)
		{
			$qry="SELECT 'id' FROM ".$table." WHERE admin_level=3 AND posted_by=".$this->session->userdata('admin_id');
		}
		else
		{
			$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		}
		return $this->db->query($qry)->num_rows();
	}

	function getAllJob()
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->order_by('created','desc');
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}






	function count_all_only1($table,$condition='',$separator="AND")
	{

		if($this->session->userdata('admin_level') == 4)
		{
			$regions=$this->modelbasic->getInstituteRegions();
		}

		$this->db->select('id');
		$this->db->from('jobs as A');
		$this->db->join('job_zone_relation as B','A.id=B.job_id','left');

		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('B.region_id',$regions);
		}
		$this->db->where('A.status',1);
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
		
   	    return $this->db->count_all_results();
	}










	function count_all_only($table,$condition='',$separator="AND")
	{
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
		$this->db->where('status',1);	
		$num_rows = $this->db->count_all_results($table);
		return $num_rows;
	}

	function countAllOnly($table,$condition='',$separator="AND",$group_by_field='')
	{
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
			$this->db->group_by($group_by_field);
		}
		$num_rows = $this->db->count_all_results($table);
		return $num_rows;
	}

	function get_max($table)
	{

		$this->db->select_max('id');
		$query = $this->db->get($table);
		$row=$query->row();
		$id=$row->id;
		return $id;
	}

	function _custom_query($table,$mysql_query)
	{
		$query = $this->db->query($mysql_query);
		return $query;
	}

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$featured_job='')
	{

		if($this->session->userdata('admin_level') == 4)
		{
			$regions=$this->modelbasic->getInstituteRegions();
		}

		$this->db->select($selectColumns,FALSE)->from($table.' as A');		
		$this->db->join('job_zone_relation as B','A.id=B.job_id','left');
		
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
			if($this->session->userdata('admin_level')==2)
			{
				$this->db->having('A.posted_by',$this->session->userdata('instituteId'));
			}
			else if($this->session->userdata('admin_level')==3)
			{
				$this->db->having('A.posted_by',$this->session->userdata('admin_id'));
			}
			if($this->session->userdata('admin_level') == 1 && $featured_job !='' && $featured_job == 1)
			{
				$this->db->having('A.featured',$featured_job);
			}

			if($this->session->userdata('admin_level') == 4 && $featured_job=='')
			{
				if(!empty($regions))
				{
					$cnt=count($regions);
					$i=1;
					$qry='';
					foreach($regions as $key => $value)
					{
						if($cnt > 1 && $i < $cnt)
						{
							$qry.='B.region_id='.$value.' OR ';
						}
						else
						{
							$qry.='B.region_id='.$value;
						}
						$i++;
					}
				}
				$this->db->having($qry,null, false);
			}
			if($this->session->userdata('admin_level') == 4 && $featured_job !='' && $featured_job == 1)
			{
				if(!empty($regions))
				{
					$cnt=count($regions);
					$i=1;
					$qry='(';
					foreach($regions as $key => $value)
					{
						if($cnt > 1 && $i < $cnt)
						{
							$qry.='B.region_id='.$value.' OR ';
						}
						else
						{
							$qry.='B.region_id='.$value;
						}
						$i++;
					}
				}
				$qry=$qry.') AND A.featured ='.$featured_job;
				//echo $qry;die;
				$this->db->having($qry,null, false);
			}

		}
		else
		{
			if($featured_job !='' && $featured_job == 1)
			{
				$this->db->where('A.featured',$featured_job);
			}

			if($this->session->userdata('admin_level')==2)
			{
				$this->db->where('A.posted_by',$this->session->userdata('instituteId'));
			}
			else if($this->session->userdata('admin_level')==3)
			{
				$this->db->where('A.posted_by',$this->session->userdata('admin_id'));
			}
			if($this->session->userdata('admin_level')==4)
			{
				$this->db->where_in('B.region_id',$regions);

			}
		}
		$this->db->where('A.status',1);
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
				//echo $orderByField;die;
				$orderByDirection=$requestData["order"][0]["dir"];
			}
			else
			{
				$orderByField='A.created';
				$orderByDirection='DESC';
			}
		}
		else
		{
			$orderByField='A.created';
			$orderByDirection='DESC';
		}

		if($this->session->userdata('admin_level') !=4)
		{
			$this->db->group_by('A.id');
		}		

		return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
		//echo $this->db->last_query();die
	}

	function getAllWhere($table,$fields,$condition,$orderby='',$dir='')
	{
		$this->db->select($fields);
		$this->db->from($table);

		foreach ($condition as $key => $value)
		{
			$this->db->where($key,$value);
		}

		if($orderby!='')
		{
			$this->db->order_by($orderby,$dir);
		}

		return $this->db->get()->result_array();
	}

	public function sendMail($data)
	{
		$localhost = array(
						    '127.0.0.1',
						    '::1'
						);

				$this->load->library('email');
			$config = Array(
			              'mailtype' => 'html',
			              'priority' => '3',
			              'charset'  => 'iso-8859-1',
			              'validate'  => TRUE ,
			              'newline'   => "\r\n",
			              'wordwrap' => TRUE
			              );

			if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
			{
			    	$config['protocol']='smtp';
			    	$config['smtp_host']='ssl://smtp.googlemail.com';
			    	$config['smtp_port']='465';			    	
			    	$config['smtp_user']='test.unichronics@gmail.com';
			    	$config['smtp_pass']='Uspl@12345';
			    	$config['mailtype']='html';
			}

			$this->email->initialize($config);
			/*if(isset($data['fromEmail']) && $data['fromEmail']!='')
			{
				$fromEmail 	=	$this->getValue($this->db->dbprefix('admin_users'),"email"," `id` = '1' ");
			}*/
			$fromName 	=	'creosouls Team';
			$this->email->clear(TRUE);
			$this->email->to($data['to']);
			$this->email->from($data['fromEmail'],$fromName);
			$this->email->subject($data['subject']);
			$this->email->message($data['template']);
			/*$this->email->send();
			echo $this->email->print_debugger();*/
			 if($this->email->send())
				return true;
			else
				return false;
	}

	public function sendMailWithAttachment($data)
	{
		$localhost = array(
		    '127.0.0.1',
		    '::1'
		);

		$this->load->library('email');
		$config = Array(
		              'mailtype' => 'html',
		              'priority' => '3',
		              'charset'  => 'iso-8859-1',
		              'validate'  => TRUE ,
		              'newline'   => "\r\n",
		              'wordwrap' => TRUE
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

		//print_r($config);die;
		$this->email->initialize($config);
		$attachment=file_upload_s3_path().'winner_certificate/'.$data['attachment'];
		$fromName 	=	'creosouls Team';
		$this->email->clear(TRUE);
		$this->email->to($data['to']);
		$this->email->from($data['from'],$fromName);
		$this->email->subject($data['subject']);
		$this->email->message($data['template']);
		$this->email->attach($attachment);
		 if($this->email->send())
		 {
		 	return true;
		 }
		else
		{
			return false;
		}
	}

	function select_all($table,$condition)
	{
		$this->db->select('*');
		$this->db->from($table);
		foreach ($condition as $key => $value)
		{
		$this->db->where($key,$value);
		}
		$query = $this->db->get()->result_array();
		return $query;
	}

	function export_job_users($value)
	{
		$baseUrl=front_base_url();
		$this->db->select("CONCAT(users.firstName,' ',users.lastName) as CandidateName,users.email as Email,CONCAT('".$baseUrl."user/userDetail/', users.id) as PortfolioLink,institute_master.instituteName as InstituteName,region_list.region_name as RegionName,zone_list.zone_name as ZoneName, case job_user_relation.apply_status
        when '1' then 'Applied'
        when '2' then 'Shortlisted'
        when '3' then 'Selected'
        when '4' then 'Accepted'
        when '5' then 'Rejected by User'
        when '6' then 'Rejected by Employe'
    end as ApplyStatus",FALSE);
		$this->db->from('job_user_relation');
		$this->db->where('job_user_relation.jobId',$value);
	    $this->db->join('users', 'job_user_relation.userId = users.id', 'left');
	    $this->db->join('institute_master', 'institute_master.id = users.instituteId', 'left');
	    $this->db->join('zone_list', 'zone_list.id = institute_master.zone', 'left');
	    $this->db->join('region_list', 'region_list.id = institute_master.region', 'left');
		$query = $this->db->get();
		return $query;
	}

	public function add($data)
	{		
		$this->db->insert('job_user_relation',$data);
		return $this->db->insert_id();		
	}

	public function _update_status($table,$userId,$jobId,$data){
		$this->db->where('userId', $userId);
		$this->db->where('jobId', $jobId);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	public function get_interview_assignment_image($userId,$jobId)
	{
		$this->db->select('upi.image_thumb');
		$this->db->from('project_master as pm');
		$this->db->join('user_project_image as upi','upi.project_id=pm.id');
		$this->db->join('interview_assignment as ia','pm.interview_assignment_id=ia.id');
		$this->db->join('interview_assignment_user_relation as iaur','ia.id=iaur.interview_assignment_id');
		$this->db->where("iaur.user_id",$userId);
		$this->db->where("ia.jobId",$jobId);
		$this->db->where("pm.userId",$userId);
		return $this->db->get()->row();
	}
}