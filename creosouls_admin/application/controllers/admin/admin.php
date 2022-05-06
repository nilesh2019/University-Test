<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/admin_model');
    	$this->load->model('admin/dashboard_model');
    	$this->load->helper('string');
	   /* if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}*/
	}
	public function index()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}	
		$this->load->view('admin/admin/manage_admin');
	}
	function get_ajaxdataObjects($institute='')
	{
		$_POST['columns']='id,name,email,manage_user,status,created';
		$requestData= $_REQUEST;
		$columns=explode(',',$_POST['columns']);
		$selectColumns="id,name,email,manage_user,status,created";
		$totalData=$this->admin_model->count_all_only('admin');
		$totalFiltered=$totalData;		
		$result=$this->admin_model->run_query('admin',$requestData,$columns,$selectColumns,'','',$institute);
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
					if($row["name"] <> ' ')
					{
						$nestedData['name'] = ucwords($row["name"]);
					}
					else
					{
						$nestedData['name'] = ucwords('No Name');
					}
					$nestedData['email'] = $row["email"];
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));					
						if($row['status']==1)
						{
							$nestedData['status']='<span class="label label-success" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Active</span>';
						}
						else
						{
							$nestedData['status']='<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';
						}
						
						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><span class="menu-action rounded-btn"><a onclick="edit_admin('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i></a><a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a></span>';

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




	
	function multiselect_action()
	{
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];

			foreach ($check as $key => $value) {

			if($_POST['listaction'] == '1'){

					$status = array('status'=>1);
					$this->modelbasic->_update('admin',$key,$status);

					$this->session->set_flashdata('success', 'admin\'s activated successfully');


				}else if($_POST['listaction'] == '2'){
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{
						$status = array('status'=>0);
						$this->modelbasic->_update('admin',$key,$status);
						$this->session->set_flashdata('success', 'admin\'s deactivated successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Fail to Dactive Admin');

					}

				}else
				if($_POST['listaction'] == '3')
				{
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{			 		
					      $this->modelbasic->_delete('admin',$key);
					      $this->session->set_flashdata('success', 'admin\'s deleted successfully');
				     }
				     else
				     {
				     	$this->session->set_flashdata('error', 'Fail to Delet Admin');

				     }
				}

			}

			redirect('admin/admin');
		}
	}

	public function delete_confirm($id)
	{
		if($id!=1 && $this->session->userdata('admin_id')!=$id)
		{
		  $res = $this->modelbasic->_delete('admin',$id);
		  if($res ==1)
		  {
		  	$this->session->set_flashdata('success', 'Admin deleted successfully');
		  	redirect('admin/admin');
	      }
		  else
		  {
		  	$this->session->set_flashdata('error', 'Fail to delete Admin');
		  	redirect('admin/admin');
		  }

		}
		else
		{
			$this->session->set_flashdata('error', 'Dont try to delete Admin');
			redirect('admin/admin');
		} 
	 
 	}


	function change_status($id = NULL)
	{
		
		$result = $this->modelbasic->getValue('admin','status','id',$id);
		if($result == 1)
		{
			if($id!=1 && $this->session->userdata('admin_id')!=$id)
			{

				$data = array('status'=>0);
				$this->session->set_flashdata('success', 'Admin deactivated successfully.');
			}
			else
			{
				$this->session->set_flashdata('error', 'Fail to change status');
				redirect('admin/admin');

			}

		}else if($result == 0)
		{
			$data = array('status'=>1);
			$this->session->set_flashdata('success', 'Admin activated successfully.');
		}
		$this->modelbasic->_update('admin',$id, $data);
		redirect('admin/admin');
		
	}

	
	function logout()
	{
		$this->session->set_userdata('admin_login', '');
		$this->session->set_userdata('admin_id', '');
		$this->session->set_userdata('name', '');
		$this->session->set_userdata('login_type', '');
		$this->session->sess_destroy();
		$this->session->set_flashdata('logout_notification', 'logged_out');
		redirect(front_base_url());
	}

public function email_check($str)
   {
   	$id=$this->input->post('id',TRUE);
   	if($id=='')
   	{  	
   		$res=array('email'=>$str);
   		$check_email=$this->modelbasic->getSelectedData('admin','email',$res,'','','','','','row_array');
		if (!empty($check_email) && $check_email['email'] != '')
	        {
	               $this->form_validation->set_message('email_check', 'The Email field exist');
	                return FALSE;
	        }
	        else
	        {
	                return TRUE;
	        }
   	}
   	else
   	{   		
   		$res=array('email'=>$str,'id !='=>$id);
   		$check_email=$this->modelbasic->getSelectedData('admin','email',$res,'','','','','','row_array');
   		if (!empty($check_email) && $check_email['email'] != '')
           {
                   $this->form_validation->set_message('email_check', 'The Email field exist');
                   return FALSE;
           }
           else
           {
                   return TRUE;
           }
  	}
   }


	public function add()
	{
		
		$id=$this->input->post('id',TRUE);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');	
		if ($this->form_validation->run())
		{
			if(isset($_POST['manage_user']) && $_POST['manage_user']!='')
			{
				$manage_user=$this->input->post('manage_user',TRUE);
			}
			else
			{
				$manage_user='0';
			}
			if($id !='')
			{
				$updateData=array('name'=> $this->input->post('name',TRUE),'email'=>$this->input->post('email',TRUE),'manage_user'=>$manage_user);

				$res=$this->modelbasic->_update('admin',$id,$updateData);
			
				if($res==1)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Admin updated successfully.');
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while update Admin please try again...');
				}
				echo json_encode($data);
			}
			else
			{
				$adminpassword = random_string('alnum', 10);

				$AddData=array('name'=> $this->input->post('name',TRUE),'email'=>$this->input->post('email',TRUE),'manage_user'=>$manage_user,'password'=>md5($adminpassword),'created'=>date('Y-m-d H:i:s'),'level'=>'1');
			
				$res=$this->modelbasic->_insert('admin',$AddData);	

				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$datas['fromEmail']=$emailFrom;
				$datas['to']=$this->input->post('email',TRUE);
				$datas['subject']='Admin Appointment';
				$datas['template']='Hello '.$_POST['name'].',<br/>You has been appointed as Admin.<br/> Following are the your login detail,<br/>Email Id is - '.$_POST['email'].'<br/> Password - '.$adminpassword.'<br/>Click following link to login </br>Thanks & Regards<br/> Admin';
			
				$result=$this->modelbasic->sendMail($datas);


				if($res > 0)
				{

					$data=array('status'=>'success','for'=>'add','message'=>'Admin added successfully.');
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Admin please try again...');
				}
				echo json_encode($data);
			}		
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo $this->form_validation->get_json();
			}
			else
			{
				$data=array('status'=>'error','message'=>'Error occurred while adding Admin please try again...');
				echo json_encode($data);
			}
		}
	}

	public function edit_admin($id)
	{	
		$data=$this->admin_model->get_single_admin($id);	
		echo json_encode($data);		
	}

	public function save_change_pass()
	{
		$this->form_validation->set_rules('chang_pass_admin', 'Password', 'trim|required');	
		if ($this->form_validation->run())
		{
			//print_r($_POST);die;
			$id=$this->input->post('admin_id',TRUE);
			$pass=$this->input->post('chang_pass_admin',TRUE);			
			$current_url=$this->input->post('current_url',TRUE);			
			$updateData=array('password'=>md5($pass));
		//	print_r($updateData);die;
			$res=$this->modelbasic->_update('admin',$id,$updateData);
			//print_r($res);die;		
			if($res==1)
			{
				$data=array('status'=>'success','for'=>'add','message'=>'Admin updated successfully.','current_url'=>$current_url);
			}
			else
			{
				$data=array('status'=>'error','message'=>'Error occurred while update Admin please try again...');
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
				$data=array('status'=>'error','message'=>'Error occurred while Change Password please try again...');
				echo json_encode($data);
			}
		}
	}

	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Disk space allocated successfully.');
			redirect(base_url().'admin/admin/');
		}
		else
		{
			$this->session->set_flashdata('success','Disk space updated successfully.');
			redirect(base_url().'admin/admin/');
		}
	}

	public function export_users_project_count()
	{		
		$instituteId = $_POST['instituteId'];	
		$this->load->dbutil();
		$this->load->helper('file');
		$query = $this->admin_model->export_users_project_count($instituteId);
		$data =$this->dbutil->csv_from_result($query);
		if (!is_dir('../export'))
		{
	    		mkdir('../export', 0777, TRUE);
		}
		$path='../export/'.time().'.csv';
		if ( ! write_file($path, $data))
		{
		     $this->session->set_flashdata('error','Unable to export data to CSV please try again.');
		}
		else
		{
		    	$this->load->helper('download');
		    	$data = file_get_contents($path);
		    	echo $path;
		}
	}


	public function export_users_likers_project()
	{	
		$instituteId = $this->session->userdata('instituteId');	
	/*	if (!is_dir('../export'))
		{
	    		mkdir('../export', 0777, TRUE);
		}*/
		$path='../export/'.time().'.csv';

		$data = $this->admin_model->export_users_likers_project($instituteId);

		  header('Content-Type: application/excel');
		  header('Content-Disposition: attachment; filename="'.$path.'"');
  		    if(!empty($data))
   			{
			      $fh = fopen('php://output', 'w');
			      fputcsv($fh, array_keys(current($data)));		     
			      foreach ( $data as $row ) {
			              fputcsv($fh, $row);
			      }
			}
		
	}
	public function export_users_assignments()
	{	
		$instituteId = $this->session->userdata('instituteId');		
		$path='../export/'.time().'.csv';
		$data = $this->admin_model->export_users_assignments($instituteId);
		  header('Content-Type: application/excel');
		  header('Content-Disposition: attachment; filename="'.$path.'"');
  		    if(!empty($data))
   			{
			      $fh = fopen('php://output', 'w');
			      fputcsv($fh, array_keys(current($data)));		     
			      foreach ( $data as $row ) {
			              fputcsv($fh, $row);
			      }
		      }		
	}

	 public function comment_status()
	 {
	   if(isset($_POST['cid']) && ($_POST['cid'] !='') && isset($_POST['proid']) && ($_POST['proid'] !='') && isset($_POST['status']) && ($_POST['status'] !=''))
	   {
	   	 $res = $this->dashboard_model->change_comment_status($_POST['cid'],$_POST['status']);

		 if($_POST['status']==1)
		 {
		 	$this->dashboard_model->commentCountIncrement($_POST['proid']);
		 }
		 else
		 {
		   $this->dashboard_model->commentCountDecrement($_POST['proid']);
		 }

	 	 if($res>0)
		 {
		   echo 'yes';
		 }
		 else
		 {
		 	echo 'no';
		 }
	  }
	  else
	  {
	  	echo 'no';
	  }
    }

}

