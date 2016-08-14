	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editnotices extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Notices';
	$description = 'Add special alerts or general notifications on the notices page';
	$page = 'notices';
	$help = 'help-notices';
	$scripts = array('scriptnotices');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$ci =& get_instance();
	// Load things with $ci->load here
	$ci->load->model('Notice');
	$ci->load->model('Resource');
	$ci->load->helper('form');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	// Set up the variables into array keys for the view to use
	$this->add_page_data();
	$this->render_page();
}
public function entry() {
	$this->my_page = 'notices-entry';
	$this->my_help = 'help-notices-entry';
	$entry_num = $this->uri->segment(4,0);

	// Determine whether or not we're working on an entry or creating a new one
	$create = $entry_num ? false : true;
	if ( !$create ) {
		$notice = $this->get_notice($entry_num);

		if ( !$notice )
			$create = true;
		else {
			$heading = $notice->heading_text;
			$message = $notice->body_text;
			$selected_resource = $notice->resource_id; //change
			$selected_type = $notice->type_id;
			$id = $notice->id;
			$add_date =date('m/d/Y', strtotime($notice->add_date));
			$notice_date = date('m/d/Y', strtotime($notice->notice_date));
		}
	}

	// Set up the page data
	$this->add_page_data(array(
		'create' => $create,
		'resources' => $this->get_resources(),
		'types' => $this->get_types(), // change
		// Notice-Row Specific Items - set to empty if we have no data
		'heading' => isset($heading) ? $heading : "",
		'message' => isset($message) ? $message : "",
		'selected_resource' => isset($selected_resource) ? $selected_resource : "",
		'selected_type' => isset($selected_type) ? $selected_type : 2, // type 2 is general; general is default value
		'id' => isset($id) ? $id : "",
		'add_date' => isset($add_date) ? $add_date : "",
		'notice_date' => isset($notice_date) ? $notice_date : "",
		'notices' => $this->get_notices() // using this for the nav
	));

	// Render the page
	$this->render_page();
} // end entry()
public function all() {
	$this->my_page = 'notices-all';
	$this->my_help = 'help-notices-all';
	$this->my_heading = 'Notices: All Notices';
	$this->my_description = 'Sort and manage your notices.';

	$this->add_page_data(array(
		'notices' => $this->get_notices()
	));

	$this->render_page();	
} // end manage()
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_notice($id) {
	$query = $this->Notice->get_by_id($id);

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_notices() {
	$query = $this->Notice->get_all();

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_types() {
	$query = $this->Notice->get_types();

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_resources() {
	$query = $this->Resource->get_all_resources();

	if ( $query->success )
		return $query->data;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
