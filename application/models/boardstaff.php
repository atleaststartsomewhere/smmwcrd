<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_Model'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class BoardStaff extends EXT_Model  {
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
	// Load models here

	// Load libraries here

} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * CREATE
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function create_board_member($package) {
	$this->db->insert($this->TABLE_BOARD, $package);

	$row = $this->get_board_member_by_id($this->db->insert_id());
	if ( !$row->success )
		return $this->result(false, array("New board member was unable to be added."));

	return $this->result(true, array(), $row->data);
}
public function create_staff_member($package) {
	$this->db->insert($this->TABLE_STAFF, $package);

	$row = $this->get_staff_member_by_id($this->db->insert_id());
	if ( !$row->success )
		return $this->result(false, array("New staff member was unable to be added."));

	return $this->result(true, array(), $row->data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * READ
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_board_member_by_id($id) {
	$this->db->limit(1);
	$query = $this->db->get_where($this->TABLE_BOARD, array('id' => $id));

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No board member found with that identifier."));

	return $this->result(true, array(), $query->row());
}
public function get_staff_member_by_id($id) {
	$this->db->limit(1);
	$query = $this->db->get_where($this->TABLE_STAFF, array('id' => $id));

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No staff member found with that identifier."));

	return $this->result(true, array(), $query->row());
}
public function get_board() {
	$this->db->order_by('order asc, id desc');
	$query = $this->db->get($this->TABLE_BOARD);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No board members found."));

	return $this->result(true, array(), $query->result());
}
public function get_staff() {
	$this->db->order_by('order asc, id desc');
	$query = $this->db->get($this->TABLE_STAFF);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No staff found."));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * UPDATE
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function update_board_member($id, $package) {
	$this->db->where('id', $id);
	$this->db->update($this->TABLE_BOARD, $package);

	$row = $this->get_board_member_by_id($id);

	return $this->result(true, array(), $row->data);
}
public function update_staff_member($id, $package) {
	$this->db->where('id', $id);
	$this->db->update($this->TABLE_STAFF, $package);

	$row = $this->get_staff_member_by_id($id);

	return $this->result(true, array(), $row->data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * DELETE
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function delete_board_member_by_id($id) {
	$row = $this->get_board_member_by_id($id);
	if ( !$row->success )
		return $this->result(false, array('No row with that ID found.'));

	$row = $row->data;

	$this->db->delete($this->TABLE_BOARD, array('id' => $id));

	$check_exists = $this->get_board_member_by_id($id);
	if ( $check_exists->success )
		return $this->result(false, array('Row was unsuccessfully deleted.'));

	return $this->result(true, array(), $row);
}
public function delete_staff_member_by_id($id) {
	$row = $this->get_staff_member_by_id($id);
	if ( !$row->success )
		return $this->result(false, array('No row with that ID found.'));

	$row = $row->data;

	$this->db->delete($this->TABLE_STAFF, array('id' => $id));

	$check_exists = $this->get_staff_member_by_id($id);
	if ( $check_exists->success )
		return $this->result(false, array('Row was unsuccessfully deleted.'));

	return $this->result(true, array(), $row);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * UTILITY
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class