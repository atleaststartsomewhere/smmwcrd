<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editbillpay extends EXT_AdminController {
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
	$title = 'Edit Bill Pay Settings';
	$heading = 'Edit Bill Pay Settings';
	$description = 'You are Now Editing the Bill Pay Settings';
	$page = 'billpay';
	$help = 'help-bill-pay-link';
	$scripts = array('scriptbillpay');
	parent::__construct($title, $heading, $description, $page, $help, $scripts);

	// Loader Calls
	$ci =& get_instance(); // Get the CI instance to load resources
	$ci->load->model('Content');
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
	$content_group = $this->get_content(array('paybill_link'));

	$this->add_page_data($content_group);
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
private function get_content($content_keys_array=array()) {
	if ( empty($content_keys_array) )
		return false;

	$query = $this->Content->get_items_by_keys($content_keys_array);

	if ( !$query->success )
		return false;

	return $query->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
