<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Courses_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$institute)
    {
    		$this->db->select($selectColumns,FALSE)->from($table.' as A');
    		$this->db->join('course_type as C','A.course_type=C.id','left');
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
		$num_rows = $this->db->count_all_results($table);
		
		return $num_rows;
	}

   

	public function _update($table,$id,$data){
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}
	

	public function get_single_course($id){
		$this->db->select('*')->from('courses');		
		$this->db->where('id', $id);		
		return $this->db->get()->row_array();
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

}