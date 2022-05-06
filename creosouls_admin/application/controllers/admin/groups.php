<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Groups extends MY_Controller
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
    	$this->load->model('admin/group_model');
	}

	public function index()
	{
		$this->load->view('admin/groups/manage_groups');
	}
	function addedit_user()
	{
		$this->load->view('admin/groups/addedit_view');
	}
	public function processForm()
	{		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('instituteId', 'Institute name', 'required');
		//$this->form_validation->set_rules('head_office_name', 'Head Office Name', 'required');
		$this->form_validation->set_rules('zone', 'Zone', 'required');
		$this->form_validation->set_rules('group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('region', 'Region', 'required');
		if ($this->form_validation->run())
		{
			if($this->input->post('groupId',TRUE) > 0)
			{
				$groupId=$this->input->post('groupId',TRUE);

				$data=array('institute_id'=>$this->input->post('instituteId',TRUE),'head_office_name'=>'Head Office','zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE),'group_name'=>$this->input->post('group_name',TRUE));			
				$res = $this->modelbasic->_update('group_master',$groupId,$data);
				if(!empty($_POST['selectUsers']))
				{
					$deletUserData = $this->modelbasic->_delete_with_condition('user_group_relation','group_id',$groupId);

					foreach ($_POST['selectUsers'] as $key => $userId) {
						$userIdData = array('user_id' => $userId,'group_id'=>$groupId);
						$this->modelbasic->_insert('user_group_relation',$userIdData);
					}					
				}

				if($res)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'Group updated successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while updating Group please try again....');
				}			
			}
			else
			{
				$data=array('institute_id'=>$this->input->post('instituteId',TRUE),'head_office_name'=>'Head Office','zone'=>$this->input->post('zone',TRUE),'region'=>$this->input->post('region',TRUE),'group_name'=>$this->input->post('group_name',TRUE),'created'=>date("Y-m-d H:i:s"));
				$groupId=$this->modelbasic->_insert('group_master',$data);

				$notificationEditEntry=array('title'=>'New Group Created','msg'=>'You are added in Group '.$this->input->post('group_name',TRUE).' on creosouls.','link'=>'','imageLink'=>'as.png','created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>0);

				$notificationId=$this->modelbasic->_insert('header_notification_master',$notificationEditEntry);

				if(!empty($_POST['selectUsers']))
				{
					foreach ($_POST['selectUsers'] as $key => $userId) {
						$userIdData = array('user_id' => $userId,'group_id'=>$groupId);
						$this->modelbasic->_insert('user_group_relation',$userIdData);

						$insertJobNotification = array('notification_id'=>$notificationId,'user_id'=>$userId,'status'=>0);
						$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);
					}					
				}
				if($groupId > 0)
				{
					$data=array('status'=>'success','for'=>'add','message'=>'Group added successfully.');
				}
				else
				{
					$data=array('status'=>'fail','message'=>'Error occurred while creating group please try again....');
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
				$this->load->view('admin/groups/addedit_view');
			}
		}
	}

	function get_ajaxdataObjects()
	{
		if($this->session->userdata('admin_level') == 4)
		{
			$ins=$this->modelbasic->getHoadminInstitutes();
		}
		$_POST['columns']='id,head_office_name,zone,region,group_name,created,status,institute_id';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);
		$selectColumns="id,head_office_name,zone,region,group_name,created,status,institute_id";	
		$condition=array();	
		$totalData=$this->modelbasic->count_all_only('group_master',$condition);
		$totalFiltered=$totalData;
		//pass concatColumns only if you want search field to be fetch from concat
		//$concatColumns='B.firstName,B.lastName';
		$result=$this->group_model->run_query('group_master',$requestData,$columns,$selectColumns);
		//print_r($result);die;
		$data = array();
			if(!empty($result))
			{
				$i=1;
				foreach ($result as $row)
				{
				  $nestedData=array();

				    $this->db->select("B.*")->from('user_group_relation as A')->join('users as B','B.id = A.user_id');
				    if($this->session->userdata('admin_level') == 4)
				    {
				    	$this->db->where_in('B.instituteId',$ins);
				    }
				    
				    $det=$this->db->where('A.group_id',$row['id'])->get()->result_array();
				    $html='';				   
				    if(!empty($det))
				  	{
				  		$j=1;
				  		foreach($det as $dt)
				  		{
				  			if($dt['status']==1){ $text="<span class='text-success'>Active</span>";}else{ $text="<span class='text-danger'>Deactive</span>";}
				  			$html.='<tr>
				  					  <td>'.$j.'</td>'.				  					  
				                      '<td>'.$dt['firstName'].'</td>'.
				                  	  '<td>'.$dt['lastName'].'</td>'.
				                  	  '<td>'.$dt['email'].'</td>'.
				                  	  '<td>'.$text.'</td>
				                     </tr>';
				               $j++;
				  		}
				  	}
				  	$nestedData['group_users']=$html;

					$zonename =$this->db->select('zone_name')->from('zone_list')->where('id',$row['zone'])->get()->row_array();
					$regionname =$this->db->select('region_name')->from('region_list')->where('id',$row['region'])->get()->row_array();
					$institutename =$this->db->select('instituteName')->from('institute_master')->where('id',$row['institute_id'])->get()->row_array();
					$nestedData['zone'] = $zonename['zone_name'];
					$nestedData['head_office_name'] = $row['head_office_name'];
					$nestedData['group_name'] = $row['group_name'];
					$nestedData['institute_name'] = $institutename['instituteName'];
					$nestedData['created'] = $row['created'];
					$nestedData['region'] = $regionname['region_name'];					
					$nestedData['chk'] = '<input type="checkbox" class="case" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					$nestedData['id'] =$i+$requestData['start'];
					if($row['status']==1)
					{
						$nestedData['status']='<span class="label label-success" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Active</span>';
					}
					else
					{
						$nestedData['status']='<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';
					}
					$nestedData['action'] = '<span class="menu-action rounded-btn"><a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a><a onclick="showInstDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><a onclick="openEditForm('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i> </a></span>';
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


	function getZoneRegionList()
	{		
		$zoneId = $_POST['zoneId'];
		$groupId = $_POST['groupId'];
		if($groupId != 0 )
		{
			$getSelectedRegion = $this->modelbasic->getSelectedData('group_master','region',array('id'=>$groupId));
		}
		$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
		?>
		<option value="">Select Region</option>
		<?php
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

	function getInstituteDataList()
		{		
			$regionId = $_POST['regionId'];
			$groupId = $_POST['groupId'];
			if($groupId != 0 )
			{
				$getSelectedRegion = $this->modelbasic->getSelectedData('group_master','institute_id',array('id'=>$groupId));
			}

			$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
			?>
			<option value="">Select Region</option>
			<?php
			if(!empty($data))
			{
				foreach($data as $value)
				{
					?>
					<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedRegion) && $getSelectedRegion[0]['institute_id'] ==$value['id']){ echo "selected"; }?>><?php echo $value['instituteName'];?> </option>
					<?php
				}
			}
			else
			{
				echo '';
			}		
		}


	function getRegionInstituteList()
	{		
		$zoneId = $_POST['zoneId'];
		$regionId = $_POST['regionId'];		
		$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
		?>
		<option value="">Select Institute </option>

		<?php
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedRegion) && $getSelectedRegion[0]['region'] ==$value['id']){ echo "selected"; }?>><?php echo $value['instituteName'];?> </option>
				<?php
			}
		}
		else
		{
			echo '';
		}		
	}	

	function getUsersDataList()
	{		
		$instituteId = $_POST['instituteId'];
		$groupId = $_POST['groupId'];
		$userid=array();	
		if($groupId != 0 )
		{
			$selectedUsers = $this->modelbasic->getSelectedData('user_group_relation','user_id',array('group_id'=>$groupId));
			
			if(!empty($selectedUsers))
			{
				foreach ($selectedUsers as $key => $userId) {
					$userid[] = $userId['user_id'];
					
				}
			}
		}
		//print_r($userid)	;die;
		$data = $this->modelbasic->getSelectedData('users','id,firstName,lastName',array('instituteId'=>$instituteId));
		?>
		<option value="">Select Users </option>

		<?php
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(!empty($userid) && in_array($value['id'], $userid)){ echo "selected";}?>><?php echo $value['firstName'].' '.$value['lastName'];?> </option>
				<?php
			}
		}
		else
		{
			echo '';
		}		
	}

function getInstituteUserList()
	{		
		$instituteId = $_POST['instituteId'];			
		$data = $this->modelbasic->getSelectedData('users','id,firstName,lastName',array('instituteId'=>$instituteId));
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedRegion) && $getSelectedRegion[0]['region'] ==$value['id']){ echo "selected"; }?>><?php echo $value['firstName'].' '.$value['lastName'];?> </option>
				<?php
			}
		}
		else
		{
			echo '';
		}		
	}

	function change_status($id = NULL)
	{
		$result = $this->modelbasic->getValue('group_master','status','id',$id);
		if($result == 1)
		{
			$data = array('status'=>'0');
			if($id != 1)
			{
				$this->session->set_flashdata('success', 'Group deactivated successfully.');
			}
		}
		else
		if($result == 0)
		{
			$data = array('status'=>'1');
			$this->session->set_flashdata('success', 'Group activated successfully.');

		}
		$this->modelbasic->_update('group_master',$id, $data);
		redirect('admin/groups');
	}

	function delete_confirm($key = NULL)
	{	
        $this->modelbasic->_delete('group_master',$key);
        $this->modelbasic->_delete_with_condition('user_group_relation','group_id',$key);
        $this->session->set_flashdata('success', 'Group\'s deleted successfully');
		redirect('admin/groups');
	}

	function multiselect_action()
	{
		if(isset($_POST['submit'])){

			$check = $_POST['checkall'];
			foreach ($check as $key => $value) {
				if($_POST['listaction'] == '1'){
					$status = array('status'=>'1');
					$this->modelbasic->_update('group_master',$key,$status);
					$this->session->set_flashdata('success', 'Group\'s activated successfully');
				}else if($_POST['listaction'] == '2'){

						$status = array('status'=>'0');
					$this->modelbasic->_update('group_master',$key,$status);

						$this->session->set_flashdata('success', 'Group\'s deactivated successfully');
				}else
				if($_POST['listaction'] == '3')
				{
	                $this->modelbasic->_delete('group_master',$key);
	                $this->modelbasic->_delete_with_condition('user_group_relation','group_id',$key);
	                $this->session->set_flashdata('success', 'Group\'s deleted successfully');
				}
			}
			redirect('admin/groups');
		}
	}
	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Group created successfully.');
			redirect(base_url().'admin/groups/');
		}
		else
		{
			$this->session->set_flashdata('success','Group updated successfully.');
			redirect(base_url().'admin/groups/');
		}
	}

	function getEditFormData()
	{
		$groupId=$this->input->post('groupId',true);
		$data=$this->group_model->getEditFormData($groupId);
		echo json_encode($data);
	}

	/*function validatepageName()
	{
		$pageName=$this->input->post('pageName',TRUE);
		$instituteId=$this->input->post('instituteId',TRUE);
		$val=$this->modelbasic->getValueWhere('group_master','pageName',array('id !='=>$instituteId,'pageName'=>$pageName));
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
*/
}
