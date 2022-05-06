<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Feedback_instance_model extends CI_Model

{

    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }



	function run_query($table,$requestData,$columns,$selectColumns,$condition,$concatColumns = '',$fieldName='')

	{

		$this->db->select($selectColumns,FALSE)->from($table);

			if(!empty($condition))

			{



				foreach ($condition as $key => $value)

				{

					$this->db->where($key,$value);

				}

			}



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

				if($table != 'feedback_instance')

				{

					$orderByField='created';

					$orderByDirection='desc';

				}

				else

				{

					$orderByField='name';

					$orderByDirection='asc';

				}

			}



			 return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();

			// echo $this->db->last_query();die;

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

	function _insert($table,$data){



		$this->db->insert($table, $data);

		return $this->db->insert_id();

	}

	function _update($table,$id, $data)

	{

		$this->db->where('id', $id);

		return $this->db->update($table, $data);

	}

	public function getEditFormData($feedbackInstanceId)

	{

		$this->db->select('id as feedbackInstanceId, name as sessionName, start_session as sessionStartDate, end_session as sessionEndDate');

		$this->db->from('feedback_instance');

		$this->db->where('id',$feedbackInstanceId);

		return $this->db->get()->row_array();

	}



	public function getAllInstituteUser($id){



		$this->db->select('*');

		$this->db->from('users');

		$this->db->where('instituteId',$id);

		return $this->db->get()->result_array();

	}

}