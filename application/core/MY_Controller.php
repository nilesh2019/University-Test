<?php
class MY_Controller extends CI_Controller
{
	public function __construct($props = array())
	{
		parent::__construct($props);
	}
	function isLoggedIn()
	{
		$this->CI =& get_instance();
		$FRONT_USER_SESSION_ID = intval($this->CI->session->userdata('front_user_id'));
		if($FRONT_USER_SESSION_ID > 0 && $this->CI->session->userdata('front_is_logged_in') === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>