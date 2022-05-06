<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Assignment extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();
    	$this->load->library('form_validation');
    	$this->load->model('modelbasic');
    	$this->load->model('admin/assignment_model');
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
		$this->load->view('admin/assignment/manage_assignment');
	}
	function get_ajaxdataObjects($institute='')
	{
		$_POST['columns']='id,name,status,created';
		$requestData= $_REQUEST;
		$columns=explode(',',$_POST['columns']);
		$selectColumns="assignment_template.id,assignment_template.product_id,assignment_template.assignment_name,assignment_template.duration,assignment_template.status,assignment_template.created,assignment_template.description,product.product_name";
		$totalData=$this->assignment_model->count_all_only('assignment_template');
		$totalFiltered=$totalData;		
		$result=$this->assignment_model->run_query('assignment_template',$requestData,$columns,$selectColumns,'','',$institute);
		
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
					if($row["assignment_name"] <> ' ')
					{
						$nestedData['name'] = ucwords($row["assignment_name"]);
					}
					else
					{
						$nestedData['name'] = ucwords('No Name');
					}
					$nestedData['created'] = date("d-M-Y", strtotime($row["created"]));	
					$nestedData['description'] = $row["description"];
					$nestedData['product_name'] = $row["product_name"];				
						if($row['status']==1)
						{
							$nestedData['status']='<span class="label label-success" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Active</span>';
						}
						else
						{
							$nestedData['status']='<span class="label label-danger" onclick="change_status('.$row['id'].')" style="cursor: pointer;">Deactive</span>';
						}
						
						$nestedData['action'] = '<a onclick="showDetails(this)" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a><span class="menu-action rounded-btn"><a onclick="edit_assignment('.$row['id'].')" class="btn menu-icon vd_bd-yellow vd_yellow" data-placement="top" data-toggle="tooltip" data-original-title="edit"> <i class="fa fa-pencil"></i></a><a class="btn menu-icon vd_bd-red vd_red" onclick="delete_confirm('.$row['id'].')" data-original-title="delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a></span>';

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
					$this->modelbasic->_update('assignment_template',$key,$status);

					$this->session->set_flashdata('success', 'Assignment template\'s activated successfully');


				}else if($_POST['listaction'] == '2'){
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{
						$status = array('status'=>0);
						$this->modelbasic->_update('assignment_template',$key,$status);
						$this->session->set_flashdata('success', 'Assignment template\'s deactivated successfully');
					}
					else
					{
						$this->session->set_flashdata('error', 'Fail to Dactive Assignment');

					}

				}else
				if($_POST['listaction'] == '3')
				{
					if($key!=1 && $this->session->userdata('admin_id')!=$key)
					{			 		
					      $this->modelbasic->_delete('assignment_template',$key);
					      $this->session->set_flashdata('success', 'assignment template\'s deleted successfully');
				     }
				     else
				     {
				     	$this->session->set_flashdata('error', 'Fail to Delet Assignment template');

				     }
				}

			}

			redirect('admin/assignment');
		}
	}

	public function delete_confirm($id)
	{
		$res = $this->modelbasic->_delete('assignment_template',$id);
		if($res ==1)
		{
		  $this->session->set_flashdata('success', 'Assignment template deleted successfully');
		  redirect('admin/assignment');
	    }
		else
		{
		  $this->session->set_flashdata('error', 'Fail to delete Assignment template');
		  redirect('admin/assignment');
		}

 	}


	function change_status($id = NULL)
	{
		
		$result = $this->modelbasic->getValue('assignment_template','status','id',$id);
		if($result == 1)
		{
			if($id!=1 && $this->session->userdata('admin_id')!=$id)
			{

				$data = array('status'=>0);
				$this->session->set_flashdata('success', 'Assignment template deactivated successfully.');
			}
			else
			{
				$this->session->set_flashdata('error', 'Fail to change status');
				redirect('admin/assignment');

			}

		}else if($result == 0)
		{
			$data = array('status'=>1);
			$this->session->set_flashdata('success', 'Assignment template activated successfully.');
		}
		$this->modelbasic->_update('assignment_template',$id, $data);
		redirect('admin/assignment');
		
	}

	

	public function add()
	{
		$id=$this->input->post('id',TRUE);
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		//$this->form_validation->set_rules('tool', 'Tool', 'trim|required');	
		if ($this->form_validation->run())
		{
			
			if($id !='')
			{
				$updateData=array('assignment_name'=> $this->input->post('name',TRUE),'description'=>$this->input->post('description',TRUE),'product_id'=>$this->input->post('product',TRUE),'duration'=>$this->input->post('duration',TRUE),'created'=>date('Y-m-d H:i:s'),'status'=>1);

				$res=$this->modelbasic->_update('assignment_template',$id,$updateData);
				$this->modelbasic->_delete_with_condition('assignment_template_tools_relation','assignment_template_id',$id);
				if(isset($_POST['tool']) && !empty($_POST['tool']) )
				{
					foreach ($_POST['tool'] as $key => $value) 
					{
						$toolData = array('assignment_template_id'=>$id,'tool_id'=>$value);
						$this->modelbasic->_insert('assignment_template_tools_relation',$toolData);
					}
				}
				if($res==1)
				{
					$data=array('status'=>'success','for'=>'edit','message'=>'Assignment template updated successfully.');
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while update Assignment template please try again...');
				}
				echo json_encode($data);
			}
			else
			{
				$AddData=array('assignment_name'=> $this->input->post('name',TRUE),'description'=>$this->input->post('description',TRUE),'product_id'=>$this->input->post('product',TRUE),'duration'=>$this->input->post('duration',TRUE),'created'=>date('Y-m-d H:i:s'),'status'=>1);
							
				$res=$this->modelbasic->_insert('assignment_template',$AddData);
				
				if(isset($_POST['tool']) && !empty($_POST['tool']) )
				{
					foreach ($_POST['tool'] as $key => $value) 
					{
						$toolData = array('assignment_template_id'=>$res,'tool_id'=>$value);
						$this->modelbasic->_insert('assignment_template_tools_relation',$toolData);
					}
				}
					
				if($res > 0)
				{

					$data=array('status'=>'success','for'=>'add','message'=>'Assignment template added successfully.');
				}
				else
				{
					$data=array('status'=>'error','message'=>'Error occurred while adding Assignment template please try again...');
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
				$data=array('status'=>'error','message'=>'Error occurred while adding Assignment template please try again...');
				echo json_encode($data);
			}
		}
	}

	public function edit_assignment($id)
	{	
		$data=$this->assignment_model->get_single_assignment_template($id);	

		echo json_encode($data);		
	}

	
	function setFlashdata($function)
	{
		if($function == 'add')
		{
			$this->session->set_flashdata('success','Assignment template details added successfully.');
			redirect(base_url().'admin/assignment/');
		}
		else
		{
			$this->session->set_flashdata('success','Assignment template details updated successfully.');
			redirect(base_url().'admin/assignment/');
		}
	}
	function getToolAttributeList()
	{		
		if(!empty($_POST['toolId']))
		{
			?>
			<option value="" disabled="">Select Attribute</option>
			<?php
				$data = $this->modelbasic->getSelectedData('attribute_value_master','id,attributeValue',array('attributeId'=>$_POST['toolId']));
			
				if(!empty($data))
				{
					foreach($data as $value)
					{
						?>		

						<option value="<?php echo $value['id'];?>"><?php echo $value['attributeValue'];?> </option>
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

