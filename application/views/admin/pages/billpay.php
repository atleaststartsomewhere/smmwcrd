<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<?php echo form_open($scripts['scriptbillpay'].'/update', array("class" => "uk-form")); ?>
	<div class="uk-grid">
		<div class="uk-width-large-1-2">
				<legend class="uk-text-primary">Update External Link</legend>

				<div class="uk-form-icon" title="Link to Bill Pay Site">
					<i class="uk-icon-external-link"></i>
					<input class='uk-form-width-large' name="paybill_link" type="text" value="<?php echo $paybill_link;?>">
				</div>
		</div>
	</div>
	<div class="uk-grid">
		<div class="uk-width-1-2">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>
	<?php echo form_close(); ?>
</article>