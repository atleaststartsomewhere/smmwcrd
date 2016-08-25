<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptsuperadmin extends EXT_ScriptController {
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
	$this->load->model('Config');
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
public function update() {
	/* DEBUG: */	//echo "<pre>";var_dump($_POST);echo "</pre>";return;
	$maintenance = isset($_POST['maintenance']) ? TRUE : FALSE;
	
	$this->set_maintenance($maintenance);
	
	redirect('admin/superadmin');

} // end update()
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
private function set_maintenance($mode=FALSE) {
	$query = $this->Config->set_config('maintenance', NULL, $mode);

	if ( !$query->success ) {
		$this->add_error('Could not update maintenance mode.');
		return;
	}

	$row = $query->data;
	$this->add_success('Successfully updated maintenance mode to: '
		.'Text: <b>&lt;</b>'.$row->setting_text.'<b>&gt;</b> '
		.'Bool: <b>&lt;</b>'.$row->setting_boolean.'<b>&gt;</b> '
	);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
