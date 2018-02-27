<?php  
/* 
Template Name: Login Page
*/
 
?>

<?php get_template_part('templates/header'); ?>
 
<section class="full">
	<section class="frame">
		<div class="buffer-50"></div>
		<div class="reg-form">
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
		<div class="reg-form">
			<p>Tell us a bit about your tank.</p>
			<?php 
			$id = uniqid();

			 ?>
			<form id="ajax-form">
				<input type="text" name="tankname" value="" placeholder="Tank Name" class="form-control" />
				<?php wp_nonce_field('ajax_form_nonce','ajax_form_nonce', true, true ); ?>
				<input type="hidden" name="action" value="add_tank">
				<input type="submit" class="btn" value="Add Your First Tank" />
			</form>
		</div>
	</section>
</section>


<?php get_template_part('templates/footer'); ?>