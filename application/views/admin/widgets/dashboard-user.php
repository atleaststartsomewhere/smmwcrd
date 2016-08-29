<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// $billpay:
	// 1 = on; 2 = off; 3 = unreachable
	$badge_class = ($billpay != 1) ? 'uk-badge-danger' : 'uk-badge-success';
	$icon_class = ($billpay != 1) ? 'uk-icon-exclamation' : 'uk-icon-check-circle-o';
	$message = ($billpay == 1) ? 'The bill pay site is up.' : 'The bill pay site is currently unreachable (Code: 0'.$billpay.')';
	
?>
<div class="uk-panel-badge uk-badge <?php echo $badge_class; ?>"><i class="uk-icon <?php echo $icon_class; ?>"></i></div>
<h1 class="uk-panel-title">Bill Pay</h1>

<?php if ( $billpay != 1 ) : ?>
	<p class="uk-text-danger"><i class="uk-icon uk-icon-exclamation-circle"></i> <?php echo $message; ?></p>
<?php else : ?>
	<p><?php echo $message; ?></p>
<?php endif; ?>

<p>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $billpay_link; ?>" target="_BLANK">Test Link</a>
	<a class="uk-button uk-button-primary uk-button-mini" href="<?php echo $links['billpay']; ?>">Edit Link</a>
</p>