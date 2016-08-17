<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	/* DEBUG: */ //echo "<pre>"; print_r($faqs); echo "</pre>";return;
?>
<section class="Page">
	<div class="Page__subNav">
		<ul class="Page__subNav__list">
			<li class="Page__subNav__list__item"><a href="<?php echo $links['resources']; ?>">Resources</a></li>
			<li class="Page__subNav__list__item"><a href="<?php echo $links['faq']; ?>" class="active">FAQ</a></li>
		</ul>
	</div>
	<div class="Page__content">
		<ul class="Page__content__list">
			<li class="Page__content__list__item QuestionAnswer">
				<?php foreach ( $faqs as $faq ) : ?>
					<h3 class="QuestionAnswer__question"><?php echo $faq->question; ?></h3>
					<p class="QuestionAnswer__answer">
						<?php echo $faq->answer; ?>
					</p>
				<?php endforeach; ?>
			</li>
		</ul>
	</div>
</section>
