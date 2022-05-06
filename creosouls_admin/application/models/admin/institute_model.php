<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Institute_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='')
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select($selectColumns,FALSE)->from($table.' as A')->join('users as B','A.adminId=B.id');
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
							if($value == 'userStatus')
							{
								$value='B.status';
							}
							$this->db->or_like($value,$requestData['search']['value'],'both');
						}
					}
					$i++;
				}
			  	if($this->session->userdata('admin_level')==2) 
				{
					$this->db->having('A.id',$this->session->userdata('instituteId'));
				}
				if($this->session->userdata('admin_level') == 4)
				{
					if(!empty($ins))
					{
						$cnt=count($ins);
						$i=1;
						$qry='';
						foreach($ins as $key => $value)
						{
							
							if($cnt > 1 && $i < $cnt)
							{
								$qry.='A.id='.$value.' OR ';
							}
							else
							{
								$qry.='A.id='.$value;
							}
							$i++;
						}
					}
					$this->db->having($qry,null, false);
				}
			}
			else
			{
				  if($this->session->userdata('admin_level')==2) 
					{
						$this->db->where('A.id',$this->session->userdata('instituteId'));
					}
					if($this->session->userdata('admin_level')==4) 
					{
						$this->db->where_in('A.id',$ins);
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

	public function getAutocompleteUserData($instituteId)
	{
		$rs=array();
		$this->db->select('id,email,CONCAT(firstName," ",lastName) as userName,profileImage',FALSE)->from('users');
		$this->db->where('status',1);
		if(isset($instituteId) && $instituteId > 0)
		{
			$this->db->where('instituteId',$instituteId);
		}
		else
		{
			$this->db->where('instituteId',0);
		}
		/*$this->db->where('instituteId',0);
		$this->db->or_where('instituteId',$instituteId);*/
		$data=$this->db->get()->result_array();
		if(!empty($data)){
			foreach($data as $val){
				$tmp['label'] 	= $val['email'];
				$tmp['desc'] 	= $val['userName'];
				$tmp['icon'] 	= file_upload_base_url().'users/thumbs/'.$val['profileImage'];
				$tmp['userId'] 	= $val['id'];
				$rs[] 			= $tmp;
			}
		}
		return json_encode($rs);
	}


	public function getEditFormData($instituteId)
	{
		return $this->db->select('A.*,B.email')->from('institute_master as A')->join('users as B','A.adminId=B.id')->where('A.id',$instituteId)->get()->row_array();
	}

	function getAllWhere($table,$fields,$condition)
	{
		$this->db->select($fields);
		$this->db->from($table);

		foreach ($condition as $key => $value)
		{
			$this->db->where($key,$value);
		}

		return $this->db->get()->result_array();
	}

	public function updateAll($instituteId,$userId,$admin_level,$previous_admin_level)
	{
		$i=0;
		$allJobsId =  $this->modelbasic->getAllWhere('jobs','id',array('posted_by'=>$userId,'admin_level'=>$previous_admin_level));
		if(!empty($allJobsId))
		{
			foreach($allJobsId as $val)
			{
				$data = array(
							'admin_level'=>$admin_level,
							'posted_by'=>$instituteId,
							'previous_admin_level'=>$previous_admin_level,
						);
				$this->db->where('id', $val['id']);
				$this->db->update('jobs', $data);
				$i++;
			}
		}
		if($i!=0)
		{
			return true;
		}
		else{
			return false;
		}
	}

}