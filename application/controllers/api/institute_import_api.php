<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class institute_import_api extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('model_basic');
  }

  function institutes_import_post()
  {

    // print_r($this->post());die;

    $validClientId='78b18083f68552d18777c9258bf23762';
    $validSecretKey='264c52176aa143b0a4c3073c5556e0c7';
    $maac = $this->load->database('maac_db', TRUE);
    $lakme = $this->load->database('lakme_db', TRUE);
    
    $logSuccessFileName = APPPATH . "api_logs/institutes_import_log/Success_".date('Y-m-d').'_12'.date('A').'.log';
    $logErrorFileName = APPPATH . "api_logs/institutes_import_log/Error_".date('Y-m-d').'_12'.date('A').'.log';
    $logData = json_encode($this->post());

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

    if($this->post('institute_name'))
    {
      $instituteName = $this->post('institute_name');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Institute name is required','statusMessage' => ''), 200);
    }

    if($this->post('brand_id'))
    {
      $brand_id = $this->post('brand_id');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Brand id is required','statusMessage' => ''), 200);
    }

    if($this->post('sap_center_code'))
    {
      $sap_center_code = $this->post('sap_center_code');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'SAP center code is required','statusMessage' => ''), 200);
    }

    if($this->post('centre_id'))
    {
      $centre_id = $this->post('centre_id');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Center ID is required','statusMessage' => ''), 200);
    }

    if($this->post('address'))
    {
      $address = $this->post('address');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Institute Address  is required','statusMessage' => ''), 200);
    }

    if($this->post('contact_number'))
    {
      $contact_number = $this->post('contact_number');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Contact number  is required','statusMessage' => ''), 200);
    }
    
    if($this->post('institute_admin_first_name'))
    {
      $institute_admin_first_name = $this->post('institute_admin_first_name');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin first name is required','statusMessage' => ''), 200);
    }

    if($this->post('institute_admin_last_name'))
    {
       $institute_admin_last_name = $this->post('institute_admin_last_name');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin last name is required','statusMessage' => ''), 200);
    }

    if($this->post('institute_admin_email'))
    {
       $institute_admin_email = $this->post('institute_admin_email');
    }
    else
    {
      $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin email name is required','statusMessage' => ''), 200);
    }
    
    if($brand_id == 1){
      if($this->post('institute_zone'))
      {
        $institute_zone = $this->post('institute_zone');
        $get_zone_details = $this->db->select('id')->from('zone_list')->where('zone_name',$institute_zone)->get()->row_array();
        if(empty($get_zone_details))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute zone not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute zone not found','statusMessage' => ''), 200);
        }else{
          $zone_id = $get_zone_details['id'];
        }

      }else{
        
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute Zone is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_region'))
      {
        $institute_region = $this->post('institute_region');
        $get_region_data = $this->db->select('zone_id, id')->from('region_list')->where('region_name',$institute_region)->get()->row_array();
        if(empty($get_region_data))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute region not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region not found','statusMessage' => ''), 200);

        }else{
          $region_id = $get_region_data['id'];
        }

      }
      else
      {
        //Error Log file
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_admin_email'))
      {
        $institute_admin_email = $this->post('institute_admin_email');
        $userdata = array(
                  'firstName'  => $institute_admin_first_name,
                  'lastName'   => $institute_admin_last_name,
                  'email'      => $institute_admin_email,
                  'admin_level'  => 2,
                  'status'      => 1,
                  'contactNo'   => $this->post('contact_number'),
                  'created'     => date('Y-m-d h:i:s')
        );
          
        $adminAreanUserData = $this->db->select('id')->from('users')->where('email',$institute_admin_email)->get()->row_array();

        if(empty($adminAreanUserData))
        {
          $this->db->insert('users',$userdata);
          $adminUserinsert_id = $this->db->insert_id();
          $admin_uid  = $adminUserinsert_id;
        }else{
          $admin_uid  = $adminAreanUserData['id'];
          $this->model_basic->_update('users','id',$admin_uid, $userdata);
        }
        
       
      }
      else
      {
        //Error Log file
        $this->logDataWrite($logErrorFileName, $logData, 'Institute admin_email id is required');
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin_email id is required','statusMessage' => ''), 200);
      }

      $data = array(
              'head_office_name'  => 'Head Office',
              'zone'              => $zone_id,
              'region'            => $region_id,
              'sap_center_code'   => $sap_center_code,
              'instituteName'     => $instituteName,
              'adminId'           => $admin_uid,
              'pageName'          => trim($instituteName),
              'address'           => $address,
              'contactNo'         => $contact_number,
              'admin_status'      => 1,
              'status'            => 1,
              'centre_id'         => $centre_id,
              'created'           => date('Y-m-d h:i:s'),
              );

      $isCenterIdPresent = $this->db->select('id')->from('institute_master')->where('centre_id',$centre_id)->get()->row_array();

      if(!empty($isCenterIdPresent)){
        unset($data['created']);
        $data['modified'] = date('Y-m-d h:i:s');
        $updateID = $isCenterIdPresent['id'];
        $this->model_basic->_update('institute_master','id',$updateID, $data);
        $this->model_basic->_update('users','id',$admin_uid,$updateID);
        $last_query = $this->db->last_query();
        //Success Log file
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data updated successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "Institute data updated successfully" );
        $this->response($status,200);
      }else{
        $this->db->insert('institute_master',$data);
        $institute_insert_id = $this->db->insert_id();
        $this->model_basic->_update('users','id',$admin_uid,array('instituteId'=>$institute_insert_id));

        //Success Log file
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data imported successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "Institute data imported successfully" );
        $this->response($status,200);
      }
    }elseif ($brand_id == 2) {
      if($this->post('institute_zone'))
      {
        $maacinstitute_zone = $this->post('institute_zone');
        $get_maac_zone_details = $maac->select('id')->from('zone_list')->where('zone_name',$maacinstitute_zone)->get()->row_array();
        if(empty($get_maac_zone_details))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute zone not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute zone not found','statusMessage' => ''), 200);
        }else{
          $maac_zone_id = $get_maac_zone_details['id'];
        }
      }else{
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute Zone is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_region'))
      {
        $maacinstitute_region = $this->post('institute_region');
        $get_maac_region_data = $maac->select('zone_id, id')->from('region_list')->where('region_name',$maacinstitute_region)->get()->row_array();
        if(empty($get_maac_region_data))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute region not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region not found','statusMessage' => ''), 200);
        }else{
          $maac_region_id = $get_maac_region_data['id'];
        }
      }
      else
      {
        //Error Log file
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_admin_email'))
      {
        $maacinstitute_admin_email = $this->post('institute_admin_email');
        $maacuserdata = array(
                        'firstName'  => $institute_admin_first_name,
                        'lastName'   => $institute_admin_last_name,
                        'email'      => $maacinstitute_admin_email,
                        'admin_level'  => 2,
                        'status'      => 1,
                        'contactNo'   => $this->post('contact_number'),
                        'created'     => date('Y-m-d h:i:s')
        );
                
        $adminMaacUserData = $maac->select('id')->from('users')->where('email',$maacinstitute_admin_email)->get()->row_array();

        if(empty($adminMaacUserData))
        {
          $maac->insert('users',$maacuserdata);
          $maacadminUserinsert_id = $maac->insert_id();
          $maacadmin_uid  = $maacadminUserinsert_id;
        }else{
          $maacadmin_uid  = $adminMaacUserData['id'];
          //$maac->update('users','id',$admin_uid, $userdata);
          $maac->where('id',$maacadmin_uid);
          $maac->update('users',$maacuserdata);
        }
             
      }
      else
      {
        //Error Log file
        $this->logDataWrite($logErrorFileName, $logData, 'Institute admin_email id is required');
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin_email id is required','statusMessage' => ''), 200);
      }

      $maacdata = array(
                    'head_office_name'  => 'Head Office',
                    'zone'              => $maac_zone_id,
                    'region'            => $maac_region_id,
                    'sap_center_code'   => $sap_center_code,
                    'instituteName'     => $instituteName,
                    'adminId'           => $maacadmin_uid,
                    'pageName'          => trim($instituteName),
                    'address'           => $address,
                    'contactNo'         => $contact_number,
                    'admin_status'      => 1,
                    'status'            => 1,
                    'centre_id'         => $centre_id,
                    'created'           => date('Y-m-d h:i:s'),
                    );

      $isMaacCenterIdPresent = $maac->select('id')->from('institute_master')->where('centre_id',$centre_id)->get()->row_array();

      if(!empty($isMaacCenterIdPresent)){
        unset($data['created']);
        $data['modified'] = date('Y-m-d h:i:s');
        $maacUpdateID = $isMaacCenterIdPresent['id'];
        $maac->where('id',$maacUpdateID);
        $maac->update('institute_master',$maacdata);
        $maac->where('id',$maacadmin_uid);
        $maac->update('users',array('instituteId'=>$maacUpdateID));
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data updated successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => $maacadmin_uid." ".$maac_institute_insert_id  );
        $this->response($status,200);
      }else{
        $maac->insert('institute_master',$maacdata);
        $maac_institute_insert_id = $maac->insert_id();
        $maac->where('id',$maacadmin_uid);
        $maac->update('users',array('instituteId'=>$maac_institute_insert_id));
        $str = $this->db->last_query();
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data imported successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => $maacdata );
        $this->response($status,200);
      }
    }elseif ($brand_id == 3) {
      if($this->post('institute_zone'))
      {
        $lakmeinstitute_zone = $this->post('institute_zone');
        $get_lakme_zone_details = $lakme->select('id')->from('zone_list')->where('zone_name',$lakmeinstitute_zone)->get()->row_array();
        if(empty($get_lakme_zone_details))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute zone not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute zone not found','statusMessage' => ''), 200);
        }else{
          $lakme_zone_id = $get_lakme_zone_details['id'];
        }
      }else{
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute Zone is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_region'))
      {
        $lakmeinstitute_region = $this->post('institute_region');
        $get_lakme_region_data = $lakme->select('zone_id, id')->from('region_list')->where('region_name',$lakmeinstitute_region)->get()->row_array();
        if(empty($get_lakme_region_data))
        {
          //Error Log file
          $this->logDataWrite($logErrorFileName, $logData, 'Institute region not found');
          $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region not found','statusMessage' => ''), 200);
        }else{
          $lakme_region_id = $get_lakme_region_data['id'];
        }
      }
      else
      {
        //Error Log file
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute region is required','statusMessage' => ''), 200);
      }

      if($this->post('institute_admin_email'))
      {
        $lakmeinstitute_admin_email = $this->post('institute_admin_email');
        $lakmeuserdata = array(
                        'firstName'  => $institute_admin_first_name,
                        'lastName'   => $institute_admin_last_name,
                        'email'      => $lakmeinstitute_admin_email,
                        'admin_level'  => 2,
                        'status'      => 1,
                        'contactNo'   => $this->post('contact_number'),
                        'created'     => date('Y-m-d h:i:s')
        );
                
        $adminlakmeUserData = $lakme->select('id')->from('users')->where('email',$maacinstitute_admin_email)->get()->row_array();

        if(empty($adminlakmeUserData))
        {
          $lakme->insert('users',$lakmeuserdata);
          $lakmeadminUserinsert_id = $lakme->insert_id();
          $lakmeadmin_uid  = $lakmeadminUserinsert_id;
        }else{
          $lakmeadmin_uid  = $adminlakmeUserData['id'];
          //$maac->update('users','id',$admin_uid, $userdata);
          $lakme->where('id',$lakmeadmin_uid);
          $lakme->update('users',$lakmeuserdata);
        }
             
      }
      else
      {
        //Error Log file
        $this->logDataWrite($logErrorFileName, $logData, 'Institute admin_email id is required');
        $this->response(array('statusCode' => 400,'errorMessage' => 'Institute admin_email id is required','statusMessage' => ''), 200);
      }

      $lakmedata = array(
                    'head_office_name'  => 'Head Office',
                    'zone'              => $lakme_zone_id,
                    'region'            => $lakme_region_id,
                    'sap_center_code'   => $sap_center_code,
                    'instituteName'     => $instituteName,
                    'adminId'           => $lakmeadmin_uid,
                    'pageName'          => trim($instituteName),
                    'address'           => $address,
                    'contactNo'         => $contact_number,
                    'admin_status'      => 1,
                    'status'            => 1,
                    'centre_id'         => $centre_id,
                    'created'           => date('Y-m-d h:i:s'),
                    );

      $islakmeCenterIdPresent = $lakme->select('id')->from('institute_master')->where('centre_id',$centre_id)->get()->row_array();

      if(!empty($islakmeCenterIdPresent)){
        unset($data['created']);
        $data['modified'] = date('Y-m-d h:i:s');
        $lakmeUpdateID = $islakmeCenterIdPresent['id'];
        $lakme->where('id',$lakmeUpdateID);
        $lakme->update('institute_master',$lakmedata);
        $lakme->where('id',$lakmeadmin_uid);
        $lakme->update('users',array('instituteId'=>$lakmeUpdateID));
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data updated successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "Institute data updated successfully");
        $this->response($status,200);
      }else{
        $lakme->insert('institute_master',$lakmedata);
        $lakme = $lakme->insert_id();
        $lakme->where('id',$lakmeadmin_uid);
        $lakme->update('users',array('instituteId'=>$lakme_institute_insert_id));
        $this->logDataWrite($logSuccessFileName, $logData, 'Institute data imported successfully');
        $status = array("statusCode" => 200, "errorMessage" => "", "statusMessage" => "Institute data imported successfully" );
        $this->response($status,200);
      }
    }
  }  
   


   /**
    * [logDataWrite description]
    * @param  [type] $pathName [description]
    * @param  [type] $logData  [description]
    * @param  [type] $msg      [description]
    * @return [type]           [description]
    */
  function logDataWrite($pathName, $logData, $msg){
    /*
    * Create Log file
    */
    $curDate  = date('m_d_Y_h:i:s_a');
    $sfh = fopen($pathName, 'a') or die("can't open file");
    $logData = $curDate.": ".$logData.",".$msg."\n";
    fwrite($sfh, $logData);
    fclose($sfh);
  }

}