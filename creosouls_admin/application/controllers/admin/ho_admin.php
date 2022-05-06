<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ho_admin extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/ho_admin_model');
    	$this->load->helper('string');
	    if($this->session->userdata('admin_level')==3)
	    {
			redirect(base_url());
		}
	}
	public function index()
	{
		if($this->session->userdata('admin_level')==0 && $this->uri->segment(2)=='admin')
		{
			$this->session->set_flashdata('error', 'Fail...');
			redirect('admin/dashboard');
		}	
		$this->load->view('admin/ho_admin/manage_admin');
	}

	
	function get_ajaxdataObjects($institute='')
	{
		$_POST['columns']='id,name,email,manage_user,status,created';
		$requestData= $_REQUEST;
		$columns=explode(',',$_POST['columns']);
		$selectColumns="id,name,email,manage_user,status,created";
		$totalData=$this->ho_admin_model->count_all_only('admin');
		$totalFiltered=$totalData;		
		$result=$this->ho_admin_model->run_query('admin',$requestData,$columns,$selectColumns,'','',$institute);
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

					$this->session->set_flashdata('success', 'Ho admin\'s activated successfully');


				}else if($_POST['listaction'] == '2'){
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{
						$status = array('status'=>0);
						$this->modelbasic->_update('admin',$key,$status);
						$this->session->set_flashdata('success', 'Ho admin\'s deactivated successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Fail to Dactive Ho admin');

					}

				}else
				if($_POST['listaction'] == '3')
				{
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{			 		
					      $this->modelbasic->_delete('admin',$key);
					      $res1 = $this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$id);
					      $this->session->set_flashdata('success', 'Ho admin\'s deleted successfully');
				     }
				     else
				     {
				     	$this->session->set_flashdata('error', 'Fail to Delete Ho admin');

				     }
				}

			}

			redirect('admin/ho_admin');
		}
	}

	public function delete_confirm($id)
	{
		if($id!=1 && $this->session->userdata('admin_id')!=$id)
		{
		  $res = $this->modelbasic->_delete('admin',$id);
		  $res1 = $this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$id);
		  if($res ==1)
		  {
		  	$this->session->set_flashdata('success', 'Ho admin deleted successfully');
		  	redirect('admin/ho_admin');
	      }
		  else
		  {
		  	$this->session->set_flashdata('error', 'Fail to delete Ho admin');
		  	redirect('admin/ho_admin');
		  }

		}
		else
		{
			$this->session->set_flashdata('error', 'Dont try to delete Admin');
			redirect('admin/ho_admin');
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
				$this->session->set_flashdata('success', 'Ho admin deactivated successfully.');
			}
			else
			{
				$this->session->set_flashdata('error', 'Fail to change status');
				redirect('admin/ho_admin');

			}

		}else if($result == 0)
		{
			$data = array('status'=>1);
			$this->session->set_flashdata('success', 'Ho admin activated successfully.');
		}
		$this->modelbasic->_update('admin',$id, $data);
		redirect('admin/ho_admin');
		
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

		//print_r($_POST);die;
		
		$id=$this->input->post('id',TRUE);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');	
		$this->form_validation->set_rules('admintype', 'Type', 'trim|required');	

		if ($this->form_validation->run())
		{			
			$manage_user='0';
			
			if($id !='')
			{
				$updateData=array('name'=> $this->input->post('name',TRUE),'email'=>$this->input->post('email',TRUE),'manage_user'=>$manage_user);

				$res=$this->modelbasic->_update('admin',$id,$updateData);

				 $this->modelbasic->_delete_with_condition('hoadmin_institute_relation','hoadmin_id',$id);			

					if(isset($_POST['region']) && !empty($_POST['region']) )
					{
						foreach ($_POST['region'] as $key => $value) 
						{
							$selectInstitute = $this->db->select('id')->from('institute_master')->where('region',$value)->get()->result_array();

							if(!empty($selectInstitute))
							{
								foreach ($selectInstitute as $inst_key => $region_instituteId) 
								{									
									$region_instituteId_Data = array('hoadmin_id'=>$id,'institute_id'=>$region_instituteId['id'],'region'=>$value,'zone'=>$_POST['zone']);
									$this->modelbasic->_insert('hoadmin_institute_relation',$region_instituteId_Data);								
								}
							}

						}
					}
				   else if(isset($_POST['zone']) && $_POST['zone']!= '' )
					{						
						$getRegion =  $this->db->select('id')->from('region_list')->where('zone_id',$_POST['zone'])->get()->result_array();					
						if(isset($getRegion) && !empty($getRegion) )
						{
							foreach ($getRegion as $key => $value) 
							{
								$selectInstitute = $this->db->select('id')->from('institute_master')->where('region',$value['id'])->get()->result_array();

								if(!empty($selectInstitute))
								{
									foreach ($selectInstitute as $inst_key => $region_instituteId) 
									{										
										$region_instituteId_Data = array('hoadmin_id'=>$id,'institute_id'=>$region_instituteId['id'],'region'=>$value['id'],'zone'=>$_POST['zone']);
										$this->modelbasic->_insert('hoadmin_institute_relation',$region_instituteId_Data);								
									}
								}
							}
						}
					}

				if($res==1)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Ho admin updated successfully.');
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
				$type=$this->input->post('admintype',TRUE);
				if($type=='Ho')
				{
					$level='4';
				}
				elseif($type=='MA')
				{
					$level='6';
				}else{
					$level='5';
				}
				$AddData=array('name'=> $this->input->post('name',TRUE),'email'=>$this->input->post('email',TRUE),'manage_user'=>$manage_user,'password'=>md5($adminpassword),'created'=>date('Y-m-d H:i:s'),'level'=>$level);		
				$res=$this->modelbasic->_insert('admin',$AddData);	
				if(isset($_POST['region']) && !empty($_POST['region']) )
				{
					foreach ($_POST['region'] as $key => $value) 
					{
						$selectInstitute = $this->db->select('id')->from('institute_master')->where('region',$value)->get()->result_array();

						if(!empty($selectInstitute))
						{
							foreach ($selectInstitute as $inst_key => $region_instituteId) 
							{
								$region_instituteId_Data = array('hoadmin_id'=>$res,'institute_id'=>$region_instituteId['id'],'region'=>$value,'zone'=>$_POST['zone']);
								$this->modelbasic->_insert('hoadmin_institute_relation',$region_instituteId_Data);								
							}
						}

					}
				}
			   else if(isset($_POST['zone']) && $_POST['zone']!= '' )
				{	
					$getRegion =  $this->db->select('id')->from('region_list')->where('zone_id',$_POST['zone'])->get()->result_array();		
					if(isset($getRegion) && !empty($getRegion) )
					{						
						foreach ($getRegion as $key => $value) 
						{							
							$selectInstitute = $this->db->select('id')->from('institute_master')->where('region',$value['id'])->get()->result_array();	
							if(!empty($selectInstitute))
							{
								foreach ($selectInstitute as $inst_key => $region_instituteId) 
								{									
									$region_instituteId_Data = array('hoadmin_id'=>$res,'institute_id'=>$region_instituteId['id'],'region'=>$value['id'],'zone'=>$_POST['zone']);
									$this->modelbasic->_insert('hoadmin_institute_relation',$region_instituteId_Data);								
								}
							}
						}
					}
				}

				/*$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$datas['fromEmail']=$emailFrom;
				$datas['to']=$this->input->post('email',TRUE);
				$datas['subject']='Admin Appointment';
				$datas['template']='Hello '.$_POST['name'].',<br/>You has been appointed as Ho Admin.<br/> Following are the your login detail,<br/>Email Id is - '.$_POST['email'].'<br/> Password - '.$adminpassword.'<br/>Click following link to login </br>Thanks & Regards<br/> Admin';
			
				$result=$this->modelbasic->sendMail($datas);*/

				if($res > 0)
				{

					$data=array('status'=>'success','for'=>'add','message'=>'Ho admin added successfully.');
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Ho admin please try again...');
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
				$data=array('status'=>'error','message'=>'Error occurred while adding Ho admin please try again...');
				echo json_encode($data);
			}
		}
	}


	public function edit_admin($id)
	{	
		$data=$this->ho_admin_model->get_single_admin($id);	
		//print_r($data);die;
		echo json_encode($data);		
	}


	public function getSelectedRegionList()
	{	

		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="" disabled="">Select Region</option>
			<?php

			foreach ($_POST['zoneId'] as $key => $value) {

				$zoneId = $value;
				$hoAdminId = $_POST['hoAdminId'];

				if($hoAdminId != 0 )
				{
					$getSelectedZone = $this->modelbasic->getSelectedData('hoadmin_institute_relation','*',array('hoadmin_id'=>$hoAdminId),$orderBy='',$dir='',$groupBy='region',$limit='',$offset='',$resultMethod='');		
				}

				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));		
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($getSelectedZone) && !empty($getSelectedZone))
						{
							foreach ($getSelectedZone as $val) {
								if($val['region'] == $value['id'])
									{ echo " selected "; }						
								}
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
	}



	function getZoneRegionList()
	{		
		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="" disabled="">Select Region</option>
			<?php
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$_POST['zoneId']));
			
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



}

