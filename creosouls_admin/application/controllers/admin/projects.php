<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Projects extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/project_model');
	}

	public function index()
	{
		$data['institute'] = $this->modelbasic->getAllInstitute();
		$data['category'] = $this->modelbasic->getAllCategory();
		$this->load->view('admin/projects/manage_projects',$data);
	}

	function get_ajaxdataObjects($featured='',$featured_project='',$ins_flag='',$ins_val='',$cat_flag='',$cat_val='',$startDate_flag='',$startDate_val='',$endDate_flag='',$endDate_val='',$statusfalg='',$statusval='')
	{		
		$_POST['columns']='A.id,A.userId,A.projectName,user_name,C.categoryName,A.created,A.status,userStatus,B.profileImage,D.instituteName';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns="A.id,A.userId,A.projectName,A.withoutCover,CONCAT(B.firstName, ' ',B.lastName) as user_name,C.categoryName,A.created,A.status,B.status as userStatus,B.profileImage,A.admin_status,A.featured,B.instituteId,A.assignmentId,D.instituteName";
		//print_r($columns);die;
		if($this->session->userdata('admin_level')==2) 
		{
			$totalData=$this->project_model->count_of_institute_project($featured,$featured_project,$ins_flag,$ins_val,$cat_flag,$cat_val,$startDate_flag,$startDate_val,$endDate_flag,$endDate_val,$statusfalg,$statusval);

		}
		elseif($this->session->userdata('admin_level')==4) 
		{
			
			$totalData=$this->project_model->count_of_institute_project($featured,$featured_project,$ins_flag,$ins_val,$cat_flag,$cat_val,$startDate_flag,$startDate_val,$endDate_flag,$endDate_val,$statusfalg,$statusval);

		}
		else
		{
			$totalData=$this->project_model->count_all_only($featured,$featured_project,$ins_flag,$ins_val,$cat_flag,$cat_val,$startDate_flag,$startDate_val,$endDate_flag,$endDate_val,$statusfalg,$statusval);
			
		}

		//print_r($totalData);die;
		$totalFiltered=$totalData;
		//pass concatColumns only if you want search field to be fetch from concat
		$concatColumns='B.firstName,B.lastName';

		
			$result=$this->project_model->run_query('project_master',$requestData,$columns,$selectColumns,$concatColumns,'user_name',$featured,$featured_project,$ins_flag,$ins_val,$cat_flag,$cat_val,$startDate_flag,$startDate_val,$endDate_flag,$endDate_val,$statusfalg,$statusval);		
		//echo $this->db->last_query();die;	

		
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
					if($row['userStatus'] == 1)
					{
						$userStatusHtml='<span class="label label-success" style="cursor: auto;">Active</span>';
					}
					else
					{
						$userStatusHtml='<span class="label label-danger" style="cursor: auto;">Deactive</span>';
					}

					if($row['user_name'] == ' ')
					{
						$userName=ucwords('No Name');
					}
					else
					{
						$userName=ucwords($row["user_name"]);
					}
					$withoutCover = $row['withoutCover'];
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

					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] =$i+$requestData['start'];
					$assignmentIdFlag = '';
					if($row['assignmentId'] !=0)
					{
						$assignmentIdFlag = '<span class="label label-info" style="cursor: auto;">Assignment Project</span>';
					}
					$nestedData['projectName'] = '<b>Project Id: </b>'.$row["id"].'<br/><a target="_blank" href="'.front_base_url().'project/projectDetail/'.$row["id"].'/'.$row["userId"].'">'.$row["projectName"].'</a><br />'.$assignmentIdFlag;

					$nestedData['user_name'] = $profileImage.'<br/><a target="_blank" href="'.front_base_url().'user/userDetail/'.$row["userId"].'">'.$userName.'</a><br/><b>User Id: </b>'.$row["userId"].'<br/><b>Status: </b>'.$userStatusHtml.'<br/>';
					$nestedData['categoryName'] = $row["categoryName"];
					$nestedData['InstituteName'] = $row["instituteName"];

					$projectCoverImage=$this->project_model->getProjectCoverImage($row['id']);
					//echo $projectCoverImage;die;
					if($withoutCover == 1){
					if($projectCoverImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'project/thumbs/'.$projectCoverImage))
						{
							$nestedData['projectCoverImage'] = '<img width="100" height="75" src="'.file_upload_base_url().'project/thumbs/'.$projectCoverImage.'">';
						}
						else
						{
							$nestedData['projectCoverImage'] = '<img width="100" height="75" src="'.base_url().'backend_assets/img/noimage.png">';
						}
					}
					else
					{
						$nestedData['projectCoverImage'] = '<img width="100" height="75" src="'.base_url().'backend_assets/img/noimage.png">';
					}
					}else{
						$nestedData['projectCoverImage'] = '<img width="100" height="75" src="'.base_url().'backend_assets/img/video-logo.jpg">';
					}
					//$nestedData['profileImage'] = '<img style="border-radius:50px;cursor: pointer;" width="70" src="'.file_upload_base_url().'projects/thumbs/'.$row['profileImage'].'">';					
					if($row["featured"]==1)
					{
						$featured = '<span class="label label-info" >Featured</span>';
					}
					else{
						$featured = '';
					}
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"])).'<br>'.$featured;
					
					if($row["status"]==1)
					{
						$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Public</span>';
					}
					elseif($row["status"]==0)
					{
						$nestedData['status'] = '<span class="label label-danger" >Draft</span>';
					}
					elseif ($row['status'] == 2)
					{
						$nestedData['status'] = '<span class="label label-danger" style="cursor: default;">Incomplete</span>';
					}
					elseif ($row['status'] == 3)
					{
						if(isset($row['admin_status']) && $row['admin_status'] == '')
						{
							$nestedData['status'] = '<span class="label label-primary" onclick="make_public('.$row['id'].')" style="cursor: pointer;">Private</span>';
						}
						else
						{
							$nestedData['status'] = '<span class="label label-warning" onclick="make_public('.$row['id'].')" style="cursor: pointer;">Pending Admin Approval</span>';
						}
					}

					$nestedData['action'] = '<a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a><a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>';
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
		$this->load->view('admin/projects/addedit_view');
	}

	function multiselect_action()
	{
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];

			//echo "<pre>";print_r($_POST);die;

			foreach ($check as $key => $value) {

				if($_POST['listaction'] == '1')
				{

					$project_id = $this->modelbasic->getValue('project_master','id','id',$key);
					if($project_id > 0)
					{
						$status = array('status'=>'1','admin_status'=>'');
						$this->session->set_flashdata('success', 'Project\'s  public successfully.');
						$this->modelbasic->_update('project_master',$key,$status);
					}

				}else if($_POST['listaction'] == '2'){					
					$status = array('status'=>'3');
					$this->modelbasic->_update('project_master',$key,$status);
     				$this->session->set_flashdata('success', 'Project\'s  private successfully');			
				}
				else if($_POST['listaction'] == '3')
				{
					/*				 		$query=$this->modelbasic->getValue('project_master','profileImage','id',$key);
						$path2 = file_upload_s3_path().'projects/';
						$path3 = file_upload_s3_path().'projects/thumbs/';
						if(!empty($query)){
				        	unlink( $path2 . $query);
				        	unlink( $path3 . $query);
				        }
				        $this->modelbasic->_delete($key);*/
				        $projectStatus=$this->modelbasic->getValueArray('project_master','status',array('id'=>$key));
				        if($projectStatus !=2)
				        {
				        	$userId=$this->modelbasic->getValueArray('project_master','userId',array('id'=>$key));
				        	$userEmail=$this->db->select('email,firstName,lastName')->from('users')->where('id',$userId)->get()->row_array();
				        	$projectName=$this->modelbasic->getValueArray('project_master','projectName',array('id'=>$key));
				        	if($projectStatus==0)
				        	{
				        		$status='Draft';
				        	}
				        	if($projectStatus==1)
				        	{
				        		$status='Public';
				        	}
				        	if($projectStatus==3)
				        	{
				        		$status='Private';
				        	}
				        }

				        $emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				        if($projectStatus !=2)
				        {
				        	$template    = 'Hello ,'.$userEmail['firstName'].' '.$userEmail['lastName'].'<br />Your project "<b>' .$projectName.'</b>" is deleted by Admin / Institute Admin from creosouls. <br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				        	$sendEmailToOwner = array('to'=>$userEmail,'subject'=>'Your project deleted','template' =>$template,'fromEmail'=>$emailFrom);
				        	//$this->modelbasic->sendMail($sendEmailToOwner);
				        }
				        $res = $this->project_model->deleteProject($key);
				        $this->session->set_flashdata('success', 'Project\'s deleted successfully');
				        if($projectStatus !=2)
				        {
				        	$template    = 'Hello ,'.$userEmail['firstName'].' '.$userEmail['lastName'].'<br />Your project "<b>' .$projectName.'</b>" is deleted by Admin / Institute Admin from creosouls. <br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				        	$sendEmailToOwner = array('to'=>$userEmail,'subject'=>'Your project deleted','template' =>$template,'fromEmail'=>$emailFrom);
				        	//$this->modelbasic->sendMail($sendEmailToOwner);
				        }
				}
				else if($_POST['listaction'] == '4')
				{
					$status = array('featured'=>'1');
					$this->modelbasic->_update('project_master',$key,$status);
     				$this->session->set_flashdata('success', 'Project\'s successfully make featured');
				}
				else if($_POST['listaction'] == '5')
				{
					$status = array('featured'=>'0');
					$this->modelbasic->_update('project_master',$key,$status);
     				$this->session->set_flashdata('success', 'Project\'s successfully make Unfeatured');
				}

			}

			redirect('admin/projects');
		}
	}
	
	
	public function delete_confirm($project_id)
	{
		$projectStatus=$this->modelbasic->getValueArray('project_master','status',array('id'=>$project_id));
		if($projectStatus !=2)
		{
			$userId=$this->modelbasic->getValueArray('project_master','userId',array('id'=>$project_id));
			$userEmail=$this->db->select('email,firstName,lastName')->from('users')->where('id',$userId)->get()->row_array();

			$projectName=$this->modelbasic->getValueArray('project_master','projectName',array('id'=>$project_id));
			if($projectStatus==0)
			{
				$status='Draft';
			}
			if($projectStatus==1)
			{
				$status='Public';
			}
			if($projectStatus==3)
			{
				$status='Private';
			}
		}
		


		$res = $this->project_model->deleteProject($project_id);
		if($res)
		{
			if($projectStatus !=2)
			{
				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$template    = 'Hello ,'.$userEmail['firstName'].' '.$userEmail['lastName'].'<br />Your project "<b>' .$projectName.'</b>" is deleted by Admin / Institute Admin from creosouls. <br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
				$sendEmailToOwner = array('to'=>$userEmail,'subject'=>'Your project deleted','template' =>$template,'fromEmail'=>$emailFrom);
				//$this->modelbasic->sendMail($sendEmailToOwner);
			}
			$this->session->set_flashdata('success', 'Project deleted successfully');
		}
		else
		{
			$this->session->set_flashdata('fail', 'Fail to delete project');
		}
		redirect('admin/projects');
 	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('project_master','status','id',$id);
		if($result == 1)
		{
			//$data = array('status'=>'0');
			$data = array('status'=>'3');
			
			$userId=$this->modelbasic->getValueArray('project_master','userId',array('id'=>$id));
			$projectName=$this->modelbasic->getValueArray('project_master','projectName',array('id'=>$id));
			$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
			$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
			$projectImage=$this->modelbasic->getValueArray('user_project_image','image_thumb',array('project_id'=>$id,'cover_pic'=>1));
			$notificationEntry=array('title'=>'Project status changed','msg'=>'Your project '.$projectName.' status changed to "Draft" by Admin / Institite Admin.','link'=>'projectDetail/'.$projectPageName,'imageLink'=>'project/thumbs/'.$projectImage,'created'=>date('Y-m-d H:i:s'),'typeId'=>3,'redirectId'=>$id);
			$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
			$notificationToUser=array('notification_id'=>$notificationId,'user_id'=>$userId);
			$this->modelbasic->_insert('header_notification_user_relation',$notificationToUser);
			$this->session->set_flashdata('success', 'Project deactivated successfully.');
			
		}
		else
		if($result == 0)
		{
			$project_id = $this->modelbasic->getValue('project_master','id','id',$id);
			if($project_id > 0)
			{
				$data = array('status'=>'1');
				$userId=$this->modelbasic->getValueArray('project_master','userId',array('id'=>$id));
				$projectName=$this->modelbasic->getValueArray('project_master','projectName',array('id'=>$id));
				$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
				$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
				$projectImage=$this->modelbasic->getValueArray('user_project_image','image_thumb',array('project_id'=>$id,'cover_pic'=>1));
				$notificationEntry=array('title'=>'Project status changed','msg'=>'Your project '.$projectName.' status changed to "Public" by Admin / Institite Admin.','link'=>'projectDetail/'.$projectPageName,'imageLink'=>'project/thumbs/'.$projectImage,'created'=>date('Y-m-d H:i:s'),'typeId'=>3,'redirectId'=>$id);
				$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
				$notificationToUser=array('notification_id'=>$notificationId,'user_id'=>$userId);
				$this->modelbasic->_insert('header_notification_user_relation',$notificationToUser);
				$this->session->set_flashdata('success', 'Project activated successfully.');
			}
		}
		$this->modelbasic->_update('project_master',$id, $data);
		redirect('admin/projects');
	}
	
	function make_public($id = NULL)
	{
		$data = array('status'=>'1','admin_status'=>'');
		$res = $this->modelbasic->_update('project_master',$id,$data);
		if($res > 0)
			{
				$userId=$this->modelbasic->getValueArray('project_master','userId',array('id'=>$id));
				$projectName=$this->modelbasic->getValueArray('project_master','projectName',array('id'=>$id));
				$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
				$projectPageName=$this->modelbasic->getValueArray('project_master','projectPageName',array('id'=>$id));
				$projectImage=$this->modelbasic->getValueArray('user_project_image','image_thumb',array('project_id'=>$id,'cover_pic'=>1));
				$notificationEntry=array('title'=>'Project status changed','msg'=>'Your project '.$projectName.' status changed to "Public" by Admin / Institite Admin.','link'=>'projectDetail/'.$projectPageName,'imageLink'=>'project/thumbs/'.$projectImage,'created'=>date('Y-m-d H:i:s'),'typeId'=>6,'redirectId'=>$id);
				$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEntry);
				$notificationToUser=array('notification_id'=>$notificationId,'user_id'=>$userId);
				$this->modelbasic->_insert('header_notification_user_relation',$notificationToUser);
				$this->session->set_flashdata('success', 'Project status change successfully.');
			}
			else
			{
				$this->session->set_flashdata('error', 'faild to change status.');
			}
		redirect('admin/projects');
	}
	
	
	function make_private()
	{
		if(isset($_POST['projectId'])&&$_POST['projectId']!=''&&isset($_POST['comment_text'])&&$_POST['comment_text']!='')
		{
			$data = array('admin_status'=>'');
			$res = $this->modelbasic->_update('project_master',$_POST['projectId'], $data);
			if($res > 0)
			{
				$data = array('projectId'=>$_POST['projectId'],'comment'=>$_POST['comment_text'],'adminId'=>$this->session->userdata('admin_id'));
			    $this->modelbasic->_insert('admin_project_not_approve_reln', $data);
			    
			    if($this->session->userdata('admin_level')!=1)
			    {
					  $instituteAdmin = $this->modelbasic->get_where('users',$this->session->userdata('admin_id'));
				}
				else
				{
					$instituteAdmin = $this->modelbasic->get_where('admin',$this->session->userdata('admin_id'));
				}
			  
			    $instituteAdmin1 = $instituteAdmin->result_array();
			   // print_r($instituteAdmin1);
			    $prodata = $this->modelbasic->get_where('project_master',$_POST['projectId']);
			    $prodata1 = $prodata->result_array();
			   //   print_r($prodata1);
			  
			    if(!empty($prodata1))
			    {
					  $userdata = $this->modelbasic->get_where('users',$prodata1[0]['userId']);
					  $userdata1 = $userdata->result_array();
					  // print_r($userdata1);
					  $emailJobDetail=array('to'=>$userdata1[0]['email'],'subject'=>'Your Project Public Staus Request','template'=>$_POST['comment_text'],'fromEmail'=>$instituteAdmin1[0]['email']);
					  //$dte =$this->modelbasic->sendMail($emailJobDetail);
					
				}
			 
				echo 'done';
			}
			else
			{
				$this->session->set_flashdata('error', 'faild to change status.');
			}
			
		}
		
	}

	public function trending_project()
	{
		$this->load->view('admin/projects/trending_project');
	}

	public function make_project_trending()
	{
		//$currentmonth=date('m');
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);

		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		$currentdate=date('Y-m-d');
		/*$result =$this->db->query("SELECT u.id,u.firstName, u.email,pm.projectName,pm.id,pr.rating, pr.created, pr.modified from users u JOIN project_rating pr ON u.id=pr.userId JOIN project_master pm ON pr.projectId=pm.id where u.admin_level=4 AND u.status=1 and pr.rating=5 AND DATE_FORMAT(pr.created,'%Y-%m-%d')>=$start_week AND DATE_FORMAT(pr.created,'%Y-%m-%d')<=$end_week");
		echo $this->db->last_query();*/
		//$this->db->query("UPDATE project_master SET featured='0'");

		$result =$this->db->query("UPDATE users u JOIN project_rating pr ON u.id=pr.userId JOIN project_master pm ON pr.projectId=pm.id SET pm.featured='1',pm.featured_date='$currentdate' WHERE u.admin_level=4 AND u.status=1 and pr.rating=5 AND DATE_FORMAT(pr.created,'%Y-%m-%d')>='$start_week' AND DATE_FORMAT(pr.created,'%Y-%m-%d')<='$end_week'");
			//echo $this->db->last_query();
		if (isset($result) && !empty($result))
		{
			echo "Trending Project Set Successfully.";
			//$this->session->set_flashdata('success', 'Trending Project Set Successfully.');
			//redirect(base_url().'admin/projects/trending_project');
		}
		else
		{
			echo "Unable To Set Trending Project.";
			//$this->session->set_flashdata('error', 'Unable To Set Trending Project.');
			//redirect(base_url().'admin/projects/trending_project');
		}
  			
	}
}
