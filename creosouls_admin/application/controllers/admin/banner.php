<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Banner extends MY_Controller
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
    	$this->load->model('admin/banner_model');
	}

	public function index()
	{
		$this->load->view('admin/banner/manage_banner');
	}

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

			$totalData=5;

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
						$nestedData['eventDetails'] = $competitionCoverImage;

						//$nestedData['admin_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/><b>User Id: </b>'.$row["userId"].'<br/><b>Status: </b>'.$userStatusHtml.'<br/>';



						//$nestedData['profileImage'] = '<img style="border-radius:50px;cursor: pointer;" width="70" src="'.file_upload_base_url().'institutes/thumbs/'.$row['profileImage'].'">';
						$nestedData['start_date'] = date("d-M-Y", strtotime($row["start_date"]));
						$nestedData['end_date'] = date("d-M-Y", strtotime($row["end_date"]));
						//$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));
						if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';}elseif($row["status"]==0){ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}else{ $nestedData['status'] = '<span class="label label-primary" >Expired</span>';}
						$nestedData['action'] = '<a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a>';
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

		function getEditFormData()
		{
			$eventId=$this->input->post('eventId',true);
			$data=$this->banner_model->getEditFormData($eventId);
			echo json_encode($data);
		}


		public function processForm()
		{
				
				
					$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
					
					
					$this->form_validation->set_rules('banner', 'cover picture', 'callback_image_upload');
					
					/*$this->form_validation->set_rules('csvUsers', 'CSV Users', 'callback_validateCsvUsers');*/
					
					
					if ($this->form_validation->run())
					{
						if($this->input->post('eventId',TRUE) > 0)
						{
							$eventId=$this->input->post('eventId',TRUE);

							
							if(isset($_POST['banner']['file_name']) && $_POST['banner']['file_name'] <> '')
							{
									$data['imageName']='arena_banner_'.$eventId.'.jpg';

									$query=$this->modelbasic->getValue('competitions','banner','id',$eventId);
							 		$path2 = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
							 		
									
									if(!empty($query))
									{
										if(file_exists($path2.$query))
										{
											unlink( $path2 . $query);
										}
										
							        }
							}


							//$this->modelbasic->_update('users',$this->input->post('adminId',TRUE),array('instituteId'=>$instituteId));
							$res=$this->modelbasic->_update('banner',$eventId,$data);

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
								$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
									
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
										$this->modelbasic->sendNotification($val['id'],$msg);
									}
								}
							}
							else
							{
								$data=array('status'=>'fail','message'=>'Error occurred while creating banner please try again....');
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
		function setFlashdata($function)
		{
			if($function == 'add')
			{
				$this->session->set_flashdata('success','Banner created successfully.');
				redirect(base_url().'admin/banner/');
			}
			else
			{
				$this->session->set_flashdata('success','Banner updated successfully.');
				redirect(base_url().'admin/banner/');
			}
		}
		function validateCoverImage()
		{
			return $this->image_upload('banner','validateCoverImage');
		}

		function image_upload()
		{
			
			if(isset($_FILES['banner']) && $_FILES['banner']['size'] != 0)
			{
				$eventId = $this->input->post('eventId',TRUE);
				$upload_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";
				if (!is_dir($upload_dir))
				{
				     mkdir($upload_dir, 0777, TRUE);
				}
				$config['upload_path']   = $upload_dir;
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name']     = 'arena_banner_'.$eventId;
				$config['max_size']	 = '2000';
				$config['maintain_ratio'] = TRUE;
				/*if($image_width < 960)
				{
					$config['width']=$image_width;
					$config['height']=$image_height;
				}
				else
				{*/
				$config['width'] = 1200;
				$config['height'] = 400;
				/*}*/
				$config['master_dim'] = 'width';
				$config['max_width']  = '1200';
			    $config['max_height']  = '400';
			    $config['overwrite'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('banner'))
				{
					$this->form_validation->set_message('image_upload', $this->upload->display_errors());
					return false;
				}
				else
				{	

					$_POST['banner'] =  $this->upload->data();
			        	
			        $config['image_library'] = 'gd2';
					$config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$_POST['banner']['file_name'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
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
	
}
