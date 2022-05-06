<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Competition_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function GetCompetitionList_post()
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

		if($this->post('instituteId'))
		{
		    $instituteId = $this->post('instituteId');
		}
		else
		{
			$instituteId = '';
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
	    	$data = $this->api_model->GetCompetitionList($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	
	
	public function GetCompetitionDetail_post()
	{	
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
		}
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		
		if($this->post('competitionId'))
        {
           $competitionId = $this->post('competitionId');
        }
         else
        {
        	$competitionId='';
			//$this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'Couldn\'t find competition!'), 404);
		}
		if($this->post('shareUrl'))
        {
           $shareUrl = $this->post('shareUrl');
        }
        else
        {
			$shareUrl='';
		}
	    if(isset($userId) && isset($competitionId))
	    {
	    	$data = $this->api_model->GetCompetitionDetail($userId,$deviceId,$competitionId,$shareUrl);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	
	
	public function JoinCompetition_post()
	{	
	
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
		}
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		
		if($this->post('competitionId'))
        {
           $competitionId = $this->post('competitionId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project Id field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($userId) && isset($competitionId)&& isset($projectId))
	    {
	    	$data = $this->api_model->JoinCompetition($userId,$deviceId,$competitionId,$projectId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	
}
