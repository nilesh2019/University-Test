<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Creative_mind_competition_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	  public function checkUserEligible($user_institute_id,$competitionId)
	{
		$det = array();
		
		$this->db->select('competitions.id,competitions.instituteId,competitions.open_for_all');
		$this->db->from('creative_mind_competition');
		$this->db->where('status',1);
		$this->db->where('id',$competitionId);
		$competitionData = $this->db->get()->result_array();
		
		if(!empty($competitionData))
		  {
		  	 if($competitionData[0]['instituteId']==$user_institute_id)
			  {
			  	 $det = $competitionData;
			  }
			 elseif($competitionData[0]['open_for_all']==1)
			  {
			  	 $det = $competitionData;
			  }
			  else
			  {
			  	$det = array();
			  }
    	  }
		
		return $det;
	}
    	

	public function markCompletedCompetions()
	{
		$this->db->select('*');
		$this->db->from('creative_mind_competition');
		$this->db->where('status',1);
	    $det = $this->db->get()->result_array();

	    foreach($det as $val)
		{
		  if(date("Y-m-d H:i:s") > date("Y-m-d 23:59:59",strtotime($val['end_date'])))
			{
				$this->db->where('id',$val['id']);
				$this->db->update('creative_mind_competition',array('status'=>2));
			}
		}
    }

    public function getJuryDetail($juryId)
    {
    	return $this->db->select('name,email')->from('competition_jury')->where('id',$juryId)->get()->result_array();
    }

	public function getCompetitionJury($competitionId)
	{
		$this->db->select('A.id,A.email,A.name');
		$this->db->from('competition_jury as A');
		$this->db->join('creative_competition_jury_relation as B','A.id=B.juryId');
		$this->db->where('B.competitionId',$competitionId);
		$this->db->where('A.status',1);
		return $this->db->get()->result_array();
	}

	public function checkRating($data)
	{
		return $this->db->select('id')->from('project_jury_rating')->where($data)->limit(1)->get()->row();
	}

	function run_query($table,$requestData,$columns,$selectColumns,$concatColumns = '',$fieldName='')
	{
		/*if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}*/
		$this->db->select($selectColumns,FALSE)->from($table.' as A');  //->join('users as B','A.userId=B.id');

		  

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
						/*if($concatColumns <> '' && $value == $fieldName)
						{
							$concat=explode(',', $concatColumns);
							$this->db->or_like("CONCAT($concat[0],' ', $concat[1])", $requestData['search']['value'], 'both',FALSE);
						}
						else
						{
							if($value == 'userStatus')
							{*/
								//$value='B.status';
						/*	}*/
							$this->db->or_like($value,$requestData['search']['value'],'both');
						/*}*/
					}
					$i++;
				}
			  	if($this->session->userdata('admin_level')==2)
				{
					$this->db->having('A.instituteId',$this->session->userdata('instituteId'));
					//$this->db->having('A.userId',$this->session->userdata('admin_id'));
					$this->db->having('A.addedBy',2);
				}
				/*if($this->session->userdata('admin_level') == 4)
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
								$qry.='A.instituteId='.$value.' OR ';
							}
							else
							{
								$qry.='A.instituteId='.$value;
							}
							$i++;
						}
					}
					$this->db->having($qry,null, false);
				}*/
			}
			else
			{
				if($this->session->userdata('admin_level')==2)
				{
					$this->db->where('A.instituteId',$this->session->userdata('instituteId'));
					//$this->db->where('A.userId',$this->session->userdata('admin_id'));
					$this->db->where('A.addedBy',2);
				}
				/*if($this->session->userdata('admin_level')==4)
				{
					$this->db->where_in('A.instituteId',$ins);
					//$this->db->where('A.userId',$this->session->userdata('admin_id'));
					//$this->db->where('A.addedBy',2);
				}*/
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



	public function getAutocompleteInstituteData()
	{
		$rs=array();
		$this->db->select('id,instituteName,instituteLogo,address',FALSE)->from('institute_master');
		$this->db->where('status',1);
		$data=$this->db->get()->result_array();
		if(!empty($data)){
			foreach($data as $val){
				$tmp['label'] 	= $val['instituteName'];
				$tmp['desc'] 	= $val['address'];
				$tmp['icon'] 	= file_upload_base_url().'institute/instituteLogo/thumbs/'.$val['instituteLogo'];
				$tmp['userId'] 	= $val['id'];
				$rs[] 			= $tmp;
			}
		}
		return json_encode($rs);
	}

	public function getAllCountry()
	{
		return $this->db->select('*')->from('country')->get()->result_array();
	}

	public function getAllCities($country)
	{
		return $this->db->select('id,name')->from('city')->where('countryId',$country)->get()->result_array();
	}

	public function deleteOldRankTitle($competitionId)
	{
		$this->db->where('competitionId', $competitionId);
		$this->db->delete('creative_competition_rank_title');
	}

	public function insertRankTitle($rankData)
	{
		$this->db->insert('creative_competition_rank_title', $rankData);
	}

	public function getAllRankTitle($competitionId)
	{
		return $this->db->select('rankTitle')->from('creative_competition_rank_title')->where('competitionId',$competitionId)->get()->result_array();
	}

	public function getEditFormData($competitionId)
	{
		$data = $this->db->select('A.*')->from('creative_mind_competition as A')->where('A.id',$competitionId)->get()->row_array();

		if(!empty($data))
		{
			if($data['instituteId']!=0)
			{
				$det = $this->db->select('A.*')->from('institute_master as A')->where('A.id',$data['instituteId'])->get()->row_array();
				if(!empty($det))
				{
					$data['institute_name'] = $det['instituteName'];
				}
				else
				{
					$data['institute_name'] = '';
				}
			}
			else
			{
				$data['institute_name'] = '';
			}
		}

		return $data;
	}

	public function declareWinners($competitionId,$numberOfWinner)
	{
		$this->db->select('creative_competition_project_avg_rating.*,project_master.like_cnt,project_master.view_cnt');
		$this->db->from('creative_competition_project_avg_rating');
		$this->db->join('project_master','project_master.id=creative_competition_project_avg_rating.projectId');
		$this->db->where('creative_competition_project_avg_rating.creative_competition_id',$competitionId);
		$this->db->order_by('creative_competition_project_avg_rating.avgRating','desc');
		$this->db->order_by('project_master.like_cnt','desc');
		$this->db->order_by('project_master.view_cnt','desc');
		$this->db->limit($numberOfWinner);
		$array = $this->db->get()->result_array();
		return $data[0] = $array;
	}

	public function declareWinnersCategorywise($competitionId,$numberOfWinner)
	{		
		$getProjectCategory = 	array('27','38','39','40','41','42','43','44');
		$array = array();
		$i=0;
		foreach ($getProjectCategory as $value) {
			$this->db->select('creative_competition_project_avg_rating.*,project_master.like_cnt,project_master.view_cnt');
			$this->db->from('creative_competition_project_avg_rating');
			$this->db->join('project_master','project_master.id=creative_competition_project_avg_rating.projectId');
			$this->db->where('creative_competition_project_avg_rating.creative_competition_id',$competitionId);
			$this->db->where('creative_competition_project_avg_rating.project_category',$value);
			$this->db->order_by('creative_competition_project_avg_rating.avgRating','desc');
			$this->db->order_by('project_master.like_cnt','desc');
			$this->db->order_by('project_master.view_cnt','desc');
			$this->db->limit($numberOfWinner);
			$array = $this->db->get()->result_array();	
			$data[$i] = $array;
			$i++;
		}	
		return $data;		
	}

	public function getWinnerDetail($competitionId,$projectId)
	{
		$this->db->select('A.rank,C.firstName,C.lastName,C.email,D.name,D.userId as competitionAddedBy,D.profile_image as competitionLogo,D.contactEmail,D.winnerEmail');
		$this->db->from('creative_mind_competition_winning_projects as A');
		$this->db->where('A.competitionId',$competitionId);
		$this->db->where('A.projectId',$projectId);
		$this->db->join('project_master as B','A.projectId=B.id');
		$this->db->join('users as C','B.userId=C.id');
		$this->db->join('creative_mind_competition as D','A.competitionId=D.id');
		return $this->db->get()->result_array();
	}

	public function get_project_jury_ratings($projectId,$competitionId)
	{
		$this->db->select('*');
		$this->db->from('project_jury_rating');
		$this->db->where('competitionId',$competitionId);
		$this->db->where('projectId',$projectId);
		return $this->db->get()->result_array();
	}

	public function deleteOldJury($competitionId)
	{
		$this->db->where('competitionId', $competitionId);
		$this->db->delete('creative_competition_jury_relation');
	}
}