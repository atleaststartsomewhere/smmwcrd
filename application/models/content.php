<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*	MODEL: CONTENT
 *	This model is responsible for the loading and storing of non-widgetized page content across all pages.
 *	For example, paragraph text, virtual arrays and images.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Content extends EXT_Model  {
	private $TABLE_CONTENT			= "content";
	private $TABLE_CONTENT_TYPES	= "content_types";
	private $TABLE_BOARD			= "list_board_members";
	private $TABLE_STAFF			= "list_staff";

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
	// Load models here

	// Load libraries here

} // end constructor

////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * This function inserts contents into the database.
 * Type, key_name, and data must be supplied.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function insert_item($nType='', $key_name='', $data='') {
	$insertType = trim(strtolower($nType));
	$insertTypeId = 0;
	$insertData = $data;
	$resultMessages = array();

	// Get types from database
	$typesQuery = $this->get_types();
	if ( !$typesQuery->success ) { // Query was unsuccessful
		array_push($resultMessages, array('Error retrieving content types:' . implode(", ", $typesQuery->messages)));
		return $this->result(false, $resultMessages);
	}
	// Check parameter nType against the database types
	foreach ( $typesQuery->data as $type ) {
		if ( trim(strtolower($nType)) == trim(strtolower($type->name)) )
			$insertTypeId = $type->id;
	}
	// This check will be false if the type was not found
	if ( $insertTypeId == 0 )
		return $this->result(false, array('Unable to locate specified type: [' . $nType . ']'));

	if ( !isset($key_name) || empty($key_name) )
		return $this->result(false, array('Must supply a key_name'));

	// Check if there's a duplicate key name
	$keyQuery = $this->db->get_where('content', array('key_name' => $key_name), 1);
	if ( $keyQuery->num_rows() > 0 )
		return $this->result(false, array('Key name already exists in database'));

	if ( !isset($data) || empty($data) )
		return $this->result(false, array('Must supply some kind of data for: ' . $insertType));

	// Everything's okay, so proceed
	if ( $insertType == "array" ) {
			if ( !is_array($insertData) )
				return $this->result(false, array('Supplied data was not an array, unlike the specified insert type.'));
			$insertData = serialize($insertData);
		
			return $this->result(false, array('An error occurred checking the insert type'));
	}

	// Assemble the insertRow
	$insertRow = array(
		'key_name' => $this->db->escape_str($key_name),
		'type' => $this->db->escape_str($insertTypeId),
		'data' => $this->db->escape_str($insertData)
	);
	// Send to database
	$insertQuery = $this->db->insert('content', $insertRow);
	if ( !defined(ENVIRONMENT) || strtolower(ENVIRONMENT) == 'development' )
		array_push($resultMessages, 'Successfully added row: ' . $this->db->insert_id() . ' to "content" table.');

	return $this->result(true, $resultMessages);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Retrieves a single row from the database based on the key_name column.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_item_id_by_key($keyText='') {
	$resultMessages = array();

	if ( empty($keyText) )
		return $this->result(false, array('Must supply a key name to retrieve'));

	$this->db->select("content.id, content.key_name, content.data, content_types.name as type_name");
	$this->db->from("content");
	$this->db->join("content_types", "content.type = content_types.id");
	$this->db->where('content.key_name', $keyText);
	$this->db->limit(1);
	$getQuery = $this->db->get();

	if ( $getQuery->num_rows() < 1 )
		return $this->result(false, array('No results found for supplied key.'));

	return $this->result(true, array(), $getQuery->result()[0]->id);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Retrieves a single row from the database based on the key_name column.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_item_by_key($keyText='', $translate_to_br=true) {
	$resultMessages = array();

	if ( empty($keyText) )
		return $this->result(false, array('Must supply a key name to retrieve'));

	$this->db->select("content.id, content.key_name, content.data, content_types.name as type_name");
	$this->db->from("content");
	$this->db->join("content_types", "content.type = content_types.id");
	$this->db->where('content.key_name', $keyText);
	$this->db->limit(1);
	$getQuery = $this->db->get();

	if ( $getQuery->num_rows() < 1 )
		return $this->result(false, array('No results found for supplied key.'));

	$resultRow = $getQuery->result()[0];

	$resultData = array();
	if ( strtolower($resultRow->type_name) == "array" )
		$resultData[$resultRow->key_name] = unserialize($resultRow->data);
	else
	{
		$data = $resultRow->data;
		if ( $translate_to_br )
			$data = nl2br($data);

		$resultData[$resultRow->key_name] = $data;
	}

	return $this->result(true, array(), $resultData);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Retrieves multiple rows from the database based on an array of supplied key names matching the 
 * key_name column.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_items_by_keys($keyNamesArray, $translate_to_br=true) {
	$resultMessages = array();

	if ( empty($keyNamesArray) )
		return $this->result(false, array('Must supply an array of keys to retrieve'));

	if ( !is_array($keyNamesArray) )
		return $this->result(false, array('Must supply a valid array of keys to retrieve'));

	$this->db->select("content.id, content.key_name, content.data, content_types.name as type_name");
	$this->db->from("content");
	$this->db->join("content_types", "content.type = content_types.id");
	$this->db->where_in('content.key_name', $keyNamesArray);
	$getQuery = $this->db->get();

	if ( $getQuery->num_rows() < 1 )
		return $this->result(false, array('No results found for supplied keys.'));

	$resultData = array();
	foreach ( $getQuery->result() as $result )
	{
		if ( strtolower($result->type_name) == "array" )
			$resultData[$result->key_name] = unserialize($result->data);
		else
		{
			$data = $result->data;
			if ( $translate_to_br )
				$data = nl2br($data);
			
			$resultData[$result->key_name] = $data;
		}
	}		

	return $this->result(true, array(), $resultData);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Updates an existing item in the database matched by key_name
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function update_item($key_name, $data) {
	$resultMessages = array();

	// Check Key
	if ( !isset($key_name) || empty($key_name) )
		return $this->result(false, array('Key name must be supplied'));
	$lookup_key = $this->get_item_by_key($key_name);
	if ( !$lookup_key->success )
		return $this->result(false, $lookup_key->messages);

	// Check Data
	if ( !isset($data) )
		return $this->result(false, array('Error: Data not set'));

	// Assemble the update
	$package = array();
	$package['key_name'] = $key_name;
	if ( strtolower($typeObj->name) == "array" )
		$data = serialize($data);
	$package['data'] = trim($data);

	$this->db->where('key_name', $key_name);
	$this->db->update('content', $package);

	if ( !defined(ENVIRONMENT) || strtolower(ENVIRONMENT) == 'development' )
		array_push($resultMessages, 'Successfully updated row in "content" table.');

	return $this->result(true, $resultMessages);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Deletes an existing item in the database matched by key_name
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function delete_item_by_key($key_name) {
	$resultMessages = array();

	// Check Key
	if ( !isset($key_name) || empty($key_name) )
		return $this->result(false, array('Key name must be supplied'));
	$lookup_key = $this->get_item_by_key($key_name);
	if ( !$lookup_key->success )
		return $this->result(false, $lookup_key->messages);

	$delete_id = $this->get_item_id_by_key($key_name)->data;
	$this->db->delete('content', array('id' => $delete_id));

	if ( $this->db->affected_rows() < 1 )
		return $this->result(false, array('No table rows affected'));

	return $this->result(true, array(), null);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Gets all the names of types of content from the database
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_types() {

	$query = $this->db->get('content_types');

	if ( $query->num_rows() < 1 ) {
		return $this->result(false, array('No results for content types found.'));
	}

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Gets a type_id for a given name
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_type_by_name($name) {
	if ( !isset($name) || empty($name) )
		$this->result(false, array('Name must be supplied'));

	$lookup = $this->db->get_where('content_types', array('name' => $name), 1);
	if ( $lookup->num_rows < 1 )
		return $this->result(false, array("Could not find type within database"));

	return $this->result(true, array(), $lookup->result()[0]);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * HELPERS
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_board() {
	$query = $this->db->get($this->TABLE_BOARD);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No board members found."));

	return $this->result(true, array(), $query->result());
}
public function get_staff() {
	$query = $this->db->get($this->TABLE_STAFF);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No staff found."));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class