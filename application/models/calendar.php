<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*	MODEL: CALENDAR
 *	This model is responsible for the loading and storing of calendar items to be displayed across
 *  various pages.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Calendar extends EXT_Model  {
	private $TABLE_CALENDAR 	= "calendar";
	private $TABLE_TYPES	 	= "calendar_types";
	private $TABLE_RES_MEETINGS	= "resources_meetings";

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();

	// Loader calls
	$this->load->config('smmwc');

} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CREATE
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		add_calendar_item
 * Add a calendar item to the database, and then check it with our get_item_by_id function
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add_calendar_item($package) {
	$this->db->insert($this->TABLE_CALENDAR, $package);

	return $this->get_item_by_id($this->db->insert_id());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		READ
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_calendar_items_today
 * Get calendar items in the database with a date included within the month of the current date
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_calendar_items_today() {
	$this->db->select("ct.type_name, ct.text, c.*")->from($this->TABLE_CALENDAR.' as c');
	$this->db->join($this->TABLE_TYPES.' as ct', 'c.type=ct.id');
	$num_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
	$this->db->where("c.date >= '".date('Y-m-01')."'")->where("c.date <= '".date('Y-m-'.$num_days)."'");
	$this->db->order_by('c.date asc');
	$query_calToday = $this->db->get();

	if ( $query_calToday->num_rows() < 1 )
		return $this->result(false, array('No calendar items found'));

	return $this->result(true, array(), $query_calToday->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_month_items
 * Get calendar items for a given month and year
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_month_items($month, $year) {
	$this->db->select("ct.type_name, ct.text, c.*")->from($this->TABLE_CALENDAR.' as c');
	$this->db->join($this->TABLE_TYPES.' as ct', 'c.type=ct.id');
	$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	$this->db->where("c.date >= '".date($year.'-'.$month.'-01')."'")->where("c.date <= '".date($year.'-'.$month.'-'.$num_days)."'");
	$this->db->order_by('c.date asc');
	$query_getMonth = $this->db->get();

	if ( $query_getMonth->num_rows() < 1 )
		return $this->result(false, array('No calendar items found'));

	return $this->result(true, array(), $query_getMonth->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_calendar_types
 * Get calendar types; table: $this->TABLE_TYPES
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_calendar_types() {
	$query_getTypes = $this->db->get($this->TABLE_TYPES);
	if ( $query_getTypes->num_rows() < 1 )
		return $this->result(false, array('No calendar types found'));

	return $this->result(true, array(), $query_getTypes->result());
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_typename_by_id
 * Get calendar type name by id; table: $this->TABLE_TYPES
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_typename_by_id($type_id) {
	$query_getType = $this->db->get_where($this->TABLE_TYPES, array('id' => $type_id), 1);
	if ( $query_getType->num_rows() < 1 )
		return $this->result(false, array('No type found'));

	return $this->result(true, array(), $query_getType->result()[0]);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_item_by_id
 * Get a row from the $this->TABLE_CALENDAR table and join it's type on $this->TABLE_TYPES
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_item_by_id($item_id) {
	$this->db->select('ct.type_name, ct.text, c.*')->from($this->TABLE_CALENDAR.' as c');
	$this->db->join($this->TABLE_TYPES.' as ct', 'c.type=ct.id');
	$this->db->where('c.id', $item_id);
	$this->db->limit(1);
	$query_getItem = $this->db->get();

	if ( $query_getItem->num_rows() < 1 )
		return $this->result(false, array('Item not found.'));

	return $this->result(true, array(), $query_getItem->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_meetings_page
 * Get all calendar items in the database that are either board meetings or shareholder meetings
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_meetings_page($page) {
	$page_length = $this->config->item('admin_rows_per_page');
	$this->db->select("ct.type_name, ct.text, rm.agenda_path, rm.minutes_path, c.*")->from($this->TABLE_CALENDAR.' as c');
	$this->db->join($this->TABLE_TYPES.' as ct', 'c.type=ct.id');
	$this->db->join($this->TABLE_RES_MEETINGS.' as rm', 'c.id=rm.calendar_id', 'left');
	$this->db->where('c.type<>1');
	$this->db->limit($page_length, ($page-1)*$page_length);
	$this->db->order_by('c.date desc');
	$query_calMeetings = $this->db->get();
	//return $this->result(true, array(), $this->db->last_query());

	if ( $query_calMeetings->num_rows() < 1 )
		return $this->result(false, array('No calendar items found'));

	return $this->result(true, array(), $query_calMeetings->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		UPDATE
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		update_item
 * Updates a row on $this->TABLE_CALENDAR by matching the id and setting the remaining columns with the
 * package's keys
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function update_item($item_id, $item_package) {
	// Check for old item
	$query_oldItem = $this->get_item_by_id($item_id);
	if ( !$query_oldItem->success )
		return $this->result(false, $query_oldItem->messages, $query_oldItem);
	$oldItem = $query_oldItem->data[0];

	// Update
	$this->db->where('id', $item_id);
	$query_update = $this->db->update($this->TABLE_CALENDAR, $item_package);

	// Get New Item
	$query_newItem = $this->get_item_by_id($item_id);
	$newItem = $query_newItem->data[0];

	if ( $this->db->affected_rows() != 1 )
		return $this->result(false, array('Error updating item on '. $query_oldItem['date']));

	// Assemble Smart Message
	$oldDateString = date('F jS, Y', strtotime($oldItem->date));
	$newDateString = date('F jS, Y', strtotime($newItem->date));
	$message = 'Updated <b>'.$oldDateString.' '.$oldItem->text.'</b> &rarr; ';
	if ( $oldItem->text == $newItem->text && $oldItem->date == $newItem->date )
		return $this->result(true, array(), $newItem); // Display no message
	
	$message .= '<b>'.$newDateString.'</b> ';
	$message .= '<b>' . $newItem->text.'</b>';

	return $this->result(true, array($message), $newItem);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		DELETE
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		delete_by_id
 * Deletes an entry from $this->TABLE_CALENDAR by matching the id
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function delete_by_id($item_id) {
	$query_checkExists = $this->db->get_where('calendar', array('id' => $item_id), 1);
	// Check if ID exists in the first place
	if ( $query_checkExists->num_rows() < 1 )
		return $this->result(false, array('The item does not exist. Please contact your system administrator'));
	// If it does, get the row data for some meaningful front-end messages
	$item = $this->get_item_by_id($item_id)->data[0];

	$this->db->delete('calendar', array('id' => $item_id));
	// Check if still exists after delete
	$query_checkExists = $this->db->get_where('calendar', array('id' => $item_id), 1);
	if ( $query_checkExists->num_rows() > 0 )
		return $this->result(false, array('Item still exists.'), $item);

	return $this->result(true, array(), $item);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		UTILITY
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		count_meetings
 * Counts the number of pages it would take to list all meetings in the database if there are a number
 * of items listed per page equal to the threshold defined in the config
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function count_meetings() {
	
	$this->db->where('type<>1');
	$this->db->from($this->TABLE_CALENDAR);

	return $this->db->count_all_results();
}
public function util_get_months() {
	$months = array();

	for ($m=1; $m<=12; $m++) {
		$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
		$month_int = date('m', mktime(0,0,0,$m, 1, date('Y')));
		$months[$month_int] = (string)$month;
	}

	return $months;
}
public function util_get_years() {
	$years = array();

	$currentY = date('Y');
	$currentY = $currentY + 1;
	$max_early_year = $this->config->item('cal_max_pre_year');

	for ( $y = $currentY; $y > $currentY-$max_early_year; $y-- )
		$years[$y] = (string)$y;

	return $years;

}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
?>