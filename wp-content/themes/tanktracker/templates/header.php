<!DOCTYPE HTML>
<html class="no-js" lang="en" >

<head>
	<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href=""/>
	<link rel="icon" type="image/x-icon" href="" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



	<script src="<?php echo get_template_directory_uri(); ?>/js/master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/register-master.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/add-tank.js"></script>

	<script src="<?php echo get_template_directory_uri(); ?>/js/fontawesome-all.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/charts/dist/chart.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/validate/core.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>
<?php 
      if(!is_user_logged_in()) {  
      	 $logged_in = false;
		} else {
		 $logged_in = true;
			 } 
			 if ($logged_in == true){
	
   if( !isset( $_GET['tank_id'] )){
    	
    	$current_user = wp_get_current_user(); 
    	$curuser = $current_user->ID;
        $tank_id = $wpdb->get_var("SELECT id FROM user_tanks WHERE user_id = $curuser ORDER BY created_date limit 1 ");

    } else {
        $tank_id = $_GET['tank_id'];

    }
 ?>
	
	<div class="menu-bar">
		<div class="main-menu">
			<a class="menu-button"><i class="fas fa-bars"></i></a>
			<!-- <a class="menu-button menu-button-open">Menu</a> -->
			<!-- <a class="menu-button menu-button-close">Close</a> -->
			
			<?php smart_menu($tank_id); ?>

				
		</div>

		
		<div class="secondary-menu">
			<a name="" href="/tanks" class="">My Tanks</a>	
			<a name="" href="/" class="">Tank Tracker Community</a>
		
			
			
			<span></span>
			
			<a name="" href="/" class="">My Profile</a>
			<a name="myaccount" href="/my-account" class="myaccount">My Account</a>
			<?php  echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>'; ?>
		
		</div>
	</div>
	

	

<section class="wrap">
<?php }  
		$login = $_GET['login'];
		if (isset( $login ) && $login == 'failed') { 
			echo '<div class="global-error show">The username or password you provided did not match our records.</div>';
		}
			?>
<div class="global-error"></div>
<div class="overlay"></div>


