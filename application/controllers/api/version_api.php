<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Version_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	public function checkForUpgrade_post()
	{	
		if($this->post('versionCode'))
        {
           $versionCode = $this->post('versionCode');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Version Code field is Required','statusMessage' => 'bad request'), 404);
		}
	
		if($this->post('version'))
        {
           $version = $this->post('version');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'version field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($versionCode) && isset($version))
	    {
	    	$data = $this->api_model->checkForUpgrade($versionCode,$version);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
	    
	  }
    }
    public function CheckServerDown_post()
	{	
			$data['statusCode']=0;
		 	$data['errorMessage']='';
		 	$data['statusMessage']='';
			echo json_encode($data);
    }
	
	
	 public function saveGcmToken_post()
	{	
		if($this->post('gcmToken'))
        {
           $gcmToken = $this->post('gcmToken');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'GCM Token field is Required','statusMessage' => 'bad request'), 404);
		}
	
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($gcmToken) && isset($deviceId))
	    {
	    	$data = $this->api_model->saveGcmToken($gcmToken,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
	    }
    }
	 public function SaveAppError_post()
	{	
		if($this->post('error') && $this->post('error')!='')
        {
           $error = $this->post('error');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'error field is Required','statusMessage' => 'bad request'), 404);
		}
			
	    if(isset($error))
	    {
	    	$data = $this->api_model->SaveAppError($error);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
	    }
    }
    public function GetMasterData_post()
    {
        $data = $this->api_model->GetMasterData();
        if(!empty($data))
        {
            echo json_encode($data);
        }
       
    }
}
