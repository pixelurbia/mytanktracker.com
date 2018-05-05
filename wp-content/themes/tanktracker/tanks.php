<?php
/*
Template Name: Tanks
*/
?>


<?php get_template_part('templates/header'); ?>



	<section class="full-frame">
		<?php 


			global $wpdb;
                $curuser = wp_get_current_user();
                $curuser = $curuser->ID;

				
				$tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $curuser");
					// var_dump($tanks);

                        foreach($tanks as $tank){

                        	?>
                        	<div class="a_tank select_tank">
									<div class="content">
										<h2><?php echo  $tank->tank_name ?></h2>
											<p>
											<?php 
												if ($tank->tank_volume) {
													echo  '<span>Volume: '.$tank->tank_volume.' Gallons </span>';
												} 
												if ($tank->tank_dimensions){
													echo '<span>Dimensions: '.$tank->tank_dimensions.'</span>';
												}
												if ($tank->tank_model){
													echo '<span>Model: '.$tank->tank_model.'</span>';
												}
												if ($tank->tank_make){
													echo '<span>Make: '.$tank->tank_make.'</span>';	
												}
												 ?>
											</p>
									<a  href="/overview/?tank_id=<?php echo $tank->id ?>"><i class="fas fa-3x fa-list-alt"></i></a>
									<a  href="/parameters/?tank_id=<?php echo $tank->id ?>"><i class="fas fa-3x fa-flask"></i></a>
									<a  href="/stock/?tank_id=<?php echo $tank->id ?>"><i class="fas fa-3x fa-tint"></i></a>
									<a  href="/equipment/?tank_id=<?php echo $tank->id ?>"><i class="fas fa-3x fa-bolt"></i></a>
									</div>
								

										<div class="shader"></div>
										<div class="tank_img" style="background:url(<?php echo $tank->tank_image ?>)"></div>
									</div>
							<?php } ?>
							<div class="a_tank select_tank">
									<div class="content">
										<h2>Add tank</h2>
										<i class="fas fa-3x fa-plus"></i>
									</div>
									</div>
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
