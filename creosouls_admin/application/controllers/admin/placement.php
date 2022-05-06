<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/

class Placement extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('json');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->model('admin/job_model');
		$this->load->model('admin/placement_model');
		$this->load->model('modelbasic');
	}

	public function index()
	{
		$this->load->view('admin/placement/manage_placement');
	}
	function get_ajaxdataObjects($featured_job='')
		{
			$_POST['columns'] = 'A.id,A.created';
			$requestData   = $_REQUEST;
			//print_r($requestData);die;
			$columns       = explode(',',$_POST['columns']);
			$selectColumns = 'A.id,A.student_name,A.company,A.position,A.profile_image,A.created,A.status,A.description,A.featured';


			if($featured_job!='' && $featured_job==1)
			{				
				$totalData     = $this->placement_model->count_all_only('placement',array('featured'=>1),'AND');	
			}
			else
			{
				$totalData     = $this->placement_model->count_all_only('placement','','AND');
			}			
							
			$totalFiltered = $totalData;


			if($featured_job!='' && $featured_job==1)
			{
				$result=$this->placement_model->run_query('placement',$requestData,$columns,$selectColumns,'','',$featured_job);		

			}
			else
			{			
				$result  = $this->placement_model->run_query('placement',$requestData,$columns,$selectColumns);	
			}

			//print_r($result);die;
			if( !empty($requestData['search']['value']) ){
				$totalFiltered = count($result);
			}
			$data = array();

			if(!empty($result)){
				$i = 1;
				foreach($result as $row)
				{
					$nestedData=array();

					
					$studentProfile=$row["profile_image"];

					//echo $instituteCoverImage;die;

					if($studentProfile <> '')

					{

						if(file_exists(file_upload_absolute_path().'placement/profile_image/'.$studentProfile))

						{

							$studentProfile = '<img width="100" height="100" src="'.file_upload_base_url().'placement/profile_image/'.$studentProfile.'">';

						}

						else

						{

							$studentProfile = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';

						}

					}

					else

					{

						$studentProfile = '<img width="100" height="100" src="'.base_url().'backend_assets/img/noimage1.png">';

					}
				
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] = $i + $requestData['start'];
					$nestedData['studentProfile'] =$studentProfile;
					$nestedData['jobid'] = $row["id"];
					$nestedData['student'] = $row["student_name"];
					$nestedData['company'] = $row["company"];
					$nestedData['position'] = $row["position"];
					$nestedData['description'] = $row["description"];
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));

					if($row["status"] == 1)
					{
						$nestedData['status'] = '<span class="label label-success" style="cursor: pointer;" onclick="change_status('.$row['id'].')">Active</span>';
					}
					else
					{
						$nestedData['status'] = '<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';
					}

				
					$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a><a class="btn menu-icon vd_bd-red vd_red" data-placement="top" data-toggle="tooltip" data-original-title="delete" onclick="delete_Placement('.$row['id'].')"> <i class="fa fa-times"></i></a>';
				
					$data[] = $nestedData;
					$i++;
				}
			}

			$json_data = array(
				"draw"           => intval( $requestData['draw'] ),// for every request / draw by clientside , they send a number as a parameter, when they recieve a response / data they first check the draw number, so we are sending same number in draw.
				"recordsTotal"=> intval( $totalData ),// total number of records
				"recordsFiltered"=> intval( $totalFiltered ),// total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"=> $data   // total data array

			);
			echo json_encode($json_data);
		}


	public function processForm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('company', 'Company Name', 'required');
		$this->form_validation->set_rules('student_name', 'Student Name', 'required');
		$this->form_validation->set_rules('description', 'Job Description', 'required|max_length[5000]');
		$this->form_validation->set_rules('profile_image', 'Student profile image', 'callback_validateStudentProfile');
		if($this->form_validation->run()){
			if($this->input->post('placementId',TRUE) > 0){
				$placementId = $this->input->post('placementId',TRUE);
				
				$data = array('student_name'=>$this->input->post('student_name',TRUE),'position'=>$this->input->post('position',TRUE),'description' =>$this->input->post('description',TRUE),'company' =>$this->input->post('company',TRUE));
				if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{

					$data['profile_image']=$_POST['profile_image']['file_name'];
					$query=$this->modelbasic->getValue('placement','profile_image','id',$placementId);
					$path2 = file_upload_s3_path().'placement/profile_image/';
					
				    if(!empty($query))
				    {
				    	if(file_exists($path2.$query))
				    	{
				    		unlink( $path2 . $query);
				    	}
				    	
				    }
				}
				$res = $this->placement_model->_update('placement',$placementId,$data);
		
				if($res){
					$data = array('status' =>'success','for'    =>'edit','message'=>'Placement details updated successfully.');
				}
				else
				{
					$data = array('status' =>'fail','message'=>'Error occurred while updating placement please try again....');
				}
			}
			else
			{
				$data = array(
					'student_name' => $this->input->post('student_name',TRUE),
					'position'    =>$this->input->post('position',TRUE),
					'company'     =>$this->input->post('company',TRUE),
					'description' =>$this->input->post('description',TRUE),
					'created'     =>date('Y-m-d H:i:s'),
					'status'      =>1,
					
				);
				if(isset($_POST['profile_image']['file_name']) && $_POST['profile_image']['file_name'] <> '')
				{
					$data['profile_image']=$_POST['profile_image']['file_name'];
				}
				$placementId = $this->placement_model->_insert('placement',$data);

				
				if($placementId > 0){

					$data = array('status' =>'success','for' =>'add','message'=>'Placement added successfully.');
								
				}
				else
				{
					$data = array('status' =>'fail','message'=>'Error occurred while adding job please try again....');
				}
			}
			echo json_encode($data);
		}
		else
		{
			if($this->input->is_ajax_request()){
				echo $this->form_validation->get_json();
			}
			else
			{
				$this->load->view('admin/placement/add_edit_view');
			}
		}
	}

	function setFlashdata($function)
	{
		if($function == 'add'){
			$this->session->set_flashdata('success','Placement details added successfully.');
			redirect(base_url().'admin/placement/');
		}
		else
		{
			$this->session->set_flashdata('success','Placement details updated successfully.');
			redirect(base_url().'admin/placement/');
		}
	}
	function getEditFormData()
	{
		$placementId = $this->input->post('placementId',true);
		$data = $this->placement_model->get_singlePlacementData($placementId);
		echo json_encode($data);
	}
	function delete_placement($id = NULL)
	{
		$this->placement_model->_delete('placement',$id);
		$this->session->set_flashdata('success', 'Placement Detail\'s deleted successfully');
		redirect('admin/placement');
	}
	function multiselect_action()
	{
		//print_r($_POST);die;
		if(isset($_POST['submit']))
			{

			$check = $_POST['checkall'];
			//echo " < pre > ";print_r($_POST);die;
			foreach($check as $key => $value)
			{
				if($_POST['listaction'] == '1')
				{
					$status = array('status'=>'1');
					$this->placement_model->_update('placement',$key,$status);
					$this->session->set_flashdata('success', 'Placement\'s activated successfully');
				}
				elseif($_POST['listaction'] == '2')
				{
					if($key != 1)
					{
						$status = array('status'=>'0');
						$this->placement_model->_update('placement',$key,$status);
						$this->session->set_flashdata('success', 'Placement\'s deactivated successfully');
					}
				}
				elseif($_POST['listaction'] == '3'){
					$this->placement_model->_delete('placement',$key);
					$this->session->set_flashdata('success', 'Placement\'s deleted successfully');
				}
				else if($_POST['listaction'] == '4')
				{
					$currentdate=date('Y-m-d');
					$status = array('featured'=>'1','featured_date'=>$currentdate);
					$this->modelbasic->_update('placement',$key,$status);
	     			$this->session->set_flashdata('success', 'Placement\'s successfully make featured');
				}
				else if($_POST['listaction'] == '5')
				{
					$status = array('featured'=>'0');
					$this->modelbasic->_update('placement',$key,$status);
	     			$this->session->set_flashdata('success', 'Placement\'s successfully make Unfeatured');
				}

			}
			redirect('admin/placement');
		}
	}
	function getZoneRegionList()
	{
		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			

				$zoneId = $_POST['zoneId'];				
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['region_name'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}			
	}

	function getRegionInstituteList(){
		if(!empty($_POST['regionId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			

				$regionId = $_POST['regionId'];			
				$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['instituteName'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}
	}

	function getInstituteStudentList(){
		if(!empty($_POST['instId']))
		{
			?>
			<option value="">Select Student</option>
			<?php
			

				$instId = $_POST['instId'];			
				$data = $this->db->select('A.id,A.firstName,A.lastName,B.studentId')->from('users as A')->join('institute_csv_users as B','B.email = A.email')->where('A.instituteId',$instId)->where('A.status',1)->where('A.admin_level',0)->where('B.studentId !=', '')->where('B.centerId', 1)->group_by('A.email')->get()->result_array();
				
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['firstName'];?>&nbsp;&nbsp;<?php echo $value['lastName'];?>&nbsp;(<?php echo $value['studentId'];?>)</option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}
	}
	function getSelectedRegionList()
	{

		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			

				$zoneId = $_POST['zoneId'];
				$placementId = $_POST['placementId'];
				$getSelectedRegion = $this->placement_model->get_singlePlacementColumnData('institute_master.region',$placementId);
				$regionId = $getSelectedRegion['region'];
				
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
		
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($regionId) && !empty($regionId))
						{
							
							if($regionId == $value['id'])
									{ echo "selected"; }						
							}
							 
							?>><?php echo $value['region_name'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}			
	}
	function getSelectedInstList()
	{

		if(!empty($_POST['regionId']))
		{
			?>
			<option value="">Select Institute</option>
			<?php
			

				$regionId = $_POST['regionId'];
				$placementId = $_POST['placementId'];
				$getSelectedInstitute = $this->placement_model->get_singlePlacementColumnData('institute_master.id',$placementId);
				$instId = $getSelectedInstitute['id'];
				
				$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
		
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($instId) && !empty($instId))
						{
							
							if($instId == $value['id'])
									{ echo "selected"; }						
							}
							 
							?>><?php echo $value['instituteName'];?> </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}			
	}
	function getSelectedStudentList(){
		if(!empty($_POST['instId']))
		{
			?>
			<option value="">Select Region</option>
			<?php
			

				$instId = $_POST['instId'];
				$placementId = $_POST['placementId'];
				$getSelectedStudent = $this->placement_model->get_singlePlacementColumnData('placement.user_id',$placementId);
				$studentId = $getSelectedStudent['user_id'];
				
				$data = $this->db->select('A.id,A.firstName,A.lastName,B.studentId')->from('users as A')->join('institute_csv_users as B','B.email = A.email')->where('A.instituteId',$instId)->where('A.status',1)->where('A.admin_level',0)->where('B.studentId !=', '')->order_by('A.id','desc')->get()->result_array();
		
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($studentId) && !empty($studentId))
						{
							
							if($studentId == $value['id'])
									{ echo "selected"; }						
							}
							 
							?>><?php echo $value['firstName'];?>&nbsp;&nbsp;<?php echo $value['lastName'];?>&nbsp;(<?php echo $value['studentId'];?>) </option>
						<?php
					}
				}
				else
				{
					echo '';
				}	
				
			
		}
	}
	function validateStudentProfile()

	{

		return $this->image_upload('profile_image','validateStudentProfile','200','200');

	}
	function image_upload($folderName,$functionName,$width,$height)

	{

		if(isset($_FILES[$folderName]) && $_FILES[$folderName]['size'] != 0)

		{

			$upload_dir = file_upload_s3_path().'placement/'.$folderName.'/';

			if (!is_dir($upload_dir))

			{

			     mkdir($upload_dir, 0777, TRUE);

			}

			$config['upload_path']   = $upload_dir;

			$config['allowed_types'] = 'jpg|png|jpeg';

			$config['file_name']     = $folderName.'_'.substr(md5(rand()),0,7);

			$config['max_size']	 = '2000';

			if($folderName=='profile_image')

			{

				$config['maintain_ratio'] = TRUE;
				$config['width']=945;
				$config['height']=470;

			}

			$this->upload->initialize($config);

			if (!$this->upload->do_upload($folderName))

			{

				$this->form_validation->set_message($functionName, $this->upload->display_errors());

				return false;

			}

			else

			{

				$_POST[$folderName] =  $this->upload->data();

		        	if(!is_dir(file_upload_s3_path().'placement/'.$folderName.'/thumbs'))

				{

					mkdir(file_upload_s3_path().'placement/'.$folderName.'/thumbs', 0777, TRUE);

				}

		        $config['image_library'] = 'gd2';

				$config['source_image'] = file_upload_s3_path().'placement/'.$folderName.'/'.$_POST[$folderName]['file_name'];

				
				

				return true;

			}

		}





		if(isset($_POST['placementId'])&&$_POST['placementId'] > 0)

		{

			return true;

		}

	    else

		{

			$this->form_validation->set_message($functionName,'Image required');

			return false;

		}



	}

}