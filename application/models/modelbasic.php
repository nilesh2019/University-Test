<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Modelbasic extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getValue($table,$selectColumns,$whereArray=''){
		$this->db->select($selectColumns);
		$this->db->from($table);
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		$result=$this->db->get()->row();
		if(!empty($result)){
			return $result->$selectColumns;
		}else{
			return '';
		}
	}
	function count_all_only($table,$whereArray=''){
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		$num_rows = $this->db->count_all_results($table);
		return $num_rows;
	}
	function getValues($table,$selectColumns,$whereArray='',$resultMethod='',$join='',$group_by='',$order_by='',$limit='',$like_columns='',$like_value='',$concatColumns = '',$havingArray='',$where_in='',$where_in_array=''){
		$this->db->select($selectColumns);
		$this->db->from($table);
		if($join != ''){
			if(is_array($join) && !empty($join)){
				foreach ($join as $value){
					$this->db->join($value[0],$value[1],'left');
				}
			}
		}
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		if(is_array($where_in_array) && !empty($where_in_array)) {
			$this->db->where_in($where_in,$where_in_array);
		}
		if($like_columns != ''){
			if(is_array($like_columns) && !empty($like_columns)){
				$i=0;
				foreach ($like_columns as $like_column){
					if($i==0){
						$this->db->like($like_column,$like_value,'both');
					}else{
						if($concatColumns <> '' && $like_column == $fieldName){
							$concat=explode(',', $concatColumns);
							$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $like_value, 'both',FALSE);
						}else{
							$this->db->or_like($like_column,$like_value,'both');
						}
					}
					$i++;
				}
			}
			else{
				$this->db->like($like_columns,$like_value,'both');
			}
		}
		if($group_by != ''){
			if(is_array($group_by)){
				$this->db->group_by($group_by[0],$group_by[1]);
			}else{
				$this->db->group_by($group_by);
			}
		}
		if($havingArray != ''){
			if(is_array($havingArray)){
				$this->db->having($havingArray);
			}else{
				$this->db->having($havingArray, NULL, FALSE);
			}
		}
		if($order_by != ''){
			if(is_array($order_by)){
				$this->db->order_by($order_by[0], $order_by[1]);
			}else{
				$this->db->order_by($order_by);
			}
		}
		if($limit != ""){
			if(is_array($limit)){
				if(count($limit)>1){
					$this->db->limit($limit[0] , $limit[1]);
				}
			}else{
				$this->db->limit($limit);
			}
		}
		if($resultMethod != ''){
			if($resultMethod == 'row'){
				return $this->db->get()->row();
			}elseif($resultMethod == 'row_array'){
				return $this->db->get()->row_array();
			}elseif($resultMethod == 'result_array'){
				return $this->db->get()->result_array();
			}
		}else{
			return $this->db->get();
		}
	}
	function getValuesJoin($table,$selectColumns,$whereArray='',$resultMethod='',$join='',$group_by='',$order_by='',$limit='',$like_columns='',$like_value='',$concatColumns = '',$havingArray='',$where_in='',$where_in_array=''){
		$this->db->select($selectColumns);
		$this->db->from($table);
		if($join != ''){
			if(is_array($join) && !empty($join)){
				foreach ($join as $value){
					$this->db->join($value[0],$value[1]);
				}
			}
		}
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		if(is_array($where_in_array) && !empty($where_in_array)) {
			$this->db->where_in($where_in,$where_in_array);
		}
		if($like_columns != ''){
			if(is_array($like_columns) && !empty($like_columns)){
				$i=0;
				foreach ($like_columns as $like_column){
					if($i==0){
						$this->db->like($like_column,$like_value,'both');
					}else{
						if($concatColumns <> '' && $like_column == $fieldName){
							$concat=explode(',', $concatColumns);
							$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $like_value, 'both',FALSE);
						}else{
							$this->db->or_like($like_column,$like_value,'both');
						}
					}
					$i++;
				}
			}
			else{
				$this->db->like($like_columns,$like_value,'both');
			}
		}
		if($group_by != ''){
			if(is_array($group_by)){
				$this->db->group_by($group_by[0],$group_by[1]);
			}else{
				$this->db->group_by($group_by);
			}
		}
		if($havingArray != ''){
			if(is_array($havingArray)){
				$this->db->having($havingArray);
			}else{
				$this->db->having($havingArray, NULL, FALSE);
			}
		}
		if($order_by != ''){
			if(is_array($order_by)){
				$this->db->order_by($order_by[0], $order_by[1]);
			}else{
				$this->db->order_by($order_by);
			}
		}
		if($limit != ""){
			if(is_array($limit)){
				if(count($limit)>1){
					$this->db->limit($limit[0] , $limit[1]);
				}
			}else{
				$this->db->limit($limit);
			}
		}
		if($resultMethod != ''){
			if($resultMethod == 'row'){
				return $this->db->get()->row();
			}elseif($resultMethod == 'row_array'){
				return $this->db->get()->row_array();
			}elseif($resultMethod == 'result_array'){
				return $this->db->get()->result_array();
			}
		}else{
			return $this->db->get();
		}
	}
	function _insert($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	function _insert_batch($table,$data){
		return $this->db->insert_batch($table, $data);
	}
	function _update($table,$whereArray, $data){
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		return $this->db->update($table, $data);
	}
	function _update_batch($table,$data,$whereKey){
		$this->db->update_batch($table, $data, $whereKey);
	}
	function _update_custom($table,$field,$value, $data){
		$this->db->where($field, $value);
		return $this->db->update($table, $data);
	}
	function _delete($table,$whereArray){
		if($whereArray != ''){
			if(is_array($whereArray)){
				$this->db->where($whereArray);
			}else{
				$this->db->where($whereArray, NULL, FALSE);
			}
		}
		return $this->db->delete($table);
	}
	function custom_query($query){
		return $this->db->query($query);
	}
	function run_query($table,$requestData=array(),$columns,$selectColumns,$concatColumns = '',$fieldName='',$condition = '',$join_array='',$group_by='',$orderByField='',$orderByDirection='',$where_in_array='',$recordsFiltered=0){
		$this->db->select($selectColumns,FALSE)->from($table);
		if($join_array != ''){
			if(is_array($join_array) && !empty($join_array)){
				foreach ($join_array as $value){
					$joinType='left';
					if(isset($value[2])){
						$joinType=$value[2];
					}
					$this->db->join($value[0],$value[1],$joinType);
				}
			}
		}
		if(!empty($requestData)){
			$i=0;
			if(!empty($requestData['search']['value']) ){
				foreach ($columns as $value){
					if($i==0){
						$this->db->group_start();
						if(isset($requestData['search']['regex']) && $requestData['search']['regex']){
							$this->db->where($value.' RLIKE', "'".$requestData['search']['value']."'", FALSE);
						}else{
							$this->db->like($value,$requestData['search']['value'],'both');
						}
						if(count($columns)==1){
							$this->db->group_end();
						}
					}else{
						if($concatColumns <> '' && $value == $fieldName){
							$concat=explode(',', $concatColumns);
							if(isset($requestData['search']['regex']) && $requestData['search']['regex']){
								$this->db->or_where("CONCAT($concat[0],' ', $concat[1]) RLIKE", "'".$requestData['search']['value']."'", FALSE);
							}else{
								$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $requestData['search']['value'], 'both',FALSE);
							}
						}else{
							if(isset($requestData['search']['regex']) && $requestData['search']['regex']){
								$this->db->or_where($value.' RLIKE', "'".$requestData['search']['value']."'", FALSE);
							}else{
								$this->db->or_like($value,$requestData['search']['value'],'both');
							}
						}
						if(count($columns)==$i+1){
							$this->db->group_end();
						}
					}
					$i++;
				}				
			}
		}
		if($condition != ''){
			if(is_array($condition)){
				$this->db->where($condition);
			}else{
				$this->db->where($condition, NULL, FALSE);
			}
		}
		if($where_in_array != ''){
			if(is_array($where_in_array) && !empty($where_in_array)){
				foreach ($where_in_array as $value){
					$this->db->where_in($value[0],$value[1]);
				}
			}
		}
		if(!empty($requestData)){
			if(!empty($requestData["order"])){
				$orderby=$requestData["order"][0]["column"];
				$orderByField='';
				$dataColumns=array();
				foreach ($requestData['columns'] as $key => $value) {
					$dataColumns[]=$value['data'];
				}
				if(isset($dataColumns[$orderby]) && $dataColumns[$orderby] != '') {
					$orderByField=$dataColumns[$orderby];
					$orderByDirection=$requestData["order"][0]["dir"];
				}else{
					$orderByField=$dataColumns[1];
					$orderByDirection=$requestData["order"][0]["dir"];
				}
			}
		}
		if($orderByField != '') {
			$this->db->order_by($orderByField,$orderByDirection);
		}
		if(!empty($requestData) && isset($requestData["length"])){
			if($requestData["length"] != -1 && $recordsFiltered==0){
				$this->db->limit($requestData["length"],$requestData["start"]);
			}
		}
		if($group_by != '') {
			$this->db->group_by($group_by);
		}
		$query = $this->db->get();
		$data = array();
		if($query !== FALSE && $query->num_rows() > 0){
		    $data = $query->result_array();
		}
		return $data;
	}
}