<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptbillpay extends EXT_ScriptController {
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
	if ( !isset($_POST['paybill_link']) || empty($_POST['paybill_link']) ) {
		$this->add_error('Error: Must supply a link to the external site.');
		redirect('admin/billpay');
	}

	$url = $_POST['paybill_link'];
	$regex = "/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/";
	$result = preg_match($regex, $url);

	// Non-Critical Validation
	if ( !$result )  // Not a valid URL
		$this->add_error('Error: Must supply a valid url.  Example: http://www.smmwc.com/meetings');

	if ( $this->has_errors() )
		redirect('admin/billpay');

	// Everything's checked, update the URL
	$this->update_billpay_url($url);
	redirect('admin/billpay');

} // end update()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//			update_billpay_url($url='')
//
//
//======================================================================================================
/*
**	update_billpay_url()
**
** 	Checks in case the paybill_link key is missing from the database, then sees if there were any changes
**	between the user-submitted data and the data inside the database.
**
**	Continues with the update if changes were made, otherwise terminates and notifies the user no changes
**	were made.
*/
//------------------------------------------------------------------------------------------------------
private function update_billpay_url($url) {
	$newUrl = trim($url);
	// Check if there's any changes.
	$check_query = $this->Content->get_item_by_key('paybill_link');
	if ( !$check_query->success ) {
		$this->add_error('Critical Error: Missing critical data in the content database.'
			.'Please contact your system administrator.');
		return;
	}
	$oldUrl = $check_query->data['paybill_link'];
	if ( $oldUrl == $newUrl ) { // No changes were made, terminate
		$this->add_success('No Changes Were Made');
		return;
	}

	// Changes Were Made, Begin Update
	$query = $this->Content->update_item('paybill_link', $newUrl);

	if ( !$query->success ) {
		$this->add_error("Error: Unable to update the bill-pay link");
		return;
	}

	$this->add_success('Updated <b>External Bill Pay Link</b> to <b>'.$newUrl.'</b>');
} // END update_billpay_url()
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
