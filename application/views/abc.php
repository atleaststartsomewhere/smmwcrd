<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-2">
			<?php echo form_open('admin/scripts/board/test', array("class" => "uk-form uk-form-stacked uk-form-horizontal")); ?>
				<input name="title" type="text">
				<input name="name" type="text">

				<div class="uk-form-row">
					<label class="uk-form-label" for="oldpwd"></label>
					<div class="uk-form-controls">
						<button class="uk-button uk-button-primary uk-align-right">UPDATE PASSWORD <i class="uk-icon-check-circle-o"></i></button>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</article>