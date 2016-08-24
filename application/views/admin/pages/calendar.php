<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<h3 class="uk-panel-title">Editing <?php echo $dd_select_month.' '.$dd_select_year;?></h3>
				<span class="">Add, Update or Delete items from your calendar.  Use month/year the drop-downs below to <button class="uk-button uk-button-link uk-button-mini">GO <i class="uk-icon-arrow-circle-o-right"></i></button> to a desired month/year.</span>
			</div>
			<div class="uk-form-row"></div>
			<hr class="uk-grid-divider">
			<?php echo form_open($scripts['scriptcalendar'].'/browse', array("class" => "uk-form")); ?>
				<div class="uk-form-row">
					<select class="uk-text-primary uk-text-bold uk-form-large" name="browse_month">
						<?php foreach ( $dd_months as $dd_month ) : ?>
							<option <?php $select = ($dd_select_month == $dd_month) ? 'selected="selected"' : '';?><?php echo $select; ?>value="<?php echo $dd_month;?>"><?php echo $dd_month;?>
						<?php endforeach; ?>
					</select>
					<select class="uk-text-primary uk-text-bold uk-form-large" name="browse_year">
						<?php foreach ( $dd_years as $dd_year ) : ?>
							<option <?php $select = ($dd_select_year == $dd_year) ? 'selected="selected"' : '';?><?php echo $select; ?>value="<?php echo $dd_year;?>"><?php echo $dd_year;?>
						<?php endforeach; ?>
					</select>
					<button class="uk-button uk-button-link">GO <i class="uk-icon-arrow-circle-o-right"></i></button>
				</div>

				<div class="uk-form-row"></div>
			<?php echo form_close(); ?>

			<?php echo form_open($scripts['scriptcalendar'].'/update', array("class" => "uk-form")); ?>

				<?php echo $calendarView; ?>

				<input type="hidden" name="month" value="<?php echo $month; ?>">
				<input type="hidden" name="year" value="<?php echo $year; ?>">

			<?php echo form_close(); ?>
		</div>
</article>