<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<article class="uk-article">
	<?php echo form_open($scripts['scriptfaq'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>

	<div class="uk-grid">
		<div class="uk-width-2-3">

			<legend class="uk-text-primary">Frequently Asked Questions</legend>
			<?php if ( empty($faqs) ) : ?>
				<span>No FAQ to display. Click <a href="<?php echo $links['faq-entry']; ?>">Here</a> to add one.</span>
			<?php else : ?>
				<span class="uk-form-help-inline uk-text-small">Click and Drag <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> to re-order FAQs</span>

				<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
					<div class="uk-form-row"></div>
					<hr class="uk-grid-divider">
					<?php foreach ( $faqs as $faq ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-3-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $faq->question; ?></span>
								</div>
								<div class="uk-width-1-6">
									<a href="<?php echo $links['faq-entry'].'/'.$faq->id; ?>">Edit FAQ</a>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $faq->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $faq->id; ?>" name="remove[<?php echo $faq->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $faq->id; ?>]" value="<?php echo $faq->id; ?>">
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