<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Resources extends EXT_Controller {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function Resources( )
{
	$this->my_content_keys = array(
	);

	parent::__construct();
	$this->config->load('smmwc');
	$this->load->model('Resource');
	$this->load->model('Faq');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	$links = $this->get_page_links();
	// segment 2 = category
	// segment 3 = category page
	// Check for valid category
	$requested_category = $this->uri->segment(2,0);
	$categories = $this->get_categories();

	// Redirect to base category if a bad category or no category is supplied
	if ( !isset($categories[$requested_category]) ) {
		redirect('resources'.'/'.array_keys($categories)[0]);//.'/1');
	}

	/*$page_num = $this->uri->segment(3,0);
	// Check under min page number
	if ( $page_num < 1 ) {
		redirect('resources'.'/'.$categories[$requested_category]->url_friendly.'/1');
	}

	// Check over max page number
	$max_page = $this->get_resources_page_count($categories[$requested_category]->id);
	if ( $page_num > $max_page ) {
		redirect('resources'.'/'.$categories[$requested_category]->url_friendly.'/'.$max_page);
	}*/

	// Set up page data
	$page_data = array();
	$this->init_page_data();

	// Meeting Data
	$categories[$requested_category]->class = 'active';
	$this->my_page_data['categories'] = $categories;
	$this->my_page_data['resources'] = $this->get_category_resources($categories[$requested_category]->id);//, $page_num);
	$this->my_page_data['url'] = $links['resources'];

	// Subnav Data
	/*$keys = range(1,$max_page);
	$pagination = array_fill_keys($keys, '');
	$pagination[$page_num] = 'current';
	$this->my_page_data['pagination'] = $pagination;
	$this->my_page_data['url'] = $this->my_page_data['links']['meetings'];
	$this->my_page_data['current_page'] = $page_num;
	$this->my_page_data['max_page'] = $max_page;*/

	$page_data = array_merge($page_data, $this->my_page_data);
	$this->load->view('pages/resources', $page_data);
}
public function faq() {
	$this->init_page_data();

	$this->add_page_data(array(
		'faqs' => $this->get_faq()
	));

	$this->load->view('pages/faq', $this->my_page_data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_categories() {
	$categories = $this->Resource->get_categories()->data;

	foreach ( $categories as $key => $category ) {
		$categories[$category->url_friendly] = $category;
		unset($categories[$key]);
	}

	return $categories;
}
private function get_resources_page_count($categoryId) {
	return $this->Resource->count_resource_pages($categoryId);
}
private function get_category_resources($categoryId) {
	$resources = $this->Resource->get_category_resources($categoryId);

	return $resources->data;
}
private function get_faq() {
	$faq = $this->Faq->get_faq();

	return $faq->data;
}
private function init_page_data() { // TO DO: Move to parent controller
	$globalRes = $this->get_global_resources();

	$page_data = array();
	// Setup data
	$page_data['img_root'] = $this->config->item('image_path');
	$page_data['js_root'] = $this->config->item('js_path');
	$page_data['styles_root'] = $this->config->item('style_path');
	$page_data['user_res_root'] = $this->config->item('user_res_path');
	$page_data['user_img_root'] = $this->config->item('user_img_path');
	$page_data['globalRes'] = $this->get_global_resources()->data;
	// Header
	$page_data['links'] = $this->get_page_links();

	$this->add_page_data($page_data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
