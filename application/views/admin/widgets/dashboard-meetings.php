<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$badge_class = $attention ? 'uk-badge-danger' : 'uk-badge-success';
	$icon_class = $attention ? 'uk-icon-exclamation' : 'uk-icon-check-circle-o';
?>
<div class="uk-panel-badge uk-badge <?php echo $badge_class; ?>"><i class="uk-icon <?php echo $icon_class; ?>"></i></div>
<h1 class="uk-panel-title">Agendas and Meeting Minutes</h1>

<?php if ( isset($messages) && count($messages) > 0 ) : ?>
	<?php foreach ( $messages as $m ) : ?>
		<p class="uk-text-danger"><i class="uk-icon uk-icon-exclamation-circle"></i> <?php echo $m; ?></p>
	<?php endforeach; ?>
<?php endif; ?>

<?php 
$agendas = 0; $minutes = 0;
foreach ( $meetings as $meeting ) {
	if ( !isset($meeting->agenda_path) )
		$agendas++;
	if ( !isset($meeting->minutes_path) )
		$minutes++;
} ?>
<p><span class="uk-text-bold"><?php echo $agendas; ?></span> meeting(s) need agendas.</p>
<p><span class="uk-text-bold"><?php echo $minutes; ?></span> meeting(s) need minutes.</p>
<p>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['meetings-resources']; ?>">View All</a>
</p>