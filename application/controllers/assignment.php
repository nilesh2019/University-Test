<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Assignment extends MY_Controller
{	
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('model_basic');    
    	$this->load->model('assignment_model'); 
	}
	public function index()
	{
		$user_id=$this->session->userdata('front_user_id');	
		$getAllUserAssignment= $this->assignment_model->getAllUserAssignment($user_id);
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
		$this->load->view('assignment_view',$data);
	}
	public function manage_assignment($id)
	{		
		$data['getAllUserAssignment'] = $this->model_basic->getAllData('assignment','*',array('teacher_id'=>$id),array('id'=>'DESC'));	
		//print_r($data);die;
		//echo $this->db->last_query();
		$this->load->view('manage_assignment_view',$data);
	}
	
	
	public function add_assignment($assignment_id='')
	{	
		if($this->session->userdata('teachers_status') == 0)
		{
			redirect('assignment');
		}
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('assignment_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');	
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');	
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');	
		if ($this->form_validation->run())
		{
			//print_r($_POST);die;	
			
			if(!empty($this->input->post("videoLink")))
			{
				$videoLinkArr = explode("watch?v=",$this->input->post("videoLink"));
				$videoLink1    = explode("&feature=youtu.b", $videoLinkArr[1]);
				$videoLink=$videoLink1[0];
			}
			else
			{
				$videoLink = '';
			}
			$user_id=$this->session->userdata('front_user_id');	
			if($assignment_id!='')
			{

				$AddData=array('assignment_name'=> $this->input->post('assignment_name',TRUE),'description'=>$this->input->post('description',TRUE),'start_date'=>date('Y-m-d',strtotime($this->input->post('start_date',TRUE))),'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date',TRUE))),'teacher_id'=>$user_id,'videoLink'=>$videoLink);

				$res=$this->model_basic->_update('assignment','id',$assignment_id,$AddData);
				//$data['delet_existing_user'] = $this->model_basic->_delete('user_assignment_relation','assignment_id',$assignment_id);			
				if(!empty($_POST['individual_user']))
				{
					foreach ($_POST['individual_user'] as $individual_user) 
					{	
						
							$check_user_present=$this->model_basic->getData('user_assignment_relation','*',array('user_id'=>$individual_user,'assignment_id'=>$assignment_id));

							if(empty($check_user_present))
							{
								$user_assig_relation_data  = array('user_id' => $individual_user,'assignment_id'=>$assignment_id);
								$insert_user_assig_relation_data=$this->model_basic->_insert('user_assignment_relation',$user_assig_relation_data);

								$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user));
								$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignment_id));
								$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));

								$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> New assignment has been assigned to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';

								$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'New assignment has been assign to you','template'=>$message);	  
								//$sendMail = $this->model_basic->sendMail($emailData);

								$notificationEntry=array('title'=>'New assignment added','msg'=>'New assignment '.$get_assignment_data['assignment_name'].' added in creosouls by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'],'link'=>'assignment/assignment_detail/'.$assignment_id.'/'.$individual_user,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>17,'redirectId'=>$assignment_id);
							
								$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

								$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user);
								$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);
								
								    $msg = array (
									'body' 	=> '',
									'title'	=> '',
									'aboutNotification'	=> ucwords($get_assignment_data['assignment_name']),
									'notificationTitle'	=> 'New assignment added',
									'notificationType'	=> 17,
									'notificationId'	=> $assignment_id,
									'notificationImageUrl'	=> ''          	
						          );
								$this->model_basic->sendNotification($individual_user,$msg);
							}
							else{	

								$user_assig_relation_data  = array('user_id' => $individual_user,'assignment_id'=>$assignment_id);
								//$insert_user_assig_relation_data=$this->model_basic->_insert('user_assignment_relation',$user_assig_relation_data);

								$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user));
								$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$assignment_id));
								$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));

								$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> Some changes are made in assignment has been assigned to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';								

								$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'Some changes are made in assignment has been assign to you','template'=>$message);	  
								//$sendMail = $this->model_basic->sendMail($emailData);

								$notificationEntry=array('title'=>'Some changes in Assignment','msg'=>'Some changes are made in assignment '.$get_assignment_data['assignment_name'].' in creosouls.','link'=>'assignment/assignment_detail/'.$assignment_id.'/'.$individual_user,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>17,'redirectId'=>$assignment_id);								

								$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

								$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user);
								$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);
							
								
								   $msg = array (
									'body' 	=> '',
									'title'	=> '',
									'aboutNotification'	=> ucwords($get_assignment_data['assignment_name']),
									'notificationTitle'	=> 'Some changes in Assignment',
									'notificationType'	=> 17,
									'notificationId'	=> $assignment_id,
									'notificationImageUrl'	=> ''          	
						          );
								$this->model_basic->sendNotification($individual_user,$msg);
							}	
					}
				}

				$assign_not_users = $this->assignment_model->not_assign_user($_POST['individual_user'],$assignment_id);	
				$errorMsg='';
				if(!empty($assign_not_users))	
				{
					foreach ($assign_not_users as $key => $value) {

						$toCheckAssigIsSubmitedOrNot=$this->model_basic->getAllData('project_master','id',array('userId'=>$value['user_id'],'assignmentId'=>$assignment_id));
						//print_r($toCheckAssigIsSubmitedOrNot);

						if(!empty($toCheckAssigIsSubmitedOrNot))
						{
							$get_user_Name=$this->model_basic->getData('users','firstName,lastName',array('id'=>$value['user_id']));
							//print_r($get_user_Name);
							$errorMsg .= $get_user_Name['firstName'].' '.$get_user_Name['lastName'].' user can not delet. submit project';
						}
						else
						{							
							$deletUser = $this->model_basic->_deleteWhere('user_assignment_relation',array('assignment_id'=>$assignment_id,'user_id'=>$value['user_id']));										
						}
						
					}
				}

				//print_r($_POST);die;

				$delettools = $this->model_basic->_deleteWhere('assignment_tools_relation',array('assignment_id'=>$assignment_id));
				$deletfeatures = $this->model_basic->_deleteWhere('assignment_features_relation',array('assignment_id'=>$assignment_id));


				if($_POST['tools']!='')
				{
					$tools = explode(',', $_POST['tools']);
					if(!empty($tools))
					{
						foreach($tools as $single_tool_value)
						{
							$get_tool_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>1,'attributeValue'=>$single_tool_value));
							if(!empty($get_tool_data))
							{							
								$AddToolData=array('assignment_id'=>$assignment_id,'attribute_tools_id'=>$get_tool_data['id']);	
							}
							else
							{
								$add_tool_data=array('attributeId'=>1,'attributeValue'=>$single_tool_value);
								$add_tool=$this->model_basic->_insert('attribute_value_master',$add_tool_data);
								if($add_tool>1)
								{
									$AddToolData=array('assignment_id'=>$assignment_id,'attribute_tools_id'=>$add_tool);
								}
							}
							$insert_get_tool_data=$this->model_basic->_insert('assignment_tools_relation',$AddToolData);						
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
							$get_features_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>2,'attributeValue'=>$single_features_value));
							if(!empty($get_features_data))
							{							
								$AddfeaturesData=array('assignment_id'=>$assignment_id,'attribute_features_id'=>$get_features_data['id']);
							}
							else
							{
								$add_feature_data=array('attributeId'=>1,'attributeValue'=>$single_features_value);
								$add_feature=$this->model_basic->_insert('attribute_value_master',$add_feature_data);
								if($add_feature>1)
								{
									$AddfeaturesData=array('assignment_id'=>$assignment_id,'attribute_features_id'=>$add_feature);
								}

							}
							$insert_get_features_data=$this->model_basic->_insert('assignment_features_relation',$AddfeaturesData);					
						}
					}			
				}							
			}
			else
			{
				$AddData=array('assignment_name'=> $this->input->post('assignment_name',TRUE),'description'=>$this->input->post('description',TRUE),'start_date'=>date('Y-m-d',strtotime($this->input->post('start_date',TRUE))),'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date',TRUE))),'teacher_id'=>$user_id,'created'=>date('Y-m-d H:i:s'),'videoLink'=>$videoLink);	
				$res=$this->model_basic->_insert('assignment',$AddData);
				if(!empty($_POST['individual_user']))
				{
					foreach ($_POST['individual_user'] as $individual_user) {
						$user_assig_relation_data  = array('user_id' => $individual_user,'assignment_id'=>$res);
						$insert_user_assig_relation_data=$this->model_basic->_insert('user_assignment_relation',$user_assig_relation_data);

						$get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$individual_user));
						$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$res));
						$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$user_id));

						$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> New assignment has been assign to you by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].'<br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Start Date :'.$get_assignment_data['start_date'].'<br /> End Date :'.$get_assignment_data['end_date'].'<br />  Thank You.';
						//echo $message;die;

						$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>'New assignment has been assign to you','template'=>$message);	  
						//$sendMail = $this->model_basic->sendMail($emailData);

						$notificationEntry=array('title'=>'New assignment added','msg'=>'New assignment '.$get_assignment_data['assignment_name'].' added in creosouls by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'],'link'=>'assignment/assignment_detail/'.$res.'/'.$individual_user,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>17,'redirectId'=>$res);
						$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

						$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$individual_user);
						$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);
					    $msg = array (
									'body' 	=> '',
									'title'	=> '',
									'aboutNotification'	=> '',
									'notificationTitle'	=> 'New assignment added',
									'notificationType'	=> 17,
									'notificationId'	=> $res,
									'notificationImageUrl'	=> ''          	
						          );
						$this->model_basic->sendNotification($individual_user,$msg);							
					}
				}
			}
	
			if($_POST['tools']!='')
			{
				$tools = explode(',', $_POST['tools']);
				if(!empty($tools))
				{
					foreach($tools as $single_tool_value)
					{
						$get_tool_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>1,'attributeValue'=>$single_tool_value));
						if(!empty($get_tool_data))
						{							
							$AddToolData=array('assignment_id'=>$res,'attribute_tools_id'=>$get_tool_data['id']);	
						}
						else
						{
							$add_tool_data=array('attributeId'=>1,'attributeValue'=>$single_tool_value);
							$add_tool=$this->model_basic->_insert('attribute_value_master',$add_tool_data);
							if($add_tool>1)
							{
								$AddToolData=array('assignment_id'=>$res,'attribute_tools_id'=>$add_tool);
							}
						}
						$insert_get_tool_data=$this->model_basic->_insert('assignment_tools_relation',$AddToolData);						
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
						$get_features_data=$this->model_basic->get_where('attribute_value_master',array('attributeId'=>2,'attributeValue'=>$single_features_value));
						if(!empty($get_features_data))
						{							
							$AddfeaturesData=array('assignment_id'=>$res,'attribute_features_id'=>$get_features_data['id']);
						}
						else
						{
							$add_feature_data=array('attributeId'=>1,'attributeValue'=>$single_features_value);
							$add_feature=$this->model_basic->_insert('attribute_value_master',$add_feature_data);
							if($add_feature>1)
							{
								$AddfeaturesData=array('assignment_id'=>$res,'attribute_features_id'=>$add_feature);
							}

						}
						$insert_get_features_data=$this->model_basic->_insert('assignment_features_relation',$AddfeaturesData);					
					}
				}			
			}
			
			if($res>0)
			{
				redirect('assignment/manage_assignment/'.$user_id);
			}
			else
			{
				redirect('assignment/add_assignment');
			}
					
		}
		else
		{
			if($assignment_id!='')
			{	
				if(isset($errorMsg) && $errorMsg !='')
				{
					echo $errorMsg;die;
					$this->session->set_flashdata('fail',$errorMsg);
				}			
				$data['edit_assignment_data']=$this->assignment_model->edit_assignment_data($assignment_id);
				$data['selected_user']=$this->assignment_model->edit_assignment_selected_user($assignment_id);

			}
			$data['user_list']=$this->model_basic->getAllData('users','id,firstName,lastName,teachers_status',array('instituteId'=>$this->session->userdata('user_institute_id'),'status'=>1,'id !='=>$this->session->userdata('front_user_id')),array('teachers_status'=>'desc'));		
			//print_r($data);die;
			//print_r($this->session->all_userdata());die;
			$this->load->view('assignment_form',$data);
		}		
	}
	

	public function get_tool_name()
	{
		$res=$this->model_basic->getAllData('attribute_value_master','attributeValue',array('attributeId'=>1));
		if(!empty($res))
		{
			$data=[];
			foreach($res as $tool)
			{
				$data[]=$tool['attributeValue'];
			}
			$data++;
		}
		$datas=json_encode($data);
		print_r($datas);die;
	}

	public function get_feature_name()
	{
		$res=$this->model_basic->getAllData('attribute_value_master','attributeValue',array('attributeId'=>2));
		if(!empty($res))
		{
			$data=[];
			foreach($res as $feature)
			{
				$data[]=$feature['attributeValue'];
			}
			$data++;
		}
		$datas=json_encode($data);
		print_r($datas);die;
	}

	public function assignment_detail($assignment_id,$userId='',$sub_assig='')
	{
		$data['assignment']=$this->assignment_model->edit_assignment_data($assignment_id);
		$data['teacher']=$this->model_basic->getAllData('users','id,instituteId,firstName,lastName,email,profileImage',array('id'=>$data['assignment'][0]['teacher_id']));
		$data['project']=$this->assignment_model->getAllAssignmentData($assignment_id,'',$this->session->userdata('front_user_id'));	
		$data['my_project']=$this->assignment_model->getAllAssignmentData($assignment_id,$this->session->userdata('front_user_id'));
		if($sub_assig != '')
		{
			$data['sub_assig']=$sub_assig;
		}

		$data['tools']=$this->db->select('A.*,B.attributeValue')->from('assignment_tools_relation as A')->join('attribute_value_master as B','B.id = A.attribute_tools_id')->where('A.assignment_id',$assignment_id)->get()->result_array();

		$data['features']=$this->db->select('A.*,B.attributeValue')->from('assignment_features_relation as A')->join('attribute_value_master as B','B.id = A.attribute_features_id')->where('A.assignment_id',$assignment_id)->get()->result_array();

		
		$this->load->view('single_assignment_view',$data);		
	}

	public function more_data()
	{		
		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['assignment']) && $_POST['assignment']!='')
		{
			$assignment='';
			$data['assignment']=$this->assignment_model->getAssignmentData($_POST['assignment']);
			if(!empty($data['assignment']))
			{
				$assignment=$data['assignment'][0]['id'];
			}
	    	//$per_call_deal =2;
	    	$per_call_deal =12;
			$call_count = $_POST['call_count'];
			$this->assignment_model->more_data($per_call_deal,$call_count,$assignment);
		}
	}	

	public function assignment_approval($id,$status,$userId)
	{
		//echo "assignment_approval_student_coment";die;
		$commentedUserId = $_POST['assignmentCommentByUserId'];
		$commentedUserData=$this->model_basic->get_where('users',array('id'=>$commentedUserId));		
		$name = $commentedUserData['firstName'].' '.$commentedUserData['lastName'];
		$email = $commentedUserData['email'];
		$comment = $_POST['assignmentText'];
		$getProjectId = $this->model_basic->get_where('project_master',array('userId'=>$userId,'assignmentId'=>$id));
		$project_id=$getProjectId['id'];	
		if($status == 2)
		{		
			if($_POST['assignmentText']!='')
			{				
				$approvalData   = array(
						'name' 		=>ucwords($name),
						'email'    	=>$email,
						'comment'  	=>ucfirst($comment),
						'projectId'	=>$project_id,
						'userId'   	=>$this->session->userdata('front_user_id'),
						'created'  	=>date('Y-m-d H:i:s'),
						'status'   	=>1,
						'assignmentId'   	=>$id
					);
				
			}
			else
			{				
				$this->session->set_flashdata('fail', 'Assignment Comment is required.');
				redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id'));
			}
		}
		if($status == 3 && $comment!='')
		{		
							
			$approvalData   = array(
					'name' 		=>ucwords($name),
					'email'    	=>$email,
					'comment'  	=>ucfirst($comment),
					'projectId'	=>$project_id,
					'userId'   	=>$this->session->userdata('front_user_id'),
					'created'  	=>date('Y-m-d H:i:s'),
					'status'   	=>1,
					'assignmentId'   	=>$id
				);					
		}		

		if(!empty($approvalData) && isset($approvalData))
		{
            $get_user_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$userId));
			$get_assignment_data=$this->model_basic->getData('assignment','*',array('id'=>$id));                
      		$get_teacher_data=$this->model_basic->getData('users','firstName,lastName,email',array('id'=>$get_assignment_data['teacher_id']));			

			if($status == 3)
			{
				$notificationEntry=array('title'=>'Assignment accepted','msg'=>'Assignment '.$get_assignment_data['assignment_name'].' has been accepted successfully by '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'],'link'=>'assignment/assignment_detail/'.$id.'/'.$userId,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>17,'redirectId'=>$id);
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

				$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$userId);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);

				$subject = 'Your Assignment Has been Accepted';
				$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> Your Assignment '.$get_assignment_data['assignment_name'].' is accepted by your teacher '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].' <br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Assignment Status : Accepted <br /> <br /> Thank You.';
				
				

					 $msg = array (
								'body' 	=> '',
								'title'	=> '',
								'aboutNotification'	=> '',
								'notificationTitle'	=> 'Assignment accepted',
								'notificationType'	=> 17,
								'notificationId'	=> $id,
								'notificationImageUrl'	=> ''          	
					          );
						$this->model_basic->sendNotification($userId,$msg);
			}
			else
			{
				$notificationEntry=array('title'=>'Assignment need more work','msg'=>'Assignment '.$get_assignment_data['assignment_name'].' has been checked and you need more work for submission','link'=>'assignment/assignment_detail/'.$id.'/'.$userId,'imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>17,'redirectId'=>$id);
				$notificationId=$this->model_basic->_insert('header_notification_master',$notificationEntry);

				$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$userId);
				$this->model_basic->_insert('header_notification_user_relation',$notificationToCreUser);

				$subject = 'Your Assignment Has been Pending Resubmit it';
				$message='Hello, '.$get_user_data['firstName'].' '.$get_user_data['lastName'].'<br /> Your Assignment is evaluated by your teacher '.$get_teacher_data['firstName'].' '.$get_teacher_data['lastName'].' <br /> Assignment Name : '.$get_assignment_data['assignment_name'].'<br /> Assignment Status : Pending <br />Comments from teacher : '.ucfirst($comment).' <br /> Please make corrections and  resubmit before end date. <br /> Thank You.';
				
				$msg = array (
						'body' 	=> '',
						'title'	=> '',
						'aboutNotification'	=> '',
						'notificationTitle'	=> 'Assignment need more work',
						'notificationType'	=> 17,
						'notificationId'	=> $id,
						'notificationImageUrl'	=> ''          	
			          );
				$this->model_basic->sendNotification($userId,$msg);
			}
			
			$this->load->model('project_model');
			$ress = $this->project_model->add_comment($approvalData);
			$emailData = array('to'=>$get_user_data['email'],'fromEmail'=>$get_teacher_data['email'],'subject'=>$subject,'template'=>$message);		

			//print_r($emailData);die;			
			//$sendMail = $this->model_basic->sendMail($emailData);

			if($status == 3)
			{	
				$assignment_accepted_date = array('assignment_accepted_date'=>date('Y-m-d'));	
				$update_assignment_accepted_date = $this->model_basic->_update('project_master','id',$project_id,$assignment_accepted_date);
			}

		}

		$data = array('assignment_status'=>$status);
		$conditionArr = array('assignmentId'=>$id,'userId'=>$userId);
		$res=$this->model_basic->_updateWhere('project_master',$conditionArr,$data);
		if($res == 1)
		{
			if($status == 3)
			{
				$this->session->set_flashdata('success', 'Assignment accepted Successfully.');
				redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id'));
			}
			else
			{
				$this->session->set_flashdata('success', 'Assignment need more Work.');
				redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id'));
			}
		}
		else
		{
			$this->session->set_flashdata('fail', 'Sorry! Failed to update status.');
			redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id'));
		}
	}



	public function assignment_approval_student_coment($id,$status,$userId)
	{		
		$commentedUserId = $_POST['assignmentCommentByUserId'];
		$commentedUserData=$this->model_basic->get_where('users',array('id'=>$commentedUserId));		
		$name = $commentedUserData['firstName'].' '.$commentedUserData['lastName'];
		$email = $commentedUserData['email'];
		$comment = $_POST['assignmentText'];
		$getProjectId = $this->model_basic->get_where('project_master',array('userId'=>$userId,'assignmentId'=>$id));
		$project_id=$getProjectId['id'];	
	
		if($status = 4 && $comment!='')
		{
			$approvalData   = array(
					'name' 		=>ucwords($name),
					'email'    	=>$email,
					'comment'  	=>ucfirst($comment),
					'projectId'	=>$project_id,
					'userId'   	=>$this->session->userdata('front_user_id'),
					'created'  	=>date('Y-m-d H:i:s'),
					'status'   	=>1,
					'assignmentId'   	=>$id
				);				
			$this->load->model('project_model');
			$res = $this->project_model->add_comment($approvalData);		
			if($res > 0)
			{				
				$this->session->set_flashdata('success', 'Assignment Edited Successfully.');
				redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id'));		
			}
			else
			{				
				$this->session->set_flashdata('fail', 'Sorry! Failed to update status.');
				redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id').'/1');
			}
		}		
		else 
		{
			redirect('assignment/assignment_detail/'.$id.'/'.$this->session->userdata('front_user_id').'/1');
		}
		
	}

	public function delete($assignment_id)
	{
		$res = $this->assignment_model->deleteAssignment($assignment_id);
		if($res)
		{			
			$this->session->set_flashdata('success', 'Assignment deleted successfully');			
		}
		else
		{
			$this->session->set_flashdata('fail', 'Fail to delete Assignment');
		}
		redirect('assignment/manage_assignment/'.$this->session->userdata('front_user_id'));
	}

	public function submited_assignment()
	{
		/*if($this->session->userdata('teachers_status') == 1)
		{
			$teacher_id=$this->session->userdata('front_user_id');
		}			
		$getAllUserAssignmentPast = $this->db->select('*')->from('assignment')->where('teacher_id',$teacher_id)->where('end_date <',date('Y-m-d'))->order_by("end_date",'desc')->get()->result_array();
		$getAllUserAssignmentFuture = $this->db->select('*')->from('assignment')->where('teacher_id',$teacher_id)->where('end_date >=',date('Y-m-d'))->order_by("end_date",'asc')->get()->result_array();
		$data['getAllUserAssignment'] = $getAllUserAssignmentFuture;
		if(!empty($getAllUserAssignmentPast))
		{
			$i =count($getAllUserAssignmentFuture);
			foreach ($getAllUserAssignmentPast as $value) {
				$data['getAllUserAssignment'][$i]=$value;
				$i++;
			}
		}	*/

		if($this->session->userdata('teachers_status') == 1)
		{
			$teacher_id=$this->session->userdata('front_user_id');
		}

		$getAllUserAssignment=$this->db->select('*')->from('assignment')->where('teacher_id',$teacher_id)->order_by("end_date",'asc')->get()->result_array();
		//print_r($getAllUserAssignment);die;
		if(!empty($getAllUserAssignment))
		{
			$data['assigned']=array();
			$data['pending']=array();
			$data['resubmitted']=array();
			$data['submitted']=array();
			$data['accepted']=array();
			foreach($getAllUserAssignment as $assignment)
			{
				$TotalNoOfAssignedUser = $this->db->select('*')->from('user_assignment_relation')->where('assignment_id',$assignment['id'])->get()->num_rows();
				$TotalNoOfAssignmentSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->get()->num_rows();
				$NoOfAssignmentSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',1)->get()->num_rows();
				$NoOfAssignmentReSubmiterUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',4)->get()->num_rows();
				$NoOfAssignmentAcceptedUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',3)->get()->num_rows();
				$NoOfAssignmentPendingUser = $this->db->select('*')->from('project_master')->where('assignmentId',$assignment['id'])->where('assignment_status',2)->get()->num_rows();
		
				if($TotalNoOfAssignedUser == $NoOfAssignmentAcceptedUser)
				{					
					$data['accepted'][]=$assignment;//complited
				}
				elseif($TotalNoOfAssignedUser > $TotalNoOfAssignmentSubmiterUser && $NoOfAssignmentReSubmiterUser>0)
				{
					$data['pending'][]=$assignment; // remailng to check Re - Submited					
				}
				elseif($TotalNoOfAssignmentSubmiterUser > 0 && $NoOfAssignmentSubmiterUser > 0)
				{
					$data['assigned'][]=$assignment;//new submited 					
				}				
				elseif($assignment['end_date'] == date('Y-m-d') )
				{
					$data['resubmitted'][]=$assignment;
				}
				else
				{					
					$data['submitted'][]=$assignment;
				}
			}
		}
		else
		{
			$data=array();
		}
		//print_r($data);die;
		$data['submited_assignment'] = 1;			
		$this->load->view('assignment_view',$data);		
	}


	



}