<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Home_api extends REST_Controller{
	public function __construct()	{
		parent::__construct();
		$this->load->model('modelbasic');
	}
    public function getTrendingProjects_post(){
        if($this->post('userId') == ''){
            $userId = '';
        }else{
            $userId = $this->post('userId');
        }
        $trendingProjects=$this->modelbasic->getValues('project_master','project_master.id as projectId,project_master.projectName,project_master.userId as projectUserId,user_project_image.image_thumb as thumbImage,project_master.videoLink as youtubeLink,project_master.view_cnt as viewCount,project_master.like_cnt as likeCount,category_master.categoryName,users.firstName,users.lastName',array('user_project_image.cover_pic'=>1,'project_master.featured'=>1,'project_master.status'=>1),'result_array',array(array("user_project_image","user_project_image.project_id=project_master.id"),array("category_master","category_master.id=project_master.categoryId"),array("users","users.id=project_master.userId")),'project_master.id',array('project_master.featured_date','desc'),10);
        $projectData=array();
        if(!empty($trendingProjects)){
        	foreach($trendingProjects as $singleProject){
        		$singleProject['projectId'] = (int)$singleProject['projectId'];
        		$singleProject['projectUserId'] = (int)$singleProject['projectUserId'];
        		$singleProject['thumbImage'] = file_upload_base_url().'project/thumbs/'.$singleProject['thumbImage'];
        		$singleProject['imageCount'] = $this->modelbasic->count_all_only('user_project_image',array('project_id'=>$singleProject['projectId']));
        		$singleProject['viewCount'] = (int)$singleProject['viewCount'];
        		$singleProject['likeCount'] = (int)$singleProject['likeCount'];
        		$projectData[]=$singleProject;
        	}
        }
        $message = array("statusMessage"=>'Done','statusCode'=>200,'errorMessage'=>'','projectData'=>$projectData);
        echo json_encode($message);
    }
    public function getTrendingStudents_post(){
        if($this->post('userId') == ''){
            $userId = '';
        }else{
            $userId = $this->post('userId');
        }
        $trendingStudents=$this->modelbasic->getValues('users','region_list.region_name,users.id as userId,users.instituteId,institute_master.instituteName,users.firstname,users.lastname,users.city,users.country,users.profession,users.profileimage,COUNT(DISTINCT project_master.id) AS project_count',array('project_master.status'=>1,'users.status'=>1,'users.admin_level'=>0,'users.instituteId !='=>1,'users.instituteId !='=>0),'result_array',array(array("institute_master","institute_master.id=users.instituteId"),array("region_list","region_list.id=institute_master.region"),array("project_master","project_master.userId=users.id")),'users.id',array('project_count','DESC'),10);
        $studentData=array();
        if(!empty($trendingStudents)){
        	foreach($trendingStudents as $singleStudent){
        		$singleStudent['userId'] = (int)$singleStudent['userId'];
        		$singleStudent['instituteId'] = (int)$singleStudent['instituteId'];
        		$singleStudent['project_count'] = (int)$singleStudent['project_count'];
        		$singleStudent['profileimage'] = file_upload_base_url().'placement/profile_image/'.$singleStudent['profileimage'];
        		$studentData[]=$singleStudent;
        	}
        }
        $message = array("statusMessage"=>'Done','statusCode'=>200,'errorMessage'=>'','studentData'=>$studentData);
        echo json_encode($message);
    }
    public function getTrendingJobs_post(){
        if($this->post('userId') == ''){
            $userId = '';
        }else{
            $userId = $this->post('userId');
        }
        $trendingJobs=$this->modelbasic->getValues('jobs','jobs.id as jobId,jobs.title,jobs.companyLogo,jobs.companyName,jobs.no_of_position',array('jobs.featured'=>1,'jobs.status'=>1),'result_array','','',array('featured_date','DESC'),10);
        $jobData=array();
        if(!empty($trendingJobs)){
        	foreach($trendingJobs as $singleJob){
        		$singleJob['jobId'] = (int)$singleJob['jobId'];
        		$singleJob['no_of_position'] = (int)$singleJob['no_of_position'];
        		$singleJob['companyLogo'] = file_upload_base_url().'companyLogos/'.$singleJob['companyLogo'];
        		$jobData[]=$singleJob;
        	}
        }
        $message = array("statusMessage"=>'Done','statusCode'=>200,'errorMessage'=>'','jobData'=>$jobData);
        echo json_encode($message);
    }
    public function getTrendingInstitutes_post(){
        if($this->post('userId') == ''){
            $userId = '';
        }else{
            $userId = $this->post('userId');
        }
        $trendingInstitutes=$this->modelbasic->getValues('users','region_list.region_name,count(*) AS projCnt,institute_master.instituteName,institute_master.coverImage,institute_master.PageName,institute_master.contactNo',array('project_master.status'=>1,'users.status'=>1,'institute_master.status'=>1,'users.instituteId !='=>1,'users.instituteId !='=>0),'result_array',array(array("institute_master","institute_master.id=users.instituteId"),array("region_list","region_list.id=institute_master.region"),array("project_master","project_master.userId=users.id")),'institute_master.id',array('projCnt','DESC'),10);
        $instituteData=array();
        if(!empty($trendingInstitutes)){
        	foreach($trendingInstitutes as $singleInstitute){
        		$singleInstitute['cnt'] = (int)$singleInstitute['cnt'];
        		$singleInstitute['coverImage'] = base_url().'assets/images/Lakme_Logo_200.png';
        		$instituteData[]=$singleInstitute;
        	}
        }
        $message = array("statusMessage"=>'Done','statusCode'=>200,'errorMessage'=>'','instituteData'=>$instituteData);
        echo json_encode($message);
    }
    public function getTrendingPlacements_post(){
        if($this->post('userId') == ''){
            $userId = '';
        }else{
            $userId = $this->post('userId');
        }
        $trendingPlacements=$this->modelbasic->getValues('placement','student_name,company,position,profile_image',array('status'=>1,'featured'=>1),'result_array','','',array('featured_date','DESC'),10);
        $placementData=array();
        if(!empty($trendingPlacements)){
        	foreach($trendingPlacements as $singlePlacement){
        		$singlePlacement['profile_image'] = file_upload_base_url().'placement/profile_image/'.$singlePlacement['profile_image'];
        		$placementData[]=$singlePlacement;
        	}
        }
        $message = array("statusMessage"=>'Done','statusCode'=>200,'errorMessage'=>'','placementData'=>$placementData);
        echo json_encode($message);
    }    
    
    
}