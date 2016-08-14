<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>


<?php foreach ( $members as $member ) : ?>

	<h3 class="uk-accordion-title"><?php echo $member->name; ?> - <?php echo $member->title; ?></h3>
	
	<div class="uk-accordion-content">
		<div class="uk-grid">
			<div class="uk-width-1-2">
				<h3>Name:</h3>
			</div>
			<div class="uk-width-1-2">
				<h3>Title:</h3>
			</div>
			<div class="uk-width-1-2">
				<input type="text" placeholder="" class="uk-width-1-1" value="<?php echo $member->name; ?>">
			</div>
			<div class="uk-width-1-2">
				<input type="text" placeholder="" class="uk-width-1-1" value="<?php echo $member->title; ?>">
			</div>
		</div>
	</div>

<?php endforeach; ?>
