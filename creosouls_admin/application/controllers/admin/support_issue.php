<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Support_issue extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')!=1)
	    {
			redirect(base_url());
		}
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/support_issue_model');
	}

	public function index()
	{
		$this->load->view('admin/support_issue/manage_support_issue');
	}

	function get_ajaxdataObjects($institute='')
	{
		$_POST['columns']='id, categorytype, ins_name, fullname, studentId, contactNo, email, coursename, receiptno, reference_no, start_date, end_date, status,created';
		$requestData= $_REQUEST;
		$columns=explode(',',$_POST['columns']);
		$selectColumns="id, categorytype, ins_name, fullname, studentId, contactNo, email, coursename, receiptno, reference_no, start_date, end_date, status,created";
		$totalData=$this->support_issue_model->count_all_only('table_support_issue');
		$totalFiltered=$totalData;		
		$result=$this->support_issue_model->run_query('table_support_issue',$requestData,$columns,$selectColumns,'','',$institute);
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
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] =$i+$requestData['start'];
					if($row["fullname"] <> ' ')
					{
						$nestedData['name'] = ucwords($row["fullname"]);
					}
					else
					{
						$nestedData['name'] = ucwords('No Name');
					}
					$nestedData['categorytype'] = $row["categorytype"];
					$nestedData['ins_name'] = $row["ins_name"];
					$nestedData['contactNo'] = $row["contactNo"].'<br/>'.$row["email"];
					$nestedData['studentId'] = $row["studentId"];
					$nestedData['student_date'] = 'Start Date : '.$row["start_date"].'<br>End Date : '.$row['end_date'];
					$nestedData['reference_no'] = $row["reference_no"];
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));					
						if($row['status']==1)
						{
							$nestedData['status']='<span class="label label-success" style="cursor: pointer;">User error -CLOSED</span>';
						}
						else if($row['status']==2)
						{
							$nestedData['status']='<span class="label label-success" style="cursor: pointer;">BUG - CLOSED</span>';
						}
						else if($row['status']==3)
						{
							$nestedData['status']='<span class="label label-success" style="cursor: pointer;">Requested- OPERATION WAITING</span>';
						}
						else
						{
							$nestedData['status']='<span class="label label-danger" style="cursor: pointer;">Open</span>';
						}
						

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

	function multiselect_action()
	{
		if(isset($_POST['submit']))
		{
			$check = $_POST['checkall']; 
			foreach ($check as $key => $value) 
			{
				if($_POST['listaction'] == '1')
				{
					$status = array('status'=>1); 
					$this->modelbasic->_update('table_support_issue',$key,$status); 
					$this->session->set_flashdata('success', 'Support Issue User error -CLOSED'); 
				} 
				else if($_POST['listaction'] == '2') 
				{
					$status = array('status'=>2); 
					$this->modelbasic->_update('table_support_issue',$key,$status); 
					$this->session->set_flashdata('success', 'Support Issue BUG - CLOSED'); 
				} 
				else if($_POST['listaction'] == '3')
				{
					$status = array('status'=>3); 
					$this->modelbasic->_update('table_support_issue',$key,$status); 
					$this->session->set_flashdata('success', 'Support Issue Requested- OPERATION WAITING'); 
				} 
			} 
			redirect('admin/support_issue'); 
		}
	}
}