<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('model_basic');
	}
	public function userDetail($user_id)
	{
		$data['user_profile']=$this->user_model->getUserProfileData($user_id);
		$data['project_data']=$this->user_model->getUserProjectData($user_id);
		$data['complete_project']=$this->user_model->getUserCompleteProject($user_id);
		$data['showreel']=$this->user_model->checkshowreel($user_id);
		if(isset($data['showreel']) && !empty($data['showreel']))
		{
			$data['complete_project']=$this->user_model->getUsershowreelProject($user_id);
			//echo $this->db->last_query();
		}
		else
		{
			$data['complete_project']=$this->user_model->getUserCompleteProject($user_id);
			//echo $this->db->last_query();
		}
		$data['work_progress_project']=$this->user_model->getUserWorkProgressProject($user_id);
		$data['appreciated']=$this->user_model->getUserAppreciatedProject($user_id);
		$data['viewed']=$this->user_model->getUserLikedOnProject($user_id);
		$data['discussed']=$this->user_model->getUserCommentedOnProject($user_id);
		$data['view_like_cnt']=$this->user_model->getViewLikeCnt($user_id);
		$data['followers']=$this->user_model->getFollowers($user_id);
		$data['following']=$this->user_model->getFollowing($user_id);
		$data['educationData']=$this->user_model->getUserHighestEducationData($user_id);
		$data['workData']=$this->user_model->getUserWorkData_new($user_id);
		$data['awards']=$this->user_model->getAwardData($user_id);
		$data['testimonials']=$this->user_model->getTestimonials($user_id);
		$username = ucwords($data['user_profile']->firstName).' '.ucwords($data['user_profile']->lastName).'’s Portfolio';
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb',$username);
		$this->session->set_userdata('breadCrumbLink','user/userDetail/'.$user_id);
		$this->load->view('profile_view',$data);
	}
	public function follow_user($uid,$dir)
	{
		 	$result=$this->user_model->checkFollowingOrNot($uid);
			if(empty($result))
			{
			  	$data=array('followingUser'=>$uid,'userId'=>$this->session->userdata('front_user_id'),'created'=>date('Y-m-d H:i:s'));
				$res=$this->user_model->follow_user($data);
				if($res > 0)
				{
					$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
					$followBy=$this->model_basic->loggedInUserInfo();
					$followTo=$this->model_basic->loggedInUserInfoById($uid);
					$nameBy=ucwords($followBy['firstName'].' '.$followBy['lastName']);
					$nameTo=ucwords($followTo['firstName'].' '.$followTo['lastName']);
					$emailBy=$followBy['email'];
					$emailTo=$followTo['email'];
					//$subjectBy='You are now following '.$nameTo.' on creosouls';
					$subjectTo='Congratulations! You have a new follower on creosouls';
					$from=$emailFrom;
					//$templateBy='Hello<b> '.$nameBy. '</b>,<br /> You are now following <b>'.$nameTo.'</b> on creosouls. You will be notified about latest creations by '.$nameTo.'.<br /><a href="'.base_url().'user/userDetail/'.$uid.'">Click here</a> to view '.$nameTo.'‘s profile.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$templateTo='Hello <b>'.$nameTo.'</b>,<br /> <b>'.$nameBy.'</b> started following you on creosouls.<br /><a href="'.base_url().'user/userDetail/'.$this->session->userdata('front_user_id').'">Click here</a> to view '.$nameBy.'‘s profile.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$emailDetailFollowTo=array('to'=>$emailTo,'subject'=>$subjectTo,'template'=>$templateTo,'fromEmail'=>$from);
					//$emailDetailFollowBy=array('to'=>$emailBy,'subject'=>$subjectBy,'template'=>$templateBy,'fromEmail'=>$from);
					$emailSetting=$this->model_basic->getValueArray('user_email_notification_relation','follow_unfollow',array('userId'=>$uid));
					if($emailSetting == 1)
					{
						$this->model_basic->sendMail($emailDetailFollowTo);
					}
					$notificationEntry=array('title'=>'New follower','msg'=>'Now '.$nameBy.' is following you on creosouls.','link'=>'user/userDetail/'.$this->session->userdata('front_user_id'),'imageLink'=>'users/thumbs/'.$followBy['profileImage'],'created'=>date('Y-m-d H:i:s'),'typeId'=>5,'redirectId'=>$this->session->userdata('front_user_id'));
					$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

					$notificationToFollowee=array('notification_id'=>$notificationId,'user_id'=>$uid);
					$this->model_basic->_insert('header_notification_user_relation',$notificationToFollowee);

					$this->session->set_flashdata('success', 'You are now following '.$nameTo);
					if($dir!=''&&$dir!=0)
					{
						if($dir==1)
						{
							redirect('user/userDetail/'.$uid);
						}
						else{
							redirect('project/projectDetail/'.$dir.'/'.$uid);
						}
					}
					else
					{
						redirect('people/index/discover');
					}
				}
				else
				{
					$followTo=$this->model_basic->loggedInUserInfoById($uid);
					$nameTo=ucwords($followTo['firstName'].' '.$followTo['lastName']);
					$this->session->set_flashdata('fail', 'Failed to follow '.$nameTo);
					if($dir==1)
					{
						redirect('user/userDetail/'.$uid);
					}
					else
					{
						redirect('people/index/discover');
					}
				}
			}
			else
			{
				$followTo=$this->model_basic->loggedInUserInfoById($uid);
				$nameTo=ucwords($followTo['firstName'].' '.$followTo['lastName']);
				$this->session->set_flashdata('fail', 'You already following '.$nameTo);
				if($dir==1)
				{
					redirect('user/userDetail/'.$uid);
				}
				else
				{
					redirect('people/index/discover');
				}
			}
	}
	public function unfollow_user($uid,$dir)
	{
       		$res=$this->user_model->unfollow_user($uid);
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$unfollowBy=$this->model_basic->loggedInUserInfo();
				$unfollowTo=$this->model_basic->loggedInUserInfoById($uid);
				$nameBy=ucwords($unfollowBy['firstName'].' '.$unfollowBy['lastName']);
				$nameTo=ucwords($unfollowTo['firstName'].' '.$unfollowTo['lastName']);
				$emailBy=$unfollowBy['email'];
				$subjectBy='You are no more following '.$nameTo.' on creosouls';
				$from=$emailFrom;
				$templateBy='Hello<b> '.$nameBy. '</b>,<br /> You are no more following <b>'.$nameTo.'</b> on creosouls. <br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$emailDetailunfollowBy=array('to'=>$emailBy,'subject'=>$subjectBy,'template'=>$templateBy,'fromEmail'=>$from);
				//$this->model_basic->sendMail($emailDetailunfollowBy);
				$this->session->set_flashdata('success', 'You are no more following '.$nameTo);
				if($dir==1)
				{
					redirect('user/userDetail/'.$uid);
				}
				else
				{
					redirect('people/index/discover');
				}
			}
			else
			{
				$unfollowTo=$this->model_basic->loggedInUserInfoById($uid);
				$nameTo=ucwords($unfollowTo['firstName'].' '.$unfollowTo['lastName']);
				$this->session->set_flashdata('fail', 'Failed to unfollow '.$nameTo);
				if($dir==1)
				{
					redirect('user/userDetail/'.$uid);
				}
				else
				{
					redirect('people/index/discover');
				}
			}
	}
	public function userSkills($user_id)
	{
		$data = array();
		$user_profile = $this->user_model->getUserSkillData($user_id);
		if(!empty($user_profile))
		{
			foreach($user_profile as $row)
			{
				$data[] = $row['skillName'];
			}
			//$data = explode(',',$user_profile['skills']);
		}
		echo json_encode($data);
	}

		
		/*public function import_users_with_data()
		{
			echo '......user.....';	die;	
			$html = '';
			$this->load->library('csvimport');
			$file_path =  file_upload_s3_path().'onboardcsv/usercsv.csv';
			//print_r($file_path);die;
			if ($this->csvimport->get_array($file_path))
			{
			    $csv_array = $this->csvimport->get_array($file_path);		    		    
			    foreach($csv_array as $user)
			    {		    	
			    	$i=1;
			    	$instituteId = $user['Institute Id'];
			    	$firstName = $user['First Name'];
			    	$lastName = $user['Last Name'];
			    	$studentId = $user['Student Id'];
			    	$courseId = $user['Course Id'];
			    	$courseName = $user['Course Name'];
	    	    
			    	$payStatus  = $user['Payment Status'];	
			    	if($payStatus == 0)
			    	{
			    		$paymentStatus = 2;
			    		$course_start_date = date('Y-m-d H:i:s');
			    		$course_end_date = date('Y-m-d H:i:s' ,  strtotime("+30 days")) ;
			    	}
			    	elseif($payStatus == 1)
			    	{
			    		$paymentStatus = 3;
			    		$course_start_date = date('Y-m-d',strtotime($user['Course Start Date']));		    		
			    		$course_end_date = date('Y-m-d', strtotime($user['Course End Date'].' +90 days'));
			    	}	
			    
			    	$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$firstName,'lastName'=>$lastName,'courseId'=>$courseId,'courseName'=>$courseName,'studentId'=>$studentId,'status'=>1,'paymentStatus'=>$paymentStatus,'registration_date'=>date('Y-m-d H:i:s'));

			    	$checkStudentPresent=$this->model_basic->getAllData('institute_csv_users','id',array('instituteId'=>$instituteId,'studentId'=>$studentId));
			    	if(empty($checkStudentPresent))
			    	{
			    		$userId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
			    		$student_membershipData = array('csvuserId'=>$userId,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
			    		$userId=$this->model_basic->_insert('student_membership',$student_membershipData);
			    	}
			    	else{
			    		$html .= $i.' ) '.$studentId.' is allready present . </br>'; 
			    	}   
			    }
			}
			echo $html;
		}
	*/


	public function import_users_with_data()
		{
			echo '......user Arena.....';	die;
		    //$maac = $this->load->database('maac_db', TRUE);		

			$html = '';
			$this->load->library('csvimport');
			$file_path =  file_upload_s3_path().'onboardcsv/usercsv.csv';
			$i=1;
			//print_r($file_path);die;
			if ($this->csvimport->get_array($file_path))
			{
			    $csv_array = $this->csvimport->get_array($file_path);		
			   print_r($csv_array);die;    		    
			    foreach($csv_array as $user)
			    {				    		    
			    		//print_r($user);die;				    	
				    	//$instituteId = $user['Institute Id'];
				    	$instituteName = $user['Institute Id'];
				    	$firstName = $user['First Name'];
				    	$lastName = $user['Last Name'];
				    	$studentId = $user['Student Id'];
				    	$courseId = $user['Course Id'];
				    	$courseName = $user['Course Name'];
				    	$centerId = '1';

				    	$get_instituteId = $this->db->select('id')->from('institute_master')->where('instituteName',$instituteName)->get()->row_array();
				    	//print_r($get_instituteId);die;
				    	if(!empty($get_instituteId))
				    	{
				    			$instituteId = $get_instituteId['id'];
				    			//print_r($instituteId);die;

				    			$payStatus  = $user['Payment Status (0 - Not Paid, 1 - Paid)'];	
				    			if($payStatus == 0)
				    			{
				    				$paymentStatus = 2;
				    				$course_start_date = date('Y-m-d H:i:s');
				    				//$course_end_date = date('Y-m-d H:i:s' ,  strtotime("+30 days")) ;
				    				$course_end_date ='2018-05-02 23:59:59';
				    			}
				    			elseif($payStatus == 1)
				    			{
				    				$paymentStatus = 3;
				    				$course_start_date = date('Y-m-d H:i:s',strtotime($user['Course Start Date']));		    		
				    				$course_end_date = date('Y-m-d H:i:s', strtotime($user['Course End Date'].' +90 days'));
				    			}	
				    			
				    			$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$firstName,'lastName'=>$lastName,'courseId'=>$courseId,'courseName'=>$courseName,'studentId'=>$studentId,'status'=>1,'paymentStatus'=>$paymentStatus,'registration_date'=>date('Y-m-d H:i:s'),'centerId'=>$centerId);

				    			//print_r($userTableArray);die;
				    			$checkStudentPresent=$this->model_basic->getAllData('institute_csv_users','id',array('instituteId'=>$instituteId,'studentId'=>$studentId));

				    			//$checkStudentPresentMaac=$maac->select('*')->from('institute_csv_users')->where('instituteId',$instituteId)->where('studentId',$studentId)->get()->result_array();
				    		//print_r($checkStudentPresentMaac);die;
				    			if(empty($checkStudentPresent))
				    			{
				    				$userId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
				    				$student_membershipData = array('csvuserId'=>$userId,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
				    				$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);

				    			
				    			//	$maac->insert('institute_csv_users',$userTableArray);
				    			//	$userIdMaac= $maac->insert_id();
				    			//	$student_membershipDataMaac = array('csvuserId'=>$userIdMaac,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
				    			//	$memberuserIdMaac=$maac->insert('student_membership',$student_membershipDataMaac);
				    			}
				    			else
				    			{
				    				$checkCourseEndDate = $this->db->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresent[0]['id'])->get()->row_array();

				    			//	$checkCourseEndDateMaac=$maac->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresentMaac[0]['id'])->get()->row_array();

				    				//print_r($checkCourseEndDate);die;
				    				if(!empty($checkCourseEndDate))
				    				{
				    					//echo $course_end_date.' < '.$checkCourseEndDate['end_date'];die;
				    					//echo 'user id = '.$checkStudentPresent[0]['id'].' data = '.$checkCourseEndDate['end_date'].' < '.$course_end_date.'</br>';	
				    					/*if($checkCourseEndDate['end_date'] < $course_end_date)*/
				    					if(date('Y-m-d',strtotime($checkCourseEndDate['end_date'])) < date('Y-m-d',strtotime($course_end_date)))
				    					{
				    						/*echo "hii";
				    						echo 'user id = '.$checkStudentPresent[0]['id'].' data = '.$checkCourseEndDate['end_date'].' > '.$course_end_date.'</br>';	die;*/		    			    				
				    						$student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
				    						$memberuserId=$this->model_basic->_updateWhere('student_membership',array('csvuserId'=>$checkStudentPresent[0]['id']),$student_membershipData);			    				    				
				    					}		    			
				    				}
				    				else
				    				{
				    					//echo "date";
				    					$student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
				    					$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);
				    				}

				    				/*if(!empty($checkCourseEndDateMaac))
				    				{				    					
				    					if(date('Y-m-d',strtotime($checkCourseEndDate['end_date'])) < date('Y-m-d',strtotime($course_end_date)))
				    					{				    							    			    				
				    						$student_membershipData = array('csvuserId'=>$checkStudentPresentMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);	

				    						$memberuserId=$maac->where('csvuserId',$checkStudentPresentMaac[0]['id'])->update('student_membership',$student_membershipData);		    				    				
				    					}		    			
				    				}
				    				else
				    				{				    					
				    					$student_membershipData = array('csvuserId'=>$checkStudentPresentMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1);
				    					$memberuserId=$maac->insert('student_membership',$student_membershipData);
				    				}*/

				    				$html .= $i.' ) '.$studentId.' is allready present . </br>'; 
				    				
				    			}

				    	}
				    	else
				    	{
				    		$html .= $i.' ) '.$studentId.'  this student id Institute is not Present institute name  ---->  '.$instituteName.' . </br>'; 
				    	}

				    	$i++;		       
			    	
			    }
			}
			echo $html;
		}

		

		public function import_jobs_with_data()
		{	

	echo '......job.....';	die;	
			$this->load->library('csvimport');
			$file_path =  file_upload_s3_path().'onboardcsv/jobcsv.csv';
			
			if ($this->csvimport->get_array($file_path))
			{
			    $csv_array = $this->csvimport->get_array($file_path);		
			    foreach($csv_array as $user)
			    {	 

			    	$zone = $user['Zone'];
			    	$companyName = $user['Company Name'];
			    	$aboutCompany = $user['About  Company'];
			    	$title = $user['Title'];
			    	$job_type = $user['Job Type'];
			    	$description = $user['Description'];
			    	$education = $user['Education'];
			    	$keySkills = $user['Key Skills'];
			    	$min_experience = $user['Min Experience'];
			    	$max_experience = $user['Max Experience'];
			    	$industry = $user['Industry'];
			    	$country = $user['Country'];
			    	$state = $user['State'];
			    	$city = $user['City'];
			    	$location = $user['Location'];
			    	$close_on = date('Y-m-d H:i:s',strtotime($user['Close On']));
			    	$recruiter_email_id = $user['Recruiter Email Id'];
			    	$companyLogo = $user['Image Name'];
			    	$admin_level = 1; // super admin
			    	$posted_by = 0; //super admin
			    	$status = 1;
			    	$created = date('Y-m-d H:i:s');
			    	$view_status = 0; //open for all
			    	$no_of_position = $user['No of Position'];
			    	
			    	$jobTableArray=array('companyName'=>$companyName,'aboutCompany'=>$aboutCompany,'title'=>$title,'job_type'=>$job_type,'description'=>$description,'education'=>$education,'keySkills'=>$keySkills,'min_experience'=>$min_experience,'max_experience'=>$max_experience,'industry'=>$industry,'country'=>$country,'state'=>$state,'city'=>$city,'location'=>$location,'close_on'=>$close_on,'recruiter_email_id'=>$recruiter_email_id,'companyLogo'=>$companyLogo,'admin_level'=>$admin_level,'posted_by'=>$posted_by,'status'=>$status,'created'=>$created,'view_status' =>$view_status,'no_of_position'=>$no_of_position);

			    	$jobId=$this->model_basic->_insert('jobs',$jobTableArray);	    	

			    	$get_all_regions = $this->db->select('id')->from('region_list')->where('zone_id',$zone)->get()->result_array();
			    	if(!empty($get_all_regions))
			    	{
			    		foreach ($get_all_regions as $keys => $values) 
			    		{
			    			$zoneData = array('job_id'=>$jobId,'region_id'=>$values['id']);
			    			$this->model_basic->_insert('job_zone_relation',$zoneData);		    			
			    		}
			    	}
			    	$zoneData = array('job_id'=>$jobId,'zone_id'=>$zone);
			    	$this->model_basic->_insert('job_zone_relation',$zoneData);	
			    }
			}
			echo 'Job imported successfully.';
		}



	public function import_event_with_data()
	{
	echo '......events.....';	die;	
			$this->load->library('csvimport');
			$file_path =  file_upload_s3_path().'onboardcsv/eventcsv.csv';
			
			if ($this->csvimport->get_array($file_path))
			{
			    $csv_array = $this->csvimport->get_array($file_path);		
			    print_r($csv_array);die;
			    foreach($csv_array as $user)
			    {	 
			    	$name = $user['Name'];
			    	$description = $user['Description'];
			    	$start_date =  date('Y-m-d H:i:s',strtotime($user['Start Date']));
			    	$end_date = date('Y-m-d H:i:s',strtotime($user['End Date']));
			    	$banner = $user['Banner Image'];			 
			    	$status = 1;
			    	$created = date('Y-m-d H:i:s');
			    	$coupon_code = 999;
			    			    
			    	$eventTableArray=array('userId'=>1,'instituteId'=>0,'name'=>$name,'description'=>$description,'coupon_code'=>$coupon_code,'start_date'=>$start_date,'end_date'=>$end_date,'banner'=>$banner,'status'=>$status,'created'=>$created);
			    	//print_r($eventTableArray);die;
			    	$eventId=$this->model_basic->_insert('events',$eventTableArray);			    	
			    }
			}
			echo 'event imported successfully.';
		}
			

	function hard_delet()
	{
		echo 'hard_delet';die;
		$this->db->select('B.id');
		$this->db->from('institute_csv_users as A');
		$this->db->join('student_membership as B','B.csvuserId = A.id');
		$student_membershipId = $this->db->get()->result_array();
		//$ids = array();	
		if(!empty($student_membershipId))
		{
			foreach ($student_membershipId as $key => $value) {
				//$ids[]=$value['id'];
				$this->db->where('id !=',$value['id']);					
			}
		}
		$this->db->delete('student_membership');
		echo $this->db->last_query();

	}


	public function import_institute_admin_data()
	{
		echo '......institute_admin.....';	die;	
		$this->load->library('csvimport');
		$file_path =  file_upload_s3_path().'onboardcsv/instituteadmincsv.csv';
		$html = '';
		$i=1;
		
		if ($this->csvimport->get_array($file_path))
		{
		    $csv_array = $this->csvimport->get_array($file_path);		
		   // print_r($csv_array);die;
		    foreach($csv_array as $data)
		    {
			    if($data['gmail ID for institute admin'] !='' && $data['Center name']!='')	
			    {

			    	$institute_name = $data['Center name'];
			    	$getInstituteId = $this->db->select('id')->from('institute_master')->where('instituteName',$institute_name)->where('zone',$data['Zone'])->where('region',$data['Region'])->get()->row_array();
			    	if(!empty($getInstituteId))
			    	{
			    		$instituteId = $getInstituteId['id'];
			    		$userData = array('firstName'=>$institute_name,'lastName'=>'Admin','email'=>$data['gmail ID for institute admin'],'type'=>'0','disk_space'=>'1024','created'=>date('Y-m-d H:i:s'),'status'=>1);
			    		$checkemailispresent = $this->db->select('id,instituteId')->from('users')->where('email',$data['gmail ID for institute admin'])->get()->row_array();
			    		if(empty($checkemailispresent))
			    		{

			    			//$html .= $i.' ) '.$data['gmail ID for institute admin'].' <b>'.$data['Center name'].'</b></br>';
			    			$userId=$this->model_basic->_insert('users',$userData);
			    			/* update admin id institute master table*/
			    			$updateInstituteAdminId=$this->model_basic->_updateWhere('institute_master',array('id'=>$instituteId),array('adminId'=>$userId));
			    			$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$institute_name,'lastName'=>'Admin','status'=>1,'paymentStatus'=>'3','registration_date'=>date('Y-m-d H:i:s'),'email'=>$data['gmail ID for institute admin']);
			    			$CSVuserId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
			    			$student_membershipData = array('csvuserId'=>$CSVuserId,'start_date'=>date('Y-m-d H:i:s'),'end_date'=>'2021-11-16 12:10:47','status'=>1);
			    			$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);
			    		}
			    		else
			    		{
			    			//print_r($checkemailispresent);die;	
			    			$checkInstitute = $this->db->select('id,instituteName')->from('institute_master')->where('adminId',$checkemailispresent['id'])->get()->row_array();
			    			if(!empty($checkInstitute))
			    			{
			    				$html .= $i.' ) '.$data['gmail ID for institute admin'].' exist mailId for institute ----> <b>'.$checkInstitute['instituteName'].'</b></br>';
			    			}  
			    			else
			    			{
			    				$html .= $i.' ) '.$data['gmail ID for institute admin'].' exist mailId </br>';
			    			}	
			    		}
			    	}
			    	else
			    	{
			    		$html .= $i.' ) '.$institute_name.' institute not exist </br>';
			    	}
			    		$i++;    	
			    	//print_r($getInstituteId);
			    }
			    else
			    {
			    	echo $data['Center name'].' email is empty </br>';
			    }		    
		    
		    }
		    echo $html;	
		}
		echo 'institute admin imported successfully.';
	}

	function sendMailInstituteAdminList()
	{
		$this->load->library('csvimport');
		$file_path =  file_upload_s3_path().'onboardcsv/upload8.csv';
		if ($this->csvimport->get_array($file_path))
		{
		    $csv_array = $this->csvimport->get_array($file_path);		
		   	print_r($csv_array);die;    		    
		    foreach($csv_array as $user)
		    {
		    	$instituteId = $user['instituteId'];
		    	$firstName=$user['firstName'];
		    	$lastName=$user['lastName'];
		    	$studentId=$user['studentId'];
		    	$email=$user['email'];
		    	$status=1;
		    	$paymentStatus=3;
		    	$first_login_date='2018-02-01';
		    	$registration_date='2018-02-01';
		    	$centerId=2;
		    	$courseId=$user['courseId'];
		    	$courseName=$user['courseName'];
		    	$start_date=date('Y-m-d H:i:s', strtotime($user['start_date']));
		    	$end_date = date('Y-m-d H:i:s', strtotime($user['end_date']));

		    	/*$emailNew=$this->model_basic->getValueArray('institute_csv_users','email',array('studentId'=>$studentId));
		    	if($emailNew !='')
		    	{
		    		$email=$emailNew;
		    	}*/
		    	
		    	$instCsvArr=array('instituteId'=>$instituteId,'firstName'=>$firstName,'lastName'=>$lastName,'studentId'=>$studentId,'email'=>$email,'status'=>1,'paymentStatus'=>3,'first_login_date'=>$first_login_date,'registration_date'=>$registration_date,'centerId'=>2,'courseId'=>$courseId,'courseName'=>$courseName);
		    	//print_r($instCsvArr);
		    	$csvId=$this->model_basic->_insert('institute_csv_users_new',$instCsvArr);

		    	$stuMemArr=array('csvuserId'=>$csvId,'start_date'=>$start_date,'end_date'=>$end_date,'status'=>1);
		    	//print_r($stuMemArr);die;
		    	$this->model_basic->_insert('student_membership_new',$stuMemArr);
		    	//die;
			}
		}
		echo "Done";die;
	}

	function send_mail_to_user()
	{

		echo "...........send_mail_to_user........";die;

		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		
		/*
		
		$from               = $emailFrom;
		$subjectBy          = 'Update your profile!';
		$templateAddedBy    = 'Hello there!,<br /><br />Just a reminder to complete your profile on creosouls and score a perfect 100% on profile meter. A complete profile attracts more attention and opportunities  compared to partially complete ones. <a href="http://www.creosouls.com">Click here</a> to login and update you profile.<br /><br />Happy creosouling!,<br /><br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
		$sendEmailToAddUser = array('to' =>'tushar.desai@emmersivetech.com','subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
		$this->model_basic->sendMail($sendEmailToAddUser);		*/
		/*
		vivekmbhide@gmail.com  =  711
		vivek.bhide@emmersivetech.com  == 796
		acdaco@gmail.com == 716
		tdesai79@gmail.com == 687
		tushar.desai@emmersivetech.com == 684
		*/

		/*$ListArrayUsers = $this->db->select("firstName,lastName,email")->from('users')->where('id NOT IN (711,796,716,687,684)')->get()->result_array();

		//echo $this->db->last_query();die;
		//print_r($ListArrayUsers);die;		
		if(!empty($ListArrayUsers)){
			foreach ($ListArrayUsers as $key => $value) {
				if($value['email'] != '')
				{
					$from               = $emailFrom;
					$subjectBy          = 'Update your profile!';
					$templateAddedBy    = 'Hello there!,<br /><br />Just a reminder to complete your profile on creosouls and score a perfect 100% on profile meter. A complete profile attracts more attention and opportunities  compared to partially complete ones. <a href="http://www.creosouls.com">Click here</a> to login and update you profile.<br /><br />Happy creosouling!,<br /><br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$sendEmailToAddUser = array('to' =>$value['email'],'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
					$this->model_basic->sendMail($sendEmailToAddUser);					
				}				
			}
		}
*/


		$ListArrayUsers = $this->db->select("A.id UsersId,B.instituteName,A.firstName,A.lastName,A.email")->from('users as A')->join('institute_master as B','B.adminId = A.id')->where('adminId !=',867)->get()->result_array();

		//print_r($ListArrayUsers);die;	

		if(!empty($ListArrayUsers)){
			foreach ($ListArrayUsers as $key => $value) {
				if($value['email'] != '')
				{
					$from = $emailFrom;
					$subjectBy = 'Admins! Your students might have uploaded some really good projects, mark as Public and let them shine!
					';
					$templateAddedBy = 'Hello Admin,<br /><br />Students in your institute might have uploaded the projects on Creosouls. Please review them and make the good  public:<br /><br />Steps to do that for Institute Admin (Only Institute Admin can execute below steps):<br /><br /><ul><li>Log in to creosouls using Institute Admin gmail ID</li><li>Click on <b>"Manage Institute Data"</b> from under the User Menu (beside the profile picture/your name in top right corner )</li><li>Click on <b>"Projects"</b> from left navigation section</li><li>Select the project/projects from the list that you want to make Public</li><li>Select the <b>"Public"</b> from Select Action menu at the bottom of the project list and click on <b>"Go"</b></li></ul><br />Happy creosouling!,<br />Team Creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
					$sendEmailToAddUser = array('to' =>$value['email'],'subject'  =>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
					//$this->model_basic->sendMail($sendEmailToAddUser);					
				}				
			}
		}


	}

	public function updateCoureseEndDate()
	{
		die;
		$names=array('Student1083175','Student1084542','Student1041708','Student1083131','Student1083118','Student1082788','Student1084709','Student1082906','Student1083779','Student1070756','Student1070756','Student1082814','Student1075066','Student1084579','Student1084615','Student1084786','Student1084592','Student1084426','Student1083192','Student1084205','Student1084774','Student1083283','Student1083161','Student1083167','Student1083286','Student1082932','Student1082943','Student1082934','Student1082952','Student1082942','Student1083566','Student1084578','Student1082832','Student1083070','Student1083078','Student1082988','Student1083769','Student1083867','Student1083082','Student1083075','Student1083797','Student1082992','Student1083081','Student1083781','Student1082991','Student1083201','Student1084767','Student1082841','Student1083359','Student1082950','Student1084004','Student1082764','Student1083787','Student1084425','Student1083357','Student1082855','Student1084704','Student1083193','Student1083132','Student1084455','Student1083168','Student1082849','Student1083205','Student1083197','Student1083322','Student1083326','Student1083145','Student1083330','Student1084520','Student1083089','Student1083085','Student1082920','Student1083256','Student1083258','Student1082946','Student1083115','Student1083129','Student1082861','Student1083200','Student1082917','Student1084745','Student1084437','Student1084661','Student1084792','Student1083365','Student1083379','Student1083321','Student1082859','Student1082817','Student1082813','Student834605','Student1084769','Student1084770','Student1083757','Student1084628','Student1083064','Student1082948','Student1083217','Student1082768','Student1084782','Student1083246','Student1084582','Student1083253','Student1083252','Student1083102','Student1083080','Student1056594','Student1056594','Student1084539','Student1083426','Student1083341','Student1082974','Student1082976','Student1084514','Student1084551','Student1084553','Student1084519','Student1084518','Student1082742','Student1082740','Student1082997','Student1084789','Student1084790','Student1084785','Student1083025','Student1083033','Student1084634');


		$stMemIds=$this->db->select('student_membership.id,institute_csv_users.studentId')->from('student_membership')->join('institute_csv_users','institute_csv_users.id=student_membership.csvuserId')->where('institute_csv_users.studentId !=','')->where_not_in('institute_csv_users.studentId', $names)->get()->result_array();
		//print_r($stMemIds);die;
		
		if(!empty($stMemIds))
		{
			foreach($stMemIds as $st)
			{
				//echo $st['id'];
				$data=array('end_date'=>'2018-01-28 23:59:59');
				$this->db->where('id', $st['id']);
				$this->db->update('student_membership', $data);
				//die;
				//echo $this->db->last_query();die;
			}
		}
	}


	public function checkStudentIdPresent()
	{
		echo '......checkStudentIdPresent.....';	die;	
		$this->load->library('csvimport');
		$file_path =  file_upload_s3_path().'onboardcsv/checkStudentIdPresent.csv';
		$html = '';
		$i=1;
		$studentId = array();
		
		if ($this->csvimport->get_array($file_path))
		{
		    $csv_array = $this->csvimport->get_array($file_path);		
		  
		    foreach($csv_array as $data)
		    {
		    	//print_r($data);
		    		/*$studentId[]= $data['Student Id'];*/
		    		$user_array[] = $this->db->select('A.firstName,A.lastName,A.studentId,B.start_date,B.end_date,A.instituteId')->from('institute_csv_users as A')->join('student_membership as B','B.csvuserId=A.id')->where_in('A.studentId',$data['Student Id'])->get()->row_array();
		    }
		   // die;

		   // print_r($user_array);die;
		   /* $studentId_explod = implode(',',$studentId);

		    $user_array = $this->db->select('*')->from('institute_csv_users')->where_in('studentId',$studentId_explod)->get()->result_array();

		   	echo $this->db->last_query();die;*/

		  //  print_r($user_array);die;

    		$path='checkStudentIdPresent'.date('M d Y').time().'.csv';	
    		  header('Content-Type: application/excel');
    		  header('Content-Disposition: attachment; filename="'.$path.'"');
    		 	if(!empty($user_array))
     			{
     			    $fh = fopen('php://output', 'w');

     			    fputcsv($fh, array('','','checkStudentIdPresent.'));		     
     			    fputcsv($fh, array());	

     			    fputcsv($fh, array_keys(current($user_array)));		     
     			    foreach ( $user_array as $row ) 
     			    {
     			            fputcsv($fh, $row);
     			    }
     			}	 


		  }
	}

	public function get_diactive_institute_student()
	{
		//echo '......get_diactive_institute_student....................';die;
		/*$instId = $this->db->select('id')->from('institute_master')->where('status',0)->get()->result_array();	
		$studentId = array();
		foreach($instId as $data)
		{
			$studentId[]= $data['id'];
		}		
		$studentId_explod = implode(',',$studentId);
		$user_array = $this->db->select('*')->from('users')->where_in('instituteId',$studentId_explod)->get()->result_array();
		echo $this->db->last_query();
		print_r($user_array);die;*/

		$ListArrayInsti = $this->db->select("A.id,B.id as InstituteId,B.instituteName,COUNT(A.id) as count")->from('users as A')->join('institute_master as B','B.id = A.instituteId','left')->where('B.status','0')->group_by('A.instituteId')->get()->result_array();

		echo $this->db->last_query();

		print_r($ListArrayInsti);die;


	}

	public function import_faculty_data()
	  {
	  	echo '......import_faculty_data.....';	die;	
	  	$this->load->library('csvimport');
	  	$file_path =  file_upload_s3_path().'onboardcsv/facultycsv.csv';
	  	$html = '';
	  	$i=1;
	  	
	  	if ($this->csvimport->get_array($file_path))
	  	{
	  	    $csv_array = $this->csvimport->get_array($file_path);		
	  	   // print_r($csv_array);die;
	  	    foreach($csv_array as $data)
	  	    {
	  	    	//print_r($data['Email']);
	  	    	//print_r($data['Center Name']);die;

	  		    if($data['Email'] !='' && $data['Center Name']!='')	
	  		    {
	  		    	$institute_name = trim($data['Center Name']);
	  		    	$getInstituteId = $this->db->select('id')->from('institute_master')->where('instituteName',$institute_name)->get()->row_array();  	
	  		    	if(!empty($getInstituteId))
	  		    	{
	  		    		$emaiId= trim($data['Email']);   		    		
			    	    	$instituteId = $getInstituteId['id'];
	  		    		$userData = array('instituteId'=>$instituteId,'firstName'=>$data['Faculty Name'],'lastName'=>'.','email'=>$data['Email'],'type'=>'1','disk_space'=>'1024','created'=>date('Y-m-d H:i:s'),'status'=>'1','teachers_status'=>'1');
	  		    		$checkemailispresent = $this->db->select('*')->from('users')->where('email',$emaiId)->get()->row_array();
	  		    		//print_r($checkemailispresent);die;

	  		    		if(empty($checkemailispresent))
	  		    		{
	  		    			//$html .= $i.' ) '.$data['gmail ID for institute admin'].' <b>'.$data['Center name'].'</b></br>';
	  		    			$userId=$this->model_basic->_insert('users',$userData);   		    			
	  		    			$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$data['Faculty Name'],'lastName'=>'.','status'=>1,'paymentStatus'=>'3','registration_date'=>date('Y-m-d H:i:s'),'email'=>$emaiId);
	  		    			$CSVuserId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
	  		    			$student_membershipData = array('csvuserId'=>$CSVuserId,'start_date'=>date('Y-m-d H:i:s'),'end_date'=>'2021-11-16 12:10:47','status'=>1);
	  		    			$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);
	  		    		}
	  		    		else
	  		    		{   		    			
	  		    			if($checkemailispresent['instituteId'] == $instituteId)
	  		    			{   		    					    				
	  		    				$updateTeacherStatusData = array('teachers_status'=>'1','status'=>1,'instituteId'=>$instituteId);
	  		    				$updateTeacherStatus=$this->model_basic->_update('users','id',$checkemailispresent['id'],$updateTeacherStatusData);

	  		    				$getCsvId = $this->db->select('*')->from('institute_csv_users')->where('email',$emaiId)->get()->row_array();   		

	  		    				$student_membershipData = array('end_date'=>'2021-11-16 12:10:47','status'=>1);
	  		    				$memberuserId=$this->model_basic->_update('student_membership','csvuserId',$getCsvId['id'],$student_membershipData);

	  		    				$html .= $i.' ) '.$data['Email'].' exist mailId ......Updated.......</b></br>';
	  		    			}
	  		    			else if($checkemailispresent['instituteId'] == 0)
	  		    			{
	  		    				$updateTeacherStatusData = array('teachers_status'=>'1','status'=>1,'instituteId'=>$instituteId);
	  		    				$updateTeacherStatus=$this->model_basic->_update('users','id',$checkemailispresent['id'],$updateTeacherStatusData);

	  		    				$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$checkemailispresent['firstName'],'lastName'=>$checkemailispresent['lastName'],'status'=>1,'paymentStatus'=>'3','registration_date'=>date('Y-m-d H:i:s'),'email'=>$checkemailispresent['email']);   		    				
	  		    				$CSVuserId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
	  		    				$student_membershipData = array('csvuserId'=>$CSVuserId,'start_date'=>date('Y-m-d H:i:s'),'end_date'=>'2021-11-16 12:10:47','status'=>1);
	  		    				$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);

	  		    				$html .= $i.' ) '.$data['Email'].' exist mailId ......Guest.......</b></br>';
	  		    			}
	  		    			else
	  		    			{
	  		    				$updateTeacherStatusData = array('teachers_status'=>'1','status'=>1,'instituteId'=>$instituteId);
	  		    				$updateTeacherStatus=$this->model_basic->_update('users','id',$checkemailispresent['id'],$updateTeacherStatusData);

	  		    				$getCsvId = $this->db->select('*')->from('institute_csv_users')->where('email',$emaiId)->get()->row_array();   	
	  		    				if(!empty($getCsvId))
	  		    				{   		    					
	  		    					$userTableArray=array('instituteId'=>$instituteId,'status'=>1,'paymentStatus'=>'3');   		    				
	  		    					$updatCSVuserInstituteId=$this->model_basic->_update('institute_csv_users','id',$getCsvId['id'],$userTableArray);
	  		    					$student_membershipData = array('end_date'=>'2021-11-16 12:10:47','status'=>1);
	  		    					$memberuserId=$this->model_basic->_update('student_membership','csvuserId',$getCsvId['id'],$student_membershipData);
	  		    				}
	  		    				else
	  		    				{
	  		    					$userTableArray=array('instituteId'=>$instituteId,'firstName'=>$checkemailispresent['firstName'],'lastName'=>$checkemailispresent['lastName'],'status'=>1,'paymentStatus'=>'3','registration_date'=>date('Y-m-d H:i:s'),'email'=>$checkemailispresent['email']);   		    				
	  		    					$CSVuserId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
	  		    					$student_membershipData = array('csvuserId'=>$CSVuserId,'start_date'=>date('Y-m-d H:i:s'),'end_date'=>'2021-11-16 12:10:47','status'=>1);
	  		    					$memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);
	  		    				}

	  		    				$html .= $i.' ) '.$data['Email'].' exist  but it belongs to other institut ...........Institute Id is --->'.$checkemailispresent['instituteId'].'</b></br>';
	  		    			}
	  		    		}   		    		
	  		    	}
	  		    	else
	  		    	{
	  		    		$html .= $i.' ) '.$institute_name.' institute not exist </br>';
	  		    	}
	  		    		$i++;    	
	  		    	//print_r($getInstituteId);
	  		    }
	  		    else
	  		    {
	  		    	echo $data['Center Name'].' email is empty </br>';
	  		    }		    
	  	    
	  	    }
	  	    echo $html;	
	  	}
	  	echo 'institute admin imported successfully.';
	  }


	     public function all_delete_user_data()
	     {
	     	//echo ".........all_delete_user_data.............";die;
	     	$this->load->library('csvimport');
	     	$file_path =  file_upload_s3_path().'onboardcsv/remove.csv';
	     	$html = '';
	     	$i=1;
	     	$Id_array = array();
	     	
	  	   	if ($this->csvimport->get_array($file_path))
	  	   	{
	  		   	    $csv_array = $this->csvimport->get_array($file_path);		
	  		   	 //  print_r($csv_array);die;
	  		   	    foreach($csv_array as $data)
	  		   	    {
	  		   	    		$studentId = $data['Student ID']; 		   	    	
	  		   	    		//$studentId = 'WIA011'; 		   	    	
	  		   	    		$getCsvId = $this->db->select('id,studentId,email')->from('institute_csv_users')->where('studentId',$studentId)->where('email !=','')->get()->row_array();     	
	  		   	    		//print_r($getCsvId);

	  		   	    		if(!empty($getCsvId))
	  		   	    		{ 		   	    			
	  		   	    			$usersId = $this->db->select('id,email')->from('users')->where('email',$getCsvId['email'])->get()->row_array();     		

	  		   	    			$userId = $usersId['id'];
	  		   	    			$csvuserId = $getCsvId['id'];

	  		   	    			$assignmentIds = $this->db->select('id')->from('assignment')->where('teacher_id',$userId)->get()->result_array();  

	  		   	    			//print_r($assignmentIds);
	  		   	    			if(!empty($assignmentIds))
	  		   	    			{
	  		   	    				foreach ($assignmentIds as $assignmentId) {

	  		   	    					$this->model_basic->_delete('assignment_features_relation','assignment_id',$assignmentId['id']);
	  		   	    					$this->model_basic->_delete('assignment_tools_relation','assignment_id',$assignmentId['id']);
	  		   	    					$this->model_basic->_delete('user_assignment_relation','assignment_id',$assignmentId['id']); 		    		   	    					
	  		   	    				} 		   	    				
	  		   	    			}
	  		   	    			
	  		   	    			$competitionIds = $this->db->select('id')->from('competitions')->where('userId',$userId)->get()->result_array();  
	  		   	    			//print_r($competitionIds);
	  		   	    			if(!empty($competitionIds))
	  		   	    			{
	  		   	    				foreach ($competitionIds as $competitionId) {

	  		   	    					$this->model_basic->_delete('competition_jury_relation','competitionId',$competitionId['id']);
	  		   	    					$this->model_basic->_delete('competition_project_avg_rating','competitionId',$competitionId['id']);
	  		   	    					$this->model_basic->_delete('competition_rank_title','competitionId',$competitionId['id']);
	  		   	    					$this->model_basic->_delete('competition_winning_projects','competitionId',$competitionId['id']);
	  		   	    					$this->model_basic->_delete('project_jury_rating','competitionId',$competitionId['id']);
	  		   	    					$this->model_basic->_delete('user_competition_relation','competitionId',$competitionId['id']); 	
	  		   	    				}
	  		   	    			}

	  		   	    			
	  		   	    			$jobIds = $this->db->select('id')->from('jobs')->where('posted_by',$userId)->where('admin_level','3')->get()->result_array();  
	  		   	    			//print_r($jobIds);
	  		   	    			if(!empty($jobIds))
	  		   	    			{
	  		   	    				foreach ($jobIds as $jobId) {

	  		   	    					$this->model_basic->_delete('job_feedback','jobId',$jobId['id']); 		 		   	    					
	  		   	    				} 		   	    				
	  		   	    			}
	  		   	    			

	  		   	    			$projectIds = $this->db->select('id')->from('project_master')->where('userId',$userId)->get()->result_array();  
	  		   	    			//print_r($projectIds);
	  		   	    			if(!empty($projectIds))
	  		   	    			{
	  		   	    				foreach ($projectIds as $projectId) {

	  		   	    					$this->model_basic->_delete('competition_winning_projects','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_appreciation','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_attribute_relation','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_attribute_value_rating','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_image_rating_like','project_id',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_jury_rating','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_rating','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('project_team','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('user_myboard','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('user_project_comment','projectId',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('user_project_image','project_id',$projectId['id']); 
	  		   	    					$this->model_basic->_delete('user_project_views','projectId',$projectId['id']); 
	  		   	    					
	  		   	    				}
	  		   	    				
	  		   	    			}

	  		   	    			
	  		   	    			$this->model_basic->_delete('institute_csv_users','studentId',$studentId);
	  		   	    			$this->model_basic->_delete('student_membership','csvuserId',$csvuserId);


	  		   	    			$this->model_basic->_delete('competition_user_notification','userId',$userId);
	  		   	    			$this->model_basic->_delete('competition_jury_relation','userId',$userId);
	  		   	    			$this->model_basic->_delete('blog_comment','userId',$userId);
	  		   	    			$this->model_basic->_delete('event_user_notification','userId',$userId);
	  		   	    			$this->model_basic->_delete('feedback_instance_notification','user_id',$userId);
	  		   	    			$this->model_basic->_delete('feedback_user_notification','userId',$userId);
	  		   	    			$this->model_basic->_delete('gcm','userId',$userId);
	  		   	    			$this->model_basic->_delete('header_notification_user_relation','user_id',$userId);
	  		   	    			$this->model_basic->_delete('institutefeedback','user_id',$userId);
	  		   	    			$this->model_basic->_delete('job_feedback','userId',$userId);
	  		   	    			$this->model_basic->_delete('job_user_notification','userId',$userId);
	  		   	    			$this->model_basic->_delete('job_user_relation','userId',$userId);
	  		   	    			$this->model_basic->_delete('project_appreciation','appreciatedUserId',$userId);
	  		   	    			$this->model_basic->_delete('project_appreciation','appreciateByUserId',$userId);
	  		   	    			$this->model_basic->_delete('project_attribute_value_rating','userId',$userId);
	  		   	    			$this->model_basic->_delete('project_image_rating_like','user_id',$userId);
	  		   	    			$this->model_basic->_delete('project_master_deleted','userId',$userId);
	  		   	    			$this->model_basic->_delete('project_rating','userId',$userId);
	  		   	    			$this->model_basic->_delete('project_team','userId',$userId);
	  		   	    			$this->model_basic->_delete('social_link','user_id',$userId);
	  		   	    			$this->model_basic->_delete('terms_and_conditions','user_id',$userId);
	  		   	    			$this->model_basic->_delete('users_award','user_id',$userId);
	  		   	    			$this->model_basic->_delete('users_custom','u_id',$userId);
	  		   	    			$this->model_basic->_delete('users_education','user_id',$userId);
	  		   	    			$this->model_basic->_delete('users_skills','user_id',$userId);
	  		   	    			$this->model_basic->_delete('users_work','user_id',$userId);
	  		   	    			$this->model_basic->_delete('user_activity_master','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_assignment_relation','user_id',$userId);
	  		   	    			$this->model_basic->_delete('user_card_detail','user_id',$userId);
	  		   	    			$this->model_basic->_delete('user_competition_relation','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_email_notification_relation','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_follow','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_follow','followingUser',$userId);
	  		   	    			$this->model_basic->_delete('user_group_relation','user_id',$userId);
	  		   	    			$this->model_basic->_delete('user_login_details','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_myboard','myboardUser',$userId);
	  		   	    			$this->model_basic->_delete('user_project_comment','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_project_views','userId',$userId);
	  		   	    			$this->model_basic->_delete('user_web_reference','user_id',$userId);	


	  		   	    			$this->model_basic->_delete('users','id',$userId);		   	    						 
	  		   	    			$this->model_basic->_delete('assignment','teacher_id',$userId);		   	    						 
	  		   	    			$this->model_basic->_delete('competitions','userId',$userId);		   	    						 
	  		   	    			$this->model_basic->_deleteWhere('jobs',array('posted_by'=>$userId,'admin_level'=>'3'));		   	    						 
	  		   	    			$this->model_basic->_delete('project_master','userId',$userId);		   	    						 
	  		   	    		
	  		   	    			//die;
	  		   	    		}	

	  		   	    }

	  	   	   }
	  	   	   echo 'Done';
	    	 }

 public function get_institute_faculty_data()
 	   {
 	   	//echo '......get_institute_faculty_data.....';	die;	
 	   	$allinstitute = $this->db->select("id as InstituteId,instituteName,CASE zone
 	   	   		   when 1 then 'East'
 	   	   		   when 2 then 'West'
 	   	   		   when 3 then 'South'
 	   	   		   when 4 then 'North'  
 	   	   		   ELSE 'Not defined'
 	   	   		END as Zone",FALSE)->from('institute_master')->get()->result_array();
 	   	if(!empty($allinstitute))
 	   	{
 	   		foreach ($allinstitute as  $key => $value) {
 	   			$teacher = $this->db->select('firstName,lastName,email')->from('users')->where('instituteId',$value['InstituteId'])->where('teachers_status',1)->get()->result_array();
 	   			if(empty($teacher))
 	   			{
 	   				$allinstitute[$key]['teacher'] = '';
 	   			}
 	   			else
 	   			{
 	   				$allinstitute[$key]['teacher'] = ' Have Teacher';
 	   			}	   			
 	   		}
 	   	}
 	   	//print_r($allinstitute);die;			
 		$path=date('M d Y').time().'.csv';	
 		  header('Content-Type: application/excel');
 		  header('Content-Disposition: attachment; filename="'.$path.'"');
 		 	if(!empty($allinstitute))
  			{
  			    $fh = fopen('php://output', 'w');

  			    fputcsv($fh, array('','','List of get_institute_faculty_data.'));		     
  			    fputcsv($fh, array());	

  			    fputcsv($fh, array_keys(current($allinstitute)));		     
  			    foreach ( $allinstitute as $row ) 
  			    {
  			            fputcsv($fh, $row);
  			    }
  			}	   	   
 	   }


   public function get_institute_admin_data()
   	   {
   	   	//echo '......get_institute_admin_data.....';	die;	
   	   	$ListArrayInsti = $this->db->select("A.id UsersId,B.instituteName,A.firstName,A.lastName,A.email,
   	   		 CASE B.zone
   	   		   when 1 then 'East'
   	   		   when 2 then 'West'
   	   		   when 3 then 'South'
   	   		   when 4 then 'North'  
   	   		   ELSE 'Not defined'
   	   		END as Zone",FALSE)->from('users as A')->join('institute_master as B','B.adminId = A.id')->get()->result_array();
   	   	//print_r($ListArrayInsti);die;
   		$path=date('M d Y').time().'.csv';	
   		  header('Content-Type: application/excel');
   		  header('Content-Disposition: attachment; filename="'.$path.'"');
   		 	if(!empty($ListArrayInsti))
    			{
    			    $fh = fopen('php://output', 'w');

    			    fputcsv($fh, array('','','List of get_institute_admin_data.'));		     
    			    fputcsv($fh, array());	

    			    fputcsv($fh, array_keys(current($ListArrayInsti)));		     
    			    foreach ( $ListArrayInsti as $row ) 
    			    {
    			            fputcsv($fh, $row);
    			    }
    			}	   	   
   	   } 


  	 	public function institutesapid()
  	 	{
  	 		//echo '......institutesapid.....';	die;	
  	 		$this->load->library('csvimport');
  	 		$file_path =  file_upload_s3_path().'onboardcsv/institutesapid.csv';
  	 		$html = '';
  	 		$i=1;
  	 		$studentId = array();
  	 		
  	 		if ($this->csvimport->get_array($file_path))
  	 		{
  	 		    $csv_array = $this->csvimport->get_array($file_path);	
  	 		   // print_r($csv_array);die;	
  	 		  
  	 		    foreach($csv_array as $data)
  	 		    {
  	 		    	$instituteName = $data['Center Name'];
  	 		    	$sap_center_code = $data['Sap Id'];

  	 		    	$get_instituteId = $this->db->select('id')->from('institute_master')->where('instituteName',$instituteName)->get()->row_array();
   			    	if(!empty($get_instituteId))
   			    	{
   			    		$this->model_basic->_updateWhere('institute_master',array('instituteName'=>$instituteName),array('sap_center_code'=>$sap_center_code));   		
   			    	}
   			    	else
   			    	{
   			    		echo $instituteName.'---------->'.$sap_center_code.'<br />';
   			    	}		    
  	 		    }	
  	 		  }
  	 	} 	


  	 	public function getExtraUsers()
  	 	{
  	 		echo "string";die;
  	 		$insts=$this->db->select('instituteId,email')->from('institute_csv_users')->where('email !=','')->where('centerId',2)->get()->result_array();
  	 		//print_r($insts);die;
  	 		foreach($insts as $val)
  	 		{
  	 			$this->db->where('email',$val['email']);
  	 			$this->db->update('users',array('instituteId'=>$val['instituteId'])); 
  	 		}
  	 		echo "done";die;
  	 	}

}
