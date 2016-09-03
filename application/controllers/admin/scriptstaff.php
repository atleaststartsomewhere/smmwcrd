<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptstaff extends EXT_ScriptController {
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
	$this->load->model('BoardStaff');
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
	$name = (!isset($_POST['name']) || empty($_POST['name'])) ? NULL : $_POST['name'];
	$title = (!isset($_POST['title']) || empty($_POST['title'])) ? NULL : $_POST['title'];
	$id = (!isset($_POST['id']) || empty($_POST['id'])) ? NULL : $_POST['id'];
	$delete = (!isset($_POST['delete']) || empty($_POST['delete'])) ? FALSE : TRUE;

	// Validate Required Items
	if ( !isset($name) )
		$this->add_error('You must enter a name for the staff member.');
	if ( !isset($title) )
		$this->add_error('You must enter a title for the staff member.');

	// Return to original page if the required items are not set
	if ( $this->has_errors() ) {
		$postpend = (!isset($id)) ? '' : '/'.$id;
		redirect('admin/staff/member'.$postpend);
	}

	// Are we just deleting as part of this update?
	if ( $delete && isset($id) ) {
		$this->delete_member($id);
		redirect('admin/staff/all');
	}

	// Assemble the Package
	$package = array(
		'name' => $name,
		'title' => $title
	);
	// Update entry if ID is set
	if ( isset($id) ) {
		$this->update_member($id, $package);
		redirect('admin/staff/all');
	} 
	// ELSE: We are creating a new row, so make an insert call
	else {
		$this->create_member($package);
		redirect('admin/staff/all');		
	}

} // end update()
public function manage() {
	$removals 	= (isset($_POST['remove'])) ? $_POST['remove'] : NULL;
	$ids 		= (isset($_POST['ids'])) ? $_POST['ids'] : NULL;

	// Run removals
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $id => $removal ) {
			$this->delete_member($id);
			unset($ids[$id]);
		}
	}
	// Run updates
	if ( isset($ids) && count($ids) > 0 ) {
		$order = 1;
		foreach ( $ids as $id ) {
			$package = array('order' => $order);
			$this->update_member($id, $package, TRUE);
			$order++;
		}
		$this->add_success('Staff list saved.');
	}

	redirect('admin/staff/all');
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
private function create_member($package) {
	$query = $this->BoardStaff->create_staff_member($package);
	if ( !$query->success ) {
		$this->add_error('Could not add the staff member.  '
			.'Please try again later or contact your system administrator if this problem persists');
		return;
	}

	$row = $query->data;

	$this->add_success('Successfully added <b>'
		.$row->name
		.'</b> to the Staff list.'
	);
}

private function update_member($id, $package, $suppress=FALSE) {
	$query = $this->BoardStaff->update_staff_member($id, $package);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error("Could not update the staff member.  "
				."Please try again later or contact your system administrator if this problem persists.");
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully updated <b>'
			.$row->name
			.'</b> on the Staff list.'
		);
	}
}

private function delete_member($id, $suppress=FALSE) {
	$query = $this->BoardStaff->delete_staff_member_by_id($id);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error('Could not delete this staff member.');
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully deleted <b>'
			.$row->name
			.'</b> from the Staff list.'
		);
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
