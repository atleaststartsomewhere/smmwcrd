<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>

<div id="cma-page-header" class="uk-block uk-contrast">
	<h1 class="uk-article-title"><i class="uk-icon-question"></i> Help</h1>
	<p class="uk-article-meta">Browse Various Help Topics Below</p>
</div>

<div style="padding:2%;">
	<article class="uk-article">
		<div class="uk-accordion" data-uk-accordion>
			<?php echo $help_content; ?>
		</div>
	</article>
</div>