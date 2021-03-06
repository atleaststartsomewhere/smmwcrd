<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_Controller'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Notices extends EXT_Controller {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	parent::__construct();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {

	$this->add_page_data(array(
		'notices' => $this->get_notices()
	));
	
	$this->render_subpage('pages/notices');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_notices() {
	$this->load->model('Notice');
	$query = $this->Notice->get_all();
	if ( $query->success )
		return $query->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
