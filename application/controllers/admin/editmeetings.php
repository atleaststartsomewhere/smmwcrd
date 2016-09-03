<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editmeetings extends EXT_AdminController {
//		Inherited Methods:
//			add_page_data($data=array(), $reset=false)
//			get_content($content_keys_array=array())
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CONSTRUCTOR
//			parent::__construct($title:string, $heading:string, $description:string, 
//				$viewFileName:string, $helpFileName:string, $scriptPaths:array())
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	// Set up parent construct and call
	$title = 'Edit Meetings Resources';
	$heading = 'Agendas &amp; Minutes';
	$description = 'Update the agendas and meeting minutes for board meetings and annual shareholder meetings';
	$page = 'meetings-resources';
	$help = 'help-meetings-resources';
	$scripts = array('scriptmeetings');
	parent::__construct($title, $heading, $description, $page, $help, $scripts);

	// Loader Calls
	$ci =& get_instance(); // Get the CI instance to load resources
	$ci->load->model('Calendar');
	$ci->load->model('Resource');
	$ci->load->helper('form');
} // END __construct()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		SUB-ROUTES
//			index
//			view
//
//======================================================================================================
/*
** 	index()
**
*/
//------------------------------------------------------------------------------------------------------
public function index() {
	// Get the page number from the URI
	// Set page to 1 if the page is 1 or 0 (0 is no page supplied in URI)	
	// Also catches the bad numbers less than 0
	$page = (int)$this->uri->segment(3, 0) < 2 ? 1 : (int)$this->uri->segment(3, 0);
	$_SESSION['last_resource_page'] = $page;

	if ( $page > $this->get_page_count() )
		redirect('admin/meetings-resources/'.$this->get_page_count());

	$this->add_page_data(array(
		'widget_items_list' => $this->make_resource_list_widget($page),
		'widget_items_pagination' => $this->make_resource_list_pagination_widget($page)
	));

	$this->render_page();
} // END index()

////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		WIDGET RENDERING
//			
//
//======================================================================================================
private function make_resource_list_widget($page_num) {
	$view_data = array();
	$view_path = $this->widget_root . 'meetings-resources-items-list';

	$view_data['meetings'] = $this->get_meetings($page_num);
	$view_data['resource_root'] = $this->config->item('user_res_path');

	return $this->load->view($view_path, $view_data, TRUE);
}
private function make_resource_list_pagination_widget($page_num) {
	$view_data = array();
	$view_path = $this->widget_root . 'meetings-resources-pagination';

	$view_data['pages'] = $this->get_pagination($page_num);

	return $this->load->view($view_path, $view_data, TRUE);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPERS
//			
//
//======================================================================================================
private function get_meetings($page_num) {
	$query = $this->Calendar->get_meetings_page($page_num);
	$page_length = $this->config->item('admin_rows_per_page');

	if ( $query->success ) {
		foreach ( $query->data as $i => $datum ) {
			$datum->index = (($page_num * $page_length) - $page_length) + $i+1;
		}

		return $query->data;
	}

	return $query;
}
private function get_pagination($page_num) {
	$count = $this->get_page_count();
	// Now build page objects with a URL and markup data
	$pages = array();
	// PREVIOUS
	$pages[0] = array(
		'url' => $this->my_url . '/' . ($page_num==1?1:$page_num-1),
		'number' => 'Prev',
		'class' => 'uk-button-link'.($page_num==1?' uk-disabled':''),
		'is_active' => false
	);
	// IN BETWEEN PAGES
	for ( $i = 1; $i <= $count; $i++ ) {
		$newPage = array();
		$newPage['url'] = $this->my_url . '/' . $i;
		$newPage['number'] = $i;
		$newPage['class'] = ($i == $page_num) ? "uk-active" : "";
		$newPage['is_active'] = ($i == $page_num);

		array_push($pages, $newPage);
	}
	// NEXT
	array_push($pages, array(
		'url' => $this->my_url . '/' . ($page_num==$count?$page_num:$page_num+1),
		'number' => 'Next',
		'class' => 'uk-button-link'.($page_num==$count?' uk-disabled':''),
		'is_active' => false
	));

	return $pages;	
}
private function get_page_count() {
	// Get the number of pages
	$query = $this->Calendar->count_meetings();
	$page_length = $this->config->item('admin_rows_per_page');
	
	return (int)ceil($query/$page_length);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
