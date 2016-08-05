<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-2">
			<?php echo form_open($scripts['scriptbillpay'].'/update', array("class" => "uk-form")); ?>
				<legend class="uk-text-primary">Update External Link</legend>

				<div class="uk-form-icon" title="Link to Bill Pay Site">
					<i class="uk-icon-external-link"></i>
					<input class='uk-form-width-large' name="paybill_link" type="text" value="<?php echo $paybill_link;?>">
				</div>

				<button class="uk-button uk-button-primary">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>

			<?php echo form_close(); ?>
		</div>
	</div>
</article>