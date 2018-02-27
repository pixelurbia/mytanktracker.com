<?php
/*
Template Name: Overview
*/
?>


<?php get_template_part('templates/header'); ?>



	<section class="frame">
		<?php 

			global $wpdb;
                $curuser = wp_get_current_user();
                $curuser = $curuser->ID;
				if( !isset( $_GET['tank_id'] )){
					$tank_id = 1;
				} else {
					$tank_id = $_GET['tank_id'];
				}
								
				$tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $curuser AND tank_id = $tank_id");
					// var_dump($tanks);

                        foreach($tanks as $tank){
                        	// var_dump($tank);
                        	$output = '';
                        	
                        	$output .= '<div class="a_tank" value="'.$tank->tank_id.'">';
                        	$output .= '<span class="name">'. $tank->tank_name .'</span><br>';
							$output .= '<div class="content">';
							$output .= '<span class="size">Volume: '. $tank->tank_volume .' Gallons </span>';
							$output .= '<span class="type">Dimensions '. $tank->tank_dimensions .'</span>';
							$output .= '<span class="type">Model: '. $tank->tank_model .'</span>';
							$output .= '<span class="type">Make: '. $tank->tank_make .'</span>';
							$output .= '</div>';
							$output .= '<div class="shader"></div>';
							$output .= '<div class="tank_img" style="background:url('.$tank->tank_image.')"></div>';
							$output .= '</div>';
							echo $output;

                        }

                        ?>



</section>

 

<?php get_template_part('templates/footer'); ?>
