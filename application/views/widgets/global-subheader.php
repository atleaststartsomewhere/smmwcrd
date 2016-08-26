<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
?>
<header class="PageHeader"><a href="<?php echo $links['home']; ?>"> <img src="<?php echo $img_root;?>logo_medium.png" class="PageHeader__logo"></a><a href="#" class="NavToggle icon-menu"></a>
	<nav class="PageNav"><i class="icon-cancel CloseNav"></i>
		<ul class="PageNavigation">
			<li class="PageNavigation__item"><a href="<?php echo $links['notices']; ?>" class="PageNavigation__link submenu__heading">Calendar & Notices</a>
				<ul class="Navigation__submenu Page__submenu">
					<li class="Navigation__submenu__item"><a href="<?php echo $links['notices']; ?>" class="Navigation__submenu__link">Notices</a></li>
					<li class="Navigation__submenu__item"><a href="<?php echo $links['calendar']; ?>" class="Navigation__submenu__link">Calendar</a></li>
				</ul>
			</li>
			<li class="PageNavigation__item"><a href="<?php echo $links['meetings']; ?>" class="PageNavigation__link submenu__heading">Board Meetings</a>
				<ul class="Navigation__submenu Page__submenu">
					<li class="Navigation__submenu__item"><a href="<?php echo $links['meetings']; ?>" class="Navigation__submenu__link">Meetings</a></li>
					<li class="Navigation__submenu__item"><a href="<?php echo $links['board']; ?>" class="Navigation__submenu__link">Board Members</a></li>
					<li class="Navigation__submenu__item"><a href="<?php echo $links['staff']; ?>" class="Navigation__submenu__link">Staff</a></li>
				</ul>
			</li>
			<li class="PageNavigation__item"><a href="<?php echo $links['resources']; ?>" class="PageNavigation__link submenu__heading">Resources</a>
				<ul class="Navigation__submenu Page__submenu">
					<?php foreach ( $resource_categories as $cat ) : ?>
						<li class="Navigation__submenu__item"><a href="<?php echo $links['resources'].'/'.$cat->url_friendly; ?>" class="Navigation__submenu__link"><?php echo $cat->category_name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="PageNavigation__item"><a href="<?php echo $links['contact']; ?>" class="PageNavigation__link">Contact</a></li>
			<li class="PageNavigation__item"><a target="_blank" href="<?php echo $links['paybill']; ?>" class="Button Button--primary Button--paymybill">Pay My Bill</a></li>
		</ul>
	</nav>
</header>