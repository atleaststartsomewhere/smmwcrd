<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";var_dump($create);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li class="uk-active"><a href="<?php echo $links['resources-add'];?>"><i class="uk-icon uk-icon-plus"></i> Add File</a></li>
		<li class=""><a href="<?php echo $links['resources-add-link'];?>"><i class="uk-icon uk-icon-plus"></i> Add Link</a></li>
		<li class=""><a href="<?php echo $links['resources'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-1-1">
		<div class="uk-panel uk-panel-box uk-panel-box-primary">
			<h3 class="uk-panel-title">Adding a File Resource</h3>
			<span class="">Upload a file to a resource category.</span>
		</div>
		<div class="uk-form-row"></div>
		<hr class="uk-grid-divider">

		<?php echo form_open_multipart($scripts['scriptresources'].'/add', 'class="uk-form uk-form-horizontal"'); ?>

			<div class="uk-form-row">
				<label class="uk-form-label">Heading</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="heading" type="text" placeholder="heading" value="<?php echo $heading; ?>">
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Date</label>
				<div class="uk-form-controls uk-form-icon uk-align-left uk-margin-left">
					<i class="uk-icon-calendar"></i>
					<input readonly name="date" class="uk-form-width-medium" type="text" data-uk-datepicker="{format: 'MM/DD/YYYY'}" value="<?php echo ($create?date('m/d/Y'):$notice_date); ?>">
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Message</label>
				<div class="uk-form-controls">
					<textarea class="uk-form-width-large" rows="10" name="message"><?php echo $message; ?></textarea>
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Resource</label>
				<div class="uk-form-controls">
					<select name="resource" class="uk-form-width-large">
						<option value="0">-- Optional: Attach a Resource --</option>
						<?php foreach ( $resources as $cat_name => $category ) : ?>
							<option value="0">-- <?php echo $cat_name; ?> --</option>
							<?php foreach ( $category as $resource ) : ?>
								<?php // Selected insert
								$selected = ($resource->id == $selected_resource)?'selected="selected"':''; ?>
								<option <?php echo $selected; ?> value="<?php echo $resource->id; ?>"><?php echo $cat_name; ?>: <?php echo $resource->display_name; ?></option>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</select>
					<span class="uk-form-help-inline uk-text-muted">Attach a Resource Link to this Notice</span>
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Notice Type</label>
				<div class="uk-form-controls">
					<select name="notice_type" class="uk-form-width-medium">
						<?php foreach ( $types as $type ) : ?>
							<?php 	// Selected insert
							$selected = ($type->id == $selected_type)?'selected="selected"':''; ?>
							<option <?php echo $selected; ?> value="<?php echo $type->id; ?>"><?php echo $type->friendly_name; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="uk-form-help-inline uk-text-muted">Special notices become highlighted</span>
				</div>
			</div>

			<?php if ( !$create ) : ?>
				<div class="uk-form-row">
					<label class="uk-form-label"></label>
					<div class="uk-form-controls">
						<input id="delete" name="delete" type="checkbox">
						<span class="uk-form-help-inline uk-text-muted">Delete this notice</span>
					</div>
				</div>
			<?php endif; ?>

			<hr class="uk-grid-divider">

			<div class="uk-form-row">
				<label class="uk-form-label"></label>
				<div class="uk-form-controls">
					<a href="<?php echo $links['notices-all']; ?>" class="uk-button uk-button-link">Cancel</a>
					<button class="uk-button uk-button-primary">Submit</button>
				</div>
			</div>

			<?php if (isset($id) && !empty($id)) : ?>
				<input type="hidden" name="id" value="<?php echo $id;?>">
			<?php endif; ?>
			
		<?php echo form_close(); ?>

		</div>
	</div>
</article>