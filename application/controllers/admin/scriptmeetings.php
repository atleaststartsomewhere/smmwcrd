<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptmeetings extends EXT_ScriptController {
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
	$this->load->model('Resource');
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

	$ids = ($_POST['ids']);
	$agenda_removals = isset($_POST['remove_agenda']) ? $_POST['remove_agenda'] : array();
	$minutes_removals = isset($_POST['remove_minutes']) ? $_POST['remove_minutes'] : array();
	
	foreach ( $ids as $id ) {
		
		$minutes_item = "file_minutes_".$id;

		// AGENDA HANDLING
		$agenda_item = "file_agenda_".$id;
		if ( isset($agenda_removals[$id]) ) // marked to remove agenda
			$this->remove_agenda($id);
		else
			$this->add_agenda($agenda_item, $id);

		// MINUTES HANDLING
		if ( isset($minutes_removals[$id]) ) // marked to remove minutes
			$this->remove_minutes($id);
		else
			$this->add_minutes($minutes_item, $id);
	}


	// We want to scrub out nil choices for file uploads
	$errors = str_replace("<span>You did not select a file to upload.</span><br />", "", $this->upload->display_errors('<span>', '</span><br />'));
	if ( !empty($errors) )
		$this->add_error($errors);

	redirect('admin/meetings-resources/'.$_SESSION['last_resource_page']);


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
**	do_upload()
**
*/
//------------------------------------------------------------------------------------------------------
private function do_upload($item_name, $meeting_id) {	
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
private function add_agenda($item_name, $meeting_id) {
	if ( $this->do_upload($item_name, $meeting_id) ) {
		$file_name = $this->upload->data()['client_name'];
		$updated_row = $this->Resource->add_agenda_to_meeting($file_name, $meeting_id);
		$this->add_success('Added Agenda to <b>'
			.date('F jS, Y', strtotime($updated_row->date))." "
			.$updated_row->text.'</b>'
			."(".$this->upload->data()['client_name'].")"
		);
	}		
}
private function add_minutes($item_name, $meeting_id) {
	if ( $this->do_upload($item_name, $meeting_id) ) {
		$file_name = $this->upload->data()['client_name'];
		$updated_row = $this->Resource->add_minutes_to_meeting($file_name, $meeting_id);
		$this->add_success('Added Minutes to <b>'
			.date('F jS, Y', strtotime($updated_row->date))." "
			.$updated_row->text.'</b>'
			."(".$this->upload->data()['client_name'].")"
		);
	}
}
private function remove_agenda($id) {
	$old_doc = $this->Resource->remove_agenda_from_meeting($id);
	if ( isset($old_doc->rem_doc) )
		$this->add_error('Removed UNUSED document: '.$old_doc->rem_doc);

	$this->add_success('Removed document: <b>'
		.$old_doc->old_doc
		.'</b> from meeting: <b>'
		.date('F jS, Y', strtotime($old_doc->date))
		.' '.$old_doc->text.'</b>'
	);
}
private function remove_minutes($id) {
	$old_doc = $this->Resource->remove_minutes_from_meeting($id);
	if ( isset($old_doc->rem_doc) )
		$this->add_error('Deleted UNUSED document: '.$old_doc->rem_doc);

	$this->add_success('Removed document: <b>'
		.$old_doc->old_doc
		.'</b> from meeting: <b>'
		.date('F jS, Y', strtotime($old_doc->date))
		.' '.$old_doc->text.'</b>'
	);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
