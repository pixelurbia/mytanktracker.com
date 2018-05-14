<?php
/*
Template Name: Overview
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
//tank object start
$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->id;
$user = $user_tanks->user_info();
?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>
<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2><?php echo  $tank[0]->tank_name ?></h2>
		<p>
			<?php
				if ($tank[0]->tank_volume) {
					echo  '<span>Volume: '.$tank[0]->tank_volume.' Gallons </span>';
				} 
				if ($tank[0]->tank_dimensions){
					echo '<span>Dimensions: '.$tank[0]->tank_dimensions.'</span>';
				}
				if ($tank[0]->tank_model){
					echo '<span>Model: '.$tank[0]->tank_model.'</span>';
				}
				if ($tank[0]->tank_make){
					echo '<span>Make: '.$tank[0]->tank_make.'</span>';	
				}
			?> 
			</p>
	</div>
<!-- <section class="reminders third"> 
		<a class="add-btn"><i class="fas fa-plus"></i></a>
</section> -->
	<section class="journals third">	
		<h3>Journals</h3>
		<?php  
		$journals = array(
			'author' => $user,
			'post_type' => 'user_journals', 
			'post_status' => 'publish'
		);
		echo '<table>';
		echo '<tr>';
		echo '<th>Journal</th>';
		echo '<th>Posted On</th>';
		echo '</tr>';
		$query = new WP_Query( $journals );
			if ( $query->have_posts() ) : ?>
    			<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
        		
            		<?php 
            		$permlink = get_the_permalink();
            		$excerpt = get_the_excerpt();

            		echo '<tr>';
            		echo '<td>';
            		echo '<a href="'.$permlink.'">'.$excerpt.'</a>';
            		echo '</td>';
            		echo '<td>';
            		the_time('F jS, Y'); 
            		echo '</td>';
            		?>

    			<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
				<?php endif; 
				echo '</table>';
				?>

	</section>
	<section class="timeline third">
			<h3>Recent Parameters</h3>
		<?php 


      	$cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';

    	$params = new Parameters();
    	$tank_id = $tank[0]->id;
        $params->most_recent_param_list($tank_id);

		 ?>
	</section>

										
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
