<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class People_api extends REST_Controller
{
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('api_model');
	}
	public function GetPeopleList_post()
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
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
		}
	    if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
			$keyword = '';
		}
if($this->post('category'))
        {
           $category = $this->post('category');
        }
         else
        {
			$category = '';
		}
		if($this->post('userId') && $this->post('userId')!='')
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($userId) && isset($pageSize)&& isset($pageNo))
	    {
	
	    	$data = $this->api_model->GetPeopleList($userId,$pageNo,$pageSize,$keyword,$deviceId,$category);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
}
