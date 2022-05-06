<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Blog_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	
	
	public function GetBlogList_post()
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
	    	$data = $this->api_model->GetBlogList($pageNo,$pageSize,$userId,$deviceId,$keyword);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	public function GetBlogDetail_post()
	{	
			        
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
		
        
        if($this->post('blogId'))
        {
           $blogId = $this->post('blogId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Blog Id field is Required','statusMessage' => 'bad request'), 404);
		}
			
		
	    if(isset($blogId))
	    {
	    	$data = $this->api_model->GetBlogDetail($blogId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	
	
	public function AddBlogComment_post()
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
		
        
        if($this->post('blogId'))
        {
           $blogId = $this->post('blogId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Blog Id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		 if($this->post('commentText'))
        {
           $commentText = $this->post('commentText');
        }
         else
        {
		 $this->response(array('statusCode' => 404,'errorMessage' => 'Comment Text Id field is Required','statusMessage' => 'bad request'), 404);
		}
			
		
	    if(isset($blogId)&&isset($commentText)&&isset($userId))
	    {
	    	$data = $this->api_model->AddBlogComment($blogId,$commentText,$userId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	
}
