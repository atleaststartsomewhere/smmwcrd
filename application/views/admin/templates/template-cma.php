<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>

<?php echo $header; ?>

<?php // BODY START ?>
<div class="uk-grid uk-grid-collapse cma-body">
	<div class="uk-width-large-2-10 cma-side-container uk-visible-large">
		<?php echo $sidebar; ?>
	</div>

	<div class="uk-width-medium-1-1 uk-width-large-8-10 cma-main-container">
		<div class="uk-block uk-block-primary uk-contrast" style="padding:2%;">
			<h1 class="uk-article-title"><i class="uk-icon-edit"></i> <?php echo $heading; ?></h1>
			<?php echo $messages; ?>
		</div>
		<div id="cma-content">
			<?php echo $page; ?>
		</div>
		<div id="cma-help">
			<?php echo $help; ?>
		</div>
	</div>
</div>