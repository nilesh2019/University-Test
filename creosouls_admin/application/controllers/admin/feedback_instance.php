<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



/*

*	@author : Santosh Badal

*	date	: 05 August, 2015

*	http://unichronic.com

*	Unichronic - Master Admin

*/

class Feedback_instance extends MY_Controller

{

	function __construct()

	{

	    	parent::__construct();

	    	$this->load->library('form_validation');



	    	$this->load->model('modelbasic');

	    	$this->load->model('admin/feedback_instance_model');

	}



	public function get($id)

	{

		$data['instituteID']=base64_decode(urldecode($id));

		//pr($data);die;

		$this->load->view('admin/feedback/manage_feedback',$data);

	}



	public function index()

	{

		$this->load->view('admin/feedback/manage_feedback');

	}



	function get_ajaxdataObjects($instituteID='')

	{

		$_POST['columns']='name';

		$requestData= $_REQUEST;

		//print_r($requestData);die;

		$columns=explode(',',$_POST['columns']);



		$selectColumns="id,name,start_session,end_session,status";

		//print_r($columns);die;

		//get total number of data without any condition and search term

		//$conditionArray=array('institute_id'=>$instituteID,'status'=>1);

		$conditionArray=array('institute_id'=>$this->session->userdata('instituteId'));

		$totalData=$this->feedback_instance_model->count_all_only('feedback_instance',$conditionArray);

		$totalFiltered=$totalData;



		//pass concatColumns only if you want search field to be fetch from concat



			$result=$this->feedback_instance_model->run_query('feedback_instance',$requestData,$columns,$selectColumns,$conditionArray);

			//print_r($result);die;

			if( !empty($requestData['search']['value']) )

			{

				$totalFiltered=count($result);

			}

			$data = array();



			if(!empty($result))

			{

				$i=1;

				foreach ($result as $row)

				{

					$nestedData=array();

					$nestedData['chk'] = '<input type="checkbox" class="case" onchange="checkValues();" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';

					if($row["name"] <> ' ')

					{

						$nestedData['name'] = ucwords($row["name"]);

					}



					if($row["start_session"] <> ' ')

					{

						$nestedData['start_session'] = ucwords($row["start_session"]);

					}

					if($row["end_session"] <> ' ')

					{

						$nestedData['end_session'] = ucwords($row["end_session"]);

					}

					if($row['status']==1){ $text="<span class='text-success'>Active</span>";}else{ $text="<span class='text-danger'>Deactive</span>";}

					if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';}else{ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}

					$nestedData['action'] = '<a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a><a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a>';

					$nestedData['id'] =$i+$requestData['start'];



					$data[] = $nestedData;

					$i++;

				}

			}



			$json_data = array(

					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.

					"recordsTotal"    => intval( $totalData ),  // total number of records

					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData

					"data"            => $data   // total data array

					);

			echo json_encode($json_data);

	}



	function setFlashdata($function)

	{

		if($function == 'add')

		{

			$this->session->set_flashdata('success','Feedback instance created successfully.');

			redirect(base_url().'admin/feedback_instance/');

		}

		else

		{

			$this->session->set_flashdata('success','Feedback instance updated successfully.');

			redirect(base_url().'admin/feedback_instance/');

		}

	}

	function multiselect_action()

	{

		if(isset($_POST['submit'])){



			$check = $_POST['checkall'];



			//echo "<pre>";print_r($_POST);die;



			foreach ($check as $key => $value) {



				if($_POST['listaction'] == '1'){



					$status = array('status'=>1);

					$this->modelbasic->_update('feedback_instance',$key,$status);



					$this->session->set_flashdata('success', 'Feedback instances activated successfully');





				}else if($_POST['listaction'] == '2'){



					$status = array('status'=>0);

					$this->modelbasic->_update('feedback_instance',$key,$status);

					$this->session->set_flashdata('success', 'Feedback instances deactivated successfully');



				}else

				if($_POST['listaction'] == '3')

				{

				      $this->modelbasic->_delete('feedback_instance',$key);

				      $this->session->set_flashdata('success', 'Feedback instances deleted successfully');

				}



			}



			redirect('admin/feedback_instance');

		}

	}



	public function processForm()

	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('sessionName', 'Session name', 'required');

		$this->form_validation->set_rules('sessionStartDate', 'Session start date', 'required');

		$this->form_validation->set_rules('sessionEndDate', 'Session End date', 'required');

		if ($this->form_validation->run())

		{

			$startDate = date("Y-m-d",strtotime($this->input->post('sessionStartDate',TRUE)));

			$endDate = date("Y-m-d",strtotime($this->input->post('sessionEndDate',TRUE)));

			if($this->input->post('feedbackInstanceId',TRUE) > 0)

			{

				$feedbackInstanceId=$this->input->post('feedbackInstanceId',TRUE);
				$data=array('name'=>$this->input->post('sessionName',TRUE),
					'start_session'=>$startDate,
					'end_session'=>$endDate);
				$res=$this->feedback_instance_model->_update('feedback_instance',$feedbackInstanceId,$data);
				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'feedback instance updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating feedback instance please try again....');
				}
			}
			else
			{
				date_default_timezone_set('Asia/Kolkata');
				$data=array('institute_id'=>$this->session->userdata('instituteId'),
					'name'=>$this->input->post('sessionName',TRUE),
					'start_session'=>$startDate,
					'end_session'=>$endDate,
					'created'=>date('Y-m-d H:i:s'));
				$instanceId=$this->feedback_instance_model->_insert('feedback_instance',$data);
				$allUser = $this->feedback_instance_model->getAllInstituteUser($this->session->userdata('instituteId'));
				foreach ($allUser as $val) {
					$data = array('institute_id'=>$this->session->userdata('instituteId'),
									              		'instance_id'=>$instanceId,
									              		'user_id'=>$val['id'],
									              		'created'=>date("Y-m-d H:i:s")
									              );
					$emailInstanceNotification =array(
					                                  'to'=>$val['email'],
					                                  'subject'=>'New feedback instance created by your institute.',
					                                  'template'=>'New feedback instance created by your institute. You can give your feedback in between following time duration : '.$this->input->post('sessionStartDate',TRUE).' TO '.$this->input->post('sessionEndDate',TRUE).'',
					                                  'fromEmail'=>$this->session->userdata('admin_email'));
					//$this->modelbasic->sendMail($emailInstanceNotification);
					$this->feedback_instance_model->_insert('feedback_instance_notification',$data);
				}
				if($instanceId > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'feedback instance added successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while creating feedback instance please try again....');
				}
			}
			echo json_encode($data);
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo $this->form_validation->get_json();
			}
			else
			{
				$this->load->view('admin/feedback/addedit_view');
			}
		}
	}





	public function delete_confirm($feedbackInstanceId)

	{



		  $res = $this->modelbasic->_delete('feedback_instance',$feedbackInstanceId);



		  if($res)

		  {

		  	$this->session->set_flashdata('success', 'Feedback instance deleted successfully');

	      }

		  else

		  {

		  	$this->session->set_flashdata('fail', 'Fail to delete Feedback instance');

		  }

		  redirect('admin/feedback_instance');

 	}



	function change_status($id = NULL)

	{

		$result = $this->modelbasic->getValue('feedback_instance','status','id',$id);

		if($result == 1)

		{

			$data = array('status'=>'0');

			if($id != 1)

			{

				$this->session->set_flashdata('success', 'Feedback instance deactivated successfully.');

			}

		}

		else if($result == 0)

		{



			$data = array('status'=>'1');

			$this->session->set_flashdata('success', 'Feedback instance activated successfully.');



		}

		$this->modelbasic->_update('feedback_instance',$id, $data);

		redirect('admin/feedback_instance');

	}



	function getEditFormData()

	{

		$feedbackInstanceId=$this->input->post('feedbackInstanceId',true);

		$data=$this->feedback_instance_model->getEditFormData($feedbackInstanceId);

		$data['sessionStartDate']=date("m/d/Y",strtotime($data['sessionStartDate']));

		$data['sessionEndDate']=date("m/d/Y",strtotime($data['sessionEndDate']));

		echo json_encode($data);

	}



}

