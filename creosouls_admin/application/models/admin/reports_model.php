<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function manage_institute_users_reports($instituteId='',$export='')
    {
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select("users.id,CONCAT(users.firstName,' ',users.lastName) as CandidateName,users.instituteId, COUNT(case project_master.status when '1' then 1 else null end) as Public ,COUNT(case project_master.status when '2' then 1 else null end) as Incomplit,COUNT(case project_master.status when '3' then 1 else null end) as Private,COUNT(case project_master.status when '0' then 1 else null end) as Draft,COUNT(project_master.id) as TotalProjectCount,institute_csv_users.first_login_date as FirstLoginDate,institute_csv_users.registration_date as RegistrationDate",FALSE);
    	$this->db->from('users');		
        $this->db->join('project_master', 'project_master.userId = users.id', 'left');
        $this->db->join('institute_csv_users', 'institute_csv_users.email = users.email', 'left');

	    if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
	    {
	    	$this->db->where('users.instituteId',$instituteId);	
	    } 
	    if($this->session->userdata('admin_level') == 4)
	    {
	    	$this->db->where_in('users.instituteId',$ins);	
	    }    
	    $this->db->group_by('users.id');	  
		$query = $this->db->get()->result_array();

		if($export !='' && $export='export')
		{
			if(!empty($query))
			{
				foreach ($query as $key => $value) {
					$query[$key]['id'] = ($key+1);
					unset($query[$key]['email']);
					unset($query[$key]['instituteId']);
				}
			}
			return $query;

		}
		else
		{			
			return $query;
		}

    }


	function manage_assignment_reports($instituteId='',$export='')
 	{		
 		if($this->session->userdata('admin_level') == 4)
 		{
 			$ins=$this->modelbasic->getHoadminInstitutes();
 		}
 		$this->db->select("u.id as ID,CONCAT(u.firstName,' ',u.lastName) as StudentName,asi.assignment_name as AssignmentName,asi.start_date as StartDate,asi.end_date as EndDate,DATE(asi.created) as SubmissionDate,pm.assignment_accepted_date as ApprovalDate,
 		  CASE pm.assignment_status
 		    when 1 then 'Submitted'
 		    when 2 then 'Pending'
 		    when 3 then 'Accepted'
 		    when 4 then 'Re-Submitted'  
 		    ELSE 'Not Submitted'
 		 END as AssignmentStatus",FALSE);

 		$this->db->from('users as u');	
 		$this->db->join('user_assignment_relation as uar', 'uar.user_id = u.id');
 		$this->db->join('assignment as asi', 'asi.id = uar.assignment_id');
 		$this->db->join('project_master as pm', '(pm.assignmentId = uar.assignment_id AND pm.userId = uar.user_id','left');
 		if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
 		{
 			$this->db->where('u.instituteId',$instituteId);	
 		} 
 		if($this->session->userdata('admin_level') == 4)
 		{
 			$this->db->where_in('u.instituteId',$ins);	
 		}		
 		$this->db->order_by('u.firstName');
 	    $query = $this->db->get()->result_array();
 		//return $query;

 		if($export !='' && $export='export')
 		{
 			if(!empty($query))
 			{
 				foreach ($query as $key => $value) {
 					$query[$key]['ID'] = ($key+1); 					
 				}
 			}
 			return $query;

 		}
 		else
 		{			
 			return $query;
 		}

 	}



 	function manage_institute_statitstics_reports($instituteId='')
 	{
 	    	if($this->session->userdata('admin_level') == 4)
 	    	{
 	    		$ins=$this->modelbasic->getHoadminInstitutes();
 	    	}
			$this->db->select('COUNT(users.id) as TotalNumberofUsers')->from('users');
			if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
			{
				$this->db->where('instituteId',$instituteId);	
			}
			if($this->session->userdata('admin_level') == 4)
			{
				$this->db->where_in('instituteId',$ins);	
			}
			$TotalNumberofUsers = $this->db->get()->row_array();


			$this->db->select('COUNT(competitions.id) as TotalCompetitions')->from('competitions');
			if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
			{
				$this->db->where('instituteId',$instituteId);	
			}
			if($this->session->userdata('admin_level') == 4)
			{
				$this->db->where_in('instituteId',$ins);	
			}
			$TotalCompetitions = $this->db->get()->row_array();

			$this->db->select('COUNT(jobs.id) as TotalJobs')->from('jobs');


			if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
			{
				$this->db->where('posted_by',$instituteId);	
				$this->db->where('admin_level',2);	
			}


			$TotalJobs = $this->db->get()->row_array();

 			$this->db->select("COUNT(project_master.id) as TotalProjectCount,COUNT(case project_master.status when '1' then 1 else null end) as Public ,COUNT(case project_master.status when '2' then 1 else null end) as Incomplit,COUNT(case project_master.status when '3' then 1 else null end) as Private,COUNT(case project_master.status when '0' then 1 else null end) as Draft,users.instituteId",FALSE);

 	    	$this->db->from('users');		
 	        $this->db->join('project_master', 'project_master.userId = users.id', 'left');

 	        $this->db->where('project_master.status !=',2);	
 	       

 		    if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
 		    {
 		    	$this->db->where('users.instituteId',$instituteId);	
 		    }     
 		   	if($this->session->userdata('admin_level') == 4)
 		   	{
 		   		$this->db->where_in('users.instituteId',$ins);	
 		   	}
 			$project = $this->db->get()->row_array();

 			$data = array(array('TotalNumberofUsers'=>$TotalNumberofUsers['TotalNumberofUsers'],'TotalNumberofProjects'=>$project['TotalProjectCount'],'TotalPrivateProjects'=>$project['Private'],'TotalPublicProjects'=>$project['Public'],'TotalDraftProjects'=>$project['Draft'],'TotalCompetitions'=>$TotalCompetitions['TotalCompetitions'],'TotalJobs'=>$TotalJobs['TotalJobs']));
 			return $data;
 	    }

	function manage_job_reports($instituteId='',$export='')
	{
		$this->db->select("jobs.id,jobs.title,DATE(jobs.created) as created,jobs.close_on",FALSE);
		$this->db->from('jobs');				
    	if($this->session->userdata('admin_level') == 2)
		{
			$this->db->where('jobs.posted_by',$instituteId);	
			$this->db->where('jobs.admin_level',2);	
		}
		else if($this->session->userdata('admin_level') == 3)
		{
			//$this->db->where('jobs.posted_by',$instituteId);	
			$this->db->where('jobs.admin_level',3);	
		}
		$query = $this->db->get()->result_array();	
		if(!empty($query))
		{
			foreach ($query as $key => $value) {
				$this->db->select("COUNT(job_user_relation.apply_status) as TotalNumberofApplications,COUNT(case job_user_relation.apply_status when '1' then 1 else null end) as Appalied,COUNT(case job_user_relation.apply_status when '2' then 1 else null end) as Shortlisted,COUNT(case job_user_relation.apply_status when '3' then 1 else null end) as Selected,COUNT(case job_user_relation.apply_status when '4' then 1 else null end) as Accepted,COUNT(case job_user_relation.apply_status when '5' then 1 else null end) as RejectedbyUser,COUNT(case job_user_relation.apply_status when '6' then 1 else null end) as RejectedbyEmploye");
				$this->db->from('job_user_relation');	
				$this->db->where('jobId',$value['id']);
				$query1 = $this->db->get()->row_array();
				$query[$key]['TotalNumberofApplications'] = $query1['TotalNumberofApplications'];	
				$query[$key]['TotalShortlisted'] = $query1['Shortlisted'];	
				$query[$key]['TotalAppalied'] = $query1['Appalied'];	
				$query[$key]['TotalSelected'] = $query1['Selected'];	
				$query[$key]['TotalAccepted'] = $query1['Accepted'];	
				$query[$key]['TotalRejectedbyUser'] = $query1['RejectedbyUser'];	
				$query[$key]['TotalRejectedbyEmploye'] = $query1['RejectedbyEmploye'];					
			}
		}

		if($export !='' && $export='export')
		{
			if(!empty($query))
			{
				foreach ($query as $key => $value) {
					$query[$key]['id'] = ($key+1); 					
				}
			}
			return $query;

		}
		else
		{			
			return $query;
		}	
		
	}


	function export_manage_job_reports($jobId)
	{
		$baseUrl=front_base_url();
		$this->db->select("CONCAT(users.firstName,' ',users.lastName) as CandidateName,users.email as Email,CONCAT('".$baseUrl."user/userDetail/', users.id) as PortfolioLink,institute_master.instituteName as InstituteName,region_list.region_name as RegionName,zone_list.zone_name as ZoneName, case job_user_relation.apply_status
        when '1' then 'Applied'
        when '2' then 'Shortlisted'
        when '3' then 'Selected'
        when '4' then 'Accepted'
        when '5' then 'Rejected by User'
        when '6' then 'Rejected by Employe'
    	end as ApplyStatus",FALSE);
		$this->db->from('job_user_relation');
		$this->db->where('job_user_relation.jobId',$jobId);
	    $this->db->join('users', 'job_user_relation.userId = users.id', 'left');
	    $this->db->join('institute_master', 'institute_master.id = users.instituteId', 'left');
	    $this->db->join('zone_list', 'zone_list.id = institute_master.zone', 'left');
	    $this->db->join('region_list', 'region_list.id = institute_master.region', 'left');
		$query = $this->db->get()->result_array();
		//print_r($query);die;
		return $query;
	}


	function export_manage_job_reports_admin()
	{
		$query = array();
		if($this->session->userdata('admin_level') == 4 || $this->session->userdata('admin_level')==5)
		{
			$regions=$this->modelbasic->getInstituteRegions();
		}
	//	print_r($regions);
		$this->db->select('A.id,A.title,A.location,A.type,A.close_on,A.created,A.status,A.description,A.posted_by,B.job_id,B.region_id,B.zone_id,A.featured,A.companyName',FALSE)->from('jobs as A');		
		$this->db->join('job_zone_relation as B','A.id=B.job_id','left');

		if($this->session->userdata('admin_level')==2)
		{
			$this->db->where('A.posted_by',$this->session->userdata('instituteId'));
		}
		else if($this->session->userdata('admin_level')==3)
		{
			$this->db->where('A.posted_by',$this->session->userdata('admin_id'));
		}
		if($this->session->userdata('admin_level')==4 || $this->session->userdata('admin_level')==5)
		{
			$this->db->where_in('B.region_id',$regions);
		}			
		$this->db->group_by('A.id');
		$this->db->order_by('created','desc');	
		$allJobs = $this->db->get()->result_array();
		//print_r($allJobs);die;
		//echo $this->db->last_query();die;
		$baseUrl=front_base_url();
		$i = 0;

		if(!empty($allJobs))
		{
			foreach ($allJobs as $key => $value) {
				//$string = str_replace(' ', '-', $value['companyName']); // Replaces all spaces with hyphens.
	  		 	$companyName =preg_replace('/[^A-Za-z0-9\-]/', '', $value['companyName']); // Removes special chars.
				$this->db->select("'".$value['title']."' as JobTitie,'".$companyName."' as CompanyName,'".$value['close_on']."' as JobCloseDate,institute_master.instituteName as InstituteName,CONCAT(users.firstName,' ',users.lastName) as CandidateName,users.age,users.contactNo,users.email as Email,CONCAT('".$baseUrl."user/userDetail/', users.id) as PortfolioLink,job_user_relation_admin_approval.jobId,users.id as userId,job_user_relation_admin_approval.apply_date as AppalyDate,job_user_relation_admin_approval.modified_date as ApproveOrRejectDate,case job_user_relation_admin_approval.apply_status when '0' then 'Pending' when '1' then 'Applied' when '2' then 'Rejected' end as ApplyStatusAdmin,job_user_relation_admin_approval.comment as ApprovalRejectionComment",FALSE);
			    $this->db->from('job_user_relation_admin_approval');
			    $this->db->where_in('job_user_relation_admin_approval.jobId',$value['id']);
			    if(isset($regions) && !empty($regions))
			    {
			    	$this->db->where_in('institute_master.region',$regions);
			    }
			    $this->db->join('users', 'job_user_relation_admin_approval.userId = users.id', 'left');
			  //  $this->db->join('users_skills', 'users.id = users_skills.user_id', 'left');
			    $this->db->join('institute_master', 'institute_master.id = users.instituteId', 'left');
			    $this->db->join('zone_list', 'zone_list.id = institute_master.zone', 'left');
			    $this->db->join('region_list', 'region_list.id = institute_master.region', 'left');
				$data = $this->db->get()->result_array();
				//echo $this->db->last_query();	
				if(!empty($data))
				{
					foreach ($data as $keyData => $valueData) {	

						$Apply_date=$valueData['AppalyDate'];				
						$ApproveOrRejectDate=$valueData['ApproveOrRejectDate'];			
						$ApprovalRejectionComment=$valueData['ApprovalRejectionComment'];

						unset($valueData['AppalyDate']);
						unset($valueData['ApproveOrRejectDate']);
						unset($valueData['ApplyStatusAdmin']);
						unset($valueData['ApprovalRejectionComment']);

						$this->db->select("GROUP_CONCAT(skillName) AS ShowreelLink",FALSE);
						$this->db->from('users_skills');
						$this->db->where('user_id',$valueData['userId']);
						$skilldata = $this->db->get()->row_array();
						
						if(!empty($skilldata))
						{
							$valueData['UserSkills'] = $skilldata['ShowreelLink'];
						}
						else
						{
							$valueData['UserSkills'] = '';
						}

						$this->db->select("CONCAT('".$baseUrl."projectDetail/', project_master.projectPageName) as ShowreelLink",FALSE);
						$this->db->from('project_master');
						$this->db->where('userId',$valueData['userId']);
						$this->db->where('showreel','1');
						$projectdata = $this->db->get()->row_array();
						
						if(!empty($projectdata))
						{
							$valueData['ShowreelLink'] = $projectdata['ShowreelLink'];
						}
						else
						{
							$valueData['ShowreelLink'] = '';
						}
						$valueData['AppalyDate']=$Apply_date;
						$valueData['ApproveOrRejectDate']=$ApproveOrRejectDate;
						$valueData['ApprovalRejectionComment']=$ApprovalRejectionComment;

					$this->db->select(" case job_user_relation.apply_status
		    		        when '1' then 'Applied'
		    		        when '2' then 'Shortlisted'
		    		        when '3' then 'Selected'
		    		        when '4' then 'Accepted'
		    		        when '5' then 'Rejected by User'
		    		        when '6' then 'Rejected by Employer'
		    		        when '11' then 'Approved By Admin'
		    		        when '12' then 'Rejected By Admin'
		    		        when '13' then 'Approved By Ho/RAH'
		    		        when '14' then 'Rejected By Ho/RAH'
		    		        when '15' then 'Approved By RPH'
		    		        when '16' then 'Rejected By RPH'
		    		        when '18' then 'Test Assign'
		    		    end as ApplyStatus",FALSE);
						$this->db->from('job_user_relation');
						$this->db->where('jobId',$valueData['jobId']);
						$this->db->where('userId',$valueData['userId']);
						$jobUserRelStatus = $this->db->get()->row_array();
						
						if(!empty($jobUserRelStatus))
						{
							$valueData['CurrentStatus'] = $jobUserRelStatus['ApplyStatus'];
						}
						else
						{
							$valueData['CurrentStatus'] = 'Pending';
						}
						
						/*$valueData['AppalyDate'] = date("Y-m-d",$valueData['AppalyDate']);
						$valueData['ApproveOrRejectDate'] = date("Y-m-d",$valueData['ApproveOrRejectDate']);*/
						unset($valueData['jobId']);
						unset($valueData['userId']);

						$query[$i] =$valueData;
						$i++;						
					}
				}						
			}
		}
		return $query;
	}


	function manage_feedback_reports($instituteId='',$export='')
	{		
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select("fi.id,im.instituteName,fi.name as FeedbackInstanceName,fi.start_session as StartDate,fi.end_session as EndDate,fi.institute_id",FALSE);
		$this->db->from('feedback_instance as fi');
		$this->db->join('institute_master as im','fi.institute_id = im.id');
	    if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
	    {	    	
	    	$this->db->where('fi.institute_id',$instituteId);	
	    }
	    if($this->session->userdata('admin_level') == 4)
	    {
	    	$this->db->where_in('fi.institute_id',$ins);
	    } 
	    $this->db->order_by('fi.institute_id');	
		$query = $this->db->get()->result_array();
		//print_r($query);die;
		if(!empty($query))
		{
			foreach ($query as $key => $value) {

				$this->db->select('COUNT(users.id) as TotalNumberofUsers');
				$this->db->from('users');
				$this->db->where('instituteId',$value['institute_id']);
				$totalNoOfUser = $this->db->get()->row_array();

				$this->db->select('COUNT(institutefeedback.id) as TotalNumberofFeedbackUsers');
				$this->db->from('institutefeedback');
				$this->db->where('institute_id',$value['institute_id']);
				$this->db->where('instance_id',$value['id']);
				$TotalFeedbackReceived = $this->db->get()->row_array();				
				$query[$key]['TotalFeedbackReceived']= $TotalFeedbackReceived['TotalNumberofFeedbackUsers'];
				$query[$key]['TotalFeedbackPending']= $totalNoOfUser['TotalNumberofUsers']-$TotalFeedbackReceived['TotalNumberofFeedbackUsers'];
				unset($query[$key]['institute_id']);
			}
		}

		if($export !='' && $export='export')
		{
			if(!empty($query))
			{
				foreach ($query as $key => $value) {
					$query[$key]['id']= ($key+1);					
					unset($query[$key]['FeedbackInstanceId']);
				}
			}
			return $query;

		}
		else
		{			
			return $query;
		}
	}

	function export_single_feedback_reports($feedbackId)
	{
		$query='';
		for($i=1;$i<17;$i++)
		{
			$query.="COUNT(case institutefeedback.q$i when 'Never' then 1 else null end) as q".$i."Never,COUNT(case institutefeedback.q$i when 'Sometimes' then 1 else null end) as q".$i."Sometimes,COUNT(case institutefeedback.q$i when 'Frequently' then 1 else null end) as q".$i."Frequently,COUNT(case institutefeedback.q$i when 'Mostly' then 1 else null end) as q".$i."Mostly,";			
		}

		$query.="COUNT(case institutefeedback.q17 when 'Excellent' then 1 else null end) as q17Excellent,COUNT(case institutefeedback.q17 when 'Good' then 1 else null end) as q17Good,COUNT(case institutefeedback.q17 when 'Average' then 1 else null end) as q17Average,COUNT(case institutefeedback.q17 when 'Fair' then 1 else null end) as q17Fair,";

		$query.="COUNT(case institutefeedback.q18 when 'Never' then 1 else null end) as q18Never,COUNT(case institutefeedback.q18 when 'Sometimes' then 1 else null end) as q18Sometimes,COUNT(case institutefeedback.q18 when 'Frequently' then 1 else null end) as q18Frequently,COUNT(case institutefeedback.q18 when 'Mostly' then 1 else null end) as q18Mostly,";

		$query.="COUNT(case institutefeedback.q19 when 'Excellent' then 1 else null end) as q19Excellent,COUNT(case institutefeedback.q19 when 'Good' then 1 else null end) as q19Good,COUNT(case institutefeedback.q19 when 'Average' then 1 else null end) as q19Average,COUNT(case institutefeedback.q19 when 'Fair' then 1 else null end) as q19Fair,";

		//echo $query;die;

		$this->db->select($query);
		$this->db->from('institutefeedback');
		$this->db->where('instance_id',$feedbackId);
		if($this->session->userdata('admin_level') != 1)
		{
			$instituteId = $this->session->userdata('instituteId');
			$this->db->where('institute_id',$instituteId);	
		} 
		$feedback = $this->db->get()->row_array();

		$result=array();

		$questions=array('Did your class ever cancel due to absence of faculty?','Were you issued courseware for the module(s) being taught?','Do theory classes start and end at right time?','Are the modules taken as per the timetable?','Does the faculty teach concepts and clear doubts to your satisfaction?','Does the theory class get conducted OHP or terminal?','Your understanding of the topics covered?','Is technical assistance always available in the lab?','Are you assisted for the lab exercises given in the courseware?','Were you able to workout lab exercises with faculty’s help in the lab?','Do you always get a machine to work during the regular lab hours?','Have you encountered a problem with respect to the software in the lab?','Have you encountered a problem with respect to the machine in the lab?','Does machine problems get sorted within a stipulated time?','Are the assignments and examinations conducted as per the schedule?','Are you evaluated after each module (test /assignment/ quiz)','Your satisfaction level with respect to faculty guidance on the project.','Is the feedback taken from you at least once a month?','Relevance and adequacy of examples used by the faculty while teaching.');
		for($i=0;$i<16;$i++)
		{
			$result[$i]['question']=$questions[$i];
			$result[$i]['option1']='Never - '.$feedback['q'.($i+1).'Never'];
			$result[$i]['option2']='Sometimes - '.$feedback['q'.($i+1).'Sometimes'];
			$result[$i]['option3']='Frequently - '.$feedback['q'.($i+1).'Frequently'];
			$result[$i]['option4']='Mostly - '.$feedback['q'.($i+1).'Mostly'];
		}

		$result[16]['question']=$questions[16];
		$result[16]['option1']='Excellent - '.$feedback['q17Excellent'];
		$result[16]['option2']='Good - '.$feedback['q17Good'];
		$result[16]['option3']='Average - '.$feedback['q17Average'];
		$result[16]['option4']='Fair - '.$feedback['q17Fair'];

		$result[17]['question']=$questions[17];
		$result[17]['option1']='Never - '.$feedback['q18Never'];
		$result[17]['option2']='Sometimes - '.$feedback['q18Sometimes'];
		$result[17]['option3']='Frequently - '.$feedback['q18Frequently'];
		$result[17]['option4']='Mostly - '.$feedback['q18Mostly'];

		$result[18]['question']=$questions[18];
		$result[18]['option1']='Excellent - '.$feedback['q19Excellent'];
		$result[18]['option2']='Good - '.$feedback['q19Good'];
		$result[18]['option3']='Average - '.$feedback['q19Average'];
		$result[18]['option4']='Fair - '.$feedback['q19Fair'];

		return $result;

	}

	function manage_individual_feedback_reports($instituteId='',$export='')
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$this->db->select("users.id,users.id as userId,feedback_instance.id as instanceId,CONCAT(users.firstName,' ',users.lastName) as CandidateName,feedback_instance.name as FeedbackInstanceName,DATE(institutefeedback.created) as FeedbackSubmittedDate",FALSE);
		$this->db->from('feedback_instance');		
		$this->db->join('institutefeedback', 'feedback_instance.id = institutefeedback.instance_id');
		$this->db->join('users', 'institutefeedback.user_id = users.id');
		if($this->session->userdata('admin_level') != 1 && $this->session->userdata('admin_level') != 4)
		{
			$this->db->where('feedback_instance.institute_id',$instituteId);	
		}
		if($this->session->userdata('admin_level') == 4)
		{
			$this->db->where_in('feedback_instance.institute_id',$ins);
		} 
		$feedback = $this->db->get()->result_array();
		//print_r($feedback);die;
		//return $feedback;
		if($export !='' && $export='export')
		{
			if(!empty($feedback))
			{
				foreach ($feedback as $key => $value) {
					$feedback[$key]['id'] = ($key+1);
					unset($feedback[$key]['userId']);
					unset($feedback[$key]['instanceId']);
				}
			}
			return $feedback;

		}
		else
		{			
			return $feedback;
		}

	}

	function export_single_user_feedback_reports($userId,$instanceId)
	{
		$this->db->select('*');
		$this->db->from('institutefeedback');
		$this->db->where('instance_id',$instanceId);
		$this->db->where('user_id',$userId);	 
		$feedback = $this->db->get()->row_array();
		$result=array();
		$questions=array('Did your class ever cancel due to absence of faculty?','Were you issued courseware for the module(s) being taught?','Do theory classes start and end at right time?','Are the modules taken as per the timetable?','Does the faculty teach concepts and clear doubts to your satisfaction?','Does the theory class get conducted OHP or terminal?','Your understanding of the topics covered?','Is technical assistance always available in the lab?','Are you assisted for the lab exercises given in the courseware?','Were you able to workout lab exercises with faculty’s help in the lab?','Do you always get a machine to work during the regular lab hours?','Have you encountered a problem with respect to the software in the lab?','Have you encountered a problem with respect to the machine in the lab?','Does machine problems get sorted within a stipulated time?','Are the assignments and examinations conducted as per the schedule?','Are you evaluated after each module (test /assignment/ quiz)','Your satisfaction level with respect to faculty guidance on the project.','Is the feedback taken from you at least once a month?','Relevance and adequacy of examples used by the faculty while teaching.');
		for($i=0;$i<19;$i++)
		{
			$result[$i]['question']=$questions[$i];
			$result[$i]['option']=$feedback['q'.($i+1)];		
		}

		return $result;
	}

	Public function getstudent_data($institute_id,$start_date,$end_date,$student_status,$zone,$region)
	{
		$whr='';
		if(isset($zone) && !empty($zone) && $zone!='All')$whr=$whr."im.zone=".$zone.' AND ';
		if(isset($region) && !empty($region) && $region!='All')$whr=$whr."im.region=".$region.' AND ';
		if(isset($institute_id) && !empty($institute_id) && $institute_id!='All')$whr=$whr."im.id=".$institute_id.' AND ';
		if(isset($student_status) && $student_status!='')$whr=$whr."u.status=".$student_status." AND ";
		if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))$whr=$whr."icu.registration_date between '".date('Y-m-d',strtotime($start_date))."' AND '".date('Y-m-d',strtotime($end_date))."' AND ";	
		
		$query=$this->db->query("SELECT DISTINCT icu.id,im.instituteName,icu.id,icu.firstName,icu.lastName,icu.studentId,icu.email,icu.registration_date,if(icu.email!='', 'Login', 'Not Login') as login_status  FROM institute_csv_users as icu LEFT JOIN users u on icu.email=u.email  LEFT JOIN institute_master as im on icu.instituteId=im.id LEFT JOIN student_membership sm ON icu.id = sm.csvuserId WHERE $whr date_format( sm.end_date, '%Y-%m-%d' ) > date_format( curdate( ) , '%Y-%m-%d' ) AND icu.studentId!='' AND icu.centerId=1");
		//	echo $this->db->last_query();
		$data      = $query->result_array();
		//print_r($data);
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
                $email= $row['email'];
               if(isset($email) && !empty($email))
               {
               		$query1=$this->db->query("SELECT count(*) as project_cnt,pm.userId AS userID from project_master pm join users u on u.id=pm.userId where u.email='$email'");  
	                $cnt=$query1->row();  
	               // echo $cnt->project_cnt;   	
	            	/*    echo $this->db->last_query();
	                echo $cnt->project_cnt;
	               	echo"-----------------------------";
	                echo "</br>";
	                echo "</br>";*/
					$data[$i]['project_cnt'] = $cnt->project_cnt;
					$data[$i]['userID'] = $cnt->userID;
					$email='';
					$i++;

               }
               else
               {
					$data[$i]['project_cnt'] = '0';
					$data[$i]['userID'] = '';
					$email='';
					$i++;

               }
                
			}	
			return $data;
		}
		else
		{
			return false;
		}
		
	}

	Public function getins_data($zone,$region,$start_date,$end_date,$institute_status)
	{
		$whr='';
		//print_r($start_date);
		if(isset($zone) && $zone!=''  && $zone!='All')$whr=$whr."im.zone=".$zone." AND ";
		if(isset($region) && $region!=''  && $region!='All')$whr=$whr."im.region=".$region." AND ";
		if(isset($institute_status) && $institute_status!='')$whr=$whr."im.status=".$institute_status." AND ";
		if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))$whr=$whr."im.created between ".date('Y-m-d',strtotime($start_date))." AND ".date('Y-m-d',strtotime($end_date))." AND ";	
		
		$query=$this->db->query("SELECT im.id,im.instituteName,im.sap_center_code,us.email,us.firstName,us.lastName,im.created,count( * ) AS enrollcnt, count(CASE WHEN icu.email != ''THEN 1 END ) AS logincnt, CONCAT(round((count(CASE WHEN icu.email != ''THEN 1 END ) / count( * ) ) *100),'%') AS LoginPercentage FROM institute_csv_users icu INNER JOIN institute_master im ON icu.instituteId = im.id INNER JOIN student_membership sm ON icu.id = sm.csvuserId LEFT JOIN users us on us.id=adminId WHERE $whr us.admin_level=2 AND im.status =1 AND icu.centerId =1 AND icu.studentId != ''AND date_format( sm.end_date, '%Y-%m-%d' ) > date_format( curdate( ) , '%Y-%m-%d' ) GROUP BY im.id ORDER BY im.instituteName ASC");
		//echo $this->db->last_query();
		$data      = $query->result_array();
		//print_r($data);
		if(!empty($data))
		{
			$i = 0;
			foreach($data as $row)
			{
               $id= $row['id'];
               if(isset($id) && !empty($id))
               {
               		$query1=$this->db->query("SELECT count(*) as project_cnt from project_master pm join users u on u.id=pm.userId INNER JOIN institute_master im ON u.instituteId = im.id where im.id=$id");  
	                $cnt=$query1->row();  
	               // echo $cnt->project_cnt;   	
	                //echo $this->db->last_query();
					$data[$i]['project_cnt'] = $cnt->project_cnt;
					$i++;
					$email='';
               }
               else
               {
					$data[$i]['project_cnt'] = '0';
					$email='';
               }
                
			}	
			return $data;
		}
		else
		{
			return false;
		}
	}

	Public function SelectActiveInsRegionwise()
	{
		$query=$this->db->query("SELECT rl.region_name,count(*) AS active_cnt FROM institute_master im LEFT JOIN region_list rl ON im.region=rl.id WHERE status=1 GROUP BY rl.id");
		$enroll_qry=$this->db->query("SELECT rl.region_name,count(*) AS enroll_cnt FROM institute_csv_users icu JOIN institute_master im ON icu.instituteId=im.id JOIN region_list rl on im.region=rl.id WHERE studentid!='' GROUP BY rl.id");
		$loged_query=$this->db->query("SELECT rl.region_name,count(*) AS loged_cnt FROM institute_csv_users icu JOIN institute_master im ON icu.instituteId=im.id JOIN region_list rl on im.region=rl.id WHERE first_login_date!='0000-00-00' AND studentid!='' GROUP BY rl.id");
		$project_query=$this->db->query("SELECT rl.region_name,count(*) project_cnt FROM users u JOIN institute_master im ON u.instituteId=im.id JOIN region_list rl on im.region=rl.id JOIN project_master pm on pm.userId=u.id GROUP BY rl.id");
		$pending_project_query=$this->db->query("SELECT rl.region_name,count(*) pendingproject_cnt FROM users u JOIN institute_master im ON u.instituteId=im.id JOIN region_list rl on im.region=rl.id JOIN project_master pm on pm.userId=u.id WHERE pm.admin_status='0' AND pm.status='3' GROUP BY rl.id");
		if($query->num_rows()>=0)
		{
			$res1=$query->result();
			for($i=0;$i<count($res1);$i++)
            {
               if(isset($enroll_qry->result()[$i]->region_name) && $res1[$i]->region_name==$enroll_qry->result()[$i]->region_name)
               {
               		$res1[$i]->enroll_cnt=$enroll_qry->result()[$i]->enroll_cnt;
               }
               else
               {
               		$res1[$i]->enroll_cnt='0';               	
               }
               if(isset($loged_query->result()[$i]->region_name) && $res1[$i]->region_name==$loged_query->result()[$i]->region_name)
               {
               		$res1[$i]->loged_cnt=$loged_query->result()[$i]->loged_cnt;
               }
               else
               {
               		$res1[$i]->loged_cnt='0';               	
               }
               if(isset( $project_query->result()[$i]->region_name) && $res1[$i]->region_name==$project_query->result()[$i]->region_name)
               {
               		$res1[$i]->project_cnt=$project_query->result()[$i]->project_cnt;
               }
               else
               {
               		$res1[$i]->project_cnt='0';               	
               }
                if(isset( $pending_project_query->result()[$i]->region_name) && $res1[$i]->region_name==$pending_project_query->result()[$i]->region_name)
               {
               		$res1[$i]->pendingproject_cnt=$pending_project_query->result()[$i]->pendingproject_cnt;
               }
               else
               {
               		$res1[$i]->pendingproject_cnt='0';               	
               }
               /*
               $res1[$i]->loged_cnt=$loged_query->result()[$i]->loged_cnt;
               $res1[$i]->project_cnt=$project_query->result()[$i]->project_cnt;*/
            }
			return $res1;
		}
		else
		{
			return false;
		}
	}
	
	
	Public function SelectTopStudentRegionwise()
	{
		$query1=$this->db->query("SELECT region_name,id FROM region_list");
		if($query1->num_rows()>=0)
		{
			$region=$query1->result();
			foreach ($region as $key) 
			{
				$tbl_data['region']=$key;
				$query=$this->db->query("SELECT count(*) AS project_cnt,CONCAT(u.firstName,' ',u.lastName) AS name,u.email,im.instituteName from users u LEFT JOIN institute_master im ON u.instituteId=im.id LEFT JOIN region_list rl on im.region=rl.id JOIN project_master pm on pm.userId=u.id WHERE im.region=$key->id GROUP BY rl.id,pm.userId ORDER BY project_cnt DESC limit 5");
				//echo $this->db->last_query();
				if($query->num_rows() > 0)
                {
                    $tbl_data['std_data']=$query->result();
               	}
               	else 
               	{
               		$tbl_data['std_data']=null;
                }
                $data[]=$tbl_data;              
			}
			return  $data;
		}
		else
		{
			return false;
		}
	}

	Public function SelectAll_InstituteData()
	{
		$query1=$this->db->query("SELECT im.id,im.instituteName,a.email as hoeamil_id,if(im.coverImage!='','Uploaded','Not Uploaded') AS coverImage,if(im.instituteLogo!='','Uploaded','Not Uploaded') AS instituteLogo,u.email as adminemail,im.address FROM institute_master im JOIN users u ON im.adminId=u.id JOIN hoadmin_institute_relation hair ON im.id=hair.institute_id JOIN admin a ON hair.hoadmin_id=a.id WHERE im.status=1");
		if($query1->num_rows()>=0)
		{
			return $query1->result();
		}
		else
		{
			return false;
		}
	}

	public function sendMailWithAttachment3($data)
	{
	  $localhost = array(
		    '127.0.0.1',
		    '::1'
		);
		$this->load->library('email');
 		$config = Array(
 		                /*'charset'=>'utf-8',
 		                'wordwrap'=> TRUE,
 		                'mailtype' => 'html'*/
 		                'mailtype' => 'html',
 		                'priority' => '3',
 		                'charset'  => 'utf-8',
 		                'validate'  => TRUE ,
 		                'newline'   => "\r\n",
 		                'wordwrap' => TRUE
 		                
                  			);
	 		if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
	 		{
 		    	$config['protocol']='smtp';
 		    	$config['smtp_host']='ssl://smtp.googlemail.com';
 		    	$config['smtp_port']='465';
 		    	$config['smtp_user']='test.unichronic@gmail.com';
 		    	$config['smtp_pass']='Uspl@123';
 		    	$config['mailtype']='html';
	 		}
			$this->email->initialize($config);
			/*if(isset($data['fromEmail']) && $data['fromEmail']!='')
			{
				$fromEmail 	=	$this->getValue($this->db->dbprefix('admin_users'),"email"," `id` = '1' ");
			}*/
			if(!isset($data['fromName']) || $data['fromName'] == '')
			{
				$fromName 	=	'Creosouls Team';
			}
			else
			{
				$fromName=$data['fromName'];
			}
			$this->email->clear(TRUE);
			$this->email->to($data['to']);
			if(isset($data['cc']) && $data['cc'] !='')
			{
				$this->email->cc($data['cc']);
			}	
			$this->email->from($data['fromEmail'],$fromName);
			$this->email->subject($data['subject']);
			$this->email->message($data['template']);
			$this->email->send();
			echo $this->email->print_debugger();
			pr($data);
			/* if($this->email->send())
				return true;
			else
				return false;*/
		
	}

	Public function getrahrating_data($start_date,$end_date,$rah){
			$selectColumns="CONCAT( u.firstName, ' ', u.lastName ) AS RAHNAME, u.email, im.instituteName,CONCAT( us.firstName, ' ', us.lastName ) AS STUDENTNAME,pm.projectName, pr.rating, pr.created";
			$table = 'users';
			$this->db->select($selectColumns,FALSE)->from($table.' as u');
			$this->db->join('project_rating as pr','pr.userId = u.id');
			$this->db->join('project_master as pm','pr.projectId = pm.id');
			$this->db->join('users as us','pm.userId = us.id');
			$this->db->join('institute_master as im','us.instituteId = im.id');
			$this->db->where('u.status','1');
			$this->db->where('u.admin_level','4');
			if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
			{
				$this->db->where('pr.created BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
			}
			if(isset($rah) && $rah!=''  && $rah!='All')
			{
				//echo $statusfalg; echo $statusval;
				$this->db->where('pr.userId',$rah);
			}
			//echo $this->db->last_query();die;

			return $this->db->get()->result_array();
	}
	Public function gettotalrahrating_data($start_date,$end_date,$rah){
			$selectColumns="CONCAT( u.firstName, ' ', u.lastName ) AS RAHNAME, u.email,COUNT( * ) project_cnt ";
			$table = 'users';
			$this->db->select($selectColumns,FALSE)->from($table.' as u');
			$this->db->join('project_rating as pr','u.id=pr.userId');
			$this->db->where('u.status','1');
			$this->db->where('u.admin_level','4');

			$this->db->group_by('u.id');
			//echo $this->db->last_query();die;
			if(isset($rah) && $rah!=''  && $rah!='All')
			{
				//echo $statusfalg; echo $statusval;
				$this->db->where('pr.userId',$rah);
			}
			return $this->db->get()->result_array();
	}
	public function getrahRate_data($start_date,$end_date,$rah){
			$selectColumns="CONCAT( u.firstName, ' ', u.lastName ) AS RAHNAME, u.email, im.instituteName,CONCAT( us.firstName, ' ', us.lastName ) AS STUDENTNAME,pm.projectName, pr.rating, pr.created";
			$table = 'users';
			$this->db->select($selectColumns,FALSE)->from($table.' as u');
			$this->db->join('project_rating as pr','pr.userId = u.id');
			$this->db->join('project_master as pm','pr.projectId = pm.id');
			$this->db->join('users as us','pm.userId = us.id');
			$this->db->join('institute_master as im','us.instituteId = im.id');
			$this->db->where('u.status','1');
			$this->db->where('u.admin_level','4');
			if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
			{
				$this->db->where('pr.created BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
			}

			if(isset($rah) && $rah!=''  && $rah!='All')
			{
				//echo $statusfalg; echo $statusval;
				$this->db->where('pr.userId',$rah);
			}
			
			 //echo $this->db->last_query();die;

			return $this->db->get()->result_array();
	}
	public function getzonewiseproject_data($start_date,$end_date){
		$selectColumns="z.zone_name, r.region_name, COUNT( * ) project_cnt ";
		$table = 'users';
		$this->db->select($selectColumns,FALSE)->from($table.' as u');
		$this->db->join('project_master as pm','u.id=pm.userId');
		$this->db->join('institute_master as im','u.instituteid=im.id');
		$this->db->join('zone_list as z','im.zone=z.id');
		$this->db->join('region_list as r','im.region=r.id');
		$this->db->group_by('r.id');
		$this->db->order_by('z.zone_name');
		//echo $this->db->last_query();die;
		return $this->db->get()->result_array();
	}
	public function getzonewiseprojecttotal_data($start_date,$end_date,$zone,$region){
		$selectColumns="z.zone_name, r.region_name, im.instituteName, CONCAT( u.firstName, '  ', u.lastName ) AS StudentName, pm.projectName,pm.created";
		$table = 'users';
		$this->db->select($selectColumns,FALSE)->from($table.' as u');
		$this->db->join('project_master as pm','u.id=pm.userId');
		$this->db->join('institute_master as im','u.instituteid=im.id');
		$this->db->join('zone_list as z','im.zone=z.id');
		$this->db->join('region_list as r','im.region=r.id');
		if(isset($zone) && $zone!=''  && $zone!='All')
		{
			$this->db->where('z.id',$zone);
		}
		if(isset($region) && $region!=''  && $region!='All')
		{
			$this->db->where('r.id',$region);
		}
		if(isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date))
		{
			$this->db->where('pm.created BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		$this->db->order_by('z.zone_name');
		//echo $this->db->last_query();die;
		return $this->db->get()->result_array();
	}
	Public function getHoAdmin()
	{

		$query = $this->db->query("SELECT u.id, CONCAT( u.firstName, ' ', u.lastName ) AS RAHNAME
			FROM `users` u WHERE u.admin_level =4 
			AND u.id IN (SELECT userId FROM project_rating)");
			//echo $this->db->last_query();
		if($query->num_rows()>=0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
				
	}
	
	
}