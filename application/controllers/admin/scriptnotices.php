<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once(APPPATH.'core/EXT_ScriptController'.EXT);
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptnotices extends EXT_ScriptController {
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
	$this->load->model('Notice');
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
	$heading = (!isset($_POST['heading']) || empty($_POST['heading'])) ? NULL : $_POST['heading'];
	$notice_type = $_POST['notice_type'];
	$id = (!isset($_POST['id']) || empty($_POST['id'])) ? NULL : $_POST['id'];
	$date = (!isset($_POST['date']) || empty($_POST['date'])) ? date('Y-m-d') : date('Y-m-d', strtotime($_POST['date']));

	// Validate Required Items
	if ( !isset($heading) )
		$this->add_error('You must choose a heading for your notice.');

	// Return to original page if the required items are not set
	if ( $this->has_errors() ) {
		$postpend = (!isset($id)) ? '' : '/'.$id;
		redirect('admin/notices/entry'.$postpend);
	}

	$message = (!isset($_POST['message']) || empty($_POST['message'])) ? NULL : $_POST['message'];
	$resource = (!isset($_POST['resource']) || empty($_POST['resource'])) ? NULL : $_POST['resource'];
	$delete = (!isset($_POST['delete']) || empty($_POST['delete'])) ? FALSE : TRUE;

	// Are we just deleting as part of this update?
	if ( $delete && isset($id) ) {
		$this->delete_notice($id);
		redirect('admin/notices/all');
	}

	// Assemble the Package
	$package = array(
		'heading_text' => $heading,
		'body_text' => $message,
		'type_id' => $notice_type,
		'add_date' => date('Y-m-d'),
		'notice_date' => $date,
		'resource_id' => $resource,
		'order' => 0

	);
	// Update entry if ID is set
	if ( isset($id) ) {
		$this->update_notice($id, $package);
		redirect('admin/notices/all');
	} 
	// ELSE: We are creating a new row, so make an insert call
	else {
		$this->create_notice($package);
		redirect('admin/notices/all');		
	}

} // end update()
public function manage() {
	$removals 	= (isset($_POST['remove'])) ? $_POST['remove'] : NULL;
	$ids 		= (isset($_POST['ids'])) ? $_POST['ids'] : NULL;

	// Run removals
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $id => $removal ) {
			$this->delete_notice($id);
			unset($ids[$id]);
		}
	}
	// Run updates
	if ( isset($ids) && count($ids) > 0 ) {
		$order = 1;
		foreach ( $ids as $id ) {
			$package = array('order' => $order);
			$this->update_notice($id, $package, TRUE);
			$order++;
		}
		$this->add_success('All notices saved.');
	}

	redirect('admin/notices/all');
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
private function create_notice($package) {
	$query = $this->Notice->create($package);
	if ( !$query->success ) {
		$this->add_error('Could not add your notice.  '
			.'Please try again later or contact your system administrator if this problem persists');
		return;
	}

	$row = $query->data;

	$this->add_success('Successfully created <b>'
		.date('F jS, Y', strtotime($row->notice_date))
		.'</b> notice: '
		.'<b>&quot;'.$row->heading_text.'&quot;</b>'
	);
}

private function update_notice($id, $package, $suppress=FALSE) {
	$query = $this->Notice->update($id, $package);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error("Could not update your notice.  "
				."Please try again later or contact your system administrator if this problem persists.");
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully updated <b>'
			.date('F jS, Y', strtotime($row->notice_date))
			.'</b> notice: '
			.'<b>&quot;'.$row->heading_text.'&quot;</b>'
		);
	}
}

private function delete_notice($id, $suppress=FALSE) {
	$query = $this->Notice->delete_by_id($id);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error('Could not delete this notice.');
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully deleted <b>'
			.date('F jS, Y', strtotime($row->notice_date))
			.'</b> notice: '
			.'<b>&quot;'.$row->heading_text.'&quot;</b>'
		);
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
