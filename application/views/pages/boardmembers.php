<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//	var_dump($board);return;
?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['meetings']; ?>">Meetings</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['board']; ?>" class="active">Board Members</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['staff']; ?>">Staff</a></li>
		</ul>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">

			<?php foreach ( $board as $member ) : ?>
			<li class="Page__content__list__item StaffMember"><span class="Page__content__list__item__name StaffMember__name"><?php echo $member->name; ?></span><span class="Page__content__list__item__membertitle StaffMember__title"><?php echo $member->title; ?></span>
				<div class="Page__content__list__item__column">
					<p class="Page__content__list__item__text StaffMember__text"><?php echo (nl2br($member->bio)); ?></p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>