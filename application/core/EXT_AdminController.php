<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
//	
////////////////////////////////////////////////////////////////////////////////////////////////////////
class EXT_AdminController extends CI_Controller {
	protected $env_production = false;
	protected $site_config = 'smmwc';
	protected $super_group = '';

	protected $is_admin = false;
	protected $is_super = false;
	protected $user = null;

	protected $my_title = '';
	protected $my_heading = '';
	protected $my_description = '';
	protected $template = 'template-cma';
	protected $help_template = 'template-help';
	protected $my_url = '';

	protected $my_page = null;
	protected $my_page_data = array();
	protected $my_scripts = array();
	protected $my_help = null;

	protected $css_includes = array();
	protected $js_includes = array();

	protected $page_links = array();
	protected $script_links = '';

	protected $template_root = '';
	protected $page_root = '';
	protected $widget_root = '';
	protected $help_root = '';
	protected $script_root = '';

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct($title='', $heading='', $description='', $page=null, $help=null, $scripts=array())
{
	parent::__construct();

	$this->my_title = empty($title) ? $this->config->item('default_page_title') : $title;
	$this->my_heading = $heading;
	$this->my_description = $description;
	$this->my_page = $page;
	$this->my_help = $help;
	$this->my_scripts = $scripts;


	$this->config->load($this->site_config);
	$this->env_production = ((ENVIRONMENT === 'production') || (ENVIRONMENT === 'staging'))?true:false;
	$this->super_group = $this->config->item('supergroup_name');
	$this->template_root = $this->config->item('admin_template_path');
	$this->page_root = $this->config->item('admin_page_path');
	$this->widget_root = $this->config->item('admin_widget_path');
	$this->help_root = $this->config->item('admin_help_path');
	$this->script_root = $this->config->item('admin_script_path');

	//= Auth Checker
	//Check if user is in admin group
	if ( !$this->ion_auth->is_admin() ) {
		if ( $this->env_production ) {
			$this->session->set_flashdata('redirectURL',uri_string());
			redirect('auth');
		} else { // We're in DEV
			$this->set_as_dev_user();
		}
	}
	else {
		// Don't think we need any of this block - RYAN KOON //
		//Put User in Class-wide variable
		/* $this->the_user = $this->ion_auth->get_user();

		//Store user in $data
		$data->the_user = $this->the_user;

		//Load $the_user in all views
		$this->load->vars($data);*/
		// End of what I don't think we need  - RYAN KOON //
		$this->user = $this->ion_auth->user()->row();
		$this->is_admin(true);
		$this->is_super($this->ion_auth->in_group($this->super_group));
	}


	//= Routes
	$this->page_links['dashboard'] = site_url() . "admin";
	$this->page_links['sitehome'] = site_url();
	$this->page_links['logout'] = site_url() . "auth/logout";
		// CMA - Settings
		$this->page_links['account'] = site_url() . "admin/account";
		$this->page_links['billpay'] = site_url() . "admin/billpay";
		// CMA - Calendar and Notices
		$this->page_links['notices'] = site_url() . "admin/notices";
		$this->page_links['notices-entry'] = site_url() . "admin/notices/entry";
		$this->page_links['notices-all'] = site_url() . "admin/notices/all";
		$this->page_links['calendar'] = site_url() . "admin/calendar";
		// CMA - Meetings
		$this->page_links['meetings-resources'] = site_url() . "admin/meetings-resources";
		$this->page_links['board'] = site_url() . "admin/board";
		$this->page_links['board-member'] = site_url() . "admin/board/member";
		$this->page_links['board-all'] = site_url() . "admin/board/all";
		$this->page_links['staff'] = site_url() . "admin/staff";
		$this->page_links['staff-member'] = site_url() . "admin/staff/member";
		$this->page_links['staff-all'] = site_url() . "admin/staff/all";
		// CMA - Resources
		$this->page_links['resources-categories'] = site_url() . "admin/resources-categories";
		$this->page_links['resources'] = site_url() . "admin/resources";
		// CMA - Frequently Asked Questions
		$this->page_links['faq'] = site_url() . "admin/faq";
		$this->page_links['faq-entry'] = site_url() . "admin/faq/entry";
		$this->page_links['faq-all'] = site_url() . "admin/faq/all";

	$this->my_url = $this->page_links[$this->my_page];

	//= Script References
		// Settings
		$this->script_links['scriptbillpay'] = $this->script_root.'scriptbillpay';
		$this->script_links['scriptaccount'] = $this->script_root.'scriptaccount';
		// Calendar and Notices
		$this->script_links['scriptcalendar'] = $this->script_root.'scriptcalendar';
		$this->script_links['scriptnotices'] = $this->script_root.'scriptnotices';
		// Meetings
		$this->script_links['scriptmeetings'] = $this->script_root.'scriptmeetings';
		$this->script_links['scriptboard'] = $this->script_root.'scriptboard';
		$this->script_links['scriptstaff'] = $this->script_root.'scriptstaff';
		// Resources
		$this->script_links['scriptrescategories'] = $this->script_root.'scriptrescategories';
		$this->script_links['scriptresources'] = $this->script_root.'scriptresources';
		// FAQ
		$this->script_links['scriptfaq'] = $this->script_root.'scriptfaq';

	//= Admin ANCHOR CSS Includes
	$asset_style_path = $this->config->item('admin_style_path');
	$asset_js_path = $this->config->item('admin_js_path');
	array_push($this->css_includes, $asset_style_path.'normalize.css');
    array_push($this->css_includes, $asset_style_path.'uikit.min.css');
	array_push($this->css_includes, $asset_style_path.'uikit.gradient.min.css');
	array_push($this->css_includes, $asset_style_path.'components/sticky.min.css');
	array_push($this->css_includes, $asset_style_path.'components/datepicker.min.css');
	array_push($this->css_includes, $asset_style_path.'components/accordion.min.css');
		// Custom CSS Files or Page-Specific CSS Styles
		array_push($this->css_includes, $asset_style_path.'style.admin.css');
	//= Admin ANCHOR JS Includes
	array_push($this->js_includes, $asset_js_path.'jquery-3.0.0.min.js');
	array_push($this->js_includes, $asset_js_path.'uikit.js');
	array_push($this->js_includes, $asset_js_path.'components/sticky.min.js');
	array_push($this->js_includes, $asset_js_path.'components/datepicker.min.js');
	array_push($this->js_includes, $asset_js_path.'components/accordion.min.js');
	array_push($this->js_includes, $asset_js_path.'components/form-password.min.js');
	array_push($this->js_includes, $asset_js_path.'components/notify.min.js');
	array_push($this->js_includes, $asset_js_path.'components/sortable.min.js');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	show_404();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// View Rendering
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function render_page( ) {

	$page_path = $this->page_root.$this->my_page;
	$template_path = $this->template_root.$this->template;

	$this->anchor_start();
	// Template w/ $header, $sidebar, $messages, $page, $help views
	// Assemble Header
	$header = $this->make_header();
	// Assemble Sidebar
	// + active link; + all link urls + superadmin
	$sidebar = $this->make_sidebar();
	// Assemble Messages
	$messages = $this->make_messages();
	// Assemble Page
	$page = $this->make_page();
	// Assemble Help
	$help = $this->make_help();
	// Render Page
	$view_data = array('header' => $header, 'sidebar' => $sidebar, 'messages' => $messages, 
		'page' => $page, 'help' => $help,
		'heading' => $this->my_heading, 'description' => $this->my_description);

	$this->load->view($template_path, $view_data);

	$this->anchor_end();
}
private function anchor_start() {
	$view_path = $this->config->item('admin_anchor_path').'start';
	$view_data = array('title' => $this->my_title, 'css' => $this->css_includes);
	$this->load->view($view_path, $view_data);
}
private function anchor_end() {
	$view_path = $this->config->item('admin_anchor_path').'end';
	$view_data = array('js' => $this->js_includes);
	$this->load->view($view_path, $view_data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Admin Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function is_admin($bool=null) {
	if ( !isset($bool) )
		return $this->is_admin;

	$this->is_admin = $bool;
	return $this->is_admin;
}
protected function is_super($bool=null) {
	if ( !isset($bool) )
		return $this->is_super;

	$this->is_super = $bool;
	return $this->is_super;
}
protected function set_as_dev_user() {
	$this->user = new stdClass();
	$this->user->username = $this->config->item('dev_placeholder_name');
	$this->is_admin(true);
	$this->is_super(true);
}
protected function get_admin_contact() {
	$admin = array();
	$admin['email'] = $this->config->item('admin_contact_email');
	$admin['name'] = $this->config->item('admin_contact_name');
	$admin['phone'] = $this->config->item('admin_contact_phone');

	return $admin;
}
protected function get_superadmin_name() {
	return $this->config->item('superadmin');
}
protected function get_dev_placeholder_name() {
	return $this->config->item('dev_placeholder_name');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global View Assembly
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function make_header() {
	$header_data = array();

	$header_data['links'] = $this->get_page_links();
	$header_data['username'] = $this->user->username;

	return $this->load->view($this->widget_root.'global-header', $header_data, true);
}
private function make_sidebar() {
	$sidebar_data = array();

	$sidebar_data['is_super'] = $this->is_super();
	$sidebar_data['links'] = $this->get_page_links();

	// Set up active nav class link
	$sidebar_data['active'] = array($this->my_page => $this->my_page);

	return $this->load->view($this->widget_root.'global-sidebar', $sidebar_data, true);
}
private function make_messages() {
	$this->load->library('session');
	$success_key = $this->config->item('session_messages_success');
	$error_key = $this->config->item('session_messages_error');

	$message_data = array();
	$message_data['successes'] = array();
	$message_data['errors'] = array();

	if ( isset($_SESSION[$success_key]) ) {
		$message_data['successes'] = $_SESSION[$success_key];
		unset($_SESSION['successes']);
	}
	if ( isset($_SESSION[$error_key]) ) {
		$message_data['errors'] = $_SESSION[$error_key];
		unset($_SESSION['errors']);
	}

	return $this->load->view($this->widget_root.'global-messages', $message_data, true);
}
private function make_page( ) {
	$view_exists = file_exists( APPPATH.'views/'.$this->page_root.$this->my_page.EXT );

	if ( !isset($this->my_page) )
		return null;

	if ( !empty($this->my_scripts) )
		$this->my_page_data['scripts'] = $this->get_scripts();

	if ( !$view_exists )
		return '';

	$this->add_page_data(array('links' => $this->get_page_links()));

	return $this->load->view($this->page_root.$this->my_page, $this->my_page_data, true);

}
private function make_help() {
	$view_exists = file_exists( APPPATH.'views/'.$this->help_root.$this->my_help.EXT );

	if ( !isset($this->my_help) || !$view_exists )
		return '';

	$view_data = array();
	$view_data['help_content'] = $this->load->view($this->help_root.$this->my_help, null, true);

	return $this->load->view($this->template_root.$this->help_template, $view_data, true);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// View Data Helpers
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function get_page_links() {
	return $this->page_links;
}
protected function get_scripts( ) {
	if ( empty($this->my_scripts) )
		return null;
	foreach ( $this->my_scripts as $name ) {
		if ( !file_exists( APPPATH.'controllers/'.$this->script_root.$name.EXT ) )
			return null;
	}
	return array_intersect_key($this->script_links, array_flip($this->my_scripts));
}
protected function add_page_data($data=array(), $reset=false) {
	if ( $reset )
		$this->my_page_data = array();

	if ( empty($this->my_page_data) )
		$this->my_page_data = $data;
	else
		$this->my_page_data = array_merge($this->my_page_data,$data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
