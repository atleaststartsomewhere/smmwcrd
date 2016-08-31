<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class EXT_Model extends CI_Model {
protected $TABLE_CALENDAR 				= 'calendar';
protected $TABLE_CALENDAR_TYPES 		= 'calendar_types';
protected $TABLE_CONFIG 				= 'config';
protected $TABLE_CONTENT				= 'content';
protected $TABLE_CONTENT_TYPES			= 'content_types';
protected $TABLE_FAQ	 				= 'faq';
protected $TABLE_BOARD					= 'list_board_members';
protected $TABLE_STAFF					= 'list_staff';
protected $TABLE_NOTICES				= 'notices';
protected $TABLE_NOTICES_TYPES			= 'notices_types';
protected $TABLE_RESOURCES				= 'resources';
protected $TABLE_RESOURCES_CATEGORIES	= 'resources_categories';
protected $TABLE_RESOURCES_FEATURED		= 'resources_featured';
protected $TABLE_RESOURCES_MEETINGS		= 'resources_meetings';
protected $TABLE_USERS 					= 'users';
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 *	This function produces uniform results for the application that models should use.
 */
public function result($success=false, $messages=array(), $data = null) {
	$result = new stdClass();
	$rSuccess = $success;
	$rMessages = $messages;
	$rData = $data;

	$result->success = $rSuccess;
	$result->messages = $rMessages;
	$result->data = $rData;
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class EXT_Model