<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function markCompletedCompetions()
	{
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('status',1);
	    $det = $this->db->get()->result_array();
	    
	    foreach($det as $val)
		{
		  if(date("Y-m-d H:i:s") > date("Y-m-d 23:59:59",strtotime($val['end_date'])))
			{
				$this->db->where('id',$val['id']);
				$this->db->update('events',array('status'=>2));
			}
		}
    }

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$featured_event='')
	{
		$this->db->select($selectColumns,FALSE)->from($table.' as A');  //->join('users as B','A.userId=B.id');
		
		  
			
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
						/*if($concatColumns <> '' && $value == $fieldName)
						{
							$concat=explode(',', $concatColumns);
							$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $requestData['search']['value'], 'both',FALSE);
						}
						else
						{
							if($value == 'userStatus')
							{*/
								//$value='B.status';
						/*	}*/
							$this->db->or_like($value,$requestData['search']['value'],'both');
						/*}*/
					}
					$i++;
				}
				if($this->session->userdata('admin_level')==2) 
				{
					$this->db->having('A.instituteId',$this->session->userdata('instituteId'));
				}
			}
			else
			{
				if($this->session->userdata('admin_level')==2) 
				{
					$this->db->where('A.instituteId',$this->session->userdata('instituteId'));
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

			if($featured_event !='' && $featured_event == 1)
			{
				$this->db->where('featured',$featured_event);
			}


			return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
	}

	/*public function getAutocompleteUserData($instituteId)
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
		$data=$this->db->get()->result_array();
		if(!empty($data)){
			foreach($data as $val){
				$tmp['label'] 	= $val['email'];
				$tmp['desc'] 	= $val['userName'];
				$tmp['icon'] 	= front_upload_base_url().'users/thumbs/'.$val['profileImage'];
				$tmp['userId'] 	= $val['id'];
				$rs[] 			= $tmp;
			}
		}
		return json_encode($rs);
	}*/


	public function getEditFormData($eventId)
	{
		return $this->db->select('A.*')->from('events as A')->where('A.id',$eventId)->get()->row_array();
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
		$num_rows = $this->db->count_all_results($table);
		return $num_rows;
	}

	public function getAllUser_SPCIFIC()
	{
		$this->db->select('id,firstName,lastName,email,instituteId');
		$this->db->from('users');
		$this->db->where('id','4356');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
}