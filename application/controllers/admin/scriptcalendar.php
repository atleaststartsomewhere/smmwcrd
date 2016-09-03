<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptcalendar extends EXT_ScriptController {
//		Inherited Methods:
//			add_error( string ) void 		appends an error message to SESSION
//			add_success( string ) void 		appends a success message to SESSION
//			has_errors( ) boolean 			checks whether or not errors are saved in SESSION
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		CONSTRUCTOR
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( ) {
	parent::__construct();

	// Loader Calls
	$this->load->model('Calendar');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		ACTION FUNCTIONS (Route Accessible)
//			add
//			update
//			browse
//
//======================================================================================================
/*
** 	add()
**
** 	Takes a type and date and then inserts it into the database
*/
//------------------------------------------------------------------------------------------------------
public function __DEPRECATED__add() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;
	$type = $_POST['add_type'];
	$date = $_POST['date'];

	// Validate
	if ( !isset($date) || empty($date) )
		$this->add_error('Error with Adding Event: Date field must not be empty.');

	if ( !isset($type) || empty($type) )
		$this->add_error('Error with Adding Event: Must select a valid event type.');

	// If we have no errors, run the query
	if ( !$this->has_errors() )
		$this->create_calendar_item($type, $date);

	redirect('admin/calendar/');
}
//======================================================================================================
/*
**	update()
**
** 	Takes multiple inputs of date IDs with boolean removal, new types and dates - as well as the current
** 	month and year.
**
**	We loop through all ids and test for whether or not the remove checkbox was on, and then we scrub
**	the ID from the array of IDs to update with new dates/types ID after we remove the row from the 
**	database.
*/
//------------------------------------------------------------------------------------------------------
public function update() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;

	// Update setup
	$types = $_POST['eventType'];
	$dates = $_POST['eventDate'];
	$removals = isset($_POST['remove']) ? $_POST['remove'] : null;
	$month = $_POST['month'];
	$year = $_POST['year'];
	// New Event setup
	$newType = $_POST['newEvent_type'];
	$newDate = $_POST['newEvent_date'];

	// Sweep Through Events and Run Removals
	$item_ids = $types;
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $remove_id => $remove_data ) {
			// remove
			if ( $remove_data === "on" ) {
				$this->remove_calendar_item($remove_id);
				unset($item_ids[$remove_id]);
			}
		} 
	}
	// Run Updates on the Remaining Items
	foreach ( $item_ids as $id => $type) {
		$package = array();
		$package['type'] = $type;
		$date_pieces = explode("/", $dates[$id]);
		$package['date'] = $year.'-'.$date_pieces[0].'-'.$date_pieces[1];
		$this->update_calendar_item($id, $package);
	}
	// Run the Add
	if ( isset($newType) && isset($newDate) && !empty($newType) && !empty($newDate) )
		$this->create_calendar_item($newType, $newDate);

	redirect('admin/calendar/'.$year.'/'.$month);
}
//======================================================================================================
/*		
**	browse()
**
** 	Takes a browse_date and then transforms it into a valid URI to redirect the user to.
**
*/
//------------------------------------------------------------------------------------------------------
public function browse() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;

	$browse_year = isset($_POST['browse_year']) ? $_POST['browse_year'] : date('Y');
	$browse_month = isset($_POST['browse_month']) ? date('m', strtotime($_POST['browse_month'])) : date('m');

	redirect('admin/calendar/'.$browse_year.'/'.$browse_month);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//			create_calendar_item(type_id, dateString)
//			update_calendar_item(row_id, rowData)
//			remove_calendar_item(row_id)
//
//
//======================================================================================================
private function create_calendar_item($type, $date) {
	$insert = array();
	$insert['date'] = date('Y/m/d', strtotime($date));
	$insert['type'] = (int)$type;

	$query_type = $this->Calendar->get_typename_by_id($type);
	$typename = $query_type->data->text;
	$dateString = date('F jS, Y', strtotime($date));

	$query_add = $this->Calendar->add_calendar_item($insert);

	if ( !$query_add->success ) {
		$this->add_error('Was unable to create '.$typename.' on '.$dateString
			.' Please try again or contact your administrator if this problem persists.');
		return false;
	}

	$this->add_success('<b>'.$dateString.' '.$typename.'</b> created successfully.');
}
//======================================================================================================
private function update_calendar_item($item_id, $package) {
	$query = $this->Calendar->update_item($item_id, $package);

	// ITEM NOT FOUND
	if ( !isset($query->data) && !$query->success ) { 
		$this->add_error('Item does not exist.'
			.'Please try again or contact your administrator if this problem persists.');
		return false;
	}
	$item = $query->data;

	// ITEM FOUND AND CONFIRMED UPDATED
	foreach ( $query->messages as $m )
		$this->add_success($m);
	return true;
}
//======================================================================================================
private function remove_calendar_item($item_id) {
	$query = $this->Calendar->delete_by_id($item_id);

	// ITEM NOT FOUND
	if ( !isset($query->data) && !$query->success ) { 
		$this->add_error('Item does not exist to delete.'
			.'Please try again or contact your administrator if this problem persists.');
		return false;
	}

	$item = $query->data;
	$dateString = date('F jS, Y', strtotime($item->date));

	// ITEM FOUND BUT COULD NOT DELETE
	if ( !$query->success ) { 
		$this->add_error('Could not delete ' . $item->text . ' on ' . $dateString . '.  '
			.'Please try again or contact your administrator if this problem persists.');
		return false;
	}

	// ITEM FOUND AND CONFIRMED DELETED
	$this->add_success('<b>'.$dateString.' '.$item->text.'</b> deleted successfully.');
	return true;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
