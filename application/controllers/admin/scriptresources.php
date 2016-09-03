<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptresources extends EXT_ScriptController {
//		Inherited Methods:
//			add_error( string ) void 		appends an error message to SESSION
//			add_success( string ) void 		appends a success message to SESSION
//			has_errors( ) boolean 			checks whether or not errors are saved in SESSION
private $is_link = TRUE;
private $is_document = FALSE;
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
//
//======================================================================================================
/*
**
*/
//------------------------------------------------------------------------------------------------------
public function manage() {
/*
array(5) {
  ["category"]=>
  array(5) {
    [5]=>
    string(1) "2"
    [8]=>
    string(1) "5"
    [9]=>
    string(1) "3"
    [12]=>
    string(1) "4"
    [14]=>
    string(1) "5"
  }
  ["ids"]=>
  array(5) {
    [5]=>
    string(1) "5"
    [8]=>
    string(1) "8"
    [9]=>
    string(1) "9"
    [12]=>
    string(2) "12"
    [14]=>
    string(2) "14"
  }
  ["remove"]=>
  array(1) {
    [8]=>
    string(2) "on"
  }
  ["feature"]=>
  array(1) {
    [9]=>
    string(2) "on"
  }
  ["category_name"]=>
  string(6) "Recent"
}
*/
	/* DEBUG: */ //echo "<pre>";var_dump($_POST);echo "</pre>";return;
	$removals 	= (isset($_POST['remove'])) ? $_POST['remove'] : NULL;
	$ids 		= (isset($_POST['ids'])) ? $_POST['ids'] : NULL;
	$cats 		= (isset($_POST['category'])) ? $_POST['category'] : NULL;
	$featured	= (isset($_POST['feature'])) ? $_POST['feature'] : NULL;
	$sorting	= (isset($_POST['sorting'])) ? $_POST['sorting'] : NULL;

	// Run removals
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $id => $removal ) {
			$this->delete_resource($id);
			unset($ids[$id]);
		}
	}
	// Run updates
	//($id, $path=NULL, $display_name=NULL, $is_link=NULL, $date_added=NULL, 
	//  $order=NULL, $is_featured=NULL, $category_id=NULL)
	if ( isset($ids) && count($ids) > 0 ) {
		$order = 1;
		foreach ( $ids as $id ) { 
			// id, path, display_name, is_link
			$this->update_resources($id, NULL, NULL, NULL, 
			// date_added, order, is_featured
				NULL, isset($sorting) ? $order : NULL, isset($featured[$id]) ? TRUE : FALSE, 
			// category_id, SUPPRESS OUTPUT
				$cats[$id], TRUE
			);
			$order++;
		}
		$this->add_success('Resources saved.');
	}

	redirect('admin/resources');
}
public function add() {
	/* DEBUG: */ //echo "<pre>";var_dump($_POST);echo "</pre>";return;
	$item_name = 'resource_file';
	$category = (isset($_POST['category']) ? (!empty($_POST['category']) ? $_POST['category'] : NULL) : NULL);
	$name = (isset($_POST['name']) ? (!empty($_POST['name']) ? $_POST['name'] : NULL) : NULL);

	if ( !isset($name) )
		$this->add_error('Please enter a value for the <b>Display Name</b>');

	if ( $this->has_errors() )
		redirect('admin/add-resource');

	if ( $this->do_upload($item_name) ) {
		$path = $this->upload->data()['client_name'];
		$resource = $this->Resource->add_resource($category, $path, $name, $this->is_document);
		if ( !$resource->success ) {
			$this->add_error('Could not add your file to resources. Please try again later or contact your system administrator if this problem persists.');
			redirect('admin/resources');
		}

		$resource = $resource->data;
		$this->add_success('Added File to <b>'
			.$resource->category_name.'</b>'
			."(".$this->upload->data()['client_name'].")"
		);
	}		

	redirect('admin/resources');
}

public function add_link() {
	/* DEBUG: */ //echo "<pre>";var_dump($_POST);echo "</pre>";return;	

	$category = (isset($_POST['category']) ? (!empty($_POST['category']) ? $_POST['category'] : NULL) : NULL);
	$link = (isset($_POST['url']) ? (!empty($_POST['url']) ? $_POST['url'] : NULL) : NULL);
	$name = (isset($_POST['name']) ? (!empty($_POST['name']) ? $_POST['name'] : NULL) : NULL);
	
	if ( !isset($category) )
		$this->add_error('Please select a valid <b>Category</b>.');
	if ( !isset($link) )
		$this->add_error('Please enter a value for the <b>Link Address</b>');
	if ( !isset($name) )
		$this->add_error('Please enter a value for the <b>Display Name</b>');

	if ( $this->has_errors() )
		redirect('admin/add-resource-link');

	$this->Resource->add_resource($category, $link, $name, $this->is_link);

	redirect('admin/resources');
}
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
private function do_upload($item_name) {	
	$this->load->config('smmwc');

	$config['upload_path']          = $this->config->item('user_res_path_rel');
	$config['allowed_types']        = $this->config->item('res_allowed_types');
	$config['max_size']             = $this->config->item('res_max_size');
	$config['overwrite']            = $this->config->item('res_overwrite');

	$this->load->library('upload', $config);

	$errors = "";
	if ( !$this->upload->do_upload($item_name) ) {
		return false;		
	} else {
		return true;
	}
} // END do_upload()

private function update_resources($id, $path=NULL, $display_name=NULL, $is_link=NULL, $date_added=NULL, $order=NULL, $is_featured=NULL, $category_id=NULL, $suppress=FALSE) {
	$query = $this->Resource->update_resource($id, $path, $display_name, $is_link, $date_added, $order, $is_featured, $category_id);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error("Could not update resources.  "
				."Please try again later or contact your system administrator if this problem persists.");
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully updated the Resource: <b>'
			.$row->display_name
			.'</b>'
		);
	}
} // END update_resources()
private function delete_resource($id, $suppress=FALSE) {
	$query = $this->Resource->delete_resource_by_id($id);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error('Could not delete this resource.');
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully deleted <b>'
			.$row->display_name
			.'</b> from resources.'
		);
	}
} // END delete_resource()
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS