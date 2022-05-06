<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Event extends MY_Controller
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
    	$this->load->model('admin/event_model');
	}

	public function index()
	{
		$this->load->view('admin/event/manage_event');
	}

	/*public function getAutocompleteUserData()
	{
		$instituteId=$_POST['instituteId'];
		echo $this->event_model->getAutocompleteUserData($instituteId);
	}*/


	function get_ajaxdataObjects($featured_event='')
	{
		$this->event_model->markCompletedCompetions();

		$_POST['columns']='A.id,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.coupon_code,A.instituteId,A.description'; //userStatus,B.id,B.email,admin_name,
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns="A.id,A.name,A.created,A.status,A.banner,A.end_date,A.start_date,A.coupon_code,A.instituteId,A.description";
		//CONCAT(B.firstName, ' ',B.lastName) as admin_name,B.status as userStatus,B.id as userId,B.email,B.profileImage,
		//print_r($columns);die;
		//get total number of data without any condition and search term
		  if($this->session->userdata('admin_level')==2)
			{
				$condition=array('instituteId'=>$this->session->userdata('instituteId'));
			}
			else
			{
				$condition=array();
			}

		$totalData=$this->modelbasic->count_all_only('events',$condition);

		if($this->session->userdata('admin_level')==2)
		{	
		//echo "2";		
			if($featured_event!='' && $featured_event==1)
			{				
				$totalData     = $this->event_model->count_all_only('events',array('instituteId'=>$this->session->userdata('instituteId'),'featured'=>1),'AND');				
			}
			else
			{
				$totalData     = $this->event_model->count_all_only('events',array('instituteId'=>$this->session->userdata('instituteId')),'AND');
			}		
		}	
		else if($this->session->userdata('admin_level')==1){

		//	echo "1";
			
			if($featured_event!='' && $featured_event==1)
			{	
				$totalData     = $this->event_model->count_all_only('events',array('featured'=>1),'AND');	
			}
			else
			{
				$totalData     = $this->event_model->count_all_only('events','','AND');
			}			
		}
		//die;
		$totalFiltered=$totalData;

		//pass concatColumns only if you want search field to be fetch from concat
		    $concatColumns=''; //B.firstName,B.lastName


		//	$result=$this->event_model->run_query('events',$requestData,$columns,$selectColumns,$concatColumns,''); //admin_name
			//print_r($result);die;

			if($featured_event!='' && $featured_event==1)
			{
				$result=$this->event_model->run_query('events',$requestData,$columns,$selectColumns,'','',$featured_event);							
			}
			else
			{
				$result  = $this->event_model->run_query('events',$requestData,$columns,$selectColumns);		
			}

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


					if($row['status'] == 1)
					{
						$userStatusHtml='<span class="label label-success" style="cursor: auto;">Active</span>';
					}
					else
					{
						$userStatusHtml='<span class="label label-danger" style="cursor: auto;">Deactive</span>';
					}

					/*if($row['admin_name'] == ' ')
					{
						$userName=ucwords('No Name');
					}
					else
					{
						$userName=ucwords($row["admin_name"]);
					}*/

					$competitionCoverImage=$row["banner"];
					//echo $instituteCoverImage;die;

					if($competitionCoverImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'event/banner/thumbs/'.$competitionCoverImage))
						{
							$competitionCoverImage = '<img width="100" height="70" src="'.file_upload_base_url().'event/banner/thumbs/'.$competitionCoverImage.'">';
						}
						else
						{
							$competitionCoverImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/noimage1.png">';
						}
					}
					else
					{
						$competitionCoverImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/noimage1.png">';
					}

					//$competitionLogo=$row["profile_image"];
					//echo $instituteCoverImage;die;
					/*if($competitionLogo <> '')
					{
						if(file_exists(file_upload_absolute_path().'competition/profile_image/thumbs/'.$competitionLogo))
						{
							$competitionLogo = '<img width="160" height="52" src="'.file_upload_base_url().'competition/profile_image/thumbs/'.$competitionLogo.'">';
						}
						else
						{
							$competitionLogo = '<img width="160" height="52" src="'.base_url().'backend_assets/img/noimage1.png">';
						}
					}
					else
					{
						$competitionLogo = '<img width="160" height="52" src="'.base_url().'backend_assets/img/noimage1.png">';
					}*/

					//$profileImage = '<img width="50" height="50" src="'.file_upload_base_url().'users/thumbs/'.$row['profileImage'].'">';
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] =$i+$requestData['start'];
					$nestedData['description'] =$row['description'];
					$nestedData['eventName'] ='<a target="_blank" href="'.front_base_url().'event/show_event/'.$row["id"].'">'.$row["name"].'</a>';
					$nestedData['eventDetails'] = '<b>Event Id: </b>'.$row["id"].'<br/><b>Cover Image: </b>'.$competitionCoverImage.'<br/><b>Coupon Code: </b>'.$row["coupon_code"];

					//$nestedData['admin_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/><b>User Id: </b>'.$row["userId"].'<br/><b>Status: </b>'.$userStatusHtml.'<br/>';



					//$nestedData['profileImage'] = '<img style="border-radius:50px;cursor: pointer;" width="70" src="'.file_upload_base_url().'institutes/thumbs/'.$row['profileImage'].'">';
					$nestedData['start_date'] = date("d-M-Y", strtotime($row["start_date"]));
					$nestedData['end_date'] = date("d-M-Y", strtotime($row["end_date"]));
					//$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));
					if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';}elseif($row["status"]==0){ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}else{ $nestedData['status'] = '<span class="label label-primary" >Expired</span>';}
					$nestedData['action'] = '<a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a><a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a>';
					$data[] = $nestedData;
					$i++;
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

				if($_POST['listaction'] == '1')
				{
					$status = array('status'=>'1');
					$this->modelbasic->_update('events',$key,$status);
					$this->session->set_flashdata('success', 'Events activated successfully');

				}else if($_POST['listaction'] == '2')
				{
					$status = array('status'=>'0');
					$this->modelbasic->_update('events',$key,$status);
					$this->session->set_flashdata('success', 'Events deactivated successfully');
				}
				else if($_POST['listaction'] == '3')
				{
				 		$query=$this->modelbasic->getValue('events','banner','id',$key);
				 		$path2 = file_upload_s3_path().'event/banner/';
						$path3 = file_upload_s3_path().'event/banner/thumbs/';
						if(!empty($query))
						{
							if(file_exists($path2.$query))
							{
								unlink( $path2 . $query);
							}
							if(file_exists($path3.$query)) {
								unlink( $path3 . $query);
							}
				        }

	        	 		/*$query=$this->modelbasic->getValue('competitions','profile_image','id',$key);
	        			$path2 = file_upload_s3_path().'competition/profile_image/';
	        			$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';
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
		            	}*/

			           // $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));
				        $this->modelbasic->_delete('events',$key);
				        $this->session->set_flashdata('success', 'Events deleted successfully');
				}

			else if($_POST['listaction'] == '4')
			{
				$status = array('featured'=>'1');
				$this->modelbasic->_update('events',$key,$status);
 				$this->session->set_flashdata('success', 'Jobs\'s successfully make featured');
			}
			else if($_POST['listaction'] == '5')
			{
				$status = array('featured'=>'0');
				$this->modelbasic->_update('events',$key,$status);
 				$this->session->set_flashdata('success', 'Jobs\'s successfully make Unfeatured');
			}

			}

			redirect('admin/event');
		}
	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('events','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>'0');
			$this->session->set_flashdata('success', 'Events deactivated successfully.');
	    }
		else
		if($result == 0)
		{
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Events activated successfully.');
		}
		$this->modelbasic->_update('events',$id, $data);
		redirect('admin/event');
	}


	function delete_confirm($key = NULL)
	{
			$query=$this->modelbasic->getValue('events','banner','id',$key);
	 		$path2 = file_upload_s3_path().'event/banner/';
			$path3 = file_upload_s3_path().'event/banner/thumbs/';
			if(!empty($query))
			{
				if(file_exists($path2.$query))
				{
					unlink( $path2 . $query);
				}
				if (file_exists($path3.$query)) {
					unlink( $path3 . $query);
				}
	        }

 		/*$query=$this->modelbasic->getValue('competitions','profile_image','id',$key);
		$path2 = file_upload_s3_path().'competition/profile_image/';
		$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';
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
        	}*/

           // $this->modelbasic->_update_custom('users','instituteId',$key,array('instituteId'=>0));
	        $this->modelbasic->_delete('events',$key);
	        $this->session->set_flashdata('success', 'Events deleted successfully');
	        redirect('admin/event');
	}






	public function processForm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Competition name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('end_date', 'End Date', 'required');
		
		/*if($this->input->post('instituteId',TRUE) > 0)
		{
			$this->form_validation->set_rules('pageName', 'Institute page display name', 'required|alpha_numeric|callback_validatepageName');
		}
		else
		{
			$this->form_validation->set_rules('pageName', 'Institute page display name', 'required|alpha_numeric|is_unique[institute_master.pageName]');
		}*/

		//$this->form_validation->set_rules('profile_image', 'Competition logo', 'callback_validateCompetitionLogo');
		
		$this->form_validation->set_rules('banner', 'cover picture', 'callback_image_upload');
		
		/*$this->form_validation->set_rules('csvUsers', 'CSV Users', 'callback_validateCsvUsers');*/
		
		if(!empty($this->input->post("videolink")))
		{
			$videoLinkArr = explode("watch?v=",$this->input->post("videolink"));
			$videoLink1    = explode("&feature=youtu.b", $videoLinkArr[1]);
			$videoLink=$videoLink1[0];
		}
		else
		{
			$videoLink = '';
		}
		if ($this->form_validation->run())
		{
			if($this->input->post('eventId',TRUE) > 0)
			{
				$eventId=$this->input->post('eventId',TRUE);

				$data=array('name'=>$this->input->post('name',TRUE),'description'=>$this->input->post('description',TRUE),'coupon_code'=>$this->input->post('coupon_code',TRUE),'start_date'=>date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),'end_date'=>date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),'created'=>date('Y-m-d H:i:s'),'status'=>1,'link'=>$this->input->post('link',TRUE),'videolink'=>$videoLink);

				/*if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{
					$data['profile_image']=$_POST['profile_image']['file_name'];

					$query=$this->modelbasic->getValue('competitions','profile_image','id',$eventId);
					$path2 = file_upload_s3_path().'competition/profile_image/';
					$path3 = file_upload_s3_path().'competition/profile_image/thumbs/';
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
				}*/

				if(isset($_POST['banner']['file_name']) && $_POST['banner']['file_name'] <> '')
				{
					$data['banner']=$_POST['banner']['file_name'];

						$query=$this->modelbasic->getValue('competitions','banner','id',$eventId);
				 		$path2 = file_upload_s3_path().'event/banner/';
						$path3 = file_upload_s3_path().'event/banner/thumbs/';
						if(!empty($query))
						{
							if(file_exists($path2.$query))
							{
								unlink( $path2 . $query);
							}
							if(file_exists($path3.$query)) {
								unlink( $path3 . $query);
							}
				        }
				}


				//$this->modelbasic->_update('users',$this->input->post('adminId',TRUE),array('instituteId'=>$instituteId));
				$res=$this->modelbasic->_update('events',$eventId,$data);

				//$adminData=$this->modelbasic->get_where('users',$this->input->post('adminId',TRUE))->row_array();
				//$emailExists=$this->modelbasic->getValue('institute_csv_users','email','email', $adminData['email']);
			/*	if($emailExists == '')
				{
					$this->modelbasic->_insert('institute_csv_users',array('instituteId'=>$instituteId,'firstName'=>$adminData['firstName'],'lastName'=>$adminData['lastName'],'email'=>$adminData['email'],'contactNo'=>$adminData['contactNo']));
				}*/
				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'Event updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating event please try again....');
				}
			}
			else
			{
			
				$data=array('name'=>$this->input->post('name',TRUE),'description'=>$this->input->post('description',TRUE),'coupon_code'=>$this->input->post('coupon_code',TRUE),'start_date'=>date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),'end_date'=>date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),'created'=>date('Y-m-d H:i:s'),'status'=>1,'link'=>$this->input->post('link',TRUE),'videolink'=>$videoLink);
				/*if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{
					$data['profile_image']=$_POST['profile_image']['file_name'];
				}*/

				if(isset($_POST['banner']['file_name']) && $_POST['banner']['file_name'] <> '')
				{
					$data['banner']=$_POST['banner']['file_name'];
				}

				  if($this->session->userdata('admin_level')==2)
					{
						$data['userId']= $this->session->userdata('admin_id');
						$data['instituteId']= $this->session->userdata('instituteId');
					}
					else
					{
						$data['userId']= $this->session->userdata('admin_id');
						$data['instituteId']= 0;
					}

				$eventId=$this->modelbasic->_insert('events',$data);

	    		if($eventId > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Event added successfully.');
					$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
					/*	$adminEmail=$this->modelbasic->getValue('users','email','id',$this->input->post('adminId',TRUE));*/
					//$adminEmail='santoshbadal1111@gmail.com';
					/*	$adminName=$this->modelbasic->getValue('users','firstName','id',$this->input->post('adminId',TRUE));
						$emailTo=$adminEmail;
						$from=$emailFrom;

						$templateInstituteEmail='Hello <b>'.$adminName. '</b>,<br />New institute "<b>'.$this->input->post('instituteName',TRUE).'</b>" is created on creosouls .<br /><a href="'.front_base_url().'institute/instituteDetails/'.$instituteId.'">Click here</a>  to view the institute details.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$emailJobDetail=array('to'=>$emailTo,'subject'=>'New institute created on creosouls','template'=>$templateInstituteEmail,'fromEmail'=>$from);
						$this->modelbasic->sendMail($emailJobDetail);*/

					//$userData=$this->event_model->getAllUser_SPCIFIC();
					$userData=$this->modelbasic->getAllUser();
					//echo $this->db->last_query();
					$notificationEntry=array('title'=>'New event posted','msg'=>'New event '.ucwords($this->input->post('name')).' posted in creosouls.','link'=>'event/show_event/'.$eventId,'imageLink'=>'event/banner/'.$_POST['banner']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>2,'redirectId'=>$eventId);
					//$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
						
					if(!empty($userData))
					{
						foreach($userData as $val)
						{

							$notificationToCreUser=array('notification_id'=>$notificationId,'user_id'=>$val['id']);
							$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);
							$msg = array (
								'body' 	=> '',
								'title'	=> '',
								'aboutNotification'	=>ucwords($this->input->post('name',TRUE)),
								'notificationTitle'	=> 'New Event Posted',
								'notificationType'	=> 2,
								'notificationId'	=> $eventId,
								'notificationImageUrl'	=> ''          	
					        );
							//$this->modelbasic->sendNotification($val['id'],$msg);
						}
					}
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while creating event please try again....');
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
				$this->load->view('admin/event/addedit_view');
			}
		}
	}

	/*function validateCompetitionLogo()
	{
		return $this->image_upload('profile_image','validateCompetitionLogo','160','52');
	}*/

	function validateCoverImage()
	{
		return $this->image_upload('banner','validateCoverImage');
	}


	/*function validateCsvUsers()
	{
		$folderName='csvUsers';
		if($_FILES[$folderName]['size'] != 0)
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
*/
	function image_upload()
	{
		
		if(isset($_FILES['banner']) && $_FILES['banner']['size'] != 0)
		{
			
			$upload_dir = file_upload_s3_path().'event/banner/';
			if (!is_dir($upload_dir))
			{
			     mkdir($upload_dir, 0777, TRUE);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = 'banner_'.substr(md5(rand()),0,7);
			$config['max_size']	 = '2000';
			$config['maintain_ratio'] = TRUE;
			/*if($image_width < 960)
			{
				$config['width']=$image_width;
				$config['height']=$image_height;
			}
			else
			{*/
				$config['width'] = 690;
				$config['height'] = 300;
			/*}*/
			$config['master_dim'] = 'width';
			$config['max_width']  = '690';
		    $config['max_height']  = '300';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('banner'))
			{
				$this->form_validation->set_message('image_upload', $this->upload->display_errors());
				return false;
			}
			else
			{				
				$_POST['banner'] =  $this->upload->data();
		        	if(!is_dir(file_upload_s3_path().'event/banner/thumbs'))
				{
					mkdir(file_upload_s3_path().'event/banner/thumbs', 0777, TRUE);
				}
		        	$config['image_library'] = 'gd2';
				$config['source_image'] = file_upload_s3_path().'event/banner/'.$_POST['banner']['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 230;
				$config['height'] = 100;
				$config['new_image'] = file_upload_s3_path().'event/banner/thumbs/'.$_POST['banner']['file_name'];
				$this->image_lib->initialize($config);
				$return = $this->image_lib->resize();
				$this->image_lib->clear();

				return true;
			}
		}
		
		if(isset($_POST['eventId'])&&$_POST['eventId'] > 0)
		{
			return true;
		}
	    else
		{		
			$this->form_validation->set_message('image_upload','Image required');
			return false;
		}
			
	}

	/*function validatepageName()
	{
		$pageName=$this->input->post('pageName',TRUE);
		$instituteId=$this->input->post('instituteId',TRUE);
		$val=$this->modelbasic->getValueWhere('institute_master','pageName',array('id !='=>$instituteId,'pageName'=>$pageName));
		if($val <> '')
		{
			$this->form_validation->set_message('validatepageName', 'Display name is already in use use unique display name.');
			return false;
		}
		else
		{
			return true;
		}
	}*/


	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Event created successfully.');
			redirect(base_url().'admin/event/');
		}
		else
		{
			$this->session->set_flashdata('success','Event updated successfully.');
			redirect(base_url().'admin/event/');
		}
	}

	function getEditFormData()
	{
		$eventId=$this->input->post('eventId',true);
		$data=$this->event_model->getEditFormData($eventId);
		echo json_encode($data);
	}
	
	public function sendGcmToken($userId,$msg)
	{
		 $API_ACCESS_KEY='AIzaSyCAVHevvPy-yAZUbJdRRF2RLf8DTQcDcGw';
		 //$registrationIds = array( $_GET['id'] );
		    $deviceId = $this->modelbasic->getValue('users','deviceId',"id",$userId);	
				
			if(isset($deviceId)&&$deviceId!='')
			{
			    $gcmToken = $this->modelbasic->getValue('gcm','gcmToken',"deviceId",$deviceId);
				
				if(isset($gcmToken)&& $gcmToken!='')
				{
					// prep the bundle
						/*$msg = array
						(
							'message' 	=> 'here is a message. message',
							'title'		=> 'This is a title. title',
							'subtitle'	=> 'This is a subtitle. subtitle',
							'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
							'vibrate'	=> 1,
							'sound'		=> 1,
							'largeIcon'	=> 'large_icon',
							'smallIcon'	=> 'small_icon'
						);*/

						/*    int type,
						    int notificationId,
						    int notificationType,
						    String notificationTitle,
						    String notificationMessage,
						    String notificationImageUrl,*/

						//	print_r($msg);
						  $gcmId = array($gcmToken);
							
						
						$fields = array
						(
							'registration_ids' 	=> $gcmId,
							'data'			=>  array('default'=>$msg)
						);
						
						//print_r($fields);die;
						 
						$headers = array
						(
							'Authorization: key=' . $API_ACCESS_KEY,
							'Content-Type: application/json'
						);
						 
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
						$result = curl_exec($ch );
						curl_close( $ch );
						//echo $result;die;
				}				
			}	
	       return;			
	}
}
