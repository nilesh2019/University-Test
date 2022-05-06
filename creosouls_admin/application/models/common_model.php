<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
	Public function fetchAllDataAsc($table_name, $asc_by_col_name,$fields)
	{
		$this->db->select($fields)->from($table_name)->order_by($asc_by_col_name, "asc");  
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
            return $qry->result();
		}
		else
		{
			return false;
		}
	}
	Public function fetchAllDataDesc($table_name, $asc_by_col_name,$fields)
	{
		$this->db->select($fields)->from($table_name)->order_by($asc_by_col_name, "desc");  
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
            return $qry->result();
		}
		else
		{
			return false;
		}
	}


	public function selectDetailsWhr($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows()== 1)
		{			
			return $query->row();
		}
		else
		{
			return false;
		}			
	}

	public function selectAllWhr($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0)
        {
            return $query->result() ;
        }
        else
        {
        	return false;
        }		
	}

	Public function selectAllArrayWhr($table,$getColumn,$conditionArray='')
	{
		$this->db->select($getColumn,false);
		$this->db->where($conditionArray);
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0)
        {
            return $query->result() ;
        }
        else
        {
        	return false;
        }
	}
}