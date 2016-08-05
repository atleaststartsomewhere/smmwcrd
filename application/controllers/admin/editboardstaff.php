<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editboardstaff extends EXT_AdminController {
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
	$title = 'Edit Board and Staff';
	$heading = 'Board Members and Staff';
	$description = 'Sort and update members on the Board and Staff';
	$page = 'board-and-staff';
	$help = 'help-board-and-staff';
	$scripts = array('scriptboardstaff');
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

	$this->add_page_data(array(
		'widget_board_list' => '',
		'widget_staff_list' => ''
	));

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
