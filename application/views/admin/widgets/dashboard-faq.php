<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$badge_class = $attention ? 'uk-badge-danger' : 'uk-badge-success';
	$icon_class = $attention ? 'uk-icon-exclamation' : 'uk-icon-check-circle-o';
?>
<div class="uk-panel-badge uk-badge <?php echo $badge_class; ?>"><i class="uk-icon <?php echo $icon_class; ?>"></i></div>
<h1 class="uk-panel-title">FAQ</h1>

<?php if ( isset($messages) && count($messages) > 0 ) : ?>
	<?php foreach ( $messages as $m ) : ?>
		<p class="uk-text-danger"><i class="uk-icon uk-icon-exclamation-circle"></i> <?php echo $m; ?></p>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ( isset($faq) ) : ?>
	<p>Last update was made on <span class="uk-text-bold"><?php echo date('F jS, Y', strtotime($faq->last_updated));?></span></p>
<?php else : ?>
	<p><span>You have no faq</p>
<?php endif; ?>
<p>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['meetings-resources']; ?>">View All</a>
</p>