<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$institute='')
	{
			if($this->session->userdata('admin_level') == 4)
			{
				$ins=$this->modelbasic->getHoadminInstitutes();
			}
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
				if($this->session->userdata('admin_level')==2)
				{
					$this->db->having('institute_id',$this->session->userdata('instituteId'));
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
								$qry.='institute_id='.$value.' OR ';
							}
							else
							{
								$qry.='institute_id='.$value;
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
					$this->db->where('institute_id',$this->session->userdata('instituteId'));
				}
				if($this->session->userdata('admin_level')==4)
				{
					$this->db->where_in('institute_id',$ins);
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

	public function getEditFormData($groupId)
	{
		$data = $this->db->select('*')->from('group_master')->where('id',$groupId)->get()->row_array();
		if(!empty($data))
		{
			$data['userList'] = $this->db->select('B.id,B.firstName,B.lastName')->from('user_group_relation as A')->join('users as B','A.user_id=B.id')->where('A.group_id',$groupId)->get()->result_array();			
		}
		return $data;
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