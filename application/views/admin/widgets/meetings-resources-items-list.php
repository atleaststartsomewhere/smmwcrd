<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//var_dump($meetings);return;
?>


<?php foreach ( $meetings as $meeting ) : ?>
	<div class="uk-grid">
		<div class="uk-width-1-10">
			<label class="uk-text-bold"><?php echo $meeting->index; ?>.</label>
		</div>
		<div class="uk-width-2-10">
			<span class="uk-text-primary uk-text-large"><?php echo date('F jS', strtotime($meeting->date)); ?></span>
			<br/>
			<span class="uk-text-muted uk-text-small"><?php echo $meeting->text; ?></span>
		</div>
		<div class="uk-width-1-10">
			<span class=""><?php echo date('Y', strtotime($meeting->date)); ?></span>
		</div>
		<div class="uk-width-3-10">
			<div class="uk-form-file">
				<label class="uk-text-bold">Agenda:</label>
				<input name="file_agenda_<?php echo $meeting->id; ?>" type="file">
			</div>
			<?php if ( !isset($meeting->agenda_path) || is_null($meeting->agenda_path)) : ?>
				<span class="uk-text-small">No File Uploaded</span>
			<?php else : ?>
				<span class="uk-text-small">Currently: </span>
				<a target="_blank" href="<?php echo ($resource_root.$meeting->agenda_path); ?>" class="uk-button uk-button-link"><?php echo $meeting->agenda_path; ?></a>
				<br />
				<label class="uk-text-link uk-text-small uk-text-danger" for="remove-agenda-<?php echo $meeting->id;?>"><i class="uk-icon uk-icon-trash"></i> Remove</label>
				<input id="remove-agenda-<?php echo $meeting->id;?>" name="remove_agenda[<?php echo $meeting->id;?>]" type="checkbox">
			<?php endif; ?>
		</div>
		<div class="uk-width-3-10">
			<div class="uk-form-file">
				<label class="uk-text-bold">Minutes:</label>
				<input name="file_minutes_<?php echo $meeting->id; ?>" type="file">
			</div>
			<?php if ( !isset($meeting->minutes_path) || is_null($meeting->minutes_path)) : ?>
				<span class="uk-text-small">No File Uploaded</span>
			<?php else : ?>
				<span class="uk-text-small">Currently: </span>
				<a target="_blank" href="<?php echo ($resource_root.$meeting->minutes_path) ?>" class="uk-button uk-button-link"><?php echo $meeting->minutes_path; ?></a>
				<br />
				<label class="uk-text-link uk-text-small uk-text-danger" for="remove-minutes-<?php echo $meeting->id;?>"><i class="uk-icon uk-icon-trash"></i> Remove</label>
				<input id="remove-minutes-<?php echo $meeting->id;?>" name="remove_minutes[<?php echo $meeting->id;?>]" type="checkbox">
			<?php endif; ?>
			<input type="hidden" name="ids[<?php echo $meeting->id; ?>]" value="<?php echo $meeting->id; ?>" >
		</div>
	</div>
<?php endforeach; ?>