<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Placement_model extends CI_Model
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
	function count_all_new($table)
	{
		$qry="SELECT 'id' FROM ".$table." WHERE DATE(created) >= DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		
		return $this->db->query($qry)->num_rows();
	}
	function get_placement_details(){
		$this->db->select("placement.student_name as CandidateName,placement.company,placement.position,placement.status,placement.created",FALSE);
				$this->db->from('placement');
		$query = $this->db->get();
		return $query;
	}

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$featured_job='')
	{
		$this->db->select($selectColumns,FALSE)->from($table.' as A');		
		
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
			
			if($this->session->userdata('admin_level') == 1 && $featured_job !='' && $featured_job == 1)
			{
				$this->db->having('A.featured',$featured_job);
			}

			
		}
		else
		{
			if($featured_job !='' && $featured_job == 1)
			{
				$this->db->where('A.featured',$featured_job);
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
				$orderByField='A.created';
				$orderByDirection='DESC';
			}
		}
		else
		{
			$orderByField='A.created';
			$orderByDirection='DESC';
		}

				

		return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
		//echo $this->db->last_query();die
	}
	function get_singlePlacementData($id)
	{
		$this->db->select('placement.*');
		$this->db->from('placement');
		$this->db->where('placement.id',$id);
		$data = $this->db->get()->row_array();
		
		
		return $data;
	}
	function get_singlePlacementRegion($id)
	{
		$this->db->select('institute_master.region');
		$this->db->from('placement');
		$this->db->join('institute_master','placement.inst_id=institute_master.id','left');
		$this->db->where('placement.id',$id);
		$data = $this->db->get()->row_array();
		
		
		return $data;
	}
	function get_singlePlacementColumnData($getColumn,$id){
		$this->db->select($getColumn);
		$this->db->from('placement');
		$this->db->join('institute_master','placement.inst_id=institute_master.id','left');
		$this->db->where('placement.id',$id);
		$data = $this->db->get()->row_array();
		return $data;
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

		function getAllJob()
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->order_by('created','desc');
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}

}