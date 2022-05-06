<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class all_project_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllProjectData()
	{
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt');
		$this->db->from('project_master');
		$this->db->where('user_project_image.cover_pic',1);
		$this->db->where('project_master.view_status','Y');
		$this->db->order_by('project_master.created','desc');
		$this->db->limit(12);
		$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		
		//$this->db->join('competitions', 'competitions.id = project_master.competitionId', 'left');
		//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		$this->db->group_by('project_master.id');
		$qry=$this->db->get();
		//echo $this->db->last_query();
		foreach ($qry->result_array() as $row)
        {
            $data[]=$row;
            /*if(isset($row['competitionId']) && $row['competitionId']!=0)
            {
            	if(isset($row['status']) && ($row['status']=='4' || $row['status']=='4'))
            	{
            		$data[]=$row;
            	}
            }
            else
            {
            	$data[]=$row;
            }*/
        }
        $new_array = array();
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				
				$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				
				
				$i++;
			}
		}
		return $data;
	}
	public function getCreativeWorkData()
	{
		$this->db->select('new_project_master.project_id,new_project_master.projectName,new_project_master.projectPageName,new_project_master.userId,new_project_master.categoryId,new_project_master.videoLink,user_project_image.image_thumb,new_project_master.view_cnt,new_project_master.like_cnt,new_project_master.comment_cnt');
		$this->db->from('new_project_master');
		$this->db->where('user_project_image.cover_pic',1);
		//$this->db->where('new_project_master.view_status','Y');
		//$this->db->order_by('project_master.created','desc');
		$this->db->limit(12);
		//$this->db->where('project_master.status',1);
		$this->db->join('user_project_image', 'user_project_image.project_id = new_project_master.project_id');
		
		//$this->db->join('competitions', 'competitions.id = project_master.competitionId', 'left');
		//$this->db->join('attribute_master', 'attribute_master.id = project_attribute_relation.attributeId','left');
		//$this->db->join('attribute_value_master', 'attribute_value_master.id = project_attribute_relation.attributeValueId', 'left');
		//$this->db->group_by('project_master.id');
		$qry=$this->db->get();
		//echo $this->db->last_query();exit();
		foreach ($qry->result_array() as $row)
        {
            $data[]=$row;
            /*if(isset($row['competitionId']) && $row['competitionId']!=0)
            {
            	if(isset($row['status']) && ($row['status']=='4' || $row['status']=='4'))
            	{
            		$data[]=$row;
            	}
            }
            else
            {
            	$data[]=$row;
            }*/
        }
        $new_array = array();
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				
				$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				
				
				$i++;
			}
		}
		return $data;
	}
	public function more_data($limit,$page,$all_project = '',$creative_fields = '',$featured = '',$search_term = '',$vartime='')
	{
		$start = ($page - 1) * $limit;
		$this->db->select('project_master.id,project_master.projectName,project_master.projectPageName,project_master.userId,project_master.categoryId,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,project_master.comment_cnt');
		$this->db->from('project_master');
		$this->db->where('project_master.view_status','Y');
		$this->db->where('user_project_image.cover_pic',1);
		if($search_term != '')
		{
			//$this->db->where("(project_master.projectName LIKE '%".$search_term."%'|| project_master.basicInfo LIKE '%".$search_term."%')");
			$this->db->where("(project_master.projectName LIKE '%".$search_term."%'|| project_master.basicInfo LIKE '%".$search_term."%'|| project_master.keyword LIKE '%".$search_term."%')");
		}
		if($all_project == 'Completed')
		{
			$this->db->where('project_master.projectStatus',1);
		}
		if($all_project == 'Work in progress')
		{
			$this->db->where('project_master.projectStatus',0);
		}

		if($this->session->userdata('adv_category_id') && $this->session->userdata('adv_category_id')!='' )
	    	{
	    		array_push($creative_fields,$this->session->userdata('adv_category_id'));
	        }

		if($creative_fields != '')
		{
			if(!empty($creative_fields))
			{
				$this->db->where_in('project_master.categoryId',$creative_fields);
			}
		}

		if($featured == 'Featured')
		{
			$this->db->order_by('project_master.created','desc');
		}
		elseif($featured == 'Most Appreciated')
		{
			$this->db->order_by('project_master.like_cnt','desc');
			//$this->db->where('project_master.like_cnt >',0);
		}
		elseif($featured == 'Most Viewed')
		{
			$this->db->order_by('project_master.view_cnt','desc');
		}
		elseif($featured == 'Most Discussed')
		{
			$this->db->order_by('project_master.comment_cnt','desc');
		}
		elseif($featured == 'Most Recent')
		{
			$this->db->order_by('project_master.created','desc');
		}		
		else
		{
			$this->db->order_by('project_master.created','desc');
		}
		$date = new DateTime("now"); 
		//echo $vartime;
		if ($vartime == 'Featured') 
		{
			$this->db->order_by('project_master.created','desc');
			$this->db->where("project_master.featured",'1');
		}		
		elseif ($vartime=='Today') {
 			$curr_date = $date->format('d-m-Y');
 			$where = "date_format(project_master.created,'%d-%m-%Y')='$curr_date'";
			$this->db->where($where);
			//$this->db->where("date_format(project_master.created,'%d-%m-%Y')",$curr_date, FALSE);
		}
		elseif ($vartime=='This Month') {
 			$curr_date = $date->format('m-Y');
 			$where = "date_format(project_master.created,'%m-%Y')='$curr_date'";
			$this->db->where($where);
			//$this->db->where("date_format(project_master.created,'%m-%Y')",$curr_date, FALSE);
		}
		elseif($vartime=='This Week')
		{
			//check the current day
			if(date('D')!='Mon')
			{    
			 //take the last monday
			  $staticstart = date('Y-m-d',strtotime('last Monday'));    

			}else{
			    $staticstart = date('Y-m-d');   
			}

			//always next Sunday

			if(date('D')!='Sun')
			{
			    $staticfinish = date('Y-m-d',strtotime('next Sunday'));
			}else{
				$staticfinish = date('Y-m-d');
			}
 			$where = "(date_format(project_master.created,'%Y-%m-%d') BETWEEN '$staticstart' AND '$staticfinish')";
			$this->db->where($where);

		}
		
	    
	    
		$this->db->where('project_master.status',1);
		$this->db->limit($limit);
		$this->db->offset($start);
		$this->db->join('user_project_image', 'user_project_image.project_id = project_master.id');
		
		$this->db->group_by('project_master.id');
		$qry=$this->db->get();
		//echo $this->db->last_query();
		foreach ($qry->result_array() as $row)
        {
            
            $data[]=$row;
           
        }	
        $new_array = array();
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				
				$data[$i]['categoryName'] =$this->model_basic->getValue('category_master','categoryName'," `id` = '".$data[$i]['categoryId']."'");
				$imageCount = $this->getCount('user_project_image','project_id',$row['id']);
				$data[$i]['imageCount'] = $imageCount;
				if($this->session->userdata('front_user_id') && $this->session->userdata('front_user_id'))
				{
					$this->db->select('*');
					$this->db->from('user_project_views');
					$this->db->where('projectId',$row['id']);
					$this->db->where('userId',$this->session->userdata('front_user_id'));
					$this->db->where('userLike',1);
					$data[$i]['userLiked'] = $this->db->get()->num_rows();
				}
				else{
					$data[$i]['userLiked']=0;
				}
				$totalLikeName = $this->db->select('B.firstName,B.lastName')->from('user_project_views as A')->join('users as B','B.id=A.userId')->where('A.projectId',$row['id'])->where('A.userLike',1)->get()->result_array(); 
						$str ='';
						if(!empty($totalLikeName))
						{
							$str .='<ul class="dropdown-menu">';
							foreach ($totalLikeName as $TLname) {
								$str .='<li>'.$TLname["firstName"].' '.$TLname["lastName"].'</li>';								
							}  
							$str .='</ul>'; 
							$data[$i]['droupdown']=$str;
						}
						else
						{
							$str .='<ul class="dropdown-menu"></ul>';
							$data[$i]['droupdown']=$str;
						}					

				$i++;
			}
		}
		//print_r($data);
		if(!empty($data))
		{
			echo json_encode($data);
		}
		else
		{
			echo '';
		}
	}
	function getCount($table,$field,$value)
	{
		return $this->db->from($table)->where($field,$value)->get()->num_rows();
	}
	public function getAllCategory()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}
	public function findCategory($cat)
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->where('categoryName',$cat);
		return $this->db->get()->result_array();
	}
	public function check_image_exixt_on_server($url)
	{
		$headers = get_headers($url);
		if(strpos($headers[17],"200") > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function get_all_attribute()
	{
		$this->db->select('*');
		$this->db->from('attribute_master');
		$this->db->where('status',1);
		$this->db->order_by('attributeName','asc');
		return $this->db->get()->result_array();
	}
	public function get_category_attribute($cat_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_master');
		$this->db->join('category_attribute_relation', 'attribute_master.id = category_attribute_relation.attributeId');
		$this->db->where('categoryId',$cat_id);
		$this->db->order_by('attributeName','asc');
		return $this->db->get()->result_array();
	}
	public function get_attribute_detail()
	{
	}
	public function get_all_category()
	{
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('status',1);
		$this->db->order_by('categoryName','asc');
		return $this->db->get()->result_array();
	}
	public function get_attribute_value($attri_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('attributeId',$attri_id);
		$this->db->order_by('attributeValue','asc');
		return $this->db->get()->result_array();
	}
	public function get_attribute_value_detail($attri_val_id)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('id',$attri_val_id);
		return $this->db->get()->result_array();
	}
	public function get_attribute_and_value($attribute_id,$attri_val_id)
	{
		$this->db->select('attribute_master.id,attribute_master.attributeName,attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('attribute_master');
		$this->db->where('attribute_master.status',1);
		$this->db->where('attribute_master.id',$attribute_id);
		$this->db->where('attribute_value_master.id',$attri_val_id);
		$this->db->join('attribute_value_master', 'attribute_master.id = attribute_value_master.attributeId');
		return $this->db->get()->result_array();
	}
	public function get_project_attribute_value($project_id,$attribute_id)
	{
		$this->db->select('attribute_value_master.id,attribute_value_master.attributeValue');
		$this->db->from('project_attribute_relation');
		$this->db->where('project_attribute_relation.projectId',$project_id);
		$this->db->where('project_attribute_relation.attributeId',$attribute_id);
		$this->db->join('attribute_value_master', 'project_attribute_relation.attributeValueId = attribute_value_master.id');
		return $this->db->get()->result_array();
	}
}