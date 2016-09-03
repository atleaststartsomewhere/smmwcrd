<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptrescategories extends EXT_ScriptController {
//		Inherited Methods:
//			add_error( string ) void 		appends an error message to SESSION
//			add_success( string ) void 		appends a success message to SESSION
//			has_errors( ) boolean 			checks whether or not errors are saved in SESSION
//			has_successes( ) boolean 		checks whether or not successes are saved in SESSION
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
	$this->load->model('Resource');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		ACTION FUNCTIONS (Route Accessible)
//
//======================================================================================================
/*
**
*/
//------------------------------------------------------------------------------------------------------
public function manage() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;
/*
array(3) {
  ["update_names"]=>
  array(5) {
    [2]=>
    string(0) ""
    [3]=>
    string(0) ""
    [4]=>
    string(0) ""
    [5]=>
    string(0) ""
    [1]=>
    string(0) ""
  }
  ["ids"]=>
  array(5) {
    [2]=>
    string(1) "2"
    [3]=>
    string(1) "3"
    [4]=>
    string(1) "4"
    [5]=>
    string(1) "5"
    [1]=>
    string(1) "1"
  }
  ["remove"]=>
  array(1) {
    [3]=>
    string(2) "on"
  }
  ["new_cat"]=>
  array(1) {
    [0]=>
    string(0) ""
  }
}
*/
	$removals 		= (isset($_POST['remove'])) ? $_POST['remove'] : array();
	$ids 			= (isset($_POST['ids'])) ? $_POST['ids'] : array();
	$new_cat		= (isset($_POST['new_cat'])) ? $_POST['new_cat'] : NULL;
	$update_names	= (isset($_POST['update_names'])) ? $_POST['update_names'] : array();
	// Check for removals
	foreach ( $removals as $id => $remove ) {
		$this->delete_category($id);
		unset($ids[$id]);
	}
	// Check for new categories
	if ( isset($new_cat) && !empty($new_cat) ) {
		$new_id = $this->create_category($new_cat);
		array_push($ids, $new_id);
	}
	// Update names and order of categories
	if ( count($ids) > 0 ) {
		$count = 1;
		foreach ( $ids as $id ) {
			$package = array(
				'order' => $count,
				'category_name' => (!empty($update_names[$id])) ? $update_names[$id] : NULL
			);
			$this->update_category($id, $package, TRUE);
			$count++;
		}
		$this->add_success('Category sort order updated.');
	}

	if ( !$this->has_successes() )
		$this->add_success('No changes made.');
	redirect('admin/resources-categories');

} // end manage()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//
//
//======================================================================================================
/*
**
*/
//------------------------------------------------------------------------------------------------------
private function create_category($category_name) {
	$query = $this->Resource->create_category($category_name);

	if ( !$query->success ) {
		$this->add_error('Could not create the resource category.  '
			.'Please try again later or contact your system administrator if this problem persists.');
		return false;
	}

	$row = $query->data;
	$this->add_success('Successfully created resource category: <b>'
		.$row->category_name
		.'</b>'
	);

	return $row->id;
}
private function update_category($id, $package, $suppress=FALSE) {
	$query = $this->Resource->update_category_by_id($id, $package);

	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error('Could not update the resource category.  '
				.'Please try again later or contact your system administrator if this problem persists.');
		}
		return false;
	}

	$row = $query->data;
	if ( !$suppress ) {
		$this->add_success('Successfully updated resource category: <b>'
			.$row->category_name
			.'</b>'
		);
	}
	return true;
}
private function delete_category($id) {
	$query = $this->Resource->delete_category_by_id($id);

	if ( !$query->success ) {
		$this->add_error('Could not delete the resource category.  '
			.'Please try again later or contact your system administrator if this problem persists.');
		return false;
	}

	$row = $query->data;
	$this->add_success('Successfully deleted resource category: <b>'
		.$row->category_name
		.'</b>'
	);
	return true;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
