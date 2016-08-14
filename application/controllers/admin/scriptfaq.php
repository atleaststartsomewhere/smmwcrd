<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptfaq extends EXT_ScriptController {
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
	$this->load->model('Faq');
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
	$question = (!isset($_POST['question']) || empty($_POST['question'])) ? NULL : $_POST['question'];
	$answer = (!isset($_POST['answer']) || empty($_POST['answer'])) ? NULL : $_POST['answer'];
	$id = (!isset($_POST['id']) || empty($_POST['id'])) ? NULL : $_POST['id'];
	$delete = (!isset($_POST['delete']) || empty($_POST['delete'])) ? FALSE : TRUE;

	// Validate Required Items
	if ( !isset($question) )
		$this->add_error('You must enter a valid question.');
	if ( !isset($answer) )
		$this->add_error('You must enter a valid answer.');

	// Return to original page if the required items are not set
	if ( $this->has_errors() ) {
		$postpend = (!isset($id)) ? '' : '/'.$id;
		redirect('admin/faq/entry'.$postpend);
	}

	// Are we just deleting as part of this update?
	if ( $delete && isset($id) ) {
		$this->delete_faq($id);
		redirect('admin/faq/all');
	}

	// Assemble the Package
	$package = array(
		'question' => $question,
		'answer' => $answer
	);
	// Update entry if ID is set
	if ( isset($id) ) {
		$this->update_faq($id, $package);
		redirect('admin/faq/all');
	} 
	// ELSE: We are creating a new row, so make an insert call
	else {
		$this->create_faq($package);
		redirect('admin/faq/all');		
	}

} // end update()
public function manage() {
	$removals 	= (isset($_POST['remove'])) ? $_POST['remove'] : NULL;
	$ids 		= (isset($_POST['ids'])) ? $_POST['ids'] : NULL;

	// Run removals
	if ( isset($removals) && count($removals) > 0 ) {
		foreach ( $removals as $id => $removal ) {
			$this->delete_faq($id);
			unset($ids[$id]);
		}
	}
	// Run updates
	if ( isset($ids) && count($ids) > 0 ) {
		$order = 1;
		foreach ( $ids as $id ) {
			$package = array('order' => $order);
			$this->update_faq($id, $package, TRUE);
			$order++;
		}
		$this->add_success('FAQ list saved.');
	}

	redirect('admin/faq/all');
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
private function create_faq($package) {
	$query = $this->Faq->create_faq($package);
	if ( !$query->success ) {
		$this->add_error('Could not add the FAQ.  '
			.'Please try again later or contact your system administrator if this problem persists');
		return;
	}

	$row = $query->data;

	$this->add_success('Successfully added the FAQ: <b>'
		.$row->question
		.'</b> to the FAQ list.'
	);
}

private function update_faq($id, $package, $suppress=FALSE) {
	$query = $this->Faq->update_faq($id, $package);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error("Could not update the FAQ.  "
				."Please try again later or contact your system administrator if this problem persists.");
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully updated the FAQ: <b>'
			.$row->question
			.'</b> on the FAQ list.'
		);
	}
}

private function delete_faq($id, $suppress=FALSE) {
	$query = $this->Faq->delete_faq_by_id($id);
	if ( !$query->success ) {
		if ( !$suppress ) {
			$this->add_error('Could not delete this FAQ.');
			return;
		}
	}

	$row = $query->data;

	if ( !$suppress ) {
		$this->add_success('Successfully deleted <b>'
			.$row->question
			.'</b> from the FAQ list.'
		);
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
