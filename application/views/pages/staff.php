<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['meetings']; ?>">Meetings</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['board']; ?>">Board Members</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['staff']; ?>" class="active">Staff</a></li>
		</ul>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">
			<?php foreach ( $staff as $member ) : ?>
				<li class="Page__content__list__item StaffMember"><span class="Page__content__list__item__name"><?php echo $member->name; ?></span>
					<div class="Page__content__list__item__column">
						<p class="Page__content__list__item__text StaffMember__text"><?php echo $member->title; ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>