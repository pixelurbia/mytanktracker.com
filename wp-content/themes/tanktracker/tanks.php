<?php
/*
Template Name: Tanks Selection
*/
?>


<?php get_template_part('templates/header'); ?>

<?php 
//get values
//obj inti
$tanks = new Tanks();
//set values
$curuser = wp_get_current_user();
$curuser = $curuser->ID;

?>
<section class="full-frame">
	<!-- Get all user tanks for tank selection -->
	<?php $tanks->tank_selection(); ?>
	
	<!-- The always present add tank button section -->
	<div class="a_tank select_tank">
	<div class="content">
		<h2>Add tank</h2>
	<a class="add-tank"><i class="fas fa-3x fa-plus"></i></a>
	</div>
	</div>

<!-- Add tank form -->
	<div class="form-contain add-tank-form">
		<script type="text/javascript">
			//img preview script
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
		<input type="file" name="file_upload" id="tank-img" class="inputfile" accept="image/*" onchange="	loadFile(event)" />
					<?php wp_nonce_field('ajax_form_nonce_tank','ajax_form_nonce_tank', true, true ); ?>
			<input type="hidden" name="action" value="add_tank">
			<input type="submit" class="btn" value="Add Your Tank" />		
		</form>
	</div>
</section>


 

<?php get_template_part('templates/footer'); ?>
