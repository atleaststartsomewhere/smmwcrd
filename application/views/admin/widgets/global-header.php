<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if ( !isset($active) )
	$active = '';
?>

<nav class="uk-navbar cma-header uk-contrast">

	<a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>

	<a class="uk-navbar-brand uk-hidden-small" href="<?php echo $links['dashboard'];?>"><img alt="Brand" src="<?php echo site_url();?>assets/img/logo_inline_medium.png" /></a>

	<ul class="uk-navbar-nav uk-hidden-small">
		<li class="<?php if ( $active == 'dashboard' ) : ?>uk-active<?php endif; ?>"><a href="<?php echo $links['dashboard'];?>"><i class="uk-icon-home"></i> Dashboard</a></li>
		<li class=""><a target="_blank" href="<?php echo $links['sitehome'];?>"><i class="uk-icon-eye"></i> View Site</a></li>
	</ul>

	<div class="uk-navbar-flip">
		<ul class="uk-navbar-nav">
			<li class="uk-navbar-content uk-hidden-small"><i class="uk-icon-user"></i> <span class="uk-text-primary">Logged in as <?php echo $username; ?></span></li>
			<li><a href="<?php echo $links['logout'];?>">Logout</a></li>
		</ul>
	</div>

	<div class="uk-navbar-content uk-navbar-center uk-visible-small"><img alt="Brand" src="<?php echo site_url();?>assets/img/logo_inline_small.png" /></div>

</nav>