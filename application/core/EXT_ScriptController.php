<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
//	
////////////////////////////////////////////////////////////////////////////////////////////////////////
class EXT_ScriptController extends CI_Controller {
////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	parent::__construct();

	$this->config->load('smmwc');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	show_404();
}
public function add_error($message) {
	$error_key = $this->config->item('session_messages_error');

	if ( isset($_SESSION[$error_key]) )
		array_push($_SESSION[$error_key], $message);
	else
		$_SESSION[$error_key] = array($message);
}
public function add_success($message) {
	$success_key = $this->config->item('session_messages_success');

	if ( isset($_SESSION[$success_key]) )
		array_push($_SESSION[$success_key], $message);
	else
		$_SESSION[$success_key] = array($message);
}
public function has_errors() {
	$error_key = $this->config->item('session_messages_error');
	if ( isset($_SESSION[$error_key]) && count($_SESSION[$error_key] > 0 ) )
		return true;

	return false;
}
public function has_successes() {
	$success_key = $this->config->item('session_messages_success');
	if ( isset($_SESSION[$success_key]) && count($_SESSION[$success_key] > 0 ) )
		return true;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
