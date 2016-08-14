<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Meetings extends EXT_Controller {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function Meetings( )
{
	$this->my_content_keys = array(
	);

	parent::__construct();
	$this->config->load('smmwc');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	$links = $this->get_page_links();
	if ( $this->uri->segment(2,0) < 1 )
		redirect($links['meetings'].'/1');

	$max_page = $this->get_meetings_page_count();
	if ( $this->uri->segment(2,0) > $max_page )
		redirect($links['meetings'].'/'.$max_page);

	// At this point, we know the page number is valid
	$page_num = $this->uri->segment(2);


	// Set up page data
	$page_data = array();
	$this->init_page_data();

	// Meeting Data
	$this->my_page_data['meetings'] = $this->get_meetings($page_num);

	// Pagination Data
	$keys = range(1,$max_page);
	$pagination = array_fill_keys($keys, '');
	$pagination[$page_num] = 'current';
	$this->my_page_data['pagination'] = $pagination;
	$this->my_page_data['url'] = $this->my_page_data['links']['meetings'];
	$this->my_page_data['current_page'] = $page_num;
	$this->my_page_data['max_page'] = $max_page;

	$page_data = array_merge($page_data, $this->my_page_data);
	$this->load->view('pages/meetings', $page_data);
}
public function boardmembers() {
	$links = $this->get_page_links();

	$page_data = array();
	$this->init_page_data();

	// Board Members Data
	$this->my_page_data['board'] = $this->get_board();

	$page_data = array_merge($page_data, $this->my_page_data);
	$this->load->view('pages/boardmembers', $page_data);
}
public function staff() {
	$links = $this->get_page_links();

	$page_data = array();
	$this->init_page_data();

	$this->my_page_data['staff'] = $this->get_staff();

	$page_data = array_merge($page_data, $this->my_page_data);
	$this->load->view('pages/staff', $page_data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
private function init_page_data() {
	$globalRes = $this->get_global_resources();

	$page_data = array();
	// Setup data
	$page_data['img_root'] = $this->config->item('image_path');
	$page_data['js_root'] = $this->config->item('js_path');
	$page_data['styles_root'] = $this->config->item('style_path');
	$page_data['user_res_root'] = $this->config->item('user_res_path');
	$page_data['user_img_root'] = $this->config->item('user_img_path');
	$page_data['globalRes'] = $this->get_global_resources();
	// Header
	$page_data['links'] = $this->get_page_links();

	$this->add_page_data($page_data);
}

private function get_meetings_page_count() {
	return (int)ceil($this->Calendar->count_meetings() / $this->config->item('meetings_items_per_page'));
}
private function get_meetings($page_num=1) {
	$query = $this->Calendar->get_meetings_page($page_num);

	return $query->data;
}
private function get_board() {
	$query = $this->Content->get_board();

	return $query->data;
}
private function get_staff() {
	$query = $this->Content->get_staff();

	return $query->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
