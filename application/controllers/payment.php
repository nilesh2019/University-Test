<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PaymentOld extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('payment_model');
		$this->load->model('model_basic');
		$this->session->unset_userdata('breadCrumb');
		$this->session->unset_userdata('breadCrumbLink');
		$this->session->set_userdata('breadCrumb','Profile');
		$this->session->set_userdata('breadCrumbLink','profile');
	}
	public function index()
	{
		//print_r($_POST);die;
		$data['user_profile']=$this->payment_model->getUserProfileData();
		$data['notification']=$this->payment_model->getUserNotificationData();
		$data['workData']=$this->payment_model->getUserWorkData();
		$data['skillsData']=$this->payment_model->getUserSkillData();
		$data['educationData']=$this->payment_model->getUserEducationData();
		$data['websiteData']=$this->payment_model->getUserWebsiteData();
		$data['cardData']=$this->payment_model->getUserCardData();
		$data['socialData']=$this->payment_model->getUserSocialData();
		$data['awardData']=$this->payment_model->getAwardData();
		$data['usedDiskSpace']=$this->getDiskSpace();
		$data['allowedDiskSpace']=$this->payment_model->getAllowedDiskSpace();
		$this->load->library('EncryptCardDetails');
		$encryptCardDetails=new EncryptCardDetails();
		// Merchant key here as provided by Payu
		$MERCHANT_KEY = "3lvw3Zgu";
		// Merchant Salt as provided by Payu
		$SALT = "WPHUFBhyKx";
		// End point - change to https://secure.payu.in for LIVE mode
		$PAYU_BASE_URL = "https://secure.payu.in";
		$action = base_url().'payment';
		//$data = array();
		if(!empty($_POST))
		{
			    //print_r($_POST);
			foreach($_POST as $key => $value)
			{
				if($key=='amount'){
					$amount = $encryptCardDetails->decrypt( $value );
					$data[$key] = $amount;
					$this->session->set_userdata('amount',$amount);
				}else if($key=='productinfo'){
					/*if(isset($_POST['productinfo']) && $value==1){
						$data[$key] = "You have purchase storage space plan 50MB";
					}else if(isset($_POST['productinfo']) && $value==2){
						$data[$key] =  "You have purchase storage space plan 100MB";
					}else if(isset($_POST['productinfo']) && $value==3){
						$data[$key] =  "You have purchase storage space plan 200MB";
					}*/
					$this->session->set_userdata('plan',$value);
					$data[$key] = $value;
				}else{
					$data[$key] = $value;
				}
			}
		}
		//print_r($data['productinfo']);die;
		$formError = 0;
		if(empty($data['txnid']))
		{
			// Generate random transaction id
			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		}
		else
		{
			$txnid = $data['txnid'];
		}
		$hash = '';
		// Hash Sequence
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($data['hash']) && sizeof($data) > 0)
		{
			if(
			empty($data['key'])
			|| empty($data['txnid'])
			|| empty($data['amount'])
			|| empty($data['firstname'])
			|| empty($data['email'])
			|| empty($data['phone'])
			|| empty($data['productinfo'])
			|| empty($data['surl'])
			|| empty($data['furl'])
			|| empty($data['service_provider'])
			)
			{
				$formError = 1;
			}
			else
			{
				//$data['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
				$hashVarsSeq = explode('|', $hashSequence);
				$hash_string = '';
				foreach($hashVarsSeq as $hash_var)
				{
					$hash_string .= isset($data[$hash_var]) ? $data[$hash_var] : '';
					$hash_string .= '|';
				}
				$hash_string .= $SALT;
				$hash = strtolower(hash('sha512', $hash_string));
				$action = $PAYU_BASE_URL . '/_payment';
			}
		}
		elseif(!empty($data['hash']))
		{
			$hash = $data['hash'];
			$action = $PAYU_BASE_URL . '/_payment';
		}
		$data['hash']=$hash;
		$data['action']=$action;
		$data['MERCHANT_KEY']=$MERCHANT_KEY;
		$data['formError']=$formError;
		$data['txnid']=$txnid;
		$data['data']=$data;
		$this->load->view('payment_view',$data);
	}
	public function getDiskSpace()
	{
		$size=0;
		$allProject=$this->payment_model->getUsersAllProject();
		if(!empty($allProject))
		{
		
			foreach($allProject as $project)
			{
				$allImages=$this->payment_model->getAllImages($project['id']);
				if(!empty($allImages))
				{
					foreach($allImages as $image)
					{
						if(file_exists(file_upload_s3_path().'project/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumbs/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/thumbs/'.$image['image_thumb']);
						}
						if(file_exists(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb'])){
							$size+=filesize(file_upload_s3_path().'project/thumb_big/'.$image['image_thumb']);
						}
					}
				}
			}
		}
		$size = number_format($size / 1048576, 2) . ' MB';
		return $size;
	}
	public function successPayUMoney(){
		//print_r($_REQUEST);die;
		$userId = $this->session->userdata('front_user_id');
		if($_REQUEST['status']=='success'){
			if($this->session->userdata('amount') == $_REQUEST['net_amount_debit']){
				$data =  array('user_id' => $userId,
				               		 'amount' => $_REQUEST['net_amount_debit'] ,
				               		 'plan' => $this->session->userdata('plan') ,
				               		 'payment_id' => $_REQUEST['mihpayid'] ,
				               		 'txnid' => $_REQUEST['txnid'] ,
				               		 'payuMoneyId' => $_REQUEST['payuMoneyId'] ,
				               		 'status' => 1,
				               		 'created' =>$_REQUEST['addedon']
				               		 );
				if(isset($_REQUEST['productinfo']) && $_REQUEST['productinfo']==1){
					$space = 50;
				}else if(isset($_REQUEST['productinfo']) && $_REQUEST['productinfo']==2){
					$space = 100;
				}else if(isset($_REQUEST['productinfo']) && $_REQUEST['productinfo']==3){
					$space = 200;
				}
				$this->payment_model->addSpaceToUser($space,$userId);
				$result = $this->payment_model->successPayUMoney($data);
				$this->session->set_flashdata('success','Payment successfully.');
			}else{
				$this->session->set_flashdata('error','You have paid invalid amount.Please contact to creosouls.');
			}
		}else{
			$data =  array('user_id' => $userId,
			               		 'payment_id' =>$_REQUEST['mihpayid'] ,
			               		 'amount' =>$_REQUEST['net_amount_debit'] ,
			               		 'plan' =>$this->session->userdata('plan') ,
			               		 'txnid' =>$_REQUEST['txnid'] ,
			               		 'payuMoneyId' => $_REQUEST['payuMoneyId'] ,
			               		 'status' => 0,
			               		 'created' =>$_REQUEST['addedon']
			               		 );
			$result = $this->payment_model->successPayUMoney($data);
			$this->session->set_flashdata('error','Payment fail. Please try again.');
		}
		redirect('payment');
	}
	public function cancel(){
		$this->session->set_flashdata('error','Payment fail. Please try again.');
		redirect('payment');
	}
}