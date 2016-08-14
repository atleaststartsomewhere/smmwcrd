<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<article class="uk-article">
	<div class="uk-form uk-form-horizontal">

		<div class="uk-grid">
			<div class="uk-width-1-1">
				<div class="uk-form-row">
					<legend class="uk-text-primary">Your Resources</legend>
				</div>
				<div class="uk-form-row">
					<div class="uk-align-right">
						<?php echo form_open($scripts['scriptresources'].'/apply_filters', array('class' => 'uk-align-right')); ?>
							<span>Filters: </span>
							<select name="category_filter">>
								<option value="">-- Choose a Category: --</option>
								<?php foreach ( $categories as $category ) : ?>
									<option <?php echo (($category->id == $category_filter)?' selected="selected" ':''); ?> value="<?php echo $category->id;?>"><?php echo $category->category_name; ?></option>
								<?php endforeach; ?>
							</select>
							<span> Date Added: </span>				
							<div class="uk-form-icon" title="">
								<i class="uk-icon-calendar"></i>
								<input readonly name="date_filter" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" value="<?php echo (isset($date_filter) ? date('m/d/Y', strtotime($date_filter)) : ''); ?>">
							</div>
							<br />
							<button type="submit" class="uk-button uk-button-link">Apply Filters <i class="uk-icon uk-icon-refresh"></i></button>
							<a href="<?php echo site_url().$scripts['scriptresources'].'/remove_filters'?>" class="uk-button uk-button-link">Clear Filters <i class="uk-icon uk-icon-close"></i></a>
						<?php echo form_close(); ?>
					</div>
				</div>
				<div class="uk-form-row">
					<span>Showing all resources<?php echo ( isset($category_filter_name) ? ' from category: &quot;<b>'.$category_filter_name.'&quot;</b>' : '' ); ?><?php echo ( isset($date_filter) ? ' Added on <b>'.date('F jS, Y', strtotime($date_filter)).'</b>' : '' );?>.</span>
				</div>
			</div>
		</div>

<?php echo form_open($scripts['scriptresources'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>
		<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
			<div class="uk-form-row"></div>
			<hr class="uk-grid-divider">
			<?php if ( empty($resources ) ) : ?>
				<div class="uk-form-row">
					<span>No resources to display with current filter settings.</span>
				</div>
			<?php else : ?>
					<?php foreach ( $resources as $resource ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-1-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $resource->display_name; ?></span>
									<br />
									<span class="uk-text uk-text-muted uk-text-small">Date Added: <?php echo date('F jS, Y', strtotime($resource->date_added)); ?></span>
								</div>
								<div class="uk-width-1-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $resource->category_name; ?></span>
								</div>
								<div class="uk-width-2-6">
									<?php foreach ( $categories as $category ) : ?>
										<div class="uk-button uk-button-link uk-button-mini">
											<label class="uk-text-small" for="cats-<?php echo $category->id; ?>-<?php echo $resource->id; ?>"><?php echo $category->category_name; ?></label>
											<input <?php echo ( ($resource->cat_id == $category->id) ? ' checked="checked" ' : '' ); ?>id="cats-<?php echo $category->id; ?>-<?php echo $resource->id; ?>" value="<?php echo $category->id; ?>" name="cats[<?php echo $resource->id; ?>]" type="radio">
										</div>
									<?php endforeach; ?>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $resource->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $resource->id; ?>" name="remove[<?php echo $resource->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $resource->id; ?>]" value="<?php echo $resource->id; ?>">
							<hr class="uk-grid-divider">
						</div>
					<?php endforeach; ?>

					
			<?php endif; ?>
		</div>
		<div class="uk-grid">
			<div class="uk-width-1-1">
				<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
			</div>
		</div>
		<?php echo form_close(); ?>

	</div>

	
	<?php echo form_close(); ?>
</article>