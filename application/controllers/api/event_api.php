<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Event_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function GetEventList_post()
	{	
				
		if($this->post('pageNo'))
        {
           $pageNo = $this->post('pageNo');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Page No field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('pageSize'))
        {
           $pageSize = $this->post('pageSize');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Page Size field is Required','statusMessage' => 'bad request'), 404);
		}
	        
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $userId = '';
		}
        
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
		
        
        if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
			$keyword = '';
		}
			
		
	    if(isset($pageNo) && isset($pageSize))
	    {
	    	$data = $this->api_model->GetEventList($pageNo,$pageSize,$userId,$deviceId,$keyword);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	
	
	
	
	public function GetEventDetail_post()
	{	
	        
        if($this->post('userId') && $this->post('userId')!='')
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'userId field is Required','statusMessage' => 'bad request'), 404);;
		}
        
        if($this->post('deviceId') && $this->post('deviceId')!='')
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);;
		}
		
        
        if($this->post('eventId') && $this->post('eventId')!='')
        {
           $eventId = $this->post('eventId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'eventId field is Required','statusMessage' => 'bad request'), 404);;
		}
			
		
	    if(isset($userId) && isset($eventId)&& isset($deviceId))
	    {
	    	$data = $this->api_model->GetEventDetail($userId,$deviceId,$eventId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	
	
}
