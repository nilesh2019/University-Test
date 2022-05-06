<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Support_issue_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$institute)
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
    				$orderByField='created';
    				$orderByDirection='desc';
    			}
    		}
    		else
    		{
    			$orderByField='created';
    			$orderByDirection='desc';
    		}

    		return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
     }




	function count_all_new($table)
	{
		$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) = DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		return $this->db->query($qry)->num_rows();
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
		if($this->session->userdata('admin_level')==2)
		{
			$num_rows = $this->db->from($table)->where('instituteId',$this->session->userdata('instituteId'))->count_all_results();
		}
		else
		{
			$num_rows = $this->db->count_all_results($table);
		}

		return $num_rows;
	}

   

	public function _update($table,$id,$data){
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	

	public function get_single_admin($id)
	{
		$this->db->select('*')->from('admin');		
		$this->db->where('id', $id);		
		$ho_adminData =  $this->db->get()->row_array();
		$ho_adminData['zone'] =array();
		$ho_adminData['region'] = array();

		$this->db->select('zone')->from('hoadmin_institute_relation');		
		$this->db->where('hoadmin_id', $id);	
		$this->db->group_by('zone');			
		$zone =  $this->db->get()->result_array();
		if(!empty($zone))
		{
			foreach ($zone as $key => $value) {
			$ho_adminData['zone'] []=$value['zone'];
			}
		}

		$this->db->select('region')->from('hoadmin_institute_relation');		
		$this->db->where('hoadmin_id', $id);	
		$this->db->group_by('region');	
		$region =  $this->db->get()->result_array();
		if(!empty($region))
		{
			foreach ($region as $key => $value) {
			$ho_adminData['region'] []=$value['region'];
			}
		}
		
		return $ho_adminData;

	}

	function _insert($table,$data){

		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function getSelectedData($table,$selectString,$conditionArray='',$orderBy='',$dir='',$groupBy='',$limit='',$offset='',$resultMethod='')

	{

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

			}

		}

		else

		{

			return $this->db->get()->result_array();

		}

	}

	function export_users_project_count($instituteId='')
	{
		//$baseUrl=front_base_url();
		$this->db->select("users.id,CONCAT(users.firstName,' ',users.lastName) as CandidateName,users.email as Email,users.instituteId, COUNT(case project_master.status when '1' then 1 else null end) as Public ,COUNT(case project_master.status when '2' then 1 else null end) as Incomplit,COUNT(case project_master.status when '3' then 1 else null end) as Private,COUNT(case project_master.status when '0' then 1 else null end) as Draft,COUNT(project_master.id) as TotalProjectCount",FALSE);

		$this->db->from('project_master');		
	    $this->db->join('users', 'users.id = project_master.userId', 'left');
	    if($this->session->userdata('admin_level') != 1)
	    {
	    	$this->db->where('users.instituteId',$instituteId);	
	    }     
	    $this->db->group_by('users.id');	  
		$query = $this->db->get();	
	//	print_r($query);die;
		return $query;
	}


	function export_users_likers_project($instituteId='')
	{		
		$this->db->select("zl.zone_name,rl.region_name,im.instituteName,pm.projectName,CONCAT(u.firstName,' ',u.lastName) as projectOwnerName,u.email as ownerEmail,uv.userId,uv.like_date",FALSE);
		$this->db->from('user_project_views as uv');
		$this->db->join('project_master as pm', 'pm.id = uv.projectId');
		$this->db->join('users as u', 'u.id = pm.userId');	
		$this->db->join('institute_master as im', 'im.id = u.instituteId');
		$this->db->join('region_list as rl', 'rl.id = im.region');
		$this->db->join('zone_list as zl', 'zl.id = im.zone');
	    $this->db->where('uv.userLike',1);
	    if($this->session->userdata('admin_level') != 1)
	    {
	    	$this->db->where('u.instituteId',$instituteId);	
	    }  	  
	   $query = $this->db->get()->result_array();

		foreach ($query as $key => $value) 
		{
			$this->db->select("firstName,lastName,email");
			$this->db->from('users');
			$this->db->where('id',$value['userId']);
			$data = $this->db->get()->row_array();
			if(!empty($data))
			{
				$query[$key]['LikerName'] = $data['firstName'].' '.$data['lastName'];
				$query[$key]['LikerEmail'] = $data['email'];
				unset($query[$key]['userId']);
			}
			else
			{
				$query[$key]['LikerName'] = 'User Deleted';
				$query[$key]['LikerEmail'] = 'User Deleted';
				unset($query[$key]['userId']);
			}
		}		
		return $query;
	}

function export_users_assignments($instituteId='')
	{		
		$this->db->select("CONCAT(u.firstName,' ',u.lastName) as StudentName,asi.assignment_name as AssignmentName,asi.start_date as StartDate,asi.end_date as EndDate,
	 CASE pm.assignment_status
	   when 1 then 'Submitted'
	   when 2 then 'Pending'
	   when 3 then 'Accepted'
	   when 4 then 'Re-Submitted'  
	   ELSE 'Not Submitted'
	END as AssignmentStatus",FALSE);
		$this->db->from('users as u');	
		$this->db->join('user_assignment_relation as uar', 'uar.user_id = u.id');
		$this->db->join('assignment as asi', 'asi.id = uar.assignment_id');
		$this->db->join('project_master as pm', '(pm.assignmentId = uar.assignment_id AND pm.userId = uar.user_id','left');
		if($this->session->userdata('admin_level') != 1)
		{
			$this->db->where('u.instituteId',$instituteId);	
		} 		
		$this->db->order_by('u.firstName');
	    $query = $this->db->get()->result_array();
		return $query;
	}


}