<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptresources extends EXT_ScriptController {
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
}

public function apply_filters( ) {
	/* DEBUG: */ //echo "<pre>";var_dump($_POST);echo "</pre>";return;

	$category = (isset($_POST['category_filter']) ? (!empty($_POST['category_filter']) ? $_POST['category_filter'] : NULL) : NULL);
	$date = (isset($_POST['date_filter']) ? (!empty($_POST['date_filter']) ? $_POST['date_filter'] : NULL) : NULL);


	if ( isset($date) ) {
		$_SESSION['admin_uri_resources_filter_date'] = '/date/'.date('Y-m-d', strtotime($date));
	} 
	if ( isset($category) ) {
		$_SESSION['admin_uri_resources_filter_category'] = '/category/'.$category;
	}

	redirect(
		'admin/resources'
		.$_SESSION['admin_uri_resources_filter_date']
		.$_SESSION['admin_uri_resources_filter_category']
	);
}

public function remove_filters( ) {
	$_SESSION['admin_uri_resources_filter_date'] = $_SESSION['admin_uri_resources_filter_category'] = '';
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

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
