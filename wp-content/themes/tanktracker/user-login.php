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
        'redirect' => site_url( $_SERVER['REQUEST_URI'].'/tanks' ),
        'remember' => true
    );
    wp_login_form( $args );
	echo '<div class="form-links"><a href="/register/">Need an Account? Register Today!</a> ';
	echo '<a href="/password-reset//">Forgot Your Password?</a></div>';
	?>
		</div>
		</div>
		</section>
<?php


} else {

	// wp_redirect('http://localhost:8888/overview/');

};

    ?>

<?php get_template_part('templates/footer'); ?>