<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//echo "<pre>";print_r($resources);echo "</pre>";return;
?>
<div class="uk-width-1-3 uk-container-center">
	<ul class="uk-subnav uk-subnav-pill">
		<li class="<?php echo ( $create ? 'uk-active' : '' ); ?>"><a href="<?php echo $links['staff-member'];?>"><i class="uk-icon uk-icon-plus"></i> Add </a></li>
		
		<li class="<?php echo ( !$create ? 'uk-active' : '' ); ?>" data-uk-dropdown="{mode:'click'}">
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
		<li class=""><a href="<?php echo $links['staff-all'];?>"><i class="uk-icon uk-icon-cog"></i> Manage All</a></li>
	</ul>
</div>
<article class="uk-article">
	<div class="uk-grid">
		<div class="uk-width-1-1">

		<?php echo form_open($scripts['scriptstaff'].'/update', 'class="uk-form uk-form-horizontal"'); ?>			
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<h3 class="uk-panel-title"><?php echo ($create)?"Adding a Staff Member":"Editing Staff Member: <b>&quot;".$name."&quot;</b>";?></h3>
				<span class=""><?php echo ($create?"Enter staff member details.":"Edit staff member details, or delete the staff member.");?></span>
			</div>
			<div class="uk-form-row"></div>
			<hr class="uk-grid-divider">

			<div class="uk-form-row">
				<label class="uk-form-label">Name</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="name" type="text" placeholder="Name" value="<?php echo $name; ?>">
				</div>
			</div>

			<div class="uk-form-row">
				<label class="uk-form-label">Title</label>
				<div class="uk-form-controls">
					<input class="uk-form-width-large" name="title" type="text" placeholder="Title" value="<?php echo $title; ?>">
				</div>
			</div>

			<?php if ( !$create ) : ?>
				<div class="uk-form-row">
					<label class="uk-form-label"></label>
					<div class="uk-form-controls">
						<input id="delete" name="delete" type="checkbox">
						<span class="uk-form-help-inline uk-text-muted">Delete this Staff Member</span>
					</div>
				</div>
			<?php endif; ?>

			<div class="uk-form-row">
				<label class="uk-form-label"></label>
				<div class="uk-form-controls uk-align-right">
					<a href="<?php echo $links['staff-all']; ?>" class="uk-button uk-button-link">Cancel</a>
					<button class="uk-button uk-button-primary">Submit</button>
				</div>
			</div>

			<?php if (isset($id) && !empty($id)) : ?>
				<input type="hidden" name="id" value="<?php echo $id;?>">
			<?php endif; ?>
			
		<?php echo form_close(); ?>

		</div>
	</div>
</article>