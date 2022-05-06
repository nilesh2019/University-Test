<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Project_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function GetProjectList_post()
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
		
	
	    if(isset($pageNo) && isset($pageSize))
	    {
	    	$data = $this->api_model->GetProjectList($pageNo,$pageSize,$userId,$deviceId,$keyword,$category,$featuredType,$projectStatus);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	
		public function GetTrendingProjectList_post()
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
			
		
		    
		    	$data = $this->api_model->GetTrendingProjectList($userId,$deviceId,$keyword,$category,$featuredType,$projectStatus);
		       	if(!empty($data))
		    	{
				 	echo json_encode($data);
				}
		
			
		}
	public function GetProjectDetail_post()
	{	
				
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
        	$projectId='';
        }
        /*else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'Couldn\'t find  project!'), 404);
		}*/

		if($this->post('shareUrl'))
        {
           $shareUrl = $this->post('shareUrl');
        }
        else
        {
			$shareUrl='';
		}
		        
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
         else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
        
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
		
      	
		
	    if(isset($projectId))
	    {
	    	$data = $this->api_model->GetProjectDetail($projectId,$shareUrl,$userId,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	public function ProjectLike_post()
	{	
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('userLikeStatus'))
        {
           $userLikeStatus = $this->post('userLikeStatus');
        }
        else
        {
		   $userLikeStatus = '';
		}
		
	    if(isset($projectId)&&isset($userId))
	    {
	    	$data = $this->api_model->ProjectLike($projectId,$userId,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	
	public function AddProject_post()
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
			$deviceId = '';
		}
		
		if($this->post('projectName'))
        {
           $projectName = $this->post('projectName');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project Name field is Required','statusMessage' => 'bad request'), 404);
		}

		if($this->post('isTeam'))
		{
		    $isTeam = $this->post('isTeam');
		}
		else
		{
			$isTeam = 0;
		}
		if($this->post('teamMembers') !='')
		{
		   $teamMembers =$this->post('teamMembers');
		}
		else
		{
			$teamMembers = '';
		}
		
		if($this->post('projectType'))
        {
           $projectType = $this->post('projectType');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project Type field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('projectStatus')!=0)
        {
           $projectStatus = $this->post('projectStatus');
        }
        else
        {
			$projectStatus =0;
		   //$this->response(array('statusCode' => 404,'errorMessage' => 'Project Status field is Required','statusMessage' => 'Project Status Required!'), 404);
		}
		
		if($this->post('projectPublish')!=0)
        {
           $projectPublish = $this->post('projectPublish');
        }
        else
        {
			$projectPublish = 0;
		   //$this->response(array('statusCode' => 404,'errorMessage' => 'Project Publish field is Required','statusMessage' => 'Project Publish Status Required!'), 404);
		}
		
		if($this->post('CategoryName')!='')
        {
           $category = $this->post('CategoryName');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Category field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if(isset($_FILES['imageList']) && $_FILES['imageList']['size'] != 0)
      {
      	$imageListArray = ($_FILES['imageList']['name']);
         
      }
     else
        {
            if($this->post('videoLink') != ''){
           		$imageListArray = array(149706);
            }else{
		    	$this->response(array('statusCode' => 404,'errorMessage' => 'Image Required','statusMessage' => 'bad request'), 404);
		    }
		}
		if($this->post('coverPicPosition') !='')
        {
           $coverPicPosition = $this->post('coverPicPosition');
        
        }
        else
        {
        	if($this->post('videoLink') != ''){
        	    $coverPicPosition = '';
        	}else{
        		$this->response(array('statusCode' => 404,'errorMessage' => 'Cover Picture Image Required','statusMessage' => 'bad request'), 404);
        	}
		   
		}
		if($this->post('videoLink'))
        {
            $url = $this->post('videoLink');
            $key = 'watch?v='; 
           	if (strpos($url, $key) == TRUE) { 
           	    $videoLinkArr = explode("watch?v=",$url);
           	    $videoLink    = $videoLinkArr[1];
           	  
           	}else { 
           	    $videoLinkArr = explode("youtu.be/",$url);
           	    $videoLink    = $videoLinkArr[1];
           	}
        }
        else
        {
        	$videoLink='';
        }

if($this->post('socialFeatures') ==1)
	{
	   $socialFeatures = 1;

	}
	elseif($this->post('socialFeatures') !=1)
	{
		$socialFeatures = 0;

	}
else{$socialFeatures = 1;
}
      	if($this->post('waterMarkTextText') !='')
	{
	   $waterMarkText = $this->post('waterMarkTextText');
	}
	else
	{
		$waterMarkText = '';
	}
      	if($this->post('waterMarkTextColor') !='')
	{
	   $waterMarkTextColor = $this->post('waterMarkTextColor');
	}
	else
	{
		$waterMarkTextColor = '';
	}
      	if($this->post('thoughtProcess') !='')
	{
	   $thoughtProcess = $this->post('thoughtProcess');
	}
	else
	{
		$thoughtProcess = '';
	}
	if($this->post('keyword') !='')
	{
	   $keyword = $this->post('keyword');
	}
	else
	{
		$keyword = '';
	}
	if($this->post('copyrightSetting') !='' && $this->post('copyrightSetting') =='Requires Permission')
	{
	   $copyrightSetting = 1;
	}
	else
	{
		$copyrightSetting = 0;
	}
	if($this->post('description') !='')
	{
	   $description =$this->post('description') ;
	}
	else
	{
		$description = '';
	}
	if($this->post('offlineId'))
	{
	   $offlineId =$this->post('offlineId') ;
	}
	else
	{
		$offlineId =0;
	}
	if($this->post('isForCompetition') == 1)
	{
	   $isForCompetition = $this->post('isForCompetition') ;
	}
	else
	{
		$isForCompetition=0;
	}
	if($this->post('isShowreel') == 1)
	{
	   $isShowreel = $this->post('isShowreel') ;
	}
	else
	{
		$isShowreel=0;
	}
		$isPaymentDone=$this->api_model->isPaymentDone($userId);
		if($isPaymentDone >0)
		{

		    if(isset($projectName)&&isset($userId)&&isset($projectType)&&isset($category)&&isset($imageListArray))
		    {
			
		    	$data = $this->api_model->AddProject($userId,$deviceId,$projectName,$isTeam,$teamMembers,$projectType,$projectStatus,$projectPublish,$category,$imageListArray,$videoLink,$coverPicPosition,$socialFeatures,$waterMarkText,$waterMarkTextColor,$thoughtProcess,$keyword,$copyrightSetting,$description,$offlineId,$isForCompetition,$isShowreel);

		    	if(!empty($data))
		    	{
				 	echo json_encode($data);
				}
			     
			}
		}
		else
		{
			$this->response(array('statusCode' => 0,'errorMessage' => 'Payment is not done, please contact your institute admin.','statusMessage' => 'Payment is not done, please contact your institute admin.'), 404);
		}
	}
	
	
	public function AddProjectReview_post()
	{	
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('commentText'))
        {
           $commentText = $this->post('commentText');
        }
        else
        {
		  $this->response(array('statusCode' => 404,'errorMessage' => 'comment Text is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('rating'))
        {
           $rating = $this->post('rating');
        }
        else
        {
		   $rating = '';
		}
		
	    if(isset($projectId)&&isset($userId)&&isset($commentText))
	    {
	    	$data = $this->api_model->AddProjectReview($projectId,$userId,$deviceId,$commentText);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	
	
	public function DeleteProject_post()
	{	
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		
	    if(isset($projectId)&&isset($userId))
	    {
	    	$data = $this->api_model->DeleteProject($projectId,$userId,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	public function GetUserProjectList_post()
	{	
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
				if($this->post('peopleId'))
		        {
		           $peopleId = $this->post('peopleId');
		        }
		        else
		        {
				   $this->response(array('statusCode' => 404,'errorMessage' => 'People id field is Required','statusMessage' => 'bad request'), 404);
				}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		
		if($this->post('tabType') !='')
        {
           $tabType = $this->post('tabType');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'TabType field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('instituteId') !=0 )
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
			//$this->response(array('statusCode' => 404,'errorMessage' => 'InstituteId field is Required','statusMessage' => 'Sorry, Refresh Page !'), 404);
			$instituteId=0;
		}
		
		
	    if(isset($userId)&&isset($tabType))
	    {
	    	$data = $this->api_model->GetUserProjectList($userId,$deviceId,$tabType,$instituteId,$peopleId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	}
	
	
	public function GetProjectCategory_post()
	{	
     	$data = $this->api_model->GetProjectCategory();
	       	if(!empty($data))
	    	{
		 	echo json_encode($data);
			}
	}
	public function GetCompProjectCategory_post()
	{	
	    $data = $this->api_model->GetCompProjectCategory();
		if(!empty($data))
		{
			echo json_encode($data);
		}
	}
	public function AppreciateWork_post()
	{
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('applicationText'))
        {
           $applicationText = $this->post('commentText');
        }
        else
        {
		  	$applicationText = '';
		}
		$appreciatedUserId=$this->api_model->getValueOnly('project_master','userId',array('id'=>$projectId));
		$res=$this->model_basic->_insert('project_appreciation',array('projectId'=>$projectId,'appreciatedUserId'=>$appreciatedUserId,'appreciateByUserId'=>$userId,'comment'=>$applicationText));
		if($res > 0)
	    {
	      $status = array("statusCode" => 200, "errorMessage" => "Done", "statusMessage" => "Done" );
	    }
	    else
	    {
	     $status = array( "statusCode" => 404, "errorMessage" => "Data not inserted.", "statusMessage" => "Data not inserted." );
	    }
	    echo json_encode($status); 
	}

	public function SaveOrRemoveOnMyBoard_post()
	{
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('flag'))
        {
           $flag = $this->post('flag');
        }
        else
        {
		  	$this->response(array('statusCode' => 404,'errorMessage' => 'Flag field is Required','statusMessage' => 'bad request'), 404);
		}
		if($flag == 1)
		{
			$res=$this->model_basic->_insert('user_myboard',array('projectId'=>$projectId,'myboardUser'=>$userId));
		}
		if($flag == 2)
		{
			$res=$this->model_basic->_deleteWhere('user_myboard',array('projectId'=>$projectId,'myboardUser'=>$userId));
		}
		
	    $status = array("statusCode" => 200, "errorMessage" => "Done", "statusMessage" => "Done" );
	    echo json_encode($status);
	}
public function GetMyBoardProjectList_post()
	{
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		$projectList=$this->model_basic->getAllData('user_myboard','projectId',array('myboardUser'=>$userId));
		if(!empty($projectList))
		{
	    	$data = $this->api_model->GetMyBoardProjectList($userId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
		else
		{
			$status = array("statusCode" => 200, "errorMessage" => "Done", "statusMessage" => "Done" );
			echo json_encode($status);
		}  	
	}
	public function GetMyStreamProjectList_post()
	{
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		$followedPeople=$this->model_basic->getAllData('user_follow','followingUser',array('userId'=>$userId));
		if(!empty($followedPeople))
		{
	    	if(!empty($followedPeople))
	    	{
	    		foreach($followedPeople as $row)
	    		{
	    			$arr[]=$row['followingUser'];
	    		}
	    	}
	    	$data = $this->api_model->GetMyStreamProjectList($arr);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
		else
		{
			$status = array("statusCode" => 200, "errorMessage" => "Done", "statusMessage" => "Done" );
			echo json_encode($status);
		}  	
	}

	public function UpdateProjectStatus_post()
	{
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('status') !='')
        {
           $status = $this->post('status');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Status field is Required','statusMessage' => 'bad request'), 404);
		}
		if(isset($projectId) && isset($status)&& isset($userId))
		{
		
		    $data = $this->api_model->UpdateProjectStatus($projectId,$userId,$status);
		    if(!empty($data))
		    {
		        echo json_encode($data);
		    }
		} 	
	}

	public function GetAllUserProject_post()
	{	
		if($this->post('userId'))
		{
		  $userId = $this->post('userId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
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
	    	$data = $this->api_model->GetAllUserProject($userId,$deviceId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}

	public function ChangeProjectImage_post()
	{	
		if($this->post('userId'))
		{
		  $userId = $this->post('userId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('projectId'))
		{
		  $projectId = $this->post('projectId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('imageId'))
		{
		  $imageId = $this->post('imageId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Image id field is Required','statusMessage' => 'bad request'), 404);
		}
		if(isset($_FILES['imageList']) && $_FILES['imageList']['size'] != 0)
		{
		   $imageListArray = ($_FILES['imageList']['name']);
		}
		else
		{
			$this->response(array('statusCode' => 404,'errorMessage' => 'Image Required','statusMessage' => 'bad request'), 404);
		}
      if($this->post('deviceId'))
      {
         $deviceId = $this->post('deviceId');
      }
      else
      {
			$deviceId = '';
		}
	   if(isset($userId) && isset($projectId) && isset($imageId) && isset($imageListArray))
	   {
	    	$data = $this->api_model->ChangeProjectImage($userId,$projectId,$imageId,$imageListArray);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}

	public function RemoveProjectImage_post()
	{	
		if($this->post('userId'))
		{
		  $userId = $this->post('userId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('projectId'))
		{
		  $projectId = $this->post('projectId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('imageId'))
		{
		  $imageId = $this->post('imageId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Image id field is Required','statusMessage' => 'bad request'), 404);
		}
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
	    if(isset($userId) && isset($projectId) && isset($imageId))
	    {
	    	$data = $this->api_model->RemoveProjectImage($userId,$projectId,$imageId);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
public function AddProjectImage_post()
	{	
		if($this->post('userId'))
		{
		  $userId = $this->post('userId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('projectId'))
		{
		  $projectId = $this->post('projectId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		if(isset($_FILES['imageList']) && $_FILES['imageList']['size'] != 0)
		{
			$imageListArray = ($_FILES['imageList']['name']);
		}
		else
		{
			$this->response(array('statusCode' => 404,'errorMessage' => 'Image Required','statusMessage' => 'bad request'), 404);
		}
      if($this->post('deviceId'))
      {
         $deviceId = $this->post('deviceId');
      }
      else
      {
			$deviceId = '';
		}
	   if(isset($userId) && isset($projectId) && isset($imageListArray))
	   {
	    	$data = $this->api_model->AddProjectImage($userId,$projectId,$imageListArray);
	      if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}

	public function EditProject_post()
	{	
		if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('CategoryName')!='')
        {
           $category = $this->post('CategoryName');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Category field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('copyrightSetting') !='' && $this->post('copyrightSetting') =='Requires Permission')
		{
		   $copyrightSetting = 1;
		}
		else
		{
			$copyrightSetting = 0;
		}
		if($this->post('coverPicImageId') !='')
        {
           $coverPicImageId= $this->post('coverPicImageId');
        
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Cover Picture Image Id Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('description') !='')
		{
		   $description =$this->post('description') ;
		}
		else
		{
			$description = '';
		}
		if($this->post('keyword') !='')
		{
		   $keyword = $this->post('keyword');
		}
		else
		{
			$keyword = '';
		}
		if($this->post('projectName'))
        {
           $projectName = $this->post('projectName');
        }
        else
        {
			$this->response(array('statusCode' => 404,'errorMessage' => 'Project Name field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('projectType'))
        {
           $projectType = $this->post('projectType');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Project Type field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('projectStatus')!=0)
        {
           $projectStatus = $this->post('projectStatus');
        }
        else
        {
			$projectStatus =0;
		   //$this->response(array('statusCode' => 404,'errorMessage' => 'Project Status field is Required','statusMessage' => 'Project Status Required!'), 404);
		}

		
if($this->post('socialFeatures') ==1)
	{
	   $socialFeatures = 1;

	}
	elseif($this->post('socialFeatures') !=1)
	{
		$socialFeatures = 0;

	}

	    if($this->post('thoughtProcess') !='')
		{
		   $thoughtProcess = $this->post('thoughtProcess');
		}
		else
		{
			$thoughtProcess = '';
		}
		if($this->post('videoLink'))
        {
            $url = $this->post('videoLink');
            $key = 'watch?v='; 
            if (strpos($url, $key) == TRUE) { 
                $videoLinkArr = explode("watch?v=",$url);
                $videoLink    = $videoLinkArr[1];
                     	  
            }else { 
                $videoLinkArr = explode("youtu.be/",$url);
                $videoLink    = $videoLinkArr[1];
            }
        }
        else
        {
        	$videoLink='';
        }
		
		if($this->post('projectPublish')!=0)
        {
           $projectPublish = $this->post('projectPublish');
        }
        else
        {
			$projectPublish = 0;
		}
		if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		
		if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
			$deviceId = '';
		}
		if($this->post('projectId') !='' && $this->post('CategoryName') !='' && $this->post('coverPicImageId') !='' && $this->post('projectName') !=''  && $this->post('userId') !='')
        { 
           if(isset($projectId)&& isset($userId)&& isset($category)&& isset($projectName))
           {

               	$data = $this->api_model->EditProject($projectId,$userId,$deviceId,$projectName,$projectType,$projectStatus,$projectPublish,$category,$videoLink,$coverPicImageId,$thoughtProcess,$socialFeatures,$description,$keyword,$copyrightSetting);
                if(!empty($data))
               	{
           		 	echo json_encode($data);
           		}
           }
        }
	}


public function UpdateCommentStatus_post()
	{	
		if($this->post('userId'))
		{
		  $userId = $this->post('userId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('commentId'))
		{
		  $commentId = $this->post('commentId');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Comment id field is Required','statusMessage' => 'bad request'), 404);
		}
		if($this->post('commentStatus') !='')
		{
		  $commentStatus = $this->post('commentStatus');
		}
		else
		{
		   $this->response(array('statusCode' => 404,'errorMessage' => 'Comment status field is Required','statusMessage' => 'bad request'), 404);
		}
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
         else
        {
			$deviceId = '';
		}
	    if(isset($userId) && isset($commentId) && isset($commentStatus))
	    {
	    	$data = $this->api_model->UpdateCommentStatus($userId,$commentId,$commentStatus);
	       	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		}
	}
   
	public function GetInstitutePendingProjectList_post()
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
            $deviceId = '';
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required.','statusMessage' => 'bad request'), 404);
        }
        if($this->post('category'))
        {
           $category = $this->post('category');
        }
         else
        {
			$category = '';
		  }
		if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
			$keyword = '';
		}
      	
		
	    if(isset($pageNo) && isset($pageSize)&& isset($instituteId))
	    {
	    	$data = $this->api_model->GetInstitutePendingProjectList($pageNo,$pageSize,$userId,$deviceId,$keyword,$category,$instituteId);
	    	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
	
		
	}
	public function approvePendingProject_post(){
        
        
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id is required.','statusMessage' => 'bad request'), 404);
        }
         if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Project id is required.','statusMessage' => 'bad request'), 404);
        }
        
		
		
	    if(isset($projectId) && isset($userId))
	    {
	    	$data = $this->api_model->approvePendingProject($userId,$projectId);
	    	if(!empty($data))
	    	{
			 	echo json_encode($data);
			}
		    
		}
    }
}
