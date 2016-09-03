<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptintroparagraph extends EXT_ScriptController {
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
	$this->load->model('Content');
}
public function index() {
		/*$username = 'testuser';
		$password = 'testuser';
		$email = 'testuser';
		$additional_data = array(
								'first_name' => 'Test',
								'last_name' => 'User',
								);
		$group = array('1'); // Sets user to admin.

		$this->ion_auth->register($username, $password, $email, $additional_data, $group);*/
	
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
** 	Takes multiple inputs of date IDs with boolean removal, new types and dates - as well as the current
** 	month and year.
**
**	We loop through all ids and test for whether or not the remove checkbox was on, and then we scrub
**	the ID from the array of IDs to update with new dates/types ID after we remove the row from the 
**	database.
*/
//------------------------------------------------------------------------------------------------------
public function update() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;

	// Critical Validation
	if ( !isset($_POST['paragraph']) || empty($_POST['paragraph']) ) {
		$this->add_error('Error: Must input text to display on the home page.');
		redirect('admin/intro-paragraph');
	}

	$paragraph = $_POST['paragraph'];

	if ( $this->has_errors() )
		redirect('admin/intro-paragraph');

	// Everything's checked, update the URL
	$this->update_paragraph($paragraph);
	redirect('admin/intro-paragraph');

} // end update()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//			update_paragraph($text)
//
//
//======================================================================================================
/*
**	update_paragraph()
**
** 	Checks in case the introductory_text key is missing from the database, then sees if there were any 
**	changes	between the user-submitted data and the data inside the database.
**
**	Continues with the update if changes were made, otherwise terminates and notifies the user no changes
**	were made.
*/
//------------------------------------------------------------------------------------------------------
private function update_paragraph($text) {
	$newText = trim($text);
	// Check if there's any changes.
	$check_query = $this->Content->get_item_by_key('introductory_text', false);
	if ( !$check_query->success ) {
		$this->add_error('Critical Error: Missing critical data in the content database.'
			.'Please contact your system administrator.');
		return;
	}
	$oldText = $check_query->data['introductory_text'];
	if ( $oldText == $newText ) { // No changes were made, terminate
		$this->add_success('No Changes Were Made');
		return;
	}

	// Changes Were Made, Begin Update
	$query = $this->Content->update_item('introductory_text', $newText);

	if ( !$query->success ) {
		$this->add_error("Error: Unable to update the paragraph text");
		return;
	}

	$this->add_success('Updated the <b>Introduction Paragraph</b> successfully.');
} // END update_paragraph()
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
