<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Dashboard extends EXT_AdminController {
protected $attention_widgets;
protected $widgets;
protected $SITE_TEST_ON = 1;
protected $SITE_TEST_OFF = 0;
protected $SITE_TEST_UNREACHABLE = 2;
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$title = "Admin: San Miguelito Mutual Water Company";
	$heading = 'Dashboard';
	$description = 'SMMWC.com Health Check and Admin Notices';
	$page = 'dashboard';
	$help = 'help-dashboard';
	$scripts = array();

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$CI =& get_instance();
	$CI->load->model('Health');
	$CI->load->model('Content');

	$this->attention_widgets = array();
	$this->widgets = array();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Order of these function calls winds up being a display prioritization on the render side
	// Each of these functions add themselves to the class object's $attention_widgets or $widgets array
	//  so there's no need to do any further assignment
	$this->make_widget_user();
	$this->make_widget_calendar();
	$this->make_widget_notices();
	$this->make_widget_meetings();
	$this->make_widget_faq();
	/*
	$this->make_widget_categories();
	$this->make_widget_resources();
	$this->make_widget_board();
	$this->make_widget_staff();
*/
	$this->add_page_data(array(
		'attention_widgets' => $this->attention_widgets,
		'widgets' => $this->widgets
	));
	$this->render_page();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function make_widget_user() {
	$widget_path = 'admin/widgets/dashboard-user';

	$widget_data = array(
		'billpay' => $this->billpay_available(),
		'links' => $this->get_page_links(),
		'billpay_link' => $this->Content->get_item_by_key('paybill_link')->data['paybill_link']
	);

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	if ( $this->billpay_available() != 1 )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
private function make_widget_calendar() {
	$widget_path = 'admin/widgets/dashboard-calendar';

	// Widget Data Setup
	$calendar_health = $this->Health->calendar_health();

	$widget_data = $calendar_health->data;
	$widget_data['links'] = $this->get_page_links();

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $calendar_health->attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
private function make_widget_notices() {
	$widget_path = 'admin/widgets/dashboard-notices';
	$attention = FALSE;
	$attention_messages = array();

	// Widget Data Setup
	$notices_health = $this->Health->notices_health();

	$widget_data = $notices_health->data;
	$widget_data['links'] = $this->get_page_links();

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $notices_health->attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
private function make_widget_meetings() {
	$widget_path = 'admin/widgets/dashboard-meetings';
	$attention = FALSE;
	$attention_messages = array();

	// Widget Data Setup
	$meetings_health = $this->Health->meetings_health();

	$widget_data = $meetings_health->data;
	$widget_data['links'] = $this->get_page_links();

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $meetings_health->attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
private function make_widget_faq() {
	$widget_path = 'admin/widgets/dashboard-faq';
	$attention = FALSE;
	$attention_messages = array();

	// Widget Data Setup
	$faq_health = $this->Health->faq_health();

	$widget_data = $faq_health->data;
	$widget_data['links'] = $this->get_page_links();

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $faq_health->attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function billpay_available() {
	$host = $this->Content->get_item_by_key('paybill_link');
	if ( !$host->success || !isset($host->data['paybill_link']) )
		return $SITE_TEST_UNREACHABLE;

	$host = preg_replace('/.*\/\//', '', $host->data['paybill_link']);

	try {
		if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
			fclose($socket);
			return $this->SITE_TEST_ON;		
		} 
		else {
			return $this->SITE_TEST_OFF;
		}
	} catch (Exception $e) {
		return $this->SITE_TEST_UNREACHABLE;
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS