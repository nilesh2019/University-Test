<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modelbasic extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function get($table,$order_by)
	{
		$this->db->order_by($order_by);
		$query=$this->db->get($table);
		return $query;
	}
	public function loggedInUserInfoById($user_id)
	{
		//$user_id=$this->session->userdata('front_user_id');
		return $this->db->select('*')->from('users')->where('id',$user_id)->get()->row_array();
	}
	public function loggedInUserInfoByEmailId($email)
	{
		//$user_id=$this->session->userdata('front_user_id');
		return $this->db->select('*')->from('users')->where('email',$email)->get()->row_array();
	}
	public function get_user_id($email)
	{
		$this->db->select("id",FALSE);
		$this->db->from('users as A');		
		$this->db->where('A.email',$email);	
		$this->db->where('A.status',1);		
	    return $this->db->get()->row_array();
	}
	public function getAllUser()
	{
		$this->db->select('id,firstName,lastName,email,instituteId');
		$this->db->from('users');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function getAllCategory(){
		
		$qry="SELECT * FROM category_master WHERE status=1";

		
	 	return $this->db->query($qry)->result_array();
			//return $this->db->get()->result_array();
	}

	public function getHoadminInstitutes()
	{
		$hoadmin_id=$this->session->userdata('admin_id');
		$mul_array=$this->db->select('institute_id')->from('hoadmin_institute_relation')->where('hoadmin_id',$hoadmin_id)->get()->result_array();
		$institutes=array();
		if(!empty($mul_array))
		{
			foreach ($mul_array as $ins) 
			{
				$institutes[]=$ins['institute_id'];
			}
		}
		return $institutes;
	}

	public function getInstituteRegions()
	{
		$hoadmin_id=$this->session->userdata('admin_id');
		$mul_array=$this->db->select('region')->from('hoadmin_institute_relation')->where('hoadmin_id',$hoadmin_id)->group_by('region')->get()->result_array();
		$regions=array();
		if(!empty($mul_array))
		{
			foreach ($mul_array as $ins) 
			{
				$regions[]=$ins['region'];
			}
		}
		return $regions;
	}
	public function getInstituteZone()
	{
		$hoadmin_id=$this->session->userdata('admin_id');
		$mul_array=$this->db->select('zone')->from('hoadmin_institute_relation')->where('hoadmin_id',$hoadmin_id)->group_by('zone')->get()->result_array();
		$zone=array();
		if(!empty($mul_array))
		{
			foreach ($mul_array as $ins) 
			{
				$zone[]=$ins['zone'];
			}
		}
		return $zone;
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

	public function getCompetitionJury($searchTerm='')
	{
		$this->db->select('id,email');
		$this->db->from('competition_jury');
		if($searchTerm <> '')
		{
			$this->db->where("(`name` LIKE '%$searchTerm%' OR `email` LIKE '%$searchTerm%')");
		}
		$this->db->where('status',1);
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
	
	function getValueArray($table,$getColumn,$conditionArray='',$order_by='',$limit='')
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
	
	public function get_update_comp_value($table_name="",$field_name="",$condition="")
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
	function count_all_register()
	{
		$qry='';
		if($this->session->userdata('admin_level') == 2)
		{
			$qry="SELECT 'id' FROM institute_csv_users WHERE centerId=1 AND studentId !=' ' AND instituteId=".$this->session->userdata('instituteId');
		}
		elseif($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
			$ins=implode(",",$ins);
			$qry="SELECT 'id' FROM institute_csv_users WHERE centerId=1 AND studentId !=' ' AND instituteId IN(".$ins.") ";
		}
		else
		{
			$qry="SELECT 'id' FROM institute_csv_users where centerId=1 AND studentId !=' ' ";
		}


		if($qry != '')
		{
			return $this->db->query($qry)->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function count_all_login()
	{
		$qry='';
		if($this->session->userdata('admin_level') == 2)
		{
			$qry="SELECT count(*) AS total FROM institute_csv_users WHERE institute_csv_users.centerId=1 AND studentId!='' AND email!='' And institute_csv_users.instituteId=".$this->session->userdata('instituteId');
		}
		elseif($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
			//echo "<pre>";print_r($ins);exit;
			$ins=implode(",",$ins);
			$qry="SELECT count(*) AS total FROM institute_csv_users WHERE institute_csv_users.centerId=1 AND studentId!='' AND email!='' And institute_csv_users.instituteId IN(".$ins.") ";

			//$qry="SELECT count(*) AS total FROM users WHERE users.instituteId IN(".$ins.") ";
		}
		else
		{
			$qry="SELECT count(distinct(institute_csv_users.id)) AS total FROM institute_csv_users WHERE institute_csv_users.centerId=1 AND institute_csv_users.studentid!='' and institute_csv_users.email !=''";
		}


		if($qry != '')
		{
			$arr= $this->db->query($qry)->row_array();
    		return $total = $arr['total'];  

		}
		else
		{
			return 0;
		}
	}
	function count_all_deactive()
	{
		$qry='';
		if($this->session->userdata('admin_level') == 2)
		{
			$qry="SELECT count(*) AS total FROM institute_csv_users WHERE institute_csv_users.centerId=1 AND studentId!='' AND email!='' And institute_csv_users.instituteId=".$this->session->userdata('instituteId');
		}
		elseif($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
			//echo "<pre>";print_r($ins);exit;
			$ins=implode(",",$ins);
			$qry="SELECT count(*) AS total FROM users WHERE institute_csv_users.centerId=1 AND studentId!='' AND email!='' And users.instituteId IN(".$ins.") ";
		}
		else
		{
			$qry="SELECT count(distinct(users.id)) AS total FROM users LEFT JOIN institute_csv_users ON users.email = institute_csv_users.email WHERE institute_csv_users.centerId=1 AND studentId!='' AND institute_csv_users.studentid!=''";
		}


		if($qry != '')
		{
			$arr= $this->db->query($qry)->row_array();
    		return $total = $arr['total'];  

		}
		else
		{
			return 0;
		}
	}
	function get_with_limit($table,$limit, $offset, $order_by){

		$this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		$query=$this->db->get($table);
		return $query;
	}

	function get_where($table,$id){

		$this->db->where('id', $id);
		$query=$this->db->get($table);
		return $query;
	}

	function get_where_custom($table,$col, $value){

		$this->db->where($col, $value);
		$query=$this->db->get($table);
		return $query;
	}

	function _insert($table,$data){

		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function _update($table,$id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($table, $data);
	}

	function _update_custom($table,$field,$value, $data){

		$this->db->where($field, $value);
		return $this->db->update($table, $data);
	}

	function _delete($table,$id){

		$this->db->where('id', $id);
		return $this->db->delete($table);
	}

	function _delete_with_condition($table,$condi,$id){

		$this->db->where($condi, $id);
		return $this->db->delete($table);
	}



	function count_where($table,$column,$value1){

		$this->db->where($column, $value1);
		$query=$this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function count_all_competitions($table,$column,$value1,$value2,$value3){

		$this->db->or_where($column, $value1);
		$this->db->or_where($column, $value2);
		$this->db->or_where($column, $value3);
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
		$qry='';
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
				$qry="SELECT 'id' FROM ".$table." WHERE admin_level=2 AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d')) AND posted_by=".$this->session->userdata('instituteId');
			}
		}
		elseif($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
			$ins=implode(",",$ins);
			if($table == "institute_master")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE id IN(".$ins.") AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
			}
			elseif($table == "users")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE instituteId IN(".$ins.") AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
			}
			elseif($table == "competitions")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE instituteId IN(".$ins.") AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
			}
			elseif($table == "events")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE instituteId IN(".$ins.") AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
			}
			elseif($table == "jobs")
			{
				$qry="SELECT 'id' FROM ".$table." WHERE instituteId IN(".$ins.") AND admin_level=2 AND DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
			}
		}
		else
		{
			$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		}


		if($qry != '')
		{
			return $this->db->query($qry)->num_rows();
		}
		else
		{
			return 0;
		}
	}

	function count_institute_project()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
		}
		$this->db->select('project_master.*');
		$this->db->from('institute_master');
		$this->db->where('institute_master.status',1);
		$this->db->where('project_master.status',1);
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('institute_master.id',$ins);
		}
		else
		{
			$this->db->where('institute_master.id',$this->session->userdata('instituteId'));
		}
		$this->db->join('users', 'institute_master.id = users.instituteId');
		$this->db->join('project_master', 'users.id = project_master.userId');
		return $this->db->get()->num_rows();
		//echo $this->db->last_query();die;
	}

	function count_institute_project_all()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
		}
		$this->db->select('project_master.*');
		$this->db->from('institute_master');
		$this->db->where('institute_master.status',1);
		//$this->db->where('project_master.status',1);
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('institute_master.id',$ins);
		}
		else
		{
			$this->db->where('institute_master.id',$this->session->userdata('instituteId'));
		}
		$this->db->join('users', 'institute_master.id = users.instituteId');
		$this->db->join('project_master', 'users.id = project_master.userId');
		return $this->db->get()->num_rows();
		//echo $this->db->last_query();die;
	}
	function getAllWinner()
	{
		$this->db->select('p2.name,p4.firstName,p4.lastName');
		$this->db->from('competition_winning_projects as p1');
		$this->db->join('competitions as p2', 'p2.id = p1.competitionId');
		$this->db->join('project_master as p3', 'p3.id = p1.projectId');
		$this->db->join('users as p4', 'p4.id = p3.userId');
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}

	function getAllJob()
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->order_by('created','desc');
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}

	function getAllJob_saperate($admin_level)
	{
		$userId = $this->session->userdata('admin_id');
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
		}
		$this->db->select('*');
		$this->db->from('jobs');
		if($admin_level==3)
		{
			$this->db->where('posted_by',$userId);
		}
		elseif($admin_level==2)
		{
			$this->db->where('posted_by',$this->session->userdata('instituteId'));
		}
		elseif($admin_level==4)
		{
			$this->db->where_in('posted_by',$ins);
		}
		$this->db->order_by('created','desc');
		$this->db->limit(15);
		return $this->db->get()->result_array();
	}

	function getAllJobUsers_saperate($admin_level)
	{
		$userId = $this->session->userdata('admin_id');
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
		}
		$this->db->select('jobs.*,job_user_relation.apply_status,users.id as uId,users.firstName,users.lastName');
		$this->db->from('jobs');
		if($admin_level==3)
		{
			$this->db->where('jobs.posted_by',$userId);
		}
		elseif($admin_level==2)
		{
			$this->db->where('jobs.posted_by',$this->session->userdata('instituteId'));
		}
		elseif($admin_level==4)
		{
			$this->db->where_in('jobs.posted_by',$ins);
		}
		$this->db->join('job_user_relation','job_user_relation.jobId = jobs.id');
		$this->db->join('users','users.id = job_user_relation.userId');
		$this->db->order_by('job_user_relation.modified_date','desc');
		$this->db->limit(15);
		return $this->db->get()->result_array();
	}

	function count_institute_new_project()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->getHoadminInstitutes();
		}
		$this->db->select('project_master.*');
		$this->db->from('institute_master');
		$this->db->where('institute_master.status',1);
		//$this->db->where('institute_master.id',$this->session->userdata('instituteId'));
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('institute_master.id',$ins);
		}
		else
		{
			$this->db->where('institute_master.id',$this->session->userdata('instituteId'));
		}
		$this->db->where('DATE(project_master.created)','DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"))',FALSE);
		$this->db->join('users', 'institute_master.id = users.instituteId');
		$this->db->join('project_master', 'users.id = project_master.userId');
		return $this->db->get()->num_rows();
	}

	function count_competitions()
	{
		$this->db->select('*');
		$this->db->from('competitions');
		return $this->db->get()->num_rows();
	}



	public function getSelectedData($table,$selectString,$conditionArray='',$orderBy='',$dir='',$groupBy='',$limit='',$offset='',$resultMethod='')

	{
		/*$this->db->select('email');
		$this->db->from('admin');	
		$this->db->where('email','sayalisatav1994@gmail.com');
		$this->db->where('id !=','13');
		$ss = $this->db->get()->row_array();nd
		print_r($ss);die;*/
		

	/*	echo $table;
		echo $selectString;
		print_r($conditionArray);die;*/

		$this->db->select($selectString);

		$this->db->from($table);

		if(is_array($conditionArray) && !empty($conditionArray))

		{

			foreach ($conditionArray as $key => $value)

			{

				$this->db->where($key,$value);

			}

		}

		if($limit != '')

		{

			$this->db->limit($limit);

		}

		if($offset != '')

		{

			$this->db->offset($offset);

		}

		if($orderBy != '')

		{

			$this->db->order_by($orderBy,$dir);

		}

		if($groupBy != '')

		{

			$this->db->group_by($groupBy);

		}

		if($resultMethod != '')

		{

			if($resultMethod == 'row')

			{

				return $this->db->get()->row();

			}

			elseif ($resultMethod == 'row_array')

			{

				return $this->db->get()->row_array();
				//print_r($this->db->last_query());die;

			}

		}

		else

		{

			return $this->db->get()->result_array();

		}

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
		if($this->session->userdata('admin_level')==4)
		{
			$ins=$this->getHoadminInstitutes();
			if($table=='institute_master')
			{
				$this->db->where_in('id',$ins);
			}
			elseif($table=='group_master')
			{
				$this->db->where_in('institute_id',$ins);
			}
			elseif($table=='blog')
			{
				$this->db->where('id >',0);
			}
			elseif($table=='testimonials')
			{
				$this->db->where('id >',0);
			}
			else
			{
				if($table =='competitions')
				{
					$this->db->where_in('instituteId',$ins);
				}
				
			}
		}
		$num_rows=$this->db->count_all_results($table);
		//echo $this->db->last_query();die;
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

	function get_max($table){

		$this->db->select_max('id');
		$query = $this->db->get($table);
		$row=$query->row();
		$id=$row->id;
		return $id;
	}

	function _custom_query($table,$mysql_query){
		$query = $this->db->query($mysql_query);
		return $query;
	}

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='')
	{
		$this->db->select($selectColumns,FALSE)->from($table);
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
					//echo $orderByField;die;
					$orderByDirection=$requestData["order"][0]["dir"];
				}
				else
				{
					if($table != 'institute_csv_users')
					{
						$orderByField='created';
						$orderByDirection='desc';
					}
					else
					{
						$orderByField='firstName';
						$orderByDirection='asc';
					}

				}
			}
			else
			{
				if($table != 'institute_csv_users')
				{
					$orderByField='created';
					$orderByDirection='desc';
				}
				else
				{
					$orderByField='firstName';
					$orderByDirection='asc';
				}
			}

			return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
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
			    	$config['smtp_host']='email-smtp.ap-south-1.amazonaws.com';
			    	$config['smtp_port']='25';
			    	$config['smtp_user']='AKIA55LNN3K23VI2DIHP';
			    	$config['smtp_pass']='BPanSV7g4iuBF86FYtY60Lk88ojZEhNMujet3yvyOLfi';
			    	$config['mailtype']='html';
				}

				$this->email->initialize($config);
				$fromName 	=	'creosouls Team';
				$fromEmail="creosoulscomp5@gmail.com";
				$this->email->clear(TRUE);
				$this->email->to($data['to']);
				$this->email->from($fromEmail,$fromName);
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
		    	$config['protocol']='smtp';
		    	$config['smtp_host']='ssl://smtp.googlemail.com';
		    	$config['smtp_port']='465';
		    	$config['smtp_user']='test.unichronic@gmail.com';
		    	$config['smtp_pass']='Uspl@12345';
		    	$config['mailtype']='html';
			}

			//print_r($config);die;
			$this->email->initialize($config);
			$attachment=$data['attachment'];
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

	function uniResize($source_image_path, $destination_image_path, $tn_w, $tn_h, $quality = 100, $wmsource = false)
	{
	    $image_size_info = getimagesize($source_image_path);

		/*output of above function will base64_encode({
	    Array
	    (
	        [0] => 1920
	        [1] => 220
	        [2] => 2
	        [3] => width="1920" height="220"
	        [bits] => 8
	        [channels] => 3
	        [mime] => image/jpeg
	    )
		})*/

	    $imgtype = image_type_to_mime_type($image_size_info[2]);
	    //get mime type of image


	    #assuming the mime type is correct
	    switch ($imgtype) {
	        case 'image/jpeg':
	            $source = imagecreatefromjpeg($source_image_path);
	            break;
	        case 'image/gif':
	            $source = imagecreatefromgif($source_image_path);
	            break;
	        case 'image/png':
	            $source = imagecreatefrompng($source_image_path);
	            break;
	        default:
	            die('Invalid image type.');
	    }

	    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
	    $src_w = imagesx($source);
	    $src_h = imagesy($source);

	    #Do some math to figure out which way we'll need to crop the image
	    #to get it proportional to the new size, then crop or adjust as needed

	    $x_ratio = $tn_w / $src_w;
	    $y_ratio = $tn_h / $src_h;



	    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
	        $new_w = $src_w;
	        $new_h = $src_h;
	    } elseif (($x_ratio * $src_h) < $tn_h) {
	        $new_h = ceil($x_ratio * $src_h);
	        $new_w = $tn_w;
	    } else {
	        $new_w = ceil($y_ratio * $src_w);
	        $new_h = $tn_h;
	    }

	    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
	    imagealphablending( $newpic, false );
	    imagesavealpha( $newpic, true );
	    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
	    $final = imagecreatetruecolor($tn_w, $tn_h);
	    $black = imagecolorallocate($final, 0, 0, 0);

	    $backgroundColor = imagecolortransparent($final, $black);
	    //imagefill($final, 0, 0, $backgroundColor);
	    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
	    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

	    #if we need to add a watermark
	    if ($wmsource) {
	        #find out what type of image the watermark is
	        $image_size_info    = getimagesize($wmsource);
	        $imgtype = image_type_to_mime_type($image_size_info[2]);

	        #assuming the mime type is correct
			/*	        switch ($imgtype) {
	            case 'image/jpeg':
	                $watermark = imagecreatefromjpeg($wmsource);
	                break;
	            case 'image/gif':
	                $watermark = imagecreatefromgif($wmsource);
	                break;
	            case 'image/png':
	                $watermark = imagecreatefrompng($wmsource);
	                break;
	            default:
	                die('Invalid watermark type.');
	        }*/
	        $watermark = imagecreatefrompng($wmsource);
	        #if we're adding a watermark, figure out the size of the watermark
	        #and then place the watermark image on the bottom right of the image
	        $wm_w = imagesx($watermark);
	        $wm_h = imagesy($watermark);
	        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

	    }
	    if (imagepng($final, $destination_image_path, 9)) {
	        return true;
	    }
	    return false;
	}


	public function convertNumberToWords($number=0)
	{
		$no = round($number);
		   $point = round($number - $no, 2) * 100;
		   $hundred = null;
		   $digits_1 = strlen($no);
		   $i = 0;
		   $str = array();
		   $words = array('0' => '', '1' => 'one', '2' => 'two',
		    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		    '7' => 'seven', '8' => 'eight', '9' => 'nine',
		    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		    '13' => 'thirteen', '14' => 'fourteen',
		    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		    '60' => 'sixty', '70' => 'seventy',
		    '80' => 'eighty', '90' => 'ninety');
		   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		   while ($i < $digits_1) {
		     $divider = ($i == 2) ? 10 : 100;
		     $number = floor($no % $divider);
		     $no = floor($no / $divider);
		     $i += ($divider == 10) ? 1 : 2;
		     if ($number) {
		        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		        $str [] = ($number < 21) ? $words[$number] .
		            " " . $digits[$counter] . $plural . " " . $hundred
		            :
		            $words[floor($number / 10) * 10]
		            . " " . $words[$number % 10] . " "
		            . $digits[$counter] . $plural . " " . $hundred;
		     } else $str[] = null;
		  }
		  $str = array_reverse($str);
		  $result = implode('', $str);
		  $points = ($point) ?
		    "." . $words[$point / 10] . " " .
		          $words[$point = $point % 10] : '';
		  return ucwords($result) ;
	}

  	
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
		public function getData($table,$selectStr,$cond,$order='',$limit='',$offset='')
		{
			$this->db->select($selectStr,FALSE)->from($table);
			foreach ($cond as $key => $value)
			{
				$this->db->where($key,$value);
			}
			if($order!='')
			{
				foreach ($order as $key => $value)
				{
					$this->db->order_by($key,$value);
				}
			}
			if($limit!='')
			{
				$this->db->limit($limit,$offset);
			}
			return $this->db->get()->row_array();
		}

		public function get_where_array($table,$condition)
		{
			return $this->db->select('*')->from($table)->where($condition)->get()->row_array();
		}

		public function sendNotification($userId,$msg)
		{ 
			$API_ACCESS_KEY= 'AAAAlqhHLn0:APA91bF4yrGgfyVHMiMRMfQ7eENB18X1HZIHrS6QiQGNrgkN4oOxumJX4CQi8KlCbiRe2aiCfKtr5iSQgjwJB4xxCISutkFXhi3p2ORe1gtKsqs4eU2X-Jzt-AmGan705Dq0mXKl2sZ6';
			//define( 'API_ACCESS_KEY', 'AAAAlqhHLn0:APA91bF4yrGgfyVHMiMRMfQ7eENB18X1HZIHrS6QiQGNrgkN4oOxumJX4CQi8KlCbiRe2aiCfKtr5iSQgjwJB4xxCISutkFXhi3p2ORe1gtKsqs4eU2X-Jzt-AmGan705Dq0mXKl2sZ6' );
			$deviceId = $this->getValue('users','deviceId',"id",$userId);
			if(isset($deviceId)&&$deviceId!='')
			{
			  	$gcmToken = $this->getValue('gcm','gcmToken',"deviceId",$deviceId);
				if(isset($gcmToken)&& $gcmToken!='')
				{		
					$registrationIds = array($gcmToken);
					$fields = array
					(
						//'to'		=> $registrationIds,// at a time for single user
						'registration_ids'		=> $registrationIds,// at a time for multiple users
						'data'	=> $msg
					);		
			
					$headers = array
							(
								'Authorization: key=' . $API_ACCESS_KEY,
								'Content-Type: application/json'
							);
					#Send Reponse To FireBase Server	
					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$result = curl_exec($ch );
					curl_close( $ch );
					#Echo Result Of FireBase Server
				/*	print_r($msg);
					echo $result;*/
				}
			}
		}

		public function getAllInstitute(){
			if($this->session->userdata('admin_level') == 4)		
			{
				$ins=$this->getHoadminInstitutes();		
				$ins=implode(",",$ins);
				$qry="SELECT * FROM institute_master WHERE id IN(".$ins.") AND status=1";
			}
			else
			{
				$qry="SELECT * FROM institute_master WHERE status=1";

			}
	 		return $this->db->query($qry)->result_array();
		}

		function count_institute_project_pending()
		{
			if($this->session->userdata('admin_level') == 4)
			{
				$ins=$this->getHoadminInstitutes();
			}
			
			else
			{

			}
			$this->db->select('project_master.*');
			$this->db->from('institute_master');
			$this->db->where('project_master.admin_status','0');
			$this->db->where('project_master.status','3');
			if($this->session->userdata('admin_level') == 4)
			{
				$this->db->where_in('institute_master.id',$ins);
			}
			elseif ($this->session->userdata('admin_level') == 2) {
				$this->db->where('institute_master.id',$this->session->userdata('instituteId'));
			}
			$this->db->join('users', 'institute_master.id = users.instituteId');
			$this->db->join('project_master', 'users.id = project_master.userId');
			return $this->db->get()->num_rows();
			echo $this->db->last_query();die;
		}

		function getCountWhere($table,$conditionArr)
		{
			$this->db->from($table);
			if(!empty($conditionArr)){
				foreach ($conditionArr as $key => $value)
				{
					$this->db->where($key,$value);
				}
			}
			return $this->db->get()->num_rows();
		}
}