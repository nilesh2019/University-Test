<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User_api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
    }
    public function UpdateIsReadNotificationFlag_post()
    {
        if($this->post('userId') && $this->post('userId')!='' && $this->post('userId')!=-1)
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId))
        {
            $data = $this->api_model->UpdateIsReadNotificationFlag($userId,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function GetBaseServerUrl_post()
    {
        $studentId = $this->post('studentId');
        if($this->post('googleId'))
        {
           $googleId = $this->post('googleId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Google id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Device id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('emaiId'))
        {
           $emailId = $this->post('emaiId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Email id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('firstName'))
        {
           $firstName = $this->post('firstName');
        }
         else
        {
          $this->response(array('statusCode' => 404,'errorMessage' => 'First name field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('lastName'))
        {
           $lastName = $this->post('lastName');
        }
         else
        {
            $lastName='.';
        }
        if($this->post('profileImageUrl'))
        {
           $profileImageUrl = $this->post('profileImageUrl');
        }
         else
        {
           $profileImageUrl = '';
        }
        if($this->post('gender'))
        {
           $gender = $this->post('gender');
        }
         else
        {
            $gender = '';
        }
          if($this->post('userType'))
        {
           $userType = $this->post('userType,');
        }
         else
        {
            $userType = '';
        }
        if(isset($googleId) && isset($emailId)&& isset($firstName))
        {
            $data = $this->api_model->GetBaseServerUrl($googleId,$emailId,$firstName,$lastName,$profileImageUrl,$gender,$deviceId,$studentId,$userType);

            //echo "<pre>";print_r($data);

            if(!empty($data))
            {
                echo json_encode($data);
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'No active user found with this student Id, Please contact your institute admin for further information. ','statusMessage' => 'No active user found with this student Id, Please contact your institute admin for further information. '), 404);
            }
        }
    }
    public function GetUserDetail_post()
    {
        $studentId = $this->post('studentId');
       /* if($studentId == '')
        {
             $this->response(array('statusCode' => 404,'errorMessage' => 'Student id field can not be blank.','statusMessage' => 'Sorry'), 404);
        }
        if($this->post('studentId'))
        {
           $studentId = $this->post('studentId');
           if($studentId == '')
           {
                $this->response(array('statusCode' => 404,'errorMessage' => 'Student id field can not be blank.','statusMessage' => 'Sorry'), 404);
           }
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Student id field is Required','statusMessage' => 'Sorry'), 404);
        }*/
       // echo($this->post('googleId'));die;
        if($this->post('googleId'))
        {
           $googleId = $this->post('googleId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Google id field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('emaiId'))
        {
           $emaiId = $this->post('emaiId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'emailId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('firstName'))
        {
           $firstName = $this->post('firstName');
        }
         else
        {
          $this->response(array('statusCode' => 404,'errorMessage' => 'First Name field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('lastName'))
        {
           $lastName = $this->post('lastName');
        }
         else
        {
            //$this->response(array('statusCode' => 404,'errorMessage' => 'Last Name field is Required','statusMessage' => 'Sorry'), 404);
            $lastName='';
        }
        if($this->post('profileImageUrl'))
        {
           $profileImageUrl = $this->post('profileImageUrl');
        }
         else
        {
           $profileImageUrl = '';
        }
        if($this->post('gender'))
        {
           $gender = $this->post('gender,');
        }
         else
        {
            $gender = '';
        }
        if($this->post('userType'))
        {
           $userType = $this->post('userType,');
        }
         else
        {
            $userType = '';
        }
        if(isset($googleId) && isset($emaiId)&& isset($firstName)&& isset($deviceId))
        {
            $data = $this->api_model->GetUserDetail($googleId,$emaiId,$firstName,$lastName,$profileImageUrl,$gender,$deviceId,$studentId,$userType);
            if(!empty($data))
            {
                echo json_encode($data);
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'No active user found with this student Id, Please contact your institute admin for further information. ','statusMessage' => 'No active user found with this student Id, Please contact your institute admin for further information. '), 404);
            }
        }
    }
    public function UserFollow_post()
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
        if($this->post('followUserId'))
        {
           $followUserId = $this->post('followUserId');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'Follow User Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('userFollowStatus')!='')
        {
           $userFollowStatus = $this->post('userFollowStatus');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'User Follow Status id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($followUserId)&&isset($userId)&&isset($userFollowStatus))
        {
            $data = $this->api_model->UserFollow($followUserId,$userFollowStatus,$userId,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function UploadProfilePic_post()
    {
        if($this->post('userId')&&$this->post('userId')!='')
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
        if(isset($_FILES['image']) && $_FILES['image']['size'] != 0)
        {
            $image = $_FILES['image']['name'];
            //$this->response(array('statusCode' => 404,'errorMessage' => $image,'statusMessage' => $image), 404);
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Image field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($image))
        {
            $data = $this->api_model->UploadProfilePic($userId,$deviceId,$image);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function GetUserInfoById_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId))
        {
            $profileCompletion = $this->api_model->userProfileMeter($userId);
            $data = $this->api_model->GetUserInfoById($userId,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function UpdateBasicInfo_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('firstName'))
        {
           $firstName = $this->post('firstName');
        }
         else
        {
          $this->response(array('statusCode' => 404,'errorMessage' => 'First Name field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('lastName'))
        {
           $lastName = $this->post('lastName');
        }
         else
        {
          $this->response(array('statusCode' => 404,'errorMessage' => 'Last Name field is Required','statusMessage' => 'bad request'), 404);
        }
       /* if($this->post('lastName'))
        {
           $lastName = $this->post('lastName');
        }
         else
        {
            //$this->response(array('statusCode' => 404,'errorMessage' => 'Last Name field is Required','statusMessage' => 'Sorry'), 404);
            $lastName='';
        }*/
        if($this->post('designation'))
        {
           $designation = $this->post('designation');
        }
         else
        {
           $designation = '';
        }
        if($this->post('address'))
        {
           $address = $this->post('address');
        }
         else
        {
            $address = '';
        }
        if($this->post('birthday'))
        {
           $birthday = $this->post('birthday');
        }
         else
        {
            $birthday = '';
        }
        if($this->post('maritalStatus'))
        {
           $maritalStatus = $this->post('maritalStatus');
        }
         else
        {
            $maritalStatus = "S";
        }
        if($this->post('contactNo'))
        {
           $contactNo = $this->post('contactNo');
        }
        else
        {
            $contactNo = '';
        }
        if($this->post('aboutMe'))
        {
           $aboutMe = $this->post('aboutMe');
        }
        else
        {
            $aboutMe = '';
        }
        if($this->post('country'))
        {
           $country = $this->post('country');
        }
        else
        {
            $country = '';
        }
        if($this->post('city'))
        {
           $city = $this->post('city');
        }
        else
        {
            $city = '';
        }
        if($this->post('websiteUrl'))
        {
           $websiteUrl = $this->post('websiteUrl');
        }
        else
        {
            $websiteUrl = '';
        }
        if($this->post('age'))
        {
           $age = $this->post('age');
        }
        else
        {
            $age = '';
        }
        if(isset($userId) && isset($firstName)&& isset($deviceId))
        {
            if($birthday)
            {
                $arr = explode('-',$birthday);
                $time = strtotime($arr[0].'-'.$arr[1].'-'.$arr[2]);
                $newformat = date('Y-m-d',$time);
            }
            else
            {
                $newformat = '';
            }
            $arr = array('firstName'=>$firstName,'lastName'=>$lastName,'webSiteURL'=>$websiteUrl,'city'=>$city,'country'=>$country,'about_me'=>$aboutMe,'dob'=>$newformat,'address'=>$address,'profession'=>$designation,'contactNo'=>$contactNo,"age"=>$age,'marital_status'=>$maritalStatus);
            $data = $this->api_model->UpdateBasicInfo($userId,$arr);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function GetUserNotification_post()
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
        if($this->post('userId') && $this->post('userId')!='' && $this->post('userId')!=-1)
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId))
        {
            $data = $this->api_model->GetUserNotification($userId,$deviceId,$pageNo,$pageSize);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function UserSignOut_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId))
        {
            $data = $this->api_model->UserSignOut($userId,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function SaveProjectRating_post()
    {
        if($this->post('projectId') && $this->post('projectId')!='')
        {
           $projectId = $this->post('projectId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'projectId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('rating'))
        {
           $rating = $this->post('rating');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Rating field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId)&& isset($projectId)&& isset($rating))
        {
            $data = $this->api_model->SaveProjectRating($userId,$deviceId,$projectId,$rating);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddExperience_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('companyName') && $this->post('companyName')!='')
        {
           $companyName = $this->post('companyName');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Company Name field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('position') && $this->post('position')!='')
        {
           $position = $this->post('position');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'Position field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('fromDate')&& $this->post('fromDate')!='')
        {
           $fromDate = $this->post('fromDate');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'From Date field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('toDate')&& $this->post('toDate')!='')
        {
           $toDate = $this->post('toDate');
        }
        elseif($this->post('currentEmployer')!=1)
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'To Date field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('address') && $this->post('address')!='')
        {
           $address = $this->post('address');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'Address field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('currentEmployer') && $this->post('currentEmployer')!=''||$this->post('currentEmployer')=='0')
        {
           $currentEmployer = $this->post('currentEmployer');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'Current Employer field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('experienceId')&& $this->post('experienceId')!='')
        {
           $experienceId = $this->post('experienceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'ExperienceId Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('workDescription'))
        {
           $workDescription = $this->post('workDescription');
        }
        else
        {
            $workDescription='';
        }
        if(isset($userId) && isset($deviceId)&& isset($companyName))
        {
            $data = $this->api_model->AddExperience($userId,$deviceId,$companyName,$position,$fromDate,$toDate,$address,$currentEmployer,$experienceId,$workDescription);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddEducation_post()
        {
            if($this->post('userId') && $this->post('userId')!='')
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
                $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
            }
            if($this->post('educationType'))
            {
               $educationType = $this->post('educationType');
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'Education Type field is Required','statusMessage' => 'bad request'), 404);
            }
            if($this->post('qualification') && $this->post('qualification')!='')
            {
               $qualification = $this->post('qualification');
            }
            else
            {
                $qualification = "";
            }
            if($this->post('university') && $this->post('university')!='')
            {
               $university = $this->post('university');
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'Board/University field is Required','statusMessage' => 'bad request'), 404);
            }
            if($this->post('stream') && $this->post('stream')!='')
            {
               $stream = $this->post('stream');
            }
            else
            {
               $stream = "";
            }
            if($this->post('passOutYear')&& $this->post('passOutYear')!='')
            {
               $passOutYear = $this->post('passOutYear');
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'Pass Out Year field is Required','statusMessage' => 'bad request'), 404);
            }
            if($this->post('schoolCollege') && $this->post('schoolCollege')!='')
            {
               $schoolCollege  = $this->post('schoolCollege');
            }
            else
            {
               $schoolCollege = "";
            }
            if($this->post('educationId')&& $this->post('educationId')!='')
            {
               $educationId = $this->post('educationId');
            }
            else
            {
                $this->response(array('statusCode' => 404,'errorMessage' => 'Education Id field is Required','statusMessage' => 'bad request'), 404);
            }
            if(isset($userId) && isset($deviceId)&& isset($educationType) && isset($university))
            {
                $data = $this->api_model->AddEducation($userId,$deviceId,$educationType,$university,$qualification,$stream,$passOutYear,$schoolCollege,$educationId);
                if(!empty($data))
                {
                    echo json_encode($data);
                }
            }
        }
    public function DeleteExperience_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('experienceId')&&$this->post('experienceId')!='')
        {
           $experienceId = $this->post('experienceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Experience Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId)&& isset($experienceId))
        {
            $data = $this->api_model->DeleteExperience($userId,$deviceId,$experienceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function DeleteEducation_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('educationId')&&$this->post('educationId')!='')
        {
           $educationId = $this->post('educationId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Education Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId)&& isset($educationId))
        {
            $data = $this->api_model->DeleteEducation($userId,$deviceId,$educationId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function SaveAppFeedback_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
        {
           $userId = $this->post('userId');
        }
        else
        {
           $userId = "";
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('email')&&$this->post('email')!='')
        {
           $email = $this->post('email');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'email field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('feedback'))
        {
           $feedback = $this->post('feedback');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'feedback field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('name'))
        {
           $name = $this->post('name');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'name field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($deviceId)&& isset($email))
        {
            $data = $this->api_model->SaveAppFeedback($userId,$deviceId,$email,$name,$feedback);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddSkill_post()
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
        if($this->post('knowledgeRate'))
        {
           $knowledgeRate = $this->post('knowledgeRate');
        }
         else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'KnowledgeRate field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('skillId')&&$this->post('skillId')!=0)
        {
           $skillId = $this->post('skillId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'skillId field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('skillName'))
        {
           $skillName = $this->post('skillName');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'skillName field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($knowledgeRate)&&isset($skillName)&&isset($userId))
        {
            $data = $this->api_model->AddSkill($knowledgeRate,$skillName,$userId,$skillId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function DeleteSkill_post()
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
         if($this->post('skillId')&&$this->post('skillId')!=0)
        {
           $skillId = $this->post('skillId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'skillId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($skillId)&&isset($userId))
        {
            $data = $this->api_model->DeleteSkill($skillId,$userId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddLink_post()
    {
        if($this->post('userId') && $this->post('userId')!='')
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('link')&&$this->post('link')!='')
        {
           $link = $this->post('link');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Link field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('linkType')&&$this->post('linkType')!='')
        {
           $linkType = $this->post('linkType');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'linkType Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId) && isset($deviceId)&& isset($linkType)&& isset($link))
        {
            $data = $this->api_model->AddLink($userId,$deviceId,$linkType,$link);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function GetSearchResult_post(){
        // print_r($this->post());die;
        // if(empty($this->post()){
        //     $this->response(array('statusCode' => 400,'errorMessage' => 'Data not found','statusMessage' => 'Sorry'), 400);
        // }
        if($this->post('keyword') && $this->post('keyword')!=''){
             $keyword = $this->post('keyword');
        }else{
            $this->response(array('statusCode' => 400,'errorMessage' => 'keyword field is Required','statusMessage' => 'bad request'), 400);
        }
        if($this->post('deviceId') && $this->post('deviceId')!=''){
            $deviceId = $this->post('deviceId');
        }else{
            $this->response(array('statusCode' => 400,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 400);
        }
        if($this->post('userId') && $this->post('userId')!=''){
             $userId = $this->post('userId');
        }else{
            $this->response(array('statusCode' => 400,'errorMessage' => 'userId field is Required','statusMessage' => 'bad request'), 400);
        }
        if(isset($keyword) && isset($deviceId) && isset($userId))
        {
            $parameters = array('keyword' => $keyword,
                                'deviceId' => $deviceId,
                                'userId' => $userId );
            $job = $this->api_model->getSearchResultForJob($parameters);
            for ($i=0; $i < count($job); $i++) {
                $job[$i]['subtitle']='';
                $job[$i]['imageUrl']=file_upload_base_url()."companyLogos/".$job[$i]['imageUrl'];
                $job[$i]['resultType']=1;
            }
            $event = $this->api_model->getSearchResultForEvent($parameters);
            for ($i=0; $i < count($event); $i++) {
                $event[$i]['subtitle']='';
                $event[$i]['imageUrl']=file_upload_base_url()."event/banner/thumbs/".$event[$i]['imageUrl'];
                $event[$i]['resultType']=2;
            }
            $project = $this->api_model->getSearchResultForProject($parameters);
            for ($i=0; $i < count($project); $i++) {
                $project[$i]['subtitle']='';
                $project[$i]['imageUrl']=file_upload_base_url()."project/thumbs/".$project[$i]['imageUrl'];
                $project[$i]['resultType']=3;
            }
            $competition = $this->api_model->getSearchResultForCompetition($parameters);
            for ($i=0; $i < count($competition); $i++) {
                $competition[$i]['subtitle']='';
                $competition[$i]['imageUrl']=file_upload_base_url()."competition/banner/".$competition[$i]['imageUrl'];
                $competition[$i]['resultType']=4;
            }
            $pepole = $this->api_model->getSearchResultForPepole($parameters);
            for ($i=0; $i < count($pepole); $i++) {
                $pepole[$i]['subtitle']='';
                $pepole[$i]['imageUrl']=file_upload_base_url()."users/thumbs/".$pepole[$i]['imageUrl'];
                $pepole[$i]['resultType']=5;
            }
            $institute = $this->api_model->getSearchResultForInstitute($parameters);
            for ($i=0; $i < count($institute); $i++) {
                $institute[$i]['subtitle']='';
                $institute[$i]['imageUrl']=file_upload_base_url()."institute/coverImage/".$institute[$i]['imageUrl'];
                $institute[$i]['resultType']=6;
            }
            $blog = $this->api_model->getSearchResultForBlog($parameters);
            for ($i=0; $i < count($blog); $i++) {
                $blog[$i]['subtitle']='';
                $blog[$i]['imageUrl']=file_upload_base_url()."blog/thumb/".$blog[$i]['imageUrl'];
                $blog[$i]['resultType']=7;
            }
            $data['result'] = array_merge($job,$event,$project,$competition,$pepole,$institute,$blog);
            if(!empty($data))
            {
                //echo "Hi";die;
                $data['statusCode']=200;
                $data['errorMessage']='';
                $data['statusMessage']='Done';
                echo json_encode($data);
            }else{
                $this->response(array('statusCode' => 204,'errorMessage' => 'No content','statusMessage' => 'No content'), 204);
            }
        }
    }
    public function AddAward_post()
    {
        //print_r($this->post());die;
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
        if($this->post('award'))
        {
           $award = $this->post('award');
        }
         else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Award field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('awardId'))
        {
           $awardId = $this->post('awardId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Award id is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('awardPrizeNomination'))
        {
           $awardPrizeNomination = $this->post('awardPrizeNomination');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Award Prize Nomination field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('date'))
        {
           $date = $this->post('date');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Date field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($award)&&isset($awardPrizeNomination)&&isset($userId)&&isset($date))
        {
            $data = $this->api_model->AddAward($award,$awardPrizeNomination,$userId,$awardId,$date);
            /*$data['statusCode']=200;
            $data['errorMessage']='';
            $data['statusMessage']='Done';*/
            if(!empty($data))
            {
                    echo json_encode($data);
            }
        }
    }
    public function DeleteAward_post()
    {
        //print_r($this->post());die;
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
         if($this->post('awardId') && $this->post('awardId') > 0)
        {
           $awardId = $this->post('awardId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Award id is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($awardId) &&isset($userId))
        {
            $data = $this->api_model->DeleteAward($userId,$awardId);
            /*$data['statusCode']=200;
            $data['errorMessage']='';
            $data['statusMessage']='Done';*/
            if(!empty($data))
            {
                    echo json_encode($data);
            }
        }
    }
    public function AddWorkshop_post()
    {
        //print_r($this->post());die;
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
        if($this->post('workshopName'))
        {
           $workshopName = $this->post('workshopName');
        }
         else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Workshop Name field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('workshopId'))
        {
           $workshopId = $this->post('workshopId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Workshop id is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('workshopBy'))
        {
           $workshopBy = $this->post('workshopBy');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Workshop By field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('workshopYear'))
        {
           $workshopYear = $this->post('workshopYear');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Year field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($workshopName)&&isset($workshopBy)&&isset($userId)&&isset($workshopYear))
        {
            $data = $this->api_model->AddWorkshop($workshopName,$workshopBy,$userId,$workshopId,$workshopYear);
            /*$data['statusCode']=200;
            $data['errorMessage']='';
            $data['statusMessage']='Done';*/
            if(!empty($data))
            {
                    echo json_encode($data);
            }
        }
    }
    public function DeleteWrokshop_post()
    {
        //print_r($this->post());die;
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
         if($this->post('workshopId') && $this->post('workshopId') > 0)
        {
           $workshopId = $this->post('workshopId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Workshop id is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($workshopId) &&isset($userId))
        {
            $data = $this->api_model->DeleteWorkshop($userId,$workshopId);
            /*$data['statusCode']=200;
            $data['errorMessage']='';
            $data['statusMessage']='Done';*/
            if(!empty($data))
            {
                    echo json_encode($data);
            }
        }
    }
    public function GetFollowersList_post()
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
            $deviceId ='';
        }
        if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
            $keyword = '';
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
    
            $data = $this->api_model->GetFollowersList($userId,$pageNo,$pageSize,$keyword,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function GetFollowingsList_post()
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
            $deviceId ='';
        }
        if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
            $keyword = '';
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
    
            $data = $this->api_model->GetFollowingsList($userId,$pageNo,$pageSize,$keyword,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function GetProjectLikeList_post()
    {           
        if($this->post('pageNo'))
        {
           $pageNo = $this->post('pageNo');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Page No field is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
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
            $deviceId ='';
        }
        if($this->post('keyword'))
        {
           $keyword = $this->post('keyword');
        }
         else
        {
            $keyword = '';
        }
        if($this->post('projectId') && $this->post('projectId')!='')
        {
           $projectId = $this->post('projectId');
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'User Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($projectId) && isset($pageSize)&& isset($pageNo))
        {
    
            $data = $this->api_model->GetProjectLikeList($projectId,$pageNo,$pageSize,$keyword,$deviceId,$userId );
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AcceptTermsAndConditions_post()
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
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId))
        {
            $data = $this->api_model->AcceptTermsAndConditions($userId,$deviceId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function SaveUserType_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'deviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('userType') !='')
        {
           $userType = $this->post('userType');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User type is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('firstName') !='')
        {
           $firstName = $this->post('firstName');
        }
        else
        {
            $firstName = "";
        }
        if($this->post('lastName') !='')
        {
           $lastName = $this->post('lastName');
        }
        else
        {
            $lastName = "";
        }
        if($this->post('contactNo') !='')
        {
           $contactNo = $this->post('contactNo');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Contact No is required','statusMessage' => 'bad request'), 404);
        }

        if($this->post('city') !='')
        {
           $city = $this->post('city');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'City is required','statusMessage' => 'bad request'), 404);
        }

        if(isset($userId)&&isset($deviceId))
        {
            $data = $this->api_model->SaveUserType($userId,$deviceId,$userType,$firstName,$lastName,$contactNo,$city);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function GetAssignmentList_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId))
        {
            $data = $this->api_model->GetAssignmentList($userId,$deviceId,$instituteId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function GetAssignmentDetail_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('assignmentId'))
        {
           $assignmentId = $this->post('assignmentId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId)&&($assignmentId))
        {
            $data = $this->api_model->GetAssignmentDetail($userId,$assignmentId,$deviceId,$instituteId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function SubmitAssignment_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('projectId'))
        {
           $projectId = $this->post('projectId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Project id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('assignmentId'))
        {
           $assignmentId = $this->post('assignmentId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('comment') !='')
        {
           $comment = $this->post('comment');
        }
        else
        {
            $comment='';
        }
        if(isset($userId)&&isset($projectId)&&isset($assignmentId)&&isset($deviceId)&&($instituteId))
        {
            $data = $this->api_model->SubmitAssignment($userId,$deviceId,$instituteId,$projectId,$assignmentId,$comment);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function MyInstitutePeopleList_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId))
        {
            $data = $this->api_model->MyInstitutePeopleList($userId,$deviceId,$instituteId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function AddNewAssignment_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('assignmentName') !='')
        {
           $assignmentName = $this->post('assignmentName');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment name is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('description') !='')
        {
           $description = $this->post('description');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment description is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('startDate') !='')
        {
           $startDate = $this->post('startDate');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment start date is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('endDate') !='')
        {
           $endDate = $this->post('endDate');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment end date is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('tools') !='')
        {
           $tools = $this->post('tools');
        }
        else
        {
            $tools='';
        }
        if($this->post('features') !='')
        {
           $features = $this->post('features');
        }
        else
        {
            $features='';
        }
        if($this->post('peopleList'))
        {
           $peopleList = $this->post('peopleList');
        
        }
        else
        {
           $this->response(array('statusCode' => 404,'errorMessage' => 'People list is required.','statusMessage' => 'bad request'), 404);
        }
        if($this->post('assignmentId'))
        {
           $assignmentId = $this->post('assignmentId');
        
        }
        else
        {
           $assignmentId=0;
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId))
        {
            $data = $this->api_model->AddNewAssignment($userId,$deviceId,$instituteId,$assignmentName,$description,$startDate,$endDate,$tools,$features,$peopleList,$assignmentId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function GetSubmitedAssignmentList_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId))
        {
            $data = $this->api_model->GetSubmitedAssignmentList($userId,$deviceId,$instituteId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function DeleteAssignment_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('assignmentId') !='')
        {
           $assignmentId = $this->post('assignmentId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Assignment id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId)&&($assignmentId))
        {
            $data = $this->api_model->DeleteAssignment($userId,$deviceId,$instituteId,$assignmentId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function AcceptAssignment_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('comment') !='')
        {
           $comment = $this->post('comment');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Acceptance comment is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('projectId') !='')
        {
           $projectId = $this->post('projectId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Project id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId)&&($comment)&&($projectId))
        {
            $data = $this->api_model->AcceptAssignment($userId,$deviceId,$instituteId,$comment,$projectId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }

    public function NeedMoreWorkAssignment_post()
    {
        if($this->post('userId'))
        {
           $userId = $this->post('userId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'User id field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('deviceId'))
        {
           $deviceId = $this->post('deviceId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'DeviceId field is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('instituteId') !='')
        {
           $instituteId = $this->post('instituteId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Institute id is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('comment') !='')
        {
           $comment = $this->post('comment');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Acceptance comment is required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('projectId') !='')
        {
           $projectId = $this->post('projectId');
        }
        else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Project id is required','statusMessage' => 'bad request'), 404);
        }
        if(isset($userId)&&isset($deviceId)&&($instituteId)&&($comment)&&($projectId))
        {
            $data = $this->api_model->NeedMoreWorkAssignment($userId,$deviceId,$instituteId,$comment,$projectId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddPreferredLocation_post()
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
        if($this->post('stateId'))
        {
           $state_id = $this->post('stateId');
        }
         else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'State field is Required','statusMessage' => 'bad request'), 404);
        }
         if($this->post('cityId')&&$this->post('cityId')!=0)
        {
           $city_id  = $this->post('cityId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'City field is Required','statusMessage' => 'bad request'), 404);
        }
        
        if(isset($city_id)&&isset($state_id)&&isset($userId))
        {
            $data = $this->api_model->AddPreferredLocation($state_id,$city_id,$userId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function DeletePreferredLocation_post()
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
         if($this->post('locationId')&&$this->post('locationId')!=0)
        {
           $locationId = $this->post('locationId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Location Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($locationId)&&isset($userId))
        {
            $data = $this->api_model->DeletePreferredLocation($locationId,$userId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function AddLanguage_post()
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
        if($this->post('language'))
        {
           $language  = $this->post('language');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Language Name is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('level'))
        {
           $level = $this->post('level');
        }
         else
        {
            $this->response(array('statusCode' => 404,'errorMessage' => 'Language Level is Required','statusMessage' => 'bad request'), 404);
        }
        if($this->post('isRead'))
        {
           $isRead = $this->post('isRead');
        }
         else
        {
            $isRead = 0;
        }
        if($this->post('isWrite'))
        {
           $isWrite = $this->post('isWrite');
        }
         else
        {
            $isWrite = 0;
        }
        if($this->post('isSpeak'))
        {
           $isSpeak = $this->post('isSpeak');
        }
         else
        {
            $isSpeak = 0;
        }
        if(isset($language)&&isset($level)&&isset($isRead)&&isset($isWrite)&&isset($isSpeak)&&isset($userId))
        {
            $data = $this->api_model->AddLanguage($language,$level,$isRead,$isWrite,$isSpeak,$userId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function DeleteLanguage_post()
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
         if($this->post('languageId')&&$this->post('languageId')!=0)
        {
           $languageId = $this->post('languageId');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Language Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($languageId)&&isset($userId))
        {
            $data = $this->api_model->DeleteLanguage($languageId,$userId);
            if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
    public function SharePortfolio_post()
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
        if($this->post('email'))
        {
           $emailId = $this->post('email');
        }
         else
        {
         $this->response(array('statusCode' => 404,'errorMessage' => 'Email Id field is Required','statusMessage' => 'bad request'), 404);
        }
        if(isset($emailId)&&isset($userId))
        {
           $data = $this->api_model->SharePortfolio($userId,$emailId);
           if(!empty($data))
            {
                echo json_encode($data);
            }
        }
    }
}