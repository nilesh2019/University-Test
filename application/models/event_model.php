<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
		
	public function markExpiredEvents()
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
	
	
	public function getAllEventData()
	{
		$this->markExpiredEvents();		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->limit(16);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    return $this->db->get()->result_array();
    }
	
	public function event_more_data($limit,$page)
	{
		//$this->markExpiredEvents();	
	  	$start=($page-1)*$limit;
		$this->db->select('*');
		$this->db->from('events');
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->where('status !=',0);
		$this->db->order_by('created','desc');
	    $data = $this->db->get()->result_array();
		
	   if(!empty($data))
		{ 
		    $i=0;
			foreach($data as $row)
			{
				$data[$i]['end_date'] = date("F j, Y",strtotime($row['end_date']));
				$data[$i]['start_date'] = date("F j, Y",strtotime($row['start_date']));
			}
		   $i++;	
		   echo json_encode($data);
	    }
	    else
	    {
	     	echo '';
	    }
	}
	
	
	public function getSingleEvent($eventId)
	{
		$this->markExpiredEvents();
		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('id',$eventId);
		$this->db->where('status !=',0);
	    return $this->db->get()->result_array();
    }

    public function getlogincountstudent($user_id)
    {
		$this->db->select('count(*) As logincount');
		$this->db->from('institute_csv_users icu');
		$this->db->join('student_membership sm', 'icu.id = sm.csvuserId');
		$this->db->join('institute_master im', 'icu.instituteId = im.id');
		$this->db->where('im.adminId',$user_id);		
		$this->db->where('icu.centerId',1);
		$this->db->where('im.status',1);
		$this->db->where('icu.studentId !=',' ',true);
		$this->db->where('icu.email != ',' ',true);
		$query=$this->db->get();
		if($query->num_rows()== 1)
		{			
			return $query->row()->logincount;
		}
		else
		{
			return false;
		}	
    }


    public function getregistercountstudent($user_id)
    {
		$this->db->select('count(*) As registercount');
		$this->db->from('institute_csv_users icu');
		$this->db->join('student_membership sm', 'icu.id = sm.csvuserId');
		$this->db->join('institute_master im', 'icu.instituteId = im.id');
		$this->db->where('icu.centerId',1);
		$this->db->where('im.adminId',$user_id);
		$this->db->where('im.status',1);
		$this->db->where('icu.studentId !=',' ',true);
		$query=$this->db->get();
		if($query->num_rows()== 1)
		{			
			return $query->row()->registercount;
		}
		else
		{
			return false;
		}	
    }
}