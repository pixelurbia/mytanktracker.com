<section class="widget quick-guides">
	<div class="heading">
		<h4>Before you plan</h4>
	</div>
<?php $query =  new WP_Query(array(
						'p' => 179,
					) ); 
						while ( $query->have_posts() ) : $query->the_post();   ?> 
							<?php 
						the_content();
							 ?>
					<?php endwhile; ?>
</section>
<section class="widget faqs">
	<div class="heading">
		<h4><a href="/faqs">View FAQs &#187</a></h4>
		</div>
		
</section>