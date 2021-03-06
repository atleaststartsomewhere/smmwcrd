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
				<img src="<?php echo $img_root; ?>logo_large.png" class="Hero__logo">
				<nav>
					<ul class="Navigation">
						<li class="Navigation__item"><a href="<?php echo $links['notices']; ?>" class="Navigation__link submenu__heading">Calendar &amp; Notices</a>
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
							<ul class="Navigation__submenu Page__submenu">
								<li class="Navigation__submenu__item">
									<a href="<?php echo $links['featured']; ?>" class="Navigation__submenu__link">Featured</a>
								</li>
								<li class="Navigation__submenu__item">
									<a href="<?php echo $links['resources']; ?>" class="Navigation__submenu__link">All Resources</a>
								</li>
								<li class="Navigation__submenu__item">
									<a href="<?php echo $links['faq']; ?>" class="Navigation__submenu__link">FAQ</a>
								</li>
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