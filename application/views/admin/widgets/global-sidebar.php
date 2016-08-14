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
		<li class="uk-parent <?php echo ( isset($active['board']) || isset($active['board-member']) || isset($active['board-all']) ? $active_class : '');?>" data-uk-nav>
			<a href="#">Board of Directors</a>
			<ul class="uk-nav-sub">
				<li><a href="<?php echo $links['board-member']; ?>"><i class="uk-icon uk-icon-justify uk-icon-plus"></i> Add Member</a></li>
				<li><a href="<?php echo $links['board-all']; ?>"><i class="uk-icon uk-icon-justify uk-icon-gear"></i> Manage List</a></li>
			</ul>
		</li>
		<li class="uk-parent <?php echo ( isset($active['staff']) || isset($active['staff-member']) || isset($active['staff-all']) ? $active_class : '');?>" data-uk-nav>
			<a href="#">Staff</a>
			<ul class="uk-nav-sub">
				<li><a href="<?php echo $links['staff-member']; ?>"><i class="uk-icon uk-icon-justify uk-icon-plus"></i> Add Member</a></li>
				<li><a href="<?php echo $links['staff-all']; ?>"><i class="uk-icon uk-icon-justify uk-icon-gear"></i> Manage List</a></li>
			</ul>
		</li>
		<li class="uk-nav-header">Resources Page</li>
		<li class=""><a href="<?php echo $links['resources-categories']; ?>">Categories</a></li>
		<li class=""><a href="<?php echo $links['resources']; ?>">Resources</a></li>
		<li class="uk-parent <?php echo ( isset($active['faq']) || isset($active['faq-entry']) || isset($active['faq-all']) ? $active_class : '');?>" data-uk-nav>
			<a href="#">Frequently Asked Questions</a>
			<ul class="uk-nav-sub">
				<li><a href="<?php echo $links['faq-entry']; ?>"><i class="uk-icon uk-icon-justify uk-icon-plus"></i> Create</a></li>
				<li><a href="<?php echo $links['faq-all']; ?>"><i class="uk-icon uk-icon-justify uk-icon-gear"></i> Manage</a></li>
			</ul>
		</li>
		<?php if ( $is_super ) : ?>
			<li class="uk-nav-header">SuperAdmin<li>
			<li class=""><a href="#">Site Configuration</a></li>
		<?php endif; ?>
	</ul>
</div>