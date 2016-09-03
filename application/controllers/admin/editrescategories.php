<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editrescategories extends EXT_AdminController {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Resource Categories';
	$description = 'Manage categories that organize resources';
	$page = 'resources-categories';
	$help = 'help-resources-categories';
	$scripts = array('scriptrescategories');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$CI =& get_instance();
	// Load things with $CI->load here
	$CI->load->model('Resource');
	$CI->load->helper('form');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {

	// Set up the variables into array keys for the view to use
	$this->add_page_data(array(
		'categories' => $this->get_categories()
	));
	$this->render_page();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_categories() {
	$query = $this->Resource->get_categories();

	if ( !$query->success ) {
		$this->add_error('Could not retrieve categories from the database. '
			.'Please try again later or contact your system administrator if this problem persists'
		);
		return false;
	}

	$categories = $query->data;

	return $categories;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
