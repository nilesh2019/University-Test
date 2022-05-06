<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Institute_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	public function GetInstituteList_post()
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
	    	$data = $this->api_model->GetInstituteList($pageNo,$pageSize,$userId,$deviceId,$keyword);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	public function GetInstituteDetail_post()
	{
        if($this->post('userId') && $this->post('userId')!='')
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
        if($this->post('instituteId'))
        {
           $instituteId = $this->post('instituteId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'InstituteId field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($instituteId))
	    {
	    	$data = $this->api_model->GetInstituteDetail($instituteId,$userId,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	public function GetInstituteProjectList_post()
	{
	  if($this->post('pageNo'))
        {
           $pageNo = $this->post('pageNo');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Page No field is Required','statusMessage' => 'bad request'), 404);
		}
		 if($this->post('instituteId'))
        {
           $instituteId = $this->post('instituteId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'InstituteId field is Required','statusMessage' => 'bad request'), 404);
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
		if($this->post('category'))
        {
           $category = $this->post('category');
        }
         else
        {
			$category = '';
		}
		if($this->post('featuredType'))
        {
           $featuredType = $this->post('featuredType');
        }
         else
        {
			$featuredType = '';
		}
		if($this->post('projectStatus'))
        {
           $projectStatus = $this->post('projectStatus');
        }
        else
        {
			$projectStatus = '';
		}
	    if(isset($pageNo) && isset($pageSize)&& isset($instituteId))
	    {
	    	$data = $this->api_model->GetInstituteProjectList($pageNo,$pageSize,$userId,$deviceId,$keyword,$category,$featuredType,$projectStatus,$instituteId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
	  public function JoinInstitute_post()
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
        if($this->post('instituteId'))
        {
           $instituteId = $this->post('instituteId');
        }
         else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Institute Id field is Required','statusMessage' => 'bad request'), 404);
		}
	    if(isset($userId) && isset($instituteId))
	    {
	    	$data = $this->api_model->JoinInstitute($userId,$deviceId,$instituteId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
        public function AddInstituteFeedback_post()
        {
            if($this->post('userId'))
            {
                  $userId = $this->post('userId');
            }
            else
            {
    	  $this->response(array('statusCode' => 404,'errorMessage' => 'User Id is Required','statusMessage' => 'bad request'), 404);
            }
            if($this->post('deviceId'))
            {
               $deviceId = $this->post('deviceId');
            }
            else
            {
	       $this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'bad request'), 404);
	 }
        if($this->post('instituteId'))
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
	$this->response(array('statusCode' => 404,'errorMessage' => 'Institute Id is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('instancdId'))
        {
           $instancdId = $this->post('instancdId');
        }
        else
        {
	$this->response(array('statusCode' => 404,'errorMessage' => 'instance Id is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('feedback'))
        {
           $feedback = $this->post('feedback');
        }
        else
        {
	$this->response(array('statusCode' => 404,'errorMessage' => 'Feedback is Required','statusMessage' => 'bad request'), 404);
        }
       if($this->post('wouldYouLiketoTellAnyonetoJoinOurInstitute'))
        {
           $likeJoinOurInstitute = $this->post('wouldYouLiketoTellAnyonetoJoinOurInstitute');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'WouldYouLiketoTellAnyonetoJoinOurInstitute is Required','statusMessage' => 'bad request'), 404);
	   }
        if($this->post('questionList'))
        {
           $questionList = $this->post('questionList');
           //$questionList = json_decode($questionList);
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'QuestionList is Required','statusMessage' => 'bad request'), 404);
         }
	if(isset($userId) && isset($instituteId) && !empty($questionList) && isset($instancdId))
	{
		$data = $this->api_model->AddInstituteFeedback($userId,$deviceId,$instituteId,$questionList,$likeJoinOurInstitute,$feedback,$instancdId);
		if(!empty($data))
		{
			echo json_encode($data);
		}
	}
    }
public function GetInstanceDetails_post(){
                    if($this->post('userId'))
                    {
                          $userId = $this->post('userId');
                    }
                    else
                    {
                        $this->response(array('statusCode' => 404,'errorMessage' => 'User Id is Required','statusMessage' => 'bad request'), 404);
                    }
                    if($this->post('deviceId'))
                    {
                       $deviceId = $this->post('deviceId');
                    }
                    else
                    {
                        $this->response(array('statusCode' => 404,'errorMessage' => 'Device Id field is Required','statusMessage' => 'bad request'), 404);
                    }
                    if($this->post('instituteId'))
                    {
                       $instituteId = $this->post('instituteId');
                    }
                    else
                    {
                        $this->response(array('statusCode' => 404,'errorMessage' => 'Institute Id is Required','statusMessage' => 'bad request'), 404);
                    }
                    if($this->post('instanceId'))
                    {
                       $instanceId = $this->post('instanceId');
                    }
                    else
                    {
                        $this->response(array('statusCode' => 404,'errorMessage' => 'Instance Id is Required','statusMessage' => 'bad request'), 404);
                    }
                    if(isset($userId) && isset($instituteId) && !empty($instanceId))
                    {
                        $data = $this->api_model->GetInstanceDetails($userId,$deviceId,$instituteId,$instanceId);
                        if(!empty($data))
                        {
                            $data['brand']='test';
                            $data['centerName']='test';
                            $data['courseName']='test';
                            $data['statusCode']=200;
                            $data['errorMessage']='';
                            $data['statusMessage']='Done';
                            //$data['wouldYouLiketoTellAnyonetoJoinOurInstitute']=
                            echo json_encode($data);
                        }
                    }
            }
}
