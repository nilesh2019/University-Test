<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
$config =
	array(
		// set on "base_url" the relative url that point to HybridAuth Endpoint
		'base_url' => '/hauth/endpoint',
		"providers" => array (
			// openid providers
			"OpenID" => array (
				"enabled" => true
			),
			"Yahoo" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),
			"AOL"  => array (
				"enabled" => true
			),
			"Google" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "4100401551-c0smmlo2j8a94mas8kf13qvo3ivujsrj.apps.googleusercontent.com", "secret" => "tl3CTBNdbAQVW_wU78J6gpL6" ),
			),
			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "1438090899800763", "secret" => "ac753768a5caef8ebe3f8e9280010900" ),
			),
			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "mCF4Cvo6GcMeBTfQkItRP5vjW", "secret" => "yz6cbygZWLbSeek3ZJX76EQ7jElNcoCk0U3VZIfjvLlLJmatg0" )
			),
			// windows live
			"Live" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),
			"MySpace" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),
			"LinkedIn" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "75b6676hg918z3", "secret" => "3Xa6miKufj8DskBJ" )
			),
			"Foursquare" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => (ENVIRONMENT == 'development'),
		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);
/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */