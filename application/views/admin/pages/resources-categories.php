<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($categories);echo "</pre>";return;
?>
<article class="uk-article">
	<?php echo form_open($scripts['scriptrescategories'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>
	<div class="uk-grid">
		<div class="uk-width-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<span class="">Click and drag the <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> icon to re-order your categories.</span>
				<p>You may add categories at the bottom of this page.</p>
			</div>

			<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
				<div class="uk-form-row"></div>
				<hr class="uk-grid-divider">
				<?php if ( !empty($categories) ) : ?>
					<?php foreach ( $categories as $category ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-1-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $category->category_name; ?></span>
								</div>
								<div class="uk-width-2-6">
									<input name="update_names[<?php echo $category->id; ?>]" class="uk-form-width-large" type="text" placeholder="Update Category Name" value="">
								</div>
								<div class="uk-width-1-6">
									<a href="<?php echo $links['resources']; ?>"><?php echo $category->num_resources; ?> resources</a>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $category->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $category->id; ?>" name="remove[<?php echo $category->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $category->id; ?>]" value="<?php echo $category->id; ?>">
							<hr class="uk-grid-divider">
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			
			<div class="uk-form-row">
				<div class="uk-grid uk-grid-condensed">
					<div class="uk-width-1-6">
						<span class="uk-text-primary">New Category</span>
					</div>
					<div class="uk-width-3-6">
						<input name="new_cat" class="uk-form-width-large" type="text" placeholder="Additional Category Name" value="">
					</div>
				</div>
				<hr class="uk-grid-divider">
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