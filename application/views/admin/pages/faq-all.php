<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li><a href="<?php echo $links['faq-entry'];?>"><i class="uk-icon uk-icon-plus"></i> Add </a></li>
		
		<li class="" data-uk-dropdown="{mode:'click'}">
			<a href="">Edit <i class="uk-icon uk-icon-chevron-down"></i></a>
			<div class="uk-dropdown uk-dropdown-small">
				<ul class="uk-nav uk-nav-dropdown">
					<?php if ( empty($faqs) ) : ?>
						<li class="uk-disabled">There are no FAQ to edit.</li>
					<?php else : ?>
						<?php foreach ( $faqs as $faq ) : ?>
							<li><a href="<?php echo $links['faq-entry'].'/'.$faq->id;?>">&quot;<?php echo $faq->question; ?>&quot;</a></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</li>
		<li class="uk-active"><a href="<?php echo $links['faq-all'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<?php echo form_open($scripts['scriptfaq'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>

	<div class="uk-grid">
		<div class="uk-width-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<span class="">Click and drag the <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> icon to re-order FAQs.</span>
			</div>
			<?php if ( empty($faqs) ) : ?>
				<span>No FAQ to display. Click <a href="<?php echo $links['faq-entry']; ?>">Here</a> to add one.</span>
			<?php else : ?>
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