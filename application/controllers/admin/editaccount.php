<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editaccount extends EXT_AdminController {
//		Inherited Methods:
//			add_page_data($data=array(), $reset=false)
//			get_content($content_keys_array=array())
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CONSTRUCTOR
//			parent::__construct($title:string, $heading:string, $description:string, 
//				$viewFileName:string, $helpFileName:string, $scriptPaths:array())
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	// Set up parent construct and call
	$title = 'My Account';
	$heading = 'Manage Your Account';
	$description = 'Change Your Account Settings';
	$page = 'account';
	$help = 'help-my-account';
	$scripts = array('scriptaccount');
	parent::__construct($title, $heading, $description, $page, $help, $scripts);

	// Loader Calls
	$ci =& get_instance(); // Get the CI instance to load resources
	$ci->load->helper('form');
} // END __construct()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		SUB-ROUTES
//			index
//			view
//
//======================================================================================================
/*
** 	index()
**
*/
//------------------------------------------------------------------------------------------------------
public function index() {


	$this->render_page();
} // END index()

////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		WIDGET RENDERING
//			
//
//======================================================================================================

////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPERS
//			
//
//======================================================================================================

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
