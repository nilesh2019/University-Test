<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Resource_model extends CI_Model

{

    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }



    function get_all_webinar()

    {

        $this->db->select('*');

        $this->db->from('webinar');

        return $this->db->get()->result_array();

    }

	function get_all_front_webinar_up()

    {

        $this->db->select('*');

        $this->db->from('webinar');

		$this->db->where('status',1);	

		$today = date("Y-m-d");

		$this->db->where('date >=',$today);      

        return $this->db->get()->result_array();

    }



    function get_all_front_webinar_past()

    {

        $this->db->select('*');

        $this->db->from('webinar');

		$this->db->where('status',1);

		$today = date("Y-m-d");

		$this->db->where('date <',$today);  

		$this->db->order_by('id','desc');

        return $this->db->get()->result_array();

    }

	function add($data)

    {

        $this->db->insert('webinar',$data);

    }

  

    public function view($id)

    {

   		 return $this->db->select('*')->from('webinar')->where('id',$id)->get()->result_array();

    }

	

	/*public function get($id)

    {

   		 return $this->db->select('*')->from('customer')->where('id',$id)->get()->result_array();

    }*/

	

	public function edit($id)

    {

   		 return $this->db->select('*')->from('webinar')->where('id',$id)->get()->result_array();

    }

	public function update_user($data,$id)

    {

		$this->db->where('id',$id);

		return $this->db->update('webinar',$data);

    }

	public function data($id)

	{

		return $this->db->select('*')->from('webinar')->where('id',$id)->get()->result_array();

	}

	public function delete($id)

    {

	    $this->db->where('id',$id);

        return $this->db->delete('webinar');

	}

	public function change_status($id,$status)

	{

		if($status == 1)

		{

			$data=array('status'=>0);

		}

		else

		{

			$data=array('status'=>1);

		}

		$this->db->where('id',$id);

		return $this->db->update('webinar',$data);

	}

	function get_table() {

	    $table = "webinar";

	    return $table;

	}

	function get_where($id){

		$table = $this->get_table();

		$this->db->where('id', $id);

		$query=$this->db->get($table);

		return $query;

	}

	function _update($id, $data){

		$table = $this->get_table();

		$this->db->where('id', $id);

		$this->db->update($table, $data);

	}

	
		/*function get_all_events_up()
	    {
	        $this->db->select('*');
	        $this->db->from('resource_events');
			$this->db->where('status',1);	
			$today = date("Y-m-d");
			$this->db->where('date >=',$today);
			$this->db->order_by('date','asc');  
	        return $this->db->get()->result_array();
	    }
	    
	    function get_all_partnership()
	    {
	        $this->db->select('*');
	        $this->db->from('partnerships');
		//	$this->db->where('event_name','Adobe Partnerships');	
		//	$today = date("Y-m-d");
		//	$this->db->where('date >=',$today);
		//	$this->db->order_by('date','asc');  
	        return $this->db->get()->result_array();
	    }
	    
	    function get_all_events_past()
	    {
	        $this->db->select('*');
	        $this->db->from('resource_events');
			$this->db->where('status',1);
			$today = date("Y-m-d");
			$this->db->where('date <',$today);
			$this->db->order_by('date','desc');
	        return $this->db->get()->result_array();
	    }	*/
  
  //get selected data from table (optional condition array, order by, group by, limit, offset, result methos)
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

}	
