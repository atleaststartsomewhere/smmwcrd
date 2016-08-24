<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>

<h3 class="uk-accordion-title">Changing Calendar Months</h3>
<div class="uk-accordion-content">
	<dl class="uk-description-list-horizontal">
		<dt>Step One</dt>
		<dd>Navigate to the top of the page.</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step Two</dt>
		<dd>Select a month and year from the top-most drop-downs.</dd>
		<dd><span class="uk-text-bold">Example:</span><span class="uk-form"><select class="uk-form-large uk-text-primary"><option><?php echo date('F'); ?></option></select><select class="uk-form-large uk-text-primary"><option><?php echo date('Y'); ?></option></select></span></dd>
		<dd><span class="uk-text-bold">Note:</span> By default, the current month and year are selected.</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step Three</dt>
		<dd>Click the <button class="uk-button uk-button-link uk-button-mini">GO <i class="uk-icon uk-icon-arrow-circle-o-right"></i></button> button.</dd>
	</dl>
</div>

<h3 class="uk-accordion-title">Updating Calendar Events</h3>
<div class="uk-accordion-content">
	<dl class="uk-description-list-horizontal">
		<dt>PREFACE:</dt>
		<dd>You may make changes to more than one event before you save changes.  All events for the month will save simultaneously.</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step One</dt>
		<dd>Navigate to the <span class="uk-text-bold uk-text-primary">Event</span> heading.</dd>
		<dd><span class="uk-text-bold">Note:</span> Events for the month will display in numbered rows.  If there are no events in the calendar month, you may proceed to adding calendar events.</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step Two</dt>
		<dd>Choose a numbered row to update and begin by selecting the event type from the event type drop-down. (e.g. "Holiday", "Board of Directors Meeting")</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step Three</dt>
		<dd>If you wish to update the date of the event, select the <span class="uk-form"><div class="uk-form-icon"><i class="uk-icon-calendar"></i><input class="uk-form-small" readonly="" type="text"></div></span> field underneath the <span class="uk-text-bold uk-text-primary">Date</span> heading.</dd>
		<dd><span class="uk-text-bold">Note:</span> Dates are in MM/DD format.</dd>
	</dl>
	<dl class="uk-description-list-horizontal">
		<dt>Step Four</dt>
		<dd>Click the <button class="uk-button uk-button-primary uk-button-mini">SAVE CHANGES <i class="uk-icon uk-icon-check-circle-o"></i></button> button to save changes.</dd>
	</dl>
</div>

