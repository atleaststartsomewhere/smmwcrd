<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_AdminController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editcalendar extends EXT_AdminController {
//		Inherited Methods:
//			add_page_data($data=array():array(), $reset=false:boolean)
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CONSTRUCTOR
//			parent::__construct($title:string, $heading:string, $description:string, 
//				$viewFileName:string, $helpFileName:string, $scriptPaths:array())
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	$title = 'Edit Calendar: San Miguelito Mutual Water Company';
	$heading = 'Calendar';
	$description = 'You are now editing the Calendar on your Home Page';
	$page = 'calendar';
	$help = 'help-calendar';
	$scripts = array('scriptcalendar');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);

	// Loader Calls
	$ci =& get_instance(); // Get the CI instance to load resources
	$ci->load->model('Calendar');
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
** 	Re-routes to view
*/
//------------------------------------------------------------------------------------------------------
public function index() {
	redirect('admin/calendar/'.date('Y').'/'.date('m'));
} // END index()
//======================================================================================================
/*
** 	view()
**
** 	Requires URI segments 3 & 4 after the view/ part of the URI, parsing them as Year and Month
**	respectively.  Then sets up the page with all of the data the widgets need.
*/
//------------------------------------------------------------------------------------------------------
public function view() {
	$year = $this->uri->segment(3, 0);
	$month = $this->uri->segment(4, 0);

	if ( $year === 0 )
		$year = date('Y');
	if ( $month === 0 )
		$month = date('m');
	// Get the month name for the given month
	$dateObj   = DateTime::createFromFormat('!m', $month);
	$month_name = $dateObj->format('F');
	// Set up the year and month drop-downs:
	$allYears = $this->Calendar->util_get_years();
	$allMonths = $this->Calendar->util_get_months();
	$selectedYear = $allYears[$year];
	$selectedMonth = $allMonths[$month];

	$this->add_page_data(array(
		'scripts' => $this->get_scripts(),
		'eventTypes' => $this->get_calendar_types(),
		'calendarView' => $this->make_calendar_item_widget($month, $year),

		'dd_years' => $allYears,
		'dd_months' => $allMonths,
		'dd_select_year' => $selectedYear,
		'dd_select_month' => $selectedMonth,

		'month' => $month,
		'monthName' => $month_name,
		'year' => $year
	));
	
	$this->render_page();
} // END view()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		WIDGET RENDERING
//			make_calendar_item_widget
//
//======================================================================================================
/*
** 	make_calendar_item_widget($month, $year)
**
** 	The Calendar Item widget is the main view for updating and browsing months to edit.
**	It requires a month and year in order to pre-populate form fields for the user with current data.
*/
//------------------------------------------------------------------------------------------------------
private function make_calendar_item_widget($month, $year) {
	$view_data = array();
	$view_path = $this->widget_root.'calendar-items-list';

	$view_data['fatal'] = false;
	$types = $this->Calendar->get_calendar_types();
	$items = $this->Calendar->get_month_items($month, $year);

	$view_data['items'] = $items;
	$view_data['types'] = $types;
	$view_data['month'] = $month;
	$view_data['year'] = $year;

	$dateObj = DateTime::createFromFormat('!m', $month);
	$view_data['monthName'] = $dateObj->format('F');

	return $this->load->view($view_path, $view_data, TRUE);
} // END make_calendar_item_widget()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPERS
//			get_calendar_types
//
//======================================================================================================
/*
** 	get_calendar_types()
**
** 	Gets all available calendar event types from the Calendar model
*/
//------------------------------------------------------------------------------------------------------
private function get_calendar_types() {
	$query = $this->Calendar->get_calendar_types();
	if ( $query->success )
		return $query->data;
} // END get_calendar_types()
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
