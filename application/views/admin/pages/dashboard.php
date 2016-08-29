<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ( count($attention_widgets) > 0 ) : ?>
	<article class="uk-article">
		<div class="uk-block">
			<div class="uk-grid" data-uk-grid-margin>
				<?php foreach ( $attention_widgets as $widget ) : ?>
					<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-width-large-1-3">
						<div class="uk-panel uk-panel-box">
							<?php echo $widget; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</article>
<?php endif; ?>

<?php if ( count($widgets) > 0 ) : ?>
	<article class="uk-article">
		<div class="uk-block">
			<div class="uk-grid" data-uk-grid-margin>
				<?php foreach ( $widgets as $widget ) : ?>
					<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-width-large-1-3">
						<div class="uk-panel uk-panel-box">
							<?php echo $widget; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</article>
<?php endif; ?>