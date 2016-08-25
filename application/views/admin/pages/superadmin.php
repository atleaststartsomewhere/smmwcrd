<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<?php echo form_open($scripts['scriptsuperadmin'].'/update', array("class" => "uk-form uk-form-stacked uk-form-horizontal")); ?>
		<div class="uk-panel uk-panel-box uk-panel-box-primary">
			<span class="">Set site configurations for SMMWC.com</span>
		</div>
		<div class="uk-form-row"></div>
		<hr class="uk-grid-divider">

		<div class="uk-grid">
			<div class="uk-width-1-1">

				<div class="uk-form-row">
					<label class="uk-form-label" for="oldpwd">Maintenance Mode</label>
					<div class="uk-form-controls">
						<label class="uk-button uk-button-primary" title="Toggle Maintenance Mode" alt="Toggle Maintenance Mode" for="checkbox-maintenance">
							<i class="uk-icon-wrench"></i>
						</label>
						<?php // Set up checked
							$checked = $maintenance ? 'checked="checked"' : '';
						?>
						<input <?php echo $checked; ?> class="" title="Toggle Maintenance Mode" alt="Toggle Maintenance Mode" id="checkbox-maintenance" name="maintenance" type="checkbox">
					</div>
				</div>

			</div>

		</div>

		<div class="uk-grid">
			<div class="uk-width-1-1">
				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
			</div>
		</div>

	<?php echo form_close(); ?>
</article>