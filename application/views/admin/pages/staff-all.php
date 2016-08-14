<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<article class="uk-article">
	<?php echo form_open($scripts['scriptstaff'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>

	<div class="uk-grid">
		<div class="uk-width-2-3">

			<legend class="uk-text-primary">SMMWC Staff</legend>
			<?php if ( empty($members) ) : ?>
				<span>No Staff Members to display. Click <a href="<?php echo $links['staff-member']; ?>">Here</a> to add one.</span>
			<?php else : ?>
				<span class="uk-form-help-inline uk-text-small">Click and Drag <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> to re-order staff members</span>

				<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
					<div class="uk-form-row"></div>
					<hr class="uk-grid-divider">
					<?php foreach ( $members as $member ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-3-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $member->name; ?></span>
									<br />
									<span class="uk-text uk-text-muted uk-text-small"><?php echo $member->title; ?></span>
								</div>
								<div class="uk-width-1-6">
									<a href="<?php echo $links['staff-member'].'/'.$member->id; ?>">Edit Member</a>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $member->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $member->id; ?>" name="remove[<?php echo $member->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $member->id; ?>]" value="<?php echo $member->id; ?>">
						<hr class="uk-grid-divider">
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>	

		</div>
	</div>

	<div class="uk-grid">
		<div class="uk-width-2-3">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>
	
	<?php echo form_close(); ?>
</article>