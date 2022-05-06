<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class reports extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('common_model');
    	$this->load->model('admin/reports_model');    
	    if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
	}

	public function manage_institute_users_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['users'] = $this->reports_model->manage_institute_users_reports($instituteId);
		//	print_r($data);die;
		$this->load->view('admin/reports/manage_institute_users_reports',$data);
	}

	public function export_manage_institute_users_reports()
	{
		$instituteId = $this->session->userdata('instituteId');		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_institute_users_reports($instituteId,'export');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
	 	if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','List of Users of Institute as per Projects Added.'));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		        fputcsv($fh, $row);
		    }
		}
	}

	public function manage_assignment_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['assignment'] = $this->reports_model->manage_assignment_reports($instituteId);
		//print_r($data);die;
		$this->load->view('admin/reports/manage_assignment_reports',$data);
	}

	public function export_manage_assignments_reports()
	{
		$instituteId = $this->session->userdata('instituteId');		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_assignment_reports($instituteId,'export');
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
	 	if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','',' Assignment Reports. '));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}

	public function manage_institute_statitstics_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['institute_statitstics'] = $this->reports_model->manage_institute_statitstics_reports($instituteId);
		//print_r($data);die;
		$this->load->view('admin/reports/manage_institute_statitstics_reports',$data);
	}

	public function export_manage_institute_statitstics_reports()
	{
		$instituteId = $this->session->userdata('instituteId');		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_institute_statitstics_reports($instituteId);
	  	header('Content-Type: application/excel');
	  	header('Content-Disposition: attachment; filename="'.$path.'"');
	    if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','',' Institute Statitstics Report . '));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}

	public function manage_job_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['jobs'] = $this->reports_model->manage_job_reports($instituteId);
		//print_r($data);die;
		$this->load->view('admin/reports/manage_job_reports',$data);
	}

	public function export_job_reports()
	{
		$instituteId = $this->session->userdata('instituteId');
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_job_reports($instituteId,'export');		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','','','',' Jobs Report . '));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}

	public function export_manage_job_reports($jobId,$jobTitie)
	{		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->export_manage_job_reports($jobId);		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');
		    $title = 'Details of job -: '.urldecode($jobTitie);

		    fputcsv($fh, array('','','',$title));		     
		    fputcsv($fh, array());	


		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}	

	public function export_manage_job_reports_admin()
	{		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->export_manage_job_reports_admin();	
		//print_r($data);	
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');
		    $title = 'Details of job -: '.urldecode('Job Related Reports');
		    fputcsv($fh, array('','','',$title));		     
		    fputcsv($fh, array());	
		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}	

	public function manage_feedback_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['feedback'] = $this->reports_model->manage_feedback_reports($instituteId);
	
		$this->load->view('admin/reports/manage_feedback_reports',$data);
	}

	public function export_manage_feedback_reports()
	{
		$instituteId = $this->session->userdata('instituteId');		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_feedback_reports($instituteId,'export');		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('', '','', ' Feedback Reports ', '', ''));
		    fputcsv($fh, array());
		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}	

	public function export_single_feedback_reports($feedbackId,$FeedbackInstanceName)
	{		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->export_single_feedback_reports($feedbackId);
		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('', '',urldecode($FeedbackInstanceName) , '', ''));
		    fputcsv($fh, array());
		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}	

	public function manage_individual_feedback_reports()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}
		$instituteId = $this->session->userdata('instituteId');
		$data['feedback'] = $this->reports_model->manage_individual_feedback_reports($instituteId);
		//print_r($data);die;
		$this->load->view('admin/reports/manage_individual_feedback_reports',$data);
	}

	public function export_manage_individual_feedback_reports()
	{
		$instituteId = $this->session->userdata('instituteId');		
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->manage_individual_feedback_reports($instituteId,'export');		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('',' Feedback Report of users . ' ));
		    fputcsv($fh, array());

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}	

	public function export_single_user_feedback_reports($userId,$instanceId,$CandidateName,$FeedbackInstanceName)
	{				
		$path=date('M d Y').time().'.csv';
		$data = $this->reports_model->export_single_user_feedback_reports($userId,$instanceId);		
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($data))
		{
			
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array(' feedback report of '));
		    fputcsv($fh, array(urldecode($FeedbackInstanceName)));				  
		    fputcsv($fh, array('User :- '.urldecode($CandidateName)));
		    fputcsv($fh, array());

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
	}

	public function manage_student_reports()
	{
		$data['instituteData']=$this->common_model->selectAllWhr('institute_master','status','1');
		$data['zoneData'] = $this->common_model->fetchAllDataAsc('zone_list','id','id,zone_name');
		//$data['studentData']=$this->reports_model->getstudent_data('','','','','','');
		$this->load->view("admin/reports/manage_student_reports",$data);
	}	

	public function student_report()
	{
		$institute_id=$this->input->post('institute_id');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$student_status=$this->input->post('student_status');
		$zone=$this->input->post('zone');
		$region=$this->input->post('region');
		$data['institute_id']=$institute_id;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		$data['student_status']=$student_status;
		$data['zone']=$zone;
		$data['region']=$region;
		$data['studentData']=$this->reports_model->getstudent_data($institute_id,$start_date,$end_date,$student_status,$zone,$region);
		//echo $this->db->last_query();
		//print_r($data['studentData']);
		$this->load->view("admin/reports/student_report",$data);			
	}

	public function exportstudentdata($zone='',$region='',$institute_id='',$start_date='',$end_date='',$student_status='')
	{
		$this->load->dbutil();
		$this->load->helper('file');
	
		$data=$this->reports_model->getstudent_data($institute_id,$start_date,$end_date,$student_status,$zone,$region);
		/*echo $this->db->last_query();
		print_r($data_result);*/
		$path='studentdata_'.date('dmY').time().'.csv';

		header('Content-Type: application/excel');
	  	header('Content-Disposition: attachment; filename="'.$path.'"');
	    if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','',' Student Report . '));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
		/*$data=$this->dbutil->csv_from_result_data($data_result);
		if (!is_dir('../export'))
		{
			mkdir('../export', 0777, TRUE);
		}
		$path='../export/studentdata_'.date('dmY').time().'.csv';
		//echo write_file();
		if (!write_file($path, $data))
		{
	    	//echo"if1";
		    $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
		}
		else
		{
	    	//echo"else1";
	    	$this->load->helper('download');
	    	$data = file_get_contents($path);
	    	force_download(basename($path),$data);
		}
		redirect('admin/reports/manage_student_reports');*/
	}
	
	public function manage_rah_rating()
	{
		$data['zoneData'] = $this->common_model->fetchAllDataAsc('zone_list','id','id,zone_name');
		$data['instituteData']=$this->reports_model->getins_data('','','','','','');
		//echo "<pre>";print_r($data['instituteData']);exit;
		$this->load->view("admin/reports/manage_rah_rating",$data);
	}
	
	public function rah_report()
	{
		//echo "<pre>";print_r($this->session->all_userdata()); exit; 
		//echo "j,hjhjhjh";exit;
		//$admin_id = $this->session->userdata('admin_id');
		//$user_id=$this->session->userdata('front_user_id');
		//echo "<pre>";print_r($session_data); exit;
		$admin_id = $this->session->userdata('admin_id');
		//$institute_id= $this->input->post('institute_id');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$status=$this->input->post('status');
		$zone=$this->input->post('zone');
		$region=$this->input->post('region');
		
		//$data['institute_id']=$institute_id;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;		
		$data['status']=$status;
		$data['zone']=$zone;
		$data['region']=$region;
		$data['admin_id']=$admin_id;
		
		$data['rahData']=$this->reports_model->getrah_data($admin_id,$start_date,$end_date,$status,$zone,$region);
		//echo $this->db->last_query();
		//echo "<pre>";print_r($data['rahData']);exit;
		
		//$this->load->view("admin/reports/student_report",$data);	
		$this->load->view("admin/reports/rah_report",$data);		
	}
	
	public function exportRahProjectData($admin_id='',$zone='',$region='',$start_date='',$end_date='',$status='')
	{
		$this->load->dbutil();
		$this->load->helper('file');

		//echo $this->db->last_query
		$data_result = $this->reports_model->getrah_data($admin_id,$start_date,$end_date,$status,$zone,$region);
		/*echo $this->db->last_query();
		print_r($data_result);*/
		$data=$this->dbutil->csv_from_result_data($data_result);
		if (!is_dir('../../export'))
		{
	    		mkdir('../../export', 0777, TRUE);
		}
		$path='../../export/rahdata_'.time().'.csv';
		if ( ! write_file($path, $data))
		{
		     $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
		}
		else
		{
	    	$this->load->helper('download');
	    	$data = file_get_contents($path);
	    	force_download(basename($path),$data);
		}
		redirect('admin/reports/manage_rah_rating');
	}

	public function manage_institute_reports()
	{
		$data['zoneData'] = $this->common_model->fetchAllDataAsc('zone_list','id','id,zone_name');
		$data['instituteData']=$this->reports_model->getins_data('','','','','','');
		$this->load->view("admin/reports/manage_institute_reports",$data);
	}

	public function institute_report()
	{
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$institute_status=$this->input->post('institute_status');
		$zone=$this->input->post('zone');
		$region=$this->input->post('region');
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		$data['institute_status']=$institute_status;
		$data['zoneid']=$zone;
		$data['regionid']=$region;
		$data['instituteData']=$this->reports_model->getins_data($zone,$region,$start_date,$end_date,$institute_status);
		$this->load->view("admin/reports/institute_report",$data);	
	}

	public function exportinstitutedata($zoneid='',$regionid='',$start_date='',$end_date='',$institute_status='')
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$path='institutedata_'.date('dmY').'.csv';

		$data=$this->reports_model->getins_data($zoneid,$regionid,$start_date,$end_date,$institute_status);	
		 	header('Content-Type: application/excel');
	  	header('Content-Disposition: attachment; filename="'.$path.'"');
	    if(!empty($data))
		{
		    $fh = fopen('php://output', 'w');

		    fputcsv($fh, array('','','',' Institute Report . '));		     
		    fputcsv($fh, array());	

		    fputcsv($fh, array_keys(current($data)));		     
		    foreach ( $data as $row ) 
		    {
		            fputcsv($fh, $row);
		    }
		}
		/*	echo $this->db->last_query()	;
		print_r($instituteData);die();*/
		/*$data=$this->dbutil->csv_from_result_data($instituteData);
		if (!is_dir('../export'))
		{
	    		mkdir('../export', 0777, TRUE);
		}
		$path='../export/institutedata_'.date('dmY').'.csv';
		if ( ! write_file($path, $data))
		{
		     $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
		}
		else
		{
	    	$this->load->helper('download');
	    	$data = file_get_contents($path);
	    	force_download(basename($path),$data);
	    }
		redirect('admin/reports/manage_institute_reports');*/

	}

	public function getZoneRegionList()
	{
		if(!empty($_POST['zoneId']))
		{  
			$cnt='';
			$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$_POST['zoneId'])); 
//print_r($data);
			if(!empty($data))
			{
				$cnt="<option value='All'>All</option>";
				foreach($data as $value)
				{	
					$cnt=$cnt."<option value=".$value['id'].">".$value['region_name']."</option>";
				}
			}	
			echo $cnt;		
		}			
	}

	public function getinsList()
	{
		if(!empty($_POST['regionid']))
		{  
			$cnt='';
			$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$_POST['regionid'],'status'=>'1')); 
			//print_r($data);
			if(!empty($data))
			{
				$cnt="<option value='All'>All</option>";
				foreach($data as $value)
				{	
					$cnt=$cnt."<option value=".$value['id'].">".$value['instituteName']."</option>";
				}
			}	
			echo $cnt;		
		}	
	}

	public function manage_region_reports()
	{
		$data['active_institute']=$this->reports_model->SelectActiveInsRegionwise();
		$this->load->view("admin/reports/manage_region_reports",$data);
	}
	public function exportregionwisedata()
	{
		$this->load->library("excel");
		$active_institute=$this->reports_model->SelectActiveInsRegionwise();
		$this->excel->exportregionwisedata($active_institute);
	}
	public function manage_top_student()
	{
		$data['top_student']=$this->reports_model->SelectTopStudentRegionwise();
		//print_r($top_student);
		$this->load->view("admin/reports/top_student_regionwise",$data);
	}

	public function export_topstudent_regionwise()
	{
		$this->load->library("excel");
		$top_student=$this->reports_model->SelectTopStudentRegionwise();
		$this->excel->export_topstudent_regionwise($top_student);
	}
	public function manage_insadmin_reports()
	{
		$this->load->view("admin/reports/manage_insadmin_reports");
	}
	public function exportinstitutewisedata()
	{
		$this->load->library("excel");
		$all_institutedata=$this->reports_model->SelectAll_InstituteData();
		$this->load->dbutil();
		$this->load->helper('file');
		//print_r($all_institutedata);
		foreach ($all_institutedata as $key) 
		{
			/*$query=$this->db->query("SELECT CONCAT(u.firstName,'  ',u.lastName) As StudentName,pm.projectname FROM users u LEFT JOIN project_master pm on u.id=pm.userId JOIN institute_master im on u.instituteid=im.id WHERE u.instituteid=$key->id AND pm.status=3");
			$data1=$this->dbutil->csv_from_result($query);
			$dir='../export/'.date('Y-m-d').'/';
			if (!is_dir($dir))
			{
		    		mkdir($dir, 0777, TRUE);
			}
			$path1=$dir.$key->instituteName.'_projectdata.csv';
			if ( ! write_file($path1, $data1))
			{
			    $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
			}
			else
			{
		    	$falg=1;
		    }


		    $query2=$this->db->query("SELECT CONCAT(icu.firstName,' ',icu.lastName) As StudentName,icu.email FROM institute_csv_users icu WHERE icu.email!='' AND icu.instituteId=$key->id");
			$data2=$this->dbutil->csv_from_result($query2);
			if (!is_dir($dir))
			{
		    		mkdir($dir, 0777, TRUE);
			}
			$path2=$dir.$key->instituteName.'_logedInstudent.csv';
			if ( ! write_file($path2, $data2))
			{
			    $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
			}
			else
			{
		    	$falg=2;
		    }


		    $query3=$this->db->query("SELECT CONCAT(icu.firstName,' ',icu.lastName) As StudentName,icu.email FROM institute_csv_users icu WHERE icu.email='' AND icu.instituteId=$key->id");
			$data3=$this->dbutil->csv_from_result($query3);
			if (!is_dir($dir))
			{
		    		mkdir($dir, 0777, TRUE);
			}
			$path3=$dir.$key->instituteName.'_notlogedInStudent.csv';
			if ( ! write_file($path3, $data3))
			{
			    $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
			}
			else
			{
		    	$falg=3;
		    }*/

		    $template='<br />Hello <b>'.$key->instituteName. '</b>,<br />Following are The Details of Institute.<br /> Cover Image <b>' .$key->coverImage.'</b><br />Logo Image <b>' .$key->instituteLogo.'</b> <br />Address <b>' .$key->address.'</b><br />Admin <b>' .$key->adminemail.'</b><br />Ho Admin <b>' .$key->hoeamil_id.'</b><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a><br />';
				//$newFileName = $dir.$key->instituteName.'_projectdata.txt';
				//file_put_contents($newFileName, $template);
			echo $template;
			$data=array('to'=>'dipali.nigade@gmail.com','cc'=>$key->hoeamil_id,'fromEmail'=>'support@creosouls.com','subject'=>'Regarding Institute Report','template'=>$template);
			$result=$this->reports_model->sendMailWithAttachment3($data);
			if($result)
			{
				echo "sucess";
			}
			else
			{				
				echo "Error Message";
			}
		}
	}

	public function check_send_mail()
	{			
	    //echo "hiiiiiiiiiiiiiiiiiiiii";
	    /*$template='<br />Hello <b>';
		$data=array('to'=>'dipali.nigade@gmail.com','fromEmail'=>'support@creosouls.com','subject'=>'Regarding Institute Report','template'=>$template);
		$result=$this->reports_model->sendMailWithAttachment3($data);
		*/
			/*if($result)
			{
				echo "sucess";
			}
			else
			{				
				echo "Error Message";
			}*/
			echo "aasdasdadasdasd";
			/*$this->load->library('email_sent');
		
					
			$subject = 'Task us Forgot Password';
						
			//$msg_body=$this->load->view("mailer/new_pass",$datavalue,true);
			$msg_body="Task us Forgot Password mail integration";
			$alt_msg = 'Task us Forgot Password';			
			$data=array('subject'=>$subject,'msg_body'=>$msg_body,'alt_msg'=>$alt_msg);	        
	        $email_id[]=array('email_id'=>"dipali.nigade@gmail.com"); 
			$result=$this->email_sent->mail_sent($data,$email_id);
			if($result)
			{				
				echo "sent";
		    }
		    else
		    {
				echo "Not sent";
		    }*/	
	}
}