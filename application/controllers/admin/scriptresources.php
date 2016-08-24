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
	/* DEBUG: */ //echo "<pre>";var_dump($_POST);echo "</pre>";return;
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

	$this->Resource->add_resource($this->is_link, $category, $link);

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
