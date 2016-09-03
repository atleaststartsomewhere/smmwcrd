<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>";var_dump($notices);echo "</pre>";return;
?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['notices']; ?>" class="active">Notices</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['calendar']; ?>">Calendar</a></li>
		</ul>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">
			<?php if ( isset($notices) && !empty($notices) ) : ?>
				<?php foreach ( $notices as $notice ) : ?>
					<?php // Setup for easy echoing
						$date = date('F jS, Y', strtotime($notice->notice_date));
						if ( isset($notice->resource_id) ) {
							$a = ($notice->r_is_link) ? $notice->r_path : $user_res_root.$notice->r_path;
							$i = ($notice->r_is_link) ? 'icon-link-ext' : 'icon-doc-text'; 
						}
					?>
					<?php // If there is a body, but no link ?>	
					<?php if ( isset($notice->body_text) && !empty($notice->body_text) && !isset($notice->resource_id) ) : ?>
						<li class="Page__content__list__item Notice__withBody">
							<div class="Notice__header">
								<span class="Notice__date"><?php echo $notice->heading_text; ?></span>
								<h2 class="Notice__heading"><?php echo $date; ?></h2>
							</div>
							<div class="Notice__body">
								<p class="Notice__content"><?php echo (nl2br($notice->body_text)); ?></p>
							</div>
						</li>
					<?php // If there is a body, and a link ?>
					<?php elseif ( isset($notice->body_text) && !empty($notice->body_text) && isset($notice->resource_id) ) : ?>
						<li class="Page__content__list__item Notice__withBody">
							<div class="Notice__header">
								<span class="Notice__date"><?php echo $notice->heading_text; ?></span>
								<h2 class="Notice__heading"><?php echo $date; ?></h2>
							</div>
							<a href="<?php echo $a; ?>" target="_BLANK" class="Notice__link">
								<p class="Notice__content"><?php echo (nl2br($notice->body_text)); ?></p>
								<i class="<?php echo $i; ?> Notice__icon">   </i>
							</a>
						</li>
					<?php // If there is no body, and a link ?>
					<?php elseif ( (!isset($notice->body_text)||empty($notice->body_text)) && isset($notice->resource_id) ) : ?>
						<li class="Page__content__list__item Notice__withoutBody">
							<div class="Notice__header">
								<span class="Notice__date"><?php echo $notice->heading_text; ?></span>
								<a href="<?php echo $a; ?>" target="_BLANK" class="Notice__link">
									<h2 class="Notice__heading"><?php echo $date; ?></h2>
									<i class="<?php echo $i; ?> Notice__icon">   </i>
								</a>
							</div>
						</li>
					<?php // Case where there is no body or link ?>
					<?php else : ?>
						<li class="Page__content__list__item Notice__withoutBody">
							<div class="Notice__header">
								<span class="Notice__date"><?php echo $date; ?></span>
								<h2 class="Notice__heading"><?php echo $notice->heading_text; ?></h2>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else : ?>
				<li class="Page__content__list__item Notice__withoutBody">
					<div class="Notice__header">
						<span class="Notice__date"><?php echo date('F jS, Y'); ?></span>
						<h2 class="Notice__heading">There are currently no notices to display.  Please check again later.</h2>
					</div>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</section>