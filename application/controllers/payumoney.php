<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payumoney extends CI_Controller
{
	public function index()
	{
		// Merchant key here as provided by Payu
		$MERCHANT_KEY = "hDkYGPQe";
		// Merchant Salt as provided by Payu
		$SALT = "yIEkykqEH3";
		// End point - change to https://secure.payu.in for LIVE mode
		$PAYU_BASE_URL = "https://test.payu.in";
		$action = base_url().'payumoney';
		$posted = array();
		if(!empty($_POST))
		{
			    //print_r($_POST);
			foreach($_POST as $key => $value)
			{
			    	$posted[$key] = $value;
			}
		}
		$formError = 0;
		if(empty($posted['txnid']))
		{
			// Generate random transaction id
			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		}
		else
		{
			$txnid = $posted['txnid'];
		}
		$hash = '';
		// Hash Sequence
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($posted['hash']) && sizeof($posted) > 0)
		{
			if(
			empty($posted['key'])
			|| empty($posted['txnid'])
			|| empty($posted['amount'])
			|| empty($posted['firstname'])
			|| empty($posted['email'])
			|| empty($posted['phone'])
			|| empty($posted['productinfo'])
			|| empty($posted['surl'])
			|| empty($posted['furl'])
			|| empty($posted['service_provider'])
			)
			{
				$formError = 1;
			}
			else
			{
				//$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
				$hashVarsSeq = explode('|', $hashSequence);
				$hash_string = '';
				foreach($hashVarsSeq as $hash_var)
				{
					$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
					$hash_string .= '|';
				}
				$hash_string .= $SALT;
				$hash = strtolower(hash('sha512', $hash_string));
				$action = $PAYU_BASE_URL . '/_payment';
			}
		}
		elseif(!empty($posted['hash']))
		{
			$hash = $posted['hash'];
			$action = $PAYU_BASE_URL . '/_payment';
		}
		$posted['hash']=$hash;
		$posted['action']=$action;
		$posted['MERCHANT_KEY']=$MERCHANT_KEY;
		$posted['formError']=$formError;
		$posted['txnid']=$txnid;
		$posted['posted']=$posted;
		$this->load->view('payumoneyview',$posted);
	}
}
