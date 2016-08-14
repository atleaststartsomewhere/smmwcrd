<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<?php if ( count($successes) > 0 || count($errors) > 0 ) : ?>
	<article class="uk-article" style="top:0, position:absolute;">
		<?php if ( count($successes) > 0 ) : ?>
			<div class="uk-alert uk-alert-success" data-uk-alert>
				<a href="" class="uk-alert-close uk-close"></a>
				<?php foreach ( $successes as $s ) : ?>
					<p><?php echo $s; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ( count($errors) > 0 ) : ?>
			<div class="uk-alert uk-alert-danger" data-uk-alert>
				<a href="" class="uk-alert-close uk-close"></a>
				<?php foreach ( $errors as $e ) : ?>
					<p><?php echo $e; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</article> 
<?php endif; ?>