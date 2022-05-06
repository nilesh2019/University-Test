<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Job_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function GetJobList_post()
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
			
		if($this->post('jobType'))
        {
           $jobType = $this->post('jobType');
        }
       else
        {
		$this->response(array('statusCode' => 404,'errorMessage' => 'Job Type field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($pageNo) && isset($pageSize))
	    {
	    	$data = $this->api_model->GetJobList($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	public function CheckSelectedForJob_post()
	{
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
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
	    if(isset($userId))
	    {
	    	$data = $this->api_model->CheckSelectedForJob($userId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	public function SaveJobFeedback_post()
	{
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' =>404,'errorMessage' =>'User Id field is required','statusMessage' =>'bad request'), 404);
		}
		if($this->post('jobId'))
        {
           $jobId = $this->post('jobId');
        }
         else
        {
		   $this->response(array('statusCode' =>404,'errorMessage' =>'Job Id field is required','statusMessage' =>'bad request'), 404);
		}
		if($this->post('joinJob')!='')
        {
           $joinJob = $this->post('joinJob');
        }
         else
        {
		   $this->response(array('statusCode' =>404,'errorMessage' =>'Join status field is required','statusMessage' =>'bad request'), 404);
		}
		if($this->post('feedback'))
        {
           $feedback = $this->post('feedback');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' =>'Feedback field is required','statusMessage' => 'bad request'),404);
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
	    if(isset($userId))
	    {
	    	$data = $this->api_model->SaveJobFeedback($userId,$jobId,$joinJob,$feedback);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	
	public function GetJobDetail_post()
	{	
		if($this->post('jobId'))
        {
           $jobId = $this->post('jobId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Job Id field is Required','statusMessage' => 'bad request'), 404);
		}
	
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
			$deviceId = '';
		}
		
	    if(isset($jobId) && isset($userId))
	    {
	    	$data = $this->api_model->GetJobDetail($userId,$deviceId,$jobId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	public function ApplyJob_post()
	{	
		if($this->post('jobId'))
        {
           $jobId = $this->post('jobId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Job Id field is Required','statusMessage' => 'bad request'), 404);
		}
	
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
		}
        if($this->post('instituteId'))
        {
           $instituteId = $this->post('instituteId');
        }
         else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
		
	    if(isset($jobId) && isset($userId))
	    {
	    	$data = $this->api_model->ApplyJob($userId,$deviceId,$jobId,$instituteId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	
	public function AdvancedJobSearch_post()
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
		
		if($this->post('jobType'))
        {
           $jobType = $this->post('jobType');
        }
        else
        {
		$this->response(array('statusCode' => 404,'errorMessage' => 'Job Type field is Required','statusMessage' => 'bad request'), 404);
		}		
		if($this->post('companyName'))
        {
           $companyName = $this->post('companyName');
        }
        else
        {
		 $companyName = '';
		}
		
		if($this->post('jobTitle'))
        {
           $jobTitle = $this->post('jobTitle');
        }
        else
        {
		  $jobTitle = '';
		}
		
		if($this->post('lcocationPlace'))
        {
           $lcocationPlace = $this->post('lcocationPlace');
        }
        else
        {
		  $lcocationPlace = '';
		}
		
		if($this->post('activeJobType'))
        {
           $activeJobType = $this->post('activeJobType');
        }
        else
        {
		$this->response(array('statusCode' => 404,'errorMessage' => 'Active Job Type field is Required','statusMessage' => 'bad request'), 404);
		}
				
	
	    if(isset($pageNo) && isset($pageSize))
	    {
	    	$data = $this->api_model->AdvancedJobSearch($pageNo,$pageSize,$userId,$instituteId,$deviceId,$keyword,$jobType,$companyName,$jobTitle,$lcocationPlace,$activeJobType);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
}
