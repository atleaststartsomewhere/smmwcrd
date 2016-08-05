<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if ( $fatal ) : ?>
	<div class="uk-grid uk-text-danger">
		<div class="uk-width-1-1">
			<?php foreach ( $fatalMsg as $m ) : ?>
				<?php echo $m.", "; ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
<?php if ( !$items->success ) : ?>
	<div class="uk-grid uk-text-primary">
		<div class="uk-width-1-1">
			No Items to Show
		</div>
	</div>
<?php else : ?>
	<?php foreach ( $items->data as $count => $i ) : ?>
		<div class="uk-grid uk-grid-collapse">
			<div class="uk-width-3-6" title="Change the event for item #<?php echo $count+1; ?>">
				<label class="uk-text-bold"><?php echo $count+1; ?>.</label>
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
				<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $i->id; ?>">
					<i class="uk-icon-trash-o"></i>
				</label>
				<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $i->id; ?>" name="remove[<?php echo $i->id; ?>]" type="checkbox">
			</div>
		</div>
	<?php endforeach; ?>
	<div class="uk-grid">
		<div class="uk-width-1-1">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>
<?php endif; ?>