<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_Controller'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Contact extends EXT_Controller {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$this->my_content_keys = array(
		'hours_operation',
		'address_one', 'address_two', 'deliveries_one', 'deliveries_two',
		'phone', 'after_hours'
	);
	parent::__construct();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	$this->config->load('smmwc');

	$content = $this->get_content($this->my_content_keys);

	// Setup data
	$this->my_page_data = array_merge($this->my_page_data, $content->data);

	$this->render_subpage('pages/contact');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_resources_nav() {
	$this->load->model('Resource');
	$query = $this->Resource->get_categories();
	if ( $query->success )
		return $query->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
