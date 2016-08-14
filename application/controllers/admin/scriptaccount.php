<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////
class Scriptaccount extends EXT_ScriptController {
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
	$this->load->library('ion_auth');
	$this->load->library('form_validation');
	$this->lang->load('auth');
	$this->load->helper('language');

	// Post-Loader Setup
	$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
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
**	Most of this was taken from Ion Auth's auth controller.  Certain updates include using the error and
**	success messages system the rest of the site uses and correct routing after the password is 
**	validated and fails, or validated and updated.
*/
//------------------------------------------------------------------------------------------------------
public function update() {
	/* DEBUG */ 	//echo "<pre>";var_dump($_POST);echo "</pre>";return;

	$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
	$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
	$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

	// Is the user even logged in?
	if (!$this->ion_auth->logged_in()) 	{
		redirect('auth/login', 'refresh');
	}

	// User is logged in, proceed
	$user = $this->ion_auth->user()->row();

	if ($this->form_validation->run() == false)
	{		
		$generated_errors = explode(".",
								preg_replace('#(\\\r|\\\r\\\n|\\\n)#', '',
									trim(
										strip_tags(
											validation_errors()
										)
									)
								)
							);
		foreach( $generated_errors as $e ) {
			if ( !empty($e) )
				$this->add_error($e);
		}			

		$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
		$this->data['old_password'] = array(
			'name' => 'old',
			'id'   => 'old',
			'type' => 'password',
		);
		$this->data['new_password'] = array(
			'name' => 'new',
			'id'   => 'new',
			'type' => 'password',
			'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
		);
		$this->data['new_password_confirm'] = array(
			'name' => 'new_confirm',
			'id'   => 'new_confirm',
			'type' => 'password',
			'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
		);
		$this->data['user_id'] = array(
			'name'  => 'user_id',
			'id'    => 'user_id',
			'type'  => 'hidden',
			'value' => $user->id,
		);

		redirect('admin/account');
	}
	else
	{
		$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

		$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

		if ($change)
		{
			//if the password was successfully changed
			//$this->session->set_flashdata('successes', $this->ion_auth->messages());
			$this->add_success('Password updated successfully');
			redirect('admin/account');
		}
		else
		{
			//$this->session->set_flashdata('errors', $this->ion_auth->errors());
			$this->add_error('Unable to update your password at this time. '
				.'Please check that you entered your old password correctly and '
				.' contact your system administrator if this problem persists.');
			redirect('admin/account');
		}
	}

} // end update()
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//		HELPER FUNCTIONS (private helpers)
//			function($defaults=null)
//
//
//======================================================================================================
/*
**	function()
**
** 	Description
*/
//------------------------------------------------------------------------------------------------------

////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
