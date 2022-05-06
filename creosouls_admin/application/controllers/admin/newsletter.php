<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Newsletter extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')==2 || $this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
	}

	public function index()
	{
		$this->load->view('admin/blog/manage_blog');
	}

	function get_ajaxdataObjects()
	{
		$_POST['columns']='id,title,keywords,created,status,description,posted_by';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns='id,title,picture,description,keywords,created,status';
		//print_r($columns);die;
		//get total number of data without any condition and search term
		$totalData=$this->modelbasic->count_all_only('blog');
		$totalFiltered=$totalData;

			$result=$this->modelbasic->run_query('blog',$requestData,$columns,$selectColumns);
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

					$nestedData['title'] = $row["title"];
					$nestedData['description'] = $row["description"];

					$picture=$row["picture"];
					//echo $instituteCoverImage;die;
					if($picture <> '')
					{
						if(file_exists(file_upload_absolute_path().'blog/thumb/'.$picture))
						{
							$picture = '<img width="120"  src="'.file_upload_base_url().'blog/thumb/'.$picture.'">';
						}
						else
						{
							$picture = '<img width="120" src="'.base_url().'backend_assets/img/noimage.png">';
						}
					}
					else
					{
						$picture = '<img width="120" src="'.base_url().'backend_assets/img/noimage.png">';
					}
					$nestedData['picture'] = $picture;
					$nestedData['keywords'] = $row["keywords"];
					/*$nestedData['type'] = $row["type"];
					$nestedData['close_on'] = date("d-M-Y", strtotime($row["close_on"]));*/
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));
					if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';}else{ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}
					$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="delete" onclick="delete_blog('.$row['id'].')"> <i class="fa fa-times"></i> </a>';
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

	function multiselect_action()
	{
		//print_r($_POST);die;
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];

			//echo "<pre>";print_r($_POST);die;

			foreach ($check as $key => $value) {

				if($_POST['listaction'] == '1'){

					$status = array('status'=>'1');
					$this->modelbasic->_update('blog',$key,$status);

					$this->session->set_flashdata('success', 'Newsletter\'s activated successfully');


				}elseif($_POST['listaction'] == '2'){



						$status = array('status'=>'0');
					$this->modelbasic->_update('blog',$key,$status);

						$this->session->set_flashdata('success', 'Newsletter\'s deactivated successfully');

				}elseif($_POST['listaction'] == '3')
				{
					$query=$this->modelbasic->getValue('blog','picture','id',$key);
					//print_r($query);die;
					$path2 = file_upload_s3_path().'blog/';
					$path3 = file_upload_s3_path().'blog/thumb/';

					//echo($query);
					if(!empty($query))
					{
						//echo( $path2 . $query);die;
						unlink( $path2 . $query);
						unlink( $path3 . $query);
					}
					$this->modelbasic->_delete('blog',$key);
					$this->modelbasic->_delete_with_condition('blog_comment','blogId',$key);
					$this->session->set_flashdata('success', 'Newsletter\'s deleted successfully');
				}
			}

			redirect('admin/newsletter');
		}
	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('blog','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>'0');
			if($id != 1)
			{
				$this->session->set_flashdata('success', 'Newsletter deactivated successfully.');
			}
		}else if($result == 0)
		{
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Newsletter activated successfully.');
		}
		$this->modelbasic->_update('blog',$id, $data);
		redirect('admin/newsletter');
	}

	function delete_blog($id = NULL)
	{
		$query=$this->modelbasic->getValue('blog','picture','id',$id);
           $path2 = file_upload_s3_path().'blog/';
		$path3 = file_upload_s3_path().'blog/thumb/';

		//echo($query);
		if(!empty($query))
		{
			//echo( $path2 . $query);die;
			unlink( $path2 . $query);
			unlink( $path3 . $query);
		}
		$this->modelbasic->_delete('blog',$id);
		$this->modelbasic->_delete_with_condition('blog_comment','blogId',$id);
		$this->session->set_flashdata('success', 'Newsletter\'s deleted successfully');
		redirect('admin/newsletter');
	}

	public function processForm()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('title', 'Newsletter Title', 'required');
		$this->form_validation->set_rules('keywords', 'keywords','required');
		$this->form_validation->set_rules('posted_by', 'Posted By', 'required');
		/*$this->form_validation->set_rules('close_on', 'blog Close Date', 'required');*/
		$this->form_validation->set_rules('description', 'Newsletter Description', 'required');
		$this->form_validation->set_rules('picture', 'Newsletter Image', 'callback_image_upload');
		if ($this->form_validation->run())
		{
			if($this->input->post('blogId',TRUE) > 0)
			{
				$blogId=$this->input->post('blogId',TRUE);
				$data=array('title'=>$this->input->post('title',TRUE),'keywords'=>$this->input->post('keywords',TRUE),'description'=>$this->input->post('description',TRUE),'posted_by'=>$this->input->post('posted_by',TRUE));
				if(isset($_POST['picture']['file_name']) && $_POST['picture']['file_name'] <> '')
				{
					$data['picture']=$_POST['picture']['file_name'];
				}
				//pr($data);
				$res=$this->modelbasic->_update('blog',$blogId,$data);

				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'Newsletter updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating newsletter please try again....');
				}
			}
			else
			{
				$data=array('title'=>$this->input->post('title',TRUE),'keywords'=>$this->input->post('keywords',TRUE),'description'=>$this->input->post('description',TRUE),'created'=>date('Y-m-d H:i:s'),'status'=>1,'posted_by'=>$this->input->post('posted_by',TRUE));
				if(isset($_POST['picture']['file_name']) && $_POST['picture']['file_name'] <> '')
				{
					$data['picture']=$_POST['picture']['file_name'];
				}
				$blogId=$this->modelbasic->_insert('blog',$data);


				if($blogId > 0)
				{
					$userDataEdit=$this->modelbasic->getAllUser();
					$notificationEditEntry=array('title'=>'New newsletter published','msg'=>'New newsletter '.$this->input->post('title',TRUE).' posted on creosouls.','link'=>'newsletter/newsletterDetail/'.$blogId,'imageLink'=>'blog/thumb/'.$_POST['picture']['file_name'],'created'=>date('Y-m-d H:i:s'),'typeId'=>10,'redirectId'=>$blogId);
					$notificationEditId=$this->modelbasic->_insert('header_notification_master',$notificationEditEntry);
					foreach($userDataEdit as $val)
					{
						$notificationToCreUser=array('notification_id'=>$notificationEditId,'user_id'=>$val['id']);
						$this->modelbasic->_insert('header_notification_user_relation',$notificationToCreUser);
					}
					$data=array('status'=>'success','for'=>'add','message'=>'newsletter added successfully.');
					$user=$this->modelbasic->getAllUser();
					//print_r($user);die;
					$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
					foreach ($user as $val)
					{
						$emailTo=$val['email'];
						$from=$emailFrom;
						$nameTo=ucwords($val['firstName'].' '.$val['lastName']);
						$templateblogEmail='Hello <b>'.$nameTo. '</b>,<br />New newsletter "<b>'.$this->input->post('title',TRUE).'</b>" is published on creosouls .<br /><a href="'.front_base_url().'newsletter/newsletterDetail/'.$blogId.'">Click here</a>  to view the newsletter detail.<br /><br /><br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
						$emailblogDetail=array('to'=>$emailTo,'subject'=>'New newsletter published on creosouls','template'=>$templateblogEmail,'fromEmail'=>$from);
						//$this->modelbasic->sendMail($emailblogDetail);
					}

				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while adding newsletter please try again....');
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
				$this->load->view('admin/blog/addedit_view');
			}
		}
	}

	function image_upload()
	{
		if(isset($_FILES['picture'])&&$_FILES['picture']['size'] != 0)
		{
			$upload_dir = file_upload_s3_path().'blog/';
			if (!is_dir($upload_dir))
			{
			     mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = 'blogImage_'.substr(md5(rand()),0,7);
			$config['max_size']	 = '2000';
			$config['max_width']  = '900';
		    $config['max_height']  = '300';

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('picture'))
			{
				$this->form_validation->set_message('image_upload', $this->upload->display_errors());
				return false;
			}
			else
			{
				$_POST['picture'] =  $this->upload->data();
		        if(!is_dir(file_upload_s3_path().'blog/thumb/'))
				{
					mkdir(file_upload_s3_path().'blog/thumb/', 0777, TRUE);
				}
		        $config['image_library'] = 'gd2';
				$config['source_image'] = file_upload_s3_path().'blog/'.$_POST['picture']['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 40;
				$config['new_image'] = file_upload_s3_path().'blog/thumb/'.$_POST['picture']['file_name'];
				$this->load->library('image_lib',$config);
				$return = $this->image_lib->resize();
				
				if($this->input->post('blogId',TRUE))
				{
					$query=$this->modelbasic->getValue('blog','picture','id',$this->input->post('blogId',TRUE));
					$path2 = file_upload_s3_path().'blog/';
					$path3 = file_upload_s3_path().'blog/thumb/';

					if(!empty($query))
					{
				    	unlink( $path2 . $query);
						unlink( $path3 . $query);
					}
				}
				
				return true;
			}
		}
		else
		{
			//$this->form_validation->set_message('image_upload', "No file selected");
			return true;
		}
	}


	function setFlashdata($function)
	{

		if($function == 'add')
		{
			$this->session->set_flashdata('success','Newsletter added successfully.');
			redirect(base_url().'admin/newsletter/');
		}
		else
		{
			$this->session->set_flashdata('success','Newsletter updated successfully.');
			redirect(base_url().'admin/newsletter/');
		}
	}

	function getEditFormData()
	{
		$blogId=$this->input->post('blogId',true);
		$data=$this->modelbasic->get_where('blog',$blogId)->row_array();
		/*$data['close_on']= date("d-M-Y", strtotime($data["close_on"]));*/
		echo json_encode($data);
	}
}
