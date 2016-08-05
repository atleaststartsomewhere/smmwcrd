<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-2">
			<?php echo form_open($scripts['scriptboardstaff'].'/update', array("class" => "uk-form")); ?>
				<legend class="uk-text-primary">Board</legend>

				<?php echo $widget_board_list; ?>

				<?php echo $widget_staff_list; ?>

				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>

			<?php echo form_close(); ?>
		</div>



		<div class="uk-width-large-1-2">
			<?php echo form_open($scripts['scriptboardstaff'].'/update', array("class" => "uk-form")); ?>
				<legend class="uk-text-primary">Staff</legend>

				<?php echo $widget_board_list; ?>
				<div class="uk-sortable uk-margin" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
					<div class="uk-sortable-handle uk-margin">
						<div class="uk-panel uk-panel-box">
							<i class="uk-sortable-handle uk-icon uk-icon-bars uk-margin-small-right"></i>
							<span>Item 1</span>
							<?php form_open('action', array('class' => 'uk-form uk-form-horizontal')); ?>
								<div class="uk-form-row">
									<label class="uk-form-label" for="">Name</label>
									<div class="uk-form-controls"><input type="text"></div>
								</div>

								<div class="uk-form-row">
									<label class="uk-form-label" for="">Bio</label>
									<div class="uk-form-controls"><textarea></textarea></div>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>

				<?php echo $widget_staff_list; ?>

				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>

			<?php echo form_close(); ?>
		</div>
	</div>
</article>