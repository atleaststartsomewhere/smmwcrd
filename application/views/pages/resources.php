<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>"; print_r($resources); echo "</pre>";return;
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
		<main class="PageMain">
			<header class="PageHeader"><img src="<?php echo $img_root; ?>logo.svg" class="PageHeader__logo"><a href="#" class="NavToggle icon-menu"></a>
				<nav class="PageNav"><i class="icon-cancel CloseNav"></i>
					<ul class="PageNavigation">
						<li class="PageNavigation__item"><a href="<?php echo $links['home']; ?>" class="PageNavigation__link">Home</a></li>
						<li class="PageNavigation__item"><a href="<?php echo $links['meetings']; ?>" class="PageNavigation__link">Board Meetings</a></li>
						<li class="PageNavigation__item"><a href="<?php echo $links['resources']; ?>" class="PageNavigation__link">Resources</a></li>
						<li class="PageNavigation__item"><a href="<?php echo $links['paybill']; ?>" target="_blank" class="Button Button--primary">Pay My Bill</a></li>
					</ul>
				</nav>
			</header>
			<section class="Page">
				<div class="Page__subNav">
					<ul class="Page__subNav__list">
						<li class="Page__subNav__list__item"><a href="<?php echo $links['resources']; ?>" class="active">Resources</a></li>
						<li class="Page__subNav__list__item"><a href="<?php echo $links['faq']; ?>">FAQ</a></li>
					</ul>
					<ul class="Page__subNav__list Categories">
						<?php foreach ( $categories as $category ) : ?>
							<?php // Set Active
								$category->active = (isset($category->class)) ? 'active' : '';
							?>
							<li class="Page__subNav__list__item"><a class="<?php echo $category->active; ?>" href="<?php echo $links['resources'].'/'.$category->url_friendly; ?>"><?php echo $category->category_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<select class="Categories__mobile__nav">
						<?php foreach ( $categories as $category ) : ?>
							<?php // Set Selected
								$category->selected = (isset($category->class)) ? 'selected="selected"' : '';
							?>
							<option <?php echo $category->selected; ?> value="<?php echo $url.'/'.$category->url_friendly; ?>"><?php echo $category->category_name;?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="Page__content">
					<ul class="Page__content__list">
						<?php if ( isset($resources) && count($resources) > 0 ) : ?>
							<?php foreach ( $resources as $resource ) : ?>
								<li class="Page__content__list__item">
									<?php // Detect if link or doc
										$resource->uri = (!$resource->is_link) ? $user_res_root.$resource->path : $resource->path;
										$resource->icon = (!$resource->is_link) ? "icon-doc-text" : "icon-link-ext";
									?>
									<a target="_blank" href="<?php echo $resource->uri; ?>">
										<span class="Page__content__list__item__text"><?php echo $resource->display_name; ?></span>
										<span class="<?php echo $resource->icon; ?> Page__content__list__item__icon"></span>
									</a>
								</li>
							<?php endforeach; ?>
						<?php else : ?>
							<a>
								<li class="Page__content__list__item">
									<span class="Page__content__list__item__text">No resources found for this category</span>
								</li>
							</a>
						<?php endif; ?>
					</ul>
				</div>
			</section>
			<footer class="Footer">
				<div class="Footer__container">
					<div class="Address">
						<div class="Address__phones">
							<h3 class="Address__heading">Phone Numbers</h3><span class="Address__phone-number">(805) 595-2348</span><span class="Address__after-hours">(After hours: use option 4)</span>
						</div>
						<address class="Address__mailing">
							<h3 class="Address__heading">Mailing</h3>P.O. Box 2120<br>Avila Beach, CA 93424-2120
						</address>
						<address class="Address__delivery">
							<h3 class="Address__heading">Delivery</h3>1561 Sparrow St<br>San Luis Obispo, CA 93405
						</address>
					</div>
					<div class="Copyright"><span class="Copyright__text">&copy; 2014-2016</span></div>
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