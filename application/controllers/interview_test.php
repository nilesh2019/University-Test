<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Interview_test extends MY_Controller
{	
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('model_basic');    
    	$this->load->model('interview_test_model'); 
	}
	public function index()
	{
		$user_id=$this->session->userdata('front_user_id');	
		$getAllUserAssignment= $this->interview_test_model->getAllUserInterviewAssignment($user_id);
		if(!empty($getAllUserAssignment))
		{
			$data['assigned']=array();
			$data['pending']=array();
			$data['resubmitted']=array();
			$data['submitted']=array();
			$data['accepted']=array();
			foreach($getAllUserAssignment as $assignment)
			{
				$assignmentStaus=$this->model_basic->getValueArray('project_master','assignment_status',array('userId'=>$user_id,'assignmentId'=>$assignment['id']));
				if($assignmentStaus==1)
				{
					$data['submitted'][]=$assignment;
				}
				elseif($assignmentStaus==2)
				{
					$data['pending'][]=$assignment;
				}
				elseif($assignmentStaus==3)
				{
					$data['accepted'][]=$assignment;
				}
				elseif($assignmentStaus==4)
				{
					$data['resubmitted'][]=$assignment;
				}
				else
				{
					$data['assigned'][]=$assignment;
				}
			}
		}
		else
		{
			$data=array();
		}

		//print_r($data);die;
		$this->load->view('interview_test_view',$data);
	}


	public function interview_test_detail($interview_assignment_id,$userId='',$sub_assig='')
	{
		$data['assignment']=$this->interview_test_model->edit_interviewtest_data($interview_assignment_id);
		$data['teacher']=$this->model_basic->getAllData('users','id,instituteId,firstName,lastName,email,profileImage',array('id'=>$data['assignment'][0]['employer_id']));
		$data['project']=$this->interview_test_model->getAllInterviewAssignmentData($interview_assignment_id,'',$this->session->userdata('front_user_id'));	
		$data['my_project']=$this->interview_test_model->getAllInterviewAssignmentData($interview_assignment_id,$this->session->userdata('front_user_id'));
		if($sub_assig != '')
		{
			$data['sub_assig']=$sub_assig;
		}
		$data['tools']=$this->db->select('A.*,B.attributeValue')->from('assignment_tools_relation as A')->join('attribute_value_master as B','B.id = A.attribute_tools_id')->where('A.interview_assignment_id',$interview_assignment_id)->get()->result_array();
		$data['features']=$this->db->select('A.*,B.attributeValue')->from('assignment_features_relation as A')->join('attribute_value_master as B','B.id = A.attribute_features_id')->where('A.interview_assignment_id',$interview_assignment_id)->get()->result_array();
		$this->load->view('single_interview_test_view',$data);		
	}
}