<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$badge_class = $attention ? 'uk-badge-danger' : 'uk-badge-success';
	$icon_class = $attention ? 'uk-icon-exclamation' : 'uk-icon-check-circle-o';
?>
<div class="uk-panel-badge uk-badge <?php echo $badge_class; ?>"><i class="uk-icon <?php echo $icon_class; ?>"></i></div>
<h1 class="uk-panel-title">Calendar</h1>

<?php if ( isset($messages) && count($messages) > 0 ) : ?>
	<?php foreach ( $messages as $m ) : ?>
		<p class="uk-text-danger"><i class="uk-icon uk-icon-exclamation-circle"></i> <?php echo $m; ?></p>
	<?php endforeach; ?>
<?php endif; ?>

<ul class="uk-list uk-list-striped">
<?php if ( isset($current) && count($current) > 0 ) : ?>
	<li>
		<span>You have <?php echo count($current); ?> events set for this month.</span>
	</li>
<?php endif; ?>

<?php if ( isset($next) && count($next) > 0 ) : ?>
	<li>
		<span>You have <?php echo count($next); ?> events set for next month.</span>
	</li>
<?php endif; ?>

<p>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['calendar']; ?>">Edit <?php echo date('F'); ?></a>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['calendar'].'/'.$next_year.'/'.$next_month; ?>">Edit <?php echo date('F', strtotime('+1 month')); ?></a>
</p>