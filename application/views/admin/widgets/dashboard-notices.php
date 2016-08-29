<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$badge_class = $attention ? 'uk-badge-danger' : 'uk-badge-success';
	$icon_class = $attention ? 'uk-icon-exclamation' : 'uk-icon-check-circle-o';
?>
<div class="uk-panel-badge uk-badge <?php echo $badge_class; ?>"><i class="uk-icon <?php echo $icon_class; ?>"></i></div>
<h1 class="uk-panel-title">Notices</h1>

<?php if ( isset($messages) && count($messages) > 0 ) : ?>
	<?php foreach ( $messages as $m ) : ?>
		<p class="uk-text-danger"><i class="uk-icon uk-icon-exclamation-circle"></i> <?php echo $m; ?></p>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ( isset($notices) && count($notices) > 0 ) : ?>
	<h4>All Notices:</h4>
	<ul class="uk-list uk-list-striped">
		<?php foreach ( $notices as $notice ) : ?>
			<li>
				<span class="uk-text-bold <?php echo $notice->old ? 'uk-text-danger' : ''; ?>">
					<?php if ( $notice->old ) : ?>
						<i class="uk-icon uk-icon-exclamation-circle"></i> 
					<?php endif; ?>
					<?php echo $notice->heading_text; ?>
					<a class="uk-button uk-button-primary uk-button-mini uk-align-right" href="<?php echo $links['notices-entry'].'/'.$notice->id; ?>">Edit</a>
				</span>
				<br />
				<span class="uk-text-muted uk-text-right"><?php echo date('F jS, Y', strtotime($notice->notice_date)); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else : ?>
	<p>You are currently not displaying any notices.</p>
<?php endif; ?>

<p>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['notices-all']; ?>">View All</a>
</p>