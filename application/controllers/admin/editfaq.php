	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
class Editfaq extends EXT_AdminController {

////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct( )
{
	$title = 'San Miguelito Mutual Water Company';
	$heading = 'Frequently Asked Questions';
	$description = 'Add to and manage the Frequently Asked Questions';
	$page = 'faq';
	$help = 'help-faq';
	$scripts = array('scriptfaq');

	parent::__construct($title, $heading, $description, $page, $help, $scripts);
	$ci =& get_instance();
	// Load things with $ci->load here
	$ci->load->model('Faq');
	$ci->load->helper('form');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
public function index() {
	// Run variable assignment here

	// Set up the variables into array keys for the view to use
	$this->add_page_data();
	$this->render_page();
}
public function entry() {
	$this->my_page = 'faq-entry';
	$this->my_heading = 'FAQ: Add Question and Answer';
	$this->my_description = 'Add a frequently asked question to the site.';
	$this->my_help = 'help-faq-entry';
	$faq_num = $this->uri->segment(4,0);

	// Determine whether or not we're working on an entry or creating a new one
	$create = $faq_num ? false : true;
	if ( !$create ) {
		$faq = $this->get_faq($faq_num);

		if ( !$faq )
			$create = true;
		else {
			$this->my_heading = 'FAQ: Edit Frequently Asked Question';
			$this->my_description = 'Editing an FAQ Question and Answer.';
			$question = $faq->question;
			$answer = $faq->answer;
		}
	}

	// Set up the page data
	$this->add_page_data(array(
		'create' => $create,
		'question' => isset($question) ? $question : "",
		'answer' => isset($answer) ? $answer : "",
		'id' => isset($faq_num) ? $faq_num : "",
		'faqs' => $this->get_faqs()
	));

	// Render the page
	$this->render_page();
} // end entry()
public function all() {
	$this->my_page = 'faq-all';
	$this->my_heading = 'FAQ: Manage';
	$this->my_description = 'Sort and manage the Frequently Asked Questions.';
	$this->my_help = 'help-faq-all';

	$this->add_page_data(array(
		'faqs' => $this->get_faqs()
	));

	$this->render_page();	
} // end manage()
////////////////////////////////////////////////////////////////////////////////////////////////////////
// Widget Render Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Helper Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////
private function get_faq($id) {
	$query = $this->Faq->get_faq_by_id($id);

	if ( $query->success )
		return $query->data;

	return false;
}
private function get_faqs() {
	$query = $this->Faq->get_faqs();

	if ( $query->success )
		return $query->data;

	return false;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
} // END OF CLASS
