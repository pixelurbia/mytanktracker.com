<?php  
/* 
Template Name: Login Page
*/
 
?>

<?php get_template_part('templates/header'); 
 if (!is_user_logged_in()){
      	?>


	<section class="frame">
				<div class="frost">
<div class="login-form">
		<div class="logo"></div>
		<!-- 	<div class="tank-menu">
					<a  href="/register/">Register</a>|
					<a class="login-header">Login</a>'			
			</div> -->
	<?php	
   $args = array(
        'redirect' => site_url('/tanks'),
        'remember' => true
    );
    wp_login_form( $args );
	echo '<div class="form-links"><a href="/register/">Need an Account? Register Today!</a> ';
	echo '<a href="/password-reset//">Forgot Your Password?</a></div>';

	?>
		</div>
		</div>
	<div class="copy">
	<a href="https://pixelurbia.com">&#169; Copyright Pixelurbia LLC. 2018</a>
</div>
		</section>
<video autoplay muted loop id="myVideo">
  <source src="/wp-content/themes/tanktracker/images/fishbg.mp4" type="video/mp4">
</video>
<?php


} else {

	// wp_redirect('http://localhost:8888/overview/');

};

    ?>

