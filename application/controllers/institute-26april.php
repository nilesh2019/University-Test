<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Institute extends CI_Controller
{
	public function getFeedbackSubmittedNames($instanceId)
	{
		$users=$this->db->select('B.firstName,B.lastName')->from('institutefeedback as A')->join('users as B','A.user_id=B.id')->where('A.instance_id',$instanceId)->where('A.user_id !=',687)->where('A.user_id !=',711)->where('A.user_id !=',738)->where('A.user_id !=',798)->get()->result_array();
		$i=1;
		$list='';
		foreach($users as $user)
		{
			$list.=$i.') '.$user['firstName'].' '.$user['lastName'].'<br/>';
			$i++;
		}
		echo $list;
	}
	public function detail($name=''){
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','Institutes,'.$name);
		$this->session->set_userdata('breadCrumbLink','institute/institute_list,'.$name);
		$this->session->unset_userdata('adv_search_for');
		$this->session->unset_userdata('adv_attribute');
		$this->session->unset_userdata('adv_attri_value');
		$this->session->unset_userdata('adv_rating');
		$this->session->unset_userdata('adv_attribute_id');
		$this->session->unset_userdata('adv_attri_value_id');
		$this->session->unset_userdata('people_sort_by');
		$this->session->unset_userdata('hsort_by');
	    $this->session->unset_userdata('category_sort');
	  	$this->session->set_userdata('user_activity_sort','Featured');
		$this->session->unset_userdata('alumni_user_sort');
		if(isset($_POST['query']) && $_POST['query']!=''){
			$this->session->set_userdata('query',$_POST['query']);
		}else{
			$this->session->unset_userdata('query');
		}
		$this->load->model('modelbasic');
		$data['institute']=$this->modelbasic->getValues('institute_master','id,coverImage,instituteLogo,instituteName,contactNo,address',array('pageName'=>$name,'status'=>1),'row_array');
		if(!empty($data['institute'])){
			$whereArr = "(user_project_image.cover_pic=1) AND (users.instituteId=".$data['institute']['id'].")";
			if($this->session->userdata('user_admin_level') == 1){
				$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
			}elseif($this->session->userdata('user_admin_level') == 4){
				$hoadminData = $this->modelbasic->getValues('admin','admin.id',array('users.id'=>$this->session->userdata('front_user_id')),'row_array',array(array("users","users.email=admin.email")));
				$isInstituteHo=$this->modelbasic->getValue('hoadmin_institute_relation','hoadmin_id',array('hoadmin_id'=>$hoadminData['id'],'institute_id'=>$data['institute']['id']));
				if($isInstituteHo !=''){
					$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
				}else{
					$whereArr .= " AND (project_master.status=1)";
				}
			}else{
				if($this->session->userdata('user_institute_id') && $this->session->userdata('user_institute_id')!='' && $data['institute']['id']==$this->session->userdata('user_institute_id')){
					$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
				}else{
					$whereArr .= " AND (project_master.status=1)";
				}
			}
			$data['project']=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,project_master.userId,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName',$whereArr,'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.created','DESC'),12);
			$data['category']=$this->modelbasic->getValues('category_master','id,categoryName',array('status'=>1),'result_array','','',array('id','desc'));
			$this->load->view('institute_view',$data);
		}else{
			$this->session->set_flashdata('success', 'Welcome to creosouls...!');
			$this->session->set_userdata('refresh_token','');
			$this->session->set_userdata('user_institute_id','');
			$this->session->set_userdata('user_institute_name','');
			$this->session->set_userdata('logged_user_name','');
			$this->session->set_userdata('teachers_status','0');
			$this->session->set_userdata('user_login_id','');
			$this->session->unset_userdata('user_activity_sort');
			redirect(base_url());
		}		
	}
	/*public function detail($name='')
	{
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','Institutes,'.$name);
		$this->session->set_userdata('breadCrumbLink','institute/institute_list,'.$name);
		$this->session->unset_userdata('adv_search_for');
		$this->session->unset_userdata('adv_attribute');
		$this->session->unset_userdata('adv_attri_value');
		$this->session->unset_userdata('adv_rating');
		$this->session->unset_userdata('adv_attribute_id');
		$this->session->unset_userdata('adv_attri_value_id');
		$this->session->unset_userdata('people_sort_by');
		$this->session->unset_userdata('hsort_by');
	    $this->session->unset_userdata('category_sort');
	  	$this->session->set_userdata('user_activity_sort','Featured');
		$this->session->unset_userdata('alumni_user_sort');
		if(isset($_POST['query']) && $_POST['query']!='')
		{
			$this->session->set_userdata('query',$_POST['query']);
		}
		else
		{
			$this->session->unset_userdata('query');
		}
		$institute=array();
		$this->load->model('institute_model');
		$data['institute']=$this->institute_model->getInstituteData($name);
		if(!empty($data['institute']))
		{
			$institute=$data['institute'];
		}
		else
		{
			$this->session->set_flashdata('success', 'Welcome to creosouls...!');
			$this->session->set_userdata('refresh_token','');
			$this->session->set_userdata('user_institute_id','');
			$this->session->set_userdata('user_institute_name','');
			$this->session->set_userdata('logged_user_name','');
			$this->session->set_userdata('teachers_status','0');
			$this->session->set_userdata('user_login_id','');
			$this->session->unset_userdata('user_activity_sort');
			redirect(base_url());
		}
	  	$data['project']=$this->institute_model->getAllProjectData($institute);
		$data['category']=$this->institute_model->getAllCategory();
		$this->load->view('institute_view',$data);
	}*/	
	public function more_data(){
		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!=''){
			$this->load->model('modelbasic');
			$institute=$this->modelbasic->getValue('institute_master','id',array('pageName'=>$_POST['institute'],'status'=>1));
			$whereArr = "(user_project_image.cover_pic=1) AND (users.instituteId=".$institute.")";
			if($this->session->userdata('user_admin_level') == 1){
				$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
			}elseif($this->session->userdata('user_admin_level') == 4){
				$hoadminData = $this->modelbasic->getValues('admin','admin.id',array('users.id'=>$this->session->userdata('front_user_id')),'row_array',array(array("users","users.email=admin.email")));
				$isInstituteHo=$this->modelbasic->getValue('hoadmin_institute_relation','hoadmin_id',array('hoadmin_id'=>$hoadminData['id'],'institute_id'=>$institute));
				if($isInstituteHo !=''){
					$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
				}else{
					$whereArr .= " AND (project_master.status=1)";
				}
			}else{
				if($this->session->userdata('user_institute_id') && $this->session->userdata('user_institute_id')!='' && $institute==$this->session->userdata('user_institute_id')){
					$whereArr .= " AND ((project_master.status=1) OR (project_master.status=3))";
				}else{
					$whereArr .= " AND (project_master.status=1)";
				}
			}
			if($_POST['all_project'] !='' && $_POST['all_project'] == 'Completed'){
				$whereArr .= " AND (project_master.projectStatus=1)";
			}
			if($_POST['all_project'] !='' && $_POST['all_project'] == 'Work in progress'){
				$whereArr .= " AND (project_master.projectStatus=0)";
			}
			if($_POST['alumini_project_status'] != 0){
				$whereArr .= " AND (users.alumniFlag=1)";
			}
			$orderBy=array('project_master.created','DESC');
			if(isset($_POST['featured']) && $_POST['featured'] == 'Featured'){
				$orderBy = array('project_master.featured','DESC');
			}elseif(isset($_POST['featured']) && $_POST['featured'] == 'Most Appreciated'){
				$orderBy = array('project_master.like_cnt','DESC');
				$whereArr .= " AND (project_master.like_cnt >=0)";
			}elseif(isset($_POST['featured']) && $_POST['featured'] == 'Most Viewed'){
				$orderBy = array('project_master.view_cnt','DESC');
			}elseif(isset($_POST['featured']) && $_POST['featured'] == 'Most Discussed'){
				$orderBy = array('project_master.comment_cnt','DESC');
			}
			if($_POST['search_term'] != ''){
				$like_columns=array('project_master.projectName','project_master.basicInfo');
				$like_value=$_POST['search_term'];
			}else{
				$like_columns='';
				$like_value='';
			}
			$instituteProjects=array();
			if(isset($_POST['creative']) && !empty($_POST['creative'])){
				$instituteProjects=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,project_master.userId,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName',$whereArr,'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',$orderBy,array(12,($_POST['call_count'] - 1) * 12),$like_columns,$like_value,'','','project_master.categoryId',$_POST['creative']);
			}else{
				$instituteProjects=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,project_master.userId,users.firstName,users.lastName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName',$whereArr,'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',$orderBy,array(12,($_POST['call_count'] - 1) * 12),$like_columns,$like_value);
			}
			//echo $this->db->last_query();die;
			if(!empty($instituteProjects)){ 
				$i=0;
			 	foreach($instituteProjects as $row){
			 		$instituteProjects[$i]['imageCount']=$this->modelbasic->count_all_only('user_project_image',array('project_id'=>$row['id']));
			 		$totalLikeName = $this->modelbasic->getValues('user_project_views','users.firstName,users.lastName',array('user_project_views.projectId'=>$row['id'],'user_project_views.userLike'=>1),'result_array',array(array("users","users.id=user_project_views.userId")));
	 				$str ='';
	 				if(!empty($totalLikeName)){
	 					$str .='<ul class="dropdown-menu">';
	 					foreach ($totalLikeName as $TLname) {
	 						$str .='<li>'.$TLname["firstName"].' '.$TLname["lastName"].'</li>';								
	 					}  
	 					$str .='</ul>'; 
	 					$instituteProjects[$i]['droupdown']=$str;
	 				}else{
	 					$str .='<ul class="dropdown-menu"></ul>';
	 					$instituteProjects[$i]['droupdown']=$str;
	 				}
			 		$i++;
			 	}
			}
			if(!empty($instituteProjects)){
				echo json_encode($instituteProjects);
			}else{
				echo '';
			}
		}
	}
	public function alumini_projects($instituteName)
	{
		$institute=array();
		$this->load->model('institute_model');
		$data['institute']=$this->institute_model->getInstituteData($instituteName);
	  	$data['project']=$this->institute_model->getAllAluminiProjectData($data['institute'][0]['id']);
		$data['category']=$this->institute_model->getAllCategory();
		$this->load->view('institute_alumini_project_view',$data);
	}
	public function alumini_people($instituteName)
	{
		$institute=array();
		$this->load->model('institute_model');
		$data['institute']=$this->institute_model->getInstituteData($instituteName);
	  	$data['peoples']=$this->institute_model->getAllAluminiPeopleData($data['institute'][0]['id']);
		$data['category']=$this->institute_model->getAllCategory();
		//print_r($data);die;
		$this->load->view('institute_alumini_people_view',$data);
	}
	public function join_institute()
	{
		if(isset($_POST['ins_id']) && $_POST['ins_id']!='')
		{
			$this->session->set_userdata('clicked_institute_id',$_POST['ins_id']);
			echo 'done';
		}
	}
	/*public function more_data()
	{
		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
		{
			$institute=array();
			$this->load->model('institute_model');
			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
			if(!empty($data['institute']))
			{
				$institute=$data['institute'];
			}
	    	$per_call_deal = 12;
	    	$all_project = $_POST['all_project'];
			$creative_fields = $_POST['creative'];
			$featured = $_POST['featured'];
			$search_term = $_POST['search_term'];
			$call_count = $_POST['call_count'];
			$alumini_project_status = $_POST['alumini_project_status'];
			$this->load->model('institute_model');
			$this->institute_model->more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$institute,$alumini_project_status);
		}
	}*/
	public function alumini_more_data()
	{		
		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
		{
			$institute=array();
			$this->load->model('institute_model');
			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
			if(!empty($data['institute']))
			{
				$institute=$data['institute'];
			}
	    	$per_call_deal = 8;
	    	$all_project = $_POST['all_project'];
			$creative_fields = $_POST['creative'];
			$featured = $_POST['featured'];
			$search_term = $_POST['search_term'];
			$call_count = $_POST['call_count'];
			$alumini_project_status = $_POST['alumini_project_status'];
			$this->load->model('institute_model');
			$this->institute_model->alumini_more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$institute,$alumini_project_status);
		}
	}

	public function alumini_more_data_people()
	{
		if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
		{
			$institute=array();
			$this->load->model('institute_model');
			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
			if(!empty($data['institute']))
			{
				$institute=$data['institute'][0]['id'];
			}	
	    	$per_call_deal = 8;	    	
			$search_term = $_POST['search_term'];
			$call_count = $_POST['call_count'];	
			$this->institute_model->alumini_more_data_people($per_call_deal,$call_count,$search_term,$institute);

		}
	}

	public function search_more_data()
	{
    	$per_call_deal = 8;
		$call_count = $_POST['call_count'];
		$search_term = $_POST['search_term'];
		$this->load->model('institute_model');
		$this->institute_model->search_more_data($per_call_deal,$call_count,$search_term);
	}



	public function sort_by()
	{
    	if(isset($_POST['all_project']) && $_POST['all_project']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
		{
			$institute=array();
			$this->load->model('institute_model');
			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
			if(!empty($data['institute']))
			{
				$institute=$data['institute'];
			}
			$per_call_deal = 8;
			$all_project = $_POST['all_project'];
			$creative_fields = $_POST['creative'];
			$featured = $_POST['featured'];
			$search_term = $_POST['search_term'];
			$call_count = $_POST['call_count'];
			$alumini_project_status = $_POST['alumini_project_status'];
			$this->load->model('institute_model');
			$this->institute_model->more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$institute,$alumini_project_status);
		}
    }
    	public function alumini_sort_by()
    	{
        	if(isset($_POST['all_project']) && $_POST['all_project']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
    		{
    			$institute=array();
    			$this->load->model('institute_model');
    			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
    			if(!empty($data['institute']))
    			{
    				$institute=$data['institute'];
    			}
    			$per_call_deal = 8;
    			$all_project = $_POST['all_project'];
    			$creative_fields = $_POST['creative'];
    			$featured = $_POST['featured'];
    			$search_term = $_POST['search_term'];
    			$call_count = $_POST['call_count'];
    			$alumini_project_status = $_POST['alumini_project_status'];
    			$this->load->model('institute_model');
    			$this->institute_model->alumini_more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$institute,$alumini_project_status);
    		}
        }
    public function alumni_user_sort()
	{
    	if(isset($_POST['status']) && $_POST['status']!='' && isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
		{
			if($_POST['status']==1)
			{
				$this->session->set_userdata('alumni_user_sort',1);
			}
			if($_POST['status']==0)
			{
				$this->session->unset_userdata('alumni_user_sort');
			}
			$institute=array();
			$this->load->model('institute_model');
			$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
			if(!empty($data['institute']))
			{
				$institute=$data['institute'];
			}
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->load->model('institute_model');
			$this->institute_model->more_data($per_call_deal,$call_count,$institute);
		}
    }
	public function institute_list()
	{
        //echo "institute_list";exit;
		/*if(!$this->session->userdata('breadCrumb') && $this->session->userdata('breadCrumb')=='')
		{
			$this->session->set_userdata('breadCrumb')='Institutes';
		}*/
		$this->load->model('institute_model');
		$data['institute']=$this->institute_model->getAllInstituteData();
		//echo $this->db->last_query(); 
        //echo "<pre>";print_r($data['institute']);exit;
		$this->load->view('institute_list_view',$data);
	}
	public function institute_more_data()
	{
    	$per_call_deal = 8;
		$call_count = $_POST['call_count'];
		if(isset($_POST['search_term']))
		{
			$search_term = $_POST['search_term'];
		}
		else {
			$search_term = '';
		}
		
		$this->load->model('institute_model');
		$this->institute_model->institute_more_data($per_call_deal,$call_count,$search_term);
	}

	public function people_more_data()
	{    	
    	if(isset($_POST['call_count']) && $_POST['call_count']!=''&& isset($_POST['institute']) && $_POST['institute']!='')
    	{
    		$institute=array();
    		$this->load->model('institute_model');
    		$data['institute']=$this->institute_model->getInstituteData($_POST['institute']);
    		if(!empty($data['institute']))
    		{
    			$institute=$data['institute'][0]['id'];
    		}

        	$per_call_deal = 8;	        	
    		$search_term = $_POST['search_term'];
    		$call_count = $_POST['call_count'];	    		
    		$this->load->model('institute_model');
    		$this->institute_model->alumini_more_data_people($per_call_deal,$call_count,$search_term,$institute);
    	}

	}

}

