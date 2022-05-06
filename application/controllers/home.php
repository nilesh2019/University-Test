<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('home_model');
		$this->load->model('model_basic');
		$this->load->model('modelbasic');
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->load->library('form_validation');
		$this->load->helper('text');
	}
	public function index($filter='',$userId='',$LoginId=''){
		$this->load->model('modelbasic');
		$data['project']=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName,project_master.userId',array('user_project_image.cover_pic'=>1,'project_master.featured'=>1,'project_master.status'=>1),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.featured_date','DESC'),10);
		$data['trandingInstitute']=$this->modelbasic->getValuesJoin('users','region_list.region_name,count(*) AS cnt,institute_master.instituteName,institute_master.PageName',array('institute_master.status'=>1),'result_array',array(array("institute_master","institute_master.id=users.instituteId"),array("region_list","region_list.id=institute_master.region"),array("project_master","project_master.userId=users.id")),'institute_master.id',array('cnt','DESC'),10);
		$data['trandingStudent']=$this->modelbasic->getValues('users','users.id as userId,institute_master.instituteName,users.firstname,users.lastname,users.profileimage,COUNT(DISTINCT project_master.id) AS project_count',array('project_master.status'=>1,'users.status'=>1,'users.admin_level'=>0,'users.instituteId !='=>1,'users.instituteId !='=>0),'result_array',array(array("institute_master","institute_master.id=users.instituteId"),array("project_master","project_master.userId=users.id")),'users.id',array('project_count','DESC'),10);
		$data['jobs']=array();
		if(($FRONT_USER_SESSION_ID > 0) || $FRONT_USER_SESSION_ID == 0){
			$data['jobs']=$this->modelbasic->getValues('jobs','jobs.id,jobs.title,jobs.companyLogo,jobs.companyName,jobs.no_of_position',array('jobs.featured'=>1,'jobs.status'=>1),'result_array','','',array('featured_date','DESC'),10);
		}
		$data['trandingPlacement']=$this->modelbasic->getValues('placement','student_name,company,position,profile_image',array('status'=>1,'featured'=>1),'result_array','','',array('featured_date','DESC'),10);
		$people_count1=$this->modelbasic->count_all_only('users',array('instituteId'=>0));
		$people_count2=$this->modelbasic->count_all_only('institute_csv_users',array('centerId'=>1));
		$data['people_count']=$people_count1+$people_count2;
		$data['register_student']=$this->modelbasic->count_all_only('institute_csv_users',array('centerId'=>1,'studentId !='=>''));
		$data['project_count']=$this->modelbasic->count_all_only('project_master');
		$data['job_count']=$this->modelbasic->getValue('jobs','SUM(no_of_position)',array('close_on >='=>date('Y-m-d')));
		if(isset($filter) && $filter !=''){
			$data['terms_and_condition'] = $filter;
			$data['userId'] = $userId;
			$data['loginId'] = $LoginId;
		}
		$this->load->view('home_view',$data);
	}
	/*public function index($filter='',$userId='',$LoginId='')
	{
		$this->load->model('home_model');
		$data['project']=$this->home_model->getAllProjectData();
		$data['trandingInstitute']=$this->home_model->getTrandingInstitute();
		$data['trandingStudent']=$this->home_model->getTrandingStudent();
		$data['trandingPlacement']=$this->home_model->getTrandingPlacement();
		$data['project_count']=$this->model_basic->getCountWhere('project_master','');
		$people_count1=$this->model_basic->getCountWhere('users',array('instituteId'=>'0'));
		$people_count2=$this->model_basic->getCountWhere('institute_csv_users',array('centerId'=>'1'));
		$data['register_student']=$this->home_model->getregisterStudentCount();
		$data['people_count']=$people_count1+$people_count2;
		$query=$this->db->query("SELECT SUM(no_of_position) as jobcount FROM jobs WHERE close_on>=CURDATE()");
		$job_count=$query->row_array();
		$data['job_count'] = $job_count['jobcount'];
		$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		$data['jobs']=array();
		if(($FRONT_USER_SESSION_ID > 0) || $FRONT_USER_SESSION_ID == 0)
		{
			$data['jobs']=$this->db->select('*')->from('jobs')->where('featured',1)->where('status',1)->order_by('featured_date','DESC')->limit(10)->get()->result_array();
		}
		$data['event']=$this->home_model->getAllEventData();
		$data['testimonial']=$this->home_model->getTestimonial();
		if(isset($filter) && $filter !='')
		{
			$data['terms_and_condition'] = $filter;
			$data['userId'] = $userId;
			$data['loginId'] = $LoginId;
		}
		$this->load->view('home_view',$data);
	}*/
	public function submit_feedback()
	{
		if(isset($_POST)&& !empty($_POST))
		{
			$arr = array('comment'=>$_POST['comment'],'fullName'=>$_POST['fullName'],'email'=>$_POST['email'],'created'=>date("Y-m-d H:i:s"));
			$this->load->model('home_model');
			$res = $this->home_model->addFeedBack($arr);
			if($res > 0)
			{
				$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$addedByName        = $_POST['fullName'];
				//$addedByEmail       = $emailFrom;
				$addedByEmail       = 'support@creosouls.com';
				$from               = $_POST['email'];
				$subjectBy          = 'Feedback';
				$templateAddedBy    = 'Hello <b>Admin</b>,<br />User  "<b>'.$addedByName.'</b>" sent following feedback about creosouls.<br />'.$_POST['comment'];
				$sendEmailToAddUser = array('to'=>$addedByEmail,'subject'=>$subjectBy,'template' =>$templateAddedBy,'fromEmail'=>$from);
				//$rest = $this->model_basic->sendMail($sendEmailToAddUser);
				 echo 'done';
			}
		}
	}
	public function get_category_attribute()
	{
    	if(isset($_POST['id']) && $_POST['id']!='')
		{
		    $this->load->model('home_model');
			$data = $this->home_model->get_category_attribute($_POST['id']);
			echo json_encode($data);
		}
   	}
	public function remember_action()
	{
		if($_POST && $_POST['pro_id']!='' && $_POST['image_id']=='')
		{
			$project_id = $_POST['pro_id'];
			$this->session->set_userdata('project_Id', $project_id);
			$i=1;
		}
		elseif($_POST && $_POST['pro_id']!='' && $_POST['image_id']!='')
		{
			$project_id = $_POST['pro_id'];
			$image_id = $_POST['image_id'];
			$this->session->set_userdata('project_Id', $project_id);
			$this->session->set_userdata('image_Id', $image_id);
			$i=1;
		}
		else
		{
			$i=0;
		}
		if($i==1)
		{
			$current_url = $_POST['urlName'];
			$pageName = $_POST['pageName'];
			$this->session->set_userdata('redirect_url', $current_url);
			$this->session->set_userdata('page_name', $pageName);
			echo 'done';
		}
		else{
			echo 'fail';
		}
	}
	public function get_attribute_value()
	{
    	if(isset($_POST['id']) && $_POST['id']!='')
		{
		    $this->load->model('home_model');
			$data = $this->home_model->get_attribute_value($_POST['id']);
			echo json_encode($data);
		}
    }
    public function advance_search()
	{
		if(isset($_POST) && !empty($_POST))
		{
			//print_r($_POST);die;

			$advArraySearch = array();
			//$this->session->set_userdata('advArraySearch',$advArraySearch);

			if($_POST['adv_search_for']!='')
			{
				$this->session->set_flashdata('adv_search_for',$_POST['adv_search_for']);
				//$this->session->keep_flashdata('adv_search_for');
				$advArraySearch['adv_search_for']=$_POST['adv_search_for'];
			}
			if($_POST['category']!='')
			{
				$this->session->set_flashdata('adv_category',$_POST['category']);
				//$this->session->keep_flashdata('adv_category');
				$advArraySearch['adv_category']=$_POST['category'];
			}
			if($_POST['category_id']!='')
			{
				$this->session->set_userdata('adv_category_id',$_POST['category_id']);
				//$this->session->keep_flashdata('adv_category_id');
				$advArraySearch['adv_category_id']=$_POST['category_id'];
			}
			if($_POST['attribute']!='')
			{
				$this->session->set_flashdata('adv_attribute',$_POST['attribute']);
				$advArraySearch['adv_attribute']=$_POST['attribute'];
			}
			if($_POST['attri_value']!='')
			{
				$this->session->set_flashdata('adv_attri_value',$_POST['attri_value']);
				$advArraySearch['adv_attri_value']=$_POST['attri_value'];
			}
			if($_POST['rating']!='')
			{
				$this->session->set_userdata('adv_rating',$_POST['rating']);
				$this->session->set_flashdata('adv_rating_exist','yes');

				$advArraySearch['adv_rating']=$_POST['rating'];
				$advArraySearch['adv_rating_exist']='yes';

			}
			if($_POST['attribute_id']!='')
			{
				$this->session->set_userdata('adv_attribute_id',$_POST['attribute_id']);

			}
			if($_POST['attri_value_id']!='')
			{
				$this->session->set_userdata('adv_attri_value_id',$_POST['attri_value_id']);
			}

			//$this->session->set_userdata('advArraySearch',$advArraySearch);

		}
    }
	public function checkStudentId()
	{
		$result=$this->home_model->checkStudentId();
		$lakemeResult=$this->home_model->lakmeCheckStudentId();
		if(!empty($result))
		{
			if($result['centerId'] == 2)
			{
				if($result['status'] ==1 && $result['email'] == '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "11";
				}
				elseif($result['email'] != '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "44";
				}
				else
				{
					echo "2";
				}
			} else if($result['centerId'] == 3) {

				if($result['status'] ==1 && $result['email'] == '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "333";
				}
				elseif($result['email'] != '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "666";
				}
				else
				{
					echo "2";
				}
			}
			else
			{
				if($result['status'] ==1 && $result['email'] == '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "1";
				}
				elseif($result['email'] != '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$result['centerId']);
					echo "4";
				}
				else
				{
					echo "2";
				}
			}

		} elseif (!empty($lakemeResult)) {


				if($lakemeResult['centerId'] == 3)
			{
				if($lakemeResult['status'] ==1 && $lakemeResult['email'] == '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$lakemeResult['centerId']);
					echo "333";
				}
				elseif($lakemeResult['email'] != '')
				{
					$this->session->set_userdata('studentId',$_POST['studentId']);
					$this->session->set_userdata('centerId',$lakemeResult['centerId']);
					echo "666";
				}
				else
				{
					echo "2";
				}
			}
		}
		else
		{
			echo "3";
		}
	}
	public function jobStatusFeedback()
	{
		$data = $this->home_model->jobStatusFeedback();
		$html = '';
		if(!empty($data))
		{
			$html .= '<div class="text-center"><p style="color:#252525">Congratulations! You have been selected for following job.</p></div>';
			$html .= '<div><strong>Company Name : </strong><span style="color:#414141">'.$data[0]['companyName'].'</span></div>';
			$html .= '<div><strong>Job :</strong> <span style="color:#414141">'.$data[0]['title'].'</span></div>';
			$html .='<br /> <input type="hidden" name="job_id" value="'.$data[0]["jobId"].'"><input type="hidden" name="job_user_relation_id" value="'.$data[0]["id"].'"><input type="hidden" name="user_id" value="'.$data[0]["userId"].'"><div class="form-group"><div class="col-sm-12 col-md-12"><textarea name="userFeedback" class="form-control" id="userFeedback" placeholder="Please put your feedback in here. It will help us to make the process even better for you." style="height:160px !important"></textarea></div></div><div style="margin-bottom:15px"><b>Would you like to take this job up?</b><div class="form-group "><div class="col-md-12"><input type="radio" name="selectJobStatus" value="4">&nbsp;&nbsp;Yes &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="selectJobStatus" value="5">&nbsp;No</div></div></div> ';
		}

		echo $html;
	}
	public function submitJobFeedback()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('userFeedback', 'Job feedback', 'trim|required');
		$this->form_validation->set_rules('selectJobStatus', 'Job status', 'trim|required');
		if($this->form_validation->run())
		{
			$jobFeedbackData = array('jobId'=>$_POST['job_id'],'userId'=>$_POST['user_id'],'feedback'=>$_POST['userFeedback']);
			$res = $this->model_basic->_insert('job_feedback',$jobFeedbackData);
			$jobStstusData = array('apply_status'=>$_POST['selectJobStatus']);
			$updateStatus = $this->model_basic->_update('job_user_relation','id',$_POST['job_user_relation_id'],$jobStstusData);
			if($updateStatus == 1)
			{
				$data=array('status'=>'success','message'=>'Feedback submited successfully.');
				$this->session->set_userdata('jobStatusFeedback',0);
			}
			else
			{
				$data=array('status'=>'fail','message'=>'Error occurred while submitting feedback please try again....');
			}
			echo json_encode($data);
		}
		else
		{
			echo $this->form_validation->get_json();
		}
	}

	function help()
	{
		$this->load->view('help_view');
	}

	public function getalluserdata()
	{
		$data=$this->user_model->getalluserdata();
		$i=1;
		foreach($data as $dt)
		{
			$dt['sr']=$i;
			if($dt['isAppInstalled'] !='')
			{
				$dt['isAppInstalled']='Yes';
			}
			else
			{
				$dt['isAppInstalled']='No';
			}
			$users[]=$dt;
			$i++;
		}
		$path=date('M d Y').time().'.csv';
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="'.$path.'"');
		if(!empty($users))
		{
		    $fh = fopen('php://output', 'w');
		    fputcsv($fh, array('Sr. No','Student Id','First Name','Last Name','Email Id','is App Installed?'));
		    fputcsv($fh, array_keys(current($users)));
		    foreach ( $users as $row )
		    {
		            fputcsv($fh, $row);
		    }
		}
	}

	public function set_block_user_session()
	{
		$set_block_maac_user_session = json_decode($_GET['arr']);
		//print_r($set_block_maac_user_session);die;
		if(!empty($set_block_maac_user_session))
		{
			if(isset($set_block_maac_user_session->studentId) && $set_block_maac_user_session->studentId!='')
			{
				$this->session->unset_userdata('studentId');
			}
			if(isset($set_block_maac_user_session->correctEmail) && $set_block_maac_user_session->correctEmail!='')
			{
				$this->session->set_userdata('correctEmail',$set_block_maac_user_session->correctEmail);
			}
			if(isset($set_block_maac_user_session->blockUser) && $set_block_maac_user_session->blockUser!='')
			{
				$this->session->set_userdata('blockUser',$set_block_maac_user_session->blockUser);
			}
		}
		redirect(base_url());
	}
	public function recaptchphp()
	{
		$this->load->view("checkrecaptcha");
	}

	public function checkPdf_generation()
	{
		$this->load->library("Report_creation");
		$pdfname = 'Invoice Pdf';
		//$this->load->view('srt-resume2');
		$html = $this->load->view('srt-resume2','',TRUE);
		$this->report_creation->create_pdf($html,$pdfname);
	}

	public function mailCheking(){
		  $this->load->library('email');
    $to_email = 'myphpwordpress@gmail.com';
    $from_email = 'creosoulscomp5@gmail.com';

    $config = array(
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'mailtype' => 'html'
                );

    $this->email->initialize($config);

     $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Test mail send');
                $this->email->message('Test Mail');

    if($this->email->send()){
    echo "send";
    }else{
    echo "error";
    }
	}

	public function sendemaildtosupport()
	{

		$tokanno= $this->generateRandomString();
		/*	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('ins_name', 'Institite Name', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|valid_email');
		$this->form_validation->set_rules('studentId', 'Studnet Id', 'trim|required');
		$this->form_validation->set_rules('contactNo', 'Contact No', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('receiptno', 'Receipt No', 'trim|required');
		if($this->form_validation->run())
		{echo "asd";
		*/	$data=array();
			if(isset($_POST['categorytype']))
			{
				$data['categorytype']=$_POST['categorytype'];
			}
			if(isset($_POST['ins_name']))
			{
				$data['ins_name']=$_POST['ins_name'];
			}
			if(isset($_POST['fullname']))
			{
				$data['fullname']=$_POST['fullname'];
			}
			if(isset($_POST['studentId']))
			{
				$data['studentId']=$_POST['studentId'];
			}
			if(isset($_POST['contactNo']))
			{
				$data['contactNo']=$_POST['contactNo'];
			}
			if(isset($_POST['email']))
			{
				$data['email']=$_POST['email'];
			}
			if(isset($_POST['coursename']))
			{
				$data['coursename']=$_POST['coursename'];
			}
			
			if(isset($_POST['start_date']))
			{
				$data['start_date']=$_POST['start_date'];
			}
			if(isset($_POST['end_date']))
			{
				$data['end_date']=$_POST['end_date'];
			}
			if(isset($_POST['receiptimage']))
			{
				$data['receiptimage']=$_FILES['receiptimage']['name'];
			}
			if(isset($tokanno))
			{
				$data['reference_no']=$tokanno;
			}

			$image = $_FILES['receiptimage']['name'];
				
				//$data['errortext']=$_POST['errorinput'];
			if(isset($_FILES['receiptimage']) && $_FILES['receiptimage']['size'] != 0)
			{
				$upload_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/receipt";
					
				if (!is_dir($upload_dir))
				{
					mkdir($upload_dir, 0777, TRUE);
				}
				$config['upload_path']   = $upload_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|html|htm|pdf';
				$config['file_name']     = $image;
				$config['max_size']	 = '5000';
				$config['maintain_ratio'] = TRUE;
									
				$config['master_dim'] = 'width';
				$config['max_width']  = '5000';
				$config['max_height']  = '5000';
				$config['overwrite'] = TRUE;
				$this->upload->initialize($config);
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('receiptimage'))
				{
					$error = array('error' => $this->upload->display_errors());
				}
				else
				{	

					$uploaddata = array('upload_data' => $this->upload->data());
					$filename = $this->upload->data();
					    
				}

			}
		$qry=$this->model_basic->_insert('table_support_issue',$data);

		/*}*/
		$subject='Someone Submited The Issue Refernec No #'.$tokanno;
		$filename = $filename['file_name'];
		$filePath = $_SERVER['DOCUMENT_ROOT']."/uploads/receipt/".$filename;
		$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$template='Hello,<br/><br/> '.ucfirst($_POST['fullname']).' has submited the issue kindly check below Student details <b><br/><br/><b> Institute Name '.$_POST['ins_name'].' </b><br/><br/><b> Student Id '.$_POST['studentId'].' </b><br/><br/><b> Contact No '.$_POST['contactNo'].' </b><br/><br/><b> Email '.$_POST['email'].' </b><br/><br/><b> Course Name '.$_POST['coursename'].' </b><br/><br/><b> Start Date '.$_POST['start_date'].' </b><br/><br/><b> End Date '.$_POST['end_date'].' </b>';
		//$CClist = array('bhupendra.chaudhary@emmersivetech.com');
		$data=array('fromEmail'=>$emailFrom,'to'=>"support@creosouls.com",'subject'=>$subject,'template'=>$template,'attachment'=>$filePath);
		$template1='Hello,<br/><br/> '.ucfirst($_POST['fullname']).' your issue has been submited creosouls, <b><br/><br/><b> kindly note down below Refrence No for further updates. </b><br/> <b>Refernec No </b> '.$tokanno.' </b><br/>';
		$data1=array('fromEmail'=>$emailFrom,'to'=>$_POST['email'],'cc'=>"swapna.jiwtode@emmersivetech.com",'subject'=>$subject,'template'=>$template1);
		//$this->model_basic->sendMail($data1);
		if($qry && $this->model_basic->sendMailToSupport($data))
		{
			echo "Success_".$tokanno;
		}
		else
		{
			echo"Error";
		}
	}

	public function generateRandomString($length = 10)
	{
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function singlesignon_for_aptech_user(){
		if(isset($_SERVER['HTTP_REFERER'])){
			$domain = parse_url($_SERVER['HTTP_REFERER']);
			if($domain['host']=='staging.creonow.com' || $domain['host']=='staging3.aptrack.asia' || $domain['host']=='staging5.aptrack.asia'|| $domain['host']=='aptrack.asia'){
			   	$validClientId='78b18083f68552d18777c9258bf23762';
			    $validSecretKey='264c52176aa143b0a4c3073c5556e0c7';
			    if(isset($_GET) && !empty($_GET)){	    	
			    	if(isset($_GET['client_id']) && $_GET['client_id']!=''){
				        $clientId = $_GET['client_id'];
				        if($clientId != $validClientId){
				            echo '<br/>Invalid API client ID.';die;
				        }
				    }else{
				        echo '<br/>Client Id is required.';die;
				    }
				    if(isset($_GET['secret_key']) && $_GET['secret_key']!=''){
				        $secret_key = $_GET['secret_key'];
				        if($secret_key != $validSecretKey){
				            echo '<br/>Invalid API secret key.';die;
				        }
				    }else{
				        echo '<br/>Secret key is required.';die;
				    }
				    if(isset($_GET['Role_Code']) && $_GET['Role_Code']!=''){
				        $Role_Code = $_GET['Role_Code'];
				        if($Role_Code=='RAH'){
				        	$Role_Code = 4;
				        }
				        if($Role_Code=='RPH'){
				        	$Role_Code = 5;
				        }
				        if($Role_Code=='Admin'){
				        	$Role_Code = 1;
				        }
				        if($Role_Code=='Mkt Admin'){
				        	$Role_Code = 6;
				        }
				    }else{

				       if($_GET['Email_ID'] == 'abir@aptech.ac.in'){
				       	    $Role_Code = 1;
				       }elseif($_GET['Email_ID'] == 'vishalv@aptech.ac.in'){
				       		$Role_Code = 1;
				       }
				       elseif($_GET['Email_ID'] == 'rimik@aptech.ac.in'){
				       		$Role_Code = 1;
				       }
				       elseif($_GET['Email_ID'] == 'sonian@aptech.ac.in'){
				       		$Role_Code = 1;
				       }else{
				       		$Role_Code = 0;
				       }
				       
				    }
				    if(isset($_GET['Zone_Name']) && $_GET['Zone_Name']!=''){
				        $Zone_Name = $_GET['Zone_Name'];
				    }else{
				        if($Role_Code == 1){
				            $Zone_Name = "";
				        }else{
				            echo 'Zone name is required.';die;
				        }	        
				    }
				    if(isset($_GET['User_Name']) && $_GET['User_Name']!=''){
				        $User_Name = $_GET['User_Name'];
				    }else{
				        echo 'User name is required.';die;
				    }
				    if(isset($_GET['Email_ID']) && $_GET['Email_ID']!=''){
				        $Email_ID = $_GET['Email_ID'];
				    }else{
				        echo 'Email id is required.';die;
				    }
				    if(isset($_GET['Login_ID']) && $_GET['Login_ID']!=''){
				        $Login_ID = $_GET['Login_ID'];
				    }else{
				        echo 'Login id is required.';die;
				    }
				    if(isset($_GET['Brand_ID']) && $_GET['Brand_ID']!=''){
				        $Brand_ID = $_GET['Brand_ID'];
				    }else{
				        echo 'Brand id is required.';die;
				    }
				    $adminpassword = random_string('alnum', 10);
				    $userdata = array(
				              'firstName'   => $User_Name,
				              'email'       => $Email_ID,
				              'aptech_email'=> $Email_ID,
				              'admin_level' => $Role_Code,
				              'aptech_id'   => $Login_ID,
				              'status'      => 1,
				              'created'     => date('Y-m-d h:i:s')
				    );
				    $adminUserData = array(
				              'name'    => $User_Name,
				              'email'   => $Email_ID,
				              'aptech_email'  => $Email_ID,
				              'password'=> md5($adminpassword),
				              'aptech_id'   => $Login_ID,
				              'level'   => $Role_Code,
				              'status'  => 1,
				              'created' => date('Y-m-d h:i:s')
				    );
				    $maac = $this->load->database('maac_db', TRUE);
				    $lakme = $this->load->database('lakme_db', TRUE);
				    if($Brand_ID == 44){
				        $checkUserArena = $this->db->select('id,admin_level')->from('users')->where('aptech_email',$Email_ID)->get()->row_array();
				        if(!empty($checkUserArena)){
				            $userDataArray=array('front_user_id' => $checkUserArena['id'],'front_is_logged_in' => 'true','user_admin_level' => $checkUserArena['admin_level']);
				            $this->session->set_userdata($userDataArray);	            
				            $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				            $userDataJSONArray=json_encode(array('front_user_id' => $checkUserArena['id'],'user_admin_level' => $checkUserArena['admin_level'],'front_is_logged_in' => true));
                            redirect(base_url().'home/set_aptech_user_session?arr='.$userDataJSONArray);
				        }else{
				            if($Role_Code == 1){
				                $this->db->insert('users',$userdata);
				                $user_id = $this->db->insert_id();
				                $this->db->insert('admin',$adminUserData);
				                $admin_id = $this->db->insert_id();
				                $userDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userDataArray);	                
				                $this->session->set_flashdata('sucess', 'You have logged in using single sign on 1.');
				                $userDataJSONArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
                            	redirect(base_url().'home/set_aptech_user_session?arr='.$userDataJSONArray);
				            }elseif ($Role_Code == 4 || $Role_Code == 5 || $Role_Code == 6) {
				                $this->db->insert('users',$userdata);
				                $user_id = $this->db->insert_id();
				                $this->db->insert('admin',$adminUserData);
				                $admin_id = $this->db->insert_id();
				                $get_zone_id = $this->db->select('id')->from('zone_list')->where('zone_name',$Zone_Name)->get()->row_array();
				                if(empty($get_zone_id)){
				                    echo 'Zone not found.';die;
				                }else{
				                    $zone_id = $get_zone_id['id'];
				                }
				                if($zone_id!= '' ){   
				                    $getRegion =  $this->db->select('id')->from('region_list')->where('zone_id',$zone_id)->get()->result_array();     
				                    if(isset($getRegion) && !empty($getRegion)){                       
				                        foreach ($getRegion as $key => $value){                           
				                            $selectInstitute = $this->db->select('id')->from('institute_master')->where('region',$value['id'])->get()->result_array();  
				                            if(!empty($selectInstitute)){
				                                foreach ($selectInstitute as $inst_key => $region_instituteId){                                   
				                                    $region_instituteId_Data = array('hoadmin_id'=>$admin_id,'institute_id'=>$region_instituteId['id'],'region'=>$value['id'],'zone'=>$zone_id);
				                                    $this->modelbasic->_insert('hoadmin_institute_relation',$region_instituteId_Data);                              
				                                }
				                            }
				                        }
				                    }
				                }
				                $userDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userDataArray);	                
				                $this->session->set_flashdata('sucess', 'You have logged in using single sign on 2.');
				                $userDataJSONArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
                            	redirect(base_url().'home/set_aptech_user_session?arr='.$userDataJSONArray);
				            }
				        }
				    }
				    if($Brand_ID == 104){
				        $checkUserMAAC = $maac->select('id,admin_level')->from('users')->where('aptech_email',$Email_ID)->get()->row_array();
				        if(!empty($checkUserMAAC)){
				            $userMAACDataArray=array('front_user_id' => $checkUserMAAC['id'],'front_is_logged_in' => 1,'user_admin_level' => $checkUserMAAC['admin_level']);
				            $this->session->set_userdata($userMAACDataArray);	            
				            $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				            $userDataJSONMAACArray=json_encode(array('front_user_id' => $checkUserMAAC['id'],'user_admin_level' => $checkUserMAAC['admin_level'],'front_is_logged_in' => 1));
                            redirect(maac_base_url().'home/set_aptech_user_session?arr='.$userDataJSONMAACArray);
				        }else{
				            if($Role_Code == 1){
				                $maac->insert('users',$userdata);
				                $user_id = $maac->insert_id();
				                $maac->insert('admin',$adminUserData);
				                $admin_id = $maac->insert_id();
				                $userMAACDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userMAACDataArray);
				    			$this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				                $userDataJSONMAACArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
                    			redirect(maac_base_url().'home/set_aptech_user_session?arr='.$userDataJSONMAACArray);
				            }elseif ($Role_Code == 4 || $Role_Code == 5 || $Role_Code == 6){
				                $maac->insert('users',$userdata);
				                $user_id = $maac->insert_id();
				                $maac->insert('admin',$adminUserData);
				                $admin_id = $maac->insert_id();
				                $get_zone_id = $maac->select('id')->from('zone_list')->where('zone_name',$Zone_Name)->get()->row_array();
				                if(empty($get_zone_id)){
				                    echo 'Zone not found.';die;
				                }else{
				                    $zone_id = $get_zone_id['id'];
				                }
				                if($zone_id!= ''){   
				                    $getRegion =  $maac->select('id')->from('region_list')->where('zone_id',$zone_id)->get()->result_array();     
				                    if(isset($getRegion) && !empty($getRegion)){                       
				                        foreach ($getRegion as $key => $value){                           
				                            $selectInstitute = $maac->select('id')->from('institute_master')->where('region',$value['id'])->get()->result_array();  
				                            if(!empty($selectInstitute)){
				                                foreach ($selectInstitute as $inst_key => $region_instituteId){                                   
				                                    $region_instituteId_Data = array('hoadmin_id'=>$admin_id,'institute_id'=>$region_instituteId['id'],'region'=>$value['id'],'zone'=>$zone_id);
				                                    $maac->insert('hoadmin_institute_relation',$region_instituteId_Data);                              
				                                }
				                            }
				                        }
				                    }
				                }
				                $userMAACDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userMAACDataArray);	                
				                $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				                $userDataJSONMAACArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
                    			redirect(maac_base_url().'home/set_aptech_user_session?arr='.$userDataJSONMAACArray);
				            }
				        }
				    }
				    if($Brand_ID == 111){
				    	$lakme_base_url_var = $this->config->config['lakme_base_url'];
				        $checkUserLakme = $lakme->select('id,admin_level')->from('users')->where('aptech_email',$Email_ID)->get()->row_array();
				        if(!empty($checkUserLakme)){
				            $userLakmeDataArray=array('front_user_id' => $checkUserLakme['id'],'front_is_logged_in' => 1,'user_admin_level' => $checkUserLakme['admin_level']);
				            $this->session->set_userdata($userLakmeDataArray);	            
				            $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				            $userDataJSONLakmeArray=json_encode(array('front_user_id' => $checkUserLakme['id'],'user_admin_level' => $checkUserLakme['admin_level'],'front_is_logged_in' => 1));
                            redirect($lakme_base_url_var.'home/set_aptech_user_session?arr='.$userDataJSONLakmeArray);
				        }else{
				            if($Role_Code == 1){
				                $lakme->insert('users',$userdata);
				                $user_id = $lakme->insert_id();
				                $lakme->insert('admin',$adminUserData);
				                $admin_id = $lakme->insert_id();
				                $userLakmeDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userLakmeDataArray);	                
				                $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				                $userDataJSONLakmeArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
				                redirect($lakme_base_url_var.'home/set_aptech_user_session?arr='.$userDataJSONLakmeArray);
				            }elseif ($Role_Code == 4 || $Role_Code == 5 || $Role_Code == 6){
				                $lakme->insert('users',$userdata);
				                $user_id = $lakme->insert_id();
				                $lakme->insert('admin',$adminUserData);
				                $admin_id = $lakme->insert_id();
				                $get_zone_id = $lakme->select('id')->from('zone_list')->where('zone_name',$Zone_Name)->get()->row_array();
				                if(empty($get_zone_id)){
				                    echo 'Zone not found.';die;
				                }else{
				                    $zone_id = $get_zone_id['id'];
				                }
				                if($zone_id!= ''){   
				                    $getRegion =  $lakme->select('id')->from('region_list')->where('zone_id',$zone_id)->get()->result_array();     
				                    if(isset($getRegion) && !empty($getRegion)){                       
				                        foreach ($getRegion as $key => $value){                           
				                            $selectInstitute = $lakme->select('id')->from('institute_master')->where('region',$value['id'])->get()->result_array();  
				                            if(!empty($selectInstitute)){
				                                foreach ($selectInstitute as $inst_key => $region_instituteId){                                   
				                                    $region_instituteId_Data = array('hoadmin_id'=>$admin_id,'institute_id'=>$region_instituteId['id'],'region'=>$value['id'],'zone'=>$zone_id);
				                                    $lakme->insert('hoadmin_institute_relation',$region_instituteId_Data);                              
				                                }
				                            }
				                        }
				                    }
				                }
				                $userLakmeDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userLakmeDataArray);
				    			$this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				                $userDataJSONLakmeArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
				                redirect($lakme_base_url_var.'home/set_aptech_user_session?arr='.$userDataJSONLakmeArray);
				            }else{
				            	$lakme->insert('users',$userdata);
				                $user_id = $lakme->insert_id();
				                $lakme->insert('admin',$adminUserData);
				                $admin_id = $lakme->insert_id();
				                $userLakmeDataArray=array('front_user_id' => $user_id,'front_is_logged_in' => 1,'user_admin_level' => $Role_Code);
				                $this->session->set_userdata($userLakmeDataArray);	                
				                $this->session->set_flashdata('sucess', 'You have logged in using single sign on.');
				                $userDataJSONLakmeArray=json_encode(array('front_user_id' => $user_id,'user_admin_level' => $Role_Code,'front_is_logged_in' => 1));
				                redirect($lakme_base_url_var.'home/set_aptech_user_session?arr='.$userDataJSONLakmeArray);
				            }
				        }
				    }	    
			    }else{
			    	echo 'Aptech user data is required.';die;
			    }
			}else{
				echo 'Request from Aptech Website is allowed.';die;
			}
		}else{
			echo 'Direct http request or request from Creosouls own website is not allowed to this url.';die;
		}	   	
	}

	public function set_aptech_user_session()
	{
		$set_aptech_user_session = json_decode($_GET['arr']);
		
		if(!empty($set_aptech_user_session))
		{
			if(isset($set_aptech_user_session->front_user_id) && $set_aptech_user_session->front_user_id!='')
			{
				$this->session->set_userdata('front_user_id',$set_aptech_user_session->front_user_id);
			}
			if(isset($set_aptech_user_session->user_admin_level) && $set_aptech_user_session->user_admin_level!='')
			{
				$this->session->set_userdata('user_admin_level',$set_aptech_user_session->user_admin_level);
			}
			$this->session->set_userdata('front_is_logged_in',true);
		}
		redirect(base_url().'home');
	}
}
