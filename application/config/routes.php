<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// CUSTOM ROUTES
// CDA PAGES
	$route['meetings'] 				= 'meetings';
	$route['meetings/:num'] 		= 'meetings';
	$route['calendar'] 				= 'mycalendar';
	$route['board-members'] 		= 'meetings/boardmembers';
	$route['staff'] 				= 'meetings/staff';
	$route['resources/(:any)']		= 'resources';
	$route['resources/(:any)/:num']	= 'resources';
	$route['faq']					= 'myfaq';
// CMA PAGES
	$route['admin'] 							= 'admin/dashboard';
	// Settings Pages
	$route['admin/billpay'] 					= 'admin/editbillpay';
	$route['admin/account'] 					= 'admin/editaccount';
	// Calendar and Notices Pages
	$route['admin/calendar'] 					= 'admin/editcalendar';
	$route['admin/calendar/:num/:num'] 			= 'admin/editcalendar/view';
	$route['admin/notices'] 					= 'admin/editnotices/all';
	$route['admin/notices/entry'] 				= 'admin/editnotices/entry';
	$route['admin/notices/entry/:num']			= 'admin/editnotices/entry';
	$route['admin/notices/all'] 				= 'admin/editnotices/all';	
	// Meetings Pages
	$route['admin/meetings-resources'] 			= 'admin/editmeetings';
	$route['admin/meetings-resources/:num'] 	= 'admin/editmeetings';
	$route['admin/board'] 						= 'admin/editboard/all';
	$route['admin/board/member']				= 'admin/editboard/member';
	$route['admin/board/member/:num'] 			= 'admin/editboard/member';
	$route['admin/board/all'] 					= 'admin/editboard/all';
	$route['admin/staff'] 						= 'admin/editstaff/all';
	$route['admin/staff/member']				= 'admin/editstaff/member';
	$route['admin/staff/member/:num'] 			= 'admin/editstaff/member';
	$route['admin/staff/all'] 					= 'admin/editstaff/all';
	// Resources Pages
	$route['admin/resources-categories']		= 'admin/editrescategories';
	$route['admin/resources']					= 'admin/editresources';
	$route['admin/resources/(.*)']				= 'admin/editresources';
	// FAQ
	$route['admin/faq'] 						= 'admin/editfaq/all';
	$route['admin/faq/entry']					= 'admin/editfaq/entry';
	$route['admin/faq/entry/:num'] 				= 'admin/editfaq/entry';
	$route['admin/faq/all'] 					= 'admin/editfaq/all';
// SCRIPTS
	$route['admin/scripts/board']				= 'admin/scripts/scriptboardmembers';
	$route['admin/scripts/board/(.+)']			= 'admin/scripts/scriptboardmembers/$1';