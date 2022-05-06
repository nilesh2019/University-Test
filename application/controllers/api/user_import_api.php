<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User_import_api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_basic');
    }

    function import_user_post()
    {

        //print_r($this->post());die;

        $validClientId='78b18083f68552d18777c9258bf23762';
        $validSecretKey='264c52176aa143b0a4c3073c5556e0c7';
        if($this->post('api_client_id'))
        {
           $clientId = $this->post('api_client_id');
           if($clientId != $validClientId)
            {
                $this->response(array('statusCode' => 401,'errorMessage' => 'Invalid API client ID','statusMessage' => ''), 200);
            }
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Client Id is required','statusMessage' => ''), 200);
        }

        if($this->post('api_secret_key'))
        {
            $secret_key = $this->post('api_secret_key');
            if($secret_key != $validSecretKey)
            {
                $this->response(array('statusCode' => 401,'errorMessage' => 'Invalid API secret key','statusMessage' => ''), 200);
            }
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Secret key is required','statusMessage' => ''), 200);
        }

        /*if($this->post('institute_name'))
        {
           $instituteName = $this->post('institute_name');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Institute name is required','statusMessage' => ''), 200);
        }*/

        if($this->post('sap_center_code'))
        {
           $sap_center_code = $this->post('sap_center_code');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'SAP center code is required','statusMessage' => ''), 200);
        }

        if($this->post('brand_id'))
        {
           $center_id = $this->post('brand_id');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Brand id is required','statusMessage' => ''), 200);
        }

        if($this->post('first_name'))
        {
           $firstName = $this->post('first_name');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'First name is required','statusMessage' => ''), 200);
        }

        if($this->post('last_name'))
        {
           $lastName = $this->post('last_name');
        }
        else
        {
            $lastName='.';
        }

        if($this->post('student_id'))
        {
           $studentId = $this->post('student_id');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Student ID is required','statusMessage' => ''), 200);
        }

        if($this->post('course_id'))
        {
           $courseId = $this->post('course_id');
        }
         else
        {
            $courseId='';
        }

        if($this->post('course_name'))
        {
           $courseName = $this->post('course_name');
        }
         else
        {
            $courseName='';
        }

        if($this->post('course_start_date'))
        {
           $courseStartDate = $this->post('course_start_date');
        }
        else
        {
            $courseStartDat=date('Y-m-d H:i:s');
        }

        if($this->post('course_end_date'))
        {
           $courseEndDate = $this->post('course_end_date');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Course end date is required','statusMessage' => ''), 200);
        }
        if($this->post('email_id'))
        {
           $email = $this->post('email_id');
        }
        else
        {
            $email ="";
        }
        if($this->post('contact_no'))
        {
           $contact_no = $this->post('contact_no');
        }
        else
        {
            $contact_no = "";
        }
        if($this->post('centre_id'))
        {
           $institute_id = $this->post('centre_id');
        }
        else
        {
            $institute_id = "";
        }
        /*if($this->post('payment_status') == 1)
        {*/
           $paymentStatus = 1;
        /*}
        else
        {
            $paymentStatus = 0;
        }*/

       // print_r($this->post());die;
       //

        $logDetailsString = $firstName.','.$lastName.',(Email Id :'.$email.'),(Contact No :'.$contact_no.'), (SAP center Code :'.$sap_center_code.'), (Student ID: '.$studentId.'), (Course ID:'.$courseId.'),(Course Name: '.$courseName.'), ( Course Start Date'.$courseStartDate.'),(Course End Date: '.$courseEndDate.'), (CenterId: '.$center_id.'), (InstId: '.$institute_id.')';

        $logSuccessFileName = "Success_".date('Y-m-d').'_12'.date('A').'.log';
        $logErrorFileName = "Error_".date('Y-m-d').'_12'.date('A').'.log';

        //$logSuccessFileName = "Success.log";
        //$logErrorFileName = "Error.log";

        $maac = $this->load->database('maac_db', TRUE);
        $lakme = $this->load->database('lakme_db', TRUE);

        if($center_id==1)
        {
            $get_instituteId = $this->db->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if($center_id==2)
        {
            $get_instituteId = $maac->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if($center_id==3)
        {
            $get_instituteId = $lakme->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if(!empty($get_instituteId))
        {
            $instituteId = $get_instituteId['id'];
            if($paymentStatus == 0)
            {
                $paymentStatus = 2;
                $course_start_date = date('Y-m-d H:i:s');
                $course_end_date ='2018-02-28 23:59:59';
            }
            elseif($paymentStatus == 1)
            {
                $paymentStatus = 3;
                $course_start_date = date('Y-m-d H:i:s',strtotime($courseStartDate));
                $course_end_date = date('Y-m-d H:i:s', strtotime($courseEndDate.' +90 days'));
            }

            $userTableArray=array('instituteId'=>$instituteId,'firstName'=>$firstName,'lastName'=>$lastName,'contact_email'=>$email,'contactNo'=>$contact_no,'courseId'=>$courseId,'courseName'=>$courseName,'studentId'=>$studentId,'status'=>1,'paymentStatus'=>$paymentStatus,'registration_date'=>date('Y-m-d H:i:s'),'centerId'=>$center_id);

            $checkStudentPresent=$this->model_basic->getAllData('institute_csv_users','id,centerId',array('instituteId'=>$instituteId,'studentId'=>$studentId));

            $checkStudentPresentInMaac=$maac->select('id,centerId')->from('institute_csv_users')->where(array('instituteId'=>$instituteId,'studentId'=>$studentId))->get()->result_array();

            $checkStudentPresentInLakme=$lakme->select('id,centerId')->from('institute_csv_users')->where(array('instituteId'=>$instituteId,'studentId'=>$studentId))->get()->result_array();

            if(empty($checkStudentPresent))
            {
                $userId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
                $maac->insert('institute_csv_users',$userTableArray);
                $userIdMaac= $maac->insert_id();

                $lakme->insert('institute_csv_users',$userTableArray);
                $userIdLakme= $lakme->insert_id();

                $student_membershipData = array('csvuserId'=>$userId,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);

                $student_membershipDataMaac = array('csvuserId'=>$userIdMaac,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserIdMaac=$maac->insert('student_membership',$student_membershipDataMaac);

                $student_membershipDataLakme = array('csvuserId'=>$userIdLakme,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserIdLakme=$lakme->insert('student_membership',$student_membershipDataLakme);

                $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                /*
                * Create Success Log file
                */
                $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                $curDate  = date('m_d_Y_h:i:s_a');
                $sfh = fopen($successLogFile, 'a') or die("can't open file");
                $logData = $curDate.": ".$logDetailsString.", (User_id:".$userId.") User data imported successfully\n";
                fwrite($sfh, $logData);
                fclose($sfh);


                $this->response($status,200);

            }
            else
            {
                if($checkStudentPresent[0]['centerId'] == 1)
                {
                    $checkCourseEndDate = $this->db->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresent[0]['id'])->get()->row_array();
                    if(!empty($checkCourseEndDate))
                    {
                        $student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                            $memberuserId=$this->model_basic->_updateWhere('student_membership',array('csvuserId'=>$checkStudentPresent[0]['id']),$student_membershipData);
                            $this->model_basic->_updateWhere('institute_csv_users',array('id'=>$checkStudentPresent[0]['id']),array('paymentStatus'=>$paymentStatus));
                            $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "User data updated successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresent[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status,200);

                        

                    }
                    else
                    {
                        $student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                        $memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);

                        $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                        /*
                            * Create Success Log file
                        */
                        $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                        $curDate  = date('m_d_Y_h:i:s_a');
                        $sfh = fopen($successLogFile, 'a') or die("can't open file");
                        $logData = $curDate.": (User_id: ".$checkStudentPresent[0]['id']."),".$logDetailsString." User data imported successfully\n";
                        fwrite($sfh, $logData);
                        fclose($sfh);

                        $this->response($status);

                    }
                }
                else if($checkStudentPresent[0]['centerId'] == 2)
                {
                    $checkCourseEndDateInMaac = $maac->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresentInMaac[0]['id'])->get()->row_array();
                   
                    if(!empty($checkCourseEndDateInMaac))
                    {
                        
                            $student_membershipDataMaac = array('csvuserId'=>$checkStudentPresentInMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $maac->where('csvuserId',$checkStudentPresentInMaac[0]['id']);
                            $maac->update('student_membership',$student_membershipDataMaac);

                            $maac->where('id',$checkStudentPresentInMaac[0]['id']);
                            $maac->update('institute_csv_users',array('paymentStatus'=>$paymentStatus));

                            $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "User data updated successfully" );


                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status,200);

                    }
                    else
                    {
                        if(empty($checkStudentPresentInMaac[0]['id'])){
                            $maac->insert('institute_csv_users',$userTableArray);
                            $userIdMaac= $maac->insert_id();
                            $student_membershipDataMaac = array('csvuserId'=>$userIdMaac,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $maac->insert('student_membership',$student_membershipDataMaac);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);

                        }else{
                            $student_membershipDataMaac = array('csvuserId'=>$checkStudentPresentInMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $maac->insert('student_membership',$student_membershipDataMaac);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);
                        }
                        




                    }
                }else if($checkStudentPresent[0]['centerId'] == 3)
                {
                    $checkCourseEndDateInLakme = $lakme->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresentInLakme[0]['id'])->get()->row_array();
                   
                    if(!empty($checkCourseEndDateInLakme))
                    {
                        
                            $student_membershipDataLakme = array('csvuserId'=>$checkStudentPresentInLakme[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->where('csvuserId',$checkStudentPresentInLakme[0]['id']);
                            $lakme->update('student_membership',$student_membershipDataLakme);

                            $lakme->where('id',$checkStudentPresentInLakme[0]['id']);
                            $lakme->update('institute_csv_users',array('paymentStatus'=>$paymentStatus));

                            $status = array("statusCode" => 200, "errorMessage" =>"", "statusMessage" => "User data updated successfully" );


                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status,200);


                        
                    }
                    else
                    {
                        if(empty($checkStudentPresentInLakme[0]['id'])){
                            $lakme->insert('institute_csv_users',$userTableArray);
                            $userIdLakme= $lakme->insert_id();
                            $student_membershipDataLakme = array('csvuserId'=>$userIdLakme,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->insert('student_membership',$student_membershipDataLakme);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);
                        }else{
                            $student_membershipDataLakme = array('csvuserId'=>$checkStudentPresentInLakme[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->insert('student_membership',$student_membershipDataLakme);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);
                        }
                       

                    }
                }


                    /*
                        * Create Error Log file
                    */
                    $successLogFile = APPPATH . "api_logs/".$logErrorFileName;
                    $curDate  = date('m_d_Y_h:i:s_a');
                    $sfh = fopen($successLogFile, 'a') or die("can't open file");
                    if(!empty($checkStudentPresentInMaac)){
                        $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." Student ID already exists\n";
                    }
                    if(!empty($checkStudentPresentInLakme)){
                        $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." Student ID already exists\n";
                    }

                    
                    fwrite($sfh, $logData);
                    fclose($sfh);


                    $this->response(array('statusCode' => 400,'errorMessage' => 'Student ID already exists','statusMessage' => ''), 200);

            }
        }
        else
        {


            /*
                * Create Error Log file
            */
            $successLogFile = APPPATH . "api_logs/".$logErrorFileName;

            $curDate  = date('m_d_Y_h:i:s_a');
            $sfh = fopen($successLogFile, 'a') or die("can't open file");
            if(empty($checkStudentPresentInMaac)){
                $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." There is no institute with given sap code\n";
            }
            if(empty($checkStudentPresentInLakme)){
                $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." There is no institute with given sap code\n";
            }
            
            fwrite($sfh, $logData);
            fclose($sfh);


            $this->response(array('statusCode' => 400,'errorMessage' => 'There is no institute with given sap code','statusMessage' => ''), 200);

        }
    }
    function import_user_retry_post()
    {

        //print_r($this->post());die;

        $validClientId='78b18083f68552d18777c9258bf23762';
        $validSecretKey='264c52176aa143b0a4c3073c5556e0c7';
        if($this->post('api_client_id'))
        {
            $clientId = $this->post('api_client_id');
            if($clientId != $validClientId)
            {
                $this->response(array('statusCode' => 401,'errorMessage' => 'Invalid API client ID','statusMessage' => ''), 200);
            }
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Client Id is required','statusMessage' => ''), 200);
        }

        if($this->post('api_secret_key'))
        {
            $secret_key = $this->post('api_secret_key');
            if($secret_key != $validSecretKey)
            {
                $this->response(array('statusCode' => 401,'errorMessage' => 'Invalid API secret key','statusMessage' => ''), 200);
            }
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Secret key is required','statusMessage' => ''), 200);
        }

        /*if($this->post('institute_name'))
        {
           $instituteName = $this->post('institute_name');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Institute name is required','statusMessage' => ''), 200);
        }*/

        if($this->post('sap_center_code'))
        {
           $sap_center_code = $this->post('sap_center_code');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'SAP center code is required','statusMessage' => ''), 200);
        }

        if($this->post('brand_id'))
        {
           $center_id = $this->post('brand_id');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Brand id is required','statusMessage' => ''), 200);
        }

        if($this->post('first_name'))
        {
           $firstName = $this->post('first_name');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'First name is required','statusMessage' => ''), 200);
        }

        if($this->post('last_name'))
        {
           $lastName = $this->post('last_name');
        }
        else
        {
            $lastName='.';
        }

        if($this->post('student_id'))
        {
           $studentId = $this->post('student_id');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Student ID is required','statusMessage' => ''), 200);
        }

        if($this->post('course_id'))
        {
           $courseId = $this->post('course_id');
        }
         else
        {
            $courseId='';
        }

        if($this->post('course_name'))
        {
           $courseName = $this->post('course_name');
        }
         else
        {
            $courseName='';
        }

        if($this->post('course_start_date'))
        {
           $courseStartDate = $this->post('course_start_date');
        }
        else
        {
            $courseStartDat=date('Y-m-d H:i:s');
        }

        if($this->post('course_end_date'))
        {
           $courseEndDate = $this->post('course_end_date');
        }
        else
        {
            $this->response(array('statusCode' => 400,'errorMessage' => 'Course end date is required','statusMessage' => ''), 200);
        }
        if($this->post('email_id'))
        {
           $email = $this->post('email_id');
        }
        else
        {
            $email = "";
        }
        if($this->post('contact_no'))
        {
           $contact_no = $this->post('contact_no');
        }
        else
        {
            $contact_no = "";
        }
        /*if($this->post('payment_status') == 1)
        {*/
           $paymentStatus = 1;
        /*}
        else
        {
            $paymentStatus = 0;
        }*/


        $logDetailsString = $firstName.','.$lastName.',(Email Id :'.$email.'),(Contact No :'.$contact_no.'), (SAP center Code :'.$sap_center_code.'), (Student ID: '.$studentId.'), (Course ID:'.$courseId.'),(Course Name: '.$courseName.'), ( Course Start Date'.$courseStartDate.'),(Course End Date: '.$courseEndDate.'), (CenterId: '.$center_id.')';

        // $logSuccessFileName = "Success.log";
        // $logErrorFileName = "Error.log";

        $logSuccessFileName = "Success_".date('Y-m-d').'_12'.date('A').'.log';
        $logErrorFileName = "Error_".date('Y-m-d').'_12'.date('A').'.log';



        // print_r($this->post());die;

        $maac = $this->load->database('maac_db', TRUE);
        $lakme = $this->load->database('lakme_db', TRUE);

        if($center_id==1)
        {
            $get_instituteId = $this->db->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if($center_id==2)
        {
            $get_instituteId = $maac->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if($center_id==3)
        {
            $get_instituteId = $lakme->select('id')->from('institute_master')->where('sap_center_code',$sap_center_code)->get()->row_array();
        }

        if(!empty($get_instituteId))
        {
            $instituteId = $get_instituteId['id'];
            if($paymentStatus == 0)
            {
                $paymentStatus = 2;
                $course_start_date = date('Y-m-d H:i:s');
                $course_end_date ='2018-02-28 23:59:59';
            }
            elseif($paymentStatus == 1)
            {
                $paymentStatus = 3;
                $course_start_date = date('Y-m-d H:i:s',strtotime($courseStartDate));
                $course_end_date = date('Y-m-d H:i:s', strtotime($courseEndDate.' +90 days'));
            }

            $userTableArray=array('instituteId'=>$instituteId,'firstName'=>$firstName,'lastName'=>$lastName,'contact_email'=>$email,'contactNo'=>$contact_no,'courseId'=>$courseId,'courseName'=>$courseName,'studentId'=>$studentId,'status'=>1,'paymentStatus'=>$paymentStatus,'registration_date'=>date('Y-m-d H:i:s'),'centerId'=>$center_id);

            $checkStudentPresent=$this->model_basic->getAllData('institute_csv_users','id,centerId',array('instituteId'=>$instituteId,'studentId'=>$studentId));

            $checkStudentPresentInMaac=$maac->select('id,centerId')->from('institute_csv_users')->where(array('instituteId'=>$instituteId,'studentId'=>$studentId))->get()->result_array();

            $checkStudentPresentInLakme=$lakme->select('id,centerId')->from('institute_csv_users')->where(array('instituteId'=>$instituteId,'studentId'=>$studentId))->get()->result_array();

            if(empty($checkStudentPresent))
            {
                $userId=$this->model_basic->_insert('institute_csv_users',$userTableArray);
                $maac->insert('institute_csv_users',$userTableArray);
                $userIdMaac= $maac->insert_id();

                $lakme->insert('institute_csv_users',$userTableArray);
                $userIdLakme= $lakme->insert_id();

                $student_membershipData = array('csvuserId'=>$userId,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);

                $student_membershipDataMaac = array('csvuserId'=>$userIdMaac,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserIdMaac=$maac->insert('student_membership',$student_membershipDataMaac);

                $student_membershipDataLakme = array('csvuserId'=>$userIdLakme,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                $memberuserIdLakme=$lakme->insert('student_membership',$student_membershipDataLakme);

                $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                /*
                    * Create Success Log file
                */

                $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                $curDate  = date('m_d_Y_h:i:s_a');
                $sfh = fopen($successLogFile, 'a') or die("can't open file 11");
                $logData = $curDate.": (Retry_func) (User_id: ".$userId."),".$logDetailsString." User data imported successfully\n";
                fwrite($sfh, $logData);
                fclose($sfh);

                $this->response($status,200);

            }
            else
            {
                if($checkStudentPresent[0]['centerId'] == 1)
                {
                    $checkCourseEndDate = $this->db->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresent[0]['id'])->get()->row_array();
                    if(!empty($checkCourseEndDate))
                    {
                        
                            $student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                            $memberuserId=$this->model_basic->_updateWhere('student_membership',array('csvuserId'=>$checkStudentPresent[0]['id']),$student_membershipData);
                            $this->model_basic->_updateWhere('institute_csv_users',array('id'=>$checkStudentPresent[0]['id']),array('paymentStatus'=>$paymentStatus));
                            $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "User data updated successfully" );

                            /*
                                * Create Success Log file
                            */

                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file 22");
                            $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresent[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status,200);

                        

                    }
                    else
                    {
                        $student_membershipData = array('csvuserId'=>$checkStudentPresent[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);
                        $memberuserId=$this->model_basic->_insert('student_membership',$student_membershipData);
                        $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                        /*
                            * Create Error Log file
                        */
                        $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                        $curDate  = date('m_d_Y_h:i:s_a');
                        $sfh = fopen($successLogFile, 'a') or die("can't open file 333");
                        $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresent[0]['id']."),".$logDetailsString." User data imported successfully\n";
                        fwrite($sfh, $logData);
                        fclose($sfh);

                        $this->response($status);

                    }
                }
                else if($checkStudentPresent[0]['centerId'] == 2)
                {
                    $checkCourseEndDateInMaac = $maac->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresentInMaac[0]['id'])->get()->row_array();

                    if(!empty($checkCourseEndDateInMaac))
                    {
                        
                            $student_membershipDataMaac = array('csvuserId'=>$checkStudentPresentInMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $maac->where('csvuserId',$checkStudentPresentInMaac[0]['id']);
                            $maac->update('student_membership',$student_membershipDataMaac);

                            $maac->where('id',$checkStudentPresentInMaac[0]['id']);
                            $maac->update('institute_csv_users',array('paymentStatus'=>$paymentStatus));

                            $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "User data updated successfully" );

                            /*
                                * Create Success Log file
                            */


                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file 343");
                            $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);


                            $this->response($status,200);

                       
                    }
                    else
                    {
                    	if(empty($checkStudentPresentInMaac[0]['id'])){
                    		$maac->insert('institute_csv_users',$userTableArray);
                    		$userIdMaac= $maac->insert_id();
                    		$student_membershipDataMaac = array('csvuserId'=>$userIdMaac,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                    		$maac->insert('student_membership',$student_membershipDataMaac);

                    		$status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                    		/*
                    	    * Create Success Log file
                    		*/
                    		$successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                    		$curDate  = date('m_d_Y_h:i:s_a');
                    		$sfh = fopen($successLogFile, 'a') or die("can't open file");
                    		$logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data imported successfully\n";
                    		fwrite($sfh, $logData);
                    		fclose($sfh);

                    		$this->response($status);

                    	}else{
                    	    $student_membershipDataMaac = array('csvuserId'=>$checkStudentPresentInMaac[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                    	    $maac->insert('student_membership',$student_membershipDataMaac);

                    	    $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                    	    /*
                    	        * Create Success Log file
                    	    */
                    	    $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                    	    $curDate  = date('m_d_Y_h:i:s_a');
                    	    $sfh = fopen($successLogFile, 'a') or die("can't open file");
                    	    $logData = $curDate.": (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." User data imported successfully\n";
                    	    fwrite($sfh, $logData);
                    	    fclose($sfh);

                    	    $this->response($status);
                    	}
                    	                        

                    }
                }else if($checkStudentPresent[0]['centerId'] == 3)
                {
                    $checkCourseEndDateInLakme = $lakme->select('*')->from('student_membership')->where('csvuserId',$checkStudentPresentInLakme[0]['id'])->get()->row_array();

                    if(!empty($checkCourseEndDateInLakme))
                    {
                            $student_membershipDataLakme = array('csvuserId'=>$checkStudentPresentInLakme[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->where('csvuserId',$checkStudentPresentInLakme[0]['id']);
                            $lakme->update('student_membership',$student_membershipDataLakme);

                            $lakme->where('id',$checkStudentPresentInLakme[0]['id']);
                            $lakme->update('institute_csv_users',array('paymentStatus'=>$paymentStatus));

                            $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "User data updated successfully" );

                            /*
                                * Create Success Log file
                            */


                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file 343");
                            $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data updated successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);


                            $this->response($status,200);

                        
                    }
                    else
                    {
                        if(empty($checkStudentPresentInLakme[0]['id'])){
                            $lakme->insert('institute_csv_users',$userTableArray);
                            $userIdLakme= $lakme->insert_id();
                            $student_membershipDataLakme = array('csvuserId'=>$userIdLakme,'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->insert('student_membership',$student_membershipDataLakme);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);
                        }else{
                            $student_membershipDataLakme = array('csvuserId'=>$checkStudentPresentInLakme[0]['id'],'start_date'=>$course_start_date,'end_date'=>$course_end_date,'status'=>1,'origin'=>1);

                            $lakme->insert('student_membership',$student_membershipDataLakme);

                            $status = array("statusCode" => 201, "errorMessage" => "", "statusMessage" => "User data imported successfully" );

                            /*
                                * Create Success Log file
                            */
                            $successLogFile = APPPATH . "api_logs/".$logSuccessFileName;
                            $curDate  = date('m_d_Y_h:i:s_a');
                            $sfh = fopen($successLogFile, 'a') or die("can't open file");
                            $logData = $curDate.": (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." User data imported successfully\n";
                            fwrite($sfh, $logData);
                            fclose($sfh);

                            $this->response($status);
                        }
                    }
                }

                    /*
                        * Create Error Log file
                    */
                    $successLogFile = APPPATH . "api_logs/".$logErrorFileName;
                    $curDate  = date('m_d_Y_h:i:s_a');
                    $sfh = fopen($successLogFile, 'a') or die("can't open file 34344");
                    if(!empty($checkStudentPresentInMaac)){
                        $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." Student ID already exists','statusMessage\n";
                    }
                    if(!empty($checkStudentPresentInLakme)){
                        $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." Student ID already exists','statusMessage\n";
                    }
                    
                    fwrite($sfh, $logData);
                    fclose($sfh);


                    $this->response(array('statusCode' => 400,'errorMessage' => 'Student ID already exists','statusMessage' => ''), 200);

            }
        }
        else
        {

            /*
                * Create Error Log file
            */
            $successLogFile = APPPATH . "api_logs/".$logErrorFileName;
            $curDate  = date('m_d_Y_h:i:s_a');
            $sfh = fopen($successLogFile, 'a') or die("can't open file");
            if(empty($checkStudentPresentInMaac)){
                $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInMaac[0]['id']."),".$logDetailsString." There is no institute with given sap code\n";
            }
            if(empty($checkStudentPresentInLakme)){
                $logData = $curDate.": (Retry_func) (User_id: ".$checkStudentPresentInLakme[0]['id']."),".$logDetailsString." There is no institute with given sap code\n";
            }
            
            fwrite($sfh, $logData);
            fclose($sfh);
            $this->response(array('statusCode' => 400,'errorMessage' => 'There is no institute with given sap code','statusMessage' => ''), 200);

        }
    }
}