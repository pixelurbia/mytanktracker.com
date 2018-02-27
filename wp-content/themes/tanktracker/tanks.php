<?php
/*
Template Name: Tanks
*/
?>


<?php get_template_part('templates/header'); ?>



	<section class="frame">
		<?php 


			global $wpdb;
                $curuser = wp_get_current_user();
                $curuser = $curuser->ID;

				
				$tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $curuser");
					// var_dump($tanks);

                        foreach($tanks as $tank){

                        	?>
                        	<div class="a_tank select_tank" value="<?php echo $tank->tank_id ?>">
									<div class="content">
										<ul>
											<li class="name"><h2><?php echo  $tank->tank_name ?></h2></li>
											<li class="size">Volume: <?php echo  $tank->tank_volume ?> Gallons </li>
											<li class="type">Dimensions <?php echo  $tank->tank_dimensions ?></li>
											<li class="type">Model: <?php echo  $tank->tank_model ?></li>
											<li class="type">Make: <?php echo  $tank->tank_make ?></li>
										</ul>
									</div>
										<div class="shader"></div>
										<div class="tank_img" style="background:url(<?php echo $tank->tank_image ?>)"></div>
									</div>
							<?php } ?>
		<section class="hide">
	          		Tank Tracker v 0.1
                        		Add Tank
                        		<form id="ajax-form" method="post">
                        			<input type="hidden" name="action" value="param_form">
                        	 		<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
                        			<input type="text" name="value" placeholder="Salinity">
                        			<input type="submit" name="submit">
                        		</form>
                        		<div id="form-status"></div>
                    		</div>
		</section>


</section>

 

<?php get_template_part('templates/footer'); ?>
