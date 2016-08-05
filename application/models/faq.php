<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*	MODEL: RESOURCE
 *	This model is responsible for the loading and storing of links to documents and external links used
 *  by the site's users as resources provided by SMMWC
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Faq extends EXT_Model  {
	private $TABLE_FAQ		 	= "faq";
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
	
	$this->config->load('smmwc');

} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_faq() {
	$this->db->order_by('order asc, id asc');
	$query = $this->db->get($this->TABLE_FAQ);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No FAQ found."));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
// - OLD FUNCTIONS BELOW

	// attributes
/*	function get_faq( )
	{
		$result = new stdClass();

		$this->db->order_by('order', 'asc');
		$query = $this->db->get('faq');
		if ( $query->num_rows() < 1 )
		{
			$result->success = false;
			$result->rows = array();
			return $result;
		}

		$result->success = true;
		$result->rows = $query->result();

		return $result;
	}
	function add_faq($package)
	{
		$this->db->insert('faq', $package);
	}
	function remove_faq($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('faq');
	}
	function update_faq($id, $package)
	{
		$this->db->where('id', $id);
		$this->db->update('faq', $package);
	}*/

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class
?>