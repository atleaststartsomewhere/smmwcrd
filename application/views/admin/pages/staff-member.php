<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-2-3">

		<?php echo form_open($scripts['scriptstaff'].'/update', 'class="uk-form uk-form-horizontal"'); ?>

			<legend class="uk-text-primary"><?php echo ($create)?"Add a New Staff Member":"Edit Staff Member";?></legend>

			<div class="uk-form-row">
				<label class="uk-form-label">Name</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="name" type="text" placeholder="Name" value="<?php echo $name; ?>">
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Title</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="title" type="text" placeholder="Title" value="<?php echo $title; ?>">
				</div>
			</div>

			<?php if ( !$create ) : ?>
				<div class="uk-form-row">
					<label class="uk-form-label"></label>
					<div class="uk-form-controls">
						<input id="delete" name="delete" type="checkbox">
						<span class="uk-form-help-inline uk-text-muted">Delete this Staff Member</span>
					</div>
				</div>
			<?php endif; ?>

			<div class="uk-form-row">
				<label class="uk-form-label"></label>
				<div class="uk-form-controls uk-align-right">
					<a href="<?php echo $links['staff-all']; ?>" class="uk-button uk-button-link">Cancel</a>
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