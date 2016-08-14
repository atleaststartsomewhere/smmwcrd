<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ( !$items->success ) : ?>
	<div class="uk-grid uk-text-primary">
		<div class="uk-width-1-1">
			There are no items for <?php echo $monthName.' of '.$year; ?>. Try adding a <span class="uk-text-bold">New Event</span> below.
		</div>
	</div>
<?php else : ?>
		<div class="uk-grid uk-grid-collapse uk-grid-divider">
			<div class="uk-width-3-6 uk-text-primary uk-text-bold">Event</div>
			<div class="uk-width-2-6 uk-text-primary uk-text-bold">Date</div>
			<div class="uk-width-1-6 uk-text-primary uk-text-bold uk-text-right"><span class="uk-hidden-small">Mark for </span>Delete</div>
		</div>
		<hr class="uk-grid-divider">
	<?php foreach ( $items->data as $count => $i ) : ?>
		<div class="uk-grid uk-grid-collapse uk-grid-divider">
			<div class="uk-width-3-6" title="Change the event for item #<?php echo $count+1; ?>">
				<label class="uk-text-bold uk-hidden-small"><?php echo $count+1; ?>.</label>
				<select name="eventType[<?php echo $i->id; ?>]">
					<?php foreach ( $types->data as $t ) : ?>
						<option <?php if ( $t->id == $i->type ) echo 'selected="selected"'; ?> value="<?php echo $t->id; ?>"><?php echo $t->text; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="uk-width-2-6">
				<div class="uk-form-icon" title="Change the date for item #<?php echo $count+1; ?>">
					<i class="uk-icon-calendar"></i>
					<input readonly name="eventDate[<?php echo $i->id; ?>]" type="text" data-uk-datepicker="{format:'MM/DD'}" value="<?php echo (date('m/d', strtotime($i->date)));?>">
				</div>
			</div>
			<div class="uk-width-1-6">
				<label class="uk-button uk-button-danger uk-align-right uk-hidden-small" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $i->id; ?>">
					<i class="uk-icon-trash-o"></i>
				</label>
				<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $i->id; ?>" name="remove[<?php echo $i->id; ?>]" type="checkbox">
			</div>
		</div>
	<?php endforeach; ?>

<?php endif; ?>


	<hr class="uk-grid-divider">

	<div class="uk-grid uk-grid-collapse">
		<div class="uk-width-1-6" title="Add a new item">
			<label class="uk-text-primary">New Event</label>
		</div>
		<div class="uk-width-2-6">
			<select name="newEvent_type">
				<option value="">-- Choose Event --</option>
				<?php foreach ( $types->data as $t ) : ?>
					<option value="<?php echo $t->id; ?>"><?php echo $t->text; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="uk-width-2-6">
			<div class="uk-form-icon" title="Add a date for the new item">
				<i class="uk-icon-calendar"></i>
				<input readonly name="newEvent_date" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" value="<?php echo $month.'/01/'.$year; ?>">
			</div>
		</div>
	</div>

	<div class="uk-grid">
		<div class="uk-width-1-1">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>