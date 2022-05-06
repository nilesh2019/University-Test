<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='',$featured='',$featured_project='',$ins_flag='',$ins_val='',$cat_flag='',$cat_val='',$startDate_flag='',$startDate_val='',$endDate_flag='',$endDate_val='',$statusfalg='',$statusval='')
	{		
			/*echo $ins_flag;
			echo $ins_val;*/
			if($this->session->userdata('admin_level') == 4)
			{
				$ins=$this->modelbasic->getHoadminInstitutes();
			}
			//$featured_project = 1;
			$this->db->select($selectColumns,FALSE)->from($table.' as A');

			/* if($this->session->userdata('admin_level')==2)
			{
				$this->db->where('B.instituteId',$this->session->userdata('instituteId'));
			}*/
			$this->db->join('category_master as C','A.categoryId=C.id');
			$this->db->join('users as B','A.userId=B.id');
			$this->db->join('institute_master as D','B.instituteId=D.id','left');


		   /* if($this->session->userdata('admin_level')==2)
			{
				$this->db->where('B.instituteId',$this->session->userdata('instituteId'));
			}	*/
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
				if($this->session->userdata('admin_level')==2)
				{
					$this->db->having('B.instituteId',$this->session->userdata('instituteId'));
				}
				if($featured_project !='' && $featured_project == 1 && $this->session->userdata('admin_level') == 1)
				{
					$this->db->having('A.featured',$featured_project);
				}
				if($this->session->userdata('admin_level') == 4 && $featured_project=='')
				{
					if(!empty($ins))
					{
						$cnt=count($ins);
						$i=1;
						$qry='';
						foreach($ins as $key => $value)
						{
							if($cnt > 1 && $i < $cnt)
							{
								$qry.='B.instituteId='.$value.' OR ';
							}
							else
							{
								$qry.='B.instituteId='.$value;
							}
							$i++;
						}
					}
					$this->db->having($qry,null, false);
				}
				if($this->session->userdata('admin_level') == 4 && $featured_project !='' && $featured_project == 1)
				{
					if(!empty($ins))
					{
						$cnt=count($ins);
						$i=1;
						$qry='(';
						foreach($ins as $key => $value)
						{
							if($cnt > 1 && $i < $cnt)
							{
								$qry.='B.instituteId='.$value.' OR ';
							}
							else
							{
								$qry.='B.instituteId='.$value;
							}
							$i++;
						}
					}
					$qry=$qry.') AND A.featured ='.$featured_project;
					$this->db->having($qry,null, false);
				}
			}
			else
			{
				if($this->session->userdata('admin_level')==2)
				{
					$this->db->where('B.instituteId',$this->session->userdata('instituteId'));
				}
				if($this->session->userdata('admin_level')==4)
				{
					$this->db->where_in('B.instituteId',$ins);
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
			if($featured && $featured_project!='')
			{
				$this->db->where('A.featured',$featured_project);
			}
			//echo $ins_val;
			if($ins_flag && $ins_val!='0')
			{
				$this->db->where('B.instituteId',$ins_val);
			}
			if($cat_flag && $cat_val!='0')
			{
				$this->db->where('A.categoryId',$cat_val);
			}
			if($startDate_flag && $startDate_val!='0' && $endDate_flag && $endDate_val!='0')
			{
				$this->db->where('A.created BETWEEN "'. date('Y-m-d', strtotime($startDate_val)). '" and "'. date('Y-m-d', strtotime($endDate_val)).'"');
			}
			if($statusfalg && $statusval=='4')
			{
				$this->db->where('A.status','3');
				$this->db->where('A.admin_status','0');		
			  	//echo $this->db->last_query();exit();

			}
			elseif($statusfalg && $statusval!='' && $statusval!='4')
			{
				$this->db->where('A.status',$statusval);
			}


			return $this->db->order_by($orderByField,$orderByDirection)->limit($requestData["length"],$requestData["start"])->get()->result_array();
	}

	function getProjectCoverImage($projectId)
	{
		$result=$this->db->select('B.image_thumb')->from('project_master as A')->join('user_project_image as B','A.id=B.project_id')->where('A.id',$projectId)->where('B.cover_pic',1)->get()->row_array();
		if(!empty($result))
		{
			return $result['image_thumb'];
		}
		else
		{
			return '';
		}

	}


	function count_of_institute_project($featured='',$featured_project='',$ins_flag='',$ins_val='',$cat_flag='',$cat_val='',$startDate_flag='',$startDate_val='',$endDate_flag='',$endDate_val='',$statusfalg='',$statusval='')
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select('id');
		$this->db->from('project_master');
		$this->db->join('users', 'users.id = project_master.userId');
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('users.instituteId',$ins);
		}
		else
		{
			$this->db->where('users.instituteId',$this->session->userdata('instituteId'));
		}
		if($featured && $featured_project!='')
		{
			$this->db->where('project_master.featured',$featured_project);
		}
		if($ins_flag && $ins_val!='0')
		{
			$this->db->where('users.instituteId',$ins_val);
		}
		if($cat_flag && $cat_val!='0')
		{
			$this->db->where('project_master.categoryId',$cat_val);
		}
		if($startDate_flag && $startDate_val!='0' && $endDate_flag && $endDate_val!='0')
		{
			$this->db->where('project_master.created BETWEEN "'. date('Y-m-d', strtotime($startDate_val)). '" and "'. date('Y-m-d', strtotime($endDate_val)).'"');
		}
		if($statusfalg && $statusval!='' && $statusval=='4')
			{
				//echo $statusfalg; echo $statusval;
				$this->db->where('project_master.status','3');
				$this->db->where('project_master.admin_status','0');
			}
			elseif ($statusfalg && $statusval!='' && $statusval!='4') 
			{
				$this->db->where('project_master.status',$statusval);
			}
   	    return $this->db->count_all_results();
    }

	function count_all_only($featured='',$featured_project='',$ins_flag='',$ins_val='',$cat_flag='',$cat_val='',$startDate_flag='',$startDate_val='',$endDate_flag='',$endDate_val='',$statusfalg='',$statusval='')
	{
		
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}

		$this->db->join('users', 'users.id = project_master.userId');
		
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('users.instituteId',$ins);
		}
		
		/*if($featured=='featured' && $featured_project!='' && $featured_project==1)
		{
			$this->db->where('project_master.featured',$featured_project);
		}
		else if($featured=='insfind' && $featured_project!='' && $featured_project)
		{
			$this->db->where_in('users.instituteId',$featured_project);
		}
		else if($featured=='projectstatus' && $featured_project!='')
		{
			$this->db->where('project_master.status',$featured_project);
		}*/
		if($featured && $featured_project!='')
			{
				$this->db->where('project_master.featured',$featured_project);
			}
			if($ins_flag && $ins_val!='0')
			{
				$this->db->where('users.instituteId',$ins_val);
			}
			if($cat_flag && $cat_val!='0')
			{
				$this->db->where('project_master.categoryId',$cat_val);
			}
			if($startDate_flag && $startDate_val!='0' && $endDate_flag && $endDate_val!='0')
			{
				$this->db->where('project_master.created BETWEEN "'. date('Y-m-d', strtotime($startDate_val)). '" and "'. date('Y-m-d', strtotime($endDate_val)).'"');
			}
			if($statusfalg && $statusval!='' && $statusval=='4')
			{
				//echo $statusfalg; echo $statusval;
				$this->db->where('project_master.admin_status','0');
				$this->db->where('project_master.status','3');
			}
			elseif ($statusfalg && $statusval!='' && $statusval!='4') 
			{
				$this->db->where('project_master.status',$statusval);
			}
		$num_rows=$this->db->count_all_results('project_master');
		//echo $this->db->last_query();die;
		return $num_rows;
	}


	public function deleteProject($project_id)
	{
    	$path2 = file_upload_s3_path().'project/';
    	$path3 = file_upload_s3_path().'project/thumbs/';

		$this->db->select('id');
		$this->db->from('project_master');
		$this->db->where('id',$project_id);
		$projectData = $this->db->get()->result_array();
		if(!empty($projectData))
		{
			foreach ($projectData as $key)
			{
				$this->db->select('image_thumb');
				$this->db->from('user_project_image');
				$this->db->where('project_id',$key['id']);
				$imageName = $this->db->get()->result_array();
				//print_r($imageName);die;
				foreach ($imageName as $name)
				{
				  	unlink( $path2 . $name['image_thumb'] );
		        	unlink( $path3 . $name['image_thumb'] );
				}
				$this->db->where('project_id',$key['id']);
				$this->db->delete('user_project_image');
			}
		}

		$this->db->where('projectId',$project_id);
		$this->db->where('projectId',$project_id);
		$this->db->delete('project_attribute_relation');
		$this->db->where('projectId',$project_id);
		$this->db->delete('project_attribute_value_rating');
		$this->db->where('projectId',$project_id);
		$this->db->delete('project_team');
		$this->db->where('projectId',$project_id);
		$this->db->delete('user_project_comment');
		$this->db->where('projectId',$project_id);
		$this->db->delete('user_project_views');

    	$this->db->where('id',$project_id);
    	return $this->db->delete('project_master');
    }

	public function getCategoryAttribute($cat_id)
	{
		$this->db->select('*');
		$this->db->from('category_attribute_relation');
		$this->db->where('category_attribute_relation.categoryId',$cat_id);
		$this->db->join('attribute_master', 'attribute_master.id = category_attribute_relation.attributeId');
		$data = $this->db->get()->result_array();
		if(!empty($data)){
			$i = 0;
			foreach($data as $row){
				$this->db->select('attributeValue');
				$this->db->from('attribute_value_master');
				$this->db->where('attributeId',$row['attributeId']);
				$atrribute = $this->db->get()->result_array();
				if(!empty($atrribute)){
					$arr = array();
					foreach($atrribute as $val){
						//$arr[] = $val['attributeValue'];
						$arr[] = "'".$val['attributeValue']."'";
					}
					$data[$i]['atrribute_value'] = $arr;
				}
				else
				{
					$data[$i]['atrribute_value'] = array();
				}
				$i++;
			}
		}
		return $data;
	}
	public function get_attribute_value_id($attri_id,$vname)
	{
		$this->db->select('*');
		$this->db->from('attribute_value_master');
		$this->db->where('attributeId',$attri_id);
		$this->db->where('attributeValue',$vname);
		return $this->db->get()->result_array();
	}
	public function add_attribute_value($data)
	{
		$this->db->insert('attribute_value_master',$data);
		return $this->db->insert_id();
	}
}