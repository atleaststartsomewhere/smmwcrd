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
	$requested_category = $this->uri->segment(2,'featured');

	$categories = array();
	// Add in 'fake' featured category
	$featured = new stdClass();
	$featured->url_friendly = 'featured';
	$featured->order = 0;
	$featured->category_name = 'Featured';
	$featured->id = 0;
	$featured->num_resources = count($this->get_featured_resources());
	$categories['featured'] =  $featured;
	// Append the custom categories
	$categories = array_merge($categories, $this->get_categories());

	// Redirect to base category if a bad category or no category is supplied
	if ( !isset($categories[$requested_category]) && $requested_category != 'featured' ) {
		redirect('resources/featured');
	}

	// Nav active setting
	$categories[$requested_category]->class = 'active';

	$this->add_page_data(array(
		'categories' => $categories,
		'resources' => $requested_category == 'featured' ? $this->get_featured_resources() : $this->get_category_resources($categories[$requested_category]->id)
	));

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
private function get_category_resources($categoryId) {
	$resources = $this->Resource->get_category_resources($categoryId);
	if ( !$resources->success )
		return array();

	return $resources->data;
}
private function get_featured_resources() {
	$resources = $this->Resource->get_featured_resources();
	if ( !$resources->success )
		return array();

	return $resources->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
