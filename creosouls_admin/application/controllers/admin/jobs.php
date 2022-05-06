<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/

class Jobs extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('json');
		$this->load->model('admin/job_model');
		$this->load->model('modelbasic');
	}

	public function index()
	{
		$this->load->view('admin/jobs/manage_jobs');
	}

	function get_ajaxdataObjects($featured_job='')
	{
		$_POST['columns'] = 'A.id,A.title,A.location,A.type,A.close_on,A.created,A.status,A.description,A.no_of_position,A.job_type1';
		$requestData   = $_REQUEST;
		//print_r($requestData);die;
		$columns       = explode(',',$_POST['columns']);
		$selectColumns = 'A.id,A.title,A.location,A.type,A.close_on,A.created,A.status,A.description,A.posted_by,B.job_id,B.region_id,B.zone_id,A.featured,A.no_of_position,A.job_type1';


		/*$_POST['columns'] = 'id,title,location,type,close_on,created,status,description';
		$requestData   = $_REQUEST;
		//print_r($requestData);die;
		$columns       = explode(',',$_POST['columns']);
		$selectColumns = 'id,title,location,type,close_on,created,status,description,posted_by';*/



		//print_r($columns);die;
		//get total number of data without any condition and search term
		if($this->session->userdata('admin_level')==2)
		{
			if($featured_job!='' && $featured_job==1)
			{				
				$totalData     = $this->job_model->count_all_only('jobs',array('posted_by'=>$this->session->userdata('instituteId'),'featured'=>1),'AND');				
			}
			else
			{
				$totalData     = $this->job_model->count_all_only('jobs',array('posted_by'=>$this->session->userdata('instituteId')),'AND');
			}
		
		}
		elseif($this->session->userdata('admin_level')==4)
		{
			if($featured_job!='' && $featured_job==1)
			{				
				$totalData     = $this->job_model->count_all_only1('jobs',array('featured'=>1),'AND');				
			}
			else
			{
				$totalData     = $this->job_model->count_all_only1('jobs',array(),'AND');
			}		
		
		}
		else if($this->session->userdata('admin_level')==3)
		{
			if($featured_job!='' && $featured_job==1)
			{				
				$totalData     = $this->job_model->count_all_only('jobs',array('posted_by'=>$this->session->userdata('admin_id'),'featured'=>1),'AND');			
			}
			else
			{
				$totalData     = $this->job_model->count_all_only('jobs',array('posted_by'=>$this->session->userdata('admin_id')),'AND');
			}			
		}		
		else{
			if($featured_job!='' && $featured_job==1)
			{				
				$totalData     = $this->job_model->count_all_only('jobs',array('featured'=>1),'AND');	
			}
			else
			{
				$totalData     = $this->job_model->count_all_only('jobs','','AND');
			}			
		}				
		$totalFiltered = $totalData;


		if($featured_job!='' && $featured_job==1)
		{
			$result=$this->job_model->run_query('jobs',$requestData,$columns,$selectColumns,'','',$featured_job);		

		}
		else
		{			
			$result  = $this->job_model->run_query('jobs',$requestData,$columns,$selectColumns);	
		}

		//print_r($result);die;
		if( !empty($requestData['search']['value']) ){
			$totalFiltered = count($result);
		}
		$data = array();

		if(!empty($result)){
			$i = 1;
			foreach($result as $row)
			{
				$nestedData=array();

				$jobs_users_rel = $this->job_model->get_users_with_status($row['id']);

				$html='';
				$det = $jobs_users_rel->result_array();
				//print_r($det);die;
				if(!empty($det))
				{
					$j=1;
					foreach($det as $dt)
					{
						$date = date_create($dt['apply_date']);
						$html.='<tr>
								<td>'.$j.'</td>'.
			                    '<td><a href="'.front_base_url().'user/userDetail/'.$dt['uId'].'" target="_blank">'.$dt['firstName'].' '.$dt['lastName'].'</a></td>'.
			                	'<td>'.$dt['email'].'</td>'.
			                	'<td>'.date_format($date,"d M Y H:i A").'</td>';
			            if($dt['apply_status']==1)
			            {
							$html .= '<td style="text-align: center"><span class="label label-success">Applied</span></td>';
						}
						else if($dt['apply_status']==2){
							$html .= '<td style="text-align: center"><span class="label label-success">Shortlisted</span></td>';
						}
						else if($dt['apply_status']==3){
							$html .= '<td style="text-align: center"><span class="label label-success">Selected</span></td>';
						}
						else if($dt['apply_status']==4){
							$html .= '<td style="text-align: center"><span class="label label-success">Accepted</span></td>';
						}
						else if($dt['apply_status']==5){
							$html .= '<td style="text-align: center"><span class="label label-danger">Rejected by User</span></td>';
						}
						else if($dt['apply_status']==11)
						{
							$html .= '<td style="text-align: center"><span class="label label-success">Admin Approved The Job and Waiting for RAH Approval</span></td>';
						}
						else if($dt['apply_status']==13)
						{
							$html .= '<td style="text-align: center"><span class="label label-success">RAH Approved The Job and Waiting for RPH Approval</span></td>';
						}
						else if($dt['apply_status']==14)
						{
							$html .= '<td style="text-align: center"><span class="label label-danger">Application Rejected By RAH</span></td>';
						}
						else if($dt['apply_status']==15)
						{
							$html .= '<td style="text-align: center"><span class="label label-success">RPH Approved The Job and Waiting for Employer Approval</span></td>';
						}
						else if($dt['apply_status']==16)
						{
							$html .= '<td style="text-align: center"><span class="label label-danger">Application Rejected By RPH</span></td>';
						}
						else if($dt['apply_status']==18)
						{
							$html .= '<td style="text-align: center"><span class="label label-success">Test Assign</span></td>';
						}
						else if($dt['apply_status']==19)
						{
							$html .= '<td style="text-align: center"><span class="label label-success" style="cursor:pointer;" onclick="check_interview_test('.$dt['userId'].','.$dt['jobId'].')">Test Submited</span></td>';
						}
						else {
							$html .= '<td style="text-align: center"><span class="label label-danger">Rejected by Employer</span></td>';
						}
						
			           if($dt['apply_status']==19)
			           {
			           		$html .= '<td style="text-align: center"><span class="label label-success" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',3)">Select</span>&nbsp;&nbsp;<span class="label label-danger" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',6)" >Reject</span>&nbsp;</td>';
			           }
			           else if($dt['apply_status']==15)
			            {
							$html .= '<td style="text-align: center"><span class="label label-success" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',2)" >Shortlist</span>&nbsp;&nbsp;<span class="label label-danger" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',6)" >Reject</span>&nbsp;</td>';
						}
						else if($dt['apply_status']==2){
							$html .= '<td style="text-align: center"><span class="label label-success" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',4)">Assign Test</span>&nbsp;&nbsp;<span class="label label-success" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',3)">Select</span>&nbsp;&nbsp;<span class="label label-danger" style="cursor:pointer;" onclick="user_job_change_status('.$dt['id'].',6)" >Reject</span>&nbsp;</td>';
						}
						else if($dt['apply_status']==3){
							$html .= '<td style="text-align: center">-</td>';
						}
						else if($dt['apply_status']==4){
							$html .= '<td style="text-align: center">-</td>';
						}
						
						else if($dt['apply_status']==5){
							$html .= '<td style="text-align: center">-</td>';
						}
						else{
							$html .= '<td style="text-align: center">-</td>';
						}
						
			            $html .='</tr>';
			            $j++;
					}
				}

				$nestedData['job_users']=$html;
				//$nestedData = array();
				$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
				$nestedData['id'] = $i + $requestData['start'];
				$nestedData['jobid'] = $row["id"];
				$nestedData['title'] = $row["title"];
				$nestedData['description'] = $row["description"];
				$nestedData['location'] = $row["location"];
				$nestedData['type'] = $row["type"];
				$nestedData['job_type1'] = (!empty($row["job_type1"]) && $row["job_type1"]==1)?'Internship':'Job';
				$nestedData['no_of_position'] = $row["no_of_position"];
				$nestedData['close_on'] = date("d-M-Y", strtotime($row["close_on"]));
				$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));

				if($row["status"] == 1)
				{
					$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';
				}
				else
				{
					$nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';
				}

			/*	if($this->session->userdata('admin_level') !=4)
				{*/
				$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="delete" onclick="delete_job('.$row['id'].')"> <i class="fa fa-times"></i></a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="Export Users" onclick="export_job_users('.$row['id'].')"> <i class="fa fa-download"></i> </a>';
				/*}else
				{
				$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="delete" onclick="delete_job('.$row['id'].')"> <i class="fa fa-times"></i></a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="Export Users" onclick="export_job_users('.$row['id'].')"> <i class="fa fa-download"></i> </a>';
				}*/

				$data[] = $nestedData;
				$i++;
			}
		}

		$json_data = array(
			"draw"           => intval( $requestData['draw'] ),// for every request / draw by clientside , they send a number as a parameter, when they recieve a response / data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"=> intval( $totalData ),// total number of records
			"recordsFiltered"=> intval( $totalFiltered ),// total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"=> $data   // total data array

		);
		echo json_encode($json_data);
	}

	function reorderRows()
	{
		$startPosition = $_POST['sPosition'];
		$endPosition   = $_POST['ePosition'];

		if($startPosition > $endPosition){
			$this->job_model->_update_custom('employee','order',$startPosition,array('order'=>0));
			$result = $this->job_model->getAllWhere('employee','order',array('order >='=>$endPosition),'order','desc');
			foreach($result as $value){
				$this->job_model->_update_custom('employee','order',$value['order'],array('order'=>$value['order'] + 1));
			}
			$this->job_model->_update_custom('employee','order',0,array('order'=>$endPosition));
		}
		else
		{
			$this->job_model->_update_custom('employee','order',$startPosition,array('order'=>0));
			$result = $this->job_model->getAllWhere('employee','order',array('order >' =>$startPosition,'order <='=> $endPosition),'order','asc');

			foreach($result as $value){
				$this->job_model->_update_custom('employee','order',$value['order'],array('order'=>$value['order'] - 1));
			}
			$this->job_model->_update_custom('employee','order',0,array('order'=>$endPosition));
		}
		echo 'true';
	}

	function multiselect_action()
	{
		//print_r($_POST);die;
		if(isset($_POST['submit']))
		{

			$check = $_POST['checkall'];
			//echo " < pre > ";print_r($_POST);die;
			foreach($check as $key => $value)
			{
				if($_POST['listaction'] == '1')
				{
					$status = array('status'=>'1');
					$this->job_model->_update('jobs',$key,$status);
					$this->session->set_flashdata('success', 'Jobs\'s activated successfully');
				}
				elseif($_POST['listaction'] == '2')
				{
					if($key != 1)
					{
						$status = array('status'=>'0');
						$this->job_model->_update('jobs',$key,$status);
						$this->session->set_flashdata('success', 'Jobs\'s deactivated successfully');
					}
				}
				elseif($_POST['listaction'] == '3'){
					$query = $this->job_model->getValue('jobs','companyLogo','id',$key);
					//print_r($query);die;
					$path2 = file_upload_s3_path().'companyLogos/';
					$path3 = file_upload_s3_path().'companyLogos/thumbs/';

					//echo($query);
					if(!empty($query)){
						//echo( $path2 . $query);die;
						unlink( $path2 . $query);
						unlink( $path3 . $query);
					}
					$this->job_model->_delete('jobs',$key);
					$deletJobZoneRel = $this->modelbasic->_delete_with_condition('job_zone_relation','job_id',$Key);
					$this->session->set_flashdata('success', 'Jobs\'s deleted successfully');
				}
				else if($_POST['listaction'] == '4')
				{
					$currentdate=date('Y-m-d');
					$status = array('featured'=>'1','featured_date'=>$currentdate);
					$this->modelbasic->_update('jobs',$key,$status);
     				$this->session->set_flashdata('success', 'Jobs\'s successfully make featured');
				}
				else if($_POST['listaction'] == '5')
				{
					$status = array('featured'=>'0');
					$this->modelbasic->_update('jobs',$key,$status);
     				$this->session->set_flashdata('success', 'Jobs\'s successfully make Unfeatured');
				}

			}
			redirect('admin/jobs');
		}
	}

	function change_status($id = NULL)
	{
		$result = $this->job_model->getValue('jobs','status','id',$id);
		if($result == 1){
			$data = array('status'=>'0');
			if($id != 1){
				$this->session->set_flashdata('success', 'Job deactivated successfully.');
			}
		}
		else
		if($result == 0){
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Job activated successfully.');
		}
		$this->job_model->_update('jobs',$id, $data);
		redirect('admin/jobs');
	}

	function getModelInfo()
	{
		$result = $this->job_model->getValue('job_user_relation','apply_status','id',$_POST['jobUserRelationId']);	
		$data = $this->job_model->select_all('job_user_relation',array('id'=>$_POST['jobUserRelationId']));
		if(!empty($data))
		{
			$jobs = $this->job_model->select_all('jobs',array('id'=>$data[0]['jobId']));
			$users = $this->job_model->select_all('users',array('id'=>$data[0]['userId']));			
			$vlaData['nameTo'] = ucwords($users[0]['firstName'].' '.$users[0]['lastName']);
			$vlaData['jobTitle'] = $jobs[0]['title'];
			$vlaData['jobId'] = $jobs[0]['id'];
			$vlaData['companyName'] = $this->modelbasic->getValueArray('jobs','companyName',array('id'=>$jobs[0]['id']));
			$vlaData['status'] = $result;
			echo json_encode($vlaData);
		}
	}
	
	function change_candidate_status($jobUserRelationId = NULL,$status=NULL)
	{		
		$jobUserRelationId = $_POST['jobUserRelationId'];
		$status = $_POST['status'];
		$additionalMsg = $_POST['additionalMsg'];
		$result = $this->job_model->getValue('job_user_relation','apply_status','id',$jobUserRelationId);
		$data='';
		$get_employer_data=$this->modelbasic->getData('users','firstName,lastName,email',array('id'=>$this->session->userdata('admin_id')));
		/*if($result == 1||$result == 2)
		{*/
			$data = $this->job_model->select_all('job_user_relation',array('id'=>$jobUserRelationId));
			
			if(!empty($data))
			{
				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$jobs = $this->job_model->select_all('jobs',array('id'=>$data[0]['jobId']));
				$users = $this->job_model->select_all('users',array('id'=>$data[0]['userId']));				
				$emailTo = $users[0]['email'];
				$from = $emailFrom;
				$nameTo = ucwords($users[0]['firstName'].' '.$users[0]['lastName']);
				$jobTitle = $jobs[0]['title'];
				$jobId = $jobs[0]['id'];
				$individual_user=$data[0]['userId'];
			}
		/*}*/

		if($result == 15 && $status==2)
		{
			$data = array('apply_status'=>$status,'shortlist_date'=>date('Y-m-d H:i:s'));
			$subject = 'You have been shortlisted for job';
			$templateJobEmail = $additionalMsg;
			$res=$this->job_model->_update('job_user_relation',$jobUserRelationId, $data);
			$emailJobDetail = array('to'=>$emailTo,'subject'=>$subject,'template'=>$templateJobEmail,'fromEmail'=>$from);
			//$this->job_model->sendMail($emailJobDetail);
			$this->session->set_flashdata('success', 'Candidate shortlisted for job.');
		}
		if(($result == 19 || $result == 2) && $status==3)
		{
			$data = array('apply_status'=>$status,'select_date'=>date('Y-m-d H:i:s'));
			$subject = 'Congratulations! You have been selected for the job';
			$templateJobEmail = $additionalMsg;
			$res=$this->job_model->_update('job_user_relation',$jobUserRelationId, $data);
			$emailJobDetail = array('to'=>$emailTo,'subject'=>$subject,'template'=>$templateJobEmail,'fromEmail'=>$from);
			//$this->job_model->sendMail($emailJobDetail);
			$this->session->set_flashdata('success', 'Candidate selected for the job.');
		}		
		if($status==6)
		{
			$data = array('apply_status'=>$status);
			$subject = 'Update regarding a job you applied for on creosouls';
			$templateJobEmail = $additionalMsg;
			$res=$this->job_model->_update('job_user_relation',$jobUserRelationId, $data);
			$emailJobDetail = array('to'=>$emailTo,'subject'=>$subject,'template'=>$templateJobEmail,'fromEmail'=>$from);
			//$this->job_model->sendMail($emailJobDetail);
			$this->session->set_flashdata('success', 'Candidate rejected.');
		}
		if($status==7)
		{
			$data = array('apply_status'=>6);
			$res=$this->job_model->_update('job_user_relation',$jobUserRelationId, $data);
			$this->session->set_flashdata('success', 'Candidate rejected.');
		}
		if($res)
		{
			
			$notificationEntry=array('title'=>$subject,'msg'=>$subject.' JOB DETAILS - Job added by '.$get_employer_data['firstName'].' '.$get_employer_data['lastName'],'link'=>'job/jobDetail/'.$jobId,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$res);
			$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
			$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user);
			$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);	
			$msg = array (
					'body' 	=> '',
					'title'	=> '',
					'aboutNotification'	=> $subject,
					'notificationTitle'	=> 'Update regarding a job you applied',
					'notificationType'	=> 1,
					'notificationId'	=> $jobId,
					'notificationImageUrl'	=> ''          	
		          );
			$this->modelbasic->sendNotification($individual_user,$msg);
		}
		
		if($this->input->is_ajax_request())
		{
			echo 1;die;
		}
		else
		{
			redirect('admin/jobs');
		}
	}

	function delete_job($id = NULL)
	{
		$query = $this->job_model->getValue('jobs','companyLogo','id',$id);
		$path2 = file_upload_s3_path().'companyLogos/';
		$path3 = file_upload_s3_path().'companyLogos/thumbs/';
		//echo($query);
		if(!empty($query)){
			//echo( $path2 . $query);die;
			unlink( $path2 . $query);
			unlink( $path3 . $query);
		}
		$this->job_model->_delete('jobs',$id);
		$deletJobZoneRel = $this->modelbasic->_delete_with_condition('job_zone_relation','job_id',$Key);
		$this->session->set_flashdata('success', 'Jobs\'s deleted successfully');
		redirect('admin/jobs');
	}

	public function processForm()
	{
		//print_r($_POST);die;		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('title', 'Job Title', 'required');
		$this->form_validation->set_rules('location', 'Job Location', 'required');
		$this->form_validation->set_rules('type', 'Job Type', 'required');
		$this->form_validation->set_rules('job_type', 'Job Type', 'required');
		$this->form_validation->set_rules('close_on', 'Job Close Date', 'required');
		$this->form_validation->set_rules('key_skills', 'Key Skills', 'required');
		$this->form_validation->set_rules('education', 'Education', 'required');
		$this->form_validation->set_rules('recruiter_email_id', 'Recruiter Email Id', 'required');
	
		$this->form_validation->set_rules('industry', 'industry', 'required');
		$this->form_validation->set_rules('min_experience', 'min experience', 'required');
		$this->form_validation->set_rules('max_experience', 'max experience', 'required');
		$this->form_validation->set_rules('no_of_position', 'No of Positions', 'required');
		/*if($this->session->userdata('admin_level')==2)
		{
			$this->form_validation->set_rules('jobStatus', 'jobStatus', 'required');
		}*/
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('description', 'Job Description', 'required|max_length[5000]');
		$this->form_validation->set_rules('logo', 'Company Logo', 'callback_image_upload');
		if($this->form_validation->run()){
			if($this->input->post('jobId',TRUE) > 0){
				$jobId = $this->input->post('jobId',TRUE);
				
				$data = array('title'   =>$this->input->post('title',TRUE),'location'    =>$this->input->post('location',TRUE),'type'        =>$this->input->post('type',TRUE),'close_on'    =>date("Y-m-d", strtotime($this->input->post('close_on',TRUE))),'description' =>$this->input->post('description',TRUE),'keySkills'   =>$this->input->post('key_skills',TRUE),'education'   =>$this->input->post('education',TRUE),'industry'    =>$this->input->post('industry',TRUE),'function'    =>$this->input->post('function',TRUE),'companyName' =>$this->input->post('company_name',TRUE),'aboutCompany'=>$this->input->post('about_company',TRUE),'min_experience' =>$this->input->post('min_experience',TRUE),'recruiter_email_id'=>$this->input->post('recruiter_email_id',TRUE),'max_experience' =>$this->input->post('max_experience',TRUE),'no_of_position' =>$this->input->post('no_of_position',TRUE),'job_type1'=>$this->input->post('job_type',TRUE));

				if(isset($_POST['companyLogo']['file_name']) && $_POST['companyLogo']['file_name'] <> ''){
					$data['companyLogo'] = $_POST['companyLogo']['file_name'];
				}				
				if($this->session->userdata('admin_level')==2)
				{
					$data['view_status'] = $this->input->post('jobStatus',TRUE);
				}
				$res = $this->job_model->_update('jobs',$jobId,$data);
		
				if(isset($_POST['zone']) && !empty($_POST['zone']) )
				{
					$this->modelbasic->_delete_with_condition('job_zone_relation','job_id',$jobId);	
					foreach ($_POST['zone'] as $key => $value) 
					{
						$zoneData = array('job_id'=>$jobId,'zone_id'=>$value);
						$this->modelbasic->_insert('job_zone_relation',$zoneData);
					}
				}
				else if($this->session->userdata('instituteId') !='' && $this->session->userdata('admin_level') == 2)
				{
					if($this->input->post('jobStatus',TRUE) == 1)
					{
						$INSTID = $this->session->userdata('instituteId');
						$getZonlistId = $this->db->select('zone')->from('institute_master')->where('id',$INSTID)->get()->row_array();
						$zoneData = array('job_id'=>$jobId,'zone_id'=>$getZonlistId['zone']);
						$this->modelbasic->_insert('job_zone_relation',$zoneData);
					}
					else 
					{
						$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
						foreach ($getZonlist_ids as $key => $value) 
						{	
							$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
							$this->modelbasic->_insert('job_zone_relation',$zoneData);					
						}							
					}		
				}
				else if($this->session->userdata('admin_level') == 3)
				{
					$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
					foreach ($getZonlist_ids as $key => $value) 
					{	
						$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
						$this->modelbasic->_insert('job_zone_relation',$zoneData);					
					}									
				}

				if(isset($_POST['region']) && !empty($_POST['region']) )
				{			
					foreach ($_POST['region'] as $key => $value) 
					{
						$zoneData = array('job_id'=>$jobId,'region_id'=>$value);
						$this->modelbasic->_insert('job_zone_relation',$zoneData);
					}
				}
			   else if(isset($_POST['zone']) && !empty($_POST['zone']) )
				{
					foreach ($_POST['zone'] as $key => $value) 
					{
						$getZonlist_ids = $this->db->select('id')->from('region_list')->where('zone_id',$value)->get()->result_array();
						if(!empty($getZonlist_ids))
						{
							foreach ($getZonlist_ids as $keys => $values) {
								$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);
								
							}
						}
						
					}
				}
				else
				{
					$getAllZonlist_ids = $this->db->select('id')->from('region_list')->get()->result_array();
					if(!empty($getAllZonlist_ids))
					{
						foreach ($getAllZonlist_ids as $keys => $valu) {
							$zoneData = array('job_id'=>$jobId,'region_id'=>$valu['id']);
							$this->modelbasic->_insert('job_zone_relation',$zoneData);							
						}
					}
				}

				if($res){
					$data = array('status' =>'success','for'    =>'edit','message'=>'Job updated successfully.');
				}
				else
				{
					$data = array('status' =>'fail','message'=>'Error occurred while updating job please try again....');
				}
			}
			else
			{
				$data = array(
					'title'       =>$this->input->post('title',TRUE),
					'location'    =>$this->input->post('location',TRUE),
					'type'        =>$this->input->post('type',TRUE),
					'close_on'    =>date("Y-m-d", strtotime($this->input->post('close_on',TRUE))),
					'keySkills'   =>$this->input->post('key_skills',TRUE),
					'education'   =>$this->input->post('education',TRUE),
					'industry'    =>$this->input->post('industry',TRUE),
					'function'    =>$this->input->post('function',TRUE),
					'companyName' =>$this->input->post('company_name',TRUE),
					'min_experience' =>$this->input->post('min_experience',TRUE),
					'max_experience' =>$this->input->post('max_experience',TRUE),
					'aboutCompany'=>$this->input->post('about_company',TRUE),
					'description' =>$this->input->post('description',TRUE),
					'recruiter_email_id'=>$this->input->post('recruiter_email_id',TRUE),
					'no_of_position'=>$this->input->post('no_of_position',TRUE),
					'created'     =>date('Y-m-d H:i:s'),
					'admin_level'  =>$this->session->userdata('admin_level'),
					'status'      =>1,
					'job_type1'=>$this->input->post('job_type',TRUE)
				);

				if(isset($_POST['companyLogo']['file_name']) && $_POST['companyLogo']['file_name'] <> ''){
					$data['companyLogo'] = $_POST['companyLogo']['file_name'];
				}
				/*if(isset($_POST['region']) && $_POST['region'] != ''){
					$data['region'] = $_POST['region'];
				}
				else if($this->session->userdata('instituteId') !='' && $this->session->userdata('admin_level') == 2)
				{
					$INSTID = $this->session->userdata('instituteId');
					$getRegionlist = $this->db->select('region')->from('institute_master')->where('id',$INSTID)->get()->row_array();
					$data['region'] = $getRegionlist['region'];			
				}*/							
				if($this->session->userdata('admin_level')==2)
				{
					$data['view_status'] = $this->input->post('jobStatus',TRUE);
					$data['posted_by'] = $this->session->userdata('instituteId');
				}
				elseif($this->session->userdata('admin_level')==3)
				{
					$data['posted_by'] = $this->session->userdata('admin_id');
				}
				elseif($this->session->userdata('admin_level')==4)
				{
					$data['view_status'] = $this->input->post('jobStatus',TRUE);
					$data['posted_by'] = $this->session->userdata('admin_id');
				}

				$jobId = $this->job_model->_insert('jobs',$data);

				if($this->session->userdata('admin_level') != 4)
				{

						if(isset($_POST['region']) && !empty($_POST['region']) )
						{
							foreach ($_POST['region'] as $key => $value) 
							{
								$zoneData = array('job_id'=>$jobId,'region_id'=>$value);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);
							}
						}
					   else if(isset($_POST['zone']) && !empty($_POST['zone']) )
						{
							foreach ($_POST['zone'] as $key => $value) 
							{
								$getZonlist_ids = $this->db->select('id')->from('region_list')->where('zone_id',$value)->get()->result_array();
							//	print_r($getZonlist_ids);die;
								if(!empty($getZonlist_ids))
								{
									foreach ($getZonlist_ids as $keys => $values) 
									{
										$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
										$this->modelbasic->_insert('job_zone_relation',$zoneData);
										
									}
								}
								
							}
						}
						else
						{
							if($this->input->post('jobStatus',TRUE) == 0)
							{						
								$getAllZonlist_ids = $this->db->select('id')->from('region_list')->get()->result_array();						
								if(!empty($getAllZonlist_ids))
								{
									foreach ($getAllZonlist_ids as $keys => $valu) {
										$zoneData = array('job_id'=>$jobId,'region_id'=>$valu['id']);
										$this->modelbasic->_insert('job_zone_relation',$zoneData);							
									}
								}
							}
							else
							{
								$INSTID = $this->session->userdata('instituteId');
								$getRegId = $this->db->select('region')->from('institute_master')->where('id',$INSTID)->get()->row_array();
								$zoneData = array('job_id'=>$jobId,'region_id'=>$getRegId['region']);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);
							}
						}
						if(isset($_POST['zone']) && !empty($_POST['zone']) ){
							foreach ($_POST['zone'] as $key => $value) {
								$zoneData = array('job_id'=>$jobId,'zone_id'=>$value);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);
							}
						}
						else if($this->session->userdata('instituteId') !='' && $this->session->userdata('admin_level') == 2)
						{
							if($this->input->post('jobStatus',TRUE) == 1)
							{
								$INSTID = $this->session->userdata('instituteId');
								$getZonlistId = $this->db->select('zone')->from('institute_master')->where('id',$INSTID)->get()->row_array();				
								$zoneData = array('job_id'=>$jobId,'zone_id'=>$getZonlistId['zone']);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);
							}
							else 
							{
								$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
								foreach ($getZonlist_ids as $key => $value) {	
									$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
									$this->modelbasic->_insert('job_zone_relation',$zoneData);					
								}							
							}		
						}
						else if($this->session->userdata('admin_level') == 3)
						{
							$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
							foreach ($getZonlist_ids as $key => $value) {	
								$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);					
							}									
						}

				}
				else
				{
						$region = $this->modelbasic->getInstituteRegions();		
						if(isset($_POST['jobStatus']) && $this->input->post('jobStatus',TRUE) == 0)
						{
							$this->db->select('id')->from('region_list');								
							$getAllRegionlist_ids = $this->db->get()->result_array();
							if(!empty($getAllRegionlist_ids))
							{
								foreach ($getAllRegionlist_ids as $keys => $valu) {
									$zoneData = array('job_id'=>$jobId,'region_id'=>$valu['id']);
									$this->modelbasic->_insert('job_zone_relation',$zoneData);							
								}
							}
							$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
							foreach ($getZonlist_ids as $key => $value) {	
								$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
								$this->modelbasic->_insert('job_zone_relation',$zoneData);					
							}
						}
						else
						{
								if(isset($_POST['region']) && !empty($_POST['region']) )
								{
									foreach ($_POST['region'] as $key => $value) 
									{
										$zoneData = array('job_id'=>$jobId,'region_id'=>$value);
										$this->modelbasic->_insert('job_zone_relation',$zoneData);
									}
								}
							   	else if(isset($_POST['zone']) && !empty($_POST['zone']) )
								{
									foreach ($_POST['zone'] as $key => $value) 
									{
										$this->db->select('id')->from('region_list')->where('zone_id',$value);
										if($this->session->userdata('admin_level')==4) 
										{
											$this->db->where_in('id',$region);
										}
										$getZonlist_ids = $this->db->get()->result_array();									
										if(!empty($getZonlist_ids))
										{
											foreach ($getZonlist_ids as $keys => $values) 
											{
												$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
												$this->modelbasic->_insert('job_zone_relation',$zoneData);
												
											}
										}
										
									}
								}
								if(isset($_POST['zone']) && !empty($_POST['zone']) ){
									foreach ($_POST['zone'] as $key => $value) {
										$zoneData = array('job_id'=>$jobId,'zone_id'=>$value);
										$this->modelbasic->_insert('job_zone_relation',$zoneData);
									}
								}
							
						}

				}

				if($jobId > 0){

					//$jobData =  $this->job_model->getJobData($jobId);

					$notificationEditEntry=array('title'=>'New job posted','msg'=>'New job '.$this->input->post('title',TRUE).' posted on creosouls.','link'=>'job/jobDetail/'.$jobId,'imageLink'=>'companyLogos/thumbs/'.$_POST['companyLogo']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$jobId);

					$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEditEntry);


					$data = array('status' =>'success','for'    =>'add','message'=>'Job added successfully.');
					if($this->input->post('jobStatus',TRUE) !='')
					{
						$view_status = $this->input->post('jobStatus',TRUE);
						$posted_by = $this->session->userdata('instituteId');
					}
					else
					{
						$view_status = '';
						$posted_by = '';
					}

					$allInstituteId = $this->job_model->getAllPreticularRegionInstitute($jobId,$view_status,$posted_by);	

					if(!empty($allInstituteId))
					{						
						foreach ($allInstituteId as $key => $value) 
						{
							$this->db->select('A.id,A.firstName,A.lastName,A.email,A.job_status,B.new_job');
							$this->db->from('users as A');						
							$this->db->join('user_email_notification_relation as B','B.userId=A.id','left');
							$this->db->where('A.job_status',1);				
							$this->db->where('B.new_job',1);				
							$this->db->where('A.instituteId',$value);	
							$allUserInSingleInstitute = $this->db->get()->result_array();
							//	print_r($allUserInSingleInstitute);die;
							if(!empty($allUserInSingleInstitute))
							{
								foreach ($allUserInSingleInstitute as $singleUserKey => $singleUaseValue) 
								{
									if($singleUaseValue['job_status'] == 1)
									{								
										$front_base_url=front_base_url();
										$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
									
										$template = 'Hello <b>'.$singleUaseValue['firstName'].' '.$singleUaseValue['lastName'].'</b>,<br /><br />New job posted on creosouls.<br/><br/>Please <a href="'.front_base_url().'job/jobDetail/'.$jobId.'">Click here</a><br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
										
										$emailData = array('to'=>$singleUaseValue['email'],'subject'  =>'New Job Posted On creosouls','template' =>$template,'fromEmail'=>$emailFrom);
										//	print_r($emailData);die;
										//$this->modelbasic->sendMail($emailData);

										$insertJobNotification = array('notification_id'=>$notificationId,'user_id'=>$singleUaseValue['id'],'status'=>0);
										$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);

										 /*$msg['notificationImageUrl'] = '';					
										$msg['notificationTitle'] = 'New Job Posted';
										$msg['notificationMessage']  = ucwords($jobData[0]['title']);
										$msg['notificationType']   = 1;						
									    $msg['notificationId']     = $jobId;
									    $msg['type']     = 0;
										$this->sendGcmToken($val['id'],$msg);*/

										$msg = array (
											'body' 	=> '',
											'title'	=> '',
											'aboutNotification'	=>$singleUaseValue['firstName'].' '.$singleUaseValue['lastName'].' New job posted on creosouls.',
											'notificationTitle'	=> 'New Job Posted',
											'notificationType'	=> 1,
											'notificationId'	=> $jobId,
											'notificationImageUrl'	=> ''          	
								        );
										$this->modelbasic->sendNotification($singleUaseValue['id'],$msg);
									}
								}
							}
						}
					}				
				}
				else
				{
					$data = array('status' =>'fail','message'=>'Error occurred while adding job please try again....');
				}
			}
			echo json_encode($data);
		}
		else
		{
			if($this->input->is_ajax_request()){
				echo $this->form_validation->get_json();
			}
			else
			{
				$this->load->view('admin/jobs/add_view');
			}
		}
	}

	function image_upload()
	{
		if($_FILES['logo']['size'] != 0){
			$upload_dir = file_upload_s3_path().'companyLogos/';
			if(!is_dir($upload_dir)){
				mkdir($upload_dir);
			}
			$config['upload_path'] = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name'] = 'companyLogo_'.substr(md5(rand()),0,7);
			$config['max_size'] = '2000';
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('logo')){
				$this->form_validation->set_message('image_upload', $this->upload->display_errors());
				return false;
			}
			else
			{
				$_POST['companyLogo'] = $this->upload->data();
				if(!is_dir(file_upload_s3_path().'companyLogos/thumbs')){
					mkdir(file_upload_s3_path().'companyLogos/thumbs', 0777, TRUE);
				}

				$config['image_library'] = 'gd2';
				$config['source_image'] = file_upload_s3_path().'companyLogos/'.$_POST['companyLogo']['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 200;
				$config['new_image'] = file_upload_s3_path().'companyLogos/thumbs/'.$_POST['companyLogo']['file_name'];
				$this->load->library('image_lib',$config);
				$return = $this->image_lib->resize();
				return true;
			}
		}
		else
		{
			//$this->form_validation->set_message('image_upload', "No file selected");
			return true;
		}
	}

	function setFlashdata($function)
	{
		if($function == 'add'){
			$this->session->set_flashdata('success','Job added successfully.');
			redirect(base_url().'admin/jobs/');
		}
		else
		{
			$this->session->set_flashdata('success','Job updated successfully.');
			redirect(base_url().'admin/jobs/');
		}
	}

	function getEditFormData()
	{
		$jobId = $this->input->post('jobId',true);
		$data = $this->job_model->get_singleJobData($jobId);
		$data['close_on'] = date("d-M-Y", strtotime($data["close_on"]));
		echo json_encode($data);
	}
	
	public function sendGcmToken($userId,$msg)
	{
		 $API_ACCESS_KEY='AIzaSyCAVHevvPy-yAZUbJdRRF2RLf8DTQcDcGw';
		 //$registrationIds = array( $_GET['id'] );
		    $deviceId = $this->modelbasic->getValue('users','deviceId',"id",$userId);	
				
			if(isset($deviceId)&&$deviceId!='')
			{
			    $gcmToken = $this->modelbasic->getValue('gcm','gcmToken',"deviceId",$deviceId);
				
				if(isset($gcmToken)&& $gcmToken!='')
				{
					// prep the bundle
						/*$msg = array
						(
							'message' 	=> 'here is a message. message',
							'title'		=> 'This is a title. title',
							'subtitle'	=> 'This is a subtitle. subtitle',
							'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
							'vibrate'	=> 1,
							'sound'		=> 1,
							'largeIcon'	=> 'large_icon',
							'smallIcon'	=> 'small_icon'
						);*/

						/*    int type,
						    int notificationId,
						    int notificationType,
						    String notificationTitle,
						    String notificationMessage,
						    String notificationImageUrl,*/

						//	print_r($msg);
						  $gcmId = array($gcmToken);
							
						
						$fields = array
						(
							'registration_ids' 	=> $gcmId,
							'data'			=>  array('default'=>$msg)
						);
						
						//print_r($fields);die;
						 
						$headers = array
						(
							'Authorization: key=' . $API_ACCESS_KEY,
							'Content-Type: application/json'
						);
						 
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
						$result = curl_exec($ch );
						curl_close( $ch );
						//echo $result;die;
				}				
			}	
	       return;			
	}

	function getZoneRegionList()
	{
		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			foreach ($_POST['zoneId'] as $key => $value) {

				$zoneId = $value;				
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['region_name'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			}
		}			
	}

	function getSelectedRegionList()
	{

		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			foreach ($_POST['zoneId'] as $key => $value) {

				$zoneId = $value;
				$jobId = $_POST['jobId'];

				if($jobId != 0 )
				{
					$getSelectedZone = $this->modelbasic->getSelectedData('job_zone_relation','*',array('job_id'=>$jobId));		
				}
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
		
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($getSelectedZone) && !empty($getSelectedZone))
						{
							foreach ($getSelectedZone as $val) {
								if($val['region_id'] == $value['id'])
									{ echo "selected"; }						
								}
							} 
							?>><?php echo $value['region_name'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			}
		}			
	}

	public function export_job_users()
	{
		$jobId = $_POST['jobId'];
		$this->load->dbutil();
		$this->load->helper('file');
		$query = $this->job_model->export_job_users($jobId);
		$data=$this->dbutil->csv_from_result($query);

		if (!is_dir('../export'))
		{
	    		mkdir('../export', 0777, TRUE);
		}
		$fileName = time().'.csv';
		$path='../export/'.$fileName;
		if ( ! write_file($path, $data))
		{
		     $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
		}
		else
		{
		    	$this->load->helper('download');
		    	$data = file_get_contents($path);
		    	//force_download(basename($path),$data);
		    	echo $fileName;
		}
			//redirect('admin/users');
	}


	public function add_csv()
	{		
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('string');

		if(isset($_FILES['csvfile']) && $_FILES['csvfile']['size'] != 0)
		{				
			$upload_path=file_upload_absolute_path();				
			if(!is_dir($upload_path))
			{
				@mkdir($upload_path, 0777, TRUE);
			}
			$upload_path.='csv/';
			if(!is_dir($upload_path))
			{
				@mkdir($upload_path, 0777, TRUE);
			}
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] ='csv';
			$this->upload->initialize($config);
			if($this->upload->do_upload('csvfile'))
			{
				$xls_file=$this->upload->data();
				$file = file_upload_s3_path().'csv/'.$xls_file['file_name'];
				$this->load->library('csvimport');
				$handle = fopen($file, "r");
				$data = fgetcsv($handle, 1000, ",");
				$all_data=array();
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{
			    	$all_data[]=$data;
				}
		     	$productCount=0;
		     	$i=1;
		     	$error='';
    			//print_r($all_data);die;
	     		if(!empty($all_data))
	     		{
		     		foreach($all_data as $val)
		     		{ 
		     			if(!empty($val[0]) && !empty($val[2]))
		     			{
		     				if($this->session->userdata('admin_level')==1)
		     				{	
		     					$title = $val[4];
		     					$companyLogo = $val[19];
		     					$no_of_position = $val[20];
								//$find_employer=$this->job_model->find_employer($val[22]);

			     				$data = array('admin_level'=>$this->session->userdata('admin_level'),'companyName'=>$val[2],'aboutCompany'=>$val[3],'title'=>$val[4],'type'=>$val[5],'description'=>$val[6],'education'=>$val[7],'keySkills'=>$val[8],'min_experience'=>$val[9],'max_experience'=>$val[10],'industry'=>$val[11],'country'=>$val[12],'state'=>$val[13],'city'=>$val[14],'location'=>$val[15],'close_on'=>date('Y-m-d H:i:s',strtotime($val[16])),'recruiter_email_id'=>$val[17],'function'=>$val[18],'companyLogo'=>$val[19],'job_type'=>1,'status'=>1,'featured'=>0,'created'=>date('Y-m-d H:i:s'),'no_of_position'=>$no_of_position,'job_type1'=>$val[21]);
			     			}
			     			elseif($this->session->userdata('admin_level')==2)
			     			{
			     				$title = $val[2];
			     				$companyLogo = $val[17];
			     				$no_of_position = $val[19];

			     				$data = array('admin_level'=>$this->session->userdata('admin_level'),'companyName'=>$val[0],'aboutCompany'=>$val[1],'title'=>$val[2],'type'=>$val[3],'description'=>$val[4],'education'=>$val[5],'keySkills'=>$val[6],'min_experience'=>$val[7],'max_experience'=>$val[8],'industry'=>$val[9],'country'=>$val[10],'state'=>$val[11],'city'=>$val[12],'location'=>$val[13],'close_on'=>date('Y-m-d H:i:s',strtotime($val[14])),'recruiter_email_id'=>$val[15],'function'=>$val[16],'companyLogo'=>$val[17],'job_type'=>1,'status'=>1,'featured'=>0,'created'=>date('Y-m-d H:i:s'),'no_of_position'=>$no_of_position,'job_type1'=>$val[21]);

			     				$data['view_status'] = $val[18];
			     				$data['posted_by'] = $this->session->userdata('instituteId');
			     			}
			     			elseif($this->session->userdata('admin_level')==3)
			     			{
			     				$title = $val[2];
			     				$companyLogo = $val[17];
			     				$no_of_position = $val[18];

			     				$data = array('admin_level'=>$this->session->userdata('admin_level'),'companyName'=>$val[0],'aboutCompany'=>$val[1],'title'=>$val[2],'type'=>$val[3],'description'=>$val[4],'education'=>$val[5],'keySkills'=>$val[6],'min_experience'=>$val[7],'max_experience'=>$val[8],'industry'=>$val[9],'country'=>$val[10],'state'=>$val[11],'city'=>$val[12],'location'=>$val[13],'close_on'=>date('Y-m-d H:i:s',strtotime($val[14])),'recruiter_email_id'=>$val[15],'function'=>$val[16],'companyLogo'=>$val[17],'job_type'=>1,'status'=>1,'featured'=>0,'created'=>date('Y-m-d H:i:s'),'no_of_position'=>$no_of_position,'job_type1'=>$val[21]);

			     				$data['posted_by'] = $this->session->userdata('admin_id');

			     			}
			     			elseif($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5)
			     			{
			     				$title = $val[4];
			     				$companyLogo = $val[19];
			     				$no_of_position = $val[21];

			     				$data = array('admin_level'=>$this->session->userdata('admin_level'),'companyName'=>$val[2],'aboutCompany'=>$val[3],'title'=>$val[4],'type'=>$val[5],'description'=>$val[6],'education'=>$val[7],'keySkills'=>$val[8],'min_experience'=>$val[9],'max_experience'=>$val[10],'industry'=>$val[11],'country'=>$val[12],'state'=>$val[13],'city'=>$val[14],'location'=>$val[15],'close_on'=>date('Y-m-d H:i:s',strtotime($val[16])),'recruiter_email_id'=>$val[17],'function'=>$val[18],'companyLogo'=>$val[19],'job_type'=>1,'status'=>1,'featured'=>0,'created'=>date('Y-m-d H:i:s'),'no_of_position'=>$no_of_position,'job_type1'=>$val[22]);

			     			//	$data['view_status'] = 0;
			     				$data['posted_by'] = $this->session->userdata('admin_id');
			     			} 								     						     				
		     			 	$jobId=$this->modelbasic->_insert('jobs',$data);
		     			 	if($this->session->userdata('admin_level')==1)
		     			 	{			     			 		
 		     			 		if(trim($val[1]) != '')
 					     			{	 					     									     				
 					     				$region = explode(',',$val[1]);	 					     			
 					     				if(!empty($region) )
 					     				{
 					     					foreach ($region as  $region_name)
 					     					{
 					     						$regionId = $this->db->select('*')->from('region_list')->where('region_name',trim($region_name))->get()->row_array();	
 					     					
 					     						$regionData = array('job_id'=>$jobId,'region_id'=>$regionId['id']);
 					     						$this->modelbasic->_insert('job_zone_relation',$regionData);		     						
 					     					}	
 					     				}
 					     			}
 					     			else if(trim($val[0]) != '')
 					     			{ 	 					     				
 					     				$zone = explode(',',$val[0]);
 					     				if(!empty($zone))
 					     				{
 					     					foreach ($zone as  $zone_name) {
 					     						$zoneId = $this->db->select('*')->from('zone_list')->where('zone_name',trim($zone_name))->get()->row_array();
 					     						$this->db->select('id')->from('region_list')->where('zone_id',$zoneId['id']);	 					     					
 					     						$getRegionlist_ids = $this->db->get()->result_array();									
 					     						if(!empty($getRegionlist_ids))
 					     						{
 					     							foreach ($getRegionlist_ids as $keys => $values) 
 					     							{
 					     								$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
 					     								$this->modelbasic->_insert('job_zone_relation',$zoneData);
 					     								
 					     							}
 					     						}
 					     					}	
 					     				}
 					     			}
		     			     		if(trim($val[0]) !='')
		     			     			{
		     			     				$zone = explode(',',$val[0]);

		     			     				if(!empty($zone))
		     				     				{
		     				     					foreach ($zone as  $zone_name) 
		     				     					{
		     				     						$zoneId = $this->db->select('*')->from('zone_list')->where('zone_name',trim($zone_name))->get()->row_array();
		     				     						$zoneData = array('job_id'=>$jobId,'zone_id'=>$zoneId['id']);
		     				     						$this->modelbasic->_insert('job_zone_relation',$zoneData);
		     				     					}
		     			     				}
		     			     			}
		     			 	}
		     			 	else if($this->session->userdata('admin_level')==2)
		     			 	{
		     			 		if($val[18] == 0)
		     			 		{						
		     			 			$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
			     			 		if(!empty($getZonlist_ids))
			     			 		{
				     			 		foreach ($getZonlist_ids as $key => $value) 
				     			 		{	
				     			 			$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
				     			 			$this->modelbasic->_insert('job_zone_relation',$zoneData);					
				     			 		}
				     			 		foreach ($getZonlist_ids as $key => $value)
				     			 		 {						     			 		
					     			 		$this->db->select('id')->from('region_list')->where('zone_id',$value['id']);	 					     					
					     			 		$getRegionlist_ids = $this->db->get()->result_array();									
					     			 		if(!empty($getRegionlist_ids))
					     			 		{
					     			 			foreach ($getRegionlist_ids as $keys => $values) 
					     			 			{
					     			 				$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
					     			 				$this->modelbasic->_insert('job_zone_relation',$zoneData);
					     			 				
					     			 			}
					     			 		}	
				     			 		}	
			     			 		}
		     			 		}
		     			 		else
		     			 		{
		     			 			$INSTID = $this->session->userdata('instituteId');
		     			 			$getRegId = $this->db->select('region')->from('institute_master')->where('id',$INSTID)->get()->row_array();
		     			 			$zoneData = array('job_id'=>$jobId,'region_id'=>$getRegId['region']);
		     			 			$this->modelbasic->_insert('job_zone_relation',$zoneData);
		     			 		}

		     			 	}
		     			 	else if($this->session->userdata('admin_level') == 3)
		     			 	{
		     			 		$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
		     			 		if(!empty($getZonlist_ids))
		     			 		{
			     			 		foreach ($getZonlist_ids as $key => $value) 
			     			 		{	
			     			 			$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
			     			 			$this->modelbasic->_insert('job_zone_relation',$zoneData);					
			     			 		}	

			     			 		foreach ($getZonlist_ids as $key => $value)
			     			 		 {						     			 		
				     			 		$this->db->select('id')->from('region_list')->where('zone_id',$value['id']);	 					     					
				     			 		$getRegionlist_ids = $this->db->get()->result_array();									
				     			 		if(!empty($getRegionlist_ids))
				     			 		{
				     			 			foreach ($getRegionlist_ids as $keys => $values) 
				     			 			{
				     			 				$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
				     			 				$this->modelbasic->_insert('job_zone_relation',$zoneData);
				     			 				
				     			 			}
				     			 		}	
			     			 		}	
		     			 		}
		     			 	}
		     			 	else if($this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level') == 5)
		     			 	{
		     			 		$regionIDs = $this->modelbasic->getInstituteRegions();		
		     			 		//	print_r($regionIDs);die;		     			 			
		     			 		if(isset($val[20]) && $val[20] == 0)
		     			 		{
		     			 			$this->db->select('id')->from('region_list');								
		     			 			$getAllRegionlist_ids = $this->db->get()->result_array();
		     			 			if(!empty($getAllRegionlist_ids))
		     			 			{
		     			 				foreach ($getAllRegionlist_ids as $keys => $valu)
		     			 				 {
		     			 					$zoneData = array('job_id'=>$jobId,'region_id'=>$valu['id']);
		     			 					$this->modelbasic->_insert('job_zone_relation',$zoneData);							
		     			 				}
		     			 			}
		     			 			$getZonlist_ids = $this->db->select('id')->from('zone_list')->get()->result_array();
		     			 			foreach ($getZonlist_ids as $key => $value)
		     			 			 {	
		     			 				$zoneData = array('job_id'=>$jobId,'zone_id'=>$value['id']);
		     			 				$this->modelbasic->_insert('job_zone_relation',$zoneData);					
		     			 			}	

		     			 		}
		     			 		else
		     			 		{

			     			 		if(trim($val[1]) != '')
						     			{
						     				$region = explode(',',$val[1]);
						     				if(!empty($region))
						     				{
						     					foreach ($region as  $region_name)
						     					{
						     						$regionId = $this->db->select('*')->from('region_list')->where('region_name',trim($region_name))->where_in('id',$regionIDs)->get()->row_array();	
						     						/*echo $this->db->last_query();
						     						print_r($regionId);*/
						     						if(!empty($regionId))
						     						{
						     							$regionData = array('job_id'=>$jobId,'region_id'=>$regionId['id']);
						     							$this->modelbasic->_insert('job_zone_relation',$regionData);		
						     						}     						
						     					}	
						     				}
						     			}
						     			else if(trim($val[0]) != '')
						     			{							     				
						     				$zone = explode(',',$val[0]);
						     				if(!empty($zone))
						     				{
						     					foreach ($zone as  $zone_name) {
						     						$zoneId = $this->db->select('*')->from('zone_list')->where('zone_name',trim($zone_name))->get()->row_array();
						     						$this->db->select('id')->from('region_list')->where('zone_id',$zoneId['id']);	
						     						$this->db->where_in('id',$regionIDs); 					     					
						     						$getRegionlist_ids = $this->db->get()->result_array();									
						     						if(!empty($getRegionlist_ids))
						     						{
						     							foreach ($getRegionlist_ids as $keys => $values) 
						     							{
						     								$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
						     								$this->modelbasic->_insert('job_zone_relation',$zoneData);							     								
						     							}
						     						}
						     					}	
						     				}
						     			}
 			 				     			if(trim($val[0]) !='')
 			 				     			{
 			 				     				$zone = explode(',',$val[0]);
 			 				     				if(!empty($zone))
 			 					     				{
 			 					     					foreach ($zone as  $zone_name) 
 			 					     					{
 			 					     						$zoneId = $this->db->select('*')->from('zone_list')->where('zone_name',trim($zone_name))->get()->row_array();
 			 					     						$zoneData = array('job_id'=>$jobId,'zone_id'=>$zoneId['id']);
 			 					     						$this->modelbasic->_insert('job_zone_relation',$zoneData);
 			 					     					}
 			 				     				}
 			 				     			}     			 				     			     			 			
		     			 		}
		     			 	}

			     			if($jobId > 0)
			     			{				     				

			     				$notificationEditEntry=array('title'=>'New job posted','msg'=>'New job '.$title.' posted on creosouls.','link'=>'job/jobDetail/'.$jobId,'imageLink'=>'companyLogos/thumbs/'.$companyLogo,'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$jobId);
			     				$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEditEntry);
			     				$data = array('status' =>'success','for'    =>'add','message'=>'Job added successfully.');

			     				$view_status = '';
			     				$posted_by = '';

			     				if($this->session->userdata('admin_level')==2)
			     				{
			     					if(isset($val[18]) && $val[18] !='')
			     					{
			     						$view_status = $val[18];
			     						$posted_by = $this->session->userdata('instituteId');
			     					}	
			     				}
			     				if($this->session->userdata('admin_level')==4)
			     				{
			     					if(isset($val[20]) && $val[20] !='')
			     					{
			     						$view_status = $val[20];
			     						$posted_by = $this->session->userdata('instituteId');
			     					}					     					
			     				}

			     				$allInstituteId = $this->job_model->getAllPreticularRegionInstitute($jobId,$view_status,$posted_by);	

			     				/*if(!empty($allInstituteId))
			     				{						
			     					foreach ($allInstituteId as $key => $value) {
			     						$this->db->select('A.id,A.firstName,A.lastName,A.email,A.job_status,B.new_job');
			     						$this->db->from('users as A');						
			     						$this->db->join('user_email_notification_relation as B','B.userId=A.id','left');
			     						$this->db->where('A.job_status',1);				
			     						$this->db->where('B.new_job',1);				
			     						$this->db->where('A.instituteId',$value);	

			     						$allUserInSingleInstitute = $this->db->get()->result_array();

			     					//	print_r($allUserInSingleInstitute);die;

			     						if(!empty($allUserInSingleInstitute))
			     							{
			     								foreach ($allUserInSingleInstitute as $singleUserKey => $singleUaseValue) 
			     								{
			     									if($singleUaseValue['job_status'] == 1)
			     									{
			     								
			     									$front_base_url=front_base_url();
			     								
			     									$template = 'Hello <b>'.$singleUaseValue['firstName'].' '.$singleUaseValue['lastName'].'</b>,<br /><br />New job posted on creosouls.<br/><br/>Please <a href="'.front_base_url().'job/jobDetail/'.$jobId.'">Click here</a><br /><br />  Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			     									$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
			     									$emailData = array('to'=>$singleUaseValue['email'],'subject'  =>'New Job Posted On creosouls','template' =>$template,'fromEmail'=>$emailFrom);
			     									//	print_r($emailData);die;
			     									//$this->modelbasic->sendMail($emailData);

			     									//$insertJobNotification = array('notification_id'=>$notificationId,'user_id'=>$singleUaseValue['id'],'status'=>0);
			     									//$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);

			     									 /*$msg['notificationImageUrl'] = '';					
			     									$msg['notificationTitle'] = 'New Job Posted';
			     									$msg['notificationMessage']  = ucwords($jobData[0]['title']);
			     									$msg['notificationType']   = 1;						
			     								    	$msg['notificationId']     = $jobId;
			     								   	 $msg['type']     = 0;
			     									$this->sendGcmToken($val['id'],$msg);*/
			     									/*$msg = array (
														'body' 	=> '',
														'title'	=> '',
														'aboutNotification'	=>$singleUaseValue['firstName'].' '.$singleUaseValue['lastName'].' New job posted on creosouls.',
														'notificationTitle'	=> 'New Job Posted',
														'notificationType'	=> 1,
														'notificationId'	=> $jobId,
														'notificationImageUrl'	=> ''          	
											        );
													//$this->modelbasic->sendNotification($singleUaseValue['id'],$msg);
			     								}

			     							}
			     						}
			     					}
			     				}*/				
			     			}
		     		 		$productCount++;
		     			}
		     			else
		     			{
		     				if($val[0] =='')
		     				{
		     					$error .= "On line no. ".$i." Company name is required.<br/>";
		     				}
		     				if($val[1] =='')
		     				{
		     					$error .= "On line no. ".$i." About company is required.<br/>";
		     				}
		     				/*	if($val[2] =='')
		     				{
		     					$error .= "On line no. ".$i." Title is required.<br/>";
		     				}
		     				if($val[3] =='')
		     				{
		     					$error .= "On line no. ".$i." Job Type is required.<br/>";
		     				}
		     				if($val[4] =='')
		     				{
		     					$error .= "On line no. ".$i." Description is required.<br/>";
		     				}
		     				if($val[5] =='')
		     				{
		     					$error .= "On line no. ".$i." Education is required.<br/>";
		     				}
							*/
		     			}
		     		}			     		
	     		   $i++;
	     		}
	     	}				
			else
			{
				$upload_error=$this->upload->display_errors();
				$this->session->set_flashdata('error',$upload_error);
				 redirect('admin/jobs','refresh');
			}
		}
		$this->session->set_flashdata('error',$error);
		redirect('admin/jobs','refresh');
	}


	public function do_upload()
	{
		$upload_path_url = file_upload_s3_path().'companyLogos/';

		if(!is_dir(file_upload_s3_path().'companyLogos/thumbs'))
		{
			mkdir(file_upload_s3_path().'companyLogos/thumbs', 0777, TRUE);
		}   

	        $config['upload_path'] = $upload_path_url;
	        $config['allowed_types'] = 'jpg|png|jpeg';
	     
	        $config['max_size'] = '2000';
	        $this->load->library('upload', $config);
	        if (!$this->upload->do_upload())
	         {
			if((isset($_FILES['userfile']['name'])))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('upload', $error);
			}
	        } 
	        else
	        {
	            	$data = $this->upload->data();		
			$this->load->library('image_lib');
		   	$config['image_library'] = 'gd2';
		   	$config['file_name'] = $data['file_name'];
		   	$config['source_image'] = file_upload_s3_path().'companyLogos/'.$data['file_name'];
			$config['new_image']= file_upload_s3_path().'companyLogos/thumbs/'.$data['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 200;
			$config['height'] = 200;
		   	 $this->image_lib->initialize($config);
			if ( ! $this->image_lib->resize())
			{
			    echo $this->image_lib->display_errors();
			}			

            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];	
            $info->url = file_upload_base_url() .'companyLogos/'.$data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
         
	   		$info->thumbnailUrl = file_upload_base_url() . 'companyLogos/thumbs/' . $data['file_name'];   		
            $info->deleteUrl = base_url() . 'admin/jobs/deleteImage/'.urldecode($data['file_name']);
            $info->deleteType = 'DELETE';
            $info->error = null;
            $files[] = $info;
            //this is why we put this in the constants to pass only json data
           if($this->input->is_ajax_request())
           {
                echo json_encode(array("files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
                $file_data['upload_data'] = $this->upload->data();
                $this->load->view('upload_success', $file_data);
            }
        }
    }

	public function deleteImage($file1)
	{	 	
 	   //gets the job done but you might want to add error checking and security
 		$upload_path_url = file_upload_s3_path().'companyLogos/';		  
		$file= html_entity_decode($file1);    
		$date = date("Y-m-d");
   		$success = unlink(FCPATH . $upload_path_url. $file);
    	$success = unlink(FCPATH . $upload_path_url.'thumbs/'. $file);
        //info to see if it is doing what it is supposed to
        $info = new StdClass;
        $info->sucess = $success;
        $info->path = $upload_path_url. $file;
        $info->file = is_file(FCPATH . $upload_path_url . $file);
       if($this->input->is_ajax_request())
        {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } 
        else 
        {
            //here you will need to decide what you want to show for a successful delete
            $file_data['delete_data'] = $file;
            $this->load->view('delete_success', $file_data);
        }     
	}

	public function addtestassigment()
	{		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('assignment_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');	
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');	
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');	
		if ($this->form_validation->run())
		{			
			$job_user_relaiton_id=$_POST['job_user_relaiton_id'];
			$jobdata=$this->modelbasic->getData('job_user_relation','*',array('id'=>$job_user_relaiton_id));
			$jobDetails=$this->db->select('*')->from('jobs')->where('id',$jobdata['jobId'])->get()->row_array();
			$jobName=$jobDetails['title'];
			$AddData=array('interview_assignment_name'=> $this->input->post('assignment_name',TRUE),'description'=>$this->input->post('description',TRUE),'start_date'=>date('Y-m-d',strtotime($this->input->post('start_date',TRUE))),'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date',TRUE))),'employer_id'=>$this->session->userdata('admin_id'),'created'=>date('Y-m-d H:i:s'),'jobId'=>$jobdata['jobId']);	

			$res=$this->modelbasic->_insert('interview_assignment',$AddData);
			
			$individual_user=$jobdata['userId'];
			$user_assig_relation_data  = array('user_id' => $individual_user,'interview_assignment_id'=>$res);
			$insert_user_assig_relation_data=$this->modelbasic->_insert('interview_assignment_user_relation',$user_assig_relation_data);
			$get_user_data=$this->modelbasic->getData('users','firstName,lastName,email',array('id'=>$individual_user));
			$get_interview_assignment_data=$this->modelbasic->getData('interview_assignment','*',array('id'=>$res));
			$get_employer_data=$this->modelbasic->getData('users','firstName,lastName,email',array('id'=>$this->session->userdata('admin_id')));
			
			
			//echo $this->db->last_query();
			if($res)
			{
				$this->job_model->_update_status("job_user_relation",$jobdata['userId'],$jobdata['jobId'],array('apply_status'=>18));			
				$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> New Interview Test has been assign to you by '.$get_employer_data['firstName'].' '.$get_employer_data['lastName'].'<br /> Interview Test Name : '.$get_interview_assignment_data['interview_assignment_name'].'<br /> Start Date :'.$get_interview_assignment_data['start_date'].'<br /> End Date :'.$get_interview_assignment_data['end_date'].'<br />You have to submit test in given time duration.  <br />Thank You.';
				//echo $message;die;
				$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_employer_data['email'],'subject'=>'Interview Test Is Assign(By Employer)','template'=>$message);	  
				//$sendMail = $this->modelbasic->sendMail($emailData);
				
				$notificationEntry=array('title'=>'Interview Test Is Assign To You For Job Application','msg'=>'New Interview Test '.$get_interview_assignment_data['interview_assignment_name'].' added by '.$get_employer_data['firstName'].' '.$get_employer_data['lastName'],'link'=>'interview_test/interview_test_detail/'.$res.'/'.$individual_user,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>$res);
				$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
				$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user);
				$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);			
				$msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=>$get_user_data['firstName'].' '.$get_user_data['lastName'].' New Interview Test has been assign to you',
						'notificationTitle'	=> 'Interview Test Is Assign',
						'notificationType'	=> 1,
						'notificationId'	=> $jobdata['jobId'],
						'notificationImageUrl'	=> ''          	
			          );
					$this->modelbasic->sendNotification($jobdata['userId'],$msg);

				if($_POST['tools']!='')
				{
					$tools = explode(',', $_POST['tools']);
					if(!empty($tools))
					{
						foreach($tools as $single_tool_value)
						{
							$get_tool_data=$this->modelbasic->get_where_array('attribute_value_master',array('attributeId'=>1,'attributeValue'=>$single_tool_value));
							if(!empty($get_tool_data))
							{							
								$AddToolData=array('interview_assignment_id'=>$res,'attribute_tools_id'=>$get_tool_data['id']);	
							}
							else
							{
								$add_tool_data=array('attributeId'=>1,'attributeValue'=>$single_tool_value);
								$add_tool=$this->modelbasic->_insert('attribute_value_master',$add_tool_data);
								if($add_tool>1)
								{
									$AddToolData=array('interview_assignment_id'=>$res,'attribute_tools_id'=>$add_tool);
								}
							}
							$insert_get_tool_data=$this->modelbasic->_insert('assignment_tools_relation',$AddToolData);						
						}
					}				
				}

				if($_POST['features']!='')
				{
					$features = explode(',', $_POST['features']);
					if(!empty($features))
					{
						foreach($features as $single_features_value)
						{
							$get_features_data=$this->modelbasic->get_where_array('attribute_value_master',array('attributeId'=>2,'attributeValue'=>$single_features_value));
							if(!empty($get_features_data))
							{							
								$AddfeaturesData=array('interview_assignment_id'=>$res,'attribute_features_id'=>$get_features_data['id']);
							}
							else
							{
								$add_feature_data=array('attributeId'=>1,'attributeValue'=>$single_features_value);
								$add_feature=$this->modelbasic->_insert('attribute_value_master',$add_feature_data);
								if($add_feature>1)
								{
									$AddfeaturesData=array('interview_assignment_id'=>$res,'attribute_features_id'=>$add_feature);
								}

							}
							$insert_get_features_data=$this->modelbasic->_insert('assignment_features_relation',$AddfeaturesData);					
						}
					}			
				}
			}
			
			if($res)
			{

				$this->session->set_flashdata('success','Interview assignment added successfully.');				
				$this->json->jsonReturn(array('status' =>'success','for'    =>'add','message'=>'Interview assignment added successfully.'));
			}
			else
			{				
				$this->session->set_flashdata('error','Error occurred while adding interview assignment please try again....');
				$this->json->jsonReturn(array('status' =>'fail','message'=>'Error occurred while adding interview assignment please try again....'));
			}					
		}
		else
		{
			$this->session->set_flashdata('error','Error occurred while adding interview assignment please try again....');
			$this->json->jsonReturn(array('status' =>'error','message'=>'Error occurred while adding interview assignment please try again....'));
		}	
	}	

	public function get_interview_test_image()
	{
		$userId=$_POST['userId'];
		$jobId=$_POST['jobid'];
		$interview_assignment_image=$this->job_model->get_interview_assignment_image($userId,$jobId);
	///	echo $this->db->last_query();
		$vlaData['interview_assignment_image'] = $interview_assignment_image->image_thumb;
		echo json_encode($vlaData);
	}

	
}