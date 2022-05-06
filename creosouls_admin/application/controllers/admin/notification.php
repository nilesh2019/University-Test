<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Notification extends MY_Controller
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
    	$this->load->model('admin/notification_model');
	}

	public function index()
	{
		$this->load->view('admin/notification/manage_notification');
	}
	
	public function processForm()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('notification', 'Notification', 'required');		
		if ($this->form_validation->run())
		{			
			$data = array('msg'=>$_POST['notification'],'title'=>'New Notification from creosouls','link'=>$_POST['link'],'created'=>date('Y-m-d H:i:s'),'typeId'=>0,'redirectId'=>0,'imageLink'=>'as.png');
			$insertHeaderNotification = $this->modelbasic->_insert('header_notification_master',$data);
			$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));

			if(isset($_POST['groupId'] ))
			{
				foreach ($_POST['groupId'] as $group) 
				{	
					$users = $this->db->select('B.id as userId,B.firstName,B.lastName,B.email')->from('user_group_relation as A')->join('users as B','A.user_id = B.id')->where('A.group_id',$group)->get()->result_array();

					if(!empty($users))
					{
						foreach($users as $user)
						{
							$template ='Hello <b>'.$user['firstName'].' '.$user['lastName'].'</b>,<br />You have new notification from Admin.<br/>'.$_POST['notification'].'<br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$emailData = array('to'=>$user['email'],'subject'  =>'New Notification from creosouls','template' =>$template,'fromEmail'=>$emailFrom);
							//$this->modelbasic->sendMail($emailData);

							$insertJobNotification = array('notification_id'=>$insertHeaderNotification,'user_id'=>$user['userId'],'status'=>0);
							$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);

						}
					}
				}		
			}
			else if(isset($_POST['instituteId'] ))
			{
				foreach ($_POST['instituteId'] as $instituteId) 
				{	
					$users = $this->modelbasic->getSelectedData('users','id,firstName,lastName,email',array('instituteId'=>$instituteId));

					if(!empty($users))
					{
						foreach($users as $user)
						{
							$template ='Hello <b>'.$user['firstName'].' '.$user['lastName'].'</b>,<br />You have new notification from Admin.<br/>'.$_POST['notification'].'<br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
							$emailData = array('to'=>$user['email'],'subject'  =>'New Notification from creosouls','template' =>$template,'fromEmail'=>$emailFrom);
							//$this->modelbasic->sendMail($emailData);

							$insertJobNotification = array('notification_id'=>$insertHeaderNotification,'user_id'=>$user['id'],'status'=>0);
							$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);
						}
					}
				}		
			}
			else if(isset($_POST['region'] ))
			{
				foreach ($_POST['region'] as $singleRegion) 
				{
					$getInstitudeIds = $this->modelbasic->getSelectedData('institute_master','id',array('region'=>$singleRegion));
					if(!empty($getInstitudeIds))
					{
						foreach ($getInstitudeIds as $key => $value) {
							$users = $this->modelbasic->getSelectedData('users','id,firstName,lastName,email',array('instituteId'=>$value['id']));

							if(!empty($users))
							{
								foreach($users as $user)
								{
									$template ='Hello <b>'.$user['firstName'].' '.$user['lastName'].'</b>,<br />You have new notification from Admin.<br/>'.$_POST['notification'].'<br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
									$emailData = array('to'=>$user['email'],'subject'  =>'New Notification from creosouls','template' =>$template,'fromEmail'=>$emailFrom);
									//$this->modelbasic->sendMail($emailData);

									$insertJobNotification = array('notification_id'=>$insertHeaderNotification,'user_id'=>$user['id'],'status'=>0);
									$this->modelbasic->_insert('header_notification_user_relation',$insertJobNotification);
								}
							}
					
						}
					}					
				}		
			}

			else if(isset($_POST['zone'] ))
			{
				foreach ($_POST['zone'] as $singleZone) 
				{
					$getInstitudeIds = $this->modelbasic->getSelectedData('institute_master','id',array('zone'=>$singleZone));
					if(!empty($getInstitudeIds))
					{
						foreach ($getInstitudeIds as $key => $value) {
							$users = $this->modelbasic->getSelectedData('users','id,firstName,lastName,email',array('instituteId'=>$value['id']));

							if(!empty($users))
							{
								foreach($users as $user)
								{
									$template ='Hello <b>'.$user['firstName'].' '.$user['lastName'].'</b>,<br />You have new notification from Admin.<br/>'.$_POST['notification'].'<br />Thanks,<br />Team creosouls<br /><a href="http://www.creosouls.com">www.creosouls.com</a>';
									$emailData = array('to'=>$user['email'],'subject'  =>'New Notification from creosouls','template' =>$template,'fromEmail'=>$emailFrom);
									//$this->modelbasic->sendMail($emailData);
								}
							}
					
						}
					}					
				}		
			}
			if($insertHeaderNotification > 0)
			{
				$data=array('status'=>'success','for'=>'add','message'=>'Notification added successfully.');
			}
			else
			{
				$data=array('status'=>'fail','message'=>'Error occurred while creating Notification please try again....');
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
				$this->load->view('admin/notification/addedit_view');
			}
		}
	}

	function getZoneRegionList()
	{
		if(!empty($_POST['zoneId']))
		{
			?>
			<option value="">Select Zone</option>
			<?php
			foreach ($_POST['zoneId'] as $key => $value) {

				$zoneId = $value;
				$notificationId = $_POST['notificationId'];
				if($notificationId != 0 )
				{
					$getSelectedRegion = $this->modelbasic->getSelectedData('notification_master','region',array('id'=>$notificationId));		
				}
				$data = $this->modelbasic->getSelectedData('region_list','id,region_name',array('zone_id'=>$zoneId));
				?>
				
				<?php
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"<?php if(isset($getSelectedZone) && !empty($getSelectedZone))
						{
							foreach ($getSelectedZone as $val) {
								if($val['zone_id'] == $value['id'])
									{ echo "selected"; }						
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

function getInstituteDataList()
	{		
		$regionId = $_POST['regionId'];
		$notificationId = $_POST['notificationId'];
		if($notificationId != 0 )
		{
			$getSelectedInstitude = $this->modelbasic->getSelectedData('notification_master','institute_id',array('id'=>$notificationId));
		}

		$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$regionId));
		?>
		<option value="">Select Institute</option>
		<?php
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedInstitude) && $getSelectedInstitude[0]['institute_id'] ==$value['id']){ echo "selected"; }?>><?php echo $value['instituteName'];?> </option>
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
		?>
		<option value="">Select Institute </option>
		<?php
		if(!empty($regionId))
		{
			foreach ($regionId as $key => $value) {
				$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('region'=>$value));
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
	}

function getZoneInstituteList()
	{	

		$zoneId = $_POST['zoneId'];	
		
		?>
		<option value="">Select Institute </option>
		<?php
		if(!empty($zoneId))
		{
			foreach ($zoneId as $key => $value) {
				$data = $this->modelbasic->getSelectedData('institute_master','id,instituteName',array('zone'=>$value));

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
	}	

function getInstituteGroupList()
	{		
		$instituteId = $_POST['instituteId'];	
		?>
		<option value="">Select Group </option>
		<?php 
		if(!empty($instituteId))
		{
			foreach ($instituteId as $key => $value) {
				$data = $this->modelbasic->getSelectedData('group_master','id,group_name',array('institute_id'=>$value));
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>
						<option value="<?php echo $value['id'];?>"><?php echo $value['group_name'];?> </option>
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

	function getGroupDataList()
	{		
		$institudeId = $_POST['institudeId'];			
		$notificationId = $_POST['notificationId'];		
		if($notificationId != 0 )
		{
			$getSelectedGroup = $this->modelbasic->getSelectedData('notification_master','group_id',array('id'=>$notificationId));
		}
		$data = $this->modelbasic->getSelectedData('group_master','id,group_name',array('institute_id'=>$institudeId));		
		?>
		<option value="">Select Group </option>
		<?php
		if(!empty($data))
		{
			foreach($data as $value)
			{
				?>
				<option value="<?php echo $value['id'];?>" <?php if(isset($getSelectedGroup) && $getSelectedGroup[0]['group_id'] ==$value['id']){ echo "selected"; }?>><?php echo $value['group_name'];?> </option>
				<?php
			}
		}
		else
		{
			echo '';
		}		
	}

	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Notification created successfully.');
			redirect(base_url().'admin/notification/');
		}
		else
		{
			$this->session->set_flashdata('success','Notification updated successfully.');
			redirect(base_url().'admin/notification/');
		}
	}
}
