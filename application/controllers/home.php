<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Home extends EXT_Controller {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function Home( )
{
	$this->my_content_keys = array(
			'paybillcard_text', 'meetingcard_text', 'resourcecard_text', 'introductory_text', 
			'cusi_link',
			'hours_operation', 'address_one', 'address_two', 'deliveries_one', 'deliveries_two',
			'after_hours', 'phone', 'alert_notice',
			'main_image');

	parent::__construct();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	$this->config->load('smmwc');

	// Model Queries
	$content = $this->get_content($this->my_content_keys);
	$calendar = $this->get_calendar_today();
	
	$page_data = array();
	// Setup data
	$page_data['img_root'] = $this->config->item('image_path');
	$page_data['js_root'] = $this->config->item('js_path');
	$page_data['styles_root'] = $this->config->item('style_path');
	$page_data['user_res_root'] = $this->config->item('user_res_path');
	$page_data['user_img_root'] = $this->config->item('user_img_path');
	// Header
	$page_data['links'] = $this->get_page_links();
	// Page Content
	$page_data['calendar_events'] = $calendar;
	$page_data['calendar_year'] = date('Y');
	$page_data['calendar_month'] = date ('F');
	$page_data = array_merge($page_data, $content->data);

	$page_data['globalRes'] = $this->get_global_resources()->data;

	$this->load->view('pages/home', $page_data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calendar
private function get_calendar_today() {
	$query_content =  $this->Calendar->get_calendar_items_today();
	if ( !$query_content->success )
		return false;

	return $query_content;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
