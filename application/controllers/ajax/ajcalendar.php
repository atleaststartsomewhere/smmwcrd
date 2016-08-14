<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajcalendar extends EXT_AJAXController {
// START OF CLASS
function Ajcalendar( ) {
	parent::__construct();

	$this->load->model('Calendar');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajcalendar serves as merely an endpoint for ajax requests from calendar widgets.
// As such, this should not have an index function.
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	show_404();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
// 		get_current
//	The calendar widget on the home page lets the user browse calendar items month by month.
// 	This function queries the item for the current month and sends them back in JSON
////////////////////////////////////////////////////////////////////////////////////////////////////////
// POST <-> JSON
public function get_current() {
	$year  = date('Y');
	$month  = date('m');
	$result = new stdClass();

	$calendarQuery = $this->Calendar->get_month_items($month, $year);
	//quick check for success and send to front end as JSON
	if ( $calendarQuery->success ) {
		$result->success = true;
		$result->items = $calendarQuery->data;
		$result->message = $calendarQuery->messages;

		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	else {
		$result->success = false;
		$result->message = $calendarQuery->messages;

		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	echo json_encode($result);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// 		get_next
//	The calendar widget on the home page lets the user browse calendar items month by month.
//	This function requires AJAX POST to it, with a 'month' and 'year' and it will find the right
//	next month to query items from the database to give back to the calling widget.
////////////////////////////////////////////////////////////////////////////////////////////////////////
// GET <-> JSON
public function get_next() { // AJAX call sends GET vars
	$postedYear  = $_GET['year'];
	$postedMonth  = $_GET['month'];
	$result = new stdClass();

	// Debug
	/*$postedMonth = 12;
	$postedYear = 2013;*/

	// Validate Month(1-12) and Year Limits(what to currentYear?)
	if ( !isset($_GET['year']) || !isset($_GET['month']) ) {
		$result->success = false;
		$result->message = array('Month and Year must be supplied.');
		echo json_encode($result);
		return;
	}

	// Push forward to the next year if we're in December
	if ( $postedMonth == 12 ) {
		$year = $postedYear + 1;
		$month = 1;
	}
	// Otherwise simply advance the month
	else {
		$year = $postedYear;
		$month = $postedMonth + 1;
	}

	// Debug
	//echo $month;echo$year;return;
	
	$calendarQuery = $this->Calendar->get_month_items($month, $year);
	//quick check for success and send to front end as JSON
	if ( $calendarQuery->success ) {
		$result->success = true;
		$result->items = $calendarQuery->data;
		$result->message = $calendarQuery->messages;

		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	else {
		$result->success = false;
		$result->message = $calendarQuery->messages;

		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	echo json_encode($result);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//		get_prev
//	The calendar widget on the home page lets the user browse calendar items month by month.
//	This function requires AJAX POST to it, with a 'month' and 'year' and it will find the right
//	previous month to query items from the database to give back to the calling widget.
////////////////////////////////////////////////////////////////////////////////////////////////////////
// GET <-> JSON
public function get_prev() { // AJAX call sends GET vars
	$postedYear  = $_GET['year'];
	$postedMonth  = $_GET['month'];
	$result = new stdClass();

	// Debug
	/*$postedMonth = 12;
	$postedYear = 2013;*/

	// Validate Month(1-12) and Year Limits(what to currentYear?)
	if ( !isset($_GET['year']) || !isset($_GET['month']) ) {
		$result->success = false;
		$result->message = array('Month and Year must be supplied.');
		echo json_encode($result);
		return;
	}

	// Pull back to the previous year if we're in January
	if ( $postedMonth ==  1 ) {
		$year = $postedYear - 1;
		$month = 12;
	}
	// Otherwise simply subtract a month
	else {
		$year = $postedYear;
		$month = $postedMonth - 1;
	}

	// Debug
	//echo $month;echo$year;return;
	
	$calendarQuery = $this->Calendar->get_month_items($month, $year);
	//quick check for success and send to front end as JSON
	$result = new stdClass();
	if ( $calendarQuery->success ) {
		$result->success = true;
		$result->items = $calendarQuery->data;
		$result->message = $calendarQuery->messages;
		
		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	else {
		$result->success = false;
		$result->message = $calendarQuery->messages;

		// Add in month name ot the result
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$result->month = $dateObj->format('F');
		$result->year = $year;
	}
	echo json_encode($result);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// END OF CLASS
}
