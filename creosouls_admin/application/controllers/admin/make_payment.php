<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
*	@author : Santosh Badal
*	date	: 05 August, 2015
*	http://unichronic.com
*	Unichronic - Master Admin
*/
class Make_payment extends MY_Controller
{
	function __construct()
	{
	    	parent::__construct();
	    	$this->load->library('form_validation');
	    	$this->load->model('modelbasic');
	    	$this->load->model('admin/make_payment_model');
	}

	public function get($id)
	{
		$data['instituteID']=base64_decode(urldecode($id));
		//pr($data);die;
		$this->load->view('admin/institutes/make_payment',$data);
	}

	function get_ajaxdataObjects($instituteID='')
	{
		$_POST['columns']='id,studentId,firstName,lastName,email,status';
		$requestData= $_REQUEST;
		//print_r($requestData);die;
		$columns=explode(',',$_POST['columns']);

		$selectColumns="id,studentId,firstName,lastName,email,status";
		//print_r($columns);die;
		//get total number of data without any condition and search term
		$conditionArray=array('instituteId'=>$instituteID,'status'=>0);
		$totalData=$this->make_payment_model->count_all_only('institute_csv_users',$conditionArray);
		$totalFiltered=$totalData;

		//pass concatColumns only if you want search field to be fetch from concat
		$concatColumns='firstName,lastName';
			$result=$this->make_payment_model->run_query('institute_csv_users',$requestData,$columns,$selectColumns,$conditionArray);
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
					$nestedData['chk'] = '<input type="checkbox" class="case" onchange="checkValues();" id="check" name="checkall['.$row["id"].']" data-index="'.$row["id"].'">';
					if($row["firstName"] <> ' ')
					{
						$nestedData['firstName'] = ucwords($row["firstName"]);
					}

					if($row["lastName"] <> ' ')
					{
						$nestedData['lastName'] = ucwords($row["lastName"]);
					}
					if($row['status']==1){ $text="<span class='text-success'>Paid</span>";}else{ $text="<span class='text-danger'>Pending</span>";}
					$nestedData['email'] = $row["email"];
					$nestedData['studentId'] = $row["studentId"];
					$nestedData['status'] = $text;

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
			 		$query=$this->modelbasic->getValue('users','profileImage','id',$key);
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

			         $user_projects = $this->user_model->getAllUserProject($key);

					  if(!empty($user_projects))
					  {
					  	 foreach($user_projects as $row)
					  	 {
						 	 $this->user_model->deleteProject($row['id']);
						 }
					  }

					  $user_comments = $this->user_model->getUserComments($user_id);
					  if(!empty($user_comments))
					  {
					  	 foreach($user_comments as $val)
					  	 {
					  	 	 $this->user_model->commentCountDecrement($val['projectId']);
						 	 $this->modelbasic->_delete_with_condition('user_project_comment','id',$val['id']);
						 }
					  }

		 			  $this->modelbasic->_delete_with_condition('user_follow','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('job_user_notification','userId',$key);
		 			  $this->modelbasic->_delete_with_condition('user_project_views','userId',$key);

				      $this->modelbasic->_delete('users',$key);
				      $this->session->set_flashdata('success', 'Users\'s deleted successfully');
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

		  $this->modelbasic->_delete_with_condition('user_follow','userId',$user_id);
		  $this->modelbasic->_delete_with_condition('job_user_notification','userId',$user_id);
		  $this->modelbasic->_delete_with_condition('user_project_views','userId',$user_id);

		  $res = $this->modelbasic->_delete('users',$user_id);

		  if($res)
		  {
		  	$this->session->set_flashdata('success', 'User deleted successfully');
	      }
		  else
		  {
		  	$this->session->set_flashdata('fail', 'Fail to delete user');
		  }
		  redirect('admin/users');
 	}


	function addQty()
	{
		if(isset($_POST['checkValues']))
		{
			$this->session->unset_userdata(array('total','quantity','rate'));
			$rate=$this->modelbasic->getValue('settings','description','type','subscription_rate');
			$data=array('rate'=>number_format($rate,2),'quantity'=>$_POST['checkValues'],'total'=>number_format(($rate*$_POST['checkValues']),2,'.', ''),'studentId'=>$_POST['studentId']);
			$this->session->set_userdata($data);
			echo json_encode($data);
		}
	}

	function success()
	{
		if(!empty($_POST) && $_POST['status'] == 'success')
		{
			if($_POST['amount'] == $this->session->userdata('total'))
			{
				$data= array('user_name' => $this->session->userdata('admin_name'),'total_amount'=>$this->session->userdata('total'),'quantity'=>$this->session->userdata('quantity'),'price'=>$this->session->userdata('rate'),'paid_amount'=>$_POST['amount'],'status'=>1);
				$this->modelbasic->_insert('payments',$data);
				$studentData=$this->session->userdata('studentId');
				$instituteID=$this->modelbasic->getValue('institute_csv_users','instituteId','id',$studentData[0]);
				$path = './receipts/'.$instituteID.'/';
				$pdfs = glob($path."*.pdf");

				foreach($pdfs as $file)
				{
					if(is_file($file))
					    unlink($file);
				}

				if(!empty($studentData))
				{
					foreach ($studentData as $value)
					{
						$this->modelbasic->_update_custom('institute_csv_users','id',$value,array('status'=>1));
	    					date_default_timezone_set('Asia/Kolkata');
						$start_date=date('Y-m-d H:i:s');
						$end_date=date('Y-m-d H:i:s', strtotime('+1 years'));
						$membershipInfo=array('csvuserId'=>$value,'end_date'=>$end_date,'start_date'=>$start_date,'status'=>1);
						$invoiceId=$this->modelbasic->_insert('student_membership',$membershipInfo);
						$membershipInfo['invoiceId']=$invoiceId;
						$studentFirstName=$this->modelbasic->getValue('institute_csv_users','firstName','id',$value);
						$studentLastName=$this->modelbasic->getValue('institute_csv_users','lastName','id',$value);
						$instituteID=$this->modelbasic->getValue('institute_csv_users','instituteId','id',$value);
						$instituteName=$this->modelbasic->getValue('institute_master','instituteName','id',$instituteID);
						$membershipInfo['studentName']=$studentFirstName.' '.$studentLastName;
						$membershipInfo['total']=$this->session->userdata('rate');
						$membershipInfo['amount']=$this->session->userdata('rate');
						$membershipInfo['instituteID']=$instituteID;
						$membershipInfo['instituteName']=$instituteName;
						$this->generateInvoice($membershipInfo);
					}
				}

				$path = './receipts/'.$instituteID.'/';
				$pdfs = glob($path."*.pdf");
				$this->load->library('zip');
				foreach($pdfs as $file)
				{
					$this->zip->read_file($file);
				}
				$this->zip->archive('./receipts/'.$instituteID.'/receipt.zip');
				$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
				$from=$emailFrom;
				$message='Hello '.$this->session->userdata('admin_name').'<br/><br/> Please find the attachment containing Payment receipts of creosouls subscription.';
				$emailData=array('to'=>$this->session->userdata('admin_email'),'from'=>$from,'subject'=>'Payment receipts of creosouls subscription','template'=>$message,'attachment'=>'./receipts/'.$instituteID.'/receipt.zip');
				$this->modelbasic->sendMailWithAttachment($emailData);
				$this->session->set_flashdata('success','Your payment has been processed successfully.');
			}
			else
			{
				$data= array('user_name' => $this->session->userdata('admin_name'),'total_amount'=>$this->session->userdata('total'),'quantity'=>$this->session->userdata('quantity'),'price'=>$this->session->userdata('rate'),'paid_amount'=>$_POST['amount'],'status'=>2);
				$this->modelbasic->_insert('payments',$data);
				$this->session->set_flashdata('error','You have supposed to pay <strong>'.$this->session->userdata('total').' <i class="fa fa-rupee"></i>,</strong> but you have paid <strong>'.$_POST['amount'].' <i class="fa fa-rupee"></i></strong>, so please contact institute admin for further proceedings.');
			}
		}
		else
		{
			$data= array('user_name' => $this->session->userdata('admin_name'),'total_amount'=>$this->session->userdata('total'),'quantity'=>$this->session->userdata('quantity'),'price'=>$this->session->userdata('rate'),'paid_amount'=>0,'status'=>0);
			$this->modelbasic->_insert('payments',$data);
			$this->session->set_flashdata('error','Payment is failed, please try again.');
		}
		$this->session->unset_userdata(array('quantity'=>'','rate'=>'','studentId'=>'','total'=>''));
		redirect('admin/institutes/');
	}

	function cancel()
	{
		if(empty($_POST))
		{
			$data= array('user_name' => $this->session->userdata('admin_name'),'total_amount'=>$this->session->userdata('total'),'quantity'=>$this->session->userdata('quantity'),'price'=>$this->session->userdata('rate'),'paid_amount'=>0,'status'=>3);
			$this->modelbasic->_insert('payments',$data);
			$this->session->set_flashdata('error','Payment is canceled, please try again.');
		}
		$this->session->unset_userdata(array('total','quantity','rate','studentId'));
		redirect('admin/institutes/');
	}

	function failure()
	{
		if(!empty($_POST) && $_POST['status'] != 'success')
		{
			$data= array('user_name' => $this->session->userdata('admin_name'),'total_amount'=>$this->session->userdata('total'),'quantity'=>$this->session->userdata('quantity'),'price'=>$this->session->userdata('rate'),'paid_amount'=>0,'status'=>0);
			$this->modelbasic->_insert('payments',$data);
			$this->session->set_flashdata('error','Payment is failed, please try again.');
			$this->session->unset_userdata(array('total','quantity','rate','studentId'));
			redirect('admin/institutes/');
		}
	}

	function generateInvoice($membershipInfo)
	{
		$userId=$membershipInfo['csvuserId'];
		$start_date=$membershipInfo['start_date'];
		$end_date=$membershipInfo['end_date'];
		$invoiceId=$membershipInfo['invoiceId'];
		$studentName=$membershipInfo['studentName'];
		$amount=$membershipInfo['amount'];
		$total=$membershipInfo['total'];
		$instituteName=$membershipInfo['instituteName'];
		$instituteID=$membershipInfo['instituteID'];
		$totalInWord=$this->modelbasic->convertNumberToWords($total);
		$emailFrom = $this->modelbasic->getValueArray("settings","description",array('settings_id'=>7,'type'=>'from_email'));
		$html='<!DOCTYPE html>
				<html>
				<head>
				    <title>Receipt</title>
				    <style>
				        *
				        {
				            margin:0;
				            padding:0;
				            font-family:Arial;
				            font-size:10pt;
				            color:#000;
				        }
				        body
				        {
				            width:100%;
				            font-family:Arial;
				            font-size:10pt;
				            margin:0;
				            padding:0;
				        }

				        p
				        {
				            margin:0;
				            padding:0;
				        }

				        #wrapper
				        {
				            width:180mm;
				            margin:0 15mm;
				        }

				        .page
				        {
				            height:297mm;
				            width:210mm;
				            page-break-after:always;
				        }

				        table
				        {
				            border-left: 1px solid #ccc;
				            border-top: 1px solid #ccc;

				            border-spacing:0;
				            border-collapse: collapse;

				        }

				        table td
				        {
				            border-right: 1px solid #ccc;
				            border-bottom: 1px solid #ccc;
				            padding: 2mm;
				        }

				        table.heading
				        {
				            height:50mm;
				        }

				        h1.heading
				        {
				            font-size:14pt;
				            color:#000;
				            font-weight:normal;
				        }

				        h2.heading
				        {
				            font-size:9pt;
				            color:#000;
				            font-weight:normal;
				        }

				        hr
				        {
				            color:#ccc;
				            background:#ccc;
				        }

				        #invoice_body
				        {
				           // height: 149mm;
				        }

				        #invoice_body , #invoice_total
				        {
				            width:100%;
				        }
				        #invoice_body table , #invoice_total table
				        {
				            width:100%;
				            border-left: 1px solid #ccc;
				            border-top: 1px solid #ccc;

				            border-spacing:0;
				            border-collapse: collapse;

				            margin-top:5mm;
				        }

				        #invoice_body table td , #invoice_total table td
				        {
				            text-align:center;
				            font-size:9pt;
				            border-right: 1px solid #ccc;
				            border-bottom: 1px solid #ccc;
				            padding:2mm 0;
				        }

				        #invoice_body table td.mono  , #invoice_total table td.mono
				        {
				            font-family:monospace;
				            text-align:right;
				            padding-right:3mm;
				            font-size:10pt;
				        }

				        #footer
				        {
				            width:180mm;
				            margin:0 15mm;
				            padding-bottom:3mm;
				        }
				        #footer table
				        {
				            width:100%;
				            border-left: 1px solid #ccc;
				            border-top: 1px solid #ccc;

				            background:#eee;

				            border-spacing:0;
				            border-collapse: collapse;
				        }
				        #footer table td
				        {
				            width:25%;
				            text-align:center;
				            font-size:9pt;
				            border-right: 1px solid #ccc;
				            border-bottom: 1px solid #ccc;
				        }
				    </style>
				</head>
				<body>
				<div id="wrapper">

				    <p style="text-align:center; font-weight:bold; padding-top:5mm;">RECEIPT</p>
				    <br />
				    <table class="heading" style="width:100%;">
				        <tr>
				            <td style="width:80mm;">
				                <h1 class="heading">creosouls</h1>
				                <h2 class="heading">
				                    123 Happy Street<br />
				                    CoolCity - Pincode<br />
				                    Region , Country<br />

				                    Website : '.front_base_url().'<br />
				                    E-mail : '.$emailFrom.'<br />
				                    Phone : +1 - 123456789
				                </h2>
				            </td>
				            <td rowspan="2" valign="top" align="right" style="padding:3mm;">
				                <table>
				                    <tr><td>Receipt No : </td><td>'.$invoiceId.'</td></tr>
				                    <tr><td>Dated : </td><td>'.date("Y-m-d").'</td></tr>
				                    <tr><td>Currency : </td><td>INR</td></tr>
				                </table>
				            </td>
				        </tr>
				        <tr>
				            <td>
				                <b>Student</b> :<br />
				               '.$studentName.'<br />
				            Student Address
				                <br />
				                City - Pincode , Country<br />
				            </td>
				        </tr>
				    </table>


				    <div id="content">

				        <div id="invoice_body">
				            <table>
				            <tr style="background:#eee;">
				                <td style="width:8%;"><b>Sl. No.</b></td>
				                <td><b>Product</b></td>
				                <td style="width:15%;"><b>Quantity</b></td>
				                <td style="width:15%;"><b>Rate</b></td>
				                <td style="width:15%;"><b>Total</b></td>
				            </tr>
				            </table>

				            <table>
				            <tr>
				                <td style="width:8%;">1</td>
				                <td style="text-align:left; padding-left:10px;">One year membership for creosouls portal.</td>
				                <td class="mono" style="width:15%;">1</td><td style="width:15%;" class="mono">'.$amount.'</td>
				                <td style="width:15%;" class="mono">'.$total.'</td>
				            </tr>
				            <tr>
				                <td colspan="3"></td>
				                <td></td>
				                <td></td>
				            </tr>

				            <tr>
				                <td colspan="3"></td>
				                <td>Total :</td>
				                <td class="mono">'.$total.'</td>
				            </tr>
				        </table>
				        </div>
				        <div id="invoice_total">
				            Total Amount :
				            <table>
				                <tr>
				                    <td style="text-align:left; padding-left:10px;">'.$totalInWord.'</td>
				                    <td style="width:15%;">INR</td>
				                    <td style="width:15%;" class="mono">'.$total.'</td>
				                </tr>
				            </table>
				        </div>
				        <br />
				        <hr />
				        <br />



				        <table style="width:100%; height:35mm;">
				            <tr>
				                <td style="width:65%;" valign="top">
				                    Declaration :<br />
				                    We declare that this receipt shows<br />
				                    the actual price and payments details of subscription.
				                    <br />
				                    and that all particulars are true and correct.<br /><br />
				                </td>
				                <td>
				                <div id="box">
				                    E &amp; O.E.<br />
				                    For creosouls<br /><br /><br /><br />
				                    Authorised Signatory
				                </div>
				                </td>
				            </tr>
				        </table>
				    </div>
				    <br />
				    </div>
				</body>
				</html>';
				$this->load->library('MPDF53/mpdf');
				$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
				$mpdf->SetDisplayMode('fullpage');
				$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
				$mpdf->WriteHTML($html);
				if(!is_dir('./receipts/'.$instituteID))
				{
					@mkdir('./receipts/'.$instituteID, 0777, TRUE);
				}
				$mpdf->Output('./receipts/'.$instituteID.'/'.$userId.'.pdf','F');
	}
}
