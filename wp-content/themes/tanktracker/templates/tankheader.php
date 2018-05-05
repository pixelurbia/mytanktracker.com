<?php 
	$user = wp_get_current_user();
	$curuser = $user->ID;
	if( !isset( $_GET['tank_id'] )){
		$tank_id = 1;
	} else {
		$tank_id = $_GET['tank_id'];
	}

 ?>

<div class="tank_header">
			<h2><?php echo  $tanks[0]->tank_name ?></h2>
			<p>
			<?php
				if ($tanks[0]->tank_volume) {
					echo  '<span>Volume: '.$tanks[0]->tank_volume.' Gallons </span>';
				} 
				if ($tanks[0]->tank_dimensions){
					echo '<span>Dimensions: '.$tanks[0]->tank_dimensions.'</span>';
				}
				if ($tanks[0]->tank_model){
					echo '<span>Model: '.$tanks[0]->tank_model.'</span>';
				}
				if ($tanks[0]->tank_make){
					echo '<span>Make: '.$tanks[0]->tank_make.'</span>';	
				}
			?> 
</p>
</div>