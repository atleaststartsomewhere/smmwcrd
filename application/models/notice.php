<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*	MODEL: NOTICE
 
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Notice extends EXT_Model  {
	private $TABLE_NOTICES		 	= "notices";
	private $TABLE_RESOURCES_LINK 	= "notices_resources";
	private $TABLE_TYPES		 	= "notices_types";
	private $TABLE_RESOURCES 		= "resources";
	private $TABLE_RES_CATEGORIES	= "resources_categories";
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
	
	$this->config->load('smmwc');

} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		CREATE
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function create($package) {
	$this->db->insert($this->TABLE_NOTICES, $package);

	$row = $this->get_by_id($this->db->insert_id());
	if ( !$row->success )
		return $this->result(false, array("New notice was unable to be added."));

	return $this->result(true, array(), $row->data);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		READ
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_by_id($id) {
	$this->db->select('n.*');
	$this->db->from($this->TABLE_NOTICES.' as n');
	$this->db->where('id', $id);
	$this->db->limit(1);
	$query = $this->db->get();

	if ( $query->num_rows() < 1 )
		return $this->result(false, array('Could not find this notice: '.$id));

	return $this->result(true, array(), $query->row());

}
public function get_all() {
	$this->db->order_by('order asc, notice_date desc, id desc');
	$query = $this->db->get($this->TABLE_NOTICES);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array('No notices found.'));

	return $this->result(true, array(), $query->result());
}
public function get_types() {
	$this->db->order_by('order asc');
	$query = $this->db->get($this->TABLE_TYPES);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array('No notice types found.'));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		UPDATE
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function update($id, $package) {
	$this->db->where('id', $id);
	$this->db->update($this->TABLE_NOTICES, $package);

	$row = $this->get_by_id($id);

	return $this->result(true, array(), $row->data);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		DELETE
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function delete_by_id($id) {
	$row = $this->get_by_id($id);
	if ( !$row->success )
		return $this->result(false, array('No row with that ID found.'));

	$row = $row->data;

	$this->db->delete($this->TABLE_NOTICES, array('id' => $id));

	$check_exists = $this->get_by_id($id);
	if ( $check_exists->success )
		return $this->result(false, array('Row was unsuccessfully deleted.'));

	return $this->result(true, array(), $row);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		UTILITY
//
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class
?>