<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-large-1-2">
			<?php echo form_open($scripts['scriptcalendar'].'/update', array("class" => "uk-form")); ?>
				<legend class="uk-text-primary">Update Month: <span class="uk-text-bold"><?php echo $monthName; ?> <?php echo $year; ?></span></legend>

				<?php echo $calendarView; ?>

				<input type="hidden" name="month" value="<?php echo $month; ?>">
				<input type="hidden" name="year" value="<?php echo $year; ?>">

			<?php echo form_close(); ?>
		</div>
		<div class="uk-width-large-1-2">
			<?php echo form_open($scripts['scriptcalendar'].'/browse', array("class" => "uk-form")); ?>
				<fieldset data-uk-margin>
					<div class="uk-text-primary uk-text-large">Browse Month</div>
					<div class="uk-form-icon">
						<i class="uk-icon-calendar"></i>
						<input readonly name="browse_date" type="text" data-uk-datepicker="{format:'MM/YYYY'}">
					</div>
					<button class="uk-button uk-button-link">GO <i class="uk-icon-arrow-circle-o-right"></i></button>
				</fieldset>

			<?php echo form_close(); ?>
		</div>
</article>

<hr class="uk-article-divider">

<article class="uk-article">
	<?php echo form_open($scripts['scriptcalendar'].'/add', array("class" => "uk-form")); ?>

		<fieldset data-uk-margin>
			<legend class="uk-text-primary">Add Event</legend>
				<div class="uk-grid">
					<div class="uk-width-1-2">
						<div class="uk-grid">
							<div class="uk-width-1-3">
								<select name="add_type">
									<?php foreach ( $eventTypes as $t ) : ?>
										<option value="<?php echo $t->id; ?>"><?php echo $t->text; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="uk-width-1-3 uk-form-icon">
								<i class="uk-icon-calendar"></i>
								<input readonly name="date" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}">
							</div>
							<div class="uk-width-1-3">
								<button class="uk-button uk-button-primary">CREATE <i class="uk-icon-check-circle-o"></i></button>
							</div>
						</div>
					</div>
			</div>
		</fieldset>

	<?php echo form_close(); ?>
</article>