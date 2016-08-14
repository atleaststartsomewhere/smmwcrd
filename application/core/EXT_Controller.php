<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
//	
////////////////////////////////////////////////////////////////////////////////////////////////////////
class EXT_Controller extends CI_Controller {
	protected $env_production = false;
	protected $site_config = 'smmwc';

	protected $my_page_data = array();

	protected $my_content_keys = array();
	protected $page_links = array();
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct();

	$this->config->load($this->site_config);
	$this->env_production = ((ENVIRONMENT === 'production') || (ENVIRONMENT === 'staging'))?true:false;

	//= Loaded Resources
	$this->load->model('Calendar');
	$this->load->model('Content');
	$this->load->model('Resource');

	//= Routes
	$this->page_links['home'] = site_url();
	$this->page_links['meetings'] = site_url() . "meetings";
	$this->page_links['resources'] = site_url() . "resources";
	$this->page_links['paybill'] = $this->get_paybill_link();
		// Sub Pages
		$this->page_links['boardmembers'] = site_url() . "board-members";
		$this->page_links['staff'] = site_url() . "staff";
		$this->page_links['faq'] = site_url() . "faq";


}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	show_404();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// View Rendering
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function anchor_start() {
	$view_path = $this->config->item('anchor_path').'start';
	$view_data = array('title' => $this->my_title, 'js' => $this->js_includes, 'css' => $this->css_includes);
	$this->load->view($view_path, $view_data);
}
protected function anchor_end() {
	$view_path = $this->config->item('anchor_path').'end';
	$this->load->view($view_path);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Content Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dynamic Content
protected function get_content($keys) {
	$query_content =  $this->Content->get_items_by_keys($keys);
	if ( !$query_content->success )
		return false;

	return $query_content;
}
// Documents & Resources
protected function get_global_resources() {
	$query_globalRes = $this->Resource->get_global_resources();
	if ( !$query_globalRes->success )
		return $this->no_data("No resources to display.");

	return $query_globalRes;
}
protected function get_all_resources() {
	$query_allRes = $this->Resource->get_all_resources();
	if ( !$query_allRes->success )
		return false;

	return $query_allRes;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// View Data Helpers
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function add_page_data($data=array(), $reset=false) {
	if ( $reset )
		$this->my_page_data = array();

	if ( empty($this->my_page_data) )
		$this->my_page_data = $data;
	else
		$this->my_page_data = array_merge($this->my_page_data,$data);
}
protected function get_page_links() {
	return $this->page_links;
}
protected function get_paybill_link() {
	$query_paybill = $this->Content->get_item_by_key($this->config->item('paybill_link_key'));
	if ( !$query_paybill->success )
		return "#";
	else
		return $query_paybill->data[$this->config->item('paybill_link_key')];
}
protected function no_data($placeholder) {
	$result = new stdClass();
	$result->success = false;
	$result->placeholder = $placeholder;

	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS

require_once(APPPATH.'core/EXT_AdminController'.EXT);
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
require_once(APPPATH.'core/EXT_AJAXController'.EXT);