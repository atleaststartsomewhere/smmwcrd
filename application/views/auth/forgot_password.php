<h1 class="uk-text-center"><?php echo lang('forgot_password_heading');?></h1>

<hr class="uk-grid-divider">

<h5><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></h5>

<div class="uk-block">

	<?php echo form_open("auth/forgot_password", array('class' => 'uk-form uk-form-horizontal')); ?>

		<?php if ( isset($message) && !empty($message) ): ?>
			<div class="uk-alert uk-alert-danger">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<div class="uk-form-row">
			<label class="uk-form-label" for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label>
			<div class="uk-form-controls"><?php echo form_input($email);?></div>
		</div>

		<div class="uk-form-row">
			<label class="uk-form-label" for=""></label>
			<div class="uk-form-controls">
				<button class="uk-button uk-button-primary" type="submit">Submit</button>
			</div>
		</div>

	<?php echo form_close(); ?>
