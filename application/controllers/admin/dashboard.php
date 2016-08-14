	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stored Content:
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Dashboard extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	$title = "Admin: San Miguelito Mutual Water Company";
	$heading = 'Dashboard';
	$description = 'Information on SMMWC.com';
	$page = 'dashboard';
	$help = 'dashboard';
	$scripts = array();

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$ci =& get_instance();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	// Set up the variables into array keys for the view to use
	//$this->add_page_data(array());
	$this->render_page();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function get_data() {
	return 'someData';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
