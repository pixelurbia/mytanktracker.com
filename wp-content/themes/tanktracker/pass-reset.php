<?php  
/* 
Template Name: pass reset
*/
 
?>

<?php get_template_part('templates/header'); ?>

<?php 
$secure_id = $_GET['secure_id'];


 ?>

	<section class="frame">
	<div class="reg-form"">
		<div class="step step-one"">
		<div class="logo"></div>
				<?php 

					if (!$secure_id) {

				 ?>
				<form id="pass-reset-form">
					<input type="email" name="email"  value="" placeholder="Email" class="form-control email email-validate" />
					<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
					<input type="hidden" name="action" value="update_user_pass">
					<div class="btn bad-btn dither">Submit</div>
					<input type="submit" class="btn pass-reset hide" value="Submit" />
				</form>

			<?php } else {

				// $user_id = $wpdb->get_var("SELECT user_id FROM pass_recovery WHERE secure_id = '$secure_id'");
				?>

				<form id="pass-reseting-form">
					<input type="password" name="pass" value="" placeholder="Password" class="form-control pass-1" />
					<input type="password" name="validate-pass" value="" placeholder="Reenter Password" class="form-control pass-2" />
					<?php wp_nonce_field('ajax_pass_reset_nonce','ajax_pass_reset_nonce', true, true ); ?>
					<input type="hidden" name="secure_id" value="<?php echo $secure_id ?>">
					<input type="hidden" name="action" value="pass_reset">
					<div class="btn bad-btn dither">Change your password</div>
					<input type="submit" class="btn pass-reset hide" value="Change your password" />
				</form>

			<?php } ?>
		</div>
		
		<!-- <div class="step step-three"></div> -->
	
		<div class="copy">
		<a href="https://pixelurbia.com">&#169; Copyright Pixelurbia LLC. 2018</a>
		</div>
	</div>
	</section>
<div class="pattern"></div>
<video autoplay muted loop id="myVideo">
  <source src="/wp-content/themes/tanktracker/images/fishbg.mp4" type="video/mp4">
</video>
		




