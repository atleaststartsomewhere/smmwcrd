<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Resources extends EXT_Controller {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function Resources( )
{
	parent::__construct();
	$this->config->load('smmwc');
	$this->load->model('Resource');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
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

	// Meeting Data
	$categories[$requested_category]->class = 'active';

	$this->add_page_data(array(
		'categories' => $categories,
		'resources' => $this->get_category_resources($categories[$requested_category]->id) // $page_num
	));

	// Subnav Data
	/*$keys = range(1,$max_page);
	$pagination = array_fill_keys($keys, '');
	$pagination[$page_num] = 'current';
	$this->my_page_data['pagination'] = $pagination;
	$this->my_page_data['url'] = $this->my_page_data['links']['meetings'];
	$this->my_page_data['current_page'] = $page_num;
	$this->my_page_data['max_page'] = $max_page;*/

	$this->render_subpage('pages/resources');
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
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
