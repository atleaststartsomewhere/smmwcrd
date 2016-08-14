<h1 class="uk-text-center"><?php echo lang('login_heading');?></h1>

<hr class="uk-grid-divider">

<h5><?php echo lang('login_subheading');?></h5>

<div class="uk-block">

	<?php echo form_open("auth/login", array('class' => 'uk-form uk-form-horizontal')); ?>

		<?php if ( isset($message) && !empty($message) ): ?>
			<div class="uk-alert uk-alert-danger">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<div class="uk-form-row">
			<label class="uk-form-label" for="identity"><?php echo lang('login_identity_label', 'identity');?></label>
			<div class="uk-form-controls"><?php echo form_input($identity);?></div>
		</div>


		<div class="uk-form-row">
			<label class="uk-form-label" for="password"><?php echo lang('login_password_label', 'password');?></label>
			<div class="uk-form-controls"><?php echo form_input($password);?></div>
		</div>


		<div class="uk-form-row">
			<label class="uk-form-label" for="remember"><?php echo lang('login_remember_label', 'remember');?></label>
			<div class="uk-form-controls"><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?></div>
		</div>


		<div class="uk-form-row">
			<label class="uk-form-label" for=""></label>
			<div class="uk-form-controls">
				<button class="uk-button uk-button-primary" type="submit">Login</button>
			</div>
		</div>

	<?php echo form_close(); ?>

	<div>
		<a href="forgot_password" class="form-main"><?php echo lang('login_forgot_password');?></a>
	</div>

</div>