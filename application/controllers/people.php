<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class People extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('model_basic');
	}
	public function index()
	{	
		
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
		
		$data['peoples']=$this->people_model->getAllData();
		$this->load->view('people_view',$data);
	}
	public function more_data()
	{
    		$per_call_data = 12;
		$call_count = $_POST['call_count'];
		$search_term = trim($_POST['search_term']);
	    $this->people_model->more_data($per_call_data,$call_count,$search_term);
	}
	
	public function people_clear_sort()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!='')
		{
			$this->session->unset_userdata('adv_search_for');
			$this->session->unset_userdata('adv_attribute');
			$this->session->unset_userdata('adv_attri_value');
			$this->session->unset_userdata('adv_rating');
			$this->session->unset_userdata('adv_attribute_id');
			$this->session->unset_userdata('adv_attri_value_id');
			$this->session->unset_userdata('people_sort_by');
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->people_model->more_data($per_call_deal,$call_count);
		}
    }
      public function clear_adv_attribute_search()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!='')
		{
		    $this->session->unset_userdata('adv_attribute');
		    $this->session->unset_userdata('adv_attribute_id');
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->people_model->more_data($per_call_deal,$call_count);
		}
    }
          public function clear_adv_category_search()
    	{
        	if(isset($_POST['call_count']) && $_POST['call_count']!='')
    		{
    		    $this->session->unset_userdata('adv_category');
    		    $this->session->unset_userdata('adv_category_id');
    			$per_call_deal = 8;
    			$call_count = $_POST['call_count'];
    			$this->people_model->more_data($per_call_deal,$call_count);
    		}
        }
    public function clear_adv_attribute_val_search()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!='')
		{
		    $this->session->unset_userdata('adv_attri_value');
		    $this->session->unset_userdata('adv_attri_value_id');
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->people_model->more_data($per_call_deal,$call_count);
		}
    }
    public function clear_adv_rating_search()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!='')
		{
		    $this->session->unset_userdata('adv_rating');
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->people_model->more_data($per_call_deal,$call_count);
		}
    }
     public function sort_by()
	{
    	if(isset($_POST['call_count']) && $_POST['call_count']!='' && isset($_POST['name']) && $_POST['name']!='')
		{
			  if($_POST['name']=='Sort By')
			  {
			  		$this->session->unset_userdata('people_sort_by');
			  }
			  else
			  {
			       $this->session->set_userdata('people_sort_by',$_POST['name']);
			  }
			$per_call_deal = 8;
			$call_count = $_POST['call_count'];
			$this->people_model->more_data($per_call_deal,$call_count);
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
}
