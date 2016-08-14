<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stored Content:
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editresources extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Resources: Manage resources';
	$description = 'Change, upload and delete resources';
	$page = 'resources';
	$help = 'help-resources';
	$scripts = array('scriptresources');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$CI =& get_instance();
	// Load things with $CI->load here
	$CI->load->model('Resource');
	$CI->load->helper('form');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	// Set up the variables into array keys for the view to use
	$params = $this->uri->uri_to_assoc();
	
	$category_filter = (isset($params['category']) ? $params['category'] : NULL);
	$date_filter = (isset($params['date']) ? $params['date'] : NULL);

	if ( !isset($date_filter) )
		$_SESSION['admin_uri_resources_filter_date'] = '';
	if ( !isset($category_filter) )
		$_SESSION['admin_uri_resources_filter_category'] = '';

	$this->add_page_data(array(
		'categories' => $this->get_categories(),
		'category_filter' => $category_filter,
		'category_filter_name' => $this->get_category_name($category_filter),
		'date_filter' => $date_filter,
		'resources' => $this->get_resources($category_filter, $date_filter)
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

	if ( !$query->success )
		return NULL;

	return $query->data;
}
private function get_resources($category_filter, $date_filter) {

	$query = $this->Resource->get_resources_filtered($category_filter, $date_filter);

	if ( !$query->success ) {
		return NULL;
	}

	return $query->data;
}
private function get_category_name($id) {
	$query = $this->Resource->get_category_by_id($id);
	if( !$query->success) {
		return NULL;
	}

	return $query->data->category_name;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
