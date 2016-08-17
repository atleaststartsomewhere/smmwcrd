<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>";var_dump($pagination);echo "</pre>";return;

?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['meetings']; ?>" class="active">Meetings</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['board']; ?>">Board Members</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['staff']; ?>">Staff</a></li>
		</ul>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">
			<?php foreach ( $meetings as $meeting ) : ?>
				<li class="Page__content__list__item Meeting"><span class="Page__content__list__item__date"><?php echo date('F jS, Y', strtotime($meeting->date)); ?></span>
					<div class="Page__content__list__item__column"><span class="Page__content__list__item__text Meeting__text"><?php echo $meeting->text; ?></span>
						<div class="Page__content__list__item__row">
							<?php // set up documents
								$a_disabled = isset($meeting->agenda_path) ? "" : 'disabled="disabled"';
								$m_disabled = isset($meeting->minutes_path) ? "" : 'disabled="disabled"';
								$a_link = isset($meeting->agenda_path) ? $user_res_root.$meeting->agenda_path : '';
								$m_link = isset($meeting->minutes_path) ? $user_res_root.$meeting->minutes_path : '';
								$disable_style = 'style="border-color:lightgrey;color:lightgrey;pointer-events:none;cursor:default;"';
								$a_style = isset($meeting->agenda_path) ? "" : $disable_style;
								$m_style = isset($meeting->minutes_path) ? "" : $disable_style;
							?>
							<a <?php echo $a_disabled; ?> href="<?php echo $a_link; ?>" target="_blank" class="Meeting__button" <?php echo $a_style; ?>>Agenda</a>
							<a <?php echo $m_disabled; ?> href="<?php echo $m_link; ?>" target="_blank" class="Meeting__button" <?php echo $m_style; ?>>Minutes</a>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<ul class="Pagination">
			<li>
				<a href="<?php echo $links['meetings'].'/'.$prev; ?>" class="Pagination__PrevNext">
					<i class="icon-left-open"></i>
				</a>
			</li>
			<?php foreach ( $pagination as $page_num => $page ) : ?>
				<li>
					<a class="<?php echo $page=='current' ? 'current' : '';?>" href="<?php echo $links['meetings'].'/'.$page_num; ?>"><?php echo $page_num; ?></a>
				</li>
			<?php endforeach; ?>
			<li>
				<a href="<?php echo $links['meetings'].'/'.$next; ?>" class="Pagination__PrevNext">
					<i class="icon-right-open"></i>
				</a>
			</li>
		</ul>
	</div>
</section>