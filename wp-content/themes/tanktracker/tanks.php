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
										<h2><?php echo  $tank->tank_name ?>
											<i class="fas edit-tank-stock fa-edit"></i>
										</h2>

           										
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
								<div class="tank_actions">
									<a  href="/overview/?tank_id=<?php echo $tank->tank_id ?>"><i class="fas fa-3x fa-list-alt"></i></a>
									<a  href="/parameters/?tank_id=<?php echo $tank->tank_id ?>"><i class="fas fa-3x fa-flask"></i></a>
									<a  href="/stock/?tank_id=<?php echo $tank->tank_id ?>"><i class="fas fa-3x fa-tint"></i></a>
									<a  href="/equipment/?tank_id=<?php echo $tank->tank_id ?>"><i class="fas fa-3x fa-bolt"></i></a>
								</div>
								</div>
								

										<div class="shader"></div>
										<div class="tank_img" style="background:url(<?php echo $tank->tank_image ?>)"></div>
									</div>
							<?php } ?>
							<div class="a_tank select_tank">
									<div class="content">
										<h2>Add tank</h2>
										<i class="fas fa-3x fa-plus add-tank"></i>
									</div>
									</div>

<div class="form-contain add-tank-form">
		<script type="text/javascript">
		//img preview
		var loadFile = function(event) {
    		var output = document.getElementById('tank-output');
    		output.src = URL.createObjectURL(event.target.files[0]);
  		};
	</script>
    <a class="add-tank param-close"><i class="fas fa-times"></i></a>
	<form id="tank-form">
				<input type="text" name="tankname"  placeholder="Tank Name" class="form-control tank-name" />
				<select type="text" name="tanktype"  placeholder="Tank Type" class="form-control">
					<option>Tank Type</option>
					<option>Fresh Water</option>
					<option>Salt Water</option>
				</select>
				<input type="text" name="volume"  placeholder="Tank Total Volume" class="form-control" />
				<input type="text" name="dimensions"  placeholder="Tank Dimensions" class="form-control" />
				<input type="text" name="model"  placeholder="Tank Model" class="form-control" />
				<input type="text" name="make"  placeholder="Tank Make" class="form-control" />
				<!-- <input id="tank-img" type="file" name="file_upload"> -->
				<img id="tank-output">
				<label class="btn tank-img" for="tank-img">Upload a tank photo</label>
				<input type="file" name="file_upload" id="tank-img" class="inputfile" accept="image/*" onchange="loadFile(event)" />
				<?php wp_nonce_field('ajax_form_nonce_tank','ajax_form_nonce_tank', true, true ); ?>
				<input type="hidden" name="action" value="add_tank">
				<input type="submit" class="btn" value="Add Your Tank" />
				
			</form>
</div>


</section>

 

<?php get_template_part('templates/footer'); ?>
