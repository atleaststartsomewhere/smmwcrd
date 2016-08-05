<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $title;?></title>
<?php /* META */ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php /* CSS */ ?>	
	<?php foreach ( $css as $cssInc ) : ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $cssInc;?>" />
	<?php endforeach; ?>
</head>

<body>