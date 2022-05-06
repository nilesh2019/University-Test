<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class All_project extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','Explore');
		$this->session->set_userdata('breadCrumbLink','all_project');
        $this->load->model('modelbasic');
		$this->load->helper('text');
	}
	public function index()
	{
		//$this->load->model('all_project_model');
		/*if(!$this->session->flashdata('adv_category'))
		{
			$this->session->unset_userdata('adv_category_id');
		}
		if(!$this->session->flashdata('adv_attribute'))
		{
			$this->session->unset_userdata('adv_attribute_id');
		}
		if(!$this->session->flashdata('adv_attri_value'))
		{
			$this->session->unset_userdata('adv_attri_value_id');
		}
		if(!$this->session->flashdata('adv_rating_exist'))
		{
			$this->session->unset_userdata('adv_rating');
		}*/
		//$data['project']=$this->all_project_model->getAllProjectData();
		//$data['getpro']=$this->all_project_model->get_pro_demo();
		//$data['category']=$this->all_project_model->getAllCategory();
		$this->load->model('modelbasic');
		$data['project']=$this->modelbasic->getValues('project_master','project_master.id,project_master.projectName,project_master.projectPageName,project_master.videoLink,user_project_image.image_thumb,project_master.view_cnt,project_master.like_cnt,category_master.categoryName',array('user_project_image.cover_pic'=>1,'project_master.view_status'=>'Y','project_master.status'=>1),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.created','DESC'),12);
		$data['category']=$this->modelbasic->getValues('category_master','id,categoryName',array('status'=>1),'result_array');
		$this->load->view('all_project_view',$data);
	}
	public function more_data()
	{		
		$per_call_deal = 12;
	    $all_project = $_POST['all_project'];
		$creative_fields = $_POST['creative'];
		$featured = $_POST['featured'];
		$vartime=$_POST['vartime'];
		$search_term = $_POST['search_term'];
		$call_count = $_POST['call_count'];
		$this->load->model('all_project_model');
		$this->all_project_model->more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$vartime);
	}
	public function sort_by()
	{
		//print_r($_POST);die;
    	if(isset($_POST['all_project']) && $_POST['all_project']!='' && isset($_POST['call_count']) && $_POST['call_count']!='')
		{
			$per_call_deal = 12;
			$all_project = $_POST['all_project'];
			$creative_fields = $_POST['creative'];
			$featured = $_POST['featured'];
			$search_term = $_POST['search_term'];
			$vartime = $_POST['vartime'];
			$call_count = $_POST['call_count'];
			$this->load->model('all_project_model');
			$this->all_project_model->more_data($per_call_deal,$call_count,$all_project,$creative_fields,$featured,$search_term,$vartime);
		}

    }
    public function clear_all_adv_sort()
	{
    	$this->session->unset_userdata('adv_category_id');
		$this->session->unset_userdata('adv_attribute_id');
		$this->session->unset_userdata('adv_attri_value_id');
		$this->session->unset_userdata('adv_rating');
		echo 'done';
    }
    public function clear_adv_rating()
	{
		$this->session->unset_userdata('adv_rating');
		echo 'done';
    }
    public function clear_adv_attri_value()
	{
		$this->session->unset_userdata('adv_attri_value_id');
		echo 'done';
    }
    public function clear_adv_attribute()
	{
		$this->session->unset_userdata('adv_attribute_id');
		echo 'done';
    }
    public function clear_adv_category()
	{
		$this->session->unset_userdata('adv_category_id');
		echo 'done';
    }
    public function generateProjectUrl()
	{
		$this->db->select('*');
		$this->db->from('users');
		$userData = $this->db->get()->result_array();
		foreach($userData as $row)
		{
			$username = $row['firstName'].$row['lastName'];
			$userId = $row['id'];
			$this->db->select('id,projectName,userId');
			$this->db->from('project_master');
			$this->db->where('userId',$userId);
			$this->db->where('projectPageName','');
			$userProjects = $this->db->get()->result_array();
			$i=1;
			foreach($userProjects as $data)
			{
				$this->db->select('id,projectName,userId');
				$this->db->from('project_master');
				$this->db->where('userId',$userId);
				$this->db->where('projectPageName','');
				$this->db->where('projectName',$data['projectName']);
				$similarProjects = $this->db->get()->result_array();
				$j='';$projectName='';$newName='';$projectPageName='';
				if(!empty($similarProjects))
				{
					$j='';
					foreach($similarProjects as $rowD)
					{
						$projectName='';$newName='';$projectPageName='';
						$projectName = preg_replace('/[^A-Za-z0-9]/','', strip_tags($rowD['projectName']));
						$newName = str_replace(" ",'',$projectName);
						$projectPageName = $newName.'_'.$j.'_By_'.$username;
						$this->db->where('userId',$data['userId']);
						$this->db->where('id',$rowD['id']);
						$this->db->update('project_master',array('projectPageName'=>$projectPageName));
						$j++;
					}
				}
			}echo '<hr>';
		}
	}

	public function udpate_video_link()
	{
		$this->db->select('id,videoLink');
		$this->db->from('project_master_demo');
		$userData = $this->db->get()->result_array();
		foreach($userData as $row)
		{	
			$this->db->where("id", $row['id']);
			$query = $this->db->update('project_master_demo1', array('videoLink'=>$row['videoLink'])); 
			//echo $this->db->last_query();	
		}
	}
}