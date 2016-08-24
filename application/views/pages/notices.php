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
						<li class="Page__content__list__item Notice__withBody">
							<div class="Notice__header">
								<span class="Notice__date"><?php echo date('F jS, Y', strtotime($notice->notice_date)); ?></span>
								<h2 class="Notice__heading"><?php echo $notice->heading_text; ?></h2>
							</div>
							<div class="Notice__body">
								<p class="Notice__content">
									<?php if ( isset($notice->resource_id) ) : ?>
										<?php /* A HREF Setting */
											$a = ($notice->r_is_link) ? $notice->r_path : $user_res_root.$notice->r_path; 
										?>
										<a target="_blank" href="<?php echo $a; ?>" class="">
											<?php echo $notice->body_text; ?>
											<i class="icon-link-ext Notice__icon">   </i>
										</a>
									<?php else : ?>
										<?php echo $notice->body_text; ?>
									<?php endif; ?></p>
							</div>
						</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</section>