<?php  
/* 
Template Name: register Page
*/
 
?>


<?php get_template_part('templates/header'); 
 $id = uniqid();
      	?>

	<script type="text/javascript">
		//img preview
		var loadFile = function(event) {
    		var output = document.getElementById('tank-output');
    		img = URL.createObjectURL(event.target.files[0]);
			$('.page-template-register .frame').css({'background':'url('+img+')'});
  		};
	</script>

	<section class="frame">
				<div class="frost">
	<div class="reg-form"">
		<div class="step step-one"">
		<div class="logo"></div>
				<form id="regi-form">
					<input type="text" name="username" value="" placeholder="Username" class="form-control username regi-validate" />
					<input type="email" name="email"  value="" placeholder="Email" class="form-control email regi-validate" />
					<input type="password" name="pass" value="" placeholder="Password" class="form-control pass-1" />
					<input type="password" name="validate-pass" value="" placeholder="Reenter Password" class="form-control pass-2" />
					<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
					<input type="hidden" name="action" value="register_user">
					<input type="submit" class="btn account-reg" value="Register Your Account" />
				</form>
		</div>
		<div class="step step-two">
			<form id="tank-form">
			<p>Welcome to the #fishfam! <br> Tell everyone a bit about your tank.</p>
				<input type="text" name="tankname" value="" placeholder="Tank Name" class="form-control tank-name" />
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
				<input type="file" name="file_upload" id="tank-img" class="inputfile" accept="image/*" onchange="loadFile(event)" />
				<input type="hidden" class="verfication" name="verfication-username" value="">
				<input type="hidden" name="action" value="add_tank">
				<div class="btn" id="skip-add-tank">Skip</div>
				<input type="submit" class="btn" value="Add Your First Tank" />
				
			</form>
		
		</div>
		<!-- <div class="step step-three"></div> -->
	</div>
		</div>
		</section>


<?php get_template_part('templates/footer'); ?>

