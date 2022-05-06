<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('model_basic');
		$this->load->model('assignment_model');
		$this->load->model('competition_model');
		$this->load->model('creative_mind_competition_model');
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','Profile');
		$this->session->set_userdata('breadCrumbLink','profile');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['user_profile']=$this->user_model->getUserProfileData();
		/*	$data['user_social_links']=$this->user_model->getUserSocialData();
		$data['user_web_links']=$this->user_model->getUserWebsiteData();*/
		/*	$data['project_data']=$this->user_model->getUserProjectData();*/
		$data['showreel']=$this->user_model->checkshowreel();
		if(isset($data['showreel']) && !empty($data['showreel']))
		{
			$data['complete_project']=$this->user_model->getUsershowreelProject();
		}
		else
		{
			$data['complete_project']=$this->user_model->getUserCompleteProject();
		}
		
		//$data['complete_project']=$this->user_model->getUserCompleteProject();

		/*	
		$data['work_progress_project']=$this->user_model->getUserWorkProgressProject();
		$data['appreciated']=$this->user_model->getUserAppreciatedProject();
		$data['viewed']=$this->user_model->getUserLikedOnProject();
		$data['competition_project']=$this->user_model->getUserCompetitionProject();
		$data['discussed']=$this->user_model->getUserCommentedOnProject();*/
		$data['view_like_cnt']=$this->user_model->getViewLikeCnt();
		$data['followers']=$this->user_model->getFollowers();
		$data['followerslist']=$this->user_model->getFollowersList();
		$data['following']=$this->user_model->getFollowing();
		$data['followinglist']=$this->user_model->getFollowingList();
		$data['awards']=$this->user_model->getAwardData();
		$data['educationData']=$this->user_model->getUserHighestEducationData();
		$data['workData']=$this->user_model->getUserWorkData_new();
		$data['workshopData']=$this->user_model->getWorkshopData($uid);
		$data['locationData']=$this->user_model->getLocationData();
		$data['languageData']=$this->user_model->getLanguageData();
		$this->load->view('profile_view',$data);
	}
	public function more_data()
	{
    	$per_call_deal = 12;
		$call_count = $_POST['call_count'];
		if(isset($_POST['active_tab']) && $_POST['active_tab']!='')
		{
				$active_tab = $_POST['active_tab'];
		}
		else
		{
				$active_tab = '';
		}
		if(isset($_POST['other_user']) && $_POST['other_user']!='')
		{
			$other_user = $_POST['other_user'];
		}
		else
		{
			$other_user='';
		}
		$this->user_model->more_data($per_call_deal,$call_count,$other_user,$active_tab);
		//echo $this->db->last_query();exit();
	}
	public function juryCompitations()
	{
		$juryId=$this->model_basic->getValue('competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");

		$data['juryCompitationsInprogress']=$this->competition_model->getJuryCompetitionsInprogress($juryId);
		$data['juryCompitationsCompleted']=$this->competition_model->getJuryCompetitionsCompleted($juryId);
		$data['juryCompitationsEvaluating']=$this->competition_model->getJuryCompetitionsEvaluating($juryId);
		$data['juryCompitationsEvaluated']=$this->competition_model->getJuryCompetitionsEvaluated($juryId);
		
		$data['user_profile']=$this->user_model->getUserProfileData();
		$this->session->unset_userdata('catid');
		$this->session->unset_userdata('compProjRatingFrom');
		$this->session->unset_userdata('compProjRatingTo');
		$this->load->view('jury_view',$data);
	}
	public function creativejuryCompitations()
	{
		$juryId=$this->model_basic->getValue('creative_competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");
		//echo $juryId;die;

		$data['juryCompitationsInprogress']=$this->creative_mind_competition_model->getJuryCompetitionsInprogress($juryId);
		$data['juryCompitationsCompleted']=$this->creative_mind_competition_model->getJuryCompetitionsCompleted($juryId);
		$data['juryCompitationsEvaluating']=$this->creative_mind_competition_model->getJuryCompetitionsEvaluating($juryId);
		$data['juryCompitationsEvaluated']=$this->creative_mind_competition_model->getJuryCompetitionsEvaluated($juryId);
		//pr($data);
		$data['user_profile']=$this->user_model->getUserProfileData();
		$this->load->view('creative_jury_view',$data);
	}
	public function sort_by()
	{
    	if(isset($_POST['name']) && $_POST['name']!='')
		{
		  	if($_POST['name']=='completed')
			{
				$this->session->set_userdata('sort_by','completed');
			}
			if($_POST['name']=='in_progress')
			{
				$this->session->set_userdata('sort_by','in_progress');
			}
			if($_POST['name']=='appreciated')
			{
				$this->session->set_userdata('sort_by','appreciated');
			}
			if($_POST['name']=='likedOn')
			{
				$this->session->set_userdata('sort_by','likedOn');
			}
			if($_POST['name']=='discussedOn')
			{
				$this->session->set_userdata('sort_by','discussedOn');
			}
			if($_POST['name']=='competition')
			{
				$this->session->set_userdata('sort_by','competition');
			}
			if($_POST['name']=='all')
			{
				$this->session->unset_userdata('sort_by');
			}
		}
		echo 'done';
	}


	function url_check($url)
	{
		if($url != '')
		{
			//$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
			
			$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			  if (!preg_match($pattern, $url))
			  {
			  	$this->form_validation->set_message('url_check', 'Please enter valid Url');
			      return FALSE;
			  }
			  return TRUE;
		}
		else
		{
			return TRUE;
		}	 
	}

	public function edit_profile()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');	

		if(isset($_POST['facebook']))
		{
			$this->form_validation->set_rules('facebook', 'Facebook', 'callback_url_check');
		}
		if(isset($_POST['twitter']))
		{
			$this->form_validation->set_rules('twitter', 'Twitter', 'callback_url_check');
		}
		if(isset($_POST['google']))	
		{
			$this->form_validation->set_rules('google', 'Google', 'callback_url_check');
		}	
		if(isset($_POST['pinterest']))
		{
			$this->form_validation->set_rules('pinterest', 'Pinterest', 'callback_url_check');
		}
		if(isset($_POST['instagram']))
		{
			$this->form_validation->set_rules('instagram', 'Instagram', 'callback_url_check');
		}
		if(isset($_POST['linkedin']))
		{
			$this->form_validation->set_rules('linkedin', 'Linkedin', 'callback_url_check');
		}		
		if(isset($_POST['behance']))
		{
			$this->form_validation->set_rules('behance', 'behance', 'callback_url_check');
		}
		if(isset($_POST['deviantart']))
		{
			$this->form_validation->set_rules('deviantart', 'deviantart', 'callback_url_check');
		}	
		$id = $this->session->userdata('front_user_id');
		if($this->form_validation->run() && isset($_POST['facebook']))
		{				
			
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('facebook'=>$_POST['facebook']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'facebook'=>$_POST['facebook']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		else if($this->form_validation->run() && isset($_POST['twitter']))
		{			
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('twitter'=>$_POST['twitter']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'twitter'=>$_POST['twitter']));
			}
			redirect(base_url().'profile/edit_profile');
		}	
		elseif($this->form_validation->run() && isset($_POST['google']))
		{
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('google'=>$_POST['google']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'google'=>$_POST['google']));
			}
			redirect(base_url().'profile/edit_profile');
		 }
		  elseif($this->form_validation->run() && isset($_POST['pinterest']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('pinterest'=>$_POST['pinterest']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'pinterest'=>$_POST['pinterest']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		elseif($this->form_validation->run() && isset($_POST['instagram']))
		{
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('instagram'=>$_POST['instagram']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'instagram'=>$_POST['instagram']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		elseif($this->form_validation->run() && isset($_POST['linkedin']))
		{
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('linkedin'=>$_POST['linkedin']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'linkedin'=>$_POST['linkedin']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		elseif($this->form_validation->run() && isset($_POST['behance']))
		{
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('behance'=>$_POST['behance']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'behance'=>$_POST['behance']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		elseif($this->form_validation->run() && isset($_POST['deviantart']))
		{
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('deviantart'=>$_POST['deviantart']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'deviantart'=>$_POST['deviantart']));
			}
			redirect(base_url().'profile/edit_profile');
		}
		else 
		{
			$data['user_profile']=$this->user_model->getUserProfileData();
            //echo "<pre>";print_r($data['user_profile']);exit();
			$data['notification']=$this->user_model->getUserNotificationData();
			$data['workData']=$this->user_model->getUserWorkData();
			$data['skillsData']=$this->user_model->getUserSkillData();
			$data['educationData']=$this->user_model->getUserEducationData();
			$data['websiteData']=$this->user_model->getUserWebsiteData();
			$data['cardData']=$this->user_model->getUserCardData();
			$data['socialData']=$this->user_model->getUserSocialData();
			$data['awardData']=$this->user_model->getAwardData();
			$data['workshopData']=$this->user_model->getWorkshopData($uid);
			$data['locationData']=$this->user_model->getLocationData();
			$data['languageData']=$this->user_model->getLanguageData();
			$data['usedDiskSpace']=$this->getDiskSpace();
			$data['allowedDiskSpace']=$this->user_model->getAllowedDiskSpace();
			$this->load->view('edit_profile_view',$data);
		}
	}
	public function submitFeedback()
	{
		
		//$this->load->library('form_validation');
		$this->form_validation->set_rules('feedbackInstance','Feedback Instance','trim|xss_clean|required');
		$this->form_validation->set_rules('q1','answer for question 1','trim|xss_clean|required');
		$this->form_validation->set_rules('q2','answer for question 2','trim|xss_clean|required');
		$this->form_validation->set_rules('q3','answer for question 3','trim|xss_clean|required');
		$this->form_validation->set_rules('q4','answer for question 4','trim|xss_clean|required');
		$this->form_validation->set_rules('q5','answer for question 5','trim|xss_clean|required');
		$this->form_validation->set_rules('q6','answer for question 6','trim|xss_clean|required');
		$this->form_validation->set_rules('q7','answer for question 7','trim|xss_clean|required');
		$this->form_validation->set_rules('q8','answer for question 8','trim|xss_clean|required');
		$this->form_validation->set_rules('q9','answer for question 9','trim|xss_clean|required');
		$this->form_validation->set_rules('q10','answer for question 10','trim|xss_clean|required');
		$this->form_validation->set_rules('q11','answer for question 11','trim|xss_clean|required');
		$this->form_validation->set_rules('q12','answer for question 12','trim|xss_clean|required');
		$this->form_validation->set_rules('q13','answer for question 13','trim|xss_clean|required');
		$this->form_validation->set_rules('q14','answer for question 14','trim|xss_clean|required');
		$this->form_validation->set_rules('q15','answer for question 15','trim|xss_clean|required');
		$this->form_validation->set_rules('q16','answer for question 16','trim|xss_clean|required');
		$this->form_validation->set_rules('q17','answer for question 17','trim|xss_clean|required');
		$this->form_validation->set_rules('q18','answer for question 18','trim|xss_clean|required');
		$this->form_validation->set_rules('q19','answer for question 19','trim|xss_clean|required');
		$this->form_validation->set_rules('q20','answer for question 20','trim|xss_clean|required');
		$this->form_validation->set_rules('q21','your comment','trim|xss_clean|required');
		if($this->form_validation->run())
		{
			$q1=$_POST['q1'];$q2=$_POST['q2'];$q3=$_POST['q3'];$q4=$_POST['q4'];$q5=$_POST['q5'];$q6=$_POST['q6'];$q7=$_POST['q7'];$q8=$_POST['q8'];$q9=$_POST['q9'];$q10=$_POST['q10'];$q11=$_POST['q11'];$q12=$_POST['q12'];$q13=$_POST['q13'];$q14=$_POST['q14'];$q15=$_POST['q15'];$q16=$_POST['q16'];$q17=$_POST['q17'];$q18=$_POST['q18'];$q19=$_POST['q19'];$q20=$_POST['q20'];$q21=$_POST['q21'];
			$user_id=$this->session->userdata('front_user_id');
			$institute_id=$this->session->userdata('user_institute_id');
			$instanceId=$this->session->userdata('instanceId');
			$data=array('q1'=>$q1,'q2'=>$q2,'q3'=>$q3,'q4'=>$q4,'q5'=>$q5,'q6'=>$q6,'q7'=>$q7,'q8'=>$q8,'q9'=>$q9,'q10'=>$q10,'q11'=>$q11,'q12'=>$q12,'q13'=>$q13,'q14'=>$q14,'q15'=>$q15,'q16'=>$q16,'q17'=>$q17,'q18'=>$q18,'q19'=>$q19,'q20'=>$q20,'q21'=>$q21,'user_id'=>$user_id,'institute_id'=>$institute_id,'instance_id'=>$instanceId);
			$this->load->model('model_basic');
			$result = $this->user_model->checkFeedbackExist($instanceId,1);
			if(!empty($result) && ($result[0]['msg'] != 'invalid')){
				if(isset($_POST['feedbackId']) && $_POST['feedbackId'] !=''){
					//echo "hi1";die;
					$res=$this->model_basic->_update('institutefeedback','id',$_POST['feedbackId'],$data);
					$flag = 2;
				}else{
					//echo "hi2";die;
					$res=$this->model_basic->_insert('institutefeedback',$data);
					$flag = 1;
				}
				if($res > 0)
				{
					$instAdminData=$this->user_model->getInstAdminData($institute_id);
					$frontUserData=$this->user_model->getFrontUserData($user_id);
					$feedbackInstanceName = $this->model_basic->getValue('feedback_instance',"name","id=".$_POST['feedbackInstance']);
					$msg='Hello '.$instAdminData[0]['firstName'].' '.$instAdminData[0]['lastName'].',<br/><b>'.$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'].'</b> has submitted feedback about your institute <b>'.$instAdminData[0]['instituteName'].'</b>, following are the feedback.<br/><table cellspacing="5" cellpadding="5" border="1" style="border:1px solid #ddd;border-collapse:collapse;border-spacing:0;"><thead><tr><th>#</th><th>Question</th><th>Answer</th></tr></thead><tbody><tr><td>1</td><td>Did your class ever cancel due to absence of faculty?</td><td>'.$q1.'</td></tr><tr><td>2</td><td>Were you issued courseware for the module(s) being taught?</td><td>'.$q2.'</td></tr><tr><td>3</td><td>Do theory classes start and end at right time?</td><td>'.$q3.'</td></tr><tr><td>4</td><td>Are the modules taken as per the timetable?</td><td>'.$q4.'</td></tr><tr><td>5</td><td>Does the faculty teach concepts and clear doubts to your satisfaction?</td><td>'.$q5.'</td></tr><tr><td>6</td><td>Does the theory class get conducted OHP or terminal?</td><td>'.$q6.'</td></tr><tr><td>7</td><td>Your understanding of the topics covered?</td><td>'.$q7.'</td></tr><tr><td>8</td><td>Is technical assistance always available in the lab?</td><td>'.$q8.'</td></tr><tr><td>9</td><td>Are you assisted for the lab exercises given in the courseware?</td><td>'.$q9.'</td></tr><tr><td>10</td><td>Were you able to workout lab exercises with facultys help in the lab?</td><td>'.$q10.'</td></tr><tr><td>11</td><td>Do you always get a machine to work during the regular lab hours?</td><td>'.$q11.'</td></tr><tr><td>12</td><td>Have you encountered a problem with respect to the software in the lab?</td><td>'.$q12.'</td></tr><tr><td>13</td><td>Have you encountered a problem with respect to the machine in the lab?</td><td>'.$q13.'</td></tr><tr><td>14</td><td>Does machine problems get sorted within a stipulated time?</td><td>'.$q14.'</td></tr><tr><td>15</td><td>Are the assignments and examinations conducted as per the schedule?</td><td>'.$q15.'</td></tr><tr><td>16</td><td>Are you evaluated after each module (test /assignment/ quiz)?</td><td>'.$q16.'</td></tr><tr><td>17</td><td>Your satisfaction level with respect to faculty guidance on the project.</td><td>'.$q17.'</td></tr><tr><td>18</td><td>Is the feedback taken from you at least once a month?</td><td>'.$q18.'</td></tr><tr><td>19</td><td>Relevance and adequacy of examples used by the faculty while teaching.</td><td>'.$q19.'</td></tr><tr><td>20</td><td>Would you like to tell anyone to join our institute?</td><td>'.$q20.'</td></tr><tr><td>21</td><td>Please use the following space to provide any other feedback about the course/ center etc.</td><td>'.$q21.'</td></tr></tbody></table>';
					$fromName=$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'];
					$sendFeedbackEmail=array('to'=>$instAdminData[0]['email'],'subject'=>'Feedback about institute','template' =>$msg,'fromEmail'=>$frontUserData[0]['email'],'fromName'=>$fromName);
					//$this->model_basic->sendMail($sendFeedbackEmail);
					//$userData = $this->user_model->getUserData($this->session->userdata('front_user_id'));
					if($flag==1){
						$msg='Hello '.$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'].', <br>You have successfully submitted feedback for '.$feedbackInstanceName.'.<br/><br/>Thank You,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$sendFeedbackEmail=array('to'=>$frontUserData[0]['email'],'subject'=>'Feedback about institute','template' =>$msg,'fromEmail'=>$instAdminData[0]['email'],'fromName'=>$instAdminData[0]['instituteName']);
						//$this->model_basic->sendMail($sendFeedbackEmail);
						$this->session->set_flashdata('success','Feedback submitted successfully.');
						redirect('profile/submitFeedback');
					}else{
						$msg='Hello '.$frontUserData[0]['firstName'].' '.$frontUserData[0]['lastName'].', <br>You have successfully update feedback for '.$feedbackInstanceName.'.<br/><br/>Thank You,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$sendFeedbackEmail=array('to'=>$frontUserData[0]['email'],'subject'=>'Feedback about institute','template' =>$msg,'fromEmail'=>$instAdminData[0]['email'],'fromName'=>$instAdminData[0]['instituteName']);
						//$this->model_basic->sendMail($sendFeedbackEmail);
						$this->session->set_flashdata('success','Feedback updated successfully.');
						redirect('profile/submitFeedback');
					}
				}
				else
				{
					$this->session->set_flashdata('error','Fail to submit feedback.');
					redirect('profile/submitFeedback');
				}
			}else{
				$this->session->set_flashdata('error','Fail to submit feedback.Please select valid feedback instance.');
				redirect('profile/submitFeedback');
			}
		}else{
			$data['user_profile']=$this->user_model->getUserProfileData();
			$data['usedDiskSpace']=$this->getDiskSpace();
			$data['allowedDiskSpace']=$this->user_model->getAllowedDiskSpace();
			$data['feedbackInstance']=$this->user_model->getAllFeedbackInstance();
			if(isset($_POST['feedbackInstance']) && $_POST['feedbackInstance'] != '')
			{
				$data['lastFeedback'] = $this->user_model->getLastFeedback($_POST['feedbackInstance']);
			}
			else
			{
				$data['lastFeedback'] = $this->user_model->getLastFeedback();
			}
			//print_r($data);die;
			$this->load->view('feedback_view',$data);
		}
	}
	public function checkFeedbackExist(){
		$instanceId = $_POST['instanceId'];
		if(isset($instanceId)){
			$this->session->set_userdata('instanceId',$instanceId);
			$res = $this->user_model->checkFeedbackExist($instanceId);
			if(!empty($res)){
				echo json_encode($res);die;
			}else{
				echo FALSE;die;
			}
		}
	}
	public function getDiskSpace()
	{
		$size=0;
		$allProject=$this->user_model->getUsersAllProject();
		//print_r($allProject);die;
		if(!empty($allProject))
		{
			foreach($allProject as $project)
			{
				$allImages=$this->user_model->getAllImages($project['id']);
				if(!empty($allImages))
				{
					foreach($allImages as $image)
					{
						if(file_exists(file_upload_s3_path().'project/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']);
						}
					}
				}
			}
		}
		$size = number_format($size / 1048576, 2) . ' MB';
		return $size;
	}
	public function change_admin_project_flag()
	{
		$admin_status_flag = $_POST['admin_status_flag'];
		$res=$this->user_model->change_admin_project_flag($admin_status_flag);
		echo json_encode(array(
		    'valid' => $res,
		));
	}
	public function checkOldPassword()
	{
		$valid = true;
		$id = $this->session->userdata('front_user_id');
		 if(isset($_POST['old_password']) && $_POST['old_password']!='')
		 {
		    $res =  $this->user_model->check_password($id,$_POST['old_password']);
		 }
		 if(!isset($res) || !$res)
		 {
		 	$valid = FALSE;
		 }
		echo json_encode(array(
		    'valid' => $valid,
		));
	}
	public function insertNewPassword()
	{
		$valid = true;
		 $id = $this->session->userdata('front_user_id');
		 if(isset($_POST['re_password']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('password'=>md5($_POST['re_password'])));
		 }
		 if(!isset($res) || !$res)
		 {
		 	$valid = FALSE;
		 }
		echo json_encode(array(
		    'valid' => $valid,
		));
	}
	public function saveFieldValues()
	{
		$valid = true;
	    	$id = $this->session->userdata('front_user_id');
		if(isset($_POST['firstName']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('firstName'=>$_POST['firstName']));
		 }
		elseif(isset($_POST['lastName']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('lastName'=>$_POST['lastName']));
		 }
		 elseif(isset($_POST['profession']))
		 {
		 	if(substr_count($_POST['profession'],',') < 5)
		 	{
		 		$res =  $this->model_basic->_update('users','id',$id,array('profession'=>$_POST['profession']));
		 	}
		 	else
		 	{
		 		$res = 0;
		 	}
		 }
		 elseif(isset($_POST['user_skills']))
		 {
		 	if(substr_count($_POST['user_skills'],',') < 5)
		 	{
		 		$res =  $this->model_basic->_update('users','id',$id,array('skills'=>$_POST['user_skills']));
		 	}
		 	else
		 	{
		 		$res = 0;
		 	}
		 }
		 elseif(isset($_POST['company']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('company'=>$_POST['company']));
		 }
		 elseif(isset($_POST['country']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('country'=>$_POST['country']));
		 }
		 elseif(isset($_POST['city']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('city'=>$_POST['city']));
		 }
		 elseif(isset($_POST['website']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('webSiteURL'=>$_POST['website']));
		 }
		 elseif(isset($_POST['address']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('address'=>$_POST['address']));
		 }
		 elseif(isset($_POST['about_me']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('about_me'=>$_POST['about_me']));
		 }
		 elseif(isset($_POST['contactNo']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('contactNo'=>$_POST['contactNo']));
		 }
		 elseif(isset($_POST['maritalStatus']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('marital_status'=>$_POST['maritalStatus']));
		 }
		 elseif(isset($_POST['experience']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('experience'=>$_POST['experience']));
		 }
		 elseif(isset($_POST['education']))
		 {
		    $res =  $this->model_basic->_update('users','id',$id,array('education'=>$_POST['education']));
		 }
		  elseif(isset($_POST['new_job']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('new_job'=>$_POST['new_job']));
		 }
		 elseif(isset($_POST['weeklyNewsletter']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('weeklyNewsletter'=>$_POST['weeklyNewsletter']));
		 }
		 elseif(isset($_POST['new_competition']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('new_competition'=>$_POST['new_competition']));
		 }
		 elseif(isset($_POST['new_institute']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('new_institute'=>$_POST['new_institute']));
		 }
		 elseif(isset($_POST['follow_unfollow']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('follow_unfollow'=>$_POST['follow_unfollow']));
		 }
		 elseif(isset($_POST['new_project_followed']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('new_project_followed'=>$_POST['new_project_followed']));
		 }
		 elseif(isset($_POST['project_like']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('project_like'=>$_POST['project_like']));
		 }
		 elseif(isset($_POST['project_comment']))
		 {
		    $res =  $this->model_basic->_update('user_email_notification_relation','userId',$id,array('project_comment'=>$_POST['project_comment']));
		 }
		 elseif (isset($_POST['dob'])) {
		 	$from = new DateTime($_POST['dob']);
			$to   = new DateTime('today');
			$age = $from->diff($to)->y;			
			# procedural
			// $age =date_diff(date_create('1970-02-01'), date_create('today'))->y;
		   	$dob=date("Y-m-d",strtotime($_POST['dob']));
		    $res =  $this->model_basic->_update('users','id',$id,array('dob'=>$dob,'age'=>$age));
		}
/*		 elseif(isset($_POST['facebook']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('facebook'=>$_POST['facebook']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'facebook'=>$_POST['facebook']));
			}
		 }
		 elseif(isset($_POST['twitter']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('twitter'=>$_POST['twitter']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'twitter'=>$_POST['twitter']));
			}
		 }
		  elseif(isset($_POST['google']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('google'=>$_POST['google']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'google'=>$_POST['google']));
			}
		 }
		  elseif(isset($_POST['pinterest']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('pinterest'=>$_POST['pinterest']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'pinterest'=>$_POST['pinterest']));
			}
		 }
		  elseif(isset($_POST['instagram']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('instagram'=>$_POST['instagram']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'instagram'=>$_POST['instagram']));
			}
		 }
		  elseif(isset($_POST['linkedin']))
		 {
		 	$result = $this->model_basic->getCount('social_link','user_id',$id);
			if($result)
			{
				$res =  $this->model_basic->_update('social_link','user_id',$id,array('linkedin'=>$_POST['linkedin']));
			}
			else
			{
				$res =  $this->model_basic->_insert('social_link',array('user_id'=>$id,'linkedin'=>$_POST['linkedin']));
			}
		  }*/
		   elseif(isset($_POST['links']))
		  {
		  	$array=$_POST['links'];
  		  	$arrCount=count($array);
  		  	if($arrCount > 1)
  		  	{
  		  		array_shift($array);
  		  	}
		  	if(!empty($array))
		  	{
		  		$i=0;
		  		foreach ($array as $value)
		  		{
	  			 	$result = $this->model_basic->getData('user_web_reference','id',array('user_id'=>$id),array('id'=>'asc'),1,$i);
	  				if(!empty($result))
	  				{
	  					$res =  $this->model_basic->_update('user_web_reference','id',$result['id'],array('link'=>$_POST['links'][$i]));
	  				}
	  				else
	  				{
	  					$res =  $this->model_basic->_insert('user_web_reference',array('user_id'=>$id,'link'=>$_POST['links'][$i]));
	  				}
	  				$i++;
		  		}
		  	}
		  }
		   elseif(isset($_POST['desc']))
		  {
		  	$array=$_POST['desc'];
  		  	$arrCount=count($array);
  		  	if($arrCount > 1)
  		  	{
  		  		array_shift($array);
  		  	}
  		  	if(!empty($array))
  		  	{
  		  		$i=0;
  		  		foreach ($array as $value)
  		  		{
  	  			 	$result = $this->model_basic->getData('user_web_reference','id',array('user_id'=>$id),array('id'=>'asc'),1,$i);
  	  				if(!empty($result))
  	  				{
  	  					$res =  $this->model_basic->_update('user_web_reference','id',$result['id'],array('description'=>$_POST['desc'][$i]));
  	  				}
  	  				else
  	  				{
  	  					$res =  $this->model_basic->_insert('user_web_reference',array('user_id'=>$id,'description'=>$_POST['desc'][$i]));
  	  				}
  	  				$i++;
  		  		}
  		  	}
		  }
		    elseif(isset($_POST['ccNumber']))
		  {
		  	$array=$_POST['ccNumber'];
  		  	$arrCount=count($array);
  		  	if($arrCount > 1)
  		  	{
  		  		array_shift($array);
  		  	}
	    	  	if(!empty($array))
	    	  	{
	    	  		$i=0;
	    	  		foreach ($array as $value)
	    	  		{
	      			 	$result = $this->model_basic->getData('user_card_detail','id',array('user_id'=>$id),array('id'=>'asc'),1,$i);
	      				if(!empty($result))
	      				{
	      					$res =  $this->model_basic->_update('user_card_detail','id',$result['id'],array('card_no'=>$_POST['ccNumber'][$i]));
	      				}
	      				else
	      				{
	      					$res =  $this->model_basic->_insert('user_card_detail',array('user_id'=>$id,'card_no'=>$_POST['ccNumber'][$i]));
	      				}
	      				$i++;
	    	  		}
	    	  	}
		  }
		   elseif(isset($_POST['cvvNumber']))
		  {
		  	$array=$_POST['cvvNumber'];
  		  	$arrCount=count($array);
  		  	if($arrCount > 1)
  		  	{
  		  		array_shift($array);
  		  	}
  		  	if(!empty($array))
  		  	{
  		  		$i=0;
  		  		foreach ($array as $value)
  		  		{
  	  			 	$result = $this->model_basic->getData('user_card_detail','id',array('user_id'=>$id),array('id'=>'asc'),1,$i);
  	  				if(!empty($result))
  	  				{
  	  					$res =  $this->model_basic->_update('user_card_detail','id',$result['id'],array('cvv'=>$value));
  	  				}
  	  				else
  	  				{
  	  					$res =  $this->model_basic->_insert('user_card_detail',array('user_id'=>$id,'cvv'=>$value));
  	  				}
  	  				$i++;
  		  		}
  		  	}
		  }
		  elseif(isset($_POST['expDate']))
		  {
		  	$array=$_POST['expDate'];
  		  	$arrCount=count($array);
  		  	if($arrCount > 1)
  		  	{
  		  		array_shift($array);
  		  	}
  		  	if(!empty($array))
  		  	{
  		  		$i=0;
  		  		foreach ($array as $value)
  		  		{
  	  			 	$result = $this->model_basic->getData('user_card_detail','id',array('user_id'=>$id),array('id'=>'asc'),1,$i);
  	  				if(!empty($result))
  	  				{
  	  					$res =  $this->model_basic->_update('user_card_detail','id',$result['id'],array('exp_date'=>$_POST['expDate'][$i]));
  	  				}
  	  				else
  	  				{
  	  					$res =  $this->model_basic->_insert('user_card_detail',array('user_id'=>$id,'exp_date'=>$_POST['expDate'][$i]));
  	  				}
  	  				$i++;
  		  		}
  		  	}
	  }
		 if(!isset($res) || !$res)
		 {
		 	$valid = FALSE;
		 }
		echo json_encode(array(
		    'valid' => $valid,
		));
	}
	public function saveAwardData()
		{
			//print_r($_POST);die;
			$valid = true;
			$id = $this->session->userdata('front_user_id');
			if(isset($_POST['save_award_details']))
			 {
			 	$award_name 		= $_POST['award_name'];
			 	$award_nomination 	= $_POST['award_nomination'];
			 	$award_date			= $_POST['award_date'];
				$entryDate			= date('Y-m-d H:i:s');
				$result    = array();
				$len       = count($award_name);
				for($i=0;$i<$len;$i++)
				{
					if($award_name[$i]!='')
					{
						$result[$i] = array($id,$award_name[$i],$award_nomination[$i],$award_date[$i]);
					}
				}
	  		  	$arrCount = count($result);
	  		  	if($arrCount > 1)
	  		  	{
	  		  		array_filter($result);
	  		  	}
	 	  		$i=0;
	  		  	if(!empty($result))
	  		  	{
	  		  		foreach ($result as $value)
	  		  		{
	  	  			 	$res =  $this->model_basic->_insert('users_award',array('user_id'=>$id,'award'=>$award_name[$i],'prize'=>$award_nomination[$i],'dateRecieved'=>$award_date[$i],'created'=>$entryDate));
	  	  			 	$i++;
	  		  		}
	  		  	}
	  		  	 if(isset($res) || $res)
				 {
				 	if($i!=0)
					{
						$this->session->set_flashdata('success', 'Award details added successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to save award details.');
					}
				 	redirect(base_url().'profile/edit_profile');
				 }
			}
		}
		public function updateAwardData()
		{
			$id = $this->session->userdata('front_user_id');
			if(isset($_POST['edit_award_details']))
			 {
			 	$award_id		    = $_POST['award_id'];
			 	$award_name 		= $_POST['award_name'];
			 	$award_nomination 	= $_POST['award_nomination'];
			 	$award_date			= $_POST['award_date'];
				$result    = array();
				$len       = count($award_name);
				for($i=0;$i<$len;$i++)
				{
					if($award_name[$i]!='')
					{
						$result[$i] =array($award_id[$i],$award_name[$i],$award_nomination[$i],$award_date[$i]);
					}
				}
	  		  	$arrCount = count($result);
	  		  	if($arrCount > 1)
	  		  	{
	  		  		array_filter($result);
	  		  	}
	  		  	//print_r($result);die;
	  		  	$i=0;
	  		  	if(!empty($result))
	  		  	{
	  		  		foreach ($result as $value)
	  		  		{
	  		  			$res =  $this->model_basic->_update('users_award','id',$value[0],array('award'=>$value[1],'prize'=>$value[2],'dateRecieved'=>$value[3]));
	  	  			 	$i++;
	  		  		}
	  		  	}
	  		  	if(isset($res) || $res)
				{
				 	if($i!=0)
					{
						$this->session->set_flashdata('success', 'Award details update successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to update award details.');
					}
				 	redirect(base_url().'profile/edit_profile');
				}
			}
	}
	public function saveWorkshopData()
	{
		//print_r($_POST);die;
		$valid = true;
		$id = $this->session->userdata('front_user_id');
		if(isset($_POST['save_workshop_details']))
		{
			$workshop_name 		= $_POST['workshop_name'];
			$workshop_by 	    = $_POST['workshop_by'];
			$workshop_date		= $_POST['workshop_date'];
			$entryDate			= date('Y-m-d H:i:s');
			$result    = array();
			$len       = count($workshop_name);
			for($i=0;$i<$len;$i++)
			{
				if($workshop_name[$i]!='')
				{
					$result[$i] = array($id,$workshop_name[$i],$workshop_by[$i],$workshop_date[$i]);
				}
			}
	  		$arrCount = count($result);
	  		if($arrCount > 1)
	  		{
	  		  	array_filter($result);
	  		}
	 	  	$i=0;
	  		if(!empty($result))
	  		{
	  			foreach ($result as $value)
	  		  	{
	  	  			$res =  $this->model_basic->_insert('users_workshop',array('user_id'=>$id,'workshop'=>$workshop_name[$i],'workshop_by'=>$workshop_by[$i],'workshop_date'=>$workshop_date[$i],'created'=>$entryDate));
	  	  			$i++;
	  		  	}
	  		}
	  		if(isset($res) || $res)
			{
				if($i!=0)
				{
					$this->session->set_flashdata('success', 'Workshop details added successfully.');
				}
				else{
					$this->session->set_flashdata('fail', 'Failed to save workshop details.');
				}
				redirect(base_url().'profile/edit_profile');
			}
		}
	}
		public function updateWorkshopData()
		{
			$id = $this->session->userdata('front_user_id');
			if(isset($_POST['edit_workshop_details']))
			 {
			 	$workshop_id		= $_POST['workshop_id'];
			 	$workshop_name 		= $_POST['workshop_name'];
			 	$workshop_by 	    = $_POST['workshop_by'];
			 	$workshop_date		= $_POST['workshop_date'];
				$result             = array();
				$len                = count($workshop_name);
				for($i=0;$i<$len;$i++)
				{
					if($workshop_name[$i]!='')
					{
						$result[$i] =array($workshop_id[$i],$workshop_name[$i],$workshop_by[$i],$workshop_date[$i]);
					}
				}
	  		  	$arrCount = count($result);
	  		  	if($arrCount > 1)
	  		  	{
	  		  		array_filter($result);
	  		  	}
	  		  	//print_r($result);die;
	  		  	$i=0;
	  		  	if(!empty($result))
	  		  	{
	  		  		foreach ($result as $value)
	  		  		{
	  		  			$res =  $this->model_basic->_update('users_workshop','id',$value[0],array('workshop'=>$value[1],'workshop_by'=>$value[2],'workshop_date'=>$value[3]));
	  	  			 	$i++;
	  		  		}
	  		  	}
	  		  	if(isset($res) || $res)
				{
				 	if($i!=0)
					{
						$this->session->set_flashdata('success', 'Workshop details update successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to update workshop details.');
					}
				 	redirect(base_url().'profile/edit_profile');
				}
			}
		}
		public function saveLanguageData()
		{
			//print_r($_POST);die;
			$valid = true;
			$id = $this->session->userdata('front_user_id');
			if(isset($_POST['save_language_details']))
			{
				$language_name 		  = $_POST['language_name'];
				$language_proficiency = $_POST['language_proficiency'];
				
				if($_POST['language_read'] == 1)
				{
					$language_read = 1;
				}else{
					$language_read = 0;
				}

				if($_POST['language_write'] == 1)
				{
					$language_write = 1;
				}else{
					$language_write = 0;
				}

				if($_POST['language_speak'] == 1)
				{
					$language_speak = 1;
				}else{
					$language_speak = 0;
				}
				
				$entryDate = date('Y-m-d H:i:s');
				
		  	  	$res =  $this->model_basic->_insert('users_language',array('user_id'=>$id,'language_name'=>$language_name,'language_proficiency'=>$language_proficiency,'read'=>$language_read,'write'=>$language_write,'speak'=>$language_speak,'created'=>$entryDate));
		  	  	
		  		if(isset($res) || $res)
				{
					if($res!=0)
					{
						$this->session->set_flashdata('success', 'Language details added successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to save language details.');
					}
					redirect(base_url().'profile/edit_profile');
				}
			}
		}
			public function saveLocationData()
			{

				$id = $this->session->userdata('front_user_id');
				if(isset($_POST['save_location_details']))
				{
					$city      = $_POST['location_city'];
				 	$entryDate = date('Y-m-d H:i:s');
					
		  	  		$res =  $this->model_basic->_insert('users_location',array('user_id'=>$id,'city_id'=>$city,'created'=>$entryDate));
		  	  			  		  		
		  		  	if(isset($res) || $res)
					{
						if($res!=0)
						{
							$this->session->set_flashdata('success', 'Location details added successfully.');
						}
						else{
							$this->session->set_flashdata('fail', 'Failed to save location details.');
						}
					 	redirect(base_url().'profile/edit_profile');
					}
				}
			}
	public function saveSkillsData()
	{
		$valid = true;
		$id = $this->session->userdata('front_user_id');
		if(isset($_POST['save_skills']))
		 {
		 	$skillName		= $_POST['skillName'];
		 	$skillLevel 	= $_POST['skillLevel'];
			$entryDate		= date('Y-m-d H:i:s');
			$result    = array();
			$len       = count($skillName);
			for($i=0;$i<$len;$i++)
			{
				if($skillName[$i]!='')
				{
					$result[$i] = array($id,$skillName[$i],$skillLevel[$i],$entryDate);
				}
			}
  		  	$arrCount = count($result);
  		  	if($arrCount > 1)
  		  	{
  		  		array_filter($result);
  		  	}
 			$i=0;
  		  	if(!empty($result))
  		  	{
  		  		foreach ($result as $value)
  		  		{
  	  			 	$res =  $this->model_basic->_insert('users_skills',array('user_id'=>$id,'skillName'=>$skillName[$i],'skillLevel'=>$skillLevel[$i],'created'=>$entryDate));
  	  			 	$i++;
  		  		}
  		  	}
  		  	if(isset($res) || $res)
			{
				if($i!=0)
				{
					$this->session->set_flashdata('success', 'Skills added successfully.');
				}
				else{
					$this->session->set_flashdata('fail', 'Failed to save skills.');
				}
			 	redirect(base_url().'profile/edit_profile');
			}
		}
	}
	public function updateSkillsData()
	{
		$id = $this->session->userdata('front_user_id');
		if(isset($_POST['update_skills']))
		 {
		 	$skills_id		= $_POST['skills_id'];
		 	$skillName		= $_POST['skillName'];
		 	$skillLevel 	= $_POST['skillLevel'];
			$result    = array();
			$len       = count($skillName);
			for($i=0;$i<$len;$i++)
			{
				if($skillName[$i]!='')
				{
					$result[$i] =array($skills_id[$i],$skillName[$i],$skillLevel[$i]);
				}
			}
  		  	$arrCount = count($result);
  		  	if($arrCount > 1)
  		  	{
  		  		array_filter($result);
  		  	}
  		  	//print_r($result);die;
  		  	$i=0;
  		  	if(!empty($result))
  		  	{
  		  		foreach ($result as $value)
  		  		{
  		  			$res = $this->model_basic->_update('users_skills','id',$value[0],array('skillName'=>$value[1],'skillLevel'=>$value[2]));
  	  			 	$i++;
  		  		}
  		  	}
  		  	if(isset($res) || $res)
			{
			 	if($i!=0)
				{
					$this->session->set_flashdata('success', 'Skills details updated successfully.');
				}
				else{
					$this->session->set_flashdata('fail', 'Failed to update skills.');
				}
			 	redirect(base_url().'profile/edit_profile');
			}
		}
	}
	public function saveExperienceData()
	{
		//print_r($_POST);die;
		$valid = true;
		$id = $this->session->userdata('front_user_id');
		if(isset($_POST['save_exp_details']))
		 {
		 	$company_name 		= $_POST['company_name'];
		 	$position 			= $_POST['position'];
		 	$from_date 			= $_POST['from_date'];
		 	$to_date 			= $_POST['to_date'];
		 	$address 			= $_POST['address'];
		 	$workDetails		= $_POST['work_description'];
		 	$current_employer 	= $_POST['current_emp_arr'];
			$entryDate			= date('Y-m-d H:i:s');
			$result    = array();
			$len       = count($company_name);
			for($i=0;$i<$len;$i++)
			{
				if($company_name[$i]!='')
				{
					$result[$i] = array($id,$company_name[$i],$position[$i],$from_date[$i],$to_date[$i],$address[$i],$workDetails[$i],$current_employer[$i],$entryDate);
				}
			}
  		  	$arrCount = count($result);
  		  	if($arrCount > 1)
  		  	{
  		  		array_filter($result);
  		  	}
 //print_r($result);die;
 			$i=0;
  		  	if(!empty($result))
  		  	{
  		  		foreach ($result as $value)
  		  		{
  	  			 	$res =  $this->model_basic->_insert('users_work',array('user_id'=>$id,'organisation'=>$company_name[$i],'w_address'=>$address[$i],'workDetails'=>$workDetails[$i],'position'=>$position[$i],'startingDate'=>$from_date[$i],'endingDate'=>$to_date[$i],'status'=>$current_employer[$i],'created'=>$entryDate));
  	  			 	$i++;
  		  		}
  		  	}
  		  	if(isset($res) || $res)
			{
				if($i!=0)
				{
					$this->session->set_flashdata('success', 'Experience details added successfully.');
				}
				else{
					$this->session->set_flashdata('fail', 'Failed to save experience details.');
				}
			 	redirect(base_url().'profile/edit_profile');
			}
/*			echo json_encode(array(
			    'valid' => $valid,
			));*/
		}
	}
	public function updateExperienceData()
	{
		$id = $this->session->userdata('front_user_id');
		if(isset($_POST['edit_exp_details']))
		 {
		 	$exp_id				= $_POST['exp_id'];
		 	$company_name 		= $_POST['company_name'];
		 	$position 			= $_POST['position'];
		 	$from_date 			= $_POST['from_date'];
		 	$to_date 			= $_POST['to_date'];
		 	$address 			= $_POST['address'];
		 	$workDetails		= $_POST['work_description'];
		 	$current_employer 	= $_POST['current_emp_arr'];
			$entryDate			= date('Y-m-d H:i:s');
			$result    = array();
			$len       = count($company_name);
			for($i=0;$i<$len;$i++)
			{
				if($company_name[$i]!='')
				{
					$result[$i] =array($exp_id[$i],$company_name[$i],$position[$i],$from_date[$i],$to_date[$i],$address[$i],$workDetails[$i],$current_employer[$i],$entryDate);
				}
			}
  		  	$arrCount = count($result);
  		  	if($arrCount > 1)
  		  	{
  		  		array_filter($result);
  		  	}
  		  	//print_r($result);die;
  		  	$i=0;
  		  	if(!empty($result))
  		  	{
  		  		foreach ($result as $value)
  		  		{
  		  			//echo $value[0].'<br/>';
  	  			 	$res =  $this->model_basic->_update('users_work','id',$value[0],array('organisation'=>$value[1],'position'=>$value[2],'startingDate'=>$value[3],'endingDate'=>$value[4],'w_address'=>$value[5],'workDetails'=>$value[6],'status'=>$value[7]));
  	  			 	$i++;
  		  		}
  		  	}
  		  	if(isset($res) || $res)
			{
			 	if($i!=0)
				{
					$this->session->set_flashdata('success', 'Experience details update successfully.');
				}
				else{
					$this->session->set_flashdata('fail', 'Failed to update experience details.');
				}
			 	redirect(base_url().'profile/edit_profile');
			}
		}
	}
	public function saveEducationalData()
		{
			$id = $this->session->userdata('front_user_id');
			$jobsId=$_POST['jobsId'];
			if(isset($jobsId) && !empty($jobsId))
			{
			   	$dob=date("Y-m-d",strtotime($_POST['dob']));
			 	$age = $_POST['age'];
			 	$contactNo = $_POST['contactNo'];
			 	$res =  $this->model_basic->_update('users','id',$id,array('dob'=>$dob,'age'=>$age,'contactNo'=>$contactNo));
			}
			if(isset($_POST['save_edu_details']))
			{
				$educationType      = $_POST['education_type'];
			 	$qualification 		= $_POST['qualification'];
			 	$stream 			= $_POST['stream'];
			 	$pass_yr 			= $_POST['pass_yr'];
			 	$university			= $_POST['university'];
			 	$school             = $_POST['school'];
				$entryDate			= date('Y-m-d H:i:s');
				$result    = array();
				$len       = count($qualification);
	 			
				for($i=0;$i<$len;$i++)
				{
					if($educationType[$i]!='')
					{
						$result[$i] = array($id,$educationType[$i],$qualification[$i],$stream[$i],$pass_yr[$i],$university[$i],$school[$i],$entryDate);
					}
				}
				//print_r($result);
	  		  	$arrCount = count($result);
	  		  	if($arrCount > 1)
	  		  	{
	  		  		array_filter($result);
	  		  	}
	 			$i=0;
	  		  	if(!empty($result))
	  		  	{
	  		  		foreach ($result as $value)
	  		  		{
	  	  			 	$res =  $this->model_basic->_insert('users_education',array('user_id'=>$id,'university'=>$university[$i],'education_type'=>$educationType[$i],'qualification'=>$qualification[$i],'stream'=>$stream[$i],'school'=>$school[$i],'passoutyear'=>$pass_yr[$i],'created'=>$entryDate));
	  	  			 	$i++;
	  	  			 }
	  		  	}
	  		  	if(isset($res) || $res)
				{
					if($i!=0)
					{
						$this->session->set_flashdata('success', 'Educational details added successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to save educational details.');
					}
				 	if(isset($jobsId) && !empty($jobsId))
					{
						redirect(base_url().'job/jobDetail/'.$jobsId);
					}
					else
					{
				 		redirect(base_url().'profile/edit_profile');
					}
				}
			}
		}
		public function updateEducationalData()
		{
			$id = $this->session->userdata('front_user_id');
			if(isset($_POST['edit_edu_details']))
			{
			 	$edu_id				= $_POST['edu_id'];
			 	$educationType 		= $_POST['education_type'];
			 	$qualification 		= $_POST['qualification'];
			 	$stream 			= $_POST['stream'];
			 	//$from_date 			= $_POST['from_yr'];
			 	$pass_yr 			= $_POST['pass_yr'];
			 	$university			= $_POST['university'];
			 	$school             = $_POST['school'];
				$entryDate			= date('Y-m-d H:i:s');
				$result    = array();
				$len       = count($edu_id);
				for($i=0;$i<$len;$i++)
				{
					if($edu_id[$i]!='')
					{
						$result[$i] = array($edu_id[$i],$educationType[$i],$qualification[$i],$stream[$i],$pass_yr[$i],$university[$i],$school[$i],$entryDate);
					}
				}
	  		  	$arrCount = count($result);
	  		  	if($arrCount > 1)
	  		  	{
	  		  		array_filter($result);
	  		  	}
	  		  	//print_r($result);die;
	  		  	$i=0;
	  		  	if(!empty($result))
	  		  	{
	  		  		foreach ($result as $value)
	  		  		{
	  		  			//echo $value[0].'<br/>';
	  	  			 	$res =  $this->model_basic->_update('users_education','id',$value[0],array('education_type'=>$educationType[$i],'university'=>$university[$i],'school'=>$school[$i],'qualification'=>$qualification[$i],'stream'=>$stream[$i],'passoutyear'=>$pass_yr[$i]));
	  	  			 	$i++;
	  		  		}
	  		  	}
	  		  	if(isset($res) || $res)
				 {
				 	if($i!=0)
					{
						$this->session->set_flashdata('success', 'Educational details update successfully.');
					}
					else{
						$this->session->set_flashdata('fail', 'Failed to update educational details.');
					}
				 	redirect(base_url().'profile/edit_profile');
				 }
			}
		}

	public function saveImage()
	{
		$this->session->set_userdata('profileImage',' ');
		$id = $this->session->userdata('front_user_id');
		if (isset($_FILES) && !empty($_FILES))
		{
			if(isset($_FILES[0]['name']) && $_FILES[0]['name'] <> "")
			{
				$files=$_FILES[0];
				$_FILES=array();
				$_FILES['image']=$files;
				$field ='image';
				$uploadFileData = array();
				$isUploaded = array();
				$image_error = array();
				$isUploaded = $this->model_basic->fileUpload($uploadFileData,$field,time(),file_upload_s3_path()."users/");
				if(!$isUploaded || $uploadFileData[$field.'_err'] <> "")
				{
					$this->session->set_userdata('profileImage',' ');
				}
				else
				{
					$file_name = $uploadFileData[$field];
					$this->session->set_userdata('profileImage',$file_name);
					$this->model_basic->ImageCropMaster('200', '200', file_upload_s3_path().'users/'.$file_name, file_upload_s3_path().'users/thumbs/'.$file_name, $quality = 80);
					$previousImage = $this->model_basic->getValue('users',"profileImage","id=".$id);
					@unlink(file_upload_s3_path().'users/'.$previousImage);
					@unlink(file_upload_s3_path().'users/thumbs/'.$previousImage);
					$res =  $this->model_basic->_update('users','id',$id,array('profileImage'=>$file_name));
				}
			}
		}
		echo $this->session->userdata('profileImage');
	}
	public function deleteData($fieldName,$table)
	{
		$data=$_POST;
		if(!empty($data))
		{
			foreach ($data as $key => $value)
			{
				$uid=$this->session->userdata('front_user_id');
				$this->model_basic->_deleteWhere($table,array('user_id' =>$uid,$fieldName=>$value));
			}
		}
		echo 1;
	}
	public function shareUserProfile()
	{
		if(isset($_POST['sendEmail']))
		{
			$emailFrom = $this->model_basic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
			$email = $_POST['userEmail'];
			$sharedUserId = $_POST['sharedUserId'];
			$sharedUserProfile     = $this->model_basic->loggedInUserInfoById($sharedUserId);
			$sharerUserProfile     = $this->model_basic->loggedInUserInfo();
			$from                  = $emailFrom;
			$nameBy                = ucwords($sharerUserProfile['firstName'].' '.$sharerUserProfile['lastName']);
			$nameTo                = ucwords($sharedUserProfile['firstName'].' '.$sharedUserProfile['lastName']);
			if($this->session->userdata('front_user_id')!=$sharedUserProfile['id'])
			{
				$templateLikeTo        = 'Hello,<br />Greetings from creosouls!<br /><b> '.$nameBy.'</b> shared a portfolio of '.$nameTo.' with you.<br /><a href="'.base_url().'user/userDetail/'.$sharedUserProfile['id'].'"><b>Click here</b></a>  to access the portfolio.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			}
			else{
				$templateLikeTo        = 'Hello,<br />Greetings from creosouls!<br /><b> '.$nameBy.'</b> shared a portfolio of with you.<br /><a href="'.base_url().'user/userDetail/'.$sharedUserProfile['id'].'"><b>Click here</b></a>  to access the portfolio.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
			}
			$emailDetailUnFollowTo = array(
							'to'		=>$email,
							'subject'  	=>'Someone has shared a profile',
							'template' 	=>$templateLikeTo,
							'fromEmail'	=>$from
							);
			//print_r($_POST);print_r($sharedUserProfile);print_r($emailDetailUnFollowTo); print_r($sharerUserProfile);die;
			if($this->model_basic->sendMail($emailDetailUnFollowTo))
			{
				$this->session->set_flashdata('success', 'Profile shared successfully.');
				redirect(base_url().'user/userDetail/'.$sharedUserProfile['id']);
			}
			else{
				$this->session->set_flashdata('fail', 'Sending failed.Please try again.');
				redirect(base_url().'user/userDetail/'.$sharedUserProfile['id']);
			}
		}
	}
	public function ajax()
	{
		echo '<div class="custom-column-5">
		<div class="be-post">
			<a href="blog-detail-2.html" class="be-img-block">
			<img src="img/p1.jpg" alt="omg">
			</a>
			<a href="blog-detail-2.html" class="be-post-title">The kitsch destruction of our world</a>
			<span>
				<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
				<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
				<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
			</span>
			<div class="author-post">
				<img src="img/a1.png" alt="" class="ava-author">
				<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
			</div>
			<div class="info-block">
				<span><i class="fa fa-thumbs-o-up"></i> 360</span>
				<span><i class="fa fa-eye"></i> 789</span>
				<span><i class="fa fa-comment-o"></i> 20</span>
			</div>
		</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p4.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">Leaving Home - LOfficiel Ukraine</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a3.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p5.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">Drive Your World</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a4.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p6.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">Fran Ewald for The Diaries Project</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a5.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p10.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">tomorrow</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a8.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p11.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">Tropicalia</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a5.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>
		<div class="custom-column-5">
			<div class="be-post">
				<a href="blog-detail-2.html" class="be-img-block">
				<img src="img/p12.jpg" alt="omg">
				</a>
				<a href="blog-detail-2.html" class="be-post-title">Face</a>
				<span>
					<a href="blog-detail-2.html" class="be-post-tag">Interaction Design</a>,
					<a href="blog-detail-2.html" class="be-post-tag">UI/UX</a>,
					<a href="blog-detail-2.html" class="be-post-tag">Web Design</a>
				</span>
				<div class="author-post">
					<img src="img/a6.png" alt="" class="ava-author">
					<span>by <a href="blog-detail-2.html">Hoang Nguyen</a></span>
				</div>
				<div class="info-block">
					<span><i class="fa fa-thumbs-o-up"></i> 360</span>
					<span><i class="fa fa-eye"></i> 789</span>
					<span><i class="fa fa-comment-o"></i> 20</span>
				</div>
			</div>
		</div>';
	}
	public function updateGoogleDriveSetting(){
		if(isset($_POST['driveSetting'])){
			$googleDriveSetting = $_POST['driveSetting'];
			echo $this->user_model->updateGoogleDriveSetting($googleDriveSetting);
		}else{
			echo FALSE;
		}
	}

	public function usre_profile_detail($uid)
	{
		$data['user_profile']=$this->user_model->getUserProfileData($uid);
		$data['notification']=$this->user_model->getUserNotificationData($uid);
		$data['workData']=$this->user_model->getUserWorkData($uid);
		$data['skillsData']=$this->user_model->getUserSkillData($uid);
		$data['educationData']=$this->user_model->getUserEducationData($uid);
		$data['educationProfData']=$this->user_model->getUserProfessionalEducationData();
		$data['websiteData']=$this->user_model->getUserWebsiteData($uid);
		$data['cardData']=$this->user_model->getUserCardData($uid);
		$data['socialData']=$this->user_model->getUserSocialData($uid);
		$data['awardData']=$this->user_model->getAwardData($uid);
		$data['workshopData']=$this->user_model->getWorkshopData($uid);
		$data['locationData']=$this->user_model->getLocationData();
		$data['languageData']=$this->user_model->getLanguageData();
		$data['user_ID'] = $uid;	
		$this->load->view('usre_profile_detail',$data);
	}

	public function preview_resume()
	{
		$data['user_profile']=$this->user_model->getUserProfileData();
		$data['workData']=$this->user_model->getUserWorkData();
		$data['skillsData']=$this->user_model->getUserSkillData();
		$data['educationData']=$this->user_model->getUserEducationData();
		$data['websiteData']=$this->user_model->getUserWebsiteData();
		$data['socialData']=$this->user_model->getUserSocialData();
		$data['awardData']=$this->user_model->getAwardData();
		$data['workshopData']=$this->user_model->getWorkshopData();
		$data['languageData']=$this->user_model->getLanguageData();
		$data['locationData']=$this->user_model->getLocationData();
		$this->load->view('preview_resume',$data);
	}
	public function donwload_resume()
	{
		$data['user_profile']=$this->user_model->getUserProfileData();
		$data['workData']=$this->user_model->getUserWorkData();
		$data['skillsData']=$this->user_model->getUserSkillData();
		$data['educationData']=$this->user_model->getUserEducationData();
		$data['websiteData']=$this->user_model->getUserWebsiteData();
		$data['socialData']=$this->user_model->getUserSocialData();
		$data['awardData']=$this->user_model->getAwardData();
		$data['workshopData']=$this->user_model->getWorkshopData();
		$data['languageData']=$this->user_model->getLanguageData();
		$data['locationData']=$this->user_model->getLocationData();
		$pdfname =$data['user_profile']->firstName.' '.$data['user_profile']->lastName.'_Resume';
		$this->load->library("Report_creation");
		//$pdfname = $data['user_profile']'Invoice Pdf';			
		//$this->load->view('srt-resume2');  
		$html = $this->load->view('srt-resume2',$data,TRUE);  
		$this->report_creation->create_pdf($html,$pdfname);
	}
	function getCityList()
	{		
		if(!empty($_POST['stateId']))
		{
			?>
			<option value="" >Select City</option>
			<?php
				$data = $this->model_basic->getAllData('cities','id,city',array('state_id'=>$_POST['stateId']));
			
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['city'];?> </option>
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

