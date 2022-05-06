<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
*	@author : Santosh Badal
*	date	: 05 August, 2014
*	http://unichronic.com
*	Unichronic - Master Admin
*/
 
class Dashboard extends MY_Controller
{
      
	function __construct()
	{
      //echo "hello";exit();
        parent::__construct();
        //echo "hello";exit();
    	$this->load->model('admin/dashboard_model');
    	$this->load->model('modelbasic');
     
	}
	
	public function index($institute_name='',$user_id='')
	{
		$data['recent_comment']=$this->dashboard_model->project_comment();
		$data['user_data']=$this->dashboard_model->get_users_data();
		/*$data['all_project']=$this->dashboard_model->getAllProject();*/
		$this->load->view('admin/dashboard_view',$data);
	}
   	
   	function change_user_status()
	{
	  if(isset($_POST['userId']) && ($_POST['userId'] !='') && isset($_POST['status']) && ($_POST['status'] !=''))
	   {
			$result = $this->modelbasic->getValue('users','status','id',$_POST['userId']);
			if($result == 1)
			{
				$data = array('status'=>'0');
			}else if($result == 0)
			{
				$data = array('status'=>'1');
			}
			$res = $this->modelbasic->_update('users',$_POST['userId'], $data);
			 if($res>0)
			 {
			   echo 'yes';
			 }
			 else
			 {
			 	echo 'no';
			 }
	   }
	     else
		  {
		  	echo 'no';
		  }	
	} 
	
		 
}


