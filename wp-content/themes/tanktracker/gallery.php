<?php
/*
Template Name: gallery
*/
?>

<?php get_template_part('templates/header'); ?>



<?php 
//get values
$tank_id = $_GET['tank_id'];
$stock_id = $_GET['stock_id'];
$user_id = $_GET['user_id'];

//obj initi
$tanks = new Tanks();

//define values
$tank = $tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;	
$user = $tanks->user_info();
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
	<section class="full recent_params">
		
		<?php 
			$tanks->full_gallery($tank_id,50);
		?>
	</section>
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
<?php get_template_part('templates/feed-scripts'); ?>