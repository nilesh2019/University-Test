<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Update_competition extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelbasic');
	}
	public function markCompletedCompetions()
	{
		//echo "sayali";die;
		$this->db->select('*');
		$this->db->from('competitions');
	   	$det = $this->db->get()->result_array();
	   	//print_r($det);die;
		foreach($det as $val)
		{
			$todayDate=date('Y-m-d');
			$evaluationEndDate=$val['evaluation_end_date'];
			$evaluationStartDate=$val['evaluation_start_date'];
			$endDate=$val['end_date'];
			$startDate=$val['start_date'];
			$checkWinnerEntry=$this->modelbasic->get_update_comp_value('competition_winning_projects','projectId'," `competitionId` = '".$val['id']."'");
			//echo $todayDate;die;
			//
			//echo $checkWinnerEntry;die;
			if($startDate > $todayDate)
			{
				$this->db->where('id',$val['id']);
				$this->db->update('competitions',array('status'=>0));
			}
			else
			{
				if($todayDate > $evaluationEndDate && $checkWinnerEntry > 0)
				{
					$this->db->where('id',$val['id']);
					$this->db->update('competitions',array('status'=>4));
				}
				else
				{
					if($todayDate > $evaluationEndDate && $checkWinnerEntry == '')
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>3));
					}
					elseif($todayDate >=$evaluationStartDate && $todayDate <=$evaluationEndDate)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>2));
					}
					elseif($todayDate >=$startDate && $todayDate <=$endDate)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>1));
					}
					else
					{
						$this->db->where('id',$val['id']);
						$this->db->update('competitions',array('status'=>5));
					}
				}
			}
		}
    }



public function markCompletedCreativeCompetions()
	{
		//echo "sayali";die;
		$this->db->select('*');
		$this->db->from('creative_mind_competition');
	   	$det = $this->db->get()->result_array();
	   	//print_r($det);die;
		foreach($det as $val)
		{
			$todayDate=date('Y-m-d');
			$evaluationEndDate=$val['evaluation_end_date'];
			$evaluationStartDate=$val['evaluation_start_date'];
			$endDate=$val['end_date'];
			$startDate=$val['start_date'];
			$checkWinnerEntry=$this->modelbasic->get_update_comp_value('creative_mind_competition_winning_projects','projectId'," `competitionId` = '".$val['id']."'");
			//echo $todayDate;die;
			//
			//echo $checkWinnerEntry;die;
			if($startDate > $todayDate)
			{
				$this->db->where('id',$val['id']);
				$this->db->update('creative_mind_competition',array('status'=>0));
			}
			else
			{
				if($todayDate > $evaluationEndDate && $checkWinnerEntry > 0)
				{
					$this->db->where('id',$val['id']);
					$this->db->update('creative_mind_competition',array('status'=>4));
				}
				else
				{
					if($todayDate > $evaluationEndDate && $checkWinnerEntry == '')
					{
						$this->db->where('id',$val['id']);
						$this->db->update('creative_mind_competition',array('status'=>3));
					}
					elseif($todayDate >=$evaluationStartDate && $todayDate <=$evaluationEndDate)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('creative_mind_competition',array('status'=>2));
					}
					elseif($todayDate >=$startDate && $todayDate <=$endDate)
					{
						$this->db->where('id',$val['id']);
						$this->db->update('creative_mind_competition',array('status'=>1));
					}
					else
					{
						$this->db->where('id',$val['id']);
						$this->db->update('creative_mind_competition',array('status'=>5));
					}
				}
			}
		}
    }


}
	