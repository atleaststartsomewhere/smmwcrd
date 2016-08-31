<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<?php if ( $sort ) : ?>
<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
<?php else : ?>
<div>
<?php endif; ?>
	<div class="uk-form-row"></div>
	<?php if ( empty($resources ) ) : ?>
		<div class="uk-form-row">
			<span>No resources to display for this category</span>
		</div>
	<?php else : ?>
		<?php foreach ( $resources as $resource ) : ?>
			<div class="uk-form-row">
				<div class="uk-grid uk-grid-condensed">
					<?php if ( $sort ) : ?>
					<div class="uk-width-1-6">
						<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
					</div>
					<div class="uk-width-2-6">
					<?php else : ?>
					<div class="uk-width-3-6">
					<?php endif; ?>
						<span class="uk-text uk-text-primary uk-text-bold"><?php echo $resource->display_name; ?></span>
						<br />
						<span class="uk-text uk-text-muted uk-text-small">Date Added: <?php echo date('F jS, Y', strtotime($resource->date_added)); ?></span>
					</div>
					<div class="uk-width-2-6">
						<label>Category:</label>
						<select name="category[<?php echo $resource->id; ?>]">
							<?php foreach ( $categories as $category ) : ?>
								<option <?php echo ( ($resource->category_id == $category->id) ? 'selected="selected"' : '' ); ?> value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="uk-width-1-6">
						<div class="uk-align-right">
							<input <?php echo ( isset($resource->featured) ? 'checked="checked"' : '' ); ?> class="" title="Mark as Featured" alt="Mark as Featured" id="<?php echo $category_name; ?>-checkbox-feat-<?php echo $resource->id; ?>" name="feature[<?php echo $resource->id; ?>]" type="checkbox">
							<label class="uk-button uk-button-success" title="Mark as Featured" alt="Mark as Featured" for="<?php echo $category_name; ?>-checkbox-feat-<?php echo $resource->id; ?>">
								<i class="uk-icon-star-o"></i>
							</label>
						</div>
						<div class="uk-align-right">
							<input class="" title="Mark for Deletion" alt="Mark for Deletion" id="<?php echo $category_name; ?>-checkbox-<?php echo $resource->id; ?>" name="remove[<?php echo $resource->id; ?>]" type="checkbox">
							<label class="uk-button uk-button-danger" title="Mark for Deletion" alt="Mark for Deletion" for="<?php echo $category_name; ?>-checkbox-<?php echo $resource->id; ?>">
								<i class="uk-icon-trash-o"></i>
							</label>
						</div>
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
<?php if ( $sort ) : ?>
	<input type="hidden" name="sorting" value="yes">
<?php endif; ?>