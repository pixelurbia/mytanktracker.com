<?php  
/* 
Template Name: register Page
*/
 
?>


<?php get_template_part('templates/header'); 
 $id = uniqid();
      	?>


	<section class="frame">
				<div class="frost">
	<div class="reg-form"">
		<div class="step step-one"">
		<div class="logo"></div>
				<form id="regi-form">
					<input type="text" name="username" value="" placeholder="Username" class="form-control" />
					<input type="email" name="email"  value="" placeholder="Email" class="form-control" />
					<input type="password" name="pass" value="" placeholder="Password" class="form-control" />
					<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
					<input type="hidden" name="action" value="register_user">
					<input type="submit" class="btn" value="Register Your Account" />
				</form>
		</div>
		<div class="step step-two">
			<form id="tank-form">
			
			<h3>Welcome to the #fishfam!</h3> <br> <p>Tell everyone a bit about your tank.</p>
				<input type="text" name="tankname" value="" placeholder="Tank Name" class="form-control" />
				<select type="text" name="tanktype" value="" placeholder="Tank Type" class="form-control">
					<option>Tank Type</option>
					<option>Fresh Water</option>
					<option>Salt Water</option>
				</select>
				<input type="text" name="volume" value="" placeholder="Tank Total Volume" class="form-control" />
				<input type="text" name="dimensions" value="" placeholder="Tank Dimensions" class="form-control" />
				<input type="text" name="model" value="" placeholder="Tank Model" class="form-control" />
				<input type="text" name="make" value="" placeholder="Tank Make" class="form-control" />
				<!-- <input id="tank-img" type="file" name="file_upload"> -->
				<label class="btn tank-img" for="tank-img">Upload a tank photo</label>
				<input type="file" name="file_upload" id="tank-img" class="inputfile" />
				
				<?php wp_nonce_field('ajax_form_nonce_tank','ajax_form_nonce_tank', true, true ); ?>
				<input type="hidden" name="action" value="add_tank">
				<input type="submit" class="btn" value="Add Your First Tank" />
			</form>
		</div>
	</div>
		</div>
		</section>


<?php get_template_part('templates/footer'); ?>

