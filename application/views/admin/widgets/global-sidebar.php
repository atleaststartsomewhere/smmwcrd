<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	$active_class = "uk-active";

?>
<div class="cma-sidebar uk-visible-large" data-uk-sticky="{top:100, boundary: true}">
	<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
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
		<li class="<?php echo ( isset($active['notices-all']) ? $active_class : '');?>">
			<a href="<?php echo $links['notices-all']; ?>">Notices</a>
		</li>
		<li class="uk-nav-header">Meetings Page</li>
		<li class="<?php echo ( isset($active['meetings-resources']) ? $active_class : '');?>">
			<a href="<?php echo $links['meetings-resources']; ?>">Agendas &amp; Minutes</a>
		</li>
		<li class="<?php echo ( (isset($active['board-all']) || isset($active['board-member'])) ? $active_class : '');?>">
			<a href="<?php echo $links['board-all']; ?>">Board of Directors</a>
		</li>
		<li class="<?php echo ( (isset($active['staff-all']) || isset($active['staff-member'])) ? $active_class : '');?>">
			<a href="<?php echo $links['staff-all']; ?>">Staff</a>
		</li>
		<li class="uk-nav-header">Resources Page</li>
		<li class=""><a href="<?php echo $links['resources-categories']; ?>">Categories</a></li>
		<li class=""><a href="<?php echo $links['resources']; ?>">Resources</a></li>
		<li class="<?php echo ( (isset($active['faq-all']) || isset($active['faq-entry'])) ? $active_class : '');?>">
			<a href="<?php echo $links['faq-all']; ?>">Frequently Asked Questions</a>
		</li>
		<?php if ( $is_super ) : ?>
			<li class="uk-nav-header">SuperAdmin<li>		
			<li class="<?php echo ( isset($active['superadmin']) ? $active_class : '');?>">
				<a href="<?php echo $links['superadmin']; ?>">Site Configurations</a>
			</li>
		<?php endif; ?>
	</ul>
</div>