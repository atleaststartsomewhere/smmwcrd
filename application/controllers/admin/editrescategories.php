<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editrescategories extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
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
		'categories' => $this->get_categories(),
		'max_categories' => $this->config->item('resources_max_categories')
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
	$max_categories = (int)$this->config->item('resources_max_categories');
	$query = $this->Resource->get_categories();

	if ( !$query->success ) {
		$this->add_error('Could not retrieve categories from the database. '
			.'Please try again later or contact your system administrator if this problem persists'
		);
		return false;
	}

	// We can only have as many categories as the config allows.  Get categories from the
	// database and then populate the remainder with empty categories so the view knows
	// to put in blank forms
	$categories = $query->data;
	if ( count($categories) < $max_categories ) {
		for ( $i = count($categories); $i < $max_categories; $i++) {
			array_push($categories, NULL);
		}
	}

	return $categories;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
