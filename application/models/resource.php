<?php defined('BASEPATH') OR exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*	MODEL: RESOURCE
 *	This model is responsible for the loading and storing of links to documents and external links used
 *  by the site's users as resources provided by SMMWC
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Resource extends EXT_Model  {
	private $TABLE_CALENDAR 	= "calendar";
	private $TABLE_TYPES	 	= "calendar_types";
	private $TABLE_RESOURCES 	= "resources";
	private $TABLE_CATEGORIES 	= "resources_categories";
	private $TABLE_RES_MEETINGS	= "resources_meetings";

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function __construct() {
	parent::__construct();
	
	$this->config->load('smmwc');

	$this->load->helper('file');

} // end constructor
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		add_resource
 *	Adds a resource to the database, agnostic of file upload.  Saves the path with whether or not the
 *  resource is a link.
 *	If it's a link, the first parameter should be TRUE; Files should have the first parameter set to
 *  FALSE.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add_resource($is_link=TRUE, $category, $path) {
	return "UPDATE THIS";
} // end add_resource()
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		add_agenda_to_meeting
 *	Adds an agenda path to an existing meeting row.  If the old path (previous assigned document) is no
 *	longer being used by any other rows, delete the document.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add_agenda_to_meeting($path, $id) {
	$path = trim($path);
	$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
	$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
	$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
	$this->db->where('rm.calendar_id', $id);
	$this->db->limit(1);
	$check_exists = $this->db->get();
	$return_row = $old_row = $check_exists->row();

	// Meeting entry not yet created
	if ( $check_exists->num_rows() == 0 ) { 
		$package = array('calendar_id' => $id, 'agenda_path' => $path);
		$this->db->insert($this->TABLE_RES_MEETINGS, $package);

		$new_id = $this->db->insert_id();
		$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
		$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
		$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
		$this->db->where('rm.calendar_id', $id);
		$this->db->limit(1);
		$return_row = $this->db->get();
		$return_row = $return_row->row();
	} 
	// Meeting entry exists, just add the agenda path
	else { 
		// Get old doc path - if it's different, then delete the old file if it's not being used
		// Otherwise we can continue with upload because the old file will be overwritten
		$old_path = $old_row->agenda_path;
		if ( isset($old_path) && $old_path != $path ) {
			// We have no other uses for the old document
			if ( !$this->resource_duplicate_uses($old_path) ) { 
				$file_path = $this->config->item('user_res_path_rel') . "/" . $old_path;
				unlink($file_path);
			}
		}

		$package = array('agenda_path' => $path);
		$this->db->where(array('calendar_id' => $id));
		$this->db->update($this->TABLE_RES_MEETINGS, $package);
	}

	return $return_row;
} // end add_agenda_to_meeting()
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		add_minutes_to_meeting
 *	Adds a minutes path to an existing meeting row.  If the old path (previous assigned document) is no
 *	longer being used by any other rows, delete the document. 
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add_minutes_to_meeting($path, $id) {
	$path = trim($path);
	$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
	$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
	$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
	$this->db->where('rm.calendar_id', $id);
	$this->db->limit(1);
	$check_exists = $this->db->get();
	$return_row = $old_row = $check_exists->row();

	// Meeting entry not yet created
	if ( $check_exists->num_rows() == 0 ) { 
		$package = array('calendar_id' => $id, 'minutes_path' => $path);
		$this->db->insert($this->TABLE_RES_MEETINGS, $package);

		$new_id = $this->db->insert_id();
		$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
		$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
		$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
		$this->db->where('rm.calendar_id', $id);
		$this->db->limit(1);
		$return_row = $this->db->get();
		$return_row = $return_row->row();
	} 
	// Meeting entry exists, just add the agenda path
	else { 
		// Get old doc path - if it's different, then delete the old file if it's not being used
		// Otherwise we can continue with upload because the old file will be overwritten
		$old_path = $old_row->minutes_path;
		if ( isset($old_path) && $old_path != $path ) {
			// check if the old_path is being used by other entries

			// We have no other uses for the old document
			if ( !$this->resource_duplicate_uses($old_path) ) {
				$file_path = $this->config->item('user_res_path_rel') . "/" . $old_path;
				unlink($file_path);
			}
		}

		$package = array('minutes_path' => $path);
		$this->db->where(array('calendar_id' => $id));
		$this->db->update($this->TABLE_RES_MEETINGS, $package);
	}

	return $return_row;
} // end add_minutes_to_meeting()
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		create_category
**
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function create_category($category_name) {
	// Trim and clean up the category name
	$category_name = trim($category_name);
	if ( empty($category_name) )
		return $this->result(false, array("Must supply a category name"));
	// Create a url-friendly category name
	$url_friendly = $this->make_url_friendly($category_name);

	$package = array(
		'category_name' => $category_name,
		'url_friendly' => $url_friendly
	);

	$this->db->insert($this->TABLE_CATEGORIES, $package);
	$insert_id = $this->db->insert_id();

	$row = $this->get_category_by_id($insert_id);
	if ( !$row->success )
		return $this->result(false, array("Could not create the category."));

	return $this->result(true, array(), $row->data);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		get_global_resources
 * Get resources flagged as is_global=true in the database.  These resources are easily accessible as links
 * on every page's footer.  Right now there is a hard limit of 5 in the config.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_global_resources( ) {
	$this->db->order_by('order asc');
	$query_globalResources = $this->db->get_where($this->TABLE_RESOURCES, array('is_global' => true), 5);

	if ( $query_globalResources->num_rows() < 1 )
		return $this->result(false, array('No global resources found'));

	return $this->result(true, array(), $query_globalResources->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		get_all_resources()
 * Gets all resources from the databases, adjoining the category name to the row data.
 * Useful for the resources page because it also sorts all the resources into separate categories based
 * on their category_name column for each row.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_all_resources( ) {
	$this->db->order_by("tc.id asc, tr.order asc");
	$this->db->select("tc.category_name as category_name, tr.*");
	$this->db->from($this->TABLE_RESOURCES." as tr");
	$this->db->join($this->TABLE_CATEGORIES." as tc", "tr.category_id=tc.id");
	$query_allResources = $this->db->get();

	if ( $query_allResources->num_rows() < 1 )
		return $this->result(false, array('No Resources Found'));

	// Transform into Array of Collections for Each Category
	$sorted = array();
	foreach ( $query_allResources->result() as $row ) {
		if ( !isset($sorted[$row->category_name]) )
			$sorted[$row->category_name] = array();
		
		array_push($sorted[$row->category_name], $row);
	}

	// Return sorted
	return $this->result(true, array(), $sorted);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		get_categories()
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_categories() {

	$this->db->select('tc.*, count(tr.category_id) as num_resources')
		->from($this->TABLE_CATEGORIES.' as tc')
		->join($this->TABLE_RESOURCES.' as tr', 'tr.category_id=tc.id', 'inner')
		->group_by('tc.id')
		->order_by('tc.order asc, tc.category_name desc');
	$query = $this->db->get();

	if ( $query->num_rows() < 1 )
		return $this->result(false, array('No categories found'));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		get_category_by_id()
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_category_by_id($id) {
	$this->db->limit(1);
	$query = $this->db->get_where($this->TABLE_CATEGORIES, array('id' => $id));

	if ( $query->num_rows() < 1 )
		return $this->result(false, array('No category with that ID found'));

	return $this->result(true, array(), $query->row());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		get_category_resources()
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_category_resources($categoryId) {
	$page_length = $this->config->item('resources_items_per_page');
	$this->db->where(array('category_id' => $categoryId));
	//$this->db->limit($page_length, ($page-1)*$page_length);
	$this->db->order_by('order asc');
	$query = $this->db->get($this->TABLE_RESOURCES);

	if ( $query->num_rows() < 1 )
		return $this->result(false, array("No resource found for this category."));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		count_resource_pages()
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function count_resource_pages($categoryId) {
	$num_per_page = $this->config->item('resources_items_per_page');

	$this->db->from($this->TABLE_RESOURCES);
	$this->db->where('category_id', $categoryId);
	return (int)ceil($this->db->count_all_results() / $num_per_page);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		get_resources_sorted_filtered()
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function get_resources_filtered($cat_filter, $date_filter) {
	$order_str 	= "order asc";
	$where 		= array();
	// Determine correct where from $filter and $filter_value
	if ( isset($cat_filter) )
		$where['tc.id'] = $cat_filter;
	if ( isset($date_filter) )
		$where['tr.date_added'] = $date_filter;

	// Run Full Query
	$this->db->select('tr.*, tc.id as cat_id, tc.category_name as category_name')
		->from($this->TABLE_RESOURCES.' as tr')
		->join($this->TABLE_CATEGORIES.' as tc', 'tr.category_id=tc.id', 'left')
		->order_by($order_str)
	->where($where);
	$query = $this->db->get();

	if ( $query->num_rows() < 1 ) 
		return $this->result(false, array("No items found for current filters"));

	return $this->result(true, array(), $query->result());
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		update_category_by_id($id, $package)
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function update_category_by_id($id, $package) {
	$check_exists = $this->get_category_by_id($id);
	if ( !$check_exists->success )
		return $this->result(false, array('Could not find a resource category with that ID'));

	if ( is_null($package['category_name']) )
		unset($package['category_name']);

	if ( isset($package['category_name']) )
		$package['url_friendly'] = $this->make_url_friendly($package['category_name']);

	$this->db->set($package);
	$this->db->where('id', $id);
	$query = $this->db->update($this->TABLE_CATEGORIES);

	$this->db->limit(1);
	$row = $this->get_category_by_id($id);
	$row = $row->data;

	return $this->result(true, array(), $row);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		remove_agenda_from_meeting()
 *	Sets the agenda_path for an existing meeting row to NULL.  Deletes the file if no other rows are
 *	using that document. 
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function remove_agenda_from_meeting($id) {
	$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
	$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
	$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
	$this->db->where('rm.calendar_id', $id);
	$this->db->limit(1);
	$row = $this->db->get();
	$row = $row->row();
	$old_doc = $row->agenda_path;
	$queryStr = $this->db->last_query();

	// Get the row to get the document
	if ( isset($row->agenda_path) && !$this->resource_duplicate_uses($row->agenda_path) ) {
		unlink($this->config->item('user_res_path_rel')."/".$row->agenda_path);
		$rem_doc = $row->agenda_path;
	}

    $this->db->set('agenda_path', null);
	$this->db->where('calendar_id', $id);
	$this->db->update($this->TABLE_RES_MEETINGS);

	$query = $this->db->query($queryStr);
	$query = $query->row();
	$query->old_doc = isset($old_doc) ? $old_doc : null;
	$query->rem_doc = isset($rem_doc) ? $rem_doc : null;
	return $query;
} // end remove_agenda_from_meeting()
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		remove_minutes_from_meeting()
 *	Sets the minutes_path for an existing meeting row to NULL.  Deletes the file if no other rows are
 *	using that document.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function remove_minutes_from_meeting($id) {
	$this->db->select("ct.text, c.date, rm.*")->from($this->TABLE_RES_MEETINGS." as rm");
	$this->db->join($this->TABLE_CALENDAR." as c", "c.id=rm.calendar_id", "left");
	$this->db->join($this->TABLE_TYPES." as ct", "ct.id=c.type", "left");
	$this->db->where('rm.calendar_id', $id);
	$this->db->limit(1);
	$row = $this->db->get();
	$row = $row->row();
	$old_doc = $row->minutes_path;
	$queryStr = $this->db->last_query();

	// Get the row to get the document
	if ( isset($row->minutes_path) && !$this->resource_duplicate_uses($row->minutes_path) ) {
		unlink($this->config->item('user_res_path_rel')."/".$row->minutes_path);
		$rem_doc = $row->agenda_path;
	}

    $this->db->set('minutes_path', null);
	$this->db->where('calendar_id', $id);
	$this->db->update($this->TABLE_RES_MEETINGS);

	$query = $this->db->query($queryStr);
	$query = $query->row();
	$query->old_doc = isset($old_doc) ? $old_doc : null;
	$query->rem_doc = isset($rem_doc) ? $rem_doc : null;
	return $query;
} // end remove_minutes_from_meeting()


public function delete_category_by_id($id) {
	// See if that ID exists
	$this->db->limit(1);
	$row = $this->get_category_by_id($id);
	if ( !$row->success )
		return $this->result(false, array('Could not find row to delete with that identifier'));

	// Assign the data so we can reference the deletion
	$row = $row->data;

	// Run the delete
	$delete = $this->db->delete($this->TABLE_CATEGORIES, array('id' => $id));

	// Verify the row no longer exists
	$check_exists = $this->get_category_by_id($id);
	if ( $check_exists->success )
		return $this->result(false, array('Category deletion unsuccessful'));

	return $this->result(true, array(), $row);
}
//
// HELPERS
////////////////////////////////////////////////////////////////////////////////////////////////////////
/* 		resource_duplicate_uses()
 *	Checks whether or not the same document path is being used by two or more existing meetings.
 *	We check two or more because there will always be one, since we're using an existing row to
 *	retrieve the path data.
 *
 *  Returns false for no duplicate uses.  Returns true for duplicate uses.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function resource_duplicate_uses($path) {
	$query = $this->db->select('*')->from($this->TABLE_RES_MEETINGS)
		->group_start()
			->where('agenda_path', $path)
			->or_group_start()
				->where('minutes_path', $path)
			->group_end()
		->group_end()
	->get();

	//$query = $this->db->get_where($this->TABLE_RES_MEETINGS, array('minutes_path' => $path) );

	return $query->num_rows() > 1;
}
private function make_url_friendly($string) {
	return strtolower(str_replace(" ", "-", urlencode($string)));
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // end class
?>