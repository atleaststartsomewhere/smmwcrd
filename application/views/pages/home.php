<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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
		<link rel="stylesheet" href="<?php echo $styles_root; ?>style.min.css">
	</head>
	<body>
		<main>
			<section class="Hero"><img src="<?php echo $img_root; ?>logo.svg" class="Hero__logo">
				<nav>
					<ul class="Navigation">
						<li class="Navigation__item"><a href="<?php echo $links['home'];?>" class="Navigation__link">Home</a></li>
						<li class="Navigation__item"><a href="<?php echo $links['meetings'];?>" class="Navigation__link">Board Meetings</a></li>
						<li class="Navigation__item"><a href="<?php echo $links['resources'];?>" class="Navigation__link">Resources</a></li>
						<li class="Navigation__item"><a href="<?php echo $links['paybill'];?>" target="_blank" class="Button Button--primary">Pay My Bill</a></li>
					</ul>
				</nav>
			</section>
			<section class="Info">
				<div class="Info__left">
					<div class="Info__left__top">
						<div class="Card">
							<div class="Card__heading">
								<h2>Meetings</h2>
							</div>
							<div class="Card__body">
								<p><?php echo $meetingcard_text; ?></p>
							</div>
						</div>
						<div class="Card">
							<div class="Card__heading">
								<h2>Resources</h2>
							</div>
							<div class="Card__body">
								<p><?php echo $resourcecard_text; ?></p>
							</div>
						</div>
						<div class="Card">
							<div class="Card__heading">
								<h2>Pay Your Bill Online</h2>
							</div>
							<div class="Card__body">
								<p><?php echo $paybillcard_text; ?></p>
							</div>
						</div>
					</div>
					<div class="Info__left__bottom">
						<h1 class="Info__heading">Welcome!</h1>
						<p class="Info__body"><?php echo $introductory_text; ?></p>
					</div>
				</div>
				<div class="Info__right">
					<div class="Card Calendar">
						<div class="Card__heading Calendar__heading"><a href="#" class="Calendar__prev">&laquo;</a>
							<div class="Calendar__date">
								<h2 class="Calendar__month"><?php echo $calendar_month; ?></h2><span class="Calendar__year"><?php echo $calendar_year; ?></span>
							</div><a href="#" class="Calendar__next">&raquo;</a>
						</div>
						<div class="Card__body Calendar__body">
							<ul class="Calendar__events">
								<?php foreach ( $calendar_events as $event ) : ?>
									<li class="Event"><span class="Event__date"><?php echo date('jS', strtotime($event->date)); ?></span><span class="Event__title"><?php echo $event->text; ?></span></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</section>
			<footer class="Footer">
				<div class="Footer__container">
					<div class="Address">
						<div class="Address__phones">
							<h3 class="Address__heading">Phone Numbers</h3><span class="Address__phone-number"><?php echo $phone; ?></span><span class="Address__after-hours"><?php echo $after_hours; ?></span>
						</div>
						<address class="Address__mailing">
							<h3 class="Address__heading">Mailing</h3><?php echo $address_one; ?><br><?php echo $address_two; ?>
						</address>
						<address class="Address__delivery">
							<h3 class="Address__heading">Delivery</h3><?php echo $deliveries_one; ?><br><?php echo $deliveries_two; ?>
						</address>
					</div>
					<div class="Copyright"><span class="Copyright__text">&copy; 2014-<?php echo date('Y'); ?></span></div>
					<div class="QuickDocs">
						<?php if ( isset($globalRes) && !empty($globalRes) ) : ?>
							<h3 class="QuickDocs__heading">Featured Resources</h3>
							<ul class="QuickDocs__list">
								<?php foreach ( $globalRes as $resource ) : ?>
									<?php if ( !$resource->is_link ) : ?><?php $resource->path = $user_res_root.$resource->path; ?><?php endif; ?>
									<?php $resource->icon = ($resource->is_link) ? "icon-link-ext" : "icon-doc-text"; ?>
									<li class="QuickDocs__list__item"><a target="_new" href="<?php echo $resource->path; ?>"><i class="<?php echo $resource->icon;?>"></i><span><?php echo $resource->display_name; ?></span></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</footer>
		</main>
		<!-- SCRIPTS-->
		<script src="<?php echo $js_root; ?>scripts.min.js"></script>
	</body>
</html>