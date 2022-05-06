<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Users extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/user_model');
	    if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
	}

	public function index()
	{
		$data['institute'] = $this->user_model->getAllInstitute();
		$this->load->view('admin/users/manage_users',$data);
	}

	function get_ajaxdataObjects($institute='')
	{	
		if($institute == '')
        {
              $institute = $this->session->userdata('instituteId');
        }

		$_POST['columns']='id,user_name,email,profileImage,created,status,job_status,disk_space,teachers_status,admin_level';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns="id,CONCAT(firstName, ' ', lastName) as user_name,email,profileImage,created,status,job_status,disk_space,alumniFlag,instituteId,teachers_status,admin_level";
		//print_r($columns);die;
		//get total number of data without any condition and search term
		$totalData=$this->user_model->count_all_only('users');
		$totalFiltered=$totalData;

		//pass concatColumns only if you want search field to be fetch from concat
		$concatColumns='firstName,lastName';
			$result=$this->user_model->run_query('users',$requestData,$columns,$selectColumns,$concatColumns,'user_name',$institute);
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
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';

					$nestedData['id'] =$i+$requestData['start'];
					if($row["user_name"] <> ' ')
					{
						$userName = ucwords($row["user_name"]);
					}
					else
					{
						$userName = ucwords('No Name');
					}

					$nestedData['email'] = $row["email"];

					$profileImage=$row['profileImage'];
					if($profileImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'users/thumbs/'.$profileImage))
						{
							$profileImage = '<img width="50" height="50" src="'.file_upload_base_url().'users/thumbs/'.$profileImage.'">';
						}
						else
						{
							$profileImage = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
						}
					}
					else
					{
						$profileImage = '<img width="50" height="50" src="'.base_url().'backend_assets/img/noimage.jpg">';
					}

					$nestedData['user_name'] = $profileImage.'<br/>'.$userName.'</a><br/>';
					$nestedData['profileImage'] = $profileImage;
					if($this->session->userdata('admin_level')==1){
						$nestedData['diskSpace'] = '<input type="text" class="user'.$i.' " value="'.$row["disk_space"].'" onclick="showUpdateBtn('.$i.');"><span class="label label-success diskSpace" id="user'.$i.'" onclick="changeDiskSpace('.$row["id"].','.$i.');"  style="cursor: pointer; display:none;">Update</span> ';
					}else{
						$nestedData['diskSpace'] = $row["disk_space"];
					}

					$nestedData['usedDiskSpace']=$this->getDiskSpace($row["id"]);

					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));

					if($row["instituteId"] != 0  && $this->session->userdata('admin_level')==2)
				     {
					  $adminId=$this->modelbasic->getValue('institute_master','adminId','id',$row["instituteId"]);
					  $InstituteAdminId=$adminId;
					}
					elseif ($row["instituteId"] != 0)
					{
						$InstituteAdminId=$this->modelbasic->getValue('institute_master','adminId','id',$row["instituteId"]);
					}

					if(isset($adminId) && $row["id"]==$adminId && $this->session->userdata('admin_level')==2)
					{
						if($row['status']==1)
						{
							$nestedData['status']='<span class="label label-success" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Active</span>';

						}
						else
						{
							$nestedData['status']='<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';

						}
						if($row['job_status']==1)
						{
							$nestedData['job_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="job_status" name="job_status" onchange="change_job_status('.$row['id'].')" checked="">';
						}
						else
						{
							$nestedData['job_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="job_status" name="job_status" onchange="change_job_status('.$row['id'].')">';

						}
						if($row['teachers_status']==1)
						{
							$nestedData['teachers_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="teachers_status" name="teachers_status" onchange="change_teachers_status('.$row['id'].')" checked="">';
						}
						else
						{
							$nestedData['teachers_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="teachers_status" name="teachers_status" onchange="change_teachers_status('.$row['id'].')">';

						}	

						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>';
					}
					else
					{
						if($row["instituteId"] != 0 && isset($InstituteAdminId) && $InstituteAdminId != $row['id'])
						 {
						 	$institute_remove_btn = '<br /><span class="label label-warning" style="cursor: pointer;" onclick="remove_from_institute('.$row['id'].')">Remove From Institute</span>';


								if($row["status"]==1 && $row["alumniFlag"]==1)
								{
									$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span><br /><span class="label label-danger" style="cursor: pointer;" onclick="change_alumini_status('.$row['id'].')">Alumni</span>'.$institute_remove_btn;
								}
								elseif($row["status"]==1 && $row["alumniFlag"]==0)
								{
									$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span><br /><span class="label label-success" style="cursor: pointer;" onclick="change_alumini_status('.$row['id'].')">Make Alumni</span>'.$institute_remove_btn;
								}
								elseif($row["status"]==0 && $row["alumniFlag"]==1)
								{
									$nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span><br /><span class="label label-danger" style="cursor: pointer;" onclick="change_alumini_status('.$row['id'].')">Alumni</span>'.$institute_remove_btn;
								}
								else
							   {
							       $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span><br /><span class="label label-success" style="cursor: pointer;" onclick="change_alumini_status('.$row['id'].')">Make Alumni</span>'.$institute_remove_btn;
							   }

						 }
						 else
						 {
						 	$institute_remove_btn = '';
						 		if($row["status"]==1 && $row["alumniFlag"]==0)
								{
									$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>'.$institute_remove_btn;
								}
								else
								{
									$nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>'.$institute_remove_btn;
								}
						 }

					    if($row['job_status']==1)
					    {
					    	/*$nestedData['job_status']='<span class="label label-success" onclick="change_job_status('.$row['id'].')" style="cursor: pointer;">On</span>';*/
					    	$nestedData['job_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="job_status" name="job_status" onchange="change_job_status('.$row['id'].')" checked="">';

					    }
					    else
					    {
					    	$nestedData['job_status']='<input type="checkbox" onchange="change_job_status('.$row['id'].')" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="job_status" name="job_status">';

					    }

					    if($row["instituteId"] != 0 )
					    {

						    if($row['teachers_status']==1)
						    {					    	
						    	$nestedData['teachers_status']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="teachers_status" name="teachers_status" onchange="change_teachers_status('.$row['id'].')" checked="">';
						    }
						    else
						    {
						    	$nestedData['teachers_status']='<input type="checkbox" onchange="change_teachers_status('.$row['id'].')" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="teachers_status" name="teachers_status">';
						    }
						}
						else
						{
							$nestedData['teachers_status']='No Access';
						}

						if($row["instituteId"] == 0 )
						{
							if($row['admin_level']==4)
							{					    	
								//$nestedData['admin_level']='<input type="checkbox" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="admin_level" name="admin_level" onchange="change_admin_level('.$row['id'].')" checked="">';
								$nestedData['admin_level']='<span class="label label-warning" onclick="change_admin_level('.$row['id'].',0)" style="cursor: pointer;">User</span><br /><span class="label label-success" onclick="change_admin_level('.$row['id'].',4)" style="cursor: pointer;">Ho admin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',5)" style="cursor: pointer;">RPH</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',1)" style="cursor: pointer;">SuperAdmin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',6)" style="cursor: pointer;">MArketingAdmin</span>';
							}
							else if($row['admin_level']==5)
							{
								$nestedData['admin_level']='<span class="label label-warning" onclick="change_admin_level('.$row['id'].',0)" style="cursor: pointer;">User</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',4)" style="cursor: pointer;">Ho admin</span><br /><span class="label label-success" onclick="change_admin_level('.$row['id'].',5)" style="cursor: pointer;">RPH</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',1)" style="cursor: pointer;">SuperAdmin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',6)" style="cursor: pointer;">MarketingAdmin</span>';
							}
							else if($row['admin_level']==6)
							{
								$nestedData['admin_level']='<span class="label label-warning" onclick="change_admin_level('.$row['id'].',0)" style="cursor: pointer;">User</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',4)" style="cursor: pointer;">Ho admin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',5)" style="cursor: pointer;">RPH</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',1)" style="cursor: pointer;">SuperAdmin</span><br /><span class="label label-success" onclick="change_admin_level('.$row['id'].',6)" style="cursor: pointer;">MarketingAdmin</span>';
							}
							else if($row['admin_level']==1)
							{
								if($row['id']==1)
								{
									$nestedData['admin_level']='<span class="label label-success">SuperAdmin</span><br />';
								}
								else
								{
									$nestedData['admin_level']='<span class="label label-warning" onclick="change_admin_level('.$row['id'].',0)" style="cursor: pointer;">User</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',4)" style="cursor: pointer;">Ho admin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',5)" style="cursor: pointer;">RPH</span><br /><span class="label label-success" onclick="change_admin_level('.$row['id'].',1)" style="cursor: pointer;">SuperAdmin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',6)" style="cursor: pointer;">MarketingAdmin</span>';
								}								
							}
							else
							{
								//$nestedData['admin_level']='<input type="checkbox" onchange="change_admin_level('.$row['id'].')" data-rel="switch" data-size="mini" data-wrapper-class="yellow" id="admin_level" name="admin_level">';
								$nestedData['admin_level']='<span class="label label-success" onclick="change_admin_level('.$row['id'].',0)" style="cursor: pointer;">User</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',4)" style="cursor: pointer;">Ho admin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',5)" style="cursor: pointer;">RPH</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',1)" style="cursor: pointer;">SuperAdmin</span><br /><span class="label label-warning" onclick="change_admin_level('.$row['id'].',6)" style="cursor: pointer;">MarketingAdmin</span>';
							}
						}
						else
						{
							$nestedData['admin_level']='No Access';
						}


					    $nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>';
					}

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
		$this->load->view('admin/users/login_view');
	}

	function multiselect_action()
	{
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];

			//echo "<pre>";print_r($_POST);die;

			foreach ($check as $key => $value) {

				if($_POST['listaction'] == '5'){

					$status = array('job_status'=>0);
					$this->modelbasic->_update('users',$key,$status);
					$email_status = array('new_job'=>0);
					$this->modelbasic->_update_custom('user_email_notification_relation','userId',$key,$email_status);
					$this->session->set_flashdata('success', 'Users\'s show job status deactivated successfully');


				}
				else if($_POST['listaction'] == '4'){

					$status = array('job_status'=>1);
					$this->modelbasic->_update('users',$key,$status);
					$email_status = array('new_job'=>1);
					$this->modelbasic->_update_custom('user_email_notification_relation','userId',$key,$email_status);
					$this->session->set_flashdata('success', 'Users\'s show job status activated successfully');


				}
				else if($_POST['listaction'] == '1'){

					$status = array('status'=>1);
					$this->modelbasic->_update('users',$key,$status);

					$this->session->set_flashdata('success', 'Users\'s activated successfully');


				}else if($_POST['listaction'] == '2'){

					$status = array('status'=>0);
					$this->modelbasic->_update('users',$key,$status);
					$this->session->set_flashdata('success', 'Users\'s deactivated successfully');

				}else
				if($_POST['listaction'] == '3')
				{
			 		//echo $key;die;
			 		$query=$this->modelbasic->getValue('users','profileImage','id',$key);
					$path2 = file_upload_s3_path().'users/';
					$path3 = file_upload_s3_path().'users/thumbs/';
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
			         $user_projects = $this->user_model->getAllUserProject($key);

					  if(!empty($user_projects))
					  {
					  	 foreach($user_projects as $row)
					  	 {
						 	 $this->user_model->deleteProject($row['id']);
						 }
					  }
					  $user_projects_deleted = $this->user_model->getAllUserProjectDeleted($key);

					  if(!empty($user_projects_deleted))
					  {
					  	 foreach($user_projects_deleted as $row_del)
					  	 {
						 	 $this->user_model->deleteProjectDeleted($row_del['id']);
						 }
					  }

					  /*$user_comments = $this->user_model->getUserComments($user_id);
					  if(!empty($user_comments))
					  {
					  	 foreach($user_comments as $val)
					  	 {
					  	 	 $this->user_model->commentCountDecrement($val['projectId']);
						 	 $this->modelbasic->_delete_with_condition('user_project_comment','id',$val['id']);
						 }
					  }*/

		 			/*  $this->modelbasic->_delete_with_condition('blog_comment','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_master','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_rating','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_team','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_project_comment','userId',$key);
		 			  //$this->modelbasic->_delete_with_condition('user_project_views','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_login_details','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_email_notification_relation','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_activity_master','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_master_deleted','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_attribute_value_rating','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('institute_user_history','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('job_user_notification','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_appreciation','appreciatedUserId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_appreciation','appreciateByUserId',$key);
		 			  $this->modelbasic->_delete_with_condition('project_image_rating_like','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('social_link','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('users_award','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('users_education','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('users_skills','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('users_work','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('user_web_reference','user_id',$key);
		 			  $this->modelbasic->_delete_with_condition('user_follow','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_follow','followingUser',$key);
		 			  $this->modelbasic->_delete_with_condition('user_myboard','myboardUser',$key);
				      $this->modelbasic->_delete('users',$key);
				      $this->session->set_flashdata('success', 'Users\'s deleted successfully');*/

				      $email=$this->modelbasic->getValue('users','email','id',$key);

				      $csv_user_id=$this->modelbasic->getValue('institute_csv_users','id','email',$email);

				      if(isset($email) && $email !='')
				      {
				      	$this->modelbasic->_delete_with_condition('institute_csv_users','email',$email);
				      }
				      if(isset($csv_user_id) && $csv_user_id !='')
				      {
				      	$this->modelbasic->_delete_with_condition('student_membership','csvuserId',$csv_user_id);
				      }

				      //	$res = $this->modelbasic->_delete('users',$user_id);
				      	$status = array('status'=>0,'instituteId'=>0);
				      	$res = $this->modelbasic->_update('users',$key,$status);
		      		  if($res == 1)
		      		  {
		      		  	$this->session->set_flashdata('success', 'User deleted successfully');
		      	      }
		      		  else
		      		  {
		      		  	$this->session->set_flashdata('fail', 'Fail to delete user');
		      		  }	      


				}

			}

			redirect('admin/users');
		}
	}

	public function delete_confirm($user_id)
	{
		    $query=$this->modelbasic->getValue('users','profileImage','id',$user_id);
			$path2 = file_upload_s3_path().'users/';
			$path3 = file_upload_s3_path().'users/thumbs/';
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
		  $user_projects = $this->user_model->getAllUserProject($user_id);

		  if(!empty($user_projects))
		  {
		  	 foreach($user_projects as $row)
		  	 {
			 	 $this->user_model->deleteProject($row['id']);
			 }
		  }
		  //user_project_views;
		  $user_comments = $this->user_model->getUserComments($user_id);
		  if(!empty($user_comments))
		  {
		  	 foreach($user_comments as $val)
		  	 {
		  	 	 $this->user_model->commentCountDecrement($val['projectId']);
			 	 $this->modelbasic->_delete_with_condition('user_project_comment','id',$val['id']);
			 }
		  }

		 /* $this->modelbasic->_delete_with_condition('user_follow','userId',$user_id);
		  $this->modelbasic->_delete_with_condition('job_user_notification','userId',$user_id);
		  $this->modelbasic->_delete_with_condition('user_project_views','userId',$user_id);*/

		  $email=$this->modelbasic->getValue('users','email','id',$user_id);

		  $csv_user_id=$this->modelbasic->getValue('institute_csv_users','id','email',$email);

		  if(isset($email) && $email !='')
		  {
		  	$this->modelbasic->_delete_with_condition('institute_csv_users','email',$email);
		  }
		  if(isset($csv_user_id) && $csv_user_id !='')
		  {
		  	$this->modelbasic->_delete_with_condition('student_membership','csvuserId',$csv_user_id);
		  }

		  //	$res = $this->modelbasic->_delete('users',$user_id);
		  $status = array('status'=>0,'instituteId'=>0);
		  	$res = $this->modelbasic->_update('users',$user_id,$status);

		  if($res == 1)
		  {
		  	$this->session->set_flashdata('success', 'User deleted successfully');
	      }
		  else
		  {
		  	$this->session->set_flashdata('fail', 'Fail to delete user');
		  }
		  redirect('admin/users');
 	}


	public function remove_from_institute($user_id)
	{
		  $instituteId=$this->modelbasic->getValue('users','instituteId','id',$user_id);

		  if($instituteId!='')
		  {
		  	 $det = array('instituteId'=>0);
			 $res = $this->modelbasic->_update('users',$user_id, $det);

		  	  if($res)
			  {
			  	 $email=$this->modelbasic->getValue('users','email','id',$user_id);
			  	 $this->modelbasic->_delete_with_condition('institute_csv_users','email',$email);
			  	 $this->modelbasic->_insert('institute_user_history',array('instituteId'=>$instituteId,'userId'=>$user_id,'created'=>date('Y-m-d H:i:s')));

			  	 $projects = $this->user_model->user_selective_projects('project_master',$user_id,3);
			 	  if(!empty($projects))
					{
						foreach($projects as $row)
						{
							$det = array('status'=>0);
							$this->modelbasic->_update('project_master',$row['id'], $det);
						}
					}
				 $this->session->set_flashdata('success', 'User removed successfully');
		      }
			  else
			  {
			  	$this->session->set_flashdata('fail', 'Fail to remove user');
			  }
		  }
	      redirect('admin/users');
 	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('users','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>0);
			$this->session->set_flashdata('success', 'User deactivated successfully.');

		}else if($result == 0)
		{
			$data = array('status'=>1);
			$this->session->set_flashdata('success', 'User activated successfully.');
		}
		$this->modelbasic->_update('users',$id, $data);
		redirect('admin/users');
	}

	function change_job_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('users','job_status','id',$id);
		if($result == 1)
		{
			$data = array('job_status'=>0);
			$email_status = array('new_job'=>0);
			$this->modelbasic->_update_custom('user_email_notification_relation','userId',$id,$email_status);
			$this->session->set_flashdata('success', 'Users job display status deactivated successfully.');

		}else if($result == 0)
		{
			$data = array('job_status'=>1);
			$email_status = array('new_job'=>1);
			$this->modelbasic->_update_custom('user_email_notification_relation','userId',$id,$email_status);
			$this->session->set_flashdata('success', 'User job display status activated successfully.');
		}
		$this->modelbasic->_update('users',$id, $data);
		redirect('admin/users');
	}


	function change_teachers_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('users','teachers_status','id',$id);
		if($result == 1)
		{
			$data = array('teachers_status'=>0);
			$this->modelbasic->_update('users',$id, $data);
			$this->session->set_flashdata('success', 'Marked As User');
		}
		else
		{
			$data = array('teachers_status'=>1);
			$this->modelbasic->_update('users',$id, $data);
			$this->session->set_flashdata('success', 'Marked As Teacher');
		}		
		redirect('admin/users');
	}


	function change_admin_level($id = NULL,$level = NULL)
	{
		$result = $this->db->select('firstName,lastName,email,password,admin_level')->from('users')->where('id',$id)->get()->row_array();
		$adminData = $this->db->select('id')->from('admin')->where('email',$result['email'])->get()->row_array();		
		//print_r($result);die;
		if($level == 0)
		{
			$data = array('admin_level'=>0);
			$this->modelbasic->_update('users',$id, $data);			
			$this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$adminData['id']);
			$this->modelbasic->_delete_with_condition('admin','id',$adminData['id']);
			$this->session->set_flashdata('success', 'Marked As User');
		}
		else if($level == 4)
		{
			$data = array('admin_level'=>4);
			$this->modelbasic->_update('users',$id, $data);		
			if(!empty($adminData))
			{
				$this->modelbasic->_update('admin',$adminData['id'], array('level'=>'4'));		
			}	
			else
			{
				$this->modelbasic->_insert('admin',array('name'=>$result['firstName'].' '.$result['lastName'],'email'=>$result['email'],'level'=>'4','manage_user'=>'0','status'=>'1','created'=>date('Y-m-d H:i:s')));
			}
			$this->session->set_flashdata('success', 'Marked As Ho Admin');
		}
		else if($level == 5)
		{
			$data = array('admin_level'=>5);
			$this->modelbasic->_update('users',$id, $data);		
				if(!empty($adminData))
				{
					$this->modelbasic->_update('admin',$adminData['id'], array('level'=>'5'));		
				}	
				else
				{
					$this->modelbasic->_insert('admin',array('name'=>$result['firstName'].' '.$result['lastName'],'email'=>$result['email'],'level'=>'5','manage_user'=>'0','status'=>'1','created'=>date('Y-m-d H:i:s')));
				}
			$this->session->set_flashdata('success', 'Marked As RPH');
		}
		else if($level == 1)
		{
			$data = array('admin_level'=>1);
			$this->modelbasic->_update('users',$id, $data);	
			$this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$adminData['id']);	
			if(!empty($adminData))
			{
				$this->modelbasic->_update('admin',$adminData['id'], array('level'=>'1','manage_user'=>'1'));		
			}	
			else
			{	
				$this->modelbasic->_insert('admin',array('name'=>$result['firstName'].' '.$result['lastName'],'email'=>$result['email'],'level'=>'1','manage_user'=>'1','status'=>'1','created'=>date('Y-m-d H:i:s')));
			}
			$this->session->set_flashdata('success', 'Marked As Super Admin');
		}
		else if($level == 6)
		{
			$data = array('admin_level'=>6);
			$this->modelbasic->_update('users',$id, $data);	
			$this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$adminData['id']);	
			if(!empty($adminData))
			{
				$this->modelbasic->_update('admin',$adminData['id'], array('level'=>'6','manage_user'=>'1'));		
			}	
			else
			{	
				$this->modelbasic->_insert('admin',array('name'=>$result['firstName'].' '.$result['lastName'],'email'=>$result['email'],'level'=>'6','manage_user'=>'1','status'=>'1','created'=>date('Y-m-d H:i:s')));
			}
			$this->session->set_flashdata('success', 'Marked As Marketing Admin');
		}		

		redirect('admin/users');
	}


	function change_alumini_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('users','alumniFlag','id',$id);
		if($result == 1)
		{
			$data = array('alumniFlag'=>0);
			$this->session->set_flashdata('success', 'You have successfully make this User as institute user.');

		}else if($result == 0)
		{
			$data = array('alumniFlag'=>1);
			$job=array('job_status'=>1);
			$this->modelbasic->_update('users',$id, $job);
			$email_status = array('new_job'=>1);
			$this->modelbasic->_update_custom('user_email_notification_relation','userId',$id,$email_status);
			$this->session->set_flashdata('success', 'You have successfully make this User as former institute user.');
		}
		$res = $this->modelbasic->_update('users',$id, $data);

		if($res > 0)
		{
			if(isset($data)&&$data['alumniFlag']==1)
			{
				$projects = $this->user_model->user_selective_projects('project_master',$id,3);

				if(!empty($projects))
				{
					foreach($projects as $row)
					{
						$det = array('status'=>0);
						$this->modelbasic->_update('project_master',$row['id'], $det);
					}
				}
			}
		}
		redirect('admin/users');
	}

	function logout()
	{
		$this->session->set_userdata('admin_login', '');
		$this->session->set_userdata('admin_id', '');
		$this->session->set_userdata('name', '');
		$this->session->set_userdata('login_type', '');
		$this->session->set_flashdata('logout_notification', 'logged_out');
		redirect(base_url().'admin/login');
	}

	function exportUsers($today='')
	{
		if($today <> '')
		{
			if($this->session->userdata('admin_level') == 1)
			{
				$today = date("Y-m-d"); 
				$query = $this->db->query("SELECT id,CONCAT(firstName,' ',lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users WHERE DATE(created) LIKE '$today'");
								
				$data = $query->result_array();
				if(!empty($data))
				{
					$i = 0;
							
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

							//$data=$this->user_model->getUserdata();	
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
			}
			else if($this->session->userdata('admin_level') == 4)
			{
				$ins1=$this->modelbasic->getHoadminInstitutes();
				$ins=implode(',', $ins1);
				$today = date("Y-m-d"); 
				$query = $this->db->query('SELECT id,CONCAT(firstName," ",lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users WHERE DATE(created) = DATE(DATE_FORMAT(NOW(),"%Y-%m-%d")) AND instituteId IN ('.$ins.')');
				$data = $query->result_array();
				if(!empty($data))
				{
					$i = 0;
							
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

					//$data=$this->user_model->getUserdata();	
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
			}
			else
			{
						
				$today = date("Y-m-d"); 
				$query = $this->db->query('SELECT id,CONCAT(firstName," ",lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users WHERE DATE(created) = DATE(DATE_FORMAT(NOW(),"%Y-%m-%d")) AND instituteId ='.$this->session->userdata('instituteId'));
								
				$data = $query->result_array();
				//print_r($data);die;
				if(!empty($data))
				{
					$i = 0;
							
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

					//$data=$this->user_model->getUserdata();	
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
			}

		}
		else
		{
			if($this->session->userdata('admin_level') == 1)
			{
				//$today = date("Y-m-d"); 
				$query = $this->db->query("SELECT id,CONCAT(firstName,' ',lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users");
														
				$data = $query->result_array();
				if(!empty($data))
				{
					$i = 0;
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
								
			}
			else if($this->session->userdata('admin_level') == 4)
			{
				$ins1=$this->modelbasic->getHoadminInstitutes();
				$ins=implode(',', $ins1);
				$today = date("Y-m-d"); 
				$query = $this->db->query('SELECT id,CONCAT(firstName," ",lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users WHERE instituteId IN ('.$ins.')');
				$data = $query->result_array();
				if(!empty($data))
				{
					$i = 0;
							
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

					//$data=$this->user_model->getUserdata();	
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
			}
			else
			{

				$today = date("Y-m-d"); 
				$query = $this->db->query('SELECT id,CONCAT(firstName," ",lastName) as name,email,contactNo,address,country,city,profession,company,about_me,experience,education,dob,status,created from users WHERE instituteId ='.$this->session->userdata('instituteId'));
								
				$data = $query->result_array();
				//print_r($data);die;
				if(!empty($data))
				{
					$i = 0;
							
					$this->load->dbutil();
					$this->load->helper('file');
					$path='userdata_'.date('dmY').'.csv';

					//$data=$this->user_model->getUserdata();	
					header('Content-Type: application/excel');
					header('Content-Disposition: attachment; filename="'.$path.'"');
					if(!empty($data))
					{
						$fh = fopen('php://output', 'w');

						fputcsv($fh, array('','','',' User Report . '));		     
						fputcsv($fh, array());	

						fputcsv($fh, array_keys(current($data)));		     
						foreach ( $data as $row ) 
						{
							fputcsv($fh, $row);
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error','Data not avalable to export.');
					redirect('admin/users');
				}
			}
		}
	}

	public function updateDiskSpace(){
		$userId = $_POST['userId'];
		$newSpace = $_POST['newSpace'];
		$result = $this->user_model->updateDiskSpace($userId,$newSpace);
		if($result != false){
			echo $result;die;
		}else{
			echo false;die;
		}
	}

	public function processForm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('institute', 'users', 'required');
		$this->form_validation->set_rules('diskSpace', 'Disk space', 'required');
		if ($this->form_validation->run())
		{


				$instanceId=$this->input->post('institute',true);
				$newDiskSpace=$this->input->post('diskSpace',true);

				$allUser = $this->user_model->getAllInstituteUser($instanceId);
				foreach ($allUser as $val) {
					$newSpace = $val['disk_space']+$newDiskSpace;
					$data = array('disk_space' => $newSpace);
					$res = $this->user_model->_update('users', $val['id'], $data);
				}

				if($res > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Disk space added successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while adding disk space please try again...');
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
				$this->load->view('admin/users/spaceAllocation_view');
			}
		}
	}

	public function processDefaultDiskSpaceAllocationFrm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('diskSpace', 'Disk space', 'required');
		if ($this->form_validation->run())
		{


				$newDiskSpace=$this->input->post('diskSpace',true);
				$data = array('description' => $newDiskSpace);
				$res = $this->user_model->_update2('settings', 14, $data);
				if($res > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Disk space update successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while adding disk space please try again...');
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
				$this->load->view('admin/users/defaultDiskSpace_view');
			}
		}
	}

	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Disk space allocated successfully.');
			redirect(base_url().'admin/users/');
		}
		else
		{
			$this->session->set_flashdata('success','Disk space updated successfully.');
			redirect(base_url().'admin/users/');
		}
	}

	public function getDiskSpace($user_id)
	{
		$size=0;
		$allProject=$this->user_model->getUsersAllProject($user_id);		
		if(!empty($allProject))
		{
			foreach($allProject as $project)
			{
				$allImages=$this->user_model->getAllImages($project['id']);
				if(!empty($allImages))
				{
					foreach($allImages as $image)
					{
						if(file_exists(file_upload_s3_path().'project/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']) && filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']) > 0){
						$size+=filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']);
						}
					}
				}
			}
		}
		$size = number_format($size / 1048576, 2) . ' MB';
		return $size;
	}

}
