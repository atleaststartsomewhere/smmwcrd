<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
	/* DEBUG: */ echo "<pre>";var_dump($_POST);echo "</pre>";return;
	$removals 	= (isset($_POST['remove'])) ? $_POST['remove'] : NULL;
	$ids 		= (isset($_POST['ids'])) ? $_POST['ids'] : NULL;
	$cats 		= (isset($_POST['category'])) ? $_POST['category'] : NULL;
	$featured	= (isset($_POST['featured'])) ? $_POST['featured'] : NULL;
	$sorting	= (isset($_POST['sorting'])) ? $_POST['sorting'] : NULL;

	// Run removals
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $id => $removal ) {
			$this->delete_resource($id);
			unset($ids[$id]);
		}
	}
	// Run updates
	if ( isset($ids) && count($ids) > 0 ) {
		$order = 1;
		foreach ( $ids as $id ) { 
			$package = array(
				'category_id' => $cats[$id],
				'featured' => isset($featured[$id]) ? TRUE : FALSE
			);
			if ( isset($sorting) )
				$package['order'] = $order;
			$this->update_resources($id, $package, $category_name, TRUE);
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
private function update_resources($id, $package, $category_name, $suppress=FALSE) {
	$featured_table_batch = array();
	if ( $category_name == "Featured" ) {
		// Change categories as normal
		// Reorder in the featured table
	}

	// Check for Featured
	if ( isset($package['featured']) && $package['featured'] ) {
		$query_featured = $this->Resource->set_featured($id);
		if ( $query_featured->success && !$suppress )
			$this->add_success('Added '.$query_featured->data->display_name.' to featured documents.');
	}

	$query = $this->Resource->update_resource($id, $package);
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