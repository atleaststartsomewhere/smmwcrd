<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */	//echo "<pre>";var_dump($cal_next);echo "</pre>";return;
?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['notices']; ?>">Notices</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['calendar']; ?>" class="active">Calendar</a></li>
		</ul>
	</div>
	<div class="Page__content Calendars">
		<div class="Calendar Calendar--current">
			<div class="Calendar__header">
				<h2><?php echo $date_current; ?></h2>
			</div>
			<ul class="Calendar__list">
				<?php foreach ( $cal_current as $currentEvent ) : ?>
					<li class="Calendar__list__item"><span class="Calendar__list__item__date"><?php echo date('jS', strtotime($currentEvent->date)); ?></span><span class="Calendar__list__item__title"><?php echo $currentEvent->text; ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="Calendar Calendar--next">
			<div class="Calendar__header">
				<h2><?php echo $date_next; ?></h2>
			</div>
			<ul class="Calendar__list">
				<?php foreach ( $cal_next as $nextEvent ) : ?>
					<li class="Calendar__list__item"><span class="Calendar__list__item__date"><?php echo date('jS', strtotime($nextEvent->date)); ?></span><span class="Calendar__list__item__title"><?php echo $nextEvent->text; ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>