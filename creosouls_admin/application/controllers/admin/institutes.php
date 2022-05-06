<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Institutes extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
    	$this->load->library('form_validation');
    	$this->load->library('upload');
    	$this->load->library('image_lib');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/institute_model');
	}

	public function index()
	{
		$this->load->view('admin/institutes/manage_institutes');
	}

	public function getAutocompleteUserData()
	{
		$instituteId=$_POST['instituteId'];
		echo $this->institute_model->getAutocompleteUserData($instituteId);
	}
	function get_ajaxdataObjects()
	{
		$_POST['columns']='A.id,A.instituteName,A.sap_center_code,admin_name,A.contactNo,A.created,A.status,userStatus,B.id,B.email';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns="A.id,A.instituteLogo,A.instituteName,A.sap_center_code,A.pageName,CONCAT(B.firstName, ' ',B.lastName) as admin_name,A.contactNo,A.created,A.status,B.status as userStatus,A.coverImage,B.profileImage,B.id as userId,B.email,A.zone,A.region";
		//print_r($columns);die;
		//get total number of data without any condition and search term
		  if($this->session->userdata('admin_level')==2)
			{
				$condition=array('id'=>$this->session->userdata('instituteId'));
			}
			else
			{
				$condition=array();
			}

		$totalData=$this->modelbasic->count_all_only('institute_master',$condition);
		$totalFiltered=$totalData;

		//pass concatColumns only if you want search field to be fetch from concat
		$concatColumns='B.firstName,B.lastName';
			$result=$this->institute_model->run_query('institute_master',$requestData,$columns,$selectColumns,$concatColumns,'admin_name');
			//print_r($result);die;
			if( !empty($requestData['search']['value']) )
			{
				$totalFiltered=count($result);
			}
			$data = array();

			if(!empty($result))
			{
				$i=1;
				foreach ($result as $row)
				{
				  $nestedData=array();

				  //$institute_users=$this->modelbasic->get_where_custom('institute_csv_users','instituteId',$row['id']);
				  $det = $this->db->select('*')->from('institute_csv_users')->where('instituteId',$row['id'])->where('centerId','1')->get()->result_array();

				  $html='';
				 // $det = $institute_users->result_array();
				  if(!empty($det))
					{
						$j=1;
						foreach($det as $dt)
						{
							if($dt['status']==1){ $text="<span class='text-success'>Active</span>";}else{ $text="<span class='text-danger'>Deactive</span>";}
							$html.='<tr>
									  <td>'.$j.'</td>'.
									  '<td>'.$dt['studentId'].'</td>'.
				                      '<td>'.$dt['firstName'].'</td>'.
				                	  '<td>'.$dt['lastName'].'</td>'.
				                	 /* '<td>'.$dt['email'].'</td>'.*/
				                	  '<td>'.$text.'</td>
				                   </tr>';
				             $j++;
						}
					}
					$nestedData['institute_users']=$html;

					if($row['userStatus'] == 1)
					{
						$userStatusHtml='<span class="label label-success" style="cursor: auto;">Active</span>';
					}
					else
					{
						$userStatusHtml='<span class="label label-danger" style="cursor: auto;">Deactive</span>';
					}

					if($row['admin_name'] == ' ')
					{
						$userName=ucwords('No Name');
					}
					else
					{
						$userName=ucwords($row["admin_name"]);
					}

					$zonename =$this->db->select('zone_name')->from('zone_list')->where('id',$row['zone'])->get()->row_array();
					$regionname =$this->db->select('region_name')->from('region_list')->where('id',$row['region'])->get()->row_array();
					$nestedData['zone'] = $zonename['zone_name'];
					$nestedData['region'] = $regionname['region_name'];

					$instituteCoverImage=$row["coverImage"];
					//echo $instituteCoverImage;die;
					if($instituteCoverImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'institute/coverImage/thumbs/'.$instituteCoverImage))
						{
							$instituteCoverImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/Institute_Thumb_Banner.png">';
						}
						else
						{
							$instituteCoverImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/Institute_Thumb_Banner.png">';
						}
					}
					else
					{
						$instituteCoverImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/Institute_Thumb_Banner.png">';
					}

					$instituteLogo=$row["instituteLogo"];
					//echo $instituteCoverImage;die;
					if($instituteLogo <> '')
					{
						if(file_exists(file_upload_absolute_path().'institute/instituteLogo/thumbs/'.$instituteLogo))
						{
							$instituteLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/Institute_Logo.png">';
						}
						else
						{
							$instituteLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/Institute_Logo.png">';
						}
					}
					else
					{
						$instituteLogo = '<img width="100" height="100" src="'.base_url().'backend_assets/img/Institute_Logo.png">';
					}

					$profileImage = '<img width="50" height="50" src="'.file_upload_base_url().'users/thumbs/'.$row['profileImage'].'">';
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] =$i+$requestData['start'];
					$nestedData['instituteName'] =$instituteLogo.'<br/>'.' <a target="_blank" href="'.front_base_url().$row["pageName"].'">'.$row["instituteName"].'</a>';

					$nestedData['instituteDetails'] = '<b>institute Id: </b>'.$row["id"].'<br/><b>Cover Image: </b>'.$instituteCoverImage.'<br/><b>Contact: </b>'.$row['contactNo'];


					$nestedData['instituteID'] = $row["id"];
					$nestedData['CoverImage'] = $instituteCoverImage;
					$nestedData['Contact'] = $row['contactNo'];
					$nestedData['sap_center_code'] = $row['sap_center_code'];
					$nestedData['admin_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/><b>User Id: </b>'.$row["userId"].'<br/><b>Status: </b>'.$userStatusHtml.'<br/>';


					$nestedData['adminprofileImage'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a>';
					$nestedData['adminuserId'] = $row["userId"];
					$nestedData['adminuserStatus'] = $userStatusHtml;


					//<a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>
					//onclick="change_status('.$row['id'].')"
					//$nestedData['profileImage'] = '<img style="border-radius:50px;cursor: pointer;" width="70" src="'.file_upload_base_url().'institutes/thumbs/'.$row['profileImage'].'">';
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));
					if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;">Active</span>';}else{ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}
					$nestedData['action'] = '<span class="menu-action rounded-btn"><a onclick="showInstDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></span>';
					$data[] = $nestedData;
					$i++;
					/*<a href="'.base_url().'admin/make_payment/get/'.urlencode(base64_encode($row['id'])).'" class="btn menu-icon vd_bd-blue vd_facebook" data-placement="top" data-toggle="tooltip" data-original-title="Make Payment"> <i class="fa fa-rupee"></i> </a>*/
				}
			}
			$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);
			echo json_encode($json_data);
	}

	function reorderRows()
	{
		$startPosition=$_POST['sPosition'];
		$endPosition=$_POST['ePosition'];

		if($startPosition > $endPosition)
		{
			$this->modelbasic->_update_custom('employee','order',$startPosition,array('order'=>0));
			$result=$this->modelbasic->getAllWhere('employee','order',array('order >='=>$endPosition),'order','desc');
			foreach ($result as $value)
			{
				$this->modelbasic->_update_custom('employee','order',$value['order'],array('order'=>$value['order']+1));
			}
			$this->modelbasic->_update_custom('employee','order',0,array('order'=>$endPosition));
		}
		else
		{
			$this->modelbasic->_update_custom('employee','order',$startPosition,array('order'=>0));
			$result=$this->modelbasic->getAllWhere('employee','order',array('order >'=>$startPosition,'order <='=> $endPosition),'order','asc');

			foreach ($result as $value)
			{
				$this->modelbasic->_update_custom('employee','order',$value['order'],array('order'=>$value['order']-1));
			}
			$this->modelbasic->_update_custom('employee','order',0,array('order'=>$endPosition));
		}
		echo 'true';
	}

	function addedit_user()
	{
		$this->load->view('admin/institutes/addedit_view');
	}

	function multiselect_action()
	{
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];

			//echo "<pre>";print_r($_POST);die;

			foreach ($check as $key => $value) {

				if($_POST['listaction'] == '1'){

					$status = array('status'=>'1');
					$this->modelbasic->_update('institute_master',$key,$status);
					$this->session->set_flashdata('success', 'Institute\'s activated successfully');

				}else if($_POST['listaction'] == '2'){

						$status = array('status'=>'0');
					$this->modelbasic->_update('institute_master',$key,$status);

						$this->session->set_flashdata('success', 'Institute\'s deactivated successfully');


				}else
				if($_POST['listaction'] == '3')
				{
				 		$query=$this->modelbasic->getValue('institute_master','coverImage','id',$key);
				 		$path2 = file_upload_s3_path().'institute/coverImage/';
						$path3 = file_upload_s3_path().'institute/coverImage/thumbs/';
						if(!empty($query))
						{
							if(file_exists($path2.$query))
							{
								unlink( $path2 . $query);
							}
							elseif (file_exists($path3.$query)) {
								unlink( $path3 . $query);
							}
				        	}

		        	 		$query=$this->modelbasic->getValue('institute_master','instituteLogo','id',$key);
		        			$path2 = file_upload_s3_path().'institute/instituteLogo/';
		        			$path3 = file_upload_s3_path().'institute/instituteLogo/thumbs/';
				    		if(!empty($query))
				    		{
				    			if(file_exists($path2.$query))
				    			{
				    				unlink( $path2 . $query);
				    			}
				    			elseif (file_exists($path3.$query))
				    			{
				    				unlink( $path3 . $query);
				    			}
			            	}

			            $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));

				        $this->modelbasic->_delete('institute_master',$key);
				        $this->modelbasic->_delete_with_condition('institute_csv_users','instituteId',$key);
				        $this->session->set_flashdata('success', 'Institute\'s deleted successfully');
				}
			}

			redirect('admin/institutes');
		}
	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('institute_master','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>'0');
			if($id != 1)
			{
				$this->session->set_flashdata('success', 'Institute deactivated successfully.');
			}
		}
		else
		if($result == 0)
		{
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Institute activated successfully.');

		}
		$this->modelbasic->_update('institute_master',$id, $data);
		redirect('admin/institutes');
	}


	function delete_confirm($key = NULL)
	{
		$query=$this->modelbasic->getValue('institute_master','coverImage','id',$key);
 		$path2 = file_upload_s3_path().'institute/coverImage/';
		$path3 = file_upload_s3_path().'institute/coverImage/thumbs/';
		if(!empty($query))
		{
			if(file_exists($path2.$query))
			{
				unlink( $path2 . $query);
			}
			elseif (file_exists($path3.$query)) {
				unlink( $path3 . $query);
			}
        	}

 		$query=$this->modelbasic->getValue('institute_master','instituteLogo','id',$key);
		$path2 = file_upload_s3_path().'institute/instituteLogo/';
		$path3 = file_upload_s3_path().'institute/instituteLogo/thumbs/';
    		if(!empty($query))
    		{
    			if(file_exists($path2.$query))
    			{
    				unlink( $path2 . $query);
    			}
    			elseif (file_exists($path3.$query))
    			{
    				unlink( $path3 . $query);
    			}
        	}

        $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));

        $this->modelbasic->_delete('institute_master',$key);
        $this->modelbasic->_delete_with_condition('institute_csv_users','instituteId',$key);
        $this->session->set_flashdata('success', 'Institute\'s deleted successfully');
		redirect('admin/institutes');
	}

	public function processForm()
	{		
		$maac = $this->load->database('maac_db', TRUE);				
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('instituteName', 'Institute name', 'required');
		$this->form_validation->set_rules('sap_center_code', 'SAP Center Code', 'required');
		$this->form_validation->set_rules('address', 'Institute address', 'required');		
		$this->form_validation->set_rules('zone', 'Zone', 'required');
		$this->form_validation->set_rules('region', 'Region', 'required');

		$this->form_validation->set_rules('adminEmail', 'Institute admin email', 'required|valid_email|callback_validateAdminEmail');
		$this->form_validation->set_rules('contactNo', 'Institute contact no', 'required');
		if($this->input->post('instituteId',TRUE) > 0)
		{
			$this->form_validation->set_rules('pageName', 'Institute page display name', 'required|alpha_numeric|callback_validatepageName');
		}
		else
		{
			$this->form_validation->set_rules('pageName', 'Institute page display name', 'required|alpha_numeric|is_unique[institute_master.pageName]');
		}

		  //$this->form_validation->set_rules('instituteLogo', 'Institute logo', 'callback_validateInstituteLogo');
		  //$this->form_validation->set_rules('coverImage', 'Institute cover picture', 'callback_validateCoverImage');

		$this->form_validation->set_rules('csvUsers', 'CSV Users', 'callback_validateCsvUsers');
		if ($this->form_validation->run())
		{
			if($this->input->post('instituteId',TRUE) > 0)
			{
				$instituteId=$this->input->post('instituteId',TRUE);
				$data=array('instituteName'=>$this->input->post('instituteName',TRUE),'sap_center_code'=>$this->input->post('sap_center_code',TRUE),'address'=>$this->input->post('address',TRUE),'adminId'=>$this->input->post('adminId',TRUE),'contactNo'=>$this->input->post('contactNo',TRUE),'pageName'=>$this->input->post('pageName',TRUE),'head_office_name'=>'Head Office','zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE));
				/*if(isset($_POST['instituteLogo']['file_name']) && $_POST['instituteLogo']['file_name'] <> '')
				{
					$data['instituteLogo']=$_POST['instituteLogo']['file_name'];
				}

				if(isset($_POST['coverImage']['file_name']) && $_POST['coverImage']['file_name'] <> '')
				{
					$data['coverImage']=$_POST['coverImage']['file_name'];
				}*/

				if(isset($_POST['csvUsers']['file_name']) && $_POST['csvUsers']['file_name'] <> '')
				{
					$this->load->library('csvimport');
					$file_path =  file_upload_s3_path().'institute/csvUsers/'.$_POST['csvUsers']['file_name'];
					//echo $file_path;die;
					if ($this->csvimport->get_array($file_path))
					{
					    $csv_array = $this->csvimport->get_array($file_path);
					    $i=0;
					    $insert_data=array();
					    $errorLog=array();
					    foreach ($csv_array as $row)
					    {
					    		if($row['firstName'] <> '' && ! is_numeric($row['firstName']) && $row['lastName'] <> '' && ! is_numeric($row['lastName']) && $row['studentId'] <> ''  && $row['courseEndDate'] <> ''  && $row['paymentStatus'] <> ''  && $instituteId > 0)
					    		{		    			
					    			$studentIdExists=$this->modelbasic->getValue('institute_csv_users','id','studentId',$row['studentId']);
					    			if($studentIdExists == '')
					    			{
					    				/*if(isset($row['centerId']) && $row['centerId'] !='')
					    				{
					    					$insert_data['centerId'] = $row['centerId'];
					    				}
					    				else
					    				{*/
					    					$insert_data['centerId'] = '1';
					    				/*}*/
					    				$insert_data['firstName']=$row['firstName'];
					    				$insert_data['lastName']=$row['lastName'];
					    				$insert_data['studentId']=$row['studentId'];
					    				$insert_data['instituteId']=$instituteId;
					    				$insert_data['status']=1;
				    					$insert_data['add_by']='self';				    				
					    				
					    				$insert_data['registration_date']=date('Y-m-d');
					    				if($row['paymentStatus']==0)
					    				{
					    					$courseEndDate=date('Y-m-d H:i:s', strtotime('+30 days'));
					    					$insert_data['paymentStatus']=2;
					    				}
					    				if($row['paymentStatus']==1)
					    				{
					    					$courseEndDate=date("Y-m-d H:i:s", strtotime($row["courseEndDate"]));
					    					$courseEndDate=date('Y-m-d H:i:s', strtotime($courseEndDate. ' + 90 days'));
					    					$insert_data['paymentStatus']=3;
					    				}

					    				if($row['free_access_status']=='Yes')
										{
											$insert_data['free_access_status']='Yes';
										}
										else
										{
											$insert_data['free_access_status']='';
										}
					    				$endDate=$courseEndDate;
					    				$startDate=date('Y-m-d H:i:s');

					    				$insertedCsvUserId=$this->modelbasic->_insert('institute_csv_users',$insert_data);
					    				$this->modelbasic->_insert('student_membership',array('csvuserId'=>$insertedCsvUserId,'status'=>1,'start_date'=>$startDate,'end_date'=>$endDate));

					    				 $maac->insert('institute_csv_users',$insert_data);
					    				 $maacinsertedCsvUserId = $maac->insert_id();
					    				 $maac->insert('student_membership',array('csvuserId'=>$maacinsertedCsvUserId,'status'=>1,'start_date'=>$startDate,'end_date'=>$endDate));
					    			}
					    			elseif($studentIdExists != '' && $row['paymentStatus']==1)
					    			{
					    				//$errorLog['errorMessage'][$i][]='Student ID already exists in our database.';
					    				$courseEndDate=date("Y-m-d H:i:s", strtotime($row["courseEndDate"]));
					    				$courseEndDate=date('Y-m-d H:i:s', strtotime($courseEndDate. ' + 90 days'));
					    				$endDate=$courseEndDate;
					    				$startDate=date('Y-m-d H:i:s');
					    				$this->modelbasic->_update_custom('institute_csv_users','id',$studentIdExists,array('paymentStatus'=>3));
					    				$this->modelbasic->_update_custom('student_membership','csvuserId',$studentIdExists,array('end_date'=>$endDate));
					    			}
					    			elseif($studentIdExists != '' && $row['paymentStatus']==0)
					    			{
					    				$errorLog['errorMessage'][$i][]='Evaluation period entry for this Student Id already inserted.';
					    			}
					    		}
					    		else
					    		{
					    			if($row['firstName'] == '')
					    			{
					    				$errorLog['errorMessage'][$i][]='First Name is required.';
					    			}
					    			elseif (is_numeric($row['firstName'])) {
					    				$errorLog['errorMessage'][$i][]='First Name can not be numeric.';
					    			}

					    			if($row['lastName'] == '')
					    			{
					    				$errorLog['errorMessage'][$i][]='Last Name is required.';
					    			}
					    			elseif (is_numeric($row['lastName'])) {
					    				$errorLog['errorMessage'][$i][]='Last Name can not be numeric.';
					    			}

					    			if($row['studentId'] == '')
					    			{
					    				$errorLog['errorMessage'][$i][]='Student ID is required.';
					    			}

					    			if($row['courseEndDate'] == '')
					    			{
					    				$errorLog['errorMessage'][$i][]='Students course end date is required.';
					    			}

					    			if($row['paymentStatus'] == '')
					    			{
					    				$errorLog['errorMessage'][$i][]='Students payment status is required.';
					    			}

					    			if($instituteId <= 0)
					    			{
					    				$errorLog['errorMessage'][$i][]='Invalid Institute Data.';
					    			}
					    		}
					    	  $i++;
					    }

					    if(!empty($errorLog))
					    {
					    	$this->session->set_userdata('errorLog',$errorLog);
					    }
					}
					else
					{
					    $this->session->userdata('error',"Error occured");
					}
				}
				$this->modelbasic->_update('users',$this->input->post('adminId',TRUE),array('instituteId'=>$instituteId));
				$res=$this->modelbasic->_update('institute_master',$instituteId,$data);
				$adminData=$this->modelbasic->get_where('users',$this->input->post('adminId',TRUE))->row_array();					
				
				$maacUserData = $maac->select('id')->from('users')->where('email',$_POST['adminEmail'])->get()->row_array();				
				if(!empty($maacUserData))
				{
					$maac->where('id',$maacUserData['id'])->delete('users');
					$maac->where('user_id',$maacUserData['id'])->delete('terms_and_conditions');
				}
				$emailIDExists=$this->modelbasic->getValue('institute_csv_users','email','email', $adminData['email']);								
				
				if($emailIDExists == '')
				{
					$this->modelbasic->_insert('institute_csv_users',array('instituteId'=>$instituteId,'firstName'=>$adminData['firstName'],'lastName'=>$adminData['lastName'],'email'=>$adminData['email'],'status'=>1));
				}
				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'Institute updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating Institute please try again....');
				}
			}
			else
			{
				$data=array('instituteName'=>$this->input->post('instituteName',TRUE),'sap_center_code'=>$this->input->post('sap_center_code',TRUE),'address'=>$this->input->post('address',TRUE),'adminId'=>$this->input->post('adminId',TRUE),'contactNo'=>$this->input->post('contactNo',TRUE),'created'=>date('Y-m-d H:i:s'),'status'=>1,'pageName'=>$this->input->post('pageName',TRUE),'head_office_name'=>'Head Office','zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE));
				/*if(isset($_POST['instituteLogo']['file_name']) && $_POST['instituteLogo']['file_name'] <> '')
				{
					$data['instituteLogo']=$_POST['instituteLogo']['file_name'];
				}

				if(isset($_POST['coverImage']['file_name']) && $_POST['coverImage']['file_name'] <> '')
				{
					$data['coverImage']=$_POST['coverImage']['file_name'];
				}*/

				$instituteId=$this->modelbasic->_insert('institute_master',$data);

				if($this->session->userdata('admin_level')==1){
					
					$checkHoAdmin = $this->db->select('hoadmin_id')->from('hoadmin_institute_relation')->where('zone',$this->input->post('zone',TRUE))->where('region',$this->input->post('region',TRUE))->group_by('hoadmin_id')->get()->result_array();
					if(!empty($checkHoAdmin))
					{
						foreach ($checkHoAdmin as $key => $value) {
							$inserthoAdminInstitutData = array('hoadmin_id'=>$value['hoadmin_id'],'zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE),'institute_id'=>$instituteId);
							$this->modelbasic->_insert('hoadmin_institute_relation',$inserthoAdminInstitutData);
						}
					}
				}
				if($this->session->userdata('admin_level')==4){
					$inserthoAdminInstitutData = array('hoadmin_id'=>$this->session->userdata('admin_id'),'zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE),'institute_id'=>$instituteId);
					$this->modelbasic->_insert('hoadmin_institute_relation',$inserthoAdminInstitutData);

				}
				$checkEmployer = $this->modelbasic->getValueWhere('jobs','admin_level',array('posted_by'=>$this->input->post('adminId'),'admin_level'=>3));
				if($checkEmployer!=0)
				{
					$checkEmployer_level = $this->institute_model->updateAll($instituteId,$this->input->post('adminId'),2,3);
					if($checkEmployer_level)
					{
						$this->modelbasic->_update('users',$this->input->post('adminId',TRUE),array('type'=>1));
					}

				}

				$this->modelbasic->_update('users',$this->input->post('adminId',TRUE),array('instituteId'=>$instituteId));
				$adminData=$this->modelbasic->get_where('users',$this->input->post('adminId',TRUE))->row_array();

				$maacUserData = $maac->select('id')->from('users')->where('email',$_POST['adminEmail'])->get()->row_array();				
				if(!empty($maacUserData))
				{
					$maac->where('id',$maacUserData['id'])->delete('users');
					$maac->where('user_id',$maacUserData['id'])->delete('terms_and_conditions');
				}				

				$emailIDExists=$this->modelbasic->getValue('institute_csv_users','email','email', $adminData['email']);

				if($emailIDExists == '')
				{
					$instituteCSVId = $this->modelbasic->_insert('institute_csv_users',array('instituteId'=>$instituteId,'firstName'=>$adminData['firstName'],'lastName'=>$adminData['lastName'],'email'=>$adminData['email'],'status'=>1));
					$subscription = array('csvuserId' => $instituteCSVId, 'start_date' => date("Y-m-d H:i:s"), 'end_date' =>date('Y-m-d H:i:s', strtotime('+1 years')), 'status'=>1);
					$this->modelbasic->_insert('student_membership',$subscription);
				}
				else
				{
					$instituteCSVId=$this->modelbasic->getValue('institute_csv_users','id','email', $adminData['email']);
					$subscription = array('csvuserId' => $instituteCSVId, 'start_date' => date("Y-m-d H:i:s"), 'end_date' =>date('Y-m-d H:i:s', strtotime('+1 years')), 'status'=>1);
					$this->modelbasic->_insert('student_membership',$subscription);
				}

				if(isset($_POST['csvUsers']['file_name']) && $_POST['csvUsers']['file_name'] <> '')
				{
					$this->load->library('csvimport');
					$file_path =  file_upload_s3_path().'institute/csvUsers/'.$_POST['csvUsers']['file_name'];

					if ($this->csvimport->get_array($file_path))
					{
					    $csv_array = $this->csvimport->get_array($file_path);
						$i=0;
						$insert_data=array();
						$errorLog=array();
						foreach ($csv_array as $row)
						{
							if($row['firstName'] <> '' && ! is_numeric($row['firstName']) && $row['lastName'] <> '' && ! is_numeric($row['lastName']) && $row['studentId'] <> ''  && $row['courseEndDate'] <> ''  && $row['paymentStatus'] <> ''  && $instituteId > 0)
							{
								$studentIdExists=$this->modelbasic->getValue('institute_csv_users','studentId','studentId', $row['studentId']);
								if($studentIdExists == '')
								{
									/*if(isset($row['centerId']) && $row['centerId'] !='')
									{
										$insert_data['centerId'] = $row['centerId'];
									}
									else
									{*/
										$insert_data['centerId'] = '1';
									/*}*/
									$insert_data['firstName']=$row['firstName'];
									$insert_data['lastName']=$row['lastName'];
									$insert_data['studentId']=$row['studentId'];
									$insert_data['instituteId']=$instituteId;
									$insert_data['status']=1;
									$insert_data['registration_date']=date('Y-m-d');
									if($row['paymentStatus']==0)
									{
										$courseEndDate=date('Y-m-d H:i:s', strtotime('+30 days'));
										$insert_data['paymentStatus']=2;
									}
									if($row['paymentStatus']==1)
									{
										$courseEndDate=date("Y-m-d H:i:s", strtotime($row["courseEndDate"]));
										$courseEndDate=date('Y-m-d H:i:s', strtotime($courseEndDate. ' + 90 days'));
										$insert_data['paymentStatus']=3;
									}
									$endDate=$courseEndDate;
									$startDate=date('Y-m-d H:i:s');

									$insertedCsvUserId=$this->modelbasic->_insert('institute_csv_users',$insert_data);
									$this->modelbasic->_insert('student_membership',array('csvuserId'=>$insertedCsvUserId,'status'=>1,'start_date'=>$startDate,'end_date'=>$endDate));

									$maac->insert('institute_csv_users',$insert_data);
									$maacinsertedCsvUserId = $maac->insert_id();
									 $maac->insert('student_membership',array('csvuserId'=>$maacinsertedCsvUserId,'status'=>1,'start_date'=>$startDate,'end_date'=>$endDate));
								}
								else
								{
								    $errorLog['errorMessage'][$i][]='Student id already exists in our system associated with student from another institute.';
								}
							}
							else
							{
								if($row['firstName'] == '')
								{
									$errorLog['errorMessage'][$i][]='First Name is required.';
								}
								elseif (is_numeric($row['firstName'])) {
									$errorLog['errorMessage'][$i][]='First Name can not be numeric.';
								}

								if($row['lastName'] == '')
								{
									$errorLog['errorMessage'][$i][]='Last Name is required.';
								}
								elseif (is_numeric($row['lastName'])) {
									$errorLog['errorMessage'][$i][]='Last Name can not be numeric.';
								}

								if($row['studentId'] == '')
								{
									$errorLog['errorMessage'][$i][]='Student ID is required.';
								}

								if($row['courseEndDate'] == '')
								{
									$errorLog['errorMessage'][$i][]='Students course end date is required.';
								}

								if($row['paymentStatus'] == '')
								{
									$errorLog['errorMessage'][$i][]='Students payment status is required.';
								}

								if($instituteId <= 0)
								{
									$errorLog['errorMessage'][$i][]='Invalid Institute Data.';
								}
							}
						  $i++;
						}

						if(!empty($errorLog))
						{
							$this->session->set_userdata('errorLog',$errorLog);
						}
					}
					else
					{
					    $this->session->userdata('error',"Error occured");
					}
				}
				
				if($instituteId > 0)
				{
					$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
					$data=array('status'=>'success','for'=>'add','message'=>'Institute added successfully.');
					$adminEmail=$this->modelbasic->getValue('users','email','id',$this->input->post('adminId',TRUE));
					//$adminEmail='santoshbadal1111@gmail.com';
					$adminName=$this->modelbasic->getValue('users','firstName','id',$this->input->post('adminId',TRUE));
						$emailTo=$adminEmail;
						$from=$emailFrom;

						$templateInstituteEmail='Hello <b>'.$adminName. '</b>,<br />New institute "<b>'.$this->input->post('instituteName',TRUE).'</b>" is created on creosouls .<br /><a href="'.front_base_url().$this->input->post('pageName',TRUE).'">Click here</a>  to view the institute details.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$emailJobDetail=array('to'=>$emailTo,'subject'=>'New institute created on creosouls','template'=>$templateInstituteEmail,'fromEmail'=>$from);
						//$this->modelbasic->sendMail($emailJobDetail);
						//print_r($emailJobDetail);die;
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while creating institute please try again....');
				}
			}

			echo json_encode($data);
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo $this->form_validation->get_json();
			}
			else
			{
				$this->load->view('admin/institutes/addedit_view');
			}
		}
	}

	function validateInstituteLogo()
	{
		return $this->image_upload('instituteLogo','validateInstituteLogo','200','134');
	}

	function validateCoverImage()
	{
		return $this->image_upload('coverImage','validateCoverImage','1300','259');
	}


	function validateCsvUsers()
	{
		$folderName='csvUsers';
		if(isset($_FILES[$folderName]) && $_FILES[$folderName]['size'] != 0)
		{
			$upload_dir = file_upload_s3_path().'institute/'.$folderName.'/';
			if (!is_dir($upload_dir))
			{
			     mkdir($upload_dir, 0777, TRUE);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'csv';
			$config['file_name']     = $folderName.'_'.substr(md5(rand()),0,7);
			$config['max_size']	 = '2000';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($folderName))
			{
				$this->form_validation->set_message('validateCsvUsers', $this->upload->display_errors());
				return false;
			}
			else
			{
				$_POST[$folderName] =  $this->upload->data();
				return true;
			}
		}
		else
		{
			return true;
		}
	}



	function image_upload($folderName,$functionName,$width,$height)
	{
		if(isset($_FILES[$folderName])&&$_FILES[$folderName]['size'] != 0)
		{
			$upload_dir = file_upload_s3_path().'institute/'.$folderName.'/';
			if (!is_dir($upload_dir))
			{
			     mkdir($upload_dir, 0777, TRUE);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = $folderName.'_'.substr(md5(rand()),0,7);
			$config['max_size']	 = '2000';


			/*if($folderName=='coverImage')
			{
				$config['max_width']  = '1300';
		        $config['max_height']  = '260';
			}*/


			$this->upload->initialize($config);
			if (!$this->upload->do_upload($folderName))
			{
				$this->form_validation->set_message($functionName, $this->upload->display_errors());
				return false;
			}
			else
			{
				$_POST[$folderName] =  $this->upload->data();
		        if(!is_dir(file_upload_s3_path().'institute/'.$folderName.'/thumbs/'))
				{
					mkdir(file_upload_s3_path().'institute/'.$folderName.'/thumbs/', 0777, TRUE);
				}
		        $config['image_library'] = 'gd2';
				$config['source_image'] = file_upload_s3_path().'institute/'.$folderName.'/'.$_POST[$folderName]['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				/*if($folderName == 'coverImage')
				{
					$config['width']=1300;
					$config['height']=259;
				}
				else
				{*/
					$config['width'] = $width;
					$config['height'] = $height;
				/*}*/
				
				$config['new_image'] = file_upload_s3_path().'institute/'.$folderName.'/thumbs/'.$_POST[$folderName]['file_name'];
				if($folderName != 'coverImage')
				{ 
					$this->modelbasic->uniResize($config['source_image'], $config['new_image'], $width, $height, $quality = 100, $wmsource = false);
				}
				if($folderName == 'coverImage')
				{
					$this->modelbasic->ImageCropMaster('300','200',file_upload_s3_path().'institute/'.$folderName.'/'.$_POST[$folderName]['file_name'],file_upload_s3_path().'institute/'.$folderName.'/thumbs/'.$_POST[$folderName]['file_name']);

				}

				return true;
			}
		}


		if(isset($_POST['instituteId'])&&$_POST['instituteId'] > 0)
		{
			return true;
		}
	    else
		{
			$this->form_validation->set_message($functionName,'Image required');
			return false;
		}

	}

	function validatepageName()
	{
		$pageName=$this->input->post('pageName',TRUE);
		$instituteId=$this->input->post('instituteId',TRUE);
		$val=$this->modelbasic->getValueWhere('institute_master','pageName',array('id !='=>$instituteId,'pageName'=>$pageName));
		if($val <> '')
		{
			$this->form_validation->set_message('validatepageName', 'Display name is already used, use unique display name.');
			return false;
		}
		else
		{
			return true;
		}
	}

	function validateAdminEmail()
	{
		if(!isset($_POST['adminId']) || $_POST['adminId'] == 0 || $_POST['adminId'] == " ")
		{
			$this->form_validation->set_message('validateAdminEmail', 'Please select admin email from dropdown.');
			return false;
		}
		else
		{
			return true;
		}
	}


	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Institute created successfully.');
			redirect(base_url().'admin/institutes/');
		}
		else
		{
			$this->session->set_flashdata('success','Institute updated successfully.');
			redirect(base_url().'admin/institutes/');
		}
	}

	function getEditFormData()
	{
		$instituteId=$this->input->post('instituteId',true);
		$data=$this->institute_model->getEditFormData($instituteId);
		$data['adminEmail']= $data["email"];
		echo json_encode($data);
	}
		function getZoneRegionList()
		{		
			$zoneId = $_POST['zoneId'];
			$instituteId = $_POST['instituteId'];
			if($instituteId != 0 )
			{
				$getSelectedRegion = $this->modelbasic->getSelectedData('institute_master','region',array('id'=>$instituteId));
			}
			$data = $this->modelbasic->getSelectedData('region_list','*',array('zone_id'=>$zoneId));
			if(!empty($data))
			{
				foreach($data as $value)
				{
					?>
					<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedRegion) && $getSelectedRegion[0]['region'] ==$value['id']){ echo "selected"; }?>><?php echo $value['region_name'];?> </option>
					<?php
				}
			}
			else
			{
				echo '';
			}		
		}
	}
