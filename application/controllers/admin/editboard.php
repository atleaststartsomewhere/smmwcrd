	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editboard extends EXT_AdminController {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Board of Directors';
	$description = 'Add to and manage the list of the Board of Directors';
	$page = 'board';
	$help = 'help-board';
	$scripts = array('scriptboard');

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
	$this->my_page = 'board-member';
	$this->my_heading = 'Board of Directors: Add Member';
	$this->my_description = 'Add someone to the Board of Directors list.';
	$this->my_help = 'help-board-member';
	$member_num = $this->uri->segment(4,0);

	// Determine whether or not we're working on an entry or creating a new one
	$create = $member_num ? false : true;
	if ( !$create ) {
		$member = $this->get_member($member_num);

		if ( !$member )
			$create = true;
		else {
			$this->my_heading = 'Board of Directors: Edit Member';
			$this->my_description = 'Editing someone on the Board of Directors list.';
			$name = $member->name;
			$title = $member->title;
			$bio = $member->bio;
		}
	}

	// Set up the page data
	$this->add_page_data(array(
		'create' => $create,
		'name' => isset($name) ? $name : "",
		'title' => isset($title) ? $title : "",
		'bio' => isset($bio) ? $bio : "",
		'id' => isset($member_num) ? $member_num : "",
		'members' => $this->get_members()
	));

	// Render the page
	$this->render_page();
} // end entry()
public function all() {
	$this->my_page = 'board-all';
	$this->my_heading = 'Board of Directors: Manage';
	$this->my_description = 'Sort and manage the Board of Directors list.';
	$this->my_help = 'help-board-all';

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
	$query = $this->BoardStaff->get_board_member_by_id($id);

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_members() {
	$query = $this->BoardStaff->get_board();

	if ( $query->success )
		return $query->data;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
