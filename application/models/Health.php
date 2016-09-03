<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_Model'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Health extends EXT_Model  {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct() {
	parent::__construct();

	$this->load->model('Calendar');
	$this->load->model('Notice');
} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CALENDAR
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function calendar_health() {
	$result = new stdClass();
	$result->attention = false;
	$result->data = array();

	$messages = array();
	$current = $this->Calendar->get_calendar_items_today();
	if ( !$current->success ) {
		array_push($messages, 'There are no calendar items for this month!');
	}

	$next_month = date('m', strtotime('+1 month'));
	$next_year = date('Y', strtotime('+1 month'));
	$next = $this->Calendar->get_month_items($next_month, $next_year);
	if ( !$next->success ) {
		$num_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		if ( date('d') > $num_days-14 )
			array_push($messages, 'There are no calendar items for next month: '.date('F Y', strtotime('+1 month')).
				', and it is less than 2 weeks until the next month.');
	}

	if ( count($messages) > 0 )
		$result->attention = true;

	$result->data['messages'] = $messages;
	$result->data['attention'] = $result->attention;
	$result->data['current'] = $current->success ? $current->data  : NULL;
	$result->data['next'] = $next->success ? $next->data : NULL;
	$result->data['current_month'] = date('m');
	$result->data['current_year'] = date('Y');
	$result->data['next_month'] = date('m', strtotime('+1 month'));
	$result->data['next_year'] = date('Y', strtotime('+1 month'));

	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		NOTICES
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function notices_health() {
	$result = new stdClass();
	$result->attention = false;
	$result->data = array();

	$messages = array();
	$notices = $this->Notice->get_all();

	$too_old = false;
	if ( $notices->success ) {
		foreach ( $notices->data as $notice ) {
			if ( $notice->notice_date < date('Y-m-d', strtotime('-3 month')) ) {
				$too_old = true;
				$notice->old = true;
			}
			else
				$notice->old = false;
		}
	}

	if ( $too_old )
		array_push($messages, 'You have one or more notices that are over 3 months old.');

	if ( count($messages) > 0 )
		$result->attention = true;

	$result->data['messages'] = $messages;
	$result->data['attention'] = $result->attention;
	$result->data['notices'] = $notices->data;

	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		MEETINGS
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function meetings_health() {
	$result = new stdClass();
	$result->attention = false;
	$result->data = array();

	$messages = array();
	
	$this->db->select('tc.*, trm.calendar_id, trm.agenda_path, trm.minutes_path, tct.text')
		->from($this->TABLE_CALENDAR.' as tc')
		->join($this->TABLE_RESOURCES_MEETINGS.' as trm', 'tc.id=trm.calendar_id', 'left')
		->join($this->TABLE_CALENDAR_TYPES.' as tct', 'tc.type=tct.id', 'left')
		->where('tc.type=', 2)->or_where('tc.type=', 3)
		->order_by('date desc, id asc');
	$query = $this->db->get();
	$query = $query->result();

	$missing = false;
	foreach ( $query as $meeting ) {
		if ( !isset($meeting->agenda_path) || !isset($meeting->minutes_path) )
			$missing = true;
	}
	if ( $missing )
		array_push($messages, 'One or more meetings are missing agenda or minutes');

	if ( count($messages) > 0 )
		$result->attention = true;

	$result->data['messages'] = $messages;
	$result->data['attention'] = $result->attention;
	$result->data['meetings'] = $query;

	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		FAQ
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function faq_health() {
	$result = new stdClass();
	$result->attention = false;
	$result->data = array();

	$messages = array();
	
	$this->db->select('*')
		->from($this->TABLE_FAQ)
		->order_by('last_updated desc')->limit(1);
	$query = $this->db->get();
	$row = $query->row();

	if ( $row->last_updated < date('Y-m-d', strtotime('-6 months')) )
		array_push($messages, 'FAQ last updated over 6 months ago.');

	if ( count($messages) > 0 )
		$result->attention = true;

	$result->data['messages'] = $messages;
	$result->data['attention'] = $result->attention;
	$result->data['faq'] = $row;

	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class
?>