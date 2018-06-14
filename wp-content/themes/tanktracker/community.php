<?php
/*
Template Name: Community
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 

?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>
<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2>Community Feed</h2>

	</div>
	<section class="feed grid" id="feed">
		  <div class="grid-sizer"></div>
		<?php  




		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$posts = array(
			'author' => $user,
			'posts_per_page' => 5,
			'post_type' => 'user_journals', 
			'post_status' => 'publish',
			'paged' => $paged,
			);

		$query = new WP_Query( $posts );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_excerpt(500);
            		$name = get_the_author_meta('display_name');
            		$time = get_the_time('F jS, Y');
            		echo '<article class="grid-item post">';
            	echo '<p>Posted by '.$name.' on '. $time .'</p>';
            		the_content();
            		echo '<a href="'.$permlink.'">Read More</a>';
            	
            		echo '</article>';
            		?>

    			<?php endwhile; //wp_reset_postdata(); ?>
				<?php endif; ?>
	</section>
<div id="pagination">
<?php 

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $query->max_num_pages
) );

 ?>
</div>
										
	</div>
</section>


<div class="reminder form-contain">
    <a class="close"><i class="fas fa-times"></i></a>
    <form id="ajax-form" class="param-form" method="post">
		<input type="hidden" name="action" value="reminder_form">
		<?php echo '<input type="hidden" name="tank_id" value="'.$tank_id.'">' ?>
		<?php echo '<input type="hidden" name="user_id" value="'.$curuser.'">' ?>
		<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
		<input type="text" name="Reminder" placeholder="Reminder">
		<input type="date" name="Reminder" >
		<input type="submit" name="submit" value="Log">
    </form>
</div>

<?php get_template_part('templates/footer'); ?>

