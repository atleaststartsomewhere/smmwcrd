<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//var_dump($pages);return;
?>


<ul class="uk-pagination">
	<li><span class="uk-text-muted">Page:</span></li>
	<?php foreach ( $pages as $page ) : ?>
		<li class="<?php echo $page['class']; ?>">
			<?php if ( $page['is_active'] ) : ?>
				<span><?php echo $page['number']; ?></span>
			<?php else : ?>
				<a href="<?php echo $page['url']; ?>"><?php echo $page['number']; ?></a>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>