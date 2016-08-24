<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li><a href="<?php echo $links['staff-member'];?>"><i class="uk-icon uk-icon-plus"></i> Add </a></li>
		
		<li class="" data-uk-dropdown="{mode:'click'}">
			<a href="">Edit <i class="uk-icon uk-icon-chevron-down"></i></a>
			<div class="uk-dropdown uk-dropdown-small">
				<ul class="uk-nav uk-nav-dropdown">
					<?php if ( empty($members) ) : ?>
						<li class="uk-disabled">There are no members to edit.</li>
					<?php else : ?>
						<?php foreach ( $members as $member ) : ?>
							<li><a href="<?php echo $links['staff-member'].'/'.$member->id;?>"><?php echo $member->name; ?></a></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</li>
		<li class="uk-active"><a href="<?php echo $links['staff-all'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<?php echo form_open($scripts['scriptstaff'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>

	<div class="uk-grid">
		<div class="uk-width-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<span class="">Click and drag the <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> icon to re-order staff members.</span>
			</div>
			<?php if ( empty($members) ) : ?>
				<span>No Staff Members to display. Click <a href="<?php echo $links['staff-member']; ?>">Here</a> to add one.</span>
			<?php else : ?>
				<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
					<div class="uk-form-row"></div>
					<hr class="uk-grid-divider">
					<?php foreach ( $members as $member ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-3-6">
									<span class="uk-text uk-text-primary uk-text-bold"><?php echo $member->name; ?></span>
									<br />
									<span class="uk-text uk-text-muted uk-text-small"><?php echo $member->title; ?></span>
								</div>
								<div class="uk-width-1-6">
									<a href="<?php echo $links['staff-member'].'/'.$member->id; ?>">Edit Member</a>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $member->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $member->id; ?>" name="remove[<?php echo $member->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $member->id; ?>]" value="<?php echo $member->id; ?>">
						<hr class="uk-grid-divider">
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>	

		</div>
	</div>

	<div class="uk-grid">
		<div class="uk-width-2-3">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>
	
	<?php echo form_close(); ?>
</article>