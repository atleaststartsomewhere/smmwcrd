<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>"; print_r($categories); echo "</pre>";return;
?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['resources']; ?>" class="active">Resources</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['faq']; ?>">FAQ</a></li>
		</ul>
		<ul class="Page__subNav__list Categories">
			<?php foreach ( $categories as $category ) : ?>
				<li class="Page__subNav__list__item"><a href="<?php echo $links['resources'].'/'.$category->url_friendly; ?>" class="<?php echo (isset($category->class)?'active':'');?>"><?php echo $category->category_name; ?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="Categories__mobile__nav__container">
			<select class="Categories__mobile__nav">
				<?php foreach ( $categories as $category ) : ?>
					<option value="<?php echo $category->url_friendly; ?>"><?php echo $category->category_name; ?></option>
				<?php endforeach; ?>
			</select><span></span>
		</div>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">
			<?php if ( !isset($resources) || empty($resources) ) : ?>
				<li class="Page__content__list__item">
					<a href="">
						<span class="Page__content__list__item__text">There are no resources to display for this category.</span>
						<span class="Page__content__list__item__icon"></span>
					</a>
				</li>
			<?php else : ?>
				<?php foreach ( $resources as $resource ) : ?>
					<li class="Page__content__list__item">
						<?php // Set Up Anchor and Icon
							$href = ($resource->is_link) ? $resource->path : $user_res_root.$resource->path;
							$icon = ($resource->is_link) ? 'icon-link-ext' : 'icon-doc-text';
						?>
						<a target="_blank" href="<?php echo $href; ?>">
							<span class="Page__content__list__item__text"><?php echo $resource->display_name; ?></span>
							<span class="<?php echo $icon; ?> Page__content__list__item__icon"></span>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</section>