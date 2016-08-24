<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG : */ //echo "<pre>";var_dump($resource_categories);echo"</pre>";return;
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- META-->
		<meta name="description" content="San Miguelito Mutual Water Company">
		<meta name="author" content="Formative Studios">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="og:title" content="San Miguelito Mutual Water Company">
		<!--meta(name='og:image', content='OPENGRAPH:IMAGE')-->
		<meta name="og:description" content="San Miguelito Mutual Water Company">
		<title>San Miguelito Mutual Water Company</title>
		<!-- STYLESHEETS-->
		<link rel="stylesheet" href="https://brick.a.ssl.fastly.net/Open+Sans:300,400,700,900/Muli:300,400,600,700/Raleway:300,400,600,700">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $styles_root; ?>style.min.css">
	</head>
	<body>
		<main>
			<section class="Hero">
				<!--
				.Notice
					h2 Notice
					p Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.
					a(href='#').Notice__close
						i.icon-cancel
				
				--><img src="<?php echo $img_root; ?>logo.svg" class="Hero__logo">
				<nav>
					<ul class="Navigation">
						<li class="Navigation__item"><a href="./notices.html" class="Navigation__link submenu__heading">Calendar & Notices</a>
							<ul class="Navigation__submenu">
								<li class="Navigation__submenu__item"><a href="<?php echo $links['notices'];?>" class="Navigation__submenu__link">Notices</a></li>
								<li class="Navigation__submenu__item"><a href="<?php echo $links['calendar'];?>" class="Navigation__submenu__link">Calendar</a></li>
							</ul>
						</li>
						<li class="Navigation__item"><a href="<?php echo $links['meetings']; ?>" class="Navigation__link submenu__heading">Board Meetings</a>
							<ul class="Navigation__submenu">
								<li class="Navigation__submenu__item"><a href="<?php echo $links['meetings'];?>" class="Navigation__submenu__link">Meetings</a></li>
								<li class="Navigation__submenu__item"><a href="<?php echo $links['board'];?>" class="Navigation__submenu__link">Board Members</a></li>
								<li class="Navigation__submenu__item"><a href="<?php echo $links['staff'];?>" class="Navigation__submenu__link">Staff</a></li>
							</ul>
						</li>
						<li class="Navigation__item"><a href="<?php echo $links['resources'];?>" class="Navigation__link submenu__heading">Resources</a>
							<ul class="Navigation__submenu">
								<?php if ( isset($resource_categories) && !empty($resource_categories) ) : ?>
									<?php foreach ($resource_categories as $cat) : ?>
										<li class="Navigation__submenu__item"><a href="<?php echo $links['resources'].'/'.$cat->url_friendly; ?>" class="Navigation__submenu__link"><?php echo $cat->category_name; ?></a></li>
									<?php endforeach; ?>
								<?php endif; ?>
								<li class="Navigation__submenu__item"><a href="<?php echo $links['faq']; ?>" class="Navigation__submenu__link">FAQ</a></li>
							</ul>
						</li>
						<li class="Navigation__item"><a href="<?php echo $links['contact'];?>" class="Navigation__link">Contact</a></li>
						<li class="Navigation__item"><a href="<?php echo $links['paybill'];?>" target="_blank" class="Button Button--primary">Pay My Bill</a></li>
					</ul>
				</nav>
			</section>
			<footer class="Footer">
				<div class="Footer__container">
					<div class="Copyright"><span class="Copyright__text">&copy; <?php echo date('Y'); ?></span></div>
				</div>
			</footer>
		</main>
		<!-- SCRIPTS-->
		<script src="<?php echo $js_root; ?>scripts.min.js"></script>
	</body>
</html>