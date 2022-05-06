<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Job_approval extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/job_approval_model');
	    if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
	}

	public function index()
	{
		if($this->session->userdata("admin_level")==5)
		{
			$this->job_approval_model->approvejobbysystem();
		}
		$data['institute'] = $this->job_approval_model->getAllInstitute();
		$this->load->view('admin/job_approval/manage_job_approval',$data);
	}

	function get_ajaxdataObjects($institute='')
	{	
		if($institute == '')
        {
              $institute = $this->session->userdata('instituteId');
        }

	        $_POST['columns']='A.id,A.institute_id,A.resume,A.userId,A.jobId,A.apply_status,A.apply_date,B.profileImage,B.email,C.companyName,C.title,C.companyLogo,C.close_on,C.job_type1';
		
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);	

		$selectColumns="CONCAT(B.firstName, ' ', B.lastName) as user_name,A.id,A.institute_id,A.resume,A.userId,A.jobId,A.apply_status,A.apply_date,B.profileImage,B.email,C.companyName,C.title,C.companyLogo,C.close_on,C.job_type1";
		//print_r($columns);die;
		//get total number of data without any condition and search term
		//$totalData=$this->job_approval_model->count_all_only('users');
		//$totalFiltered=$totalData;

		//pass concatColumns only if you want search field to be fetch from concat
		$concatColumns='firstName,lastName';

		$result=$this->job_approval_model->run_query($requestData,$columns,$selectColumns,$concatColumns,'user_name',$institute);
			//echo $this->db->last_query();
			//print_r($result);die;
			$totalData=count($result);
			if( !empty($requestData['search']['value']) )
			{
				$totalFiltered=count($result);
			}
			else
			{
				$totalFiltered=$totalData;
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
					if($row["user_name"] <> ' ')
					{
						$userName= ucwords($row["user_name"]);
					}
					else
					{
						$userName = ucwords('No Name');
					}

					$nestedData['email'] = $row["email"];				

					$profileImage=$row['profileImage'];
					if($profileImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'users/thumbs/'.$profileImage))
						{
							$profileImage = '<img width="50" height="50" src="'.file_upload_base_url().'users/thumbs/'.$profileImage.'">';
						}
						else
						{
							$profileImage = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
						}
					}
					else
					{
						$profileImage = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
					}
					$companyLogo=$row['companyLogo'];
					if($companyLogo <> '')
					{
						if(file_exists(file_upload_absolute_path().'companyLogos/thumbs/'.$companyLogo))
						{
							$companyLogo = '<img width="50" height="50" src="'.file_upload_base_url().'companyLogos/thumbs/'.$companyLogo.'">';
						}
						else
						{
							$companyLogo = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
						}
					}
					else
					{
						$companyLogo = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
					}
					$job_type1=(!empty($row["job_type1"]) && $row["job_type1"]==1)?'Internship':'Job';
					$nestedData['user_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/>';
					$nestedData['jobInfo'] = $companyLogo.'<br/><a target="_blank" href="'.front_base_url().'job/jobDetail/'.$row["jobId"].'">'.$row['companyName'].'</a><br/><b>Job : </b>'.$row["title"].'<br/><b>Job type: </b>'.$job_type1.'<br/>';	

					$nestedData['created'] = date("d-M-Y", strtotime($row["apply_date"]));						
					$nestedData['jobEndDate'] = date("d-M-Y", strtotime($row["close_on"]));		
					if(isset($row['comment1']) && !empty($row['comment1']))
					{
						$comment1=$row['comment1'];
					}
					else
					{
						$comment1='';
					}
					if($row['apply_status'] == 0)
					{
						$nestedData['status']='<span class="label label-success" onclick="change_status('.$row['id'].',1)" style="cursor: pointer;">Approve Application</span><br /><span class="label label-danger" onclick="change_status('.$row['id'].',2)" style="cursor: pointer;">Reject Application</span><br /><span >'.$comment1.'</span>';	
					}	
					else
					{
						if($row['apply_status'] == 1)
						{
							$nestedData['status']='<span class="label label-success">Approved</span>';		
						}
						else
						{
							$nestedData['status']='<span class="label label-danger">Rejected</span>';		
						}
					}											
						
					$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>';
					
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
			//echo $this->db->last_query();
	}


	function change_status($id,$status='')
	{
		$get_temp_data = $this->db->select('*')->from('job_user_relation_admin_approval')->where('id',$id)->get()->row_array();			
		$RecruiterEmailId = $this->db->select('recruiter_email_id')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();	
		$jobDetails=$this->db->select('*')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();
		$jobName=$jobDetails['title'];
		
		$userDetails=$this->modelbasic->loggedInUserInfoById($get_temp_data['userId']);	
		
		// get rah detials 
		$find_RPH=$this->job_approval_model->find_admin_level($userDetails['instituteId'],'5');
		
		$comment = '';
		$res = 0;
		if($status != '')
		{
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');	
			if ($this->form_validation->run())
			{
				$comment = $_POST['comment'];
			}
			else
			{
				if($this->input->is_ajax_request())
				{
					echo $this->form_validation->get_json();
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Admin please try again...');
					echo json_encode($data);
				}
			}
			$res=$this->job_approval_model->_update_status("job_user_relation",$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>12));			
			$this->job_approval_model->_update('job_user_relation_admin_approval',$id,array('apply_status'=>2,'comment'=>$comment));	
		}
		else
		{
			$job_user_relation_data = array('resume' => $get_temp_data['resume'],'userId' => $get_temp_data['userId'],'jobId' => $get_temp_data['jobId'],'apply_status' => 13,'apply_date' => $get_temp_data['apply_date'],'modified_date' => $get_temp_data['modified_date']);
			$res=$this->job_approval_model->add("job_user_relation",$job_user_relation_data);

			$data=array('userId'=>$get_temp_data['userId'],"rphadmin_id"=>$find_RPH->hoadmin_id,'jobId'=>$get_temp_data['jobId'],'resume'=>'','apply_date'=>$get_temp_data['apply_date'],'institute_id'=>$get_temp_data['institute_id'],"apply_status"=>0);   
			$res=$this->job_approval_model->add("job_user_relation_rph_approval",$data);			
			$this->job_approval_model->_update('job_user_relation_admin_approval',$id,array('apply_status'=>1,'comment'=>$comment));
		}

		
		$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));	
		$getInstituteRPHInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->where('A.email',$find_RPH->email)->get()->row();
		//$getInstituteAdminInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->join('institute_master as B','B.adminId = A.id')->where('B.id',$get_temp_data['institute_id'])->get()->row();
		//print_r($getInstituteHoAdminInfo);
		if($res > 0)
		{		
			//send mail to RPH along with notification		
			$notificationEditEntryRPHAdmin=array('title'=>'Someone has applied for the job and admin approved application(Pending For RPH Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdrphAdmin=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryRPHAdmin);
			
			$insertJobNotificationrphAdmin = array('notification_id'=>$notificationIdrphAdmin,'user_id'=>$getInstituteRPHInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationrphAdmin);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job admin approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteRPHInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

			//send mail to user along with notification
			$notificationEditEntryUser=array('title'=>'Your Job Application Approved By Admin (Pendig For RPH Approve)','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Approved by admin.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);
			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);
			
			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have successfully applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Successfully applied for job.(Approv By Admin)','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);
		}
		else
		{
			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have  applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Your Application for job is Rejected By Admin.<br />Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Your Application for job is Rejected By Admin','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);

			$notificationEditEntryUser=array('title'=>'Your Job Application Rejected By Admin','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Rejected admin.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);

			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);
		}
		redirect('admin/job_approval','refresh');
	}

	function change_status_byrah($id,$status='')
	{
		$get_temp_data = $this->db->select('*')->from('job_user_relation_rahadmin_approval')->where('id',$id)->get()->row_array();		
		//print_r($get_temp_data);die();	
		$RecruiterEmailId = $this->db->select('recruiter_email_id')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();	
		$jobDetails=$this->db->select('*')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();
		$jobName=$jobDetails['title'];
		
		$userDetails=$this->modelbasic->loggedInUserInfoById($get_temp_data['userId']);			
		//RPH Details
		$find_admin_level=$this->job_approval_model->find_admin_level($userDetails['instituteId'],'5');

		$comment = '';
		$res = 0;
		if($status != '')
		{
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');	
			if ($this->form_validation->run())
			{
				$comment = $_POST['comment'];
			}
			else
			{
				if($this->input->is_ajax_request())
				{
					echo $this->form_validation->get_json();
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Admin please try again...');
					echo json_encode($data);
				}
			}
			$this->job_approval_model->_update_status('job_user_relation_admin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>2,'comment'=>$comment));	
			$this->job_approval_model->_update_status('job_user_relation_rahadmin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>2,'comment'=>$comment));	
			$this->job_approval_model->_update_status("job_user_relation",$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>14));			
		}
		else
		{			
			$data=array('userId'=>$get_temp_data['userId'],"rphadmin_id"=>$find_admin_level->hoadmin_id,'jobId'=>$get_temp_data['jobId'],'resume'=>'','apply_date'=>$get_temp_data['apply_date'],'institute_id'=>$get_temp_data['institute_id'],"apply_status"=>0);   
			$res=$this->job_approval_model->add("job_user_relation_rph_approval",$data);
			
			$this->job_approval_model->_update_status("job_user_relation",$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>13));			
			$this->job_approval_model->_update_status('job_user_relation_admin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>1,'comment'=>$comment));
			$this->job_approval_model->_update_status('job_user_relation_rahadmin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>1,'comment'=>$comment));
		}		
		$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));	
		$getInstituteRPHInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->where('A.email',$find_admin_level->email)->get()->row();
		$getInstituteAdminInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->join('institute_master as B','B.adminId = A.id')->where('B.id',$get_temp_data['institute_id'])->get()->row();
		if($res > 0)
		{		
			//send mail to RPH along with notification		
			$notificationEditEntryrph=array('title'=>'Rah Approved Application(Pending For RPH Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationrph=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryrph);
			$insertJobNotificationrph = array('notification_id'=>$notificationrph,'user_id'=>$getInstituteRPHInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationrph);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RAH approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteRPHInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

			//send mail to admin along with notification		
			$notificationEditEntryadmin=array('title'=>'Rah Approved Application(Pending For RPH Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationadmin=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryadmin);
			$insertJobNotificationadmin = array('notification_id'=>$notificationadmin,'user_id'=>$getInstituteAdminInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationadmin);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RAH approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteAdminInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

			//send mail to user along with notification
			$notificationEditEntryUser=array('title'=>'Your Job Application Approved By RAH (Pendig RPH Approve)','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Approved by RAH.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);
			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);
			
			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have successfully applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Successfully applied for job.(Approv By Admin)','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);
		}
		else
		{			
			//send mail to admin along with notification		
			$notificationEditEntryadmin=array('title'=>'RAH Rejected Application','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationadmin=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryadmin);
			$insertJobNotificationadmin = array('notification_id'=>$notificationadmin,'user_id'=>$getInstituteAdminInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationadmin);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RAH Rejected job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteAdminInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

			//send mail to USER along with notification
			$notificationEditEntryUser=array('title'=>'Your Job Application Rejected By RAH','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Rejected RAH.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);
			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);

			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have  applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Your Application for job is Rejected By RAH.<br />Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Your Application for job is Rejected By RAH','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);

		}
		redirect('admin/job_approval','refresh');
	}

	
	function change_status_byrph($id,$status='')
	{
		$get_temp_data = $this->db->select('*')->from('job_user_relation_rph_approval')->where('id',$id)->get()->row_array();			
		$RecruiterEmailId = $this->db->select('recruiter_email_id')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();	
		$jobDetails=$this->db->select('*')->from('jobs')->where('id',$get_temp_data['jobId'])->get()->row_array();
		$jobName=$jobDetails['title'];
		
		$userDetails=$this->modelbasic->loggedInUserInfoById($get_temp_data['userId']);			
		//RPH Details
		$find_employer=$this->job_approval_model->find_employer($get_temp_data['jobId']);
		//echo $this->db->last_query();die();
		$find_rah=$this->job_approval_model->find_admin_level($userDetails['instituteId'],'4');

		$comment = '';
		$res = 0;
		if($status != '')
		{
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');	
			if ($this->form_validation->run())
			{
				$comment = $_POST['comment'];
			}
			else
			{
				if($this->input->is_ajax_request())
				{
					echo $this->form_validation->get_json();
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Admin please try again...');
					echo json_encode($data);
				}
			}
			$this->job_approval_model->_update_status('job_user_relation_admin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>2,'comment'=>$comment));	
			//$this->job_approval_model->_update_status('job_user_relation_rahadmin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>2,'comment'=>$comment));	
			$this->job_approval_model->_update_status('job_user_relation_rph_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>2,'comment'=>$comment));	
			$this->job_approval_model->_update_status("job_user_relation",$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>16));			
		}
		else
		{			
			$data=array('userId'=>$get_temp_data['userId'],"employer_id"=>$find_employer->id,'jobId'=>$get_temp_data['jobId'],'resume'=>'','apply_date'=>$get_temp_data['apply_date'],'institute_id'=>$get_temp_data['institute_id'],"apply_status"=>0);   
			$res=$this->job_approval_model->add("job_user_relation_employer_approval",$data);
			
			$this->job_approval_model->_update_status("job_user_relation",$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>15));			
			$this->job_approval_model->_update_status('job_user_relation_admin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>1,'comment'=>$comment));
			//$this->job_approval_model->_update_status('job_user_relation_rahadmin_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>1,'comment'=>$comment));
			$this->job_approval_model->_update_status('job_user_relation_rph_approval',$userDetails['id'],$get_temp_data['jobId'],array('apply_status'=>1,'comment'=>$comment));
		}		
		$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));	
		$getInstituteRAHInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->where('A.email',$find_rah->email)->get()->row();
		$getInstituteAdminInfo = $this->db->select('A.id,A.firstName,A.lastName,A.email')->from('users as A')->join('institute_master as B','B.adminId = A.id')->where('B.id',$get_temp_data['institute_id'])->get()->row();
		if($res > 0)
		{	
			//send mail to Empoyer along with notification	
			$notificationEditEntryemployer=array('title'=>'RPH Approved Application(Pending For Employer Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationrah=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryemployer);
			$insertJobNotificationemployer = array('notification_id'=>$notificationrah,'user_id'=>$find_employer->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationemployer);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RAH approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.front_base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$find_employer->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

		/*
			//send mail to RH along with notification	
			$notificationEditEntryrah=array('title'=>'RPH Approved Application(Pending For Employer Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationrah=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryrah);
			$insertJobNotificationrah = array('notification_id'=>$notificationrah,'user_id'=>$getInstituteRAHInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationrah);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RAH approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteRAHInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			$this->modelbasic->sendMail($data);*/


			//send mail to admin along with notification		
			$notificationEditEntryadmin=array('title'=>'RPH Approved Application(Pending For Employer Approval) ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationadmin=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryadmin);
			$insertJobNotificationadmin = array('notification_id'=>$notificationadmin,'user_id'=>$getInstituteAdminInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationadmin);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RPH approved job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteAdminInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);


			//send mail to user along with notification
			$notificationEditEntryUser=array('title'=>'Your Job Application Approved By RPH (Pendig Employer Approve)','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Approved by RPH.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);
			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);
			
			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have successfully applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Successfully applied for job.(Approv By Admin)','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);
		}
		else
		{			
			
			//send mail to RH along with notification	
			/*	$notificationEditEntryrah=array('title'=>'RPH Rejected Application ','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationrah=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryrah);
			$insertJobNotificationrah = array('notification_id'=>$notificationrah,'user_id'=>$getInstituteRAHInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationrah);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RPH Rejected application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteRAHInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			$this->modelbasic->sendMail($data);*/


			//send mail to admin along with notification		
			$notificationEditEntryadmin=array('title'=>'RPH Rejected Application','msg'=>ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' Has applied for job '.$jobName.' posted on creosouls.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationadmin=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryadmin);
			$insertJobNotificationadmin = array('notification_id'=>$notificationadmin,'user_id'=>$getInstituteAdminInfo->id,'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationadmin);
			
			$template='Hello,<br/><br/> '.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).' has applied for the job RPH Rejected job application.<b>'.$jobName.' </b><br/><br/><a href="'.base_url().'user/userDetail/'.$get_temp_data['userId'].'">Click here</a> to see his portfolio.';				
			$data=array('fromEmail'=>$userDetails['email'],'to'=>$getInstituteAdminInfo->email,'cc'=>$emailFrom,'subject'=>'Someone has applied for the job.','template'=>$template);	
			//$this->modelbasic->sendMail($data);

			//send mail to USER along with notification
			$notificationEditEntryUser=array('title'=>'Your Job Application Rejected By RPH','msg'=>'Your Application for job '.$jobName.' posted on creosouls is Rejected RPH.','link'=>'job/jobDetail/'.$get_temp_data['jobId'],'imageLink'=>'companyLogos/thumbs/'.$jobDetails['companyLogo'],'created'=>date('Y-m-d H:i:s'),'typeId'=>1,'redirectId'=>$get_temp_data['jobId']);
			$notificationIdUser=$this->modelbasic->_insert('header_notification_master',$notificationEditEntryUser);
			$insertJobNotificationUser = array('notification_id'=>$notificationIdUser,'user_id'=>$get_temp_data['userId'],'status'=>0);
			$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotificationUser);

			$templateForApplicant='Hello <b>'.ucfirst($userDetails['firstName']).' '.ucfirst($userDetails['lastName']).'</b>,<br/> You have  applied for the job <b>'.$jobName.' at '.$jobDetails['companyName'].'. </b><br/>Your Application for job is Rejected By RAH.<br />Thank you! We will get back to you soon.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			$dataApplicant=array('fromEmail'=>$emailFrom,'to'=>$userDetails['email'],'subject'=>'Your Application for job is Rejected By RPH','template'=>$templateForApplicant);
			//$this->modelbasic->sendMail($dataApplicant);

		}
		redirect('admin/job_approval','refresh');
	}
}
