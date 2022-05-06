<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creative_mind_competitions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_basic');
		$this->load->model('creative_mind_competition_model');
		$this->load->library('image_lib');
	}

    public function competition_list()
	{
		$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		$ho_status = $this->model_basic->getValue($this->db->dbprefix('users'),"admin_level"," `id` = '".$FRONT_USER_SESSION_ID."'");
		$jury_status = $this->model_basic->getValue($this->db->dbprefix('creative_competition_jury_relation'),"userId"," `userId` = '".$FRONT_USER_SESSION_ID."'");
		if(isset($ho_status) && !empty($ho_status) && $ho_status=='4' || $ho_status=='2' || $ho_status=='1') 
		{ 
			$flag=1;
		} 
		if(isset($jury_status) && !empty($jury_status) && $jury_status==$FRONT_USER_SESSION_ID)
		{
			$flag=1;
		} 
		if($ho_status=='0' && ($this->session->userdata('user_institute_id')==0))
		{
			$flag=1;
		}
		if($this->session->userdata('user_institute_id')!=0)
		{
			$flag=1;
		}
		if(isset($flag) && !empty($flag) && $flag=='1') 
		{
			$data['competition']=$this->creative_mind_competition_model->getAllCompetionData();
			$this->load->view('creative_competition_list_view',$data);
		}
		else
		{
			redirect(base_url());			
		}
	}

	public function get_competition($competitionId='',$juryId='')
	{
		/*$this->session->set_userdata('breadCrumb','');
		$this->session->set_userdata('breadCrumbLink','');*/
		$FRONT_USER_SESSION_ID = intval($this->session->userdata('front_user_id'));
		$ho_status = $this->model_basic->getValue($this->db->dbprefix('users'),"admin_level"," `id` = '".$FRONT_USER_SESSION_ID."'");
		$jury_status = $this->model_basic->getValue($this->db->dbprefix('creative_competition_jury_relation'),"userId"," `userId` = '".$FRONT_USER_SESSION_ID."'");
		if(isset($ho_status) && !empty($ho_status) && $ho_status=='4' || $ho_status=='2' || $ho_status=='1') 
		{ 
			$flag=1;
		}
		if($ho_status=='0' && ($this->session->userdata('user_institute_id')==0))
		{
			$flag=1;
		}
		if($this->session->userdata('user_institute_id')!=0)
		{
			$flag=1;
		}
		if(isset($jury_status) && !empty($jury_status) && $jury_status==$FRONT_USER_SESSION_ID)
		{
			$flag=1;
		} 

		if(isset($flag) && !empty($flag) && $flag=='1') 
		{
			if(isset($_POST['query']) && $_POST['query']!='')
			{
				$this->session->set_userdata('query',$_POST['query']);
			}
			else
			{
				$this->session->unset_userdata('query');
			}
			if($this->input->post('filter_projet',true)){
				
			    $cmcatid = $this->input->post('competition_category',true);
			    if($cmcatid != 0){
			    	$this->session->set_userdata('cmcatid',$cmcatid);
			    }else{
			    	$this->session->set_userdata('cmcatid',"");
			    }
			    
			    		    
			}
			if($this->input->post('clear_projet',true)){
				
			    $this->session->unset_userdata('cmcatid');
			    	    
			}
			$cmcatid = $this->session->userdata('cmcatid');
			$competition=array();
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($competitionId);		
			if(isset($data['competition']) && empty($data['competition']))
			{
				$this->session->set_flashdata('error', 'Sorry, Invalid URL.');
				redirect(base_url());
			}		
			
			//$data['project']=$this->creative_mind_competition_model->getAllProjectData($competitionId);
			$totalProject = $this->creative_mind_competition_model->getAllProjectData($competitionId,$cmcatid);
			$ratedProject = $this->creative_mind_competition_model->getAllRatedProjectData($competitionId,$juryId,$cmcatid);
			$nonRatedProject = array();
			$newRatedProject = array();
			foreach($totalProject as $val)
			{
				
				
				
				$projectid = $val['id'];
				if (in_array($val, $ratedProject))
				  {

				  	array_push($nonRatedProject,$val);
					
				  }
				else
				  {
				  	array_push($newRatedProject,$val);
				  	
				  }
				  //print_r($nonRatedProject);
				  
			}
			$totalProjects = array_merge($newRatedProject,$nonRatedProject);
			
			$data['project'] = $totalProjects;
			$data['winningProjects']=$this->creative_mind_competition_model->getAllWinningProjects($competitionId);
			$data['category']=$this->creative_mind_competition_model->getAllCategory();
			$data['exstingProject']=$this->creative_mind_competition_model->getAllExstingUserProject($competitionId);
			//print_r($data['winningProjects']);die;
			$data['juries']=$this->creative_mind_competition_model->getAllJuries($competitionId);
			$userId=$this->model_basic->getValue('creative_competition_jury_relation','userId'," `competitionId` = '".$competitionId."' AND  `juryId` = '".$juryId."'");
			if($juryId <> '' && $userId == $this->session->userdata('front_user_id'))
			{
				$isJury=$this->model_basic->getValue('creative_competition_jury_relation','competitionId'," `competitionId` = '".$competitionId."' AND  `juryId` = '".$juryId."'");
			}
			else
			{
				$isJury=0;
			}
			if($isJury > 0)
			{
				$evaluationStartDate=$data['competition'][0]['evaluation_start_date'];
				$evaluationEndDate=$data['competition'][0]['evaluation_end_date'];
				$todayDate=date('Y-m-d');
				if($todayDate >= $evaluationStartDate && $todayDate <= $evaluationEndDate)
				{
					$data['isJury']=true;
				}
				else
				{
					$data['isJury']=false;
				}
			}
			else
			{
				$data['isJury']=false;
			}			
			$this->load->view('creative_competition_view',$data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function submitExstingUserProject()
	{
		$exstingProjectId=$_POST['exstingProjectId'];
		$competitionId=$_POST['competitionId'];
		$res=$this->creative_mind_competition_model->submitExstingUserProject($exstingProjectId,$competitionId);
		if($res > 0)
		{
			$this->session->set_flashdata('success', 'Project added successfully for competition.');
			redirect('creative_mind_competitions/get_competition/'.$competitionId);
		}
		else
		{
			$this->session->set_flashdata('fail', 'Project submission failed.');
			redirect('creative_mind_competitions/get_competition/'.$competitionId);
		}
	}

	public function rateProject($competitionId='',$projectId="")
	{
		if(isset($projectId) && $projectId > 0)
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('rating', 'Rating', 'trim|required|is_natural');
			if($this->form_validation->run())
			{
				$juryId=$this->model_basic->getValue('creative_competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");
				$competitionData=$this->db->select('competitionId,categoryId')->from('project_master')->where('id',$projectId)->get()->row_array();
				//$competitionId = $competitionData['competitionId'];
				$data=array('projectId'=>$projectId,'creative_competition_id'=>$competitionId,'juryId'=>$juryId,'rating'=>$this->input->post('rating',true));
				$isRatingExists=$this->model_basic->getValue('creative_competition_project_jury_rating','id'," `creative_competition_id` = '".$competitionId."' AND  `juryId` = '".$juryId."' AND  `projectId` = '".$projectId."'");
				if($isRatingExists > 0)
				{
					$this->model_basic->_updateWhere('creative_competition_project_jury_rating',array('creative_competition_id'=>$competitionId,'projectId'=>$projectId,'juryId'=>$juryId),$data);
					$this->session->set_flashdata('success','Your rating updated successfully.');
				}
				else
				{
					$this->model_basic->_insert('creative_competition_project_jury_rating',$data);
					$this->session->set_flashdata('success','Your rating submitted successfully.');
				}
				$allJuryRating=$this->creative_mind_competition_model->getAllJuryRating($competitionId,$projectId);
				//print_r($allJuryRating);die;
				$avg=0;
				if(!empty($allJuryRating))
				{
					foreach ($allJuryRating as $key)
					{
						$avg+=$key['rating'];
					}
					$avg=$avg/count($allJuryRating);
					$updateData=array('avgRating'=>$avg);
					$insertData=array('avgRating'=>$avg,'creative_competition_id'=>$competitionId,'projectId'=>$projectId,'project_category'=>$competitionData['categoryId']);

					$isRatingAvgExists=$this->model_basic->getValue('creative_competition_project_avg_rating','avgRating'," `creative_competition_id` = '".$competitionId."' AND  `projectId` = '".$projectId."'");
					if($isRatingAvgExists > 0)
					{
						$this->model_basic->_updateWhere('creative_competition_project_avg_rating',array('creative_competition_id'=>$competitionId,'projectId'=>$projectId),$updateData);
					}
					else
					{
						$this->model_basic->_insert('creative_competition_project_avg_rating',$insertData);
					}
				}
			}
			else
			{
				$this->session->set_flashdata('error', form_error('rating'));
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid Url please try again.');
		}
		// echo 'creative_mind_competitions/get_competition/'.$competitionId.'/'.$juryId;die;
		redirect('creative_mind_competitions/get_competition/'.$competitionId.'/'.$juryId);
	}
   
	public function competition_more_data()
	{
    		$per_call_deal = 12;
		$call_count = $_POST['call_count'];
		$this->creative_mind_competition_model->competition_more_data($per_call_deal,$call_count);
	}
	public function join_competition()
	{
		if(isset($_POST['competition_id']) && $_POST['competition_id']!='')
		{
			$this->session->set_userdata('clicked_competition_id',$_POST['competition_id']);
			echo 'done';
		}
	}
	/*public function submit_competition_project()
	{
		if(isset($_POST['competition_id']) && $_POST['competition_id']!='')
		{
			$this->session->set_userdata('competition_id',$_POST['competition_id']);
			echo 'done';
		}
	}*/
	public function more_data()
	{
		//print_r($_POST);die;
		$category_id = $_POST['competition_category'];
		$institute_id = $_POST['competition_institute'];
		$region_id = $_POST['competition_region'];
		$zone_id=$_POST['competition_zone'];

		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
	    		$per_call_deal =12;
			$call_count = $_POST['call_count'];
			//$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition,$category_id,$institute_id,$region_id,$zone_id);
		}
	}
    public function clear_sort()
	{
    	if(isset($_POST['name1']) && $_POST['name1']!='' && isset($_POST['name2']) && $_POST['name2']!='' && isset($_POST['name3']) && $_POST['name3']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
			$this->session->unset_userdata('hsort_by');
		    $this->session->unset_userdata('category_sort');
		    $this->session->unset_userdata('query');
			$this->session->set_userdata('user_activity_sort','Featured');
			$this->session->unset_userdata('adv_search_for');
			$this->session->unset_userdata('adv_attribute');
			$this->session->unset_userdata('adv_attri_value');
			$this->session->unset_userdata('adv_rating');
			$this->session->unset_userdata('adv_attribute_id');
			$this->session->unset_userdata('adv_attri_value_id');
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
	public function clear_query()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
		    $this->session->unset_userdata('query');
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
	public function sort_by()
	{
    	if(isset($_POST['name']) && $_POST['name']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
			if($_POST['name']=='completed')
			{
				$this->session->set_userdata('hsort_by','completed');
			}
			if($_POST['name']=='in_progress')
			{
				$this->session->set_userdata('hsort_by','in_progress');
			}
			if($_POST['name']=='all_project')
			{
				$this->session->unset_userdata('hsort_by');
			}
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
	public function cat_sort()
	{
    	if(isset($_POST['name']) && $_POST['name']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
			 $category = $this->creative_mind_competition_model->getAllCategory();
			 if($_POST['name']=='all_category')
			 {
				$this->session->unset_userdata('category_sort');
			 }
			 else
			 {
			 	 if(!empty($category))
				 {
				 	 foreach($category as $cat)
					 {
					 	if($cat['categoryName']==$_POST['name'])
						{
						   $this->session->set_userdata('category_sort',$cat['categoryName']);
						}
					 }
				 }
			 }
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
	 }
	public function leftside_cat_sort()
	{
    	if(isset($_POST['name']) && $_POST['name']!='')
		{
			 $category = $this->creative_mind_competition_model->getAllCategory();
			 	 if(!empty($category))
				 {
				 	 foreach($category as $cat)
					 {
					 	if($cat['categoryName']==$_POST['name'])
						{
						   $this->session->set_userdata('category_sort',$cat['categoryName']);
						   echo 'done';
						}
					 }
				 }
      	}
	 }
	public function user_activity_sort()
	{
    	if(isset($_POST['name']) && $_POST['name']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
			if($_POST['name']=='Featured')
			{
				$this->session->set_userdata('user_activity_sort','Featured');
			}
			if($_POST['name']=='Most Appreciated')
			{
				$this->session->set_userdata('user_activity_sort','Most Appreciated');
			}
			if($_POST['name']=='Most Viewed')
			{
				$this->session->set_userdata('user_activity_sort','Most Viewed');
			}
			if($_POST['name']=='Most Discussed')
			{
				$this->session->set_userdata('user_activity_sort','Most Discussed');
			}
			if($_POST['name']=='Most Recent')
			{
				$this->session->set_userdata('user_activity_sort','Most Recent');
			}
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
	public function get_attribute_value()
	{
		if(isset($_POST['id']) && $_POST['id']!='')
		{
			$data = $this->creative_mind_competition_model->get_attribute_value($_POST['id']);
			echo json_encode($data);
		}
	}
	public function getRating()
	{
	    	if(isset($_POST['projectId']) && $_POST['projectId'] > 0 && isset($_POST['competitionId']) && $_POST['competitionId'])
		{
			$data = $this->creative_mind_competition_model->get_project_jury_ratings($_POST['projectId'],$_POST['competitionId']);
			$totalRating=0;
			$newArray=array();
			$juryId=$this->model_basic->getValue('creative_competition_jury_relation','juryId'," `userId` = '".$this->session->userdata('front_user_id')."'");
			if(!empty($data))
			{
				$i=0;
				foreach ($data as $value)
				{
					$totalRating+=$value['rating'];
					if($value['juryId'] == $juryId)
					{
						$newArray['yourRating']=$value['rating'];
					}
					$i++;
				}
				$newArray['avgRating']=round($totalRating/$i,2);
			}
			echo json_encode($newArray);
		}
	}
     public function clear_adv_attribute_search()
     {
    	      if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
		    $this->session->unset_userdata('adv_attribute');
		    $this->session->unset_userdata('adv_attribute_id');
			$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
    public function clear_adv_attribute_val_search()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
		    $this->session->unset_userdata('adv_attri_value');
		    $this->session->unset_userdata('adv_attri_value_id');
		    $competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
    public function clear_adv_rating_search()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['competition']) && $_POST['competition']!='')
		{
		    $this->session->unset_userdata('adv_rating');
		 	$competition='';
			$data['competition']=$this->creative_mind_competition_model->getCompetitionData($_POST['competition']);
			if(!empty($data['competition']))
			{
				$competition=$data['competition'][0]['id'];
			}
			$per_call_deal = 12;
			$call_count = $_POST['call_count'];
			$this->creative_mind_competition_model->more_data($per_call_deal,$call_count,$competition);
		}
    }
	public function advance_search()
	{
			//print_r($_POST);die;
		if(isset($_POST) && !empty($_POST))
		{
			if($_POST['adv_search_for']!='')
			{
				$this->session->set_userdata('adv_search_for',$_POST['adv_search_for']);
			}
			if($_POST['attribute']!='')
			{
				$this->session->set_userdata('adv_attribute',$_POST['attribute']);
			}
			if($_POST['attri_value']!='')
			{
				$this->session->set_userdata('adv_attri_value',$_POST['attri_value']);
			}
			if($_POST['rating']!='')
			{
				$this->session->set_userdata('adv_rating',$_POST['rating']);
			}
			if($_POST['attribute_id']!='')
			{
				$this->session->set_userdata('adv_attribute_id',$_POST['attribute_id']);
			}
			if($_POST['attri_value_id']!='')
			{
				$this->session->set_userdata('adv_attri_value_id',$_POST['attri_value_id']);
			}
		}
    }
    public function getJuryWriteUp()
    {
    		$writeUp='';
    	    	if(isset($_POST['juryId']) && $_POST['juryId'])
    		{
    			$writeUp=$this->model_basic->getValue('competition_jury','writeup'," `id` = '".$_POST['juryId']."'");
  		}
  		echo json_encode($writeUp);
    }

    public function get_competition_category($competitionId='')
    {    
    	$category = $this->creative_mind_competition_model->getAllCategory($competitionId);
    	$html = '<option value="">Select Project Category</option>';
    	if(!empty($category))
    	{
    		foreach ($category as $key => $value) {
    			$html .= '<option value="'.$value['id'].'">'.$value['categoryName'].'</option>';    			
    		}
    	}
    	echo $html;
    }
    public function get_regions($zoneId)
    {
    	$region = $this->model_basic->getAllData('region_list','id,region_name',array('zone_id'=>$zoneId),$order='',$limit='',$offset='');
    	$html = '<option value="">Select Project Region</option>';
    	if(!empty($region))
    	{
    		foreach ($region as $key => $value) {
    			$html .= '<option value="'.$value['id'].'">'.$value['region_name'].'</option>';    			
    		}
    	}
    	echo $html;

    }
    public function get_Institute($regionId)
    {
    	$institute = $this->model_basic->getAllData('institute_master','id,instituteName',array('region'=>$regionId),$order='',$limit='',$offset='');
    	$html = '<option value="">Select Project Institute</option>';
    	if(!empty($institute))
    	{
    		foreach ($institute as $key => $value) {
    			$html .= '<option value="'.$value['id'].'">'.$value['instituteName'].'</option>';    			
    		}
    	}
    	echo $html;
    }

    public function get_defult_regions()
    {
    	$zoneId = $_POST['zoneId'];
    	$regionId = $_POST['regionId'];

    	$region = $this->model_basic->getAllData('region_list','id,region_name',array('zone_id'=>$zoneId),$order='',$limit='',$offset='');
    	$html = '<option value="">Select Project Region</option>';

    	if(!empty($region))
    	{
    		foreach ($region as $key => $value) {
    			$selected = '';
    			if($regionId == $value['id'])
    			{
    				$selected = "selected";
    			}

    			$html .= '<option value="'.$value['id'].'" '.$selected.' >'.$value['region_name'].'</option>';    			
    		}
    	}
    	echo $html;
    }

    public function get_defult_Institute()
    {
    	$regionId = $_POST['regionId'];
    	$instituteId = $_POST['instituteId'];

    	$institute = $this->model_basic->getAllData('institute_master','id,instituteName',array('region'=>$regionId),$order='',$limit='',$offset='');
    	$html = '<option value="">Select Project Institute</option>';
    	if(!empty($institute))
    	{
    		foreach ($institute as $key => $value) {
    			$selected = '';
    			if($instituteId == $value['id'])
    			{
    				$selected = "selected";
    			}

    			$html .= '<option value="'.$value['id'].'" '.$selected.' >'.$value['instituteName'].'</option>';    			
    		}
    	}
    	echo $html;
    }

}
