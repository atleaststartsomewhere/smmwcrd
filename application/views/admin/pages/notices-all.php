<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li><a href="<?php echo $links['notices-entry'];?>"><i class="uk-icon uk-icon-plus"></i> Create</a></li>
		
		<li class="" data-uk-dropdown="{mode:'click'}">
			<a href="">Edit Notice <i class="uk-icon uk-icon-chevron-down"></i></a>
			<div class="uk-dropdown uk-dropdown-small">
				<ul class="uk-nav uk-nav-dropdown">
					<?php if ( empty($notices) ) : ?>
						<li class="uk-disabled">There are no notices to edit.</li>
					<?php else : ?>
						<?php foreach ( $notices as $notice ) : ?>
							<li><a href="<?php echo $links['notices-entry'].'/'.$notice->id;?>"><?php echo $notice->heading_text; ?></a></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</li>
		<li class="uk-active"><a href="<?php echo $links['notices-all'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<?php echo form_open($scripts['scriptnotices'].'/manage', 'class="uk-form uk-form-horizontal"'); ?>

	<div class="uk-grid uk-grid-divider">
		<div class="uk-width-1-1">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<span class="">Click and drag the <i class="uk-icon uk-icon-align-justify uk-icon-button uk-icon-small"></i> icon to re-order your notices.</span>
			</div>

			<?php if ( empty($notices) ) : ?>
				<div class="uk-block">No notices to display. Click <a href="<?php echo $links['notices-entry']; ?>">Here</a> to create one.</div>
			<?php else : ?>
				<div class="uk-sortable" data-uk-sortable="{handleClass:'uk-sortable-handle'}">
					<div class="uk-form-row"></div>
					<hr class="uk-grid-divider">
					<?php foreach ( $notices as $notice ) : ?>
						<div class="uk-form-row">
							<div class="uk-grid uk-grid-condensed uk-grid-divider">
								<div class="uk-width-1-6">
									<i class="uk-icon uk-icon-align-justify uk-icon-button uk-sortable-handle"></i>
								</div>
								<div class="uk-width-3-6">
									<span class="uk-text uk-text-primary uk-text-bold">&quot;<?php echo $notice->heading_text; ?>&quot;</span>
									<br />
									<span class="uk-text uk-text-muted uk-text-small"><?php echo date('F jS, Y', strtotime($notice->notice_date)); ?></span>
								</div>
								<div class="uk-width-1-6 uk-text-center">
									<a href="<?php echo $links['notices-entry'].'/'.$notice->id; ?>">Edit Notice</a>
								</div>
								<div class="uk-width-1-6">
									<label class="uk-button uk-button-danger uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" for="checkbox-<?php echo $notice->id; ?>">
										<i class="uk-icon-trash-o"></i>
									</label>
									<input class="uk-align-right" title="Mark for Deletion" alt="Mark for Deletion" id="checkbox-<?php echo $notice->id; ?>" name="remove[<?php echo $notice->id; ?>]" type="checkbox">
								</div>
							</div>
							<input type="hidden" name="ids[<?php echo $notice->id; ?>]" value="<?php echo $notice->id; ?>">
						<hr class="uk-grid-divider">
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>	

		</div>
	</div>

	<div class="uk-grid">
		<div class="uk-width-1-1">
			<button class="uk-button uk-button-primary uk-align-right">SAVE CHANGES <i class="uk-icon-check-circle-o"></i></button>
		</div>
	</div>
	
	<?php echo form_close(); ?>
</article>