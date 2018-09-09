<?php
/*
Template Name: Community
*/
?>

<?php get_template_part('templates/header'); ?>


<?php 
//tank object start
$tank_id = $_GET['tank_id'];
$user_tanks = new Tanks();
$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;	
$user = $user_tanks->user_info();
$feed = new Feed();

?>

<div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>

<section class="overview_tank frame" value="<?php echo $tank->tank_id ?>">
	<div class="tank_header">
		<h2>Community</h2>
		<p class="page-subnav">
			<a>Discover / </a>
			<a>Following / </a>
			<a>Favorites</a>
		</p>
		<p class="page-subnav category-filter">
			<?php 

			$cats = $feed->cats(); 
			$currentCat = $_GET['cats'];
			echo '<a ';
	 		if ($currentCat == 0) { 
				 	echo 'class="current"'; 
				 }
			echo 'value="">All / </a>';
			foreach ($cats as $cat){
				 echo '<a ';
				 if ($currentCat == $cat->term_id) { 
				 	echo 'class="current"'; 
				 }
				 echo 'value="'.$cat->term_id.'">'.$cat->name.' / </a>';
			}


			 ?>
		</p>
		
	</div>

	
	<!-- <section class="third recent_params side-bar">
		<h3>People to Follow</h3>
		<?php 
    		$feed = new Feed();
			$feed->get_people_feed();
		 ?>
	</section> -->
	<section class="feed full" id="feed">
		<?php 
		
			$feed->get_main_feed(); 
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

<?php 
get_template_part('templates/footer'); 
get_template_part('templates/feed-scripts'); //start ias instance
?>

