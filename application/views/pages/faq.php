<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>"; print_r($faqs); echo "</pre>";return;
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
						<li class="PageNavigation__item"><a href="<?php echo $links['paybill']; ?>" class="Button Button--primary">Pay My Bill</a></li>
					</ul>
				</nav>
			</header>
			<section class="Page">
				<div class="Page__subNav">
					<ul class="Page__subNav__list">
						<li class="Page__subNav__list__item"><a href="<?php echo $links['resources']; ?>">Resources</a></li>
						<li class="Page__subNav__list__item"><a href="<?php echo $links['faq']; ?>" class="active">FAQ</a></li>
					</ul>
				</div>
				<div class="Page__content">
					<ul class="Page__content__list">
						<li class="Page__content__list__item QuestionAnswer">
							<?php foreach ( $faqs as $faq ) : ?>
								<h3 class="QuestionAnswer__question"><?php echo $faq->question; ?></h3>
								<p class="QuestionAnswer__answer"><?php echo $faq->answer; ?></p>
							<?php endforeach; ?>
						</li>
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
						<h3 class="QuickDocs__heading">Featured Resources</h3>
						<ul class="QuickDocs__list">
							<li class="QuickDocs__list__item"><a href="#"><i class="icon-doc-text"></i><span>Quick Doc 1</span></a></li>
							<li class="QuickDocs__list__item"><a href="#"><i class="icon-doc-text"></i><span>Quick Doc 2</span></a></li>
							<li class="QuickDocs__list__item"><a href="#"><i class="icon-doc-text"></i><span>Quick Doc 3</span></a></li>
						</ul>
					</div>
				</div>
			</footer>
		</main>
		<!-- SCRIPTS-->
		<script src="<?php echo $js_root; ?>scripts.min.js"></script>
	</body>
</html>