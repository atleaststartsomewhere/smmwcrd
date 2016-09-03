<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_Controller'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Meetings extends EXT_Controller {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
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

	// Pagination Data
	$keys = range(1,$max_page);
	$pagination = array_fill_keys($keys, '');
	$pagination[$page_num] = 'current';

	$this->add_page_data(array(
		'meetings' => $this->get_meetings($page_num),
		'pagination' => $pagination,
		'current_page' => $page_num,
		'max_page' => $max_page,
		'next' => ($page_num + 1) > $max_page ? $page_num : $page_num+1,
		'prev' => ($page_num - 1) < 1 ? $page_num : $page_num-1
	));

	$this->render_subpage('pages/meetings');
}
public function boardmembers() {
	// Board Members Data
	$this->add_page_data(array(
		'board' => $this->get_board()
	));
	$this->render_subpage('pages/boardmembers');
}
public function staff() {
	// Staff Members Data
	$this->add_page_data(array(
		'staff' => $this->get_staff()
	));
	$this->render_subpage('pages/staff');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
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
