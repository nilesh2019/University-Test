<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	if($this->session->userdata('admin_level')!=1)
	    {
			redirect(base_url());
		}
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
	}

	public function index()
	{
		$this->load->view('admin/clients/manage_clients');
	}

	function get_ajaxdataObjects()
	{
		$_POST['columns']='id,name,logo,description,created,status';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns='id,name,logo,description,created,status';
		//print_r($columns);die;
		//get total number of data without any condition and search term
		$totalData=$this->modelbasic->count_all_only('clients');
		$totalFiltered=$totalData;

			$result=$this->modelbasic->run_query('clients',$requestData,$columns,$selectColumns);

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
					$nestedData['name'] = $row["name"];
					$LogoImage=$row["logo"];

					if($LogoImage <> '')
					{
						if(file_exists(file_upload_absolute_path().'client/thumbs/'.$LogoImage))
						{
							$LogoImage = '<img width="100" height="70" src="'.file_upload_base_url().'client/thumbs/'.$LogoImage.'">';
						}
						else
						{
							$LogoImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/noimage1.png">';
						}
					}
					else
					{
						$LogoImage = '<img width="100" height="70" src="'.base_url().'backend_assets/img/noimage1.png">';
					}

					$nestedData['logo'] = $LogoImage;
					$nestedData['description'] = $row["description"];
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));
					if($row["status"]==1){ $nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';}else{ $nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';}
					$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="delete" onclick="delete_client('.$row['id'].')"> <i class="fa fa-times"></i> </a>';
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
					$this->modelbasic->_update('clients',$key,$status);

					$this->session->set_flashdata('success', 'Clients activated successfully');


				}elseif($_POST['listaction'] == '2'){

										$status = array('status'=>'0');
					$this->modelbasic->_update('clients',$key,$status);

						$this->session->set_flashdata('success', 'clients deactivated successfully');


				}elseif($_POST['listaction'] == '3')
				{
					$query=$this->modelbasic->getValue('clients','logo','id',$key);
					//print_r($query);die;
					$path2 = file_upload_s3_path().'client/';
					$path3 = file_upload_s3_path().'client/thumbs/';

					//echo($query);
					if(!empty($query))
					{
						//echo( $path2 . $query);die;
						unlink( $path2 . $query);
						unlink( $path3 . $query);
					}
					$this->modelbasic->_delete('clients',$key);
					$this->session->set_flashdata('success', 'Clients deleted successfully');
				}
			}

			redirect('admin/client');
		}
	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('clients','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>'0');
			if($id != 1)
			{
				$this->session->set_flashdata('success', 'Client deactivated successfully.');
			}
		}else if($result == 0)
		{
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Client activated successfully.');
		}
		$this->modelbasic->_update('clients',$id, $data);
		redirect('admin/client');
	}

	function delete_client($id = NULL)
	{
		$query=$this->modelbasic->getValue('clients','logo','id',$id);
            $path2 = file_upload_s3_path().'client/';
		$path3 = file_upload_s3_path().'client/thumbs/';
		//echo($query);
		if(!empty($query))
		{
			//echo( $path2 . $query);die;
			unlink( $path2 . $query);
			unlink( $path3 . $query);
		}
		$this->modelbasic->_delete('clients',$id);
		$this->session->set_flashdata('success', 'clients deleted successfully');
		redirect('admin/client');
	}

	public function processForm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Client Name', 'required');
		$this->form_validation->set_rules('description', 'Job Description', 'required|max_length[5000]');
		$this->form_validation->set_rules('logo', 'Logo', 'callback_image_upload');
		if ($this->form_validation->run())
		{
			if($this->input->post('clientId',TRUE) > 0)
			{
				$clientId=$this->input->post('clientId',TRUE);
				$data=array('name'=>$this->input->post('name',TRUE),'created'=>date("Y-m-d H:i:s"),'description'=>$this->input->post('description',TRUE));
				if(isset($_POST['companyLogo']['file_name']) && $_POST['companyLogo']['file_name'] <> '')
				{
					$data['companyLogo']=$_POST['companyLogo']['file_name'];
				}
				$res=$this->modelbasic->_update('clients',$clientId,$data);

				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'client updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating client please try again....');
				}
			}
			else
			{
				$data=array('name'=>$this->input->post('name',TRUE),'description'=>$this->input->post('description',TRUE),'created'=>date('Y-m-d H:i:s'),'status'=>1);
				if(isset($_POST['logo']['file_name']) && $_POST['logo']['file_name'] <> '')
				{
					$data['logo']=$_POST['logo']['file_name'];
				}
				$clientId=$this->modelbasic->_insert('clients',$data);


				if($clientId > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Client added successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while adding job please try again....');
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
				$this->load->view('admin/client/add_view');
			}
		}
	}

	function image_upload()
	{
		if($_FILES['logo']['size'] != 0)
		{
			$upload_dir = file_upload_s3_path().'client/';
			if (!is_dir($upload_dir))
			{
			     mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = 'companyLogo_'.substr(md5(rand()),0,7);
			$config['max_size']	 = '2000';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('logo'))
			{
				$this->form_validation->set_message('image_upload', $this->upload->display_errors());
				return false;
			}
			else
			{
				$_POST['logo'] =  $this->upload->data();
		        	if(!is_dir(file_upload_s3_path().'client/thumbs'))
				{
					mkdir(file_upload_s3_path().'client/thumbs', 0777, TRUE);
				}
		        	$config['image_library'] = 'gd2';
				$config['source_image'] = file_upload_s3_path().'client/'.$_POST['logo']['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 200;
				$config['new_image'] = file_upload_s3_path().'client/thumbs/'.$_POST['logo']['file_name'];
				$this->load->library('image_lib',$config);
				$return = $this->image_lib->resize();
				return true;
			}
		}
		elseif($this->input->post('clientId',TRUE) > 0)
		{
			//$this->form_validation->set_message('image_upload', "No file selected");
			return true;
		}
		else
		{
			$this->form_validation->set_message('image_upload', "No file selected");
			return false;
		}
	}


	function setFlashdata($function)
	{

		if($function == 'add')
		{
			$this->session->set_flashdata('success','client added successfully.');
			redirect(base_url().'admin/client/');
		}
		else
		{
			$this->session->set_flashdata('success','client updated successfully.');
			redirect(base_url().'admin/client/');
		}
	}

	function getEditFormData()
	{
		$clientId=$this->input->post('clientId',true);
		$data=$this->modelbasic->get_where('clients',$clientId)->row_array();
		echo json_encode($data);
	}
}
