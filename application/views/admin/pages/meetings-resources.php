<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<h3 class="uk-panel-title">Agendas and Meeting Minutes</h3>
				<span class="">Please note that the list of meetings below is created from the data you enter into the calendar.  Any events that are listed as Board Meetings or Annual Shareholder Meetings will display here in the order of the most recent date to earliest date.</span>
				<br /><span>You may add agendas and meeting minutes files to these calendar events, replace or remove them.</span>
			</div>
			<div class="uk-form-row"></div>
			<hr class="uk-grid-divider">
			<?php echo form_open_multipart($scripts['scriptmeetings'].'/update', array("class" => "uk-form")); ?>
				<?php echo $widget_items_pagination; ?>
				<hr class="uk-grid-divider">

				<?php echo $widget_items_list; ?>


				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>

			<?php echo form_close(); ?>
		</div>
	</div>
</article>