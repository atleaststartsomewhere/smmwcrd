<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-1-1">
			<?php echo form_open($scripts['scriptaccount'].'/update', array("class" => "uk-form uk-form-stacked uk-form-horizontal")); ?>
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<h3 class="uk-panel-title">Update Your Password</h3>
					<span class="">You should change this every 6 months to increase site security.</span>
				</div>
				<div class="uk-form-row"></div>
				<hr class="uk-grid-divider">

				<div class="uk-form-row">
					<label class="uk-form-label" for="oldpwd">Old Password</label>
					<div class="uk-form-controls">
						<div class="uk-form-password">
							<input class="uk-form-width-large" type="password" placeholder="Enter Old Password" name="old">
							<a href="" class="uk-form-password-toggle" data-uk-form-password>Show</a>
						</div>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="oldpwd">New Password</label>
					<div class="uk-form-controls">
						<div class="uk-form-password">
							<input class="uk-form-width-large" type="password" placeholder="Enter New Password" name="new">
							<a href="" class="uk-form-password-toggle" data-uk-form-password>Show</a>
						</div>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="oldpwd">Confirm Password</label>
					<div class="uk-form-controls">
						<div class="uk-form-password">
							<input class="uk-form-width-large" type="password" placeholder="Enter New Password Again" name="new_confirm">
							<a href="" class="uk-form-password-toggle" data-uk-form-password>Show</a>
						</div>
					</div>
				</div>

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