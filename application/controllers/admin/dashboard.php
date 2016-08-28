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

	$attention_widgets = array();
	$widgets = array();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Order of these function calls winds up being a display prioritization on the render side
	// Each of these functions add themselves to the class object's $attention_widgets or $widgets array
	//  so there's no need to do any further assignment
	$this->make_widget_calendar();
	$this->make_widget_notices();
	$this->make_widget_meetings();
	$this->make_widget_categories();
	$this->make_widget_resources();
	$this->make_widget_faq();
	$this->make_widget_board();
	$this->make_widget_staff();

	$this->add_page_data(array(
		'user_widget' => $this->make_widget_user(),
		'attention_widgets' => $attention_widgets,
		'widgets' => $widgets
	));
	$this->render_page();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function make_widget_user() {
	$widget_path = 'admin/widgets/dashboard-user';

	$last_login = // function call - either to auth model or user object or helper function
	$pwd_age = // function call - either to auth model or user object or helper function

	$widget_data = array(
		'billpay' => $this->billpay_available,
		'last_login' => $last_login,
		'pwd_age' => $pwd_age
	);

	return $this->load->view($widget_path, $widget_data, TRUE);
}
private function make_widget_calendar() {
	$widget_path = 'admin/widgets/dashboard-calendar';
	$attention = FALSE;
	$attention_messages = array();

	// Widget Data Setup
	$current_month = $this->Calendar->get_current_month_items();
	if ( !$current_month->success ) {
		array_push($attention_messages, 'There are no calendar events for the current month!');
	}
	$next_month = $this->Calendar->get_month_items(date('Y'), date('m', strtotime('+1 month')));
	if ( !$next_month->success ) {
		if ( date('d') >= //last day of month - 14 ) {
			array_push($attention_messages, 'There are no calendar events for next month and you are less than two weeks from '.date('F', strtotime('+1 month')));
		}
	}

	$attention = (count($attention_messages) > 0) ? TRUE : FALSE;
	$widget_data = array(
		'current' => $current_month,
		'next' => $next_month,
		'attention' => $attention,
		'attention_messages' => $attention_messages
	);

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
private function make_widget_notices() {
	$widget_path = 'admin/widgets/dashboard-notices';
	$attention = FALSE;
	$attention_messages = array();

	// Widget Data Setup
	$notices = $this->Notices->get_notices();
	$oldest = $this->Notices->get_oldest_date();
	if ( $oldest < date('Y-m-d', strtotime('-1 month')) ) {
		array_push($attention_messages, 'One or more notices are more than one month old.');
	}

	$attention = (count($attention_messages) > 0) ? TRUE : FALSE;
	$widget_data = array(
		'notices' => $notices,
		'attention' => $attention,
		'attention_messages' => $attention_messages
	);

	$widget = $this->load->view($widget_path, $widget_data, TRUE);

	// Test if the widget is grouped with the attention widgets or if it will go in as normal
	if ( $attention )
		array_push($this->attention_widgets, $widget);
	else
		array_push($this->widgets, $widget);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function billpay_available() {
	$host = $this->Content->get_content_by_key('billpay_link');

	try {
		if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
			fclose($socket);
			return $SITE_TEST_ON;		
		} 
		else {
			return $SITE_TEST_OFF;
		}
	} Exception($e) {
		return $SITE_TEST_UNREACHABLE;
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS