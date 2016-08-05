<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptboardstaff extends EXT_ScriptController {
//		Inherited Methods:
//			add_error( string ) void 		appends an error message to SESSION
//			add_success( string ) void 		appends a success message to SESSION
//			has_errors( ) boolean 			checks whether or not errors are saved in SESSION
protected $my_uploads = array();
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
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		ACTION FUNCTIONS (Route Accessible)
//			update
//
//======================================================================================================
/*
**	update()
**	
** 	Adds or removes documents from meetings
*/
//------------------------------------------------------------------------------------------------------
public function update() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;


} // end update()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//
//
//======================================================================================================
/*
**	do_upload()
**
*/
//------------------------------------------------------------------------------------------------------

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
