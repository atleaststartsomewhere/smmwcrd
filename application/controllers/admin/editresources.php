<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editresources extends EXT_AdminController {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Resources: Manage All';
	$description = 'Change, upload and delete resources';
	$page = 'resources';
	$help = 'help-resources';
	$scripts = array('scriptresources');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$CI =& get_instance();
	// Load things with $CI->load here
	$CI->load->model('Resource');
	$CI->load->helper('form');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	$this->add_page_data(array(
		'recent' => $this->make_recent_widget(),
		'featured' => $this->make_featured_widget(),
		'custom_categories' => $this->make_custom_category_widgets()
	));

	$this->render_page();
}

public function add_file() {
	$this->my_page = 'resources-add';
	$this->my_help = 'help-resources-add';
	$this->my_heading = 'Resources: Add File';

	$this->add_page_data(array(
		'categories' => $this->get_categories()
	));

	$this->render_page();
}

public function add_link() {
	$this->my_page = 'resources-add-link';
	$this->my_help = 'help-resources-add-link';
	$this->my_heading = 'Resources: Add Link';

	$this->add_page_data(array(
		'categories' => $this->get_categories()
	));

	$this->render_page();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function make_recent_widget() {
	$widget_path = 'admin/widgets/resources-category-list';
	$widget_data = array(
		'sort' => FALSE,
		'resources' => $this->get_recent(),
		'categories' => $this->get_categories(),
		'category_name' => 'Recent'
	);

	return $this->load->view($widget_path, $widget_data, TRUE);
}
private function make_featured_widget() {
	$widget_path = 'admin/widgets/resources-category-list';
	$widget_data = array(
		'sort' => FALSE,
		'resources' => $this->get_featured(),
		'categories' => $this->get_categories(),
		'category_name' => 'Featured'
	);

	return $this->load->view($widget_path, $widget_data, TRUE);
}
private function make_custom_category_widgets() {
	$widget_path = 'admin/widgets/resources-category-list';
	
	$categories = $this->get_categories();
	$category_widgets = array();


	foreach ( $categories as $category ) {
		$widget_data = array(
			'sort' => TRUE,
			'resources' => $this->get_category_resources($category->id),
			'categories' => $categories,
			'category_name' => $category->category_name
		);

		$widget = $this->load->view($widget_path, $widget_data, TRUE);
		$category_widgets[$category->category_name] = $widget;
	}

	return $category_widgets;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_categories() {
	$query = $this->Resource->get_categories();

	if ( !$query->success )
		return NULL;

	return $query->data;
}
private function get_recent() {
	$query = $this->Resource->get_recent_resources();
	if ( !$query->success )
		return NULL;

	return $query->data;
}
private function get_featured() {
	$query = $this->Resource->get_featured_resources();
	if ( !$query->success )
		return NULL;

	return $query->data;
}
private function get_category_resources($cat_id) {
	$query = $this->Resource->get_category_resources($cat_id);
	if ( !$query->success )
		return NULL;

	return $query->data;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
