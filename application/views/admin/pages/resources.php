<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li class=""><a href="<?php echo $links['resources-add'];?>"><i class="uk-icon uk-icon-plus"></i> Add File</a></li>
		<li class=""><a href="<?php echo $links['resources-add-link'];?>"><i class="uk-icon uk-icon-plus"></i> Add Link</a></li>
		<li class="uk-active"><a href="<?php echo $links['resources'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<div class="uk-form uk-form-horizontal">
		<div class="uk-grid">
			<div class="uk-width-1-1">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<h3 class="uk-panel-title">Resources</h3>
					<span>Re-order, or change categories for resources.</span>
				</div>
			</div>
		</div>

		<hr class="uk-grid-divider">

		<ul class="uk-tab" data-uk-tab="{connect:'#resources-tabs'}">
			<li class="uk-active"><a href=""><i class="uk-icon uk-icon-calendar"></i> Recent</a></li>
			<li><a href=""><i class="uk-icon uk-icon-star"></i> Featured</a></li>
			<?php foreach ( $custom_categories as $category => $widget ) : ?>
				<li><a href=""><i class="uk-icon uk-icon-square"></i> <?php echo $category; ?></a></li>
			<?php endforeach; ?>
		</ul>

		<ul id="resources-tabs" class="uk-switcher uk-margin">
			<?php // Recent ?>
			<li>
				<?php echo form_open($scripts['scriptresources'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>
					<?php echo $recent; ?>
				<?php echo form_close(); ?>
			</li>
			<?php // Featured ?>
			<li>
				<?php echo form_open($scripts['scriptresources'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>
					<?php echo $featured; ?>
				<?php echo form_close(); ?>
			</li>
			<?php // Custom Categories ?>
			<?php foreach ( $custom_categories as $category => $widget) : ?>
				<li>
					<?php echo form_open($scripts['scriptresources'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>
						<?php echo $widget; ?>
					<?php echo form_close(); ?>
				</li>
			<?php endforeach; ?>
		</ul>


	</div>
</article>