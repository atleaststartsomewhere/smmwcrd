<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Home extends EXT_Controller {
///////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	parent::__construct();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	$this->config->load('smmwc');
	
	$page_data = array();
	// Setup data
	$page_data['img_root'] = $this->config->item('image_path');
	$page_data['js_root'] = $this->config->item('js_path');
	$page_data['styles_root'] = $this->config->item('style_path');
	$page_data['user_res_root'] = $this->config->item('user_res_path');
	$page_data['user_img_root'] = $this->config->item('user_img_path');
	// Page Nav
	$page_data['links'] = $this->get_page_links();
	$page_data['resource_categories'] = $this->get_resources_nav();

	$this->load->view('pages/home', $page_data);
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
