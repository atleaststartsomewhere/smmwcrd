<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";var_dump($create);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li class=""><a href="<?php echo $links['resources-add'];?>"><i class="uk-icon uk-icon-plus"></i> Add File</a></li>
		<li class="uk-active"><a href="<?php echo $links['resources-add-link'];?>"><i class="uk-icon uk-icon-plus"></i> Add Link</a></li>
		<li class=""><a href="<?php echo $links['resources'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-1-1">
		<div class="uk-panel uk-panel-box uk-panel-box-primary">
			<h3 class="uk-panel-title">Adding a Link Resource</h3>
			<span class="">Add a website address to a resouce category</span>
		</div>
		<div class="uk-form-row"></div>
		<hr class="uk-grid-divider">

		<?php echo form_open($scripts['scriptresources'].'/add_link', 'class="uk-form uk-form-horizontal"'); ?>

			<div class="uk-form-row">
				<label class="uk-form-label">Resource Category</label>
				<div class="uk-form-controls">
					<select name="category">
						<?php foreach ( $categories as $category ) : ?>
							<option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Link Address</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="url" type="text" placeholder="Enter URL" value="">
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Display Name </label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="name" type="text" placeholder="Enter Display Name" value="">
					<span class="uk-form-help-inline">The display name is what users will see to click on your link.</span>
				</div>
			</div>

			<hr class="uk-grid-divider">

			<div class="uk-form-row">
				<label class="uk-form-label"></label>
				<div class="uk-form-controls">
					<a href="<?php echo $links['notices-all']; ?>" class="uk-button uk-button-link">Cancel</a>
					<button class="uk-button uk-button-primary">Submit</button>
				</div>
			</div>
			
		<?php echo form_close(); ?>

		</div>
	</div>
</article>