<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='')
    {
    	$this->db->select($selectColumns,FALSE)->from($table.' as A')->join('users as B','A.userId=B.id')->join('category_master as C','A.categoryId=C.id');
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

}