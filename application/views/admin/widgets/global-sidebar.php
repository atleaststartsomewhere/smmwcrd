<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	$active_class = "uk-active";

?>
<div class="cma-sidebar" data-uk-sticky="{top:100, boundary: true}">
	<ul class="uk-nav uk-nav-side">
		<li class="uk-nav-header">Settings</li>
		<li class="<?php echo ( isset($active['account']) ? $active_class : '');?>">
			<a href="<?php echo $links['account']; ?>">My Account</a>
		</li>
		<li class="<?php echo ( isset($active['billpay']) ? $active_class : '');?>">
			<a href="<?php echo $links['billpay']; ?>">Bill Pay</a>
		</li>
		<li class="uk-nav-header">Calendar &amp; Notices Page</li>
		<li class="<?php echo ( isset($active['calendar']) ? $active_class : '');?>">
			<a href="<?php echo $links['calendar']; ?>">Calendar</a>
		</li>
		<li class=""><a href="#">Notices</a></li>
		<li class="uk-nav-header">Meetings Page</li>
		<li class="<?php echo ( isset($active['meetings-resources']) ? $active_class : '');?>">
			<a href="<?php echo $links['meetings-resources']; ?>">Agendas &amp; Minutes</a>
		</li>
		<li class=""><a href="#">Board of Directors &amp; Staff</a></li>
		<li class="uk-nav-header">Resources Page</li>
		<li class=""><a href="#">Categories</a></li>
		<li class=""><a href="#">Resources</a></li>
		<li class=""><a href="#">Frequently Asked Questions</a></li>
		<?php if ( $is_super ) : ?>
			<li class="uk-nav-header">SuperAdmin<li>
			<li class=""><a href="#">Site Configuration</a></li>
		<?php endif; ?>
	</ul>
</div>