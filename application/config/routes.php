<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "my_default";
$route['404_override'] = 'defult_error';
$pageName = explode('/', $_SERVER['REQUEST_URI']);
require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();
if($pageName[1]=='projectDetail')
{
	$query = $db->where('projectPageName', urldecode($pageName[2]) ); //check pageName name
	$query = $db->get( 'project_master' );
	if($query->num_rows > 0){ //if exits the create routing
		$data = $query->row();
	    $route['(:any)'] = 'project/projectDetail/'.$data->id.'/'.$data->userId; // here you can define any controller and function name as required for the demo I have given this "'pageName/'.$pageName[1]"
	}
}
elseif($pageName[1]=='competition')
{
	$query = $db->where('pageName', $pageName[2] );
	$query = $db->get( 'competitions' );
	if($query->num_rows > 0)
	{
		$data = $query->row();
	    $route['(:any)'] = 'competition/get_competition/'.$data->id;
	}
}
elseif($pageName[1]=='creative_mind_competitions')
{
	$query = $db->where('pageName', $pageName[2] );
	$query = $db->get( 'creative_mind_competition' );
	if($query->num_rows > 0)
	{
		$data = $query->row();
	    $route['(:any)'] = 'creative_mind_competitions/get_competition/'.$data->id;
	}
}
elseif(isset($pageName[2]) && $pageName[2]=='alumini_projects')
{
	$query = $db->where('pageName', $pageName[1] );
	$query = $db->get( 'institute_master' );
	if($query->num_rows > 0)
	{
	    $route['(:any)'] = 'institute/alumini_projects/'.$pageName[1];
	}
}
elseif(isset($pageName[2]) && $pageName[2]=='alumini_people')
{
	$query = $db->where('pageName', $pageName[1] );
	$query = $db->get( 'institute_master' );
	if($query->num_rows > 0)
	{
	    $route['(:any)'] = 'institute/alumini_people/'.$pageName[1];
	}
}
else
{
	$query = $db->where('pageName', $pageName[1] );
	$query = $db->get( 'institute_master' );
	if($query->num_rows > 0)
	{
	    $route['(:any)'] = 'institute/detail/'.$pageName[1];
	}
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */