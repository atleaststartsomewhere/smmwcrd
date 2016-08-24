<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class EXT_ScriptController extends CI_Controller {
	const REQUIRED = TRUE;
	const NOT_REQUIRED = FALSE;
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct() {
	parent::__construct();
	//$this->lang->load('error-messages-'.$lang_file, 'english');
	$this->config->load('smmwc');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// 		Message Handling
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function add_error($message) {
	$error_key = $this->config->item('session_messages_error');

	if ( isset($_SESSION[$error_key]) )
		array_push($_SESSION[$error_key], $message);
	else
		$_SESSION[$error_key] = array($message);
}
protected function add_success($message) {
	$success_key = $this->config->item('session_messages_success');

	if ( isset($_SESSION[$success_key]) )
		array_push($_SESSION[$success_key], $message);
	else
		$_SESSION[$success_key] = array($message);
}
protected function has_errors() {
	$error_key = $this->config->item('session_messages_error');
	if ( isset($_SESSION[$error_key]) && count($_SESSION[$error_key] > 0 ) )
		return true;

	return false;
}
protected function has_successes() {
	$success_key = $this->config->item('session_messages_success');
	if ( isset($_SESSION[$success_key]) && count($_SESSION[$success_key] > 0 ) )
		return true;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// 		Submit/Form Helping
//
////////////////////////////////////////////////////////////////////////////////////////////////////////
protected function post_values($needle, $required, $valIfTrue=NULL, $valIfFalse=NULL) {
	$haystack = $this->input->post();
	if ( isset($haystack[$needle]) && !empty($haystack[$needle]) ) {
		if ( !isset($valIfTrue) )
			$valIfTrue = $haystack[$needle];
		return $valIfTrue;
	}

	if ( $required )
		$this->add_error($this->lang->line('field_missing_'.$needle));

	return $valIfFalse;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
