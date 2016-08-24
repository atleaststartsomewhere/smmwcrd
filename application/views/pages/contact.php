<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */	//echo "<pre>";var_dump($a);echo "</pre>";return;
?>
<section class="Page">
	<div class="Page__content">
		<div class="Address">
			<div class="Address__phones">
				<h3 class="Address__heading">Phone Numbers</h3><span class="Address__phone-number"><?php echo $phone; ?></span><span class="Address__after-hours"><?php echo $after_hours; ?></span>
			</div>
			<address class="Address__mailing">
				<h3 class="Address__heading">Mailing</h3><?php echo $address_one; ?><br><?php echo $address_two; ?>
			</address>
			<address class="Address__delivery">
				<h3 class="Address__heading">Delivery</h3><?php echo $deliveries_one; ?><br><?php echo $deliveries_two; ?>
			</address>
		</div>
	</div>
</section>