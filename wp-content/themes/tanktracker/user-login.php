<?php  
/* 
Template Name: Login Page
*/
 
?>

<?php get_template_part('templates/header'); 
 if (!is_user_logged_in()){
      	?>


<section class="frame">
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
	echo '<div><a class="btn" href="/register/">Register your account</a>';
	echo '<a class="btn" href="/pass-reset/">Forgot Your Password?</a></div>';
	echo '<div class="copy"><a href="https://pixelurbia.com">&#169; Copyright Pixelurbia LLC. 2018</a></div>';
	?>
		</div>

		
	
</section>
<div class="pattern"></div>
<video autoplay muted loop id="myVideo">
  <source src="/wp-content/themes/tanktracker/images/fishbg.mp4" type="video/mp4">
</video>
<?php


} else {

	// wp_redirect('http://localhost:8888/overview/');

};

    ?>

