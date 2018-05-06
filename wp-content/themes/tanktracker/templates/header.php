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
        $tank_id = 1;
    } else {
        $tank_id = $_GET['tank_id'];
    }
 ?>
	
	<div class="menu-bar">
		<div class="menu-button">Menu</div>
	</div>
	<div class="main-menu">
		<a name="" href="/tanks" class="">My Tanks</a>
		<a name="tanks" href="/overview<?php echo '?tank_id='.$tank_id; ?>" class="overview">Overview</a>
			<a name="parameters" href="/parameters<?php echo '?tank_id='.$tank_id; ?>" class="parameters">Parameters</a>
			<a name="stock" href="/stock<?php echo '?tank_id='.$tank_id; ?>" class="stock">Stock</a>
			<a name="equipment" href="/equipment<?php echo '?tank_id='.$tank_id; ?>" class="equipment">Equipment</a>	
		<a name="" href="/" class="">Community</a>	
		<br>
		<br>
		<a name="myaccount" href="/my-account" class="myaccount">My Account</a>
		<a name="" href="/" class="">Linked Accounts</a>
		<?php  echo '<a href="'.wp_logout_url('$index.php').'">Logout</a>'; ?>
		
	</div>

	

<section class="wrap">
<?php } ?>
<div class="global-error"></div>
<div class="overlay"></div>


