<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>";var_dump($notices);echo "</pre>";return;
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
		<link rel="stylesheet" href="<?php echo $styles_root;?>style.min.css">
	</head>
	<body>
		<main class="PageMain">
			<?php echo $header; ?>

			<?php echo $page; ?>
			
			<?php echo $footer; ?>
		</main>
		<!-- SCRIPTS-->
		<script src="<?php echo $js_root; ?>scripts.min.js"></script>
	</body>
</html>