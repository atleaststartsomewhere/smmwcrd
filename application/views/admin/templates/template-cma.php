<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>

<?php echo $header; ?>

<?php // BODY START ?>
<div class="uk-grid uk-grid-collapse cma-body">
	<div class="uk-width-2-10 cma-side-container">
		<?php echo $sidebar; ?>
	</div>

	<div class="uk-width-8-10 cma-main-container">
		<div id="cma-page-header" class="uk-block uk-contrast" style="padding:2%;">
			<h1 class="uk-article-title"><i class="uk-icon-edit"></i> <?php echo $heading; ?></h1>
			<p class="uk-article-meta"><?php echo $description; ?></p>
		</div>
		<div id="cma-content">
			<?php echo $messages; ?>
			<?php echo $page; ?>
		</div>
		<div id="cma-help">
			<?php echo $help; ?>
		</div>
	</div>
</div>