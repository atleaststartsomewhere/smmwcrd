<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php /* JavaScript---*/ ?>
	<?php foreach ( $js as $jsInc ) : ?>
		<script src="<?php echo $jsInc; ?>" language="javascript" type="text/javascript"></script>
	<?php endforeach; ?>
	
</body>

</html>