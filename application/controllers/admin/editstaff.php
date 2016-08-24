	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editstaff extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Staff';
	$description = 'Add to and manage the Staff list';
	$page = 'staff';
	$help = 'help-staff';
	$scripts = array('scriptstaff');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$ci =& get_instance();
	// Load things with $ci->load here
	$ci->load->model('BoardStaff');
	$ci->load->helper('form');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	// Set up the variables into array keys for the view to use
	$this->add_page_data();
	$this->render_page();
}
public function member() {
	$this->my_page = 'staff-member';
	$this->my_heading = 'Staff: Add Member';
	$this->my_description = 'Add someone to the Staff list.';
	$member_num = $this->uri->segment(4,0);

	// Determine whether or not we're working on an entry or creating a new one
	$create = $member_num ? false : true;
	if ( !$create ) {
		$member = $this->get_member($member_num);

		if ( !$member )
			$create = true;
		else {
			$this->my_heading = 'Staff: Edit Member';
			$this->my_description = 'Editing someone on the Staff list.';
			$name = $member->name;
			$title = $member->title;
		}
	}

	// Set up the page data
	$this->add_page_data(array(
		'create' => $create,
		'name' => isset($name) ? $name : "",
		'title' => isset($title) ? $title : "",
		'id' => isset($member_num) ? $member_num : "",
		'members' => $this->get_members()
	));

	// Render the page
	$this->render_page();
} // end entry()
public function all() {
	$this->my_page = 'staff-all';
	$this->my_heading = 'Staff: Manage';
	$this->my_description = 'Sort and manage the Staff list.';

	$this->add_page_data(array(
		'members' => $this->get_members()
	));

	$this->render_page();	
} // end manage()
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_member($id) {
	$query = $this->BoardStaff->get_staff_member_by_id($id);

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_members() {
	$query = $this->BoardStaff->get_staff();

	if ( $query->success )
		return $query->data;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
