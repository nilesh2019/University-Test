<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_model');
		$this->load->model('model_basic');
		$this->load->library('form_validation');
	}
	public function index()
	{
		if(isset($_POST['search']) && $_POST['search']!='')
		{
			$search = $_POST['search'];
			$data['search'] = $_POST['search'];
		}
		else
		{
			$data['search'] = '';
			$search = '';
		}
		$data['blog']=$this->blog_model->getAllData($search);
		$this->load->view('blog_view',$data);
	}
	
	public function more_data()
	{
    	$per_call_deal = 4;
		$call_count = $_POST['call_count'];
		$search_term = $_POST['search_term'];
		$this->blog_model->more_data($per_call_deal,$call_count,$search_term);
	}
	public function newsletterDetail($id)
	{
		$data['blog']=$this->blog_model->getSingleBlogData($id);
		$data['comment']=$this->blog_model->getAllComment($id);
		//print_r($data);die;
		$this->load->view('single_blog_view',$data);
	}
	
	public function submitComment()
	{
	  if(isset($_POST['comment']) && $_POST['comment']!='' && isset($_POST['blogId']) && $_POST['blogId']!='')
		{
			$blogId = $_POST['blogId'];
			$comment = $_POST['comment'];
			$data=array('userId'=>$this->session->userdata('front_user_id'),'comment'=>$comment,'blogId'=>$blogId,'created'=>date('Y-m-d H:i:s'));
			$res=$this->blog_model->submit_blog_comment($data);
			
			if($res > 0)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			echo 'false';
		}
	}	
}