<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-1">
			<?php echo form_open_multipart($scripts['scriptmeetings'].'/update', array("class" => "uk-form")); ?>
				<legend class="uk-text-primary">Agendas and Meeting Minutes</legend>
				<?php echo $widget_items_pagination; ?>

				<?php echo $widget_items_list; ?>


				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>

			<?php echo form_close(); ?>
		</div>
	</div>
</article>